@php
    $lang = request()->get('lang', defaultLangCode());
    $links = [
        ['title' => 'Report Reasons', 'route' => 'classified.ads.report.reasons.list', 'active' => false],
        ['title' => 'Edit Reason', 'route' => '', 'active' => true],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    {{ translation('Edit Report Reason') }}
@endsection
@section('page-content')
    <x-admin-page-header title="Edit Report Reason" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('classified.ads.report.reasons.update') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $reason->id }}">
                <input type="hidden" name="lang" value="{{ $lang }}">

                <div class="row">
                    {{-- Main Content --}}
                    <div class="col-lg-9 col-12">
                        <div class="card">
                            {{-- Language Tabs --}}
                            <ul class="nav nav-tabs nav-fill border-light border-0">
                                @foreach (getAllLanguages() as $language)
                                    <li class="nav-item">
                                        <a class="nav-link @if ($language->code == $lang) active border-0 @else bg-light @endif py-3"
                                            href="{{ route('classified.ads.report.reasons.edit', ['id' => $reason->id, 'lang' => $language->code]) }}">
                                            <span>{{ $language->name }}</span>
                                            @if ($language->native_title)
                                                <small class="text-muted d-block">{{ $language->native_title }}</small>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ translation('Title') }}</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ $reason->translation('title', $lang) }}"
                                        placeholder="{{ translation('Enter reason title') }}">
                                    @error('title')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar: Status + Save --}}
                    <div class="col-lg-3 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div
                                    class="form-group {{ !empty($lang) && $lang != defaultLangCode() ? 'area-disabled' : '' }}">
                                    <label>{{ translation('Status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="{{ config('settings.general_status.active') }}"
                                            @selected($reason->status == config('settings.general_status.active'))>
                                            {{ translation('Active') }}
                                        </option>
                                        <option value="{{ config('settings.general_status.in_active') }}"
                                            @selected($reason->status == config('settings.general_status.in_active'))>
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
