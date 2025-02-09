<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return OrderResource::collection($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        foreach ($request->items as $item) {
            $product = Product::find($item['productId']);
            if (!$product || $product->stock < $item['quantity']) {
                return response()->json([
                    'error' => 'Yetersiz stok: ' . ($product->name ?? 'Ürün bulunamadı.')
                ], 400);
            }
        }

        $order = Order::create([
            'customerId' => $request->customerId,
            'items' => json_encode($request->items),
            'total' => $request->total,
        ]);

        foreach ($request->items as $item) {
            $product = Product::find($item['productId']);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        return response()->json(new OrderResource($order), 201);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, 204);
    }
}
