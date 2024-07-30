<div class="card-body">
    <!-- adults -->
    <div class="card mb-3">
        <div class="card-header text-uppercase">
            <div class="row">
                <div class="col-md-4">{{ $type }} Traveler <strong>{{ $data + 1 }}</strong></div>
                <div class="col-md-8">
                    <select class="form-select old_passenger passenger_{{ $type }}_{{ $data }}">
                        <option value="" selected disabled>Existing Passenger</option>
                        {{-- @foreach ($passengers as $item)
                    <option data-data="{{ $data }}" data-type="{{ $type }}" value="{{ $item->id }}">
                        {{ $item->firstname }} {{ $item->lastname }} -- {{ $item->dob }} -- {{ $item->passport }}
                    </option>
                @endforeach --}}
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- personal info -->
            <div class="row">
                <div class="col-md-2">
                    <label class="label-text">Title</label>
                    <select name="title_{{ $type . '_' . $data + 1 }}" class="form-select title" required>
                        <option value="" selected disabled>Select Title</option>
                        
                        @if ($type == 'adult') 
                        <option value="Mr">Mr</option>
                        <option value="Miss">Miss</option>
                        <option value="Mrs">Mrs</option>
                        @elseif($type == 'children')
                        <option value="Miss">Miss</option>
                        <option value="MSTR">Master</option>
                        @elseif($type == 'infant')
                        <option value="Infant">Infant</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="label-text">Given Name / Prénom</label>
                    <input type="text" name="firstname_{{ $type . '_' . $data + 1 }}" class="form-control"
                        placeholder="First Name" required />
                </div>
                <div class="col-md-4">
                    <label class="label-text">Surname / Nom</label>
                    <input type="text" name="lastname_{{ $type . '_' . $data + 1 }}" class="form-control"
                        placeholder="Last Name" />
                </div>
                <div class="col-md-2">
                    <label class="label-text">Gender</label>
                    <select name="gender_{{ $type . '_' . $data + 1 }}" class="form-select" required>
                        <option value="" selected disabled>Select Gender</option>
                        <option value="MALE">Male</option>
                        <option value="FEMALE">Female</option>
                    </select>
                </div>
            </div>

            <!-- nationality and personality -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="label-text">Nationality</label>
                    <select class="form-select form-select" name="nationality_{{ $type . '_' . $data + 1 }}" required>
                        <option value="" selected disabled>Select Country</option>
                        @foreach (countryList() as $country)
                            <option value="{{ $country->code }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        @php
                            if ($type == 'adult') {
                                $maxDate = now()->subYears(11)->format('d-m-Y');
                                $minDate = now()->subYears(150)->format('d-m-Y');
                            } elseif ($type == 'children') {
                                $maxDate = now()->subYears(2)->format('d-m-Y');
                                $minDate = now()->subYears(11)->format('d-m-Y');
                            } elseif ($type == 'infant') {
                                $maxDate = now()->subDays(2)->format('d-m-Y');
                                $minDate = now()->subYears(2)->format('d-m-Y');
                            } 
                        @endphp
                        <div class="input-box">
                            <label class="label-text " for="dob_{{ $type . '_' . $data + 1 }}">Date of Birth <span style="display: none; color:red" id="alert_dob_{{ $type . '_' . $data + 1 }}"></span> </label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon dob_calendar" style="position: absolute; z-index:+9999; margin-top:15px; margin-left:10px"></span>
                                <input type="text" typeV="{{$type}}" key="{{$data+1}}" class="form-control dob dobField slashes" id="dob_{{ $type . '_' . $data + 1 }}"
                                placeholder="DD/MM/YYYY" name="dob_{{ $type . '_' . $data + 1 }}" min="{{ $minDate }}"
                                    max="{{ $maxDate }}" required style="padding-left: 40px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- passport credentials -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <label class="label-text">Passport or ID number</label>
                    <input type="text" name="passport_{{ $type . '_' . $data + 1 }}" class="form-control"
                        placeholder="Passport or ID number" value="" required />
                </div>
                <div class="col-md-12 mt-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-box">
                                <label class="label-text" for="passport_expiry_{{ $type . '_' . $data + 1 }}">Passport
                                    Expiry
                                    Date 
                                    <span style="display: none; color:red" id="alert_passport_expiry_{{ $type . '_' . $data + 1 }}"></span>
                                </label>
                                <div class="form-group">
                                    <span class="la la-calendar form-icon passport_expiry_calendar" style="position: absolute; z-index:+9999; margin-top:15px; margin-left:10px"></span>
                                    <input type="text" typeV="{{$type}}" key="{{$data+1}}" class="form-control passport_expiry expField slashes"
                                    placeholder="DD/MM/YYYY"
                                        id="passport_expiry_{{ $type . '_' . $data + 1 }}"
                                        name="passport_expiry_{{ $type . '_' . $data + 1 }}"
                                        min="{{ now()->addMonths(1)->format('Y-m-d') }}"
                                        max="{{ now()->addYears(20)->format('Y-m-d') }}" value="" required style="padding-left: 40px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
