@extends('admin.master')

@section('main-content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

<style>
    .form-label-custom { font-size:.88rem; font-weight:600; color:#333; margin-bottom:5px; display:block; }
    .form-label-sub    { font-size:.78rem; color:#6c757d; font-weight:400; }
    .optional-badge    { font-size:.72rem; color:#fff; background:#6c757d; border-radius:10px; padding:2px 8px; margin-left:5px; font-weight:500; }
    .btn-back { background:#1a2b6b; color:#fff; border:none; border-radius:20px; padding:6px 18px; font-size:.85rem; text-decoration:none; display:inline-flex; align-items:center; gap:5px; }
    .btn-back:hover { background:#152259; color:#fff; }
    .btn-update-product { background:#1a2b6b; color:#fff; border:none; border-radius:4px; padding:10px 32px; font-size:.95rem; font-weight:600; width:100%; margin-top:10px; }
    .btn-update-product:hover { background:#152259; color:#fff; }
    .feature-img-box { border:2px dashed #ced4da; border-radius:8px; min-height:200px; display:flex; align-items:center; justify-content:center; background:#f8f9fa; overflow:hidden; cursor:pointer; }
    .feature-img-box img { width:100%; height:200px; object-fit:cover; }
    .btn-upload-img { background:#1a2b6b; color:#fff; border:none; border-radius:4px; padding:10px 24px; font-size:.88rem; display:inline-flex; align-items:center; gap:6px; cursor:pointer; }
    .btn-upload-img:hover { background:#152259; }
    .btn-set-gallery { background:#1a2b6b; color:#fff; border:none; border-radius:4px; padding:8px 20px; font-size:.88rem; display:inline-flex; align-items:center; gap:5px; cursor:pointer; }
    .btn-set-gallery:hover { background:#152259; }
    .tag-row { display:flex; gap:8px; align-items:center; margin-bottom:8px; }
    .tag-row input[type="text"] { flex:1; }
    .tag-row input[type="color"] { width:40px; height:38px; border:1px solid #ced4da; border-radius:4px; padding:2px; cursor:pointer; }
    .btn-remove-tag { background:#dc3545; color:#fff; border:none; border-radius:50%; width:28px; height:28px; font-size:.8rem; cursor:pointer; flex-shrink:0; }
    .btn-add-tag { background:none; border:1px dashed #1a2b6b; color:#1a2b6b; border-radius:4px; padding:6px 16px; font-size:.85rem; cursor:pointer; width:100%; }
    .btn-add-tag:hover { background:#e8ecf8; }
    .sidebar-card { background:#fff; border:1px solid #e9ecef; border-radius:8px; padding:18px; margin-bottom:18px; }
    .sidebar-card-title { font-size:.9rem; font-weight:700; color:#1a2b6b; margin-bottom:14px; }
    .select-hint { font-size:.75rem; color:#6c757d; margin-top:3px; display:block; }
    .variant-row { display:grid; grid-template-columns:1fr 80px 80px 90px 32px; gap:6px; align-items:center; margin-bottom:8px; }
    .variant-row input[type="color"] { width:100%; height:38px; border:1px solid #ced4da; border-radius:4px; padding:2px; cursor:pointer; }
    .btn-remove-variant { background:#dc3545; color:#fff; border:none; border-radius:50%; width:28px; height:28px; font-size:.8rem; cursor:pointer; flex-shrink:0; }
    .variant-header { display:grid; grid-template-columns:1fr 80px 80px 90px 32px; gap:6px; margin-bottom:4px; }
    .variant-header span { font-size:.75rem; font-weight:600; color:#6c757d; }
    .gallery-grid { display:flex; flex-wrap:wrap; gap:10px; margin-top:10px; }
    .gallery-card { background:#f8f9fa; border:1px solid #dee2e6; border-radius:8px; padding:6px; width:130px; }
    .gallery-card img { width:100%; height:75px; object-fit:cover; border-radius:4px; }
    .gallery-card .meta { font-size:.7rem; color:#555; margin-top:3px; }
    .gallery-card input { font-size:.72rem; margin-top:4px; }
    .gallery-card .btn-rm { background:#dc3545; color:#fff; border:none; border-radius:4px; width:100%; margin-top:4px; font-size:.72rem; padding:2px 0; cursor:pointer; }
    .gallery-card.new-img { border-color:#ffc107; background:#fff3cd; }
</style>

<div class="d-flex align-items-center gap-3 mb-2">
    <h4 style="font-size:1.1rem;font-weight:600;margin:0;">Edit Product</h4>
    <a href="{{ route('products.index') }}" class="btn-back">&#8592; Back</a>
</div>
<small class="text-muted" style="font-size:.82rem;">
    Dashboard &rsaquo; Products &rsaquo; All Products &rsaquo; Edit Product
</small>

@if($errors->any())
<div class="alert alert-danger mt-2 py-2">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
@csrf
@method('PUT')
<div id="galleryFileInputs"></div>

<div class="row g-3">
    {{-- LEFT --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4">

            <div class="mb-3">
                <label class="form-label-custom">Product Name*</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}">
            </div>

            <div class="row g-2 mb-3">
                <div class="col-md-6">
                    <label class="form-label-custom">SKU <span class="optional-badge">Optional</span></label>
                    <input type="text" name="sku" class="form-control" value="{{ $product->sku }}" placeholder="Auto-generated if empty">
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Vendor <span class="optional-badge">Optional</span></label>
                    <input type="text" name="vendor" class="form-control" value="{{ $product->vendor }}" placeholder="e.g. Test Stores">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Product Type*</label>
                <select name="product_type" class="form-select">
                    @foreach(\App\Models\Product::$productTypes as $value => $label)
                        <option value="{{ $value }}" {{ $product->product_type == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Category*</label>
                <select name="category_id" id="product_category" class="form-select">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Sub Category <span class="optional-badge">Optional</span></label>
                <select name="sub_category_id" id="product_subcategory" class="form-select">
                    <option value="">-- Select Sub Category (Optional) --</option>
                    @foreach($subCategories as $sub)
                        <option value="{{ $sub->id }}" {{ $product->sub_category_id == $sub->id ? 'selected' : '' }}>
                            {{ $sub->sub_name }}
                        </option>
                    @endforeach
                </select>
                <small class="select-hint" id="sub_hint">Not required</small>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Child Category <span class="optional-badge">Optional</span></label>
                <select name="child_sub_category_id" id="product_childcategory" class="form-select">
                    <option value="">-- Select Child Category (Optional) --</option>
                    @foreach($childSubCategories as $child)
                        <option value="{{ $child->id }}" {{ $product->child_sub_category_id == $child->id ? 'selected' : '' }}>
                            {{ $child->child_sub_name }}
                        </option>
                    @endforeach
                </select>
                <small class="select-hint" id="child_hint">Not required</small>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Select Upload Type*</label>
                <select name="upload_type" id="upload_type" class="form-select">
                    <option value="file" {{ $product->upload_type == 'file' ? 'selected' : '' }}>Upload By File</option>
                    <option value="url"  {{ $product->upload_type == 'url'  ? 'selected' : '' }}>Upload By URL</option>
                </select>
            </div>

            <div class="mb-3" id="file_upload_section" {{ $product->upload_type == 'url' ? 'style=display:none' : '' }}>
                <label class="form-label-custom">Select File</label>
                @if($product->product_file)
                    <p class="text-muted mb-1" style="font-size:.82rem;">Current: <strong>{{ $product->product_file }}</strong></p>
                @endif
                <input type="file" name="product_file" class="form-control">
            </div>

            <div class="mb-3 {{ $product->upload_type != 'url' ? 'd-none' : '' }}" id="url_upload_section">
                <label class="form-label-custom">Product URL*</label>
                <input type="text" name="product_url" class="form-control" placeholder="Enter product download URL" value="{{ $product->product_url }}">
            </div>

            {{-- Variants --}}
            <div class="mb-3">
                <label class="form-label-custom">Product Variants <span class="optional-badge">Optional</span></label>
                <div class="variant-header">
                    <span>Size</span><span>Color</span><span>Stock</span><span>Price (USD)</span><span></span>
                </div>
                <div id="variantContainer">
                    @if($product->variants && count($product->variants) > 0)
                        @foreach($product->variants as $v)
                        <div class="variant-row">
                            <input type="text"   name="variant_size[]"  class="form-control form-control-sm" value="{{ $v['size'] ?? '' }}">
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

            <div class="mb-3">
                <label class="form-label-custom">Product Description*</label>
                <textarea name="description" id="product_description" class="form-control" rows="6">{{ $product->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Product Buy/Return Policy <span class="form-label-sub">(Optional)</span></label>
                <textarea name="return_policy" id="return_policy" class="form-control" rows="6">{{ $product->return_policy }}</textarea>
            </div>

        </div>
    </div>

    {{-- RIGHT --}}
    <div class="col-lg-4">

        <div class="sidebar-card">
            <div class="sidebar-card-title">Feature Image *</div>
            <div class="feature-img-box" onclick="document.getElementById('feature_image_input').click()">
                @if($product->feature_image && file_exists(public_path('uploads/products/'.$product->feature_image)))
                    <img id="featureImgPreview" src="{{ asset('uploads/products/'.$product->feature_image) }}" style="display:block;">
                @else
                    <img id="featureImgPreview" src="" style="display:none;">
                    <div id="featureImgPlaceholder">
                        <button type="button" class="btn-upload-img">&#8679; Upload Image Here</button>
                    </div>
                @endif
            </div>
            <input type="file" name="feature_image" id="feature_image_input" accept="image/*" class="d-none">
        </div>

        <div class="sidebar-card">
            <div class="sidebar-card-title">Product Gallery Images</div>
            <input type="file" id="galleryPicker" accept="image/*" multiple class="d-none">
            <button type="button" class="btn-set-gallery" onclick="document.getElementById('galleryPicker').click()">+ Add Images</button>
            <small class="text-muted d-block mt-1" style="font-size:.75rem;">&#10005; = remove existing | Yellow = new upload</small>
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
                            <img src="{{ asset('uploads/products/'.$imgName) }}" alt="">
                            @if($imgColor || $imgSize)
                                <div class="meta">@if($imgColor)&#127912; {{ $imgColor }}@endif @if($imgSize)&middot; {{ $imgSize }}@endif</div>
                            @endif
                            <button type="button" class="btn-rm" onclick="removeExistingGallery('{{ $imgName }}')">&#10005; Remove</button>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="gallery-grid" id="newGalleryPreview"></div>
        </div>

        <div class="sidebar-card">
            <div class="mb-3">
                <label class="form-label-custom">Product Current Price* <span class="form-label-sub">(In USD)</span></label>
                <input type="number" step="0.01" name="current_price" class="form-control" value="{{ $product->current_price }}">
            </div>
            <div class="mb-3">
                <label class="form-label-custom">Product Discount Price <span class="form-label-sub">(Optional)</span></label>
                <input type="number" step="0.01" name="discount_price" class="form-control" value="{{ $product->discount_price }}">
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <label class="form-label-custom mb-0">Stock Quantity*</label>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_unlimited" id="is_unlimited" value="1"
                               onchange="toggleUnlimited(this)" {{ $product->is_unlimited ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_unlimited" style="font-size:.8rem;">Unlimited</label>
                    </div>
                </div>
                <input type="number" min="0" name="stock" id="stock_input" class="form-control"
                       value="{{ $product->stock }}" {{ $product->is_unlimited ? 'disabled' : '' }}>
            </div>
            <div class="mb-3">
                <label class="form-label-custom">Youtube Video URL <span class="form-label-sub">(Optional)</span></label>
                <input type="text" name="youtube_url" class="form-control" value="{{ $product->youtube_url }}">
            </div>
        </div>

        <div class="sidebar-card">
            <div class="sidebar-card-title">Feature Tags</div>
            <div id="featureTagsContainer">
                @if($product->feature_tags && count($product->feature_tags) > 0)
                    @foreach($product->feature_tags as $tag)
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
var URL_SUBCATEGORIES   = "{{ route('products.getSubCategories') }}";
var URL_CHILDCATEGORIES = "{{ route('products.getChildCategories') }}";
var SAVED_SUB_ID   = {{ $product->sub_category_id       ? (int)$product->sub_category_id       : 'null' }};
var SAVED_CHILD_ID = {{ $product->child_sub_category_id ? (int)$product->child_sub_category_id : 'null' }};
var newGalleryItems = [];

$(document).ready(function () {
    $('#product_description').summernote({ height: 200 });
    $('#return_policy').summernote({ height: 200 });
    $('#product_tags').select2({ tags: true, tokenSeparators: [','], placeholder: 'Type and press Enter' });

    $('#product_category').on('change', function () {
        var catId = $(this).val();
        $('#product_subcategory').html('<option value="">-- Select Sub Category (Optional) --</option>');
        $('#product_childcategory').html('<option value="">-- Select Sub Category First --</option>');
        if (!catId) { $('#sub_hint').text('Select a category above'); return; }
        $('#sub_hint').text('Loading...');
        $.get(URL_SUBCATEGORIES, { category_id: catId })
            .done(function(data) {
                var html = '<option value="">-- Select Sub Category (Optional) --</option>';
                $.each(data, function(i,r){ html += '<option value="'+r.id+'">'+r.sub_name+'</option>'; });
                $('#product_subcategory').html(html);
                $('#sub_hint').text(data.length + ' sub category found');
                if (SAVED_SUB_ID) { $('#product_subcategory').val(SAVED_SUB_ID).trigger('change'); SAVED_SUB_ID = null; }
            })
            .fail(function(xhr){ $('#sub_hint').text('Error ' + xhr.status); });
    });

    $('#product_subcategory').on('change', function () {
        var subId = $(this).val();
        $('#product_childcategory').html('<option value="">-- Select Child Category (Optional) --</option>');
        if (!subId) { $('#child_hint').text('Select a sub category above'); return; }
        $('#child_hint').text('Loading...');
        $.get(URL_CHILDCATEGORIES, { sub_category_id: subId })
            .done(function(data) {
                var html = '<option value="">-- Select Child Category (Optional) --</option>';
                $.each(data, function(i,r){ html += '<option value="'+r.id+'">'+r.child_sub_name+'</option>'; });
                $('#product_childcategory').html(html);
                $('#child_hint').text(data.length + ' child category found');
                if (SAVED_CHILD_ID) { $('#product_childcategory').val(SAVED_CHILD_ID); SAVED_CHILD_ID = null; }
            })
            .fail(function(xhr){ $('#child_hint').text('Error ' + xhr.status); });
    });

    $('#upload_type').on('change', function () {
        if ($(this).val() === 'url') { $('#file_upload_section').addClass('d-none'); $('#url_upload_section').removeClass('d-none'); }
        else { $('#url_upload_section').addClass('d-none'); $('#file_upload_section').removeClass('d-none'); }
    });

    $('#feature_image_input').on('change', function () {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) { $('#featureImgPreview').attr('src', e.target.result).show(); $('#featureImgPlaceholder').hide(); };
            reader.readAsDataURL(file);
        }
    });

    $('#galleryPicker').on('change', function () {
        Array.from(this.files).forEach(function(f){ newGalleryItems.push({ file: f, size: '', color: '' }); });
        $(this).val('');
        renderNewGallery();
    });

    if ($('#product_category').val()) $('#product_category').trigger('change');
});

function toggleUnlimited(cb) {
    document.getElementById('stock_input').disabled = cb.checked;
    if (cb.checked) document.getElementById('stock_input').value = '';
}

function renderNewGallery() {
    var container = $('#newGalleryPreview');
    container.empty();
    newGalleryItems.forEach(function(item, idx) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var card = $('<div class="gallery-card new-img" id="ngc_'+idx+'"></div>');
            card.append('<img src="'+e.target.result+'">');
            card.append('<input type="text" class="form-control form-control-sm" placeholder="Size" value="'+item.size+'" onchange="newGalleryItems['+idx+'].size=this.value;rebuildNewGalleryInputs();">');
            card.append('<input type="text" class="form-control form-control-sm mt-1" placeholder="Color" value="'+item.color+'" onchange="newGalleryItems['+idx+'].color=this.value;rebuildNewGalleryInputs();">');
            card.append('<button type="button" class="btn-rm" onclick="removeNewGallery('+idx+')">&#10005; Remove</button>');
            container.append(card);
        };
        reader.readAsDataURL(item.file);
    });
    rebuildNewGalleryInputs();
}

function rebuildNewGalleryInputs() {
    var container = $('#galleryFileInputs');
    container.empty();
    newGalleryItems.forEach(function(item) {
        var inputEl = document.createElement('input');
        inputEl.type = 'file'; inputEl.name = 'gallery_images[]'; inputEl.style.display = 'none';
        var dt = new DataTransfer(); dt.items.add(item.file); inputEl.files = dt.files;
        container.append(inputEl);
        container.append('<input type="hidden" name="gallery_color[]" value="'+(item.color||'')+'">');
        container.append('<input type="hidden" name="gallery_size[]"  value="'+(item.size||'')+'">');
    });
}

function removeNewGallery(idx)       { newGalleryItems.splice(idx, 1); renderNewGallery(); }
function removeExistingGallery(name) { var el = document.getElementById('gex_' + name); if (el) el.remove(); }

function addVariantRow() {
    $('#variantContainer').append('<div class="variant-row"><input type="text" name="variant_size[]" class="form-control form-control-sm" placeholder="e.g. M / XL"><input type="color" name="variant_color[]" value="#000000"><input type="number" name="variant_stock[]" class="form-control form-control-sm" placeholder="0" min="0" value="0"><input type="number" name="variant_price[]" class="form-control form-control-sm" placeholder="0.00" step="0.01" min="0"><button type="button" class="btn-remove-variant" onclick="removeVariantRow(this)">&#10005;</button></div>');
}
function removeVariantRow(btn) { if ($('#variantContainer .variant-row').length > 1) $(btn).closest('.variant-row').remove(); }

function addTagRow() {
    $('#featureTagsContainer').append('<div class="tag-row"><input type="text" name="tag_keyword[]" class="form-control" placeholder="Enter Your Keyword"><input type="color" name="tag_color[]" value="#000000"><button type="button" class="btn-remove-tag" onclick="removeTagRow(this)">&#10005;</button></div>');
}
function removeTagRow(btn) { if ($('#featureTagsContainer .tag-row').length > 1) $(btn).closest('.tag-row').remove(); }
</script>

@endsection
