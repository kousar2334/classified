@php
    $links = [
        [
            'title' => 'Ad Listings',
            'route' => 'classified.ads.list',
            'active' => false,
        ],
        [
            'title' => 'Featured Ad Listings',
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    Featured Ad Listings
@endsection
@section('page-style')
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/public/web-assets/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('page-content')
    <x-admin-page-header title="Featured Ad Listings" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation(' Featured Ad Listings') }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ translation('#') }}</th>
                                        <th>{{ translation('Image') }}</th>
                                        <th>{{ translation('Title') }}</th>
                                        <th>{{ translation('Category') }}</th>
                                        <th>{{ translation('Member') }}</th>
                                        <th>{{ translation('Location') }}</th>
                                        <th>{{ translation('Price') }}</th>
                                        <th>{{ translation('Post Date') }}</th>
                                        <th>{{ translation('Status') }}</th>
                                        <th class="text-right">{{ translation('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ads as $key=> $ad)
                                        <tr>
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                <img src="{{ asset(getFilePath($ad->thumbnail_image, true, '240x160')) }}"
                                                    class="img-md" alt="{{ $ad->title }}">
                                            </td>
                                            <td>
                                                <span class="ad-title">{{ $ad->title }}</span>
                                            </td>
                                            <td>{{ $ad->categoryInfo?->title }}</td>
                                            <td>
                                                {{ $ad->userInfo?->name }}
                                            </td>
                                            <td>
                                                {{ $ad->location() }}
                                            </td>
                                            <td>{{ $ad->price }}</td>
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
                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn btn-default">{{ translation('Action') }}
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-default dropdown-toggle dropdown-hover dropdown-icon"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <button class="dropdown-item edit-item">
                                                            {{ translation('Edit') }}
                                                        </button>
                                                        <div class="dropdown-divider"></div>
                                                        <button class="dropdown-item delete-item"
                                                            data-id="{{ $ad->id }}">
                                                            {{ translation('Delete') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="10">
                                                <div class="text-center">{{ translation('No item found') }}</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @if ($ads->hasPages())
                                <div class="p-3">
                                    {{ $ads->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Modal-->
        <div class="modal fade" id="user-delete-modal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title h6">{{ translation('Delete Confirmation') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h4 class="mt-1 h6 my-2">{{ translation('Are you sure to delete ?') }}</h4>
                        <form method="POST" action="{{ route('classified.ads.categories.delete') }}">
                            @csrf
                            <input type="hidden" id="delete-item-id" name="id">
                            <button type="button" class="btn mt-2 btn-danger"
                                data-dismiss="modal">{{ translation('Cancel') }}</button>
                            <button type="submit" class="btn btn-success mt-2">{{ translation('Delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End  Delete Modal-->
    </section>
@endsection
@section('page-script')
    <script src="{{ asset('/public/web-assets/backend/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initMediaManager();
            initParentSelect();
            //Visible user delete modal
            $('.delete-item').on('click', function(e) {
                e.preventDefault();
                let user_id = $(this).data('id');
                $('#delete-item-id').val(user_id);
                $('#user-delete-modal').modal('show');
            });

            function initParentSelect() {
                $('.parent-options').select2({
                    theme: "bootstrap4",
                    placeholder: '{{ translation('Select parent category') }}',
                    closeOnSelect: true,
                    width: '100%',
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
            }
        })(jQuery);
    </script>
@endsection
