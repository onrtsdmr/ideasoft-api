<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run()
    {
        Order::create([
            'customerId' => 1,
            'items' => json_encode([
                [
                    'productId' => 102,
                    'quantity' => 10,
                    'unitPrice' => '11.28',
                    'total' => '112.80',
                ],
            ]),
            'total' => '112.80',
        ]);

        Order::create([
            'customerId' => 2,
            'items' => json_encode([
                [
                    'productId' => 101,
                    'quantity' => 2,
                    'unitPrice' => '49.50',
                    'total' => '99.00',
                ],
                [
                    'productId' => 100,
                    'quantity' => 1,
                    'unitPrice' => '120.75',
                    'total' => '120.75',
                ],
            ]),
            'total' => '219.75',
        ]);

        Order::create([
            'customerId' => 3,
            'items' => json_encode([
                [
                    'productId' => 102,
                    'quantity' => 6,
                    'unitPrice' => '11.28',
                    'total' => '67.68',
                ],
                [
                    'productId' => 100,
                    'quantity' => 10,
                    'unitPrice' => '120.75',
                    'total' => '1207.50',
                ],
            ]),
            'total' => '1275.18',
        ]);
    }
}