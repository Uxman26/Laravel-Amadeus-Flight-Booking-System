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
                                    <h2 class="sec__title font-size-30 text-white mb-4">Package Bookings</h2>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-main-content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-10 responsive-column--m">
                            <div class="form-box dashboard-card">
                                <div class="form-title-wrap">
                                    <div class="">
                                        <h3 class="title">Package Booking</h3>
                                    </div>
                                </div>
                                <div class="form-content p-5">
                                    <div class="list-group drop-reveal-list">
                                        <form action="{{ route('admin.package.store_booking') }}" method="POST" class="ml-5"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class=" mb-5">
                                                <h5><b>Package: </b>{{ $package->name }}</h5>
                                                <h5><b>Mecca Hotel: </b>{{ $package->mecca_hotel }}</h5>
                                                <h5><b>Madina Hotel: </b>{{ $package->madina_hotel }}</h5>
                                                <h5><b>Departure Date: </b>{{ $package->departure }}</h5>
                                                <h5><b>Return Date: </b>{{ $package->return }}</h5>
                                                <h5><b>Period: </b>{{ \Carbon\Carbon::parse($package->departure)->diffInDays(\Carbon\Carbon::parse($package->return)) + 1 }}</h5>
                                            </div>
                                            <div class="row">
                                                <input type="hidden" name="id" value="{{ $package->id }}">
                                                <input type="hidden" name="price">
                                                <div class="form-group col-md-6">
                                                    <label for="image">Given Name / Prénom</label>
                                                    <input type="text" name="first_name" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="image">Surname / Nom</label>
                                                    <input type="text" name="last_name" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="image">Phone Number</label>
                                                    <input type="number" name="phone_number" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="image">Email</label>
                                                    <input type="email" name="email" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="image">Address</label>
                                                    <input type="text" name="address" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="image">Nationality</label>
                                                    <select name="nationality" class="form-control" required>
                                                        <option value="" selected hidden>Select Nationality</option>
                                                        <option value="europian">Europian</option>
                                                        <option value="non-europian">non-Europian</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="image">Rooms</label>
                                                    <select type="text" name="rooms" class="form-control" required>
                                                        <option value="" selected hidden>Select Room ...</option>
                                                        <option value="single">Single ({{ $package->single_room_price }}
                                                            EUR)</option>
                                                        <option value="double">Double ({{ $package->double_room_price }}
                                                            EUR)</option>
                                                        <option value="triple">Triple ({{ $package->triple_room_price }}
                                                            EUR)</option>
                                                        <option value="quadruple">Quadruple
                                                            ({{ $package->quadruple_room_price }} EUR)</option>
                                                    </select>
                                                </div>
                                                <h3 class="my-2">Number of Travelers</h3>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Adults (12 years and over) </label>
                                                    <input type="number" name="adults" class="form-control" value="0" min="0" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Children (2-11 years)
                                                        (-{{ $package->children_price_deduction }} EUR)</label>
                                                    <input type="number" name="childrens" class="form-control" value="0" min="0" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Babies (2 years and less)
                                                        ({{ $package->infant_price }} EUR)</label>
                                                    <input type="number" name="infants" class="form-control" value="0" min="0" required>
                                                </div>
                                                <div class="form-group my-2 col-md-12">
                                                    <input type="checkbox" name="checkbox" required>
                                                    <label>By continuing, you agree to the
                                                        <a href="#">Terms and Conditions</a>
                                                        Confirm Booking</label>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center text-center">
                                                <h3 id="total_price"></h3>
                                            </div>
                                            
                                            <div class="row">
                                                <button type="submit"
                                                    class="btn btn-primary col-md-auto m-3">Submit</button>
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
    <input type="hidden" name="" value="{{ $package->single_room_price }}" id="single">
    <input type="hidden" name="" value="{{ $package->double_room_price }}" id="double">
    <input type="hidden" name="" value="{{ $package->triple_room_price }}" id="triple">
    <input type="hidden" name="" value="{{ $package->quadruple_room_price }}" id="quadruple">
    <input type="hidden" name="" value="{{ $package->children_price_deduction }}" id="children_price_deduction">
    <input type="hidden" name="" value="{{ $package->infant_price }}" id="infant_price">
@endsection
@section('footer')
    @livewireScripts
    @powerGridScripts
    <script>
        $(document).ready(function() {
            $('input[name="adults"], input[name="childrens"], input[name="infants"], select[name="rooms"], select[name="nationality"]').on(
            'change keypress keyup click',function() {
                var rooms = $('select[name="rooms"]').val();
                var price = 0;
                if (rooms == 'single') {
                    price = $('#single').val();
                } else if (rooms == 'double') {
                    price = $('#double').val();
                } else if (rooms == 'triple') {
                    price = $('#triple').val();
                } else if (rooms == 'quadruple') {
                    price = $('#quadruple').val();
                }
                var nationality = $('select[name="nationality"]').val();
                
                var adults = Number($('input[name="adults"]').val());
                var childrens = Number($('input[name="childrens"]').val());
                var infants = Number($('input[name="infants"]').val());
                var infant_price = $('#infant_price').val();
                var children_price_deduction = $('#children_price_deduction').val();
                if(nationality == 'europian'){
                    nationality = 0;
                } else {
                    var x = adults + childrens + infants; 
                    nationality = 130 * x;
                }
                var final_price = (price*adults) + ((price-children_price_deduction)*childrens) + (infant_price*infants) + nationality;
                $('#total_price').empty("");
                $('#total_price').append("<b>"+final_price+" EUR</b>");
                $('input[name="price"]').val(final_price);
            });
        })
    </script>
@endsection
