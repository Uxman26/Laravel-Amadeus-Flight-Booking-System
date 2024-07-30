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
                                <h2 class="sec__title font-size-30 text-white mb-4">Footer Section</h2>
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
                                    <h3 class="title pb-4">Settings</h3>
                                    <form action="{{ route('admin.footer.settings.save') }}" method="POST">
                                    @csrf
                                        <div class="form-content p-2">
                                            <div class="list-group drop-reveal-list">
                                                <div class="col-md-6 mx-auto">
                                                    <label for="facebook">Facebook</label>
                                                    <input type="text" name="facebook" class="form-control" value="@if(isset($settings) && !empty($settings)){!! $settings->facebook !!}@endif">
                                                    <label for="twitter">Twitter</label>
                                                    <input type="text" name="twitter" class="form-control" value="@if(isset($settings) && !empty($settings)){!! $settings->twitter !!}@endif">
                                                    <label for="whatsapp">WhatsApp</label>
                                                    <input type="text" name="whatsapp" class="form-control" value="@if(isset($settings) && !empty($settings)){!! $settings->whatsapp !!}@endif">
                                                    <label for="instagram">Instagram</label>
                                                    <input type="text" name="instagram" class="form-control" value="@if(isset($settings) && !empty($settings)){!! $settings->instagram !!}@endif">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-content p-2">
                                            <div class="list-group drop-reveal-list">
                                                <div class="col-md-10 mx-auto">
                                                    <div class="card m-2">
                                                        <label for="ApiLiveMode" class="form-check-label">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="policy">Privacy Policy</label>
                                                                    <textarea class="form-control policy" name="policy" id="policy">@if(isset($settings) && !empty($settings)){!! $settings->policy !!}@endif</textarea>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="card m-2">
                                                        <label for="ApiLiveMode" class="form-check-label">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="aboutus">About Us</label>
                                                                    <textarea class="form-control aboutus" name="aboutus" id="aboutus">@if(isset($settings) && !empty($settings)){!! $settings->aboutus !!}@endif</textarea>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-large">Update</button>
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
@section('footer')
@livewireScripts
@powerGridScripts
@endsection
<script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script>
$(document).ready(function () {
    CKEDITOR.replace('policy');
    CKEDITOR.replace('aboutus');
});
</script>