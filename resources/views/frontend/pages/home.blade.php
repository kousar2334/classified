@extends('frontend.layouts.master')
@section('meta')
    <title>{{ get_setting('site_name') }} - Classifieds ads</title>
    <title>{{ get_setting('site_name') }}: Your Gateway to Seamless Buying and Selling Experiences</title>
    <!-- Primary Meta Tags -->
    <meta name="title" content="Your Gateway to Seamless Buying and Selling Experiences">
    <meta name="description"
        content="Dive into the endless possibilities of buying and selling at ListOcean! Navigate a vast sea of opportunities as you connect with buyers and sellers effortlessly. Uncover incredible deals on a wide range of items or transform your unused items into treasure by listing them for sale. Immerse yourself in our dynamic community and enjoy the simplicity of buying and selling. Begin your oceanic journey today at ListOcean – where opportunities flow like waves!">
    <meta name="keywords"
        content="classified ads, free ads, buy and sell, online classifieds, cars, housing, electronics, community,Home & Livings,Fashion			,Sports	,Pet's & Animals">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Your Gateway to Seamless Buying and Selling Experiences">
    <meta property="og:description"
        content="Dive into the endless possibilities of buying and selling at ListOcean! Navigate a vast sea of opportunities as you connect with buyers and sellers effortlessly. Uncover incredible deals on a wide range of items or transform your unused items into treasure by listing them for sale. Immerse yourself in our dynamic community and enjoy the simplicity of buying and selling. Begin your oceanic journey today at ListOcean – where opportunities flow like waves!">
    <meta property="og:image" content="{{ asset('/public/uploads/media-uploader/icon1717328206.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="Your Gateway to Seamless Buying and Selling Experiences">
    <meta property="twitter:description"
        content="Dive into the endless possibilities of buying and selling at ListOcean! Navigate a vast sea of opportunities as you connect with buyers and sellers effortlessly. Uncover incredible deals on a wide range of items or transform your unused items into treasure by listing them for sale. Immerse yourself in our dynamic community and enjoy the simplicity of buying and selling. Begin your oceanic journey today at ListOcean – where opportunities flow like waves!">
    <meta property="twitter:description" content="{{ asset('/public/uploads/media-uploader/icon1717328206.png') }}">
