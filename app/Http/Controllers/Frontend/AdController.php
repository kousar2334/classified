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
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $subcategories = AdsCategory::where('parent', $request->parent_id)
            ->where('status', config('settings.general_status.active'))
            ->orderBy('id', 'ASC')
            ->get(['id', 'title']);

        return response()->json($subcategories);
    }

    public function adListingPage(Request $request, $category_slug = null)
    {
        // Load parent categories for filter dropdown
        $categories = AdsCategory::whereNull('parent')
            ->where('status', config('settings.general_status.active'))
            ->orderBy('id', 'ASC')
            ->get(['id', 'title']);

        // Load conditions for filter
        $conditions = AdsCondition::where('status', config('settings.general_status.active'))
            ->orderBy('id', 'ASC')
            ->get(['id', 'title']);

        // If category slug provided, find the category
        $selectedCategory = null;
        if ($category_slug) {
            $selectedCategory = AdsCategory::where('permalink', $category_slug)
                ->where('status', config('settings.general_status.active'))
                ->first();
        }

        // Get selected category/subcategory/child category for breadcrumb
        $breadcrumbCategory = null;
        $breadcrumbSubcategory = null;
        $breadcrumbChildCategory = null;

        if ($request->has('child_cat') && $request->child_cat != '') {
            $breadcrumbChildCategory = AdsCategory::find($request->child_cat);
            if ($breadcrumbChildCategory) {
                $breadcrumbSubcategory = AdsCategory::find($breadcrumbChildCategory->parent);
                if ($breadcrumbSubcategory) {
                    $breadcrumbCategory = AdsCategory::find($breadcrumbSubcategory->parent);
                }
            }
        } elseif ($request->has('subcat') && $request->subcat != '') {
            $breadcrumbSubcategory = AdsCategory::find($request->subcat);
            if ($breadcrumbSubcategory) {
                $breadcrumbCategory = AdsCategory::find($breadcrumbSubcategory->parent);
            }
        } elseif ($request->has('cat') && $request->cat != '') {
            $breadcrumbCategory = AdsCategory::find($request->cat);
        } elseif ($selectedCategory) {
            $breadcrumbCategory = $selectedCategory;
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
        $query = Ad::with(['categoryInfo', 'cityInfo'])
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

        // Filter by category
        if ($request->has('cat') && $request->cat != '') {
            $query->where('category', $request->cat);
        } elseif ($selectedCategory) {
            $query->where('category', $selectedCategory->id);
        }

        // Filter by subcategory
        if ($request->has('subcat') && $request->subcat != '') {
            $query->where('category', $request->subcat);
        }

        // Filter by child category
        if ($request->has('child_cat') && $request->child_cat != '') {
            $query->where('category', $request->child_cat);
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
            $query->where('item_condition', $request->condition);
        }

        // Filter by type (featured/top_listing)
        if ($request->has('type') && $request->type == 'featured') {
            $query->where('is_featured', config('settings.general_status.active'));
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

        // dd($breadcrumbSubcategory);

        return view('frontend.pages.ad.listing', compact(
            'categories',
            'conditions',
            'category_slug',
            'selectedCategory',
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
        return view('frontend.pages.ad.details', compact('slug'));
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
}
