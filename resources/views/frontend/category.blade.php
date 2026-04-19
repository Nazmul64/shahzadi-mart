{{-- resources/views/frontend/category.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,600;0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

/* ══ BASE ══ */
.cp *, .cp *::before, .cp *::after { box-sizing: border-box; }
.cp {
    font-family: 'Plus Jakarta Sans', sans-serif;
    width: 100%;
    max-width: 100%;
}
.cp h1, .cp h2, .cp h3 { font-family: 'Fraunces', serif; }

/* ══ CSS VARS ══ */
.cp {
    --red:       #d0152b;
    --red-dk:    #a80f22;
    --red-lt:    #fff0f2;
    --dark:      #0e0e0f;
    --text:      #2c2c30;
    --mid:       #5a5a65;
    --muted:     #9a9aaa;
    --border:    #e8e8ef;
    --light:     #f6f6f9;
    --white:     #ffffff;
    --shadow:    0 2px 16px rgba(0,0,0,.07);
    --shadow-md: 0 8px 32px rgba(0,0,0,.10);
    --shadow-lg: 0 20px 60px rgba(0,0,0,.13);
    --radius:    14px;
}

/* ══ HERO BANNER ══ */
.cp-banner {
    position: relative;
    background: var(--dark);
    border-radius: 20px;
    overflow: hidden;
    padding: 38px 46px;
    margin-bottom: 26px;
    min-height: 166px;
    display: flex;
    align-items: center;
    gap: 26px;
}
.cp-banner-bg {
    position: absolute; inset: 0; z-index: 0;
    background:
        radial-gradient(ellipse 70% 90% at 100% 50%, rgba(208,21,43,.30) 0%, transparent 65%),
        radial-gradient(ellipse 40% 60% at 0% 0%,   rgba(255,255,255,.04) 0%, transparent 60%),
        linear-gradient(160deg, #161618 0%, #0e0e0f 100%);
}
.cp-banner-ring {
    position: absolute; right: -48px; top: 50%; transform: translateY(-50%);
    width: 310px; height: 310px; border-radius: 50%; z-index: 1;
    border: 52px solid rgba(208,21,43,.06);
}
.cp-banner-ring2 {
    position: absolute; right: 62px; top: 50%; transform: translateY(-50%);
    width: 154px; height: 154px; border-radius: 50%; z-index: 1;
    border: 22px solid rgba(208,21,43,.05);
}
.cp-banner-img {
    width: 86px; height: 86px;
    border-radius: 50%; object-fit: cover;
    border: 3px solid rgba(208,21,43,.55);
    box-shadow: 0 0 0 7px rgba(208,21,43,.1), 0 10px 36px rgba(0,0,0,.5);
    position: relative; z-index: 2; flex-shrink: 0;
}
.cp-banner-img-placeholder {
    width: 86px; height: 86px; border-radius: 50%; flex-shrink: 0;
    background: rgba(208,21,43,.14);
    border: 3px solid rgba(208,21,43,.4);
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; color: rgba(208,21,43,.75);
    position: relative; z-index: 2;
}
.cp-banner-inner { position: relative; z-index: 2; flex: 1; min-width: 0; }
.cp-breadcrumb {
    display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
    font-size: 11.5px; font-weight: 600; letter-spacing: .03em;
    color: rgba(255,255,255,.38); margin-bottom: 13px;
}
.cp-breadcrumb a { color: rgba(255,255,255,.38); text-decoration: none; transition: color .2s; }
.cp-breadcrumb a:hover { color: rgba(255,255,255,.8); }
.cp-breadcrumb .sep { font-size: 8px; color: rgba(255,255,255,.2); }
.cp-breadcrumb .cur { color: rgba(255,255,255,.88); }
.cp-banner-row { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; }
.cp-banner-text h1 {
    font-size: 31px; font-weight: 900; color: #fff;
    line-height: 1.08; margin-bottom: 12px; letter-spacing: -.02em;
}
.cp-banner-meta { display: flex; align-items: center; gap: 9px; flex-wrap: wrap; }
.cp-meta-chip {
    display: flex; align-items: center; gap: 6px;
    padding: 5px 13px; border-radius: 20px;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.10);
    font-size: 12px; font-weight: 700;
    color: rgba(255,255,255,.55);
}
.cp-meta-chip strong { color: var(--red); font-size: 14px; }

/* ══ MAIN LAYOUT: Sidebar + Content ══ */
.cp-layout {
    display: grid;
    grid-template-columns: 272px 1fr;
    gap: 22px;
    align-items: start;
}

/* ══════════════════════════════════════════
   SIDEBAR
══════════════════════════════════════════ */
.cp-sidebar {
    position: sticky;
    top: 18px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* ── Sidebar Widget Card ── */
.cp-sw {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}
.cp-sw-head {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 18px;
    border-bottom: 1.5px solid var(--border);
    background: var(--light);
}
.cp-sw-head-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: var(--red-lt);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: var(--red); flex-shrink: 0;
}
.cp-sw-head-title {
    font-size: 11px; font-weight: 800;
    letter-spacing: .14em; text-transform: uppercase;
    color: var(--dark); flex: 1;
}
.cp-sw-body { padding: 14px 16px; }

/* ── Subcategory List with Image ── */
.cp-sub-list { display: flex; flex-direction: column; gap: 4px; }

.cp-sub-item {
    display: flex; align-items: center; gap: 11px;
    padding: 9px 12px; border-radius: 10px;
    text-decoration: none;
    transition: all .22s;
    position: relative;
    border: 1.5px solid transparent;
}
.cp-sub-item:hover {
    background: var(--red-lt);
    border-color: rgba(208,21,43,.18);
}
.cp-sub-item.active {
    background: var(--red);
    border-color: var(--red);
}
/* Image thumbnail */
.cp-sub-img {
    width: 40px; height: 40px; border-radius: 9px;
    object-fit: cover; flex-shrink: 0;
    border: 1.5px solid var(--border);
    transition: border-color .2s;
    background: var(--light);
}
.cp-sub-item:hover .cp-sub-img { border-color: rgba(208,21,43,.35); }
.cp-sub-item.active .cp-sub-img { border-color: rgba(255,255,255,.4); }

/* Icon fallback when no image */
.cp-sub-icon {
    width: 40px; height: 40px; border-radius: 9px;
    background: var(--light);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; color: var(--muted); flex-shrink: 0;
    border: 1.5px solid var(--border);
    transition: all .2s;
}
.cp-sub-item:hover .cp-sub-icon { background: var(--red-lt); color: var(--red); border-color: rgba(208,21,43,.25); }
.cp-sub-item.active .cp-sub-icon { background: rgba(255,255,255,.18); color: #fff; border-color: rgba(255,255,255,.3); }

.cp-sub-info { flex: 1; min-width: 0; }
.cp-sub-name {
    font-size: 13px; font-weight: 700;
    color: var(--text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    display: block;
    transition: color .2s;
    line-height: 1.3;
}
.cp-sub-item:hover .cp-sub-name { color: var(--red); }
.cp-sub-item.active .cp-sub-name { color: #fff; }

.cp-sub-count {
    font-size: 10.5px; font-weight: 600;
    color: var(--muted);
    display: block; margin-top: 1px;
    transition: color .2s;
}
.cp-sub-item:hover .cp-sub-count { color: rgba(208,21,43,.6); }
.cp-sub-item.active .cp-sub-count { color: rgba(255,255,255,.65); }

.cp-sub-arrow {
    font-size: 10px; color: var(--muted); flex-shrink: 0;
    transition: all .2s;
}
.cp-sub-item:hover .cp-sub-arrow { color: var(--red); transform: translateX(3px); }
.cp-sub-item.active .cp-sub-arrow { color: rgba(255,255,255,.7); transform: translateX(3px); }

/* "View All" link inside subcategory widget */
.cp-sub-view-all {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    margin-top: 10px; padding: 9px;
    border-radius: 9px; border: 1.5px dashed var(--border);
    font-size: 12px; font-weight: 700; color: var(--muted);
    text-decoration: none; transition: all .2s;
}
.cp-sub-view-all:hover { border-color: var(--red); color: var(--red); background: var(--red-lt); }

/* ── Price Range ── */
.cp-price-range { padding: 4px 0; }
.cp-price-inputs {
    display: flex; align-items: center; gap: 8px; margin-bottom: 14px;
}
.cp-price-input {
    flex: 1; padding: 9px 11px; border-radius: 9px;
    border: 1.5px solid var(--border); font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 600; color: var(--text);
    background: var(--light); outline: none; text-align: center;
    transition: border-color .2s;
}
.cp-price-input:focus { border-color: var(--red); }
.cp-price-sep { font-size: 11px; color: var(--muted); font-weight: 700; flex-shrink: 0; }
.cp-price-btn {
    width: 100%; padding: 10px; border-radius: 9px;
    background: var(--red); color: #fff; border: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12.5px; font-weight: 700; cursor: pointer;
    transition: background .2s;
}
.cp-price-btn:hover { background: var(--red-dk); }

/* Range slider */
.cp-range-wrap { margin-bottom: 16px; position: relative; }
.cp-range-track {
    position: relative; height: 5px;
    background: var(--border); border-radius: 4px; margin: 14px 0;
}
.cp-range-fill {
    position: absolute; height: 100%;
    background: var(--red); border-radius: 4px;
    left: 0%; right: 0%;
}
input[type="range"].cp-slider {
    position: absolute; width: 100%; height: 5px;
    -webkit-appearance: none; appearance: none;
    background: transparent; pointer-events: none; top: 0;
}
input[type="range"].cp-slider::-webkit-slider-thumb {
    -webkit-appearance: none; appearance: none;
    width: 18px; height: 18px; border-radius: 50%;
    background: #fff; border: 2.5px solid var(--red);
    cursor: pointer; pointer-events: all;
    box-shadow: 0 2px 8px rgba(208,21,43,.28);
}
.cp-range-labels {
    display: flex; justify-content: space-between;
    font-size: 11.5px; font-weight: 700; color: var(--muted); margin-top: 6px;
}

/* ── Rating Filter ── */
.cp-rating-list { display: flex; flex-direction: column; gap: 6px; }
.cp-rating-row {
    display: flex; align-items: center; gap: 9px;
    padding: 7px 10px; border-radius: 9px; cursor: pointer;
    border: 1.5px solid transparent; transition: all .2s;
    text-decoration: none;
}
.cp-rating-row:hover { background: var(--red-lt); border-color: rgba(208,21,43,.15); }
.cp-rating-row .cp-stars { color: #f59e0b; font-size: 12px; letter-spacing: .04em; }
.cp-rating-row .cp-stars-label { font-size: 12px; font-weight: 700; color: var(--mid); margin-left: 2px; }
.cp-rating-row:hover .cp-stars-label { color: var(--red); }

/* ── Ad / Banner Widget ── */
.cp-sidebar-ad {
    background: linear-gradient(145deg, var(--red) 0%, #8b0000 100%);
    border-radius: var(--radius); overflow: hidden;
    position: relative; padding: 24px 20px;
    text-decoration: none; display: block;
    transition: transform .22s, box-shadow .22s;
}
.cp-sidebar-ad:hover { transform: translateY(-3px); box-shadow: 0 12px 36px rgba(208,21,43,.4); }
.cp-sidebar-ad::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(circle at 80% 20%, rgba(255,255,255,.12), transparent 55%);
}
.cp-sidebar-ad-tag {
    font-size: 9px; font-weight: 800; letter-spacing: .18em;
    text-transform: uppercase; color: rgba(255,255,255,.65);
    margin-bottom: 10px; display: block; position: relative; z-index: 1;
}
.cp-sidebar-ad-title {
    font-family: 'Fraunces', serif;
    font-size: 26px; font-weight: 900; color: #fff;
    line-height: 1.08; margin-bottom: 6px;
    position: relative; z-index: 1;
}
.cp-sidebar-ad-sub {
    font-size: 11px; font-weight: 700; color: rgba(255,255,255,.72);
    letter-spacing: .08em; text-transform: uppercase;
    position: relative; z-index: 1;
}
.cp-sidebar-ad-ring {
    position: absolute; right: -28px; bottom: -28px;
    width: 110px; height: 110px; border-radius: 50%;
    border: 28px solid rgba(255,255,255,.06);
}

/* ══ CONTENT AREA (right side) ══ */
.cp-content { min-width: 0; }

/* ── Filter chips ── */
.cp-filter-bar {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    margin-bottom: 20px; padding-bottom: 18px;
    border-bottom: 1.5px solid var(--border);
}
.cp-filter-label {
    font-size: 10.5px; font-weight: 800; letter-spacing: .14em;
    text-transform: uppercase; color: var(--muted); margin-right: 2px;
}
.cp-chip {
    padding: 6px 16px; border-radius: 50px;
    border: 1.5px solid var(--border);
    font-size: 12px; font-weight: 700; color: var(--mid);
    text-decoration: none; transition: all .2s; white-space: nowrap;
    background: var(--white);
}
.cp-chip:hover { border-color: var(--red); color: var(--red); background: var(--red-lt); }
.cp-chip.active {
    background: var(--red); color: #fff; border-color: var(--red);
    box-shadow: 0 4px 14px rgba(208,21,43,.3);
}

/* ── Toolbar ── */
.cp-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
    padding: 12px 16px;
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}
.cp-result-text { font-size: 13px; font-weight: 600; color: var(--muted); }
.cp-result-text strong { color: var(--dark); }
.cp-sort {
    padding: 8px 13px; border: 1.5px solid var(--border);
    border-radius: 9px; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 600; color: var(--text);
    background: var(--light); cursor: pointer; outline: none; transition: border-color .2s;
}
.cp-sort:focus { border-color: var(--red); }
.cp-view-btns { display: flex; gap: 5px; }
.cp-view-btn {
    width: 36px; height: 36px; border: 1.5px solid var(--border);
    border-radius: 9px; display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: var(--muted); cursor: pointer;
    transition: all .2s; background: var(--white);
}
.cp-view-btn.active, .cp-view-btn:hover {
    border-color: var(--red); color: var(--red); background: var(--red-lt);
}

/* ══ PRODUCT GRID ══ */
.cp-prod-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
.cp-prod-grid.list-view { grid-template-columns: 1fr; }

/* ══ PRODUCT CARD ══ */
.cp-card {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: 16px; overflow: hidden; position: relative;
    transition: all .3s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
    animation: cp-fadeup .45s ease both;
}
@keyframes cp-fadeup {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
.cp-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-6px);
    border-color: rgba(208,21,43,.22);
}
.cp-badge {
    position: absolute; top: 11px; left: 11px; z-index: 3;
    background: var(--red); color: #fff;
    font-size: 10px; font-weight: 800; letter-spacing: .04em;
    padding: 4px 10px; border-radius: 6px;
    box-shadow: 0 2px 8px rgba(208,21,43,.4);
}
.cp-wish {
    position: absolute; top: 10px; right: 10px; z-index: 3;
    width: 34px; height: 34px; background: rgba(255,255,255,.95);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: #ccc; box-shadow: 0 2px 10px rgba(0,0,0,.12);
    border: none; cursor: pointer; transition: all .22s;
    opacity: 0; pointer-events: none;
}
.cp-card:hover .cp-wish, .cp-wish.wished { opacity: 1; pointer-events: auto; }
.cp-wish.wished { color: var(--red); background: #fff0f2; }
.cp-wish:hover { transform: scale(1.18); color: var(--red); }

.cp-img-wrap { position: relative; overflow: hidden; background: var(--light); }
.cp-img {
    width: 100%; height: 168px; object-fit: cover; display: block;
    border-bottom: 1.5px solid var(--border);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
}
.cp-card:hover .cp-img { transform: scale(1.06); }
.cp-quickview {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(14,14,15,.88); color: #fff;
    font-size: 11px; font-weight: 800; letter-spacing: .08em;
    text-transform: uppercase; text-align: center; padding: 10px;
    transform: translateY(100%); transition: transform .28s ease;
    backdrop-filter: blur(6px); text-decoration: none; display: block;
}
.cp-card:hover .cp-quickview { transform: translateY(0); }

.cp-card-body { padding: 13px 14px 14px; display: flex; flex-direction: column; flex: 1; }
.cp-card-cat {
    font-size: 10px; font-weight: 800; letter-spacing: .12em;
    text-transform: uppercase; color: var(--red); margin-bottom: 5px;
}
.cp-card-name {
    font-size: 13px; font-weight: 600; color: var(--text);
    line-height: 1.45; margin-bottom: 7px;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.cp-card-stars { color: #f59e0b; font-size: 11px; margin-bottom: 8px; }
.cp-card-stars span { color: var(--muted); font-size: 11px; margin-left: 2px; font-family: 'Plus Jakarta Sans', sans-serif; }
.cp-price-row { display: flex; align-items: baseline; gap: 7px; margin-bottom: 2px; flex-wrap: wrap; }
.cp-card-price { font-size: 17px; font-weight: 800; color: var(--red); }
.cp-card-old { font-size: 12px; color: var(--muted); text-decoration: line-through; }
.cp-stock { margin: 8px 0; }
.cp-stock-label {
    font-size: 10.5px; font-weight: 700; color: #d97706;
    display: flex; align-items: center; gap: 4px; margin-bottom: 5px;
}
.cp-stock-track { height: 4px; background: #f0f0f0; border-radius: 3px; overflow: hidden; }
.cp-stock-fill { height: 100%; background: linear-gradient(90deg, #f59e0b, #ef4444); border-radius: 3px; }
.cp-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 11px 0;
    background: var(--red); color: #fff; border: none; border-radius: 11px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12.5px; font-weight: 700; cursor: pointer;
    transition: all .22s; margin-top: auto; text-decoration: none;
}
.cp-atc:hover {
    background: var(--red-dk); transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(208,21,43,.38); color: #fff;
}

/* ── List View ── */
.cp-prod-grid.list-view .cp-card { flex-direction: row; border-radius: 14px; }
.cp-prod-grid.list-view .cp-img-wrap { width: 175px; flex-shrink: 0; }
.cp-prod-grid.list-view .cp-img { height: 140px; border-bottom: none; border-right: 1.5px solid var(--border); }
.cp-prod-grid.list-view .cp-card-body { padding: 16px 18px; }
.cp-prod-grid.list-view .cp-card-name { -webkit-line-clamp: 1; font-size: 15px; }
.cp-prod-grid.list-view .cp-atc { max-width: 190px; }

/* ── Empty State ── */
.cp-empty {
    text-align: center; padding: 80px 24px;
    background: var(--white); border: 2px dashed var(--border); border-radius: 20px;
}
.cp-empty-icon {
    font-size: 52px; color: #d8d8e8; margin-bottom: 18px; display: block;
    animation: float 3.5s ease-in-out infinite;
}
@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
.cp-empty h3 { font-size: 22px; color: var(--dark); margin-bottom: 8px; }
.cp-empty p { font-size: 14px; color: var(--muted); font-weight: 500; }

/* ── Pagination ── */
.cp-pagination { margin-top: 32px; display: flex; justify-content: center; }
.cp-pagination .pagination { display: flex; gap: 5px; list-style: none; padding: 0; margin: 0; }
.cp-pagination .page-item .page-link {
    width: 38px; height: 38px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    border: 1.5px solid var(--border); font-size: 13px; font-weight: 700;
    color: var(--mid); text-decoration: none; transition: all .2s;
    background: var(--white); font-family: 'Plus Jakarta Sans', sans-serif;
}
.cp-pagination .page-item.active .page-link {
    background: var(--red); border-color: var(--red); color: #fff;
    box-shadow: 0 4px 14px rgba(208,21,43,.35);
}
.cp-pagination .page-item .page-link:hover { border-color: var(--red); color: var(--red); background: var(--red-lt); }

/* ══ MOBILE SIDEBAR TOGGLE ══ */
.cp-sidebar-toggle {
    display: none;
    align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 11px 16px;
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: var(--radius); margin-bottom: 14px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 700; color: var(--text);
    cursor: pointer; transition: all .2s;
    box-shadow: var(--shadow);
}
.cp-sidebar-toggle:hover { border-color: var(--red); color: var(--red); }

/* ══ RESPONSIVE ══ */
@media (max-width: 1100px) {
    .cp-layout { grid-template-columns: 240px 1fr; gap: 18px; }
    .cp-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
}
@media (max-width: 900px) {
    .cp-layout { grid-template-columns: 1fr; }
    .cp-sidebar { position: static; display: none; }
    .cp-sidebar.open { display: flex; }
    .cp-sidebar-toggle { display: flex; }
    .cp-banner { padding: 26px 22px; gap: 16px; }
    .cp-banner-text h1 { font-size: 24px; }
    .cp-banner-img, .cp-banner-img-placeholder { width: 66px; height: 66px; font-size: 22px; }
    .cp-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
}
@media (max-width: 640px) {
    .cp-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .cp-img { height: 140px; }
    .cp-wish { opacity: 1; pointer-events: auto; }
    .cp-prod-grid.list-view .cp-card { flex-direction: column; }
    .cp-prod-grid.list-view .cp-img-wrap { width: 100%; }
    .cp-prod-grid.list-view .cp-img { height: 145px; border-right: none; border-bottom: 1.5px solid var(--border); }
}
</style>

<div class="cp">

    {{-- ══ HERO BANNER ══ --}}
    <div class="cp-banner">
        <div class="cp-banner-bg"></div>
        <div class="cp-banner-ring"></div>
        <div class="cp-banner-ring2"></div>

        @if($category->category_photo)
            <img class="cp-banner-img"
                 src="{{ asset('uploads/category/' . $category->category_photo) }}"
                 alt="{{ $category->category_name }}">
        @else
            <div class="cp-banner-img-placeholder"><i class="bi bi-grid"></i></div>
        @endif

        <div class="cp-banner-inner">
            <div class="cp-breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="sep"><i class="bi bi-chevron-right"></i></span>
                <span class="cur">{{ $category->category_name }}</span>
            </div>
            <div class="cp-banner-row">
                <div class="cp-banner-text">
                    <h1>{{ $category->category_name }}</h1>
                    <div class="cp-banner-meta">
                        <div class="cp-meta-chip">
                            <i class="bi bi-box2" style="font-size:12px;color:rgba(255,255,255,.4)"></i>
                            <strong>{{ $products->total() }}</strong> Products
                        </div>
                        @if($category->subCategories->count())
                        <div class="cp-meta-chip">
                            <i class="bi bi-diagram-3" style="font-size:12px;color:rgba(255,255,255,.4)"></i>
                            <strong>{{ $category->subCategories->count() }}</strong> Subcategories
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ MOBILE SIDEBAR TOGGLE ══ --}}
    <button class="cp-sidebar-toggle" onclick="document.getElementById('cpSidebar').classList.toggle('open')">
        <i class="bi bi-sliders"></i> Filters & Categories
        <i class="bi bi-chevron-down" style="margin-left:auto;font-size:11px;"></i>
    </button>

    {{-- ══ MAIN LAYOUT ══ --}}
    <div class="cp-layout">

        {{-- ════════════════════════════
             SIDEBAR
        ════════════════════════════ --}}
        <aside class="cp-sidebar" id="cpSidebar">

            {{-- ── Widget 1: Subcategories with Images ── --}}
            @if($category->subCategories->count())
            <div class="cp-sw">
                <div class="cp-sw-head">
                    <div class="cp-sw-head-icon"><i class="bi bi-diagram-3"></i></div>
                    <span class="cp-sw-head-title">Subcategories</span>
                </div>
                <div class="cp-sw-body" style="padding:10px 12px;">
                    <div class="cp-sub-list">

                        {{-- "All" item with category image --}}
                        <a href="{{ route('category.page', $category->slug) }}"
                           class="cp-sub-item {{ !request('sub') ? 'active' : '' }}">
                            @if($category->category_photo)
                                <img class="cp-sub-img"
                                     src="{{ asset('uploads/category/' . $category->category_photo) }}"
                                     alt="All">
                            @else
                                <div class="cp-sub-icon"><i class="bi bi-grid-fill"></i></div>
                            @endif
                            <div class="cp-sub-info">
                                <span class="cp-sub-name">All Products</span>
                                <span class="cp-sub-count">{{ $products->total() }} items</span>
                            </div>
                            <i class="bi bi-chevron-right cp-sub-arrow"></i>
                        </a>

                        {{-- Each subcategory with its own photo ── --}}
                        @foreach($category->subCategories as $sub)
                        <a href="{{ route('subcategory.page', [$category->slug, $sub->slug]) }}"
                           class="cp-sub-item {{ request()->is('*/'.$sub->slug.'*') ? 'active' : '' }}">

                            @if(!empty($sub->sub_photo))
                                <img class="cp-sub-img"
                                     src="{{ asset('uploads/subcategory/' . $sub->sub_photo) }}"
                                     alt="{{ $sub->sub_name }}">
                            @elseif(!empty($sub->photo))
                                <img class="cp-sub-img"
                                     src="{{ asset('uploads/' . $sub->photo) }}"
                                     alt="{{ $sub->sub_name }}">
                            @else
                                <div class="cp-sub-icon">
                                    <i class="bi bi-tag"></i>
                                </div>
                            @endif

                            <div class="cp-sub-info">
                                <span class="cp-sub-name">{{ $sub->sub_name }}</span>
                                <span class="cp-sub-count">
                                    {{ $sub->childCategories->count() ?? 0 }} types
                                </span>
                            </div>
                            <i class="bi bi-chevron-right cp-sub-arrow"></i>
                        </a>
                        @endforeach

                    </div>
                </div>
            </div>
            @endif

            {{-- ── Widget 2: Price Range ── --}}
            <div class="cp-sw">
                <div class="cp-sw-head">
                    <div class="cp-sw-head-icon"><i class="bi bi-cash-stack"></i></div>
                    <span class="cp-sw-head-title">Price Range</span>
                </div>
                <div class="cp-sw-body">
                    <div class="cp-price-range">
                        <div class="cp-range-wrap">
                            <div class="cp-range-track" id="cpRangeTrack">
                                <div class="cp-range-fill" id="cpRangeFill"></div>
                                <input type="range" class="cp-slider" id="cpRangeMin"
                                       min="0" max="50000" value="0" step="500">
                                <input type="range" class="cp-slider" id="cpRangeMax"
                                       min="0" max="50000" value="50000" step="500">
                            </div>
                            <div class="cp-range-labels">
                                <span id="cpRangeMinLabel">৳ 0</span>
                                <span id="cpRangeMaxLabel">৳ 50,000</span>
                            </div>
                        </div>
                        <div class="cp-price-inputs">
                            <input type="number" class="cp-price-input" id="cpPriceMin"
                                   placeholder="Min" value="0">
                            <span class="cp-price-sep">—</span>
                            <input type="number" class="cp-price-input" id="cpPriceMax"
                                   placeholder="Max" value="50000">
                        </div>
                        <button class="cp-price-btn">
                            <i class="bi bi-arrow-right-circle me-1"></i> Apply Filter
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── Widget 3: Rating Filter ── --}}
            <div class="cp-sw">
                <div class="cp-sw-head">
                    <div class="cp-sw-head-icon"><i class="bi bi-star-half"></i></div>
                    <span class="cp-sw-head-title">Customer Rating</span>
                </div>
                <div class="cp-sw-body" style="padding:10px 12px;">
                    <div class="cp-rating-list">
                        @foreach([5,4,3,2,1] as $r)
                        <a href="#" class="cp-rating-row">
                            <span class="cp-stars">
                                @for($s=1;$s<=5;$s++)
                                    {{ $s <= $r ? '★' : '☆' }}
                                @endfor
                            </span>
                            <span class="cp-stars-label">{{ $r }} Star{{ $r > 1 ? 's' : '' }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── Clearance Banner Ad ── --}}
            <a href="{{ url('clearance') }}" class="cp-sidebar-ad">
                <div class="cp-sidebar-ad-ring"></div>
                <span class="cp-sidebar-ad-tag">Limited Time</span>
                <div class="cp-sidebar-ad-title">Up to<br>70% OFF</div>
                <div class="cp-sidebar-ad-sub">Clearance Sale →</div>
            </a>

        </aside>{{-- /.cp-sidebar --}}


        {{-- ════════════════════════════
             CONTENT (Products)
        ════════════════════════════ --}}
        <div class="cp-content">

            {{-- ── Filter chips (top of content) ── --}}
            @if($category->subCategories->count())
            <div class="cp-filter-bar">
                <span class="cp-filter-label">Filter:</span>
                <a href="{{ route('category.page', $category->slug) }}" class="cp-chip active">All</a>
                @foreach($category->subCategories as $sub)
                    <a href="{{ route('subcategory.page', [$category->slug, $sub->slug]) }}"
                       class="cp-chip">{{ $sub->sub_name }}</a>
                @endforeach
            </div>
            @endif

            {{-- ── Toolbar ── --}}
            <div class="cp-toolbar">
                <span class="cp-result-text">
                    Showing
                    <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong>
                    of <strong>{{ $products->total() }}</strong> results
                </span>
                <div style="display:flex;gap:9px;align-items:center;">
                    <select class="cp-sort">
                        <option>Default Sorting</option>
                        <option>Newest First</option>
                        <option>Price: Low → High</option>
                        <option>Price: High → Low</option>
                        <option>Best Rated</option>
                    </select>
                    <div class="cp-view-btns">
                        <button class="cp-view-btn active" onclick="cpView('grid')"
                                id="cpGridBtn" title="Grid View">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </button>
                        <button class="cp-view-btn" onclick="cpView('list')"
                                id="cpListBtn" title="List View">
                            <i class="bi bi-list-ul"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── Product Grid ── --}}
            @if($products->isNotEmpty())
            <div class="cp-prod-grid" id="cpProdGrid">
                @foreach($products as $i => $item)
                @php
                    $displayPrice = $item->discount_price ?? $item->current_price;
                    $discount     = ($item->discount_price && $item->current_price > 0)
                        ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                    $stockPct     = ($item->stock && !$item->is_unlimited && $item->stock <= 50)
                        ? max(10, ($item->stock / 50) * 100) : null;
                @endphp
                <div class="cp-card" style="animation-delay:{{ $i * 0.05 }}s">
                    @if($discount) <span class="cp-badge">-{{ $discount }}%</span> @endif
                    <button class="cp-wish" onclick="cpWish(this)" title="Wishlist">
                        <i class="bi bi-heart"></i>
                    </button>
                    <div class="cp-img-wrap">
                        <img class="cp-img"
                             src="{{ asset('uploads/products/' . $item->feature_image) }}"
                             alt="{{ $item->name }}" loading="lazy">
                        <a href="{{ route('product.detail', $item->slug) }}" class="cp-quickview">
                            <i class="bi bi-eye me-1"></i> Quick View
                        </a>
                    </div>
                    <div class="cp-card-body">
                        <div class="cp-card-cat">{{ $category->category_name }}</div>
                        <div class="cp-card-name">{{ $item->name }}</div>
                        <div class="cp-card-stars">★★★★☆ <span>(0)</span></div>
                        <div class="cp-price-row">
                            <span class="cp-card-price">৳ {{ number_format($displayPrice, 0) }}</span>
                            @if($item->discount_price)
                                <span class="cp-card-old">৳ {{ number_format($item->current_price, 0) }}</span>
                            @endif
                        </div>
                        @if($stockPct !== null && $item->stock <= 20)
                        <div class="cp-stock">
                            <div class="cp-stock-label">
                                <i class="bi bi-fire" style="font-size:10px"></i>
                                Only {{ $item->stock }} left!
                            </div>
                            <div class="cp-stock-track">
                                <div class="cp-stock-fill" style="width:{{ 100 - $stockPct }}%"></div>
                            </div>
                        </div>
                        @endif
                        <a href="{{ route('product.detail', $item->slug) }}" class="cp-atc">
                            <i class="bi bi-cart-plus"></i> View Product
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="cp-pagination">{{ $products->links() }}</div>

            @else
            <div class="cp-empty">
                <i class="bi bi-box-seam cp-empty-icon"></i>
                <h3>No Products Found</h3>
                <p>No products available in <strong>{{ $category->category_name }}</strong> yet.</p>
            </div>
            @endif

        </div>{{-- /.cp-content --}}

    </div>{{-- /.cp-layout --}}

</div>{{-- /.cp --}}

<script>
/* ── Wishlist toggle ── */
function cpWish(btn) {
    btn.classList.toggle('wished');
    const i = btn.querySelector('i');
    i.classList.toggle('bi-heart');
    i.classList.toggle('bi-heart-fill');
}

/* ── Grid / List view toggle ── */
function cpView(v) {
    const grid = document.getElementById('cpProdGrid');
    document.getElementById('cpGridBtn').classList.toggle('active', v === 'grid');
    document.getElementById('cpListBtn').classList.toggle('active', v === 'list');
    grid.classList.toggle('list-view', v === 'list');
}

/* ── Price range slider sync ── */
(function () {
    const minEl   = document.getElementById('cpRangeMin');
    const maxEl   = document.getElementById('cpRangeMax');
    const fill    = document.getElementById('cpRangeFill');
    const minInp  = document.getElementById('cpPriceMin');
    const maxInp  = document.getElementById('cpPriceMax');
    const minLbl  = document.getElementById('cpRangeMinLabel');
    const maxLbl  = document.getElementById('cpRangeMaxLabel');

    function fmt(v) { return '৳ ' + Number(v).toLocaleString(); }

    function update() {
        let lo = Math.min(+minEl.value, +maxEl.value - 500);
        let hi = Math.max(+maxEl.value, +minEl.value + 500);
        minEl.value = lo; maxEl.value = hi;
        const pct = v => ((v - 0) / 50000) * 100;
        fill.style.left  = pct(lo) + '%';
        fill.style.right = (100 - pct(hi)) + '%';
        minLbl.textContent = fmt(lo);
        maxLbl.textContent = fmt(hi);
        minInp.value = lo;
        maxInp.value = hi;
    }

    if (minEl && maxEl) {
        minEl.addEventListener('input', update);
        maxEl.addEventListener('input', update);
        minInp && minInp.addEventListener('input', () => { minEl.value = minInp.value; update(); });
        maxInp && maxInp.addEventListener('input', () => { maxEl.value = maxInp.value; update(); });
        update();
    }
})();
</script>

@endsection
