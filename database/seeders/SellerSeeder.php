<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'seller@gmail.com'],
            [
                'name'              => 'Seller',
                'email'             => 'seller@gmail.com',
                'password'          => Hash::make('seller@gmail.com'),
                'phone'             => '01711111111',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );

        $role = Role::where('slug', 'seller')->first();
        if ($role) {
            $user->roles()->sync([$role->id]);
        }

        $this->command->info('✅ Seller created: seller@gmail.com');
    }
}
