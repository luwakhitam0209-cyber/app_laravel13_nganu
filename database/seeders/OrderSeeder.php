<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::create([
            'user_id' => 1,
            'status' => 'Pending',
        ]);

        Order::create([
            'user_id' => 2,
            'status' => 'Diproses',
        ]);

        Order::create([
            'user_id' => 3,
            'status' => 'Selesai',
        ]);
    }
}