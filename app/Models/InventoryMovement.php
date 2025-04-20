<?php
/*
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'type',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
    */




namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $fillable = [
        'inventory_id',
        'product_id',
        'warehouse_id',
        'user_id',
        'quantity',
        'type',
        'current_stock',
        'reference_type',
        'reference_id',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'current_stock' => 'integer'
    ];

    // Relaciones
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }

        // En app/Models/InventoryMovement.php

    protected static function booted()
    {
        static::creating(function ($movement) {
            if (!$movement->product_id && $movement->inventory) {
                $movement->product_id = $movement->inventory->product_id;
            }
            if (!$movement->warehouse_id && $movement->inventory) {
                $movement->warehouse_id = $movement->inventory->warehouse_id;
            }
            if (!$movement->user_id) {
                $movement->user_id = auth()->id();
            }
        });
    }
}