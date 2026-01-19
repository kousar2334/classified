@extends('backend.layouts.dashboard_layout')
@section('title')
    {{ translate('Quick Sell Tips') }}
@endsection
@section('page-content')
    <div class="theme-option-container">
        @include('backend.modules.settings.includes.head')
        <div class="theme-option-tab-wrap">
            @include('backend.modules.settings.includes.tabs')
            <div class="tab-content">
                <div class="tab-pane fade show active">
                    <div class="card">
                        <div class="card-header align-items-center bg-white d-flex justify-content-between">
                            <h4>{{ translate('Quick Sell Tips') }}</h4>
                            <button class="btn long" data-toggle="modal"
                                data-target="#new-tip-model">{{ translate('Add New Tips') }}
                            </button>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="hoverable text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ translate('Title') }}</th>
                                            <th>{{ translate('Status') }}</th>
                                            <th class="text-center">{{ translate('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($tips->count() > 0)
                                            @foreach ($tips as $key => $tip)
                                                <tr>
                                                    <td>
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td>
                                                        {{ $tip->translation('title') }}
                                                    </td>
                                                    <td>
                                                        @if ($tip->status == config('settings.general_status.active'))
                                                            <p class="badge badge-success">{{ translate('Active') }}</p>
                                                        @else
                                                            <p class="badge badge-danger">{{ translate('Inactive') }}</p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex dropdown-button justify-content-center show">
                                                            <a href="#"
                                                                class="d-flex align-items-center justify-content-end"
                                                                data-toggle="dropdown">
                                                                <div class="menu-icon mr-0">
                                                                    <span></span>
                                                                    <span></span>
                                                                    <span></span>
                                                                </div>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a
                                                                    href="{{ route('plugin.classilookscore.classified.settings.quick.sell.tips.edit', ['id' => $tip->id, 'lang' => getDefaultLang()]) }}">
                                                                    {{ translate('Edit') }}
                                                                </a>
                                                                <a href="#" class="delete-tip"
                                                                    data-tip="{{ $tip->id }}">{{ translate('Delete') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9">
                                                    <p class="alert alert-danger text-center">
                                                        {{ translate('Nothing Found') }}</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="pgination px-3">
                                    {!! $tips->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5-custom') !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--Tip adding Modal-->
    <div id="new-tip-model" class="new-tip-model modal fade show" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title bold h6">{{ translate('Create New Safety Tips') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="new-tip-form">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="black font-14">{{ translate('Title') }}</label>
                                    <input type="text" name="title" class="form-control slugable_input"
                                        placeholder="{{ translate('Enter title') }}">
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
                                <button class="btn long mt-2 store-new-tip">{{ translate('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End tip adding modal-->
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
                    <p class="mt-1">{{ translate('Are you sure to delete this  tips') }}?</p>
                    <form method="POST"
                        action="{{ route('plugin.classilookscore.classified.settings.quick.sell.tips.delete') }}">
                        @csrf
                        <input type="hidden" id="delete-id" name="id">
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
             * Store New tips
             *
             **/
            $(document).on('click', '.store-new-tip', function(e) {
                $(document).find('.invalid-input').remove();
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $("#new-tip-form").serialize(),
                    url: '{{ route('plugin.classilookscore.classified.settings.quick.sell.tips.store') }}',
                    success: function(response) {
                        if (response.success) {
                            toastr.success(
                                '{{ translate('Quick sell tips created successfully') }}');
                            location.reload();
                        } else {
                            toastr.error('{{ translate('Quick sell tips create failed') }}');
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
                            toastr.error('{{ translate('Quick sell tips create failed') }}');
                        }
                    }
                });
            });
            /**
             *
             * Visible delete modal
             *
             * */
            $('.delete-tip').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('tip');
                $('#delete-id').val(id);
                $("#delete-modal").modal("show");
            });

        })(jQuery);
    </script>
@endsection
