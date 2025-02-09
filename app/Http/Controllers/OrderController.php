<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Redis::lrange('orders', 0, -1);
        
        if (empty($orders)) {
            $orders = Order::all();
            foreach ($orders as $order) {
                Redis::rpush('orders', json_encode($order));
            }
        } else {
            $orders = array_map(function ($order) {
                $orderData = json_decode($order, true);
                $orderData['items'] = json_decode($orderData['items'], true);
                return $orderData;
            }, $orders);
        }
        
        return response()->json($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        foreach ($request->items as $item) {
            $stock = Redis::get('product_stock:' . $item['productId']);
            if (!$stock || $stock < $item['quantity']) {
                return response()->json([
                    'error' => 'Yetersiz stok: ' . ($item['productId'] ?? 'Ürün bulunamadı.')
                ], 400);
            }
        }

        $order = Order::create([
            'customerId' => $request->customerId,
            'items' => json_encode($request->items),
            'total' => $request->total,
        ]);

        Redis::rpush('orders', json_encode($order));

        foreach ($request->items as $item) {
            $currentStock = Redis::get('product_stock:' . $item['productId']);
            if ($currentStock === null) {
                $product = Product::find($item['productId']);
                $currentStock = $product->stock;
            }

            $newStock = $currentStock - $item['quantity'];
            Redis::set('product_stock:' . $item['productId'], $newStock);

            $product = Product::find($item['productId']);
            $product->stock = $newStock;
            $product->save();
        }

        return response()->json(new OrderResource($order), 201);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        $orders = Redis::lrange('orders', 0, -1);
        foreach ($orders as $key => $orderData) {
            $orderInRedis = json_decode($orderData, true);
            if ($orderInRedis['id'] == $id) {
                Redis::lrem('orders', 1, $orderData);
                break;
            }
        }

        return response()->json(null, 204);
    }
}
