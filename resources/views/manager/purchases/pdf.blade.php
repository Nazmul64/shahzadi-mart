<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Invoice — {{ $purchase->purchase_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f3f4f6; color: #111827; }

        .invoice-wrap { max-width: 850px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        
        /* Header section */
        .inv-header { padding: 40px; background: #111827; color: #fff; display: flex; justify-content: space-between; align-items: center; }
        .inv-brand { display: flex; align-items: center; gap: 14px; }
        .inv-logo-box { width: 50px; height: 50px; background: #e91e8c; color: #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; }
        .inv-brand-text h1 { font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -0.5px; line-height: 1.2; }
        .inv-brand-text p { font-size: 13px; color: #9ca3af; font-weight: 500; }
        
        .inv-title { text-align: right; }
        .inv-title h2 { font-size: 26px; font-weight: 800; color: #fff; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 4px; }
        .inv-title p { font-size: 14px; color: #e91e8c; font-weight: 600; }
        .inv-title .date { font-size: 12px; color: #9ca3af; margin-top: 4px; font-weight: 400; }

        /* Meta details */
        .inv-meta { display: flex; justify-content: space-between; gap: 30px; padding: 30px 40px; border-bottom: 2px solid #f3f4f6; }
        .meta-col { flex: 1; }
        .meta-label { font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; display: block; }
        .meta-text { font-size: 14px; color: #374151; line-height: 1.6; }
        .meta-text strong { color: #111827; font-size: 16px; display: block; margin-bottom: 4px; }
        
        .status-badge { display: inline-block; margin-top: 10px; padding: 4px 12px; background: #d1fae5; color: #065f46; font-size: 11px; font-weight: 800; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }

        /* Items Table */
        .inv-body { padding: 30px 40px; }
        table.inv-table { width: 100%; border-collapse: collapse; }
        table.inv-table thead th { background: #f9fafb; color: #4b5563; padding: 12px 16px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-align: left; border-bottom: 2px solid #e5e7eb; }
        table.inv-table thead th:last-child { text-align: right; }
        
        table.inv-table tbody td { padding: 16px; border-bottom: 1px solid #f3f4f6; font-size: 14px; color: #374151; vertical-align: middle; }
        table.inv-table tbody td:last-child { text-align: right; font-weight: 700; color: #111827; }
        table.inv-table tbody tr:last-child td { border-bottom: none; }
        
        .item-name { font-weight: 700; color: #111827; }

        /* Totals section */
        .inv-summary { display: flex; justify-content: space-between; align-items: flex-start; padding: 0 40px 40px; }
        .notes-info { background: #f9fafb; padding: 16px 20px; border-radius: 10px; border: 1px solid #e5e7eb; max-width: 350px; }
        .notes-info p { font-size: 13px; color: #4b5563; line-height: 1.5; }
        .notes-info p strong { color: #111827; display: block; margin-bottom: 4px; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        
        .totals-box { width: 300px; background: #f9fafb; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; }
        .totals-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; color: #4b5563; }
        .totals-divider { border-top: 1px solid #d1d5db; margin: 12px 0; }
        .totals-row.grand { font-size: 16px; font-weight: 800; color: #111827; padding-top: 4px; }
        .totals-row.grand span:last-child { color: #e91e8c; font-size: 20px; }

        /* Footer */
        .inv-footer { background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 24px 40px; display: flex; justify-content: space-between; align-items: center; }
        .inv-footer-text p { font-size: 12px; color: #6b7280; margin-bottom: 4px; }
        .inv-footer-text strong { color: #111827; }
        
        .slip-img { width: 100px; height: 75px; object-fit: cover; border-radius: 6px; border: 1px solid #d1d5db; }

        /* Print Controls */
        .print-ctrl { text-align: center; margin-top: 40px; }
        .btn { padding: 12px 28px; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all .2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary { background: #e91e8c; color: #fff; box-shadow: 0 4px 12px rgba(233,30,140,0.3); }
        .btn-primary:hover { background: #c2185b; transform: translateY(-2px); }
        .btn-secondary { background: #fff; color: #374151; border: 1px solid #d1d5db; margin-right: 12px; }
        .btn-secondary:hover { background: #f9fafb; }

        @media print {
            body { background: #fff; padding: 0; }
            .invoice-wrap { box-shadow: none; margin: 0; max-width: 100%; border-radius: 0; }
            .print-ctrl { display: none; }
            .inv-header { background: #fff; color: #000; border-bottom: 2px solid #000; padding: 20px 0; }
            .inv-brand-text h1, .inv-brand-text p, .inv-title h2, .inv-title p, .inv-title .date { color: #000; }
            .inv-logo-box { background: #000; color: #fff; }
            .inv-meta, .inv-body, .inv-summary, .inv-footer { padding-left: 0; padding-right: 0; }
            .inv-footer { background: #fff; border-top: 1px solid #000; }
            table.inv-table thead th { border-bottom: 2px solid #000; }
        }
    </style>
</head>
<body onload="window.print()">

<div class="print-ctrl">
    <button class="btn btn-secondary" onclick="window.close()">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
        Close Window
    </button>
    <button class="btn btn-primary" onclick="window.print()">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        Print Invoice
    </button>
</div>

<div class="invoice-wrap">
    
    {{-- Header --}}
    <div class="inv-header">
        <div class="inv-brand">
            <div class="inv-logo-box">SM</div>
            <div class="inv-brand-text">
                <h1>{{ config('app.name', 'Shahzadi Mart') }}</h1>
                <p>Purchase Management System</p>
            </div>
        </div>
        <div class="inv-title">
            <h2>PURCHASE INVOICE</h2>
            <p>#{{ $purchase->purchase_number }}</p>
            <div class="date">Issued: {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</div>
        </div>
    </div>

    {{-- Meta Details --}}
    <div class="inv-meta">
        <div class="meta-col">
            <span class="meta-label">Supplier Details</span>
            <div class="meta-text">
                <strong>{{ $purchase->supplier->name ?? '—' }}</strong>
                @if($purchase->supplier && $purchase->supplier->company_name)
                    {{ $purchase->supplier->company_name }}<br>
                @endif
                @if($purchase->supplier && $purchase->supplier->phone)
                    Phone: {{ $purchase->supplier->phone }}<br>
                @endif
                @if($purchase->supplier && $purchase->supplier->email)
                    Email: {{ $purchase->supplier->email }}
                @endif
            </div>
        </div>
        <div class="meta-col" style="text-align:right;">
            <span class="meta-label">Purchase Info</span>
            <div class="meta-text">
                <strong>{{ $purchase->title ?? 'Purchase Order' }}</strong>
                @php
                    $statusClass = 'status-pending';
                    if($purchase->status === 'received') $statusClass = '';
                    elseif($purchase->status === 'cancelled') $statusClass = 'status-cancelled';
                @endphp
                <div class="status-badge {{ $statusClass }}">
                    {{ ucfirst($purchase->status) }}
                </div>
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="inv-body">
        <table class="inv-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Product Item</th>
                    <th style="text-align: center;">Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchase->items as $item)
                <tr>
                    <td>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                    <td><div class="item-name">{{ $item->product->name ?? 'Deleted Product' }}</div></td>
                    <td style="text-align: center; font-weight: 600;">{{ number_format($item->quantity) }}</td>
                    <td>৳{{ number_format($item->unit_price, 2) }}</td>
                    <td>৳{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:40px;color:#9ca3af;">No products found in this purchase.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Summary & Totals --}}
    <div class="inv-summary">
        <div class="notes-info">
            <p><strong>Notes / Remarks</strong></p>
            @if($purchase->notes)
                <p>{{ $purchase->notes }}</p>
            @else
                <p style="color:#9ca3af;font-style:italic;">No additional notes provided for this purchase order.</p>
            @endif
        </div>
        
        <div class="totals-box">
            <div class="totals-row">
                <span>Total Items</span>
                <span>{{ $purchase->items->count() }}</span>
            </div>
            <div class="totals-row">
                <span>Subtotal</span>
                <span>৳{{ number_format($purchase->total_amount, 2) }}</span>
            </div>
            
            <div class="totals-divider"></div>
            
            <div class="totals-row grand">
                <span>Grand Total</span>
                <span>৳{{ number_format($purchase->total_amount, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="inv-footer">
        <div class="inv-footer-text">
            <p><strong>Shahzadi Mart</strong> — Procurement Division</p>
            <p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
        </div>
        @if($purchase->lot_slip_image)
        <div>
            <div style="font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;margin-bottom:4px;text-align:right;">Attached Lot Slip</div>
            <img src="{{ asset('uploads/purchase/' . $purchase->lot_slip_image) }}" alt="Lot Slip" class="slip-img">
        </div>
        @endif
    </div>

</div>

</body>
</html>
