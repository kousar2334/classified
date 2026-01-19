<?php

namespace App\Http\Controllers\Backend;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\AdsCategory;
use App\Repository\CategoryRepository;
use App\Http\Requests\AdsCategoryRequest;

class CategoryController extends Controller
{
    public function __construct(public CategoryRepository $category_repository) {}

    /**
     * Will return all ads categories
     */
    public function  categories(Request $request): View
    {
        $status = $request->has('status') && $request['status'] != null ? [$request['status']] : [config('settings.general_status.active'), config('settings.general_status.in_active')];
        $categories = $this->category_repository->adsCategoryList($request, $status);

        return view('backend.modules.ads.categories.list', ['categories' => $categories]);
    }
    /**
     * Will store new category
     */
    public function categoryStore(AdsCategoryRequest $request): JsonResponse
    {
        $res = $this->category_repository->storeCategory($request);
        if ($res) {
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }
    /**
     * Will delete a category
     */
    public function categoryDelete(Request $request): RedirectResponse
    {
        $res = $this->category_repository->deleteCategory($request['id']);
        if ($res) {
            toastNotification('success', 'Category deleted successfully', 'Success');
        } else {
            toastNotification('error', 'Category delete failed', 'Error');
        }
        return redirect()->back();
    }
    /**
     * Will redirect category edit page
     */
    public function categoryEdit($id): View
    {
        $category = $this->category_repository->categoryDetails($id);
        return view('backend.modules.ads.categories.edit', ['category' => $category]);
    }

    /**
     * Will category update
     */
    public function categoryUpdate(AdsCategoryRequest $request): RedirectResponse
    {
        $res = $this->category_repository->updateCategory($request);
        if ($res) {
            toastNotification('success', 'Category updated successfully', 'Success');
        } else {
            toastNotification('error', 'Category update failed', 'Error');
        }

        return to_route('classified.ads.categories.edit', ['id' => $request['id'], 'lang' => $request['lang'] != null ? $request['lang'] : getDefaultLang()]);
    }

    /**
     * Will return  category options
     */
    public function CategoryOption(Request $request): JsonResponse
    {
        $query = AdsCategory::with(['child' => function ($q) {
            $q->where('status', config('settings.general_status.active'))
                ->select('id', 'title', 'parent');
        }, 'category_translations'])
            ->select('id', 'title', 'parent')
            ->where('status', config('settings.general_status.active'));

        if ($request->has('term')) {
            $term = trim($request->term);
            $query = $query->where('title', 'LIKE',  '%' . $term . '%');
        }

        $categories = $query->orderBy('id', 'asc')->paginate(2);

        $output = [];

        foreach ($categories->items() as $category) {
            $item['id'] = $category->id;
            $item['text'] = $category->translation('title', getLocale());
            array_push($output, $item);

            if ($category->child != null) {
                foreach ($category->child as $child) {
                    $sub_item['id'] = $child->id;
                    $sub_item['text'] = '-- ' . $child->translation('title', getLocale());
                    array_push($output, $sub_item);

                    if ($child->child != null) {
                        foreach ($child->child as $pro_child) {
                            $sub_sub_item['id'] = $pro_child->id;
                            $sub_sub_item['text'] = '--- ' . $pro_child->translation('title', getLocale());
                            array_push($output, $sub_sub_item);
                        }
                    }
                }
            }
        }

        $morePages = true;

        if (empty($categories->nextPageUrl())) {
            $morePages = false;
        }
        $results = array(
            "results" => $output,
            "pagination" => array(
                "more" => $morePages
            )
        );

        return response()->json($results);
    }
}
