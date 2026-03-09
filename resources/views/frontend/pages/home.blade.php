@extends('frontend.layouts.master')
@section('meta')
    <title>{{ get_setting('site_name') }} - {{ get_setting('site_tagline') }}</title>
    <!-- Primary Meta Tags -->
    <meta name="title" content="{{ get_setting('site_name') }}">
    <meta name="description" content="{{ get_setting('site_description') }}">
    <meta name="keywords" content="{{ get_setting('site_keywords') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="{{ get_setting('site_name') }}">
    <meta property="og:description" content="{{ get_setting('site_description') }}">
    <meta property="og:image" content="{{ asset('/public/uploads/media-uploader/icon1717328206.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="{{ asset('/public/uploads/media-uploader/icon1717328206.png') }}">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="{{ get_setting('site_name') }}">
    <meta property="twitter:description" content="{{ get_setting('site_description') }}">
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
                                                placeholder="{{ translation('What are you looking for?') }}">
                                            <span id="all_search_result" class="search_with_text_section"></span>
                                        </div>
                                    </div>
                                    <button type="submit" class="banner-v2-btn setLocation_btn">
                                        <i class="las la-search"></i>
                                        <span class="d-none d-sm-inline">{{ translation('Search') }}</span>
                                    </button>
                                </form>
                            </div>

                            @if ($categories->count() > 0)
                                <div class="banner-quick-cats wow fadeInUp" data-wow-delay="0.5s">
                                    <span class="banner-quick-label">{{ translation('Browse:') }}</span>
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
                                    <span>{{ translation('Live Ads') }}</span>
                                </div>
                                <div class="stat-divider"></div>
                                <div class="stat-pill">
                                    <strong>{{ $categories->count() }}</strong>
                                    <span>{{ translation('Categories') }}</span>
                                </div>
                                <div class="stat-divider"></div>
                                <div class="stat-pill">
                                    <strong>{{ translation('Free') }}</strong>
                                    <span>{{ translation('To Post') }}</span>
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
                    @php
                        $catBg = [
                            'linear-gradient(145deg,#fde8d8,#f9c7a8)',
                            'linear-gradient(145deg,#daeaff,#b8d4ff)',
                            'linear-gradient(145deg,#d6f5e8,#a8e6cc)',
                            'linear-gradient(145deg,#f0deff,#d9b8ff)',
                            'linear-gradient(145deg,#fff3cc,#ffe080)',
                            'linear-gradient(145deg,#ffe0eb,#ffb3c6)',
                            'linear-gradient(145deg,#d0f0ff,#8ed8f8)',
                            'linear-gradient(145deg,#e8f5d0,#c3e89a)',
                            'linear-gradient(145deg,#ffd6c8,#ffaa8a)',
                            'linear-gradient(145deg,#d8e4ff,#a0b8f8)',
                            'linear-gradient(145deg,#d6faf5,#90e8d8)',
                            'linear-gradient(145deg,#fde8f8,#f5b8e8)',
                        ];
                    @endphp
                    <section class="browse-categories-section" data-padding-top="50" data-padding-bottom="50">
                        <div class="container">
                            <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                                <h2 class="head3">{{ p_trans('home_categories_title', null, 'Browse Categories') }}</h2>
                            </div>
                            <div class="row g-3">
                                @foreach ($categories as $category)
                                    @php $bg = $catBg[$loop->index % count($catBg)]; @endphp
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
                                        <a href="{{ route('ad.listing.page', $category->permalink) }}"
                                            class="cat-thumb-card text-decoration-none">
                                            <div class="cat-thumb-img" style="background:{{ $bg }};">
                                                <img src="{{ asset(getFilePath($category->icon)) }}"
                                                    alt="{{ $category->title }}" />
                                            </div>
                                            <div class="cat-thumb-info">
                                                <div class="cat-thumb-name">{{ $category->title }}</div>
                                                <div class="cat-thumb-count">
                                                    {{ number_format($category->ads_count) }} {{ translation('ads') ?? 'ads' }}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
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
                                    class="see-all">{{ translation('See All') }} <i class="las la-angle-right"></i></a>
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

            {{-- ═══════════════════════════ FEATURED ADS ═══════════════════════════ --}}
            @case('featured_ads')
                @if ($featuredAds->count() > 0)
                    <section class="featureListing" data-padding-top="50" data-padding-bottom="50">
                        <div class="container">
                            <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                                <h2 class="head3">{{ p_trans('home_featured_ads_title', null, 'Featured Ads') }}</h2>
                                <a href="{{ route('ad.listing.page', ['listing_type_preferences' => 'top_listing']) }}"
                                    class="see-all">{{ translation('See All') }} <i class="las la-angle-right"></i></a>
                            </div>
                            <div class="slider-inner-margin">
                                @foreach ($featuredAds as $ad)
                                    <x-single-listing :ad="$ad" />
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
                                <a href="{{ route('ad.listing.page', ['sortby' => 'latest_listing']) }}"
                                    class="see-all">{{ translation('See All') }}
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
                    <a href="{{ route('ad.listing.page', ['cat' => $catListing['category']->id]) }}"
                        class="see-all">{{ translation('See All') }}
                        <i class="las la-angle-right"></i></a>
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
