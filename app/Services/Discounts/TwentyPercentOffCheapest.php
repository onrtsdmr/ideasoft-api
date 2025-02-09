<?php

namespace App\Services\Discounts;

use App\Models\Order;

class TwentyPercentOffCheapest implements DiscountRule
{
    public function applyDiscount(Order $order): ?array
    {
        $category1Items = $order->products->where('category_id', 1);
        if ($category1Items->count() >= 2) {
            $cheapestItem = $category1Items->min('unitPrice');
            $discountAmount = $cheapestItem * 0.20;
            return [
                'discountReason' => '20_PERCENT_OFF_CHEAPEST',
                'discountAmount' => number_format($discountAmount, 2),
                'subtotal' => number_format($order->total, 2)
            ];
        }
        return null;
    }
}