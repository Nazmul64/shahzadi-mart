@extends('frontend.master')

@section('main-content')
<style>
/* ── RESET & BASE ── */
.pdp *, .pdp *::before, .pdp *::after { box-sizing: border-box; margin: 0; padding: 0; }
.pdp {
  --red:     #be0318;
  --red-d:   #960212;
  --red-bg:  #fff0f1;
  --text:    #1a1a1a;
  --muted:   #6b7280;
  --border:  #e5e7eb;
  --bg:      #f9fafb;
  --white:   #ffffff;
  --gold:    #f59e0b;
  --green:   #16a34a;
  --radius:  10px;
  --shadow:  0 2px 12px rgba(0,0,0,.08);
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  color: var(--text);
  background: var(--bg);
  line-height: 1.6;
}
.pdp a { color: inherit; text-decoration: none; }
.pdp img { display: block; max-width: 100%; }
.pdp button { cursor: pointer; font-family: inherit; border: none; }

/* ── LAYOUT ── */
.pdp__wrap  { max-width: 1280px; margin: 0 auto; padding: 0 20px; }

/* ── TOAST ── */
#pdp-toasts {
  position: fixed; top: 20px; right: 20px; z-index: 999999;
  display: flex; flex-direction: column; gap: 10px; pointer-events: none;
}
.pdp-toast {
  background: #fff; border-radius: 10px; padding: 14px 18px;
  font-size: 13px; font-weight: 600;
  display: flex; align-items: center; gap: 10px;
  box-shadow: 0 8px 32px rgba(0,0,0,.15); border-left: 4px solid;
  pointer-events: all; min-width: 260px; max-width: 360px;
  animation: toastIn .3s ease both;
}
.pdp-toast--success { border-color: #16a34a; color: #166534; }
.pdp-toast--error   { border-color: #be0318; color: #9b0000; }
.pdp-toast--info    { border-color: #2563eb; color: #1e40af; }
.pdp-toast.out      { animation: toastOut .3s ease forwards; }
@keyframes toastIn  { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
@keyframes toastOut { to   { opacity:0; transform:translateX(20px); } }

/* ── FLASH (server-side fallback) ── */
.pdp-alert {
  border-radius: 8px; padding: 10px 18px; font-size: 13px; font-weight: 600;
  display: flex; align-items: center; gap: 8px; margin: 10px 0;
}
.pdp-alert--success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
.pdp-alert--error   { background: #fff0f1; color: var(--red); border: 1px solid #fecdd3; }
.pdp-alert--info    { background: #eff6ff; color: #2563eb;  border: 1px solid #bfdbfe; }

/* ── BREADCRUMB ── */
.pdp__breadbar { background: var(--white); border-bottom: 1px solid var(--border); padding: 10px 0; font-size: 12px; color: var(--muted); }
.pdp__bread    { display: flex; align-items: center; flex-wrap: wrap; gap: 6px; }
.pdp__bread a  { color: var(--muted); transition: color .2s; }
.pdp__bread a:hover { color: var(--red); }
.pdp__bread-sep { color: #d1d5db; }
.pdp__bread-cur { color: var(--text); font-weight: 500; }

/* ── PRODUCT CARD ── */
.pdp__card {
  background: var(--white); margin-top: 16px;
  border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;
  animation: fadeUp .4s ease both;
}
@keyframes fadeUp { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }

.pdp__grid {
  display: grid;
  grid-template-columns: 420px 1fr 280px;
  align-items: start;
}
@media(max-width:1100px) {
  .pdp__grid { grid-template-columns: 1fr 1fr; }
  .pdp__sidebar { grid-column: 1/-1; }
}
@media(max-width:680px) { .pdp__grid { grid-template-columns: 1fr; } }

/* ── GALLERY ── */
.pdp__gallery { padding: 20px; }
.pdp__main-wrap {
  position: relative; border-radius: 8px; overflow: hidden;
  background: #f3f4f6; aspect-ratio: 1/1; cursor: zoom-in;
}
.pdp__main-img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform .45s ease; display: block;
}
.pdp__main-wrap:hover .pdp__main-img { transform: scale(1.07); }

.pdp__badge-row {
  position: absolute; top: 10px; left: 10px;
  display: flex; flex-direction: column; gap: 5px; z-index: 2;
}
.pdp__badge {
  font-size: 10px; font-weight: 700; padding: 3px 9px;
  border-radius: 4px; letter-spacing: .4px;
}
.pdp__badge--vendor { background: var(--green); color: #fff; }

.pdp__wish-btn {
  position: absolute; top: 10px; right: 10px; z-index: 2;
  width: 36px; height: 36px; border-radius: 50%;
  background: rgba(255,255,255,.9); border: none;
  display: flex; align-items: center; justify-content: center;
  font-size: 16px; color: #9ca3af;
  transition: all .2s; box-shadow: 0 2px 8px rgba(0,0,0,.1);
  cursor: pointer;
}
.pdp__wish-btn:hover { color: #ef4444; background: #fff; }
.pdp__wish-btn--active i { color: #ef4444; }

.pdp__img-counter {
  position: absolute; bottom: 10px; right: 10px;
  background: rgba(0,0,0,.5); color: #fff;
  font-size: 11px; padding: 3px 8px; border-radius: 20px;
  display: flex; align-items: center; gap: 5px; z-index: 3;
}
.pdp__zoom-hint {
  position: absolute; bottom: 10px; left: 10px;
  background: rgba(0,0,0,.4); color: #fff;
  font-size: 10px; padding: 3px 8px; border-radius: 20px;
  display: flex; align-items: center; gap: 4px;
  opacity: 0; transition: opacity .3s; z-index: 3; pointer-events: none;
}
.pdp__main-wrap:hover .pdp__zoom-hint { opacity: 1; }

.pdp__img-popup {
  position: absolute; bottom: 0; left: 0; right: 0;
  background: linear-gradient(to top, rgba(190,3,24,.96) 0%, rgba(190,3,24,.85) 55%, transparent 100%);
  color: #fff; padding: 28px 18px 18px;
  transform: translateY(100%); opacity: 0;
  transition: transform .38s cubic-bezier(.4,0,.2,1), opacity .38s ease;
  z-index: 10; pointer-events: none; border-radius: 0 0 8px 8px;
}
.pdp__main-wrap:hover .pdp__img-popup { transform: translateY(0); opacity: 1; }
.pdp__popup-title { font-size: 13px; font-weight: 700; line-height: 1.4; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.pdp__popup-meta  { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 10px; }
.pdp__popup-price { font-size: 20px; font-weight: 800; }
.pdp__popup-old   { font-size: 12px; color: rgba(255,255,255,.65); text-decoration: line-through; }
.pdp__popup-chip  { background: rgba(255,255,255,.25); border: 1px solid rgba(255,255,255,.5); font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px; }
.pdp__popup-stock { display: flex; align-items: center; gap: 5px; font-size: 11px; background: rgba(255,255,255,.15); padding: 3px 9px; border-radius: 20px; }
.pdp__popup-hr    { border: none; border-top: 1px solid rgba(255,255,255,.2); margin: 10px 0; }
.pdp__popup-meta2 { display: flex; gap: 14px; font-size: 11px; color: rgba(255,255,255,.85); flex-wrap: wrap; }
.pdp__popup-meta2 span { display: flex; align-items: center; gap: 5px; }

/* thumbnails */
.pdp__thumbs { display: flex; gap: 8px; margin-top: 12px; flex-wrap: wrap; }
.pdp__thumb {
  width: 60px; height: 60px; border-radius: 6px; overflow: hidden;
  border: 2px solid transparent; cursor: pointer; flex-shrink: 0;
  transition: border-color .2s, transform .2s;
}
.pdp__thumb img { width: 100%; height: 100%; object-fit: cover; }
.pdp__thumb--active { border-color: var(--red); }
.pdp__thumb:hover   { border-color: #f5a0aa; transform: translateY(-2px); }

/* share */
.pdp__share { margin-top: 16px; display: flex; align-items: center; gap: 10px; }
.pdp__share-label { font-size: 12px; color: var(--muted); font-weight: 500; }
.pdp__soc-btn {
  width: 32px; height: 32px; border-radius: 50%; border: none;
  display: flex; align-items: center; justify-content: center;
  font-size: 13px; color: #fff; transition: transform .2s, opacity .2s;
}
.pdp__soc-btn:hover { transform: scale(1.15); opacity: .88; }
.pdp__soc--fb { background: #1877f2; }
.pdp__soc--tw { background: #1da1f2; }
.pdp__soc--li { background: #0a66c2; }
.pdp__soc--wa { background: #25d366; }

/* ── MIDDLE: PRODUCT INFO ── */
.pdp__info { padding: 24px; border-left: 1px solid var(--border); border-right: 1px solid var(--border); }
.pdp__title { font-family: 'DM Serif Display', serif; font-size: 20px; line-height: 1.35; margin-bottom: 12px; }
.pdp__meta-row  { display: flex; align-items: center; gap: 8px; font-size: 13px; margin-bottom: 10px; flex-wrap: wrap; }
.pdp__meta-muted { color: var(--muted); }
.pdp__viewers { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--muted); margin-bottom: 10px; }
.pdp__viewers i { color: #10b981; }
.pdp__viewers-n { font-weight: 600; color: var(--text); }

.pdp__flash {
  background: linear-gradient(135deg, #1a1a2e, #16213e);
  border-radius: 8px; padding: 12px 16px;
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 18px; flex-wrap: wrap; gap: 10px;
}
.pdp__flash-left { display: flex; align-items: center; gap: 8px; }
.pdp__flash-left i { color: #facc15; font-size: 16px; }
.pdp__flash-left span { color: #fff; font-weight: 700; font-size: 14px; letter-spacing: .5px; }
.pdp__flash-right { display: flex; align-items: center; gap: 6px; }
.pdp__flash-ends { color: #94a3b8; font-size: 11px; }
.pdp__timer-box { background: #facc15; color: #1a1a2e; font-weight: 800; font-size: 13px; padding: 4px 8px; border-radius: 5px; min-width: 36px; text-align: center; }

/* price */
.pdp__price-block { margin-bottom: 18px; }
.pdp__price-row   { display: flex; align-items: baseline; gap: 10px; flex-wrap: wrap; margin-bottom: 6px; }
.pdp__price-cur   { font-size: 28px; font-weight: 700; color: var(--red); }
.pdp__price-old   { font-size: 16px; color: var(--muted); text-decoration: line-through; }
.pdp__price-chip  { background: var(--red-bg); color: var(--red); font-size: 12px; font-weight: 700; padding: 2px 8px; border-radius: 20px; border: 1px solid #f5a0aa; }
.pdp__stock-row   { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
.pdp__stock-label { font-size: 12px; color: var(--red); font-weight: 600; }
.pdp__stock-bar   { height: 4px; background: #fee2e2; border-radius: 2px; flex: 1; }
.pdp__stock-fill  { height: 100%; background: var(--red); border-radius: 2px; }

/* options */
.pdp__opt-group  { margin-bottom: 14px; }
.pdp__opt-label  { font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 6px; margin-bottom: 8px; }
.pdp__opt-tag    { font-size: 10px; font-weight: 500; color: var(--muted); background: #f3f4f6; padding: 2px 7px; border-radius: 10px; }
.pdp__opt-selected { font-size: 12px; color: var(--red); font-weight: 600; margin-left: 4px; }
.pdp__opt-btns   { display: flex; gap: 8px; flex-wrap: wrap; }
.pdp__opt-btn {
  padding: 6px 14px; border-radius: 6px;
  border: 1.5px solid var(--border);
  background: var(--white); font-size: 13px; font-weight: 500;
  color: var(--text); transition: all .2s;
}
.pdp__opt-btn:hover         { border-color: var(--red); color: var(--red); }
.pdp__opt-btn--active       { border-color: var(--red); background: var(--red-bg); color: var(--red); font-weight: 600; }

/* quantity */
.pdp__qty-group { margin-bottom: 18px; }
.pdp__qty-row   { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.pdp__qty-sel   { display: flex; align-items: center; border: 1.5px solid var(--border); border-radius: 8px; overflow: hidden; }
.pdp__qty-btn   { width: 36px; height: 36px; background: #f9fafb; font-size: 14px; color: var(--text); transition: background .2s; border: none; cursor: pointer; }
.pdp__qty-btn:hover { background: #f3f4f6; }
.pdp__qty-input { width: 48px; height: 36px; border: none; border-left: 1.5px solid var(--border); border-right: 1.5px solid var(--border); text-align: center; font-size: 14px; font-weight: 600; font-family: inherit; background: #fff; }
.pdp__stock-alert { display: flex; align-items: center; gap: 5px; font-size: 12px; color: var(--red); font-weight: 500; }

/* action btns */
.pdp__actions { display: flex; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
.pdp__btn {
  flex: 1; min-width: 140px; padding: 13px 20px;
  border-radius: 8px; border: none; font-size: 14px; font-weight: 600;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: all .2s; letter-spacing: .3px; text-decoration: none; cursor: pointer; font-family: inherit;
}
.pdp__btn--cart { background: var(--red-bg); color: var(--red); border: 2px solid var(--red); }
.pdp__btn--cart:hover { background: #ffd6d6; }
.pdp__btn--buy  { background: var(--red); color: #fff; }
.pdp__btn--buy:hover { background: var(--red-d); box-shadow: 0 4px 14px rgba(190,3,24,.35); }
.pdp__btn:disabled { opacity: .65; cursor: not-allowed; pointer-events: none; }

.pdp-spinner {
  width: 16px; height: 16px; border: 2px solid currentColor;
  border-top-color: transparent; border-radius: 50%;
  animation: spin .6s linear infinite; flex-shrink: 0;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* product meta */
.pdp__product-meta { display: flex; flex-direction: column; gap: 6px; font-size: 12px; color: var(--muted); padding: 12px 0; border-top: 1px solid var(--border); margin-top: 4px; }
.pdp__product-meta strong { color: var(--text); }
.pdp__notice { background: #fffbeb; border: 1px solid #fcd34d; border-radius: 8px; padding: 10px 14px; display: flex; align-items: flex-start; gap: 8px; font-size: 12px; color: #92400e; margin-top: 12px; }
.pdp__notice i { color: #f59e0b; margin-top: 2px; flex-shrink: 0; }

/* feature tags */
.pdp__feature-tags { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 10px; }
.pdp__feature-tag  { font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 20px; letter-spacing: .4px; }

/* ── SIDEBAR ── */
.pdp__sidebar { padding: 20px; display: flex; flex-direction: column; gap: 16px; }
.pdp__s-card  { border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
.pdp__card-head { background: #f9fafb; padding: 12px 16px; font-size: 13px; font-weight: 700; border-bottom: 1px solid var(--border); }
.pdp__card-body { padding: 16px; }
.pdp__del-row   { display: flex; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f3f4f6; }
.pdp__del-row:last-child { border-bottom: none; padding-bottom: 0; }
.pdp__del-icon  { width: 32px; height: 32px; background: var(--red-bg); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: var(--red); font-size: 14px; flex-shrink: 0; }
.pdp__del-title { font-size: 13px; font-weight: 600; }
.pdp__del-date  { font-size: 11px; color: var(--muted); margin-top: 2px; line-height: 1.5; }
.pdp__seller-head { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
.pdp__seller-ava  { width: 44px; height: 44px; background: linear-gradient(135deg, var(--red), #e05060); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 16px; color: #fff; flex-shrink: 0; }
.pdp__seller-name { font-size: 13px; font-weight: 700; }
.pdp__seller-ver  { display: flex; align-items: center; gap: 4px; font-size: 11px; color: var(--green); margin-top: 3px; }

/* ── TABS ── */
.pdp__tabs { background: var(--white); margin-top: 16px; border-radius: var(--radius); box-shadow: var(--shadow); animation: fadeUp .4s .1s ease both; }
.pdp__tab-nav { display: flex; border-bottom: 2px solid var(--border); overflow-x: auto; }
.pdp__tab-btn {
  padding: 14px 22px; border: none; background: none; font-family: inherit;
  font-size: 13px; font-weight: 600; color: var(--muted);
  border-bottom: 3px solid transparent; margin-bottom: -2px;
  white-space: nowrap; transition: all .2s; display: flex; align-items: center; gap: 6px; cursor: pointer;
}
.pdp__tab-btn:hover { color: var(--text); }
.pdp__tab-btn--active { color: var(--red); border-bottom-color: var(--red); }
.pdp__tab-pane { display: none; padding: 28px 24px; }
.pdp__tab-pane--active { display: block; }
.pdp__desc { color: #4b5563; line-height: 1.85; font-size: 14px; }
.pdp__desc p { margin-bottom: 14px; }
.pdp__desc p:last-child { margin-bottom: 0; }

/* specs */
.pdp__spec-section { border: 1px solid var(--border); border-radius: 8px; overflow: hidden; margin-bottom: 12px; }
.pdp__spec-head { background: #f8f8f8; padding: 10px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--muted); letter-spacing: .8px; border-bottom: 1px solid var(--border); }
.pdp__spec-row  { display: flex; padding: 10px 16px; border-bottom: 1px solid #f3f4f6; font-size: 13px; }
.pdp__spec-row:last-child { border-bottom: none; }
.pdp__spec-k { width: 200px; flex-shrink: 0; color: var(--muted); font-weight: 600; }
.pdp__spec-v { flex: 1; }

/* ══════════════════════════════════════
   REVIEWS TAB — COMPLETE SECTION
══════════════════════════════════════ */

/* Overall rating summary box */
.pdp-rev-summary {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 24px 28px;
    display: flex;
    align-items: center;
    gap: 32px;
    margin-bottom: 28px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    flex-wrap: wrap;
}
.pdp-rev-big-score {
    text-align: center;
    flex-shrink: 0;
    min-width: 100px;
}
.pdp-rev-big-num {
    font-family: 'Playfair Display', serif;
    font-size: 58px;
    font-weight: 900;
    color: var(--text);
    line-height: 1;
    margin-bottom: 8px;
}
.pdp-rev-big-stars {
    display: flex;
    gap: 4px;
    justify-content: center;
    margin-bottom: 6px;
}
.pdp-rev-big-stars i { font-size: 18px; color: #f59e0b; }
.pdp-rev-big-count {
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
}

/* Rating bars */
.pdp-rev-bars {
    flex: 1;
    min-width: 200px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.pdp-rev-bar-row {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
    color: var(--muted);
    font-weight: 600;
}
.pdp-rev-bar-track {
    flex: 1;
    height: 8px;
    background: #f3f4f6;
    border-radius: 4px;
    overflow: hidden;
}
.pdp-rev-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #f59e0b, #fbbf24);
    border-radius: 4px;
    transition: width .7s ease;
}
.pdp-rev-bar-pct {
    font-size: 11px;
    color: var(--muted);
    width: 34px;
    text-align: right;
    flex-shrink: 0;
}

/* Write Review CTA box */
.pdp-rev-write-cta {
    flex-shrink: 0;
    background: linear-gradient(135deg, var(--red-bg), #fff0f0);
    border: 1.5px solid #f5a0aa;
    border-radius: 10px;
    padding: 16px 20px;
    text-align: center;
    min-width: 160px;
}
.pdp-rev-write-cta p {
    font-size: 12px;
    color: var(--muted);
    line-height: 1.55;
    margin-bottom: 10px;
}
.pdp-rev-write-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--red);
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 9px 16px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: background .2s, transform .2s;
    font-family: inherit;
}
.pdp-rev-write-btn:hover { background: var(--red-d); transform: translateY(-1px); }

/* Reviews grid */
.pdp-rev-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

/* Individual review card */
.pdp-rev-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: box-shadow .25s, transform .25s, border-color .25s;
    position: relative;
    overflow: hidden;
}
.pdp-rev-card::before {
    content: '"';
    position: absolute;
    top: -10px;
    right: 16px;
    font-family: 'Playfair Display', serif;
    font-size: 88px;
    color: var(--red);
    opacity: .06;
    line-height: 1;
    pointer-events: none;
}
.pdp-rev-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,.1);
    border-color: #f5a0aa;
    transform: translateY(-3px);
}

/* Stars row in review card */
.pdp-rev-stars {
    display: flex;
    align-items: center;
    gap: 3px;
}
.pdp-rev-stars i { font-size: 13px; }
.pdp-rev-stars .rev-star-filled { color: #f59e0b; }
.pdp-rev-stars .rev-star-empty  { color: #d1d5db; }
.pdp-rev-score-label {
    font-size: 12px;
    color: var(--muted);
    margin-left: 6px;
    font-weight: 600;
}

/* Review text */
.pdp-rev-text {
    font-size: 13.5px;
    color: #4b5563;
    line-height: 1.7;
    font-style: italic;
    flex: 1;
}

/* Reviewer info footer */
.pdp-rev-footer {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-top: 12px;
    border-top: 1px solid var(--border);
}
.pdp-rev-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--red), #8b0000);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 800;
    color: #fff;
    flex-shrink: 0;
    font-family: 'Playfair Display', serif;
}
.pdp-rev-name {
    font-size: 13px;
    font-weight: 700;
    color: var(--text);
}
.pdp-rev-date {
    font-size: 11px;
    color: var(--muted);
    margin-top: 1px;
}
.pdp-rev-verified {
    margin-left: auto;
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 10px;
    font-weight: 700;
    color: #16a34a;
    background: rgba(22,163,74,.1);
    border: 1px solid rgba(22,163,74,.2);
    border-radius: 20px;
    padding: 3px 9px;
    flex-shrink: 0;
}

/* No reviews empty state */
.pdp-rev-empty {
    text-align: center;
    padding: 48px 24px;
    color: var(--muted);
}
.pdp-rev-empty i {
    font-size: 40px;
    color: #e5e7eb;
    display: block;
    margin-bottom: 12px;
}
.pdp-rev-empty p { font-size: 14px; margin-bottom: 16px; }

/* Write Review Modal */
.pdp-rev-modal-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,.55);
    z-index: 99998; display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none; transition: opacity .3s;
    padding: 20px;
}
.pdp-rev-modal-overlay.active { opacity: 1; pointer-events: all; }
.pdp-rev-modal {
    background: var(--white);
    border-radius: 16px;
    padding: 28px;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 24px 60px rgba(0,0,0,.2);
    transform: scale(.94) translateY(10px);
    transition: transform .3s ease;
}
.pdp-rev-modal-overlay.active .pdp-rev-modal { transform: scale(1) translateY(0); }
.pdp-rev-modal-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px;
}
.pdp-rev-modal-title {
    font-family: 'Playfair Display', serif;
    font-size: 20px; font-weight: 800; color: var(--text);
}
.pdp-rev-modal-close {
    width: 32px; height: 32px; border-radius: 50%;
    background: #f3f4f6; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: var(--muted); transition: background .2s;
}
.pdp-rev-modal-close:hover { background: #e5e7eb; color: var(--text); }
.pdp-rev-modal-label {
    font-size: 12px; font-weight: 700; color: var(--muted);
    text-transform: uppercase; letter-spacing: .08em; margin-bottom: 8px; display: block;
}
.pdp-rev-star-picker {
    display: flex; gap: 6px; margin-bottom: 18px;
}
.pdp-rev-star-picker i {
    font-size: 26px; color: #d1d5db; cursor: pointer;
    transition: color .15s, transform .15s;
}
.pdp-rev-star-picker i:hover,
.pdp-rev-star-picker i.selected { color: #f59e0b; transform: scale(1.18); }
.pdp-rev-modal textarea {
    width: 100%; border: 1.5px solid var(--border); border-radius: 8px;
    padding: 12px 14px; font-size: 14px; font-family: inherit;
    resize: vertical; min-height: 110px; color: var(--text);
    transition: border-color .2s; outline: none; margin-bottom: 18px;
}
.pdp-rev-modal textarea:focus { border-color: var(--red); }
.pdp-rev-modal-submit {
    width: 100%; padding: 13px; background: var(--red); color: #fff;
    border: none; border-radius: 8px; font-size: 14px; font-weight: 700;
    cursor: pointer; font-family: inherit; transition: background .2s, box-shadow .2s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.pdp-rev-modal-submit:hover { background: var(--red-d); box-shadow: 0 4px 14px rgba(190,3,24,.35); }
.pdp-rev-modal-submit:disabled { opacity: .65; cursor: not-allowed; }
.pdp-rev-login-note {
    text-align: center; padding: 24px;
    font-size: 13px; color: var(--muted);
}
.pdp-rev-login-note a { color: var(--red); font-weight: 600; }

/* ── RELATED ── */
.pdp__related { background: var(--white); margin-top: 16px; border-radius: var(--radius); box-shadow: var(--shadow); padding: 24px; animation: fadeUp .4s .2s ease both; }
.pdp__section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
.pdp__section-title  { font-family: 'DM Serif Display', serif; font-size: 18px; }
.pdp__see-all { color: var(--red); font-size: 13px; font-weight: 600; }
.pdp__see-all:hover { text-decoration: underline; }
.pdp__prod-grid { display: grid; grid-template-columns: repeat(auto-fill,minmax(175px,1fr)); gap: 16px; }
.pdp__prod-card {
  background: var(--white); border: 1px solid var(--border); border-radius: 10px;
  overflow: hidden; transition: all .25s; cursor: pointer; display: flex; flex-direction: column;
}
.pdp__prod-card:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(0,0,0,.12); border-color: #f5a0aa; }
.pdp__prod-img  { position: relative; aspect-ratio: 1/1; background: #f3f4f6; overflow: hidden; }
.pdp__prod-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .35s; }
.pdp__prod-card:hover .pdp__prod-img img { transform: scale(1.06); }
.pdp__prod-disc { position: absolute; top: 8px; right: 8px; width: 42px; height: 42px; border-radius: 50%; background: var(--red); color: #fff; font-size: 10px; font-weight: 800; line-height: 1.2; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; z-index: 2; }
.pdp__prod-body { padding: 10px 10px 0; flex: 1; display: flex; flex-direction: column; gap: 5px; }
.pdp__prod-name { font-size: 12px; line-height: 1.45; display: -webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; flex:1; }
.pdp__prod-prices { display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap; }
.pdp__prod-old   { font-size: 11px; color: var(--muted); text-decoration: line-through; }
.pdp__prod-price { font-size: 14px; font-weight: 700; color: var(--red); }
.pdp__prod-cart-btn {
  width: 100%; padding: 9px 0; background: var(--red); color: #fff;
  font-size: 13px; font-weight: 700; border: none; cursor: pointer; font-family: inherit;
  display: flex; align-items: center; justify-content: center; gap: 6px;
  transition: background .2s; margin-top: 8px;
}
.pdp__prod-cart-btn:hover { background: var(--red-d); }
.pdp__prod-cart-btn:disabled { opacity: .65; cursor: not-allowed; }

/* ── ZOOM OVERLAY ── */
.pdp__zoom {
  position: fixed; inset: 0; background: rgba(0,0,0,.92); z-index: 99999;
  display: flex; align-items: center; justify-content: center;
  opacity: 0; pointer-events: none; transition: opacity .3s;
}
.pdp__zoom--active { opacity: 1; pointer-events: all; }
.pdp__zoom-img {
  max-width: 90vw; max-height: 90vh; object-fit: contain;
  border-radius: 10px; transform: scale(.82); cursor: zoom-out;
  transition: transform .35s cubic-bezier(.4,0,.2,1), opacity .3s;
  box-shadow: 0 24px 80px rgba(0,0,0,.6);
}
.pdp__zoom--active .pdp__zoom-img { transform: scale(1); }
.pdp__zoom-close {
  position: absolute; top: 18px; right: 22px;
  background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.3);
  color: #fff; font-size: 18px; width: 44px; height: 44px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; transition: background .2s;
}
.pdp__zoom-close:hover { background: rgba(255,255,255,.28); }
.pdp__zoom-nav {
  position: absolute; top: 50%; transform: translateY(-50%);
  background: rgba(255,255,255,.12); border: 1.5px solid rgba(255,255,255,.25);
  color: #fff; width: 48px; height: 48px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center; font-size: 18px;
  cursor: pointer; transition: background .2s;
}
.pdp__zoom-nav:hover { background: rgba(255,255,255,.25); }
.pdp__zoom-prev { left: 20px; }
.pdp__zoom-next { right: 20px; }
.pdp__zoom-count { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); background: rgba(255,255,255,.15); color: #fff; font-size: 12px; font-weight: 600; padding: 5px 14px; border-radius: 20px; }

/* ── RESPONSIVE ── */
@media(max-width:768px){
    .pdp__prod-grid { grid-template-columns: repeat(auto-fill,minmax(145px,1fr)); gap: 12px; }
    .pdp-rev-grid { grid-template-columns: 1fr; }
    .pdp-rev-summary { gap: 20px; }
}
@media(max-width:480px){
  .pdp__title { font-size: 17px; }
  .pdp__price-cur { font-size: 22px; }
  .pdp__actions { flex-direction: column; }
  .pdp__flash { flex-direction: column; align-items: flex-start; }
  .pdp__prod-grid { grid-template-columns: repeat(2,1fr); gap: 10px; }
  #pdp-toasts { top: auto; bottom: 20px; right: 10px; left: 10px; }
  .pdp-toast { max-width: 100%; }
  .pdp-rev-summary { flex-direction: column; align-items: flex-start; }
  .pdp-rev-big-score { min-width: auto; }
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

  $allImages   = collect([['url' => $featureImg]])->merge($gallery)->values();
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

  $inStock    = $product->is_unlimited || ($product->stock ?? 0) > 0;
  $stockLabel = $product->is_unlimited
                ? 'In Stock'
                : ($product->stock > 0 ? $product->stock . ' items left' : 'Out of Stock');
  $stockPct   = $product->is_unlimited ? 100
                : ($product->stock > 0 ? min(100, round($product->stock / max(1, $product->stock + 10) * 100)) : 0);

  $categoryName = $product->category->category_name ?? '';
  $subCatName   = $product->subCategory->sub_name ?? '';
  $shareUrl     = url()->current();
  $shareTitle   = urlencode($product->name);

  preg_match('/(?:v=|youtu\.be\/|embed\/)([a-zA-Z0-9_-]{11})/', $product->youtube_url ?? '', $ytMatch);
  $ytId = $ytMatch[1] ?? null;

  $cartAddUrl     = route('cart.add', $product->id);
  $wishlistAddUrl = route('wishlist.add', $product->id);
  $checkoutUrl    = route('checkout');
  $csrfToken      = csrf_token();

  /* ── REVIEWS DATA ── */
  $productReviews   = \App\Models\Producreview::where('product_id', $product->id)
                        ->where('is_approved', true)
                        ->with('user')
                        ->latest()
                        ->get();

  $totalRevCount    = $productReviews->count();
  $avgRating        = $totalRevCount > 0 ? round($productReviews->avg('rating'), 1) : 0;

  $starCounts = [];
  for ($s = 5; $s >= 1; $s--) {
      $starCounts[$s] = $productReviews->where('rating', $s)->count();
  }

  /* Has the logged-in user already reviewed this product? */
  $userReview       = null;
  $alreadyReviewed  = false;
  if (auth()->check()) {
      $userReview      = \App\Models\Producreview::where('product_id', $product->id)
                          ->where('user_id', auth()->id())
                          ->first();
      $alreadyReviewed = (bool) $userReview;
  }

  $reviewStoreUrl = route('review.store', $product->id);
@endphp

{{-- ── TOAST CONTAINER ── --}}
<div id="pdp-toasts"></div>

{{-- ── REVIEW WRITE MODAL ── --}}
<div class="pdp-rev-modal-overlay" id="pdpRevModal">
    <div class="pdp-rev-modal">
        <div class="pdp-rev-modal-head">
            <span class="pdp-rev-modal-title">Write a Review</span>
            <button class="pdp-rev-modal-close" id="pdpRevModalClose" type="button">
                <i class="fas fa-times"></i>
            </button>
        </div>

        @auth
            @if($alreadyReviewed)
                <div style="text-align:center;padding:20px 0">
                    <i class="fas fa-check-circle" style="font-size:36px;color:#16a34a;display:block;margin-bottom:12px"></i>
                    <p style="font-size:14px;color:#374151;font-weight:600">আপনি ইতোমধ্যে এই পণ্যটি রিভিউ করেছেন।</p>
                    <p style="font-size:12px;color:var(--muted);margin-top:6px">Rating: {{ $userReview->rating }}/5 — "{{ Str::limit($userReview->review, 60) }}"</p>
                </div>
            @else
                <form id="pdpRevForm" action="{{ $reviewStoreUrl }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="rating" id="pdpRevRatingInput" value="0">

                    <label class="pdp-rev-modal-label">Your Rating *</label>
                    <div class="pdp-rev-star-picker" id="pdpRevStarPicker">
                        <i class="far fa-star" data-val="1"></i>
                        <i class="far fa-star" data-val="2"></i>
                        <i class="far fa-star" data-val="3"></i>
                        <i class="far fa-star" data-val="4"></i>
                        <i class="far fa-star" data-val="5"></i>
                    </div>
                    <div id="pdpRevRatingErr" style="font-size:11px;color:var(--red);margin-bottom:12px;display:none">
                        অনুগ্রহ করে একটি রেটিং দিন।
                    </div>

                    <label class="pdp-rev-modal-label">Your Review (Optional)</label>
                    <textarea name="review" placeholder="এই পণ্য সম্পর্কে আপনার মতামত লিখুন..."></textarea>

                    <button type="submit" class="pdp-rev-modal-submit" id="pdpRevSubmit">
                        <i class="fas fa-paper-plane"></i> রিভিউ জমা দিন
                    </button>
                </form>
            @endif
        @else
            <div class="pdp-rev-login-note">
                <i class="fas fa-lock" style="font-size:28px;color:#d1d5db;display:block;margin-bottom:12px"></i>
                রিভিউ দিতে হলে আগে <a href="{{ url('customer/login') }}">লগইন করুন</a>।
            </div>
        @endauth
    </div>
</div>

<div class="pdp">

  {{-- Server-side flash --}}
  <div class="pdp__wrap">
    @if(session('success'))
      <div class="pdp-alert pdp-alert--success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('info'))
      <div class="pdp-alert pdp-alert--info"><i class="bi bi-info-circle-fill"></i> {{ session('info') }}</div>
    @endif
    @if(session('error'))
      <div class="pdp-alert pdp-alert--error"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
    @endif
  </div>

  {{-- ── BREADCRUMB ── --}}
  <div class="pdp__breadbar">
    <div class="pdp__wrap">
      <nav class="pdp__bread">
        <a href="{{ url('/') }}">Home</a>
        @if($categoryName)
          <span class="pdp__bread-sep">›</span>
          <a href="#">{{ $categoryName }}</a>
        @endif
        @if($subCatName)
          <span class="pdp__bread-sep">›</span>
          <a href="#">{{ $subCatName }}</a>
        @endif
        <span class="pdp__bread-sep">›</span>
        <span class="pdp__bread-cur">{{ Str::limit($product->name, 60) }}</span>
      </nav>
    </div>
  </div>

  <div class="pdp__wrap">

    {{-- ── PRODUCT CARD ── --}}
    <div class="pdp__card">
      <div class="pdp__grid">

        {{-- ── LEFT: GALLERY ── --}}
        <div class="pdp__gallery">
          <div class="pdp__main-wrap" id="pdpMainWrap">
            <button class="pdp__wish-btn" id="pdpWishBtn"
                    data-url="{{ $wishlistAddUrl }}"
                    title="উইশলিস্টে যোগ করুন">
              <i class="bi bi-heart"></i>
            </button>
            @if($product->vendor)
            <div class="pdp__badge-row">
              <span class="pdp__badge pdp__badge--vendor">{{ $product->vendor }}</span>
            </div>
            @endif
            <img id="pdpMainImg" class="pdp__main-img" src="{{ $featureImg }}" alt="{{ $product->name }}"/>
            <div class="pdp__zoom-hint"><i class="fas fa-search-plus" style="font-size:10px"></i> Click to zoom</div>
            <div class="pdp__img-counter">
              <i class="fas fa-camera"></i>
              <span id="pdpCounter">1 / {{ $totalImages }}</span>
            </div>
            <div class="pdp__img-popup">
              <div class="pdp__popup-title">{{ $product->name }}</div>
              <div class="pdp__popup-meta">
                <span class="pdp__popup-price">৳{{ number_format($displayPrice, 2) }}</span>
                @if($originalPrice)
                  <span class="pdp__popup-old">৳{{ number_format($originalPrice, 2) }}</span>
                @endif
                @if($discountPct)
                  <span class="pdp__popup-chip">−{{ $discountPct }}%</span>
                @endif
              </div>
              <div class="pdp__popup-stock"><i class="fas fa-fire"></i> {{ $stockLabel }}</div>
              <hr class="pdp__popup-hr"/>
              <div class="pdp__popup-meta2">
                <span><i class="fas fa-tag"></i> SKU: {{ $product->sku ?? 'N/A' }}</span>
                @if($product->return_policy)
                  <span><i class="fas fa-undo"></i> Return Policy</span>
                @endif
              </div>
            </div>
          </div>

          {{-- Thumbnails --}}
          <div class="pdp__thumbs" id="pdpThumbs">
            @foreach($allImages as $idx => $img)
            <div class="pdp__thumb {{ $idx === 0 ? 'pdp__thumb--active' : '' }}"
                 data-idx="{{ $idx }}"
                 data-src="{{ $img['url'] }}">
              <img src="{{ $img['url'] }}" alt="Thumb {{ $idx + 1 }}" loading="lazy"/>
            </div>
            @endforeach
          </div>

          {{-- Share --}}
          <div class="pdp__share">
            <span class="pdp__share-label">Share:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" class="pdp__soc-btn pdp__soc--fb"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.linkedin.com/shareArticle?url={{ $shareUrl }}&title={{ $shareTitle }}" target="_blank" rel="noopener" class="pdp__soc-btn pdp__soc--li"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener" class="pdp__soc-btn pdp__soc--tw"><i class="fab fa-twitter"></i></a>
            <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener" class="pdp__soc-btn pdp__soc--wa"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>{{-- /GALLERY --}}

        {{-- ── MIDDLE: INFO ── --}}
        <div class="pdp__info">
          @if(!empty($featureTags))
          <div class="pdp__feature-tags">
            @foreach($featureTags as $ft)
            <span class="pdp__feature-tag" style="background:{{ $ft['color'] ?? '#be0318' }};color:#fff">{{ $ft['keyword'] }}</span>
            @endforeach
          </div>
          @endif

          <h1 class="pdp__title">{{ $product->name }}</h1>

          <div class="pdp__meta-row">
            <span class="pdp__meta-muted">SKU:</span>
            <strong>{{ $product->sku ?? 'N/A' }}</strong>
            @if($product->vendor)
              <span style="color:var(--border)">|</span>
              <span class="pdp__meta-muted">Vendor:</span>
              <strong>{{ $product->vendor }}</strong>
            @endif
          </div>

          {{-- Inline rating summary under product name --}}
          @if($totalRevCount > 0)
          <div class="pdp__meta-row" style="margin-bottom:14px">
            @for($s=1;$s<=5;$s++)
              <i class="bi bi-star{{ $s <= round($avgRating) ? '-fill' : '' }}"
                 style="font-size:13px;color:{{ $s <= round($avgRating) ? '#f59e0b' : '#d1d5db' }}"></i>
            @endfor
            <span style="font-size:13px;font-weight:700;color:var(--text)">{{ $avgRating }}</span>
            <a href="#" onclick="pdpTab('reviews');return false;"
               style="font-size:12px;color:var(--muted);text-decoration:underline">
               ({{ $totalRevCount }} {{ $totalRevCount === 1 ? 'review' : 'reviews' }})
            </a>
          </div>
          @endif

          <div class="pdp__viewers">
            <i class="fas fa-eye"></i>
            <span><span class="pdp__viewers-n" id="pdpViewers">61</span> people are viewing this right now</span>
          </div>

          @if($product->discount_price)
          <div class="pdp__flash">
            <div class="pdp__flash-left"><i class="fa-solid fa-bolt"></i><span>Special Offer</span></div>
            <div class="pdp__flash-right">
              <span class="pdp__flash-ends"><i class="far fa-clock"></i> Ends in:</span>
              <span class="pdp__timer-box" id="pdpTH">01h</span>
              <span class="pdp__timer-box" id="pdpTM">39m</span>
              <span class="pdp__timer-box" id="pdpTS">54s</span>
            </div>
          </div>
          @endif

          {{-- Price --}}
          <div class="pdp__price-block">
            <div class="pdp__price-row">
              <span class="pdp__price-cur">৳{{ number_format($displayPrice, 2) }}</span>
              @if($originalPrice)
                <span class="pdp__price-old">৳{{ number_format($originalPrice, 2) }}</span>
              @endif
              @if($discountPct)
                <span class="pdp__price-chip">−{{ $discountPct }}%</span>
              @endif
            </div>
            <div class="pdp__stock-row">
              <span class="pdp__stock-label">{{ $stockLabel }}</span>
              @if(!$product->is_unlimited)
              <div class="pdp__stock-bar"><div class="pdp__stock-fill" style="width:{{ $stockPct }}%"></div></div>
              @endif
            </div>
          </div>

          {{-- Color options --}}
          @if($colors->count())
          <div class="pdp__opt-group">
            <label class="pdp__opt-label">
              Color: <span class="pdp__opt-tag">Optional</span>
              <span class="pdp__opt-selected" id="pdpColorSel" style="display:none"></span>
            </label>
            <div class="pdp__opt-btns" id="pdpColorBtns">
              @foreach($colors as $color)
              <button class="pdp__opt-btn" data-group="color" data-value="{{ $color }}">{{ $color }}</button>
              @endforeach
            </div>
          </div>
          @endif

          {{-- Size options --}}
          @if($sizes->count())
          <div class="pdp__opt-group">
            <label class="pdp__opt-label">
              Size: <span class="pdp__opt-tag">Optional</span>
              <span class="pdp__opt-selected" id="pdpSizeSel" style="display:none"></span>
            </label>
            <div class="pdp__opt-btns" id="pdpSizeBtns">
              @foreach($sizes as $size)
              <button class="pdp__opt-btn" data-group="size" data-value="{{ $size }}">{{ $size }}</button>
              @endforeach
            </div>
          </div>
          @endif

          {{-- Quantity --}}
          <div class="pdp__qty-group">
            <label class="pdp__opt-label">Quantity:</label>
            <div class="pdp__qty-row">
              <div class="pdp__qty-sel">
                <button class="pdp__qty-btn" id="pdpQtyDec" type="button"><i class="fas fa-minus"></i></button>
                <input type="text" class="pdp__qty-input" id="pdpQtyInput" value="1" readonly/>
                <button class="pdp__qty-btn" id="pdpQtyInc" type="button"><i class="fas fa-plus"></i></button>
              </div>
              @if(!$product->is_unlimited && ($product->stock ?? 0) > 0)
              <div class="pdp__stock-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $product->stock }} units available</span>
              </div>
              @endif
            </div>
          </div>

          {{-- ACTION BUTTONS --}}
          <div class="pdp__actions">
            @if(!$inStock)
              <span class="pdp__btn pdp__btn--cart" style="opacity:.5;cursor:not-allowed;">
                <i class="fas fa-times-circle"></i> Out of Stock
              </span>
            @else
              <button type="button" class="pdp__btn pdp__btn--cart" id="pdpAddCart" data-url="{{ $cartAddUrl }}">
                <i class="fas fa-shopping-cart"></i>
                <span class="pdp-btn-text">Add to Cart</span>
              </button>
              <button type="button" class="pdp__btn pdp__btn--buy" id="pdpBuyNow"
                      data-url="{{ $cartAddUrl }}" data-checkout="{{ $checkoutUrl }}">
                <i class="fas fa-shopping-bag"></i>
                <span class="pdp-btn-text">Buy Now</span>
              </button>
            @endif
          </div>

          {{-- Meta --}}
          <div class="pdp__product-meta">
            @if($categoryName)<span><strong>Category:</strong> {{ $categoryName }}</span>@endif
            @if($subCatName)<span><strong>Sub-Category:</strong> {{ $subCatName }}</span>@endif
            @if(!empty($tags))
            <span>
              <strong>Tags:</strong>
              @foreach($tags as $tag)<a href="#" style="color:var(--red);margin-right:4px">#{{ $tag }}</a>@endforeach
            </span>
            @endif
            <span><strong>Product Type:</strong> {{ ucfirst($product->product_type ?? 'N/A') }}</span>
          </div>

          @if($product->return_policy)
          <div class="pdp__notice">
            <i class="fas fa-undo"></i>
            <span>{{ $product->return_policy }}</span>
          </div>
          @endif
        </div>{{-- /INFO --}}

        {{-- ── RIGHT: SIDEBAR ── --}}
        <div class="pdp__sidebar">
          <div class="pdp__s-card">
            <div class="pdp__card-head"><i class="fas fa-truck" style="margin-right:6px;color:var(--red)"></i>Delivery & Shipping</div>
            <div class="pdp__card-body">
              <div class="pdp__del-row">
                <div class="pdp__del-icon"><i class="fas fa-truck"></i></div>
                <div>
                  <div class="pdp__del-title">Door Delivery</div>
                  <div class="pdp__del-date">Standard delivery within 3–7 working days</div>
                </div>
              </div>
              <div class="pdp__del-row">
                <div class="pdp__del-icon"><i class="fas fa-store"></i></div>
                <div>
                  <div class="pdp__del-title">Pickup Available</div>
                  <div class="pdp__del-date">Contact seller for pickup details</div>
                </div>
              </div>
              @if($product->return_policy)
              <div class="pdp__del-row">
                <div class="pdp__del-icon"><i class="fas fa-undo"></i></div>
                <div>
                  <div class="pdp__del-title">Return Policy</div>
                  <div class="pdp__del-date">{{ Str::limit($product->return_policy, 80) }}</div>
                </div>
              </div>
              @endif
              @if(($product->product_type ?? '') === 'digital')
              <div class="pdp__del-row">
                <div class="pdp__del-icon"><i class="fas fa-download"></i></div>
                <div>
                  <div class="pdp__del-title">Instant Download</div>
                  <div class="pdp__del-date">Available immediately after purchase</div>
                </div>
              </div>
              @endif
            </div>
          </div>

          @if($product->vendor)
          <div class="pdp__s-card">
            <div class="pdp__card-head"><i class="fas fa-store" style="margin-right:6px;color:var(--red)"></i>Seller</div>
            <div class="pdp__card-body">
              <div class="pdp__seller-head">
                <div class="pdp__seller-ava">{{ strtoupper(substr($product->vendor, 0, 2)) }}</div>
                <div>
                  <div class="pdp__seller-name">{{ $product->vendor }}</div>
                  <div class="pdp__seller-ver"><i class="fas fa-check-circle"></i> Verified Seller</div>
                </div>
              </div>
            </div>
          </div>
          @endif

          @if($ytId)
          <div class="pdp__s-card">
            <div class="pdp__card-head"><i class="fab fa-youtube" style="margin-right:6px;color:#ef4444"></i>Product Video</div>
            <div class="pdp__card-body" style="padding:0">
              <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;">
                <iframe src="https://www.youtube.com/embed/{{ $ytId }}"
                        style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                        allowfullscreen loading="lazy"></iframe>
              </div>
            </div>
          </div>
          @endif
        </div>{{-- /SIDEBAR --}}

      </div>{{-- /grid --}}
    </div>{{-- /card --}}

    {{-- ══ TABS ══ --}}
    <div class="pdp__tabs" id="pdpTabsSection">
      <div class="pdp__tab-nav">
        <button class="pdp__tab-btn pdp__tab-btn--active" onclick="pdpTab('description')">
          <i class="fas fa-align-left"></i> Description
        </button>
        <button class="pdp__tab-btn" onclick="pdpTab('specifications')">
          <i class="fas fa-list"></i> Specifications
        </button>
        <button class="pdp__tab-btn" onclick="pdpTab('reviews')">
          <i class="fas fa-star"></i> Reviews
          @if($totalRevCount > 0)
            <span style="background:var(--red);color:#fff;font-size:10px;font-weight:800;padding:2px 7px;border-radius:10px;margin-left:2px">
              {{ $totalRevCount }}
            </span>
          @endif
        </button>
      </div>

      {{-- Description Tab --}}
      <div id="pdpDescription" class="pdp__tab-pane pdp__tab-pane--active">
        <div class="pdp__desc">{!! nl2br(e($product->description)) !!}</div>
      </div>

      {{-- Specifications Tab --}}
      <div id="pdpSpecifications" class="pdp__tab-pane">
        <div class="pdp__spec-section">
          <div class="pdp__spec-head">Product Details</div>
          <div class="pdp__spec-row"><span class="pdp__spec-k">SKU</span><span class="pdp__spec-v">{{ $product->sku ?? 'N/A' }}</span></div>
          <div class="pdp__spec-row"><span class="pdp__spec-k">Product Type</span><span class="pdp__spec-v">{{ ucfirst($product->product_type ?? 'N/A') }}</span></div>
          @if($categoryName)<div class="pdp__spec-row"><span class="pdp__spec-k">Category</span><span class="pdp__spec-v">{{ $categoryName }}</span></div>@endif
          @if($subCatName)<div class="pdp__spec-row"><span class="pdp__spec-k">Sub Category</span><span class="pdp__spec-v">{{ $subCatName }}</span></div>@endif
          @if($product->vendor)<div class="pdp__spec-row"><span class="pdp__spec-k">Vendor / Brand</span><span class="pdp__spec-v">{{ $product->vendor }}</span></div>@endif
          <div class="pdp__spec-row"><span class="pdp__spec-k">Availability</span><span class="pdp__spec-v">{{ $stockLabel }}</span></div>
        </div>
        @if($variants->count())
        <div class="pdp__spec-section">
          <div class="pdp__spec-head">Available Variants</div>
          @foreach($variants as $v)
          <div class="pdp__spec-row">
            <span class="pdp__spec-k">{{ $v['size'] ?? '' }}{{ (!empty($v['size']) && !empty($v['color'])) ? ' / ' : '' }}{{ $v['color'] ?? '' }}</span>
            <span class="pdp__spec-v">Stock: {{ $v['stock'] ?? 0 }}@if(!empty($v['price'])) — ৳{{ number_format($v['price'], 2) }}@endif</span>
          </div>
          @endforeach
        </div>
        @endif
      </div>

      {{-- ══ REVIEWS TAB ══ --}}
      <div id="pdpReviews" class="pdp__tab-pane">

        {{-- Overall Rating Summary --}}
        <div class="pdp-rev-summary">

          {{-- Big Score --}}
          <div class="pdp-rev-big-score">
            <div class="pdp-rev-big-num">{{ $totalRevCount > 0 ? number_format($avgRating, 1) : '—' }}</div>
            <div class="pdp-rev-big-stars">
              @for($s = 1; $s <= 5; $s++)
                <i class="bi bi-star{{ $s <= round($avgRating) ? '-fill' : ($s - 0.5 <= $avgRating ? '-half' : '') }}"
                   style="color:{{ $totalRevCount > 0 ? '#f59e0b' : '#d1d5db' }}"></i>
              @endfor
            </div>
            <div class="pdp-rev-big-count">
              {{ $totalRevCount }} {{ $totalRevCount === 1 ? 'টি রিভিউ' : 'টি রিভিউ' }}
            </div>
          </div>

          {{-- Rating Bars --}}
          <div class="pdp-rev-bars">
            @for($s = 5; $s >= 1; $s--)
              @php
                $cnt = $starCounts[$s] ?? 0;
                $pct = $totalRevCount > 0 ? round(($cnt / $totalRevCount) * 100) : 0;
              @endphp
              <div class="pdp-rev-bar-row">
                <span style="width:12px;text-align:right;flex-shrink:0;">{{ $s }}</span>
                <i class="bi bi-star-fill" style="font-size:11px;color:#f59e0b;flex-shrink:0;"></i>
                <div class="pdp-rev-bar-track">
                  <div class="pdp-rev-bar-fill" style="width:{{ $pct }}%"></div>
                </div>
                <span class="pdp-rev-bar-pct">{{ $pct }}%</span>
                <span style="font-size:11px;color:var(--muted);width:20px;flex-shrink:0">({{ $cnt }})</span>
              </div>
            @endfor
          </div>

          {{-- Write Review CTA --}}
          <div class="pdp-rev-write-cta">
            @auth
              @if($alreadyReviewed)
                <p>আপনি ইতোমধ্যে রিভিউ দিয়েছেন। ধন্যবাদ!</p>
                <button class="pdp-rev-write-btn" type="button" id="pdpOpenRevModal" style="background:#6b7280">
                  <i class="fas fa-eye"></i> আপনার রিভিউ
                </button>
              @else
                <p>এই পণ্যটি কি পছন্দ হয়েছে? আপনার অভিজ্ঞতা শেয়ার করুন!</p>
                <button class="pdp-rev-write-btn" type="button" id="pdpOpenRevModal">
                  <i class="fas fa-pen"></i> রিভিউ লিখুন
                </button>
              @endif
            @else
              <p>রিভিউ দিতে লগইন করুন।</p>
              <a href="{{ url('customer/login') }}" class="pdp-rev-write-btn" style="text-decoration:none;color:#fff">
                <i class="fas fa-sign-in-alt"></i> লগইন করুন
              </a>
            @endauth
          </div>

        </div>{{-- /pdp-rev-summary --}}

        {{-- Review Cards --}}
        @if($productReviews->isNotEmpty())
          <div class="pdp-rev-grid">
            @foreach($productReviews as $rev)
              @php
                $reviewer     = $rev->user;
                $reviewerName = $reviewer ? $reviewer->name : 'Anonymous';
                $initial      = strtoupper(substr($reviewerName, 0, 1));
              @endphp
              <div class="pdp-rev-card">

                {{-- Stars --}}
                <div class="pdp-rev-stars">
                  @for($s = 1; $s <= 5; $s++)
                    <i class="bi bi-star{{ $s <= $rev->rating ? '-fill rev-star-filled' : ' rev-star-empty' }}"></i>
                  @endfor
                  <span class="pdp-rev-score-label">{{ $rev->rating }}/5</span>
                </div>

                {{-- Review text --}}
                @if($rev->review)
                  <p class="pdp-rev-text">"{{ $rev->review }}"</p>
                @else
                  <p class="pdp-rev-text" style="color:var(--muted);font-style:normal;font-size:12px">
                    (কোনো মন্তব্য করা হয়নি)
                  </p>
                @endif

                {{-- Footer --}}
                <div class="pdp-rev-footer">
                  <div class="pdp-rev-avatar">{{ $initial }}</div>
                  <div>
                    <div class="pdp-rev-name">{{ $reviewerName }}</div>
                    <div class="pdp-rev-date">{{ $rev->created_at->format('d M Y') }}</div>
                  </div>
                  <div class="pdp-rev-verified">
                    <i class="bi bi-patch-check-fill"></i> Verified
                  </div>
                </div>

              </div>
            @endforeach
          </div>
        @else
          <div class="pdp-rev-empty">
            <i class="fas fa-star"></i>
            <p>এখনো কোনো রিভিউ নেই। প্রথম রিভিউটি আপনিই দিন!</p>
            @auth
              @if(!$alreadyReviewed)
                <button class="pdp-rev-write-btn" type="button" id="pdpOpenRevModalEmpty">
                  <i class="fas fa-pen"></i> রিভিউ লিখুন
                </button>
              @endif
            @else
              <a href="{{ url('customer/login') }}" class="pdp-rev-write-btn" style="text-decoration:none;color:#fff">
                <i class="fas fa-sign-in-alt"></i> লগইন করুন
              </a>
            @endauth
          </div>
        @endif

      </div>{{-- /pdpReviews tab --}}

    </div>{{-- /tabs --}}

    {{-- ── RELATED PRODUCTS ── --}}
    @if(!empty($relatedProducts) && $relatedProducts->count())
    <div class="pdp__related">
      <div class="pdp__section-header">
        <h2 class="pdp__section-title">Related Products</h2>
        @if($categoryName)<a href="#" class="pdp__see-all">See All →</a>@endif
      </div>
      <div class="pdp__prod-grid">
        @foreach($relatedProducts as $rp)
        @php
          $rpImg  = $rp->feature_image ? asset('uploads/products/' . $rp->feature_image) : asset('images/placeholder.png');
          $rpPx   = $rp->discount_price ?? $rp->current_price;
          $rpOld  = $rp->discount_price ? $rp->current_price : null;
          $rpDisc = ($rp->discount_price && $rp->current_price > 0)
                    ? round((($rp->current_price - $rp->discount_price) / $rp->current_price) * 100) : null;
        @endphp
        <a href="{{ route('product.detail', $rp->slug) }}" class="pdp__prod-card" style="text-decoration:none;color:inherit">
          <div class="pdp__prod-img">
            @if($rpDisc)
            <div class="pdp__prod-disc"><span>{{ $rpDisc }}%</span><span style="font-size:8px">OFF</span></div>
            @endif
            <img src="{{ $rpImg }}" alt="{{ $rp->name }}" loading="lazy"/>
          </div>
          <div class="pdp__prod-body">
            <div class="pdp__prod-name">{{ $rp->name }}</div>
            <div class="pdp__prod-prices">
              @if($rpOld)<span class="pdp__prod-old">৳{{ number_format($rpOld, 2) }}</span>@endif
              <span class="pdp__prod-price">৳{{ number_format($rpPx, 2) }}</span>
            </div>
          </div>
          <button type="button"
                  class="pdp__prod-cart-btn"
                  data-url="{{ route('cart.add', $rp->id) }}"
                  onclick="event.preventDefault(); event.stopPropagation(); pdpRelatedCart(this)">
           <i class="fa-solid fa-cart-plus"></i> কার্টে যোগ করুন
          </button>
        </a>
        @endforeach
      </div>
    </div>
    @endif

  </div>{{-- /wrap --}}

  {{-- ── ZOOM OVERLAY ── --}}
  <div class="pdp__zoom" id="pdpZoom">
    <button type="button" class="pdp__zoom-close" id="pdpZoomClose"><i class="fas fa-times"></i></button>
    <button type="button" class="pdp__zoom-nav pdp__zoom-prev" id="pdpZoomPrev"><i class="fas fa-chevron-left"></i></button>
    <img id="pdpZoomImg" class="pdp__zoom-img" src="" alt="Zoomed"/>
    <button type="button" class="pdp__zoom-nav pdp__zoom-next" id="pdpZoomNext"><i class="fas fa-chevron-right"></i></button>
    <div class="pdp__zoom-count" id="pdpZoomCount">1 / {{ $totalImages }}</div>
  </div>

</div>{{-- /pdp --}}

{{-- ══ JAVASCRIPT ══ --}}
<script>
(function () {
  'use strict';

  var IMGS     = @json($allImages->pluck('url')->values());
  var MAX_QTY  = {{ $product->is_unlimited ? 9999 : max(1, $product->stock ?? 1) }};
  var CHECKOUT = '{{ $checkoutUrl }}';
  var CSRF     = document.querySelector('meta[name="csrf-token"]')
                   ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                   : '{{ $csrfToken }}';
  var curIdx   = 0;
  var selColor = null;
  var selSize  = null;

  /* ── TOAST ── */
  function toast(msg, type, ms) {
    type = type || 'success'; ms = ms || 3200;
    var icons = { success:'bi bi-check-circle-fill', error:'bi bi-x-circle-fill', info:'bi bi-info-circle-fill' };
    var el = document.createElement('div');
    el.className = 'pdp-toast pdp-toast--' + type;
    el.innerHTML = '<i class="' + (icons[type]||icons.info) + '"></i><span>' + msg + '</span>';
    var wrap = document.getElementById('pdp-toasts');
    if (wrap) wrap.appendChild(el);
    setTimeout(function () {
      el.classList.add('out');
      setTimeout(function () { if (el.parentNode) el.parentNode.removeChild(el); }, 320);
    }, ms);
  }

  /* ── UPDATE CART BADGE ── */
  function updateBadge(n) {
    document.querySelectorAll('.cart-badge, #cart-count, .pdp-cart-count').forEach(function (b) {
      b.textContent = n; b.style.display = n > 0 ? '' : 'none';
    });
  }

  /* ── CART POST ── */
  function cartPost(url, qty, color, size, callback) {
    var fd = new FormData();
    fd.append('quantity', qty);
    if (color) fd.append('selected_color', color);
    if (size)  fd.append('selected_size',  size);
    fetch(url, {
      method: 'POST',
      headers: { 'X-Requested-With':'XMLHttpRequest', 'Accept':'application/json', 'X-CSRF-TOKEN':CSRF },
      body: fd
    })
    .then(function (res) {
      if (!res.ok && res.status !== 422) throw new Error('HTTP ' + res.status);
      return res.json();
    })
    .then(function (data) { if (typeof callback === 'function') callback(null, data); })
    .catch(function (err) { console.error('[PDP Cart Error]', err); if (typeof callback === 'function') callback(err, null); });
  }

  /* ── BUTTON LOADING ── */
  function btnLoad(btn, on) {
    if (!btn) return;
    var icon = btn.querySelector('i:not(.pdp-spinner)');
    if (on) {
      btn.disabled = true;
      if (!btn.querySelector('.pdp-spinner')) {
        var s = document.createElement('span'); s.className = 'pdp-spinner'; btn.insertBefore(s, btn.firstChild);
      }
      if (icon) icon.style.display = 'none';
    } else {
      btn.disabled = false;
      var sp = btn.querySelector('.pdp-spinner'); if (sp) sp.parentNode.removeChild(sp);
      if (icon) icon.style.display = '';
    }
  }

  /* ── ADD TO CART ── */
  var addCartBtn = document.getElementById('pdpAddCart');
  if (addCartBtn) {
    addCartBtn.addEventListener('click', function () {
      var btn = this;
      btnLoad(btn, true);
      cartPost(btn.dataset.url, parseInt(document.getElementById('pdpQtyInput').value,10)||1, selColor, selSize, function (err, data) {
        btnLoad(btn, false);
        if (err) { toast('নেটওয়ার্ক সমস্যা। আবার চেষ্টা করুন।','error'); return; }
        if (data && data.success) { updateBadge(data.cart_count); toast(data.message||'কার্টে যোগ হয়েছে!','success'); }
        else toast((data&&data.message)||'কার্টে যোগ করতে সমস্যা হয়েছে।','error');
      });
    });
  }

  /* ── BUY NOW ── */
  var buyNowBtn = document.getElementById('pdpBuyNow');
  if (buyNowBtn) {
    buyNowBtn.addEventListener('click', function () {
      var btn = this;
      btnLoad(btn, true);
      cartPost(btn.dataset.url, parseInt(document.getElementById('pdpQtyInput').value,10)||1, selColor, selSize, function (err, data) {
        if (err) { btnLoad(btn,false); toast('নেটওয়ার্ক সমস্যা। আবার চেষ্টা করুন।','error'); return; }
        if (data && data.success) { updateBadge(data.cart_count); window.location.href = CHECKOUT; }
        else { btnLoad(btn,false); toast((data&&data.message)||'কার্টে যোগ করতে সমস্যা হয়েছে।','error'); }
      });
    });
  }

  /* ── WISHLIST ── */
  var wishBtn = document.getElementById('pdpWishBtn');
  if (wishBtn) {
    wishBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      var btn = this; btn.disabled = true;
      fetch(btn.dataset.url, { headers: { 'X-Requested-With':'XMLHttpRequest', 'Accept':'application/json' } })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        btn.disabled = false;
        if (data.success || data.message) {
          btn.classList.toggle('pdp__wish-btn--active');
          var icon = btn.querySelector('i');
          if (icon) { var a = btn.classList.contains('pdp__wish-btn--active'); icon.className = a?'bi bi-heart-fill':'bi bi-heart'; icon.style.color = a?'#ef4444':''; }
          toast(data.message||'উইশলিস্টে যোগ হয়েছে!','success');
        } else toast(data.message||'সমস্যা হয়েছে।','error');
      })
      .catch(function () { btn.disabled = false; window.location.href = btn.dataset.url; });
    });
  }

  /* ── RELATED CART ── */
  window.pdpRelatedCart = function (btn) {
    var url = btn.dataset.url; var orig = btn.innerHTML;
    btn.disabled = true; btn.innerHTML = '<span class="pdp-spinner" style="width:14px;height:14px;border-width:2px"></span> যোগ হচ্ছে...';
    cartPost(url, 1, null, null, function (err, data) {
      if (err) { btn.innerHTML = orig; btn.disabled = false; toast('নেটওয়ার্ক সমস্যা।','error'); return; }
      if (data && data.success) {
        updateBadge(data.cart_count); toast(data.message||'কার্টে যোগ হয়েছে!','success');
        btn.innerHTML = '<i class="fas fa-check"></i> যোগ হয়েছে!';
        setTimeout(function () { btn.innerHTML = orig; btn.disabled = false; }, 2000);
      } else { btn.innerHTML = orig; btn.disabled = false; toast((data&&data.message)||'সমস্যা হয়েছে।','error'); }
    });
  };

  /* ── OPTION BUTTONS ── */
  document.querySelectorAll('.pdp__opt-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var group = this.dataset.group; var value = this.dataset.value;
      var wasActive = this.classList.contains('pdp__opt-btn--active');
      document.querySelectorAll('.pdp__opt-btn[data-group="'+group+'"]').forEach(function(b){ b.classList.remove('pdp__opt-btn--active'); });
      if (!wasActive) { this.classList.add('pdp__opt-btn--active'); if(group==='color'){selColor=value;_setLabel('pdpColorSel',value);}else{selSize=value;_setLabel('pdpSizeSel',value);} }
      else { if(group==='color'){selColor=null;_setLabel('pdpColorSel',null);}else{selSize=null;_setLabel('pdpSizeSel',null);} }
    });
  });
  function _setLabel(id,val){ var el=document.getElementById(id); if(!el) return; el.textContent=val?'— '+val:''; el.style.display=val?'inline':'none'; }

  /* ── QUANTITY ── */
  var qtyInput = document.getElementById('pdpQtyInput');
  var qtyInc   = document.getElementById('pdpQtyInc');
  var qtyDec   = document.getElementById('pdpQtyDec');
  if (qtyInc) qtyInc.addEventListener('click', function(){ var v=parseInt(qtyInput.value,10); if(v<MAX_QTY) qtyInput.value=v+1; });
  if (qtyDec) qtyDec.addEventListener('click', function(){ var v=parseInt(qtyInput.value,10); if(v>1) qtyInput.value=v-1; });

  /* ── THUMBNAILS ── */
  var mainImg = document.getElementById('pdpMainImg');
  var counter = document.getElementById('pdpCounter');
  var thumbs  = document.querySelectorAll('.pdp__thumb');
  thumbs.forEach(function (t) {
    t.addEventListener('click', function (e) {
      e.stopPropagation();
      thumbs.forEach(function(x){x.classList.remove('pdp__thumb--active');});
      t.classList.add('pdp__thumb--active');
      curIdx = parseInt(t.dataset.idx,10); mainImg.src = t.dataset.src;
      counter.textContent = (curIdx+1)+' / '+IMGS.length;
    });
  });

  /* ── ZOOM OVERLAY ── */
  var zoomEl = document.getElementById('pdpZoom');
  var zoomImg = document.getElementById('pdpZoomImg');
  var zoomCount = document.getElementById('pdpZoomCount');
  function openZoom(idx){ curIdx=idx; zoomImg.src=IMGS[curIdx]; zoomImg.style.opacity='1'; zoomImg.style.transform=''; zoomCount.textContent=(curIdx+1)+' / '+IMGS.length; zoomEl.classList.add('pdp__zoom--active'); document.body.style.overflow='hidden'; }
  function closeZoom(){ zoomEl.classList.remove('pdp__zoom--active'); document.body.style.overflow=''; }
  function zoomNav(dir){
    curIdx=(curIdx+dir+IMGS.length)%IMGS.length;
    zoomImg.style.opacity='0'; zoomImg.style.transform='scale(.88)';
    setTimeout(function(){
      zoomImg.src=IMGS[curIdx]; zoomCount.textContent=(curIdx+1)+' / '+IMGS.length;
      mainImg.src=IMGS[curIdx]; counter.textContent=(curIdx+1)+' / '+IMGS.length;
      thumbs.forEach(function(t){ t.classList.toggle('pdp__thumb--active', parseInt(t.dataset.idx,10)===curIdx); });
      zoomImg.style.opacity='1'; zoomImg.style.transform='scale(1)';
    },160);
  }
  var mainWrap = document.getElementById('pdpMainWrap');
  if (mainWrap) mainWrap.addEventListener('click', function(e){ if(e.target.closest('#pdpWishBtn')) return; openZoom(curIdx); });
  document.getElementById('pdpZoomClose').addEventListener('click', function(e){ e.stopPropagation(); closeZoom(); });
  zoomEl.addEventListener('click', function(e){ if(e.target===zoomEl) closeZoom(); });
  zoomImg.addEventListener('click', closeZoom);
  document.getElementById('pdpZoomPrev').addEventListener('click', function(e){ e.stopPropagation(); zoomNav(-1); });
  document.getElementById('pdpZoomNext').addEventListener('click', function(e){ e.stopPropagation(); zoomNav(1); });
  document.addEventListener('keydown', function(e){
    if(!zoomEl.classList.contains('pdp__zoom--active')) return;
    if(e.key==='Escape') closeZoom(); if(e.key==='ArrowLeft') zoomNav(-1); if(e.key==='ArrowRight') zoomNav(1);
  });

  /* ── COUNTDOWN TIMER ── */
  @if($product->discount_price)
  var _secs = 5994;
  var _timerEl = { h:document.getElementById('pdpTH'), m:document.getElementById('pdpTM'), s:document.getElementById('pdpTS') };
  setInterval(function(){
    if(_secs<=0) return; _secs--;
    var h=Math.floor(_secs/3600), m=Math.floor((_secs%3600)/60), s=_secs%60;
    if(_timerEl.h) _timerEl.h.textContent=String(h).padStart(2,'0')+'h';
    if(_timerEl.m) _timerEl.m.textContent=String(m).padStart(2,'0')+'m';
    if(_timerEl.s) _timerEl.s.textContent=String(s).padStart(2,'0')+'s';
  },1000);
  @endif

  /* ── VIEWER COUNT ── */
  var _vc = document.getElementById('pdpViewers');
  if (_vc) setInterval(function(){ var c=parseInt(_vc.textContent,10); _vc.textContent=Math.max(50,Math.min(80,c+(Math.random()<.5?1:-1))); },4000);

  /* ── TABS ── */
  var _tabMap = { description:0, specifications:1, reviews:2 };
  window.pdpTab = function(id){
    document.querySelectorAll('.pdp__tab-pane').forEach(function(c){ c.classList.remove('pdp__tab-pane--active'); });
    document.querySelectorAll('.pdp__tab-btn').forEach(function(b){ b.classList.remove('pdp__tab-btn--active'); });
    var cap = id.charAt(0).toUpperCase()+id.slice(1);
    var pane = document.getElementById('pdp'+cap); var btns = document.querySelectorAll('.pdp__tab-btn');
    if(pane) pane.classList.add('pdp__tab-pane--active');
    if(btns[_tabMap[id]]) btns[_tabMap[id]].classList.add('pdp__tab-btn--active');
    var sec = document.getElementById('pdpTabsSection'); if(sec) sec.scrollIntoView({behavior:'smooth',block:'start'});
  };

  /* ══════════════════════════════════════
     REVIEW MODAL LOGIC
  ══════════════════════════════════════ */
  var revModal = document.getElementById('pdpRevModal');
  var revModalClose = document.getElementById('pdpRevModalClose');

  function openRevModal() {
    if (revModal) revModal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
  function closeRevModal() {
    if (revModal) revModal.classList.remove('active');
    document.body.style.overflow = '';
  }

  var openBtn = document.getElementById('pdpOpenRevModal');
  if (openBtn) openBtn.addEventListener('click', openRevModal);

  var openBtnEmpty = document.getElementById('pdpOpenRevModalEmpty');
  if (openBtnEmpty) openBtnEmpty.addEventListener('click', openRevModal);

  if (revModalClose) revModalClose.addEventListener('click', closeRevModal);
  if (revModal) revModal.addEventListener('click', function(e){ if(e.target===revModal) closeRevModal(); });
  document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeRevModal(); });

  /* ── STAR PICKER ── */
  var starPicker = document.getElementById('pdpRevStarPicker');
  var ratingInput = document.getElementById('pdpRevRatingInput');
  var selectedRating = 0;

  if (starPicker) {
    var stars = starPicker.querySelectorAll('i');
    stars.forEach(function(star) {
      star.addEventListener('mouseenter', function() {
        var val = parseInt(this.dataset.val, 10);
        stars.forEach(function(s, idx) {
          s.className = idx < val ? 'fas fa-star selected' : 'far fa-star';
        });
      });
      star.addEventListener('mouseleave', function() {
        stars.forEach(function(s, idx) {
          s.className = idx < selectedRating ? 'fas fa-star selected' : 'far fa-star';
        });
      });
      star.addEventListener('click', function() {
        selectedRating = parseInt(this.dataset.val, 10);
        if (ratingInput) ratingInput.value = selectedRating;
        var err = document.getElementById('pdpRevRatingErr');
        if (err) err.style.display = 'none';
        stars.forEach(function(s, idx) {
          s.className = idx < selectedRating ? 'fas fa-star selected' : 'far fa-star';
        });
      });
    });
  }

  /* ── REVIEW FORM SUBMIT ── */
  var revForm = document.getElementById('pdpRevForm');
  if (revForm) {
    revForm.addEventListener('submit', function(e) {
      e.preventDefault();
      if (selectedRating === 0) {
        var err = document.getElementById('pdpRevRatingErr');
        if (err) err.style.display = 'block';
        return;
      }
      var submitBtn = document.getElementById('pdpRevSubmit');
      if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<span class="pdp-spinner"></span> জমা হচ্ছে...'; }

      var fd = new FormData(revForm);
      fetch(revForm.action, {
        method: 'POST',
        headers: { 'X-Requested-With':'XMLHttpRequest', 'Accept':'application/json', 'X-CSRF-TOKEN':CSRF },
        body: fd
      })
      .then(function(r){ return r.json(); })
      .then(function(data){
        if (data.success) {
          closeRevModal();
          toast(data.message || 'রিভিউ সফলভাবে জমা হয়েছে। অনুমোদনের পরে প্রকাশিত হবে।', 'success', 5000);
          /* Reload after brief delay to show new review if auto-approved */
          setTimeout(function(){ window.location.reload(); }, 2500);
        } else {
          toast(data.message || 'রিভিউ জমা দিতে সমস্যা হয়েছে।', 'error');
          if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> রিভিউ জমা দিন'; }
        }
      })
      .catch(function(){
        /* Fallback: regular form submit */
        revForm.submit();
      });
    });
  }

})();
</script>
@endsection
