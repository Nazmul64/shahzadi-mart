<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $campaign->title }} | {{ $websetting->site_name ?? 'Landing Page' }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

:root {
    --pk:      #e91e8c;
    --pk-d:    #b5116a;
    --pk-l:    #ff6bbe;
    --pk-glow: rgba(233,30,140,.28);
    --teal:    #00c6b2;
    --gold:    #f5a623;
    --dark:    #0d0d1a;
    --dark2:   #15152a;
    --dark3:   #1e1e36;
    --card:    #1a1a30;
    --border:  rgba(255,255,255,.10);
    --text:    #ffffff;
    --muted:   rgba(255,255,255,.65);
    --radius:  14px;
    --radius-l:22px;
    --shadow:  0 20px 60px rgba(0,0,0,.45);
}

html { scroll-behavior: smooth; }

body {
    font-family: 'Hind Siliguri', sans-serif;
    background: var(--dark);
    color: var(--text);
    font-size: 15px;
    line-height: 1.7;
    overflow-x: hidden;
}

body::before {
    content: '';
    position: fixed;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 50% at 10% 10%, rgba(233,30,140,.12) 0%, transparent 60%),
        radial-gradient(ellipse 60% 40% at 90% 80%, rgba(0,198,178,.09) 0%, transparent 55%),
        radial-gradient(ellipse 50% 60% at 50% 50%, rgba(13,13,26,1) 0%, transparent 100%);
    pointer-events: none;
    z-index: 0;
}

/* ══ Topbar ══ */
.topbar {
    position: sticky;
    top: 0;
    z-index: 900;
    background: linear-gradient(90deg, var(--pk-d), var(--pk), var(--pk-l), var(--pk));
    background-size: 300% 100%;
    animation: gradShift 6s ease infinite;
    color: #ffffff;
    text-align: center;
    padding: 10px 16px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .4px;
    box-shadow: 0 2px 20px var(--pk-glow);
}
@keyframes gradShift { 0%,100%{background-position:0% 50%} 50%{background-position:100% 50%} }

/* ══ Wrap ══ */
.lp-wrap {
    max-width: 940px;
    margin: 0 auto;
    padding: 0 16px 80px;
    position: relative;
    z-index: 1;
}

/* ══ Section title ══ */
.sec-title {
    text-align: center;
    font-family: 'Sora', sans-serif;
    font-size: clamp(20px, 4vw, 28px);
    font-weight: 800;
    color: #ffffff;
    padding: 32px 0 6px;
    line-height: 1.35;
    letter-spacing: -.5px;
}

/* ══ Hero media ══ */
.hero-media {
    width: 100%;
    margin: 22px 0;
    border-radius: var(--radius-l);
    overflow: hidden;
    box-shadow: 0 8px 48px rgba(233,30,140,.22), 0 2px 0 rgba(255,255,255,.06) inset;
    border: 1px solid var(--border);
    position: relative;
}
.hero-media::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: var(--radius-l);
    box-shadow: inset 0 0 0 1px rgba(255,255,255,.07);
    pointer-events: none;
}
.hero-media img   { width: 100%; display: block; }
.hero-media video { width: 100%; display: block; background: #000; }
.hero-media iframe { width: 100%; height: 420px; display: block; border: none; }
.video-url-embed  { width: 100%; aspect-ratio: 16/9; }

/* ══ Extra images ══ */
.extra-images { display: flex; gap: 12px; margin-bottom: 20px; }
.extra-images img {
    flex: 1; width: 0;
    border-radius: var(--radius);
    object-fit: cover;
    max-height: 200px;
    border: 1px solid var(--border);
    transition: transform .3s, box-shadow .3s;
}
.extra-images img:hover { transform: scale(1.02); box-shadow: 0 8px 32px rgba(233,30,140,.2); }

/* ══ CTA Button ══ */
.cta-wrap { text-align: center; margin: 24px 0; }
.btn-cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, var(--pk), var(--pk-d));
    color: #ffffff;
    font-family: 'Hind Siliguri', sans-serif;
    font-size: 19px;
    font-weight: 700;
    padding: 16px 44px;
    border-radius: 60px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    box-shadow: 0 6px 28px var(--pk-glow), 0 1px 0 rgba(255,255,255,.15) inset;
    transition: all .25s;
    animation: pulse 2.2s ease infinite;
    letter-spacing: .2px;
    position: relative;
    overflow: hidden;
}
.btn-cta::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.18) 0%, transparent 60%);
    border-radius: inherit;
}
.btn-cta:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 10px 40px rgba(233,30,140,.5); color: #ffffff; text-decoration: none; }
@keyframes pulse {
    0%,100% { box-shadow: 0 6px 28px var(--pk-glow); }
    50%      { box-shadow: 0 6px 44px rgba(233,30,140,.55); }
}

