{{-- ============================================================
     SIDEBAR — resources/views/admin/partials/sidebar.blade.php
============================================================ --}}

@php
    $dashActive     = request()->routeIs('admin.dashboard');
    $ordersActive   = request()->routeIs('admin.orders*');
    $catsActive     = request()->routeIs('admin.category.*')
                   || request()->routeIs('admin.subcategory.*')
                   || request()->routeIs('admin.childcategory.*');
    $prodsActive    = request()->routeIs('admin.products.*')
                   || request()->routeIs('admin.product.settings.*');
    $affActive      = request()->routeIs('admin.affiliateproduct.*');
    $couponsActive  = request()->routeIs('admin.coupons.*');
    // Customer routes are outside the admin. group so NO admin. prefix
    $custsActive    = request()->routeIs('customer.*');
    $usersActive    = request()->routeIs('admin.users.*');
    $vendorsActive  = request()->routeIs('admin.vendors*');
    $rolesActive    = request()->routeIs('admin.roles.*');
    $permsActive    = request()->routeIs('admin.permissions.*');
    $blogsActive    = request()->routeIs('admin.blog*');
    $sliderActive   = request()->routeIs('admin.slider.*');
    $settingsActive = request()->routeIs('admin.Generalsettings.*')
                   || request()->routeIs('admin.websitefavicon.*');
@endphp

