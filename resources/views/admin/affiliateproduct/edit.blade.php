@extends('admin.master')

@section('main-content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    .card { border: none; box-shadow: 0 0 8px rgba(0,0,0,.06); border-radius: 8px; }
    .card-header { background: #fff; border-bottom: 1px solid #f0f0f0; border-radius: 8px 8px 0 0 !important; padding: 14px 20px; }
    .card-body { padding: 1.4rem; }
    .form-select, .form-control { font-size: 13px; }
    .section-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #6c757d; font-weight: 700; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 2px solid #f0f0f0; }

    .feature-image-box {
        width: 100%; height: 185px;
        border: 2px dashed #ced4da; border-radius: 6px;
        background: #f8f9fa;
        display: flex; align-items: center; justify-content: center;
        position: relative; overflow: hidden; cursor: pointer;
        transition: border-color .2s;
    }
    .feature-image-box:hover { border-color: #2d3e6e; }
    .feature-image-box img { width: 100%; height: 100%; object-fit: cover; }
    .feature-image-box .upload-overlay { position: absolute; text-align: center; }
    .feature-image-box .upload-overlay i { font-size: 28px; color: #adb5bd; display: block; margin-bottom: 6px; }
    .feature-image-box .upload-overlay span { font-size: 12px; color: #adb5bd; }

    .gallery-wrap { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
    .gallery-item { width: 75px; height: 65px; border-radius: 5px; overflow: hidden; position: relative; border: 1px solid #dee2e6; }
    .gallery-item img { width: 100%; height: 100%; object-fit: cover; }
    .gallery-item .rm { position: absolute; top: 2px; right: 2px; width: 18px; height: 18px; background: rgba(220,53,69,.9); border: none; border-radius: 50%; color: #fff; font-size: 11px; cursor: pointer; padding: 0; display: flex; align-items: center; justify-content: center; }
    .gallery-item.marked { opacity: .3; }
    .gallery-item.marked .rm { display: none; }

    .toggle-section { display: none; }
    .toggle-group { border-top: 1px solid #f0f0f0; padding-top: 12px; margin-top: 6px; }

    .tag-color-swatch { width: 38px; height: 34px; padding: 2px; border-radius: 4px; cursor: pointer; flex-shrink: 0; }

    .color-tags-wrap { display: flex; flex-wrap: wrap; gap: 6px; padding: 6px 8px; min-height: 42px; border: 1px solid #ced4da; border-radius: 4px; background: #fff; align-items: center; }
    .color-chip { display: inline-flex; align-items: center; gap: 5px; padding: 3px 8px 3px 6px; border-radius: 20px; font-size: 12px; font-weight: 500; }
    .color-chip .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
    .color-chip .rm-chip { background: none; border: none; font-size: 14px; line-height: 1; cursor: pointer; padding: 0; margin-left: 2px; opacity: .8; }

    .size-tags-wrap { display: flex; flex-wrap: wrap; gap: 6px; padding: 6px 8px; min-height: 42px; border: 1px solid #ced4da; border-radius: 4px; background: #fff; align-items: center; }
    .size-chip { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; background: #2d3e6e; color: #fff; }
    .size-chip .rm-chip { background: none; border: none; color: #fff; font-size: 13px; line-height: 1; cursor: pointer; padding: 0; margin-left: 4px; opacity: .75; }

    .rm-tag-row { width: 30px; height: 30px; padding: 0; flex-shrink: 0; }

    .note-editor.note-frame { border: 1px solid #ced4da !important; border-radius: 4px !important; }
    .note-editor.note-frame .note-toolbar { background: #f8f9fa !important; border-bottom: 1px solid #ced4da !important; padding: 5px 6px !important; }
    .note-editor.note-frame .note-statusbar { background: #f8f9fa !important; border-top: 1px solid #ced4da !important; }
    .note-btn { font-size: 12px !important; }

    .submit-bar { background: #fff; border-top: 1px solid #f0f0f0; padding: 16px 0; margin-top: 10px; position: sticky; bottom: 0; z-index: 10; }
</style>

<div class="container-fluid">

    {{-- Breadcrumb --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Edit Affiliate Product</h4>
                <div class="page-title-right d-flex align-items-center gap-2">
                    <ol class="breadcrumb m-0 me-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('affiliateproduct.index') }}">Affiliate Products</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                    <a href="{{ route('affiliateproduct.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>



    <form action="{{ route('affiliateproduct.update', $product->id) }}" method="POST"
          enctype="multipart/form-data" id="affiliateForm">
        @csrf @method('PUT')

        <div class="row g-3">

            {{-- ══════════════ LEFT COLUMN ══════════════ --}}
            <div class="col-lg-8">

                {{-- Basic Info --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <p class="section-label mb-0"><i class="mdi mdi-information-outline me-1"></i>Basic Information</p>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="product_name"
                                   class="form-control @error('product_name') is-invalid @enderror"
                                   value="{{ old('product_name', $product->product_name) }}">
                            @error('product_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold">Product SKU <span class="text-danger">*</span></label>
                                <input type="text" name="product_sku"
                                       class="form-control @error('product_sku') is-invalid @enderror"
                                       value="{{ old('product_sku', $product->product_sku) }}">
                                @error('product_sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold">Product Stock <small class="text-muted fw-normal">(empty = Always Available)</small></label>
                                <input type="number" name="product_stock"
                                       class="form-control @error('product_stock') is-invalid @enderror"
                                       placeholder="e.g. 20" min="0"
                                       value="{{ old('product_stock', $product->product_stock) }}">
                                @error('product_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-semibold">Affiliate Link <span class="text-danger">*</span></label>
                            <input type="url" name="product_affiliate_link"
                                   class="form-control @error('product_affiliate_link') is-invalid @enderror"
                                   value="{{ old('product_affiliate_link', $product->product_affiliate_link) }}">
                            @error('product_affiliate_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Category --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <p class="section-label mb-0"><i class="mdi mdi-tag-multiple-outline me-1"></i>Category</p>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="categorySelect"
                                        class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label fw-semibold">Sub Category</label>
                                <select name="sub_category_id" id="subCategorySelect" class="form-select">
                                    <option value="">Select Sub Category</option>
                                    @foreach($subCategories as $sub)
                                        <option value="{{ $sub->id }}"
                                            {{ old('sub_category_id', $product->sub_category_id) == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label fw-semibold">Child Category</label>
                                <select name="child_category_id" id="childCategorySelect" class="form-select">
                                    <option value="">Select Child Category</option>
                                    @foreach($childCategories as $child)
                                        <option value="{{ $child->id }}"
                                            {{ old('child_category_id', $product->child_category_id) == $child->id ? 'selected' : '' }}>
                                            {{ $child->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Optional Toggles --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <p class="section-label mb-0"><i class="mdi mdi-tune me-1"></i>Product Options</p>
                    </div>
                    <div class="card-body">

                        <div class="toggle-group">
                            <div class="form-check">
                                <input class="form-check-input toggle-cb" type="checkbox" name="allow_measurement"
                                       id="allowMeasurement" data-target="#measurementSection"
                                       {{ old('allow_measurement', $product->allow_measurement) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="allowMeasurement">Allow Measurement</label>
                            </div>
                            <div id="measurementSection" class="toggle-section mt-2 ps-3">
                                <select name="product_measurement" class="form-select w-auto">
                                    @foreach(['None','cm','inch','mm','meter','foot'] as $opt)
                                        <option value="{{ $opt }}" {{ old('product_measurement', $product->product_measurement) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="toggle-group">
                            <div class="form-check">
                                <input class="form-check-input toggle-cb" type="checkbox" name="allow_condition"
                                       id="allowCondition" data-target="#conditionSection"
                                       {{ old('allow_condition', $product->allow_condition) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="allowCondition">Allow Condition</label>
                            </div>
                            <div id="conditionSection" class="toggle-section mt-2 ps-3">
                                <select name="product_condition" class="form-select w-auto">
                                    @foreach(['New','Used','Refurbished'] as $opt)
                                        <option value="{{ $opt }}" {{ old('product_condition', $product->product_condition) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="toggle-group">
                            <div class="form-check">
                                <input class="form-check-input toggle-cb" type="checkbox" name="allow_shipping_time"
                                       id="allowShipping" data-target="#shippingSection"
                                       {{ old('allow_shipping_time', $product->allow_shipping_time) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="allowShipping">Allow Shipping Time</label>
                            </div>
                            <div id="shippingSection" class="toggle-section mt-2 ps-3">
                                <input type="text" name="estimated_shipping_time" class="form-control"
                                       placeholder="e.g. 3-5 Business Days"
                                       value="{{ old('estimated_shipping_time', $product->estimated_shipping_time) }}">
                            </div>
                        </div>

                        <div class="toggle-group">
                            <div class="form-check">
                                <input class="form-check-input toggle-cb" type="checkbox" name="allow_colors"
                                       id="allowColors" data-target="#colorsSection"
                                       {{ old('allow_colors', $product->allow_colors) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="allowColors">Allow Colors</label>
                            </div>
                            <div id="colorsSection" class="toggle-section mt-2 ps-3">
                                <div class="color-tags-wrap mb-2" id="colorTagsWrap">
                                    <span class="text-muted" id="colorPlaceholder" style="font-size:12px;">Color chips will appear here...</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" id="colorNameInput" class="form-control form-control-sm" placeholder="Color name">
                                    <input type="color" id="colorPicker" class="tag-color-swatch border" value="#e74c3c">
                                    <button type="button" class="btn btn-primary btn-sm px-3" id="addColorBtn"><i class="mdi mdi-plus"></i> Add</button>
                                </div>
                                <small class="text-muted">Press Enter to add</small>
                                <input type="hidden" name="product_colors" id="productColorsHidden"
                                       value="{{ old('product_colors', $product->product_colors) }}">
                            </div>
                        </div>

                        <div class="toggle-group">
                            <div class="form-check">
                                <input class="form-check-input toggle-cb" type="checkbox" name="allow_sizes"
                                       id="allowSizes" data-target="#sizesSection"
                                       {{ old('allow_sizes', $product->allow_sizes) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="allowSizes">Allow Sizes</label>
                            </div>
                            <div id="sizesSection" class="toggle-section mt-2 ps-3">
                                <div class="size-tags-wrap mb-2" id="sizeTagsWrap">
                                    <span class="text-muted" id="sizePlaceholder" style="font-size:12px;">Size chips will appear here...</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" id="sizeNameInput" class="form-control form-control-sm" placeholder="e.g. S, M, L, XL">
                                    <button type="button" class="btn btn-primary btn-sm px-3" id="addSizeBtn"><i class="mdi mdi-plus"></i> Add</button>
                                </div>
                                <small class="text-muted">Separate with commas</small>
                                <input type="hidden" name="product_sizes" id="productSizesHidden"
                                       value="{{ old('product_sizes', $product->product_sizes) }}">
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Description --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <p class="section-label mb-0"><i class="mdi mdi-text me-1"></i>Description & Policy</p>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Description <span class="text-danger">*</span></label>
                            <textarea name="product_description" id="productDescription"
                                      class="form-control @error('product_description') is-invalid @enderror"
                                      >{{ old('product_description', $product->product_description) }}</textarea>
                            @error('product_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="form-label fw-semibold">Buy / Return Policy <span class="text-danger">*</span></label>
                            <textarea name="buy_return_policy" id="buyReturnPolicy"
                                      class="form-control @error('buy_return_policy') is-invalid @enderror"
                                      >{{ old('buy_return_policy', $product->buy_return_policy) }}</textarea>
                            @error('buy_return_policy')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- SEO --}}
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center gap-2">
                        <div class="form-check mb-0">
                            <input class="form-check-input toggle-cb" type="checkbox" name="allow_seo"
                                   id="allowSeo" data-target="#seoSection"
                                   {{ old('allow_seo', $product->allow_seo) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="allowSeo">
                                <i class="mdi mdi-magnify me-1"></i>SEO Settings
                            </label>
                        </div>
                    </div>
                    <div id="seoSection" class="toggle-section">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Meta Tags</label>
                                <input type="text" name="meta_tags" class="form-control"
                                       value="{{ old('meta_tags', $product->meta_tags) }}"
                                       placeholder="e.g. electronics, gadgets">
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3"
                                          placeholder="Meta description...">{{ old('meta_description', $product->meta_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ══════════════ RIGHT COLUMN ══════════════ --}}
            <div class="col-lg-4">

                {{-- Feature Image --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <p class="section-label mb-0"><i class="mdi mdi-image-outline me-1"></i>Feature Image</p>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Image Source <span class="text-danger">*</span></label>
                            <select name="feature_image_source" id="imageSourceSelect" class="form-select">
                                <option value="file" {{ old('feature_image_source', $product->feature_image_source) === 'file' ? 'selected' : '' }}>Upload File</option>
                                <option value="url"  {{ old('feature_image_source', $product->feature_image_source) === 'url'  ? 'selected' : '' }}>External URL</option>
                            </select>
                        </div>

                        <div id="featureImageFileWrap">
                            <div class="feature-image-box" id="featureImageBox"
                                 onclick="document.getElementById('featureImageInput').click()">
                                @if($product->feature_image && $product->feature_image_source === 'file')
                                    <img id="featureImagePreview" src="{{ asset('storage/'.$product->feature_image) }}" alt="">
                                    <div class="upload-overlay d-none" id="uploadOverlay"><i class="mdi mdi-cloud-upload-outline"></i><span>Click to change</span></div>
                                @else
                                    <img id="featureImagePreview" src="" alt="" style="display:none;">
                                    <div class="upload-overlay" id="uploadOverlay"><i class="mdi mdi-cloud-upload-outline"></i><span>Click to upload image</span></div>
                                @endif
                            </div>
                            <input type="file" name="feature_image" id="featureImageInput" class="d-none" accept="image/*">
                        </div>

                        <div id="featureImageUrlWrap" {{ old('feature_image_source', $product->feature_image_source) !== 'url' ? 'style=display:none' : '' }}>
                            <input type="url" name="feature_image_url" class="form-control"
                                   placeholder="https://example.com/image.jpg"
                                   value="{{ old('feature_image_url', $product->feature_image_source === 'url' ? $product->feature_image : '') }}">
                        </div>
                    </div>
                </div>

                {{-- Gallery --}}
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <p class="section-label mb-0"><i class="mdi mdi-view-grid-outline me-1"></i>Gallery Images</p>
                        <button type="button" class="btn btn-primary btn-sm"
                                onclick="document.getElementById('galleryInput').click()">
                            <i class="mdi mdi-plus me-1"></i> Add More
                        </button>
                    </div>
                    <div class="card-body">
                        <input type="file" name="gallery_images[]" id="galleryInput" class="d-none" accept="image/*" multiple>

                        {{-- Existing gallery --}}
                        <div class="gallery-wrap" id="existingGallery">
                            @if($product->gallery_images)
                                @foreach($product->gallery_images as $idx => $imgPath)
                                    <div class="gallery-item" id="egp-{{ $idx }}">
                                        <img src="{{ asset('storage/'.$imgPath) }}" alt="">
                                        <button type="button" class="rm rm-existing" data-idx="{{ $idx }}">&times;</button>
                                        <input type="hidden" name="remove_gallery_index[]" id="rmi-{{ $idx }}"
                                               value="{{ $idx }}" disabled>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        {{-- New gallery --}}
                        <div class="gallery-wrap mt-2" id="newGalleryPreview"></div>
                    </div>
                </div>

                {{-- Pricing --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <p class="section-label mb-0"><i class="mdi mdi-currency-usd me-1"></i>Pricing</p>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Price <span class="text-danger">*</span> <small class="text-muted fw-normal">(USD)</small></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="current_price" step="0.01"
                                       class="form-control @error('current_price') is-invalid @enderror"
                                       value="{{ old('current_price', $product->current_price) }}">
                                @error('current_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Discount Price <small class="text-muted fw-normal">(Optional)</small></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="discount_price" step="0.01"
                                       class="form-control @error('discount_price') is-invalid @enderror"
                                       value="{{ old('discount_price', $product->discount_price) }}">
                                @error('discount_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div>
                            <label class="form-label fw-semibold">YouTube URL <small class="text-muted fw-normal">(Optional)</small></label>
                            <input type="url" name="youtube_video_url"
                                   class="form-control @error('youtube_video_url') is-invalid @enderror"
                                   value="{{ old('youtube_video_url', $product->youtube_video_url) }}"
                                   placeholder="https://youtube.com/watch?v=...">
                            @error('youtube_video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Feature Tags --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <p class="section-label mb-0"><i class="mdi mdi-label-multiple-outline me-1"></i>Feature Tags</p>
                    </div>
                    <div class="card-body">
                        <div id="featureTagsWrapper">
                            @php
                                $existingTags = old('tag_keyword')
                                    ? array_map(fn($k,$c)=>['keyword'=>$k,'color'=>$c], old('tag_keyword'), old('tag_color',[]))
                                    : ($product->feature_tags ?? [['keyword'=>'','color'=>'#2d3e6e']]);
                            @endphp
                            @foreach($existingTags as $i => $tag)
                            <div class="feature-tag-row d-flex align-items-center gap-1 mb-2">
                                <input type="text" name="tag_keyword[]" class="form-control form-control-sm"
                                       placeholder="Keyword" value="{{ $tag['keyword'] ?? '' }}">
                                <input type="color" name="tag_color[]" class="tag-color-swatch border"
                                       value="{{ $tag['color'] ?? '#2d3e6e' }}">
                                <button type="button" class="btn btn-danger btn-sm rm-tag-row {{ $i===0?'d-none':'' }}">
                                    <i class="mdi mdi-minus"></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm w-100 mt-1" id="addTagRow">
                            <i class="mdi mdi-plus me-1"></i> Add More
                        </button>
                    </div>
                </div>

                {{-- Tags --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <p class="section-label mb-0"><i class="mdi mdi-tag-outline me-1"></i>Tags</p>
                    </div>
                    <div class="card-body">
                        <input type="text" name="tags" class="form-control"
                               value="{{ old('tags', $product->tags) }}"
                               placeholder="e.g. electronics, gadgets">
                        <small class="text-muted">Separate with commas</small>
                    </div>
                </div>

            </div>

        </div>

        {{-- Submit --}}
        <div class="submit-bar">
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('affiliateproduct.index') }}" class="btn btn-secondary px-4">
                    <i class="mdi mdi-close me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary px-5" style="background-color:#2d3e6e;border-color:#2d3e6e;">
                    <i class="mdi mdi-check me-1"></i> Update Product
                </button>
            </div>
        </div>

    </form>
</div>

{{-- JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(function () {

    // ── Summernote ────────────────────────────────────────────────────
    var snOpts = {
        height: 220,
        toolbar: [
            ['style',   ['bold','italic','underline','strikethrough','clear']],
            ['para',    ['ul','ol','paragraph']],
            ['table',   ['table']],
            ['insert',  ['link','picture','hr']],
            ['fontsize',['fontsize']],
            ['color',   ['color']],
            ['view',    ['fullscreen','codeview']],
        ],
    };
    $('#productDescription').summernote(snOpts);
    $('#buyReturnPolicy').summernote(snOpts);

    // ── Toggle Sections ───────────────────────────────────────────────
    $('.toggle-cb').each(function () {
        if ($(this).is(':checked')) $($(this).data('target')).show();
    });
    $(document).on('change', '.toggle-cb', function () {
        $(this).is(':checked') ? $($(this).data('target')).slideDown(200) : $($(this).data('target')).slideUp(200);
    });

    // ── Image Source Toggle ───────────────────────────────────────────
    $('#imageSourceSelect').on('change', function () {
        if ($(this).val() === 'url') {
            $('#featureImageFileWrap').hide();
            $('#featureImageUrlWrap').show();
        } else {
            $('#featureImageFileWrap').show();
            $('#featureImageUrlWrap').hide();
        }
    });

    // ── Feature Image Preview ─────────────────────────────────────────
    $('#featureImageInput').on('change', function () {
        var f = this.files[0]; if (!f) return;
        var r = new FileReader();
        r.onload = function (e) {
            $('#featureImagePreview').attr('src', e.target.result).show();
            $('#uploadOverlay').hide();
        };
        r.readAsDataURL(f);
    });

    // ── New Gallery ───────────────────────────────────────────────────
    var newFiles = [];
    $('#galleryInput').on('change', function () {
        Array.from(this.files).forEach(function (f) {
            newFiles.push(f);
            var idx = newFiles.length - 1;
            var r = new FileReader();
            r.onload = function (e) {
                $('#newGalleryPreview').append(
                    '<div class="gallery-item" id="ngp-' + idx + '">' +
                        '<img src="' + e.target.result + '">' +
                        '<button type="button" class="rm rm-new" data-idx="' + idx + '">&times;</button>' +
                    '</div>'
                );
            };
            r.readAsDataURL(f);
        });
        rebuildGallery();
    });
    $(document).on('click', '.rm-new', function () {
        newFiles[$(this).data('idx')] = null;
        $('#ngp-' + $(this).data('idx')).remove();
        rebuildGallery();
    });
    function rebuildGallery() {
        var dt = new DataTransfer();
        newFiles.filter(Boolean).forEach(function (f) { dt.items.add(f); });
        document.getElementById('galleryInput').files = dt.files;
    }

    // ── Existing Gallery Remove ───────────────────────────────────────
    $(document).on('click', '.rm-existing', function () {
        var idx = $(this).data('idx');
        $('#rmi-' + idx).prop('disabled', false);
        $('#egp-' + idx).addClass('marked');
    });

    // ── Category AJAX ─────────────────────────────────────────────────
    $('#categorySelect').on('change', function () {
        var catId = $(this).val();
        $('#subCategorySelect').html('<option value="">Select Sub Category</option>');
        $('#childCategorySelect').html('<option value="">Select Child Category</option>');
        if (!catId) return;
        $.get('/admin/affiliateproduct/get-sub-categories', { category_id: catId }, function (data) {
            $.each(data, function (i, s) {
                $('#subCategorySelect').append('<option value="' + s.id + '">' + s.name + '</option>');
            });
        }).fail(function () { toastr.error('Failed to load sub-categories!'); });
    });

    $('#subCategorySelect').on('change', function () {
        var subId = $(this).val();
        $('#childCategorySelect').html('<option value="">Select Child Category</option>');
        if (!subId) return;
        $.get('/admin/affiliateproduct/get-child-categories', { sub_category_id: subId }, function (data) {
            $.each(data, function (i, c) {
                $('#childCategorySelect').append('<option value="' + c.id + '">' + c.name + '</option>');
            });
        }).fail(function () { toastr.error('Failed to load child categories!'); });
    });

    // ── Color Chips ───────────────────────────────────────────────────
    var colorChips = [];
    function renderColors() {
        $('#colorTagsWrap .color-chip').remove();
        $('#colorPlaceholder').toggle(colorChips.length === 0);
        colorChips.forEach(function (c, i) {
            var r=parseInt(c.hex.slice(1,3),16),g=parseInt(c.hex.slice(3,5),16),b=parseInt(c.hex.slice(5,7),16);
            var tc=(0.299*r+0.587*g+0.114*b)>150?'#333':'#fff';
            $('#colorTagsWrap').append(
                '<span class="color-chip" style="background:'+c.hex+';color:'+tc+';">' +
                    '<span class="dot" style="background:'+c.hex+';border:2px solid rgba(0,0,0,.2);"></span>' +
                    c.name +
                    '<button type="button" class="rm-chip rm-color" data-idx="'+i+'">&times;</button>' +
                '</span>'
            );
        });
        $('#productColorsHidden').val(colorChips.map(function(c){return c.name+':'+c.hex;}).join(','));
    }
    function addColor() {
        var name=$('#colorNameInput').val().trim(), hex=$('#colorPicker').val();
        if(!name){toastr.warning('Enter a color name!');return;}
        if(colorChips.some(function(c){return c.name.toLowerCase()===name.toLowerCase();})){toastr.warning('Already added!');return;}
        colorChips.push({name:name,hex:hex}); renderColors(); $('#colorNameInput').val('').focus();
    }
    $('#addColorBtn').on('click',addColor);
    $('#colorNameInput').on('keydown',function(e){if(e.key==='Enter'){e.preventDefault();addColor();}});
    $(document).on('click','.rm-color',function(){colorChips.splice(+$(this).data('idx'),1);renderColors();});
    (function(){
        var existing=$('#productColorsHidden').val(); if(!existing)return;
        existing.split(',').forEach(function(p){var x=p.trim().split(':');if(x.length>=2)colorChips.push({name:x[0],hex:x[1]});});
        renderColors();
    })();

    // ── Size Chips ────────────────────────────────────────────────────
    var sizeChips = [];
    function renderSizes() {
        $('#sizeTagsWrap .size-chip').remove();
        $('#sizePlaceholder').toggle(sizeChips.length===0);
        sizeChips.forEach(function(s,i){
            $('#sizeTagsWrap').append('<span class="size-chip">'+s+'<button type="button" class="rm-chip rm-size" data-idx="'+i+'">&times;</button></span>');
        });
        $('#productSizesHidden').val(sizeChips.join(','));
    }
    function addSize(){
        var raw=$('#sizeNameInput').val().trim(); if(!raw){toastr.warning('Enter a size!');return;}
        raw.split(',').map(function(s){return s.trim();}).filter(Boolean).forEach(function(s){
            if(!sizeChips.some(function(x){return x.toLowerCase()===s.toLowerCase();}))sizeChips.push(s);
        });
        renderSizes(); $('#sizeNameInput').val('').focus();
    }
    $('#addSizeBtn').on('click',addSize);
    $('#sizeNameInput').on('keydown',function(e){if(e.key==='Enter'){e.preventDefault();addSize();}});
    $(document).on('click','.rm-size',function(){sizeChips.splice(+$(this).data('idx'),1);renderSizes();});
    (function(){
        var existing=$('#productSizesHidden').val(); if(!existing)return;
        existing.split(',').forEach(function(s){var t=s.trim();if(t)sizeChips.push(t);});
        renderSizes();
    })();

    // ── Feature Tag Rows ──────────────────────────────────────────────
    $('#addTagRow').on('click',function(){
        $('#featureTagsWrapper').append(
            '<div class="feature-tag-row d-flex align-items-center gap-1 mb-2">' +
                '<input type="text" name="tag_keyword[]" class="form-control form-control-sm" placeholder="Keyword">' +
                '<input type="color" name="tag_color[]" class="tag-color-swatch border" value="#2d3e6e">' +
                '<button type="button" class="btn btn-danger btn-sm rm-tag-row"><i class="mdi mdi-minus"></i></button>' +
            '</div>'
        );
    });
    $(document).on('click','.rm-tag-row',function(){$(this).closest('.feature-tag-row').remove();});

});
</script>

@endsection
