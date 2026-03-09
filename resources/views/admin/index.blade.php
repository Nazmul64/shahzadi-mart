@extends('admin.master')

@section('main-content')
<div class="page-wrapper">

    {{-- Page Header --}}
    <div class="page-header-bar">
        <h1>Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    {{-- ── Stat Cards Row 1 ─────────────────────────────── --}}
    <div class="stat-grid" style="grid-template-columns:repeat(3,1fr);">
        <div class="stat-card stat-card-orange">
            <div>
                <div class="stat-card-title">Orders Pending!</div>
                <div class="stat-card-value">130</div>
            </div>
            <div class="stat-card-link"><a href="#">View All</a></div>
            <i class="bi bi-currency-dollar stat-card-icon"></i>
        </div>

        <div class="stat-card stat-card-blue">
            <div>
                <div class="stat-card-title">Orders Processing!</div>
                <div class="stat-card-value">0</div>
            </div>
            <div class="stat-card-link"><a href="#">View All</a></div>
            <i class="bi bi-truck stat-card-icon"></i>
        </div>

        <div class="stat-card stat-card-teal">
            <div>
                <div class="stat-card-title">Orders Completed!</div>
                <div class="stat-card-value">8</div>
            </div>
            <div class="stat-card-link"><a href="#">View All</a></div>
            <i class="bi bi-check-circle stat-card-icon"></i>
        </div>
    </div>

    {{-- ── Stat Cards Row 2 ─────────────────────────────── --}}
    <div class="stat-grid" style="grid-template-columns:repeat(3,1fr);">
        <div class="stat-card stat-card-purple">
            <div>
                <div class="stat-card-title">Total Products!</div>
                <div class="stat-card-value">24</div>
            </div>
            <div class="stat-card-link"><a href="#">View All</a></div>
            <i class="bi bi-cart stat-card-icon"></i>
        </div>

        <div class="stat-card stat-card-red">
            <div>
                <div class="stat-card-title">Total Customers!</div>
                <div class="stat-card-value">61</div>
            </div>
            <div class="stat-card-link"><a href="#">View All</a></div>
            <i class="bi bi-people stat-card-icon"></i>
        </div>

        <div class="stat-card stat-card-green">
            <div>
                <div class="stat-card-title">Total Posts!</div>
                <div class="stat-card-value">15</div>
            </div>
            <div class="stat-card-link"><a href="#">View All</a></div>
            <i class="bi bi-newspaper stat-card-icon"></i>
        </div>
    </div>

    {{-- ── Circle Stats ─────────────────────────────────── --}}
    <div class="circle-stats-grid">
        <div class="circle-stat-card">
            <div class="circle-stat-ring ring-gold">0</div>
            <div class="circle-stat-label">New Customers</div>
            <div class="circle-stat-sublabel">Last 30 Days</div>
        </div>
        <div class="circle-stat-card">
            <div class="circle-stat-ring ring-teal">61</div>
            <div class="circle-stat-label">Total Customers</div>
            <div class="circle-stat-sublabel">All Time</div>
        </div>
        <div class="circle-stat-card">
            <div class="circle-stat-ring ring-purple">0</div>
            <div class="circle-stat-label">Total Sales</div>
            <div class="circle-stat-sublabel">Last 30 days</div>
        </div>
        <div class="circle-stat-card">
            <div class="circle-stat-ring ring-green">8</div>
            <div class="circle-stat-label">Total Sales</div>
            <div class="circle-stat-sublabel">All Time</div>
        </div>
    </div>

    {{-- ── Two-column: Recent Orders + Recent Customers ─── --}}
    <div class="two-col">
        {{-- Recent Orders --}}
        <div class="data-card">
            <div class="data-card-header">
                <h5 class="data-card-title">Recent Order(s)</h5>
            </div>
            <div class="data-card-body">
                <table class="admin-table">
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
                            <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                        </tr>
                        <tr>
                            <td>nK8L1768816175</td>
                            <td>2026-01-19</td>
                            <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                        </tr>
                        <tr>
                            <td>14VF1760993204</td>
                            <td>2025-10-20</td>
                            <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                        </tr>
                        <tr>
                            <td>vIPo1757936088</td>
                            <td>2025-09-15</td>
                            <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                        </tr>
                        <tr>
                            <td>b5fj1752750195</td>
                            <td>2025-07-17</td>
                            <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Customers --}}
        <div class="data-card">
            <div class="data-card-header">
                <h5 class="data-card-title">Recent Customer(s)</h5>
            </div>
            <div class="data-card-body">
                <table class="admin-table">
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
                            <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                        </tr>
                        <tr>
                            <td>bgblogin2345@gmail.com</td>
                            <td>2025-10-01 12:45:44</td>
                            <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                        </tr>
                        <tr>
                            <td>mmstfyalshhary@gmail.com</td>
                            <td>2025-09-29 14:08:16</td>
                            <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                        </tr>
                        <tr>
                            <td>archita@gmail.com</td>
                            <td>2025-07-17 11:03:15</td>
                            <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                        </tr>
                        <tr>
                            <td>webappmate.pm@gmail.com</td>
                            <td>2025-07-10 04:39:05</td>
                            <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ── Popular Products ─────────────────────────────── --}}
    <div class="data-card">
        <div class="data-card-header">
            <h5 class="data-card-title">Popular Product(s)</h5>
        </div>
        <div class="data-card-body">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Featured Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="https://images.unsplash.com/photo-1591348278863-a8fb3887e2aa?w=100" alt="" class="pop-img"></td>
                        <td>Top Rated product title will be here according to ...</td>
                        <td>Fashion & Beauty ACCESSORIES</td>
                        <td>Physical</td>
                        <td>110$</td>
                        <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                    </tr>
                    <tr>
                        <td><img src="https://images.unsplash.com/photo-1594938298603-c8148c4b4de2?w=100" alt="" class="pop-img"></td>
                        <td>Physical Product Title will be here</td>
                        <td>Fashion & Beauty CLOTHINGS</td>
                        <td>Physical</td>
                        <td>40.70$</td>
                        <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                    </tr>
                    <tr>
                        <td><img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?w=100" alt="" class="pop-img"></td>
                        <td>Revel - Real Estate Huuu</td>
                        <td>Home decoration / LCD TV</td>
                        <td>Physical</td>
                        <td>335$</td>
                        <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                    </tr>
                    <tr>
                        <td><img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=100" alt="" class="pop-img"></td>
                        <td>Zain - Digital Agency and Startup HTML Template</td>
                        <td>Fashion & Beauty SHOES</td>
                        <td>Physical</td>
                        <td>321$</td>
                        <td><a href="#" class="btn-detail"><i class="bi bi-eye"></i> Details</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Sales Chart ──────────────────────────────────── --}}
    <div class="chart-card">
        <h5>Total Sales in Last 30 Days</h5>
        <canvas id="salesChart" height="90"></canvas>
    </div>

    {{-- ── Pie Charts ───────────────────────────────────── --}}
    <div class="two-col">
        <div class="chart-card">
            <h5>Top Referrals</h5>
            <div style="display:flex; align-items:center; gap:20px; flex-wrap:wrap;">
                <canvas id="referralChart" style="max-width:220px; max-height:220px;"></canvas>
                <div id="referralLegend" style="font-size:12px;"></div>
            </div>
        </div>
        <div class="chart-card">
            <h5>Most Used OS</h5>
            <div style="display:flex; align-items:center; gap:20px; flex-wrap:wrap;">
                <canvas id="osChart" style="max-width:220px; max-height:220px;"></canvas>
                <div id="osLegend" style="font-size:12px;"></div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Sales line chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
