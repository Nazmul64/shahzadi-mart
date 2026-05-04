<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MassLandingPageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = \App\Models\Product::first();
        if (!$product) return;

        $niches = [
            'Smartwatch & Tech' => ['bg' => '#f8f9fa', 'text' => '#212529', 'btn' => '#0d6efd', 'hero' => 'স্মার্ট লাইফস্টাইলের জন্য সেরা গ্যাজেট'],
            'Organic Honey & Food' => ['bg' => '#fff8e1', 'text' => '#4e342e', 'btn' => '#ff8f00', 'hero' => '১০০% খাঁটি ও প্রাকৃতিক খাবার'],
            'Premium Fashion (T-Shirt)' => ['bg' => '#111111', 'text' => '#ffffff', 'btn' => '#ff3b30', 'hero' => 'আপনার স্টাইল হোক সবার চেয়ে আলাদা'],
            'Herbal Hair Oil' => ['bg' => '#e8f5e9', 'text' => '#1b5e20', 'btn' => '#43a047', 'hero' => 'চুল পড়া বন্ধ করে নতুন চুল গজাতে সাহায্য করে'],
            'Luxury Perfume' => ['bg' => '#efebe9', 'text' => '#3e2723', 'btn' => '#8d6e63', 'hero' => 'দীর্ঘস্থায়ী ও আকর্ষণীয় সুবাস'],
            'Exclusive Shoes' => ['bg' => '#eceff1', 'text' => '#263238', 'btn' => '#ff5722', 'hero' => 'আরামদায়ক ও টেকসই জুতো'],
            'Real Estate & Plots' => ['bg' => '#f4f6f8', 'text' => '#001f3f', 'btn' => '#3d9970', 'hero' => 'স্বপ্নের বাড়ি তৈরির জন্য সেরা প্লট'],
            'Online Course/Masterclass' => ['bg' => '#f9fbfc', 'text' => '#333333', 'btn' => '#6f42c1', 'hero' => 'ঘরে বসেই শিখুন নতুন স্কিল'],
            'Gym & Fitness Equipments' => ['bg' => '#212121', 'text' => '#f5f5f5', 'btn' => '#e53935', 'hero' => 'সুস্থ ও ফিট থাকার সেরা সরঞ্জাম'],
            'Cleaning & Home Service' => ['bg' => '#e0f7fa', 'text' => '#006064', 'btn' => '#00acc1', 'hero' => 'আপনার ঘর রাখুন ঝকঝকে পরিষ্কার']
        ];

        // We will generate 5 variations for each of the 10 niches to get 50 templates.
        $count = 1;
        foreach ($niches as $nicheName => $nicheData) {
            for ($i = 1; $i <= 5; $i++) {
                $template = \App\Models\LandingPage::create([
                    'title'         => $nicheName . ' Theme ' . $i,
                    'slug'          => 'template-' . \Illuminate\Support\Str::slug($nicheName) . '-' . $i,
                    'product_id'    => $product->id,
                    'template_name' => 'landing-3', // Use any base layout
                    'bg_color'      => $this->adjustColor($nicheData['bg'], $i),
                    'text_color'    => $nicheData['text'],
                    'btn_color'     => $this->adjustColor($nicheData['btn'], $i),
                    'is_full_width' => ($i % 2 == 0), // Alternate layout styles
                    'is_template'   => true,
                    'status'        => 1
                ]);

                // Create blocks based on variation
                $blocks = $this->getBlocksForVariation($i, $nicheData['hero']);
                $this->createBlocks($template->id, $blocks);

                $count++;
            }
        }
    }

    private function adjustColor($hex, $variation)
    {
        // Simple trick to slightly vary colors for variety (not strictly accurate color math, but works for hex strings)
        if ($variation == 1) return $hex;
        return $hex; // For simplicity, keep base colors but we have 10 distinct niches.
    }

    private function getBlocksForVariation($variation, $heroText)
    {
        // Define different block combinations
        if ($variation == 1) {
            return [
                ['type' => 'product_hero', 'content' => ['title' => $heroText, 'show_video' => true, 'padding' => 80]],
                ['type' => 'features', 'content' => ['f_title' => 'কেন আমাদেরটি সেরা?', 'feature_titles' => ['প্রিমিয়াম কোয়ালিটি', '১০০% গ্যারান্টি'], 'feature_texts' => ['সেরা উপাদান', 'মানি ব্যাক গ্যারান্টি'], 'padding' => 60]],
                ['type' => 'product_price', 'content' => ['pp_title' => 'আজকের অফার প্রাইস:', 'padding' => 60]],
                ['type' => 'call_to_action', 'content' => ['cta_title' => 'দেরি না করে আজই অর্ডার করুন', 'cta_btn_text' => 'অর্ডার করতে ক্লিক করুন', 'padding' => 80]]
            ];
        } elseif ($variation == 2) {
            return [
                ['type' => 'banner', 'content' => ['banner_title' => $heroText, 'banner_btn_text' => 'Buy Now', 'padding' => 100]],
                ['type' => 'text_image', 'content' => ['ti_title' => 'বিস্তারিত জানুন', 'ti_text' => 'আমাদের প্রোডাক্ট কেন অন্যদের চেয়ে আলাদা তার বিস্তারিত জানতে ভিডিও দেখুন বা নিচে পড়ুন।', 'ti_image_position' => 'left', 'padding' => 80]],
                ['type' => 'product_feature_list', 'content' => ['pfl_titles' => ['সারা দেশে ডেলিভারি ফ্রি', 'ক্যাশ অন ডেলিভারি', 'দ্রুত রিটার্ন পলিসি'], 'padding' => 40]],
                ['type' => 'product_price', 'content' => ['padding' => 60]],
                ['type' => 'reviews_slider', 'content' => ['rs_title' => 'কাস্টমার রিভিউ', 'padding' => 80]]
            ];
        } elseif ($variation == 3) {
            return [
                ['type' => 'video', 'content' => ['v_title' => $heroText . ' - ভিডিও দেখুন', 'v_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'padding' => 80]],
                ['type' => 'product_price', 'content' => ['pp_title' => 'অবিশ্বাস্য ডিসকাউন্ট!', 'padding' => 60]],
                ['type' => 'star_ratings', 'content' => ['sr_title' => 'কাস্টমারদের ভরসা', 'sr_rating' => 5, 'padding' => 40]],
                ['type' => 'faq', 'content' => ['faq_title' => 'সাধারণ প্রশ্নসমূহ', 'faq_questions' => ['অর্ডার করার নিয়ম?', 'ডেলিভারি চার্জ কত?'], 'faq_answers' => ['অর্ডার ফর্মে তথ্য দিন।', 'ঢাকার ভেতরে ফ্রি, বাইরে ১০০ টাকা।'], 'padding' => 80]]
            ];
        } elseif ($variation == 4) {
            return [
                ['type' => 'product_hero', 'content' => ['title' => $heroText, 'padding' => 80]],
                ['type' => 'image_compare', 'content' => ['before_label' => 'আগে', 'after_label' => 'পরে', 'padding' => 80]],
                ['type' => 'custom_html', 'content' => ['ch_content' => '<h2 class="text-center text-danger">Special Discount Running!</h2><p class="text-center">Limited Stock Available.</p>', 'padding' => 60]],
                ['type' => 'product_price', 'content' => ['padding' => 60]],
                ['type' => 'whatsapp_button', 'content' => ['wa_btn_text' => 'সরাসরি হোয়াটসঅ্যাপে অর্ডার করুন', 'padding' => 40]]
            ];
        } else {
            return [
                ['type' => 'banner_slider', 'content' => ['padding' => 40]],
                ['type' => 'features', 'content' => ['f_title' => 'আমাদের বৈশিষ্ট্য', 'feature_titles' => ['বেস্ট প্রাইস', 'ফাস্ট ডেলিভারি'], 'feature_texts' => ['', ''], 'padding' => 60]],
                ['type' => 'product_price', 'content' => ['padding' => 60]],
                ['type' => 'footer_classic', 'content' => ['f_description' => 'আমরা দিচ্ছি সেরা সার্ভিস।', 'f_copyright' => '© 2026 All Rights Reserved.', 'padding' => 80]]
            ];
        }
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
