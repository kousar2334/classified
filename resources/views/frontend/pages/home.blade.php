@extends('frontend.layouts.master')
@section('meta')
    <title>{{ get_setting('site_name') }} - Classifieds ads</title>
    <title>{{ get_setting('site_name') }}: Your Gateway to Seamless Buying and Selling Experiences</title>
    <!-- Primary Meta Tags -->
    <meta name="title" content="Your Gateway to Seamless Buying and Selling Experiences">
    <meta name="description"
        content="Dive into the endless possibilities of buying and selling at ListOcean! Navigate a vast sea of opportunities as you connect with buyers and sellers effortlessly. Uncover incredible deals on a wide range of items or transform your unused items into treasure by listing them for sale. Immerse yourself in our dynamic community and enjoy the simplicity of buying and selling. Begin your oceanic journey today at ListOcean – where opportunities flow like waves!">
    <meta name="keywords"
        content="classified ads, free ads, buy and sell, online classifieds, cars, housing, electronics, community,Home & Livings,Fashion			,Sports	,Pet’s & Animals">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://localhost:8080/">
    <meta property="og:title" content="Your Gateway to Seamless Buying and Selling Experiences">
    <meta property="og:description"
        content="Dive into the endless possibilities of buying and selling at ListOcean! Navigate a vast sea of opportunities as you connect with buyers and sellers effortlessly. Uncover incredible deals on a wide range of items or transform your unused items into treasure by listing them for sale. Immerse yourself in our dynamic community and enjoy the simplicity of buying and selling. Begin your oceanic journey today at ListOcean – where opportunities flow like waves!">
    <meta property="og:image" content="http://localhost:8080//public/uploads/media-uploader/icon1717328206.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="http://localhost:8080/">
    <meta property="twitter:title" content="Your Gateway to Seamless Buying and Selling Experiences">
    <meta property="twitter:description"
        content="Dive into the endless possibilities of buying and selling at ListOcean! Navigate a vast sea of opportunities as you connect with buyers and sellers effortlessly. Uncover incredible deals on a wide range of items or transform your unused items into treasure by listing them for sale. Immerse yourself in our dynamic community and enjoy the simplicity of buying and selling. Begin your oceanic journey today at ListOcean – where opportunities flow like waves!">
    <meta property="twitter:description" content="http://localhost:8080//public/uploads/media-uploader/icon1717328206.png">
