<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdsCategory;

class PageController extends Controller
{
    public function homePage()
    {
        $activeStatus = config('settings.general_status.active');

        // Fetch active parent categories
        $categories = AdsCategory::whereNull('parent')
            ->where('status', $activeStatus)
            ->orderBy('id', 'ASC')
            ->get();

        // Fetch featured/top listings
        $topListings = Ad::where('status', $activeStatus)
            ->where('is_featured', $activeStatus)
            ->with(['cityInfo', 'stateInfo'])
            ->latest()
            ->take(8)
            ->get();

        // Fetch recent listings
        $recentListings = Ad::where('status', $activeStatus)
            ->with(['cityInfo', 'stateInfo'])
            ->latest()
            ->take(8)
            ->get();

        // Fetch category-wise listings for top 3 parent categories
        $topCategories = AdsCategory::whereNull('parent')
            ->where('status', $activeStatus)
            ->orderBy('id', 'ASC')
            ->take(3)
            ->get();

        // Get all child category IDs in one query
        $allChildCategories = AdsCategory::whereIn('parent', $topCategories->pluck('id'))
            ->where('status', $activeStatus)
            ->get(['id', 'parent']);

        // Build category ID map: parent_id => [parent_id, child_id1, child_id2, ...]
        $categoryIdMap = [];
        foreach ($topCategories as $category) {
            $childIds = $allChildCategories->where('parent', $category->id)->pluck('id')->toArray();
            $categoryIdMap[$category->id] = array_merge([$category->id], $childIds);
        }

        // Fetch all ads for all categories in one query
        $allCategoryIds = collect($categoryIdMap)->flatten()->unique()->toArray();
        $allAds = Ad::where('status', $activeStatus)
            ->whereIn('category_id', $allCategoryIds)
            ->with(['cityInfo', 'stateInfo'])
            ->latest()
            ->get();

        // Group ads by parent category
        $categoryWiseListings = [];
        foreach ($topCategories as $category) {
            $categoryIds = $categoryIdMap[$category->id];
            $ads = $allAds->whereIn('category_id', $categoryIds)->take(8)->values();

            if ($ads->count() > 0) {
                $categoryWiseListings[] = [
                    'category' => $category,
                    'ads' => $ads,
                ];
            }
        }

        return view('frontend.pages.home', compact(
            'categories',
            'topListings',
            'recentListings',
            'categoryWiseListings'
        ));
    }
}
