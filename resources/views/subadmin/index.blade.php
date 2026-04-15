@extends('subadmin.master')
@section('content')
<!-- TOPBAR -->
  <div id="topbar">
    <div class="srch">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Search..."/>
    </div>
    <div class="tb-right">
      <button class="tb-btn"><i class="fas fa-bell"></i><span class="tb-dot">4</span></button>
      <button class="tb-btn"><i class="fas fa-envelope"></i><span class="tb-dot">9</span></button>
      <button class="tb-btn"><i class="fas fa-cog"></i></button>
      <div class="user-chip ms-2">
        <img src="https://ui-avatars.com/api/?name=Sub+Admin&background=e63946&color=fff" alt="Sub Admin"/>
        <div>
          <div class="uc-name">Sub Admin</div>
          <div class="uc-role">Sub Administrator</div>
        </div>
        <i class="fas fa-chevron-down ms-2" style="font-size:10px;color:#94a3b8;"></i>
      </div>
    </div>
  </div>

  <!-- CONTENT -->
  <div id="content">

    <!-- Page Head -->
    <div class="pg-head">
      <h4>Sub Admin Dashboard</h4>
      <nav><ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol></nav>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-3">
      <div class="col-6 col-md-4 col-lg-2">
        <div class="scard sc-red">
          <div class="sc-lbl">Total Orders</div>
          <div class="sc-num" data-count="2148">0</div>
          <div class="sc-foot">All Time</div>
          <i class="fas fa-shopping-cart sc-ico"></i>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="scard sc-orange">
          <div class="sc-lbl">Pending</div>
          <div class="sc-num" data-count="72">0</div>
          <div class="sc-foot">Action Needed</div>
          <i class="fas fa-hourglass-half sc-ico"></i>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="scard sc-teal">
          <div class="sc-lbl">Completed</div>
          <div class="sc-num" data-count="1940">0</div>
          <div class="sc-foot">This Month</div>
          <i class="fas fa-check-double sc-ico"></i>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="scard sc-navy">
          <div class="sc-lbl">Revenue</div>
          <div class="sc-num" data-count="96400" data-prefix="$">0</div>
          <div class="sc-foot">This Month</div>
          <i class="fas fa-dollar-sign sc-ico"></i>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="scard sc-purple">
          <div class="sc-lbl">Products</div>
          <div class="sc-num" data-count="384">0</div>
          <div class="sc-foot">Total Listed</div>
          <i class="fas fa-box sc-ico"></i>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="scard sc-green">
          <div class="sc-lbl">Customers</div>
          <div class="sc-num" data-count="5210">0</div>
          <div class="sc-foot">Registered</div>
          <i class="fas fa-users sc-ico"></i>
        </div>
      </div>
    </div>

    <!-- Row 2: Donut + Progress + Quick Actions -->
    <div class="row g-3 mb-3">

      <!-- Order Status Donut -->
      <div class="col-12 col-md-4">
        <div class="wcard h-100">
          <h6><i class="fas fa-chart-pie"></i> Order Status</h6>
          <div class="donut-wrap">
            <svg viewBox="0 0 100 100">
              <circle class="donut-bg" cx="50" cy="50" r="40"/>
              <!-- Completed -->
              <circle class="donut-fg" cx="50" cy="50" r="40"
                stroke="#14a085" stroke-dasharray="0 251" data-val="152" data-max="251"/>
              <!-- Pending — offset -->
              <circle class="donut-fg" cx="50" cy="50" r="40"
                stroke="#f4a261" stroke-dasharray="0 251" data-val="45" data-max="251" data-offset="152"/>
              <!-- Cancelled -->
              <circle class="donut-fg" cx="50" cy="50" r="40"
                stroke="#e63946" stroke-dasharray="0 251" data-val="20" data-max="251" data-offset="197"/>
            </svg>
            <div class="donut-num">217</div>
          </div>
          <div class="donut-lbl">This Week</div>
          <div class="donut-sub mb-3">Total Orders</div>
          <div class="legend-item"><span class="legend-dot" style="background:#14a085"></span> Completed <span class="legend-val">152</span></div>
          <div class="legend-item"><span class="legend-dot" style="background:#f4a261"></span> Pending <span class="legend-val">45</span></div>
          <div class="legend-item"><span class="legend-dot" style="background:#e63946"></span> Cancelled <span class="legend-val">20</span></div>
        </div>
      </div>

      <!-- Category Performance -->
      <div class="col-12 col-md-4">
        <div class="wcard h-100">
          <h6><i class="fas fa-tasks"></i> Category Sales</h6>
          <div class="mini-bar-row">
            <div class="mini-bar-top"><span>Electronics</span><span>82%</span></div>
            <div class="mini-track"><div class="mini-fill" style="width:0%;background:#e63946" data-w="82%"></div></div>
          </div>
          <div class="mini-bar-row">
            <div class="mini-bar-top"><span>Fashion</span><span>67%</span></div>
            <div class="mini-track"><div class="mini-fill" style="width:0%;background:#f4a261" data-w="67%"></div></div>
          </div>
          <div class="mini-bar-row">
            <div class="mini-bar-top"><span>Home & Garden</span><span>54%</span></div>
            <div class="mini-track"><div class="mini-fill" style="width:0%;background:#14a085" data-w="54%"></div></div>
          </div>
          <div class="mini-bar-row">
            <div class="mini-bar-top"><span>Sports</span><span>39%</span></div>
            <div class="mini-track"><div class="mini-fill" style="width:0%;background:#2980b9" data-w="39%"></div></div>
          </div>
          <div class="mini-bar-row">
            <div class="mini-bar-top"><span>Beauty</span><span>61%</span></div>
            <div class="mini-track"><div class="mini-fill" style="width:0%;background:#8e44ad" data-w="61%"></div></div>
          </div>
          <div class="mini-bar-row">
            <div class="mini-bar-top"><span>Books</span><span>28%</span></div>
            <div class="mini-track"><div class="mini-fill" style="width:0%;background:#27ae60" data-w="28%"></div></div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="col-12 col-md-4">
        <div class="wcard h-100">
          <h6><i class="fa-solid fa-bol"></i> Quick Actions</h6>
          <div class="row g-2">
            <div class="col-6"><a href="#" class="qa-btn"><i class="fas fa-plus-circle"></i><span>Add Product</span></a></div>
            <div class="col-6"><a href="#" class="qa-btn"><i class="fas fa-shopping-bag"></i><span>View Orders</span></a></div>
            <div class="col-6"><a href="#" class="qa-btn"><i class="fas fa-user-plus"></i><span>Add Customer</span></a></div>
            <div class="col-6"><a href="#" class="qa-btn"><i class="fas fa-tag"></i><span>New Coupon</span></a></div>
            <div class="col-6"><a href="#" class="qa-btn"><i class="fas fa-chart-bar"></i><span>Reports</span></a></div>
            <div class="col-6"><a href="#" class="qa-btn"><i class="fas fa-store"></i><span>Vendors</span></a></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Row 3: Orders Table + Activity + Top Products -->
    <div class="row g-3">

      <!-- Recent Orders -->
      <div class="col-12 col-lg-7">
        <div class="wcard">
          <h6><i class="fas fa-list-alt"></i> Recent Orders</h6>
          <div class="table-responsive">
            <table class="table mb-0">
              <thead>
                <tr>
                  <th>Order #</th>
                  <th>Customer</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>#SA-3041</strong></td>
                  <td>Arif Hossain</td>
                  <td>$249</td>
                  <td>Mar 10, 2026</td>
                  <td><span class="pill pill-warn">Pending</span></td>
                  <td><a href="#" class="act-btn"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                <tr>
                  <td><strong>#SA-3040</strong></td>
                  <td>Nadia Islam</td>
                  <td>$89</td>
                  <td>Mar 09, 2026</td>
                  <td><span class="pill pill-info">Processing</span></td>
                  <td><a href="#" class="act-btn"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                <tr>
                  <td><strong>#SA-3038</strong></td>
                  <td>Rahim Uddin</td>
                  <td>$560</td>
                  <td>Mar 08, 2026</td>
                  <td><span class="pill pill-success">Completed</span></td>
                  <td><a href="#" class="act-btn"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                <tr>
                  <td><strong>#SA-3035</strong></td>
                  <td>Tasnim Khan</td>
                  <td>$134</td>
                  <td>Mar 07, 2026</td>
                  <td><span class="pill pill-success">Completed</span></td>
                  <td><a href="#" class="act-btn"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                <tr>
                  <td><strong>#SA-3031</strong></td>
                  <td>Sabbir Ahmed</td>
                  <td>$78</td>
                  <td>Mar 06, 2026</td>
                  <td><span class="pill pill-danger">Cancelled</span></td>
                  <td><a href="#" class="act-btn"><i class="fas fa-eye"></i> View</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-12 col-lg-5">

        <!-- Activity Feed -->
        <div class="wcard mb-3">
          <h6><i class="fas fa-history"></i> Recent Activity</h6>
          <div class="feed-item">
            <div class="feed-ico" style="background:#fee2e2"><i class="fas fa-shopping-cart" style="color:#e63946"></i></div>
            <div><div class="feed-txt">New order <strong>#SA-3041</strong> from Arif Hossain</div><div class="feed-time">5 min ago</div></div>
          </div>
          <div class="feed-item">
            <div class="feed-ico" style="background:#d1fae5"><i class="fas fa-check" style="color:#14a085"></i></div>
            <div><div class="feed-txt">Order <strong>#SA-3038</strong> marked as completed</div><div class="feed-time">30 min ago</div></div>
          </div>
          <div class="feed-item">
            <div class="feed-ico" style="background:#dbeafe"><i class="fas fa-user" style="color:#2980b9"></i></div>
            <div><div class="feed-txt">New customer <strong>Nadia Islam</strong> registered</div><div class="feed-time">1 hour ago</div></div>
          </div>
          <div class="feed-item">
            <div class="feed-ico" style="background:#ede9fe"><i class="fas fa-store" style="color:#8e44ad"></i></div>
            <div><div class="feed-txt">Vendor <strong>Fashion Hub BD</strong> verified</div><div class="feed-time">2 hours ago</div></div>
          </div>
        </div>

        <!-- Top Products -->
        <div class="wcard">
          <h6><i class="fas fa-trophy"></i> Top Products</h6>
          <div class="prod-item">
            <div class="prod-rank gold">1</div>
            <div class="prod-info"><div class="prod-name">iPhone 15 Pro</div><div class="prod-cat">Electronics</div></div>
            <div class="prod-rev">$12,400</div>
          </div>
          <div class="prod-item">
            <div class="prod-rank silver">2</div>
            <div class="prod-info"><div class="prod-name">Nike Air Max 270</div><div class="prod-cat">Sports</div></div>
            <div class="prod-rev">$8,900</div>
          </div>
          <div class="prod-item">
            <div class="prod-rank bronze">3</div>
            <div class="prod-info"><div class="prod-name">Samsung 4K TV</div><div class="prod-cat">Electronics</div></div>
            <div class="prod-rev">$7,200</div>
          </div>
          <div class="prod-item">
            <div class="prod-rank">4</div>
            <div class="prod-info"><div class="prod-name">Sony WH-1000XM5</div><div class="prod-cat">Electronics</div></div>
            <div class="prod-rev">$5,800</div>
          </div>
          <div class="prod-item">
            <div class="prod-rank">5</div>
            <div class="prod-info"><div class="prod-name">Zara Summer Dress</div><div class="prod-cat">Fashion</div></div>
            <div class="prod-rev">$4,100</div>
          </div>
        </div>

      </div>
    </div>

  </div><!-- /content -->
@endsection
