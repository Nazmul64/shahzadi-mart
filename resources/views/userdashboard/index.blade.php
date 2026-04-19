@include('frontend.pages.header')

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&display=swap');

.oc-shell *, .oc-shell *::before, .oc-shell *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --oc-bg:        #0f0f0f;
    --oc-surface:   #1a1a1a;
    --oc-surface2:  #222222;
    --oc-surface3:  #2a2a2a;
    --oc-border:    #2e2e2e;
    --oc-border2:   #3a3a3a;
    --oc-red:       #e8192c;
    --oc-red-dim:   rgba(232,25,44,0.12);
    --oc-red-glow:  rgba(232,25,44,0.25);
    --oc-text:      #f0f0f0;
    --oc-text2:     #cccccc;
    --oc-muted:     #888888;
    --oc-muted2:    #505050;
    --oc-sidebar-w: 260px;
    --oc-radius:    14px;
    --oc-radius-sm: 8px;
    --oc-amber:     #f59e0b;
    --oc-green:     #22c55e;
    --oc-blue:      #3b82f6;
    --oc-header-h:  150px;
}

.oc-shell { display: flex; min-height: 100vh; background: var(--oc-bg); font-family: 'DM Sans', sans-serif; color: var(--oc-text); position: relative; }

/* ── OVERLAY ── */
.oc-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); z-index: 480; backdrop-filter: blur(3px); opacity: 0; transition: opacity .3s ease; }
.oc-overlay.open { display: block; opacity: 1; }

/* ── TOPBAR ── */
.oc-topbar { display: none; position: fixed; top: 0; left: 0; right: 0; height: 54px; background: var(--oc-surface); border-bottom: 1px solid var(--oc-border); align-items: center; justify-content: space-between; padding: 0 16px; z-index: 600; }
.oc-topbar-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 16px; color: var(--oc-text); }
.oc-hamburger { width: 38px; height: 38px; background: var(--oc-surface2); border: 1px solid var(--oc-border2); border-radius: var(--oc-radius-sm); color: var(--oc-text2); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .2s; flex-shrink: 0; font-size: 15px; }
.oc-hamburger:hover { border-color: var(--oc-red); color: var(--oc-red); }
.oc-hamburger .close-icon { display: none; }
.oc-hamburger.active .bar-icon { display: none; }
.oc-hamburger.active .close-icon { display: block; }
.oc-hamburger.active { border-color: var(--oc-red); color: var(--oc-red); background: var(--oc-red-dim); }

