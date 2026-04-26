{{-- resources/views/frontend/offers.blade.php --}}
@extends('frontend.master')

@section('main-content')
<div class="ofp">

    {{-- ══════════ HERO ══════════ --}}
    <div class="ofp-hero">
        <div class="ofp-hero__text">
            <p class="ofp-hero__eye">
                <i class="bi bi-tag-fill"></i> Exclusive Deals
            </p>
            <h1 class="ofp-hero__title">সেরা <em>অফার</em> &amp;<br>ডিসকাউন্ট</h1>
            <p class="ofp-hero__sub">সীমিত সময়ের জন্য বিশেষ মূল্যছাড় উপভোগ করুন</p>
        </div>
        <div class="ofp-hero__badge">
            <span class="b-num">70%</span>
            <span class="b-txt">পর্যন্ত</span>
            <span class="b-txt">ছাড়</span>
        </div>
    </div>

    {{-- ══════════ FILTER BAR ══════════ --}}
    <div class="ofp-filter">
        <span class="ofp-filter__lbl">
            <i class="bi bi-funnel-fill"></i> ফিল্টার:
        </span>
        <a href="{{ url('offers') }}"
           class="ofp-chip {{ !request('type') && !request('sort') ? 'is-active' : '' }}">
            সব অফার
        </a>
        <a href="{{ url('offers?type=flash') }}"
           class="ofp-chip {{ request('type') === 'flash' ? 'is-active' : '' }}">
            <i class="bi bi-lightning-charge-fill"></i> ফ্ল্যাশ সেল
        </a>
        <a href="{{ url('offers?type=clearance') }}"
           class="ofp-chip {{ request('type') === 'clearance' ? 'is-active' : '' }}">
            <i class="bi bi-fire"></i> ক্লিয়ারেন্স
        </a>
        <a href="{{ url('offers?sort=discount') }}"
           class="ofp-chip {{ request('sort') === 'discount' ? 'is-active' : '' }}">
            <i class="bi bi-sort-down"></i> সর্বোচ্চ ছাড়
        </a>
    </div>

    {{-- ══════════ FLASH SALE ══════════ --}}
    @if(isset($flashProducts) && $flashProducts->isNotEmpty())

        <div class="ofp-sec">
            <h2><i class="bi bi-lightning-charge-fill" style="color:#c8102e"></i> ফ্ল্যাশ সেল</h2>
            <span class="ofp-tag ofp-tag--red">HOT</span>
        </div>

        <div class="ofp-grid">
            @foreach($flashProducts as $item)
                @php
                    $dPrice  = $item->flash_sale_price ?? $item->discount_price ?? $item->current_price;
                    $oPrice  = $item->current_price;
                    $disc    = ($dPrice < $oPrice && $oPrice > 0)
                               ? round((($oPrice - $dPrice) / $oPrice) * 100) : null;
                    $inStock = $item->is_unlimited || (($item->stock ?? 0) > 0);
                @endphp
                <div class="ofp-wrap">

                    {{-- Wishlist (GET is fine here) --}}
                    <a href="{{ route('wishlist.add', $item->id) }}"
                       class="ofp-wish"
                       onclick="event.stopPropagation();event.preventDefault();"
                       title="উইশলিস্টে যোগ করুন">
                        <i class="bi bi-heart"></i>
                    </a>

                    {{-- Product card link --}}
                    <a href="{{ route('product.detail', $item->slug) }}" class="ofp-card">
                        @if($disc)
                            <span class="ofp-disc{{ $disc >= 50 ? ' ofp-disc--gold' : '' }}">-{{ $disc }}%</span>
                        @endif
                        <div class="ofp-img-wrap">
                            <img class="ofp-img"
                                 src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                 alt="{{ $item->name }}"
                                 loading="lazy"
                                 onerror="this.src='{{ asset('default/no-image.png') }}'">
                        </div>
                        <div class="ofp-body">
                            <p class="ofp-name">{{ $item->name }}</p>
                            <p class="ofp-price">৳&nbsp;{{ number_format($dPrice, 0) }}</p>
                            @if($dPrice < $oPrice)
                                <p class="ofp-old">৳&nbsp;{{ number_format($oPrice, 0) }}</p>
                            @endif
                            <div class="ofp-stars" aria-label="রেটিং">★★★★☆</div>
                            <div class="ofp-spacer"></div>

                            {{-- ✅ FIX: POST form instead of GET link --}}
                            @if($inStock)
                                <form
                                    action="{{ route('cart.add', $item->id) }}"
                                    method="POST"
                                    class="ofp-atc-form"
                                    onclick="event.stopPropagation()">
                                    @csrf
                                    <button type="submit" class="ofp-atc">
                                        <i class="bi bi-cart-plus-fill"></i> কার্টে যোগ করুন
                                    </button>
                                </form>
                            @else
                                <span class="ofp-atc ofp-atc--out">
                                    <i class="bi bi-x-circle"></i> স্টক নেই
                                </span>
                            @endif

                        </div>
                    </a>
                </div>
            @endforeach
        </div>

    @endif

    {{-- ══════════ DISCOUNT PRODUCTS ══════════ --}}
    <div class="ofp-sec">
        <h2>ডিসকাউন্ট পণ্য</h2>
        <span class="ofp-tag ofp-tag--amber">সেভ করুন</span>
    </div>

    @if(isset($discountProducts) && $discountProducts->isNotEmpty())

        <div class="ofp-grid">
            @foreach($discountProducts as $item)
                @php
                    $dPrice  = $item->discount_price ?? $item->current_price;
                    $oPrice  = $item->current_price;
                    $disc    = ($item->discount_price && $oPrice > 0)
                               ? round((($oPrice - $item->discount_price) / $oPrice) * 100) : null;
                    $inStock = $item->is_unlimited || (($item->stock ?? 0) > 0);
                @endphp
                <div class="ofp-wrap">

                    {{-- Wishlist (GET is fine here) --}}
                    <a href="{{ route('wishlist.add', $item->id) }}"
                       class="ofp-wish"
                       onclick="event.stopPropagation();event.preventDefault();"
                       title="উইশলিস্টে যোগ করুন">
                        <i class="bi bi-heart"></i>
                    </a>

                    {{-- Product card link --}}
                    <a href="{{ route('product.detail', $item->slug) }}" class="ofp-card">
                        @if($disc)
                            <span class="ofp-disc{{ $disc >= 50 ? ' ofp-disc--gold' : '' }}">-{{ $disc }}%</span>
                        @endif
                        <div class="ofp-img-wrap">
                            <img class="ofp-img"
                                 src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                 alt="{{ $item->name }}"
                                 loading="lazy"
                                 onerror="this.src='{{ asset('default/no-image.png') }}'">
                        </div>
                        <div class="ofp-body">
                            <p class="ofp-name">{{ $item->name }}</p>
                            <p class="ofp-price">৳&nbsp;{{ number_format($dPrice, 0) }}</p>
                            @if($item->discount_price && $item->discount_price < $oPrice)
                                <p class="ofp-old">৳&nbsp;{{ number_format($oPrice, 0) }}</p>
                            @endif
                            <div class="ofp-stars" aria-label="রেটিং">★★★★☆</div>
                            <div class="ofp-spacer"></div>

                            {{-- ✅ FIX: POST form instead of GET link --}}
                            @if($inStock)
                                <form
                                    action="{{ route('cart.add', $item->id) }}"
                                    method="POST"
                                    class="ofp-atc-form"
                                    onclick="event.stopPropagation()">
                                    @csrf
                                    <button type="submit" class="ofp-atc">
                                        <i class="bi bi-cart-plus-fill"></i> কার্টে যোগ করুন
                                    </button>
                                </form>
                            @else
                                <span class="ofp-atc ofp-atc--out">
                                    <i class="bi bi-x-circle"></i> স্টক নেই
                                </span>
                            @endif

                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($discountProducts->hasPages())
            <div class="ofp-pages">
                @if($discountProducts->onFirstPage())
                    <span>‹</span>
                @else
                    <a href="{{ $discountProducts->previousPageUrl() }}">‹</a>
                @endif

                @foreach($discountProducts->links()->elements[0] as $page => $url)
                    @if($page == $discountProducts->currentPage())
                        <span class="is-cur">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($discountProducts->hasMorePages())
                    <a href="{{ $discountProducts->nextPageUrl() }}">›</a>
                @else
                    <span>›</span>
                @endif
            </div>
        @endif

    @else

        <div class="ofp-empty">
            <i class="bi bi-tag"></i>
            <p>এখন কোনো অফার নেই। শীঘ্রই আসছে!</p>
        </div>

    @endif

</div>

@endsection
