<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name'     => 'Demo Customer',
                'password' => Hash::make('customer@gmail.com'),
                'status'   => 'active',
            ]
        );

        $customerRole = Role::where('slug', 'customer')->first();
        if ($customerRole) {
            $customer->roles()->sync([$customerRole->id]);
        }
    }
}
