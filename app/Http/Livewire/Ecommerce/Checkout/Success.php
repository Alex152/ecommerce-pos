<?php

namespace App\Http\Livewire\Ecommerce\Checkout;

use Livewire\Component;
use App\Models\Order;

class Success extends Component
{
    public $order;

    public function mount(Order $order)
    {
        $this->order = $order->load('items.product');
    }

    public function render()
    {
        return view('livewire.ecommerce.checkout.success')
            ->layout('layouts.ecommerce', [
                'title' => 'Pedido completado - ' . $this->order->number,
                'hideCart' => true
            ]);
    }
}