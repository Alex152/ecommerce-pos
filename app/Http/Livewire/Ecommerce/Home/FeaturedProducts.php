<?php

namespace App\Http\Livewire\Ecommerce\Home;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class FeaturedProducts extends Component
{
    use WithPagination;

    public $perPage = 8;

    public function loadMore()
    {
        $this->perPage += 4;
    }

    public function render()
    {
        $products = Product::with(['media', 'variants'])
            ->where('is_featured', true)
            ->where('is_active', true)
            ->take($this->perPage)
            ->get();

        return view('livewire.ecommerce.home.featured-products', [
            'products' => $products
        ]);
    }
}