@extends('layouts.app')
@section('head')
    <script src="{{ asset('assets/theme/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('assets/theme/js/mixitup-pagination.min.js') }}"></script>
    <script src="{{ asset('assets/theme/js/mixitup-multifilter.min.js') }}"></script>
    <script src="{{ asset('assets/theme/js/plugins/ion.rangeSlider.min.js') }}"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <style>
        .bg-success-light {
            background: rgba(0, 227, 0, 0.385);
        }

        .hover-container {
            position: relative;
        }

        .hover-target {
            position: relative;
        }

        .span {
            min-width: 100px !important;
        }

        hr {
            border: 1px solid #ffffff !important;
            padding: 0;
            margin: 0;
        }

        .hover-popup {
            position: absolute;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            top: 70%;
            width: 300px;
            left: 0;
            margin-left: -300px !important;
            margin-top: -100px !important;
            margin: min(1rem, 20px);
            font-size: .8rem;
            background-color: #343434;
            border-radius: 8px;
            padding: 1em;
            z-index: 9999;
            transform: scale(0);
            transition: transform 200ms ease;
            transform-origin: 8% -10px;
        }

        .hover-target:hover+.hover-popup,
        .hover-target:focus+.hover-popup,
        .hover-popup:hover {
            transform: scale(1);
        }

        .hover-popup :not(:first-child) {
            margin-top: 1rem;
        }

        .hover-popup::after {
            /* This is merely here to expand the hoverable area, as a buffer between the "Hover me" text and the popup. */
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: -1rem;
            left: 0;
            z-index: 9999;
        }
        @media (prefers-reduced-motion: reduce) {

            *,
            ::before,
            ::after {
                animation-delay: -1ms !important;
                animation-duration: -1ms !important;
                animation-iteration-count: 1 !important;
                background-attachment: initial !important;
                scroll-behavior: auto !important;
                transition-duration: 0s !important;
                transition-delay: 0s !important;
            }
        }
    </style>
    @livewireStyles()
