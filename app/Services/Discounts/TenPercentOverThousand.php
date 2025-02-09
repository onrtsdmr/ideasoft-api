<?php

namespace App\Services\Discounts;

use App\Models\Order;

class TenPercentOverThousand implements DiscountRule
{
    public function applyDiscount(Order $order): ?array
    {
        if ($order->total >= 1000) {
            $discountAmount = $order->total * 0.10;
            return [
                'discountReason' => '10_PERCENT_OVER_1000',
                'discountAmount' => number_format($discountAmount, 2),
                'subtotal' => number_format($order->total, 2)
            ];
        }
        return null;
    }
}