@extends('frontend.layouts.dashboard')
@section('dash-meta')
    <title>{{ translation('Dashboard') }} - {{ get_setting('site_name') }}</title>
@endsection
@section('dashboard-content')
    <!-- Header -->
    <div class="dashboard-header">
        <h1 class="dash-page-title">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="dash-page-subtitle">{{ translation("Here's what's happening with your listings today.") }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">{{ translation('Total Ads') }}</span>
                <div class="stat-icon blue"><i class="fas fa-list-ul"></i></div>
            </div>
            <div class="stat-value">{{ $totalListings }}</div>
            <div class="stat-change positive">
                <i class="fas fa-circle-check"></i> {{ $activeListings }} {{ translation('active') }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">{{ translation('Messages') }}</span>
                <div class="stat-icon green"><i class="fas fa-comments"></i></div>
            </div>
            <div class="stat-value">{{ $totalMessages }}</div>
            @if ($unreadMessages > 0)
                <div class="stat-change positive">
                    <i class="fas fa-envelope"></i> {{ $unreadMessages }} {{ translation('unread') }}
                </div>
            @else
                <div class="stat-change">
                    <i class="fas fa-check"></i> {{ translation('All caught up') }}
                </div>
            @endif
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">{{ translation('Favorites') }}</span>
                <div class="stat-icon cyan"><i class="fas fa-heart"></i></div>
            </div>
            <div class="stat-value">{{ $totalFavourites }}</div>
            <div class="stat-change">
                <i class="fas fa-bookmark"></i> {{ translation('Saved ads') }}
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Recent Listings -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ translation('Recent Listings') }}</h3>
                <a href="{{ route('member.my.listings') }}" class="view-all">{{ translation('View All') }} →</a>
            </div>

            <div class="card-body">
                @if ($recentListings->count())
                    <div class="activity-list">
                        @foreach ($recentListings as $listing)
                            <div class="activity-item">
                                <div class="activity-icon blue">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div class="activity-content">
                                    <h4>{{ $listing->title }}</h4>
                                    <p>
                                        {{ $listing->categoryInfo->title ?? '—' }}
                                        @if ($listing->cityInfo)
                                            · <i class="fas fa-location-dot icon-xs"></i>
                                            {{ $listing->cityInfo->name }}
                                        @endif
                                    </p>
                                    <div class="activity-time">
                                        <i class="fas fa-clock icon-xxs"></i>
                                        {{ $listing->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="activity-badge-wrap">
                                    <span
                                        class="badge-status {{ $listing->status == config('settings.general_status.active') ? 'active' : 'inactive' }}">
                                        {{ $listing->status == config('settings.general_status.active') ? translation('Active') : translation('Inactive') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-activity">
                        <i class="fas fa-inbox empty-activity-icon"></i>
                        {{ translation('No listings yet.') }}
                        <a href="{{ route('ad.post.page') }}"
                            class="link-primary-bold">{{ translation('Post your first ad!') }}</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">{{ translation('Quick Actions') }}</h3>
            </div>
            <div class="quick-actions">
                <a href="{{ route('ad.post.page') }}" class="action-btn">
                    <i class="fas fa-plus"></i> {{ translation('Post New Ad') }}
                </a>
                <a href="{{ route('member.my.listings') }}" class="action-btn secondary">
                    <i class="fas fa-list-ul"></i> {{ translation('My Listings') }}
                </a>
                <a href="{{ route('member.messages.index') }}" class="action-btn secondary">
                    <i class="fas fa-comments"></i> {{ translation('Messages') }}
                    @if ($unreadMessages > 0)
                        <span class="msg-unread-badge">{{ $unreadMessages }}</span>
                    @endif
                </a>
                <a href="{{ route('member.favourites') }}" class="action-btn secondary">
                    <i class="fas fa-heart"></i> {{ translation('Favourites') }}
                </a>
            </div>
        </div>
    </div>
@endsection
