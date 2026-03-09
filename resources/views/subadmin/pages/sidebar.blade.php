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
    <li class="active"><a href="#"><i class="fas fa-th-large"></i> Dashboard</a></li>
  </ul>

  <div class="sb-section">E-Commerce</div>
  <ul class="sb-menu">
    <li><a href="#"><i class="fas fa-shopping-bag"></i> Orders <span class="nb">18</span></a></li>
    <li><a href="#"><i class="fas fa-box-open"></i> Products <i class="fas fa-chevron-right arr"></i></a></li>
    <li><a href="#"><i class="fas fa-th"></i> Categories <i class="fas fa-chevron-right arr"></i></a></li>
    <li><a href="#"><i class="fas fa-tags"></i> Coupons</a></li>
    <li><a href="#"><i class="fas fa-star"></i> Reviews <span class="nb">6</span></a></li>
    <li><a href="#"><i class="fas fa-comments"></i> Discussions</a></li>
  </ul>

  <div class="sb-section">Users</div>
  <ul class="sb-menu">
    <li><a href="#"><i class="fas fa-users"></i> Customers <i class="fas fa-chevron-right arr"></i></a></li>
    <li><a href="#"><i class="fas fa-store"></i> Vendors <i class="fas fa-chevron-right arr"></i></a></li>
    <li><a href="#"><i class="fas fa-user-check"></i> Verifications</a></li>
  </ul>

  <div class="sb-section">Reports</div>
  <ul class="sb-menu">
    <li><a href="#"><i class="fas fa-chart-bar"></i> Sales Report</a></li>
    <li><a href="#"><i class="fas fa-file-export"></i> Export Data</a></li>
  </ul>

  <div class="sb-bottom">
    <ul class="sb-menu">
      <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
      <li><a href="{{ route('subadmin.logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>

      <form id="logout-form" action="{{ route('subadmin.logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </ul>
  </div>
</div>
