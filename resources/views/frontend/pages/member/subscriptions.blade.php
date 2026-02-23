@extends('frontend.layouts.dashboard')
@section('dash-meta')
    <title>My Subscriptions - {{ get_setting('site_name') }}</title>
@endsection

@section('dashboard-content')
    <div class="my-listings-header">
        <h1>My Subscriptions</h1>
        <div class="btn-wrapper">
            <a href="{{ route('pricing.plans') }}" class="cmn-btn1">
                Upgrade Plan
            </a>
        </div>
    </div>

    {{-- Active Subscription Banner --}}
    @if ($activeSubscription)
        <div class="sub-active-banner">
            <div class="sub-active-banner-row">
                <div>
                    <div class="sub-plan-label">Active Plan</div>
                    <div class="sub-plan-name">{{ $activeSubscription->plan->title ?? 'N/A' }}</div>
                    <div class="sub-plan-expires">
                        Expires: {{ $activeSubscription->expires_at?->format('M d, Y') }}
                        ({{ $activeSubscription->expires_at?->diffForHumans() }})
                    </div>
                </div>
                <div class="sub-limits-col">
                    <div class="sub-limits-label">Plan Limits</div>
                    <div class="sub-limits-detail">
                        <i class="fas fa-list-ul"></i> {{ $activeSubscription->plan->listing_quantity }} Listings<br>
                        <i class="fas fa-star"></i> {{ $activeSubscription->plan->featured_listing_quantity }} Featured<br>
                        <i class="fas fa-images"></i> {{ $activeSubscription->plan->gallery_image_quantity }} Gallery Images
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="sub-warning-banner">
            <i class="fas fa-exclamation-triangle sub-warning-icon"></i>
            <div>
                <strong class="sub-warning-title">No active subscription</strong>
                <p class="sub-warning-text">
                    <a href="{{ route('pricing.plans') }}" class="sub-warning-link">Choose a plan</a>
                    to unlock posting limits and premium features.
                </p>
            </div>
        </div>
    @endif

    {{-- Subscription History Table --}}
    <div class="dashboard-card">
        <div class="card-header">
            <h3 class="card-title">Subscription History</h3>
            <span class="sub-history-count">{{ $subscriptions->total() }} total</span>
        </div>

        @if ($subscriptions->count())
            <div class="sub-table-wrap">
                <table class="sub-table">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Start</th>
                            <th>Expires</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $sub)
                            <tr>
                                <td class="td-plan">{{ $sub->plan->title ?? 'N/A' }}</td>
                                <td class="td-txn">{{ $sub->transaction_id }}</td>
                                <td class="td-amount">
                                    @if ($sub->amount > 0)
                                        ${{ number_format($sub->amount, 2) }}
                                    @else
                                        <span class="sub-free-badge">Free</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($sub->payment_method === 'sslcommerz')
                                        <span class="sub-method-badge sub-method-sslcommerz">SSLCommerz</span>
                                    @else
                                        <span class="sub-method-badge sub-method-trial">Trial</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'active' => ['bg' => '#f0fdf4', 'text' => '#166534'],
                                            'pending' => ['bg' => '#fffbeb', 'text' => '#92400e'],
                                            'expired' => ['bg' => '#f9fafb', 'text' => '#6b7280'],
                                            'failed' => ['bg' => '#fef2f2', 'text' => '#991b1b'],
                                            'cancelled' => ['bg' => '#fef2f2', 'text' => '#991b1b'],
                                        ];
                                        $color = $statusColors[$sub->status] ?? [
                                            'bg' => '#f9fafb',
                                            'text' => '#6b7280',
                                        ];
                                    @endphp
                                    <span class="sub-status-badge"
                                        style="background: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                                        {{ $sub->status }}
                                        @if ($sub->status === 'active' && $sub->expires_at?->isPast())
                                            (expired)
                                        @endif
                                    </span>
                                </td>
                                <td class="td-date">{{ $sub->starts_at?->format('M d, Y') ?? '—' }}</td>
                                <td class="td-date">{{ $sub->expires_at?->format('M d, Y') ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($subscriptions->hasPages())
                <div class="pagination-wrapper">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        @else
            <div class="empty-listings">
                <div class="icon"><i class="fas fa-credit-card"></i></div>
                <h3>No subscriptions yet</h3>
                <p>Subscribe to a plan to start posting ads.</p>
                <a href="{{ route('pricing.plans') }}" class="cmn-btn1">
                    <i class="fas fa-tag"></i> View Plans
                </a>
            </div>
        @endif
    </div>
@endsection
