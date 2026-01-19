@extends('backend.layouts.dashboard_layout')
@section('title')
    {{ translate('Tags') }}
@endsection
@section('page-content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-30">
                <div class="align-items-center bg-white card-header d-sm-flex justify-content-between py-2">
                    <h4 class="font-20">{{ translate('Tags') }}</h4>
                    @if (auth()->user()->can('Create Tags'))
                        <button class="btn long" data-toggle="modal"
                            data-target="#new-tag-modal">{{ translate('Add New Tag') }}
                        </button>
                    @endif
                </div>
                <div class="card-body">

                    <div class="px-2 filter-area d-flex align-items-center">
                        <!--Bulk actions-->
                        <select class="form-control bulk-action-selection mb-2">
                            <option value="null">{{ translate('Bulk Action') }}</option>
                            <option value="delete_all">{{ translate('Delete selection') }}</option>
                        </select>
                        <button class="btn long btn-warning fire-bulk-action mb-2">{{ translate('Apply') }}
                        </button>
                        <!--End bulk actions-->

                        <form method="get" action="{{ route('classified.ads.tag.list') }}">
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
                            <input type="text" name="search" class="form-control mb-10"
                                value="{{ request()->has('search') ? request()->get('search') : '' }}"
                                placeholder="Enter title">
                            <button type="submit" class="btn long mb-1">{{ translate('Filter') }}</button>
                        </form>
                        <a class="btn btn-danger long mb-2"
                            href="{{ route('classified.ads.tag.list') }}">{{ translate('Clear Filter') }}</a>


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
                                    <th class="text-center">{{ translate('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tags->count() > 0)
                                    @foreach ($tags as $key => $tag)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center mb-3">
                                                    <label class="position-relative mr-2">
                                                        <input type="checkbox" name="item_id[]" class="item-id"
                                                            value="{{ $tag->id }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $tag->title }}
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
                                                        @if (auth()->user()->can('Edit Tags'))
                                                            <a href="#" class="edit-tag"
                                                                data-id="{{ $tag->id }}"
                                                                data-title="{{ $tag->title }}">{{ translate('Edit') }}
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->can('Delete Tags'))
                                                            <a href="#" class="delete-tag"
                                                                data-tag="{{ $tag->id }}">{{ translate('Delete') }}
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
                            {!! $tags->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5-custom') !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--Tag adding Modal-->
    <div id="new-tag-modal" class="new-tag-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title bold h6">{{ translate('Tag information') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="new-tag-form">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="black font-14">{{ translate('Tags') }}</label>
                                    <textarea name="tags" class="form-control" required></textarea>
                                    <span class="fz-14">Enter the tags separated by commas ,</span>
                                </div>
                            </div>
                            <div class="btn-area d-flex justify-content-between">
                                <button class="btn long mt-2 store-tag">{{ translate('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Tag adding modal-->
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
                    <p class="mt-1">{{ translate('Are you sure to delete this tag') }}?</p>
                    <form method="POST" action="{{ route('classified.ads.tag.delete') }}">
                        @csrf
                        <input type="hidden" id="delete-tag-id" name="id">
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
    <!--Tag Edit Modal-->
    <div id="tag-edit-modal" class="tag-edit-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title bold h6">{{ translate('Tag information') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="tag-edit-form">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="black font-14">{{ translate('Title') }}</label>
                                    <input type="hidden" id="edit-tag-id" name="id">
                                    <input type="text" id="edit-tag-title" name="title" class="form-control">
                                </div>
                            </div>
                            <div class="btn-area d-flex justify-content-between">
                                <button class="btn long mt-2 update-tag">{{ translate('Save Change') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Tag Edit modal-->
@endsection
@section('page-script')
    <script src="{{ asset('/public/web-assets/backend/plugins/moment/moment.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('/public/web-assets/backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone();
            /**
             * Store New Tag
             *
             **/
            $(document).on('click', '.store-tag', function(e) {
                $(document).find('.invalid-input').remove();
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#new-tag-form").serialize(),
                    url: '{{ route('classified.ads.tag.store') }}',
                    success: function(response) {
                        if (response.success) {
                            toastr.success('{{ translate('Tags created successfully') }}');
                            location.reload();
                        } else {
                            toastr.error('{{ translate('Tags create failed') }}');
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
                            toastr.error('{{ translate('Tags create failed') }}');
                        }
                    }
                });
            });
            /**
             *
             * Visible delete modal
             *
             * */
            $('.delete-tag').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('tag');
                $('#delete-tag-id').val(id);
                $("#delete-modal").modal("show");
            });

            /**
             *Load edit tag modal
             *
             **/
            $('.edit-tag').on('click', function(e) {
                e.preventDefault();
                $(document).find('.invalid-input').remove();
                let id = $(this).data('id');
                let title = $(this).data('title');
                $("#edit-tag-id").val(id);
                $("#edit-tag-title").val(title);
                $("#tag-edit-modal").modal("show");
            });
            /**
             * Update tag
             *
             **/
            $(document).on('click', '.update-tag', function(e) {
                $(document).find('.invalid-input').remove();
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#tag-edit-form").serialize(),
                    url: '{{ route('classified.ads.tag.update') }}',
                    success: function(response) {
                        if (response.success) {
                            $("#tag-edit-modal").modal('hide');
                            toastr.success('{{ translate('Tag updated successfully') }}');
                            location.reload();
                        } else {
                            toastr.error('{{ translate('Tag Update Failed') }}');
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
                            toastr.error('{{ translate('Tag Update Failed') }}');
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
                        $.post('{{ route('classified.ads.tag.bulk.action') }}', {
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
