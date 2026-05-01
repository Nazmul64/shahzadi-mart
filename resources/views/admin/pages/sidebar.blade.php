{{-- ============================================================
     ADMIN SIDEBAR
     resources/views/admin/pages/sidebar.blade.php
     Premium UI/UX - 100% Permission-based
============================================================ --}}

@php
    $u = auth()->user();

    // ── Active state helpers ───────────────────────────────────────────────
    $dashActive       = request()->routeIs('admin.dashboard');
    $posActive        = request()->routeIs('admin.pos.*');
    $ordersActive     = request()->routeIs('admin.order.*') || request()->routeIs('admin.orders.*');
    $incompleteActive = request()->routeIs('admin.incomplete-orders.*');
    $catsActive       = request()->routeIs('admin.category.*') || request()->routeIs('admin.subcategory.*') || request()->routeIs('admin.childcategory.*');
    $prodsActive      = request()->routeIs('admin.products.*') || request()->routeIs('admin.product.settings.*');
    $affActive        = request()->routeIs('admin.affiliateproduct.*');
    $couponsActive    = request()->routeIs('admin.coupons.*');
    $custsActive      = request()->routeIs('customer.*');
    $usersActive      = request()->routeIs('admin.users.*');
    $vendorsActive    = request()->routeIs('admin.seller.*');
    $rolesActive      = request()->routeIs('admin.roles.*');
    $permsActive      = request()->routeIs('admin.permissions.*');
    $sliderActive     = request()->routeIs('admin.slider.*');
    $reviewsActive    = request()->routeIs('admin.reviews.*');
    $campaignActive   = request()->routeIs('admin.campaigncreate.*');
    $shippingActive   = request()->routeIs('admin.shipping.*');
    $colorsActive     = request()->routeIs('admin.color.*') || request()->routeIs('admin.size.*') || request()->routeIs('admin.unit.*') || request()->routeIs('admin.productbrands.*');
    $dupActive        = request()->routeIs('admin.duplicateordersetting.*') || request()->routeIs('admin.Ipblockmanage.*');
    $deliveryActive   = request()->routeIs('admin.DeliveryInformation.*');
    $taxActive        = request()->routeIs('admin.alltaxes.*');
    $chatActive       = request()->routeIs('admin.chat.*');
    $settingsActive   = request()->routeIs('admin.Generalsettings.*') || request()->routeIs('admin.websitefavicon.*') || request()->routeIs('admin.contact.*') || request()->routeIs('admin.pixels.*') || request()->routeIs('admin.googletagmanager.*') || $campaignActive || $shippingActive || $reviewsActive || $taxActive || request()->routeIs('admin.nagad.*');
    $apiActive        = request()->routeIs('admin.paymentgetewaymanage.*') || request()->routeIs('admin.steadfastcourier.*') || request()->routeIs('admin.pathaocourier.*') || request()->routeIs('admin.Smsgatewaysetup.*') || request()->routeIs('admin.payment.*') || request()->routeIs('admin.payment.history');
    $pagesActive      = request()->routeIs('admin.pages.*') || request()->routeIs('admin.footercategory.*') || request()->routeIs('admin.aboutcompany.*') || request()->routeIs('admin.tremsandcondation.*') || request()->routeIs('admin.contactinfomationadmins.*');
    $aiActive         = request()->routeIs('admin.aiprompt.*');
    $posOrdersActive  = request()->routeIs('admin.pos.orders');
    $staffHistoryActive = request()->routeIs('admin.order-history.*');
    $assignActive       = request()->routeIs('admin.order.assignments.*');
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --sb-w          : 280px;
    --sb-col-w      : 76px;
    --sb-bg         : #0B1121;
    --sb-bg-glass   : rgba(11, 17, 33, 0.95);
    --sb-border     : rgba(255, 255, 255, 0.05);
    --sb-brand-h    : 72px;
    --sb-item-h     : 44px;
    
    --sb-accent-1   : #3b82f6;
    --sb-accent-2   : #8b5cf6;
    --sb-gradient   : linear-gradient(135deg, var(--sb-accent-1), var(--sb-accent-2));
    
    --sb-text       : #94a3b8;
    --sb-text-hover : #f8fafc;
    --sb-text-active: #ffffff;
    
    --sb-hover-bg   : rgba(255, 255, 255, 0.04);
    --sb-active-bg  : rgba(59, 130, 246, 0.1);
    
    --sb-radius     : 12px;
    --sb-ease       : 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: var(--sb-w);
    background: var(--sb-bg-glass);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    display: flex;
    flex-direction: column;
    z-index: 1040;
    transition: width var(--sb-ease), transform var(--sb-ease);
    border-right: 1px solid var(--sb-border);
    box-shadow: 4px 0 24px rgba(0,0,0,0.2);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

