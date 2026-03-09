<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmpleeSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'employee@gmail.com'],
            [
                'name'              => 'Employee',
                'email'             => 'employee@gmail.com',
                'password'          => Hash::make('employee@gmail.com'),
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );

        $role = Role::where('slug', 'employee')->first();
        if ($role) {
            $user->roles()->sync([$role->id]);
        }

        $this->command->info('✅ Employee created: employee@gmail.com');
    }
}
