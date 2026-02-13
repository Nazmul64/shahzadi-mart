<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'seller',
            'email' => '=seller@gmail.com',
            'password'=>Hash::make('seller@gmail.com'),
            'role' => 'seller',
            'phone' => '01700000000',
            'status' => 'active',
        ]);
    }
}
