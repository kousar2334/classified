@php
    $lang = request()->get('lang');
@endphp

@extends('backend.layouts.dashboard_layout')
@section('title')
    {{ translation('Edit Ad') }}
@endsection
@section('page-style')
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.css') }}">
    <link href="{{ asset('/public/web-assets/backend/plugins/summernote/summernote-lite.css') }}" rel="stylesheet" />
@endsection
@section('page-content')
    <form action="{{ route('classified.ads.update') }}" method="POST" class="row">
        @csrf
        <div class="col-lg-8">
            <div class="mb-3">
                <p class="alert alert-info">You are editing <strong>"{{ getLanguageNameByCode($lang) }}"</strong>
                    version
                </p>
            </div>
            <!--Language Switcher-->
            <ul class="nav nav-tabs nav-fill border-light border-0">
                @foreach (getAllLanguages() as $key => $language)
                    <li class="nav-item">
                        <a class="nav-link @if ($language->code == $lang) active border-0 @else bg-light @endif py-3"
                            href="{{ route('classified.ads.edit', ['id' => $ad_details->id, 'lang' => $language->code]) }}">
                            <img src="{{ asset('/public/web-assets/backend/img/flags') . '/' . $language->code . '.png' }}"
                                width="20px">
                            <span>{{ $language->name }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <!--End Language Switcher--->

            <div class="card mb-30">
                <div class="card-header bg-white border-bottom2 py-3">
                    <h4>{{ translation('Ad Information') }}</h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="id" value="{{ $ad_details->id }}">
                    <input type="hidden" name="lang" value="{{ $lang }}">

                    <div class="form-row mb-20">
                        <div class="col-sm-3">
                            <label class="font-14 bold black">{{ translation('Title') }} </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control"
                                value="{{ $ad_details->translation('title', $lang) }}"
                                placeholder="{{ translation('Type Enter') }}">
                            @if ($errors->has('title'))
                                <div class="invalid-input">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-row mb-20 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                        <div class="col-sm-3">
                            <label class="font-14 bold black ">{{ translation('Category') }} </label>
                        </div>
                        <div class="col-sm-9">
                            <select class="category form-control" name="category">
                                @if ($ad_details->categoryInfo != null)
                                    <option value="{{ $ad_details->category }}" selected>
                                        {{ $ad_details->categoryInfo->translation('title') }}
                                    </option>
                                @endif
                            </select>
                            @if ($errors->has('category'))
                                <div class="invalid-input">{{ $errors->first('category') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-row mb-20 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                        <div class="col-sm-3">
                            <label class="font-14 bold black">{{ translation('Condition') }} </label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" name="condition">
                                @foreach ($conditions as $condition)
                                    <option value="{{ $condition->id }}" @selected($ad_details->item_condition == $condition->id)>
                                        {{ $condition->translation('title', $lang) }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('condition'))
                                <div class="invalid-input">{{ $errors->first('condition') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-row mb-20 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                        <div class="col-sm-3">
                            <label class="font-14 bold black">{{ translation('Price') }} </label>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group addon">
                                <input type="number" name="price" value="{{ $ad_details->price }}"
                                    class="form-control style--two" placeholder="0.00">
                                <div class="input-group-append">
                                    <span class="input-group-text black">
                                        <input id="negotiable" name="is_negotiable" @checked($ad_details->is_negotiable == config('settings.general_status.active'))
                                            type="checkbox" />
                                        <small>{{ translation('Negotiable') }}</small>
                                    </span>
                                </div>
                            </div>
                            @if ($errors->has('price'))
                                <div class="invalid-input">{{ $errors->first('price') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-30">
                <div class="card-header bg-white border-bottom2 py-3">
                    <h4>{{ translation('Ad Description') }}</h4>
                </div>
                <div class="card-body">
                    <div class="form-row mb-20">
                        <div class="form-group col-lg-12">
                            <textarea class="form-control" id="ad_description" name="description">{{ $ad_details->translation('description', $lang) }}</textarea>
                            @if ($errors->has('description'))
                                <div class="invalid-input">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <div class="card mb-30 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                <div class="card-header bg-white border-bottom2 py-3">
                    <h4>{{ translation('Images') }}</h4>
                </div>
                <div class="card-body">
                    <div class="form-row mb-20">
                        <div class="col-sm-3">
                            <label class="font-14 bold black mb-0">{{ translation('Thumbnail Image') }} </label>
                            <p>240x160</p>
                        </div>
                        <div class="col-sm-">
                            @include('core::base.includes.media.media_input', [
                                'input' => 'thumbnail_image',
                                'data' => $ad_details->thumbnail_image,
                            ])
                            @if ($errors->has('thumbnail_image'))
                                <div class="invalid-input">{{ $errors->first('thumbnail_image') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row mb-20 product-gallery-images">
                        <div class="col-sm-3">
                            <label class="font-14 bold black mb-0">{{ translation('Gallery Images') }} </label>
                            <p>825x550</p>
                        </div>
                        <div class="col-sm-9">
                            @php
                                $galleryImages = $ad_details->galleryImages->pluck('image_id')->toArray();
                            @endphp
                            @include('core::base.includes.media.media_input_multi_select', [
                                'input' => 'gallery_images',
                                'data' => implode(',', $galleryImages),
                                'indicator' => 1,
                                'container_id' => '#multi_input_1',
                            ])
                            @if ($errors->has('gallery_images'))
                                <div class="invalid-input">{{ $errors->first('gallery_images') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-30 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                <div class="card-header bg-white border-bottom2 py-3">
                    <h4>{{ translation('Custom Fields') }}</h4>
                </div>
                <div class="card-body">
                    @foreach ($ad_details->customFields() as $cf)
                        @php
                            $field = \Plugin\ClassiLooksCore\Models\AdsCustomField::with([
                                'custom_field_translations',
                                'options',
                            ])->find($cf['flied_id']);
                        @endphp
                        @if ($field != null)
                            <div class="form-row mb-20">
                                <div class="col-sm-3">
                                    <label class="font-14 bold black">{{ $field->translation('title', $lang) }} </label>
                                </div>
                                <div class="col-sm-9">
                                    @if ($cf['type'] == config('settings.input_types.text'))
                                        <input type="text" name="custom_field[{{ $field->id }}]" class="form-control"
                                            value="{{ $cf['value'] }}"
                                            placeholder="{{ translation('Type ') }} {{ $field->translation('title', $lang) }}">
                                    @endif
                                    @if ($cf['type'] == config('settings.input_types.number'))
                                        <input type="number" name="custom_field[{{ $field->id }}]"
                                            class="form-control" value="{{ $cf['value'] }}"
                                            placeholder="{{ translation('Type ') }} {{ $field->translation('title', $lang) }}">
                                    @endif
                                    @if ($cf['type'] == config('settings.input_types.text_area'))
                                        <textarea name="custom_field[{{ $field->id }}]" class="form-control">{{ $cf['value'] }}</textarea>
                                    @endif
                                    @if ($cf['type'] == config('settings.input_types.date'))
                                        <input type="date" name="custom_field[{{ $field->id }}]"
                                            class="form-control" value="{{ $cf['value'] }}"
                                            placeholder="{{ translation('Type ') }} {{ $field->translation('title', $lang) }}">
                                    @endif
                                    @if ($cf['type'] == config('settings.input_types.select'))
                                        <select name="custom_field[{{ $field->id }}]" class="form-control">
                                            @foreach ($field->options as $option)
                                                <option value="{{ $option->id }}" @selected($option->id == $cf['value'])>
                                                    {{ $option->translation('value', $lang) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @if ($cf['type'] == config('settings.input_types.radio'))
                                        @foreach ($field->options as $option)
                                            <label class="mr-2">
                                                <input type="radio" name="custom_field[{{ $field->id }}]"
                                                    value="{{ $option->id }}" @checked($option->id == $cf['value']) />
                                                {{ $option->translation('value', $lang) }}
                                            </label>
                                        @endforeach
                                    @endif

                                    @if ($cf['type'] == config('settings.input_types.checkbox'))
                                        @foreach ($field->options as $option)
                                            <label class="mr-2">
                                                <input type="checkbox" name="custom_field[{{ $field->id }}][]"
                                                    value="{{ $option->id }}" @checked(in_array($option->id, $cf['value'])) />
                                                {{ $option->translation('value', $lang) }}
                                            </label>
                                        @endforeach
                                    @endif
                                    @if ($cf['type'] == config('settings.input_types.file'))
                                        @include('core::base.includes.media.media_input', [
                                            'input' => 'customfile_' . $field->id,
                                            'data' => $cf['value'],
                                        ])
                                    @endif

                                    @if ($errors->has('title'))
                                        <div class="invalid-input">{{ $errors->first('title') }}</div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>

        <div class="col-lg-4">
            <div class="card mb-30 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                <div class="card-header bg-white border-bottom2 py-3">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <h4>{{ translation('Featured') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row mb-20">
                        <div class="col-sm-6">
                            <label class="font-14 bold black ">{{ translation('Status') }} </label>
                        </div>
                        <div class="col-sm-6">
                            <label class="switch glow primary medium">
                                <input type="checkbox" name="is_featured"
                                    @if ($ad_details->is_featured == config('settings.general_status.active')) checked @endif>
                                <span class="control"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-30 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                <div class="card-header bg-white border-bottom2 py-3">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <h4>{{ translation('Tags') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row mb-20 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                        <div class="col-sm-12">
                            <select class="tags form-control" name="tags[]" multiple>
                                @foreach ($ad_details->tags as $tag)
                                    <option value="{{ $tag->id }}" selected>
                                        {{ $tag->title }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('tag'))
                                <div class="invalid-input">{{ $errors->first('tag') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-30 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                <div class="card-header bg-white border-bottom2 py-3">
                    <h4>{{ translation('Contact Info') }}</h4>
                </div>
                <div class="card-body">
                    <div class="contact-card">
                        <img src="{{ asset(getFilePath($ad_details->userInfo->image)) }}" class="img-80 img-thumbnail"
                            alt="{{ $ad_details->userInfo->name }}">
                        <p class="black h6 mb-0 mb-1 mt-2"><span class="bold">{{ translation('Name') }}:</span>
                            {{ $ad_details->userInfo->name }}</p>
                        <p class="black h6 mb-0 mb-1"><span class="bold">{{ translation('Email') }}:</span>
                            {{ $ad_details->contact_email }}
                        </p>
                        <p class="black h6 mb-0 mb-1"><span class="bold">{{ translation('Phone') }}:</span>
                            {{ $ad_details->contact_phone }}</p>
                    </div>
                    <div class="form-row mb-20">
                        <div class="col-sm-6">
                            <label class="font-14 bold black ">{{ translation('Phone Visible') }} </label>
                        </div>
                        <div class="col-sm-6">
                            <label class="switch glow primary medium">
                                <input type="checkbox" name="contact_is_hide"
                                    @if ($ad_details->contact_is_hide == config('settings.general_status.active')) checked @endif>
                                <span class="control"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-30 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                <div class="card-header bg-white border-bottom2 py-3">
                    <h4>{{ translation('Location') }}</h4>
                </div>
                <div class="card-body p-0">
                    @if ($ad_details->cityInfo != null)
                        <iframe width="100%" height="250" frameborder="0"
                            src="https://www.google.com/maps/embed/v1/place?q={{ $ad_details->cityInfo->name }}&key=AIzaSyBz0OQItk9_cip0UiVTR7NL9lL9oR5VR_Q"
                            allowfullscreen>
                        </iframe>
                    @endif
                </div>
            </div>
        </div>

        <!--Form submit area-->
        <div
            class="bottom-button d-flex align-items-center justify-content-sm-end gap-10 flex-wrap justify-content-center">
            <button type="submit" name="status" value="{{ config('settings.general_status.in_active') }}"
                class="btn btn-dark btn-outline-info" tabindex="4">
                {{ translation('Update & Pending') }}
            </button>
            <button type="submit" name="status" value="{{ config('settings.general_status.active') }}"
                class="btn btn-outline-primary" tabindex="4">
                {{ translation('Update & Publish') }}
            </button>
        </div>
        <!--End Form submit area-->

    </form>

@endsection
@section('page-script')
    <!--Select2-->
    <script src="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/public/web-assets/backend/plugins/summernote/summernote-lite.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone();
            /**
             *  category Select
             * 
             */
            $('.category').select2({
                theme: "classic",
                placeholder: '{{ translation('Select category') }}',
                closeOnSelect: true,
                ajax: {
                    url: '{{ route('classified.ads.categories.options') }}',
                    dataType: 'json',
                    method: "GET",
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });

            /**
             *  tags options
             * 
             */
            $('.tags').select2({
                theme: "classic",
                tags: true,
                placeholder: '{{ translation('Select or insert  tags') }}',
                closeOnSelect: true,
                ajax: {
                    url: '{{ route('classified.ads.tag.options') }}',
                    dataType: 'json',
                    method: "GET",
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });

            // SUMMERNOTE INIT
            $('#ad_description').summernote({
                tabsize: 2,
                height: 200,
                codeviewIframeFilter: false,
                codeviewFilter: true,
                codeviewFilterRegex: /<\/*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|ilayer|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|t(?:itle|extarea)|xml)[^>]*>|on\w+\s*=\s*"[^"]*"|on\w+\s*=\s*'[^']*'|on\w+\s*=\s*[^\s>]+/gi,
                toolbar: [
                    ["style", ["style"]],
                    ['fontsize', ['fontsize']],
                    ["font", ["bold", "underline", "clear"]],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["view", ["fullscreen"]],

                ],
                placeholder: 'Enter Description',
            });
        })(jQuery);
    </script>
@endsection
