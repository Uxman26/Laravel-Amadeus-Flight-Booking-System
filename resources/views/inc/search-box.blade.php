<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--classic .select2-selection--multiple .select2-selection__choice {
        margin-top: 0 !important;
    }

    .select2-container .select2-search--inline .select2-search__field {
        vertical-align: top !important;
    }

    @media only screen and (max-width: 600px) {
        .mt-10 {
            margin-top: 300px !important;
        }

        .select2-dropdown {
            margin-top: 270px;
        }

    }

    @media only screen and (min-width: 601px) {
        .departure_city {
            left: 12rem;
        }

        .arrival_city {
            right: 12rem;
        }
    }

    @media only screen and (min-width: 601px) {
        .select2-dropdown {
            margin-top: 60px;
        }
    }


    .loader {
        text-align: center;
        background: white;
        width: 100%;
        height: 100% !important;
        position: fixed;
        z-index: +9999999;
        overflow: hidden;
        height: 30rem;
        margin: 0 auto;
    }

    .wait {
        margin: 5rem 0;
    }

    .iata_code {
        font-size: 6rem;
        opacity: 0.3;
        top: 52%;
        position: absolute;
        color: #0099cc;
    }



    .plane {
        position: absolute;
        width: 100%;
        left: 0px !important;
        top: 150px;
    }

    .plane-img {
        -webkit-animation: spin 2.5s linear infinite;
        -moz-animation: spin 2.5s linear infinite;
        animation: spin 2.5s linear infinite;
    }

    @-moz-keyframes spin {
        100% {
            -moz-transform: rotate(360deg);
        }
    }

    @-webkit-keyframes spin {
        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }


    .earth-wrapper {
        position: absolute;
        margin: 0 auto;
        width: 100%;
        padding-top: 1rem;
    }

    .earth {
        width: 160px;
        height: 160px;
        background: url("https://zupimages.net/up/19/34/6vlb.gif");
        border-radius: 100%;
        background-size: 340px;
        animation: earthAnim 12s infinite linear;
        margin: 0 auto;
        border: 1px solid #CDD1D3;
    }

    @keyframes earthAnim {
        0% {
            background-position-x: 0;
        }

        100% {
            background-position-x: -500px;
        }
    }

    @media screen and (max-width: 600px) {
        .departure_city {
            left: 0;
            right: 0;
            top: 20%;
            position: absolute;
            margin: 0 auto;
        }

        .arrival_city {
            left: 0;
            right: 0;
            top: 80%;
            position: absolute;
            margin: 0 auto;
        }

        .earth-wrapper {
            position: absolute;
            margin: 0 auto;
            width: 100%;
            padding-top: 13rem;
        }

        .plane {
            position: absolute;
            width: 100%;
            left: 0px !important;
            top: 22rem;
        }

    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@include('inc.calendar')
<div id="fadein">
    <form autocomplete="off" class="main_search mb-5">
        <div class="row mb-3 g-1" style="justify-content: space-between;">
            <div class="col-md-4 flight_types">,
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
                            @if (isset($data)) @if ($data['trip_type'] != 'oneway' && $data['trip_type'] != 'multi') checked @endif @else
                                checked @endif>
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
            @php
                $airlines = App\Models\Airline::get();
            @endphp
            <div class="col-md-4"></div>

            <div class="col-md-2">
                <select name="airline[]" id="airline" class="airline " multiple="multiple">
                    @foreach ($airlines as $item)
                        <option value="{{ $item->code }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                {{-- <select name="airline[]" id="airline" class="airline" multiple="multiple"></select> --}}
            </div>
            <div class="col-md-2 custom-select">
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
                                <span class="la la-plane-arrival form-icon"></span>
                                <input class="form-control autocomplete-airport focus px-5 ms-2" type="search"
                                    placeholder="To Destination" name="to" id="autocomplete2"
                                    value="{{ old('to', isset($data['to']) ? $data['to'] : '') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row g-0">
                    <div class="col" id="departDiv">
                        <div class="input-box">
                            <label class="label-text">Departure Date</label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon"></span>
                                <input class="depart form-control" id="departure" name="depart" type="text"
                                    value="{{ old('depart', isset($data['departure']) ? $data['departure'] : now()->addDays(8)->format('d-m-Y')) }}">
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
                                    value="{{ old('returning', isset($data['returning']) ? $data['returning'] : now()->addDays(16)->format('d-m-Y')) }}">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col" id="range">
                        <div class="input-box">
                            <label class="label-text">Date Range</label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon"></span>
                                <input class="date form-control border-top-l0 selector" name="daterange"
                                    type="text" id="daterange">
                            </div>
                        </div>
                    </div> --}}
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
                        @auth @if (Auth()->user()->status == 1) id="flights-search" @endif @else id="flights-search-order" @endauth
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
    {{-- loader --}}
    <div class="loader">
        <div class="wait"> Veuillez patienter svp</div>
        <div class="iata_code departure_city"></div>
        <div class="plane">
            <img src="https://zupimages.net/up/19/34/4820.gif" class="plane-img">
        </div>
        <div class="earth-wrapper">
            <div class="earth"></div>
        </div>
        <div class="iata_code arrival_city"></div>
    </div>
    {{-- loader --}}
    <!-- Include Required Prerequisites -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $('.loader').hide();

        // var select = $('.select2-search__field').val();

        // function fetchAirlines(search = '') {
        //     $.ajax({
        //         url: `/flight/airlines?search=${search}`,
        //         method: 'GET',
        //         dataType: 'json',
        //         success: function(data) {
        //             console.log(data);
        //             $('#airline').empty(); // Clear existing options
        //             data.data.forEach(airline => {
        //                 var option = $('<option></option>').val(airline.code).text(airline.name);
        //                 console.log($('#airline').append(option));
        //             });
        //         },
        //         error: function(jqXHR, textStatus, errorThrown) {
        //             console.error('Error fetching airlines:', textStatus, errorThrown);
        //         }
        //     });
        // }

        // Initial fetch
        // fetchAirlines();


        // $("#airline").on('select2:open', function() {
        //     var searchInput = $('.select2-search__field');

        //     searchInput.on('input', function() {
        //         var searchTerm = $(this).val();
        //         fetchAirlines(searchTerm);
        //         // Your custom function or logic here
        //     });
        // });

        var start = moment(); // Start date as today
        var end = moment().add(13, 'days'); // End date as 13 days from now

        $('input[name="daterange"]').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            startDate: start,
            endDate: end,
            autoApply: true
        });
        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            $('.daterangepicker').removeClass('d-flex');
            $('.daterangepicker').removeClass('mt-10');
        });
        $('input[name="daterange"]').click(function() {
            if ($('.daterangepicker').css('display') !== 'none') {
                $('.daterangepicker').addClass('d-flex');
                $('.daterangepicker').addClass('mt-10');
            } else {
                $('.daterangepicker').removeClass('d-flex');
                $('.daterangepicker').removeClass('mt-10');
            }
        })


        $("#airline").select2({
            placeholder: "Preferred QR EK EY",
            theme: "classic",
            matcher: function(params, data) {
                // If there are no search terms, return all data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') {
                    return null;
                }

                // Match the option's text with the search term
                if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1 || data.id.toUpperCase() ===
                    params.term.toUpperCase()) {
                    return $.extend({}, data, true);
                }

                // Return `null` if the term should not be displayed
                return null;
            },
            templateResult: function(data) {
                // Return the option text unchanged
                return data.text;
            }
        });
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
        $("#flights-search").click(function() {
            $('.departure_city').append($('input[name="from"]').val().split("-")[0].toUpperCase());
            $('.arrival_city').append($('input[name="to"]').val().split("-")[0].toUpperCase());
            $('.loader').show();
            $('html, body').css({
                overflow: 'hidden',
                height: '100%'
            });
            $('#flights-search').prop('disabled', true);
            setTimeout(() => {
                $('#flights-search').prop('disabled', false);
            }, 5000);
            var trip_type = $('input[name=trip]:checked').val();
            var origin = $("#autocomplete").val().toLowerCase();
            var destination = $("#autocomplete2").val().toLowerCase();
            var cdeparture = $("#departure").val();
            var returnn = $("#return").val();


            var flight_type = $("#flight_type").val().toLowerCase();
            var airline = $("#airline").val();
            if (airline == '') {
                airline = 'null';
            }
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
                $('.loader').hide();
                $('html, body').css({
                    overflow: 'auto'
                });
            } else if (destination == '') {
                alert('Please fill out destination');
                $('#autocomplete2').focus();
                $('.loader').hide();
                $('html, body').css({
                    overflow: 'auto'
                });

                // main params of get url
            } else {
                $("#loader").fadeIn("slow");
                var actionURL = 'flight' + '/';
                if (trip_type == 'oneway') {



                    var finelURL = actionURL + origin + '/' + destination + '/' + trip_type + '/' + flight_type +
                        '/' + cdeparture + '/' + adult + '/' + children + '/' + infant + '/' + airline;
                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");
                    window.location.href = "{{ env('APP_URL') }}" + finelURL;

                    // for return
                } else if (trip_type == 'return') {

                    // var id = $('input[name="daterange"]').val();
                    // var dates = id.split(" - ");
                    // var cdeparture = dates[0];
                    // var returnn = dates[1];

                    var finelURL = actionURL + origin + '/' + destination + '/' + trip_type + '/' + flight_type +
                        '/' + cdeparture + '/' + returnn + '/' + adult + '/' + children + '/' + infant + '/' +
                        airline;
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

                    var finelURL = actionURL +
                        origin + '/' + destination + '/' + departure1 + '/' +
                        origin1 + '/' + destination1 + '/' + departure2 + '/' +
                        origin2 + '/' + destination2 + '/' + departure3 + '/' +
                        origin3 + '/' + destination3 + '/' + departure4 + '/' +
                        adult + '/' + children + '/' + infant + '/' + airline;
                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");
                    window.location.href = "{{ env('APP_URL') }}" + finelURL;
                }
            }
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
                var actionURL = 'booking/create_daily_report' + '?';
                if (trip_type == 'oneway') {

                    var finelURL = actionURL + '&origin1=' + origin + '&destination1=' + destination +
                        '&trip_type=' + trip_type + '&flight_type=' + flight_type +
                        '&departureDate1=' + cdeparture + '&adult=' + adult + '&children=' + children + '&infant=' +
                        infant;
                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");
                    window.location.href = "{{ env('APP_URL') }}" + finelURL;

                    // for return
                } else if (trip_type == 'return') {

                    // var id = $('input[name="daterange"]').val();
                    // var dates = id.split(" - ");
                    // var cdeparture = dates[0];
                    // var returnn = dates[1];

                    var finelURL = actionURL + '&origin1=' + origin + '&destination1=' + destination +
                        '&trip_type=' + trip_type + '&flight_type=' + flight_type +
                        '&departureDate1=' + cdeparture + '&returnDate1=' + returnn + '&adult=' + adult +
                        '&children=' + children + '&infant=' + infant;
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

                    var finelURL = actionURL + '&origin1=' + '&trip_type=' + trip_type + '&flight_type=' +
                        flight_type +
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
        if ($("#one-way").is(':checked')) {
            $('#range').hide();
            $('#departDiv').show();
            $('#show').hide();
            document.getElementById("show").className = "col hide";
            document.getElementById("onereturn").className = "row g-1 contact-form-action";
            document.getElementById("multiway").className = "";
            document.getElementById("departure").className = "depart form-control dateleft border-top-r0";
        }
        document.getElementById("one-way").onclick = function() {
            $('#range').hide();
            $('#departDiv').show();
            $('#show').hide();
            document.getElementById("show").className = "col hide";
            document.getElementById("onereturn").className = "row g-1 contact-form-action";
            document.getElementById("multiway").className = "";
            document.getElementById("departure").className = "depart form-control";
        }
        /* return */
        if ($("#round-trip").is(':checked')) {
            $('#range').hide();
            $('#departDiv').show();
            $('#show').show();
            document.getElementById("show").className = "col hide";
            document.getElementById("onereturn").className = "row g-1 contact-form-action";
            document.getElementById("multiway").className = "";
            document.getElementById("departure").className = "depart form-control dateleft border-top-r0";
        }
        document.getElementById("round-trip").onclick = function() {
            $('#range').hide();
            $('#departDiv').show();
            $('#show').show();
            document.getElementById("show").className = "col hide";
            document.getElementById("onereturn").className = "row g-1 contact-form-action";
            document.getElementById("multiway").className = "";
            document.getElementById("departure").className = "depart form-control dateleft border-top-r0";
        }

        /* multiway */
        if ($("#multi-trip").is(':checked')) {
            $('#range').hide();
            $('#show').hide();
            $('#departDiv').show();
            document.getElementById("multiway").className = "multi-flight-wrap show_";
            document.getElementById("show").className = "col hide";
            document.getElementById("departure").className = "depart clone-departure form-control";
        }
        document.getElementById("multi-trip").onclick = function() {
            $('#range').hide();
            $('#show').hide();
            $('#departDiv').show();
            document.getElementById("multiway").className = "multi-flight-wrap show_";
            document.getElementById("show").className = "col hide";
            document.getElementById("departure").className = "depart clone-departure form-control";
        }
    </script>
</div>
