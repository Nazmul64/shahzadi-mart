@extends('frontend.master')

@section('main-content')

@php
  // ── Images ──────────────────────────────────────────────────────────
  $featureImg = $product->feature_image
                ? asset('uploads/products/' . $product->feature_image)
                : asset('images/placeholder.png');

  $gallery = collect($product->gallery_images ?? [])
               ->map(fn($g) => [
                   'url'   => asset('uploads/products/' . (is_array($g) ? $g['image'] : $g)),
                   'color' => is_array($g) ? ($g['color'] ?? null) : null,
                   'size'  => is_array($g) ? ($g['size'] ?? null) : null,
               ])->values();

  $allImages   = collect([['url' => $featureImg, 'color' => null, 'size' => null]])->merge($gallery)->values();
  $totalImages = $allImages->count();

  // ── Pricing ──────────────────────────────────────────────────────────
  $discountPct   = ($product->discount_price && $product->current_price > 0)
                    ? round((($product->current_price - $product->discount_price) / $product->current_price) * 100)
                    : null;
  $displayPrice  = $product->discount_price ?? $product->current_price;
  $originalPrice = $product->discount_price ? $product->current_price : null;

  // ── Tags / Feature Tags ──────────────────────────────────────────────
  $tags        = $product->tags ?? [];
  $featureTags = $product->feature_tags ?? [];

  // ── Stock ────────────────────────────────────────────────────────────
  $inStock    = $product->is_unlimited || ($product->stock ?? 0) > 0;
  $stockLabel = $product->is_unlimited
                  ? 'স্টকে আছে'
                  : ($product->stock > 0 ? $product->stock . ' টি বাকি আছে' : 'স্টক শেষ');

  // ── Category names ───────────────────────────────────────────────────
  $categoryName = $product->category->category_name ?? '';
  $subCatName   = $product->subCategory->sub_name   ?? '';

  // ── URLs / CSRF ──────────────────────────────────────────────────────
  $cartAddUrl     = route('cart.add', $product->id);
  $wishlistAddUrl = route('wishlist.add', $product->id);
  $checkoutUrl    = route('checkout');
  $csrfToken      = csrf_token();

  // ── Contact info ─────────────────────────────────────────────────────
  $contactInfo    = \App\Models\Contactinfomationadmin::first();
  $phoneNumber    = $contactInfo->phone         ?? '';
  $whatsappNumber = $contactInfo->watsapp_url   ?? '';
  $messengerUrl   = $contactInfo->messanger_url ?? '';
  $whatsappText   = urlencode('আমি এই পণ্যটি সম্পর্কে জানতে চাই: ' . $product->name . ' — ' . url()->current());

  // ── Reviews ──────────────────────────────────────────────────────────
  $productReviews = \App\Models\Producreview::where('product_id', $product->id)
                        ->where('is_approved', true)
                        ->with('user')
                        ->latest()
                        ->get();
  $totalRevCount = $productReviews->count();
  $avgRating     = $totalRevCount > 0 ? round($productReviews->avg('rating'), 1) : 0;

  $starCounts = [];
  for ($s = 5; $s >= 1; $s--) {
      $starCounts[$s] = $productReviews->where('rating', $s)->count();
  }

  $reviewStoreUrl = route('review.store', $product->id);
@endphp

{{-- ════════ TOAST CONTAINER ════════ --}}
<div id="pdp-toasts"></div>

