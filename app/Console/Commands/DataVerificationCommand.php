<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DataVerificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:verify';
    protected $description = 'Verify key data counts to ensure no data loss during migration.';

    public function handle()
    {
        $tables = [
            'products' => \App\Models\Product::class,
            'categories' => \App\Models\Category::class,
            'sub_categories' => \App\Models\SubCategory::class,
            'orders' => \App\Models\Order::class,
            'customers' => \App\Models\Customer::class,
            'users' => \App\Models\User::class,
        ];

        $this->info('--- Data Verification Report ---');
        foreach ($tables as $name => $model) {
            try {
                if (class_exists($model)) {
                    $count = $model::count();
                    $this->line(sprintf('%-20s: <info>%d</info> records', ucfirst($name), $count));
                } else {
                    $this->warn(sprintf('%-20s: Model class not found', ucfirst($name)));
                }
            } catch (\Exception $e) {
                $this->error(sprintf('%-20s: Error counting (Table may not exist yet)', ucfirst($name)));
            }
        }
        $this->info('--------------------------------');
        
        return 0;
    }
}
