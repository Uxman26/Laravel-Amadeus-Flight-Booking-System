@extends('layouts.app')
@section('content')
    <section>
        <div class="dashboard-content-wrap">

            <div class="dashboard-bread">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <div class="breadcrumb-content">
                                <div class="section-heading">
                                    <h2 class="sec__title font-size-30 text-white mb-4">Package</h2>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-main-content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12 responsive-column--m">
                            <div class="form-box dashboard-card">
                                <div class="form-content p-md-5">
                                    <div class="row mb-5">
                                        <img src="{{ asset($package->image) }}" alt="" style="max-height: 300px"
                                            class="col-md-5 img-fluid border rounded">
                                        <div class="col-md-7">
                                            <h2 class="text-center mb-3" style="color:{{ $color }}">
                                                <b>{{ $package->name }}</b>
                                            </h2>
                                            <div class="row text-center mb-4">
                                                <div class="col-4">
                                                    <h6>Departure Date</h6>
                                                    <h5 style="color:{{ $color }}"><b>{{ $package->departure }}</b>
                                                    </h5>
                                                </div>
                                                <div class="col-4">
                                                    <h6>Duration Of Stay</h6>
                                                    <h5 style="color:{{ $color }}">
                                                        <b>{{ \Carbon\Carbon::parse($package->departure)->diffInDays(\Carbon\Carbon::parse($package->return)) + 1 }}
                                                            Days</b>
                                                    </h5>
                                                </div>
                                                <div class="col-4">
                                                    <h6>Price</h6>
                                                    <h5 style="color:{{ $color }}">
                                                        <b>{{ $package->quadruple_room_price }} EUR</b>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="row mb-3 ms-md-5" >
                                                <h4 class="mb-2"><b>From
                                                        {{ \Carbon\Carbon::parse($package->departure)->format('d/M/Y') }} to
                                                        {{ \Carbon\Carbon::parse($package->return)->format('d/M/Y') }}</b>
                                                </h4>
                                                <h6 class="mb-3">{!! $package->description !!}
                                                </h6>
                                                <h6 class="mb-2">Mecca Hotel : <b>{{ $package->mecca_hotel }}</b></h6>
                                                <h6 class="mb-2">Madina Hotel : <b>{{ $package->madina_hotel }}</b></h6>
                                                <h6 class="mb-2">Stay : <b>France >> Medina >> Mecca</b></h6>
                                                <h6 class="mb-2">Departure cities :<b>Paris</b></h6>
                                                <h6 class="mb-2">Period : <b>From {{ $package->departure }} to
                                                        {{ $package->return }}</b></h6>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <h2 class="text-center mb-3" style="color:{{ $color }}"><b>RATES OF
                                                ROOMS</b></h2>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-2 col-6 mb-5 mb-md-0 text-center">
                                            <h5><b>1 Bed Room</b></h5><img src="{{ asset('assets/img/1bed.png') }}"
                                                class="img-fluid" alt="">
                                            <h4><b>{{ $package->single_room_price }} EUR</b></h4>
                                            <h6>per person</h6>
                                        </div>
                                        <div class="col-md-2 col-6 mb-5 mb-md-0 text-center">
                                            <h5><b>2 Bed Room</b></h5><img src="{{ asset('assets/img/2bed.png') }}"
                                                class="img-fluid" alt="">
                                            <h4><b>{{ $package->double_room_price }} EUR</b></h4>
                                            <h6>per person</h6>
                                        </div>
                                        <div class="col-md-2 col-6 mb-5 mb-md-0 text-center">
                                            <h5><b>3 Bed Room</b></h5><img src="{{ asset('assets/img/3bed.png') }}"
                                                class="img-fluid" alt="">
                                            <h4><b>{{ $package->triple_room_price }} EUR</b></h4>
                                            <h6>per person</h6>
                                        </div>
                                        <div class="col-md-2 col-6 mb-5 mb-md-0 text-center">
                                            <h5><b>4 Bed Room</b></h5><img src="{{ asset('assets/img/4bed.png') }}"
                                                class="img-fluid" alt="">
                                            <h4><b>{{ $package->quadruple_room_price }} EUR</b></h4>
                                            <h6>per person</h6>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <h5 class="mb-4"><b>Prices Children*</b></h5>
                                            <h6><b>Child from 2 to 11 years old <br>
                                                    -{{ $package->children_price_deduction }} EUR on the formula <br> Child
                                                    under 2 years old: {{ $package->infant_price }} EUR</b></h6>
                                        </div>
                                        <a href="{{ route('admin.package.booking', ['id' => $package->id]) }}"
                                            class="btn btn-primary col-md-4 mt-4">Reserve</a>
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
