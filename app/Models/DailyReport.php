<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone_number',
        'flexible_date',
        'preffered_airline',
        'trip_type',
        'flight_type',
        'origin1',
        'destination1',
        'departureDate1',
        'returnDate1',
        'origin2',
        'destination2',
        'departureDate2',
        'origin3',
        'destination3',
        'departureDate3',
        'origin4',
        'destination4',
        'departureDate4',
        'adults',
        'children',
        'infants',
        'remark',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
