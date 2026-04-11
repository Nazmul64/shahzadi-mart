{{-- resources/views/frontend/index.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700;800&display=swap');

.ci, .ci * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; }
.ci h1, .ci h2, .ci .df { font-family: 'Playfair Display', serif; }

/* ═══ HERO ═══ */
.hero {
    display: grid;
    grid-template-columns: 1fr 220px;
    gap: 16px;
    margin-bottom: 24px;
}

/* ── Slider ── */
.hero-slider {
    position: relative;
    border-radius: var(--rl);
    overflow: hidden;
    min-height: 300px;
    box-shadow: var(--sh2);
    border: 1px solid var(--border);
    background: #111;
}
.slides-wrap {
    display: flex;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
    height: 100%;
}
.slide {
    min-width: 100%;
    height: 300px;
    position: relative;
    overflow: hidden;
}
.slide img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}

.sl-arrow {
    position: absolute; top: 50%; transform: translateY(-50%);
    background: rgba(255,255,255,.85); border: none;
    width: 38px; height: 38px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 13px; color: var(--text);
    box-shadow: var(--sh2); transition: var(--t); z-index: 10; outline: none;
}
.sl-arrow:hover { background: var(--red); color: #fff; }
.sl-prev { left: 14px; }
.sl-next { right: 14px; }
.sl-dots {
    position: absolute; bottom: 14px; left: 50%; transform: translateX(-50%);
    display: flex; gap: 6px; z-index: 10;
}
.sl-dot {
    width: 8px; height: 8px; border-radius: 4px;
    background: rgba(255,255,255,.5); cursor: pointer;
    transition: var(--t); border: none; padding: 0;
}
.sl-dot.active { background: #fff; width: 24px; }

/* ── Hero Right Panel ── */
.hero-panel { display: flex; flex-direction: column; gap: 12px; }

.welcome-card {
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); padding: 20px 14px 16px;
    text-align: center; box-shadow: var(--sh1);
}
.welcome-card__label {
    font-size: 11px; font-weight: 700; letter-spacing: .14em;
    text-transform: uppercase; color: var(--muted); margin-bottom: 14px;
}
.auth-btns { display: flex; gap: 8px; }
.btn-reg {
    flex: 1; background: var(--light); color: var(--text);
    border: 1.5px solid var(--border); padding: 10px 4px; border-radius: 26px;
    font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 700;
    cursor: pointer; transition: var(--t);
}
.btn-reg:hover { border-color: var(--red); color: var(--red); }
.btn-sign {
    flex: 1; background: var(--red); color: #fff;
    border: none; padding: 10px 4px; border-radius: 26px;
    font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 700;
    cursor: pointer; transition: var(--t);
}
.btn-sign:hover { background: var(--red-d); }

.clearance-card {
    flex: 1; background: linear-gradient(145deg, var(--red) 0%, #8b0000 100%);
    color: #fff; border-radius: var(--rm);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif;
    font-size: 23px; font-weight: 900;
    line-height: 1.05; text-align: center;
    padding: 20px 10px; min-height: 100px;
    box-shadow: var(--sh-red); cursor: pointer;
    transition: var(--t); text-decoration: none;
    position: relative; overflow: hidden;
}
.clearance-card::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(circle at 80% 20%, rgba(255,255,255,.13), transparent 55%);
}
.clearance-card small {
    font-family: 'DM Sans', sans-serif;
    font-size: 9px; font-weight: 800; letter-spacing: .2em;
    text-transform: uppercase; opacity: .88; margin-top: 6px; display: block;
}
.clearance-card:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(200,16,46,.45); }

/* ── Mobile strip ── */
.hero-mobile-strip { display: none; gap: 10px; margin-bottom: 18px; }
.hero-mobile-strip .welcome-card { flex: 1; }
.hero-mobile-strip .clearance-card { flex: 0 0 130px; min-height: 76px; font-size: 17px; }

/* ═══ CATEGORY CIRCLES ═══ */
.circles-box {
    margin-bottom: 24px; overflow: hidden;
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); padding: 18px; box-shadow: var(--sh1);
}
.circles-track {
    display: flex; gap: 18px; width: max-content;
    animation: idx-marquee 34s linear infinite;
}
.circles-track:hover { animation-play-state: paused; }
@keyframes idx-marquee { to { transform: translateX(-50%); } }

