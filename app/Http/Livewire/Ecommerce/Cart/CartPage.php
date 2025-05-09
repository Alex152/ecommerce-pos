<?php

namespace App\Http\Livewire\Ecommerce\Cart;

use Livewire\Component;
use Cart;

class CartPage extends Component
{
    public $cartItems= []; 
    public $subtotal = 0;
    public $total = 0;
    public $isEmpty = true;

    protected $listeners = ['cartUpdated' => 'updateCart'];

    public function mount()
    {
        $this->updateCart();
    }

    public function updateCart()
    {
        /*
        $this->cartItems = Cart::content()->sortBy('id');
        $this->subtotal = Cart::subtotal();
        $this->total = Cart::total();*/

        $this->cartItems = Cart::content()->map(function ($item) {
            return [
                'id' => $item->rowId,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->qty,
                'attributes' => $item->options,
                'associatedModel' => [
                    'slug' => $item->model?->slug ?? '#',
                    'media' => [
                        [
                            //'original_url' => $item->model?->getFirstMediaUrl('default') ?? asset('images/placeholder-product.png')
                            'original_url' => $item->model?->main_image_url ?? asset('images/placeholder-product.png')

                        ]
                    ]
                ]
            ];
        })->values()->toArray();
        
        $this->subtotal = (float) str_replace(',', '', Cart::subtotal());
        $this->total = (float) str_replace(',', '', Cart::total());
        $this->isEmpty = Cart::count() == 0;
    }

    public function removeItem($id)
    {
        Cart::remove($id);
        $this->dispatch('cartUpdated');
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Producto removido'
        ]);
    }

    /* Complica innecesariamente
    public function getCartItemsProperty()
    {
        return $this->cartItems;
    }*/
    
    public function updateQuantity($id, $quantity)
    {
        Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $quantity
            ]
        ]);
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.ecommerce.cart.cart-page')  // Ya no se manda los datos por aqui
            ->layout('layouts.ecommerce', [
                'title' => 'Carrito de compras',
                'description' => 'Revisa tus productos antes de pagar'
            ]);
    }
}