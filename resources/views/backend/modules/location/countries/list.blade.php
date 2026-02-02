@php
    $links = [
        [
            'title' => 'Locations',
            'route' => '',
            'active' => true,
        ],
        [
            'title' => 'Countries',
            'route' => route('classified.locations.country.list'),
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')

@section('page-title')
    Countries
@endsection
@section('page-content')
    <x-admin-page-header title="Countries" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Countries') }}</h3>
                            <button class="btn btn-success btn-sm float-right text-white" data-toggle="modal"
                                data-target="#create-item-modal">{{ translation('Create New Country') }}
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ translation('#') }}</th>
                                        <th>{{ translation('Name') }}</th>
                                        <th>{{ translation('Code') }}</th>
                                        <th>{{ translation('Status') }}</th>
                                        <th>{{ translation('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($countries as $key=> $country)
                                        <tr>
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>{{ $country->name }}</td>
                                            <td class="text-uppercase">{{ $country->code }}</td>
                                            <td>
                                                @if ($country->status == config('settings.general_status.active'))
                                                    <span class="badge badge-success">{{ translation('Active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ translation('Inactive') }}</span>
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
                                                        <button class="dropdown-item edit-item"
                                                            data-id="{{ $country->id }}">
                                                            {{ translation('Edit') }}
                                                        </button>
                                                        <div class="dropdown-divider"></div>
                                                        <button class="dropdown-item delete-item"
                                                            data-id="{{ $country->id }}">
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
                            @if ($countries->hasPages())
                                <div class="p-3">
                                    {{ $countries->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--New  Modal-->
        <div class="modal fade" id="create-item-modal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ translation('New Country') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="new-country-form">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="black font-14">{{ translation('Name') }}</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="{{ translation('Enter Name') }}">
                                </div>

                                <div class="form-group col-lg-12">
                                    <label class="black font-14">{{ translation('Country Code') }}</label>
                                    <input type="text" name="code" class="form-control"
                                        placeholder="{{ translation('Enter Country Code') }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="black font-14">{{ translation('Status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="{{ config('settings.general_status.active') }}">
                                            {{ translation('Active') }}
                                        </option>
                                        <option value="{{ config('settings.general_status.in_active') }}">
                                            {{ translation('Inactive') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="btn-area d-flex justify-content-between">
                                <button class="btn btn-primary mt-2 store-country">{{ translation('Save') }}</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!--End New  Modal-->
        <!-- Edit Modal-->
        <div class="modal fade" id="edit-item-modal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ translation('Country Information') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body item-edit-content">

                    </div>
                </div>
            </div>
        </div>
        <!--End  Edit Modal-->
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
                        <form method="POST" action="{{ route('classified.locations.country.delete') }}">
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

            //Create new 
            $('#new-country-form').submit(function(e) {
                e.preventDefault();
                $(document).find(".invalid-input").remove();
                $(document).find(".form-control").removeClass('is-invalid');
                var formData = new FormData(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: formData,
                    url: '{{ route('classified.locations.country.store') }}',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('New country added successfully', 'Success');
                            location.reload();

                        } else {
                            toastr.error(response.message, 'Error')
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            $.each(response.responseJSON.errors, function(field_name,
                                error) {
                                $(document).find('[name=' + field_name + ']')
                                    .addClass('is-invalid');
                                $(document).find('[name=' + field_name + ']')
                                    .after(
                                        '<div class="error text-danger mb-0 invalid-input">' +
                                        error + '</div>');
                            })
                        } else {
                            toastr.error('country add failed', 'Error')
                        }
                    }
                });
            });

            //Visible user edit modal
            $('.edit-item').on('click', function(e) {
                e.preventDefault();
                let country_id = $(this).data('id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('classified.locations.country.edit') }}',
                    data: {
                        id: country_id
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.item-edit-content').html(response.html);
                            $('#edit-item-modal').modal('show');
                            initParentSelect();
                        } else {
                            toastr.error('country fetch failed', 'Error')
                        }
                    },
                    error: function(response) {
                        toastr.error('country fetch failed', 'Error')
                    }
                });
            });


            //update country
            $(document).on('submit', '#editForm', function(e) {
                e.preventDefault();
                $(document).find(".invalid-input").remove();
                $(document).find(".form-control").removeClass('is-invalid');
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    data: formData,
                    url: '{{ route('classified.locations.country.update') }}',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Country updated successfully', 'Success');
                            location.reload();
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            $.each(response.responseJSON.errors, function(field_name,
                                error) {
                                $(document).find('[name=' + field_name + ']')
                                    .addClass('is-invalid');
                                $(document).find('[name=' + field_name + ']')
                                    .after(
                                        '<div class="error text-danger mb-0 invalid-input">' +
                                        error + '</div>');
                            })
                        } else {
                            toastr.error('country update failed', 'Error')
                        }
                    }
                });
            });


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
                    placeholder: '{{ translation('Select parent country') }}',
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
