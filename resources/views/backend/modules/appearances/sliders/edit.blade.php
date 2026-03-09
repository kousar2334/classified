@php
    $links = [
        [
            'title' => 'Sliders',
            'route' => 'admin.appearance.slider.list',
            'active' => false,
        ],
        [
            'title' => 'Edit Slider',
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    Edit Slider
@endsection
@section('page-style')
@endsection
@section('page-content')
    <x-admin-page-header title="Edit Slider" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Edit Slider') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="lang-switcher-wrap mb-3">
                                <div class="lang-switcher-label">
                                    <i class="fas fa-globe-americas"></i>
                                    <span>{{ translation('Language') }}</span>
                                </div>
                                <div class="lang-switcher-tabs">
                                    @foreach (activeLanguages() as $key => $language)
                                        <a href="{{ route('admin.appearance.slider.edit.slider.item', ['slider' => $slider->id, 'lang' => $language->code]) }}"
                                            class="lang-switcher-btn @if ($language->code == $lang) active @endif">
                                            <span class="lang-dot"></span>
                                            {{ $language->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <form id="new-slider-item-form" method="POST"
                                action="{{ route('admin.appearance.slider.update.slider.item') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ translation('Title') }}</label>
                                            <input type="hidden" name="id" value="{{ $slider->id }}">
                                            <input type="hidden" name="lang" value="{{ $lang }}">
                                            <input type="text" class="form-control" name="title"
                                                value="{{ $slider->translation('title', $lang) }}"
                                                placeholder="{{ translation('Enter Title') }}">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ translation('Link') }}</label>
                                            <input type="text" class="form-control" name="button_link"
                                                placeholder="{{ translation('Enter Link') }}"
                                                value="{{ $slider->btn_link }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ translation('Image') }}</label>
                                            <x-media name="image"
                                                value="{{ $slider->translation('image', $lang) }}"></x-media>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit"
                                        class="btn btn-primary create-new-slider-item-btn">{{ translation('Save Changes') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-script')
    <script>
        (function($) {
            "use strict";
            initMediaManager();

        })(jQuery);
    </script>
@endsection
