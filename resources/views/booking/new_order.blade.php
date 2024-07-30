@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aldrich">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <style>
        :root {
            --bg-image: url({{ asset('assets/banner/' . $banner->image) }});
            /* Replace $imageUrl with your actual variable */
            --news-bg: {{ option('newsbg') }};
            --news-color: {{ option('newscolor') }};
        }

        p {
            text-shadow: 0 0 7px rgba(255, 255, 255, .3), 0 0 3px rgba(255, 255, 255, .3);
        }

        .texttrans {
            color: #e5e5e5;
            font-size: 1.26rem;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Aldrich" !important;
        }

        .animation {
            height: 30px;
            overflow: hidden;
            margin-left: 0.5rem;
        }

        .animation>div>div {
            height: 2.81rem;
            margin-bottom: 2.81rem;
            display: inline-block;
        }

        .animation div:first-child {
            animation: text-animation 10s infinite;
        }

        @keyframes text-animation {
            0% {
                margin-top: 0;
            }

            10% {
                margin-top: 0;
            }

            20% {
                margin-top: -5.62rem;
            }

            30% {
                margin-top: -5.62rem;
            }

            40% {
                margin-top: -11.24rem;
            }

            60% {
                margin-top: -11.24rem;
            }

            70% {
                margin-top: -5.62rem;
            }

            80% {
                margin-top: -5.62rem;
            }

            90% {
                margin-top: 0;
            }

            100% {
                margin-top: 0;
            }
        }

        .grid {
            position: relative;
            list-style: none;
            text-align: center;
        }

        /* Common style */
        .grid figure {
            position: relative;
            float: left;
            overflow: hidden;
            background: #3085a3;
            text-align: center;
            cursor: pointer;
        }

        .grid figure img {
            position: relative;
            display: block;
            min-height: 100%;
            max-width: 100%;
            opacity: 0.8;
        }

        .grid figure figcaption {
            padding: 2em;
            color: #fff;
            text-transform: uppercase;
            font-size: 1.25em;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .grid figure figcaption::before,
        .grid figure figcaption::after {
            pointer-events: none;
        }

        .grid figure figcaption,
        .grid figure figcaption>a {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Anchor will cover the whole item by default */
        /* For some effects it will show as a button */
        .grid figure figcaption>a {
            z-index: 1000;
            text-indent: 200%;
            white-space: nowrap;
            font-size: 0;
            opacity: 0;
        }


        .grid figure p {
            letter-spacing: 1px;
            font-size: 68.5%;
        }


        /*---------------*/
        /***** Sadie *****/
        /*---------------*/

        figure.effect-sadie figcaption::before {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: -webkit-linear-gradient(top, rgba(72, 76, 97, 0) 0%, rgba(72, 76, 97, 0.8) 75%);
            background: linear-gradient(to bottom, rgba(72, 76, 97, 0) 0%, rgba(72, 76, 97, 0.8) 75%);
            content: '';
            opacity: 0;
            -webkit-transform: translate3d(0, 50%, 0);
            transform: translate3d(0, 50%, 0);
        }

        figure.effect-sadie h4 {
            position: absolute;
            top: 30%;
            left: 0;
            width: 50%;
            color: white;
            -webkit-transition: -webkit-transform 0.35s, color 0.35s;
            transition: transform 0.35s, color 0.35s;
            -webkit-transform: translate3d(0, -50%, 0);
            transform: translate3d(0, -50%, 0);
        }

        figure.effect-sadie figcaption::before,
        figure.effect-sadie p {
            -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
            transition: opacity 0.35s, transform 0.35s;
        }

        figure.effect-sadie p {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 2em;
            width: 100%;
            opacity: 0;
            -webkit-transform: translate3d(0, 10px, 0);
            transform: translate3d(0, 10px, 0);
        }

        figure.effect-sadie:hover h4 {
            color: #fff;
            -webkit-transform: translate3d(0, -50%, 0) translate3d(0, -40px, 0);
            transform: translate3d(0, -50%, 0) translate3d(0, -40px, 0);
        }

        figure.effect-sadie:hover figcaption::before,
        figure.effect-sadie:hover p {
            opacity: 1;
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }



        a {
            outline: none;
            color: #3498db;
            text-decoration: none;
        }

        a:hover,
        a:focus {
            color: #528cb3;
        }


        .content {
            margin: 0 auto;
            max-width: 1000px;
        }


        /* Header */
        .codrops-header {
            margin: 0 auto;
            padding: 4em 1em;
            text-align: center;
        }

        .codrops-header h1 {
            margin: 0;
            font-weight: 800;
            font-size: 4em;
            line-height: 1.3;
        }

        .codrops-header h1 span {
            display: block;
            padding: 0 0 0.6em 0.1em;
            color: #74777b;
            font-weight: 300;
            font-size: 45%;
        }

        /* Demo links */
        .codrops-demos {
            clear: both;
            padding: 1em 0 0;
            text-align: center;
        }

        .content+.codrops-demos {
            padding-top: 5em;
        }

        .codrops-demos a {
            display: inline-block;
            margin: 0 5px;
            padding: 1em 1.5em;
            text-transform: uppercase;
            font-weight: bold;
        }

        .codrops-demos a:hover,
        .codrops-demos a:focus,
        .codrops-demos a.current-demo {
            background: #3c414a;
            color: #fff;
        }

        /* To Navigation Style */
        .codrops-top {
            width: 100%;
            text-transform: uppercase;
            font-weight: 800;
            font-size: 0.69em;
            line-height: 2.2;
        }

        .codrops-top a {
            display: inline-block;
            padding: 1em 2em;
            text-decoration: none;
            letter-spacing: 1px;
        }

        .codrops-top span.right {
            float: right;
        }

        .codrops-top span.right a {
            display: block;
            float: left;
        }

        .codrops-icon:before {
            margin: 0 4px;
            text-transform: none;
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            font-family: 'codropsicons';
            line-height: 1;
            speak: none;
            -webkit-font-smoothing: antialiased;
        }

        .codrops-icon-drop:before {
            content: "\e001";
        }

        .codrops-icon-prev:before {
            content: "\e004";
        }

        /* Related demos */
        .related {
            clear: both;
            padding: 6em 1em;
            font-size: 120%;
        }

        .related>a {
            display: inline-block;
            margin: 20px 10px;
            padding: 25px;
            border: 1px solid #4f7f90;
            text-align: center;
        }

        .related a:hover {
            border-color: #39545e;
        }

        .related a img {
            max-width: 100%;
            opacity: 0.8;
        }

        .related a:hover img,
        .related a:active img {
            opacity: 1;
        }

        .related a h3 {
            margin: 0;
            padding: 0.5em 0 0.3em;
            max-width: 300px;
            text-align: left;
        }

        @media screen and (max-width: 25em) {
            .codrops-header {
                font-size: 75%;
            }

            .codrops-icon span {
                display: none;
            }
        }
    </style>
    <section class="breadcrumb-area bread-bg-flights">
        <section class="container" style="border-radius:10px;padding:100px 0px">
            <div class="container">
                <main class="texttrans">
                    <p>Gondal Travel New Order</p>
                    <section class="animation">
                        <div class="first">
                            <div>Dream</div>
                        </div>
                        <div class="second">
                            <div>Explore</div>
                        </div>
                        <div class="third">
                            <div>Experience</div>
                        </div>
                    </section>
                </main>
                <br>
                <div id="fadein">
                    <form autocomplete="off" class="main_search">
                        <div class="row mb-3 g-1" style="justify-content: space-between;">
                            <div class="col-md-8 flight_types">
                                <div class="row">
                                    <div class="d-flex justify-content-start gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="trip" id="one-way"
                                                onclick="oneway();" value="oneway"
                                            @if (isset($data)) @if ($data['trip_type'] == 'oneway') checked @endif
                                                 @endif>
                                            <label class="form-check-label" for="one-way">One Way</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="trip" id="round-trip" value="return"
                                                @if (isset($data)) @if ($data['trip_type'] != 'oneway' && $data['trip_type'] != 'multi') checked @endif @else checked
                                                @endif>
                                            <label class="form-check-label" for="round-trip"> Round Trip</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="trip" id="multi-trip"
                                                onclick="multiway();" value="multi"
                                                @if (isset($data)) @if ($data['trip_type'] == 'multi') checked @endif
                                                @endif>
                                            <label class="form-check-label" for="multi-trip"> Multi Way</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexible_date" id="flexible_date" >
                                    <label class="form-check-label" for="flexible_date">Flexible Date</label>
                                </div>
                            </div> --}}
                            <div class="col-md-2">
                                <select name="" id="flight_type" class="flight_type form-select form-select-sm">
                                    <option value="economy" selected>Economy</option>
                                    <option value="economy_premium">Economy Premium</option>
                                    <option value="business">Business</option>
                                    <option value="first">First</option>
                                </select>
                            </div>
                        </div>
                        <div class="row contact-form-action g-1" id="onereturn">
                            <div class="col-md-6">
                                <div class="row g-1">
                                    <div class="col-md-6">
                                        <div class="input-box input-items">
                                            <label class="label-text">Flying From</label>
                                            <div class="form-group">
                                                <span class="la la-plane-departure form-icon"></span>
                                                <input class="form-control autocomplete-airport" type="search"
                                                    placeholder="Flying From" name="from" id="autocomplete"
                                                    value="{{ old('from', isset($data['from']) ? $data['from'] : 'cdg') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box input-items">
                                            <div id="swap" class="position-absolute">
                                                <div class="swap-places  shadow">
                                                    <span class="swap-places__arrow --top">
                                                        <svg width="13" height="6" viewBox="0 0 13 6" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3 4V6L0 3L3 0V2H13V4H3Z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                    <span class="swap-places__arrow --bottom">
                                                        <svg width="13" height="6" viewBox="0 0 13 6" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3 4V6L0 3L3 0V2H13V4H3Z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <label class="label-text">To Destination</label>
                                            <div class="form-group">
                                                <span class="la la-plane-arrival form-icon mx-2"></span>
                                                <input class="form-control autocomplete-airport focus px-5" type="search"
                                                    placeholder="To Destination" name="to" id="autocomplete2"
                                                    value="{{ old('to', isset($data['to']) ? $data['to'] : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row g-0">
                                    <div class="col">
                                        <div class="input-box">
                                            <label class="label-text">Departure Date</label>
                                            <div class="form-group">
                                                <span class="la la-calendar form-icon"></span>
                                                <input class="depart form-control" id="departure" name="depart" type="text"
                                                    value="{{ old('depart',isset($data['departure'])? $data['departure']: now()->addDays(8)->format('d-m-Y')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col" id="show">
                                        <div class="input-box">
                                            <label class="label-text">Return Date</label>
                                            <div class="form-group">
                                                <span class="la la-calendar form-icon"></span>
                                                <input class="returning form-control dateright border-top-l0" name="returning"
                                                    type="text" id="return"
                                                    value="{{ old('returning',isset($data['returning'])? $data['returning']: now()->addDays(16)->format('d-m-Y')) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="input-box">
                                    <label class="label-text">Passengers </label>
                                    <div class="form-group">
                                        <div class="dropdown dropdown-contain">
                
                                            <i class="la la-user form-icon"></i>
                                            <a class="dropdown-toggle dropdown-btn travellers" href="#" role="button"
                                                data-toggle="dropdown" aria-expanded="false">
                                                <p>Travelers<span class="guest_flights"></span>
                                                </p>
                                            </a>
                
                                            <div class="dropdown-menu dropdown-menu-wrap">
                                                <div class="dropdown-item adult_qty">
                                                    <div class="qty-box d-flex align-items-center justify-content-between"
                                                        style="margin-bottom: 10px; border-bottom: 1px solid #dedede; padding-bottom: 10px;">
                                                        <label style="line-height:16px">
                                                            <i class="la la-user"></i> Adults
                                                            <div class="clear"></div>
                                                            <small style="font-size:10px">+12</small>
                                                        </label>
                                                        <div class="qtyBtn d-flex align-items-center">
                                                            <input type="text" name="adults" id="fadults"
                                                                value="{{ old('adults', isset($data['adults']) ? $data['adults'] : 1) }}"
                                                                class="qtyInput_flights">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dropdown-item child_qty">
                                                    <div class="qty-box d-flex align-items-center justify-content-between"
                                                        style="margin-bottom: 10px; border-bottom: 1px solid #dedede; padding-bottom: 10px;">
                                                        <label style="line-height:16px">
                                                            <i class="la la-female"></i> Childs
                                                            <div class="clear"></div>
                                                            <small style="font-size:10px">2 - 11</small>
                                                        </label>
                                                        <div class="qtyBtn d-flex align-items-center">
                                                            <input type="text" name="childs" id="fchilds"
                                                                value="{{ old('childs', isset($data['childs']) ? $data['childs'] : 0) }}"
                                                                class="qtyInput_flights">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dropdown-item infant_qty">
                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                        <label style="line-height:16px">
                                                            <i class="la la-female"></i> Infants
                                                            <div class="clear"></div>
                                                            <small style="font-size:10px">-2</small>
                                                        </label>
                                                        <div class="qtyBtn d-flex align-items-center">
                                                            <input type="text" name="childs" id="finfant"
                                                                value="{{ old('childs', isset($data['childs']) ? $data['childs'] : 0) }}"
                                                                class="qtyInput_flights">
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="multi-flight-wrap" id="multiway">
                                <div class="contact-form-action multi-flight-field">
                                    <div class="row g-1 contact-form-action multi_flight">
                                        <div class="col-md-6">
                                            <div class="row g-1">
                                                <div class="col-md-6">
                                                    <div class="input-box input-items">
                                                        <label class="label-text">Flying From</label>
                                                        <div class="form-group">
                                                            <span class="la la-plane-departure form-icon"></span>
                                                            <div class="autocomplete-wrapper _1 row_1">
                                                                <input class="form-control cloning-origin autocomplete-airport"
                                                                    type="search" placeholder="Flying From" name="from"
                                                                    id="autocomplete3" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-box input-items">
                                                        <label class="label-text">To Destination</label>
                                                        <div class="form-group">
                                                            <span class="la la-plane-arrival form-icon"></span>
                                                            <div class="autocomplete-wrapper _1 row_2">
                                                                <input class="form-control cloning-destination autocomplete-airport"
                                                                    type="search" placeholder="To Destination" name="to"
                                                                    id="autocomplete4" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="input-box">
                                                        <label class="label-text">Departure Date</label>
                                                        <div class="form-group">
                                                            <span class="la la-calendar form-icon"></span>
                                                            <input class="dp form-control clone-departure" id="departure"
                                                                name="depart" type="text" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col-lg-3 -->
                                        <div class="col-md-3 d-flex flight-remove"
                                            style="padding-left:10px;align-items:center;margin-top:30px">
                                            <label class="label-text">&nbsp;</label>
                                            <button class="btn multi-flight-remove d-flex align-items-center justi-content-center"
                                                type="button"><i class="la la-remove"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-lg-3 pr-0">
                                        <div class="form-group">
                                            <button class="theme-btn text-white add-flight-btn mt-4" type="button"><i
                                                    class="la la-plus mr-1"></i>Add another flight</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col-lg-3 -->
                            <div class="col-md-1">
                                <div class="btn-search text-center">
                
                                    <button
                                         id="flights-search-order" 
                                        type="button" class="more_details w-100 btn-lg effect" data-style="zoom-in">
                                        <svg style="fill:currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"
                                            class="c8LPF-icon" role="img" height="24" cleanup="">
                                            <path
                                                d="M174.973 150.594l-29.406-29.406c5.794-9.945 9.171-21.482 9.171-33.819C154.737 50.164 124.573 20 87.368 20S20 50.164 20 87.368s30.164 67.368 67.368 67.368c12.345 0 23.874-3.377 33.827-9.171l29.406 29.406c6.703 6.703 17.667 6.703 24.371 0c6.704-6.702 6.704-17.674.001-24.377zM36.842 87.36c0-27.857 22.669-50.526 50.526-50.526s50.526 22.669 50.526 50.526s-22.669 50.526-50.526 50.526s-50.526-22.669-50.526-50.526z">
                                            </path>
                                        </svg>
                                    </button>
                
                                </div>
                            </div>
                
                        </div>
                        <input type="hidden" class="form-control" name="language" id="language" value="en">
                        
                    </form>
                    
                </div>
                
               
            </div>
        </section>
    </section>
    <script>
        // URL beurify and search action
        $('.add-flight-btn').click(function() {
            if ($('.multi-flight-field').length < 3) {
                $('.multi-flight-field:last').clone().insertAfter('.multi-flight-field:last');
            }

            $(this).closest('.multi-flight-wrap').find('.multi-flight-field:last').children(
                '.multi-flight-delete-wrap').show();

            $('.date-multi-picker').daterangepicker('destroy');

            var i = 0;
            $('.date-multi-picker').each(function() {
                $this.attr('id', 'date' + i).daterangepicker({
                    opens: 'right',
                    singleDatePicker: true,
                    format: 'DD-MM-YYYY'
                });
                i++;
            });
        });
        $("#flights-search-order").click(function() {
            $('#flights-search-order').prop('disabled', true);
            setTimeout(() => {
                $('#flights-search-order').prop('disabled', false);
            }, 5000);
            var trip_type = $('input[name=trip]:checked').val();
            var origin = $("#autocomplete").val().toLowerCase();
            var destination = $("#autocomplete2").val().toLowerCase();
            var cdeparture = $("#departure").val();
            var returnn = $("#return").val();
            var flight_type = $("#flight_type").val().toLowerCase();
            var adult = $("#fadults").val();
            var children = $("#fchilds").val();
            var infant = $("#finfant").val();
            var language = $('#language').val();
            var origin_split = origin.split(' ');
            var origin = origin_split[0];
            var destination_split = destination.split(' ');
            var destination = destination_split[0];
            if (origin == '') {
                alert('Please fill out origin');
                $('#autocomplete').focus();
            } else if (destination == '') {
                alert('Please fill out destination');
                $('#autocomplete2').focus();

                // main params of get url
            } else {
                $("#loader").fadeIn("slow");
                var actionURL = 'create_daily_report' + '?';
                if (trip_type == 'oneway') {
                    var finelURL = actionURL + '&origin1=' + origin + '&destination1=' + destination + '&trip_type=' + trip_type + '&flight_type=' + flight_type +
                        '&departureDate1=' + cdeparture + '&adult=' + adult + '&children=' + children + '&infant=' + infant;
                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");
                    window.location.href = "{{ env('APP_URL') }}" + finelURL;

                    // for return
                } else if (trip_type == 'return') {
                    var finelURL = actionURL + '&origin1=' + origin + '&destination1=' + destination + '&trip_type=' + trip_type + '&flight_type=' + flight_type +
                        '&departureDate1=' + cdeparture + '&returnDate1=' + returnn + '&adult=' + adult + '&children=' + children + '&infant=' + infant;
                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");
                    window.location.href = "{{ env('APP_URL') }}" + finelURL;

                    // for multi way
                } else {
                    // getting all origins
                    var origins = document.querySelectorAll('.cloning-origin');
                    var allOrigins = [];

                    origins.forEach(function(origin) {
                        allOrigins.push(origin.value);
                    });

                    // Access the values
                    var origin = $("#autocomplete").val().toLowerCase();
                    var origin1 = allOrigins[0];
                    var origin2 = allOrigins[1];
                    var origin3 = allOrigins[2];

                    var origin_split = origin.split(' ');
                    var origin = origin_split[0];
                    var origin1_split = origin1.split(' ');
                    var origin1 = origin1_split[0];



                    // getting all destinations
                    var destinations = document.querySelectorAll('.cloning-destination');
                    var allDestinations = [];

                    destinations.forEach(function(destination) {
                        allDestinations.push(destination.value);
                    });

                    // Access the values
                    var destination = $("#autocomplete2").val().toLowerCase();
                    var destination1 = allDestinations[0];
                    var destination2 = allDestinations[1];
                    var destination3 = allDestinations[2];

                    var destination_split = destination.split(' ');
                    var destination = destination_split[0];
                    var destination1_split = destination1.split(' ');
                    var destination1 = destination1_split[0];



                    // getting all departuredate
                    var departures = document.querySelectorAll('.clone-departure');
                    var alldepartureDates = [];

                    departures.forEach(function(departure) {
                        alldepartureDates.push(departure.value);
                    });

                    var departure1 = alldepartureDates[0];
                    var departure2 = alldepartureDates[1];
                    var departure3 = alldepartureDates[2];
                    var departure4 = alldepartureDates[3];

                    var departure1_split = departure1.split(' ');
                    var departure1 = departure1_split[0];
                    var departure2_split = departure2.split(' ');
                    var departure2 = departure2_split[0];



                    if (origin2) {
                        var origin2_split = origin2.split(' ');
                        var origin2 = origin2_split[0];
                        var destination2_split = destination2.split(' ');
                        var destination2 = destination2_split[0];
                        var departure3_split = departure3.split(' ');
                        var departure3 = departure3_split[0];
                    } else {
                        origin2 = null;
                        destination2 = null;
                        departure3 = null;
                    }
                    if (origin3) {
                        var origin3_split = origin3.split(' ');
                        var origin3 = origin3_split[0];
                        var destination3_split = destination3.split(' ');
                        var destination3 = destination3_split[0];
                        var departure4_split = departure4.split(' ');
                        var departure4 = departure4_split[0];
                    } else {
                        origin3 = null;
                        destination3 = null;
                        departure4 = null;
                    }

                    var finelURL = actionURL + '&origin1=' + '&trip_type=' + trip_type + '&flight_type=' + flight_type +
                        origin + '&destination1=' + destination + '&departureDate1=' + departure1 + '&origin2=' +
                        origin1 + '&destination2=' + destination1 + '&departureDate2=' + departure2 + '&origin3=' +
                        origin2 + '&destination3=' + destination2 + '&departureDate3=' + departure3 + '&origin4=' +
                        origin3 + '&destination4=' + destination3 + '&departureDate4=' + departure4 + '&adult=' +
                        adult + '&children=' + children + '&infant=' + infant;
                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");
                    window.location.href = "{{ env('APP_URL') }}" + finelURL;
                }
            }
        });

        /* oneway */
        document.getElementById("one-way").onclick = function() {
            document.getElementById("show").className = "col hide";
            document.getElementById("onereturn").className = "row g-1 contact-form-action";
            document.getElementById("multiway").className = "";
            document.getElementById("departure").className = "depart form-control";
        }
        /* return */
        if ($("#round-trip").is(':checked')) {
            document.getElementById("show").className = "col show_";
            document.getElementById("onereturn").className = "row g-1 contact-form-action";
            document.getElementById("multiway").className = "";
            document.getElementById("departure").className = "depart form-control dateleft border-top-r0";
        }
        document.getElementById("round-trip").onclick = function() {
            document.getElementById("show").className = "col show_";
            document.getElementById("onereturn").className = "row g-1 contact-form-action";
            document.getElementById("multiway").className = "";
            document.getElementById("departure").className = "depart form-control dateleft border-top-r0";
        }

        /* multiway */
        if ($("#multi-trip").is(':checked')) {
            document.getElementById("multiway").className = "multi-flight-wrap show_";
            document.getElementById("show").className = "col hide";
            document.getElementById("departure").className = "depart clone-departure form-control";
        }
        document.getElementById("multi-trip").onclick = function() {
            document.getElementById("multiway").className = "multi-flight-wrap show_";
            document.getElementById("show").className = "col hide";
            document.getElementById("departure").className = "depart clone-departure form-control";
        }
    </script>
@endsection
