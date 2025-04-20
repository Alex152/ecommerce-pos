<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sale extends Model
{
    use HasFactory;

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

    //Para que se borren lo pagos asociados
    public function payments()
    {
        return $this->morphMany(\App\Models\Payment::class, 'payable');
    }


    // Métodos
    public function calculateTotal(): float
    {
        return $this->items->sum('subtotal');
    }

    protected static function boot()
{
    parent::boot();

    // Eliminar pagos asociados antes de eliminar la venta
    static::deleting(function ($sale) {
        $sale->payments()->delete(); // Elimina los pagos relacionados con la venta
    });
}


}