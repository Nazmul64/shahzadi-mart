@extends('admin.master')

@section('main-content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<style>
    .page-title-box h4    { font-size: 1.1rem; font-weight: 600; margin-bottom: 2px; }
    .page-title-box small { color: #6c757d; font-size: .82rem; }

    .landing-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        height: 100%;
    }
    .landing-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }
    .landing-img-box {
        height: 180px;
        background: #f8f9fa;
        position: relative;
        overflow: hidden;
    }
    .landing-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .landing-status {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .status-active { background: #e8f5e9; color: #2e7d32; }
    .status-inactive { background: #ffebee; color: #c62828; }

    .landing-body { padding: 16px; }
    .landing-title { font-size: 1rem; font-weight: 700; color: #1a2b6b; margin-bottom: 4px; }
    .landing-product { font-size: 0.85rem; color: #6c757d; margin-bottom: 12px; }
    .landing-slug {
        font-size: 0.8rem;
        background: #f1f3f9;
        padding: 4px 8px;
        border-radius: 4px;
        color: #1a2b6b;
        display: block;
        margin-bottom: 16px;
        text-decoration: none;
    }
    .landing-slug:hover { color: #3b82f6; }

    .btn-add-new {
        background-color: #1a2b6b; color: #fff !important; border: none;
        border-radius: 25px; padding: 8px 22px; font-size: .9rem; font-weight: 500;
        text-decoration: none; display: inline-flex;
        align-items: center; gap: 5px; cursor: pointer;
    }
    .btn-add-new:hover { background-color: #152259; }

    .btn-action {
        width: 32px; height: 32px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        border: none; font-size: 0.9rem; transition: all 0.2s;
    }
    .btn-edit { background: #e3f2fd; color: #1976d2; }
    .btn-edit:hover { background: #1976d2; color: #fff; }
    .btn-delete { background: #ffebee; color: #c62828; }
    .btn-delete:hover { background: #c62828; color: #fff; }
    .btn-view { background: #f3e5f5; color: #7b1fa2; }
    .btn-view:hover { background: #7b1fa2; color: #fff; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="page-title-box">
        <h4>Landing Pages</h4>
        <small>Dashboard &rsaquo; Marketing &rsaquo; Landing Pages</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.landing-pages.templates') }}" class="btn btn-outline-primary rounded-pill d-flex align-items-center gap-2">
            <i class="bi bi-grid-3x3-gap-fill"></i> Theme Library ({{ $templates_count }})
        </a>
        <a href="{{ route('admin.landing-pages.create') }}" class="btn-add-new">+ Create New Page</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    @forelse($landings as $item)
    <div class="col-md-4 col-lg-3">
        <div class="landing-card">
            <div class="landing-img-box">
                @if($item->feature_image)
                    <img src="{{ asset('uploads/landing/'.$item->feature_image) }}" alt="">
                @else
                    <div class="h-100 d-flex align-items-center justify-content-center text-muted bg-light">
                        <i class="bi bi-image" style="font-size: 2rem;"></i>
                    </div>
                @endif
                <span class="landing-status {{ $item->status ? 'status-active' : 'status-inactive' }}">
                    {{ $item->status ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="landing-body">
                <h5 class="landing-title text-truncate">{{ $item->title }}</h5>
                <div class="landing-product text-truncate">
                    <i class="bi bi-box-seam me-1"></i> {{ $item->product->name ?? 'No Product' }}
                </div>
                <a href="{{ route('landing.show', $item->slug) }}" target="_blank" class="landing-slug text-truncate">
                    <i class="bi bi-link-45deg"></i> /l/{{ $item->slug }}
                </a>
                
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-light text-dark border">{{ $item->template_name }}</span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('landing.show', $item->slug) }}" target="_blank" class="btn-action btn-view" title="Preview">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.landing-pages.builder', $item->id) }}" class="btn-action text-white bg-primary border-0" title="Builder" style="background: #1a2b6b !important;">
                            <i class="bi bi-columns-gap"></i>
                        </a>
                        <a href="{{ route('admin.landing-pages.edit', $item->id) }}" class="btn-action btn-edit" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="{{ route('admin.landing-pages.duplicate', $item->id) }}" class="btn-action bg-info text-white border-0" title="Duplicate" onclick="return confirm('Duplicate this landing page?')">
                            <i class="bi bi-files"></i>
                        </a>

                        <form action="{{ route('admin.landing-pages.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this landing page?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="text-muted">
            <i class="bi bi-window-stack" style="font-size: 4rem;"></i>
            <h5 class="mt-3">No Landing Pages Found</h5>
            <p>Create your first high-converting landing page now!</p>
            <a href="{{ route('admin.landing-pages.create') }}" class="btn btn-primary px-4">Get Started</a>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $landings->links() }}
</div>

@endsection
