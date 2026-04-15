{{-- resources/views/frontend/index.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700;800&display=swap');

.shahzadimartshophome-ci,
.shahzadimartshophome-ci * {
    font-family: 'DM Sans', sans-serif;
    box-sizing: border-box;
}
.shahzadimartshophome-ci h1,
.shahzadimartshophome-ci h2 {
    font-family: 'Playfair Display', serif;
}

/* ══ HERO ══ */
.shahzadimartshophome-hero {
    display: grid;
    grid-template-columns: 1fr 220px;
    gap: 16px;
    margin-bottom: 24px;
}

/* ── CSS-only Slider ── */
.shahzadimartshophome-hero-slider {
    position: relative;
    border-radius: var(--rl);
    overflow: hidden;
    height: 300px;
    box-shadow: var(--sh2);
    border: 1px solid var(--border);
    background: #111;
}
.shahzadimartshophome-slides-wrap {
    display: flex;
    height: 100%;
    animation: shahzadimartshophome-css-slide 16s infinite;
    will-change: transform;
}
@keyframes shahzadimartshophome-css-slide {
    0%,20%  { transform: translateX(0%); }
    25%,45% { transform: translateX(-100%); }
    50%,70% { transform: translateX(-200%); }
    75%,95% { transform: translateX(-300%); }
    100%    { transform: translateX(0%); }
}
.shahzadimartshophome-slide {
    min-width: 100%;
    height: 300px;
    flex-shrink: 0;
    overflow: hidden;
}
.shahzadimartshophome-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Dots */
.shahzadimartshophome-sl-dots {
    position: absolute;
    bottom: 14px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 6px;
    z-index: 10;
    pointer-events: none;
}
.shahzadimartshophome-sl-dot {
    width: 8px;
    height: 8px;
    border-radius: 4px;
    background: rgba(255,255,255,.4);
}
.shahzadimartshophome-sl-dot:nth-child(1) { animation: shahzadimartshophome-dot-a 16s infinite 0s; }
.shahzadimartshophome-sl-dot:nth-child(2) { animation: shahzadimartshophome-dot-a 16s infinite -12s; }
.shahzadimartshophome-sl-dot:nth-child(3) { animation: shahzadimartshophome-dot-a 16s infinite -8s; }
.shahzadimartshophome-sl-dot:nth-child(4) { animation: shahzadimartshophome-dot-a 16s infinite -4s; }
@keyframes shahzadimartshophome-dot-a {
    0%,20%   { background: #fff; width: 24px; }
    25%,100% { background: rgba(255,255,255,.4); width: 8px; }
}

/* ── Hero Right Panel ── */
.shahzadimartshophome-hero-panel {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.shahzadimartshophome-welcome-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    padding: 20px 14px 16px;
    text-align: center;
    box-shadow: var(--sh1);
}
.shahzadimartshophome-welcome-card__label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 14px;
}
.shahzadimartshophome-auth-btns {
    display: flex;
    gap: 8px;
}
.shahzadimartshophome-btn-reg {
    flex: 1;
    background: var(--light);
    color: var(--text);
    border: 1.5px solid var(--border);
    padding: 10px 4px;
    border-radius: 26px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    transition: var(--t);
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}
.shahzadimartshophome-btn-reg:hover {
    border-color: var(--red);
    color: var(--red);
}
.shahzadimartshophome-btn-sign {
    flex: 1;
    background: var(--red);
    color: #fff;
    border: none;
    padding: 10px 4px;
    border-radius: 26px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    transition: var(--t);
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}
.shahzadimartshophome-btn-sign:hover {
    background: var(--red-d);
}
.shahzadimartshophome-clearance-card {
    flex: 1;
    background: linear-gradient(145deg, var(--red) 0%, #8b0000 100%);
    color: #fff;
    border-radius: var(--rm);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-family: 'Playfair Display', serif;
    font-size: 23px;
    font-weight: 900;
    line-height: 1.05;
    text-align: center;
    padding: 20px 10px;
    min-height: 100px;
    box-shadow: var(--sh-red);
    transition: var(--t);
    text-decoration: none;
    position: relative;
    overflow: hidden;
}
.shahzadimartshophome-clearance-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 80% 20%, rgba(255,255,255,.13), transparent 55%);
}
.shahzadimartshophome-clearance-card small {
    font-family: 'DM Sans', sans-serif;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .2em;
    text-transform: uppercase;
    opacity: .88;
    margin-top: 6px;
    display: block;
}
.shahzadimartshophome-clearance-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(200,16,46,.45);
}

