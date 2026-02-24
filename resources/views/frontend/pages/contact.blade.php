@extends('frontend.layouts.master')
@section('meta')
    <title>{{ translation('Contact Us') }} - {{ get_setting('site_name') }}</title>
    <meta name="description"
        content="{{ translation('Get in touch with us. Send us a message and we will get back to you.') }}">
@endsection
@section('content')

    <!-- Page Banner -->
    <section class="breadcrumb-area"
        style="background: linear-gradient(135deg, var(--primary-color, #1a73e8) 0%, #0d47a1 100%); padding: 60px 0;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="text-white mb-2">{{ p_trans('contact_title') ?: translation('Contact Us') }}</h2>
                    <p class="text-white-50">
                        {{ p_trans('contact_sub_title') ?: translation('We would love to hear from you. Send us a message!') }}
                    </p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"
                                    class="text-white">{{ translation('Home') }}</a></li>
                            <li class="breadcrumb-item text-white-50 active">{{ translation('Contact Us') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Page Banner -->

    <!-- Contact Section -->
    <section class="contact-section py-5">
        <div class="container">
            <div class="row g-4">

                <!-- Contact Info Cards -->
                <div class="col-lg-4">
                    <div class="h-100 d-flex flex-column gap-3">

                        @if (p_trans('contact_address'))
                            <div class="card border-0 shadow-sm rounded-3 p-4">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="icon-box bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width:50px;height:50px;">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">{{ translation('Address') }}</h6>
                                        <p class="text-muted mb-0 small">{{ p_trans('contact_address') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (p_trans('contact_email'))
                            <div class="card border-0 shadow-sm rounded-3 p-4">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="icon-box bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width:50px;height:50px;">
                                        <i class="fas fa-envelope text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">{{ translation('Email') }}</h6>
                                        <a href="mailto:{{ p_trans('contact_email') }}"
                                            class="text-muted text-decoration-none small">{{ p_trans('contact_email') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (p_trans('contact_phone_1'))
                            <div class="card border-0 shadow-sm rounded-3 p-4">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="icon-box bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width:50px;height:50px;">
                                        <i class="fas fa-phone text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">{{ translation('Phone') }}</h6>
                                        <a href="tel:{{ p_trans('contact_phone_1') }}"
                                            class="text-muted text-decoration-none small d-block">{{ p_trans('contact_phone_1') }}</a>
                                        @if (p_trans('contact_phone_2'))
                                            <a href="tel:{{ p_trans('contact_phone_2') }}"
                                                class="text-muted text-decoration-none small d-block">{{ p_trans('contact_phone_2') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (p_trans('contact_opening_hours'))
                            <div class="card border-0 shadow-sm rounded-3 p-4">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="icon-box bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width:50px;height:50px;">
                                        <i class="fas fa-clock text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">{{ translation('Working Hours') }}</h6>
                                        <p class="text-muted mb-0 small">{{ p_trans('contact_opening_hours') }}</p>
                                        @if (p_trans('contact_closed_hours'))
                                            <p class="text-muted mb-0 small">{{ p_trans('contact_closed_hours') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Fallback if no contact info configured -->
                        @if (!p_trans('contact_address') && !p_trans('contact_email') && !p_trans('contact_phone_1'))
                            <div class="card border-0 shadow-sm rounded-3 p-4">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="icon-box bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width:50px;height:50px;">
                                        <i class="fas fa-info-circle text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">{{ get_setting('site_name') }}</h6>
                                        <p class="text-muted mb-0 small">
                                            {{ translation('Fill in the form and we will reach out to you.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5">
                        <h4 class="fw-bold mb-1">{{ translation('Send Us a Message') }}</h4>
                        <p class="text-muted mb-4 small">
                            {{ translation('Fill in the form below and we will reply as soon as possible.') }}</p>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('contact.send') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">{{ translation('Your Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="{{ translation('Enter your full name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">{{ translation('Email Address') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="{{ translation('Enter your email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-medium">{{ translation('Subject') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="subject" value="{{ old('subject') }}"
                                        class="form-control @error('subject') is-invalid @enderror"
                                        placeholder="{{ translation('What is this about?') }}" required>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-medium">{{ translation('Message') }} <span
                                            class="text-danger">*</span></label>
                                    <textarea name="message" rows="6" class="form-control @error('message') is-invalid @enderror"
                                        placeholder="{{ translation('Write your message here...') }}" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold">
                                        <i class="fas fa-paper-plane me-2"></i>{{ translation('Send Message') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Contact Section -->

@endsection
