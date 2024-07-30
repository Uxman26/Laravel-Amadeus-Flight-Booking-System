<div class="col-md-3 d-sm-block search_filter_options" id="fadefilter" style="display: none">
    <div class="">
        <form>
            <div class="card-header">
                <strong>Modify Search</strong>
            </div>
            <div class=" mt-0">
                <div class="sidebar-widget">
                    <div class="sidebar-widget-item">
                        <div class="contact-form-action">
                            <div class="sidebar-widget">
                                <div class="sidebar-box">
                                    <h3 class="title stroke-shape">Flight Stops</h3>
                                    <div class="box-content">
                                        <fieldset data-filter-group>
                                            <ul class="list remove_duplication">
                                                <li>
                                                    <div class="form-check">
                                                        <input class="form-check-input filter" type="radio"
                                                            name="type" id="all" checked="" value="all"
                                                            onchange="changeStop('all')">
                                                        <label class="form-check-label" for="all"> All
                                                            Flights</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check">
                                                        <input class="form-check-input filter" type="radio"
                                                            name="type" id="directFlight" value="0"
                                                            onchange="changeStop(0)">
                                                        <label class="form-check-label" for="directFlight">
                                                            Direct</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check">
                                                        <input class="form-check-input filter" type="radio"
                                                            name="type" id="singleStop" value="1"
                                                            onchange="changeStop(1)">
                                                        <label class="form-check-label" for="singleStop"> Stops
                                                            1</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check">
                                                        <input class="form-check-input filter" type="radio"
                                                            name="type" id="doubleStop" value="2"
                                                            onchange="changeStop(2)">
                                                        <label class="form-check-label" for="doubleStop"> Stops
                                                            2</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar-widget controls">
                                <h3 class="title stroke-shape">Price Range
                                    <input type="text" id="amountRange" readonly
                                        style="border:0; color:#f6931f; font-weight:bold;">
                                </h3>
                                <div id="slider-range"></div>
                                {{-- <div class="sidebar-price-range">
                                    <input type="range" class="form-range" min="{{ $data['minPrice'] }}" max="{{ $data['maxPrice'] }}" step="10" id="priceRange" value="{{ $data['maxPrice'] }}">
                                    <small>Maximum <span id="currentFilterRangePrice" style="border:0; color:#f6931f; font-weight:bold;"></span></small>
                                </div>
                                <div class="sidebar-price-range">
                                    <input type="range" class="form-range" min="{{ $data['minPrice'] }}" max="{{ $data['maxPrice'] }}" step="10" id="priceRangeMinimum" value="{{ $data['minPrice'] }}">
                                    <small>Minimum <span id="currentFilterRangePriceMinimum" style="border:0; color:#f6931f; font-weight:bold;"></span></small>
                                </div> --}}
                            </div>


                            <div class="sidebar-widget controls">
                                @livewire('search-filter')
                            </div>
                            <fieldset data-filter-group> 
                                <div class="sidebar-box mb-4 controls">
                                    <h3 class="title stroke-shape" style="text-transform:capitalize">Airlines</h3>
                                    <ul class="list remove_duplication checkbox-group">
                                        @foreach ($data['flightsFilters'] as $flightsFilter)
                                            <li>
                                                <div class="custom-checkbox flights_line">
                                                    <input class="filter" type="checkbox" id="{{ $loop->iteration }}"
                                                        value="{{ $flightsFilter }}" onchange="filterListItems()"> 
                                                    <label for="{{ $loop->iteration }}"> <img class="lazyload"
                                                            data-src="{{ asset('assets/airlines/' . $flightsFilter . '.png') }}"
                                                            style="background:transparent;max-width:20px;padding-top:0px;margin: 0 6px" />{{ findAirlineName($flightsFilter) }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
