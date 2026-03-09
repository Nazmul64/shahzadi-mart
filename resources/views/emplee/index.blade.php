@extends('emplee.master')
@section('content')
 <!-- TOPBAR -->
  <div id="topbar">
    <div class="search-wrap">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Search..."/>
    </div>
    <div class="topbar-icons">
      <button class="icon-btn"><i class="fas fa-globe"></i></button>
      <button class="icon-btn">
        <i class="fas fa-envelope"></i>
        <span class="badge-dot">3</span>
      </button>
      <button class="icon-btn">
        <i class="fas fa-shopping-cart"></i>
        <span class="badge-dot">2</span>
      </button>
      <button class="icon-btn">
        <i class="fas fa-user-plus"></i>
        <span class="badge-dot">1</span>
      </button>
      <button class="icon-btn">
        <i class="fas fa-bell"></i>
        <span class="badge-dot">4</span>
      </button>
      <div class="user-pill ms-2">
        <img src="https://ui-avatars.com/api/?name=Super+Admin&background=4e9ef5&color=fff" alt="Admin"/>
        <span class="uname">Super Admin</span>
        <i class="fas fa-chevron-down uarrow"></i>
      </div>
    </div>
  </div>

  <!-- CONTENT -->
  <div id="content">
    <!-- Page header -->
    <div class="page-header">
      <h4>Dashboard</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>

    <!-- Row 1: Stat Cards -->
    <div class="row g-3 mb-3">
      <div class="col-12 col-md-4">
        <div class="stat-card card-orange">
          <div>
            <div class="card-label">Orders Pending!</div>
            <div class="card-number">130</div>
          </div>
          <div><a href="#" class="card-btn">View All</a></div>
          <i class="fas fa-dollar-sign bg-icon"></i>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="stat-card card-blue">
          <div>
            <div class="card-label">Orders Processing!</div>
            <div class="card-number">0</div>
          </div>
          <div><a href="#" class="card-btn">View All</a></div>
          <i class="fas fa-truck bg-icon"></i>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="stat-card card-teal">
          <div>
            <div class="card-label">Orders Completed!</div>
            <div class="card-number">8</div>
          </div>
          <div><a href="#" class="card-btn">View All</a></div>
          <i class="fas fa-check-circle bg-icon"></i>
        </div>
      </div>
    </div>

    <!-- Row 2: Stat Cards -->
    <div class="row g-3 mb-3">
      <div class="col-12 col-md-4">
        <div class="stat-card card-purple">
          <div>
            <div class="card-label">Total Products!</div>
            <div class="card-number">24</div>
          </div>
          <div><a href="#" class="card-btn">View All</a></div>
          <i class="fas fa-shopping-cart bg-icon"></i>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="stat-card card-red">
          <div>
            <div class="card-label">Total Customers!</div>
            <div class="card-number">61</div>
          </div>
          <div><a href="#" class="card-btn">View All</a></div>
          <i class="fas fa-users bg-icon"></i>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="stat-card card-green">
          <div>
            <div class="card-label">Total Posts!</div>
            <div class="card-number">15</div>
          </div>
          <div><a href="#" class="card-btn">View All</a></div>
          <i class="fas fa-th-list bg-icon"></i>
        </div>
      </div>
    </div>

    <!-- Row 3: Donut Circles -->
    <div class="row g-3 mb-3">
      <div class="col-6 col-md-3">
        <div class="circle-card">
          <div class="circle-wrap">
            <svg viewBox="0 0 100 100">
              <circle class="circle-bg" cx="50" cy="50" r="42"/>
              <circle class="circle-fg" cx="50" cy="50" r="42" stroke="#f7931e"
                stroke-dasharray="0 264" data-val="0" data-max="130"/>
            </svg>
            <div class="circle-num">0</div>
          </div>
          <div class="circle-label">New Customers</div>
          <div class="circle-sub">Last 30 Days</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="circle-card">
          <div class="circle-wrap">
            <svg viewBox="0 0 100 100">
              <circle class="circle-bg" cx="50" cy="50" r="42"/>
              <circle class="circle-fg" cx="50" cy="50" r="42" stroke="#00bcd4"
                stroke-dasharray="264 264" data-val="61" data-max="61"/>
            </svg>
            <div class="circle-num">61</div>
          </div>
          <div class="circle-label">Total Customers</div>
          <div class="circle-sub">All Time</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="circle-card">
          <div class="circle-wrap">
            <svg viewBox="0 0 100 100">
              <circle class="circle-bg" cx="50" cy="50" r="42"/>
              <circle class="circle-fg" cx="50" cy="50" r="42" stroke="#9c27b0"
                stroke-dasharray="0 264" data-val="0" data-max="100"/>
            </svg>
            <div class="circle-num">0</div>
          </div>
          <div class="circle-label">Total Sales</div>
          <div class="circle-sub">Last 30 days</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="circle-card">
          <div class="circle-wrap">
            <svg viewBox="0 0 100 100">
              <circle class="circle-bg" cx="50" cy="50" r="42"/>
              <circle class="circle-fg" cx="50" cy="50" r="42" stroke="#4caf50"
                stroke-dasharray="35 264" data-val="8" data-max="61"/>
            </svg>
            <div class="circle-num">8</div>
          </div>
          <div class="circle-label">Total Sales</div>
          <div class="circle-sub">All Time</div>
        </div>
      </div>
    </div>

    <!-- Row 4: Tables -->
    <div class="row g-3">
      <!-- Recent Orders -->
      <div class="col-12 col-lg-7">
        <div class="table-card">
          <h6>Recent Order(s)</h6>
          <div class="table-responsive">
            <table class="table mb-0">
              <thead>
                <tr>
                  <th>Order Number</th>
                  <th>Order Date</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>z9qz1772084754</td>
                  <td>2026-02-26</td>
                  <td><a href="#" class="btn-detail"><i class="fas fa-eye"></i> Details</a></td>
                </tr>
                <tr>
                  <td>nK8L1768816175</td>
                  <td>2026-01-19</td>
                  <td><a href="#" class="btn-detail"><i class="fas fa-eye"></i> Details</a></td>
                </tr>
                <tr>
                  <td>14VF1760993204</td>
                  <td>2025-10-20</td>
                  <td><a href="#" class="btn-detail"><i class="fas fa-eye"></i> Details</a></td>
                </tr>
                <tr>
                  <td>7GH21758402910</td>
                  <td>2025-09-21</td>
                  <td><a href="#" class="btn-detail"><i class="fas fa-eye"></i> Details</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Recent Customers -->
      <div class="col-12 col-lg-5">
        <div class="table-card">
          <h6>Recent Customer(s)</h6>
          <div class="table-responsive">
            <table class="table mb-0">
              <thead>
                <tr>
                  <th>Customer Email</th>
                  <th>Joined</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>sufialityyty@gmail.com</td>
                  <td>2025-11-17 07:41:47</td>
                  <td><a href="#" class="btn-detail"><i class="fas fa-eye"></i> Details</a></td>
                </tr>
                <tr>
                  <td>bgblogin2345@gmail.com</td>
                  <td>2025-10-01 12:45:44</td>
                  <td><a href="#" class="btn-detail"><i class="fas fa-eye"></i> Details</a></td>
                </tr>
                <tr>
                  <td>mmstfyalshhary@gmail.com</td>
                  <td>2025-09-29 14:08:16</td>
                  <td><a href="#" class="btn-detail"><i class="fas fa-eye"></i> Details</a></td>
                </tr>
                <tr>
                  <td>test@example.com</td>
                  <td>2025-08-15 09:22:10</td>
                  <td><a href="#" class="btn-detail"><i class="fas fa-eye"></i> Details</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
