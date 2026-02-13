<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'User',
            'email' => '=user@gmail.com',
            'password'=>Hash::make('user@gmail.com'),
            'role' => 'customer',
            'phone' => '01700000000',
            'status' => 'active',
        ]);
    }
}
