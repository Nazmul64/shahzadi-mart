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
            ->orderByDesc('order')
            ->paginate(20);
        return view('admin.landing.index', compact('landings'));
    }

    /**
     * Show the form for creating a new landing page.
     */
    public function create()
    {
        $products = Product::where('status', 'active')
            ->select('id', 'name')
            ->get();
        $templates = [
            ['id' => 'landing-1', 'name' => 'Template 1 (Modern Dark)', 'image' => 'https://preview.funnelliner.xyz/landing-38'],
            ['id' => 'landing-2', 'name' => 'Template 2 (Clean Light)', 'image' => 'https://preview.funnelliner.xyz/landing-37'],
            ['id' => 'landing-3', 'name' => 'Template 3 (Bold Red)',    'image' => 'https://preview.funnelliner.xyz/landing-36'],
            ['id' => 'landing-4', 'name' => 'Template 4 (Video Focused)', 'image' => 'https://preview.funnelliner.xyz/landing-35'],
            ['id' => 'landing-5', 'name' => 'Template 5 (Minimal)',       'image' => 'https://preview.funnelliner.xyz/landing-34'],
        ];
        return view('admin.landing.create', compact('products', 'templates'));
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
            'title'         => 'required|string|max:255',
            'slug'          => 'required|string|max:255|unique:landing_pages,slug',
            'product_id'    => 'required|exists:products,id',
            'template_name' => 'required|string',
            'bg_color'      => 'nullable|string',
            'text_color'    => 'nullable|string',
            'btn_color'     => 'nullable|string',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'review_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except(['feature_image', 'review_image']);
        $data['slug'] = Str::slug($request->slug);

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

        // Determine order
        $maxOrder = LandingPage::max('order') ?? 0;
        $data['order'] = $maxOrder + 1;

        LandingPage::create($data);
        return redirect()->route('admin.landing.index')->with('success', 'Landing Page Created Successfully!');
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
        $templates = [
            ['id' => 'landing-1', 'name' => 'Template 1 (Modern Dark)'],
            ['id' => 'landing-2', 'name' => 'Template 2 (Clean Light)'],
            ['id' => 'landing-3', 'name' => 'Template 3 (Bold Red)'],
            ['id' => 'landing-4', 'name' => 'Template 4 (Video Focused)'],
            ['id' => 'landing-5', 'name' => 'Template 5 (Minimal)'],
        ];
        return view('admin.landing.edit', compact('landing', 'products', 'templates'));
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
            'title'         => 'required|string|max:255',
            'slug'          => 'required|string|max:255|unique:landing_pages,slug,' . $id,
            'product_id'    => 'required|exists:products,id',
            'template_name' => 'required|string',
            'bg_color'      => 'nullable|string',
            'text_color'    => 'nullable|string',
            'btn_color'     => 'nullable|string',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'review_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except(['feature_image', 'review_image']);
        $data['slug'] = Str::slug($request->slug);

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
