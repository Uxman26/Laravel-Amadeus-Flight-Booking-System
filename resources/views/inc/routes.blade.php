<div class="ItineraryTrip">
    @if(isset($flight->duration))
    <div>
        <div class="ItineraryTrip-title"><span class="ItineraryTrip-depart"><span class="">{{ $flight->departure->iataCode }} <i class="la la-arrow-right"></i> {{ $flight->arrival->iataCode }}</span></span><span class="ItineraryTrip-time _actionButtons"><span>{{ getDuration($flight->duration) }} </span></span></div>
    </div>
    @endif
    <div class="ItineraryTimeline">
        <div class="">
            <div class="ItineraryListItemWrapper__ListWrapper-sc-19iopls-1 HSQYU ItineraryTripLayover">
            </div>
            <div class="ItineraryPart__ItineraryPartWrapper-hxyeqa-0">
                <div class="ItineraryDate">
                    <div class="Stack__StyledStack-sc-1t576ow-0 fuCtbb">
                        <div>
                            <svg class="Icon__StyledIcon-sc-1pnzn3g-0 dnIYzU ItineraryDate-icon" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet">
                                <path d="M19.917 4.5c.916 0 1.666.75 1.666 1.667v14.166c0 .917-.75 1.667-1.666 1.667H4.083c-.916 0-1.666-.75-1.666-1.667V6.167c0-.917.75-1.667 1.666-1.667h1.25c.25 0 .417.167.334.417v1.916c0 .417.333.667.666.667A.657.657 0 007 6.833v-4c0-.5.333-.833.833-.833s.834.333.834.833v1.5a.18.18 0 00.166.167h5.25c.25 0 .417.167.334.417v1.916c0 .417.333.667.666.667a.657.657 0 00.667-.667v-4c0-.5.333-.833.833-.833s.834.333.834.833v1.5a.18.18 0 00.166.167h2.334zM19.5 20.333c.25 0 .417-.166.417-.416v-10c0-.25-.167-.417-.417-.417h-15c-.25 0-.417.167-.417.417v10c0 .25.167.416.417.416h15zM8.25 10.75c.5 0 .833.333.833.833s-.333.834-.833.834h-.833c-.5 0-.834-.334-.834-.834s.334-.833.834-.833h.833z"></path>
                            </svg>
                            <span class="ItineraryDate-date spTypo-medium"><time class="">{{ getFullDate($flight->departure->at) }}</time></span>
                        </div>
                        <div class="BadgePrimitive__StyledBadge-q8r1qt-0 jJBLUc" data-test="cabinClassBadge">
                            <div class="BadgePrimitive__StyledBadgeContent-q8r1qt-2 jHZqCf">Flight</div>
                        </div>
                    </div>
                </div>
                <div class="ItineraryPart _flight" data-test="PartToggle">
                    <div class="ItineraryPart-milestone">
                        <svg class="Icon__StyledIcon-sc-1pnzn3g-0 dnIYzU ItineraryPart-milestoneIcon _flight" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet">
                            <path d="M12 20.578c-.894 0-1.424-.837-1.424-2.174v-3.666c0-.356-.178-.624-.445-.802L3.446 10.28C3.178 10.192 3 9.836 3 9.568v-.576c0-.624.624-1.07 1.159-.802l5.793 1.961c.268.09.624-.089.624-.445V6.714c0-.268-.178-.624-.445-.803L8.437 4.843c-.356-.178-.592-.467-.475-.677.026-.047.069-.249.315-.303.246-.055 1.228.175 2.665.425.02.003.044.007.075.01.248-.584.576-.877.983-.877.406 0 .732.292.976.875l.082-.012c1.437-.25 2.42-.48 2.665-.425.246.054.289.256.315.304.117.21-.119.498-.475.676l-1.694 1.07c-.267.178-.445.36-.445.717v2.992c0 .267.267.534.624.445l5.793-1.96c.535-.268 1.159.177 1.159.801v.576c0 .357-.178.624-.446.802l-6.685 3.655c-.267.178-.445.445-.445.802v3.577c0 1.158-.53 2.263-1.424 2.263z"></path>
                        </svg>
                    </div>
                    <div class="ItineraryPartOverview" data-test="flight">
                        <div class="ItineraryPartOverview-airports">
                            <div class="ItineraryPartOverview-outbound">
                                <span class="ItineraryPartOverviewField _time"><time class="">{{ getTimeOnly($flight->departure->at) }}</time></span>
                                <div class="ItineraryPartOverview-airports-fields">
                                    <div class="ItineraryPartOverview-airports-fields-merged"><span class="ItineraryPartOverviewField _name">{{ $flight->departure->iataCode }}</span><span class="ItineraryPartOverviewField _code" data-id="0-khi">{{ findCityName($flight->departure->iataCode) }}</span></div>
                                </div>
                            </div>
                            <div class="ItineraryPartOverview-inbound">
                                <span class="ItineraryPartOverviewField _time"><time class="">{{ getTimeOnly($flight->arrival->at) }}</time></span>
                                <div class="ItineraryPartOverview-airports-fields">
                                    <div class="ItineraryPartOverview-airports-fields-merged"><span class="ItineraryPartOverviewField _name">{{ $flight->arrival->iataCode }}</span><span class="ItineraryPartOverviewField _code" data-id="0-shj">{{ findCityName($flight->arrival->iataCode) }}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="ItineraryPartOverview-airline"><img class="ItineraryPartOverview-airline-logo" src="{{ asset('assets/airlines/'.$flight->carrierCode.'.png') }}" alt="" width="28" height="28"><span class="ItineraryPartOverview-duration"></span></div>
                        <div>
                            <div class="ItineraryPartDetail _expanded">
                                <ul>
                                    <li><img class="ItineraryPartOverview-airline-logo" src="{{ asset('assets/airlines/'.$flight->carrierCode.'.png') }}" alt="" width="14" height="14"><span class="ItineraryPartDetail-item"><span>Airline: <span class="indent-right">{{ findAirlineName($flight->carrierCode) }}</span></span></span></li>
                                    <li>
                                        <svg class="Icon__StyledIcon-sc-1pnzn3g-0 dnIYzU ItineraryPartDetail-itemIcon" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet">
                                            <path d="M14.167 17h-3.334c-.5 0-.833-.315-.833-.786 0-.472.333-.787.833-.787h.667c.083 0 .167-.079.167-.157v-3.54c0-.078-.084-.157-.167-.157h-.667c-.5 0-.833-.315-.833-.786s.333-.787.833-.787h.834c.916 0 1.666.708 1.666 1.573v3.775c0 .079.084.158.167.158h.667c.5 0 .833.314.833.786 0 .472-.333.708-.833.708zM12.3 6c.693 0 1.3.607 1.3 1.3s-.52 1.3-1.3 1.3S11 7.993 11 7.3 11.607 6 12.3 6zM12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2"></path>
                                        </svg>
                                        <span class="ItineraryPartDetail-item"><span class="">Fligth No: {{ $flight->number }}</span></span>
                                    </li>

                                    <li class="d-flex align-items-center" style="gap: 10px; margin-left: -3px;">
                                        <i style="font-size:22px" class="la la-suitcase-rolling"></i> 
                                        <span class="ItineraryPartOverview-airline-logo"><span>BAGGAGE:<span class="indent-right">{{ json_decode($routes)->travelerPricings[0]->fareDetailsBySegment[0]->includedCheckedBags->weight ?? "0" }} {{ json_decode($routes)->travelerPricings[0]->fareDetailsBySegment[0]->includedCheckedBags->weightUnit ?? "KG" }}</span></span></span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="ItineraryPart-icon-folding-wrapper">
                        <svg class="Icon__StyledIcon-sc-1pnzn3g-0 dnIYzU ItineraryPart-icon-folding" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet">
                            <path d="M12.71 14.2l2.72 3.255c.332.37.3.94-.07 1.271a.904.904 0 01-1.275-.07l-1.753-2.18a.4.4 0 00-.594 0l-1.826 2.229a.904.904 0 01-1.274.065.898.898 0 01-.066-1.27l2.796-3.303a.904.904 0 011.342.003zM9.912 5.297l1.826 2.23a.4.4 0 00.594-.001l1.753-2.18a.904.904 0 011.275-.07c.37.332.402.9.07 1.27l-2.72 3.257a.904.904 0 01-1.342.002L8.572 6.503a.898.898 0 01.066-1.271.904.904 0 011.274.065z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>