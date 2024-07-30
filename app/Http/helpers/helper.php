<?php


use Illuminate\Support\Facades\Route;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Booking;
use App\Models\Option;
use App\Models\SearchHistory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

function getBalance($user_id)
{
    $in = Transaction::where('user_id', $user_id)->where('sum', true)->sum('amount');
    $out = Transaction::where('user_id', $user_id)->where('sum', false)->sum('amount');
    return $in - $out;
}

function canEditAnything()
{
    if (auth()->user()->role == 1) {
        return true;
    } else {
        return false;
    }
}

function totalCredit($user_id)
{
    $in = Transaction::where('user_id', $user_id)->where('sum', true)->sum('amount');
    return $in;
}


function totalDebit($user_id)
{
    $out = Transaction::where('user_id', $user_id)->where('sum', false)->sum('amount');
    return $out;
}


function myBookings($user_id)
{
    $bookings = Booking::where('user_id', $user_id)->count();
    return $bookings;
}


function companyBalance()
{
    $in = Transaction::where('type', 'Payment')->sum('amount');
    return $in;
}


function totalReceivable()
{
    // $in = Transaction::where('type', 'Ticket Book')->sum('amount');
    // $out = Transaction::where('type', 'Payment')->sum('amount');
    $in = Booking::where('ticket_status','issued')->sum('agent_margin');
    $out = Booking::where('ticket_status','issued')->sum('received');
    return $in - $out;
}
function totalReceivableAgent()
{
    // $in = Transaction::where('type', 'Ticket Book')->sum('amount');
    // $out = Transaction::where('type', 'Payment')->sum('amount');
    $in = Booking::where('user_id', auth()->user()->id)->where('ticket_status','issued')->sum('agent_margin');
    $out = Booking::where('user_id', auth()->user()->id)->where('ticket_status','issued')->sum('received');
    return $in - $out;
}


function iataBalance()
{
    // $transaction = Transaction::where('user_id', 4)->where('type', 'Paid')->sum('amount');
    // $bookings = Booking::where('ticket_status', 'issued')->sum('admin_buy_price');
    // return $transaction - $bookings;
    $in = Booking::where('ticket_status','issued')->sum('iata');
    // $in = Booking::where('ticket_status','issued')->sum('admin_buy_price');
    $out = Booking::where('ticket_status','issued')->sum('nego');
    return $in - $out;
}



