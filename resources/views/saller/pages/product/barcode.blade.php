@extends('saller.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    <div class="container-fluid px-lg-5">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Generate Barcode</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb small mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('saller.products.index') }}" class="text-decoration-none">Products</a></li>
                        <li class="breadcrumb-item active">Barcode</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('saller.products.index') }}" class="btn btn-sm btn-light border px-3 rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="row g-4">
            {{-- Left: Product Info Card --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex gap-3 align-items-center">
                            <img src="{{ asset('uploads/products/'.$product->feature_image) }}" class="rounded-3 shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $product->name }}</h5>
                                <p class="text-muted small mb-2">{{ Str::limit(strip_tags($product->short_description), 80) }}</p>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold text-danger">৳{{ number_format($product->current_price, 0) }}</span>
                                    @if($product->discount_price)
                                        <span class="badge bg-danger rounded-pill" style="font-size: 10px;">-৳{{ number_format($product->discount_price - $product->current_price, 0) }}</span>
                                    @endif
                                </div>
                                <div class="text-muted small mt-1">Code: {{ $product->sku }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Generation Options --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="input-group" style="width: 120px;">
                                <input type="number" id="barcode_count" class="form-control" value="4" min="1" max="24">
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-danger rounded-3" onclick="window.location.reload()"><i class="bi bi-arrow-repeat"></i></button>
                                <button class="btn btn-outline-success rounded-3" onclick="window.print()"><i class="bi bi-printer"></i></button>
                                <button class="btn btn-danger rounded-3 ms-4"><i class="bi bi-grid-fill"></i></button>
                            </div>
                        </div>

                        <div id="barcode_grid" class="row g-3">
                            {{-- Barcodes will be generated here --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .barcode-item {
        border: 1px dashed #dee2e6;
        padding: 20px;
        text-align: center;
        border-radius: 12px;
        background: white;
    }
    .barcode-img { width: 100%; height: auto; max-width: 200px; }
    @media print {
        .btn, .breadcrumb, h4, .card:not(#barcode_card) { display: none !important; }
        .page-content { background: white !important; }
        #barcode_grid { display: block !important; }
        .barcode-item { border: none; margin-bottom: 50px; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        generateBarcodes();
        document.getElementById('barcode_count').addEventListener('input', generateBarcodes);
    });

    function generateBarcodes() {
        const count = document.getElementById('barcode_count').value;
        const grid = document.getElementById('barcode_grid');
        grid.innerHTML = '';
        
        for(let i=0; i<count; i++) {
            grid.innerHTML += `
                <div class="col-md-6">
                    <div class="barcode-item shadow-sm">
                        <div class="fw-bold small text-dark mb-1">JHR Bazar</div>
                        <div class="text-muted" style="font-size: 10px;">{{ $product->name }}</div>
                        <div class="fw-bold text-danger my-2">৳{{ number_format($product->current_price, 0) }}</div>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $product->sku }}" class="barcode-img mb-2" style="max-height: 80px;">
                        <div class="text-muted" style="font-size: 9px;">Code: {{ $product->sku }}</div>
                    </div>
                </div>
            `;
        }
    }
</script>
@endsection
