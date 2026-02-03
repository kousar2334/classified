<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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

        // Monthly ad posts for the last 12 months
        $monthly_ads = \App\Models\Ad::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Build arrays for all 12 months (fill missing months with 0)
        $monthly_labels = [];
        $monthly_data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $monthly_labels[] = $date->format('M Y');
            $monthly_data[] = $monthly_ads[$key] ?? 0;
        }

        return view('backend.modules.dashboard.index', [
            'total_ads' => $total_ads,
            'total_members' => $total_members,
            'total_blogs' => $total_blogs,
            'total_page' => $total_page,
            'latest_ads' => $latest_ads,
            'latest_members' => $latest_members,
            'monthly_labels' => $monthly_labels,
            'monthly_data' => $monthly_data,
        ]);
    }
}
