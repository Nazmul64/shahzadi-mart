<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildSubCategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Unit;
use App\Models\Size;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    private array $allowedImageMimes = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];

    // ── Image helpers ─────────────────────────────────────────────────

    private function uploadImage($file, string $folder = 'uploads/products'): string
    {
        $ext      = strtolower($file->getClientOriginalExtension());
        $filename = time() . rand(100, 9999) . '_' . Str::slug(
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        ) . '.' . $ext;
        $file->move(public_path($folder), $filename);
        return $filename;
    }

    private function deleteFile(?string $filename, string $folder = 'uploads/products'): void
    {
        if ($filename && file_exists(public_path($folder . '/' . $filename))) {
            unlink(public_path($folder . '/' . $filename));
        }
    }

    // ── Common data for views ─────────────────────────────────────────

    private function formData(): array
    {
        return [
            'categories' => Category::where('status', 'active')->orderBy('category_name')->get(),
            'brands'     => Brand::where('is_active', true)->orderBy('name')->get(),
            'colors'     => Color::where('is_active', true)->orderBy('name')->get(),
            'units'      => Unit::where('is_active', true)->orderBy('name')->get(),
            'sizes'      => Size::where('is_active', true)->orderBy('name')->get(),
        ];
    }

    // ══════════════════════════════════════════════════════════════
    //  INDEX
    // ══════════════════════════════════════════════════════════════

    public function index()
    {
        $products = Product::with('category', 'subCategory', 'childSubCategory')
            ->latest()->get();

        if (request()->routeIs('manager.*')) {
            return view('manager.product.index', compact('products'));
        } elseif (request()->routeIs('emplee.*')) {
            return view('emplee.product.index', compact('products'));
        }
        
        return view('admin.product.index', compact('products'));
    }

    // ══════════════════════════════════════════════════════════════
    //  CREATE
    // ══════════════════════════════════════════════════════════════

    public function create()
    {
        return view('admin.product.create', $this->formData());
    }

    // ══════════════════════════════════════════════════════════════
    //  STORE
    // ══════════════════════════════════════════════════════════════

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
            'brand_ids'            => 'nullable|array',
            'brand_ids.*'          => 'exists:brands,id',
            'color_ids'            => 'nullable|array',
            'color_ids.*'          => 'exists:colors,id',
            'unit_ids'             => 'nullable|array',
            'unit_ids.*'           => 'exists:units,id',
            'size_ids'             => 'nullable|array',
            'size_ids.*'           => 'exists:sizes,id',
        ]);

        $featureImageName = $this->uploadImage($request->file('feature_image'));
        $galleryImages    = $this->processGallery($request);
        $productFile      = $this->processProductFile($request, null);

        $isUnlimited  = $request->boolean('is_unlimited');
        $isNewArrival = $request->boolean('is_new_arrival');
        $isBestseller = $request->boolean('is_bestseller');
        [$isFlashSale, $flashSalePrice, $flashSaleStarts, $flashSaleEnds] = $this->buildFlashSale($request);

        $sku = $request->filled('sku')
            ? trim($request->sku)
            : strtoupper(Str::random(3)) . rand(100000, 999999) . strtolower(Str::random(2));

        Product::create([
            'name'                  => $request->name,
            'slug'                  => Str::slug($request->name),
            'sku'                   => $sku,
            'vendor'                => $request->vendor                ?: null,
            'category_id'           => $request->category_id,
            'sub_category_id'       => $request->sub_category_id       ?: null,
            'child_sub_category_id' => $request->child_sub_category_id ?: null,
            // Multiple IDs – store as array (cast handles JSON encode)
            'brand_ids'             => $request->filled('brand_ids')  ? array_map('intval', $request->brand_ids)  : null,
            'color_ids'             => $request->filled('color_ids')  ? array_map('intval', $request->color_ids)  : null,
            'unit_ids'              => $request->filled('unit_ids')   ? array_map('intval', $request->unit_ids)   : null,
            'size_ids'              => $request->filled('size_ids')   ? array_map('intval', $request->size_ids)   : null,
            'product_type'          => $request->product_type          ?: 'digital',
            'upload_type'           => $request->upload_type           ?: 'file',
            'product_file'          => $productFile,
            'product_url'           => $request->product_url           ?: null,
            'description'           => $request->description,
            'return_policy'         => $request->return_policy         ?: null,
            'feature_image'         => $featureImageName,
            'gallery_images'        => $galleryImages,
            'current_price'         => $request->current_price,
            'discount_price'        => $request->discount_price        ?: null,
            'stock'                 => $isUnlimited ? null : (int) $request->stock,
            'is_unlimited'          => $isUnlimited,
            'youtube_url'           => $request->youtube_url           ?: null,
            'tags'                  => $this->buildTags($request),
            'feature_tags'          => $this->buildFeatureTags($request),
            'status'                => 'active',
            'is_highlighted'        => false,
            'meta_tags'             => $request->meta_tags             ?: null,
            'meta_description'      => $request->meta_description      ?: null,
            'is_flash_sale'         => $isFlashSale,
            'flash_sale_price'      => $flashSalePrice,
            'flash_sale_starts_at'  => $flashSaleStarts,
            'flash_sale_ends_at'    => $flashSaleEnds,
            'is_new_arrival'        => $isNewArrival,
            'arrived_at'            => $isNewArrival ? Carbon::now() : null,
            'is_bestseller'         => $isBestseller,
            'bestseller_at'         => $isBestseller ? Carbon::now() : null,
        ]);

        $route = 'admin.products.index';
        if (request()->routeIs('manager.*')) $route = 'manager.products.index';
        if (request()->routeIs('emplee.*')) $route = 'emplee.products.index';

        return redirect()->route($route)->with('success', 'Product Created Successfully');
    }

    // ══════════════════════════════════════════════════════════════
    //  EDIT
    // ══════════════════════════════════════════════════════════════

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        $subCategories = $product->category_id
            ? SubCategory::where('category_id', $product->category_id)->orderBy('sub_name')->get()
            : collect();

        $childSubCategories = $product->sub_category_id
            ? ChildSubCategory::where('sub_category_id', $product->sub_category_id)->orderBy('child_sub_name')->get()
            : collect();

        return view('admin.product.edit', array_merge($this->formData(), compact(
            'product', 'subCategories', 'childSubCategories'
        )));
    }

    // ══════════════════════════════════════════════════════════════
    //  UPDATE
    // ══════════════════════════════════════════════════════════════

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $mimes   = implode(',', $this->allowedImageMimes);

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
            'brand_ids'            => 'nullable|array',
            'brand_ids.*'          => 'exists:brands,id',
            'color_ids'            => 'nullable|array',
            'color_ids.*'          => 'exists:colors,id',
            'unit_ids'             => 'nullable|array',
            'unit_ids.*'           => 'exists:units,id',
            'size_ids'             => 'nullable|array',
            'size_ids.*'           => 'exists:sizes,id',
        ]);

        // Feature Image
        $featureImageName = $product->feature_image;
        if ($request->hasFile('feature_image')) {
            $this->deleteFile($featureImageName);
            $featureImageName = $this->uploadImage($request->file('feature_image'));
        }

        // Gallery: keep existing + append new
        $keepImages    = $request->input('keep_gallery', []);
        $galleryImages = array_values(array_filter(
            $product->gallery_images ?? [],
            fn($item) => in_array(is_array($item) ? $item['image'] : $item, $keepImages)
        ));

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $i => $file) {
                if ($file && $file->isValid()) {
                    $galleryImages[] = [
                        'image' => $this->uploadImage($file),
                        'color' => $request->input('gallery_color')[$i] ?? null,
                        'size'  => $request->input('gallery_size')[$i]  ?? null,
                    ];
                }
            }
        }

        // Product File
        $productFile = $product->product_file;
        if ($request->hasFile('product_file')) {
            $this->deleteFile($productFile);
            $file        = $request->file('product_file');
            $productFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $productFile);
        }

        $isUnlimited  = $request->boolean('is_unlimited');
        $isNewArrival = $request->boolean('is_new_arrival');
        $isBestseller = $request->boolean('is_bestseller');
        [$isFlashSale, $flashSalePrice, $flashSaleStarts, $flashSaleEnds] = $this->buildFlashSale($request);

        $arrivedAt = match(true) {
            $isNewArrival && !$product->is_new_arrival => Carbon::now(),
            $isNewArrival && $product->is_new_arrival  => $product->arrived_at,
            default                                    => null,
        };
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
            // Multiple IDs
            'brand_ids'             => $request->filled('brand_ids')  ? array_map('intval', $request->brand_ids)  : null,
            'color_ids'             => $request->filled('color_ids')  ? array_map('intval', $request->color_ids)  : null,
            'unit_ids'              => $request->filled('unit_ids')   ? array_map('intval', $request->unit_ids)   : null,
            'size_ids'              => $request->filled('size_ids')   ? array_map('intval', $request->size_ids)   : null,
            'product_type'          => $request->product_type          ?: $product->product_type,
            'upload_type'           => $request->upload_type           ?: $product->upload_type,
            'product_file'          => $productFile,
            'product_url'           => $request->product_url           ?: null,
            'description'           => $request->description,
            'return_policy'         => $request->return_policy         ?: null,
            'feature_image'         => $featureImageName,
            'gallery_images'        => $galleryImages,
            'current_price'         => $request->current_price,
            'discount_price'        => $request->discount_price        ?: null,
            'stock'                 => $isUnlimited ? null : (int) $request->stock,
            'is_unlimited'          => $isUnlimited,
            'youtube_url'           => $request->youtube_url           ?: null,
            'tags'                  => $this->buildTags($request),
            'feature_tags'          => $this->buildFeatureTags($request),
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

        $route = 'admin.products.index';
        if (request()->routeIs('manager.*')) $route = 'manager.products.index';
        if (request()->routeIs('emplee.*')) $route = 'emplee.products.index';

        return redirect()->route($route)->with('success', 'Product Updated Successfully');
    }

    // ══════════════════════════════════════════════════════════════
    //  DESTROY
    // ══════════════════════════════════════════════════════════════

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $this->deleteFile($product->feature_image);
        foreach ($product->gallery_images ?? [] as $item) {
            $this->deleteFile(is_array($item) ? $item['image'] : $item);
        }
        $this->deleteFile($product->product_file);
        $product->delete();
        
        $route = 'admin.products.index';
        if (request()->routeIs('manager.*')) $route = 'manager.products.index';
        if (request()->routeIs('emplee.*')) $route = 'emplee.products.index';

        return redirect()->route($route)->with('success', 'Product Deleted Successfully');
    }

    // ══════════════════════════════════════════════════════════════
    //  AJAX / STATUS / OTHER
    // ══════════════════════════════════════════════════════════════

    public function show(string $id) { return redirect()->route('admin.products.index'); }

    public function getSubCategories(Request $request)
    {
        $subs = SubCategory::where('category_id', (int) $request->category_id)
            ->orderBy('sub_name')->get(['id', 'sub_name']);
        return response()->json($subs);
    }

    public function getChildCategories(Request $request)
    {
        $children = ChildSubCategory::where('sub_category_id', (int) $request->sub_category_id)
            ->orderBy('child_sub_name')->get(['id', 'child_sub_name']);
        return response()->json($children);
    }

    public function toggleStatus(string $id)
    {
        $product         = Product::findOrFail($id);
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();
        return redirect()->back()->with('success', 'Product status updated');
    }

    public function deactivated()
    {
        $products = Product::with('category')->where('status', 'inactive')->latest()->get();
        return view('admin.product.deactivated', compact('products'));
    }

    public function catalogIndex()
    {
        $products = Product::with('category', 'subCategory')->latest()->get();
        return view('admin.catalog.catalog', compact('products'));
    }

    public function catalogAdd(string $id)
    {
        Product::findOrFail($id)->update(['in_catalog' => true]);
        return redirect()->back()->with('success', 'Product added to catalog');
    }

    public function catalogRemove(Request $request, string $id)
    {
        Product::findOrFail($id)->update(['in_catalog' => false, 'is_highlighted' => false]);
        return redirect()->back()->with('success', 'Product removed from catalog');
    }

    public function catalogHighlight(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->is_highlighted = !$product->is_highlighted;
        $product->save();
        return redirect()->back()->with('success', $product->is_highlighted ? 'Product highlighted' : 'Removed from highlights');
    }

    public function flashSalesIndex()
    {
        $products = Product::with('category')->where('is_flash_sale', true)->latest()->get();
        return view('admin.product.flash_sales', compact('products'));
    }

    public function toggleFlashSale(string $id)
    {
        $product = Product::findOrFail($id);
        $product->is_flash_sale = !$product->is_flash_sale;
        if (!$product->is_flash_sale) {
            $product->flash_sale_price = $product->flash_sale_starts_at = $product->flash_sale_ends_at = null;
        }
        $product->save();
        return redirect()->back()->with('success', $product->is_flash_sale ? 'Added to flash sale' : 'Removed from flash sale');
    }

    public function newArrivalsIndex()
    {
        $products = Product::with('category')->where('is_new_arrival', true)->latest('arrived_at')->get();
        return view('admin.product.new_arrivals', compact('products'));
    }

    public function toggleNewArrival(string $id)
    {
        $product             = Product::findOrFail($id);
        $product->is_new_arrival = !$product->is_new_arrival;
        $product->arrived_at     = $product->is_new_arrival ? Carbon::now() : null;
        $product->save();
        return redirect()->back()->with('success', $product->is_new_arrival ? 'Marked as new arrival' : 'Removed from new arrivals');
    }

    public function bestsellersIndex()
    {
        $products = Product::with('category')->where('is_bestseller', true)->latest('bestseller_at')->get();
        return view('admin.product.bestsellers', compact('products'));
    }

    public function toggleBestseller(string $id)
    {
        $product = Product::findOrFail($id);
        $product->is_bestseller = !$product->is_bestseller;
        $product->bestseller_at = $product->is_bestseller ? Carbon::now() : null;
        $product->save();
        return redirect()->back()->with('success', $product->is_bestseller ? 'Marked as bestseller' : 'Removed from bestsellers');
    }

    // ── Private Builders ───────────────────────────────────────────────

    private function processGallery(Request $request): array
    {
        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $i => $file) {
                if ($file && $file->isValid()) {
                    $galleryImages[] = [
                        'image' => $this->uploadImage($file),
                        'color' => $request->input('gallery_color')[$i] ?? null,
                        'size'  => $request->input('gallery_size')[$i]  ?? null,
                    ];
                }
            }
        }
        return $galleryImages;
    }

    private function processProductFile(Request $request, ?string $existing): ?string
    {
        if ($request->hasFile('product_file')) {
            $this->deleteFile($existing);
            $file = $request->file('product_file');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $name);
            return $name;
        }
        return $existing;
    }

    private function buildFeatureTags(Request $request): array
    {
        $featureTags = [];
        if ($request->has('tag_keyword')) {
            foreach ($request->tag_keyword as $i => $keyword) {
                if (!empty(trim((string) $keyword))) {
                    $featureTags[] = [
                        'keyword' => trim((string) $keyword),
                        'color'   => $request->tag_color[$i] ?? '#000000',
                    ];
                }
            }
        }
        return $featureTags;
    }

    private function buildTags(Request $request): array
    {
        if (!$request->filled('tags')) return [];
        $raw = is_array($request->tags) ? implode(',', $request->tags) : $request->tags;
        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }

    private function buildFlashSale(Request $request): array
    {
        $isFlashSale     = $request->boolean('is_flash_sale');
        $flashSalePrice  = $isFlashSale && $request->filled('flash_sale_price') ? (float) $request->flash_sale_price : null;
        $flashSaleStarts = $isFlashSale && $request->filled('flash_sale_starts_at') ? Carbon::parse($request->flash_sale_starts_at) : null;
        $flashSaleEnds   = $isFlashSale && $request->filled('flash_sale_ends_at')   ? Carbon::parse($request->flash_sale_ends_at)   : null;
        return [$isFlashSale, $flashSalePrice, $flashSaleStarts, $flashSaleEnds];
    }
}
