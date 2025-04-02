<?php

namespace App\Models;

/*
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
    */





use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'tax_id',
        'type',
        'notes',
        'credit_limit',
        'balance',
        'is_active',

        //nuevo
        'loyalty_points',
        'birthdate',
        'preferred_payment_method'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'credit_limit' => 'decimal:2',
        'balance' => 'decimal:2',

        //Nuevo
        'birthdate' => 'date',
        'loyalty_points' => 'integer'
    ];

      // Relaciones
      public function orders(): HasMany
      {
          return $this->hasMany(Order::class);
      }
  
      public function sales(): HasMany
      {
          return $this->hasMany(Sale::class);
      }
  
      public function addresses(): HasMany
      {
          return $this->hasMany(CustomerAddress::class);
      }
  
      public function payments(): MorphMany
      {
          return $this->morphMany(Payment::class, 'payable');
      }
  
      // Scopes
      public function scopeActive($query)
      {
          return $query->where('is_active', true);
      }
  
      public function scopeWithCredit($query)
      {
          return $query->where('credit_limit', '>', 0);
      }
  
      // Métodos
      public function canPurchaseOnCredit($amount): bool
      {
          return $this->credit_limit > 0 && 
                 ($this->credit_limit - $this->balance) >= $amount;
      }
  
      public function updateBalance($amount): void
      {
          $this->balance += $amount;
          $this->save();
      }
}