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

        #pac-input {
            height: 3em;
            width: 75%;
            margin-left: 140px;
            border: 1px solid;
            top: 4px;
            font-size: 16px;
        }

        @media (max-width: 1499px) {
            #pac-input {
                width: 100%;
                margin-left: 0;
            }
        }

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

        .input-group .form-control.is-valid,
        .input-group .form-select.is-valid,
        .was-validated .input-group .form-control:valid,
        .was-validated .input-group .form-select:valid {
            z-index: 0 !important;
        }

        #custom-fields-container .custom-field-group {
            margin-bottom: 15px;
        }

        #custom-fields-container .custom-field-group label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }
    </style>
@endsection
@section('content')
    <div class="add-listing-wrapper mt-5 mb-5">

        @if(session('success'))
            <div class="container">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger">{{ session('error') }}</div>
            </div>
        @endif

        <!-- Nav Bar Tabs -->
        <div style="display: none" class="nav nav-pills" id="add-listing-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link stepIndicator active stepForm_btn__previous" id="listing-info-tab" data-bs-toggle="pill"
                href="#listing-info" role="tab" aria-controls="listing-info" aria-selected="true">
                <span class="nav-link-number">1</span>
                Listing Info
            </a>
            <a class="nav-link stepIndicator" id="location-tab" data-bs-toggle="pill" href="#media-uploads"
                role="tab" aria-controls="media-uploads" aria-selected="true">
                <span class="nav-link-number">2</span>
                Location
            </a>
        </div>

        <form action="{{ route('ad.store') }}" method="POST" enctype="multipart/form-data" id="ad-post-form">
            @csrf
            <div class="add-listing-content-wrapper">
                <div class="tab-content add-listing-content" id="add-listing-tabContent">

                    <!-- Step 1: Listing Info -->
                    <div class="tab-pane fade step active show" id="listing-info" role="tabpanel"
                        aria-labelledby="listing-info-tab">
                        <div class="post-your-add">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mt-3 mb-2"></div>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-lg-8">
                                        <div class="post-add-wraper">
                                            <!-- Item Name -->
                                            <div class="item-name box-shadow1 p-24">
                                                <label for="title">Item Name <span class="text-danger">*</span></label>
                                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                                    class="input-filed w-100 @error('title') is-invalid @enderror" placeholder="Item Name">
                                                @error('title')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- About Item -->
                                            <div class="about-item box-shadow1 p-24 mt-4">
                                                <h3 class="head4">About Item</h3>
                                                <div class="row g-3 mt-3">
                                                    <!-- Category -->
                                                    <div class="col-sm-4">
                                                        <label for="category">Category <span class="text-danger">*</span></label>
                                                        <select name="" id="select-category" class="input-filed w-100">
                                                            <option value="">Select Category</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Subcategory -->
                                                    <div class="col-sm-4" id="subcategory-wrapper" style="display:none;">
                                                        <label for="subcategory">Subcategory <span class="text-danger">*</span></label>
                                                        <select name="" id="select-subcategory" class="input-filed w-100">
                                                            <option value="">Select Subcategory</option>
                                                        </select>
                                                    </div>

                                                    <!-- Sub-subcategory -->
                                                    <div class="col-sm-4" id="sub-subcategory-wrapper" style="display:none;">
                                                        <label for="sub-subcategory">Sub Subcategory</label>
                                                        <select id="select-sub-subcategory" class="input-filed w-100">
                                                            <option value="">Select Sub Subcategory</option>
                                                        </select>
                                                    </div>

                                                    <!-- Hidden field to store the final selected category -->
                                                    <input type="hidden" name="category" id="final-category" value="{{ old('category') }}">

                                                    <div class="col-12">
                                                        <p class="text-sm text-muted" id="category-breadcrumb"></p>
                                                        @error('category')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <!-- Condition -->
                                                    <div class="col-sm-6">
                                                        <label for="condition">Item Condition</label>
                                                        <select name="condition" id="condition" class="input-filed w-100">
                                                            <option value="">Select Condition</option>
                                                            @foreach($conditions as $condition)
                                                                <option value="{{ $condition->id }}" {{ old('condition') == $condition->id ? 'selected' : '' }}>
                                                                    {{ $condition->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- City -->
                                                    <div class="col-sm-6">
                                                        <label for="city">City</label>
                                                        <select name="city" id="city" class="input-filed w-100">
                                                            <option value="">Select City</option>
                                                            @foreach($cities as $city)
                                                                <option value="{{ $city->id }}" {{ old('city') == $city->id ? 'selected' : '' }}>
                                                                    {{ $city->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Custom Fields Container -->
                                                <div id="custom-fields-container" class="mt-3"></div>
                                            </div>

                                            <!-- Description -->
                                            <div class="description box-shadow1 p-24 mt-4">
                                                <label for="description">Description <span class="text-danger">*</span>
                                                    <span class="text-danger">(minimum 150 characters.)</span>
                                                </label>
                                                <textarea name="description" id="description" rows="6"
                                                    class="input-filed w-100 textarea--form summernote @error('description') is-invalid @enderror"
                                                    placeholder="Enter a Description">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="right-sidebar">
                                            <!-- Price -->
                                            <div class="box-shadow1 price p-24">
                                                <div class="price-wraper">
                                                    <label for="price">Price <span class="text-danger">*</span></label>
                                                    <input type="number" name="price" id="price" value="{{ old('price') }}"
                                                        class="input-filed w-100 mb-3 @error('price') is-invalid @enderror"
                                                        placeholder="0.00" step="0.01">
                                                    @error('price')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                    <label class="negotiable">
                                                        <input type="checkbox" class="custom-check-box" name="negotiable"
                                                            id="negotiable" {{ old('negotiable') ? 'checked' : '' }}>
                                                        <span class="ms-2">Negotiable</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Contact -->
                                            <div class="box-shadow1 p-24 mt-3">
                                                <label for="contact_email">Contact Email <span class="text-danger">*</span></label>
                                                <input type="email" name="contact_email" id="contact_email"
                                                    value="{{ old('contact_email', auth()->check() ? auth()->user()->email : '') }}"
                                                    class="input-filed w-100 mb-3 @error('contact_email') is-invalid @enderror"
                                                    placeholder="Email Address">
                                                @error('contact_email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Phone -->
                                            <div class="box-shadow1 hode-phone-number p-24 mt-3">
                                                <label class="hide-number">
                                                    <input type="checkbox" class="custom-check-box"
                                                        name="hide_phone_number" {{ old('hide_phone_number') ? 'checked' : '' }}>
                                                    <span class="black-font"> Hide My Phone Number</span>
                                                </label>
                                                <div class="input-group mt-3">
                                                    <input class="input-filed w-100" type="tel" name="phone"
                                                        value="{{ old('phone') }}" id="phone" placeholder="Type Phone"
                                                        class="@error('contact_phone') is-invalid @enderror">
                                                    @error('contact_phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Thumbnail Image -->
                                            <div class="box-shadow1 p-24 mt-3">
                                                <label for="thumbnail_image">Featured Image <span class="text-danger">*</span></label>
                                                <input type="file" name="thumbnail_image" id="thumbnail_image"
                                                    class="input-filed w-100 @error('thumbnail_image') is-invalid @enderror"
                                                    accept="image/jpg,image/jpeg,image/png,image/gif,image/webp">
                                                <small class="text-muted">image format: jpg,jpeg,png,gif,webp | max: 5MB</small>
                                                <div id="thumbnail-preview" class="mt-2"></div>
                                                @error('thumbnail_image')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Gallery Images -->
                                            <div class="box-shadow1 p-24 mt-3">
                                                <label for="gallery_images">Gallery Images</label>
                                                <input type="file" name="gallery_images[]" id="gallery_images"
                                                    class="input-filed w-100" multiple
                                                    accept="image/jpg,image/jpeg,image/png,image/gif,image/webp">
                                                <small class="text-muted">You can select multiple images</small>
                                                <div id="gallery-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
                                            </div>

                                            <!-- Continue Button -->
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
                    <!-- Step 1 End -->

                    <!-- Step 2: Location & Additional -->
                    <div class="tab-pane fade step" id="media-uploads" role="tabpanel" aria-labelledby="location-tab">
                        <div class="post-your-add add-location section-padding2">
                            <div class="container-1920 plr1">
                                <div class="row">
                                    <div class="col-xl-2"></div>
                                    <div class="col-xl-6">
                                        <!-- Address -->
                                        <div class="address box-shadow1 p-24">
                                            <div class="location-map mt-3">
                                                <label class="infoTitle">Google Map Location
                                                    <small class="text-info">Search your location, pick a location</small>
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
                                                <label for="user_address">Address</label>
                                                <input type="text" class="w-100 input-filed" name="address"
                                                    id="user_address" value="{{ old('address') }}" placeholder="Address">
                                            </div>
                                        </div>

                                        <!-- Video URL -->
                                        <div class="video box-shadow1 p-24 mt-3 mb-3">
                                            <label for="video_url">Video Url</label>
                                            <input type="text" class="input-filed w-100" name="video_url"
                                                id="video_url" value="{{ old('video_url') }}" placeholder="YouTube URL">
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="right-sidebar">
                                            <!-- Featured Ad -->
                                            <div class="box-shadow1 feature p-24">
                                                <label>
                                                    <input type="checkbox" name="is_featured" id="is_featured"
                                                        value="1" class="custom-check-box feature_disable_color"
                                                        {{ old('is_featured') ? 'checked' : '' }}>
                                                    <span class="ms-2">Feature This Ad</span>
                                                </label>
                                                <p>To feature this ad, you will need to subscribe to a
                                                    <a href="{{ url('/membership') }}">paid membership</a>
                                                </p>
                                            </div>

                                            <!-- Tags -->
                                            <div class="box-shadow1 tags p-24 mt-3">
                                                <label for="tags">Tags</label>
                                                <div class="select-itms">
                                                    <select name="tags[]" id="tags" class="select2_activation" multiple>
                                                        @foreach($tags as $tag)
                                                            <option value="{{ $tag->id }}"
                                                                {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'selected' : '' }}>
                                                                {{ $tag->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small>Select your tags or type a new tag name</small>
                                                </div>
                                            </div>

                                            <!-- Meta Section -->
                                            <div class="box-shadow1 tags p-24 mt-3">
                                                <div class="row">
                                                    <div class="col-xxl-12 col-lg-12">
                                                        <div class="collapse_wrapper dashboard__card style_one bg__white padding-20 radius-10">
                                                            <div class="collapse_wrapper__header mb-3">
                                                                <h5 class="collapse_wrapper__header__title">Meta Section</h5>
                                                            </div>
                                                            <div class="tab_wrapper style_seven">
                                                                <nav>
                                                                    <div class="nav nav-tabs flex-nowrap" id="nav-tab8" role="tablist">
                                                                        <a class="nav-link active" id="nav-21-tab"
                                                                            data-bs-toggle="tab" href="#blog_meta"
                                                                            role="tab" aria-controls="nav-21"
                                                                            aria-selected="true">Blog Meta</a>
                                                                        <a class="nav-link" id="nav-22-tab"
                                                                            data-bs-toggle="tab" href="#facebook_meta"
                                                                            role="tab" aria-controls="nav-22"
                                                                            aria-selected="false">Facebook Meta</a>
                                                                        <a class="nav-link" id="nav-23-tab"
                                                                            data-bs-toggle="tab" href="#twitter_meta"
                                                                            role="tab" aria-controls="nav-23"
                                                                            aria-selected="false">Twitter Meta</a>
                                                                    </div>
                                                                </nav>
                                                                <div class="tab-content mt-4" id="nav-tabContent8">
                                                                    <div class="tab-pane fade show active" id="blog_meta"
                                                                        role="tabpanel" aria-labelledby="nav-21-tab">
                                                                        <div class="form__input__single">
                                                                            <label for="meta_title" class="form__input__single__label">Meta Title</label><br>
                                                                            <input type="text" class="form__control" name="meta_title"
                                                                                id="meta_title" value="{{ old('meta_title') }}" placeholder="Title">
                                                                        </div>
                                                                        <div class="form__input__single">
                                                                            <label for="meta_tags" class="form__input__single__label">Meta Tags</label>
                                                                            <input type="text" class="form__control" name="meta_tags"
                                                                                id="meta_tags" value="{{ old('meta_tags') }}"
                                                                                data-role="tagsinput" placeholder="Tag">
                                                                        </div>
                                                                        <div class="form__input__single">
                                                                            <label for="meta_description" class="form__input__single__label">Meta Description</label>
                                                                            <textarea class="form__control" name="meta_description" cols="30" rows="10">{{ old('meta_description') }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane fade" id="facebook_meta"
                                                                        role="tabpanel" aria-labelledby="nav-22-tab">
                                                                        <div class="form__input__single">
                                                                            <label class="form__input__single__label">Facebook Meta Title</label>
                                                                            <input type="text" class="form__control"
                                                                                data-role="tagsinput" name="facebook_meta_tags"
                                                                                value="{{ old('facebook_meta_tags') }}">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form__input__single col-md-12">
                                                                                <label class="form__input__single__label">Facebook Meta Description</label>
                                                                                <textarea name="facebook_meta_description" class="form__control max-height-140" cols="20" rows="4">{{ old('facebook_meta_description') }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane fade" id="twitter_meta"
                                                                        role="tabpanel" aria-labelledby="nav-22-tab">
                                                                        <div class="form__input__single">
                                                                            <label class="form__input__single__label">Twitter Meta Title</label>
                                                                            <input type="text" class="form__control"
                                                                                data-role="tagsinput" name="twitter_meta_tags"
                                                                                value="{{ old('twitter_meta_tags') }}">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form__input__single col-md-12">
                                                                                <label>Twitter Meta Description</label>
                                                                                <textarea name="twitter_meta_description" class="form__control max-height-140" cols="20" rows="4">{{ old('twitter_meta_description') }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Guest User Info (shown when not logged in) -->
                                            @guest
                                            <div class="box-shadow1 hode-phone-number p-24 mt-3">
                                                <label>User Information</label>
                                                <div class="mt-3">
                                                    <label for="guest_first_name" class="infoTitle">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="input-filed w-100" name="guest_first_name"
                                                        id="guest_first_name" value="{{ old('guest_first_name') }}" placeholder="First Name">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="guest_last_name" class="infoTitle">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="input-filed w-100" name="guest_last_name"
                                                        id="guest_last_name" value="{{ old('guest_last_name') }}" placeholder="Last Name">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="guest_email" class="infoTitle">Email <span class="text-danger">*</span></label>
                                                    <input type="email" class="input-filed w-100" name="guest_email"
                                                        id="guest_email" value="{{ old('guest_email') }}" placeholder="Email">
                                                </div>
                                                <div class="mt-3">
                                                    <label for="guest_phone" class="infoTitle">Phone Number <span class="text-danger">*</span></label>
                                                    <input type="tel" class="input-filed w-100" name="guest_phone"
                                                        id="guest_phone" value="{{ old('guest_phone') }}" placeholder="Phone">
                                                </div>
                                                <div id="guest_error_message" class="d-flex flex-column gap-2 mt-2 mb-2"></div>
                                                <div class="feature">
                                                    <label>
                                                        <input type="checkbox" name="guest_register_request"
                                                            id="guest_register_request" value="1" class="custom-check-box">
                                                        <span class="ms-2 title-para text-primary">I confirm the above info and am excited to register!</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @endguest

                                            <!-- Terms and Conditions -->
                                            <div class="box-shadow1 p-24 mt-3">
                                                <div class="feature">
                                                    <label class="checkWrap2 terms-conditions">
                                                        <input class="custom-check-box check-input" type="checkbox"
                                                            name="terms_conditions" id="terms_conditions" value="1">
                                                        <span class="checkmark mx-1"></span> I agree with the
                                                        <a href="{{ url('/terms-and-conditions') }}" target="_blank"
                                                            class="text-primary"> Terms and Conditions </a>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Previous / Submit -->
                                            <div class="continue-btn mt-3">
                                                <div class="btn-wrapper mb-10 d-flex justify-content-end gap-3">
                                                    <button class="red-btn w-100 d-block" id="prevBtn" type="button">Previous</button>
                                                    <button class="red-btn w-100 d-block" id="submitBtn" type="submit">Submit Listing</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-xl-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Step 2 End -->

                </div>
            </div>
        </form>

    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            if ($.fn.select2) {
                $('.select2_activation').select2({
                    tags: true,
                    tokenSeparators: [',']
                });
            }

            // Initialize Summernote
            if ($.fn.summernote) {
                $('.summernote').summernote({
                    height: 200,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link']],
                        ['view', ['codeview']]
                    ]
                });
            }

            // ============================================
            // Multi-level Category Selection
            // ============================================
            const categorySelect = $('#select-category');
            const subcategorySelect = $('#select-subcategory');
            const subSubcategorySelect = $('#select-sub-subcategory');
            const subcategoryWrapper = $('#subcategory-wrapper');
            const subSubcategoryWrapper = $('#sub-subcategory-wrapper');
            const finalCategoryInput = $('#final-category');
            const breadcrumb = $('#category-breadcrumb');

            function updateFinalCategory() {
                let finalVal = '';
                let path = [];

                if (subSubcategorySelect.val()) {
                    finalVal = subSubcategorySelect.val();
                    path = [
                        categorySelect.find('option:selected').text().trim(),
                        subcategorySelect.find('option:selected').text().trim(),
                        subSubcategorySelect.find('option:selected').text().trim()
                    ];
                } else if (subcategorySelect.val()) {
                    finalVal = subcategorySelect.val();
                    path = [
                        categorySelect.find('option:selected').text().trim(),
                        subcategorySelect.find('option:selected').text().trim()
                    ];
                } else if (categorySelect.val()) {
                    finalVal = categorySelect.val();
                    path = [categorySelect.find('option:selected').text().trim()];
                }

                finalCategoryInput.val(finalVal);
                breadcrumb.text(path.length ? path.join(' > ') : '');

                // Load custom fields for the selected category
                if (finalVal) {
                    loadCustomFields(finalVal);
                } else {
                    $('#custom-fields-container').html('');
                }
            }

            // Category change -> load subcategories
            categorySelect.on('change', function() {
                const parentId = $(this).val();
                subcategoryWrapper.hide();
                subSubcategoryWrapper.hide();
                subcategorySelect.html('<option value="">Select Subcategory</option>');
                subSubcategorySelect.html('<option value="">Select Sub Subcategory</option>');

                if (parentId) {
                    $.get("{{ route('ad.subcategories') }}", { parent_id: parentId }, function(data) {
                        if (data.length > 0) {
                            data.forEach(function(item) {
                                subcategorySelect.append(`<option value="${item.id}">${item.title}</option>`);
                            });
                            subcategoryWrapper.show();
                        }
                    });
                }
                updateFinalCategory();
            });

            // Subcategory change -> load sub-subcategories
            subcategorySelect.on('change', function() {
                const parentId = $(this).val();
                subSubcategoryWrapper.hide();
                subSubcategorySelect.html('<option value="">Select Sub Subcategory</option>');

                if (parentId) {
                    $.get("{{ route('ad.subcategories') }}", { parent_id: parentId }, function(data) {
                        if (data.length > 0) {
                            data.forEach(function(item) {
                                subSubcategorySelect.append(`<option value="${item.id}">${item.title}</option>`);
                            });
                            subSubcategoryWrapper.show();
                        }
                    });
                }
                updateFinalCategory();
            });

            subSubcategorySelect.on('change', function() {
                updateFinalCategory();
            });

            // ============================================
            // Load Custom Fields by Category
            // ============================================
            function loadCustomFields(categoryId) {
                $.get("{{ route('ad.custom.fields') }}", { category_id: categoryId }, function(fields) {
                    let html = '';
                    if (fields.length > 0) {
                        html += '<h6 class="mt-3 mb-2">Additional Information</h6>';
                        html += '<div class="row g-3">';
                        fields.forEach(function(field) {
                            const required = field.is_required == 1 ? 'required' : '';
                            const requiredStar = field.is_required == 1 ? '<span class="text-danger">*</span>' : '';

                            html += '<div class="col-sm-6 custom-field-group">';
                            html += `<label>${field.title} ${requiredStar}</label>`;

                            switch (parseInt(field.type)) {
                                case {{ config('settings.input_types.text') }}:
                                    html += `<input type="text" name="custom_field[${field.id}]" class="input-filed w-100" value="${field.default_value || ''}" ${required}>`;
                                    break;
                                case {{ config('settings.input_types.number') }}:
                                    html += `<input type="number" name="custom_field[${field.id}]" class="input-filed w-100" value="${field.default_value || ''}" ${required}>`;
                                    break;
                                case {{ config('settings.input_types.select') }}:
                                    html += `<select name="custom_field[${field.id}]" class="input-filed w-100" ${required}>`;
                                    html += '<option value="">Select</option>';
                                    if (field.options) {
                                        field.options.forEach(function(opt) {
                                            html += `<option value="${opt.id}">${opt.value}</option>`;
                                        });
                                    }
                                    html += '</select>';
                                    break;
                                case {{ config('settings.input_types.text_area') }}:
                                    html += `<textarea name="custom_field[${field.id}]" class="input-filed w-100" rows="3" ${required}>${field.default_value || ''}</textarea>`;
                                    break;
                                case {{ config('settings.input_types.checkbox') }}:
                                    if (field.options) {
                                        field.options.forEach(function(opt) {
                                            html += `<div class="form-check">
                                                <input type="checkbox" name="custom_field[${field.id}][]" value="${opt.id}" class="form-check-input" id="cf_${field.id}_${opt.id}">
                                                <label class="form-check-label" for="cf_${field.id}_${opt.id}">${opt.value}</label>
                                            </div>`;
                                        });
                                    }
                                    break;
                                case {{ config('settings.input_types.radio') }}:
                                    if (field.options) {
                                        field.options.forEach(function(opt) {
                                            html += `<div class="form-check">
                                                <input type="radio" name="custom_field[${field.id}]" value="${opt.id}" class="form-check-input" id="cf_${field.id}_${opt.id}" ${required}>
                                                <label class="form-check-label" for="cf_${field.id}_${opt.id}">${opt.value}</label>
                                            </div>`;
                                        });
                                    }
                                    break;
                                case {{ config('settings.input_types.file') }}:
                                    html += `<input type="file" name="customfile_${field.id}" class="input-filed w-100" ${required}>`;
                                    break;
                                case {{ config('settings.input_types.date') }}:
                                    html += `<input type="date" name="custom_field[${field.id}]" class="input-filed w-100" value="${field.default_value || ''}" ${required}>`;
                                    break;
                            }

                            html += '</div>';
                        });
                        html += '</div>';
                    }
                    $('#custom-fields-container').html(html);
                });
            }

            // ============================================
            // Form Wizard (Step Navigation)
            // ============================================
            let currentTab = 0;
            const tabs = document.querySelectorAll('.step');
            const indicators = document.querySelectorAll('.stepIndicator');

            function showTab(n) {
                tabs.forEach((tab, i) => {
                    if (i === n) {
                        tab.classList.add('active', 'show');
                        tab.style.display = 'block';
                    } else {
                        tab.classList.remove('active', 'show');
                        tab.style.display = 'none';
                    }
                });
                indicators.forEach((ind, i) => {
                    ind.classList.toggle('active', i === n);
                });
            }

            showTab(currentTab);

            $('#nextBtn').on('click', function() {
                // Basic validation before moving to next step
                const title = $('#title').val();
                const category = $('#final-category').val();
                const description = $('#description').val() || ($('.summernote').length ? $('.summernote').summernote('code') : '');
                const price = $('#price').val();

                if (!title) {
                    alert('Please enter an item name.');
                    $('#title').focus();
                    return;
                }
                if (!category) {
                    alert('Please select a category.');
                    return;
                }
                if (!price) {
                    alert('Please enter a price.');
                    $('#price').focus();
                    return;
                }

                currentTab = 1;
                showTab(currentTab);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            $('#prevBtn').on('click', function() {
                currentTab = 0;
                showTab(currentTab);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // ============================================
            // Image Preview
            // ============================================
            $('#thumbnail_image').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        $('#thumbnail-preview').html(`<img src="${ev.target.result}" style="max-width:200px;max-height:200px;border-radius:6px;object-fit:cover;">`);
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#gallery_images').on('change', function(e) {
                const preview = $('#gallery-preview');
                preview.html('');
                Array.from(e.target.files).forEach(function(file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        preview.append(`<img src="${ev.target.result}" style="width:80px;height:80px;border-radius:6px;object-fit:cover;">`);
                    };
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
@endsection
