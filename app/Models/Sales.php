<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cashier_id',
        'customer_id',
        'invoice_number',
        'total_amount',    // USD
        'tax_amount',      // USD
        'discount_amount', // USD
        'payment_method',  // cash, card, transfer
        'payment_status',  // paid, pending, cancelled
        'status',         // completed, refunded, partially_refunded
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    // Relaciones
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Métodos
    public function calculateTotal(): float
    {
        return $this->items->sum('subtotal');
    }
}