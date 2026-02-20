<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = UserSubscription::with(['user', 'plan'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('email', 'like', '%' . $request->q . '%');
            });
        }

        $subscriptions = $query->paginate(20)->withQueryString();

        $stats = [
            'total'     => UserSubscription::count(),
            'active'    => UserSubscription::where('status', 'active')->where('expires_at', '>', now())->count(),
            'pending'   => UserSubscription::where('status', 'pending')->count(),
            'expired'   => UserSubscription::where('status', 'active')->where('expires_at', '<=', now())->count(),
        ];

        return view('backend.modules.subscriptions.index', compact('subscriptions', 'stats'));
    }

    public function delete(Request $request)
    {
        $subscription = UserSubscription::findOrFail($request->id);
        $subscription->delete();

        toastNotification('success', 'Subscription deleted successfully', 'Success');
        return redirect()->back();
    }
}
