<?php

namespace App\Services;

use App\Models\ShippingCarrier;
use App\Models\ShippingRate;
use Illuminate\Support\Collection;

class ShippingCalculator
{
    public function calculateCost(float $orderTotal, string $country): Collection
    {
        return ShippingCarrier::with('shippingRates')
            ->active()
            ->get()
            ->map(function ($carrier) use ($orderTotal, $country) {
                $rate = $carrier->shippingRates
                    ->where('min_order_amount', '<=', $orderTotal)
                    ->sortByDesc('min_order_amount')
                    ->first();

                return [
                    'carrier' => $carrier->name,
                    'cost' => $rate ? $rate->rate : 0,
                    'delivery_time' => $this->getDeliveryTime($country),
                ];
            });
    }

    protected function getDeliveryTime(string $country): string
    {
        $times = [
            'US' => '3-5 days',
            'CA' => '5-7 days',
            'default' => '7-14 days',
        ];

        return $times[$country] ?? $times['default'];
    }
}