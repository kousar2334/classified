@extends('frontend.layouts.master')
@section('meta')
    <title>{{ $ad->title }} - {{ get_setting('site_name') }}</title>
    <style>
        /* ── Sidebar: Seller Card ─────────────────────────────── */
        .sid-seller-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 14px rgba(0, 0, 0, .08);
            padding: 18px;
            margin-bottom: 12px;
        }

        .sid-seller-top {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .sid-avatar-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
        }

        .sid-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        .sid-member-label {
            font-size: 10px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .sid-seller-info {
            flex: 1;
            min-width: 0;
        }

        .sid-seller-name {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 4px;
        }

        .sid-verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            background: #3b82f6;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .06em;
            padding: 2px 7px;
            border-radius: 20px;
        }

        .sid-seller-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #64748b;
        }

        .sid-dot {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: #94a3b8;
            display: inline-block;
        }

        /* ── Sidebar: Contact Card ─────────────────────────────── */
        .sid-contact-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 14px rgba(0, 0, 0, .08);
            margin-bottom: 12px;
            overflow: hidden;
        }

        .sid-action-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 18px;
            text-decoration: none;
            color: inherit;
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            transition: background .15s;
        }

        .sid-action-row:hover {
            background: #f8fafc;
            color: inherit;
            text-decoration: none;
        }

        .sid-icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sid-icon-phone {
            background: #22c55e;
        }

        .sid-icon-chat {
            background: #f59e0b;
        }

        .sid-icon-whatsapp {
            background: #25d366;
        }

        .sid-action-text {
            flex: 1;
            min-width: 0;
        }

        .sid-action-text span {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .sid-action-text small {
            font-size: 12px;
            color: #94a3b8;
        }

        .sid-action-arrow {
            flex-shrink: 0;
        }

        .sid-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 0 18px;
        }

        /* ── Message modal ───────────────────────────────────── */
        #messageSellerModal .modal-content {
            border: none;
            border-radius: 14px;
            overflow: hidden;
        }

        #messageSellerModal .modal-header {
            background: var(--main-color-one);
            border-bottom: none;
            padding: 18px 22px;
        }

        #messageSellerModal .modal-title {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
        }

        #messageSellerModal .btn-close {
            filter: invert(1) brightness(2);
        }

        #messageSellerModal .modal-body {
            padding: 22px;
        }

        #messageSellerModal .msg-listing-ref {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f8fafc;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 16px;
            font-size: 13px;
            color: #475569;
        }

        #messageSellerModal .msg-listing-ref strong {
            color: #1e293b;
        }

        #messageSellerModal textarea.form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            resize: none;
            transition: border-color .2s;
        }

        #messageSellerModal textarea.form-control:focus {
            border-color: var(--main-color-one);
            box-shadow: none;
        }

        #messageSellerModal .modal-footer {
            border-top: 1px solid #f1f5f9;
            padding: 14px 22px;
            gap: 10px;
        }

        #messageSellerModal .modal-send-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 22px;
            background: var(--main-color-one);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: filter .2s;
        }

        #messageSellerModal .modal-send-btn:hover {
            filter: brightness(1.08);
        }

        /* ── Actions Card (Save, Report, Share) ─────────────── */
        .sid-actions-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 14px rgba(0, 0, 0, .08);
            margin-bottom: 12px;
            overflow: hidden;
        }

        .sid-quick-actions {
            display: flex;
            border-bottom: 1px solid #f1f5f9;
        }

        .sid-quick-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 14px 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            transition: background .15s, color .15s;
            cursor: pointer;
            background: none;
            border: none;
        }

        .sid-quick-btn:hover {
            background: #f8fafc;
            color: #1e293b;
            text-decoration: none;
        }

        .sid-quick-btn i {
            font-size: 17px;
        }

        .sid-fav-btn i {
            color: #ef4444;
        }

        .sid-fav-btn:hover,
        .sid-fav-btn.is-favourited {
            color: #ef4444;
        }

        .sid-fav-btn.is-favourited i {
            font-weight: 900;
        }

        .sid-report-btn:hover {
            color: #ef4444;
        }

        .sid-quick-sep {
            width: 1px;
            background: #f1f5f9;
            flex-shrink: 0;
        }

        .sid-share-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
        }

        .sid-share-label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .06em;
            white-space: nowrap;
        }

        .sid-share-icons {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .sid-share-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 14px;
            color: #fff;
            transition: transform .15s, filter .15s;
        }

        .sid-share-icon:hover {
            transform: translateY(-2px);
            filter: brightness(1.12);
            color: #fff;
        }

        .sid-share-fb {
            background: #1877f2;
        }

        .sid-share-tw {
            background: #000;
        }

        .sid-share-pt {
            background: #e60023;
        }

        .sid-share-wa {
            background: #25d366;
        }

        /* ── Responsive ──────────────────────────────────────── */
        @media (max-width: 767px) {
            .proDetails.section-padding2 {
                padding-top: 20px;
            }

            .product-name-price {
                flex-direction: column;
                gap: 6px;
            }

            .product-name {
                font-size: 18px !important;
            }

            .price {
                text-align: left !important;
            }

            .date-location {
                flex-wrap: wrap;
                gap: 4px 0;
            }

            .date-location .vartical-devider {
                display: none;
            }

            .date-location>span {
                display: block;
                width: 100%;
            }

            .descriptionTop .row>div {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .sid-actions-card .sid-share-row {
                flex-wrap: wrap;
                padding: 12px 14px;
            }

            .sid-actions-card .sid-quick-btn {
                font-size: 12px;
                padding: 12px 6px;
            }
        }

        @media (max-width: 480px) {
            .descriptionTop .row>div {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        img.no-image {
            max-width: 400px;
            margin: auto;
        }

        .slick_slider_item {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: max-content;
        }

        .slick_slider_item a {
            display: flex;
            align-items: center;
            height: 40px;
            border-radius: 20px;
            background-color: rgb(243, 243, 247);
            padding: 8px 16px 8px 12px;
            font-size: 15px;
            font-weight: initial;
            line-height: 16px;
            letter-spacing: 0.25px;
            transition: all;
        }

        .product-view-wrap .shop-details-gallery-slider {
            position: relative;
        }

        .product-view-wrap .shop-details-gallery-slider .prev-icon,
        .product-view-wrap .shop-details-gallery-slider .next-icon {
            cursor: pointer;
            position: absolute !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            z-index: 10;
            width: 36px;
            height: 36px;
            background: rgba(0, 0, 0, 0.5) !important;
            color: #fff !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            border-radius: 50% !important;
            border: none !important;
            line-height: normal !important;
            right: auto !important;
            left: auto !important;
        }

        .product-view-wrap .shop-details-gallery-slider .prev-icon {
            left: 10px !important;
        }

        .product-view-wrap .shop-details-gallery-slider .next-icon {
            right: 10px !important;
        }

        .product-view-wrap .shop-details-gallery-slider .prev-icon i,
        .product-view-wrap .shop-details-gallery-slider .next-icon i {
            font-size: 20px;
            color: #fff !important;
            position: static !important;
        }

        @media (max-width: 576px) {

            .product-view-wrap .shop-details-gallery-slider .prev-icon,
            .product-view-wrap .shop-details-gallery-slider .next-icon {
                width: 30px;
                height: 30px;
            }

            .product-view-wrap .shop-details-gallery-slider .prev-icon i,
            .product-view-wrap .shop-details-gallery-slider .next-icon i {
                font-size: 18px;
            }
        }

        .zoom-img {
            width: 100%;
            display: block;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('public/web-assets/frontend/css/magnific-popup.min.css') }}">
@endsection

@section('content')
    @php $sellerUser = $ad->userInfo; @endphp
    <!--Listing Details-->
    <div class="proDetails section-padding2">
        <div class="container">
            {{-- Breadcrumb --}}
            <div class="bradecrumb-wraper-div">
                <div class="row mb-24">
                    <div class="col-sm-12">
                        <nav aria-label="breadcrumb" class="frontend-breadcrumb-wrap">
                            <h4 class="breadcrumb-contents-title"></h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('ad.listing.page') }}">Listings</a></li>
                                <li class="breadcrumb-item active">{{ $ad->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                {{-- Left Column --}}
                <div class="col-xl-8 col-lg-8 col-md-8">
                    {{-- Title, Price, Date & Location --}}
                    <div class="short-description">
                        <div class="left-part mb-4">
                            <div class="product-name-price">
                                <div class="product-name">{{ $ad->title }}</div>
                                <div class="right-part text-right">
                                    <div class="price text-end">
                                        <span>${{ number_format($ad->price, 2) }}</span>
                                        @if ($ad->is_negotiable == config('settings.general_status.active'))
                                            <div class="token">NEGOTIABLE</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="date-location">
                                <span>Posted on <span class="posted">{{ $ad->created_at->format('d F Y') }}</span></span>
                                @if ($ad->categoryInfo)
                                    <span class="vartical-devider"></span>
                                    <span>Category <span class="posted">{{ $ad->categoryInfo->title }}</span></span>
                                @endif
                                @php
                                    $locationParts = array_filter([
                                        $ad->cityInfo->name ?? null,
                                        $ad->stateInfo->name ?? null,
                                        $ad->countryInfo->name ?? null,
                                    ]);
                                @endphp
                                @if (count($locationParts) > 0)
                                    <span class="vartical-devider"></span>
                                    <span>Location <span class="posted">{{ implode(', ', $locationParts) }}</span></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Image Gallery Slider --}}
                    @php
                        $allImages = collect();
                        if ($ad->thumbnail_image) {
                            $allImages->push($ad->thumbnail_image);
                        }
                        foreach ($ad->galleryImages as $galleryImage) {
                            $allImages->push($galleryImage->image_path);
                        }
                    @endphp

                    @if ($allImages->count() > 0)
                        <div class="product-view-wrap" id="myTabContent">
                            <div class="shop-details-gallery-slider global-slick-init slider-inner-margin sliderArrow"
                                data-asNavFor=".shop-details-gallery-nav" data-infinite="true" data-arrows="true"
                                data-dots="false" data-slidesToShow="1" data-swipeToSlide="true" data-fade="true"
                                data-autoplay="false" data-autoplaySpeed="3000"
                                data-prevArrow='<div class="prev-icon"><i class="las la-angle-left"></i></div>'
                                data-nextArrow='<div class="next-icon"><i class="las la-angle-right"></i></div>'
                                data-responsive='[{"breakpoint": 1800,"settings": {"slidesToShow": 1}},{"breakpoint": 1600,"settings": {"slidesToShow": 1}},{"breakpoint": 1400,"settings": {"slidesToShow": 1}},{"breakpoint": 1200,"settings": {"slidesToShow": 1}},{"breakpoint": 991,"settings": {"slidesToShow": 1}},{"breakpoint": 768, "settings": {"slidesToShow": 1}},{"breakpoint": 576, "settings": {"slidesToShow": 1}}]'>

                                @foreach ($allImages as $image)
                                    <div class="single-main-image">
                                        <a href="#" data-mfp-src="{{ asset(getFilePath($image, false)) }}"
                                            class="long-img image-link">
                                            <img src="{{ asset(getFilePath($image, false)) }}"
                                                alt="{{ $ad->title }}" />
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            @if ($allImages->count() > 1)
                                <div class="thumb-wrap">
                                    <div class="shop-details-gallery-nav global-slick-init slider-inner-margin sliderArrow"
                                        data-asNavFor=".shop-details-gallery-slider" data-focusOnSelect="true"
                                        data-infinite="false" data-arrows="false" data-dots="false" data-slidesToShow="6"
                                        data-autoplay="false" data-swipeToSlide="true"
                                        data-prevArrow='<div class="prev-icon"><i class="las la-angle-left"></i></div>'
                                        data-nextArrow='<div class="next-icon"><i class="las la-angle-right"></i></div>'
                                        data-responsive='[{"breakpoint": 1200,"settings": {"slidesToShow": 5}}, {"breakpoint": 992,"settings": {"slidesToShow": 4}}, {"breakpoint": 450,"settings": {"slidesToShow": 3}}, {"breakpoint": 350,"settings": {"slidesToShow": 2}}]'>

                                        @foreach ($allImages as $index => $image)
                                            <div class="single-thumb">
                                                <a class="thumb-link"
                                                    data-mfp-src="{{ asset(getFilePath($image, false)) }}"
                                                    data-toggle="tab" href="#image-{{ $index }}">
                                                    <img src="{{ asset(getFilePath($image, false)) }}"
                                                        alt="{{ $ad->title }}" />
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="product-view-wrap text-center p-4">
                            <img class="no-image" src="{{ getFilePath(null) }}" alt="No image available" />
                        </div>
                    @endif

                    {{-- Description Section --}}
                    <div class="proDescription box-shadow1">
                        {{-- Custom Fields / Condition --}}
                        {{-- $customFields and $fieldModels passed from controller --}}
                        @if ($ad->condition || $fieldModels->count() > 0)
                            <div class="descriptionTop">
                                <div class="row gy-4">
                                    @if ($ad->condition)
                                        <div class="col-4">
                                            Condition: <span class="text-bold">{{ $ad->condition->title }}</span>
                                        </div>
                                    @endif
                                    @if ($customFields)
                                        @foreach ($customFields as $field)
                                            @php
                                                $fieldModel = $fieldModels->get($field['flied_id'] ?? null);
                                            @endphp
                                            @if ($fieldModel && $field['type'] != 7)
                                                <div class="col-4">
                                                    {{ $fieldModel->title }}: <span
                                                        class="text-bold">{{ $field['value'] }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="devider"></div>
                        @endif

                        {{-- Description --}}
                        <div class="descriptionMid">
                            <h4 class="disTittle">Description</h4>
                            <div class="product__details__para" id="description">{!! $ad->description !!}</div>
                            <button id="showMoreButton" class="show-more-btn">Show More</button>
                        </div>

                        {{-- Tags --}}
                        @if ($ad->tags->count() > 0)
                            <div class="descriptionFooter">
                                <h4 class="disTittle">Tags</h4>
                                <div class="tags">
                                    @foreach ($ad->tags as $tag)
                                        <a
                                            href="{{ route('ad.listing.page') }}?tag_id={{ $tag->id }}">{{ $tag->title }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Mobile Seller Info --}}
                    <div class="seller-part mt-3 d-md-none">
                        @include('frontend.pages.ad._seller_info', ['ad' => $ad, 'isMobile' => true])
                    </div>

                    {{-- Relevant Ads --}}
                    @if ($relevantAds->count() > 0)
                        <div class="relevant-ads box-shadow1">
                            <h4 class="disTittle">Relevant Ads</h4>
                            <div class="add-wraper relevant-listing-wrapper">
                                @foreach ($relevantAds as $relAd)
                                    <div class="single-add-card">
                                        <div class="single-add-image">
                                            <a href="{{ route('ad.details.page', $relAd->uid) }}">
                                                <img src="{{ asset(getFilePath($relAd->thumbnail_image)) }}"
                                                    alt="{{ $relAd->title }}" />
                                            </a>
                                        </div>
                                        <div class="single-add-body">
                                            <h4 class="add-heading head4">
                                                <a
                                                    href="{{ route('ad.details.page', $relAd->uid) }}">{{ $relAd->title }}</a>
                                            </h4>
                                            <div class="btn-wrapper">
                                                @if ($relAd->is_featured == config('settings.general_status.active'))
                                                    <span class="pro-btn2">
                                                        <svg width="7" height="10" viewBox="0 0 7 10"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4 0V3.88889H7L3 10V6.11111H0L4 0Z" fill="white" />
                                                        </svg>
                                                        FEATURED
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="pricing head4">${{ number_format($relAd->price, 2) }}</div>
                                            <p class="featureCap d-flex align-items-center gap-1">
                                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.99984 7.83332C5.99984 8.36376 6.21055 8.87246 6.58562 9.24754C6.9607 9.62261 7.4694 9.83332 7.99984 9.83332C8.53027 9.83332 9.03898 9.62261 9.41405 9.24754C9.78912 8.87246 9.99984 8.36376 9.99984 7.83332C9.99984 7.30289 9.78912 6.79418 9.41405 6.41911C9.03898 6.04404 8.53027 5.83332 7.99984 5.83332C7.4694 5.83332 6.9607 6.04404 6.58562 6.41911C6.21055 6.79418 5.99984 7.30289 5.99984 7.83332Z"
                                                        stroke="#64748B" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M11.7712 11.6047L8.94251 14.4333C8.6925 14.6831 8.35356 14.8234 8.00017 14.8234C7.64678 14.8234 7.30785 14.6831 7.05784 14.4333L4.22851 11.6047C3.48265 10.8588 2.97473 9.90845 2.76896 8.8739C2.5632 7.83934 2.66883 6.767 3.07251 5.79247C3.47618 4.81795 4.15977 3.98501 5.03683 3.39899C5.91388 2.81297 6.94502 2.50018 7.99984 2.50018C9.05466 2.50018 10.0858 2.81297 10.9629 3.39899C11.8399 3.98501 12.5235 4.81795 12.9272 5.79247C13.3308 6.767 13.4365 7.83934 13.2307 8.8739C13.0249 9.90845 12.517 10.8588 11.7712 11.6047Z"
                                                        stroke="#64748B" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <span class="oneLine">
                                                    {{ $relAd->cityInfo->name ?? '' }}{{ $relAd->stateInfo ? ', ' . $relAd->stateInfo->name : '' }}
                                                </span>
                                            </p>
                                            <div class="dates">
                                                <svg width="14" height="13" viewBox="0 0 14 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9 7.83333L7 6.5V3.16667M1 6.5C1 7.28793 1.15519 8.06815 1.45672 8.7961C1.75825 9.52405 2.20021 10.1855 2.75736 10.7426C3.31451 11.2998 3.97595 11.7417 4.7039 12.0433C5.43185 12.3448 6.21207 12.5 7 12.5C7.78793 12.5 8.56815 12.3448 9.2961 12.0433C10.0241 11.7417 10.6855 11.2998 11.2426 10.7426C11.7998 10.1855 12.2417 9.52405 12.5433 8.7961C12.8448 8.06815 13 7.28793 13 6.5C13 5.71207 12.8448 4.93185 12.5433 4.2039C12.2417 3.47595 11.7998 2.81451 11.2426 2.25736C10.6855 1.70021 10.0241 1.25825 9.2961 0.956723C8.56815 0.655195 7.78793 0.5 7 0.5C6.21207 0.5 5.43185 0.655195 4.7039 0.956723C3.97595 1.25825 3.31451 1.70021 2.75736 2.25736C2.20021 2.81451 1.75825 3.47595 1.45672 4.2039C1.15519 4.93185 1 5.71207 1 6.5Z"
                                                        stroke="#64748B" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <span>{{ $relAd->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="favourite-icon">
                                            <a href="javascript:void(0)" class="click_to_favorite_add_remove"
                                                data-listing_id="{{ $relAd->id }}">
                                                <i class="lar la-heart icon favorite_add_icon"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @if (!$loop->last)
                                        <div class="devider"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Right Column / Sidebar --}}
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="seller-part">
                        {{-- Desktop Seller Info --}}
                        <div class="d-none d-md-block">
                            @include('frontend.pages.ad._seller_info', ['ad' => $ad, 'isMobile' => false])
                        </div>

                        {{-- Actions: Save, Report, Share --}}
                        <div class="sid-actions-card">
                            <div class="sid-quick-actions">
                                <a href="javascript:void(0)"
                                    class="sid-quick-btn sid-fav-btn click_to_favorite_add_remove {{ $isFavourited ? 'is-favourited' : '' }}"
                                    data-listing_id="{{ $ad->id }}"
                                    data-toggle-url="{{ route('ad.favourite.toggle') }}"
                                    data-is-auth="{{ auth()->check() ? 'true' : 'false' }}"
                                    data-login-url="{{ route('member.login') }}">
                                    <i class="{{ $isFavourited ? 'las' : 'lar' }} la-heart icon favorite_add_icon"></i>
                                    <span>{{ $isFavourited ? 'Saved' : 'Save' }}</span>
                                </a>
                                <div class="sid-quick-sep"></div>
                                <a href="javascript:void(0)" class="sid-quick-btn sid-report-btn"
                                    data-is-auth="{{ auth()->check() ? '1' : '0' }}"
                                    data-login-url="{{ route('member.login') }}">
                                    <svg width="15" height="17" viewBox="0 0 16 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 10H15L10.5 5.5L15 1H1V17" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>Report</span>
                                </a>
                            </div>
                            <div class="sid-share-row">
                                <span class="sid-share-label">Share</span>
                                <div class="sid-share-icons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                        target="_blank" rel="noopener" class="sid-share-icon sid-share-fb"
                                        title="Facebook">
                                        <i class="lab la-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($ad->title) }}&url={{ urlencode(request()->url()) }}"
                                        target="_blank" rel="noopener" class="sid-share-icon sid-share-tw"
                                        title="Twitter / X">
                                        <i class="lab la-twitter"></i>
                                    </a>
                                    <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&description={{ urlencode($ad->title) }}"
                                        target="_blank" rel="noopener" class="sid-share-icon sid-share-pt"
                                        title="Pinterest">
                                        <i class="lab la-pinterest-p"></i>
                                    </a>
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($ad->title . ' ' . request()->url()) }}"
                                        target="_blank" rel="noopener" class="sid-share-icon sid-share-wa"
                                        title="WhatsApp">
                                        <i class="lab la-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Safety Tips --}}
                        @if (isset($safetyTips) && $safetyTips->count() > 0)
                            <div class="safety-tips">
                                <h3 class="head5">{{ translation('Safety Tips') }}</h3>
                                <div class="safety-wraper">
                                    <ol>
                                        @foreach ($safetyTips as $tip)
                                            <li
                                                style="display: flex; align-items: center; gap: 8px; color: rgb(15, 23, 42); font-size: 16px; line-height: 1.5;">
                                                <i class="las la-check-circle"
                                                    style="color: var(--main-color-one); font-size: 20px;"></i>
                                                <span>{{ $tip->translation('title') }}</span>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Message Seller Modal --}}
    @auth
        @if ($sellerUser && auth()->id() !== $sellerUser->id)
            <div class="modal fade" id="messageSellerModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="d-flex align-items-center gap-2">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z"
                                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <h5 class="modal-title">Message {{ $sellerUser->name }}</h5>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('member.messages.start') }}" method="POST">
                            @csrf
                            <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                            <div class="modal-body">
                                <div class="msg-listing-ref">
                                    @if ($ad->thumbnail_image)
                                        <img src="{{ asset(getFilePath($ad->thumbnail_image, false)) }}"
                                            alt="{{ $ad->title }}"
                                            style="width:40px;height:40px;object-fit:cover;border-radius:6px;flex-shrink:0;">
                                    @endif
                                    <div>
                                        <div
                                            style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">
                                            Listing</div>
                                        <strong>{{ Str::limit($ad->title, 55) }}</strong>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label"
                                        style="font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Your
                                        message</label>
                                    <textarea name="message" class="form-control" rows="5"
                                        placeholder="Hi, I am interested in your listing. Is it still available?" required maxlength="2000"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="modal-send-btn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 2L11 13M22 2L15 22L11 13M22 2L2 9L11 13" stroke="white" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    {{-- Report Modal --}}
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Report this ad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reportForm">
                        @csrf
                        <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                        <div class="mb-3">
                            <label for="reportReason" class="form-label">Reason</label>
                            <select class="form-select" id="reportReason" name="reason">
                                <option value="spam">Spam</option>
                                <option value="inappropriate">Inappropriate content</option>
                                <option value="fraud">Fraud / Scam</option>
                                <option value="duplicate">Duplicate listing</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reportMessage" class="form-label">Message</label>
                            <textarea class="form-control" id="reportMessage" name="message" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="submitReport">Submit Report</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('public/web-assets/frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                // Phone reveal
                $(document).on('click', '.sid-phone-trigger, .sid-phone-triggerForResponsive', function(e) {
                    var $row = $(this);
                    if ($row.data('revealed')) {
                        return true;
                    }
                    e.preventDefault();
                    var phone = $row.data('phone');
                    var prefix = $row.data('prefix');
                    $row.find('.sid-phone-display' + prefix).text(phone);
                    $row.find('.sid-phone-hint' + prefix).text('Tap to call');
                    $row.attr('href', 'tel:' + phone);
                    $row.data('revealed', true);
                });

                // Show More / Show Less for description
                var descriptionEl = $('#description');
                var showMoreBtn = $('#showMoreButton');
                if (descriptionEl.length && descriptionEl[0].scrollHeight <= 200) {
                    showMoreBtn.hide();
                }
                showMoreBtn.on('click', function() {
                    if (descriptionEl.hasClass('expanded')) {
                        descriptionEl.removeClass('expanded');
                        descriptionEl.css('max-height', '');
                        $(this).text('Show More');
                    } else {
                        descriptionEl.addClass('expanded');
                        descriptionEl.css('max-height', 'none');
                        $(this).text('Show Less');
                    }
                });

                // Initialize magnific popup for gallery images
                if (typeof $.fn.magnificPopup !== 'undefined') {
                    $('.image-link').magnificPopup({
                        type: 'image',
                        gallery: {
                            enabled: true
                        }
                    });
                }

                // Re-initialize slick if not already initialized (for dynamic content)
                $('.shop-details-gallery-slider').on('init', function() {
                    $(this).css('visibility', 'visible');
                });

                // Report button - redirect to login if not authenticated, else open modal
                $(document).on('click', '.sid-report-btn', function() {
                    if ($(this).attr('data-is-auth') === '1') {
                        $('#reportModal').modal('show');
                    } else {
                        window.location.href = $(this).data('login-url');
                    }
                });

                // Report form submission
                $('#submitReport').on('click', function() {
                    var $btn = $(this);
                    $btn.prop('disabled', true).text('Submitting...');

                    $.ajax({
                        url: '{{ route('ad.report') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ad_id: $('input[name="ad_id"]').val(),
                            reason: $('#reportReason').val(),
                            message: $('#reportMessage').val(),
                        },
                        success: function(res) {
                            $('#reportModal').modal('hide');
                            toastr_success_js(res.message);
                            $btn.prop('disabled', false).text('Submit Report');
                        },
                        error: function(xhr) {
                            var msg = xhr.responseJSON && xhr.responseJSON.message ?
                                xhr.responseJSON.message :
                                'Something went wrong. Please try again.';
                            toastr_error_js(msg);
                            $btn.prop('disabled', false).text('Submit Report');
                        }
                    });
                });

                // Favourite toggle
                $(document).on('click', '.click_to_favorite_add_remove', function(e) {
                    e.preventDefault();
                    var $btn = $(this);

                    if (!$btn.data('is-auth')) {
                        window.location.href = $btn.data('login-url');
                        return;
                    }

                    var adId = $btn.data('listing_id');
                    var url = $btn.data('toggle-url');

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ad_id: adId
                        },
                        success: function(res) {
                            if (res.saved) {
                                $btn.addClass('is-favourited');
                                $btn.find('.favorite_add_icon').removeClass('lar').addClass(
                                    'las');
                                $btn.find('span').text('Saved');
                                toastr_success_js(res.message);
                            } else {
                                $btn.removeClass('is-favourited');
                                $btn.find('.favorite_add_icon').removeClass('las').addClass(
                                    'lar');
                                $btn.find('span').text('Save');
                                toastr_warning_js(res.message);
                            }
                        },
                        error: function() {
                            toastr_error_js('Something went wrong. Please try again.');
                        }
                    });
                });
            });
        })(jQuery);
    </script>
@endsection
