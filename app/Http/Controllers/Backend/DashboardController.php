<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Will redirect admin dashboard
     */
    public function adminDashboard(): View
    {
        $total_ads = \App\Models\Ad::count();
        $total_members = \App\Models\User::count();
        $total_blogs = \App\Models\Blog::count();
        $total_page = \App\Models\Page::count();
        $latest_ads = \App\Models\Ad::with(['categoryInfo', 'userInfo', 'cityInfo'])
            ->latest()
            ->take(10)
            ->get();
        $latest_members = \App\Models\User::latest()
            ->take(10)
            ->get();

        return view('backend.modules.dashboard.index', [
            'total_ads' => $total_ads,
            'total_members' => $total_members,
            'total_blogs' => $total_blogs,
            'total_page' => $total_page,
            'latest_ads' => $latest_ads,
            'latest_members' => $latest_members,
        ]);
    }
}
