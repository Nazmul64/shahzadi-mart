{{-- resources/views/frontend/new-arrivals.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
.na-page { padding: 4px 0; margin-top: 15px; }

/* ══ HERO ══ */
.na-hero {
    background: linear-gradient(135deg, #0e0e0f 0%, #2c2c30 100%);
    border-radius: 20px; padding: 40px; margin-bottom: 25px; color: #fff;
    display: flex; justify-content: space-between; align-items: center; overflow: hidden; position: relative;
}
.na-hero::after {
    content: ''; position: absolute; right: -20px; top: -20px; width: 150px; height: 150px;
    border-radius: 50%; border: 30px solid rgba(255,255,255,.03);
}
.na-hero__title { font-size: 32px; font-weight: 900; margin-bottom: 8px; }
.na-hero__title span { color: #d0152b; }
.na-hero__sub { color: rgba(255,255,255,.6); font-size: 14px; }

/* ══ FILTERS ══ */
.na-filters { display: flex; gap: 10px; margin-bottom: 25px; flex-wrap: wrap; }
.na-filter-chip { padding: 8px 20px; border-radius: 30px; background: #fff; border: 1.5px solid #e8e8ef; text-decoration: none; color: #5a5a65; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 8px; transition: all .2s; }
.na-filter-chip.is-active { background: #d0152b; border-color: #d0152b; color: #fff; }

/* ══ GRID (5 Columns) ══ */
.na-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
    margin-bottom: 28px;
}

.na-card {
    background: #fff; border: 1.5px solid #e8e8ef; border-radius: 16px; overflow: hidden;
    transition: all .3s; display: flex; flex-direction: column; height: 100%; position: relative;
}
.na-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,.08); border-color: #d0152b44; }

/* Badges handled globally in custom-style.css */

.na-img { width: 100%; height: 280px; object-fit: cover; border-bottom: 1.5px solid #e8e8ef; transition: transform .5s; display: block; }
.na-card:hover .na-img { transform: scale(1.06); }
.na-img-wrap { overflow: hidden; position: relative; }

.na-body { padding: 14px; display: flex; flex-direction: column; flex: 1; }
.na-name { font-size: 18px; font-weight: 800; color: #2c2c30; line-height: 1.4; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 48px; text-decoration: none; }
.na-price { font-size: 22px; font-weight: 900; color: #d0152b; }
.na-old { font-size: 13.5px; color: #9a9aaa; text-decoration: line-through; margin-left: 8px; }

.na-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; padding: 11px 0; background: #d0152b;
    color: #fff; border-radius: 10px; font-size: 12.5px; font-weight: 700; text-decoration: none; margin-top: auto;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 1700px) { .na-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 1400px) { .na-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 1100px) { .na-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; } }
@media (max-width: 900px) {
    .na-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .na-img { height: 220px; }
}
@media (max-width: 500px) {
    .na-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .na-img { height: 180px; }
}
</style>

<div class="na-page content-area-inner">
    <div class="na-hero">
        <div class="na-hero__left">
            <h1 class="na-hero__title">নতুন <span>পণ্য</span> এসেছ!</h1>
            <p class="na-hero__sub">সদ্য যোগ হওয়া সব নতুন পণ্য এখানে দেখুন</p>
        </div>
        <div class="na-hero-count">
            <span style="font-size:36px; font-weight:900; display:block; color:#d0152b;">{{ $newArrivals->total() }}</span>
            <span style="font-size:12px; text-transform:uppercase; opacity:.6;">টি পণ্য</span>
        </div>
    </div>

    <div class="na-filters">
        <a href="{{ url('new-arrivals') }}" class="na-filter-chip {{ !request('when') ? 'is-active' : '' }}">সব পণ্য</a>
        <a href="{{ url('new-arrivals?when=week') }}" class="na-filter-chip {{ request('when') === 'week' ? 'is-active' : '' }}">এই সপ্তাহ</a>
        <a href="{{ url('new-arrivals?when=month') }}" class="na-filter-chip {{ request('when') === 'month' ? 'is-active' : '' }}">এই মাস</a>
    </div>

    @if($newArrivals->isNotEmpty())
        <div class="na-grid">
            @foreach($newArrivals as $item)
                @php
                    $displayPrice = $item->discount_price ?? $item->current_price;
                    $discount = ($item->discount_price && $item->current_price > 0 && $item->discount_price < $item->current_price) ? round((($item->current_price - $item->discount_price)/$item->current_price)*100) : null;
                @endphp
                <div class="na-card" onclick="window.location='{{ route('product.detail', $item->slug) }}'" style="cursor:pointer;">
                    <span class="na-badge-new">NEW</span>
                    @if($discount) <span class="na-badge-disc">-{{ $discount }}%</span> @endif
                    <div class="na-img-wrap"><img class="na-img" src="{{ asset('uploads/products/' . $item->feature_image) }}" alt="{{ $item->name }}" loading="lazy"></div>
                    <div class="na-body">
                        <a href="{{ route('product.detail', $item->slug) }}" class="na-name" onclick="event.stopPropagation()">{{ $item->name }}</a>
                        <div style="margin-bottom:10px;">
                            <span class="na-price">৳ {{ number_format($displayPrice, 0) }}</span>
                            @if($item->discount_price) <span class="na-old">৳ {{ number_format($item->current_price, 0) }}</span> @endif
                        </div>
                        <form action="{{ route('cart.add', $item->id) }}" method="POST" onclick="event.stopPropagation()">
                            @csrf
                            <button type="submit" class="na-atc" style="border:none; width:100%;">কার্টে যোগ করুন</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="display:flex; justify-content:center;">{{ $newArrivals->links() }}</div>
    @else
        <div style="text-align:center; padding:60px 20px; background:#fff; border-radius:14px; border:1.5px solid #e8e8ef;">
            <i class="bi bi-box-seam" style="font-size:48px; color:#d1d5db; display:block; margin-bottom:15px;"></i>
            <p>এখন কোনো নতুন পণ্য নেই। শীঘ্রই আসছে!</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // ── Tracking for New Arrivals Page ──
    (function() {
        if (typeof dataLayer !== 'undefined') {
            dataLayer.push({
                'event': 'view_item_list',
                'ecommerce': {
                    'currency': 'BDT',
                    'item_list_name': 'New Arrivals',
                    'items': [
                        @foreach($newArrivals as $i => $item)
                        {
                            'item_name': '{{ addslashes($item->name) }}',
                            'item_id': '{{ $item->id }}',
                            'price': {{ (float)($item->discount_price ?? $item->current_price) }},
                            'index': {{ $i + 1 }}
                        },
                        @endforeach
                    ]
                }
            });
        }
    })();
</script>
@endpush

@endsection