@endsection
{{-- @include('inc.loader') --}}
@section('content')

    @include('inc.search-nav')
    <main class="cd-main-content container mt-3">
        <div class="row g-3">
            @include('inc.filter-bar')
            <div class="col-md-9">
                <section data-ref="container" id="data">
                    <div class="flight-search-box mb-3" id="flightSearchBox">
                        @include('inc.search-box')
                    </div>
                    <div class="next-date-panel mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between gap-2 align-items-center">
                                    @if ($data['trip_type'] == 'return')
                                        <a href="{{ route('flight.search.return', $data['backDayRoute']) }}"
                                            class="btn btn-primary">Previews Date <i class="la la-angle-right"></i></a>
                                        <a href="{{ route('flight.search.return', $data['nextDayRoute']) }}"
                                            class="btn btn-primary">Next Date <i class="la la-angle-right"></i></a>
                                    @elseif($data['trip_type'] == 'multi')
                                    @else
                                        <a href="{{ route('flight.search.oneway', $data['backDayRoute']) }}"
                                            class="btn btn-primary">Previews Date <i class="la la-angle-right"></i></a>
                                        <a href="{{ route('flight.search.oneway', $data['nextDayRoute']) }}"
                                            class="btn btn-primary">Next Date <i class="la la-angle-right"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="catalog-panel">
                        @foreach ($allFlights as $flight)
                            @php
                                $copyFlightData = 'Hi Dear @ ';
                                $copyFlightData .= 'Your ' . $data['trip_type'] . ' Flight  Itinerary @ ';
                                if (
                                    isset($flight['travelerPricings'][0]['fareDetailsBySegment'][0]['amenities']) &&
                                    isset($flight['travelerPricings'][0]['fareDetailsBySegment'][0]['amenities'][3]) &&
                                    isset(
                                        $flight['travelerPricings'][0]['fareDetailsBySegment'][0]['amenities'][3][
                                            'isChargeable'
                                        ],
                                    )
                                ) {
                                    $isRefundable =
                                        $flight['travelerPricings'][0]['fareDetailsBySegment'][0]['amenities'][3][
                                            'isChargeable'
                                        ];
                                } else {
                                    $isRefundable = false;
                                }
                            @endphp
                            @php
                            $infantPrice = 0;
                            $childPrice = 0;
                            $adultPrice = 0;
                            $infants = 0;
                            $childs = 0;
                            $adults = 0;
                            foreach ($flight['travelerPricings'] as $pricings) {
                                if ($pricings['travelerType'] == 'INFANT' || $pricings['travelerType'] == 'HELD_INFANT') {
                                    $infants += 1;
                                    $infantPrice = $pricings['price']['total'];
                                } elseif ($pricings['travelerType'] == 'CHILD') {
                                    $childs += 1;
                                    $childPrice = $pricings['price']['total'];
                                } elseif ($pricings['travelerType'] == 'ADULT') {
                                    $adults += 1;
                                    $adultPrice = $pricings['price']['total'];
                                }
                            }
                        @endphp
                            <li class="mix all qr oneway_1" data-a="503" data-b=""
                                data-price="{{ $flight['price']['grandTotal'] }}"
                                data-stops="{{ count($flight['itineraries'][0]['segments']) - 1 }}"
                                data-flights="{{ $flight['validatingAirlineCodes'][0] }}">
                                <div
                                    class="theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-">
                                    <div class="row g-0">
                                        <div class="col-md-10">
                                            @foreach ($flight['itineraries'] as $itineraries)
                                                <div id="theme-search-results-item-preview{{ $loop->parent->index }}{{ $loop->index }}"
                                                    class="theme-search-results-item-preview @if ( isset($flight['itineraries'][$loop->index]['duration']) && (int) explode(':', getDuration($flight['itineraries'][$loop->index]['duration']), 3)[0] < 17) bg-success-light @endif">
                                                    <div class="theme-search-results-item-mask-link"
                                                        data-bs-toggle="collapse"
                                                        href="#searchResultsItem-{{ $loop->parent->index }}"
                                                        role="button"></div>
                                                    <div class="row" data-gutter="20">
                                                        <div class="col-md-12">
                                                            <div class="theme-search-results-item-flight-sections">
                                                                <div class="theme-search-results-item-flight-section">
                                                                    <div class="row-no-gutter row-eq-height row">
                                                                        <div class="col-md-2 col-12">
                                                                            <div class="theme-search-results-item-flight-section-airline-logo-wrap"
                                                                                style="border-radius: 5px;">
                                                                                @php
                                                                                    $flightCode =
                                                                                        $itineraries['segments'][0][
                                                                                            'carrierCode'
                                                                                        ];
                                                                                @endphp
                                                                                <div
                                                                                    class="d-md-block d-flex justify-content-around">
                                                                                    <h5 class="theme-search-results-item-flight-section-airline-title mb-0"
                                                                                        style="margin-top:3px">
                                                                                        <b>{{ findAirlineName($flightCode) }}</b>
                                                                                    </h5>
                                                                                    <img class="theme-search-results-item-flight-section-airline-logo lazyload"
                                                                                        style="background:transparent"
                                                                                        data-src="https://assets.kplus.com.tr/images/airline/180x60/logo_{{ $flightCode }}.png">
                                                                                    <h5 class="theme-search-results-item-flight-section-airline-title mb-0"
                                                                                        style="margin-top:44px">
                                                                                        @foreach ($itineraries['segments'] as $segment)
                                                                                            <strong>{{ $flightCode }} -
                                                                                                {{ $segment['number'] }}
                                                                                                (@foreach ($flight['travelerPricings'][0]['fareDetailsBySegment'] as $fareSegment)
                                                                                                    @if ($fareSegment['segmentId'] == $segment['id'] && isset($fareSegment['class']))
                                                                                                        {{ $fareSegment['class'] }}
                                                                                                        {{-- @else
                                                                                                        0 --}}
                                                                                                    @endif
                                                                                                @endforeach)
                                                                                            </strong><br>
                                                                                        @endforeach
                                                                                    </h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-8 col-12">
                                                                            <div
                                                                                class="theme-search-results-item-flight-section-item">
                                                                                <div class="row">
                                                                                    <div class="col-md-3 col-3">
                                                                                        <div
                                                                                            class="theme-search-results-item-flight-section-meta mb-0">
                                                                                            <p
                                                                                                class="theme-search-results-item-flight-section-meta-time mb-1">
                                                                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $itineraries['segments'][0]['departure']['at'])->format('H:i') }}
                                                                                                {{ $itineraries['segments'][0]['departure']['iataCode'] }}
                                                                                            </p>
                                                                                            <p
                                                                                                class="theme-search-results-item-flight-section-meta-time text-primary mb-1">
                                                                                                {{ findCityName($itineraries['segments'][0]['departure']['iataCode']) }}
                                                                                            </p>
                                                                                            @php
                                                                                                $copyFlightData .= findCityName(
                                                                                                    $itineraries[
                                                                                                        'segments'
                                                                                                    ][0]['departure'][
                                                                                                        'iataCode'
                                                                                                    ],
                                                                                                );
                                                                                            @endphp
                                                                                            <p class=" mb-1">
                                                                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $itineraries['segments'][0]['departure']['at'])->format('d M Y') }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6 col-6 g-0">
                                                                                        <div
                                                                                            class="theme-search-results-item-flight-section-path mb-0">
                                                                                            <div
                                                                                                class="theme-search-results-item-flight-section-path-fly-time">
                                                                                                @if (isset($flight['itineraries'][$loop->index]['duration']))
                                                                                                    <p><strong>Duration
                                                                                                            {{ getDuration($flight['itineraries'][$loop->index]['duration']) }}</strong>
                                                                                                    </p>
                                                                                                @endif
                                                                                            </div>
                                                                                            <div
                                                                                                class="theme-search-results-item-flight-section-path-line">
                                                                                            </div>
                                                                                            <div
                                                                                                class="theme-search-results-item-flight-section-path-line-start">
                                                                                                <i
                                                                                                    class="la la-plane-departure theme-search-results-item-flight-section-path-icon"></i>
                                                                                                <div
                                                                                                    class="theme-search-results-item-flight-section-path-line-dot">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="theme-search-results-item-flight-section-path-line-title">
                                                                                                    {{ $itineraries['segments'][0]['departure']['iataCode'] }}
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="theme-search-results-item-flight-section-path-line-middle">
                                                                                                <div class="theme-search-results-item-flight-section-path-line-title"
                                                                                                    style="margin-top:35px;color:#000;font-weight:bold;width:40px">
                                                                                                    <strong>Stops
                                                                                                        {{ count($itineraries['segments']) - 1 }}</strong>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="theme-search-results-item-flight-section-path-line-end">
                                                                                                <i
                                                                                                    class="la la-plane-arrival theme-search-results-item-flight-section-path-icon"></i>
                                                                                                <div
                                                                                                    class="theme-search-results-item-flight-section-path-line-dot">
                                                                                                </div>
                                                                                                <div
                                                                                                    class="theme-search-results-item-flight-section-path-line-title">
                                                                                                    {{ end($itineraries['segments'])['arrival']['iataCode'] }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3 col-3">
                                                                                        <div
                                                                                            class="theme-search-results-item-flight-section-meta mb-0">
                                                                                            <p
                                                                                                class="theme-search-results-item-flight-section-meta-time mb-1">
                                                                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', end($itineraries['segments'])['arrival']['at'])->format('H:i') }}
                                                                                                {{ end($itineraries['segments'])['arrival']['iataCode'] }}
                                                                                            </p>
                                                                                            <p
                                                                                                class="theme-search-results-item-flight-section-meta-time text-primary mb-1">
                                                                                                {{ findCityName(end($itineraries['segments'])['arrival']['iataCode']) }}
                                                                                            </p>
                                                                                            @php
                                                                                                $copyFlightData .=
                                                                                                    '-' .
                                                                                                    findCityName(
                                                                                                        end(
                                                                                                            $itineraries[
                                                                                                                'segments'
                                                                                                            ],
                                                                                                        )['arrival'][
                                                                                                            'iataCode'
                                                                                                        ],
                                                                                                    ) .
                                                                                                    ' ';
                                                                                                if ($loop->index < 1) {
                                                                                                    $copyFlightData .=
                                                                                                        'For ' .
                                                                                                        $data['adult'] +
                                                                                                        $data[
                                                                                                            'children'
                                                                                                        ] +
                                                                                                        $data[
                                                                                                            'infant'
                                                                                                        ] .
                                                                                                        ' Traveler @ ';
                                                                                                }
                                                                                                $copyFlightData .=
                                                                                                    'Departure: ' .
                                                                                                    $itineraries[
                                                                                                        'segments'
                                                                                                    ][0]['departure'][
                                                                                                        'iataCode'
                                                                                                    ] .
                                                                                                    ' ' .
                                                                                                    \Carbon\Carbon::createFromFormat(
                                                                                                        'Y-m-d\TH:i:s',
                                                                                                        $itineraries[
                                                                                                            'segments'
                                                                                                        ][0][
                                                                                                            'departure'
                                                                                                        ]['at'],
                                                                                                    )->format(
                                                                                                        'd M H:i',
                                                                                                    ) .
                                                                                                    ' @ ';
                                                                                                $copyFlightData .=
                                                                                                    'Arrival: ' .
                                                                                                    end(
                                                                                                        $itineraries[
                                                                                                            'segments'
                                                                                                        ],
                                                                                                    )['arrival'][
                                                                                                        'iataCode'
                                                                                                    ] .
                                                                                                    ' ' .
                                                                                                    \Carbon\Carbon::createFromFormat(
                                                                                                        'Y-m-d\TH:i:s',
                                                                                                        end(
                                                                                                            $itineraries[
                                                                                                                'segments'
                                                                                                            ],
                                                                                                        )['arrival'][
                                                                                                            'at'
                                                                                                        ],
                                                                                                    )->format(
                                                                                                        'd M H:i',
                                                                                                    ) .
                                                                                                    ' @ ';
                                                                                                if (
                                                                                                    isset(
                                                                                                        $flight[
                                                                                                            'itineraries'
                                                                                                        ][$loop->index][
                                                                                                            'duration'
                                                                                                        ],
                                                                                                    )
                                                                                                ) {
                                                                                                    $copyFlightData .=
                                                                                                        'Duration: ' .
                                                                                                        getCustomDuration(
                                                                                                            $flight[
                                                                                                                'itineraries'
                                                                                                            ][
                                                                                                                $loop
                                                                                                                    ->index
                                                                                                            ][
                                                                                                                'duration'
                                                                                                            ],
                                                                                                        ) .
                                                                                                        ' @ ';
                                                                                                }
                                                                                            @endphp
                                                                                            <p class="">
                                                                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', end($itineraries['segments'])['arrival']['at'])->format('d M Y') }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="text-center">
                                                                                        <p class="d-none"
                                                                                            id="layover{{ $loop->parent->index }}{{ $loop->index }}">
                                                                                            Layover: <span
                                                                                                class="connectingTime{{ $loop->parent->index }}{{ $loop->index }}"
                                                                                                id="connectingTime{{ $loop->parent->index }}{{ $loop->index }}"></span>
                                                                                        </p>
                                                                                        <p
                                                                                            id="direct{{ $loop->parent->index }}{{ $loop->index }}">
                                                                                            Direct
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-12">
                                                                            <div
                                                                                class="d-md-block d-flex justify-content-around">
                                                                                <p class="d-flex align-items-center"
                                                                                    style="gap:6px"><img
                                                                                        src="{{ asset('assets/img/seat.png') }}"
                                                                                        width="20" alt="Seat">
                                                                                    @if (isset($flight['numberOfBookableSeats']))
                                                                                        {{ $flight['numberOfBookableSeats'] }}
                                                                                    @endif
                                                                                </p>
                                                                                <p class="d-flex align-items-center"
                                                                                    style="gap:6px"><i
                                                                                        style="font-size:22px"
                                                                                        class="la la-passport"></i>
                                                                                    {{ $flight['travelerPricings'][0]['fareDetailsBySegment'][0]['cabin'] ?? '0' }}
                                                                                </p>
                                                                                <p class="d-flex align-items-center"
                                                                                    style="gap:6px"><i
                                                                                        style="font-size:22px"
                                                                                        class="la la-suitcase-rolling"></i>
                                                                                    {{ $flight['travelerPricings'][0]['fareDetailsBySegment'][0]['includedCheckedBags']['weight'] ?? $flight['travelerPricings'][0]['fareDetailsBySegment'][0]['includedCheckedBags']['quantity'] }}
                                                                                    {{ $flight['travelerPricings'][0]['fareDetailsBySegment'][0]['includedCheckedBags']['weightUnit'] ?? 'Bag' }}
                                                                                </p>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @php
                                                $copyFlightData .=
                                                    'Total Price: ' .
                                                    commission($flight['price']['grandTotal'], $adults + $infants + $childs) .
                                                    ' ' .
                                                    $flight['price']['currency'] .
                                                    ' @ ';
                                                $copyFlightData .= 'Thanks';
                                            @endphp
                                            <div class="collapse theme-search-results-item-collapse"
                                                id="searchResultsItem-{{ $loop->index }}">
                                                <div class="theme-search-results-item-extend">
                                                    <div class="theme-search-results-item-extend-close"
                                                        data-bs-toggle="collapse" href="#searchResultsItem-0"
                                                        role="button">&#10005;</div>
                                                    @php
                                                        $oldDate = '';
                                                    @endphp
                                                    @foreach ($flight['itineraries'] as $itineraries)
                                                        @foreach ($itineraries['segments'] as $segment)
                                                            @if ($oldDate != '')
                                                                <div class="text-center">
                                                                    Connecting Time:
                                                                    {{ getConnectingTime($oldDate, $segment['departure']['at']) }}
                                                                    <input type="hidden"
                                                                        id="getConnectingTime{{ $loop->parent->parent->index }}{{ $loop->parent->index }}{{ $loop->index }}"
                                                                        value="{{ getConnectingTime($oldDate, $segment['departure']['at']) }}">
                                                                </div>
                                                            @endif
                                                            <div class="theme-search-results-item-extend-inner">
                                                                <div class="theme-search-results-item-flight-detail-items">
                                                                    <div class="theme-search-results-item-flight-details">
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div style="display: nonee;"
                                                                                    class="theme-search-results-item-flight-details-info p-3">
                                                                                    <h5
                                                                                        class="theme-search-results-item-flight-details-info-title">
                                                                                        From</h5>
                                                                                    <p
                                                                                        class="theme-search-results-item-flight-details-info-date">
                                                                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $segment['departure']['at'])->format('d M Y') }}
                                                                                    </p>
                                                                                    <p
                                                                                        class="theme-search-results-item-flight-details-info-cities">
                                                                                        {{ $segment['departure']['iataCode'] }}
                                                                                    </p>
                                                                                    <p
                                                                                        class="theme-search-results-item-flight-details-info-fly-time">
                                                                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $segment['departure']['at'])->format('h:i') }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <div
                                                                                    class="theme-search-results-item-flight-details-schedule">
                                                                                    <ul
                                                                                        class="theme-search-results-item-flight-details-schedule-list">
                                                                                        <li>
                                                                                            <i
                                                                                                class="la la-plane theme-search-results-item-flight-details-schedule-icon"></i>
                                                                                            <div
                                                                                                class="theme-search-results-item-flight-details-schedule-dots">
                                                                                            </div>
                                                                                            <p
                                                                                                class="theme-search-results-item-flight-details-schedule-date">
                                                                                                To
                                                                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $segment['arrival']['at'])->format('d M Y') }}
                                                                                            </p>
                                                                                            <div class="row">
                                                                                                <div class="col-6">
                                                                                                    <div
                                                                                                        class="theme-search-results-item-flight-details-schedule-time">
                                                                                                        <span
                                                                                                            class="theme-search-results-item-flight-details-schedule-time-item">
                                                                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $segment['departure']['at'])->format('H:i') }}
                                                                                                        </span>
                                                                                                        <span
                                                                                                            class="theme-search-results-item-flight-details-schedule-time-separator">-</span>
                                                                                                        <span
                                                                                                            class="theme-search-results-item-flight-details-schedule-time-item">
                                                                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $segment['arrival']['at'])->format('H:i') }}
                                                                                                        </span>
                                                                                                    </div>

                                                                                                    <div
                                                                                                        class="theme-search-results-item-flight-details-schedule-destination">
                                                                                                        <div
                                                                                                            class="theme-search-results-item-flight-details-schedule-destination-item">
                                                                                                            <p
                                                                                                                class="theme-search-results-item-flight-details-schedule-destination-title">
                                                                                                                <b>{{ $segment['departure']['iataCode'] }}</b>
                                                                                                                {{ $segment['departure']['iataCode'] }}
                                                                                                            </p>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="theme-search-results-item-flight-details-schedule-destination-separator">
                                                                                                            <span>&#8594;</span>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="theme-search-results-item-flight-details-schedule-destination-item">
                                                                                                            <p
                                                                                                                class="theme-search-results-item-flight-details-schedule-destination-title">
                                                                                                                <b>{{ $segment['arrival']['iataCode'] }}</b>
                                                                                                                {{ $segment['arrival']['iataCode'] }}
                                                                                                            </p>
                                                                                                            <p
                                                                                                                class="theme-search-results-item-flight-details-schedule-destination-city">
                                                                                                            </p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <ul
                                                                                                        class="theme-search-results-item-flight-details-schedule-features">
                                                                                                        <li>{{ $segment['carrierCode'] }}
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="col-6 flight_desc">
                                                                                                    <p class="d-flex align-items-center"
                                                                                                        style="gap:6px"><i
                                                                                                            style="font-size:22px"
                                                                                                            class="la la-passport"></i>
                                                                                                        <strong>Flight
                                                                                                            Class</strong>
                                                                                                        {{ $flight['travelerPricings'][0]['fareDetailsBySegment'][0]['cabin'] }}
                                                                                                        @foreach ($flight['travelerPricings'][0]['fareDetailsBySegment'] as $fareSegment)
                                                                                                            @if ($fareSegment['segmentId'] == $segment['id'] && isset($fareSegment['class']))
                                                                                                                {{ $fareSegment['class'] }}
                                                                                                            @else
                                                                                                                0
                                                                                                            @endif
                                                                                                        @endforeach
                                                                                                    </p>
                                                                                                    <p class="d-flex align-items-center"
                                                                                                        style="gap:6px"><i
                                                                                                            style="font-size:20px"
                                                                                                            class="la la-history"></i>
                                                                                                        @if (isset($itineraries['segments'][$loop->index]['duration']))
                                                                                                            <strong> Trip
                                                                                                                Duration
                                                                                                            </strong>
                                                                                                            {{ getDuration($itineraries['segments'][$loop->index]['duration']) }}
                                                                                                        @endif
                                                                                                    </p>

                                                                                                    <p class="d-flex align-items-center"
                                                                                                        style="gap:6px"><i
                                                                                                            style="font-size:22px"
                                                                                                            class="la la-suitcase-rolling"></i> 
                                                                                                        <strong>Baggage
                                                                                                        </strong>
                                                                                                        {{ $flight['travelerPricings'][0]['fareDetailsBySegment'][0]['includedCheckedBags']['weight'] ?? $flight['travelerPricings'][0]['fareDetailsBySegment'][0]['includedCheckedBags']['quantity'] }}
                                                                                                        {{ $flight['travelerPricings'][0]['fareDetailsBySegment'][0]['includedCheckedBags']['weightUnit'] ?? 'Bag' }}
                                                                                                    </p>
                                                                                                    <hr>
                                                                                                    <p> </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $oldDate = $segment['arrival']['at'];
                                                            @endphp
                                                        @endforeach
                                                        <div class="text-center">
                                                            @if ($data['trip_type'] == 'return' && !$loop->last)
                                                                @php
                                                                    $oldDate = '';
                                                                @endphp
                                                                <b><span style="font-size: 20px;">Return Ticket</span></b>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            @csrf
                                            <div class="theme-search-results-item-book row">
                                                <form id="book_now_form{{ $loop->index }}"
                                                    action="{{ route('flight.search.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="routes" id="routes"
                                                        value="{{ json_encode($flight) }}">
                                                    <input type="hidden" name="amount"
                                                        value="{{ $flight['price']['grandTotal'] }}">
                                                    <input type="hidden" name="currency"
                                                        value="{{ $flight['price']['currency'] }}">
                                                    <input type="hidden" name="adult" value="{{ $data['adult'] }}">
                                                    <input type="hidden" name="children"
                                                        value="{{ $data['children'] }}">
                                                    <input type="hidden" name="infant" value="{{ $data['infant'] }}">
                                                    <input type="hidden" name="trip_type"
                                                        value="{{ $data['trip_type'] }}">
                                                    <input type="hidden" name="uri" value="{{ url()->current() }}">
                                                </form>
                                                <div class="d-md-block d-flex pe-3 ps-3 p-md-0">
                                                    <p style="font-size: 15px"
                                                        class="d-none d-md-flex align-items-center justify-content-center @if (!$isRefundable) text-danger @endif">
                                                        <b>
                                                            @if ($isRefundable)
                                                                Refundable
                                                            @else
                                                                Non Refundable
                                                            @endif
                                                        </b>
                                                    </p>
                                                    
                                                    <button class="btn btn-block submitButton" data-style="zoom-in">
                                                        <p style="font-size: 10px;"
                                                            class="d-flex pt-2 d-md-none @if (!$isRefundable) text-danger @endif">
                                                            <b>
                                                                @if ($isRefundable)
                                                                    Refundable
                                                                @else
                                                                    Non Refundable
                                                                @endif
                                                            </b>

                                                        </p>
                                                        <div class="d-flex justify-content-center text-dark">
                                                            <strong>{{ $flight['price']['currency'] }}
                                                                {{ commission($flight['price']['grandTotal'], $adults + $infants + $childs) }}
                                                            </strong>

                                                            <div class="hover-container d-none d-md-block">
                                                                <i tabindex="0"
                                                                    class="hover-target la la-info-circle ml-2 text-info"></i>
                                                                <aside class="hover-popup text-white text-start">
                                                                    @if ($adults != 0)
                                                                        <p><span class="span">{{ $adults }} <i
                                                                                    class="la la-times"></i>
                                                                                Adult</span> <span
                                                                                class="ms-3 span"><b>{{ $adultPrice }}
                                                                                    EUR</b></span><span
                                                                                class="ms-3 span"><b>{{ $adultPrice * $adults }}
                                                                                    EUR</b></span></p>
                                                                        <hr>
                                                                    @endif
                                                                    @if ($childs != 0)
                                                                        <p><span class="span">{{ $childs }} <i
                                                                                    class="la la-times"></i>
                                                                                Child</span> <span
                                                                                class="ms-3 span"><b>{{ $childPrice }}
                                                                                    EUR</b></span><span
                                                                                class="ms-3 span"><b>{{ $childPrice * $childs }}
                                                                                    EUR</b></span></p>
                                                                        <hr>
                                                                    @endif
                                                                    @if ($infants != 0)
                                                                        <p><span class="span">{{ $infants }} <i
                                                                                    class="la la-times"></i>
                                                                                Infant</span> <span
                                                                                class="ms-3 span"><b>{{ $infantPrice }}
                                                                                    EUR</b></span><span
                                                                                class="ms-3 span"><b>{{ $infantPrice * $infants }}
                                                                                    EUR</b></span></p>
                                                                        <hr>
                                                                    @endif
                                                                </aside>
                                                            </div>
                                                        </div>
                                                        <span class="btn btn-primary"
                                                            onclick="confirmSubmit('{{ json_encode($flight) }}', '{{ $flight['price']['grandTotal'] }}', '{{ $loop->index }}')">Book
                                                            Now <i class="la la-angle-right"></i></span>
                                                    </button>
                                                    <p class="d-flex align-items-center justify-content-center"><a
                                                            onclick="copyData('{{ $copyFlightData }}')"
                                                            href="javascript:;"><i style="font-size:22px"
                                                                class="las la-clipboard"></i>Copy</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>
            </div>
        </div>
    </main>
    <input type="hidden" name="allFlights" value="{{ json_encode($allFlights) }}">
