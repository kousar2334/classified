@extends('frontend.layouts.dashboard')
@section('dash-meta')
    <title>{{ translation('Confirm Subscription') }} - {{ get_setting('site_name') }}</title>
@endsection

@section('dashboard-content')
    <div class="my-listings-header">
        <h1>{{ translation('Confirm Subscription') }}</h1>
        <div class="btn-wrapper">
            <a href="{{ route('pricing.plans') }}" class="cmn-btn btn-outline">
                <i class="fas fa-arrow-left"></i> {{ translation('Back to Plans') }}
            </a>
        </div>
    </div>

    <div class="row" style="gap: 0; display: flex; flex-wrap: wrap;">

        {{-- Plan Summary --}}
        <div style="flex: 0 0 340px; max-width: 340px; padding-right: 24px; margin-bottom: 24px;">
            <div class="dashboard-card" style="padding: 28px;">
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 18px; color: var(--heading-color);">
                    {{ translation('Order Summary') }}
                </h3>
                <div
                    style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <span style="color: #6b7280;">{{ translation('Plan') }}</span>
                    <strong>{{ $plan->translation('title') }}</strong>
                </div>
                <div
                    style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <span style="color: #6b7280;">{{ translation('Duration') }}</span>
                    <strong>{{ $plan->duration_days }} {{ translation('days') }}</strong>
                </div>
                <div
                    style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <span style="color: #6b7280;">{{ translation('Listings') }}</span>
                    <strong>{{ $plan->listing_quantity }}</strong>
                </div>
                <div
                    style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <span style="color: #6b7280;">{{ translation('Featured') }}</span>
                    <strong>{{ $plan->featured_listing_quantity }}</strong>
                </div>
                <div
                    style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <span style="color: #6b7280;">{{ translation('Gallery Images') }}</span>
                    <strong>{{ $plan->gallery_image_quantity }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 14px 0 0; margin-top: 4px;">
                    <span
                        style="font-size: 1.05rem; font-weight: 700; color: var(--heading-color);">{{ translation('Total') }}</span>
                    <span
                        style="font-size: 1.3rem; font-weight: 800; color: var(--main-color);">${{ number_format($plan->price, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Payment Methods --}}
        <div style="flex: 1; min-width: 280px; margin-bottom: 24px;">

            @if (!$sslEnabled && !$bankTransferEnabled)
                <div class="sub-warning-banner">
                    <i class="fas fa-exclamation-triangle sub-warning-icon"></i>
                    <div>
                        <strong class="sub-warning-title">{{ translation('No payment method available') }}</strong>
                        <p class="sub-warning-text">{{ translation('Please contact the administrator.') }}</p>
                    </div>
                </div>
            @endif

            {{-- SSLCommerz --}}
            @if ($sslEnabled)
                <div class="dashboard-card" style="padding: 28px; margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <div
                            style="width: 44px; height: 44px; background: #e0f2fe; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-credit-card" style="color: #0369a1; font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 1rem; font-weight: 700; margin: 0; color: var(--heading-color);">
                                {{ translation('Online Payment') }}</h4>
                            <small style="color: #6b7280;">{{ translation('Pay securely via SSLCommerz') }}</small>
                        </div>
                    </div>
                    <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 18px;">
                        {{ translation('Supports credit/debit cards, mobile banking, and internet banking. Instant activation.') }}
                    </p>
                    <form action="{{ route('membership.initiate.payment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="membership_id" value="{{ $plan->id }}">
                        <button type="submit" class="cmn-btn" style="width: 100%;">
                            <i class="fas fa-lock me-2"></i> {{ translation('Pay') }}
                            ${{ number_format($plan->price, 2) }} {{ translation('Online') }}
                        </button>
                    </form>
                </div>
            @endif

            {{-- Bank Transfer --}}
            @if ($bankTransferEnabled)
                <div class="dashboard-card" style="padding: 28px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <div
                            style="width: 44px; height: 44px; background: #f0fdf4; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-university" style="color: #16a34a; font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <h4 style="font-size: 1rem; font-weight: 700; margin: 0; color: var(--heading-color);">
                                {{ translation('Bank Transfer') }}</h4>
                            <small style="color: #6b7280;">{{ translation('Manual verification required') }}</small>
                        </div>
                    </div>

                    {{-- Bank Details --}}
                    <div style="background: #f9fafb; border-radius: 10px; padding: 16px; margin-bottom: 18px;">
                        <p
                            style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #9ca3af; margin-bottom: 12px;">
                            {{ translation('Bank Account Details') }}
                        </p>
                        @if (get_setting('bank_name'))
                            <div
                                style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e5e7eb; font-size: 0.875rem;">
                                <span style="color: #6b7280;">{{ translation('Bank Name') }}</span>
                                <strong>{{ get_setting('bank_name') }}</strong>
                            </div>
                        @endif
                        @if (get_setting('bank_account_name'))
                            <div
                                style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e5e7eb; font-size: 0.875rem;">
                                <span style="color: #6b7280;">{{ translation('Account Name') }}</span>
                                <strong>{{ get_setting('bank_account_name') }}</strong>
                            </div>
                        @endif
                        @if (get_setting('bank_account_number'))
                            <div
                                style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e5e7eb; font-size: 0.875rem;">
                                <span style="color: #6b7280;">{{ translation('Account Number') }}</span>
                                <strong style="font-family: monospace;">{{ get_setting('bank_account_number') }}</strong>
                            </div>
                        @endif
                        @if (get_setting('bank_routing_number'))
                            <div
                                style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e5e7eb; font-size: 0.875rem;">
                                <span style="color: #6b7280;">{{ translation('Routing Number') }}</span>
                                <strong style="font-family: monospace;">{{ get_setting('bank_routing_number') }}</strong>
                            </div>
                        @endif
                        @if (get_setting('bank_branch'))
                            <div
                                style="display: flex; justify-content: space-between; padding: 6px 0; font-size: 0.875rem;">
                                <span style="color: #6b7280;">{{ translation('Branch') }}</span>
                                <strong>{{ get_setting('bank_branch') }}</strong>
                            </div>
                        @endif
                    </div>

                    @if (get_setting('bank_instructions'))
                        <div
                            style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 12px 14px; margin-bottom: 18px; font-size: 0.875rem; color: #92400e;">
                            <i class="fas fa-info-circle me-1"></i>
                            {{ get_setting('bank_instructions') }}
                        </div>
                    @endif

                    <form action="{{ route('membership.bank.payment') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="membership_id" value="{{ $plan->id }}">

                        <div style="margin-bottom: 16px;">
                            <label
                                style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 8px; color: var(--heading-color);">
                                {{ translation('Upload Payment Slip') }} <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="file" name="bank_slip" accept=".jpg,.jpeg,.png,.pdf" required
                                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.875rem; background: #fff;">
                            <small style="color: #9ca3af; margin-top: 4px; display: block;">
                                {{ translation('Accepted formats: JPG, PNG, PDF. Max 4MB.') }}
                            </small>
                            @error('bank_slip')
                                <span style="color: #dc2626; font-size: 0.8rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="cmn-btn"
                            style="width: 100%; background: #16a34a; border-color: #16a34a;">
                            <i class="fas fa-paper-plane me-2"></i> {{ translation('Submit Payment') }}
                        </button>
                    </form>

                    <p style="margin-top: 12px; font-size: 0.8rem; color: #9ca3af; text-align: center;">
                        <i class="fas fa-clock me-1"></i>
                        {{ translation('Your subscription will be activated after admin verification.') }}
                    </p>
                </div>
            @endif

        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @foreach ($errors->all() as $error)
                    toastr.error('{{ $error }}');
                @endforeach
            });
        </script>
    @endif
@endsection
