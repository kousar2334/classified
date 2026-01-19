@php
    $lang = request()->get('lang');
@endphp
@extends('backend.layouts.dashboard_layout')
@section('title')
    {{ translate('Edit Safety Tips') }}
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
                            <h4>{{ translate('Edit Safety Tips') }}</h4>
                            <a class="btn long"
                                href="{{ route('plugin.classilookscore.classified.settings.safety.tips.list') }}">{{ translate('Safety Tips List') }}
                            </a>
                        </div>
                        <div class="card-body">
                            <!--Language Switcher-->
                            <ul class="nav nav-tabs nav-fill border-light border-0 mb-20">
                                @foreach (getAllLanguages() as $key => $language)
                                    <li class="nav-item">
                                        <a class="nav-link @if ($language->code == $lang) active border-0 @else bg-light @endif py-3"
                                            href="{{ route('plugin.classilookscore.classified.settings.safety.tips.edit', ['id' => $tips->id, 'lang' => $language->code]) }}">
                                            <img src="{{ asset('/public/web-assets/backend/img/flags') . '/' . $language->code . '.png' }}"
                                                width="20px">
                                            <span>{{ $language->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <!--End Language Switcher--->
                            <form action="{{ route('plugin.classilookscore.classified.settings.safety.tips.update') }}"
                                method="POST">
                                @csrf
                                <div class="form-row mb-20">
                                    <div class="col-sm-12">
                                        <label class="font-14 bold black">{{ translate('Title') }} </label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="hidden" name="id" value="{{ $tips->id }}">
                                        <input type="hidden" name="lang" value="{{ $lang }}">
                                        <input type="text" name="title" class="form-control"
                                            value="{{ $tips->translation('title', $lang) }}"
                                            placeholder="{{ translate('Type Enter') }}">
                                        @if ($errors->has('title'))
                                            <div class="invalid-input">{{ $errors->first('title') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div
                                    class="form-row {{ !empty($lang) && $lang != getdefaultlang() ? 'area-disabled' : '' }}">
                                    <div class="form-group col-lg-12">
                                        <label class="black font-14">{{ translate('Status') }}</label>
                                        <select name="status" class="form-control">
                                            <option value="{{ config('settings.general_status.active') }}"
                                                @selected($tips->status == config('settings.general_status.active'))>
                                                {{ translate('Active') }}
                                            </option>
                                            <option value="{{ config('settings.general_status.in_active') }}"
                                                @selected($tips->status == config('settings.general_status.in_active'))>
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
        </div>
    </div>
@endsection
