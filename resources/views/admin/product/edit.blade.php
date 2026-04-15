@extends('admin.master')

@section('main-content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<style>
    /* ── Typography ── */
    .form-label-custom { font-size:.88rem; font-weight:600; color:#333; margin-bottom:5px; display:block; }
    .form-label-sub    { font-size:.78rem; color:#6c757d; font-weight:400; }
    .optional-badge    { font-size:.72rem; color:#fff; background:#6c757d; border-radius:10px; padding:2px 8px; margin-left:5px; font-weight:500; }
    .select-hint       { font-size:.75rem; color:#6c757d; margin-top:3px; display:block; }

    /* ── Buttons ── */
    .btn-back               { background:#1a2b6b; color:#fff; border:none; border-radius:20px; padding:6px 18px; font-size:.85rem; text-decoration:none; display:inline-flex; align-items:center; gap:5px; }
    .btn-back:hover         { background:#152259; color:#fff; }
    .btn-update-product     { background:#1a2b6b; color:#fff; border:none; border-radius:4px; padding:10px 32px; font-size:.95rem; font-weight:600; width:100%; margin-top:10px; }
    .btn-update-product:hover { background:#152259; color:#fff; }
    .btn-upload-img         { background:#1a2b6b; color:#fff; border:none; border-radius:4px; padding:10px 24px; font-size:.88rem; display:inline-flex; align-items:center; gap:6px; cursor:pointer; }
    .btn-upload-img:hover   { background:#152259; }
    .btn-set-gallery        { background:#1a2b6b; color:#fff; border:none; border-radius:4px; padding:8px 20px; font-size:.88rem; display:inline-flex; align-items:center; gap:5px; cursor:pointer; }
    .btn-set-gallery:hover  { background:#152259; }
    .btn-add-tag            { background:none; border:1px dashed #1a2b6b; color:#1a2b6b; border-radius:4px; padding:6px 16px; font-size:.85rem; cursor:pointer; width:100%; }
    .btn-add-tag:hover      { background:#e8ecf8; }

    /* ── Feature image box ── */
    .feature-img-box        { border:2px dashed #ced4da; border-radius:8px; min-height:200px; display:flex; align-items:center; justify-content:center; background:#f8f9fa; overflow:hidden; cursor:pointer; }
    .feature-img-box img    { width:100%; height:200px; object-fit:cover; }

    /* ── Sidebar cards ── */
    .sidebar-card           { background:#fff; border:1px solid #e9ecef; border-radius:8px; padding:18px; margin-bottom:18px; }
    .sidebar-card-title     { font-size:.9rem; font-weight:700; color:#1a2b6b; margin-bottom:14px; }

    /* ── Flash Sale card ── */
    .flash-sale-card                    { border:1px solid #fcd34d; border-radius:8px; background:#fffbeb; padding:18px; margin-bottom:18px; }
    .flash-sale-card .sidebar-card-title { color:#b45309; }
    .flash-sale-fields                  { margin-top:12px; }

    /* ── New Arrival card ── */
    .new-arrival-card                    { border:1px solid #6ee7b7; border-radius:8px; background:#f0fdf4; padding:18px; margin-bottom:18px; }
    .new-arrival-card .sidebar-card-title { color:#065f46; }

    /* ── Bestseller card ── */
    .bestseller-card                    { border:1px solid #c4b5fd; border-radius:8px; background:#f5f3ff; padding:18px; margin-bottom:18px; }
    .bestseller-card .sidebar-card-title { color:#5b21b6; }

    /* ── Toggle switch ── */
    .toggle-switch-wrap                   { display:flex; align-items:center; gap:10px; }
    .toggle-switch-wrap .form-check-label { font-size:.85rem; font-weight:600; cursor:pointer; }

    /* ── Tag rows ── */
    .tag-row                      { display:flex; gap:8px; align-items:center; margin-bottom:8px; }
    .tag-row input[type="text"]   { flex:1; }
    .tag-row input[type="color"]  { width:40px; height:38px; border:1px solid #ced4da; border-radius:4px; padding:2px; cursor:pointer; }
    .btn-remove-tag               { background:#dc3545; color:#fff; border:none; border-radius:50%; width:28px; height:28px; font-size:.8rem; cursor:pointer; flex-shrink:0; }

    /* ── Variant rows ── */
    .variant-header              { display:grid; grid-template-columns:1fr 80px 80px 90px 32px; gap:6px; margin-bottom:4px; }
    .variant-header span         { font-size:.75rem; font-weight:600; color:#6c757d; }
    .variant-row                 { display:grid; grid-template-columns:1fr 80px 80px 90px 32px; gap:6px; align-items:center; margin-bottom:8px; }
    .variant-row input[type="color"] { width:100%; height:38px; border:1px solid #ced4da; border-radius:4px; padding:2px; cursor:pointer; }
    .btn-remove-variant          { background:#dc3545; color:#fff; border:none; border-radius:50%; width:28px; height:28px; font-size:.8rem; cursor:pointer; flex-shrink:0; }

    /* ── Gallery ── */
    .gallery-grid               { display:flex; flex-wrap:wrap; gap:10px; margin-top:10px; }
    .gallery-card               { background:#f8f9fa; border:1px solid #dee2e6; border-radius:8px; padding:6px; width:130px; }
    .gallery-card img           { width:100%; height:75px; object-fit:cover; border-radius:4px; }
    .gallery-card .meta         { font-size:.7rem; color:#555; margin-top:3px; }
    .gallery-card input         { font-size:.72rem; margin-top:4px; }
    .gallery-card .btn-rm       { background:#dc3545; color:#fff; border:none; border-radius:4px; width:100%; margin-top:4px; font-size:.72rem; padding:2px 0; cursor:pointer; }
    .gallery-card.new-img       { border-color:#ffc107; background:#fff3cd; }

    /* ── SEO section ── */
    .seo-section                 { border:1px solid #e0e7ff; border-radius:8px; background:#f8f9ff; padding:16px; margin-top:6px; }
    .seo-toggle-label            { font-size:.9rem; font-weight:600; color:#1a2b6b; cursor:pointer; user-select:none; display:flex; align-items:center; gap:8px; }
    .seo-toggle-label input[type="checkbox"] { width:17px; height:17px; cursor:pointer; accent-color:#1a2b6b; }
</style>

{{-- Page header --}}
<div class="d-flex align-items-center gap-3 mb-2">
    <h4 style="font-size:1.1rem;font-weight:600;margin:0;">Edit Product</h4>
    <a href="{{ route('admin.products.index') }}" class="btn-back">&#8592; Back</a>
</div>
<small class="text-muted" style="font-size:.82rem;">
    Dashboard &rsaquo; Products &rsaquo; All Products &rsaquo; Edit Product
</small>

@if($errors->any())
    <div class="alert alert-danger mt-2 py-2">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ route('admin.products.update', $product->id) }}" method="POST"
      enctype="multipart/form-data" class="mt-3">
    @csrf
    @method('PUT')
    {{-- Hidden gallery file inputs (rebuilt by JS) --}}
    <div id="galleryFileInputs"></div>

    <div class="row g-3">

        {{-- ═══════════ LEFT COLUMN ═══════════ --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">

                {{-- Product Name --}}
                <div class="mb-3">
                    <label class="form-label-custom">Product Name*</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
                </div>

                {{-- SKU / Vendor --}}
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">SKU <span class="optional-badge">Optional</span></label>
                        <input type="text" name="sku" class="form-control"
                               value="{{ old('sku', $product->sku) }}" placeholder="Auto-generated if empty">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Vendor <span class="optional-badge">Optional</span></label>
                        <input type="text" name="vendor" class="form-control"
                               value="{{ old('vendor', $product->vendor) }}" placeholder="e.g. Test Stores">
                    </div>
                </div>

                {{-- Product Type --}}
                <div class="mb-3">
                    <label class="form-label-custom">Product Type*</label>
                    <select name="product_type" class="form-select">
                        @foreach(\App\Models\Product::$productTypes as $value => $label)
                            <option value="{{ $value }}" {{ old('product_type', $product->product_type) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Category --}}
                <div class="mb-3">
                    <label class="form-label-custom">Category*</label>
                    <select name="category_id" id="product_category" class="form-select">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sub Category --}}
                <div class="mb-3">
                    <label class="form-label-custom">Sub Category <span class="optional-badge">Optional</span></label>
                    <select name="sub_category_id" id="product_subcategory" class="form-select">
                        <option value="">-- Select Sub Category (Optional) --</option>
                        @foreach($subCategories as $sub)
                            <option value="{{ $sub->id }}" {{ old('sub_category_id', $product->sub_category_id) == $sub->id ? 'selected' : '' }}>
                                {{ $sub->sub_name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="select-hint" id="sub_hint">Not required</small>
                </div>

                {{-- Child Category --}}
                <div class="mb-3">
                    <label class="form-label-custom">Child Category <span class="optional-badge">Optional</span></label>
                    <select name="child_sub_category_id" id="product_childcategory" class="form-select">
                        <option value="">-- Select Child Category (Optional) --</option>
                        @foreach($childSubCategories as $child)
                            <option value="{{ $child->id }}" {{ old('child_sub_category_id', $product->child_sub_category_id) == $child->id ? 'selected' : '' }}>
                                {{ $child->child_sub_name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="select-hint" id="child_hint">Not required</small>
                </div>

                {{-- Upload Type --}}
                <div class="mb-3">
                    <label class="form-label-custom">Select Upload Type*</label>
                    <select name="upload_type" id="upload_type" class="form-select">
                        <option value="file" {{ old('upload_type', $product->upload_type) === 'file' ? 'selected' : '' }}>Upload By File</option>
                        <option value="url"  {{ old('upload_type', $product->upload_type) === 'url'  ? 'selected' : '' }}>Upload By URL</option>
                    </select>
                </div>

                {{-- File upload --}}
                <div class="mb-3" id="file_upload_section"
                     style="{{ old('upload_type', $product->upload_type) === 'url' ? 'display:none;' : '' }}">
                    <label class="form-label-custom">Select File <span class="optional-badge">Leave blank to keep current</span></label>
                    @if($product->product_file)
                        <p class="text-muted mb-1" style="font-size:.82rem;">
                            Current: <strong>{{ $product->product_file }}</strong>
                        </p>
                    @endif
                    <input type="file" name="product_file" class="form-control">
                </div>

                {{-- URL upload --}}
                <div class="mb-3" id="url_upload_section"
                     style="{{ old('upload_type', $product->upload_type) !== 'url' ? 'display:none;' : '' }}">
                    <label class="form-label-custom">Product URL*</label>
                    <input type="text" name="product_url" class="form-control"
                           placeholder="Enter product download URL"
                           value="{{ old('product_url', $product->product_url) }}">
                </div>

                {{-- SEO --}}
                @php $hasSeo = !empty($product->meta_tags) || !empty($product->meta_description); @endphp
                <div class="mb-3">
                    <label class="seo-toggle-label">
                        <input type="checkbox" id="allow_seo_checkbox" {{ $hasSeo ? 'checked' : '' }}>
                        Allow Product SEO
                    </label>
                    <div class="seo-section mt-3" id="seo_fields" style="{{ $hasSeo ? '' : 'display:none;' }}">
                        <div class="mb-3">
                            <label class="form-label-custom">Meta Tags</label>
                            <input type="text" name="meta_tags" id="meta_tags_input" class="form-control"
                                   placeholder="Enter meta tags (comma separated)"
                                   value="{{ old('meta_tags', $product->meta_tags) }}">
                            <small class="text-muted" style="font-size:.75rem;">e.g. shoes, running, sport</small>
                        </div>
                        <div class="mb-0">
                            <label class="form-label-custom">Meta Description</label>
                            <textarea name="meta_description" id="meta_description_input" class="form-control" rows="4"
                                      placeholder="Meta Description">{{ old('meta_description', $product->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Variants --}}
                <div class="mb-3">
                    <label class="form-label-custom">Product Variants <span class="optional-badge">Optional</span></label>
                    <div class="variant-header">
                        <span>Size</span><span>Color</span><span>Stock</span><span>Price (USD)</span><span></span>
                    </div>
                    <div id="variantContainer">
                        @php $variants = $product->variants ?? []; @endphp
                        @if(count($variants) > 0)
                            @foreach($variants as $v)
                                <div class="variant-row">
                                    <input type="text"   name="variant_size[]"  class="form-control form-control-sm" value="{{ $v['size']  ?? '' }}" placeholder="e.g. M / XL">
                                    <input type="color"  name="variant_color[]" value="{{ $v['color'] ?? '#000000' }}">
                                    <input type="number" name="variant_stock[]" class="form-control form-control-sm" min="0" value="{{ $v['stock'] ?? 0 }}">
                                    <input type="number" name="variant_price[]" class="form-control form-control-sm" step="0.01" min="0" value="{{ $v['price'] ?? '' }}">
                                    <button type="button" class="btn-remove-variant" onclick="removeVariantRow(this)">&#10005;</button>
                                </div>
                            @endforeach
                        @else
                            <div class="variant-row">
                                <input type="text"   name="variant_size[]"  class="form-control form-control-sm" placeholder="e.g. M / XL">
                                <input type="color"  name="variant_color[]" value="#000000">
                                <input type="number" name="variant_stock[]" class="form-control form-control-sm" placeholder="0" min="0" value="0">
                                <input type="number" name="variant_price[]" class="form-control form-control-sm" placeholder="0.00" step="0.01" min="0">
                                <button type="button" class="btn-remove-variant" onclick="removeVariantRow(this)">&#10005;</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn-add-tag mt-1" onclick="addVariantRow()">+ Add Variant</button>
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label-custom">Product Description*</label>
                    <textarea name="description" id="product_description" class="form-control" rows="6">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- Return Policy --}}
                <div class="mb-3">
                    <label class="form-label-custom">Product Buy/Return Policy <span class="form-label-sub">(Optional)</span></label>
                    <textarea name="return_policy" id="return_policy" class="form-control" rows="6">{{ old('return_policy', $product->return_policy) }}</textarea>
                </div>

            </div>
        </div>

        {{-- ═══════════ RIGHT COLUMN ═══════════ --}}
        <div class="col-lg-4">

            {{-- Feature Image --}}
            <div class="sidebar-card">
                <div class="sidebar-card-title">Feature Image *</div>
                <div class="feature-img-box" onclick="document.getElementById('feature_image_input').click()">
                    @if($product->feature_image && file_exists(public_path('uploads/products/' . $product->feature_image)))
                        <img id="featureImgPreview"
                             src="{{ asset('uploads/products/' . $product->feature_image) }}"
                             style="display:block;">
                    @else
                        <img id="featureImgPreview" src="" style="display:none;" alt="Preview">
                        <div id="featureImgPlaceholder">
                            <button type="button" class="btn-upload-img">&#8679; Upload Image Here</button>
                        </div>
                    @endif
                </div>
                <input type="file" name="feature_image" id="feature_image_input" accept="image/*" class="d-none">
                <small class="text-muted d-block mt-1" style="font-size:.75rem;">Leave blank to keep current image</small>
            </div>

            {{-- Gallery --}}
            <div class="sidebar-card">
                <div class="sidebar-card-title">Product Gallery Images</div>
                <input type="file" id="galleryPicker" accept="image/*" multiple class="d-none">
                <button type="button" class="btn-set-gallery" onclick="document.getElementById('galleryPicker').click()">+ Add Images</button>
                <small class="text-muted d-block mt-1" style="font-size:.75rem;">&#10005; = remove existing &nbsp;|&nbsp; Yellow border = new upload</small>

                {{-- Existing gallery images --}}
                <div class="gallery-grid" id="existingGallery">
                    @if($product->gallery_images)
                        @foreach($product->gallery_images as $img)
                            @php
                                $imgName  = is_array($img) ? $img['image'] : $img;
                                $imgColor = is_array($img) ? ($img['color'] ?? '') : '';
                                $imgSize  = is_array($img) ? ($img['size']  ?? '') : '';
                            @endphp
                            <div class="gallery-card" id="gex_{{ $imgName }}">
                                <input type="hidden" name="keep_gallery[]" value="{{ $imgName }}">
                                <img src="{{ asset('uploads/products/' . $imgName) }}" alt="">
                                @if($imgColor || $imgSize)
                                    <div class="meta">
                                        @if($imgColor)&#127912; {{ $imgColor }}@endif
                                        @if($imgSize) &middot; {{ $imgSize }}@endif
                                    </div>
                                @endif
                                <button type="button" class="btn-rm" onclick="removeExistingGallery('{{ $imgName }}')">&#10005; Remove</button>
                            </div>
                        @endforeach
                    @endif
                </div>

                {{-- New gallery uploads (preview only) --}}
                <div class="gallery-grid" id="newGalleryPreview"></div>
            </div>

            {{-- Pricing & Stock --}}
            <div class="sidebar-card">
                <div class="mb-3">
                    <label class="form-label-custom">Product Current Price* <span class="form-label-sub">(In USD)</span></label>
                    <input type="number" step="0.01" name="current_price" class="form-control"
                           value="{{ old('current_price', $product->current_price) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Product Discount Price <span class="form-label-sub">(Optional)</span></label>
                    <input type="number" step="0.01" name="discount_price" class="form-control"
                           value="{{ old('discount_price', $product->discount_price) }}">
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <label class="form-label-custom mb-0">Stock Quantity*</label>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="is_unlimited" id="is_unlimited" value="1"
                                   onchange="toggleUnlimited(this)"
                                   {{ old('is_unlimited', $product->is_unlimited) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_unlimited" style="font-size:.8rem;">Unlimited</label>
                        </div>
                    </div>
                    <input type="number" min="0" name="stock" id="stock_input" class="form-control"
                           value="{{ old('stock', $product->stock) }}"
                           {{ old('is_unlimited', $product->is_unlimited) ? 'disabled' : '' }}>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Youtube Video URL <span class="form-label-sub">(Optional)</span></label>
                    <input type="text" name="youtube_url" class="form-control"
                           value="{{ old('youtube_url', $product->youtube_url) }}">
                </div>
            </div>

            {{-- Flash Sale --}}
            <div class="flash-sale-card">
                <div class="sidebar-card-title">&#9889; Flash Sale</div>
                <div class="toggle-switch-wrap mb-3">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_flash_sale" id="is_flash_sale" value="1"
                               onchange="toggleFlashSale(this)"
                               {{ old('is_flash_sale', $product->is_flash_sale) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_flash_sale">Enable Flash Sale</label>
                    </div>
                </div>
                <div class="flash-sale-fields" id="flashSaleFields"
                     style="{{ old('is_flash_sale', $product->is_flash_sale) ? '' : 'display:none;' }}">
                    <div class="mb-3">
                        <label class="form-label-custom">Flash Sale Price* <span class="form-label-sub">(In USD)</span></label>
                        <input type="number" step="0.01" name="flash_sale_price" class="form-control"
                               placeholder="e.g 9.99"
                               value="{{ old('flash_sale_price', $product->flash_sale_price) }}">
                        <small class="text-muted" style="font-size:.75rem;">This price overrides discount price during the sale</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Sale Starts At <span class="optional-badge">Optional</span></label>
                        <input type="datetime-local" name="flash_sale_starts_at" class="form-control"
                               value="{{ old('flash_sale_starts_at', $product->flash_sale_starts_at ? $product->flash_sale_starts_at->format('Y-m-d\TH:i') : '') }}">
                    </div>
                    <div class="mb-0">
                        <label class="form-label-custom">Sale Ends At <span class="optional-badge">Optional</span></label>
                        <input type="datetime-local" name="flash_sale_ends_at" class="form-control"
                               value="{{ old('flash_sale_ends_at', $product->flash_sale_ends_at ? $product->flash_sale_ends_at->format('Y-m-d\TH:i') : '') }}">
                        @if($product->is_flash_sale_active)
                            <small class="text-success d-block mt-1" style="font-size:.75rem;">
                                &#9989; Flash sale is currently <strong>ACTIVE</strong>
                            </small>
                        @elseif($product->is_flash_sale)
                            <small class="text-warning d-block mt-1" style="font-size:.75rem;">
                                &#8987; Flash sale is scheduled but not yet active
                            </small>
                        @endif
                        <small class="text-muted" style="font-size:.75rem;">Leave blank for no expiry</small>
                    </div>
                </div>
            </div>

            {{-- New Arrival --}}
            <div class="new-arrival-card">
                <div class="sidebar-card-title">&#10024; New Arrival</div>
                <div class="toggle-switch-wrap">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_new_arrival" id="is_new_arrival" value="1"
                               {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_new_arrival">Mark as New Arrival</label>
                    </div>
                </div>
                @if($product->is_new_arrival && $product->arrived_at)
                    <small class="text-success d-block mt-2" style="font-size:.75rem;">
                        &#10024; Marked as new arrival on <strong>{{ $product->arrived_at->format('d M Y, h:i A') }}</strong>
                    </small>
                @else
                    <small class="text-muted d-block mt-2" style="font-size:.75rem;">
                        Arrival date will be set automatically when enabled.
                    </small>
                @endif
            </div>

            {{-- Bestseller --}}
            <div class="bestseller-card">
                <div class="sidebar-card-title">&#11088; Bestseller</div>
                <div class="toggle-switch-wrap">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_bestseller" id="is_bestseller" value="1"
                               {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_bestseller">Mark as Bestseller</label>
                    </div>
                </div>
                @if($product->is_bestseller && $product->bestseller_at)
                    <small class="text-success d-block mt-2" style="font-size:.75rem;">
                        &#11088; Marked as bestseller on <strong>{{ $product->bestseller_at->format('d M Y, h:i A') }}</strong>
                    </small>
                @else
                    <small class="text-muted d-block mt-2" style="font-size:.75rem;">
                        Enable this toggle to publish product in the Bestsellers section.
                    </small>
                @endif
            </div>

            {{-- Feature Tags --}}
            <div class="sidebar-card">
                <div class="sidebar-card-title">Feature Tags</div>
                <div id="featureTagsContainer">
                    @php $featureTags = $product->feature_tags ?? []; @endphp
                    @if(count($featureTags) > 0)
                        @foreach($featureTags as $tag)
                            <div class="tag-row">
                                <input type="text"  name="tag_keyword[]" class="form-control" value="{{ $tag['keyword'] }}">
                                <input type="color" name="tag_color[]"   value="{{ $tag['color'] ?? '#000000' }}">
                                <button type="button" class="btn-remove-tag" onclick="removeTagRow(this)">&#10005;</button>
                            </div>
                        @endforeach
                    @else
                        <div class="tag-row">
                            <input type="text"  name="tag_keyword[]" class="form-control" placeholder="Enter Your Keyword">
                            <input type="color" name="tag_color[]"   value="#000000">
                            <button type="button" class="btn-remove-tag" onclick="removeTagRow(this)">&#10005;</button>
                        </div>
                    @endif
                </div>
                <button type="button" class="btn-add-tag mt-1" onclick="addTagRow()">+ Add More Field</button>
            </div>

            {{-- Tags --}}
            <div class="sidebar-card">
                <div class="sidebar-card-title">Tags</div>
                <select name="tags[]" id="product_tags" class="form-select" multiple>
                    @if($product->tags)
                        @foreach($product->tags as $tag)
                            <option value="{{ $tag }}" selected>{{ $tag }}</option>
                        @endforeach
                    @endif
                </select>
                <small class="text-muted" style="font-size:.75rem;">Type and press Enter to add tags</small>
            </div>

            <button type="submit" class="btn-update-product">Update Product</button>
        </div>

    </div>
</form>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
var URL_SUB          = "{{ route('admin.products.getSubCategories') }}";
var URL_CHILD        = "{{ route('admin.products.getChildCategories') }}";
var SAVED_SUB_ID     = {{ $product->sub_category_id       ? (int) $product->sub_category_id       : 'null' }};
var SAVED_CHILD_ID   = {{ $product->child_sub_category_id ? (int) $product->child_sub_category_id : 'null' }};
var newGalleryItems  = [];

$(document).ready(function () {

    // Rich text editors
    $('#product_description').summernote({ height: 200 });
    $('#return_policy').summernote({ height: 200 });

    // Select2 tag input
    $('#product_tags').select2({ tags: true, tokenSeparators: [','], placeholder: 'Type and press Enter' });

    // SEO toggle
    $('#allow_seo_checkbox').on('change', function () {
        if ($(this).is(':checked')) {
            $('#seo_fields').slideDown(250);
        } else {
            $('#seo_fields').slideUp(250);
            $('#meta_tags_input').val('');
            $('#meta_description_input').val('');
        }
    });

    // Category → Sub Category (AJAX) — also restores saved sub on page load
    $('#product_category').on('change', function () {
        var catId = $(this).val();
        $('#product_subcategory').html('<option value="">-- Select Sub Category (Optional) --</option>');
        $('#product_childcategory').html('<option value="">-- Select Sub Category First --</option>');

        if (!catId) {
            $('#sub_hint').text('Select a category above');
            return;
        }

        $('#sub_hint').html('<span style="color:#e67e22;">Loading...</span>');
        $.get(URL_SUB, { category_id: catId })
            .done(function (data) {
                var html = '<option value="">-- Select Sub Category (Optional) --</option>';
                $.each(data, function (i, r) { html += '<option value="' + r.id + '">' + r.sub_name + '</option>'; });
                $('#product_subcategory').html(html);
                $('#sub_hint').html(data.length
                    ? '<span style="color:green;">&#10003; ' + data.length + ' sub category found</span>'
                    : '<span style="color:#e67e22;">No sub categories found</span>');

                // Restore saved sub-category selection on page load
                if (SAVED_SUB_ID) {
                    $('#product_subcategory').val(SAVED_SUB_ID).trigger('change');
                    SAVED_SUB_ID = null;
                }
            })
            .fail(function (xhr) {
                $('#sub_hint').html('<span style="color:red;">Error ' + xhr.status + '</span>');
            });
    });

    // Sub Category → Child Category (AJAX) — also restores saved child on page load
    $('#product_subcategory').on('change', function () {
        var subId = $(this).val();
        $('#product_childcategory').html('<option value="">-- Select Child Category (Optional) --</option>');

        if (!subId) {
            $('#child_hint').text('Select a sub category above');
            return;
        }

        $('#child_hint').html('<span style="color:#e67e22;">Loading...</span>');
        $.get(URL_CHILD, { sub_category_id: subId })
            .done(function (data) {
                var html = '<option value="">-- Select Child Category (Optional) --</option>';
                $.each(data, function (i, r) { html += '<option value="' + r.id + '">' + r.child_sub_name + '</option>'; });
                $('#product_childcategory').html(html);
                $('#child_hint').html(data.length
                    ? '<span style="color:green;">&#10003; ' + data.length + ' child category found</span>'
                    : '<span style="color:#e67e22;">No child categories found</span>');

                // Restore saved child-category selection on page load
                if (SAVED_CHILD_ID) {
                    $('#product_childcategory').val(SAVED_CHILD_ID);
                    SAVED_CHILD_ID = null;
                }
            })
            .fail(function (xhr) {
                $('#child_hint').html('<span style="color:red;">Error ' + xhr.status + '</span>');
            });
    });

    // Upload type toggle
    $('#upload_type').on('change', function () {
        if ($(this).val() === 'url') {
            $('#file_upload_section').hide();
            $('#url_upload_section').show();
        } else {
            $('#url_upload_section').hide();
            $('#file_upload_section').show();
        }
    });

    // Feature image preview
    $('#feature_image_input').on('change', function () {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#featureImgPreview').attr('src', e.target.result).show();
                $('#featureImgPlaceholder').hide();
            };
            reader.readAsDataURL(file);
        }
    });

    // New gallery picker
    $('#galleryPicker').on('change', function () {
        Array.from(this.files).forEach(function (f) {
            newGalleryItems.push({ file: f, size: '', color: '' });
        });
        $(this).val('');
        renderNewGallery();
    });

    // Trigger category AJAX on page load to load and restore sub/child options
    if ($('#product_category').val()) {
        $('#product_category').trigger('change');
    }
});

// ── Toggle helpers ────────────────────────────────────────────────
function toggleUnlimited(cb) {
    document.getElementById('stock_input').disabled = cb.checked;
    if (cb.checked) document.getElementById('stock_input').value = '';
}

function toggleFlashSale(cb) {
    cb.checked ? $('#flashSaleFields').slideDown(250) : $('#flashSaleFields').slideUp(250);
}

// ── New gallery helpers ───────────────────────────────────────────
function renderNewGallery() {
    var container = $('#newGalleryPreview');
    container.empty();
    newGalleryItems.forEach(function (item, idx) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var card = $('<div class="gallery-card new-img" id="ngc_' + idx + '"></div>');
            card.append('<img src="' + e.target.result + '">');
            card.append('<input type="text" class="form-control form-control-sm" placeholder="Size" value="' + item.size + '" onchange="newGalleryItems[' + idx + '].size=this.value; rebuildNewGalleryInputs();">');
            card.append('<input type="text" class="form-control form-control-sm mt-1" placeholder="Color" value="' + item.color + '" onchange="newGalleryItems[' + idx + '].color=this.value; rebuildNewGalleryInputs();">');
            card.append('<button type="button" class="btn-rm" onclick="removeNewGallery(' + idx + ')">&#10005; Remove</button>');
            container.append(card);
        };
        reader.readAsDataURL(item.file);
    });
    rebuildNewGalleryInputs();
}

function rebuildNewGalleryInputs() {
    var container = $('#galleryFileInputs');
    container.empty();
    newGalleryItems.forEach(function (item) {
        var inputEl = document.createElement('input');
        inputEl.type  = 'file';
        inputEl.name  = 'gallery_images[]';
        inputEl.style.display = 'none';
        var dt = new DataTransfer();
        dt.items.add(item.file);
        inputEl.files = dt.files;
        container.append(inputEl);
        container.append('<input type="hidden" name="gallery_color[]" value="' + (item.color || '') + '">');
        container.append('<input type="hidden" name="gallery_size[]"  value="' + (item.size  || '') + '">');
    });
}

function removeNewGallery(idx) {
    newGalleryItems.splice(idx, 1);
    renderNewGallery();
}

function removeExistingGallery(name) {
    var el = document.getElementById('gex_' + name);
    if (el) el.remove();
}

// ── Variant helpers ───────────────────────────────────────────────
function addVariantRow() {
    $('#variantContainer').append(
        '<div class="variant-row">' +
        '<input type="text"   name="variant_size[]"  class="form-control form-control-sm" placeholder="e.g. M / XL">' +
        '<input type="color"  name="variant_color[]" value="#000000">' +
        '<input type="number" name="variant_stock[]" class="form-control form-control-sm" placeholder="0" min="0" value="0">' +
        '<input type="number" name="variant_price[]" class="form-control form-control-sm" placeholder="0.00" step="0.01" min="0">' +
        '<button type="button" class="btn-remove-variant" onclick="removeVariantRow(this)">&#10005;</button>' +
        '</div>'
    );
}

function removeVariantRow(btn) {
    if ($('#variantContainer .variant-row').length > 1) {
        $(btn).closest('.variant-row').remove();
    }
}

// ── Feature tag helpers ───────────────────────────────────────────
function addTagRow() {
    $('#featureTagsContainer').append(
        '<div class="tag-row">' +
        '<input type="text"  name="tag_keyword[]" class="form-control" placeholder="Enter Your Keyword">' +
        '<input type="color" name="tag_color[]"   value="#000000">' +
        '<button type="button" class="btn-remove-tag" onclick="removeTagRow(this)">&#10005;</button>' +
        '</div>'
    );
}

function removeTagRow(btn) {
    if ($('#featureTagsContainer .tag-row').length > 1) {
        $(btn).closest('.tag-row').remove();
    }
}
</script>

@endsection
