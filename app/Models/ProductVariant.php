<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'barcode',
        'price',
        'cost_price',
        'stock_quantity',
        'options',
        'is_default',
        'is_active'
    ];

    protected $casts = [
        'options' => 'array',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }


    //Mejorado

    public function options()
    {
        return $this->hasMany(ProductVariantOption::class);
    }
    
    public function getPriceAttribute()
    {
        return $this->special_price ?? $this->base_price;
    }
}