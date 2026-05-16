<?php

namespace App\Http\Controllers\Saller;

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
use Illuminate\Support\Facades\Cache;

class SellerProductController extends Controller
{
    private array $allowedImageMimes = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];

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

    public function index(Request $request)
    {
        $query = Product::with('category', 'subCategory', 'childSubCategory')
            ->where('vendor', auth()->id()) // Only seller's products
            ->orderBy('name', 'asc');

        if ($request->routeIs('saller.digital_products.index')) {
            $query->whereIn('product_type', ['digital', 'license']);
        } elseif ($request->filled('type')) {
            $query->where('product_type', $request->type);
        }


        $products = $query->get();
        return view('saller.pages.product.index', compact('products'));
    }

    public function create(Request $request)
    {
        $type = $request->type ?? 'physical';
        return view('saller.pages.product.create', array_merge($this->formData(), compact('type')));
    }

    public function store(Request $request)
    {
        $mimes = implode(',', $this->allowedImageMimes);

        $request->validate([
            'name'                 => 'required|string|max:255|unique:products,name',
            'category_id'          => 'required|exists:categories,id',
            'current_price'        => 'required|numeric|min:0',
            'description'          => 'required',
            'feature_image'        => "required|file|mimes:{$mimes}|max:5120",
            'gallery_images.*'     => "nullable|file|mimes:{$mimes}|max:5120",
            'product_type'         => 'required|in:physical,digital,license,service',
        ], [
            'name.unique' => 'এই প্রোডাক্টটি অলরেডি অ্যাড করা আছে, দয়া করে ইউনিক নাম ব্যবহার করুন।',
        ]);

        $featureImageName = $this->uploadImage($request->file('feature_image'));
        $galleryImages    = $this->processGallery($request);
        $productFile      = $this->processProductFile($request, null);

        $sku = $request->filled('sku')
            ? trim($request->sku)
            : 'SEL-' . strtoupper(Str::random(3)) . rand(1000, 9999);

        Product::create([
            'name'                  => $request->name,
            'slug'                  => Str::slug($request->name),
            'short_description'     => $request->short_description,
            'sku'                   => $sku,
            'vendor'                => auth()->id(),
            'category_id'           => $request->category_id,
            'sub_category_id'       => $request->sub_category_id       ?: null,
            'child_sub_category_id' => $request->child_sub_category_id ?: null,
            'brand_ids'             => $request->filled('brand_ids')  ? array_map('intval', $request->brand_ids)  : null,
            'color_ids'             => $request->filled('color_ids')  ? array_map('intval', $request->color_ids)  : null,
            'unit_ids'              => $request->filled('unit_ids')   ? array_map('intval', $request->unit_ids)   : null,
            'size_ids'              => $request->filled('size_ids')   ? array_map('intval', $request->size_ids)   : null,
            'product_type'          => $request->product_type,
            'upload_type'           => $request->upload_type           ?: 'file',
            'product_file'          => $productFile,
            'product_url'           => $request->product_url           ?: null,
            'license_keys'          => $request->license_keys          ?: null,
            'description'           => $request->description,
            'return_policy'         => $request->return_policy         ?: null,
            'feature_image'         => $featureImageName,
            'gallery_images'        => $galleryImages,
            'current_price'         => $request->current_price,
            'buying_price'          => $request->buying_price          ?: 0,
            'discount_price'        => $request->discount_price        ?: null,
            'stock'                 => $request->boolean('is_unlimited') ? null : (int) $request->stock,
            'is_unlimited'          => $request->boolean('is_unlimited'),
            'youtube_url'           => $request->youtube_url,
            'video_type'            => $request->video_type            ?: null,
            'video_file'            => $request->hasFile('video_file') ? $this->uploadImage($request->file('video_file')) : null,
            'status'                => 'inactive',
            'meta_tags'             => $request->meta_tags             ?: null,
            'meta_description'      => $request->meta_description      ?: null,
        ]);

        return redirect()->route('saller.products.index')->with('success', 'Product Uploaded Successfully and waiting for approval.');
    }

    public function edit(string $id)
    {
        $product = Product::where('vendor', auth()->id())->findOrFail($id);

        $subCategories = $product->category_id
            ? SubCategory::where('category_id', $product->category_id)->orderBy('sub_name')->get()
            : collect();

        $childSubCategories = $product->sub_category_id
            ? ChildSubCategory::where('sub_category_id', $product->sub_category_id)->orderBy('child_sub_name')->get()
            : collect();

        return view('saller.pages.product.edit', array_merge($this->formData(), compact(
            'product', 'subCategories', 'childSubCategories'
        )));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::where('vendor', auth()->id())->findOrFail($id);
        $mimes   = implode(',', $this->allowedImageMimes);

        $request->validate([
            'name'                 => 'required|string|max:255|unique:products,name,' . $id,
            'category_id'          => 'required|exists:categories,id',
            'current_price'        => 'required|numeric|min:0',
            'description'          => 'required',
            'feature_image'        => "nullable|file|mimes:{$mimes}|max:5120",
        ]);

        // Feature Image
        $featureImageName = $product->feature_image;
        if ($request->hasFile('feature_image')) {
            $this->deleteFile($featureImageName);
            $featureImageName = $this->uploadImage($request->file('feature_image'));
        }

        $product->update([
            'name'                  => $request->name,
            'slug'                  => Str::slug($request->name),
            'short_description'     => $request->short_description,
            'category_id'           => $request->category_id,
            'sub_category_id'       => $request->sub_category_id       ?: null,
            'child_sub_category_id' => $request->child_sub_category_id ?: null,
            'brand_ids'             => $request->filled('brand_ids')  ? array_map('intval', $request->brand_ids)  : null,
            'color_ids'             => $request->filled('color_ids')  ? array_map('intval', $request->color_ids)  : null,
            'unit_ids'              => $request->filled('unit_ids')   ? array_map('intval', $request->unit_ids)   : null,
            'size_ids'              => $request->filled('size_ids')   ? array_map('intval', $request->size_ids)   : null,
            'description'           => $request->description,
            'feature_image'         => $featureImageName,
            'current_price'         => $request->current_price,
            'buying_price'          => $request->buying_price          ?: $product->buying_price,
            'discount_price'        => $request->discount_price        ?: null,
            'stock'                 => $request->boolean('is_unlimited') ? null : (int) $request->stock,
            'is_unlimited'          => $request->boolean('is_unlimited'),
            'product_type'          => $request->product_type          ?: $product->product_type,
            'upload_type'           => $request->upload_type           ?: $product->upload_type,
            'product_url'           => $request->product_url           ?: $product->product_url,
            'license_keys'          => $request->license_keys          ?: $product->license_keys,
            'youtube_url'           => $request->youtube_url,
            'video_type'            => $request->video_type            ?: $product->video_type,
            'video_file'            => $request->hasFile('video_file') ? $this->uploadImage($request->file('video_file')) : $product->video_file,
        ]);

        if ($request->hasFile('product_file')) {
            $this->deleteFile($product->product_file);
            $product->update([
                'product_file' => $this->uploadImage($request->file('product_file'))
            ]);
        }


        return redirect()->route('saller.products.index')->with('success', 'Product Updated Successfully');
    }

    public function destroy(string $id)
    {
        $product = Product::where('vendor', auth()->id())->findOrFail($id);
        $this->deleteFile($product->feature_image);
        foreach ($product->gallery_images ?? [] as $item) {
            $this->deleteFile(is_array($item) ? $item['image'] : $item);
        }
        $this->deleteFile($product->product_file);
        $product->delete();

        return redirect()->route('saller.products.index')->with('success', 'Product Deleted Successfully');
    }

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

    public function toggleStatus(string $id)
    {
        $product = Product::where('vendor', auth()->id())->findOrFail($id);
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();

        return response()->json(['status' => 'success', 'new_status' => $product->status]);
    }

    public function show(string $id)
    {
        $product = Product::where('vendor', auth()->id())->findOrFail($id);
        return view('saller.pages.product.show', compact('product'));
    }

    public function barcode(string $id)
    {
        $product = Product::where('vendor', auth()->id())->findOrFail($id);
        return view('saller.pages.product.barcode', compact('product'));
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
}
