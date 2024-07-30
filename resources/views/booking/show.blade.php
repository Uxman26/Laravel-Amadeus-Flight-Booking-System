@extends('layouts.app')
@section('title')
    {{ $booking->pnr }} {{ $booking->passengers[0]->firstname }} {{ $booking->passengers[0]->lastname }}
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .swal-modal {
            width: 400px !important;
            position: fixed;
            top: 0;
            left: 0;
        }

        .lbtn {
            background-color: rgb(230, 30, 180);
            border: none;
            color: white;
            padding: 12px 30px;
            cursor: pointer;
            font-size: 20px;
        }

        .lbtn:hover {
            background-color: rgb(255, 225, 30);
        }

        .pbtn {
            background-color: DodgerBlue;
            border: none;
            color: white;
            padding: 12px 30px;
            cursor: pointer;
            font-size: 20px;
        }

        .pbtn:hover {
            background-color: RoyalBlue;
        }

        .ibtn {
            background-color: darkgreen;
            border: none;
            color: white;
            padding: 12px 30px;
            cursor: pointer;
            font-size: 20px;
        }

        .ibtn:hover {
            background-color: green;
        }

        .fbtn {
            background-color: darkred;
            border: none;
            color: white;
            padding: 12px 30px;
            cursor: pointer;
            font-size: 20px;
        }

        .fbtn:hover {
            background-color: red;
        }

        .termtext {
            font-size: 10px;
            margin: 0 !important;
            line-height: 1.5;
        }

        .line {
            width: 70px;
            height: 5px;
        }

        .print {
            width: 220mm;
            /* height: 251mm;
                                                    overflow: scroll; */
        }

        @media print and (max-width: 600px) {
            header {
                display: none;
                margin-bottom: 0;
            }


            .print {
                position: absolute;
                top: -40;
                padding: 20px;
            }

            .pbtn {
                display: none;
            }

            .fbtn {
                display: none;
            }

            .ibtn {
                display: none;
            }

            .lbtn {
                display: none;
            }


        }

        @media print and (min-width: 601px) {
            header {
                display: none;
                margin-bottom: 0;
            }


            .print {
                position: absolute;
                top: 0;
                padding: 20px;
            }

            .pbtn {
                display: none;
            }

            .fbtn {
                display: none;
            }

            .ibtn {
                display: none;
            }

            .lbtn {
                display: none;
            }


        }

        #watermark {
            position: relative !important;
            margin-bottom: -300px;
            margin-left: 200px;
        }
    </style>
