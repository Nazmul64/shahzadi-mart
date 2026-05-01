<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    private array $permissions = [

        // ── Main ──────────────────────────────────────────────────────────
        'dashboard' => [
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard'],
        ],
        'pos' => [
            ['name' => 'View POS System',   'slug' => 'view-pos'],
            ['name' => 'Manage POS System', 'slug' => 'manage-pos'],
        ],
        
        // ── E-Commerce ────────────────────────────────────────────────────
        'orders' => [
            ['name' => 'View Orders',    'slug' => 'view-orders'],
            ['name' => 'Create Orders',  'slug' => 'create-orders'],
            ['name' => 'Edit Orders',    'slug' => 'edit-orders'],
            ['name' => 'Delete Orders',  'slug' => 'delete-orders'],
            ['name' => 'Process Orders', 'slug' => 'process-orders'],
            ['name' => 'Export Orders',  'slug' => 'export-orders'],
        ],
        'products' => [
            ['name' => 'View Products',    'slug' => 'view-products'],
            ['name' => 'Create Products',  'slug' => 'create-products'],
            ['name' => 'Edit Products',    'slug' => 'edit-products'],
            ['name' => 'Delete Products',  'slug' => 'delete-products'],
            ['name' => 'Approve Products', 'slug' => 'approve-products'],
            ['name' => 'Export Products',  'slug' => 'export-products'],
        ],
        'categories' => [
            ['name' => 'View Categories',   'slug' => 'view-categories'],
            ['name' => 'Create Categories', 'slug' => 'create-categories'],
            ['name' => 'Edit Categories',   'slug' => 'edit-categories'],
            ['name' => 'Delete Categories', 'slug' => 'delete-categories'],
        ],
        'attributes' => [
            ['name' => 'Manage Colors', 'slug' => 'manage-colors'],
            ['name' => 'Manage Sizes',  'slug' => 'manage-sizes'],
            ['name' => 'Manage Units',  'slug' => 'manage-units'],
            ['name' => 'Manage Brands', 'slug' => 'manage-brands'],
        ],
        'affiliates' => [
            ['name' => 'View Affiliates',   'slug' => 'view-affiliates'],
            ['name' => 'Manage Affiliates', 'slug' => 'manage-affiliates'],
        ],

        // ── Marketing & CRM ───────────────────────────────────────────────
        'users' => [
            ['name' => 'View Users',   'slug' => 'view-users'],
            ['name' => 'Create Users', 'slug' => 'create-users'],
            ['name' => 'Edit Users',   'slug' => 'edit-users'],
            ['name' => 'Delete Users', 'slug' => 'delete-users'],
        ],
        'sellers' => [
            ['name' => 'View Sellers',    'slug' => 'view-sellers'],
            ['name' => 'Approve Sellers', 'slug' => 'approve-sellers'],
            ['name' => 'Suspend Sellers', 'slug' => 'suspend-sellers'],
        ],
        'coupons' => [
            ['name' => 'View Coupons',   'slug' => 'view-coupons'],
            ['name' => 'Manage Coupons', 'slug' => 'manage-coupons'],
        ],
        'chat' => [
            ['name' => 'View Live Chat',   'slug' => 'view-chat'],
            ['name' => 'Manage Live Chat', 'slug' => 'manage-chat'],
        ],
        'reviews' => [
            ['name' => 'View Reviews',   'slug' => 'view-reviews'],
            ['name' => 'Manage Reviews', 'slug' => 'manage-reviews'],
        ],
        'reports' => [
            ['name' => 'View Reports',   'slug' => 'view-reports'],
            ['name' => 'Export Reports', 'slug' => 'export-reports'],
        ],

        // ── System & Security ─────────────────────────────────────────────
        'roles' => [
            ['name' => 'View Roles',   'slug' => 'view-roles'],
            ['name' => 'Create Roles', 'slug' => 'create-roles'],
            ['name' => 'Edit Roles',   'slug' => 'edit-roles'],
            ['name' => 'Delete Roles', 'slug' => 'delete-roles'],
        ],
        'permissions' => [
            ['name' => 'View Permissions',   'slug' => 'view-permissions'],
            ['name' => 'Create Permissions', 'slug' => 'create-permissions'],
            ['name' => 'Edit Permissions',   'slug' => 'edit-permissions'],
            ['name' => 'Delete Permissions', 'slug' => 'delete-permissions'],
        ],

        // ── Configuration ─────────────────────────────────────────────────
        'configuration' => [
            ['name' => 'View Settings',           'slug' => 'view-settings'],
            ['name' => 'Edit Settings',           'slug' => 'edit-settings'],
            ['name' => 'Manage Logo',             'slug' => 'manage-logo'],
            ['name' => 'Manage Favicon',          'slug' => 'manage-favicon'],
            ['name' => 'Manage Contact',          'slug' => 'manage-contact'],
            ['name' => 'Manage Pixel Scripts',    'slug' => 'manage-pixels'],
            ['name' => 'Manage Tag Manager',      'slug' => 'manage-tag-manager'],
            ['name' => 'Manage Campaigns',        'slug' => 'manage-campaigns'],
            ['name' => 'Manage Shipping',         'slug' => 'manage-shipping'],
            ['name' => 'Manage Taxes',            'slug' => 'manage-taxes'],
            ['name' => 'Manage AI Prompts',       'slug' => 'manage-ai-prompts'],
        ],

        // ── Advanced Settings ─────────────────────────────────────────────
        'advanced' => [
            ['name' => 'Manage Payment Gateways', 'slug' => 'manage-payment-gateways'],
            ['name' => 'Manage Steadfast',        'slug' => 'manage-steadfast'],
            ['name' => 'Manage Pathao',           'slug' => 'manage-pathao'],
            ['name' => 'Manage SMS Gateway',      'slug' => 'manage-sms-gateway'],
            ['name' => 'Manage Sliders',          'slug' => 'manage-sliders'],
            ['name' => 'Manage Duplicates',       'slug' => 'manage-duplicates'],
            ['name' => 'Manage IP Blocking',      'slug' => 'manage-ip-blocking'],
            ['name' => 'Manage Pages',            'slug' => 'manage-pages'],
        ],
    ];

    public function run(): void
    {
        $total = 0;

        foreach ($this->permissions as $group => $items) {
            foreach ($items as $item) {
                Permission::updateOrCreate(
                    ['slug' => $item['slug']],
                    [
                        'name'  => $item['name'],
                        'slug'  => $item['slug'],
                        'group' => $group,
                    ]
                );
                $total++;
            }
        }

        $this->command->info("✅ PermissionSeeder: {$total} টি permission তৈরি / আপডেট হয়েছে।");
        $this->command->newLine();

        $rows = [];
        foreach ($this->permissions as $group => $items) {
            $slugs  = implode(', ', array_column($items, 'slug'));
            $rows[] = [ucfirst($group), count($items), $slugs];
        }
        $this->command->table(['Group', 'Count', 'Slugs'], $rows);
    }
}
