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
            <h2 class="text-center" style="color:#fff">Privacy Policy</h2>
            <hr style="margin: 4px 0; color: #fff;border-color:#fff">
            <br>
            <div class="row" style="background-color: #fff">
                <div class="col-md-12">
                    @if(isset($settings) && !empty($settings)){!! $settings->policy !!}@endif
                </div>
            </div>
        </div>
    </section>
</section>
@include('inc.info')
@include('inc.footer')
@endsection