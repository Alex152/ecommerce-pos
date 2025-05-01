<?php

namespace App\Http\Livewire\Ecommerce\Shop;

use Livewire\Component;
use App\Models\Product;
use Cart;

class ProductCard extends Component
{
    public $product;
    public $showQuickView = false;
    public $selectedVariant = null;

    public function mount($product)
    {
        $this->product = $product;
        if ($this->product->variants->isNotEmpty()) {
            $this->selectedVariant = $this->product->variants->first()->id;
        }
    }

    public function addToCart()
    {
        $item = [
            'id' => $this->selectedVariant ? 'variant_'.$this->selectedVariant : 'product_'.$this->product->id,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'quantity' => 1,
            'associatedModel' => $this->product
        ];

        Cart::add($item);
        $this->emit('cartUpdated');
        $this->dispatchBrowserEvent('notify', ['message' => 'Producto añadido al carrito']);
    }

    public function render()
    {
        return view('livewire.ecommerce.shop.product-card');
    }
}