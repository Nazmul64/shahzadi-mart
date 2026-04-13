@extends('frontend.master')

@section('main-content')
<style>
  /* ── RESET & BASE ── */
  .productdetailspage *, .productdetailspage *::before, .productdetailspage *::after {
    box-sizing: border-box; margin: 0; padding: 0;
  }
  .productdetailspage {
    --primary:   #be0318;
    --primary-d: #960212;
    --text:      #1a1a1a;
    --muted:     #6b7280;
    --border:    #e5e7eb;
    --bg:        #f9fafb;
    --white:     #ffffff;
    --gold:      #f59e0b;
    --green:     #16a34a;
    --radius:    10px;
    --shadow:    0 2px 12px rgba(0,0,0,.08);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    color: var(--text);
    background: var(--bg);
    line-height: 1.6;
  }
  .productdetailspage a { color: inherit; text-decoration: none; }
  .productdetailspage img { display: block; max-width: 100%; }
  .productdetailspage button { cursor: pointer; font-family: inherit; }

  /* ── LAYOUT HELPERS ── */
  .productdetailspage__container { max-width: 1280px; margin: 0 auto; padding: 0 20px; }

  /* ── TOP BAR / BREADCRUMB ── */
  .productdetailspage__top-bar {
    background: var(--white);
    border-bottom: 1px solid var(--border);
    padding: 10px 0;
    font-size: 12px;
    color: var(--muted);
  }
  .productdetailspage__breadcrumb { display: flex; align-items: center; flex-wrap: wrap; gap: 6px; }
  .productdetailspage__breadcrumb a { color: var(--muted); transition: color .2s; }
  .productdetailspage__breadcrumb a:hover { color: var(--primary); }
  .productdetailspage__breadcrumb-sep { color: #d1d5db; }
  .productdetailspage__breadcrumb-current { color: var(--text); font-weight: 500; }

  /* ── MAIN PRODUCT LAYOUT ── */
  .productdetailspage__product-page {
    background: var(--white);
    margin-top: 16px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
  }
  .productdetailspage__product-grid {
    display: grid;
    grid-template-columns: 420px 1fr 280px;
    gap: 0;
    align-items: start;
  }
  @media(max-width:1100px){
    .productdetailspage__product-grid { grid-template-columns: 1fr 1fr; }
    .productdetailspage__sidebar-section { grid-column: 1/-1; }
  }
  @media(max-width:680px){
    .productdetailspage__product-grid { grid-template-columns: 1fr; }
  }
  .productdetailspage__product-info-section {
    border-left: 1px solid var(--border);
    border-right: 1px solid var(--border);
  }

  /* ── GALLERY ── */
  .productdetailspage__gallery-section { padding: 20px; }

  .productdetailspage__main-image-wrap {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    background: #f3f4f6;
    aspect-ratio: 1/1;
    cursor: zoom-in;
  }
  .productdetailspage__main-image-wrap img.productdetailspage__main-img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .45s ease; display: block;
  }
  .productdetailspage__main-image-wrap:hover img.productdetailspage__main-img { transform: scale(1.07); }

  .productdetailspage__badge-row {
    position: absolute; top: 10px; left: 10px;
    display: flex; flex-direction: column; gap: 5px; z-index: 2;
  }
  .productdetailspage__badge {
    font-size: 10px; font-weight: 600;
    padding: 3px 8px; border-radius: 4px; letter-spacing: .4px;
  }
  .productdetailspage__badge--vendor { background: var(--green); color: #fff; }

  .productdetailspage__wishlist-btn {
    position: absolute; top: 10px; right: 10px; z-index: 2;
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255,255,255,.9); border: none;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; color: #9ca3af;
    transition: all .2s; box-shadow: 0 2px 6px rgba(0,0,0,.1);
  }
  .productdetailspage__wishlist-btn:hover,
  .productdetailspage__wishlist-btn--active { color: #ef4444; }

  .productdetailspage__img-counter {
    position: absolute; bottom: 10px; right: 10px;
    background: rgba(0,0,0,.5); color: #fff;
    font-size: 11px; padding: 3px 8px; border-radius: 20px;
    display: flex; align-items: center; gap: 5px; z-index: 3;
  }

  .productdetailspage__zoom-hint {
    position: absolute; bottom: 10px; left: 10px;
    background: rgba(0,0,0,.45); color: #fff;
    font-size: 10px; padding: 3px 8px; border-radius: 20px;
    display: flex; align-items: center; gap: 4px;
    opacity: 0; transition: opacity .3s;
    z-index: 3; pointer-events: none;
  }
  .productdetailspage__main-image-wrap:hover .productdetailspage__zoom-hint { opacity: 1; }

  /* ── HOVER POPUP ── */
  .productdetailspage__img-hover-popup {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: linear-gradient(to top, rgba(190,3,24,0.97) 0%, rgba(190,3,24,0.88) 60%, transparent 100%);
    color: #fff; padding: 28px 18px 18px;
    transform: translateY(100%);
    transition: transform .38s cubic-bezier(.4,0,.2,1), opacity .38s ease;
    opacity: 0; z-index: 10; pointer-events: none;
    border-radius: 0 0 8px 8px;
  }
  .productdetailspage__main-image-wrap:hover .productdetailspage__img-hover-popup {
    transform: translateY(0); opacity: 1;
  }
  .productdetailspage__popup-title {
    font-size: 13px; font-weight: 700; line-height: 1.4; margin-bottom: 10px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
  }
  .productdetailspage__popup-meta {
    display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 10px;
  }
  .productdetailspage__popup-price-current { font-size: 20px; font-weight: 800; color: #fff; }
  .productdetailspage__popup-price-old { font-size: 12px; color: rgba(255,255,255,0.65); text-decoration: line-through; }
  .productdetailspage__popup-discount-chip {
    background: rgba(255,255,255,0.25); border: 1px solid rgba(255,255,255,0.5);
    color: #fff; font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px;
  }
  .productdetailspage__popup-row {
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;
  }
  .productdetailspage__popup-stock {
    display: flex; align-items: center; gap: 5px; font-size: 11px;
    color: rgba(255,255,255,0.85); background: rgba(255,255,255,0.15);
    padding: 3px 9px; border-radius: 20px;
  }
  .productdetailspage__popup-stock i { font-size: 10px; color: #fbbf24; }
  .productdetailspage__popup-divider { border: none; border-top: 1px solid rgba(255,255,255,0.2); margin: 10px 0; }
  .productdetailspage__popup-info-row {
    display: flex; gap: 14px; font-size: 11px; color: rgba(255,255,255,0.85); flex-wrap: wrap;
  }
  .productdetailspage__popup-info-item { display: flex; align-items: center; gap: 5px; }
  .productdetailspage__popup-info-item i { font-size: 11px; color: rgba(255,255,255,0.7); }

  /* ── ZOOM OVERLAY ── */
  .productdetailspage__zoom-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,0.92);
    z-index: 99999; display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none; transition: opacity .3s ease;
  }
  .productdetailspage__zoom-overlay--active { opacity: 1; pointer-events: all; }
  .productdetailspage__zoom-overlay-img {
    max-width: 90vw; max-height: 90vh; object-fit: contain;
    border-radius: 10px; transform: scale(0.82);
    transition: transform .38s cubic-bezier(.4,0,.2,1);
    cursor: zoom-out; box-shadow: 0 24px 80px rgba(0,0,0,.6);
  }
  .productdetailspage__zoom-overlay--active .productdetailspage__zoom-overlay-img { transform: scale(1); }
  .productdetailspage__zoom-close-btn {
    position: absolute; top: 18px; right: 22px;
    background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.3);
    color: #fff; font-size: 18px; width: 44px; height: 44px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .2s, transform .2s; z-index: 2;
  }
  .productdetailspage__zoom-close-btn:hover { background: rgba(255,255,255,.28); transform: scale(1.1); }
  .productdetailspage__zoom-nav-btn {
    position: absolute; top: 50%; transform: translateY(-50%);
    background: rgba(255,255,255,.12); border: 1.5px solid rgba(255,255,255,.25);
    color: #fff; width: 48px; height: 48px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center; font-size: 18px;
    cursor: pointer; transition: background .2s, transform .2s; z-index: 2;
  }
  .productdetailspage__zoom-nav-btn:hover { background: rgba(255,255,255,.25); }
  .productdetailspage__zoom-nav-btn:active { transform: translateY(-50%) scale(.95); }
  .productdetailspage__zoom-prev { left: 20px; }
  .productdetailspage__zoom-next { right: 20px; }
  .productdetailspage__zoom-counter {
    position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);
    background: rgba(255,255,255,.15); color: #fff;
    font-size: 12px; font-weight: 600; padding: 5px 14px; border-radius: 20px; letter-spacing: .5px;
  }

  /* ── THUMBNAILS ── */
  .productdetailspage__thumbnails { display: flex; gap: 8px; margin-top: 12px; flex-wrap: wrap; }
  .productdetailspage__thumb {
    width: 60px; height: 60px; border-radius: 6px; overflow: hidden;
    border: 2px solid transparent; cursor: pointer; flex-shrink: 0;
    transition: border-color .2s, transform .2s;
  }
  .productdetailspage__thumb img { width: 100%; height: 100%; object-fit: cover; }
  .productdetailspage__thumb--active { border-color: var(--primary); }
  .productdetailspage__thumb:hover { border-color: #f5a0aa; transform: translateY(-2px); }

  /* ── SHARE ROW ── */
  .productdetailspage__share-row { margin-top: 16px; display: flex; align-items: center; gap: 10px; }
  .productdetailspage__share-label { font-size: 12px; color: var(--muted); font-weight: 500; white-space: nowrap; }
  .productdetailspage__social-icons { display: flex; gap: 8px; }
  .productdetailspage__soc-btn {
    width: 32px; height: 32px; border-radius: 50%; border: none;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; color: #fff; transition: transform .2s, opacity .2s;
  }
  .productdetailspage__soc-btn:hover { transform: scale(1.15); opacity: .9; }
  .productdetailspage__soc-btn--fb { background: #1877f2; }
  .productdetailspage__soc-btn--tw { background: #1da1f2; }
  .productdetailspage__soc-btn--li { background: #0a66c2; }
  .productdetailspage__soc-btn--wa { background: #25d366; }

  /* ── PRODUCT INFO ── */
  .productdetailspage__product-info-section { padding: 24px; }
  .productdetailspage__product-title {
    font-family: 'DM Serif Display', serif;
    font-size: 20px; line-height: 1.35;
    color: var(--text); margin-bottom: 12px;
  }
  .productdetailspage__brand-row {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; margin-bottom: 10px; flex-wrap: wrap;
  }
  .productdetailspage__brand-label { color: var(--muted); }
  .productdetailspage__divider-dot { color: var(--border); }

  .productdetailspage__viewers-row {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; color: var(--muted); margin-bottom: 8px;
  }
  .productdetailspage__viewers-row i { color: #10b981; }
  .productdetailspage__viewers-count { font-weight: 600; color: var(--text); }

  /* ── FLASH BANNER ── */
  .productdetailspage__flash-banner {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    border-radius: 8px; padding: 12px 16px;
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 18px; flex-wrap: wrap; gap: 10px;
  }
  .productdetailspage__flash-left { display: flex; align-items: center; gap: 8px; }
  .productdetailspage__flash-left i { color: #facc15; font-size: 16px; }
  .productdetailspage__flash-left span { color: #fff; font-weight: 700; font-size: 14px; letter-spacing: .5px; }
  .productdetailspage__flash-timer { display: flex; align-items: center; gap: 6px; }
  .productdetailspage__ends-label { color: #94a3b8; font-size: 11px; }
  .productdetailspage__timer-box {
    background: #facc15; color: #1a1a2e;
    font-weight: 800; font-size: 13px;
    padding: 4px 8px; border-radius: 5px; min-width: 36px; text-align: center;
  }

  /* ── PRICE ── */
  .productdetailspage__price-block { margin-bottom: 18px; }
  .productdetailspage__price-row {
    display: flex; align-items: baseline; gap: 10px; flex-wrap: wrap; margin-bottom: 6px;
  }
  .productdetailspage__current-price { font-size: 28px; font-weight: 700; color: var(--primary); }
  .productdetailspage__original-price { font-size: 16px; color: var(--muted); text-decoration: line-through; }
  .productdetailspage__discount-chip {
    background: #fff0f0; color: var(--primary);
    font-size: 12px; font-weight: 700; padding: 2px 8px;
    border-radius: 20px; border: 1px solid #f5a0aa;
  }
  .productdetailspage__stock-info { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
  .productdetailspage__stock-count { font-size: 12px; color: var(--primary); font-weight: 600; }
  .productdetailspage__stock-bar { height: 4px; background: #fee2e2; border-radius: 2px; flex: 1; }
  .productdetailspage__stock-fill { height: 100%; background: var(--primary); border-radius: 2px; }

  /* ── OPTIONS ── */
  .productdetailspage__option-group { margin-bottom: 14px; }
  .productdetailspage__option-label {
    font-size: 13px; font-weight: 600; color: var(--text); display: block; margin-bottom: 8px;
  }
  .productdetailspage__option-btns { display: flex; gap: 8px; flex-wrap: wrap; }
  .productdetailspage__opt-btn {
    padding: 6px 14px; border-radius: 6px;
    border: 1.5px solid var(--border);
    background: var(--white); font-size: 13px; font-weight: 500; color: var(--text);
    transition: all .2s;
  }
  .productdetailspage__opt-btn:hover { border-color: var(--primary); color: var(--primary); }
  .productdetailspage__opt-btn--active { border-color: var(--primary); background: #fff0f0; color: var(--primary); font-weight: 600; }

  /* ── QUANTITY ── */
  .productdetailspage__qty-group { margin-bottom: 18px; }
  .productdetailspage__qty-row { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
  .productdetailspage__qty-selector {
    display: flex; align-items: center;
    border: 1.5px solid var(--border); border-radius: 8px; overflow: hidden;
  }
  .productdetailspage__qty-btn {
    width: 36px; height: 36px; border: none; background: #f9fafb;
    font-size: 14px; color: var(--text); transition: background .2s;
  }
  .productdetailspage__qty-btn:hover { background: #f3f4f6; }
  .productdetailspage__qty-input {
    width: 48px; height: 36px; border: none;
    border-left: 1.5px solid var(--border); border-right: 1.5px solid var(--border);
    text-align: center; font-size: 14px; font-weight: 600; font-family: inherit; background: #fff;
  }
  .productdetailspage__stock-alert {
    display: flex; align-items: center; gap: 5px;
    font-size: 12px; color: var(--primary); font-weight: 500;
  }

  /* ── ACTION BUTTONS ── */
  .productdetailspage__action-btns { display: flex; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
  .productdetailspage__act-btn {
    flex: 1; min-width: 140px; padding: 13px 20px;
    border-radius: 8px; border: none; font-size: 14px; font-weight: 600;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .2s; letter-spacing: .3px;
  }
  .productdetailspage__btn-cart {
    background: #fff0f0; color: var(--primary); border: 2px solid var(--primary);
  }
  .productdetailspage__btn-cart:hover { background: #ffd6d6; }
  .productdetailspage__btn-buy { background: var(--primary); color: #fff; }
  .productdetailspage__btn-buy:hover {
    background: var(--primary-d); box-shadow: 0 4px 14px rgba(190,3,24,.35);
  }

  /* ── META ROW ── */
  .productdetailspage__meta-row {
    display: flex; flex-direction: column; gap: 6px;
    font-size: 12px; color: var(--muted);
    padding: 12px 0; border-top: 1px solid var(--border); margin-top: 4px;
  }
  .productdetailspage__meta-row span strong { color: var(--text); }

  .productdetailspage__notice-box {
    background: #fffbeb; border: 1px solid #fcd34d;
    border-radius: 8px; padding: 10px 14px;
    display: flex; align-items: flex-start; gap: 8px;
    font-size: 12px; color: #92400e;
  }
  .productdetailspage__notice-box i { color: #f59e0b; margin-top: 2px; flex-shrink: 0; }

  /* ── SIDEBAR ── */
  .productdetailspage__sidebar-section { padding: 20px; display: flex; flex-direction: column; gap: 16px; }
  .productdetailspage__card { border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
  .productdetailspage__card-head {
    background: #f9fafb; padding: 12px 16px;
    font-size: 13px; font-weight: 700; color: var(--text);
    border-bottom: 1px solid var(--border);
  }
  .productdetailspage__card-body { padding: 16px; }
  .productdetailspage__del-option {
    display: flex; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f3f4f6;
  }
  .productdetailspage__del-option:last-child { border-bottom: none; padding-bottom: 0; }
  .productdetailspage__del-icon {
    width: 32px; height: 32px; background: #fff0f0; border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    color: var(--primary); font-size: 14px; flex-shrink: 0;
  }
  .productdetailspage__del-body { flex: 1; }
  .productdetailspage__del-title { font-size: 13px; font-weight: 600; color: var(--text); }
  .productdetailspage__del-date { font-size: 11px; color: var(--muted); margin-top: 2px; line-height: 1.5; }
  .productdetailspage__seller-head { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
  .productdetailspage__seller-avatar {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, var(--primary) 0%, #e05060 100%);
    border-radius: 10px; display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 16px; color: #fff; flex-shrink: 0;
  }
  .productdetailspage__seller-name { font-size: 13px; font-weight: 700; color: var(--text); }
  .productdetailspage__seller-verified {
    display: flex; align-items: center; gap: 4px; font-size: 11px; color: var(--green); margin-top: 3px;
  }

  /* ── TABS ── */
  .productdetailspage__tabs-section {
    background: var(--white); margin-top: 16px;
    border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;
  }
  .productdetailspage__tab-nav {
    display: flex; border-bottom: 2px solid var(--border); overflow-x: auto;
  }
  .productdetailspage__tab-btn {
    padding: 14px 22px; border: none; background: none;
    font-size: 13px; font-weight: 600; color: var(--muted);
    border-bottom: 3px solid transparent; margin-bottom: -2px;
    white-space: nowrap; transition: all .2s; display: flex; align-items: center; gap: 6px;
  }
  .productdetailspage__tab-btn:hover { color: var(--text); }
  .productdetailspage__tab-btn--active { color: var(--primary); border-bottom-color: var(--primary); }
  .productdetailspage__tab-content { display: none; padding: 28px 24px; }
  .productdetailspage__tab-content--active { display: block; }

  .productdetailspage__desc-text { color: #4b5563; line-height: 1.85; font-size: 14px; }
  .productdetailspage__desc-text p { margin-bottom: 14px; }
  .productdetailspage__desc-text p:last-child { margin-bottom: 0; }

  /* ── SPECS ── */
  .productdetailspage__spec-section {
    border: 1px solid var(--border); border-radius: 8px; overflow: hidden; margin-bottom: 16px;
  }
  .productdetailspage__spec-section:last-child { margin-bottom: 0; }
  .productdetailspage__spec-head {
    background: #f8f8f8; padding: 10px 16px; font-size: 11px; font-weight: 700;
    text-transform: uppercase; color: var(--muted); letter-spacing: .8px; border-bottom: 1px solid var(--border);
  }
  .productdetailspage__spec-row {
    display: flex; padding: 10px 16px; border-bottom: 1px solid #f3f4f6; font-size: 13px;
  }
  .productdetailspage__spec-row:last-child { border-bottom: none; }
  .productdetailspage__spec-key { width: 200px; flex-shrink: 0; color: var(--muted); font-weight: 600; }
  .productdetailspage__spec-val { flex: 1; color: var(--text); }

  /* ── REVIEWS ── */
  .productdetailspage__no-reviews { text-align: center; color: var(--muted); font-size: 14px; padding: 30px 0; }

  /* ── RELATED PRODUCTS ── */
  .productdetailspage__products-section {
    margin-top: 16px; border-radius: var(--radius);
    box-shadow: var(--shadow); background: var(--white); padding: 24px;
  }
  .productdetailspage__section-header {
    display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;
  }
  .productdetailspage__section-title { font-family: 'DM Serif Display', serif; font-size: 18px; color: var(--text); }
  .productdetailspage__see-all { color: var(--primary); font-size: 13px; font-weight: 600; }
  .productdetailspage__see-all:hover { text-decoration: underline; }
  .productdetailspage__products-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(175px,1fr)); gap: 16px;
  }
  .productdetailspage__prod-card {
    background: var(--white); border: 1px solid var(--border);
    border-radius: 10px; overflow: hidden; transition: all .25s;
    cursor: pointer; position: relative; display: flex; flex-direction: column;
  }
  .productdetailspage__prod-card:hover {
    transform: translateY(-4px); box-shadow: 0 10px 24px rgba(0,0,0,.12); border-color: #f5a0aa;
  }
  .productdetailspage__prod-img-wrap {
    position: relative; aspect-ratio: 1/1; background: #f3f4f6; overflow: hidden;
  }
  .productdetailspage__prod-img-wrap img {
    width: 100%; height: 100%; object-fit: cover; transition: transform .35s ease;
  }
  .productdetailspage__prod-card:hover .productdetailspage__prod-img-wrap img { transform: scale(1.06); }
  .productdetailspage__prod-discount {
    position: absolute; top: 8px; right: 8px;
    width: 42px; height: 42px; border-radius: 50%;
    background: var(--primary); color: #fff;
    font-size: 10px; font-weight: 800; line-height: 1.2;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    text-align: center; box-shadow: 0 2px 6px rgba(190,3,24,.45); z-index: 2;
  }
  .productdetailspage__prod-info { padding: 10px 10px 12px; flex: 1; display: flex; flex-direction: column; gap: 5px; }
  .productdetailspage__prod-name {
    font-size: 12px; color: var(--text); line-height: 1.45;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex: 1;
  }
  .productdetailspage__prod-price-row { display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap; }
  .productdetailspage__prod-old-price { font-size: 11px; color: var(--muted); text-decoration: line-through; }
  .productdetailspage__prod-price { font-size: 14px; font-weight: 700; color: var(--primary); }
  .productdetailspage__prod-order-btn {
    display: flex; width: 100%; padding: 9px 0;
    background: var(--primary); color: #fff;
    font-size: 13px; font-weight: 700;
    border: none; border-radius: 0 0 9px 9px;
    letter-spacing: .3px; transition: background .2s, box-shadow .2s;
    align-items: center; justify-content: center; gap: 6px;
  }
  .productdetailspage__prod-order-btn:hover {
    background: var(--primary-d); box-shadow: 0 4px 12px rgba(190,3,24,.35);
  }

  /* ── ANIMATIONS ── */
  @keyframes productdetailspage-fadeIn {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .productdetailspage__product-page,
  .productdetailspage__tabs-section,
  .productdetailspage__products-section {
    animation: productdetailspage-fadeIn .4s ease both;
  }

  /* ── RESPONSIVE ── */
  @media(max-width:768px){
    .productdetailspage__products-grid { grid-template-columns: repeat(auto-fill, minmax(145px,1fr)); gap: 12px; }
  }
  @media(max-width:480px){
    .productdetailspage__product-title { font-size: 17px; }
    .productdetailspage__current-price { font-size: 24px; }
    .productdetailspage__action-btns { flex-direction: column; }
    .productdetailspage__flash-banner { flex-direction: column; align-items: flex-start; }
    .productdetailspage__products-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  }
</style>

{{-- ── PHP VARIABLES ── --}}
@php
  $featureImg = $product->feature_image
                ? asset('uploads/products/' . $product->feature_image)
                : asset('images/placeholder.png');

  $gallery = collect($product->gallery_images ?? [])
               ->map(fn($g) => [
                   'url'   => asset('uploads/products/' . (is_array($g) ? $g['image'] : $g)),
                   'color' => is_array($g) ? ($g['color'] ?? null) : null,
                   'size'  => is_array($g) ? ($g['size']  ?? null) : null,
               ])->values();

  $allImages   = collect([['url' => $featureImg, 'color' => null, 'size' => null]])
                   ->merge($gallery)->values();
  $totalImages = $allImages->count();

  $discountPct   = ($product->discount_price && $product->current_price > 0)
                   ? round((($product->current_price - $product->discount_price) / $product->current_price) * 100)
                   : null;
  $displayPrice  = $product->discount_price ?? $product->current_price;
  $originalPrice = $product->discount_price ? $product->current_price : null;

  $variants = collect($product->variants ?? []);
  $colors   = $variants->pluck('color')->filter()->unique()->values();
  $sizes    = $variants->pluck('size')->filter()->unique()->values();

  $tags        = $product->tags ?? [];
  $featureTags = $product->feature_tags ?? [];

  $stockLabel = $product->is_unlimited
                ? 'In Stock'
                : ($product->stock > 0 ? $product->stock . ' items left' : 'Out of Stock');

  $stockPct = $product->is_unlimited ? 100
              : ($product->stock > 0
                 ? min(100, round($product->stock / max(1, $product->stock + 10) * 100))
                 : 0);

  $categoryName = $product->category->category_name ?? '';
  $subCatName   = $product->subCategory->sub_name ?? '';

  $shareUrl   = url()->current();
  $shareTitle = urlencode($product->name);

  // YouTube ID extraction
  preg_match('/(?:v=|youtu\.be\/|embed\/)([a-zA-Z0-9_-]{11})/', $product->youtube_url ?? '', $ytMatch);
  $ytId = $ytMatch[1] ?? null;
@endphp

<div class="productdetailspage">

  {{-- ── BREADCRUMB ── --}}
  <div class="productdetailspage__top-bar">
    <div class="productdetailspage__container">
      <nav class="productdetailspage__breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        @if($categoryName)
          <span class="productdetailspage__breadcrumb-sep">›</span>
          <a href="#">{{ $categoryName }}</a>
        @endif
        @if($subCatName)
          <span class="productdetailspage__breadcrumb-sep">›</span>
          <a href="#">{{ $subCatName }}</a>
        @endif
        <span class="productdetailspage__breadcrumb-sep">›</span>
        <span class="productdetailspage__breadcrumb-current">{{ Str::limit($product->name, 60) }}</span>
      </nav>
    </div>
  </div>

  <div class="productdetailspage__container">

    {{-- ── PRODUCT CARD ── --}}
    <div class="productdetailspage__product-page">
      <div class="productdetailspage__product-grid">

        {{-- ── LEFT: GALLERY ── --}}
        <div class="productdetailspage__gallery-section">

          <div class="productdetailspage__main-image-wrap" id="pdpMainWrap">

            {{-- Wishlist Button --}}
            <button class="productdetailspage__wishlist-btn" id="pdpWishlistBtn" title="Add to Wishlist">
              <i class="bi bi-heart"></i>
            </button>

            {{-- Vendor Badge --}}
            @if($product->vendor)
            <div class="productdetailspage__badge-row">
              <span class="productdetailspage__badge productdetailspage__badge--vendor">
                {{ $product->vendor }}
              </span>
            </div>
            @endif

            {{-- Main Image --}}
            <img id="pdpMainImage"
                 class="productdetailspage__main-img"
                 src="{{ $featureImg }}"
                 alt="{{ $product->name }}"/>

            <div class="productdetailspage__zoom-hint">
              <i class="fas fa-search-plus" style="font-size:10px"></i> Click to zoom
            </div>

            <div class="productdetailspage__img-counter">
              <i class="fas fa-camera"></i>
              <span id="pdpImgCounter">1 / {{ $totalImages }}</span>
            </div>

            {{-- Hover Popup --}}
            <div class="productdetailspage__img-hover-popup">
              <div class="productdetailspage__popup-title">{{ $product->name }}</div>
              <div class="productdetailspage__popup-meta">
                <span class="productdetailspage__popup-price-current">
                  ৳{{ number_format($displayPrice, 2) }}
                </span>
                @if($originalPrice)
                  <span class="productdetailspage__popup-price-old">
                    ৳{{ number_format($originalPrice, 2) }}
                  </span>
                @endif
                @if($discountPct)
                  <span class="productdetailspage__popup-discount-chip">−{{ $discountPct }}%</span>
                @endif
              </div>
              <div class="productdetailspage__popup-row">
                <div class="productdetailspage__popup-stock">
                  <i class="fas fa-fire"></i> {{ $stockLabel }}
                </div>
              </div>
              <hr class="productdetailspage__popup-divider"/>
              <div class="productdetailspage__popup-info-row">
                <div class="productdetailspage__popup-info-item">
                  <i class="fas fa-tag"></i>
                  <span>SKU: {{ $product->sku ?? 'N/A' }}</span>
                </div>
                @if($product->return_policy)
                <div class="productdetailspage__popup-info-item">
                  <i class="fas fa-undo"></i>
                  <span>Return Policy</span>
                </div>
                @endif
              </div>
            </div>

          </div>{{-- /main-image-wrap --}}

          {{-- Thumbnails --}}
          <div class="productdetailspage__thumbnails" id="pdpThumbnails">
            @foreach($allImages as $idx => $img)
            <div class="productdetailspage__thumb {{ $idx === 0 ? 'productdetailspage__thumb--active' : '' }}"
                 data-idx="{{ $idx }}"
                 data-src="{{ $img['url'] }}">
              <img src="{{ $img['url'] }}" alt="Thumb {{ $idx + 1 }}" loading="lazy"/>
            </div>
            @endforeach
          </div>

          {{-- Share Row --}}
          <div class="productdetailspage__share-row">
            <span class="productdetailspage__share-label">Share:</span>
            <div class="productdetailspage__social-icons">
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                 target="_blank" rel="noopener"
                 class="productdetailspage__soc-btn productdetailspage__soc-btn--fb" title="Facebook">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="https://www.linkedin.com/shareArticle?url={{ $shareUrl }}&title={{ $shareTitle }}"
                 target="_blank" rel="noopener"
                 class="productdetailspage__soc-btn productdetailspage__soc-btn--li" title="LinkedIn">
                <i class="fab fa-linkedin-in"></i>
              </a>
              <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
                 target="_blank" rel="noopener"
                 class="productdetailspage__soc-btn productdetailspage__soc-btn--tw" title="Twitter/X">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}"
                 target="_blank" rel="noopener"
                 class="productdetailspage__soc-btn productdetailspage__soc-btn--wa" title="WhatsApp">
                <i class="fab fa-whatsapp"></i>
              </a>
            </div>
          </div>

        </div>{{-- /GALLERY --}}

        {{-- ── MIDDLE: PRODUCT INFO ── --}}
        <div class="productdetailspage__product-info-section">

          {{-- Feature Tags --}}
          @if(!empty($featureTags))
          <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:10px;">
            @foreach($featureTags as $ft)
            <span style="background:{{ $ft['color'] ?? '#be0318' }};color:#fff;font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;letter-spacing:.4px;">
              {{ $ft['keyword'] }}
            </span>
            @endforeach
          </div>
          @endif

          <h1 class="productdetailspage__product-title">{{ $product->name }}</h1>

          <div class="productdetailspage__brand-row">
            <span class="productdetailspage__brand-label">SKU:</span>
            <span style="font-weight:600;color:var(--text)">{{ $product->sku ?? 'N/A' }}</span>
            @if($product->vendor)
              <span class="productdetailspage__divider-dot">|</span>
              <span class="productdetailspage__brand-label">Vendor:</span>
              <span style="font-weight:600;color:var(--text)">{{ $product->vendor }}</span>
            @endif
          </div>

          <div class="productdetailspage__viewers-row">
            <i class="fas fa-eye"></i>
            <span>
              <span class="productdetailspage__viewers-count" id="pdpViewersCount">61</span>
              people are viewing this right now
            </span>
          </div>

          {{-- Flash Sale Timer --}}
          @if($product->discount_price)
          <div class="productdetailspage__flash-banner">
            <div class="productdetailspage__flash-left">
              <i class="fas fa-bolt"></i>
              <span>Special Offer</span>
            </div>
            <div class="productdetailspage__flash-timer">
              <span class="productdetailspage__ends-label">
                <i class="far fa-clock"></i> Ends in:
              </span>
              <span class="productdetailspage__timer-box" id="pdpTimerH">01h</span>
              <span class="productdetailspage__timer-box" id="pdpTimerM">39m</span>
              <span class="productdetailspage__timer-box" id="pdpTimerS">54s</span>
            </div>
          </div>
          @endif

          {{-- Price Block --}}
          <div class="productdetailspage__price-block">
            <div class="productdetailspage__price-row">
              <span class="productdetailspage__current-price">
                ৳{{ number_format($displayPrice, 2) }}
              </span>
              @if($originalPrice)
                <span class="productdetailspage__original-price">
                  ৳{{ number_format($originalPrice, 2) }}
                </span>
              @endif
              @if($discountPct)
                <span class="productdetailspage__discount-chip">−{{ $discountPct }}%</span>
              @endif
            </div>
            <div class="productdetailspage__stock-info">
              <span class="productdetailspage__stock-count">{{ $stockLabel }}</span>
              @if(!$product->is_unlimited)
              <div class="productdetailspage__stock-bar">
                <div class="productdetailspage__stock-fill" style="width:{{ $stockPct }}%"></div>
              </div>
              @endif
            </div>
          </div>

          {{-- Color Options --}}
          @if($colors->count())
          <div class="productdetailspage__option-group">
            <label class="productdetailspage__option-label">Color:</label>
            <div class="productdetailspage__option-btns">
              @foreach($colors as $i => $color)
              <button class="productdetailspage__opt-btn {{ $i === 0 ? 'productdetailspage__opt-btn--active' : '' }}"
                      data-group="color">{{ $color }}</button>
              @endforeach
            </div>
          </div>
          @endif

          {{-- Size Options --}}
          @if($sizes->count())
          <div class="productdetailspage__option-group">
            <label class="productdetailspage__option-label">Size:</label>
            <div class="productdetailspage__option-btns">
              @foreach($sizes as $i => $size)
              <button class="productdetailspage__opt-btn {{ $i === 0 ? 'productdetailspage__opt-btn--active' : '' }}"
                      data-group="size">{{ $size }}</button>
              @endforeach
            </div>
          </div>
          @endif

          {{-- Quantity --}}
          <div class="productdetailspage__qty-group">
            <label class="productdetailspage__option-label">Quantity:</label>
            <div class="productdetailspage__qty-row">
              <div class="productdetailspage__qty-selector">
                <button class="productdetailspage__qty-btn" id="pdpQtyDec">
                  <i class="fas fa-minus"></i>
                </button>
                <input type="text" class="productdetailspage__qty-input"
                       id="pdpQtyInput" value="1" readonly/>
                <button class="productdetailspage__qty-btn" id="pdpQtyInc">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
              @if(!$product->is_unlimited && $product->stock > 0)
              <div class="productdetailspage__stock-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $product->stock }} units available</span>
              </div>
              @endif
            </div>
          </div>

          {{-- Action Buttons --}}
          <div class="productdetailspage__action-btns">
            @if(!$product->is_unlimited && $product->stock <= 0)
              <button class="productdetailspage__act-btn productdetailspage__btn-cart"
                      disabled style="opacity:.5;cursor:not-allowed;">
                <i class="fas fa-times-circle"></i> Out of Stock
              </button>
            @else
              <button class="productdetailspage__act-btn productdetailspage__btn-cart"
                      id="pdpAddCartBtn"
                      data-id="{{ $product->id }}"
                      data-slug="{{ $product->slug }}">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
              <button class="productdetailspage__act-btn productdetailspage__btn-buy"
                      id="pdpBuyNowBtn"
                      data-id="{{ $product->id }}"
                      data-slug="{{ $product->slug }}">
                <i class="fas fa-shopping-bag"></i> Buy Now
              </button>
            @endif
          </div>

          {{-- Product Meta --}}
          <div class="productdetailspage__meta-row">
            @if($categoryName)
            <span><strong>Category:</strong> {{ $categoryName }}</span>
            @endif
            @if($subCatName)
            <span><strong>Sub-Category:</strong> {{ $subCatName }}</span>
            @endif
            @if(!empty($tags))
            <span>
              <strong>Tags:</strong>
              @foreach($tags as $tag)
                <a href="#" style="color:var(--primary);margin-right:4px">#{{ $tag }}</a>
              @endforeach
            </span>
            @endif
            <span>
              <strong>Product Type:</strong> {{ ucfirst($product->product_type ?? 'N/A') }}
            </span>
          </div>

          {{-- Return Policy --}}
          @if($product->return_policy)
          <div class="productdetailspage__notice-box" style="margin-top:12px">
            <i class="fas fa-undo"></i>
            <span>{{ $product->return_policy }}</span>
          </div>
          @endif

        </div>{{-- /PRODUCT INFO --}}

        {{-- ── RIGHT: SIDEBAR ── --}}
        <div class="productdetailspage__sidebar-section">

          {{-- Delivery Card --}}
          <div class="productdetailspage__card">
            <div class="productdetailspage__card-head">
              <i class="fas fa-truck" style="margin-right:6px;color:var(--primary)"></i>
              Delivery & Shipping
            </div>
            <div class="productdetailspage__card-body">

              <div class="productdetailspage__del-option">
                <div class="productdetailspage__del-icon"><i class="fas fa-truck"></i></div>
                <div class="productdetailspage__del-body">
                  <div class="productdetailspage__del-title">Door Delivery</div>
                  <div class="productdetailspage__del-date">Standard delivery within 3–7 working days</div>
                </div>
              </div>

              <div class="productdetailspage__del-option">
                <div class="productdetailspage__del-icon"><i class="fas fa-store"></i></div>
                <div class="productdetailspage__del-body">
                  <div class="productdetailspage__del-title">Pickup Available</div>
                  <div class="productdetailspage__del-date">Contact seller for pickup details</div>
                </div>
              </div>

              @if($product->return_policy)
              <div class="productdetailspage__del-option">
                <div class="productdetailspage__del-icon"><i class="fas fa-undo"></i></div>
                <div class="productdetailspage__del-body">
                  <div class="productdetailspage__del-title">Return Policy</div>
                  <div class="productdetailspage__del-date">
                    {{ Str::limit($product->return_policy, 80) }}
                  </div>
                </div>
              </div>
              @endif

              @if($product->product_type === 'digital')
              <div class="productdetailspage__del-option">
                <div class="productdetailspage__del-icon"><i class="fas fa-download"></i></div>
                <div class="productdetailspage__del-body">
                  <div class="productdetailspage__del-title">Instant Download</div>
                  <div class="productdetailspage__del-date">Available immediately after purchase</div>
                </div>
              </div>
              @endif

            </div>
          </div>

          {{-- Seller Card --}}
          @if($product->vendor)
          <div class="productdetailspage__card">
            <div class="productdetailspage__card-head">
              <i class="fas fa-store" style="margin-right:6px;color:var(--primary)"></i>Seller
            </div>
            <div class="productdetailspage__card-body">
              <div class="productdetailspage__seller-head">
                <div class="productdetailspage__seller-avatar">
                  {{ strtoupper(substr($product->vendor, 0, 2)) }}
                </div>
                <div>
                  <div class="productdetailspage__seller-name">{{ $product->vendor }}</div>
                  <div class="productdetailspage__seller-verified">
                    <i class="fas fa-check-circle"></i> Verified Seller
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif

          {{-- YouTube Video Card --}}
          @if($ytId)
          <div class="productdetailspage__card">
            <div class="productdetailspage__card-head">
              <i class="fab fa-youtube" style="margin-right:6px;color:#ef4444"></i>Product Video
            </div>
            <div class="productdetailspage__card-body" style="padding:0">
              <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;">
                <iframe
                  src="https://www.youtube.com/embed/{{ $ytId }}"
                  style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                  allowfullscreen loading="lazy">
                </iframe>
              </div>
            </div>
          </div>
          @endif

        </div>{{-- /SIDEBAR --}}

      </div>{{-- /product-grid --}}
    </div>{{-- /product-page --}}

    {{-- ── TABS ── --}}
    <div class="productdetailspage__tabs-section" id="pdpTabsSection">
      <div class="productdetailspage__tab-nav">
        <button class="productdetailspage__tab-btn productdetailspage__tab-btn--active"
                onclick="pdpOpenTab('description')">
          <i class="fas fa-align-left"></i> Product Description
        </button>
        <button class="productdetailspage__tab-btn"
                onclick="pdpOpenTab('specifications')">
          <i class="fas fa-list"></i> Specifications
        </button>
        <button class="productdetailspage__tab-btn"
                onclick="pdpOpenTab('reviews')">
          <i class="fas fa-star"></i> Reviews
        </button>
      </div>

      {{-- Description Tab --}}
      <div id="pdpDescription"
           class="productdetailspage__tab-content productdetailspage__tab-content--active">
        <div class="productdetailspage__desc-text">
          {!! nl2br(e($product->description)) !!}
        </div>
      </div>

      {{-- Specifications Tab --}}
      <div id="pdpSpecifications" class="productdetailspage__tab-content">
        <div class="productdetailspage__spec-section">
          <div class="productdetailspage__spec-head">Product Details</div>

          <div class="productdetailspage__spec-row">
            <span class="productdetailspage__spec-key">SKU</span>
            <span class="productdetailspage__spec-val">{{ $product->sku ?? 'N/A' }}</span>
          </div>
          <div class="productdetailspage__spec-row">
            <span class="productdetailspage__spec-key">Product Type</span>
            <span class="productdetailspage__spec-val">{{ ucfirst($product->product_type ?? 'N/A') }}</span>
          </div>
          @if($categoryName)
          <div class="productdetailspage__spec-row">
            <span class="productdetailspage__spec-key">Category</span>
            <span class="productdetailspage__spec-val">{{ $categoryName }}</span>
          </div>
          @endif
          @if($subCatName)
          <div class="productdetailspage__spec-row">
            <span class="productdetailspage__spec-key">Sub Category</span>
            <span class="productdetailspage__spec-val">{{ $subCatName }}</span>
          </div>
          @endif
          @if($product->vendor)
          <div class="productdetailspage__spec-row">
            <span class="productdetailspage__spec-key">Vendor / Brand</span>
            <span class="productdetailspage__spec-val">{{ $product->vendor }}</span>
          </div>
          @endif
          <div class="productdetailspage__spec-row">
            <span class="productdetailspage__spec-key">Availability</span>
            <span class="productdetailspage__spec-val">{{ $stockLabel }}</span>
          </div>
        </div>

        {{-- Variants --}}
        @if($variants->count())
        <div class="productdetailspage__spec-section" style="margin-top:12px">
          <div class="productdetailspage__spec-head">Available Variants</div>
          @foreach($variants as $v)
          <div class="productdetailspage__spec-row">
            <span class="productdetailspage__spec-key">
              {{ $v['size'] ?? '' }}
              {{ (!empty($v['size']) && !empty($v['color'])) ? ' / ' : '' }}
              {{ $v['color'] ?? '' }}
            </span>
            <span class="productdetailspage__spec-val">
              Stock: {{ $v['stock'] ?? 0 }}
              @if(!empty($v['price']))
                — Price: ৳{{ number_format($v['price'], 2) }}
              @endif
            </span>
          </div>
          @endforeach
        </div>
        @endif
      </div>

      {{-- Reviews Tab --}}
      <div id="pdpReviews" class="productdetailspage__tab-content">
        <div class="productdetailspage__no-reviews">
          <i class="fas fa-star" style="color:var(--gold);font-size:28px;display:block;margin-bottom:10px"></i>
          No reviews yet. Be the first to review this product!
        </div>
      </div>

    </div>{{-- /TABS --}}

    {{-- ── RELATED PRODUCTS ── --}}
    @if(!empty($relatedProducts) && $relatedProducts->count())
    <div class="productdetailspage__products-section">
      <div class="productdetailspage__section-header">
        <h2 class="productdetailspage__section-title">Related Products</h2>
        @if($categoryName)
          <a href="#" class="productdetailspage__see-all">See All →</a>
        @endif
      </div>
      <div class="productdetailspage__products-grid">
        @foreach($relatedProducts as $rp)
        @php
          $rpImg      = $rp->feature_image
                        ? asset('uploads/products/' . $rp->feature_image)
                        : asset('images/placeholder.png');
          $rpPrice    = $rp->discount_price ?? $rp->current_price;
          $rpOld      = $rp->discount_price ? $rp->current_price : null;
          $rpDiscount = ($rp->discount_price && $rp->current_price > 0)
                        ? round((($rp->current_price - $rp->discount_price) / $rp->current_price) * 100)
                        : null;
        @endphp
        <a href="{{ route('product.detail', $rp->slug) }}"
           class="productdetailspage__prod-card"
           style="text-decoration:none;color:inherit">
          <div class="productdetailspage__prod-img-wrap">
            @if($rpDiscount)
            <div class="productdetailspage__prod-discount">
              <span>{{ $rpDiscount }}%</span>
              <span style="font-size:8px">OFF</span>
            </div>
            @endif
            <img src="{{ $rpImg }}" alt="{{ $rp->name }}" loading="lazy"/>
          </div>
          <div class="productdetailspage__prod-info">
            <div class="productdetailspage__prod-name">{{ $rp->name }}</div>
            <div class="productdetailspage__prod-price-row">
              @if($rpOld)
              <span class="productdetailspage__prod-old-price">
                ৳{{ number_format($rpOld, 2) }}
              </span>
              @endif
              <span class="productdetailspage__prod-price">
                ৳{{ number_format($rpPrice, 2) }}
              </span>
            </div>
          </div>
          <div class="productdetailspage__prod-order-btn">
            <i class="fas fa-shopping-bag"></i> Order Now
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

  </div>{{-- /container --}}

  {{-- ── ZOOM OVERLAY ── --}}
  <div class="productdetailspage__zoom-overlay" id="pdpZoomOverlay">
    <button class="productdetailspage__zoom-close-btn" id="pdpZoomClose" title="Close (Esc)">
      <i class="fas fa-times"></i>
    </button>
    <button class="productdetailspage__zoom-nav-btn productdetailspage__zoom-prev"
            id="pdpZoomPrev" title="Previous">
      <i class="fas fa-chevron-left"></i>
    </button>
    <img id="pdpZoomImg" class="productdetailspage__zoom-overlay-img" src="" alt="Zoomed image"/>
    <button class="productdetailspage__zoom-nav-btn productdetailspage__zoom-next"
            id="pdpZoomNext" title="Next">
      <i class="fas fa-chevron-right"></i>
    </button>
    <div class="productdetailspage__zoom-counter" id="pdpZoomCounter">
      1 / {{ $totalImages }}
    </div>
  </div>

</div>{{-- /productdetailspage --}}

{{-- ── JAVASCRIPT ── --}}
<script>
(function () {
  'use strict';

  /* ── Image sources from PHP ── */
  const PDP_SRCS = @json($allImages->pluck('url')->values());
  let pdpCurrentIdx = 0;

  /* ── DOM refs ── */
  const pdpMainImage   = document.getElementById('pdpMainImage');
  const pdpImgCounter  = document.getElementById('pdpImgCounter');
  const pdpThumbs      = document.querySelectorAll('.productdetailspage__thumb');
  const pdpMainWrap    = document.getElementById('pdpMainWrap');
  const pdpZoomOverlay = document.getElementById('pdpZoomOverlay');
  const pdpZoomImg     = document.getElementById('pdpZoomImg');
  const pdpZoomClose   = document.getElementById('pdpZoomClose');
  const pdpZoomPrev    = document.getElementById('pdpZoomPrev');
  const pdpZoomNext    = document.getElementById('pdpZoomNext');
  const pdpZoomCounter = document.getElementById('pdpZoomCounter');

  /* ── Thumbnail switcher ── */
  pdpThumbs.forEach(function (t) {
    t.addEventListener('click', function (e) {
      e.stopPropagation();
      pdpThumbs.forEach(function (x) {
        x.classList.remove('productdetailspage__thumb--active');
      });
      t.classList.add('productdetailspage__thumb--active');
      pdpCurrentIdx    = parseInt(t.dataset.idx);
      pdpMainImage.src = t.dataset.src;
      pdpImgCounter.textContent = (pdpCurrentIdx + 1) + ' / ' + PDP_SRCS.length;
    });
  });

  /* ── Zoom open / close / navigate ── */
  function pdpOpenZoom(idx) {
    pdpCurrentIdx = idx;
    pdpZoomImg.src = PDP_SRCS[pdpCurrentIdx];
    pdpZoomCounter.textContent = (pdpCurrentIdx + 1) + ' / ' + PDP_SRCS.length;
    pdpZoomOverlay.classList.add('productdetailspage__zoom-overlay--active');
    document.body.style.overflow = 'hidden';
  }

  function pdpCloseZoom() {
    pdpZoomOverlay.classList.remove('productdetailspage__zoom-overlay--active');
    document.body.style.overflow = '';
  }

  function pdpZoomNavigate(dir) {
    pdpCurrentIdx = (pdpCurrentIdx + dir + PDP_SRCS.length) % PDP_SRCS.length;
    pdpZoomImg.style.opacity   = '0';
    pdpZoomImg.style.transform = 'scale(0.88)';
    setTimeout(function () {
      pdpZoomImg.src = PDP_SRCS[pdpCurrentIdx];
      pdpZoomCounter.textContent    = (pdpCurrentIdx + 1) + ' / ' + PDP_SRCS.length;
      pdpMainImage.src              = PDP_SRCS[pdpCurrentIdx];
      pdpImgCounter.textContent     = (pdpCurrentIdx + 1) + ' / ' + PDP_SRCS.length;
      pdpThumbs.forEach(function (t) {
        t.classList.toggle('productdetailspage__thumb--active',
          parseInt(t.dataset.idx) === pdpCurrentIdx);
      });
      pdpZoomImg.style.opacity   = '1';
      pdpZoomImg.style.transform = 'scale(1)';
    }, 160);
  }

  pdpZoomImg.style.transition = 'opacity .16s ease, transform .2s ease';

  /* ── Zoom events ── */
  pdpMainWrap.addEventListener('click', function () { pdpOpenZoom(pdpCurrentIdx); });
  pdpZoomClose.addEventListener('click', function (e) { e.stopPropagation(); pdpCloseZoom(); });
  pdpZoomOverlay.addEventListener('click', function (e) {
    if (e.target === pdpZoomOverlay) pdpCloseZoom();
  });
  pdpZoomImg.addEventListener('click', pdpCloseZoom);
  pdpZoomPrev.addEventListener('click', function (e) { e.stopPropagation(); pdpZoomNavigate(-1); });
  pdpZoomNext.addEventListener('click', function (e) { e.stopPropagation(); pdpZoomNavigate(1); });

  document.addEventListener('keydown', function (e) {
    if (!pdpZoomOverlay.classList.contains('productdetailspage__zoom-overlay--active')) return;
    if (e.key === 'Escape')     pdpCloseZoom();
    if (e.key === 'ArrowLeft')  pdpZoomNavigate(-1);
    if (e.key === 'ArrowRight') pdpZoomNavigate(1);
  });

  /* ── Wishlist toggle ── */
  var pdpWishlistBtn = document.getElementById('pdpWishlistBtn');
  pdpWishlistBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    var active = pdpWishlistBtn.classList.toggle('productdetailspage__wishlist-btn--active');
    pdpWishlistBtn.querySelector('i').className = active ? 'fas fa-heart' : 'bi bi-heart';
  });

  /* ── Option buttons (color / size) ── */
  document.querySelectorAll('.productdetailspage__opt-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var group = btn.dataset.group;
      document.querySelectorAll('.productdetailspage__opt-btn[data-group="' + group + '"]')
        .forEach(function (b) { b.classList.remove('productdetailspage__opt-btn--active'); });
      btn.classList.add('productdetailspage__opt-btn--active');
    });
  });

  /* ── Quantity ── */
  var pdpQtyInput = document.getElementById('pdpQtyInput');
  var PDP_MAX_QTY = {{ $product->is_unlimited ? 999 : max(1, $product->stock ?? 1) }};

  document.getElementById('pdpQtyInc').addEventListener('click', function () {
    var v = parseInt(pdpQtyInput.value);
    if (v < PDP_MAX_QTY) pdpQtyInput.value = v + 1;
  });
  document.getElementById('pdpQtyDec').addEventListener('click', function () {
    var v = parseInt(pdpQtyInput.value);
    if (v > 1) pdpQtyInput.value = v - 1;
  });

  /* ── Button flash feedback ── */
  function pdpFlashBtn(btn, msg, color) {
    var orig   = btn.innerHTML;
    var origBg = btn.style.background;
    btn.innerHTML      = '<i class="fas fa-check"></i> ' + msg;
    btn.style.opacity  = '.8';
    if (color) btn.style.background = color;
    setTimeout(function () {
      btn.innerHTML     = orig;
      btn.style.opacity = '1';
      if (color) btn.style.background = origBg;
    }, 2000);
  }

  var addCartBtn = document.getElementById('pdpAddCartBtn');
  var buyNowBtn  = document.getElementById('pdpBuyNowBtn');

  if (addCartBtn) {
    addCartBtn.addEventListener('click', function () {
      pdpFlashBtn(this, 'Added to Cart!', null);
      // TODO: AJAX cart logic
    });
  }

  if (buyNowBtn) {
    buyNowBtn.addEventListener('click', function () {
      pdpFlashBtn(this, 'Redirecting…', '#16a34a');
      // TODO: redirect to checkout
      // window.location.href = '/checkout?product={{ $product->id }}&qty=' + pdpQtyInput.value;
    });
  }

  /* ── Countdown timer (discount products only) ── */
  @if($product->discount_price)
  var pdpTotalSecs = 1 * 3600 + 39 * 60 + 54;
  function pdpUpdateTimer() {
    if (pdpTotalSecs <= 0) return;
    pdpTotalSecs--;
    var h = Math.floor(pdpTotalSecs / 3600);
    var m = Math.floor((pdpTotalSecs % 3600) / 60);
    var s = pdpTotalSecs % 60;
    document.getElementById('pdpTimerH').textContent = String(h).padStart(2, '0') + 'h';
    document.getElementById('pdpTimerM').textContent = String(m).padStart(2, '0') + 'm';
    document.getElementById('pdpTimerS').textContent = String(s).padStart(2, '0') + 's';
  }
  setInterval(pdpUpdateTimer, 1000);
  @endif

  /* ── Viewer count flicker ── */
  var pdpVc = document.getElementById('pdpViewersCount');
  setInterval(function () {
    var delta = Math.random() < .5 ? 1 : -1;
    var cur   = parseInt(pdpVc.textContent);
    pdpVc.textContent = Math.max(50, Math.min(80, cur + delta));
  }, 4000);

  /* ── Tabs ── */
  window.pdpOpenTab = function (id) {
    document.querySelectorAll('.productdetailspage__tab-content').forEach(function (c) {
      c.classList.remove('productdetailspage__tab-content--active');
    });
    document.querySelectorAll('.productdetailspage__tab-btn').forEach(function (b) {
      b.classList.remove('productdetailspage__tab-btn--active');
    });
    var map = { description: 0, specifications: 1, reviews: 2 };
    var capitalized = id.charAt(0).toUpperCase() + id.slice(1);
    document.getElementById('pdp' + capitalized)
            .classList.add('productdetailspage__tab-content--active');
    document.querySelectorAll('.productdetailspage__tab-btn')[map[id]]
            .classList.add('productdetailspage__tab-btn--active');
    document.getElementById('pdpTabsSection')
            .scrollIntoView({ behavior: 'smooth', block: 'start' });
  };

})();
</script>

@endsection
