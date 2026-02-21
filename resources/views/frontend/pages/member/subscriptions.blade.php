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
        <div
            style="background: linear-gradient(135deg, #0f4c81, #1a73e8); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem; color: #fff;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div
                        style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; margin-bottom: 0.4rem;">
                        Active Plan
                    </div>
                    <div style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem;">
                        {{ $activeSubscription->plan->title ?? 'N/A' }}
                    </div>
                    <div style="opacity: 0.85; font-size: 0.9rem;">
                        Expires: {{ $activeSubscription->expires_at?->format('M d, Y') }}
                        ({{ $activeSubscription->expires_at?->diffForHumans() }})
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.8rem; opacity: 0.8; margin-bottom: 0.25rem;">Plan Limits</div>
                    <div style="font-size: 0.85rem; opacity: 0.9;">
                        <i class="fas fa-list-ul"></i> {{ $activeSubscription->plan->listing_quantity }} Listings<br>
                        <i class="fas fa-star"></i> {{ $activeSubscription->plan->featured_listing_quantity }} Featured<br>
                        <i class="fas fa-images"></i> {{ $activeSubscription->plan->gallery_image_quantity }} Gallery Images
                    </div>
                </div>
            </div>
        </div>
    @else
        <div
            style="background: #fff8e1; border: 1px solid #ffd54f; border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-exclamation-triangle" style="color: #f59e0b; font-size: 1.25rem;"></i>
            <div>
                <strong style="color: #92400e;">No active subscription</strong>
                <p style="margin: 0; color: #78350f; font-size: 0.875rem;">
                    <a href="{{ route('pricing.plans') }}" style="color: #1a73e8; font-weight: 600;">Choose a plan</a>
                    to unlock posting limits and premium features.
                </p>
            </div>
        </div>
    @endif

    {{-- Subscription History Table --}}
    <div class="dashboard-card">
        <div class="card-header">
            <h3 class="card-title">Subscription History</h3>
            <span style="font-size: 0.8rem; color: var(--text-muted);">{{ $subscriptions->total() }} total</span>
        </div>

        @if ($subscriptions->count())
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: var(--bg-light); border-bottom: 2px solid var(--border);">
                            <th
                                style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.5px;">
                                Plan</th>
                            <th
                                style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.5px;">
                                Transaction ID</th>
                            <th
                                style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.5px;">
                                Amount</th>
                            <th
                                style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.5px;">
                                Method</th>
                            <th
                                style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.5px;">
                                Status</th>
                            <th
                                style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.5px;">
                                Start</th>
                            <th
                                style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.5px;">
                                Expires</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $sub)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 0.875rem 1rem; font-weight: 600; color: var(--text-dark);">
                                    {{ $sub->plan->title ?? 'N/A' }}
                                </td>
                                <td
                                    style="padding: 0.875rem 1rem; color: var(--text-muted); font-family: monospace; font-size: 0.8rem;">
                                    {{ $sub->transaction_id }}
                                </td>
                                <td style="padding: 0.875rem 1rem; color: var(--text-dark); font-weight: 600;">
                                    @if ($sub->amount > 0)
                                        ${{ number_format($sub->amount, 2) }}
                                    @else
                                        <span style="color: #10b981;">Free</span>
                                    @endif
                                </td>
                                <td style="padding: 0.875rem 1rem;">
                                    @if ($sub->payment_method === 'sslcommerz')
                                        <span
                                            style="background: #e0f2fe; color: #0369a1; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">SSLCommerz</span>
                                    @else
                                        <span
                                            style="background: #f0fdf4; color: #166534; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Trial</span>
                                    @endif
                                </td>
                                <td style="padding: 0.875rem 1rem;">
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
                                    <span
                                        style="background: {{ $color['bg'] }}; color: {{ $color['text'] }}; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: capitalize;">
                                        {{ $sub->status }}
                                        @if ($sub->status === 'active' && $sub->expires_at?->isPast())
                                            (expired)
                                        @endif
                                    </span>
                                </td>
                                <td style="padding: 0.875rem 1rem; color: var(--text-muted); font-size: 0.82rem;">
                                    {{ $sub->starts_at?->format('M d, Y') ?? '—' }}
                                </td>
                                <td style="padding: 0.875rem 1rem; color: var(--text-muted); font-size: 0.82rem;">
                                    {{ $sub->expires_at?->format('M d, Y') ?? '—' }}
                                </td>
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
