<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $session->invoice_no }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; margin: 0; padding: 20px; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0,0,0,.15); }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .company-info h2 { margin: 0; color: #ff3e6c; }
        .invoice-details { text-align: right; }
        .client-info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #f8f9fa; text-align: left; padding: 10px; border-bottom: 2px solid #dee2e6; }
        td { padding: 10px; border-bottom: 1px solid #dee2e6; }
        .totals { float: right; width: 250px; }
        .totals div { display: flex; justify-content: space-between; padding: 5px 0; }
        .grand-total { font-weight: bold; border-top: 2px solid #dee2e6; margin-top: 10px; padding-top: 10px; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; }
        @media print { .no-print { display: none; } .invoice-box { border: none; box-shadow: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #ff3e6c; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Print Invoice</button>
    </div>

    <div class="invoice-box">
        @php
            $gs = \App\Models\Generalsetting::getSettings();
        @endphp
        <div class="header">
            <div class="company-info">
                @if($gs->invoice_logo)
                    <img src="{{ asset($gs->invoice_logo) }}" alt="Logo" style="max-height: 70px; margin-bottom: 10px;">
                @else
                    <h2>{{ auth()->user()->store_name ?? 'Shahzadi Mart' }}</h2>
                @endif
                <p style="margin: 0; font-weight: 700; color: #ff3e6c;">{{ auth()->user()->name }}</p>
                <p style="margin: 0;">{{ auth()->user()->address['business_address'] ?? 'Official Store' }}</p>
                <p style="margin: 0;">Phone: {{ auth()->user()->phone }}</p>
            </div>
            <div class="invoice-details">
                <h3>INVOICE</h3>
                <p>#{{ $session->invoice_no }}</p>
                <p>Date: {{ $session->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="client-info">
            <strong>Bill To:</strong><br>
            {{ $session->customer->name ?? 'Guest Customer' }}<br>
            Phone: {{ $session->customer->phone ?? 'N/A' }}<br>
            Email: {{ $session->customer->email ?? 'N/A' }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($session->items as $item)
                <tr>
                    <td>
                        {{ $item->product->name }}
                        @if($item->variant_label)<br><small>({{ $item->variant_label }})</small>@endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>৳{{ number_format($item->unit_price, 2) }}</td>
                    <td>৳{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div><span>Subtotal</span> <span>৳{{ number_format($session->sub_total, 2) }}</span></div>
            @if($session->discount_amount > 0)
            <div><span>Discount</span> <span>-৳{{ number_format($session->discount_amount, 2) }}</span></div>
            @endif
            @if($session->tax_amount > 0)
            <div><span>Tax</span> <span>৳{{ number_format($session->tax_amount, 2) }}</span></div>
            @endif
            @if($session->shipping_amount > 0)
            <div><span>Shipping</span> <span>৳{{ number_format($session->shipping_amount, 2) }}</span></div>
            @endif
            <div class="grand-total"><span>Grand Total</span> <span>৳{{ number_format($session->grand_total, 2) }}</span></div>
        </div>
        <div style="clear: both;"></div>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>Shahzadi Mart | Solution by Antigravity</p>
        </div>
    </div>
</body>
</html>
