@extends('frontend.layouts.master')
@section('meta')
    <title>Post ad - {{ get_setting('site_name') }}</title>
    <link rel="stylesheet" href="{{ asset('public/web-assets/backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/web-assets/backend/plugins/summernote/summernote-bs4.min.css') }}">
    <style>
        /* Transparent overlay — browsers never block opacity:0 inputs (unlike display:none) */
        .gallery-slot .slot-file-input,
        .thumbnail-slot .slot-file-input {
            position: absolute !important;
            inset: 0 !important;
            width: 100% !important;
            height: 100% !important;
            opacity: 0 !important;
            cursor: pointer !important;
            z-index: 5 !important;
        }

        .gallery-slot.has-image .slot-file-input,
        .thumbnail-slot.has-image .slot-file-input {
            display: none !important;
        }

        .thumbnail-slot {
            position: relative;
            width: 100%;
            min-height: 160px;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            cursor: pointer;
            overflow: hidden;
            background: #f9fafb;
            transition: border-color .2s, background .2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumbnail-slot:hover {
            border-color: var(--main-color-one, #3b82f6);
            background: #eff6ff;
        }

        .thumbnail-slot.has-image {
            border-style: solid;
            border-color: var(--main-color-one, #3b82f6);
            background: transparent;
        }

        .thumbnail-slot .slot-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #9ca3af;
            text-align: center;
            padding: 20px;
            pointer-events: none;
        }

        .thumbnail-slot .slot-placeholder svg {
            width: 48px;
            height: 48px;
            opacity: .5;
        }

        .thumbnail-slot .slot-placeholder span {
            font-size: 14px;
            font-weight: 500;
        }

        .thumbnail-slot .slot-image {
            position: absolute;
            inset: 0;
        }

        .thumbnail-slot .slot-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumbnail-slot .slot-remove {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(239, 68, 68, .9);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            line-height: 1;
            padding: 0;
            z-index: 10;
            transition: background .2s, transform .2s;
        }

        .thumbnail-slot .slot-remove:hover {
            background: #dc2626;
            transform: scale(1.15);
        }
    </style>
@endsection
@section('content')
    <div class="add-listing-wrapper mt-5 mb-5">

        @if (session('success'))
            <div class="container">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
        @endif
        @if (session('error'))
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
            <a class="nav-link stepIndicator" id="location-tab" data-bs-toggle="pill" href="#media-uploads" role="tab"
                aria-controls="media-uploads" aria-selected="true">
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
                                <div class="row g-4">
                                    <div class="col-lg-8">
                                        <div class="post-add-wraper">
                                            <!-- Item Name -->
                                            <div class="box-shadow1 p-24">
                                                <div class="form-group">
                                                    <label for="title">Item Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" name="title" id="title"
                                                        value="{{ old('title') }}"
                                                        class="input-style @error('title') is-invalid @enderror"
                                                        placeholder="Item Name">

                                                    <div class="invalid-feedback @error('title') d-block @enderror">
                                                        @error('title')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- About Item -->
                                            <div class="box-shadow1 p-24 mt-4">
                                                <h3 class="head4">About Item</h3>
                                                <!-- Category -->
                                                <div class="form-group mb-20">
                                                    <label for="category">Category
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select name="" id="select-category" class="input-style">
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Subcategory -->
                                                <div class="form-group mb-20" id="subcategory-wrapper"
                                                    style="display:none;">
                                                    <label for="subcategory">Subcategory
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select name="" id="select-subcategory"
                                                        class="input-style w-100">
                                                        <option value="">Select Subcategory</option>
                                                    </select>
                                                </div>

                                                <!-- Sub-subcategory -->
                                                <div class="form-group mb-20" id="sub-subcategory-wrapper"
                                                    style="display:none;">
                                                    <label for="sub-subcategory">Sub Subcategory</label>
                                                    <select id="select-sub-subcategory" class="input-style w-100">
                                                        <option value="">Select Sub Subcategory</option>
                                                    </select>
                                                </div>

                                                <!-- Hidden field to store the final selected category -->
                                                <input type="hidden" name="category" id="final-category"
                                                    value="{{ old('category') }}">

                                                <div class="form-group mb-20">
                                                    <p class="text-sm text-muted" id="category-breadcrumb"></p>
                                                    <div class="invalid-feedback @error('category') d-block @enderror">
                                                        @error('category')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Custom Fields Container -->
                                                <div id="custom-fields-container" class="mt-3"></div>

                                                <!-- Condition -->
                                                <div class="form-group mb-20">
                                                    <label for="condition">Item Condition</label>
                                                    <select name="condition" id="condition" class="input-style">
                                                        <option value="">Select Condition</option>
                                                        @foreach ($conditions as $condition)
                                                            <option value="{{ $condition->id }}"
                                                                {{ old('condition') == $condition->id ? 'selected' : '' }}>
                                                                {{ $condition->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>

                                            <!-- Description -->
                                            <div class="description box-shadow1 p-24 mt-4">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" rows="6"
                                                    class="input-style summernote @error('description') is-invalid @enderror" placeholder="Enter a Description">{{ old('description') }}</textarea>
                                                <div class="invalid-feedback @error('description') d-block @enderror">
                                                    @error('description')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="right-sidebar">
                                            <!-- Price -->
                                            <div class="box-shadow1 price p-24">
                                                <div class="price-wraper">
                                                    <label for="price">Price <span class="text-danger">*</span></label>
                                                    <input type="number" name="price" id="price"
                                                        value="{{ old('price') }}"
                                                        class="input-style w-100 mb-3 @error('price') is-invalid @enderror"
                                                        placeholder="0.00" step="0.01">
                                                    <div class="invalid-feedback @error('price') d-block @enderror">
                                                        @error('price')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                    <label class="negotiable">
                                                        <input type="checkbox" class="custom-check-box" name="negotiable"
                                                            id="negotiable" {{ old('negotiable') ? 'checked' : '' }}>
                                                        <span class="ms-2">Negotiable</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Contact -->
                                            <div class="box-shadow1 p-24 mt-3">
                                                <label for="contact_email">Contact Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" name="contact_email" id="contact_email"
                                                    value="{{ old('contact_email', auth()->check() ? auth()->user()->email : '') }}"
                                                    class="input-style w-100 @error('contact_email') is-invalid @enderror"
                                                    placeholder="Email Address">
                                                <div class="invalid-feedback @error('contact_email') d-block @enderror">
                                                    @error('contact_email')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Phone -->
                                            <div class="box-shadow1 hode-phone-number p-24 mt-3">
                                                <label class="hide-number">
                                                    <input type="checkbox" class="custom-check-box"
                                                        name="hide_phone_number"
                                                        {{ old('hide_phone_number') ? 'checked' : '' }}>
                                                    <span class="black-font"> Hide My Phone Number</span>
                                                </label>
                                                <div class="mt-3">
                                                    <input class="input-style w-100 @error('phone') is-invalid @enderror"
                                                        type="tel" name="phone" value="{{ old('phone') }}"
                                                        id="phone" placeholder="Type Phone">
                                                    <div class="invalid-feedback @error('phone') d-block @enderror">
                                                        @error('phone')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Thumbnail Image -->
                                            <div class="box-shadow1 p-24 mt-3">
                                                <label>Featured Image <span class="text-danger">*</span></label>
                                                <div class="thumbnail-slot" id="thumbnail-slot">
                                                    <div class="slot-placeholder">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span>Choose Featured Image</span>
                                                    </div>
                                                    <div class="slot-image" id="thumbnail-slot-image"
                                                        style="display:none;">
                                                        <img src="" alt="">
                                                        <button type="button" class="slot-remove" id="thumbnail-remove"
                                                            title="Remove">×</button>
                                                    </div>
                                                    <input type="file" name="thumbnail_image" id="thumbnail_image"
                                                        class="slot-file-input @error('thumbnail_image') is-invalid @enderror"
                                                        accept="image/jpg,image/jpeg,image/png,image/gif,image/webp">
                                                </div>
                                                <small class="text-muted d-block mt-2">image format: jpg,jpeg,png,gif,webp
                                                    | max: 5MB</small>
                                                <div class="invalid-feedback @error('thumbnail_image') d-block @enderror">
                                                    @error('thumbnail_image')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Gallery Images -->
                                            <div class="box-shadow1 p-24 mt-3">
                                                <div class="gallery-slots-label">
                                                    <span>Gallery Images</span>
                                                    @if ($galleryImageLimit > 0)
                                                        <span class="slot-count-badge">{{ $galleryImageLimit }}
                                                            photos</span>
                                                    @endif
                                                </div>

                                                @if ($galleryImageLimit > 0)
                                                    <div class="gallery-slots-grid" id="gallery-slots-grid">
                                                        @for ($i = 0; $i < $galleryImageLimit; $i++)
                                                            <div class="gallery-slot" data-slot="{{ $i }}">
                                                                <div class="slot-placeholder">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="1.5"
                                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                    </svg>
                                                                    <span>Add Photo</span>
                                                                </div>
                                                                <div class="slot-image" style="display:none;">
                                                                    <img src="" alt="">
                                                                    <button type="button" class="slot-remove"
                                                                        title="Remove">×</button>
                                                                </div>
                                                                <span class="slot-number">{{ $i + 1 }}</span>
                                                                <input type="file" class="slot-file-input"
                                                                    accept="image/jpg,image/jpeg,image/png,image/gif,image/webp">
                                                            </div>
                                                        @endfor
                                                    </div>
                                                    <small class="text-muted d-block mt-2">Click a box to add a photo
                                                        &bull; max 5MB each</small>
                                                @else
                                                    <div class="gallery-no-plan-notice">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span>Your current plan does not include gallery images. <a
                                                                href="{{ url('/membership') }}">Upgrade your plan</a> to
                                                            upload gallery photos.</span>
                                                    </div>
                                                @endif
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
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-2"></div>
                                    <div class="col-xl-6">
                                        <!-- Location Information -->
                                        <div class="address box-shadow1 p-24">
                                            <h5 class="mb-3">Location Information</h5>
                                            <div class="row g-3">
                                                <!-- Country -->
                                                <div class="col-12">
                                                    <label for="country">Country <span
                                                            class="text-danger">*</span></label>
                                                    <select name="country" id="country" class="select2-ajax w-100"
                                                        required>
                                                        <option value="">Select Country</option>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                                <!-- State -->
                                                <div class="col-12">
                                                    <label for="state">State <span class="text-danger">*</span></label>
                                                    <select name="state" id="state" class="select2-ajax w-100"
                                                        required disabled>
                                                        <option value="">Select State</option>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                                <!-- City -->
                                                <div class="col-12">
                                                    <label for="city">City <span class="text-danger">*</span></label>
                                                    <select name="city" id="city" class="select2-ajax w-100"
                                                        required disabled>
                                                        <option value="">Select City</option>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                                <!-- Address -->
                                                <div class="col-12">
                                                    <label for="address">Address</label>
                                                    <textarea class="w-100 input-style" name="address" id="address" rows="3"
                                                        placeholder="Enter your detailed address">{{ old('address') }}</textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Video URL -->
                                        <div class="video box-shadow1 p-24 mt-3 mb-3">
                                            <label for="video_url">Video URL</label>
                                            <input type="text" class="input-style w-100" name="video_url"
                                                id="video_url" value="{{ old('video_url') }}" placeholder="YouTube URL">
                                            <div class="invalid-feedback"></div>
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
                                                    <select name="tags[]" id="tags" class="select2_activation"
                                                        multiple>
                                                        @foreach ($tags as $tag)
                                                            <option value="{{ $tag->id }}"
                                                                {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'selected' : '' }}>
                                                                {{ $tag->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small>Select your tags or type a new tag name</small>
                                                </div>
                                            </div>


                                            <!-- Guest User Info (shown when not logged in) -->
                                            @guest
                                                <div class="box-shadow1 hode-phone-number p-24 mt-3">
                                                    <label>User Information</label>
                                                    <div class="mt-3">
                                                        <label for="guest_first_name" class="infoTitle">First Name <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="input-style w-100"
                                                            name="guest_first_name" id="guest_first_name"
                                                            value="{{ old('guest_first_name') }}" placeholder="First Name">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="guest_last_name" class="infoTitle">Last Name <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="input-style w-100"
                                                            name="guest_last_name" id="guest_last_name"
                                                            value="{{ old('guest_last_name') }}" placeholder="Last Name">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="guest_email" class="infoTitle">Email <span
                                                                class="text-danger">*</span></label>
                                                        <input type="email" class="input-style w-100" name="guest_email"
                                                            id="guest_email" value="{{ old('guest_email') }}"
                                                            placeholder="Email">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="guest_phone" class="infoTitle">Phone Number <span
                                                                class="text-danger">*</span></label>
                                                        <input type="tel" class="input-style w-100" name="guest_phone"
                                                            id="guest_phone" value="{{ old('guest_phone') }}"
                                                            placeholder="Phone">
                                                    </div>
                                                    <div id="guest_error_message" class="d-flex flex-column gap-2 mt-2 mb-2">
                                                    </div>
                                                    <div class="feature">
                                                        <label>
                                                            <input type="checkbox" name="guest_register_request"
                                                                id="guest_register_request" value="1"
                                                                class="custom-check-box">
                                                            <span class="ms-2 title-para text-primary">I confirm the above info
                                                                and am excited to register!</span>
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
                                                    <div
                                                        class="invalid-feedback @error('terms_conditions') d-block @enderror">
                                                        @error('terms_conditions')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Form Messages -->
                                            <div id="form-messages" class="mt-3"></div>

                                            <!-- Previous / Submit -->
                                            <div class="continue-btn mt-3">
                                                <div class="btn-wrapper mb-10 d-flex justify-content-end gap-3">
                                                    <button class="red-btn w-100 d-block" id="prevBtn"
                                                        type="button">Previous</button>
                                                    <button class="red-btn w-100 d-block" id="submitBtn" type="submit">
                                                        <span class="btn-text">Submit Listing</span>
                                                    </button>
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

    <!-- Form Loader -->
    <div id="form-loader">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/web-assets/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // ============================================
            // LocalStorage - Save and Restore Form Data
            // ============================================
            const formStorageKey = 'ad_post_form_data';

            // Restore form data from localStorage
            function restoreFormData() {
                try {
                    const savedData = localStorage.getItem(formStorageKey);
                    if (savedData) {
                        const formData = JSON.parse(savedData);

                        // Restore text inputs
                        Object.keys(formData).forEach(function(key) {
                            const input = $(`[name="${key}"]`);
                            if (input.length && formData[key]) {
                                if (input.is(':checkbox')) {
                                    input.prop('checked', formData[key] === true || formData[key] === 'on');
                                } else if (input.is(':radio')) {
                                    $(`[name="${key}"][value="${formData[key]}"]`).prop('checked', true);
                                } else if (!input.is(':file')) {
                                    input.val(formData[key]);
                                }
                            }
                        });

                        // Restore Summernote description
                        if (formData.description && $('.summernote').length) {
                            $('.summernote').summernote('code', formData.description);
                        }

                        console.log('Form data restored from localStorage');
                    }
                } catch (error) {
                    console.error('Error restoring form data:', error);
                }
            }

            // Save form data to localStorage
            function saveFormData() {
                try {
                    const formData = {};

                    // Save all text inputs, textareas, and selects
                    $('#ad-post-form').find('input, textarea, select').each(function() {
                        const $input = $(this);
                        const name = $input.attr('name');

                        if (name && !$input.is(':file')) {
                            if ($input.is(':checkbox')) {
                                formData[name] = $input.is(':checked');
                            } else if ($input.is(':radio')) {
                                if ($input.is(':checked')) {
                                    formData[name] = $input.val();
                                }
                            } else {
                                formData[name] = $input.val();
                            }
                        }
                    });

                    // Save Summernote description
                    if ($('.summernote').length) {
                        formData.description = $('.summernote').summernote('code');
                    }

                    localStorage.setItem(formStorageKey, JSON.stringify(formData));
                } catch (error) {
                    console.error('Error saving form data:', error);
                }
            }

            // Clear localStorage
            function clearFormData() {
                localStorage.removeItem(formStorageKey);
                console.log('Form data cleared from localStorage');
            }

            // Auto-save form data on input change (with debounce)
            let saveTimeout;
            $('#ad-post-form').on('input change', 'input, textarea, select', function() {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(function() {
                    saveFormData();
                }, 1000); // Save after 1 second of inactivity
            });

            // Initialize Select2 for tags
            if ($.fn.select2) {
                $('.select2_activation').select2({
                    tags: true,
                    tokenSeparators: [',']
                });
            }

            // Initialize Select2 for Country with ajax
            $('#country').select2({
                ajax: {
                    url: "{{ route('ad.countries') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                placeholder: 'Select Country',
                minimumInputLength: 0,
                allowClear: true
            });

            // Initialize Select2 for State with ajax
            $('#state').select2({
                ajax: {
                    url: "{{ route('ad.states') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            country_id: $('#country').val()
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                placeholder: 'Select State',
                minimumInputLength: 0,
                allowClear: true
            });

            // Initialize Select2 for City with ajax
            $('#city').select2({
                ajax: {
                    url: "{{ route('ad.cities') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            state_id: $('#state').val()
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                placeholder: 'Select City',
                minimumInputLength: 0,
                allowClear: true,
            });

            // Handle Country change - enable state and reset
            $('#country').on('change', function() {
                $('#state').prop('disabled', false).val(null).trigger('change');
                $('#city').prop('disabled', true).val(null).trigger('change');
            });

            // Handle State change - enable city and reset
            $('#state').on('change', function() {
                $('#city').prop('disabled', false).val(null).trigger('change');
            });

            // Initialize Summernote
            $('.summernote').summernote({
                tabsize: 2,
                height: 250,
                toolbar: [
                    ["style", ["style"]],
                    ["font", ["bold", "underline", "clear"]],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["table", ["table"]],
                    ["insert", ["link", "picture"]],
                    ["view", ["fullscreen", "help"]],
                ],
            });

            // Restore form data from localStorage after initializations
            restoreFormData();

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
                    $.get("{{ route('ad.subcategories') }}", {
                        parent_id: parentId
                    }, function(data) {
                        if (data.length > 0) {
                            data.forEach(function(item) {
                                subcategorySelect.append(
                                    `<option value="${item.id}">${item.title}</option>`);
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
                    $.get("{{ route('ad.subcategories') }}", {
                        parent_id: parentId
                    }, function(data) {
                        if (data.length > 0) {
                            data.forEach(function(item) {
                                subSubcategorySelect.append(
                                    `<option value="${item.id}">${item.title}</option>`);
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
                $.get("{{ route('ad.custom.fields') }}", {
                    category_id: categoryId
                }, function(fields) {
                    let html = '';
                    if (fields.length > 0) {
                        html += '<h6 class="mt-3 mb-2">Additional Information</h6>';
                        html += '<div class="row g-3">';
                        fields.forEach(function(field) {
                            const required = field.is_required == 1 ? 'required' : '';
                            const requiredStar = field.is_required == 1 ?
                                '<span class="text-danger">*</span>' : '';

                            html += '<div class="col-sm-6 custom-field-group">';
                            html += `<label>${field.title} ${requiredStar}</label>`;

                            switch (parseInt(field.type)) {
                                case {{ config('settings.input_types.text') }}:
                                    html +=
                                        `<input type="text" name="custom_field[${field.id}]" class="input-style" placeholder="Enter ${field.title}" value="${field.default_value || ''}" ${required}>`;
                                    break;
                                case {{ config('settings.input_types.number') }}:
                                    html +=
                                        `<input type="number" name="custom_field[${field.id}]" class="input-style" placeholder="Enter ${field.title}" value="${field.default_value || ''}" ${required}>`;
                                    break;
                                case {{ config('settings.input_types.select') }}:
                                    html +=
                                        `<select name="custom_field[${field.id}]" class="input-style" ${required}>`;
                                    html += '<option value="">Select</option>';
                                    if (field.options) {
                                        field.options.forEach(function(opt) {
                                            html +=
                                                `<option value="${opt.id}">${opt.value}</option>`;
                                        });
                                    }
                                    html += '</select>';
                                    break;
                                case {{ config('settings.input_types.text_area') }}:
                                    html +=
                                        `<textarea name="custom_field[${field.id}]" class="input-style" placeholder="Write ${field.title}" rows="3" ${required}>${field.default_value || ''}</textarea>`;
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
                                    html +=
                                        `<input type="file" name="customfile_${field.id}" class="input-style w-100" ${required}>`;
                                    break;
                                case {{ config('settings.input_types.date') }}:
                                    html +=
                                        `<input type="date" name="custom_field[${field.id}]" class="input-style w-100" value="${field.default_value || ''}" ${required}>`;
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
                // Validate step 1 fields before proceeding
                let isValid = true;
                const errors = [];

                // Clear previous errors
                $('.invalid-feedback').removeClass('d-block').text('');
                $('.is-invalid').removeClass('is-invalid');

                // Validate title
                const title = $('#title').val().trim();
                if (!title) {
                    isValid = false;
                    $('#title').addClass('is-invalid');
                    $('#title').siblings('.invalid-feedback').text('Item name is required').addClass(
                        'd-block');
                    errors.push('title');
                }

                // Validate category
                const category = $('#final-category').val();
                if (!category) {
                    isValid = false;
                    $('#final-category').addClass('is-invalid');
                    $('#category-breadcrumb').siblings('.invalid-feedback').text('Please select a category')
                        .addClass('d-block');
                    errors.push('category');
                }

                // Validate description
                const description = $('.summernote').summernote('code').replace(/<[^>]*>/g, '').trim();
                if (!description || description.length < 150) {
                    isValid = false;
                    $('#description').addClass('is-invalid');
                    $('#description').siblings('.invalid-feedback').text(
                        !description ? 'Description is required' :
                        'Description must be at least 150 characters'
                    ).addClass('d-block');
                    errors.push('description');
                }

                // Validate price
                const price = $('#price').val();
                if (!price || parseFloat(price) < 0) {
                    isValid = false;
                    $('#price').addClass('is-invalid');
                    $('#price').siblings('.invalid-feedback').text(
                        !price ? 'Price is required' : 'Price cannot be negative'
                    ).addClass('d-block');
                    errors.push('price');
                }

                // Validate contact email
                const email = $('#contact_email').val().trim();
                if (!email) {
                    isValid = false;
                    $('#contact_email').addClass('is-invalid');
                    $('#contact_email').siblings('.invalid-feedback').text('Contact email is required')
                        .addClass('d-block');
                    errors.push('contact_email');
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    isValid = false;
                    $('#contact_email').addClass('is-invalid');
                    $('#contact_email').siblings('.invalid-feedback').text(
                        'Please provide a valid email address').addClass('d-block');
                    errors.push('contact_email');
                }

                // Validate phone
                const phone = $('#phone').val().trim();
                if (!phone) {
                    isValid = false;
                    $('#phone').addClass('is-invalid');
                    $('#phone').siblings('.invalid-feedback').text('Phone number is required').addClass(
                        'd-block');
                    errors.push('phone');
                }

                // Validate thumbnail image
                const thumbnailFile = $('#thumbnail_image')[0].files[0];
                if (!thumbnailFile) {
                    isValid = false;
                    $('#thumbnail_image').addClass('is-invalid');
                    $('#thumbnail_image').siblings('.invalid-feedback').text('Featured image is required')
                        .addClass('d-block');
                    errors.push('thumbnail_image');
                }

                if (isValid) {
                    currentTab = 1;
                    showTab(currentTab);
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                } else {
                    // Scroll to first error
                    const firstError = $('.is-invalid:first');
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 500);
                    }
                }
            });

            $('#prevBtn').on('click', function() {
                currentTab = 0;
                showTab(currentTab);
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // ============================================
            // Custom File Input - Display File Names
            // ============================================
            const maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

            // Thumbnail slot
            $('#thumbnail_image').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > maxFileSize) {
                        alert(
                            `File size (${(file.size / 1024 / 1024).toFixed(2)}MB) exceeds the maximum allowed size of 5MB. Please choose a smaller file.`
                        );
                        this.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        $('#thumbnail-slot .slot-placeholder').hide();
                        $('#thumbnail-slot .slot-image img').attr('src', ev.target.result);
                        $('#thumbnail-slot .slot-image').show();
                        $('#thumbnail-slot').addClass('has-image');
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#thumbnail-remove').on('click', function(e) {
                e.stopPropagation();
                $('#thumbnail_image').val('');
                $('#thumbnail-slot .slot-image img').attr('src', '');
                $('#thumbnail-slot .slot-image').hide();
                $('#thumbnail-slot .slot-placeholder').show();
                $('#thumbnail-slot').removeClass('has-image');
            });

            // ============================================
            // Gallery Image Slots
            // ============================================
            const slotFiles = {}; // slot index => File object

            // File selected for a slot
            $(document).on('change', '.slot-file-input', function() {
                const file = this.files[0];
                if (!file) return;

                const $slot = $(this).closest('.gallery-slot');
                const slotIndex = parseInt($slot.data('slot'));

                if (file.size > maxFileSize) {
                    alert(
                        `File "${file.name}" is too large (${(file.size/1024/1024).toFixed(2)}MB). Max allowed is 5MB.`
                    );
                    this.value = '';
                    return;
                }

                slotFiles[slotIndex] = file;

                const reader = new FileReader();
                reader.onload = function(ev) {
                    $slot.find('.slot-placeholder').hide();
                    $slot.find('.slot-image img').attr('src', ev.target.result);
                    $slot.find('.slot-image').show();
                    $slot.addClass('has-image');
                };
                reader.readAsDataURL(file);
                this.value = '';
            });

            // Remove image from slot
            $(document).on('click', '.slot-remove', function(e) {
                e.stopPropagation();
                const $slot = $(this).closest('.gallery-slot');
                const slotIndex = parseInt($slot.data('slot'));

                delete slotFiles[slotIndex];
                $slot.find('.slot-image img').attr('src', '');
                $slot.find('.slot-image').hide();
                $slot.find('.slot-placeholder').show();
                $slot.removeClass('has-image');
            });

            // ============================================
            // Ajax Form Submission
            // ============================================
            $('#ad-post-form').on('submit', function(e) {
                e.preventDefault();

                // Clear previous errors and messages
                $('.invalid-feedback').removeClass('d-block').text('');
                $('.is-invalid').removeClass('is-invalid');
                $('#form-messages').html('');

                // Add loading state to submit button
                const $submitBtn = $('#submitBtn');
                $submitBtn.addClass('btn-loading').prop('disabled', true);

                // Prepare form data
                const formData = new FormData(this);

                // Add gallery images from slot files
                formData.delete('gallery_images[]');
                Object.values(slotFiles).forEach(function(file) {
                    formData.append('gallery_images[]', file);
                });

                $.ajax({
                    url: "{{ route('ad.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Remove loading state
                        $submitBtn.removeClass('btn-loading').prop('disabled', false);

                        if (response.success) {
                            // Clear localStorage on successful submission
                            clearFormData();

                            // Show success message
                            $('#form-messages').html(
                                `<div class="success-message">${response.message}</div>`
                            );

                            // Scroll to top to show message
                            $('html, body').animate({
                                scrollTop: 0
                            }, 300);

                            // Redirect to ad details page after a short delay
                            if (response.redirect_url) {
                                setTimeout(function() {
                                    window.location.href = response.redirect_url;
                                }, 1500);
                            }
                        }
                    },
                    error: function(xhr) {
                        // Remove loading state
                        $submitBtn.removeClass('btn-loading').prop('disabled', false);

                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors;
                            let errorCount = 0;

                            // Display errors below each field
                            $.each(errors, function(field, messages) {
                                errorCount++;
                                const input = $(`[name="${field}"]`);
                                const errorContainer = input.siblings(
                                    '.invalid-feedback');

                                if (errorContainer.length === 0) {
                                    // If no error container exists, create one
                                    input.after(
                                        `<div class="invalid-feedback">${messages[0]}</div>`
                                    );
                                    input.next('.invalid-feedback').addClass('d-block');
                                } else {
                                    errorContainer.text(messages[0]).addClass(
                                        'd-block');
                                }

                                // Add is-invalid class
                                input.addClass('is-invalid');

                                // For Select2, add class to the container
                                if (input.hasClass('select2-ajax') || input.hasClass(
                                        'select2_activation')) {
                                    input.next('.select2-container').find(
                                            '.select2-selection')
                                        .addClass('is-invalid');
                                }
                            });

                            // Show error message at top
                            $('#form-messages').html(
                                `<div class="error-message">Please fix ${errorCount} validation error${errorCount > 1 ? 's' : ''} below and try again.</div>`
                            );

                            // Scroll to first error
                            const firstError = $('.is-invalid:first');
                            if (firstError.length) {
                                $('html, body').animate({
                                    scrollTop: firstError.offset().top - 100
                                }, 500);
                            } else {
                                // If no specific error found, scroll to top
                                $('html, body').animate({
                                    scrollTop: 0
                                }, 300);
                            }
                        } else {
                            // Other errors
                            const message = xhr.responseJSON?.message ||
                                'An error occurred while submitting your ad. Please try again.';

                            $('#form-messages').html(
                                `<div class="error-message">${message}</div>`
                            );

                            // Scroll to top to show message
                            $('html, body').animate({
                                scrollTop: 0
                            }, 300);
                        }
                    }
                });
            });

            // Remove error styling on input change
            $('input, select, textarea').on('change input', function() {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').removeClass('d-block');

                // For Select2
                if ($(this).hasClass('select2-ajax') || $(this).hasClass('select2_activation')) {
                    $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
