<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProduct;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AffiliateproductController extends Controller
{
    // ══════════════════════════════════════════════════════════════════
    // INDEX
    // ══════════════════════════════════════════════════════════════════
    public function index()
    {
        $products = AffiliateProduct::with('category')->latest()->paginate(10);
        return view('admin.affiliateproduct.index', compact('products'));
    }

    // ══════════════════════════════════════════════════════════════════
    // CREATE
    // ══════════════════════════════════════════════════════════════════
    public function create()
    {
        $categories = Category::all();
        return view('admin.affiliateproduct.create', compact('categories'));
    }

    // ══════════════════════════════════════════════════════════════════
    // STORE
    // ══════════════════════════════════════════════════════════════════
    public function store(Request $request)
    {
        $request->validate([
            'product_name'           => 'required|string|max:255',
            'product_sku'            => 'required|string|unique:affiliate_products,product_sku',
            'product_affiliate_link' => 'required|url',
            'category_id'            => 'required|exists:categories,id',
            'sub_category_id'        => 'nullable',
            'child_category_id'      => 'nullable',
            'product_stock'          => 'nullable|integer|min:0',
            'product_description'    => 'required|string',
            'buy_return_policy'      => 'required|string',
            'feature_image_source'   => 'required|in:file,url',
            'feature_image'          => 'nullable|image|max:2048',
            'gallery_images.*'       => 'nullable|image|max:2048',
            'current_price'          => 'required|numeric|min:0',
            'discount_price'         => 'nullable|numeric|min:0',
            'youtube_video_url'      => 'nullable|url',
        ]);

        // Feature image
        $featureImagePath = null;
        if ($request->feature_image_source === 'file' && $request->hasFile('feature_image')) {
            $featureImagePath = $request->file('feature_image')->store('uploads/products', 'public');
        } elseif ($request->feature_image_source === 'url') {
            $featureImagePath = $request->input('feature_image_url');
        }

        // Gallery
        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $img) {
                $galleryPaths[] = $img->store('uploads/products', 'public');
            }
        }

        // Feature Tags
        $featureTags = [];
        if ($request->filled('tag_keyword')) {
            foreach ($request->tag_keyword as $i => $keyword) {
                if (!empty(trim($keyword))) {
                    $featureTags[] = [
                        'keyword' => trim($keyword),
                        'color'   => $request->tag_color[$i] ?? '#000000',
                    ];
                }
            }
        }

        AffiliateProduct::create([
            'product_name'            => $request->product_name,
            'product_sku'             => $request->product_sku,
            'product_affiliate_link'  => $request->product_affiliate_link,
            'category_id'             => $request->category_id,
            'sub_category_id'         => $request->sub_category_id ?: null,
            'child_category_id'       => $request->child_category_id ?: null,
            'product_stock'           => $request->product_stock,
            'allow_measurement'       => $request->boolean('allow_measurement'),
            'product_measurement'     => $request->boolean('allow_measurement') ? $request->product_measurement : null,
            'allow_condition'         => $request->boolean('allow_condition'),
            'product_condition'       => $request->boolean('allow_condition') ? $request->product_condition : null,
            'allow_shipping_time'     => $request->boolean('allow_shipping_time'),
            'estimated_shipping_time' => $request->boolean('allow_shipping_time') ? $request->estimated_shipping_time : null,
            'allow_colors'            => $request->boolean('allow_colors'),
            'product_colors'          => $request->boolean('allow_colors') ? $request->product_colors : null,
            'allow_sizes'             => $request->boolean('allow_sizes'),
            'product_sizes'           => $request->boolean('allow_sizes') ? $request->product_sizes : null,
            'product_description'     => $request->product_description,
            'buy_return_policy'       => $request->buy_return_policy,
            'feature_image_source'    => $request->feature_image_source,
            'feature_image'           => $featureImagePath,
            'gallery_images'          => !empty($galleryPaths) ? $galleryPaths : null,
            'current_price'           => $request->current_price,
            'discount_price'          => $request->discount_price,
            'youtube_video_url'       => $request->youtube_video_url,
            'feature_tags'            => !empty($featureTags) ? $featureTags : null,
            'tags'                    => $request->tags,
            'allow_seo'               => $request->boolean('allow_seo'),
            'meta_tags'               => $request->boolean('allow_seo') ? $request->meta_tags : null,
            'meta_description'        => $request->boolean('allow_seo') ? $request->meta_description : null,
            'status'                  => 'active',
        ]);

        return redirect()->route('affiliateproduct.index')
            ->with('success', 'Affiliate product created successfully!');
    }

    // ══════════════════════════════════════════════════════════════════
    // SHOW
    // ══════════════════════════════════════════════════════════════════
    public function show(string $id)
    {
        $product = AffiliateProduct::with(['category', 'subCategory', 'childCategory'])->findOrFail($id);
        return view('admin.affiliateproduct.show', compact('product'));
    }

    // ══════════════════════════════════════════════════════════════════
    // EDIT
    // ══════════════════════════════════════════════════════════════════
    public function edit(string $id)
    {
        $product         = AffiliateProduct::findOrFail($id);
        $categories      = Category::all();
        $subCategories   = SubCategory::where('category_id', $product->category_id)->get();
        $childCategories = ChildSubCategory::where('sub_category_id', $product->sub_category_id)->get();

        return view('admin.affiliateproduct.edit', compact(
            'product', 'categories', 'subCategories', 'childCategories'
        ));
    }

    // ══════════════════════════════════════════════════════════════════
    // UPDATE
    // ══════════════════════════════════════════════════════════════════
    public function update(Request $request, string $id)
    {
        $product = AffiliateProduct::findOrFail($id);

        $request->validate([
            'product_name'           => 'required|string|max:255',
            'product_sku'            => 'required|string|unique:affiliate_products,product_sku,' . $id,
            'product_affiliate_link' => 'required|url',
            'category_id'            => 'required|exists:categories,id',
            'sub_category_id'        => 'nullable',
            'child_category_id'      => 'nullable',
            'product_stock'          => 'nullable|integer|min:0',
            'product_description'    => 'required|string',
            'buy_return_policy'      => 'required|string',
            'feature_image_source'   => 'required|in:file,url',
            'feature_image'          => 'nullable|image|max:2048',
            'gallery_images.*'       => 'nullable|image|max:2048',
            'current_price'          => 'required|numeric|min:0',
            'discount_price'         => 'nullable|numeric|min:0',
            'youtube_video_url'      => 'nullable|url',
        ]);

        // Feature image
        $featureImagePath = $product->feature_image;
        if ($request->feature_image_source === 'file' && $request->hasFile('feature_image')) {
            if ($product->feature_image && !str_starts_with($product->feature_image, 'http')) {
                Storage::disk('public')->delete($product->feature_image);
            }
            $featureImagePath = $request->file('feature_image')->store('uploads/products', 'public');
        } elseif ($request->feature_image_source === 'url') {
            $featureImagePath = $request->input('feature_image_url');
        }

        // Gallery — remove marked + add new
        $galleryPaths = $product->gallery_images ?? [];
        if ($request->has('remove_gallery_index')) {
            foreach ($request->remove_gallery_index as $index) {
                if (isset($galleryPaths[$index])) {
                    Storage::disk('public')->delete($galleryPaths[$index]);
                    unset($galleryPaths[$index]);
                }
            }
            $galleryPaths = array_values($galleryPaths);
        }
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $img) {
                $galleryPaths[] = $img->store('uploads/products', 'public');
            }
        }

        // Feature Tags
        $featureTags = [];
        if ($request->filled('tag_keyword')) {
            foreach ($request->tag_keyword as $i => $keyword) {
                if (!empty(trim($keyword))) {
                    $featureTags[] = [
                        'keyword' => trim($keyword),
                        'color'   => $request->tag_color[$i] ?? '#000000',
                    ];
                }
            }
        }

        $product->update([
            'product_name'            => $request->product_name,
            'product_sku'             => $request->product_sku,
            'product_affiliate_link'  => $request->product_affiliate_link,
            'category_id'             => $request->category_id,
            'sub_category_id'         => $request->sub_category_id ?: null,
            'child_category_id'       => $request->child_category_id ?: null,
            'product_stock'           => $request->product_stock,
            'allow_measurement'       => $request->boolean('allow_measurement'),
            'product_measurement'     => $request->boolean('allow_measurement') ? $request->product_measurement : null,
            'allow_condition'         => $request->boolean('allow_condition'),
            'product_condition'       => $request->boolean('allow_condition') ? $request->product_condition : null,
            'allow_shipping_time'     => $request->boolean('allow_shipping_time'),
            'estimated_shipping_time' => $request->boolean('allow_shipping_time') ? $request->estimated_shipping_time : null,
            'allow_colors'            => $request->boolean('allow_colors'),
            'product_colors'          => $request->boolean('allow_colors') ? $request->product_colors : null,
            'allow_sizes'             => $request->boolean('allow_sizes'),
            'product_sizes'           => $request->boolean('allow_sizes') ? $request->product_sizes : null,
            'product_description'     => $request->product_description,
            'buy_return_policy'       => $request->buy_return_policy,
            'feature_image_source'    => $request->feature_image_source,
            'feature_image'           => $featureImagePath,
            'gallery_images'          => !empty($galleryPaths) ? $galleryPaths : null,
            'current_price'           => $request->current_price,
            'discount_price'          => $request->discount_price,
            'youtube_video_url'       => $request->youtube_video_url,
            'feature_tags'            => !empty($featureTags) ? $featureTags : null,
            'tags'                    => $request->tags,
            'allow_seo'               => $request->boolean('allow_seo'),
            'meta_tags'               => $request->boolean('allow_seo') ? $request->meta_tags : null,
            'meta_description'        => $request->boolean('allow_seo') ? $request->meta_description : null,
        ]);

        return redirect()->route('affiliateproduct.index')
            ->with('success', 'Affiliate product updated successfully!');
    }

    // ══════════════════════════════════════════════════════════════════
    // DESTROY
    // ══════════════════════════════════════════════════════════════════
    public function destroy(string $id)
    {
        $product = AffiliateProduct::findOrFail($id);

        if ($product->feature_image && !str_starts_with($product->feature_image, 'http')) {
            Storage::disk('public')->delete($product->feature_image);
        }
        if (!empty($product->gallery_images)) {
            foreach ($product->gallery_images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $product->delete();

        return redirect()->route('affiliateproduct.index')
            ->with('success', 'Affiliate product deleted successfully!');
    }

    // ══════════════════════════════════════════════════════════════════
    // TOGGLE STATUS
    // ══════════════════════════════════════════════════════════════════
    public function toggleStatus(string $id)
    {
        $product = AffiliateProduct::findOrFail($id);
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();
        return response()->json(['success' => true, 'status' => $product->status]);
    }

    // ══════════════════════════════════════════════════════════════════
    // AJAX: GET SUB-CATEGORIES
    // sub_categories table এ column নাম হলো: sub_name
    // ══════════════════════════════════════════════════════════════════
    public function getSubCategories(Request $request)
    {
        $catId = $request->input('category_id');

        if (!$catId) {
            return response()->json([]);
        }

        $subs = SubCategory::where('category_id', $catId)->get();

        $result = $subs->map(function ($sub) {
            return [
                'id'   => $sub->id,
                'name' => $sub->sub_name,   // ← directly use column name
            ];
        });

        return response()->json($result);
    }

    // ══════════════════════════════════════════════════════════════════
    // AJAX: GET CHILD CATEGORIES
    // child_sub_categories table এ column নাম হলো: child_sub_name
    // ══════════════════════════════════════════════════════════════════
    public function getChildCategories(Request $request)
    {
        $subId = $request->input('sub_category_id');

        if (!$subId) {
            return response()->json([]);
        }

        $children = ChildSubCategory::where('sub_category_id', $subId)->get();

        $result = $children->map(function ($child) {
            return [
                'id'   => $child->id,
                'name' => $child->child_sub_name,   // ← directly use column name
            ];
        });

        return response()->json($result);
    }
}
