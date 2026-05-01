@extends('emplee.master')
@section('content')

  <!-- TOPBAR -->
  @include('emplee.pages.topbar')

  <!-- CONTENT -->
  <div id="content">

    <div class="page-header">
      <h4>Employee Dashboard</h4>
    </div>

    @if(!auth()->user()->isSuperAdmin() && !auth()->user()->hasPermission('view-dashboard'))
      <div class="alert alert-danger" style="border-radius:12px;">
        <i class="fas fa-lock me-2"></i> আপনার Dashboard দেখার অনুমতি নেই।
      </div>
    @else

    <!-- Stats Grid -->
    <div class="row g-3 g-md-4 mb-4">
      @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view-orders'))
      <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card card-warning">
          <div>
            <div class="card-label">Pending Orders</div>
            <div class="card-number">130</div>
          </div>
          <i class="fas fa-clock bg-icon"></i>
          <div><a href="{{ route('admin.order.allorder', ['status'=>'pending']) }}" class="btn-detail" style="background:rgba(255,255,255,0.2); color:#fff; border:none;">View All</a></div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card card-primary">
          <div>
            <div class="card-label">Processing</div>
            <div class="card-number">24</div>
          </div>
          <i class="fas fa-gear bg-icon"></i>
          <div><a href="{{ route('admin.order.allorder', ['status'=>'processing']) }}" class="btn-detail" style="background:rgba(255,255,255,0.2); color:#fff; border:none;">View All</a></div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card card-success">
          <div>
            <div class="card-label">Completed</div>
            <div class="card-number">8</div>
          </div>
          <i class="fas fa-check-circle bg-icon"></i>
          <div><a href="{{ route('admin.order.allorder', ['status'=>'completed']) }}" class="btn-detail" style="background:rgba(255,255,255,0.2); color:#fff; border:none;">View All</a></div>
        </div>
      </div>
      @endif

      @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view-products'))
      <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card card-primary" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9);">
          <div>
            <div class="card-label">Total Products</div>
            <div class="card-number">24</div>
          </div>
          <i class="fas fa-box bg-icon"></i>
          <div><a href="{{ route('admin.products.index') }}" class="btn-detail" style="background:rgba(255,255,255,0.2); color:#fff; border:none;">View All</a></div>
        </div>
      </div>
      @endif

      @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view-users'))
      <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card card-danger">
          <div>
            <div class="card-label">Total Customers</div>
            <div class="card-number">61</div>
          </div>
          <i class="fas fa-users bg-icon"></i>
          <div><a href="{{ route('customer.index') }}" class="btn-detail" style="background:rgba(255,255,255,0.2); color:#fff; border:none;">View All</a></div>
        </div>
      </div>
      @endif

      <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card card-success" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
          <div>
            <div class="card-label">Total Posts</div>
            <div class="card-number">15</div>
          </div>
          <i class="fas fa-newspaper bg-icon"></i>
          <div><a href="#" class="btn-detail" style="background:rgba(255,255,255,0.2); color:#fff; border:none;">View All</a></div>
        </div>
      </div>
    </div>

    <!-- Data Tables Row -->
    <div class="row g-4">
      @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view-orders'))
      <div class="col-12 col-xl-7">
        <div class="table-card">
          <div class="table-card-header">
            <h6>Recent Orders</h6>
          </div>
          <div class="table-responsive">
            <table class="table mb-0">
              <thead>
                <tr>
                  <th>Order No</th>
                  <th>Date</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="fw-bold">z9qz1772084754</td>
                  <td class="text-muted">2026-02-26</td>
                  <td class="text-end">
                    <a href="#" class="btn-detail">Details</a>
                  </td>
                </tr>
                <tr>
                  <td class="fw-bold">nK8L1768816175</td>
                  <td class="text-muted">2026-01-19</td>
                  <td class="text-end">
                    <a href="#" class="btn-detail">Details</a>
                  </td>
                </tr>
                <tr>
                  <td class="fw-bold">14VF1760993204</td>
                  <td class="text-muted">2025-10-20</td>
                  <td class="text-end">
                    <a href="#" class="btn-detail">Details</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endif

      @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('view-users'))
      <div class="col-12 col-xl-5">
        <div class="table-card">
          <div class="table-card-header">
            <h6>Recent Customers</h6>
          </div>
          <div class="table-responsive">
            <table class="table mb-0">
              <thead>
                <tr>
                  <th>Email</th>
                  <th class="text-end">Joined</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-truncate" style="max-width:150px;">sufialityyty@gmail.com</td>
                  <td class="text-end text-muted">2025-11-17</td>
                </tr>
                <tr>
                  <td class="text-truncate" style="max-width:150px;">bgblogin2345@gmail.com</td>
                  <td class="text-end text-muted">2025-10-01</td>
                </tr>
                <tr>
                  <td class="text-truncate" style="max-width:150px;">mmstfyalshhary@gmail.com</td>
                  <td class="text-end text-muted">2025-09-29</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endif
    </div>

    @endif

  </div><!-- /content -->
@endsection
