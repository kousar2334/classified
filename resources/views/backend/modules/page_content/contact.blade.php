@php
    $links = [
        [
            'title' => 'Page Settings',
            'route' => '',
            'active' => false,
        ],
        [
            'title' => 'Contact Page',
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    {{ translation('Contact Page Setting') }}
@endsection
@section('page-style')
@endsection
@section('page-content')
    <x-admin-page-header title="" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ translation('Contact Page') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 col-sm-3">
                                    @include('backend.modules.page_content.nav_bar')
                                </div>
                                <div class="col-7 col-sm-9">
                                    <div class=" tab-content border" id="vert-tabs-tabContent">
                                        <h5 class="p-2 mb-0">{{ translation('Contact Page') }}</h5>
                                        <hr class="mt-0">
                                        <div class="lang-switcher-wrap mb-3">
                                            <div class="lang-switcher-label">
                                                <i class="fas fa-globe-americas"></i>
                                                <span>{{ translation('Language') }}</span>
                                            </div>
                                            <div class="lang-switcher-tabs">
                                                @foreach (activeLanguages() as $key => $language)
                                                    <a href="{{ route('admin.page.content.contact', ['lang' => $language->code]) }}"
                                                        class="lang-switcher-btn @if ($language->code == $lang) active @endif">
                                                        <span class="lang-dot"></span>
                                                        {{ $language->title }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div
                                            class="p-2 tab-pane text-left fade {{ Request::routeIs(['admin.page.content.contact']) ? 'show active' : '' }}">

                                            <form method="POST" action="{{ route('admin.page.content.update') }}">
                                                @csrf
                                                <input type="hidden" name="lang" value="{{ $lang }}">

                                                <div class="form-group">
                                                    <label>{{ translation('Title') }}</label>
                                                    <input type="text" name="contact_title" class="form-control"
                                                        value="{{ p_trans('contact_title', $lang) }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ translation('Sub Title') }}</label>
                                                    <input type="text" name="contact_sub_title" class="form-control"
                                                        value="{{ p_trans('contact_sub_title', $lang) }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ translation('Address') }}</label>
                                                    <input type="text" name="contact_address" class="form-control"
                                                        value="{{ p_trans('contact_address', $lang) }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ translation('Email') }}</label>
                                                    <input type="text" name="contact_email" class="form-control"
                                                        value="{{ p_trans('contact_email', $lang) }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ translation('Phone 1') }}</label>
                                                    <input type="text" name="contact_phone_1" class="form-control"
                                                        value="{{ p_trans('contact_phone_1', $lang) }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ translation('Phone 2') }}</label>
                                                    <input type="text" name="contact_phone_2" class="form-control"
                                                        value="{{ p_trans('contact_phone_2', $lang) }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ translation('Opening Hours') }}</label>
                                                    <input type="text" name="contact_opening_hours" class="form-control"
                                                        value="{{ p_trans('contact_opening_hours', $lang) }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ translation('Closed Hours') }}</label>
                                                    <input type="text" name="contact_closed_hours" class="form-control"
                                                        value="{{ p_trans('contact_closed_hours', $lang) }}">
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
@endsection
