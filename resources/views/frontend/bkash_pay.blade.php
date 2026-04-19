{{-- resources/views/frontend/bkash_pay.blade.php --}}
{{-- bKash Tokenized Checkout — Popup Page --}}
@extends('frontend.master')

@section('main-content')
<style>
  .bk-wrap {
    min-height: 70vh; display: flex; align-items: center;
    justify-content: center; background: #f9fafb; padding: 40px 20px;
    font-family: 'DM Sans', sans-serif;
  }
  .bk-card {
    background: #fff; border-radius: 16px;
    box-shadow: 0 4px 32px rgba(0,0,0,.1);
    padding: 40px 32px; max-width: 420px; width: 100%; text-align: center;
  }
  .bk-logo { width: 120px; margin-bottom: 20px; }
  .bk-title { font-size: 20px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; }
  .bk-sub { font-size: 14px; color: #6b7280; margin-bottom: 24px; }
  .bk-amount {
    font-size: 32px; font-weight: 800; color: #E2136E;
    margin-bottom: 28px;
  }
  .bk-btn {
    width: 100%; padding: 15px; background: #E2136E; color: #fff;
    border: none; border-radius: 10px; font-size: 16px; font-weight: 700;
    cursor: pointer; transition: all .2s;
  }
  .bk-btn:hover { background: #c0105a; }
  .bk-btn:disabled { opacity: .6; cursor: not-allowed; }
  .bk-cancel {
    display: block; margin-top: 14px; color: #6b7280; font-size: 13px;
    text-decoration: none; transition: color .2s;
  }
  .bk-cancel:hover { color: #1a1a1a; }
  .bk-spinner {
    display: inline-block; width: 16px; height: 16px;
    border: 2px solid rgba(255,255,255,.4); border-top-color: #fff;
    border-radius: 50%; animation: spin .7s linear infinite; vertical-align: middle;
  }
  @keyframes spin { to { transform: rotate(360deg); } }
  .bk-info-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 8px 0; font-size: 13px; border-bottom: 1px solid #f3f4f6;
    text-align: left;
  }
  .bk-info-row:last-child { border-bottom: none; }
  .bk-info-label { color: #6b7280; }
  .bk-info-val { font-weight: 600; color: #1a1a1a; }
  .bk-error {
    background: #fff0f1; color: #be0318; border: 1px solid #fecdd3;
    border-radius: 8px; padding: 10px 16px; font-size: 13px;
    margin-bottom: 16px; display: none;
  }
</style>

@php
  $pending  = session('pending_order');
  $total    = $pending['total'] ?? 0;
@endphp

<div class="bk-wrap">
  <div class="bk-card">
    {{-- bKash Logo --}}
    <img src="https://www.shajgoj.com/wp-content/uploads/2020/01/bkash-logo-png-transparent.png"
         alt="bKash" class="bk-logo"
         onerror="this.style.display='none'">

    <div class="bk-title">bKash দিয়ে পেমেন্ট করুন</div>
    <div class="bk-sub">নিচের বাটনে ক্লিক করুন এবং bKash পেমেন্ট সম্পন্ন করুন</div>

    <div class="bk-amount">৳{{ number_format($total, 2) }}</div>

    {{-- Order info --}}
    <div style="margin-bottom: 24px;">
      <div class="bk-info-row">
        <span class="bk-info-label">নাম</span>
        <span class="bk-info-val">{{ $pending['customer_name'] ?? '—' }}</span>
      </div>
      <div class="bk-info-row">
        <span class="bk-info-label">ফোন</span>
        <span class="bk-info-val">{{ $pending['phone'] ?? '—' }}</span>
      </div>
      <div class="bk-info-row">
        <span class="bk-info-label">ডেলিভারি এলাকা</span>
        <span class="bk-info-val">{{ $pending['delivery_area'] ?? '—' }}</span>
      </div>
    </div>

    <div class="bk-error" id="bkError"></div>

    <button class="bk-btn" id="bkPayBtn" onclick="startBkashPayment()">
      <svg style="width:20px;height:20px;vertical-align:middle;margin-right:6px" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
      bKash পেমেন্ট করুন
    </button>

    <a href="{{ route('checkout.index') }}" class="bk-cancel">← চেকআউটে ফিরে যান</a>
  </div>
</div>

{{-- bKash Script --}}
<script src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>

<script>
(function () {
  'use strict';

  var CSRF   = '{{ csrf_token() }}';
  var CREATE = '{{ route("bkash.create") }}';

  var paymentID = null;

  window.startBkashPayment = function () {
    var btn = document.getElementById('bkPayBtn');
    btn.disabled   = true;
    btn.innerHTML  = '<span class="bk-spinner"></span> প্রক্রিয়া হচ্ছে...';
    hideError();

    bKash.init({
      paymentMode : 'checkout',
      paymentRequest : {},

      // ── Step 1: create payment on your backend ──────────────────
      createRequest : function (data) {
        fetch(CREATE, {
          method  : 'POST',
          headers : {
            'Content-Type'     : 'application/json',
            'X-CSRF-TOKEN'     : CSRF,
            'X-Requested-With' : 'XMLHttpRequest',
          },
          body : JSON.stringify({}),
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (res.bkashURL && res.paymentID) {
            paymentID = res.paymentID;
            bKash.create().onSuccess(res);
          } else {
            bKash.create().onError();
            showError(res.error || 'Payment create করতে সমস্যা হয়েছে।');
            resetBtn();
          }
        })
        .catch(function () {
          bKash.create().onError();
          showError('Network error. আবার চেষ্টা করুন।');
          resetBtn();
        });
      },

      // ── Step 2: execute payment ─────────────────────────────────
      executeRequestOnAuthorization : function () {
        // After bKash popup completes, bKash redirects to callback URL automatically
        // (callbackURL is set server-side in createPayment)
        // Nothing needed here for URL-based checkout (mode 0011)
      },

      onClose : function () {
        resetBtn();
      }
    });

    bKash.create().onSuccess = function () {};
  };

  function resetBtn() {
    var btn = document.getElementById('bkPayBtn');
    btn.disabled  = false;
    btn.innerHTML = '<svg style="width:20px;height:20px;vertical-align:middle;margin-right:6px" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>bKash পেমেন্ট করুন';
  }

  function showError(msg) {
    var el = document.getElementById('bkError');
    el.textContent = msg;
    el.style.display = 'block';
  }

  function hideError() {
    document.getElementById('bkError').style.display = 'none';
  }
})();
</script>
@endsection