function totalBookings()
{
    $booking = Booking::whereBetween('created_at', [option('from_date').' 00:00:00', option('to_date'). ' 23:59:59'])->get();
    $count = 0;
    foreach($booking as $item){
        $count += $item->passengers->count();
    }
    return $count;
}
function issuedBookings()
{
    $booking = Booking::whereBetween('created_at', [option('from_date').' 00:00:00', option('to_date'). ' 23:59:59'])->where('ticket_status', 'issued')->get();
    $count = 0;
    foreach($booking as $item){
        if(isset($item->passengers[0]->etkt)){
            $count += $item->passengers->count();
            }
    }
    return $count;
}
function bookedBookings()
{
    $booking = Booking::whereBetween('created_at', [option('from_date').' 00:00:00', option('to_date'). ' 23:59:59'])->where('ticket_status', 'Booked')->get();
    $count = 0;
    foreach($booking as $item){
        if(!isset($item->passengers[0]->etkt)){
        $count += $item->passengers->count();
        }
    }
    return $count;
}
function cancelBookings()
{
    $booking = Booking::whereBetween('created_at', [option('from_date').' 00:00:00', option('to_date'). ' 23:59:59'])->where('ticket_status', 'Cancel')->get();
    $count = 0;
    foreach($booking as $item){
        $count += $item->passengers->count();
    }
    return $count;
}
function issuedBookingsAgent()
{
    $booking = Booking::whereBetween('created_at', [option('from_date').' 00:00:00', option('to_date'). ' 23:59:59'])->where('user_id', auth()->user()->id)->where('ticket_status', 'issued')->get();
    $count = 0;
    foreach($booking as $item){
        if(isset($item->passengers[0]->etkt)){
            $count += $item->passengers->count();
            }
    }
    return $count;
}
function bookedBookingsAgent()
{
    $booking = Booking::whereBetween('created_at', [option('from_date').' 00:00:00', option('to_date'). ' 23:59:59'])->where('user_id', auth()->user()->id)->where('ticket_status', 'Booked')->get();
    $count = 0;
    foreach($booking as $item){
        if(!isset($item->passengers[0]->etkt)){
            $count += $item->passengers->count();
            }
    }
    return $count;
}
function cancelBookingsAgent()
{
    $booking = Booking::whereBetween('created_at', [option('from_date').' 00:00:00', option('to_date'). ' 23:59:59'])->where('user_id', auth()->user()->id)->where('ticket_status', 'Cancel')->get();
    $count = 0;
    foreach($booking as $item){
        $count += $item->passengers->count();
    }
    return $count;
}
function todayDeparture()
{
    $bookings = Booking::where('ticket_status', 'issued')->get();
    $count = 0;
    foreach ($bookings as $booking) {
        $x = Carbon::parse(str_replace('T',' ',json_decode($booking->routes)->itineraries[0]->segments[0]->departure->at))->format('Y-m-d') >= Carbon::now()->format('Y-m-d') && isset(json_decode($booking->routes)->itineraries[0]->segments[0]->departure->at) && Carbon::parse(str_replace('T',' ',json_decode($booking->routes)->itineraries[0]->segments[0]->departure->at))->diffInHours(Carbon::now()) <= 72;
        if ($x) {
            $count++;
        }
        if ($booking->trip_type == 'return' && isset(json_decode($booking->routes)->itineraries[1])) {
        $x = Carbon::parse(str_replace('T',' ',json_decode($booking->routes)->itineraries[1]->segments[0]->departure->at))->format('Y-m-d') >= Carbon::now()->format('Y-m-d') && isset(json_decode($booking->routes)->itineraries[1]->segments[0]->departure->at) && Carbon::parse(str_replace('T',' ',json_decode($booking->routes)->itineraries[1]->segments[0]->departure->at))->diffInHours(Carbon::now()) <= 72;
        if ($x) {
            $count++;
        }
    }
    }
    return $count;
}
function todayDepartureAgent()
{
    $bookings = Booking::where('ticket_status', 'issued')->where('user_id', auth()->user()->id)->get();
    $count = 0;
    foreach ($bookings as $booking) {
        $x = Carbon::parse(str_replace('T',' ',json_decode($booking->routes)->itineraries[0]->segments[0]->departure->at))->format('Y-m-d') >= Carbon::now()->format('Y-m-d') && isset(json_decode($booking->routes)->itineraries[0]->segments[0]->departure->at) && Carbon::parse(str_replace('T',' ',json_decode($booking->routes)->itineraries[0]->segments[0]->departure->at))->diffInHours(Carbon::now()) <= 72;
        if ($x) {
            $count++;
        }
        if ($booking->trip_type == 'return' && isset(json_decode($booking->routes)->itineraries[1])) {
            $x = Carbon::parse(str_replace('T',' ',json_decode($booking->routes)->itineraries[1]->segments[0]->departure->at))->format('Y-m-d') >= Carbon::now()->format('Y-m-d') && isset(json_decode($booking->routes)->itineraries[1]->segments[0]->departure->at) && Carbon::parse(str_replace('T',' ',json_decode($booking->routes)->itineraries[1]->segments[0]->departure->at))->diffInHours(Carbon::now()) <= 72;
            if ($x) {
                $count++;
            }
        }
    }
    return $count;
}

function salePercentage(){
    $out = Booking::whereBetween('created_at', [option('from_date').' 00:00:00', option('to_date'). ' 23:59:59'])->where('ticket_status','issued')->sum('nego');
    $in = Booking::whereBetween('created_at', [option('from_date').' 00:00:00', option('to_date'). ' 23:59:59'])->where('ticket_status','issued')->sum('agent_margin');
    return $in - $out;
}

function totalUsers($role)
{
    $users = User::where('role', $role)->get();
    return $users->count();
}


function totalTicketSold()
{
    $booking = Booking::whereBetween('updated_at', [option('from_date').' 00:00:00', option('to_date'). ' 23:59:59'])->where('ticket_status', 'issued')->sum('agent_margin');
    return $booking;
}
function totalTicketSoldAgent()
{
    $booking = Booking::whereBetween('updated_at', [option('from_date').' 00:00:00', option('to_date'). ' 23:59:59'])->where('user_id', auth()->user()->id)->where('ticket_status', 'issued')->sum('agent_margin');
    return $booking;
}

function getCurrentUrl()
{
    return Route::current()->parameters;
}