/* ══ Description cards ══ */
.short-desc, .full-desc {
    background: var(--card);
    border-radius: var(--radius);
    padding: 22px 24px;
    margin-bottom: 16px;
    border: 1px solid var(--border);
    font-size: 15px;
    color: #ffffff;
    line-height: 1.85;
}
.full-desc { margin-bottom: 24px; }
.full-desc img, .short-desc img { max-width: 100%; border-radius: 8px; margin: 8px 0; }
.short-desc *, .full-desc * { color: #ffffff !important; }

/* ══ Divider ══ */
.lp-divider {
    border: none;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--border), rgba(233,30,140,.3), var(--border), transparent);
    margin: 32px 0;
}

/* ══ Review section ══ */
.review-section {
    background: var(--dark2);
    padding: 40px 0;
    margin: 0 -16px;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    position: relative;
    z-index: 1;
}
.review-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 70% 100% at 50% 50%, rgba(233,30,140,.06) 0%, transparent 70%);
    pointer-events: none;
}
.review-inner { max-width: 940px; margin: 0 auto; padding: 0 16px; }
.review-title {
    text-align: center;
    font-family: 'Sora', sans-serif;
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #ffffff;
    letter-spacing: -.3px;
}
.review-img {
    width: 100%;
    border-radius: var(--radius);
    display: block;
    margin: 0 auto;
    max-width: 700px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
}
.review-text-box {
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
    margin-top: 16px;
    padding: 14px 20px;
    background: var(--card);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* ══ Discount banner ══ */
.discount-banner {
    background: linear-gradient(90deg, var(--teal), #009688, var(--teal));
    background-size: 200% 100%;
    animation: gradShift 4s ease infinite;
    color: #ffffff;
    text-align: center;
    padding: 18px 16px;
    font-family: 'Sora', sans-serif;
    font-size: clamp(16px, 3vw, 22px);
    font-weight: 700;
    margin: 0 -16px;
    letter-spacing: .4px;
    position: relative;
    z-index: 1;
}

/* ══ Price display ══ */
.price-display { text-align: center; padding: 24px 0 12px; }
.price-original { font-size: 18px; color: rgba(255,255,255,.5); text-decoration: line-through; margin-right: 10px; font-weight: 400; }
.price-final { font-family: 'Sora', sans-serif; font-size: 38px; font-weight: 800; color: var(--pk); letter-spacing: -1px; }
.price-label { font-size: 16px; font-weight: 400; color: rgba(255,255,255,.7); margin-left: 4px; }

/* ══ Order section ══ */
.order-section { margin-top: 24px; }
.section-heading {
    font-family: 'Sora', sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 18px;
    text-align: center;
    letter-spacing: -.3px;
}
.order-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    align-items: start;
}

/* ══ Order card ══ */
.order-card {
    background: var(--card);
    border-radius: var(--radius-l);
    border: 1px solid var(--border);
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,.3);
    transition: box-shadow .3s;
}
.order-card:hover { box-shadow: 0 14px 50px rgba(233,30,140,.12); }

.order-card-head {
    background: linear-gradient(135deg, rgba(233,30,140,.18), rgba(0,198,178,.10));
    border-bottom: 1px solid var(--border);
    padding: 14px 20px;
    font-size: 14px;
    font-weight: 700;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 8px;
    letter-spacing: .2px;
}
.order-card-head i { color: var(--pk); font-size: 15px; }

.order-card-body { padding: 20px; }

