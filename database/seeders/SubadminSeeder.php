<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SubadminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'subadmin@gmail.com'],
            [
                'name'     => 'Sub Admin',
                'password' => Hash::make('subadmin@gmail.com'),
                'status'   => 'active',
            ]
        );

        $role = Role::where('slug', 'sub-admin')->first();

        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}