<style>
:root {
    --sb-width       : 260px;
    --sb-collapsed-w : 68px;
    --sb-bg          : #0f1923;
    --sb-border      : rgba(255,255,255,.06);
    --sb-brand-h     : 64px;
    --sb-item-h      : 42px;
    --sb-accent      : #3b82f6;
    --sb-accent-soft : rgba(59,130,246,.12);
    --sb-text        : rgba(255,255,255,.72);
    --sb-text-dim    : rgba(255,255,255,.35);
    --sb-hover-bg    : rgba(255,255,255,.05);
    --sb-active-bg   : rgba(59,130,246,.14);
    --sb-active-text : #60a5fa;
    --sb-radius      : 9px;
    --sb-sub-bg      : rgba(0,0,0,.18);
    --sb-ease        : 240ms cubic-bezier(.4,0,.2,1);
}
#sidebar {
    position       : fixed;
    top: 0; left: 0; bottom: 0;
    width          : var(--sb-width);
    background     : var(--sb-bg);
    display        : flex;
    flex-direction : column;
    overflow       : hidden;
    z-index        : 1040;
    transition     : width var(--sb-ease), transform var(--sb-ease);
    border-right   : 1px solid var(--sb-border);
    box-shadow     : 4px 0 24px rgba(0,0,0,.28);
}
body.sb-collapsed #sidebar { width: var(--sb-collapsed-w); }
@media (max-width: 991px) {
    #sidebar { transform: translateX(-100%); width: var(--sb-width); box-shadow: none; }
    body.sb-open #sidebar { transform: translateX(0); box-shadow: 4px 0 32px rgba(0,0,0,.45); }
}
#main-content {
    margin-left : var(--sb-width);
    transition  : margin-left var(--sb-ease);
    min-height  : 100vh;
    box-sizing  : border-box;
}
body.sb-collapsed #main-content { margin-left: var(--sb-collapsed-w); }
@media (max-width: 991px) { #main-content { margin-left: 0 !important; } }
.page-wrapper { width: 100%; padding: 20px 24px; box-sizing: border-box; }
.sb-overlay {
    display    : none;
    position   : fixed;
    inset      : 0;
    background : rgba(0,0,0,.55);
    z-index    : 1039;
    backdrop-filter: blur(2px);
}
body.sb-open .sb-overlay { display: block; }
.sidebar-brand {
    height         : var(--sb-brand-h);
    display        : flex;
    align-items    : center;
    gap            : 11px;
    padding        : 0 18px;
    flex-shrink    : 0;
    border-bottom  : 1px solid var(--sb-border);
    text-decoration: none;
    white-space    : nowrap;
    overflow       : hidden;
    background     : rgba(0,0,0,.12);
}
.sb-logo-icon {
    width           : 34px;
    height          : 34px;
    background      : linear-gradient(135deg,#3b82f6,#1d4ed8);
    border-radius   : 9px;
    display         : flex;
    align-items     : center;
    justify-content : center;
    font-size       : 16px;
    color           : #fff;
    flex-shrink     : 0;
    box-shadow      : 0 3px 10px rgba(59,130,246,.4);
}
.sb-brand-text { display: flex; flex-direction: column; overflow: hidden; }
.sb-brand-name {
    font-size     : 14.5px;
    font-weight   : 800;
    color         : #fff;
    letter-spacing: .2px;
    white-space   : nowrap;
    overflow      : hidden;
    text-overflow : ellipsis;
}
.sb-brand-tag {
    font-size     : 10px;
    color         : var(--sb-text-dim);
    font-weight   : 500;
    letter-spacing: .6px;
    text-transform: uppercase;
    margin-top    : 1px;
}
body.sb-collapsed .sb-brand-text,
body.sb-collapsed .sidebar-section-label { display: none; }
.sidebar-nav {
    flex           : 1;
    overflow-y     : auto;
    overflow-x     : hidden;
    padding        : 10px 0 24px;
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,.1) transparent;
}
.sidebar-nav::-webkit-scrollbar       { width: 4px; }
.sidebar-nav::-webkit-scrollbar-track { background: transparent; }
.sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 4px; }
.sidebar-section-label {
    font-size     : 10px;
    font-weight   : 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color         : var(--sb-text-dim);
    padding       : 16px 18px 5px;
    white-space   : nowrap;
    overflow      : hidden;
}
.sidebar-item {
    display        : flex;
    align-items    : center;
    justify-content: space-between;
    height         : var(--sb-item-h);
    padding        : 0 14px;
    margin         : 1px 8px;
    border-radius  : var(--sb-radius);
    color          : var(--sb-text);
    font-size      : 13.5px;
    font-weight    : 500;
    text-decoration: none;
    cursor         : pointer;
    white-space    : nowrap;
    overflow       : hidden;
    transition     : background var(--sb-ease), color var(--sb-ease);
    border         : none;
    background     : transparent;
    width          : calc(100% - 16px);
    box-sizing     : border-box;
    user-select    : none;
}
.sidebar-item:hover               { background: var(--sb-hover-bg); color: #fff; text-decoration: none; }
.sidebar-item.active,
.sidebar-item.open                { background: var(--sb-active-bg); color: var(--sb-active-text); }
.item-left {
    display    : flex;
    align-items: center;
    gap        : 11px;
    overflow   : hidden;
    flex       : 1;
    min-width  : 0;
}
.item-text {
    white-space  : nowrap;
    overflow     : hidden;
    text-overflow: ellipsis;
    transition   : opacity var(--sb-ease);
}
body.sb-collapsed .item-text { opacity: 0; width: 0; pointer-events: none; }
.nav-icon {
    font-size  : 16px;
    flex-shrink: 0;
    width      : 20px;
    text-align : center;
    color      : var(--sb-text-dim);
    transition : color var(--sb-ease);
}
.sidebar-item:hover .nav-icon,
.sidebar-item.active .nav-icon,
.sidebar-item.open .nav-icon { color: var(--sb-active-text); }
.arrow {
    font-size  : 10px;
    flex-shrink: 0;
    color      : var(--sb-text-dim);
    transition : transform var(--sb-ease), opacity var(--sb-ease);
}
body.sb-collapsed .arrow          { opacity: 0; }
.sidebar-item.open .arrow         { transform: rotate(90deg); color: var(--sb-active-text); }
.sidebar-submenu {
    max-height   : 0;
    overflow     : hidden;
    transition   : max-height 280ms cubic-bezier(.4,0,.2,1);
    background   : var(--sb-sub-bg);
    margin       : 0 8px;
    border-radius: 0 0 var(--sb-radius) var(--sb-radius);
}
.sidebar-submenu.open              { max-height: 600px; }
body.sb-collapsed .sidebar-submenu { display: none; }
.sidebar-submenu a {
    display        : flex;
    align-items    : center;
    gap            : 10px;
    height         : 38px;
    padding        : 0 14px 0 42px;
    font-size      : 13px;
    color          : var(--sb-text);
    text-decoration: none;
    border-radius  : 7px;
    margin         : 1px 4px;
    transition     : background var(--sb-ease), color var(--sb-ease);
    white-space    : nowrap;
    overflow       : hidden;
}
.sidebar-submenu a i          { font-size: 13px; color: var(--sb-text-dim); flex-shrink: 0; }
.sidebar-submenu a:hover,
.sidebar-submenu a.active     { background: rgba(255,255,255,.06); color: #fff; text-decoration: none; }
.sidebar-submenu a.active     { color: var(--sb-active-text); }
.sidebar-submenu a.active i   { color: var(--sb-active-text); }
.sb-sep { height: 1px; background: var(--sb-border); margin: 8px 16px; }
.sb-logout-form { padding: 6px 8px 8px; }
.sb-logout-btn {
    display      : flex;
    align-items  : center;
    gap          : 11px;
    width        : 100%;
    height       : var(--sb-item-h);
    padding      : 0 14px;
    border-radius: var(--sb-radius);
    background   : rgba(239,68,68,.08);
    border       : none;
    color        : #fca5a5;
    font-size    : 13.5px;
    font-weight  : 500;
    cursor       : pointer;
    text-align   : left;
    transition   : background var(--sb-ease), color var(--sb-ease);
    white-space  : nowrap;
    overflow     : hidden;
}
.sb-logout-btn:hover { background: rgba(239,68,68,.18); color: #fecaca; }
.sb-logout-btn i     { font-size: 16px; flex-shrink: 0; }
.sb-tooltip {
    position      : fixed;
    background    : #1e293b;
    color         : #fff;
    font-size     : 12.5px;
    font-weight   : 600;
    padding       : 5px 12px;
    border-radius : 7px;
    white-space   : nowrap;
    z-index       : 9999;
    pointer-events: none;
    box-shadow    : 0 3px 12px rgba(0,0,0,.25);
    border        : 1px solid rgba(255,255,255,.08);
}
</style>

<aside id="sidebar">

    {{-- Brand --}}
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <div class="sb-logo-icon"><i class="bi bi-shop"></i></div>
        <div class="sb-brand-text">
            <span class="sb-brand-name">Shahzadimart Shop</span>
            <span class="sb-brand-tag">Admin Panel</span>
        </div>
    </a>

    <nav class="sidebar-nav">

        {{-- MAIN --}}
        <div class="sidebar-section-label">Main</div>

        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-item {{ $dashActive ? 'active' : '' }}">
            <span class="item-left">
                <i class="bi bi-speedometer2 nav-icon"></i>
                <span class="item-text">Dashboard</span>
            </span>
        </a>

        {{-- E-COMMERCE --}}
        <div class="sb-sep"></div>
        <div class="sidebar-section-label">E-Commerce</div>

        {{-- Slider --}}
        <div class="sidebar-item {{ $sliderActive ? 'active open' : '' }}" onclick="sbToggle(this)">
            <span class="item-left">
                <i class="bi bi-images nav-icon"></i>
                <span class="item-text">Slider</span>
            </span>
            <i class="bi bi-chevron-right arrow"></i>
        </div>
        <div class="sidebar-submenu {{ $sliderActive ? 'open' : '' }}">
            <a href="{{ route('admin.slider.index') }}"
               class="{{ request()->routeIs('admin.slider.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> All Sliders
            </a>
            <a href="{{ route('admin.slider.create') }}"
               class="{{ request()->routeIs('admin.slider.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add Slider
            </a>
        </div>

        {{-- Orders --}}
      {{-- Orders --}}
<div class="sidebar-item {{ $ordersActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="item-left">
        <i class="bi bi-cart-check nav-icon"></i>
        <span class="item-text">Orders</span>
    </span>
    <i class="bi bi-chevron-right arrow"></i>
</div>
<div class="sidebar-submenu {{ $ordersActive ? 'open' : '' }}">
    <a href="{{ route('admin.order.allorder') }}"
       class="{{ request()->routeIs('admin.order.allorder') && !request()->filled('status') ? 'active' : '' }}">
        <i class="bi bi-list-ul"></i> All Orders
    </a>

    <a href="{{ route('admin.order.allorder', ['status' => 'pending']) }}"
       class="{{ request()->routeIs('admin.order.allorder') && request('status') === 'pending' ? 'active' : '' }}">
        <i class="bi bi-clock"></i> Pending
    </a>

    <a href="{{ route('admin.order.allorder', ['status' => 'processing']) }}"
       class="{{ request()->routeIs('admin.order.allorder') && request('status') === 'processing' ? 'active' : '' }}">
        <i class="bi bi-gear"></i> Processing
    </a>

    <a href="{{ route('admin.order.allorder', ['status' => 'shipped']) }}"
       class="{{ request()->routeIs('admin.order.allorder') && request('status') === 'shipped' ? 'active' : '' }}">
        <i class="bi bi-truck"></i> Shipped
    </a>

    <a href="{{ route('admin.order.allorder', ['status' => 'delivered']) }}"
       class="{{ request()->routeIs('admin.order.allorder') && request('status') === 'delivered' ? 'active' : '' }}">
        <i class="bi bi-check-circle"></i> Delivered
    </a>

    <a href="{{ route('admin.order.allorder', ['status' => 'cancelled']) }}"
       class="{{ request()->routeIs('admin.order.allorder') && request('status') === 'cancelled' ? 'active' : '' }}">
        <i class="bi bi-x-circle"></i> Cancelled
    </a>

    <a href="{{ route('admin.order.create') }}"
       class="{{ request()->routeIs('admin.order.create') ? 'active' : '' }}">
        <i class="bi bi-plus-circle"></i> Create Order
    </a>
</div>

        {{-- Categories --}}
        <div class="sidebar-item {{ $catsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
            <span class="item-left">
                <i class="bi bi-tags nav-icon"></i>
                <span class="item-text">Categories</span>
            </span>
            <i class="bi bi-chevron-right arrow"></i>
        </div>
        <div class="sidebar-submenu {{ $catsActive ? 'open' : '' }}">
            <a href="{{ route('admin.category.index') }}"
               class="{{ request()->routeIs('admin.category.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> All Categories
            </a>
            <a href="{{ route('admin.category.create') }}"
               class="{{ request()->routeIs('admin.category.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add Category
            </a>
            <a href="{{ route('admin.subcategory.index') }}"
               class="{{ request()->routeIs('admin.subcategory.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> All Sub-Categories
            </a>
            <a href="{{ route('admin.subcategory.create') }}"
               class="{{ request()->routeIs('admin.subcategory.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add Sub-Category
            </a>
            <a href="{{ route('admin.childcategory.index') }}"
               class="{{ request()->routeIs('admin.childcategory.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> All Child Categories
            </a>
            <a href="{{ route('admin.childcategory.create') }}"
               class="{{ request()->routeIs('admin.childcategory.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add Child Category
            </a>
        </div>

        {{-- Products --}}
        <div class="sidebar-item {{ $prodsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
            <span class="item-left">
                <i class="bi bi-box-seam nav-icon"></i>
                <span class="item-text">Products</span>
            </span>
            <i class="bi bi-chevron-right arrow"></i>
        </div>
        <div class="sidebar-submenu {{ $prodsActive ? 'open' : '' }}">
            <a href="{{ route('admin.products.index') }}"
               class="{{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> All Products
            </a>
            <a href="{{ route('admin.products.create') }}"
               class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add Product
            </a>
            <a href="{{ route('admin.products.deactivated') }}"
               class="{{ request()->routeIs('admin.products.deactivated') ? 'active' : '' }}">
                <i class="bi bi-x-circle"></i> Deactivated Products
            </a>
            <a href="{{ route('admin.products.catalog') }}"
               class="{{ request()->routeIs('admin.products.catalog') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> Catalog
            </a>
            <a href="{{ route('admin.product.settings.index') }}"
               class="{{ request()->routeIs('admin.product.settings.index') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Product Settings
            </a>
        </div>

        {{-- Affiliate Products --}}
        <div class="sidebar-item {{ $affActive ? 'active open' : '' }}" onclick="sbToggle(this)">
            <span class="item-left">
                <i class="bi bi-diagram-3 nav-icon"></i>
                <span class="item-text">Affiliate Products</span>
            </span>
            <i class="bi bi-chevron-right arrow"></i>
        </div>
        <div class="sidebar-submenu {{ $affActive ? 'open' : '' }}">
            <a href="{{ route('admin.affiliateproduct.index') }}"
               class="{{ request()->routeIs('admin.affiliateproduct.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> All Affiliate Products
            </a>
            <a href="{{ route('admin.affiliateproduct.create') }}"
               class="{{ request()->routeIs('admin.affiliateproduct.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add Affiliate Product
            </a>
            <a href="#"><i class="bi bi-x-circle"></i> Deactivated</a>
        </div>

        {{-- Bulk Upload --}}
        <a href="#" class="sidebar-item">
            <span class="item-left">
                <i class="bi bi-cloud-upload nav-icon"></i>
                <span class="item-text">Bulk Upload</span>
            </span>
        </a>

        {{-- Coupons --}}
        <div class="sidebar-item {{ $couponsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
            <span class="item-left">
                <i class="bi bi-ticket-perforated nav-icon"></i>
                <span class="item-text">Coupons</span>
            </span>
            <i class="bi bi-chevron-right arrow"></i>
        </div>
        <div class="sidebar-submenu {{ $couponsActive ? 'open' : '' }}">
            <a href="{{ route('admin.coupons.index') }}"
               class="{{ request()->routeIs('admin.coupons.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> All Coupons
            </a>
            <a href="{{ route('admin.coupons.create') }}"
               class="{{ request()->routeIs('admin.coupons.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add Coupon
            </a>
        </div>

        {{-- Customers — no admin. prefix because these routes are outside the admin. group --}}
        <div class="sidebar-item {{ $custsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
            <span class="item-left">
                <i class="bi bi-people nav-icon"></i>
                <span class="item-text">Customers</span>
            </span>
            <i class="bi bi-chevron-right arrow"></i>
        </div>
        <div class="sidebar-submenu {{ $custsActive ? 'open' : '' }}">
            <a href="{{ route('customer.index') }}"
               class="{{ request()->routeIs('customer.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> All Customers
            </a>
            <a href="{{ route('customer.create') }}"
               class="{{ request()->routeIs('customer.create') ? 'active' : '' }}">
                <i class="bi bi-person-plus"></i> Add Customer
            </a>
        </div>

        {{-- Product Discussion --}}
        <a href="#" class="sidebar-item">
            <span class="item-left">
                <i class="bi bi-chat-text nav-icon"></i>
                <span class="item-text">Product Discussion</span>
            </span>
        </a>

        {{-- Total Earning --}}
        <a href="#" class="sidebar-item">
            <span class="item-left">
                <i class="bi bi-cash-coin nav-icon"></i>
                <span class="item-text">Total Earning</span>
            </span>
        </a>

        {{-- Manage Country --}}
        <a href="#" class="sidebar-item">
            <span class="item-left">
                <i class="bi bi-globe nav-icon"></i>
                <span class="item-text">Manage Country</span>
            </span>
        </a>

        {{-- USER MANAGEMENT --}}
        <div class="sb-sep"></div>
        <div class="sidebar-section-label">User Management</div>

        {{-- Users --}}
        <div class="sidebar-item {{ $usersActive ? 'active open' : '' }}" onclick="sbToggle(this)">
            <span class="item-left">
                <i class="bi bi-person-badge nav-icon"></i>
                <span class="item-text">Users</span>
            </span>
            <i class="bi bi-chevron-right arrow"></i>
        </div>
        <div class="sidebar-submenu {{ $usersActive ? 'open' : '' }}">
            <a href="{{ route('admin.users.index') }}"
               class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> All Users
            </a>
            <a href="{{ route('admin.users.create') }}"
               class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                <i class="bi bi-person-plus"></i> Add User
            </a>
        </div>

        {{-- Vendors --}}
        <div class="sidebar-item {{ $vendorsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
            <span class="item-left">
                <i class="bi bi-shop nav-icon"></i>
                <span class="item-text">Vendors</span>
            </span>
            <i class="bi bi-chevron-right arrow"></i>
        </div>
        <div class="sidebar-submenu {{ $vendorsActive ? 'open' : '' }}">
            <a href="#"><i class="bi bi-list-ul"></i> All Vendors</a>
            <a href="#"><i class="bi bi-plus-circle"></i> Add Vendor</a>
        </div>

        {{-- Vendor Subscriptions --}}
        <a href="#" class="sidebar-item">
            <span class="item-left">
                <i class="bi bi-star nav-icon"></i>
                <span class="item-text">Vendor Subscriptions</span>
            </span>
        </a>

        {{-- Vendor Verifications --}}
        <a href="#" class="sidebar-item">
            <span class="item-left">
                <i class="bi bi-shield-check nav-icon"></i>
                <span class="item-text">Vendor Verifications</span>
            </span>
        </a>

        {{-- Subscription Plans --}}
        <a href="#" class="sidebar-item">
            <span class="item-left">
                <i class="bi bi-credit-card nav-icon"></i>
                <span class="item-text">Subscription Plans</span>
            </span>
        </a>

        {{-- Riders --}}
        <a href="#" class="sidebar-item">
            <span class="item-left">
                <i class="bi bi-bicycle nav-icon"></i>
                <span class="item-text">Riders</span>
            </span>
        </a>

        {{-- Customer Deposits --}}
        <a href="#" class="sidebar-item">
            <span class="item-left">
                <i class="bi bi-wallet2 nav-icon"></i>
                <span class="item-text">Customer Deposits</span>
            </span>
        </a>

        {{-- Subscribers --}}
        <a href="#" class="sidebar-item">
            <span class="item-left">
                <i class="bi bi-people-fill nav-icon"></i>
                <span class="item-text">Subscribers</span>
            </span>
        </a>

        {{-- Messages --}}
        <a href="#" class="sidebar-item">
            <span class="item-left">
                <i class="bi bi-chat-dots nav-icon"></i>
                <span class="item-text">Messages</span>
            </span>
        </a>

        {{-- ACCESS CONTROL --}}
        <div class="sb-sep"></div>
        <div class="sidebar-section-label">Access Control</div>

        {{-- Roles --}}
        <div class="sidebar-item {{ $rolesActive ? 'active open' : '' }}" onclick="sbToggle(this)">
            <span class="item-left">
                <i class="bi bi-shield-lock nav-icon"></i>
                <span class="item-text">Manage Roles</span>
            </span>
            <i class="bi bi-chevron-right arrow"></i>
        </div>
        <div class="sidebar-submenu {{ $rolesActive ? 'open' : '' }}">
            <a href="{{ route('admin.roles.index') }}"
               class="{{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> All Roles
            </a>
            <a href="{{ route('admin.roles.create') }}"
               class="{{ request()->routeIs('admin.roles.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Create Role
            </a>
        </div>

        {{-- Permissions --}}
        <div class="sidebar-item {{ $permsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
            <span class="item-left">
                <i class="bi bi-key nav-icon"></i>
                <span class="item-text">Permissions</span>
            </span>
            <i class="bi bi-chevron-right arrow"></i>
        </div>
        <div class="sidebar-submenu {{ $permsActive ? 'open' : '' }}">
            <a href="{{ route('admin.permissions.index') }}"
               class="{{ request()->routeIs('admin.permissions.index') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> All Permissions
            </a>
            <a href="{{ route('admin.permissions.create') }}"
               class="{{ request()->routeIs('admin.permissions.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Create Permission
            </a>
        </div>

        {{-- Manage Staffs --}}
        <a href="#" class="sidebar-item">
            <span class="item-left">
                <i class="bi bi-person-workspace nav-icon"></i>
                <span class="item-text">Manage Staffs</span>
            </span>
        </a>

        {{-- SETTINGS --}}
        <div class="sb-sep"></div>
        <div class="sidebar-section-label">Settings</div>

        {{-- Blog --}}
        <div class="sidebar-item {{ $blogsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
            <span class="item-left">
                <i class="bi bi-pencil-square nav-icon"></i>
                <span class="item-text">Blog</span>
            </span>
            <i class="bi bi-chevron-right arrow"></i>
        </div>
        <div class="sidebar-submenu {{ $blogsActive ? 'open' : '' }}">
            <a href="#"><i class="bi bi-list-ul"></i> All Posts</a>
            <a href="#"><i class="bi bi-plus-circle"></i> Add Post</a>
        </div>

        {{-- General Settings --}}
        <div class="sidebar-item {{ $settingsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
            <span class="item-left">
                <i class="bi bi-gear nav-icon"></i>
                <span class="item-text">General Settings</span>
            </span>
            <i class="bi bi-chevron-right arrow"></i>
        </div>
        <div class="sidebar-submenu {{ $settingsActive ? 'open' : '' }}">
            <a href="{{ route('admin.Generalsettings.index') }}"
               class="{{ request()->routeIs('admin.Generalsettings.*') ? 'active' : '' }}">
                <i class="bi bi-image"></i> Logo Settings
            </a>

             <a href="{{ route('admin.contact.index') }}"
               class="{{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                <i class="bi bi-image"></i> Contact Settings
            </a>
              <a href="{{ route('admin.pixels.index') }}"
               class="{{ request()->routeIs('admin.pixels.*') ? 'active' : '' }}">
                <i class="bi bi-image"></i> pixels Settings
            </a>
            </a>
              <a href="{{ route('admin.googletagmanager.index') }}"
               class="{{ request()->routeIs('admin.googletagmanager.*') ? 'active' : '' }}">
                <i class="bi bi-image"></i> Google Tag Manager
            </a>




            <a href="{{ route('admin.websitefavicon.index') }}"
               class="{{ request()->routeIs('admin.websitefavicon.*') ? 'active' : '' }}">
                <i class="bi bi-layout-text-sidebar"></i> Website Favicon
            </a>
            <a href="#"><i class="bi bi-envelope"></i> Email Settings</a>
            <a href="{{route('admin.shipping.index')}}"><i class="bi bi-cash-stack"></i>Shipping Charge</a>
            <a href="#"><i class="bi bi-share"></i> Social Settings</a>
            <a href="#"><i class="bi bi-translate"></i> Language Settings</a>
            <a href="#"><i class="bi bi-fonts"></i> Font Options</a>
            <a href="#"><i class="bi bi-graph-up-arrow"></i> SEO Tools</a>
        </div>

    </nav>

    {{-- Logout --}}
    <div class="sb-sep" style="margin:0;"></div>
    <form method="POST" action="{{ route('admin.logout') }}" class="sb-logout-form">
        @csrf
        <button type="submit" class="sb-logout-btn">
            <i class="bi bi-box-arrow-right"></i>
            <span class="item-text">Logout</span>
        </button>
    </form>

</aside>

<div class="sb-overlay" onclick="sbClose()"></div>

<script>
(function () {
    'use strict';

    window.toggleSidebar = function () {
        if (window.innerWidth < 992) {
            document.body.classList.toggle('sb-open');
        } else {
            document.body.classList.toggle('sb-collapsed');
        }
    };

    window.sbClose = function () {
        document.body.classList.remove('sb-open');
    };

    window.sbToggle = function (trigger) {
        var sub = trigger.nextElementSibling;
        if (!sub || !sub.classList.contains('sidebar-submenu')) return;
        var isOpen = sub.classList.contains('open');
        document.querySelectorAll('.sidebar-submenu.open').forEach(function (s) {
            s.classList.remove('open');
            var prev = s.previousElementSibling;
            if (prev) prev.classList.remove('open');
        });
        if (!isOpen) {
            sub.classList.add('open');
            trigger.classList.add('open');
        }
    };

    document.querySelectorAll('.sidebar-submenu').forEach(function (sub) {
        if (sub.querySelector('a.active')) {
            sub.classList.add('open');
            var prev = sub.previousElementSibling;
            if (prev) prev.classList.add('open');
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') window.sbClose();
    });

    var startX = 0;
    var sb = document.getElementById('sidebar');
    if (sb) {
        sb.addEventListener('touchstart', function (e) {
            startX = e.touches[0].clientX;
        }, { passive: true });
        sb.addEventListener('touchend', function (e) {
            if (startX - e.changedTouches[0].clientX > 60) window.sbClose();
        }, { passive: true });
    }

    document.querySelectorAll('#sidebar .sidebar-item').forEach(function (el) {
        var textEl = el.querySelector('.item-text');
        if (!textEl) return;
        var label = textEl.textContent.trim();
        el.addEventListener('mouseenter', function () {
            if (!document.body.classList.contains('sb-collapsed')) return;
            var r   = el.getBoundingClientRect();
            var tip = document.createElement('div');
            tip.className   = 'sb-tooltip';
            tip.textContent = label;
            tip.style.left  = (r.right + 10) + 'px';
            tip.style.top   = (r.top + r.height / 2 - 16) + 'px';
            document.body.appendChild(tip);
            el._sbTip = tip;
        });
        el.addEventListener('mouseleave', function () {
            if (el._sbTip) { el._sbTip.remove(); el._sbTip = null; }
        });
    });

})();
</script>
