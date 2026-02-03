@extends('frontend.layouts.master')
@section('meta')
    <title>Listing 1- {{ get_setting('site_name') }}</title>
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

        .singleFeatureCard.inside_google_map_card {
            max-width: 200px !important;
            height: 181px !important;
        }

        .singleFeatureCard.inside_google_map_card .main-card-image {
            height: 111px !important;
        }

        .new-style .singleFeatureCard.inside_google_map_card .featurebody {
            height: auto !important;
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

        /* Price range dollar sign positioning */
        .priceRangeWraper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .priceRangeWraper .site_currency_symbol {
            position: absolute;
            left: 12px;
            color: #666;
            font-size: 14px;
            pointer-events: none;
            z-index: 1;
        }

        .priceRangeWraper input[type="number"] {
            padding-left: 28px !important;
        }

        /* ViewItems box styling */
        .viewItems {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .viewItems-header {
            background: linear-gradient(135deg, var(--main-color-one) 0%, #0056b3 100%);
            padding: 20px 25px;
            border-bottom: 3px solid rgba(0, 0, 0, 0.1);
        }

        .viewItems-title {
            color: #fff;
            font-size: 22px;
            font-weight: 600;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .SearchWrapper {
            padding: 20px 25px;
            background: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
        }

        .gridView {
            padding: 25px;
        }
    </style>
@endsection
@section('content')
    <div class="container-1920 plr1">
        <nav aria-label="breadcrumb" class="frontend-breadcrumb-wrap breadcrumb-nav-part">
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

    <div class="all-listing" data-padding-top="50" data-padding-bottom="100">
        <div class="container-1920 plr1">
            <!--Sidebar Icon-->
            <div class="sidebar-btn d-none">
                <a href="javascript:void(0)"><i class="las la-bars"></i></a>
            </div>

            <div class="catabody-wraper">
                <!-- Left Content -->
                <div class="cateLeftContent">
                    <form id="search_listings_form" method="GET"
                        action="{{ route('ad.listing.page', $category_slug ?? '') }}">
                        <!-- Hidden inputs for filter state -->
                        <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price') }}">
                        <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price') }}">
                        <input type="hidden" name="condition" id="condition" value="{{ request('condition') }}">
                        <input type="hidden" name="type" id="type" value="{{ request('type') }}">
                        <input type="hidden" name="date_posted" id="date_posted" value="{{ request('date_posted') }}">
                        <input type="hidden" name="sortby" id="sortby_hidden" value="{{ request('sortby') }}">

                        <div class="cateSidebar1">

                            <!--Search any title filter start -->
                            <div class="catagoriesWraper mb-4">
                                <div class="catagories w-100">
                                    <div class="single-category-service">
                                        <div class="single-select">
                                            <input type="text" class="search-input form-control" id="search_by_query"
                                                placeholder="Listing search" name="q" value="{{ request('q') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Search any title filter end -->

                            <!-- All Categories -->
                            <div class="catagoriesWraper mb-4">
                                <div class="catagories w-100">
                                    <h5 class="cateTitle mb-2 postdateTitle">Categories</h5>
                                    <input type="hidden" name="cat" id="selected_category"
                                        value="{{ request('cat') }}">
                                    <input type="hidden" name="subcat" id="selected_subcategory"
                                        value="{{ request('subcat') }}">
                                    <input type="hidden" name="child_cat" id="selected_child_category"
                                        value="{{ request('child_cat') }}">

                                    <!-- Parent Category List -->
                                    <div id="parent-category-section">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted small">Select Category</span>
                                        </div>
                                        <ul class="category-list" id="parent-category-list">
                                            @foreach ($categories as $category)
                                                <li class="category-item {{ request('cat') == $category->id && !request('subcat') ? 'active' : '' }}"
                                                    data-category-id="{{ $category->id }}"
                                                    data-category-name="{{ $category->title }}">
                                                    <a href="javascript:void(0)" class="category-link">
                                                        <i class="las la-angle-right"></i>
                                                        {{ $category->title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <!-- Subcategory List -->
                                    <div id="subcategory-section" style="display: none;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <a href="javascript:void(0)" id="back-to-parent-categories"
                                                class="text-primary small">
                                                <i class="las la-arrow-left"></i> Back to Categories
                                            </a>
                                            <span class="text-muted small" id="selected-category-name"></span>
                                        </div>
                                        <ul class="category-list" id="subcategory-list">
                                            <!-- Subcategories will be loaded here -->
                                        </ul>
                                    </div>

                                    <!-- Child Category List -->
                                    <div id="child-category-section" style="display: none;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <a href="javascript:void(0)" id="back-to-subcategories"
                                                class="text-primary small">
                                                <i class="las la-arrow-left"></i> Back to Subcategories
                                            </a>
                                            <span class="text-muted small" id="selected-subcategory-name"></span>
                                        </div>
                                        <ul class="category-list" id="child-category-list">
                                            <!-- Child categories will be loaded here -->
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
                                                <input type="number" class="input-min">
                                            </div>
                                        </div>
                                        <div class="separator">-</div>
                                        <div class="field">
                                            <div class="max_price_range priceRangeWraper">
                                                <span class="site_currency_symbol">$</span>
                                                <input type="number" class="input-max">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="price_range_setup">
                                        <div class="progress"></div>
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
                                    <ul class="postdate">
                                        <li><a href="javascript:void(0)" id="featured">Featured</a></li>
                                        <li><a href="javascript:void(0)" id="top_listing">Top Listing</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="catagoriesWraper mb-4">
                                <div class="catagories">
                                    <h5 class="cateTitle mb-2 postdateTitle">Condition</h5>
                                    <ul class="postdate">
                                        @foreach ($conditions as $condition)
                                            <li class="{{ request('condition') == $condition->id ? 'active' : '' }}">
                                                <a href="javascript:void(0)" class="condition-filter"
                                                    data-condition-id="{{ $condition->id }}">{{ $condition->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="catagoriesWraper mb-4">
                                <div class="catagories">
                                    <h5 class="cateTitle mb-2 postdateTitle">Date Posted</h5>
                                    <ul class="postdate">
                                        <li><a href="javascript:void(0)" id="today">Today</a></li>
                                        <li><a href="javascript:void(0)" id="yesterday">Yesterday</a></li>
                                        <li><a href="javascript:void(0)" id="last_week">Last Week</a></li>
                                    </ul>
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
                                <div class="viewItems-header">
                                    <h4 class="viewItems-title">Browse Listings</h4>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="SearchWrapper d-flex justify-content-between align-items-center">
                                            <!-- Custom Tab -->
                                            <div class="views align-items-center">
                                                <div class="sidebar-btn d-lg-none d-block">
                                                    <a href="javascript:void(0)"><i class="fa-solid fa-bars"></i></a>
                                                </div>
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
                                                    <div class="reset-btn cmn-filter-btn">
                                                        <a href="{{ route('ad.listing.page', $category_slug ?? '') }}">
                                                            <i class="las la-undo-alt"></i> Reset Filter
                                                        </a>
                                                    </div>
                                                @endif
                                                <div class="listing-btn">
                                                    <button class="customTab  active "
                                                        data-toggle-target=".customTab-content-1" id="card_grid">
                                                        <i class="las la-th-large fs-4"></i>
                                                    </button>
                                                    <button class="customTab " data-toggle-target=".customTab-content-2"
                                                        id="card_list">
                                                        <i class="las la-th-list fs-4"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Sort By Dropdown -->
                                            <div class="sort-by-wrapper">
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
                                            <div class="singleFeatureCard">
                                                <div class="featureImg">
                                                    <div class="favourite-icon">
                                                        <a href="javascript:void(0)" class="click_to_favorite_add_remove"
                                                            data-listing_id="{{ $ad->id }}">
                                                            <i class="lar la-heart icon favorite_add_icon"></i>
                                                        </a>
                                                    </div>
                                                    <a href="{{ route('ad.details.page', $ad->uid) }}"
                                                        class="main-card-image">
                                                        <img src="{{ $ad->thumbnail_image ? asset($ad->thumbnail_image) : asset('public/uploads/media-uploader/no-image.png') }}"
                                                            alt="{{ $ad->title }}" />
                                                    </a>
                                                </div>
                                                <div class="featurebody">
                                                    <div class="card-body-top">
                                                        <h4>
                                                            <a href="{{ route('ad.details.page', $ad->uid) }}"
                                                                class="featureTittle head4 twoLine">{{ $ad->title }}</a>
                                                        </h4>
                                                    </div>

                                                    <p class="featureCap d-flex align-items-center gap-1">
                                                        <svg width="16" height="17" viewBox="0 0 16 17"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M5.99984 7.83332C5.99984 8.36376 6.21055 8.87246 6.58562 9.24754C6.9607 9.62261 7.4694 9.83332 7.99984 9.83332C8.53027 9.83332 9.03898 9.62261 9.41405 9.24754C9.78912 8.87246 9.99984 8.36376 9.99984 7.83332C9.99984 7.30289 9.78912 6.79418 9.41405 6.41911C9.03898 6.04404 8.53027 5.83332 7.99984 5.83332C7.4694 5.83332 6.9607 6.04404 6.58562 6.41911C6.21055 6.79418 5.99984 7.30289 5.99984 7.83332Z"
                                                                stroke="#64748B" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                            <path
                                                                d="M11.7712 11.6047L8.94251 14.4333C8.6925 14.6831 8.35356 14.8234 8.00017 14.8234C7.64678 14.8234 7.30785 14.6831 7.05784 14.4333L4.22851 11.6047C3.48265 10.8588 2.97473 9.90845 2.76896 8.8739C2.5632 7.83934 2.66883 6.767 3.07251 5.79247C3.47618 4.81795 4.15977 3.98501 5.03683 3.39899C5.91388 2.81297 6.94502 2.50018 7.99984 2.50018C9.05466 2.50018 10.0858 2.81297 10.9629 3.39899C11.8399 3.98501 12.5235 4.81795 12.9272 5.79247C13.3308 6.767 13.4365 7.83934 13.2307 8.8739C13.0249 9.90845 12.517 10.8588 11.7712 11.6047Z"
                                                                stroke="#64748B" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                        <span
                                                            class="oneLine">{{ $ad->cityInfo->name ?? 'Unknown Location' }}</span>
                                                    </p>

                                                    @if ($ad->is_featured == config('settings.general_status.active'))
                                                        <div class="btn-wrapper">
                                                            <span class="pro-btn2">
                                                                <svg width="7" height="10" viewBox="0 0 7 10"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M4 0V3.88889H7L3 10V6.11111H0L4 0Z"
                                                                        fill="white" />
                                                                </svg> FEATURED
                                                            </span>
                                                        </div>
                                                    @endif

                                                    <span
                                                        class="featurePricing d-flex justify-content-between align-items-center">
                                                        <span class="money">${{ number_format($ad->price, 2) }}</span>
                                                        <span class="date">
                                                            {{ $ad->created_at->diffForHumans() }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-5 w-100">
                                                <i class="las la-inbox" style="font-size: 80px; color: #ccc;"></i>
                                                <h4 class="mt-3">No ads found</h4>
                                                <p class="text-muted">Try adjusting your filters to find what you're
                                                    looking for.</p>
                                            </div>
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
    <script>
        (function($) {
            "use strict";

            $(document).ready(function() {
                const SUBCATEGORY_ENDPOINT = '/ad/subcategories';
                const COUNTRIES_ENDPOINT = '/ad/countries';
                const STATES_ENDPOINT = '/ad/states';
                const CITIES_ENDPOINT = '/ad/cities';

                // ========== Category Hierarchical Selection ==========

                // Handle parent category click
                $(document).on('click', '#parent-category-list .category-link', function(e) {
                    e.preventDefault();
                    const $item = $(this).closest('.category-item');
                    const categoryId = $item.data('category-id');
                    const categoryName = $item.data('category-name');

                    // Load subcategories for this category
                    $.get(SUBCATEGORY_ENDPOINT, {
                        parent_id: categoryId
                    }, function(data) {
                        const $subcategoryList = $('#subcategory-list');
                        $subcategoryList.empty();

                        if (data.length > 0) {
                            data.forEach(function(subcat) {
                                const isActive = '{{ request('subcat') }}' == subcat
                                    .id ? 'active' : '';
                                $subcategoryList.append(`
                                    <li class="category-item ${isActive}" data-subcategory-id="${subcat.id}" data-subcategory-name="${subcat.title}">
                                        <a href="javascript:void(0)" class="category-link subcategory-link">
                                            <i class="las la-angle-right"></i>
                                            ${subcat.title}
                                        </a>
                                    </li>
                                `);
                            });

                            // Show subcategory section
                            $('#parent-category-section').hide();
                            $('#subcategory-section').show();
                            $('#selected-category-name').text(categoryName);
                            $('#selected_category').val(categoryId);
                        } else {
                            // No subcategories - directly apply category filter
                            $('#selected_category').val(categoryId);
                            $('#selected_subcategory').val('');
                            $('#selected_child_category').val('');
                            $('#search_listings_form').submit();
                        }
                    });
                });

                // Handle subcategory click
                $(document).on('click', '.subcategory-link', function(e) {
                    e.preventDefault();
                    const $item = $(this).closest('.category-item');
                    const subcategoryId = $item.data('subcategory-id');
                    const subcategoryName = $item.data('subcategory-name');

                    // Load child categories for this subcategory
                    $.get(SUBCATEGORY_ENDPOINT, {
                        parent_id: subcategoryId
                    }, function(data) {
                        const $childCategoryList = $('#child-category-list');
                        $childCategoryList.empty();

                        if (data.length > 0) {
                            data.forEach(function(childCat) {
                                const isActive = '{{ request('child_cat') }}' ==
                                    childCat.id ? 'active' : '';
                                $childCategoryList.append(`
                                    <li class="category-item ${isActive}" data-child-category-id="${childCat.id}">
                                        <a href="javascript:void(0)" class="category-link child-category-link">
                                            <i class="las la-angle-right"></i>
                                            ${childCat.title}
                                        </a>
                                    </li>
                                `);
                            });

                            // Show child category section
                            $('#subcategory-section').hide();
                            $('#child-category-section').show();
                            $('#selected-subcategory-name').text(subcategoryName);
                            $('#selected_subcategory').val(subcategoryId);
                        } else {
                            // No child categories - directly apply subcategory filter
                            $('#selected_subcategory').val(subcategoryId);
                            $('#selected_child_category').val('');
                            $('#search_listings_form').submit();
                        }
                    });
                });

                // Handle child category click
                $(document).on('click', '.child-category-link', function(e) {
                    e.preventDefault();
                    const $item = $(this).closest('.category-item');
                    const childCategoryId = $item.data('child-category-id');

                    $('.category-item').removeClass('active');
                    $item.addClass('active');

                    $('#selected_child_category').val(childCategoryId);
                    $('#search_listings_form').submit();
                });

                // Back to parent categories
                $('#back-to-parent-categories').on('click', function() {
                    $('#subcategory-section').hide();
                    $('#parent-category-section').show();
                    $('#selected_subcategory').val('');
                    $('#selected_child_category').val('');
                });

                // Back to subcategories
                $('#back-to-subcategories').on('click', function() {
                    $('#child-category-section').hide();
                    $('#subcategory-section').show();
                    $('#selected_child_category').val('');
                });

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

                    if (selectedCityId && selectedStateId && selectedCountryId) {
                        // Load country, then state, then city
                        $.get(COUNTRIES_ENDPOINT, function(countries) {
                            const country = countries.find(c => c.id == selectedCountryId);
                            if (country) {
                                $('#selected-country-name').text(country.text);
                                $('#selected_country').val(selectedCountryId);

                                $.get(STATES_ENDPOINT, {
                                    country_id: selectedCountryId
                                }, function(states) {
                                    const state = states.find(s => s.id == selectedStateId);
                                    if (state) {
                                        $('#selected-state-name').text(state.text);
                                        $('#selected_state').val(selectedStateId);

                                        $.get(CITIES_ENDPOINT, {
                                            state_id: selectedStateId
                                        }, function(cities) {
                                            const $cityList = $('#city-list');
                                            $cityList.empty();

                                            cities.forEach(function(city) {
                                                const isActive = selectedCityId == city.id ? 'active' : '';
                                                $cityList.append(`
                                                    <li class="location-item ${isActive}" data-city-id="${city.id}">
                                                        <a href="javascript:void(0)" class="location-link city-link">
                                                            <i class="las la-map-marker"></i>
                                                            ${city.text}
                                                        </a>
                                                    </li>
                                                `);
                                            });

                                            // Show city section
                                            $('#country-section').hide();
                                            $('#state-section').hide();
                                            $('#city-section').show();
                                        });
                                    }
                                });
                            }
                        });
                    } else if (selectedStateId && selectedCountryId) {
                        // Load country and state
                        $.get(COUNTRIES_ENDPOINT, function(countries) {
                            const country = countries.find(c => c.id == selectedCountryId);
                            if (country) {
                                $('#selected-country-name').text(country.text);
                                $('#selected_country').val(selectedCountryId);

                                $.get(STATES_ENDPOINT, {
                                    country_id: selectedCountryId
                                }, function(states) {
                                    const $stateList = $('#state-list');
                                    $stateList.empty();

                                    states.forEach(function(state) {
                                        const isActive = selectedStateId == state.id ? 'active' : '';
                                        $stateList.append(`
                                            <li class="location-item ${isActive}" data-state-id="${state.id}" data-state-name="${state.text}">
                                                <a href="javascript:void(0)" class="location-link state-link">
                                                    <i class="las la-angle-right"></i>
                                                    ${state.text}
                                                </a>
                                            </li>
                                        `);
                                    });

                                    // Show state section
                                    $('#country-section').hide();
                                    $('#state-section').show();
                                });
                            }
                        });
                    } else if (selectedCountryId) {
                        // Just load countries (they will be marked as active by the loadCountries function)
                        loadCountries();
                    } else {
                        // Load countries normally
                        loadCountries();
                    }
                }

                // Load countries on page load and restore filter
                restoreLocationFilter();

                // Handle country click
                $(document).on('click', '.country-link', function(e) {
                    e.preventDefault();
                    const $item = $(this).closest('.location-item');
                    const countryId = $item.data('country-id');
                    const countryName = $item.data('country-name');

                    // Load states for this country
                    $.get(STATES_ENDPOINT, {
                        country_id: countryId
                    }, function(data) {
                        const $stateList = $('#state-list');
                        $stateList.empty();

                        if (data.length > 0) {
                            data.forEach(function(state) {
                                const isActive = '{{ request('state') }}' == state.id ?
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

                            // Show state section
                            $('#country-section').hide();
                            $('#state-section').show();
                            $('#selected-country-name').text(countryName);
                            $('#selected_country').val(countryId);
                        } else {
                            // No states - directly apply country filter
                            $('#selected_country').val(countryId);
                            $('#selected_state').val('');
                            $('#selected_city').val('');
                            $('#search_listings_form').submit();
                        }
                    });
                });

                // Handle state click
                $(document).on('click', '.state-link', function(e) {
                    e.preventDefault();
                    const $item = $(this).closest('.location-item');
                    const stateId = $item.data('state-id');
                    const stateName = $item.data('state-name');

                    // Load cities for this state
                    $.get(CITIES_ENDPOINT, {
                        state_id: stateId
                    }, function(data) {
                        const $cityList = $('#city-list');
                        $cityList.empty();

                        if (data.length > 0) {
                            data.forEach(function(city) {
                                const isActive = '{{ request('city') }}' == city.id ?
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

                            // Show city section
                            $('#state-section').hide();
                            $('#city-section').show();
                            $('#selected-state-name').text(stateName);
                            $('#selected_state').val(stateId);
                        } else {
                            // No cities - directly apply state filter
                            $('#selected_state').val(stateId);
                            $('#selected_city').val('');
                            $('#search_listings_form').submit();
                        }
                    });
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

                // Back to countries
                $('#back-to-countries').on('click', function() {
                    $('#state-section').hide();
                    $('#country-section').show();
                    $('#selected_state').val('');
                    $('#selected_city').val('');
                });

                // Back to states
                $('#back-to-states').on('click', function() {
                    $('#city-section').hide();
                    $('#state-section').show();
                    $('#selected_city').val('');
                });

                // ========== Other Filters (keeping existing functionality) ==========

                // Search with debounce
                let searchTimeout;
                $('#search_by_query').on('keyup', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function() {
                        $('#search_listings_form').submit();
                    }, 800);
                });

                // Price Range Filter
                $('#price_wise_filter_apply').on('click', function() {
                    const minPrice = $('.input-min').val();
                    const maxPrice = $('.input-max').val();

                    $('#min_price').val(minPrice);
                    $('#max_price').val(maxPrice);

                    $('#search_listings_form').submit();
                });

                // Condition Filter
                $(document).on('click', '.condition-filter', function(e) {
                    e.preventDefault();
                    const conditionId = $(this).data('condition-id');

                    $('#condition').val(conditionId);
                    $('.condition-filter').parent().removeClass('active');
                    $(this).parent().addClass('active');

                    $('#search_listings_form').submit();
                });

                // Type Filter
                $('#featured, #top_listing').on('click', function(e) {
                    e.preventDefault();
                    const type = $(this).attr('id');

                    $('#type').val(type);
                    $('#featured, #top_listing').parent().removeClass('active');
                    $(this).parent().addClass('active');

                    $('#search_listings_form').submit();
                });

                // Date Posted Filter
                $('#today, #yesterday, #last_week').on('click', function(e) {
                    e.preventDefault();
                    const datePosted = $(this).attr('id');

                    $('#date_posted').val(datePosted);
                    $('#today, #yesterday, #last_week').parent().removeClass('active');
                    $(this).parent().addClass('active');

                    $('#search_listings_form').submit();
                });

                // Sorting Filter
                $('#search_by_sorting').on('change', function() {
                    const sortValue = $(this).val();
                    $('#sortby_hidden').val(sortValue);
                    $('#search_listings_form').submit();
                });

                // Highlight active filters on page load
                const currentType = '{{ request('type') }}';
                const currentDatePosted = '{{ request('date_posted') }}';

                if (currentType) {
                    $('#' + currentType).parent().addClass('active');
                }
                if (currentDatePosted) {
                    $('#' + currentDatePosted).parent().addClass('active');
                }

            });
        })(jQuery);
    </script>
@endsection
