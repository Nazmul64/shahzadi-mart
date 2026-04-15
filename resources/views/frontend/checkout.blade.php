{{-- resources/views/frontend/checkout.blade.php --}}
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

    .checkout-section {
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

    /* ── Alert ── */
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

    /* ── Steps ── */
    .checkout-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        margin-bottom: 32px;
    }
    .step {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--muted);
        padding: 10px 20px;
    }
    .step.active { color: var(--primary); }
    .step.done   { color: #16a34a; }
    .step-num {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 800;
        color: var(--muted);
        flex-shrink: 0;
    }
    .step.active .step-num { background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(232,25,44,.3); }
    .step.done   .step-num { background: #16a34a; color: #fff; }
    .step-line       { width: 60px; height: 2px; background: #e5e7eb; }
    .step-line.done  { background: #16a34a; }

    /* ── Layout ── */
    .checkout-layout {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
        align-items: start;
    }

    /* ── Tabs ── */
    .panel-tabs {
        display: flex;
        border-bottom: 2px solid var(--border);
        background: var(--card-bg);
        border-radius: 16px 16px 0 0;
        overflow: hidden;
    }
    .ptab {
        flex: 1;
        padding: 14px 20px;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        color: var(--muted);
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: all .2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }
    .ptab.active { color: var(--primary); border-bottom-color: var(--primary); background: var(--primary-light); }
    .ptab i { font-size: 16px; }

    /* ── Card ── */
    .checkout-card {
        background: var(--card-bg);
        border: 1.5px solid var(--border);
        border-top: none;
        border-radius: 0 0 16px 16px;
    }
    .checkout-card-head {
        padding: 18px 26px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 22px;
    }
    .checkout-card-head .head-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 17px;
    }
    .checkout-card-head h2 { font-size: 17px; font-weight: 700; color: var(--dark); margin: 0; }
    .checkout-card-body { padding: 0 26px 26px; }

    /* ── Form ── */
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px; }
    .form-group label .req { color: var(--primary); margin-left: 2px; }
    .form-control {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 11px 15px;
        font-size: 14px;
        font-family: 'Hind Siliguri', sans-serif;
        color: var(--text);
        outline: none;
        transition: border .2s, box-shadow .2s;
        background: #fff;
        box-sizing: border-box;
    }
    .form-control::placeholder { color: #c4c9d4; }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(232,25,44,.08); }
    .form-control.is-invalid { border-color: var(--primary); }
    select.form-control { cursor: pointer; }
    textarea.form-control { resize: vertical; min-height: 100px; }
    .invalid-feedback { font-size: 12px; color: var(--primary); margin-top: 4px; display: flex; align-items: center; gap: 4px; }

    /* ── Payment Methods ── */
    .payment-methods { display: flex; flex-direction: column; gap: 12px; }
    .pay-option {
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 16px 20px;
        cursor: pointer;
        transition: all .2s;
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
    }
    .pay-option:hover { border-color: var(--primary); }
    .pay-option.selected { border-color: var(--dark); background: #f0f4ff; }
    .pay-option input[type="radio"] {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        accent-color: var(--dark);
    }
    .pay-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 22px; }
    .pay-icon.cod { background: #e0f2fe; color: #0369a1; }
    .pay-icon.bkash  { background: #fce7f3; }
    .pay-icon.shurjo { background: #fef3c7; }
    .pay-icon.uddokta { background: #ede9fe; }
    .pay-icon.aamar  { background: #ecfdf5; }
    .pay-icon img { width: 34px; height: auto; object-fit: contain; }
    .pay-info h4 { font-size: 14px; font-weight: 700; color: var(--dark); margin: 0 0 3px; }
    .pay-info p  { font-size: 12px; color: var(--muted); margin: 0; }

    /* ── Summary (right) ── */
    .summary-card {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1.5px solid var(--border);
        overflow: hidden;
        position: sticky;
        top: 90px;
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
    .summary-body { padding: 16px 20px; }

    .summary-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
    }
    .summary-item:last-of-type { border-bottom: none; }
    .si-img { width: 52px; height: 52px; border-radius: 8px; object-fit: cover; border: 1.5px solid var(--border); flex-shrink: 0; }
    .si-name { font-size: 13px; font-weight: 600; color: var(--dark); line-height: 1.3; flex: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .si-qty-price { text-align: right; flex-shrink: 0; }
    .si-qty-price .qty-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; color: var(--muted); margin-bottom: 4px; }
    .si-qty-price .item-price { font-size: 14px; font-weight: 700; color: var(--dark); }
    .si-remove { color: var(--muted); cursor: pointer; font-size: 15px; transition: color .15s; text-decoration: none; flex-shrink: 0; }
    .si-remove:hover { color: var(--primary); }

    /* coupon in checkout summary */
    .coupon-row { display: flex; gap: 8px; margin: 16px 0 8px; }
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
    .btn-apply { background: var(--dark); color: #fff; border: none; padding: 10px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; letter-spacing: .5px; transition: background .2s; }
    .btn-apply:hover { background: var(--primary); }

    .coupon-msg { font-size: 12px; font-weight: 600; padding: 7px 12px; border-radius: 7px; margin-bottom: 12px; display: flex; align-items: center; gap: 6px; }
    .coupon-msg.error   { background: #fff0f1; color: var(--primary); }
    .coupon-msg.success { background: #f0fdf4; color: #16a34a; }

    .price-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; font-size: 14px; color: var(--text); border-bottom: 1px dashed var(--border); }
    .price-row:last-of-type { border-bottom: none; }
    .price-row .label { display: flex; align-items: center; gap: 6px; }
    .price-row .label i { color: var(--muted); font-size: 13px; }
    .price-row .val { font-weight: 600; color: var(--dark); }

    .total-row { display: flex; justify-content: space-between; align-items: center; padding: 14px 0 4px; border-top: 2px solid var(--border); margin-top: 4px; }
    .total-row .total-label { font-size: 16px; font-weight: 800; color: var(--dark); }
    .total-row .total-val   { font-size: 22px; font-weight: 800; color: var(--primary); }

    .btn-place-order {
        display: flex;
        width: 100%;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, transform .15s;
        margin-top: 18px;
        font-family: 'Hind Siliguri', sans-serif;
        text-decoration: none;
    }
    .btn-place-order:hover { background: #c8101f; transform: scale(1.01); color: #fff; }

    .secure-note { text-align: center; font-size: 12px; color: var(--muted); margin-top: 12px; display: flex; align-items: center; justify-content: center; gap: 5px; }

    @media(max-width:992px){ .checkout-layout { grid-template-columns: 1fr; } .summary-card { position: static; } }
    @media(max-width:576px){ .form-row { grid-template-columns: 1fr; } .checkout-steps .step-line { width: 30px; } .step span { display: none; } }
</style>

{{-- Breadcrumb --}}
<div class="breadcrumb-bar">
    <div class="container">
        <div class="bc-inner">
            <a href="{{ route('frontend') }}"><i class="bi bi-house-fill"></i> হোম</a>
            <span class="sep">/</span>
            <a href="{{ route('cart') }}">কার্ট</a>
            <span class="sep">/</span>
            <span class="current">চেকআউট</span>
        </div>
    </div>
</div>

<section class="checkout-section">
    <div class="container">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert-msg alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-msg alert-error"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="alert-msg alert-info"><i class="bi bi-info-circle-fill"></i> {{ session('info') }}</div>
        @endif

        {{-- Steps --}}
        <div class="checkout-steps">
            <div class="step done">
                <div class="step-num"><i class="bi bi-check-lg"></i></div>
                <span>কার্ট</span>
            </div>
            <div class="step-line done"></div>
            <div class="step active">
                <div class="step-num">2</div>
                <span>চেকআউট</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-num">3</div>
                <span>নিশ্চিতকরণ</span>
            </div>
        </div>

        @php
            $cartItems   = session('cart', []);
            $subtotal    = 0;
            $deliveryFee = 70;
            $discount    = session('coupon_discount', 0);
            foreach ($cartItems as $item) {
                $p = (isset($item['discount_price']) && $item['discount_price'] > 0)
                    ? $item['discount_price'] : $item['price'];
                $subtotal += $p * $item['quantity'];
            }
            $total = $subtotal - $discount + $deliveryFee;
        @endphp

        <form action="{{ route('checkout.place') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="checkout-layout">

                {{-- ── LEFT ── --}}
                <div>

                    {{-- Tabs --}}
                    <div class="panel-tabs">
                        <div class="ptab active" onclick="showTab('shipping', this)">
                            <i class="bi bi-truck"></i> শিপিং তথ্য
                        </div>
                        <div class="ptab" onclick="showTab('payment', this)">
                            <i class="bi bi-credit-card-2-front"></i> পেমেন্ট মেথড
                        </div>
                    </div>

                    {{-- ── SHIPPING TAB ── --}}
                    <div class="checkout-card" id="tab-shipping">
                        <div class="checkout-card-head">
                            <div class="head-icon"><i class="bi bi-truck-front-fill"></i></div>
                            <h2>শিপিং এবং বিলিং তথ্য</h2>
                        </div>
                        <div class="checkout-card-body">

                            <div class="form-row">
                                <div class="form-group">
                                    <label>আপনার নাম <span class="req">*</span></label>
                                    <input type="text"
                                           name="customer_name"
                                           class="form-control @error('customer_name') is-invalid @enderror"
                                           placeholder="সম্পূর্ণ নাম লিখুন"
                                           value="{{ old('customer_name') }}"
                                           required>
                                    @error('customer_name')
                                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>মোবাইল নাম্বার <span class="req">*</span></label>
                                    <input type="tel"
                                           name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           placeholder="017xxxxxxxx"
                                           value="{{ old('phone') }}"
                                           required>
                                    @error('phone')
                                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>সম্পূর্ণ ঠিকানা <span class="req">*</span></label>
                                <input type="text"
                                       name="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       placeholder="বাসা নং, রোড নং, এলাকা, জেলা"
                                       value="{{ old('address') }}"
                                       required>
                                @error('address')
                                    <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>ডেলিভারি এরিয়া <span class="req">*</span></label>
                                <select name="delivery_area"
                                        class="form-control @error('delivery_area') is-invalid @enderror"
                                        required>
                                    <option value="">এরিয়া নির্বাচন করুন...</option>
                                    <optgroup label="ঢাকার ভেতরে">
                                        <option value="dhaka_inside" {{ old('delivery_area') === 'dhaka_inside' ? 'selected' : '' }}>
                                            ঢাকার ভেতরে
                                        </option>
                                    </optgroup>
                                    <optgroup label="ঢাকার বাইরে">
                                        <option value="dhaka_outside" {{ old('delivery_area') === 'dhaka_outside' ? 'selected' : '' }}>
                                            ঢাকার বাইরে
                                        </option>
                                    </optgroup>
                                    @if(isset($deliveryAreas))
                                        @foreach($deliveryAreas as $area)
                                            <option value="{{ $area->id }}" {{ old('delivery_area') == $area->id ? 'selected' : '' }}>
                                                {{ $area->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('delivery_area')
                                    <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>অর্ডার নোট (ঐচ্ছিক)</label>
                                <textarea name="note"
                                          class="form-control"
                                          placeholder="ডেলিভারি সম্পর্কে বিশেষ কিছু বলার থাকলে লিখুন...">{{ old('note') }}</textarea>
                            </div>

                            <button type="button"
                                    class="btn-place-order"
                                    style="margin-top:4px"
                                    onclick="showTab('payment', document.querySelectorAll('.ptab')[1])">
                                পেমেন্ট মেথড নির্বাচন করুন
                                <i class="bi bi-arrow-right-circle-fill"></i>
                            </button>

                        </div>
                    </div>

                    {{-- ── PAYMENT TAB ── --}}
                    <div class="checkout-card" id="tab-payment" style="display:none">
                        <div class="checkout-card-head">
                            <div class="head-icon"><i class="bi bi-wallet2"></i></div>
                            <h2>পেমেন্ট মেথড নির্বাচন করুন</h2>
                        </div>
                        <div class="checkout-card-body">
                            <div class="payment-methods">

                                <label class="pay-option selected" id="pay-cod">
                                    <div class="pay-icon cod"><i class="bi bi-truck"></i></div>
                                    <div class="pay-info">
                                        <h4>Cash On Delivery</h4>
                                        <p>পণ্য হাতে পেয়ে মূল্য পরিশোধ করুন</p>
                                    </div>
                                    <input type="radio" name="payment_method" value="cod" checked onchange="selectPay('pay-cod')">
                                </label>

                                <label class="pay-option" id="pay-bkash">
                                    <div class="pay-icon bkash">
                                        <img src="{{ asset('assets/img/payment/bkash.png') }}" alt="bKash"
                                             onerror="this.parentElement.innerHTML='<span style=\'font-size:20px;color:#e2136e\'>b</span>'">
                                    </div>
                                    <div class="pay-info">
                                        <h4>bKash Payment</h4>
                                        <p>বিকাশ অ্যাপ বা গেটওয়ের দ্বারা পেমেন্ট</p>
                                    </div>
                                    <input type="radio" name="payment_method" value="bkash" onchange="selectPay('pay-bkash')">
                                </label>

                                <label class="pay-option" id="pay-shurjo">
                                    <div class="pay-icon shurjo">
                                        <img src="{{ asset('assets/img/payment/shurjopay.png') }}" alt="ShurjoPay"
                                             onerror="this.parentElement.innerHTML='<i class=\'bi bi-credit-card-fill\' style=\'font-size:22px;color:#f59e0b\'></i>'">
                                    </div>
                                    <div class="pay-info">
                                        <h4>Online Payment</h4>
                                        <p>ShurjoPay (Card/Mobile Banking)</p>
                                    </div>
                                    <input type="radio" name="payment_method" value="shurjopay" onchange="selectPay('pay-shurjo')">
                                </label>

                                <label class="pay-option" id="pay-uddokta">
                                    <div class="pay-icon uddokta">
                                        <img src="{{ asset('assets/img/payment/uddoktapay.png') }}" alt="UddoktaPay"
                                             onerror="this.parentElement.innerHTML='<i class=\'bi bi-phone-fill\' style=\'font-size:22px;color:#7c3aed\'></i>'">
                                    </div>
                                    <div class="pay-info">
                                        <h4>UddoktaPay</h4>
                                        <p>মোবাইল ব্যাংকিং পেমেন্ট গেটওয়ে</p>
                                    </div>
                                    <input type="radio" name="payment_method" value="uddoktapay" onchange="selectPay('pay-uddokta')">
                                </label>

                                <label class="pay-option" id="pay-aamar">
                                    <div class="pay-icon aamar">
                                        <img src="{{ asset('assets/img/payment/aamarpay.png') }}" alt="aamarPay"
                                             onerror="this.parentElement.innerHTML='<i class=\'bi bi-bank2\' style=\'font-size:22px;color:#059669\'></i>'">
                                    </div>
                                    <div class="pay-info">
                                        <h4>aamarPay</h4>
                                        <p>কার্ড ও মোবাইল ব্যাংকিং পেমেন্ট</p>
                                    </div>
                                    <input type="radio" name="payment_method" value="aamarpay" onchange="selectPay('pay-aamar')">
                                </label>

                            </div>
                        </div>
                    </div>

                </div>{{-- /left --}}

                {{-- ── RIGHT: Summary ── --}}
                <div>
                    <div class="summary-card">
                        <div class="summary-head">
                            <i class="bi bi-bag-heart-fill"></i>
                            অর্ডার সামারি ({{ count($cartItems) }})
                        </div>
                        <div class="summary-body">

                            {{-- Items --}}
                            @foreach($cartItems as $id => $item)
                            @php
                                $hasDisc   = isset($item['discount_price']) && $item['discount_price'] > 0;
                                $unitPrice = $hasDisc ? $item['discount_price'] : $item['price'];
                            @endphp
                            <div class="summary-item">
                                <img src="{{ asset('storage/' . ($item['image'] ?? '')) }}"
                                     class="si-img"
                                     alt="{{ $item['name'] }}"
                                     onerror="this.src='{{ asset('assets/img/no-image.png') }}'">
                                <div class="si-name">{{ $item['name'] }}</div>
                                <div class="si-qty-price">
                                    <div class="qty-badge"><span>×{{ $item['quantity'] }}</span></div>
                                    <div class="item-price">৳ {{ number_format($unitPrice * $item['quantity'], 0) }}</div>
                                </div>
                                <a href="{{ route('cart.remove', $id) }}" class="si-remove">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                            </div>
                            @endforeach

                            {{-- Coupon --}}
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
                                    "{{ session('coupon_code') }}" প্রয়োগ হয়েছে! ছাড়: ৳{{ number_format(session('coupon_discount'), 2) }}
                                </div>
                            @endif

                            {{-- Price breakdown --}}
                            <div class="price-row">
                                <span class="label"><i class="bi bi-receipt"></i> সাবটোটাল</span>
                                <span class="val">৳ {{ number_format($subtotal, 2) }}</span>
                            </div>
                            @if($discount > 0)
                            <div class="price-row" style="color:#16a34a">
                                <span class="label"><i class="bi bi-tags-fill"></i> কুপন ছাড়</span>
                                <span class="val">- ৳ {{ number_format($discount, 2) }}</span>
                            </div>
                            @endif
                            <div class="price-row">
                                <span class="label"><i class="bi bi-truck"></i> ডেলিভারি চার্জ</span>
                                <span class="val">৳ {{ number_format($deliveryFee, 2) }}</span>
                            </div>

                            <div class="total-row">
                                <span class="total-label">সর্বমোট</span>
                                <span class="total-val">৳ {{ number_format($total, 2) }}</span>
                            </div>

                            <button type="submit" class="btn-place-order">
                                অর্ডার নিশ্চিত করুন <i class="bi bi-check-circle-fill"></i>
                            </button>

                            <p class="secure-note">
                                <i class="bi bi-lock-fill"></i> ১০০% নিরাপদ চেকআউট প্রসেস
                            </p>

                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</section>

<script>
function showTab(tab, el) {
    document.getElementById('tab-shipping').style.display = tab === 'shipping' ? '' : 'none';
    document.getElementById('tab-payment').style.display  = tab === 'payment'  ? '' : 'none';
    document.querySelectorAll('.ptab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

function selectPay(id) {
    document.querySelectorAll('.pay-option').forEach(o => o.classList.remove('selected'));
    document.getElementById(id).classList.add('selected');
}
</script>
@endsection
