<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * প্রতিটি group = Admin sidebar-এর একটি section।
     * Admin panel থেকে যেকোনো user-কে যেকোনো permission দেওয়া যাবে।
     */
    private array $permissions = [

        // ── Dashboard ─────────────────────────────────────────────────────
        'dashboard' => [
            ['name' => 'View Dashboard',     'slug' => 'view-dashboard'],
        ],

        // ── POS ───────────────────────────────────────────────────────────
        'pos' => [
            ['name' => 'View POS System',   'slug' => 'view-pos'],
            ['name' => 'Manage POS System', 'slug' => 'manage-pos'],
        ],

        // ── Orders ────────────────────────────────────────────────────────
        'orders' => [
            ['name' => 'View Orders',            'slug' => 'view-orders'],
            ['name' => 'Create Orders',          'slug' => 'create-orders'],
            ['name' => 'Edit Orders',            'slug' => 'edit-orders'],
            ['name' => 'Delete Orders',          'slug' => 'delete-orders'],
            ['name' => 'Process Orders',         'slug' => 'process-orders'],
            ['name' => 'Export Orders',          'slug' => 'export-orders'],
            ['name' => 'Assign Staff to Orders', 'slug' => 'assign-staff-orders'],
            ['name' => 'Send to Steadfast',      'slug' => 'send-steadfast'],
            ['name' => 'Send to Pathao',         'slug' => 'send-pathao'],
        ],

        // ── Products ──────────────────────────────────────────────────────
        'products' => [
            ['name' => 'View Products',    'slug' => 'view-products'],
            ['name' => 'Create Products',  'slug' => 'create-products'],
            ['name' => 'Edit Products',    'slug' => 'edit-products'],
            ['name' => 'Delete Products',  'slug' => 'delete-products'],
            ['name' => 'Approve Products', 'slug' => 'approve-products'],
            ['name' => 'Export Products',  'slug' => 'export-products'],
        ],

        // ── Categories ────────────────────────────────────────────────────
        'categories' => [
            ['name' => 'View Categories',          'slug' => 'view-categories'],
            ['name' => 'Create Categories',        'slug' => 'create-categories'],
            ['name' => 'Edit Categories',          'slug' => 'edit-categories'],
            ['name' => 'Delete Categories',        'slug' => 'delete-categories'],
            ['name' => 'View Sub-Categories',      'slug' => 'view-subcategories'],
            ['name' => 'Manage Sub-Categories',    'slug' => 'manage-subcategories'],
            ['name' => 'View Child Categories',    'slug' => 'view-childcategories'],
            ['name' => 'Manage Child Categories',  'slug' => 'manage-childcategories'],
        ],

        // ── Product Attributes ────────────────────────────────────────────
        'attributes' => [
            ['name' => 'Manage Colors', 'slug' => 'manage-colors'],
            ['name' => 'Manage Sizes',  'slug' => 'manage-sizes'],
            ['name' => 'Manage Units',  'slug' => 'manage-units'],
            ['name' => 'Manage Brands', 'slug' => 'manage-brands'],
        ],

        // ── Affiliate Products ────────────────────────────────────────────
        'affiliates' => [
            ['name' => 'View Affiliates',   'slug' => 'view-affiliates'],
            ['name' => 'Manage Affiliates', 'slug' => 'manage-affiliates'],
        ],

        // ── Coupons ───────────────────────────────────────────────────────
        'coupons' => [
            ['name' => 'View Coupons',   'slug' => 'view-coupons'],
            ['name' => 'Create Coupons', 'slug' => 'create-coupons'],
            ['name' => 'Edit Coupons',   'slug' => 'edit-coupons'],
            ['name' => 'Delete Coupons', 'slug' => 'delete-coupons'],
        ],

        // ── Reviews ───────────────────────────────────────────────────────
        'reviews' => [
            ['name' => 'View Reviews',   'slug' => 'view-reviews'],
            ['name' => 'Manage Reviews', 'slug' => 'manage-reviews'],
            ['name' => 'Delete Reviews', 'slug' => 'delete-reviews'],
        ],

        // ── Live Chat ─────────────────────────────────────────────────────
        'chat' => [
            ['name' => 'View Live Chat',      'slug' => 'view-chat'],
            ['name' => 'Manage Live Chat',    'slug' => 'manage-chat'],
            ['name' => 'Reply Live Chat',     'slug' => 'reply-chat'],
            ['name' => 'Close Chat Sessions', 'slug' => 'close-chat'],
        ],

        // ── Customers & Users ─────────────────────────────────────────────
        'users' => [
            ['name' => 'View Users',         'slug' => 'view-users'],
            ['name' => 'Create Users',        'slug' => 'create-users'],
            ['name' => 'Edit Users',          'slug' => 'edit-users'],
            ['name' => 'Delete Users',        'slug' => 'delete-users'],
            ['name' => 'Toggle User Status',  'slug' => 'toggle-user-status'],
        ],

        // ── Sellers ───────────────────────────────────────────────────────
        'sellers' => [
            ['name' => 'View Sellers',    'slug' => 'view-sellers'],
            ['name' => 'Approve Sellers', 'slug' => 'approve-sellers'],
            ['name' => 'Reject Sellers',  'slug' => 'reject-sellers'],
            ['name' => 'Suspend Sellers', 'slug' => 'suspend-sellers'],
        ],

        // ── Reports ───────────────────────────────────────────────────────
        'reports' => [
            ['name' => 'View Reports',       'slug' => 'view-reports'],
            ['name' => 'Export Reports',     'slug' => 'export-reports'],
            ['name' => 'View Payment History','slug' => 'view-payment-history'],
        ],

        // ── Roles & Permissions ───────────────────────────────────────────
        'roles' => [
            ['name' => 'View Roles',   'slug' => 'view-roles'],
            ['name' => 'Create Roles', 'slug' => 'create-roles'],
            ['name' => 'Edit Roles',   'slug' => 'edit-roles'],
            ['name' => 'Delete Roles', 'slug' => 'delete-roles'],
            ['name' => 'Assign Permissions to Roles', 'slug' => 'assign-role-permissions'],
        ],
        'permissions' => [
            ['name' => 'View Permissions',   'slug' => 'view-permissions'],
            ['name' => 'Create Permissions', 'slug' => 'create-permissions'],
            ['name' => 'Edit Permissions',   'slug' => 'edit-permissions'],
            ['name' => 'Delete Permissions', 'slug' => 'delete-permissions'],
        ],

        // ── Website Settings ──────────────────────────────────────────────
        'configuration' => [
            ['name' => 'View Settings',        'slug' => 'view-settings'],
            ['name' => 'Edit General Settings', 'slug' => 'edit-settings'],
            ['name' => 'Manage Logo',           'slug' => 'manage-logo'],
            ['name' => 'Manage Favicon',        'slug' => 'manage-favicon'],
            ['name' => 'Manage Footer',         'slug' => 'manage-footer'],
            ['name' => 'Manage Sliders',        'slug' => 'manage-sliders'],
            ['name' => 'Manage Campaigns',      'slug' => 'manage-campaigns'],
            ['name' => 'Manage Shipping Zones', 'slug' => 'manage-shipping'],
            ['name' => 'Manage AI Prompts',     'slug' => 'manage-ai-prompts'],
            ['name' => 'Manage Pages',          'slug' => 'manage-pages'],
        ],

        // ── Courier & Payment ─────────────────────────────────────────────
        'advanced' => [
            ['name' => 'Manage Payment Gateways', 'slug' => 'manage-payment-gateways'],
            ['name' => 'Manage Steadfast Config',  'slug' => 'manage-steadfast'],
            ['name' => 'Manage Pathao Config',     'slug' => 'manage-pathao'],
            ['name' => 'Manage SMS Gateway',       'slug' => 'manage-sms-gateway'],
            ['name' => 'Manage Pixel Scripts',     'slug' => 'manage-pixels'],
            ['name' => 'Manage Tag Manager',       'slug' => 'manage-tag-manager'],
            ['name' => 'Manage IP Blocking',       'slug' => 'manage-ip-blocking'],
        ],

        // ── Blog ──────────────────────────────────────────────────────────
        'blog' => [
            ['name' => 'View Blog Posts',       'slug' => 'view-blog-posts'],
            ['name' => 'Create Blog Posts',     'slug' => 'create-blog-posts'],
            ['name' => 'Edit Blog Posts',       'slug' => 'edit-blog-posts'],
            ['name' => 'Delete Blog Posts',     'slug' => 'delete-blog-posts'],
            ['name' => 'Manage Blog Categories','slug' => 'manage-blog-categories'],
        ],

        // ── Order Assignments Dashboard ───────────────────────────────────
        'assignments' => [
            ['name' => 'View Order Assignments',   'slug' => 'view-assignments'],
            ['name' => 'Manage Order Assignments',  'slug' => 'manage-assignments'],
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
