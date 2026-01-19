@php
    $lang = request()->get('lang');
@endphp
@extends('backend.layouts.dashboard_layout')
@section('title')
    {{ translate('Edit State') }}
@endsection
@section('page-style')
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.css') }}">
@endsection
@section('page-content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="mb-3">
                <p class="alert alert-info">You are editing <strong>"{{ getLanguageNameByCode($lang) }}"</strong>
                    version
                </p>
            </div>

            <div class="card mb-30">
                <!--Language Switcher-->
                <ul class="nav nav-tabs nav-fill border-light border-0 mb-20">
                    @foreach (getAllLanguages() as $key => $language)
                        <li class="nav-item">
                            <a class="nav-link @if ($language->code == $lang) active border-0 @else bg-light @endif py-3"
                                href="{{ route('plugin.location.state.edit', ['id' => $stateDetails->id, 'lang' => $language->code]) }}">
                                <img src="{{ asset('/public/web-assets/backend/img/flags') . '/' . $language->code . '.png' }}"
                                    width="20px">
                                <span>{{ $language->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <!--End Language Switcher--->
                <div class="card-header bg-white py-3">
                    <h4>{{ translate('State Information') }}</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('plugin.location.state.update') }}" method="POST">
                        @csrf
                        <div class="form-row mb-20">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Name') }} </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control"
                                    value="{{ $stateDetails->translation('name', $lang) }}"
                                    placeholder="{{ translate('Type Name') }}">
                                <input type="hidden" name="id" value="{{ $stateDetails->id }}">
                                <input type="hidden" name="lang" value="{{ $lang }}">
                                @if ($errors->has('name'))
                                    <div class="invalid-input">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div
                            class="form-row mb-20 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Code') }}</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="code" class="form-control" value="{{ $stateDetails->code }}"
                                    placeholder="{{ translate('Type  Here') }}">
                                @if ($errors->has('code'))
                                    <div class="invalid-input">{{ $errors->first('code') }}</div>
                                @endif
                            </div>
                        </div>
                        <div
                            class="form-row mb-20 {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Country') }}</label>
                            </div>
                            <div class="col-sm-8">
                                <select class="countrySelect form-control" name="country"
                                    placeholder="{{ translate('Select a option') }}">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $stateDetails->country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country'))
                                    <div class="invalid-input">{{ $errors->first('country') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn long">{{ translate('Save Changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                $('.countrySelect').select2({
                    theme: "classic",
                });
            });
        })(jQuery);
    </script>
@endsection
