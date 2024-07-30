@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aldrich">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <style>
        :root {
            --bg-image: url({{ asset('assets/banner/' . $banner->image) }});
            /* Replace $imageUrl with your actual variable */
            --news-bg: {{ option('newsbg') }};
            --news-color: {{ option('newscolor') }};
        }

        p {
            text-shadow: 0 0 7px rgba(255, 255, 255, .3), 0 0 3px rgba(255, 255, 255, .3);
        }

        .texttrans {
            color: #e5e5e5;
            font-size: 1.26rem;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Aldrich" !important;
        }

        .animation {
            height: 30px;
            overflow: hidden;
            margin-left: 0.5rem;
        }

        .animation>div>div {
            height: 2.81rem;
            margin-bottom: 2.81rem;
            display: inline-block;
        }

        .animation div:first-child {
            animation: text-animation 10s infinite;
        }

        @keyframes text-animation {
            0% {
                margin-top: 0;
            }

            10% {
                margin-top: 0;
            }

            20% {
                margin-top: -5.62rem;
            }

            30% {
                margin-top: -5.62rem;
            }

            40% {
                margin-top: -11.24rem;
            }

            60% {
                margin-top: -11.24rem;
            }

            70% {
                margin-top: -5.62rem;
            }

            80% {
                margin-top: -5.62rem;
            }

            90% {
                margin-top: 0;
            }

            100% {
                margin-top: 0;
            }
        }

        .grid {
            position: relative;
            list-style: none;
            text-align: center;
        }

        /* Common style */
        .grid figure {
            position: relative;
            float: left;
            overflow: hidden;
            background: #3085a3;
            text-align: center;
            cursor: pointer;
        }

        .grid figure img {
            position: relative;
            display: block;
            min-height: 100%;
            max-width: 100%;
            opacity: 0.8;
        }

        .grid figure figcaption {
            padding: 2em;
            color: #fff;
            text-transform: uppercase;
            font-size: 1.25em;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .grid figure figcaption::before,
        .grid figure figcaption::after {
            pointer-events: none;
        }

        .grid figure figcaption,
        .grid figure figcaption>a {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Anchor will cover the whole item by default */
        /* For some effects it will show as a button */
        .grid figure figcaption>a {
            z-index: 1000;
            text-indent: 200%;
            white-space: nowrap;
            font-size: 0;
            opacity: 0;
        }


        .grid figure p {
            letter-spacing: 1px;
            font-size: 68.5%;
        }


        /*---------------*/
        /***** Sadie *****/
        /*---------------*/

        figure.effect-sadie figcaption::before {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: -webkit-linear-gradient(top, rgba(72, 76, 97, 0) 0%, rgba(72, 76, 97, 0.8) 75%);
            background: linear-gradient(to bottom, rgba(72, 76, 97, 0) 0%, rgba(72, 76, 97, 0.8) 75%);
            content: '';
            opacity: 0;
            -webkit-transform: translate3d(0, 50%, 0);
            transform: translate3d(0, 50%, 0);
        }

        figure.effect-sadie h4 {
            position: absolute;
            top: 30%;
            left: 0;
            width: 50%;
            color: white;
            -webkit-transition: -webkit-transform 0.35s, color 0.35s;
            transition: transform 0.35s, color 0.35s;
            -webkit-transform: translate3d(0, -50%, 0);
            transform: translate3d(0, -50%, 0);
        }

        figure.effect-sadie figcaption::before,
        figure.effect-sadie p {
            -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
            transition: opacity 0.35s, transform 0.35s;
        }

        figure.effect-sadie p {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 2em;
            width: 100%;
            opacity: 0;
            -webkit-transform: translate3d(0, 10px, 0);
            transform: translate3d(0, 10px, 0);
        }

        figure.effect-sadie:hover h4 {
            color: #fff;
            -webkit-transform: translate3d(0, -50%, 0) translate3d(0, -40px, 0);
            transform: translate3d(0, -50%, 0) translate3d(0, -40px, 0);
        }

        figure.effect-sadie:hover figcaption::before,
        figure.effect-sadie:hover p {
            opacity: 1;
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }



        a {
            outline: none;
            color: #3498db;
            text-decoration: none;
        }

        a:hover,
        a:focus {
            color: #528cb3;
        }


        .content {
            margin: 0 auto;
            max-width: 1000px;
        }


        /* Header */
        .codrops-header {
            margin: 0 auto;
            padding: 4em 1em;
            text-align: center;
        }

        .codrops-header h1 {
            margin: 0;
            font-weight: 800;
            font-size: 4em;
            line-height: 1.3;
        }

        .codrops-header h1 span {
            display: block;
            padding: 0 0 0.6em 0.1em;
            color: #74777b;
            font-weight: 300;
            font-size: 45%;
        }

        /* Demo links */
        .codrops-demos {
            clear: both;
            padding: 1em 0 0;
            text-align: center;
        }

        .content+.codrops-demos {
            padding-top: 5em;
        }

        .codrops-demos a {
            display: inline-block;
            margin: 0 5px;
            padding: 1em 1.5em;
            text-transform: uppercase;
            font-weight: bold;
        }

        .codrops-demos a:hover,
        .codrops-demos a:focus,
        .codrops-demos a.current-demo {
            background: #3c414a;
            color: #fff;
        }

        /* To Navigation Style */
        .codrops-top {
            width: 100%;
            text-transform: uppercase;
            font-weight: 800;
            font-size: 0.69em;
            line-height: 2.2;
        }

        .codrops-top a {
            display: inline-block;
            padding: 1em 2em;
            text-decoration: none;
            letter-spacing: 1px;
        }

        .codrops-top span.right {
            float: right;
        }

        .codrops-top span.right a {
            display: block;
            float: left;
        }

        .codrops-icon:before {
            margin: 0 4px;
            text-transform: none;
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            font-family: 'codropsicons';
            line-height: 1;
            speak: none;
            -webkit-font-smoothing: antialiased;
        }

        .codrops-icon-drop:before {
            content: "\e001";
        }

        .codrops-icon-prev:before {
            content: "\e004";
        }

        /* Related demos */
        .related {
            clear: both;
            padding: 6em 1em;
            font-size: 120%;
        }

        .related>a {
            display: inline-block;
            margin: 20px 10px;
            padding: 25px;
            border: 1px solid #4f7f90;
            text-align: center;
        }

        .related a:hover {
            border-color: #39545e;
        }

        .related a img {
            max-width: 100%;
            opacity: 0.8;
        }

        .related a:hover img,
        .related a:active img {
            opacity: 1;
        }

        .related a h3 {
            margin: 0;
            padding: 0.5em 0 0.3em;
            max-width: 300px;
            text-align: left;
        }

        @media screen and (max-width: 25em) {
            .codrops-header {
                font-size: 75%;
            }

            .codrops-icon span {
                display: none;
            }
        }
    </style>
    <div class="marquee-container">
        <div class="@if (option('newsdirection')) anti-marquee-content @else marquee-content @endif">
            <!-- Your marquee text here -->
            @forelse ($news as $n)
                &#x2022 {{ $n->news_body }}
            @empty
            @endforelse
        </div>
    </div>
    <section class="breadcrumb-area bread-bg-flights">
        <section class="container" style="border-radius:10px;padding:100px 0px">
            <div class="container">
                <main class="texttrans">
                    <p>Gondal Travel</p>
                    <section class="animation">
                        <div class="first">
                            <div>Dream</div>
                        </div>
                        <div class="second">
                            <div>Explore</div>
                        </div>
                        <div class="third">
                            <div>Experience</div>
                        </div>
                    </section>
                </main>
                <br>
                @include('inc.search-box')
                @auth
                    <div class="row my-5">
                        <div class="col-md-12">
                            <p class="mt-2" style="color:#fff">Recent Searches</p>
                            <hr style="margin: 4px 0; color: #fff;border-color:#fff">
                        </div>
                        @forelse (mySearches(auth()->user()->id) as $result)
                            <div class="col-md-2 mt-3">
                                <div class="list-group">
                                    <a href="{{ $result->uri }}" target="_blank"
                                        class="list-group-item list-group-item-action border-top-0 ">
                                        <div class="msg-body d-flex align-items-center">
                                            <div class="icon-element flex-shrink-0 mr-3 ml-0">
                                                <i class="la la-plane"></i>
                                            </div>
                                            <div class="msg-content w-100">
                                                <h3 class="title pb-0 px-2" style="text-transform:uppercase">flights</h3>
                                                <p class="msg-text px-2" style="text-transform:capitalize">
                                                    {{ strtoupper($result->origin) }}<i
                                                        class="la la-arrow-right px-1"></i>{{ strtoupper($result->destination) }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12 mt-3">
                                <div class="list-group bg-white p-3">
                                    <div class="msg-content w-100">
                                        <h3 class="title pb-0 px-2" style="text-transform:uppercase">Your Recent Search will be
                                            appear here</h3>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                @endauth
            </div>
        </section>
    </section>
    @include('inc.info')
    @include('inc.footer')
@endsection
