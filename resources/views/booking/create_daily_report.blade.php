@extends('layouts.app')
@section('head')
    @livewireStyles
    @livewireStyles
    @powerGridStyles
@endsection
@section('content')
<style>
    .select2-container .select2-selection--single {
    height: 45px !important;
    }
    .select2-container--classic .select2-selection--single .select2-selection__arrow {
    height: 45px !important;
    }
    .select2-container--classic .select2-selection--single .select2-selection__rendered {
    height: 45px !important;
    }
</style>
    <link rel="stylesheet" href="{{ asset('assets/tel/build/css/intlTelInput.css') }}">
    <script src="{{ asset('assets/tel/build/js/intlTelInput-jquery.min.js') }}"></script>
    <section class="">
        <div class="dashboard-content-wrap">
            <div class="dashboard-bread">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="breadcrumb-content">
                                <div class="section-heading">
                                    <h2 class="sec__title font-size-30 text-white mb-4">Daily Report Section</h2>
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
                                        <h3 class="title">Order Management</h3>
                                    </div>
                                </div>
                                <div class="form-content p-2">
                                    <div class="list-group drop-reveal-list">
                                        <div class="col-md-10 mx-auto">
                                            <form class="row" id="order_form"
                                                action="{{ route('booking.store_daily_report') }}" method="POST">
                                                @csrf
                                                @foreach ($request->all() as $key => $item)
                                                    <input type="hidden" name="{{ $key }}"
                                                        value="{{ $item }}">
                                                @endforeach
                                                <div class="form-group mb-2 col-md-4">
                                                    <label>First Name</label>
                                                    <input required type="text" name="firstname" class="form-control"
                                                        placeholder="First Name">
                                                </div>
                                                <div class="form-group mb-2 col-md-4">
                                                    <label>Last Name</label>
                                                    <input required type="text" name="lastname" class="form-control"
                                                        placeholder="Last Name">
                                                </div>
                                                <div class="form-group mb-2 col-md-4">
                                                    <label>Phone Number</label><br>
                                                    <input required type="tel" name="phone_number" id="phone_number"
                                                        class="form-control" placeholder="Phone Number">
                                                </div>
                                                <div class="form-group mb-2 col-md-4">
                                                    <label>Email</label>
                                                    <input required type="email" name="email" class="form-control"
                                                        placeholder="Email">
                                                </div>
                                                @php
                                                    $airlines = App\Models\Airline::all();
                                                @endphp
                                                <div class="form-group mb-2 col-md-4">
                                                    <label>Preffered Airline</label>
                                                    {{-- <input required type="text" name="preffered_airline"
                                                        class="form-control" placeholder="Preffered Airline"> --}}
                                                    <br />
                                                    <select name="preffered_airline" id="preffered_airline"
                                                        class="preffered_airline" multiple="multiple">
                                                        @foreach ($airlines as $item)
                                                            <option value="{{ $item->code }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group mb-2 col-md-2 mt-4">
                                                    <input type="checkbox" name="flexible_date">
                                                    <label>My Dates are Flexible</label>
                                                </div>
                                                <div class="form-group mb-2 col-md-12">
                                                    <label>Remarks</label><br>
                                                    <textarea name="remark" id="" class="form-control" cols="100" rows="2"></textarea>
                                                </div>
                                                <div class="form-group mb-2 col-md-12">
                                                    <input type="checkbox" name="checkbox" required>
                                                    <label>By continuing, you agree to the
                                                        <a href="#">Terms and Conditions</a>
                                                        Confirm Order</label>
                                                </div>
                                                <input type="text" style="opacity: 0" name="check">
                                                <div class="form-group mb-2">
                                                    <button type="submit" id="order_button"
                                                        class="btn btn-primary btn-large">Add
                                                        Order</button>
                                                </div>
                                            </form>
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
    <script>
        $("#phone_number").intlTelInput({
            allowDropdown: true,
            countrySearch: true,
            fixDropdownWidth: true,
            initialCountry: "fr",
        });
        $("#order_form").submit(function() {
            $("#order_button").prop('disabled', true);
        });
        $("#preffered_airline").select2({
            theme: "classic", // Setting the theme to classic
            multiple: false, // Allowing only single selection
            matcher: function(params, data) {
                if (typeof data.text === 'undefined') {
                    return null;
                }
                if (params.term === '' || typeof params.term === 'undefined') {
                    return data;
                } else {
                    var q = params.term.toUpperCase();
                    if (data.text.toUpperCase().indexOf(q) > -1 || data.id.toUpperCase().indexOf(q) > -1) {
                        return $.extend({}, data, true);
                    }
                }
                // Return `null` if the term should not be displayed
                return null;
            },
            templateSelection: function(data, container) {
                return data.id;
            }
        });
        $("#preffered_airline").val("QR").trigger("change");
    </script>
@endsection
