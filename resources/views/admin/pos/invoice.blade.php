<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice — {{ $session->invoice_no }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f3f4f6; color: #111827; }

        .invoice-wrap { max-width: 800px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        
        /* Header section */
        .inv-header { padding: 40px; background: #fff; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f3f4f6; }
        .inv-brand { display: flex; align-items: center; gap: 14px; }
        .inv-logo-box { width: 50px; height: 50px; background: #e91e8c; color: #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; }
        .inv-brand-text h1 { font-size: 22px; font-weight: 800; color: #111827; letter-spacing: -0.5px; line-height: 1.2; }
        .inv-brand-text p { font-size: 13px; color: #6b7280; font-weight: 500; }
        
        .inv-title { text-align: right; }
        .inv-title h2 { font-size: 26px; font-weight: 800; color: #e91e8c; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 4px; }
        .inv-title p { font-size: 14px; color: #6b7280; font-weight: 600; }

        /* Meta details */
        .inv-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; padding: 30px 40px; }
        .meta-box { background: #f9fafb; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; }
        .meta-label { font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px; }
        .meta-text { font-size: 14px; color: #374151; line-height: 1.6; }
        .meta-text strong { color: #111827; font-size: 15px; }

        /* Items Table */
        .inv-body { padding: 0 40px 30px; }
        table.inv-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        table.inv-table thead th { background: #111827; color: #fff; padding: 14px 16px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; text-align: left; }
        table.inv-table thead th:first-child { border-top-left-radius: 8px; border-bottom-left-radius: 8px; }
        table.inv-table thead th:last-child { border-top-right-radius: 8px; border-bottom-right-radius: 8px; text-align: right; }
        
        table.inv-table tbody td { padding: 16px; border-bottom: 1px solid #f3f4f6; font-size: 14px; color: #374151; vertical-align: middle; }
        table.inv-table tbody td:last-child { text-align: right; font-weight: 700; color: #111827; }
        table.inv-table tbody tr:last-child td { border-bottom: none; }
        
        .item-info { display: flex; align-items: center; gap: 12px; }
        .item-img { width: 46px; height: 46px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb; }
        .item-name { font-weight: 700; color: #111827; margin-bottom: 2px; }
        .item-meta { font-size: 12px; color: #6b7280; display: flex; gap: 8px; }
        .item-variant { color: #e91e8c; font-weight: 600; background: #fdf2f8; padding: 2px 6px; border-radius: 4px; }

        /* Totals section */
        .inv-summary { display: flex; justify-content: space-between; align-items: flex-end; padding: 0 40px 40px; }
        .payment-info { background: #f9fafb; padding: 16px 20px; border-radius: 10px; border: 1px dashed #d1d5db; max-width: 250px; }
        .payment-info p { font-size: 13px; color: #374151; margin-bottom: 4px; }
        .payment-info p strong { color: #111827; }
        
        .totals-box { width: 320px; }
        .totals-row { display: flex; justify-content: space-between; padding: 8px 0; font-size: 14px; color: #4b5563; }
        .totals-row.discount { color: #ef4444; }
        .totals-row.tax { color: #6b7280; }
        .totals-divider { border-top: 1px solid #e5e7eb; margin: 12px 0; }
        .totals-row.grand { font-size: 18px; font-weight: 800; color: #111827; padding-top: 4px; }
        .totals-row.grand span:last-child { color: #e91e8c; font-size: 22px; }

        /* Footer */
        .inv-footer { background: #111827; color: #9ca3af; padding: 24px 40px; text-align: center; font-size: 13px; }
        .inv-footer strong { color: #fff; }
        .barcode { text-align: center; margin-top: 16px; font-family: 'Courier New', Courier, monospace; font-size: 14px; letter-spacing: 4px; color: #fff; }

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
            table.inv-table thead th { color: #000; border-bottom: 2px solid #000; }
            .inv-footer { background: #fff; color: #000; border-top: 1px solid #000; }
            .inv-footer strong, .barcode { color: #000; }
        }
    </style>
</head>
<body>

<div class="print-ctrl">
    <button class="btn btn-secondary" onclick="history.back()">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Go Back
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
                <p>Point of Sale Receipt</p>
            </div>
        </div>
        <div class="inv-title">
            <h2>INVOICE</h2>
            <p>#{{ $session->invoice_no }}</p>
            <p style="font-size:12px; margin-top:4px;">{{ $session->created_at->format('d M Y, h:i A') }}</p>
            <div style="display:inline-block; margin-top:8px; padding:4px 12px; background:#d1fae5; color:#065f46; font-size:11px; font-weight:800; border-radius:20px; text-transform:uppercase; letter-spacing:1px;">
                {{ $session->status }}
            </div>
        </div>
    </div>

    {{-- Meta Details --}}
    <div class="inv-meta">
        <div class="meta-box">
            <span class="meta-label">Billed To</span>
            <div class="meta-text">
                @if($session->customer)
                    <strong>{{ $session->customer->name }}</strong><br>
                    @if($session->customer->phone) {{ $session->customer->phone }}<br> @endif
                    @if($session->customer->email) {{ $session->customer->email }}<br> @endif
                @else
                    <strong>Walk-in Customer</strong><br>
                    No details provided
                @endif
            </div>
        </div>
        <div class="meta-box">
            <span class="meta-label">Order Details</span>
            <div class="meta-text">
                Payment Method: <strong>{{ ucwords(str_replace('_', ' ', $session->payment_method)) }}</strong><br>
                Items Count: <strong>{{ $session->items->count() }}</strong><br>
                @if($session->coupon_code)
                    Applied Coupon: <strong>{{ $session->coupon_code }}</strong>
                @endif
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
                    <th>Price</th>
                    <th style="text-align: center;">Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($session->items as $i => $item)
                @php
                    $product = $item->product;
                    $imgUrl  = ($product && $product->feature_image) ? asset('uploads/products/' . $product->feature_image) : asset('images/no-image.png');
                @endphp
                <tr>
                    <td>{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div class="item-info">
                            <img src="{{ $imgUrl }}" class="item-img" onerror="this.src='{{ asset('images/no-image.png') }}'">
                            <div>
                                <div class="item-name">{{ $product->name ?? 'Deleted Product' }}</div>
                                <div class="item-meta">
                                    <span>SKU: {{ $product->sku ?? '-' }}</span>
                                    @if($item->variant_label)
                                        <span class="item-variant">{{ $item->variant_label }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>৳{{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align: center; font-weight: 600; color: #111827;">{{ $item->quantity }}</td>
                    <td>৳{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Summary & Totals --}}
    <div class="inv-summary">
        <div class="payment-info">
            <p><strong>Payment Status:</strong> {{ ucfirst($session->payment_status ?? 'Paid') }}</p>
            @if($session->note)
                <p style="margin-top:8px;"><strong>Note:</strong> <span style="font-style:italic;">{{ $session->note }}</span></p>
            @endif
        </div>
        
        <div class="totals-box">
            <div class="totals-row">
                <span>Sub Total</span>
                <span>৳{{ number_format($session->sub_total, 2) }}</span>
            </div>
            
            @if($session->coupon_discount > 0)
            <div class="totals-row discount">
                <span>Coupon Discount ({{ $session->coupon_code }})</span>
                <span>- ৳{{ number_format($session->coupon_discount, 2) }}</span>
            </div>
            @endif
            
            @if($session->discount_amount > 0)
            <div class="totals-row discount">
                <span>Special Discount</span>
                <span>- ৳{{ number_format($session->discount_amount, 2) }}</span>
            </div>
            @endif
            
            @foreach($taxes as $tax)
            <div class="totals-row tax">
                <span>{{ $tax->name }} ({{ $tax->percentage }}%)</span>
                <span>৳{{ number_format(($session->sub_total - $session->coupon_discount) * ($tax->percentage / 100), 2) }}</span>
            </div>
            @endforeach
            
            @if($session->tax_amount > 0)
            <div class="totals-row tax">
                <span>Total Tax</span>
                <span>৳{{ number_format($session->tax_amount, 2) }}</span>
            </div>
            @endif
            
            <div class="totals-divider"></div>
            
            <div class="totals-row grand">
                <span>Grand Total</span>
                <span>৳{{ number_format($session->grand_total, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="inv-footer">
        <p><strong>Thank you for shopping with us!</strong></p>
        <p style="margin-top:4px;">If you have any questions concerning this invoice, please contact our support.</p>
        <div class="barcode">
            *{{ $session->invoice_no }}*
        </div>
    </div>

</div>

</body>
</html>
