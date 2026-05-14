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
  $stockLabel = $inStock ? 'স্টক এভেইলেবল' : 'স্টক আউট';

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

  // ── Delivery Information ──
  $deliveryInfo = \App\Models\DeliveryInformation::first();

  // ── YouTube Video ──
  $videoUrl = $product->youtube_url ?? $product->video_url ?? null;
  $embedUrl = null;
  if ($videoUrl) {
      if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoUrl, $match)) {
          $embedUrl = "https://www.youtube.com/embed/" . $match[1];
      }
  }
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
      <div class="pdp__grid {{ !$deliveryInfo ? 'pdp__grid--full' : '' }}">
        <div class="pdp__gallery">
          <div class="pdp__main-wrap" id="pdpMainWrap">
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
          <div class="pdp__meta-row"><span>Availability:</span> <strong style="color: {{ $inStock ? '#16a34a' : 'var(--red)' }}">{{ $stockLabel }}</strong></div>

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
            @if($phoneNumber)
            <a href="tel:{{ $phoneNumber }}" class="pdp__contact-btn pdp__contact-btn--call">
              <i class="fas fa-phone-alt"></i> কল করুন: {{ $phoneNumber }}
            </a>
            @endif

            @php
              // Handle both raw phone number or full URL for WhatsApp
              $waLink = $whatsappNumber;
              if ($whatsappNumber && !str_starts_with($whatsappNumber, 'http')) {
                  $waLink = "https://wa.me/" . preg_replace('/[^\d]/', '', $whatsappNumber) . "?text=" . $whatsappText;
              }
            @endphp

            @if($waLink)
            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="pdp__contact-btn pdp__contact-btn--whatsapp">
              <i class="fab fa-whatsapp"></i> WhatsApp অর্ডার
            </a>
            @endif
@if(isset($deliveryTimeWarning) && $deliveryTimeWarning->warning_text)
    <div class="pdp__delivery-warning">
        {!! nl2br(e($deliveryTimeWarning->warning_text)) !!}
    </div>
    @if(!empty($deliveryTimeWarning->button_text))
        <button class="pdp__btn pdp__btn--warning">{{ $deliveryTimeWarning->button_text }}</button>
    @endif
