{{-- resources/views/frontend/index.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
/* ════════════════════════════════════════════════════════
   FONT IMPORT — Nunito (body) + Fraunces (display)
════════════════════════════════════════════════════════ */
@import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,600;0,700;0,800;0,900;1,700&family=Nunito:wght@400;500;600;700;800;900&display=swap');

/* ════════════════════════════════════════════════════════
   INDEX PAGE TOKENS
════════════════════════════════════════════════════════ */
.content-area-inner,
.content-area-inner * {
    font-family: 'Nunito', sans-serif;
}
.content-area-inner h1,
.content-area-inner h2,
.content-area-inner .display-font {
    font-family: 'Fraunces', serif;
}

/* ════════════════════════════════════════════════════════
   HERO — 2-col desktop / stacked mobile
════════════════════════════════════════════════════════ */
.hero {
    display: grid;
    grid-template-columns: 1fr 200px;
    gap: 14px;
    margin-bottom: 20px;
}

/* ── Slider ── */
.hero-slider {
    position: relative;
    background: var(--light);
    border-radius: var(--rl);
    overflow: hidden;
    min-height: 280px;
    box-shadow: var(--sh1);
    border: 1px solid var(--border);
}
.slides-wrap {
    display: flex;
    transition: transform .55s var(--ease);
    height: 100%;
}
.slide {
    min-width: 100%;
    display: flex;
    align-items: center;
    padding: 30px 32px;
    gap: 20px;
    position: relative;
}
.slide-bg {
    position: absolute; inset: 0; opacity: .07;
    background: radial-gradient(circle at 70% 50%, var(--red), transparent 58%);
    pointer-events: none;
}
.slide-content { flex: 1; position: relative; z-index: 2; min-width: 0; }
.slide-tag {
    display: inline-flex; align-items: center; gap: 5px;
    background: var(--red); color: #fff;
    font-family: 'Nunito', sans-serif;
    font-size: 10.5px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase;
    padding: 4px 12px; border-radius: 20px; margin-bottom: 10px;
}
.slide-content h1 {
    font-family: 'Fraunces', serif;
    font-size: clamp(17px, 2.5vw, 28px);
    font-weight: 900; color: var(--dark); line-height: 1.18; margin-bottom: 9px;
}
.slide-sub {
    font-size: 13px; font-weight: 500; color: var(--muted); margin-bottom: 18px; line-height: 1.5;
}
.slide-btn {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--red); color: #fff;
    border: none; padding: 11px 26px; border-radius: 30px;
    font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 800;
    letter-spacing: .03em; cursor: pointer; transition: var(--t);
    box-shadow: var(--sh-red);
}
.slide-btn:hover { background: var(--red-d); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(200,16,46,.4); }
.slide-img { flex-shrink: 0; width: 160px; position: relative; z-index: 2; }
.slide-img img { width: 100%; height: 175px; object-fit: cover; border-radius: var(--rm); }

.sl-arrow {
    position: absolute; top: 50%; transform: translateY(-50%);
    background: var(--white); border: 1.5px solid var(--border);
    width: 34px; height: 34px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 11px; color: var(--text);
    box-shadow: var(--sh2); transition: var(--t); z-index: 10; outline: none;
}
.sl-arrow:hover { background: var(--red); color: #fff; border-color: var(--red); }
.sl-prev { left: 12px; }
.sl-next { right: 12px; }
.sl-dots {
    position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%);
    display: flex; gap: 5px; z-index: 10;
}
.sl-dot {
    width: 7px; height: 7px; border-radius: 4px;
    background: rgba(0,0,0,.2); cursor: pointer;
    transition: var(--t); border: none; padding: 0;
}
.sl-dot.active { background: var(--red); width: 22px; }

/* ── Hero Panel ── */
.hero-panel { display: flex; flex-direction: column; gap: 10px; }

.welcome-card {
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); padding: 16px 12px 14px;
    text-align: center; box-shadow: var(--sh1);
}
.welcome-card__label {
    font-size: 10px; font-weight: 800; letter-spacing: .12em;
    text-transform: uppercase; color: var(--muted); margin-bottom: 12px;
}
.auth-btns { display: flex; gap: 7px; }
.btn-reg {
    flex: 1; background: var(--light); color: var(--text);
    border: 1.5px solid var(--border); padding: 9px 4px; border-radius: 22px;
    font-family: 'Nunito', sans-serif; font-size: 12px; font-weight: 800;
    cursor: pointer; transition: var(--t);
}
.btn-reg:hover { border-color: var(--red); color: var(--red); }
.btn-sign {
    flex: 1; background: var(--red); color: #fff;
    border: none; padding: 9px 4px; border-radius: 22px;
    font-family: 'Nunito', sans-serif; font-size: 12px; font-weight: 800;
    cursor: pointer; transition: var(--t);
}
.btn-sign:hover { background: var(--red-d); }

