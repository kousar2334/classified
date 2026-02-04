@extends('frontend.layouts.master')
@section('meta')
    <title>Listing mb-3- {{ get_setting('site_name') }}</title>
    <!-- page css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css">
    <style>
        /*loader css start */
        .all_location_new_btn.btn-primary {
            background-color: var(--main-color-one);
            border-color: var(--main-color-one);
        }

        .loader-container {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #map-container {
            display: none;
            /* Initially hide the map container */
        }

        /*loader css end */

        /* new ======================*/
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        .slider-kilometer .slider-range {
            height: 8px;
            background: #ddd;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        .slider-kilometer .slider-range {
            height: 8px;
            background: #ddd;
        }

        .noUi-handle:after,
        .noUi-handle:before {
            display: none;
        }

        .noUi-touch-area {
            height: 100%;
            width: 100%;
            background: var(--main-color-one);
            border-radius: 50%;
        }

        .noUi-pips-horizontal {
            padding: 10px 0;
            height: 80px;
            top: 100%;
            left: 0;
            width: 100%;
            visibility: hidden;
            opacity: 0;
        }

        .noUi-connect {
            background: gray;
        }

        .noUi-horizontal .noUi-handle {
            width: 20px;
            height: 20px;
            right: -10px;
            top: -6px;
            border-radius: 50%;
        }

        .range-input {
            position: relative;
        }

        .range-input input {
            position: absolute;
            width: 100%;
            height: 5px;
            top: -5px;
            background: none;
            pointer-events: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        input[type="range"]::-webkit-slider-thumb {
            height: 17px;
            width: 17px;
            border-radius: 50%;
            background: #17A2B8;
            pointer-events: auto;
            -webkit-appearance: none;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
        }

        input[type="range"]::-moz-range-thumb {
            height: 17px;
            width: 17px;
            border: none;
            border-radius: 50%;
            background: #17A2B8;
            pointer-events: auto;
            -moz-appearance: none;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
        }

        /* Category and Location List Styles */
        .category-list,
        .subcategory-list,
        .location-list {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 300px;
            overflow-y: auto;
        }

        .category-item,
        .subcategory-item,
        .location-item {
            margin-bottom: 5px;
        }

        .category-link,
        .subcategory-link,
        .location-link {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .category-link:hover,
        .subcategory-link:hover,
        .location-link:hover {
            background-color: #f0f0f0;
            color: var(--main-color-one);
        }

        .category-item.active>.category-link,
        .subcategory-item.active>.subcategory-link,
        .location-item.active>.location-link {
            background-color: var(--main-color-one);
            color: white;
        }

        .category-arrow {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }

        .category-item.has-children.active>.category-link .category-arrow {
            transform: rotate(90deg);
        }

        .subcategory-list {
            padding-left: 20px;
            margin-top: 5px;
        }

        .location-list li {
            border-bottom: 1px solid #f0f0f0;
        }

        .location-list li:last-child {
            border-bottom: none;
        }

        #back-to-countries,
        #back-to-states,
        #back-to-parent-categories,
        #back-to-subcategories {
            cursor: pointer;
            font-weight: 500;
        }

        .category-list li {
            border-bottom: 1px solid #f0f0f0;
        }

        .category-list li:last-child {
            border-bottom: none;
        }

        .category-link i {
            margin-right: 8px;
        }

        /* Sort by dropdown styling */
        .sort-by-wrapper {
            min-width: 200px;
        }

        .sort-by-wrapper select {
            padding: 8px 35px 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .sort-by-wrapper select:focus {
            outline: none;
            border-color: var(--main-color-one);
        }

        .sort-by-wrapper select:hover {
            border-color: var(--main-color-one);
        }

        /* Filter Radio Button Styles */
        .filter-radio-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s ease;
            margin: 0;
            font-weight: normal;
        }

        .filter-radio-label:hover {
            background-color: #f0f0f0;
        }

        .filter-radio-label input[type="radio"] {
            accent-color: var(--main-color-one);
            width: 16px;
            height: 16px;
            cursor: pointer;
            margin: 0;
        }

        .filter-radio-label input[type="radio"]:checked+span {
            color: var(--main-color-one);
            font-weight: 500;
        }

        /* Fix dollar sign vertical alignment (override translationY typo in main-style.css) */
        .cateSidebar1 .catagoriesWraper .priceRangeWraper .site_currency_symbol {
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
            font-size: 14px;
            color: #555;
            z-index: 1;
        }

        .cateSidebar1 .catagoriesWraper .priceRangeWraper input {
            padding-left: 20px;
        }

        /* Price range slider styles */
        .price_range_setup {
            margin-top: 16px;
            margin-bottom: 8px;
        }

        .price_range_setup .noUi-horizontal {
            height: 6px;
            border: none;
            box-shadow: none;
            background: #e2e8f0;
            border-radius: 3px;
        }

        .price_range_setup .noUi-connect {
            background: var(--main-color-one);
        }

        .price_range_setup .noUi-handle {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--main-color-one);
            border: 2px solid #fff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            top: -7px;
            right: -9px;
        }

        .price_range_setup .noUi-handle::before,
        .price_range_setup .noUi-handle::after {
            display: none;
        }

        /* Search input button */
        #search_by_query_btn {
            z-index: 2;
            width: 40px;
            height: 100%;
            right: 0;
            top: 0;
            transform: none;
            background-color: var(--main-color-one);
            color: #fff;
            border-radius: 0 5px 5px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #search_by_query_btn:hover {
            opacity: 0.85;
        }

        /* Sidebar toggle button */
        .sidebar-btn a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            color: var(--main-color-one);
            font-size: 20px;
            text-decoration: none;
        }

        .sidebar-btn a:hover {
            border-color: var(--main-color-one);
            background-color: var(--main-color-one);
            color: #fff;
        }

        /* SearchWrapper layout */
        .SearchWrapper .search-top-row {
            width: 100%;
        }

        .SearchWrapper .content-title h4 {
            margin: 0;
            font-size: 18px;
        }

        .SearchWrapper .content-title p {
            font-size: 13px;
            color: #667085;
            margin: 0;
        }

        .SearchWrapper .sort-by-wrapper .form-select {
            width: max-content;
            font-size: 14px;
        }

        @media only screen and (max-width: 991.92px) {
            .SearchWrapper .sort-by-wrapper {
                width: 100%;
            }

            .SearchWrapper .sort-by-wrapper .form-select {
                width: 100%;
            }
        }

        /* Mobile sidebar overlay */
        @media only screen and (max-width: 991.92px) {
            .main-body .catabody-wraper .cateLeftContent {
                position: fixed;
                top: 0;
                left: -100%;
                width: 300px;
                height: 100vh;
                max-height: 100vh;
                overflow-y: auto;
                background: #fff;
                z-index: 1050;
                padding: 20px;
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
                border-radius: 0;
                transition: left 0.3s ease;
            }

            .main-body .catabody-wraper .cateLeftContent.show {
                left: 0;
            }

            /* Backdrop overlay */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
            }

            .sidebar-overlay.show {
                display: block;
            }

            /* Close button inside sidebar */
            .sidebar-close-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 32px;
                height: 32px;
                border: 1px solid #e2e8f0;
                border-radius: 50%;
                background: none;
                font-size: 18px;
                color: #333;
                cursor: pointer;
                margin-left: auto;
                margin-bottom: 15px;
            }

            .sidebar-close-btn:hover {
                background: #f1f5f9;
                border-color: var(--main-color-one);
                color: var(--main-color-one);
            }

        }
    </style>
