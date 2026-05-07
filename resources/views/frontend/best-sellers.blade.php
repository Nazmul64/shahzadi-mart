{{-- resources/views/frontend/best-sellers.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
.smp-allprod { margin-top: 15px; }

/* ══ HERO ══ */
.smp-hero {
    background: linear-gradient(135deg, #1a1a1a 0%, #d0152b 100%);
    border-radius: 20px; padding: 40px; margin-bottom: 25px; color: #fff;
    display: flex; justify-content: space-between; align-items: center; overflow: hidden; position: relative;
}
.smp-hero::after {
    content: ''; position: absolute; right: -20px; top: -20px; width: 150px; height: 150px;
    border-radius: 50%; border: 30px solid rgba(255,255,255,.03);
}
.smp-hero-text h1 { font-size: 32px; font-weight: 900; margin-bottom: 8px; }
.smp-hero-text p { color: rgba(255,255,255,.8); font-size: 14px; }
.smp-hero-count { text-align: right; }
.smp-hero-count-num { display: block; font-size: 36px; font-weight: 900; color: #ffcc00; }
.smp-hero-count-label { font-size: 12px; color: rgba(255,255,255,.7); text-transform: uppercase; letter-spacing: 1px; }

/* ══ GRID (5 Columns) ══ */
.smp-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
    margin-bottom: 30px;
}

/* ══ CARD ══ */
.smp-card-wrap { position: relative; }
.smp-card {
    background: #fff; border: 1.5px solid #e8e8ef; border-radius: 16px; overflow: hidden;
    transition: all .3s; display: flex; flex-direction: column; height: 100%;
}
.smp-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,.08); border-color: #d0152b44; }

.smp-badge { position: absolute; top: 12px; left: 12px; z-index: 2; padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 800; color: #222; background: #ffcc00; }

.smp-wish-btn { 
    position: absolute; top: 12px; right: 12px; z-index: 10; width: 36px; height: 36px; 
    background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; 
    box-shadow: 0 4px 12px rgba(0,0,0,.15); color: #be0318; text-decoration: none; transition: all .2s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
}
.smp-wish-btn:hover { transform: scale(1.15); background: #be0318; color: #fff; }

.smp-img { width: 100%; height: 280px; object-fit: cover; border-bottom: 1.5px solid #e8e8ef; transition: transform .5s; }
.smp-card:hover .smp-img { transform: scale(1.06); }

.smp-card-body { padding: 14px; display: flex; flex-direction: column; flex: 1; }
.smp-card-name { font-size: 18px; font-weight: 800; color: #2c2c30; text-decoration: none; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 48px; line-height: 1.35; }
.smp-card-price { font-size: 22px; font-weight: 900; color: #d0152b; margin-bottom: 4px; }
.smp-card-old { font-size: 13.5px; color: #9a9aaa; text-decoration: line-through; margin-bottom: 12px; }
.smp-atc-btn { width: 100%; padding: 11px; border: none; border-radius: 10px; font-weight: 700; font-size: 12.5px; cursor: pointer; transition: all .2s; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; }
.smp-atc-btn--active { background: #d0152b; color: #fff; }

/* ══ RESPONSIVE ══ */
@media (max-width: 1700px) { .smp-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 1400px) { .smp-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 1100px) { .smp-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 900px) {
    .smp-hero { padding: 25px; }
    .smp-hero-text h1 { font-size: 24px; }
    .smp-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .smp-img { height: 220px; }
}
@media (max-width: 500px) {
    .smp-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .smp-img { height: 180px; }
}
</style>

<div class="smp-allprod content-area-inner">
    <div class="smp-hero">
        <div class="smp-hero-text">
            <h1>বেস্ট সেলার</h1>
            <p>আমাদের সবচেয়ে জনপ্রিয় পণ্যগুলো দেখুন</p>
        </div>
        <div class="smp-hero-count">
            <span class="smp-hero-count-num">{{ $products->total() }}</span>
            <span class="smp-hero-count-label">টি পণ্য</span>
        </div>
    </div>

    <div class="smp-grid">
        @foreach($products as $item)
            @php
                $displayPrice  = $item->discount_price ?? $item->current_price;
                $originalPrice = $item->current_price;
                $discount      = ($displayPrice < $originalPrice && $originalPrice > 0)
                    ? round((($originalPrice - $displayPrice) / $originalPrice) * 100) : null;
            @endphp
            <div class="smp-card-wrap">
                <div class="smp-card">
                    <a href="{{ route('wishlist.add', $item->id) }}" class="smp-wish-btn" title="উইশলিস্টে যোগ করুন">
                        <i class="bi bi-heart"></i>
                    </a>
                    <span class="smp-badge">BEST SELLER</span>
                    <div class="smp-img-wrap" onclick="window.location='{{ route('product.detail', $item->slug) }}'" style="cursor:pointer;">
                        <img class="smp-img" src="{{ asset('uploads/products/' . $item->feature_image) }}" alt="{{ $item->name }}" loading="lazy">
                    </div>
                    <div class="smp-card-body">
                        <a href="{{ route('product.detail', $item->slug) }}" class="smp-card-name">{{ $item->name }}</a>
                        <p class="smp-card-price">৳ {{ number_format($displayPrice, 0) }}</p>
                        @if($displayPrice < $originalPrice)
                            <p class="smp-card-old">৳ {{ number_format($originalPrice, 0) }}</p>
                        @endif
                        <form action="{{ route('cart.add', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="smp-atc-btn smp-atc-btn--active">অর্ডার করুন</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div style="display:flex; justify-content:center; margin-bottom:40px;">
        {{ $products->links() }}
    </div>
</div>

@endsection
