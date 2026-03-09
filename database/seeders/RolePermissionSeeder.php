<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            // User Management
            ['name' => 'View Users', 'slug' => 'view-users', 'group' => 'users', 'description' => 'Can view users list'],
            ['name' => 'Create Users', 'slug' => 'create-users', 'group' => 'users', 'description' => 'Can create new users'],
            ['name' => 'Edit Users', 'slug' => 'edit-users', 'group' => 'users', 'description' => 'Can edit existing users'],
            ['name' => 'Delete Users', 'slug' => 'delete-users', 'group' => 'users', 'description' => 'Can delete users'],

            // Role Management
            ['name' => 'View Roles', 'slug' => 'view-roles', 'group' => 'roles', 'description' => 'Can view roles list'],
            ['name' => 'Create Roles', 'slug' => 'create-roles', 'group' => 'roles', 'description' => 'Can create new roles'],
            ['name' => 'Edit Roles', 'slug' => 'edit-roles', 'group' => 'roles', 'description' => 'Can edit existing roles'],
            ['name' => 'Delete Roles', 'slug' => 'delete-roles', 'group' => 'roles', 'description' => 'Can delete roles'],

            // Permission Management
            ['name' => 'View Permissions', 'slug' => 'view-permissions', 'group' => 'permissions', 'description' => 'Can view permissions list'],
            ['name' => 'Create Permissions', 'slug' => 'create-permissions', 'group' => 'permissions', 'description' => 'Can create new permissions'],
            ['name' => 'Edit Permissions', 'slug' => 'edit-permissions', 'group' => 'permissions', 'description' => 'Can edit existing permissions'],
            ['name' => 'Delete Permissions', 'slug' => 'delete-permissions', 'group' => 'permissions', 'description' => 'Can delete permissions'],

            // Product Management
            ['name' => 'View Products', 'slug' => 'view-products', 'group' => 'products', 'description' => 'Can view products'],
            ['name' => 'Create Products', 'slug' => 'create-products', 'group' => 'products', 'description' => 'Can create products'],
            ['name' => 'Edit Products', 'slug' => 'edit-products', 'group' => 'products', 'description' => 'Can edit products'],
            ['name' => 'Delete Products', 'slug' => 'delete-products', 'group' => 'products', 'description' => 'Can delete products'],

            // Order Management
            ['name' => 'View Orders', 'slug' => 'view-orders', 'group' => 'orders', 'description' => 'Can view orders'],
            ['name' => 'Create Orders', 'slug' => 'create-orders', 'group' => 'orders', 'description' => 'Can create orders'],
            ['name' => 'Edit Orders', 'slug' => 'edit-orders', 'group' => 'orders', 'description' => 'Can edit orders'],
            ['name' => 'Delete Orders', 'slug' => 'delete-orders', 'group' => 'orders', 'description' => 'Can delete orders'],

            // Category Management
            ['name' => 'View Categories', 'slug' => 'view-categories', 'group' => 'categories', 'description' => 'Can view categories'],
            ['name' => 'Create Categories', 'slug' => 'create-categories', 'group' => 'categories', 'description' => 'Can create categories'],
            ['name' => 'Edit Categories', 'slug' => 'edit-categories', 'group' => 'categories', 'description' => 'Can edit categories'],
            ['name' => 'Delete Categories', 'slug' => 'delete-categories', 'group' => 'categories', 'description' => 'Can delete categories'],

            // Settings
            ['name' => 'View Settings', 'slug' => 'view-settings', 'group' => 'settings', 'description' => 'Can view system settings'],
            ['name' => 'Edit Settings', 'slug' => 'edit-settings', 'group' => 'settings', 'description' => 'Can edit system settings'],

            // Reports
            ['name' => 'View Reports', 'slug' => 'view-reports', 'group' => 'reports', 'description' => 'Can view reports'],
            ['name' => 'Export Reports', 'slug' => 'export-reports', 'group' => 'reports', 'description' => 'Can export reports'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        // Create Roles
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Admin',
                'description' => 'Full system access with all permissions'
            ]
        );

        $managerRole = Role::firstOrCreate(
            ['slug' => 'manager'],
            [
                'name' => 'Manager',
                'description' => 'Can manage products, orders, and categories'
            ]
        );

        $sellerRole = Role::firstOrCreate(
            ['slug' => 'seller'],
            [
                'name' => 'Seller',
                'description' => 'Can manage own products and orders'
            ]
        );

        $customerRole = Role::firstOrCreate(
            ['slug' => 'customer'],
            [
                'name' => 'Customer',
                'description' => 'Regular customer with basic access'
            ]
        );

        // Assign Permissions to Admin (all permissions)
        $adminRole->permissions()->sync(Permission::all()->pluck('id'));

        // Assign Permissions to Manager
        $managerPermissions = Permission::whereIn('slug', [
            'view-products', 'create-products', 'edit-products', 'delete-products',
            'view-orders', 'edit-orders',
            'view-categories', 'create-categories', 'edit-categories',
            'view-users',
            'view-reports', 'export-reports'
        ])->pluck('id');
        $managerRole->permissions()->sync($managerPermissions);

        // Assign Permissions to Seller
        $sellerPermissions = Permission::whereIn('slug', [
            'view-products', 'create-products', 'edit-products',
            'view-orders',
            'view-categories'
        ])->pluck('id');
        $sellerRole->permissions()->sync($sellerPermissions);

        // Assign Permissions to Customer
        $customerPermissions = Permission::whereIn('slug', [
            'view-products',
            'view-orders', 'create-orders'
        ])->pluck('id');
        $customerRole->permissions()->sync($customerPermissions);

        $this->command->info('Roles and Permissions created successfully!');
    }
}