body.sb-collapsed #sidebar { width: var(--sb-col-w); }
@media(max-width: 991px){
    #sidebar { transform: translateX(-100%); width: var(--sb-w); }
    body.sb-open #sidebar { transform: translateX(0); box-shadow: 4px 0 32px rgba(0,0,0,0.5); }
}

#main-content { margin-left: var(--sb-w); transition: margin-left var(--sb-ease); min-height: 100vh; }
body.sb-collapsed #main-content { margin-left: var(--sb-col-w); }
@media(max-width: 991px){ #main-content { margin-left: 0 !important; } }

.sb-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); z-index: 1039; backdrop-filter: blur(4px); }
body.sb-open .sb-overlay { display: block; }

.sb-brand {
    height: var(--sb-brand-h);
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 0 20px;
    flex-shrink: 0;
    border-bottom: 1px solid var(--sb-border);
    text-decoration: none;
    white-space: nowrap;
    overflow: hidden;
    position: relative;
}

.sb-brand::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.5), transparent);
    opacity: 0;
    transition: opacity 0.5s ease;
}

.sb-brand:hover::after { opacity: 1; }

.sb-icon {
    width: 38px;
    height: 38px;
    background: var(--sb-gradient);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #fff;
    flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4);
    position: relative;
    overflow: hidden;
}

.sb-icon::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(180deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
}

.sb-brand-text { display: flex; flex-direction: column; overflow: hidden; }
.sb-brand-name { font-size: 16px; font-weight: 800; color: #fff; letter-spacing: -0.3px; }
.sb-brand-tag { font-size: 11px; color: var(--sb-accent-1); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-top: 2px; }

body.sb-collapsed .sb-brand-text, .sb-section { transition: opacity var(--sb-ease); }
body.sb-collapsed .sb-brand-text { opacity: 0; pointer-events: none; }

.sb-nav {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 16px 0 24px;
}
.sb-nav::-webkit-scrollbar { width: 5px; }
.sb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 10px; }
.sb-nav::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.15); }

.sb-section {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: #475569;
    padding: 20px 24px 8px;
    white-space: nowrap;
}
body.sb-collapsed .sb-section { opacity: 0; height: 0; padding: 0; overflow: hidden; }

.sb-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: var(--sb-item-h);
    padding: 0 16px;
    margin: 2px 12px;
    border-radius: var(--sb-radius);
    color: var(--sb-text);
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    white-space: nowrap;
    overflow: hidden;
    transition: all 0.2s ease;
    border: 1px solid transparent;
    background: transparent;
    user-select: none;
}

.sb-item:hover {
    background: var(--sb-hover-bg);
    color: var(--sb-text-hover);
    transform: translateX(4px);
}

.sb-item.active, .sb-item.open {
    background: var(--sb-active-bg);
    color: var(--sb-text-active);
    border-color: rgba(59, 130, 246, 0.2);
    box-shadow: inset 0 0 0 1px rgba(255,255,255,0.02);
}

.sb-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    height: 60%;
    width: 3px;
    background: var(--sb-accent-1);
    border-radius: 0 4px 4px 0;
    box-shadow: 0 0 8px var(--sb-accent-1);
}

.sb-left { display: flex; align-items: center; gap: 14px; overflow: hidden; flex: 1; min-width: 0; }
.sb-text { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; transition: opacity var(--sb-ease); font-weight: 600; }
body.sb-collapsed .sb-text { opacity: 0; width: 0; pointer-events: none; }

