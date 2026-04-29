{{-- resources/views/admin/pos/invoice.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $session->invoice_no }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f3f4f6; padding: 20px; color: #111; }

        .invoice-wrap { max-width: 800px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 30px rgba(0,0,0,.08); }

        /* Header */
        .inv-header { background: linear-gradient(135deg, #e91e8c, #c2185b); color: #fff; padding: 30px; display: flex; justify-content: space-between; align-items: flex-start; }
        .inv-header .brand { font-size: 24px; font-weight: 800; letter-spacing: -0.5px; }
        .inv-header .brand small { display: block; font-size: 12px; font-weight: 400; opacity: .8; margin-top: 2px; }
        .inv-header .inv-info { text-align: right; }
        .inv-header .inv-no { font-size: 18px; font-weight: 700; }
        .inv-header .inv-date { font-size: 12px; opacity: .85; margin-top: 3px; }
        .inv-header .inv-status { display: inline-block; background: rgba(255,255,255,.2); border-radius: 20px; padding: 3px 12px; font-size: 12px; font-weight: 600; margin-top: 6px; }

        /* Body */
        .inv-body { padding: 28px 30px; }

        /* Customer + Payment row */
        .inv-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; }
        .meta-box { background: #f9fafb; border-radius: 10px; padding: 14px 16px; border: 1px solid #e5e7eb; }
        .meta-box h4 { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; margin-bottom: 8px; }
        .meta-box p { font-size: 13px; color: #374151; line-height: 1.6; }
        .meta-box .highlight { font-weight: 600; color: #111; }

        /* Items Table */
        .inv-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .inv-table thead tr { background: #f3f4f6; }
        .inv-table th { padding: 10px 12px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; color: #6b7280; text-align: left; border-bottom: 2px solid #e5e7eb; }
        .inv-table th:last-child { text-align: right; }
        .inv-table td { padding: 12px; border-bottom: 1px solid #f3f4f6; font-size: 13px; vertical-align: middle; }
        .inv-table td:last-child { text-align: right; font-weight: 600; }
        .inv-table .item-img { width: 42px; height: 42px; object-fit: cover; border-radius: 6px; }
        .inv-table .item-name { font-weight: 600; color: #111; }
        .inv-table .item-sku  { font-size: 11px; color: #9ca3af; }
        .inv-table .item-variant { font-size: 11px; color: #e91e8c; font-weight: 600; }

        /* Totals */
        .inv-totals { margin-left: auto; width: 300px; }
        .totals-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 13px; color: #374151; }
        .totals-row.discount { color: #ef4444; }
        .totals-row.tax { color: #6b7280; }
        .totals-divider { border: none; border-top: 1px dashed #e5e7eb; margin: 8px 0; }
        .totals-row.grand { font-size: 16px; font-weight: 800; color: #111; }
        .totals-row.grand span:last-child { color: #e91e8c; }

        /* Footer */
        .inv-footer { background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 16px 30px; display: flex; justify-content: space-between; align-items: center; }
        .inv-footer p { font-size: 12px; color: #9ca3af; }

        /* Print */
        .print-bar { text-align: center; margin-bottom: 16px; display: flex; justify-content: center; gap: 10px; }
        .btn-print { padding: 10px 28px; background: #e91e8c; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .btn-print:hover { background: #c2185b; }
        .btn-back { padding: 10px 20px; background: #f3f4f6; color: #374151; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; }

        @media print {
            body { background: #fff; padding: 0; }
            .print-bar { display: none; }
            .invoice-wrap { box-shadow: none; border-radius: 0; }
        }
    </style>
</head>
<body>

<div class="print-bar">
    <button class="btn-back" onclick="history.back()">← Back</button>
    <button class="btn-print" onclick="window.print()">🖨 Print Invoice</button>
</div>

<div class="invoice-wrap">

    {{-- Header --}}
    <div class="inv-header">
        <div class="brand">
            {{ config('app.name', 'Store') }}
            <small>Point of Sale Receipt</small>
        </div>
        <div class="inv-info">
            <div class="inv-no">{{ $session->invoice_no }}</div>
            <div class="inv-date">{{ $session->created_at->format('d M Y, h:i A') }}</div>
            <div class="inv-status">{{ ucfirst($session->status) }}</div>
        </div>
    </div>

    <div class="inv-body">

        {{-- Meta --}}
        <div class="inv-meta">
            <div class="meta-box">
                <h4>Customer</h4>
                @if($session->customer)
                    <p><span class="highlight">{{ $session->customer->name }}</span></p>
                    @if($session->customer->phone) <p>{{ $session->customer->phone }}</p> @endif
                    @if($session->customer->email) <p>{{ $session->customer->email }}</p> @endif
                @else
                    <p>Walk-in Customer</p>
                @endif
            </div>
            <div class="meta-box">
                <h4>Payment</h4>
                <p><span class="highlight">{{ ucwords(str_replace('_', ' ', $session->payment_method)) }}</span></p>
                @if($session->coupon_code)
                    <p>Coupon: <strong>{{ $session->coupon_code }}</strong></p>
                @endif
                @if($session->note)
                    <p style="margin-top:6px;font-style:italic;color:#6b7280">{{ $session->note }}</p>
                @endif
            </div>
        </div>

        {{-- Items Table --}}
        <table class="inv-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Variant</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($session->items as $i => $item)
                @php
                    // products টেবিল থেকে JOIN করা data
                    $product = $item->product;
                    $imgUrl  = ($product && $product->feature_image)
                                ? asset('uploads/products/' . $product->feature_image)
                                : asset('images/no-image.png');
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <img src="{{ $imgUrl }}" class="item-img"
                                 onerror="this.src='{{ asset('images/no-image.png') }}'">
                            <div>
                                <div class="item-name">{{ $product->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="item-sku">{{ $product->sku ?? '-' }}</span></td>
                    <td>
                        @if($item->variant_label)
                            <span class="item-variant">{{ $item->variant_label }}</span>
                        @else
                            <span style="color:#d1d5db">—</span>
                        @endif
                    </td>
                    <td>${{ number_format($item->unit_price, 2) }}</td>
                    <td>× {{ $item->quantity }}</td>
                    <td>${{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="inv-totals">
            <div class="totals-row">
                <span>Sub Total</span>
                <span>${{ number_format($session->sub_total, 2) }}</span>
            </div>
            @if($session->coupon_discount > 0)
            <div class="totals-row discount">
                <span>Coupon Discount ({{ $session->coupon_code }})</span>
                <span>- ${{ number_format($session->coupon_discount, 2) }}</span>
            </div>
            @endif
            @if($session->discount_amount > 0)
            <div class="totals-row discount">
                <span>Discount</span>
                <span>- ${{ number_format($session->discount_amount, 2) }}</span>
            </div>
            @endif
            {{-- VAT & Taxes --}}
            @foreach($taxes as $tax)
            <div class="totals-row tax">
                <span>{{ $tax->name }} ({{ $tax->percentage }}%)</span>
                <span>${{ number_format(($session->sub_total - $session->coupon_discount) * ($tax->percentage / 100), 2) }}</span>
            </div>
            @endforeach
            @if($session->tax_amount > 0)
            <div class="totals-row tax">
                <span>Total Tax</span>
                <span>${{ number_format($session->tax_amount, 2) }}</span>
            </div>
            @endif
            <hr class="totals-divider">
            <div class="totals-row grand">
                <span>Grand Total</span>
                <span>${{ number_format($session->grand_total, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="inv-footer">
        <p>Thank you for your purchase!</p>
        <p>Generated: {{ now()->format('d M Y, h:i A') }}</p>
    </div>
</div>

</body>
</html>
