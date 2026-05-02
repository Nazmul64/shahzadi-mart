@extends('admin.master')
@section('title', 'Purchase Invoices')
@section('main-content')
<style>
body { background:#f5f7fa; }
.pur-wrap { padding:24px 28px; min-height:100vh; background:#f5f7fa; font-family:'Segoe UI',sans-serif; }
.pur-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px; }
.pur-page-title { font-size:20px; font-weight:700; color:#111827; }
.pur-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border-radius:7px; font-size:13px; font-weight:600; cursor:pointer; border:none; transition:all .2s; text-decoration:none; }
.pur-btn-pink { background:#e91e8c; color:#fff; }
.pur-btn-pink:hover { background:#c4176f; color:#fff; }
.pur-btn-sm { padding:5px 11px; font-size:12px; border-radius:5px; }
.pur-btn-info { background:#dbeafe; color:#1d4ed8; }
.pur-btn-info:hover { background:#1d4ed8; color:#fff; }
.pur-btn-danger { background:#fee2e2; color:#ef4444; border:1px solid #fecaca; }
.pur-btn-danger:hover { background:#ef4444; color:#fff; }
.pur-btn-excel { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; }
.pur-btn-excel:hover { background:#10b981; color:#fff; }
.filter-card { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:16px 20px; margin-bottom:18px; display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; }
.filter-card select, .filter-card input { border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; font-size:13px; color:#374151; background:#fff; min-width:150px; outline:none; }
.filter-card select:focus,.filter-card input:focus{border-color:#e91e8c;}
.filter-card label{font-size:11px;font-weight:700;text-transform:uppercase;color:#9ca3af;display:block;margin-bottom:4px;}
.pur-card { background:#fff; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,.06); }
table.pur-table { width:100%; border-collapse:collapse; }
table.pur-table th { background:#f9fafb; padding:12px 16px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#6b7280; border-bottom:1px solid #e5e7eb; text-align:left; }
table.pur-table td { padding:13px 16px; font-size:14px; color:#374151; border-bottom:1px solid #f3f4f6; vertical-align:middle; }
table.pur-table tr:last-child td { border-bottom:none; }
table.pur-table tr:hover td { background:#fafafa; }
.badge { padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.badge-pending { background:#fef3c7; color:#92400e; }
.badge-received { background:#d1fae5; color:#065f46; }
.badge-cancelled { background:#fee2e2; color:#991b1b; }
.pur-alert{padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;font-weight:500;}
.pur-alert-success{background:#d1fae5;color:#065f46;border:1px solid #a7f3d0;}
.pur-alert-error{background:#fee2e2;color:#991b1b;border:1px solid #fecaca;}
</style>

<div class="pur-wrap">
    <div class="pur-top">
        <div class="pur-page-title">Purchase Invoices</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('admin.purchases.export', request()->all()) }}" class="pur-btn pur-btn-excel">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/></svg>
                Export Excel
            </a>
            <a href="{{ route('admin.purchases.create') }}" class="pur-btn pur-btn-pink">
                + New Purchase
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="pur-alert pur-alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="pur-alert pur-alert-error">{{ session('error') }}</div>
    @endif

    <form class="filter-card" method="GET" action="{{ route('admin.purchases.index') }}">
        <div>
            <label>Supplier</label>
            <select name="supplier_id">
                <option value="">All Suppliers</option>
                @foreach($suppliers as $sup)
                <option value="{{ $sup->id }}" {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Status</label>
            <select name="status">
                <option value="">All Status</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                <option value="received" {{ request('status')=='received' ? 'selected' : '' }}>Received</option>
                <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div style="display:flex;gap:8px;align-items:flex-end;">
            <button type="submit" class="pur-btn pur-btn-pink" style="padding:9px 16px;">Filter</button>
            <a href="{{ route('admin.purchases.index') }}" class="pur-btn" style="background:#6b7280;color:#fff;padding:9px 14px;">Reset</a>
        </div>
    </form>

    <div class="pur-card">
        <table class="pur-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Purchase #</th>
                    <th>Supplier</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $purchase)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $purchase->purchase_number }}</strong></td>
                    <td>{{ $purchase->supplier->name ?? '—' }}</td>
                    <td>{{ $purchase->title ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('m/d/Y') }}</td>
                    <td><strong>৳{{ number_format($purchase->total_amount, 2) }}</strong></td>
                    <td>
                        @if($purchase->status==='received')<span class="badge badge-received">Received</span>
                        @elseif($purchase->status==='pending')<span class="badge badge-pending">Pending</span>
                        @else<span class="badge badge-cancelled">Cancelled</span>@endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.purchases.show', $purchase->id) }}" class="pur-btn pur-btn-sm pur-btn-info">View</a>
                            <a href="{{ route('admin.purchases.pdf', $purchase->id) }}" target="_blank" class="pur-btn pur-btn-sm" style="background:#d1fae5;color:#065f46;">PDF</a>
                            @if($purchase->status !== 'received')
                            <form action="{{ route('admin.purchases.destroy', $purchase->id) }}" method="POST"
                                onsubmit="return confirm('Delete this purchase?')">
                                @csrf @method('DELETE')
                                <button class="pur-btn pur-btn-sm pur-btn-danger" type="submit">Delete</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;padding:50px;color:#9ca3af;">No purchases found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;">{{ $purchases->links() }}</div>
</div>
@endsection
