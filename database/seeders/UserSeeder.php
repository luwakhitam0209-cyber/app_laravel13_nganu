<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Diana Amelia',
            'email' => 'diana@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Abdul Suki',
            'email' => 'abdul@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Yuliana Erawati',
            'email' => 'yuliana@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Anastasya Ayu',
            'email' => 'anastasya@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Putri Aulia',
            'email' => 'putri@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}