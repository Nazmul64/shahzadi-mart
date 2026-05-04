{{-- resources/views/frontend/search_results.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
.search-results-wrap { padding: 4px 0; margin-top: 15px; }
.sr-header {
    background: #fff; border: 1.5px solid #e8e8ef; border-radius: 14px; padding: 18px 22px; margin-bottom: 20px;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.05);
}
.sr-header h1 { font-size: 19px; font-weight: 800; color: #0e0e0f; display: flex; align-items: center; gap: 8px; }
.sr-header h1 i { color: #d0152b; }
.sr-meta { font-size: 13px; color: #9a9aaa; }
.sr-meta strong { color: #d0152b; }

/* ══ GRID (5 Columns) ══ */
.sr-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
    margin-bottom: 28px;
}

.sr-card {
    background: #fff; border: 1.5px solid #e8e8ef; border-radius: 16px; overflow: hidden;
    transition: all .3s; display: flex; flex-direction: column; height: 100%; position: relative;
}
.sr-card:hover { box-shadow: 0 20px 40px rgba(0,0,0,.08); transform: translateY(-5px); border-color: #d0152b44; }

.sr-badge {
    position: absolute; top: 11px; left: 11px; background: #d0152b; color: #fff;
    font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; z-index: 2;
}

.sr-p-img { width: 100%; height: 280px; object-fit: cover; border-bottom: 1.5px solid #e8e8ef; transition: transform .5s; display: block; }
.sr-card:hover .sr-p-img { transform: scale(1.06); }
.sr-p-img-wrap { overflow: hidden; position: relative; }

.sr-p-body { padding: 14px; display: flex; flex-direction: column; flex: 1; }
.sr-p-name { font-size: 18px; font-weight: 800; color: #2c2c30; line-height: 1.4; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 48px; text-decoration: none; }
.sr-p-price { font-size: 22px; font-weight: 900; color: #d0152b; margin-bottom: 4px; }
.sr-p-old { font-size: 13.5px; color: #9a9aaa; text-decoration: line-through; margin-bottom: 12px; }

.sr-p-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; padding: 11px 0; background: #d0152b;
    color: #fff; border-radius: 10px; font-size: 12.5px; font-weight: 700; text-decoration: none; margin-top: auto;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 1700px) { .sr-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 1400px) { .sr-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 1100px) { .sr-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; } }
@media (max-width: 900px) {
    .sr-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .sr-p-img { height: 220px; }
}
@media (max-width: 500px) {
    .sr-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .sr-p-img { height: 180px; }
}
</style>

<div class="search-results-wrap content-area-inner">
    <div class="sr-header">
        <h1><i class="bi bi-search"></i> @if($q) "{{ $q }}" এর ফলাফল @else সার্চ ফলাফল @endif</h1>
        @if($q && $products->total() > 0)
            <span class="sr-meta">মোট <strong>{{ $products->total() }}</strong> টি পণ্য পাওয়া গেছে</span>
        @endif
    </div>

    @if(!$q)
        <div style="text-align:center; padding:60px 20px; background:#fff; border-radius:14px; border:1.5px solid #e8e8ef;">
            <i class="bi bi-search" style="font-size:48px; color:#d1d5db; display:block; margin-bottom:15px;"></i>
            <h3>কী খুঁজছেন?</h3>
            <p style="color:#9a9aaa; margin-bottom:20px;">উপরের সার্চ বক্সে পণ্যের নাম লিখুন।</p>
            <a href="{{ url('/') }}" style="display:inline-flex; align-items:center; gap:8px; background:#d0152b; color:#fff; padding:10px 25px; border-radius:30px; font-weight:700; text-decoration:none;">হোম পেজে যান</a>
        </div>
    @elseif($products->isEmpty())
        <div style="text-align:center; padding:60px 20px; background:#fff; border-radius:14px; border:1.5px solid #e8e8ef;">
            <i class="bi bi-emoji-frown" style="font-size:48px; color:#d1d5db; display:block; margin-bottom:15px;"></i>
            <h3>"{{ $q }}" পাওয়া যায়নি</h3>
            <p style="color:#9a9aaa; margin-bottom:20px;">অন্য কোনো কীওয়ার্ড দিয়ে আবার চেষ্টা করুন।</p>
            <a href="{{ url('shop') }}" style="display:inline-flex; align-items:center; gap:8px; background:#d0152b; color:#fff; padding:10px 25px; border-radius:30px; font-weight:700; text-decoration:none;">সব পণ্য দেখুন</a>
        </div>
    @else
        <div class="sr-grid">
            @foreach ($products as $item)
                @php
                    $displayPrice = $item->discount_price ?? $item->current_price;
                    $discount = ($item->discount_price && $item->current_price > 0) ? round((($item->current_price - $item->discount_price)/$item->current_price)*100) : null;
                @endphp
                <div class="sr-card" onclick="window.location='{{ route('product.detail', $item->slug) }}'" style="cursor:pointer;">
                    @if($discount) <span class="sr-badge">-{{ $discount }}%</span> @endif
                    <div class="sr-p-img-wrap"><img class="sr-p-img" src="{{ asset('uploads/products/' . $item->feature_image) }}" alt="{{ $item->name }}" loading="lazy"></div>
                    <div class="sr-p-body">
                        <a href="{{ route('product.detail', $item->slug) }}" class="sr-p-name" onclick="event.stopPropagation()">{{ $item->name }}</a>
                        <p class="sr-p-price">৳ {{ number_format($displayPrice, 0) }}</p>
                        @if($item->discount_price) <p class="sr-p-old">৳ {{ number_format($item->current_price, 0) }}</p> @endif
                        <form action="{{ route('cart.add', $item->id) }}" method="POST" onclick="event.stopPropagation()">
                            @csrf
                            <button type="submit" class="sr-p-atc" style="border:none; width:100%;">কার্টে যোগ করুন</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="display:flex; justify-content:center; margin-top:10px;">{{ $products->links() }}</div>
    @endif
</div>

@endsection
