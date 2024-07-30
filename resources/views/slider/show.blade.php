@extends('layouts.app')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<style>
    :root {
      --bg-image: url({{ asset('assets/banner/'.$banner->image) }}); /* Replace $imageUrl with your actual variable */
      --news-bg: {{option('newsbg')}};
      --news-color: {{option('newscolor')}};
    }
</style>
<div class="marquee-container">
  <div class="marquee-content">
    <!-- Your marquee text here -->
    @forelse ($news as $n)
        &#x2022 {{$n->news_body}}
    @empty
    @endforelse
  </div>
</div>
<section class="breadcrumb-area bread-bg-flights">
    <section class="container" style="border-radius:10px;padding:100px 0px">
        <div class="container">
            <div class="row">
                <div class="col-md-12 promo">
                    <img src="{{ asset('assets/slider/'.$promos->image) }}" alt="" class="d-block w-100" height="350">
                    <h2 class="text-center pb-2"><u>{{$promos->promotext}}</u></h2>
                    <form action="{{ url('slider/promotion/'.$promos->slug.'/save')}}" method="POST" class="pb-4">
                    @csrf
                    <input type="hidden" name="promo_id" value="{{$promos->id}}">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <label for="news_body">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="news_body">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <label for="news_body">Message</label>
                            <textarea class="form-control" name="message"></textarea>
                        </div>
                    </div>
                    <div class="row pt-2">
                    <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary btn-large form-control">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
@include('inc.footer')
@endsection