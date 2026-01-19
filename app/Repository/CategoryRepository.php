<?php

namespace App\Repository;

use App\Models\AdsCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\AdsCategoryTranslation;

class CategoryRepository
{

    //Will return ads category
    public function adsCategoryList($request, $status = [1, 2])
    {
        $query = AdsCategory::with(['child'])->orderBy('id', 'DESC');


        if ($request->has('search')) {
            $query = $query->where('title', 'like', '%' . $request['search'] . '%');
        }
        $per_page = $request->has('per_page') && $request['per_page'] != null ? $request['per_page'] : 10;
        if ($per_page != null && $per_page == 'all') {
            return $query->whereIn('status', $status)->paginate($query->get()->count())->withQueryString();
        } else {
            return $query->whereIn('status', $status)->paginate($per_page)->withQueryString();
        }
    }
    /**
     * Will store a new category
     */
    public function storeCategory($data)
    {
        try {
            $category = new AdsCategory();
            $category->title = $data['title'];
            $category->permalink = Str::slug($data['title']);
            $category->icon = $data['icon'];
            $category->image = $data['image'];
            $category->parent = $data['parent'];
            $category->status = $data['status'];
            $category->save();
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
            return false;
        }
    }
    /**
     * Will delete a category
     * 
     * @param Int $id
     */
    public function deleteCategory(int $id): bool
    {
        try {
            DB::beginTransaction();
            $category = AdsCategory::findOrFail($id);
            $category->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    /**
     * Will return category details
     */
    public function categoryDetails(int $id)
    {
        return AdsCategory::findOrFail($id);
    }

    /**
     * Will update category
     * 
     */
    public function updateCategory($request): bool
    {
        try {
            DB::beginTransaction();
            if ($request['lang'] != null && $request['lang'] != getDefaultLang()) {
                $category_translation = AdsCategoryTranslation::firstOrNew(['category_id' => $request['id'], 'lang' => $request['lang']]);
                $category_translation->title = $request['title'];
                $category_translation->save();
            } else {
                $category = AdsCategory::findOrFail($request['id']);
                $category->title = $request['title'];
                $category->permalink = $request['permalink'];
                $category->icon = $request['icon'];
                $category->image = $request['image'];
                $category->parent = $request['parent'];
                $category->status = $request['status'];
                $category->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