/* ── Mobile strip ── */
.shahzadimartshophome-hero-mobile-strip {
    display: none;
    gap: 10px;
    margin-bottom: 18px;
}
.shahzadimartshophome-hero-mobile-strip .shahzadimartshophome-welcome-card { flex: 1; }
.shahzadimartshophome-hero-mobile-strip .shahzadimartshophome-clearance-card {
    flex: 0 0 130px;
    min-height: 76px;
    font-size: 17px;
}

/* ══ CATEGORY CIRCLES ══ */
.shahzadimartshophome-circles-box {
    margin-bottom: 24px;
    overflow: hidden;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    padding: 18px;
    box-shadow: var(--sh1);
}
.shahzadimartshophome-circles-track {
    display: flex;
    gap: 18px;
    width: max-content;
    animation: shahzadimartshophome-idx-marquee 34s linear infinite;
}
.shahzadimartshophome-circles-track:hover {
    animation-play-state: paused;
}
@keyframes shahzadimartshophome-idx-marquee {
    to { transform: translateX(-50%); }
}
.shahzadimartshophome-circle-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
    text-decoration: none;
}
.shahzadimartshophome-circle-img {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    overflow: hidden;
    border: 2.5px solid var(--border);
    transition: var(--t);
}
.shahzadimartshophome-circle-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.shahzadimartshophome-circle-item:hover .shahzadimartshophome-circle-img {
    border-color: var(--red);
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(200,16,46,.22);
}
.shahzadimartshophome-circle-item p {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--mid);
    text-align: center;
    white-space: nowrap;
}
.shahzadimartshophome-circle-item:hover p {
    color: var(--red);
}

/* ══ SECTION HEADER ══ */
.shahzadimartshophome-sec-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 28px 0 14px;
}
.shahzadimartshophome-sec-head h2 {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    font-weight: 800;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 11px;
}
.shahzadimartshophome-sec-head h2::before {
    content: '';
    width: 5px;
    height: 24px;
    background: var(--red);
    border-radius: 3px;
    flex-shrink: 0;
}
.shahzadimartshophome-see-all {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--red);
    letter-spacing: .07em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: gap .2s;
    text-decoration: none;
}
.shahzadimartshophome-see-all:hover { gap: 9px; }

/* ══ FLASH SALE BAR ══ */
.shahzadimartshophome-flash-hd {
    display: flex;
    align-items: center;
    gap: 14px;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    padding: 14px 20px;
    margin-bottom: 12px;
    box-shadow: var(--sh1);
    flex-wrap: wrap;
}
.shahzadimartshophome-flash-title {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    font-weight: 800;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
    min-width: 130px;
}
.shahzadimartshophome-flash-title i {
    color: var(--red);
    animation: shahzadimartshophome-flash-pulse 1.4s ease-in-out infinite;
}
@keyframes shahzadimartshophome-flash-pulse {
    0%,100% { opacity: 1; }
    50%     { opacity: .3; }
}

/* ══ HOT CATEGORIES ══ */
.shahzadimartshophome-hot-wrap {
    overflow: hidden;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    padding: 16px;
    box-shadow: var(--sh1);
    margin-bottom: 10px;
}
.shahzadimartshophome-hot-track {
    display: flex;
    gap: 14px;
    width: max-content;
    animation: shahzadimartshophome-idx-marquee 28s linear infinite;
}
.shahzadimartshophome-hot-track:hover {
    animation-play-state: paused;
}
.shahzadimartshophome-hot-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 14px 10px;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    transition: var(--t);
    flex-shrink: 0;
    width: 100px;
    text-decoration: none;
}
.shahzadimartshophome-hot-item:hover {
    border-color: var(--red);
    box-shadow: var(--sh2);
    transform: translateY(-3px);
}
.shahzadimartshophome-hot-img {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    overflow: hidden;
}
.shahzadimartshophome-hot-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.shahzadimartshophome-hot-item p {
    font-size: 12px;
    font-weight: 700;
    color: var(--mid);
    text-align: center;
    line-height: 1.3;
}
.shahzadimartshophome-hot-item:hover p {
    color: var(--red);
}

