<?php

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