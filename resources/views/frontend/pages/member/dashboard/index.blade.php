@extends('frontend.layouts.dashboard')
@section('dash-meta')
    <title>Dashboard - {{ get_setting('site_name') }}</title>
@endsection
@section('dashboard-content')
    <!-- Header -->
    <div class="dashboard-header" style="margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.25rem;">
            Welcome back, {{ auth()->user()->name }}!
        </h1>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            Here's what's happening with your listings today.
        </p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Listings</span>
                <div class="stat-icon blue"><i class="fas fa-list-ul"></i></div>
            </div>
            <div class="stat-value">{{ $totalListings }}</div>
            <div class="stat-change positive">
                <i class="fas fa-circle-check"></i> {{ $activeListings }} active
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Messages</span>
                <div class="stat-icon green"><i class="fas fa-comments"></i></div>
            </div>
            <div class="stat-value">{{ $totalMessages }}</div>
            @if ($unreadMessages > 0)
                <div class="stat-change positive">
                    <i class="fas fa-envelope"></i> {{ $unreadMessages }} unread
                </div>
            @else
                <div class="stat-change" style="color: var(--text-muted);">
                    <i class="fas fa-check"></i> All caught up
                </div>
            @endif
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Favorites</span>
                <div class="stat-icon cyan"><i class="fas fa-heart"></i></div>
            </div>
            <div class="stat-value">{{ $totalFavourites }}</div>
            <div class="stat-change" style="color: var(--text-muted);">
                <i class="fas fa-bookmark"></i> Saved ads
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Recent Listings -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Listings</h3>
                <a href="{{ route('member.my.listings') }}" class="view-all">View All →</a>
            </div>

            <div class="card-body">
                @if ($recentListings->count())
                    <div class="activity-list">
                        @foreach ($recentListings as $listing)
                            <div class="activity-item">
                                <div class="activity-icon blue"
                                    style="background: rgba(53,146,252,0.1); color: var(--primary);">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div class="activity-content" style="flex: 1; min-width: 0;">
                                    <h4 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $listing->title }}
                                    </h4>
                                    <p>
                                        {{ $listing->categoryInfo->title ?? '—' }}
                                        @if ($listing->cityInfo)
                                            · <i class="fas fa-location-dot" style="font-size:0.7rem;"></i>
                                            {{ $listing->cityInfo->name }}
                                        @endif
                                    </p>
                                    <div class="activity-time">
                                        <i class="fas fa-clock" style="font-size:0.65rem;"></i>
                                        {{ $listing->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div style="flex-shrink: 0; align-self: center; margin-left: 0.75rem;">
                                    <span
                                        class="badge-status {{ $listing->status == config('settings.general_status.active') ? 'active' : 'inactive' }}">
                                        {{ $listing->status == config('settings.general_status.active') ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="padding: 2rem 0; text-align: center; color: var(--text-muted);">
                        <i class="fas fa-inbox"
                            style="font-size: 2rem; margin-bottom: 0.75rem; display: block; opacity: 0.4;"></i>
                        No listings yet.
                        <a href="{{ route('ad.post.page') }}" style="color: var(--primary); font-weight: 600;">Post your
                            first
                            ad!</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="quick-actions">
                <a href="{{ route('ad.post.page') }}" class="action-btn">
                    <i class="fas fa-plus"></i> Post New Ad
                </a>
                <a href="{{ route('member.my.listings') }}" class="action-btn secondary">
                    <i class="fas fa-list-ul"></i> My Listings
                </a>
                <a href="{{ route('member.messages.index') }}" class="action-btn secondary">
                    <i class="fas fa-comments"></i> Messages
                    @if ($unreadMessages > 0)
                        <span
                            style="background: var(--primary); color: #fff; border-radius: 999px; font-size: 0.7rem; padding: 0.1rem 0.45rem; margin-left: 0.25rem;">
                            {{ $unreadMessages }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('member.favourites') }}" class="action-btn secondary">
                    <i class="fas fa-heart"></i> Favourites
                </a>
            </div>
        </div>
    </div>
@endsection
