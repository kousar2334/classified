@extends('frontend.layouts.master')
@section('meta')
    <title>Forgot Password - {{ get_setting('site_name') }}</title>
@endsection
@section('content')
    <div class="loginArea section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 login-Wrapper">
                    <h3 class="tittle mb-3"> Forgot Password!</h3>
                    <form method="post" action="forget-password.html">
                        <input type="hidden" name="_token" value="4qMgoof0CGXn76Y2Ovd5AWGkX891VOaiaqMZeUxn"
                            autocomplete="off">
                        <div class="col-lg-12">
                            <label class="infoTitle"> Email </label>
                            <div class="input-form input-form2">
                                <input type="text" name="email" class="input-style w-100" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="btn-wrapper mb-10">
                            <button type="submit" class="cmn-btn4 w-100">Submit Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
