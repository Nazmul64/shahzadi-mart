<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingPageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a default product to link templates to
        $product = \App\Models\Product::first();
        if (!$product) return;

        // 1. Cosmetics Premium Template
        $cosmetics = \App\Models\LandingPage::create([
            'title'         => 'Premium Cosmetics Theme',
            'slug'          => 'template-cosmetics',
            'product_id'    => $product->id,
            'template_name' => 'landing-3',
            'bg_color'      => '#0f172a', // Dark Slate
            'text_color'    => '#f8fafc',
            'btn_color'     => '#ec4899', // Pink
            'is_full_width' => true,
            'is_template'   => true,
            'status'        => 1
        ]);

        $this->createBlocks($cosmetics->id, [
            ['type' => 'product_hero', 'content' => ['title' => 'আপনার সৌন্দর্য বৃদ্ধি করুন প্রাকৃতিক উপায়ে', 'show_video' => true, 'padding' => 80]],
            ['type' => 'product_feature_list', 'content' => ['pfl_titles' => ['১০০% হার্বাল উপাদান', 'কোন পার্শ্বপ্রতিক্রিয়া নেই', 'দ্রুত ফলাফল'], 'padding' => 40]],
            ['type' => 'product_price', 'content' => ['pp_title' => 'সীমিত সময়ের অফার:', 'padding' => 60]],
            ['type' => 'reviews_slider', 'content' => ['rs_title' => 'আমাদের কাস্টমাররা যা বলছেন', 'padding' => 80]],
            ['type' => 'faq', 'content' => ['faq_title' => 'সাধারণ কিছু জিজ্ঞাসা', 'faq_questions' => ['কিভাবে ব্যবহার করবেন?', 'কত দিনে রেজাল্ট আসবে?'], 'faq_answers' => ['প্রতিদিন রাতে ঘুমানোর আগে।', '৭-১৫ দিনের মধ্যে।'], 'padding' => 60]],
        ]);

        // 2. Gadget Tech Template
        $gadget = \App\Models\LandingPage::create([
            'title'         => 'Modern Tech Theme',
            'slug'          => 'template-gadget',
            'product_id'    => $product->id,
            'template_name' => 'landing-3',
            'bg_color'      => '#ffffff',
            'text_color'    => '#1e293b',
            'btn_color'     => '#2563eb', // Blue
            'is_full_width' => false,
            'is_template'   => true,
            'status'        => 1
        ]);

        $this->createBlocks($gadget->id, [
            ['type' => 'banner', 'content' => ['banner_title' => 'স্মার্ট লাইফস্টাইলের জন্য সেরা স্মার্টওয়াচ', 'banner_btn_text' => 'অর্ডার করুন', 'padding' => 100]],
            ['type' => 'video', 'content' => ['v_title' => 'প্রোডাক্টটির ভিডিও দেখুন', 'v_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'padding' => 80]],
            ['type' => 'features', 'content' => ['f_title' => 'কেন এই প্রোডাক্টটি নিবেন?', 'feature_titles' => ['দীর্ঘস্থায়ী ব্যাটারি', 'ওয়াটারপ্রুফ ডিজাইন'], 'feature_texts' => ['এক চার্জে ৭ দিন চলে', 'IP68 সার্টিফাইড'], 'padding' => 80]],
            ['type' => 'product_price', 'content' => ['padding' => 60]],
            ['type' => 'whatsapp_button', 'content' => ['wa_btn_text' => 'সরাসরি কথা বলুন', 'padding' => 40]],
        ]);

        // 3. Health & Supplement Template
        $health = \App\Models\LandingPage::create([
            'title'         => 'Health & Vitality Theme',
            'slug'          => 'template-health',
            'product_id'    => $product->id,
            'template_name' => 'landing-3',
            'bg_color'      => '#fff7ed', // Light Orange/Cream
            'text_color'    => '#431407',
            'btn_color'     => '#ea580c', // Orange
            'is_full_width' => true,
            'is_template'   => true,
            'status'        => 1
        ]);

        $this->createBlocks($health->id, [
            ['type' => 'product_hero', 'content' => ['title' => 'সুস্থ ও সবল থাকুন সবসময়', 'padding' => 80]],
            ['type' => 'image_compare', 'content' => ['before_label' => 'আগে', 'after_label' => 'পরে', 'padding' => 80]],
            ['type' => 'star_ratings', 'content' => ['sr_title' => '৫০০০+ মানুষ আমাদের ওপর ভরসা করেছেন', 'sr_rating' => 4.9, 'padding' => 60]],
            ['type' => 'product_price', 'content' => ['padding' => 60]],
            ['type' => 'footer_classic', 'content' => ['f_description' => 'আমরা দিচ্ছি সেরা মানের স্বাস্থ্যসেবা।', 'padding' => 80]],
        ]);
    }

    private function createBlocks($landingId, $blocks)
    {
        foreach ($blocks as $index => $b) {
            \App\Models\LandingPageBlock::create([
                'landing_page_id' => $landingId,
                'type'            => $b['type'],
                'content'         => $b['content'],
                'order'           => $index + 1
            ]);
        }
    }
}
