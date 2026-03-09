<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // User Management
            ['name' => 'View Users',    'group' => 'users'],
            ['name' => 'Create Users',  'group' => 'users'],
            ['name' => 'Edit Users',    'group' => 'users'],
            ['name' => 'Delete Users',  'group' => 'users'],

            // Role Management
            ['name' => 'View Roles',    'group' => 'roles'],
            ['name' => 'Create Roles',  'group' => 'roles'],
            ['name' => 'Edit Roles',    'group' => 'roles'],
            ['name' => 'Delete Roles',  'group' => 'roles'],

            // Permission Management
            ['name' => 'View Permissions',   'group' => 'permissions'],
            ['name' => 'Create Permissions', 'group' => 'permissions'],
            ['name' => 'Edit Permissions',   'group' => 'permissions'],
            ['name' => 'Delete Permissions', 'group' => 'permissions'],

            // Product Management
            ['name' => 'View Products',   'group' => 'products'],
            ['name' => 'Create Products', 'group' => 'products'],
            ['name' => 'Edit Products',   'group' => 'products'],
            ['name' => 'Delete Products', 'group' => 'products'],

            // Order Management
            ['name' => 'View Orders',   'group' => 'orders'],
            ['name' => 'Create Orders', 'group' => 'orders'],
            ['name' => 'Edit Orders',   'group' => 'orders'],
            ['name' => 'Delete Orders', 'group' => 'orders'],

            // Category Management
            ['name' => 'View Categories',   'group' => 'categories'],
            ['name' => 'Create Categories', 'group' => 'categories'],
            ['name' => 'Edit Categories',   'group' => 'categories'],
            ['name' => 'Delete Categories', 'group' => 'categories'],

            // Settings
            ['name' => 'View Settings', 'group' => 'settings'],
            ['name' => 'Edit Settings', 'group' => 'settings'],

            // Reports
            ['name' => 'View Reports',   'group' => 'reports'],
            ['name' => 'Export Reports', 'group' => 'reports'],

            // Dashboard
            ['name' => 'View Dashboard', 'group' => 'dashboard'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => Str::slug($permission['name'])],
                [
                    'name'  => $permission['name'],
                    'slug'  => Str::slug($permission['name']),
                    'group' => $permission['group'],
                ]
            );
        }

        $this->command->info('✅ Permissions created: ' . Permission::count() . ' total');
    }
}
