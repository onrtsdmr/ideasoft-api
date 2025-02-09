<?php

namespace App\Services\Discounts;

use App\Models\Order;

class DiscountManager
{
    protected $rules = [];

    public function __construct()
    {
        $this->rules = [
            new TenPercentOverThousand(),
            new Buy5Get1Free(),
            new TwentyPercentOffCheapest(),
        ];
    }

    public function applyDiscounts(Order $order)
    {
        $discounts = [];
        $totalDiscount = 0;

        foreach ($this->rules as $rule) {
            $discount = $rule->applyDiscount($order);
            if ($discount) {
                $discounts[] = $discount;
                $totalDiscount += floatval($discount['discountAmount']);
            }
        }

        return [
            'discounts' => $discounts,
            'totalDiscount' => number_format($totalDiscount, 2),
            'discountedTotal' => number_format($order->total - $totalDiscount, 2)
        ];
    }
}