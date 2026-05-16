@extends('saller.master')

@section('main-content')
<div class="main-content">
    <div class="top-navbar">
        <div class="d-flex align-items-center gap-3">
            <button class="menu-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div class="navbar-brand">
                <i class="bi bi-shop"></i>
                <span class="d-none d-sm-inline">SELLER <strong>PORTAL</strong></span>
            </div>
        </div>
    </div>

    <div class="page-content" style="background: #f4f7fa;">
        <div class="page-header mb-4 px-3 pt-3">
            <h2 class="page-title font-w700" style="font-size: 24px; color: #333;">Banner Setup</h2>
        </div>

        <div class="row g-4 px-3">
            @forelse($banners as $banner)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; position: relative;">
                    <img src="{{ asset($banner->photo) }}" class="card-img" alt="Banner" style="height: 250px; object-fit: cover;">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 p-3" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                            <span class="badge bg-primary rounded-pill mb-2">Global Banner</span>
                            <h6 class="text-white mb-0">Active on Homepage</h6>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="data-card border-0 shadow-sm p-5 text-center" style="border-radius: 12px; background: #fff;">
                    <i class="bi bi-image text-muted" style="font-size: 48px;"></i>
                    <p class="text-muted mt-2">No banners found.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .font-w600 { font-weight: 600; }
    .font-w700 { font-weight: 700; }
</style>
@endsection
