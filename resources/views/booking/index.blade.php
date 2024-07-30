@extends('layouts.app')
@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-search__field {
            border: 5px solid red !important;
            background-color: lightblue !important;
        }

        body {
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.816);
            /* Adjust the opacity value */
            z-index: 1030;
        }
    </style>
@endsection
@section('content')
    <section class="breadcrumb-area bread-bg-flights">
        <section class="container" style="border-radius:10px;padding:50px 0px">
            <div class="container">
                <h2 class="text-center" style="color:#fff">FLIGHTS BOOKING</h2>
                <p class="text-center text-white">This Page will be Expired after <span id="timer">10:00</span></p>
            </div>
        </section>
    </section>
    <section class="booking-area padding-top-50px padding-bottom-70px">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">

                    @if (session('bookingData'))
                        @php
                            $oldPassengers = App\Models\Passenger::where(
                                'booking_id',
                                session('bookingData')->id,
                            )->get();
                        @endphp
                        <input type="hidden" name="oldPassengers" id="oldPassengers" value="{{ $oldPassengers }}">

                        <div class="form-box">
                            <div class="form-title-wrap">
                                <h3 class="title">Re-Issue Ticket <span
                                        class="text-danger">{{ session('bookingData')->pnr }}</span></h3>
                            </div><!-- form-title-wrap -->
                            <div class="form-content">
                                <div class="section-tab check-mark-tab pb-4">
                                    <div class="card-item shadow-none radius-none mb-4">
                                        <h5>Old Price : {{ session('bookingData')->amount }} EUR</h5>
                                        <h5>New Price:
                                            {{ commission($data['amount'], $data['infant'] + $data['children'] + $data['adult']) }}
                                            EUR</h5>
                                        <h5>Diffrence:
                                            {{ session('bookingData')->amount - commission($data['amount'], $data['infant'] + $data['children'] + $data['adult']) }}
                                            EUR</h5>
                                    </div>
                                    <h5>if you want to Re-Issue This Ticket with Default Details, Please Click Continue?
                                    </h5>
                                    <hr>
                                    <div class="btn-box">
                                        <form action="{{ route('flight.reissue.store') }}" id="reissueForm" method="POST">
                                            @csrf
                                            <input type="hidden" name="routes" value="{{ $routes }}">
                                            <input type="hidden" name="uri" value="{{ $data['uri'] }}">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="">Agent Sell Price</label>
                                                    <input type="number" required class="form-control mb-2"
                                                        name="marginAmount" id="chargesInput2">
                                                </div>
                                            </div>
                                            <button class="theme-btn book" type="button" id="booking">Continue</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="oldPassengers" id="oldPassengers" value="">
                    @endif
                    <form id="booking_store" action="{{ route('flight.booking.store') }}" method="POST">
                        <div class="form-box payment-received-wrap mb-2">
                            <div class="form-title-wrap">
                                <h3 class="title">Travelers Information</h3>
                            </div>
                            @csrf
                            <input type="hidden" name="adult_count" value="{{ $data['adult'] }}">
                            <input type="hidden" name="children_count" value="{{ $data['children'] }}">
                            <input type="hidden" name="infant_count" value="{{ $data['infant'] }}">
                            <input type="hidden" name="trip_type" value="{{ $data['trip_type'] }}">
                            <input type="hidden" name="lastTicketingDate"
                                value="{{ isset(json_decode($routes)->lastTicketingDate) ? json_decode($routes)->lastTicketingDate : null }}">
                            <input type="hidden" name="uri" value="{{ $data['uri'] }}">

                            @for ($adult = 0; $adult < $data['adult']; $adult++)
                                @include('inc.traveler', [
                                    'type' => 'adult',
                                    'data' => $adult,
                                    'passengers' => $passengers['adult'],
                                ])
                            @endfor
                            @for ($children = 0; $children < $data['children']; $children++)
                                @include('inc.traveler', [
                                    'type' => 'children',
                                    'data' => $children,
                                    'passengers' => $passengers['children'],
                                ])
                            @endfor
                            @for ($infant = 0; $infant < $data['infant']; $infant++)
                                @include('inc.traveler', [
                                    'type' => 'infant',
                                    'data' => $infant,
                                    'passengers' => $passengers['infant'],
                                ])
                            @endfor
                        </div>
                        <div class="form-box">
                            <div class="form-title-wrap">
                                <h3 class="title">Payment Method</h3>
                            </div><!-- form-title-wrap -->
                            <div class="form-content">
                                <div class="section-tab check-mark-tab text-center pb-4">
                                    <ul class="nav nav-tabs gateways row" id="myTab" role="tablist">
                                        <label style="width:100%" class="form-check-label" for="gateway_bank_transfer">
                                            <div class="col-md-12 mb-1 gateway_bank_transfer">
                                                <div class="form-check nav-link p-2 px-3 m-1 d-flex"
                                                    style="justify-content: space-between;border-radius: 4px !important;">
                                                    <div class="d-flex mb-2 input" style="gap: 16px; align-items: center;">
                                                        <input checked="" class="form-check-input mx-auto"
                                                            type="radio" name="payment_gateway" id="gateway_bank_transfer"
                                                            value="bank-transfer" required="">
                                                        <span class="d-block pt-2">Pay With <strong>BANK
                                                                TRANSFER</strong></span>
                                                    </div>
                                                    <div class="d-block">
                                                        <img src="{{ asset('assets/theme/img/gateways/bank-transfer.png') }}"
                                                            style="max-height:40px;background:transparent"
                                                            alt="Bank Transfer">
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                        <label style="width:100%" class="form-check-label" for="gateway_cash_transfer">
                                            <div class="col-md-12 mb-1 gateway_cash_transfer">
                                                <div class="form-check nav-link p-2 px-3 m-1 d-flex"
                                                    style="justify-content: space-between;border-radius: 4px !important;">
                                                    <div class="d-flex mb-2 input"
                                                        style="gap: 16px; align-items: center;">
                                                        <input class="form-check-input mx-auto" type="radio"
                                                            name="payment_gateway" id="gateway_cash_transfer"
                                                            value="Cash" required="">
                                                        <span class="d-block pt-2">Pay With <strong>CASH</strong></span>
                                                    </div>
                                                    <div class="d-block">
                                                        <img src="{{ asset('assets/theme/img/gateways/bank-transfer.png') }}"
                                                            style="max-height:40px;background:transparent"
                                                            alt="bank-transfer">
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                        <label style="width:100%" class="form-check-label" for="gateway_card_transfer">
                                            <div class="col-md-12 mb-1 gateway_card_transfer">
                                                <div class="form-check nav-link p-2 px-3 m-1 d-flex"
                                                    style="justify-content: space-between;border-radius: 4px !important;">
                                                    <div class="d-flex mb-2 input"
                                                        style="gap: 16px; align-items: center;">
                                                        <input class="form-check-input mx-auto" type="radio"
                                                            name="payment_gateway" id="gateway_card_transfer"
                                                            value="Card" required="">
                                                        <span class="d-block pt-2">Pay With <strong>CARD</strong></span>
                                                    </div>
                                                    <div class="d-block">
                                                        <img src="{{ asset('assets/theme/img/gateways/bank-transfer.png') }}"
                                                            style="max-height:40px;background:transparent"
                                                            alt="bank-transfer">
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-box">
                            <div class="form-title-wrap">
                                <h3 class="title">Ticket Confirmation</h3>
                            </div><!-- form-title-wrap -->
                            <div class="form-content">
                                <div class="section-tab check-mark-tab text-center pb-4">
                                    <ul class="nav nav-tabs gateways row" id="myTab" role="tablist">
                                        <label style="width:100%" class="form-check-label" for="delay_time">
                                            <div class="col-md-12 mb-1 delay_time">
                                                <div class="form-check nav-link p-2 px-3 m-1 d-flex"
                                                    style="justify-content: space-between;border-radius: 4px !important;">
                                                    <div class="d-flex mb-2 input"
                                                        style="gap: 16px; align-items: center;">
                                                        <span class="pt-2">DelayTime</span>
                                                        <input type="text" name="delay_value" class="form-control" id="delay_value" placeholder="*D" value="{{option('DELAY_TO_CANCEL')}}">

                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                        <label style="width:100%" class="form-check-label" for="ticketHold">
                                            <div class="col-md-12 mb-1 ticketHold">
                                                <div class="form-check nav-link p-2 px-3 m-1 d-flex"
                                                    style="justify-content: space-between;border-radius: 4px !important;">
                                                    <div class="d-flex mb-2 input"
                                                        style="gap: 16px; align-items: center;">
                                                        <input checked="" class="form-check-input mx-auto"
                                                            type="radio" name="ticket_status" id="ticketHold"
                                                            value="Hold" required="">
                                                        <span class="d-block pt-2">Ticket On <strong>HOLD</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                        <label style="width:100%" class="form-check-label" for="ticketConfirm">
                                            <div class="col-md-12 mb-1 ticketConfirm">
                                                <div class="form-check nav-link p-2 px-3 m-1 d-flex"
                                                    style="justify-content: space-between;border-radius: 4px !important;">
                                                    <div class="d-flex mb-2 input"
                                                        style="gap: 16px; align-items: center;">
                                                        <input class="form-check-input mx-auto" type="radio"
                                                            name="ticket_status" id="ticketConfirm" value="Confirm"
                                                            required="">
                                                        <span class="d-block pt-2">Ticket Is
                                                            <strong>CONFIRMED</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-box">
                            <div class="form-title-wrap">
                                <h3 class="title">Contact Detail & Bags</h3>
                            </div><!-- form-title-wrap -->
                            <div class="form-content">
                                <div class="section-tab check-mark-tab pb-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="label-text" for="email">Email</label>
                                            <input type="email" value="travelgondal@gmail.com" name="email"
                                                class="form-control" placeholder="Contact Email" required />
                                        </div>
                                        <div class="col-md-2">
                                            <label class="label-text" for="phone_code">Country Code</label>
                                            <input type="text" value="33" name="phone_code" class="form-control"
                                                placeholder="Ex: 92" required />
                                        </div>
                                        <div class="col-md-10">
                                            <label class="label-text" for="phone">Phone</label>
                                            <input type="text" name="phone" class="form-control" value="771626271"
                                                placeholder="771626271" required />
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="section-tab check-mark-tab pb-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="label-text" for="bags">Bag Weight</label>
                                            <input type="text" name="bags" class="form-control"
                                                placeholder="Ex: 40 KG" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="input-box">
                                <div class="form-group">
                                    <div class="custom-checkbox">
                                        <input type="hidden" name="routes" value="{{ $routes }}">
                                        <input type="hidden" name="pureAmount" id="pureAmount"
                                            value="{{ commission($data['amount'], $data['infant'] + $data['children'] + $data['adult']) }}">
                                        <input type="hidden" name="admin_buy_price" id="admin_buy_price"
                                            value="{{ $data['amount'] }}">
                                        <input type="hidden" name="marginAmount" id="marginAmount"
                                            value="{{ $data['amount'] }}">
                                        <input type="hidden" name="receivedAmount" id="receivedAmount" value="0">
                                        <input type="hidden" name="negoAmount" id="negoAmount"
                                            value="{{ commission($data['amount'], $data['infant'] + $data['children'] + $data['adult']) }}">
                                        {{-- <input type="checkbox" id="agreechb"
                                            onchange="document.getElementById('booking').disabled = !this.checked;">
                                        <label for="agreechb">By continuing, you agree to the <a target="_blank"
                                                href="#">Terms and Conditions</a></label> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 d-none">
                            <div class="btn-box">
                                <button class="theme-btn book" type="submit" id="bookingConfirm">Confirm
                                    Booking</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="sticky-top">
                        <div class="form-box booking-detail-form">
                            <div class="form-title-wrap">
                                <h3 class="title">Booking Details</h3>
                            </div>
                            <div class="form-content">
                                <div class="card-item shadow-none radius-none mb-0">
                                    @foreach (json_decode($routes)->itineraries as $allFlights)
                                        @foreach ($allFlights->segments as $flight)
                                            @include('inc.routes')
                                            <hr>
                                            <input type="hidden" name="last_route_departure"
                                                value="{{ $flight->departure->at }}">
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-title-wrap">
                                <h3 class="title">Passengers Price</h3>
                            </div>
                            <div class="form-content">
                                <div class="card-item shadow-none radius-none mb-0">
                                    @foreach ($travelerType->where('travelerType', 'ADULT')->take(1) as $adult)
                                        <h5>Adults : <span
                                                class="text-white">{{ $travelerType->where('travelerType', 'ADULT')->count() }}
                                                X {{ $adult->price->total }} =
                                                {{ $travelerType->where('travelerType', 'ADULT')->count() * $adult->price->total }}</span>
                                            {{ $adult->price->currency }}</h5>
                                        <small>Age 18+</small>
                                        <hr>
                                    @endforeach
                                    @foreach ($travelerType->where('travelerType', 'CHILD')->all() as $child)
                                        <h5>Children : <span
                                                class="text-white">{{ $travelerType->where('travelerType', 'CHILD')->count() }}
                                                X {{ $child->price->total }} =
                                                {{ $travelerType->where('travelerType', 'CHILD')->count() * $child->price->total }}</span>
                                            {{ $child->price->currency }}</h5>
                                        <small>2-12 years old</small>
                                        <hr>
                                    @endforeach
                                    @foreach ($travelerType->where('travelerType', 'HELD_INFANT')->all() as $infant)
                                        <h5>Infats : <span
                                                class="text-white">{{ $travelerType->where('travelerType', 'HELD_INFANT')->count() }}
                                                X {{ $infant->price->total }} =
                                                {{ $travelerType->where('travelerType', 'HELD_INFANT')->count() * $infant->price->total }}</span>
                                            {{ $infant->price->currency }}</h5>
                                        <small>0-2 years old</small>
                                        <hr>
                                    @endforeach

                                </div>
                                <hr>
                            </div>
                            <div class="form-title-wrap">
                                <h3 class="title">Grand Total</h3>
                            </div>
                            <div class="form-content">
                                <div class="card-item shadow-none radius-none mb-0">
                                    <h5>Price : <span class="text-white"
                                            id="grandPrice">{{ commission($data['amount'], $data['infant'] + $data['children'] + $data['adult']) }}</span>
                                        EUR</h5>
                                    <h5>Margin: <span class="text-white"
                                            id="totalMargin">{{ commission($data['amount'], $data['infant'] + $data['children'] + $data['adult']) }}</span>
                                        EUR</h5>
                                </div>
                                <hr>
                                <div class="card-item shadow-none radius-none mb-0">
                                    <div class="form-group">
                                        <label for="chargesInput">Agent Sell Price</label>
                                        <input type="text" name="chargesInput" id="chargesInput" class="form-control"
                                            placeholder="{{ commission($data['amount'], $data['infant'] + $data['children'] + $data['adult']) }}"
                                            value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="negoInput">NEGO</label>
                                        <input type="text" name="negoInput" id="negoInput" class="form-control"
                                            value="{{ commission($data['amount'], $data['infant'] + $data['children'] + $data['adult']) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="receivedInput">Received From Customer</label>
                                        <input type="text" name="receivedInput" id="receivedInput"
                                            class="form-control" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-box">
                                <div class="form-group">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="agreechb"
                                            onchange="document.getElementById('booking').disabled = !this.checked;">
                                        <label for="agreechb">By continuing, you agree to the <a target="_blank"
                                                href="#">Terms and Conditions</a></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="btn-box">
                                <button class="theme-btn book" type="submit" id="booking_dublicate">Confirm
                                    Booking</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="passenger_adult" value="{{ $passengers['adult'] }}">
    <input type="hidden" id="passenger_children" value="{{ $passengers['children'] }}">
    <input type="hidden" id="passenger_infant" value="{{ $passengers['infant'] }}">
    <input type="hidden" id="number_adult" value="{{ $data['adult'] }}">
    <input type="hidden" id="number_children" value="{{ $data['children'] }}">
    <input type="hidden" id="number_infant" value="{{ $data['infant'] }}">
    <div class="modal fade" id="thankyouModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" style="border-top: 20px solid {{ option('themecolor') }}">
            <div class="modal-content">
                <div class="modal-body justify-content-center text-center">
                    <p>We are processing you booking. please wait.</p>
                    <p>This will take only a few seconds ...</p>
                    <div class="spinner-grow"
                        style="width: 3rem; height: 3rem; color: {{ option('themecolor') }} !important" role="status">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $('#booking').click(function() {
            if (!$('#chargesInput2').val()) {
                alert('Please Fill Agent Sell Price');
            } else {
                $('#booking').prop('disabled', true);
                setTimeout(() => {
                    $('#booking').prop('disabled', false);
                }, 5000);
                $('#reissueForm').submit();
            }
        })

        adult = JSON.parse($('#passenger_adult').val());
        children = JSON.parse($('#passenger_children').val());
        infant = JSON.parse($('#passenger_infant').val());
        adult_count = JSON.parse($('#number_adult').val());
        children_count = JSON.parse($('#number_children').val());
        infant_count = JSON.parse($('#number_infant').val());

        for (let i = 0; i < adult_count; i++) {
            adult.forEach(function(data) {
                $('.passenger_adult_' + i).append($('<option>').attr({
                    "value": data.id + '-adult-' + i,
                }).text(data.firstname + ' ' + data.lastname + '--' + data.dob + '--' + data.passport));
            })
        }
        for (let i = 0; i < children_count; i++) {
            children.forEach(function(data) {
                $('.passenger_children_' + i).append($('<option>').attr({
                    "value": data.id + '-children-' + i,
                }).text(data.firstname + ' ' + data.lastname + '--' + data.dob + '--' + data.passport));
            })
        }
        for (let i = 0; i < infant_count; i++) {
            infant.forEach(function(data) {
                $('.passenger_infant_' + i).append($('<option>').attr({
                    "value": data.id + '-infant-' + i,
                }).text(data.firstname + ' ' + data.lastname + '--' + data.dob + '--' + data.passport));
            })
        }
        var oldPassengersCheck = $('input[name="oldPassengers"]').val();
        if (oldPassengersCheck != '') {
            var oldPassengers = JSON.parse($('input[name="oldPassengers"]').val());
            var i = 0;
            oldPassengers.forEach(function(data) {
                type = data.type;
                val = data.id;
                var postData = {
                    id: val
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('/flight/booking/get_passenger') }}",
                    type: 'POST',
                    data: postData,
                    success: function(response) {
                        console.log(response[1])
                        console.log('select[name="title_' + type + '_' + (i + 1) + '"]')
                        passenger = response[1];
                        if (passenger) {
                            $('select[name="title_' + type + '_' + (i + 1) + '"]').val(passenger.title);
                            $('input[name="firstname_' + type + '_' + (i + 1) + '"]').val(passenger
                                .firstname);
                            $('input[name="lastname_' + type + '_' + (i + 1) + '"]').val(passenger
                                .lastname);
                            $('select[name="gender_' + type + '_' + (i + 1) + '"]').val(passenger
                                .gender);
                            $('select[name="nationality_' + type + '_' + (i + 1) + '"]').val(passenger
                                .nationality);
                            $('input[name="dob_' + type + '_' + (i + 1) + '"]').val(formatDate(new Date(
                                passenger.dob)));
                            $('input[name="passport_' + type + '_' + (i + 1) + '"]').val(passenger
                                .passport);

                            $('input[name="passport_expiry_' + type + '_' + (i + 1) + '"]').val(
                                formatDate(new Date(passenger.passport_expiry)));
                        } else {
                            alert('Passenger not found');
                        }
                        i++;
                    },
                    error: function(error) {
                        console.log(error);
                        i++;
                    }
                });

            })
        }
        $(document).ready(function() {
            $('.old_passenger').select2();
        })

        $('.title').change(function() {
            data = parseInt($(this).attr('name').split("_")[2]);
            type = $(this).attr('name').split("_")[1];
            val = $(this).find(':selected').val();
            console.log(data, type, val);
            input = 'select[name="gender_' + type + "_" + data + '"]';
            if (val == 'Mr' || val == 'MSTR') {
                $(input).find('option[value="MALE"]').prop('selected', true);
            } else {
                $(input).find('option[value="FEMALE"]').prop('selected', true);
            }
        })
        $('.old_passenger').change(function() {
            data = parseInt($(this).find(':selected').val().split("-")[2]);
            type = $(this).find(':selected').val().split("-")[1];
            val = parseInt($(this).find(':selected').val().split("-")[0]);
            console.log(type, data, val);
            var postData = {
                id: val
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('/flight/booking/get_passenger') }}",
                type: 'POST',
                data: postData,
                success: function(response) {
                    console.log(response[1], type, data);
                    passenger = response[1];
                    if (passenger) {
                        $('select[name="title_' + type + '_' + (data + 1) + '"]').val(passenger.title);
                        $('input[name="firstname_' + type + '_' + (data + 1) + '"]').val(passenger
                            .firstname);
                        $('input[name="lastname_' + type + '_' + (data + 1) + '"]').val(passenger
                            .lastname);
                        $('select[name="gender_' + type + '_' + (data + 1) + '"]').val(passenger
                            .gender);
                        $('select[name="nationality_' + type + '_' + (data + 1) + '"]').val(passenger
                            .nationality);
                        $('input[name="dob_' + type + '_' + (data + 1) + '"]').val(formatDate(new Date(
                            passenger.dob)));
                        $('input[name="passport_' + type + '_' + (data + 1) + '"]').val(passenger
                            .passport);

                        $('input[name="passport_expiry_' + type + '_' + (data + 1) + '"]').val(
                            formatDate(new Date(passenger.passport_expiry)));
                    } else {
                        alert('Passenger not found');
                    }
                },
                error: function(error) {
                    // Handle errors here
                    console.log(error);
                }
            });
        })

        function padTo2Digits(num) {
            return num.toString().padStart(2, '0');
        }

        function formatDate(date) {
            return [
                padTo2Digits(date.getDate()),
                padTo2Digits(date.getMonth() + 1),
                date.getFullYear(),
            ].join('/');
        }

        //
        $('.expField').on('change click touchstart keypress keyup focus touch', function() {
            var type = $(this).attr('typeV');
            var key = $(this).attr('key');
            var date1 = new Date($('input[name="last_route_departure"]').val());
            var inp = 'input[name="passport_expiry_' + type + '_' + key + '"]';
            var date2 = $(inp).val();
            var parts = date2.split('/');
            if (parts.length === 3) {
                var day = parseInt(parts[0], 10);
                var month = parseInt(parts[1], 10);
                var year = parseInt(parts[2], 10);

                // Create date in YYYY-MM-DD format
                var isoDateStr = year + '-' + ('0' + month).slice(-2) + '-' + ('0' + day).slice(-2);
                date2 = new Date(isoDateStr + 'T09:05:00');
            }

            // Calculate the difference in days
            var timeDifference = date2.getTime() - date1.getTime();
            var daysDifference = timeDifference / (1000 * 3600 * 24);
            if (daysDifference < 183) {
                inp = '#alert_passport_expiry_' + type + '_' + key;
                $(inp).text('Expiry Date is less than or equal to 6 months');
                $(inp).css("display", "block");
            } else {
                inp = '#alert_passport_expiry_' + type + '_' + key;
                $(inp).css("display", "none");
            }
        });
        $('.dobField').on('change click touchstart keypress keyup focus touchnge', function() {
            var type = $(this).attr('typeV');
            var key = $(this).attr('key');
            var date1 = new Date($('input[name="last_route_departure"]').val());
            var inp = 'input[name="dob_' + type + '_' + key + '"]';
            var date2 = $(inp).val();
            var parts = date2.split('/');
            if (parts.length === 3) {
                var day = parseInt(parts[0], 10);
                var month = parseInt(parts[1], 10);
                var year = parseInt(parts[2], 10);

                // Create date in YYYY-MM-DD format
                var isoDateStr = year + '-' + ('0' + month).slice(-2) + '-' + ('0' + day).slice(-2);
                date2 = new Date(isoDateStr + 'T09:05:00');
            }

            // Calculate the difference in days
            var timeDifference = date1.getTime() - date2.getTime();
            var daysDifference = timeDifference / (1000 * 3600 * 24);
            console.log(daysDifference);

            if (type == 'adult') {
                if (daysDifference < 4380) {
                    inp = '#alert_dob_adult_' + key;
                    $(inp).text('Age of Adult in not greater than 11');
                    $(inp).css("display", "block");

                } else {
                    inp = '#alert_dob_adult_' + key;
                    $(inp).css("display", "none");
                }
            } else if (type == 'children') {
                if (daysDifference < 730 || daysDifference >= 4380 || daysDifference < 0) {
                    inp = '#alert_dob_children_' + key;
                    $(inp).text('Age of Children in not between 2 to 11');
                    $(inp).css("display", "block");

                } else {
                    inp = '#alert_dob_children_' + key;
                    $(inp).css("display", "none");
                }
            } else if (type == 'infant') {
                if (daysDifference > 730 || daysDifference < 0) {
                    inp = '#alert_dob_infant_' + key;
                    $(inp).text('Age of Infant in not between 0 to 2');
                    $(inp).css("display", "block");

                } else {
                    inp = '#alert_dob_infant_' + key;
                    $(inp).css("display", "none");
                }
            };



        })
        //

        $('#booking_dublicate').click(function() {
            $('#booking_dublicate').prop('disabled', true);
            if (!$('#chargesInput').val()) {
                alert('Please Fill Agent Sell Price');
                setTimeout(() => {
                    $('#booking_dublicate').prop('disabled', false);
                }, 3000);
            } else if (!$('#agreechb').is(':checked')) {
                alert('Please Accept Terms & Conditions');
                setTimeout(() => {
                    $('#booking_dublicate').prop('disabled', false);
                }, 3000);
            } else {
                // for (i = 1; i < adult_count + 1; i++) {
                //     var x = 'input[name="passport_expiry_adult_' + i + '"]';
                //     dataPost['passport_expiry_adult_' + i] = $(x)
                //         .val();

                //     var date1 = new Date($('input[name="last_route_departure"]').val());
                //     var inp = 'input[name="dob_adult_' + i + '"]';
                //     var date2 = new Date($(inp).val());

                //     var yearDiff = date1.getFullYear() - date2.getFullYear();
                //     if (yearDiff < 12 || yearDiff < 0) {
                //         // alert('Age of Adult ' + i + ' in not greater than 12');
                //         inp = '#alert_dob_adult_' + i;
                //         $(inp).text('Age of Adult in not greater than 12');
                //         $(inp).css("display", "block");
                //         setTimeout(() => {
                //             $('#booking_dublicate').prop('disabled', false);
                //         }, 3000);
                //         check = false;
                //         break;
                //     } else {
                //         inp = '#alert_dob_adult_' + i;
                //         $(inp).css("display", "none");
                //     };
                // }
                // for (i = 1; i < children_count + 1; i++) {
                //     var x = 'input[name="passport_expiry_children_' + i + '"]';
                //     dataPost['passport_expiry_children_' + i] = $(x).val();
                //     var date1 = new Date($('input[name="last_route_departure"]').val());
                //     var inp = 'input[name="dob_children_' + i + '"]';
                //     var date2 = new Date($(inp).val());

                //     var yearDiff = date1.getFullYear() - date2.getFullYear();

                //     if (yearDiff < 2 || yearDiff > 12 || yearDiff < 0) {
                //         // alert('Age of Children ' + i + ' in not between 2 to 12');
                //         inp = '#alert_dob_children_' + i;
                //         $(inp).text('Age of Children in not between 2 to 12');
                //         $(inp).css("display", "block");
                //         setTimeout(() => {
                //             $('#booking_dublicate').prop('disabled', false);
                //         }, 3000);
                //         check = false;
                //         break;
                //     } else {
                //         inp = '#alert_dob_children_' + i;
                //         $(inp).css("display", "none");
                //     };
                // }
                // for (i = 1; i < infant_count + 1; i++) {
                //     var x = 'input[name="passport_expiry_infant_' + i + '"]';
                //     dataPost['passport_expiry_infant_' + i] = $(x)
                //         .val();
                //     var date1 = new Date($('input[name="last_route_departure"]').val());
                //     var inp = 'input[name="dob_infant_' + i + '"]';
                //     var date2 = new Date($(inp).val());

                //     var yearDiff = date1.getFullYear() - date2.getFullYear();
                //     if (yearDiff > 2 || yearDiff < 0) {
                //         // alert('Age of Infant ' + i + ' in not between 0 to 2');
                //         inp = '#alert_dob_infant_' + i;
                //         $(inp).text('Age of Infant in not between 0 to 2');
                //         $(inp).css("display", "block");
                //         setTimeout(() => {
                //             $('#booking_dublicate').prop('disabled', false);
                //         }, 3000);
                //         check = false;
                //         break;
                //     } else {
                //         inp = '#alert_dob_infant_' + i;
                //         $(inp).css("display", "none");
                //     };
                // }

                $('body').each(function() {
                    $(this).append('<div class="overlay"></div>');
                });
                $('#thankyouModal').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                $('#thankyouModal').modal('show');
                $('#booking_dublicate').prop('disabled', true);

                $('#bookingConfirm').click();

                setTimeout(() => {
                    $('body .overlay').remove();

                    $('#thankyouModal').modal('hide');
                    $('#booking_dublicate').prop('disabled', false);
                }, 10000);


                $('#booking_dublicate').prop('disabled', false);

            }
        })
        var grandPrice = document.getElementById("grandPrice");
        var totalMargin = document.getElementById("totalMargin");
        var chargesInput = document.getElementById("chargesInput");
        var pureAmount = document.getElementById("pureAmount");
        var marginAmount = document.getElementById("marginAmount");
        var receivedInput = document.getElementById("receivedInput");
        var receivedAmount = document.getElementById("receivedAmount");

        var negoInput = document.getElementById("negoInput");
        var negoAmount = document.getElementById("negoAmount");
        var negoAmountResissue = document.getElementById("negoAmountResissue");

        negoInput.addEventListener('keyup', function() {
            negoAmount.value = parseFloat(negoInput.value);
            negoAmountResissue.value = parseFloat(negoInput.value);
        });

        receivedInput.addEventListener('keyup', function() {
            receivedAmount.value = parseFloat(receivedInput.value);
        });

        chargesInput.addEventListener('keyup', function() {
            totalMargin.textContent = parseFloat(pureAmount.value - chargesInput.value).toFixed(2);
            marginAmount.value = parseFloat(chargesInput.value);
        });
    </script>
    @include('inc.timer')
@endsection