@endsection
@section('content')
    <!--Banner part Start-->
    <div class="home-banner" data-padding-top="100" data-padding-bottom="50"
        style="background-image: url({{ asset('/public/uploads/media-uploader/header1717328732.png') }});">

        <div class="container-1920 position-relative plr">
            <div class="letf-part-img">
                <div class="img-wraper">
                    <div class="img1 imges">
                        <img src="/public/uploads/media-uploader/img11715513859.png" alt="" />
                    </div>
                    <div class="img2 imges">
                        <img src="/public/uploads/media-uploader/img21715513597.png" alt="" />
                    </div>
                    <div class="img3 imges">
                        <img src="/public/uploads/media-uploader/img31715514924.png" alt="" />
                    </div>
                    <div class="img4 imges">
                        <img src="/public/uploads/media-uploader/img41715513597.png" alt="" />
                    </div>
                    <div class="img5 imges">
                        <img src="/public/uploads/media-uploader/img51715514984.png" alt="" />
                    </div>
                    <div class="img6 imges">
                        <img src="/public/uploads/media-uploader/img61715513596.png" alt="" />
                    </div>
                </div>
            </div>
            <div class="right-part-img">
                <div class="img-wraper">
                    <div class="img1 imges">
                        <img src="/public/uploads/media-uploader/img011715515047.png" alt="" />
                    </div>
                    <div class="img2 imges">
                        <img src="/public/uploads/media-uploader/img02-11715515047.png" alt="" />
                    </div>
                    <div class="img3 imges">
                        <img src="/public/uploads/media-uploader/img031715513595.png" alt="" />
                    </div>
                    <div class="img4 imges">
                        <img src="/public/uploads/media-uploader/img041715515087.png" alt="" />
                    </div>
                    <div class="img5 imges">
                        <img src="/public/uploads/media-uploader/img05-11715515086.png" alt="" />
                    </div>
                    <div class="img6 imges">
                        <img src="/public/uploads/media-uploader/img061715515086.png" alt="" />
                    </div>
                </div>
            </div>
            <div class="banner-wraper">
                <div class="banner-text">
                    <div class="top-text text-center">
                        <img src="/public/uploads/media-uploader/cup1715516782.png" alt="" />
                        #1 Classified Ad listing Platform in the US
                    </div>
                    <h1 class="banner-main-head text-center"> Buy anything you need Sell anything you want </h1>
                    <p class="text text-center">Country’s most loved and trusted classified ad listing website. Browse
                        thousand of classified items near you.</p>
                </div>
                <div class="banner-form">
                    <form action="listings.html" class="d-flex align-items-center banner-search-location" method="get">
                        <div class="banner-form-wraper align-items-center">
                            <div class="new_banner__search__input">
                                <div class="new_banner__search__location_left" id="myLocationGetAddress">
                                    <i class="fa-solid fa-location-crosshairs fs-4"></i>
                                </div>
                                <input class="form--control" name="change_address_new" id="change_address_new"
                                    type="hidden" value="">
                                <input class="banner-input-field w-100" name="autocomplete" id="autocomplete" type="text"
                                    placeholder="Search location here">
                            </div>
                            <div class="search-with-any-texts">
                                <input class="banner-input-field w-100" type="text" name="home_search" id="home_search"
                                    placeholder="What are you looking for?">
                                <span id="all_search_result" class="search_with_text_section"></span>
                            </div>
                        </div>
                        <div class="banner-btn">
                            <button type="submit" class="new-cmn-btn rounded-red-btn setLocation_btn border-0">Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Banner part End-->
    <!--Google Adds-->
    <div class="google-adds" data-padding-top="100" data-padding-bottom="50">
        <div class="text-center single-banner-ads ads-banner-box" id="home_advertisement_store">
            <input type="hidden" id="add_id" value="2">
            <a href="index.html"><img src="/public/uploads/media-uploader/image-161717309429.png" alt="" /></a>
        </div>
    </div>
    <!--Google Adds-->
    <!-- Categorie Area  S t a r t-->
    <div class="exploreCategories" data-padding-top="50" data-padding-bottom="50"
        style="background-color: rgb(255, 255, 255)">
        <div class="container-1440">
            <div class="row">
                <div class="col-xl-8 col-lg-7 col-md-10 col-sm-10">
                    <div class="section-tittle">
                        <h2 class="tittle">Categorices </h2>
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
                        <!-- Single -->
                        <div class="singleCategories categories1 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="categoriIcon text-center">
                                <a href="listing/category/car-vehicles.html" class="title">
                                    <img src="/public/uploads/media-uploader/chatagori2-11715683293.png" alt="" />
                                </a>
                            </div>
                            <div class="categorie-text">
                                <h4 class="text-center">
                                    <a href="listing/category/car-vehicles.html" class="title oneLine mt-2"> Car &amp;
                                        Vehicles </a>
                                </h4>
                            </div>
                        </div>
                        <div class="singleCategories categories2 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="categoriIcon text-center">
                                <a href="listing/category/electronics.html" class="title">
                                    <img src="/public/uploads/media-uploader/shirt-21717939712.png" alt="" />
                                </a>
                            </div>
                            <div class="categorie-text">
                                <h4 class="text-center">
                                    <a href="listing/category/electronics.html" class="title oneLine mt-2"> Electronics
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <div class="singleCategories categories3 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="categoriIcon text-center">
                                <a href="listing/category/home-and-living.html" class="title">
                                    <img src="/public/uploads/media-uploader/chatagori161715683462.png" alt="" />
                                </a>
                            </div>
                            <div class="categorie-text">
                                <h4 class="text-center">
                                    <a href="listing/category/home-and-living.html" class="title oneLine mt-2"> Home
                                        &amp; Livings </a>
                                </h4>
                            </div>
                        </div>
                        <div class="singleCategories categories4 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="categoriIcon text-center">
                                <a href="listing/category/fashion.html" class="title">
                                    <img src="/public/uploads/media-uploader/chatagori41715684590.png" alt="" />
                                </a>
                            </div>
                            <div class="categorie-text">
                                <h4 class="text-center">
                                    <a href="listing/category/fashion.html" class="title oneLine mt-2"> Fashion </a>
                                </h4>
                            </div>
                        </div>
                        <div class="singleCategories categories5 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="categoriIcon text-center">
                                <a href="listing/category/books--sports--hobbies.html" class="title">
                                    <img src="/public/uploads/media-uploader/chatagori151715683419.png" alt="" />
                                </a>
                            </div>
                            <div class="categorie-text">
                                <h4 class="text-center">
                                    <a href="listing/category/books--sports--hobbies.html" class="title oneLine mt-2">
                                        Sports </a>
                                </h4>
                            </div>
                        </div>
                        <div class="singleCategories categories6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="categoriIcon text-center">
                                <a href="listing/category/pets-and-animals.html" class="title">
                                    <img src="/public/uploads/media-uploader/pet1715683570.png" alt="" />
                                </a>
                            </div>
                            <div class="categorie-text">
                                <h4 class="text-center">
                                    <a href="listing/category/pets-and-animals.html" class="title oneLine mt-2"> Pet’s
                                        &amp; Animals </a>
                                </h4>
                            </div>
                        </div>
                        <div class="singleCategories categories7 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="categoriIcon text-center">
                                <a href="listing/category/appliances.html" class="title">
                                    <img src="/public/uploads/media-uploader/chatagori31715683982.png" alt="" />
                                </a>
                            </div>
                            <div class="categorie-text">
                                <h4 class="text-center">
                                    <a href="listing/category/appliances.html" class="title oneLine mt-2"> Appliances
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <div class="singleCategories categories8 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="categoriIcon text-center">
                                <a href="listing/category/property.html" class="title">
                                    <img src="/public/uploads/media-uploader/shirt-2-11717939717.png" alt="" />
                                </a>
                            </div>
                            <div class="categorie-text">
                                <h4 class="text-center">
                                    <a href="listing/category/property.html" class="title oneLine mt-2"> Education </a>
                                </h4>
                            </div>
                        </div>
                        <div class="singleCategories categories9 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="categoriIcon text-center">
                                <a href="listing/category/mobile-phones.html" class="title">
                                    <img src="/public/uploads/media-uploader/phone1715683527.png" alt="" />
                                </a>
                            </div>
                            <div class="categorie-text">
                                <h4 class="text-center">
                                    <a href="listing/category/mobile-phones.html" class="title oneLine mt-2"> Mobile
                                        Phones </a>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End-of Categories -->
    <!-- top Listings  S t a r t -->
    <section class="featureListing" data-padding-top="50" data-padding-bottom="50" style="background-color:">
        <div class="container-1440">
            <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                <h2 class="head3">Top Listings</h2>
                <form id="filter_with_listing_page_top" action="listings.html" method="get">
                    <input type="hidden" name="listing_type_preferences" value="top_listing" />
                    <a href="index.html#" id="submit_form_listing_filter_top" class="see-all">See All <i
                            class="las la-angle-right"></i></a>
                </form>
            </div>
            <div class="slider-inner-margin">
                <!-- Single -->
                <div class="singleFeatureCard">
                    <div class="featureImg">
                        <div class="favourite-icon ">
                            <a href="javascript:void(0)" class="click_to_favorite_add_remove" data-listing_id="7">
                                <i class="lar la-heart icon favorite_add_icon"></i>
                            </a>
                        </div>
                        <a href="listing/exquisite-luxury-corner-2-3-seater-sofa-collection.html" class="main-card-image">
                            <img src="/public/uploads/media-uploader/alex-knight-j4uuknn43-m-unsplash1718095931.jpg"
                                alt="" />
                        </a>
                    </div>
                    <div class="featurebody">
                        <h4> <a href="listing/exquisite-luxury-corner-2-3-seater-sofa-collection.html"
                                class="featureTittle head4 twoLine">Exquisite Luxury: Corner &amp; 2+3 Seater Sofa
                                Collection</a> </h4>

                        <p class="featureCap d-flex align-items-center gap-1">
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.99984 7.83332C5.99984 8.36376 6.21055 8.87246 6.58562 9.24754C6.9607 9.62261 7.4694 9.83332 7.99984 9.83332C8.53027 9.83332 9.03898 9.62261 9.41405 9.24754C9.78912 8.87246 9.99984 8.36376 9.99984 7.83332C9.99984 7.30289 9.78912 6.79418 9.41405 6.41911C9.03898 6.04404 8.53027 5.83332 7.99984 5.83332C7.4694 5.83332 6.9607 6.04404 6.58562 6.41911C6.21055 6.79418 5.99984 7.30289 5.99984 7.83332Z"
                                    stroke="#64748B" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M11.7712 11.6047L8.94251 14.4333C8.6925 14.6831 8.35356 14.8234 8.00017 14.8234C7.64678 14.8234 7.30785 14.6831 7.05784 14.4333L4.22851 11.6047C3.48265 10.8588 2.97473 9.90845 2.76896 8.8739C2.5632 7.83934 2.66883 6.767 3.07251 5.79247C3.47618 4.81795 4.15977 3.98501 5.03683 3.39899C5.91388 2.81297 6.94502 2.50018 7.99984 2.50018C9.05466 2.50018 10.0858 2.81297 10.9629 3.39899C11.8399 3.98501 12.5235 4.81795 12.9272 5.79247C13.3308 6.767 13.4365 7.83934 13.2307 8.8739C13.0249 9.90845 12.517 10.8588 11.7712 11.6047Z"
                                    stroke="#64748B" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="oneLine"> Chicago, United States </span>
                        </p>

                        <div class="btn-wrapper">
                            <span class="pro-btn2">
                                <svg width="7" height="10" viewBox="0 0 7 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 0V3.88889H7L3 10V6.11111H0L4 0Z" fill="white" />
                                </svg> FEATURED
                            </span>
                        </div>

                        <span class="featurePricing d-flex justify-content-between align-items-center">
                            <span class="money">$1,200.00</span>
                            <span class="date">
                                1 year ago
                            </span>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End-of top -->
    <!-- top Listings  S t a r t -->
    <section class="featureListing" data-padding-top="50" data-padding-bottom="50" style="background-color:">
        <div class="container-1440">
            <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                <h2 class="head3"> Electronics</h2>
                <form id="filter_with_listing_page_category_wise_listing" action="listings.html" method="get">
                    <input type="hidden" name="cat" value="2" />
                    <a href="index.html#" class="submit_form_listing_filter_category_wise_listing see-all">See all <i
                            class="las la-angle-right"></i></a>
                </form>
            </div>
            <div class="slider-inner-margin">
                <!-- Single -->
                <div class="singleFeatureCard">
                    <div class="featureImg">
                        <div class="favourite-icon ">
                            <a href="javascript:void(0)" class="click_to_favorite_add_remove" data-listing_id="15">
                                <i class="lar la-heart icon favorite_add_icon"></i>
                            </a>
                        </div>
                        <a href="listing/ehs-18crn-new-elite-1-5-ton-split-ac.html" class="main-card-image">
                            <img src="/public/uploads/media-uploader/listing1-11715592687.png" alt="" />
                        </a>
                    </div>
                    <div class="featurebody">
                        <h4> <a href="listing/ehs-18crn-new-elite-1-5-ton-split-ac.html"
                                class="featureTittle head4 twoLine">EHS-18CRN|NEW Elite 1.5 Ton Split AC</a> </h4>

                        <p class="featureCap d-flex align-items-center gap-1">
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.99984 7.83332C5.99984 8.36376 6.21055 8.87246 6.58562 9.24754C6.9607 9.62261 7.4694 9.83332 7.99984 9.83332C8.53027 9.83332 9.03898 9.62261 9.41405 9.24754C9.78912 8.87246 9.99984 8.36376 9.99984 7.83332C9.99984 7.30289 9.78912 6.79418 9.41405 6.41911C9.03898 6.04404 8.53027 5.83332 7.99984 5.83332C7.4694 5.83332 6.9607 6.04404 6.58562 6.41911C6.21055 6.79418 5.99984 7.30289 5.99984 7.83332Z"
                                    stroke="#64748B" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M11.7712 11.6047L8.94251 14.4333C8.6925 14.6831 8.35356 14.8234 8.00017 14.8234C7.64678 14.8234 7.30785 14.6831 7.05784 14.4333L4.22851 11.6047C3.48265 10.8588 2.97473 9.90845 2.76896 8.8739C2.5632 7.83934 2.66883 6.767 3.07251 5.79247C3.47618 4.81795 4.15977 3.98501 5.03683 3.39899C5.91388 2.81297 6.94502 2.50018 7.99984 2.50018C9.05466 2.50018 10.0858 2.81297 10.9629 3.39899C11.8399 3.98501 12.5235 4.81795 12.9272 5.79247C13.3308 6.767 13.4365 7.83934 13.2307 8.8739C13.0249 9.90845 12.517 10.8588 11.7712 11.6047Z"
                                    stroke="#64748B" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="oneLine"> Dhaka, Bangladesh </span>
                        </p>

                        <div class="btn-wrapper">
                            <span class="pro-btn2">
                                <svg width="7" height="10" viewBox="0 0 7 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 0V3.88889H7L3 10V6.11111H0L4 0Z" fill="white" />
                                </svg> FEATURED
                            </span>
                        </div>

                        <span class="featurePricing d-flex justify-content-between align-items-center">
                            <span class="money">$500.00</span>
                            <span class="date">
                                1 year ago
                            </span>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End-of top -->
    <section class="aboutArea" data-padding-top="50" data-padding-bottom="50"
        style="background-color:rgb(255, 255, 255)">
        <div class="container-1440">
            <div class="aboutAreaWraper"
                style="background-image: url(/public/uploads/media-uploader/group-343641717336658.png);">
                <div class="row justify-content-between flex-lg-row flex-column-reverse gap-lg-0 gap-4">
                    <div class="col-lg-6">
                        <div class="about-caption">
                            <!-- Section Tittle -->
                            <div class="section-tittle section-tittle2 mb-80">
                                <h2 class="head2 wow fadeInUp" data-wow-delay="0.1s">Earn cash by selling or Find
                                    anything you desire</h2>
                                <p class="wow fadeInUp mt-3" data-wow-delay="0.2s">Earn cash by selling your pre-loved
                                    or new items on our platform or you can find anything on our platform you desire.
                                </p>
                            </div>
                            <div class="btn-wrapper">
                                <a href="user/listing/add.html" class="cmn-btn2 mr-15 mb-10 wow fadeInLeft"
                                    data-wow-delay="0.3s">Post Your Ads</a>
                                <a href="listings.html" class="cmn-btn2 transparent-btn mb-10 wow fadeInRight"
                                    data-wow-delay="0.3s">Browse ads</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- about-img -->
                        <div class="aboutImg tilt-effect wow fadeInRight ps-lg-5" data-wow-delay="0.1s">
                            <img src="/public/uploads/media-uploader/about11713418479.png" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- top Listings  S t a r t -->
    <section class="featureListing" data-padding-top="50" data-padding-bottom="50" style="background-color:">
        <div class="container-1440">
            <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                <h2 class="head3"> Car &amp; Vehicles</h2>
                <form id="filter_with_listing_page_category_wise_listing" action="listings.html" method="get">
                    <input type="hidden" name="cat" value="1" />
                    <a href="index.html#" class="submit_form_listing_filter_category_wise_listing see-all">See all <i
                            class="las la-angle-right"></i></a>
                </form>
            </div>
            <div class="slider-inner-margin">
                <!-- Single -->
                <div class="singleFeatureCard">
                    <div class="featureImg">
                        <div class="favourite-icon ">
                            <a href="javascript:void(0)" class="click_to_favorite_add_remove" data-listing_id="86">
                                <i class="lar la-heart icon favorite_add_icon"></i>
                            </a>
                        </div>
                        <a href="listing/2024-bmw-s1000r.html" class="main-card-image">
                            <img src="/public/uploads/media-uploader/pexels-jakubsisulak-69244951718103450.jpg"
                                alt="" />
                        </a>
                    </div>
                    <div class="featurebody">
                        <h4> <a href="listing/2024-bmw-s1000r.html" class="featureTittle head4 twoLine">2024 BMW
                                S1000R</a> </h4>

                        <p class="featureCap d-flex align-items-center gap-1">
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.99984 7.83332C5.99984 8.36376 6.21055 8.87246 6.58562 9.24754C6.9607 9.62261 7.4694 9.83332 7.99984 9.83332C8.53027 9.83332 9.03898 9.62261 9.41405 9.24754C9.78912 8.87246 9.99984 8.36376 9.99984 7.83332C9.99984 7.30289 9.78912 6.79418 9.41405 6.41911C9.03898 6.04404 8.53027 5.83332 7.99984 5.83332C7.4694 5.83332 6.9607 6.04404 6.58562 6.41911C6.21055 6.79418 5.99984 7.30289 5.99984 7.83332Z"
                                    stroke="#64748B" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M11.7712 11.6047L8.94251 14.4333C8.6925 14.6831 8.35356 14.8234 8.00017 14.8234C7.64678 14.8234 7.30785 14.6831 7.05784 14.4333L4.22851 11.6047C3.48265 10.8588 2.97473 9.90845 2.76896 8.8739C2.5632 7.83934 2.66883 6.767 3.07251 5.79247C3.47618 4.81795 4.15977 3.98501 5.03683 3.39899C5.91388 2.81297 6.94502 2.50018 7.99984 2.50018C9.05466 2.50018 10.0858 2.81297 10.9629 3.39899C11.8399 3.98501 12.5235 4.81795 12.9272 5.79247C13.3308 6.767 13.4365 7.83934 13.2307 8.8739C13.0249 9.90845 12.517 10.8588 11.7712 11.6047Z"
                                    stroke="#64748B" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="oneLine"> ঢাকা, Bangladesh </span>
                        </p>

                        <div class="btn-wrapper">
                        </div>

                        <span class="featurePricing d-flex justify-content-between align-items-center">
                            <span class="money">$1,000.00</span>
                            <span class="date">
                                1 year ago
                            </span>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End-of top -->
    <!-- Membership Card Start-->
    <section class="pricingCard plr" data-padding-top="50" data-padding-bottom="50">
        <div class="container-1440">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-7 col-md-10 col-sm-10">
                    <div class="section-tittle text-center mb-50">
                        <h2 class="head3">Membership</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="singlePrice  mb-24 wow fadeInLeft" data-wow-delay="0.0s">
                        <h4 class="priceTittle">Free </h4>
                        <span class="price">$0.00
                            <span class="subTittle">Free</span>
                        </span>
                        <div class="btn-wrapper">
                            <!-- Free Membership Plan -->

                            <!--if user membership empty buy free membership -->
                            <!--free membership form start -->
                            <form action="http://localhost:8080/membership/buy" method="post">
                                <input type="hidden" name="_token" value="4qMgoof0CGXn76Y2Ovd5AWGkX891VOaiaqMZeUxn"
                                    autocomplete="off"> <input type="hidden" name="membership_id" class="membership_id"
                                    value="1">
                                <input type="hidden" name="price" value="0">
                                <input type="hidden" name="selected_payment_gateway" class="selected_payment_gateway"
                                    value="Trial">
                                <button type="submit" class="cmn-btn-outline1">Get Started</button>
                            </form>
                            <!--free membership form end -->
                        </div>

                        <ul class="listing mt-3">
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Listing 5
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Gallery Images Per Listing 2
                            </li>
                            <li class="listItem">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Featured Listings 0
                            </li>
                            <li class="listItem">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Business Hour Not Allowed
                            </li>
                            <li class="listItem">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Enquiry Form Not Allowed
                            </li>
                            <li class="listItem">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Membership Badge Not Allowed
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="singlePrice  mb-24 wow fadeInLeft" data-wow-delay="0.0s">
                        <h4 class="priceTittle">Weekly </h4>
                        <span class="price">$10.00
                            <span class="subTittle">Weekly</span>
                        </span>
                        <div class="btn-wrapper">
                            <!-- Paid Membership Plan -->
                            <button class="cmn-btn-outline1 choose_membership_plan" data-bs-toggle="modal" data-id="2"
                                data-price="10" data-bs-target="#loginModal">
                                Buy Now
                            </button>
                        </div>

                        <ul class="listing mt-3">
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Listing 10
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Gallery Images Per Listing 5
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Featured Listings 5
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Business Hour Allowed
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Enquiry Form Allowed
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Membership Badge Allowed
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="singlePrice  mb-24 wow fadeInLeft" data-wow-delay="0.0s">
                        <h4 class="priceTittle">Monthly </h4>
                        <span class="price">$50.00
                            <span class="subTittle">Monthly</span>
                        </span>
                        <div class="btn-wrapper">
                            <!-- Paid Membership Plan -->
                            <button class="cmn-btn-outline1 choose_membership_plan" data-bs-toggle="modal" data-id="3"
                                data-price="50" data-bs-target="#loginModal">
                                Buy Now
                            </button>
                        </div>

                        <ul class="listing mt-3">
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Listing 20
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Gallery Images Per Listing 10
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Featured Listings 10
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Business Hour Allowed
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Enquiry Form Allowed
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Membership Badge Allowed
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="singlePrice  mb-24 wow fadeInLeft" data-wow-delay="0.0s">
                        <h4 class="priceTittle">Yearly </h4>
                        <span class="price">$100.00
                            <span class="subTittle">Yearly</span>
                        </span>
                        <div class="btn-wrapper">
                            <!-- Paid Membership Plan -->
                            <button class="cmn-btn-outline1 choose_membership_plan" data-bs-toggle="modal" data-id="4"
                                data-price="100" data-bs-target="#loginModal">
                                Buy Now
                            </button>
                        </div>

                        <ul class="listing mt-3">
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Listing 50
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Gallery Images Per Listing 20
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Featured Listings 20
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Business Hour Allowed
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Enquiry Form Allowed
                            </li>
                            <li class="listItem check">
                                <div class="checkicon me-2">
                                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.38561 11.9999C6.34326 11.9999 6.30137 11.9913 6.26258 11.9748C6.22378 11.9583 6.18891 11.9342 6.16017 11.9039L0.0815684 5.5059C0.0410469 5.46325 0.0141836 5.41003 0.00426649 5.35275C-0.00565067 5.29547 0.00180835 5.23662 0.0257308 5.1834C0.0496532 5.13018 0.0890012 5.08491 0.138959 5.05311C0.188917 5.02131 0.247317 5.00438 0.307013 5.00438H3.23292C3.27685 5.00438 3.32026 5.01356 3.36024 5.03128C3.40022 5.049 3.43582 5.07486 3.46465 5.10712L5.49615 7.38125C5.7157 6.9246 6.1407 6.16424 6.88652 5.23772C7.98909 3.868 10.0399 1.85355 13.5487 0.0350571C13.6165 -8.32163e-05 13.6954 -0.00920352 13.7698 0.00949718C13.8442 0.0281979 13.9086 0.0733601 13.9505 0.136066C13.9923 0.198772 14.0085 0.274464 13.9958 0.348195C13.983 0.421926 13.9424 0.488336 13.8818 0.534313C13.8684 0.5445 12.5155 1.58113 10.9586 3.4799C9.52566 5.22724 7.62085 8.0844 6.68355 11.773C6.66708 11.8378 6.62879 11.8953 6.57477 11.9365C6.52075 11.9776 6.45413 12 6.38552 12L6.38561 11.9999Z"
                                            fill="#22C55E"></path>
                                    </svg>
                                </div>
                                Membership Badge Allowed
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End-of Membership -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="LoginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="index.html#" method="post">
                <input type="hidden" name="_token" value="4qMgoof0CGXn76Y2Ovd5AWGkX891VOaiaqMZeUxn"
                    autocomplete="off">
                <input type="hidden" id="membership_price">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="LoginModalLabel">
                            Login to buy Membership
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="alert alert-warning " role="alert">
                            <p>Notice: You must login as a user to buy a membership</p>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                        </div>
                        <div class="error-message"></div>
                        <div class="input-form">
                            <label class="infoTitle">Email Or User Name</label>
                            <input class="form-control radius-10" type="text" name="username" id="username"
                                placeholder="Email Or User Name">
                        </div>

                        <div class="single-input mt-4">
                            <label class="label-title mb-2"> Password </label>
                            <div class="input-form position-relative">
                                <input class="form-control radius-10" type="password" name="password" id="password"
                                    placeholder="Type Password">
                                <div class="icon toggle-password position-absolute">
                                    <i class="las la-eye icon"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer flex-column">
                        <div class="btn-wrapper text-center">
                            <button type="submit" class="cmn-btn4 w-100 mb-60 login_to_buy_a_membership">Login</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- top Listings  S t a r t -->
    <section class="featureListing" data-padding-top="50" data-padding-bottom="100"
        style="background-color:rgb(255, 255, 255)">
        <div class="container-1440">
            <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                <h2 class="head3">Recent Listing</h2>
                <form id="filter_with_listing_page_recent" action="listings.html" method="get">
                    <input type="hidden" name="sortby" value="latest_listing" />
                    <a href="index.html#" id="submit_form_listing_filter_recent" class="see-all">See All <i
                            class="las la-angle-right"></i></a>
                </form>
            </div>
            <div class="slider-inner-margin">
                <!-- Single -->
                <div class="singleFeatureCard">
                    <div class="featureImg">
                        <div class="favourite-icon ">
                            <a href="javascript:void(0)" class="click_to_favorite_add_remove" data-listing_id="49">
                                <i class="lar la-heart icon favorite_add_icon"></i>
                            </a>
                        </div>
                        <a href="listing/10-sustainable-sofa-upcycling.html" class="main-card-image">
                            <img src="/public/uploads/media-uploader/christian-kaindl-4ud9w-pxbta-unsplash1717946299.jpg"
                                alt="" />
                        </a>
                    </div>
                    <div class="featurebody">
                        <h4> <a href="listing/10-sustainable-sofa-upcycling.html" class="featureTittle head4 twoLine">10
                                Sustainable Sofa Upcycling</a> </h4>

                        <p class="featureCap d-flex align-items-center gap-1">
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.99984 7.83332C5.99984 8.36376 6.21055 8.87246 6.58562 9.24754C6.9607 9.62261 7.4694 9.83332 7.99984 9.83332C8.53027 9.83332 9.03898 9.62261 9.41405 9.24754C9.78912 8.87246 9.99984 8.36376 9.99984 7.83332C9.99984 7.30289 9.78912 6.79418 9.41405 6.41911C9.03898 6.04404 8.53027 5.83332 7.99984 5.83332C7.4694 5.83332 6.9607 6.04404 6.58562 6.41911C6.21055 6.79418 5.99984 7.30289 5.99984 7.83332Z"
                                    stroke="#64748B" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M11.7712 11.6047L8.94251 14.4333C8.6925 14.6831 8.35356 14.8234 8.00017 14.8234C7.64678 14.8234 7.30785 14.6831 7.05784 14.4333L4.22851 11.6047C3.48265 10.8588 2.97473 9.90845 2.76896 8.8739C2.5632 7.83934 2.66883 6.767 3.07251 5.79247C3.47618 4.81795 4.15977 3.98501 5.03683 3.39899C5.91388 2.81297 6.94502 2.50018 7.99984 2.50018C9.05466 2.50018 10.0858 2.81297 10.9629 3.39899C11.8399 3.98501 12.5235 4.81795 12.9272 5.79247C13.3308 6.767 13.4365 7.83934 13.2307 8.8739C13.0249 9.90845 12.517 10.8588 11.7712 11.6047Z"
                                    stroke="#64748B" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="oneLine"> Sanger, United States </span>
                        </p>

                        <div class="btn-wrapper">
                        </div>

                        <span class="featurePricing d-flex justify-content-between align-items-center">
                            <span class="money">$1,000.00</span>
                            <span class="date">
                                1 year ago
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End-of top -->


    <div data-padding-top="50">
        <div class="container ">
            <div class="row">
                <div class="col-lg-8 ">

                </div>

                <div class="col-md-6 col-lg-4  widg ">
                    <div class="widget-area-wrapper custom-margin-widget  style-" data-padding-bottom="0">

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