@endsection
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" class="frontend-breadcrumb-wrap mt-3 mb-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ad.listing.page') }}">Listings</a></li>

                @if ($breadcrumbCategory)
                    <li class="breadcrumb-item {{ !$breadcrumbSubcategory && !$breadcrumbChildCategory ? 'active' : '' }}">
                        @if ($breadcrumbSubcategory || $breadcrumbChildCategory)
                            <a
                                href="{{ route('ad.listing.page') }}?cat={{ $breadcrumbCategory->id }}">{{ $breadcrumbCategory->title }}</a>
                        @else
                            {{ $breadcrumbCategory->title }}
                        @endif
                    </li>
                @endif

                @if ($breadcrumbSubcategory)
                    <li class="breadcrumb-item {{ !$breadcrumbChildCategory ? 'active' : '' }}">
                        @if ($breadcrumbChildCategory)
                            <a
                                href="{{ route('ad.listing.page') }}?cat={{ $breadcrumbCategory->id }}&subcat={{ $breadcrumbSubcategory->id }}">{{ $breadcrumbSubcategory->title }}</a>
                        @else
                            {{ $breadcrumbSubcategory->title }}
                        @endif
                    </li>
                @endif

                @if ($breadcrumbChildCategory)
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumbChildCategory->title }}</li>
                @endif

                @if ($breadcrumbCountry && !$breadcrumbCategory && !$breadcrumbSubcategory && !$breadcrumbChildCategory)
                    <li class="breadcrumb-item {{ !$breadcrumbState && !$breadcrumbCity ? 'active' : '' }}">
                        @if ($breadcrumbState || $breadcrumbCity)
                            <a
                                href="{{ route('ad.listing.page') }}?country={{ $breadcrumbCountry->id }}">{{ $breadcrumbCountry->name }}</a>
                        @else
                            {{ $breadcrumbCountry->name }}
                        @endif
                    </li>
                @endif

                @if ($breadcrumbState && !$breadcrumbCategory && !$breadcrumbSubcategory && !$breadcrumbChildCategory)
                    <li class="breadcrumb-item {{ !$breadcrumbCity ? 'active' : '' }}">
                        @if ($breadcrumbCity)
                            <a
                                href="{{ route('ad.listing.page') }}?country={{ $breadcrumbCountry->id }}&state={{ $breadcrumbState->id }}">{{ $breadcrumbState->name }}</a>
                        @else
                            {{ $breadcrumbState->name }}
                        @endif
                    </li>
                @endif

                @if ($breadcrumbCity && !$breadcrumbCategory && !$breadcrumbSubcategory && !$breadcrumbChildCategory)
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumbCity->name }}</li>
                @endif

                @if (
                    !$breadcrumbCategory &&
                        !$breadcrumbSubcategory &&
                        !$breadcrumbChildCategory &&
                        !$breadcrumbCountry &&
                        !$breadcrumbState &&
                        !$breadcrumbCity)
                    <li class="breadcrumb-item active" aria-current="page">All Listings</li>
                @endif
            </ol>
        </nav>
    </div>

    <div class="all-listing">
        <div class="container">
            <!-- Sidebar backdrop overlay -->
            <div class="sidebar-overlay" id="sidebar_overlay"></div>

            <div class="catabody-wraper">
                <!-- Left Content -->
                <div class="cateLeftContent">
                    <button type="button" class="sidebar-close-btn d-lg-none" id="sidebar_close_btn">
                        <i class="las la-times"></i>
                    </button>
                    @if (request()->hasAny([
                            'q',
                            'cat',
                            'subcat',
                            'child_cat',
                            'country',
                            'state',
                            'city',
                            'min_price',
                            'max_price',
                            'condition',
                            'type',
                            'date_posted',
                            'sortby',
                        ]))
                        <div class="reset-btn cmn-filter-btn mb-3">
                            <a href="{{ route('ad.listing.page', $category_slug ?? '') }}" class="btn btn-primary w-100">
                                <i class="las la-undo-alt"></i> {{ translation('Reset Filters') }}
                            </a>
                        </div>
                    @endif
                    <!--Search any title filter start -->
                    <div class="catagoriesWraper mb-4">
                        <div class="catagories w-100">
                            <div class="single-category-service">
                                <div class="single-select position-relative">
                                    <input type="text" class="search-input form-control pe-5" id="search_by_query"
                                        placeholder="Search here you want" value="{{ request('q') }}">
                                    <button type="button" id="search_by_query_btn" class="btn position-absolute border-0">
                                        <i class="las la-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Search any title filter end -->
                    <!-- Sort By Dropdown -->

                    <form id="search_listings_form" method="GET"
                        action="{{ route('ad.listing.page', $category_slug ?? '') }}">
                        <!-- Hidden inputs for filter state -->
                        <input type="hidden" name="q" id="search_q_hidden" value="{{ request('q') }}">
                        <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price') }}">
                        <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price') }}">
                        <input type="hidden" name="condition" id="condition" value="{{ request('condition') }}">
                        <input type="hidden" name="type" id="type" value="{{ request('type') }}">
                        <input type="hidden" name="date_posted" id="date_posted" value="{{ request('date_posted') }}">
                        <input type="hidden" name="sortby" id="sortby_hidden" value="{{ request('sortby') }}">

                        <div class="cateSidebar1">



                            <!-- All Categories -->
                            <div class="catagoriesWraper mb-4">
                                <div class="catagories w-100">
                                    <h5 class="cateTitle mb-2 postdateTitle">Categories</h5>
                                    <input type="hidden" name="cat_id" id="selected_category_id"
                                        value="{{ request('cat_id') }}">

                                    <!-- Category Section -->
                                    <div id="category-section">
                                        <!-- Back button (hidden for root level) -->
                                        <div id="back-button-container" class="mb-2" style="display: none;">
                                            <a href="javascript:void(0)" id="back-button" class="text-primary small">
                                                <i class="las la-arrow-left"></i> <span id="back-button-text">Back to
                                                    Categories</span>
                                            </a>
                                        </div>

                                        <!-- Selected Category Display (when has children) -->
                                        @if ($selectedCategory && $selectedCategoryId)
                                            <div id="selected-category-display" style="margin-left: 12px;">
                                                <strong style="color: var(--main-color-one); font-size: 16px;">
                                                    <i class="las la-folder-open" style="margin-right: 5px;"></i>
                                                    {{ $selectedCategory->title }}
                                                </strong>
                                            </div>
                                        @endif

                                        <!-- Category List -->
                                        <ul class="category-list" id="category-list">
                                            @foreach ($categories as $category)
                                                <li class="category-item {{ request('cat_id') == $category->id ? 'active' : '' }}"
                                                    data-category-id="{{ $category->id }}"
                                                    data-category-name="{{ $category->title }}"
                                                    data-parent-id="{{ $category->parent_id ?? '' }}"
                                                    data-parent-name="{{ $category->parent_title ?? '' }}">
                                                    <a href="javascript:void(0)" class="category-link">
                                                        <i class="las la-angle-right"></i>
                                                        {{ $category->title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Filter -->
                            <div class="catagoriesWraper mb-4">
                                <div class="catagories w-100">
                                    <h5 class="cateTitle mb-2 postdateTitle">Location</h5>
                                    <input type="hidden" name="country" id="selected_country"
                                        value="{{ request('country') }}">
                                    <input type="hidden" name="state" id="selected_state"
                                        value="{{ request('state') }}">
                                    <input type="hidden" name="city" id="selected_city"
                                        value="{{ request('city') }}">

                                    <!-- Country List -->
                                    <div id="country-section">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted small">Select Country</span>
                                        </div>
                                        <ul class="location-list" id="country-list">
                                            <!-- Countries will be loaded here -->
                                        </ul>
                                    </div>

                                    <!-- State List -->
                                    <div id="state-section" style="display: none;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <a href="javascript:void(0)" id="back-to-countries"
                                                class="text-primary small">
                                                <i class="las la-arrow-left"></i> Back to Countries
                                            </a>
                                            <span class="text-muted small" id="selected-country-name"></span>
                                        </div>
                                        <ul class="location-list" id="state-list">
                                            <!-- States will be loaded here -->
                                        </ul>
                                    </div>

                                    <!-- City List -->
                                    <div id="city-section" style="display: none;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <a href="javascript:void(0)" id="back-to-states" class="text-primary small">
                                                <i class="las la-arrow-left"></i> Back to States
                                            </a>
                                            <span class="text-muted small" id="selected-state-name"></span>
                                        </div>
                                        <ul class="location-list" id="city-list">
                                            <!-- Cities will be loaded here -->
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!--price range filter -->
                            <div class="catagoriesWraper mb-4">
                                <div class="catagories priceRange">
                                    <h5 class="cateTitle mb-2 postdateTitle">Price Range</h5>
                                    <input type="hidden" name="price_range_value" id="price_range_value">
                                    <div class="price-input">
                                        <div class="field">
                                            <div class="min_price_range priceRangeWraper">
                                                <span class="site_currency_symbol">$</span>
                                                <input type="number" class="input-min"
                                                    value="{{ request('min_price', 0) }}">
                                            </div>
                                        </div>
                                        <div class="separator">-</div>
                                        <div class="field">
                                            <div class="max_price_range priceRangeWraper">
                                                <span class="site_currency_symbol">$</span>
                                                <input type="number" class="input-max"
                                                    value="{{ request('max_price', 50000) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="price_range_setup">
                                        <div id="price-slider"></div>
                                    </div>
                                    <!-- cancel and apply button start -->
                                    <div class="cancel_apply_section_start mt-3">
                                        <button type="button" class="filter-btn w-100"
                                            id="price_wise_filter_apply">Filter</button>
                                    </div>
                                </div>
                            </div>
                            <!--price range filter end -->

                            <div class="catagoriesWraper mb-4">
                                <div class="catagories">
                                    <h5 class="cateTitle mb-2 postdateTitle">Types</h5>
                                    <div class="filter-radio-group">
                                        <label class="filter-radio-label">
                                            <input type="radio" name="type_radio" value="featured"
                                                {{ request('type') == 'featured' ? 'checked' : '' }}>
                                            <span>Featured</span>
                                        </label>
                                        <label class="filter-radio-label">
                                            <input type="radio" name="type_radio" value="top_listing"
                                                {{ request('type') == 'top_listing' ? 'checked' : '' }}>
                                            <span>Top Listing</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="catagoriesWraper mb-4">
                                <div class="catagories">
                                    <h5 class="cateTitle mb-2 postdateTitle">Condition</h5>
                                    <div class="filter-radio-group">
                                        @foreach ($conditions as $condition)
                                            <label class="filter-radio-label">
                                                <input type="radio" name="condition_radio"
                                                    value="{{ $condition->id }}"
                                                    {{ request('condition') == $condition->id ? 'checked' : '' }}>
                                                <span>{{ $condition->title }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="catagoriesWraper mb-4">
                                <div class="catagories">
                                    <h5 class="cateTitle mb-2 postdateTitle">Date Posted</h5>
                                    <div class="filter-radio-group">
                                        <label class="filter-radio-label">
                                            <input type="radio" name="date_posted_radio" value="today"
                                                {{ request('date_posted') == 'today' ? 'checked' : '' }}>
                                            <span>Today</span>
                                        </label>
                                        <label class="filter-radio-label">
                                            <input type="radio" name="date_posted_radio" value="yesterday"
                                                {{ request('date_posted') == 'yesterday' ? 'checked' : '' }}>
                                            <span>Yesterday</span>
                                        </label>
                                        <label class="filter-radio-label">
                                            <input type="radio" name="date_posted_radio" value="last_week"
                                                {{ request('date_posted') == 'last_week' ? 'checked' : '' }}>
                                            <span>Last Week</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- Right Content -->
                <div class="cateRightContent">

                    <div class="cateRightContentWraper">
                        <div class="content-part">
                            <div class="viewItems">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="SearchWrapper p-2">
                                            <div class="search-top-row d-flex justify-content-between align-items-center">
                                                <div class="content-title">
                                                    <h4>
                                                        @if ($breadcrumbChildCategory)
                                                            {{ $breadcrumbChildCategory->title }}
                                                        @elseif($breadcrumbSubcategory)
                                                            {{ $breadcrumbSubcategory->title }}
                                                        @elseif($breadcrumbCategory)
                                                            {{ $breadcrumbCategory->title }}
                                                        @else
                                                            All Ads
                                                        @endif
                                                    </h4>
                                                    <p class="mb-0">{{ $ads->total() }}
                                                        {{ $ads->total() == 1 ? 'Ad' : 'Ads' }} found</p>
                                                </div>
                                                <div class="sidebar-btn d-lg-none">
                                                    <a href="javascript:void(0)"><i class="las la-bars"></i></a>
                                                </div>
                                            </div>
                                            <div class="sort-by-wrapper mt-2">
                                                <select id="search_by_sorting" class="form-select">
                                                    <option value="">Sort By</option>
                                                    <option value="latest_listing"
                                                        {{ request('sortby') == 'latest_listing' ? 'selected' : '' }}>
                                                        Latest Listing
                                                    </option>
                                                    <option value="lowest_price"
                                                        {{ request('sortby') == 'lowest_price' ? 'selected' : '' }}>Lowest
                                                        Price
                                                    </option>
                                                    <option value="highest_price"
                                                        {{ request('sortby') == 'highest_price' ? 'selected' : '' }}>
                                                        Highest Price
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="gridView customTab-content customTab-content-1 active">
                                <div class="gridViews">
                                    <div class="singleFeatureCardWraper d-flex" id="ads-container">
                                        @forelse($ads as $ad)
                                            <x-single-listing :d="$ad" />
                                        @empty
                                            <x-empty-result title="No Ads found"
                                                message="Try adjusting your filters to find what you're looking for" />
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Pagination -->
                    @if ($ads->hasPages())
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="pagination mt-60">
                                    <div class="blog-pagination">
                                        <div class="custom-pagination mt-4 mt-lg-5">
                                            {{ $ads->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js"></script>
    <script>
        (function($) {
            "use strict";

            $(document).ready(function() {
                const SUBCATEGORY_ENDPOINT = '/ad/subcategories';

                // ========== Price Range Slider ==========
                const priceSliderEl = document.getElementById('price-slider');
                if (priceSliderEl) {
                    const minVal = parseInt($('.input-min').val()) || 0;
                    const maxVal = parseInt($('.input-max').val()) || 50000;

                    noUiSlider.create(priceSliderEl, {
                        start: [minVal, maxVal],
                        connect: true,
                        range: {
                            'min': 0,
                            'max': 50000
                        },
                        step: 100,
                        format: {
                            to: function(value) {
                                return Math.round(value);
                            },
                            from: function(value) {
                                return Number(value);
                            }
                        }
                    });

                    // Sync slider to inputs
                    priceSliderEl.noUiSlider.on('update', function(values) {
                        $('.input-min').val(values[0]);
                        $('.input-max').val(values[1]);
                    });

                    // Sync inputs to slider
                    $('.input-min').on('change', function() {
                        priceSliderEl.noUiSlider.set([$(this).val(), null]);
                    });
                    $('.input-max').on('change', function() {
                        priceSliderEl.noUiSlider.set([null, $(this).val()]);
                    });
                }
                const COUNTRIES_ENDPOINT = '/ad/countries';
                const STATES_ENDPOINT = '/ad/states';
                const CITIES_ENDPOINT = '/ad/cities';

                // ========== Category Navigation System ==========

                let categoryHierarchy = {}; // Store parent relationships as we navigate

                // Handle category click
                $(document).on('click', '#category-list .category-link', function(e) {
                    e.preventDefault();
                    const $item = $(this).closest('.category-item');
                    const categoryId = $item.data('category-id');
                    const categoryName = $item.data('category-name');
                    const parentId = $item.data('parent-id');
                    const parentName = $item.data('parent-name');

                    // Store parent relationship for back navigation
                    if (parentId) {
                        categoryHierarchy[categoryId] = {
                            parentId: parentId,
                            parentName: parentName
                        };
                    }

                    // Set selected category and submit form
                    $('#selected_category_id').val(categoryId);
                    $('#search_listings_form').submit();
                });

                // Handle back button click
                $('#back-button').on('click', function() {
                    const selectedCategoryId = '{{ request('cat_id') }}';
                    const parentInfo = categoryHierarchy[selectedCategoryId];

                    if (parentInfo && parentInfo.parentId) {
                        // Go to parent category
                        $('#selected_category_id').val(parentInfo.parentId);
                    } else {
                        // Go to root (clear category filter)
                        $('#selected_category_id').val('');
                    }
                    $('#search_listings_form').submit();
                });

                // Load and display categories on page load
                function loadCategories() {
                    const selectedCategoryId = '{{ request('cat_id') }}';

                    if (!selectedCategoryId) {
                        // No category selected - already showing root categories from backend
                        $('#back-button-container').hide();
                        return;
                    }

                    // Try to load children of selected category
                    $.get(SUBCATEGORY_ENDPOINT, {
                        parent_id: selectedCategoryId
                    }, function(children) {
                        const $categoryList = $('#category-list');

                        if (children.length > 0) {
                            // Selected category HAS children - show them
                            $categoryList.empty();
                            // Remove any existing selected category display
                            $('#selected-category-display').remove();

                            // Extract parent info from first child (all children share same parent)
                            const currentCategoryTitle = children[0].parent_title ||
                                'Selected Category';
                            const currentCategoryParentId = children[0].parent_id || null;
                            const currentCategoryGrandparentTitle = children[0].grandparent_title ||
                                null;

                            // Show selected category display
                            let selectedCategoryHtml = `
                                <div id="selected-category-display" style="margin-left: 12px;">
                                    <strong style="color: var(--main-color-one); font-size: 16px;">
                                        <i class="las la-folder-open" style="margin-right: 5px;"></i>
                                        ${currentCategoryTitle}
                                    </strong>
                                </div>
                            `;
                            $('#back-button-container').after(selectedCategoryHtml);

                            children.forEach(function(child) {
                                $categoryList.append(`
                                    <li class="category-item"
                                        data-category-id="${child.id}"
                                        data-category-name="${child.title}"
                                        data-parent-id="${selectedCategoryId}"
                                        data-parent-name="${currentCategoryTitle}">
                                        <a href="javascript:void(0)" class="category-link">
                                            <i class="las la-angle-right"></i>
                                            ${child.title}
                                        </a>
                                    </li>
                                `);

                                // Store parent relationship for each child
                                categoryHierarchy[child.id] = {
                                    parentId: selectedCategoryId,
                                    parentName: currentCategoryTitle
                                };
                            });

                            // Store current category's parent relationship for back navigation
                            if (currentCategoryParentId) {
                                categoryHierarchy[selectedCategoryId] = {
                                    parentId: currentCategoryParentId,
                                    parentName: currentCategoryGrandparentTitle || 'Categories'
                                };
                                $('#back-button-text').text('Back to ' +
                                    currentCategoryGrandparentTitle);
                            } else {
                                // Current category is at root level
                                categoryHierarchy[selectedCategoryId] = {
                                    parentId: null,
                                    parentName: 'Categories'
                                };
                                $('#back-button-text').text('Back to Categories');
                            }

                            $('#back-button-container').show();
                        } else {
                            // Selected category has NO children - keep showing current level with selected active
                            // Remove selected category display if exists
                            $('#selected-category-display').remove();

                            $('#category-list .category-item').removeClass('active');
                            $(`.category-item[data-category-id="${selectedCategoryId}"]`).addClass(
                                'active');

                            // Get parent info from the list item
                            const $selectedItem = $(
                                `.category-item[data-category-id="${selectedCategoryId}"]`);
                            const parentId = $selectedItem.data('parent-id');
                            const parentName = $selectedItem.data('parent-name');

                            if (parentName) {
                                $('#back-button-text').text('Back to ' + parentName);

                                // Store for back navigation
                                if (!categoryHierarchy[selectedCategoryId]) {
                                    categoryHierarchy[selectedCategoryId] = {
                                        parentId: parentId,
                                        parentName: parentName
                                    };
                                }
                            } else {
                                $('#back-button-text').text('Back to Categories');
                            }

                            $('#back-button-container').show();
                        }
                    });
                }

                // Store parent relationships from initial page load
                $('#category-list .category-item').each(function() {
                    const catId = $(this).data('category-id');
                    const parentId = $(this).data('parent-id');
                    const parentName = $(this).data('parent-name');

                    if (parentId) {
                        categoryHierarchy[catId] = {
                            parentId: parentId,
                            parentName: parentName
                        };
                    }
                });

                // Initialize categories on page load
                loadCategories();

                // ========== Location Hierarchical Selection ==========

                // Load countries on page load
                function loadCountries(callback) {
                    $.get(COUNTRIES_ENDPOINT, function(data) {
                        const $countryList = $('#country-list');
                        $countryList.empty();

                        if (data.length > 0) {
                            data.forEach(function(country) {
                                const isActive = '{{ request('country') }}' == country.id ?
                                    'active' : '';
                                $countryList.append(`
                                    <li class="location-item ${isActive}" data-country-id="${country.id}" data-country-name="${country.text}">
                                        <a href="javascript:void(0)" class="location-link country-link">
                                            <i class="las la-angle-right"></i>
                                            ${country.text}
                                        </a>
                                    </li>
                                `);
                            });
                        } else {
                            $countryList.append(
                                '<li class="text-muted small p-2">No countries available</li>');
                        }

                        if (callback) callback();
                    });
                }

                // Function to restore location filter based on URL parameters
                function restoreLocationFilter() {
                    const selectedCountryId = '{{ request('country') }}';
                    const selectedStateId = '{{ request('state') }}';
                    const selectedCityId = '{{ request('city') }}';

                    // Always load countries first so back navigation works
                    loadCountries(function() {
                        if (selectedCityId && selectedStateId && selectedCountryId) {
                            // Restore city view
                            $.get(COUNTRIES_ENDPOINT, function(countries) {
                                const country = countries.find(c => c.id == selectedCountryId);
                                if (country) {
                                    $('#selected-country-name').text(country.text);
                                }
                            });

                            $.get(STATES_ENDPOINT, {
                                country_id: selectedCountryId
                            }, function(states) {
                                // Populate state list for back navigation
                                const $stateList = $('#state-list');
                                $stateList.empty();
                                states.forEach(function(state) {
                                    const isActive = selectedStateId == state.id ?
                                        'active' : '';
                                    $stateList.append(`
                                        <li class="location-item ${isActive}" data-state-id="${state.id}" data-state-name="${state.text}">
                                            <a href="javascript:void(0)" class="location-link state-link">
                                                <i class="las la-angle-right"></i>
                                                ${state.text}
                                            </a>
                                        </li>
                                    `);
                                });

                                const state = states.find(s => s.id == selectedStateId);
                                if (state) {
                                    $('#selected-state-name').text(state.text);
                                }
                            });

                            $.get(CITIES_ENDPOINT, {
                                state_id: selectedStateId
                            }, function(cities) {
                                const $cityList = $('#city-list');
                                $cityList.empty();
                                cities.forEach(function(city) {
                                    const isActive = selectedCityId == city.id ?
                                        'active' : '';
                                    $cityList.append(`
                                        <li class="location-item ${isActive}" data-city-id="${city.id}">
                                            <a href="javascript:void(0)" class="location-link city-link">
                                                <i class="las la-map-marker"></i>
                                                ${city.text}
                                            </a>
                                        </li>
                                    `);
                                });

                                $('#country-section').hide();
                                $('#state-section').hide();
                                $('#city-section').show();
                            });

                        } else if (selectedStateId && selectedCountryId) {
                            // Restore city view for selected state
                            $.get(COUNTRIES_ENDPOINT, function(countries) {
                                const country = countries.find(c => c.id == selectedCountryId);
                                if (country) {
                                    $('#selected-country-name').text(country.text);
                                }
                            });

                            // Populate state list for back navigation
                            $.get(STATES_ENDPOINT, {
                                country_id: selectedCountryId
                            }, function(states) {
                                const $stateList = $('#state-list');
                                $stateList.empty();
                                states.forEach(function(state) {
                                    const isActive = selectedStateId == state.id ?
                                        'active' : '';
                                    $stateList.append(`
                                        <li class="location-item ${isActive}" data-state-id="${state.id}" data-state-name="${state.text}">
                                            <a href="javascript:void(0)" class="location-link state-link">
                                                <i class="las la-angle-right"></i>
                                                ${state.text}
                                            </a>
                                        </li>
                                    `);
                                });

                                const state = states.find(s => s.id == selectedStateId);
                                if (state) {
                                    $('#selected-state-name').text(state.text);
                                }
                            });

                            // Check if selected state has cities
                            $.get(CITIES_ENDPOINT, {
                                state_id: selectedStateId
                            }, function(cities) {
                                if (cities.length > 0) {
                                    const $cityList = $('#city-list');
                                    $cityList.empty();
                                    cities.forEach(function(city) {
                                        $cityList.append(`
                                            <li class="location-item" data-city-id="${city.id}">
                                                <a href="javascript:void(0)" class="location-link city-link">
                                                    <i class="las la-map-marker"></i>
                                                    ${city.text}
                                                </a>
                                            </li>
                                        `);
                                    });

                                    $('#country-section').hide();
                                    $('#state-section').hide();
                                    $('#city-section').show();
                                } else {
                                    // No cities - show states with selected one active
                                    $('#country-section').hide();
                                    $('#state-section').show();
                                }
                            });

                        } else if (selectedCountryId) {
                            // Check if selected country has states
                            $.get(STATES_ENDPOINT, {
                                country_id: selectedCountryId
                            }, function(states) {
                                if (states.length > 0) {
                                    const $stateList = $('#state-list');
                                    $stateList.empty();
                                    states.forEach(function(state) {
                                        $stateList.append(`
                                            <li class="location-item" data-state-id="${state.id}" data-state-name="${state.text}">
                                                <a href="javascript:void(0)" class="location-link state-link">
                                                    <i class="las la-angle-right"></i>
                                                    ${state.text}
                                                </a>
                                            </li>
                                        `);
                                    });

                                    $.get(COUNTRIES_ENDPOINT, function(countries) {
                                        const country = countries.find(c => c.id ==
                                            selectedCountryId);
                                        if (country) {
                                            $('#selected-country-name').text(country
                                                .text);
                                        }
                                    });

                                    $('#country-section').hide();
                                    $('#state-section').show();
                                }
                                // If no states, countries are already shown with active state from loadCountries
                            });
                        }
                        // If no location selected, countries are already loaded and shown
                    });
                }

                // Load countries on page load and restore filter
                restoreLocationFilter();

                // Handle country click - always filter by country
                $(document).on('click', '.country-link', function(e) {
                    e.preventDefault();
                    const $item = $(this).closest('.location-item');
                    const countryId = $item.data('country-id');

                    $('#selected_country').val(countryId);
                    $('#selected_state').val('');
                    $('#selected_city').val('');
                    $('#search_listings_form').submit();
                });

                // Handle state click - always filter by state
                $(document).on('click', '.state-link', function(e) {
                    e.preventDefault();
                    const $item = $(this).closest('.location-item');
                    const stateId = $item.data('state-id');

                    $('#selected_state').val(stateId);
                    $('#selected_city').val('');
                    $('#search_listings_form').submit();
                });

                // Handle city click
                $(document).on('click', '.city-link', function(e) {
                    e.preventDefault();
                    const $item = $(this).closest('.location-item');
                    const cityId = $item.data('city-id');

                    $('.location-item').removeClass('active');
                    $item.addClass('active');

                    $('#selected_city').val(cityId);
                    $('#search_listings_form').submit();
                });

                // Back to countries - clear all location filters and reload
                $('#back-to-countries').on('click', function() {
                    $('#selected_country').val('');
                    $('#selected_state').val('');
                    $('#selected_city').val('');
                    $('#search_listings_form').submit();
                });

                // Back to states - clear state/city and reload with country only
                $('#back-to-states').on('click', function() {
                    $('#selected_state').val('');
                    $('#selected_city').val('');
                    $('#search_listings_form').submit();
                });

                // ========== Other Filters (keeping existing functionality) ==========

                // Price Range Filter
                $('#price_wise_filter_apply').on('click', function() {
                    const minPrice = $('.input-min').val();
                    const maxPrice = $('.input-max').val();

                    $('#min_price').val(minPrice);
                    $('#max_price').val(maxPrice);

                    $('#search_listings_form').submit();
                });

                // Condition Filter
                $('input[name="condition_radio"]').on('change', function() {
                    $('#condition').val($(this).val());
                    $('#search_listings_form').submit();
                });

                // Type Filter
                $('input[name="type_radio"]').on('change', function() {
                    $('#type').val($(this).val());
                    $('#search_listings_form').submit();
                });

                // Date Posted Filter
                $('input[name="date_posted_radio"]').on('change', function() {
                    $('#date_posted').val($(this).val());
                    $('#search_listings_form').submit();
                });

                // Sorting Filter
                $('#search_by_sorting').on('change', function() {
                    const sortValue = $(this).val();
                    $('#sortby_hidden').val(sortValue);
                    $('#search_listings_form').submit();
                });

                // Active filter states are handled by checked attribute on radio buttons

            });
        })(jQuery);
    </script>
@endsection
