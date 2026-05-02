{{-- ============================================================
     EMPLOYEE (EMPLEE) SIDEBAR
     resources/views/emplee/pages/siderbar.blade.php
     100% Permission-based — Linking Admin Panel Features
============================================================ --}}

@php
    $u = auth()->user();
    $dashActive   = request()->routeIs('emplee.dashboard');
    $ordersActive = request()->routeIs('emplee.orders.*');
    $prodsActive  = request()->routeIs('admin.products.*');
    $catsActive   = request()->routeIs('emplee.category.*') || request()->routeIs('admin.subcategory.*') || request()->routeIs('admin.childcategory.*');
    $reviewsActive= request()->routeIs('emplee.reviews.*');
    $usersActive  = request()->routeIs('customer.*');
    $vendorsActive= request()->routeIs('admin.seller.*');
    $blogActive   = request()->routeIs('emplee.blog-categories.*') || request()->routeIs('emplee.blog-posts.*');
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
<a href="{{ route('emplee.profile.index') }}" class="sb-item {{ request()->routeIs('emplee.profile.*') ? 'active' : '' }}">
    <span class="sb-left"><i class="fas fa-user-circle sb-ico"></i> My Profile</span>
</a>
@endif

<div class="sb-sep"></div>

{{-- Communication Section --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-chat', 'manage-chat']))
<div class="sb-section">Communication</div>
<a href="{{ route('emplee.chat.index') }}" class="sb-item {{ request()->routeIs('emplee.chat.*') ? 'active' : '' }}">
    <span class="sb-left">
        <i class="fas fa-comments sb-ico"></i> Live Chat
        <span class="badge bg-danger ms-2" id="sbUnreadBadge" style="display:none; font-size:10px;">0</span>
    </span>
</a>
<div class="sb-sep"></div>
@endif

<div class="sb-section">Inventory & Sales</div>

{{-- Orders Section --}}
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-orders', 'edit-orders', 'delete-orders']))
<div class="sb-item {{ $ordersActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="fas fa-shopping-bag sb-ico"></i> Orders</span>
    <i class="fas fa-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $ordersActive ? 'open' : '' }}">
    <a href="{{ route('emplee.orders.index') }}" class="{{ request()->routeIs('emplee.orders.index') && !request()->filled('status') ? 'active' : '' }}">
        All Orders
    </a>
    <a href="{{ route('emplee.orders.index', ['status' => 'pending']) }}" class="{{ request('status') === 'pending' ? 'active' : '' }}">
        Pending
    </a>
    <a href="{{ route('emplee.orders.index', ['status' => 'processing']) }}" class="{{ request('status') === 'processing' ? 'active' : '' }}">
        Processing
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
    <a href="{{ route('emplee.category.index') }}" class="{{ request()->routeIs('emplee.category.index') ? 'active' : '' }}">
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

{{-- Blog Management --}}
@if($u->isSuperAdmin() || $u->hasPermission('view-pages'))
<div class="sb-item {{ $blogActive ? 'active open' : '' }}" onclick="sbToggle(this)">
    <span class="sb-left"><i class="fas fa-file-alt sb-ico"></i> Blog Management</span>
    <i class="fas fa-chevron-right sb-arr"></i>
</div>
<div class="sb-sub {{ $blogActive ? 'open' : '' }}">
    <a href="{{ route('emplee.blog-posts.index') }}" class="{{ request()->routeIs('emplee.blog-posts.*') ? 'active' : '' }}">
        All Posts
    </a>
    <a href="{{ route('emplee.blog-categories.index') }}" class="{{ request()->routeIs('emplee.blog-categories.*') ? 'active' : '' }}">
        Blog Categories
    </a>
</div>
@endif

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


{{-- Account Settings --}}
<div class="sb-item {{ request()->routeIs('emplee.profile.*') ? 'active' : '' }}">
    <a href="{{ route('emplee.profile.index') }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; width: 100%;">
        <span class="sb-left"><i class="fas fa-user-gear sb-ico"></i> Profile & Password</span>
    </a>
</div>

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

// Sidebar Unread Badge Polling
@if($u->isSuperAdmin() || $u->hasAnyPermission(['view-chat', 'manage-chat']))
function sbRefreshUnread() {
    fetch('{{ route("emplee.chat.unread") }}')
        .then(r => r.json())
        .then(d => {
            const badge = document.getElementById('sbUnreadBadge');
            if (badge) {
                if (d.count > 0) {
                    badge.textContent = d.count > 99 ? '99+' : d.count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        }).catch(() => {});
}
sbRefreshUnread();
setInterval(sbRefreshUnread, 15000);
@endif
</script>
