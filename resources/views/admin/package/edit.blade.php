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
                                    <h2 class="sec__title font-size-30 text-white mb-4">Packages</h2>

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
                                        <h3 class="title">Edit Package</h3>
                                    </div>
                                </div>
                                <div class="form-content p-2">
                                    <div class="list-group drop-reveal-list">
                                        <form action="{{ route('admin.package.update_package') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$package->id}}">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="image">Package Name</label>
                                                    <input type="text" name="name" class="form-control" value="{{$package->name}}" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Mecca Hotel</label>
                                                    <input type="text" name="mecca_hotel" class="form-control" value="{{$package->mecca_hotel}}" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Madina Hotel</label>
                                                    <input type="text" name="madina_hotel" class="form-control" value="{{$package->madina_hotel}}" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Single Room Price</label>
                                                    <input type="number" name="single_room_price" class="form-control" value="{{$package->single_room_price}}" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Double Room Price</label>
                                                    <input type="number" name="double_room_price" class="form-control" value="{{$package->double_room_price}}" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Triple Room Price</label>
                                                    <input type="number" name="triple_room_price" class="form-control" value="{{$package->triple_room_price}}" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Quadruple Room Price</label>
                                                    <input type="number" name="quadruple_room_price" class="form-control" value="{{$package->quadruple_room_price}}" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Children Price Deduction</label>
                                                    <input type="number" name="children_price_deduction"
                                                        class="form-control" value="{{$package->children_price_deduction}}" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Infant Price</label>
                                                    <input type="numbe" name="infant_price" class="form-control" value="{{$package->infant_price}}" required>
                                                </div>
                                                
                                                <div class="form-group col-md-4">
                                                    <label for="image">Departure Date</label>
                                                    <input type="date" name="departure" class="form-control" value="{{$package->departure}}" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Return Date</label>
                                                    <input type="date" name="return" class="form-control" value="{{$package->return}}" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="image">Image</label>
                                                    <input type="file" accept="image/png, image/jpeg, image/jpg" name="image" class="form-control" >
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="image">Description</label>
                                                    <textarea class="form-control" style="width:100%" id="description" name="description">{{ $package->description ?? null }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <button type="submit" class="btn btn-primary col-md-auto m-3">Submit</button>
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
@section('footer')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
         ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                editor.ui.view.editable.element.style.height = '100px';
                editor.maxLength = '1000';
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
