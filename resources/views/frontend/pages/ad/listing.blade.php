@extends('frontend.layouts.master')
@section('meta')
    <title>Listing - {{ get_setting('site_name') }}</title>
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
    </style>
@endsection
@section('content')
    <div class=" container-1920 plr1 ">
        <nav aria-label="breadcrumb" class="frontend-breadcrumb-wrap breadcrumb-nav-part">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item66"><a href="listings.html#">Listings </a></li>
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
                    <div class="cateSidebar1">

                        <!--Search any title filter start -->
                        <div class="catagoriesWraper mb-4">
                            <div class="catagories w-100">
                                <div class="single-category-service">
                                    <div class="single-select">
                                        <input type="text" class="search-input form-control" id="search_by_query"
                                            placeholder="Listing search" name="q" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Search any title filter end -->

                        <!--Distance google map filter -->
                        <div class="catagoriesWraper mb-4">
                            <div class="catagories w-100">
                                <!-- autocomplete address -->
                                <div class="suburb_section_start">
                                    <input type="hidden" name="autocomplete_address" id="autocomplete_address">
                                    <input type="hidden" name="location_city_name" id="location_city_name">
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">
                                    <label class="cateTitle mb-2">Location</label>
                                    <input class="search-input form-control w-100 border-1 bg-white autocomplete_disable"
                                        name="autocomplete" id="autocomplete" placeholder="Enter a Location" type="text">
                                </div>

                                <!-- Distance range-->
                                <div id="distance-slider"></div>
                                <div class="slider-container slider-kilometer">
                                    <input type="hidden" name="distance_kilometers_value" id="distance_kilometers_value">
                                    <div class="cateTitle mb-2">Distance</div>
                                    <div id="slider" class="slider-range mt-2"></div>
                                    <div class="d-flex align-items-center gap-2 mt-2">
                                        <div id="slider-value" class="slider-range-value"></div>
                                        <span class="km_title_text">km</span>
                                    </div>
                                </div>

                                <!-- cancel and apply button start -->
                                <div class="cancel_apply_section_start text-end mb-2">
                                    <button type="button" class="filter-btn w-100"
                                        id="distance_wise_filter_apply">Filter</button>
                                </div>
                            </div>
                        </div>
                        <!--google map Distance filter end -->

                        <!-- All Categories -->
                        <div class="catagoriesWraper mb-4">
                            <div class="catagories w-100">
                                <select id="search_by_category" name="cat" class="categorySelect">
                                    <option value="">Category</option>
                                    <option value="1">Car &amp; Vehicles</option>
                                    <option value="2">Electronics</option>
                                    <option value="3">Home &amp; Livings</option>
                                    <option value="4">Fashion</option>
                                    <option value="5">Sports</option>
                                    <option value="6">Pet’s &amp; Animals</option>
                                    <option value="7">Appliances</option>
                                    <option value="8">Education</option>
                                    <option value="9">Mobile Phones</option>
                                </select>
                            </div>
                            <div class="catagories w-100">
                                <select id="search_by_subcategory" name="subcat" class="categorySelect">
                                    <option value="">Subcategory</option>
                                </select>
                            </div>
                            <div class="catagories">
                                <select id="search_by_child_category" name="child_cat" class="categorySelect">
                                    <option value="">Child Category</option>
                                </select>
                            </div>
                        </div>

                        <!-- Location -->



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
                                    <li><a href="javascript:void(0)" id="new">New</a></li>
                                    <li><a href="javascript:void(0)" id="used">Used</a></li>
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

                        <!-- Sort-by filter start -->
                        <div class="catagoriesWraper px-0">
                            <div class="catagories mx-3">
                                <select id="search_by_sorting" name="sortby">
                                    <option value="">Sort By</option>
                                    <option value="latest_listing">Latest listing</option>
                                    <option value="lowest_price">Lowest Price</option>
                                    <option value="highest_price">Highest Price</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Content -->
                <div class="cateRightContent  active-map  ">

                    <div class="cateRightContentWraper">
                        <div class="content-part">
                            <div class="viewItems">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="SearchWrapper d-flex justify-content-between align-items-start">
                                            <!-- Custom Tab -->
                                            <div class="views align-items-center">
                                                <div class="sidebar-btn d-lg-none d-block">
                                                    <a href="javascript:void(0)"><i class="fa-solid fa-bars"></i></a>
                                                </div>
                                                <div class="reset-btn cmn-filter-btn">
                                                    <a href="listings.html">
                                                        <button type="button">
                                                            <i class="las la-undo-alt"></i> Reset Filter
                                                        </button>
                                                    </a>
                                                </div>
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
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="gridView customTab-content customTab-content-1  active ">
                                <div class="gridViews">
                                    <div class="singleFeatureCardWraper d-flex">
                                        <div class="singleFeatureCard">
                                            <div class="featureImg">
                                                <div class="favourite-icon ">
                                                    <a href="javascript:void(0)" class="click_to_favorite_add_remove"
                                                        data-listing_id="1">
                                                        <i class="lar la-heart icon favorite_add_icon"></i>
                                                    </a>
                                                </div>
                                                <a href="listing/logitech-e19-computer-keyboard-for-sell.html"
                                                    class="main-card-image">
                                                    <img src="/public/uploads/media-uploader/listing10-11715593565.png"
                                                        alt="" />
                                                </a>
                                            </div>
                                            <div class="featurebody">
                                                <div class="card-body-top">
                                                    <h4> <a href="listing/logitech-e19-computer-keyboard-for-sell.html"
                                                            class="featureTittle head4 twoLine">Logitech E19 Computer
                                                            Keyboard for sell</a> </h4>
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
                                                    <span class="oneLine"> Dhaka, Bangladesh </span>
                                                </p>

                                                <div class="btn-wrapper">
                                                    <span class="pro-btn2">
                                                        <svg width="7" height="10" viewBox="0 0 7 10"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4 0V3.88889H7L3 10V6.11111H0L4 0Z" fill="white" />
                                                        </svg> FEATURED
                                                    </span>
                                                </div>

                                                <span
                                                    class="featurePricing d-flex justify-content-between align-items-center">
                                                    <span class="money">$500.00</span>
                                                    <span class="date">
                                                        1 year ago
                                                    </span>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                    <!-- Pagination -->
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="pagination mt-60">
                                <div class="blog-pagination">
                                    <div class="custom-pagination mt-4 mt-lg-5">
                                        <nav>
                                            <ul class="pagination">

                                                <li class="page-item disabled" aria-disabled="true"
                                                    aria-label="&laquo; Previous">
                                                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                                                </li>
                                                <li class="page-item active" aria-current="page"><span
                                                        class="page-link">1</span></li>
                                                <li class="page-item"><a class="page-link"
                                                        href="listings%3Fpage=2.html">2</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="listings%3Fpage=2.html" rel="next"
                                                        aria-label="Next &raquo;">&rsaquo;</a>
                                                </li>
                                            </ul>
                                        </nav>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
@endsection