/* ══ Fields ══ */
.field-group { margin-bottom: 16px; }
.field-group label {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 7px;
    text-transform: uppercase;
    letter-spacing: .6px;
}
.field-group label span { color: #ff6b6b; }

.field-group input,
.field-group select {
    width: 100%;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 10px;
    padding: 11px 14px;
    font-family: 'Hind Siliguri', sans-serif;
    font-size: 14.5px;
    color: #ffffff;
    outline: none;
    transition: all .2s;
    appearance: none;
    -webkit-appearance: none;
}
.field-group input::placeholder { color: rgba(255,255,255,.3); }
.field-group input:focus,
.field-group select:focus {
    border-color: var(--pk);
    background: rgba(233,30,140,.08);
    box-shadow: 0 0 0 3px rgba(233,30,140,.15);
}
.field-group select option { background: var(--dark3); color: #ffffff; }

.select-wrap { position: relative; }
.select-wrap::after {
    content: '\f107';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    right: 14px; top: 50%;
    transform: translateY(-50%);
    color: rgba(255,255,255,.5);
    pointer-events: none;
    font-size: 13px;
}

.field-note { color: rgba(255,255,255,.35); font-size: 11.5px; margin-top: 5px; display: block; }

/* ══ COD badge ══ */
.cod-badge {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(0,198,178,.12);
    border: 1px solid rgba(0,198,178,.28);
    border-radius: 10px;
    padding: 11px 14px;
    margin-bottom: 18px;
    font-size: 13px;
    color: #7ff5ea;
    font-weight: 600;
}
.cod-badge i { font-size: 20px; color: var(--teal); flex-shrink: 0; }

/* ══ Submit button ══ */
.btn-order-submit {
    width: 100%;
    background: linear-gradient(135deg, var(--pk), var(--pk-d));
    color: #ffffff;
    font-family: 'Hind Siliguri', sans-serif;
    font-size: 17px;
    font-weight: 700;
    padding: 14px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    margin-top: 6px;
    transition: all .2s;
    box-shadow: 0 4px 20px var(--pk-glow);
    letter-spacing: .2px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.btn-order-submit::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.12) 0%, transparent 60%);
}
.btn-order-submit:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(233,30,140,.5); }
.btn-order-submit:disabled { background: rgba(255,255,255,.12); cursor: not-allowed; box-shadow: none; color: rgba(255,255,255,.35); }

/* ══ Product table ══ */
.product-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.product-table th {
    background: rgba(255,255,255,.04);
    border-bottom: 1px solid var(--border);
    padding: 10px;
    font-weight: 700;
    font-size: 11px;
    color: rgba(255,255,255,.55);
    text-align: center;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.product-table td {
    border-bottom: 1px solid var(--border);
    padding: 12px 10px;
    vertical-align: middle;
    text-align: center;
    color: #ffffff;
}
.product-table tbody tr:last-child td { border-bottom: none; }

/* ══ Product cell ══ */
.prod-img-cell { display: flex; align-items: center; gap: 9px; text-align: left; }
.prod-img-cell img { width: 42px; height: 42px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border); flex-shrink: 0; }
.prod-name { font-size: 13px; font-weight: 600; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 110px; }

/* ══ Qty control ══ */
.qty-control {
    display: inline-flex;
    align-items: center;
    background: rgba(255,255,255,.06);
    border: 1px solid var(--border);
    border-radius: 8px;
    overflow: hidden;
}
.qty-btn {
    width: 30px; height: 30px;
    background: transparent;
    border: none;
    font-size: 17px;
    font-weight: 700;
    cursor: pointer;
    color: var(--pk);
    transition: background .15s;
    display: flex;
    align-items: center;
    justify-content: center;
    user-select: none;
}
.qty-btn:hover { background: rgba(233,30,140,.15); }
.qty-num {
    min-width: 34px;
    text-align: center;
    font-size: 14px;
    font-weight: 700;
    color: #ffffff;
    border-left: 1px solid var(--border);
    border-right: 1px solid var(--border);
    padding: 0 4px;
    line-height: 30px;
    user-select: none;
}

/* ══ Row price ══ */
.row-price { font-weight: 700; color: var(--pk); font-family: 'Sora', sans-serif; }

