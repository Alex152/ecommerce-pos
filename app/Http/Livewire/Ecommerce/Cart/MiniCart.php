<?php

namespace App\Http\Livewire\Ecommerce\Cart;

use Livewire\Component;
use Cart;

class MiniCart extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];
/*
    public function removeItem($itemId)
    {
        Cart::remove($itemId);
        $this->emit('cartUpdated');
        $this->dispatchBrowserEvent('notify', ['message' => 'Producto removido']);
    }

    public function updateQuantity($itemId, $quantity)
    {
        Cart::update($itemId, [
            'quantity' => [
                'relative' => false,
                'value' => $quantity
            ]
        ]);
        $this->emit('cartUpdated');
    }
*/
    public function updateCart()
    {
        // Forzar actualización
        $this->render();
    }

    public function removeItem($rowId)
    {
        Cart::remove($rowId);
        $this->emit('cartUpdated');
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Producto removido'
        ]);
    }

    public function updateQuantity($rowId, $quantity)
    {
        Cart::update($rowId, $quantity); // Forma simplificada
        $this->emit('cartUpdated');
    }
    public function render()
    {
        return view('livewire.ecommerce.cart.mini-cart', [
            'cartItems' => Cart::instance('default')->content(),
          //  'isEmpty' => Cart::instance('default')->count() == 0,
            'subtotal' => Cart::instance('default')->subtotal()
        ]);
    }
}