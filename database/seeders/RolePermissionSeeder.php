<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // আগে PermissionSeeder চালাও
        $this->call(PermissionSeeder::class);

        // ── Super Admin ───────────────────────────────────────────────────
        $superAdmin = Role::updateOrCreate(
            ['slug' => 'super-admin'],
            [
                'name'        => 'Super Admin',
                'description' => 'সর্বোচ্চ অ্যাক্সেস — সব পারমিশন',
                'is_active'   => true,
                'is_default'  => false,
            ]
        );
        $superAdmin->permissions()->sync(Permission::all()->pluck('id'));

        // ── Admin ─────────────────────────────────────────────────────────
        $admin = Role::updateOrCreate(
            ['slug' => 'admin'],
            [
                'name'        => 'Admin',
                'description' => 'পূর্ণ সিস্টেম অ্যাক্সেস',
                'is_active'   => true,
                'is_default'  => false,
            ]
        );
        $admin->permissions()->sync(Permission::all()->pluck('id'));

        // ── Manager ───────────────────────────────────────────────────────
        $manager = Role::updateOrCreate(
            ['slug' => 'manager'],
            [
                'name'        => 'Manager',
                'description' => 'Products, Orders, Sellers, Categories, Reports পরিচালনা',
                'is_active'   => true,
                'is_default'  => false,
            ]
        );
        $manager->permissions()->sync(
            Permission::whereIn('group', ['products', 'orders', 'sellers', 'categories', 'reports'])
                ->orWhereIn('slug', ['view-users', 'view-dashboard'])
                ->pluck('id')
        );

        // ── Seller ────────────────────────────────────────────────────────
        $seller = Role::updateOrCreate(
            ['slug' => 'seller'],
            [
                'name'        => 'Seller',
                'description' => 'নিজের পণ্য পরিচালনা ও অর্ডার দেখা',
                'is_active'   => true,
                'is_default'  => false,
            ]
        );
        $seller->permissions()->sync(
            Permission::whereIn('slug', [
                'view-dashboard',
                'view-products', 'create-products', 'edit-products',
                'view-orders', 'process-orders',
                'view-categories',
            ])->pluck('id')
        );

        // ── Customer ──────────────────────────────────────────────────────
        $customer = Role::updateOrCreate(
            ['slug' => 'customer'],
            [
                'name'        => 'Customer',
                'description' => 'সাধারণ কাস্টমার — পণ্য দেখা ও অর্ডার করা',
                'is_active'   => true,
                'is_default'  => true,
            ]
        );
        $customer->permissions()->sync(
            Permission::whereIn('slug', [
                'view-products',
                'create-orders',
                'view-orders',
            ])->pluck('id')
        );

        $this->command->info('✅ Roles তৈরি ও permissions assign হয়েছে!');

        // ── Demo Users ────────────────────────────────────────────────────
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@test.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password'),
                'status'   => 'active',
            ]
        );
        $superAdminUser->roles()->syncWithoutDetaching([$superAdmin->id]);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
                'status'   => 'active',
            ]
        );
        $adminUser->roles()->syncWithoutDetaching([$admin->id]);

        $managerUser = User::firstOrCreate(
            ['email' => 'manager@test.com'],
            [
                'name'     => 'Manager User',
                'password' => Hash::make('password'),
                'status'   => 'active',
            ]
        );
        $managerUser->roles()->syncWithoutDetaching([$manager->id]);

        $sellerUser = User::firstOrCreate(
            ['email' => 'seller@test.com'],
            [
                'name'     => 'Seller User',
                'password' => Hash::make('password'),
                'status'   => 'active',
            ]
        );
        $sellerUser->roles()->syncWithoutDetaching([$seller->id]);

        $customerUser = User::firstOrCreate(
            ['email' => 'customer@test.com'],
            [
                'name'     => 'Customer User',
                'password' => Hash::make('password'),
                'status'   => 'active',
            ]
        );
        $customerUser->roles()->syncWithoutDetaching([$customer->id]);

        $this->command->info('✅ Demo Users তৈরি হয়েছে!');
        $this->command->newLine();
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Super Admin', 'superadmin@test.com', 'password'],
                ['Admin',       'admin@test.com',       'password'],
                ['Manager',     'manager@test.com',     'password'],
                ['Seller',      'seller@test.com',      'password'],
                ['Customer',    'customer@test.com',    'password'],
            ]
        );
    }
}
