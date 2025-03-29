<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'super-admin', 'description' => 'Acceso total al sistema']);
        Role::create(['name' => 'admin', 'description' => 'Administrador general']);
        Role::create(['name' => 'cashier', 'description' => 'Cajero/POS']);
        Role::create(['name' => 'inventory-manager', 'description' => 'Gestión de productos']);
        Role::create(['name' => 'customer', 'description' => 'Cliente del ecommerce']);
    }
}