{{-- ════════ REVIEW MODAL ════════ --}}
<div class="pdp-rev-modal-overlay" id="pdpRevModal">
  <div class="pdp-rev-modal">
    <div class="pdp-rev-modal-head">
      <span class="pdp-rev-modal-title">রিভিউ লিখুন</span>
      <button class="pdp-rev-modal-close" id="pdpRevModalClose" type="button">
        <i class="fas fa-times"></i>
      </button>
    </div>

    @auth
        <form id="pdpRevForm" action="{{ $reviewStoreUrl }}" method="POST">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <input type="hidden" name="rating" id="pdpRevRatingInput" value="0">
          <label class="pdp-rev-modal-label">আপনার রেটিং *</label>
          <div class="pdp-rev-star-picker" id="pdpRevStarPicker">
            <i class="far fa-star" data-val="1"></i>
            <i class="far fa-star" data-val="2"></i>
            <i class="far fa-star" data-val="3"></i>
            <i class="far fa-star" data-val="4"></i>
            <i class="far fa-star" data-val="5"></i>
          </div>
          <div id="pdpRevRatingErr" style="font-size:11px;color:var(--red);margin-bottom:12px;display:none">
            অনুগ্রহ করে একটি রেটিং দিন।
          </div>
          <label class="pdp-rev-modal-label">আপনার মন্তব্য (ঐচ্ছিক)</label>
          <textarea name="review" placeholder="এই পণ্য সম্পর্কে আপনার মতামত লিখুন..."></textarea>
          <button type="submit" class="pdp-rev-modal-submit" id="pdpRevSubmit">
            <i class="fas fa-paper-plane"></i> রিভিউ জমা দিন
          </button>
        </form>
    @else
      <div class="pdp-rev-login-note">
        <i class="fas fa-lock" style="font-size:28px;color:#d1d5db;display:block;margin-bottom:12px"></i>
        রিভিউ দিতে হলে আগে <a href="{{ url('customer/login') }}">লগইন করুন</a>।
      </div>
    @endauth
  </div>
</div>