@endif
          </div>
        </div>

        {{-- ── DELIVERY SIDEBAR ── --}}
        @if($deliveryInfo)
        <div class="pdp__sidebar">
            <div class="pdp__s-card">
                <div class="pdp__card-head">
                    <i class="fas fa-truck-moving me-2" style="color:var(--red)"></i> {{ $deliveryInfo->header_title ?? 'Delivery Information' }}
                </div>
                <div class="pdp__card-body">
                    <div class="pdp__del-row">
                        <div class="pdp__del-icon"><i class="fas fa-home"></i></div>
                        <div>
                            <div class="pdp__del-title">{{ $deliveryInfo->home_delivery_title }}</div>
                            <div class="pdp__del-date">{{ $deliveryInfo->home_delivery_description }}</div>
                        </div>
                    </div>
                    <div class="pdp__del-row">
                        <div class="pdp__del-icon"><i class="fas fa-store"></i></div>
                        <div>
                            <div class="pdp__del-title">{{ $deliveryInfo->pickup_title }}</div>
                            <div class="pdp__del-date">{{ $deliveryInfo->pickup_description }}</div>
                        </div>
                    </div>
                    <div class="pdp__del-row">
                        <div class="pdp__del-icon"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <div class="pdp__del-title">{{ $deliveryInfo->secure_title }}</div>
                            <div class="pdp__del-date">{{ $deliveryInfo->secure_description }}</div>
                        </div>
                    </div>
                    <div class="pdp__del-row">
                        <div class="pdp__del-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div>
                            <div class="pdp__del-title">{{ $deliveryInfo->cod_title }}</div>
                            <div class="pdp__del-date">{{ $deliveryInfo->cod_description }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
      </div>
    </div>

    {{-- Tabs / Desc / Reviews --}}
    <div class="pdp__tabs">
        <div class="pdp__tab-nav">
            <button class="pdp__tab-btn pdp__tab-btn--active" data-tab="desc">বিবরণ</button>
            @if($embedUrl)
                <button class="pdp__tab-btn" data-tab="video">ভিডিও</button>
            @endif
            <button class="pdp__tab-btn" data-tab="rev">রিভিউ ({{ $totalRevCount }})</button>
        </div>

        {{-- Description Pane --}}
        <div class="pdp__tab-pane pdp__tab-pane--active" id="pane-desc">
            {!! $product->description !!}
        </div>

        {{-- Video Pane --}}
        @if($embedUrl)
        <div class="pdp__tab-pane" id="pane-video">
            <div class="pdp-video-wrap">
                <iframe width="100%" height="450" src="{{ $embedUrl }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
        @endif

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

    {{-- Related Products --}}
    @if($relatedProducts->isNotEmpty())
    <div class="pdp__wrap" style="margin-top: 40px;">
        <div class="pdp__related-head">
            <h2 class="pdp__related-title">রিলেটেড প্রোডাক্ট</h2>
            <div class="pdp__related-line"></div>
        </div>
        
        <div class="pdp__related-grid">
            @foreach($relatedProducts as $item)
                @php
                    $displayPrice  = $item->discount_price ?? $item->current_price;
                    $originalPrice = $item->current_price;
                    $discount      = ($item->discount_price && $item->current_price > 0)
                        ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                    $inStock = $item->is_unlimited || ($item->stock ?? 0) > 0;
                @endphp
                <div class="pdp__rel-card" onclick="window.location='{{ route('product.detail', $item->slug) }}'">
                    @if($discount)
                        <span class="pdp__rel-badge">-{{ $discount }}%</span>
                    @endif
                    <div class="pdp__rel-img-wrap">
                        <img src="{{ asset('uploads/products/'.$item->feature_image) }}" alt="{{ $item->name }}" loading="lazy">
                    </div>
                    <div class="pdp__rel-body">
                        <h3 class="pdp__rel-name">{{ $item->name }}</h3>
                        <div class="pdp__rel-price-row">
                            <span class="pdp__rel-price">৳{{ number_format($displayPrice, 0) }}</span>
                            @if($item->discount_price)
                                <span class="pdp__rel-old">৳{{ number_format($originalPrice, 0) }}</span>
                            @endif
                        </div>
                        @if($inStock)
                            <a href="{{ route('product.detail', $item->slug) }}" class="pdp__rel-btn">অর্ডার করুন</a>
                        @else
                            <span class="pdp__rel-btn pdp__rel-btn--out">স্টক নেই</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
  </div>
</div>

<style>
/* ── PDP BASE & GRID ── */
.pdp {
    --primary: {{ $gs->primary_color ?? '#be0318' }};
    --primary-light: {{ ($gs->primary_color ? $gs->primary_color . '15' : '#fff0f1') }};
    background: #f8f9fa;
    padding-bottom: 40px;
}

/* Full Width Override for Desktop */
@if($gs->site_layout_width == 'full-width')
    .main-site-content.container-fluid, .page-wrap {
        padding: 0 !important;
        margin: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
    }
@endif

.pdp__wrap {
    max-width: {{ $gs->site_layout_width == 'full-width' ? '100%' : '1280px' }};
    margin: 0 auto;
    padding: 0 15px;
}

.pdp__card {
    background: #fff;
    border-radius: {{ $gs->site_layout_width == 'full-width' ? '0' : '16px' }};
    box-shadow: {{ $gs->site_layout_width == 'full-width' ? 'none' : '0 4px 20px rgba(0,0,0,0.05)' }};
    overflow: hidden;
    margin-top: {{ $gs->site_layout_width == 'full-width' ? '0' : '20px' }};
}

.pdp__grid {
    display: grid;
    grid-template-columns: 450px 1fr 300px;
    gap: 0;
    align-items: start;
}

.pdp__grid--full {
    grid-template-columns: 450px 1fr !important;
}

/* ── GALLERY ── */
.pdp__gallery {
    padding: 0; /* Removed padding to allow image to fill width */
}

.pdp__main-wrap {
    position: relative;
    overflow: hidden;
    background: #fff;
    /* aspect-ratio removed to allow natural image height if needed, 
       or we can keep it and use cover for a fixed square look */
    aspect-ratio: 1/1; 
    border-bottom: 1px solid #f1f5f9;
}

.pdp__main-img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* This will fill the entire container */
    transition: opacity 0.3s ease;
}

.pdp__main-img.fading { opacity: 0.3; }

