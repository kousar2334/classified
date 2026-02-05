@extends('frontend.layouts.dashboard')
@section('dash-meta')
    <title>My Listings - {{ get_setting('site_name') }}</title>
    <style>
        .my-listings-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .my-listings-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--heading-color);
            margin: 0;
        }

        .listing-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .listing-tab {
            padding: 0.625rem 1.25rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #fff;
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .listing-tab:hover {
            border-color: var(--main-color-one);
            color: var(--main-color-one);
        }

        .listing-tab.active {
            background: var(--main-color-one);
            border-color: var(--main-color-one);
            color: #fff;
        }

        .listing-tab .count {
            background: rgba(0, 0, 0, 0.1);
            padding: 0.125rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
        }

        .listing-tab.active .count {
            background: rgba(255, 255, 255, 0.2);
        }

        .filters-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 250px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9375rem;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--main-color-one);
        }

        .search-box .search-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .sort-select {
            padding: 0.75rem 2rem 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #fff;
            font-size: 0.9375rem;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
        }

        .sort-select:focus {
            outline: none;
            border-color: var(--main-color-one);
        }

        .listings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .listing-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            transition: all 0.3s;
        }

        .listing-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .listing-image {
            position: relative;
            height: 180px;
            overflow: hidden;
        }

        .listing-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .listing-status {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .listing-status.active {
            background: #10b981;
            color: #fff;
        }

        .listing-status.inactive {
            background: #6b7280;
            color: #fff;
        }

        .listing-status.sold {
            background: #ef4444;
            color: #fff;
        }

        .listing-status.featured {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
        }

        .listing-actions-overlay {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            display: flex;
            gap: 0.5rem;
        }

        .listing-action-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: #374151;
        }

        .listing-action-btn:hover {
            background: var(--main-color-one);
            color: #fff;
        }

        .listing-content {
            padding: 1rem;
        }

        .listing-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--heading-color);
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .listing-title a {
            color: inherit;
            text-decoration: none;
        }

        .listing-title a:hover {
            color: var(--main-color-one);
        }

        .listing-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }

        .listing-meta svg {
            flex-shrink: 0;
        }

        .listing-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.75rem;
            border-top: 1px solid #f3f4f6;
        }

        .listing-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--main-color-one);
        }

        .listing-views {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .listing-date {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 0.5rem;
        }

        .pagination-wrapper {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }

        .empty-listings {
            text-align: center;
            padding: 4rem 2rem;
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .empty-listings .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-listings h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--heading-color);
            margin-bottom: 0.5rem;
        }

        .empty-listings p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .empty-listings .cmn-btn1 {
            display: inline-flex;
        }

        @media (max-width: 768px) {
            .my-listings-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .listing-tabs {
                width: 100%;
                overflow-x: auto;
                flex-wrap: nowrap;
                padding-bottom: 0.5rem;
            }

            .listing-tab {
                white-space: nowrap;
            }

            .filters-row {
                flex-direction: column;
            }

            .search-box {
                min-width: 100%;
            }

            .sort-select {
                width: 100%;
            }

            .listings-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
@section('dashboard-content')
    <div class="my-listings-header">
        <h1>My Listings</h1>
        <a href="{{ route('ad.post.page') }}" class="cmn-btn1">
            <span>+</span> Post New Ad
        </a>
    </div>

    <div class="listing-tabs">
        <a href="{{ route('member.my.listings') }}" class="listing-tab {{ !request('status') ? 'active' : '' }}">
            All <span class="count">{{ $totalCount }}</span>
        </a>
        <a href="{{ route('member.my.listings', ['status' => 'active']) }}"
            class="listing-tab {{ request('status') == 'active' ? 'active' : '' }}">
            Active <span class="count">{{ $activeCount }}</span>
        </a>
        <a href="{{ route('member.my.listings', ['status' => 'inactive']) }}"
            class="listing-tab {{ request('status') == 'inactive' ? 'active' : '' }}">
            Inactive <span class="count">{{ $inactiveCount }}</span>
        </a>
        <a href="{{ route('member.my.listings', ['status' => 'sold']) }}"
            class="listing-tab {{ request('status') == 'sold' ? 'active' : '' }}">
            Sold <span class="count">{{ $soldCount }}</span>
        </a>
    </div>

    <form id="listings-filter-form" method="GET" action="{{ route('member.my.listings') }}">
        @if (request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <div class="filters-row">
            <div class="search-box">
                <span class="search-icon">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.33333 12.6667C10.2789 12.6667 12.6667 10.2789 12.6667 7.33333C12.6667 4.38781 10.2789 2 7.33333 2C4.38781 2 2 4.38781 2 7.33333C2 10.2789 4.38781 12.6667 7.33333 12.6667Z"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M14 14L11.1 11.1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
                <input type="text" name="q" placeholder="Search your listings..." value="{{ request('q') }}">
            </div>
            <select name="sortby" class="sort-select" onchange="this.form.submit()">
                <option value="">Sort by: Latest</option>
                <option value="oldest" {{ request('sortby') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                <option value="price_low" {{ request('sortby') == 'price_low' ? 'selected' : '' }}>Price: Low to High
                </option>
                <option value="price_high" {{ request('sortby') == 'price_high' ? 'selected' : '' }}>Price: High to Low
                </option>
            </select>
        </div>
    </form>

    @if ($ads->count() > 0)
        <div class="listings-grid">
            @foreach ($ads as $ad)
                <div class="listing-card">
                    <div class="listing-image">
                        <a href="{{ route('ad.details.page', $ad->uid) }}">
                            <img src="{{ asset(getFilePath($ad->thumbnail_image)) }}" alt="{{ $ad->title }}">
                        </a>

                        @if ($ad->is_sold == config('settings.general_status.active'))
                            <span class="listing-status sold">Sold</span>
                        @elseif($ad->is_featured == config('settings.general_status.active'))
                            <span class="listing-status featured">Featured</span>
                        @elseif($ad->status == config('settings.general_status.active'))
                            <span class="listing-status active">Active</span>
                        @else
                            <span class="listing-status inactive">Inactive</span>
                        @endif

                        <div class="listing-actions-overlay">
                            <a href="{{ route('ad.details.page', $ad->uid) }}" class="listing-action-btn" title="View">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 8C1 8 3.5 3 8 3C12.5 3 15 8 15 8C15 8 12.5 13 8 13C3.5 13 1 8 1 8Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M8 10C9.10457 10 10 9.10457 10 8C10 6.89543 9.10457 6 8 6C6.89543 6 6 6.89543 6 8C6 9.10457 6.89543 10 8 10Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                            <a href="{{ route('member.ad.edit', $ad->uid) }}" class="listing-action-btn" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.333 2.00004C11.5081 1.82494 11.716 1.68605 11.9447 1.59129C12.1735 1.49653 12.4187 1.44775 12.6663 1.44775C12.914 1.44775 13.1592 1.49653 13.3879 1.59129C13.6167 1.68605 13.8246 1.82494 13.9997 2.00004C14.1748 2.17513 14.3137 2.383 14.4084 2.61178C14.5032 2.84055 14.552 3.08575 14.552 3.33337C14.552 3.58099 14.5032 3.82619 14.4084 4.05497C14.3137 4.28374 14.1748 4.49161 13.9997 4.66671L4.99967 13.6667L1.33301 14.6667L2.33301 11L11.333 2.00004Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="listing-content">
                        <h3 class="listing-title">
                            <a href="{{ route('ad.details.page', $ad->uid) }}">{{ $ad->title }}</a>
                        </h3>

                        <div class="listing-meta">
                            <svg width="14" height="14" viewBox="0 0 16 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.99984 7.83332C5.99984 8.36376 6.21055 8.87246 6.58562 9.24754C6.9607 9.62261 7.4694 9.83332 7.99984 9.83332C8.53027 9.83332 9.03898 9.62261 9.41405 9.24754C9.78912 8.87246 9.99984 8.36376 9.99984 7.83332C9.99984 7.30289 9.78912 6.79418 9.41405 6.41911C9.03898 6.04404 8.53027 5.83332 7.99984 5.83332C7.4694 5.83332 6.9607 6.04404 6.58562 6.41911C6.21055 6.79418 5.99984 7.30289 5.99984 7.83332Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M11.7712 11.6047L8.94251 14.4333C8.6925 14.6831 8.35356 14.8234 8.00017 14.8234C7.64678 14.8234 7.30785 14.6831 7.05784 14.4333L4.22851 11.6047C3.48265 10.8588 2.97473 9.90845 2.76896 8.8739C2.5632 7.83934 2.66883 6.767 3.07251 5.79247C3.47618 4.81795 4.15977 3.98501 5.03683 3.39899C5.91388 2.81297 6.94502 2.50018 7.99984 2.50018C9.05466 2.50018 10.0858 2.81297 10.9629 3.39899C11.8399 3.98501 12.5235 4.81795 12.9272 5.79247C13.3308 6.767 13.4365 7.83934 13.2307 8.8739C13.0249 9.90845 12.517 10.8588 11.7712 11.6047Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>{{ $ad->cityInfo?->name ? $ad->cityInfo->name . ', ' . $ad->stateInfo?->name : 'Unknown Location' }}</span>
                        </div>

                        <div class="listing-footer">
                            <span class="listing-price">${{ number_format($ad->price, 2) }}</span>
                            <span class="listing-views">
                                <svg width="14" height="14" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 8C1 8 3.5 3 8 3C12.5 3 15 8 15 8C15 8 12.5 13 8 13C3.5 13 1 8 1 8Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M8 10C9.10457 10 10 9.10457 10 8C10 6.89543 9.10457 6 8 6C6.89543 6 6 6.89543 6 8C6 9.10457 6.89543 10 8 10Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                {{ $ad->view_counter ?? 0 }}
                            </span>
                        </div>

                        <div class="listing-date">
                            Posted {{ $ad->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($ads->hasPages())
            <div class="pagination-wrapper">
                {{ $ads->links() }}
            </div>
        @endif
    @else
        <div class="empty-listings">
            <div class="icon">📦</div>
            <h3>No listings found</h3>
            <p>
                @if (request('status') || request('q'))
                    No listings match your current filters. Try adjusting your search criteria.
                @else
                    You haven't posted any listings yet. Start by creating your first ad!
                @endif
            </p>
            @if (!request('status') && !request('q'))
                <a href="{{ route('ad.post.page') }}" class="cmn-btn1">
                    <span>+</span> Post Your First Ad
                </a>
            @else
                <a href="{{ route('member.my.listings') }}" class="cmn-btn">
                    View All Listings
                </a>
            @endif
        </div>
    @endif
@endsection
@section('dashboard-js')
    <script>
        (function($) {
            "use strict";

            // Search on enter key
            $('.search-box input').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#listings-filter-form').submit();
                }
            });
        })(jQuery);
    </script>
@endsection
