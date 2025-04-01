<?php

namespace App\Services;

use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Warehouse;

class InventoryService
{
    public function recordMovement(
        Product $product,
        Warehouse $warehouse,
        int $quantity,
        string $type
    ): InventoryMovement {
        // Actualizar stock principal
        $product->update([
            'stock_quantity' => $type === 'in' 
                ? $product->stock_quantity + $quantity
                : $product->stock_quantity - $quantity
        ]);

        // Registrar movimiento
        return InventoryMovement::create([
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity' => $type === 'in' ? $quantity : -$quantity,
            'type' => $type,
        ]);
    }

    public function getStockAlertThreshold(): int
    {
        return config('inventory.low_stock_threshold', 5);
    }
}