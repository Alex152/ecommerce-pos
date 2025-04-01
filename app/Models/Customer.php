<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'dni',
        'company_name',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'loyalty_points',
        'notes',
    ];

    protected $casts = [
        'loyalty_points' => 'integer',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Métodos
    public function getFullAddressAttribute(): string
    {
        return "{$this->address}, {$this->city}, {$this->country}";
    }

    // Momentania mente para manegar dinamicamente el customer label en Sales Resource
    public function getCustomerLabel(): string
    {
        $label = $this->dni;
        
        if (!empty($this->company_name)) {
            $label .= " - {$this->company_name}";
        } elseif ($this->user) {
            $label .= " - {$this->user->name}";
        }
        
        return $label;
    }
}