@php
    $links = [
        [
            'title' => 'Colors Setup',
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    {{ translation('Colors Setup') }}
@endsection
@section('page-style')
    <link rel="stylesheet"
        href="{{ asset('public/web-assets/backend/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <style>
        .colorpicker-input {
            position: relative;
        }

        .colorpicker-input .colorpicker {
            top: 100% !important;
            left: 0 !important;
        }

        .color-preview-swatch {
            width: 22px;
            height: 22px;
            border-radius: 4px;
            display: inline-block;
            border: 1px solid #ccc;
            vertical-align: middle;
        }

        .color-var-badge {
            font-family: monospace;
            font-size: 11px;
            background: #f4f4f4;
            color: #555;
            padding: 1px 6px;
            border-radius: 3px;
            border: 1px solid #ddd;
        }

        .color-group-title {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: #888;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #eee;
        }
    </style>
@endsection
@section('page-content')
    <x-admin-page-header title="" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Colors Setup') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 col-sm-3">
                                    @include('backend.modules.appearances.site-setting.setting_tabs')
                                </div>
                                <div class="col-7 col-sm-9">
                                    <div class="tab-content">
                                        <div
                                            class="tab-pane text-left fade {{ Request::routeIs(['admin.appearance.site.setting.colors']) ? 'show active' : '' }}">
                                            <h4>{{ translation('Colors Setup') }}</h4>
                                            <hr>
                                            <form method="POST"
                                                action="{{ route('admin.appearance.site.setting.colors.update') }}">
                                                @csrf

                                                {{-- Primary Colors --}}
                                                <p class="color-group-title">{{ translation('Primary Colors') }}</p>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ translation('Primary Color') }}
                                                                <span class="color-var-badge">--primary-color</span>
                                                            </label>
                                                            <div class="input-group colorpicker-input">
                                                                <input type="text" class="form-control"
                                                                    name="site_primary_color"
                                                                    value="{{ get_setting('site_primary_color', '#260ac4') }}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="fas fa-square"
                                                                            style="color:{{ get_setting('site_primary_color', '#260ac4') }}"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ translation('Primary Dark') }}
                                                                <span class="color-var-badge">--primary-color-dark</span>
                                                            </label>
                                                            <div class="input-group colorpicker-input">
                                                                <input type="text" class="form-control"
                                                                    name="site_primary_color_dark"
                                                                    value="{{ get_setting('site_primary_color_dark', '#e84e1b') }}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="fas fa-square"
                                                                            style="color:{{ get_setting('site_primary_color_dark', '#e84e1b') }}"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ translation('Primary Light') }}
                                                                <span class="color-var-badge">--primary-color-light</span>
                                                            </label>
                                                            <div class="input-group colorpicker-input">
                                                                <input type="text" class="form-control"
                                                                    name="site_primary_color_light"
                                                                    value="{{ get_setting('site_primary_color_light', '#ff9a5c') }}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="fas fa-square"
                                                                            style="color:{{ get_setting('site_primary_color_light', '#ff9a5c') }}"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ translation('Primary Lighter') }}
                                                                <span class="color-var-badge">--primary-color-lighter</span>
                                                            </label>
                                                            <div class="input-group colorpicker-input">
                                                                <input type="text" class="form-control"
                                                                    name="site_primary_color_lighter"
                                                                    value="{{ get_setting('site_primary_color_lighter', '#ffb347') }}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="fas fa-square"
                                                                            style="color:{{ get_setting('site_primary_color_lighter', '#ffb347') }}"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ translation('Primary Shadow') }}
                                                                <span class="color-var-badge">--primary-color-shadow</span>
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                name="site_primary_color_shadow"
                                                                value="{{ get_setting('site_primary_color_shadow', '#f766310f') }}"
                                                                placeholder="#rrggbbaa — supports 8-digit hex with alpha">
                                                            <small
                                                                class="text-muted">{{ translation('Supports 8-digit hex with alpha (e.g. #f766310f)') }}</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Accent / Main Colors --}}
                                                <p class="color-group-title mt-2">{{ translation('Accent Colors') }}</p>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ translation('Main Color Two') }}
                                                                <span class="color-var-badge">--main-color-two</span>
                                                            </label>
                                                            <div class="input-group colorpicker-input">
                                                                <input type="text" class="form-control"
                                                                    name="site_main_color_two"
                                                                    value="{{ get_setting('site_main_color_two', '#524eb7') }}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="fas fa-square"
                                                                            style="color:{{ get_setting('site_main_color_two', '#524eb7') }}"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ translation('Main Color Three') }}
                                                                <span class="color-var-badge">--main-color-three</span>
                                                            </label>
                                                            <div class="input-group colorpicker-input">
                                                                <input type="text" class="form-control"
                                                                    name="site_main_color_three"
                                                                    value="{{ get_setting('site_main_color_three', '#00cad5') }}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i
                                                                            class="fas fa-square"
                                                                            style="color:{{ get_setting('site_main_color_three', '#00cad5') }}"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Text / Heading Colors --}}
                                                <p class="color-group-title mt-2">{{ translation('Text Colors') }}</p>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ translation('Heading Color') }}
                                                                <span class="color-var-badge">--heading-color</span>
                                                            </label>
                                                            <div class="input-group colorpicker-input">
                                                                <input type="text" class="form-control"
                                                                    name="site_heading_color"
                                                                    value="{{ get_setting('site_heading_color', '#333333') }}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i
                                                                            class="fas fa-square"
                                                                            style="color:{{ get_setting('site_heading_color', '#333333') }}"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ translation('Base / Secondary Color') }}
                                                                <span class="color-var-badge">--secondary-color</span>
                                                            </label>
                                                            <div class="input-group colorpicker-input">
                                                                <input type="text" class="form-control"
                                                                    name="site_base_color"
                                                                    value="{{ get_setting('site_base_color', '#fba260') }}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i
                                                                            class="fas fa-square"
                                                                            style="color:{{ get_setting('site_base_color', '#fba260') }}"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-end mt-2">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ translation('Save Changes') }}
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
        </div>
    </section>
@endsection
@section('page-script')
    <script src="{{ asset('public/web-assets/backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}">
    </script>
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                $('.colorpicker-input').colorpicker({
                    container: true,
                    placement: 'bottom'
                });
            });

            $(document).on('colorpickerChange', '.colorpicker-input', function(event) {
                $(this).find('.fa-square').css('color', event.color.toString());
            });
        })(jQuery);
    </script>
@endsection