.sb-ico {
    font-size: 18px;
    flex-shrink: 0;
    width: 22px;
    text-align: center;
    color: #64748b;
    transition: all 0.3s ease;
}
.sb-item:hover .sb-ico { color: #fff; transform: scale(1.1); }
.sb-item.active .sb-ico, .sb-item.open .sb-ico { color: var(--sb-accent-1); text-shadow: 0 0 12px rgba(59, 130, 246, 0.4); }

.sb-arr {
    font-size: 11px;
    flex-shrink: 0;
    color: #475569;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
body.sb-collapsed .sb-arr { opacity: 0; }
.sb-item.open .sb-arr { transform: rotate(90deg); color: var(--sb-text-active); }

.sb-sub {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    margin: 0 12px;
    border-radius: 0 0 var(--sb-radius) var(--sb-radius);
}
.sb-sub.open { max-height: 1200px; }
body.sb-collapsed .sb-sub { display: none; }

.sb-sub-inner {
    padding: 6px 0 12px;
    position: relative;
}
.sb-sub-inner::before {
    content: '';
    position: absolute;
    left: 26px;
    top: 0;
    bottom: 12px;
    width: 1px;
    background: rgba(255,255,255,0.06);
}

.sb-sub a {
    display: flex;
    align-items: center;
    gap: 12px;
    height: 38px;
    padding: 0 16px 0 46px;
    font-size: 13.5px;
    font-weight: 500;
    color: #64748b;
    text-decoration: none;
    border-radius: 8px;
    margin: 2px 8px;
    transition: all 0.2s ease;
    position: relative;
}

.sb-sub a::before {
    content: '';
    position: absolute;
    left: 22px;
    top: 50%;
    transform: translateY(-50%);
    width: 8px;
    height: 1px;
    background: rgba(255,255,255,0.06);
    transition: all 0.2s ease;
}

.sb-sub a i { font-size: 14px; color: #475569; transition: color 0.2s ease; }

.sb-sub a:hover { color: #e2e8f0; background: rgba(255,255,255,0.03); transform: translateX(3px); }
.sb-sub a:hover::before { width: 12px; background: var(--sb-accent-1); }
.sb-sub a:hover i { color: #e2e8f0; }

.sb-sub a.active { color: #fff; background: rgba(255,255,255,0.05); }
.sb-sub a.active::before { width: 12px; background: var(--sb-accent-1); height: 2px; border-radius: 2px; }
.sb-sub a.active i { color: var(--sb-accent-1); }

.sb-sep { height: 1px; background: linear-gradient(90deg, transparent, var(--sb-border), transparent); margin: 12px 24px; }

.sb-user-profile {
    padding: 16px 20px;
    border-top: 1px solid var(--sb-border);
    background: rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    gap: 12px;
    overflow: hidden;
    text-decoration: none;
    transition: background 0.2s ease;
}
.sb-user-profile:hover { background: rgba(0,0,0,0.3); }

.sb-avatar {
    width: 36px; height: 36px; border-radius: 10px;
    background: var(--sb-accent-1);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 14px; flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.sb-user-info { display: flex; flex-direction: column; overflow: hidden; }
.sb-user-name { font-size: 14px; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sb-user-role { font-size: 11px; color: var(--sb-text); margin-top: 2px; }

.sb-logout-btn {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
    display: flex; align-items: center; justify-content: center;
    margin-left: auto; cursor: pointer; transition: all 0.2s ease;
}
.sb-logout-btn:hover { background: #ef4444; color: #fff; transform: scale(1.05); }

.sb-tip {
    position: fixed;
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(8px);
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 8px;
    white-space: nowrap;
    z-index: 9999;
    pointer-events: none;
    box-shadow: 0 4px 16px rgba(0,0,0,0.3);
    border: 1px solid rgba(255,255,255,0.1);
    font-family: 'Plus Jakarta Sans', sans-serif;
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.2s ease;
}
.sb-tip.show { opacity: 1; transform: translateX(0); }

body.sb-collapsed .sb-user-profile { justify-content: center; padding: 16px 0; }
body.sb-collapsed .sb-user-info, body.sb-collapsed .sb-logout-btn { display: none; }
</style>

<aside id="sidebar">

{{-- ══ BRAND ══ --}}
<a href="{{ route('admin.dashboard') }}" class="sb-brand">
    <div class="sb-icon"><i class="bi bi-shop"></i></div>
    <div class="sb-brand-text">
        <span class="sb-brand-name">Shahzadimart</span>
        <span class="sb-brand-tag">Admin Portal</span>
    </div>
</a>

<nav class="sb-nav">

{{-- ════ MAIN ════ --}}
<div class="sb-section">Main Menu</div>

{{-- Dashboard --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-dashboard'))
<a href="{{ route('admin.dashboard') }}" class="sb-item {{ $dashActive ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-grid-1x2-fill sb-ico"></i><span class="sb-text">Dashboard</span></span>
</a>
@endif

{{-- POS --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-orders','create-orders']))
<div class="sb-item {{ $posActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-pc-display-horizontal sb-ico"></i><span class="sb-text">POS System</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $posActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.pos.index') }}" class="{{ request()->routeIs('admin.pos.index') ? 'active' : '' }}">
            <i class="bi bi-calculator"></i> POS Terminal
        </a>
        <a href="{{ route('admin.pos.orders') }}" class="{{ $posOrdersActive ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> Sales History
        </a>
    </div>
</div>
@endif

{{-- Orders --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-orders','edit-orders','delete-orders','create-orders']))
<div class="sb-item {{ $ordersActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-bag-check-fill sb-ico"></i><span class="sb-text">Orders Hub</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $ordersActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.order.allorder') }}" class="{{ request()->routeIs('admin.order.allorder') && !request()->filled('status') ? 'active' : '' }}">
            <i class="bi bi-basket3"></i> All Orders
        </a>
        <a href="{{ route('admin.order.allorder', ['status' => 'pending']) }}" class="{{ request('status') === 'pending' ? 'active' : '' }}">
            <i class="bi bi-hourglass-split"></i> Pending
        </a>
        <a href="{{ route('admin.order.allorder', ['status' => 'processing']) }}" class="{{ request('status') === 'processing' ? 'active' : '' }}">
            <i class="bi bi-arrow-repeat"></i> Processing
        </a>
        <a href="{{ route('admin.order.allorder', ['status' => 'shipped']) }}" class="{{ request('status') === 'shipped' ? 'active' : '' }}">
            <i class="bi bi-truck"></i> Shipped
        </a>
        <a href="{{ route('admin.order.allorder', ['status' => 'delivered']) }}" class="{{ request('status') === 'delivered' ? 'active' : '' }}">
            <i class="bi bi-check2-circle"></i> Delivered
        </a>
        <a href="{{ route('admin.order.allorder', ['status' => 'cancelled']) }}" class="{{ request('status') === 'cancelled' ? 'active' : '' }}">
            <i class="bi bi-x-circle"></i> Cancelled
        </a>
        @if($u->isSuperAdmin() || $u->hasPermission('create-orders'))
        <a href="{{ route('admin.order.create') }}" class="{{ request()->routeIs('admin.order.create') ? 'active' : '' }}">
            <i class="bi bi-plus-lg"></i> Create Order
        </a>
        @endif

        @if($u->isSuperAdmin() || $u->hasPermission('view-orders'))
        <a href="{{ route('admin.order.assignments.index') }}" class="{{ $assignActive ? 'active' : '' }}">
            <i class="bi bi-person-check"></i> Staff Assignments
        </a>
        <a href="{{ route('admin.order-history.index') }}" class="{{ $staffHistoryActive ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Activity History
        </a>
        @endif
    </div>
</div>
@endif

{{-- Payment Logs --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-orders'))
<div class="sb-item {{ (request()->routeIs('admin.payment.history') || request()->routeIs('admin.nagad.*') || request()->routeIs('admin.paymentgetewaymanage.*')) ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-credit-card-2-front sb-ico"></i><span class="sb-text">Payment Logs</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ (request()->routeIs('admin.payment.history') || request()->routeIs('admin.nagad.*') || request()->routeIs('admin.paymentgetewaymanage.*')) ? 'show' : '' }}">
    <div class="sb-sub-wrap">
        <a href="{{ route('admin.payment.history') }}" class="{{ request()->routeIs('admin.payment.history') ? 'active' : '' }}">
            <i class="bi bi-receipt-cutoff"></i> Payment History
        </a>
        <a href="{{ route('admin.nagad.index') }}" class="{{ request()->routeIs('admin.nagad.*') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i> Nagad API Setup
        </a>
        <a href="{{ route('admin.paymentgetewaymanage.index') }}" class="{{ request()->routeIs('admin.paymentgetewaymanage.*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Manage Gateways
        </a>
    </div>
</div>
@endif

{{-- Incomplete Orders --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-orders'))
<a href="{{ route('admin.incomplete-orders.index') }}" class="sb-item {{ $incompleteActive ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-cart-x-fill sb-ico"></i><span class="sb-text">Incomplete Orders</span></span>
</a>
@endif

{{-- Products --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-products','create-products','edit-products','delete-products','approve-products']))
<div class="sb-item {{ $prodsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-box-seam-fill sb-ico"></i><span class="sb-text">Products</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $prodsActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
            <i class="bi bi-boxes"></i> All Products
        </a>
        @if($u->isSuperAdmin() || $u->hasPermission('create-products'))
        <a href="{{ route('admin.products.create') }}" class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
            <i class="bi bi-plus-lg"></i> Add Product
        </a>
        @endif
        <a href="{{ route('admin.products.deactivated') }}" class="{{ request()->routeIs('admin.products.deactivated') ? 'active' : '' }}">
            <i class="bi bi-slash-circle"></i> Deactivated
        </a>
        <a href="{{ route('admin.products.catalog') }}" class="{{ request()->routeIs('admin.products.catalog') ? 'active' : '' }}">
            <i class="bi bi-journal-bookmark"></i> Catalog
        </a>
        @if($u->isSuperAdmin() || $u->hasPermission('edit-products'))
        <a href="{{ route('admin.product.settings.index') }}" class="{{ request()->routeIs('admin.product.settings.*') ? 'active' : '' }}">
            <i class="bi bi-sliders"></i> Settings
        </a>
        @endif
    </div>
</div>
@endif

{{-- Categories --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-categories','create-categories','edit-categories','delete-categories']))
<div class="sb-item {{ $catsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-tags-fill sb-ico"></i><span class="sb-text">Categories</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $catsActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.category.index') }}" class="{{ request()->routeIs('admin.category.index') ? 'active' : '' }}">
            <i class="bi bi-bookmark-fill"></i> Categories
        </a>
        @if($u->isSuperAdmin() || $u->hasPermission('create-categories'))
        <a href="{{ route('admin.category.create') }}" class="{{ request()->routeIs('admin.category.create') ? 'active' : '' }}">
            <i class="bi bi-plus-lg"></i> Add Category
        </a>
        @endif
        <a href="{{ route('admin.subcategory.index') }}" class="{{ request()->routeIs('admin.subcategory.index') ? 'active' : '' }}">
            <i class="bi bi-bookmarks-fill"></i> Sub Categories
        </a>
        <a href="{{ route('admin.childcategory.index') }}" class="{{ request()->routeIs('admin.childcategory.index') ? 'active' : '' }}">
            <i class="bi bi-diagram-3-fill"></i> Child Categories
        </a>
    </div>
</div>
@endif

{{-- Color, Size & Brands --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-products','create-products','edit-products']))
<div class="sb-item {{ $colorsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-palette-fill sb-ico"></i><span class="sb-text">Attributes & Brands</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $colorsActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.color.index') }}" class="{{ request()->routeIs('admin.color.*') ? 'active' : '' }}">
            <i class="bi bi-paint-bucket"></i> Colors
        </a>
        <a href="{{ route('admin.size.index') }}" class="{{ request()->routeIs('admin.size.*') ? 'active' : '' }}">
            <i class="bi bi-aspect-ratio-fill"></i> Sizes
        </a>
        <a href="{{ route('admin.unit.index') }}" class="{{ request()->routeIs('admin.unit.*') ? 'active' : '' }}">
            <i class="bi bi-rulers"></i> Units
        </a>
        <a href="{{ route('admin.productbrands.index') }}" class="{{ request()->routeIs('admin.productbrands.*') ? 'active' : '' }}">
            <i class="bi bi-star-fill"></i> Brands
        </a>
    </div>
</div>
@endif

{{-- Affiliate Products --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-products','create-products']))
<div class="sb-item {{ $affActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-share-fill sb-ico"></i><span class="sb-text">Affiliate Products</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $affActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.affiliateproduct.index') }}" class="{{ request()->routeIs('admin.affiliateproduct.index') ? 'active' : '' }}">
            <i class="bi bi-view-list"></i> All Affiliates
        </a>
        @if($u->isSuperAdmin() || $u->hasPermission('create-products'))
        <a href="{{ route('admin.affiliateproduct.create') }}" class="{{ request()->routeIs('admin.affiliateproduct.create') ? 'active' : '' }}">
            <i class="bi bi-plus-lg"></i> Add Affiliate
        </a>
        @endif
    </div>
</div>
@endif

{{-- ════ MARKETING & CRM ════ --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-users','create-users','view-orders']))
<div class="sb-sep"></div>
<div class="sb-section">Marketing & CRM</div>
@endif

{{-- Customers --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-users'))
<div class="sb-item {{ $custsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-people-fill sb-ico"></i><span class="sb-text">Customers</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $custsActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('customer.index') }}" class="{{ request()->routeIs('customer.index') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill"></i> All Customers
        </a>
        @if($u->isSuperAdmin() || $u->hasPermission('create-users'))
        <a href="{{ route('customer.create') }}" class="{{ request()->routeIs('customer.create') ? 'active' : '' }}">
            <i class="bi bi-person-plus-fill"></i> Add Customer
        </a>
        @endif
    </div>
</div>
@endif

{{-- Vendors --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-sellers','approve-sellers','suspend-sellers']))
<div class="sb-item {{ $vendorsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-shop-window sb-ico"></i><span class="sb-text">Vendors</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $vendorsActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.seller.register.list') }}" class="{{ request()->routeIs('admin.seller.register.list') ? 'active' : '' }}">
            <i class="bi bi-list-stars"></i> All Vendors
        </a>
        @if($u->isSuperAdmin() || $u->hasPermission('approve-sellers'))
        <a href="{{ route('admin.seller.register.check') }}" class="{{ request()->routeIs('admin.seller.register.check') ? 'active' : '' }}">
            <i class="bi bi-patch-check-fill"></i> Approvals
        </a>
        @endif
    </div>
</div>
@endif

{{-- Coupons --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-orders'))
<div class="sb-item {{ $couponsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-ticket-detailed-fill sb-ico"></i><span class="sb-text">Coupons</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $couponsActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.coupons.index') }}" class="{{ request()->routeIs('admin.coupons.index') ? 'active' : '' }}">
            <i class="bi bi-ticket-fill"></i> All Coupons
        </a>
        <a href="{{ route('admin.coupons.create') }}" class="{{ request()->routeIs('admin.coupons.create') ? 'active' : '' }}">
            <i class="bi bi-plus-lg"></i> Add Coupon
        </a>
    </div>
</div>
@endif

{{-- Live Chat --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-users'))
<a href="{{ route('admin.chat.index') }}" class="sb-item {{ $chatActive ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-chat-right-dots-fill sb-ico"></i><span class="sb-text">Live Chat</span></span>
</a>
@endif

{{-- Reviews --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-reports'))
<a href="{{ route('admin.reviews.index') }}" class="sb-item {{ $reviewsActive ? 'active' : '' }}">
    <span class="sb-left"><i class="bi bi-star-fill sb-ico"></i><span class="sb-text">Product Reviews</span></span>
</a>
@endif

{{-- ════ SYSTEM & SECURITY ════ --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-roles','view-users','view-settings']))
<div class="sb-sep"></div>
<div class="sb-section">System & Security</div>
@endif

{{-- Administrators --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-users'))
<div class="sb-item {{ $usersActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-person-bounding-box sb-ico"></i><span class="sb-text">Administrators</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $usersActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> All Admins
        </a>
        @if($u->isSuperAdmin() || $u->hasPermission('create-users'))
        <a href="{{ route('admin.users.create') }}" class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
            <i class="bi bi-person-plus-fill"></i> Add Admin
        </a>
        @endif
    </div>
</div>
@endif

{{-- Roles & Permissions --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-roles','create-roles','edit-roles']))
<div class="sb-item {{ ($rolesActive || $permsActive) ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-shield-lock-fill sb-ico"></i><span class="sb-text">Access Control</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ ($rolesActive || $permsActive) ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <i class="bi bi-shield-check"></i> Roles
        </a>
        <a href="{{ route('admin.permissions.index') }}" class="{{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
            <i class="bi bi-key-fill"></i> Permissions
        </a>
    </div>
</div>
@endif

{{-- Configuration (Settings) --}}
@if($u->isSuperAdmin() || $u->hasPermission('edit-settings'))
<div class="sb-item {{ $settingsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-gear-fill sb-ico"></i><span class="sb-text">Configuration</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $settingsActive ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.Generalsettings.index') }}" class="{{ request()->routeIs('admin.Generalsettings.*') ? 'active' : '' }}">
            <i class="bi bi-card-image"></i> Logo Settings
        </a>
        <a href="{{ route('admin.websitefavicon.index') }}" class="{{ request()->routeIs('admin.websitefavicon.*') ? 'active' : '' }}">
            <i class="bi bi-globe2"></i> Favicon
        </a>
        <a href="{{ route('admin.contact.index') }}" class="{{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
            <i class="bi bi-telephone-fill"></i> Contact Details
        </a>
        <a href="{{ route('admin.pixels.index') }}" class="{{ request()->routeIs('admin.pixels.*') ? 'active' : '' }}">
            <i class="bi bi-code-slash"></i> Pixel Scripts
        </a>
        <a href="{{ route('admin.googletagmanager.index') }}" class="{{ request()->routeIs('admin.googletagmanager.*') ? 'active' : '' }}">
            <i class="bi bi-google"></i> Tag Manager
        </a>
        <a href="{{ route('admin.campaigncreate.index') }}" class="{{ request()->routeIs('admin.campaigncreate.*') ? 'active' : '' }}">
            <i class="bi bi-megaphone-fill"></i> Campaigns
        </a>
        <a href="{{ route('admin.shipping.index') }}" class="{{ request()->routeIs('admin.shipping.*') ? 'active' : '' }}">
            <i class="bi bi-truck-flatbed"></i> Shipping Charges
        </a>
        <a href="{{ route('admin.alltaxes.index') }}" class="{{ request()->routeIs('admin.alltaxes.*') ? 'active' : '' }}">
            <i class="bi bi-percent"></i> Taxes
        </a>
        <a href="{{ route('admin.aiprompt.index') }}" class="{{ request()->routeIs('admin.aiprompt.*') ? 'active' : '' }}">
            <i class="bi bi-robot"></i> AI Prompts
        </a>
    </div>
</div>
@endif

{{-- Advanced Settings --}}
@if($u->isSuperAdmin() || $u->hasPermission('edit-settings'))
<div class="sb-item {{ ($apiActive || $dupActive || $sliderActive || $pagesActive) ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="bi bi-motherboard-fill sb-ico"></i><span class="sb-text">Advanced Settings</span></span>
    <i class="bi bi-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ ($apiActive || $dupActive || $sliderActive || $pagesActive) ? 'open' : '' }}">
    <div class="sb-sub-inner">
        <a href="{{ route('admin.paymentgetewaymanage.index') }}" class="{{ request()->routeIs('admin.paymentgetewaymanage.*') ? 'active' : '' }}">
            <i class="bi bi-credit-card-fill"></i> Gateways
        </a>
        <a href="{{ route('admin.steadfastcourier.create') }}" class="{{ request()->routeIs('admin.steadfastcourier.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Steadfast
        </a>
        <a href="{{ route('admin.pathaocourier.create') }}" class="{{ request()->routeIs('admin.pathaocourier.*') ? 'active' : '' }}">
            <i class="bi bi-bicycle"></i> Pathao
        </a>
        <a href="{{ route('admin.Smsgatewaysetup.create') }}" class="{{ request()->routeIs('admin.Smsgatewaysetup.*') ? 'active' : '' }}">
            <i class="bi bi-chat-left-text-fill"></i> SMS Gateway
        </a>
        <a href="{{ route('admin.slider.index') }}" class="{{ request()->routeIs('admin.slider.*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Sliders
        </a>
        <a href="{{ route('admin.duplicateordersetting.index') }}" class="{{ request()->routeIs('admin.duplicateordersetting.*') ? 'active' : '' }}">
            <i class="bi bi-files"></i> Duplicates
        </a>
        <a href="{{ route('admin.Ipblockmanage.index') }}" class="{{ request()->routeIs('admin.Ipblockmanage.*') ? 'active' : '' }}">
            <i class="bi bi-shield-fill-x"></i> IP Blocking
        </a>
        <a href="{{ route('admin.pages.index') }}" class="{{ request()->routeIs('admin.pages.*') || request()->routeIs('admin.footercategory.*') || request()->routeIs('admin.aboutcompany.*') || request()->routeIs('admin.tremsandcondation.*') || request()->routeIs('admin.contactinfomationadmins.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text-fill"></i> Pages
        </a>
    </div>
</div>
@endif

</nav>

{{-- ══ USER PROFILE & LOGOUT ══ --}}
<div class="sb-user-profile">
    <div class="sb-avatar">{{ substr($u->name, 0, 1) }}</div>
    <div class="sb-user-info">
        <div class="sb-user-name">{{ $u->name }}</div>
        <div class="sb-user-role">Administrator</div>
    </div>
    <form method="POST" action="{{ route('admin.logout') }}" style="margin-left: auto;">
        @csrf
        <button type="submit" class="sb-logout-btn" title="Logout">
            <i class="bi bi-power"></i>
        </button>
    </form>
</div>

</aside>

<div class="sb-overlay" onclick="sbClose()"></div>

<script>
(function(){
    'use strict';
    window.toggleSidebar = function(){
        if(window.innerWidth < 992){ document.body.classList.toggle('sb-open'); }
        else { document.body.classList.toggle('sb-collapsed'); }
    };
    window.sbClose = function(){ document.body.classList.remove('sb-open'); };
    
    window.sbToggle = function(t){
        var s = t.nextElementSibling;
        if(!s || !s.classList.contains('sb-sub')) return;
        var open = s.classList.contains('open');
        document.querySelectorAll('.sb-sub.open').forEach(function(x){
            x.classList.remove('open');
            if(x.previousElementSibling) x.previousElementSibling.classList.remove('open');
        });
        if(!open){
            s.classList.add('open');
            t.classList.add('open');
        }
    };
    
    document.querySelectorAll('.sb-sub').forEach(function(s){
        if(s.querySelector('a.active')){
            s.classList.add('open');
            if(s.previousElementSibling) s.previousElementSibling.classList.add('open');
        }
    });
    
    document.addEventListener('keydown', function(e){ if(e.key === 'Escape') window.sbClose(); });
    
    var sx = 0, sb = document.getElementById('sidebar');
    if(sb){
        sb.addEventListener('touchstart', function(e){ sx = e.touches[0].clientX; }, {passive: true});
        sb.addEventListener('touchend', function(e){ if(sx - e.changedTouches[0].clientX > 60) window.sbClose(); }, {passive: true});
    }
    
    document.querySelectorAll('#sidebar .sb-item').forEach(function(el){
        var t = el.querySelector('.sb-text');
        if(!t) return;
        var label = t.textContent.trim();
        
        el.addEventListener('mouseenter', function(){
            if(!document.body.classList.contains('sb-collapsed')) return;
            var r = el.getBoundingClientRect();
            var tip = document.createElement('div');
            tip.className = 'sb-tip';
            tip.textContent = label;
            document.body.appendChild(tip);
            
            setTimeout(() => {
                tip.style.left = (r.right + 12) + 'px';
                tip.style.top = (r.top + r.height/2 - tip.offsetHeight/2) + 'px';
                tip.classList.add('show');
            }, 10);
            
            el._tip = tip;
        });
        
        el.addEventListener('mouseleave', function(){
            if(el._tip){
                var tip = el._tip;
                tip.classList.remove('show');
                setTimeout(() => tip.remove(), 200);
                el._tip = null;
            }
        });
    });
})();
</script>
