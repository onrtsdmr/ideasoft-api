<?php

namespace App\Services\Discounts;

use App\Models\Order;

class Buy5Get1Free implements DiscountRule
{
    public function applyDiscount(Order $order): ?array
    {
        $category2Count = 0;
        foreach ($order->products as $product) {
            if ($product->category_id == 2) {
                $category2Count += $product->pivot->quantity;
            }
        }

        if ($category2Count >= 6) {
            $discountAmount = $order->products->firstWhere('category_id', 2)->unitPrice;
            return [
                'discountReason' => 'BUY_5_GET_1',
                'discountAmount' => number_format($discountAmount, 2),
                'subtotal' => number_format($order->total, 2)
            ];
        }
        return null;
    }
}