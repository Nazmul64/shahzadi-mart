<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // এই ক্রমে run করতে হবে
        $this->call([
            PermissionSeeder::class,   // 1. আগে permission তৈরি
            RoleSeeder::class,         // 2. তারপর role ও permission assign
            AdminSeeder::class,        // 3. admin user
            SellerSeeder::class,       // 4. seller user
            CustomerSeeder::class,     // 5. customer user
            EmpleeSeeder::class,       // 6. emplee user
        ]);
    }
}