.circle-item {
    display: flex; flex-direction: column; align-items: center;
    gap: 8px; cursor: pointer; flex-shrink: 0; text-decoration: none;
}
.circle-img {
    width: 72px; height: 72px; border-radius: 50%; overflow: hidden;
    border: 2.5px solid var(--border); transition: var(--t);
}
.circle-img img { width: 100%; height: 100%; object-fit: cover; }
.circle-item:hover .circle-img { border-color: var(--red); transform: scale(1.1); box-shadow: 0 6px 16px rgba(200,16,46,.22); }
.circle-item p { font-size: 12.5px; font-weight: 700; color: var(--mid); text-align: center; white-space: nowrap; }
.circle-item:hover p { color: var(--red); }

/* ═══ SECTION HEADER ═══ */
.sec-head { display: flex; align-items: center; justify-content: space-between; margin: 28px 0 14px; }
.sec-head h2 {
    font-family: 'Playfair Display', serif;
    font-size: 24px; font-weight: 800; color: var(--dark);
    display: flex; align-items: center; gap: 11px;
}
.sec-head h2::before {
    content: ''; width: 5px; height: 24px;
    background: var(--red); border-radius: 3px; flex-shrink: 0;
}
.see-all {
    font-family: 'DM Sans', sans-serif;
    font-size: 12.5px; font-weight: 700; color: var(--red);
    letter-spacing: .07em; text-transform: uppercase;
    display: flex; align-items: center; gap: 5px; transition: gap .2s;
}
.see-all:hover { gap: 9px; }

/* ═══ FLASH SALE BAR ═══ */
.flash-hd {
    display: flex; align-items: center; gap: 14px;
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); padding: 14px 20px;
    margin-bottom: 12px; box-shadow: var(--sh1); flex-wrap: wrap;
}
.flash-title {
    font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 800;
    color: var(--dark); display: flex; align-items: center; gap: 8px; flex: 1; min-width: 130px;
}
.flash-title i { color: var(--red); animation: flash-pulse 1.4s ease-in-out infinite; }
@keyframes flash-pulse { 0%,100%{opacity:1} 50%{opacity:.3} }
.flash-timer {
    background: var(--dark); color: var(--white);
    padding: 7px 16px; border-radius: 22px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 800; letter-spacing: .04em; white-space: nowrap;
}

/* ═══ HOT CATEGORIES ═══ */
.hot-wrap {
    overflow: hidden; background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); padding: 16px; box-shadow: var(--sh1); margin-bottom: 10px;
}
.hot-track {
    display: flex; gap: 14px; width: max-content;
    animation: idx-marquee 28s linear infinite;
}
.hot-track:hover { animation-play-state: paused; }
.hot-item {
    display: flex; flex-direction: column; align-items: center; gap: 8px;
    cursor: pointer; padding: 14px 10px;
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); transition: var(--t);
    flex-shrink: 0; width: 100px; text-decoration: none;
}
.hot-item:hover { border-color: var(--red); box-shadow: var(--sh2); transform: translateY(-3px); }
.hot-img { width: 58px; height: 58px; border-radius: 50%; overflow: hidden; }
.hot-img img { width: 100%; height: 100%; object-fit: cover; }
.hot-item p { font-size: 12px; font-weight: 700; color: var(--mid); text-align: center; line-height: 1.3; }
.hot-item:hover p { color: var(--red); }

/* ═══ PRODUCT GRID ═══ */
.prod-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
    gap: 16px; margin-bottom: 32px;
}

