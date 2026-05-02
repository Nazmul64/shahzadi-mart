<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice — {{ $purchase->purchase_number }}</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Segoe UI',Arial,sans-serif;background:#fff;color:#1f2937;font-size:14px;}
.page{width:794px;min-height:1123px;margin:0 auto;padding:48px;}
.inv-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:40px;padding-bottom:24px;border-bottom:2px solid #e5e7eb;}
.inv-brand{font-size:24px;font-weight:800;color:#111827;letter-spacing:-0.5px;}
.inv-brand-sub{font-size:12px;color:#6b7280;margin-top:2px;}
.inv-badge{display:inline-block;background:#e91e8c;color:#fff;padding:6px 18px;border-radius:6px;font-size:16px;font-weight:700;letter-spacing:1px;}
.meta-grid{display:grid;grid-template-columns:1fr 1fr;gap:0;margin-bottom:32px;}
.meta-box{padding:16px 20px;background:#f9fafb;border:1px solid #e5e7eb;}
.meta-box:first-child{border-radius:8px 0 0 8px;}
.meta-box:last-child{border-radius:0 8px 8px 0;border-left:none;}
.meta-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#9ca3af;margin-bottom:6px;}
.meta-value{font-size:14px;font-weight:600;color:#111827;}
.meta-value.big{font-size:20px;color:#e91e8c;}
.section-title{font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#6b7280;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #e5e7eb;}
table.inv-table{width:100%;border-collapse:collapse;margin-bottom:24px;}
table.inv-table th{background:#1f2937;color:#fff;padding:10px 14px;font-size:12px;font-weight:600;text-align:left;letter-spacing:.4px;}
table.inv-table td{padding:11px 14px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#374151;}
table.inv-table tbody tr:last-child td{border-bottom:none;}
table.inv-table tbody tr:nth-child(even) td{background:#fafafa;}
.total-section{display:flex;justify-content:flex-end;margin-bottom:32px;}
.total-box{background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:16px 24px;min-width:260px;}
.total-row{display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #f3f4f6;font-size:13px;color:#6b7280;}
.total-row:last-child{border-bottom:none;padding-top:10px;font-size:16px;font-weight:700;color:#111827;}
.inv-footer{margin-top:auto;padding-top:32px;border-top:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:flex-end;}
.status-badge{display:inline-block;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;}
.status-received{background:#d1fae5;color:#065f46;}
.status-pending{background:#fef3c7;color:#92400e;}
.slip-img{width:120px;height:90px;object-fit:cover;border-radius:6px;border:1px solid #e5e7eb;}
@media print{
    body{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
    .page{width:100%;padding:24px;}
    .no-print{display:none!important;}
}
</style>
</head>
<body onload="window.print()">
<div class="page">

    {{-- Header --}}
    <div class="inv-header">
        <div>
            <div class="inv-brand">Shahzadi Mart</div>
            <div class="inv-brand-sub">Purchase Management System</div>
        </div>
        <div style="text-align:right;">
            <div class="inv-badge">INVOICE</div>
            <div style="margin-top:8px;font-size:13px;color:#6b7280;">
                #{{ $purchase->purchase_number }}<br>
                Issued: {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}
            </div>
        </div>
    </div>

    {{-- Meta --}}
    <div class="meta-grid">
        <div class="meta-box">
            <div class="meta-label">Supplier</div>
            <div class="meta-value">{{ $purchase->supplier->name ?? '—' }}</div>
            @if($purchase->supplier && $purchase->supplier->company_name)
            <div style="font-size:12px;color:#6b7280;margin-top:2px;">{{ $purchase->supplier->company_name }}</div>
            @endif
            @if($purchase->supplier && $purchase->supplier->phone)
            <div style="font-size:12px;color:#6b7280;">{{ $purchase->supplier->phone }}</div>
            @endif
        </div>
        <div class="meta-box" style="text-align:right;">
            <div class="meta-label">Purchase Info</div>
            <div class="meta-value">{{ $purchase->title ?? $purchase->purchase_number }}</div>
            <div style="font-size:12px;color:#6b7280;margin-top:4px;">
                Status: <span class="status-badge {{ $purchase->status === 'received' ? 'status-received' : 'status-pending' }}">{{ ucfirst($purchase->status) }}</span>
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="section-title">Product List</div>
    <table class="inv-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchase->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                <td>{{ number_format($item->quantity) }}</td>
                <td>৳{{ number_format($item->unit_price, 2) }}</td>
                <td>৳{{ number_format($item->total_price, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:20px;color:#9ca3af;">No items found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Totals --}}
    <div class="total-section">
        <div class="total-box">
            <div class="total-row">
                <span>Subtotal</span>
                <span>৳{{ number_format($purchase->total_amount, 2) }}</span>
            </div>
            <div class="total-row">
                <span><strong>Grand Total</strong></span>
                <span><strong>৳{{ number_format($purchase->total_amount, 2) }}</strong></span>
            </div>
        </div>
    </div>

    @if($purchase->notes)
    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:12px 16px;margin-bottom:24px;">
        <div class="meta-label" style="margin-bottom:4px;">Notes</div>
        <div style="font-size:13px;color:#6b7280;">{{ $purchase->notes }}</div>
    </div>
    @endif

    {{-- Footer --}}
    <div class="inv-footer">
        <div>
            <div style="font-size:11px;color:#9ca3af;margin-bottom:4px;">Generated on {{ now()->format('d M Y, h:i A') }}</div>
            <div style="font-size:12px;color:#6b7280;">Shahzadi Mart — Purchase Management</div>
        </div>
        @if($purchase->lot_slip_image)
        <div>
            <div class="meta-label" style="margin-bottom:4px;">Lot Slip</div>
            <img src="{{ public_path('uploads/purchase/' . $purchase->lot_slip_image) }}" alt="Lot Slip" class="slip-img">
        </div>
        @endif
    </div>
</div>
</body>
</html>
