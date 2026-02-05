<form id="editForm">
    @csrf
    <input type="hidden" name="id" value="{{ $plan->id }}">

    <div class="form-row">
        <div class="form-group col-lg-12">
            <label class="black font-14">{{ translation('Title') }} *</label>
            <input type="text" name="title" class="form-control" value="{{ $plan->title }}"
                placeholder="{{ translation('Enter plan title') }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-lg-6">
            <label class="black font-14">{{ translation('Duration (Days)') }} *</label>
            <input type="number" name="duration_days" class="form-control" min="1"
                value="{{ $plan->duration_days }}" placeholder="{{ translation('Enter duration in days') }}">
        </div>
        <div class="form-group col-lg-6">
            <label class="black font-14">{{ translation('Price') }} *</label>
            <input type="number" name="price" class="form-control" min="0" step="0.01"
                value="{{ $plan->price }}" placeholder="{{ translation('Enter price') }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-lg-4">
            <label class="black font-14">{{ translation('Listing Quantity') }} *</label>
            <input type="number" name="listing_quantity" class="form-control" min="0"
                value="{{ $plan->listing_quantity }}" placeholder="{{ translation('Number of listings') }}">
        </div>
        <div class="form-group col-lg-4">
            <label class="black font-14">{{ translation('Featured Listing Quantity') }} *</label>
            <input type="number" name="featured_listing_quantity" class="form-control" min="0"
                value="{{ $plan->featured_listing_quantity }}"
                placeholder="{{ translation('Number of featured listings') }}">
        </div>
        <div class="form-group col-lg-4">
            <label class="black font-14">{{ translation('Gallery Image Quantity') }} *</label>
            <input type="number" name="gallery_image_quantity" class="form-control" min="0"
                value="{{ $plan->gallery_image_quantity }}"
                placeholder="{{ translation('Max gallery images per listing') }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-lg-4">
            <label class="black font-14">{{ translation('Membership Badge') }}</label>
            <select name="membership_badge" class="form-control">
                <option value="0" {{ $plan->membership_badge == 0 ? 'selected' : '' }}>
                    {{ translation('Disabled') }}
                </option>
                <option value="1" {{ $plan->membership_badge == 1 ? 'selected' : '' }}>
                    {{ translation('Enabled') }}
                </option>
            </select>
        </div>
        <div class="form-group col-lg-4">
            <label class="black font-14">{{ translation('Online Shop') }}</label>
            <select name="online_shop" class="form-control">
                <option value="0" {{ $plan->online_shop == 0 ? 'selected' : '' }}>
                    {{ translation('Disabled') }}
                </option>
                <option value="1" {{ $plan->online_shop == 1 ? 'selected' : '' }}>
                    {{ translation('Enabled') }}
                </option>
            </select>
        </div>
        <div class="form-group col-lg-4">
            <label class="black font-14">{{ translation('Status') }}</label>
            <select name="status" class="form-control">
                <option value="{{ config('settings.general_status.active') }}"
                    {{ $plan->status == config('settings.general_status.active') ? 'selected' : '' }}>
                    {{ translation('Active') }}
                </option>
                <option value="{{ config('settings.general_status.in_active') }}"
                    {{ $plan->status == config('settings.general_status.in_active') ? 'selected' : '' }}>
                    {{ translation('Inactive') }}
                </option>
            </select>
        </div>
    </div>

    <div class="btn-area d-flex justify-content-between">
        <button type="submit" class="btn btn-primary mt-2">{{ translation('Update') }}</button>
    </div>
</form>
