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
            <h2 class="page-title font-w700" style="font-size: 24px; color: #333;">Flash Deals</h2>
        </div>

        <div class="row g-4 px-3">
            @forelse($deals as $deal)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                    <img src="{{ asset($deal->image) }}" class="card-img-top" alt="{{ $deal->title }}" style="height: 180px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title font-w600" style="font-size: 16px;">{{ $deal->title }}</h5>
                        <p class="card-text text-muted small mb-3">{{ Str::limit($deal->short_description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge {{ $deal->status ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3">
                                {{ $deal->status ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="text-primary font-w600" style="font-size: 13px;">View Products</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="data-card border-0 shadow-sm p-5 text-center" style="border-radius: 12px; background: #fff;">
                    <i class="bi bi-lightning-charge text-muted" style="font-size: 48px;"></i>
                    <p class="text-muted mt-2">No flash deals found.</p>
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
