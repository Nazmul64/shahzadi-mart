{{-- resources/views/frontend/allproducts.blade.php --}}
@extends('frontend.master')

@section('main-content')

<div class="smp-allprod content-area-inner">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;padding:10px 18px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;margin-bottom:12px;border-radius:8px;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fff0f1;color:#e8192c;border:1px solid #fecdd3;padding:10px 18px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;margin-bottom:12px;border-radius:8px;">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Breadcrumb --}}
    <div class="smp-allprod-bc">
        <a href="{{ url('/') }}"><i class="bi bi-house-fill"></i> হোম</a>
        <span>/</span>
        <span class="current">সব পণ্য</span>
    </div>

    {{-- Hero Header --}}
    <div class="smp-allprod-hero">
        <div class="smp-allprod-hero-text">
            <h1>সব পণ্য</h1>
            <p>আমাদের সম্পূর্ণ পণ্য সংগ্রহ দেখুন</p>
        </div>
        <div class="smp-allprod-hero-count">
            {{ $products->total() }}
            <span>টি পণ্য পাওয়া গেছে</span>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="smp-allprod-toolbar">
        <div class="smp-allprod-toolbar-left">
            <span class="smp-allprod-sort-label">সাজান:</span>
            <form method="GET" action="{{ url('all-products') }}" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('min_price'))
                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                @endif
                @if(request('max_price'))
                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                @endif
                @if(request('in_stock'))
                    <input type="hidden" name="in_stock" value="{{ request('in_stock') }}">
                @endif
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <select name="sort" class="smp-allprod-select" onchange="this.form.submit()">
                    <option value="latest"     {{ request('sort','latest') == 'latest'     ? 'selected' : '' }}>সর্বশেষ</option>
                    <option value="price_low"  {{ request('sort') == 'price_low'  ? 'selected' : '' }}>দাম: কম → বেশি</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>দাম: বেশি → কম</option>
                    <option value="name_asc"   {{ request('sort') == 'name_asc'   ? 'selected' : '' }}>নাম: A → Z</option>
                    <option value="discount"   {{ request('sort') == 'discount'   ? 'selected' : '' }}>সর্বোচ্চ ছাড়</option>
                </select>
            </form>
        </div>

        <div class="smp-allprod-view-btns">
            <span class="smp-allprod-view-btn active" title="Grid view">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </span>
        </div>
    </div>

    {{-- Main Layout --}}
    <div class="smp-allprod-layout">

        {{-- Sidebar Filters --}}
        <aside class="smp-allprod-sidebar">
            <div class="smp-allprod-sidebar-title">ফিল্টার করুন</div>

            <form method="GET" action="{{ url('all-products') }}" id="filterForm">
                <input type="hidden" name="sort" value="{{ request('sort','latest') }}">

                {{-- Categories --}}
                @if($categories->isNotEmpty())
                <div class="smp-allprod-filter-sec">
                    <h4>ক্যাটাগরি</h4>
                    <ul class="smp-allprod-cat-list">
                        <li>
                            <a href="{{ url('all-products') }}?sort={{ request('sort','latest') }}"
                               class="{{ !request('category') ? 'active' : '' }}">
                                সব ক্যাটাগরি
                                <span class="smp-allprod-cat-count">{{ $products->total() }}</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ url('all-products') }}?category={{ $cat->slug }}&sort={{ request('sort','latest') }}"
                                   class="{{ request('category') == $cat->slug ? 'active' : '' }}">
                                    {{ $cat->category_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Price Range --}}
                <div class="smp-allprod-filter-sec">
                    <h4>দামের সীমা</h4>
                    <div class="smp-allprod-price-inputs">
                        <input type="number" name="min_price" placeholder="সর্বনিম্ন"
                               class="smp-allprod-price-input"
                               value="{{ request('min_price') }}">
                        <span class="smp-allprod-price-sep">—</span>
                        <input type="number" name="max_price" placeholder="সর্বোচ্চ"
                               class="smp-allprod-price-input"
                               value="{{ request('max_price') }}">
                    </div>
                    <button type="submit" class="smp-allprod-apply-btn">
                        <i class="bi bi-funnel-fill"></i> ফিল্টার প্রয়োগ করুন
                    </button>
                </div>

                {{-- Stock --}}
                <div class="smp-allprod-filter-sec">
                    <h4>স্টক</h4>
                    <div class="smp-allprod-check-list">
                        <label>
                            <input type="checkbox" name="in_stock" value="1"
                                   {{ request('in_stock') ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            শুধু স্টকে আছে এমন পণ্য
                        </label>
                    </div>
                </div>

                {{-- Search --}}
                <div class="smp-allprod-filter-sec">
                    <h4>পণ্য খুঁজুন</h4>
                    <div style="display:flex;gap:6px;">
                        <input type="text" name="search" placeholder="পণ্যের নাম..."
                               class="smp-allprod-price-input"
                               value="{{ request('search') }}"
                               style="flex:1">
                        <button type="submit" style="padding:7px 12px;background:var(--red);color:#fff;border:none;border-radius:7px;cursor:pointer;font-size:14px;">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                {{-- Reset --}}
                <a href="{{ url('all-products') }}"
                   style="display:flex;align-items:center;justify-content:center;gap:6px;font-size:12.5px;font-weight:700;color:var(--muted);text-decoration:none;margin-top:4px;transition:color .2s;"
                   onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--muted)'">
                    <i class="bi bi-arrow-counterclockwise"></i> ফিল্টার রিসেট করুন
                </a>
            </form>
        </aside>

        {{-- Products --}}
        <div>
            <div class="smp-allprod-grid">
                @forelse($products as $item)
                    @php
                        $displayPrice  = $item->discount_price ?? $item->current_price;
                        $originalPrice = $item->current_price;
                        $discount = ($displayPrice < $originalPrice && $originalPrice > 0)
                            ? round((($originalPrice - $displayPrice) / $originalPrice) * 100)
                            : null;
                        $inStock = $item->is_unlimited || ($item->stock ?? 0) > 0;
                    @endphp

                    <div style="position:relative">
                        <a href="{{ route('wishlist.add', $item->id) }}"
                           class="smp-ap-wish"
                           title="উইশলিস্টে যোগ করুন"
                           onclick="event.stopPropagation()">
                            <i class="bi bi-heart"></i>
                        </a>

                        <a href="{{ route('product.detail', $item->slug) }}"
                           class="smp-ap-card-link">
                            <div class="smp-ap-card">
                                @if($discount)
                                    <span class="smp-ap-badge">-{{ $discount }}%</span>
                                @elseif($item->is_new_arrival)
                                    <span class="smp-ap-new-badge">NEW</span>
                                @endif

                                <div class="smp-ap-img-wrap">
                                    <img class="smp-ap-img"
                                         src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                         alt="{{ $item->name }}" loading="lazy">
                                </div>
                                <div class="smp-ap-body">
                                    <p class="smp-ap-name">{{ $item->name }}</p>
                                    <p class="smp-ap-price">৳ {{ number_format($displayPrice, 0) }}</p>
                                    @if($displayPrice < $originalPrice)
                                        <p class="smp-ap-old">৳ {{ number_format($originalPrice, 0) }}</p>
                                    @endif
                                    <div class="smp-ap-meta">
                                        @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10 && $item->stock > 0)
                                            <p class="smp-ap-stock">
                                                <i class="fas fa-fire-flame-curved" style="font-size:10px"></i>
                                                {{ $item->stock }} টি বাকি
                                            </p>
                                        @endif
                                        <span class="smp-ap-stars">★★★★☆</span>
                                    </div>

                                    @if($inStock)
                                        <a href="{{ route('cart.add', $item->id) }}"
                                           class="smp-ap-atc"
                                           onclick="event.stopPropagation()">
                                            <i class="fa-solid fa-cart-plus"></i> কার্টে যোগ করুন
                                        </a>
                                    @else
                                        <span class="smp-ap-atc"
                                              style="background:#e5e7eb;color:#9ca3af;cursor:not-allowed;">
                                            <i class="fas fa-times-circle"></i> স্টক নেই
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>

                @empty
                    <div class="smp-allprod-empty">
                        <div class="smp-allprod-empty-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <h3>কোনো পণ্য পাওয়া যায়নি</h3>
                        <p>আপনার ফিল্টার পরিবর্তন করে আবার চেষ্টা করুন</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="smp-allprod-pagination">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>{{-- /.smp-allprod-layout --}}

</div>{{-- /.smp-allprod --}}

@endsection
