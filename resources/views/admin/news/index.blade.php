@extends('layouts.app')
@section('head')
@livewireStyles
@livewireStyles
@powerGridStyles
@endsection
@section('content')
@include('inc.admin.nav')
    @php
        $newsbg = option('newsbg');
        $newscolor = option('newscolor');null;
        $newsdirection = option('newsdirection');null;
    @endphp
<section class="dashboard-area">
    <div class="dashboard-content-wrap">

        <div class="dashboard-bread">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="breadcrumb-content">
                            <div class="section-heading">
                                <h2 class="sec__title font-size-30 text-white mb-4">News Section</h2>
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
                                    <h3 class="title pb-4">News</h3>
                                    <div class="col-md-4">
                                        <form action="{{ route('admin.news.settings') }}" method="POST">
                                        @csrf
                                            <label for="news_body">Color</label>
                                            <input type="color" name="color" class="form-control" value="@if(isset($newscolor) && !empty($newscolor)){{ $newscolor }}@endif">
                                            <label for="news_body">Background Color</label>
                                            <input type="color" name="bgcolor" class="form-control" value="@if(isset($newsbg) && !empty($newsbg)){{ $newsbg }}@endif">
                                            <label for="news_body">Direction</label>
                                            <div class="card mb-2">
                                                <label for="newsdirection" class="form-check-label">
                                                    <div class="card-body">
                                                        <div class="form-group d-flex text-center justify-content-center">
                                                            Right-To-Left
                                                            <div class="form-check form-switch">
                                                                
                                                                <input class="form-check-input ms-1 me-5" type="checkbox" name="newsdirection" role="switch" id="newsdirection" {{ option('newsdirection') ? 'checked' : '' }}>
                                                                
                                                            </div>
                                                            Left-To-Right
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <label for="news_body">Maintenance Mood</label>
                                            <div class="card mb-2">
                                                <label for="maintenance_mode" class="form-check-label">
                                                    <div class="card-body">
                                                        <div class="form-group d-flex text-center justify-content-center">
                                                            Right-To-Left
                                                            <div class="form-check form-switch">
                                                                
                                                                <input class="form-check-input ms-1 me-5" type="checkbox" name="maintenance_mode" role="switch" id="maintenance_mode" {{ option('maintenance_mode') == 'on' ? 'checked' : '' }}>
                                                                
                                                            </div>
                                                            Left-To-Right
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-large">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="form-content p-2">
                                <div class="list-group drop-reveal-list">
                                    <div class="col-md-6 mx-auto">
                                        <form action="{{ route('admin.news.store') }}" method="POST">
                                            @csrf
                                            
                                            <div class="card mb-2">
                                                <label for="ApiLiveMode" class="form-check-label">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="news_body">News Body</label>
                                                            <input type="hidden" name="nid" value="@if(isset($news1->news_body) && !empty($news1->news_body)){{ $news1->id }}@endif">
                                                            <textarea class="form-control" name="news_body" id="news_body">@if(isset($news1->news_body) && !empty($news1->news_body)){{ $news1->news_body }}@endif</textarea>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="form-group mb-2">
                                                @if(isset($news1->news_body) && !empty($news1->news_body))
                                                    <button type="submit" class="btn btn-primary btn-large">Update</button>
                                                @else
                                                    <button type="submit" class="btn btn-primary btn-large">Add</button>
                                                @endif
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
                            @forelse ($news as $n)
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
                                                <h6 class="mb-0 text-sm">{{ $n->news_body }}</h6>
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
                                                <h6 class="mb-0 text-sm"><a href="{{ route('admin.news.edit', $n->id) }}" class="btn btn-sm">Edit</a>
                                                                        <form action="{{ route('admin.news.destroy', $n->id) }}" method="POST">
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