<?php

namespace App\Http\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\Order;
use App\Models\Customer;

class CheckoutProcess extends Component
{
    public $cart;
    public $customer = [
        'name' => '',
        'email' => '',
        'address' => ''
    ];

    public function mount($cart)
    {
        $this->cart = $cart;
    }

    public function placeOrder()
    {
        $customer = Customer::firstOrCreate(
            ['email' => $this->customer['email']],
            $this->customer
        );

        $order = Order::create([
            'customer_id' => $customer->id,
            'total_amount' => $this->cart['total'],
            'status' => 'pending'
        ]);

        // Redirigir a confirmación
        return redirect()->route('order.confirmation', $order->id);
    }

    public function render()
    {
        return view('livewire.ecommerce.checkout-process');
    }
}