.clearance-card {
    flex: 1; background: linear-gradient(140deg, var(--red) 0%, #7a000f 100%);
    color: #fff; border-radius: var(--rm);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    font-family: 'Fraunces', serif;
    font-size: 20px; font-weight: 900;
    line-height: 1.05; text-align: center;
    padding: 16px 10px; min-height: 90px;
    box-shadow: var(--sh-red); cursor: pointer;
    transition: var(--t); text-decoration: none;
    position: relative; overflow: hidden;
}
.clearance-card::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(circle at 80% 20%, rgba(255,255,255,.12), transparent 60%);
}
.clearance-card small {
    font-family: 'Nunito', sans-serif;
    font-size: 8.5px; font-weight: 900; letter-spacing: .18em;
    text-transform: uppercase; opacity: .85; margin-top: 5px; display: block;
}
.clearance-card:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(200,16,46,.45); }

/* ════════════════════════════════════════════════
   MOBILE HERO STRIP
════════════════════════════════════════════════ */
.hero-mobile-strip {
    display: none;
    gap: 10px;
    margin-bottom: 16px;
}
.hero-mobile-strip .welcome-card { flex: 1; }
.hero-mobile-strip .clearance-card {
    flex: 0 0 120px; min-height: 72px; font-size: 16px;
}

/* ════════════════════════════════════════════════
   CATEGORY CIRCLES — marquee
════════════════════════════════════════════════ */
.circles-box {
    margin-bottom: 20px; overflow: hidden;
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); padding: 14px 16px; box-shadow: var(--sh1);
}
.circles-track {
    display: flex; gap: 14px; width: max-content;
    animation: idx-marquee 34s linear infinite;
}
.circles-track:hover { animation-play-state: paused; }
@keyframes idx-marquee { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }

.circle-item {
    display: flex; flex-direction: column; align-items: center;
    gap: 7px; cursor: pointer; flex-shrink: 0; text-decoration: none;
}
.circle-img {
    width: 66px; height: 66px; border-radius: 50%; overflow: hidden;
    border: 2.5px solid var(--border); transition: var(--t);
}
.circle-img img { width: 100%; height: 100%; object-fit: cover; }
.circle-item:hover .circle-img {
    border-color: var(--red); transform: scale(1.09);
    box-shadow: 0 5px 14px rgba(200,16,46,.22);
}
.circle-item p {
    font-size: 11px; font-weight: 700; color: var(--mid);
    text-align: center; white-space: nowrap;
}
.circle-item:hover p { color: var(--red); }

/* ════════════════════════════════════════════════
   SECTION HEADER
════════════════════════════════════════════════ */
.sec-head {
    display: flex; align-items: center;
    justify-content: space-between; margin: 24px 0 12px;
}
.sec-head h2 {
    font-family: 'Fraunces', serif;
    font-size: 21px; font-weight: 800; color: var(--dark);
    display: flex; align-items: center; gap: 10px;
}
.sec-head h2::before {
    content: '';
    width: 4px; height: 20px;
    background: var(--red); border-radius: 3px; flex-shrink: 0;
}
.see-all {
    font-family: 'Nunito', sans-serif;
    font-size: 11px; font-weight: 800; color: var(--red);
    letter-spacing: .08em; text-transform: uppercase;
    display: flex; align-items: center; gap: 5px; transition: gap .2s;
}
.see-all:hover { gap: 9px; }

