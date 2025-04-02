<?php
/*
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payable_id',
        'payable_type',
        'amount',       // USD
        'payment_method', // cash, card, transfer, etc.
        'transaction_id',
        'status',       // completed, pending, failed, refunded
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    // Relación polimórfica (pagos para Sales u Orders)
    public function payable()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
    */



    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Builder;
    
    class Payment extends Model
    {
        /* Old
        protected $fillable = [
            'payable_id',
            'payable_type',
            'amount',
            'payment_method',
            'transaction_id',
            'status',
            'notes',
            'completed_at'
        ];
    
        protected $casts = [
            'amount' => 'decimal:2',
            'completed_at' => 'datetime'
        ];
    
        // Relación polimórfica
        public function payable()
        {
            return $this->morphTo();
        }
        
        */


        protected $fillable = [
            'payable_id',
            'payable_type',
            'amount',
            'payment_method',
            'payment_date',
            'transaction_id',
            'status',
            'notes'
        ];
    
        protected $casts = [
            'amount' => 'decimal:2',
            'payment_date' => 'date'
        ];
    
        public function payable(): MorphTo
        {
            return $this->morphTo();
        }
    
        // Método para identificar si es pago de cliente
        public function isCustomerPayment(): bool
        {
            return $this->payable_type === Customer::class;
        }
        // Scopes
        public function scopeCompleted(Builder $query): Builder
        {
            return $query->where('status', 'completed');
        }
    
        public function scopePending(Builder $query): Builder
        {
            return $query->where('status', 'pending');
        }
    
        public function scopeForOrder(Builder $query, $orderId): Builder
        {
            return $query->where('payable_type', Order::class)
                        ->where('payable_id', $orderId);
        }
    }