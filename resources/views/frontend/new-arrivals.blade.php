{{-- resources/views/frontend/new-arrivals.blade.php --}}
@extends('frontend.master')

@section('main-content')

<div class="na-page">

    {{-- ══════════ HERO ══════════ --}}
    <div class="na-hero">
        <div class="na-hero__left">
            <div class="na-hero__eyebrow">
                <i class="bi bi-stars"></i> Fresh Collection
            </div>
            <h1 class="na-hero__title">
                নতুন <span class="hl">পণ্য</span><br>এসেছে!
            </h1>
            <p class="na-hero__sub">সদ্য যোগ হওয়া সব নতুন পণ্য এখানে দেখুন</p>
        </div>
        <div class="na-hero__right">
            <div class="na-hero__orb">
                <i class="bi bi-box-seam"></i>
            </div>
            @if(isset($newArrivals))
                <div class="na-hero__count">
                    মোট <b>{{ $newArrivals->total() }}</b> টি পণ্য
                </div>
            @endif
        </div>
    </div>

    {{-- ══════════ FILTER CHIPS ══════════ --}}
    <div class="na-filters">
        <a href="{{ url('new-arrivals') }}"
           class="na-filter-chip {{ !request('when') ? 'is-active' : '' }}">
            <span class="dot"></span> সব পণ্য
        </a>
        <a href="{{ url('new-arrivals?when=week') }}"
           class="na-filter-chip {{ request('when') === 'week' ? 'is-active' : '' }}">
            <i class="bi bi-calendar-week"></i> এই সপ্তাহ
        </a>
        <a href="{{ url('new-arrivals?when=month') }}"
           class="na-filter-chip {{ request('when') === 'month' ? 'is-active' : '' }}">
            <i class="bi bi-calendar-month"></i> এই মাস
        </a>
    </div>

    {{-- ══════════ SECTION HEADING ══════════ --}}
    <div class="na-heading">
        <div class="na-heading__left">
            <div class="na-heading__bar"></div>
            <h2 class="na-heading__title">সদ্য যোগ হয়েছে</h2>
            <span class="na-heading__badge">NEW</span>
        </div>
        @if(isset($newArrivals))
            <div class="na-heading__total">
                মোট <span>{{ $newArrivals->total() }}</span> পণ্য
            </div>
        @endif
    </div>

    {{-- ══════════ PRODUCT GRID ══════════ --}}
    @if(isset($newArrivals) && $newArrivals->isNotEmpty())

        <div class="na-grid">
            @foreach($newArrivals as $item)
                @php
                    $displayPrice  = $item->discount_price ?? $item->current_price;
                    $originalPrice = $item->current_price;
                    $discount      = ($item->discount_price && $originalPrice > 0)
                        ? round((($originalPrice - $item->discount_price) / $originalPrice) * 100) : null;
                    $inStock       = $item->is_unlimited || ($item->stock ?? 0) > 0;
                    $arrivedAt     = isset($item->arrived_at)
                        ? \Carbon\Carbon::parse($item->arrived_at)->diffForHumans() : null;
                @endphp

                <div class="na-wrap">

                    {{-- Wishlist — GET route তাই <a> ঠিকই আছে --}}
                    <a href="{{ route('wishlist.add', $item->id) }}"
                       class="na-wish"
                       onclick="event.stopPropagation();"
                       title="উইশলিস্টে যোগ করুন">
                        <i class="bi bi-heart"></i>
                    </a>

                    {{-- Product detail link wrapper (div instead of <a> to avoid nested form/anchor) --}}
                    <div class="na-card"
                         onclick="window.location='{{ route('product.detail', $item->slug) }}'"
                         style="cursor: pointer;">

                        <span class="na-badge-new">NEW</span>

                        @if($discount)
                            <span class="na-badge-disc">-{{ $discount }}%</span>
                        @endif

                        <div class="na-img-wrap">
                            <img class="na-img"
                                 src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                 alt="{{ $item->name }}"
                                 loading="lazy"
                                 onerror="this.src='{{ asset('default/no-image.png') }}'">
                        </div>

                        <div class="na-body">

                            @if($arrivedAt)
                                <p class="na-arrived">
                                    <i class="bi bi-clock"></i> {{ $arrivedAt }}
                                </p>
                            @endif

                            <a href="{{ route('product.detail', $item->slug) }}" 
                               class="na-name" 
                               onclick="event.stopPropagation()" 
                               style="text-decoration: none; color: inherit;">
                               {{ $item->name }}
                            </a>

                            <div class="na-price-row">
                                <span class="na-price">৳ {{ number_format($displayPrice, 0) }}</span>
                                @if($item->discount_price && $item->discount_price < $originalPrice)
                                    <span class="na-old">৳ {{ number_format($originalPrice, 0) }}</span>
                                @endif
                            </div>

                            <div class="na-stars" aria-label="রেটিং">★★★★☆</div>

                            <div class="na-spacer"></div>

                            {{-- ✅ FIX: POST form — GET method supported নেই --}}
                            @if($inStock)
                                <form class="na-atc-form"
                                      action="{{ route('cart.add', $item->id) }}"
                                      method="POST"
                                      onclick="event.stopPropagation()">
                                    @csrf
                                    <button type="submit" class="na-atc" style="border: none; width: 100%;">
                                        <i class="bi bi-cart-plus-fill"></i> কার্টে যোগ করুন
                                    </button>
                                </form>
                            @else
                                <span class="na-atc--out">
                                    <i class="bi bi-x-circle"></i> স্টক নেই
                                </span>
                            @endif

                        </div>

                    </div>
                </div>

            @endforeach
        </div>

        {{-- ══════════ PAGINATION ══════════ --}}
        @if($newArrivals->hasPages())
            <div class="na-pages">
                @if($newArrivals->onFirstPage())
                    <span class="disabled">‹</span>
                @else
                    <a href="{{ $newArrivals->previousPageUrl() }}">‹</a>
                @endif

                @foreach($newArrivals->links()->elements[0] as $page => $url)
                    @if($page == $newArrivals->currentPage())
                        <span class="is-cur">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($newArrivals->hasMorePages())
                    <a href="{{ $newArrivals->nextPageUrl() }}">›</a>
                @else
                    <span class="disabled">›</span>
                @endif
            </div>
        @endif

    @else

        <div class="na-empty">
            <i class="bi bi-box-seam"></i>
            <p>এখন কোনো নতুন পণ্য নেই। শীঘ্রই আসছে!</p>
        </div>

    @endif

</div>

@endsection
