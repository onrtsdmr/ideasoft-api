<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\Discounts\DiscountManager;


class DiscountController extends Controller
{
    public function calculateDiscount(Request $request, $orderId)
    {
        $order = Order::with('products')->findOrFail($orderId);
        
        $discountManager = new DiscountManager();
        $discountResults = $discountManager->applyDiscounts($order);

        return response()->json(array_merge(['orderId' => $orderId], $discountResults));
    }
}
