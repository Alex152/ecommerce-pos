<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Usa una contraseña segura en producción
            //'role' => 'admin',
            //'is_active' => true,
            'pos_pin' => '1234',
            'barcode' => 'ABC123456',
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ]);

        // Si usas Spatie Roles y Permisos
        $user->assignRole('admin');
    }
}