<div class="pdp">
  <div class="pdp__wrap">
    @if(session('success'))
      <div class="pdp-alert pdp-alert--success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
  </div>

  <div class="pdp__breadbar">
    <div class="pdp__wrap">
      <nav class="pdp__bread">
        <a href="{{ url('/') }}">হোম</a>
        @if($categoryName) <span class="pdp__bread-sep">›</span> <a href="#">{{ $categoryName }}</a> @endif
        <span class="pdp__bread-sep">›</span> <span class="pdp__bread-cur">{{ Str::limit($product->name, 60) }}</span>
      </nav>
    </div>
  </div>

  <div class="pdp__wrap">
    <div class="pdp__card">
      <div class="pdp__grid">
        <div class="pdp__gallery">
          <div class="pdp__main-wrap" id="pdpMainWrap" style="position: relative;">
            <button class="pdp__wish-btn" id="pdpWishBtn" data-url="{{ $wishlistAddUrl }}"><i class="bi bi-heart"></i></button>
            <img id="pdpMainImg" class="pdp__main-img" src="{{ $featureImg }}" alt="{{ $product->name }}"/>
            <div class="pdp__img-counter"><i class="fas fa-camera"></i> <span id="pdpCounter">1 / {{ $totalImages }}</span></div>
            <div id="pdpZoomLens" class="pdp__zoom-lens"></div>
          </div>
          
          <div id="pdpZoomResult" class="pdp__zoom-result"></div>
          <div class="pdp__thumbs">
            @foreach($allImages as $idx => $img)
              <div class="pdp__thumb {{ $idx === 0 ? 'pdp__thumb--active' : '' }}" data-idx="{{ $idx }}" data-src="{{ $img['url'] }}">
                <img src="{{ $img['url'] }}" alt="ছবি {{ $idx + 1 }}"/>
              </div>
            @endforeach
          </div>
        </div>

        <div class="pdp__info">
          <h1 class="pdp__title">{{ $product->name }}</h1>
          <div class="pdp__meta-row"><span>SKU:</span> <strong>{{ $product->sku ?? 'N/A' }}</strong></div>

          <div class="pdp__price-block">
            <span class="pdp__price-cur">৳{{ round($displayPrice, 2) }}</span>
            @if($originalPrice) <span class="pdp__price-old">৳{{ round($originalPrice, 2) }}</span> @endif
          </div>

          {{-- ── COLORS ── --}}
          @if(isset($productColors) && $productColors->count())
            <div class="pdp__opt-group">
              <label class="pdp__opt-label">রঙ: <span class="pdp__opt-selected" id="pdpColorSel"></span></label>
              <div class="pdp__opt-btns">
                @foreach($productColors as $color)
                  <button class="pdp__opt-btn" data-group="color" data-value="{{ $color->name }}">
                    @if($color->hex_code) <span style="background:{{ $color->hex_code }}; width:12px; height:12px; border-radius:50%; display:inline-block; margin-right:5px; border:1px solid #ddd;"></span> @endif
                    {{ $color->name }}
                  </button>
                @endforeach
              </div>
            </div>
          @endif

          {{-- ── SIZES ── --}}
          @if(isset($productSizes) && $productSizes->count())
            <div class="pdp__opt-group">
              <label class="pdp__opt-label">সাইজ: <span class="pdp__opt-selected" id="pdpSizeSel"></span></label>
              <div class="pdp__opt-btns">
                @foreach($productSizes as $size)
                  <button class="pdp__opt-btn" data-group="size" data-value="{{ $size->name }}">{{ $size->name }}</button>
                @endforeach
              </div>
            </div>
          @endif

          <div class="pdp__qty-group">
            <label class="pdp__opt-label">পরিমাণ:</label>
            <div class="pdp__qty-row">
              <button id="pdpQtyDec" class="pdp__qty-btn">-</button>
              <input type="text" id="pdpQtyInput" value="1" readonly class="pdp__qty-input"/>
              <button id="pdpQtyInc" class="pdp__qty-btn">+</button>
            </div>
          </div>

          <div class="pdp__actions">
            @if(!$inStock)
              <button class="pdp__btn" style="opacity:.5" disabled>স্টক শেষ</button>
            @else
              <button id="pdpAddCart" class="pdp__btn pdp__btn--cart" data-url="{{ $cartAddUrl }}">কার্টে যোগ করুন</button>
              <button id="pdpBuyNow" class="pdp__btn pdp__btn--buy" data-url="{{ $cartAddUrl }}">অর্ডার করুন</button>
            @endif
          </div>

          <div class="pdp__contact-actions">
            <a href="tel:{{ $phoneNumber }}" class="pdp__contact-btn pdp__contact-btn--call"><i class="fas fa-phone-alt"></i> কল করে অর্ডার দিন</a>
            <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappText }}" class="pdp__contact-btn pdp__contact-btn--whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp অর্ডার</a>
          </div>
        </div>
      </div>
    </div>

    {{-- Tabs / Desc / Reviews --}}
    <div class="pdp__tabs">
        <div class="pdp__tab-nav">
            <button class="pdp__tab-btn pdp__tab-btn--active" data-tab="desc">বিবরণ</button>
            <button class="pdp__tab-btn" data-tab="rev">রিভিউ ({{ $totalRevCount }})</button>
        </div>

        {{-- Description Pane --}}
        <div class="pdp__tab-pane pdp__tab-pane--active" id="pane-desc">
            {!! $product->description !!}
        </div>

        {{-- Reviews Pane --}}
        <div class="pdp__tab-pane" id="pane-rev">
            <div class="pdp-rev-sec">
                {{-- Summary --}}
                <div class="pdp-rev-summary">
                    <div class="pdp-rev-avg">
                        <div class="pdp-rev-avg-num">{{ $avgRating }}</div>
                        <div class="pdp-rev-avg-stars">
                            @for($i=1;$i<=5;$i++)
                                <i class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        <div class="pdp-rev-avg-count">{{ $totalRevCount }} টি রিভিউ</div>
                    </div>
                    
                    <div class="pdp-rev-bars">
                        @foreach($starCounts as $stars => $count)
                            @php $pct = $totalRevCount > 0 ? ($count / $totalRevCount) * 100 : 0; @endphp
                            <div class="pdp-rev-bar-row">
                                <span class="pdp-rev-bar-label">{{ $stars }} স্টার</span>
                                <div class="pdp-rev-bar-bg"><div class="pdp-rev-bar-fill" style="width: {{ $pct }}%"></div></div>
                                <span class="pdp-rev-bar-count">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="pdp-rev-action">
                        <button class="pdp-rev-btn" id="pdpWriteRevBtn">
                            <i class="fas fa-edit"></i> রিভিউ লিখুন
                        </button>
                    </div>
                </div>

                {{-- List --}}
                <div class="pdp-rev-list">
                    @forelse($productReviews as $rev)
                        <div class="pdp-rev-item">
                            <div class="pdp-rev-item-head">
                                <div class="pdp-rev-item-user">
                                    <div class="pdp-rev-item-avatar">{{ strtoupper(substr($rev->user->name ?? 'C', 0, 1)) }}</div>
                                    <div>
                                        <div class="pdp-rev-item-name">{{ $rev->user->name ?? 'সম্মানিত ক্রেতা' }}</div>
                                        <div class="pdp-rev-item-date">{{ $rev->created_at->format('d M, Y') }}</div>
                                    </div>
                                </div>
                                <div class="pdp-rev-item-stars">
                                    @for($i=1;$i<=5;$i++)
                                        <i class="bi bi-star{{ $i <= $rev->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="pdp-rev-item-body">
                                {{ $rev->review }}
                            </div>
                        </div>
                    @empty
                        <div class="pdp-rev-empty">
                            <i class="bi bi-chat-left-dots" style="font-size:40px;opacity:.2"></i>
                            <p>এখনো কোনো রিভিউ দেওয়া হয়নি। প্রথম রিভিউটি আপনি দিন!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<style>
