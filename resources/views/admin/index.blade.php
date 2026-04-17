@extends('admin.master')

@section('main-content')
<div class="page-wrapper">

    {{-- Page Header --}}
    <div class="page-header-bar">
        <h1>Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
            </ol>
        </nav>
    </div>

    {{-- Stats Cards --}}
    <div class="stats-grid">

        <div class="stat-card stat-pending">
            <div class="stat-icon"><i class="bi bi-clock-history"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $ordersPending }}</div>
                <div class="stat-label">Pending Orders</div>
            </div>
        </div>

        <div class="stat-card stat-processing">
            <div class="stat-icon"><i class="bi bi-arrow-repeat"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $ordersProcessing }}</div>
                <div class="stat-label">Processing Orders</div>
            </div>
        </div>

        <div class="stat-card stat-completed">
            <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $ordersCompleted }}</div>
                <div class="stat-label">Completed Orders</div>
            </div>
        </div>

        <div class="stat-card stat-products">
            <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $totalProducts }}</div>
                <div class="stat-label">Total Products</div>
            </div>
        </div>

        <div class="stat-card stat-sales">
            <div class="stat-icon"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $salesLast30 }}</div>
                <div class="stat-label">Sales (Last 30 Days)</div>
            </div>
        </div>

        <div class="stat-card stat-alltime">
            <div class="stat-icon"><i class="bi bi-trophy"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $salesAllTime }}</div>
                <div class="stat-label">Total Sales (All Time)</div>
            </div>
        </div>

    </div>

    {{-- Sales Chart --}}
    <div class="data-card" style="margin-bottom:24px;">
        <div class="data-card-header">
            <h5 class="data-card-title">
                <i class="bi bi-bar-chart-line me-2"></i>Last 30 Days Sales
            </h5>
        </div>
        <div class="data-card-body" style="padding:20px;">
            <canvas id="salesChart" style="max-height:280px;"></canvas>
        </div>
    </div>

    {{-- Recent Orders + Popular Products --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;">

        {{-- Recent Orders --}}
        <div class="data-card">
            <div class="data-card-header"
                 style="display:flex;justify-content:space-between;align-items:center;">
                <h5 class="data-card-title">
                    <i class="bi bi-receipt me-2"></i>Recent Orders
                </h5>
                <a href="{{ route('admin.order.allorder') }}"
                   style="font-size:12px;color:#3d5a99;text-decoration:none;">
                    View All →
                </a>
            </div>
            <div class="data-card-body" style="padding:0;">
                @if($recentOrders->isEmpty())
                    <div style="text-align:center;padding:30px;color:#aaa;">
                        <i class="bi bi-inbox" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                        কোনো অর্ডার নেই।
                    </div>
                @else
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>অর্ডার</th>
                                <th>কাস্টমার</th>
                                <th>মোট</th>
                                <th>স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.order.show', $order->id) }}"
                                       style="font-weight:600;color:#3d5a99;font-size:12px;">
                                        {{ $order->order_number }}
                                    </a>
                                    <div style="font-size:11px;color:#aaa;">
                                        {{ $order->items->count() }} টি পণ্য
                                    </div>
                                </td>
                                <td style="font-size:13px;">{{ $order->customer_name }}</td>
                                <td style="font-size:13px;font-weight:600;">
                                    ৳{{ number_format($order->total, 0) }}
                                </td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'pending'    => ['bg' => '#fff8e6', 'color' => '#b7791f', 'label' => '⏳ Pending'],
                                            'processing' => ['bg' => '#ebf8ff', 'color' => '#2b6cb0', 'label' => '🔄 Processing'],
                                            'completed'  => ['bg' => '#f0fff4', 'color' => '#276749', 'label' => '✅ Completed'],
                                            'cancelled'  => ['bg' => '#fff5f5', 'color' => '#c53030', 'label' => '❌ Cancelled'],
                                        ];
                                        $cfg = $statusConfig[$order->order_status]
                                            ?? ['bg' => '#f5f5f5', 'color' => '#888', 'label' => $order->order_status];
                                    @endphp
                                    <span style="background:{{ $cfg['bg'] }};color:{{ $cfg['color'] }};
                                                 border-radius:20px;padding:2px 8px;font-size:11px;font-weight:500;">
                                        {{ $cfg['label'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        {{-- Popular Products --}}
        <div class="data-card">
            <div class="data-card-header">
                <h5 class="data-card-title">
                    <i class="bi bi-fire me-2"></i>Popular Products
                </h5>
            </div>
            <div class="data-card-body" style="padding:0;">
                @if($popularProducts->isEmpty())
                    <div style="text-align:center;padding:30px;color:#aaa;">
                        <i class="bi bi-box" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                        কোনো পণ্য নেই।
                    </div>
                @else
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>পণ্যের নাম</th>
                                <th style="text-align:center;">অর্ডার সংখ্যা</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($popularProducts as $i => $product)
                            <tr>
                                <td style="font-weight:600;color:#3d5a99;">{{ $i + 1 }}</td>
                                <td>
                                    <div style="font-size:13px;font-weight:500;">{{ $product->name }}</div>
                                    @if($product->price)
                                        <div style="font-size:11px;color:#aaa;">
                                            ৳{{ number_format($product->price, 0) }}
                                        </div>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    <span style="background:#ebf8ff;color:#2b6cb0;border-radius:20px;
                                                 padding:2px 10px;font-size:12px;font-weight:600;">
                                        {{ $product->order_items_count }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>

    {{-- Order Status Summary --}}
    <div class="data-card" style="margin-bottom:24px;">
        <div class="data-card-header">
            <h5 class="data-card-title">
                <i class="bi bi-pie-chart me-2"></i>Order Status Summary
            </h5>
        </div>
        <div class="data-card-body">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px;">

                <a href="{{ route('admin.order.allorder') }}" style="text-decoration:none;">
                    <div style="background:#f8f9fa;border-radius:10px;padding:16px;text-align:center;
                                border:1px solid #e5e7eb;transition:opacity .2s;"
                         onmouseover="this.style.opacity='.82'" onmouseout="this.style.opacity='1'">
                        <div style="font-size:24px;font-weight:700;color:#3d5a99;">{{ $statusCounts['all'] }}</div>
                        <div style="font-size:12px;color:#888;margin-top:4px;">All Orders</div>
                    </div>
                </a>

                <a href="{{ route('admin.order.allorder', ['status' => 'pending']) }}" style="text-decoration:none;">
                    <div style="background:#fff8e6;border-radius:10px;padding:16px;text-align:center;
                                border:1px solid #f6e05e;transition:opacity .2s;"
                         onmouseover="this.style.opacity='.82'" onmouseout="this.style.opacity='1'">
                        <div style="font-size:24px;font-weight:700;color:#b7791f;">{{ $statusCounts['pending'] }}</div>
                        <div style="font-size:12px;color:#b7791f;margin-top:4px;">⏳ Pending</div>
                    </div>
                </a>

                <a href="{{ route('admin.order.allorder', ['status' => 'processing']) }}" style="text-decoration:none;">
                    <div style="background:#ebf8ff;border-radius:10px;padding:16px;text-align:center;
                                border:1px solid #90cdf4;transition:opacity .2s;"
                         onmouseover="this.style.opacity='.82'" onmouseout="this.style.opacity='1'">
                        <div style="font-size:24px;font-weight:700;color:#2b6cb0;">{{ $statusCounts['processing'] }}</div>
                        <div style="font-size:12px;color:#2b6cb0;margin-top:4px;">🔄 Processing</div>
                    </div>
                </a>

                <a href="{{ route('admin.order.allorder', ['status' => 'completed']) }}" style="text-decoration:none;">
                    <div style="background:#f0fff4;border-radius:10px;padding:16px;text-align:center;
                                border:1px solid #9ae6b4;transition:opacity .2s;"
                         onmouseover="this.style.opacity='.82'" onmouseout="this.style.opacity='1'">
                        <div style="font-size:24px;font-weight:700;color:#276749;">{{ $statusCounts['completed'] }}</div>
                        <div style="font-size:12px;color:#276749;margin-top:4px;">✅ Completed</div>
                    </div>
                </a>

                <a href="{{ route('admin.order.allorder', ['status' => 'cancelled']) }}" style="text-decoration:none;">
                    <div style="background:#fff5f5;border-radius:10px;padding:16px;text-align:center;
                                border:1px solid #feb2b2;transition:opacity .2s;"
                         onmouseover="this.style.opacity='.82'" onmouseout="this.style.opacity='1'">
                        <div style="font-size:24px;font-weight:700;color:#c53030;">{{ $statusCounts['cancelled'] }}</div>
                        <div style="font-size:12px;color:#c53030;margin-top:4px;">❌ Cancelled</div>
                    </div>
                </a>

            </div>
        </div>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Completed Orders',
                data: @json($chartData),
                borderColor: '#3d5a99',
                backgroundColor: 'rgba(61,90,153,0.07)',
                borderWidth: 2,
                pointBackgroundColor: '#3d5a99',
                pointRadius: 3,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.parsed.y + ' orders'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 11 } },
                    grid: { color: 'rgba(0,0,0,0.04)' }
                },
                x: {
                    ticks: { font: { size: 10 }, maxRotation: 45 },
                    grid: { display: false }
                }
            }
        }
    });
