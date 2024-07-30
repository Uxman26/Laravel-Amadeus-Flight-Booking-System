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
<section class="info-area info-bg padding-top-90px padding-bottom-20px" style="">
    <div id="omranhajj" style="margin-bottom: 100px"></div>
    <div class="col-md-10 mx-auto" >

        <div class="row text-center mt-5 mb-3">
            <h1 style="color: {{ $color }} !important"><b>Omra & Hajj</b></h1>
        </div>
        <div class="row">
            @foreach ($packages as $package)
                <div class="col-lg-4 responsive-column">

                    <div class="grid">
                        <figure class="effect-sadie">
                            <img src="{{ asset($package->image) }}" alt="" class="d-block" height="300">
                            <figcaption>
                                <h4 style="background: {{$color}}; border-radius:5px" class="text-fluid"><span>{{ strtoupper($package->name) }}</span></h4>
                                {{-- <p>Gondal Travel<br />Experience Best Travel </p> --}}
                                <a href="{{ route('admin.package.view', ['id' => $package->id]) }}">View more</a>
                            </figcaption>
                        </figure>
                    </div>

                    <a href="{{ route('admin.package.view', ['id' => $package->id]) }}"
                        class="btn btn-primary col-12 mt-1">View package</a>
                    <a href="{{ route('admin.package.booking', ['id' => $package->id]) }}"
                        class="btn btn-primary col-12 mt-1">Reserve</a>
                </div>
            @endforeach
        </div>
    </div>
    <div id="touristvisa" style="margin-bottom: 100px"></div>
    <div class="col-md-10 mx-auto" id="touristvisa">
        <div class="row text-center mt-5 mb-3">
            <h1 style="color: {{ $color }} !important"><b>Tourist Visa</b></h1>
        </div>
        <div class="row">
            @forelse ($slides as $s)
                <div class="col-md-4 promo_div" data-id="{{ $s->slug }}"
                    data-url="{{ url('slider/promotion/' . $s->slug) }}">
                    <!-- <a href="{{ url('slider/promotion/' . $s->slug) }}"> -->
                    <div class="slid pb-4">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">

                                <div class="carousel-item active">
                                    <img src="{{ asset('assets/slider/' . $s->image) }}" alt=""
                                        class="d-block w-100" height="300">
                                    <div
                                        class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5 text-white banner_text">
                                        <h5 class="mb-1 ml-4">{{ $s->promotext }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- </a> -->
                </div>
            @empty
            @endforelse
        </div>
        <div class="row">
            <div class="col-lg-4 responsive-column">
                <a href="http://localhost/GondalTravelFr/contact" class="icon-box icon-layout-2 d-flex bg-light">
                    <div class="info-icon flex-shrink-0">
                        <i class="la la-phone"></i>
                    </div>
                    <div class="info-content pt-2">
                        <h4 class="info__title">Need Help? Contact us</h4>
                        <p class="info__desc">
                            Our support team available 24/7 </p>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 responsive-column">
                <div class="icon-box icon-layout-2 d-flex bg-light">
                    <div class="info-icon flex-shrink-0">
                        <i class="la la-money"></i>
                    </div>
                    <div class="info-content pt-2">
                        <h4 class="info__title">Secure Payments</h4>
                        <p class="info__desc">
                            Remarkable and 99.9% service uptime </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 responsive-column">
                <div class="icon-box icon-layout-2 d-flex bg-light">
                    <div class="info-icon flex-shrink-0 ">
                        <i class="la la-times"></i>
                    </div>
                    <div class="info-content pt-2">
                        <h4 class="info__title">Cancel Policy</h4>
                        <p class="info__desc">
                            Cancellation made easy and automated </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bootstrap modal popup -->
<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Promotion</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="dataModalBody">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 promo">
                            <img src="" alt="" class="d-block w-100 promoimg" height="350">
                            <h2 class="text-center pb-2"><u class="promotext"></u></h2>
                            <form action="" method="POST" class="pb-4" id="promoform">
                                @csrf
                                <input type="hidden" name="promo_id" class="promo_id" value="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="news_body">Name</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="news_body">Email</label>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="news_body">Message</label>
                                        <textarea class="form-control" name="message"></textarea>
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <button type="submit"
                                            class="btn btn-primary btn-large form-control">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
