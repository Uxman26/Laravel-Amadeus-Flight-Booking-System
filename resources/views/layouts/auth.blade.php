<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <script async src="{{ asset('assets/js/api.js') }}"></script>
    <style>
        .sb-customizer-toggler {
            display: none !important
        }
    </style>
</head>
@php
    $color = App\Models\Option::where('key', 'themecolor')->first()->value;
@endphp
<body style="background: {{$color}}">
    <!-- Layout wrapper-->
    <div id="layoutAuthentication">
        <!-- Layout content-->
        <div id="layoutAuthentication_content">
            <!-- Main page content-->
            <main>
                <!-- Main content container-->
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8">
                            @yield('form')
                            <!-- Auth card message-->
                            <div class="text-center mb-5">
                                <div class="me-sm-3 mb-2 mb-sm-0">
                                    <div class="fw-500 text-white">Powered by <a target="_blank" style="color: #FFFFFF" href="#">
                                            <b>{{ env('APP_NAME') }}</b>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Load Bootstrap JS bundle-->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script type="module" src="{{ asset('assets/js/material.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/sb-customizer.js') }}"></script>
    <sb-customizer project="material-admin-pro"></sb-customizer>
    <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/fa.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/include/login/ladda-themeless.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/include/login/spin.min.js') }}"></script>
    <script src="{{ asset('assets/include/login/ladda.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>

    <script src="{{ asset('assets/include/icheck/icheck.min.js') }}"></script>
    <link href="{{ asset('assets/include/icheck/square/grey.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/js/custom.js') }}" rel="stylesheet">
    <x-alert />
</body>

</html>