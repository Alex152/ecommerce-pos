<?php

namespace App\Http\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\Product;

class CartManager extends Component
{
    public $cart = [];
    public $subtotal = 0;
    public $shipping = 5.00; // USD fijo por ahora

    protected $listeners = ['addToCart' => 'addProduct'];

    public function addProduct($productId)
    {
        $product = Product::findOrFail($productId);
        
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->images->first()->url ?? null
            ];
        }

        $this->calculateSubtotal();
    }

    public function calculateSubtotal()
    {
        $this->subtotal = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function render()
    {
        return view('livewire.ecommerce.cart-manager');
    }
}