<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'type',
        'etkt',
        'title',
        'gender',
        'firstname',
        'lastname',
        'nationality',
        'dob',
        'passport',
        'passport_expiry',
    ];


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
