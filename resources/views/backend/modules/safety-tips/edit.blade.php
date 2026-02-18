@php
    $lang = request()->get('lang');
    $links = [
        [
            'title' => 'Safety Tips',
            'route' => 'classified.settings.safety.tips.list',
            'active' => false,
        ],
        [
            'title' => 'Edit Safety Tips',
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    {{ translation('Edit Safety Tips') }}
@endsection
@section('page-content')
    <x-admin-page-header title="Edit Safety Tips" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('classified.settings.safety.tips.update') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-9 col-12">
                        <div class="card">
                            <ul class="nav nav-tabs nav-fill border-light border-0">
                                @foreach (getAllLanguages() as $key => $language)
                                    <li class="nav-item">
                                        <a class="nav-link @if ($language->code == $lang) active border-0 @else bg-light @endif py-3"
                                            href="{{ route('classified.settings.safety.tips.edit', ['id' => $tips->id, 'lang' => $language->code]) }}">
                                            <img src="{{ asset('/public/web-assets/backend/img/flags') . '/' . $language->code . '.png' }}"
                                                width="20px">
                                            <span>{{ $language->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ translation('Title') }}</label>
                                    <input type="hidden" name="id" value="{{ $tips->id }}">
                                    <input type="hidden" name="lang" value="{{ $lang }}">
                                    <input type="text" name="title" class="form-control"
                                        value="{{ $tips->translation('title', $lang) }}"
                                        placeholder="{{ translation('Enter title') }}">
                                    @if ($errors->has('title'))
                                        <div class="error text-danger mb-0 invalid-input">
                                            {{ $errors->first('title') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div
                                    class="form-group {{ !empty($lang) && $lang != defaultLangCode() ? 'area-disabled' : '' }}">
                                    <label>{{ translation('Status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="{{ config('settings.general_status.active') }}"
                                            @selected($tips->status == config('settings.general_status.active'))>
                                            {{ translation('Active') }}
                                        </option>
                                        <option value="{{ config('settings.general_status.in_active') }}"
                                            @selected($tips->status == config('settings.general_status.in_active'))>
                                            {{ translation('Inactive') }}
                                        </option>
                                    </select>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary btn-block">{{ translation('Save Changes') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
