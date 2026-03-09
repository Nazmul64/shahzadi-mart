<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'manager@geniusshop.com'],
            [
                'name'     => 'Store Manager',
                'password' => Hash::make('manager123'),
                'status'   => 'active',
            ]
        );

        $managerRole = Role::where('slug', 'manager')->first();

        if ($managerRole) {
            $user->roles()->syncWithoutDetaching([$managerRole->id]);
        }
    }
}