/* ════════════════════════════════════════════════
   FLASH SALE BAR
════════════════════════════════════════════════ */
.flash-hd {
    display: flex; align-items: center; gap: 12px;
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); padding: 12px 18px;
    margin-bottom: 10px; box-shadow: var(--sh1);
    flex-wrap: wrap;
}
.flash-title {
    font-family: 'Fraunces', serif; font-size: 18px; font-weight: 800;
    color: var(--dark); display: flex; align-items: center; gap: 7px; flex: 1;
    min-width: 120px;
}
.flash-title i { color: var(--red); animation: flash-pulse 1.4s ease-in-out infinite; }
@keyframes flash-pulse { 0%,100%{opacity:1} 50%{opacity:.3} }
.flash-timer {
    background: var(--dark); color: var(--white);
    padding: 6px 14px; border-radius: 20px;
    font-family: 'Nunito', sans-serif;
    font-size: 12px; font-weight: 800; letter-spacing: .04em;
    white-space: nowrap;
}

/* ════════════════════════════════════════════════
   HOT CATEGORIES
════════════════════════════════════════════════ */
.hot-wrap {
    overflow: hidden;
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); padding: 14px;
    box-shadow: var(--sh1); margin-bottom: 8px;
}
.hot-track {
    display: flex; gap: 12px; width: max-content;
    animation: idx-marquee 28s linear infinite;
}
.hot-track:hover { animation-play-state: paused; }
.hot-item {
    display: flex; flex-direction: column; align-items: center; gap: 7px;
    cursor: pointer; padding: 12px 8px;
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); transition: var(--t);
    flex-shrink: 0; width: 90px; text-decoration: none;
}
.hot-item:hover { border-color: var(--red); box-shadow: var(--sh2); transform: translateY(-2px); }
.hot-img { width: 54px; height: 54px; border-radius: 50%; overflow: hidden; }
.hot-img img { width: 100%; height: 100%; object-fit: cover; }
.hot-item p { font-size: 11px; font-weight: 700; color: var(--mid); text-align: center; line-height: 1.3; }
.hot-item:hover p { color: var(--red); }

/* ════════════════════════════════════════════════
   PRODUCT GRID — Normal grid for all sections
════════════════════════════════════════════════ */
.prod-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
    gap: 14px;
    margin-bottom: 30px;
}

/* ════════════════════════════════════════════════
   PRODUCT CARD
════════════════════════════════════════════════ */
.p-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    overflow: hidden; position: relative;
    transition: var(--t); cursor: pointer;
    display: flex; flex-direction: column;
}
.p-card:hover {
    box-shadow: var(--sh3);
    transform: translateY(-4px);
    border-color: var(--border-d);
}
.p-badge {
    position: absolute; top: 9px; left: 9px;
    background: var(--red); color: #fff;
    font-family: 'Nunito', sans-serif;
    font-size: 9.5px; font-weight: 800; padding: 3px 8px;
    border-radius: 4px; letter-spacing: .04em; z-index: 2;
}
.p-wish {
    position: absolute; top: 8px; right: 8px;
    width: 28px; height: 28px; background: var(--white);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; color: var(--muted);
    box-shadow: var(--sh1); z-index: 2;
    transition: var(--t); opacity: 0; border: none; cursor: pointer;
}
.p-card:hover .p-wish { opacity: 1; }
.p-wish:hover { color: var(--red); transform: scale(1.15); }

.p-img-wrap { position: relative; overflow: hidden; }
.p-img {
    width: 100%; height: 150px; object-fit: cover;
    border-bottom: 1px solid var(--border);
    transition: transform .35s var(--ease);
    display: block;
}
.p-card:hover .p-img { transform: scale(1.06); }

