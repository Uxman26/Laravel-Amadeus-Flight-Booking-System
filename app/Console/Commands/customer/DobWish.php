<?php

namespace App\Console\Commands\customer;

use App\Mail\WishDateOfBirthNotification;
use App\Models\Passenger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DobWish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:customer-dob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Happy birthday Email to Customers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $passengers = Passenger::all();
        foreach ($passengers as $passenger) {
            $dobDate = now()->parse($passenger->dob);
            $dobDay = now()->parse($passenger->dob)->format('d');
            $dobMonth = now()->parse($passenger->dob)->format('m');
            // today
            $todayDay = now()->format('d');
            $todayMonth = now()->format('m');
            if ($dobDay == $todayDay && $dobMonth == $todayMonth) {
                Mail::to($passenger->booking->email)->send(new WishDateOfBirthNotification($passenger));
            }
        }
    }
}
