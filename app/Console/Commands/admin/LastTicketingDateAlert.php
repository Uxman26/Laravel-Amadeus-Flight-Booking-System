<?php

namespace App\Console\Commands\admin;

use App\Mail\LastTicketingDateNotification;
use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class LastTicketingDateAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:admin-last-ticketing-alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all the booking which are going to expired, Last Ticketing Date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bookings = Booking::whereDate('last_ticketing_date', '>=', now())->whereIn('ticket_status', ['Booked', 'Pending'])->get();
        $pnrs = [];
        foreach ($bookings as $booking) {
            // checking if this ticket will expired after 1 or 2 hour.
            if (now()->parse($booking->last_ticketing_date)->diffInHours() < 3) {
                $pnrs[] = [
                    'pnr' => $booking->pnr,
                    'name' => $booking->passengers[0]->firstname . ' ' . $booking->passengers[0]->lastname,
                    'time' => $booking->last_ticketing_date,
                ];
            }
        }
        if (!empty($pnrs)) {
            Mail::to(option('admin_email'))->send(new LastTicketingDateNotification($pnrs));
        }
    }
}
