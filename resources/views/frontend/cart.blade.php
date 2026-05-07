{{-- resources/views/frontend/cart.blade.php --}}
@extends('frontend.master')

@section('main-content')
<link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/cart.css">


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
                                        "{{ session('coupon_code') }}" প্রয়োগ হয়েছে! ছাড়: ৳{{ number_format(session('coupon_discount'), 0) }}
                                    </div>
                                @endif

                                <div class="cp-price-row">
                                    <span class="lbl"><i class="bi bi-receipt"></i> সাবটোটাল</span>
                                    <span class="val">৳ {{ number_format($subtotal, 0) }}</span>
                                </div>

                                @if($discount > 0)
                                <div class="cp-price-row cp-price-row--discount">
                                    <span class="lbl"><i class="bi bi-tags-fill"></i> কুপন ছাড়</span>
                                    <span class="val">− ৳ {{ number_format($discount, 0) }}</span>
                                </div>
                                @endif

                                <div class="cp-ship-note">
                                    <i class="bi bi-truck"></i>
                                    <span>ডেলিভারি চার্জ চেকআউটে এলাকা অনুযায়ী যোগ হবে।</span>
                                </div>

                                @php $displayTotal = $subtotal - $discount; @endphp

                                <div class="cp-total-row">
                                    <span class="lbl">মোট পরিমাণ</span>
                                    <span class="val">৳ {{ number_format($displayTotal, 0) }}</span>
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
