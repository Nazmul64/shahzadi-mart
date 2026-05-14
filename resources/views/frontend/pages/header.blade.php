{{-- resources/views/frontend/pages/header.blade.php --}}

@php
    // Centralized Tracking from Generalsetting
    $fbPixelId = ($gs->facebook_pixel_status && $gs->facebook_pixel_id) ? trim($gs->facebook_pixel_id) : null;
    $gtmId     = ($gs->gtm_status && $gs->gtm_id) ? trim($gs->gtm_id) : null;

    // AppServiceProvider থেকে cached share হচ্ছে — আর DB query নেই
    $deliveryInfo = $sharedDeliveryInfo ?? null;
    // $navLanding ইতিমধ্যে AppServiceProvider থেকে share হচ্ছে
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">
    @php
        $siteName = $gs->site_name;
        $websitefavicon = \App\Models\Websitefavicon::getSettings();

        $seoTitle = $siteName;
        $seoDesc  = '';
        $seoKeys  = 'online shop, ecommerce, bangladesh, premium products';
        $ogImg    = !empty($websetting?->header_logo) ? asset($websetting->header_logo) : asset('default/logo.png');
        $ogType   = 'website';
        $canonicalUrl = url()->current();

        if (isset($product)) {
            $seoTitle = ($product->meta_title ?: $product->name) . ' - ' . $siteName;
            $seoDesc  = $product->meta_description ?: substr(strip_tags($product->description), 0, 160);
            $seoKeys  = $product->meta_keywords ?: $product->meta_tags ?: (is_array($product->tags ?? null) ? implode(', ', $product->tags) : ($product->tags ?? ''));
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
    {{-- ══ GOOGLE ANALYTICS (GA4) ══ --}}
    @if($gs->analytics_status && $gs->analytics_id)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gs->analytics_id }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $gs->analytics_id }}');
    </script>
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

    {{-- ── Structured Data (JSON-LD) for SEO ── --}}
    @if(isset($product))
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org/",
      "@@type": "Product",
      "name": "{{ $product->name }}",
      "image": "{{ $ogImg }}",
      "description": "{{ $seoDesc }}",
      "sku": "{{ $product->sku }}",
      "brand": {
        "@@type": "Brand",
        "name": "{{ $product->brand->name ?? $siteName }}"
      },
      "offers": {
        "@@type": "Offer",
        "url": "{{ $canonicalUrl }}",
        "priceCurrency": "BDT",
        "price": "{{ $product->current_price }}",
        "availability": "https://schema.org/InStock",
        "itemCondition": "https://schema.org/NewCondition"
      }
    }
    </script>
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&family=Roboto:wght@400;500;700&family=Poppins:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700;800&family=Lato:wght@400;700;900&family=Raleway:wght@400;500;600;700;800&family=Nunito:wght@400;500;600;700;800&family=Ubuntu:wght@400;500;700&family=Oswald:wght@400;500;600;700&family=Merriweather:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&family=Lora:wght@400;500;600;700&family=Quicksand:wght@400;500;600;700&family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset($websitefavicon->favicon_logo ?? 'default/favicon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    {{-- Owl Carousel --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/main.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/index.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/footer.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/newproduct.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/offer.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/shop.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/allproduct.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/productdetils.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/custom-loader.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/custom-style.css">
    <style>
        /* ══ Dynamic Font Family from Admin Settings ══ */
        html, body {
            max-width: 100% !important;
            overflow-x: hidden !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            font-size: var(--base-size) !important;
            font-family: var(--font-main) !important;
        }
        /* Override ALL text elements globally */
        body *:not(i):not([class*="fa"]):not([class*="bi-"]):not(.bi) {
            font-family: var(--font-main) !important;
        }
        :root {
            --red: {{ $gs->primary_color ?? '#be0318' }};
            --red-d: {{ ($gs->primary_color ? $gs->primary_color . 'cc' : '#96010f') }};
            --top-bg: {{ $gs->top_header_bg_color ?? '#0B1121' }};
            --top-text: {{ $gs->top_header_text_color ?? '#94a3b8' }};
            --main-bg: {{ $gs->main_header_bg_color ?? '#ffffff' }};
            --main-text: {{ $gs->main_header_text_color ?? '#333333' }};
            --btn-bg: {{ $gs->button_bg_color ?? '#be0318' }};
            --btn-text: {{ $gs->button_text_color ?? '#ffffff' }};
            --font-main: "{{ $gs->font_family }}", sans-serif;
            --base-size: {{ $gs->font_size ?? 16 }}px;
            --base-size-mob: {{ $gs->product_font_size_mobile ?? 12 }}px;
            --p-img-h-mob: {{ $gs->product_img_height_mobile ?? 180 }}px;
        }

        /* ── Dynamic Layout Settings ── */
        @media (min-width: 1201px) {
            .smhome-prod-grid, .smp-grid, .cp-prod-grid, .ofp-grid {
                grid-template-columns: repeat({{ $gs->products_per_row ?? 5 }}, 1fr) !important;
            }
        }
        @media (min-width: 992px) {
            .smhome-prod-grid, .smp-grid, .ofp-grid, .cp-prod-grid, .na-grid {
                grid-template-columns: repeat({{ $gs->products_per_row ?? 4 }}, 1fr) !important;
            }
        }
        @media (max-width: 991px) {
            .smhome-prod-grid, .smp-grid, .ofp-grid, .cp-prod-grid, .na-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 8px !important;
            }
        }

        /* 3. Image Container */
        .smhome-p-img-wrap, .smp-img-wrap, .ofp-img-wrap, .cp-img-wrap, .na-img-wrap {
            height: {{ $gs->product_img_height ?? 240 }}px !important;
        }
        .smhome-p-img, .smp-img, .ofp-img, .cp-img, .na-img {
            object-fit: {{ $gs->product_img_fit ?? 'cover' }} !important;
        }

        .smhome-p-stars-row {
            display: {{ ($gs->show_rating_stars ?? 1) == 1 ? 'flex' : 'none' }} !important;
        }

        /* 6. Dynamic Category Circles */
        .smhome-circle-item { width: {{ $gs->category_img_width ?? 80 }}px !important; }
        .smhome-circle-img {
            width: {{ $gs->category_img_width ?? 80 }}px !important;
            height: {{ $gs->category_img_height ?? 80 }}px !important;
            border-radius: {{ ($gs->category_img_shape ?? 'circle') == 'circle' ? '50%' : '8px' }} !important;
        }

        @media (max-width: 991px) {
            .smhome-circle-item {
                width: {{ $gs->category_img_width ?? 80 }}px !important;
            }
            .smhome-circle-img {
                width: {{ $gs->category_img_width ?? 80 }}px !important;
                height: {{ $gs->category_img_height ?? 80 }}px !important;
            }
            /* Category Name Font Size */
            .smhome-circle-item p, .cp-sub-name, .smp-cat-name {
                font-size: {{ $gs->product_font_size_mobile ?? 12 }}px !important;
            }
            /* Global Button Font Size */
            .smhome-p-order-btn, .pdp__btn, .pdp__contact-btn, .cp-atc, .ofp-btn, .smp-order-btn, .na-order-btn, .btn-buy, .btn-cart, .add-to-cart, .smhome-load-more-btn {
                font-size: {{ $gs->product_font_size_mobile ?? 12 }}px !important;
            }
            .smhome-p-name {
                font-size: {{ $gs->product_font_size_mobile ?? 12 }}px !important;
            }
            .smhome-p-price {
                font-size: {{ ($gs->product_font_size_mobile ?? 12) + 2 }}px !important;
            }
        }

        /* ── Global Product Name Truncation (Single Line) ── */
        .smhome-p-name, 
        .sp-card-name, 
        .smp-card-name, 
        .sr-p-name, 
        .ofp-name, 
        .na-name, 
        .chp-card-name, 
        .td-product-name, 
        .pdp__prod-name,
        .smhome-p-name a,
        .sp-card-name a,
        .smp-card-name a,
        .sr-p-name a,
        .ofp-name a,
        .na-name a,
        .chp-card-name a {
            display: -webkit-box !important;
            -webkit-line-clamp: 1 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            min-height: unset !important;
            height: auto !important;
            line-height: 1.4 !important;
        }

        /* ── Design Restoration & Sticky ── */
        .top-bar { background-color: var(--top-bg) !important; color: var(--top-text) !important; position: relative; z-index: 2000002; }
        .top-bar a { color: var(--top-text) !important; }

        .site-hdr {
            background-color: var(--main-bg) !important;
            color: var(--main-text) !important;
            width: 100% !important;
            position: relative !important;
            z-index: 2000001 !important;
        }
        .site-hdr .h-act__lbl, .site-hdr .logo { color: var(--main-text) !important; }

        .site-nav { position: relative !important; z-index: 1000000 !important; overflow: visible !important; background: var(--red) !important; height: 55px !important; display: flex !important; align-items: center; }
        .site-nav > div { overflow: visible !important; height: 100% !important; }
        .site-nav__in { display: flex !important; align-items: center !important; height: 100% !important; width: 100% !important; overflow: visible !important; }

        /* ── LAYOUT FIX: Lower Stacking for Page content ── */
        .main-site-content { position: relative !important; z-index: 1 !important; }
        .page-wrap.no-sidebar { grid-template-columns: 1fr !important; gap: 0 !important; position: relative !important; z-index: 1 !important; }

        .main-site-content { position: relative !important; z-index: 1 !important; }
        .page-wrap.no-sidebar { grid-template-columns: 1fr !important; gap: 0 !important; position: relative !important; z-index: 1 !important; }

        /* ── FULL WIDTH CONTENT ON MOBILE ── */
        @media (max-width: 991px) {
            html, body {
                width: 100% !important;
                overflow-x: hidden !important;
            }
            .container, .container-fluid, .main-site-content, .page-wrap, .content-area, .content-area-inner, .smhome-ci {
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            .page-wrap {
                padding-top: 0 !important;
                padding-bottom: 60px !important; /* Bottom nav space */
            }
            .content-area-inner {
                padding: 0 !important;
            }
            .product-details-wrap, .product-details, .pd-main, .pd-info, .pd-desc {
                padding-left: 8px !important; /* Minimal padding for text readability */
                padding-right: 8px !important;
            }
            .smhome-section, .smp-section, .ofp-section, .na-section, .cp-section {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .smhome-prod-grid, .smp-grid, .ofp-grid, .cp-prod-grid, .na-grid {
                padding: 0 8px !important;
                gap: 8px !important;
            }
            /* Row and Column resets */
            .row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            .row > * {
                padding-left: 8px !important;
                padding-right: 8px !important;
            }

            /* ── HOME PAGE MOBILE OPTIMIZATION ── */
            .smhome-ci {
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            .smhome-hero-panel, .smhome-landing-mobile-btn-wrap {
                display: none !important;
            }
            .smhome-hero {
                grid-template-columns: 1fr !important;
            }
            .smhome-circles-box {
                padding: 15px 5px !important;
                margin: 0 !important;
                background: transparent !important;
                box-shadow: none !important;
                border: none !important;
                width: 100% !important;
            }
            .smhome-circle-img {
                width: 65px !important;
                height: 65px !important;
            }
            .smhome-circle-item p {
                font-size: 11px !important;
                white-space: normal !important;
                line-height: 1.2 !important;
            }
            .smhome-circles-track.grid-mode {
                display: flex !important;
                flex-wrap: nowrap !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
                gap: 15px !important;
                padding-bottom: 10px !important;
            }
            .smhome-circles-track.grid-mode::-webkit-scrollbar {
                display: none !important;
            }
            .smhome-sec-head, .smhome-flash-hd, .smhome-prod-grid {
                padding-left: 4px !important;
                padding-right: 4px !important;
                width: 100% !important;
            }

            /* ── PRODUCT DETAILS FULL WIDTH ── */
            .pdp__wrap {
                padding: 0 !important;
            }
            .pdp__card {
                margin-top: 0 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }
            .pdp__grid {
                gap: 0 !important;
            }
            .pdp__gallery, .pdp__info {
                padding: 4px !important;
                border-left: none !important;
                border-right: none !important;
            }
            .pdp__bread {
                padding: 0 4px !important;
            }
            .pdp__breadbar {
                padding: 8px 0 !important;
            }
            .pdp__sidebar {
                padding: 4px !important;
            }
            .pdp__tabs {
                border-radius: 0 !important;
                margin-top: 10px !important;
                box-shadow: none !important;
                border-top: 1px solid #eee !important;
            }
            .pdp__tab-pane {
                padding: 15px !important;
            }
            .pdp__related {
                border-radius: 0 !important;
                margin-top: 10px !important;
                box-shadow: none !important;
                padding: 15px !important;
                border-top: 1px solid #eee !important;
            }
        }

        /* ── Dynamic Layout Settings ── */
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
            max-height: 500px !important; overflow-y: auto !important;
            scrollbar-width: thin !important;
            scrollbar-color: var(--red) transparent !important;
        }
        .nav-cat-menu::-webkit-scrollbar { width: 5px; }
        .nav-cat-menu::-webkit-scrollbar-thumb { background: var(--red); border-radius: 10px; }
        .nav-cat-menu::-webkit-scrollbar-track { background: transparent; }

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

        .nav-cat-menu .sidebar { display: block !important; width: 100% !important; border: none !important; margin: 0 !important; box-shadow: none !important; position: static !important; max-height: none !important; overflow: visible !important; }
        .nav-cat-menu .sb-head { display: none !important; }
        .nav-cat-menu a { color: #333 !important; text-decoration: none !important; font-weight: 600 !important; display: block !important; padding: 8px 20px !important; transition: all 0.2s; }
        .smhome-p-available { font-size: 11px; font-weight: 700; margin-bottom: 4px; display: flex; align-items: center; gap: 4px; }
        .smhome-p-available i { font-size: 10px; }
        
        .site-hdr { background: var(--main-bg) !important; position: relative !important; z-index: 2000001 !important; transition: all 0.3s; }
        .nav-cat-menu a:hover { background: #f8f9fa !important; color: var(--red) !important; padding-left: 25px !important; }

        /* ── SEARCH BAR CLEANUP ── */
        .hdr-search-wrap { position: relative !important; z-index: 1000 !important; }
        .hdr-search { box-shadow: none !important; border-color: var(--border) !important; }
        .hdr-search.focused, .hdr-search:focus-within { box-shadow: none !important; border-color: var(--red) !important; background: var(--white) !important; }
        .search-dropdown { z-index: 1001 !important; }
        /* Hide search bar when drawer is open on mobile */
        body.drawer-open .hdr-search-wrap { z-index: 1 !important; }

        /* ══════════════════════════════════════════
           MOBILE HEADER FIX — ICONS FULLY VISIBLE
        ══════════════════════════════════════════ */

        /* Desktop header inner layout */
        .site-hdr__in {
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
            gap: 12px !important;
            padding: 10px 0 !important;
            flex-wrap: nowrap !important;
        }

        /* hdr-actions ALWAYS visible, flex row */
        .hdr-actions {
            display: flex !important;
            align-items: center !important;
            gap: 4px !important;
            flex-shrink: 0 !important;
            margin-left: auto !important;
        }

        /* Each icon button */
        .h-act {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            color: var(--main-text) !important;
            cursor: pointer !important;
            position: relative !important;
            padding: 6px 8px !important;
            border-radius: 8px !important;
            transition: background 0.2s ease !important;
            min-width: 40px !important;
            background: transparent !important;
            border: none !important;
            outline: none !important;
        }
        .h-act:hover { background: rgba(0,0,0,0.06) !important; }
        .h-act i {
            font-size: 22px !important;
            color: var(--main-text) !important;
            display: block !important;
            line-height: 1 !important;
        }
        .h-act__lbl {
            font-size: 10px !important;
            font-weight: 600 !important;
            color: var(--main-text) !important;
            margin-top: 2px !important;
            white-space: nowrap !important;
            display: block !important;
        }

        /* Badge */
        .h-badge {
            position: absolute !important;
            top: 2px !important;
            right: 2px !important;
            background: var(--red) !important;
            color: #fff !important;
            font-size: 9px !important;
            font-weight: 800 !important;
            min-width: 16px !important;
            height: 16px !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 3px !important;
            line-height: 1 !important;
            pointer-events: none !important;
        }
        .h-badge.zero { display: none !important; }

        /* hdr-drop (dropdown menus) */
        .hdr-drop-wrap {
            position: relative !important;
            display: inline-flex !important;
            align-items: center !important;
        }
        .hdr-drop {
            position: absolute !important;
            top: calc(100% + 8px) !important;
            right: 0 !important;
            min-width: 260px !important;
            background: #fff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
            z-index: 2000000000 !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transform: translateY(10px) !important;
            transition: all 0.25s ease !important;
            pointer-events: none !important;
        }
        .hdr-drop-wrap:hover .hdr-drop,
        .hdr-drop-wrap:focus-within .hdr-drop {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
            pointer-events: all !important;
        }

        /* Hamb button */
        .hamb {
            display: none !important;
            background: none !important;
            border: none !important;
            font-size: 26px !important;
            cursor: pointer !important;
            color: var(--main-text) !important;
            padding: 4px 8px !important;
            flex-shrink: 0 !important;
            line-height: 1 !important;
        }

        /* Logo */
        .logo {
            display: flex !important;
            align-items: center !important;
            text-decoration: none !important;
            flex-shrink: 0 !important;
            position: relative !important;
        }
        .logo img { height: 60px !important; width: auto !important; display: block !important; }
        .logo__dot {
            width: 6px !important; height: 6px !important;
            border-radius: 50% !important;
            background: var(--red) !important;
            position: absolute !important;
            bottom: 2px !important; right: -8px !important;
        }

        /* Search wrap */
        .hdr-search-wrap {
            flex: 1 !important;
            min-width: 0 !important;
            position: relative !important;
        }
        .hdr-search {
            display: flex !important;
            align-items: center !important;
            border: 2px solid #e5e7eb !important;
            border-radius: 10px !important;
            overflow: hidden !important;
            background: #f9fafb !important;
            height: 44px !important;
            transition: border-color 0.2s !important;
        }
        .hdr-search input {
            flex: 1 !important;
            border: none !important;
            background: transparent !important;
            padding: 0 12px !important;
            font-size: 14px !important;
            outline: none !important;
            color: #1e293b !important;
            min-width: 0 !important;
        }
        .hdr-search__btn {
            background: var(--red) !important;
            color: #fff !important;
            border: none !important;
            padding: 0 18px !important;
            height: 100% !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            white-space: nowrap !important;
            flex-shrink: 0 !important;
        }
        .search-clear {
            background: none !important;
            border: none !important;
            color: #9ca3af !important;
            cursor: pointer !important;
            padding: 0 8px !important;
            display: none !important;
            font-size: 14px !important;
        }
        .search-clear.visible { display: flex !important; align-items: center !important; }

        /* Track order button */
        .track-order-btn {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-decoration: none !important;
            color: var(--main-text) !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            gap: 2px !important;
            flex-shrink: 0 !important;
            padding: 4px 8px !important;
            border-radius: 8px !important;
            transition: background 0.2s !important;
        }
        .track-order-btn:hover { background: #f3f4f6 !important; }
        .track-order-btn i { font-size: 20px !important; color: var(--main-text) !important; }
        .track-lbl { font-size: 9px !important; white-space: nowrap !important; }

        /* ── DESKTOP: show labels ── */
        @media (min-width: 992px) {
            .h-act__lbl { display: block !important; }
            .hamb { display: none !important; }
            .logo img { height: 70px !important; }
        }

        /* ── TABLET / MOBILE (≤991px) ── */
        @media (max-width: 991px) {
            .site-nav { display: none !important; }

            .site-hdr { padding: 0 !important; }

            .site-hdr__in {
                flex-wrap: wrap !important;
                padding: 8px 4px !important;
                gap: 8px !important;
                align-items: center !important;
            }

            /* Row 1: hamb | logo | actions */
            .hamb {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                order: 1 !important;
            }
            .logo { order: 2 !important; flex: 1 !important; }
            .logo img { height: 45px !important; }

            /* Actions ALWAYS visible on mobile */
            .hdr-actions {
                order: 3 !important;
                display: flex !important;
                align-items: center !important;
                gap: 0px !important;
                flex-shrink: 0 !important;
                margin-left: 0 !important;
            }

            /* Row 2: search full width */
            .hdr-search-wrap {
                order: 4 !important;
                width: 100% !important;
                flex: none !important;
                margin-top: 0 !important;
            }
            .hdr-search { height: 40px !important; }
            .hdr-search input { font-size: 13px !important; }
            .hdr-search__btn { padding: 0 14px !important; font-size: 12px !important; }

            /* Hide label text on mobile but KEEP icons */
            .h-act__lbl { display: none !important; }
            .h-act {
                padding: 6px 6px !important;
                min-width: 36px !important;
            }
            .h-act i { font-size: 22px !important; }

            /* Hide track-order text link in header (already in nav) */
            .track-order-btn { display: none !important; }

            /* Dropdowns on mobile: open on click via JS */
            .hdr-drop {
                right: 0 !important;
                left: auto !important;
                min-width: 240px !important;
                max-height: 70vh !important;
                overflow-y: auto !important;
            }
        }

        /* ── Extra Small ≤ 380px ── */
        @media (max-width: 380px) {
            .site-hdr__in { padding: 6px 6px !important; gap: 4px !important; }
            .h-act { padding: 5px 4px !important; min-width: 32px !important; }
            .h-act i { font-size: 20px !important; }
            .logo img { height: 38px !important; }
        }

        /* ── Top Bar ── */
        .top-bar { background-color: var(--top-bg) !important; color: var(--top-text) !important; position: relative; z-index: 2000002; }
        .top-bar a { color: var(--top-text) !important; }

        /* ── Toastr Visibility Fix ── */
        #toast-container { z-index: 2147483647 !important; top: 12px !important; }
        .toast { opacity: 1 !important; box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important; }

        /* ══════════════════════════════════════════
           SEARCH DROPDOWN
        ══════════════════════════════════════════ */
        .search-dropdown {
            position: absolute !important;
            top: calc(100% + 4px) !important;
            left: 0 !important; right: 0 !important;
            background: #fff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
            z-index: 99999 !important;
            display: none !important;
            max-height: 420px !important;
            overflow-y: auto !important;
        }
        .search-dropdown.active { display: block !important; }
        .search-loading { display: none; align-items: center; gap: 8px; padding: 16px 20px; font-size: 13px; color: #64748b; }
        .search-loading.active { display: flex; }
        .search-spinner { width: 16px; height: 16px; border: 2px solid #e5e7eb; border-top-color: var(--red); border-radius: 50%; animation: spin .6s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .sd-section-hd { font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: .6px; padding: 10px 16px 4px; }
        .sd-item { display: flex !important; align-items: center !important; gap: 10px !important; padding: 8px 16px !important; text-decoration: none !important; transition: background .15s !important; }
        .sd-item:hover { background: #f8f9fa !important; }
        .sd-cat-img { width: 36px; height: 36px; border-radius: 6px; overflow: hidden; flex-shrink: 0; }
        .sd-cat-img img, .sd-prod-img img { width: 100%; height: 100%; object-fit: cover; }
        .sd-cat-name { font-size: 13px; font-weight: 600; color: #1e293b; }
        .sd-prod-img { width: 44px; height: 44px; border-radius: 8px; overflow: hidden; flex-shrink: 0; }
        .sd-prod-info { flex: 1; min-width: 0; }
        .sd-prod-name { font-size: 13px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sd-prod-cat { font-size: 11px; color: #94a3b8; }
        .sd-prod-badge { font-size: 9px; font-weight: 700; padding: 1px 6px; border-radius: 4px; background: #dcfce7; color: #15803d; }
        .sd-prod-badge.out { background: #fee2e2; color: #dc2626; }
        .sd-prod-price-wrap { text-align: right; flex-shrink: 0; }
        .sd-prod-price { font-size: 13px; font-weight: 800; color: var(--red); }
        .sd-prod-old { font-size: 11px; color: #9ca3af; text-decoration: line-through; }
        .sd-empty { padding: 20px 16px; font-size: 13px; color: #64748b; text-align: center; }
        .sd-view-all { display: flex; align-items: center; justify-content: center; gap: 6px; padding: 12px; font-size: 13px; font-weight: 700; color: var(--red); border-top: 1px solid #f1f5f9; text-decoration: none; }
        mark.search-highlight { background: #fef3c7; color: inherit; padding: 0; border-radius: 2px; }

        /* ══════════════════════════════════════════
           ACCOUNT / WISHLIST / CART DROPDOWNS
        ══════════════════════════════════════════ */
        .acct-drop__hd { padding: 16px; border-bottom: 1px solid #f1f5f9; }
        .user-greeting { display: block; font-weight: 700; font-size: 14px; color: #1e293b; }
        .user-email { display: block; font-size: 12px; color: #94a3b8; margin: 2px 0 8px; }
        .acct-dash-btn { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: var(--red); color: #fff !important; border-radius: 6px; font-size: 12px; font-weight: 700; text-decoration: none; }
        .acct-drop__hd p { margin: 0 0 8px; font-size: 13px; color: #64748b; }
        .acct-signin { display: block; width: 100%; padding: 9px; background: var(--red); color: #fff; border: none; border-radius: 6px; font-weight: 700; font-size: 13px; cursor: pointer; }
        .hdr-drop a { display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 13px; font-weight: 600; color: #334155; text-decoration: none; transition: all .15s; border-bottom: 1px solid #f8fafc; }
        .hdr-drop a:hover { background: #f8f9fa; color: var(--red); padding-left: 20px; }
        .hdr-drop a.logout { color: #dc2626; }
        .hdr-drop a.logout:hover { background: #fff5f5; }

        /* Wishlist drop */
        .wish-drop { min-width: 300px !important; }
        .wish-drop__hd { display: flex; align-items: center; gap: 8px; padding: 12px 16px; border-bottom: 1px solid #f1f5f9; font-weight: 700; font-size: 14px; color: #1e293b; }
        .wish-count-pill { margin-left: auto; background: var(--red); color: #fff; font-size: 10px; font-weight: 800; padding: 1px 7px; border-radius: 10px; }
        .wish-drop__body { max-height: 280px; overflow-y: auto; }
        .wish-item { display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-bottom: 1px solid #f8fafc; }
        .wish-item__img { width: 48px; height: 48px; border-radius: 8px; overflow: hidden; flex-shrink: 0; }
        .wish-item__img img { width: 100%; height: 100%; object-fit: cover; }
        .wish-item__info { flex: 1; min-width: 0; }
        .wish-item__name { display: block; font-size: 12px; font-weight: 600; color: #1e293b; text-decoration: none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .wish-item__price { font-size: 13px; font-weight: 800; color: var(--red); }
        .wish-item__old { font-size: 11px; color: #9ca3af; text-decoration: line-through; margin-left: 4px; }
        .wish-item__add { display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: var(--red); color: #fff; text-decoration: none; flex-shrink: 0; font-size: 14px; }
        .wish-drop__empty { padding: 20px; text-align: center; font-size: 13px; color: #94a3b8; }
        .wish-drop__foot { display: flex; align-items: center; justify-content: center; gap: 6px; padding: 12px; font-size: 12px; font-weight: 700; color: var(--red); border-top: 1px solid #f1f5f9; text-decoration: none; }

        /* Cart drop */
        .cart-drop { min-width: 320px !important; }
        .cart-drop__hd { display: flex; align-items: center; gap: 8px; padding: 12px 16px; border-bottom: 1px solid #f1f5f9; font-weight: 700; font-size: 14px; color: #1e293b; }
        .cart-count-pill { margin-left: auto; background: var(--red); color: #fff; font-size: 10px; font-weight: 800; padding: 1px 7px; border-radius: 10px; }
        .cart-drop__body { max-height: 280px; overflow-y: auto; }
        .cart-mini-item { display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-bottom: 1px solid #f8fafc; }
        .cart-mini-img { width: 52px; height: 52px; border-radius: 8px; overflow: hidden; flex-shrink: 0; position: relative; }
        .cart-mini-img img { width: 100%; height: 100%; object-fit: cover; }
        .cart-mini-qty { position: absolute; top: -4px; right: -4px; background: var(--red); color: #fff; font-size: 9px; font-weight: 800; width: 16px; height: 16px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .cart-mini-info { flex: 1; min-width: 0; }
        .cart-mini-name { display: block; font-size: 12px; font-weight: 600; color: #1e293b; text-decoration: none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .cart-mini-variants { font-size: 10px; color: #94a3b8; margin-top: 1px; }
        .cart-mini-price { font-size: 13px; font-weight: 800; color: var(--red); margin-top: 2px; }
        .cart-mini-remove { color: #e74c3c; font-size: 14px; padding: 4px; text-decoration: none; flex-shrink: 0; }
        .cart-drop__empty { padding: 20px; text-align: center; font-size: 13px; color: #94a3b8; }
        .cart-drop__summary { padding: 12px 16px; border-top: 1px solid #f1f5f9; }
        .cart-drop__total { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
        .cart-drop__total-lbl { font-size: 13px; color: #64748b; font-weight: 600; }
        .cart-drop__total-val { font-size: 16px; font-weight: 900; color: var(--red); }
        .cart-drop__btns { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .cart-drop__btn { display: flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; transition: all .2s; }
        .cart-drop__btn--view { background: #f1f5f9; color: #334155; }
        .cart-drop__btn--view:hover { background: #e2e8f0; }
        .cart-drop__btn--checkout { background: var(--red); color: #fff; }
        .cart-drop__btn--checkout:hover { opacity: .9; }

        /* ══════════════════════════════════════════
           OFFLINE INDICATOR
        ══════════════════════════════════════════ */
        #offline-indicator {
            position: fixed; bottom: 80px; left: 50%; transform: translateX(-50%);
            background: #1e293b; color: #fff; border-radius: 12px; padding: 10px 20px;
            display: none; align-items: center; gap: 10px; z-index: 9999999;
            font-size: 13px; font-weight: 600; box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        }
        #offline-indicator.show { display: flex; }

        /* ══════════════════════════════════════════
           MOBILE BOTTOM NAV
        ══════════════════════════════════════════ */
        .mob-nav {
            position: fixed !important; bottom: 0 !important; left: 0 !important; right: 0 !important;
            background: #fff !important; border-top: 1px solid #e5e7eb !important;
            z-index: 9000000 !important; display: none !important;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.1) !important;
        }
        .mob-nav__items {
            display: flex !important; align-items: center !important; justify-content: space-around !important;
            padding: 6px 0 !important;
        }
        .mob-nav__item {
            display: flex !important; flex-direction: column !important; align-items: center !important;
            gap: 2px !important; text-decoration: none !important; color: #64748b !important;
            font-size: 9px !important; font-weight: 600 !important; padding: 4px 10px !important;
            border-radius: 8px !important; transition: color .15s !important; position: relative !important;
        }
        .mob-nav__item i { font-size: 20px !important; display: block !important; }
        .mob-nav__item.active { color: var(--red) !important; }
        .mob-nav__item--track { color: var(--red) !important; }
        .mob-nav__badge {
            position: absolute !important; top: 0 !important; right: 4px !important;
            background: var(--red) !important; color: #fff !important; font-size: 8px !important;
            font-weight: 800 !important; min-width: 14px !important; height: 14px !important;
            border-radius: 7px !important; display: flex !important; align-items: center !important;
            justify-content: center !important; padding: 0 2px !important;
        }
        .mob-nav__badge.zero { display: none !important; }
        @media (max-width: 991px) { .mob-nav { display: block !important; } }

        /* ══════════════════════════════════════════
           FLOATING CONTACT WIDGET
        ══════════════════════════════════════════ */
        .float-contact-wrap {
            position: fixed !important; bottom: 80px !important; right: 16px !important;
            z-index: 8999999 !important; display: flex !important;
            flex-direction: column-reverse !important; align-items: flex-end !important; gap: 8px !important;
        }
        .float-contact-toggle {
            width: 52px !important; height: 52px !important; border-radius: 50% !important;
            background: var(--red) !important; color: #fff !important; border: none !important;
            cursor: pointer !important; display: flex !important; align-items: center !important;
            justify-content: center !important; font-size: 22px !important;
            box-shadow: 0 6px 20px rgba(0,0,0,0.25) !important; transition: all .3s !important;
        }
        .float-contact-toggle:hover { transform: scale(1.08) !important; }
        .float-contact-toggle .icon-close { display: none !important; }
        .float-contact-wrap.open .float-contact-toggle .icon-open { display: none !important; }
        .float-contact-wrap.open .float-contact-toggle .icon-close { display: block !important; }

        .float-contact-items { display: flex !important; flex-direction: column !important; gap: 8px !important; align-items: flex-end !important; }
        .float-contact-item {
            display: flex !important; align-items: center !important; gap: 10px !important;
            text-decoration: none !important; opacity: 0 !important; transform: translateY(10px) !important;
            transition: all .3s ease !important; pointer-events: none !important;
        }
        .float-contact-wrap.open .float-contact-item { opacity: 1 !important; transform: translateY(0) !important; pointer-events: all !important; }
        .float-contact-label {
            background: #fff !important; color: #1e293b !important; font-size: 12px !important;
            font-weight: 700 !important; padding: 5px 12px !important; border-radius: 20px !important;
            box-shadow: 0 3px 12px rgba(0,0,0,0.12) !important; white-space: nowrap !important;
        }
        .float-contact-icon {
            width: 44px !important; height: 44px !important; border-radius: 50% !important;
            display: flex !important; align-items: center !important; justify-content: center !important;
            font-size: 20px !important; color: #fff !important; box-shadow: 0 3px 12px rgba(0,0,0,0.2) !important;
            flex-shrink: 0 !important;
        }
        .float-icon-chat     { background: #0084ff !important; }
        .float-icon-messenger{ background: linear-gradient(135deg,#0078ff,#a855f7) !important; }
        .float-icon-whatsapp { background: #25d366 !important; }
        .float-icon-call     { background: #10b981 !important; }

        @media (min-width: 992px) {
            .float-contact-wrap { bottom: 24px !important; right: 24px !important; }
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

{{-- ── MARQUEE OFFER BAR ── --}}
@if($gs->marquee_status && $gs->marquee_text)
<div class="marquee-wrapper">
    <div class="marquee-content">
        <span>{{ $gs->marquee_text }}</span>
        <span>{{ $gs->marquee_text }}</span>
        <span>{{ $gs->marquee_text }}</span>
        <span>{{ $gs->marquee_text }}</span>
    </div>
</div>
<style>
    .marquee-wrapper {
        background: #be0318;
        color: #fff;
        padding: 8px 0;
        overflow: hidden;
        white-space: nowrap;
        position: relative;
        z-index: 2000003;
        font-weight: 700;
        font-size: 14px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .marquee-content {
        display: inline-block;
        animation: marquee 50s linear infinite;
    }
    .marquee-content span {
        padding-right: 50px;
    }
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .marquee-wrapper:hover .marquee-content {
        animation-play-state: paused;
    }
</style>
@endif

<div class="top-bar">
    <div class="{{ $gs->site_layout_width == 'boxed' ? 'container' : 'container-fluid' }}">
        <div class="top-bar__in">
            <div class="top-bar__promo">
                <span class="top-bar__dot"></span>
                <i class="bi bi-lightning-charge-fill" style="color:var(--gold);font-size:11px"></i>
               {{$deliveryInfo->header_title ?? ''}}
            </div>
            <div class="top-bar__nav">
                {{-- ল্যান্ডিং পেজ বাটন রিমুভ করা হয়েছে --}}
                <a href="{{ route('products.all') }}"><i class="bi bi-grid-3x3-gap"></i> সব পণ্য</a>
                <a href="#"><i class="bi bi-shop"></i>{{ $gs->site_name }}</a>
                <a href="#"><i class="bi bi-geo-alt"></i> Our Stores</a>
            </div>
        </div>
    </div>
</div>

{{-- ── STICKY WRAPPER ── --}}
<div class="sticky-wrapper">
    {{-- ── MAIN HEADER ── --}}
    <header class="site-hdr">
    <div class="{{ $gs->site_layout_width == 'boxed' ? 'container' : 'container-fluid' }}">
        <div class="site-hdr__in">

            {{-- Hamburger --}}
            <button class="hamb" onclick="toggleSidebar()" aria-label="Toggle menu">
                <i class="bi bi-list"></i>
            </button>

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ !empty($gs->header_logo) ? asset($gs->header_logo) : asset('default/logo.png') }}"
                     alt="{{ $siteName }} Logo">
                <div class="logo__dot"></div>
            </a>

            {{-- Search --}}
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

            {{-- Track Order (desktop only) --}}
            <a href="{{ route('order.track') }}" class="track-order-btn" aria-label="Track Order">
                <i class="bi bi-truck"></i>
                <span class="track-lbl">অর্ডার ট্র্যাকিং</span>
            </a>

            {{-- ══ HDR ACTIONS — ALL ICONS ══ --}}
            <div class="hdr-actions">

                {{-- Account --}}
                <div class="hdr-drop-wrap">
                    <div class="h-act" tabindex="0" role="button" aria-label="Account" onclick="toggleDrop(this)">
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
                                <p>Welcome to {{ $gs->site_name }}</p>
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
                <a href="#" class="h-act">
                    <i class="bi bi-headset"></i>
                    <span class="h-act__lbl">Help</span>
                </a>

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
                            <div style="padding:10px 14px;border-top:1px solid #f1f5f9;">
                                <a href="{{ route('products.all') }}"
                                   style="display:flex;align-items:center;justify-content:center;gap:6px;padding:10px;background:var(--red);color:#fff;border-radius:6px;font-size:13px;font-weight:800;text-decoration:none;"
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
            @endif
            <span class="nav-divider"></span>

            <script>
                // Search Bar Typing Effect
                const searchInput = document.getElementById('globalSearch');
                if (searchInput) {
                    const typingWords = [
                        "আপনার প্রয়োজনীয় যেকোনো পণ্য খুঁজুন...",
                        "স্মার্টফোন, গ্যাজেট এবং ইলেকট্রনিক্স খুঁজুন...",
                        "ছেলে ও মেয়েদের লেটেস্ট ফ্যাশন কালেকশন খুঁজুন...",
                        "অরিজিনাল কসমেটিকস ও বিউটি প্রোডাক্ট খুঁজুন..."
                    ];
                    let wordIndex = 0, charIndex = 0, isDeleting = false;
                    const segmenter = new Intl.Segmenter("bn", { granularity: "grapheme" });
                    function typeEffect() {
                        const currentWord = typingWords[wordIndex];
                        const segments = Array.from(segmenter.segment(currentWord)).map(s => s.segment);
                        if (isDeleting) { searchInput.placeholder = segments.slice(0, charIndex - 1).join(''); charIndex--; }
                        else { searchInput.placeholder = segments.slice(0, charIndex + 1).join(''); charIndex++; }
                        let typeSpeed = 80;
                        if (isDeleting) typeSpeed /= 2;
                        if (!isDeleting && charIndex === segments.length) { typeSpeed = 2000; isDeleting = true; }
                        else if (isDeleting && charIndex === 0) { isDeleting = false; wordIndex = (wordIndex + 1) % typingWords.length; typeSpeed = 500; }
                        setTimeout(typeEffect, typeSpeed);
                    }
                    setTimeout(typeEffect, 1000);
                }
            </script>

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

            <a href="{{ route('blog.index') }}" class="nav-item {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> ব্লগ
            </a>

            <span class="nav-divider"></span>
            <a href="{{ route('order.track') }}" class="nav-item nav-item--track">
                <i class="bi bi-truck"></i> অর্ডার ট্র্যাক
            </a>
        </div>
    </div>
    </nav>
</div>

{{-- Sidebar overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

{{-- Mobile Sidebar Drawer --}}
<div id="sidebar-drawer">
    @include('frontend.pages.category')
</div>

<style>
    /* ══ SIDEBAR DRAWER ══ */
    #sidebar-drawer {
        position: fixed;
        top: 0;
        left: -310px;
        width: 300px;
        height: 100vh;
        background: #fff;
        z-index: 2000000000; /* above everything including search bar */
        transition: left 0.3s ease;
        display: flex;
        flex-direction: column;
        box-shadow: 10px 0 30px rgba(0,0,0,0.15);
    }
    #sidebar-drawer.is-open { left: 0; }

    /* Overlay also above search */
    .sidebar-overlay {
        z-index: 1999999999 !important;
    }

    /* Sticky header inside drawer */
    #sidebar-drawer .sb-head {
        flex-shrink: 0;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* The sidebar content area scrolls — NOT the whole drawer */
    #sidebar-drawer .sidebar {
        width: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        flex: 1 !important;
        min-height: 0 !important; /* critical for flex scroll */
        border: none !important;
        box-shadow: none !important;
        margin: 0 !important;
        position: static !important;
        overflow: hidden !important;
        max-height: none !important;
    }

    /* .cat-scroll-body scrolls inside the drawer — sb-head stays sticky */
    #sidebar-drawer .cat-scroll-body {
        flex: 1 !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        scrollbar-width: thin !important;
        scrollbar-color: #ddd transparent !important;
        -webkit-overflow-scrolling: touch !important;
    }
    #sidebar-drawer .cat-scroll-body::-webkit-scrollbar {
        width: 4px;
    }
    #sidebar-drawer .cat-scroll-body::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 4px;
    }

    /* Mobile Sub-menu Toggle Styles */
    @media (max-width: 991px) {
        .sub-menu.is-open, .child-menu.is-open {
            max-height: 2000px !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        .cat-arrow.rotate, .sub-arrow.rotate {
            transform: rotate(180deg) !important;
        }
    }
</style>

<script>
    function toggleSidebar() {
        var drawer = document.getElementById('sidebar-drawer');
        var overlay = document.getElementById('sidebarOverlay');
        if (!drawer || !overlay) return;
        var isOpen = drawer.classList.toggle('is-open');
        overlay.classList.toggle('active', isOpen);
        document.body.classList.toggle('drawer-open', isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : '';
    }

    // Mobile Category Toggles
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Category Toggles – close other open sub-menus first
        document.querySelectorAll('#sidebar-drawer .cat-row').forEach(row => {
            const arrow = row.querySelector('.cat-arrow');
            if (arrow) {
                arrow.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    // Close other sub-menus
                    document.querySelectorAll('#sidebar-drawer .sub-menu.is-open').forEach(sm => sm.classList.remove('is-open'));
                    document.querySelectorAll('#sidebar-drawer .cat-arrow.rotate').forEach(ar => ar.classList.remove('rotate'));
                    const subMenu = row.nextElementSibling;
                    if (subMenu && subMenu.classList.contains('sub-menu')) {
                        subMenu.classList.toggle('is-open');
                        arrow.classList.toggle('rotate');
                    }
                });
            }
        });

        // Handle Sub-category Toggles – close other open child-menus first
        document.querySelectorAll('#sidebar-drawer .sub-row').forEach(row => {
            const arrow = row.querySelector('.sub-arrow');
            if (arrow) {
                arrow.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    // Close other child-menus
                    document.querySelectorAll('#sidebar-drawer .child-menu.is-open').forEach(cm => cm.classList.remove('is-open'));
                    document.querySelectorAll('#sidebar-drawer .sub-arrow.rotate').forEach(ar => ar.classList.remove('rotate'));
                    const childMenu = row.nextElementSibling;
                    if (childMenu && childMenu.classList.contains('child-menu')) {
                        childMenu.classList.toggle('is-open');
                        arrow.classList.toggle('rotate');
                    }
                });
            }
        });
    });

    function toggleOutsideSidebar() {
        toggleSidebar();
    }

    /* Mobile: toggle dropdown on tap */
    function toggleDrop(el) {
        if (window.innerWidth > 991) return; // desktop uses hover via CSS
        var wrap = el.closest('.hdr-drop-wrap');
        if (!wrap) return;
        var drop = wrap.querySelector('.hdr-drop');
        if (!drop) return;
        var isOpen = drop.style.opacity === '1';
        // close all
        document.querySelectorAll('.hdr-drop').forEach(function(d) {
            d.style.opacity = '0';
            d.style.visibility = 'hidden';
            d.style.transform = 'translateY(10px)';
            d.style.pointerEvents = 'none';
        });
        if (!isOpen) {
            drop.style.opacity = '1';
            drop.style.visibility = 'visible';
            drop.style.transform = 'translateY(0)';
            drop.style.pointerEvents = 'all';
        }
    }
    // Close drops on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.hdr-drop-wrap')) {
            document.querySelectorAll('.hdr-drop').forEach(function(d) {
                d.style.opacity = '';
                d.style.visibility = '';
                d.style.transform = '';
                d.style.pointerEvents = '';
            });
        }
    });
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



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>


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
    function openDrop()  { if(dropdown) dropdown.classList.add('active');    if(searchBox) searchBox.classList.add('has-results','focused'); }
    function closeDrop() { if(dropdown) dropdown.classList.remove('active'); if(searchBox) searchBox.classList.remove('has-results'); activeIdx = -1; currentItems = []; }
    function showLoad()  { if(loading) loading.classList.add('active');    if(results) results.innerHTML = ''; openDrop(); }
    function hideLoad()  { if(loading) loading.classList.remove('active'); }

    function renderResults(data, q) {
        hideLoad(); if(!results) return; results.innerHTML = ''; currentItems = []; activeIdx = -1;
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
                el.className = 'sd-cat-item sd-item'; el.href = cat.url;
                el.innerHTML = '<div class="sd-cat-img"><img src="' + cat.image + '" alt="' + cat.name + '" loading="lazy"></div>'
                    + '<span class="sd-cat-name">' + highlight(cat.name, q) + '</span>'
                    + '<i class="bi bi-chevron-right" style="color:#94a3b8;font-size:11px;margin-left:auto"></i>';
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
        va.className = 'sd-view-all'; va.href = searchUrl + '?q=' + encodeURIComponent(q);
        va.innerHTML = 'সব ফলাফল দেখুন "' + q + '" <i class="bi bi-arrow-right"></i>';
        results.appendChild(va);
    }

    function setActive(idx) {
        currentItems.forEach(function (el, i) { el.style.background = i === idx ? '#f8f9fa' : ''; });
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
          .catch(function() { hideLoad(); if(results) results.innerHTML = '<div class="sd-empty"><i class="bi bi-wifi-off"></i> নেটওয়ার্ক সমস্যা হয়েছে।</div>'; });
    }

    if(input) {
        input.addEventListener('input', function () {
            var q = this.value.trim();
            if(clearBtn) clearBtn.classList.toggle('visible', q.length > 0);
            clearTimeout(debounceTimer);
            if (q.length < 2) { closeDrop(); return; }
            debounceTimer = setTimeout(function () { doAjax(q); }, 300);
        });

        input.addEventListener('keydown', function (e) {
            if (!dropdown || !dropdown.classList.contains('active')) return;
            if      (e.key === 'ArrowDown') { e.preventDefault(); setActive(Math.min(activeIdx + 1, currentItems.length - 1)); }
            else if (e.key === 'ArrowUp')   { e.preventDefault(); setActive(Math.max(activeIdx - 1, 0)); }
            else if (e.key === 'Enter')     { if (activeIdx >= 0 && currentItems[activeIdx]) { e.preventDefault(); currentItems[activeIdx].click(); } else { doSearch(); } }
            else if (e.key === 'Escape')    { closeDrop(); input.blur(); }
        });

        input.addEventListener('focus', function () {
            if(searchBox) searchBox.classList.add('focused');
            var q = this.value.trim();
            if (q.length >= 2 && results && results.innerHTML.trim()) openDrop();
        });
    }

    if(clearBtn) {
        clearBtn.addEventListener('click', function () {
            if(input) { input.value = ''; input.focus(); }
            clearBtn.classList.remove('visible'); closeDrop(); lastQuery = '';
        });
    }

    document.addEventListener('click', function (e) {
        var wrap = document.getElementById('searchWrap');
        if (wrap && !wrap.contains(e.target)) {
            closeDrop(); if(searchBox) searchBox.classList.remove('focused');
        }
    });
})();

function doSearch() {
    var qInput = document.getElementById('globalSearch');
    var q = qInput ? qInput.value.trim() : '';
    if (q) window.location.href = '{{ route("search.results") }}' + '?q=' + encodeURIComponent(q);
}

var sInput = document.getElementById('globalSearch');
if(sInput) {
    sInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') doSearch();
    });
}

function updateBadges(cartCount, wishCount) {
    var cb = document.getElementById('cartBadge'), mb = document.getElementById('mobCartBadge'), wb = document.getElementById('wishBadge');
    if (cb) { cb.textContent = cartCount > 0 ? cartCount : ''; cb.classList.toggle('zero', cartCount === 0); }
    if (mb) { mb.textContent = cartCount > 0 ? cartCount : ''; mb.classList.toggle('zero', cartCount === 0); }
    if (wb) { wb.textContent = wishCount  > 0 ? wishCount  : ''; wb.classList.toggle('zero', wishCount  === 0); }
}

/* ── Sticky Menu JS ── */
document.addEventListener('DOMContentLoaded', function() {
    var wrapper = document.querySelector('.sticky-wrapper');
    if (!wrapper) return;

    var header = document.querySelector('.site-hdr');
    var topBar = document.querySelector('.top-bar');
    var stickyThreshold = (topBar ? topBar.offsetHeight : 0) + 10;

    // Create a spacer to prevent layout jump when header becomes fixed
    var spacer = document.createElement('div');
    spacer.style.display = 'none';
    wrapper.parentNode.insertBefore(spacer, wrapper.nextSibling);

    window.addEventListener('scroll', function() {
        if (window.scrollY > stickyThreshold) {
            if (!wrapper.classList.contains('is-sticky')) {
                wrapper.classList.add('is-sticky');
                spacer.style.height = wrapper.offsetHeight + 'px';
                spacer.style.display = 'block';
            }
        } else {
            if (wrapper.classList.contains('is-sticky')) {
                wrapper.classList.remove('is-sticky');
                spacer.style.display = 'none';
            }
        }
    });
});
</script>
