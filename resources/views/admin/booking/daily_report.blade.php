@extends('layouts.app')
@section('head')
    @livewireStyles
    @livewireStyles
    @powerGridStyles
@endsection
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
                                    <h2 class="sec__title font-size-30 text-white mb-4">All Bookings</h2>
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
                                    <div class="d-flex justify-content-between">
                                        <h3 class="title">Latest Booking Entries (Today Departure =
                                            <b>{{ todayDeparture() }}</b>)
                                        </h3>
                                    </div>
                                </div>
                                <div class="form-content p-2">
                                    <div class="list-group drop-reveal-list">
                                        <div class="mb-4">
                                            <div class="form-group">
                                            @section('head')
                                                @livewireStyles
                                                @livewireStyles
                                                @powerGridStyles
                                            @endsection
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
                                                                                <h2
                                                                                    class="sec__title font-size-30 text-white mb-4">
                                                                                    All Daily Reports</h2>
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
                                                                                <div class="d-flex justify-content-between">
                                                                                    <h3 class="title">Latest Daily
                                                                                        Report Entries</h3>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-content p-2">
                                                                                <div class="list-group drop-reveal-list">
                                                                                    <livewire:admin.daily-reports-table />
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
                                            @section('footer')
                                                @livewireScripts
                                                @powerGridScripts
                                            @endsection Backup File
                                            </label>
                                        </div>
                                    </div>
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
@section('footer')
@livewireScripts
@powerGridScripts
@endsection
