@php
    $page_title = 'Faqs';
    $links = [
        [
            'title' => $page_title,
            'route' => 'admin.appearance.faq.list',
            'active' => false,
        ],
        [
            'title' => 'Edit ' . $page_title,
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    Edit {{ $page_title }}
@endsection
@section('page-style')
@endsection
@section('page-content')
    <x-admin-page-header :title="$page_title" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Edit Faq') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="lang-switcher-wrap mb-3">
                                <div class="lang-switcher-label">
                                    <i class="fas fa-globe-americas"></i>
                                    <span>{{ translation('Language') }}</span>
                                </div>
                                <div class="lang-switcher-tabs">
                                    @foreach (activeLanguages() as $key => $language)
                                        <a href="{{ route('admin.appearance.faq.edit', ['id' => $item->id, 'lang' => $language->code]) }}"
                                            class="lang-switcher-btn @if ($language->code == $lang) active @endif">
                                            <span class="lang-dot"></span>
                                            {{ $language->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <form id="new-item-item-form" method="POST"
                                action="{{ route('admin.appearance.faq.update') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ translation('Title') }}</label>
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="hidden" name="lang" value="{{ $lang }}">
                                            <input type="text" class="form-control" name="question"
                                                value="{{ $item->translation('question', $lang) }}"
                                                placeholder="{{ translation('Enter Question') }}">
                                            @if ($errors->has('question'))
                                                <div class="error text-danger mb-0 invalid-input">
                                                    {{ $errors->first('question') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ translation('Answer') }}</label>
                                            <textarea class="form-control" name="answer" placeholder="{{ translation('Enter Answer') }}" rows="5">{{ $item->translation('answer', $lang) }}</textarea>
                                            @if ($errors->has('answer'))
                                                <div class="error text-danger mb-0 invalid-input">
                                                    {{ $errors->first('answer') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit"
                                        class="btn btn-primary create-new-item-item-btn">{{ translation('Save Changes') }}</button>
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
