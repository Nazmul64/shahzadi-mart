<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\LandingPageBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LandingPageBuilderController extends Controller
{
    /**
     * Show the drag-and-drop builder for a specific landing page.
     */
    public function index($landingId)
    {
        $landing = LandingPage::with(['blocks' => function($q) {
            $q->orderBy('order', 'asc');
        }])->findOrFail($landingId);
        $products = \App\Models\Product::where('status', 'active')->get();
        $templates = LandingPage::where('is_template', true)->get();
        return view('admin.landing.builder', compact('landing', 'products', 'templates'));
    }

    /**
     * Store a new block.
     */
    public function storeBlock(Request $request, $landingId)
    {
        $landing = LandingPage::findOrFail($landingId);

        $request->validate([
            'type' => 'required|string',
        ]);

        $content = $this->processBlockContent($request);

        // Get max order
        $maxOrder = LandingPageBlock::where('landing_page_id', $landing->id)->max('order') ?? 0;

        LandingPageBlock::create([
            'landing_page_id' => $landing->id,
            'type' => $request->type,
            'content' => $content,
            'order' => $maxOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Block added successfully!');
    }

    /**
     * Show block content as JSON for editing.
     */
    public function showBlock($id)
    {
        $block = LandingPageBlock::findOrFail($id);
        return response()->json($block);
    }

    /**
     * Update an existing block.
     */
    public function updateBlock(Request $request, $id)
    {
        $block = LandingPageBlock::findOrFail($id);
        $content = $this->processBlockContent($request, $block);

        $block->update([
            'content' => $content
        ]);

        return redirect()->back()->with('success', 'Block updated successfully!');
    }

    /**
     * Helper to process block content and common style/animation fields.
     */
    private function processBlockContent(Request $request, $existingBlock = null)
    {
        $content = $existingBlock ? $existingBlock->content : [];
        $type = $request->input('type', $existingBlock ? $existingBlock->type : null);

        // Standard style/animation fields
        $content['title_color'] = $request->input('title_color');
        $content['text_color'] = $request->input('text_color');
        $content['bg_color'] = $request->input('block_bg_color');
        $content['aos_type'] = $request->input('aos_type', 'fade-up');
        $content['aos_duration'] = $request->input('aos_duration', 800);
        $content['padding'] = $request->input('block_padding', 60);
        $content['style_variation'] = $request->input('style_variation', 'style-1');

        // Type specific content
        switch ($type) {
            case 'banner':
                if ($request->hasFile('banner_image')) {
                    // Delete old
                    if (isset($content['image'])) {
                        $oldPath = public_path('uploads/landing/blocks/' . $content['image']);
                        if (File::exists($oldPath)) File::delete($oldPath);
                    }
                    $name = time() . '_banner_' . $request->file('banner_image')->getClientOriginalName();
                    $request->file('banner_image')->move(public_path('uploads/landing/blocks'), $name);
                    $content['image'] = $name;
                }
                $content['title'] = $request->input('banner_title');
                $content['subtitle'] = $request->input('banner_subtitle');
                $content['btn_text'] = $request->input('banner_btn_text');
                break;

            case 'text_image':
                if ($request->hasFile('ti_image')) {
                    if (isset($content['image'])) {
                        $oldPath = public_path('uploads/landing/blocks/' . $content['image']);
                        if (File::exists($oldPath)) File::delete($oldPath);
                    }
                    $name = time() . '_ti_' . $request->file('ti_image')->getClientOriginalName();
                    $request->file('ti_image')->move(public_path('uploads/landing/blocks'), $name);
                    $content['image'] = $name;
                }
                $content['title'] = $request->input('ti_title');
                $content['text'] = $request->input('ti_text');
                $content['image_position'] = $request->input('ti_image_position', 'left');
                break;

            case 'features':
                $content['title'] = $request->input('f_title', 'Why Choose Us?');
                $content['items'] = [];
                if ($request->has('feature_titles')) {
                    foreach ($request->input('feature_titles') as $k => $ft) {
                        $content['items'][] = [
                            'title' => $ft,
                            'text' => $request->input('feature_texts')[$k] ?? ''
                        ];
                    }
                }
                break;

            case 'video':
                $content['title'] = $request->input('v_title');
                $content['video_url'] = $request->input('v_url');
                break;

            case 'reviews_slider':
                $content['title'] = $request->input('rs_title', 'Customer Reviews');
                break;

            case 'custom_reviews_slider':
                $content['title'] = $request->input('crs_title', 'Real Customer Reviews');
                if ($request->hasFile('crs_images')) {
                    // Optionally delete old images? Usually people append or replace.
                    // For now, let's replace if new images provided.
                    if (isset($content['images'])) {
                        foreach ($content['images'] as $img) {
                            $oldPath = public_path('uploads/landing/blocks/' . $img);
                            if (File::exists($oldPath)) File::delete($oldPath);
                        }
                    }
                    $content['images'] = [];
                    foreach ($request->file('crs_images') as $image) {
                        $name = time() . '_' . uniqid() . '_crs_' . $image->getClientOriginalName();
                        $image->move(public_path('uploads/landing/blocks'), $name);
                        $content['images'][] = $name;
                    }
                }
                break;

            case 'faq':
                $content['title'] = $request->input('faq_title', 'Frequently Asked Questions');
                $content['items'] = [];
                if ($request->has('faq_questions')) {
                    foreach ($request->input('faq_questions') as $k => $q) {
                        $content['items'][] = [
                            'question' => $q,
                            'answer' => $request->input('faq_answers')[$k] ?? ''
                        ];
                    }
                }
                break;

            case 'countdown':
                $content['title'] = $request->input('cd_title');
                $content['end_time'] = $request->input('cd_end_time');
                break;

            case 'gallery':
                $content['title'] = $request->input('gal_title', 'Our Gallery');
                if ($request->hasFile('gal_images')) {
                    if (isset($content['images'])) {
                        foreach ($content['images'] as $img) {
                            $oldPath = public_path('uploads/landing/blocks/' . $img);
                            if (File::exists($oldPath)) File::delete($oldPath);
                        }
                    }
                    $content['images'] = [];
                    foreach ($request->file('gal_images') as $image) {
                        $name = time() . '_' . uniqid() . '_gal_' . $image->getClientOriginalName();
                        $image->move(public_path('uploads/landing/blocks'), $name);
                        $content['images'][] = $name;
                    }
                }
                break;

            case 'custom_html':
                $content['html_content'] = $request->input('ch_content');
                break;

            case 'whatsapp_button':
                $content['phone'] = $request->input('wa_phone');
                $content['message'] = $request->input('wa_message');
                $content['btn_text'] = $request->input('wa_btn_text', 'Chat on WhatsApp');
                break;

            case 'counter':
                $content['title'] = $request->input('count_title');
                $content['number'] = $request->input('count_number', 100);
                $content['prefix'] = $request->input('count_prefix');
                $content['suffix'] = $request->input('count_suffix');
                break;

            case 'image_compare':
                if ($request->hasFile('ic_before')) {
                    $name = time() . '_before_' . $request->file('ic_before')->getClientOriginalName();
                    $request->file('ic_before')->move(public_path('uploads/landing/blocks'), $name);
                    $content['before_image'] = $name;
                }
                if ($request->hasFile('ic_after')) {
                    $name = time() . '_after_' . $request->file('ic_after')->getClientOriginalName();
                    $request->file('ic_after')->move(public_path('uploads/landing/blocks'), $name);
                    $content['after_image'] = $name;
                }
                $content['before_label'] = $request->input('ic_before_label', 'Before');
                $content['after_label'] = $request->input('ic_after_label', 'After');
                break;

            case 'dual_button':
                $content['btn1_text'] = $request->input('db_btn1_text', 'Button 1');
                $content['btn1_url'] = $request->input('db_btn1_url', '#');
                $content['btn2_text'] = $request->input('db_btn2_text', 'Button 2');
                $content['btn2_url'] = $request->input('db_btn2_url', '#');
                $content['separator'] = $request->input('db_separator', 'OR');
                break;

            case 'star_ratings':
                $content['title'] = $request->input('sr_title');
                $content['rating'] = $request->input('sr_rating', 5);
                $content['count'] = $request->input('sr_count');
                break;

            case 'text_typing':
                $content['prefix'] = $request->input('tt_prefix');
                $content['strings'] = $request->input('tt_strings'); // Comma separated
                $content['suffix'] = $request->input('tt_suffix');
                break;

            case 'elegant_card':
                if ($request->hasFile('ec_image')) {
                    $name = time() . '_ec_' . $request->file('ec_image')->getClientOriginalName();
                    $request->file('ec_image')->move(public_path('uploads/landing/blocks'), $name);
                    $content['image'] = $name;
                }
                $content['title'] = $request->input('ec_title');
                $content['text'] = $request->input('ec_text');
                $content['btn_text'] = $request->input('ec_btn_text');
                $content['btn_url'] = $request->input('ec_btn_url');
                break;

            case 'syntax_highlighter':
                $content['language'] = $request->input('sh_lang', 'javascript');
                $content['code'] = $request->input('sh_code');
                break;

            case 'ribbon':
                $content['text'] = $request->input('rb_text', 'Special Offer');
                $content['position'] = $request->input('rb_pos', 'top-left');
                $content['color'] = $request->input('rb_color', '#ff0000');
                break;

            case 'header_classic':
                if ($request->hasFile('h_logo')) {
                    $name = time() . '_logo_' . $request->file('h_logo')->getClientOriginalName();
                    $request->file('h_logo')->move(public_path('uploads/landing/blocks'), $name);
                    $content['logo'] = $name;
                }
                $content['menu_items'] = [];
                if ($request->has('h_menu_titles')) {
                    foreach ($request->input('h_menu_titles') as $k => $title) {
                        $content['menu_items'][] = [
                            'title' => $title,
                            'url' => $request->input('h_menu_urls')[$k] ?? '#'
                        ];
                    }
                }
                $content['sticky'] = $request->has('h_sticky');
                $content['phone'] = $request->input('h_phone');
                $content['email'] = $request->input('h_email');
                break;

            case 'footer_classic':
                if ($request->hasFile('f_logo')) {
                    $name = time() . '_flogo_' . $request->file('f_logo')->getClientOriginalName();
                    $request->file('f_logo')->move(public_path('uploads/landing/blocks'), $name);
                    $content['logo'] = $name;
                }
                $content['description'] = $request->input('f_description');
                $content['copyright'] = $request->input('f_copyright');
                $content['links'] = [];
                if ($request->has('f_link_titles')) {
                    foreach ($request->input('f_link_titles') as $k => $title) {
                        $content['links'][] = [
                            'title' => $title,
                            'url' => $request->input('f_link_urls')[$k] ?? '#'
                        ];
                    }
                }
                $content['phone'] = $request->input('f_phone');
                $content['email'] = $request->input('f_email');
                $content['address'] = $request->input('f_address');
                break;

            case 'banner_slider':
                if ($request->hasFile('bs_images')) {
                    $content['slides'] = [];
                    foreach ($request->file('bs_images') as $image) {
                        $name = time() . '_' . uniqid() . '_bs_' . $image->getClientOriginalName();
                        $image->move(public_path('uploads/landing/blocks'), $name);
                        $content['slides'][] = ['image' => $name];
                    }
                }
                break;

            case 'section_shape':
                $content['shape_type'] = $request->input('shape_type', 'wave');
                $content['shape_color'] = $request->input('shape_color', '#ffffff');
                $content['is_bottom'] = $request->has('shape_is_bottom');
                break;

            case 'product_grid':
                $content['title'] = $request->input('title', 'Our Products');
                $content['product_ids'] = $request->input('pg_product_ids', []);
                break;


            case 'custom_page':
                $content['title'] = $request->input('cp_title');
                $content['content'] = $request->input('cp_content');
                break;

            case 'call_to_action':
                $content['title'] = $request->input('cta_title');
                $content['subtitle'] = $request->input('cta_subtitle');
                $content['btn_text'] = $request->input('cta_btn_text');
                break;

            case 'product_hero':
                $content['title'] = $request->input('ph_title');
                $content['show_video'] = $request->has('ph_show_video');
                $content['show_image'] = $request->has('ph_show_image');
                break;

            case 'product_price':
                $content['title'] = $request->input('pp_title', 'আজকের বিশেষ দাম:');
                break;

            case 'product_feature_list':
                $content['items'] = [];
                if ($request->has('pfl_titles')) {
                    foreach ($request->input('pfl_titles') as $k => $title) {
                        $content['items'][] = [
                            'title' => $title,
                        ];
                    }
                }
                break;

            case 'rihanu_checkout':
                $content['title'] = $request->input('rc_title', 'অর্ডার করতে নিচের ফর্মে আপনার তথ্য দিন');
                $content['product_ids'] = $request->input('rc_product_ids', []);
                break;
        }

        return $content;
    }

    /**
     * Delete a block.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $blocks = LandingPageBlock::whereIn('id', $ids)->get();
            foreach ($blocks as $block) {
                // Optionally delete images in JSON content here
                $this->destroyBlock($block->id);
            }
        }
        return response()->json(['success' => true]);
    }

    public function destroyBlock($id)
    {
        $block = LandingPageBlock::findOrFail($id);

        // Remove image if exists
        if (isset($block->content['image']) && $block->content['image']) {
            $path = public_path('uploads/landing/blocks/' . $block->content['image']);
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        
        // Remove multiple images if custom_reviews_slider or gallery
        if (isset($block->content['images']) && is_array($block->content['images'])) {
            foreach ($block->content['images'] as $imgName) {
                $path = public_path('uploads/landing/blocks/' . $imgName);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
        }

        $block->delete();
        if (request()->ajax()) return response()->json(['success' => true]);
        return redirect()->back()->with('success', 'Block deleted successfully!');
    }

    /**
     * Reorder blocks via AJAX.
     */
    public function reorderBlocks(Request $request)
    {
        $order = $request->input('order');
        if (is_array($order)) {
            foreach ($order as $index => $id) {
                LandingPageBlock::where('id', $id)->update(['order' => $index + 1]);
            }
        }
        return response()->json(['success' => true]);
    }

    /**
     * Update global landing page settings from builder.
     */
    public function updateSettings(Request $request, $id)
    {
        $landing = LandingPage::findOrFail($id);
        $landing->update([
            'title'         => $request->input('title', $landing->title),
            'slug'          => $request->input('slug', $landing->slug),
            'gtm_id'        => $request->input('gtm_id', $landing->gtm_id),
            'fb_pixel_id'   => $request->input('fb_pixel_id', $landing->fb_pixel_id),
            'is_full_width' => $request->input('is_full_width') == '1',
            'bg_color'      => $request->input('bg_color'),
            'text_color'    => $request->input('text_color'),
            'btn_color'     => $request->input('btn_color'),
        ]);

        return redirect()->back()->with('success', 'Page settings updated successfully!');
    }

    /**
     * Switch theme/template for an existing landing page.
     * Replaces all current blocks with blocks from the source template.
     */
    public function switchTheme(Request $request, $landingId)
    {
        $landing = LandingPage::findOrFail($landingId);
        $sourceTemplateId = $request->input('template_id');
        
        $source = LandingPage::with('blocks')->where('is_template', true)->findOrFail($sourceTemplateId);

        // Delete all current blocks
        foreach ($landing->blocks as $block) {
            $this->destroyBlock($block->id);
        }

        // Copy blocks from source
        foreach ($source->blocks as $block) {
            $newBlock = $block->replicate();
            $newBlock->landing_page_id = $landing->id;
            $newBlock->save();
        }

        // Update landing page settings if needed (bg_color, etc.)
        $landing->update([
            'template_name' => $source->template_name,
            'bg_color'      => $source->bg_color,
            'text_color'    => $source->text_color,
            'btn_color'     => $source->btn_color,
            'is_full_width' => $source->is_full_width,
        ]);

        return redirect()->back()->with('success', 'Theme applied successfully! Your blocks have been updated.');
    }
}
