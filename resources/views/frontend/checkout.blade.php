{{-- resources/views/frontend/checkout.blade.php --}}
@extends('frontend.master')

@section('main-content')
<link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/checkout.css">



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

  {{-- ── Flash Messages ── --}}
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

  {{-- ── Breadcrumb ── --}}
  <div class="checkout-page__top-bar">
    <div class="checkout-page__container">
      <nav class="checkout-page__breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span>›</span>
        <a href="{{ route('cart.index') }}">Cart</a>
        <span>›</span>
        <span style="color:var(--text);font-weight:600">Checkout</span>
      </nav>
    </div>
  </div>

  <div class="checkout-page__container">
    <div class="checkout-page__grid">

      {{-- ════ LEFT — FORM ════ --}}
      <div>
        <form method="POST" action="{{ route('checkout.place') }}" id="checkoutForm">
          @csrf

          {{-- ── Customer Information ── --}}
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
              {{-- Name --}}
              <div class="ck-field">
                <label class="ck-label">Full Name <span>*</span></label>
                <input type="text"
                       id="fieldName"
                       name="customer_name"
                       class="ck-input @error('customer_name') is-invalid @enderror"
                       placeholder="আপনার পূর্ণ নাম"
                       value="{{ old('customer_name') }}"
                       required>
                @error('customer_name')
                  <div class="ck-error">{{ $message }}</div>
                @enderror
              </div>

              {{-- Phone — ইনকমপ্লিট অর্ডার এখান থেকে trigger হয় --}}
              <div class="ck-field">
                <label class="ck-label">Phone Number <span>*</span></label>
                <input type="text"
                       id="fieldPhone"
                       name="phone"
                       class="ck-input @error('phone') is-invalid @enderror"
                       placeholder="01XXXXXXXXX"
                       value="{{ old('phone') }}"
                       required
                       autocomplete="tel">
                @error('phone')
                  <div class="ck-error">{{ $message }}</div>
                @enderror
                {{-- Save indicator: phone blur হলে দেখা যাবে --}}
                <div class="ck-save-indicator" id="phoneSaveIndicator">
                  <i class="bi bi-check-circle-fill" id="phoneSaveIcon"></i>
                  <span id="phoneSaveText"></span>
                </div>
              </div>
            </div>

            <div class="ck-form-row full">
              <div class="ck-field">
                <label class="ck-label">Full Address <span>*</span></label>
                <textarea id="fieldAddress"
                          name="address"
                          class="ck-input @error('address') is-invalid @enderror"
                          placeholder="বাড়ি নম্বর, রাস্তা, এলাকা..."
                          rows="2"
                          required>{{ old('address') }}</textarea>
                @error('address')
                  <div class="ck-error">{{ $message }}</div>
                @enderror
              </div>
            </div>

            {{-- ── Delivery Area ── --}}
            <div class="ck-form-row full">
              <div class="ck-field">
                <label class="ck-label">Delivery Area <span>*</span></label>

                <input type="hidden" name="delivery_area"      id="deliveryAreaValue"  value="{{ old('delivery_area') }}">
                <input type="hidden" name="shipping_charge_id" id="shippingChargeId"   value="{{ old('shipping_charge_id') }}">

                <div class="ck-shipping-wrap" id="shippingWrap">
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
                      <i class="fas fa-chevron-down ck-shipping-caret"></i>
                    </div>
                  </button>

                  <div class="ck-shipping-dropdown hidden" id="shippingDropdown">
                    <div class="ck-shipping-search-wrap">
                      <input type="text" class="ck-shipping-search-input"
                             id="shippingSearchInput"
                             placeholder="এলাকার নাম লিখুন..."
                             oninput="filterShipping(this.value)"
                             autocomplete="off">
                    </div>
                    <div class="ck-shipping-list" id="shippingList">
                      <div class="ck-shipping-loading">
                        <i class="fas fa-circle-notch fa-spin"></i> লোড হচ্ছে...
                      </div>
                    </div>
                  </div>
                </div>

                @error('delivery_area')
                  <div class="ck-error" id="areaError">{{ $message }}</div>
                @else
                  <div class="ck-error" id="areaError" style="display:none">
                    অনুগ্রহ করে ডেলিভারি এলাকা সিলেক্ট করুন।
                  </div>
                @enderror
              </div>
            </div>

            {{-- ── Order Note ── --}}
            <div class="ck-form-row full">
              <div class="ck-field">
                <label class="ck-label">
                  Order Note
                  <small style="font-weight:400;color:var(--muted)">(optional)</small>
                </label>
                <textarea id="fieldNote"
                          name="note"
                          class="ck-input" rows="2"
                          placeholder="বিশেষ নির্দেশনা থাকলে লিখুন...">{{ old('note') }}</textarea>
              </div>
            </div>
          </div>{{-- /customer card --}}

          {{-- ── Payment Method ── --}}
          <div class="ck-card">
            <div class="ck-card-title">
              <i class="fas fa-credit-card"></i> Payment Method
            </div>

            <div class="ck-payment-grid">
              <label class="ck-pay-option">
                <input type="radio" name="payment_method" value="cod" id="payCod"
                       checked onchange="onPayMethod(this)">
                <div class="ck-pay-label">
                  <span class="ck-pay-icon" style="font-size:26px;line-height:1">
                    <img src="https://cdn-icons-png.flaticon.com/512/1554/1554406.png"
                         style="height:26px;object-fit:contain"
                         onerror="this.outerHTML='💵'" alt="COD">
                  </span>
                  <span class="ck-pay-name">Cash on Delivery</span>
                  <span class="ck-pay-sub live">সহজ</span>
                </div>
              </label>

              <label class="ck-pay-option pay-bkash">
                <input type="radio" name="payment_method" value="bkash" id="payBkash"
                       onchange="onPayMethod(this)">
                <div class="ck-pay-label">
                  <span class="ck-pay-icon" style="font-size:26px;line-height:1">
                    <img src="{{ asset('frontend/assets/paymentmethodlogo/bkash.png') }}"
                         style="height:50px;object-fit:contain"
                         onerror="this.outerHTML='📱'" alt="bKash">
                  </span>
                  <span class="ck-pay-name" style="color:#E2136E">bKash</span>
                </div>
              </label>

              <label class="ck-pay-option pay-nagad">
                <input type="radio" name="payment_method" value="nagad" id="payNagad"
                       onchange="onPayMethod(this)">
                <div class="ck-pay-label">
                  <span class="ck-pay-icon" style="font-size:26px;line-height:1">
                    <img src="{{ asset('frontend/assets/paymentmethodlogo/nogad.png') }}"
                         style="height:26px;object-fit:contain"
                         onerror="this.outerHTML='💸'" alt="Nagad">
                  </span>
                  <span class="ck-pay-name" style="color:#f12a24">Nagad</span>
                </div>
              </label>

             

              <label class="ck-pay-option pay-shurjo">
                <input type="radio" name="payment_method" value="shurjopay" id="payShurjo"
                       onchange="onPayMethod(this)">
                <div class="ck-pay-label">
                  <span class="ck-pay-icon" style="font-size:26px;line-height:1">
                    <img src="{{ asset('frontend/assets/paymentmethodlogo/surjopya.png') }}"
                         style="height:26px;border-radius:4px;object-fit:contain"
                         onerror="this.outerHTML='☀️'" alt="SurjoPay">
                  </span>
                  <span class="ck-pay-name" style="color:#f97316">SurjoPay</span>
                </div>
              </label>

              <label class="ck-pay-option">
                <input type="radio" name="payment_method" value="uddoktapay"
                       onchange="onPayMethod(this)">
                <div class="ck-pay-label">
                  <span class="ck-pay-icon" style="font-size:26px;line-height:1">
                    <img src="{{ asset('frontend/assets/paymentmethodlogo/uddoktapay.png') }}"
                         style="height:26px;object-fit:contain"
                         onerror="this.outerHTML='🏦'" alt="UddoktaPay">
                  </span>
                  <span class="ck-pay-name">UddoktaPay</span>
                </div>
              </label>

              <label class="ck-pay-option">
                <input type="radio" name="payment_method" value="aamarpay"
                       onchange="onPayMethod(this)">
                <div class="ck-pay-label">
                  <span class="ck-pay-icon" style="font-size:26px;line-height:1">
                    <img src="{{ asset('frontend/assets/paymentmethodlogo/amarpay.png') }}"
                         style="height:26px;object-fit:contain"
                         onerror="this.outerHTML='🌐'" alt="AamarPay">
                  </span>
                  <span class="ck-pay-name">AamarPay</span>
                </div>
              </label>
            </div>

            <div class="ck-gw-bar bkash-bar" id="gwBkash">
              <span style="font-size:18px;flex-shrink:0">📱</span>
              <span>bKash payment page এ redirect হবেন। নম্বর ও PIN দিয়ে পেমেন্ট করুন। শেষে অটো ফিরে আসবেন।</span>
            </div>
            <div class="ck-gw-bar nagad-bar" id="gwNagad" style="display:none; background:#fff1f1; border:1px solid #fecaca; color:#991b1b; padding:10px 14px; border-radius:8px; font-size:12px; margin-top:14px; align-items:center; gap:10px;">
              <span style="font-size:18px;flex-shrink:0">💸</span>
              <span>Nagad পেমেন্ট গেটওয়েতে রিডাইরেক্ট করা হবে। আপনার নম্বর ও ওটিপি দিয়ে পেমেন্ট সম্পন্ন করুন।</span>
            </div>
            <div class="ck-gw-bar shurjo-bar" id="gwShurjo">
              <span style="font-size:18px;flex-shrink:0">☀️</span>
              <span>ShurjoPay gateway এ redirect হবেন। Card, bKash, Nagad সহ সব MFS সাপোর্ট করে।</span>
            </div>
          </div>

          {{-- ── Place Order Button ── --}}
          <button type="submit" class="ck-place-btn" id="placeBtn">
            <i class="fas fa-shopping-bag"></i>
            <span id="placeBtnText">অর্ডার করুন</span>
          </button>

        </form>
      </div>{{-- /left --}}

      {{-- ════ RIGHT — ORDER SUMMARY ════ --}}
      <div class="ck-summary">
        <div class="ck-card">
          <div class="ck-card-title">
            <i class="fas fa-shopping-cart"></i> Order Summary
          </div>

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
                      @if($selColor) <span class="ck-summary-chip color">🎨 {{ $selColor }}</span> @endif
                      @if($selSize)  <span class="ck-summary-chip size">📐 {{ $selSize }}</span>  @endif
                    </div>
                  @endif
                  <div class="ck-summary-item-qty">Qty: {{ $item['quantity'] }}</div>
                </div>
              </div>
              <div class="ck-summary-item-price">
                ৳{{ number_format($unitPrice * $item['quantity'], 0) }}
              </div>
            </div>
          @empty
            <p style="color:var(--muted);font-size:13px;padding:10px 0">কার্টে কোনো পণ্য নেই।</p>
          @endforelse

          <div class="ck-totals">
            <div class="ck-total-row">
              <span class="label">Subtotal</span>
              <span class="value">৳{{ number_format($subtotal, 0) }}</span>
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
                <span class="ck-discount-val">−৳{{ number_format($discount, 0) }}</span>
              </div>
            @endif
            <div class="ck-total-row">
              <span class="label">Shipping Charge</span>
              <span id="shippingDisplay" class="ck-shipping-pending">এলাকা সিলেক্ট করুন</span>
            </div>
            <div class="ck-total-row grand">
              <span>Total</span>
              <span id="grandTotal">৳{{ number_format($subtotal - $discount, 0) }} + shipping</span>
            </div>
          </div>

          <div class="ck-trust-row">
            <div class="ck-trust-item"><i class="fas fa-shield-alt"></i> Secure Checkout</div>
            <div class="ck-trust-item"><i class="fas fa-undo"></i> Easy Return</div>
            <div class="ck-trust-item"><i class="fas fa-headset"></i> 24/7 Support</div>
          </div>
        </div>

        <div style="text-align:center;margin-top:10px">
          <a href="{{ route('cart.index') }}" style="color:var(--muted);font-size:13px">
            <i class="fas fa-arrow-left"></i> Back to Cart
          </a>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
