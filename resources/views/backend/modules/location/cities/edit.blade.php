<form id="editForm">
    @csrf
    <input type="hidden" name="id" value="{{ $city->id }}">
    <input type="hidden" name="lang" value="{{ $lang }}">

    {{-- Language Tabs --}}
    <div class="lang-switcher-wrap mb-3">
        <div class="lang-switcher-label">
            <i class="fas fa-globe-americas"></i>
            <span>{{ translation('Language') }}</span>
        </div>
        <div class="lang-switcher-tabs">
            @foreach ($languages as $language)
                <button type="button"
                    class="lang-switcher-btn location-lang-tab @if ($language->code == $lang) active @endif"
                    data-lang="{{ $language->code }}" data-id="{{ $city->id }}"
                    data-endpoint="{{ route('classified.locations.city.edit') }}">
                    <span class="lang-dot"></span>
                    {{ $language->title }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-lg-12">
            <label class="black font-14">{{ translation('Name') }}</label>
            <input type="text" name="name" class="form-control" placeholder="{{ translation('Enter Name') }}"
                value="{{ $city->translation('name', $lang) }}">
        </div>
    </div>

    @if ($lang == defaultLangCode())
        <div class="form-row">
            <div class="form-group col-lg-12">
                <label class="black font-14">{{ translation('Country') }}</label>
                <select name="country" class="form-control country-select">
                    <option value="">{{ translation('Select Country') }}</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" @selected($city->state?->country_id == $country->id)>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-12">
                <label class="black font-14">{{ translation('State') }}</label>
                <select name="state_id" class="form-control state-select">
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}" @selected($city->state_id == $state->id)>{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-lg-12">
                <label class="black font-14">{{ translation('Status') }}</label>
                <select name="status" class="form-control" required>
                    <option value="{{ config('settings.general_status.active') }}" @selected($city->status == config('settings.general_status.active'))>
                        {{ translation('Active') }}
                    </option>
                    <option value="{{ config('settings.general_status.in_active') }}" @selected($city->status == config('settings.general_status.in_active'))>
                        {{ translation('Inactive') }}
                    </option>
                </select>
            </div>
        </div>
    @endif

    <div class="btn-area d-flex justify-content-between">
        <button class="btn btn-primary mt-2">{{ translation('Save Changes') }}</button>
    </div>

</form>
