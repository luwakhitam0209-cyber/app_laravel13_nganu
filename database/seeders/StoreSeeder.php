<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        Store::create([
            'user_id' => 1,
            'name' => 'HomeLoka',
            'address' => 'Semarang',
        ]);

        Store::create([
            'user_id' => 2,
            'name' => 'Cozy Living',
            'address' => 'Yogyakarta',
        ]);

        Store::create([
            'user_id' => 3,
            'name' => 'Rumah Indah',
            'address' => 'Solo',
        ]);

        Store::create([
            'user_id' => 4,
            'name' => 'Modern Home',
            'address' => 'Surabaya',
        ]);

        Store::create([
            'user_id' => 5,
            'name' => 'Elegant House',
            'address' => 'Bandung',
        ]);
    }
}