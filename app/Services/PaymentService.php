<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Str;

class PaymentService
{
    public function processPayment(
        float $amount,
        string $method,
        object $payable
    ): Payment {
        return Payment::create([
            'payable_id' => $payable->id,
            'payable_type' => get_class($payable),
            'amount' => $amount,
            'payment_method' => $method,
            'transaction_id' => Str::uuid(),
            'status' => 'completed',
        ]);
    }

    public function refundPayment(Payment $payment, float $amount = null): Payment
    {
        $refundAmount = $amount ?? $payment->amount;

        $payment->update([
            'status' => 'refunded',
            'amount' => $payment->amount - $refundAmount,
        ]);

        return $payment->refresh();
    }
}