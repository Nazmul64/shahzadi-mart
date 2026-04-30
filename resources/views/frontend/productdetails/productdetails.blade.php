@extends('frontend.master')

@section('main-content')

@php
  $featureImg = $product->feature_image
                ? asset('uploads/products/' . $product->feature_image)
                : asset('images/placeholder.png');
  $gallery = collect($product->gallery_images ?? [])
               ->map(fn($g) => [
                   'url'   => asset('uploads/products/' . (is_array($g) ? $g['image'] : $g)),
                   'color' => is_array($g) ? ($g['color'] ?? null) : null,
                   'size'  => is_array($g) ? ($g['size'] ?? null) : null,
               ])->values();
  $allImages   = collect([['url' => $featureImg]])->merge($gallery)->values();
  $totalImages = $allImages->count();

  $discountPct   = ($product->discount_price && $product->current_price > 0)
                    ? round((($product->current_price - $product->discount_price) / $product->current_price) * 100)
                    : null;
  $displayPrice  = $product->discount_price ?? $product->current_price;
  $originalPrice = $product->discount_price ? $product->current_price : null;

  $variants = collect($product->variants ?? []);
  $colors   = $variants->pluck('color')->filter()->unique()->values();
  $sizes    = $variants->pluck('size')->filter()->unique()->values();

  $tags        = $product->tags ?? [];
  $featureTags = $product->feature_tags ?? [];

  $inStock    = $product->is_unlimited || ($product->stock ?? 0) > 0;
  $stockLabel = $product->is_unlimited
                  ? 'স্টকে আছে'
                  : ($product->stock > 0 ? $product->stock . ' টি বাকি আছে' : 'স্টক শেষ');

  $categoryName = $product->category->category_name ?? '';
  $subCatName   = $product->subCategory->sub_name ?? '';
  $shareUrl     = url()->current();
  $shareTitle   = urlencode($product->name);

  preg_match('/(?:v=|youtu\.be\/|embed\/)([a-zA-Z0-9_-]{11})/', $product->youtube_url ?? '', $ytMatch);
  $ytId = $ytMatch[1] ?? null;

  $cartAddUrl     = route('cart.add', $product->id);
  $wishlistAddUrl = route('wishlist.add', $product->id);
  $checkoutUrl    = route('checkout');
  $csrfToken      = csrf_token();

  // ── Contact info from admin settings ──
  $contactInfo    = \App\Models\Contactinfomationadmin::first();
  $phoneNumber    = $contactInfo->phone         ?? '';
  $whatsappNumber = $contactInfo->watsapp_url   ?? '';
  $messengerUrl   = $contactInfo->messanger_url ?? '';
  $whatsappText   = urlencode('আমি এই পণ্যটি সম্পর্কে জানতে চাই: ' . $product->name . ' — ' . url()->current());

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

  $userReview      = null;
  $alreadyReviewed = false;
  if (auth()->check()) {
      $userReview      = \App\Models\Producreview::where('product_id', $product->id)->where('user_id', auth()->id())->first();
      $alreadyReviewed = (bool) $userReview;
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
      <button class="pdp-rev-modal-close" id="pdpRevModalClose" type="button"><i class="fas fa-times"></i></button>
    </div>
    @auth
      @if($alreadyReviewed)
        <div style="text-align:center;padding:20px 0">
          <i class="fas fa-check-circle" style="font-size:36px;color:#16a34a;display:block;margin-bottom:12px"></i>
          <p style="font-size:14px;color:#374151;font-weight:600">আপনি ইতোমধ্যে এই পণ্যটি রিভিউ করেছেন।</p>
          <p style="font-size:12px;color:var(--muted);margin-top:6px">রেটিং: {{ $userReview->rating }}/5 — "{{ Str::limit($userReview->review, 60) }}"</p>
        </div>
      @else
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
      @endif
    @else
      <div class="pdp-rev-login-note">
        <i class="fas fa-lock" style="font-size:28px;color:#d1d5db;display:block;margin-bottom:12px"></i>
        রিভিউ দিতে হলে আগে <a href="{{ url('customer/login') }}">লগইন করুন</a>।
      </div>
    @endauth
  </div>
</div>

{{-- ════════ MAIN PDP ════════ --}}
<div class="pdp">
  <div class="pdp__wrap">
    @if(session('success'))<div class="pdp-alert pdp-alert--success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>@endif
    @if(session('info'))<div class="pdp-alert pdp-alert--info"><i class="bi bi-info-circle-fill"></i> {{ session('info') }}</div>@endif
    @if(session('error'))<div class="pdp-alert pdp-alert--error"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>@endif
  </div>

  {{-- Breadcrumb --}}
  <div class="pdp__breadbar">
    <div class="pdp__wrap">
      <nav class="pdp__bread">
        <a href="{{ url('/') }}">হোম</a>
        @if($categoryName)<span class="pdp__bread-sep">›</span><a href="#">{{ $categoryName }}</a>@endif
        @if($subCatName)<span class="pdp__bread-sep">›</span><a href="#">{{ $subCatName }}</a>@endif
        <span class="pdp__bread-sep">›</span>
        <span class="pdp__bread-cur">{{ Str::limit($product->name, 60) }}</span>
      </nav>
    </div>
  </div>

  <div class="pdp__wrap">
    <div class="pdp__card">
      <div class="pdp__grid">

        {{-- ── Gallery Column ── --}}
        <div class="pdp__gallery">
          <div class="pdp__main-wrap" id="pdpMainWrap">
            <button class="pdp__wish-btn" id="pdpWishBtn" data-url="{{ $wishlistAddUrl }}" title="উইশলিস্টে যোগ করুন">
              <i class="bi bi-heart"></i>
            </button>
            @if($product->vendor)
              <div class="pdp__badge-row">
                <span class="pdp__badge pdp__badge--vendor">{{ $product->vendor }}</span>
              </div>
            @endif
            <img id="pdpMainImg" class="pdp__main-img" src="{{ $featureImg }}" alt="{{ $product->name }}"/>
            <div class="pdp__zoom-hint"><i class="fas fa-search-plus" style="font-size:10px"></i> বড় করে দেখুন</div>
            <div class="pdp__img-counter">
              <i class="fas fa-camera"></i>
              <span id="pdpCounter">1 / {{ $totalImages }}</span>
            </div>
            <div class="pdp__img-popup">
              <div class="pdp__popup-title">{{ $product->name }}</div>
              <div class="pdp__popup-meta">
                <span class="pdp__popup-price">৳{{ number_format($displayPrice, 2) }}</span>
                @if($originalPrice)<span class="pdp__popup-old">৳{{ number_format($originalPrice, 2) }}</span>@endif
                @if($discountPct)<span class="pdp__popup-chip">−{{ $discountPct }}%</span>@endif
              </div>
              <div class="pdp__popup-stock"><i class="fas fa-fire"></i> {{ $stockLabel }}</div>
              <hr class="pdp__popup-hr"/>
              <div class="pdp__popup-meta2">
                <span><i class="fas fa-tag"></i> SKU: {{ $product->sku ?? 'N/A' }}</span>
                @if($product->return_policy)<span><i class="fas fa-undo"></i> রিটার্ন পলিসি</span>@endif
              </div>
            </div>
          </div>

          {{-- Thumbnails --}}
          <div class="pdp__thumbs" id="pdpThumbs">
            @foreach($allImages as $idx => $img)
              <div class="pdp__thumb {{ $idx === 0 ? 'pdp__thumb--active' : '' }}"
                   data-idx="{{ $idx }}" data-src="{{ $img['url'] }}">
                <img src="{{ $img['url'] }}" alt="ছবি {{ $idx + 1 }}" loading="lazy"/>
              </div>
            @endforeach
          </div>

          {{-- Share --}}
          <div class="pdp__share">
            <span class="pdp__share-label">শেয়ার করুন:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" class="pdp__soc-btn pdp__soc--fb"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.linkedin.com/shareArticle?url={{ $shareUrl }}&title={{ $shareTitle }}" target="_blank" rel="noopener" class="pdp__soc-btn pdp__soc--li"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener" class="pdp__soc-btn pdp__soc--tw"><i class="fab fa-twitter"></i></a>
            <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener" class="pdp__soc-btn pdp__soc--wa"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>

        {{-- ── Info Column ── --}}
        <div class="pdp__info">

          {{-- Feature Tags --}}
          @if(!empty($featureTags))
            <div class="pdp__feature-tags">
              @foreach($featureTags as $ft)
                <span class="pdp__feature-tag" style="background:{{ $ft['color'] ?? '#be0318' }};color:#fff">
                  {{ $ft['keyword'] }}
                </span>
              @endforeach
            </div>
          @endif

          <h1 class="pdp__title">{{ $product->name }}</h1>

          <div class="pdp__meta-row">
            <span class="pdp__meta-muted">SKU:</span>
            <strong>{{ $product->sku ?? 'N/A' }}</strong>
            @if($product->vendor)
              <span style="color:var(--border)">|</span>
              <span class="pdp__meta-muted">বিক্রেতা:</span>
              <strong>{{ $product->vendor }}</strong>
            @endif
          </div>

          {{-- Ratings summary --}}
          @if($totalRevCount > 0)
            <div class="pdp__meta-row" style="margin-bottom:14px">
              @for($s=1; $s<=5; $s++)
                <i class="bi bi-star{{ $s <= round($avgRating) ? '-fill' : '' }}"
                   style="font-size:13px;color:{{ $s <= round($avgRating) ? '#f59e0b' : '#d1d5db' }}"></i>
              @endfor
              <span style="font-size:13px;font-weight:700;color:var(--text)">{{ $avgRating }}</span>
              <a href="#" onclick="pdpTab('reviews');return false;"
                 style="font-size:12px;color:var(--muted);text-decoration:underline">
                ({{ $totalRevCount }} টি রিভিউ)
              </a>
            </div>
          @endif

          {{-- Viewers --}}
          <div class="pdp__viewers">
            <i class="fas fa-eye"></i>
            <span><span class="pdp__viewers-n" id="pdpViewers">61</span> জন এখন দেখছেন</span>
          </div>

          {{-- Price Block --}}
          <div class="pdp__price-block">
            <div class="pdp__price-row">
              <span class="pdp__price-cur">৳{{ round($displayPrice, 2) }}</span>
              @if($originalPrice)
                <span class="pdp__price-old">৳{{ round($originalPrice, 2) }}</span>
              @endif
              @if($discountPct)
                <span class="pdp__price-chip">−{{ $discountPct }}%</span>
              @endif
            </div>
          </div>

          {{-- Color Options --}}
          @if($colors->count())
            <div class="pdp__opt-group">
              <label class="pdp__opt-label">
                রঙ: <span class="pdp__opt-tag">ঐচ্ছিক</span>
                <span class="pdp__opt-selected" id="pdpColorSel" style="display:none"></span>
              </label>
              <div class="pdp__opt-btns">
                @foreach($colors as $color)
                  <button class="pdp__opt-btn" data-group="color" data-value="{{ $color }}">{{ $color }}</button>
                @endforeach
              </div>
            </div>
          @endif

          {{-- Size Options --}}
          @if($sizes->count())
            <div class="pdp__opt-group">
              <label class="pdp__opt-label">
                সাইজ: <span class="pdp__opt-tag">ঐচ্ছিক</span>
                <span class="pdp__opt-selected" id="pdpSizeSel" style="display:none"></span>
              </label>
              <div class="pdp__opt-btns">
                @foreach($sizes as $size)
                  <button class="pdp__opt-btn" data-group="size" data-value="{{ $size }}">{{ $size }}</button>
                @endforeach
              </div>
            </div>
          @endif

          {{-- Quantity --}}
          <div class="pdp__qty-group">
            <label class="pdp__opt-label">পরিমাণ:</label>
            <div class="pdp__qty-row">
              <div class="pdp__qty-sel">
                <button class="pdp__qty-btn" id="pdpQtyDec" type="button"><i class="fas fa-minus"></i></button>
                <input type="text" class="pdp__qty-input" id="pdpQtyInput" value="1" readonly/>
                <button class="pdp__qty-btn" id="pdpQtyInc" type="button"><i class="fas fa-plus"></i></button>
              </div>
            </div>
          </div>

          {{-- ════ Cart / Buy Buttons ════ --}}
          <div class="pdp__actions" style="display:flex;gap:10px;flex-wrap:nowrap;">
            @if(!$inStock)
              <span class="pdp__btn pdp__btn--cart"
                    style="opacity:.5;cursor:not-allowed;white-space:nowrap;flex:1;justify-content:center;">
                <i class="fas fa-times-circle"></i> স্টক শেষ
              </span>
            @else
              <button type="button" class="pdp__btn pdp__btn--cart" id="pdpAddCart"
                      data-url="{{ $cartAddUrl }}"
                      style="white-space:nowrap;flex:1;justify-content:center;">
                <i class="fas fa-shopping-cart"></i> কার্টে যোগ করুন
              </button>
              <button type="button" class="pdp__btn pdp__btn--buy" id="pdpBuyNow"
                      data-url="{{ $cartAddUrl }}" data-checkout="{{ $checkoutUrl }}"
                      style="white-space:nowrap;flex:1;justify-content:center;">
                <i class="fas fa-shopping-bag"></i> এখনই কিনুন
              </button>
            @endif
          </div>

          {{-- ════ Contact / Order Buttons ════ --}}
          {{-- Data pulled from Contactinfomationadmin model --}}
          <div class="pdp__contact-actions">

            @if($phoneNumber)
              <a href="tel:{{ $phoneNumber }}"
                 class="pdp__contact-btn pdp__contact-btn--call">
                <i class="fas fa-phone-alt"></i>
                অর্ডার করতে কল করুন
              </a>
            @endif

            @if($whatsappNumber)
              <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappText }}"
                 target="_blank" rel="noopener"
                 class="pdp__contact-btn pdp__contact-btn--whatsapp">
                <i class="fab fa-whatsapp"></i>
                Whats App
              </a>
            @endif

            @if($messengerUrl)
              <a href="{{ $messengerUrl }}"
                 target="_blank" rel="noopener"
                 class="pdp__contact-btn pdp__contact-btn--messenger">
                <i class="fab fa-facebook-messenger"></i>
                Message
              </a>
            @endif

          </div>

          {{-- Product Meta --}}
          <div class="pdp__product-meta">
            @if($categoryName)<span><strong>ক্যাটাগরি:</strong> {{ $categoryName }}</span>@endif
            @if($subCatName)<span><strong>সাব-ক্যাটাগরি:</strong> {{ $subCatName }}</span>@endif
            @if(!empty($tags))
              <span>
                <strong>ট্যাগ:</strong>
                @foreach($tags as $tag)
                  <a href="#" style="color:var(--red);margin-right:4px">#{{ $tag }}</a>
                @endforeach
              </span>
            @endif
            <span><strong>পণ্যের ধরন:</strong> {{ ucfirst($product->product_type ?? 'N/A') }}</span>
          </div>

          @if($product->return_policy)
            <div class="pdp__notice">
              <i class="fas fa-undo"></i>
              <span>{{ $product->return_policy }}</span>
            </div>
          @endif

        </div>{{-- /.pdp__info --}}

        {{-- ── Sidebar Column ── --}}
        <div class="pdp__sidebar">

          {{-- Delivery --}}
          <div class="pdp__s-card">
            <div class="pdp__card-head">
              <i class="fas fa-truck" style="margin-right:6px;color:var(--red)"></i>ডেলিভারি ও শিপিং
            </div>
            <div class="pdp__card-body">
              <div class="pdp__del-row">
                <div class="pdp__del-icon"><i class="fas fa-truck"></i></div>
                <div>
                  <div class="pdp__del-title">{{$deliveryInformation->home_delivery_title ?? ''}}</div>
                  <div class="pdp__del-date">{{$deliveryInformation->home_delivery_description ?? ''}}</div>
                </div>
              </div>
              <div class="pdp__del-row">
                <div class="pdp__del-icon"><i class="fas fa-store"></i></div>
                <div>
                  <div class="pdp__del-title">{{$deliveryInformation->pickup_title ?? ''}}</div>
                  <div class="pdp__del-date">{{$deliveryInformation->pickup_description ?? ''}}</div>
                </div>
              </div>
              @if($product->return_policy)
                <div class="pdp__del-row">
                  <div class="pdp__del-icon"><i class="fas fa-undo"></i></div>
                  <div>
                    <div class="pdp__del-title">রিটার্ন পলিসি</div>
                    <div class="pdp__del-date">{{ Str::limit($product->return_policy, 80) }}</div>
                  </div>
                </div>
              @endif
              @if(($product->product_type ?? '') === 'digital')
                <div class="pdp__del-row">
                  <div class="pdp__del-icon"><i class="fas fa-download"></i></div>
                  <div>
                    <div class="pdp__del-title">{{$deliveryInformation->instant_download_title ?? ''}}</div>
                    <div class="pdp__del-date">{{$deliveryInformation->instant_download_description ?? ''}}</div>
                  </div>
                </div>
              @endif
            </div>
          </div>

          {{-- Seller --}}
          @if($product->vendor)
            <div class="pdp__s-card">
              <div class="pdp__card-head">
                <i class="fas fa-store" style="margin-right:6px;color:var(--red)"></i>বিক্রেতা
              </div>
              <div class="pdp__card-body">
                <div class="pdp__seller-head">
                  <div class="pdp__seller-ava">{{ strtoupper(substr($product->vendor, 0, 2)) }}</div>
                  <div>
                    <div class="pdp__seller-name">{{ $product->vendor }}</div>
                    <div class="pdp__seller-ver"><i class="fas fa-check-circle"></i> যাচাইকৃত বিক্রেতা</div>
                  </div>
                </div>
              </div>
            </div>
          @endif

          {{-- YouTube Video --}}
          @if($ytId)
            <div class="pdp__s-card">
              <div class="pdp__card-head">
                <i class="fab fa-youtube" style="margin-right:6px;color:#ef4444"></i>পণ্যের ভিডিও
              </div>
              <div class="pdp__card-body" style="padding:0">
                <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;">
                  <iframe src="https://www.youtube.com/embed/{{ $ytId }}"
                          style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                          allowfullscreen loading="lazy"></iframe>
                </div>
              </div>
            </div>
          @endif

          {{-- Secure Payment --}}
          <div class="pdp__s-card">
            <div class="pdp__card-head">
              <i class="fas fa-shield-alt" style="margin-right:6px;color:var(--red)"></i>নিরাপদ পেমেন্ট
            </div>
            <div class="pdp__card-body">
              <div class="pdp__del-row">
                <div class="pdp__del-icon"><i class="fas fa-lock"></i></div>
                <div>
                  <div class="pdp__del-title">{{$deliveryInformation->secure_title ?? ''}}</div>
                  <div class="pdp__del-date">{{$deliveryInformation->secure_description ?? ''}}</div>
                </div>
              </div>
              <div class="pdp__del-row">
                <div class="pdp__del-icon"><i class="fas fa-credit-card"></i></div>
                <div>
                  <div class="pdp__del-title">{{$deliveryInformation->cod_title ?? ''}}</div>
                  <div class="pdp__del-date">{{$deliveryInformation->cod_description ?? ''}}</div>
                </div>
              </div>
              <div class="pdp__del-row">
                <div class="pdp__del-icon"><i class="fas fa-mobile-alt"></i></div>
                <div>
                  <div class="pdp__del-title">{{$deliveryInformation->mobile_banking_title ?? ''}}</div>
                  <div class="pdp__del-date">{{$deliveryInformation->mobile_banking_description ?? ''}}</div>
                </div>
              </div>
            </div>
          </div>

        </div>{{-- /.pdp__sidebar --}}

      </div>{{-- /.pdp__grid --}}
    </div>{{-- /.pdp__card --}}

    {{-- ════════ TABS ════════ --}}
    <div class="pdp__tabs" id="pdpTabsSection">
      <div class="pdp__tab-nav">
        <button class="pdp__tab-btn pdp__tab-btn--active" onclick="pdpTab('description')">
          <i class="fas fa-align-left"></i> বিবরণ
        </button>
        <button class="pdp__tab-btn" onclick="pdpTab('specifications')">
          <i class="fas fa-list"></i> বিশেষত্ব
        </button>
        <button class="pdp__tab-btn" onclick="pdpTab('reviews')">
          <i class="fas fa-star"></i> রিভিউ
          @if($totalRevCount > 0)
            <span style="background:var(--red);color:#fff;font-size:10px;font-weight:800;padding:2px 7px;border-radius:10px;margin-left:2px">
              {{ $totalRevCount }}
            </span>
          @endif
        </button>
      </div>

      {{-- Description Tab --}}
      <div id="pdpDescription" class="pdp__tab-pane pdp__tab-pane--active">
        <div class="pdp__desc">{!! $product->description !!}</div>
      </div>

      {{-- Specifications Tab --}}
      <div id="pdpSpecifications" class="pdp__tab-pane">
        <div class="pdp__spec-section">
          <div class="pdp__spec-head">পণ্যের বিবরণ</div>
          <div class="pdp__spec-row">
            <span class="pdp__spec-k">SKU</span>
            <span class="pdp__spec-v">{{ $product->sku ?? 'N/A' }}</span>
          </div>
          <div class="pdp__spec-row">
            <span class="pdp__spec-k">পণ্যের ধরন</span>
            <span class="pdp__spec-v">{{ ucfirst($product->product_type ?? 'N/A') }}</span>
          </div>
          @if($categoryName)
            <div class="pdp__spec-row">
              <span class="pdp__spec-k">ক্যাটাগরি</span>
              <span class="pdp__spec-v">{{ $categoryName }}</span>
            </div>
          @endif
          @if($subCatName)
            <div class="pdp__spec-row">
              <span class="pdp__spec-k">সাব-ক্যাটাগরি</span>
              <span class="pdp__spec-v">{{ $subCatName }}</span>
            </div>
          @endif
          @if($product->vendor)
            <div class="pdp__spec-row">
              <span class="pdp__spec-k">ব্র্যান্ড / বিক্রেতা</span>
              <span class="pdp__spec-v">{{ $product->vendor }}</span>
            </div>
          @endif
          <div class="pdp__spec-row">
            <span class="pdp__spec-k">প্রাপ্যতা</span>
            <span class="pdp__spec-v">{{ $stockLabel }}</span>
          </div>
        </div>

        @if($variants->count())
          <div class="pdp__spec-section">
            <div class="pdp__spec-head">ভ্যারিয়েন্ট সমূহ</div>
            @foreach($variants as $v)
              <div class="pdp__spec-row">
                <span class="pdp__spec-k">
                  {{ $v['size'] ?? '' }}{{ (!empty($v['size']) && !empty($v['color'])) ? ' / ' : '' }}{{ $v['color'] ?? '' }}
                </span>
                <span class="pdp__spec-v">
                  স্টক: {{ $v['stock'] ?? 0 }}
                  @if(!empty($v['price'])) — ৳{{ number_format($v['price'], 2) }}@endif
                </span>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      {{-- Reviews Tab --}}
      <div id="pdpReviews" class="pdp__tab-pane">
        <div class="pdp-rev-summary">
          <div class="pdp-rev-big-score">
            <div class="pdp-rev-big-num">{{ $totalRevCount > 0 ? number_format($avgRating, 1) : '—' }}</div>
            <div class="pdp-rev-big-stars">
              @for($s=1; $s<=5; $s++)
                <i class="bi bi-star{{ $s <= round($avgRating) ? '-fill' : ($s - 0.5 <= $avgRating ? '-half' : '') }}"
                   style="color:{{ $totalRevCount > 0 ? '#f59e0b' : '#d1d5db' }}"></i>
              @endfor
            </div>
            <div class="pdp-rev-big-count">{{ $totalRevCount }} টি রিভিউ</div>
          </div>

          <div class="pdp-rev-bars">
            @for($s = 5; $s >= 1; $s--)
              @php
                $cnt = $starCounts[$s] ?? 0;
                $pct = $totalRevCount > 0 ? round(($cnt / $totalRevCount) * 100) : 0;
              @endphp
              <div class="pdp-rev-bar-row">
                <span style="width:12px;text-align:right;flex-shrink:0;">{{ $s }}</span>
                <i class="bi bi-star-fill" style="font-size:11px;color:#f59e0b;flex-shrink:0;"></i>
                <div class="pdp-rev-bar-track">
                  <div class="pdp-rev-bar-fill" style="width:{{ $pct }}%"></div>
                </div>
                <span class="pdp-rev-bar-pct">{{ $pct }}%</span>
                <span style="font-size:11px;color:var(--muted);width:20px;flex-shrink:0">({{ $cnt }})</span>
              </div>
            @endfor
          </div>

          <div class="pdp-rev-write-cta">
            @auth
              @if($alreadyReviewed)
                <p>আপনি ইতোমধ্যে রিভিউ দিয়েছেন। ধন্যবাদ!</p>
                <button class="pdp-rev-write-btn" type="button" id="pdpOpenRevModal" style="background:#6b7280">
                  <i class="fas fa-eye"></i> আপনার রিভিউ দেখুন
                </button>
              @else
                <p>এই পণ্যটি কি পছন্দ হয়েছে? আপনার অভিজ্ঞতা শেয়ার করুন!</p>
                <button class="pdp-rev-write-btn" type="button" id="pdpOpenRevModal">
                  <i class="fas fa-pen"></i> রিভিউ লিখুন
                </button>
              @endif
            @else
              <p>রিভিউ দিতে লগইন করুন।</p>
              <a href="{{ url('customer/login') }}" class="pdp-rev-write-btn">
                <i class="fas fa-sign-in-alt"></i> লগইন করুন
              </a>
            @endauth
          </div>
        </div>

        @if($productReviews->isNotEmpty())
          <div class="pdp-rev-grid">
            @foreach($productReviews as $rev)
              @php
                $reviewer     = $rev->user;
                $reviewerName = $reviewer ? $reviewer->name : 'অজ্ঞাত';
                $initial      = strtoupper(substr($reviewerName, 0, 1));
              @endphp
              <div class="pdp-rev-card">
                <div class="pdp-rev-stars">
                  @for($s=1; $s<=5; $s++)
                    <i class="bi bi-star{{ $s <= $rev->rating ? '-fill rev-star-filled' : ' rev-star-empty' }}"></i>
                  @endfor
                  <span class="pdp-rev-score-label">{{ $rev->rating }}/5</span>
                </div>
                @if($rev->review)
                  <p class="pdp-rev-text">"{{ $rev->review }}"</p>
                @else
                  <p class="pdp-rev-text" style="color:var(--muted);font-style:normal;font-size:12px">
                    (কোনো মন্তব্য করা হয়নি)
                  </p>
                @endif
                <div class="pdp-rev-footer">
                  <div class="pdp-rev-avatar">{{ $initial }}</div>
                  <div>
                    <div class="pdp-rev-name">{{ $reviewerName }}</div>
                    <div class="pdp-rev-date">{{ $rev->created_at->format('d M Y') }}</div>
                  </div>
                  <div class="pdp-rev-verified"><i class="bi bi-patch-check-fill"></i> যাচাইকৃত</div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="pdp-rev-empty">
            <i class="fas fa-star"></i>
            <p>এখনো কোনো রিভিউ নেই। প্রথম রিভিউটি আপনিই দিন!</p>
            @auth
              @if(!$alreadyReviewed)
                <button class="pdp-rev-write-btn" type="button" id="pdpOpenRevModalEmpty">
                  <i class="fas fa-pen"></i> রিভিউ লিখুন
                </button>
              @endif
            @else
              <a href="{{ url('customer/login') }}" class="pdp-rev-write-btn">
                <i class="fas fa-sign-in-alt"></i> লগইন করুন
              </a>
            @endauth
          </div>
        @endif
      </div>

    </div>{{-- /.pdp__tabs --}}

    {{-- ════════ RELATED PRODUCTS ════════ --}}
    @if(!empty($relatedProducts) && $relatedProducts->count())
      <div class="pdp__related">
        <div class="pdp__section-header">
          <h2 class="pdp__section-title">সম্পর্কিত পণ্য</h2>
          @if($categoryName)<a href="#" class="pdp__see-all">সব দেখুন →</a>@endif
        </div>
        <div class="pdp__prod-grid">
          @foreach($relatedProducts as $rp)
            @php
              $rpImg  = $rp->feature_image ? asset('uploads/products/' . $rp->feature_image) : asset('images/placeholder.png');
              $rpPx   = $rp->discount_price ?? $rp->current_price;
              $rpOld  = $rp->discount_price ? $rp->current_price : null;
              $rpDisc = ($rp->discount_price && $rp->current_price > 0)
                          ? round((($rp->current_price - $rp->discount_price) / $rp->current_price) * 100)
                          : null;
            @endphp
            <a href="{{ route('product.detail', $rp->slug) }}" class="pdp__prod-card">
              <div class="pdp__prod-img">
                @if($rpDisc)
                  <div class="pdp__prod-disc">
                    <span>{{ $rpDisc }}%</span>
                    <span style="font-size:8px">ছাড়</span>
                  </div>
                @endif
                <img src="{{ $rpImg }}" alt="{{ $rp->name }}" loading="lazy"/>
              </div>
              <div class="pdp__prod-body">
                <div class="pdp__prod-name">{{ $rp->name }}</div>
                <div class="pdp__prod-prices">
                  @if($rpOld)<span class="pdp__prod-old">৳{{ number_format($rpOld, 2) }}</span>@endif
                  <span class="pdp__prod-price">৳{{ number_format($rpPx, 2) }}</span>
                </div>
              </div>
              <button type="button" class="pdp__prod-cart-btn"
                      data-url="{{ route('cart.add', $rp->id) }}"
                      onclick="event.preventDefault();event.stopPropagation();pdpRelatedCart(this)">
                <i class="fa-solid fa-cart-plus"></i> কার্টে যোগ করুন
              </button>
            </a>
          @endforeach
        </div>
      </div>
    @endif

  </div>{{-- /.pdp__wrap --}}

  {{-- ════════ ZOOM OVERLAY ════════ --}}
  <div class="pdp__zoom" id="pdpZoom">
    <button type="button" class="pdp__zoom-close" id="pdpZoomClose"><i class="fas fa-times"></i></button>
    <button type="button" class="pdp__zoom-nav pdp__zoom-prev" id="pdpZoomPrev"><i class="fas fa-chevron-left"></i></button>
    <img id="pdpZoomImg" class="pdp__zoom-img" src="" alt="বড় ছবি"/>
    <button type="button" class="pdp__zoom-nav pdp__zoom-next" id="pdpZoomNext"><i class="fas fa-chevron-right"></i></button>
    <div class="pdp__zoom-count" id="pdpZoomCount">1 / {{ $totalImages }}</div>
  </div>

