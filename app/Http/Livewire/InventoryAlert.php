<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class InventoryAlert extends Component
{
    public $threshold = 5;

    public function getLowStockProductsProperty()
    {
        return Product::where('stock_quantity', '<=', $this->threshold)
            ->orderBy('stock_quantity')
            ->get();
    }

    public function render()
    {
        return view('livewire.inventory-alert');
    }
}