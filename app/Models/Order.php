<?php
/*
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'order_number',
        'status', // pending, processing, completed, cancelled
        'total_amount', // USD
        'shipping_amount',
        'tax_amount',
        'discount_amount',
        'payment_method',
        'payment_status',
        'shipping_address',
        'billing_address',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    // Relaciones
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}

*/



namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'user_id',
        'order_type',
        'status',
        'subtotal',
        'tax',
        'discount',
        'shipping',
        'total',
        'notes',
        'customer_notes',
        'shipping_method',
        'payment_method',
        'billing_address',
        'shipping_address'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2'
    ];


     // Boot method to auto-generate order number   
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(uniqid()); // Ej: ORD-65F3A2B1
            $order->subtotal = 0; // Valor inicial, se actualizará al añadir items.
            $order->user_id = auth()->id(); // Asigna el usuario logueado
        });

        // Eliminar pagos asociados antes de eliminar la orden
        static::deleting(function ($order) {
            $order->payments()->delete(); // Elimina los pagos relacionados con la orden
        });
    }

    // Relaciones
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    //Relaciones añadidas por 3erC


    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }


    // Scopes
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function scopePos(Builder $query): Builder
    {
        return $query->where('order_type', 'pos');
    }

    public function scopeEcommerce(Builder $query): Builder
    {
        return $query->where('order_type', 'ecommerce');
    }

    public function recalculateTotals(): void
    {
        // Resetear y recargar relaciones
        $this->unsetRelation('items');
        $this->load(['items.tax']);
    
        $this->subtotal = $this->items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
    
        // Cálculo de taxes seguro
        $totalTax = $this->items->sum(function ($item) {
            if ($item->relationLoaded('tax') && $item->tax instanceof \Illuminate\Database\Eloquent\Collection) {
                return $item->tax->sum('pivot.amount');
            }
            return 0;
        });
    
        $this->total = max(0, 
            $this->subtotal 
            - $this->items->sum('discount') 
            + $totalTax
            + $this->shipping
        );
    
        $this->save();
    }

}