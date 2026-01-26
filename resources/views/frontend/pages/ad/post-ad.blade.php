@extends('frontend.layouts.master')
@section('meta')
    <title>Post ad - {{ get_setting('site_name') }}</title>
    <link rel="stylesheet" href="../../assets/backend/css/dropzone.css">
    <link rel="stylesheet" href="../../assets/backend/css/media-uploader.css">
    <link rel="stylesheet" href="../../assets/backend/css/summernote.css">
    <link rel="stylesheet" href="../../assets/backend/css/bootstrap-tagsinput.css">
    <style>
        input#pac-input {
            background-color: ghostwhite;
        }

        .select2-container .select2-selection--single {
            background-color: var(--white-bg);
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            position: relative;
            height: auto;
            padding: 10px;
        }

        span.select2.select2-container.select2-container--default.select2-container--focus {
            width: 100% !important;
        }

        .select-itms span.select2 {
            width: 100% !important;
        }


        .close {
            border: none;
        }

        .dashboard-switch-single {
            font-size: 20px;
        }

        .swal_delete_button {
            color: #da0000 !important;
        }

        /* Default styles for the input box */
        #pac-input {
            height: 3em;
            width: 75%;
            margin-left: 140px;
            border: 1px solid;
            top: 4px;
            font-size: 16px;
        }

        /* Media query for screens smaller than 768px */
        @media (max-width: 1499px) {
            #pac-input {
                width: 100%;
                margin-left: 0;
            }
        }

        /*select tags start css*/
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #e3e3e3;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: 1px solid #e3e3e3;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            font-size: 23px;
        }

        .select2-selection__choice__display {
            font-size: 15px;
            color: #000;
            font-weight: 400;
        }

        /*select tags end css*/

        /* price and number css start   */
        label.infoTitle.position-absolute {
            top: 0;
            background-color: whitesmoke;
            left: 0;
            padding: 10px 15px;
        }

        .checkBox.position-absolute {
            right: 0;
            top: 0;
            background-color: whitesmoke;
            padding: 10px 15px;
        }

        input.effectBorder.checkBox__input {
            border: 2px solid #a3a3a3;
        }

        /* price and number css end   */

        button.btn.btn-info.media_upload_form_btn {
            background-color: rgb(239, 246, 255);
            border: none;
            color: rgb(59, 130, 246);
            outline: none;
            box-shadow: none;
            margin: auto;
        }

        .new_image_add_listing .attachment-preview {
            width: 200px;
            height: 200px;
            border-radius: 6px;
            overflow: hidden;
        }

        .new_image_add_listing .attachment-preview .thumbnail .centered img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transform: translation(-50%, -50%);
        }

        .new_image_gallery_add_listing .attachment-preview {
            width: 100px;
            height: 100px;
            border-radius: 6px;
            overflow: hidden;
        }

        .new_image_gallery_add_listing .attachment-preview .thumbnail .centered img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transform: translation(-50%, -50%);
        }

        .media-upload-btn-wrapper .img-wrap .rmv-span {
            padding: 0;
        }
    </style>
    <style>
        .input-group .form-control.is-valid,
        .input-group .form-select.is-valid,
        .was-validated .input-group .form-control:valid,
        .was-validated .input-group .form-select:valid {
            z-index: 0 !important;
        }
    </style>
