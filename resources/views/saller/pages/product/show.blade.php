@extends('saller.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    <div class="container-fluid px-lg-5">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Product Details</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb small mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('saller.products.index') }}" class="text-decoration-none">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('saller.products.index') }}" class="btn btn-sm btn-light border px-3 rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
                <a href="{{ route('saller.products.edit', $product->id) }}" class="btn btn-sm btn-danger px-3 rounded-pill" style="background: #e91e63; border: none;">
                    <i class="bi bi-pencil-square me-1"></i> Edit Product
                </a>
            </div>
        </div>

        <div class="row g-4">
            {{-- Left Side: Image Slider --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 text-center">
                        <div class="main-image-container position-relative mb-3 bg-light rounded-4" style="height: 450px;">
                            <img id="main-image" src="{{ asset('uploads/products/'.$product->feature_image) }}" 
                                 class="img-fluid h-100 rounded-4" style="object-fit: contain; width: 100%;">
                            
                            <button class="slider-btn prev-btn position-absolute top-50 start-0 translate-middle-y btn btn-white rounded-circle shadow-sm ms-3" onclick="slidePrev()">
                                <i class="bi bi-chevron-left text-danger"></i>
                            </button>
                            <button class="slider-btn next-btn position-absolute top-50 end-0 translate-middle-y btn btn-white rounded-circle shadow-sm me-3" onclick="slideNext()">
                                <i class="bi bi-chevron-right text-danger"></i>
                            </button>
                        </div>

                        <div class="thumbnail-row d-flex gap-2 overflow-auto pb-2 justify-content-center">
                            <div class="thumb-item active" onclick="changeImage('{{ asset('uploads/products/'.$product->feature_image) }}', this)">
                                <img src="{{ asset('uploads/products/'.$product->feature_image) }}" class="rounded-3 border" style="width: 80px; height: 60px; object-fit: cover;">
                            </div>
                            @foreach($product->gallery_images ?? [] as $gallery)
                                @php $img = is_array($gallery) ? $gallery['image'] : $gallery; @endphp
                                <div class="thumb-item" onclick="changeImage('{{ asset('uploads/products/'.$img) }}', this)">
                                    <img src="{{ asset('uploads/products/'.$img) }}" class="rounded-3 border" style="width: 80px; height: 60px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Product Info --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1 mb-2" style="font-size: 11px;">Seller ID: #{{ auth()->id() }}</span>
                            <h2 class="fw-bold text-dark mb-1">{{ $product->name }}</h2>
                            <div class="d-flex align-items-center gap-3 text-muted small">
                                <span><i class="bi bi-grid me-1"></i> {{ $product->category->category_name ?? 'N/A' }}</span>
                                <span><i class="bi bi-upc-scan me-1"></i> SKU: {{ $product->sku }}</span>
                            </div>
                        </div>

                        <div class="pricing-card bg-light p-3 rounded-4 mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <h3 class="text-danger fw-bold mb-0">৳{{ number_format($product->current_price, 2) }}</h3>
                                @if($product->discount_price)
                                    <span class="text-muted text-decoration-line-through">৳{{ number_format($product->discount_price, 2) }}</span>
                                    @php 
                                        $discount = (($product->discount_price - $product->current_price) / $product->discount_price) * 100;
                                    @endphp
                                    <span class="badge bg-danger rounded-pill" style="font-size: 10px;">Save {{ round($discount) }}%</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-2">Quantity</label>
                            <h4 class="fw-bold">{{ $product->stock ?? 0 }} <small class="text-muted fw-normal" style="font-size: 14px;">Available in Stock</small></h4>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('product.detail', $product->slug) }}" target="_blank" class="btn btn-outline-danger py-2 rounded-pill fw-bold">
                                <i class="bi bi-eye me-1"></i> View Live
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom: Description --}}
            <div class="col-12 mt-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold">Description</h5>
                        <hr class="mt-3 mb-0 opacity-50">
                    </div>
                    <div class="card-body p-4">
                        <div class="product-description text-muted">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1.25rem !important; }
    .thumb-item { cursor: pointer; opacity: 0.6; transition: all 0.2s; }
    .thumb-item:hover, .thumb-item.active { opacity: 1; transform: translateY(-2px); }
    .thumb-item.active img { border: 2px solid #e91e63 !important; }
    .slider-btn { width: 40px; height: 40px; border: none; z-index: 5; }
    .slider-btn:hover { background: #f8f9fa; transform: scale(1.1); }
    .pricing-card { border: 1px solid #f1f1f1; }
</style>

<script>
    let currentImageIndex = 0;
    const images = [
        '{{ asset('uploads/products/'.$product->feature_image) }}',
        @foreach($product->gallery_images ?? [] as $gallery)
            '{{ asset('uploads/products/'.(is_array($gallery) ? $gallery['image'] : $gallery)) }}',
        @endforeach
    ];

    function changeImage(src, element) {
        $('#main-image').fadeOut(200, function() {
            $(this).attr('src', src).fadeIn(200);
        });
        $('.thumb-item').removeClass('active');
        $(element).addClass('active');
        currentImageIndex = images.indexOf(src);
    }

    function slideNext() {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        updateSlider();
    }

    function slidePrev() {
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        updateSlider();
    }

    function updateSlider() {
        const src = images[currentImageIndex];
        $('#main-image').fadeOut(200, function() {
            $(this).attr('src', src).fadeIn(200);
        });
        $('.thumb-item').removeClass('active').eq(currentImageIndex).addClass('active');
    }
</script>
@endsection
