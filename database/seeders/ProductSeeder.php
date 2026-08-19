<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'store_id' => 1,
            'name' => 'Sofa Minimalis',
            'price' => 2500000,
            'stock' => 15,
        ]);

        Product::create([
            'store_id' => 1,
            'name' => 'Meja Kayu',
            'price' => 1800000,
            'stock' => 10,
        ]);

        Product::create([
            'store_id' => 2,
            'name' => 'Rak Buku',
            'price' => 900000,
            'stock' => 8,
        ]);

        Product::create([
            'store_id' => 2,
            'name' => 'Kursi Santai',
            'price' => 1200000,
            'stock' => 12,
        ]);

        Product::create([
            'store_id' => 3,
            'name' => 'Panci Granite',
            'price' => 350000,
            'stock' => 20,
        ]);

        Product::create([
            'store_id' => 3,
            'name' => 'Spatula Silicon',
            'price' => 45000,
            'stock' => 50,
        ]);

        Product::create([
            'store_id' => 4,
            'name' => 'TV LED 43"',
            'price' => 4500000,
            'stock' => 6,
        ]);

        Product::create([
            'store_id' => 4,
            'name' => 'Mesin Cuci',
            'price' => 3800000,
            'stock' => 5,
        ]);

        Product::create([
            'store_id' => 5,
            'name' => 'Shower Set',
            'price' => 850000,
            'stock' => 9,
        ]);

        Product::create([
            'store_id' => 5,
            'name' => 'Rak Handuk',
            'price' => 275000,
            'stock' => 15,
        ]);

        Product::create([
            'store_id' => 1,
            'name' => 'Lampu Meja',
            'price' => 150000,
            'stock' => 25,
        ]);
    }
}