/* ══ Price summary ══ */
.price-summary { padding: 14px 20px 16px; border-top: 1px solid var(--border); }
.price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 7px 0;
    font-size: 14px;
    color: rgba(255,255,255,.65);
}
.price-row .label { font-weight: 500; color: rgba(255,255,255,.65); }
.price-row .val   { font-weight: 600; color: #ffffff; }
.price-row.total  {
    font-weight: 800;
    font-size: 17px;
    color: #ffffff;
    border-top: 1px solid var(--border);
    margin-top: 6px;
    padding-top: 12px;
}
.price-row.total .val { color: var(--pk); font-family: 'Sora', sans-serif; font-size: 19px; }

/* ══ Delete button ══ */
.del-btn {
    background: rgba(220,38,38,.14);
    border: 1px solid rgba(220,38,38,.25);
    border-radius: 6px;
    color: #f87171;
    font-size: 12px;
    cursor: pointer;
    padding: 5px 7px;
    line-height: 1;
    transition: all .15s;
}
.del-btn:hover { background: rgba(220,38,38,.28); }

/* ══ Trust badges ══ */
.trust-badges {
    display: flex;
    justify-content: center;
    gap: 14px;
    flex-wrap: wrap;
    margin: 28px 0 8px;
}
.trust-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 30px;
    padding: 7px 14px;
    font-size: 12.5px;
    color: #ffffff;
    font-weight: 600;
}
.trust-badge i { color: var(--teal); font-size: 14px; }

