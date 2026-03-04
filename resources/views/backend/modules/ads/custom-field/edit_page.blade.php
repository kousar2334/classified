@php
    $lang = request()->get('lang', defaultLangCode());
    $links = [
        [
            'title' => 'Listing Custom Fields',
            'route' => 'classified.ads.custom.field.list',
            'active' => false,
        ],
        [
            'title' => 'Edit Custom Field',
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    {{ translation('Edit Custom Field') }}
@endsection
@section('page-content')
    <x-admin-page-header title="Edit Custom Field" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Custom Field Information') }}</h3>
                        </div>
                        <div class="card-body">
                            {{-- Language tabs --}}
                            <ul class="nav nav-tabs nav-fill border-light border-0 mb-3">
                                @foreach (activeLanguages() as $language)
                                    <li class="nav-item">
                                        <a class="nav-link @if ($language->code == $lang) active border-0 @else bg-light @endif py-3"
                                            href="{{ route('classified.ads.custom.field.edit.page', ['id' => $field->id, 'lang' => $language->code]) }}">
                                            {{ $language->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <form id="editForm">
                                @csrf
                                <input type="hidden" name="id" value="{{ $field->id }}">
                                <input type="hidden" name="lang" value="{{ $lang }}">

                                <div class="form-group">
                                    <label class="black font-14">{{ translation('Title') }}</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ $field->translation('title', $lang) }}"
                                        placeholder="{{ translation('Enter title') }}">
                                </div>

                                @if ($lang == defaultLangCode())
                                    <div class="form-group">
                                        <label class="black font-14">{{ translation('Type') }}</label>
                                        <select name="type" class="form-control text-capitalize">
                                            @foreach (config('settings.input_types') as $key => $value)
                                                <option value="{{ $value }}" @selected($field->type == $value)>
                                                    {{ ucwords(str_replace('_', ' ', $key)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="black font-14">{{ translation('Default Value') }}</label>
                                        <input type="text" name="default_value" class="form-control"
                                            placeholder="{{ translation('Enter Default Value') }}"
                                            value="{{ $field->default_value }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="switch glow primary medium mr-2">
                                            <input type="checkbox" name="is_required" @checked($field->is_required == config('settings.general_status.active'))>
                                            <span class="control"></span>
                                        </label>
                                        <label class="black font-14">{{ translation('Is Required ?') }}</label>
                                    </div>

                                    <div class="form-group">
                                        <label class="switch glow primary medium mr-2">
                                            <input type="checkbox" name="is_filterable" @checked($field->is_filterable == config('settings.general_status.active'))>
                                            <span class="control"></span>
                                        </label>
                                        <label class="black font-14">{{ translation('Is Filterable ?') }}</label>
                                    </div>

                                    <div class="form-group">
                                        <label class="black font-14">{{ translation('Status') }}</label>
                                        <select name="status" class="form-control">
                                            <option value="{{ config('settings.general_status.active') }}"
                                                @selected($field->status == config('settings.general_status.active'))>
                                                {{ translation('Active') }}
                                            </option>
                                            <option value="{{ config('settings.general_status.in_active') }}"
                                                @selected($field->status == config('settings.general_status.in_active'))>
                                                {{ translation('Inactive') }}
                                            </option>
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="type" value="{{ $field->type }}">
                                    <input type="hidden" name="status" value="{{ $field->status }}">
                                    <input type="hidden" name="default_value" value="{{ $field->default_value }}">
                                @endif

                                <div class="d-flex justify-content-between mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ translation('Save Changes') }}
                                    </button>
                                    <a href="{{ route('classified.ads.custom.field.list') }}" class="btn btn-secondary">
                                        {{ translation('Back') }}
                                    </a>
                                </div>
                            </form>
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

            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                $(document).find('.invalid-input').remove();
                $(document).find('.form-control').removeClass('is-invalid');
                var formData = new FormData(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: formData,
                    url: '{{ route('classified.ads.custom.field.update') }}',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message, 'Success');
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            $.each(response.responseJSON.errors, function(field_name, error) {
                                $(document).find('[name=' + field_name + ']').addClass(
                                    'is-invalid');
                                $(document).find('[name=' + field_name + ']').after(
                                    '<div class="error text-danger mb-0 invalid-input">' +
                                    error + '</div>'
                                );
                            });
                        } else {
                            toastr.error('{{ translation('Custom field update failed') }}',
                                'Error');
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
