@extends('admin.master')

@section('main-content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Edit Digital Product</h4>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.digital-products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            {{-- 1. Product Info --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0">Product Info</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="form-group mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Product Name" value="{{ $product->name }}">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" class="form-control" rows="3" placeholder="Enter short description">{{ $product->short_description }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label mb-0">Description</label>
                            <button type="button" class="btn btn-sm btn-danger rounded-pill px-3">
                                <i class="bi bi-chat-dots-fill"></i> Generate Via AI
                            </button>
                        </div>
                        <div id="editor">{!! $product->description !!}</div>
                        <textarea name="description" id="description" class="d-none">{{ $product->description }}</textarea>
                    </div>
                </div>
            </div>

            {{-- 2. Generale Information --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0">Generale Information</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Select Category</label>
                            <select name="category_id" id="category_id" class="form-control custom-select">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Select Sub Categories</label>
                            <select name="sub_category_id" id="sub_category_id" class="form-control custom-select">
                                <option value="">Select Sub Category</option>
                                @foreach($subCategories ?? [] as $sub)
                                    <option value="{{ $sub->id }}" {{ $product->sub_category_id == $sub->id ? 'selected' : '' }}>{{ $sub->sub_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Select Brand</label>
                            <select name="brand_id" class="form-control custom-select">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label">Product SKU <i class="bi bi-info-circle text-muted"></i></label>
                                <a href="javascript:void(0)" id="generateSKU" class="text-primary small">Generate Code</a>
                            </div>
                            <input type="text" name="sku" id="sku" class="form-control" placeholder="Ex: 134543" value="{{ $product->sku }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Child Category</label>
                            <select name="child_sub_category_id" id="child_sub_category_id" class="form-control custom-select">
                                <option value="">Select Child Category</option>
                                @foreach($childSubCategories ?? [] as $child)
                                    <option value="{{ $child->id }}" {{ $product->child_sub_category_id == $child->id ? 'selected' : '' }}>{{ $child->child_sub_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. Digital Product Attachments --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0"><i class="bi bi-bar-chart-fill me-2"></i>Digital Product Attachments (Downloadable)</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Digital Additional Documents</label>
                        <div class="upload-box border-dashed rounded p-4 text-center" style="border: 2px dashed #dee2e6; cursor: pointer;" onclick="document.getElementById('product_file').click()">
                            <input type="file" name="product_file" id="product_file" class="d-none">
                            <i class="bi bi-file-earmark-arrow-up fs-1 text-muted"></i>
                            <p class="mb-0 mt-2 text-muted">Click to update file (Zip, PDF, etc.)</p>
                            @if($product->product_file)
                                <div class="mt-2 text-success"><i class="bi bi-check-circle"></i> Current: {{ $product->product_file }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="license-keys-section p-3 bg-light rounded border">
                        <label class="form-label fw-bold">License Keys</label>
                        <div id="license_keys_container">
                            @forelse($product->license_keys ?? [] as $key)
                                <div class="input-group mb-2 license-row">
                                    <input type="text" name="license_keys[]" class="form-control" placeholder="License Key" value="{{ $key }}">
                                    <button type="button" class="btn btn-outline-secondary" onclick="generateKey(this)">Generate key</button>
                                    <button type="button" class="btn btn-outline-danger remove-license"><i class="bi bi-trash"></i></button>
                                </div>
                            @empty
                                <div class="input-group mb-2 license-row">
                                    <input type="text" name="license_keys[]" class="form-control" placeholder="License Key">
                                    <button type="button" class="btn btn-outline-secondary" onclick="generateKey(this)">Generate key</button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="copyKey(this)">Copy key</button>
                                </div>
                            @endforelse
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button type="button" class="btn btn-success btn-sm" id="addLicense">
                                <i class="bi bi-plus"></i> Add License
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm">
                                Bulk Generate (3)
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. Price Information --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0">Price Information</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Buying Price</label>
                            <input type="number" step="0.01" name="buying_price" class="form-control" placeholder="Buying Price" value="{{ $product->buying_price }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Selling Price</label>
                            <input type="number" step="0.01" name="current_price" class="form-control" value="{{ $product->current_price }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Discount Price</label>
                            <input type="number" step="0.01" name="discount_price" class="form-control" value="{{ $product->discount_price }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Current Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- 5. Images --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0">Images</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Thumbnail <span class="text-primary small">(Ratio 1:1 (500 × 500 px))</span></label>
                            <div class="image-upload-wrapper border-dashed rounded text-center py-4" style="border: 2px dashed #ff0055; background: #fff5f8;" onclick="document.getElementById('feature_image').click()">
                                <input type="file" name="feature_image" id="feature_image" class="d-none" onchange="previewImg(this, 'feature_preview')">
                                <div id="feature_preview">
                                    @if($product->feature_image)
                                        <img src="{{ asset('uploads/products/' . $product->feature_image) }}" style="max-width: 100%; max-height: 180px; object-fit: contain;">
                                    @else
                                        <h2 class="text-muted mb-0">500 × 500</h2>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Additional Thumbnails <span class="text-primary small">(Multiple, 500 × 500 px)</span></label>
                            <div class="image-upload-wrapper border-dashed rounded text-center py-4" style="border: 2px dashed #ff0055; background: #f8f9fa;" onclick="document.getElementById('additional_thumbnail').click()">
                                <input type="file" name="additional_thumbnail[]" id="additional_thumbnail" class="d-none" multiple onchange="previewMultipleImg(this, 'additional_preview')">
                                <div id="additional_preview" class="row px-2">
                                    @forelse($product->additional_thumbnail ?? [] as $img)
                                        <div class="col-3 mb-2 position-relative">
                                            <img src="{{ asset('uploads/products/' . $img) }}" class="img-thumbnail" style="height: 80px; width: 100%; object-fit: cover;">
                                            <div class="mt-1 text-center">
                                                <input type="checkbox" name="keep_additional[]" value="{{ $img }}" checked> <small>Keep</small>
                                            </div>
                                        </div>
                                    @empty
                                        <h2 class="text-muted mb-0">500 × 500</h2>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gallery Images --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0">Gallery Images</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        @foreach($product->gallery_images ?? [] as $img)
                        <div class="col-md-2 mb-2 text-center position-relative">
                            <img src="{{ asset('uploads/products/' . $img) }}" class="img-thumbnail" style="height: 100px; width: 100%; object-fit: cover;">
                            <div class="mt-1">
                                <input type="checkbox" name="keep_gallery[]" value="{{ $img }}" checked> Keep
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <label>Add New Gallery Images</label>
                        <input type="file" name="gallery_images[]" class="form-control" multiple>
                    </div>
                </div>
            </div>

            {{-- 6. Upload or Add Product Video (Collapsible) --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0 d-flex align-items-center cursor-pointer" data-bs-toggle="collapse" data-bs-target="#videoCollapse" style="cursor: pointer;">
                    <i class="bi bi-caret-right-fill me-2"></i>
                    <h5 class="mb-0">Upload or Add Product Video</h5>
                </div>
                <div id="videoCollapse" class="collapse">
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Select Video Type</label>
                                <select name="video_type" id="video_type" class="form-control custom-select">
                                    <option value="file" {{ $product->video_type == 'file' ? 'selected' : '' }}>Upload Video File</option>
                                    <option value="youtube" {{ $product->video_type == 'youtube' ? 'selected' : '' }}>YouTube Link</option>
                                </select>
                            </div>
                            <div class="col-md-9 mb-3 {{ $product->video_type == 'youtube' ? 'd-none' : '' }}" id="video_file_input">
                                <label class="form-label">Product Video File</label>
                                <input type="file" name="video_file" class="form-control">
                                @if($product->video_type == 'file' && $product->video_url)
                                    <small class="text-success d-block mt-1">Current: {{ $product->video_url }}</small>
                                @endif
                            </div>
                            <div class="col-md-9 mb-3 {{ $product->video_type == 'file' ? 'd-none' : '' }}" id="video_url_input">
                                <label class="form-label">YouTube Video Link</label>
                                <input type="text" name="video_url" class="form-control" placeholder="YouTube Link" value="{{ $product->video_type == 'youtube' ? $product->video_url : '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 7. SEO Information (Collapsible) --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0 d-flex align-items-center cursor-pointer" data-bs-toggle="collapse" data-bs-target="#seoCollapse" style="cursor: pointer;">
                    <i class="bi bi-bar-chart-fill me-2"></i>
                    <h5 class="mb-0">SEO Information</h5>
                </div>
                <div id="seoCollapse" class="collapse">
                    <div class="card-body pt-0">
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" placeholder="Meta Title" value="{{ $product->meta_title }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" placeholder="Meta Description">{{ $product->meta_description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" placeholder="Keywords" value="{{ $product->meta_keywords }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Footer --}}
            <div class="d-flex justify-content-end gap-2 mb-5">
                <button type="submit" class="btn btn-danger px-5" style="background: #ff0055; border-color: #ff0055;">Update Product</button>
            </div>

        </form>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
    .form-label { font-weight: 500; color: #444; }
    .card { border-radius: 12px; }
    .card-header h5 { color: #333; font-weight: 600; }
    .image-upload-wrapper { min-height: 200px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; }
    .image-upload-wrapper:hover { opacity: 0.8; }
    .border-dashed { border-style: dashed !important; }
    #editor { height: 250px; background: #fff; }
    .ql-toolbar.ql-snow { border-top-left-radius: 8px; border-top-right-radius: 8px; background: #f8f9fa; }
    .ql-container.ql-snow { border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; }
    .cursor-pointer { cursor: pointer; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Quill Editor
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // On form submit, copy Quill content to hidden textarea
        const form = document.querySelector('form');
        form.onsubmit = function() {
            document.querySelector('#description').value = quill.root.innerHTML;
        };

        // Video Toggle logic
        $('#video_type').on('change', function() {
            if ($(this).val() === 'youtube') {
                $('#video_url_input').removeClass('d-none');
                $('#video_file_input').addClass('d-none');
            } else {
                $('#video_url_input').addClass('d-none');
                $('#video_file_input').removeClass('d-none');
            }
        });
    });

    function previewImg(input, targetId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#' + targetId).html('<img src="' + e.target.result + '" style="max-width: 100%; max-height: 180px; object-fit: contain;">');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewMultipleImg(input, targetId) {
        if (input.files) {
            $('#' + targetId).empty();
            Array.from(input.files).forEach(file => {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + targetId).append(`
                        <div class="col-3 mb-2">
                            <img src="${e.target.result}" class="img-thumbnail" style="height: 80px; width: 100%; object-fit: cover;">
                        </div>
                    `);
                }
                reader.readAsDataURL(file);
            });
        }
    }

    function generateKey(btn) {
        let key = Math.random().toString(36).substr(2, 4).toUpperCase() + '-' +
                  Math.random().toString(36).substr(2, 4).toUpperCase() + '-' +
                  Math.random().toString(36).substr(2, 4).toUpperCase() + '-' +
                  Math.random().toString(36).substr(2, 4).toUpperCase();
        $(btn).closest('.license-row').find('input').val(key);
    }

    function copyKey(btn) {
        let input = $(btn).closest('.license-row').find('input');
        input.select();
        document.execCommand("copy");
        alert('Key copied to clipboard!');
    }

    $(document).ready(function() {
        // SKU Generator
        $('#generateSKU').on('click', function() {
            let sku = 'DIG-' + Math.random().toString(36).substr(2, 8).toUpperCase();
            $('#sku').val(sku);
        });

        // Add License Key Row
        $('#addLicense').on('click', function() {
            let html = `
                <div class="input-group mb-2 license-row">
                    <input type="text" name="license_keys[]" class="form-control" placeholder="License Key">
                    <button type="button" class="btn btn-outline-secondary" onclick="generateKey(this)">Generate key</button>
                    <button type="button" class="btn btn-outline-danger remove-license"><i class="bi bi-trash"></i></button>
                </div>`;
            $('#license_keys_container').append(html);
        });

        $(document).on('click', '.remove-license', function() {
            $(this).closest('.license-row').remove();
        });

        // Category Chain
        $('#category_id').on('change', function() {
            let catId = $(this).val();
            $('#sub_category_id').html('<option value="">Loading...</option>');
            $.get("{{ route('admin.products.getSubCategories') }}", {category_id: catId}, function(data) {
                let html = '<option value="">Select Sub Category</option>';
                data.forEach(function(sub) {
                    html += `<option value="${sub.id}">${sub.sub_name}</option>`;
                });
                $('#sub_category_id').html(html);
            });
        });

        $('#sub_category_id').on('change', function() {
            let subId = $(this).val();
            $('#child_sub_category_id').html('<option value="">Loading...</option>');
            $.get("{{ route('admin.products.getChildCategories') }}", {sub_category_id: subId}, function(data) {
                let html = '<option value="">Select Child Category</option>';
                data.forEach(function(child) {
                    html += `<option value="${child.id}">${child.child_sub_name}</option>`;
                });
                $('#child_sub_category_id').html(html);
            });
        });
    });
</script>
@endpush
@endsection
