<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tax extends Model
{
    protected $fillable = [
        'name',
        'rate',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rate' => 'decimal:2',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

        public function orderItems(): BelongsToMany
    {
        //return $this->belongsToMany(OrderItem::class)->withPivot('amount');
        return $this->belongsToMany(OrderItem::class, 'order_item_tax')->withPivot('amount');
    }
}