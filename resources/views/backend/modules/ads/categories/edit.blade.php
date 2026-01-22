@php
    $links = [
        [
            'title' => 'Listing',
            'route' => 'classified.ads.list',
            'active' => false,
        ],
        [
            'title' => 'Listing Categories',
            'route' => 'classified.ads.categories.list',
            'active' => false,
        ],
        [
            'title' => 'Edit',
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    Edit Category
@endsection
@section('page-style')
@endsection
@section('page-content')
    <x-admin-page-header title="Edit Category" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Category') }}</h3>
                        </div>
                        <div class="card-body">

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
