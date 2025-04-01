<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /* Seeder incompleto y concampo description equivocado (description no exite )
    public function run()
    {
        Role::create(['name' => 'super-admin', 'description' => 'Acceso total al sistema']);
        Role::create(['name' => 'admin', 'description' => 'Administrador general']);
        Role::create(['name' => 'cashier', 'description' => 'Cajero/POS']);
        Role::create(['name' => 'inventory-manager', 'description' => 'Gestión de productos']);
        Role::create(['name' => 'customer', 'description' => 'Cliente del ecommerce']);
    }

    */


    /* Recordatorio de campos Role generado por Spatie

    = [
    "id",
    "name",
    "guard_name",
    "created_at",
    "updated_at",
  ]
    */

    public function run()
    {
        // Crear roles sin la columna 'description'
        Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'cashier', 'guard_name' => 'web']);
        Role::create(['name' => 'inventory-manager', 'guard_name' => 'web']);
        Role::create(['name' => 'customer', 'guard_name' => 'web']);
    }
}