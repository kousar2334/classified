@extends('frontend.layouts.master')
@section('meta')
    <title>Sign In - {{ get_setting('site_name') }}</title>
@endsection
@section('content')
    <div class="loginArea section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-5 p-0 order-lg-1 order-1 loginLeft-img">
                    <div class="loginLeft-img">
                        <div class="login-cap">
                            <h3 class="tittle">Buy &amp; sell anything</h3>
                            <p class="pera">Buy &amp; sell anything with ease. Enjoy a seamless experience and connect with
                                buyers and sellers in just a few clicks.</p>
                        </div>
                        <div class="login-img">
                            <img src="/public/uploads/media-uploader//login1708750583.png" alt="" />
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 order-lg-1 order-0 login-Wrapper">
                    <div class="error-message"></div>
                    <div class="row">
                        <form method="post" action="add.html">
                            <input type="hidden" name="_token" value="4qMgoof0CGXn76Y2Ovd5AWGkX891VOaiaqMZeUxn"
                                autocomplete="off">
                            <div class="col-md-12">
                                <label class="infoTitle">Email Or User Name</label>
                                <div class="input-form">
                                    <input type="text" name="username" id="username" placeholder="Email Or User Name">
                                    <div class="icon"><i class="las la-envelope icon"></i></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="infoTitle"> Password </label>
                                <div class="input-form">
                                    <input type="password" name="password" id="password" placeholder="Type Password">
                                    <div class="icon"><i class="las la-lock icon"></i></div>
                                    <div class="icon toggle-password">
                                        <i class="las la-eye-slash"></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-sm-12">
                            <div class="passRemember mt-20">
                                <label class="checkWrap2">Remember Me
                                    <input class="effectBorder" name="remember" type="checkbox" id="check15">
                                    <span class="checkmark"></span>
                                </label>
                                <!-- forgetPassword -->
                                <div class="forgetPassword mb-25">
                                    <a href="../../forget-password.html" class="forgetPass">Forgot Password?</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="btn-wrapper text-center">
                                <button id="signin_form" class="cmn-btn4 w-100">Login</button>
                                <p class="font-weight-bold text-center mt-2 mb-2">or</p>
                                <a href="../../login/otp.html" class="cmn-btn-outline4 w-100 mb-20">Login In with OTP</a>
                                <!--social login -->

                                <p class="sinUp"><span>Don’t have an account?</span><a href="../../user-register.html"
                                        class="singApp">Sign Up</a></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
