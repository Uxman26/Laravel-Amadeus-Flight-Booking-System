<?php

namespace App\Http\Controllers;

use App\Mail\OrderAddedNotification;
use App\Mail\OrderReopenedNotification;
use App\Mail\OrderReopenRequestNotification;
use App\Mail\PassportRenewalNotification;
use App\Mail\TicketNotification;
use App\Mail\TicketBookedAdminNotification;
use App\Mail\PaymentDueNotification;
use App\Models\Banner;
use App\Models\Booking;
use App\Models\DailyReport;
use App\Models\News;
use App\Models\Option;
use App\Models\Package;
use App\Models\Passenger;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        //
    }

    public function get_passenger(Request $request)
    {
        $passenger = Passenger::findOrFail($request->id);
        return response()->json(['passenger', $passenger]);
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
    {dd('kj');
        $validatedData = $request->validate([
            'routes' => 'required',
            'adult_count' => 'required|integer',
            'children_count' => 'required|integer',
            'infant_count' => 'required|integer',
            'payment_gateway' => 'required|string',
            'email' => 'nullable|string',
            'phone' => 'nullable|string',
            'bags' => 'nullable|string',
            'phone_code' => 'nullable|string',
            'trip_type' => 'required|string',
            'marginAmount' => 'required|numeric',
            'pureAmount' => 'required|numeric',
            'admin_buy_price' => 'required|numeric',
            'negoAmount' => 'required|numeric',
            'receivedAmount' => 'required|numeric',
            'ticket_status' => 'required|string',
            'uri' => 'required|string',
        ]);
		$lastTicketingDate = now()->format('Y-m-d H:i:s');
        $routes = json_decode($validatedData['routes']);
		if (option('live_booking')) {
		$validatedData = $request->validate([
            'lastTicketingDate' => 'required',
            'routes' => 'required',
            'adult_count' => 'required|integer',
            'children_count' => 'required|integer',
            'infant_count' => 'required|integer',
            'payment_gateway' => 'required|string',
            'email' => 'nullable|string',
            'phone' => 'nullable|string',
            'bags' => 'nullable|string',
            'phone_code' => 'nullable|string',
            'trip_type' => 'required|string',
            'marginAmount' => 'required|numeric',
            'pureAmount' => 'required|numeric',
            'admin_buy_price' => 'required|numeric',
            'negoAmount' => 'required|numeric',
            'receivedAmount' => 'required|numeric',
            'ticket_status' => 'required|string',
            'uri' => 'required|string',
        ]);
			$lastTicketingDate = now()->parse($routes->lastTicketingDate)->format('Y-m-d H:i:s');
		}





        // adding new Booking
        $booking = new Booking();
        $booking->user_id = auth()->user()->id;
        $booking->routes = $validatedData['routes'];
        $booking->payment_method = $validatedData['payment_gateway'];
        $booking->trip_type = $validatedData['trip_type'];
        $booking->pnr = $this->quickRandom(6);
        $booking->status = $validatedData['ticket_status'];
        $booking->email = $validatedData['email'];
        $booking->phone = $validatedData['phone_code'] . $validatedData['phone'];
        $booking->bags = $validatedData['bags'];
        $booking->last_ticketing_date = $lastTicketingDate;
        $booking->agent_margin = $validatedData['marginAmount'];
        $booking->amount = $validatedData['pureAmount'];
        $booking->nego = $validatedData['negoAmount'];
        $booking->received = $validatedData['receivedAmount'];
        $booking->admin_buy_price = $validatedData['admin_buy_price'];
        $booking->uri = $validatedData['uri'];
        $booking->adults = $validatedData['adult_count'];
        $booking->children = $validatedData['children_count'];
        $booking->infants = $validatedData['infant_count'];
        $booking->save();
        info("Ticket Booked");
        $thispassengerDetail = [];


        $travelerId = 1;


        for ($i = 1; $i < $validatedData['adult_count'] + 1; $i++) {
            // adding passenger
            $passenger = new Passenger();
            $passenger->booking_id =  $booking->id;
            $passenger->type = 'adult';
            $passenger->title = $request->get('title_adult_' . $i);
            $passenger->gender = $request->get('gender_adult_' . $i);
            $passenger->firstname = $request->get('firstname_adult_' . $i);
            $passenger->lastname = $request->get('lastname_adult_' . $i) ?? null;
            $passenger->nationality = $request->get('nationality_adult_' . $i);
            $passenger->dob = Carbon::createFromFormat('d/m/Y', $request->get('dob_adult_' . $i))->format('Y-m-d');
            $passenger->passport = $request->get('passport_adult_' . $i);
            $passenger->passport_expiry = Carbon::createFromFormat('d/m/Y', $request->get('passport_expiry_adult_' . $i))->format('Y-m-d');
            $passenger->save();
            info("Adult Added");

            $passenger;

            $thispassengerDetail[] = [
                'id' => $travelerId,
                'dateOfBirth' => Carbon::parse($passenger->dob)->format('Y-m-d'),
                'name' => [
                    'firstName' => $passenger->firstname,
                    'lastName' => $passenger->lastname,
                ],
                'gender' => $passenger->gender,
                'contact' => [
                    'emailAddress' => option('admin_email'),
                    'phones' => [
                        [
                            'deviceType' => 'MOBILE',
                            'countryCallingCode' => option('admin_phone_code'),
                            'number' => option('admin_phone'),
                        ],
                    ],
                ],
                'documents' => [
                    [
                        'documentType' => 'PASSPORT',
                        'birthPlace' => $request->get('nationality_adult_' . $i),
                        'issuanceLocation' => $request->get('nationality_adult_' . $i),
                        'number' => $request->get('passport_adult_' . $i),
                        'expiryDate' => Carbon::parse($passenger->passport_expiry)->format('Y-m-d'),
                        "issuanceCountry" => $passenger->nationality,
                        "nationality" => $passenger->nationality,
                        'holder' => true,
                    ],
                ]
            ];
            info("Live API Fetched");

            $nextPassengerId = $i;
            $travelerId++;
        }

        for ($i = 1; $i < $validatedData['children_count'] + 1; $i++) {
            // adding passenger
            $passenger = new Passenger();
            $passenger->booking_id =  $booking->id;
            $passenger->type = 'children';
            $passenger->title = $request->get('title_children_' . $i);
            $passenger->gender = $request->get('gender_children_' . $i);
            $passenger->firstname = $request->get('firstname_children_' . $i);
            $passenger->lastname = $request->get('lastname_children_' . $i) ?? null;
            $passenger->nationality = $request->get('nationality_children_' . $i);
            $passenger->dob = Carbon::createFromFormat('d/m/Y', $request->get('dob_children_' . $i))->format('Y-m-d');
            $passenger->passport = $request->get('passport_children_' . $i);
            $passenger->passport_expiry = Carbon::createFromFormat('d/m/Y', $request->get('passport_expiry_children_' . $i))->format('Y-m-d');
            $passenger->save();
            info("Children Added");

            $thispassengerDetail[] = [
                'id' => $travelerId,
                'dateOfBirth' => Carbon::parse($passenger->dob)->format('Y-m-d'),
                'name' => [
                    'firstName' => $passenger->firstname,
                    'lastName' => $passenger->lastname,
                ],
                'gender' => $passenger->gender,
                'contact' => [
                    'emailAddress' => option('admin_email'),
                    'phones' => [
                        [
                            'deviceType' => 'MOBILE',
                            'countryCallingCode' => option('admin_phone_code'),
                            'number' => option('admin_phone'),
                        ],
                    ],
                ],
                'documents' => [
                    [
                        'documentType' => 'PASSPORT',
                        'birthPlace' => $request->get('nationality_adult_' . $i),
                        'issuanceLocation' => $request->get('nationality_adult_' . $i),
                        'number' => $request->get('passport_children_' . $i),
                        "issuanceCountry" => $passenger->nationality,
                        "nationality" => $passenger->nationality,
                        'expiryDate' => Carbon::parse($passenger->passport_expiry)->format('Y-m-d'),
                        'holder' => true,
                    ],
                ]
            ];
            info("Live API Added");

            $nextPassengerId = $i;
            $travelerId++;
        }
        for ($i = 1; $i < $validatedData['infant_count'] + 1; $i++) {
            // adding passenger
            $passenger = new Passenger();
            $passenger->booking_id =  $booking->id;
            $passenger->type = 'infant';
            $passenger->title = $request->get('title_infant_' . $i);
            $passenger->gender = $request->get('gender_infant_' . $i);
            $passenger->firstname = $request->get('firstname_infant_' . $i);
            $passenger->lastname = $request->get('lastname_infant_' . $i) ?? null;
            $passenger->nationality = $request->get('nationality_infant_' . $i);
            $passenger->dob = Carbon::createFromFormat('d/m/Y', $request->get('dob_infant_' . $i))->format('Y-m-d');
            $passenger->passport = $request->get('passport_infant_' . $i);
            $passenger->passport_expiry = Carbon::createFromFormat('d/m/Y', $request->get('passport_expiry_infant_' . $i))->format('Y-m-d');
            $passenger->save();
            info("Infant Added");


            $thispassengerDetail[] = [
                'id' => $travelerId,
                'dateOfBirth' => Carbon::parse($passenger->dob)->format('Y-m-d'),
                'name' => [
                    'firstName' => $passenger->firstname,
                    'lastName' => $passenger->lastname,
                ],
                'gender' => $passenger->gender,
                'contact' => [
                    'emailAddress' => option('admin_email'),
                    'phones' => [
                        [
                            'deviceType' => 'MOBILE',
                            'countryCallingCode' => option('admin_phone_code'),
                            'number' => option('admin_phone'),
                        ],
                    ],
                ],
                'documents' => [
                    [
                        'documentType' => 'PASSPORT',
                        'birthPlace' => $request->get('nationality_infant_' . $i),
                        'issuanceLocation' => $request->get('nationality_infant_' . $i),
                        'number' => $request->get('passport_infant_' . $i),
                        "issuanceCountry" => $passenger->nationality,
                        "nationality" => $passenger->nationality,
                        'expiryDate' => Carbon::parse($passenger->passport_expiry)->format('Y-m-d'),
                        'holder' => true,
                    ],
                ]
            ];
            info("Live API Added");
            $travelerId++;
        }

        $url = $this->ApiUrl . '/v1/booking/flight-orders';
        $accessToken = getApi(); // access token

        info(json_encode($thispassengerDetail));

        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];
        $data = [
            'data' => [
                'type' => 'flight-order',
                'flightOffers' => [
                    json_decode($validatedData['routes'], true)
                ],
                'travelers' => $thispassengerDetail,
                'remarks' => [
                    'general' => [
                        [
                            'subType' => 'GENERAL_MISCELLANEOUS',
                            'text' => 'ONLINE BOOKING FROM GONDAL TRAVEL',
                        ],
                    ],
                ],
                'ticketingAgreement' => [
                    'option' => 'DELAY_TO_CANCEL',
                    'delay' => $request->delay_value ?? option('DELAY_TO_CANCEL'),
                ],
                'contacts' => [
                    [
                        'addresseeName' => [
                            'firstName' => 'NAEEM',
                            'lastName' => 'GONDAL',
                        ],
                        'companyName' => 'GUR ELEC',
                        'purpose' => 'INVOICE',
                        'phones' => [
                            [
                                'deviceType' => 'LANDLINE',
                                'countryCallingCode' => '33',
                                'number' => '771626271',
                            ],
                            [
                                'deviceType' => 'MOBILE',
                                'countryCallingCode' => '33',
                                'number' => '950379906',
                            ],
                        ],
                        'emailAddress' => option('admin_email'),
                        'address' => [
                            'lines' => [
                                '89 AV DU GROUPE MANOUCHIAN',
                            ],
                            'postalCode' => '94400',
                            'cityName' => 'VITRY-SUR-SEINE',
                            'countryCode' => 'FR',
                        ],
                    ],
                ],
            ],
        ];
        if (option('live_booking')) {
            info("Attempt to Live booking Start");
            // checking price before order
            //if (!$this->verify_price($validatedData['routes'], $validatedData['admin_buy_price'])) {
            //    return redirect()->route('index')->withErrors('Price has been Changed, Please Try again');
            //}
            $response = Http::withHeaders($headers)->post($url, $data);
            if (isset($response['errors'])) {
                info("Error " . $response['errors'][0]['detail']);
                $error = $response['errors'][0]['detail'];
                return redirect()->route('index')->withErrors($error);
            }
            $liveData = $response->json();
            info(json_encode($liveData));
            $booking = Booking::find($booking->id);
            $booking->pnr = $liveData['data']['associatedRecords'][0]['reference'];
            if (isset($liveData['data']['associatedRecords'])) {
                foreach ($liveData['data']['associatedRecords'] as $data) {
                    if ($data['originSystemCode'] != 'GDS' && $data['reference'] != $booking->pnr) {
                        $booking->pnr_ts = $data['reference'];
                    }
                }
            }
            $booking->pnr_status = 'live';
            $booking->ticket_status = 'Booked';
            $booking->pnr_track_id = $liveData['data']['id'];
            $booking->live_data = json_encode($liveData);
            $booking->save();
            info("Live API Ticket Booked");
        }
        if ($booking->email != "") {
            // send notification to this user
            Mail::to($booking->email)->send(new TicketNotification($booking, $passenger));
            // send notification to the admin
            Mail::to(option('admin_email'))->send(new TicketBookedAdminNotification($booking, $passenger));
            info("Email Sent to admin");

            $amount = $booking->agent_margin - $booking->received;
            if ($amount > 0) {
                info('This Customer Found with Pending Payment, sending notification');
                Mail::to($booking->email)->send(new PaymentDueNotification($booking));
                info('Due Payment Notification Sent');
            }
        }
        if ($booking->phone != "") {
            $url = 'https://graph.facebook.com/v17.0/122106273722003042/messages';

            $accessToken = 'EAAOtb7cPMDABO14rHxdoIKCzqZC2nuZBZCrdmSpKZAU9qsZCzf5WBgECJZATPkU9KTs0xyGhlyiE8oAZBuJNOmblC1DIZBBFhi6HLxRcKtyY02jYRc13Mn79jCE2A4LGFOXD2hRxp6GcanfgUkR6OsllwAncmuzJ1eJeMnzNvGZAF8nsXjpZBmjGbRD8s54XYoaVKJUaDsdd7gBK793MjDREJ5ZAIeuvupZBSK5ny2YZD';

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])
                ->post($url, [
                    'messaging_product' => 'whatsapp',
                    'to' => $booking->phone,
                    'type' => 'template',
                    'template' => [
                        'name' => 'hello_world',
                        'language' => [
                            'code' => 'en_US',
                        ],
                    ],
                ]);

            // Handle the response as needed
            $statusCode = $response->status();
            $responseData = $response->json();

            // You can return a response or handle the data accordingly
            $data = response()->json([
                'status' => $statusCode,
                'data' => $responseData,
            ]);
        }
        return redirect()->route('flight.booking.show', ['booking' => $booking->id])->with('success', 'Ticket Has Been Booked');
    }



    private function verify_price($routes, $price)
    {
        info("Attempt to Verify Price");
        // Build the request URL and headers
        $flightPricingUrl = $this->ApiUrl . '/v1/shopping/flight-offers/pricing';
        $accessToken = getApi();
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];

        // Prepare the request payload
        $data = [
            'data' => [
                'type' => 'flight-offers-pricing',
                'flightOffers' => [json_decode($routes)], // Replace with your flight offer data
            ],
        ];

        // Send the price verification request
        $response = Http::withHeaders($headers)->post($flightPricingUrl, $data);
        // Handle the response
        if ($response->successful()) {
            $pricingData = $response->json();
            // Process the pricing data as needed
            if ($price == $pricingData['data']['flightOffers'][0]['price']['grandTotal']) {
                info("Price is Matched" . $pricingData['data']['flightOffers'][0]['price']['grandTotal']);
                return true;
            } else {
                info("Price is Mis-Matched");
                return false;
            }
        } else {
            $error = $response->json('errors.0.detail');
            info("Error on Attempt to Verify Price");
            return false;
        }
    }


    private static function quickRandom($length = 16)
    {
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $flightData = json_decode($booking->routes);
        return view('booking.show', compact('booking', 'flightData'));
    }
    public function show_off(Request $request)
    {
        $booking = Booking::findOrFail($request->booking);
        $flightData = json_decode($booking->routes);
        return view('booking.show', compact('booking', 'flightData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }


    public function ticket($id, $hash, $pnr)
    {
        $booking = Booking::findOrFail($id);
        $passenger = Passenger::where('booking_id', $id)->first();
        $originalHash = md5($booking->uri);
        if ($originalHash == $hash) {
            $flightData = json_decode($booking->routes);
            $text = "As-salamu alaykum Dear $passenger->firstname $passenger->lastname , Please check that the passengers name, date of travel, and destination are all accurate. Any errors or mistakes in this information Please contact immediately with travel agent Thanks, Gondal Travel";
            return redirect()->route('flight.booking.show_off', ['booking' => $booking->id])->with('notice', $text);
        } else {
            abort(404);
        }
    }

    public function new_order(Request $request)
    {
        session()->forget('bookingData');
        $news = News::all();
        $packages = Package::where('status', 1)->get();
        $slides = Slider::all();
        $banner = Banner::where('ishidden', '=', 0)->first();
        $settings = DB::table('footer_settings')->first();
        $color = Option::where('key', 'themecolor')->first()->value;
        return view('booking.new_order', ['color' => $color, 'packages' => $packages, 'news' => $news, 'slides' => $slides, 'banner' => $banner, 'settings' => $settings]);
        // return view('booking.new_order', compact('request'));
    }
    public function create_daily_report(Request $request)
    {
        return view('booking.create_daily_report', compact('request'));
    }
    public function store_daily_report(Request $request)
    {
        if ($request->checkbox == 'on') {
            $order = new DailyReport();
            $order->order_no = rand(pow(10, 4 - 1), pow(10, 4) - 1);;
            $order->firstname = $request->firstname ?? null;
            $order->lastname = $request->lastname ?? null;
            $order->email = $request->email ?? null;
            $order->phone_number = $request->phone_number ?? null;
            $order->flexible_date = $request->flexible_date ?? 'off';
            $order->preffered_airline = $request->preffered_airline ?? null;
            $order->trip_type = $request->trip_type ?? null;
            $order->flight_type = $request->flight_type ?? null;
            $order->origin1 = $request->origin1 ?? null;
            $order->destination1 = $request->destination1 ?? null;
            $order->departureDate1 = $request->departureDate1 ?? null;
            $order->returnDate1 = $request->returnDate1 ?? null;
            $order->origin2 = $request->origin2 ?? null;
            $order->destination2 = $request->destination2 ?? null;
            $order->departureDate2 = $request->departureDate2 ?? null;
            $order->origin3 = $request->origin3 ?? null;
            $order->destination3 = $request->destination3 ?? null;
            $order->departureDate3 = $request->departureDate3 ?? null;
            $order->origin4 = $request->origin4 ?? null;
            $order->destination4 = $request->destination4 ?? null;
            $order->departureDate4 = $request->departureDate4 ?? null;
            $order->adults = $request->adult ?? null;
            $order->children = $request->children ?? null;
            $order->infants = $request->infant ?? null;
            $order->remark = $request->remark ?? null;
            $order->user_id =  null;
            // $order->status =  'pending';
            $order->status =  'open';
            $order->save();
            Mail::to($order->email)->send(new OrderAddedNotification($order));
            Mail::to(option('admin_email'))->send(new OrderAddedNotification($order));
            Mail::to('ordergondaltravel@gmail.com')->send(new OrderAddedNotification($order));

        return redirect()->route('index')->with('success', 'Order Added Successfully');
        } else {
            return redirect()->back()->with('error', 'Please Accept Terms & Conditions');
        }
    }
    public function reopen_request(Request $request)
    {
        $order = DailyReport::where('order_no', $request->order_no)->first();
        $order->status = 'open';
        $order->save();
        Mail::to($order->email)->send(new OrderReopenRequestNotification($order));
        Mail::to(option('admin_email'))->send(new OrderReopenRequestNotification($order));
        Mail::to('ordergondaltravel@gmail.com')->send(new OrderReopenRequestNotification($order));
        $DailyReport = DailyReport::where('order_no', $request->order_no)->first();
        Mail::to($DailyReport->email)->send(new OrderReopenedNotification($DailyReport));
        Mail::to(option('admin_email'))->send(new OrderReopenedNotification($DailyReport));
        Mail::to('ordergondaltravel@gmail.com')->send(new OrderReopenedNotification($DailyReport));
        return redirect()->route('index')->with('success', 'Order Re-Open Requested Has Been Sent');
    }
}
