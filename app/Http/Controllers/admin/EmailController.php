<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index()
    {
        return view('admin.email.index');
    }
    public function send(Request $request)
    {
        $bookings = Booking::where('ticket_status', 'issued')->groupBy('email')->get();
         foreach ($bookings as $booking) {
             if (isset($booking->email)) {
                Mail::to('uxmanhafeez4@gmail.com')->send(new CustomMail($booking, $request->content, $request->subject));
             }
         }
        return redirect()->back()->with('success', 'Email Sent Successfully');
    }
}
