@extends('frontend.layouts.master')
@section('meta')
    <title>Edit Ad - {{ get_setting('site_name') }}</title>
    <link rel="stylesheet" href="{{ asset('public/web-assets/backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/web-assets/backend/plugins/summernote/summernote-bs4.min.css') }}">
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

        <form action="{{ route('member.ad.update', $ad->uid) }}" method="POST" enctype="multipart/form-data"
            id="ad-edit-form">
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
                                        <div class="edit-page-header mt-3 mb-2">
                                            <h4>Edit Listing</h4>
                                            <a href="{{ route('member.my.listings') }}" class="back-link">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                                </svg>
                                                Back to My Listings
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-lg-8">
                                        <div class="post-add-wraper">
                                            <!-- Item Name -->
                                            <div class="item-name box-shadow1 p-24">
                                                <label for="title">Item Name <span class="text-danger">*</span></label>
                                                <input type="text" name="title" id="title"
                                                    value="{{ old('title', $ad->title) }}"
                                                    class="input-style w-100 @error('title') is-invalid @enderror"
                                                    placeholder="Item Name">
                                                <div class="invalid-feedback @error('title') d-block @enderror">
                                                    @error('title')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- About Item -->
                                            <div class="about-item box-shadow1 p-24 mt-4">
                                                <h3 class="head4">About Item</h3>
                                                <div class="row g-3 mt-3">
                                                    <!-- Category -->
                                                    <div class="col-12">
                                                        <label for="category">Category <span
                                                                class="text-danger">*</span></label>
                                                        <select name="" id="select-category"
                                                            class="input-style w-100">
                                                            <option value="">Select Category</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ $categoryHierarchy['category'] == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback"></div>
                                                    </div>

                                                    <!-- Subcategory -->
                                                    <div class="col-12" id="subcategory-wrapper"
                                                        style="{{ $categoryHierarchy['subcategory'] ? '' : 'display:none;' }}">
                                                        <label for="subcategory">Subcategory <span
                                                                class="text-danger">*</span></label>
                                                        <select name="" id="select-subcategory"
                                                            class="input-style w-100">
                                                            <option value="">Select Subcategory</option>
                                                        </select>
                                                    </div>

                                                    <!-- Sub-subcategory -->
                                                    <div class="col-12" id="sub-subcategory-wrapper"
                                                        style="{{ $categoryHierarchy['subSubcategory'] ? '' : 'display:none;' }}">
                                                        <label for="sub-subcategory">Sub Subcategory</label>
                                                        <select id="select-sub-subcategory" class="input-style w-100">
                                                            <option value="">Select Sub Subcategory</option>
                                                        </select>
                                                    </div>

                                                    <!-- Hidden field to store the final selected category -->
                                                    <input type="hidden" name="category" id="final-category"
                                                        value="{{ old('category', $ad->category_id) }}">

                                                    <div class="col-12">
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
                                                    <div class="col-sm-12">
                                                        <label for="condition">Item Condition</label>
                                                        <select name="condition" id="condition"
                                                            class="input-style w-100">
                                                            <option value="">Select Condition</option>
                                                            @foreach ($conditions as $condition)
                                                                <option value="{{ $condition->id }}"
                                                                    {{ old('condition', $ad->condition_id) == $condition->id ? 'selected' : '' }}>
                                                                    {{ $condition->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Description -->
                                            <div class="description box-shadow1 p-24 mt-4">
                                                <label for="description">Description <span class="text-danger">*</span>
                                                    <span class="text-danger">(minimum 150 characters.)</span>
                                                </label>
                                                <textarea name="description" id="description" rows="6"
                                                    class="input-style w-100 textarea--form summernote @error('description') is-invalid @enderror"
                                                    placeholder="Enter a Description">{{ old('description', $ad->description) }}</textarea>
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
                                                        value="{{ old('price', $ad->price) }}"
                                                        class="input-style w-100 mb-3 @error('price') is-invalid @enderror"
                                                        placeholder="0.00" step="0.01">
                                                    <div class="invalid-feedback @error('price') d-block @enderror">
                                                        @error('price')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                    <label class="negotiable">
                                                        <input type="checkbox" class="custom-check-box" name="negotiable"
                                                            id="negotiable"
                                                            {{ old('negotiable', $ad->is_negotiable == config('settings.general_status.active')) ? 'checked' : '' }}>
                                                        <span class="ms-2">Negotiable</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Contact -->
                                            <div class="box-shadow1 p-24 mt-3">
                                                <label for="contact_email">Contact Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" name="contact_email" id="contact_email"
                                                    value="{{ old('contact_email', $ad->contact_email) }}"
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
                                                        {{ old('hide_phone_number', $ad->contact_is_hide == config('settings.general_status.active')) ? 'checked' : '' }}>
                                                    <span class="black-font"> Hide My Phone Number</span>
                                                </label>
                                                <div class="mt-3">
                                                    <input class="input-style w-100 @error('phone') is-invalid @enderror"
                                                        type="tel" name="phone"
                                                        value="{{ old('phone', $ad->contact_phone) }}" id="phone"
                                                        placeholder="Type Phone">
                                                    <div class="invalid-feedback @error('phone') d-block @enderror">
                                                        @error('phone')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Thumbnail Image -->
                                            <div class="box-shadow1 p-24 mt-3">
                                                <label for="thumbnail_image">Featured Image</label>
                                                <div class="custom-file-input">
                                                    <input type="file" name="thumbnail_image" id="thumbnail_image"
                                                        class="@error('thumbnail_image') is-invalid @enderror"
                                                        accept="image/jpg,image/jpeg,image/png,image/gif,image/webp">
                                                    <label for="thumbnail_image" class="custom-file-label">
                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                        <span>Change Featured Image</span>
                                                    </label>
                                                    <div class="file-name" id="thumbnail-file-name"></div>
                                                </div>
                                                <small class="text-muted d-block mt-2">Leave empty to keep current image |
                                                    max: 5MB</small>
                                                <div class="invalid-feedback @error('thumbnail_image') d-block @enderror">
                                                    @error('thumbnail_image')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                                <div id="thumbnail-preview" class="mt-2">
                                                    @if ($ad->thumbnail_image)
                                                        <img src="{{ asset(getFilePath($ad->thumbnail_image)) }}"
                                                            style="max-width:200px;max-height:200px;border-radius:6px;object-fit:cover;border:2px solid #e3e3e3;">
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Gallery Images -->
                                            <div class="box-shadow1 p-24 mt-3">
                                                <label for="gallery_images">Gallery Images</label>
                                                <div class="custom-file-input">
                                                    <input type="file" name="gallery_images[]" id="gallery_images"
                                                        multiple
                                                        accept="image/jpg,image/jpeg,image/png,image/gif,image/webp">
                                                    <label for="gallery_images" class="custom-file-label">
                                                        <i class="fas fa-images"></i>
                                                        <span>Add More Gallery Images</span>
                                                    </label>
                                                    <div class="file-name" id="gallery-file-name"></div>
                                                </div>
                                                <small class="text-muted d-block mt-2">You can select multiple images (max:
                                                    5MB each)</small>

                                                <!-- Existing Gallery Images -->
                                                @if ($ad->galleryImages && $ad->galleryImages->count() > 0)
                                                    <div class="existing-gallery mt-3">
                                                        <label class="mb-2">Current Gallery Images</label>
                                                        <div id="existing-gallery-preview"
                                                            style="display:flex;flex-wrap:wrap;gap:10px;">
                                                            @foreach ($ad->galleryImages as $image)
                                                                <div class="existing-gallery-image-wrapper"
                                                                    data-id="{{ $image->id }}"
                                                                    style="position:relative;display:inline-block;">
                                                                    <img src="{{ asset(getFilePath($image->image_path)) }}"
                                                                        style="width:80px;height:80px;object-fit:cover;border-radius:6px;border:2px solid #e3e3e3;">
                                                                    <span class="remove-existing-gallery-image"
                                                                        data-id="{{ $image->id }}"
                                                                        style="position:absolute;top:-8px;right:-8px;background:#ef4444;color:#fff;width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:14px;">x</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                <input type="hidden" name="deleted_gallery_images"
                                                    id="deleted_gallery_images" value="[]">

                                                <!-- New Gallery Preview -->
                                                <div id="gallery-preview" class="mt-3"></div>
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
                                                        @if ($ad->countryInfo)
                                                            <option value="{{ $ad->country_id }}" selected>
                                                                {{ $ad->countryInfo->name }}</option>
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                                <!-- State -->
                                                <div class="col-12">
                                                    <label for="state">State <span class="text-danger">*</span></label>
                                                    <select name="state" id="state" class="select2-ajax w-100"
                                                        required>
                                                        <option value="">Select State</option>
                                                        @if ($ad->stateInfo)
                                                            <option value="{{ $ad->state_id }}" selected>
                                                                {{ $ad->stateInfo->name }}</option>
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                                <!-- City -->
                                                <div class="col-12">
                                                    <label for="city">City <span class="text-danger">*</span></label>
                                                    <select name="city" id="city" class="select2-ajax w-100"
                                                        required>
                                                        <option value="">Select City</option>
                                                        @if ($ad->cityInfo)
                                                            <option value="{{ $ad->city_id }}" selected>
                                                                {{ $ad->cityInfo->name }}</option>
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                                <!-- Address -->
                                                <div class="col-12">
                                                    <label for="address">Address</label>
                                                    <textarea class="w-100 input-style" name="address" id="address" rows="3"
                                                        placeholder="Enter your detailed address">{{ old('address', $ad->address) }}</textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Video URL -->
                                        <div class="video box-shadow1 p-24 mt-3 mb-3">
                                            <label for="video_url">Video URL</label>
                                            <input type="text" class="input-style w-100" name="video_url"
                                                id="video_url" value="{{ old('video_url', $ad->video_url) }}"
                                                placeholder="YouTube URL">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="right-sidebar">
                                            <!-- Tags -->
                                            <div class="box-shadow1 tags p-24 mt-3">
                                                <label for="tags">Tags</label>
                                                <div class="select-itms">
                                                    <select name="tags[]" id="tags" class="select2_activation"
                                                        multiple>
                                                        @foreach ($tags as $tag)
                                                            <option value="{{ $tag->id }}"
                                                                {{ in_array($tag->id, $selectedTagIds) ? 'selected' : '' }}>
                                                                {{ $tag->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small>Select your tags or type a new tag name</small>
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
                                                        <span class="btn-text">Update Listing</span>
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
    <script src="{{ asset('public/web-assets/backend/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/web-assets/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Category hierarchy from server
            const categoryHierarchy = {
                category: {{ $categoryHierarchy['category'] ?? 'null' }},
                subcategory: {{ $categoryHierarchy['subcategory'] ?? 'null' }},
                subSubcategory: {{ $categoryHierarchy['subSubcategory'] ?? 'null' }}
            };

            // Existing custom field values from server
            const customFieldValues = @json($customFieldValues ?? []);

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
                                const selected = categoryHierarchy.subcategory == item
                                    .id ? 'selected' : '';
                                subcategorySelect.append(
                                    `<option value="${item.id}" ${selected}>${item.title}</option>`
                                );
                            });
                            subcategoryWrapper.show();

                            // Trigger change if we have a pre-selected subcategory
                            if (categoryHierarchy.subcategory) {
                                subcategorySelect.trigger('change');
                            }
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
                                const selected = categoryHierarchy.subSubcategory ==
                                    item.id ? 'selected' : '';
                                subSubcategorySelect.append(
                                    `<option value="${item.id}" ${selected}>${item.title}</option>`
                                );
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

            // Trigger initial category load if we have a pre-selected category
            if (categoryHierarchy.category) {
                categorySelect.trigger('change');
            }

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

                            // Get existing value for this field
                            const existingValue = customFieldValues[field.id] || field
                                .default_value || '';

                            html += '<div class="col-sm-6 custom-field-group">';
                            html += `<label>${field.title} ${requiredStar}</label>`;

                            switch (parseInt(field.type)) {
                                case {{ config('settings.input_types.text') }}:
                                    html +=
                                        `<input type="text" name="custom_field[${field.id}]" class="input-style w-100" value="${existingValue}" ${required}>`;
                                    break;
                                case {{ config('settings.input_types.number') }}:
                                    html +=
                                        `<input type="number" name="custom_field[${field.id}]" class="input-style w-100" value="${existingValue}" ${required}>`;
                                    break;
                                case {{ config('settings.input_types.select') }}:
                                    html +=
                                        `<select name="custom_field[${field.id}]" class="input-style w-100" ${required}>`;
                                    html += '<option value="">Select</option>';
                                    if (field.options) {
                                        field.options.forEach(function(opt) {
                                            const selected = existingValue == opt.id ?
                                                'selected' : '';
                                            html +=
                                                `<option value="${opt.id}" ${selected}>${opt.value}</option>`;
                                        });
                                    }
                                    html += '</select>';
                                    break;
                                case {{ config('settings.input_types.text_area') }}:
                                    html +=
                                        `<textarea name="custom_field[${field.id}]" class="input-style w-100" rows="3" ${required}>${existingValue}</textarea>`;
                                    break;
                                case {{ config('settings.input_types.checkbox') }}:
                                    if (field.options) {
                                        // Handle checkbox arrays
                                        const checkedValues = Array.isArray(existingValue) ?
                                            existingValue : (existingValue ? [existingValue] : []);
                                        field.options.forEach(function(opt) {
                                            const checked = checkedValues.includes(opt.id
                                                .toString()) || checkedValues.includes(
                                                opt.id) ? 'checked' : '';
                                            html += `<div class="form-check">
                                                <input type="checkbox" name="custom_field[${field.id}][]" value="${opt.id}" class="form-check-input" id="cf_${field.id}_${opt.id}" ${checked}>
                                                <label class="form-check-label" for="cf_${field.id}_${opt.id}">${opt.value}</label>
                                            </div>`;
                                        });
                                    }
                                    break;
                                case {{ config('settings.input_types.radio') }}:
                                    if (field.options) {
                                        field.options.forEach(function(opt) {
                                            const checked = existingValue == opt.id ?
                                                'checked' : '';
                                            html += `<div class="form-check">
                                                <input type="radio" name="custom_field[${field.id}]" value="${opt.id}" class="form-check-input" id="cf_${field.id}_${opt.id}" ${required} ${checked}>
                                                <label class="form-check-label" for="cf_${field.id}_${opt.id}">${opt.value}</label>
                                            </div>`;
                                        });
                                    }
                                    break;
                                case {{ config('settings.input_types.file') }}:
                                    html +=
                                        `<input type="file" name="customfile_${field.id}" class="input-style w-100">`;
                                    if (existingValue) {
                                        html +=
                                            `<small class="text-muted d-block mt-1">Current file: ${existingValue.split('/').pop()}</small>`;
                                    }
                                    break;
                                case {{ config('settings.input_types.date') }}:
                                    html +=
                                        `<input type="date" name="custom_field[${field.id}]" class="input-style w-100" value="${existingValue}" ${required}>`;
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
                }

                // Validate category
                const category = $('#final-category').val();
                if (!category) {
                    isValid = false;
                    $('#final-category').addClass('is-invalid');
                    $('#category-breadcrumb').siblings('.invalid-feedback').text('Please select a category')
                        .addClass('d-block');
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
                }

                // Validate price
                const price = $('#price').val();
                if (!price || parseFloat(price) < 0) {
                    isValid = false;
                    $('#price').addClass('is-invalid');
                    $('#price').siblings('.invalid-feedback').text(
                        !price ? 'Price is required' : 'Price cannot be negative'
                    ).addClass('d-block');
                }

                // Validate contact email
                const email = $('#contact_email').val().trim();
                if (!email) {
                    isValid = false;
                    $('#contact_email').addClass('is-invalid');
                    $('#contact_email').siblings('.invalid-feedback').text('Contact email is required')
                        .addClass('d-block');
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    isValid = false;
                    $('#contact_email').addClass('is-invalid');
                    $('#contact_email').siblings('.invalid-feedback').text(
                        'Please provide a valid email address').addClass('d-block');
                }

                // Validate phone
                const phone = $('#phone').val().trim();
                if (!phone) {
                    isValid = false;
                    $('#phone').addClass('is-invalid');
                    $('#phone').siblings('.invalid-feedback').text('Phone number is required').addClass(
                        'd-block');
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

            $('#thumbnail_image').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Check file size
                    if (file.size > maxFileSize) {
                        alert(
                            `File size (${(file.size / 1024 / 1024).toFixed(2)}MB) exceeds the maximum allowed size of 5MB. Please choose a smaller file.`
                        );
                        this.value = '';
                        $('#thumbnail-file-name').text('');
                        return;
                    }

                    // Display file name and size
                    $('#thumbnail-file-name').text(
                        `Selected: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)}MB)`);

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        $('#thumbnail-preview').html(
                            `<img src="${ev.target.result}" style="max-width:200px;max-height:200px;border-radius:6px;object-fit:cover;border:2px solid #e3e3e3;">`
                        );
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Gallery images with remove functionality
            let galleryFiles = [];
            let deletedGalleryIds = [];

            $('#gallery_images').on('change', function(e) {
                const files = Array.from(e.target.files);
                let invalidFiles = [];
                let validFiles = [];

                // Check each file size
                files.forEach(file => {
                    if (file.size > maxFileSize) {
                        invalidFiles.push(
                            `${file.name} (${(file.size / 1024 / 1024).toFixed(2)}MB)`);
                    } else {
                        validFiles.push(file);
                    }
                });

                // Show error for invalid files
                if (invalidFiles.length > 0) {
                    alert(
                        `The following files exceed 5MB and were not added:\n\n${invalidFiles.join('\n')}\n\nPlease choose smaller files.`
                    );
                }

                if (validFiles.length > 0) {
                    // Add valid files to galleryFiles array
                    validFiles.forEach(file => {
                        galleryFiles.push(file);
                    });

                    // Update preview
                    updateGalleryPreview();
                }

                // Clear the input so the same file can be selected again if needed
                this.value = '';
            });

            function updateGalleryPreview() {
                const preview = $('#gallery-preview');
                preview.html('');

                galleryFiles.forEach(function(file, index) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        const wrapper = $(`
                            <div class="gallery-image-wrapper" data-index="${index}" style="position:relative;display:inline-block;margin:5px;">
                                <img src="${ev.target.result}" style="width:80px;height:80px;object-fit:cover;border-radius:6px;border:2px solid #e3e3e3;">
                                <span class="remove-gallery-image" data-index="${index}" style="position:absolute;top:-8px;right:-8px;background:#ef4444;color:#fff;width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:14px;">x</span>
                            </div>
                        `);
                        preview.append(wrapper);
                    };
                    reader.readAsDataURL(file);
                });

                // Update file count
                if (galleryFiles.length > 0) {
                    $('#gallery-file-name').text(`${galleryFiles.length} new image(s) to add`);
                } else {
                    $('#gallery-file-name').text('');
                }
            }

            // Remove new gallery image
            $(document).on('click', '.remove-gallery-image', function() {
                const index = $(this).data('index');
                galleryFiles.splice(index, 1);
                updateGalleryPreview();
            });

            // Remove existing gallery image
            $(document).on('click', '.remove-existing-gallery-image', function() {
                const id = $(this).data('id');
                deletedGalleryIds.push(id);
                $('#deleted_gallery_images').val(JSON.stringify(deletedGalleryIds));
                $(this).closest('.existing-gallery-image-wrapper').fadeOut(300, function() {
                    $(this).remove();
                });
            });

            // ============================================
            // Ajax Form Submission
            // ============================================
            $('#ad-edit-form').on('submit', function(e) {
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

                // Remove default gallery images and add from galleryFiles array
                formData.delete('gallery_images[]');
                galleryFiles.forEach(function(file) {
                    formData.append('gallery_images[]', file);
                });

                $.ajax({
                    url: "{{ route('member.ad.update', $ad->uid) }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Remove loading state
                        $submitBtn.removeClass('btn-loading').prop('disabled', false);

                        if (response.success) {
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
                                    input.after(
                                        `<div class="invalid-feedback">${messages[0]}</div>`
                                    );
                                    input.next('.invalid-feedback').addClass('d-block');
                                } else {
                                    errorContainer.text(messages[0]).addClass(
                                        'd-block');
                                }

                                input.addClass('is-invalid');
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
                                $('html, body').animate({
                                    scrollTop: 0
                                }, 300);
                            }
                        } else {
                            const message = xhr.responseJSON?.message ||
                                'An error occurred while updating your ad. Please try again.';

                            $('#form-messages').html(
                                `<div class="error-message">${message}</div>`
                            );

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
            });
        });
    </script>
@endsection
