@extends('manager.master')
@section('title', 'Purchase Return Create')
@section('main-content')
<style>
body{background:#f5f7fa;}
.pur-wrap{padding:24px 28px;min-height:100vh;background:#f5f7fa;font-family:'Segoe UI',sans-serif;}
.pur-page-title{font-size:20px;font-weight:700;color:#111827;margin-bottom:20px;}
.search-card{background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:18px 22px;margin-bottom:20px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;}
.search-input{flex:1;min-width:280px;border:1px solid #d1d5db;border-radius:6px;padding:9px 14px;font-size:14px;color:#374151;outline:none;}
.search-input:focus{border-color:#e91e8c;}
.btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:7px;font-size:13px;font-weight:600;cursor:pointer;border:none;transition:all .2s;text-decoration:none;}
.btn-pink{background:#e91e8c;color:#fff;}
.btn-pink:hover{background:#c4176f;}
.btn-green{background:#10b981;color:#fff;}
.btn-green:hover{background:#059669;}
.btn-cancel{background:#fff;color:#6b7280;border:1px solid #d1d5db;}
.btn-cancel:hover{background:#f3f4f6;}
.pur-card{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:28px;box-shadow:0 1px 4px rgba(0,0,0,.06);margin-bottom:20px;}
.pur-label{font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;display:block;}
.pur-input{width:100%;border:1px solid #d1d5db;border-radius:6px;padding:9px 12px;font-size:14px;color:#374151;background:#fff;box-sizing:border-box;font-family:inherit;outline:none;}
.pur-input:focus{border-color:#e91e8c;}
.pur-input option{background:#fff;}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;}
.form-full{grid-column:1/-1;}
.form-footer{display:flex;justify-content:space-between;align-items:center;margin-top:24px;padding-top:20px;border-top:1px solid #f3f4f6;}
.pur-alert{padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;font-weight:500;}
.pur-alert-success{background:#d1fae5;color:#065f46;border:1px solid #a7f3d0;}
.purchase-info{background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:16px 20px;margin-bottom:20px;}
.pi-label{font-size:11px;font-weight:700;text-transform:uppercase;color:#9ca3af;margin-bottom:3px;}
.pi-value{font-size:14px;font-weight:600;color:#111827;}
.pi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;}
table.rt-table{width:100%;border-collapse:collapse;}
table.rt-table th{background:#f9fafb;padding:11px 14px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:#6b7280;border-bottom:2px solid #e5e7eb;text-align:left;}
table.rt-table td{padding:12px 14px;font-size:13px;color:#374151;border-bottom:1px solid #f3f4f6;vertical-align:middle;}
table.rt-table tr:last-child td{border-bottom:none;}
.qty-input{width:80px;border:1px solid #d1d5db;border-radius:5px;padding:5px 8px;font-size:13px;text-align:center;outline:none;}
.qty-input:focus{border-color:#e91e8c;}
.not-found{text-align:center;padding:30px;color:#9ca3af;font-size:13px;}
</style>

<div class="pur-wrap">
    <div class="pur-page-title">Purchase Return Create</div>

    @if(session('success'))
    <div class="pur-alert pur-alert-success">{{ session('success') }}</div>
    @endif

    {{-- Search --}}
    <form method="GET" action="{{ route('manager.purchase-returns.create') }}">
        <div class="search-card">
            <input type="text" name="invoice" class="search-input"
                placeholder="Search by invoice or barcode"
                value="{{ request('invoice') }}">
            <button type="submit" class="btn btn-pink">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
                </svg>
                Search
            </button>
            <a href="{{ route('manager.purchase-returns.create') }}" class="btn btn-green">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                </svg>
                Reset
            </a>
        </div>
    </form>

    @if($purchase)
    {{-- Purchase Info --}}
    <div class="purchase-info">
        <div class="pi-grid">
            <div>
                <div class="pi-label">Invoice #</div>
                <div class="pi-value">{{ $purchase->purchase_number }}</div>
            </div>
            <div>
                <div class="pi-label">Supplier</div>
                <div class="pi-value">{{ $purchase->supplier->name ?? '—' }}</div>
            </div>
            <div>
                <div class="pi-label">Date</div>
                <div class="pi-value">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('m/d/Y') }}</div>
            </div>
            <div>
                <div class="pi-label">Total</div>
                <div class="pi-value">৳{{ number_format($purchase->total_amount, 2) }}</div>
            </div>
        </div>
    </div>

    {{-- Return Form --}}
    <form action="{{ route('manager.purchase-returns.store') }}" method="POST">
        @csrf
        <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
        <input type="hidden" name="supplier_id" value="{{ $purchase->supplier_id }}">

        {{-- Product List with return qty --}}
        <div class="pur-card" style="padding:0;overflow:hidden;margin-bottom:20px;">
            <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;font-size:15px;font-weight:700;color:#111827;">
                Product List
            </div>
            <table class="rt-table">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Product</th>
                        <th>Purchased Qty</th>
                        <th>Unit Price</th>
                        <th>Return Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchase->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->name ?? '—' }}</td>
                        <td>{{ number_format($item->quantity) }}</td>
                        <td>৳{{ number_format($item->unit_price, 2) }}</td>
                        <td>
                            <input type="number" name="return_qty[{{ $item->id }}]"
                                class="qty-input" placeholder="0"
                                min="0" max="{{ $item->quantity }}" value="0">
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="not-found">No products in this purchase.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pur-card">
            <div class="form-grid">
                <div>
                    <label class="pur-label">Return Amount (৳)</label>
                    <input type="number" name="amount" class="pur-input"
                        placeholder="0.00" step="0.01" min="0" required
                        value="{{ old('amount') }}">
                </div>
                <div>
                    <label class="pur-label">Total Products</label>
                    <input type="number" name="total_product" class="pur-input"
                        placeholder="0" min="0"
                        value="{{ old('total_product', $purchase->items->count()) }}" readonly>
                </div>
                <div class="form-full">
                    <label class="pur-label">Reason</label>
                    <textarea name="reason" class="pur-input" rows="3"
                        placeholder="Reason for return...">{{ old('reason') }}</textarea>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('manager.purchase-returns.index') }}" class="btn btn-cancel">Cancel</a>
                <button type="submit" class="btn btn-pink">Submit Return</button>
            </div>
        </div>
    </form>

    @elseif(request()->filled('invoice'))
    <div class="pur-card" style="text-align:center;padding:40px;color:#9ca3af;">
        <svg width="40" height="40" fill="none" viewBox="0 0 24 24" style="margin:0 auto 12px;opacity:.3;display:block;">
            <circle cx="11" cy="11" r="8" stroke="#9ca3af" stroke-width="2"/>
            <path d="m21 21-4.35-4.35" stroke="#9ca3af" stroke-width="2" stroke-linecap="round"/>
        </svg>
        No received purchase found for "<strong>{{ request('invoice') }}</strong>".
    </div>
    @endif
</div>
@endsection
