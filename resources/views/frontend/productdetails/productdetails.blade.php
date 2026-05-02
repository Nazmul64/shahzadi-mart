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
          <div class="pdp__main-wrap" id="pdpMainWrap">
            <button class="pdp__wish-btn" id="pdpWishBtn" data-url="{{ $wishlistAddUrl }}"><i class="bi bi-heart"></i></button>
            <img id="pdpMainImg" class="pdp__main-img" src="{{ $featureImg }}" alt="{{ $product->name }}"/>
            <div class="pdp__img-counter"><i class="fas fa-camera"></i> <span id="pdpCounter">1 / {{ $totalImages }}</span></div>
          </div>
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

    {{-- Tabs / Desc --}}
    <div class="pdp__tabs">
        <div class="pdp__tab-nav">
            <button class="pdp__tab-btn pdp__tab-btn--active">বিবরণ</button>
        </div>
        <div class="pdp__tab-pane pdp__tab-pane--active">
            {!! $product->description !!}
        </div>
    </div>
  </div>
</div>

<style>
/* ... (existing styles) ... */
.pdp-toast {
    position: fixed; top: 20px; right: 20px; background: #333; color: #fff; padding: 12px 20px;
    border-radius: 8px; z-index: 9999; animation: slideIn .3s ease; display: flex; align-items: center; gap: 10px;
}
@keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }
.pdp-toast.out { opacity: 0; transform: translateY(-20px); transition: all .3s; }
.pdp__opt-btn--active { background: #be0318 !important; color: #fff !important; border-color: #be0318 !important; }
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
        });
    });
})();
</script>

@endsection
