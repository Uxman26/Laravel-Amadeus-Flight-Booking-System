<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'single_room_price',
        'double_room_price',
        'triple_room_price',
        'quadruple_room_price',
        'children_price_deduction',
        'infant_price',
        'mecca_hotel',
        'madina_hotel',
        'departure',
        'return',
        'description',
    ];
}
