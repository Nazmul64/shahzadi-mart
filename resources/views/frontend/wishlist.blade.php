{{-- resources/views/frontend/wishlist.blade.php --}}
@extends('frontend.master')

@section('main-content')
<style>
    :root {
        --primary: #e8192c;
        --primary-light: #fff0f1;
        --dark: #1a1a2e;
        --text: #374151;
        --muted: #9ca3af;
        --border: #e5e7eb;
        --card-bg: #ffffff;
        --bg: #f8f9fb;
    }

    .wishlist-section {
        background: var(--bg);
        min-height: 80vh;
        padding: 40px 0 60px;
        font-family: 'Hind Siliguri', 'Segoe UI', sans-serif;
    }

    /* ── Breadcrumb ── */
    .breadcrumb-bar {
        background: #fff;
        border-bottom: 1px solid var(--border);
        padding: 12px 0;
        margin-bottom: 30px;
    }
    .breadcrumb-bar .bc-inner {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--muted);
    }
    .breadcrumb-bar a { color: var(--muted); text-decoration: none; }
    .breadcrumb-bar a:hover { color: var(--primary); }
    .breadcrumb-bar .sep { color: #d1d5db; }
    .breadcrumb-bar .current { color: var(--text); font-weight: 600; }

    /* ── Page Header ── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }
    .page-header h1 i { color: var(--primary); font-size: 20px; }
    .wish-count-badge {
        background: var(--primary);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
    }
    .btn-clear-all {
        background: #fff;
        border: 1.5px solid var(--border);
        color: var(--muted);
        font-size: 13px;
        padding: 8px 18px;
        border-radius: 8px;
        cursor: pointer;
        transition: all .2s;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    .btn-clear-all:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    /* ── Grid ── */
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    /* ── Card ── */
    .wish-card {
        background: var(--card-bg);
        border-radius: 14px;
        border: 1.5px solid var(--border);
        overflow: hidden;
        transition: transform .25s, box-shadow .25s;
        position: relative;
    }
    .wish-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,.08);
    }

    /* remove btn */
    .wish-remove {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fff;
        border: 1.5px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .2s;
        z-index: 5;
        color: var(--muted);
        font-size: 14px;
        text-decoration: none;
    }
    .wish-remove:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }

    /* image area */
    .wish-img {
        position: relative;
        height: 200px;
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .wish-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .35s;
    }
    .wish-card:hover .wish-img img { transform: scale(1.05); }

    .badge-flash {
        position: absolute;
        top: 10px;
        left: 10px;
        background: var(--primary);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
        letter-spacing: .5px;
    }

    /* body */
    .wish-body {
        padding: 14px 16px 16px;
    }
    .wish-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 6px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-decoration: none;
        display: block;
    }
    .wish-name:hover { color: var(--primary); }

    .wish-cat {
        font-size: 11px;
        color: var(--muted);
        margin-bottom: 10px;
    }

    .wish-price-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }
    .wish-price {
        font-size: 17px;
        font-weight: 700;
        color: var(--primary);
    }
    .wish-old-price {
        font-size: 13px;
        color: var(--muted);
        text-decoration: line-through;
    }
    .wish-discount {
        font-size: 11px;
        background: #fff3f3;
        color: var(--primary);
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 700;
    }

    .btn-add-cart {
        width: 100%;
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s, transform .15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        text-decoration: none;
        font-family: 'Hind Siliguri', sans-serif;
    }
    .btn-add-cart:hover {
        background: #c8101f;
        transform: scale(1.02);
        color: #fff;
    }

    /* out of stock */
    .wish-card.out-of-stock .btn-add-cart {
        background: #e5e7eb;
        color: var(--muted);
        cursor: not-allowed;
    }
    .wish-card.out-of-stock .wish-img::after {
        content: 'স্টক নেই';
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,.4);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 700;
    }

    /* ── Empty State ── */
    .wish-empty {
        text-align: center;
        padding: 80px 20px;
        background: var(--card-bg);
        border-radius: 16px;
        border: 2px dashed var(--border);
    }
    .wish-empty .empty-icon {
        width: 100px;
        height: 100px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }
    .wish-empty .empty-icon i {
        font-size: 42px;
        color: var(--primary);
    }
    .wish-empty h3 {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }
    .wish-empty p {
        color: var(--muted);
        font-size: 14px;
        margin-bottom: 24px;
    }
    .btn-shop-now {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--primary);
        color: #fff;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: background .2s;
    }
    .btn-shop-now:hover { background: #c8101f; color: #fff; }

    @media(max-width:576px){
        .wishlist-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .wish-img { height: 150px; }
    }
</style>

{{-- Breadcrumb --}}
<div class="breadcrumb-bar">
    <div class="container">
        <div class="bc-inner">
            <a href="{{ route('frontend') }}"><i class="bi bi-house-fill"></i> হোম</a>
            <span class="sep">/</span>
            <span class="current">উইশলিস্ট</span>
        </div>
    </div>
</div>

<section class="wishlist-section">
    <div class="container">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert-msg alert-success"
                 style="border-radius:10px;padding:12px 18px;font-size:14px;font-weight:600;display:flex;align-items:center;gap:9px;margin-bottom:18px;background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-msg alert-error"
                 style="border-radius:10px;padding:12px 18px;font-size:14px;font-weight:600;display:flex;align-items:center;gap:9px;margin-bottom:18px;background:#fff0f1;color:#e8192c;border:1px solid #fecdd3;">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div class="alert-msg alert-info"
                 style="border-radius:10px;padding:12px 18px;font-size:14px;font-weight:600;display:flex;align-items:center;gap:9px;margin-bottom:18px;background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;">
                <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
            </div>
        @endif

        @if(isset($wishlistItems) && $wishlistItems->count() > 0)

            <div class="page-header">
                <h1>
                    <i class="bi bi-heart-fill"></i>
                    আমার উইশলিস্ট
                    <span class="wish-count-badge">{{ $wishlistItems->count() }}</span>
                </h1>
                <a href="{{ route('wishlist.clear') }}" class="btn-clear-all"
                   onclick="return confirm('সব আইটেম মুছে ফেলবেন?')">
                    <i class="bi bi-trash3"></i> সব মুছুন
                </a>
            </div>

            <div class="wishlist-grid">
                @foreach($wishlistItems as $item)
                @php
                    // product relationship থেকে সঠিক field নেওয়া হচ্ছে
                    $product = $item->product;

                    // product না থাকলে skip করো
                    if (!$product) continue;

                    $hasDiscount = $product->discount_price && $product->discount_price > 0;
                    $discountPct = $hasDiscount
                        ? round((($product->current_price - $product->discount_price) / $product->current_price) * 100)
                        : 0;
                    $inStock = $product->is_unlimited || ($product->stock ?? 0) > 0;

                    // feature_image ব্যবহার, uploads/products/ path
                    $imgSrc = $product->feature_image
                        ? asset('uploads/products/' . $product->feature_image)
                        : asset('images/placeholder.png');

                    // product->name (Product model এ 'name' field)
                    $productName = $product->name ?? ($product->product_name ?? 'Product');
                @endphp
                <div class="wish-card {{ !$inStock ? 'out-of-stock' : '' }}">

                    {{-- Remove --}}
                    <a href="{{ route('wishlist.remove', $item->id) }}"
                       class="wish-remove"
                       title="সরিয়ে দিন">
                        <i class="bi bi-x-lg"></i>
                    </a>

                    {{-- Image --}}
                    <a href="{{ route('product.detail', $product->slug) }}" class="wish-img">
                        <img src="{{ $imgSrc }}"
                             alt="{{ $productName }}"
                             onerror="this.src='{{ asset('images/placeholder.png') }}'">
                        @if($product->is_flash_sale)
                            <span class="badge-flash">⚡ Flash</span>
                        @endif
                    </a>

                    {{-- Body --}}
                    <div class="wish-body">
                        <a href="{{ route('product.detail', $product->slug) }}" class="wish-name">
                            {{ $productName }}
                        </a>
                        <p class="wish-cat">
                            <i class="bi bi-tag"></i>
                            {{ $product->category->category_name ?? 'Uncategorized' }}
                        </p>
                        <div class="wish-price-row">
                            <span class="wish-price">
                                ৳ {{ number_format($hasDiscount ? $product->discount_price : $product->current_price, 0) }}
                            </span>
                            @if($hasDiscount)
                                <span class="wish-old-price">৳ {{ number_format($product->current_price, 0) }}</span>
                                <span class="wish-discount">-{{ $discountPct }}%</span>
                            @endif
                        </div>

                        @if($inStock)
                            <a href="{{ route('cart.add', $product->id) }}"
                               class="btn-add-cart">
                                <i class="bi bi-cart-plus"></i> কার্টে যোগ করুন
                            </a>
                        @else
                            <button class="btn-add-cart" disabled>
                                <i class="bi bi-x-circle"></i> স্টক নেই
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

        @else
            {{-- Empty State --}}
            <div class="wish-empty">
                <div class="empty-icon">
                    <i class="bi bi-heart"></i>
                </div>
                <h3>উইশলিস্ট খালি আছে!</h3>
                <p>আপনার পছন্দের পণ্যগুলো উইশলিস্টে সেভ করুন।</p>
                <a href="{{ route('frontend') }}" class="btn-shop-now">
                    <i class="bi bi-shop"></i> শপিং শুরু করুন
                </a>
            </div>
        @endif

    </div>
</section>
@endsection
