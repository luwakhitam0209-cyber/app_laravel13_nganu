<?php

namespace Database\Seeders;

use App\Models\ProductDetail;
use Illuminate\Database\Seeder;

class ProductDetailSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            ProductDetail::create([
                'product_id' => $i,
                'description' => 'Deskripsi produk ke-' . $i,
                'weight' => rand(1, 30),
            ]);
        }
    }
}