<?php

namespace App\Http\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 12;
    public $categoryId = null;

    protected $queryString = ['search', 'categoryId'];

    public function render()
    {
        $products = Product::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->categoryId, fn($q) => $q->where('category_id', $this->categoryId))
            ->active()
            ->paginate($this->perPage);

        return view('livewire.ecommerce.product-list', [
            'products' => $products
        ]);
    }
}