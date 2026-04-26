{{-- resources/views/frontend/shop.blade.php --}}
@extends('frontend.master')

@section('main-content')

<div class="smp-shop content-area-inner">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="smp-flash smp-flash--success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="smp-flash smp-flash--error">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Breadcrumb --}}
    <nav class="smp-breadcrumb" aria-label="breadcrumb">
        <a href="{{ url('/') }}"><i class="bi bi-house-fill"></i> হোম</a>
        <span>/</span>
        <span class="current" aria-current="page">শপ</span>
    </nav>

    {{-- Hero --}}
    <div class="smp-hero">
        <div class="smp-hero-grid"></div>
        <div class="smp-hero-text">
            <h1>আমাদের শপ</h1>
            <p>প্রিমিয়াম কোয়ালিটির সকল পণ্য এক ছাদের নিচে</p>
        </div>
        <div class="smp-hero-count">
            <span class="smp-hero-count-num">{{ $products->total() }}</span>
            <span class="smp-hero-count-label">টি পণ্য পাওয়া গেছে</span>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="smp-toolbar">
        <div class="smp-toolbar-left">
            <span class="smp-toolbar-label">সাজানো:</span>
            <form method="GET" action="{{ url('shop') }}" id="smpSortForm">
                @foreach(['category','search','min_price','max_price'] as $param)
                    @if(request($param))
                        <input type="hidden" name="{{ $param }}" value="{{ request($param) }}">
                    @endif
                @endforeach
                <select name="sort" class="smp-sort-select" onchange="this.form.submit()" aria-label="পণ্য সাজানো">
                    @php
                        $sorts = [
                            'latest'     => 'সর্বশেষ যোগ হয়েছে',
                            'price_low'  => 'দাম: কম → বেশি',
                            'price_high' => 'দাম: বেশি → কম',
                            'name_asc'   => 'নাম (A → Z)',
                            'discount'   => 'সর্বোচ্চ ছাড়',
                        ];
                        $currentSort = request('sort', 'latest');
                    @endphp
                    @foreach($sorts as $val => $label)
                        <option value="{{ $val }}" {{ $currentSort === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="smp-toolbar-info">
            {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}
            <span style="color:#d1d5db;">of</span>
            {{ $products->total() }} পণ্য
        </div>
    </div>

    {{-- Layout --}}
    <div class="smp-layout">

        {{-- Sidebar --}}
        <aside class="smp-sidebar" aria-label="ফিল্টার প্যানেল">
            <div class="smp-sidebar-title">
                <div class="smp-sidebar-bar"></div>
                <i class="bi bi-sliders2-vertical"></i>
                ফিল্টার
            </div>

            <form method="GET" action="{{ url('shop') }}" id="smpFilterForm">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                {{-- Categories --}}
                @if(isset($categories) && $categories->isNotEmpty())
                <div class="smp-filter-sec">
                    <div class="smp-filter-sec-title">ক্যাটাগরি</div>
                    <ul class="smp-cat-list">
                        <li>
                            <a href="{{ url('shop') }}{{ request('sort') ? '?sort='.request('sort') : '' }}"
                               class="{{ !request('category') ? 'active' : '' }}">
                                <span>সব পণ্য</span>
                                <span class="smp-cat-count">{{ $products->total() }}</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ url('shop') }}?category={{ $cat->slug }}{{ request('sort') ? '&sort='.request('sort') : '' }}"
                               class="{{ request('category') === $cat->slug ? 'active' : '' }}">
                                <span>{{ $cat->category_name }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Price Range --}}
                <div class="smp-filter-sec">
                    <div class="smp-filter-sec-title">দামের রেঞ্জ</div>
                    <div class="smp-price-row">
                        <input type="number"
                               name="min_price"
                               class="smp-price-input"
                               placeholder="সর্বনিম্ন"
                               value="{{ request('min_price') }}"
                               min="0"
                               aria-label="সর্বনিম্ন দাম">
                        <span class="smp-price-sep">–</span>
                        <input type="number"
                               name="max_price"
                               class="smp-price-input"
                               placeholder="সর্বোচ্চ"
                               value="{{ request('max_price') }}"
                               min="0"
                               aria-label="সর্বোচ্চ দাম">
                    </div>
                    <button type="submit" class="smp-apply-btn">
                        <i class="bi bi-funnel-fill"></i> ফিল্টার প্রয়োগ করুন
                    </button>
                </div>

                {{-- Search --}}
                <div class="smp-filter-sec">
                    <div class="smp-filter-sec-title">পণ্য খুঁজুন</div>
                    <div class="smp-search-row">
                        <input type="text"
                               name="search"
                               class="smp-search-input"
                               placeholder="নাম বা কীওয়ার্ড..."
                               value="{{ request('search') }}"
                               aria-label="পণ্য সার্চ">
                        <button type="submit" class="smp-search-btn" aria-label="সার্চ করুন">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                {{-- Reset --}}
                <a href="{{ url('shop') }}" class="smp-reset-link">
                    <i class="bi bi-arrow-counterclockwise"></i> সব ফিল্টার রিসেট
                </a>
            </form>
        </aside>

        {{-- Products --}}
        <main>
            <div class="smp-grid">
                @forelse($products as $item)
                    @php
                        $displayPrice  = $item->discount_price ?? $item->current_price;
                        $originalPrice = $item->current_price;
                        $hasDiscount   = $displayPrice < $originalPrice && $originalPrice > 0;
                        $discountPct   = $hasDiscount
                            ? round((($originalPrice - $displayPrice) / $originalPrice) * 100)
                            : null;
                        $inStock  = $item->is_unlimited || (($item->stock ?? 0) > 0);
                        $lowStock = !$item->is_unlimited && isset($item->stock) && $item->stock > 0 && $item->stock <= 8;
                    @endphp

                    {{-- Card Wrapper --}}
                    <div class="smp-card-wrap">

                        {{-- Discount / New Badge --}}
                        @if($discountPct)
                            <span class="smp-badge smp-badge--discount">-{{ $discountPct }}% OFF</span>
                        @elseif(!empty($item->is_new_arrival))
                            <span class="smp-badge smp-badge--new">NEW</span>
                        @endif

                        {{-- Wishlist Button (GET — intentional) --}}
                        <a href="{{ route('wishlist.add', $item->id) }}"
                           class="smp-wish-btn"
                           title="উইশলিস্টে যোগ করুন"
                           aria-label="উইশলিস্টে যোগ করুন"
                           onclick="event.stopPropagation()">
                            <i class="bi bi-heart"></i>
                        </a>

                        {{-- Card (div — avoids nested <a> bug) --}}
                        <div class="smp-card"
                             onclick="window.location='{{ route('product.detail', $item->slug) }}'"
                             role="article"
                             aria-label="{{ $item->name }}">

                            {{-- Product Image --}}
                            <a href="{{ route('product.detail', $item->slug) }}"
                               class="smp-img-wrap"
                               tabindex="-1"
                               aria-hidden="true">
                                <img class="smp-img"
                                     src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                     alt="{{ $item->name }}"
                                     loading="lazy"
                                     width="300"
                                     height="180">
                            </a>

                            {{-- Card Body --}}
                            <div class="smp-card-body">

                                {{-- Product Name --}}
                                <a href="{{ route('product.detail', $item->slug) }}"
                                   class="smp-card-name"
                                   onclick="event.stopPropagation()">
                                    {{ $item->name }}
                                </a>

                                {{-- Current Price --}}
                                <p class="smp-card-price">৳&nbsp;{{ number_format($displayPrice, 0) }}</p>

                                {{-- Original Price --}}
                                @if($hasDiscount)
                                    <p class="smp-card-old">৳&nbsp;{{ number_format($originalPrice, 0) }}</p>
                                @endif

                                {{-- Meta --}}
                                <div class="smp-card-meta">
                                    @if($lowStock)
                                        <p class="smp-card-stock-warn">
                                            <i class="fas fa-fire"></i>
                                            মাত্র {{ $item->stock }}টি বাকি
                                        </p>
                                    @endif
                                    <span class="smp-card-stars" aria-label="রেটিং ৪/৫">★★★★☆</span>
                                </div>

                                {{-- ✅ FIX: POST form instead of GET <a> link --}}
                                @if($inStock)
                                    <form
                                        action="{{ route('cart.add', $item->id) }}"
                                        method="POST"
                                        class="smp-atc-form"
                                        onclick="event.stopPropagation()">
                                        @csrf
                                        <button type="submit"
                                                class="smp-atc-btn smp-atc-btn--active"
                                                aria-label="{{ $item->name }} কার্টে যোগ করুন">
                                            <i class="fas fa-shopping-cart"></i>
                                            কার্টে যোগ করুন
                                        </button>
                                    </form>
                                @else
                                    <span class="smp-atc-btn smp-atc-btn--disabled"
                                          aria-label="স্টক আউট">
                                        <i class="fas fa-times-circle"></i>
                                        স্টক আউট
                                    </span>
                                @endif

                            </div>{{-- /.smp-card-body --}}
                        </div>{{-- /.smp-card --}}
                    </div>{{-- /.smp-card-wrap --}}

                @empty
                    <div class="smp-empty">
                        <span class="smp-empty-icon" aria-hidden="true">🛍️</span>
                        <h3>কোনো পণ্য মিলেনি</h3>
                        <p>ফিল্টার পরিবর্তন করে আবার চেষ্টা করুন</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="smp-pagination">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </main>

    </div>{{-- /.smp-layout --}}
</div>{{-- /.smp-shop --}}

@endsection
