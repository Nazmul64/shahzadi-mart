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
    <title>Shahzadimart Shop</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700;800;900&family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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

{{-- GTM noscript --}}
@if($gtmId)
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
@endif

{{-- ── TOP BAR ── --}}
<div class="top-bar">
    <div class="top-bar__in">
        <div class="top-bar__promo">
            <span class="top-bar__dot"></span>
            <i class="bi bi-lightning-charge-fill" style="color:var(--gold);font-size:11px"></i>
            Free shipping on orders over ৳ 5,000 — Shop now!
        </div>
        <div class="top-bar__nav">
            <a href="{{ route('order.track') }}" class="top-bar__track"><i class="bi bi-truck"></i> অর্ডার ট্র্যাক</a>
            <a href="{{ route('products.all') }}"><i class="bi bi-grid-3x3-gap"></i> সব পণ্য</a>
            <a href="#"><i class="bi bi-shop"></i> Sell on Shahzadi</a>
            <a href="#"><i class="bi bi-geo-alt"></i> Our Stores</a>
        </div>
    </div>
</div>

{{-- ── MAIN HEADER ── --}}
<header class="site-hdr">
    <div class="site-hdr__in">

        <button class="hamb" onclick="toggleSidebar()" aria-label="Toggle menu">
            <i class="bi bi-list"></i>
        </button>

        <a href="{{ url('/') }}" class="logo">
            <img src="{{ !empty($websetting?->header_logo) ? asset($websetting->header_logo) : asset('default/logo.png') }}"
                 alt="Shahzadimart Logo" style="height:70px;width:auto;">
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
    </div>
</header>

{{-- ── SECONDARY NAV ── --}}
<nav class="site-nav" aria-label="Main navigation">
    <div class="site-nav__in">
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

         <a href="{{ route('terms.conditions') }}" class="nav-item {{ request()->is('about*') ? 'active' : '' }}">
            <i class="bi bi-info-circle"></i> শর্তাবলী
        </a>
        <a href="{{ route('order.track') }}" class="nav-item nav-item--track {{ request()->routeIs('order.track*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i> অর্ডার ট্র্যাক করুন
        </a>
    </div>
</nav>

{{-- Sidebar overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

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
    var q = (document.getElementById('globalSearch') || {}).value;
    if (q && q.trim()) window.location.href = '{{ route("search.results") }}?q=' + encodeURIComponent(q.trim());
}
document.getElementById('globalSearch') && document.getElementById('globalSearch').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') doSearch();
});

/* ── Mobile sidebar toggle ── */
function toggleSidebar() {
    var sb  = document.getElementById('sidebar');
    var ovl = document.getElementById('sidebarOverlay');
    if (!sb || !ovl) return;
    var open = sb.classList.toggle('is-open');
    ovl.classList.toggle('active', open);
    document.body.style.overflow = open ? 'hidden' : '';
}
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        var sb = document.getElementById('sidebar');
        if (sb && sb.classList.contains('is-open')) toggleSidebar();
    }
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
