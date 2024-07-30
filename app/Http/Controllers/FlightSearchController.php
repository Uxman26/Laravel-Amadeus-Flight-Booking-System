<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Month;
use App\Models\SearchHistory;
use App\Models\Passenger;
use App\Models\Airline;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class FlightSearchController extends Controller
{
    private $ApiUrl;

    public function __construct()
    {
        if (option('enterprise_api')) {
            if (option('live_api')) {
                $this->ApiUrl = 'https://travel.api.amadeus.com';
            } else {
                $this->ApiUrl = 'https://test.travel.api.amadeus.com';
            }
        } else {
            if (option('live_api')) {
                $this->ApiUrl = 'https://api.amadeus.com';
            } else {
                $this->ApiUrl = 'https://test.api.amadeus.com';
            }
        }
    }

    public function index()
    {
        return redirect()->route('index');
    }
    public function airlines(Request $request)
    {
        $search = $request->input('search');
        $airlines = Airline::where('name', 'like', '%'.$search.'%')->orWhere('code',$search)->get();
        return response()->json($airlines);
    }
    public function search(Request $request)
    {
        $term = $request->get('term');
        $access_token = getApi();

        $response = Http::get($this->ApiUrl . '/v1/reference-data/locations', [
            'subType' => 'AIRPORT',
            'keyword' => $term,
        ]);
        $headers = array('Authorization' => 'Bearer ' . $access_token);
        $responses = Http::withHeaders($headers)->get($response);
        return response()->json($responses->json());
    }
    public function addingHistory($origin, $destination)
    {
        $search = new SearchHistory();
        $search->user_id = auth()->user()->id;
        $search->uri = url()->current();
        $search->origin = $origin;
        $search->destination = $destination;
        $search->save();
    }


    /**
     * Display a listing of the resource.
     */
    public function oneway($origin, $destination, $flight_type, $cdeparture, $adult, $children, $infant, $airline = null)
    {
        $access_token = getApi();
        $flight = $this->ApiUrl . '/v2/shopping/flight-offers';
        $orgDate = $cdeparture; //departing date
        if (date('Y-m-d', strtotime($orgDate)) < Carbon::now()->format('Y-m-d')) {
            $orgDate = Carbon::now()->addDay()->format('Y-m-d');
        }
        $travel_data = [
            'originLocationCode' => strtoupper($origin),
            'destinationLocationCode' => strtoupper($destination),
            'departureDate' => date('Y-m-d', strtotime($orgDate)),
            'adults' => $adult,
            'children' => $children,
            'infants' => $infant,
            'travelClass' => strtoupper($flight_type),
        ];
        if (isset($airline) && $airline != 'null') {
            $travel_data['includedAirlineCodes'] = $airline;
        }
        if (session()->exists('includedAirlineCodes')) {
            $travel_data['includedAirlineCodes'] = session('includedAirlineCodes');
        }
        $fields = http_build_query($travel_data);
        $url = $flight . '?' . $fields;
        $headers = array('Authorization' => 'Bearer ' . $access_token);
        $response = Http::withHeaders($headers)->get($url);

        if (isset($response['errors'])) {
            $error = $response['errors'][0]['title'];
            return redirect()->back()->withErrors($error);
        }
        if ($response->json()['meta']['count'] < 1) {
            return redirect()->back()->withErrors("No Flight Found.");
        }
        $allFlights =  collect($response->json())['data'];
        if (option('paginate_50')) {
            $allFlights = array_slice($allFlights, 0, 50);
        }
        $data['allFlightsCount'] = $response->json()['meta']['count'];
        // Airline Code Lookup Api
        $access_token = getApi();
        $flight = $this->ApiUrl . '/v1/reference-data/airlines';
        $orgDate = $cdeparture;
        $travel_data = [
            'airlineCodes' => "PK",
        ];
        $fields = http_build_query($travel_data);
        $url = $flight . '?' . $fields;
        $headers = array('Authorization' => 'Bearer ' . $access_token);
        $response = Http::withHeaders($headers)->get($url);
// dd($allFlights);
        $data['from'] = $origin;
        $data['to'] = $destination;
        $data['class'] = strtoupper($flight_type);
        $data['trip_type'] = 'oneway';
        $data['departure'] = $cdeparture;
        $data['adult'] = $adult;
        $data['children'] = $children;
        $data['infant'] = $infant;
        $data['minPrice'] = $this->priceMin($allFlights);
        $data['maxPrice'] = $this->priceMax($allFlights);
        $data['flightsFilters'] = $this->flightsFilter($allFlights);
        $data['nextDayRoute'] = getNextOrBackUri(true);
        $data['backDayRoute'] = getNextOrBackUri(false);
        $this->addingHistory($origin, $destination);
        return view('flight.search.index', compact('allFlights', 'data'));
    }




    public function return($origin, $destination, $flight_type, $cdeparture, $return, $adult, $children, $infant, $airline = null)
    {
        $access_token = getApi();
        $flight = $this->ApiUrl . '/v2/shopping/flight-offers';
        $orgDate = $cdeparture; //departing date
        if (date('Y-m-d', strtotime($orgDate)) < Carbon::now()->format('Y-m-d')) {
            $orgDate = Carbon::now()->addDay()->format('Y-m-d');
        }
        if (date('Y-m-d', strtotime($return)) <= date('Y-m-d', strtotime($orgDate))) {
            $return = Carbon::parse($orgDate)->addWeek()->format('Y-m-d');
        }
        if (date('Y-m-d') > date('Y-m-d', strtotime($orgDate))) {
            $travel_data = [
                'originLocationCode' => strtoupper($origin),
                'destinationLocationCode' => strtoupper($destination),
                'departureDate' => date('Y-m-d', strtotime($return)),
                'adults' => $adult,
                'children' => $children,
                'infants' => $infant,
                'travelClass' => strtoupper($flight_type),
            ];
        } else {
            $travel_data = [
                'originLocationCode' => strtoupper($origin),
                'destinationLocationCode' => strtoupper($destination),
                'departureDate' => date('Y-m-d', strtotime($orgDate)),
                'returnDate' => date('Y-m-d', strtotime($return)),
                'adults' => $adult,
                'children' => $children,
                'infants' => $infant,
                'travelClass' => strtoupper($flight_type),
            ];
        }
        if (isset($airline) && $airline != 'null') {
            $travel_data['includedAirlineCodes'] = $airline;
        }
        $fields = http_build_query($travel_data);
        $url = $flight . '?' . $fields;
        $headers = array('Authorization' => 'Bearer ' . $access_token, 'Accept' => 'application/json, application/vnd.amadeus+json');
        $response = Http::withHeaders($headers)->get($url);
        if (isset($response['errors'])) {
            $error = $response['errors'][0]['detail'];
            return redirect()->back()->withErrors($error);
        }
        if ($response->json()['meta']['count'] < 1) {
            return redirect()->back()->withErrors("No Flight Found.");
        }
        $allFlights =  collect($response->json())['data'];
        if (option('paginate_50')) {
            $allFlights = array_slice($allFlights, 0, 50);
        }
        $data['allFlightsCount'] = $response->json()['meta']['count'];

        // Airline Code Lookup Api
        $access_token = getApi();
        $flight = $this->ApiUrl . '/v1/reference-data/airlines';
        $orgDate = $cdeparture;
        $travel_data = [
            'airlineCodes' => "PK",
        ];
        $fields = http_build_query($travel_data);
        $url = $flight . '?' . $fields;
        $headers = array('Authorization' => 'Bearer ' . $access_token);
        $response = Http::withHeaders($headers)->get($url);


        $data['from'] = $origin;
        $data['to'] = $destination;
        $data['class'] = strtoupper($flight_type);
        $data['trip_type'] = 'return';
        if (date('Y-m-d') > date('Y-m-d', strtotime($orgDate))) {
            $data['departure'] = $return;
        } else {
            $data['departure'] = $cdeparture;
            $data['returning'] = $return;
        }
        $data['adult'] = $adult;
        $data['children'] = $children;
        $data['infant'] = $infant;
        $data['minPrice'] = $this->priceMin($allFlights);
        $data['maxPrice'] = $this->priceMax($allFlights);
        $data['flightsFilters'] = $this->flightsFilter($allFlights);
        $data['nextDayRoute'] = getNextOrBackUri(true);
        $data['backDayRoute'] = getNextOrBackUri(false);
        $this->addingHistory($origin, $destination);
        return view('flight.search.index', compact('allFlights', 'data'));
    }

    public function multiCity($origin1, $destination1, $departureDate1, $origin2, $destination2, $departureDate2, $origin3, $destination3, $departureDate3, $origin4, $destination4, $departureDate4, $adults, $children, $infants, $airline = null)
    {
        $access_token = getApi();
        $flight = $this->ApiUrl . '/v2/shopping/flight-offers';
        if (isset($origin3) && isset($origin4) && $origin3 != 'null' && $origin4 != 'null') {
            $segments = [
                [
                    'id' => 1,
                    'originLocationCode' => strtoupper($origin1),
                    'destinationLocationCode' => strtoupper($destination1),
                    'departureDateTimeRange' => [
                        'date' => date('Y-m-d', strtotime($departureDate1)),
                        'time' => '00:00:00',
                    ],
                ],
                [
                    'id' => 2,
                    'originLocationCode' => strtoupper($origin2),
                    'destinationLocationCode' => strtoupper($destination2),
                    'departureDateTimeRange' => [
                        'date' => date('Y-m-d', strtotime($departureDate2)),
                        'time' => '00:00:00',
                    ],
                ],
                [
                    'id' => 3,
                    'originLocationCode' => strtoupper($origin3),
                    'destinationLocationCode' => strtoupper($destination3),
                    'departureDateTimeRange' => [
                        'date' => date('Y-m-d', strtotime($departureDate3)),
                        'time' => '00:00:00',
                    ],
                ],
                [
                    'id' => 3,
                    'originLocationCode' => strtoupper($origin4),
                    'destinationLocationCode' => strtoupper($destination4),
                    'departureDateTimeRange' => [
                        'date' => date('Y-m-d', strtotime($departureDate4)),
                        'time' => '00:00:00',
                    ],
                ],
            ];
        } elseif (isset($origin3) && $origin3 != 'null') {
            $segments = [
                [
                    'id' => 1,
                    'originLocationCode' => strtoupper($origin1),
                    'destinationLocationCode' => strtoupper($destination1),
                    'departureDateTimeRange' => [
                        'date' => date('Y-m-d', strtotime($departureDate1)),
                        'time' => '00:00:00',
                    ],
                ],
                [
                    'id' => 2,
                    'originLocationCode' => strtoupper($origin2),
                    'destinationLocationCode' => strtoupper($destination2),
                    'departureDateTimeRange' => [
                        'date' => date('Y-m-d', strtotime($departureDate2)),
                        'time' => '00:00:00',
                    ],
                ],
                [
                    'id' => 3,
                    'originLocationCode' => strtoupper($origin3),
                    'destinationLocationCode' => strtoupper($destination3),
                    'departureDateTimeRange' => [
                        'date' => date('Y-m-d', strtotime($departureDate3)),
                        'time' => '00:00:00',
                    ],
                ]
            ];
        } else {
            $segments = [
                [
                    'id' => 1,
                    'originLocationCode' => strtoupper($origin1),
                    'destinationLocationCode' => strtoupper($destination1),
                    'departureDateTimeRange' => [
                        'date' => date('Y-m-d', strtotime($departureDate1)),
                        'time' => '00:00:00',
                    ],
                ],
                [
                    'id' => 2,
                    'originLocationCode' => strtoupper($origin2),
                    'destinationLocationCode' => strtoupper($destination2),
                    'departureDateTimeRange' => [
                        'date' => date('Y-m-d', strtotime($departureDate2)),
                        'time' => '00:00:00',
                    ],
                ]
            ];
        }

        $travelerId = 1;

        if ($adults > 0) {
            for ($i = 1; $i <= $adults; $i++) {
                $travelers[] = [
                    'id' => $travelerId,
                    'travelerType' => 'ADULT',
                ];
                $travelerId++;
            }
        }

        if ($children > 0) {
            for ($i = 1; $i <= $children; $i++) {
                $travelers[] = [
                    'id' => $travelerId,
                    'travelerType' => 'CHILD',
                ];
                $travelerId++;
            }
        }

        if ($infants > 0) {
            for ($i = 1; $i <= $infants; $i++) {
                $travelers[] = [
                    'id' => $travelerId,
                    'travelerType' => 'HELD_INFANT',
                    'associatedAdultId' => $i,
                ];
                $travelerId++;
            }
        }

        $request_data = [
            'currencyCode' => 'EUR',
            'travelers' => $travelers,
            'sources' => ['GDS'],
            'searchCriteria' => [
                'maxFlightOffers' => 10,
            ],
            'originDestinations' => $segments,
        ];
        if (isset($airline) && $airline != 'null') {
            $request_data['includedAirlineCodes'] = $airline;
        }
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $access_token,
        ])->post($flight, $request_data);

        if (!$response->successful()) {
            return back()->withErrors('Error: ' . $response['errors'][0]['detail']);
        }

        if ($response->json()['meta']['count'] < 1) {
            return redirect()->back()->withErrors("No Flight Found.");
        }

        $allFlights = $response->json()['data'];
        if (option('paginate_50')) {
            $allFlights = array_slice($allFlights, 0, 50);
        }
        $data['allFlightsCount'] = $response->json()['meta']['count'];


        // Airline Code Lookup Api
        $access_token = getApi();
        $flight = $this->ApiUrl . '/v1/reference-data/airlines';
        $orgDate = $departureDate1;
        $travel_data = [
            'airlineCodes' => "PK",
        ];

        $fields = http_build_query($travel_data);
        $url = $flight . '?' . $fields;
        $headers = array('Authorization' => 'Bearer ' . $access_token);
        $response = Http::withHeaders($headers)->get($url);

        $access_token = getApi();
        $flight = $this->ApiUrl . '/v1/reference-data/airlines';
        $orgDate = $departureDate2;
        $travel_data = [
            'airlineCodes' => "PK",
        ];
        $fields = http_build_query($travel_data);
        $url = $flight . '?' . $fields;
        $headers = array('Authorization' => 'Bearer ' . $access_token);
        $response = Http::withHeaders($headers)->get($url);

        $data['from'] = $origin1;
        $data['to'] = $destination1;
        $data['class'] = strtoupper('ECONOMY');
        $data['trip_type'] = 'multi';
        $data['departure'] = $departureDate1;
        $data['adult'] = $adults;
        $data['children'] = $children;
        $data['infant'] = $infants;
        $data['minPrice'] = $this->priceMin($allFlights);
        $data['maxPrice'] = $this->priceMax($allFlights);
        $data['flightsFilters'] = $this->flightsFilter($allFlights);
        $data['nextDayRoute'] = 'http://127.0.0.1:8000/flight/jed/lhe/oneway/economy/07-07-2023/1/0/0';
        $data['backDayRoute'] = 'http://127.0.0.1:8000/flight/jed/lhe/oneway/economy/07-07-2023/1/0/0';
        return view('flight.search.index', compact('allFlights', 'data'));

        // Process the flight results as needed

        // Return the view or response
    }





    public function flightsFilter($flights)
    {
        $flightCode = array();
        foreach ($flights as $flight) {
            $flightCode[] = $flight['validatingAirlineCodes'][0];
        }
        return array_unique($flightCode);
    }




    public function priceMin($flights)
    {
        $min = array();
        foreach ($flights as $flight) {
            $min[] = $flight['price']['grandTotal'];
        }
        $numbers = array_map('floatval', $min);
        return min($numbers);
    }

    public function priceMax($flights)
    {
        $min = array();
        foreach ($flights as $flight) {
            $min[] = $flight['price']['grandTotal'];
        }
        $numbers = array_map('floatval', $min);
        return max($numbers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'routes' => 'required',
            'amount' => 'required',
            'currency' => 'required',
            'adult' => 'required',
            'children' => 'required',
            'infant' => 'required',
            'trip_type' => 'required',
            'uri' => 'required',
        ]);

        $routes = $validatedData['routes'];
        $travelerType = collect(json_decode($routes)->travelerPricings);
        $data['amount'] = $validatedData['amount'];
        $data['currency'] = $validatedData['currency'];
        $data['adult'] = $validatedData['adult'];
        $data['children'] = $validatedData['children'];
        $data['infant'] = $validatedData['infant'];
        $data['trip_type'] = $validatedData['trip_type'];
        $data['uri'] = $validatedData['uri'];
        $passengers['adult'] = Passenger::where('type', 'adult')->get();
        $passengers['infant'] = Passenger::where('type', 'infant')->get();
        $passengers['children'] = Passenger::where('type', 'children')->get();
        return view('booking.index', compact('routes', 'data', 'travelerType', 'passengers'));
    }
    public function verify_price(Request $request)
    {
        info("Attempt to Verify Price");
        // Build the request URL and headers
        $flightPricingUrl = $this->ApiUrl . '/v1/shopping/flight-offers/pricing';
        // $this->ApiUrl . '/v2/shopping/flight-offers';
        $accessToken = getApi();
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];

        // Prepare the request payload
        $data = [
            'data' => [
                'type' => 'flight-offers-pricing',
                'flightOffers' => [json_decode($request->routes)], // Replace with your flight offer data
            ],
        ];

        // Send the price verification request
        $response = Http::withHeaders($headers)->post($flightPricingUrl, $data);
        // Handle the response
        if ($response->successful()) {
            $pricingData = $response->json();
            return response()->json(['status' => true, 'price' => $pricingData['data']['flightOffers'][0]['price']['grandTotal']]);
        } else {
            return response()->json(['status' => false]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
