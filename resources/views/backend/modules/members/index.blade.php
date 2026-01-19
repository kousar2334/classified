@extends('backend.layouts.dashboard_layout')
@section('title')
    {{ translate('Members') }}
@endsection
@section('page-style')
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/daterangepicker/daterangepicker.css') }}">
@endsection
@section('page-content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-30">
                <div class="align-items-center bg-white card-header d-sm-flex justify-content-between py-2">
                    <h4 class="font-20">{{ translate('Members') }}</h4>
                    <button class="btn long" data-toggle="modal"
                        data-target="#new-member-modal">{{ translate('Add New Member') }}
                    </button>
                </div>
                <div class="card-body">

                    <div class="px-2 filter-area d-flex align-items-center">
                        <form method="get" action="{{ route('plugin.classilookscore.members.list') }}">
                            <select class="form-control mb-10" name="per_page">
                                <option value="">{{ translate('Per page') }}</option>
                                <option value="20" @selected(request()->has('per_page') && request()->get('per_page') == '20')>20</option>
                                <option value="50" @selected(request()->has('per_page') && request()->get('per_page') == '50')>50</option>
                                <option value="all" @selected(request()->has('per_page') && request()->get('per_page') == 'all')>All</option>
                            </select>
                            <select class="form-control mb-10" name="status">
                                <option value="">{{ translate('Status') }}</option>
                                <option value="{{ config('settings.general_status.active') }}" @selected(request()->has('status') && request()->get('status') == config('settings.general_status.active'))>
                                    {{ translate('Active') }}</option>
                                <option value="{{ config('settings.general_status.in_active') }}"
                                    @selected(request()->has('status') && request()->get('status') == config('settings.general_status.in_active'))>
                                    {{ translate('Inactive') }}</option>
                            </select>
                            <input type="text" class="form-control mb-10" id="joinDateRange"
                                placeholder="Filter by join date" name="join_date" readonly>
                            <input type="text" name="search" class="form-control mb-10"
                                value="{{ request()->has('search') ? request()->get('search') : '' }}"
                                placeholder="Enter name, email, phone, uid">
                            <button type="submit" class="btn long mb-1">{{ translate('Filter') }}</button>
                        </form>
                        @if (auth()->user()->can('Create Members'))
                            <a class="btn btn-danger long mb-2"
                                href="{{ route('plugin.classilookscore.members.list') }}">{{ translate('Clear Filter') }}
                            </a>
                        @endif

                    </div>
                    <div class="table-responsive">
                        <table id="memberTable" class="table table-hover text-nowrap table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>{{ translate('Image') }}</th>
                                    <th>{{ translate('Name') }}</th>
                                    <th>{{ translate('Email') }}</th>
                                    <th>{{ translate('Email Verified') }}</th>
                                    <th>{{ translate('Phone') }}</th>
                                    <th>{{ translate('No. of Ads') }}</th>
                                    <th>{{ translate('Status') }}</th>
                                    <th class="text-center">{{ translate('Actions') }}</th>
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
                                                <img src="{{ asset(getFilePath($member->image, true)) }}" class="img-45"
                                                    alt="{{ $member->name }}">
                                            </td>
                                            <td>
                                                {{ $member->name }}
                                            </td>
                                            <td>{{ $member->email }}</td>
                                            <td>
                                                @if ($member->email_verified_at != null)
                                                    {{ $member->email_verified_at->format('d M Y') }}
                                                @else
                                                    <p class="badge badge-danger">{{ translate('Not Verified') }}</p>
                                                @endif
                                            </td>
                                            <td>{{ $member->phone }}</td>
                                            <td>{{ $member->ads->count() }}</td>
                                            <td>
                                                @if ($member->status == config('settings.general_status.active'))
                                                    <p class="badge badge-success">{{ translate('Active') }}</p>
                                                @else
                                                    <p class="badge badge-danger">{{ translate('Inactive') }}</p>
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
                                                        @if (auth()->user()->can('Edit Members'))
                                                            <a href="#" data-id="{{ $member->id }}"
                                                                class="edit-member-btn">
                                                                {{ translate('Edit') }}
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->can('Edit Members'))
                                                            <a href="#" data-id="{{ $member->id }}"
                                                                class="member-reset-password">
                                                                {{ translate('Reset Password') }}
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->can('Delete Members'))
                                                            <a href="#" class="delete-member"
                                                                data-member="{{ $member->id }}">{{ translate('Delete member') }}
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
                                            <p class="alert alert-danger text-center">{{ translate('Nothing Found') }}</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="pgination px-3">
                            {!! $members->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5-custom') !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--Edit member Modal-->
    <div id="new-member-modal" class="new-member-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title bold h6">{{ translate('member information') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="new-member-form">
                            <div class="form-row mb-20">
                                <label class="black font-14 col-12">{{ translate('Image') }}</label>
                                @include('core::base.includes.media.media_input', [
                                    'input' => 'image',
                                    'data' => '',
                                ])

                            </div>

                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label class="black font-14">{{ translate('Name') }}</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="{{ translate('Enter Name') }}">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="black font-14">{{ translate('Email') }}</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="{{ translate('Enter Email') }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label class="black font-14">{{ translate('Phone') }}</label>
                                    <input type="text" name="phone" class="form-control"
                                        placeholder="{{ translate('Enter Phone') }}">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="black font-14">{{ translate('Status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="{{ config('settings.general_status.active') }}">
                                            {{ translate('Active') }}
                                        </option>
                                        <option value="{{ config('settings.general_status.in_active') }}">
                                            {{ translate('Inactive') }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>{{ translate('New password') }}</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="{{ translate('Enter new password') }}">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ translate('Confirm password') }}</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="{{ translate('Confirm password') }}">
                                </div>
                            </div>
                            <div class="btn-area d-flex justify-content-between">
                                <button class="btn long mt-2 store-member">{{ translate('Save') }}</button>
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
                    <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to delete this member') }}?</p>
                    <form method="POST" action="{{ route('plugin.classilookscore.members.delete') }}">
                        @csrf
                        <input type="hidden" id="delete-member-id" name="id">
                        <div class="form-row d-flex justify-content-between">
                            <button type="button" class="btn long mt-2 btn-danger"
                                data-dismiss="modal">{{ translate('cancel') }}</button>
                            <button type="submit" class="btn long mt-2">{{ translate('Delete') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Delete Modal-->
    <!--Reset password modal Modal-->
    <div id="reset-password-modal" class="reset-password-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title bold h6">{{ translate('Reset Password') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <form id="reset-passwork-form">
                        <div class="form-row mb-20">
                            <label>{{ translate('New password') }}</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="{{ translate('Enter new password') }}">
                        </div>
                        <div class="form-row mb-20">
                            <label>{{ translate('Confirm password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="{{ translate('Confirm password') }}">
                        </div>
                        <input type="hidden" id="reset-password-member-id" name="id">
                        <div class="btn-area d-flex justify-content-between">
                            <button type="button" class="btn long mt-2 btn-danger"
                                data-dismiss="modal">{{ translate('cancel') }}</button>
                            <button class="btn long mt-2 reset-password-btn">{{ translate('Submit') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Reset password modal-->
    <!--Edit member Modal-->
    <div id="edit-cutomer-modal" class="edit-cutomer-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title bold h6">{{ translate('member information') }}</h4>
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
    <!--End member modal-->
    @include('core::base.media.partial.media_modal')
@endsection
@section('page-script')
    <script src="{{ asset('/public/web-assets/backend/plugins/moment/moment.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('/public/web-assets/backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone()
            $(document).ready(function() {
                is_for_browse_file = true
                filtermedia()
            });
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
                $(document).find('.invalid-input').remove();
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#reset-passwork-form").serialize(),
                    url: '{{ route('plugin.classilookscore.members.password.reset') }}',
                    success: function(response) {
                        if (response.success) {
                            $("#reset-password-modal").modal('hide');
                            $(document).find('[name=password]').val('');
                            $(document).find('[name=password_confirmation').val('');
                            toastr.success('{{ translate('Password updated successfully') }}');
                        } else {
                            toastr.error('{{ translate('Update Failed ') }}');
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            $.each(response.responseJSON.errors, function(field_name, error) {
                                $(document).find('[name=' + field_name + ']').closest(
                                    '.form-control').after(
                                    '<div class="invalid-input d-flex">' + error +
                                    '</div>')
                            })
                        } else {
                            toastr.error('{{ translate('Update Failed ') }}');
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
                    url: '{{ route('plugin.classilookscore.members.edit') }}',
                    success: function(response) {
                        if (response.success) {
                            $('.member-edit-form').html(response.data);
                            $("#edit-cutomer-modal").modal('show');
                        } else {
                            toastr.error('{{ translate('Member not found') }}');
                        }
                    },
                    error: function(error) {
                        toastr.error('{{ translate('Member not found') }}');
                    }
                });
            });
            /**
             * Update member
             *
             **/
            $(document).on('click', '.update-member', function(e) {
                $(document).find('.invalid-input').remove();
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#member-update-form").serialize(),
                    url: '{{ route('plugin.classilookscore.members.update') }}',
                    success: function(response) {
                        if (response.success) {
                            $("#edit-cutomer-modal").modal('hide');
                            toastr.success('{{ translate('Member updated successfully') }}');
                            location.reload();
                        } else {
                            toastr.error('{{ translate('Member Update Failed') }}');
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            $.each(response.responseJSON.errors, function(field_name, error) {
                                $(document).find('[name=' + field_name + ']').closest(
                                    '.form-control').after(
                                    '<div class="invalid-input d-flex">' + error +
                                    '</div>')
                            })
                        } else {
                            toastr.error('{{ translate('Member Update Failed') }}');
                        }
                    }
                });
            });

            //Store new member
            $('.store-member').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#new-member-form").serialize(),
                    url: '{{ route('plugin.classilookscore.members.store') }}',
                    success: function(response) {
                        if (response.success) {
                            $("#new-member-modal").modal('hide');
                            toastr.success('{{ translate('Member Created successfully') }}');
                            location.reload();
                        } else {
                            toastr.error('{{ translate('Member Create Failed') }}');
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            $.each(response.responseJSON.errors, function(field_name, error) {
                                $(document).find('[name=' + field_name + ']').closest(
                                    '.form-control').after(
                                    '<div class="invalid-input d-flex">' + error +
                                    '</div>')
                            })
                        } else {
                            toastr.error('{{ translate('Member Create Failed') }}');
                        }
                    }
                });
            });
            //Join date filter
            function cb(start, end) {
                let initVal = '{{ request()->has('join_date') ? request()->get('join_date') : '' }}';
                $('#joinDateRange').val(initVal);
            }
            var start = moment().subtract(0, 'days');
            var end = moment();
            $('#joinDateRange').on('apply.daterangepicker', function(ev, picker) {
                let val = picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format(
                    'YYYY-MM-DD')
                $('#joinDateRange').val(val);
            });
            $('#joinDateRange').daterangepicker({
                startDate: start,
                endDate: end,
                showCustomRangeLabel: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);
            cb(start, end);

        })(jQuery);
    </script>
@endsection
