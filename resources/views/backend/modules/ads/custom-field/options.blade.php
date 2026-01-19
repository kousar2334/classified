@extends('backend.layouts.dashboard_layout')
@section('title')
    {{ translate('Custom Field Options') }}
@endsection
@section('page-content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-30">
                <div class="align-items-center bg-white card-header d-sm-flex justify-content-between py-2">
                    <h4 class="font-20">{{ $field->translation('title') }} <i class="icofont-long-arrow-right"></i>
                        {{ translate('Options') }}</h4>
                    <button class="btn long" data-toggle="modal"
                        data-target="#new-option-modal">{{ translate('Add New Option') }}
                    </button>
                </div>
                <div class="card-body">
                    <div class="px-2 filter-area d-flex align-items-center">
                        <!--Bulk actions-->
                        <select class="form-control bulk-action-selection mb-2">
                            <option value="null">{{ translate('Bulk Action') }}</option>
                            <option value="delete_all">{{ translate('Delete selection') }}</option>
                            <option value="active">{{ translate('Active selection') }}</option>
                            <option value="in_active">{{ translate('Inactive selection') }}</option>
                        </select>
                        <button class="btn long btn-warning fire-bulk-action mb-2">{{ translate('Apply') }}
                        </button>
                        <!--End bulk actions-->
                        <form method="get"
                            action="{{ route('classified.ads.custom.field.options', ['id' => $field->id]) }}">
                            <select class="form-control mb-10" name="per_page">
                                <option value="">{{ translate('Per page') }}</option>
                                <option value="20" @selected(request()->has('per_page') && request()->get('per_page') == '20')>20</option>
                                <option value="50" @selected(request()->has('per_page') && request()->get('per_page') == '50')>50</option>
                                <option value="all" @selected(request()->has('per_page') && request()->get('per_page') == 'all')>All</option>
                            </select>
                            <select class="form-control mb-10" name="status">
                                <option value="">{{ translate('Status') }}</option>
                                <option value="{{ config('settings.general_status.active') }}"
                                    @selected(request()->has('status') && request()->get('status') == config('settings.general_status.active'))>
                                    {{ translate('Active') }}</option>
                                <option value="{{ config('settings.general_status.in_active') }}"
                                    @selected(request()->has('status') && request()->get('status') == config('settings.general_status.in_active'))>
                                    {{ translate('Inactive') }}</option>
                            </select>
                            <input type="text" name="search" class="form-control mb-10"
                                value="{{ request()->has('search') ? request()->get('search') : '' }}"
                                placeholder="Enter value">
                            <button type="submit" class="btn long mb-1">{{ translate('Filter') }}</button>
                        </form>
                        <a class="btn btn-danger long mb-2"
                            href="{{ route('classified.ads.custom.field.options', ['id' => $field->id]) }}">{{ translate('Clear Filter') }}</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="d-flex align-items-center">
                                            <label class="position-relative">
                                                <input type="checkbox" name="select_all" class="checked-all-items">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </th>
                                    <th>{{ translate('Value') }}</th>
                                    <th>{{ translate('Status') }}</th>
                                    <th class="text-center">{{ translate('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($options->count() > 0)
                                    @foreach ($options as $key => $option)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center mb-3">
                                                    <label class="position-relative mr-2">
                                                        <input type="checkbox" name="item_id[]" class="item-id"
                                                            value="{{ $option->id }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $option->translation('value') }}
                                            </td>
                                            <td>
                                                @if ($option->status == config('settings.general_status.active'))
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
                                                        <a
                                                            href="{{ route('classified.ads.custom.field.options.edit', ['id' => $option->id, 'lang' => getDefaultLang()]) }}">
                                                            {{ translate('Edit') }}
                                                        </a>
                                                        <a href="#" class="delete-option"
                                                            data-id="{{ $option->id }}">{{ translate('Delete') }}
                                                        </a>
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
                            {!! $options->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5-custom') !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--Option adding Modal-->
    <div id="new-option-modal" class="new-option-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title bold h6">{{ translate('Option information') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="new-Option-form">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="black font-14">{{ translate('Value') }}</label>
                                    <input type="text" name="value" class="form-control"
                                        placeholder="{{ translate('Enter value') }}">
                                    <input type="hidden" name="field" value="{{ $field->id }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-lg-12">
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
                            <div class="btn-area d-flex justify-content-between">
                                <button class="btn long mt-2 store-option">{{ translate('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Option adding modal-->
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
                    <p class="mt-1">{{ translate('Are you sure to delete this custom option') }}?</p>
                    <form method="POST" action="{{ route('classified.ads.custom.field.options.delete') }}">
                        @csrf
                        <input type="hidden" id="delete-id" name="id">
                        <input type="hidden" name="field_id" value="{{ $field->id }}">
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
@endsection
@section('page-script')
    <script>
        (function($) {
            "use strict";

            /**
             * Store New option 
             *
             **/
            $(document).on('click', '.store-option', function(e) {
                $(document).find('.invalid-input').remove();
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#new-Option-form").serialize(),
                    url: '{{ route('classified.ads.custom.field.options.store') }}',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('{{ translate('Option created successfully') }}');
                            location.reload();
                        } else {
                            toastr.error('{{ translate('Option create failed') }}');
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
                            toastr.error('{{ translate('Option create failed') }}');
                        }
                    }
                });
            });
            /**
             *
             * Visible delete modal
             *
             * */
            $('.delete-option').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#delete-id').val(id);
                $("#delete-modal").modal("show");
            });
            /**
             * 
             * Checked all items
             **/
            $('.checked-all-items').on('change', function(e) {
                if ($('.checked-all-items').is(":checked")) {
                    $(".item-id").prop("checked", true);
                } else {
                    $(".item-id").prop("checked", false);
                }
            });
            /**
             * 
             * Bulk action
             **/
            $('.fire-bulk-action').on('click', function(e) {
                let action = $('.bulk-action-selection').val();
                if (action != 'null') {
                    var selected_items = [];
                    $('input[name^="item_id"]:checked').each(function() {
                        selected_items.push($(this).val());
                    });
                    if (selected_items.length > 0) {
                        $.post('{{ route('classified.ads.custom.field.options.bulk.action') }}', {
                            _token: '{{ csrf_token() }}',
                            items: selected_items,
                            action: action
                        }, function(data) {
                            if (data.success) {
                                toastr.success('{{ translate('Action Applied Successfully') }}');
                                location.reload();
                            }
                            if (!data.success) {
                                toastr.error('{{ translate('Action Failed') }}');
                            }
                        })
                    } else {
                        toastr.error('{{ translate('No Item Selected') }}');
                    }
                } else {
                    toastr.error('{{ translate('No Action Selected') }}');
                }
            });

        })(jQuery);
    </script>
@endsection
