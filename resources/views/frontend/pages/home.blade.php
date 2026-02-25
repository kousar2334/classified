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
    @php
        $promoPrinted = false;
    @endphp

    @foreach ($homeSections as $section)
        @switch($section->key)
            {{-- ═══════════════════════════ BANNER ═══════════════════════════ --}}
            @case('banner')
                <section class="home-banner-v2"
                    style="background-image: url({{ asset(get_setting('banner_bg_image', 'public/uploads/media-uploader/header1717328732.png')) }});">
                    <div class="banner-v2-overlay"></div>

                    <div class="banner-orb banner-orb-1"></div>
                    <div class="banner-orb banner-orb-2"></div>
                    <div class="banner-orb banner-orb-3"></div>

                    <div class="container position-relative" style="z-index:1;">
                        <div class="banner-v3-wrap">

                            @php $badgeText = p_trans('home_banner_badge', null, get_setting('banner_badge_text', '#1 Classified Ad Platform in the US')); @endphp
                            @if ($badgeText)
                                <div class="banner-v2-badge wow fadeInDown" data-wow-delay="0.1s">
                                    <span class="badge-icon">&#127942;</span>
                                    <span>{{ $badgeText }}</span>
                                </div>
                            @endif

                            <h1 class="banner-v2-title wow fadeInUp" data-wow-delay="0.2s">
                                {{ p_trans('home_banner_title', null, get_setting('banner_title', 'Buy & Sell Anything, All in One Place')) }}
                            </h1>

                            <p class="banner-v2-desc wow fadeInUp" data-wow-delay="0.3s">
                                {{ p_trans('home_banner_subtitle', null, get_setting('banner_description', "Country's most loved and trusted classified ad listing website. Browse thousands of classified items near you.")) }}
                            </p>

                            <div class="banner-v2-search-wrap wow fadeInUp" data-wow-delay="0.4s">
                                <form action="{{ route('ad.listing.page') }}"
                                    class="d-flex align-items-stretch banner-search-location banner-v2-form" method="get">
                                    <div class="banner-v2-inputs d-flex align-items-center flex-grow-1">
                                        <div class="banner-v2-input-group flex-grow-1" style="position:relative;">
                                            <div class="banner-v2-input-icon">
                                                <i class="las la-search"></i>
                                            </div>
                                            <input class="banner-v2-field w-100" type="text" name="q" id="home_search"
                                                placeholder="What are you looking for?">
                                            <span id="all_search_result" class="search_with_text_section"></span>
                                        </div>
                                    </div>
                                    <button type="submit" class="banner-v2-btn setLocation_btn">
                                        <i class="las la-search"></i>
                                        <span class="d-none d-sm-inline">Search</span>
                                    </button>
                                </form>
                            </div>

                            @if ($categories->count() > 0)
                                <div class="banner-quick-cats wow fadeInUp" data-wow-delay="0.5s">
                                    <span class="banner-quick-label">Browse:</span>
                                    @foreach ($categories->take(8) as $cat)
                                        <a href="{{ route('ad.listing.page', $cat->permalink) }}" class="banner-quick-pill">
                                            {{ $cat->title }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <div class="banner-v2-stats wow fadeInUp" data-wow-delay="0.6s">
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
                    </div>
                </section>
            @break

            {{-- ═══════════════════════════ AD SLOT ═══════════════════════════ --}}
            @case('ad_slot')
                @include('frontend.components.ad-slot', ['position' => 'home_top'])
            @break

            {{-- ═══════════════════════════ CATEGORIES ═══════════════════════════ --}}
            @case('categories')
                @if ($categories->count() > 0)
                    <div class="exploreCategories" data-padding-top="50" data-padding-bottom="50"
                        style="background-color: rgb(255, 255, 255)">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-8 col-lg-7 col-md-10 col-sm-10">
                                    <div class="section-tittle">
                                        <h2 class="tittle">{{ p_trans('home_categories_title', null, 'Categories') }}</h2>
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
                                                    <a href="{{ route('ad.listing.page', $category->permalink) }}"
                                                        class="title">
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
            @break

            {{-- ═══════════════════════════ TOP LISTINGS ═══════════════════════════ --}}
            @case('top_listings')
                @if ($topListings->count() > 0)
                    <section class="featureListing" data-padding-top="50" data-padding-bottom="50" style="background-color:">
                        <div class="container">
                            <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                                <h2 class="head3">{{ p_trans('home_top_listings_title', null, 'Top Listings') }}</h2>
                                <a href="{{ route('ad.listing.page', ['listing_type_preferences' => 'top_listing']) }}"
                                    class="see-all">See All <i class="las la-angle-right"></i></a>
                            </div>
                            <div class="slider-inner-margin">
                                @foreach ($topListings as $ad)
                                    <x-single-listing :ad="$ad" />
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif
            @break

            {{-- ═══════════════════════════ PROMO ═══════════════════════════ --}}
            @case('promo')
                @php $promoPrinted = true; @endphp
                <section class="promoSection">
                    <div class="container">
                        <div class="promoWrapper">
                            <div class="promo-orb-1"></div>
                            <div class="promo-orb-2"></div>

                            <div class="promo-compact-content wow fadeInUp" data-wow-delay="0.1s">
                                <span class="promo-badge">{{ p_trans('home_promo_badge', null, 'Your Local Marketplace') }}</span>
                                <h2 class="promo-heading">
                                    {{ p_trans('home_promo_heading', null, 'Earn cash by selling or find anything you desire') }}
                                </h2>
                                <p class="promo-text">
                                    {{ p_trans('home_promo_text', null, 'List your pre-loved or new items in minutes, or browse thousands of ads to find exactly what you need — all in one place.') }}
                                </p>
                                <div class="d-flex flex-wrap gap-3 justify-content-center">
                                    <a href="{{ route('ad.post.page') }}" class="promo-btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 1a.5.5 0 0 1 .5.5V7h5.5a.5.5 0 0 1 0 1H8.5v5.5a.5.5 0 0 1-1 0V8H2a.5.5 0 0 1 0-1h5.5V1.5A.5.5 0 0 1 8 1z" />
                                        </svg>
                                        {{ p_trans('home_promo_btn_primary', null, 'Post Your Ad') }}
                                    </a>
                                    <a href="{{ route('ad.listing.page') }}" class="promo-btn-outline">
                                        {{ p_trans('home_promo_btn_secondary', null, 'Browse Ads') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @break

            {{-- ═══════════════════════════ PRICING PLANS ═══════════════════════════ --}}
            @case('pricing_plans')
                @if ($pricingPlans->count() > 0)
                    <section class="pricingCard" data-padding-top="50" data-padding-bottom="50">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-xl-8 col-lg-7 col-md-10 col-sm-10">
                                    <div class="section-tittle text-center mb-50">
                                        <h2 class="head3">{{ p_trans('home_pricing_title', null, translation('Membership')) }}
                                        </h2>
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
            @break

            {{-- ═══════════════════════════ RECENT LISTINGS ═══════════════════════════ --}}
            @case('recent_listings')
                @if ($recentListings->count() > 0)
                    <section class="featureListing" data-padding-top="50" data-padding-bottom="100"
                        style="background-color:rgb(255, 255, 255)">
                        <div class="container">
                            <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                                <h2 class="head3">{{ p_trans('home_recent_title', null, 'Recent Listing') }}</h2>
                                <a href="{{ route('ad.listing.page', ['sortby' => 'latest_listing']) }}" class="see-all">See All
                                    <i class="las la-angle-right"></i></a>
                            </div>
                            <div class="slider-inner-margin">
                                @foreach ($recentListings as $ad)
                                    <x-single-listing :ad="$ad" />
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif
            @break
        @endswitch
    @endforeach

    {{-- Category-wise listings are always rendered after top_listings --}}
    @foreach ($categoryWiseListings as $index => $catListing)
        <section class="featureListing" data-padding-top="50" data-padding-bottom="50" style="background-color:">
            <div class="container">
                <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                    <h2 class="head3">{{ $catListing['category']->title }}</h2>
                    <a href="{{ route('ad.listing.page', ['cat' => $catListing['category']->id]) }}" class="see-all">See
                        All <i class="las la-angle-right"></i></a>
                </div>
                <div class="slider-inner-margin">
                    @foreach ($catListing['ads'] as $ad)
                        <x-single-listing :ad="$ad" />
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Insert promo section after first category listing if promo section is not active --}}
        @if ($index === 0 && !$promoPrinted)
            <section class="promoSection">
                <div class="container">
                    <div class="promoWrapper">
                        <div class="promo-orb-1"></div>
                        <div class="promo-orb-2"></div>
                        <div class="promo-compact-content wow fadeInUp" data-wow-delay="0.1s">
                            <span
                                class="promo-badge">{{ p_trans('home_promo_badge', null, 'Your Local Marketplace') }}</span>
                            <h2 class="promo-heading">
                                {{ p_trans('home_promo_heading', null, 'Earn cash by selling or find anything you desire') }}
                            </h2>
                            <p class="promo-text">
                                {{ p_trans('home_promo_text', null, 'List your pre-loved or new items in minutes, or browse thousands of ads to find exactly what you need — all in one place.') }}
                            </p>
                            <div class="d-flex flex-wrap gap-3 justify-content-center">
                                <a href="{{ route('ad.post.page') }}" class="promo-btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M8 1a.5.5 0 0 1 .5.5V7h5.5a.5.5 0 0 1 0 1H8.5v5.5a.5.5 0 0 1-1 0V8H2a.5.5 0 0 1 0-1h5.5V1.5A.5.5 0 0 1 8 1z" />
                                    </svg>
                                    {{ p_trans('home_promo_btn_primary', null, 'Post Your Ad') }}
                                </a>
                                <a href="{{ route('ad.listing.page') }}" class="promo-btn-outline">
                                    {{ p_trans('home_promo_btn_secondary', null, 'Browse Ads') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    {{-- Show promo standalone if no category listings and promo section is not active --}}
    @if (count($categoryWiseListings) === 0 && !$promoPrinted)
        <section class="promoSection">
            <div class="container">
                <div class="promoWrapper">
                    <div class="promo-orb-1"></div>
                    <div class="promo-orb-2"></div>
                    <div class="promo-compact-content wow fadeInUp" data-wow-delay="0.1s">
                        <span class="promo-badge">{{ p_trans('home_promo_badge', null, 'Your Local Marketplace') }}</span>
                        <h2 class="promo-heading">
                            {{ p_trans('home_promo_heading', null, 'Earn cash by selling or find anything you desire') }}
                        </h2>
                        <p class="promo-text">
                            {{ p_trans('home_promo_text', null, 'List your pre-loved or new items in minutes, or browse thousands of ads to find exactly what you need — all in one place.') }}
                        </p>
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a href="{{ route('ad.post.page') }}" class="promo-btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a.5.5 0 0 1 .5.5V7h5.5a.5.5 0 0 1-1 0V8H2a.5.5 0 0 1 0-1h5.5V1.5A.5.5 0 0 1 8 1z" />
                                </svg>
                                {{ p_trans('home_promo_btn_primary', null, 'Post Your Ad') }}
                            </a>
                            <a href="{{ route('ad.listing.page') }}" class="promo-btn-outline">
                                {{ p_trans('home_promo_btn_secondary', null, 'Browse Ads') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
