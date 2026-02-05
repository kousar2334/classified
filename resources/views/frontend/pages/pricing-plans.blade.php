@extends('frontend.layouts.master')

@section('page-title')
    {{ translation('Pricing Plans') }}
@endsection

@section('page-content')
    <!-- Breadcrumb Section -->
    <section class="breadcrumb-area" data-padding-top="50" data-padding-bottom="50">
        <div class="container-1440">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h1 class="head3">{{ translation('Pricing Plans') }}</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ translation('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ translation('Pricing Plans') }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Cards Section -->
    <section class="pricingCard plr" data-padding-top="50" data-padding-bottom="100">
        <div class="container-1440">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-7 col-md-10 col-sm-10">
                    <div class="section-tittle text-center mb-50">
                        <h2 class="head3">{{ translation('Choose Your Plan') }}</h2>
                        <p class="pera mt-3">{{ translation('Select a membership plan that suits your needs') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($pricingPlans as $plan)
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        @include('frontend.includes.pricing-card', ['plan' => $plan])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center">
                            <p class="pera">{{ translation('No pricing plans available at the moment.') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="LoginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="#" method="post">
                @csrf
                <input type="hidden" id="membership_price">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="LoginModalLabel">
                            {{ translation('Login to buy Membership') }}
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="alert alert-warning " role="alert">
                            <p>{{ translation('Notice: You must login as a user to buy a membership') }}</p>
                        </div>
                        <div class="error-message"></div>
                        <div class="input-form">
                            <label class="infoTitle">{{ translation('Email Or User Name') }}</label>
                            <input class="form-control radius-10" type="text" name="username" id="username"
                                placeholder="{{ translation('Email Or User Name') }}">
                        </div>
                        <div class="single-input mt-4">
                            <label class="label-title mb-2">{{ translation('Password') }}</label>
                            <div class="input-form position-relative">
                                <input class="form-control radius-10" type="password" name="password" id="password"
                                    placeholder="{{ translation('Type Password') }}">
                                <div class="icon toggle-password position-absolute">
                                    <i class="las la-eye icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-column">
                        <div class="btn-wrapper text-center">
                            <button type="submit"
                                class="cmn-btn4 w-100 mb-60 login_to_buy_a_membership">{{ translation('Login') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        (function($) {
            "use strict";

            // Store selected membership data
            $('.choose_membership_plan').on('click', function() {
                let membership_id = $(this).data('id');
                let price = $(this).data('price');
                $('#membership_price').val(price);
                $('.membership_id').val(membership_id);
            });

            // Toggle password visibility
            $('.toggle-password').on('click', function() {
                let input = $(this).siblings('input');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    $(this).find('i').removeClass('la-eye').addClass('la-eye-slash');
                } else {
                    input.attr('type', 'password');
                    $(this).find('i').removeClass('la-eye-slash').addClass('la-eye');
                }
            });
        })(jQuery);
    </script>
@endsection
