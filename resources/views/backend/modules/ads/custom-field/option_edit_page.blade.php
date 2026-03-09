@php
    $lang = request()->get('lang', defaultLangCode());
    $links = [
        [
            'title' => 'Listing Custom Fields',
            'route' => 'classified.ads.custom.field.list',
            'active' => false,
        ],
        [
            'title' => 'Custom Field Options',
            'route' => 'classified.ads.custom.field.options',
            'params' => ['id' => $option->field?->id],
            'active' => false,
        ],
        [
            'title' => 'Edit Option',
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    {{ translation('Edit Custom Field Option') }}
@endsection
@section('page-content')
    <x-admin-page-header title="Edit Custom Field Option" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Option Information') }}</h3>
                        </div>
                        <div class="card-body">
                            {{-- Language tabs --}}
                            <div class="lang-switcher-wrap mb-3">
                                <div class="lang-switcher-label">
                                    <i class="fas fa-globe-americas"></i>
                                    <span>{{ translation('Language') }}</span>
                                </div>
                                <div class="lang-switcher-tabs">
                                    @foreach (activeLanguages() as $language)
                                        <a href="{{ route('classified.ads.custom.field.options.edit.page', ['id' => $option->id, 'lang' => $language->code]) }}"
                                            class="lang-switcher-btn @if ($language->code == $lang) active @endif">
                                            <span class="lang-dot"></span>
                                            {{ $language->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <form id="editForm">
                                @csrf
                                <input type="hidden" name="id" value="{{ $option->id }}">
                                <input type="hidden" name="lang" value="{{ $lang }}">

                                <div class="form-group">
                                    <label class="black font-14">{{ translation('Value') }}</label>
                                    <input type="text" name="value" class="form-control"
                                        value="{{ $option->translation('value', $lang) }}"
                                        placeholder="{{ translation('Enter value') }}">
                                </div>

                                @if ($lang == defaultLangCode())
                                    <div class="form-group">
                                        <label class="black font-14">{{ translation('Status') }}</label>
                                        <select name="status" class="form-control">
                                            <option value="{{ config('settings.general_status.active') }}"
                                                @selected($option->status == config('settings.general_status.active'))>
                                                {{ translation('Active') }}
                                            </option>
                                            <option value="{{ config('settings.general_status.in_active') }}"
                                                @selected($option->status == config('settings.general_status.in_active'))>
                                                {{ translation('Inactive') }}
                                            </option>
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="status" value="{{ $option->status }}">
                                @endif

                                <div class="d-flex justify-content-between mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ translation('Save Changes') }}
                                    </button>
                                    @if ($option->field)
                                        <a href="{{ route('classified.ads.custom.field.options', ['id' => $option->field->id]) }}"
                                            class="btn btn-secondary">
                                            {{ translation('Back') }}
                                        </a>
                                    @endif
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
                    url: '{{ route('classified.ads.custom.field.options.update') }}',
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
                            toastr.error('{{ translation('Option update failed') }}', 'Error');
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