</script>

<style>
/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.stat-card {
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    border: 1px solid transparent;
    transition: transform .2s, box-shadow .2s;
}
.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}
.stat-icon {
    font-size: 26px;
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.stat-number { font-size: 26px; font-weight: 700; line-height: 1; }
.stat-label  { font-size: 12px; margin-top: 4px; opacity: .75; }

.stat-pending    { background:#fff8e6; color:#b7791f; border-color:#f6e05e; }
.stat-pending    .stat-icon { background:rgba(183,121,31,.12); }
.stat-processing { background:#ebf8ff; color:#2b6cb0; border-color:#90cdf4; }
.stat-processing .stat-icon { background:rgba(43,108,176,.12); }
.stat-completed  { background:#f0fff4; color:#276749; border-color:#9ae6b4; }
.stat-completed  .stat-icon { background:rgba(39,103,73,.12); }
.stat-products   { background:#faf5ff; color:#6b46c1; border-color:#d6bcfa; }
.stat-products   .stat-icon { background:rgba(107,70,193,.12); }
.stat-sales      { background:#fff5f5; color:#c53030; border-color:#feb2b2; }
.stat-sales      .stat-icon { background:rgba(197,48,48,.12); }
.stat-alltime    { background:#f0f4ff; color:#3d5a99; border-color:#c3cfe2; }
.stat-alltime    .stat-icon { background:rgba(61,90,153,.12); }

@media (max-width: 768px) {
    div[style*="grid-template-columns:1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
