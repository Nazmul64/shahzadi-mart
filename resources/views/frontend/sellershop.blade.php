{{-- resources/views/frontend/sellershop.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
.sellershop { margin-top: 15px; }

/* ══ SELLER HERO ══ */
.seller-hero {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    margin-bottom: 25px;
    border: 1px solid #eee;
}
.seller-banner {
    height: 250px;
    background: #f8f9fa;
    position: relative;
    overflow: hidden;
}
.seller-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.seller-profile-wrap {
    padding: 0 40px 30px;
    margin-top: -60px;
    position: relative;
    z-index: 2;
    display: flex;
    align-items: flex-end;
    gap: 25px;
}
.seller-logo-big {
    width: 140px;
    height: 140px;
    background: #fff;
    border-radius: 16px;
    padding: 6px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid #eee;
}
.seller-logo-big img {
    width: 100%;
    height: 100%;
    border-radius: 12px;
    object-fit: cover;
}
.seller-info-big {
    padding-bottom: 15px;
    flex: 1;
}
.seller-name-big {
    font-size: 32px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 8px;
}
.seller-stats-big {
    display: flex;
    gap: 20px;
    font-size: 14px;
    color: #666;
}
.seller-stat-item i { color: var(--primary); margin-right: 5px; }

/* ══ LAYOUT ══ */
.smp-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 24px;
    align-items: start;
}

/* ══ SIDEBAR ══ */
.smp-sidebar { background: #fff; border: 1px solid #eee; border-radius: 14px; padding: 20px; }
.smp-sidebar-title { font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.smp-sidebar-bar { width: 4px; height: 18px; background: var(--primary); border-radius: 2px; }

.smp-filter-sec { margin-bottom: 24px; }
.smp-filter-sec-title { font-size: 12px; font-weight: 700; color: #9a9aaa; text-transform: uppercase; margin-bottom: 12px; }
.smp-cat-list { list-style: none; padding: 0; margin: 0; }
.smp-cat-list li { margin-bottom: 5px; }
.smp-cat-list a { display: flex; justify-content: space-between; padding: 8px 12px; border-radius: 8px; text-decoration: none; color: #2c2c30; font-size: 13.5px; font-weight: 600; transition: all .2s; }
.smp-cat-list a:hover, .smp-cat-list a.active { background: var(--primary-light); color: var(--primary); }

/* ══ GRID ══ */
.smp-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
}

@media (max-width: 1400px) { .smp-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 1100px) { .smp-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 800px) {
    .smp-grid { grid-template-columns: repeat(2, 1fr); }
    .seller-profile-wrap { flex-direction: column; align-items: center; text-align: center; padding: 0 20px 20px; }
    .seller-logo-big { margin-top: 0; }
}
</style>

<div class="sellershop content-area-inner">
    <div class="seller-hero">
        <div class="seller-banner">
            @if($seller->store_banner)
                <img src="{{ asset($seller->store_banner) }}" alt="{{ $seller->store_name }}">
            @else
                <div style="width:100%; height:100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
            @endif
        </div>
        <div class="seller-profile-wrap">
            <div class="seller-logo-big">
                <img src="{{ $seller->store_logo ? asset($seller->store_logo) : 'https://ui-avatars.com/api/?name='.$seller->store_name.'&background=fff&color=ff3e6c' }}" alt="Logo">
            </div>
            <div class="seller-info-big">
                <h1 class="seller-name-big">{{ $seller->store_name }}</h1>
                <div class="seller-stats-big">
                    <span class="seller-stat-item"><i class="bi bi-box-seam"></i> {{ $products->total() }} Products</span>
                    <span class="seller-stat-item"><i class="bi bi-star-fill text-warning"></i> {{ number_format($seller->avg_rating ?? 5.0, 1) }} Shop Rating</span>
                    <span class="seller-stat-item"><i class="bi bi-calendar3"></i> Joined {{ $seller->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="smp-layout-full">
        <main>
            <div class="smp-grid">
                @foreach($products as $index => $item)
                    @php
                        $displayPrice  = $item->discount_price ?? $item->current_price;
                        $originalPrice = $item->current_price;
                        $discount      = ($item->discount_price && $item->current_price > 0)
                            ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                        $inStock = $item->is_unlimited || ($item->stock ?? 0) > 0;
                        $revAvg   = $item->reviews_avg_rating ?? 5.0;
                        $revCount = $item->reviews_count ?? 0;
                    @endphp
                    <div class="smhome-p-item" style="position:relative">
                        <a href="{{ route('wishlist.add', $item->id) }}" class="smhome-p-wish" title="Add to wishlist"><i class="bi bi-heart"></i></a>
                        <div class="smhome-p-card" onclick="window.location='{{ route('product.detail', $item->slug) }}'">
                            @if($discount)
                                <span class="smhome-p-badge">-{{ $discount }}%</span>
                            @endif
                            <div class="smhome-p-img-wrap">
                                <img class="smhome-p-img" src="{{ asset('uploads/products/'.$item->feature_image) }}" alt="{{ $item->name }}" loading="lazy">
                            </div>
                            <div class="smhome-p-body">
                                <p class="smhome-p-name">{{ $item->name }}</p>
                                <div class="smhome-p-price-row">
                                    <p class="smhome-p-price">৳ {{ number_format($displayPrice, 0) }}</p>
                                    @if($displayPrice < $originalPrice)
                                        <p class="smhome-p-old">৳ {{ number_format($originalPrice, 0) }}</p>
                                    @endif
                                </div>
                                <div class="smhome-p-meta">
                                    <div class="smhome-p-stars-row">
                                        @for($s=1;$s<=5;$s++)
                                            <i class="bi bi-star{{ $s <= round($revAvg) ? '-fill' : '' }} sm-star filled"></i>
                                        @endfor
                                        <span class="smhome-p-rc">({{ $revCount }})</span>
                                    </div>
                                </div>
                                @if($inStock)
                                    <form action="{{ route('cart.add', $item->id) }}" method="POST" class="smhome-order-form" onclick="event.stopPropagation()">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="redirect_to_checkout" value="1">
                                        <button type="submit" class="smhome-p-order-btn">অর্ডার করুন</button>
                                    </form>
                                @else
                                    <span class="smhome-p-order-btn smhome-p-order-btn--out">স্টক নেই</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </main>
    </div>
</div>

@endsection
