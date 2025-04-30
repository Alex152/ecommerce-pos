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
    use Illuminate\Database\Eloquent\Relations\MorphTo;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    
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
            'customer_id', 
            'payable_id',
            'payable_type',
            'amount',
            'payment_method',
            'payment_date',
            'transaction_id',
            'status',
            'is_approved',
            'notes'
        ];
    
        protected $casts = [
            'amount' => 'decimal:2',
            'payment_date' => 'date',
            'is_approved' => 'boolean'
        ];

        protected $attributes = [
            'status' => 'pending',
            'is_approved' => false,
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

        //Añadido para ver payments directos y hechos por el cliente en CustomerResource/Historial De Pagos
        /*  Ya no esto es antes de usar customer_id en la tabla payments
        public function order()
        {
            return $this->belongsTo(Order::class, 'payable_id')->where('payable_type', Order::class);
        }

        public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'payable_id')
            ->where('payable_type', Customer::class);
    }

    // Scopes
    public function scopeForCustomer(Builder $query, $customerId): Builder
    {
        return $query->where(function($q) use ($customerId) {
            $q->where([
                'payable_type' => Customer::class,
                'payable_id' => $customerId
            ])->orWhereHas('order', function($q) use ($customerId) {
                $q->where('customer_id', $customerId);
            });
        });
    }*/


    // En el modelo Payment
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // En el creating/updating del modelo
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($payment) {
            // Auto-asignar customer_id basado en la relación
            if (empty($payment->customer_id)) {
                if ($payment->payable_type === Order::class) {
                    $payment->customer_id = $payment->payable->customer_id;
                } elseif ($payment->payable_type === Customer::class) {
                    $payment->customer_id = $payment->payable_id;
                }
            }
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'payable_id');
            //->where('payable_type', Order::class);   //Esta mal porque Order no tiene campo payable_type
    }

    //Añadido para ver orden asociado a PaymentsRelationManager del CustomResource
    public function getOrderAttribute()
    {
        if ($this->payable_type === Order::class) {
            return $this->payable;
        }
        return null;
    }
    /////////////////////////////////////////////////////////////////
    }