@endsection
@section('content')
    <section class="payment-area p-5">
        <div class="">
            <div class="row">
                <div class="col-lg-12 col-10 mx-auto d-flex justify-content-center" id="">
                    <div class="form-box mb-0 print payment-received-list pt-5">

                        <div class="form-content pb-0 @if (count($booking->passengers) < 4) px-5 @endif pt-2">
                            <button class="btn pbtn" onclick="printDiv()"><i class="fa fa-print"></i></button>
                            {{-- <button class="btn fbtn" id=""><i class='fa fa-file-pdf-o'></i></button> --}}
                            <button class="btn lbtn" id=""><i class='fa fa-share-alt'></i></button>
                            <button class="btn ibtn" id="downloadButton"><i class='fa fa-cloud-download'></i></button>
                            <div class="" id="printarea">
                                <div class="mt-2 mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="brand-area d-flex justify-content-around">
                                                <div class="col-md-4">
                                                    <img src="{{ asset('assets/img/logo-old1.png') }}" width="200"
                                                        alt="Logo">
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <p>
                                                        @if ($booking->trip_type == 'return')
                                                            Round Trip
                                                        @elseif($booking->trip_type == 'oneway')
                                                            One Way
                                                        @else
                                                            Multi Way
                                                        @endif
                                                    </p>
                                                    <h6>
                                                        @foreach ($flightData->itineraries as $segments)
                                                            {{ findCityName($segments->segments[0]->departure->iataCode) }}
                                                        @endforeach
                                                        -
                                                        @foreach ($flightData->itineraries as $segments)
                                                            {{ findCityName(end($segments->segments)->arrival->iataCode) }}
                                                        @endforeach
                                                    </h6>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <h5
                                                        style='color: @if (isset($booking->passengers[0]->etkt)) darkgreen  @elseif ($booking->pnr_status == 'live' and $booking->ticket_status != 'Cancel') #d5d228 @elseif($booking->ticket_status == 'Cancel') #f00125 @endif'>

                                                        @if ($booking->pnr_status == 'live' && $booking->ticket_status != 'Cancel')
                                                            Confirmed
                                                        @elseif($booking->ticket_status == 'Cancel')
                                                            Canceled
                                                        @elseif($booking->pnr_status == 'test')
                                                            Confirmed
                                                        @endif PNR
                                                        <br>{{ $booking->pnr }}
                                                        @if (isset($booking->pnr_ts))
                                                            /{{ $booking->pnr_ts }}
                                                        @endif
                                                    </h5>
                                                    <!-- <h5>CONFIRMED: 546543</h5> -->
                                                </div>
                                            </div>
                                            <hr class="my-2">
                                            <div class="col-md-12">
                                                <div class="passenger my-2">
                                                    <div>
                                                        <span class="name">Passenger's Name</span>
                                                    </div>
                                                    <div class="row">
                                                        @foreach ($booking->passengers as $passenger)
                                                            <div class="col-6">
                                                                <span
                                                                    style="display: inline-block; width: 20px; height: 20px; line-height: 20px; text-align: center; border-radius: 50%; background-color: #ddd; color: #000; font-weight: bold; margin-right: 10px;">
                                                                    {{ $loop->iteration }}
                                                                </span>
                                                                @php
                                                                    $date = Carbon\Carbon::now()
                                                                        ->subYears(25)
                                                                        ->format('Y-m-d');
                                                                @endphp
                                                                <span>
                                                                    @if ($passenger->gender == 'FEMALE' && $passenger->dob < $date)
                                                                        Mrs
                                                                    @else
                                                                        {{ $passenger->title }}
                                                                    @endif
                                                                </span>
                                                                {{ $passenger->firstname }} {{ $passenger->lastname }}
                                                                <small style="font-size:10px;"><sup class="text-uppercase">
                                                                        {{ $passenger->type }}</sup></small>
                                                                @if ($passenger->etkt != '')
                                                                    </br>
                                                                    <span class="ms-5">
                                                                        ETKT: {{ $passenger->etkt }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mb-0 mt-0">
                                        </div>
                                        <div class="row">
                                            @if ($booking->ticket_status == 'Cancel')
                                                <div id="watermark">
                                                    <img src="{{ asset('assets/img/cancel_watermark.png') }}"
                                                        width="300">
                                                </div>
                                            @endif
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-sm mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Flight</th>
                                                                    <th>Departure</th>
                                                                    <th></th>
                                                                    <th>Arrival</th>
                                                                    <th>Baggage</th>
                                                                </tr>
                                                                @php
                                                                    $oldDate = '';
                                                                    $oldCity = '';
                                                                    $fareDetailsBySegment = 0;
                                                                @endphp
                                                                @foreach ($flightData->itineraries as $segments)
                                                                    @if (isset($segments->segments[0]) &&
                                                                            isset($segments->segments[0]->bookingStatus) &&
                                                                            $segments->segments[0]->bookingStatus == 'DENIED')
                                                                        <tr>
                                                                            <td colspan="6">
                                                                                <div
                                                                                    class="col-md-12 d-flex text-center justify-content-center">

                                                                                    <div class="text-center">

                                                                                        <b><span
                                                                                                style="font-size: 20px; margin-left:20px">Flight
                                                                                                Time Change</span></b>

                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    @if (isset($flightData->itineraries[0]->segments[0]) &&
                                                                            isset($flightData->itineraries[0]->segments[0]->bookingStatus) &&
                                                                            $flightData->itineraries[0]->segments[0]->bookingStatus !== 'DENIED')
                                                                        @if (count($flightData->itineraries) > 1 && $loop->index != 0)
                                                                            <tr>
                                                                                <td colspan="6">
                                                                                    <div class="col-md-12 d-flex">
                                                                                        <b>Stay in {{ $oldCity }}
                                                                                            {{ getDurationBetweenDays($oldDate, $segments->segments[0]->departure->at) }}</b>
                                                                                        <div class="text-center">
                                                                                            @if ($booking->trip_type == 'return')
                                                                                                <b><span
                                                                                                        style="font-size: 20px; margin-left:20px">Return
                                                                                                        Ticket </span> </b>
                                                                                            @else
                                                                                                <b><span
                                                                                                        style="font-size: 20px; margin-left:20px">Next
                                                                                                        Departure</span></b>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @else
                                                                        @if (count($flightData->itineraries) > 1 && $loop->index != 0)
                                                                            <tr>
                                                                                <td colspan="6">
                                                                                    <div class="col-md-12 d-flex">
                                                                                        <b>Stay in {{ $oldCity }}
                                                                                            {{ getDurationBetweenDays($oldDate, $segments->segments[0]->departure->at) }}</b>
                                                                                        <div class="text-center">
                                                                                            @if ($booking->trip_type == 'return')
                                                                                                <b><span
                                                                                                        style="font-size: 20px; margin-left:20px">Return
                                                                                                        Ticket </span> </b>
                                                                                            @else
                                                                                                <b><span
                                                                                                        style="font-size: 20px; margin-left:20px">Next
                                                                                                        Departure</span></b>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endif
                                                                    @foreach ($segments->segments as $flight)
                                                                        @if ($oldDate != '' && count($flightData->itineraries) > 0 && $loop->index != 0)
                                                                            <tr>
                                                                                <td colspan="6">
                                                                                    <div class="text-center">
                                                                                        Connecting Time
                                                                                        {{ findCityName($flight->departure->iataCode) }}
                                                                                        {{ getConnectingTime($oldDate, $flight->departure->at) }}
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                        <tr>
                                                                            <td class="text-center align-middle">
                                                                                <p
                                                                                    style="font-weight: bold;white-space: nowrap;">
                                                                                    {{ str()->limit(findAirlineName($flight->carrierCode), 10) }}
                                                                                </p>
                                                                                <p style="font-weight: bold;">
                                                                                    {{ $flight->carrierCode }}-{{ $flight->number }}
                                                                                </p>
                                                                                <p>{{ $flightData->travelerPricings[0]->fareDetailsBySegment[0]->cabin ?? '' }}
                                                                                    {{ $flightData->travelerPricings[0]->fareDetailsBySegment[$fareDetailsBySegment]->class ?? '' }}
                                                                                </p>
                                                                            </td>
                                                                            <td class="text-center align-middle">
                                                                                <p
                                                                                    class="font-weight: bold;white-space: nowrap;">
                                                                                    <b>{{ $flight->departure->iataCode }}
                                                                                        <small>({{ findCityName($flight->departure->iataCode) }})</b></small>
                                                                                </p>
                                                                                @if (isset($segments->segments[0]) &&
                                                                                        isset($segments->segments[0]->bookingStatus) &&
                                                                                        $segments->segments[0]->bookingStatus == 'DENIED')
                                                                                    <p style="white-space: nowrap;"><time
                                                                                            class=""><b><del>{{ getFullDate($flight->departure->at) }}</del></b></time>
                                                                                    </p>
                                                                                @else
                                                                                    <p style="white-space: nowrap;"><time
                                                                                            class=""><b>{{ getFullDate($flight->departure->at) }}</b></time>
                                                                                    </p>
                                                                                @endif
                                                                                <p><small style="font-size: 10px;"><b>{{ str()->limit(findAirportName($flight->departure->iataCode), 17) }}
                                                                                            Terminal-{{ $flight->departure->terminal ?? '' }}</b></small>
                                                                                </p>
                                                                            </td>
                                                                            <td class="text-center align-middle">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="airplan">
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <i style="font-size: 2em;"
                                                                                                class="la la-plane-departure m-2"></i>
                                                                                            <div class="line"></div>
                                                                                            <i style="font-size: 2em;"
                                                                                                class="la la-plane-arrival  m-2"></i>
                                                                                        </div>
                                                                                        @php
                                                                                            $date1 = Carbon\Carbon::parse(
                                                                                                $flight->departure->at,
                                                                                            );
                                                                                            $date2 = Carbon\Carbon::parse(
                                                                                                $flight->arrival->at,
                                                                                            );

                                                                                            $diffInHours = $date1->diffInHours(
                                                                                                $date2,
                                                                                            );
                                                                                            $diffInMinutes =
                                                                                                $date1->diffInMinutes(
                                                                                                    $date2,
                                                                                                ) % 60;

                                                                                            // Format the difference as "HH:MM"
                                                                                            $formattedDifference = sprintf(
                                                                                                '%02d:%02d',
                                                                                                $diffInHours,
                                                                                                $diffInMinutes,
                                                                                            );
                                                                                        @endphp
                                                                                        <p
                                                                                            style="margin-top:-35px;font-size:13px">
                                                                                            @if (isset($flight->duration))
                                                                                                {{ getDuration($flight->duration) }}
                                                                                            @else
                                                                                                {{ $formattedDifference }}
                                                                                                Hours
                                                                                            @endif
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center align-middle">
                                                                                <p
                                                                                    class="font-weight: bold;white-space: nowrap;">
                                                                                    <b>{{ $flight->arrival->iataCode }}
                                                                                        <small>({{ findCityName($flight->arrival->iataCode) }})</b></small>
                                                                                </p>
                                                                                @if (isset($segments->segments[0]) &&
                                                                                        isset($segments->segments[0]->bookingStatus) &&
                                                                                        $segments->segments[0]->bookingStatus == 'DENIED')
                                                                                    <p style="white-space: nowrap;">
                                                                                        <b><del>{{ getFullDate($flight->arrival->at) }}</del></b>
                                                                                    </p>
                                                                                @else
                                                                                    <p style="white-space: nowrap;">
                                                                                        <b>{{ getFullDate($flight->arrival->at) }}</b>
                                                                                    </p>
                                                                                @endif
                                                                                <p><small style="font-size: 10px;"><b>{{ str()->limit(findAirportName($flight->arrival->iataCode), 17) }}
                                                                                            Terminal-{{ $flight->arrival->terminal ?? '' }}</b></small>
                                                                                </p>
                                                                            </td>
                                                                            <td class="text-center align-middle">
                                                                                <div class="d-flex">
                                                                                    <div class="suitecase text-center me-1">
                                                                                        <i style="font-size: 2.0rem;"
                                                                                            class="la la-dolly-flatbed"></i>
                                                                                        <p style="font-size:12px;">
                                                                                            @if (isset($flightData->travelerPricings[0]) &&
                                                                                                    isset($flightData->travelerPricings[0]->fareDetailsBySegment[$fareDetailsBySegment]))
                                                                                                {{ getWeight($booking, $flightData->travelerPricings[0]->fareDetailsBySegment[$fareDetailsBySegment]->includedCheckedBags) }}
                                                                                            @endif
                                                                                        </p>
                                                                                    </div>
                                                                                    <p class="mt-2">+</p>
                                                                                    <div class="handcarry text-center">
                                                                                        <i style="font-size: 2.0rem;"
                                                                                            class="la la-shopping-bag"></i>
                                                                                        <p style="font-size:10px;">Cabin
                                                                                            Bag
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        @php
                                                                            $oldDate = $flight->arrival->at;
                                                                            $oldCity = findCityName(
                                                                                $flight->arrival->iataCode,
                                                                            );
                                                                            $fareDetailsBySegment++;
                                                                        @endphp
                                                                    @endforeach
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="text-center">Terms & Conditions</p>
                                                        <p class="termtext">The following terms and conditions should be
                                                            read carefully.</p>
                                                        <p class="termtext">1)The passenger's name(s) should be checked as
                                                            per their passport/identity proof, departure and arrival dates,
                                                            times, flight number, terminal, and baggage information.</p>
                                                        <p class="termtext">2)Check-in counters open 3 hours prior to
                                                            flight
                                                            departure and close 1 hour prior to flight departure. If you
                                                            fail to report on time you may be denied boarding.</p>
                                                        <p class="termtext">3)Please make sure flight schedule before
                                                            departure.
                                                            Visit airline website or contact your travel agent براہ کرم
                                                            روانگی سے پہلے ائیر لائن کی ویب سائٹ سے پرواز کا شیڈول یقینی
                                                            بنائیں۔.</p>
                                                        <p class="termtext">4) Whenever you travel internationally, please
                                                            confirm your passport ,visa,and ok to board requirements with
                                                            your airline or relevant Embassy..</p>
                                                        <p class="termtext">5)Some countries may impose local taxes (VAT,
                                                            tourist tax, etc.) that must be paid locally.</p>
                                                        <p class="termtext">6) We are not responsible for schedule changes
                                                            or flight cancellations by the airline before or after tickets
                                                            are issued.</p>
                                                        <p class="termtext">7) We cannot be held liable for any loss,
                                                            damage
                                                            or mishap to the traveler's or his/her belongings due to
                                                            accident, theft or other unforeseeable circumstances.</p>
                                                        <p class="termtext">8)Booking amendments will be subject to the
                                                            airline's terms and conditions, including penalties, fare
                                                            difference, and availability.</p>
                                                        <p class="termtext">9)A cancellation or refund of a booking will be
                                                            handled on a case-by-case basis depending on the airline and
                                                            agency policies.</p>
                                                        <p class="termtext">10)Non-refundable tickets cannot be refunded
                                                            unless the airline promises to provide one or cancels a flight
                                                            or makes significant schedule changes. Refundable tickets cannot
                                                            be refunded their full amount because of penalties
                                                            and airport taxes.</p>
                                                        <p class="termtext">11)Should you need amendments, cancellations,
                                                            or ancillary services, contact your travel partner.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="text-center" style="margin-bottom: -30px">Bon Voyage!
                                                        </p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="termtext">
                                                                24/7 Customer service <br>
                                                                FRA:0033187653786 <br>
                                                                UK: 00448007074285 <br>
                                                                USA:0018143008040
                                                            </p>
                                                            <p>
                                                                www.gondaltravel.com
                                                            </p>
                                                            <p class="termtext">
                                                                BOOKING PARTNER<br>
                                                                {{ $booking->user->name }} <br>
                                                                OFFICE PHONE: <br>
                                                                {{ $booking->user->phone }} <br>
                                                                {{ $booking->user->email }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 justify-content-end text-end">
                                                        <p style="font-size: 10px">
                                                            {{ Carbon\Carbon::parse($booking->passengers[0]->updated_at)->format('d-m-Y H:i:s') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="editor"></div>
    </section>
    <textarea style="opacity: 0" id="url" rows="1" cols="30">{{ route('flight.ticket.show.passenger', ['id' => $booking->id, 'hash' => md5($booking->uri), 'pnr' => $booking->pnr]) }}</textarea>
@endsection
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script>
    function printDiv() {
        window.print();
    }
    window.onload = function() {
        document.getElementById('downloadButton').addEventListener('click', function() {
            // Get the element containing the content you want to capture
            $('.ibtn').hide();
            $('.lbtn').hide();
            $('.pbtn').hide();
            const contentElement = document.querySelector('.payment-received-list');
            const contentWidth = contentElement.scrollWidth;
            var options = {
                allowTaint: true,
                useCORS: true,
                width: contentWidth,
            };
            if (window.innerWidth <= 768) { // Adjust the width value as needed
                // Capture the entire content for mobile devices
                options.scrollX = 0;
                options.scrollY = 0;
                options.windowWidth = document.documentElement.offsetWidth;
                options.windowHeight = document.documentElement.offsetHeight;
            }

            // Convert the element to a canvas image using html2canvas
            html2canvas(contentElement, options).then(function(canvas) {
                // Create a temporary anchor element to download the image
                const link = document.createElement('a');
                link.href = canvas.toDataURL('image/png');
                link.download = document.title + '.png';

                // Trigger the download
                link.click();
            });
            $('.ibtn').show();
            $('.lbtn').show();
            $('.pbtn').show();
        });

        var doc = new jsPDF();
        var specialElementHandlers = {
            '#editor': function(element, renderer) {
                return true;
            }
        };

        $('.fbtn').click(function() {
            doc.fromHTML($('.payment-received-list').html(), 15, 15, {
                'width': 100,
                'elementHandlers': specialElementHandlers
            });
            setTimeout(function() {
                doc.save(document.title + '.pdf');
            }, 1000);
        });
        $('.lbtn').click(function() {
            var Url = document.getElementById("url");
            Url.select();
            document.execCommand("copy");
        });
    }
</script>
