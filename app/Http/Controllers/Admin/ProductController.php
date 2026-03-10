<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  PRODUCT CRUD
    // ══════════════════════════════════════════════════════════════

    public function index()
    {
        $products = Product::with('category', 'subCategory', 'childSubCategory')
                        ->latest()->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'current_price' => 'required|numeric|min:0',
            'description'   => 'required',
            'feature_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ── Feature Image ──────────────────────────────────────────
        $featureImageName = null;
        if ($request->hasFile('feature_image')) {
            $img              = $request->file('feature_image');
            $featureImageName = time() . '_' . $img->getClientOriginalName();
            $img->move(public_path('uploads/products'), $featureImageName);
        }

        // ── Gallery Images ─────────────────────────────────────────
        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            $files  = $request->file('gallery_images');
            $colors = $request->input('gallery_color', []);
            $sizes  = $request->input('gallery_size', []);
            foreach ($files as $i => $file) {
                if ($file && $file->isValid()) {
                    $gName = time() . rand(100, 999) . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/products'), $gName);
                    $galleryImages[] = [
                        'image' => $gName,
                        'color' => $colors[$i] ?? null,
                        'size'  => $sizes[$i]  ?? null,
                    ];
                }
            }
        }

        // ── Product File ───────────────────────────────────────────
        $productFile = null;
        if ($request->hasFile('product_file')) {
            $file        = $request->file('product_file');
            $productFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $productFile);
        }

        // ── Variants ───────────────────────────────────────────────
        $variants = [];
        if ($request->has('variant_size')) {
            foreach ($request->variant_size as $i => $size) {
                $color  = $request->variant_color[$i] ?? null;
                $vStock = $request->variant_stock[$i] ?? 0;
                $vPrice = $request->variant_price[$i] ?? null;
                if (!empty(trim($size)) || !empty(trim($color ?? ''))) {
                    $variants[] = [
                        'size'  => trim($size),
                        'color' => trim($color ?? ''),
                        'stock' => (int) $vStock,
                        'price' => $vPrice ? (float) $vPrice : null,
                    ];
                }
            }
        }

        // ── Feature Tags ───────────────────────────────────────────
        $featureTags = [];
        if ($request->has('tag_keyword')) {
            foreach ($request->tag_keyword as $i => $keyword) {
                if (!empty(trim($keyword))) {
                    $featureTags[] = [
                        'keyword' => trim($keyword),
                        'color'   => $request->tag_color[$i] ?? '#000000',
                    ];
                }
            }
        }

        // ── Tags ───────────────────────────────────────────────────
        $tags = [];
        if ($request->filled('tags')) {
            $raw  = is_array($request->tags) ? implode(',', $request->tags) : $request->tags;
            $tags = array_values(array_filter(array_map('trim', explode(',', $raw))));
        }

        // ── Stock (unlimited support) ──────────────────────────────
        $isUnlimited = $request->boolean('is_unlimited');
        $stock       = $isUnlimited ? null : (int) $request->stock;

        // ── SKU (auto-generate if empty) ───────────────────────────
        $sku = $request->filled('sku')
            ? trim($request->sku)
            : strtoupper(Str::random(3)) . rand(100000, 999999) . strtolower(Str::random(2));

        Product::create([
            'name'                  => $request->name,
            'slug'                  => Str::slug($request->name),
            'sku'                   => $sku,
            'vendor'                => $request->vendor ?: null,
            'category_id'           => $request->category_id,
            'sub_category_id'       => $request->sub_category_id       ?: null,
            'child_sub_category_id' => $request->child_sub_category_id ?: null,
            'product_type'          => $request->product_type ?: 'digital',
            'upload_type'           => $request->upload_type           ?: 'file',
            'product_file'          => $productFile,
            'product_url'           => $request->product_url           ?: null,
            'description'           => $request->description,
            'return_policy'         => $request->return_policy         ?: null,
            'feature_image'         => $featureImageName,
            'gallery_images'        => $galleryImages,
            'variants'              => $variants,
            'current_price'         => $request->current_price,
            'discount_price'        => $request->discount_price        ?: null,
            'stock'                 => $stock,
            'is_unlimited'          => $isUnlimited,
            'youtube_url'           => $request->youtube_url           ?: null,
            'tags'                  => $tags,
            'feature_tags'          => $featureTags,
            'status'                => 'active',
            'is_highlighted'        => false,
        ]);

        return redirect()->route('products.index')
                         ->with('success', 'Product Created Successfully');
    }

    public function edit(string $id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::orderBy('category_name')->get();

        $subCategories = $product->category_id
            ? SubCategory::where('category_id', $product->category_id)->orderBy('sub_name')->get()
            : collect();

        $childSubCategories = $product->sub_category_id
            ? ChildSubCategory::where('sub_category_id', $product->sub_category_id)->orderBy('child_sub_name')->get()
            : collect();

        return view('admin.product.edit', compact(
            'product', 'categories', 'subCategories', 'childSubCategories'
        ));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'current_price' => 'required|numeric|min:0',
            'description'   => 'required',
        ]);

        // ── Feature Image ──────────────────────────────────────────
        $featureImageName = $product->feature_image;
        if ($request->hasFile('feature_image')) {
            if ($featureImageName && file_exists(public_path('uploads/products/' . $featureImageName))) {
                unlink(public_path('uploads/products/' . $featureImageName));
            }
            $img              = $request->file('feature_image');
            $featureImageName = time() . '_' . $img->getClientOriginalName();
            $img->move(public_path('uploads/products'), $featureImageName);
        }

        // ── Gallery — keep existing + append new ───────────────────
        $galleryImages = $product->gallery_images ?? [];
        $keepImages    = $request->input('keep_gallery', []);
        $galleryImages = array_values(array_filter($galleryImages, function ($item) use ($keepImages) {
            $imgName = is_array($item) ? $item['image'] : $item;
            return in_array($imgName, $keepImages);
        }));

        if ($request->hasFile('gallery_images')) {
            $files  = $request->file('gallery_images');
            $colors = $request->input('gallery_color', []);
            $sizes  = $request->input('gallery_size', []);
            foreach ($files as $i => $file) {
                if ($file && $file->isValid()) {
                    $gName = time() . rand(100, 999) . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/products'), $gName);
                    $galleryImages[] = [
                        'image' => $gName,
                        'color' => $colors[$i] ?? null,
                        'size'  => $sizes[$i]  ?? null,
                    ];
                }
            }
        }

        // ── Product File ───────────────────────────────────────────
        $productFile = $product->product_file;
        if ($request->hasFile('product_file')) {
            if ($productFile && file_exists(public_path('uploads/products/' . $productFile))) {
                unlink(public_path('uploads/products/' . $productFile));
            }
            $file        = $request->file('product_file');
            $productFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $productFile);
        }

        // ── Variants ───────────────────────────────────────────────
        $variants = [];
        if ($request->has('variant_size')) {
            foreach ($request->variant_size as $i => $size) {
                $color  = $request->variant_color[$i] ?? null;
                $vStock = $request->variant_stock[$i] ?? 0;
                $vPrice = $request->variant_price[$i] ?? null;
                if (!empty(trim($size)) || !empty(trim($color ?? ''))) {
                    $variants[] = [
                        'size'  => trim($size),
                        'color' => trim($color ?? ''),
                        'stock' => (int) $vStock,
                        'price' => $vPrice ? (float) $vPrice : null,
                    ];
                }
            }
        }

        // ── Feature Tags ───────────────────────────────────────────
        $featureTags = [];
        if ($request->has('tag_keyword')) {
            foreach ($request->tag_keyword as $i => $keyword) {
                if (!empty(trim($keyword))) {
                    $featureTags[] = [
                        'keyword' => trim($keyword),
                        'color'   => $request->tag_color[$i] ?? '#000000',
                    ];
                }
            }
        }

        // ── Tags ───────────────────────────────────────────────────
        $tags = [];
        if ($request->filled('tags')) {
            $raw  = is_array($request->tags) ? implode(',', $request->tags) : $request->tags;
            $tags = array_values(array_filter(array_map('trim', explode(',', $raw))));
        }

        // ── Stock (unlimited support) ──────────────────────────────
        $isUnlimited = $request->boolean('is_unlimited');
        $stock       = $isUnlimited ? null : (int) $request->stock;

        $product->update([
            'name'                  => $request->name,
            'slug'                  => Str::slug($request->name),
            'sku'                   => $request->filled('sku') ? trim($request->sku) : $product->sku,
            'vendor'                => $request->vendor ?: null,
            'category_id'           => $request->category_id,
            'sub_category_id'       => $request->sub_category_id       ?: null,
            'child_sub_category_id' => $request->child_sub_category_id ?: null,
            'product_type'          => $request->product_type ?: $product->product_type,
            'upload_type'           => $request->upload_type           ?: $product->upload_type,
            'product_file'          => $productFile,
            'product_url'           => $request->product_url           ?: null,
            'description'           => $request->description,
            'return_policy'         => $request->return_policy         ?: null,
            'feature_image'         => $featureImageName,
            'gallery_images'        => $galleryImages,
            'variants'              => $variants,
            'current_price'         => $request->current_price,
            'discount_price'        => $request->discount_price        ?: null,
            'stock'                 => $stock,
            'is_unlimited'          => $isUnlimited,
            'youtube_url'           => $request->youtube_url           ?: null,
            'tags'                  => $tags,
            'feature_tags'          => $featureTags,
        ]);

        return redirect()->route('products.index')
                         ->with('success', 'Product Updated Successfully');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->feature_image && file_exists(public_path('uploads/products/' . $product->feature_image))) {
            unlink(public_path('uploads/products/' . $product->feature_image));
        }
        foreach ($product->gallery_images ?? [] as $item) {
            $imgName = is_array($item) ? $item['image'] : $item;
            if ($imgName && file_exists(public_path('uploads/products/' . $imgName))) {
                unlink(public_path('uploads/products/' . $imgName));
            }
        }
        if ($product->product_file && file_exists(public_path('uploads/products/' . $product->product_file))) {
            unlink(public_path('uploads/products/' . $product->product_file));
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully');
    }

    // ══════════════════════════════════════════════════════════════
    //  AJAX HELPERS
    // ══════════════════════════════════════════════════════════════

    public function getSubCategories(Request $request)
    {
        $categoryId = (int) $request->input('category_id', 0);
        if (!$categoryId) return response()->json([], 200);
        $subs = SubCategory::where('category_id', $categoryId)
                    ->orderBy('sub_name')
                    ->get(['id', 'sub_name']);
        return response()->json($subs, 200);
    }

    public function getChildCategories(Request $request)
    {
        $subCategoryId = (int) $request->input('sub_category_id', 0);
        if (!$subCategoryId) return response()->json([], 200);
        $children = ChildSubCategory::where('sub_category_id', $subCategoryId)
                        ->orderBy('child_sub_name')
                        ->get(['id', 'child_sub_name']);
        return response()->json($children, 200);
    }

    // ══════════════════════════════════════════════════════════════
    //  STATUS TOGGLE
    // ══════════════════════════════════════════════════════════════

    public function toggleStatus(string $id)
    {
        $product         = Product::findOrFail($id);
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();
        return redirect()->back()->with('success', 'Product status updated');
    }

    // ══════════════════════════════════════════════════════════════
    //  DEACTIVATED LIST
    // ══════════════════════════════════════════════════════════════

    public function deactivated()
    {
        $products = Product::with('category', 'subCategory', 'childSubCategory')
                        ->where('status', 'inactive')
                        ->latest()->get();
        return view('admin.product.deactivated', compact('products'));
    }

    // ══════════════════════════════════════════════════════════════
    //  CATALOG
    // ══════════════════════════════════════════════════════════════

    public function catalogIndex()
    {
        $products = Product::with('category', 'subCategory')
                        ->latest()->get();
        return view('admin.catalog.catalog', compact('products'));
    }

    /**
     * Toggle highlighted status via POST (from catalog page).
     */
    public function catalogHighlight(Request $request, string $id)
    {
        $product                 = Product::findOrFail($id);
        $product->is_highlighted = !$product->is_highlighted;
        $product->save();

        $msg = $product->is_highlighted
            ? 'Product highlighted successfully'
            : 'Product removed from highlights';

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Remove a product from catalog (set in_catalog = false).
     * Does NOT delete the product.
     */
    public function catalogRemove(Request $request, string $id)
    {
        $product              = Product::findOrFail($id);
        $product->in_catalog  = false;
        $product->is_highlighted = false;
        $product->save();

        return redirect()->back()->with('success', 'Product removed from catalog');
    }

    /**
     * Add a product to catalog (set in_catalog = true).
     */
    public function catalogAdd(string $id)
    {
        $product             = Product::findOrFail($id);
        $product->in_catalog = true;
        $product->save();

        return redirect()->back()->with('success', 'Product added to catalog');
    }

    /**
     * Show gallery images of a product (JSON — used by View Gallery modal).
     */
    public function catalogGallery(string $id)
    {
        $product = Product::findOrFail($id);
        $gallery = collect($product->gallery_images ?? [])->map(function ($item) {
            $name = is_array($item) ? $item['image'] : $item;
            return [
                'url'   => asset('uploads/products/' . $name),
                'color' => is_array($item) ? ($item['color'] ?? null) : null,
                'size'  => is_array($item) ? ($item['size']  ?? null) : null,
            ];
        })->filter(fn($g) => file_exists(public_path('uploads/products/' . basename($g['url']))));

        return response()->json([
            'product' => $product->name,
            'gallery' => $gallery->values(),
        ]);
    }
}