@endsection
@section('content')
    <!--Banner part Start-->
    <section class="home-banner-v2"
        style="background-image: url({{ asset(get_setting('banner_bg_image', 'public/uploads/media-uploader/header1717328732.png')) }});">
        <div class="banner-v2-overlay"></div>

        <div class="container position-relative" style="z-index:1;">
            <div class="row align-items-center g-4 g-xl-5 banner-v2-row">

                <!-- Left: Text + Form + Stats -->
                <div class="col-xl-6 col-lg-7 col-md-12">

                    {{-- Badge --}}
                    @if (get_setting('banner_badge_text', '#1 Classified Ad Platform in the US'))
                        <div class="banner-v2-badge wow fadeInDown" data-wow-delay="0.1s">
                            <span class="badge-icon">&#127942;</span>
                            <span>{{ get_setting('banner_badge_text', '#1 Classified Ad Platform in the US') }}</span>
                        </div>
                    @endif

                    {{-- Main Heading --}}
                    <h1 class="banner-v2-title wow fadeInUp" data-wow-delay="0.2s">
                        {!! get_setting(
                            'banner_title',
                            'Buy <span class="banner-highlight">Anything</span> You Need,<br>Sell <span class="banner-highlight">Anything</span> You Want',
                        ) !!}
                    </h1>

                    {{-- Sub-description --}}
                    <p class="banner-v2-desc wow fadeInUp" data-wow-delay="0.3s">
                        {{ get_setting('banner_description', "Country's most loved and trusted classified ad listing website. Browse thousands of classified items near you.") }}
                    </p>

                    {{-- Search Form --}}
                    <div class="banner-v2-search-wrap wow fadeInUp" data-wow-delay="0.4s">
                        <form action="{{ route('ad.listing.page') }}"
                            class="d-flex align-items-stretch banner-search-location banner-v2-form" method="get">
                            <div class="banner-v2-inputs d-flex align-items-center flex-grow-1">
                                {{-- Keyword --}}
                                <div class="banner-v2-input-group flex-grow-1" style="position:relative;">
                                    <div class="banner-v2-input-icon">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                    <input class="banner-v2-field w-100" type="text" name="q" id="home_search"
                                        placeholder="What are you looking for?">
                                    <span id="all_search_result" class="search_with_text_section"></span>
                                </div>
                            </div>
                            <button type="submit" class="banner-v2-btn setLocation_btn">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span class="d-none d-sm-inline">Search</span>
                            </button>
                        </form>
                    </div>

                    {{-- Stats Bar --}}
                    <div class="banner-v2-stats wow fadeInUp" data-wow-delay="0.5s">
                        <div class="stat-pill">
                            <strong>{{ number_format($totalAdsCount) }}+</strong>
                            <span>Live Ads</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-pill">
                            <strong>{{ $categories->count() }}</strong>
                            <span>Categories</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-pill">
                            <strong>Free</strong>
                            <span>To Post</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Floating Category Cards --}}
                @if ($categories->count() > 0)
                    <div class="col-xl-6 col-lg-5 d-none d-lg-block">
                        <div class="banner-v2-categories wow fadeInRight" data-wow-delay="0.3s">
                            @foreach ($categories->take(6) as $cat)
                                <a href="{{ route('ad.listing.page', $cat->permalink) }}"
                                    class="banner-cat-card banner-cat-card-{{ $loop->iteration }}">
                                    <div class="banner-cat-icon">
                                        <img src="{{ asset(getFilePath($cat->icon)) }}" alt="{{ $cat->title }}" />
                                    </div>
                                    <span class="banner-cat-name">{{ $cat->title }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>
    <!--Banner part End-->
    <!--Google Adds-->
    <div class="google-adds" data-padding-top="50" data-padding-bottom="50">
        <div class="container">
            <div class="text-center single-banner-ads ads-banner-box" id="home_advertisement_store">
                <input type="hidden" id="add_id" value="2">
                <a href="#"><img src="/public/uploads/media-uploader/image-161717309429.png" alt="" /></a>
            </div>
        </div>
    </div>
    <!--Google Adds-->

    <!-- Categorie Area Start -->
    @if ($categories->count() > 0)
        <div class="exploreCategories" data-padding-top="50" data-padding-bottom="50"
            style="background-color: rgb(255, 255, 255)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-7 col-md-10 col-sm-10">
                        <div class="section-tittle">
                            <h2 class="tittle">Categories</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="global-slick-init slider-inner-margin sliderArrow" data-infinite="true"
                            data-arrows="true" data-dots="false" data-rtl="false" data-slidesToShow="8"
                            data-swipeToSlide="true" data-autoplay="false" data-autoplaySpeed="2500"
                            data-prevArrow='<div class="prev-icon"><i class="las la-angle-left"></i></div>'
                            data-nextArrow='<div class="next-icon"><i class="las la-angle-right"></i></div>'
                            data-responsive='[{"breakpoint": 1500,"settings": {"slidesToShow": 4}},{"breakpoint": 1600,"settings": {"slidesToShow": 4}},{"breakpoint": 1400,"settings": {"slidesToShow": 3}},{"breakpoint": 1200,"settings": {"slidesToShow": 3}},{"breakpoint": 991,"settings": {"slidesToShow": 2}},{"breakpoint": 768, "settings": {"slidesToShow": 2}},{"breakpoint": 576, "settings": {"slidesToShow": 1}}]'>
                            @foreach ($categories as $category)
                                <div class="singleCategories categories{{ $loop->iteration }} wow fadeInUp"
                                    data-wow-delay="0.1s">
                                    <div class="categoriIcon text-center">
                                        <a href="{{ route('ad.listing.page', $category->permalink) }}" class="title">
                                            <img src="{{ asset(getFilePath($category->icon)) }}"
                                                alt="{{ $category->title }}" />
                                        </a>
                                    </div>
                                    <div class="categorie-text">
                                        <h4 class="text-center">
                                            <a href="{{ route('ad.listing.page', $category->permalink) }}"
                                                class="title oneLine mt-2">{{ $category->title }}</a>
                                        </h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End-of Categories -->

    <!-- Top Listings Start -->
    @if ($topListings->count() > 0)
        <section class="featureListing" data-padding-top="50" data-padding-bottom="50" style="background-color:">
            <div class="container">
                <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                    <h2 class="head3">Top Listings</h2>
                    <form id="filter_with_listing_page_top" action="{{ route('ad.listing.page') }}" method="get">
                        <input type="hidden" name="listing_type_preferences" value="top_listing" />
                        <a href="javascript:void(0)" id="submit_form_listing_filter_top" class="see-all">See All <i
                                class="las la-angle-right"></i></a>
                    </form>
                </div>
                <div class="slider-inner-margin">
                    @foreach ($topListings as $ad)
                        <x-single-listing :ad="$ad" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- End-of Top Listings -->

    <!-- Category Wise Listings -->
    @foreach ($categoryWiseListings as $index => $catListing)
        <section class="featureListing" data-padding-top="50" data-padding-bottom="50" style="background-color:">
            <div class="container">
                <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                    <h2 class="head3">{{ $catListing['category']->title }}</h2>
                    <form id="filter_with_listing_page_category_wise_listing_{{ $catListing['category']->id }}"
                        action="{{ route('ad.listing.page') }}" method="get">
                        <input type="hidden" name="cat" value="{{ $catListing['category']->id }}" />
                        <a href="javascript:void(0)" class="submit_form_listing_filter_category_wise_listing see-all">See
                            all <i class="las la-angle-right"></i></a>
                    </form>
                </div>
                <div class="slider-inner-margin">
                    @foreach ($catListing['ads'] as $ad)
                        <x-single-listing :ad="$ad" />
                    @endforeach
                </div>
            </div>
        </section>

        @if ($index === 0)
            <!-- About/Promo Section -->
            <section class="aboutArea" data-padding-top="50" data-padding-bottom="50"
                style="background-color:rgb(255, 255, 255)">
                <div class="container">
                    <div class="aboutAreaWraper"
                        style="background-image: url(/public/uploads/media-uploader/group-343641717336658.png);">
                        <div class="row justify-content-between flex-lg-row flex-column-reverse gap-lg-0 gap-4">
                            <div class="col-lg-6">
                                <div class="about-caption">
                                    <div class="section-tittle section-tittle2 mb-80">
                                        <h2 class="head2 wow fadeInUp" data-wow-delay="0.1s">Earn cash by selling or Find
                                            anything you desire</h2>
                                        <p class="wow fadeInUp mt-3" data-wow-delay="0.2s">Earn cash by selling your
                                            pre-loved
                                            or new items on our platform or you can find anything on our platform you
                                            desire.
                                        </p>
                                    </div>
                                    <div class="btn-wrapper">
                                        <a href="{{ route('ad.post.page') }}" class="cmn-btn2 mr-15 mb-10 wow fadeInLeft"
                                            data-wow-delay="0.3s">Post Your Ads</a>
                                        <a href="{{ route('ad.listing.page') }}"
                                            class="cmn-btn2 transparent-btn mb-10 wow fadeInRight"
                                            data-wow-delay="0.3s">Browse ads</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="aboutImg tilt-effect wow fadeInRight ps-lg-5" data-wow-delay="0.1s">
                                    <img src="/public/uploads/media-uploader/about11713418479.png" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    @if (count($categoryWiseListings) === 0)
        <!-- About/Promo Section (shown if no category listings) -->
        <section class="aboutArea" data-padding-top="50" data-padding-bottom="50"
            style="background-color:rgb(255, 255, 255)">
            <div class="container">
                <div class="aboutAreaWraper"
                    style="background-image: url(/public/uploads/media-uploader/group-343641717336658.png);">
                    <div class="row justify-content-between flex-lg-row flex-column-reverse gap-lg-0 gap-4">
                        <div class="col-lg-6">
                            <div class="about-caption">
                                <div class="section-tittle section-tittle2 mb-80">
                                    <h2 class="head2 wow fadeInUp" data-wow-delay="0.1s">Earn cash by selling or Find
                                        anything you desire</h2>
                                    <p class="wow fadeInUp mt-3" data-wow-delay="0.2s">Earn cash by selling your pre-loved
                                        or new items on our platform or you can find anything on our platform you desire.
                                    </p>
                                </div>
                                <div class="btn-wrapper">
                                    <a href="{{ route('ad.post.page') }}" class="cmn-btn2 mr-15 mb-10 wow fadeInLeft"
                                        data-wow-delay="0.3s">Post Your Ads</a>
                                    <a href="{{ route('ad.listing.page') }}"
                                        class="cmn-btn2 transparent-btn mb-10 wow fadeInRight"
                                        data-wow-delay="0.3s">Browse ads</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="aboutImg tilt-effect wow fadeInRight ps-lg-5" data-wow-delay="0.1s">
                                <img src="/public/uploads/media-uploader/about11713418479.png" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Membership Card Start-->
    @if ($pricingPlans->count() > 0)
        <section class="pricingCard" data-padding-top="50" data-padding-bottom="50">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-7 col-md-10 col-sm-10">
                        <div class="section-tittle text-center mb-50">
                            <h2 class="head3">{{ translation('Membership') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($pricingPlans as $plan)
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            @include('frontend.includes.pricing-card', ['plan' => $plan])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- End-of Membership -->

    <!-- Recent Listings Start -->
    @if ($recentListings->count() > 0)
        <section class="featureListing" data-padding-top="50" data-padding-bottom="100"
            style="background-color:rgb(255, 255, 255)">
            <div class="container">
                <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                    <h2 class="head3">Recent Listing</h2>
                    <form id="filter_with_listing_page_recent" action="{{ route('ad.listing.page') }}" method="get">
                        <input type="hidden" name="sortby" value="latest_listing" />
                        <a href="javascript:void(0)" id="submit_form_listing_filter_recent" class="see-all">See All <i
                                class="las la-angle-right"></i></a>
                    </form>
                </div>
                <div class="slider-inner-margin">
                    @foreach ($recentListings as $ad)
                        <x-single-listing :ad="$ad" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- End-of Recent Listings -->

@endsection
