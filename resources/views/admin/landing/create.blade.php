@extends('admin.master')

@section('main-content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<style>
    .page-title-box h4    { font-size: 1.1rem; font-weight: 600; margin-bottom: 2px; }
    .page-title-box small { color: #6c757d; font-size: .82rem; }

    .form-card {
        border: none;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 24px;
    }
    .form-label { font-weight: 600; color: #1a2b6b; font-size: 0.9rem; margin-bottom: 6px; }
    .form-control:focus, .form-select:focus {
        border-color: #1a2b6b;
        box-shadow: 0 0 0 0.25rem rgba(26, 43, 107, 0.1);
    }

    .template-selector {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
        margin-top: 10px;
    }
    .template-item {
        border: 2px solid #f1f3f9;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }
    .template-item:hover { border-color: #3b82f6; transform: scale(1.02); }
    .template-item.selected {
        border-color: #1a2b6b;
        box-shadow: 0 0 0 3px rgba(26, 43, 107, 0.1);
    }
    .template-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        opacity: 0.8;
    }
    .template-item.selected img { opacity: 1; }
    .template-name {
        padding: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-align: center;
        background: #f8f9fa;
        color: #333;
    }
    .template-item.selected .template-name { background: #1a2b6b; color: #fff; }
    .template-check {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #1a2b6b;
        color: #fff;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
    }
    .template-item.selected .template-check { display: flex; }

    .img-preview {
        width: 100%;
        max-height: 200px;
        object-fit: contain;
        border-radius: 8px;
        margin-top: 10px;
        border: 1px solid #dee2e6;
        display: none;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="page-title-box">
        <h4>Create Landing Page</h4>
        <small>Dashboard &rsaquo; Landing Pages &rsaquo; New</small>
    </div>
    <a href="{{ route('admin.landing-pages.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Back to List</a>
</div>
<!-- Antigravity Update: Removed required from title and product -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('admin.landing-pages.store') }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card mb-4">
                <h5 class="mb-4 border-bottom pb-2">Basic Information</h5>
                
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">SUPER Page Title Test</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter landing page title">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">URL Slug (Optional)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">/l/</span>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="unique-page-slug">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Select Primary Product</label>
                        <select name="product_id" class="form-select">
                            <option value="">-- Choose Main Product --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Additional Products / Combo Options (Optional)</label>
                        <select name="product_ids[]" class="form-select select2" multiple>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">These will appear as options in the order form.</small>
                    </div>
                </div>
            </div>

            <div class="form-card mb-4">
                <h5 class="mb-4 border-bottom pb-2">Choose Visual Style (Blade Template) <span class="text-danger">*</span></h5>
                <input type="hidden" name="template_name" id="template_name" value="{{ $source_template ? $source_template->template_name : 'landing-3' }}">
                <input type="hidden" name="source_template_id" value="{{ $source_template ? $source_template->id : '' }}">
                
                <div class="template-selector">
                    @php
                        $built_in = [
                            ['id' => 'landing-1', 'name' => 'Template 1 (Modern Dark)', 'image' => 'https://via.placeholder.com/300x150?text=Template+1'],
                            ['id' => 'landing-2', 'name' => 'Template 2 (Clean Light)', 'image' => 'https://via.placeholder.com/300x150?text=Template+2'],
                            ['id' => 'landing-3', 'name' => 'Template 3 (Dynamic Builder)', 'image' => 'https://via.placeholder.com/300x150?text=Template+3'],
                            ['id' => 'rihanu', 'name' => 'Rihanu (Premium Landing)', 'image' => 'https://rihanu.com/wp-content/uploads/2024/09/oil-bg.jpg'],
                        ];
                        $selected_template = $source_template ? $source_template->template_name : 'landing-3';
                    @endphp
                    @foreach($built_in as $t)
                    <div class="template-item {{ $selected_template == $t['id'] ? 'selected' : '' }}" onclick="selectTemplate('{{ $t['id'] }}', this)">
                        <img src="{{ $t['image'] }}" alt="{{ $t['name'] }}">
                        <div class="template-name">{{ $t['name'] }}</div>
                        <div class="template-check"><i class="bi bi-check"></i></div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3 text-muted" style="font-size: 0.85rem;">
                    <i class="bi bi-info-circle"></i> This controls the base layout. You will add content blocks in the next step.
                </div>
            </div>

            @if($source_template)
            <div class="alert alert-success d-flex align-items-center mb-4">
                <i class="bi bi-magic me-2 fs-4"></i>
                <div>
                    <strong>Selected Theme: {{ $source_template->title }}</strong><br>
                    All blocks and styles from this theme will be copied to your new page automatically!
                </div>
            </div>
            @elseif($templates->count() > 0)
            <div class="form-card mb-4">
                <h5 class="mb-4 border-bottom pb-2">Or Start from a Ready-made Theme</h5>
                <div class="row g-3">
                    @foreach($templates as $t)
                    <div class="col-md-6">
                        <a href="{{ route('admin.landing-pages.create', ['template_id' => $t->id]) }}" class="text-decoration-none">
                            <div class="template-item border {{ request('template_id') == $t->id ? 'border-primary shadow' : '' }}">
                                @if($t->preview_image)
                                    <img src="{{ asset('uploads/landing/'.$t->preview_image) }}" alt="{{ $t->title }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 120px;">
                                        <i class="bi bi-columns-gap fs-1 text-muted"></i>
                                    </div>
                                @endif
                                <div class="template-name text-dark">{{ $t->title }}</div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Tracking & Analytics removed - now managed globally via General Settings --}}
        </div>

        <div class="col-lg-4">
            <div class="form-card mb-4">
                <h5 class="mb-4 border-bottom pb-2">Global Media <i class="bi bi-info-circle text-muted" title="These are fixed elements. You can add more media inside the Page Builder."></i></h5>
                
                <div class="mb-3">
                    <label class="form-label">Main Feature Image (Optional)</label>
                    <input type="file" name="feature_image" class="form-control" onchange="previewImg(this, 'preview_feature')">
                    <img id="preview_feature" class="img-preview">
                    <small class="text-muted">Shows at the top of the page.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Main Video URL (Optional)</label>
                    <input type="text" name="video_url" class="form-control" placeholder="https://youtube.com/...">
                </div>

                <div class="mb-3">
                    <label class="form-label">Checkout Review Image (Optional)</label>
                    <input type="file" name="review_image" class="form-control" onchange="previewImg(this, 'preview_review')">
                    <img id="preview_review" class="img-preview">
                    <small class="text-muted">This single review image will stay fixed right above the Order Form.</small>
                </div>
            </div>

            <div class="form-card mb-4">
                <h5 class="mb-4 border-bottom pb-2">Theme Colors <i class="bi bi-palette text-muted"></i></h5>
                <div class="alert alert-info py-2" style="font-size: 0.8rem;">
                    These colors will automatically apply to all blocks you add in the Page Builder later!
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Background Color</label>
                        <input type="color" name="bg_color" class="form-control form-control-color w-100" value="#ffffff">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Primary/Button Color</label>
                        <input type="color" name="btn_color" class="form-control form-control-color w-100" value="#1a2b6b">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-card mb-4 border-primary border-2">
                <h5 class="mb-3 text-primary"><i class="bi bi-star-fill me-1"></i> Theme Library</h5>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_template" id="is_template">
                    <label class="form-check-label fw-bold" for="is_template">Mark as a Template</label>
                </div>
                <div id="template_preview_section" style="display: none;">
                    <label class="form-label">Template Preview Image</label>
                    <input type="file" name="preview_image" class="form-control" onchange="previewImg(this, 'preview_template')">
                    <img id="preview_template" class="img-preview">
                    <small class="text-muted d-block mt-1">This image will show up in the "Ready-made Themes" gallery.</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow" style="background: #1a2b6b; border: none; font-size: 1.1rem;">
                <i class="bi bi-arrow-right-circle me-2"></i> Save & Go to Builder
            </button>
        </div>
    </div>
</form>

<script>
    function selectTemplate(id, el) {
        document.querySelectorAll('.template-item').forEach(i => i.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('template_name').value = id;
    }

    function previewImg(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.getElementById(previewId);
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto-slug
    document.getElementById('title').addEventListener('input', function() {
        let slug = this.value.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
        document.getElementById('slug').value = slug;
    });
    document.getElementById('is_template').addEventListener('change', function() {
        document.getElementById('template_preview_section').style.display = this.checked ? 'block' : 'none';
    });
</script>

@endsection
