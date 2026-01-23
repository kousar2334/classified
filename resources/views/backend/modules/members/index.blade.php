@php
    $links = [
        [
            'title' => 'Members',
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    Members
@endsection
@section('page-style')
@endsection
@section('page-content')
    <x-admin-page-header title="Members" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Members') }}</h3>
                            <button class="btn btn-success btn-sm float-right text-white" data-toggle="modal"
                                data-target="#new-member-modal">{{ translation('Add New Member') }}</button>
                        </div>
                        <div class="card-body">
                            <div class="filter-area mb-3">
                                <form method="get" action="{{ route('admin.members.list') }}"
                                    class="d-flex align-items-center gap-10">
                                    <select class="form-control mb-10" name="per_page">
                                        <option value="">{{ translation('Per page') }}</option>
                                        <option value="20" @selected(request()->has('per_page') && request()->get('per_page') == '20')>20</option>
                                        <option value="50" @selected(request()->has('per_page') && request()->get('per_page') == '50')>50</option>
                                        <option value="all" @selected(request()->has('per_page') && request()->get('per_page') == 'all')>All</option>
                                    </select>
                                    <select class="form-control mb-10" name="status">
                                        <option value="">{{ translation('Status') }}</option>
                                        <option value="{{ config('settings.general_status.active') }}"
                                            @selected(request()->has('status') && request()->get('status') == config('settings.general_status.active'))>
                                            {{ translation('Active') }}</option>
                                        <option value="{{ config('settings.general_status.in_active') }}"
                                            @selected(request()->has('status') && request()->get('status') == config('settings.general_status.in_active'))>
                                            {{ translation('Inactive') }}</option>
                                    </select>

                                    <input type="text" name="search" class="form-control mb-10"
                                        value="{{ request()->has('search') ? request()->get('search') : '' }}"
                                        placeholder="Enter name, email, phone, uid">
                                    <button type="submit" class="btn btn-primary">{{ translation('Filter') }}</button>

                                    @if (request()->has('per_page') || request()->has('status') || request()->has('search'))
                                        <a class="btn btn-danger"
                                            href="{{ route('admin.members.list') }}">{{ translation('Clear Filter') }}
                                        </a>
                                    @endif
                                </form>


                            </div>
                            <div class="table-responsive">
                                <table id="memberTable" class="table table-hover text-nowrap table-bordered">
                                    <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>{{ translation('Image') }}</th>
                                            <th>{{ translation('Name') }}</th>
                                            <th>{{ translation('Email') }}</th>
                                            <th>{{ translation('Email Verified') }}</th>
                                            <th>{{ translation('Phone') }}</th>
                                            <th>{{ translation('No. of Ads') }}</th>
                                            <th>{{ translation('Status') }}</th>
                                            <th class="text-center">{{ translation('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($members->count() > 0)
                                            @foreach ($members as $key => $member)
                                                <tr>
                                                    <td>
                                                        {{ $member->uid }}
                                                    </td>
                                                    <td>
                                                        <img src="{{ asset(getFilePath($member->image, true)) }}"
                                                            class="img-md rounded" alt="{{ $member->name }}">
                                                    </td>
                                                    <td>
                                                        {{ $member->name }}
                                                    </td>
                                                    <td>{{ $member->email }}</td>
                                                    <td>
                                                        @if ($member->email_verified_at != null)
                                                            {{ $member->email_verified_at->format('d M Y') }}
                                                        @else
                                                            <p class="badge badge-danger">{{ translation('Not Verified') }}
                                                            </p>
                                                        @endif
                                                    </td>
                                                    <td>{{ $member->phone }}</td>
                                                    <td>{{ $member->ads->count() }}</td>
                                                    <td>
                                                        @if ($member->status == config('settings.general_status.active'))
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
                                                                <button class="dropdown-item edit-member-btn"
                                                                    data-id="{{ $member->id }}">
                                                                    {{ translation('Edit') }}
                                                                </button>
                                                                <div class="dropdown-divider"></div>
                                                                <button class="dropdown-item member-reset-password"
                                                                    data-id="{{ $member->id }}">
                                                                    {{ translation('Reset Password') }}
                                                                </button>
                                                                <div class="dropdown-divider"></div>
                                                                <button class="dropdown-item delete-member"
                                                                    data-member="{{ $member->id }}">
                                                                    {{ translation('Delete') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9">
                                                    <p class="alert alert-danger text-center">
                                                        {{ translation('Nothing Found') }}
                                                    </p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                @if ($members->hasPages())
                                    <div class="pgination px-3">
                                        {!! $members->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5-custom') !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--New member Modal-->
    <div id="new-member-modal" class="new-member-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title bold h6">{{ translation('Member information') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="new-member-form">
                            <div class="form-row mb-20">
                                <label class="black font-14 col-12">{{ translation('Image') }}</label>
                                <x-media name="image"></x-media>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label class="black font-14">{{ translation('Name') }}</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="{{ translation('Enter Name') }}">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="black font-14">{{ translation('Email') }}</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="{{ translation('Enter Email') }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label class="black font-14">{{ translation('Phone') }}</label>
                                    <input type="text" name="phone" class="form-control"
                                        placeholder="{{ translation('Enter Phone') }}">
                                </div>
                                <div class="form-group col-lg-6">
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

                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>{{ translation('New password') }}</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="{{ translation('Enter new password') }}">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ translation('Confirm password') }}</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="{{ translation('Confirm password') }}">
                                </div>
                            </div>
                            <div class="btn-area d-flex justify-content-between">
                                <button class="btn mt-2 btn-primary store-member">{{ translation('Save') }}</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End member modal-->
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
                    <p class="mt-1">{{ translation('Are you sure to delete this member') }}?</p>
                    <form method="POST" action="{{ route('admin.members.delete') }}">
                        @csrf
                        <input type="hidden" id="delete-member-id" name="id">
                        <div class="form-row d-flex justify-content-between">
                            <button type="button" class="btn mt-2 btn-primary"
                                data-dismiss="modal">{{ translation('cancel') }}</button>
                            <button type="submit" class="btn btn-danger mt-2">{{ translation('Delete') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Delete Modal-->
    <!--Reset password modal Modal-->
    <div id="reset-password-modal" class="reset-password-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-md ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title bold h6">{{ translation('Reset Password') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <form id="reset-passwork-form">
                        <div class="form-row mb-2">
                            <label>{{ translation('New password') }}</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="{{ translation('Enter new password') }}">
                        </div>
                        <div class="form-row mb-2">
                            <label>{{ translation('Confirm password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="{{ translation('Confirm password') }}">
                        </div>
                        <input type="hidden" id="reset-password-member-id" name="id">
                        <div class="form-row mt-3 justify-content-between">
                            <button type="button" class="btn btn-danger"
                                data-dismiss="modal">{{ translation('cancel') }}</button>
                            <button class="btn btn-primary reset-password-btn">{{ translation('Submit') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Reset password modal-->
    <!--Edit member Modal-->
    <div id="edit-member-modal" class="edit-member-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title bold h6">{{ translation('Member information') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body member-edit-form">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        (function($) {
            "use strict";
            initMediaManager();

            /**
             *
             * delete member
             *
             * */
            $('.delete-member').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('member');
                $('#delete-member-id').val(id);
                $("#delete-modal").modal("show");
            });

            /**
             * Reset password
             *
             **/
            $('.member-reset-password').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $("#reset-password-member-id").val(id);
                $("#reset-password-modal").modal('show');
            });
            /**
             * Submit reset password form
             *
             **/
            $(".reset-password-btn").on('click', function(e) {
                $(document).find('.invalid-feedback').remove();
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#reset-passwork-form").serialize(),
                    url: '{{ route('admin.members.password.reset') }}',
                    success: function(response) {
                        if (response.success) {
                            $("#reset-password-modal").modal('hide');
                            $(document).find('[name=password]').val('');
                            $(document).find('[name=password_confirmation').val('');
                            toastr.success('{{ translation('Password updated successfully') }}');
                        } else {
                            toastr.error('{{ translation('Update Failed ') }}');
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            $.each(response.responseJSON.errors, function(field_name, error) {
                                $(document).find('[name=' + field_name + ']').closest(
                                    '.form-control').after(
                                    '<div class="d-flex invalid-feedback text-danger">' +
                                    error +
                                    '</div>')
                            })
                        } else {
                            toastr.error('{{ translation('Update Failed ') }}');
                        }
                    }
                });
            });
            /**
             *Load edit member modal
             *
             **/
            $('.edit-member-btn').on('click', function(e) {
                e.preventDefault();
                $('.member-edit-form').html('');
                let id = $(this).data('id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: {
                        id: id
                    },
                    url: '{{ route('admin.members.edit') }}',
                    success: function(response) {
                        if (response.success) {
                            $('.member-edit-form').html(response.data);
                            $("#edit-member-modal").modal('show');
                        } else {
                            toastr.error('{{ translation('Member not found') }}');
                        }
                    },
                    error: function(error) {
                        toastr.error('{{ translation('Member not found') }}');
                    }
                });
            });
            /**
             * Update member
             *
             **/
            $(document).on('click', '.update-member', function(e) {
                $(document).find('.invalid-feedback').remove();
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#member-update-form").serialize(),
                    url: '{{ route('admin.members.update') }}',
                    success: function(response) {
                        if (response.success) {
                            $("#edit-member-modal").modal('hide');
                            toastr.success('{{ translation('Member updated successfully') }}');
                            location.reload();
                        } else {
                            toastr.error('{{ translation('Member Update Failed') }}');
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            $.each(response.responseJSON.errors, function(field_name, error) {
                                $(document).find('[name=' + field_name + ']').closest(
                                    '.form-control').after(
                                    '<div class="d-flex invalid-feedback text-danger">' +
                                    error +
                                    '</div>')
                            })
                        } else {
                            toastr.error('{{ translation('Member Update Failed') }}');
                        }
                    }
                });
            });

            //Store new member
            $('.store-member').on('click', function(e) {
                e.preventDefault();
                $(document).find('.invalid-feedback').remove();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#new-member-form").serialize(),
                    url: '{{ route('admin.members.store') }}',
                    success: function(response) {
                        if (response.success) {
                            $("#new-member-modal").modal('hide');
                            toastr.success('{{ translation('Member Created successfully') }}');
                            location.reload();
                        } else {
                            toastr.error('{{ translation('Member Create Failed') }}');
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            $.each(response.responseJSON.errors, function(field_name, error) {
                                $(document).find('[name=' + field_name + ']').closest(
                                    '.form-control').after(
                                    '<div class="d-flex invalid-feedback text-danger">' +
                                    error +
                                    '</div>')
                            })
                        } else {
                            toastr.error('{{ translation('Member Create Failed') }}');
                        }
                    }
                });
            });


        })(jQuery);
    </script>
@endsection
