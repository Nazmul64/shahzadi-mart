<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('admin@gmail.com'),
                'status'   => 'active',
            ]
        );

        $role = Role::where('slug', 'super-admin')->first();
        if ($role) {
            $user->roles()->sync([$role->id]);
        }

        $this->command->info('✅ Super Admin তৈরি: superadmin@gmail.com');
    }
}