/* ═══ PRODUCT CARD ═══ */
.p-card {
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); overflow: hidden; position: relative;
    transition: var(--t); cursor: pointer; display: flex; flex-direction: column;
}
.p-card:hover { box-shadow: var(--sh3); transform: translateY(-5px); border-color: var(--border-d); }
.p-badge {
    position: absolute; top: 10px; left: 10px;
    background: var(--red); color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: 10px; font-weight: 800; padding: 4px 9px;
    border-radius: 5px; letter-spacing: .04em; z-index: 2;
}
.p-wish {
    position: absolute; top: 9px; right: 9px;
    width: 32px; height: 32px; background: var(--white);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 13px; color: var(--muted); box-shadow: var(--sh1); z-index: 2;
    transition: var(--t); opacity: 0; border: none; cursor: pointer;
}
.p-card:hover .p-wish { opacity: 1; }
.p-wish:hover { color: var(--red); transform: scale(1.15); }
.p-img-wrap { position: relative; overflow: hidden; }
.p-img {
    width: 100%; height: 165px; object-fit: cover;
    border-bottom: 1px solid var(--border);
    transition: transform .35s cubic-bezier(.4,0,.2,1); display: block;
}
.p-card:hover .p-img { transform: scale(1.06); }
.p-body { padding: 12px 13px 13px; display: flex; flex-direction: column; flex: 1; }
.p-name {
    font-size: 13.5px; font-weight: 600; color: var(--text);
    line-height: 1.48; margin-bottom: 8px;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.p-price { font-size: 16px; font-weight: 900; color: var(--red); margin-bottom: 2px; }
.p-old { font-size: 12px; color: var(--muted); text-decoration: line-through; margin-bottom: 5px; }
.p-stock { font-size: 11.5px; font-weight: 700; color: #d97706; margin-bottom: 5px; }
.p-stars { color: #f59e0b; font-size: 12.5px; }
.p-rc { color: var(--muted); font-size: 11.5px; margin-left: 3px; }
.p-meta { margin-bottom: 10px; }
.p-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 11px 0;
    background: var(--red); color: #fff;
    border: none; border-radius: var(--r);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 700; letter-spacing: .02em;
    cursor: pointer; transition: var(--t); margin-top: auto;
}
.p-atc:hover { background: var(--red-d); transform: translateY(-1px); box-shadow: 0 5px 14px rgba(200,16,46,.35); }
.p-atc:active { transform: scale(.97); }
.p-atc i { font-size: 12px; }

/* ═══ RESPONSIVE ═══ */
@media (max-width: 900px) {
    .hero { grid-template-columns: 1fr; }
    .hero-panel { display: none; }
    .hero-mobile-strip { display: flex; }
    .prod-grid { grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 13px; }
}
@media (max-width: 640px) {
    .slide { height: 230px; }
    .hero-slider { min-height: 230px; }
    .hero-mobile-strip .clearance-card { flex: 0 0 110px; font-size: 15px; }
    .sec-head h2 { font-size: 20px; }
    .prod-grid { grid-template-columns: repeat(2, 1fr); gap: 11px; }
    .p-img { height: 140px; }
    .flash-hd { padding: 11px 16px; gap: 9px; }
    .flash-title { font-size: 18px; }
    .flash-timer { font-size: 12px; padding: 6px 12px; }
}
@media (max-width: 420px) {
    .slide { height: 195px; }
    .hero-slider { min-height: 195px; }
    .hero-mobile-strip .clearance-card { flex: 0 0 96px; font-size: 14px; }
    .prod-grid { gap: 9px; }
    .p-name { font-size: 12.5px; }
    .p-price { font-size: 15px; }
    .p-img { height: 130px; }
    .circle-img { width: 63px; height: 63px; }
    .circle-item p { font-size: 11.5px; }
    .sec-head h2 { font-size: 18px; }
}
@media (max-width: 360px) {
    .hero-mobile-strip { flex-direction: column; }
    .hero-mobile-strip .clearance-card { flex: none; min-height: 64px; flex-direction: row; gap: 8px; font-size: 15px; }
    .prod-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<div class="ci content-area-inner">

    {{-- ══ HERO ══ --}}
    <div class="hero">

        {{-- Slider --}}
        <div class="hero-slider" id="heroSlider">
            <div class="slides-wrap" id="heroWrap">

                <div class="slide">
                    <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=900&h=400&fit=crop" alt="Gadgets">
                </div>

                <div class="slide">
                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=900&h=400&fit=crop" alt="Headphones">
                </div>

                <div class="slide">
                    <img src="https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=900&h=400&fit=crop" alt="Baby">
                </div>

                <div class="slide">
                    <img src="https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=900&h=400&fit=crop" alt="Speakers">
                </div>

            </div>

            <button class="sl-arrow sl-prev" id="slPrev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
            <button class="sl-arrow sl-next" id="slNext" aria-label="Next"><i class="fas fa-chevron-right"></i></button>

            <div class="sl-dots" id="heroDots">
                <button class="sl-dot active" data-i="0"></button>
                <button class="sl-dot" data-i="1"></button>
                <button class="sl-dot" data-i="2"></button>
                <button class="sl-dot" data-i="3"></button>
            </div>
        </div>

        {{-- Right Panel — desktop only --}}
        <div class="hero-panel">
            <div class="welcome-card">
                <p class="welcome-card__label">Welcome Back</p>
                <div class="auth-btns">
                    <button class="btn-reg" onclick="location.href='{{ url('customer/register') }}'">Register</button>
                    <button class="btn-sign" onclick="location.href='{{ url('customer/login') }}'">Sign In</button>
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
                <button class="btn-reg" onclick="location.href='{{ url('customer/register') }}'">Register</button>
                <button class="btn-sign" onclick="location.href='{{ url('customer/login') }}'">Sign In</button>
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
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=150&h=150&fit=crop" alt="Sunglasses" loading="lazy"></div><p>Sunglasses</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1593640495253-23196b27a87f?w=150&h=150&fit=crop" alt="Flash Sales" loading="lazy"></div><p>Flash Sales</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=150&h=150&fit=crop" alt="Phones" loading="lazy"></div><p>Phones</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=150&h=150&fit=crop" alt="Laptops" loading="lazy"></div><p>Laptops</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=150&h=150&fit=crop" alt="Speakers" loading="lazy"></div><p>Speakers</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=150&h=150&fit=crop" alt="Keyboards" loading="lazy"></div><p>Keyboards</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1585255318859-f5c15f4cffe9?w=150&h=150&fit=crop" alt="Watches" loading="lazy"></div><p>Watches</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=150&h=150&fit=crop" alt="Fashion" loading="lazy"></div><p>Fashion</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=150&h=150&fit=crop" alt="Beauty" loading="lazy"></div><p>Beauty</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1556909114-44e3e70034e2?w=150&h=150&fit=crop" alt="Home" loading="lazy"></div><p>Home</p></a>
            {{-- Duplicate for seamless marquee --}}
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=150&h=150&fit=crop" alt="Sunglasses" loading="lazy"></div><p>Sunglasses</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1593640495253-23196b27a87f?w=150&h=150&fit=crop" alt="Flash Sales" loading="lazy"></div><p>Flash Sales</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=150&h=150&fit=crop" alt="Phones" loading="lazy"></div><p>Phones</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=150&h=150&fit=crop" alt="Laptops" loading="lazy"></div><p>Laptops</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=150&h=150&fit=crop" alt="Speakers" loading="lazy"></div><p>Speakers</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=150&h=150&fit=crop" alt="Keyboards" loading="lazy"></div><p>Keyboards</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1585255318859-f5c15f4cffe9?w=150&h=150&fit=crop" alt="Watches" loading="lazy"></div><p>Watches</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=150&h=150&fit=crop" alt="Fashion" loading="lazy"></div><p>Fashion</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=150&h=150&fit=crop" alt="Beauty" loading="lazy"></div><p>Beauty</p></a>
            <a href="#" class="circle-item"><div class="circle-img"><img src="https://images.unsplash.com/photo-1556909114-44e3e70034e2?w=150&h=150&fit=crop" alt="Home" loading="lazy"></div><p>Home</p></a>
        </div>
    </div>

    {{-- ══ FLASH SALES ══ --}}
    <div class="flash-hd">
        <div class="flash-title"><i class="fas fa-bolt"></i> Flash Sales</div>
        <div class="flash-timer" id="flashTimer">Ends in: 02h : 26m : 17s</div>
        <a href="#" class="see-all">SEE ALL <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="prod-grid">

        <div class="p-card">
            <span class="p-badge">-18%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?w=300&h=220&fit=crop" alt="Lenovo V30a" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Lenovo V30a Business All-in-One Desktop</p>
                <p class="p-price">KSh 44,326</p>
                <p class="p-old">KSh 54,900</p>
                <div class="p-meta">
                    <p class="p-stock"><i class="fas fa-fire-flame-curved" style="font-size:10px"></i> 13 left</p>
                    <span class="p-stars">★★★☆☆</span><span class="p-rc">(74)</span>
                </div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-18%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=300&h=220&fit=crop" alt="Acer Chromebook" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Acer Chromebook Spin 314 Convertible Laptop</p>
                <p class="p-price">KSh 34,260</p>
                <p class="p-old">KSh 41,800</p>
                <div class="p-meta">
                    <p class="p-stock"><i class="fas fa-fire-flame-curved" style="font-size:10px"></i> 22 left</p>
                    <span class="p-stars">★★★☆☆</span><span class="p-rc">(56)</span>
                </div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-17%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1527814050087-3793815479db?w=300&h=220&fit=crop" alt="Razer Naga" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Razer Naga Pro Wireless Gaming Mouse</p>
                <p class="p-price">KSh 999</p>
                <p class="p-old">KSh 1,200</p>
                <div class="p-meta">
                    <p class="p-stock"><i class="fas fa-fire-flame-curved" style="font-size:10px"></i> 11 left</p>
                    <span class="p-stars">★★★★☆</span><span class="p-rc">(132)</span>
                </div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-18%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=300&h=220&fit=crop" alt="Redragon Keyboard" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Redragon S101 RGB Backlit Gaming Keyboard</p>
                <p class="p-price">KSh 4,260</p>
                <p class="p-old">KSh 5,200</p>
                <div class="p-meta">
                    <p class="p-stock"><i class="fas fa-fire-flame-curved" style="font-size:10px"></i> 6 left</p>
                    <span class="p-stars">★★★★☆</span><span class="p-rc">(89)</span>
                </div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-17%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=300&h=220&fit=crop" alt="SteelSeries QcK" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">SteelSeries QcK Gaming Mouse Pad</p>
                <p class="p-price">KSh 999</p>
                <p class="p-old">KSh 1,200</p>
                <div class="p-meta">
                    <p class="p-stock"><i class="fas fa-fire-flame-curved" style="font-size:10px"></i> 3 left</p>
                    <span class="p-stars">★★★★☆</span><span class="p-rc">(245)</span>
                </div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-18%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1586953208270-e1a85ab5d9d6?w=300&h=220&fit=crop" alt="Wacom Cintiq" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Wacom Cintiq 16 Drawing Tablet Full HD</p>
                <p class="p-price">KSh 23,673</p>
                <p class="p-old">KSh 28,900</p>
                <div class="p-meta">
                    <p class="p-stock"><i class="fas fa-fire-flame-curved" style="font-size:10px"></i> 43 left</p>
                    <span class="p-stars">★★★★☆</span><span class="p-rc">(167)</span>
                </div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-28%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1625805866449-3589fe3f71a3?w=300&h=220&fit=crop" alt="Razer Wolverine" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Razer Wolverine V2 Chroma Controller</p>
                <p class="p-price">KSh 8,326</p>
                <p class="p-old">KSh 11,600</p>
                <div class="p-meta">
                    <p class="p-stock"><i class="fas fa-fire-flame-curved" style="font-size:10px"></i> 18 left</p>
                    <span class="p-stars">★★★★☆</span><span class="p-rc">(156)</span>
                </div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-28%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1527814050087-3793815479db?w=300&h=220&fit=crop" alt="Logitech G502" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Logitech G502 Lightspeed Wireless Mouse</p>
                <p class="p-price">KSh 1,726</p>
                <p class="p-old">KSh 2,400</p>
                <div class="p-meta">
                    <p class="p-stock"><i class="fas fa-fire-flame-curved" style="font-size:10px"></i> 30 left</p>
                    <span class="p-stars">★★★★☆</span><span class="p-rc">(289)</span>
                </div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

    </div>

    {{-- ══ HOT CATEGORIES ══ --}}
    <div class="sec-head">
        <h2>Hot Categories</h2>
    </div>
    <div class="hot-wrap" style="margin-bottom:28px">
        <div class="hot-track">
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=150&h=150&fit=crop" alt="Fashion" loading="lazy"></div><p>Fashion</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=150&h=150&fit=crop" alt="Audio" loading="lazy"></div><p>Audio</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=150&h=150&fit=crop" alt="Electronics" loading="lazy"></div><p>Electronics</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=150&h=150&fit=crop" alt="Beauty" loading="lazy"></div><p>Beauty</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1556909114-44e3e70034e2?w=150&h=150&fit=crop" alt="Home" loading="lazy"></div><p>Home</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?w=150&h=150&fit=crop" alt="Kitchen" loading="lazy"></div><p>Kitchen</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=150&h=150&fit=crop" alt="Outdoor" loading="lazy"></div><p>Outdoor</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1554260570-9140fd3b7614?w=150&h=150&fit=crop" alt="Sports" loading="lazy"></div><p>Sports</p></a>
            {{-- Duplicate for seamless marquee --}}
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=150&h=150&fit=crop" alt="Fashion" loading="lazy"></div><p>Fashion</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=150&h=150&fit=crop" alt="Audio" loading="lazy"></div><p>Audio</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=150&h=150&fit=crop" alt="Electronics" loading="lazy"></div><p>Electronics</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=150&h=150&fit=crop" alt="Beauty" loading="lazy"></div><p>Beauty</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1556909114-44e3e70034e2?w=150&h=150&fit=crop" alt="Home" loading="lazy"></div><p>Home</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?w=150&h=150&fit=crop" alt="Kitchen" loading="lazy"></div><p>Kitchen</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=150&h=150&fit=crop" alt="Outdoor" loading="lazy"></div><p>Outdoor</p></a>
            <a href="#" class="hot-item"><div class="hot-img"><img src="https://images.unsplash.com/photo-1554260570-9140fd3b7614?w=150&h=150&fit=crop" alt="Sports" loading="lazy"></div><p>Sports</p></a>
        </div>
    </div>

    {{-- ══ NEW ARRIVALS ══ --}}
    <div class="sec-head">
        <h2>New Arrivals</h2>
        <a href="#" class="see-all">SEE ALL <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="prod-grid">

        <div class="p-card">
            <span class="p-badge">-28%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1625805866449-3589fe3f71a3?w=300&h=220&fit=crop" alt="Razer Wolverine" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Razer Wolverine V2 Chroma Gaming Controller</p>
                <p class="p-price">KSh 8,326</p>
                <p class="p-old">KSh 11,600</p>
                <div class="p-meta"><span class="p-stars">★★★★☆</span><span class="p-rc">(156)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-28%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1527814050087-3793815479db?w=300&h=220&fit=crop" alt="Logitech G502" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Logitech G502 Lightspeed Wireless Gaming Mouse</p>
                <p class="p-price">KSh 1,726</p>
                <p class="p-old">KSh 2,400</p>
                <div class="p-meta"><span class="p-stars">★★★★☆</span><span class="p-rc">(289)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-28%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?w=300&h=220&fit=crop" alt="Lenovo V30a" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Lenovo V30a Business All-in-One Desktop</p>
                <p class="p-price">KSh 45,426</p>
                <p class="p-old">KSh 63,100</p>
                <div class="p-meta"><span class="p-stars">★★★☆☆</span><span class="p-rc">(74)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-28%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=300&h=220&fit=crop" alt="Wacom Intuos" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Wacom Intuos Pro Medium Drawing Tablet</p>
                <p class="p-price">KSh 24,260</p>
                <p class="p-old">KSh 33,700</p>
                <div class="p-meta"><span class="p-stars">★★★★☆</span><span class="p-rc">(198)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-28%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1625805866449-3589fe3f71a3?w=300&h=220&fit=crop" alt="Anker USB-C Hub" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Anker USB-C Hub Adapter 7-in-1</p>
                <p class="p-price">KSh 1,626</p>
                <p class="p-old">KSh 2,260</p>
                <div class="p-meta"><span class="p-stars">★★★★★</span><span class="p-rc">(412)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-28%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=300&h=220&fit=crop" alt="SteelSeries Apex" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">SteelSeries Apex 3 RGB Gaming Keyboard</p>
                <p class="p-price">KSh 2,426</p>
                <p class="p-old">KSh 3,370</p>
                <div class="p-meta"><span class="p-stars">★★★★☆</span><span class="p-rc">(267)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-18%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1586953208270-e1a85ab5d9d6?w=300&h=220&fit=crop" alt="Wacom Cintiq" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Wacom Cintiq 16 Drawing Tablet Full HD</p>
                <p class="p-price">KSh 23,673</p>
                <p class="p-old">KSh 28,900</p>
                <div class="p-meta"><span class="p-stars">★★★★☆</span><span class="p-rc">(167)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-28%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=300&h=220&fit=crop" alt="SteelSeries QcK" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">SteelSeries QcK XXL Gaming Mouse Pad</p>
                <p class="p-price">KSh 1,299</p>
                <p class="p-old">KSh 1,800</p>
                <div class="p-meta"><span class="p-stars">★★★★★</span><span class="p-rc">(398)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

    </div>

    {{-- ══ BEST SELLERS ══ --}}
    <div class="sec-head" style="margin-top:6px">
        <h2>Best Sellers</h2>
        <a href="#" class="see-all">SEE ALL <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="prod-grid">

        <div class="p-card">
            <span class="p-badge">-19%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=300&h=220&fit=crop" alt="Samsung Galaxy" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Samsung Galaxy A55 5G Smartphone 128GB</p>
                <p class="p-price">KSh 32,500</p>
                <p class="p-old">KSh 40,000</p>
                <div class="p-meta"><span class="p-stars">★★★★★</span><span class="p-rc">(612)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-26%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=300&h=220&fit=crop" alt="Ray-Ban" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Ray-Ban Aviator Classic Polarized Sunglasses</p>
                <p class="p-price">KSh 8,900</p>
                <p class="p-old">KSh 12,000</p>
                <div class="p-meta"><span class="p-stars">★★★★☆</span><span class="p-rc">(341)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-29%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=300&h=220&fit=crop" alt="MAC Cosmetics" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">MAC Cosmetics Lipstick Retro Matte Collection</p>
                <p class="p-price">KSh 3,200</p>
                <p class="p-old">KSh 4,500</p>
                <div class="p-meta"><span class="p-stars">★★★★☆</span><span class="p-rc">(789)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-28%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=300&h=220&fit=crop" alt="Zara Dress" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Zara Women's Floral Midi Dress Summer Edition</p>
                <p class="p-price">KSh 5,600</p>
                <p class="p-old">KSh 7,800</p>
                <div class="p-meta"><span class="p-stars">★★★★☆</span><span class="p-rc">(213)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-27%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1556909114-44e3e70034e2?w=300&h=220&fit=crop" alt="IKEA KALLAX" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">IKEA KALLAX Shelf Unit Storage Organizer</p>
                <p class="p-price">KSh 9,800</p>
                <p class="p-old">KSh 13,500</p>
                <div class="p-meta"><span class="p-stars">★★★★★</span><span class="p-rc">(456)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

        <div class="p-card">
            <span class="p-badge">-25%</span>
            <button class="p-wish"><i class="fas fa-heart"></i></button>
            <div class="p-img-wrap"><img class="p-img" src="https://images.unsplash.com/photo-1585255318859-f5c15f4cffe9?w=300&h=220&fit=crop" alt="Casio G-Shock" loading="lazy"></div>
            <div class="p-body">
                <p class="p-name">Casio G-Shock GA-100 Military Watch</p>
                <p class="p-price">KSh 11,200</p>
                <p class="p-old">KSh 15,000</p>
                <div class="p-meta"><span class="p-stars">★★★★★</span><span class="p-rc">(893)</span></div>
                <button class="p-atc"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </div>
        </div>

    </div>

</div>{{-- /.ci --}}

<script>
/* HERO SLIDER */
(function(){
    var cur=0, total=4, wrap=document.getElementById('heroWrap'), dots=document.querySelectorAll('#heroDots .sl-dot'), timer;
    function go(n){ cur=(n+total)%total; wrap.style.transform='translateX(-'+(cur*100)+'%)'; dots.forEach(function(d){d.classList.toggle('active',+d.dataset.i===cur);}); }
    document.getElementById('slPrev').onclick=function(){go(cur-1);reset();};
    document.getElementById('slNext').onclick=function(){go(cur+1);reset();};
    dots.forEach(function(d){d.onclick=function(){go(+d.dataset.i);reset();};});
    function reset(){clearInterval(timer);timer=setInterval(function(){go(cur+1);},4800);}
    reset();
})();

/* FLASH COUNTDOWN */
(function(){
    var el=document.getElementById('flashTimer'), secs=2*3600+26*60+17;
    setInterval(function(){
        if(secs<=0){el.textContent='Sale Ended!';return;}secs--;
        el.textContent='Ends in: '+String(Math.floor(secs/3600)).padStart(2,'0')+'h : '+String(Math.floor((secs%3600)/60)).padStart(2,'0')+'m : '+String(secs%60).padStart(2,'0')+'s';
    },1000);
})();

/* ADD TO CART */
document.querySelectorAll('.p-atc').forEach(function(btn){
    btn.addEventListener('click',function(){
        var orig=btn.innerHTML;
        btn.innerHTML='<i class="fas fa-check"></i> Added!';btn.style.background='#16a34a';
        setTimeout(function(){btn.innerHTML=orig;btn.style.background='';},1400);
        var badge=document.getElementById('cartBadge');
        if(badge)badge.textContent=(parseInt(badge.textContent)||0)+1;
        if(typeof toastr!=='undefined')toastr.success('Item added to cart!','',{timeOut:1800,progressBar:true});
    });
});
</script>

@endsection
