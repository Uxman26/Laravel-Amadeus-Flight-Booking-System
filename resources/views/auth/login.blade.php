@extends('layouts.auth')
@section('form')
<div class="card card-raised shadow-10 mt-5 mt-xl-10 mb-4">
    <div class="card-body p-5">
        <!-- Auth header with logo image-->
        <div class="text-center">
            <img class="mb-3" src="{{ asset('assets/img/favicon.png') }}" alt="..." style="max-height: 48px;border-radius: 8px;" />
            <h1 class="display-5 mb-0"><strong>Login</strong></h1>
            <div class="subheading-1 mb-5">Sign in to your account</div>
        </div>
        <!-- Login submission form-->

        <form method="POST" action="{{ route('login') }}" data-wow-duration="0.2s" data-wow-delay="0.2s" class="form-signin form-horizontal wow fadeIn animated">
            @csrf

            <div class="mb-2">
                <label class="pure-material-textfield-outlined">
                    <input placeholder="Email" name="email" type="text" autofocus="">
                    <span>Email</span>
                </label>
            </div>

            <div class="mb-2">
                <label class="pure-material-textfield-outlined">
                    <input type="password" name="password" placeholder=" " autofocus="">
                    <span>Password</span>
                </label>
            </div>

            <div class="row form-group">
                <div class="col-xs-6">
                    <label class="checkbox">
                        <input type="checkbox" name="remember" value="remember-me"> Remember me </label>
                </div>

            </div>
            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">

                <div class="text-right small fw-500 text-decoration-none">
                    <a id="link-forgot" href="{{ route('register') }}"> <strong class="small fw-500 text-decoration-none">Create New Account</strong></a>
                    <div class="clearfix"></div>
                </div>

                <button data-wow-duration="2s" data-wow-delay="s" type="submit" class="btn btn-primary btn-block ladda-button fadeIn animated" data-style="zoom-in">Login</button>
            </div>
            <div style="margin-top:10px" class="resultlogin"></div>
        </form>
    </div>
</div>
@endsection