/* ══ PRODUCT GRID ══ */
.shahzadimartshophome-prod-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
    gap: 16px;
    margin-bottom: 32px;
}

/* ══ PRODUCT CARD ══ */
/* Card wrapper as anchor */
.shahzadimartshophome-p-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
    position: relative;
}
.shahzadimartshophome-p-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    overflow: hidden;
    position: relative;
    transition: var(--t);
    display: flex;
    flex-direction: column;
    height: 100%;
}
.shahzadimartshophome-p-card:hover {
    box-shadow: var(--sh3);
    transform: translateY(-5px);
    border-color: var(--border-d);
}

.shahzadimartshophome-p-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: var(--red);
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    padding: 4px 9px;
    border-radius: 5px;
    letter-spacing: .04em;
    z-index: 2;
}

/* ── Wishlist button ── */
.shahzadimartshophome-p-wish {
    position: absolute;
    top: 9px;
    right: 9px;
    width: 34px;
    height: 34px;
    background: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: #bbb;
    box-shadow: 0 2px 8px rgba(0,0,0,.13);
    z-index: 10;
    border: none;
    cursor: pointer;
    transition: color .2s, background .2s, transform .2s;
    opacity: 0;
    pointer-events: none;
    text-decoration: none;
}
.shahzadimartshophome-p-card:hover .shahzadimartshophome-p-wish {
    opacity: 1;
    pointer-events: auto;
}
.shahzadimartshophome-p-wish:hover {
    transform: scale(1.15);
    color: var(--red);
    background: #fff0f0;
}

.shahzadimartshophome-p-img-wrap {
    position: relative;
    overflow: hidden;
}
.shahzadimartshophome-p-img {
    width: 100%;
    height: 165px;
    object-fit: cover;
    border-bottom: 1px solid var(--border);
    transition: transform .35s cubic-bezier(.4,0,.2,1);
    display: block;
}
.shahzadimartshophome-p-card:hover .shahzadimartshophome-p-img {
    transform: scale(1.06);
}