.p-body {
    padding: 10px 11px 11px;
    display: flex; flex-direction: column; flex: 1;
}
.p-name {
    font-size: 12px; font-weight: 600; color: var(--text);
    line-height: 1.45; margin-bottom: 6px;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.p-price { font-size: 14.5px; font-weight: 900; color: var(--red); margin-bottom: 1px; }
.p-old { font-size: 11px; color: var(--muted); text-decoration: line-through; margin-bottom: 4px; }
.p-stock { font-size: 10.5px; font-weight: 700; color: #d97706; margin-bottom: 4px; }
.p-stars { color: #f59e0b; font-size: 11.5px; }
.p-rc { color: var(--muted); font-size: 10.5px; margin-left: 3px; }
.p-meta { margin-bottom: 9px; }

.p-atc {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    width: 100%; padding: 9px 0;
    background: var(--red); color: #fff;
    border: none; border-radius: var(--r);
    font-family: 'Nunito', sans-serif;
    font-size: 11.5px; font-weight: 800; letter-spacing: .03em;
    cursor: pointer; transition: var(--t); margin-top: auto;
}
.p-atc:hover {
    background: var(--red-d); transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(200,16,46,.35);
}
.p-atc:active { transform: scale(.97); }
.p-atc i { font-size: 11px; }

/* ════════════════════════════════════════════════
   RESPONSIVE — tablet ≤900px
════════════════════════════════════════════════ */
@media (max-width: 900px) {
    .hero { grid-template-columns: 1fr; }
    .hero-panel { display: none; }
    .hero-mobile-strip { display: flex; }
    .prod-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; }
}

/* ════════════════════════════════════════════════
   RESPONSIVE — phone ≤640px
════════════════════════════════════════════════ */
@media (max-width: 640px) {
    .slide { padding: 20px 16px; gap: 12px; }
    .slide-img { width: 110px; }
    .slide-img img { height: 120px; }
    .slide-content h1 { font-size: 16px; }
    .slide-sub { font-size: 12px; margin-bottom: 14px; }
    .slide-btn { padding: 9px 20px; font-size: 12px; }
    .hero-slider { min-height: 220px; }
    .hero-mobile-strip .clearance-card { flex: 0 0 100px; font-size: 14px; }
    .hero-mobile-strip .welcome-card { padding: 12px 10px 10px; }
    .sec-head h2 { font-size: 17px; }
    .prod-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .p-img { height: 130px; }
    .flash-hd { padding: 10px 14px; gap: 8px; }
    .flash-title { font-size: 16px; }
    .flash-timer { font-size: 11px; padding: 5px 11px; }
}

/* ════════════════════════════════════════════════
   RESPONSIVE — small phone ≤420px
════════════════════════════════════════════════ */
@media (max-width: 420px) {
    .slide-img { display: none; }
    .slide { padding: 18px 14px; }
    .slide-content h1 { font-size: 17px; }
    .hero-slider { min-height: 200px; }
    .hero-mobile-strip .clearance-card { flex: 0 0 90px; font-size: 13px; }
    .hero-mobile-strip .clearance-card small { font-size: 7px; letter-spacing: .12em; }
    .prod-grid { gap: 8px; }
    .p-name { font-size: 11px; }
    .p-price { font-size: 13.5px; }
    .p-img { height: 120px; }
    .circle-img { width: 58px; height: 58px; }
    .circle-item p { font-size: 10px; }
    .sec-head h2 { font-size: 15px; }
    .sec-head h2::before { height: 17px; }
}

/* ════════════════════════════════════════════════
   RESPONSIVE — very small ≤360px
════════════════════════════════════════════════ */
@media (max-width: 360px) {
    .hero-mobile-strip { flex-direction: column; }
    .hero-mobile-strip .clearance-card { flex: none; min-height: 60px; flex-direction: row; gap: 8px; font-size: 14px; }
    .prod-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<div class="content-area-inner">

    {{-- ══ HERO ══ --}}
    <div class="hero">

        {{-- Slider --}}
        <div class="hero-slider" id="heroSlider">
            <div class="slides-wrap" id="heroWrap">

                <div class="slide">
                    <div class="slide-bg"></div>
                    <div class="slide-content">
                        <span class="slide-tag"><i class="fas fa-bolt"></i> 30% OFF TODAY</span>
                        <h1>Hot Deals on<br>Cool Gadgets!</h1>
                        <p class="slide-sub">Exclusive tech deals — limited stock!</p>
                        <button class="slide-btn">Shop Now <i class="fas fa-arrow-right"></i></button>
                    </div>
                    <div class="slide-img">
                        <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=400&h=300&fit=crop" alt="Gadgets">
                    </div>
                </div>

                <div class="slide">
                    <div class="slide-bg"></div>
                    <div class="slide-content">
                        <span class="slide-tag"><i class="fas fa-headphones"></i> NEW IN</span>
                        <h1>Elevate Your<br>Audio Experience</h1>
                        <p class="slide-sub">Premium sound, premium feel.</p>
                        <button class="slide-btn">Explore Now <i class="fas fa-arrow-right"></i></button>
                    </div>
                    <div class="slide-img">
                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop" alt="Headphones">
                    </div>
                </div>

                <div class="slide">
                    <div class="slide-bg"></div>
                    <div class="slide-content">
                        <span class="slide-tag"><i class="fas fa-baby"></i> BABY WEEK</span>
                        <h1>Cozy Comfort for<br>Little Ones!</h1>
                        <p class="slide-sub">Everything your baby needs.</p>
                        <button class="slide-btn">Shop Baby <i class="fas fa-arrow-right"></i></button>
                    </div>
                    <div class="slide-img">
                        <img src="https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=400&h=300&fit=crop" alt="Baby">
                    </div>
                </div>

                <div class="slide">
                    <div class="slide-bg"></div>
                    <div class="slide-content">
                        <span class="slide-tag"><i class="fas fa-music"></i> CRYSTAL CLEAR</span>
                        <h1>Dive Into a World of<br>Crystal Clear Sound</h1>
                        <p class="slide-sub">Studio-quality audio at home.</p>
                        <button class="slide-btn">Buy Now <i class="fas fa-arrow-right"></i></button>
                    </div>
                    <div class="slide-img">
                        <img src="https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&h=300&fit=crop" alt="Speakers">
                    </div>
                </div>

            </div>

            <button class="sl-arrow sl-prev" onclick="heroSlide(-1)" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="sl-arrow sl-next" onclick="heroSlide(1)" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>

            <div class="sl-dots" id="heroDots">
                <button class="sl-dot active" onclick="heroGoTo(0)"></button>
                <button class="sl-dot" onclick="heroGoTo(1)"></button>
                <button class="sl-dot" onclick="heroGoTo(2)"></button>
                <button class="sl-dot" onclick="heroGoTo(3)"></button>
            </div>
        </div>

        {{-- Right Panel — desktop only --}}
        <div class="hero-panel">
            <div class="welcome-card">
                <p class="welcome-card__label">Welcome Back</p>
                <div class="auth-btns">
                    <button class="btn-reg" onclick="window.location.href='{{ url('customer/register') }}'">Register</button>
                    <button class="btn-sign" onclick="window.location.href='{{ url('customer/login') }}'">Sign In</button>
                </div>
            </div>
            <a href="#" class="clearance-card">
                CLEA-<br>RANCE
                <small>UP TO 70% OFF</small>
            </a>
        </div>
    </div>

    {{-- Mobile strip --}}
    <div class="hero-mobile-strip">
        <div class="welcome-card" style="flex:1">
            <p class="welcome-card__label">Welcome Back</p>
            <div class="auth-btns">
                <button class="btn-reg" onclick="window.location.href='{{ url('customer/register') }}'">Register</button>
                <button class="btn-sign" onclick="window.location.href='{{ url('customer/login') }}'">Sign In</button>
            </div>
        </div>
        <a href="#" class="clearance-card">
            CLEA-<br>RANCE
            <small>UP TO 70% OFF</small>
        </a>
    </div>

    {{-- ══ CATEGORY CIRCLES ══ --}}
    <div class="circles-box">
        <div class="circles-track">
            @php
            $cats = [
                ['img'=>'photo-1572635196237-14b3f281503f','label'=>'Sunglasses'],
                ['img'=>'photo-1593640495253-23196b27a87f','label'=>'Flash Sales'],
                ['img'=>'photo-1511707171634-5f897ff02aa9','label'=>'Phones'],
                ['img'=>'photo-1517336714731-489689fd1ca8','label'=>'Laptops'],
                ['img'=>'photo-1608043152269-423dbba4e7e1','label'=>'Speakers'],
                ['img'=>'photo-1587829741301-dc798b83add3','label'=>'Keyboards'],
                ['img'=>'photo-1585255318859-f5c15f4cffe9','label'=>'Watches'],
                ['img'=>'photo-1490481651871-ab68de25d43d','label'=>'Fashion'],
                ['img'=>'photo-1596462502278-27bfdc403348','label'=>'Beauty'],
                ['img'=>'photo-1556909114-44e3e70034e2','label'=>'Home'],
            ];
            @endphp
            @foreach(array_merge($cats, $cats) as $cat)
            <a href="#" class="circle-item">
                <div class="circle-img">
                    <img src="https://images.unsplash.com/{{ $cat['img'] }}?w=150&h=150&fit=crop"
                         alt="{{ $cat['label'] }}" loading="lazy">
                </div>
                <p>{{ $cat['label'] }}</p>
            </a>
            @endforeach
        </div>
    </div>

    {{-- ══ FLASH SALES — Normal Grid (carousel removed) ══ --}}
    <div class="flash-hd">
        <div class="flash-title"><i class="fas fa-bolt"></i> Flash Sales</div>
        <div class="flash-timer" id="flashTimer">Ends in: 02h : 26m : 17s</div>
        <a href="#" class="see-all">SEE ALL <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="prod-grid">
        @php
        $flashProducts = [
            ['img'=>'photo-1587831990711-23ca6441447b','name'=>'Lenovo V30a Business All-in-One Desktop','price'=>'KSh 44,326','old'=>'KSh 54,900','badge'=>'-18%','stock'=>'13 left','stars'=>3,'rc'=>74],
            ['img'=>'photo-1593642632823-8f785ba67e45','name'=>'Acer Chromebook Spin 314 Convertible Laptop','price'=>'KSh 34,260','old'=>'KSh 41,800','badge'=>'-18%','stock'=>'22 left','stars'=>3,'rc'=>56],
            ['img'=>'photo-1527814050087-3793815479db','name'=>'Razer Naga Pro Wireless Gaming Mouse','price'=>'KSh 999','old'=>'KSh 1,200','badge'=>'-17%','stock'=>'11 left','stars'=>4,'rc'=>132],
            ['img'=>'photo-1587829741301-dc798b83add3','name'=>'Redragon S101 RGB Backlit Gaming Keyboard','price'=>'KSh 4,260','old'=>'KSh 5,200','badge'=>'-18%','stock'=>'6 left','stars'=>4,'rc'=>89],
            ['img'=>'photo-1615663245857-ac93bb7c39e7','name'=>'SteelSeries QcK Gaming Mouse Pad','price'=>'KSh 999','old'=>'KSh 1,200','badge'=>'-17%','stock'=>'3 left','stars'=>4,'rc'=>245],
            ['img'=>'photo-1586953208270-e1a85ab5d9d6','name'=>'Wacom Cintiq 16 Drawing Tablet Full HD','price'=>'KSh 23,673','old'=>'KSh 28,900','badge'=>'-18%','stock'=>'43 left','stars'=>4,'rc'=>167],
            ['img'=>'photo-1625805866449-3589fe3f71a3','name'=>'Razer Wolverine V2 Chroma Controller','price'=>'KSh 8,326','old'=>'KSh 11,600','badge'=>'-28%','stock'=>'18 left','stars'=>4,'rc'=>156],
            ['img'=>'photo-1527814050087-3793815479db','name'=>'Logitech G502 Lightspeed Wireless Mouse','price'=>'KSh 1,726','old'=>'KSh 2,400','badge'=>'-28%','stock'=>'30 left','stars'=>4,'rc'=>289],
        ];
        @endphp
        @foreach($flashProducts as $p)
        <div class="p-card">
            <span class="p-badge">{{ $p['badge'] }}</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap">
                <img class="p-img" src="https://images.unsplash.com/{{ $p['img'] }}?w=300&h=220&fit=crop" alt="{{ $p['name'] }}" loading="lazy">
            </div>
            <div class="p-body">
                <p class="p-name">{{ $p['name'] }}</p>
                <p class="p-price">{{ $p['price'] }}</p>
                <p class="p-old">{{ $p['old'] }}</p>
                <div class="p-meta">
                    <p class="p-stock"><i class="fas fa-fire-flame-curved" style="font-size:9px"></i> {{ $p['stock'] }}</p>
                    <span class="p-stars">{{ str_repeat('★',$p['stars']) }}{{ str_repeat('☆',5-$p['stars']) }}</span>
                    <span class="p-rc">({{ $p['rc'] }})</span>
                </div>
                <button class="p-atc" onclick="addToCart(this)">
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ══ HOT CATEGORIES ══ --}}
    <div class="sec-head">
        <h2>Hot Categories</h2>
    </div>
    <div class="hot-wrap" style="margin-bottom:24px">
        <div class="hot-track">
            @php
            $hotCats = [
                ['img'=>'photo-1490481651871-ab68de25d43d','label'=>'Fashion'],
                ['img'=>'photo-1505740420928-5e560c06d30e','label'=>'Audio'],
                ['img'=>'photo-1511707171634-5f897ff02aa9','label'=>'Electronics'],
                ['img'=>'photo-1596462502278-27bfdc403348','label'=>'Beauty'],
                ['img'=>'photo-1556909114-44e3e70034e2','label'=>'Home'],
                ['img'=>'photo-1578328819058-b69f3a3b0f6b','label'=>'Kitchen'],
                ['img'=>'photo-1506905925346-21bda4d32df4','label'=>'Outdoor'],
                ['img'=>'photo-1554260570-9140fd3b7614','label'=>'Sports'],
            ];
            @endphp
            @foreach(array_merge($hotCats, $hotCats) as $hc)
            <a href="#" class="hot-item">
                <div class="hot-img">
                    <img src="https://images.unsplash.com/{{ $hc['img'] }}?w=150&h=150&fit=crop" alt="{{ $hc['label'] }}" loading="lazy">
                </div>
                <p>{{ $hc['label'] }}</p>
            </a>
            @endforeach
        </div>
    </div>

    {{-- ══ NEW ARRIVALS — Normal Grid (carousel removed) ══ --}}
    <div class="sec-head">
        <h2>New Arrivals</h2>
        <a href="#" class="see-all">SEE ALL <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="prod-grid">
        @php
        $newArrivals = [
            ['img'=>'photo-1625805866449-3589fe3f71a3','name'=>'Razer Wolverine V2 Chroma Gaming Controller','price'=>'KSh 8,326','old'=>'KSh 11,600','badge'=>'-28%','stars'=>4,'rc'=>156],
            ['img'=>'photo-1527814050087-3793815479db','name'=>'Logitech G502 Lightspeed Wireless Gaming Mouse','price'=>'KSh 1,726','old'=>'KSh 2,400','badge'=>'-28%','stars'=>4,'rc'=>289],
            ['img'=>'photo-1587831990711-23ca6441447b','name'=>'Lenovo V30a Business All-in-One Desktop','price'=>'KSh 45,426','old'=>'KSh 63,100','badge'=>'-28%','stars'=>3,'rc'=>74],
            ['img'=>'photo-1593640408182-31c70c8268f5','name'=>'Wacom Intuos Pro Medium Drawing Tablet','price'=>'KSh 24,260','old'=>'KSh 33,700','badge'=>'-28%','stars'=>4,'rc'=>198],
            ['img'=>'photo-1625805866449-3589fe3f71a3','name'=>'Anker USB-C Hub Adapter 7-in-1','price'=>'KSh 1,626','old'=>'KSh 2,260','badge'=>'-28%','stars'=>5,'rc'=>412],
            ['img'=>'photo-1587829741301-dc798b83add3','name'=>'SteelSeries Apex 3 RGB Gaming Keyboard','price'=>'KSh 2,426','old'=>'KSh 3,370','badge'=>'-28%','stars'=>4,'rc'=>267],
            ['img'=>'photo-1586953208270-e1a85ab5d9d6','name'=>'Wacom Cintiq 16 Drawing Tablet Full HD','price'=>'KSh 23,673','old'=>'KSh 28,900','badge'=>'-18%','stars'=>4,'rc'=>167],
            ['img'=>'photo-1615663245857-ac93bb7c39e7','name'=>'SteelSeries QcK XXL Gaming Mouse Pad','price'=>'KSh 1,299','old'=>'KSh 1,800','badge'=>'-28%','stars'=>5,'rc'=>398],
        ];
        @endphp
        @foreach($newArrivals as $p)
        <div class="p-card">
            <span class="p-badge">{{ $p['badge'] }}</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap">
                <img class="p-img" src="https://images.unsplash.com/{{ $p['img'] }}?w=300&h=220&fit=crop" alt="{{ $p['name'] }}" loading="lazy">
            </div>
            <div class="p-body">
                <p class="p-name">{{ $p['name'] }}</p>
                <p class="p-price">{{ $p['price'] }}</p>
                <p class="p-old">{{ $p['old'] }}</p>
                <div class="p-meta">
                    <span class="p-stars">{{ str_repeat('★',$p['stars']) }}{{ str_repeat('☆',5-$p['stars']) }}</span>
                    <span class="p-rc">({{ $p['rc'] }})</span>
                </div>
                <button class="p-atc" onclick="addToCart(this)">
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ══ BEST SELLERS ══ --}}
    <div class="sec-head" style="margin-top:6px">
        <h2>Best Sellers</h2>
        <a href="#" class="see-all">SEE ALL <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="prod-grid">
        @php
        $bestSellers = [
            ['img'=>'photo-1511707171634-5f897ff02aa9','name'=>'Samsung Galaxy A55 5G Smartphone 128GB','price'=>'KSh 32,500','old'=>'KSh 40,000','badge'=>'-19%','stars'=>5,'rc'=>612],
            ['img'=>'photo-1572635196237-14b3f281503f','name'=>'Ray-Ban Aviator Classic Polarized Sunglasses','price'=>'KSh 8,900','old'=>'KSh 12,000','badge'=>'-26%','stars'=>4,'rc'=>341],
            ['img'=>'photo-1596462502278-27bfdc403348','name'=>'MAC Cosmetics Lipstick Retro Matte Collection','price'=>'KSh 3,200','old'=>'KSh 4,500','badge'=>'-29%','stars'=>4,'rc'=>789],
            ['img'=>'photo-1490481651871-ab68de25d43d','name'=>"Zara Women's Floral Midi Dress Summer Edition",'price'=>'KSh 5,600','old'=>'KSh 7,800','badge'=>'-28%','stars'=>4,'rc'=>213],
            ['img'=>'photo-1556909114-44e3e70034e2','name'=>'IKEA KALLAX Shelf Unit Storage Organizer','price'=>'KSh 9,800','old'=>'KSh 13,500','badge'=>'-27%','stars'=>5,'rc'=>456],
            ['img'=>'photo-1585255318859-f5c15f4cffe9','name'=>'Casio G-Shock GA-100 Military Watch','price'=>'KSh 11,200','old'=>'KSh 15,000','badge'=>'-25%','stars'=>5,'rc'=>893],
        ];
        @endphp
        @foreach($bestSellers as $p)
        <div class="p-card">
            <span class="p-badge">{{ $p['badge'] }}</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap">
                <img class="p-img" src="https://images.unsplash.com/{{ $p['img'] }}?w=300&h=220&fit=crop" alt="{{ $p['name'] }}" loading="lazy">
            </div>
            <div class="p-body">
                <p class="p-name">{{ $p['name'] }}</p>
                <p class="p-price">{{ $p['price'] }}</p>
                <p class="p-old">{{ $p['old'] }}</p>
                <div class="p-meta">
                    <span class="p-stars">{{ str_repeat('★',$p['stars']) }}{{ str_repeat('☆',5-$p['stars']) }}</span>
                    <span class="p-rc">({{ $p['rc'] }})</span>
                </div>
                <button class="p-atc" onclick="addToCart(this)">
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
            </div>
        </div>
        @endforeach
    </div>

