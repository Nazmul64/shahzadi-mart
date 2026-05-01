@extends('admin.master')

@section('main-content')
<style>
/* ══════════════════════════════════════════
   GOOGLE FONTS
══════════════════════════════════════════ */
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

/* ══════════════════════════════════════════
   CSS VARIABLES
══════════════════════════════════════════ */
:root {
    --primary:       #6366f1;
    --primary-dark:  #4f46e5;
    --primary-light: #eef2ff;
    --primary-muted: rgba(99, 102, 241, 0.1);
    --secondary:     #64748b;
    --accent:        #10b981;
    --danger:        #ef4444;
    --warning:       #f59e0b;
    --gray-50:       #f8fafc;
    --gray-100:      #f1f5f9;
    --gray-200:      #e2e8f0;
    --gray-300:      #cbd5e1;
    --gray-400:      #94a3b8;
    --gray-500:      #64748b;
    --gray-600:      #475569;
    --gray-700:      #334155;
    --gray-800:      #1e293b;
    --gray-900:      #0f172a;
    --radius-sm:     8px;
    --radius:        12px;
    --radius-lg:     16px;
    --shadow-sm:     0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow:        0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-md:     0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-lg:     0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    --glass:         rgba(255, 255, 255, 0.8);
    --glass-border:  rgba(255, 255, 255, 0.3);
}

* { box-sizing: border-box; font-family: 'DM Sans', sans-serif; }

/* ══════════════════════════════════════════
   POS LAYOUT
══════════════════════════════════════════ */
.pos-wrapper {
    display: flex;
    height: calc(100vh - 60px);
    overflow: hidden;
    background: var(--gray-50);
}

/* ── LEFT PANEL ───────────────────────── */
.pos-left {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* Filters Bar */
.pos-filters {
    padding: 16px 20px;
    background: var(--glass);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 100;
}

.filter-select {
    height: 42px;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius);
    padding: 0 14px;
    font-size: 14px;
    font-weight: 600;
    outline: none;
    background: #fff;
    color: var(--gray-700);
    cursor: pointer;
    transition: all .2s;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 32px;
}
.filter-select:focus { border-color: var(--primary); box-shadow: 0 0 0 4px var(--primary-muted); }

.filter-search {
    flex: 1;
    min-width: 250px;
    height: 42px;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius);
    padding: 0 14px 0 40px;
    font-size: 14px;
    font-weight: 500;
    outline: none;
    color: var(--gray-700);
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 14px center;
    transition: all .2s;
}
.filter-search:focus { border-color: var(--primary); box-shadow: 0 0 0 4px var(--primary-muted); }

/* ── Product Grid ── */
.product-grid {
    flex: 1;
    overflow-y: auto;
    padding: 14px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(155px, 1fr));
    gap: 12px;
    align-content: start;
}

.product-card {
    background: #fff;
    border-radius: var(--radius-lg);
    border: 1px solid var(--gray-200);
    padding: 12px;
    cursor: pointer;
    transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    user-select: none;
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
}
.product-card:hover {
    border-color: var(--primary);
    box-shadow: var(--shadow-md);
    transform: translateY(-4px);
}
.product-card:active { transform: scale(.96); }

.product-card img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: var(--radius);
    background: var(--gray-50);
    transition: transform .3s;
}
.product-card:hover img { transform: scale(1.05); }

.p-name {
    font-weight: 700;
    font-size: 13px;
    color: var(--gray-800);
    margin: 12px 0 6px;
    line-height: 1.4;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    min-height: 36px;
}
.p-price-row { display: flex; align-items: baseline; gap: 6px; }
.p-price     { font-size: 16px; font-weight: 800; color: var(--primary); }
.p-old-price { font-size: 12px; color: var(--gray-400); text-decoration: line-through; }
.p-stock     { font-size: 11px; color: var(--gray-500); margin-top: 4px; font-weight: 500; }

.flash-badge {
    position: absolute;
    top: 10px; right: 10px;
    background: var(--danger);
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: 30px;
    box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
    z-index: 1;
}

.pagination-wrap {
    padding: 8px 16px;
    background: #fff;
    border-top: 1px solid var(--gray-200);
}

/* ── RIGHT PANEL ──────────────────────── */
.pos-right {
    width: 430px;
    min-width: 370px;
    background: #fff;
    border-left: 1px solid var(--gray-200);
    display: flex;
    flex-direction: column;
    box-shadow: -4px 0 20px rgba(0,0,0,.04);
}

/* ── Customer Header ── */
.cart-header {
    padding: 12px 14px;
    border-bottom: 1px solid var(--gray-200);
    background: #fff;
}

.customer-row {
    display: flex;
    gap: 8px;
    align-items: center;
}

.customer-select-wrap {
    flex: 1;
    position: relative;
}

.customer-search-input {
    width: 100%;
    height: 44px;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius);
    padding: 0 14px 0 42px;
    font-size: 14px;
    font-weight: 500;
    outline: none;
    color: var(--gray-700);
    background: var(--gray-50) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'/%3E%3Ccircle cx='12' cy='7' r='4'/%3E%3C/svg%3E") no-repeat 14px center;
    transition: all .2s;
}
.customer-search-input:focus {
    border-color: var(--primary);
    background-color: #fff;
    box-shadow: 0 0 0 4px var(--primary-muted);
}
.customer-search-input.has-value {
    border-color: var(--primary);
    background-color: var(--primary-light);
    font-weight: 700;
    color: var(--primary-dark);
}

/* ══ Customer Dropdown ══ */
.customer-dropdown {
    position: absolute;
    top: 46px;
    left: 0;
    right: 0;
    background: #fff;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius-lg);
    z-index: 9999;
    max-height: 280px;
    overflow-y: auto;
    display: none;
    box-shadow: var(--shadow-lg);
}
.customer-dropdown.show { display: block; }

.customer-dd-header {
    padding: 8px 12px 6px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: var(--gray-500);
    border-bottom: 1px solid var(--gray-100);
    background: var(--gray-50);
    border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    position: sticky;
    top: 0;
}

.customer-item {
    padding: 10px 12px;
    cursor: pointer;
    border-bottom: 1px solid var(--gray-100);
    display: flex;
    align-items: center;
    gap: 10px;
    transition: background .12s;
}
.customer-item:last-child { border-bottom: none; }
.customer-item:hover { background: var(--pink-light); }