function getNextOrBackUri($next)
{
    $getNextDayUrl = Route::current()->parameters;
    if ($next) {
        $next = 1;
    } else {
        $next = -1;
    }
    $nextDate = Carbon::now()->parse($getNextDayUrl['cdeparture'])->addDay($next)->format('d-m-Y');
    $getNextDayUrl['cdeparture'] = $nextDate;
    return $getNextDayUrl;
}

function findAirlineName($code)
{
    $codeQuery = $code . ".png";
    $airline = Airline::where('thumbnail', $codeQuery)->first();
    if ($airline != "") {
        return strtoupper($airline->name);
    } else {
        return $code;
    }
}


function findAirportName($code)
{
    $airport = Airport::where('code', $code)->first();
    if ($airport != "") {
        return strtoupper($airport->name);
    } else {
        return $code;
    }
}


function findCityName($code)
{
    $airport = Airport::where('code', $code)->first();
    if ($airport != "") {
        return strtoupper($airport->city);
    } else {
        return $code;
    }
}

function findCountryName($code)
{
    $airport = Airport::where('code', $code)->first();
    if ($airport != "") {
        return strtoupper($airport->country);
    } else {
        return $code;
    }
}


function getDuration($duration)
{
    $interval = new DateInterval($duration);
    $hours = $interval->h;
    $minutes = $interval->i;

    $totalMinutes = ($hours * 60) + $minutes;
    return sprintf("%02d:%02d Hours", floor($totalMinutes / 60), $totalMinutes % 60);
}

function getCustomDuration($duration)
{
    $interval = new DateInterval($duration);
    $hours = $interval->h;
    $minutes = $interval->i;

    $totalMinutes = ($hours * 60) + $minutes;
    return sprintf("%02dh%02d", floor($totalMinutes / 60), $totalMinutes % 60);
}


function getConnectingTime($oldDate, $newDate)
{
    $date1 = new DateTime($oldDate);
    $date2 = new DateTime($newDate);

    $diff = $date1->diff($date2);

    // Accessing the time difference
    $hours = $diff->h;
    $minutes = $diff->i;

    return $hours . "h" . $minutes . "min";
}
function getDurationBetweenDays($oldDay, $newDay)
{
    $day1 = new DateTime($oldDay);
    $day2 = new DateTime($newDay);

    $diff = $day1->diff($day2);

    // Accessing the time difference
    $months = $diff->m;
    $days = $diff->d;
    $hours = $diff->h;
    $minutes = $diff->i;
    if ($months == 0) {
        return $days . "day" . $hours . "h" . $minutes . "min";
    }
    if ($months == 0 && $days == 0) {
        return  $hours . "h" . $minutes . "min";
    }
    return $months . "month" . $days . "day" . $hours . "h" . $minutes . "min";
}

function getTimeOnly($timestamp)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $timestamp)->format('H:i');
}

function getDateOnly($date)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $date)->format('d M Y');
}

function getDayName($date)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $date)->format('l');
}

function getFullDate($timestamp)
{
    return  getDateOnly($timestamp) . " " . substr(getDayName($timestamp), 0, 3) . " " . getTimeOnly($timestamp);
}



function mySearches($user_id)
{
    return SearchHistory::where('user_id', $user_id)->limit(12)->latest()->get();
}