@endsection
@section('footer')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        // $('html, body').css({
        //         overflow: 'hidden'
        //     });
        //   document.addEventListener("DOMContentLoaded", function() {
        //     setTimeout(function() {
        //         $("#loaderCustom").fadeOut("slow");
        //         $('html, body').css({
        //             overflow: 'auto'
        //         });
        //     }, 10000);
        // })

        function confirmSubmit(route, price, loopindex) {
            // id = "book_now_form"+loopindex;
            // document.getElementById(id).submit();
            // $("#loaderCustom").fadeIn("slow");
            $('html, body').css({
                overflow: 'hidden'
            });
            var postData = {
                routes: route
            };
            // AJAX POST request
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('flight/search/verify_price') }}",
                type: 'POST',
                data: postData,
                success: function(response) {
                    // Handle the successful response here
                    console.log(response);
                    id = "book_now_form" + loopindex;
                    console.log(response);
                    if (response.status) {
                        if (response.price != price) {
                            if (confirm('New Price is : ' + response.price)) {
                                document.getElementById(id).submit();
                            } else {
                                location.reload();
                            }
                        } else {
                            // $("#loaderCustom").fadeOut("slow");
                            // $('html, body').css({
                            //     overflow: 'auto'
                            // });
                            document.getElementById(id).submit();
                        }
                    } else {
                        // $("#loaderCustom").fadeOut("slow");
                        // $('html, body').css({
                        //     overflow: 'auto'
                        // });
                        alert('Error on Attempt to Verify Price');
                    }
                },
                error: function(error) {
                    // Handle errors here
                    console.log(error);
                    // $("#loaderCustom").fadeOut("slow");
                }
            });
        }

        $("#slider-range").slider({
            range: true,
            min: {{ $data['minPrice'] }},
            max: {{ $data['maxPrice'] }},
            values: [{{ $data['minPrice'] }} + 100, {{ $data['maxPrice'] }} - 500],
            slide: function(event, ui) {
                $("#amountRange").val(ui.values[0] + " - " + ui.values[1]);
                var priceRange = ui.values[1];
                var priceRangeMinimum = ui.values[0];
                var listItemsByPrice = document.querySelectorAll('li[data-price]');
                listItemsByPrice.forEach(function(item) {
                    var itemPrice = parseFloat(item.getAttribute('data-price'));
                    if (itemPrice <= parseFloat(priceRange) && itemPrice >= parseFloat(
                            priceRangeMinimum)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        });
        $("#amountRange").val($("#slider-range").slider("values", 0) +
            " - " + $("#slider-range").slider("values", 1));
        // var priceRange = document.getElementById("priceRange");
        // var priceRangeMinimum = document.getElementById("priceRangeMinimum");
        // var listItemsByPrice = document.querySelectorAll('li[data-price]');
        // var currentFilterRangePrice = document.getElementById("currentFilterRangePrice");
        // var currentFilterRangePriceMinimum = document.getElementById("currentFilterRangePriceMinimum");
        // currentFilterRangePrice.textContent = parseFloat(priceRange.value);
        // currentFilterRangePriceMinimum.textContent = parseFloat(priceRangeMinimum.value);
        // priceRange.addEventListener('change', function() {
        //     listItemsByPrice.forEach(function(item) {
        //         var itemPrice = parseFloat(item.getAttribute('data-price'));
        //         currentFilterRangePrice.textContent = parseFloat(priceRange.value);
        //         if (itemPrice <= parseFloat(priceRange.value) && itemPrice >= parseFloat(priceRangeMinimum
        //                 .value)) {
        //             item.style.display = 'block';
        //         } else {
        //             item.style.display = 'none';
        //         }
        //     });
        // });
        // priceRangeMinimum.addEventListener('change', function() {
        //     listItemsByPrice.forEach(function(item) {
        //         var itemPrice = parseFloat(item.getAttribute('data-price'));
        //         currentFilterRangePriceMinimum.textContent = parseFloat(priceRangeMinimum.value);
        //         if (itemPrice <= parseFloat(priceRange.value) && itemPrice >= parseFloat(priceRangeMinimum
        //                 .value)) {
        //             item.style.display = 'block';
        //         } else {
        //             item.style.display = 'none';
        //         }
        //     });
        // });

        function changeStop(stops) {
            var listItemsByPrice = document.querySelectorAll('li[data-stops]');
            if (stops == "all") {
                listItemsByPrice.forEach(function(item) {
                    var currentStop = parseFloat(item.getAttribute('data-stops'));
                    item.style.display = 'block';
                });
            } else {
                listItemsByPrice.forEach(function(item) {
                    var currentStop = parseFloat(item.getAttribute('data-stops'));
                    if (currentStop == stops) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        }


        function filterListItems() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var listItems = document.querySelectorAll('li[data-flights]');

            console.log("Checkboxes:", checkboxes);
            console.log("List items:", listItems);

            var selectedFlights = [];

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    selectedFlights.push(checkbox.value);
                    console.log("Selected:", checkbox.value);
                }
            });

            console.log("Selected flights:", selectedFlights);

            listItems.forEach(function(item) {
                var dataFlights = item.getAttribute('data-flights');

                console.log("List item data-flights:", dataFlights);

                if (selectedFlights.length === 0) {
                    item.style.display = 'block'; // Show the list item
                    console.log("Showing list item:", item);
                } else {
                    if (selectedFlights.includes(dataFlights)) {
                        item.style.display = 'block'; // Show the list item
                        console.log("Showing list item:", item);
                    } else {
                        item.style.display = 'none'; // Hide the list item
                        console.log("Hiding list item:", item);
                    }
                }
            });
        }
    </script>

    <script>
        var totalFlights = <?php echo count($allFlights); ?>;
        for (var i = 0; i < totalFlights; i++) {
            var x = JSON.parse($('input[name="allFlights"]').val());
            var itinerariesCount = (x[i]['itineraries']).length;
            // var itinerariesCount = <?php echo count($allFlights[0]['itineraries']); ?>;
            var segmentCount = (x[i]["itineraries"][0]["segments"]).length;
            for (var j = 0; j < itinerariesCount; j++) {
                // var connectingTimeId = "getConnectingTime" + i + j;
                // var connectingTimeValue = document.getElementById(connectingTimeId).value;

                var connectingTimeSpanId = "connectingTime" + i + j;
                var theme = 'theme-search-results-item-preview' + i + j;
                var direct = 'direct' + i + j;
                var layover = 'layover' + i + j;
                // if (connectingTimeValue.split('h')[0] > 5) {
                //     document.getElementById(theme).classList.remove('bg-success-light');
                // }
                // if (connectingTimeValue == '0h0min') {
                //     document.getElementById(layover).classList.add('d-none');
                //     document.getElementById(direct).classList.remove('d-none');
                // } else {
                document.getElementById(layover).classList.remove('d-none');
                document.getElementById(direct).classList.add('d-none');
                // }
                var hours = 0;
                var mints = 0;
                for (var k = 1; k <= segmentCount; k++) {
                    var newTimeId = "getConnectingTime" + i + j + k;
                    if (document.getElementById(newTimeId) !== null) {
                        dataTime = document.getElementById(newTimeId).value;
                        hours = hours + Number(dataTime.split("h")[0]);
                        mints = mints + Number(dataTime.split("h")[1].split("min")[0]);
                    }
                }
                if (mints > 60) {
                    var extraH = parseInt(mints / 60);
                    hours = hours + extraH;
                    mints = mints - (extraH * 60);
                }
                var newValue = hours + 'h' + mints + 'min';
                document.getElementById(connectingTimeSpanId).textContent = newValue;
                if (newValue.split('h')[0] > 5) {
                    document.getElementById(theme).classList.remove('bg-success-light');
                }

                var check = document.getElementById(connectingTimeSpanId).textContent;

                if (check == '0h0min' && segmentCount == 1) {
                    document.getElementById(layover).classList.add('d-none');
                    document.getElementById(direct).classList.remove('d-none');
                } else {
                    document.getElementById(layover).classList.remove('d-none');
                    document.getElementById(direct).classList.add('d-none');
                }
            }
        }
    </script>
    <script>
        function copyData(data) {
            var replacedData = data.replace(/@/g, '\r\n');
            var tempInput = document.createElement("input");
            tempInput.value = replacedData;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
        }
    </script>
    <script>
        document.getElementById("flightSearchBox").style.display = "none";
    </script>
    @include('inc.timer')
    @livewireScripts()
@endsection
