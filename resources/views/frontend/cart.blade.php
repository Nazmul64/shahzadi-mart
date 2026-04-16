{{-- resources/views/frontend/cart.blade.php --}}
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

    /* ── Alert Messages ── */
    .alert-msg {
        border-radius: 10px;
        padding: 12px 18px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 18px;
    }
    .alert-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .alert-error   { background: #fff0f1; color: var(--primary); border: 1px solid #fecdd3; }
    .alert-info    { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }

    /* ── Page Header ── */
    .cart-page-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
    }
    .cart-page-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }
    .cart-count-badge {
        background: var(--primary);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
    }

    /* ── Layout ── */
    .cart-layout {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 24px;
        align-items: start;
    }

    /* ── Cart Table Card ── */
    .cart-card {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1.5px solid var(--border);
        overflow: hidden;
    }
    .cart-card-head {
        padding: 16px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .cart-card-head span {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .cart-card-head span i { color: var(--primary); }
    .btn-clear {
        font-size: 12px;
        color: var(--muted);
        background: none;
        border: 1.5px solid var(--border);
        padding: 5px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: all .2s;
        display: flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
    }
    .btn-clear:hover { border-color: var(--primary); color: var(--primary); }

    /* ── Cart Item ── */
    .cart-item {
        display: grid;
        grid-template-columns: 90px 1fr auto auto auto auto;
        align-items: center;
        gap: 16px;
        padding: 16px 24px;
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }
    .cart-item:last-child { border-bottom: none; }
    .cart-item:hover { background: #fafafa; }

    .cart-item-img {
        width: 90px;
        height: 90px;
        border-radius: 10px;
        object-fit: cover;
        border: 1.5px solid var(--border);
    }

    .cart-item-info { min-width: 0; }
    .cart-item-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-decoration: none;
        margin-bottom: 4px;
        display: block;
    }
    .cart-item-name:hover { color: var(--primary); }
    .cart-item-meta {
        font-size: 12px;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 4px;
    }
    .cart-item-meta span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* ── Variant Chips ── */
    .cart-variant-chips {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        margin-top: 5px;
    }
    .cart-variant-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 9px;
        border-radius: 20px;
        border: 1px solid var(--border);
        background: #f9fafb;
        color: var(--text);
        white-space: nowrap;
    }
    .cart-variant-chip.color-chip {
        background: #fff0f1;
        border-color: #fecdd3;
        color: var(--primary);
    }
    .cart-variant-chip.size-chip {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #2563eb;
    }

    .cart-unit-price {
        font-size: 15px;
        font-weight: 700;
        color: var(--primary);
        white-space: nowrap;
        text-align: right;
    }
    .cart-unit-old {
        font-size: 12px;
        color: var(--muted);
        text-decoration: line-through;
        text-align: right;
    }

    /* qty */
    .qty-control {
        display: flex;
        align-items: center;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
    }
    .qty-btn {
        width: 32px;
        height: 36px;
        background: #f3f4f6;
        border: none;
        cursor: pointer;
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
        transition: background .15s;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .qty-btn:hover { background: var(--primary); color: #fff; }
    .qty-val {
        width: 40px;
        text-align: center;
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        border: none;
        outline: none;
        background: #fff;
    }

    .cart-subtotal {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        white-space: nowrap;
    }

    .cart-remove {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #fff5f5;
        border: 1.5px solid #fecdd3;
        color: #f43f5e;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .2s;
        font-size: 14px;
        text-decoration: none;
    }
    .cart-remove:hover { background: var(--primary); border-color: var(--primary); color: #fff; }

    /* ── Order Summary ── */
    .summary-card {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1.5px solid var(--border);
        overflow: hidden;
        position: sticky;
        top: 100px;
    }
    .summary-head {
        background: var(--dark);
        color: #fff;
        padding: 16px 22px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
        font-weight: 700;
    }
    .summary-head i { color: #f87171; }

    .summary-body { padding: 20px 22px; }

    /* coupon */
    .coupon-row {
        display: flex;
        gap: 8px;
        margin-bottom: 8px;
    }
    .coupon-input {
        flex: 1;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 13px;
        outline: none;
        transition: border .2s;
        font-family: 'Hind Siliguri', sans-serif;
    }
    .coupon-input:focus { border-color: var(--primary); }
    .coupon-input::placeholder { color: var(--muted); }
    .btn-apply {
        background: var(--dark);
        color: #fff;
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s;
        letter-spacing: .5px;
    }
    .btn-apply:hover { background: var(--primary); }

    .coupon-msg {
        font-size: 12px;
        font-weight: 600;
        padding: 7px 12px;
        border-radius: 7px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .coupon-msg.error   { background: #fff0f1; color: var(--primary); }
    .coupon-msg.success { background: #f0fdf4; color: #16a34a; }

    /* price rows */
    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        font-size: 14px;
        color: var(--text);
        border-bottom: 1px dashed var(--border);
    }
    .price-row:last-of-type { border-bottom: none; }
    .price-row .label { display: flex; align-items: center; gap: 6px; }
    .price-row .label i { color: var(--muted); font-size: 13px; }
    .price-row .val { font-weight: 600; color: var(--dark); }
    .price-row.discount .val { color: #16a34a; }

    /* Shipping note row */
    .shipping-note-row {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        background: #fffbeb;
        border: 1px solid #fcd34d;
        border-radius: 8px;
        margin: 10px 0;
        font-size: 12px;
        color: #92400e;
        font-weight: 500;
    }
    .shipping-note-row i { color: #f59e0b; flex-shrink: 0; font-size: 13px; }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0 4px;
        border-top: 2px solid var(--border);
        margin-top: 4px;
    }
    .total-row .total-label { font-size: 15px; font-weight: 700; color: var(--dark); }
    .total-row .total-val   { font-size: 22px; font-weight: 800; color: var(--primary); }

    .btn-checkout {
        display: flex;
        width: 100%;
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, transform .15s;
        text-align: center;
        text-decoration: none;
        margin-top: 18px;
        font-family: 'Hind Siliguri', sans-serif;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-sizing: border-box;
    }
    .btn-checkout:hover { background: #c8101f; transform: scale(1.01); color: #fff; }

    .secure-note {
        text-align: center;
        font-size: 12px;
        color: var(--muted);
        margin-top: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .btn-continue {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--muted);
        text-decoration: none;
        transition: color .2s;
        margin-top: 14px;
        justify-content: center;
    }
    .btn-continue:hover { color: var(--primary); }

    /* ── Empty ── */
    .cart-empty {
        text-align: center;
        padding: 70px 20px;
        background: var(--card-bg);
        border-radius: 16px;
        border: 2px dashed var(--border);
    }
    .cart-empty .empty-icon {
        width: 100px;
        height: 100px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    .cart-empty .empty-icon i { font-size: 42px; color: var(--primary); }
    .cart-empty h3 { font-size: 20px; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
    .cart-empty p  { color: var(--muted); font-size: 14px; margin-bottom: 22px; }
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

    @media(max-width:992px){
        .cart-layout { grid-template-columns: 1fr; }
        .summary-card { position: static; }
    }
    @media(max-width:576px){
        .cart-item {
            grid-template-columns: 70px 1fr;
            grid-template-rows: auto auto auto;
        }
        .cart-item-img { width: 70px; height: 70px; }
    }
</style>

{{-- ════════════════════════════ Breadcrumb ════════════════════════════ --}}
<div class="breadcrumb-bar">
    <div class="container">
        <div class="bc-inner">
            <a href="{{ route('frontend') }}"><i class="bi bi-house-fill"></i> হোম</a>
            <span class="sep">/</span>
            <span class="current">শপিং কার্ট</span>
        </div>
    </div>
</div>

<section class="cart-section" style="background:var(--bg);min-height:80vh;padding:40px 0 60px;font-family:'Hind Siliguri','Segoe UI',sans-serif;">
    <div class="container">

        {{-- ════════════════════ Flash Messages ════════════════════ --}}
        @if(session('success'))
            <div class="alert-msg alert-success">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-msg alert-error">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div class="alert-msg alert-info">
                <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
            </div>
        @endif

        @php
            $cartItems = session('cart', []);
            $hasItems  = !empty($cartItems);
            $subtotal  = 0;
            $discount  = (float) session('coupon_discount', 0);
        @endphp

        {{-- ════════════════════ HAS ITEMS ════════════════════ --}}
        @if($hasItems)

            <div class="cart-page-header">
                <i class="bi bi-cart3" style="font-size:22px;color:var(--primary)"></i>
                <h1>শপিং কার্ট</h1>
                <span class="cart-count-badge">{{ count($cartItems) }}</span>
            </div>

            <div class="cart-layout">

                {{-- ════════ Left: Items ════════ --}}
                <div>
                    <div class="cart-card">
                        <div class="cart-card-head">
                            <span><i class="bi bi-bag-check"></i> কার্টে থাকা পণ্য</span>
                            {{--
                                route('cart.clear')
                                → web.php: Route::get('/clear', ...)->name('clear')
                                → URL: GET /cart/clear
                            --}}
                            <a href="{{ route('cart.clear') }}"
                               class="btn-clear"
                               onclick="return confirm('সব পণ্য সরিয়ে দেবেন?')">
                                <i class="bi bi-trash3"></i> সব মুছুন
                            </a>
                        </div>

                        @foreach($cartItems as $id => $item)
                        @php
                            $hasDisc   = isset($item['discount_price']) && $item['discount_price'] > 0;
                            $unitPrice = $hasDisc ? $item['discount_price'] : $item['price'];
                            $lineTotal = $unitPrice * $item['quantity'];
                            $subtotal += $lineTotal;

                            $imgSrc = !empty($item['image'])
                                ? asset('uploads/products/' . $item['image'])
                                : asset('images/placeholder.png');

                            $selColor = $item['selected_color'] ?? null;
                            $selSize  = $item['selected_size']  ?? null;
                        @endphp

                        <div class="cart-item">

                            {{-- Image --}}
                            <img src="{{ $imgSrc }}"
                                 class="cart-item-img"
                                 alt="{{ $item['name'] }}"
                                 onerror="this.src='{{ asset('images/placeholder.png') }}'">

                            {{-- Info --}}
                            <div class="cart-item-info">
                                <a href="{{ route('product.detail', $item['slug'] ?? $id) }}"
                                   class="cart-item-name">{{ $item['name'] }}</a>

                                <div class="cart-item-meta">
                                    @if(isset($item['category']))
                                        <span><i class="bi bi-tag"></i> {{ $item['category'] }}</span>
                                    @endif
                                    @if($hasDisc)
                                        <span style="color:#16a34a">
                                            <i class="bi bi-percent"></i>
                                            {{ round((($item['price'] - $item['discount_price']) / $item['price']) * 100) }}% ছাড়
                                        </span>
                                    @endif
                                </div>

                                @if($selColor || $selSize)
                                <div class="cart-variant-chips">
                                    @if($selColor)
                                        <span class="cart-variant-chip color-chip">
                                            <i class="bi bi-circle-fill" style="font-size:8px"></i>
                                            {{ $selColor }}
                                        </span>
                                    @endif
                                    @if($selSize)
                                        <span class="cart-variant-chip size-chip">
                                            <i class="bi bi-rulers" style="font-size:9px"></i>
                                            {{ $selSize }}
                                        </span>
                                    @endif
                                </div>
                                @endif
                            </div>

                            {{-- Unit Price --}}
                            <div style="text-align:right">
                                <div class="cart-unit-price">৳ {{ number_format($unitPrice, 0) }}</div>
                                @if($hasDisc)
                                    <div class="cart-unit-old">৳ {{ number_format($item['price'], 0) }}</div>
                                @endif
                            </div>

                            {{-- Qty Control
                                route('cart.decrease', $id) → GET /cart/decrease/{key}
                                route('cart.increase', $id) → GET /cart/increase/{key}
                            --}}
                            <div class="qty-control">
                                <a href="{{ route('cart.decrease', $id) }}" class="qty-btn">−</a>
                                <span class="qty-val">{{ $item['quantity'] }}</span>
                                <a href="{{ route('cart.increase', $id) }}" class="qty-btn">+</a>
                            </div>

                            {{-- Line Total --}}
                            <div class="cart-subtotal">৳ {{ number_format($lineTotal, 0) }}</div>

                            {{-- Remove
                                route('cart.remove', $id) → GET /cart/remove/{key}
                            --}}
                            <a href="{{ route('cart.remove', $id) }}" class="cart-remove" title="সরান">
                                <i class="bi bi-trash3-fill"></i>
                            </a>

                        </div>
                        @endforeach

                    </div>{{-- /.cart-card --}}
                </div>{{-- /.left --}}

                {{-- ════════ Right: Summary ════════ --}}
                <div>
                    <div class="summary-card">
                        <div class="summary-head">
                            <i class="bi bi-bag-heart-fill"></i>
                            অর্ডার সামারি ({{ count($cartItems) }})
                        </div>
                        <div class="summary-body">

                            {{-- Coupon: route('cart.coupon') → POST /cart/coupon --}}
                            <form action="{{ route('cart.coupon') }}" method="POST">
                                @csrf
                                <div class="coupon-row">
                                    <input type="text"
                                           name="coupon_code"
                                           class="coupon-input"
                                           placeholder="কুপন কোড আছে? এখানে লিখুন..."
                                           value="{{ session('coupon_code') }}">
                                    <button type="submit" class="btn-apply">APPLY</button>
                                </div>
                            </form>

                            @if(session('coupon_error'))
                                <div class="coupon-msg error">
                                    <i class="bi bi-x-circle-fill"></i> {{ session('coupon_error') }}
                                </div>
                            @endif
                            @if(session('coupon_discount') && session('coupon_code'))
                                <div class="coupon-msg success">
                                    <i class="bi bi-check-circle-fill"></i>
                                    "{{ session('coupon_code') }}" কুপন প্রয়োগ হয়েছে! ছাড়: ৳{{ number_format(session('coupon_discount'), 2) }}
                                </div>
                            @endif

                            {{-- Price rows --}}
                            <div class="price-row">
                                <span class="label"><i class="bi bi-receipt"></i> সাবটোটাল</span>
                                <span class="val">৳ {{ number_format($subtotal, 2) }}</span>
                            </div>

                            @if($discount > 0)
                            <div class="price-row discount">
                                <span class="label"><i class="bi bi-tags-fill"></i> কুপন ছাড়</span>
                                <span class="val">− ৳ {{ number_format($discount, 2) }}</span>
                            </div>
                            @endif

                            <div class="shipping-note-row">
                                <i class="bi bi-truck"></i>
                                <span>ডেলিভারি চার্জ চেকআউটে এলাকা অনুযায়ী যোগ হবে।</span>
                            </div>

                            @php $displayTotal = $subtotal - $discount; @endphp

                            <div class="total-row">
                                <span class="total-label">সাবটোটাল</span>
                                <span class="total-val">৳ {{ number_format($displayTotal, 2) }}</span>
                            </div>

                            {{-- route('checkout') → GET /checkout --}}
                            <a href="{{ route('checkout') }}" class="btn-checkout">
                                অর্ডার নিশ্চিত করুন <i class="bi bi-check-circle-fill"></i>
                            </a>

                            <p class="secure-note">
                                <i class="bi bi-lock-fill"></i> ১০০% নিরাপদ চেকআউট প্রসেস
                            </p>

                            {{-- route('frontend') → GET / --}}
                            <a href="{{ route('frontend') }}" class="btn-continue">
                                <i class="bi bi-arrow-left"></i> শপিং চালিয়ে যান
                            </a>

                        </div>
                    </div>
                </div>{{-- /.right --}}

            </div>{{-- /.cart-layout --}}

        @else

            {{-- ════════════════════ EMPTY CART ════════════════════ --}}
            <div class="cart-empty">
                <div class="empty-icon">
                    <i class="bi bi-cart-x"></i>
                </div>
                <h3>কার্ট এখন খালি!</h3>
                <p>আপনার পছন্দের পণ্য কার্টে যোগ করুন।</p>
                <a href="{{ route('frontend') }}" class="btn-shop-now">
                    <i class="bi bi-shop"></i> শপিং শুরু করুন
                </a>
            </div>

        @endif

    </div>
</section>
@endsection
