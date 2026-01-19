@extends('backend.layouts.dashboard_layout')
@section('title')
    {{ translate('Custom Fields') }}
@endsection
@section('page-style')
    <!--Select2-->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.css') }}">
    <style>
        .select2-container--classic {
            width: 100% !important;
        }
    </style>
@endsection
@section('page-content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-30">
                <div class="align-items-center bg-white card-header d-sm-flex justify-content-between py-2">
                    <h4 class="font-20">{{ translate('Custom Fields') }}</h4>
                    @if (auth()->user()->can('Create Custom Field'))
                        <button class="btn long" data-toggle="modal"
                            data-target="#new-field-modal">{{ translate('Add New Custom Field') }}
                        </button>
                    @endif
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
                        <form method="get" action="{{ route('classified.ads.custom.field.list') }}">
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
                                placeholder="Enter title">
                            <button type="submit" class="btn long mb-1">{{ translate('Filter') }}</button>
                        </form>
                        <a class="btn btn-danger long mb-2"
                            href="{{ route('classified.ads.custom.field.list') }}">{{ translate('Clear Filter') }}</a>
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
                                    <th>{{ translate('Title') }}</th>
                                    <th>{{ translate('Type') }}</th>
                                    <th>{{ translate('Category') }}</th>
                                    <th>{{ translate('Options') }}</th>
                                    <th>{{ translate('Is Required') }}</th>
                                    <th>{{ translate('Is Filterable') }}</th>
                                    <th>{{ translate('Status') }}</th>
                                    <th class="text-center">{{ translate('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($fields->count() > 0)
                                    @foreach ($fields as $key => $field)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center mb-3">
                                                    <label class="position-relative mr-2">
                                                        <input type="checkbox" name="item_id[]" class="item-id"
                                                            value="{{ $field->id }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $field->translation('title') }}
                                            </td>
                                            <td>
                                                {{ $field->get_type() }}
                                            </td>

                                            <td>
                                                @if ($field->category != null)
                                                    <a href="#" data-id="{{ $field->id }}"
                                                        class="attatch-category"><i class="icofont-wrench"></i>
                                                        {{ $field->category->translation('title') }}
                                                    </a>
                                                @else
                                                    @if (auth()->user()->can('Manage Custom Field'))
                                                        <a href="#" data-id="{{ $field->id }}"
                                                            class="attatch-category"><i class="icofont-plus-circle"></i>
                                                            {{ translate('Add to a category') }}
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if (auth()->user()->can('Manage Custom Field'))
                                                    @if ($field->has_options() == config('settings.general_status.active'))
                                                        <a
                                                            href="{{ route('classified.ads.custom.field.options', ['id' => $field->id]) }}">
                                                            <i class="icofont-ui-settings"></i>
                                                            {{ translate('Options') }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($field->is_required == config('settings.general_status.active'))
                                                    <p class="badge badge-success">{{ translate('Yes') }}</p>
                                                @else
                                                    <p class="badge badge-danger">{{ translate('No') }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($field->is_filterable == config('settings.general_status.active'))
                                                    <p class="badge badge-success">{{ translate('Yes') }}</p>
                                                @else
                                                    <p class="badge badge-danger">{{ translate('No') }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($field->status == config('settings.general_status.active'))
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
                                                        @if (auth()->user()->can('Edit Custom Field'))
                                                            <a
                                                                href="{{ route('classified.ads.custom.field.edit', ['id' => $field->id, 'lang' => getDefaultLang()]) }}">
                                                                {{ translate('Edit') }}
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->can('Delete Custom Field'))
                                                            <a href="#" class="delete-field"
                                                                data-id="{{ $field->id }}">{{ translate('Delete') }}
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
                            {!! $fields->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5-custom') !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--Field adding Modal-->
    <div id="new-field-modal" class="new-field-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title bold h6">{{ translate('Custom Field information') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="new-Field-form">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="black font-14">{{ translate('Type') }}</label>
                                    <select name="type" class="form-control text-capitalize">
                                        @foreach (config('settings.input_types') as $key => $value)
                                            <option value="{{ $value }}">
                                                {{ ucwords(str_replace('_', ' ', $key)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="black font-14">{{ translate('Title') }}</label>
                                    <input type="text" name="title" class="form-control slugable_input"
                                        placeholder="{{ translate('Enter title') }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="black font-14">{{ translate('Default Value') }}</label>
                                    <input type="text" name="default_value" class="form-control slugable_input"
                                        placeholder="{{ translate('Enter Default Value') }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="black font-14">{{ translate('Is Required ?') }}</label>
                                    <label class="switch glow primary medium">
                                        <input type="checkbox" name="is_required">
                                        <span class="control"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="black font-14">{{ translate('Is Filterable ?') }}</label>
                                    <label class="switch glow primary medium">
                                        <input type="checkbox" name="is_filterable">
                                        <span class="control"></span>
                                    </label>
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
                                <button class="btn long mt-2 store-field">{{ translate('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Field adding modal-->
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
                    <p class="mt-1">{{ translate('Are you sure to delete this custom field') }}?</p>
                    <form method="POST" action="{{ route('classified.ads.custom.field.delete') }}">
                        @csrf
                        <input type="hidden" id="delete-field-id" name="id">
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
    <!--Assign category-->
    <div id="category-modal" class="category-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Category') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="assign-category-form">
                        <input type="hidden" id="selected-field-id" name="id">
                        <div class="form-row">
                            <div class="form-group col-lg-12">
                                <label class="font-14 bold black w-100">{{ translate('Select category') }} </label>
                                <select class="category-options form-control w-100" name="category">
                                </select>
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-between">
                            <button class="btn long mt-2 assign-category">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Assign Category-->
@endsection
@section('page-script')
    <!--Select2-->
    <script src="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            /**
             * Category Options
             * 
             */
            $('.category-options').select2({
                theme: "classic",
                placeholder: '{{ translate('Select a category') }}',
                closeOnSelect: true,
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
            /**
             * Store New custom field
             *
             **/
            $(document).on('click', '.store-field', function(e) {
                $(document).find('.invalid-input').remove();
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#new-Field-form").serialize(),
                    url: '{{ route('classified.ads.custom.field.store') }}',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('{{ translate('Custom field created successfully') }}');
                            location.reload();
                        } else {
                            toastr.error('{{ translate('Custom field create failed') }}');
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
                            toastr.error('{{ translate('Custom field create failed') }}');
                        }
                    }
                });
            });
            /**
             *
             * Visible delete modal
             *
             * */
            $('.delete-field').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#delete-field-id').val(id);
                $("#delete-modal").modal("show");
            });

            //Open Category Modal
            $('.attatch-category').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $("#selected-field-id").val(id);
                $("#category-modal").modal("show");
            });

            //Assign category
            $(document).on('click', '.assign-category', function(e) {
                $(document).find('.invalid-input').remove();
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#assign-category-form").serialize(),
                    url: '{{ route('classified.ads.custom.field.assign.category') }}',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('{{ translate('Category  assigned successfully') }}');
                            location.reload();
                        } else {
                            toastr.error('{{ translate('Category  assign failed') }}');
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
                            toastr.error('{{ translate('Category  assign failed') }}');
                        }
                    }
                });
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
                        $.post('{{ route('classified.ads.custom.field.bulk.action') }}', {
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