.pdp__wish-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 10;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #fff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    color: #94a3b8;
    transition: all 0.2s;
    cursor: pointer;
}

.pdp__wish-btn:hover { color: var(--primary); transform: scale(1.1); }
.pdp__wish-btn.active { color: var(--primary); }

.pdp__img-counter {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background: rgba(0,0,0,0.6);
    color: #fff;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 20px;
    display: flex;
    align-items: center; gap: 6px;
    backdrop-filter: blur(4px);
}

.pdp__thumbs {
    display: flex;
    gap: 10px;
    margin-top: 15px;
    overflow-x: auto;
    padding: 0 15px 10px 15px; /* Added horizontal padding */
    scrollbar-width: none;
}

.pdp__thumbs::-webkit-scrollbar { display: none; }

.pdp__thumb {
    width: 70px;
    height: 70px;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid transparent;
    cursor: pointer;
    flex-shrink: 0;
    transition: all 0.2s;
    background: #f8f9fa;
}

.pdp__thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.pdp__thumb--active {
    border-color: var(--primary);
    box-shadow: 0 0 0 2px var(--primary-light);
}

/* ── INFO SECTION ── */
.pdp__info {
    padding: 30px;
    border-left: 1px solid #f1f5f9;
    border-right: 1px solid #f1f5f9;
}

.pdp__title {
    font-size: 24px;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.3;
    margin-bottom: 15px;
}

.pdp__meta-row {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 20px;
}

