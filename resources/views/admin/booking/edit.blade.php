@extends('layouts.app')
@section('content')
@include('inc.admin.nav')
<section class="dashboard-area">
    <div class="dashboard-content-wrap">

        <div class="dashboard-bread">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="breadcrumb-content">
                            <div class="section-heading">
                                <h2 class="sec__title font-size-30 text-white mb-4">Edit Booking PNR {{ $booking->pnr }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 responsive-column--m">
                        <div class="form-box dashboard-card">
                            <div class="form-title-wrap">
                                <div class="">
                                    <h3 class="title">Recent Searches</h3>
                                </div>
                            </div>
                            <div class="form-content p-4">
                                <div class="list-group drop-reveal-list">
                                    <form action="#" method="POST">
                                        @csrf
                                        @method('UPDATE')
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pnr">PNR</label>
                                                    <input type="text" name="pnr" id="pnr" value="{{ $booking->pnr }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="trip_type">TRIP TYPE</label>
                                                    <select name="trip_type" id="trip_type" class="form-control">
                                                        <option value="oneway">Oneway</option>
                                                        <option value="return">Round Trip</option>
                                                        <option value="multicity">Multi City</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="status">STATUS</label>
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="Waiting For Payment">Waiting For Payment</option>
                                                        <option value="Paid">Paid</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="payment_method">Payment Method</label>
                                                    <select name="payment_method" id="payment_method" class="form-control">
                                                        <option value="bank-transfer">Bank</option>
                                                        <option value="cash">Cash</option>
                                                        <option value="card">Card</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_ticketing_date">Last Ticketing Date</label>
                                                    <input type="text" name="last_ticketing_date" id="last_ticketing_date" value="{{ $booking->last_ticketing_date }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="amount">Amount</label>
                                                    <input type="text" name="amount" value="{{ $booking->amount }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="agent_margin">Agent Margin</label>
                                                    <input type="text" name="agent_margin" id="agent_margin" value="{{ $booking->agent_margin }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="remarks">Remarks</label>
                                                    <input type="text" name="remarks" id="remarks" value="{{ $booking->remarks }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-lg">Update PNR</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="border-top mt-4"></div>
            </div>
        </div>
    </div>
</section>
@endsection