@endsection
@section('content')
    <div class="add-listing-wrapper mt-5 mb-5">
        <!--check user verification -->

        <!--Nav Bar Tabs markup start -->
        <div style="display: none" class="nav nav-pills" id="add-listing-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link  stepIndicator active stepForm_btn__previous" id="listing-info-tab" data-bs-toggle="pill"
                href="add-listing.html#listing-info" role="tab" aria-controls="listing-info" aria-selected="true">
                <span class="nav-link-number">1</span>
                Listing Info
            </a>

            <a class="nav-link  stepIndicator" id="location-tab" data-bs-toggle="pill" href="add-listing.html#media-uploads"
                role="tab" aria-controls="media-uploads" aria-selected="true">
                <span class="nav-link-number">2</span>
                Location
            </a>
        </div>
        <form action="add-listing.html" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="4qMgoof0CGXn76Y2Ovd5AWGkX891VOaiaqMZeUxn" autocomplete="off">
            <div class="add-listing-content-wrapper">
                <div class="tab-content add-listing-content" id="add-listing-tabContent">
                    <!-- listing Info start-->
                    <div class="tab-pane fade step active show" id="listing-info" role="tabpanel"
                        aria-labelledby="listing-info-tab">
                        <!--Post your add-->
                        <div class="post-your-add">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mt-3 mb-2">
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-lg-8">
                                        <div class="post-add-wraper">
                                            <div class="item-name box-shadow1 p-24">
                                                <label for="item-name">Item Name <span class="text-danger">*</span> </label>
                                                <input type="text" name="title" id="title" value=""
                                                    class="input-filed w-100" placeholder="Item Name">

                                            </div>
                                            <div class="about-item box-shadow1 p-24 mt-4">
                                                <h3 class="head4">About Item</h3>
                                                <div class="row g-3 mt-3">
                                                    <div class="col-sm-12">
                                                        <div class="item-catagory-wraper">
                                                            <label for="item-catagory">Item Category <span
                                                                    class="text-danger">*</span> </label>
                                                            <select name="category" id="select-category"
                                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                                required>
                                                                <option value="">Select a category</option>
                                                                @foreach ($categories as $key => $category)
                                                                    @if (is_array($category) && isset($category['subcategories']))
                                                                        <optgroup label="{{ $category['name'] }}">
                                                                            @foreach ($category['subcategories'] as $subKey => $subcategory)
                                                                                @if (is_array($subcategory) && isset($subcategory['subcategories']))
                                                                        <optgroup
                                                                            label="&nbsp;&nbsp;{{ $subcategory['name'] }}">
                                                                            @foreach ($subcategory['subcategories'] as $subSubKey => $subSubcategory)
                                                                                <option value="{{ $subSubKey }}"
                                                                                    {{ old('category') == $subSubKey ? 'selected' : '' }}>
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;{{ is_array($subSubcategory) ? $subSubcategory['name'] : $subSubcategory }}
                                                                                </option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                    @else
                                                                        <option value="{{ $subKey }}"
                                                                            {{ old('category') == $subKey ? 'selected' : '' }}>
                                                                            &nbsp;&nbsp;{{ is_array($subcategory) ? $subcategory['name'] : $subcategory }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                                </optgroup>
                                                            @else
                                                                <option value="{{ $key }}"
                                                                    {{ old('category') == $key ? 'selected' : '' }}>
                                                                    {{ is_array($category) ? $category['name'] : $category }}
                                                                </option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                            <p class="text-sm text-gray-500 mt-1" id="category-breadcrumb">
                                                            </p>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="description box-shadow1 p-24 mt-4">
                                                <label for="description">Description <span class="text-danger">*</span>
                                                    <span class="text-danger">(minimum 150 characters.)</span> </label>
                                                <textarea name="description" id="description" rows="6" class="input-filed w-100 textarea--form summernote"
                                                    placeholder="Enter a Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="right-sidebar">
                                            <div class="box-shadow1 price p-24">
                                                <div class="price-wraper">
                                                    <label for="price">Price <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number" name="price" id="price" value=""
                                                        class="input-filed w-100 mb-3" placeholder="0.00">
                                                    <label class="negotiable">
                                                        <input type="checkbox" class="custom-check-box" name="negotiable"
                                                            id="negotiable">
                                                        <span class="ms-2">Negotiable</span>
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="box-shadow1 hode-phone-number p-24 mt-3">
                                                <label class="hide-number">
                                                    <input type="checkbox" class="custom-check-box"
                                                        name="hide_phone_number" value="">
                                                    <span class="black-font"> Hide My Phone Number</span>
                                                </label>
                                                <div class="input-group mt-3">
                                                    <input type="hidden" id="country-code" name="country_code">
                                                    <input class="input-filed w-100" type="tel" name="phone"
                                                        value="" id="phone" placeholder="Type Phone">
                                                    <span id="phone_availability"></span>
                                                    <div class="d-none">
                                                        <span id="error-msg" class="hide"></span>
                                                        <p id="result" class="d-none"></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="upload-img text-center mt-3">
                                                <div class="media-upload-btn-wrapper">
                                                    <div class="img-wrap new_image_add_listing">
                                                        <img src="../../assets/common/img/listing_single_image.jpg"
                                                            alt="images" class="w-100">
                                                    </div>
                                                    <input type="hidden" name="image">
                                                    <button type="button" class="btn btn-info media_upload_form_btn"
                                                        data-btntitle="Select Image" data-modaltitle="Upload Image"
                                                        data-bs-toggle="modal" data-bs-target="#media_upload_modal">
                                                        Click to browse &amp; Upload Featured Image
                                                    </button>
                                                    <small>image format: jpg,jpeg,png,gif,webp</small> <br>
                                                    <small>recommended size 810x450</small>
                                                </div>
                                            </div>

                                            <div class="picture mt-3">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <div class="upload-img text-center mt-3">
                                                            <div class="media-upload-btn-wrapper">
                                                                <div class="img-wrap new_image_gallery_add_listing">
                                                                    <img src="../../assets/common/img/listing_single_image.jpg"
                                                                        alt="images" class="w-100">
                                                                </div>
                                                                <input type="hidden" name="gallery_images">
                                                                <button type="button"
                                                                    class="btn btn-info media_upload_form_btn"
                                                                    data-btntitle="Select Image"
                                                                    data-modaltitle="Upload Image" data-mulitple="true"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#media_upload_modal">
                                                                    Click to Upload Gallery Images
                                                                </button>
                                                                <small>image format: jpg,jpeg,png,gif,webp</small> <br>
                                                                <small>recommended size 810x450</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- start previous / next buttons -->
                                            <div class="continue-btn mt-3">
                                                <div class="btn-wrapper mb-10 d-flex justify-content-end gap-3">
                                                    <button class="red-btn w-100 d-block" style="border: none"
                                                        id="nextBtn" type="button">Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- listing Info end-->

                    <!-- location start-->
                    <div class="tab-pane fade step" id="media-uploads" role="tabpanel" aria-labelledby="location-tab">
                        <div class="post-your-add add-location section-padding2">
                            <div class="container-1920 plr1">
                                <div class="row">
                                    <div class="col-xl-2">
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="address box-shadow1 p-24">
                                            <!--Google Map -->
                                            <div class="location-map mt-3">
                                                <label class="infoTitle">Google Map Location
                                                    <a href="https://drive.google.com/file/d/1BwDAjSLAeb4LaxzOkrdsgGO_Io2jM6S6/view?usp=sharing"
                                                        target="_blank">
                                                        <strong class="text-warning">Video link</strong>
                                                    </a><small class="text-info">Search your location, pick a location
                                                    </small>
                                                </label>
                                                <div class="input-form input-form2">
                                                    <div class="map-warper dark-support rounded overflow-hidden">
                                                        <input id="pac-input" class="controls rounded" type="text"
                                                            placeholder="Search your location" />
                                                        <div id="map_canvas" style="height: 480px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="address-text mt-3">
                                                <input type="hidden" name="latitude" id="latitude">
                                                <input type="hidden" name="longitude" id="longitude">
                                                <label for="address-text">Address</label>
                                                <input type="text" class="w-100 input-filed" name="address"
                                                    id="user_address" value="" placeholder="Address">
                                            </div>
                                        </div>
                                        <div class="video box-shadow1 p-24 mt-3 mb-3">
                                            <label for="vedio-link">Video Url</label>
                                            <input type="text" class="input-filed w-100" name="video_url"
                                                id="video_url" value="" placeholder="youtube url">
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="right-sidebar">
                                            <div class="box-shadow1 feature p-24">
                                                <label>
                                                    <input type="checkbox" name="is_featured" id="is_featured"
                                                        value="" class="custom-check-box feature_disable_color">
                                                    <span class="ms-2">Feature This Ad</span>
                                                </label>
                                                <p>To feature this ad, you will need to subscribe to a.
                                                    <a href="../../membership.html">paid membership</a>
                                                </p>
                                            </div>

                                            <div class="box-shadow1 tags p-24 mt-3">
                                                <label for="tags">Tags</label>
                                                <div class="select-itms">
                                                    <select name="tags[]" id="tags" class="select2_activation"
                                                        multiple>
                                                        <option value="1">iPhone</option>
                                                        <option value="2">Android</option>
                                                        <option value="3">Smartphone</option>
                                                        <option value="4">Computers</option>
                                                        <option value="5">Laptops</option>
                                                        <option value="6">Tablets</option>
                                                        <option value="7">Cameras</option>
                                                        <option value="8">TVs</option>
                                                        <option value="9">Audio equipment</option>
                                                        <option value="10">Cars</option>
                                                        <option value="11">Trucks</option>
                                                        <option value="12">Motorcycles</option>
                                                        <option value="13">Auto parts</option>
                                                        <option value="14">Car accessories</option>
                                                        <option value="15">Furniture</option>
                                                        <option value="16">Home decor</option>
                                                        <option value="17">Bedding</option>
                                                        <option value="18">Lighting</option>
                                                        <option value="19">Home improvement</option>
                                                        <option value="20">Organization</option>
                                                        <option value="21">Clothing</option>
                                                        <option value="22">Jewelry</option>
                                                        <option value="23">Watches</option>
                                                        <option value="24">Sports apparel</option>
                                                        <option value="25">Pet food</option>
                                                        <option value="26">Pet toys</option>
                                                        <option value="27">Dog supplies</option>
                                                        <option value="28">Kitchen appliances</option>
                                                        <option value="29">Home appliances</option>
                                                        <option value="30">Small appliances</option>
                                                        <option value="31">Online courses</option>
                                                        <option value="32">Skill development</option>
                                                        <option value="33">E-learning platforms</option>
                                                        <option value="51">Sports</option>
                                                        <option value="52">Nike</option>
                                                        <option value="53">Adidas</option>
                                                        <option value="54">Gym</option>
                                                        <option value="55">Shoes</option>
                                                        <option value="56">Style</option>
                                                        <option value="57">Fashion</option>
                                                        <option value="58">Men’s</option>
                                                        <option value="59">Sportswear</option>
                                                        <option value="60">neque</option>
                                                        <option value="61">Similique</option>
                                                        <option value="62">Lorem</option>
                                                        <option value="63">consequuntur</option>
                                                        <option value="64">car</option>
                                                        <option value="65">cosmetics</option>
                                                        <option value="66">cat</option>
                                                        <option value="67">microwave</option>
                                                        <option value="68">daewoo</option>
                                                        <option value="69">study</option>
                                                        <option value="70">Tuitions</option>
                                                        <option value="71">and</option>
                                                        <option value="72">Coaching</option>
                                                        <option value="73">Book</option>
                                                        <option value="74">music</option>
                                                        <option value="75">Musical</option>
                                                        <option value="76">instruments</option>
                                                        <option value="77">Women&#039;s</option>
                                                        <option value="78">jeans</option>
                                                        <option value="79">AC</option>
                                                        <option value="80">sa</option>
                                                        <option value="81">iajs</option>
                                                        <option value="82">dasdokasdadl;akd;lakdl;asjdl</option>
                                                        <option value="83">jasdkl;</option>
                                                        <option value="84">asjd;lasd</option>
                                                        <option value="85">;laskjd</option>
                                                        <option value="86">lkasjdlkasdj</option>
                                                        <option value="87">
                                                            alsk;da;sdkas;l;adjasjklhdkjahdkjashdkjashdaksdkjashdkjashdkajsdhaskdaskjdhaskjdhaskjdhaskjdasdasd
                                                        </option>
                                                        <option value="88">dsf</option>
                                                        <option value="89">sdufh</option>
                                                        <option value="90">
                                                            sdfhsdfjdsfoisdjofjsoidfjsodfjsodifjsodifjsdlkfjsdlkfsdfsdf
                                                        </option>
                                                        <option value="91">sdfjklsfhsdjkfhsdkjfhsdkjfhskdjfhsdkjfs
                                                        </option>
                                                        <option value="92">
                                                            sdfnsdkjlhlfjsdlkfjsdlkfjsdklfjsdl;fksd;flkjsd;fjsdkfljsdkfhsdkjfhsdkjfhsdkjfhsdjklfhsdlkfhsdlfksdfjklhsdkjfhsdjkfhsdjkfhsdkjfhsdkjfsdoiaushjsadfhasjkdhaksjhdakjdhaskjdhaskjda
                                                        </option>
                                                        <option value="93">
                                                            yuashgdaudhaiusdhaisudaiudhasuidhyasiudhasudhaisudhiasdhoiasdjsakjdasldaskldhaskjdhaskjdhaskjdhaskjdhaskjdhaskjdhaskjd
                                                        </option>
                                                        <option value="94">
                                                            hnasiuasdasnjkdhnasjkhdkajsdhkasjdhasklaskdjhasdkjahskjdhaskjdhaskdasjkdgasdhasdkjaskjdaslkdlkasdasjkldhkajsldas
                                                        </option>
                                                        <option value="95">card</option>
                                                        <option value="96">basketball</option>
                                                        <option value="97">michael</option>
                                                        <option value="98">jordan</option>
                                                        <option value="99">HIRE</option>
                                                        <option value="100">carz</option>
                                                        <option value="101">nkjknj</option>
                                                        <option value="102">reger</option>
                                                        <option value="103">regg</option>
                                                        <option value="104">tamo</option>
                                                        <option value="105">56456</option>
                                                        <option value="106">jhkjk</option>
                                                        <option value="107">Temporibus</option>
                                                        <option value="108">samsung</option>
                                                        <option value="109">перевозка</option>
                                                        <option value="110">12121</option>
                                                        <option value="111">mumbai</option>
                                                        <option value="112">gggh</option>
                                                        <option value="113">kkkl</option>
                                                        <option value="114">d4ce</option>
                                                        <option value="115">ؤسئءءؤ</option>
                                                        <option value="116">ccccc</option>
                                                        <option value="117">gle</option>
                                                        <option value="118">For</option>
                                                        <option value="119">Forsale</option>
                                                        <option value="120">test</option>
                                                        <option value="121">nail</option>
                                                        <option value="122">salon</option>
                                                        <option value="123">domena</option>
                                                        <option value="124">bike</option>
                                                        <option value="125">huffy</option>
                                                        <option value="126">ad</option>
                                                        <option value="127">sdsd</option>
                                                        <option value="128">adad</option>
                                                        <option value="129">zzz</option>
                                                        <option value="130">sss</option>
                                                        <option value="131">Bro</option>
                                                        <option value="132">Khamastashar</option>
                                                        <option value="133">Max</option>
                                                        <option value="134">ufo</option>
                                                        <option value="135">برء</option>
                                                        <option value="136">ddd</option>
                                                        <option value="137">svetlo</option>
                                                        <option value="138">skoda</option>
                                                        <option value="139">auto</option>
                                                        <option value="140">GPixel</option>
                                                        <option value="141">Google</option>
                                                        <option value="142">Phone</option>
                                                        <option value="143">sample</option>
                                                        <option value="144">stuff</option>
                                                        <option value="145">towing</option>
                                                        <option value="146">sjafjskdgsdg</option>
                                                        <option value="147">clothes</option>
                                                        <option value="148">dvr</option>
                                                        <option value="149">gjtfh</option>
                                                        <option value="150">sofa</option>
                                                        <option value="151">home</option>
                                                        <option value="152">Fasion</option>
                                                        <option value="153">spa</option>
                                                        <option value="154">sdfsdf</option>
                                                        <option value="155">asdfsdf</option>
                                                        <option value="156">bikini</option>
                                                        <option value="157">bikinisets</option>
                                                        <option value="158">bikinidesign</option>
                                                        <option value="159">ecofriendlyswimwear</option>
                                                        <option value="160">swimsuits</option>
                                                        <option value="161">swimwear</option>
                                                        <option value="162">gwhwh</option>
                                                        <option value="163">vbvm</option>
                                                        <option value="164">fkj</option>
                                                        <option value="165">bdjd</option>
                                                        <option value="166">fjfj</option>
                                                        <option value="167">fjfjf</option>
                                                        <option value="168">gu</option>
                                                    </select>
                                                    <small>Select Your tags name or new tag name type</small>
                                                </div>
                                            </div>
                                            <div class="box-shadow1 tags p-24 mt-3">
                                                <div class="row">
                                                    <div class="col-xxl-12 col-lg-12">
                                                        <div
                                                            class="collapse_wrapper dashboard__card style_one bg__white padding-20 radius-10">
                                                            <div class="collapse_wrapper__header mb-3">
                                                                <h5 class="collapse_wrapper__header__title">Meta Section
                                                                </h5>
                                                            </div>
                                                            <div class="tab_wrapper style_seven">
                                                                <!--Tab Button  -->
                                                                <nav>
                                                                    <div class="nav nav-tabs flex-nowrap" id="nav-tab8"
                                                                        role="tablist">
                                                                        <a class="nav-link active" id="nav-21-tab"
                                                                            data-bs-toggle="tab"
                                                                            href="add-listing.html#blog_meta"
                                                                            role="tab" aria-controls="nav-21"
                                                                            aria-selected="true">Blog Meta</a>
                                                                        <a class="nav-link" id="nav-22-tab"
                                                                            data-bs-toggle="tab"
                                                                            href="add-listing.html#facebook_meta"
                                                                            role="tab" aria-controls="nav-22"
                                                                            aria-selected="false">Facebook Meta</a>
                                                                        <a class="nav-link" id="nav-23-tab"
                                                                            data-bs-toggle="tab"
                                                                            href="add-listing.html#twitter_meta"
                                                                            role="tab" aria-controls="nav-23"
                                                                            aria-selected="false">Twitter Meta</a>
                                                                    </div>
                                                                </nav>
                                                                <!--End-of Tab Button  -->
                                                                <!-- Tab Contents -->
                                                                <div class="tab-content mt-4" id="nav-tabContent8">
                                                                    <div class="tab-pane fade show active" id="blog_meta"
                                                                        role="tabpanel" aria-labelledby="nav-21-tab">

                                                                        <div class="form__input__single">
                                                                            <label for="meta_title"
                                                                                class="form__input__single__label">Meta
                                                                                Title</label><br>
                                                                            <input type="text" class="form__control"
                                                                                name="meta_title"
                                                                                id="meta_title"data-role="tagsinput"
                                                                                placeholder="Title">
                                                                        </div>
                                                                        <div class="form__input__single">
                                                                            <label for="meta_tags"
                                                                                class="form__input__single__label">Meta
                                                                                Tags</label>
                                                                            <input type="text" class="form__control"
                                                                                name="meta_tags" id="meta_tags"
                                                                                data-role="tagsinput" placeholder="Tag">
                                                                        </div>
                                                                        <div class="form__input__single">
                                                                            <label for="meta_description"
                                                                                class="form__input__single__label">Meta
                                                                                Description</label>
                                                                            <textarea class="form__control" name="meta_description" cols="30" rows="10"></textarea>
                                                                        </div>

                                                                    </div>
                                                                    <div class="tab-pane fade" id="facebook_meta"
                                                                        role="tabpanel" aria-labelledby="nav-22-tab">
                                                                        <div class="form__input__single">
                                                                            <label for="title"
                                                                                class="form__input__single__label">Facebook
                                                                                Meta Title</label>
                                                                            <input type="text" class="form__control"
                                                                                data-role="tagsinput"
                                                                                name="facebook_meta_tags">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form__input__single col-md-12">
                                                                                <label for="title"
                                                                                    class="form__input__single__label">Facebook
                                                                                    Meta Description</label>
                                                                                <textarea name="facebook_meta_description" class="form__control max-height-140" cols="20" rows="4"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form__input__single">
                                                                            <label for="image"
                                                                                class="form__input__single__label">Facebook
                                                                                Meta Image</label>
                                                                            <div class="media-upload-btn-wrapper">
                                                                                <div class="img-wrap"></div>
                                                                                <input type="hidden"
                                                                                    name="facebook_meta_image">
                                                                                <button type="button"
                                                                                    class="cmnBtn btn_5 btn_bg_blue radius-5 media_upload_form_btn"
                                                                                    data-btntitle="Select Image"
                                                                                    data-modaltitle="Upload Image"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#media_upload_modal">
                                                                                    Upload Image
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane fade" id="twitter_meta"
                                                                        role="tabpanel" aria-labelledby="nav-22-tab">
                                                                        <div class="form__input__single">
                                                                            <label for="title"
                                                                                class="form__input__single__label">Twitter
                                                                                Meta Title</label>
                                                                            <input type="text" class="form__control"
                                                                                data-role="tagsinput"
                                                                                name="twitter_meta_tags">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form__input__single col-md-12">
                                                                                <label for="title">Twitter Meta
                                                                                    Description</label>
                                                                                <textarea name="twitter_meta_description" class="form__control max-height-140" cols="20" rows="4"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form__input__single">
                                                                            <label for="image"
                                                                                class="form__input__single__label">Twitter
                                                                                Meta Image</label>
                                                                            <div class="media-upload-btn-wrapper">
                                                                                <div class="img-wrap"></div>
                                                                                <input type="hidden"
                                                                                    name="twitter_meta_image">
                                                                                <button type="button"
                                                                                    class="cmnBtn btn_5 btn_bg_blue radius-5 media_upload_form_btn"
                                                                                    data-btntitle="Select Image"
                                                                                    data-modaltitle="Upload Image"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#media_upload_modal">
                                                                                    Upload Image
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <!--Guest post section -->
                                            <div class="box-shadow1 hode-phone-number p-24 mt-3">
                                                <label>User Information</label>
                                                <div class="mt-3">
                                                    <label for="guest_first_name" class="infoTitle">First Name <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="text" class="input-filed w-100"
                                                        name="guest_first_name" id="guest_first_name" value=""
                                                        placeholder="First Name">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="guest_first_name" class="infoTitle">Last Name <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="text" class="input-filed w-100"
                                                        name="guest_last_name" id="guest_last_name" value=""
                                                        placeholder="Last Name">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="guest_first_name" class="infoTitle">Email <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="email" class="input-filed w-100" name="guest_email"
                                                        id="guest_email" value="" placeholder="Email">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="guest_first_name" class="infoTitle">Phone Number 11 <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="hidden" id="guest-country-code"
                                                        name="guest_country_code">
                                                    <input type="tel" class="input-filed w-100" name="guest_phone"
                                                        id="guest_phone" value="" placeholder="Phone">
                                                </div>

                                                <div id="guest_error_message" class="d-flex flex-column gap-2 mt-2 mb-2">
                                                </div>

                                                <div class="feature">
                                                    <label>
                                                        <input type="checkbox" name="guest_register_request"
                                                            id="guest_register_request" value=""
                                                            class="custom-check-box">
                                                        <span class="ms-2 title-para text-primary">I confirm the above info
                                                            and am excited to register!</span>
                                                    </label>
                                                </div>

                                                <!-- Terms and Conditions -->
                                                <div class="feature">
                                                    <label class="checkWrap2 terms-conditions">
                                                        <input class="custom-check-box check-input" type="checkbox"
                                                            name="terms_conditions" id="terms_conditions" value="1">
                                                        <span class="checkmark mx-1"></span> I agree with the
                                                        <a href="../../terms-and-conditions.html" target="_blank"
                                                            class="text-primary"> Terms and Conditions </a>
                                                    </label>
                                                </div>

                                            </div>


                                            <!-- start previous / next buttons -->
                                            <div class="continue-btn mt-3">
                                                <div class="btn-wrapper mb-10 d-flex justify-content-end gap-3">
                                                    <button class="red-btn w-100 d-block" id="prevBtn"
                                                        type="button">Previous</button>
                                                    <button class="red-btn w-100 d-block" id="submitBtn"
                                                        type="submit">Submit Listing</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-xl-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- location end-->
                </div>
            </div>
        </form>

    </div>
@endsection
@section('js')
    <script>
        // Category breadcrumb functionality
        $(document).ready(function() {
            const categorySelect = $('#select-category');
            const breadcrumb = $('#category-breadcrumb');

            categorySelect.on('change', function() {
                const selectedOption = $(this).find('option:selected');

                if (selectedOption.val()) {
                    // Get parent optgroups
                    let path = [];
                    let element = selectedOption;

                    while (element.length) {
                        if (element.prop('tagName') === 'OPTGROUP') {
                            path.unshift(element.attr('label').trim());
                        }
                        element = element.parent();
                    }

                    path.push(selectedOption.text().trim());
                    breadcrumb.text(path.join(' > '));
                } else {
                    breadcrumb.text('');
                }
            });

            // Trigger on page load if there's an old value
            if (categorySelect.val()) {
                categorySelect.trigger('change');
            }
        });
    </script>
@endsection