.pdp__price-block {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.pdp__price-cur {
    font-size: 32px;
    font-weight: 800;
    color: var(--primary);
}

.pdp__price-old {
    font-size: 18px;
    color: #94a3b8;
    text-decoration: line-through;
}

/* ── OPTIONS & QTY ── */
.pdp__opt-group {
    margin-bottom: 20px;
}

.pdp__opt-label {
    display: block;
    font-size: 14px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 10px;
}

.pdp__opt-btns {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.pdp__opt-btn {
    padding: 8px 16px;
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
    transition: all 0.2s;
}

.pdp__opt-btn:hover { border-color: var(--primary); color: var(--primary); }
.pdp__opt-btn--active {
    background: var(--primary);
    color: #fff !important;
    border-color: var(--primary);
}

.pdp__qty-group {
    margin-bottom: 30px;
}

.pdp__qty-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.pdp__qty-btn {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    background: #f8f9fa;
    font-size: 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}

.pdp__qty-btn:hover { background: #e2e8f0; }

.pdp__qty-input {
    width: 60px;
    height: 40px;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    text-align: center;
    font-size: 16px;
    font-weight: 700;
    outline: none;
}

/* ── ACTIONS ── */
.pdp__actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 12px;
}

.pdp__btn {
    height: 52px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s;
    cursor: pointer;
    border: none;
    width: 100%;
}

.pdp__btn--cart {
    background: #fff;
    color: var(--primary);
    border: 2px solid var(--primary);
}

.pdp__btn--cart:hover { background: var(--primary-light); }

.pdp__btn--buy {
    background: var(--primary);
    color: #fff;
}

.pdp__btn--buy:hover { opacity: 0.9; }

.pdp__contact-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 20px;
}

.pdp__contact-btn {
    height: 52px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none !important;
    transition: all 0.2s;
    width: 100%;
}

.pdp__contact-btn--call { background: #111; color: #fff !important; }
.pdp__contact-btn--whatsapp { background: #25d366; color: #fff !important; }
.pdp__contact-btn:hover { opacity: 0.9; }

/* ── SIDEBAR ── */
.pdp__sidebar {
    padding: 24px;
    background: #fcfcfc;
}

.pdp__s-card {
    border: 1px solid #f1f5f9;
    border-radius: 12px;
    background: #fff;
    overflow: hidden;
}

.pdp__card-head {
    padding: 12px 16px;
    background: #f8f9fa;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    font-weight: 700;
    color: #475569;
}

.pdp__card-body { padding: 15px; }

.pdp__del-row {
    display: flex;
    gap: 12px;
    margin-bottom: 15px;
}

.pdp__del-row:last-child { margin-bottom: 0; }

.pdp__del-icon {
    width: 36px;
    height: 36px;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.pdp__del-title { font-size: 13px; font-weight: 700; color: #1e293b; }
.pdp__del-date { font-size: 12px; color: #64748b; margin-top: 2px; }

/* ── TABS ── */
.pdp__tabs {
    background: #fff;
    margin-top: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
}

.pdp__tab-nav {
    display: flex;
    background: #f8f9fa;
    border-bottom: 1px solid #eee;
}

.pdp__tab-btn {
    flex: 1;
    padding: 16px 20px;
    border: none;
    background: none;
    font-size: 16px;
    font-weight: 700;
    color: #666;
    cursor: pointer;
    position: relative;
    transition: all 0.2s;
}

.pdp__tab-btn--active {
    color: var(--primary);
}

.pdp__tab-btn--active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 15%;
    right: 15%;
    height: 3px;
    background: var(--primary);
}

.pdp__tab-pane {
    padding: 30px;
    display: none;
}

.pdp__tab-pane--active { display: block; }

/* ── REVIEWS UI ── */
.pdp-rev-summary {
    display: grid;
    grid-template-columns: 200px 1fr 200px;
    gap: 30px;
    background: #f8f9fa;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    align-items: center;
}

.pdp-rev-avg { text-align: center; border-right: 1px solid #e2e8f0; }
.pdp-rev-avg-num { font-size: 48px; font-weight: 800; color: #1e293b; line-height: 1; }
.pdp-rev-avg-stars { color: #f59e0b; margin: 10px 0; font-size: 18px; }
.pdp-rev-avg-count { font-size: 13px; color: #64748b; }

.pdp-rev-bar-row { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
.pdp-rev-bar-label { font-size: 13px; font-weight: 600; color: #475569; width: 55px; }
.pdp-rev-bar-bg { flex: 1; height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden; }
.pdp-rev-bar-fill { height: 100%; background: #f59e0b; }
.pdp-rev-bar-count { font-size: 13px; color: #64748b; width: 30px; text-align: right; }

.pdp-rev-btn {
    padding: 12px 20px;
    background: #1e293b;
    color: #fff;
    border-radius: 10px;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    border: none;
}

.pdp-rev-item {
    padding: 20px 0;
    border-bottom: 1px solid #f1f5f9;
}

.pdp-rev-item-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.pdp-rev-item-user { display: flex; align-items: center; gap: 12px; }
.pdp-rev-item-avatar {
    width: 40px;
    height: 40px;
    background: #e2e8f0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    color: #64748b;
}

.pdp-rev-item-name { font-weight: 700; color: #1e293b; font-size: 14px; }
.pdp-rev-item-date { font-size: 12px; color: #94a3b8; }
.pdp-rev-item-stars { color: #f59e0b; font-size: 12px; }
.pdp-rev-item-body { font-size: 14px; color: #475569; line-height: 1.6; }

/* ── ZOOM LENS (Desktop only) ── */
.pdp__zoom-lens {
    position: absolute;
    border: 1px solid #d4d4d4;
    width: 120px;
    height: 120px;
    background: rgba(255, 255, 255, 0.4);
    cursor: crosshair;
    opacity: 0;
    border-radius: 5px;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

.pdp__zoom-result {
    position: absolute;
    top: 0;
    left: calc(100% + 20px);
    width: 500px;
    height: 500px;
    border: 1px solid #e2e8f0;
    background: #fff;
    background-repeat: no-repeat;
    opacity: 0;
    visibility: hidden;
    z-index: 100;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

/* ── VIDEO PLAYER ── */
.pdp-video-wrap {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    height: 0;
    overflow: hidden;
    border-radius: 12px;
    background: #000;
}
.pdp-video-wrap iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

/* ── RELATED PRODUCTS ── */
.pdp__related-head {
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
}
.pdp__related-title {
    font-size: 20px;
    font-weight: 800;
    color: #1e293b;
    white-space: nowrap;
}
.pdp__related-line {
    flex: 1;
    height: 2px;
    background: #e2e8f0;
}
.pdp__related-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 15px;
}
.pdp__rel-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}
.pdp__rel-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    border-color: var(--primary);
}
.pdp__rel-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: var(--primary);
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    padding: 3px 8px;
    border-radius: 6px;
    z-index: 2;
}
.pdp__rel-img-wrap {
    aspect-ratio: 1/1;
    overflow: hidden;
    background: #f8f9fa;
}
.pdp__rel-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.pdp__rel-card:hover .pdp__rel-img-wrap img {
    transform: scale(1.1);
}
.pdp__rel-body {
    padding: 12px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.pdp__rel-name {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
    min-height: 39px;
}
.pdp__rel-price-row {
    margin-bottom: 12px;
    display: flex;
    align-items: baseline;
    gap: 8px;
}
.pdp__rel-price {
    font-size: 16px;
    font-weight: 800;
    color: var(--primary);
}
.pdp__rel-old {
    font-size: 12px;
    color: #94a3b8;
    text-decoration: line-through;
}
.pdp__rel-btn {
    display: block;
    width: 100%;
    padding: 8px;
    background: #f1f5f9;
    color: #475569;
    text-align: center;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
}
.pdp__rel-card:hover .pdp__rel-btn {
    background: var(--primary);
    color: #fff;
}
.pdp__rel-btn--out {
    background: #fee2e2;
    color: #ef4444;
}

@media (max-width: 1200px) { .pdp__related-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 768px) { .pdp__related-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .pdp__related-grid { gap: 10px; } }

/* ── RESPONSIVE STYLES (A-Z) ── */

/* Global Mobile Fixes for Alignment (Extremely Specific) */
@media (max-width: 991px) {
    html, body { overflow-x: hidden !important; width: 100% !important; position: relative; }
    .main-site-content, .page-wrap, .content-area, .content-area-inner { 
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        float: none !important;
        left: 0 !important;
        position: relative !important;
    }
    .sidebar { display: none !important; width: 0 !important; }
}

/* Laptop / Small Desktop */
@media (max-width: 1200px) {
    .pdp__grid { grid-template-columns: 400px 1fr 260px !important; }
}

/* Tablet / Small Laptop */
@media (max-width: 1024px) {
    .pdp__grid { grid-template-columns: 1fr 1fr !important; }
    .pdp__sidebar {
        grid-column: span 2 !important;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .pdp__zoom-result { display: none !important; }
}

/* Medium Tablet & Mobile Grid Force */
@media (max-width: 991px) {
    .pdp__grid { 
        display: block !important; 
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .pdp__gallery, .pdp__info, .pdp__sidebar { 
        width: 100% !important; 
        max-width: 100% !important; 
        display: block !important;
        margin: 0 !important;
        padding: 15px !important;
        border: none !important;
    }
}

/* Mobile Devices (Professional A-Z) */
@media (max-width: 600px) {
    .pdp { padding-bottom: 20px; overflow-x: hidden; width: 100% !important; }
    .pdp__wrap { padding: 0 !important; width: 100% !important; max-width: 100% !important; }
    .pdp__card { border-radius: 0 !important; margin: 0 !important; box-shadow: none !important; border: none !important; width: 100% !important; }
    
    .pdp__gallery { padding: 8px !important; }
    .pdp__main-wrap { border-radius: 0; width: 100% !important; }
    .pdp__thumb { width: 60px; height: 60px; }
    
    .pdp__info { padding: 8px 10px !important; }
    .pdp__title { 
        font-size: 18px !important; 
        margin-bottom: 8px; 
        line-height: 1.3; 
        word-wrap: break-word; 
        overflow-wrap: break-word; 
    }
    .pdp__price-cur { font-size: 22px; }
    
    .pdp__actions, .pdp__contact-actions { gap: 8px; width: 100% !important; padding: 0 8px !important; box-sizing: border-box !important; }
    .pdp__btn, .pdp__contact-btn { height: 46px; font-size: 14px; width: 100% !important; }
    
    .pdp__sidebar { padding: 10px !important; }
    
    .pdp__tab-btn { padding: 10px 8px; font-size: 13px; }
    .pdp-rev-summary {
        display: block !important;
        padding: 10px !important;
    }
    .pdp-rev-avg { border-right: none !important; border-bottom: 1px solid #e2e8f0 !important; padding-bottom: 10px; margin-bottom: 10px; }
}

/* Small Mobile (320px - 375px) */
@media (max-width: 375px) {
    .pdp__title { font-size: 16px !important; }
    .pdp__price-cur { font-size: 22px; }
    .pdp__opt-btn { padding: 6px 8px; font-size: 11px; }
}

/* Delivery Warning Dynamic Style */
.pdp__delivery-warning {
    background: #fff8e1;
    border-left: 4px solid #ffc107;
    padding: 12px 15px;
    margin-top: 15px;
    font-size: 13px;
    color: #856404;
    border-radius: 4px;
    line-height: 1.5;
}

.pdp__btn--warning {
    margin-top: 10px;
    width: 100%;
    background: #ffc107;
    color: #000;
}
</style>

<script>
(function() {
    'use strict';
    var CSRF = '{{ $csrfToken }}';
    var selColors = [];
    var selSizes  = [];


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
                showGlobalToast((group==='color'?'রঙ':'সাইজ') + ' "' + val + '" সিলেক্ট করা হয়েছে');
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
                else showGlobalToast(d.message);
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

    /* Auto Slider Logic */
    var mainImg = document.getElementById('pdpMainImg');
    var thumbs = document.querySelectorAll('.pdp__thumb');
    var counterText = document.getElementById('pdpCounter');
    var currentIndex = 0;
    var autoSlideInterval;

    function showImage(index) {
        if (!thumbs[index]) return;
        var thumb = thumbs[index];
        var src = thumb.dataset.src;
        
        mainImg.classList.add('fading');
        setTimeout(function() {
            mainImg.src = src;
            thumbs.forEach(t => t.classList.remove('pdp__thumb--active'));
            thumb.classList.add('pdp__thumb--active');
            
            if (counterText) {
                counterText.textContent = (index + 1) + ' / ' + thumbs.length;
            }
            
            currentIndex = index;
            initZoom();
            mainImg.classList.remove('fading');
        }, 300);
    }

    function startAutoSlide() {
        if (thumbs.length <= 1) return;
        autoSlideInterval = setInterval(function() {
            currentIndex = (currentIndex + 1) % thumbs.length;
            showImage(currentIndex);
        }, 2000); // 2 seconds
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    if (thumbs.length > 1) {
        startAutoSlide();
        var gallery = document.querySelector('.pdp__gallery');
        if (gallery) {
            gallery.addEventListener('mouseenter', stopAutoSlide);
            gallery.addEventListener('mouseleave', startAutoSlide);
        }
    }
})();
</script>

@push('scripts')
<script>
    // ── Centralized Tracking for Product Details ──
    (function() {
        var productData = {
            id: '{{ $product->id }}',
            name: '{{ addslashes($product->name) }}',
            price: {{ number_format($product->discount_price ?? $product->current_price, 2, '.', '') }},
            category: '{{ addslashes($categoryName) }}',
            sku: '{{ $product->sku ?? "N/A" }}'
        };

        window.dataLayer = window.dataLayer || [];

        // ── ViewContent / view_item on Page Load ──
        if (typeof fbq !== 'undefined') {
            fbq('track', 'ViewContent', {
                content_ids: [productData.id],
                content_name: productData.name,
                content_category: productData.category,
                content_type: 'product',
                value: productData.price,
                currency: 'BDT'
            });
        }

        window.dataLayer.push({
            'event': 'view_item',
            'ecommerce': {
                'currency': 'BDT',
                'value': Number(productData.price),
                'items': [{
                    'item_name': productData.name,
                    'item_id': productData.id,
                    'price': Number(productData.price),
                    'item_category': productData.category,
                    'quantity': 1
                }]
            }
        });

        // ── AddToCart / add_to_cart on Button Click ──
        function trackAddToCart(e) {
            var qtyInput = document.getElementById('pdpQtyInput');
            var qty = qtyInput ? parseInt(qtyInput.value) : 1;
            var totalVal = Number((productData.price * qty).toFixed(2));
            
            if (typeof fbq !== 'undefined') {
                fbq('track', 'AddToCart', {
                    content_ids: [productData.id],
                    content_name: productData.name,
                    content_type: 'product',
                    value: totalVal,
                    currency: 'BDT'
                });
            }

            window.dataLayer.push({
                'event': 'add_to_cart',
                'ecommerce': {
                    'currency': 'BDT',
                    'value': totalVal,
                    'items': [{
                        'item_name': productData.name,
                        'item_id': productData.id,
                        'price': Number(productData.price),
                        'item_category': productData.category,
                        'quantity': Number(qty)
                    }]
                }
            });
        }

        document.addEventListener('click', function(e) {
            if (e.target.closest('#pdpAddCart, #pdpBuyNow')) {
                trackAddToCart(e);
            }
        });
    })();
</script>
@endpush

@endsection
