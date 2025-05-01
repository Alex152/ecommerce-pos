<?php

namespace App\Http\Livewire\Ecommerce\Home;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class HomePage extends Component
{
    public $featuredProducts;
    public $categories;

    public function mount()
    {
        $this->featuredProducts = Product::where('is_featured', true)
            ->with('media')
            ->take(8)
            ->get();

        $this->categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();
    }

    public function render()
    {
        return view('livewire.ecommerce.home.home-page')
            ->layout('layouts.ecommerce', [
                'title' => 'Inicio',
                'description' => 'Bienvenido a nuestra tienda en línea'
            ]);
    }
}