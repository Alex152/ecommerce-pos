<?php

namespace App\Models;

/*
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'barcode',
        'pos_pin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'pos_pin',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    protected $appends = ['profile_photo_url'];

    // Relaciones
    public function sales()
    {
        return $this->hasMany(\App\Models\Sale::class, 'cashier_id');
    }

    // Métodos
    public function hasAccessToPos(): bool
    {
        return $this->hasAnyRole(['super-admin', 'cashier']);
    }
}
    */


namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; // Asegúrate de tener instalado spatie/laravel-permission

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        //'phone',
        //'address',
        //'city',
        //'state',
        //'zip_code',
        //'country',
        'role',
        'is_active',
        'pos_pin',
        'barcode',
        'two_factor_secret',
        'two_factor_recovery_codes',
        // Agrega aquí cualquier otro campo específico de tu repositorio
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'pos_pin', // Oculto por seguridad
        'two_factor_secret',
        'two_factor_recovery_codes'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    #########################################
    ### RELACIONES ORIGINALES DEl REPO ###
    #########################################

    // Relación con ventas (POS)
    public function sales()
    {
        return $this->hasMany(\App\Models\Sale::class, 'cashier_id');
    }

    // Relación con órdenes (eCommerce)
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'user_id');
    }

    // Relación con sesiones de POS
    public function posSessions()
    {
        return $this->hasMany(\App\Models\PosSession::class, 'cashier_id');
    }

    #######################################
    ### MÉTODOS ORIGINALES DE  REPO ###
    #######################################

    public function hasAccessToPos(): bool
    {
        return $this->hasAnyRole(['super-admin', 'cashier', 'admin']);
    }

    public function canManageProducts(): bool
    {
        return $this->hasAnyRole(['super-admin', 'manager']);
    }

    #######################################
    ### MEJORAS Y MÉTODOS ADICIONALES ###
    #######################################

    // Verificación segura de PIN
    public function verifyPosPin(string $pin): bool
    {
        return hash_equals($this->pos_pin ?? '', $pin);
    }

    // Generación automática de barcode
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->barcode)) {
                $user->barcode = 'EMP' . now()->format('ymd') . str_pad(
                    (int) self::count(),//withTrashed()->count() + 1,    // Con soft delete
                    4, '0', STR_PAD_LEFT
                );
            }
        });
    }

    // Método para dashboard
    public function getTodaySalesAttribute()
    {
        return $this->sales()->whereDate('created_at', today())->sum('total');
    }
}