function countryList()
{
    $countires = '[{"name":"Afghanistan","code":"AF"},{"name":"\u00c5land Islands","code":"AX"},{"name":"Albania","code":"AL"},{"name":"Algeria","code":"DZ"},{"name":"American Samoa","code":"AS"},{"name":"Andorra","code":"AD"},{"name":"Angola","code":"AO"},{"name":"Anguilla","code":"AI"},{"name":"Antarctica","code":"AQ"},{"name":"Antigua and Barbuda","code":"AG"},{"name":"Argentina","code":"AR"},{"name":"Armenia","code":"AM"},{"name":"Aruba","code":"AW"},{"name":"Australia","code":"AU"},{"name":"Austria","code":"AT"},{"name":"Azerbaijan","code":"AZ"},{"name":"Bahamas","code":"BS"},{"name":"Bahrain","code":"BH"},{"name":"Bangladesh","code":"BD"},{"name":"Barbados","code":"BB"},{"name":"Belarus","code":"BY"},{"name":"Belgium","code":"BE"},{"name":"Belize","code":"BZ"},{"name":"Benin","code":"BJ"},{"name":"Bermuda","code":"BM"},{"name":"Bhutan","code":"BT"},{"name":"Bolivia (Plurinational State of)","code":"BO"},{"name":"Bonaire, Sint Eustatius and Saba","code":"BQ"},{"name":"Bosnia and Herzegovina","code":"BA"},{"name":"Botswana","code":"BW"},{"name":"Bouvet Island","code":"BV"},{"name":"Brazil","code":"BR"},{"name":"British Indian Ocean Territory","code":"IO"},{"name":"United States Minor Outlying Islands","code":"UM"},{"name":"Virgin Islands (British)","code":"VG"},{"name":"Virgin Islands (U.S.)","code":"VI"},{"name":"Brunei Darussalam","code":"BN"},{"name":"Bulgaria","code":"BG"},{"name":"Burkina Faso","code":"BF"},{"name":"Burundi","code":"BI"},{"name":"Cambodia","code":"KH"},{"name":"Cameroon","code":"CM"},{"name":"Canada","code":"CA"},{"name":"Cabo Verde","code":"CV"},{"name":"Cayman Islands","code":"KY"},{"name":"Central African Republic","code":"CF"},{"name":"Chad","code":"TD"},{"name":"Chile","code":"CL"},{"name":"China","code":"CN"},{"name":"Christmas Island","code":"CX"},{"name":"Cocos (Keeling) Islands","code":"CC"},{"name":"Colombia","code":"CO"},{"name":"Comoros","code":"KM"},{"name":"Congo","code":"CG"},{"name":"Congo (Democratic Republic of the)","code":"CD"},{"name":"Cook Islands","code":"CK"},{"name":"Costa Rica","code":"CR"},{"name":"Croatia","code":"HR"},{"name":"Cuba","code":"CU"},{"name":"Cura\u00e7ao","code":"CW"},{"name":"Cyprus","code":"CY"},{"name":"Czech Republic","code":"CZ"},{"name":"Denmark","code":"DK"},{"name":"Djibouti","code":"DJ"},{"name":"Dominica","code":"DM"},{"name":"Dominican Republic","code":"DO"},{"name":"Ecuador","code":"EC"},{"name":"Egypt","code":"EG"},{"name":"El Salvador","code":"SV"},{"name":"Equatorial Guinea","code":"GQ"},{"name":"Eritrea","code":"ER"},{"name":"Estonia","code":"EE"},{"name":"Ethiopia","code":"ET"},{"name":"Falkland Islands (Malvinas)","code":"FK"},{"name":"Faroe Islands","code":"FO"},{"name":"Fiji","code":"FJ"},{"name":"Finland","code":"FI"},{"name":"France","code":"FR"},{"name":"French Guiana","code":"GF"},{"name":"French Polynesia","code":"PF"},{"name":"French Southern Territories","code":"TF"},{"name":"Gabon","code":"GA"},{"name":"Gambia","code":"GM"},{"name":"Georgia","code":"GE"},{"name":"Germany","code":"DE"},{"name":"Ghana","code":"GH"},{"name":"Gibraltar","code":"GI"},{"name":"Greece","code":"GR"},{"name":"Greenland","code":"GL"},{"name":"Grenada","code":"GD"},{"name":"Guadeloupe","code":"GP"},{"name":"Guam","code":"GU"},{"name":"Guatemala","code":"GT"},{"name":"Guernsey","code":"GG"},{"name":"Guinea","code":"GN"},{"name":"Guinea-Bissau","code":"GW"},{"name":"Guyana","code":"GY"},{"name":"Haiti","code":"HT"},{"name":"Heard Island and McDonald Islands","code":"HM"},{"name":"Vatican City","code":"VA"},{"name":"Honduras","code":"HN"},{"name":"Hungary","code":"HU"},{"name":"Hong Kong","code":"HK"},{"name":"Iceland","code":"IS"},{"name":"India","code":"IN"},{"name":"Indonesia","code":"ID"},{"name":"Ivory Coast","code":"CI"},{"name":"Iran (Islamic Republic of)","code":"IR"},{"name":"Iraq","code":"IQ"},{"name":"Ireland","code":"IE"},{"name":"Isle of Man","code":"IM"},{"name":"Israel","code":"IL"},{"name":"Italy","code":"IT"},{"name":"Jamaica","code":"JM"},{"name":"Japan","code":"JP"},{"name":"Jersey","code":"JE"},{"name":"Jordan","code":"JO"},{"name":"Kazakhstan","code":"KZ"},{"name":"Kenya","code":"KE"},{"name":"Kiribati","code":"KI"},{"name":"Kuwait","code":"KW"},{"name":"Kyrgyzstan","code":"KG"},{"name":"Lao People\'s Democratic Republic","code":"LA"},{"name":"Latvia","code":"LV"},{"name":"Lebanon","code":"LB"},{"name":"Lesotho","code":"LS"},{"name":"Liberia","code":"LR"},{"name":"Libya","code":"LY"},{"name":"Liechtenstein","code":"LI"},{"name":"Lithuania","code":"LT"},{"name":"Luxembourg","code":"LU"},{"name":"Macao","code":"MO"},{"name":"North Macedonia","code":"MK"},{"name":"Madagascar","code":"MG"},{"name":"Malawi","code":"MW"},{"name":"Malaysia","code":"MY"},{"name":"Maldives","code":"MV"},{"name":"Mali","code":"ML"},{"name":"Malta","code":"MT"},{"name":"Marshall Islands","code":"MH"},{"name":"Martinique","code":"MQ"},{"name":"Mauritania","code":"MR"},{"name":"Mauritius","code":"MU"},{"name":"Mayotte","code":"YT"},{"name":"Mexico","code":"MX"},{"name":"Micronesia (Federated States of)","code":"FM"},{"name":"Moldova (Republic of)","code":"MD"},{"name":"Monaco","code":"MC"},{"name":"Mongolia","code":"MN"},{"name":"Montenegro","code":"ME"},{"name":"Montserrat","code":"MS"},{"name":"Morocco","code":"MA"},{"name":"Mozambique","code":"MZ"},{"name":"Myanmar","code":"MM"},{"name":"Namibia","code":"NA"},{"name":"Nauru","code":"NR"},{"name":"Nepal","code":"NP"},{"name":"Netherlands","code":"NL"},{"name":"New Caledonia","code":"NC"},{"name":"New Zealand","code":"NZ"},{"name":"Nicaragua","code":"NI"},{"name":"Niger","code":"NE"},{"name":"Nigeria","code":"NG"},{"name":"Niue","code":"NU"},{"name":"Norfolk Island","code":"NF"},{"name":"Korea (Democratic People\'s Republic of)","code":"KP"},{"name":"Northern Mariana Islands","code":"MP"},{"name":"Norway","code":"NO"},{"name":"Oman","code":"OM"},{"name":"Pakistan","code":"PK"},{"name":"Palau","code":"PW"},{"name":"Palestine, State of","code":"PS"},{"name":"Panama","code":"PA"},{"name":"Papua New Guinea","code":"PG"},{"name":"Paraguay","code":"PY"},{"name":"Peru","code":"PE"},{"name":"Philippines","code":"PH"},{"name":"Pitcairn","code":"PN"},{"name":"Poland","code":"PL"},{"name":"Portugal","code":"PT"},{"name":"Puerto Rico","code":"PR"},{"name":"Qatar","code":"QA"},{"name":"Republic of Kosovo","code":"XK"},{"name":"R\u00e9union","code":"RE"},{"name":"Romania","code":"RO"},{"name":"Russian Federation","code":"RU"},{"name":"Rwanda","code":"RW"},{"name":"Saint Barth\u00e9lemy","code":"BL"},{"name":"Saint Helena, Ascension and Tristan da Cunha","code":"SH"},{"name":"Saint Kitts and Nevis","code":"KN"},{"name":"Saint Lucia","code":"LC"},{"name":"Saint Martin (French part)","code":"MF"},{"name":"Saint Pierre and Miquelon","code":"PM"},{"name":"Saint Vincent and the Grenadines","code":"VC"},{"name":"Samoa","code":"WS"},{"name":"San Marino","code":"SM"},{"name":"Sao Tome and Principe","code":"ST"},{"name":"Saudi Arabia","code":"SA"},{"name":"Senegal","code":"SN"},{"name":"Serbia","code":"RS"},{"name":"Seychelles","code":"SC"},{"name":"Sierra Leone","code":"SL"},{"name":"Singapore","code":"SG"},{"name":"Sint Maarten (Dutch part)","code":"SX"},{"name":"Slovakia","code":"SK"},{"name":"Slovenia","code":"SI"},{"name":"Solomon Islands","code":"SB"},{"name":"Somalia","code":"SO"},{"name":"South Africa","code":"ZA"},{"name":"South Georgia and the South Sandwich Islands","code":"GS"},{"name":"Korea (Republic of)","code":"KR"},{"name":"Spain","code":"ES"},{"name":"Sri Lanka","code":"LK"},{"name":"Sudan","code":"SD"},{"name":"South Sudan","code":"SS"},{"name":"Suriname","code":"SR"},{"name":"Svalbard and Jan Mayen","code":"SJ"},{"name":"Swaziland","code":"SZ"},{"name":"Sweden","code":"SE"},{"name":"Switzerland","code":"CH"},{"name":"Syrian Arab Republic","code":"SY"},{"name":"Taiwan","code":"TW"},{"name":"Tajikistan","code":"TJ"},{"name":"Tanzania, United Republic of","code":"TZ"},{"name":"Thailand","code":"TH"},{"name":"Timor-Leste","code":"TL"},{"name":"Togo","code":"TG"},{"name":"Tokelau","code":"TK"},{"name":"Tonga","code":"TO"},{"name":"Trinidad and Tobago","code":"TT"},{"name":"Tunisia","code":"TN"},{"name":"Turkey","code":"TR"},{"name":"Turkmenistan","code":"TM"},{"name":"Turks and Caicos Islands","code":"TC"},{"name":"Tuvalu","code":"TV"},{"name":"Uganda","code":"UG"},{"name":"Ukraine","code":"UA"},{"name":"United Arab Emirates","code":"AE"},{"name":"United Kingdom of Great Britain and Northern Ireland","code":"GB"},{"name":"United States of America","code":"US"},{"name":"Uruguay","code":"UY"},{"name":"Uzbekistan","code":"UZ"},{"name":"Vanuatu","code":"VU"},{"name":"Venezuela (Bolivarian Republic of)","code":"VE"},{"name":"Vietnam","code":"VN"},{"name":"Wallis and Futuna","code":"WF"},{"name":"Western Sahara","code":"EH"},{"name":"Yemen","code":"YE"},{"name":"Zambia","code":"ZM"},{"name":"Zimbabwe","code":"ZW"}]';
    return json_decode($countires);
}


