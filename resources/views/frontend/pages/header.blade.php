{{-- resources/views/frontend/pages/header.blade.php --}}

@php
    $pixelData     = $Pixelid         ?? \App\Models\Pixel::first();
    $analyticsData = $GoogleAnalytics ?? \App\Models\Tagmanager::first();

    $fbPixelId = ($pixelData     && $pixelData->status     == 1) ? trim($pixelData->pixel_id)         : null;
    $gtmId     = ($analyticsData && $analyticsData->status == 1) ? trim($analyticsData->google_tag_id) : null;

    // Contact info for floating widget
    $contactinformationadmin = $contactinformationadmin
        ?? \App\Models\Contactinfomationadmin::latest()->first();
@endphp



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">
    @php
        $gs = \App\Models\Generalsetting::getSettings();
        $siteName = $gs->site_name;
        $websitefavicon = \App\Models\Websitefavicon::getSettings();
        
        $seoTitle = $siteName;
        $seoDesc  = '';
        $seoKeys  = 'online shop, ecommerce, bangladesh, premium products';
        $ogImg    = !empty($websetting?->header_logo) ? asset($websetting->header_logo) : asset('default/logo.png');
        $ogType   = 'website';
        $canonicalUrl = url()->current();

        if (isset($product)) {
            $seoTitle = $product->name . ' - ' . $siteName;
            $seoDesc  = $product->meta_description ?: ($aiPrompt->product_description ?? substr(strip_tags($product->description), 0, 160));
            $seoKeys  = $product->meta_tags ?: (is_array($product->tags) ? implode(', ', $product->tags) : $product->tags);
            $ogImg    = $product->feature_image ? asset('uploads/products/'.$product->feature_image) : $ogImg;
            $ogType   = 'product';
        } elseif (isset($category)) {
            $seoTitle = ($category->name ?? 'Category') . ' - ' . $siteName;
            $seoDesc  = $aiPrompt->page_description ?? 'Browse our range of ' . ($category->name ?? 'products') . '.';
        } elseif (isset($post)) {
            $seoTitle = ($post->title) . ' - ' . $siteName;
            $seoDesc  = substr(strip_tags($post->description), 0, 160);
            $ogImg    = $post->image ? asset($post->image) : $ogImg;
        } elseif (isset($page)) {
            $seoTitle = ($page->title ?: $page->name) . ' - ' . $siteName;
            $seoDesc  = $aiPrompt->page_description ?? substr(strip_tags($page->description), 0, 160);
        } else {
            $seoTitle = $siteName . ' - Your Trusted Marketplace';
            $seoDesc  = $aiPrompt->page_description ?? 'Best online shop for premium products. Quality guaranteed, delivered to your door.';
        }
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDesc }}">
    @if($seoKeys) <meta name="keywords" content="{{ $seoKeys }}"> @endif
    <meta name="author" content="{{ $siteName }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    {{-- ── Open Graph / Facebook ── --}}
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDesc }}">
    <meta property="og:image" content="{{ $ogImg }}">
    <meta property="og:site_name" content="{{ $siteName }}">

    {{-- ── Twitter ── --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $canonicalUrl }}">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDesc }}">
    <meta name="twitter:image" content="{{ $ogImg }}">

    {{-- ══ GOOGLE TAG MANAGER — <head> ══ --}}
    @if($gtmId)
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $gtmId }}');</script>
    @endif

    {{-- ══ FACEBOOK PIXEL ══ --}}
    @if($fbPixelId)
    <script>
    !function(f,b,e,v,n,t,s){
        if(f.fbq)return;
        n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];
        t=b.createElement(e);t.async=!0;t.src=v;
        s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)
    }(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init','{{ $fbPixelId }}');
    fbq('track','PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
             src="https://www.facebook.com/tr?id={{ $fbPixelId }}&ev=PageView&noscript=1"/>
    </noscript>
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset($websitefavicon->favicon_logo ?? 'default/favicon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/main.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/index.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/footer.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/newproduct.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/offer.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/shop.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/allproduct.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/productdetils.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/custom-loader.css">
    <style>
        :root {
            --red: {{ $gs->primary_color ?? '#be0318' }};
            --red-d: {{ ($gs->primary_color ? $gs->primary_color . 'cc' : '#96010f') }};
            --header-bg: {{ $gs->header_color ?? '#ffffff' }};
            --header-text: {{ $gs->header_text_color ?? '#333333' }};
            --font-main: {{ $gs->font_family ?? 'Plus Jakarta Sans' }}, sans-serif;
        }
        body { font-family: var(--font-main); overflow-x: hidden !important; }
        
        /* ── Design Restoration ── */
        .site-hdr { background-color: var(--header-bg) !important; color: var(--header-text) !important; position: sticky !important; top: 0 !important; z-index: 2000000 !important; overflow: visible !important; }
        .site-nav { position: relative !important; z-index: 1000000 !important; overflow: visible !important; background: var(--red) !important; height: 55px !important; display: flex !important; align-items: center; }
        .site-nav > div { overflow: visible !important; height: 100% !important; }
        .site-nav__in { display: flex !important; align-items: center !important; height: 100% !important; width: 100% !important; overflow: visible !important; }
        
        /* ── LAYOUT FIX: Lower Stacking for Page content ── */
        .main-site-content { position: relative !important; z-index: 1 !important; }
        .page-wrap.no-sidebar { grid-template-columns: 1fr !important; gap: 0 !important; position: relative !important; z-index: 1 !important; }
        
        /* ── FULL WIDTH CONTAINER FIX (Prevents sidebar overlap) ── */
        .container-fluid .page-wrap { max-width: 100% !important; padding-left: 20px !important; padding-right: 20px !important; }

        /* ── Dynamic Layout Settings from Admin Panel ── */
        @media (min-width: 1201px) {
            .smhome-prod-grid, .smp-grid, .cp-prod-grid, .ofp-grid {
                grid-template-columns: repeat({{ $gs->products_per_row ?? 5 }}, 1fr) !important;
            }
        }
        @media (min-width: 992px) and (max-width: 1200px) {
            .smhome-prod-grid, .smp-grid, .cp-prod-grid, .ofp-grid {
                grid-template-columns: repeat({{ min(($gs->products_per_row ?? 4), 4) }}, 1fr) !important;
            }
        }
        
        /* ── Category Dropdown Overhaul ── */
        .nav-cat-dropdown { position: relative !important; display: flex !important; align-items: center !important; overflow: visible !important; z-index: 10000 !important; height: 100% !important; }
        .nav-cat-btn { 
            background: rgba(0,0,0,0.2) !important; color: #fff !important; border: 1px solid rgba(255,255,255,0.2) !important; padding: 0 25px !important; 
            border-radius: 6px !important; font-size: 15px !important; font-weight: 800 !important; cursor: pointer !important;
            display: flex !important; align-items: center !important; gap: 10px !important; position: relative !important; z-index: 11 !important;
            height: 42px !important; white-space: nowrap !important; min-width: 210px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .nav-cat-btn:hover { background: rgba(0,0,0,0.3) !important; box-shadow: 0 0 15px rgba(0,0,0,0.2) !important; }
        
        .nav-cat-menu {
            position: absolute !important; top: 100% !important; left: 0 !important; width: 280px !important; background: #fff !important;
            box-shadow: 0 25px 80px rgba(0,0,0,0.5) !important; border-radius: 0 0 12px 12px !important;
            opacity: 0 !important; visibility: hidden !important; transform: translateY(15px) !important;
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s !important; 
            z-index: 999999999 !important; padding: 12px 0 !important; 
            border: 1px solid rgba(0,0,0,0.1) !important; border-top: 4px solid var(--red) !important;
            margin-top: 0px !important; pointer-events: none;
        }
        
        /* Show states with Animation */
        .nav-cat-dropdown:hover .nav-cat-menu,
        .nav-cat-dropdown.is-active .nav-cat-menu { 
            opacity: 1 !important; visibility: visible !important; transform: translateY(0) !important; pointer-events: all !important;
        }
        
        /* ── Nav Items ── */
        .nav-item { color: #fff !important; font-weight: 700 !important; font-size: 14px !important; display: flex !important; align-items: center !important; gap: 6px !important; padding: 0 15px !important; height: 100% !important; text-decoration: none !important; transition: all 0.2s; opacity: 0.95; }
        .nav-item:hover, .nav-item.active { background: rgba(255,255,255,0.12) !important; opacity: 1; transform: translateY(-1px); }
        .nav-item i { font-size: 16px !important; color: #fff !important; }
        .nav-divider { width: 1px !important; height: 20px !important; background: rgba(255,255,255,0.2) !important; margin: 0 !important; }
        
        .nav-cat-menu .sidebar { display: block !important; width: 100% !important; border: none !important; margin: 0 !important; box-shadow: none !important; position: static !important; max-height: 80vh !important; overflow-y: auto !important; }
        .nav-cat-menu .sb-head { display: none !important; }
        .nav-cat-menu a { color: #333 !important; text-decoration: none !important; font-weight: 600 !important; display: block !important; padding: 8px 20px !important; transition: all 0.2s; }
        .nav-cat-menu a:hover { background: #f8f9fa !important; color: var(--red) !important; padding-left: 25px !important; }

        /* ── SEARCH BAR CLEANUP ── */
        .hdr-search { box-shadow: none !important; border-color: var(--border) !important; }
        .hdr-search.focused, .hdr-search:focus-within { box-shadow: none !important; border-color: var(--red) !important; background: var(--white) !important; }

        @media (max-width: 991px) {
            .site-nav { display: none !important; }
        }
    </style>



    {{-- ── Toastr Flash Messages ── --}}
    @if(Session::has('success') || Session::has('error') || Session::has('info') || Session::has('coupon_error'))
    <script>
        $(document).ready(function(){
            toastr.options = { closeButton:true, progressBar:true, positionClass:"toast-top-right", timeOut:4500 };
            @if(Session::has('error'))        toastr.error("{{ Session::get('error') }}"); @endif
            @if(Session::has('success'))      toastr.success("{{ Session::get('success') }}"); @endif
            @if(Session::has('info'))         toastr.info("{{ Session::get('info') }}"); @endif
            @if(Session::has('coupon_error')) toastr.error("{{ Session::get('coupon_error') }}"); @endif
        });
    </script>
    @endif

    @php
        $headerCartCount    = collect(session('cart', []))->sum('quantity');
        $headerCartItems    = session('cart', []);
        $headerCartSubtotal = 0;
        foreach ($headerCartItems as $item) {
            $unitP = (!empty($item['discount_price']) && $item['discount_price'] > 0)
                     ? $item['discount_price'] : $item['price'];
            $headerCartSubtotal += $unitP * $item['quantity'];
        }
        if (Auth::check()) {
            $headerWishItems = \App\Models\Wishlist::with('product')->where('user_id', Auth::id())->latest()->take(6)->get();
            $headerWishTotal = \App\Models\Wishlist::where('user_id', Auth::id())->count();
        } else {
            $headerWishItems = \App\Models\Wishlist::with('product')->where('session_id', session()->getId())->latest()->take(6)->get();
            $headerWishTotal = \App\Models\Wishlist::where('session_id', session()->getId())->count();
        }
    @endphp
</head>
<body>

{{-- 
<div id="global-loader">
    <div class="loader-content">
        <div class="loader-circle"></div>
        <div class="loader-brand">
            Shahzadi<span>-mart</span>
        </div>
    </div>
</div>

<div id="top-progress-bar"></div>
--}}

{{-- ── OFFLINE INDICATOR ── --}}
<div id="offline-indicator">
    <div class="offline-icon">
        <i class="bi bi-wifi-off" id="offline-icon-bi"></i>
    </div>
    <div class="offline-text" id="offline-text">
        আপনি অফলাইনে আছেন! সংযোগ পরীক্ষা করুন।
    </div>
</div>

{{-- GTM noscript --}}
@if($gtmId)
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
@endif

{{-- ── TOP BAR ── --}}
<div class="top-bar">
    <div class="{{ $gs->site_layout_width == 'boxed' ? 'container' : 'container-fluid' }}">
        <div class="top-bar__in">
            <div class="top-bar__promo">
                <span class="top-bar__dot"></span>
                <i class="bi bi-lightning-charge-fill" style="color:var(--gold);font-size:11px"></i>
               {{$deliveryInformation->header_title ?? ''}}
            </div>
            <div class="top-bar__nav">
                <a href="{{ route('order.track') }}" class="top-bar__track"><i class="bi bi-truck"></i> অর্ডার ট্র্যাক</a>
                <a href="{{ route('products.all') }}"><i class="bi bi-grid-3x3-gap"></i> সব পণ্য</a>
                <a href="#"><i class="bi bi-shop"></i> Sell on Shahzadi</a>
                <a href="#"><i class="bi bi-geo-alt"></i> Our Stores</a>
            </div>
        </div>
    </div>
</div>

{{-- ── MAIN HEADER ── --}}
<header class="site-hdr">
    <div class="{{ $gs->site_layout_width == 'boxed' ? 'container' : 'container-fluid' }}">
        <div class="site-hdr__in">

            <button class="hamb" onclick="toggleSidebar()" aria-label="Toggle menu">
                <i class="bi bi-list"></i>
            </button>

            <a href="{{ url('/') }}" class="logo">
                <img src="{{ !empty($gs->header_logo) ? asset($gs->header_logo) : asset('default/logo.png') }}"
                     alt="{{ $siteName }} Logo" style="height:70px;width:auto;">
                <div class="logo__dot"></div>
            </a>

            <div class="hdr-search-wrap" id="searchWrap">
                <div class="hdr-search" id="hdrSearch">
                    <input type="search" id="globalSearch"
                           placeholder="পণ্য, ব্র্যান্ড, ক্যাটাগরি খুঁজুন…"
                           autocomplete="off" aria-label="Search products">
                    <button class="search-clear" id="searchClear" type="button" title="Clear">
                        <i class="bi bi-x-lg"></i>
                    </button>
                    <button class="hdr-search__btn" type="button" onclick="doSearch()">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
                <div class="search-dropdown" id="searchDropdown">
                    <div class="search-loading" id="searchLoading">
                        <div class="search-spinner"></div> খুঁজছি…
                    </div>
                    <div id="searchResults"></div>
                </div>
            </div>

            <a href="{{ route('order.track') }}" class="track-order-btn" aria-label="Track Order">
                <i class="bi bi-truck"></i>
                <span class="track-lbl">অর্ডার ট্র্যাক</span>
            </a>

            <div class="hdr-actions">

            {{-- Account --}}
            <div class="hdr-drop-wrap">
                <div class="h-act" tabindex="0" role="button" aria-label="Account">
                    <i class="bi bi-person-circle"></i>
                    <span class="h-act__lbl">@auth Dashboard @else Login @endauth</span>
                </div>
                <div class="hdr-drop acct-drop">
                    <div class="acct-drop__hd">
                        @auth
                            <span class="user-greeting">
                                <i class="bi bi-person-check" style="color:var(--gold);margin-right:4px;"></i>
                                {{ Auth::user()->name }}
                            </span>
                            <span class="user-email">{{ Auth::user()->email }}</span>
                            <a href="{{ route('user.dashboard') }}" class="acct-dash-btn">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        @else
                            <p>Welcome to Shahzadi-mart</p>
                            <button class="acct-signin" onclick="window.location.href='{{ url('customer/login') }}'">Sign In</button>
                        @endauth
                    </div>
                    @auth
                        <a href="{{ route('user.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    @endauth
                    <a href="{{ url('customer/account') }}"><i class="bi bi-person"></i> My Account</a>
                    <a href="{{ route('wishlist') }}">
                        <i class="bi bi-heart"></i> My Wishlist
                        @if($headerWishTotal > 0)
                            <span style="margin-left:auto;background:var(--red);color:#fff;font-size:10px;font-weight:800;padding:1px 7px;border-radius:10px;">{{ $headerWishTotal }}</span>
                        @endif
                    </a>
                    <a href="{{ route('products.all') }}"><i class="bi bi-grid-3x3-gap"></i> সব পণ্য</a>
                    <a href="{{ url('cart') }}"><i class="bi bi-bag"></i> My Orders</a>
                    <a href="{{ route('order.track') }}"><i class="bi bi-truck"></i> অর্ডার ট্র্যাক</a>
                    @auth
                        <a href="{{ url('customer/logout') }}" class="logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    @else
                        <a href="{{ url('customer/login') }}"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                        <a href="{{ url('customer/register') }}"><i class="bi bi-person-plus"></i> Register</a>
                    @endauth
                </div>
            </div>

            {{-- Wishlist --}}
            <div class="hdr-drop-wrap">
                <a href="{{ route('wishlist') }}" class="h-act" title="Wishlist">
                    <i class="bi bi-heart"></i>
                    <span class="h-act__lbl">Wishlist</span>
                    <span class="h-badge {{ $headerWishTotal == 0 ? 'zero' : '' }}" id="wishBadge">
                        {{ $headerWishTotal > 0 ? $headerWishTotal : '' }}
                    </span>
                </a>
                <div class="hdr-drop wish-drop">
                    <div class="wish-drop__hd">
                        <i class="bi bi-heart-fill"></i>
                        <span>উইশলিস্ট</span>
                        @if($headerWishTotal > 0)
                            <span class="wish-count-pill">{{ $headerWishTotal }}</span>
                        @endif
                    </div>
                    <div class="wish-drop__body">
                        @if($headerWishItems->count() > 0)
                            @foreach($headerWishItems as $wItem)
                                @php
                                    $wp = $wItem->product;
                                    if (!$wp) continue;
                                    $wHasDisc = $wp->discount_price && $wp->discount_price > 0;
                                    $wPrice   = $wHasDisc ? $wp->discount_price : ($wp->current_price ?? $wp->price ?? 0);
                                    $wImgSrc  = $wp->feature_image ? asset('uploads/products/'.$wp->feature_image) : asset('images/placeholder.png');
                                    $wName    = $wp->name ?? ($wp->product_name ?? 'Product');
                                    $wInStock = $wp->is_unlimited || (($wp->stock ?? 0) > 0);
                                @endphp
                                <div class="wish-item">
                                    <div class="wish-item__img">
                                        <img src="{{ $wImgSrc }}" alt="{{ $wName }}" loading="lazy"
                                             onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                    </div>
                                    <div class="wish-item__info">
                                        <a href="{{ route('product.detail', $wp->slug) }}" class="wish-item__name">{{ $wName }}</a>
                                        <div>
                                            <span class="wish-item__price">৳ {{ number_format($wPrice, 0) }}</span>
                                            @if($wHasDisc)
                                                <span class="wish-item__old">৳ {{ number_format($wp->price, 0) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($wInStock)
                                        <a href="{{ route('wishlist.moveToCart', $wItem->id) }}" class="wish-item__add" title="কার্টে যোগ করুন">
                                            <i class="bi bi-cart-plus"></i>
                                        </a>
                                    @else
                                        <span class="wish-item__add" style="opacity:.4;cursor:not-allowed;">
                                            <i class="bi bi-x-circle"></i>
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="wish-drop__empty">
                                <i class="bi bi-heart"></i> উইশলিস্ট খালি আছে।
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('wishlist') }}" class="wish-drop__foot">
                        সম্পূর্ণ উইশলিস্ট দেখুন <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- Help --}}
            <a href="#" class="h-act"><i class="bi bi-headset"></i><span class="h-act__lbl">Help</span></a>

            {{-- Cart --}}
            <div class="hdr-drop-wrap">
                <a href="{{ url('cart') }}" class="h-act" title="Cart">
                    <i class="bi bi-cart3"></i>
                    <span class="h-act__lbl">Cart</span>
                    <span class="h-badge {{ $headerCartCount == 0 ? 'zero' : '' }}" id="cartBadge">
                        {{ $headerCartCount > 0 ? $headerCartCount : '' }}
                    </span>
                </a>
                <div class="hdr-drop cart-drop">
                    <div class="cart-drop__hd">
                        <i class="bi bi-cart3"></i>
                        <span>আমার কার্ট</span>
                        @if($headerCartCount > 0)
                            <span class="cart-count-pill">{{ $headerCartCount }}</span>
                        @endif
                    </div>
                    <div class="cart-drop__body">
                        @forelse($headerCartItems as $cKey => $cItem)
                            @php
                                $cHasDisc   = isset($cItem['discount_price']) && $cItem['discount_price'] > 0;
                                $cUnitP     = $cHasDisc ? $cItem['discount_price'] : $cItem['price'];
                                $cLineTotal = $cUnitP * $cItem['quantity'];
                                $cImgSrc    = !empty($cItem['image']) ? asset('uploads/products/'.$cItem['image']) : asset('images/placeholder.png');
                                $cVariants  = array_filter([$cItem['selected_color'] ?? null, $cItem['selected_size'] ?? null]);
                            @endphp
                            <div class="cart-mini-item">
                                <div class="cart-mini-img">
                                    <img src="{{ $cImgSrc }}" alt="{{ $cItem['name'] }}" loading="lazy"
                                         onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                    <span class="cart-mini-qty">{{ $cItem['quantity'] }}</span>
                                </div>
                                <div class="cart-mini-info">
                                    <a href="{{ route('product.detail', $cItem['slug'] ?? $cKey) }}" class="cart-mini-name">
                                        {{ $cItem['name'] }}
                                    </a>
                                    @if(!empty($cVariants))
                                        <div class="cart-mini-variants">{{ implode(' · ', $cVariants) }}</div>
                                    @endif
                                    <div class="cart-mini-price">৳ {{ number_format($cLineTotal, 0) }}</div>
                                </div>
                                <a href="{{ route('cart.remove', $cKey) }}" class="cart-mini-remove" title="সরান"
                                   onclick="event.preventDefault();if(confirm('সরিয়ে দেবেন?'))window.location.href=this.href;">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </div>
                        @empty
                            <div class="cart-drop__empty">
                                <i class="bi bi-cart-x"></i> কার্ট এখন খালি।
                            </div>
                        @endforelse
                    </div>
                    @if(!empty($headerCartItems))
                        <div class="cart-drop__summary">
                            <div class="cart-drop__total">
                                <span class="cart-drop__total-lbl">সাবটোটাল</span>
                                <span class="cart-drop__total-val">৳ {{ number_format($headerCartSubtotal, 0) }}</span>
                            </div>
                            <div class="cart-drop__btns">
                                <a href="{{ url('cart') }}" class="cart-drop__btn cart-drop__btn--view">
                                    <i class="bi bi-bag"></i> কার্ট দেখুন
                                </a>
                                <a href="{{ route('checkout') }}" class="cart-drop__btn cart-drop__btn--checkout">
                                    <i class="bi bi-check-circle"></i> চেকআউট
                                </a>
                            </div>
                        </div>
                    @else
                        <div style="padding:10px 14px;border-top:1px solid var(--border);">
                            <a href="{{ route('products.all') }}"
                               style="display:flex;align-items:center;justify-content:center;gap:6px;padding:10px;background:var(--red);color:#fff;border-radius:var(--rm);font-size:13px;font-weight:800;text-decoration:none;"
                               onmouseover="this.style.background='var(--red-d)'"
                               onmouseout="this.style.background='var(--red)'">
                                <i class="bi bi-shop"></i> শপিং শুরু করুন
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>{{-- /.hdr-actions --}}
    </div>{{-- /.site-hdr__in --}}
    </div>{{-- /.container --}}
</header>

{{-- ── SECONDARY NAV ── --}}
<nav class="site-nav" aria-label="Main navigation">
    <div class="{{ $gs->site_layout_width == 'boxed' ? 'container' : 'container-fluid' }}">
        <div class="site-nav__in">
            @if($gs->category_menu_type == 'hover')
                <div class="nav-cat-dropdown" id="navCatDropdown">
                    <button type="button" class="nav-cat-btn" id="catBtnToggle" onclick="event.stopPropagation(); document.getElementById('navCatDropdown').classList.toggle('is-active');">
                        <i class="bi bi-grid-fill"></i> সব ক্যাটাগরি <i class="bi bi-chevron-down ms-1"></i>
                    </button>
                    <div class="nav-cat-menu">
                        @include('frontend.pages.category')
                    </div>
                </div>
                <span class="nav-divider"></span>
                
                <script>
                    document.addEventListener('mouseover', function(e) {
                        if (e.target.closest('#catBtnToggle') || e.target.closest('#navCatMenu')) {
                            document.getElementById('navCatDropdown').classList.add('is-active');
                        }
                    });

                    document.addEventListener('mouseout', function(e) {
                        if (!e.relatedTarget || (!e.relatedTarget.closest('#catBtnToggle') && !e.relatedTarget.closest('#navCatMenu'))) {
                            document.getElementById('navCatDropdown').classList.remove('is-active');
                        }
                    });

                    // Search Bar Typing Effect
                    const searchInput = document.getElementById('globalSearch');
                    if (searchInput) {
                        const typingWords = [
                            "আপনার প্রয়োজনীয় যেকোনো পণ্য খুঁজুন...", 
                            "স্মার্টফোন, গ্যাজেট এবং ইলেকট্রনিক্স খুঁজুন...", 
                            "ছেলে ও মেয়েদের লেটেস্ট ফ্যাশন কালেকশন খুঁজুন...", 
                            "অরিজিনাল কসমেটিকস ও বিউটি প্রোডাক্ট খুঁজুন..."
                        ];
                        let wordIndex = 0;
                        let charIndex = 0;
                        let isDeleting = false;

                        // Use Intl.Segmenter for proper Bengali conjuncts (যুক্তবর্ণ) handling
                        const segmenter = new Intl.Segmenter("bn", { granularity: "grapheme" });

                        function typeEffect() {
                            const currentWord = typingWords[wordIndex];
                            const segments = Array.from(segmenter.segment(currentWord)).map(s => s.segment);
                            
                            if (isDeleting) {
                                searchInput.placeholder = segments.slice(0, charIndex - 1).join('');
                                charIndex--;
                            } else {
                                searchInput.placeholder = segments.slice(0, charIndex + 1).join('');
                                charIndex++;
                            }
                            
                            let typeSpeed = 80;
                            if (isDeleting) typeSpeed /= 2;
                            
                            if (!isDeleting && charIndex === segments.length) {
                                typeSpeed = 2000; // Pause at end of word
                                isDeleting = true;
                            } else if (isDeleting && charIndex === 0) {
                                isDeleting = false;
                                wordIndex = (wordIndex + 1) % typingWords.length;
                                typeSpeed = 500; // Pause before new word
                            }
                            setTimeout(typeEffect, typeSpeed);
                        }
                        
                        // Start typing effect
                        setTimeout(typeEffect, 1000);
                    }
                </script>
            @endif

            <a href="{{ url('/') }}" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <i class="bi bi-house"></i> হোম
            </a>
            <span class="nav-divider"></span>
            <a href="{{ route('products.all') }}" class="nav-item {{ request()->routeIs('products.all') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap"></i> সব পণ্য
            </a>
            <span class="nav-divider"></span>
            <a href="{{ url('shop') }}" class="nav-item {{ request()->is('shop*') ? 'active' : '' }}">
                <i class="bi bi-bag"></i> শপ
            </a>
            <span class="nav-divider"></span>
            <a href="{{ url('offers') }}" class="nav-item {{ request()->is('offers*') ? 'active' : '' }}">
                <i class="bi bi-tag"></i> অফার
            </a>
            <span class="nav-divider"></span>
            <a href="{{ url('new-arrivals') }}" class="nav-item {{ request()->is('new-arrivals*') ? 'active' : '' }}">
                <i class="bi bi-stars"></i> নতুন পণ্য
            </a>
            <span class="nav-divider"></span>
            <a href="{{ route('contact.details') }}" class="nav-item {{ request()->is('contact*') ? 'active' : '' }}">
                <i class="bi bi-telephone"></i> যোগাযোগ
            </a>
            <a href="{{ route('about.company') }}" class="nav-item {{ request()->is('about*') ? 'active' : '' }}">
                <i class="bi bi-info-circle"></i> আমাদের সম্পর্কে
            </a>

             <a href="{{ route('terms.conditions') }}" class="nav-item {{ request()->is('terms*') ? 'active' : '' }}">
                <i class="bi bi-info-circle"></i> শর্তাবলী
            </a>
            <span class="nav-divider"></span>
            <a href="{{ route('blog.index') }}" class="nav-item {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> ব্লগ
            </a>
            <a href="{{ route('order.track') }}" class="nav-item nav-item--track {{ request()->routeIs('order.track*') ? 'active' : '' }}">
                <i class="bi bi-truck"></i> অর্ডার ট্র্যাক করুন
            </a>
        </div>
    </div>
</nav>

{{-- Sidebar overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

{{-- Mobile Sidebar Drawer --}}
<div id="sidebar-drawer">
    @include('frontend.pages.category')
</div>

<style>
    #sidebar-drawer {
        position: fixed; top: 0; left: -300px; width: 300px; height: 100vh;
        background: #fff; z-index: 99999999; transition: all 0.3s ease;
        overflow-y: auto; box-shadow: 10px 0 30px rgba(0,0,0,0.1);
    }
    #sidebar-drawer.is-open { left: 0; }
    
    /* Ensure the sidebar inside drawer is visible and styled correctly */
    #sidebar-drawer .sidebar { width: 100% !important; display: block !important; border: none !important; box-shadow: none !important; margin: 0 !important; height: auto !important; position: static !important; }
</style>

<script>
    function toggleSidebar() {
        var drawer = document.getElementById('sidebar-drawer');
        var overlay = document.getElementById('sidebarOverlay');
        if (!drawer || !overlay) return;
        
        var isOpen = drawer.classList.toggle('is-open');
        overlay.classList.toggle('active', isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : '';
    }
</script>

{{-- ── MOBILE BOTTOM NAV ── --}}
<nav class="mob-nav" id="mobNav" aria-label="Mobile navigation">
    <div class="mob-nav__items">
        <a href="{{ url('/') }}" class="mob-nav__item {{ request()->is('/') ? 'active' : '' }}">
            <i class="bi bi-house"></i> Home
        </a>
        <a href="{{ route('products.all') }}" class="mob-nav__item {{ request()->routeIs('products.all') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap"></i> সব পণ্য
        </a>
        <a href="{{ route('order.track') }}" class="mob-nav__item mob-nav__item--track {{ request()->routeIs('order.track*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i> ট্র্যাক
        </a>
        <a href="{{ url('cart') }}" class="mob-nav__item" style="position:relative;">
            <i class="bi bi-cart3"></i> Cart
            <span class="mob-nav__badge {{ $headerCartCount == 0 ? 'zero' : '' }}" id="mobCartBadge">
                {{ $headerCartCount > 0 ? $headerCartCount : '' }}
            </span>
        </a>
        @auth
            <a href="{{ route('user.dashboard') }}" class="mob-nav__item {{ request()->routeIs('user.dashboard*') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        @else
            <a href="{{ url('customer/login') }}" class="mob-nav__item {{ request()->is('customer/login*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Login
            </a>
        @endauth
    </div>
</nav>


{{-- ══════════════════════════════════════════════════════════════
     ── FLOATING CONTACT WIDGET ──
     DB থেকে: watsapp_url, messanger_url, phone
══════════════════════════════════════════════════════════════ --}}
@if($contactinformationadmin)
<div class="float-contact-wrap" id="floatContactWrap">

    {{-- Action items (hidden until toggle opens) --}}
    <div class="float-contact-items" id="floatContactItems">

        {{-- Live Chat (messenger দিয়ে) --}}
        @if($contactinformationadmin->messanger_url)
        <a href="{{ $contactinformationadmin->messanger_url }}" target="_blank" rel="noopener"
           class="float-contact-item" style="animation-delay:.05s;" title="Live Chat">
            <span class="float-contact-label">Live Chat</span>
            <span class="float-contact-icon float-icon-chat">
                <i class="bi bi-chat-dots-fill"></i>
            </span>
        </a>
        @endif

        {{-- Messenger --}}
        @if($contactinformationadmin->messanger_url)
        <a href="{{ $contactinformationadmin->messanger_url }}" target="_blank" rel="noopener"
           class="float-contact-item" style="animation-delay:.10s;" title="Messenger">
            <span class="float-contact-label">Messenger</span>
            <span class="float-contact-icon float-icon-messenger">
                <i class="bi bi-messenger"></i>
            </span>
        </a>
        @endif

        {{-- WhatsApp --}}
        @if($contactinformationadmin->watsapp_url)
        <a href="{{ $contactinformationadmin->watsapp_url }}" target="_blank" rel="noopener"
           class="float-contact-item" style="animation-delay:.15s;" title="WhatsApp">
            <span class="float-contact-label">WhatsApp</span>
            <span class="float-contact-icon float-icon-whatsapp">
                <i class="bi bi-whatsapp"></i>
            </span>
        </a>
        @endif

        {{-- Call Us --}}
        @if($contactinformationadmin->phone)
        <a href="tel:{{ $contactinformationadmin->phone }}"
           class="float-contact-item" style="animation-delay:.20s;" title="Call Us">
            <span class="float-contact-label">Call Us</span>
            <span class="float-contact-icon float-icon-call">
                <i class="bi bi-telephone-fill"></i>
            </span>
        </a>
        @endif

    </div>

    {{-- Main toggle button --}}
    <button class="float-contact-toggle" id="floatContactToggle"
            onclick="toggleFloatContact()" aria-label="Contact Us" title="আমাদের সাথে যোগাযোগ করুন">
        <i class="bi bi-headset icon-open"></i>
        <i class="bi bi-x-lg icon-close"></i>
    </button>

</div>
@endif
{{-- ── /FLOATING CONTACT WIDGET ── --}}


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
/* ── Floating Contact Toggle ── */
function toggleFloatContact() {
    var wrap = document.getElementById('floatContactWrap');
    if (wrap) wrap.classList.toggle('open');
}
// Click outside বন্ধ করে
document.addEventListener('click', function(e) {
    var wrap = document.getElementById('floatContactWrap');
    if (wrap && wrap.classList.contains('open') && !wrap.contains(e.target)) {
        wrap.classList.remove('open');
    }
});

/* ── Live Search ── */
(function () {
    var input     = document.getElementById('globalSearch'),
        dropdown  = document.getElementById('searchDropdown'),
        results   = document.getElementById('searchResults'),
        loading   = document.getElementById('searchLoading'),
        clearBtn  = document.getElementById('searchClear'),
        searchBox = document.getElementById('hdrSearch'),
        ajaxUrl   = '{{ route("search.ajax") }}',
        searchUrl = '{{ route("search.results") }}';

    var debounceTimer = null, lastQuery = '', activeIdx = -1, currentItems = [];

    function highlight(t, q) {
        if (!q) return t;
        return t.replace(new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi'),
            '<mark class="search-highlight">$1</mark>');
    }
    function openDrop()  { dropdown.classList.add('active');    searchBox.classList.add('has-results','focused'); }
    function closeDrop() { dropdown.classList.remove('active'); searchBox.classList.remove('has-results'); activeIdx = -1; currentItems = []; }
    function showLoad()  { loading.classList.add('active');    results.innerHTML = ''; openDrop(); }
    function hideLoad()  { loading.classList.remove('active'); }

    function renderResults(data, q) {
        hideLoad(); results.innerHTML = ''; currentItems = []; activeIdx = -1;
        var hasP = data.products   && data.products.length   > 0;
        var hasC = data.categories && data.categories.length > 0;
        if (!hasP && !hasC) {
            results.innerHTML = '<div class="sd-empty"><i class="bi bi-search"></i>"<strong>' + q + '</strong>" এর জন্য কোনো পণ্য পাওয়া যায়নি।</div>';
            return;
        }
        if (hasC) {
            results.innerHTML += '<div class="sd-section-hd"><i class="bi bi-grid-3x3-gap"></i> ক্যাটাগরি</div>';
            data.categories.forEach(function (cat) {
                var el = document.createElement('a');
                el.className = 'sd-cat-item sd-item';
                el.href = cat.url;
                el.innerHTML = '<div class="sd-cat-img"><img src="' + cat.image + '" alt="' + cat.name + '" loading="lazy"></div>'
                    + '<span class="sd-cat-name">' + highlight(cat.name, q) + '</span>'
                    + '<i class="bi bi-chevron-right" style="color:var(--muted);font-size:11px;margin-left:auto"></i>';
                results.appendChild(el); currentItems.push(el);
            });
        }
        if (hasP) {
            results.innerHTML += '<div class="sd-section-hd"><i class="bi bi-bag"></i> পণ্য</div>';
            data.products.forEach(function (p) {
                var badge = p.in_stock ? '<span class="sd-prod-badge">In Stock</span>' : '<span class="sd-prod-badge out">স্টক নেই</span>';
                var el = document.createElement('a');
                el.className = 'sd-prod-item sd-item'; el.href = p.url;
                el.innerHTML = '<div class="sd-prod-img"><img src="' + p.image + '" alt="' + p.name + '" loading="lazy"></div>'
                    + '<div class="sd-prod-info"><div class="sd-prod-name">' + highlight(p.name, q) + '</div>'
                    + '<div class="sd-prod-cat">' + p.category + '</div>' + badge + '</div>'
                    + '<div class="sd-prod-price-wrap"><div class="sd-prod-price">৳ ' + p.price + '</div>'
                    + (p.old_price ? '<div class="sd-prod-old">৳ ' + p.old_price + '</div>' : '') + '</div>';
                results.appendChild(el); currentItems.push(el);
            });
        }
        var va = document.createElement('a');
        va.className = 'sd-view-all';
        va.href = searchUrl + '?q=' + encodeURIComponent(q);
        va.innerHTML = 'সব ফলাফল দেখুন "' + q + '" <i class="bi bi-arrow-right"></i>';
        results.appendChild(va);
    }

    function setActive(idx) {
        currentItems.forEach(function (el, i) { el.style.background = i === idx ? 'var(--light)' : ''; });
        activeIdx = idx;
    }

    function doAjax(q) {
        if (q === lastQuery) return;
        lastQuery = q;
        if (q.length < 2) { closeDrop(); return; }
        showLoad();
        fetch(ajaxUrl + '?q=' + encodeURIComponent(q), {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        }).then(function(r) { return r.json(); })
          .then(function(data) { renderResults(data, q); })
          .catch(function() {
              hideLoad();
              results.innerHTML = '<div class="sd-empty"><i class="bi bi-wifi-off"></i> নেটওয়ার্ক সমস্যা হয়েছে।</div>';
          });
    }

    input.addEventListener('input', function () {
        var q = this.value.trim();
        clearBtn.classList.toggle('visible', q.length > 0);
        clearTimeout(debounceTimer);
        if (q.length < 2) { closeDrop(); return; }
        debounceTimer = setTimeout(function () { doAjax(q); }, 300);
    });

    input.addEventListener('keydown', function (e) {
        if (!dropdown.classList.contains('active')) return;
        if      (e.key === 'ArrowDown') { e.preventDefault(); setActive(Math.min(activeIdx + 1, currentItems.length - 1)); }
        else if (e.key === 'ArrowUp')   { e.preventDefault(); setActive(Math.max(activeIdx - 1, 0)); }
        else if (e.key === 'Enter')     { if (activeIdx >= 0 && currentItems[activeIdx]) { e.preventDefault(); currentItems[activeIdx].click(); } else { doSearch(); } }
        else if (e.key === 'Escape')    { closeDrop(); input.blur(); }
    });

    input.addEventListener('focus', function () {
        searchBox.classList.add('focused');
        var q = this.value.trim();
        if (q.length >= 2 && results.innerHTML.trim()) openDrop();
    });

    clearBtn.addEventListener('click', function () {
        input.value = ''; clearBtn.classList.remove('visible'); closeDrop(); lastQuery = ''; input.focus();
    });

    document.addEventListener('click', function (e) {
        if (!document.getElementById('searchWrap').contains(e.target)) {
            closeDrop(); searchBox.classList.remove('focused');
        }
    });
})();

function doSearch() {
    var qInput = document.getElementById('globalSearch');
    var q = qInput ? qInput.value.trim() : '';
    if (q) {
        // Tracking Search
        if (typeof fbq !== 'undefined') {
            fbq('track', 'Search', { search_string: q });
        }
        if (typeof dataLayer !== 'undefined') {
            dataLayer.push({
                'event': 'search',
                'search_term': q
            });
        }
        window.location.href = '{{ route("search.results") }}?q=' + encodeURIComponent(q);
    }
}
document.getElementById('globalSearch') && document.getElementById('globalSearch').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') doSearch();
});

/* ── Badge updater ── */
function updateBadges(cartCount, wishCount) {
    var cb = document.getElementById('cartBadge');
    var mb = document.getElementById('mobCartBadge');
    var wb = document.getElementById('wishBadge');
    if (cb) { cb.textContent = cartCount > 0 ? cartCount : ''; cb.classList.toggle('zero', cartCount === 0); }
    if (mb) { mb.textContent = cartCount > 0 ? cartCount : ''; mb.classList.toggle('zero', cartCount === 0); }
    if (wb) { wb.textContent = wishCount  > 0 ? wishCount  : ''; wb.classList.toggle('zero', wishCount  === 0); }
}
</script>
