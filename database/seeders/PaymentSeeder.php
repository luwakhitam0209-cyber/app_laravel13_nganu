<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Payment::create([
            'order_id' => 1,
            'method' => 'Transfer BCA',
            'amount' => 5000000,
        ]);

        Payment::create([
            'order_id' => 2,
            'method' => 'DANA',
            'amount' => 900000,
        ]);

        Payment::create([
            'order_id' => 3,
            'method' => 'OVO',
            'amount' => 1050000,
        ]);
    }
}