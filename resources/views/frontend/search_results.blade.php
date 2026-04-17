{{-- resources/views/frontend/search_results.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
.search-results-wrap { padding: 4px 0; }
.sr-header {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    padding: 18px 22px;
    margin-bottom: 20px;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 10px;
    box-shadow: var(--sh1);
}
.sr-header h1 {
    font-size: 19px; font-weight: 800; color: var(--dark);
    display: flex; align-items: center; gap: 8px;
}
.sr-header h1 i { color: var(--red); }
.sr-meta { font-size: 13px; color: var(--muted); }
.sr-meta strong { color: var(--red); }

.sr-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
    gap: 16px;
    margin-bottom: 28px;
}

/* Reuse existing card styles from homepage */
.sr-card-link { text-decoration: none; color: inherit; display: block; position: relative; }
.sr-card {
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); overflow: hidden;
    transition: var(--t); display: flex; flex-direction: column; height: 100%;
}
.sr-card:hover { box-shadow: var(--sh3); transform: translateY(-5px); border-color: var(--border-d); }
.sr-badge {
    position: absolute; top: 10px; left: 10px;
    background: var(--red); color: #fff;
    font-size: 10px; font-weight: 800;
    padding: 4px 9px; border-radius: 5px; letter-spacing: .04em; z-index: 2;
}
.sr-p-img { width: 100%; height: 165px; object-fit: cover; border-bottom: 1px solid var(--border); transition: transform .35s; display: block; }
.sr-card:hover .sr-p-img { transform: scale(1.06); }
.sr-p-img-wrap { overflow: hidden; position: relative; }
.sr-p-body { padding: 12px 13px 13px; display: flex; flex-direction: column; flex: 1; }
.sr-p-name { font-size: 13.5px; font-weight: 600; color: var(--text); line-height: 1.48; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.sr-p-price { font-size: 16px; font-weight: 900; color: var(--red); margin-bottom: 2px; }
.sr-p-old { font-size: 12px; color: var(--muted); text-decoration: line-through; margin-bottom: 8px; }
.sr-p-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 11px 0; background: var(--red);
    color: #fff; border: none; border-radius: var(--r);
    font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 700;
    cursor: pointer; transition: var(--t); margin-top: auto; text-decoration: none;
}
.sr-p-atc:hover { background: var(--red-d); transform: translateY(-1px); box-shadow: 0 5px 14px rgba(200,16,46,.35); color: #fff; }

.sr-empty {
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); padding: 60px 20px;
    text-align: center; box-shadow: var(--sh1);
}
.sr-empty i { font-size: 48px; color: var(--border-d); display: block; margin-bottom: 12px; }
.sr-empty h3 { font-size: 18px; font-weight: 800; color: var(--dark); margin-bottom: 8px; }
.sr-empty p { color: var(--muted); font-size: 14px; margin-bottom: 20px; }
.sr-back-btn {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--red); color: #fff; padding: 10px 24px;
    border-radius: 30px; font-size: 13px; font-weight: 800;
    text-decoration: none; transition: var(--t);
}
.sr-back-btn:hover { background: var(--red-d); color: #fff; }

/* Pagination */
.sr-pagination { display: flex; justify-content: center; margin-top: 10px; }
.sr-pagination .pagination { display: flex; gap: 4px; }
.sr-pagination .page-item .page-link {
    display: inline-flex; align-items: center; justify-content: center;
    width: 36px; height: 36px; border-radius: var(--r);
    font-size: 13px; font-weight: 700; color: var(--text);
    border: 1.5px solid var(--border); text-decoration: none; transition: var(--t);
}
.sr-pagination .page-item.active .page-link { background: var(--red); color: #fff; border-color: var(--red); }
.sr-pagination .page-item .page-link:hover { border-color: var(--red); color: var(--red); }

@media (max-width: 640px) {
    .sr-grid { grid-template-columns: repeat(2, 1fr); gap: 11px; }
    .sr-p-img { height: 140px; }
    .sr-header { padding: 14px 16px; }
    .sr-header h1 { font-size: 16px; }
}
</style>

<div class="search-results-wrap content-area-inner">

    {{-- Header --}}
    <div class="sr-header">
        <h1>
            <i class="bi bi-search"></i>
            @if($q) "{{ $q }}" এর ফলাফল @else সার্চ ফলাফল @endif
        </h1>
        @if($q && $products->total() > 0)
            <span class="sr-meta">মোট <strong>{{ $products->total() }}</strong> টি পণ্য পাওয়া গেছে</span>
        @endif
    </div>

    @if(!$q)
        <div class="sr-empty">
            <i class="bi bi-search"></i>
            <h3>কী খুঁজছেন?</h3>
            <p>উপরের সার্চ বক্সে পণ্যের নাম লিখুন।</p>
            <a href="{{ url('/') }}" class="sr-back-btn"><i class="bi bi-house"></i> হোম পেজে যান</a>
        </div>

    @elseif($products->isEmpty())
        <div class="sr-empty">
            <i class="bi bi-emoji-frown"></i>
            <h3>"{{ $q }}" পাওয়া যায়নি</h3>
            <p>অন্য কোনো কীওয়ার্ড দিয়ে আবার চেষ্টা করুন।</p>
            <a href="{{ url('shop') }}" class="sr-back-btn"><i class="bi bi-grid-3x3-gap"></i> সব পণ্য দেখুন</a>
        </div>

    @else
        <div class="sr-grid">
            @foreach ($products as $item)
                @php
                    $displayPrice  = $item->discount_price ?? $item->current_price;
                    $discount      = ($item->discount_price && $item->current_price > 0)
                        ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100)
                        : null;
                    $inStock = $item->is_unlimited || ($item->stock ?? 0) > 0;
                @endphp

                <div style="position:relative">
                    <a href="{{ route('product.detail', $item->slug) }}" class="sr-card-link">
                        <div class="sr-card">
                            @if($discount)
                                <span class="sr-badge">-{{ $discount }}%</span>
                            @endif
                            <div class="sr-p-img-wrap">
                                <img class="sr-p-img"
                                     src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                     alt="{{ $item->name }}" loading="lazy">
                            </div>
                            <div class="sr-p-body">
                                <p class="sr-p-name">{{ $item->name }}</p>
                                <p class="sr-p-price">৳ {{ number_format($displayPrice, 0) }}</p>
                                @if($item->discount_price)
                                    <p class="sr-p-old">৳ {{ number_format($item->current_price, 0) }}</p>
                                @endif
                                @if($inStock)
                                    <a href="{{ route('cart.add', $item->id) }}"
                                       class="sr-p-atc"
                                       onclick="event.stopPropagation()">
                                      <i class="fa-solid fa-cart-plus"></i> কার্টে যোগ করুন
                                    </a>
                                @else
                                    <span class="sr-p-atc" style="background:#e5e7eb;color:#9ca3af;cursor:not-allowed;">
                                        <i class="fas fa-times-circle"></i> স্টক নেই
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="sr-pagination">
                {{ $products->links() }}
            </div>
        @endif
    @endif

</div>

@endsection
