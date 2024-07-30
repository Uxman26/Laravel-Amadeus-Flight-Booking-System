@extends('layouts.auth')
@section('form')
<div class="card card-raised shadow-10 mt-5 mt-xl-10 mb-4">
    <div class="card-body p-5">
        <!-- Auth header with logo image-->
        <div class="text-center">
            <img class="mb-3" src="{{ asset('assets/img/favicon.png') }}" alt="..." style="max-height: 48px;border-radius: 8px;" />
            <h1 class="display-5 mb-0"><strong>Login</strong></h1>
            <div class="subheading-1 mb-5">Administrator Users Only</div>
        </div>
        <!-- Login submission form-->

        <form method="POST" action="{{ route('register') }}" data-wow-duration="0.2s" data-wow-delay="0.2s" class="form-signin form-horizontal wow fadeIn animated">
            @csrf

            <div class="mb-2">
                <label class="pure-material-textfield-outlined">
                    <input placeholder="Full Name" name="name" type="text" autofocus="">
                    <span>Full Name</span>
                </label>
            </div>

            <div class="mb-2">
                <label class="pure-material-textfield-outlined">
                    <input placeholder="Email" name="email" type="text">
                    <span>Email</span>
                </label>
            </div>
            <div class="mb-2">
                <label class="pure-material-textfield-outlined">
                    <input placeholder="Phone" name="phone" type="text">
                    <span>Phone #</span>
                </label>
            </div>

            <div class="mb-2">
                <label class="pure-material-textfield-outlined">
                    <input placeholder="Company" name="company" type="text">
                    <span>Company Name</span>
                </label>
            </div>

            <div class="mb-2">
                <label class="pure-material-textfield-outlined">
                    <input placeholder="Country" name="country" type="text">
                    <span>Country</span>
                </label>
            </div>

            <div class="mb-2">
                <label class="pure-material-textfield-outlined">
                    <input type="password" name="password" placeholder=" ">
                    <span>Password</span>
                </label>
            </div>
            <div class="mb-2">
                <label class="pure-material-textfield-outlined">
                    <input type="password" name="password_confirmation" placeholder=" ">
                    <span>Confirm Password</span>
                </label>
            </div>

            <div class="row form-group">
                <div class="col-xs-6">
                    <label class="checkbox">
                        <input type="checkbox" name="remember" value="remember-me"> I agree to ther Terms </label>
                </div>

            </div>
            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">

                <div class="text-right small fw-500 text-decoration-none">
                    <a id="link-forgot" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ForgetPassword"> <strong class="small fw-500 text-decoration-none">Forget Password</strong></a>
                    <div class="clearfix"></div>
                </div>

                <button data-wow-duration="2s" data-wow-delay="s" type="submit" class="btn btn-primary btn-block ladda-button fadeIn animated" data-style="zoom-in">Create Account</button>
            </div>
            <div style="margin-top:10px" class="resultlogin"></div>
        </form>
    </div>
</div>
@endsection