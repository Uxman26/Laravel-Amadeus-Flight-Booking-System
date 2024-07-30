<?php

namespace App\Console\Commands\customer;

use App\Mail\PaymentDueNotification as MailPaymentDueNotification;
use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PaymentDueNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:payment-due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Customer Payment Due Notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // checking if any user payment is pending
        info('checking if any user payment is pending');
        $bookings = Booking::get();
        foreach ($bookings as $booking) {
            if(isset($booking->email) && $booking->email != null){
            $amount = $booking->agent_margin - $booking->received;
            if ($amount > 0) {
                info('A Customer Found with Pending Payment, sending notification');
                Mail::to($booking->email)->send(new MailPaymentDueNotification($booking));
                info('Email Sent Successfully');
            }
        }
        }
    }
}
