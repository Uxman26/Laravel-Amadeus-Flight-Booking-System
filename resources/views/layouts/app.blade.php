<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title') {{ env('APP_NAME') }}</title>
    <!-- ASSETS -->
    <link rel="stylesheet" href="{{ asset('assets/theme/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/line-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/animated-headline.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/mobile.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/childstyle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/responsive.css') }}">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <script src="{{ asset('assets/theme/js/jquery/jquery.min.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">

    {{-- <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script> --}}
    @yield('head')
    <style>
        :root {
            --theme: {{ option('themecolor') }};
        }

        .hide {
            display: none;
        }

        .show_ {
            display: block !important;
        }

        .theme-search-results-item {
            border: 2px solid #354e0c;
        }

        #show,
        #multiway {
            display: none;
        }

        .select2-selection__rendered {
            margin-top: 1px !important;
        }


        .float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            left: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        .my-float {
            margin-top: 16px;
        }

        .btn-call {
            background: #38a3fd;
            border: 2px solid #38a3fd;
            border-radius: 50%;
            box-shadow: 0 8px 10px rgba(56, 163, 253, 0.3);
            cursor: pointer;
            height: 40px;
            width: 40px;
            text-align: center;
            margin-left: 5px;
            /* margin-top: 20px; */
            /* position: fixed; */
            /* right: 50px;
    bottom: 50px; */
            /* z-index: 999; */
            transition: .3s;
            -webkit-animation: hoverWave linear 1s infinite;
            animation: hoverWave linear 1s infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
        }

        .btn-call__ico {
            display: flex;
            justify-content: center;
            align-items: center;
            animation: 1200ms ease 0s normal none 1 running shake;
            animation-iteration-count: infinite;
            -webkit-animation: 1200ms ease 0s normal none 1 running shake;
            -webkit-animation-iteration-count: infinite;
            color: white;
            font-size: 30px;
            padding-top: 5px;
            transition: .3s all;
        }

        .btn-call:hover {
            background-color: #fff;
        }

        .btn-call:hover .btn-call__ico {
            color: #38a3fd;
        }

        @-webkit-keyframes hoverWave {
            0% {
                box-shadow: 0 8px 10px rgba(56, 163, 253, 0.3), 0 0 0 0 rgba(56, 163, 253, 0.2), 0 0 0 0 rgba(56, 163, 253, 0.2)
            }

            40% {
                box-shadow: 0 8px 10px rgba(56, 163, 253, 0.3), 0 0 0 15px rgba(56, 163, 253, 0.2), 0 0 0 0 rgba(56, 163, 253, 0.2)
            }

            80% {
                box-shadow: 0 8px 10px rgba(56, 163, 253, 0.3), 0 0 0 30px rgba(56, 163, 253, 0), 0 0 0 26.7px rgba(56, 163, 253, 0.067)
            }

            100% {
                box-shadow: 0 8px 10px rgba(56, 163, 253, 0.3), 0 0 0 30px rgba(56, 163, 253, 0), 0 0 0 40px rgba(56, 163, 253, 0.0)
            }
        }

        @keyframes hoverWave {
            0% {
                box-shadow: 0 8px 10px rgba(56, 163, 253, 0.3), 0 0 0 0 rgba(56, 163, 253, 0.2), 0 0 0 0 rgba(56, 163, 253, 0.2)
            }

            40% {
                box-shadow: 0 8px 10px rgba(56, 163, 253, 0.3), 0 0 0 15px rgba(56, 163, 253, 0.2), 0 0 0 0 rgba(56, 163, 253, 0.2)
            }

            80% {
                box-shadow: 0 8px 10px rgba(56, 163, 253, 0.3), 0 0 0 30px rgba(56, 163, 253, 0), 0 0 0 26.7px rgba(56, 163, 253, 0.067)
            }

            100% {
                box-shadow: 0 8px 10px rgba(56, 163, 253, 0.3), 0 0 0 30px rgba(56, 163, 253, 0), 0 0 0 40px rgba(56, 163, 253, 0.0)
            }
        }

        /* animations icon */

        @keyframes shake {
            0% {
                transform: rotateZ(0deg);
                -ms-transform: rotateZ(0deg);
                -webkit-transform: rotateZ(0deg);
            }

            10% {
                transform: rotateZ(-30deg);
                -ms-transform: rotateZ(-30deg);
                -webkit-transform: rotateZ(-30deg);
            }

            20% {
                transform: rotateZ(15deg);
                -ms-transform: rotateZ(15deg);
                -webkit-transform: rotateZ(15deg);
            }

            30% {
                transform: rotateZ(-10deg);
                -ms-transform: rotateZ(-10deg);
                -webkit-transform: rotateZ(-10deg);
            }

            40% {
                transform: rotateZ(7.5deg);
                -ms-transform: rotateZ(7.5deg);
                -webkit-transform: rotateZ(7.5deg);
            }

            50% {
                transform: rotateZ(-6deg);
                -ms-transform: rotateZ(-6deg);
                -webkit-transform: rotateZ(-6deg);
            }

            60% {
                transform: rotateZ(5deg);
                -ms-transform: rotateZ(5deg);
                -webkit-transform: rotateZ(5deg);
            }

            70% {
                transform: rotateZ(-4.28571deg);
                -ms-transform: rotateZ(-4.28571deg);
                -webkit-transform: rotateZ(-4.28571deg);
            }

            80% {
                transform: rotateZ(3.75deg);
                -ms-transform: rotateZ(3.75deg);
                -webkit-transform: rotateZ(3.75deg);
            }

            90% {
                transform: rotateZ(-3.33333deg);
                -ms-transform: rotateZ(-3.33333deg);
                -webkit-transform: rotateZ(-3.33333deg);
            }

            100% {
                transform: rotateZ(0deg);
                -ms-transform: rotateZ(0deg);
                -webkit-transform: rotateZ(0deg);
            }
        }

        @-webkit-keyframes shake {
            0% {
                transform: rotateZ(0deg);
                -ms-transform: rotateZ(0deg);
                -webkit-transform: rotateZ(0deg);
            }

            10% {
                transform: rotateZ(-30deg);
                -ms-transform: rotateZ(-30deg);
                -webkit-transform: rotateZ(-30deg);
            }

            20% {
                transform: rotateZ(15deg);
                -ms-transform: rotateZ(15deg);
                -webkit-transform: rotateZ(15deg);
            }

            30% {
                transform: rotateZ(-10deg);
                -ms-transform: rotateZ(-10deg);
                -webkit-transform: rotateZ(-10deg);
            }

            40% {
                transform: rotateZ(7.5deg);
                -ms-transform: rotateZ(7.5deg);
                -webkit-transform: rotateZ(7.5deg);
            }

            50% {
                transform: rotateZ(-6deg);
                -ms-transform: rotateZ(-6deg);
                -webkit-transform: rotateZ(-6deg);
            }

            60% {
                transform: rotateZ(5deg);
                -ms-transform: rotateZ(5deg);
                -webkit-transform: rotateZ(5deg);
            }

            70% {
                transform: rotateZ(-4.28571deg);
                -ms-transform: rotateZ(-4.28571deg);
                -webkit-transform: rotateZ(-4.28571deg);
            }

            80% {
                transform: rotateZ(3.75deg);
                -ms-transform: rotateZ(3.75deg);
                -webkit-transform: rotateZ(3.75deg);
            }

            90% {
                transform: rotateZ(-3.33333deg);
                -ms-transform: rotateZ(-3.33333deg);
                -webkit-transform: rotateZ(-3.33333deg);
            }

            100% {
                transform: rotateZ(0deg);
                -ms-transform: rotateZ(0deg);
                -webkit-transform: rotateZ(0deg);
            }
        }

        .datepicker-days>table>tbody>tr>.old,
        .datepicker-days>table>tbody>tr>.new {
            opacity: 0 !important;
            pointer-events: none !important;
        }

        .datepicker-days>table>tbody>tr>td:first-child,
        .datepicker-days>table>tbody>tr>td:last-child {
            color: red !important;
        }


    </style>
