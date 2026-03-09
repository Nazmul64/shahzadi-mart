<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompleteRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // ========== CREATE PERMISSIONS ==========

        $permissions = [
            // Users
            ['name' => 'View Users', 'slug' => 'view-users', 'group' => 'users'],
            ['name' => 'Create Users', 'slug' => 'create-users', 'group' => 'users'],
            ['name' => 'Edit Users', 'slug' => 'edit-users', 'group' => 'users'],
            ['name' => 'Delete Users', 'slug' => 'delete-users', 'group' => 'users'],

            // Products
            ['name' => 'View Products', 'slug' => 'view-products', 'group' => 'products'],
            ['name' => 'Create Products', 'slug' => 'create-products', 'group' => 'products'],
            ['name' => 'Edit Products', 'slug' => 'edit-products', 'group' => 'products'],
            ['name' => 'Delete Products', 'slug' => 'delete-products', 'group' => 'products'],
            ['name' => 'Approve Products', 'slug' => 'approve-products', 'group' => 'products'],

            // Orders
            ['name' => 'View Orders', 'slug' => 'view-orders', 'group' => 'orders'],
            ['name' => 'Create Orders', 'slug' => 'create-orders', 'group' => 'orders'],
            ['name' => 'Edit Orders', 'slug' => 'edit-orders', 'group' => 'orders'],
            ['name' => 'Delete Orders', 'slug' => 'delete-orders', 'group' => 'orders'],
            ['name' => 'Process Orders', 'slug' => 'process-orders', 'group' => 'orders'],

            // Categories
            ['name' => 'View Categories', 'slug' => 'view-categories', 'group' => 'categories'],
            ['name' => 'Create Categories', 'slug' => 'create-categories', 'group' => 'categories'],
            ['name' => 'Edit Categories', 'slug' => 'edit-categories', 'group' => 'categories'],
            ['name' => 'Delete Categories', 'slug' => 'delete-categories', 'group' => 'categories'],

            // Sellers
            ['name' => 'View Sellers', 'slug' => 'view-sellers', 'group' => 'sellers'],
            ['name' => 'Approve Sellers', 'slug' => 'approve-sellers', 'group' => 'sellers'],
            ['name' => 'Suspend Sellers', 'slug' => 'suspend-sellers', 'group' => 'sellers'],

            // Reports
            ['name' => 'View Reports', 'slug' => 'view-reports', 'group' => 'reports'],
            ['name' => 'Export Reports', 'slug' => 'export-reports', 'group' => 'reports'],

            // Settings
            ['name' => 'View Settings', 'slug' => 'view-settings', 'group' => 'settings'],
            ['name' => 'Edit Settings', 'slug' => 'edit-settings', 'group' => 'settings'],

            // Roles & Permissions
            ['name' => 'View Roles', 'slug' => 'view-roles', 'group' => 'roles'],
            ['name' => 'Create Roles', 'slug' => 'create-roles', 'group' => 'roles'],
            ['name' => 'Edit Roles', 'slug' => 'edit-roles', 'group' => 'roles'],
            ['name' => 'Delete Roles', 'slug' => 'delete-roles', 'group' => 'roles'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // ========== CREATE ROLES ==========

        // Admin
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Full system access'
        ]);
        $adminRole->permissions()->attach(Permission::all());

        // Manager
        $managerRole = Role::create([
            'name' => 'Manager',
            'slug' => 'manager',
            'description' => 'Manage products, orders, sellers'
        ]);
        $managerRole->permissions()->attach(
            Permission::whereIn('group', ['products', 'orders', 'sellers', 'categories', 'reports'])->get()
        );

        // Seller
        $sellerRole = Role::create([
            'name' => 'Seller',
            'slug' => 'seller',
            'description' => 'Manage own products'
        ]);
        $sellerRole->permissions()->attach(
            Permission::whereIn('slug', [
                'view-products', 'create-products', 'edit-products',
                'view-orders', 'process-orders'
            ])->get()
        );

        // Customer
        $customerRole = Role::create([
            'name' => 'Customer',
            'slug' => 'customer',
            'description' => 'Place orders'
        ]);
        $customerRole->permissions()->attach(
            Permission::whereIn('slug', ['view-products', 'create-orders', 'view-orders'])->get()
        );

        // ========== CREATE DEMO USERS ==========

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);
        $admin->assignRole('admin');

        $seller = User::create([
            'name' => 'Seller User',
            'email' => 'seller@test.com',
            'password' => Hash::make('password'),
            'store_name' => 'Demo Store',
            'store_slug' => 'demo-store',
            'status' => 'active',
        ]);
        $seller->assignRole('seller');

        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@test.com',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);
        $customer->assignRole('customer');

        $this->command->info('✅ Roles, Permissions এবং Demo Users তৈরি হয়েছে!');
    }
}
