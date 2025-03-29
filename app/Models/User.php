<?php

namespace App\Models;

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