/* ══ Success modal ══ */
.success-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.75);
    z-index: 9900;
    align-items: center;
    justify-content: center;
    padding: 20px;
    backdrop-filter: blur(6px);
}
.success-modal.show { display: flex; }
.success-modal-box {
    background: var(--dark2);
    border: 1px solid rgba(22,163,74,.3);
    border-radius: 22px;
    padding: 40px 30px;
    max-width: 430px;
    width: 100%;
    text-align: center;
    box-shadow: 0 30px 80px rgba(0,0,0,.5), 0 0 60px rgba(22,163,74,.1);
    animation: popIn .35s cubic-bezier(.34, 1.56, .64, 1);
}
@keyframes popIn { from{transform:scale(.8);opacity:0} to{transform:scale(1);opacity:1} }
.success-icon { font-size: 60px; color: #4ade80; margin-bottom: 16px; animation: bounceIn .6s .3s both; }
@keyframes bounceIn { 0%{transform:scale(0);opacity:0} 60%{transform:scale(1.2)} 100%{transform:scale(1);opacity:1} }
.success-title { font-family: 'Sora', sans-serif; font-size: 24px; font-weight: 800; color: #ffffff; margin-bottom: 10px; }
.success-sub   { font-size: 15px; color: rgba(255,255,255,.7); margin-bottom: 8px; line-height: 1.75; }
.success-order-no { font-size: 14px; color: rgba(255,255,255,.5); margin-bottom: 24px; }
.success-order-no strong { color: var(--pk); font-size: 17px; font-family: 'Sora', sans-serif; }
.btn-success-ok {
    display: inline-block;
    background: linear-gradient(135deg, #16a34a, #15803d);
    color: #ffffff;
    font-family: 'Hind Siliguri', sans-serif;
    font-size: 17px;
    font-weight: 700;
    padding: 13px 40px;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    box-shadow: 0 6px 24px rgba(22,163,74,.35);
    transition: all .2s;
}
.btn-success-ok:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(22,163,74,.5); }

/* ══ Toast ══ */
.toast-wrap { position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
.toast {
    background: #16a34a;
    color: #ffffff;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 6px 24px rgba(0,0,0,.3);
    animation: slideIn .3s cubic-bezier(.34,1.56,.64,1);
    max-width: 300px;
}
.toast.error { background: #dc2626; }
@keyframes slideIn { from{transform:translateX(120%);opacity:0} to{transform:translateX(0);opacity:1} }

/* ══ Loading ══ */
.loading-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(13,13,26,.88);
    z-index: 8888;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(4px);
}
.loading-overlay.show { display: flex; }
.spinner {
    width: 48px; height: 48px;
    border: 3px solid rgba(255,255,255,.1);
    border-top-color: var(--pk);
    border-radius: 50%;
    animation: spin .7s linear infinite;
}
@keyframes spin { to{transform:rotate(360deg)} }

/* ══ Responsive ══ */
@media (max-width: 640px) {
    .order-grid { grid-template-columns: 1fr; }
    .extra-images { flex-direction: column; }
    .extra-images img { width: 100%; max-height: 180px; }
    .hero-media iframe { height: 240px; }
    .trust-badges { gap: 8px; }
    .trust-badge { font-size: 11.5px; padding: 6px 11px; }
}
</style>
</head>

<body>

{{-- ── Topbar ── --}}
<div class="topbar">
    🚚 সারাদেশে হোম ডেলিভারি চলছে &nbsp;|&nbsp; আজই অর্ডার করুন &nbsp;|&nbsp; ক্যাশ অন ডেলিভারি
</div>

@php
    $product      = $campaign->product;
    $currentPrice = (float) ($product->current_price ?? 0);
    $discPrice    = $product->discount_price ? (float) $product->discount_price : null;
    $flashActive  = isset($product->is_flash_sale_active) ? (bool) $product->is_flash_sale_active : false;
    $flashPrice   = ($flashActive && $product->flash_sale_price) ? (float) $product->flash_sale_price : null;

    if ($flashPrice && $flashPrice < $currentPrice) {
        $sellPrice = $flashPrice;
        $regPrice  = $currentPrice;
    } elseif ($discPrice && $discPrice < $currentPrice) {
        $sellPrice = $discPrice;
        $regPrice  = $currentPrice;
    } else {
        $sellPrice = $currentPrice;
        $regPrice  = 0;
    }

    $discount = ($regPrice > $sellPrice && $regPrice > 0)
                ? round((($regPrice - $sellPrice) / $regPrice) * 100)
                : 0;

    $productImage = $product->feature_image
                    ? asset('uploads/products/' . $product->feature_image)
                    : null;
@endphp

<div class="lp-wrap">

    {{-- ── Campaign Title ── --}}
    <h1 class="sec-title">{{ $campaign->title }}</h1>

    {{-- ── Hero Media ── --}}
    <div class="hero-media">
        @if($campaign->media_type === 'Video')
            @if($campaign->video)
                <video controls autoplay muted loop playsinline>
                    <source src="{{ asset($campaign->video) }}" type="video/mp4">
                </video>
            @elseif($campaign->video_url)
                @php
                    $vurl = $campaign->video_url;
                    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/', $vurl, $m)) {
                        $embedUrl = 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=0&rel=0';
                    } elseif (preg_match('/vimeo\.com\/(\d+)/', $vurl, $m)) {
                        $embedUrl = 'https://player.vimeo.com/video/' . $m[1];
                    } else {
                        $embedUrl = $vurl;
                    }
                @endphp
                <iframe src="{{ $embedUrl }}"
                    allowfullscreen
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    class="video-url-embed"></iframe>
            @endif
        @else
            @if($campaign->image)
                <img src="{{ asset($campaign->image) }}" alt="{{ $campaign->title }}">
            @endif
        @endif
    </div>

    {{-- ── Extra Images ── --}}
    @if($campaign->media_type === 'Image' && ($campaign->image_two || $campaign->image_three))
    <div class="extra-images">
        @if($campaign->image_two)
            <img src="{{ asset($campaign->image_two) }}" alt="product image 2">
        @endif
        @if($campaign->image_three)
            <img src="{{ asset($campaign->image_three) }}" alt="product image 3">
        @endif
    </div>
    @endif

    {{-- ── CTA Top ── --}}
    <div class="cta-wrap">
        <a href="#order-section" class="btn-cta">
            <i class="fas fa-shopping-cart"></i> অর্ডার করতে ক্লিক করুন
        </a>
    </div>

    {{-- ── Trust Badges ── --}}
    <div class="trust-badges">
        <div class="trust-badge"><i class="fas fa-shield-alt"></i> ১০০% অরিজিনাল</div>
        <div class="trust-badge"><i class="fas fa-truck"></i> দ্রুত ডেলিভারি</div>
        <div class="trust-badge"><i class="fas fa-undo"></i> রিটার্ন গ্যারান্টি</div>
        <div class="trust-badge"><i class="fas fa-headset"></i> ২৪/৭ সাপোর্ট</div>
    </div>

    {{-- ── Short Description ── --}}
    @if($campaign->short_description)
    <div class="short-desc">
        {!! $campaign->short_description !!}
    </div>
    @endif

    {{-- ── Full Description ── --}}
    @if($campaign->description)
    <div class="full-desc">
        {!! $campaign->description !!}
    </div>
    @endif

    {{-- ── CTA Middle ── --}}
    <div class="cta-wrap">
        <a href="#order-section" class="btn-cta">
            <i class="fas fa-shopping-cart"></i> অর্ডার করতে ক্লিক করুন
        </a>
    </div>

    <hr class="lp-divider">

</div>

{{-- ── Review Section ── --}}
<div class="review-section">
    <div class="review-inner">
        <div class="review-title">⭐ কাস্টমারদের রিভিউ</div>
        @if($campaign->review_image)
            <img src="{{ asset($campaign->review_image) }}" alt="Review" class="review-img">
        @endif
        @if($campaign->review)
            <div class="review-text-box">⭐ {{ $campaign->review }}</div>
        @endif
    </div>
</div>

{{-- ── Discount Banner ── --}}
<div class="discount-banner">
    @if($discount > 0)
        🔥 &nbsp;{{ $discount }}% ডিসকাউন্টে এখনই অর্ডার করুন&nbsp; 🔥
    @else
        🛒 &nbsp;এখনই অর্ডার করুন — স্টক সীমিত!
    @endif
</div>

<div class="lp-wrap">

    {{-- ── Price Display ── --}}
    <div class="price-display">
        @if($regPrice > $sellPrice && $regPrice > 0)
            <span class="price-original">{{ number_format($regPrice) }} টাকা</span>
        @endif
        <span class="price-final">{{ number_format($sellPrice) }}</span>
        <span class="price-label">টাকা</span>
    </div>

    {{-- ══ ORDER SECTION ══ --}}
    <div class="order-section" id="order-section">
        <div class="section-heading">📦 এখনই অর্ডার করুন</div>
        <div class="order-grid">

            {{-- ── Left: Customer Form ── --}}
            <div class="order-card">
                <div class="order-card-head">
                    <i class="fas fa-user-circle"></i> আপনার তথ্য দিন
                </div>
                <div class="order-card-body">

                    <div class="cod-badge">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>ক্যাশ অন ডেলিভারি — পণ্য পেয়ে পেমেন্ট করুন</span>
                    </div>

                    <div class="field-group">
                        <label>আপনার নাম <span>*</span></label>
                        <input type="text" id="cust_name" placeholder="আপনার পুরো নাম">
                    </div>
                    <div class="field-group">
                        <label>মোবাইল নম্বর <span>*</span></label>
                        <input type="tel" id="cust_phone" placeholder="01XXXXXXXXX" maxlength="11">
                    </div>
                    <div class="field-group">
                        <label>সম্পূর্ণ ঠিকানা <span>*</span></label>
                        <input type="text" id="cust_address" placeholder="জেলা, থানা, গ্রাম, বাড়ি নং">
                    </div>
                    <div class="field-group">
                        <label>ডেলিভারি এরিয়া <span>*</span></label>
                        <div class="select-wrap">
                            <select id="cust_area" onchange="updateDelivery()">
                                <option value="">-- এরিয়া সিলেক্ট করুন --</option>
                            </select>
                        </div>
                        <small class="field-note" id="shipping-note">ডেলিভারি এলাকা লোড হচ্ছে...</small>
                    </div>

                    <button class="btn-order-submit" id="order-btn" onclick="submitOrder()" disabled>
                        <i class="fas fa-check-circle"></i> অর্ডার কনফার্ম করুন
                    </button>

                </div>
            </div>

            {{-- ── Right: Product Summary ── --}}
            <div>
                <div class="order-card">
                    <div class="order-card-head">
                        <i class="fas fa-box-open"></i> পণ্যের বিবরণ
                    </div>
                    <div class="order-card-body" style="padding:0">

                        <table class="product-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>প্রোডাক্ট</th>
                                    <th>পরিমাণ</th>
                                    <th>মূল্য</th>
                                </tr>
                            </thead>
                            <tbody id="cart-body">
                                <tr id="prod-row-{{ $product->id }}">
                                    <td>
                                        <button class="del-btn" onclick="removeProduct({{ $product->id }})" title="সরিয়ে দিন">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <div class="prod-img-cell">
                                            @if($productImage)
                                                <img src="{{ $productImage }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="https://placehold.co/42x42/1e1e36/e91e8c?text=P" alt="product">
                                            @endif
                                            <span class="prod-name" title="{{ $product->name }}">{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="qty-control">
                                            <button class="qty-btn" onclick="changeQty({{ $product->id }}, -1)">−</button>
                                            <span class="qty-num" id="qty-{{ $product->id }}">1</span>
                                            <button class="qty-btn" onclick="changeQty({{ $product->id }}, 1)">+</button>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="row-price" id="row-price-{{ $product->id }}">৳{{ number_format($sellPrice, 0) }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="price-summary">
                            <div class="price-row">
                                <span class="label">পণ্যের মূল্য</span>
                                <span class="val" id="subtotal">৳{{ number_format($sellPrice, 0) }}</span>
                            </div>
                            <div class="price-row">
                                <span class="label">ডেলিভারি চার্জ</span>
                                <span class="val" id="delivery-charge">এরিয়া সিলেক্ট করুন</span>
                            </div>
                            <div class="price-row total">
                                <span>সর্বমোট</span>
                                <span class="val" id="grand-total">—</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ── CTA Bottom ── --}}
    <div class="cta-wrap" style="margin-top:36px">
        <a href="#order-section" class="btn-cta">
            <i class="fas fa-shopping-cart"></i> এখনই অর্ডার করুন
        </a>
    </div>

</div>

{{-- ══ SUCCESS MODAL ══ --}}
<div class="success-modal" id="success-modal">
    <div class="success-modal-box">
        <div class="success-icon"><i class="fas fa-check-circle"></i></div>
        <div class="success-title">অর্ডার সম্পন্ন হয়েছে! 🎉</div>
        <p class="success-sub">আপনার অর্ডার সফলভাবে গ্রহণ করা হয়েছে।<br>আমাদের টিম শীঘ্রই আপনার সাথে যোগাযোগ করবে।</p>
        <p class="success-order-no">অর্ডার নম্বর: <strong id="modal-order-no">—</strong></p>
        <button class="btn-success-ok" onclick="closeSuccessModal()">
            <i class="fas fa-check"></i>&nbsp; ঠিক আছে
        </button>
    </div>
</div>

{{-- Toast --}}
<div class="toast-wrap" id="toast-wrap"></div>

{{-- Loading --}}
<div class="loading-overlay" id="loading"><div class="spinner"></div></div>

<script>
var products = {};
products[{{ $product->id }}] = {
    name:   '{{ addslashes($product->name) }}',
    price:  {{ $sellPrice }},
    qty:    1,
    active: true
};

var CAMPAIGN_ID = {{ $campaign->id }};
var ORDER_URL   = '{{ route("order.store") }}';
var CSRF        = document.querySelector('meta[name="csrf-token"]').content;

var deliveryEl   = document.getElementById('delivery-charge');
var subtotalEl   = document.getElementById('subtotal');
var grandTotalEl = document.getElementById('grand-total');
var orderBtn     = document.getElementById('order-btn');
var areaSelect   = document.getElementById('cust_area');
var shippingNote = document.getElementById('shipping-note');
var deliveryCharge = 0;

function loadShippingAreas() {
    fetch('{{ route("shipping.areas") }}')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            areaSelect.innerHTML = '<option value="">-- এরিয়া সিলেক্ট করুন --</option>';
            if (!data || data.length === 0) {
                areaSelect.innerHTML += '<option value="120">সারা বাংলাদেশ — ১২০ টাকা</option>';
                areaSelect.innerHTML += '<option value="60">ঢাকার ভেতরে — ৬০ টাকা</option>';
            } else {
                data.forEach(function(area) {
                    var opt = document.createElement('option');
                    opt.value = area.amount;
                    opt.textContent = area.area_name + ' — ' + area.amount + ' টাকা';
                    areaSelect.appendChild(opt);
                });
            }
            shippingNote.style.display = 'none';
            orderBtn.disabled = false;
        })
        .catch(function() {
            areaSelect.innerHTML  = '<option value="">-- এরিয়া সিলেক্ট করুন --</option>';
            areaSelect.innerHTML += '<option value="120">সারা বাংলাদেশ — ১২০ টাকা</option>';
            areaSelect.innerHTML += '<option value="60">ঢাকার ভেতরে — ৬০ টাকা</option>';
            shippingNote.textContent = 'ডিফল্ট চার্জ ব্যবহার হচ্ছে।';
            orderBtn.disabled = false;
        });
}

