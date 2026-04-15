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

    /* ── Hero / Breadcrumb ── */
    .wish-hero {
        background: #f3f5f7;
        padding: 36px 0 30px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 40px;
    }
    .wish-hero h1 {
        font-size: 26px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 10px;
    }
    .bc-inner {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--muted);
    }
    .bc-inner a { color: var(--muted); text-decoration: none; }
    .bc-inner a:hover { color: var(--primary); }
    .bc-inner .sep { color: #d1d5db; font-size: 12px; }
    .bc-inner .current { color: var(--text); }

    /* ── Wishlist Section ── */
    .wishlist-section {
        background: #fff;
        padding-bottom: 60px;
    }

    /* ── Alert Messages ── */
    .alert-msg {
        border-radius: 10px;
        padding: 12px 18px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 20px;
    }

    /* ── Table ── */
    .wish-table-wrap {
        overflow-x: auto;
        border: 1px solid var(--border);
        border-radius: 12px;
    }
    .wish-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 680px;
    }
    .wish-table thead tr {
        border-bottom: 1.5px solid var(--border);
        background: #fafafa;
    }
    .wish-table thead th {
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
        padding: 15px 20px;
        text-align: left;
        white-space: nowrap;
        letter-spacing: .02em;
    }
    .wish-table thead th.th-remove {
        text-align: right;
    }
    .wish-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }
    .wish-table tbody tr:last-child {
        border-bottom: none;
    }
    .wish-table tbody tr:hover {
        background: #fafafa;
    }
    .wish-table tbody td {
        padding: 20px 20px;
        vertical-align: middle;
    }

    /* ── Product Cell ── */
    .td-product {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .td-product-img {
        width: 76px;
        height: 76px;
        flex-shrink: 0;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--border);
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .td-product-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .td-product-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        text-decoration: none;
        line-height: 1.45;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        max-width: 300px;
    }
    .td-product-name:hover { color: var(--primary); }

    /* ── Price Cell ── */
    .td-price {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        white-space: nowrap;
    }

    /* ── Stock Badge ── */
    .badge-stock {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #16a34a;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 20px;
        white-space: nowrap;
    }
    .badge-stock.out {
        background: #e5e7eb;
        color: var(--muted);
    }
    .badge-stock svg {
        width: 11px;
        height: 11px;
        flex-shrink: 0;
    }

    /* ── Add To Cart Button ── */
    .btn-add-cart {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 11px 22px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, transform .15s;
        text-decoration: none;
        white-space: nowrap;
        font-family: inherit;
        letter-spacing: .01em;
    }
    .btn-add-cart:hover {
        background: #c8101f;
        color: #fff;
        transform: translateY(-1px);
    }
    .btn-add-cart.disabled,
    .btn-add-cart[disabled] {
        background: #e5e7eb;
        color: var(--muted);
        cursor: not-allowed;
        pointer-events: none;
        transform: none;
    }
    .btn-add-cart svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
    }

    /* ── Remove Button ── */
    .td-remove {
        text-align: right;
    }
    .btn-remove {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border: none;
        background: transparent;
        color: var(--muted);
        font-size: 20px;
        line-height: 1;
        cursor: pointer;
        text-decoration: none;
        border-radius: 50%;
        transition: color .2s, background .2s;
        font-weight: 300;
    }
    .btn-remove:hover {
        color: var(--primary);
        background: var(--primary-light);
    }

    /* ── Empty State ── */
    .wish-empty {
        text-align: center;
        padding: 80px 20px;
        border: 2px dashed var(--border);
        border-radius: 16px;
    }
    .wish-empty .empty-icon {
        width: 90px;
        height: 90px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 22px;
    }
    .wish-empty .empty-icon i { font-size: 38px; color: var(--primary); }
    .wish-empty h3 { font-size: 20px; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
    .wish-empty p  { color: var(--muted); font-size: 14px; margin-bottom: 24px; }
    .btn-shop-now {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--primary);
        color: #fff;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        transition: background .2s;
    }
    .btn-shop-now:hover { background: #c8101f; color: #fff; }

    @media (max-width: 576px) {
        .wish-hero h1 { font-size: 20px; }
        .td-product-img { width: 56px; height: 56px; }
        .btn-add-cart { padding: 9px 14px; font-size: 12px; }
        .wish-table tbody td { padding: 14px 12px; }
    }
</style>

{{-- ── Hero / Breadcrumb ── --}}
<div class="wish-hero">
    <div class="container">
        <h1>Wishlist</h1>
        <nav class="bc-inner">
            <a href="{{ route('frontend') }}">Home</a>
            <span class="sep">&#8250;</span>
            <span>Pages</span>
            <span class="sep">&#8250;</span>
            <span class="current">Wishlist</span>
        </nav>
    </div>
</div>

<section class="wishlist-section">
    <div class="container">

        {{-- ── Flash Messages ── --}}
        @if(session('success'))
            <div class="alert-msg" style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-msg" style="background:#fff0f1;color:#e8192c;border:1px solid #fecdd3;">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div class="alert-msg" style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;">
                <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
            </div>
        @endif

        @if(isset($wishlistItems) && $wishlistItems->count() > 0)

            <div class="wish-table-wrap">
                <table class="wish-table">
                    <thead>
                        <tr>
                            <th style="min-width:300px;">Product</th>
                            <th style="min-width:110px;">Price</th>
                            <th style="min-width:130px;">Stock Status</th>
                            <th style="min-width:180px;"></th>
                            <th class="th-remove" style="min-width:80px;">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishlistItems as $item)
                        @php
                            $product = $item->product;
                            if (!$product) continue;

                            $hasDiscount  = $product->discount_price && $product->discount_price > 0;
                            $inStock      = $product->is_unlimited || ($product->stock ?? 0) > 0;
                            $displayPrice = $hasDiscount ? $product->discount_price : $product->current_price;

                            $imgSrc = $product->feature_image
                                ? asset('uploads/products/' . $product->feature_image)
                                : asset('images/placeholder.png');

                            $productName = $product->name ?? ($product->product_name ?? 'Product');
                        @endphp
                        <tr>

                            {{-- Product --}}
                            <td>
                                <div class="td-product">
                                    <a href="{{ route('product.detail', $product->slug) }}"
                                       class="td-product-img">
                                        <img src="{{ $imgSrc }}"
                                             alt="{{ $productName }}"
                                             onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                    </a>
                                    <a href="{{ route('product.detail', $product->slug) }}"
                                       class="td-product-name">
                                        {{ $productName }}
                                    </a>
                                </div>
                            </td>

                            {{-- Price --}}
                            <td class="td-price">
                                ${{ number_format($displayPrice, 2) }}
                            </td>

                            {{-- Stock Status --}}
                            <td>
                                @if($inStock)
                                    <span class="badge-stock">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                        In Stock
                                    </span>
                                @else
                                    <span class="badge-stock out">Out of Stock</span>
                                @endif
                            </td>

                            {{-- Add To Cart ── wishlist.moveToCart route ব্যবহার করছে --}}
                            {{-- এটা cart-এ add করে AND wishlist থেকে remove করে        --}}
                            <td>
                                @if($inStock)
                                    <a href="{{ route('wishlist.moveToCart', $item->id) }}"
                                       class="btn-add-cart">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.5 1.5H.5A.5.5 0 0 1 0 1.5z"/>
                                            <path d="M6.5 15a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                        </svg>
                                        Add To Cart
                                    </a>
                                @else
                                    <button class="btn-add-cart" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                        Out of Stock
                                    </button>
                                @endif
                            </td>

                            {{-- Remove --}}
                            <td class="td-remove">
                                <a href="{{ route('wishlist.remove', $item->id) }}"
                                   class="btn-remove"
                                   title="Remove"
                                   onclick="return confirm('এই পণ্যটি উইশলিস্ট থেকে সরাবেন?')">
                                    &times;
                                </a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            {{-- Empty State --}}
            <div class="wish-empty">
                <div class="empty-icon">
                    <i class="bi bi-heart"></i>
                </div>
                <h3>Your wishlist is empty!</h3>
                <p>Save your favourite products to your wishlist.</p>
                <a href="{{ route('frontend') }}" class="btn-shop-now">
                    <i class="bi bi-shop"></i> Start Shopping
                </a>
            </div>
        @endif

    </div>
</section>
@endsection
