<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price', // USD
        'discount',
        'tax_amount',
        'subtotal',   // USD (calculado: quantity * unit_price - discount + tax)
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relaciones
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Eventos del modelo
    protected static function booted()
    {
        static::creating(function ($item) {
            $item->subtotal = ($item->quantity * $item->unit_price) - $item->discount + $item->tax_amount;
        });

        static::updating(function ($item) {
            $item->subtotal = ($item->quantity * $item->unit_price) - $item->discount + $item->tax_amount;
        });
    }
}