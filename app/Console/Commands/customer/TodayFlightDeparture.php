<?php

namespace App\Console\Commands\customer;

use App\Mail\AfterDepartureNotificaiton;
use App\Mail\DayDepartureNotification;
use App\Mail\DepartureNotificaiton;
use App\Mail\DepartureTimeChange;
use App\Models\Booking;
use App\Models\Passenger;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class TodayFlightDeparture extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:today-flight-departure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Customer Email if the departure date is today';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bookings = Booking::where('ticket_status', 'issued')->get();
        foreach ($bookings as $booking) {
            info('in the loop');
            if (isset($booking->routes)) {
                $routes = json_decode($booking->routes);
                $departureDate = Carbon::parse($routes->itineraries[0]->segments[0]->departure->at)->diffInHours(now());
                info($departureDate . "Hours Remaining");
                if (Carbon::parse($routes->itineraries[0]->segments[0]->departure->at)->format('Y-m-d') >= Carbon::now()->format('Y-m-d')) {
                    if ($departureDate > 96 && $departureDate < 120) {
                        Mail::to($booking->email)->send(new DayDepartureNotification($booking, 0));
                    } else if ($departureDate < 72) {
                        info('Booking Found');
                        Mail::to($booking->email)->send(new DepartureNotificaiton($booking, 0));
                        info('Email Sent for Booking Departure');
                    } else {
                        info('Not Relative');
                    }
                }
                if ($departureDate > 72 && $departureDate < 96 && Carbon::parse($routes->itineraries[0]->segments[0]->departure->at) < now()) {
                    Mail::to($booking->email)->send(new AfterDepartureNotificaiton($booking, 0));
                }
                if (isset($routes->itineraries[1])) {
                    $departureDate1 = Carbon::parse($routes->itineraries[1]->segments[0]->departure->at)->diffInHours(now());
                    if ($booking->trip_type == 'return' && isset(json_decode($booking->routes)->itineraries[1]) && Carbon::parse($routes->itineraries[1]->segments[0]->departure->at)->format('Y-m-d') >= Carbon::now()->format('Y-m-d')) {
                        if ($departureDate1 > 96 && $departureDate1 < 120) {
                            Mail::to($booking->email)->send(new DayDepartureNotification($booking, 1));
                        } else if ($departureDate1 < 72) {
                            info('Booking Found');
                            Mail::to($booking->email)->send(new DepartureNotificaiton($booking, 1));
                            info('Email Sent for Booking Departure');
                        } else {
                            info('Not Relative');
                        }
                    }
                    if ($departureDate1 > 72 && $departureDate1 < 96 && Carbon::parse($routes->itineraries[1]->segments[0]->departure->at) < now()) {
                        Mail::to($booking->email)->send(new AfterDepartureNotificaiton($booking, 1));
                    }
                }
            }
        }

        $bookings = Booking::whereIn('ticket_status', ['issued', 'Booked'])->get();
        foreach ($bookings as $booking) {
            info('in the loop');
            if (isset($booking->routes)) {
                $routes = json_decode($booking->routes);
                $departureDate = Carbon::parse($routes->itineraries[0]->segments[0]->departure->at)->diffInHours(now());
                if ($departureDate > 0 && $departureDate < 120 && Carbon::parse($routes->itineraries[0]->segments[0]->departure->at) < now()) {
                    if ($booking->pnr_track_id != "") {
                        $orderId = $booking->pnr_track_id;
                        if (option('enterprise_api')) {
                            if (option('live_api')) {
                                $ApiUrl = 'https://travel.api.amadeus.com';
                            } else {
                                $ApiUrl = 'https://test.travel.api.amadeus.com';
                            }
                        } else {
                            if (option('live_api')) {
                                $ApiUrl = 'https://api.amadeus.com';
                            } else {
                                $ApiUrl = 'https://test.api.amadeus.com';
                            }
                        }
                        $url = $ApiUrl . "/v1/booking/flight-orders/{$orderId}";

                        $accessToken = getApi();

                        $headers = [
                            'Authorization' => 'Bearer ' . $accessToken,
                            'Content-Type' => 'application/json'
                        ];
                        $response = Http::withHeaders($headers)->get($url);


                        if (isset($response['data'])) {
                            if (isset($response['data']['tickets'])) {
                                $passengersArray = $booking->passengers->pluck('id')->toArray();
                                foreach ($response['data']['tickets'] as $key => $data) {
                                    // if ($data['travelerId'] == $key + 1) {
                                        unset($passengersArray[$data['travelerId']-1]);
                                        $passenger = Passenger::where('id', $booking->passengers[$data['travelerId']-1]->id)->first();
                                        $passenger->etkt = str_replace('-', '', $data['documentNumber']);
                                        $passenger->save();
                                    // }
                                    $booking->ticket_status = 'issued';
                                }
                                foreach($passengersArray as $item){
                                    Passenger::where('id', $item)->first()->delete();
                                }
                            }

                            $data = $response->json();
                            if (isset($response['data']['flightOffers'][0]['price'])) {
                                $nego = $response['data']['flightOffers'][0]['price']['total'] + (count($response['data']['flightOffers'][0]['travelerPricings']) * 8);
                            }

                            $pnr_ts = null;
                            if (isset($response['data']['associatedRecords'])) {
                                foreach ($response['data']['associatedRecords'] as $data) {
                                    if ($data['originSystemCode'] != 'GDS' && $data['reference'] != $booking->pnr) {
                                        $pnr_ts = $data['reference'];
                                    }
                                }
                            }
                            if (isset($nego)) {
                                $booking->nego = $nego;
                            }
                            $booking->pnr_ts = $pnr_ts;
                            $booking->save();

                            if (Carbon::parse(json_decode($booking->routes)->itineraries[0]->segments[0]->departure->at)->format('Y-m-d H:i:s') !== Carbon::parse($response['data']['flightOffers'][0]['itineraries'][0]['segments'][0]['departure']['at'])->format('Y-m-d H:i:s')) {
                                $newBooking = $booking->replicate();
                                $newBooking->routes = json_encode($response['data']['flightOffers'][0]);
                                $newBooking->last_ticketing_date = Carbon::parse($response['data']['flightOffers'][0]['itineraries'][0]['segments'][0]['departure']['at'])->format('Y-m-d H:i:s');
                                $newBooking->date_status = 'updated';
                                $newBooking->save();

                                Mail::to($booking->email)->send(new DepartureTimeChange($newBooking));
                                $passengers = Passenger::where('booking_id', $booking->id)->get();
                                foreach ($passengers as $data) {
                                    $passenger = $data->replicate();
                                    $passenger->booking_id = $newBooking->id;
                                    $passenger->save();
                                }
                            } else {

                                $booking->routes = json_encode($response['data']['flightOffers'][0]);
                                $booking->save();
                            }
                        }
                    }
                }
                if ($booking->trip_type == 'return') {
                    $departureDate = Carbon::parse($routes->itineraries[0]->segments[0]->arrival->at)->diffInHours(now());
                    if ($departureDate > 0 && $departureDate < 120 && Carbon::parse($routes->itineraries[0]->segments[0]->arrival->at) < now()) {
                        if ($booking->pnr_track_id != "") {
                            $orderId = $booking->pnr_track_id;
                            if (option('enterprise_api')) {
                                if (option('live_api')) {
                                    $ApiUrl = 'https://travel.api.amadeus.com';
                                } else {
                                    $ApiUrl = 'https://test.travel.api.amadeus.com';
                                }
                            } else {
                                if (option('live_api')) {
                                    $ApiUrl = 'https://api.amadeus.com';
                                } else {
                                    $ApiUrl = 'https://test.api.amadeus.com';
                                }
                            }
                            $url = $ApiUrl . "/v1/booking/flight-orders/{$orderId}";
                            $accessToken = getApi();
                            $headers = [
                                'Authorization' => 'Bearer ' . $accessToken,
                                'Content-Type' => 'application/json'
                            ];
                            $response = Http::withHeaders($headers)->get($url);
                            if (isset($response['data'])) {
                                if (Carbon::parse(json_decode($booking->routes)->itineraries[0]->segments[0]->arrival->at)->format('Y-m-d H:i:s') !== Carbon::parse($response['data']['flightOffers'][0]['itineraries'][0]['segments'][0]['arrival']['at'])->format('Y-m-d H:i:s')) {
                                    $newBooking = $booking->replicate();
                                    $newBooking->routes = json_encode($response['data']['flightOffers'][0]);
                                    $newBooking->last_ticketing_date = Carbon::parse($response['data']['flightOffers'][0]['itineraries'][0]['segments'][0]['departure']['at'])->format('Y-m-d H:i:s');
                                    $newBooking->date_status = 'updated';
                                    $newBooking->save();

                                    Mail::to($booking->email)->send(new DepartureTimeChange($newBooking));
                                    $passengers = Passenger::where('booking_id', $booking->id)->get();
                                    foreach ($passengers as $data) {
                                        $passenger = $data->replicate();
                                        $passenger->booking_id = $newBooking->id;
                                        $passenger->save();
                                    }
                                } else {
                                    $booking->routes = json_encode($response['data']['flightOffers'][0]);
                                    $booking->save();
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