</div>{{-- /.content-area-inner --}}

<script>
/* ─── HERO SLIDER ─── */
(function(){
    let cur = 0, total = 4, timer;
    const wrap = document.getElementById('heroWrap');
    const dots = document.querySelectorAll('#heroDots .sl-dot');

    function setSlide(n){
        cur = (n + total) % total;
        wrap.style.transform = 'translateX(-' + (cur * 100) + '%)';
        dots.forEach((d,i) => d.classList.toggle('active', i === cur));
    }
    window.heroSlide = d => { setSlide(cur + d); resetTimer(); };
    window.heroGoTo  = n => { setSlide(n); resetTimer(); };
    function resetTimer(){ clearInterval(timer); timer = setInterval(() => setSlide(cur + 1), 4800); }
    resetTimer();
})();

/* ─── FLASH COUNTDOWN ─── */
(function(){
    const el = document.getElementById('flashTimer');
    if (!el) return;
    let secs = 2 * 3600 + 26 * 60 + 17;
    setInterval(function(){
        if (secs <= 0){ el.textContent = 'Sale Ended!'; return; }
        secs--;
        const h = String(Math.floor(secs / 3600)).padStart(2,'0');
        const m = String(Math.floor((secs % 3600) / 60)).padStart(2,'0');
        const s = String(secs % 60).padStart(2,'0');
        el.textContent = 'Ends in: ' + h + 'h : ' + m + 'm : ' + s + 's';
    }, 1000);
})();

/* ─── ADD TO CART ─── */
window.addToCart = function(btn){
    const orig = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-check"></i> Added!';
    btn.style.background = '#16a34a';
    setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; }, 1400);

    const badge = document.getElementById('cartBadge');
    if (badge){
        badge.textContent = (parseInt(badge.textContent) || 0) + 1;
        badge.style.animation = 'none';
        requestAnimationFrame(() => badge.style.animation = '');
    }
    if (typeof toastr !== 'undefined')
        toastr.success('Item added to cart!', '', { timeOut: 1800, progressBar: true });
};
</script>

@endsection
