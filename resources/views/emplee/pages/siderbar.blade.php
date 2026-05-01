{{-- ============================================================
     EMPLOYEE (EMPLEE) SIDEBAR
     resources/views/emplee/pages/siderbar.blade.php
     100% Permission-based — Linking Admin Panel Features
============================================================ --}}

@php
    $u = auth()->user();
    $dashActive   = request()->routeIs('emplee.dashboard');
    $ordersActive = request()->routeIs('admin.order.*');
    $prodsActive  = request()->routeIs('admin.products.*');
    $catsActive   = request()->routeIs('admin.category.*') || request()->routeIs('admin.subcategory.*') || request()->routeIs('admin.childcategory.*');
    $reviewsActive= request()->routeIs('admin.reviews.*');
    $usersActive  = request()->routeIs('customer.*');
    $vendorsActive= request()->routeIs('admin.seller.*');
@endphp

<aside id="sidebar">

<a href="{{ route('emplee.dashboard') }}" class="sb-brand">
    <div class="sb-icon"><i class="fas fa-briefcase"></i></div>
    <div>
        <span class="sb-brand-name">Shahzadimart</span>
        <span class="sb-brand-tag">Employee Panel</span>
    </div>
</a>

<nav class="sb-nav">

<div class="sb-section">Core</div>

@if($u->canAccessAdmin() || $u->hasPermission('view-dashboard'))
<a href="{{ route('emplee.dashboard') }}" class="sb-item {{ $dashActive ? 'active' : '' }}">
    <span class="sb-left"><i class="fas fa-chart-line sb-ico"></i> Dashboard</span>
</a>
@endif

<div class="sb-sep"></div>
<div class="sb-section">Inventory & Sales</div>

{{-- Orders Section --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-orders', 'edit-orders', 'delete-orders']))
<div class="sb-item {{ $ordersActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="fas fa-shopping-bag sb-ico"></i> Orders</span>
    <i class="fas fa-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $ordersActive ? 'open' : '' }}">
    <a href="{{ route('admin.order.allorder') }}" class="{{ request()->routeIs('admin.order.allorder') && !request()->filled('status') ? 'active' : '' }}">
        All Orders
    </a>
    <a href="{{ route('admin.order.allorder', ['status' => 'pending']) }}" class="{{ request('status') === 'pending' ? 'active' : '' }}">
        Pending
    </a>
    <a href="{{ route('admin.order.allorder', ['status' => 'processing']) }}" class="{{ request('status') === 'processing' ? 'active' : '' }}">
        Processing
    </a>
    <a href="{{ route('admin.order.allorder', ['status' => 'completed']) }}" class="{{ request('status') === 'completed' ? 'active' : '' }}">
        Completed
    </a>
    <a href="{{ route('admin.order.allorder', ['status' => 'cancelled']) }}" class="{{ request('status') === 'cancelled' ? 'active' : '' }}">
        Cancelled
    </a>
</div>
@endif

{{-- Products Section --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-products', 'create-products', 'edit-products', 'delete-products']))
<div class="sb-item {{ $prodsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="fas fa-box sb-ico"></i> Products</span>
    <i class="fas fa-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $prodsActive ? 'open' : '' }}">
    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
        Inventory List
    </a>
    @if($u->isSuperAdmin() || $u->hasPermission('create-products'))
    <a href="{{ route('admin.products.create') }}" class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
        Add New Product
    </a>
    @endif
    <a href="{{ route('admin.products.deactivated') }}" class="{{ request()->routeIs('admin.products.deactivated') ? 'active' : '' }}">
        Deactivated
    </a>
</div>
@endif

{{-- Category Management --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-categories', 'create-categories', 'edit-categories', 'delete-categories']))
<div class="sb-item {{ $catsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="fas fa-layer-group sb-ico"></i> Catalog</span>
    <i class="fas fa-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $catsActive ? 'open' : '' }}">
    <a href="{{ route('admin.category.index') }}" class="{{ request()->routeIs('admin.category.index') ? 'active' : '' }}">
        Categories
    </a>
    <a href="{{ route('admin.subcategory.index') }}" class="{{ request()->routeIs('admin.subcategory.index') ? 'active' : '' }}">
        Sub-Categories
    </a>
    <a href="{{ route('admin.childcategory.index') }}" class="{{ request()->routeIs('admin.childcategory.index') ? 'active' : '' }}">
        Child-Categories
    </a>
</div>
@endif

<div class="sb-sep"></div>
<div class="sb-section">People</div>

{{-- Customer Management --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-users'))
<div class="sb-item {{ $usersActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="fas fa-user-group sb-ico"></i> Customers</span>
    <i class="fas fa-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $usersActive ? 'open' : '' }}">
    <a href="{{ route('customer.index') }}" class="{{ request()->routeIs('customer.index') ? 'active' : '' }}">
        All Customers
    </a>
    <a href="{{ route('customer.create') }}" class="{{ request()->routeIs('customer.create') ? 'active' : '' }}">
        Add Customer
    </a>
</div>
@endif

{{-- Vendor Management --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-sellers'))
<div class="sb-item {{ $vendorsActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="fas fa-store sb-ico"></i> Vendors</span>
    <i class="fas fa-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $vendorsActive ? 'open' : '' }}">
    <a href="{{ route('admin.seller.register.list') }}" class="{{ request()->routeIs('admin.seller.register.list') ? 'active' : '' }}">
        Merchant List
    </a>
</div>
@endif

</nav>

<div class="sb-logout-wrap">
    <form method="POST" action="{{ route('emplee.logout') }}">
        @csrf
        <button type="submit" class="sb-logout">
            <i class="fas fa-sign-out-alt"></i> Sign Out
        </button>
    </form>
</div>

</aside>

<script>
window.sbToggle = function(t) {
    var s = t.nextElementSibling;
    if (!s || !s.classList.contains('sb-sub')) return;
    var o = s.classList.contains('open');
    
    // Close others
    document.querySelectorAll('.sb-sub.open').forEach(function(x) {
        if (x !== s) {
            x.classList.remove('open');
            if (x.previousElementSibling) x.previousElementSibling.classList.remove('open');
        }
    });
    
    if (!o) {
        s.classList.add('open');
        t.classList.add('open');
    } else {
        s.classList.remove('open');
        t.classList.remove('open');
    }
};

// Auto-open active menu
document.querySelectorAll('.sb-sub').forEach(function(s) {
    if (s.querySelector('a.active')) {
        s.classList.add('open');
        if (s.previousElementSibling) s.previousElementSibling.classList.add('open');
    }
});
</script>
