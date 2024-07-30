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
                                <h2 class="sec__title font-size-30 text-white mb-4">Banner Section</h2>
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
                                    <h3 class="title">Banner</h3>
                                </div>
                            </div>
                            <div class="form-content p-2">
                                <div class="list-group drop-reveal-list">
                                    <div class="col-md-6 mx-auto">
                                        <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
											<div class="card mb-2">
                                                <label for="ApiLiveMode" class="form-check-label">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                        <label for="image">Logo Image</label>
                                                        <input type="file" name="logo_image" class="form-control" accept="image/png, image/gif, image/jpeg">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="card mb-2">
                                                <label for="ApiLiveMode" class="form-check-label">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                        <label for="image">Banner Image</label>
                                                        <input type="file" name="image" class="form-control" accept="image/png, image/gif, image/jpeg">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="form-group mb-2">
                                                <button type="submit" class="btn btn-primary btn-large">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="border-top mt-4">
                        <table class="table align-items-center table-hover table-stripped table-bordered mb-0">
                            <tbody>
                            @forelse ($banner as $n)
                                <tr>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{!! $n->id !!}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $n->user_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm"><a href="{{ asset('assets/banner/'.$n->image) }}">{{ $n->image }}</a></h6>
                                            </div>
                                        </div>
                                    </td>
									<td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm"><a href="{{ asset('assets/logo/'.$n->logo_image) }}">{{ $n->logo_image }}</a></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ date('d-m-Y', strtotime($n->updated_at)) }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ date('h:i A', strtotime($n->updated_at)) }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $n->ishidden == "0" ? "Visible" : "Hidden" }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    <form action="{{ route('admin.banner.destroy', $n->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-sm">Delete</button>
                                                    </form>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" align="center">No news</td></tr>
                            @endforelse
                            </tbody>
                        </table>
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