function updateDelivery() {
    var val = areaSelect.value;
    if (!val) {
        deliveryEl.textContent   = 'এরিয়া সিলেক্ট করুন';
        grandTotalEl.textContent = '—';
        orderBtn.disabled        = true;
        deliveryCharge           = 0;
        return;
    }
    deliveryCharge    = parseInt(val) || 0;
    orderBtn.disabled = false;
    recalculate();
}

function changeQty(id, delta) {
    if (!products[id] || !products[id].active) return;
    products[id].qty = Math.max(1, products[id].qty + delta);
    document.getElementById('qty-' + id).textContent       = products[id].qty;
    document.getElementById('row-price-' + id).textContent = '৳' + fmt(products[id].price * products[id].qty);
    recalculate();
}

function removeProduct(id) {
    if (!products[id]) return;
    var row = document.getElementById('prod-row-' + id);
    if (row) row.remove();
    products[id].active = false;
    recalculate();
}

function recalculate() {
    var sub = 0;
    Object.values(products).forEach(function(p) {
        if (p.active) sub += p.price * p.qty;
    });
    subtotalEl.textContent   = '৳' + fmt(sub);
    deliveryEl.textContent   = areaSelect.value ? '৳' + deliveryCharge : 'এরিয়া সিলেক্ট করুন';
    grandTotalEl.textContent = areaSelect.value ? '৳' + fmt(sub + deliveryCharge) : '—';
}

