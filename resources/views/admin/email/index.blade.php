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
                                <h2 class="sec__title font-size-30 text-white mb-4">Email Section</h2>
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
                                    <h3 class="title pb-4">Email</h3>
                                    <div class="col-md-4">
                                        <form action="{{ route('admin.email.send') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="news_body">Subject</label>
<input type="text" name="subject" class="form-control" required>                                        </div>
                                        <div class="form-group">
                                            <label for="news_body">Message</label>
                                            <textarea name="content" id="content" rows="10" class="form-control col-md-12" required></textarea>
                                        </div>
                                            <button type="submit" class="btn btn-primary btn-large mt-5">Send To All</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer')
@livewireScripts
@powerGridScripts
@endsection