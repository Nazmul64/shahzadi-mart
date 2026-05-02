@extends('emplee.master')
@section('title', 'Purchase Summary')
@section('main-content')
<style>
body{background:#f5f7fa;}
.pur-wrap{padding:24px 28px;min-height:100vh;background:#f5f7fa;font-family:'Segoe UI',sans-serif;}
.filter-bar{background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap;}
.flt-item{display:flex;flex-direction:column;gap:4px;}
.flt-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:#9ca3af;}
.flt-item select,.flt-item input{border:1px solid #d1d5db;border-radius:6px;padding:7px 11px;font-size:13px;color:#374151;background:#fff;outline:none;min-width:140px;}
.flt-item select:focus,.flt-item input:focus{border-color:#e91e8c;}
.btn-filter{background:#e91e8c;color:#fff;border:none;border-radius:6px;padding:9px 16px;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px;}
.btn-filter:hover{background:#c4176f;}
.btn-reset{background:#374151;color:#fff;border:none;border-radius:6px;padding:9px 12px;font-size:13px;cursor:pointer;display:inline-flex;align-items:center;}
.btn-reset:hover{background:#111827;}
.pur-card{background:#fff;border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.06);}
table.sm-table{width:100%;border-collapse:collapse;}
table.sm-table th{background:#f9fafb;padding:12px 16px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#6b7280;border-bottom:2px solid #e5e7eb;text-align:left;}
table.sm-table td{padding:12px 16px;font-size:14px;color:#374151;border-bottom:1px solid #f3f4f6;vertical-align:middle;}
table.sm-table tbody tr:hover td{background:#fafafa;}
table.sm-table tbody tr:last-child td{border-bottom:none;}
.total-row td{background:#f9fafb;font-weight:700;color:#111827!important;border-top:2px solid #e5e7eb!important;border-bottom:none!important;}
</style>

<div class="pur-wrap">
    <form class="filter-bar" method="GET" action="{{ route('emplee.purchases.summary') }}">
        <div class="flt-item" style="flex:1;min-width:200px;">
            <label class="flt-label">Choose Product</label>
            <select name="product_id">
                <option value="">Select Product</option>
                @foreach($products as $p)
                <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected':'' }}>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flt-item">
            <label class="flt-label">Choose Purchase</label>
            <select name="purchase_id">
                <option value="">Select Pur...</option>
                @foreach($purchases as $pur)
                <option value="{{ $pur->id }}" {{ request('purchase_id') == $pur->id ? 'selected':'' }}>{{ $pur->purchase_number }}</option>
                @endforeach
            </select>
        </div>
        <div class="flt-item">
            <label class="flt-label">Choose Supplier</label>
            <select name="supplier_id">
                <option value="">Select Su...</option>
                @foreach($suppliers as $sup)
                <option value="{{ $sup->id }}" {{ request('supplier_id') == $sup->id ? 'selected':'' }}>{{ $sup->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flt-item">
            <label class="flt-label">From</label>
            <input type="date" name="from" value="{{ request('from', \Carbon\Carbon::now()->subMonth()->format('Y-m-d')) }}">
        </div>
        <div class="flt-item">
            <label class="flt-label">To</label>
            <input type="date" name="to" value="{{ request('to', \Carbon\Carbon::now()->format('Y-m-d')) }}">
        </div>
        <div style="display:flex;gap:6px;align-self:flex-end;">
            <button type="submit" class="btn-filter">
                <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20"><path d="M3 3h14l-5 6v5l-4 2V9L3 3z"/></svg>
                Filter
            </button>
            <a href="{{ route('emplee.purchases.summary') }}" class="btn-reset" title="Reset">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/></svg>
            </a>
        </div>
    </form>

    <div class="pur-card">
        <table class="sm-table">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Purchase Name</th>
                    <th>Products</th>
                    <th>Price</th>
                    <th>Total Stock Add</th>
                </tr>
            </thead>
            <tbody>
                @php $totalStock = 0; @endphp
                @forelse($items as $i => $item)
                @php $totalStock += $item->quantity; @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->purchase->title ?? $item->purchase->purchase_number ?? '—' }}</td>
                    <td>{{ $item->product->name ?? '—' }}</td>
                    <td>৳{{ number_format($item->total_price, 2) }}</td>
                    <td>{{ number_format($item->quantity) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:50px;color:#9ca3af;">No data found.</td>
                </tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="4" style="text-align:right;padding-right:12px;">Total</td>
                    <td><strong>{{ number_format($totalStock) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
