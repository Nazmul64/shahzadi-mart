<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  ALLOWED IMAGE MIMES & EXTENSIONS
    // ══════════════════════════════════════════════════════════════

    private array $allowedImageMimes = [
        'jpg', 'jpeg', 'png', 'webp', 'gif', 'svg',
    ];

    private array $allowedImageMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
        'image/svg+xml',
    ];

    // ══════════════════════════════════════════════════════════════
    //  HELPER — Upload a single image file
    // ══════════════════════════════════════════════════════════════

    private function uploadImage($file, string $folder = 'uploads/products'): string
    {
        $ext      = strtolower($file->getClientOriginalExtension());
        $filename = time() . rand(100, 9999) . '_' . Str::slug(
                        pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                    ) . '.' . $ext;

        $file->move(public_path($folder), $filename);

        return $filename;
    }

    // ══════════════════════════════════════════════════════════════
    //  HELPER — Delete a file safely
    // ══════════════════════════════════════════════════════════════

    private function deleteFile(?string $filename, string $folder = 'uploads/products'): void
    {
        if ($filename && file_exists(public_path($folder . '/' . $filename))) {
            unlink(public_path($folder . '/' . $filename));
        }
    }

    // ══════════════════════════════════════════════════════════════
    //  IMAGE VALIDATION RULE STRING
    // ══════════════════════════════════════════════════════════════

    private function imageRule(bool $required = true): string
    {
        $mimes = implode(',', $this->allowedImageMimes);
        $rule  = $required ? 'required' : 'nullable';

        return "{$rule}|file|mimes:{$mimes}|max:5120";
    }

    // ══════════════════════════════════════════════════════════════
    //  INDEX
    // ══════════════════════════════════════════════════════════════

    public function index()
    {
        $products = Product::with('category', 'subCategory', 'childSubCategory')
                        ->latest()->get();

        return view('admin.product.index', compact('products'));
    }

    // ══════════════════════════════════════════════════════════════
    //  CREATE / STORE
    // ══════════════════════════════════════════════════════════════

    public function create()
    {
        $categories = Category::orderBy('category_name')->get();

        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $mimes = implode(',', $this->allowedImageMimes);

        $request->validate([
            'name'                 => 'required|string|max:255',
            'category_id'          => 'required|exists:categories,id',
            'current_price'        => 'required|numeric|min:0',
            'description'          => 'required',
            'feature_image'        => "required|file|mimes:{$mimes}|max:5120",
            'gallery_images.*'     => "nullable|file|mimes:{$mimes}|max:5120",
            'flash_sale_price'     => 'nullable|numeric|min:0',
            'flash_sale_starts_at' => 'nullable|date',
            'flash_sale_ends_at'   => 'nullable|date|after_or_equal:flash_sale_starts_at',
        ], [
            'feature_image.mimes'      => "Feature image must be: jpg, jpeg, png, webp, gif, svg.",
            'gallery_images.*.mimes'   => "Gallery images must be: jpg, jpeg, png, webp, gif, svg.",
            'feature_image.max'        => 'Feature image must not exceed 5MB.',
            'gallery_images.*.max'     => 'Each gallery image must not exceed 5MB.',
        ]);

        // ── Feature Image ──────────────────────────────────────────
        $featureImageName = null;
        if ($request->hasFile('feature_image')) {
            $featureImageName = $this->uploadImage($request->file('feature_image'));
        }

        // ── Gallery Images ─────────────────────────────────────────
        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            $files  = $request->file('gallery_images');
            $colors = $request->input('gallery_color', []);
            $sizes  = $request->input('gallery_size', []);

            foreach ($files as $i => $file) {
                if ($file && $file->isValid()) {
                    $gName = $this->uploadImage($file);
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
        $variants = $this->buildVariants($request);

        // ── Feature Tags ───────────────────────────────────────────
        $featureTags = $this->buildFeatureTags($request);

        // ── Tags ───────────────────────────────────────────────────
        $tags = $this->buildTags($request);

        // ── Stock ──────────────────────────────────────────────────
        $isUnlimited = $request->boolean('is_unlimited');
        $stock       = $isUnlimited ? null : (int) $request->stock;

        // ── SKU (auto-generate if empty) ───────────────────────────
        $sku = $request->filled('sku')
            ? trim($request->sku)
            : strtoupper(Str::random(3)) . rand(100000, 999999) . strtolower(Str::random(2));

        // ── Flash Sale ─────────────────────────────────────────────
        [$isFlashSale, $flashSalePrice, $flashSaleStarts, $flashSaleEnds]
            = $this->buildFlashSale($request);

        // ── New Arrival ────────────────────────────────────────────
        $isNewArrival = $request->boolean('is_new_arrival');
        $arrivedAt    = $isNewArrival ? Carbon::now() : null;

        // ── Bestseller ─────────────────────────────────────────────
        $isBestseller = $request->boolean('is_bestseller');
        $bestsellerAt = $isBestseller ? Carbon::now() : null;

        Product::create([
            'name'                  => $request->name,
            'slug'                  => Str::slug($request->name),
            'sku'                   => $sku,
            'vendor'                => $request->vendor                ?: null,
            'category_id'           => $request->category_id,
            'sub_category_id'       => $request->sub_category_id       ?: null,
            'child_sub_category_id' => $request->child_sub_category_id ?: null,
            'product_type'          => $request->product_type          ?: 'digital',
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
            'meta_tags'             => $request->meta_tags             ?: null,
            'meta_description'      => $request->meta_description      ?: null,
            'is_flash_sale'         => $isFlashSale,
            'flash_sale_price'      => $flashSalePrice,
            'flash_sale_starts_at'  => $flashSaleStarts,
            'flash_sale_ends_at'    => $flashSaleEnds,
            'is_new_arrival'        => $isNewArrival,
            'arrived_at'            => $arrivedAt,
            'is_bestseller'         => $isBestseller,
            'bestseller_at'         => $bestsellerAt,
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product Created Successfully');
    }

    // ══════════════════════════════════════════════════════════════
    //  SHOW / EDIT / UPDATE
    // ══════════════════════════════════════════════════════════════

    public function show(string $id)
    {
        return redirect()->route('admin.products.index');
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::orderBy('category_name')->get();

        $subCategories = $product->category_id
            ? SubCategory::where('category_id', $product->category_id)
                         ->orderBy('sub_name')->get()
            : collect();

        $childSubCategories = $product->sub_category_id
            ? ChildSubCategory::where('sub_category_id', $product->sub_category_id)
                               ->orderBy('child_sub_name')->get()
            : collect();

        return view('admin.product.edit', compact(
            'product', 'categories', 'subCategories', 'childSubCategories'
        ));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $mimes = implode(',', $this->allowedImageMimes);

        $request->validate([
            'name'                 => 'required|string|max:255',
            'category_id'          => 'required|exists:categories,id',
            'current_price'        => 'required|numeric|min:0',
            'description'          => 'required',
            'feature_image'        => "nullable|file|mimes:{$mimes}|max:5120",
            'gallery_images.*'     => "nullable|file|mimes:{$mimes}|max:5120",
            'flash_sale_price'     => 'nullable|numeric|min:0',
            'flash_sale_starts_at' => 'nullable|date',
            'flash_sale_ends_at'   => 'nullable|date|after_or_equal:flash_sale_starts_at',
        ], [
            'feature_image.mimes'    => "Feature image must be: jpg, jpeg, png, webp, gif, svg.",
            'gallery_images.*.mimes' => "Gallery images must be: jpg, jpeg, png, webp, gif, svg.",
            'feature_image.max'      => 'Feature image must not exceed 5MB.',
            'gallery_images.*.max'   => 'Each gallery image must not exceed 5MB.',
        ]);

        // ── Feature Image ──────────────────────────────────────────
        $featureImageName = $product->feature_image;
        if ($request->hasFile('feature_image')) {
            $this->deleteFile($featureImageName);
            $featureImageName = $this->uploadImage($request->file('feature_image'));
        }

        // ── Gallery: keep existing + append new ────────────────────
        $existingGallery = $product->gallery_images ?? [];
        $keepImages      = $request->input('keep_gallery', []);

        $galleryImages = array_values(
            array_filter($existingGallery, function ($item) use ($keepImages) {
                $imgName = is_array($item) ? $item['image'] : $item;
                return in_array($imgName, $keepImages);
            })
        );

        if ($request->hasFile('gallery_images')) {
            $files  = $request->file('gallery_images');
            $colors = $request->input('gallery_color', []);
            $sizes  = $request->input('gallery_size', []);

            foreach ($files as $i => $file) {
                if ($file && $file->isValid()) {
                    $gName = $this->uploadImage($file);
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
            $this->deleteFile($productFile);
            $file        = $request->file('product_file');
            $productFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $productFile);
        }

        // ── Variants / Feature Tags / Tags ─────────────────────────
        $variants    = $this->buildVariants($request);
        $featureTags = $this->buildFeatureTags($request);
        $tags        = $this->buildTags($request);

        // ── Stock ──────────────────────────────────────────────────
        $isUnlimited = $request->boolean('is_unlimited');
        $stock       = $isUnlimited ? null : (int) $request->stock;

        // ── Flash Sale ─────────────────────────────────────────────
        [$isFlashSale, $flashSalePrice, $flashSaleStarts, $flashSaleEnds]
            = $this->buildFlashSale($request);

        // ── New Arrival (preserve original arrived_at if already set)
        $isNewArrival = $request->boolean('is_new_arrival');
        $arrivedAt    = match(true) {
            $isNewArrival && !$product->is_new_arrival => Carbon::now(),
            $isNewArrival && $product->is_new_arrival  => $product->arrived_at,
            default                                    => null,
        };

        // ── Bestseller (preserve original bestseller_at if already set)
        $isBestseller = $request->boolean('is_bestseller');
        $bestsellerAt = match(true) {
            $isBestseller && !$product->is_bestseller => Carbon::now(),
            $isBestseller && $product->is_bestseller  => $product->bestseller_at,
            default                                   => null,
        };

        $product->update([
            'name'                  => $request->name,
            'slug'                  => Str::slug($request->name),
            'sku'                   => $request->filled('sku') ? trim($request->sku) : $product->sku,
            'vendor'                => $request->vendor                ?: null,
            'category_id'           => $request->category_id,
            'sub_category_id'       => $request->sub_category_id       ?: null,
            'child_sub_category_id' => $request->child_sub_category_id ?: null,
            'product_type'          => $request->product_type          ?: $product->product_type,
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
            'meta_tags'             => $request->meta_tags             ?: null,
            'meta_description'      => $request->meta_description      ?: null,
            'is_flash_sale'         => $isFlashSale,
            'flash_sale_price'      => $flashSalePrice,
            'flash_sale_starts_at'  => $flashSaleStarts,
            'flash_sale_ends_at'    => $flashSaleEnds,
            'is_new_arrival'        => $isNewArrival,
            'arrived_at'            => $arrivedAt,
            'is_bestseller'         => $isBestseller,
            'bestseller_at'         => $bestsellerAt,
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product Updated Successfully');
    }

    // ══════════════════════════════════════════════════════════════
    //  DESTROY
    // ══════════════════════════════════════════════════════════════

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Delete feature image
        $this->deleteFile($product->feature_image);

        // Delete gallery images
        foreach ($product->gallery_images ?? [] as $item) {
            $imgName = is_array($item) ? $item['image'] : $item;
            $this->deleteFile($imgName);
        }

        // Delete product file
        $this->deleteFile($product->product_file);

        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product Deleted Successfully');
    }

    // ══════════════════════════════════════════════════════════════
    //  AJAX HELPERS
    // ══════════════════════════════════════════════════════════════

    public function getSubCategories(Request $request)
    {
        $categoryId = (int) $request->input('category_id', 0);

        if (!$categoryId) {
            return response()->json([], 200);
        }

        $subs = SubCategory::where('category_id', $categoryId)
                    ->orderBy('sub_name')
                    ->get(['id', 'sub_name']);

        return response()->json($subs, 200);
    }

    public function getChildCategories(Request $request)
    {
        $subCategoryId = (int) $request->input('sub_category_id', 0);

        if (!$subCategoryId) {
            return response()->json([], 200);
        }

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

    public function catalogAdd(string $id)
    {
        $product             = Product::findOrFail($id);
        $product->in_catalog = true;
        $product->save();

        return redirect()->back()->with('success', 'Product added to catalog');
    }

    public function catalogRemove(Request $request, string $id)
    {
        $product                 = Product::findOrFail($id);
        $product->in_catalog     = false;
        $product->is_highlighted = false;
        $product->save();

        return redirect()->back()->with('success', 'Product removed from catalog');
    }

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

    public function catalogGallery(string $id)
    {
        $product = Product::findOrFail($id);

        $gallery = collect($product->gallery_images ?? [])
            ->map(function ($item) {
                $name = is_array($item) ? $item['image'] : $item;
                return [
                    'url'   => asset('uploads/products/' . $name),
                    'color' => is_array($item) ? ($item['color'] ?? null) : null,
                    'size'  => is_array($item) ? ($item['size']  ?? null) : null,
                ];
            })
            ->filter(fn($g) => file_exists(public_path('uploads/products/' . basename($g['url']))));

        return response()->json([
            'product' => $product->name,
            'gallery' => $gallery->values(),
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    //  FLASH SALES
    // ══════════════════════════════════════════════════════════════

    public function flashSalesIndex()
    {
        $products = Product::with('category', 'subCategory')
                        ->where('is_flash_sale', true)
                        ->latest()->get();

        return view('admin.product.flash_sales', compact('products'));
    }

    public function toggleFlashSale(string $id)
    {
        $product                = Product::findOrFail($id);
        $product->is_flash_sale = !$product->is_flash_sale;

        if (!$product->is_flash_sale) {
            $product->flash_sale_price     = null;
            $product->flash_sale_starts_at = null;
            $product->flash_sale_ends_at   = null;
        }

        $product->save();

        $msg = $product->is_flash_sale
            ? 'Product added to flash sale'
            : 'Product removed from flash sale';

        return redirect()->back()->with('success', $msg);
    }

    public function updateFlashSale(Request $request, string $id)
    {
        $request->validate([
            'flash_sale_price'     => 'required|numeric|min:0',
            'flash_sale_starts_at' => 'nullable|date',
            'flash_sale_ends_at'   => 'nullable|date|after_or_equal:flash_sale_starts_at',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'is_flash_sale'        => true,
            'flash_sale_price'     => (float) $request->flash_sale_price,
            'flash_sale_starts_at' => $request->filled('flash_sale_starts_at')
                                        ? Carbon::parse($request->flash_sale_starts_at) : null,
            'flash_sale_ends_at'   => $request->filled('flash_sale_ends_at')
                                        ? Carbon::parse($request->flash_sale_ends_at) : null,
        ]);

        return redirect()->back()->with('success', 'Flash sale updated successfully');
    }

    // ══════════════════════════════════════════════════════════════
    //  NEW ARRIVALS
    // ══════════════════════════════════════════════════════════════

    public function newArrivalsIndex()
    {
        $products = Product::with('category', 'subCategory')
                        ->where('is_new_arrival', true)
                        ->latest('arrived_at')->get();

        return view('admin.product.new_arrivals', compact('products'));
    }

    public function toggleNewArrival(string $id)
    {
        $product               = Product::findOrFail($id);
        $product->is_new_arrival = !$product->is_new_arrival;
        $product->arrived_at   = $product->is_new_arrival ? Carbon::now() : null;
        $product->save();

        $msg = $product->is_new_arrival
            ? 'Product marked as new arrival'
            : 'Product removed from new arrivals';

        return redirect()->back()->with('success', $msg);
    }

    // ══════════════════════════════════════════════════════════════
    //  BESTSELLERS
    // ══════════════════════════════════════════════════════════════

    public function bestsellersIndex()
    {
        $products = Product::with('category', 'subCategory')
                        ->where('is_bestseller', true)
                        ->latest('bestseller_at')->get();

        return view('admin.product.bestsellers', compact('products'));
    }

    public function toggleBestseller(string $id)
    {
        $product              = Product::findOrFail($id);
        $product->is_bestseller = !$product->is_bestseller;
        $product->bestseller_at = $product->is_bestseller ? Carbon::now() : null;
        $product->save();

        $msg = $product->is_bestseller
            ? 'Product marked as bestseller'
            : 'Product removed from bestsellers';

        return redirect()->back()->with('success', $msg);
    }

    // ══════════════════════════════════════════════════════════════
    //  PRIVATE BUILDER HELPERS
    // ══════════════════════════════════════════════════════════════

    private function buildVariants(Request $request): array
    {
        $variants = [];

        if ($request->has('variant_size')) {
            foreach ($request->variant_size as $i => $size) {
                $color  = $request->variant_color[$i] ?? null;
                $vStock = $request->variant_stock[$i] ?? 0;
                $vPrice = $request->variant_price[$i] ?? null;

                if (!empty(trim((string)$size)) || !empty(trim((string)($color ?? '')))) {
                    $variants[] = [
                        'size'  => trim((string)$size),
                        'color' => trim((string)($color ?? '')),
                        'stock' => (int) $vStock,
                        'price' => $vPrice !== null && $vPrice !== '' ? (float) $vPrice : null,
                    ];
                }
            }
        }

        return $variants;
    }

    private function buildFeatureTags(Request $request): array
    {
        $featureTags = [];

        if ($request->has('tag_keyword')) {
            foreach ($request->tag_keyword as $i => $keyword) {
                if (!empty(trim((string)$keyword))) {
                    $featureTags[] = [
                        'keyword' => trim((string)$keyword),
                        'color'   => $request->tag_color[$i] ?? '#000000',
                    ];
                }
            }
        }

        return $featureTags;
    }

    private function buildTags(Request $request): array
    {
        if (!$request->filled('tags')) {
            return [];
        }

        $raw = is_array($request->tags)
            ? implode(',', $request->tags)
            : $request->tags;

        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }

    private function buildFlashSale(Request $request): array
    {
        $isFlashSale     = $request->boolean('is_flash_sale');
        $flashSalePrice  = $isFlashSale && $request->filled('flash_sale_price')
                               ? (float) $request->flash_sale_price : null;
        $flashSaleStarts = $isFlashSale && $request->filled('flash_sale_starts_at')
                               ? Carbon::parse($request->flash_sale_starts_at) : null;
        $flashSaleEnds   = $isFlashSale && $request->filled('flash_sale_ends_at')
                               ? Carbon::parse($request->flash_sale_ends_at) : null;

        return [$isFlashSale, $flashSalePrice, $flashSaleStarts, $flashSaleEnds];
    }
}
