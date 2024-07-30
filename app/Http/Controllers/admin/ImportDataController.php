<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Str;

class ImportDataController extends Controller
{
    public function booking(Request $request)
    {
        $rows = SimpleExcelReader::create($request->booking, 'csv')
            ->noHeaderRow()
            ->getRows()
            ->each(function (array $rowProperties) {
                // Create a new Booking model instance
                $booking = new Booking();
                $booking->user_id = $rowProperties[1];
                $booking->pnr = $rowProperties[2];
                $booking->trip_type = $rowProperties[3];
                $booking->status = $rowProperties[4];
                $booking->ticket_status = $rowProperties[5];
                $booking->email = $rowProperties[6];
                $booking->phone = $rowProperties[7];
                $booking->payment_method = $rowProperties[8];
                $booking->last_ticketing_date = $rowProperties[9];
                $booking->amount = $rowProperties[10];
                $booking->bags = $rowProperties[11];
                $booking->nego = $rowProperties[12];
                $booking->received = $rowProperties[13];
                $booking->agent_margin = $rowProperties[14];
                $booking->admin_buy_price = $rowProperties[15];
                $booking->issued_from = $rowProperties[16];
                $booking->remarks = $rowProperties[17];
                $booking->routes = $rowProperties[18];
                $booking->live_data = $rowProperties[19];
                $booking->pnr_track_id = $rowProperties[20];
                $booking->pnr_status = $rowProperties[21];
                $booking->uri = $rowProperties[22];
                $booking->track_price = $rowProperties[23];
                $booking->adults = $rowProperties[24];
                $booking->children = $rowProperties[25];
                $booking->infants = $rowProperties[26];
                $booking->save();
            });
        return back()->with('success', 'Import Completed Succesfully');
    }


    public function passenger(Request $request)
    {
        $rows = SimpleExcelReader::create($request->passenger, 'csv')
            ->noHeaderRow()
            ->getRows()
            ->each(function (array $rowProperties) {
                info($rowProperties);
                // Create a new Booking model instance
                $passenger = new Passenger();
                $passenger->booking_id = $rowProperties[1];
                $passenger->type = $rowProperties[2];
                $passenger->etkt = $rowProperties[3];
                $passenger->title = $rowProperties[4];
                $passenger->gender = $rowProperties[5];
                $passenger->firstname = $rowProperties[6];
                $passenger->lastname = $rowProperties[7];
                $passenger->nationality = $rowProperties[8];
                $passenger->dob = $rowProperties[9];
                $passenger->passport = $rowProperties[10];
                $passenger->passport_expiry = $rowProperties[11];
                $passenger->save();
            });
        return back()->with('success', 'Import Completed Succesfully');
    }


    public function transactions(Request $request)
    {
        $rows = SimpleExcelReader::create($request->transaction, 'csv')
            ->noHeaderRow()
            ->getRows()
            ->each(function (array $rowProperties) {
                info($rowProperties);
                // Create a new Booking model instance
                $transaction = new Transaction();
                $transaction->user_id = $rowProperties[1];
                $transaction->amount = $rowProperties[2];
                $transaction->iata = $rowProperties[3];
                $transaction->type = $rowProperties[4];
                $transaction->sum = $rowProperties[5];
                $transaction->description = $rowProperties[6];
                $transaction->pnr = $rowProperties[7];
                $transaction->save();
            });

        return back()->with('success', 'Import Completed Succesfully');
    }
}
