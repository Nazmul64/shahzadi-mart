<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildSubCategory;
use App\Models\DigitalProduct;
use App\Models\SubCategory;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DigitalProductController extends Controller
{
    protected array $allowedImageMimes = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    public function index(Request $request)
    {
        $query = DigitalProduct::with('category', 'subCategory', 'childSubCategory')->latest();
        $products = $query->get();

        return view('admin.digital_product.index', compact('products'));
    }

    public function create()
    {
        return view('admin.digital_product.create', $this->formData());
    }

    public function store(Request $request)
    {
        $mimes = implode(',', $this->allowedImageMimes);

        $request->validate([
            'name'                 => 'nullable|string|max:255',
            'category_id'          => 'nullable|exists:categories,id',
            'current_price'        => 'nullable|numeric|min:0',
            'description'          => 'nullable',
            'feature_image'        => "nullable|file|mimes:{$mimes}|max:5120",
            'gallery_images.*'     => "nullable|file|mimes:{$mimes}|max:5120",
        ]);

        // Feature Image
        $featureImageName = null;
        if ($request->hasFile('feature_image')) {
            $featureImageName = $this->uploadImage($request->file('feature_image'));
        }

        // Gallery
        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $galleryImages[] = $this->uploadImage($file);
                }
            }
        }

        // Product File
        $productFile = null;
        if ($request->hasFile('product_file')) {
            $file        = $request->file('product_file');
            $productFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $productFile);
        }

        // Additional Thumbnails (Multiple)
        $additionalThumbnails = [];
        if ($request->hasFile('additional_thumbnail')) {
            foreach ($request->file('additional_thumbnail') as $file) {
                if ($file && $file->isValid()) {
                    $additionalThumbnails[] = $this->uploadImage($file);
                }
            }
        }

        // Product Video File
        $videoFile = null;
        if ($request->hasFile('video_file')) {
            $file      = $request->file('video_file');
            $videoFile = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $videoFile);
        }

        $name = $request->name ?: 'Untitled Digital Product ' . strtoupper(Str::random(5));
        $slug = Str::slug($name);

        DigitalProduct::create([
            'name'                  => $name,
            'slug'                  => $slug,
            'sku'                   => $request->filled('sku') ? trim($request->sku) : 'DIG-' . strtoupper(Str::random(8)),
            'short_description'     => $request->short_description,
            'category_id'           => $request->category_id,
            'sub_category_id'       => $request->sub_category_id       ?: null,
            'child_sub_category_id' => $request->child_sub_category_id ?: null,
            'brand_id'              => $request->brand_id              ?: null,
            'upload_type'           => $request->upload_type           ?: 'file',
            'product_file'          => $productFile,
            'product_url'           => $request->product_url           ?: null,
            'license_keys'          => $request->input('license_keys', []),
            'video_type'            => $request->video_type,
            'video_url'             => $request->video_type == 'youtube' ? $request->video_url : $videoFile,
            'description'           => $request->description,
            'feature_image'         => $featureImageName,
            'additional_thumbnail'  => $additionalThumbnails,
            'gallery_images'        => $galleryImages,
            'current_price'         => $request->current_price,
            'buying_price'          => $request->buying_price          ?: 0,
            'discount_price'        => $request->discount_price        ?: null,
            'stock_quantity'        => $request->stock_quantity        ?: 0,
            'status'                => 'active',
            'meta_title'            => $request->meta_title,
            'meta_description'      => $request->meta_description,
            'meta_keywords'         => $request->meta_keywords,
        ]);

        return redirect()->route('admin.digital-products.index')->with('success', 'Digital Product Added Successfully');
    }

    public function edit(string $id)
    {
        $product = DigitalProduct::findOrFail($id);
        $subCategories = SubCategory::where('category_id', $product->category_id)->orderBy('sub_name')->get();
        $childSubCategories = ChildSubCategory::where('sub_category_id', $product->sub_category_id)->orderBy('child_sub_name')->get();

        return view('admin.digital_product.edit', array_merge($this->formData(), compact('product', 'subCategories', 'childSubCategories')));
    }

    public function update(Request $request, string $id)
    {
        $product = DigitalProduct::findOrFail($id);
        $mimes   = implode(',', $this->allowedImageMimes);

        $request->validate([
            'name'                 => 'nullable|string|max:255',
            'category_id'          => 'nullable|exists:categories,id',
            'current_price'        => 'nullable|numeric|min:0',
            'description'          => 'nullable',
            'feature_image'        => "nullable|file|mimes:{$mimes}|max:5120",
            'gallery_images.*'     => "nullable|file|mimes:{$mimes}|max:5120",
        ]);

        // Feature Image
        $featureImageName = $product->feature_image;
        if ($request->hasFile('feature_image')) {
            $this->deleteFile($featureImageName);
            $featureImageName = $this->uploadImage($request->file('feature_image'));
        }

        // Gallery
        $keepImages    = $request->input('keep_gallery', []);
        $galleryImages = array_values(array_intersect($product->gallery_images ?? [], $keepImages));

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $galleryImages[] = $this->uploadImage($file);
                }
            }
        }

        // Additional Thumbnails
        $keepAddThumbnails    = $request->input('keep_additional', []);
        $additionalThumbnails = array_values(array_intersect($product->additional_thumbnail ?? [], $keepAddThumbnails));

        if ($request->hasFile('additional_thumbnail')) {
            foreach ($request->file('additional_thumbnail') as $file) {
                if ($file && $file->isValid()) {
                    $additionalThumbnails[] = $this->uploadImage($file);
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

        $name = $request->name ?: $product->name ?: 'Untitled Digital Product ' . strtoupper(Str::random(5));
        $slug = Str::slug($name);

        $product->update([
            'name'                  => $name,
            'slug'                  => $slug,
            'sku'                   => $request->filled('sku') ? trim($request->sku) : $product->sku,
            'short_description'     => $request->short_description,
            'category_id'           => $request->category_id,
            'sub_category_id'       => $request->sub_category_id       ?: null,
            'child_sub_category_id' => $request->child_sub_category_id ?: null,
            'brand_id'              => $request->brand_id              ?: null,
            'upload_type'           => $request->upload_type           ?: $product->upload_type,
            'product_file'          => $productFile,
            'product_url'           => $request->product_url           ?: null,
            'license_keys'          => $request->input('license_keys', []),
            'video_type'            => $request->video_type,
            'video_url'             => $request->video_type == 'youtube' ? $request->video_url : ($videoFile ?: $product->video_url),
            'description'           => $request->description,
            'feature_image'         => $featureImageName,
            'additional_thumbnail'  => $additionalThumbnails,
            'gallery_images'        => $galleryImages,
            'current_price'         => $request->current_price,
            'buying_price'          => $request->buying_price          ?: 0,
            'discount_price'        => $request->discount_price        ?: null,
            'stock_quantity'        => $request->stock_quantity        ?: 0,
            'meta_title'            => $request->meta_title,
            'meta_description'      => $request->meta_description,
            'meta_keywords'         => $request->meta_keywords,
        ]);

        return redirect()->route('admin.digital-products.index')->with('success', 'Digital Product Updated Successfully');
    }

    public function destroy(string $id)
    {
        $product = DigitalProduct::findOrFail($id);
        $this->deleteFile($product->feature_image);
        foreach ($product->gallery_images ?? [] as $img) {
            $this->deleteFile($img);
        }
        $this->deleteFile($product->product_file);
        if ($product->video_type == 'file') {
            $this->deleteFile($product->video_url);
        }
        foreach ($product->additional_thumbnail ?? [] as $img) {
            $this->deleteFile($img);
        }
        $product->delete();

        return redirect()->route('admin.digital-products.index')->with('success', 'Digital Product Deleted Successfully');
    }

    public function toggleStatus(string $id)
    {
        $product         = DigitalProduct::findOrFail($id);
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();
        return redirect()->back()->with('success', 'Product status updated');
    }

    // ── Private Helpers ───────────────────────────────────────────────

    private function formData(): array
    {
        return [
            'categories' => Category::where('status', 'active')->orderBy('category_name')->get(),
            'brands'     => Brand::where('is_active', true)->orderBy('name')->get(),
        ];
    }

    private function uploadImage($file): string
    {
        $name = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/products'), $name);
        return $name;
    }

    private function deleteFile(?string $name): void
    {
        if ($name && File::exists(public_path('uploads/products/' . $name))) {
            File::delete(public_path('uploads/products/' . $name));
        }
    }
}
