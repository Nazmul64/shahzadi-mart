@extends('saller.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    {{-- Header section --}}
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Edit Product</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size: 13px;">
                        <li class="breadcrumb-item"><a href="{{ route('saller.dashboard') }}" class="text-muted text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('saller.products.index') }}" class="text-muted text-decoration-none">Products</a></li>
                        <li class="breadcrumb-item active text-dark">Edit</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('saller.products.index') }}" class="btn btn-sm btn-white border shadow-sm px-3 rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <form action="{{ route('saller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            @method('PUT')
            <div class="row g-4">
                {{-- Left Column: Core Info --}}
                <div class="col-lg-8">
                    {{-- Product Type & Basic Info --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-3">
                                    <i class="bi bi-info-circle text-primary"></i>
                                </div>
                                <h6 class="mb-0 fw-bold">Basic Information</h6>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label small fw-semibold">Product Type <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check custom-radio">
                                            <input class="form-check-input" type="radio" name="product_type" id="type_physical" value="physical" {{ $product->product_type == 'physical' ? 'checked' : '' }} onchange="toggleProductType()">
                                            <label class="form-check-label" for="type_physical">Physical Product</label>
                                        </div>
                                        <div class="form-check custom-radio">
                                            <input class="form-check-input" type="radio" name="product_type" id="type_digital" value="digital" {{ $product->product_type == 'digital' ? 'checked' : '' }} onchange="toggleProductType()">
                                            <label class="form-check-label" for="type_digital">Digital Product</label>
                                        </div>
                                        <div class="form-check custom-radio">
                                            <input class="form-check-input" type="radio" name="product_type" id="type_license" value="license" {{ $product->product_type == 'license' ? 'checked' : '' }} onchange="toggleProductType()">
                                            <label class="form-check-label" for="type_license">License/Keys</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-semibold">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control rounded-3" value="{{ $product->name }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-semibold">Short Description</label>
                                    <div id="short_editor" style="height: 120px; border-radius: 8px;">{!! $product->short_description !!}</div>
                                    <textarea name="short_description" id="short_description_input" class="d-none"></textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Classification --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-success bg-opacity-10 p-2 rounded-3">
                                    <i class="bi bi-grid text-success"></i>
                                </div>
                                <h6 class="mb-0 fw-bold">Classification</h6>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-select rounded-3 select2" required>
                                        <option value="">Choose Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Sub Category</label>
                                    <select name="sub_category_id" id="sub_category_id" class="form-select rounded-3 select2">
                                        @foreach($subCategories as $sub)
                                            <option value="{{ $sub->id }}" {{ $product->sub_category_id == $sub->id ? 'selected' : '' }}>{{ $sub->sub_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Child Category</label>
                                    <select name="child_sub_category_id" id="child_sub_category_id" class="form-select rounded-3 select2">
                                        @foreach($childSubCategories as $child)
                                            <option value="{{ $child->id }}" {{ $product->child_sub_category_id == $child->id ? 'selected' : '' }}>{{ $child->child_sub_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Physical Product Variants --}}
                    <div id="physical_variants_section" class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center cursor-pointer" data-bs-toggle="collapse" data-bs-target="#variantCollapse">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-warning bg-opacity-10 p-2 rounded-3">
                                    <i class="bi bi-palette text-warning"></i>
                                </div>
                                <h6 class="mb-0 fw-bold">Product Attributes & Variants</h6>
                            </div>
                            <i class="bi bi-chevron-down opacity-50"></i>
                        </div>
                        <div id="variantCollapse" class="collapse show">
                            <div class="card-body pt-0">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Brand</label>
                                        <select name="brand_ids[]" class="form-select select2-multiple" multiple>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ in_array($brand->id, $product->brand_ids ?? []) ? 'selected' : '' }}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Color</label>
                                        <select name="color_ids[]" class="form-select select2-multiple" multiple>
                                            @foreach($colors as $color)
                                                <option value="{{ $color->id }}" {{ in_array($color->id, $product->color_ids ?? []) ? 'selected' : '' }}>{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Size</label>
                                        <select name="size_ids[]" class="form-select select2-multiple" multiple>
                                            @foreach($sizes as $size)
                                                <option value="{{ $size->id }}" {{ in_array($size->id, $product->size_ids ?? []) ? 'selected' : '' }}>{{ $size->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Unit</label>
                                        <select name="unit_ids[]" class="form-select select2-multiple" multiple>
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->id }}" {{ in_array($unit->id, $product->unit_ids ?? []) ? 'selected' : '' }}>{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Digital Product Specifics --}}
                    <div id="digital_section" class="card border-0 shadow-sm rounded-4 mb-4" style="display: none;">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-info bg-opacity-10 p-2 rounded-3">
                                    <i class="bi bi-cloud-download text-info"></i>
                                </div>
                                <h6 class="mb-0 fw-bold">Digital Product Configuration</h6>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label small fw-semibold">Upload Type</label>
                                    <select name="upload_type" id="upload_type" class="form-select rounded-3" onchange="toggleUploadType()">
                                        <option value="file" {{ $product->upload_type == 'file' ? 'selected' : '' }}>Local File Upload</option>
                                        <option value="url" {{ $product->upload_type == 'url' ? 'selected' : '' }}>External Download Link</option>
                                    </select>
                                </div>
                                <div id="upload_file_div" class="col-md-12">
                                    <label class="form-label small fw-semibold">Product File</label>
                                    <input type="file" name="product_file" class="form-control rounded-3">
                                    @if($product->product_file)
                                        <p class="mt-1 small">Current: <span class="text-primary">{{ $product->product_file }}</span></p>
                                    @endif
                                </div>
                                <div id="upload_url_div" class="col-md-12" style="display: none;">
                                    <label class="form-label small fw-semibold">External URL</label>
                                    <input type="url" name="product_url" class="form-control rounded-3" value="{{ $product->product_url }}">
                                </div>
                                
                                {{-- License Keys --}}
                                <div id="license_keys_section" class="col-md-12 mt-3" style="{{ in_array($product->product_type, ['digital', 'license']) ? '' : 'display: none;' }}">
                                    <label class="form-label small fw-semibold d-flex justify-content-between align-items-center">
                                        <span>License Keys / Serials</span>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-info text-white" style="font-size: 10px;" onclick="generateAllKeys()">Generate All</button>
                                            <button type="button" class="btn btn-sm btn-outline-primary" style="font-size: 10px;" onclick="addLicenseKey()">+ Add Key</button>
                                        </div>
                                    </label>
                                    <div id="license_keys_container">
                                        @if($product->license_keys && is_array($product->license_keys))
                                            @foreach($product->license_keys as $key)
                                                <div class="input-group mb-2 shadow-sm">
                                                    <input type="text" name="license_keys[]" class="form-control" value="{{ $key }}">
                                                    <button class="btn btn-light border" type="button" onclick="generateKey(this)" title="Generate Key"><i class="bi bi-magic"></i></button>
                                                    <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">×</button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="input-group mb-2 shadow-sm">
                                                <input type="text" name="license_keys[]" class="form-control" placeholder="Enter key or serial number">
                                                <button class="btn btn-light border" type="button" onclick="generateKey(this)" title="Generate Key"><i class="bi bi-magic"></i></button>
                                                <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">×</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Media: Video --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-danger bg-opacity-10 p-2 rounded-3">
                                    <i class="bi bi-play-circle text-danger"></i>
                                </div>
                                <h6 class="mb-0 fw-bold">Product Video</h6>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Video Source</label>
                                    <select name="video_type" id="video_type" class="form-select rounded-3" onchange="toggleVideoSource()">
                                        <option value="youtube" {{ $product->video_type == 'youtube' ? 'selected' : '' }}>YouTube URL</option>
                                        <option value="file" {{ $product->video_type == 'file' ? 'selected' : '' }}>Video File Upload</option>
                                    </select>
                                </div>
                                <div id="video_url_div" class="col-md-6">
                                    <label class="form-label small fw-semibold">YouTube URL</label>
                                    <input type="url" name="youtube_url" class="form-control rounded-3" value="{{ $product->youtube_url }}">
                                </div>
                                <div id="video_file_div" class="col-md-6" style="display: none;">
                                    <label class="form-label small fw-semibold">Video File</label>
                                    <input type="file" name="video_file" class="form-control rounded-3" accept="video/*">
                                    @if($product->video_file && $product->video_type == 'file')
                                        <p class="mt-1 small">Current: <span class="text-primary">{{ $product->video_file }}</span></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">Detailed Description <span class="text-danger">*</span></h6>
                                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3" style="font-size: 11px; background: #ff0055; border: none;">
                                    <i class="bi bi-chat-dots-fill me-1"></i> Generate Via AI
                                </button>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div id="editor" style="height: 300px; border-radius: 0 0 12px 12px;">{!! $product->description !!}</div>
                            <textarea name="description" id="description_input" class="d-none"></textarea>
                        </div>
                    </div>

                </div>

                {{-- Right Column: Sidebars --}}
                <div class="col-lg-4">
                    {{-- Action Card --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-3 rounded-3 shadow-sm fw-bold border-0" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                                    <i class="bi bi-cloud-check me-2"></i> Update Product
                                </button>
                                <a href="{{ route('saller.products.index') }}" class="btn btn-light py-2 rounded-3 border fw-semibold">
                                    Cancel
                                </a>
                            </div>
                            <hr class="my-4">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">SKU</label>
                                <div class="input-group shadow-sm">
                                    <input type="text" name="sku" id="sku_input" class="form-control border-0 bg-light" value="{{ $product->sku }}">
                                    <button class="btn btn-white border-start" type="button" onclick="generateSKU()"><i class="bi bi-arrow-repeat"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pricing & Stock --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="mb-0 fw-bold">Pricing & Stock</h6>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Buying Price <span class="text-muted">(Internal)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">৳</span>
                                    <input type="number" name="buying_price" class="form-control border-start-0 ps-0" value="{{ $product->buying_price }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Selling Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">৳</span>
                                    <input type="number" name="current_price" class="form-control border-start-0 ps-0 fw-bold text-primary" value="{{ $product->current_price }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Discount Price</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">৳</span>
                                    <input type="number" name="discount_price" class="form-control border-start-0 ps-0" value="{{ $product->discount_price }}">
                                </div>
                            </div>
                            <div id="stock_section" class="mb-0">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label small fw-semibold mb-0">Available Stock</label>
                                    <div class="form-check form-switch small">
                                        <input class="form-check-input" type="checkbox" name="is_unlimited" id="unlimited_stock" onchange="toggleStock(this)" {{ $product->is_unlimited ? 'checked' : '' }}>
                                        <label class="form-check-label text-muted" for="unlimited_stock">Unlimited</label>
                                    </div>
                                </div>
                                <input type="number" name="stock" id="stock_input" class="form-control bg-light border-0" value="{{ $product->stock ?? 0 }}" {{ $product->is_unlimited ? 'disabled' : '' }}>
                            </div>
                        </div>
                    </div>

                    {{-- Feature Image --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="mb-0 fw-bold">Feature Image</h6>
                        </div>
                        <div class="card-body pt-0 text-center">
                            <div class="mb-3">
                                @if($product->feature_image)
                                    <img src="{{ asset('uploads/products/'.$product->feature_image) }}" class="img-fluid rounded-4 shadow-sm mb-3" id="feature-preview" style="max-height: 200px">
                                @endif
                            </div>
                            <input type="file" name="feature_image" class="form-control rounded-pill" onchange="previewImage(this, 'feature-preview')">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .cursor-pointer { cursor: pointer; }
    .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple {
        border: 1px solid #dee2e6; border-radius: 0.5rem; min-height: 40px; padding-top: 4px;
    }    /* Select2 Premium Styling */
    .select2-container--default .select2-selection--single, 
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        min-height: 42px;
        padding: 5px;
        transition: border-color 0.2s;
    }
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #3b82f6;
        outline: 0;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        color: #1e293b;
        font-size: 13px;
    }
    .select2-dropdown {
        border: 0;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin-top: 5px;
    }
    /* Quill Styling */
    .ql-toolbar.ql-snow { border: 1px solid #dee2e6; border-radius: 8px 8px 0 0; background: #f8fafc; }
    .ql-container.ql-snow { border: 1px solid #dee2e6; border-radius: 0 0 8px 8px; }

</style>


{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        $('.select2').select2({ width: '100%' });
        $('.select2-multiple').select2({ width: '100%', multiple: true });
        
        // Quill Editor for Full Description
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Quill Editor for Short Description
        var shortQuill = new Quill('#short_editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });

        // Sync Quill content with hidden inputs on form submission
        $('form').on('submit', function() {
            $('#description_input').val(quill.root.innerHTML);
            $('#short_description_input').val(shortQuill.root.innerHTML);
        });

        
        toggleProductType();
        toggleUploadType();
        toggleVideoSource();
    });

    function toggleProductType() {
        const type = $('input[name="product_type"]:checked').val();
        if(type === 'physical') {
            $('#physical_variants_section').fadeIn();
            $('#digital_section').fadeOut();
            $('#stock_section').fadeIn();
            $('#license_keys_section').hide();
        } else {
            $('#physical_variants_section').fadeOut();
            $('#digital_section').fadeIn();
            $('#stock_section').fadeOut();
            if(type === 'license' || type === 'digital') {
                $('#license_keys_section').fadeIn();
            } else {
                $('#license_keys_section').hide();
            }
        }

    }

    function toggleUploadType() {
        const utype = $('#upload_type').val();
        if(utype === 'file') {
            $('#upload_file_div').show();
            $('#upload_url_div').hide();
        } else {
            $('#upload_file_div').hide();
            $('#upload_url_div').show();
        }
    }

    function toggleVideoSource() {
        const vtype = $('#video_type').val();
        if(vtype === 'youtube') {
            $('#video_url_div').show();
            $('#video_file_div').hide();
        } else {
            $('#video_url_div').hide();
            $('#video_file_div').show();
        }
    }

    function addLicenseKey() {
        const html = `<div class="input-group mb-2 shadow-sm">
            <input type="text" name="license_keys[]" class="form-control" placeholder="Enter key or serial number">
            <button class="btn btn-light border" type="button" onclick="generateKey(this)" title="Generate Key"><i class="bi bi-magic"></i></button>
            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">×</button>
        </div>`;
        $('#license_keys_container').append(html);
    }

    function generateKey(btn) {
        const key = Math.random().toString(36).substr(2, 4).toUpperCase() + '-' + 
                    Math.random().toString(36).substr(2, 4).toUpperCase() + '-' + 
                    Math.random().toString(36).substr(2, 4).toUpperCase();
        $(btn).closest('.input-group').find('input').val(key);
    }

    function generateAllKeys() {
        $('#license_keys_container .input-group').each(function() {
            generateKey($(this).find('button')[0]);
        });
    }


    function toggleStock(checkbox) {
        $('#stock_input').prop('disabled', checkbox.checked).css('opacity', checkbox.checked ? '0.5' : '1');
    }

    function generateSKU() {
        const sku = 'SKU-' + Math.random().toString(36).substr(2, 7).toUpperCase();
        $('#sku_input').val(sku);
    }

    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                if($('#'+previewId).length) {
                    $('#'+previewId).attr('src', e.target.result);
                } else {
                    $(input).before(`<img src="${e.target.result}" class="img-fluid rounded-4 shadow-sm mb-3" id="${previewId}" style="max-height: 200px">`);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Dependent Dropdowns
    $('#category_id').on('change', function() {
        const id = $(this).val();
        if(id) {
            $.get("{{ route('saller.products.get_sub_categories') }}", {category_id: id}, function(data) {
                let html = '<option value="">Select Sub Category</option>';
                data.forEach(item => { html += `<option value="${item.id}">${item.sub_name}</option>`; });
                $('#sub_category_id').html(html).trigger('change');
            });
        }
    });

    $('#sub_category_id').on('change', function() {
        const id = $(this).val();
        if(id) {
            $.get("{{ route('saller.products.get_child_categories') }}", {sub_category_id: id}, function(data) {
                let html = '<option value="">Select Child Category</option>';
                data.forEach(item => { html += `<option value="${item.id}">${item.child_sub_name}</option>`; });
                $('#child_sub_category_id').html(html).trigger('change');
            });
        }
    });
</script>
@endsection
