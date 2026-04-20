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
    .btn-back             { background:#1a2b6b; color:#fff; border:none; border-radius:20px; padding:6px 18px; font-size:.85rem; text-decoration:none; display:inline-flex; align-items:center; gap:5px; }
    .btn-back:hover       { background:#152259; color:#fff; }
    .btn-create-product   { background:#1a2b6b; color:#fff; border:none; border-radius:4px; padding:10px 32px; font-size:.95rem; font-weight:600; width:100%; margin-top:10px; }
    .btn-create-product:hover { background:#152259; color:#fff; }
    .btn-upload-img       { background:#1a2b6b; color:#fff; border:none; border-radius:4px; padding:10px 24px; font-size:.88rem; display:inline-flex; align-items:center; gap:6px; cursor:pointer; }
    .btn-upload-img:hover { background:#152259; }
    .btn-set-gallery      { background:#1a2b6b; color:#fff; border:none; border-radius:4px; padding:8px 20px; font-size:.88rem; display:inline-flex; align-items:center; gap:5px; cursor:pointer; }
    .btn-set-gallery:hover{ background:#152259; }
    .btn-add-tag          { background:none; border:1px dashed #1a2b6b; color:#1a2b6b; border-radius:4px; padding:6px 16px; font-size:.85rem; cursor:pointer; width:100%; }
    .btn-add-tag:hover    { background:#e8ecf8; }

    /* ── Feature image box ── */
    .feature-img-box     { border:2px dashed #ced4da; border-radius:8px; min-height:200px; display:flex; align-items:center; justify-content:center; background:#f8f9fa; overflow:hidden; cursor:pointer; }
    .feature-img-box img { width:100%; height:200px; object-fit:cover; display:none; }

    /* ── Sidebar cards ── */
    .sidebar-card        { background:#fff; border:1px solid #e9ecef; border-radius:8px; padding:18px; margin-bottom:18px; }
    .sidebar-card-title  { font-size:.9rem; font-weight:700; color:#1a2b6b; margin-bottom:14px; }

    /* ── Flash Sale card ── */
    .flash-sale-card              { border:1px solid #fcd34d; border-radius:8px; background:#fffbeb; padding:18px; margin-bottom:18px; }
    .flash-sale-card .sidebar-card-title { color:#b45309; }
    .flash-sale-fields            { margin-top:12px; }

    /* ── New Arrival card ── */
    .new-arrival-card              { border:1px solid #6ee7b7; border-radius:8px; background:#f0fdf4; padding:18px; margin-bottom:18px; }
    .new-arrival-card .sidebar-card-title { color:#065f46; }

    /* ── Bestseller card ── */
    .bestseller-card              { border:1px solid #c4b5fd; border-radius:8px; background:#f5f3ff; padding:18px; margin-bottom:18px; }
    .bestseller-card .sidebar-card-title { color:#5b21b6; }

    /* ── Toggle switch ── */
    .toggle-switch-wrap           { display:flex; align-items:center; gap:10px; }
    .toggle-switch-wrap .form-check-label { font-size:.85rem; font-weight:600; cursor:pointer; }

    /* ── Tag rows ── */
    .tag-row                     { display:flex; gap:8px; align-items:center; margin-bottom:8px; }
    .tag-row input[type="text"]  { flex:1; }
    .tag-row input[type="color"] { width:40px; height:38px; border:1px solid #ced4da; border-radius:4px; padding:2px; cursor:pointer; }
    .btn-remove-tag              { background:#dc3545; color:#fff; border:none; border-radius:50%; width:28px; height:28px; font-size:.8rem; cursor:pointer; flex-shrink:0; }

    /* ── Variant rows ── */
    .variant-table-wrap          { display:none; margin-top:10px; } /* ✅ default hidden */
    .variant-table-wrap.has-rows { display:block; }
    .variant-header              { display:grid; grid-template-columns:1fr 80px 80px 90px 32px; gap:6px; margin-bottom:4px; }
    .variant-header span         { font-size:.75rem; font-weight:600; color:#6c757d; }
    .variant-row                 { display:grid; grid-template-columns:1fr 80px 80px 90px 32px; gap:6px; align-items:center; margin-bottom:8px; }
    .variant-row input[type="color"] { width:100%; height:38px; border:1px solid #ced4da; border-radius:4px; padding:2px; cursor:pointer; }
    .btn-remove-variant          { background:#dc3545; color:#fff; border:none; border-radius:50%; width:28px; height:28px; font-size:.8rem; cursor:pointer; flex-shrink:0; display:flex; align-items:center; justify-content:center; }

    /* ── Gallery ── */
    .gallery-preview             { display:flex; flex-wrap:wrap; gap:10px; margin-top:10px; }
    .gallery-card                { background:#f8f9fa; border:1px solid #dee2e6; border-radius:8px; padding:6px; width:130px; }
    .gallery-card img            { width:100%; height:75px; object-fit:cover; border-radius:4px; }
    .gallery-card input          { font-size:.72rem; margin-top:4px; }
    .gallery-card .btn-rm        { background:#dc3545; color:#fff; border:none; border-radius:4px; width:100%; margin-top:4px; font-size:.72rem; padding:2px 0; cursor:pointer; }

    /* ── SEO section ── */
    .seo-section                 { border:1px solid #e0e7ff; border-radius:8px; background:#f8f9ff; padding:16px; margin-top:6px; }
    .seo-toggle-label            { font-size:.9rem; font-weight:600; color:#1a2b6b; cursor:pointer; user-select:none; display:flex; align-items:center; gap:8px; }
    .seo-toggle-label input[type="checkbox"] { width:17px; height:17px; cursor:pointer; accent-color:#1a2b6b; }

    /* ── Variant add btn ── */
    .btn-add-variant-main {
        background: none;
        border: 1px dashed #1a2b6b;
        color: #1a2b6b;
        border-radius: 4px;
        padding: 8px 16px;
        font-size: .85rem;
        cursor: pointer;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background .2s;
    }
    .btn-add-variant-main:hover { background: #e8ecf8; }
</style>

{{-- Page header --}}
<div class="d-flex align-items-center gap-3 mb-2">
    <h4 style="font-size:1.1rem;font-weight:600;margin:0;">Add Product</h4>
    <a href="{{ route('admin.products.index') }}" class="btn-back">&#8592; Back</a>
</div>
<small class="text-muted" style="font-size:.82rem;">
    Dashboard &rsaquo; Products &rsaquo; All Products &rsaquo; Add Product
</small>

@if($errors->any())
    <div class="alert alert-danger mt-2 py-2">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="mt-3" id="productForm">
    @csrf
    {{-- Hidden gallery file inputs (rebuilt by JS) --}}
    <div id="galleryFileInputs"></div>

    <div class="row g-3">

        {{-- ═══════════ LEFT COLUMN ═══════════ --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">

                {{-- Product Name --}}
                <div class="mb-3">
                    <label class="form-label-custom">Product Name* <span class="form-label-sub">(In Any Language)</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Product Name" value="{{ old('name') }}">
                </div>

                {{-- SKU / Vendor --}}
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">SKU <span class="optional-badge">Optional</span></label>
                        <input type="text" name="sku" class="form-control" placeholder="Auto-generated if empty" value="{{ old('sku') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Vendor <span class="optional-badge">Optional</span></label>
                        <input type="text" name="vendor" class="form-control" placeholder="e.g. Test Stores" value="{{ old('vendor') }}">
                    </div>
                </div>

                {{-- Product Type --}}
                <div class="mb-3">
                    <label class="form-label-custom">Product Type*</label>
                    <select name="product_type" class="form-select">
                        @foreach(\App\Models\Product::$productTypes as $value => $label)
                            <option value="{{ $value }}" {{ old('product_type', 'digital') == $value ? 'selected' : '' }}>
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
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sub Category --}}
                <div class="mb-3">
                    <label class="form-label-custom">Sub Category <span class="optional-badge">Optional</span></label>
                    <select name="sub_category_id" id="product_subcategory" class="form-select">
                        <option value="">-- Select Category First --</option>
                    </select>
                    <small class="select-hint" id="sub_hint">Select a category above to load sub categories</small>
                </div>

                {{-- Child Category --}}
                <div class="mb-3">
                    <label class="form-label-custom">Child Category <span class="optional-badge">Optional</span></label>
                    <select name="child_sub_category_id" id="product_childcategory" class="form-select">
                        <option value="">-- Select Sub Category First --</option>
                    </select>
                    <small class="select-hint" id="child_hint">Select a sub category above to load child categories</small>
                </div>

                {{-- Upload Type --}}
                <div class="mb-3">
                    <label class="form-label-custom">Select Upload Type*</label>
                    <select name="upload_type" id="upload_type" class="form-select">
                        <option value="file" {{ old('upload_type', 'file') === 'file' ? 'selected' : '' }}>Upload By File</option>
                        <option value="url"  {{ old('upload_type') === 'url'  ? 'selected' : '' }}>Upload By URL</option>
                    </select>
                </div>

                {{-- File upload --}}
                <div class="mb-3" id="file_upload_section">
                    <label class="form-label-custom">Select File*</label>
                    <input type="file" name="product_file" class="form-control">
                </div>

                {{-- URL upload --}}
                <div class="mb-3 d-none" id="url_upload_section">
                    <label class="form-label-custom">Product URL*</label>
                    <input type="text" name="product_url" class="form-control"
                           placeholder="Enter product download URL" value="{{ old('product_url') }}">
                </div>

                {{-- SEO --}}
                <div class="mb-3">
                    <label class="seo-toggle-label">
                        <input type="checkbox" id="allow_seo_checkbox" {{ old('allow_seo') ? 'checked' : '' }}>
                        Allow Product SEO
                    </label>
                    <div class="seo-section mt-3" id="seo_fields" style="{{ old('allow_seo') ? '' : 'display:none;' }}">
                        <div class="mb-3">
                            <label class="form-label-custom">Meta Tags</label>
                            <input type="text" name="meta_tags" id="meta_tags_input" class="form-control"
                                   placeholder="Enter meta tags (comma separated)" value="{{ old('meta_tags') }}">
                            <small class="text-muted" style="font-size:.75rem;">e.g. shoes, running, sport</small>
                        </div>
                        <div class="mb-0">
                            <label class="form-label-custom">Meta Description</label>
                            <textarea name="meta_description" id="meta_description_input" class="form-control" rows="4"
                                      placeholder="Meta Description">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- ══ Variants ══
                     ✅ Default: শুধু "+ Add Variant" বাটন দেখাবে
                     ✅ বাটন ক্লিক করলে header + row দেখাবে
                --}}
                <div class="mb-3">
                    <label class="form-label-custom">
                        Product Variants <span class="optional-badge">Optional</span>
                    </label>
                    <small class="text-muted d-block mb-2" style="font-size:.75rem;">
                        কোনো variant না থাকলে "+ Add Variant" বাটনে ক্লিক করার দরকার নেই।
                    </small>

                    {{-- Header + Rows (default: hidden) --}}
                    <div class="variant-table-wrap" id="variantTableWrap">
                        <div class="variant-header">
                            <span>Size / Name</span>
                            <span>Color</span>
                            <span>Stock</span>
                            <span>Price (BDT)</span>
                            <span></span>
                        </div>
                        <div id="variantContainer"></div>
                    </div>

                    {{-- Add Variant button --}}
                    <button type="button" class="btn-add-variant-main" id="btnAddVariant" onclick="addVariantRow()">
                        <span style="font-size:1.1rem;line-height:1;">+</span> Add Variant
                    </button>
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label-custom">Product Description*</label>
                    <textarea name="description" id="product_description" class="form-control" rows="6">{{ old('description') }}</textarea>
                </div>

                {{-- Return Policy --}}
                <div class="mb-3">
                    <label class="form-label-custom">Product Buy/Return Policy <span class="form-label-sub">(Optional)</span></label>
                    <textarea name="return_policy" id="return_policy" class="form-control" rows="6">{{ old('return_policy') }}</textarea>
                </div>

            </div>
        </div>

        {{-- ═══════════ RIGHT COLUMN ═══════════ --}}
        <div class="col-lg-4">

            {{-- Feature Image --}}
            <div class="sidebar-card">
                <div class="sidebar-card-title">Feature Image *</div>
                <div class="feature-img-box" onclick="document.getElementById('feature_image_input').click()">
                    <img id="featureImgPreview" src="" alt="Preview">
                    <div id="featureImgPlaceholder">
                        <button type="button" class="btn-upload-img">&#8679; Upload Image Here</button>
                    </div>
                </div>
                <input type="file" name="feature_image" id="feature_image_input" accept="image/*" class="d-none">
            </div>

            {{-- Gallery --}}
            <div class="sidebar-card">
                <div class="sidebar-card-title">Product Gallery Images <span class="optional-badge">Optional</span></div>
                <input type="file" id="galleryPicker" accept="image/*" multiple class="d-none">
                <button type="button" class="btn-set-gallery" onclick="document.getElementById('galleryPicker').click()">+ Select Images</button>
                <small class="text-muted d-block mt-1" style="font-size:.75rem;">Each image can have a Size &amp; Color tag</small>
                <div class="gallery-preview" id="galleryPreview"></div>
            </div>

            {{-- Pricing & Stock --}}
            <div class="sidebar-card">
                <div class="mb-3">
                    <label class="form-label-custom">Product Current Price* <span class="form-label-sub">(In BDT)</span></label>
                    <input type="number" step="0.01" name="current_price" class="form-control"
                           placeholder="e.g 500" value="{{ old('current_price') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Product Discount Price <span class="form-label-sub">(Optional)</span></label>
                    <input type="number" step="0.01" name="discount_price" class="form-control"
                           placeholder="e.g 450" value="{{ old('discount_price') }}">
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <label class="form-label-custom mb-0">Stock Quantity*</label>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="is_unlimited" id="is_unlimited" value="1"
                                   onchange="toggleUnlimited(this)" {{ old('is_unlimited') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_unlimited" style="font-size:.8rem;">Unlimited</label>
                        </div>
                    </div>
                    <input type="number" min="0" name="stock" id="stock_input" class="form-control"
                           placeholder="e.g 100" value="{{ old('stock', 0) }}"
                           {{ old('is_unlimited') ? 'disabled' : '' }}>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Youtube Video URL <span class="form-label-sub">(Optional)</span></label>
                    <input type="text" name="youtube_url" class="form-control"
                           placeholder="https://youtube.com/watch?v=..." value="{{ old('youtube_url') }}">
                </div>
            </div>

            {{-- Flash Sale --}}
            <div class="flash-sale-card">
                <div class="sidebar-card-title">&#9889; Flash Sale</div>
                <div class="toggle-switch-wrap mb-3">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_flash_sale" id="is_flash_sale" value="1"
                               onchange="toggleFlashSale(this)" {{ old('is_flash_sale') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_flash_sale">Enable Flash Sale</label>
                    </div>
                </div>
                <div class="flash-sale-fields" id="flashSaleFields" style="{{ old('is_flash_sale') ? '' : 'display:none;' }}">
                    <div class="mb-3">
                        <label class="form-label-custom">Flash Sale Price* <span class="form-label-sub">(In BDT)</span></label>
                        <input type="number" step="0.01" name="flash_sale_price" class="form-control"
                               placeholder="e.g 399" value="{{ old('flash_sale_price') }}">
                        <small class="text-muted" style="font-size:.75rem;">This price overrides discount price during the sale</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Sale Starts At <span class="optional-badge">Optional</span></label>
                        <input type="datetime-local" name="flash_sale_starts_at" class="form-control"
                               value="{{ old('flash_sale_starts_at') }}">
                    </div>
                    <div class="mb-0">
                        <label class="form-label-custom">Sale Ends At <span class="optional-badge">Optional</span></label>
                        <input type="datetime-local" name="flash_sale_ends_at" class="form-control"
                               value="{{ old('flash_sale_ends_at') }}">
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
                               {{ old('is_new_arrival') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_new_arrival">Mark as New Arrival</label>
                    </div>
                </div>
                <small class="text-muted d-block mt-2" style="font-size:.75rem;">
                    Product will appear in the New Arrivals section.
                </small>
            </div>

            {{-- Bestseller --}}
            <div class="bestseller-card">
                <div class="sidebar-card-title">&#11088; Bestseller</div>
                <div class="toggle-switch-wrap">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_bestseller" id="is_bestseller" value="1"
                               {{ old('is_bestseller') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_bestseller">Mark as Bestseller</label>
                    </div>
                </div>
                <small class="text-muted d-block mt-2" style="font-size:.75rem;">
                    Product will appear in the Bestsellers section.
                </small>
            </div>

            {{-- Feature Tags --}}
            <div class="sidebar-card">
                <div class="sidebar-card-title">Feature Tags</div>
                <div id="featureTagsContainer">
                    <div class="tag-row">
                        <input type="text"  name="tag_keyword[]" class="form-control" placeholder="Enter Your Keyword">
                        <input type="color" name="tag_color[]"   value="#000000">
                        <button type="button" class="btn-remove-tag" onclick="removeTagRow(this)">&#10005;</button>
                    </div>
                </div>
                <button type="button" class="btn-add-tag mt-1" onclick="addTagRow()">+ Add More Field</button>
            </div>

            {{-- Tags --}}
            <div class="sidebar-card">
                <div class="sidebar-card-title">Tags</div>
                <select name="tags[]" id="product_tags" class="form-select" multiple></select>
                <small class="text-muted" style="font-size:.75rem;">Type and press Enter to add tags</small>
            </div>

            <button type="submit" class="btn-create-product">Create Product</button>
        </div>

    </div>
</form>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
var URL_SUB   = "{{ route('admin.products.getSubCategories') }}";
var URL_CHILD = "{{ route('admin.products.getChildCategories') }}";
var galleryItems = [];

$(document).ready(function () {

    // Rich text editors
    $('#product_description').summernote({ height: 200 });
    $('#return_policy').summernote({ height: 200 });

    // Select2 tag input
    $('#product_tags').select2({
        tags: true,
        tokenSeparators: [','],
        placeholder: 'Type and press Enter'
    });

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

    // Category → Sub Category (AJAX)
    $('#product_category').on('change', function () {
        var catId = $(this).val();
        $('#product_subcategory').html('<option value="">-- Select Sub Category (Optional) --</option>');
        $('#product_childcategory').html('<option value="">-- Select Sub Category First --</option>');
        $('#child_hint').text('Select a sub category above to load child categories');

        if (!catId) {
            $('#sub_hint').text('Select a category above to load sub categories');
            return;
        }

        $('#sub_hint').html('<span style="color:#e67e22;">Loading...</span>');
        $.get(URL_SUB, { category_id: catId })
            .done(function (data) {
                var html = '<option value="">-- Select Sub Category (Optional) --</option>';
                $.each(data, function (i, r) {
                    html += '<option value="' + r.id + '">' + r.sub_name + '</option>';
                });
                $('#product_subcategory').html(html);
                $('#sub_hint').html(data.length
                    ? '<span style="color:green;">&#10003; ' + data.length + ' sub category found</span>'
                    : '<span style="color:#e67e22;">No sub categories found</span>');
            })
            .fail(function () {
                $('#sub_hint').html('<span style="color:red;">Failed to load sub categories</span>');
            });
    });

    // Sub Category → Child Category (AJAX)
    $('#product_subcategory').on('change', function () {
        var subId = $(this).val();
        $('#product_childcategory').html('<option value="">-- Select Child Category (Optional) --</option>');

        if (!subId) {
            $('#child_hint').text('Select a sub category above to load child categories');
            return;
        }

        $('#child_hint').html('<span style="color:#e67e22;">Loading...</span>');
        $.get(URL_CHILD, { sub_category_id: subId })
            .done(function (data) {
                var html = '<option value="">-- Select Child Category (Optional) --</option>';
                $.each(data, function (i, r) {
                    html += '<option value="' + r.id + '">' + r.child_sub_name + '</option>';
                });
                $('#product_childcategory').html(html);
                $('#child_hint').html(data.length
                    ? '<span style="color:green;">&#10003; ' + data.length + ' child category found</span>'
                    : '<span style="color:#e67e22;">No child categories found</span>');
            })
            .fail(function () {
                $('#child_hint').html('<span style="color:red;">Failed to load child categories</span>');
            });
    });

    // Upload type toggle
    $('#upload_type').on('change', function () {
        if ($(this).val() === 'url') {
            $('#file_upload_section').addClass('d-none');
            $('#url_upload_section').removeClass('d-none');
        } else {
            $('#url_upload_section').addClass('d-none');
            $('#file_upload_section').removeClass('d-none');
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

    // Gallery picker
    $('#galleryPicker').on('change', function () {
        Array.from(this.files).forEach(function (f) {
            galleryItems.push({ file: f, size: '', color: '' });
        });
        $(this).val('');
        renderGallery();
    });
});

// ── Toggle helpers ─────────────────────────────────────────────
function toggleUnlimited(cb) {
    document.getElementById('stock_input').disabled = cb.checked;
    if (cb.checked) document.getElementById('stock_input').value = '';
}

function toggleFlashSale(cb) {
    cb.checked ? $('#flashSaleFields').slideDown(250) : $('#flashSaleFields').slideUp(250);
}

// ── Gallery helpers ────────────────────────────────────────────
function renderGallery() {
    var preview = $('#galleryPreview');
    preview.empty();
    galleryItems.forEach(function (item, idx) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var card = $('<div class="gallery-card" id="gc_' + idx + '"></div>');
            card.append('<img src="' + e.target.result + '">');
            card.append('<input type="text" class="form-control form-control-sm" placeholder="Size (e.g. M)" value="' + item.size + '" onchange="galleryItems[' + idx + '].size=this.value; rebuildGalleryInputs();">');
            card.append('<input type="text" class="form-control form-control-sm mt-1" placeholder="Color (e.g. Red)" value="' + item.color + '" onchange="galleryItems[' + idx + '].color=this.value; rebuildGalleryInputs();">');
            card.append('<button type="button" class="btn-rm" onclick="removeGalleryItem(' + idx + ')">&#10005; Remove</button>');
            preview.append(card);
        };
        reader.readAsDataURL(item.file);
    });
    rebuildGalleryInputs();
}

function rebuildGalleryInputs() {
    var container = $('#galleryFileInputs');
    container.empty();
    galleryItems.forEach(function (item) {
        var inputEl = $('<input type="file" name="gallery_images[]" class="d-none">');
        container.append(inputEl);
        var dt = new DataTransfer();
        dt.items.add(item.file);
        inputEl[0].files = dt.files;
        container.append('<input type="hidden" name="gallery_color[]" value="' + (item.color || '') + '">');
        container.append('<input type="hidden" name="gallery_size[]"  value="' + (item.size  || '') + '">');
    });
}

function removeGalleryItem(idx) {
    galleryItems.splice(idx, 1);
    renderGallery();
}

// ── Variant helpers ────────────────────────────────────────────
// ✅ প্রথমে table hidden, + Add Variant ক্লিকে row যোগ হয় এবং table দেখা যায়
function addVariantRow() {
    var wrap = document.getElementById('variantTableWrap');
    wrap.classList.add('has-rows'); // table দেখাও

    var row = document.createElement('div');
    row.className = 'variant-row';
    row.innerHTML =
        '<input type="text"   name="variant_size[]"  class="form-control form-control-sm" placeholder="e.g. M / XL / Red Shirt">' +
        '<input type="color"  name="variant_color[]" value="#1a2b6b">' +
        '<input type="number" name="variant_stock[]" class="form-control form-control-sm" placeholder="0" min="0" value="0">' +
        '<input type="number" name="variant_price[]" class="form-control form-control-sm" placeholder="0.00" step="0.01" min="0">' +
        '<button type="button" class="btn-remove-variant" onclick="removeVariantRow(this)" title="Remove">&#10005;</button>';

    document.getElementById('variantContainer').appendChild(row);
}

function removeVariantRow(btn) {
    var container = document.getElementById('variantContainer');
    btn.closest('.variant-row').remove();

    // সব row চলে গেলে table আবার hide করো
    if (container.querySelectorAll('.variant-row').length === 0) {
        document.getElementById('variantTableWrap').classList.remove('has-rows');
    }
}

// ── Feature tag helpers ────────────────────────────────────────
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
