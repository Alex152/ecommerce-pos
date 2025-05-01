<?php

namespace App\Http\Livewire\Ecommerce\Cart;

use Livewire\Component;
use Cart;

class CartPage extends Component
{
    public $cartItems = [];
    public $subtotal;
    public $total;

    protected $listeners = ['cartUpdated' => 'updateCart'];

    public function mount()
    {
        $this->updateCart();
    }

    public function updateCart()
    {
        $this->cartItems = Cart::getContent()->sortBy('id');
        $this->subtotal = Cart::getSubTotal();
        $this->total = Cart::getTotal();
    }

    public function removeItem($id)
    {
        Cart::remove($id);
        $this->emit('cartUpdated');
    }

    public function updateQuantity($id, $quantity)
    {
        Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $quantity
            ]
        ]);
        $this->emit('cartUpdated');
    }

    public function render()
    {
        return view('livewire.ecommerce.cart.cart-page')
            ->layout('layouts.ecommerce', [
                'title' => 'Carrito de compras',
                'description' => 'Revisa tus productos antes de pagar'
            ]);
    }
}