.customer-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 800;
    color: #fff;
    flex-shrink: 0;
    text-transform: uppercase;
    box-shadow: 0 4px 8px var(--primary-muted);
}

.customer-info-dd { flex: 1; min-width: 0; }
.customer-info-dd strong {
    font-size: 13px;
    font-weight: 600;
    color: var(--gray-900);
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.customer-info-dd .cdd-phone {
    font-size: 11px;
    color: var(--gray-500);
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 1px;
}
.customer-info-dd .cdd-email {
    font-size: 11px;
    color: var(--gray-500);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.customer-dd-empty {
    padding: 24px 12px;
    text-align: center;
    color: var(--gray-500);
    font-size: 13px;
}
.customer-dd-empty svg {
    display: block;
    margin: 0 auto 8px;
    opacity: .35;
}

/* Dropdown loading spinner */
.customer-dd-loading {
    padding: 18px 12px;
    text-align: center;
    color: var(--gray-500);
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.dd-spinner {
    width: 18px; height: 18px;
    border: 2px solid var(--gray-200);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: ddSpin .6s linear infinite;
}
@keyframes ddSpin { to { transform: rotate(360deg); } }

.btn-add-customer {
    height: 44px;
    padding: 0 16px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    border: none;
    border-radius: var(--radius);
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all .2s;
    box-shadow: 0 4px 12px var(--primary-muted);
}
.btn-add-customer:hover { transform: translateY(-1px); box-shadow: 0 6px 16px var(--primary-muted); opacity: 0.95; }
.btn-add-customer:active { transform: scale(0.98); }

/* Selected Customer Tag */
.selected-customer-tag {
    display: none;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
    padding: 7px 10px;
    background: var(--pink-light);
    border-radius: var(--radius);
    border: 1px solid rgba(233,30,140,.2);
}
.selected-customer-tag.show { display: flex; }
.sct-avatar {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800; color: #fff;
    flex-shrink: 0;
    text-transform: uppercase;
}
.sct-info { flex: 1; min-width: 0; }
.sct-info strong { font-size: 12px; font-weight: 700; color: var(--pink-dark); display: block; }
.sct-info span   { font-size: 11px; color: var(--gray-500); }
.sct-remove {
    width: 22px; height: 22px;
    border: none; background: rgba(233,30,140,.15);
    border-radius: 50%; cursor: pointer; color: var(--pink);
    font-size: 11px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s;
}
.sct-remove:hover { background: rgba(233,30,140,.3); }

/* ── Cart Items ── */
.cart-items {
    flex: 1;
    overflow-y: auto;
    padding: 10px;
}

.empty-cart {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 200px;
    color: var(--gray-300);
    gap: 10px;
}
.empty-cart svg { opacity: .4; }
.empty-cart span { font-size: 13px; color: var(--gray-500); }

.cart-item {
    background: var(--gray-50);
    border-radius: var(--radius-lg);
    padding: 10px;
    margin-bottom: 8px;
    display: flex;
    gap: 10px;
    align-items: flex-start;
    border: 1.5px solid var(--gray-200);
    transition: border-color .15s;
}
.cart-item:hover { border-color: var(--pink); }

.cart-item img {
    width: 52px; height: 52px;
    border-radius: var(--radius);
    object-fit: cover;
    flex-shrink: 0;
    background: var(--gray-100);
}

.cart-item-info { flex: 1; min-width: 0; }
.ci-name {
    font-weight: 600;
    font-size: 12px;
    color: var(--gray-900);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ci-variant {
    display: inline-block;
    font-size: 11px;
    color: var(--primary-dark);
    font-weight: 700;
    background: var(--primary-light);
    padding: 2px 10px;
    border-radius: 20px;
    margin-top: 4px;
}
.ci-price { font-size: 15px; color: var(--primary); font-weight: 800; margin-top: 4px; }

.ci-sku-row {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #fff;
    border: 1px solid var(--gray-200);
    border-radius: 5px;
    padding: 2px 7px;
    font-size: 10px;
    color: var(--gray-700);
    margin-top: 4px;
    max-width: 100%;
    overflow: hidden;
}
.ci-sku-row span {
    font-family: monospace;
    font-size: 10px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.cart-qty {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 6px;
}
.qty-btn {
    width: 24px; height: 24px;
    border: 1.5px solid var(--gray-200);
    border-radius: 6px;
    background: #fff;
    cursor: pointer;
    font-size: 14px;
    line-height: 1;
    display: flex; align-items: center; justify-content: center;
    transition: all .15s;
    color: var(--gray-700);
    font-weight: 700;
}
.qty-btn:hover { background: var(--pink); color: #fff; border-color: var(--pink); }
.qty-input {
    width: 40px; height: 24px;
    border: 1.5px solid var(--gray-200);
    border-radius: 6px;
    text-align: center;
    font-size: 13px;
    font-weight: 700;
    outline: none;
    color: var(--gray-900);
}

.cart-item-actions { display: flex; flex-direction: column; gap: 4px; }
.btn-edit-item, .btn-remove-item {
    width: 28px; height: 28px;
    border: none; border-radius: 6px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px;
    transition: opacity .15s;
}
.btn-edit-item   { background: #eff6ff; color: var(--blue); }
.btn-remove-item { background: #fef2f2; color: var(--red); }
.btn-edit-item:hover, .btn-remove-item:hover { opacity: .7; }

/* ── Cart Summary ── */
.cart-summary {
    padding: 10px 14px;
    border-top: 1px solid var(--gray-200);
    background: #fff;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    margin-bottom: 4px;
    color: var(--gray-700);
}
.summary-row .label { font-weight: 500; }
.summary-row .val   { font-weight: 600; color: var(--gray-900); }
.summary-row.discount .val { color: var(--red); }

.tax-block {
    background: var(--gray-50);
    border-radius: var(--radius);
    padding: 8px 12px;
    margin: 6px 0;
    border: 1px solid var(--gray-200);
}
.tax-block-title {
    font-size: 10px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px;
    color: var(--gray-500); margin-bottom: 5px;
}
.tax-row {
    display: flex; justify-content: space-between;
    font-size: 12px; color: var(--gray-500); margin-bottom: 3px;
}
.tax-total-row {
    display: flex; justify-content: space-between;
    font-size: 12px; font-weight: 700; color: var(--gray-900);
    border-top: 1px dashed var(--gray-300);
    margin-top: 5px; padding-top: 5px;
}

.shipping-block { margin: 6px 0; }
.shipping-label {
    font-size: 10px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px;
    color: var(--gray-500); margin-bottom: 4px;
}
.shipping-select {
    width: 100%; height: 36px;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius);
    padding: 0 12px;
    font-size: 13px; outline: none;
    color: var(--gray-700); background: #fff;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    padding-right: 28px;
}
.shipping-select:focus { border-color: var(--pink); }

/* Payment Methods */
.pay-methods { display: flex; gap: 6px; margin: 6px 0; }
.pay-method {
    flex: 1;
    padding: 8px 4px;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius);
    text-align: center;
    cursor: pointer;
    font-size: 11px; font-weight: 600;
    color: var(--gray-700);
    transition: all .15s;
    display: flex; flex-direction: column; align-items: center; gap: 2px;
}
.pay-method span { font-size: 16px; }
.pay-method.active {
    border-color: var(--primary);
    background: var(--primary-light);
    color: var(--primary);
    box-shadow: 0 4px 10px var(--primary-muted);
}

/* Coupon */
.coupon-row { display: flex; gap: 8px; margin: 6px 0; }
.coupon-input {
    flex: 1; height: 36px;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius);
    padding: 0 12px;
    font-size: 13px; outline: none;
}
.coupon-input:focus { border-color: var(--pink); }
.btn-apply-coupon {
    height: 38px; padding: 0 16px;
    background: var(--primary); color: #fff;
    border: none; border-radius: var(--radius);
    font-size: 14px; font-weight: 700; cursor: pointer;
    transition: all .2s;
}
.btn-apply-coupon:hover { background: var(--primary-dark); transform: translateY(-1px); }

.coupon-applied-msg {
    display: none;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    border-radius: var(--radius);
    font-size: 11px;
    font-weight: 600;
    color: #065f46;
    margin-top: 4px;
}
.coupon-applied-msg.show { display: flex; }
.coupon-applied-msg .remove-coupon {
    margin-left: auto;
    cursor: pointer;
    color: var(--red);
    font-size: 12px;
    font-weight: 700;
}

/* Note */
.note-area {
    width: 100%; min-height: 50px;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius);
    padding: 7px 12px;
    font-size: 12px; resize: none; outline: none;
    box-sizing: border-box; margin-bottom: 6px;
    color: var(--gray-700); font-family: 'DM Sans', sans-serif;
    transition: border-color .15s;
}
.note-area:focus { border-color: var(--pink); }

/* Grand Total */
.grand-total-row {
    display: flex; justify-content: space-between; align-items: center;
    font-size: 16px; font-weight: 800; color: var(--gray-900);
    margin: 8px 0 4px;
    padding: 10px 12px;
    background: var(--gray-50);
    border-radius: var(--radius-lg);
    border: 1.5px solid var(--gray-200);
}
.grand-total-row .gt-amount { color: var(--pink); font-size: 18px; }

/* Actions */
.cart-actions {
    display: flex; gap: 8px;
    padding: 10px 14px;
    border-top: 1px solid var(--gray-200);
    background: #fff;
}
.btn-draft {
    flex: 0 0 84px; height: 46px;
    background: #fef3c7; color: #92400e;
    border: none; border-radius: var(--radius-lg);
    font-weight: 700; font-size: 14px; cursor: pointer;
    transition: background .15s;
}
.btn-draft:hover { background: #fde68a; }

.btn-complete {
    flex: 1; height: 50px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff; border: none; border-radius: var(--radius-lg);
    font-weight: 800; font-size: 15px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 8px 20px var(--primary-muted);
    transition: all .2s;
}
.btn-complete:hover { transform: translateY(-2px); box-shadow: 0 12px 24px var(--primary-muted); opacity: 0.95; }
.btn-complete:active { transform: scale(0.98); }

/* ══════════════════════════════════════════
   MODALS
══════════════════════════════════════════ */
.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.5);
    backdrop-filter: blur(3px);
    z-index: 9999;
    display: none;
    align-items: center; justify-content: center;
}
.modal-overlay.show { display: flex; }

.modal-box {
    background: #fff;
    border-radius: 20px;
    padding: 26px;
    width: 440px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-lg);
    animation: modalIn .25s ease;
}
@keyframes modalIn {
    from { opacity:0; transform: scale(.95) translateY(10px); }
    to   { opacity:1; transform: scale(1)  translateY(0); }
}

.modal-title {
    font-size: 18px; font-weight: 800;
    color: var(--gray-900); margin: 0 0 18px;
    display: flex; align-items: center; gap: 8px;
}
.modal-title-icon {
    width: 36px; height: 36px;
    background: var(--pink-light); border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: var(--pink); font-size: 16px;
}

.form-group { margin-bottom: 14px; }
.form-group label {
    font-size: 11px; font-weight: 700;
    color: var(--gray-500);
    display: block; margin-bottom: 5px;
    text-transform: uppercase; letter-spacing: .4px;
}
.form-group input,
.form-group select {
    width: 100%; height: 40px;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius);
    padding: 0 12px;
    font-size: 13px; font-weight: 500;
    outline: none; box-sizing: border-box;
    color: var(--gray-700);
    transition: border-color .15s;
}
.form-group input:focus,
.form-group select:focus { border-color: var(--pink); }

.form-error {
    font-size: 11px; color: var(--red);
    margin-top: 3px; display: block;
}

.modal-actions { display: flex; gap: 8px; margin-top: 18px; }
.btn-modal-cancel {
    flex: 1; height: 42px;
    background: var(--gray-100); color: var(--gray-700);
    border: none; border-radius: var(--radius);
    cursor: pointer; font-size: 14px; font-weight: 600;
    transition: background .15s;
}
.btn-modal-cancel:hover { background: var(--gray-200); }
.btn-modal-submit {
    flex: 1; height: 46px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff; border: none; border-radius: var(--radius);
    cursor: pointer; font-size: 15px; font-weight: 800;
    transition: all .2s;
    box-shadow: 0 4px 12px var(--primary-muted);
}
.btn-modal-submit:hover { opacity: 0.95; transform: translateY(-1px); box-shadow: 0 6px 16px var(--primary-muted); }

/* Variant card */
.variant-card {
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius);
    padding: 14px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all .2s;
    background: #fff;
}
.variant-card:hover {
    border-color: var(--primary);
    background: var(--primary-light);
    transform: translateX(4px);
}
.variant-card-name  { font-weight: 800; font-size: 14px; color: var(--gray-800); }
.variant-card-price { font-size: 15px; color: var(--primary); font-weight: 800; margin-top: 4px; }
.variant-card-stock { font-size: 11px; color: var(--gray-500); margin-top: 2px; }

