{{-- resources/views/frontend/index.blade.php --}}
@extends('frontend.master')

@section('main-content')

@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 mb-3" role="alert">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
</div>
@endif
@if(session('info'))
<div class="alert alert-info d-flex align-items-center gap-2 mb-3" role="alert">
    <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger d-flex align-items-center gap-2 mb-3" role="alert">
    <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
</div>
@endif

<div class="smhome-ci content-area-inner">

    {{-- ══ HERO ══ --}}
    <div class="smhome-hero">
        <div class="smhome-hero-slider">
            <div class="smhome-slides-wrap">
                @forelse ($slider as $index => $item)
                    <div class="smhome-slide">
                        <img src="{{ $item->photo ?? '' }}" alt="Slide" {{ $index === 0 ? 'loading="eager"' : 'loading="lazy"' }}>
                    </div>
                @empty
                    <div class="smhome-slide"
                         style="background:#222;display:flex;align-items:center;justify-content:center;">
                        <span style="color:#555;font-size:14px;">No slides added yet</span>
                    </div>
                @endforelse
            </div>
            <div class="smhome-sl-dots">
                <div class="smhome-sl-dot"></div>
                <div class="smhome-sl-dot"></div>
                <div class="smhome-sl-dot"></div>
                <div class="smhome-sl-dot"></div>
            </div>
        </div>

        <div class="smhome-hero-panel">
            <div class="smhome-welcome-card">
                <p class="smhome-welcome-card__label">Welcome Back</p>
                <div class="smhome-auth-btns">
                    <a href="{{ url('customer/register') }}" class="smhome-btn-reg">Register</a>
                    <a href="{{ url('customer/login') }}"    class="smhome-btn-sign">Sign In</a>
                </div>
            </div>
            <a href="{{ url('clearance') }}" class="smhome-clearance-card">
                CLEA-<br>RANCE
                <small>UP TO 70% OFF</small>
            </a>
        </div>
    </div>

    {{-- Mobile Strip --}}
    <div class="smhome-hero-mobile-strip">
        <div class="smhome-welcome-card" style="flex:1">
            <p class="smhome-welcome-card__label">Welcome Back</p>
            <div class="smhome-auth-btns">
                <a href="{{ url('customer/register') }}" class="smhome-btn-reg">Register</a>
                <a href="{{ url('customer/login') }}"    class="smhome-btn-sign">Sign In</a>
            </div>
        </div>
        <a href="{{ url('clearance') }}" class="smhome-clearance-card">
            CLEA-<br>RANCE
            <small>UP TO 70% OFF</small>
        </a>
    </div>

    {{-- ══ CATEGORY CIRCLES ══ --}}
    @if($categories->isNotEmpty())
    <div class="smhome-circles-box">
        <div class="smhome-circles-track">
            @foreach ($categories as $cat)
                <a href="{{ url('category/'.$cat->slug) }}" class="smhome-circle-item">
                    <div class="smhome-circle-img">
                        <img src="{{ asset('uploads/category/'.$cat->category_photo) }}"
                             alt="{{ $cat->category_name }}" loading="lazy">
                    </div>
                    <p>{{ $cat->category_name }}</p>
                </a>
            @endforeach
            @foreach ($categories as $cat)
                <a href="{{ url('category/'.$cat->slug) }}" class="smhome-circle-item">
                    <div class="smhome-circle-img">
                        <img src="{{ asset('uploads/category/'.$cat->category_photo) }}"
                             alt="{{ $cat->category_name }}" loading="lazy">
                    </div>
                    <p>{{ $cat->category_name }}</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ══ FLASH SALES ══ --}}
    @if($flashProducts->isNotEmpty())
    <div class="smhome-flash-hd">
        <div class="smhome-flash-title">
            <i class="bi bi-lightning-charge-fill"></i> Flash Sales
        </div>
        <a href="{{ url('flash-sales') }}" class="smhome-see-all">
            SEE ALL <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="smhome-prod-grid">
        @foreach ($flashProducts as $item)
            @php
                $displayPrice  = $item->flash_sale_price ?? $item->discount_price ?? $item->current_price;
                $originalPrice = $item->current_price;
                $discount      = ($displayPrice < $originalPrice && $originalPrice > 0)
                    ? round((($originalPrice - $displayPrice) / $originalPrice) * 100) : null;
                $inStock = $item->is_unlimited || ($item->stock ?? 0) > 0;
                $revAvg   = \App\Models\Producreview::where('product_id',$item->id)->where('is_approved',true)->avg('rating') ?? 0;
                $revCount = \App\Models\Producreview::where('product_id',$item->id)->where('is_approved',true)->count();
            @endphp
            <div style="position:relative">
                <a href="{{ route('wishlist.add', $item->id) }}"
                   class="smhome-p-wish" title="উইশলিস্টে যোগ করুন"
                   onclick="event.stopPropagation()">
                    <i class="bi bi-heart"></i>
                </a>

                <div class="smhome-p-card" 
                     onclick="window.location='{{ route('product.detail', $item->slug) }}'"
                     style="cursor: pointer;">
                    @if($discount)
                        <span class="smhome-p-badge">-{{ $discount }}%</span>
                    @endif
                    <div class="smhome-p-img-wrap">
                        <img class="smhome-p-img"
                             src="{{ asset('uploads/products/'.$item->feature_image) }}"
                             alt="{{ $item->name }}" loading="lazy">
                    </div>
                    <div class="smhome-p-body">
                        <a href="{{ route('product.detail', $item->slug) }}" 
                           class="smhome-p-name" 
                           onclick="event.stopPropagation()">{{ $item->name }}</a>
                        <p class="smhome-p-price">৳ {{ number_format($displayPrice, 0) }}</p>
                        @if($displayPrice < $originalPrice)
                            <p class="smhome-p-old">৳ {{ number_format($originalPrice, 0) }}</p>
                        @endif
                        <div class="smhome-p-meta">
                            @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                                <p class="smhome-p-stock">
                                    <i class="bi bi-fire" style="font-size:10px"></i> {{ $item->stock }} left
                                </p>
                            @endif
                            <div class="smhome-p-stars-row">
                                @for($s=1;$s<=5;$s++)
                                    <i class="bi bi-star{{ $s <= round($revAvg) ? '-fill' : '' }} sm-star {{ $s <= round($revAvg) ? 'filled' : 'empty' }}"></i>
                                @endfor
                                <span class="smhome-p-rc">({{ $revCount }})</span>
                            </div>
                        </div>

                        {{-- ✅ অর্ডার করুন → cart add → checkout redirect --}}
                        @if($inStock)
                            <form
                                action="{{ route('cart.add', $item->id) }}"
                                method="POST"
                                class="smhome-order-form"
                                onclick="event.stopPropagation()">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="redirect_to_checkout" value="1">
                                <button type="submit" class="smhome-p-order-btn" style="border:none; width:100%;">
                                    অর্ডার করুন
                                </button>
                            </form>
                        @else
                            <span class="smhome-p-order-btn smhome-p-order-btn--out">
                                স্টক নেই
                            </span>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif

    {{-- ══ NEW ARRIVALS ══ --}}
    @if($newArrivals->isNotEmpty())
    <div class="smhome-sec-head">
        <h2>New Arrivals</h2>
        <a href="{{ url('new-arrivals') }}" class="smhome-see-all">
            SEE ALL <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="smhome-prod-grid">
        @foreach ($newArrivals as $item)
            @php
                $discount = ($item->discount_price && $item->current_price > 0)
                    ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                $inStock  = $item->is_unlimited || ($item->stock ?? 0) > 0;
                $revAvg   = \App\Models\Producreview::where('product_id',$item->id)->where('is_approved',true)->avg('rating') ?? 0;
                $revCount = \App\Models\Producreview::where('product_id',$item->id)->where('is_approved',true)->count();
            @endphp
            <div style="position:relative">
                <a href="{{ route('wishlist.add', $item->id) }}"
                   class="smhome-p-wish" title="উইশলিস্টে যোগ করুন"
                   onclick="event.stopPropagation()">
                    <i class="bi bi-heart"></i>
                </a>

                <a href="{{ route('product.detail', $item->slug) }}" class="smhome-p-card-link">
                    <div class="smhome-p-card">
                        @if($discount)
                            <span class="smhome-p-badge">-{{ $discount }}%</span>
                        @endif
                        <div class="smhome-p-img-wrap">
                            <img class="smhome-p-img"
                                 src="{{ asset('uploads/products/'.$item->feature_image) }}"
                                 alt="{{ $item->name }}" loading="lazy">
                        </div>
                        <div class="smhome-p-body">
                            <p class="smhome-p-name">{{ $item->name }}</p>
                            <p class="smhome-p-price">৳ {{ number_format($item->discount_price ?? $item->current_price, 0) }}</p>
                            @if($item->discount_price)
                                <p class="smhome-p-old">৳ {{ number_format($item->current_price, 0) }}</p>
                            @endif
                            <div class="smhome-p-meta">
                                @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                                    <p class="smhome-p-stock">
                                        <i class="bi bi-fire" style="font-size:10px"></i> {{ $item->stock }} left
                                    </p>
                                @endif
                                <div class="smhome-p-stars-row">
                                    @for($s=1;$s<=5;$s++)
                                        <i class="bi bi-star{{ $s <= round($revAvg) ? '-fill' : '' }} sm-star {{ $s <= round($revAvg) ? 'filled' : 'empty' }}"></i>
                                    @endfor
                                    <span class="smhome-p-rc">({{ $revCount }})</span>
                                </div>
                            </div>

                            @if($inStock)
                                <form
                                    action="{{ route('cart.add', $item->id) }}"
                                    method="POST"
                                    class="smhome-order-form"
                                    onclick="event.stopPropagation()">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="redirect_to_checkout" value="1">
                                    <button type="submit" class="smhome-p-order-btn">
                                        অর্ডার করুন
                                    </button>
                                </form>
                            @else
                                <span class="smhome-p-order-btn smhome-p-order-btn--out">
                                    স্টক নেই
                                </span>
                            @endif

                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    @endif

    {{-- ══ BEST SELLERS ══ --}}
    @if($bestSellers->isNotEmpty())
    <div class="smhome-sec-head" style="margin-top:6px">
        <h2>Best Sellers</h2>
        <a href="{{ url('best-sellers') }}" class="smhome-see-all">
            SEE ALL <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="smhome-prod-grid">
        @foreach ($bestSellers as $item)
            @php
                $discount = ($item->discount_price && $item->current_price > 0)
                    ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                $inStock  = $item->is_unlimited || ($item->stock ?? 0) > 0;
                $revAvg   = \App\Models\Producreview::where('product_id',$item->id)->where('is_approved',true)->avg('rating') ?? 0;
                $revCount = \App\Models\Producreview::where('product_id',$item->id)->where('is_approved',true)->count();
            @endphp
            <div style="position:relative">
                <a href="{{ route('wishlist.add', $item->id) }}"
                   class="smhome-p-wish" title="উইশলিস্টে যোগ করুন"
                   onclick="event.stopPropagation()">
                    <i class="bi bi-heart"></i>
                </a>

                <a href="{{ route('product.detail', $item->slug) }}" class="smhome-p-card-link">
                    <div class="smhome-p-card">
                        @if($discount)
                            <span class="smhome-p-badge">-{{ $discount }}%</span>
                        @endif
                        <div class="smhome-p-img-wrap">
                            <img class="smhome-p-img"
                                 src="{{ asset('uploads/products/'.$item->feature_image) }}"
                                 alt="{{ $item->name }}" loading="lazy">
                        </div>
                        <div class="smhome-p-body">
                            <p class="smhome-p-name">{{ $item->name }}</p>
                            <p class="smhome-p-price">৳ {{ number_format($item->discount_price ?? $item->current_price, 0) }}</p>
                            @if($item->discount_price)
                                <p class="smhome-p-old">৳ {{ number_format($item->current_price, 0) }}</p>
                            @endif
                            <div class="smhome-p-meta">
                                @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                                    <p class="smhome-p-stock">
                                        <i class="bi bi-fire" style="font-size:10px"></i> {{ $item->stock }} left
                                    </p>
                                @endif
                                <div class="smhome-p-stars-row">
                                    @for($s=1;$s<=5;$s++)
                                        <i class="bi bi-star{{ $s <= round($revAvg) ? '-fill' : '' }} sm-star {{ $s <= round($revAvg) ? 'filled' : 'empty' }}"></i>
                                    @endfor
                                    <span class="smhome-p-rc">({{ $revCount }})</span>
                                </div>
                            </div>

                            @if($inStock)
                                <form
                                    action="{{ route('cart.add', $item->id) }}"
                                    method="POST"
                                    class="smhome-order-form"
                                    onclick="event.stopPropagation()">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="redirect_to_checkout" value="1">
                                    <button type="submit" class="smhome-p-order-btn">
                                        অর্ডার করুন
                                    </button>
                                </form>
                            @else
                                <span class="smhome-p-order-btn smhome-p-order-btn--out">
                                    স্টক নেই
                                </span>
                            @endif

                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    @endif

