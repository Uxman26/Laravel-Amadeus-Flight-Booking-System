<section class="breadcrumb-area bread-bg-flights">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="breadcrumb-content">
                        <div class="section-heading">
                            <div class="left-side-info rtl-align-right" style="color:#fff">
                                @if ($data['trip_type'] != 'return')
                                    <div>
                                        <strong style="text-transform: capitalize">
                                            <h2 class="sec__title_list">{{ $data['from'] }} <i
                                                    class="la la-arrow-right"></i> {{ $data['to'] }}</h2>
                                        </strong>
                                    </div>
                                    <div>
                                        <p><strong>Date</strong>({{ $data['departure'] }})</p>
                                    </div>
                                @elseif($data['trip_type'] == 'return')
                                    <div>
                                        <strong style="text-transform: capitalize">
                                            <h2 class="sec__title_list">{{ $data['from'] }} <i
                                                    class="la la-arrow-right"></i> {{ $data['to'] }}</h2>
                                        </strong>
                                    </div>
                                    <div>
                                        <p><strong>Date</strong>({{ $data['departure'] }})</p>
                                    </div>
                                    <div class="mt-2">
                                        <strong style="text-transform: capitalize">
                                            <h2 class="sec__title_list">{{ $data['to'] }} <i class="la la-arrow-right"></i> {{ $data['from'] }}</h2>
                                        </strong>
                                    </div>
                                    <div>
                                        @if(isset($data['returning']))<p><strong>Date</strong>({{ $data['returning'] }})</p>@endif
                                    </div>
                                @endif
                                <div>
                                    <p><strong>Adults</strong> {{ $data['adult'] }} <strong>Childs</strong>
                                        {{ $data['children'] }} <strong>Infants</strong> {{ $data['infant'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="breadcrumb-list d-flex gap-2 accordion">
                        <ul class="list-items d-flex justify-content-end d-none d-sm-block">
                            <li class=" "><a
                                class=""
                                    href="javascript:void(0)"><i class="la la-plane mx-1"></i> Total Flights :
                                    {{ $data['allFlightsCount'] }}</a></li>
                        </ul>
                        <button type="button" id="search_filter" class="accordion-button btn btn-outline-light w-100"
                            style="display: none">Modify Filter</button>
                        <button type="button" onclick="toggleDiv()"
                            class="accordion-button btn btn-outline-light w-100">Modify Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function toggleDiv() {
        var flightSearchBox = document.getElementById("flightSearchBox");
        flightSearchBox.style.display = (flightSearchBox.style.display === "none") ? "block" : "none";
    }

    function toggleFilter() {
        var filterSearchBox = document.getElementById("fadefilter");
        filterSearchBox.style.display = (filterSearchBox.style.display === "none") ? "block !important" :
            "none !important";
    }
</script>