</div>{{-- /.pdp --}}

{{-- ════════ CONTACT BUTTON STYLES ════════ --}}
<style>
.pdp__contact-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 14px;
    margin-bottom: 14px;
}
.pdp__contact-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 13px 20px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 700;
    color: #fff;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: opacity .18s, transform .15s;
    letter-spacing: .3px;
}
.pdp__contact-btn:hover {
    opacity: .88;
    transform: translateY(-1px);
    color: #fff;
    text-decoration: none;
}
.pdp__contact-btn:active {
    transform: translateY(0);
    opacity: 1;
}
.pdp__contact-btn i {
    font-size: 17px;
}
/* Black — Call */
.pdp__contact-btn--call      { background: #111111; }
/* Green — WhatsApp */
.pdp__contact-btn--whatsapp  { background: #25D366; }
/* Blue  — Messenger */
.pdp__contact-btn--messenger { background: #0866FF; }
</style>

{{-- ════════ JAVASCRIPT ════════ --}}
<script>
(function () {
'use strict';

var IMGS     = @json($allImages->pluck('url')->values());
var MAX_QTY  = {{ $product->is_unlimited ? 9999 : max(1, $product->stock ?? 1) }};
var CHECKOUT = '{{ $checkoutUrl }}';
var CSRF     = (function () {
    var m = document.querySelector('meta[name="csrf-token"]');
    return m ? m.getAttribute('content') : '{{ $csrfToken }}';
})();
var curIdx = 0, selColor = null, selSize = null;

/* ── Toast ── */
function toast(msg, type, ms) {
    type = type || 'success'; ms = ms || 3200;
    var icons = { success: 'bi bi-check-circle-fill', error: 'bi bi-x-circle-fill', info: 'bi bi-info-circle-fill' };
    var el = document.createElement('div');
    el.className = 'pdp-toast pdp-toast--' + type;
    el.innerHTML = '<i class="' + (icons[type] || icons.info) + '"></i><span>' + msg + '</span>';
    var w = document.getElementById('pdp-toasts');
    if (w) w.appendChild(el);
    setTimeout(function () {
        el.classList.add('out');
        setTimeout(function () { if (el.parentNode) el.parentNode.removeChild(el); }, 320);
    }, ms);
}

/* ── Badge update ── */
function updateBadge(n) {
    document.querySelectorAll('#cartBadge,#mobCartBadge,.cart-badge,#cart-count,.pdp-cart-count')
        .forEach(function (b) {
            b.textContent = n > 0 ? n : '';
            if (b.classList) b.classList.toggle('zero', n === 0);
        });
}

/* ── Cart POST ── */
function cartPost(url, qty, color, size, cb) {
    var fd = new FormData();
    fd.append('_token', CSRF);
    fd.append('quantity', qty);
    if (color) fd.append('selected_color', color);
    if (size)  fd.append('selected_size', size);
    fetch(url, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: fd
    }).then(function (r) {
        if (!r.ok && r.status !== 422 && r.status !== 419) throw new Error('HTTP ' + r.status);
        return r.json();
    }).then(function (d) {
        if (typeof cb === 'function') cb(null, d);
    }).catch(function (e) {
        if (typeof cb === 'function') cb(e, null);
    });
}

/* ── Button loader ── */
function btnLoad(btn, on) {
    if (!btn) return;
    var icon = btn.querySelector('i:not(.pdp-spinner)');
    if (on) {
        btn.disabled = true;
        if (!btn.querySelector('.pdp-spinner')) {
            var s = document.createElement('span');
            s.className = 'pdp-spinner';
            btn.insertBefore(s, btn.firstChild);
        }
        if (icon) icon.style.display = 'none';
    } else {
        btn.disabled = false;
        var sp = btn.querySelector('.pdp-spinner');
        if (sp) sp.parentNode.removeChild(sp);
        if (icon) icon.style.display = '';
    }
}

/* ── Add to Cart ── */
var acb = document.getElementById('pdpAddCart');
if (acb) {
    acb.addEventListener('click', function () {
        var btn = this;
        btnLoad(btn, true);
        cartPost(btn.dataset.url, parseInt(document.getElementById('pdpQtyInput').value, 10) || 1, selColor, selSize, function (err, data) {
            btnLoad(btn, false);
            if (err) { toast('নেটওয়ার্ক সমস্যা। আবার চেষ্টা করুন।', 'error'); return; }
            if (data && data.success) {
                updateBadge(data.cart_count);
                toast(data.message || 'কার্টে যোগ হয়েছে!', 'success');
            } else {
                if (data && String(data.message).toLowerCase().indexOf('csrf') !== -1) {
                    toast('সেশন শেষ হয়েছে। পেজ রিলোড হচ্ছে...', 'info');
                    setTimeout(function () { window.location.reload(); }, 1500);
                } else {
                    toast((data && data.message) || 'কার্টে যোগ করতে সমস্যা হয়েছে।', 'error');
                }
            }
        });
    });
}

/* ── Buy Now ── */
var bnb = document.getElementById('pdpBuyNow');
if (bnb) {
    bnb.addEventListener('click', function () {
        var btn = this;
        btnLoad(btn, true);
        cartPost(btn.dataset.url, parseInt(document.getElementById('pdpQtyInput').value, 10) || 1, selColor, selSize, function (err, data) {
            if (err) { btnLoad(btn, false); toast('নেটওয়ার্ক সমস্যা। আবার চেষ্টা করুন।', 'error'); return; }
            if (data && data.success) {
                updateBadge(data.cart_count);
                window.location.href = CHECKOUT;
            } else {
                btnLoad(btn, false);
                toast((data && data.message) || 'কার্টে যোগ করতে সমস্যা হয়েছে।', 'error');
            }
        });
    });
}

/* ── Wishlist ── */
var wb = document.getElementById('pdpWishBtn');
if (wb) {
    wb.addEventListener('click', function (e) {
        e.stopPropagation();
        var btn = this;
        btn.disabled = true;
        fetch(btn.dataset.url, { method: 'GET', headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                btn.disabled = false;
                if (data.success || data.message) {
                    btn.classList.toggle('pdp__wish-btn--active');
                    var icon   = btn.querySelector('i');
                    var active = btn.classList.contains('pdp__wish-btn--active');
                    if (icon) { icon.className = active ? 'bi bi-heart-fill' : 'bi bi-heart'; icon.style.color = active ? '#ef4444' : ''; }
                    toast(data.message || 'উইশলিস্টে যোগ হয়েছে!', 'success');
                } else {
                    toast(data.message || 'সমস্যা হয়েছে।', 'error');
                }
            }).catch(function () { btn.disabled = false; window.location.href = btn.dataset.url; });
    });
}

/* ── Related product cart ── */
window.pdpRelatedCart = function (btn) {
    var url = btn.dataset.url, orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="pdp-spinner" style="width:14px;height:14px;border-width:2px"></span> যোগ হচ্ছে...';
    cartPost(url, 1, null, null, function (err, data) {
        if (err) { btn.innerHTML = orig; btn.disabled = false; toast('নেটওয়ার্ক সমস্যা।', 'error'); return; }
        if (data && data.success) {
            updateBadge(data.cart_count);
            toast(data.message || 'কার্টে যোগ হয়েছে!', 'success');
            btn.innerHTML = '<i class="fas fa-check"></i> যোগ হয়েছে!';
            setTimeout(function () { btn.innerHTML = orig; btn.disabled = false; }, 2000);
        } else {
            btn.innerHTML = orig; btn.disabled = false;
            toast((data && data.message) || 'সমস্যা হয়েছে।', 'error');
        }
    });
};

/* ── Option buttons (color / size) ── */
document.querySelectorAll('.pdp__opt-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var g = this.dataset.group, v = this.dataset.value, wa = this.classList.contains('pdp__opt-btn--active');
        document.querySelectorAll('.pdp__opt-btn[data-group="' + g + '"]').forEach(function (b) { b.classList.remove('pdp__opt-btn--active'); });
        if (!wa) {
            this.classList.add('pdp__opt-btn--active');
            if (g === 'color') { selColor = v; _l('pdpColorSel', v); }
            else               { selSize  = v; _l('pdpSizeSel', v);  }
        } else {
            if (g === 'color') { selColor = null; _l('pdpColorSel', null); }
            else               { selSize  = null; _l('pdpSizeSel', null);  }
        }
    });
});
function _l(id, val) {
    var el = document.getElementById(id); if (!el) return;
    el.textContent = val ? '— ' + val : ''; el.style.display = val ? 'inline' : 'none';
}

/* ── Quantity ── */
var qi  = document.getElementById('pdpQtyInput');
var inc = document.getElementById('pdpQtyInc');
var dec = document.getElementById('pdpQtyDec');
if (inc) inc.addEventListener('click', function () { var v = parseInt(qi.value, 10); if (v < MAX_QTY) qi.value = v + 1; });
if (dec) dec.addEventListener('click', function () { var v = parseInt(qi.value, 10); if (v > 1) qi.value = v - 1; });

/* ── Gallery / Thumbnails ── */
var mainImg = document.getElementById('pdpMainImg');
var counter = document.getElementById('pdpCounter');
var thumbs  = document.querySelectorAll('.pdp__thumb');
thumbs.forEach(function (t) {
    t.addEventListener('click', function (e) {
        e.stopPropagation();
        thumbs.forEach(function (x) { x.classList.remove('pdp__thumb--active'); });
        t.classList.add('pdp__thumb--active');
        curIdx = parseInt(t.dataset.idx, 10);
        mainImg.src = t.dataset.src;
        counter.textContent = (curIdx + 1) + ' / ' + IMGS.length;
    });
});

/* ── Zoom ── */
var zoomEl    = document.getElementById('pdpZoom');
var zoomImg   = document.getElementById('pdpZoomImg');
var zoomCount = document.getElementById('pdpZoomCount');
function openZoom(idx) {
    curIdx = idx; zoomImg.src = IMGS[curIdx]; zoomImg.style.opacity = '1'; zoomImg.style.transform = '';
    zoomCount.textContent = (curIdx + 1) + ' / ' + IMGS.length;
    zoomEl.classList.add('pdp__zoom--active'); document.body.style.overflow = 'hidden';
}
function closeZoom() { zoomEl.classList.remove('pdp__zoom--active'); document.body.style.overflow = ''; }
function zoomNav(dir) {
    curIdx = (curIdx + dir + IMGS.length) % IMGS.length;
    zoomImg.style.opacity = '0'; zoomImg.style.transform = 'scale(.88)';
    setTimeout(function () {
        zoomImg.src = IMGS[curIdx];
        zoomCount.textContent = (curIdx + 1) + ' / ' + IMGS.length;
        mainImg.src = IMGS[curIdx];
        counter.textContent = (curIdx + 1) + ' / ' + IMGS.length;
        thumbs.forEach(function (t) { t.classList.toggle('pdp__thumb--active', parseInt(t.dataset.idx, 10) === curIdx); });
        zoomImg.style.opacity = '1'; zoomImg.style.transform = 'scale(1)';
    }, 160);
}
var mw = document.getElementById('pdpMainWrap');
if (mw) mw.addEventListener('click', function (e) { if (e.target.closest('#pdpWishBtn')) return; openZoom(curIdx); });
document.getElementById('pdpZoomClose').addEventListener('click', function (e) { e.stopPropagation(); closeZoom(); });
zoomEl.addEventListener('click', function (e) { if (e.target === zoomEl) closeZoom(); });
zoomImg.addEventListener('click', closeZoom);
document.getElementById('pdpZoomPrev').addEventListener('click', function (e) { e.stopPropagation(); zoomNav(-1); });
document.getElementById('pdpZoomNext').addEventListener('click', function (e) { e.stopPropagation(); zoomNav(1); });
document.addEventListener('keydown', function (e) {
    if (!zoomEl.classList.contains('pdp__zoom--active')) return;
    if (e.key === 'Escape')      closeZoom();
    if (e.key === 'ArrowLeft')   zoomNav(-1);
    if (e.key === 'ArrowRight')  zoomNav(1);
});

/* ── Viewers counter (live feel) ── */
var _vc = document.getElementById('pdpViewers');
if (_vc) setInterval(function () {
    var c = parseInt(_vc.textContent, 10);
    _vc.textContent = Math.max(50, Math.min(80, c + (Math.random() < .5 ? 1 : -1)));
}, 4000);

/* ── Tabs ── */
var _tm = { description: 0, specifications: 1, reviews: 2 };
window.pdpTab = function (id) {
    document.querySelectorAll('.pdp__tab-pane').forEach(function (c) { c.classList.remove('pdp__tab-pane--active'); });
    document.querySelectorAll('.pdp__tab-btn').forEach(function (b) { b.classList.remove('pdp__tab-btn--active'); });
    var cap  = id.charAt(0).toUpperCase() + id.slice(1);
    var pane = document.getElementById('pdp' + cap);
    var btns = document.querySelectorAll('.pdp__tab-btn');
    if (pane) pane.classList.add('pdp__tab-pane--active');
    if (btns[_tm[id]]) btns[_tm[id]].classList.add('pdp__tab-btn--active');
    var sec = document.getElementById('pdpTabsSection');
    if (sec) sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
};

/* ── Review modal ── */
var revModal = document.getElementById('pdpRevModal');
var rmc      = document.getElementById('pdpRevModalClose');
function openRM()  { if (revModal) revModal.classList.add('active');    document.body.style.overflow = 'hidden'; }
function closeRM() { if (revModal) revModal.classList.remove('active'); document.body.style.overflow = ''; }
var ob  = document.getElementById('pdpOpenRevModal');      if (ob)  ob.addEventListener('click', openRM);
var obe = document.getElementById('pdpOpenRevModalEmpty'); if (obe) obe.addEventListener('click', openRM);
if (rmc) rmc.addEventListener('click', closeRM);
if (revModal) revModal.addEventListener('click', function (e) { if (e.target === revModal) closeRM(); });
document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeRM(); });