function monthsList()
{
    return $months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ];
}


function option($key)
{
    return Option::where('key', $key)->first()->value;
}

function getApi()
{
    if (option('enterprise_api')) {
        if (option('live_api')) {
            $apiUrl = 'https://travel.api.amadeus.com';
            $url = $apiUrl . '/v1/security/oauth2/token';
            $auth_data = [
                'client_id' => option('live_enterprise_client_id'),
                'client_secret' => option('live_enterprise_client_secret'),
                'grant_type' => option('live_grant_type'),
            ];
        } else {
            $apiUrl = 'https://test.travel.api.amadeus.com';
            $url = $apiUrl . '/v1/security/oauth2/token';
            $auth_data = [
                'client_id' => option('test_enterprise_client_id'),
                'client_secret' => option('test_enterprise_client_secret'),
                'grant_type' => option('test_grant_type'),
            ];
        }
    } else {
        if (option('live_api')) {
            $apiUrl = 'https://api.amadeus.com';
            $url = $apiUrl . '/v1/security/oauth2/token';
            $auth_data = [
                'client_id' => option('live_client_id'),
                'client_secret' => option('live_client_secret'),
                'grant_type' => option('live_grant_type'),
            ];
        } else {
            $apiUrl = 'https://test.api.amadeus.com';
            $url = $apiUrl . '/v1/security/oauth2/token';
            $auth_data = [
                'client_id' => option('test_client_id'),
                'client_secret' => option('test_client_secret'),
                'grant_type' => option('test_grant_type'),
            ];
        }
    }

    try {
        $response = Http::asForm()->post($url, $auth_data);
        $responseBody = $response->json();
        return $responseBody['access_token'];
    } catch (Exception $e) {
        return "Error";
    }
}



function commission($amount, $total)
{
    if (option('commission_fixed')) {
        if (option('commission_fixed_amount') > 0) {
            $amount = $amount + option('commission_fixed_amount') * $total;
        }
    } else {
        if (option('commission_percentage_amount') > 0) {
            $percentage = $amount * (option('commission_percentage_amount')* $total) / 100;
            $amount = $amount + $percentage;
        }
    }
    return $amount;
}


function getWeight($booking, $includedCheckedBags)
{
    if ($booking->bags) {
        return $booking->bags;
    } else {
        try {
            return $includedCheckedBags->weight . " " . $includedCheckedBags->weightUnit;
        } catch (\Throwable $th) {
            return $includedCheckedBags->quantity;
        }
    }
}

function getLogo()
{
    $banner = Banner::where('ishidden', '=', 0)->first();
    return $banner->logo_image ?? '';
}
