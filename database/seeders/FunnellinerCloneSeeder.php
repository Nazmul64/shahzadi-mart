<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FunnellinerCloneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = \App\Models\Product::first();
        if (!$product) return;

        $landing = \App\Models\LandingPage::create([
            'title'         => 'Gift Box / Perfume Funnel (Clone)',
            'slug'          => 'template-funnelliner-1',
            'product_id'    => $product->id,
            'template_name' => 'landing-3',
            'bg_color'      => '#ffffff',
            'text_color'    => '#1a1a1a',
            'btn_color'     => '#e63946', // Reddish button
            'is_full_width' => false,
            'is_template'   => true,
            'status'        => 1
        ]);

        $blocks = [
            [
                'type' => 'product_hero', 
                'content' => [
                    'title' => 'ভালোবাসার উপহারটি মূল্যবান হয়। প্রিয়জনের রাগ ভাঙাতে ফুল, Coustomize Chocklet Gift Box, কার্ড মুহূর্তের মধ্যে প্রিয়জনের মুখে হাসি ফোটাবে।', 
                    'show_video' => false, 
                    'padding' => 60
                ]
            ],
            [
                'type' => 'product_feature_list', 
                'content' => [
                    'pfl_titles' => ['সারাদেশে ডেলিভারী চার্জ ফ্রি', 'প্রিমিয়াম প্যাকেজিং', 'ক্যাশ অন ডেলিভারী'], 
                    'padding' => 40
                ]
            ],
            [
                'type' => 'custom_html', 
                'content' => [
                    'ch_content' => '<h2 class="text-center fw-bold mt-4" style="color: #e63946;">আপনার এবং আপনার প্রিয়জনদের জন্য সেরা উপহার</h2>', 
                    'padding' => 40
                ]
            ],
            [
                'type' => 'product_price', 
                'content' => [
                    'pp_title' => 'মুল্য-১২০০ টাকা', 
                    'padding' => 40
                ]
            ],
            [
                'type' => 'features', 
                'content' => [
                    'f_title' => 'Customized Chocolet gift box কেন কিনবেন?', 
                    'feature_titles' => ['প্রিয়জনের অভিমান ভাঙ্গাতে', 'স্মৃতিময় পুরোনো ছবি', 'সারপ্রাইজ দিতে'], 
                    'feature_texts' => ['স্মৃতিময় পুরোনো ছবি দিয়ে সাজিয়ে নিতে পারেন Chocolate gift box', 'স্মৃতিময় পুরোনো ছবি দিয়ে সাজিয়ে নিতে পারেন Chocolate gift box', 'স্মৃতিময় পুরোনো ছবি দিয়ে সাজিয়ে নিতে পারেন Chocolate gift box'], 
                    'padding' => 60
                ]
            ],
            [
                'type' => 'call_to_action', 
                'content' => [
                    'cta_title' => 'অর্ডার করতে এখানে ক্লিক করুন', 
                    'cta_btn_text' => 'অর্ডার করুন', 
                    'padding' => 40
                ]
            ],
            [
                'type' => 'custom_html', 
                'content' => [
                    'ch_content' => '<h3 class="text-center text-success fw-bold">সারা দেশে ফ্রি হোম ডেলিভারি</h3><h4 class="text-center mt-3">কি কি থাকছে Coustomize Chocolet Gift box</h4>', 
                    'padding' => 60
                ]
            ],
            [
                'type' => 'reviews_slider', 
                'content' => [
                    'rs_title' => 'আমাদের কাস্টমার রিভিউ', 
                    'padding' => 60
                ]
            ],
            [
                'type' => 'call_to_action', 
                'content' => [
                    'cta_title' => 'তাই আর দেরি না করে আজই অর্ডার করুন', 
                    'cta_btn_text' => 'অর্ডার করুন', 
                    'padding' => 80
                ]
            ],
            [
                'type' => 'footer_classic', 
                'content' => [
                    'f_address' => 'Kuril, Vatara, Dhaka-1229, Bangladesh', 
                    'f_link_titles' => ['Privacy Policy', 'Terms & Conditions'],
                    'f_link_urls' => ['#', '#'],
                    'f_copyright' => '© 2026 All Rights Reserved Designed by YourBrand',
                    'padding' => 60
                ]
            ]
        ];

        foreach ($blocks as $index => $b) {
            \App\Models\LandingPageBlock::create([
                'landing_page_id' => $landing->id,
                'type'            => $b['type'],
                'content'         => $b['content'],
                'order'           => $index + 1
            ]);
        }
    }
}
