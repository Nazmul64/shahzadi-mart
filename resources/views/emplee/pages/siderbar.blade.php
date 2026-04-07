<!-- SIDEBAR -->
<div id="sidebar">
  <div class="brand">
    <div class="brand-icon">G</div>
    <div class="brand-text">
      <strong>Genius Shop</strong>
      <span>Admin Panel</span>
    </div>
  </div>

  <div class="sidebar-section">Main</div>
  <ul class="sidebar-menu">
    <li class="active"><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
  </ul>

  <div class="sidebar-section">E-Commerce</div>
  <ul class="sidebar-menu">
    <li><a href="#"><i class="fas fa-shopping-cart"></i> Orders <i class="fas fa-chevron-right"></i> arrow"></i></a></li>
    <li><a href="#"><i class="fas fa-th-large"></i> Categories <i class="fas fa-chevron-right"></i> arrow"></i></a></li>
    <li><a href="#"><i class="fas fa-box"></i> Products <i class="fas fa-chevron-right"></i> arrow"></i></a></li>
    <li><a href="#"><i class="fas fa-link"></i> Affiliate Products</a></li>
    <li><a href="#"><i class="fas fa-upload"></i> Bulk Upload</a></li>
    <li><a href="#"><i class="fas fa-tag"></i> Coupons</a></li>
    <li><a href="#"><i class="fas fa-comments"></i> Product Discussion</a></li>
    <li><a href="#"><i class="fas fa-dollar-sign"></i> Total Earning</a></li>
    <li><a href="#"><i class="fas fa-globe"></i> Manage Country</a></li>
  </ul>

  <div class="sidebar-section">User Management</div>
  <ul class="sidebar-menu">
    <li><a href="#"><i class="fas fa-users"></i> Users <i class="fas fa-chevron-right"></i> arrow"></i></a></li>
    <li><a href="#"><i class="fas fa-store"></i> Vendors <i class="fas fa-chevron-right"></i> arrow"></i></a></li>
    <li><a href="#"><i class="fas fa-calendar-check"></i> Vendor Subscriptions</a></li>
    <li><a href="#"><i class="fas fa-user-check"></i> Vendor Verifications</a></li>
    <li><a href="#"><i class="fas fa-credit-card"></i> Subscription Plans</a></li>
  </ul>

  <div class="sidebar-bottom">
    <ul class="sidebar-menu">
      <li><a href="{{ route('emplee.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a></li>

        <form id="logout-form" action="{{ route('emplee.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </ul>
  </div>
</div>
