<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use App\Notifications\SubscriptionApproved;
use App\Notifications\SubscriptionRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = UserSubscription::with(['user', 'plan'])
            ->where('payment_method', 'bank_transfer')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('bank_transaction_number', 'like', '%' . $request->q . '%')
                    ->orWhereHas('user', function ($uq) use ($request) {
                        $uq->where('name', 'like', '%' . $request->q . '%')
                            ->orWhere('email', 'like', '%' . $request->q . '%');
                    });
            });
        }

        $payments = $query->paginate(20)->withQueryString();

        $stats = [
            'total'    => UserSubscription::where('payment_method', 'bank_transfer')->count(),
            'pending'  => UserSubscription::where('payment_method', 'bank_transfer')->where('status', 'pending')->count(),
            'approved' => UserSubscription::where('payment_method', 'bank_transfer')->where('status', 'active')->count(),
            'rejected' => UserSubscription::where('payment_method', 'bank_transfer')->where('status', 'rejected')->count(),
        ];

        return view('backend.modules.bank-payments.index', compact('payments', 'stats'));
    }

    public function approve(Request $request)
    {
        $subscription = UserSubscription::with('user', 'plan')
            ->where('payment_method', 'bank_transfer')
            ->where('status', 'pending')
            ->findOrFail($request->id);

        try {
            DB::beginTransaction();

            $subscription->update([
                'status'     => 'active',
                'starts_at'  => now(),
                'expires_at' => now()->addDays($subscription->plan->duration_days),
                'admin_note' => $request->admin_note ?? null,
            ]);

            $subscription->user->notify(new SubscriptionApproved($subscription));

            DB::commit();

            toastNotification('success', 'Payment approved and user notified.', 'Approved');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', 'Failed to approve payment.', 'Error');
        }

        return redirect()->back();
    }

    public function reject(Request $request)
    {
        $subscription = UserSubscription::with('user', 'plan')
            ->where('payment_method', 'bank_transfer')
            ->where('status', 'pending')
            ->findOrFail($request->id);

        try {
            DB::beginTransaction();

            $subscription->update([
                'status'     => 'rejected',
                'admin_note' => $request->admin_note ?? null,
            ]);

            $subscription->user->notify(new SubscriptionRejected($subscription));

            DB::commit();

            toastNotification('success', 'Payment rejected and user notified.', 'Rejected');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', 'Failed to reject payment.', 'Error');
        }

        return redirect()->back();
    }
}
