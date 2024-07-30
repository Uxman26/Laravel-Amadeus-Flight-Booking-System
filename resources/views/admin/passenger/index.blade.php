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
                                    <h3 class="title">Passengers List</h3>
                                    <a href="{{ route('admin.export.passenger') }}" class="btn btn-primary">Export Passengers</a>
                                </div>
                            </div>
                            <div class="form-content p-2">
                                <div class="list-group drop-reveal-list">
                                    <div class="mb-4">
                                        <form action="{{ route('admin.import.passenger') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="passenger">Import Passenger Backup File</label>
                                                <input type="file" name="passenger" id="passenger" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Import Passenger</button>
                                            </div>
                                        </form>
                                    </div>
                                    <livewire:admin.booking.all-passengers />
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