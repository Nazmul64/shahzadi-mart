@extends('admin.master')

@section('main-content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.db-page {
    padding: 30px 24px;
    background: #f4f7fb;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.db-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 30px;
}

.db-header h1 {
    margin: 0;
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.5px;
}

.db-header p {
    margin: 4px 0 0;
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

/* ── STAT CARDS ── */
.db-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.db-stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.02);
    position: relative;
    overflow: hidden;
}

.db-stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 4px;
    background: var(--card-color);
    opacity: 0.8;
}

.db-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
}

.db-stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    flex-shrink: 0;
    background: var(--icon-bg);
    color: var(--card-color);
}

.db-stat-info { display: flex; flex-direction: column; }
.db-stat-val { font-size: 28px; font-weight: 800; color: #0f172a; line-height: 1.1; }
.db-stat-label { font-size: 13px; font-weight: 600; color: #64748b; margin-top: 6px; text-transform: uppercase; letter-spacing: 0.5px; }

/* ── CHARTS & TABLES SECTION ── */
.db-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
    margin-bottom: 24px;
}
@media(max-width: 1200px) { .db-layout { grid-template-columns: 1fr; } }

.db-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(0,0,0,0.02);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.db-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.db-card-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 10px;
}
.db-card-title i { color: #3b82f6; font-size: 18px; }

.db-card-link {
    font-size: 13px;
    font-weight: 600;
    color: #3b82f6;
    text-decoration: none;
    transition: color 0.2s;
}
.db-card-link:hover { color: #1d4ed8; text-decoration: underline; }

.db-card-body { padding: 24px; flex: 1; }
.db-card-body.no-pad { padding: 0; }

/* ── TABLES ── */
.db-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.db-table th {
    background: #f8fafc;
    padding: 14px 24px;
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}
.db-table td {
    padding: 16px 24px;
    font-size: 14px;
    color: #1e293b;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.db-table tr:last-child td { border-bottom: none; }
.db-table tr:hover td { background: #f8fafc; }

.db-order-link { font-weight: 700; color: #0f172a; text-decoration: none; transition: color 0.2s; }
.db-order-link:hover { color: #3b82f6; }
.db-order-meta { font-size: 12px; color: #64748b; margin-top: 2px; }

/* ── STATUS BADGES ── */
.db-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.3px;
}
.badge-pending { background: #fef3c7; color: #d97706; }
.badge-processing { background: #e0f2fe; color: #0284c7; }
.badge-completed { background: #dcfce7; color: #16a34a; }
.badge-cancelled { background: #fee2e2; color: #dc2626; }

/* ── SUMMARY GRID ── */
.db-summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 16px;
}
.db-summary-box {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    text-align: center;
    border: 1.5px solid #e2e8f0;
    text-decoration: none;
    transition: all 0.2s;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.db-summary-box:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.05); }
.db-summary-val { font-size: 28px; font-weight: 800; line-height: 1; margin-bottom: 8px; }
.db-summary-lbl { font-size: 13px; font-weight: 600; color: #64748b; }

.s-all { border-color: #cbd5e1; } .s-all:hover { border-color: #94a3b8; } .s-all .db-summary-val { color: #334155; }
.s-pen { border-color: #fde68a; background: #fffbeb; } .s-pen:hover { border-color: #fbbf24; } .s-pen .db-summary-val { color: #d97706; }
.s-pro { border-color: #bae6fd; background: #f0f9ff; } .s-pro:hover { border-color: #7dd3fc; } .s-pro .db-summary-val { color: #0284c7; }
.s-com { border-color: #bbf7d0; background: #f0fdf4; } .s-com:hover { border-color: #86efac; } .s-com .db-summary-val { color: #16a34a; }
.s-can { border-color: #fecaca; background: #fef2f2; } .s-can:hover { border-color: #fca5a5; } .s-can .db-summary-val { color: #dc2626; }
</style>

<div class="db-page">
    {{-- HEADER --}}
    <div class="db-header">
        <div>
            <h1>Dashboard Overview</h1>
            <p>Welcome back, {{ auth()->user()->name }}! Here's what's happening today.</p>
        </div>
        <div style="font-size: 14px; font-weight: 600; color: #64748b; background: #fff; padding: 10px 16px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <i class="bi bi-calendar3 me-2"></i> {{ date('d M Y, l') }}
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="db-stats-grid">
        <div class="db-stat-card" style="--card-color: #f59e0b; --icon-bg: #fef3c7;">
            <div class="db-stat-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">{{ number_format($ordersPending) }}</div>
                <div class="db-stat-label">Pending Orders</div>
            </div>
        </div>
        <div class="db-stat-card" style="--card-color: #3b82f6; --icon-bg: #dbeafe;">
            <div class="db-stat-icon"><i class="bi bi-arrow-repeat"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">{{ number_format($ordersProcessing) }}</div>
                <div class="db-stat-label">Processing Orders</div>
            </div>
        </div>
        <div class="db-stat-card" style="--card-color: #10b981; --icon-bg: #d1fae5;">
            <div class="db-stat-icon"><i class="bi bi-check2-circle"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">{{ number_format($ordersCompleted) }}</div>
                <div class="db-stat-label">Completed Orders</div>
            </div>
        </div>
        <div class="db-stat-card" style="--card-color: #8b5cf6; --icon-bg: #ede9fe;">
            <div class="db-stat-icon"><i class="bi bi-boxes"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">{{ number_format($totalProducts) }}</div>
                <div class="db-stat-label">Total Products</div>
            </div>
        </div>
        <div class="db-stat-card" style="--card-color: #ec4899; --icon-bg: #fce7f3;">
            <div class="db-stat-icon"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">৳{{ number_format($salesLast30) }}</div>
                <div class="db-stat-label">Sales (30 Days)</div>
            </div>
        </div>
        <div class="db-stat-card" style="--card-color: #14b8a6; --icon-bg: #ccfbf1;">
            <div class="db-stat-icon"><i class="bi bi-trophy"></i></div>
            <div class="db-stat-info">
                <div class="db-stat-val">৳{{ number_format($salesAllTime) }}</div>
                <div class="db-stat-label">Total Sales (All Time)</div>
            </div>
        </div>
    </div>

    {{-- CHART AND POPULAR PRODUCTS --}}
    <div class="db-layout">
        {{-- Chart --}}
        <div class="db-card">
            <div class="db-card-header">
                <h5 class="db-card-title"><i class="bi bi-activity"></i> Last 30 Days Sales Trend</h5>
            </div>
            <div class="db-card-body">
                <canvas id="salesChart" style="width: 100%; max-height: 320px;"></canvas>
            </div>
        </div>

        {{-- Popular Products --}}
        <div class="db-card">
            <div class="db-card-header">
                <h5 class="db-card-title"><i class="bi bi-fire" style="color: #ef4444;"></i> Popular Products</h5>
            </div>
            <div class="db-card-body no-pad" style="overflow-y: auto; max-height: 368px;">
                @if($popularProducts->isEmpty())
                    <div style="text-align: center; padding: 40px; color: #94a3b8;">
                        <i class="bi bi-box-seam" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                        কোনো পণ্য নেই।
                    </div>
                @else
                    <table class="db-table">
                        <tbody>
                            @foreach($popularProducts as $i => $product)
                            <tr>
                                <td style="width: 40px; font-weight: 800; color: #cbd5e1; font-size: 16px;">#{{ $i + 1 }}</td>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a; font-size: 13px;">{{ $product->name }}</div>
                                    @if($product->price)
                                        <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 2px;">৳{{ number_format($product->price, 0) }}</div>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <span style="background: #f1f5f9; color: #3b82f6; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 700;">
                                        {{ $product->order_items_count }} Sold
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

    {{-- RECENT ORDERS & STATUS SUMMARY --}}
    <div class="db-layout" style="grid-template-columns: 1fr;">
        
        {{-- Status Summary --}}
        <div class="db-card" style="margin-bottom: 24px;">
            <div class="db-card-header">
                <h5 class="db-card-title"><i class="bi bi-pie-chart-fill" style="color: #8b5cf6;"></i> Order Status Summary</h5>
            </div>
            <div class="db-card-body">
                <div class="db-summary-grid">
                    <a href="{{ route('admin.order.allorder') }}" class="db-summary-box s-all">
                        <div class="db-summary-val">{{ number_format($statusCounts['all']) }}</div>
                        <div class="db-summary-lbl">All Orders</div>
                    </a>
                    <a href="{{ route('admin.order.allorder', ['status' => 'pending']) }}" class="db-summary-box s-pen">
                        <div class="db-summary-val">{{ number_format($statusCounts['pending']) }}</div>
                        <div class="db-summary-lbl"><i class="bi bi-hourglass-split"></i> Pending</div>
                    </a>
                    <a href="{{ route('admin.order.allorder', ['status' => 'processing']) }}" class="db-summary-box s-pro">
                        <div class="db-summary-val">{{ number_format($statusCounts['processing']) }}</div>
                        <div class="db-summary-lbl"><i class="bi bi-arrow-repeat"></i> Processing</div>
                    </a>
                    <a href="{{ route('admin.order.allorder', ['status' => 'completed']) }}" class="db-summary-box s-com">
                        <div class="db-summary-val">{{ number_format($statusCounts['completed']) }}</div>
                        <div class="db-summary-lbl"><i class="bi bi-check2-circle"></i> Completed</div>
                    </a>
                    <a href="{{ route('admin.order.allorder', ['status' => 'cancelled']) }}" class="db-summary-box s-can">
                        <div class="db-summary-val">{{ number_format($statusCounts['cancelled']) }}</div>
                        <div class="db-summary-lbl"><i class="bi bi-x-circle"></i> Cancelled</div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="db-card">
            <div class="db-card-header">
                <h5 class="db-card-title"><i class="bi bi-receipt-cutoff" style="color: #10b981;"></i> Recent Orders</h5>
                <a href="{{ route('admin.order.allorder') }}" class="db-card-link">View All Orders &rarr;</a>
            </div>
            <div class="db-card-body no-pad">
                @if($recentOrders->isEmpty())
                    <div style="text-align: center; padding: 40px; color: #94a3b8;">
                        <i class="bi bi-inbox" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                        কোনো অর্ডার নেই।
                    </div>
                @else
                    <div style="overflow-x: auto;">
                        <table class="db-table">
                            <thead>
                                <tr>
                                    <th>Order Info</th>
                                    <th>Customer Details</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th style="text-align: right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.order.show', $order->id) }}" class="db-order-link">
                                            #{{ $order->order_number }}
                                        </a>
                                        <div class="db-order-meta">{{ $order->items->count() }} Items • {{ $order->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; color: #1e293b;">{{ $order->customer_name }}</div>
                                        <div style="font-size: 12px; color: #64748b;">{{ $order->customer_phone ?? 'No Phone' }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 800; color: #0f172a;">৳{{ number_format($order->total, 0) }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $statusConfig = [
                                                'pending'    => ['class' => 'badge-pending', 'label' => 'Pending'],
                                                'processing' => ['class' => 'badge-processing', 'label' => 'Processing'],
                                                'completed'  => ['class' => 'badge-completed', 'label' => 'Completed'],
                                                'cancelled'  => ['class' => 'badge-cancelled', 'label' => 'Cancelled'],
                                            ];
                                            $cfg = $statusConfig[$order->order_status] ?? ['class' => '', 'label' => ucfirst($order->order_status)];
                                        @endphp
                                        <span class="db-badge {{ $cfg['class'] }}">{{ $cfg['label'] }}</span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('admin.order.show', $order->id) }}" style="background: #f1f5f9; color: #3b82f6; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-block; transition: all 0.2s;">
                                            Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Create gradient for chart
    let gradient = ctx.createLinearGradient(0, 0, 0, 320);
    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
    gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Completed Orders',
                data: @json($chartData),
                borderColor: '#3b82f6',
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleFont: { size: 13, family: "'Plus Jakarta Sans', sans-serif" },
                    bodyFont: { size: 14, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return '৳' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { 
                        stepSize: 1, 
                        font: { size: 12, family: "'Plus Jakarta Sans', sans-serif" },
                        color: '#64748b'
                    },
                    grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false }
                },
                x: {
                    ticks: { 
                        font: { size: 11, family: "'Plus Jakarta Sans', sans-serif" },
                        color: '#64748b',
                        maxRotation: 45
                    },
                    grid: { display: false, drawBorder: false }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
        }
    });
});
</script>
@endsection
