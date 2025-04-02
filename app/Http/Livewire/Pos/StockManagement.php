<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Inventory;
use App\Models\Warehouse;

class StockManagement extends Component
{
    public $productId;
    public $warehouseId;
    public $quantity = 1;
    public $movementType = 'in';
    public $notes;
    public $currentStock;

    protected $rules = [
        'productId' => 'required|exists:products,id',
        'warehouseId' => 'required|exists:warehouses,id',
        'quantity' => 'required|integer|min:1',
        'movementType' => 'required|in:in,out,adjustment',
        'notes' => 'nullable|string|max:500'
    ];

    public function updatedProductId()
    {
        $this->updateCurrentStock();
    }

    public function updatedWarehouseId()
    {
        $this->updateCurrentStock();
    }

    public function updateCurrentStock()
    {
        if ($this->productId && $this->warehouseId) {
            $inventory = Inventory::where('product_id', $this->productId)
                                ->where('warehouse_id', $this->warehouseId)
                                ->first();
            $this->currentStock = $inventory ? $inventory->quantity : 0;
        }
    }

    public function submit()
    {
        $this->validate();

        $inventory = Inventory::firstOrCreate([
            'product_id' => $this->productId,
            'warehouse_id' => $this->warehouseId
        ], ['quantity' => 0, 'min_stock' => 5]);

        $inventory->updateStock(
            $this->quantity,
            $this->movementType,
            ['notes' => $this->notes]
        );

        $this->reset(['quantity', 'notes']);
        $this->updateCurrentStock();
        $this->dispatch('showNotification', type: 'success', message: 'Movimiento registrado correctamente');
    }

    public function render()
    {
        return view('livewire.stock-management', [
            'products' => \App\Models\Product::active()->get(),
            'warehouses' => Warehouse::active()->get(),
            'movementTypes' => [
                'in' => 'Entrada de Stock',
                'out' => 'Salida de Stock',
                'adjustment' => 'Ajuste de Inventario'
            ]
        ]);
    }
}