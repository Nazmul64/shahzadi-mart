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
  .checkout-page input, .checkout-page select, .checkout-page textarea, .checkout-page button {
    font-family: inherit;
  }

  .checkout-page__container { max-width: 1140px; margin: 0 auto; padding: 0 20px; }

  /* TOP BAR */
  .checkout-page__top-bar {
    background: var(--white); border-bottom: 1px solid var(--border);
    padding: 10px 0; font-size: 12px; color: var(--muted);
  }
  .checkout-page__breadcrumb { display: flex; align-items: center; gap: 6px; }
  .checkout-page__breadcrumb a { color: var(--muted); transition: color .2s; }
  .checkout-page__breadcrumb a:hover { color: var(--primary); }

  /* FLASH */
  .ck-alert { border-radius: 8px; padding: 10px 18px; font-size: 13px; font-weight: 600;
    display: flex; align-items: center; gap: 8px; margin: 10px 0; }
  .ck-alert-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
  .ck-alert-error   { background: #fff0f1; color: var(--primary); border: 1px solid #fecdd3; }
  .ck-alert-info    { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }

  /* GRID */
  .checkout-page__grid {
    display: grid; grid-template-columns: 1fr 400px; gap: 24px; margin: 24px 0;
  }
  @media(max-width:900px){ .checkout-page__grid { grid-template-columns: 1fr; } }

  /* CARD */
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

  /* FORM */
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

  /* ── SHIPPING AREA DROPDOWN ── */
  .ck-shipping-wrap { position: relative; }
  .ck-shipping-search {
    padding: 10px 36px 10px 14px;
    border: 1.5px solid var(--border);
    border-radius: 8px; font-size: 14px; color: var(--text);
    background: var(--white); width: 100%; outline: none;
    transition: border-color .2s, box-shadow .2s; cursor: pointer;
  }
  .ck-shipping-search:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(190,3,24,.1); }
  .ck-shipping-icon {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    color: var(--muted); pointer-events: none; font-size: 14px;
  }
  .ck-shipping-dropdown {
    position: absolute; top: calc(100% + 4px); left: 0; right: 0;
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,.12);
    z-index: 100; max-height: 260px; overflow-y: auto;
    display: none;
  }
  .ck-shipping-dropdown.open { display: block; }
  .ck-shipping-search-input {
    width: 100%; padding: 10px 14px;
    border: none; border-bottom: 1px solid var(--border);
    font-size: 13px; outline: none; color: var(--text);
    background: #f9fafb;
  }
  .ck-shipping-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 14px; cursor: pointer; font-size: 14px;
    transition: background .15s;
  }
  .ck-shipping-item:hover { background: #fff0f0; }
  .ck-shipping-item.selected { background: #fff0f0; }
  .ck-shipping-item-name { color: var(--text); font-weight: 500; }
  .ck-shipping-item-price {
    color: var(--primary); font-weight: 700; font-size: 13px;
    background: #fff0f0; padding: 2px 8px; border-radius: 20px;
    border: 1px solid #fecdd3;
  }
  .ck-shipping-empty { padding: 14px; text-align: center; color: var(--muted); font-size: 13px; }
  .ck-shipping-loading { padding: 14px; text-align: center; color: var(--muted); font-size: 13px; }
  .ck-selected-area {
    margin-top: 8px; padding: 10px 14px;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 8px; display: none; align-items: center; gap: 8px;
    font-size: 13px; color: #16a34a; font-weight: 600;
  }
  .ck-selected-area.show { display: flex; }

  /* PAYMENT */
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

  /* ORDER SUMMARY */
  .ck-summary { position: sticky; top: 20px; }
  .ck-summary-item {
    display: flex; justify-content: space-between; align-items: flex-start;
    padding: 10px 0; border-bottom: 1px solid #f3f4f6;
    font-size: 13px;
  }
  .ck-summary-item:last-child { border-bottom: none; }
  .ck-summary-item-name { color: var(--text); max-width: 180px; }
  .ck-summary-item-qty {
    color: var(--muted); font-size: 11px;
    background: #f3f4f6; padding: 1px 6px;
    border-radius: 10px; margin-top: 3px;
  }
  .ck-summary-item-price { font-weight: 600; color: var(--text); white-space: nowrap; }

  .ck-totals { margin-top: 16px; }
  .ck-total-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 8px 0; font-size: 13px;
  }
  .ck-total-row.divider { border-top: 2px dashed var(--border); margin-top: 4px; padding-top: 12px; }
  .ck-total-row.grand {
    font-size: 16px; font-weight: 700; color: var(--primary);
    border-top: 2px solid var(--border); margin-top: 6px; padding-top: 12px;
  }
  .ck-total-row .label { color: var(--muted); }
  .ck-total-row .value { font-weight: 600; }
  .ck-discount-val { color: #16a34a; font-weight: 600; }
  .ck-shipping-val { color: var(--primary); font-weight: 600; }

  /* Shipping pending indicator */
  .ck-shipping-pending {
    color: var(--muted); font-size: 12px; font-style: italic;
  }

  /* PLACE ORDER BTN */
  .ck-place-btn {
    width: 100%; padding: 15px; margin-top: 16px;
    background: var(--primary); color: #fff;
    border: none; border-radius: 10px; font-size: 15px; font-weight: 700;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;
    transition: all .2s; letter-spacing: .3px;
  }
  .ck-place-btn:hover { background: var(--primary-d); box-shadow: 0 4px 16px rgba(190,3,24,.35); }
  .ck-place-btn:disabled { opacity: .6; cursor: not-allowed; }

  /* TRUST BADGES */
  .ck-trust-row {
    display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;
    margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border);
  }
  .ck-trust-item { display: flex; align-items: center; gap: 5px; font-size: 11px; color: var(--muted); }
  .ck-trust-item i { color: var(--primary); font-size: 13px; }

  /* THUMBNAIL in summary */
  .ck-summary-thumb {
    width: 44px; height: 44px; object-fit: cover;
    border-radius: 6px; border: 1px solid var(--border); flex-shrink: 0;
  }

  /* Loading spinner */
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

  {{-- Flash --}}
  <div class="checkout-page__container">
    @if(session('error'))
      <div class="ck-alert ck-alert-error"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
    @endif
    @if(session('info'))
      <div class="ck-alert ck-alert-info"><i class="bi bi-info-circle-fill"></i> {{ session('info') }}</div>
    @endif
  </div>

  {{-- Breadcrumb --}}
  <div class="checkout-page__top-bar">
    <div class="checkout-page__container">
      <nav class="checkout-page__breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span>›</span>
        <a href="{{ route('cart') }}">Cart</a>
        <span>›</span>
        <span style="color:var(--text);font-weight:600">Checkout</span>
      </nav>
    </div>
  </div>

  <div class="checkout-page__container">
    <div class="checkout-page__grid">

      {{-- ── LEFT: FORM ── --}}
      <div>
        <form method="POST" action="{{ route('checkout.place') }}" id="checkoutForm">
          @csrf

          {{-- Customer Info --}}
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
                <input type="text" name="customer_name" class="ck-input @error('customer_name') is-invalid @enderror"
                       placeholder="আপনার পূর্ণ নাম"
                       value="{{ old('customer_name') }}" required>
                @error('customer_name')<div class="ck-error">{{ $message }}</div>@enderror
              </div>
              <div class="ck-field">
                <label class="ck-label">Phone Number <span>*</span></label>
                <input type="text" name="phone" class="ck-input @error('phone') is-invalid @enderror"
                       placeholder="01XXXXXXXXX"
                       value="{{ old('phone') }}" required>
                @error('phone')<div class="ck-error">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="ck-form-row full">
              <div class="ck-field">
                <label class="ck-label">Full Address <span>*</span></label>
                <textarea name="address" class="ck-input @error('address') is-invalid @enderror"
                          placeholder="বাড়ি নম্বর, রাস্তা, এলাকা..."
                          rows="2" required>{{ old('address') }}</textarea>
                @error('address')<div class="ck-error">{{ $message }}</div>@enderror
              </div>
            </div>

            {{-- ── SHIPPING AREA SELECTOR (AJAX) ── --}}
            <div class="ck-form-row full">
              <div class="ck-field">
                <label class="ck-label">Delivery Area <span>*</span></label>

                {{-- Hidden input for actual value submission --}}
                <input type="hidden" name="delivery_area" id="deliveryAreaValue" value="{{ old('delivery_area') }}" required>
                <input type="hidden" name="shipping_charge_id" id="shippingChargeId" value="">

                <div class="ck-shipping-wrap">
                  <input type="text" class="ck-shipping-search" id="shippingDisplayInput"
                         placeholder="এলাকা সার্চ করুন বা ক্লিক করুন..."
                         readonly
                         onclick="openShippingDropdown()"
                         value="{{ old('delivery_area') }}">
                  <i class="fas fa-map-marker-alt ck-shipping-icon"></i>

                  <div class="ck-shipping-dropdown" id="shippingDropdown">
                    <input type="text" class="ck-shipping-search-input" id="shippingSearchInput"
                           placeholder="এলাকার নাম লিখুন..."
                           oninput="filterShipping(this.value)"
                           autocomplete="off">
                    <div id="shippingList">
                      <div class="ck-shipping-loading">
                        <span class="ck-spinner"></span> লোড হচ্ছে...
                      </div>
                    </div>
                  </div>
                </div>

                <div class="ck-selected-area" id="selectedAreaBadge">
                  <i class="fas fa-check-circle"></i>
                  <span id="selectedAreaText"></span>
                </div>

                @error('delivery_area')<div class="ck-error">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="ck-form-row full">
              <div class="ck-field">
                <label class="ck-label">Order Note <small style="font-weight:400;color:var(--muted)">(optional)</small></label>
                <textarea name="note" class="ck-input" rows="2"
                          placeholder="বিশেষ নির্দেশনা থাকলে লিখুন...">{{ old('note') }}</textarea>
              </div>
            </div>
          </div>

          {{-- Payment Method --}}
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
          </div>

          {{-- Place Order Button (inside form) --}}
          <button type="submit" class="ck-place-btn" id="placeOrderBtn">
            <i class="fas fa-shopping-bag"></i>
            অর্ডার করুন
          </button>

        </form>
      </div>

      {{-- ── RIGHT: SUMMARY ── --}}
      <div class="ck-summary">
        <div class="ck-card">
          <div class="ck-card-title">
            <i class="fas fa-shopping-cart"></i> Order Summary
          </div>

          {{-- Cart Items --}}
          @foreach($cart as $productId => $item)
          @php
            $unitPrice = ($item['discount_price'] ?? null) ?: $item['price'];
            $imgPath   = $item['image'] ?? null;
          @endphp
          <div class="ck-summary-item">
            <div style="display:flex;gap:10px;align-items:flex-start;flex:1">
              @if($imgPath)
              <img src="{{ asset('uploads/products/' . $imgPath) }}"
                   alt="{{ $item['name'] }}" class="ck-summary-thumb">
              @endif
              <div>
                <div class="ck-summary-item-name">{{ Str::limit($item['name'], 40) }}</div>
                @if(!empty($item['selected_color']) || !empty($item['selected_size']))
                <div style="font-size:11px;color:var(--muted);margin-top:3px">
                  @if(!empty($item['selected_color']))
                    <span style="background:#f3f4f6;padding:1px 6px;border-radius:4px">
                      🎨 {{ $item['selected_color'] }}
                    </span>
                  @endif
                  @if(!empty($item['selected_size']))
                    <span style="background:#f3f4f6;padding:1px 6px;border-radius:4px;margin-left:4px">
                      📐 {{ $item['selected_size'] }}
                    </span>
                  @endif
                </div>
                @endif
                <div class="ck-summary-item-qty">Qty: {{ $item['quantity'] }}</div>
              </div>
            </div>
            <div class="ck-summary-item-price">৳{{ number_format($unitPrice * $item['quantity'], 2) }}</div>
          </div>
          @endforeach

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
                  <span style="font-size:11px;color:var(--primary);background:#fff0f0;padding:1px 6px;border-radius:10px;margin-left:4px">
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

            <div class="ck-total-row grand" id="grandTotalRow">
              <span>Total</span>
              <span id="grandTotal">
                @if($discount > 0)
                  ৳{{ number_format($subtotal - $discount, 2) }} + shipping
                @else
                  ৳{{ number_format($subtotal, 2) }} + shipping
                @endif
              </span>
            </div>
          </div>

          {{-- Trust badges --}}
          <div class="ck-trust-row">
            <div class="ck-trust-item"><i class="fas fa-shield-alt"></i> Secure Checkout</div>
            <div class="ck-trust-item"><i class="fas fa-undo"></i> Easy Return</div>
            <div class="ck-trust-item"><i class="fas fa-headset"></i> 24/7 Support</div>
          </div>
        </div>

        {{-- Back to cart --}}
        <div style="text-align:center;margin-top:10px">
          <a href="{{ route('cart') }}" style="color:var(--muted);font-size:13px">
            <i class="fas fa-arrow-left"></i> Back to Cart
          </a>
        </div>
      </div>

    </div>{{-- /grid --}}
  </div>{{-- /container --}}
</div>{{-- /checkout-page --}}

<script>
(function () {
  'use strict';

  /* ═══════════════════════════════════════════════════════════════
     STATE
  ═══════════════════════════════════════════════════════════════ */
  var allShippingAreas = [];  // [{id, area_name, amount}, ...]
  var selectedCharge   = null;
  var loaded           = false;

  var SUBTOTAL  = {{ $subtotal }};
  var DISCOUNT  = {{ $discount }};

  /* ─── DOM refs ─── */
  var displayInput    = document.getElementById('shippingDisplayInput');
  var hiddenArea      = document.getElementById('deliveryAreaValue');
  var hiddenChargeId  = document.getElementById('shippingChargeId');
  var dropdown        = document.getElementById('shippingDropdown');
  var searchInput     = document.getElementById('shippingSearchInput');
  var listEl          = document.getElementById('shippingList');
  var selectedBadge   = document.getElementById('selectedAreaBadge');
  var selectedText    = document.getElementById('selectedAreaText');
  var shippingDisplay = document.getElementById('shippingDisplay');
  var grandTotal      = document.getElementById('grandTotal');

  /* ═══════════════════════════════════════════════════════════════
     FETCH shipping areas from server (AJAX)
  ═══════════════════════════════════════════════════════════════ */
  function loadShippingAreas() {
    if (loaded) return;
    listEl.innerHTML = '<div class="ck-shipping-loading"><span class="ck-spinner"></span> লোড হচ্ছে...</div>';

    fetch('{{ route("shipping.areas") }}', {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(r){ return r.json(); })
    .then(function(data) {
      allShippingAreas = data;
      loaded = true;
      renderList(data);
    })
    .catch(function() {
      listEl.innerHTML = '<div class="ck-shipping-empty">লোড করা যায়নি। রিফ্রেশ করুন।</div>';
    });
  }

  /* ═══════════════════════════════════════════════════════════════
     RENDER list items
  ═══════════════════════════════════════════════════════════════ */
  function renderList(areas) {
    if (!areas.length) {
      listEl.innerHTML = '<div class="ck-shipping-empty">কোনো এলাকা পাওয়া যায়নি।</div>';
      return;
    }
    var html = '';
    areas.forEach(function(area) {
      var isSelected = selectedCharge && selectedCharge.id === area.id;
      html += '<div class="ck-shipping-item' + (isSelected ? ' selected' : '') + '"' +
              ' data-id="' + area.id + '"' +
              ' data-name="' + area.area_name.replace(/"/g,'&quot;') + '"' +
              ' data-amount="' + area.amount + '"' +
              ' onclick="selectArea(this)">' +
              '<span class="ck-shipping-item-name">' + area.area_name + '</span>' +
              '<span class="ck-shipping-item-price">৳' + parseFloat(area.amount).toLocaleString('bn-BD', {minimumFractionDigits:0}) + '</span>' +
              '</div>';
    });
    listEl.innerHTML = html;
  }

  /* ═══════════════════════════════════════════════════════════════
     FILTER by search
  ═══════════════════════════════════════════════════════════════ */
  window.filterShipping = function(q) {
    var query = q.trim().toLowerCase();
    var filtered = allShippingAreas.filter(function(a) {
      return a.area_name.toLowerCase().includes(query);
    });
    renderList(filtered);
  };

  /* ═══════════════════════════════════════════════════════════════
     SELECT area
  ═══════════════════════════════════════════════════════════════ */
  window.selectArea = function(el) {
    var id     = el.dataset.id;
    var name   = el.dataset.name;
    var amount = parseFloat(el.dataset.amount);

    selectedCharge = { id: id, area_name: name, amount: amount };

    /* Update form inputs */
    hiddenArea.value     = name;
    hiddenChargeId.value = id;
    displayInput.value   = name;

    /* Update badge */
    selectedText.textContent = name + ' — ৳' + amount.toFixed(2) + ' শিপিং চার্জ';
    selectedBadge.classList.add('show');

    /* Update totals */
    updateTotals(amount);

    /* Close dropdown */
    closeShippingDropdown();
  };

  /* ═══════════════════════════════════════════════════════════════
     UPDATE grand total in sidebar
  ═══════════════════════════════════════════════════════════════ */
  function updateTotals(shippingAmount) {
    var total = SUBTOTAL - DISCOUNT + shippingAmount;

    shippingDisplay.className = 'ck-shipping-val';
    shippingDisplay.textContent = '৳' + shippingAmount.toFixed(2);

    grandTotal.textContent = '৳' + total.toLocaleString('en-BD', {
      minimumFractionDigits: 2, maximumFractionDigits: 2
    });
    grandTotal.style.color = 'var(--primary)';
  }

  /* ═══════════════════════════════════════════════════════════════
     OPEN / CLOSE dropdown
  ═══════════════════════════════════════════════════════════════ */
  window.openShippingDropdown = function() {
    dropdown.classList.add('open');
    loadShippingAreas();
    setTimeout(function(){ searchInput.focus(); }, 80);
  };

  function closeShippingDropdown() {
    dropdown.classList.remove('open');
    searchInput.value = '';
    if (loaded) renderList(allShippingAreas);
  }

  /* Close on outside click */
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.ck-shipping-wrap')) {
      closeShippingDropdown();
    }
  });

  /* ═══════════════════════════════════════════════════════════════
     FORM SUBMIT — validate shipping selected
  ═══════════════════════════════════════════════════════════════ */
  document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    if (!selectedCharge && !hiddenArea.value) {
      e.preventDefault();
      displayInput.style.borderColor = '#f87171';
      displayInput.style.boxShadow   = '0 0 0 3px rgba(248,113,113,.2)';
      displayInput.scrollIntoView({ behavior:'smooth', block:'center' });
      var errEl = displayInput.closest('.ck-field').querySelector('.ck-error');
      if (!errEl) {
        var d = document.createElement('div');
        d.className = 'ck-error';
        d.textContent = 'অনুগ্রহ করে ডেলিভারি এলাকা সিলেক্ট করুন।';
        displayInput.closest('.ck-shipping-wrap').after(d);
      }
    }
  });

  /* Pre-select old value if validation failed and page reloaded */
  @if(old('delivery_area'))
  (function(){
    var oldArea = '{{ old('delivery_area') }}';
    displayInput.value = oldArea;
    hiddenArea.value   = oldArea;
    selectedText.textContent = oldArea;
    selectedBadge.classList.add('show');
    shippingDisplay.textContent = 'পূর্বের নির্বাচন';
  })();
  @endif

})();
</script>
@endsection
