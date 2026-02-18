@php
    $currency_position = getCurrencyPosition();
@endphp
@extends('backend.layouts.dashboard_layout')
@section('title')
    {{ translation('Currency Settings') }}
@endsection
@push('head')
    <style>
        .important-border {
            border: 1px solid #dddcdc !important
        }

        .form-row {
            align-items: center !important;
        }
    </style>
@endpush
@section('page-content')
    <div class="theme-option-container">
        @include('backend.modules.settings.includes.head')
        <div class="theme-option-tab-wrap">
            @include('backend.modules.settings.includes.tabs')
            <div class="tab-content">
                <div class="tab-pane fade show active">
                    <div class="card">
                        <div class="card-header bg-white border-bottom2 py-3">
                            <h4>{{ translation('Currency Settings') }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('classified.settings.update') }}" method="POST">
                                @csrf
                                <div class="form-row mb-20">
                                    <div class="col-md-4">
                                        <label class="font-14 bold black">{{ translation('Name') }} </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="default_currency_name" class="form-control"
                                            value="{{ getGeneralSetting('default_currency_name') }}"
                                            placeholder="{{ translation('Type Name') }}">
                                        @if ($errors->has('default_currency_name'))
                                            <div class="invalid-input">{{ $errors->first('default_currency_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-md-4">
                                        <label class="font-14 bold black">{{ translation('Symbol') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="default_currency_symbol"
                                            class="form-control currency-font"
                                            value="{{ getGeneralSetting('default_currency_symbol') }}"
                                            placeholder="{{ translation('Symbol') }}">
                                        @if ($errors->has('default_currency_symbol'))
                                            <div class="invalid-input">{{ $errors->first('default_currency_symbol') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-md-4">
                                        <label class="font-14 bold black">{{ translation('Code') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="default_currency_code" class="form-control"
                                            value="{{ getGeneralSetting('default_currency_code') }}"
                                            placeholder="{{ translation('Code') }}">
                                        @if ($errors->has('default_currency_code'))
                                            <div class="invalid-input">{{ $errors->first('default_currency_code') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-md-4">
                                        <label class="font-14 bold black">{{ translation('Currency Position') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" name="default_currency_position" id="currency_position"
                                            placeholder="{{ translation('Select currency position') }}">
                                            @foreach ($currency_position as $key => $value)
                                                <option value="{{ $key }}" @selected(getGeneralSetting('default_currency_position') == $key)>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('default_currency_position'))
                                            <div class="invalid-input">{{ $errors->first('default_currency_position') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-md-4">
                                        <label class="font-14 bold black">{{ translation('Thousand separator') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="default_currency_thousand_separator"
                                            class="form-control"
                                            value="{{ getGeneralSetting('default_currency_thousand_separator') }}"
                                            placeholder="{{ translation('Thousand separator') }}">
                                        @if ($errors->has('default_currency_thousand_separator'))
                                            <div class="invalid-input">
                                                {{ $errors->first('default_currency_thousand_separator') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-md-4">
                                        <label class="font-14 bold black">{{ translation('Decimal separator') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="default_currency_decimal_separator" class="form-control"
                                            value="{{ getGeneralSetting('default_currency_decimal_separator') }}"
                                            placeholder="{{ translation('Decimal separator') }}">
                                        @if ($errors->has('default_currency_decimal_separator'))
                                            <div class="invalid-input">
                                                {{ $errors->first('default_currency_decimal_separator') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-md-4">
                                        <label class="font-14 bold black">{{ translation('Number of decimals') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" name="default_currency_number_of_decimal" class="form-control"
                                            value="{{ getGeneralSetting('default_currency_number_of_decimal') }}"
                                            placeholder="0">
                                        @if ($errors->has('default_currency_number_of_decimal'))
                                            <div class="invalid-input">
                                                {{ $errors->first('default_currency_number_of_decimal') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn long">{{ translation('Save Changes') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
