<?php

namespace Database\Seeders;

use App\Models\EmployeeDetail;
use Illuminate\Database\Seeder;

class EmployeeDetailSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            EmployeeDetail::create([
                'employee_id' => $i,
                'employee_number' => 'EMP00' . $i,
                'date_of_joining' => '2024-01-0' . $i,
            ]);
        }
    }
}