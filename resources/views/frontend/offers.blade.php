{{-- resources/views/frontend/offers.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
.ofp { padding: 4px 0; margin-top: 15px; }

/* ══ HERO ══ */
.ofp-hero {
    background: linear-gradient(135deg, #0e0e0f 0%, #2c2c30 100%);
    border-radius: 20px; padding: 40px; margin-bottom: 25px; color: #fff;
    display: flex; justify-content: space-between; align-items: center; overflow: hidden; position: relative;
}
.ofp-hero__title { font-size: 32px; font-weight: 900; margin-bottom: 8px; }
.ofp-hero__title em { color: #d0152b; font-style: normal; }
.ofp-hero__sub { color: rgba(255,255,255,.6); font-size: 14px; }
.ofp-hero__badge { text-align: right; }
.ofp-hero__badge .b-num { display: block; font-size: 36px; font-weight: 900; color: #d0152b; }

/* ══ FILTERS ══ */
.ofp-filter { display: flex; gap: 10px; margin-bottom: 25px; flex-wrap: wrap; align-items: center; }
.ofp-chip { padding: 8px 20px; border-radius: 30px; background: #fff; border: 1.5px solid #e8e8ef; text-decoration: none; color: #5a5a65; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 8px; transition: all .2s; }
.ofp-chip.is-active { background: #d0152b; border-color: #d0152b; color: #fff; }

.ofp-sec { display: flex; align-items: center; gap: 12px; margin: 30px 0 15px; }
.ofp-sec h2 { font-size: 22px; font-weight: 800; margin: 0; }

/* ══ GRID (5 Columns) ══ */
.ofp-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
    margin-bottom: 30px;
}

.ofp-card {
    background: #fff; border: 1.5px solid #e8e8ef; border-radius: 16px; overflow: hidden;
    transition: all .3s; display: flex; flex-direction: column; height: 100%; position: relative;
}
.ofp-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,.08); border-color: #d0152b44; }

.ofp-disc { position: absolute; top: 11px; left: 11px; background: #d0152b; color: #fff; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; z-index: 2; }
.ofp-disc--gold { background: #f59e0b; }

.ofp-img { width: 100%; height: 280px; object-fit: cover; border-bottom: 1.5px solid #e8e8ef; transition: transform .5s; display: block; }
.ofp-card:hover .ofp-img { transform: scale(1.06); }
.ofp-img-wrap { overflow: hidden; position: relative; }

.ofp-body { padding: 14px; display: flex; flex-direction: column; flex: 1; }
.ofp-name { font-size: 18px; font-weight: 800; color: #2c2c30; line-height: 1.4; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 48px; text-decoration: none; }
.ofp-price { font-size: 22px; font-weight: 900; color: #d0152b; }
.ofp-old { font-size: 13.5px; color: #9a9aaa; text-decoration: line-through; margin-left: 8px; }

.ofp-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; padding: 11px 0; background: #d0152b;
    color: #fff; border-radius: 10px; font-size: 12.5px; font-weight: 700; text-decoration: none; margin-top: auto;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 1700px) { .ofp-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 1400px) { .ofp-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 1100px) { .ofp-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; } }
@media (max-width: 900px) {
    .ofp-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .ofp-img { height: 220px; }
}
@media (max-width: 500px) {
    .ofp-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .ofp-img { height: 180px; }
}
</style>

<div class="ofp content-area-inner">
    <div class="ofp-hero">
        <div class="ofp-hero__text">
            <h1 class="ofp-hero__title">সেরা <em>অফার</em> &amp;<br>ডিসকাউন্ট</h1>
            <p class="ofp-hero__sub">সীমিত সময়ের জন্য বিশেষ মূল্যছাড় উপভোগ করুন</p>
        </div>
        <div class="ofp-hero__badge">
            <span class="b-num">70%</span>
            <span style="font-size:12px; text-transform:uppercase; opacity:.6;">পর্যন্ত ছাড়</span>
        </div>
    </div>

    <div class="ofp-filter">
        <a href="{{ url('offers') }}" class="ofp-chip {{ !request('type') && !request('sort') ? 'is-active' : '' }}">সব অফার</a>
        <a href="{{ url('offers?type=flash') }}" class="ofp-chip {{ request('type') === 'flash' ? 'is-active' : '' }}">ফ্ল্যাশ সেল</a>
        <a href="{{ url('offers?type=clearance') }}" class="ofp-chip {{ request('type') === 'clearance' ? 'is-active' : '' }}">ক্লিয়ারেন্স</a>
    </div>

    @if(isset($flashProducts) && $flashProducts->isNotEmpty())
        <div class="ofp-sec"><h2>ফ্ল্যাশ সেল</h2></div>
        <div class="ofp-grid">
            @foreach($flashProducts as $item)
                @php
                    $dPrice = $item->flash_sale_price ?? $item->discount_price ?? $item->current_price;
                    $disc = round((($item->current_price - $dPrice)/$item->current_price)*100);
                @endphp
                <div class="ofp-card" onclick="window.location='{{ route('product.detail', $item->slug) }}'" style="cursor:pointer;">
                    @if($disc > 0) <span class="ofp-disc">-{{ $disc }}%</span> @endif
                    <div class="ofp-img-wrap"><img class="ofp-img" src="{{ asset('uploads/products/' . $item->feature_image) }}" alt="{{ $item->name }}" loading="lazy"></div>
                    <div class="ofp-body">
                        <a href="{{ route('product.detail', $item->slug) }}" class="ofp-name" onclick="event.stopPropagation()">{{ $item->name }}</a>
                        @php
                            $inStock = $item->is_unlimited || ($item->stock ?? 0) > 0;
                        @endphp
                        <div class="smp-stock-status mb-1 mt-1">
                            @if($inStock)
                                <span class="smhome-p-available text-success">
                                    <i class="bi bi-check-circle-fill"></i> স্টক এভেইলেবল
                                </span>
                            @else
                                <span class="smhome-p-available text-danger">
                                    <i class="bi bi-x-circle-fill"></i> স্টক আউট
                                </span>
                            @endif
                        </div>
                        <div>
                            <span class="ofp-price">৳ {{ number_format($dPrice, 0) }}</span>
                            @if($dPrice < $item->current_price) <span class="ofp-old">৳ {{ number_format($item->current_price, 0) }}</span> @endif
                        </div>
                        <form action="{{ route('cart.add', $item->id) }}" method="POST" onclick="event.stopPropagation()">
                            @csrf
                            <button type="submit" class="ofp-atc" style="border:none; width:100%;">কার্টে যোগ করুন</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if(isset($discountProducts) && $discountProducts->isNotEmpty())
        <div class="ofp-sec"><h2>ডিসকাউন্ট পণ্য</h2></div>
        <div class="ofp-grid">
            @foreach($discountProducts as $item)
                @php
                    $dPrice = $item->discount_price ?? $item->current_price;
                    $disc = round((($item->current_price - $dPrice)/$item->current_price)*100);
                @endphp
                <div class="ofp-card" onclick="window.location='{{ route('product.detail', $item->slug) }}'" style="cursor:pointer;">
                    @if($disc > 0) <span class="ofp-disc">-{{ $disc }}%</span> @endif
                    <div class="ofp-img-wrap"><img class="ofp-img" src="{{ asset('uploads/products/' . $item->feature_image) }}" alt="{{ $item->name }}" loading="lazy"></div>
                    <div class="ofp-body">
                        <a href="{{ route('product.detail', $item->slug) }}" class="ofp-name" onclick="event.stopPropagation()">{{ $item->name }}</a>
                        @php
                            $inStock = $item->is_unlimited || ($item->stock ?? 0) > 0;
                        @endphp
                        <div class="smp-stock-status mb-1 mt-1">
                            @if($inStock)
                                <span class="smhome-p-available text-success">
                                    <i class="bi bi-check-circle-fill"></i> স্টক এভেইলেবল
                                </span>
                            @else
                                <span class="smhome-p-available text-danger">
                                    <i class="bi bi-x-circle-fill"></i> স্টক আউট
                                </span>
                            @endif
                        </div>
                        <div>
                            <span class="ofp-price">৳ {{ number_format($dPrice, 0) }}</span>
                            @if($dPrice < $item->current_price) <span class="ofp-old">৳ {{ number_format($item->current_price, 0) }}</span> @endif
                        </div>
                        <form action="{{ route('cart.add', $item->id) }}" method="POST" onclick="event.stopPropagation()">
                            @csrf
                            <button type="submit" class="ofp-atc" style="border:none; width:100%;">কার্টে যোগ করুন</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="display:flex; justify-content:center;">{{ $discountProducts->links() }}</div>
    @endif
</div>

@push('scripts')
<script>
    // ── Tracking for Offers Page ──
    (function() {
        if (typeof dataLayer !== 'undefined') {
            var items = [];
            @if(isset($flashProducts))
                @foreach($flashProducts as $i => $item)
                items.push({
                    'item_name': '{{ addslashes($item->name) }}',
                    'item_id': '{{ $item->id }}',
                    'price': {{ (float)($item->flash_sale_price ?? $item->discount_price ?? $item->current_price) }},
                    'item_list_name': 'Offers - Flash Sale',
                    'index': {{ $i + 1 }}
                });
                @endforeach
            @endif
            @if(isset($discountProducts))
                @foreach($discountProducts as $i => $item)
                items.push({
                    'item_name': '{{ addslashes($item->name) }}',
                    'item_id': '{{ $item->id }}',
                    'price': {{ (float)($item->discount_price ?? $item->current_price) }},
                    'item_list_name': 'Offers - Discounts',
                    'index': items.length + 1
                });
                @endforeach
            @endif

            dataLayer.push({
                'event': 'view_item_list',
                'ecommerce': {
                    'currency': 'BDT',
                    'item_list_name': 'Offers Page',
                    'items': items
                }
            });
        }
    })();
</script>
@endpush

@endsection
