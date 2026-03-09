@extends('manager.master')
@section('content')
  <!-- TOPBAR -->
  <div id="topbar">
    <div class="search-box">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Search orders, products..."/>
    </div>
    <div class="topbar-right">
      <button class="t-btn"><i class="fas fa-bell"></i><span class="t-badge">3</span></button>
      <button class="t-btn"><i class="fas fa-envelope"></i><span class="t-badge">7</span></button>
      <button class="t-btn"><i class="fas fa-cog"></i></button>
      <div class="manager-pill ms-2">
        <img src="https://ui-avatars.com/api/?name=Manager&background=6366f1&color=fff" alt="Manager"/>
        <div>
          <div class="mp-name">Manager</div>
          <div class="mp-role">Store Manager</div>
        </div>
        <i class="fas fa-chevron-down ms-1" style="font-size:10px;color:#94a3b8;"></i>
      </div>
    </div>
  </div>

  <!-- CONTENT -->
  <div id="content">

    <!-- Page Top -->
    <div class="page-top">
      <h4>Manager Dashboard</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>

    <!-- Stat Cards Row 1 -->
    <div class="row g-3 mb-3">
      <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card sc-indigo">
          <div class="sc-label">Total Orders</div>
          <div class="sc-num" data-count="1284">0</div>
          <div class="sc-sub">All Time</div>
          <i class="fas fa-shopping-cart sc-icon"></i>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card sc-cyan">
          <div class="sc-label">Pending</div>
          <div class="sc-num" data-count="48">0</div>
          <div class="sc-sub">Needs Action</div>
          <i class="fas fa-clock sc-icon"></i>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card sc-emerald">
          <div class="sc-label">Completed</div>
          <div class="sc-num" data-count="1190">0</div>
          <div class="sc-sub">This Month</div>
          <i class="fas fa-check-circle sc-icon"></i>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card sc-amber">
          <div class="sc-label">Revenue</div>
          <div class="sc-num" data-count="84250" data-prefix="$">0</div>
          <div class="sc-sub">This Month</div>
          <i class="fas fa-dollar-sign sc-icon"></i>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card sc-rose">
          <div class="sc-label">Returns</div>
          <div class="sc-num" data-count="12">0</div>
          <div class="sc-sub">This Month</div>
          <i class="fas fa-undo sc-icon"></i>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card sc-violet">
          <div class="sc-label">Customers</div>
          <div class="sc-num" data-count="3420">0</div>
          <div class="sc-sub">Total</div>
          <i class="fas fa-users sc-icon"></i>
        </div>
      </div>
    </div>

    <!-- Chart + Mini Stats -->
    <div class="row g-3 mb-3">
      <!-- Bar Chart -->
      <div class="col-12 col-lg-8">
        <div class="chart-card">
          <div class="cc-head">
            <h6><i class="fas fa-chart-bar me-2" style="color:var(--accent)"></i>Monthly Revenue</h6>
            <select id="chartFilter">
              <option>Last 7 Months</option>
              <option>Last 12 Months</option>
            </select>
          </div>
          <div class="bar-chart" id="barChart"></div>
          <div style="display:flex;gap:8px;margin-top:10px;" id="barLabels"></div>
        </div>
      </div>

      <!-- Mini Stats -->
      <div class="col-12 col-lg-4">
        <div class="row g-3 h-100">
          <div class="col-6 col-lg-12">
            <div class="mini-stat" style="animation-delay:0.35s">
              <div class="mini-icon mi-bg-indigo"><i class="fas fa-box"></i></div>
              <div><div class="mi-val" data-count="246">0</div><div class="mi-label">Total Products</div></div>
            </div>
          </div>
          <div class="col-6 col-lg-12">
            <div class="mini-stat" style="animation-delay:0.40s">
              <div class="mini-icon mi-bg-cyan"><i class="fas fa-store"></i></div>
              <div><div class="mi-val" data-count="38">0</div><div class="mi-label">Active Vendors</div></div>
            </div>
          </div>
          <div class="col-6 col-lg-12">
            <div class="mini-stat" style="animation-delay:0.45s">
              <div class="mini-icon mi-bg-emerald"><i class="fas fa-star"></i></div>
              <div><div class="mi-val">4.8</div><div class="mi-label">Avg. Rating</div></div>
            </div>
          </div>
          <div class="col-6 col-lg-12">
            <div class="mini-stat" style="animation-delay:0.50s">
              <div class="mini-icon mi-bg-amber"><i class="fas fa-ticket-alt"></i></div>
              <div><div class="mi-val" data-count="15">0</div><div class="mi-label">Active Coupons</div></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Progress + Activity -->
    <div class="row g-3 mb-3">
      <div class="col-12 col-md-5">
        <div class="progress-card">
          <h6><i class="fas fa-tasks me-2" style="color:var(--accent)"></i>Category Performance</h6>
          <div class="prog-row">
            <div class="prog-label"><span>Electronics</span><span>78%</span></div>
            <div class="progress"><div class="progress-bar bg-primary" style="width:0%" data-width="78%"></div></div>
          </div>
          <div class="prog-row">
            <div class="prog-label"><span>Fashion</span><span>62%</span></div>
            <div class="progress"><div class="progress-bar" style="width:0%;background:var(--accent2)" data-width="62%"></div></div>
          </div>
          <div class="prog-row">
            <div class="prog-label"><span>Home & Garden</span><span>45%</span></div>
            <div class="progress"><div class="progress-bar bg-success" style="width:0%" data-width="45%"></div></div>
          </div>
          <div class="prog-row">
            <div class="prog-label"><span>Sports</span><span>33%</span></div>
            <div class="progress"><div class="progress-bar bg-warning" style="width:0%" data-width="33%"></div></div>
          </div>
          <div class="prog-row">
            <div class="prog-label"><span>Beauty</span><span>55%</span></div>
            <div class="progress"><div class="progress-bar bg-danger" style="width:0%" data-width="55%"></div></div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-7">
        <div class="activity-card">
          <h6><i class="fas fa-history me-2" style="color:var(--accent)"></i>Recent Activity</h6>
          <div class="activity-item">
            <div class="act-dot mi-bg-indigo"><i class="fas fa-shopping-cart" style="color:#6366f1"></i></div>
            <div><div class="act-text">New order <strong>#ORD-2984</strong> received from John Doe</div><div class="act-time">2 minutes ago</div></div>
          </div>
          <div class="activity-item">
            <div class="act-dot mi-bg-emerald"><i class="fas fa-check" style="color:#059669"></i></div>
            <div><div class="act-text">Order <strong>#ORD-2981</strong> has been completed</div><div class="act-time">18 minutes ago</div></div>
          </div>
          <div class="activity-item">
            <div class="act-dot mi-bg-amber"><i class="fas fa-user-plus" style="color:#d97706"></i></div>
            <div><div class="act-text">New vendor <strong>Tech World BD</strong> registered</div><div class="act-time">1 hour ago</div></div>
          </div>
          <div class="activity-item">
            <div class="act-dot mi-bg-cyan"><i class="fas fa-star" style="color:#06b6d4"></i></div>
            <div><div class="act-text">Product <strong>iPhone 15 Pro</strong> received 5-star review</div><div class="act-time">2 hours ago</div></div>
          </div>
          <div class="activity-item">
            <div class="act-dot" style="background:#fee2e2"><i class="fas fa-undo" style="color:#ef4444"></i></div>
            <div><div class="act-text">Return request for <strong>#ORD-2970</strong> submitted</div><div class="act-time">3 hours ago</div></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row g-3">
      <div class="col-12">
        <div class="table-card">
          <h6><i class="fas fa-list me-2" style="color:var(--accent)"></i>Recent Orders</h6>
          <div class="table-responsive">
            <table class="table mb-0">
              <thead>
                <tr>
                  <th>Order #</th>
                  <th>Customer</th>
                  <th>Product</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>#ORD-2984</strong></td>
                  <td>John Doe</td>
                  <td>iPhone 15 Pro</td>
                  <td>$1,199</td>
                  <td>2026-03-10</td>
                  <td><span class="status-pill sp-warning">Pending</span></td>
                  <td><a href="#" class="btn-sm-action"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                <tr>
                  <td><strong>#ORD-2983</strong></td>
                  <td>Sarah Khan</td>
                  <td>Samsung Galaxy S24</td>
                  <td>$899</td>
                  <td>2026-03-09</td>
                  <td><span class="status-pill sp-info">Processing</span></td>
                  <td><a href="#" class="btn-sm-action"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                <tr>
                  <td><strong>#ORD-2981</strong></td>
                  <td>Rahim Mia</td>
                  <td>Nike Air Max 270</td>
                  <td>$149</td>
                  <td>2026-03-08</td>
                  <td><span class="status-pill sp-success">Completed</span></td>
                  <td><a href="#" class="btn-sm-action"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                <tr>
                  <td><strong>#ORD-2979</strong></td>
                  <td>Priya Das</td>
                  <td>Adidas Ultraboost</td>
                  <td>$189</td>
                  <td>2026-03-07</td>
                  <td><span class="status-pill sp-success">Completed</span></td>
                  <td><a href="#" class="btn-sm-action"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                <tr>
                  <td><strong>#ORD-2970</strong></td>
                  <td>Karim Ahmed</td>
                  <td>Sony WH-1000XM5</td>
                  <td>$349</td>
                  <td>2026-03-05</td>
                  <td><span class="status-pill sp-danger">Returned</span></td>
                  <td><a href="#" class="btn-sm-action"><i class="fas fa-eye"></i> View</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /content -->
@endsection
