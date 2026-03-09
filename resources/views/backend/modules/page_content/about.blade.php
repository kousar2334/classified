@php
    $links = [
        [
            'title' => 'Page Settings',
            'route' => '',
            'active' => false,
        ],
        [
            'title' => 'About Page',
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    {{ translation('About Page Setting') }}
@endsection
@section('page-style')
    <link rel="stylesheet"
        href="{{ asset('public/web-assets/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/web-assets/backend/plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('page-content')
    <x-admin-page-header title="" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ translation('About Page') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 col-sm-3">
                                    @include('backend.modules.page_content.nav_bar')
                                </div>
                                <div class="col-7 col-sm-9">
                                    <div class=" tab-content border" id="vert-tabs-tabContent">
                                        <h5 class="p-2 mb-0">{{ translation('About Page') }}</h5>
                                        <hr class="mt-0">
                                        <div class="lang-switcher-wrap mb-3">
                                            <div class="lang-switcher-label">
                                                <i class="fas fa-globe-americas"></i>
                                                <span>{{ translation('Language') }}</span>
                                            </div>
                                            <div class="lang-switcher-tabs">
                                                @foreach (activeLanguages() as $key => $language)
                                                    <a href="{{ route('admin.page.content.about', ['lang' => $language->code]) }}"
                                                        class="lang-switcher-btn @if ($language->code == $lang) active @endif">
                                                        <span class="lang-dot"></span>
                                                        {{ $language->title }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div
                                            class="p-2 tab-pane text-left fade {{ Request::routeIs(['admin.page.content.about']) ? 'show active' : '' }}">

                                            <form method="POST" action="{{ route('admin.page.content.update') }}">
                                                @csrf
                                                <input type="hidden" name="lang" value="{{ $lang }}">
                                                <div class="form-group">
                                                    <label>{{ translation('About Section Image') }}</label>
                                                    <x-media name="about_page_image" :value="p_trans('about_page_image', $lang)"></x-media>

                                                </div>
                                                <div class="form-group">
                                                    <label>{{ translation('About Section Top Paragraph') }}</label>
                                                    <textarea name="about_top_paragraph" class="form-control summernote" id="">{{ p_trans('about_top_paragraph', $lang) }}</textarea>

                                                </div>
                                                <div class="form-group">
                                                    <label>{{ translation('About Section Left Paragraph') }}</label>
                                                    <textarea name="about_left_paragraph" class="form-control summernote" id="">{{ p_trans('about_left_paragraph', $lang) }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ translation('Exhibition Paragraph') }}</label>
                                                    <textarea name="about_exhibition_paragraph" class="form-control" id="">{{ p_trans('about_exhibition_paragraph', $lang) }}</textarea>
                                                </div>
                                                <div class="form-row justify-content-end">
                                                    <button type="submit"
                                                        class="btn btn-primary">{{ translation('Save Change') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
@section('page-script')
    <script src="{{ asset('public/web-assets/backend/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/web-assets/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            $('.summernote').summernote({
                tabsize: 2,
                height: 200,
                toolbar: [
                    ["style", ["style"]],
                    ["font", ["bold", "underline", "clear"]],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["table", ["table"]],
                    ["insert", ["link"]],
                    ["view", ["fullscreen", "help"]],
                ]
            });
            initMediaManager();
        })(jQuery);
    </script>
@endsection
