<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdReport;
use Illuminate\Http\Request;

class AdReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = AdReport::with(['ad', 'user'])
            ->when($request->filled('reason'), fn($q) => $q->where('reason', $request->reason))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return view('backend.modules.ads.reports.list', compact('reports'));
    }

    public function delete(Request $request)
    {
        $report = AdReport::findOrFail($request->id);
        $report->delete();

        toastNotification('success', 'Report deleted successfully', 'Success');
        return redirect()->back();
    }

    public function updateStatus(Request $request)
    {
        $request->validate(['id' => 'required|exists:ad_reports,id', 'status' => 'required|in:0,1,2']);

        AdReport::where('id', $request->id)->update(['status' => $request->status]);

        toastNotification('success', 'Report status updated', 'Success');
        return redirect()->back();
    }
}
