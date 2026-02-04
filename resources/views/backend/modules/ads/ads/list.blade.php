@extends('backend.layouts.dashboard_layout')
@section('title')
    {{ translation('Ads') }}
@endsection
@section('page-style')
    <!--Select2-->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.css') }}">

    <style>
        .select2-container--classic {
            width: 100% !important;
        }

        .ad-title {
            max-width: 200px;
            display: inline-block;
            font-weight: 600
        }

        .img-90-70 {
            min-width: 90px;
            width: 90px !important;
        }
    </style>
@endsection
@section('page-content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-30">
                <div class="bg-white card-header py-3">
                    <h4 class="font-20">{{ translation('Ads') }}</h4>
                </div>
                <div class="card-body">

                    <div class="px-2 filter-area d-flex align-items-center">
                        <form method="get" action="{{ route('classified.ads.list') }}">
                            <select class="form-control mb-10" name="per_page">
                                <option value="">{{ translation('Per page') }}</option>
                                <option value="20" @selected(request()->has('per_page') && request()->get('per_page') == '20')>20</option>
                                <option value="50" @selected(request()->has('per_page') && request()->get('per_page') == '50')>50</option>
                                <option value="all" @selected(request()->has('per_page') && request()->get('per_page') == 'all')>All</option>
                            </select>
                            <select class="form-control mb-10" name="status">
                                <option value="">{{ translation('Status') }}</option>
                                <option value="{{ config('settings.general_status.active') }}" @selected(request()->has('status') && request()->get('status') == config('settings.general_status.active'))>
                                    {{ translation('Active') }}</option>
                                <option value="{{ config('settings.general_status.in_active') }}"
                                    @selected(request()->has('status') && request()->get('status') == config('settings.general_status.in_active'))>
                                    {{ translation('Inactive') }}</option>
                            </select>
                            <select class="form-control mb-10" name="payment_status">
                                <option value="">{{ translation('Payment Status') }}</option>
                                <option value="{{ config('settings.general_status.active') }}"
                                    @selected(request()->has('payment_status') && request()->get('payment_status') == config('settings.general_status.active'))>
                                    {{ translation('Paid') }}
                                </option>
                                <option value="{{ config('settings.general_status.in_active') }}"
                                    @selected(request()->has('payment_status') && request()->get('payment_status') == config('settings.general_status.in_active'))>
                                    {{ translation('Pending') }}
                                </option>
                            </select>
                            <input type="text" name="search" class="form-control mb-10"
                                value="{{ request()->has('search') ? request()->get('search') : '' }}"
                                placeholder="Enter title">
                            <button type="submit" class="btn long mb-1">{{ translation('Filter') }}</button>
                        </form>
                        <a class="btn btn-danger long mb-2"
                            href="{{ route('classified.ads.list') }}">{{ translation('Clear Filter') }}</a>
                    </div>
                    <div class="table-responsive">
                        <table class="hoverable border-top2">
                            <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>{{ translation('Image') }}</th>
                                    <th>{{ translation('Name') }}</th>
                                    <th>{{ translation('Info') }}</th>
                                    <th>{{ translation('PayAble Amount') }}</th>
                                    <th>{{ translation('Payment Status') }}</th>
                                    <th>{{ translation('Post Date') }}</th>
                                    <th>{{ translation('Status') }}</th>
                                    <th class="text-center">{{ translation('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($ads->count() > 0)
                                    @foreach ($ads as $key => $ad)
                                        <tr>
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                <img src="{{ asset(getFilePath($ad->thumbnail_image, true, '240x160')) }}"
                                                    class="img-90-70" alt="{{ $ad->title }}">
                                            </td>
                                            <td>
                                                <span class="ad-title">{{ $ad->title }}</span>
                                            </td>
                                            <td>
                                                <p class="mb-0"><span
                                                        class="bold">{{ translation('Posted By :') }}</span>
                                                    {{ $ad->userInfo->name }}
                                                </p>
                                                <p class="mb-0"><span
                                                        class="bold">{{ translation('Category :') }}</span>
                                                    @if ($ad->categoryInfo != null)
                                                        {{ $ad->categoryInfo->translation('title') }}
                                                    @else
                                                        --
                                                    @endif
                                                </p>
                                                <p class="mb-0"><span class="bold">{{ translation('Price :') }}</span>
                                                    {{ $ad->price }}
                                                </p>
                                            </td>
                                            <td>
                                                @if ($ad->cost > 0)
                                                    @if ($ad->payment_status == config('settings.general_status.active'))
                                                        <p class="badge badge-success">{{ translation('Paid') }}</p>
                                                    @else
                                                        <p class="badge badge-danger">{{ translation('Pending') }}</p>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td>
                                                {{ $ad->created_at->format('d M Y') }}
                                            </td>

                                            <td>
                                                @if ($ad->status == config('settings.general_status.active'))
                                                    <p class="badge badge-success">{{ translation('Active') }}</p>
                                                @else
                                                    <p class="badge badge-danger">{{ translation('Inactive') }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex dropdown-button justify-content-center show">
                                                    <a href="#" class="d-flex align-items-center justify-content-end"
                                                        data-toggle="dropdown">
                                                        <div class="menu-icon mr-0">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </div>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if (auth()->user()->can('Edit All Ads'))
                                                            <a
                                                                href="{{ route('classified.ads.edit', ['id' => $ad->id, 'lang' => getDefaultLang()]) }}">
                                                                {{ translation('Edit') }}
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->can('Delete All Ads'))
                                                            <a href="#" class="delete-ad"
                                                                data-ad="{{ $ad->id }}">{{ translation('Delete') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9">
                                            <p class="alert alert-danger text-center">{{ translation('Nothing Found') }}
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="pgination px-3">
                            {!! $ads->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--Delete Modal-->
    <div id="delete-modal" class="delete-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translation('Delete Confirmation') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translation('Are you sure to delete this category') }}?</p>
                    <form method="POST" action="{{ route('classified.ads.delete') }}">
                        @csrf
                        <input type="hidden" id="delete-id" name="id">
                        <div class="form-row d-flex justify-content-between">
                            <button type="button" class="btn long mt-2 btn-danger"
                                data-dismiss="modal">{{ translation('cancel') }}</button>
                            <button type="submit" class="btn long mt-2">{{ translation('Delete') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Delete Modal-->

@endsection
@section('page-script')
    <!--Select2-->
    <script src="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone();
            /**
             *
             * Visible delete modal
             *
             * */
            $('.delete-ad').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('ad');
                $('#delete-id').val(id);
                $("#delete-modal").modal("show");
            });

        })(jQuery);
    </script>
@endsection
