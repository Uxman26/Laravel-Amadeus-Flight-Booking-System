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
                                <h2 class="sec__title font-size-30 text-white mb-4">Promostions Section</h2>
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
                                    <h3 class="title pb-4">Promostions</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="border-top mt-4">
                        <table class="table align-items-center table-hover table-stripped table-bordered mb-0">
                            <tbody>
                            @forelse ($promos as $p)
                                <tr>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{!! $p->id !!}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm"><a href="{{ url('slider/promotion/'.$p->slug)}}">{{ $p->promotext }}</a></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $p->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $p->email }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $p->phone }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $p->message }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ date('d-m-Y', strtotime($p->updated_at)) }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ date('h:i A', strtotime($p->updated_at)) }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    <form action="{{ route('admin.promotion.destroy', $p->id) }}" method="POST">
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
                                <tr><td colspan="6" align="center">No entry</td></tr>
                            @endforelse
                            </tbody>
                        </table>

                        <div class="row pt-4">
                            <div class="col-12 responsive-column--m">
                                <div class="form-box dashboard-card">
                                    <div class="form-title-wrap">
                                        <div class="">
                                            <h3 class="title pb-4">Guests</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <table class="table align-items-center table-hover table-stripped table-bordered mb-0">
                            <tbody>
                            @forelse ($guests as $g)
                                <tr>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{!! $g->id !!}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $g->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $g->email }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $g->phone }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $g->message }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ date('d-m-Y', strtotime($g->updated_at)) }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ date('h:i A', strtotime($g->updated_at)) }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    <form action="{{ route('admin.promotion.destroy', $g->id) }}" method="POST">
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
                                <tr><td colspan="6" align="center">No entry</td></tr>
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