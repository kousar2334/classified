@php
    $links = [['title' => 'Currency Settings', 'route' => '', 'active' => true]];
    $currency_position = getCurrencyPosition();
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    {{ translation('Currency Settings') }}
@endsection
@section('page-content')
    <x-admin-page-header title="Currency Settings" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Currency Settings') }}</h3>
                        </div>
                        <form action="{{ route('classified.settings.update') }}" method="POST">
                            @csrf
                            <div class="card-body">

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">{{ translation('Name') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="default_currency_name" class="form-control"
                                            value="{{ getGeneralSetting('default_currency_name') }}"
                                            placeholder="{{ translation('e.g. US Dollar') }}">
                                        @error('default_currency_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">{{ translation('Symbol') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="default_currency_symbol" class="form-control"
                                            value="{{ getGeneralSetting('default_currency_symbol') }}"
                                            placeholder="{{ translation('e.g. $') }}">
                                        @error('default_currency_symbol')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">{{ translation('Code') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="default_currency_code" class="form-control"
                                            value="{{ getGeneralSetting('default_currency_code') }}"
                                            placeholder="{{ translation('e.g. USD') }}">
                                        @error('default_currency_code')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">{{ translation('Currency Position') }}</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="default_currency_position">
                                            @foreach ($currency_position as $key => $value)
                                                <option value="{{ $key }}" @selected(getGeneralSetting('default_currency_position') == $key)>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('default_currency_position')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">{{ translation('Thousand Separator') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="default_currency_thousand_separator"
                                            class="form-control"
                                            value="{{ getGeneralSetting('default_currency_thousand_separator') }}"
                                            placeholder="{{ translation('e.g. ,') }}">
                                        @error('default_currency_thousand_separator')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">{{ translation('Decimal Separator') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="default_currency_decimal_separator" class="form-control"
                                            value="{{ getGeneralSetting('default_currency_decimal_separator') }}"
                                            placeholder="{{ translation('e.g. .') }}">
                                        @error('default_currency_decimal_separator')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="col-sm-4 col-form-label">{{ translation('Number of Decimals') }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="default_currency_number_of_decimal" class="form-control"
                                            value="{{ getGeneralSetting('default_currency_number_of_decimal', 2) }}"
                                            min="0" max="8" placeholder="2">
                                        @error('default_currency_number_of_decimal')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> {{ translation('Save Changes') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Preview') }}</h3>
                        </div>
                        <div class="card-body text-center">
                            <p class="text-muted mb-1 small">{{ translation('Amount will display as:') }}</p>
                            <h3 class="text-primary mb-0" id="currency-preview">{{ format_amount(1234.56) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
