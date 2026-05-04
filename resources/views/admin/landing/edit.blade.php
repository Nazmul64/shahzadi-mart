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
    
    .template-selector {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }
    .template-item {
        border: 2px solid #f1f3f9;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }
    .template-item.selected {
        border-color: #1a2b6b;
        box-shadow: 0 0 0 3px rgba(26, 43, 107, 0.1);
    }
    .template-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }
    .template-name {
        padding: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-align: center;
        background: #f8f9fa;
    }
    .template-item.selected .template-name { background: #1a2b6b; color: #fff; }
    .template-check {
        position: absolute;
        top: 8px; right: 8px;
        background: #1a2b6b; color: #fff;
        width: 20px; height: 20px;
        border-radius: 50%;
        display: none; align-items: center; justify-content: center;
    }
    .template-item.selected .template-check { display: flex; }

    .img-preview {
        width: 100%;
        max-height: 200px;
        object-fit: contain;
        border-radius: 8px;
        margin-top: 10px;
        border: 1px solid #dee2e6;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="page-title-box">
        <h4>Edit Landing Page</h4>
        <small>Dashboard &rsaquo; Landing Pages &rsaquo; Edit &rsaquo; {{ $landing->title }}</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('landing.show', $landing->slug) }}" target="_blank" class="btn btn-outline-info btn-sm rounded-pill px-3">View Page</a>
        <a href="{{ route('admin.landing-pages.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Back to List</a>
    </div>
</div>

<form action="{{ route('admin.landing-pages.update', $landing->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card mb-4">
                <h5 class="mb-4 border-bottom pb-2">Basic Information</h5>
                
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Page Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $landing->title }}" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">URL Slug <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">/l/</span>
                            <input type="text" name="slug" id="slug" class="form-control" value="{{ $landing->slug }}" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Select Product <span class="text-danger">*</span></label>
                        <select name="product_id" class="form-select" required>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" {{ $landing->product_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-card mb-4">
                <h5 class="mb-4 border-bottom pb-2">Choose Visual Style (Blade Template) <span class="text-danger">*</span></h5>
                <input type="hidden" name="template_name" id="template_name" value="{{ $landing->template_name }}">
                
                <div class="template-selector">
                    @php
                        $built_in = [
                            ['id' => 'landing-1', 'name' => 'Template 1 (Modern Dark)', 'image' => 'https://via.placeholder.com/300x150?text=Template+1'],
                            ['id' => 'landing-2', 'name' => 'Template 2 (Clean Light)', 'image' => 'https://via.placeholder.com/300x150?text=Template+2'],
                            ['id' => 'landing-3', 'name' => 'Template 3 (Dynamic Builder)', 'image' => 'https://via.placeholder.com/300x150?text=Template+3'],
                            ['id' => 'rihanu', 'name' => 'Rihanu (Premium Landing)', 'image' => 'https://rihanu.com/wp-content/uploads/2024/09/oil-bg.jpg'],
                        ];
                    @endphp
                    @foreach($built_in as $t)
                    <div class="template-item {{ $landing->template_name == $t['id'] ? 'selected' : '' }}" onclick="selectTemplate('{{ $t['id'] }}', this)">
                        <img src="{{ $t['image'] }}" alt="{{ $t['name'] }}">
                        <div class="template-name">{{ $t['name'] }}</div>
                        <div class="template-check"><i class="bi bi-check"></i></div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="form-card">
                <h5 class="mb-4 border-bottom pb-2">Tracking & Analytics</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Google Tag Manager (GTM) ID</label>
                        <input type="text" name="gtm_id" class="form-control" value="{{ $landing->gtm_id }}" placeholder="GTM-XXXXXXX">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Facebook Pixel ID</label>
                        <input type="text" name="fb_pixel_id" class="form-control" value="{{ $landing->fb_pixel_id }}" placeholder="Pixel ID">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-card mb-4">
                <h5 class="mb-4 border-bottom pb-2">Media & Content</h5>
                
                <div class="mb-3">
                    <label class="form-label">Feature Image</label>
                    <input type="file" name="feature_image" class="form-control" onchange="previewImg(this, 'preview_feature')">
                    @if($landing->feature_image)
                        <img id="preview_feature" src="{{ asset('uploads/landing/'.$landing->feature_image) }}" class="img-preview" style="display:block;">
                    @else
                        <img id="preview_feature" class="img-preview">
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Video URL (YouTube/Vimeo)</label>
                    <input type="text" name="video_url" class="form-control" value="{{ $landing->video_url }}" placeholder="https://youtube.com/...">
                </div>

                <div class="mb-3">
                    <label class="form-label">Review Image</label>
                    <input type="file" name="review_image" class="form-control" onchange="previewImg(this, 'preview_review')">
                    @if($landing->review_image)
                        <img id="preview_review" src="{{ asset('uploads/landing/'.$landing->review_image) }}" class="img-preview" style="display:block;">
                    @else
                        <img id="preview_review" class="img-preview">
                    @endif
                </div>
            </div>

            <div class="form-card mb-4">
                <h5 class="mb-4 border-bottom pb-2">Customization</h5>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Background Color</label>
                        <input type="color" name="bg_color" class="form-control form-control-color w-100" value="{{ $landing->bg_color ?? '#ffffff' }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Button Color</label>
                        <input type="color" name="btn_color" class="form-control form-control-color w-100" value="{{ $landing->btn_color ?? '#1a2b6b' }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $landing->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$landing->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-card mb-4 border-primary border-2">
                <h5 class="mb-3 text-primary"><i class="bi bi-star-fill me-1"></i> Theme Library</h5>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_template" id="is_template" {{ $landing->is_template ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="is_template">Mark as a Template</label>
                </div>
                <div id="template_preview_section" style="{{ $landing->is_template ? 'display: block;' : 'display: none;' }}">
                    <label class="form-label">Template Preview Image</label>
                    <input type="file" name="preview_image" class="form-control" onchange="previewImg(this, 'preview_template')">
                    @if($landing->preview_image)
                        <img id="preview_template" src="{{ asset('uploads/landing/'.$landing->preview_image) }}" class="img-preview" style="display:block;">
                    @else
                        <img id="preview_template" class="img-preview">
                    @endif
                    <small class="text-muted d-block mt-1">This image will show up in the "Ready-made Themes" gallery.</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="background: #1a2b6b; border: none;">
                <i class="bi bi-check-circle me-2"></i> Update Landing Page
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

    document.getElementById('is_template').addEventListener('change', function() {
        document.getElementById('template_preview_section').style.display = this.checked ? 'block' : 'none';
    });
</script>

@endsection
