<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * প্রতিটি role-এর জন্য কোন group-এর permission দেওয়া হবে সেটা এখানে define।
     * Super Admin ও Admin — সব পায়, তাই আলাদা handle।
     */
    private array $roleConfig = [
        [
            'slug'        => 'super-admin',
            'name'        => 'Super Admin',
            'description' => 'সর্বোচ্চ ক্ষমতা — সব পারমিশন আছে',
            'is_default'  => false,
            'all'         => true, // সব permission
        ],
        [
            'slug'        => 'admin',
            'name'        => 'Admin',
            'description' => 'প্রশাসক — প্রায় সব পারমিশন আছে',
            'is_default'  => false,
            'all'         => true,
        ],
        [
            'slug'        => 'sub-admin',
            'name'        => 'Sub Admin',
            'description' => 'সীমিত অ্যাডমিন অ্যাক্সেস',
            'is_default'  => false,
            'slugs'       => [
                'view-dashboard',
                'view-products', 'create-products', 'edit-products',
                'view-orders', 'edit-orders',
                'view-categories', 'create-categories', 'edit-categories',
                'view-users',
                'view-reports', 'export-reports',
            ],
        ],
        [
            'slug'        => 'manager',
            'name'        => 'Manager',
            'description' => 'পণ্য, অর্ডার, ক্যাটাগরি ম্যানেজ করতে পারে',
            'is_default'  => false,
            'slugs'       => [],
        ],
        [
            'slug'        => 'seller',
            'name'        => 'Seller',
            'description' => 'নিজের পণ্য ও অর্ডার ম্যানেজ করতে পারে',
            'is_default'  => false,
            'slugs'       => [
                'view-dashboard',
                'view-products', 'create-products', 'edit-products',
                'view-orders', 'process-orders',
                'view-categories',
                'view-reports',
            ],
        ],
        [
            'slug'        => 'employee',
            'name'        => 'Employee',
            'description' => 'কর্মচারী — সীমিত ড্যাশবোর্ড অ্যাক্সেস',
            'is_default'  => false,
            'slugs'       => [],
        ],
        [
            'slug'        => 'customer',
            'name'        => 'Customer',
            'description' => 'সাধারণ গ্রাহক — পণ্য দেখা ও অর্ডার করা',
            'is_default'  => true, // নতুন user পেলে এই role পাবে
            'slugs'       => [
                'view-products',
                'view-categories',
                'create-orders', 'view-orders',
            ],
        ],
    ];

    public function run(): void
    {
        $allPermissionIds = Permission::pluck('id');

        foreach ($this->roleConfig as $config) {
            $role = Role::updateOrCreate(
                ['slug' => $config['slug']],
                [
                    'name'        => $config['name'],
                    'description' => $config['description'],
                    'is_active'   => true,
                    'is_default'  => $config['is_default'],
                ]
            );

            if ($config['all'] ?? false) {
                $role->permissions()->sync($allPermissionIds);
            } else {
                $ids = Permission::whereIn('slug', $config['slugs'])->pluck('id');
                $role->permissions()->sync($ids);
            }
        }

        $this->command->info('✅ Roles: ' . Role::count() . ' টি তৈরি হয়েছে।');
    }
}
