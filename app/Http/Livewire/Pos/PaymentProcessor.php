<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;

class PaymentProcessor extends Component
{
    public $paymentMethods = ['cash', 'card', 'transfer'];
    public $selectedMethod = 'cash';
    public $amountReceived = 0;
    public $change = 0;

    public function calculateChange($total)
    {
        $this->change = max(0, $this->amountReceived - $total);
    }

    public function render()
    {
        return view('livewire.pos.payment-processor');
    }
}