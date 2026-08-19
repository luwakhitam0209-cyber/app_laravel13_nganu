<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        Employee::create([
            'store_id' => 1,
            'name' => 'Ahmad',
            'position' => 'Kasir',
        ]);

        Employee::create([
            'store_id' => 2,
            'name' => 'Rizky',
            'position' => 'Admin',
        ]);

        Employee::create([
            'store_id' => 3,
            'name' => 'Putri',
            'position' => 'Marketing',
        ]);

        Employee::create([
            'store_id' => 4,
            'name' => 'Yoga',
            'position' => 'Gudang',
        ]);

        Employee::create([
            'store_id' => 5,
            'name' => 'Salsa',
            'position' => 'Supervisor',
        ]);
    }
}