/* ... (existing styles) ... */
.pdp__grid { position: relative; }
.pdp__main-img {
    width: 100%;
    height: 500px; /* Fixed height for all main images */
    object-fit: cover; /* Fill the area to remove gaps */
    background-color: #f9fafb; /* Fallback background */
}
.pdp__thumb img {
    width: auto;
    height: 80px; /* Fixed thumbnail height */
    object-fit: cover;
}
.pdp__zoom-lens {
    position: absolute; border: 1px solid #d4d4d4; width: 120px; height: 120px; background: rgba(255, 255, 255, 0.4);
    cursor: crosshair; opacity: 0; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.2); pointer-events: none;
    transition: opacity 0.3s ease;
}
.pdp__zoom-result {
    position: absolute; top: 0; left: calc(100% + 30px); width: 500px; height: 500px; border: 1px solid #e5e7eb;
    background-color: #fff; background-repeat: no-repeat; opacity: 0; visibility: hidden; z-index: 9999; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    transition: opacity 0.3s ease, visibility 0.3s ease;
}
@media (max-width: 991px) {
    .pdp__zoom-result { display: none !important; }
    .pdp__zoom-lens { display: none !important; }
}
.pdp-toast {
    position: fixed; top: 20px; right: 20px; background: #333; color: #fff; padding: 12px 20px;
    border-radius: 8px; z-index: 9999; animation: slideIn .3s ease; display: flex; align-items: center; gap: 10px;
}
@keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }
.pdp-toast.out { opacity: 0; transform: translateY(-20px); transition: all .3s; }
.pdp__opt-btn--active { background: #be0318 !important; color: #fff !important; border-color: #be0318 !important; }

/* ── Reviews UI ── */
.pdp-rev-sec { padding: 10px 0; }
.pdp-rev-summary { display: grid; grid-template-columns: 200px 1fr 200px; gap: 30px; align-items: center; background: #f9fafb; padding: 30px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #f1f5f9; }
@media (max-width: 768px) { .pdp-rev-summary { grid-template-columns: 1fr; gap: 20px; text-align: center; } }
.pdp-rev-avg { text-align: center; border-right: 1px solid #e2e8f0; }
@media (max-width: 768px) { .pdp-rev-avg { border-right: none; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px; } }
.pdp-rev-avg-num { font-size: 48px; font-weight: 800; color: #1e293b; line-height: 1; }
.pdp-rev-avg-stars { color: #f59e0b; margin: 10px 0; font-size: 18px; }
.pdp-rev-avg-count { font-size: 13px; color: #64748b; font-weight: 500; }
.pdp-rev-bar-row { display: flex; align-items: center; gap: 12px; margin-bottom: 6px; }
.pdp-rev-bar-label { font-size: 13px; font-weight: 600; color: #475569; width: 55px; }
.pdp-rev-bar-bg { flex: 1; height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden; }
.pdp-rev-bar-fill { height: 100%; background: #f59e0b; border-radius: 4px; }
.pdp-rev-bar-count { font-size: 13px; color: #64748b; width: 25px; text-align: right; }
.pdp-rev-action { display: flex; justify-content: center; }
.pdp-rev-btn { padding: 12px 24px; background: #1e293b; color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: 14px; cursor: pointer; transition: all .2s; }
.pdp-rev-btn:hover { background: #0f172a; transform: translateY(-2px); }

.pdp-rev-item { padding: 24px 0; border-bottom: 1px solid #f1f5f9; }
.pdp-rev-item-head { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
.pdp-rev-item-user { display: flex; align-items: center; gap: 12px; }
.pdp-rev-item-avatar { width: 44px; height: 44px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #64748b; font-size: 18px; }
.pdp-rev-item-name { font-weight: 700; color: #1e293b; font-size: 15px; }
.pdp-rev-item-date { font-size: 12px; color: #94a3b8; margin-top: 2px; }
.pdp-rev-item-stars { color: #f59e0b; font-size: 13px; }
.pdp-rev-item-body { font-size: 14.5px; color: #475569; line-height: 1.6; white-space: pre-line; }
.pdp-rev-empty { text-align: center; padding: 60px 0; color: #94a3b8; }

/* ── Modal ── */
.pdp-rev-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000000; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: all .3s ease; padding: 20px; }
.pdp-rev-modal-overlay.active { opacity: 1; visibility: visible; }
.pdp-rev-modal { background: #fff; width: 100%; max-width: 500px; border-radius: 20px; overflow: hidden; transform: translateY(20px); transition: all .3s ease; }
.pdp-rev-modal-overlay.active .pdp-rev-modal { transform: translateY(0); }
.pdp-rev-modal-head { padding: 20px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
.pdp-rev-modal-title { font-size: 18px; font-weight: 800; color: #1e293b; }
.pdp-rev-modal-close { border: none; background: none; font-size: 20px; color: #94a3b8; cursor: pointer; }
.pdp-rev-modal form { padding: 24px; }
.pdp-rev-modal-label { display: block; font-size: 14px; font-weight: 700; color: #475569; margin-bottom: 10px; }
.pdp-rev-star-picker { display: flex; gap: 8px; font-size: 32px; color: #cbd5e1; margin-bottom: 24px; }
.pdp-rev-star-picker i { cursor: pointer; transition: color .2s; }
.pdp-rev-star-picker i.active { color: #f59e0b; }
.pdp-rev-modal textarea { width: 100%; height: 120px; padding: 12px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; resize: none; margin-bottom: 20px; }
.pdp-rev-modal-submit { width: 100%; padding: 14px; background: #be0318; color: #fff; border: none; border-radius: 12px; font-weight: 700; font-size: 15px; cursor: pointer; }
.pdp-rev-login-note { padding: 40px 24px; text-align: center; }
.pdp-rev-login-note a { color: #be0318; font-weight: 700; text-decoration: none; }
</style>

<script>
(function() {
    'use strict';
    var CSRF = '{{ $csrfToken }}';
    var selColors = [];
    var selSizes  = [];

    function toast(msg) {
        var el = document.createElement('div');
        el.className = 'pdp-toast';
        el.innerHTML = '<i class="bi bi-check-circle"></i> ' + msg;
        document.body.appendChild(el);
        setTimeout(() => { el.classList.add('out'); setTimeout(() => el.remove(), 400); }, 3000);
    }

    document.querySelectorAll('.pdp__opt-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            var group = this.dataset.group;
            var val   = this.dataset.value;
            var list  = (group === 'color') ? selColors : selSizes;
            var label = (group === 'color') ? 'pdpColorSel' : 'pdpSizeSel';

            if (this.classList.contains('pdp__opt-btn--active')) {
                this.classList.remove('pdp__opt-btn--active');
                var idx = list.indexOf(val);
                if (idx > -1) list.splice(idx, 1);
            } else {
                this.classList.add('pdp__opt-btn--active');
                list.push(val);
                toast((group==='color'?'রঙ':'সাইজ') + ' "' + val + '" সিলেক্ট করা হয়েছে');
            }
            document.getElementById(label).textContent = list.length ? ': ' + list.join(', ') : '';
        });
    });

    function getCartData() {
        var fd = new FormData();
        fd.append('_token', CSRF);
        fd.append('quantity', document.getElementById('pdpQtyInput').value);
        selColors.forEach(c => fd.append('selected_color[]', c));
        selSizes.forEach(s => fd.append('selected_size[]', s));
        return fd;
    }

    function handleCart(url, redirect) {
        fetch(url, { method: 'POST', body: getCartData(), headers: {'X-Requested-With':'XMLHttpRequest'} })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                if (redirect) window.location.href = '{{ $checkoutUrl }}';
                else toast(d.message);
            } else {
                alert(d.message || 'Error adding to cart');
            }
        });
    }

    document.getElementById('pdpAddCart')?.addEventListener('click', function() { handleCart(this.dataset.url, false); });
    document.getElementById('pdpBuyNow')?.addEventListener('click', function() { handleCart(this.dataset.url, true); });

    /* Qty logic */
    var qtyIn = document.getElementById('pdpQtyInput');
    document.getElementById('pdpQtyInc')?.addEventListener('click', () => { qtyIn.value = parseInt(qtyIn.value)+1; });
    document.getElementById('pdpQtyDec')?.addEventListener('click', () => { if(parseInt(qtyIn.value)>1) qtyIn.value = parseInt(qtyIn.value)-1; });

    /* Thumbs logic */
    document.querySelectorAll('.pdp__thumb').forEach(t => {
        t.addEventListener('click', function() {
            document.getElementById('pdpMainImg').src = this.dataset.src;
            document.querySelectorAll('.pdp__thumb').forEach(x => x.classList.remove('pdp__thumb--active'));
            this.classList.add('pdp__thumb--active');
            initZoom(); // re-init zoom with new image
        });
    });

    /* Zoom logic */
    function initZoom() {
        var img = document.getElementById('pdpMainImg');
        var lens = document.getElementById('pdpZoomLens');
        var result = document.getElementById('pdpZoomResult');
        var container = document.getElementById('pdpMainWrap');
        var infoPanel = document.querySelector('.pdp__info'); // The right side text area
        
        // Remove previous listeners if any
        container.onmousemove = null;
        container.onmouseleave = null;
        lens.onmousemove = null;

        var cx, cy;

        // Set background image
        result.style.backgroundImage = "url('" + img.src + "')";

        // We need to wait for image to load to get dimensions
        img.onload = function() {
            setupZoom();
        };
        // If already loaded
        if (img.complete) {
            setupZoom();
        }

        function setupZoom() {
            if (infoPanel && window.innerWidth > 991) {
                var infoRect = infoPanel.getBoundingClientRect();
                var gridRect = document.querySelector('.pdp__grid').getBoundingClientRect();
                
                result.style.width = infoPanel.offsetWidth + "px";
                result.style.height = infoPanel.offsetHeight + "px";
                result.style.left = (infoRect.left - gridRect.left) + "px";
                result.style.top = "0px";
            }

            // Calculate ratio based on NATURAL image dimensions for maximum clarity
            // This ensures 1:1 pixel mapping for crisp zoomed details
            var ratioX = result.offsetWidth / lens.offsetWidth;
            var ratioY = result.offsetHeight / lens.offsetHeight;
            
            // To make it super clear, use natural width if available
            var natW = img.naturalWidth || img.width * 2;
            var natH = img.naturalHeight || img.height * 2;
            
            cx = result.offsetWidth / lens.offsetWidth;
            cy = result.offsetHeight / lens.offsetHeight;

            // Set background size to scale up the image relative to the lens ratio
            result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";

            lens.onmousemove = moveLens;
            container.onmousemove = moveLens;
            container.onmouseleave = hideZoom;
            container.onmouseenter = showZoom;
        }

        function showZoom() {
            if(window.innerWidth > 991) {
                setupZoom(); 
                lens.style.opacity = "1";
                result.style.opacity = "1";
                result.style.visibility = "visible";
                infoPanel.style.opacity = "0"; 
            }
        }
        function hideZoom() {
            lens.style.opacity = "0";
            result.style.opacity = "0";
            setTimeout(() => { if (result.style.opacity === "0") result.style.visibility = "hidden"; }, 300);
            infoPanel.style.opacity = "1"; 
        }

        function moveLens(e) {
            var pos, x, y;
            e.preventDefault();
            pos = getCursorPos(e);
            
            x = pos.x - (lens.offsetWidth / 2);
            y = pos.y - (lens.offsetHeight / 2);

            // Prevent lens from being positioned outside the image
            if (x > img.width - lens.offsetWidth) { x = img.width - lens.offsetWidth; }
            if (x < 0) { x = 0; }
            if (y > img.height - lens.offsetHeight) { y = img.height - lens.offsetHeight; }
            if (y < 0) { y = 0; }

            lens.style.left = x + "px";
            lens.style.top = y + "px";
            
            // Move the background image correctly mapped to the cursor
            result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
        }

        function getCursorPos(e) {
            var a, x = 0, y = 0;
            e = e || window.event;
            a = img.getBoundingClientRect();
            x = e.pageX - a.left;
            y = e.pageY - a.top;
            x = x - window.pageXOffset;
            y = y - window.pageYOffset;
            return {x : x, y : y};
        }
    }
    
    /* Tabs logic */
    document.querySelectorAll('.pdp__tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            var tab = this.dataset.tab;
            document.querySelectorAll('.pdp__tab-btn').forEach(x => x.classList.remove('pdp__tab-btn--active'));
            this.classList.add('pdp__tab-btn--active');
            
            document.querySelectorAll('.pdp__tab-pane').forEach(x => x.classList.remove('pdp__tab-pane--active'));
            document.getElementById('pane-' + tab).classList.add('pdp__tab-pane--active');
        });
    });

    /* Review Modal logic */
    var revModal = document.getElementById('pdpRevModal');
    var revRatingInput = document.getElementById('pdpRevRatingInput');
    var stars = document.querySelectorAll('#pdpRevStarPicker i');

    document.getElementById('pdpWriteRevBtn')?.addEventListener('click', () => {
        revModal.classList.add('active');
    });
    document.getElementById('pdpRevModalClose')?.addEventListener('click', () => {
        revModal.classList.remove('active');
    });
    revModal?.addEventListener('click', (e) => {
        if(e.target === revModal) revModal.classList.remove('active');
    });

    stars.forEach(s => {
        s.addEventListener('mouseover', function() {
            var val = parseInt(this.dataset.val);
            stars.forEach(st => {
                if(parseInt(st.dataset.val) <= val) st.classList.replace('far','fas'), st.classList.add('active');
                else st.classList.replace('fas','far'), st.classList.remove('active');
            });
        });
        s.addEventListener('click', function() {
            var val = parseInt(this.dataset.val);
            revRatingInput.value = val;
            document.getElementById('pdpRevRatingErr').style.display = 'none';
        });
    });

    document.getElementById('pdpRevStarPicker')?.addEventListener('mouseleave', () => {
        var current = parseInt(revRatingInput.value);
        stars.forEach(st => {
            if(parseInt(st.dataset.val) <= current) st.classList.replace('far','fas'), st.classList.add('active');
            else st.classList.replace('fas','far'), st.classList.remove('active');
        });
    });

    document.getElementById('pdpRevForm')?.addEventListener('submit', function(e) {
        if(parseInt(revRatingInput.value) === 0) {
            e.preventDefault();
            document.getElementById('pdpRevRatingErr').style.display = 'block';
        }
    });

    // Initialize zoom on load
    initZoom();
})();
</script>

@endsection
