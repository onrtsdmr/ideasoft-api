<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        Customer::create([
            'name' => 'Türker Jöntürk',
            'since' => '2014-06-28',
            'revenue' => 492.12,
        ]);

        Customer::create([
            'name' => 'Kaptan Devopuz',
            'since' => '2015-01-15',
            'revenue' => 1505.95,
        ]);

        Customer::create([
            'name' => 'İsa Sonuyumaz',
            'since' => '2016-02-11',
            'revenue' => 0.00,
        ]);
    }
}