/* Pagination Styling */
.pagination { display: flex; gap: 5px; list-style: none; padding: 0; margin: 0; align-items: center; }
.page-item { border-radius: 8px; overflow: hidden; }
.page-link { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #fff; border: 1.5px solid var(--gray-200); color: var(--gray-700); text-decoration: none; font-size: 14px; font-weight: 600; transition: all 0.2s; }
.page-item.active .page-link { background: var(--primary); border-color: var(--primary); color: #fff; box-shadow: 0 4px 10px var(--primary-muted); }
.page-link:hover:not(.active) { background: var(--gray-50); border-color: var(--primary); color: var(--primary); }
.page-item.disabled .page-link { opacity: 0.5; cursor: not-allowed; }
</style>

<div class="pos-wrapper">

    {{-- ═══════════════ LEFT: Products ═══════════════ --}}
    <div class="pos-left">

        {{-- Filters --}}
        <div class="pos-filters">
            <select class="filter-select" id="brandFilter">
                <option value="">All Brands</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand }}">{{ $brand }}</option>
                @endforeach
            </select>

            <select class="filter-select" id="categoryFilter">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                @endforeach
            </select>

            <input class="filter-search" type="text" id="productSearch"
                   placeholder="Search product name or SKU...">
        </div>

        {{-- Product Grid --}}
        <div id="productGridWrap" class="product-grid">
            @include('admin.pos.partials.product_grid', ['products' => $products])
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrap" id="paginationWrap">
            {{ $products->links() }}
        </div>
    </div>

    {{-- ═══════════════ RIGHT: Cart ═══════════════ --}}
    <div class="pos-right">

        {{-- Customer Section --}}
        <div class="cart-header">
            <div class="customer-row">
                <div class="customer-select-wrap" id="customerSelectWrap">
                    <input type="text"
                           class="customer-search-input"
                           id="customerSearch"
                           placeholder="Search customer by name or phone..."
                           autocomplete="off">
                    <input type="hidden" id="selectedCustomerId">
                    <input type="hidden" id="selectedCustomerName">

                    {{-- Customer Dropdown --}}
                    <div class="customer-dropdown" id="customerDropdown">
                        <div class="customer-dd-header">
                            <i class="fas fa-users" style="margin-right:4px"></i> Customers
                        </div>
                        <div id="customerDdList"></div>
                    </div>
                </div>

                <button class="btn-add-customer" onclick="openNewCustomerModal()">
                    <i class="fas fa-user-plus"></i> New
                </button>
            </div>

            {{-- Selected Customer Tag --}}
            <div class="selected-customer-tag" id="selectedCustomerTag">
                <div class="sct-avatar" id="sctAvatar">?</div>
                <div class="sct-info">
                    <strong id="sctName">—</strong>
                    <span id="sctPhone">—</span>
                </div>
                <button class="sct-remove" onclick="clearCustomer()" title="Remove Customer">✕</button>
            </div>
        </div>

        {{-- Cart Items --}}
        <div class="cart-items" id="cartItems">
            <div class="empty-cart">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.2">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                <span>Cart is empty — tap a product to add</span>
            </div>
        </div>

        {{-- Summary --}}
        <div class="cart-summary">

            <div class="summary-row">
                <span class="label">Sub Total</span>
                <span class="val" id="subTotalDisplay">$0.00</span>
            </div>

            <div class="summary-row discount" id="discountRow" style="display:none">
                <span class="label">Coupon Discount</span>
                <span class="val" id="discountDisplay">-$0.00</span>
            </div>

            {{-- VAT & Tax --}}
            @if($taxes->count())
            <div class="tax-block">
                <div class="tax-block-title">VAT &amp; Taxes</div>
                @foreach($taxes as $tax)
                <div class="tax-row">
                    <span>{{ $tax->name }} ({{ $tax->percentage }}%)</span>
                    <span class="tax-line-amount" data-percent="{{ $tax->percentage }}">$0.00</span>
                </div>
                @endforeach
                <div class="tax-total-row">
                    <span>Total Tax</span>
                    <span id="totalTaxDisplay">$0.00</span>
                </div>
            </div>
            @endif

            {{-- Shipping --}}
            @if($shippingCharges->count())
            <div class="shipping-block">
                <div class="shipping-label">Shipping Area</div>
                <select class="shipping-select" id="shippingChargeSelect" onchange="updateTotals()">
                    <option value="" data-amount="0">No Shipping / Pick Up</option>
                    @foreach($shippingCharges as $sc)
                        <option value="{{ $sc->id }}" data-amount="{{ $sc->amount }}">
                            {{ $sc->area_name }} — ${{ number_format($sc->amount, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="summary-row" id="shippingRow" style="display:none">
                <span class="label">Shipping Charge</span>
                <span class="val" id="shippingDisplay">$0.00</span>
            </div>
            @endif

            {{-- Payment Method --}}
            <div class="pay-methods">
                <div class="pay-method active" data-method="cash" onclick="selectPayMethod(this)">
                    <span>💵</span> Cash
                </div>
                <div class="pay-method" data-method="card" onclick="selectPayMethod(this)">
                    <span>💳</span> Card
                </div>
                <div class="pay-method" data-method="mobile_banking" onclick="selectPayMethod(this)">
                    <span>📱</span> Mobile
                </div>
            </div>

            {{-- Coupon --}}
            <div class="coupon-row">
                <input type="text" class="coupon-input" id="couponCode" placeholder="Coupon code...">
                <button class="btn-apply-coupon" onclick="applyCoupon()">Apply</button>
            </div>
            <div class="coupon-applied-msg" id="couponAppliedMsg">
                <i class="fas fa-check-circle"></i>
                <span id="couponAppliedText"></span>
                <span class="remove-coupon" onclick="removeCoupon()">✕ Remove</span>
            </div>

            {{-- Note --}}
            <textarea class="note-area" id="orderNote" placeholder="Order note (optional)..."></textarea>

            <div class="grand-total-row">
                <span>Grand Total</span>
                <span class="gt-amount" id="grandTotalDisplay">$0.00</span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="cart-actions">
            <button class="btn-draft" onclick="placeOrder('draft')">
                <i class="fas fa-save"></i> Draft
            </button>
            <button class="btn-complete" onclick="placeOrder('completed')">
                <i class="fas fa-check-circle"></i>
                Complete &nbsp;<span id="grandTotalBtn">$0.00</span>
            </button>
        </div>
    </div>
</div>

{{-- ══════════ NEW CUSTOMER MODAL ══════════ --}}
<div class="modal-overlay" id="newCustomerModal">
    <div class="modal-box">
        <h3 class="modal-title">
            <span class="modal-title-icon"><i class="fas fa-user-plus"></i></span>
            Add New Customer
        </h3>
        <div class="form-group">
            <label>Full Name *</label>
            <input type="text" id="newCustName" placeholder="e.g. John Doe">
            <span class="form-error" id="errCustName"></span>
        </div>
        <div class="form-group">
            <label>Phone Number *</label>
            <input type="text" id="newCustPhone" placeholder="e.g. 01700000000">
            <span class="form-error" id="errCustPhone"></span>
        </div>
        <div class="form-group">
            <label>Email Address <small style="font-weight:400;text-transform:none">(optional)</small></label>
            <input type="email" id="newCustEmail" placeholder="e.g. john@email.com">
            <span class="form-error" id="errCustEmail"></span>
        </div>
        <div class="modal-actions">
            <button class="btn-modal-cancel" onclick="closeModal('newCustomerModal')">Cancel</button>
            <button class="btn-modal-submit" onclick="saveNewCustomer()">
                <i class="fas fa-save"></i> Save Customer
            </button>
        </div>
    </div>
</div>

{{-- ══════════ VARIANT SELECTOR MODAL ══════════ --}}
<div class="modal-overlay" id="variantModal">
    <div class="modal-box">
        <h3 class="modal-title" id="variantModalTitle">
            <span class="modal-title-icon"><i class="fas fa-layer-group"></i></span>
            Select Variant
        </h3>
        <div id="variantList"></div>
        <div class="modal-actions">
            <button class="btn-modal-cancel" onclick="closeModal('variantModal')">Cancel</button>
        </div>
    </div>
</div>

{{-- ══════════ EDIT QTY MODAL ══════════ --}}
<div class="modal-overlay" id="editItemModal">
    <div class="modal-box">
        <h3 class="modal-title">
            <span class="modal-title-icon"><i class="fas fa-edit"></i></span>
            Edit Quantity
        </h3>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" id="editQty" min="1" value="1">
        </div>
        <input type="hidden" id="editCartIndex">
        <div class="modal-actions">
            <button class="btn-modal-cancel" onclick="closeModal('editItemModal')">Cancel</button>
            <button class="btn-modal-submit" onclick="saveEditItem()">Update</button>
        </div>
    </div>
</div>

<script>
// ══════════════════════════════════════════════
//  STATE
// ══════════════════════════════════════════════
let cart              = [];
let couponData        = null;
let selectedPayMethod = 'cash';
const taxes = @json($taxes);

// ══════════════════════════════════════════════
//  ADD TO CART
// ══════════════════════════════════════════════
function addToCart(productId, name, sku, image, price, oldPrice, isUnlimited, stock, variants) {
    const parsedVariants = Array.isArray(variants) ? variants : [];
    if (parsedVariants.length > 0) {
        openVariantModal(productId, name, sku, image, price, isUnlimited, stock, parsedVariants);
        return;
    }
    addItemToCart({
        product_id:    productId,
        name,
        sku,
        image,
        unit_price:    parseFloat(price),
        quantity:      1,
        variant_label: null,
        is_unlimited:  isUnlimited,
        stock:         parseInt(stock) || 0,
    });
}

function addItemToCart(item) {
    const key = item.product_id + '|' + (item.variant_label || '');
    const existing = cart.find(c => (c.product_id + '|' + (c.variant_label || '')) === key);
    if (existing) {
        existing.quantity++;
    } else {
        cart.push({ ...item, quantity: 1 });
    }
    renderCart();
}

// ══════════════════════════════════════════════
//  VARIANT MODAL
// ══════════════════════════════════════════════
let variantContext = {};

function openVariantModal(productId, name, sku, image, price, isUnlimited, stock, variants) {
    variantContext = { productId, name, sku, image, price, isUnlimited, stock, variants };
    document.getElementById('variantModalTitle').innerHTML =
        `<span class="modal-title-icon"><i class="fas fa-layer-group"></i></span> ${escHtml(name)}`;

    const html = variants.map((v, i) => {
        const label  = [v.size, v.color].filter(Boolean).join(' | ');
        const vPrice = (v.price !== null && v.price !== undefined) ? v.price : price;
        const vStock = v.stock !== null && v.stock !== undefined ? v.stock : 'Unlimited';
        return `<div class="variant-card" onclick="selectVariant(${i})">
            <div class="variant-card-name">${escHtml(label) || 'Default'}</div>
            <div class="variant-card-price">$${parseFloat(vPrice).toFixed(2)}</div>
            <div class="variant-card-stock">Stock: ${vStock}</div>
        </div>`;
    }).join('');

    document.getElementById('variantList').innerHTML = html || '<p style="color:var(--gray-500);font-size:13px">No variants available.</p>';
    openModal('variantModal');
}

function selectVariant(idx) {
    const v      = variantContext.variants[idx];
    const label  = [v.size, v.color].filter(Boolean).join(' | ');
    const vPrice = (v.price !== null && v.price !== undefined) ? v.price : variantContext.price;
    addItemToCart({
        product_id:    variantContext.productId,
        name:          variantContext.name,
        sku:           variantContext.sku,
        image:         variantContext.image,
        unit_price:    parseFloat(vPrice),
        quantity:      1,
        variant_label: label,
        is_unlimited:  variantContext.isUnlimited,
        stock:         v.stock !== null && v.stock !== undefined ? v.stock : 9999,
    });
    closeModal('variantModal');
}

// ══════════════════════════════════════════════
//  RENDER CART
// ══════════════════════════════════════════════
function renderCart() {
    const wrap = document.getElementById('cartItems');

    if (cart.length === 0) {
        wrap.innerHTML = `<div class="empty-cart">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.2">
                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            <span>Cart is empty — tap a product to add</span>
        </div>`;
        updateTotals();
        return;
    }

    const html = cart.map((item, idx) => {
        const imgUrl = item.image
            ? `/uploads/products/${item.image}`
            : '/images/no-image.png';

        const skuHtml = item.sku
            ? `<div class="ci-sku-row">
                   <i class="fas fa-barcode" style="font-size:10px;color:var(--gray-500)"></i>
                   <span>${escHtml(item.sku)}</span>
               </div>`
            : '';

        const variantHtml = item.variant_label
            ? `<span class="ci-variant">${escHtml(item.variant_label)}</span>`
            : '';

        return `<div class="cart-item">
            <img src="${imgUrl}" alt="${escHtml(item.name)}" onerror="this.src='/images/no-image.png'">
            <div class="cart-item-info">
                <div class="ci-name" title="${escHtml(item.name)}">${escHtml(item.name)}</div>
                ${variantHtml}
                <div class="ci-price">$${item.unit_price.toFixed(2)}</div>
                ${skuHtml}
                <div class="cart-qty">
                    <button class="qty-btn" onclick="changeQty(${idx}, -1)"><i class="fas fa-minus" style="font-size:10px"></i></button>
                    <input class="qty-input" type="number" value="${item.quantity}" min="1"
                           onchange="setQty(${idx}, this.value)"
                           onclick="this.select()">
                    <button class="qty-btn" onclick="changeQty(${idx}, 1)"><i class="fas fa-plus" style="font-size:10px"></i></button>
                </div>
            </div>
            <div class="cart-item-actions">
                <button class="btn-edit-item" onclick="openEditItem(${idx})" title="Edit Quantity">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button class="btn-remove-item" onclick="removeItem(${idx})" title="Remove from Cart">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>`;
    }).join('');

    wrap.innerHTML = html;
    updateTotals();
}

// ══════════════════════════════════════════════
//  TOTALS
// ══════════════════════════════════════════════
function updateTotals() {
    const subTotal       = cart.reduce((s, i) => s + (i.unit_price * i.quantity), 0);
    const couponDiscount = couponData ? parseFloat(couponData.discount_amount) : 0;
    const taxableAmount  = Math.max(0, subTotal - couponDiscount);

    let totalTax = 0;
    document.querySelectorAll('.tax-line-amount').forEach(el => {
        const pct = parseFloat(el.dataset.percent || 0);
        const amt = taxableAmount * (pct / 100);
        totalTax += amt;
        el.textContent = '$' + amt.toFixed(2);
    });

    let shippingAmount = 0;
    const scSelect = document.getElementById('shippingChargeSelect');
    if (scSelect) {
        const opt = scSelect.options[scSelect.selectedIndex];
        shippingAmount = parseFloat(opt?.dataset?.amount || 0);
    }

    const shippingRow     = document.getElementById('shippingRow');
    const shippingDisplay = document.getElementById('shippingDisplay');
    if (shippingRow && shippingDisplay) {
        shippingRow.style.display = shippingAmount > 0 ? 'flex' : 'none';
        shippingDisplay.textContent = '$' + shippingAmount.toFixed(2);
    }

    const grandTotal = taxableAmount + totalTax + shippingAmount;

    const discountRow = document.getElementById('discountRow');
    if (discountRow) discountRow.style.display = couponDiscount > 0 ? 'flex' : 'none';

    document.getElementById('subTotalDisplay').textContent   = '$' + subTotal.toFixed(2);
    document.getElementById('discountDisplay').textContent   = '-$' + couponDiscount.toFixed(2);
    document.getElementById('totalTaxDisplay').textContent   = '$' + totalTax.toFixed(2);
    document.getElementById('grandTotalDisplay').textContent = '$' + grandTotal.toFixed(2);
    document.getElementById('grandTotalBtn').textContent     = '$' + grandTotal.toFixed(2);
}

function changeQty(idx, delta) {
    cart[idx].quantity = Math.max(1, cart[idx].quantity + delta);
    renderCart();
}
function setQty(idx, val) {
    cart[idx].quantity = Math.max(1, parseInt(val) || 1);
    renderCart();
}
function removeItem(idx) {
    cart.splice(idx, 1);
    renderCart();
}

// ══════════════════════════════════════════════
//  EDIT ITEM MODAL
// ══════════════════════════════════════════════
function openEditItem(idx) {
    document.getElementById('editCartIndex').value = idx;
    document.getElementById('editQty').value = cart[idx].quantity;
    openModal('editItemModal');
}
function saveEditItem() {
    const idx = parseInt(document.getElementById('editCartIndex').value);
    const qty = parseInt(document.getElementById('editQty').value) || 1;
    cart[idx].quantity = Math.max(1, qty);
    closeModal('editItemModal');
    renderCart();
}

// ══════════════════════════════════════════════
//  PAYMENT METHOD
// ══════════════════════════════════════════════
function selectPayMethod(el) {
    document.querySelectorAll('.pay-method').forEach(e => e.classList.remove('active'));
    el.classList.add('active');
    selectedPayMethod = el.dataset.method;
}

// ══════════════════════════════════════════════
//  CUSTOMER SEARCH — FIXED
//  সমস্যা ছিল: blur event dropdown বন্ধ করত,
//  ফলে customer click করার আগেই dropdown লুকিয়ে যেত।
//  Fix: mousedown preventDefault দিয়ে blur আটকানো হয়েছে।
// ══════════════════════════════════════════════
let customerSearchTimeout = null;
let isCustomerSelected    = false;

const custSearchEl   = document.getElementById('customerSearch');
const custDropdown   = document.getElementById('customerDropdown');
const custDdList     = document.getElementById('customerDdList');

// ── Input এ type করলে search শুরু হয়
custSearchEl.addEventListener('input', function () {
    if (isCustomerSelected) {
        // কাস্টমার already selected থাকলে clear করে নতুন search
        clearCustomer(false); // false = don't focus again
    }
    clearTimeout(customerSearchTimeout);
    const q = this.value.trim();
    if (q.length < 1) {
        closeCustomerDropdown();
        return;
    }
    // Loading state দেখাও
    custDdList.innerHTML = `<div class="customer-dd-loading">
        <div class="dd-spinner"></div> Searching...
    </div>`;
    custDropdown.classList.add('show');

    customerSearchTimeout = setTimeout(() => searchCustomers(q), 300);
});

// ── Focus হলে যদি value থাকে আবার search করো
custSearchEl.addEventListener('focus', function () {
    if (!isCustomerSelected && this.value.trim().length >= 1) {
        searchCustomers(this.value.trim());
    }
});

// ── CRITICAL FIX: dropdown এ mousedown এ preventDefault করো
// এতে blur event fire হওয়ার আগেই click ধরা পড়ে
custDropdown.addEventListener('mousedown', function (e) {
    e.preventDefault();
});

// ── blur এ dropdown বন্ধ করো (mousedown preventDefault এর কারণে
//    customer item click এ blur fire হবে না)
custSearchEl.addEventListener('blur', function () {
    setTimeout(() => closeCustomerDropdown(), 150);
});

// ── Document click: dropdown এর বাইরে click করলে বন্ধ হয়
document.addEventListener('click', function (e) {
    const wrap = document.getElementById('customerSelectWrap');
    if (wrap && !wrap.contains(e.target)) {
        closeCustomerDropdown();
    }
});

// ── Customer search AJAX call
function searchCustomers(q) {
    fetch(`{{ route('admin.pos.searchCustomers') }}?q=${encodeURIComponent(q)}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success || !data.data || data.data.length === 0) {
            custDdList.innerHTML = `
                <div class="customer-dd-empty">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    কোনো customer পাওয়া যায়নি "<strong>${escHtml(q)}</strong>"
                </div>`;
            custDropdown.classList.add('show');
            return;
        }

        const html = data.data.map(c => {
            const initials = c.name
                .split(' ')
                .map(w => w[0] || '')
                .join('')
                .substring(0, 2)
                .toUpperCase();

            const phoneHtml = c.phone
                ? `<span class="cdd-phone">
                       <i class="fas fa-phone" style="font-size:9px"></i>
                       ${escHtml(c.phone)}
                   </span>`
                : '';
            const emailHtml = c.email
                ? `<span class="cdd-email">${escHtml(c.email)}</span>`
                : '';

            // ★ onclick এ সরাসরি selectCustomer call — mousedown preventDefault এর কারণে
            //   blur fire হয় না, তাই dropdown বন্ধ হয় না click এর আগে
            return `<div class="customer-item"
                         onclick="selectCustomer(${c.id}, '${escJs(c.name)}', '${escJs(c.phone || '')}', '${escJs(c.email || '')}')">
                        <div class="customer-avatar">${initials}</div>
                        <div class="customer-info-dd">
                            <strong>${escHtml(c.name)}</strong>
                            ${phoneHtml}
                            ${emailHtml}
                        </div>
                    </div>`;
        }).join('');

        custDdList.innerHTML = html;
        custDropdown.classList.add('show');
    })
    .catch(err => {
        console.error('Customer search error:', err);
        closeCustomerDropdown();
    });
}

// ── Customer select করো
function selectCustomer(id, name, phone, email) {
    isCustomerSelected = true;

    document.getElementById('selectedCustomerId').value   = id;
    document.getElementById('selectedCustomerName').value = name;

    // Search input update
    custSearchEl.value = name + (phone ? '  ·  ' + phone : '');
    custSearchEl.classList.add('has-value');

    // Tag দেখাও
    const initials = name
        .split(' ')
        .map(w => w[0] || '')
        .join('')
        .substring(0, 2)
        .toUpperCase();

    document.getElementById('sctAvatar').textContent  = initials;
    document.getElementById('sctName').textContent    = name;
    document.getElementById('sctPhone').textContent   = phone || email || 'No contact info';
    document.getElementById('selectedCustomerTag').classList.add('show');

    closeCustomerDropdown();
    showToast(`✓ ${name} selected`, 'success');
}

// ── Customer clear করো
function clearCustomer(shouldFocus = true) {
    isCustomerSelected = false;

    document.getElementById('selectedCustomerId').value   = '';
    document.getElementById('selectedCustomerName').value = '';
    custSearchEl.value = '';
    custSearchEl.classList.remove('has-value');
    document.getElementById('selectedCustomerTag').classList.remove('show');

    if (shouldFocus) {
        custSearchEl.focus();
    }
}

function closeCustomerDropdown() {
    custDropdown.classList.remove('show');
}

// ══════════════════════════════════════════════
//  NEW CUSTOMER MODAL
// ══════════════════════════════════════════════
function openNewCustomerModal() {
    openModal('newCustomerModal');
}

function saveNewCustomer() {
    const name  = document.getElementById('newCustName').value.trim();
    const phone = document.getElementById('newCustPhone').value.trim();
    const email = document.getElementById('newCustEmail').value.trim();

    // Error clear
    ['Name', 'Phone', 'Email'].forEach(f => {
        document.getElementById('errCust' + f).textContent = '';
    });

    fetch('{{ route("admin.pos.storeCustomer") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ name, phone, email }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            selectCustomer(
                data.customer.id,
                data.customer.name,
                data.customer.phone || '',
                data.customer.email || ''
            );
            closeModal('newCustomerModal');
            // Form clear
            ['newCustName', 'newCustPhone', 'newCustEmail'].forEach(id => {
                document.getElementById(id).value = '';
            });
            showToast('Customer created!', 'success');
        } else if (data.errors) {
            Object.entries(data.errors).forEach(([k, v]) => {
                const key = k.charAt(0).toUpperCase() + k.slice(1);
                const el  = document.getElementById('errCust' + key);
                if (el) el.textContent = v[0];
            });
        }
    })
    .catch(() => showToast('Something went wrong.', 'error'));
}

// ══════════════════════════════════════════════
//  COUPON
// ══════════════════════════════════════════════
function applyCoupon() {
    const code = document.getElementById('couponCode').value.trim();
    if (!code) { showToast('Please enter a coupon code.', 'error'); return; }
    if (cart.length === 0) { showToast('Add products first!', 'error'); return; }

    const subTotal = cart.reduce((s, i) => s + (i.unit_price * i.quantity), 0);

    fetch('{{ route("admin.pos.applyCoupon") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ code, sub_total: subTotal }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            couponData = data;
            updateTotals();
            document.getElementById('couponAppliedText').textContent =
                `"${data.coupon_code}" — $${parseFloat(data.discount_amount).toFixed(2)} off`;
            document.getElementById('couponAppliedMsg').classList.add('show');
            showToast('Coupon applied!', 'success');
        } else {
            showToast(data.message || 'Invalid coupon.', 'error');
        }
    })
    .catch(() => showToast('Something went wrong.', 'error'));
}

function removeCoupon() {
    couponData = null;
    document.getElementById('couponCode').value = '';
    document.getElementById('couponAppliedMsg').classList.remove('show');
    updateTotals();
    showToast('Coupon removed.', 'success');
}

// ══════════════════════════════════════════════
//  PLACE ORDER
// ══════════════════════════════════════════════
function placeOrder(status) {
    if (cart.length === 0) { showToast('Cart is empty!', 'error'); return; }

    const subTotal       = cart.reduce((s, i) => s + (i.unit_price * i.quantity), 0);
    const couponDiscount = couponData ? parseFloat(couponData.discount_amount) : 0;
    const taxableAmount  = Math.max(0, subTotal - couponDiscount);

    let totalTax = 0;
    taxes.forEach(t => { totalTax += taxableAmount * (t.percentage / 100); });

    let shippingAmount = 0, shippingChargeId = null;
    const scSelect = document.getElementById('shippingChargeSelect');
    if (scSelect) {
        const opt = scSelect.options[scSelect.selectedIndex];
        shippingAmount   = parseFloat(opt?.dataset?.amount || 0);
        shippingChargeId = scSelect.value || null;
    }

    const grandTotal = taxableAmount + totalTax + shippingAmount;

    const payload = {
        customer_id:        document.getElementById('selectedCustomerId').value || null,
        items:              cart.map(i => ({
                                product_id:    i.product_id,
                                quantity:      i.quantity,
                                unit_price:    i.unit_price,
                                variant_label: i.variant_label || null,
                            })),
        sub_total:          subTotal.toFixed(2),
        discount_amount:    couponDiscount.toFixed(2),
        tax_amount:         totalTax.toFixed(2),
        shipping_charge_id: shippingChargeId,
        shipping_amount:    shippingAmount.toFixed(2),
        grand_total:        grandTotal.toFixed(2),
        coupon_code:        couponData ? couponData.coupon_code : null,
        coupon_discount:    couponDiscount.toFixed(2),
        payment_method:     selectedPayMethod,
        note:               document.getElementById('orderNote').value.trim(),
        status,
    };

    const btnDraft    = document.querySelector('.btn-draft');
    const btnComplete = document.querySelector('.btn-complete');
    btnDraft.disabled    = true;
    btnComplete.disabled = true;
    btnComplete.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

    fetch('{{ route("admin.pos.placeOrder") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload),
    })
    .then(r => r.json())
    .then(data => {
        btnDraft.disabled    = false;
        btnComplete.disabled = false;
        btnComplete.innerHTML = `<i class="fas fa-check-circle"></i> Complete &nbsp;<span id="grandTotalBtn">$${grandTotal.toFixed(2)}</span>`;

        if (data.success) {
            showToast(data.message, 'success');
            if (status === 'completed') {
                setTimeout(() => window.open(`{{ url('admin/pos/invoice') }}/${data.session_id}`, '_blank'), 500);
            }
            // Reset everything
            cart = [];
            couponData = null;
            document.getElementById('couponCode').value  = '';
            document.getElementById('orderNote').value   = '';
            document.getElementById('couponAppliedMsg').classList.remove('show');
            if (scSelect) scSelect.selectedIndex = 0;
            clearCustomer(false);
            renderCart();
            updateTotals();
        } else {
            showToast(data.message || 'Order failed!', 'error');
        }
    })
    .catch(() => {
        btnDraft.disabled    = false;
        btnComplete.disabled = false;
        btnComplete.innerHTML = `<i class="fas fa-check-circle"></i> Complete &nbsp;<span id="grandTotalBtn">$${grandTotal.toFixed(2)}</span>`;
        showToast('Network error. Please try again.', 'error');
    });
}

// ══════════════════════════════════════════════
//  PRODUCT SEARCH
// ══════════════════════════════════════════════
let productSearchTimeout;
['productSearch', 'brandFilter', 'categoryFilter'].forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;
    el.addEventListener(id === 'productSearch' ? 'input' : 'change', () => {
        clearTimeout(productSearchTimeout);
        productSearchTimeout = setTimeout(doProductSearch, 350);
    });
});

function doProductSearch() {
    const search      = document.getElementById('productSearch').value;
    const category_id = document.getElementById('categoryFilter').value;
    const brand       = document.getElementById('brandFilter').value;

    fetch(`{{ route('admin.pos.searchProducts') }}?search=${encodeURIComponent(search)}&category_id=${encodeURIComponent(category_id)}&brand=${encodeURIComponent(brand)}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('productGridWrap').innerHTML = data.html;
        }
    })
    .catch(() => {});
}

// ══════════════════════════════════════════════
//  HELPERS
// ══════════════════════════════════════════════
function openModal(id)  { document.getElementById(id).classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }

function escHtml(str) {
    return String(str || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
function escJs(str) {
    return String(str || '').replace(/\\/g, '\\\\').replace(/'/g, "\\'").replace(/"/g, '\\"');
}

function showToast(msg, type = 'success') {
    const t = document.createElement('div');
    t.textContent = msg;
    t.style.cssText = `
        position:fixed; top:20px; right:20px; z-index:99999;
        padding:13px 20px; border-radius:12px;
        background:${type === 'success' ? '#10b981' : '#ef4444'};
        color:#fff; font-size:13px; font-weight:700;
        box-shadow:0 6px 24px rgba(0,0,0,.2);
        animation:toastIn .3s ease;
        max-width:320px;
        display:flex; align-items:center; gap:8px;
    `;
    document.body.appendChild(t);
    setTimeout(() => { t.style.opacity = '0'; t.style.transition = 'opacity .3s'; }, 2700);
    setTimeout(() => t.remove(), 3000);
}

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function (e) {
        if (e.target === this) this.classList.remove('show');
    });
});
</script>

<style>
@keyframes toastIn {
    from { transform: translateX(20px); opacity: 0; }
    to   { transform: translateX(0);    opacity: 1; }
}
</style>

@endsection
