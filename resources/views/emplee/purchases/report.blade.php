@extends('emplee.master')

@section('title', 'Stock Report')

@section('main-content')
<style>
:root { --pur-bg:#0f172a; --pur-card:#1e293b; --pur-border:rgba(255,255,255,0.07); --pur-accent:#3b82f6; --pur-accent2:#8b5cf6; --pur-green:#10b981; --pur-red:#ef4444; --pur-warn:#f59e0b; --pur-text:#94a3b8; --pur-heading:#f1f5f9; }
.pm-wrap { padding:28px 32px; min-height:100vh; background:var(--pur-bg); font-family:'Plus Jakarta Sans','Segoe UI',sans-serif; }
.pm-title { font-size:24px; font-weight:800; color:var(--pur-heading); display:flex; align-items:center; gap:12px; margin-bottom:28px; }
.pm-title i { width:44px; height:44px; background:linear-gradient(135deg,var(--pur-accent),var(--pur-accent2)); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; color:#fff; box-shadow:0 4px 16px rgba(59,130,246,.35); }
.pm-filter { background:var(--pur-card); border:1px solid var(--pur-border); border-radius:12px; padding:18px 22px; margin-bottom:22px; display:flex; gap:14px; flex-wrap:wrap; align-items:flex-end; }
.pm-filter select, .pm-filter input { background:rgba(255,255,255,0.04); border:1px solid var(--pur-border); border-radius:8px; color:var(--pur-heading); padding:9px 14px; font-size:13px; outline:none; min-width:160px; }
.pm-filter select option { background:#1e293b; }
.pm-btn { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:10px; font-size:14px; font-weight:600; text-decoration:none; transition:all .2s; cursor:pointer; border:none; }
.pm-btn-info { background:rgba(59,130,246,.15); color:var(--pur-accent); border:1px solid rgba(59,130,246,.25); }
.pm-btn-info:hover { background:var(--pur-accent); color:#fff; }
.pm-btn-ghost { background:rgba(255,255,255,.05); color:var(--pur-text); border:1px solid var(--pur-border); }
.pm-btn-ghost:hover { background:rgba(255,255,255,.1); color:var(--pur-heading); }
.pm-card { background:var(--pur-card); border:1px solid var(--pur-border); border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.2); }
.pm-table { width:100%; border-collapse:collapse; }
.pm-table thead th { background:rgba(0,0,0,.3); padding:14px 18px; font-size:12px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.8px; border-bottom:1px solid var(--pur-border); text-align:left; }
.pm-table tbody tr { border-bottom:1px solid var(--pur-border); transition:background .2s; }
.pm-table tbody tr:hover { background:rgba(255,255,255,0.02); }
.pm-table tbody tr:last-child { border-bottom:none; }
.pm-table td { padding:14px 18px; font-size:14px; color:var(--pur-text); vertical-align:middle; }
.pm-table td strong { color:var(--pur-heading); }
.chip-in { background:rgba(16,185,129,.12); color:var(--pur-green); border:1px solid rgba(16,185,129,.25); padding:3px 10px; border-radius:20px; font-size:12px; font-weight:700; }
.chip-out { background:rgba(239,68,68,.12); color:var(--pur-red); border:1px solid rgba(239,68,68,.25); padding:3px 10px; border-radius:20px; font-size:12px; font-weight:700; }
.chip-stock { background:rgba(59,130,246,.12); color:var(--pur-accent); border:1px solid rgba(59,130,246,.25); padding:3px 10px; border-radius:20px; font-size:12px; font-weight:700; }
.pm-empty { text-align:center; padding:60px 20px; color:var(--pur-text); }
.pm-empty i { font-size:48px; opacity:.3; display:block; margin-bottom:14px; }
.pm-filter label { font-size:11px; color:#64748b; display:block; margin-bottom:5px; font-weight:700; text-transform:uppercase; }
</style>

<div class="pm-wrap">
    <div class="pm-title">
        <i class="bi bi-graph-up-arrow"></i>
        Stock Report
    </div>

    <form class="pm-filter" method="GET" action="{{ route('emplee.purchases.report') }}">
        <div>
            <label>Product</label>
            <select name="product_id">
                <option value="">All Products</option>
                @foreach($allProducts as $product)
                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>From Date</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}">
        </div>
        <div>
            <label>To Date</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}">
        </div>
        <button type="submit" class="pm-btn pm-btn-info"><i class="bi bi-funnel"></i> Filter</button>
        <a href="{{ route('emplee.purchases.report') }}" class="pm-btn pm-btn-ghost"><i class="bi bi-x-lg"></i> Clear</a>
    </form>

    <div class="pm-card">
        <table class="pm-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Purchased (In)</th>
                    <th>Sold (Out)</th>
                    <th>Current Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $p['name'] }}</strong></td>
                    <td><span class="chip-in">+{{ number_format($p['purchased']) }}</span></td>
                    <td><span class="chip-out">-{{ number_format($p['sold']) }}</span></td>
                    <td><span class="chip-stock">{{ number_format($p['stock']) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5">
                    <div class="pm-empty">
                        <i class="bi bi-clipboard-data"></i>
                        No data available.
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