/* ── SIDEBAR ── */
.oc-sidebar { width: var(--oc-sidebar-w); background: var(--oc-surface); border-right: 1px solid var(--oc-border); display: flex; flex-direction: column; position: fixed; top: var(--oc-header-h); left: 0; height: calc(100vh - var(--oc-header-h)); z-index: 500; transition: transform .3s cubic-bezier(.4,0,.2,1); overflow: hidden; }
@media (max-width: 768px) { .oc-sidebar { margin-top: 147px; } }
.oc-sidebar-logo { padding: 20px 18px 16px; border-bottom: 1px solid var(--oc-border); display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
.oc-logo-mark { width: 34px; height: 34px; background: var(--oc-red); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-family: 'Syne', sans-serif; font-weight: 800; font-size: 15px; color: #fff; flex-shrink: 0; }
.oc-logo-text { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 17px; letter-spacing: -.3px; color: var(--oc-text); }
.oc-avatar-wrap { padding: 16px 18px; border-bottom: 1px solid var(--oc-border); flex-shrink: 0; }
.oc-avatar-row { display: flex; align-items: center; gap: 11px; }
.oc-avatar { width: 42px; height: 42px; border-radius: 50%; background: var(--oc-red); display: flex; align-items: center; justify-content: center; font-family: 'Syne', sans-serif; font-weight: 700; font-size: 16px; color: #fff; flex-shrink: 0; overflow: hidden; }
.oc-avatar img { width: 100%; height: 100%; object-fit: cover; }
.oc-user-name { font-family: 'Syne', sans-serif; font-weight: 600; font-size: 13px; color: var(--oc-text); line-height: 1.3; }
.oc-user-joined { font-size: 11px; color: var(--oc-muted); margin-top: 2px; }
.oc-edit-btn { margin-left: auto; background: none; border: none; color: var(--oc-muted); cursor: pointer; width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; transition: all .2s; flex-shrink: 0; }
.oc-edit-btn:hover { background: var(--oc-border); color: var(--oc-red); }
.oc-nav { flex: 1; padding: 12px 10px; overflow-y: auto; display: flex; flex-direction: column; gap: 2px; }
.oc-nav::-webkit-scrollbar { width: 3px; }
.oc-nav::-webkit-scrollbar-thumb { background: var(--oc-border2); border-radius: 3px; }
.oc-nav-item { display: flex; align-items: center; gap: 11px; padding: 10px 12px; border-radius: var(--oc-radius-sm); cursor: pointer; transition: all .2s; color: var(--oc-muted); font-size: 13.5px; font-weight: 500; border: none; background: none; width: 100%; text-align: left; font-family: 'DM Sans', sans-serif; }
.oc-nav-item:hover { background: var(--oc-surface2); color: var(--oc-text); }
.oc-nav-item.active { background: var(--oc-red-dim); color: var(--oc-red); font-weight: 600; }
.oc-nav-icon { width: 18px; text-align: center; font-size: 14px; flex-shrink: 0; }
.oc-nav-label { flex: 1; }
.oc-badge { padding: 2px 7px; border-radius: 20px; font-size: 10px; font-weight: 700; line-height: 1.5; }
.oc-badge.danger  { background: var(--oc-red); color: #fff; }
.oc-badge.warning { background: var(--oc-amber); color: #000; }
.oc-signout-wrap { padding: 12px 10px; border-top: 1px solid var(--oc-border); flex-shrink: 0; }
.oc-signout-btn { display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 12px; background: none; border: 1px solid var(--oc-border2); border-radius: var(--oc-radius-sm); color: var(--oc-muted); font-size: 13px; font-weight: 500; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.oc-signout-btn:hover { background: rgba(232,25,44,.08); border-color: var(--oc-red); color: var(--oc-red); }

/* ── MAIN ── */
.oc-main { margin-left: var(--oc-sidebar-w); flex: 1; min-height: 100vh; padding: 32px 28px 56px; background: var(--oc-bg); max-width: calc(100vw - var(--oc-sidebar-w)); }
.oc-section { display: none; }
.oc-section.active { display: block; animation: ocFadeUp .3s ease both; }
@keyframes ocFadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

/* ── PAGE HEADER ── */
.oc-page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
.oc-page-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 22px; color: var(--oc-text); flex: 1; }
.oc-back-btn { width: 36px; height: 36px; border-radius: var(--oc-radius-sm); border: 1px solid var(--oc-border2); background: var(--oc-surface); color: var(--oc-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .2s; flex-shrink: 0; }
.oc-back-btn:hover { border-color: var(--oc-red); color: var(--oc-red); }
.oc-action-btn { display: flex; align-items: center; gap: 7px; padding: 9px 16px; background: var(--oc-red); color: #fff; border: none; border-radius: var(--oc-radius-sm); font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.oc-action-btn:hover { background: #c8102e; transform: translateY(-1px); }

/* ── STATS ── */
.oc-stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
.oc-stat-card { background: var(--oc-surface); border: 1px solid var(--oc-border); border-radius: var(--oc-radius); padding: 22px 20px; position: relative; overflow: hidden; transition: border-color .2s, transform .2s; cursor: pointer; }
.oc-stat-card::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--oc-red); transform: scaleX(0); transition: transform .3s; transform-origin: left; }
.oc-stat-card:hover { border-color: var(--oc-border2); transform: translateY(-2px); }
.oc-stat-card:hover::after { transform: scaleX(1); }
.oc-stat-icon { width: 36px; height: 36px; background: var(--oc-red-dim); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--oc-red); font-size: 15px; margin-bottom: 16px; }
.oc-stat-number { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 24px; color: var(--oc-text); line-height: 1; margin-bottom: 6px; }
.oc-stat-label { font-size: 11px; color: var(--oc-muted); font-weight: 500; text-transform: uppercase; letter-spacing: .6px; }

/* ── CARD ── */
.oc-card { background: var(--oc-surface); border: 1px solid var(--oc-border); border-radius: var(--oc-radius); padding: 24px; margin-bottom: 16px; }
.oc-card-title { font-family: 'Syne', sans-serif; font-weight: 600; font-size: 15px; color: var(--oc-text); margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
.oc-card-title i { color: var(--oc-red); font-size: 14px; }

/* ── INFO ROWS ── */
.oc-address-tag { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; background: var(--oc-red-dim); border: 1px solid var(--oc-red); border-radius: 20px; color: var(--oc-red); font-size: 10px; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; margin-bottom: 14px; }
.oc-address-type { font-size: 13px; color: var(--oc-muted); font-weight: 500; margin-bottom: 14px; }
.oc-info-row { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px; font-size: 13px; color: var(--oc-muted); }
.oc-info-row i { color: var(--oc-red); font-size: 12px; margin-top: 2px; flex-shrink: 0; width: 14px; }
.oc-info-row span { color: var(--oc-text2); }
.oc-manage-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: var(--oc-surface2); border: 1px solid var(--oc-border2); border-radius: var(--oc-radius-sm); color: var(--oc-muted); font-size: 13px; font-weight: 500; cursor: pointer; margin-top: 16px; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.oc-manage-btn:hover { border-color: var(--oc-red); color: var(--oc-red); }

/* ── FILTER TABS ── */
.oc-filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px; }
.oc-filter-btn { padding: 7px 14px; border-radius: 20px; border: 1px solid var(--oc-border2); background: none; color: var(--oc-muted); font-size: 12px; font-weight: 500; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.oc-filter-btn:hover, .oc-filter-btn.active { background: var(--oc-red); border-color: var(--oc-red); color: #fff; }

/* ── STATUS BADGES ── */
.oc-status-badge { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; }
.oc-status-badge.pending    { background: rgba(245,158,11,.12); color: var(--oc-amber); border: 1px solid rgba(245,158,11,.3); }
.oc-status-badge.processing { background: rgba(59,130,246,.12);  color: var(--oc-blue);  border: 1px solid rgba(59,130,246,.3); }
.oc-status-badge.shipped    { background: rgba(59,130,246,.12);  color: var(--oc-blue);  border: 1px solid rgba(59,130,246,.3); }
.oc-status-badge.delivered  { background: rgba(34,197,94,.12);   color: var(--oc-green); border: 1px solid rgba(34,197,94,.3); }
.oc-status-badge.cancelled  { background: var(--oc-red-dim);     color: var(--oc-red);   border: 1px solid rgba(232,25,44,.3); }
.oc-status-badge.in_transit { background: rgba(139,92,246,.12);  color: #a78bfa;         border: 1px solid rgba(139,92,246,.3); }
.oc-status-badge.reviewed   { background: rgba(34,197,94,.12);   color: var(--oc-green); border: 1px solid rgba(34,197,94,.3); }

/* ── ORDER ITEM ── */
.oc-order-item { background: var(--oc-surface); border: 1px solid var(--oc-border); border-radius: var(--oc-radius); padding: 18px 20px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; transition: border-color .2s; gap: 10px; }
.oc-order-item:hover { border-color: var(--oc-border2); }
.oc-order-item[data-status="cancelled"] { opacity: .7; }
.oc-order-num { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 6px; }
.oc-order-label  { font-size: 12px; color: var(--oc-muted); }
.oc-order-id     { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 14px; color: var(--oc-text); }
.oc-order-date   { font-size: 12px; color: var(--oc-muted); }
.oc-order-total  { font-size: 12px; color: var(--oc-muted); margin-top: 4px; }
.oc-order-total strong { color: var(--oc-text2); font-family: 'Syne', sans-serif; }
.oc-copy-btn { background: none; border: none; color: var(--oc-muted); cursor: pointer; font-size: 12px; padding: 2px 5px; transition: color .2s; }
.oc-copy-btn:hover { color: var(--oc-red); }
.oc-order-actions { display: flex; gap: 8px; align-items: center; flex-shrink: 0; }
.oc-cancel-order-btn { padding: 6px 12px; background: rgba(232,25,44,.08); border: 1px solid rgba(232,25,44,.25); border-radius: 6px; color: var(--oc-red); font-size: 11px; font-weight: 600; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.oc-cancel-order-btn:hover { background: var(--oc-red); color: #fff; }
.oc-order-items-mini { margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--oc-border); display: none; }
.oc-order-items-mini.show { display: block; animation: ocFadeUp .2s ease; }
.oc-order-item-mini-row { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; font-size: 12px; color: var(--oc-muted2); }
.oc-order-item-mini-row img { width: 36px; height: 36px; border-radius: 6px; object-fit: cover; border: 1px solid var(--oc-border); flex-shrink: 0; }
.oc-order-item-mini-name { color: var(--oc-text2); font-weight: 500; flex: 1; }

/* ── FORM ── */
.oc-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.oc-form-group { display: flex; flex-direction: column; gap: 7px; }
.oc-form-full  { grid-column: 1 / -1; }
.oc-form-label { font-size: 11px; font-weight: 600; color: var(--oc-muted); text-transform: uppercase; letter-spacing: .5px; }
.oc-form-input, .oc-form-select, .oc-form-textarea { background: var(--oc-surface2); border: 1px solid var(--oc-border2); border-radius: var(--oc-radius-sm); color: var(--oc-text); font-family: 'DM Sans', sans-serif; font-size: 14px; padding: 11px 14px; transition: border-color .2s, box-shadow .2s; outline: none; width: 100%; }
.oc-form-input::placeholder, .oc-form-textarea::placeholder { color: var(--oc-muted2); }
.oc-form-input:focus, .oc-form-select:focus, .oc-form-textarea:focus { border-color: var(--oc-red); box-shadow: 0 0 0 3px var(--oc-red-dim); }
.oc-form-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23888' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; background-size: 12px; cursor: pointer; }
.oc-form-textarea { resize: vertical; min-height: 110px; }
.oc-char-count { font-size: 11px; color: var(--oc-muted2); text-align: right; margin-top: 4px; }
.oc-checkbox-wrap { display: flex; align-items: center; gap: 10px; }
.oc-checkbox-wrap input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--oc-red); cursor: pointer; }
.oc-checkbox-label { font-size: 13px; color: var(--oc-muted); cursor: pointer; }
.oc-checkbox-label a { color: var(--oc-red); text-decoration: none; }
.oc-phone-row { display: flex; gap: 8px; }
.oc-phone-code { width: 70px; flex-shrink: 0; }
.oc-form-actions { display: flex; gap: 10px; justify-content: flex-end; }
.oc-save-btn { padding: 11px 24px; background: var(--oc-red); color: #fff; border: none; border-radius: var(--oc-radius-sm); font-size: 14px; font-weight: 600; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.oc-save-btn:hover { background: #c8102e; transform: translateY(-1px); }
.oc-cancel-btn { padding: 11px 20px; background: var(--oc-surface2); color: var(--oc-muted); border: 1px solid var(--oc-border2); border-radius: var(--oc-radius-sm); font-size: 14px; font-weight: 500; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.oc-cancel-btn:hover { border-color: var(--oc-red); color: var(--oc-red); }

/* ── TABS ── */
.oc-tabs { display: flex; border-bottom: 1px solid var(--oc-border); margin-bottom: 24px; overflow-x: auto; }
.oc-tab-btn { padding: 10px 20px; background: none; border: none; border-bottom: 2px solid transparent; color: var(--oc-muted); font-size: 13.5px; font-weight: 500; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; margin-bottom: -1px; white-space: nowrap; }
.oc-tab-btn:hover { color: var(--oc-text); }
.oc-tab-btn.active { border-bottom-color: var(--oc-red); color: var(--oc-red); font-weight: 600; }
.oc-tab-content { display: none; }
.oc-tab-content.active { display: block; animation: ocFadeUp .25s ease; }

/* ── TOGGLE ── */
.oc-pref-item { display: flex; align-items: center; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid var(--oc-border); }
.oc-pref-item:last-of-type { border-bottom: none; }
.oc-pref-label { font-size: 14px; color: var(--oc-text2); font-weight: 500; }
.oc-toggle { position: relative; display: inline-block; width: 46px; height: 24px; }
.oc-toggle input { opacity: 0; width: 0; height: 0; }
.oc-toggle-slider { position: absolute; inset: 0; background: var(--oc-border2); border-radius: 24px; transition: .3s; cursor: pointer; }
.oc-toggle-slider::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: .3s; }
.oc-toggle input:checked + .oc-toggle-slider { background: var(--oc-red); }
.oc-toggle input:checked + .oc-toggle-slider::before { transform: translateX(22px); }

/* ══════════════════════════════════════
   REVIEW SECTION — FULL INLINE DESIGN
══════════════════════════════════════ */
.oc-review-card { background: var(--oc-surface); border: 1px solid var(--oc-border); border-radius: var(--oc-radius); margin-bottom: 20px; overflow: hidden; transition: border-color .2s; }
.oc-review-card:hover { border-color: var(--oc-border2); }
.oc-review-card.is-reviewed { border-color: rgba(34,197,94,.2); }

.oc-review-card-header { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--oc-border); background: var(--oc-surface2); flex-wrap: wrap; gap: 10px; }
.oc-review-order-meta { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--oc-muted); flex-wrap: wrap; }
.oc-review-order-meta strong { color: var(--oc-text); font-family: 'Syne', sans-serif; font-size: 13px; }

.oc-review-product-strip { display: flex; align-items: center; gap: 14px; padding: 16px 20px; border-bottom: 1px solid var(--oc-border); }
.oc-review-product-strip img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; border: 1px solid var(--oc-border2); flex-shrink: 0; }
.oc-review-product-info-text { flex: 1; min-width: 0; }
.oc-review-product-info-text h4 { font-size: 14px; font-weight: 600; color: var(--oc-text); margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.oc-review-product-info-text p  { font-size: 12px; color: var(--oc-muted); }

/* Status pill right side of product strip */
.oc-order-status-pill { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }

/* Already-reviewed display */
.oc-reviewed-display { padding: 16px 20px; }
.oc-reviewed-stars { display: flex; align-items: center; gap: 4px; margin-bottom: 10px; }
.oc-reviewed-text { font-size: 13px; color: var(--oc-text2); line-height: 1.6; background: var(--oc-surface2); border-left: 3px solid var(--oc-amber); padding: 10px 14px; border-radius: 0 6px 6px 0; margin-bottom: 10px; font-style: italic; }
.oc-reviewed-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }

/* Trigger area */
.oc-review-form-trigger { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; flex-wrap: wrap; gap: 10px; }
.oc-write-review-trigger { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: var(--oc-red-dim); border: 1px solid rgba(232,25,44,.35); border-radius: var(--oc-radius-sm); color: var(--oc-red); font-size: 13px; font-weight: 700; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.oc-write-review-trigger:hover { background: var(--oc-red); color: #fff; box-shadow: 0 4px 14px rgba(232,25,44,.3); }

/* Inline form panel */
.oc-review-form-panel { padding: 20px; display: none; border-top: 1px solid var(--oc-border); background: var(--oc-surface2); }
.oc-review-form-panel.show { display: block; animation: ocFadeUp .25s ease; }

/* Star rating */
.oc-star-rating-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
.oc-star-rating-label { font-size: 11px; font-weight: 600; color: var(--oc-muted); text-transform: uppercase; letter-spacing: .5px; }
.oc-star-row { display: flex; gap: 6px; }
.oc-star-btn { font-size: 30px; color: var(--oc-muted2); cursor: pointer; background: none; border: none; padding: 0; line-height: 1; transition: color .15s, transform .15s; }
.oc-star-btn:hover  { transform: scale(1.2); }
.oc-star-btn.active { color: var(--oc-amber); }
.oc-star-label-hint { font-size: 13px; color: var(--oc-amber); font-weight: 600; min-height: 20px; }

/* Textarea */
.oc-review-textarea-wrap { margin-bottom: 18px; }
.oc-review-textarea-wrap label { font-size: 11px; font-weight: 600; color: var(--oc-muted); text-transform: uppercase; letter-spacing: .5px; display: block; margin-bottom: 8px; }
.oc-review-textarea { width: 100%; background: var(--oc-surface); border: 1px solid var(--oc-border2); border-radius: var(--oc-radius-sm); color: var(--oc-text); font-family: 'DM Sans', sans-serif; font-size: 14px; padding: 12px 14px; transition: border-color .2s, box-shadow .2s; outline: none; resize: vertical; min-height: 120px; line-height: 1.6; }
.oc-review-textarea::placeholder { color: var(--oc-muted2); }
.oc-review-textarea:focus { border-color: var(--oc-red); box-shadow: 0 0 0 3px var(--oc-red-dim); }

/* Error */
.oc-review-form-error { display: none; background: var(--oc-red-dim); border: 1px solid rgba(232,25,44,.3); border-radius: var(--oc-radius-sm); padding: 10px 14px; margin-bottom: 14px; font-size: 13px; color: var(--oc-red); gap: 8px; align-items: center; }
.oc-review-form-error.show { display: flex; }

/* Form actions */
.oc-review-form-actions { display: flex; align-items: center; gap: 10px; justify-content: flex-end; flex-wrap: wrap; }
.oc-review-submit-btn { display: inline-flex; align-items: center; gap: 8px; padding: 11px 22px; background: var(--oc-amber); color: #000; border: none; border-radius: var(--oc-radius-sm); font-size: 14px; font-weight: 700; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.oc-review-submit-btn:hover { background: #d97706; transform: translateY(-1px); box-shadow: 0 5px 16px rgba(245,158,11,.35); }
.oc-review-dismiss-btn { padding: 11px 18px; background: var(--oc-surface); color: var(--oc-muted); border: 1px solid var(--oc-border2); border-radius: var(--oc-radius-sm); font-size: 14px; font-weight: 500; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.oc-review-dismiss-btn:hover { border-color: var(--oc-red); color: var(--oc-red); }

/* ══════════════════════════════════
   ORDER HISTORY SECTION
══════════════════════════════════ */
.oh-stats-row { display: grid; grid-template-columns: repeat(6,1fr); gap: 10px; margin-bottom: 24px; }
.oh-stat { background: var(--oc-surface); border: 1px solid var(--oc-border); border-radius: var(--oc-radius-sm); padding: 14px 12px; text-align: center; transition: border-color .2s; }
.oh-stat:hover { border-color: var(--oc-border2); }
.oh-stat-num { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 20px; color: var(--oc-text); line-height: 1; margin-bottom: 4px; }
.oh-stat-lbl { font-size: 10px; color: var(--oc-muted); text-transform: uppercase; letter-spacing: .5px; font-weight: 600; }

/* Search + filter bar */
.oh-search-bar { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }
.oh-search-input { flex: 1; min-width: 180px; background: var(--oc-surface); border: 1px solid var(--oc-border2); border-radius: var(--oc-radius-sm); color: var(--oc-text); font-family: 'DM Sans', sans-serif; font-size: 13px; padding: 10px 14px; outline: none; transition: border-color .2s; }
.oh-search-input:focus { border-color: var(--oc-red); }
.oh-search-input::placeholder { color: var(--oc-muted2); }
.oh-status-select { background: var(--oc-surface); border: 1px solid var(--oc-border2); border-radius: var(--oc-radius-sm); color: var(--oc-text); font-family: 'DM Sans', sans-serif; font-size: 13px; padding: 10px 14px; outline: none; cursor: pointer; min-width: 130px; }

/* History table */
.oh-table-wrap { overflow-x: auto; }
.oh-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.oh-table th { padding: 10px 14px; text-align: left; font-size: 10px; font-weight: 700; color: var(--oc-muted); text-transform: uppercase; letter-spacing: .6px; border-bottom: 1px solid var(--oc-border); white-space: nowrap; }
.oh-table td { padding: 14px; border-bottom: 1px solid var(--oc-border); vertical-align: middle; }
.oh-table tr:last-child td { border-bottom: none; }
.oh-table tr:hover td { background: var(--oc-surface2); }
.oh-order-num { font-family: 'Syne', sans-serif; font-weight: 700; color: var(--oc-text); font-size: 13px; }
.oh-date { color: var(--oc-muted); font-size: 12px; }
.oh-total { font-family: 'Syne', sans-serif; font-weight: 700; color: var(--oc-text); }
.oh-items-count { color: var(--oc-muted); font-size: 12px; }

/* Expand row */
.oh-detail-row { display: none; }
.oh-detail-row.show { display: table-row; }
.oh-detail-row td { background: var(--oc-surface2); padding: 0; }
.oh-detail-inner { padding: 16px 20px; }
.oh-detail-item { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid var(--oc-border); font-size: 12px; color: var(--oc-muted); }
.oh-detail-item:last-child { border-bottom: none; }
.oh-detail-item img { width: 36px; height: 36px; border-radius: 6px; object-fit: cover; border: 1px solid var(--oc-border); flex-shrink: 0; }
.oh-detail-item-name { flex: 1; color: var(--oc-text2); font-weight: 500; }

/* Pagination */
.oh-pagination { display: flex; align-items: center; justify-content: space-between; margin-top: 20px; flex-wrap: wrap; gap: 10px; }
.oh-page-info { font-size: 12px; color: var(--oc-muted); }
.oh-pages { display: flex; gap: 4px; }
.oh-pages a, .oh-pages span { display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; border: 1px solid var(--oc-border); color: var(--oc-muted); transition: all .2s; }
.oh-pages a:hover { border-color: var(--oc-red); color: var(--oc-red); }
.oh-pages span.active { background: var(--oc-red); border-color: var(--oc-red); color: #fff; }

/* ── SAVED ITEMS ── */
.oc-pagination { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
.oc-page-info  { font-size: 13px; color: var(--oc-muted); display: flex; align-items: center; gap: 10px; }
.oc-products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
.oc-product-card { background: var(--oc-surface); border: 1px solid var(--oc-border); border-radius: var(--oc-radius); overflow: hidden; position: relative; transition: border-color .2s, transform .2s; }
.oc-product-card:hover { border-color: var(--oc-border2); transform: translateY(-3px); }
.oc-remove-btn { position: absolute; top: 10px; right: 10px; width: 28px; height: 28px; background: rgba(13,13,13,.8); border: 1px solid var(--oc-border2); border-radius: 6px; color: var(--oc-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 11px; transition: all .2s; z-index: 2; }
.oc-remove-btn:hover { background: var(--oc-red); border-color: var(--oc-red); color: #fff; }
.oc-product-img-wrap { position: relative; height: 160px; overflow: hidden; }
.oc-product-img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
.oc-product-card:hover .oc-product-img { transform: scale(1.04); }
.oc-brand-badge { position: absolute; bottom: 8px; left: 8px; background: var(--oc-red); color: #fff; font-size: 9px; font-weight: 700; padding: 3px 7px; border-radius: 4px; }
.oc-product-body { padding: 14px; }
.oc-product-title-text { font-size: 12px; color: var(--oc-text2); font-weight: 500; line-height: 1.5; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.oc-price-row { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-bottom: 8px; }
.oc-current-price { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 15px; color: var(--oc-text); }
.oc-old-price { font-size: 11px; color: var(--oc-muted2); text-decoration: line-through; }
.oc-discount  { font-size: 10px; font-weight: 700; color: var(--oc-green); background: rgba(34,197,94,.1); padding: 2px 5px; border-radius: 4px; }
.oc-add-cart-btn { width: 100%; padding: 9px; background: var(--oc-red-dim); border: 1px solid rgba(232,25,44,.25); border-radius: var(--oc-radius-sm); color: var(--oc-red); font-size: 12px; font-weight: 600; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.oc-add-cart-btn:hover { background: var(--oc-red); color: #fff; }

/* ── MISC ── */
.oc-empty { text-align: center; padding: 60px 20px; color: var(--oc-muted); }
.oc-empty i { font-size: 44px; color: var(--oc-border2); display: block; margin-bottom: 12px; }
.oc-empty p { font-size: 14px; }
.oc-toast-el { position: fixed; bottom: 24px; right: 24px; background: var(--oc-red); color: #fff; padding: 12px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: 'DM Sans', sans-serif; box-shadow: 0 6px 20px rgba(0,0,0,.3); z-index: 99999; animation: ocFadeUp .3s ease; }
.oc-alert { padding: 12px 18px; border-radius: var(--oc-radius-sm); margin-bottom: 16px; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 10px; }
.oc-alert.success { background: rgba(34,197,94,.12); border: 1px solid rgba(34,197,94,.3); color: var(--oc-green); }
.oc-alert.error   { background: var(--oc-red-dim); border: 1px solid rgba(232,25,44,.3); color: var(--oc-red); }
.oc-alert.info    { background: rgba(59,130,246,.12); border: 1px solid rgba(59,130,246,.3); color: var(--oc-blue); }

/* ── MODAL ── */
.oc-modal-bg { display: none; position: fixed; inset: 0; z-index: 9000; background: rgba(0,0,0,.75); backdrop-filter: blur(4px); align-items: center; justify-content: center; }
.oc-modal-bg.show { display: flex; }
.oc-modal-box { background: var(--oc-surface); border: 1px solid var(--oc-border2); border-radius: var(--oc-radius); padding: 28px 24px; max-width: 380px; width: 90%; text-align: center; animation: ocFadeUp .25s ease; }
.oc-modal-icon  { font-size: 40px; color: var(--oc-red); margin-bottom: 14px; }
.oc-modal-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 18px; color: var(--oc-text); margin-bottom: 8px; }
.oc-modal-desc  { font-size: 13px; color: var(--oc-muted); margin-bottom: 24px; line-height: 1.6; }
.oc-modal-actions { display: flex; gap: 10px; }
.oc-modal-confirm-btn { flex: 1; padding: 11px; background: var(--oc-red); color: #fff; border: none; border-radius: var(--oc-radius-sm); font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; }
.oc-modal-cancel-btn  { flex: 1; padding: 11px; background: var(--oc-surface2); color: var(--oc-muted); border: 1px solid var(--oc-border2); border-radius: var(--oc-radius-sm); font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'DM Sans', sans-serif; }

/* ── ADDRESS ── */
.oc-address-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; }
.oc-address-actions { display: flex; gap: 8px; margin-top: 16px; }
.oc-del-btn, .oc-edit2-btn { flex: 1; padding: 8px; border-radius: var(--oc-radius-sm); font-size: 12px; font-weight: 600; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif; }
.oc-del-btn { background: rgba(232,25,44,.08); border: 1px solid rgba(232,25,44,.2); color: var(--oc-red); }
.oc-del-btn:hover { background: rgba(232,25,44,.18); }
.oc-edit2-btn { background: var(--oc-surface2); border: 1px solid var(--oc-border2); color: var(--oc-muted); }
.oc-edit2-btn:hover { border-color: var(--oc-red); color: var(--oc-red); }

/* ── RESPONSIVE ── */
@media (max-width: 1100px) { .oc-stats-grid { grid-template-columns: repeat(2,1fr); } .oh-stats-row { grid-template-columns: repeat(3,1fr); } }
@media (max-width: 900px)  { .oc-form-grid { grid-template-columns: 1fr; } .oc-form-full { grid-column: 1; } }
@media (max-width: 768px) {
    .oc-topbar { display: flex; }
    .oc-sidebar { top: 0; height: 100vh; transform: translateX(-100%); z-index: 510; transition: transform .3s cubic-bezier(.4,0,.2,1), box-shadow .3s; }
    .oc-sidebar.open { transform: translateX(0); box-shadow: 4px 0 30px rgba(0,0,0,.6); }
    .oc-main { margin-left: 0; max-width: 100vw; padding: 70px 16px 32px; }
    .oc-review-card-header { flex-direction: column; align-items: flex-start; }
    .oh-stats-row { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 480px) {
    .oc-stats-grid { grid-template-columns: 1fr 1fr; }
    .oc-stat-number { font-size: 20px; }
    .oc-page-title { font-size: 18px; }
    .oc-products-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); }
    .oc-star-btn { font-size: 26px; }
    .oh-stats-row { grid-template-columns: repeat(2,1fr); }
}
</style>

{{-- ══ SESSION ALERTS ══ --}}
@if(session('success') || session('error') || session('info'))
<div style="position:fixed;top:70px;right:20px;z-index:99998;min-width:280px;max-width:360px;">
    @if(session('success'))
        <div class="oc-alert success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="oc-alert error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="oc-alert info"><i class="fas fa-info-circle"></i> {{ session('info') }}</div>
    @endif
</div>
@endif

<!-- ══ MOBILE TOPBAR ══ -->
<div class="oc-topbar">
    <button class="oc-hamburger" id="oc-hamburger-btn" onclick="ocToggleSidebar()">
        <i class="fas fa-bars bar-icon"></i>
        <i class="fas fa-times close-icon"></i>
    </button>
    <span class="oc-topbar-title">My Account</span>
    <div style="width:38px;"></div>
</div>

<div class="oc-overlay" id="oc-overlay" onclick="ocToggleSidebar()"></div>

<!-- ══ CANCEL ORDER MODAL ══ -->
<div class="oc-modal-bg" id="oc-cancel-modal">
    <div class="oc-modal-box">
        <div class="oc-modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="oc-modal-title">অর্ডার বাতিল করবেন?</div>
        <div class="oc-modal-desc" id="oc-modal-order-text">এই অর্ডারটি বাতিল করা হলে আর ফিরিয়ে আনা যাবে না।</div>
        <div class="oc-modal-actions">
            <button class="oc-modal-cancel-btn" onclick="ocCloseModal('oc-cancel-modal')">না, রাখুন</button>
            <button class="oc-modal-confirm-btn" id="oc-modal-confirm-btn">হ্যাঁ, বাতিল করুন</button>
        </div>
    </div>
</div>

<!-- ══ SHELL ══ -->
<div class="oc-shell">

    <!-- ════ SIDEBAR ════ -->
    <aside class="oc-sidebar" id="oc-sidebar">
        <div class="oc-sidebar-logo">
            <div class="oc-logo-mark">S</div>
            <span class="oc-logo-text">Shahzadi</span>
        </div>
        <div class="oc-avatar-wrap">
            <div class="oc-avatar-row">
                <div class="oc-avatar">
                    @auth
                        @if(Auth::user()->photo)
                            <img src="{{ Auth::user()->photo_url }}" alt="avatar">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    @endauth
                </div>
                <div>
                    <div class="oc-user-name">@auth {{ Auth::user()->name }} @endauth</div>
                    <div class="oc-user-joined">@auth Joined: {{ Auth::user()->created_at->format('jS F, Y') }} @endauth</div>
                </div>
                <button class="oc-edit-btn" onclick="ocShow('manage-account')" title="Edit Profile">
                    <i class="fas fa-pen" style="font-size:11px;"></i>
                </button>
            </div>
        </div>
        <nav class="oc-nav">
            <button class="oc-nav-item active" onclick="ocShow('dashboard')">
                <i class="fas fa-chart-pie oc-nav-icon"></i>
                <span class="oc-nav-label">Dashboard</span>
            </button>
            <button class="oc-nav-item" onclick="ocShow('orders')">
                <i class="fas fa-shopping-bag oc-nav-icon"></i>
                <span class="oc-nav-label">My Orders</span>
                @if($totalOrders > 0)
                    <span class="oc-badge danger">{{ $totalOrders }}</span>
                @endif
            </button>
            <button class="oc-nav-item" onclick="ocShow('order-history')">
                <i class="fas fa-history oc-nav-icon"></i>
                <span class="oc-nav-label">Order History</span>
            </button>
            <button class="oc-nav-item" onclick="ocShow('address-book')">
                <i class="fas fa-address-book oc-nav-icon"></i>
                <span class="oc-nav-label">Address Book</span>
            </button>
            <button class="oc-nav-item" onclick="ocShow('reviews')">
                <i class="fas fa-star oc-nav-icon"></i>
                <span class="oc-nav-label">Write Reviews</span>
                @if($pendingReviewCount > 0)
                    <span class="oc-badge warning">{{ $pendingReviewCount }}</span>
                @endif
            </button>
            <button class="oc-nav-item" onclick="ocShow('notifications')">
                <i class="fas fa-bell oc-nav-icon"></i>
                <span class="oc-nav-label">Notifications</span>
            </button>
            <button class="oc-nav-item" onclick="ocShow('saved-items')">
                <i class="fas fa-heart oc-nav-icon"></i>
                <span class="oc-nav-label">Saved Items</span>
                @if($wishlistCount > 0)
                    <span class="oc-badge warning">{{ $wishlistCount }}</span>
                @endif
            </button>
        </nav>
        <div class="oc-signout-wrap">
            <form id="oc-logout-form" action="{{ route('customer.logout') }}" method="POST" style="display:none;">@csrf</form>
            <button class="oc-signout-btn" onclick="document.getElementById('oc-logout-form').submit()">
                <i class="fas fa-sign-out-alt"></i> <span>Sign Out</span>
            </button>
        </div>
    </aside>

    <!-- ════ MAIN ════ -->
    <main class="oc-main">

        <!-- ══ DASHBOARD ══ -->
        <section class="oc-section active" id="oc-section-dashboard">
            <div class="oc-stats-grid">
                <div class="oc-stat-card" onclick="ocShow('orders')">
                    <div class="oc-stat-icon"><i class="fas fa-shopping-bag"></i></div>
                    <div class="oc-stat-number">{{ $totalOrders }}</div>
                    <div class="oc-stat-label">Total Orders</div>
                </div>
                <div class="oc-stat-card" onclick="ocShowFiltered('orders','pending')">
                    <div class="oc-stat-icon"><i class="fas fa-clock"></i></div>
                    <div class="oc-stat-number">{{ $pendingOrders }}</div>
                    <div class="oc-stat-label">Pending</div>
                </div>
                <div class="oc-stat-card" onclick="ocShowFiltered('orders','delivered')">
                    <div class="oc-stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="oc-stat-number">{{ $deliveredOrders }}</div>
                    <div class="oc-stat-label">Delivered</div>
                </div>
                <div class="oc-stat-card" onclick="ocShow('saved-items')">
                    <div class="oc-stat-icon"><i class="fas fa-heart"></i></div>
                    <div class="oc-stat-number">{{ $wishlistCount }}</div>
                    <div class="oc-stat-label">Saved Items</div>
                </div>
            </div>
            <div class="oc-card">
                <div class="oc-card-title"><i class="fas fa-map-marker-alt"></i> Default Delivery Address</div>
                <div class="oc-address-tag"><i class="fas fa-check-circle"></i> Default Address</div>
                <div class="oc-address-type">Door to Door Delivery</div>
                <div class="oc-info-row"><i class="fas fa-user"></i><span>@auth {{ strtoupper(Auth::user()->name) }} @endauth</span></div>
                <div class="oc-info-row"><i class="fas fa-phone"></i><span>@auth {{ Auth::user()->phone ?? 'Not set' }} @endauth</span></div>
                <div class="oc-info-row"><i class="fas fa-map-marker-alt"></i><span>No address saved yet</span></div>
                <button class="oc-manage-btn" onclick="ocShow('address-book')"><i class="fas fa-cog"></i> Manage Address</button>
            </div>
            @if($orders->count() > 0)
            <div class="oc-card">
                <div class="oc-card-title" style="justify-content:space-between;">
                    <span><i class="fas fa-shopping-bag"></i> Recent Orders</span>
                    <button onclick="ocShow('orders')" style="background:none;border:none;color:var(--oc-red);font-size:12px;cursor:pointer;font-weight:600;">View All <i class="fas fa-arrow-right" style="font-size:10px;"></i></button>
                </div>
                @foreach($orders->take(3) as $recentOrder)
                <div class="oc-order-item" style="margin-bottom:8px;" data-status="{{ $recentOrder->order_status }}">
                    <div style="flex:1;min-width:0;">
                        <div class="oc-order-num">
                            <span class="oc-order-label">Order No:</span>
                            <span class="oc-order-id">{{ $recentOrder->order_number }}</span>
                            <span class="oc-status-badge {{ $recentOrder->order_status }}">{{ ucfirst($recentOrder->order_status) }}</span>
                        </div>
                        <div class="oc-order-date">{{ $recentOrder->created_at->format('d-m-Y H:i') }}</div>
                        <div class="oc-order-total">মোট: <strong>৳{{ number_format($recentOrder->total, 2) }}</strong></div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Quick review prompt --}}
            @if($pendingReviewCount > 0)
            <div style="background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.25);border-radius:var(--oc-radius);padding:18px 20px;display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:38px;height:38px;background:rgba(245,158,11,.15);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--oc-amber);font-size:16px;flex-shrink:0;">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;color:var(--oc-text);font-size:14px;">{{ $pendingReviewCount }}টি পণ্যে রিভিউ বাকি</div>
                        <div style="font-size:12px;color:var(--oc-muted);margin-top:2px;">আপনার অর্ডার করা পণ্যগুলোতে রিভিউ দিন</div>
                    </div>
                </div>
                <button onclick="ocShow('reviews')" style="padding:9px 18px;background:var(--oc-amber);color:#000;border:none;border-radius:var(--oc-radius-sm);font-weight:700;font-size:13px;cursor:pointer;font-family:'DM Sans',sans-serif;">
                    রিভিউ লিখুন <i class="fas fa-arrow-right" style="font-size:11px;"></i>
                </button>
            </div>
            @endif
        </section>

        <!-- ══ MY ORDERS ══ -->
        <section class="oc-section" id="oc-section-orders">
            <div class="oc-page-header">
                <button class="oc-back-btn" onclick="ocShow('dashboard')"><i class="fas fa-arrow-left"></i></button>
                <h1 class="oc-page-title">My Orders</h1>
                <button class="oc-action-btn" onclick="ocShow('order-history')"><i class="fas fa-history"></i> Full History</button>
            </div>
            <div class="oc-filter-tabs" id="oc-orders-filter">
                <button class="oc-filter-btn active" data-filter="all">All</button>
                <button class="oc-filter-btn" data-filter="pending">Pending</button>
                <button class="oc-filter-btn" data-filter="processing">Processing</button>
                <button class="oc-filter-btn" data-filter="shipped">Shipped</button>
                <button class="oc-filter-btn" data-filter="in_transit">In Transit</button>
                <button class="oc-filter-btn" data-filter="delivered">Delivered</button>
                <button class="oc-filter-btn" data-filter="cancelled">Cancelled</button>
            </div>
            <div id="oc-orders-list">
                @forelse($orders as $order)
                <div class="oc-order-item" data-status="{{ $order->order_status }}" id="order-row-{{ $order->id }}">
                    <div style="flex:1;min-width:0;">
                        <div class="oc-order-num">
                            <span class="oc-order-label">Order No:</span>
                            <span class="oc-order-id">{{ $order->order_number }}</span>
                            <button class="oc-copy-btn" onclick="ocCopy('{{ $order->order_number }}')"><i class="far fa-copy"></i></button>
                            <span class="oc-status-badge {{ $order->order_status }}">{{ ucfirst(str_replace('_',' ',$order->order_status)) }}</span>
                        </div>
                        <div class="oc-order-date">Order date: {{ $order->created_at->format('d-m-Y H:i:s') }}</div>
                        <div class="oc-order-total">
                            {{ $order->items->count() }} item(s) &nbsp;|&nbsp; মোট: <strong>৳{{ number_format($order->total, 2) }}</strong>
                            @if($order->discount > 0)
                                &nbsp;| ছাড়: <span style="color:var(--oc-green)">-৳{{ number_format($order->discount, 2) }}</span>
                            @endif
                        </div>
                        <div class="oc-order-items-mini" id="order-items-{{ $order->id }}">
                            @foreach($order->items as $item)
                            <div class="oc-order-item-mini-row">
                                @if($item->product_image)
                                    <img src="{{ asset('uploads/products/'.$item->product_image) }}" alt="{{ $item->product_name }}" onerror="this.src='https://via.placeholder.com/36/222/888?text=P'">
                                @else
                                    <img src="https://via.placeholder.com/36/222/888?text=P" alt="">
                                @endif
                                <span class="oc-order-item-mini-name">{{ $item->product_name }}</span>
                                <span>x{{ $item->quantity }}</span>
                                <span style="color:var(--oc-text2);font-weight:600;">৳{{ number_format($item->subtotal, 2) }}</span>
                            </div>
                            @endforeach
                            <div style="font-size:12px;color:var(--oc-muted);padding-top:8px;border-top:1px solid var(--oc-border);display:flex;justify-content:space-between;flex-wrap:wrap;gap:6px;">
                                <span>Payment: <strong style="color:var(--oc-text2)">{{ ucfirst($order->payment_method) }}</strong></span>
                                <span>Status: <strong style="color:var(--oc-text2)">{{ ucfirst($order->payment_status) }}</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="oc-order-actions">
                        <button style="background:none;border:none;color:var(--oc-muted);cursor:pointer;padding:4px 8px;" onclick="ocToggleOrderItems({{ $order->id }})">
                            <i class="fas fa-chevron-down" id="order-chevron-{{ $order->id }}"></i>
                        </button>
                        @if(in_array($order->order_status, ['pending','processing']))
                            <button class="oc-cancel-order-btn" onclick="ocConfirmCancel('{{ $order->order_number }}','{{ $order->id }}')">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        @endif
                    </div>
                </div>
                @empty
                <div class="oc-empty"><i class="fas fa-shopping-bag"></i><p>কোনো অর্ডার নেই।</p></div>
                @endforelse
            </div>
        </section>

        <!-- ══════════════════════════════════════
             ORDER HISTORY SECTION
        ══════════════════════════════════════ -->
        <section class="oc-section" id="oc-section-order-history">
            <div class="oc-page-header">
                <button class="oc-back-btn" onclick="ocShow('dashboard')"><i class="fas fa-arrow-left"></i></button>
                <h1 class="oc-page-title"><i class="fas fa-history" style="color:var(--oc-red);font-size:18px;"></i> Order History</h1>
            </div>

            {{-- Stats row --}}
            <div class="oh-stats-row">
                <div class="oh-stat">
                    <div class="oh-stat-num">{{ $totalOrders }}</div>
                    <div class="oh-stat-lbl">Total</div>
                </div>
                <div class="oh-stat">
                    <div class="oh-stat-num" style="color:var(--oc-amber);">{{ $pendingOrders }}</div>
                    <div class="oh-stat-lbl">Pending</div>
                </div>
                <div class="oh-stat">
                    <div class="oh-stat-num" style="color:var(--oc-blue);">{{ $orders->where('order_status','processing')->count() }}</div>
                    <div class="oh-stat-lbl">Processing</div>
                </div>
                <div class="oh-stat">
                    <div class="oh-stat-num" style="color:var(--oc-blue);">{{ $orders->whereIn('order_status',['shipped','in_transit'])->count() }}</div>
                    <div class="oh-stat-lbl">Shipped</div>
                </div>
                <div class="oh-stat">
                    <div class="oh-stat-num" style="color:var(--oc-green);">{{ $deliveredOrders }}</div>
                    <div class="oh-stat-lbl">Delivered</div>
                </div>
                <div class="oh-stat">
                    <div class="oh-stat-num" style="color:var(--oc-red);">{{ $cancelledOrders }}</div>
                    <div class="oh-stat-lbl">Cancelled</div>
                </div>
            </div>

            {{-- Search + filter bar (client-side) --}}
            <div class="oh-search-bar">
                <input type="text" class="oh-search-input" id="oh-search-input"
                       placeholder="অর্ডার নম্বর খুঁজুন..."
                       oninput="ohFilterHistory()">
                <select class="oh-status-select" id="oh-status-select" onchange="ohFilterHistory()">
                    <option value="all">সব স্ট্যাটাস</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="in_transit">In Transit</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            {{-- Table --}}
            @if($orders->count() > 0)
            <div class="oc-card" style="padding:0;overflow:hidden;">
                <div class="oh-table-wrap">
                    <table class="oh-table" id="oh-table">
                        <thead>
                            <tr style="background:var(--oc-surface2);">
                                <th>অর্ডার নম্বর</th>
                                <th>তারিখ</th>
                                <th>আইটেম</th>
                                <th>মোট</th>
                                <th>পেমেন্ট</th>
                                <th>স্ট্যাটাস</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $histOrder)
                            <tr class="oh-history-row" data-status="{{ $histOrder->order_status }}" data-num="{{ strtolower($histOrder->order_number) }}">
                                <td>
                                    <div class="oh-order-num">{{ $histOrder->order_number }}</div>
                                    <button class="oc-copy-btn" onclick="ocCopy('{{ $histOrder->order_number }}')" style="font-size:11px;margin-top:2px;">
                                        <i class="far fa-copy"></i> Copy
                                    </button>
                                </td>
                                <td>
                                    <div style="color:var(--oc-text2);font-size:13px;">{{ $histOrder->created_at->format('d M Y') }}</div>
                                    <div class="oh-date">{{ $histOrder->created_at->format('H:i:s') }}</div>
                                </td>
                                <td>
                                    <span class="oh-items-count">{{ $histOrder->items->count() }} item(s)</span>
                                </td>
                                <td>
                                    <div class="oh-total">৳{{ number_format($histOrder->total, 2) }}</div>
                                    @if($histOrder->discount > 0)
                                        <div style="font-size:11px;color:var(--oc-green);">-৳{{ number_format($histOrder->discount, 2) }} ছাড়</div>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size:12px;color:var(--oc-text2);">{{ ucfirst($histOrder->payment_method) }}</div>
                                    <div style="font-size:11px;color:var(--oc-muted);">{{ ucfirst($histOrder->payment_status) }}</div>
                                </td>
                                <td>
                                    <span class="oc-status-badge {{ $histOrder->order_status }}">
                                        {{ ucfirst(str_replace('_',' ',$histOrder->order_status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;align-items:center;">
                                        <button style="background:none;border:1px solid var(--oc-border2);border-radius:6px;color:var(--oc-muted);cursor:pointer;padding:5px 10px;font-size:12px;transition:all .2s;"
                                                onclick="ohToggleDetail('oh-detail-{{ $histOrder->id }}')"
                                                onmouseover="this.style.borderColor='var(--oc-red)';this.style.color='var(--oc-red)'"
                                                onmouseout="this.style.borderColor='var(--oc-border2)';this.style.color='var(--oc-muted)'">
                                            <i class="fas fa-eye" id="oh-eye-{{ $histOrder->id }}"></i>
                                        </button>
                                        @if(in_array($histOrder->order_status, ['pending','processing']))
                                            <button class="oc-cancel-order-btn" onclick="ocConfirmCancel('{{ $histOrder->order_number }}','{{ $histOrder->id }}')">
                                                Cancel
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            {{-- Detail row --}}
                            <tr class="oh-detail-row" id="oh-detail-{{ $histOrder->id }}">
                                <td colspan="7">
                                    <div class="oh-detail-inner">
                                        <div style="font-size:11px;font-weight:700;color:var(--oc-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">
                                            <i class="fas fa-box" style="color:var(--oc-red);"></i> অর্ডার আইটেম
                                        </div>
                                        @foreach($histOrder->items as $hItem)
                                        <div class="oh-detail-item">
                                            @if($hItem->product_image)
                                                <img src="{{ asset('uploads/products/'.$hItem->product_image) }}" alt="{{ $hItem->product_name }}" onerror="this.src='https://via.placeholder.com/36/222/888?text=P'">
                                            @else
                                                <img src="https://via.placeholder.com/36/222/888?text=P" alt="">
                                            @endif
                                            <span class="oh-detail-item-name">{{ $hItem->product_name }}</span>
                                            <span style="background:var(--oc-surface3);padding:2px 8px;border-radius:4px;">x{{ $hItem->quantity }}</span>
                                            <span style="color:var(--oc-text2);font-weight:700;font-family:'Syne',sans-serif;">৳{{ number_format($hItem->subtotal, 2) }}</span>
                                        </div>
                                        @endforeach
                                        {{-- Totals --}}
                                        <div style="display:flex;justify-content:flex-end;gap:20px;padding-top:10px;border-top:1px solid var(--oc-border);margin-top:6px;font-size:12px;flex-wrap:wrap;">
                                            @if($histOrder->discount > 0)
                                                <span style="color:var(--oc-green);">ছাড়: -৳{{ number_format($histOrder->discount, 2) }}</span>
                                            @endif
                                            @if($histOrder->shipping_cost > 0)
                                                <span style="color:var(--oc-muted);">ডেলিভারি: ৳{{ number_format($histOrder->shipping_cost, 2) }}</span>
                                            @endif
                                            <span style="color:var(--oc-text);font-weight:700;font-family:'Syne',sans-serif;font-size:14px;">
                                                মোট: ৳{{ number_format($histOrder->total, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- No results message --}}
                <div id="oh-no-results" style="display:none;text-align:center;padding:40px;color:var(--oc-muted);">
                    <i class="fas fa-search" style="font-size:32px;color:var(--oc-border2);display:block;margin-bottom:10px;"></i>
                    কোনো অর্ডার পাওয়া যায়নি।
                </div>
            </div>
            @else
            <div class="oc-empty">
                <i class="fas fa-history"></i>
                <p>কোনো অর্ডার হিস্টোরি নেই।</p>
            </div>
            @endif
        </section>

        <!-- ══════════════════════════════════════════
             REVIEWS SECTION — FULL INLINE FORM
             নিয়ম: pending ও cancelled ছাড়া যেকোনো
             অর্ডারের পণ্যে রিভিউ দেওয়া যাবে
        ══════════════════════════════════════════ -->
        <section class="oc-section" id="oc-section-reviews">
            <div class="oc-page-header">
                <button class="oc-back-btn" onclick="ocShow('dashboard')"><i class="fas fa-arrow-left"></i></button>
                <h1 class="oc-page-title">
                    <i class="fas fa-star" style="color:var(--oc-amber);font-size:18px;"></i>
                    Write Reviews
                </h1>
            </div>

            {{-- Info banner --}}
            <div style="background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.2);border-radius:var(--oc-radius-sm);padding:12px 16px;margin-bottom:24px;display:flex;align-items:flex-start;gap:10px;font-size:13px;color:var(--oc-amber);">
                <i class="fas fa-info-circle" style="flex-shrink:0;margin-top:2px;"></i>
                <span>
                    আপনার <strong>অর্ডার করা</strong> পণ্যগুলোতে রিভিউ দিতে পারবেন।
                    <strong>"Write Review"</strong> বাটনে ক্লিক করে ★ রেটিং দিন এবং মন্তব্য লিখুন।
                    রিভিউ অ্যাডমিন অনুমোদনের পর প্রকাশিত হবে।
                </span>
            </div>

            @php
                // processing, shipped, in_transit, delivered — সব অর্ডারে রিভিউ দেওয়া যাবে
                $reviewableStatuses = ['processing', 'shipped', 'in_transit', 'delivered'];
                $hasAnyReviewableItem = false;
            @endphp

            @foreach($orders->whereIn('order_status', $reviewableStatuses) as $reviewOrder)
                @foreach($reviewOrder->items as $reviewItem)
                    @php
                        $hasAnyReviewableItem = true;
                        $alreadyReviewed = isset($myReviewMap[$reviewItem->product_id]);
                        $existingReview  = $alreadyReviewed ? $myReviewMap[$reviewItem->product_id] : null;
                        $thumbSrc = $reviewItem->product_image
                            ? asset('uploads/products/'.$reviewItem->product_image)
                            : 'https://via.placeholder.com/60/222/888?text=P';
                        $uid = $reviewItem->product_id . '_' . $reviewOrder->id;
                    @endphp

                    <div class="oc-review-card {{ $alreadyReviewed ? 'is-reviewed' : '' }}" id="rcard-{{ $uid }}">

                        {{-- Card Header --}}
                        <div class="oc-review-card-header">
                            <div class="oc-review-order-meta">
                                <i class="fas fa-receipt" style="color:var(--oc-red);font-size:11px;"></i>
                                <span>অর্ডার:</span>
                                <strong>{{ $reviewOrder->order_number }}</strong>
                                <button class="oc-copy-btn" onclick="ocCopy('{{ $reviewOrder->order_number }}')" title="Copy">
                                    <i class="far fa-copy"></i>
                                </button>
                                <span style="color:var(--oc-muted2);">•</span>
                                <span>{{ $reviewOrder->created_at->format('d M Y') }}</span>
                            </div>
                            <span class="oc-status-badge {{ $reviewOrder->order_status }}">
                                {{ ucfirst(str_replace('_',' ',$reviewOrder->order_status)) }}
                            </span>
                        </div>

                        {{-- Product Strip --}}
                        <div class="oc-review-product-strip">
                            <img src="{{ $thumbSrc }}" alt="{{ $reviewItem->product_name }}"
                                 onerror="this.src='https://via.placeholder.com/60/222/888?text=P'">
                            <div class="oc-review-product-info-text">
                                <h4>{{ $reviewItem->product_name }}</h4>
                                <p>পরিমাণ: {{ $reviewItem->quantity }} &nbsp;|&nbsp; মূল্য: ৳{{ number_format($reviewItem->price, 2) }}</p>
                            </div>
                            @if($alreadyReviewed)
                                <span class="oc-status-badge reviewed" style="flex-shrink:0;">
                                    <i class="fas fa-check"></i> রিভিউ দেওয়া হয়েছে
                                </span>
                            @endif
                        </div>

                        {{-- Already Reviewed Display --}}
                        @if($alreadyReviewed)
                            <div class="oc-reviewed-display">
                                <div class="oc-reviewed-stars">
                                    @for($s = 1; $s <= 5; $s++)
                                        <i class="fas fa-star" style="{{ $s <= $existingReview->rating ? 'color:var(--oc-amber)' : 'color:var(--oc-muted2)' }};font-size:16px;"></i>
                                    @endfor
                                    <span style="font-size:13px;color:var(--oc-muted);margin-left:8px;">{{ $existingReview->rating }}/5</span>
                                </div>
                                @if($existingReview->review)
                                    <div class="oc-reviewed-text">"{{ $existingReview->review }}"</div>
                                @else
                                    <p style="font-size:13px;color:var(--oc-muted2);font-style:italic;margin-bottom:10px;">(কোনো মন্তব্য দেওয়া হয়নি)</p>
                                @endif
                                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                                    <span class="oc-reviewed-badge {{ $existingReview->is_approved ? '' : '' }}"
                                          style="{{ $existingReview->is_approved ? 'background:rgba(34,197,94,.12);border:1px solid rgba(34,197,94,.3);color:var(--oc-green);' : 'background:rgba(245,158,11,.12);border:1px solid rgba(245,158,11,.3);color:var(--oc-amber);' }}">
                                        @if($existingReview->is_approved)
                                            <i class="fas fa-check-circle"></i> অনুমোদিত
                                        @else
                                            <i class="fas fa-hourglass-half"></i> অনুমোদন পেন্ডিং
                                        @endif
                                    </span>
                                    <span style="font-size:11px;color:var(--oc-muted2);">{{ $existingReview->created_at->format('d M Y') }}</span>
                                </div>
                            </div>

                        @else
                            {{-- Trigger Row --}}
                            <div class="oc-review-form-trigger" id="trigger-{{ $uid }}">
                                <span style="font-size:13px;color:var(--oc-muted);">
                                    <i class="fas fa-pencil-alt" style="font-size:11px;color:var(--oc-red);"></i>
                                    এই পণ্যে আপনার অভিজ্ঞতা শেয়ার করুন
                                </span>
                                <button class="oc-write-review-trigger"
                                        onclick="ocToggleReviewForm('{{ $uid }}')">
                                    <i class="fas fa-star"></i> Write Review
                                </button>
                            </div>

                            {{-- ════ INLINE REVIEW FORM ════ --}}
                            <div class="oc-review-form-panel" id="rfpanel-{{ $uid }}">
                                <form action="{{ route('review.store') }}" method="POST"
                                      onsubmit="return ocValidateReview('{{ $uid }}')">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $reviewItem->product_id }}">
                                    <input type="hidden" name="order_id"   value="{{ $reviewOrder->id }}">
                                    <input type="hidden" name="rating"     id="rating-{{ $uid }}" value="0">

                                    {{-- ★ Star Rating --}}
                                    <div class="oc-star-rating-group">
                                        <div class="oc-star-rating-label">
                                            রেটিং দিন <span style="color:var(--oc-red);">*</span>
                                        </div>
                                        <div class="oc-star-row" id="starrow-{{ $uid }}">
                                            @for($s = 1; $s <= 5; $s++)
                                            <button type="button"
                                                    class="oc-star-btn"
                                                    data-val="{{ $s }}"
                                                    onclick="ocSetStar('{{ $uid }}', {{ $s }})"
                                                    onmouseover="ocHoverStar('{{ $uid }}', {{ $s }})"
                                                    onmouseout="ocResetStar('{{ $uid }}')"
                                                    title="{{ $s }} তারা">
                                                <i class="fas fa-star"></i>
                                            </button>
                                            @endfor
                                        </div>
                                        <div class="oc-star-label-hint" id="shint-{{ $uid }}">
                                            একটি রেটিং বেছে নিন
                                        </div>
                                    </div>

                                    {{-- ✍ Comment --}}
                                    <div class="oc-review-textarea-wrap">
                                        <label>
                                            আপনার মন্তব্য
                                            <span style="color:var(--oc-muted);font-weight:400;text-transform:none;letter-spacing:0;">(ঐচ্ছিক)</span>
                                        </label>
                                        <textarea name="review"
                                                  class="oc-review-textarea"
                                                  placeholder="পণ্যের গুণমান, ডেলিভারি, প্যাকেজিং — যা খুশি লিখুন..."
                                                  maxlength="1000"
                                                  oninput="document.getElementById('rcc-{{ $uid }}').textContent=this.value.length"></textarea>
                                        <div class="oc-char-count">
                                            <span id="rcc-{{ $uid }}">0</span> / 1000
                                        </div>
                                    </div>

                                    {{-- Error --}}
                                    <div class="oc-review-form-error" id="rerr-{{ $uid }}">
                                        <i class="fas fa-exclamation-circle"></i>
                                        সাবমিট করার আগে অন্তত একটি রেটিং (★) দিন।
                                    </div>

                                    {{-- Actions --}}
                                    <div class="oc-review-form-actions">
                                        <button type="button" class="oc-review-dismiss-btn"
                                                onclick="ocToggleReviewForm('{{ $uid }}')">
                                            <i class="fas fa-times"></i> বাতিল
                                        </button>
                                        <button type="submit" class="oc-review-submit-btn">
                                            <i class="fas fa-paper-plane"></i> রিভিউ জমা দিন
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                    </div>{{-- /.oc-review-card --}}
                @endforeach
            @endforeach

            @if(!$hasAnyReviewableItem)
            <div class="oc-empty">
                <i class="fas fa-star" style="color:var(--oc-amber);opacity:.3;"></i>
                <p style="margin-bottom:8px;">এখনও কোনো রিভিউ দেওয়ার মতো অর্ডার নেই।</p>
                <p style="font-size:12px;color:var(--oc-muted2);">
                    অর্ডার processing / shipped / delivered হলে এখানে দেখাবে।
                    <br>বর্তমানে আপনার সব অর্ডার pending বা cancelled।
                </p>
                <button onclick="ocShow('orders')" style="margin-top:16px;padding:9px 20px;background:var(--oc-red-dim);border:1px solid rgba(232,25,44,.3);border-radius:var(--oc-radius-sm);color:var(--oc-red);font-size:13px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;">
                    <i class="fas fa-shopping-bag"></i> আমার অর্ডার দেখুন
                </button>
            </div>
            @endif
        </section>

        <!-- ══ ADDRESS BOOK ══ -->
        <section class="oc-section" id="oc-section-address-book">
            <div class="oc-page-header">
                <button class="oc-back-btn" onclick="ocShow('dashboard')"><i class="fas fa-arrow-left"></i></button>
                <h1 class="oc-page-title">Address Book</h1>
                <button class="oc-action-btn" onclick="ocShow('add-address')"><i class="fas fa-plus"></i> Add New</button>
            </div>
            <div class="oc-address-grid">
                <div class="oc-card" style="margin-bottom:0;">
                    <div class="oc-address-tag"><i class="fas fa-check-circle"></i> Default Address</div>
                    <div class="oc-address-type">Door to Door Delivery</div>
                    <div class="oc-info-row"><i class="fas fa-user"></i><span>@auth {{ strtoupper(Auth::user()->name) }} @endauth</span></div>
                    <div class="oc-info-row"><i class="fas fa-phone"></i><span>@auth {{ Auth::user()->phone ?? 'Not set' }} @endauth</span></div>
                    <div class="oc-info-row"><i class="fas fa-map-marker-alt"></i><span>No address saved yet</span></div>
                    <div class="oc-address-actions">
                        <button class="oc-del-btn">Delete</button>
                        <button class="oc-edit2-btn">Edit</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══ ADD ADDRESS ══ -->
        <section class="oc-section" id="oc-section-add-address">
            <div class="oc-page-header">
                <button class="oc-back-btn" onclick="ocShow('address-book')"><i class="fas fa-arrow-left"></i></button>
                <h1 class="oc-page-title">Add Shipping Address</h1>
            </div>
            <div class="oc-card">
                <div class="oc-form-grid">
                    <div class="oc-form-group">
                        <label class="oc-form-label">First Name</label>
                        <input type="text" class="oc-form-input" placeholder="First name">
                    </div>
                    <div class="oc-form-group">
                        <label class="oc-form-label">Last Name</label>
                        <input type="text" class="oc-form-input" placeholder="Last name">
                    </div>
                    <div class="oc-form-group">
                        <label class="oc-form-label">Phone Number</label>
                        <div class="oc-phone-row">
                            <input type="text" class="oc-form-input oc-phone-code" value="+880" readonly style="width:70px;flex-shrink:0;">
                            <input type="tel" class="oc-form-input" style="flex:1;" placeholder="01700000000">
                        </div>
                    </div>
                    <div class="oc-form-group">
                        <label class="oc-form-label">Additional Phone</label>
                        <div class="oc-phone-row">
                            <input type="text" class="oc-form-input" value="+880" readonly style="width:70px;flex-shrink:0;">
                            <input type="tel" class="oc-form-input" style="flex:1;" placeholder="Optional">
                        </div>
                    </div>
                    <div class="oc-form-group oc-form-full">
                        <label class="oc-form-label">Delivery Address</label>
                        <textarea class="oc-form-textarea" placeholder="Full delivery address..." maxlength="200"></textarea>
                    </div>
                    <div class="oc-form-group">
                        <label class="oc-form-label">Division</label>
                        <select class="oc-form-select">
                            <option>Select Division</option>
                            <option>Dhaka</option><option>Chittagong</option><option>Sylhet</option><option>Rajshahi</option>
                        </select>
                    </div>
                    <div class="oc-form-group">
                        <label class="oc-form-label">District</label>
                        <select class="oc-form-select"><option>Select District</option></select>
                    </div>
                    <div class="oc-form-group oc-form-full">
                        <label class="oc-checkbox-wrap">
                            <input type="checkbox">
                            <span class="oc-checkbox-label">Set as default address</span>
                        </label>
                    </div>
                    <div class="oc-form-group oc-form-full">
                        <div class="oc-form-actions">
                            <button type="button" class="oc-cancel-btn" onclick="ocShow('address-book')">Cancel</button>
                            <button type="button" class="oc-save-btn">Save Address</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══ MANAGE ACCOUNT ══ -->
        <section class="oc-section" id="oc-section-manage-account">
            <div class="oc-page-header">
                <button class="oc-back-btn" onclick="ocShow('dashboard')"><i class="fas fa-arrow-left"></i></button>
                <h1 class="oc-page-title">Manage Account</h1>
            </div>
            <div class="oc-tabs">
                <button class="oc-tab-btn active" onclick="ocSwitchTab('personal-details',this)">Personal Details</button>
                <button class="oc-tab-btn" onclick="ocSwitchTab('security',this)">Security</button>
                <button class="oc-tab-btn" onclick="ocSwitchTab('preference',this)">Preferences</button>
            </div>
            <div class="oc-tab-content active" id="oc-tab-personal-details">
                <div class="oc-card">
                    <div class="oc-card-title"><i class="fas fa-user"></i> Personal Information</div>
                    <div class="oc-form-grid">
                        <div class="oc-form-group">
                            <label class="oc-form-label">Full Name</label>
                            <input type="text" class="oc-form-input" value="@auth {{ Auth::user()->name }} @endauth">
                        </div>
                        <div class="oc-form-group">
                            <label class="oc-form-label">Email Address</label>
                            <input type="email" class="oc-form-input" value="@auth {{ Auth::user()->email }} @endauth">
                        </div>
                        <div class="oc-form-group">
                            <label class="oc-form-label">Gender</label>
                            <select class="oc-form-select"><option>Select gender</option><option>Male</option><option>Female</option><option>Other</option></select>
                        </div>
                        <div class="oc-form-group">
                            <label class="oc-form-label">Date of Birth</label>
                            <input type="date" class="oc-form-input">
                        </div>
                        <div class="oc-form-group oc-form-full">
                            <div class="oc-form-actions"><button type="button" class="oc-save-btn">Save Changes</button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="oc-tab-content" id="oc-tab-security">
                <div class="oc-card">
                    <div class="oc-card-title"><i class="fas fa-lock"></i> Change Password</div>
                    <div class="oc-form-grid">
                        <div class="oc-form-group oc-form-full">
                            <label class="oc-form-label">Current Password</label>
                            <input type="password" class="oc-form-input" placeholder="••••••••">
                        </div>
                        <div class="oc-form-group">
                            <label class="oc-form-label">New Password</label>
                            <input type="password" class="oc-form-input" placeholder="••••••••">
                        </div>
                        <div class="oc-form-group">
                            <label class="oc-form-label">Confirm Password</label>
                            <input type="password" class="oc-form-input" placeholder="••••••••">
                        </div>
                        <div class="oc-form-group oc-form-full">
                            <p style="font-size:12px;color:var(--oc-muted);">8+ characters. Mix uppercase, lowercase &amp; numbers.</p>
                        </div>
                        <div class="oc-form-group oc-form-full">
                            <div class="oc-form-actions"><button type="button" class="oc-save-btn">Update Password</button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="oc-tab-content" id="oc-tab-preference">
                <div class="oc-card">
                    <div class="oc-card-title"><i class="fas fa-sliders-h"></i> Notification Preferences</div>
                    @foreach([['Order Updates',true],['Promotional Emails',true],['SMS Offers',false],['Product Recommendations',true],['Wishlist Alerts',false],['Newsletter',false]] as [$label,$checked])
                    <div class="oc-pref-item">
                        <span class="oc-pref-label">{{ $label }}</span>
                        <label class="oc-toggle"><input type="checkbox" {{ $checked?'checked':'' }}><span class="oc-toggle-slider"></span></label>
                    </div>
                    @endforeach
                    <div class="oc-form-actions" style="margin-top:20px;"><button type="button" class="oc-save-btn">Save Preferences</button></div>
                </div>
            </div>
        </section>

        <!-- ══ SAVED ITEMS ══ -->
        <section class="oc-section" id="oc-section-saved-items">
            <div class="oc-page-header">
                <button class="oc-back-btn" onclick="ocShow('dashboard')"><i class="fas fa-arrow-left"></i></button>
                <h1 class="oc-page-title">Saved Items</h1>
            </div>
            @if($wishlistItems->count() > 0)
            <div class="oc-pagination">
                <div class="oc-page-info">
                    All ({{ $wishlistItems->count() }})
                    <form action="{{ route('wishlist.clear') }}" method="POST" style="display:inline;" onsubmit="return confirm('সব সেভড আইটেম মুছে ফেলবেন?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="oc-cancel-btn" style="padding:5px 14px;font-size:12px;">Clear All</button>
                    </form>
                </div>
            </div>
            <div class="oc-products-grid">
                @foreach($wishlistItems as $wItem)
                @php $prod = $wItem->product; @endphp
                @if($prod)
                <div class="oc-product-card">
                    <form action="{{ route('wishlist.remove', $wItem->id) }}" method="POST" style="position:absolute;top:10px;right:10px;z-index:2;">
                        @csrf @method('DELETE')
                        <button type="submit" class="oc-remove-btn" title="Remove"><i class="fas fa-trash-alt"></i></button>
                    </form>
                    <a href="{{ route('product.detail', $prod->slug) }}" style="text-decoration:none;">
                        <div class="oc-product-img-wrap">
                            @if($prod->feature_image)
                                <img src="{{ asset('uploads/products/'.$prod->feature_image) }}" alt="{{ $prod->name }}" class="oc-product-img" onerror="this.src='https://via.placeholder.com/400x160/1a1a1a/505050?text=No+Image'">
                            @else
                                <img src="https://via.placeholder.com/400x160/1a1a1a/505050?text=No+Image" class="oc-product-img" alt="">
                            @endif
                            @if($prod->category)
                                <span class="oc-brand-badge">{{ $prod->category->category_name }}</span>
                            @endif
                        </div>
                    </a>
                    <div class="oc-product-body">
                        <div class="oc-product-title-text">{{ $prod->name }}</div>
                        <div class="oc-price-row">
                            <span class="oc-current-price">৳{{ number_format($prod->effective_price, 2) }}</span>
                            @if($prod->discount_price && $prod->discount_price < $prod->current_price)
                                <span class="oc-old-price">৳{{ number_format($prod->current_price, 2) }}</span>
                                <span class="oc-discount">-{{ round((($prod->current_price-$prod->discount_price)/$prod->current_price)*100) }}%</span>
                            @endif
                        </div>
                        @if($prod->is_out_of_stock)
                            <div style="font-size:11px;color:var(--oc-red);margin-bottom:8px;font-weight:600;"><i class="fas fa-exclamation-circle"></i> স্টকে নেই</div>
                        @elseif($prod->is_low_stock)
                            <div style="font-size:11px;color:var(--oc-amber);margin-bottom:8px;font-weight:600;"><i class="fas fa-exclamation-triangle"></i> মাত্র {{ $prod->stock }}টি বাকি</div>
                        @endif
                        @if(!$prod->is_out_of_stock)
                        <form action="{{ route('wishlist.remove', $wItem->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="oc-add-cart-btn"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                        </form>
                        @else
                        <button class="oc-add-cart-btn" disabled style="opacity:.4;cursor:not-allowed;">স্টকে নেই</button>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @else
            <div class="oc-empty"><i class="fas fa-heart"></i><p>কোনো সেভড আইটেম নেই।</p></div>
            @endif
        </section>

        <!-- ══ NOTIFICATIONS ══ -->
        <section class="oc-section" id="oc-section-notifications">
            <div class="oc-page-header">
                <button class="oc-back-btn" onclick="ocShow('dashboard')"><i class="fas fa-arrow-left"></i></button>
                <h1 class="oc-page-title">Notifications</h1>
            </div>
            <div class="oc-card">
                <div class="oc-empty"><i class="fas fa-bell-slash"></i><p>No new notifications</p></div>
            </div>
        </section>

    </main>
</div>

<form id="oc-cancel-form" action="" method="POST" style="display:none;">@csrf @method('POST')</form>

<script>
/* ═══════════════════════════════════════════════════
   DASHBOARD JS — COMPLETE
═══════════════════════════════════════════════════ */

// ── SIDEBAR ──
function ocToggleSidebar() {
    var s=document.getElementById('oc-sidebar'), o=document.getElementById('oc-overlay'), h=document.getElementById('oc-hamburger-btn');
    var open=s.classList.contains('open');
    if(open){ s.classList.remove('open'); o.classList.remove('open'); if(h)h.classList.remove('active'); document.body.style.overflow=''; }
    else    { s.classList.add('open');    o.classList.add('open');    if(h)h.classList.add('active');    document.body.style.overflow='hidden'; }
}
function ocCloseSidebar() {
    document.getElementById('oc-sidebar').classList.remove('open');
    document.getElementById('oc-overlay').classList.remove('open');
    var h=document.getElementById('oc-hamburger-btn'); if(h)h.classList.remove('active');
    document.body.style.overflow='';
}

// ── SECTION SWITCHER ──
var _navMap = {
    dashboard:0, orders:1, 'order-history':2, 'address-book':3, 'add-address':3,
    reviews:4, notifications:5, 'saved-items':6, 'manage-account':null
};
function ocShow(name) {
    document.querySelectorAll('.oc-section').forEach(function(s){ s.classList.remove('active'); });
    var el=document.getElementById('oc-section-'+name);
    if(el) el.classList.add('active');
    document.querySelectorAll('.oc-nav-item').forEach(function(b){ b.classList.remove('active'); });
    var idx=_navMap[name];
    if(idx!==null && idx!==undefined){
        var items=document.querySelectorAll('.oc-nav-item');
        if(items[idx]) items[idx].classList.add('active');
    }
    if(window.innerWidth<=768) ocCloseSidebar();
    window.scrollTo({top:0,behavior:'smooth'});
}
function ocShowFiltered(section, filter) {
    ocShow(section);
    setTimeout(function(){
        var btn=document.querySelector('[data-filter="'+filter+'"]');
        if(btn) btn.click();
    },100);
}

// ── ORDER FILTERS ──
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.oc-filter-tabs').forEach(function(wrap){
        wrap.querySelectorAll('.oc-filter-btn').forEach(function(btn){
            btn.addEventListener('click', function(){
                wrap.querySelectorAll('.oc-filter-btn').forEach(function(b){ b.classList.remove('active'); });
                btn.classList.add('active');
                var filter=btn.getAttribute('data-filter');
                document.querySelectorAll('#oc-orders-list .oc-order-item').forEach(function(row){
                    row.style.display=(filter==='all'||row.getAttribute('data-status')===filter)?'':'none';
                });
                var visible=document.querySelectorAll('#oc-orders-list .oc-order-item:not([style*="none"])').length;
                var emp=document.getElementById('oc-filter-empty');
                if(visible===0){
                    if(!emp){ var d=document.createElement('div'); d.id='oc-filter-empty'; d.className='oc-empty'; d.innerHTML='<i class="fas fa-inbox"></i><p>এই ক্যাটাগরিতে কোনো অর্ডার নেই।</p>'; document.getElementById('oc-orders-list').appendChild(d); }
                } else { if(emp) emp.remove(); }
            });
        });
    });

    // Auto-hide alerts
    setTimeout(function(){
        document.querySelectorAll('.oc-alert').forEach(function(el){
            el.style.transition='opacity .5s'; el.style.opacity='0';
            setTimeout(function(){ el.remove(); },500);
        });
    },4000);
});

// ── ORDER ITEM TOGGLE ──
function ocToggleOrderItems(id) {
    var el=document.getElementById('order-items-'+id), ic=document.getElementById('order-chevron-'+id);
    if(el){ el.classList.toggle('show'); if(ic) ic.style.transform=el.classList.contains('show')?'rotate(180deg)':''; }
}

// ── ORDER HISTORY TABLE FILTER ──
function ohFilterHistory() {
    var search=(document.getElementById('oh-search-input').value||'').toLowerCase().trim();
    var status=document.getElementById('oh-status-select').value;
    var rows=document.querySelectorAll('.oh-history-row');
    var visCount=0;
    rows.forEach(function(row){
        var numMatch=!search||row.getAttribute('data-num').includes(search);
        var statMatch=status==='all'||row.getAttribute('data-status')===status;
        var show=numMatch&&statMatch;
        row.style.display=show?'':'none';
        // also hide associated detail row
        var nextRow=row.nextElementSibling;
        if(nextRow&&nextRow.classList.contains('oh-detail-row')){
            if(!show) nextRow.classList.remove('show');
            nextRow.style.display=show?'':'none';
        }
        if(show) visCount++;
    });
    var noRes=document.getElementById('oh-no-results');
    if(noRes) noRes.style.display=visCount===0?'block':'none';
}

// ── ORDER HISTORY DETAIL TOGGLE ──
function ohToggleDetail(id) {
    var row=document.getElementById(id);
    if(!row) return;
    row.classList.toggle('show');
}

// ── CANCEL ORDER ──
function ocConfirmCancel(orderNumber, orderId) {
    document.getElementById('oc-modal-order-text').textContent='অর্ডার #'+orderNumber+' বাতিল করা হলে আর ফিরিয়ে আনা যাবে না।';
    document.getElementById('oc-cancel-modal').classList.add('show');
    document.getElementById('oc-modal-confirm-btn').onclick=function(){
        var f=document.getElementById('oc-cancel-form');
        f.action='{{ url("order/cancel") }}/'+orderNumber;
        f.submit();
    };
}
function ocCloseModal(id){ document.getElementById(id).classList.remove('show'); }
document.getElementById('oc-cancel-modal').addEventListener('click', function(e){ if(e.target===this) ocCloseModal('oc-cancel-modal'); });

// ── TABS ──
function ocSwitchTab(tabId, btn) {
    document.querySelectorAll('.oc-tab-content').forEach(function(t){ t.classList.remove('active'); });
    document.querySelectorAll('.oc-tab-btn').forEach(function(b){ b.classList.remove('active'); });
    var tab=document.getElementById('oc-tab-'+tabId); if(tab) tab.classList.add('active');
    if(btn) btn.classList.add('active');
}

// ── COPY ──
function ocCopy(text){ navigator.clipboard.writeText(text).then(function(){ ocToast('Copied: '+text,'green'); }); }

// ── TOAST ──
function ocToast(msg, type) {
    var ex=document.querySelector('.oc-toast-el'); if(ex) ex.remove();
    var el=document.createElement('div'); el.className='oc-toast-el'; el.textContent=msg;
    if(type==='error')   el.style.background='#333';
    else if(type==='info')   el.style.background='#3b82f6';
    else if(type==='green')  el.style.background='#22c55e';
    document.body.appendChild(el);
    setTimeout(function(){ el.remove(); },3500);
}

/* ══════════════════════════════════════
   INLINE REVIEW FORM LOGIC
══════════════════════════════════════ */
var _stars = {};   // selected star per uid
var _labels = ['','খুব খারাপ 😞','মোটামুটি 😐','ভালো 🙂','খুব ভালো 😊','চমৎকার! 🤩'];

function ocToggleReviewForm(uid) {
    var panel=document.getElementById('rfpanel-'+uid);
    var trigger=document.getElementById('trigger-'+uid);
    if(!panel) return;
    var showing=panel.classList.contains('show');
    if(showing){
        panel.classList.remove('show');
        if(trigger) trigger.style.display='flex';
    } else {
        panel.classList.add('show');
        if(trigger) trigger.style.display='none';
        setTimeout(function(){ panel.scrollIntoView({behavior:'smooth',block:'nearest'}); },100);
    }
}

function ocSetStar(uid, val) {
    _stars[uid]=val;
    var inp=document.getElementById('rating-'+uid); if(inp) inp.value=val;
    var hint=document.getElementById('shint-'+uid); if(hint) hint.textContent=_labels[val];
    var err=document.getElementById('rerr-'+uid); if(err) err.classList.remove('show');
    _paintStars(uid, val, false);
}
function ocHoverStar(uid, val) { _paintStars(uid, val, true); }
function ocResetStar(uid) { _paintStars(uid, _stars[uid]||0, false); }

function _paintStars(uid, val, hover) {
    var row=document.getElementById('starrow-'+uid); if(!row) return;
    row.querySelectorAll('.oc-star-btn').forEach(function(btn){
        var v=parseInt(btn.getAttribute('data-val'));
        if(v<=val){ btn.classList.add('active'); btn.style.color='#f59e0b'; if(hover) btn.style.transform='scale(1.15)'; }
        else       { btn.classList.remove('active'); btn.style.color='var(--oc-muted2)'; btn.style.transform=''; }
    });
}

function ocValidateReview(uid) {
    if(!_stars[uid]||_stars[uid]===0){
        var err=document.getElementById('rerr-'+uid);
        if(err){ err.classList.add('show'); err.scrollIntoView({behavior:'smooth',block:'nearest'}); }
        return false;
    }
    return true;
}

// ── RESIZE ──
window.addEventListener('resize', function(){ if(window.innerWidth>768) ocCloseSidebar(); });

// ── SESSION FLASH ──
@if(session('success')) ocToast("{{ addslashes(session('success')) }}",'green'); @endif
@if(session('error'))   ocToast("{{ addslashes(session('error')) }}",'error'); @endif
@if(session('info'))    ocToast("{{ addslashes(session('info')) }}",'info'); @endif
</script>
