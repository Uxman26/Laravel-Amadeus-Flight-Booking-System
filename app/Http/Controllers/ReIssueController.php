<?php

namespace App\Http\Controllers;

use App\Console\Commands\customer\PaymentDueNotification;
use App\Mail\PaymentDueNotification as MailPaymentDueNotification;
use App\Mail\TicketBookedAdminNotification;
use App\Mail\TicketNotification;
use App\Mail\TicketReIssueNotification;
use App\Models\Booking;
use App\Models\Passenger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ReIssueController extends Controller
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
            'uri' => 'required',
        ]);

        $oldBooking = Booking::findOrFail(session('bookingData')->id);

        $routes = json_decode($validatedData['routes']);
        $lastTicketingDate = now()->parse($routes->lastTicketingDate)->format('Y-m-d H:i:s');





        // adding new Booking
        $booking = new Booking();
        $booking->user_id = $oldBooking->user_id;
        $booking->routes = $validatedData['routes'];
        $booking->last_ticketing_date = $lastTicketingDate;
        $booking->amount = $routes->price->grandTotal;
        $booking->admin_buy_price = $routes->price->grandTotal;
        $booking->uri = $validatedData['uri'];

        $booking->payment_method = $oldBooking->payment_method;
        $booking->trip_type = $oldBooking->trip_type;
        $booking->pnr = $oldBooking->pnr;
        $booking->status = 'Re-issued'; //
        $booking->email = $oldBooking->email;
        $booking->phone = $oldBooking->phone_code . $oldBooking->phone;
        $booking->bags = $oldBooking->bags;
        $booking->nego = $request->negoAmountResissue;
        $booking->received = $oldBooking->receivedAmount;
        $booking->adults = $oldBooking->adults;
        $booking->children = $oldBooking->children;
        $booking->infants = $oldBooking->infants;
        $booking->agent_margin = $request->marginAmount;
        $booking->save();
        info("Ticket Booked");
        $thispassengerDetail = [];


        $travelerId = 1;


        $passengersAll = Passenger::where('booking_id', $oldBooking->id)->get();
        foreach ($passengersAll as $key => $passenger) {
            if ($passenger->type == 'adult') {
                // adding passenger
                $newPassenger = new Passenger();
                $newPassenger->booking_id =  $booking->id;
                $newPassenger->type = 'adult';
                $newPassenger->title = $passenger->title;
                $newPassenger->gender = $passenger->gender;
                $newPassenger->firstname = $passenger->firstname;
                $newPassenger->lastname = $passenger->lastname;
                $newPassenger->nationality = $passenger->nationality;
                $newPassenger->dob = $passenger->dob;
                $newPassenger->passport = $passenger->passport;
                $newPassenger->passport_expiry = $passenger->passport_expiry;
                $newPassenger->save();
                info("Adult Added");

                $thispassengerDetail[] = [
                    'id' => $travelerId,
                    'dateOfBirth' => Carbon::parse($newPassenger->dob)->format('Y-m-d'),
                    'name' => [
                        'firstName' => $newPassenger->firstname,
                        'lastName' => $newPassenger->lastname,
                    ],
                    'gender' => $newPassenger->gender,
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
                            'birthPlace' => $newPassenger->nationality,
                            'issuanceLocation' => $newPassenger->nationality,
                            'number' => $newPassenger->passport_adult_ . $key + 1,
                            'expiryDate' => Carbon::parse($newPassenger->passport_expiry)->format('Y-m-d'),
                            "issuanceCountry" => $newPassenger->nationality,
                            "nationality" => $newPassenger->nationality,
                            'holder' => true,
                        ],
                    ]
                ];
                info("Live API Fetched");

                $travelerId++;
            } else if ($passenger->type == 'children') {
                // adding passenger
                $newPassenger = new Passenger();
                $newPassenger->booking_id =  $booking->id;
                $newPassenger->type = 'children';
                $newPassenger->title = $passenger->title;
                $newPassenger->gender = $passenger->gender;
                $newPassenger->firstname = $passenger->firstname;
                $newPassenger->lastname = $passenger->lastname;
                $newPassenger->nationality = $passenger->nationality;
                $newPassenger->dob = $passenger->dob;
                $newPassenger->passport = $passenger->passport;
                $newPassenger->passport_expiry = $passenger->passport_expiry;
                $newPassenger->save();
                info("Children Added");

                $thispassengerDetail[] = [
                    'id' => $travelerId,
                    'dateOfBirth' => Carbon::parse($newPassenger->dob)->format('Y-m-d'),
                    'name' => [
                        'firstName' => $newPassenger->firstname,
                        'lastName' => $newPassenger->lastname,
                    ],
                    'gender' => $newPassenger->gender,
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
                            'birthPlace' => $newPassenger->nationality,
                            'issuanceLocation' => $newPassenger->nationality,
                            'number' => $newPassenger->passport_children_ . $key + 1,
                            'expiryDate' => Carbon::parse($newPassenger->passport_expiry)->format('Y-m-d'),
                            "issuanceCountry" => $newPassenger->nationality,
                            "nationality" => $newPassenger->nationality,
                            'holder' => true,
                        ],
                    ]
                ];
                info("Live API Fetched");

                $travelerId++;
            } else if ($passenger->type == 'infant') {
                // adding passenger
                $newPassenger = new Passenger();
                $newPassenger->booking_id =  $booking->id;
                $newPassenger->type = 'infant';
                $newPassenger->title = $passenger->title;
                $newPassenger->gender = $passenger->gender;
                $newPassenger->firstname = $passenger->firstname;
                $newPassenger->lastname = $passenger->lastname;
                $newPassenger->nationality = $passenger->nationality;
                $newPassenger->dob = $passenger->dob;
                $newPassenger->passport = $passenger->passport;
                $newPassenger->passport_expiry = $passenger->passport_expiry;
                $newPassenger->save();
                info("Infant Added");

                $thispassengerDetail[] = [
                    'id' => $travelerId,
                    'dateOfBirth' => Carbon::parse($newPassenger->dob)->format('Y-m-d'),
                    'name' => [
                        'firstName' => $newPassenger->firstname,
                        'lastName' => $newPassenger->lastname,
                    ],
                    'gender' => $newPassenger->gender,
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
                            'birthPlace' => $newPassenger->nationality,
                            'issuanceLocation' => $newPassenger->nationality,
                            'number' => $newPassenger->passport_infant_ . $key + 1,
                            'expiryDate' => Carbon::parse($newPassenger->passport_expiry)->format('Y-m-d'),
                            "issuanceCountry" => $newPassenger->nationality,
                            "nationality" => $newPassenger->nationality,
                            'holder' => true,
                        ],
                    ]
                ];
                info("Live API Fetched");

                $travelerId++;
            }
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
                    'delay' => '7D',
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
                Mail::to($booking->email)->send(new MailPaymentDueNotification($booking));
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
        return redirect()->route('flight.booking.show', ['booking' => $booking->id]);
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