.shahzadimartshophome-p-body {
    padding: 12px 13px 13px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.shahzadimartshophome-p-name {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text);
    line-height: 1.48;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.shahzadimartshophome-p-price {
    font-size: 16px;
    font-weight: 900;
    color: var(--red);
    margin-bottom: 2px;
}
.shahzadimartshophome-p-old {
    font-size: 12px;
    color: var(--muted);
    text-decoration: line-through;
    margin-bottom: 5px;
}
.shahzadimartshophome-p-stock {
    font-size: 11.5px;
    font-weight: 700;
    color: #d97706;
    margin-bottom: 5px;
}
.shahzadimartshophome-p-stars {
    color: #f59e0b;
    font-size: 12.5px;
}
.shahzadimartshophome-p-rc {
    color: var(--muted);
    font-size: 11.5px;
    margin-left: 3px;
}
.shahzadimartshophome-p-meta { margin-bottom: 10px; }

/* Add to Cart button */
.shahzadimartshophome-p-atc {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    padding: 11px 0;
    background: var(--red);
    color: #fff;
    border: none;
    border-radius: var(--r);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: .02em;
    cursor: pointer;
    transition: var(--t);
    margin-top: auto;
    text-decoration: none;
}
.shahzadimartshophome-p-atc:hover {
    background: var(--red-d);
    transform: translateY(-1px);
    box-shadow: 0 5px 14px rgba(200,16,46,.35);
    color: #fff;
}
.shahzadimartshophome-p-atc:active { transform: scale(.97); }
.shahzadimartshophome-p-atc i { font-size: 12px; }

/* View Detail button (secondary) */
.shahzadimartshophome-p-view {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    padding: 8px 0;
    background: transparent;
    color: var(--red);
    border: 1.5px solid var(--red);
    border-radius: var(--r);
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: var(--t);
    margin-top: 6px;
    text-decoration: none;
}
.shahzadimartshophome-p-view:hover {
    background: var(--red);
    color: #fff;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 900px) {
    .shahzadimartshophome-hero { grid-template-columns: 1fr; }
    .shahzadimartshophome-hero-panel { display: none; }
    .shahzadimartshophome-hero-mobile-strip { display: flex; }
    .shahzadimartshophome-prod-grid { grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 13px; }
    .shahzadimartshophome-p-wish { opacity: 1; pointer-events: auto; }
}
@media (max-width: 640px) {
    .shahzadimartshophome-slide { height: 230px; }
    .shahzadimartshophome-hero-slider { height: 230px; }
    .shahzadimartshophome-hero-mobile-strip .shahzadimartshophome-clearance-card { flex: 0 0 110px; font-size: 15px; }
    .shahzadimartshophome-sec-head h2 { font-size: 20px; }
    .shahzadimartshophome-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 11px; }
    .shahzadimartshophome-p-img { height: 140px; }
    .shahzadimartshophome-flash-hd { padding: 11px 16px; gap: 9px; }
    .shahzadimartshophome-flash-title { font-size: 18px; }
}
@media (max-width: 420px) {
    .shahzadimartshophome-slide { height: 195px; }
    .shahzadimartshophome-hero-slider { height: 195px; }
    .shahzadimartshophome-hero-mobile-strip .shahzadimartshophome-clearance-card { flex: 0 0 96px; font-size: 14px; }
    .shahzadimartshophome-prod-grid { gap: 9px; }
    .shahzadimartshophome-p-name { font-size: 12.5px; }
    .shahzadimartshophome-p-price { font-size: 15px; }
    .shahzadimartshophome-p-img { height: 130px; }
    .shahzadimartshophome-circle-img { width: 63px; height: 63px; }
    .shahzadimartshophome-circle-item p { font-size: 11.5px; }
    .shahzadimartshophome-sec-head h2 { font-size: 18px; }
}
@media (max-width: 360px) {
    .shahzadimartshophome-hero-mobile-strip { flex-direction: column; }
    .shahzadimartshophome-hero-mobile-strip .shahzadimartshophome-clearance-card {
        flex: none;
        min-height: 64px;
        flex-direction: row;
        gap: 8px;
        font-size: 15px;
    }
    .shahzadimartshophome-prod-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

{{-- ══ Flash message (cart/wishlist feedback) ══ --}}
@if(session('success'))
    <div style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;padding:10px 18px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;margin-bottom:12px;border-radius:8px;">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif
@if(session('info'))
    <div style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;padding:10px 18px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;margin-bottom:12px;border-radius:8px;">
        <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
    </div>
@endif
@if(session('error'))
    <div style="background:#fff0f1;color:#e8192c;border:1px solid #fecdd3;padding:10px 18px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;margin-bottom:12px;border-radius:8px;">
        <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
    </div>
@endif

<div class="shahzadimartshophome-ci content-area-inner">

    {{-- ══════════════════════════════════════════
         HERO — Slider + Right Panel
    ══════════════════════════════════════════ --}}
    <div class="shahzadimartshophome-hero">
        {{-- ── Slider ── --}}
        <div class="shahzadimartshophome-hero-slider">
            <div class="shahzadimartshophome-slides-wrap">
                @forelse ($slider as $item)
                    <div class="shahzadimartshophome-slide">
                        <img src="{{ $item->photo ?? '' }}" alt="Slide">
                    </div>
                @empty
                    <div class="shahzadimartshophome-slide" style="background:#222; display:flex; align-items:center; justify-content:center;">
                        <span style="color:#555; font-size:14px;">No slides added yet</span>
                    </div>
                @endforelse
            </div>
            <div class="shahzadimartshophome-sl-dots">
                <div class="shahzadimartshophome-sl-dot"></div>
                <div class="shahzadimartshophome-sl-dot"></div>
                <div class="shahzadimartshophome-sl-dot"></div>
                <div class="shahzadimartshophome-sl-dot"></div>
            </div>
        </div>

        {{-- ── Right Panel (Desktop) ── --}}
        <div class="shahzadimartshophome-hero-panel">
            <div class="shahzadimartshophome-welcome-card">
                <p class="shahzadimartshophome-welcome-card__label">Welcome Back</p>
                <div class="shahzadimartshophome-auth-btns">
                    <a href="{{ url('customer/register') }}" class="shahzadimartshophome-btn-reg">Register</a>
                    <a href="{{ url('customer/login') }}" class="shahzadimartshophome-btn-sign">Sign In</a>
                </div>
            </div>
            <a href="{{ url('clearance') }}" class="shahzadimartshophome-clearance-card">
                CLEA-<br>RANCE
                <small>UP TO 70% OFF</small>
            </a>
        </div>
    </div>

    {{-- ── Mobile Strip ── --}}
    <div class="shahzadimartshophome-hero-mobile-strip">
        <div class="shahzadimartshophome-welcome-card" style="flex:1">
            <p class="shahzadimartshophome-welcome-card__label">Welcome Back</p>
            <div class="shahzadimartshophome-auth-btns">
                <a href="{{ url('customer/register') }}" class="shahzadimartshophome-btn-reg">Register</a>
                <a href="{{ url('customer/login') }}" class="shahzadimartshophome-btn-sign">Sign In</a>
            </div>
        </div>
        <a href="{{ url('clearance') }}" class="shahzadimartshophome-clearance-card">
            CLEA-<br>RANCE
            <small>UP TO 70% OFF</small>
        </a>
    </div>


    {{-- ══════════════════════════════════════════
         CATEGORY CIRCLES — marquee
    ══════════════════════════════════════════ --}}
    @if($categories->isNotEmpty())
    <div class="shahzadimartshophome-circles-box">
        <div class="shahzadimartshophome-circles-track">
            @foreach ($categories as $cat)
                <a href="{{ url('category/' . $cat->slug) }}" class="shahzadimartshophome-circle-item">
                    <div class="shahzadimartshophome-circle-img">
                        <img src="{{ asset('uploads/category/' . $cat->category_photo) }}"
                             alt="{{ $cat->category_name }}" loading="lazy">
                    </div>
                    <p>{{ $cat->category_name }}</p>
                </a>
            @endforeach
            @foreach ($categories as $cat)
                <a href="{{ url('category/' . $cat->slug) }}" class="shahzadimartshophome-circle-item">
                    <div class="shahzadimartshophome-circle-img">
                        <img src="{{ asset('uploads/category/' . $cat->category_photo) }}"
                             alt="{{ $cat->category_name }}" loading="lazy">
                    </div>
                    <p>{{ $cat->category_name }}</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif


    {{-- ══════════════════════════════════════════
         FLASH SALES
    ══════════════════════════════════════════ --}}
    @if($flashProducts->isNotEmpty())
    <div class="shahzadimartshophome-flash-hd">
        <div class="shahzadimartshophome-flash-title">
            <i class="fa-solid fa-bolt"></i> Flash Sales
        </div>
        <a href="{{ url('flash-sales') }}" class="shahzadimartshophome-see-all">
            SEE ALL <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    <div class="shahzadimartshophome-prod-grid">
        @foreach ($flashProducts as $item)
            @php
                $displayPrice  = $item->flash_sale_price ?? $item->discount_price ?? $item->current_price;
                $originalPrice = $item->current_price;
                $discount      = ($displayPrice < $originalPrice && $originalPrice > 0)
                    ? round((($originalPrice - $displayPrice) / $originalPrice) * 100)
                    : null;
                $inStock       = $item->is_unlimited || ($item->stock ?? 0) > 0;
            @endphp

            {{-- ✅ পুরো কার্ড ক্লিক করলে product detail পেজে যাবে --}}
            <div style="position:relative">
                {{-- Wishlist button — কার্ড ক্লিকের বাইরে থাকবে --}}
                <a href="{{ route('wishlist.add', $item->id) }}"
                   class="shahzadimartshophome-p-wish"
                   title="উইশলিস্টে যোগ করুন"
                   onclick="event.stopPropagation()">
                    <i class="bi bi-heart"></i>
                </a>

                <a href="{{ route('product.detail', $item->slug) }}"
                   class="shahzadimartshophome-p-card-link">
                    <div class="shahzadimartshophome-p-card">
                        @if($discount)
                            <span class="shahzadimartshophome-p-badge">-{{ $discount }}%</span>
                        @endif

                        <div class="shahzadimartshophome-p-img-wrap">
                            <img class="shahzadimartshophome-p-img"
                                 src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                 alt="{{ $item->name }}" loading="lazy">
                        </div>
                        <div class="shahzadimartshophome-p-body">
                            <p class="shahzadimartshophome-p-name">{{ $item->name }}</p>
                            <p class="shahzadimartshophome-p-price">৳ {{ number_format($displayPrice, 0) }}</p>
                            @if($displayPrice < $originalPrice)
                                <p class="shahzadimartshophome-p-old">৳ {{ number_format($originalPrice, 0) }}</p>
                            @endif
                            <div class="shahzadimartshophome-p-meta">
                                @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                                    <p class="shahzadimartshophome-p-stock">
                                        <i class="fas fa-fire-flame-curved" style="font-size:10px"></i>
                                        {{ $item->stock }} left
                                    </p>
                                @endif
                                <span class="shahzadimartshophome-p-stars">★★★★☆</span>
                            </div>

                            {{-- ✅ কার্টে যোগ করুন — stopPropagation দিয়ে card link override --}}
                            @if($inStock)
                                <a href="{{ route('cart.add', $item->id) }}"
                                   class="shahzadimartshophome-p-atc"
                                   onclick="event.stopPropagation()">
                                    <i class="fas fa-cart-plus"></i> কার্টে যোগ করুন
                                </a>
                            @else
                                <span class="shahzadimartshophome-p-atc"
                                      style="background:#e5e7eb;color:#9ca3af;cursor:not-allowed;">
                                    <i class="fas fa-times-circle"></i> স্টক নেই
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    @endif


    {{-- ══════════════════════════════════════════
         NEW ARRIVALS
    ══════════════════════════════════════════ --}}
    @if($newArrivals->isNotEmpty())
    <div class="shahzadimartshophome-sec-head">
        <h2>New Arrivals</h2>
        <a href="{{ url('new-arrivals') }}" class="shahzadimartshophome-see-all">
            SEE ALL <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    <div class="shahzadimartshophome-prod-grid">
        @foreach ($newArrivals as $item)
            @php
                $discount = ($item->discount_price && $item->current_price > 0)
                    ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100)
                    : null;
                $inStock  = $item->is_unlimited || ($item->stock ?? 0) > 0;
            @endphp

            <div style="position:relative">
                <a href="{{ route('wishlist.add', $item->id) }}"
                   class="shahzadimartshophome-p-wish"
                   title="উইশলিস্টে যোগ করুন"
                   onclick="event.stopPropagation()">
                    <i class="bi bi-heart"></i>
                </a>

                <a href="{{ route('product.detail', $item->slug) }}"
                   class="shahzadimartshophome-p-card-link">
                    <div class="shahzadimartshophome-p-card">
                        @if($discount)
                            <span class="shahzadimartshophome-p-badge">-{{ $discount }}%</span>
                        @endif

                        <div class="shahzadimartshophome-p-img-wrap">
                            <img class="shahzadimartshophome-p-img"
                                 src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                 alt="{{ $item->name }}" loading="lazy">
                        </div>
                        <div class="shahzadimartshophome-p-body">
                            <p class="shahzadimartshophome-p-name">{{ $item->name }}</p>
                            <p class="shahzadimartshophome-p-price">৳ {{ number_format($item->discount_price ?? $item->current_price, 0) }}</p>
                            @if($item->discount_price)
                                <p class="shahzadimartshophome-p-old">৳ {{ number_format($item->current_price, 0) }}</p>
                            @endif
                            <div class="shahzadimartshophome-p-meta">
                                @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                                    <p class="shahzadimartshophome-p-stock">
                                        <i class="fas fa-fire-flame-curved" style="font-size:10px"></i>
                                        {{ $item->stock }} left
                                    </p>
                                @endif
                                <span class="shahzadimartshophome-p-stars">★★★★☆</span>
                            </div>

                            @if($inStock)
                                <a href="{{ route('cart.add', $item->id) }}"
                                   class="shahzadimartshophome-p-atc"
                                   onclick="event.stopPropagation()">
                                    <i class="fas fa-cart-plus"></i> কার্টে যোগ করুন
                                </a>
                            @else
                                <span class="shahzadimartshophome-p-atc"
                                      style="background:#e5e7eb;color:#9ca3af;cursor:not-allowed;">
                                    <i class="fas fa-times-circle"></i> স্টক নেই
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    @endif


    {{-- ══════════════════════════════════════════
         BEST SELLERS
    ══════════════════════════════════════════ --}}
    @if($bestSellers->isNotEmpty())
    <div class="shahzadimartshophome-sec-head" style="margin-top:6px">
        <h2>Best Sellers</h2>
        <a href="{{ url('best-sellers') }}" class="shahzadimartshophome-see-all">
            SEE ALL <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    <div class="shahzadimartshophome-prod-grid">
        @foreach ($bestSellers as $item)
            @php
                $discount = ($item->discount_price && $item->current_price > 0)
                    ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100)
                    : null;
                $inStock  = $item->is_unlimited || ($item->stock ?? 0) > 0;
            @endphp

            <div style="position:relative">
                <a href="{{ route('wishlist.add', $item->id) }}"
                   class="shahzadimartshophome-p-wish"
                   title="উইশলিস্টে যোগ করুন"
                   onclick="event.stopPropagation()">
                    <i class="bi bi-heart"></i>
                </a>

                <a href="{{ route('product.detail', $item->slug) }}"
                   class="shahzadimartshophome-p-card-link">
                    <div class="shahzadimartshophome-p-card">
                        @if($discount)
                            <span class="shahzadimartshophome-p-badge">-{{ $discount }}%</span>
                        @endif

                        <div class="shahzadimartshophome-p-img-wrap">
                            <img class="shahzadimartshophome-p-img"
                                 src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                 alt="{{ $item->name }}" loading="lazy">
                        </div>
                        <div class="shahzadimartshophome-p-body">
                            <p class="shahzadimartshophome-p-name">{{ $item->name }}</p>
                            <p class="shahzadimartshophome-p-price">৳ {{ number_format($item->discount_price ?? $item->current_price, 0) }}</p>
                            @if($item->discount_price)
                                <p class="shahzadimartshophome-p-old">৳ {{ number_format($item->current_price, 0) }}</p>
                            @endif
                            <div class="shahzadimartshophome-p-meta">
                                @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                                    <p class="shahzadimartshophome-p-stock">
                                        <i class="fas fa-fire-flame-curved" style="font-size:10px"></i>
                                        {{ $item->stock }} left
                                    </p>
                                @endif
                                <span class="shahzadimartshophome-p-stars">★★★★☆</span>
                            </div>

                            @if($inStock)
                                <a href="{{ route('cart.add', $item->id) }}"
                                   class="shahzadimartshophome-p-atc"
                                   onclick="event.stopPropagation()">
                                    <i class="fas fa-cart-plus"></i> কার্টে যোগ করুন
                                </a>
                            @else
                                <span class="shahzadimartshophome-p-atc"
                                      style="background:#e5e7eb;color:#9ca3af;cursor:not-allowed;">
                                    <i class="fas fa-times-circle"></i> স্টক নেই
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    @endif

</div>{{-- /.shahzadimartshophome-ci --}}

@endsection
