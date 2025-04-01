<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Recursos de Productos
        Permission::create(['name' => 'view-products']);
        Permission::create(['name' => 'create-products']);
        Permission::create(['name' => 'edit-products']);
        Permission::create(['name' => 'delete-products']);

        // Recursos de Ventas
        Permission::create(['name' => 'view-sales']);
        Permission::create(['name' => 'create-sales']);
        Permission::create(['name' => 'edit-sales']);
        Permission::create(['name' => 'delete-sales']);

        // Recursos de Clientes
        Permission::create(['name' => 'view-customers']);
        Permission::create(['name' => 'create-customers']);
        Permission::create(['name' => 'edit-customers']);
        Permission::create(['name' => 'delete-customers']);

        // Recursos de Pedidos
        Permission::create(['name' => 'view-orders']);
        Permission::create(['name' => 'create-orders']);
        Permission::create(['name' => 'edit-orders']);
        Permission::create(['name' => 'delete-orders']);

        // Recursos de Categorías
        Permission::create(['name' => 'view-categories']);
        Permission::create(['name' => 'create-categories']);
        Permission::create(['name' => 'edit-categories']);
        Permission::create(['name' => 'delete-categories']);

        // Recursos de Inventario
        Permission::create(['name' => 'view-inventories']);
        Permission::create(['name' => 'create-inventories']);
        Permission::create(['name' => 'edit-inventories']);
        Permission::create(['name' => 'delete-inventories']);

        // Recursos de Configuración del Sistema
        Permission::create(['name' => 'view-system-settings']);
        Permission::create(['name' => 'edit-system-settings']);

        // Recursos de Descuentos
        Permission::create(['name' => 'view-discounts']);
        Permission::create(['name' => 'create-discounts']);
        Permission::create(['name' => 'edit-discounts']);
        Permission::create(['name' => 'delete-discounts']);

        // Recursos de Impuestos
        Permission::create(['name' => 'view-taxes']);
        Permission::create(['name' => 'create-taxes']);
        Permission::create(['name' => 'edit-taxes']);
        Permission::create(['name' => 'delete-taxes']);

        // Recursos de Transportistas
        Permission::create(['name' => 'view-shipping-carriers']);
        Permission::create(['name' => 'create-shipping-carriers']);
        Permission::create(['name' => 'edit-shipping-carriers']);
        Permission::create(['name' => 'delete-shipping-carriers']);

        // Recursos de Usuarios
        Permission::create(['name' => 'view-users']);
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        // Recursos de Informes
        Permission::create(['name' => 'view-reports']);

        // Recursos de Roles
        Permission::create(['name' => 'view-roles']);
        Permission::create(['name' => 'create-roles']);
        Permission::create(['name' => 'edit-roles']);
        Permission::create(['name' => 'delete-roles']);

        // Recursos de Permisos
        Permission::create(['name' => 'view-permissions']);
        Permission::create(['name' => 'create-permissions']);
        Permission::create(['name' => 'edit-permissions']);
        Permission::create(['name' => 'delete-permissions']);

        // Recursos de Movimientos de Inventario
        Permission::create(['name' => 'view-inventory-movements']);
        Permission::create(['name' => 'create-inventory-movements']);
        Permission::create(['name' => 'edit-inventory-movements']);
        Permission::create(['name' => 'delete-inventory-movements']);

        // Recursos de Almacén
        Permission::create(['name' => 'view-warehouses']);
        Permission::create(['name' => 'create-warehouses']);
        Permission::create(['name' => 'edit-warehouses']);
        Permission::create(['name' => 'delete-warehouses']);
    }
}
