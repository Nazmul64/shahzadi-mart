{{-- resources/views/frontend/wishlist.blade.php --}}
@extends('frontend.master')

@section('main-content')
<link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/wishlist.css">


{{-- ── Hero / Breadcrumb ── --}}
<div class="wish-hero">
    <div class="container">
        <h1>Wishlist</h1>
        <nav class="bc-inner">
            <a href="{{ route('frontend') }}">Home</a>
            <span class="sep">&#8250;</span>
            <span>Pages</span>
            <span class="sep">&#8250;</span>
            <span class="current">Wishlist</span>
        </nav>
    </div>
</div>

<section class="wishlist-section">
    <div class="container">

        {{-- ── Flash Messages ── --}}
        @if(session('success'))
            <div class="alert-msg" style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-msg" style="background:#fff0f1;color:#e8192c;border:1px solid #fecdd3;">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div class="alert-msg" style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;">
                <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
            </div>
        @endif

        @if(isset($wishlistItems) && $wishlistItems->count() > 0)

            <div class="wish-table-wrap">
                <table class="wish-table">
                    <thead>
                        <tr>
                            <th style="min-width:300px;">Product</th>
                            <th style="min-width:110px;">Price</th>
                            <th style="min-width:130px;">Stock Status</th>
                            <th style="min-width:180px;"></th>
                            <th class="th-remove" style="min-width:80px;">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishlistItems as $item)
                        @php
                            $product = $item->product;
                            if (!$product) continue;

                            $hasDiscount  = $product->discount_price && $product->discount_price > 0;
                            $inStock      = $product->is_unlimited || ($product->stock ?? 0) > 0;
                            $displayPrice = $hasDiscount ? $product->discount_price : $product->current_price;

                            $imgSrc = $product->feature_image
                                ? asset('uploads/products/' . $product->feature_image)
                                : asset('images/placeholder.png');

                            $productName = $product->name ?? ($product->product_name ?? 'Product');
                        @endphp
                        <tr>

                            {{-- Product --}}
                            <td>
                                <div class="td-product">
                                    <a href="{{ route('product.detail', $product->slug) }}"
                                       class="td-product-img">
                                        <img src="{{ $imgSrc }}"
                                             alt="{{ $productName }}"
                                             onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                    </a>
                                    <a href="{{ route('product.detail', $product->slug) }}"
                                       class="td-product-name">
                                        {{ $productName }}
                                    </a>
                                </div>
                            </td>

                            {{-- Price --}}
                            <td class="td-price">
                                ${{ number_format($displayPrice, 2) }}
                            </td>

                            {{-- Stock Status --}}
                            <td>
                                @if($inStock)
                                    <span class="badge-stock">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                        In Stock
                                    </span>
                                @else
                                    <span class="badge-stock out">Out of Stock</span>
                                @endif
                            </td>

                            {{-- Add To Cart ── wishlist.moveToCart route ব্যবহার করছে --}}
                            {{-- এটা cart-এ add করে AND wishlist থেকে remove করে        --}}
                            <td>
                                @if($inStock)
                                    <a href="{{ route('wishlist.moveToCart', $item->id) }}"
                                       class="btn-add-cart">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.5 1.5H.5A.5.5 0 0 1 0 1.5z"/>
                                            <path d="M6.5 15a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                        </svg>
                                        Add To Cart
                                    </a>
                                @else
                                    <button class="btn-add-cart" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                        Out of Stock
                                    </button>
                                @endif
                            </td>

                            {{-- Remove --}}
                            <td class="td-remove">
                                <a href="{{ route('wishlist.remove', $item->id) }}"
                                   class="btn-remove"
                                   title="Remove"
                                   onclick="return confirm('এই পণ্যটি উইশলিস্ট থেকে সরাবেন?')">
                                    &times;
                                </a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            {{-- Empty State --}}
            <div class="wish-empty">
                <div class="empty-icon">
                    <i class="bi bi-heart"></i>
                </div>
                <h3>Your wishlist is empty!</h3>
                <p>Save your favourite products to your wishlist.</p>
                <a href="{{ route('frontend') }}" class="btn-shop-now">
                    <i class="bi bi-shop"></i> Start Shopping
                </a>
            </div>
        @endif

    </div>
</section>
@endsection