/* ── Star picker ── */
var sp = document.getElementById('pdpRevStarPicker');
var ri = document.getElementById('pdpRevRatingInput');
var sr = 0;
if (sp) {
    var stars = sp.querySelectorAll('i');
    stars.forEach(function (star) {
        star.addEventListener('mouseenter', function () {
            var v = parseInt(this.dataset.val, 10);
            stars.forEach(function (s, i) { s.className = i < v ? 'fas fa-star selected' : 'far fa-star'; });
        });
        star.addEventListener('mouseleave', function () {
            stars.forEach(function (s, i) { s.className = i < sr ? 'fas fa-star selected' : 'far fa-star'; });
        });
        star.addEventListener('click', function () {
            sr = parseInt(this.dataset.val, 10);
            if (ri) ri.value = sr;
            var er = document.getElementById('pdpRevRatingErr');
            if (er) er.style.display = 'none';
            stars.forEach(function (s, i) { s.className = i < sr ? 'fas fa-star selected' : 'far fa-star'; });
        });
    });
}

/* ── Review form submit ── */
var rf = document.getElementById('pdpRevForm');
if (rf) {
    rf.addEventListener('submit', function (e) {
        e.preventDefault();
        if (sr === 0) { var er = document.getElementById('pdpRevRatingErr'); if (er) er.style.display = 'block'; return; }
        var sb = document.getElementById('pdpRevSubmit');
        if (sb) { sb.disabled = true; sb.innerHTML = '<span class="pdp-spinner"></span> জমা হচ্ছে...'; }
        var fd = new FormData(rf); fd.set('_token', CSRF);
        fetch(rf.action, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }, body: fd })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    closeRM();
                    toast(data.message || 'রিভিউ সফলভাবে জমা হয়েছে।', 'success', 5000);
                    setTimeout(function () { window.location.reload(); }, 2500);
                } else {
                    toast(data.message || 'রিভিউ জমা দিতে সমস্যা হয়েছে।', 'error');
                    if (sb) { sb.disabled = false; sb.innerHTML = '<i class="fas fa-paper-plane"></i> রিভিউ জমা দিন'; }
                }
            }).catch(function () { rf.submit(); });
    });
}

})();
</script>
@endsection
