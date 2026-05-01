<div id="sidebar">
  <div class="sb-brand">
    <div class="sb-icon">G</div>
    <div>
      <strong>Shahzadimart Shop</strong>
      <span>Sub Admin</span>
    </div>
  </div>

  <div class="sb-section">Main</div>
  <ul class="sb-menu">
    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view-dashboard'))
    <li class="{{ request()->routeIs('subadmin.dashboard') ? 'active' : '' }}">
      <a href="{{ route('subadmin.dashboard') }}">
        <i class="fas fa-th-large"></i> Dashboard
      </a>
    </li>
    @endif
  </ul>

  {{-- E-Commerce Section --}}
  @php
    $showEcommerce = auth()->user()->isSuperAdmin()
      || auth()->user()->hasAnyPermission([
          'view-orders','edit-orders',
          'view-products','create-products','edit-products','delete-products',
          'view-categories','create-categories','edit-categories','delete-categories',
      ]);
  @endphp
  @if($showEcommerce)
  <div class="sb-section">E-Commerce</div>
  <ul class="sb-menu">

    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view-orders'))
    <li class="{{ request()->routeIs('subadmin.orders*') ? 'active' : '' }}">
      <a href="#">
        <i class="fas fa-shopping-bag"></i> Orders
        <span class="nb">18</span>
      </a>
    </li>
    @endif

    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['view-products','create-products','edit-products','delete-products']))
    <li class="{{ request()->routeIs('subadmin.products*') ? 'active' : '' }}">
      <a href="#">
        <i class="fas fa-box-open"></i> Products
        <i class="fa-solid fa-chevron-right arr"></i>
      </a>
    </li>
    @endif

    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['view-categories','create-categories','edit-categories']))
    <li class="{{ request()->routeIs('subadmin.categories*') ? 'active' : '' }}">
      <a href="#">
        <i class="fas fa-th"></i> Categories
        <i class="fa-solid fa-chevron-right arr"></i>
      </a>
    </li>
    @endif

    <li class="{{ request()->routeIs('subadmin.coupons*') ? 'active' : '' }}">
      <a href="#"><i class="fas fa-tags"></i> Coupons</a>
    </li>

    <li class="{{ request()->routeIs('subadmin.reviews*') ? 'active' : '' }}">
      <a href="#">
        <i class="fas fa-star"></i> Reviews
        <span class="nb">6</span>
      </a>
    </li>

    <li class="{{ request()->routeIs('subadmin.discussions*') ? 'active' : '' }}">
      <a href="#"><i class="fas fa-comments"></i> Discussions</a>
    </li>

  </ul>
  @endif

  {{-- Users Section --}}
  @php
    $showUsers = auth()->user()->isSuperAdmin()
      || auth()->user()->hasAnyPermission(['view-users','view-sellers','approve-sellers']);
  @endphp
  @if($showUsers)
  <div class="sb-section">Users</div>
  <ul class="sb-menu">

    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view-users'))
    <li class="{{ request()->routeIs('subadmin.customers*') ? 'active' : '' }}">
      <a href="#">
        <i class="fas fa-users"></i> Customers
        <i class="fa-solid fa-chevron-right arr"></i>
      </a>
    </li>
    @endif

    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view-sellers'))
    <li class="{{ request()->routeIs('subadmin.vendors*') ? 'active' : '' }}">
      <a href="#">
        <i class="fas fa-store"></i> Vendors
        <i class="fa-solid fa-chevron-right arr"></i>
      </a>
    </li>
    @endif

    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('approve-sellers'))
    <li class="{{ request()->routeIs('subadmin.verifications*') ? 'active' : '' }}">
      <a href="#"><i class="fas fa-user-check"></i> Verifications</a>
    </li>
    @endif

  </ul>
  @endif

  {{-- Reports Section --}}
  @if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['view-reports','export-reports']))
  <div class="sb-section">Reports</div>
  <ul class="sb-menu">

    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view-reports'))
    <li class="{{ request()->routeIs('subadmin.reports*') ? 'active' : '' }}">
      <a href="#"><i class="fas fa-chart-bar"></i> Sales Report</a>
    </li>
    @endif

    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('export-reports'))
    <li class="{{ request()->routeIs('subadmin.export*') ? 'active' : '' }}">
      <a href="#"><i class="fas fa-file-export"></i> Export Data</a>
    </li>
    @endif

  </ul>
  @endif

  <div class="sb-bottom">
    <ul class="sb-menu">
      <li class="{{ request()->routeIs('subadmin.settings*') ? 'active' : '' }}">
        <a href="#"><i class="fas fa-cog"></i> Settings</a>
      </li>
      <li>
        <a href="{{ route('subadmin.logout') }}"
           onclick="event.preventDefault(); document.getElementById('subadmin-logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
    <form id="subadmin-logout-form" action="{{ route('subadmin.logout') }}" method="POST" style="display:none;">
      @csrf
    </form>
  </div>
</div>