function fmt(n) { return Number(n).toLocaleString('en-IN'); }

function showToast(msg, type) {
    var wrap = document.getElementById('toast-wrap');
    var el   = document.createElement('div');
    el.className   = 'toast' + (type === 'error' ? ' error' : '');
    el.textContent = msg;
    wrap.appendChild(el);
    setTimeout(function() { el.remove(); }, 3800);
}

function setLoading(v) {
    document.getElementById('loading').classList.toggle('show', v);
}

function openSuccessModal(orderNo, redirectUrl) {
    document.getElementById('modal-order-no').textContent = orderNo;
    document.getElementById('success-modal').classList.add('show');
    if (redirectUrl) {
        setTimeout(function() { window.location.href = redirectUrl; }, 4000);
    }
}
function closeSuccessModal() {
    document.getElementById('success-modal').classList.remove('show');
}

function submitOrder() {
    var name     = document.getElementById('cust_name').value.trim();
    var phone    = document.getElementById('cust_phone').value.trim();
    var address  = document.getElementById('cust_address').value.trim();
    var areaVal  = areaSelect.value;
    var areaText = (areaSelect.selectedIndex >= 0 && areaSelect.options[areaSelect.selectedIndex])
                   ? areaSelect.options[areaSelect.selectedIndex].text : '';

    if (!name)                       { showToast('নাম লিখুন', 'error'); return; }
    if (!phone || phone.length < 11) { showToast('সঠিক মোবাইল নম্বর দিন (১১ সংখ্যা)', 'error'); return; }
    if (!address)                    { showToast('ঠিকানা লিখুন', 'error'); return; }
    if (!areaVal)                    { showToast('ডেলিভারি এরিয়া সিলেক্ট করুন', 'error'); return; }

    var activeItems = [];
    Object.keys(products).forEach(function(id) {
        var p = products[id];
        if (p.active) activeItems.push({ product_id: parseInt(id), qty: p.qty, price: p.price });
    });

    if (activeItems.length === 0) { showToast('কোনো পণ্য নেই!', 'error'); return; }

    var sub        = activeItems.reduce(function(s, i) { return s + i.price * i.qty; }, 0);
    var shipCharge = parseInt(areaVal) || 0;

    setLoading(true);
    orderBtn.disabled = true;

    fetch(ORDER_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: JSON.stringify({
            customer_name:    name,
            customer_phone:   phone,
            customer_address: address,
            shipping_area:    areaText,
            delivery_charge:  shipCharge,
            subtotal:         sub,
            grand_total:      sub + shipCharge,
            items:            activeItems,
            campaign_id:      CAMPAIGN_ID,
        }),
    })
    .then(function(r) { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
    .then(function(data) {
        setLoading(false);
        orderBtn.disabled = false;
        if (data.success) {
            document.getElementById('cust_name').value    = '';
            document.getElementById('cust_phone').value   = '';
            document.getElementById('cust_address').value = '';
            areaSelect.selectedIndex = 0;
            updateDelivery();
            openSuccessModal(data.order_number || data.order_id || '', data.redirect);
        } else {
            showToast(data.message || 'কিছু একটা সমস্যা হয়েছে।', 'error');
        }
    })
    .catch(function(err) {
        setLoading(false);
        orderBtn.disabled = false;
        showToast('সার্ভার এরর! আবার চেষ্টা করুন।', 'error');
    });
}

document.querySelectorAll('a[href="#order-section"]').forEach(function(a) {
    a.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('order-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});

loadShippingAreas();
</script>

</body>
</html>
