<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the landing pages.
     */
    public function index()
    {
        $landings = LandingPage::with('product')
            ->where('is_template', false)
            ->orderByDesc('order')
            ->paginate(20);
        
        $templates_count = LandingPage::where('is_template', true)->count();
        
        return view('admin.landing.index', compact('landings', 'templates_count'));
    }

    /**
     * Display the template library.
     */
    public function templates()
    {
        $templates = LandingPage::where('is_template', true)
            ->orderByDesc('created_at')
            ->get();
        return view('admin.landing.templates', compact('templates'));
    }

    /**
     * Show the form for creating a new landing page.
     */
    public function create(Request $request)
    {
        $products = Product::where('status', 'active')
            ->select('id', 'name')
            ->get();
            
        $from_template_id = $request->input('template_id');
        $source_template = null;
        if ($from_template_id) {
            $source_template = LandingPage::where('is_template', true)->find($from_template_id);
        }

        $templates = LandingPage::where('is_template', true)->get();
        
        return view('admin.landing.create', compact('products', 'templates', 'source_template'));
    }

    /**
     * Store a newly created landing page.
     */
    public function store(Request $request)
    {
        // Ensure upload directory exists
        if (!File::exists(public_path('uploads/landing'))) {
            File::makeDirectory(public_path('uploads/landing'), 0755, true);
        }

        // Limit to 500 pages
        if (LandingPage::count() >= 500) {
            return redirect()->back()->with('error', 'আপনি সর্বোচ্চ ৫০০টি ল্যান্ডিং পেজ তৈরি করতে পারেন।');
        }

        $request->validate([
            'title'         => 'nullable|string|max:255',
            'slug'          => 'nullable|string|max:255|unique:landing_pages,slug',
            'product_id'    => 'nullable|exists:products,id',
            'product_ids'   => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'template_name' => 'required|string',
            'bg_color'      => 'nullable|string',
            'text_color'    => 'nullable|string',
            'btn_color'     => 'nullable|string',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'review_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_template'   => 'nullable',
        ]);

        $data = $request->except(['feature_image', 'review_image', 'preview_image', 'is_template']);
        $data['is_template'] = $request->has('is_template');
        if (empty($request->slug)) {
            $data['slug'] = $request->title ? Str::slug($request->title) : 'lp-' . rand(1000, 9999);
        } else {
            $data['slug'] = Str::slug($request->slug);
        }
        $data['product_ids'] = $request->input('product_ids', []);

        if ($request->hasFile('feature_image')) {
            $name = time() . '_feature_' . $request->file('feature_image')->getClientOriginalName();
            $request->file('feature_image')->move(public_path('uploads/landing'), $name);
            $data['feature_image'] = $name;
        }

        if ($request->hasFile('review_image')) {
            $name = time() . '_review_' . $request->file('review_image')->getClientOriginalName();
            $request->file('review_image')->move(public_path('uploads/landing'), $name);
            $data['review_image'] = $name;
        }

        if ($request->hasFile('preview_image')) {
            $name = time() . '_preview_' . $request->file('preview_image')->getClientOriginalName();
            $request->file('preview_image')->move(public_path('uploads/landing'), $name);
            $data['preview_image'] = $name;
        }

        // Determine order
        $maxOrder = LandingPage::max('order') ?? 0;
        $data['order'] = $maxOrder + 1;

        $landing = LandingPage::create($data);

        // If created from a template, copy blocks
        if ($request->input('source_template_id')) {
            $source = LandingPage::with('blocks')->find($request->input('source_template_id'));
            if ($source) {
                foreach ($source->blocks as $block) {
                    $newBlock = $block->replicate();
                    $newBlock->landing_page_id = $landing->id;
                    $newBlock->save();
                }
            }
        }

        return redirect()->route('admin.landing-pages.index')->with('success', 'Landing Page Created Successfully!');
    }

    /**
     * Show the form for editing the specified landing page.
     */
    public function edit($id)
    {
        $landing = LandingPage::findOrFail($id);
        $products = Product::where('status', 'active')
            ->select('id', 'name')
            ->get();
        return view('admin.landing.edit', compact('landing', 'products'));
    }

    /**
     * Update the specified landing page.
     */
    public function update(Request $request, $id)
    {
        // Ensure upload directory exists
        if (!File::exists(public_path('uploads/landing'))) {
            File::makeDirectory(public_path('uploads/landing'), 0755, true);
        }

        $landing = LandingPage::findOrFail($id);

        $request->validate([
            'title'         => 'nullable|string|max:255',
            'slug'          => 'nullable|string|max:255|unique:landing_pages,slug,' . $id,
            'product_id'    => 'nullable|exists:products,id',
            'product_ids'   => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'template_name' => 'required|string',
            'bg_color'      => 'nullable|string',
            'text_color'    => 'nullable|string',
            'btn_color'     => 'nullable|string',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'review_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_template'   => 'nullable',
        ]);

        $data = $request->except(['feature_image', 'review_image', 'preview_image', 'is_template']);
        $data['is_template'] = $request->has('is_template');
        if (empty($request->slug)) {
            $data['slug'] = $request->title ? Str::slug($request->title) : 'lp-' . rand(1000, 9999);
        } else {
            $data['slug'] = Str::slug($request->slug);
        }
        $data['product_ids'] = $request->input('product_ids', []);

        if ($request->hasFile('feature_image')) {
            if ($landing->feature_image && File::exists(public_path('uploads/landing/' . $landing->feature_image))) {
                File::delete(public_path('uploads/landing/' . $landing->feature_image));
            }
            $name = time() . '_feature_' . $request->file('feature_image')->getClientOriginalName();
            $request->file('feature_image')->move(public_path('uploads/landing'), $name);
            $data['feature_image'] = $name;
        }

        if ($request->hasFile('review_image')) {
            if ($landing->review_image && File::exists(public_path('uploads/landing/' . $landing->review_image))) {
                File::delete(public_path('uploads/landing/' . $landing->review_image));
            }
            $name = time() . '_review_' . $request->file('review_image')->getClientOriginalName();
            $request->file('review_image')->move(public_path('uploads/landing'), $name);
            $data['review_image'] = $name;
        }

        if ($request->hasFile('preview_image')) {
            if ($landing->preview_image && File::exists(public_path('uploads/landing/' . $landing->preview_image))) {
                File::delete(public_path('uploads/landing/' . $landing->preview_image));
            }
            $name = time() . '_preview_' . $request->file('preview_image')->getClientOriginalName();
            $request->file('preview_image')->move(public_path('uploads/landing'), $name);
            $data['preview_image'] = $name;
        }

        $landing->update($data);
        return redirect()->route('admin.landing.index')->with('success', 'Landing Page Updated Successfully!');
    }

    /**
     * Delete the specified landing page.
     */
    public function destroy($id)
    {
        $landing = LandingPage::findOrFail($id);
        if ($landing->feature_image && File::exists(public_path('uploads/landing/' . $landing->feature_image))) {
            File::delete(public_path('uploads/landing/' . $landing->feature_image));
        }
        if ($landing->review_image && File::exists(public_path('uploads/landing/' . $landing->review_image))) {
            File::delete(public_path('uploads/landing/' . $landing->review_image));
        }
        $landing->delete();
        return redirect()->back()->with('success', 'Landing Page Deleted Successfully!');
    }

    /**
     * Reorder landing pages via drag‑and‑drop (AJAX).
     */
    public function reorder(Request $request)
    {
        $order = $request->input('order'); // expected: array of ids in new order
        if (is_array($order)) {
            foreach ($order as $position => $id) {
                LandingPage::where('id', $id)->update(['order' => $position + 1]);
            }
        }
        return response()->json(['status' => 'ok']);
    }
    /**
     * Duplicate the specified landing page including all blocks.
     */
    public function duplicate($id)
    {
        $original = LandingPage::with('blocks')->findOrFail($id);
        
        $new = $original->replicate();
        $new->title = $original->title . ' (Copy)';
        $new->slug = $original->slug . '-copy-' . time();
        $new->order = (LandingPage::max('order') ?? 0) + 1;
        $new->save();

        foreach ($original->blocks as $block) {
            $newBlock = $block->replicate();
            $newBlock->landing_page_id = $new->id;
            $newBlock->save();
        }

        return redirect()->route('admin.landing-pages.index')->with('success', 'Landing Page Duplicated Successfully!');
    }
}
