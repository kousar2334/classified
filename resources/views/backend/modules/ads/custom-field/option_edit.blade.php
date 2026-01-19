@php
    $lang = request()->get('lang');
@endphp

@extends('backend.layouts.dashboard_layout')
@section('title')
    {{ translate('Edit Option') }}
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
                <div class="align-items-center bg-white card-header d-flex justify-content-between">
                    <h4>{{ translate('Option Information') }}</h4>
                    <a href="{{ route('classified.ads.custom.field.options', ['id' => $option->field_id]) }}"
                        class="btn long text-white"><i class="icofont-long-arrow-left"></i> {{ translate('Back to') }}
                        {{ $option->field->translation('title') }}</a>
                </div>
                <!--Language Switcher-->
                <ul class="nav nav-tabs nav-fill border-light border-0 mb-20">
                    @foreach (getAllLanguages() as $key => $language)
                        <li class="nav-item">
                            <a class="nav-link @if ($language->code == $lang) active border-0 @else bg-light @endif py-3"
                                href="{{ route('classified.ads.custom.field.options.edit', ['id' => $option->id, 'lang' => $language->code]) }}">
                                <img src="{{ asset('/public/web-assets/backend/img/flags') . '/' . $language->code . '.png' }}"
                                    width="20px">
                                <span>{{ $language->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <!--End Language Switcher--->
                <div class="card-body">
                    <form action="{{ route('classified.ads.custom.field.options.update') }}" method="POST">
                        @csrf
                        <div class="form-row mb-20">
                            <div class="col-sm-12">
                                <label class="font-14 bold black">{{ translate('Title') }} </label>
                            </div>
                            <div class="col-sm-12">
                                <input type="hidden" name="id" value="{{ $option->id }}">
                                <input type="hidden" name="lang" value="{{ $lang }}">
                                <input type="text" name="value" class="form-control"
                                    value="{{ $option->translation('value', $lang) }}"
                                    placeholder="{{ translate('Type Value') }}">
                                @if ($errors->has('value'))
                                    <div class="invalid-input">{{ $errors->first('value') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-row {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                            <div class="form-group col-lg-12">
                                <label class="black font-14">{{ translate('Status') }}</label>
                                <select name="status" class="form-control">
                                    <option value="{{ config('settings.general_status.active') }}"
                                        @selected($option->status == config('settings.general_status.active'))>
                                        {{ translate('Active') }}
                                    </option>
                                    <option value="{{ config('settings.general_status.in_active') }}"
                                        @selected($option->status == config('settings.general_status.in_active'))>
                                        {{ translate('Inactive') }}
                                    </option>
                                </select>
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
