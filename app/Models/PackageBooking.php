<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageBooking extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'address',
        'rooms',
        'childrens',
        'adults',
        'infants',
        'price',
        'received',
        'remaining',
        'payment_method',
        'status',
        'invoice_no',
        'remarks',
        'nationality',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
