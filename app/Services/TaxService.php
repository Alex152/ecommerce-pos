<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Tax;

class TaxService
{
    public function calculateTax(Product $product, float $subtotal): float
    {
        $taxRate = $product->taxes->sum('rate') / 100;
        return round($subtotal * $taxRate, 2);
    }

    public function getApplicableTaxes(Product $product): array
    {
        return $product->taxes->map(fn($tax) => [
            'name' => $tax->name,
            'rate' => $tax->rate,
        ])->toArray();
    }
}