const labels = [];
const now = new Date();
for (let i = 29; i >= 0; i--) {
    const d = new Date(now);
    d.setDate(d.getDate() - i);
    labels.push(d.toLocaleDateString('en-GB', { day:'2-digit', month:'short' }));
}
new Chart(salesCtx, {
    type : 'line',
    data : {
        labels  : labels,
        datasets: [{
            label          : 'Sales',
            data           : labels.map(() => Math.floor(Math.random() * 3)),
            borderColor    : '#3d5a99',
            backgroundColor: 'rgba(61,90,153,0.08)',
            tension        : 0.3,
            pointRadius    : 3,
            pointBackgroundColor: '#3d5a99',
            fill           : true,
        }]
    },
    options: {
        plugins   : { legend: { display: false } },
        scales    : {
            x: { ticks: { font: { size: 10 }, maxRotation: 0, autoSkip: true, maxTicksLimit: 15 } },
            y: { beginAtZero: true, ticks: { font: { size: 10 } } }
        }
    }
});

// Helper: custom legend
function buildLegend(containerId, labels, colors) {
    const el = document.getElementById(containerId);
    el.innerHTML = labels.map((l, i) =>
        `<div style="display:flex;align-items:center;gap:6px;margin-bottom:5px;">
            <span style="width:12px;height:12px;border-radius:50%;background:${colors[i]};flex-shrink:0;"></span>
            <span>${l}</span>
        </div>`
    ).join('');
}

// Referral pie
const refLabels = ['codecanyon.net', 'geniusocean.com', 's-o-s.net', 'www.google.com', 'connect.facebook.net'];
const refData   = [71, 20.88, 4.69, 2.02, 1.41];
const refColors = ['#4472ca', '#ed7d31', '#a9d18e', '#4db8c8', '#7030a0'];
new Chart(document.getElementById('referralChart').getContext('2d'), {
    type : 'pie',
    data : { labels: refLabels, datasets: [{ data: refData, backgroundColor: refColors, borderWidth: 2, borderColor:'#fff' }] },
    options: { plugins: { legend: { display: false } } }
});
buildLegend('referralLegend', refLabels, refColors);

// OS pie
const osLabels = ['Unknown OS Platform', 'Windows 10', 'Android', 'Mac OS X', 'Windows 7'];
const osData   = [63.37, 22.62, 6.11, 5.7, 2.21];
const osColors = ['#4472ca', '#ed7d31', '#a9d18e', '#4db8c8', '#7030a0'];
new Chart(document.getElementById('osChart').getContext('2d'), {
    type : 'pie',
    data : { labels: osLabels, datasets: [{ data: osData, backgroundColor: osColors, borderWidth: 2, borderColor:'#fff' }] },
    options: { plugins: { legend: { display: false } } }
});
buildLegend('osLegend', osLabels, osColors);
</script>
@endpush
