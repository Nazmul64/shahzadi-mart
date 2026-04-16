{{-- resources/views/frontend/checkout.blade.php --}}
@extends('frontend.master')

@section('main-content')
<style>
  .checkout-page *, .checkout-page *::before, .checkout-page *::after {
    box-sizing: border-box; margin: 0; padding: 0;
  }
  .checkout-page {
    --primary: #be0318; --primary-d: #960212;
    --text: #1a1a1a; --muted: #6b7280;
    --border: #e5e7eb; --bg: #f9fafb; --white: #ffffff;
    --green: #16a34a; --radius: 10px;
    --shadow: 0 2px 12px rgba(0,0,0,.08);
    font-family: 'DM Sans', sans-serif; font-size: 14px;
    color: var(--text); background: var(--bg); line-height: 1.6;
  }
  .checkout-page a { color: inherit; text-decoration: none; }
  .checkout-page input, .checkout-page select,
  .checkout-page textarea, .checkout-page button { font-family: inherit; }

  .checkout-page__container { max-width: 1140px; margin: 0 auto; padding: 0 20px; }

  /* ── TOP BAR ─────────────────────────────────────────────────────────────── */
  .checkout-page__top-bar {
    background: var(--white); border-bottom: 1px solid var(--border);
    padding: 10px 0; font-size: 12px; color: var(--muted);
  }
  .checkout-page__breadcrumb { display: flex; align-items: center; gap: 6px; }
  .checkout-page__breadcrumb a { color: var(--muted); transition: color .2s; }
  .checkout-page__breadcrumb a:hover { color: var(--primary); }

  /* ── FLASH ALERTS ────────────────────────────────────────────────────────── */
  .ck-alert {
    border-radius: 8px; padding: 10px 18px; font-size: 13px; font-weight: 600;
    display: flex; align-items: center; gap: 8px; margin: 10px 0;
  }
  .ck-alert-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
  .ck-alert-error   { background: #fff0f1; color: var(--primary); border: 1px solid #fecdd3; }
  .ck-alert-info    { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }

  /* ── GRID ────────────────────────────────────────────────────────────────── */
  .checkout-page__grid {
    display: grid; grid-template-columns: 1fr 400px; gap: 24px; margin: 24px 0;
  }
  @media(max-width:900px){ .checkout-page__grid { grid-template-columns: 1fr; } }

  /* ── CARD ────────────────────────────────────────────────────────────────── */
  .ck-card {
    background: var(--white); border-radius: var(--radius);
    box-shadow: var(--shadow); padding: 24px; margin-bottom: 20px;
  }
  .ck-card-title {
    font-size: 16px; font-weight: 700; margin-bottom: 18px;
    padding-bottom: 12px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 8px;
  }
  .ck-card-title i { color: var(--primary); }

  /* ── FORM ────────────────────────────────────────────────────────────────── */
  .ck-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
  .ck-form-row.full { grid-template-columns: 1fr; }
  @media(max-width:600px){ .ck-form-row { grid-template-columns: 1fr; } }

  .ck-field { display: flex; flex-direction: column; gap: 5px; }
  .ck-label { font-size: 12px; font-weight: 600; color: var(--text); }
  .ck-label span { color: var(--primary); }
  .ck-input {
    padding: 10px 14px; border: 1.5px solid var(--border);
    border-radius: 8px; font-size: 14px; color: var(--text); background: var(--white);
    transition: border-color .2s, box-shadow .2s; outline: none;
  }
  .ck-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(190,3,24,.1); }
  .ck-input.is-invalid { border-color: #f87171; }
  .ck-error { font-size: 11px; color: var(--primary); margin-top: 3px; }

  /* ── SHIPPING AREA SELECTOR ──────────────────────────────────────────────── */
  .ck-shipping-wrap { position: relative; }

  .ck-shipping-trigger {
    width: 100%; padding: 10px 40px 10px 14px; border: 1.5px solid var(--border);
    border-radius: 8px; font-size: 14px; color: var(--text); background: var(--white);
    text-align: left; cursor: pointer; transition: border-color .2s, box-shadow .2s;
    display: flex; align-items: center; justify-content: space-between; gap: 8px;
  }
  .ck-shipping-trigger:hover,
  .ck-shipping-trigger.open {
    border-color: var(--primary); box-shadow: 0 0 0 3px rgba(190,3,24,.08);
  }
  .ck-shipping-trigger-left {
    display: flex; align-items: center; gap: 8px; min-width: 0; flex: 1;
  }
  .ck-shipping-trigger-name {
    font-weight: 600; color: var(--text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  .ck-shipping-trigger-fee {
    font-size: 13px; font-weight: 700; color: var(--primary);
    background: #fff0f1; padding: 2px 8px; border-radius: 20px;
    border: 1px solid #fecdd3; white-space: nowrap; flex-shrink: 0;
  }
  .ck-shipping-trigger-placeholder { color: var(--muted); font-weight: 400; }
  .ck-shipping-caret {
    color: var(--muted); font-size: 12px; flex-shrink: 0; transition: transform .2s;
  }
  .ck-shipping-trigger.open .ck-shipping-caret { transform: rotate(180deg); }

  .ck-shipping-dropdown {
    position: absolute; top: calc(100% + 6px); left: 0; right: 0;
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: 10px; box-shadow: 0 8px 32px rgba(0,0,0,.12);
    z-index: 200; max-height: 280px; display: flex; flex-direction: column; overflow: hidden;
  }
  .ck-shipping-dropdown.hidden { display: none; }

  .ck-shipping-search-wrap {
    padding: 10px; border-bottom: 1px solid var(--border); background: #f9fafb;
  }
  .ck-shipping-search-input {
    width: 100%; padding: 8px 12px; border: 1.5px solid var(--border);
    border-radius: 6px; font-size: 13px; outline: none;
    color: var(--text); background: var(--white); transition: border-color .2s;
  }
  .ck-shipping-search-input:focus { border-color: var(--primary); }

  .ck-shipping-list { overflow-y: auto; flex: 1; }
  .ck-shipping-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: 11px 16px; cursor: pointer; font-size: 14px;
    transition: background .15s; border-bottom: 1px solid #f3f4f6;
  }
  .ck-shipping-item:last-child { border-bottom: none; }
  .ck-shipping-item:hover { background: #fff0f1; }
  .ck-shipping-item.selected { background: #fff0f1; }
  .ck-shipping-item.selected .ck-shipping-item-name::before {
    content: '✓ '; color: var(--primary); font-weight: 800;
  }
  .ck-shipping-item-name { color: var(--text); font-weight: 500; }
  .ck-shipping-item-price {
    color: var(--primary); font-weight: 700; font-size: 13px;
    background: #fff0f1; padding: 2px 8px; border-radius: 20px;
    border: 1px solid #fecdd3; flex-shrink: 0;
  }
  .ck-shipping-empty  { padding: 20px; text-align: center; color: var(--muted); font-size: 13px; }
  .ck-shipping-loading{ padding: 20px; text-align: center; color: var(--muted); font-size: 13px; }

  /* ── PAYMENT ─────────────────────────────────────────────────────────────── */
  .ck-payment-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
  @media(max-width:480px){ .ck-payment-grid { grid-template-columns: repeat(2, 1fr); } }
  .ck-pay-option { cursor: pointer; }
  .ck-pay-option input[type="radio"] { display: none; }
  .ck-pay-label {
    display: flex; flex-direction: column; align-items: center; gap: 6px;
    padding: 12px 8px; border: 2px solid var(--border);
    border-radius: 8px; transition: all .2s; text-align: center;
  }
  .ck-pay-option input:checked + .ck-pay-label {
    border-color: var(--primary); background: #fff0f0;
  }
  .ck-pay-icon { font-size: 20px; }
  .ck-pay-name { font-size: 11px; font-weight: 600; color: var(--text); }

  /* ── ORDER SUMMARY ───────────────────────────────────────────────────────── */
  .ck-summary { position: sticky; top: 20px; }
  .ck-summary-item {
    display: flex; justify-content: space-between; align-items: flex-start;
    padding: 10px 0; border-bottom: 1px solid #f3f4f6; font-size: 13px;
  }
  .ck-summary-item:last-child { border-bottom: none; }
  .ck-summary-item-name { color: var(--text); max-width: 200px; font-weight: 500; }
  .ck-summary-item-qty {
    color: var(--muted); font-size: 11px; background: #f3f4f6;
    padding: 1px 6px; border-radius: 10px; margin-top: 3px; display: inline-block;
  }
  .ck-summary-item-price { font-weight: 600; color: var(--text); white-space: nowrap; }

  .ck-summary-chips { display: flex; gap: 5px; flex-wrap: wrap; margin-top: 4px; }
  .ck-summary-chip {
    font-size: 10px; font-weight: 600; padding: 1px 7px; border-radius: 10px;
  }
  .ck-summary-chip.color { background: #fff0f1; color: var(--primary); border: 1px solid #fecdd3; }
  .ck-summary-chip.size  { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }

  .ck-totals { margin-top: 16px; }
  .ck-total-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 8px 0; font-size: 13px;
  }
  .ck-total-row.grand {
    font-size: 16px; font-weight: 700; color: var(--primary);
    border-top: 2px solid var(--border); margin-top: 6px; padding-top: 12px;
  }
  .ck-total-row .label { color: var(--muted); }
  .ck-total-row .value { font-weight: 600; }
  .ck-discount-val { color: #16a34a; font-weight: 600; }
  .ck-shipping-val { color: var(--primary); font-weight: 700; }
  .ck-shipping-pending { color: var(--muted); font-size: 12px; font-style: italic; }

  /* ── PLACE ORDER BUTTON ──────────────────────────────────────────────────── */
  .ck-place-btn {
    width: 100%; padding: 15px; margin-top: 16px;
    background: var(--primary); color: #fff;
    border: none; border-radius: 10px; font-size: 15px; font-weight: 700;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;
    transition: all .2s; letter-spacing: .3px;
  }
  .ck-place-btn:hover { background: var(--primary-d); box-shadow: 0 4px 16px rgba(190,3,24,.35); }
  .ck-place-btn:disabled { opacity: .6; cursor: not-allowed; }

  /* ── TRUST BADGES ────────────────────────────────────────────────────────── */
  .ck-trust-row {
    display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;
    margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border);
  }
  .ck-trust-item { display: flex; align-items: center; gap: 5px; font-size: 11px; color: var(--muted); }
  .ck-trust-item i { color: var(--primary); font-size: 13px; }

  /* ── THUMBNAIL ───────────────────────────────────────────────────────────── */
  .ck-summary-thumb {
    width: 44px; height: 44px; object-fit: cover;
    border-radius: 6px; border: 1px solid var(--border); flex-shrink: 0;
  }

  /* ── SPINNER ─────────────────────────────────────────────────────────────── */
  @keyframes spin { to { transform: rotate(360deg); } }
  .ck-spinner {
    display: inline-block; width: 14px; height: 14px;
    border: 2px solid var(--border); border-top-color: var(--primary);
    border-radius: 50%; animation: spin .7s linear infinite; vertical-align: middle;
  }
</style>

@php
  $cart     = session()->get('cart', []);
  $subtotal = 0;
  foreach ($cart as $item) {
      $price     = ($item['discount_price'] ?? null) ?: $item['price'];
      $subtotal += $price * $item['quantity'];
  }
  $discount = (float) session()->get('coupon_discount', 0);
@endphp

<div class="checkout-page">

  {{-- Flash Messages --}}
  <div class="checkout-page__container">
    @if(session('success'))
      <div class="ck-alert ck-alert-success">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="ck-alert ck-alert-error">
        <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
      </div>
    @endif
    @if(session('info'))
      <div class="ck-alert ck-alert-info">
        <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
      </div>
    @endif
  </div>

  {{-- Breadcrumb --}}
  <div class="checkout-page__top-bar">
    <div class="checkout-page__container">
      <nav class="checkout-page__breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span>›</span>
        {{-- ✅ FIX: route('cart') → route('cart.index') --}}
        <a href="{{ route('cart.index') }}">Cart</a>
        <span>›</span>
        <span style="color:var(--text);font-weight:600">Checkout</span>
      </nav>
    </div>
  </div>

  <div class="checkout-page__container">
    <div class="checkout-page__grid">

      {{-- ══════════════════════════════════════════════════════════════════
           LEFT — CHECKOUT FORM
      ══════════════════════════════════════════════════════════════════ --}}
      <div>
        <form method="POST" action="{{ route('checkout.place') }}" id="checkoutForm">
          @csrf

          {{-- ── Customer Information ──────────────────────────────────── --}}
          <div class="ck-card">
            <div class="ck-card-title">
              <i class="fas fa-user"></i> Customer Information
            </div>

            @if($errors->any())
              <div class="ck-alert ck-alert-error" style="margin-bottom:14px">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
              </div>
            @endif

            <div class="ck-form-row">
              <div class="ck-field">
                <label class="ck-label">Full Name <span>*</span></label>
                <input type="text" name="customer_name"
                       class="ck-input @error('customer_name') is-invalid @enderror"
                       placeholder="আপনার পূর্ণ নাম"
                       value="{{ old('customer_name') }}" required>
                @error('customer_name')
                  <div class="ck-error">{{ $message }}</div>
                @enderror
              </div>
              <div class="ck-field">
                <label class="ck-label">Phone Number <span>*</span></label>
                <input type="text" name="phone"
                       class="ck-input @error('phone') is-invalid @enderror"
                       placeholder="01XXXXXXXXX"
                       value="{{ old('phone') }}" required>
                @error('phone')
                  <div class="ck-error">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="ck-form-row full">
              <div class="ck-field">
                <label class="ck-label">Full Address <span>*</span></label>
                <textarea name="address"
                          class="ck-input @error('address') is-invalid @enderror"
                          placeholder="বাড়ি নম্বর, রাস্তা, এলাকা..."
                          rows="2" required>{{ old('address') }}</textarea>
                @error('address')
                  <div class="ck-error">{{ $message }}</div>
                @enderror
              </div>
            </div>

            {{-- ── Delivery Area (custom dropdown) ─────────────────────── --}}
            <div class="ck-form-row full">
              <div class="ck-field">
                <label class="ck-label">Delivery Area <span>*</span></label>

                {{-- Hidden inputs – form submission-এ এগুলো যাবে --}}
                <input type="hidden" name="delivery_area"      id="deliveryAreaValue"
                       value="{{ old('delivery_area') }}">
                <input type="hidden" name="shipping_charge_id" id="shippingChargeId"
                       value="{{ old('shipping_charge_id') }}">

                <div class="ck-shipping-wrap" id="shippingWrap">

                  {{-- Trigger button: current selection দেখায় --}}
                  <button type="button" class="ck-shipping-trigger" id="shippingTrigger"
                          onclick="toggleShippingDropdown()">
                    <div class="ck-shipping-trigger-left">
                      <i class="fas fa-map-marker-alt" style="color:var(--primary);flex-shrink:0"></i>
                      <span class="ck-shipping-trigger-name" id="triggerName">
                        <span class="ck-shipping-trigger-placeholder">লোড হচ্ছে...</span>
                      </span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;flex-shrink:0">
                      <span class="ck-shipping-trigger-fee" id="triggerFee" style="display:none"></span>
                      <i class="fas fa-chevron-down ck-shipping-caret" id="shippingCaret"></i>
                    </div>
                  </button>

                  {{-- Dropdown panel --}}
                  <div class="ck-shipping-dropdown hidden" id="shippingDropdown">
                    <div class="ck-shipping-search-wrap">
                      <input type="text"
                             class="ck-shipping-search-input"
                             id="shippingSearchInput"
                             placeholder="এলাকার নাম লিখুন..."
                             oninput="filterShipping(this.value)"
                             autocomplete="off">
                    </div>
                    <div class="ck-shipping-list" id="shippingList">
                      <div class="ck-shipping-loading">
                        <span class="ck-spinner"></span> লোড হচ্ছে...
                      </div>
                    </div>
                  </div>

                </div>{{-- /ck-shipping-wrap --}}

                @error('delivery_area')
                  <div class="ck-error" id="areaError">{{ $message }}</div>
                @else
                  <div class="ck-error" id="areaError" style="display:none">
                    অনুগ্রহ করে ডেলিভারি এলাকা সিলেক্ট করুন।
                  </div>
                @enderror

              </div>
            </div>

            {{-- ── Order Note ────────────────────────────────────────────── --}}
            <div class="ck-form-row full">
              <div class="ck-field">
                <label class="ck-label">
                  Order Note
                  <small style="font-weight:400;color:var(--muted)">(optional)</small>
                </label>
                <textarea name="note" class="ck-input" rows="2"
                          placeholder="বিশেষ নির্দেশনা থাকলে লিখুন...">{{ old('note') }}</textarea>
              </div>
            </div>
          </div>{{-- /ck-card customer-info --}}

          {{-- ── Payment Method ────────────────────────────────────────── --}}
          <div class="ck-card">
            <div class="ck-card-title">
              <i class="fas fa-credit-card"></i> Payment Method
            </div>
            <div class="ck-payment-grid">
              <label class="ck-pay-option">
                <input type="radio" name="payment_method" value="cod" checked>
                <div class="ck-pay-label">
                  <span class="ck-pay-icon">💵</span>
                  <span class="ck-pay-name">Cash on Delivery</span>
                </div>
              </label>
              <label class="ck-pay-option">
                <input type="radio" name="payment_method" value="bkash">
                <div class="ck-pay-label">
                  <span class="ck-pay-icon">📱</span>
                  <span class="ck-pay-name">bKash</span>
                </div>
              </label>
              <label class="ck-pay-option">
                <input type="radio" name="payment_method" value="shurjopay">
                <div class="ck-pay-label">
                  <span class="ck-pay-icon">💳</span>
                  <span class="ck-pay-name">SurjoPay</span>
                </div>
              </label>
              <label class="ck-pay-option">
                <input type="radio" name="payment_method" value="uddoktapay">
                <div class="ck-pay-label">
                  <span class="ck-pay-icon">🏦</span>
                  <span class="ck-pay-name">UddoktaPay</span>
                </div>
              </label>
              <label class="ck-pay-option">
                <input type="radio" name="payment_method" value="aamarpay">
                <div class="ck-pay-label">
                  <span class="ck-pay-icon">🌐</span>
                  <span class="ck-pay-name">AamarPay</span>
                </div>
              </label>
            </div>
          </div>{{-- /ck-card payment --}}

          {{-- ── Place Order Button ────────────────────────────────────── --}}
          <button type="submit" class="ck-place-btn" id="placeOrderBtn">
            <i class="fas fa-shopping-bag"></i>
            অর্ডার করুন
          </button>

        </form>
      </div>{{-- /left --}}

      {{-- ══════════════════════════════════════════════════════════════════
           RIGHT — ORDER SUMMARY
      ══════════════════════════════════════════════════════════════════ --}}
      <div class="ck-summary">
        <div class="ck-card">
          <div class="ck-card-title">
            <i class="fas fa-shopping-cart"></i> Order Summary
          </div>

          {{-- Cart Items --}}
          @forelse($cart as $productId => $item)
          @php
            $unitPrice = ($item['discount_price'] ?? null) ?: $item['price'];
            $imgPath   = $item['image'] ?? null;
            $selColor  = $item['selected_color'] ?? null;
            $selSize   = $item['selected_size']  ?? null;
          @endphp
          <div class="ck-summary-item">
            <div style="display:flex;gap:10px;align-items:flex-start;flex:1">
              @if($imgPath)
                <img src="{{ asset('uploads/products/' . $imgPath) }}"
                     alt="{{ $item['name'] }}" class="ck-summary-thumb">
              @endif
              <div style="min-width:0">
                <div class="ck-summary-item-name">{{ Str::limit($item['name'], 40) }}</div>
                @if($selColor || $selSize)
                  <div class="ck-summary-chips">
                    @if($selColor)
                      <span class="ck-summary-chip color">🎨 {{ $selColor }}</span>
                    @endif
                    @if($selSize)
                      <span class="ck-summary-chip size">📐 {{ $selSize }}</span>
                    @endif
                  </div>
                @endif
                <div class="ck-summary-item-qty">Qty: {{ $item['quantity'] }}</div>
              </div>
            </div>
            <div class="ck-summary-item-price">
              ৳{{ number_format($unitPrice * $item['quantity'], 2) }}
            </div>
          </div>
          @empty
            <p style="color:var(--muted);font-size:13px;padding:10px 0">কার্টে কোনো পণ্য নেই।</p>
          @endforelse

          {{-- Totals --}}
          <div class="ck-totals">
            <div class="ck-total-row">
              <span class="label">Subtotal</span>
              <span class="value">৳{{ number_format($subtotal, 2) }}</span>
            </div>

            @if($discount > 0)
            <div class="ck-total-row">
              <span class="label">
                Coupon Discount
                @if(session('coupon_code'))
                  <span style="font-size:11px;color:var(--primary);background:#fff0f0;
                               padding:1px 6px;border-radius:10px;margin-left:4px">
                    {{ session('coupon_code') }}
                  </span>
                @endif
              </span>
              <span class="ck-discount-val">−৳{{ number_format($discount, 2) }}</span>
            </div>
            @endif

            <div class="ck-total-row" id="shippingRow">
              <span class="label">Shipping Charge</span>
              <span id="shippingDisplay" class="ck-shipping-pending">এলাকা সিলেক্ট করুন</span>
            </div>

            <div class="ck-total-row grand">
              <span>Total</span>
              <span id="grandTotal">
                ৳{{ number_format($subtotal - $discount, 2) }} + shipping
              </span>
            </div>
          </div>

          {{-- Trust badges --}}
          <div class="ck-trust-row">
            <div class="ck-trust-item"><i class="fas fa-shield-alt"></i> Secure Checkout</div>
            <div class="ck-trust-item"><i class="fas fa-undo"></i> Easy Return</div>
            <div class="ck-trust-item"><i class="fas fa-headset"></i> 24/7 Support</div>
          </div>
        </div>{{-- /ck-card summary --}}

        {{-- ✅ FIX: route('cart') → route('cart.index') --}}
        <div style="text-align:center;margin-top:10px">
          <a href="{{ route('cart.index') }}" style="color:var(--muted);font-size:13px">
            <i class="fas fa-arrow-left"></i> Back to Cart
          </a>
        </div>
      </div>{{-- /right --}}

    </div>{{-- /checkout-page__grid --}}
  </div>{{-- /checkout-page__container --}}
</div>{{-- /checkout-page --}}

<script>
(function () {
  'use strict';

  /* ═══════════════════════════════════════════════════════════
     STATE
  ═══════════════════════════════════════════════════════════ */
  var allAreas     = [];
  var selArea      = null;     /* { id, area_name, amount } */
  var dropdownOpen = false;
  var loaded       = false;

  /* PHP থেকে পাস করা values */
  var SUBTOTAL = {{ (float) $subtotal }};
  var DISCOUNT = {{ (float) $discount }};

  /* ═══════════════════════════════════════════════════════════
     DOM REFS
  ═══════════════════════════════════════════════════════════ */
  var trigger        = document.getElementById('shippingTrigger');
  var dropdown       = document.getElementById('shippingDropdown');
  var triggerName    = document.getElementById('triggerName');
  var triggerFee     = document.getElementById('triggerFee');
  var searchInput    = document.getElementById('shippingSearchInput');
  var listEl         = document.getElementById('shippingList');
  var hiddenArea     = document.getElementById('deliveryAreaValue');
  var hiddenChargeId = document.getElementById('shippingChargeId');
  var shippingDisp   = document.getElementById('shippingDisplay');
  var grandTotalEl   = document.getElementById('grandTotal');
  var areaError      = document.getElementById('areaError');

  /* ═══════════════════════════════════════════════════════════
     LOAD AREAS FROM SERVER
  ═══════════════════════════════════════════════════════════ */
  function loadAreas() {
    fetch('{{ route("shipping.areas") }}', {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function (r) {
      if (!r.ok) throw new Error('Server error: ' + r.status);
      return r.json();
    })
    .then(function (data) {
      allAreas = data;
      loaded   = true;

      /* ─ পুরনো ফর্ম value restore (validation error এর পর) ─ */
      var oldArea     = '{{ old("delivery_area", "") }}';
      var oldChargeId = '{{ old("shipping_charge_id", "") }}';

      if (oldArea && oldChargeId) {
        var found = data.find(function (a) {
          return String(a.id) === String(oldChargeId);
        });
        if (!found) {
          found = data.find(function (a) {
            return a.area_name === oldArea;
          });
        }
        applySelection(found || (data.length ? data[0] : null), false);
      } else if (data.length > 0) {
        /* প্রথমবার লোডে — সবার প্রথম এলাকা auto-select */
        applySelection(data[0], false);
      } else {
        triggerName.innerHTML =
          '<span class="ck-shipping-trigger-placeholder">কোনো এলাকা পাওয়া যায়নি</span>';
        listEl.innerHTML = '<div class="ck-shipping-empty">কোনো এলাকা পাওয়া যায়নি।</div>';
      }

      renderList(data);
    })
    .catch(function (err) {
      console.error('Shipping load error:', err);
      triggerName.innerHTML =
        '<span class="ck-shipping-trigger-placeholder">লোড করা যায়নি</span>';
      listEl.innerHTML =
        '<div class="ck-shipping-empty">লোড করা যায়নি। পেজ রিফ্রেশ করুন।</div>';
    });
  }

  /* ═══════════════════════════════════════════════════════════
     RENDER LIST
  ═══════════════════════════════════════════════════════════ */
  function renderList(areas) {
    if (!areas || !areas.length) {
      listEl.innerHTML = '<div class="ck-shipping-empty">কোনো এলাকা পাওয়া যায়নি।</div>';
      return;
    }
    var html = '';
    areas.forEach(function (area) {
      var isSel = selArea && String(selArea.id) === String(area.id);
      html +=
        '<div class="ck-shipping-item' + (isSel ? ' selected' : '') + '"'
        + ' data-id="'     + area.id + '"'
        + ' data-name="'   + area.area_name.replace(/"/g, '&quot;') + '"'
        + ' data-amount="' + area.amount + '"'
        + ' onclick="selectArea(this)">'
        + '<span class="ck-shipping-item-name">' + area.area_name + '</span>'
        + '<span class="ck-shipping-item-price">৳'
          + parseFloat(area.amount).toFixed(0) + '</span>'
        + '</div>';
    });
    listEl.innerHTML = html;
  }

  /* ═══════════════════════════════════════════════════════════
     FILTER (search input)
  ═══════════════════════════════════════════════════════════ */
  window.filterShipping = function (q) {
    var query    = q.trim().toLowerCase();
    var filtered = allAreas.filter(function (a) {
      return a.area_name.toLowerCase().indexOf(query) !== -1;
    });
    renderList(filtered);
  };

  /* ═══════════════════════════════════════════════════════════
     SELECT AREA (onclick of list item)
  ═══════════════════════════════════════════════════════════ */
  window.selectArea = function (el) {
    applySelection({
      id        : el.dataset.id,
      area_name : el.dataset.name,
      amount    : parseFloat(el.dataset.amount)
    }, true);
    closeDropdown();
  };

  /* ═══════════════════════════════════════════════════════════
     APPLY SELECTION
  ═══════════════════════════════════════════════════════════ */
  function applySelection(area, reRender) {
    if (!area) return;
    selArea = area;

    /* Hidden inputs update */
    hiddenArea.value     = area.area_name;
    hiddenChargeId.value = area.id;

    /* Trigger button update */
    triggerName.innerHTML =
      '<span style="font-weight:600;color:var(--text)">' + area.area_name + '</span>';
    triggerFee.textContent  = '৳' + parseFloat(area.amount).toFixed(0);
    triggerFee.style.display = '';

    /* Summary totals */
    updateTotals(parseFloat(area.amount));

    /* Clear validation error */
    if (areaError) areaError.style.display = 'none';
    trigger.style.borderColor = '';

    /* Re-render list (selected state আপডেট) */
    if (reRender && loaded) renderList(allAreas);
  }

  /* ═══════════════════════════════════════════════════════════
     UPDATE TOTALS
  ═══════════════════════════════════════════════════════════ */
  function updateTotals(shippingAmt) {
    var total = SUBTOTAL - DISCOUNT + shippingAmt;

    shippingDisp.className   = 'ck-shipping-val';
    shippingDisp.textContent = '৳' + shippingAmt.toFixed(2);

    grandTotalEl.textContent = '৳' + total.toLocaleString('en-BD', {
      minimumFractionDigits : 2,
      maximumFractionDigits : 2
    });
    grandTotalEl.style.color = 'var(--primary)';
  }

  /* ═══════════════════════════════════════════════════════════
     DROPDOWN TOGGLE / OPEN / CLOSE
  ═══════════════════════════════════════════════════════════ */
  window.toggleShippingDropdown = function () {
    dropdownOpen ? closeDropdown() : openDropdown();
  };

  function openDropdown() {
    dropdownOpen = true;
    dropdown.classList.remove('hidden');
    trigger.classList.add('open');
    if (loaded) renderList(allAreas);
    setTimeout(function () { searchInput.focus(); }, 60);
  }

  function closeDropdown() {
    dropdownOpen = false;
    dropdown.classList.add('hidden');
    trigger.classList.remove('open');
    searchInput.value = '';
    if (loaded) renderList(allAreas);
  }

  /* Dropdown বাইরে click করলে বন্ধ হবে */
  document.addEventListener('click', function (e) {
    if (!e.target.closest('#shippingWrap')) {
      if (dropdownOpen) closeDropdown();
    }
  });

  /* ═══════════════════════════════════════════════════════════
     FORM SUBMIT GUARD — এলাকা না বেছে submit আটকাবে
  ═══════════════════════════════════════════════════════════ */
  document.getElementById('checkoutForm').addEventListener('submit', function (e) {
    if (!selArea) {
      e.preventDefault();
      trigger.style.borderColor = '#f87171';
      if (areaError) { areaError.style.display = 'block'; }
      trigger.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return;
    }

    /* Submit করার সময় button disable করো (double-submit রোধ) */
    var btn = document.getElementById('placeOrderBtn');
    if (btn) {
      btn.disabled   = true;
      btn.innerHTML  = '<span class="ck-spinner"></span> প্রক্রিয়া হচ্ছে...';
    }
  });

  /* ═══════════════════════════════════════════════════════════
     BOOT
  ═══════════════════════════════════════════════════════════ */
  loadAreas();

})();
</script>
@endsection
