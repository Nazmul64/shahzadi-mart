@extends('admin.master')

@section('main-content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<style>
    .page-title-box h4    { font-size: 1.1rem; font-weight: 600; margin-bottom: 2px; }
    .page-title-box small { color: #6c757d; font-size: .82rem; }

    .template-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        height: 100%;
        position: relative;
    }
    .template-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }
    .template-img-box {
        height: 220px;
        background: #f8f9fa;
        position: relative;
        overflow: hidden;
    }
    .template-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .template-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(26, 43, 107, 0.8);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
        gap: 10px;
    }
    .template-card:hover .template-overlay { opacity: 1; }

    .template-body { padding: 16px; }
    .template-title { font-size: 1rem; font-weight: 700; color: #1a2b6b; margin-bottom: 4px; }
    
    .btn-use-template {
        background: #fff;
        color: #1a2b6b;
        font-weight: 700;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-use-template:hover { background: #f1f3f9; transform: scale(1.05); }

    .badge-built-in { background: #e3f2fd; color: #1976d2; font-size: 0.7rem; }
    .badge-custom { background: #fff3e0; color: #e65100; font-size: 0.7rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="page-title-box">
        <h4>Theme Library</h4>
        <small>Landing Pages &rsaquo; Templates &rsaquo; Manage & Select</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.landing-pages.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Back to List</a>
        <a href="{{ route('admin.landing-pages.create') }}" class="btn btn-primary rounded-pill px-4" style="background: #1a2b6b; border: none;">+ Create New Theme</a>
    </div>
</div>

<div class="row g-4">
    @forelse($templates as $item)
    <div class="col-md-4 col-lg-3">
        <div class="template-card">
            <div class="template-img-box">
                @if($item->preview_image)
                    <img src="{{ asset('uploads/landing/'.$item->preview_image) }}" alt="">
                @else
                    <div class="h-100 d-flex flex-column align-items-center justify-content-center text-muted bg-light">
                        <i class="bi bi-layout-text-window-reverse mb-2" style="font-size: 3rem;"></i>
                        <span>No Preview</span>
                    </div>
                @endif
                
                <div class="template-overlay">
                    <a href="{{ route('admin.landing-pages.create', ['template_id' => $item->id]) }}" class="btn-use-template">
                        <i class="bi bi-magic me-1"></i> Use this Theme
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.landing-pages.builder', $item->id) }}" class="btn btn-sm btn-light rounded-pill px-3">
                            <i class="bi bi-pencil-square"></i> Edit Blocks
                        </a>
                        <a href="{{ route('admin.landing-pages.edit', $item->id) }}" class="btn btn-sm btn-light rounded-pill px-3">
                            <i class="bi bi-gear"></i> Settings
                        </a>
                    </div>
                </div>
            </div>
            <div class="template-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h5 class="template-title text-truncate mb-0">{{ $item->title }}</h5>
                    <span class="badge badge-custom border">Custom Theme</span>
                </div>
                <small class="text-muted"><i class="bi bi-layers"></i> {{ $item->blocks->count() }} Content Blocks</small>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="text-muted">
            <i class="bi bi-grid-3x3-gap" style="font-size: 4rem;"></i>
            <h5 class="mt-3">Your Theme Library is Empty</h5>
            <p>Create a landing page and mark it as a "Template" to see it here.</p>
            <a href="{{ route('admin.landing-pages.create') }}" class="btn btn-primary px-4" style="background: #1a2b6b; border: none;">Create My First Theme</a>
        </div>
    </div>
    @endforelse

    <!-- Built-in placeholders for inspiration -->
    @if($templates->count() < 4)
    <div class="col-12 mt-5">
        <h6 class="text-muted border-bottom pb-2">Reference Layouts (Built-in)</h6>
    </div>
    <div class="col-md-4 col-lg-3 opacity-75">
        <div class="template-card grayscale">
            <div class="template-img-box">
                <img src="https://via.placeholder.com/400x300?text=Modern+Dark+Layout" alt="">
                <div class="template-overlay">
                     <span class="text-white fw-bold">Blade: landing-1</span>
                </div>
            </div>
            <div class="template-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="template-title mb-0">Modern Dark</h5>
                    <span class="badge badge-built-in border">Built-in</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3 opacity-75">
        <div class="template-card grayscale">
            <div class="template-img-box">
                <img src="https://via.placeholder.com/400x300?text=Clean+Light+Layout" alt="">
                <div class="template-overlay">
                    <span class="text-white fw-bold">Blade: landing-2</span>
                </div>
            </div>
            <div class="template-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="template-title mb-0">Clean Light</h5>
                    <span class="badge badge-built-in border">Built-in</span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection
