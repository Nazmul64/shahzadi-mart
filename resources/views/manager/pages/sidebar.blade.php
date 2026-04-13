<div id="sidebar">
  <div class="sidebar-brand">
    <div class="brand-logo">G</div>
    <div class="brand-info">
      <strong>Shahzadimart Shop</strong>
      <span>Manager Panel</span>
    </div>
  </div>

  <div class="nav-section">Main</div>
  <ul class="nav-list">
    <li class="active"><a href="#"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
  </ul>

  <div class="nav-section">Management</div>
  <ul class="nav-list">
    <li><a href="#"><i class="fas fa-shopping-bag"></i> Orders <span class="badge-nav">12</span></a></li>
    <li><a href="#"><i class="fas fa-box-open"></i> Products <i class="fa-solid fa-chevron-right"></i> arrow"></i></a></li>
    <li><a href="#"><i class="fas fa-users"></i> Customers <i class="fa-solid fa-chevron-right"></i> arrow"></i></a></li>
    <li><a href="#"><i class="fas fa-store"></i> Vendors <i class="fa-solid fa-chevron-right"></i> arrow"></i></a></li>
    <li><a href="#"><i class="fas fa-tags"></i> Coupons</a></li>
    <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
    <li><a href="#"><i class="fas fa-star"></i> Reviews <span class="badge-nav">5</span></a></li>
  </ul>

  <div class="nav-section">Settings</div>
  <ul class="nav-list">
    <li><a href="#"><i class="fas fa-user-cog"></i> My Profile</a></li>
    <li><a href="#"><i class="fas fa-bell"></i> Notifications</a></li>
  </ul>

  <div class="sidebar-footer">
    <ul class="nav-list">
      <li><a href="{{ route('manager.logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      <form id="logout-form" action="{{ route('manager.logout') }}" method="POST" style="display: none;">
        @csrf
        </form>
    </ul>
  </div>
</div>
