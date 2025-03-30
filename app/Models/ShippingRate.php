<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = [
        'shipping_carrier_id',
        'name',
        'rate',
        'min_order_amount',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
    ];
}