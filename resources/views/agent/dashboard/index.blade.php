@extends('layouts.app')
@section('content')
@if (auth()->user()->role == 1)
@include('inc.admin.nav')
@elseif(auth()->user()->role == 2)
@include('inc.agent.nav')
@endif
<section class="dashboard-area">
    <div class="dashboard-content-wrap">
        <div class="dashboard-bread">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="breadcrumb-content">
                            <div class="section-heading">
                                <h2 class="sec__title font-size-30 text-white">Hi, <span style="text-transform:capitalize">{{ auth()->user()->name }}</span> Welcome Back</h2>
                            </div>
                            <h4 class=" text-white">From {{now()->startOfMonth()->format('d-M-Y')}} To {{ now()->endOfMonth()->format('d-M-Y')}}</h4>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="breadcrumb-list text-right">
                            <p style="font-weight:bold;color:#fff" id="ct">{{ now() }}</p>
                        </div>
                    </div>
                    <div class="col-md-2 float-right mt-3">
                        <form action="{{ route('agent.dashboard.index') }}" id="form">
                            <div id="dateForm" class="form-inline d-flex">
                                <div class="form-group  ml-auto d-flex">
                                    <label for="" class="mr-2 text-white mt-2">From: </label>
                                    <input type="date" id="dateFrom"
                                        @if ($request->from) value="{{ $request->from }}" @endif
                                        class="form-control   mr-sm-2 border-white" name="from"
                                        placeholder="From" required>
                                </div>
                                <div class="form-group d-flex ms-2">
                                    <label for="" class="mr-2 text-white mt-2">To: </label>
                                    <input type="date" id="dateTo"
                                        @if ($request->to) value="{{ $request->to }}" @endif
                                        class="form-control   mr-sm-2 dateTo border-white" name="to"
                                        placeholder="To">
                                </div>
                                
                            <button type="submit" class="btn btn-info ms-3">Search</button>
                            </div>
                        </form>
                    </div>
                </div> 
                <div class="row mt-4">
                    <div class="col-md-3 col-12 responsive-column-m user_wallet">
                        <div class="icon-box icon-layout-2 dashboard-icon-box">
                            <div class="d-flex">
                                <div class="info-icon icon-element flex-shrink-0">
                                    <i class="la la-wallet"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info__desc">My Balance</p>
                                    <h4 class="info__title">EUR {{ number_format(getBalance(auth()->user()->id),2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 responsive-column-m">
                        <div class="icon-box icon-layout-2 dashboard-icon-box">
                            <div class="d-flex">
                                <div class="info-icon icon-element bg-2 flex-shrink-0">
                                    <i class="la la-shopping-cart"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info__desc">Total Credit</p>
                                    <h4 class="info__title">EUR {{ number_format(totalCredit(auth()->user()->id),2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 responsive-column-m">
                        <div class="icon-box icon-layout-2 dashboard-icon-box">
                            <div class="d-flex">
                                <div class="info-icon icon-element bg-3 flex-shrink-0">
                                    <i class="la la-clock"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info__desc">Total Debit</p>
                                    <h4 class="info__title">EUR {{ number_format(totalDebit(auth()->user()->id),2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 responsive-column-m">
                        <div class="icon-box icon-layout-2 dashboard-icon-box">
                            <div class="d-flex">
                                <div class="info-icon icon-element bg-4 flex-shrink-0">
                                    <i class="la la-star"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info__desc">Total Ticket Sold</p>
                                    <h4 class="info__title">{{ number_format(totalTicketSoldAgent(),2) }} EUR</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 responsive-column-m">
                        <div class="icon-box icon-layout-2 dashboard-icon-box">
                            <div class="d-flex">
                                <div class="info-icon icon-element bg-2 flex-shrink-0">
                                    <i class="la la-shopping-cart"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info__desc">Reservations</p>
                                    <h4 class="info__title">{{ bookedBookingsAgent() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 responsive-column-m">
                        <div class="icon-box icon-layout-2 dashboard-icon-box">
                            <div class="d-flex">
                                <div class="info-icon icon-element bg-2 flex-shrink-0">
                                    <i class="la la-shopping-cart"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info__desc">Issued Ticket</p>
                                    <h4 class="info__title">{{ issuedBookingsAgent() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 responsive-column-m">
                        <div class="icon-box icon-layout-2 dashboard-icon-box">
                            <div class="d-flex">
                                <div class="info-icon icon-element bg-2 flex-shrink-0">
                                    <i class="la la-shopping-cart"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info__desc">Cancel Bookings</p>
                                    <h4 class="info__title">{{ cancelBookingsAgent() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 responsive-column-m">
                        <div class="icon-box icon-layout-2 dashboard-icon-box">
                            <div class="d-flex">
                                <div class="info-icon icon-element bg-2 flex-shrink-0">
                                    <i class="la la-business-time"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info__desc">Today Departure</p>
                                    <h4 class="info__title">{{ todayDepartureAgent() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 responsive-column-m">
                        <div class="icon-box icon-layout-2 dashboard-icon-box">
                            <div class="d-flex">
                                <div class="info-icon icon-element bg-2 flex-shrink-0">
                                    <i class="la la-shopping-cart"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info__desc">Total Due Amount</p>
                                    <h4 class="info__title">{{ number_format(totalReceivableAgent(),2) }}</h4>
                                </div>
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
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="title">Recent Searches</h3>
                                    <button type="button" class="icon-element mark-as-read-btn ml-auto mr-0 ">
                                        <i class="la la-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-content p-0">
                                <div class="list-group drop-reveal-list">
                                    @foreach (mySearches(auth()->user()->id) as $result)
                                    <a href="{{ $result->uri }}" class="list-group-item list-group-item-action border-top-0 " target="_blank">
                                        <div class="msg-body d-flex align-items-center">
                                            <div class="icon-element flex-shrink-0 mr-3 ml-0">{{$loop->iteration}}</div>
                                            <div class="msg-content w-100">
                                                <h3 class="title pb-1 px-2" style="text-transform:uppercase">flights - {{$result->origin}}<i class="la la-arrow-right px-1"></i>{{$result->destination}}</h3>
                                                <p class="msg-text px-2">{{ $result->uri }}</p>
                                            </div>
                                            <span class="icon-element mark-as-read-btn flex-shrink-0 ml-auto mr-0">
                                                <i class="la la-check-square"></i>
                                            </span>
                                        </div>
                                    </a>
                                    @endforeach
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
{{-- <script>
    $(document).ready(function() {
            var dateFrom = $('#dateFrom').val();
            $('#dateTo').attr('min', dateFrom);
        });
        $('#dateFrom').on('keyup keypress change', function() {
            var dateFrom = $(this).val();
            $('#dateTo').attr('min', dateFrom);
        });
        $('#dateTo').on('keyup keypress change', function() {
            var dateFrom = $('#dateFrom').val();
            console.log(dateFrom);
            if (!dateFrom) {
                alert('From Date Is Required');
                $('#dateTo').val('');
                return;
            }
            $('#form').submit();
        });
</script> --}}
@endsection