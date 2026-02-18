<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdPostingRequest;
use App\Models\Ad;
use App\Models\AdGalleryImage;
use App\Models\AdHasTag;
use App\Models\AdsCategory;
use App\Models\AdsCondition;
use App\Models\AdsCustomField;
use App\Models\AdsTag;
use App\Models\City;
use App\Models\Country;
use App\Models\SafetyTips;
use App\Models\State;
use App\Models\User;
use App\Notifications\NewAdPosted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class AdController extends Controller
{
    public function addPostPage()
    {
        $categories = AdsCategory::whereNull('parent')
            ->where('status', config('settings.general_status.active'))
            ->with(['child' => function ($q) {
                $q->where('status', config('settings.general_status.active'))
                    ->with(['child' => function ($q2) {
                        $q2->where('status', config('settings.general_status.active'));
                    }]);
            }])
            ->orderBy('id', 'ASC')
            ->get();

        $conditions = AdsCondition::where('status', config('settings.general_status.active'))->get();
        $tags = AdsTag::orderBy('title', 'ASC')->get();

        return view('frontend.pages.ad.post-ad', compact('categories', 'conditions', 'tags'));
    }

    public function storeAd(AdPostingRequest $request)
    {

        // dd($request);
        try {
            DB::beginTransaction();

            $ad = new Ad();
            $ad->user_id = auth()->check() ? auth()->id() : null;

            $ad->title = xss_clean($request->title);
            $ad->description = xss_clean($request->description);
            $ad->category_id = $request->category;
            $ad->city_id = $request->city;
            $ad->condition_id = $request->condition;
            $ad->price = $request->price;
            $ad->is_negotiable = $request->has('negotiable') ? config('settings.general_status.active') : config('settings.general_status.in_active');
            $ad->country_id = $request->country;
            $ad->state_id = $request->state;
            $ad->address = xss_clean($request->address);
            $ad->video_url = $request->video_url;
            $ad->contact_email = xss_clean($request->contact_email);
            $ad->contact_phone = xss_clean($request->phone);
            $ad->contact_is_hide = $request->has('hide_phone_number') ? config('settings.general_status.active') : config('settings.general_status.in_active');
            $ad->is_featured = $request->has('is_featured') ? config('settings.general_status.active') : config('settings.general_status.in_active');
            $ad->status = config('settings.general_status.active');
            $ad->payment_status = config('settings.general_status.active');
            $ad->cost = 0;

            // Handle thumbnail image
            if ($request->hasFile('thumbnail_image')) {
                $ad->thumbnail_image = saveFileInStorage($request->file('thumbnail_image'));
            }

            // Handle custom fields
            $customFieldData = [];
            if ($request->has('custom_field') && is_array($request->custom_field)) {
                foreach ($request->custom_field as $fieldId => $value) {
                    $field = AdsCustomField::find($fieldId);
                    if ($field) {
                        $customFieldData[] = [
                            'flied_id' => $fieldId,
                            'type' => $field->type,
                            'value' => $value,
                        ];
                    }
                }
            }
            $ad->custom_field = json_encode($customFieldData);

            // Handle custom file fields
            foreach ($request->allFiles() as $key => $file) {
                if (str_starts_with($key, 'customfile_')) {
                    $fieldId = str_replace('customfile_', '', $key);
                    $field = AdsCustomField::find($fieldId);
                    if ($field) {
                        $savedPath = saveFileInStorage($file);
                        $customFieldData[] = [
                            'flied_id' => $fieldId,
                            'type' => $field->type,
                            'value' => $savedPath,
                        ];
                    }
                }
            }
            if (count($customFieldData) > 0) {
                $ad->custom_field = json_encode($customFieldData);
            }

            $ad->save();

            // Store tags
            if ($request->has('tags')) {
                foreach ($request->tags as $tag) {
                    $tagInfo = AdsTag::find($tag);
                    if ($tagInfo) {
                        $tagId = $tagInfo->id;
                    } else {
                        $newTag = new AdsTag();
                        $newTag->title = $tag;
                        $newTag->save();
                        $tagId = $newTag->id;
                    }
                    AdHasTag::firstOrCreate(['ad_id' => $ad->id, 'tag_id' => $tagId]);
                }
            }

            // Store gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $savedImage = saveFileInStorage($image);
                    $galleryImage = new AdGalleryImage();
                    $galleryImage->image_path = $savedImage;
                    $galleryImage->ad_id = $ad->id;
                    $galleryImage->save();
                }
            }

            DB::commit();

            // Notify admin users about the new ad
            $admins = User::where('type', config('settings.user_type.admin'))->get();
            Notification::send($admins, new NewAdPosted($ad));

            // Check if it's an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ad posted successfully!',
                    'redirect_url' => route('ad.details.page', ['slug' => $ad->uid]),
                ]);
            }

            return redirect()->route('ad.details.page', ['slug' => $ad->uid])
                ->with('success', 'Ad posted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Check if it's an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to post ad. Please try again.',
                    'error' => $e->getMessage()
                ], 422);
            }

            return back()->withInput()->with('error', 'Failed to post ad. Please try again. ' . $e->getMessage());
        }
    }

    public function getCustomFields(Request $request)
    {
        $customFields = AdsCustomField::with(['options' => function ($q) {
            $q->where('status', config('settings.general_status.active'));
        }])
            ->where('category_id', $request->category_id)
            ->where('status', config('settings.general_status.active'))
            ->get();

        return response()->json($customFields);
    }

    public function getSubcategories(Request $request)
    {
        $parentCategory = null;
        if ($request->parent_id) {
            $parentCategory = AdsCategory::find($request->parent_id);
        }

        $subcategories = AdsCategory::where('parent', $request->parent_id)
            ->where('status', config('settings.general_status.active'))
            ->orderBy('id', 'ASC')
            ->get(['id', 'title', 'parent'])
            ->map(function ($cat) use ($parentCategory) {
                return [
                    'id' => $cat->id,
                    'title' => $cat->title,
                    'parent_id' => $parentCategory ? $parentCategory->parent : null,
                    'parent_title' => $parentCategory ? $parentCategory->title : null,
                    'grandparent_title' => $parentCategory && $parentCategory->parent
                        ? AdsCategory::find($parentCategory->parent)->title ?? null
                        : null
                ];
            });

        return response()->json($subcategories);
    }

    public function adListingPage(Request $request, $category_slug = null)
    {
        // Determine which categories to load (root or children based on cat_id)
        $selectedCategoryId = $request->cat_id ?? null;
        $selectedCategory = null;

        if ($selectedCategoryId) {
            $selectedCategory = AdsCategory::with('parentCategory')
                ->where('status', config('settings.general_status.active'))
                ->find($selectedCategoryId);

            // Check if selected category has children
            $hasChildren = AdsCategory::where('parent', $selectedCategoryId)
                ->where('status', config('settings.general_status.active'))
                ->exists();

            if ($hasChildren) {
                // Load children of selected category
                $categories = AdsCategory::where('parent', $selectedCategoryId)
                    ->where('status', config('settings.general_status.active'))
                    ->orderBy('id', 'ASC')
                    ->get(['id', 'title', 'parent'])
                    ->map(function ($cat) use ($selectedCategory) {
                        $cat->parent_id = $cat->parent;
                        $cat->parent_title = $selectedCategory->title ?? '';
                        return $cat;
                    });
            } else {
                // Load siblings (same parent level)
                $categories = AdsCategory::where('parent', $selectedCategory->parent ?? null)
                    ->where('status', config('settings.general_status.active'))
                    ->orderBy('id', 'ASC')
                    ->get(['id', 'title', 'parent'])
                    ->map(function ($cat) use ($selectedCategory) {
                        $cat->parent_id = $cat->parent;
                        if ($cat->parent && $selectedCategory->parentCategory) {
                            $cat->parent_title = $selectedCategory->parentCategory->title ?? '';
                        }
                        return $cat;
                    });
            }
        } else {
            // Load root categories (no parent)
            $categories = AdsCategory::whereNull('parent')
                ->where('status', config('settings.general_status.active'))
                ->orderBy('id', 'ASC')
                ->get(['id', 'title', 'parent'])
                ->map(function ($cat) {
                    $cat->parent_id = null;
                    $cat->parent_title = null;
                    return $cat;
                });
        }

        // Load conditions for filter
        $conditions = AdsCondition::where('status', config('settings.general_status.active'))
            ->orderBy('id', 'ASC')
            ->get(['id', 'title']);

        // If category slug provided, find the category
        if ($category_slug && !$selectedCategory) {
            $selectedCategory = AdsCategory::where('permalink', $category_slug)
                ->where('status', config('settings.general_status.active'))
                ->first();
        }

        // Build breadcrumb trail for selected category
        $breadcrumbCategory = null;
        $breadcrumbSubcategory = null;
        $breadcrumbChildCategory = null;

        if ($selectedCategory) {
            $breadcrumbTrail = $this->buildCategoryBreadcrumb($selectedCategory);
            $breadcrumbCategory = $breadcrumbTrail['category'] ?? null;
            $breadcrumbSubcategory = $breadcrumbTrail['subcategory'] ?? null;
            $breadcrumbChildCategory = $breadcrumbTrail['child'] ?? null;
        }

        // Get selected location for breadcrumb
        $breadcrumbCountry = null;
        $breadcrumbState = null;
        $breadcrumbCity = null;

        if ($request->has('city') && $request->city != '') {
            $breadcrumbCity = City::find($request->city);
            if ($breadcrumbCity) {
                $breadcrumbState = State::find($breadcrumbCity->state_id);
                if ($breadcrumbState) {
                    $breadcrumbCountry = Country::find($breadcrumbState->country_id);
                }
            }
        } elseif ($request->has('state') && $request->state != '') {
            $breadcrumbState = State::find($request->state);
            if ($breadcrumbState) {
                $breadcrumbCountry = Country::find($breadcrumbState->country_id);
            }
        } elseif ($request->has('country') && $request->country != '') {
            $breadcrumbCountry = Country::find($request->country);
        }

        // Build query for ads
        $query = Ad::with(['categoryInfo', 'cityInfo', 'stateInfo'])
            ->where('status', config('settings.general_status.active'))
            ->where('payment_status', config('settings.general_status.active'));

        // Filter by search query
        if ($request->has('q') && $request->q != '') {
            $searchQuery = $request->q;
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Filter by category (cat_id)
        if ($request->has('cat_id') && $request->cat_id != '') {
            $query->where('category_id', $request->cat_id);
        } elseif ($selectedCategory) {
            $query->where('category_id', $selectedCategory->id);
        }

        // Filter by price range
        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = $request->min_price;
            $maxPrice = $request->max_price;
            if ($minPrice != '' && $maxPrice != '') {
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }
        }

        // Filter by condition
        if ($request->has('condition') && $request->condition != '') {
            $query->where('condition_id', $request->condition);
        }

        // Filter by type (featured/top_listing)
        if ($request->has('type') && $request->type == 'featured') {
            $query->where('is_featured', config('settings.general_status.active'));
        }

        // Filter by location
        if ($request->has('country') && $request->country != '') {
            $query->where('country_id', $request->country);
        }
        if ($request->has('state') && $request->state != '') {
            $query->where('state_id', $request->state);
        }
        if ($request->has('city') && $request->city != '') {
            $query->where('city_id', $request->city);
        }

        // Filter by date posted
        if ($request->has('date_posted') && $request->date_posted != '') {
            $now = now();
            switch ($request->date_posted) {
                case 'today':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', $now->subDay()->toDateString());
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [
                        $now->subWeek()->startOfDay(),
                        now()->endOfDay()
                    ]);
                    break;
            }
        }

        // Sorting
        if ($request->has('sortby') && $request->sortby != '') {
            switch ($request->sortby) {
                case 'latest_listing':
                    $query->orderBy('created_at', 'DESC');
                    break;
                case 'lowest_price':
                    $query->orderBy('price', 'ASC');
                    break;
                case 'highest_price':
                    $query->orderBy('price', 'DESC');
                    break;
                default:
                    $query->orderBy('created_at', 'DESC');
            }
        } else {
            $query->orderBy('created_at', 'DESC');
        }

        // Paginate results
        $ads = $query->paginate(12)->appends($request->except('page'));
        // dd($ads);

        return view('frontend.pages.ad.listing', compact(
            'categories',
            'conditions',
            'category_slug',
            'selectedCategory',
            'selectedCategoryId',
            'ads',
            'breadcrumbCategory',
            'breadcrumbSubcategory',
            'breadcrumbChildCategory',
            'breadcrumbCountry',
            'breadcrumbState',
            'breadcrumbCity'
        ));
    }

    public function adDetailsPage($slug)
    {
        $ad = Ad::with([
            'categoryInfo',
            'cityInfo',
            'stateInfo',
            'countryInfo',
            'galleryImages',
            'tags',
            'condition',
            'userInfo' => function ($q) {
                $q->withCount(['ads' => function ($q2) {
                    $q2->where('status', config('settings.general_status.active'));
                }]);
            },
        ])
            ->where('uid', $slug)
            ->where('status', config('settings.general_status.active'))
            ->firstOrFail();

        // Pre-load custom field models to avoid N+1 in the view
        $customFields = $ad->customFields();
        $fieldModels = collect();
        if ($customFields && count($customFields) > 0) {
            $fieldIds = collect($customFields)->pluck('flied_id')->filter()->values();
            $fieldModels = AdsCustomField::whereIn('id', $fieldIds)->get()->keyBy('id');
        }

        // Get relevant ads from the same category
        $relevantAds = Ad::with(['categoryInfo', 'cityInfo', 'stateInfo'])
            ->where('status', config('settings.general_status.active'))
            ->where('payment_status', config('settings.general_status.active'))
            ->where('id', '!=', $ad->id)
            ->where('category_id', $ad->category_id)
            ->orderBy('created_at', 'DESC')
            ->limit(4)
            ->get();

        // Get active safety tips
        $safetyTips = SafetyTips::with(['tip_translations'])
            ->where('status', config('settings.general_status.active'))
            ->get();

        return view('frontend.pages.ad.details', compact('ad', 'relevantAds', 'customFields', 'fieldModels', 'safetyTips'));
    }

    public function getCountries(Request $request)
    {
        $query = Country::where('status', config('settings.general_status.active'));

        // If search term is provided for Select2
        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $countries = $query->orderBy('name', 'ASC')
            ->limit(50)
            ->get(['id', 'name as text']);

        return response()->json($countries);
    }

    public function getStates(Request $request)
    {
        $query = State::where('status', config('settings.general_status.active'))
            ->where('country_id', $request->country_id);

        // If search term is provided for Select2
        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $states = $query->orderBy('name', 'ASC')
            ->limit(50)
            ->get(['id', 'name as text']);

        return response()->json($states);
    }

    public function getCities(Request $request)
    {
        $query = City::where('status', config('settings.general_status.active'))
            ->where('state_id', $request->state_id);

        // If search term is provided for Select2
        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $cities = $query->orderBy('name', 'ASC')
            ->limit(50)
            ->get(['id', 'name as text']);

        return response()->json($cities);
    }

    public function myListings(Request $request)
    {
        $query = Ad::with(['categoryInfo', 'cityInfo', 'stateInfo'])
            ->where('user_id', auth()->id());

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'active') {
                $query->where('status', config('settings.general_status.active'));
            } elseif ($request->status == 'inactive') {
                $query->where('status', config('settings.general_status.in_active'));
            } elseif ($request->status == 'sold') {
                $query->where('is_sold', config('settings.general_status.active'));
            }
        }

        // Search by title
        if ($request->has('q') && $request->q != '') {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // Sorting
        if ($request->has('sortby') && $request->sortby != '') {
            switch ($request->sortby) {
                case 'oldest':
                    $query->orderBy('created_at', 'ASC');
                    break;
                case 'price_low':
                    $query->orderBy('price', 'ASC');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'DESC');
                    break;
                default:
                    $query->orderBy('created_at', 'DESC');
            }
        } else {
            $query->orderBy('created_at', 'DESC');
        }

        $ads = $query->paginate(12)->appends($request->except('page'));

        // Get counts for tabs
        $totalCount = Ad::where('user_id', auth()->id())->count();
        $activeCount = Ad::where('user_id', auth()->id())
            ->where('status', config('settings.general_status.active'))
            ->count();
        $inactiveCount = Ad::where('user_id', auth()->id())
            ->where('status', config('settings.general_status.in_active'))
            ->count();
        $soldCount = Ad::where('user_id', auth()->id())
            ->where('is_sold', config('settings.general_status.active'))
            ->count();

        return view('frontend.pages.member.my-listings', compact(
            'ads',
            'totalCount',
            'activeCount',
            'inactiveCount',
            'soldCount'
        ));
    }

    public function editAd($uid)
    {
        $ad = Ad::with(['galleryImages', 'tags', 'categoryInfo', 'countryInfo', 'stateInfo', 'cityInfo'])
            ->where('uid', $uid)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $categories = AdsCategory::whereNull('parent')
            ->where('status', config('settings.general_status.active'))
            ->with(['child' => function ($q) {
                $q->where('status', config('settings.general_status.active'))
                    ->with(['child' => function ($q2) {
                        $q2->where('status', config('settings.general_status.active'));
                    }]);
            }])
            ->orderBy('id', 'ASC')
            ->get();

        $conditions = AdsCondition::where('status', config('settings.general_status.active'))->get();
        $tags = AdsTag::orderBy('title', 'ASC')->get();

        // Build category hierarchy for pre-selection
        $categoryHierarchy = $this->buildCategoryHierarchy($ad->category_id);

        // Get selected tag IDs
        $selectedTagIds = $ad->tags->pluck('id')->toArray();

        // Parse custom field values
        $customFieldValues = [];
        if ($ad->custom_field) {
            $customFields = json_decode($ad->custom_field, true);
            if (is_array($customFields)) {
                foreach ($customFields as $field) {
                    if (isset($field['flied_id']) && isset($field['value'])) {
                        $customFieldValues[$field['flied_id']] = $field['value'];
                    }
                }
            }
        }

        return view('frontend.pages.ad.edit-ad', compact('ad', 'categories', 'conditions', 'tags', 'categoryHierarchy', 'selectedTagIds', 'customFieldValues'));
    }

    public function updateAd(Request $request, $uid)
    {
        $ad = Ad::where('uid', $uid)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Validation rules
        $rules = [
            'title' => 'required|string|max:250',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|min:150',
            'country' => 'required|integer|exists:countries,id',
            'state' => 'required|integer|exists:states,id',
            'city' => 'required|integer|exists:cities,id',
            'category' => 'required|integer|exists:ads_categories,id',
            'condition' => 'nullable|integer|exists:ads_conditions,id',
            'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'contact_email' => 'required|email|max:200',
            'phone' => 'required|string|max:100',
            'address' => 'nullable|string|max:500',
            'video_url' => 'nullable|url|max:500',
        ];

        $request->validate($rules);

        try {
            DB::beginTransaction();

            $ad->title = xss_clean($request->title);
            $ad->description = xss_clean($request->description);
            $ad->category_id = $request->category;
            $ad->city_id = $request->city;
            $ad->condition_id = $request->condition;
            $ad->price = $request->price;
            $ad->is_negotiable = $request->has('negotiable') ? config('settings.general_status.active') : config('settings.general_status.in_active');
            $ad->country_id = $request->country;
            $ad->state_id = $request->state;
            $ad->address = xss_clean($request->address);
            $ad->video_url = $request->video_url;
            $ad->contact_email = xss_clean($request->contact_email);
            $ad->contact_phone = xss_clean($request->phone);
            $ad->contact_is_hide = $request->has('hide_phone_number') ? config('settings.general_status.active') : config('settings.general_status.in_active');

            // Handle thumbnail image
            if ($request->hasFile('thumbnail_image')) {
                $ad->thumbnail_image = saveFileInStorage($request->file('thumbnail_image'));
            }

            // Handle custom fields
            $customFieldData = [];
            if ($request->has('custom_field') && is_array($request->custom_field)) {
                foreach ($request->custom_field as $fieldId => $value) {
                    $field = AdsCustomField::find($fieldId);
                    if ($field) {
                        $customFieldData[] = [
                            'flied_id' => $fieldId,
                            'type' => $field->type,
                            'value' => $value,
                        ];
                    }
                }
            }

            // Handle custom file fields
            foreach ($request->allFiles() as $key => $file) {
                if (str_starts_with($key, 'customfile_')) {
                    $fieldId = str_replace('customfile_', '', $key);
                    $field = AdsCustomField::find($fieldId);
                    if ($field) {
                        $savedPath = saveFileInStorage($file);
                        $customFieldData[] = [
                            'flied_id' => $fieldId,
                            'type' => $field->type,
                            'value' => $savedPath,
                        ];
                    }
                }
            }

            if (count($customFieldData) > 0) {
                $ad->custom_field = json_encode($customFieldData);
            }

            $ad->save();

            // Update tags - remove old and add new
            if ($request->has('tags')) {
                AdHasTag::where('ad_id', $ad->id)->delete();
                foreach ($request->tags as $tag) {
                    $tagInfo = AdsTag::find($tag);
                    if ($tagInfo) {
                        $tagId = $tagInfo->id;
                    } else {
                        $newTag = new AdsTag();
                        $newTag->title = $tag;
                        $newTag->save();
                        $tagId = $newTag->id;
                    }
                    AdHasTag::firstOrCreate(['ad_id' => $ad->id, 'tag_id' => $tagId]);
                }
            }

            // Handle deleted gallery images
            if ($request->has('deleted_gallery_images')) {
                $deletedIds = json_decode($request->deleted_gallery_images, true);
                if (is_array($deletedIds)) {
                    AdGalleryImage::whereIn('id', $deletedIds)->where('ad_id', $ad->id)->delete();
                }
            }

            // Store new gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $savedImage = saveFileInStorage($image);
                    $galleryImage = new AdGalleryImage();
                    $galleryImage->image_path = $savedImage;
                    $galleryImage->ad_id = $ad->id;
                    $galleryImage->save();
                }
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ad updated successfully!',
                    'redirect_url' => route('ad.details.page', ['slug' => $ad->uid]),
                ]);
            }

            return redirect()->route('ad.details.page', ['slug' => $ad->uid])
                ->with('success', 'Ad updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update ad. Please try again.',
                    'error' => $e->getMessage()
                ], 422);
            }

            return back()->withInput()->with('error', 'Failed to update ad. Please try again. ' . $e->getMessage());
        }
    }

    /**
     * Build category hierarchy for pre-selection in edit form
     */
    private function buildCategoryHierarchy($categoryId)
    {
        $hierarchy = [
            'category' => null,
            'subcategory' => null,
            'subSubcategory' => null,
        ];

        if (!$categoryId) {
            return $hierarchy;
        }

        $category = AdsCategory::find($categoryId);
        if (!$category) {
            return $hierarchy;
        }

        $chain = [$category];
        $current = $category;

        while ($current->parent) {
            $parent = AdsCategory::find($current->parent);
            if ($parent) {
                $chain[] = $parent;
                $current = $parent;
            } else {
                break;
            }
        }

        $chain = array_reverse($chain);

        if (count($chain) >= 1) {
            $hierarchy['category'] = $chain[0]->id;
        }
        if (count($chain) >= 2) {
            $hierarchy['subcategory'] = $chain[1]->id;
        }
        if (count($chain) >= 3) {
            $hierarchy['subSubcategory'] = $chain[2]->id;
        }

        return $hierarchy;
    }

    /**
     * Build breadcrumb trail for a category by traversing up the hierarchy
     */
    private function buildCategoryBreadcrumb($category)
    {
        $breadcrumb = [
            'category' => null,
            'subcategory' => null,
            'child' => null
        ];

        if (!$category) {
            return $breadcrumb;
        }

        // Determine depth level by traversing up the hierarchy
        $current = $category;
        $level = 0;
        $hierarchy = [$current];

        while ($current->parent) {
            $parent = AdsCategory::find($current->parent);
            if ($parent) {
                $hierarchy[] = $parent;
                $current = $parent;
                $level++;
            } else {
                break;
            }
        }

        // Reverse to get root -> leaf order
        $hierarchy = array_reverse($hierarchy);

        // Assign to breadcrumb based on depth
        if (count($hierarchy) == 1) {
            $breadcrumb['category'] = $hierarchy[0];
        } elseif (count($hierarchy) == 2) {
            $breadcrumb['category'] = $hierarchy[0];
            $breadcrumb['subcategory'] = $hierarchy[1];
        } elseif (count($hierarchy) >= 3) {
            $breadcrumb['category'] = $hierarchy[0];
            $breadcrumb['subcategory'] = $hierarchy[1];
            $breadcrumb['child'] = $hierarchy[2];
        }

        return $breadcrumb;
    }
}