</div>{{-- /.smhome-ci --}}

<style>
.smhome-p-card-link { display: block; text-decoration: none; color: inherit; }
.smhome-order-form  { margin: 0; padding: 0; }

.smhome-p-order-btn {
    display: block;
    width: 100%;
    margin-top: 10px;
    padding: 9px 0;
    background: #be0318;
    color: #fff !important;
    -webkit-text-fill-color: #fff !important;
    font-size: 13px;
    font-weight: 700;
    text-align: center;
    border-radius: 6px;
    letter-spacing: .3px;
    transition: background .18s, transform .15s;
    cursor: pointer;
    text-decoration: none !important;
    border: none;
    box-sizing: border-box;
    font-family: inherit;
    line-height: 1.4;
}
.smhome-p-order-btn:hover {
    background: #96010f;
    color: #fff !important;
    -webkit-text-fill-color: #fff !important;
    transform: translateY(-1px);
}
.smhome-p-order-btn:active {
    transform: translateY(0);
    color: #fff !important;
    -webkit-text-fill-color: #fff !important;
}
.smhome-p-order-btn--out {
    background: #e5e7eb;
    color: #9ca3af !important;
    -webkit-text-fill-color: #9ca3af !important;
    cursor: not-allowed;
    pointer-events: none;
}
</style>

@endsection