(function () {
  'use strict';

  /* ══════════════════════════════════════════════════════════════
     ROUTES
  ══════════════════════════════════════════════════════════════ */
  var SAVE_URL   = '{{ route("incomplete.save") }}';
  var UPDATE_URL = '{{ route("incomplete.update") }}';
  var CSRF       = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  /* ══════════════════════════════════════════════════════════════
     STATE
  ══════════════════════════════════════════════════════════════ */
  var allAreas      = [];
  var selArea       = null;
  var dropdownOpen  = false;
  var loaded        = false;
  var phoneSaved    = false;   // phone সেভ হয়েছে কিনা
  var updateTimer   = null;

  var SUBTOTAL = {{ (float) $subtotal }};
  var DISCOUNT = {{ (float) $discount }};

  /* ══════════════════════════════════════════════════════════════
     DOM REFS
  ══════════════════════════════════════════════════════════════ */
  var fieldPhone     = document.getElementById('fieldPhone');
  var fieldName      = document.getElementById('fieldName');
  var fieldAddress   = document.getElementById('fieldAddress');
  var fieldNote      = document.getElementById('fieldNote');
  var saveIndicator  = document.getElementById('phoneSaveIndicator');
  var saveIcon       = document.getElementById('phoneSaveIcon');
  var saveText       = document.getElementById('phoneSaveText');
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
  var placeBtn       = document.getElementById('placeBtn');
  var placeBtnText   = document.getElementById('placeBtnText');
  var gwBkash        = document.getElementById('gwBkash');
  var gwShurjo       = document.getElementById('gwShurjo');

  /* ══════════════════════════════════════════════════════════════
     AJAX HELPER
  ══════════════════════════════════════════════════════════════ */
  function ajaxPost(url, data, callback) {
    var body = new FormData();
    body.append('_token', CSRF);
    Object.keys(data).forEach(function (k) {
      if (data[k] !== null && data[k] !== undefined) body.append(k, data[k]);
    });
    fetch(url, { method: 'POST', body: body, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then(function (r) { return r.json(); })
      .then(function (d) { if (callback) callback(null, d); })
      .catch(function (e) { if (callback) callback(e, null); });
  }

  /* ══════════════════════════════════════════════════════════════
     SHOW SAVE INDICATOR
  ══════════════════════════════════════════════════════════════ */
  function showIndicator(type, text) {
    saveIndicator.className = 'ck-save-indicator show' + (type === 'error' ? ' error' : '');
    saveIcon.className      = type === 'error'
      ? 'bi bi-exclamation-circle-fill'
      : 'bi bi-check-circle-fill';
    saveText.textContent    = text;
    // ৩ সেকেন্ড পর hide
    setTimeout(function () {
      saveIndicator.classList.remove('show');
    }, 3000);
  }

  /* ══════════════════════════════════════════════════════════════
     INCOMPLETE ORDER — PHONE BLUR এ TRIGGER

     নিয়ম:
     - phone দেওয়ার আগে কিছুই save হবে না
     - phone blur বা change হলে (min 10 digits) → save call
     - phoneSaved = true হলে অন্য field change হলে → update call
  ══════════════════════════════════════════════════════════════ */
  function getFormData() {
    return {
      phone            : fieldPhone.value.trim(),
      customer_name    : fieldName.value.trim()    || null,
      address          : fieldAddress.value.trim() || null,
      delivery_area    : hiddenArea.value           || null,
      shipping_charge_id: hiddenChargeId.value      || null,
      note             : fieldNote.value.trim()     || null,
      payment_method   : getSelectedPayment(),
    };
  }

  function getSelectedPayment() {
    var radios = document.querySelectorAll('input[name="payment_method"]');
    for (var i = 0; i < radios.length; i++) {
      if (radios[i].checked) return radios[i].value;
    }
    return 'cod';
  }

  function isValidPhone(ph) {
    var digits = ph.replace(/[^\d]/g, '');
    return digits.length >= 10;
  }

  // ── Phone blur/change → first save ─────────────────────────────
  function onPhoneChange() {
    var ph = fieldPhone.value.trim();
    if (!isValidPhone(ph)) return;

    ajaxPost(SAVE_URL, getFormData(), function (err, data) {
      if (!err && data && data.success) {
        phoneSaved = true;
        showIndicator('success', '✓ তথ্য সেভ হয়েছে');
      } else if (!err && data && !data.success) {
        showIndicator('error', 'সেভ হয়নি, আবার চেষ্টা করুন');
      }
    });
  }

  // phone blur
  fieldPhone.addEventListener('blur', function () {
    onPhoneChange();
  });

  // phone input — debounce 800ms (typing এর সময় বারবার call না করতে)
  var phoneDebounce = null;
  fieldPhone.addEventListener('input', function () {
    clearTimeout(phoneDebounce);
    phoneDebounce = setTimeout(function () {
      if (isValidPhone(fieldPhone.value.trim())) onPhoneChange();
    }, 800);
  });

  // ── Other fields change → update (শুধু phone সেভ থাকলে) ────────
  function scheduleUpdate() {
    if (!phoneSaved) return;   // phone না থাকলে update নয়
    clearTimeout(updateTimer);
    updateTimer = setTimeout(function () {
      ajaxPost(UPDATE_URL, getFormData(), null); // silent update
    }, 600);
  }

  fieldName.addEventListener('input',    scheduleUpdate);
  fieldAddress.addEventListener('input', scheduleUpdate);
  fieldNote.addEventListener('input',    scheduleUpdate);

  // payment method change → update
  document.querySelectorAll('input[name="payment_method"]').forEach(function (r) {
    r.addEventListener('change', scheduleUpdate);
  });

  /* ══════════════════════════════════════════════════════════════
     PAYMENT METHOD CHANGE (UI)
  ══════════════════════════════════════════════════════════════ */
  window.onPayMethod = function (radio) {
    var method = radio.value;
    var gwNagad = document.getElementById('gwNagad');
    placeBtn.classList.remove('bkash-btn', 'shurjo-btn', 'nagad-btn');
    gwBkash.classList.remove('show');
    gwShurjo.classList.remove('show');
    if (gwNagad) {
      gwNagad.style.display = 'none';
      gwNagad.classList.remove('show');
    }

    switch (method) {
      case 'cod':
        placeBtnText.textContent = 'অর্ডার করুন';
        break;
      case 'bkash':
        placeBtn.classList.add('bkash-btn');
        placeBtnText.textContent = 'bKash দিয়ে অর্ডার করুন';
        gwBkash.classList.add('show');
        break;
      case 'nagad':
        placeBtn.classList.add('nagad-btn');
        placeBtnText.textContent = 'Nagad দিয়ে অর্ডার করুন';
        var gwNagad = document.getElementById('gwNagad');
        if (gwNagad) {
          gwNagad.style.display = 'flex';
          gwNagad.classList.add('show');
        }
        break;
      case 'shurjopay':
        placeBtn.classList.add('shurjo-btn');
        placeBtnText.textContent = 'ShurjoPay দিয়ে অর্ডার করুন';
        gwShurjo.classList.add('show');
        break;
      default:
        placeBtnText.textContent = method + ' দিয়ে অর্ডার করুন';
    }

    scheduleUpdate();
  };

  /* ══════════════════════════════════════════════════════════════
     LOAD SHIPPING AREAS
  ══════════════════════════════════════════════════════════════ */
  function loadAreas() {
    fetch('{{ route("shipping.areas") }}', {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function (r) { if (!r.ok) throw new Error('status ' + r.status); return r.json(); })
    .then(function (data) {
      allAreas = data; loaded = true;
      var oldArea      = '{{ old("delivery_area", "") }}';
      var oldChargeId  = '{{ old("shipping_charge_id", "") }}';
      if (oldArea && oldChargeId) {
        var found = data.find(function (a) { return String(a.id) === String(oldChargeId); })
                 || data.find(function (a) { return a.area_name === oldArea; });
        applySelection(found || (data.length ? data[0] : null), false);
      } else if (data.length > 0) {
        applySelection(data[0], false);
      } else {
        triggerName.innerHTML = '<span class="ck-shipping-trigger-placeholder">কোনো এলাকা পাওয়া যায়নি</span>';
        listEl.innerHTML = '<div class="ck-shipping-empty">কোনো এলাকা পাওয়া যায়নি।</div>';
      }
      renderList(data);
    })
    .catch(function () {
      triggerName.innerHTML = '<span class="ck-shipping-trigger-placeholder">লোড করা যায়নি</span>';
      listEl.innerHTML = '<div class="ck-shipping-empty">লোড করা যায়নি।</div>';
    });
  }

  function renderList(areas) {
    if (!areas || !areas.length) {
      listEl.innerHTML = '<div class="ck-shipping-empty">কোনো এলাকা পাওয়া যায়নি।</div>';
      return;
    }
    var html = '';
    areas.forEach(function (area) {
      var isSel = selArea && String(selArea.id) === String(area.id);
      html += '<div class="ck-shipping-item' + (isSel ? ' selected' : '') + '"'
            + ' data-id="'     + area.id + '"'
            + ' data-name="'   + area.area_name.replace(/"/g, '&quot;') + '"'
            + ' data-amount="' + area.amount + '"'
            + ' onclick="selectArea(this)">'
            + '<span class="ck-shipping-item-name">' + area.area_name + '</span>'
            + '<span class="ck-shipping-item-price">৳' + parseFloat(area.amount).toFixed(0) + '</span>'
            + '</div>';
    });
    listEl.innerHTML = html;
  }

  window.filterShipping = function (q) {
    var query = q.trim().toLowerCase();
    renderList(allAreas.filter(function (a) {
      return a.area_name.toLowerCase().indexOf(query) !== -1;
    }));
  };

  window.selectArea = function (el) {
    applySelection({
      id        : el.dataset.id,
      area_name : el.dataset.name,
      amount    : parseFloat(el.dataset.amount)
    }, true);
    closeDropdown();
    scheduleUpdate(); // area পরিবর্তন হলে update
  };

  function applySelection(area, reRender) {
    if (!area) return;
    selArea = area;
    hiddenArea.value     = area.area_name;
    hiddenChargeId.value = area.id;
    triggerName.innerHTML = '<span style="font-weight:600;color:var(--text)">' + area.area_name + '</span>';
    triggerFee.textContent   = '৳' + parseFloat(area.amount).toFixed(0);
    triggerFee.style.display = '';
    updateTotals(parseFloat(area.amount));
    if (areaError) areaError.style.display = 'none';
    trigger.style.borderColor = '';
    if (reRender && loaded) renderList(allAreas);
  }

  function updateTotals(ship) {
    var total = SUBTOTAL - DISCOUNT + ship;
    shippingDisp.className   = 'ck-shipping-val';
    shippingDisp.textContent = '৳' + ship.toFixed(2);
    grandTotalEl.textContent = '৳' + total.toLocaleString('en-BD', {
      minimumFractionDigits: 2, maximumFractionDigits: 2
    });
    grandTotalEl.style.color = 'var(--primary)';
  }

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

  document.addEventListener('click', function (e) {
    if (!e.target.closest('#shippingWrap') && dropdownOpen) closeDropdown();
  });

  /* ══════════════════════════════════════════════════════════════
     FORM SUBMIT
  ══════════════════════════════════════════════════════════════ */
  document.getElementById('checkoutForm').addEventListener('submit', function (e) {
    if (!selArea) {
      e.preventDefault();
      trigger.style.borderColor = '#f87171';
      if (areaError) areaError.style.display = 'block';
      trigger.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return;
    }
    placeBtn.disabled  = true;
    placeBtn.innerHTML = '<span class="ck-spinner"></span> প্রক্রিয়া হচ্ছে...';
  });

  /* ══════════════════════════════════════════════════════════════
     BOOT
  ══════════════════════════════════════════════════════════════ */
  loadAreas();

})();
</script>
@push('scripts')
<script>
    // ── Facebook Pixel: InitiateCheckout ──
    if (typeof fbq !== 'undefined') {
        fbq('track', 'InitiateCheckout', {
            content_ids: [@foreach($cart as $item) '{{ $item['id'] ?? $loop->index }}', @endforeach],
            content_type: 'product',
            value: {{ $subtotal }},
            currency: 'BDT'
        });
    }

    // ── Google Tag Manager: BeginCheckout ──
    if (typeof dataLayer !== 'undefined') {
        dataLayer.push({
            'event': 'begin_checkout',
            'ecommerce': {
                'items': [
                    @foreach($cart as $item)
                    {
                        'item_name': '{{ addslashes($item['name']) }}',
                        'item_id': '{{ $item['id'] ?? $loop->index }}',
                        'price': '{{ $item['price'] }}',
                        'quantity': {{ $item['quantity'] }}
                    },
                    @endforeach
                ]
            }
        });
    }
</script>
@endpush
@endsection
