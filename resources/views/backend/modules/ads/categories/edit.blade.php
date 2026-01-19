@php
    $lang = request()->get('lang');
@endphp

@extends('backend.layouts.dashboard_layout')
@section('title')
    {{ translate('Edit Category') }}
@endsection
@section('page-style')
    <!--Select2-->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.css') }}">
@endsection
@section('page-content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="mb-3">
                <p class="alert alert-info">You are editing <strong>"{{ getLanguageNameByCode($lang) }}"</strong>
                    version
                </p>
            </div>
            <div class="card mb-30">
                <div class="card-header bg-white border-bottom2 py-3">
                    <h4>{{ translate('Category Information') }}</h4>
                </div>
                <div class="card-body">
                    <!--Language Switcher-->
                    <ul class="nav nav-tabs nav-fill border-light border-0 mb-20">
                        @foreach (getAllLanguages() as $key => $language)
                            <li class="nav-item">
                                <a class="nav-link @if ($language->code == $lang) active border-0 @else bg-light @endif py-3"
                                    href="{{ route('classified.ads.categories.edit', ['id' => $category->id, 'lang' => $language->code]) }}">
                                    <img src="{{ asset('/public/web-assets/backend/img/flags') . '/' . $language->code . '.png' }}"
                                        width="20px">
                                    <span>{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <!--End Language Switcher--->
                    <form action="{{ route('classified.ads.categories.update') }}" method="POST">
                        @csrf
                        <div class="form-row mb-20 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                            <div class="form-group col-lg-6">
                                <label class="black font-14">{{ translate('Icon') }}</label>
                                @include('core::base.includes.media.media_input', [
                                    'input' => 'icon',
                                    'data' => $category->icon,
                                ])
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="black font-14">{{ translate('Featured Image') }}</label>
                                @include('core::base.includes.media.media_input', [
                                    'input' => 'image',
                                    'data' => $category->image,
                                ])
                            </div>
                        </div>

                        <div class="form-row mb-20">
                            <div class="col-sm-12">
                                <label class="font-14 bold black">{{ translate('Title') }} </label>
                            </div>
                            <div class="col-sm-12">
                                <input type="hidden" name="id" value="{{ $category->id }}">
                                <input type="hidden" name="lang" value="{{ $lang }}">
                                <input type="text" name="title"
                                    class="form-control {{ !empty($lang) && $lang != getdefaultlang() ? '' : 'slugable_input' }}"
                                    value="{{ $category->translation('title', $lang) }}"
                                    placeholder="{{ translate('Type Enter') }}">
                                @if ($errors->has('title'))
                                    <div class="invalid-input">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                        </div>

                        @include('plugin/classilookscore::includes.permalink', [
                            'root_url' => 'ads/category',
                            'value' => $category->permalink,
                            'lang' => $lang,
                        ])

                        <div
                            class="form-row mb-20 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                            <div class="col-sm-12">
                                <label class="font-14 bold black ">{{ translate('Parent') }} </label>
                            </div>
                            <div class="col-sm-12">
                                <select class="parent-options form-control" name="parent">
                                    @if ($category->parentCategory != null)
                                        <option value="{{ $category->parent }}" selected>
                                            {{ $category->parentCategory->translation('title') }}
                                        </option>
                                    @endif
                                </select>
                                @if ($errors->has('parent'))
                                    <div class="invalid-input">{{ $errors->first('parent') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-row {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                            <div class="form-group col-lg-12">
                                <label class="black font-14">{{ translate('Status') }}</label>
                                <select name="status" class="form-control">
                                    <option value="{{ config('settings.general_status.active') }}"
                                        @selected($category->status == config('settings.general_status.active'))>
                                        {{ translate('Active') }}
                                    </option>
                                    <option value="{{ config('settings.general_status.in_active') }}"
                                        @selected($category->status == config('settings.general_status.in_active'))>
                                        {{ translate('Inactive') }}
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn long">{{ translate('Save Changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('core::base.media.partial.media_modal')
@endsection
@section('page-script')
    <!--Select2-->
    <script src="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone();
            /**
             *  Parent Select
             * 
             */
            $('.parent-options').select2({
                theme: "classic",
                placeholder: '{{ translate('Select parent category') }}',
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
        })(jQuery);
    </script>

    @include('plugin/classilookscore::includes.permalink_script')
@endsection
