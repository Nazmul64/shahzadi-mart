{{-- resources/views/frontend/cart.blade.php --}}
@extends('frontend.master')

@section('main-content')
<style>
.cart-page *, .cart-page *::before, .cart-page *::after { box-sizing: border-box; }
.cart-page {
    --red:      #e8192c;
    --red-d:    #c8101f;
    --red-bg:   #fff0f1;
    --dark:     #1a1a2e;
    --text:     #374151;
    --muted:    #9ca3af;
    --border:   #e5e7eb;
    --card:     #ffffff;
    --bg:       #f8f9fb;
    --green:    #16a34a;
    --blue:     #2563eb;
    --gold:     #f59e0b;
    --radius:   14px;
    --shadow:   0 2px 16px rgba(0,0,0,.07);
    font-family: 'Hind Siliguri', 'DM Sans', 'Segoe UI', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 80vh;
}
.cart-page a { text-decoration: none; color: inherit; }

.cp-bread {
    background: #fff;
    border-bottom: 1px solid var(--border);
    padding: 11px 0;
    font-size: 12px;
    color: var(--muted);
}
.cp-bread__in { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.cp-bread a   { color: var(--muted); transition: color .2s; }
.cp-bread a:hover { color: var(--red); }
.cp-bread__sep { color: #d1d5db; }
.cp-bread__cur { color: var(--text); font-weight: 600; }

.cp-alert {
    border-radius: 10px; padding: 11px 16px;
    font-size: 13px; font-weight: 600;
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 16px;
}
.cp-alert--success { background: #f0fdf4; color: var(--green); border: 1px solid #bbf7d0; }
.cp-alert--error   { background: var(--red-bg); color: var(--red); border: 1px solid #fecdd3; }
.cp-alert--info    { background: #eff6ff; color: var(--blue); border: 1px solid #bfdbfe; }

#cp-toasts {
    position: fixed; top: 20px; right: 20px; z-index: 999999;
    display: flex; flex-direction: column; gap: 10px; pointer-events: none;
}
.cp-toast {
    background: #fff; border-radius: 10px; padding: 13px 17px;
    font-size: 13px; font-weight: 600;
    display: flex; align-items: center; gap: 10px;
    box-shadow: 0 8px 28px rgba(0,0,0,.14); border-left: 4px solid;
    pointer-events: all; min-width: 240px; max-width: 340px;
    animation: cpToastIn .3s ease both;
}
.cp-toast--success { border-color: var(--green); color: #166534; }
.cp-toast--error   { border-color: var(--red);   color: #9b0000; }
.cp-toast--info    { border-color: var(--blue);   color: #1e40af; }
.cp-toast.out      { animation: cpToastOut .3s ease forwards; }
@keyframes cpToastIn  { from { opacity:0; transform:translateX(16px); } to { opacity:1; transform:none; } }
@keyframes cpToastOut { to   { opacity:0; transform:translateX(16px); } }

.cp-header {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 22px;
}
.cp-header h1 { font-size: 21px; font-weight: 700; color: var(--dark); margin: 0; }
.cp-header__badge {
    background: var(--red); color: #fff;
    font-size: 11px; font-weight: 800;
    padding: 2px 9px; border-radius: 20px;
}

.cp-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 22px;
    align-items: start;
}
@media(max-width:992px) { .cp-layout { grid-template-columns: 1fr; } }

.cp-card {
    background: var(--card);
    border-radius: var(--radius);
    border: 1.5px solid var(--border);
    overflow: hidden;
    box-shadow: var(--shadow);
}
.cp-card__head {
    padding: 14px 22px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    background: #fafafa;
}
.cp-card__head-title {
    font-size: 14px; font-weight: 700; color: var(--dark);
    display: flex; align-items: center; gap: 7px;
}
.cp-card__head-title i { color: var(--red); }

/* ── POST form buttons styled as links ── */
.cp-form-btn {
    background: none; border: none; padding: 0; margin: 0;
    cursor: pointer; font-family: inherit; line-height: 1;
    display: inline-flex; align-items: center;
}
.cp-clear-btn {
    font-size: 12px; color: var(--muted);
    background: none; border: 1.5px solid var(--border);
    padding: 5px 11px; border-radius: 6px; cursor: pointer;
    transition: all .2s; display: flex; align-items: center; gap: 5px;
    font-family: inherit;
}
.cp-clear-btn:hover { border-color: var(--red); color: var(--red); }

.cp-item {
    display: grid;
    grid-template-columns: 88px 1fr auto auto auto auto;
    align-items: center;
    gap: 14px;
    padding: 15px 22px;
    border-bottom: 1px solid var(--border);
    transition: background .15s;
}
.cp-item:last-child { border-bottom: none; }
.cp-item:hover { background: #fafafa; }

.cp-item__img {
    width: 88px; height: 88px;
    border-radius: 10px; object-fit: cover;
    border: 1.5px solid var(--border);
    flex-shrink: 0;
}

.cp-item__info { min-width: 0; }
.cp-item__name {
    font-size: 13.5px; font-weight: 600; color: var(--dark);
    line-height: 1.4; display: block;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; margin-bottom: 4px;
    transition: color .2s;
}
.cp-item__name:hover { color: var(--red); }
.cp-item__meta {
    font-size: 11px; color: var(--muted);
    display: flex; align-items: center; gap: 7px; flex-wrap: wrap; margin-top: 3px;
}
.cp-item__meta span { display: inline-flex; align-items: center; gap: 3px; }

.cp-chips { display: flex; gap: 5px; flex-wrap: wrap; margin-top: 5px; }
.cp-chip {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600;
    padding: 2px 9px; border-radius: 20px;
    border: 1px solid var(--border); background: #f9fafb;
    color: var(--text); white-space: nowrap;
}
.cp-chip--color { background: var(--red-bg); border-color: #fecdd3; color: var(--red); }
.cp-chip--size  { background: #eff6ff; border-color: #bfdbfe; color: var(--blue); }

.cp-item__price { text-align: right; }
.cp-item__price-cur { font-size: 15px; font-weight: 700; color: var(--red); white-space: nowrap; }
.cp-item__price-old { font-size: 11px; color: var(--muted); text-decoration: line-through; }

/* qty — POST form buttons */
.cp-qty {
    display: flex; align-items: center;
    border: 1.5px solid var(--border); border-radius: 8px; overflow: hidden;
}
.cp-qty__btn {
    width: 32px; height: 34px;
    background: #f3f4f6; border: none; cursor: pointer;
    font-size: 15px; font-weight: 700; color: var(--text);
    display: flex; align-items: center; justify-content: center;
    transition: background .15s, color .15s;
    font-family: inherit;
}
.cp-qty__btn:hover { background: var(--red); color: #fff; }
.cp-qty__val {
    width: 38px; text-align: center;
    font-size: 13px; font-weight: 700; color: var(--dark);
    border: none; outline: none; background: #fff;
    border-left: 1.5px solid var(--border);
    border-right: 1.5px solid var(--border);
    padding: 0; line-height: 34px;
}

.cp-item__total {
    font-size: 15px; font-weight: 700; color: var(--dark);
    white-space: nowrap;
}

/* remove button */
.cp-item__remove-btn {
    width: 34px; height: 34px; border-radius: 8px;
    background: #fff5f5; border: 1.5px solid #fecdd3;
    color: #f43f5e; display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .2s; font-size: 13px;
    font-family: inherit;
}
.cp-item__remove-btn:hover { background: var(--red); border-color: var(--red); color: #fff; }

.cp-summary {
    background: var(--card);
    border-radius: var(--radius);
    border: 1.5px solid var(--border);
    overflow: hidden;
    box-shadow: var(--shadow);
    position: sticky;
    top: 100px;
}
@media(max-width:992px) { .cp-summary { position: static; } }

.cp-summary__head {
    background: var(--dark); color: #fff;
    padding: 15px 22px;
    display: flex; align-items: center; gap: 8px;
    font-size: 14px; font-weight: 700;
}
.cp-summary__head i { color: #f87171; }
.cp-summary__body { padding: 18px 20px; }

.cp-coupon-row { display: flex; gap: 8px; margin-bottom: 8px; }
.cp-coupon-input {
    flex: 1; border: 1.5px solid var(--border); border-radius: 8px;
    padding: 9px 13px; font-size: 13px; outline: none;
    transition: border .2s; font-family: inherit; color: var(--text);
}
.cp-coupon-input:focus { border-color: var(--red); }
.cp-coupon-input::placeholder { color: var(--muted); }
.cp-coupon-btn {
    background: var(--dark); color: #fff; border: none;
    padding: 9px 15px; border-radius: 8px;
    font-size: 12px; font-weight: 700; cursor: pointer;
    transition: background .2s; letter-spacing: .5px; font-family: inherit;
}
.cp-coupon-btn:hover { background: var(--red); }

.cp-coupon-msg {
    font-size: 12px; font-weight: 600;
    padding: 7px 12px; border-radius: 7px; margin-bottom: 12px;
    display: flex; align-items: center; gap: 6px;
}
.cp-coupon-msg--error   { background: var(--red-bg); color: var(--red); }
.cp-coupon-msg--success { background: #f0fdf4; color: var(--green); }

.cp-price-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 9px 0; font-size: 13px; color: var(--text);
    border-bottom: 1px dashed var(--border);
}
.cp-price-row:last-of-type { border-bottom: none; }
.cp-price-row .lbl { display: flex; align-items: center; gap: 5px; color: var(--muted); }
.cp-price-row .lbl i { font-size: 12px; }
.cp-price-row .val { font-weight: 600; color: var(--dark); }
.cp-price-row--discount .val { color: var(--green); }

.cp-ship-note {
    display: flex; align-items: center; gap: 8px;
    padding: 9px 12px; background: #fffbeb;
    border: 1px solid #fcd34d; border-radius: 8px;
    margin: 10px 0; font-size: 12px; color: #92400e; font-weight: 500;
}
.cp-ship-note i { color: var(--gold); flex-shrink: 0; }

.cp-total-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 14px 0 4px; border-top: 2px solid var(--border); margin-top: 4px;
}
.cp-total-row .lbl { font-size: 14px; font-weight: 700; color: var(--dark); }
.cp-total-row .val { font-size: 22px; font-weight: 800; color: var(--red); }

.cp-checkout-btn {
    display: flex; width: 100%; background: var(--red);
    color: #fff !important; -webkit-text-fill-color: #fff;
    border: none; padding: 14px; border-radius: 11px;
    font-size: 15px; font-weight: 700; cursor: pointer;
    transition: background .2s, transform .15s, box-shadow .2s;
    text-align: center; text-decoration: none !important; margin-top: 16px;
    font-family: inherit; align-items: center; justify-content: center; gap: 8px;
}
.cp-checkout-btn:hover {
    background: var(--red-d);
    color: #fff !important;
    transform: scale(1.01);
    box-shadow: 0 4px 16px rgba(232,25,44,.3);
}

.cp-secure {
    text-align: center; font-size: 12px; color: var(--muted);
    margin-top: 11px; display: flex; align-items: center; justify-content: center; gap: 5px;
}
.cp-continue {
    display: flex; align-items: center; gap: 7px;
    font-size: 13px; color: var(--muted); text-decoration: none;
    transition: color .2s; margin-top: 12px; justify-content: center;
}
.cp-continue:hover { color: var(--red); }

.cp-empty {
    text-align: center; padding: 70px 20px;
    background: var(--card); border-radius: var(--radius);
    border: 2px dashed var(--border); box-shadow: var(--shadow);
}
.cp-empty__icon {
    width: 100px; height: 100px; background: var(--red-bg);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
}
.cp-empty__icon i { font-size: 42px; color: var(--red); }
.cp-empty h3 { font-size: 20px; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
.cp-empty p  { color: var(--muted); font-size: 14px; margin-bottom: 22px; }
.cp-shop-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--red); color: #fff !important;
    padding: 12px 28px; border-radius: 10px;
    font-weight: 600; font-size: 14px; text-decoration: none !important;
    transition: background .2s;
}
.cp-shop-btn:hover { background: var(--red-d); color: #fff !important; }

@media(max-width:576px) {
    .cp-item {
        grid-template-columns: 70px 1fr;
        grid-template-rows: auto auto auto;
        gap: 10px;
    }
    .cp-item__img { width: 70px; height: 70px; }
    .cp-item__price, .cp-item__total { grid-column: 2; }
    .cp-qty, .cp-item__remove-btn { grid-column: 2; }
    #cp-toasts { top: auto; bottom: 20px; right: 10px; left: 10px; }
    .cp-toast { max-width: 100%; }
}
</style>

<div id="cp-toasts"></div>

<div class="cart-page">

    {{-- BREADCRUMB --}}
    <div class="cp-bread">
        <div class="container">
            <div class="cp-bread__in">
                <a href="{{ route('frontend') }}"><i class="bi bi-house-fill"></i> হোম</a>
                <span class="cp-bread__sep">›</span>
                <span class="cp-bread__cur">শপিং কার্ট</span>
            </div>
        </div>
    </div>

    <div style="padding: 36px 0 60px;">
        <div class="container">

            @if(session('success'))
                <div class="cp-alert cp-alert--success">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="cp-alert cp-alert--error">
                    <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                </div>
            @endif
            @if(session('info'))
                <div class="cp-alert cp-alert--info">
                    <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
                </div>
            @endif

            @php
                $cartItems = session('cart', []);
                $hasItems  = !empty($cartItems);
                $subtotal  = 0;
                $discount  = (float) session('coupon_discount', 0);
            @endphp

            @if($hasItems)

                <div class="cp-header">
                    <i class="bi bi-cart3" style="font-size:22px;color:var(--red)"></i>
                    <h1>শপিং কার্ট</h1>
                    <span class="cp-header__badge">{{ count($cartItems) }}</span>
                </div>

                <div class="cp-layout">

                    {{-- LEFT: ITEMS --}}
                    <div>
                        <div class="cp-card">
                            <div class="cp-card__head">
                                <span class="cp-card__head-title">
                                    <i class="bi bi-bag-check"></i> কার্টে থাকা পণ্য
                                </span>

                                {{-- ✅ Clear cart — POST form --}}
                                <form action="{{ route('cart.clear') }}" method="POST"
                                      onsubmit="return confirm('সব পণ্য সরিয়ে দেবেন?')">
                                    @csrf
                                    <button type="submit" class="cp-clear-btn">
                                        <i class="bi bi-trash3"></i> সব মুছুন
                                    </button>
                                </form>
                            </div>

                            @foreach($cartItems as $cartKey => $item)
                            @php
                                $hasDisc   = isset($item['discount_price']) && $item['discount_price'] > 0;
                                $unitPrice = $hasDisc ? $item['discount_price'] : $item['price'];
                                $lineTotal = $unitPrice * $item['quantity'];
                                $subtotal += $lineTotal;
                                $imgSrc    = !empty($item['image'])
                                                ? asset('uploads/products/' . $item['image'])
                                                : asset('images/placeholder.png');
                                $selColor  = $item['selected_color'] ?? null;
                                $selSize   = $item['selected_size']  ?? null;
                            @endphp

                            <div class="cp-item">

                                {{-- Image --}}
                                <img src="{{ $imgSrc }}"
                                     class="cp-item__img"
                                     alt="{{ $item['name'] }}"
                                     onerror="this.src='{{ asset('images/placeholder.png') }}'">

                                {{-- Info --}}
                                <div class="cp-item__info">
                                    <a href="{{ route('product.detail', $item['slug'] ?? $cartKey) }}"
                                       class="cp-item__name">{{ $item['name'] }}</a>

                                    <div class="cp-item__meta">
                                        @if(isset($item['category']))
                                            <span><i class="bi bi-tag"></i> {{ $item['category'] }}</span>
                                        @endif
                                        @if($hasDisc)
                                            <span style="color:var(--green)">
                                                <i class="bi bi-percent"></i>
                                                {{ round((($item['price'] - $item['discount_price']) / $item['price']) * 100) }}% ছাড়
                                            </span>
                                        @endif
                                    </div>

                                    @if($selColor || $selSize)
                                    <div class="cp-chips">
                                        @if($selColor)
                                            <span class="cp-chip cp-chip--color">
                                                <i class="bi bi-circle-fill" style="font-size:7px"></i>
                                                {{ $selColor }}
                                            </span>
                                        @endif
                                        @if($selSize)
                                            <span class="cp-chip cp-chip--size">
                                                <i class="bi bi-rulers" style="font-size:9px"></i>
                                                {{ $selSize }}
                                            </span>
                                        @endif
                                    </div>
                                    @endif
                                </div>

                                {{-- Unit Price --}}
                                <div class="cp-item__price">
                                    <div class="cp-item__price-cur">৳ {{ number_format($unitPrice, 0) }}</div>
                                    @if($hasDisc)
                                        <div class="cp-item__price-old">৳ {{ number_format($item['price'], 0) }}</div>
                                    @endif
                                </div>

                                {{-- ✅ Qty — POST forms --}}
                                <div class="cp-qty">
                                    <form action="{{ route('cart.decrease', $cartKey) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="cp-qty__btn" title="কমান">−</button>
                                    </form>
                                    <span class="cp-qty__val">{{ $item['quantity'] }}</span>
                                    <form action="{{ route('cart.increase', $cartKey) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="cp-qty__btn" title="বাড়ান">+</button>
                                    </form>
                                </div>

                                {{-- Line Total --}}
                                <div class="cp-item__total">৳ {{ number_format($lineTotal, 0) }}</div>

                                {{-- ✅ Remove — POST form --}}
                                <form action="{{ route('cart.remove', $cartKey) }}" method="POST"
                                      onsubmit="return confirm('এই পণ্যটি সরাবেন?')">
                                    @csrf
                                    <button type="submit" class="cp-item__remove-btn" title="সরান">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>

                            </div>
                            @endforeach

                        </div>
                    </div>

                    {{-- RIGHT: SUMMARY --}}
                    <div>
                        <div class="cp-summary">
                            <div class="cp-summary__head">
                                <i class="bi bi-bag-heart-fill"></i>
                                অর্ডার সামারি ({{ count($cartItems) }})
                            </div>
                            <div class="cp-summary__body">

                                {{-- Coupon --}}
                                <form action="{{ route('cart.coupon') }}" method="POST">
                                    @csrf
                                    <div class="cp-coupon-row">
                                        <input type="text"
                                               name="coupon_code"
                                               class="cp-coupon-input"
                                               placeholder="কুপন কোড লিখুন..."
                                               value="{{ session('coupon_code') }}">
                                        <button type="submit" class="cp-coupon-btn">APPLY</button>
                                    </div>
                                </form>

                                @if(session('coupon_error'))
                                    <div class="cp-coupon-msg cp-coupon-msg--error">
                                        <i class="bi bi-x-circle-fill"></i> {{ session('coupon_error') }}
                                    </div>
                                @endif
                                @if(session('coupon_discount') && session('coupon_code'))
                                    <div class="cp-coupon-msg cp-coupon-msg--success">
                                        <i class="bi bi-check-circle-fill"></i>
                                        "{{ session('coupon_code') }}" প্রয়োগ হয়েছে! ছাড়: ৳{{ number_format(session('coupon_discount'), 2) }}
                                    </div>
                                @endif

                                <div class="cp-price-row">
                                    <span class="lbl"><i class="bi bi-receipt"></i> সাবটোটাল</span>
                                    <span class="val">৳ {{ number_format($subtotal, 2) }}</span>
                                </div>

                                @if($discount > 0)
                                <div class="cp-price-row cp-price-row--discount">
                                    <span class="lbl"><i class="bi bi-tags-fill"></i> কুপন ছাড়</span>
                                    <span class="val">− ৳ {{ number_format($discount, 2) }}</span>
                                </div>
                                @endif

                                <div class="cp-ship-note">
                                    <i class="bi bi-truck"></i>
                                    <span>ডেলিভারি চার্জ চেকআউটে এলাকা অনুযায়ী যোগ হবে।</span>
                                </div>

                                @php $displayTotal = $subtotal - $discount; @endphp

                                <div class="cp-total-row">
                                    <span class="lbl">মোট পরিমাণ</span>
                                    <span class="val">৳ {{ number_format($displayTotal, 2) }}</span>
                                </div>

                                <a href="{{ route('checkout') }}" class="cp-checkout-btn">
                                    <i class="bi bi-check-circle-fill"></i> অর্ডার নিশ্চিত করুন
                                </a>

                                <p class="cp-secure">
                                    <i class="bi bi-lock-fill"></i> ১০০% নিরাপদ চেকআউট
                                </p>

                                <a href="{{ route('frontend') }}" class="cp-continue">
                                    <i class="bi bi-arrow-left"></i> শপিং চালিয়ে যান
                                </a>

                            </div>
                        </div>
                    </div>

                </div>

            @else

                <div class="cp-empty">
                    <div class="cp-empty__icon">
                        <i class="bi bi-cart-x"></i>
                    </div>
                    <h3>কার্ট এখন খালি!</h3>
                    <p>আপনার পছন্দের পণ্য কার্টে যোগ করুন।</p>
                    <a href="{{ route('frontend') }}" class="cp-shop-btn">
                        <i class="bi bi-shop"></i> শপিং শুরু করুন
                    </a>
                </div>

            @endif

        </div>
    </div>

</div>

<script>
(function () {
    'use strict';

    function toast(msg, type, ms) {
        type = type || 'success'; ms = ms || 3000;
        var icons = {
            success: 'bi bi-check-circle-fill',
            error:   'bi bi-x-circle-fill',
            info:    'bi bi-info-circle-fill'
        };
        var el = document.createElement('div');
        el.className = 'cp-toast cp-toast--' + type;
        el.innerHTML = '<i class="' + (icons[type] || icons.info) + '"></i><span>' + msg + '</span>';
        var wrap = document.getElementById('cp-toasts');
        if (wrap) wrap.appendChild(el);
        setTimeout(function () {
            el.classList.add('out');
            setTimeout(function () { if (el.parentNode) el.parentNode.removeChild(el); }, 320);
        }, ms);
    }

    @if(session('success'))
        toast('{{ addslashes(session('success')) }}', 'success');
    @endif
    @if(session('error'))
        toast('{{ addslashes(session('error')) }}', 'error');
    @endif
    @if(session('info'))
        toast('{{ addslashes(session('info')) }}', 'info');
    @endif

})();
</script>
@endsection
