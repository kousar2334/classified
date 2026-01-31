<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdGalleryImage;
use App\Models\AdHasTag;
use App\Models\AdsCategory;
use App\Models\AdsCondition;
use App\Models\AdsCustomField;
use App\Models\AdsTag;
use App\Models\City;
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
        $cities = City::where('status', config('settings.general_status.active'))->get();

        return view('frontend.pages.ad.post-ad', compact('categories', 'conditions', 'tags', 'cities'));
    }

    public function storeAd(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:250',
            'category' => 'required|integer|exists:ads_categories,id',
            'description' => 'required|string|min:150',
            'price' => 'required|numeric|min:0',
            'contact_email' => 'required|email|max:200',
            'contact_phone' => 'required|string|max:100',
            'thumbnail_image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        try {
            DB::beginTransaction();

            $ad = new Ad();
            $ad->user_id = auth()->check() ? auth()->id() : null;
            $ad->title = xss_clean($request->title);
            $ad->description = xss_clean($request->description);
            $ad->category = $request->category;
            $ad->city = $request->city;
            $ad->item_condition = $request->condition;
            $ad->price = $request->price;
            $ad->is_negotiable = $request->has('negotiable') ? config('settings.general_status.active') : config('settings.general_status.in_active');
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
                    $galleryImage->image_id = $savedImage;
                    $galleryImage->ad_id = $ad->id;
                    $galleryImage->save();
                }
            }

            DB::commit();

            return redirect()->route('ad.details.page', Str::slug($ad->title) . '/' . $ad->uid)
                ->with('success', 'Ad posted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
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

    public function adListingPage($category_slug = null)
    {
        return view('frontend.pages.ad.listing', compact('category_slug'));
    }

    public function adDetailsPage($slug)
    {
        return view('frontend.pages.ad.details', compact('slug'));
    }
}
