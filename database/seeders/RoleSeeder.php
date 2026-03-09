<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // ── Super Admin ───────────────────────────────────────────────────────
        $superAdmin = Role::firstOrCreate(
            ['slug' => 'super-admin'],
            ['name' => 'Super Admin', 'description' => 'সর্বোচ্চ ক্ষমতাসম্পন্ন, সব পারমিশন আছে', 'is_active' => true]
        );
        $superAdmin->permissions()->sync(Permission::pluck('id'));

        // ── Admin ─────────────────────────────────────────────────────────────
        $admin = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Admin', 'description' => 'প্রশাসক, প্রায় সব পারমিশন আছে', 'is_active' => true]
        );
        $admin->permissions()->sync(Permission::pluck('id'));

        // ── Manager ───────────────────────────────────────────────────────────
        $manager = Role::firstOrCreate(
            ['slug' => 'manager'],
            ['name' => 'Manager', 'description' => 'পণ্য, অর্ডার ও রিপোর্ট ম্যানেজ করতে পারে', 'is_active' => true]
        );
        $managerSlugs = [
            'view-dashboard',
            'view-products', 'create-products', 'edit-products', 'delete-products',
            'view-orders', 'edit-orders',
            'view-categories', 'create-categories', 'edit-categories',
            'view-reports', 'export-reports',
            'view-users',
        ];
        $manager->permissions()->sync(
            Permission::whereIn('slug', $managerSlugs)->pluck('id')
        );

        // ── Seller ────────────────────────────────────────────────────────────
        $seller = Role::firstOrCreate(
            ['slug' => 'seller'],
            ['name' => 'Seller', 'description' => 'নিজের পণ্য ও অর্ডার দেখতে পারে', 'is_active' => true]
        );
        $sellerSlugs = [
            'view-dashboard',
            'view-products', 'create-products', 'edit-products',
            'view-orders',
            'view-categories',
        ];
        $seller->permissions()->sync(
            Permission::whereIn('slug', $sellerSlugs)->pluck('id')
        );

        // ── Customer ──────────────────────────────────────────────────────────
        $customer = Role::firstOrCreate(
            ['slug' => 'customer'],
            ['name' => 'Customer', 'description' => 'পণ্য দেখা ও অর্ডার করতে পারে', 'is_active' => true, 'is_default' => true]
        );
        $customerSlugs = [
            'view-products',
            'view-categories',
            'create-orders', 'view-orders',
        ];
        $customer->permissions()->sync(
            Permission::whereIn('slug', $customerSlugs)->pluck('id')
        );

        // ── Employee ──────────────────────────────────────────────────────────
        $employee = Role::firstOrCreate(
            ['slug' => 'employee'],
            ['name' => 'Employee', 'description' => 'কর্মচারী, সীমিত ড্যাশবোর্ড অ্যাক্সেস', 'is_active' => true]
        );
        $employeeSlugs = [
            'view-dashboard',
            'view-products',
            'view-orders', 'edit-orders',
            'view-categories',
            'view-reports',
        ];
        $employee->permissions()->sync(
            Permission::whereIn('slug', $employeeSlugs)->pluck('id')
        );
    }
}