</head>

<body id="fadein" class="fixed-nav" style="padding-top:70px !important;">

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <a href="https://api.whatsapp.com/send?phone=33771626271&amp;text=Hello%20Gondal,%20Having%20visited%20your%20website,%20I%20would%20like%20to%20know%20more%20about%20tickets%20and%C2%A0umrah%C2%A0packages."
            class="float" target="_blank">
            <i class="fa fa-whatsapp my-float"></i>
        </a> --}}
    <!-- loading effect -->
    <!-- <div class="preloader centerrotate" id="preloader">
        <div class="rotatingDiv"></div>
    </div> -->
    @php
        $maintenance_mood = App\Models\Option::where('key', 'maintenance_mode')->first()
            ? App\Models\Option::where('key', 'maintenance_mode')->first()->value
            : 'off';
    @endphp
    @if (
        ($maintenance_mood == 'on' && auth()->user() != null && auth()->user()->role != 1) ||
            ($maintenance_mood == 'on' && auth()->user() == null))
        <img class="img-fluid" src="{{ asset('assets/img/maintenance.jpg') }}"
            style="position: absolute; z-index:+9999">
    @else
        <header class="header-area">
            <div class="header-menu-wrapper padding-right-100px padding-left-100px d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="menu-wrapper d-flex">
                                <div class="logo">
                                    <a href="{{ route('index') }}" style="border-radius:5px">
                                        <img style="max-height:70px;border-radius:5px;background:transparent;padding:4px;"
                                            src="{{ asset('assets/logo/' . getLogo()) }}" alt="logo">
                                    </a>
                                    {{-- <a href="tel:+3318765378" style="margin-left:5px" class=" text-dark"
                                    title="3318765378">+33187653786</a> --}}
                                    <a href="tel:+33187653786" rel="nofollow" class="btn-call">
                                        <div class="btn-call__ico">
                                            <i class="la la-phone"></i>
                                        </div>
                                    </a>
                                    <div class="menu-toggler">
                                        <i class="la la-bars"></i>
                                        <i class="la la-times"></i>
                                    </div>
                                </div>

                                <div class="main-menu-content w-100" style="padding-left:20px!important">
                                    <div class="align-items-center d-flex justify-content-between gap-3">

                                        <div class="w-100">
                                            <nav class="">
                                                <ul style="padding-top:10px!important">
                                                    <li><a href=" {{ route('index') }}" title="home active">Home</a>
                                                    </li>
                                                    @auth
                                                        <li><a href=" {{ route('admin.dashboard.index') }}"
                                                                title="Dashboard">Dashboard</a></li>
                                                        @if (auth()->user()->role == 1)
                                                            <li><a href=" {{ route('admin.booking.index') }}"
                                                                    title="Booking">Go to Bookings</a></li>
                                                        @else
                                                            <li><a href=" {{ route('agent.booking.index') }}"
                                                                    title="Booking">Go to Bookings</a></li>
                                                        @endif
                                                        {{-- <li><a href=" {{ route('goto_nego') }}" title="IATA Nego FARE">IATA
                                                            Nego FARE</a></li> --}}
                                                        {{-- <li><a href=" {{ route('goto_nego_fair_qr') }}" title="FRA NEGO FARE QR EY WY">FRA NEGO FARE QR EY WY</a></li> --}}

                                                        <li><a href=" {{ route('booking.new_order') }}" title="Booking">New
                                                                Order</a></li>
                                                    @else
                                                        <li><a href="#omranhajj">Omra & Hajj</a></li>
                                                        <li><a href="#touristvisa">Tourist Visa</a></li>
                                                    @endauth
                                                </ul>
                                            </nav>
                                        </div>
                                        @auth
                                            <div class="w-100 text-end">
                                                <form action="{{ route('logout') }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary">
                                                            <svg class="pe-1" xmlns="http://www.w3.org/2000/svg"
                                                                width="20" height="20" viewBox="0 0 24 24"
                                                                fill="none" stroke="#ffffff" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                                <circle cx="12" cy="7" r="4"></circle>
                                                            </svg>
                                                            Sign Out
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endauth
                                        @guest
                                            <div class="w-100 d-flex justify-content-end">
                                                <div class="me-1">
                                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                                        <svg class="pe-1" xmlns="http://www.w3.org/2000/svg"
                                                            width="20" height="20" viewBox="0 0 24 24"
                                                            fill="none" stroke="#ffffff" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                            <circle cx="12" cy="7" r="4"></circle>
                                                        </svg>
                                                        B2B Login
                                                    </a>
                                                </div>
                                                <div class="ms-1">
                                                    <a href="{{ route('register') }}" class="btn btn-primary">
                                                        <svg class="pe-1" xmlns="http://www.w3.org/2000/svg"
                                                            width="20" height="20" viewBox="0 0 24 24"
                                                            fill="none" stroke="#ffffff" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                            <circle cx="12" cy="7" r="4"></circle>
                                                        </svg>
                                                        Join Us
                                                    </a>
                                                </div>
                                            </div>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        @guest
            @include('inc.whatsapp-icon')

        @endguest
        @yield('content')
        <!-- start back-to-top -->
        <div id="back-to-top">
            <i class="la la-angle-up" title="Go top"></i>
        </div>
        <!-- end back-to-top -->
    @endif
    <script type="text/javascript">
        $(function() {
            $('#cookie_stop').click(function() {
                $('#cookie_disclaimer').slideUp();
                var nDays = 999;
                var cookieName = "disclaimer";
                var cookieValue = "true";
                var today = new Date();
                var expire = new Date();
                expire.setTime(today.getTime() + 3600000 * 24 * nDays);
                document.cookie = cookieName + "=" + escape(cookieValue) + ";expires=" + expire
                    .toGMTString() + ";path=/";
            });

        });
    </script>

    <!-- javascript resouces and libs -->
    <script src="{{ asset('assets/theme/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/theme/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/theme/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/theme/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/theme/js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('assets/theme/js/jquery.countTo.min.js') }}"></script>
    <script src="{{ asset('assets/theme/js/animated-headline.js') }}"></script>
    <script src="{{ asset('assets/theme/js/quantity-input.js') }}"></script>
    <script src="{{ asset('assets/theme/js/select2.js') }}"></script>
    <script src="{{ asset('assets/theme/js/main.js') }}"></script>
    <script src="{{ asset('assets/theme/js/app.js') }}"></script>
    <script src="{{ asset('assets/theme/js/responsive.js') }}"></script>

    <script>
        // LOADING EFFECT
        $(".foot_menu a,.blog-area a,.destination-area a,.hotel-area a,.popular-round-trip-wrap a,.loading_effect,.header-menu-wrapper a")
            .click(function() {
                $('#preloader').fadeIn(250);
            })

        // homepage tab rearrange and make first one active default
        $(".listitems li").sort(sort_li).appendTo('.listitems');

        function sort_li(a, b) {
            return ($(b).data('position')) < ($(a).data('position')) ? 1 : -1;
        };
        $('.nav-tabs .nav-item:first-child button').addClass('active');
        $('.search_tabs .tab-pane:first-child').addClass('show active');

        // select 2 location init for hotels search
        var $ajax = $(".city");

        function formatRepo(t) {
            return t.loading ? t.text : (console.log(t), '<i class="flag ' + t.icon.toLowerCase() + '"></i>' + t.text)
        }

        function formatRepoSelection(t) {
            return t.text
        }
        // $ajax.select2({
        //     ajax: {
        //         url: "http://localhost/GondalTravelFr/hotels_locations",
        //         dataType: "json",
        //         data: function(t) {
        //             return {
        //                 q: $.trim(t.term)
        //             }
        //         },
        //         processResults: function(t) {
        //             var e = [];
        //             return t.forEach(function(t) {
        //                 e.push({
        //                     id: t.id,
        //                     text: t.text,
        //                     icon: t.icon
        //                 })
        //             }), console.log(e), {
        //                 results: e
        //             }
        //         },
        //         cache: !0
        //     },
        //     escapeMarkup: function(t) {
        //         return t
        //     },
        //     minimumInputLength: 3,
        //     templateResult: formatRepo,
        //     templateSelection: formatRepoSelection,
        //     dropdownPosition: 'below',
        //     cache: !0
        // });
    </script>

    <script>
        $('.select_').select2({
            placeholder: {
                id: '1',
                text: 'Select Category'
            }
        });
        $('.select2-container').css('width', '100%')
        $('#select').select2({
            placeholder: {
                id: '1',
                text: 'Select Category'
            }
        });

        // $('#email_subscribe').click(function() {
        //     let S_email = $('#exampleInputEmail1').val();
        //     if (S_email != 0) {
        //         if (isValidEmailAddress(S_email)) {
        //             $.ajax({
        //                 type: "GET",
        //                 url: "http://localhost/GondalTravelFr/subscribe",
        //                 data: {
        //                     S_email: S_email
        //                 },
        //                 success: function(response) {
        //                     res = JSON.parse(response);
        //                     if (res.error) {
        //                         $('.wow').text("Please add email!");
        //                         $(".newstext").fadeIn(3000);
        //                         $(".newstext").fadeOut(3000);
        //                     } else {
        //                         if (res.status == true) {
        //                             $('.wow').text("Thank you for subscription");
        //                             $(".newstext").fadeIn(3000);
        //                             $(".newstext").fadeOut(3000);
        //                             $('#exampleInputEmail1').val('');
        //                         } else {
        //                             $('.wow').text("Email exist");
        //                             $(".newstext").fadeIn(3000);
        //                             $(".newstext").fadeOut(3000);
        //                             $('#exampleInputEmail1').val('');
        //                         }
        //                     }
        //                 }
        //             });
        //         } else {
        //             $('.wow').text("Please add correct email!");
        //             $(".newstext").fadeIn(3000);
        //             $(".newstext").fadeOut(3000);
        //         }
        //     } else {
        //         $('.wow').text("Please add email!");
        //         $(".newstext").fadeIn(3000);
        //         $(".newstext").fadeOut(3000);
        //     }
        // });

        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(
                /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+))|("[\w-\s]+")([\w-]+(?:\.[\w-]+)))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i
            );
            return pattern.test(emailAddress);
        }
    </script>
    <script>
        // SWAP VALUES
        var btn = document.getElementById("swap");
        btn.addEventListener("click", function(e) {
            var from = document.getElementById("autocomplete"),
                to = document.getElementById("autocomplete2");
            if (!!from && !!to) {
                var _ = from.value;
                from.value = to.value;
                to.value = _;
            } else {
                console.log("some input elements could not be found");
            }
        });
    </script>

    <link rel="stylesheet" href="{{ asset('assets/theme/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/custom.js') }}">
    @yield('footer')
    <x-alert />
</body>

</html>
