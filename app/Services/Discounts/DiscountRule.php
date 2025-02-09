<?php

namespace App\Services\Discounts;

use App\Models\Order;

interface DiscountRule
{
    public function applyDiscount(Order $order): ?array;
}