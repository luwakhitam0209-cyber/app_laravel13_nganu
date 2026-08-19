<?php

namespace Database\Seeders;

use App\Models\OrderDetail;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        OrderDetail::create([
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 2,
            'unit_price' => 2500000,
        ]);

        OrderDetail::create([
            'order_id' => 2,
            'product_id' => 3,
            'quantity' => 1,
            'unit_price' => 900000,
        ]);

        OrderDetail::create([
            'order_id' => 3,
            'product_id' => 5,
            'quantity' => 3,
            'unit_price' => 350000,
        ]);
    }
}