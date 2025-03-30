<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingCarrier extends Model
{
    protected $fillable = [
        'name',
        'tracking_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function shippingRates(): HasMany
    {
        return $this->hasMany(ShippingRate::class);
    }
}