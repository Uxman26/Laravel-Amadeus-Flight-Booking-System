<?php

namespace App\Console\Commands;

use App\Mail\PassportRenewalNotification;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PassportExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:passport-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Passport Expiry';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bookings = Booking::where('ticket_status', 'issued')->get();
        foreach ($bookings as $booking) {
            foreach ($booking->passengers as $passenger) {
                if ($passenger->passport_expiry > Carbon::now()->format('Y-m-d')) {

                    $firstname = $passenger->firstname;
                    $lastname = $passenger->lastname;

                    $month1 = Carbon::parse($passenger->passport_expiry);
                    $month2 = Carbon::now();

                    $diffInDays = $month1->diffInDays($month2);
                    if ($diffInDays == 180) {
                        Mail::to($booking->email)->send(new PassportRenewalNotification($firstname, $lastname));
                    } elseif ($diffInDays == 150) {
                        Mail::to($booking->email)->send(new PassportRenewalNotification($firstname, $lastname));
                    }
                }
            }
        }
    }
}
