<?php

namespace App\Repository;

use App\Models\Advertisement;
use Illuminate\Support\Facades\DB;

class AdvertisementRepository
{
    /**
     * Paginated list for admin panel
     */
    public function advertisementList($request)
    {
        $query = Advertisement::orderBy('sort_order', 'ASC')->orderBy('id', 'DESC');

        if ($request->has('search') && $request['search'] != null) {
            $query->where('title', 'like', '%' . $request['search'] . '%');
        }

        if ($request->has('position') && $request['position'] != null) {
            $query->where('position', $request['position']);
        }

        $per_page = ($request->has('per_page') && $request['per_page'] != null)
            ? $request['per_page']
            : 10;

        if ($per_page == 'all') {
            return $query->paginate($query->count())->withQueryString();
        }

        return $query->paginate($per_page)->withQueryString();
    }

    /**
     * Returns active ads for a given position (used on frontend)
     */
    public function getActiveByPosition(string $position)
    {
        return Advertisement::active()
            ->forPosition($position)
            ->orderBy('sort_order', 'ASC')
            ->get();
    }

    /**
     * Store a new advertisement
     */
    public function store($request): bool
    {
        try {
            $ad = new Advertisement();
            $ad->title      = $request['title'];
            $ad->position   = $request['position'];
            $ad->type       = $request['type'];
            $ad->status     = $request['status'];
            $ad->sort_order = $request['sort_order'] ?? 0;
            $ad->start_date = $request['start_date'] ?? null;
            $ad->end_date   = $request['end_date'] ?? null;

            if ($request['type'] === 'image') {
                $ad->image_path = $request['image_path'];
                $ad->click_url  = $request['click_url'] ?? null;
            } else {
                $ad->html_code = $request['html_code'];
            }

            $ad->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Find advertisement by id
     */
    public function findById(int $id): Advertisement
    {
        return Advertisement::findOrFail($id);
    }

    /**
     * Update advertisement
     */
    public function update($request): bool
    {
        try {
            DB::beginTransaction();
            $ad = Advertisement::findOrFail($request['id']);
            $ad->title      = $request['title'];
            $ad->position   = $request['position'];
            $ad->type       = $request['type'];
            $ad->status     = $request['status'];
            $ad->sort_order = $request['sort_order'] ?? 0;
            $ad->start_date = $request['start_date'] ?? null;
            $ad->end_date   = $request['end_date'] ?? null;

            if ($request['type'] === 'image') {
                $ad->image_path = $request['image_path'];
                $ad->click_url  = $request['click_url'] ?? null;
                $ad->html_code  = null;
            } else {
                $ad->html_code  = $request['html_code'];
                $ad->image_path = null;
                $ad->click_url  = null;
            }

            $ad->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Delete advertisement
     */
    public function delete(int $id): bool
    {
        try {
            $ad = Advertisement::find($id);
            if ($ad) {
                $ad->delete();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
