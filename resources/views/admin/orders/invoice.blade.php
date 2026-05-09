<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices - {{ $gs->site_name }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            background: #f1f5f9;
            color: #1e293b;
        }

        .invoice-container {
            width: 794px; /* A4 width */
            margin: 20px auto;
            background: #fff;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
            page-break-after: always;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .logo {
            max-height: 70px;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h1 {
            margin: 0;
            font-size: 28px;
            color: #be0318;
            text-transform: uppercase;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
        }

        .info-section h3 {
            font-size: 14px;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 10px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 5px;
        }

        .info-item {
            margin-bottom: 5px;
            font-size: 14px;
        }

        .info-item strong {
            color: #1e293b;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            background: #f8fafc;
            padding: 12px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
        }

        .items-table td {
            padding: 12px;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
        }

        .summary-container {
            display: flex;
            justify-content: flex-end;
        }

        .summary-table {
            width: 250px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }

        .summary-row.total {
            border-top: 2px solid #be0318;
            margin-top: 10px;
            padding-top: 10px;
            font-weight: 700;
            font-size: 18px;
            color: #be0318;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }

        @media print {
            body { background: #fff; }
            .invoice-container { 
                margin: 0; 
                box-shadow: none; 
                width: 100%;
                padding: 20px;
            }
            .no-print { display: none; }
        }

        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #be0318;
            color: #fff;
            border: none;
            padding: 15px 25px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1000;
        }
    </style>
</head>
<body>

    <button class="print-btn no-print" onclick="window.print()">
        <i class="bi bi-printer-fill"></i> Print All Invoices
    </button>

    @foreach($orders as $order)
    <div class="invoice-container">
        <div class="invoice-header">
            <div>
                @if($gs->invoice_logo)
                    <img src="{{ asset($gs->invoice_logo) }}" class="logo" alt="Logo">
                @elseif($gs->header_logo)
                    <img src="{{ asset($gs->header_logo) }}" class="logo" alt="Logo">
                @else
                    <h2 style="margin:0;color:#be0318;">{{ $gs->site_name }}</h2>
                @endif
            </div>
            <div class="invoice-title">
                <h1>Invoice</h1>
                <div class="info-item"><strong>Order ID:</strong> #{{ $order->order_number }}</div>
                <div class="info-item"><strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}</div>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-section">
                <h3>Customer Details</h3>
                <div class="info-item"><strong>Name:</strong> {{ $order->customer_name }}</div>
                <div class="info-item"><strong>Phone:</strong> {{ $order->phone }}</div>
                <div class="info-item"><strong>Address:</strong> {{ $order->address }}</div>
                <div class="info-item"><strong>Area:</strong> {{ $order->delivery_area }}</div>
            </div>
            <div class="info-section" style="text-align: right;">
                <h3>Payment Info</h3>
                <div class="info-item"><strong>Method:</strong> {{ strtoupper($order->payment_method) }}</div>
                <div class="info-item"><strong>Status:</strong> {{ ucfirst($order->payment_status) }}</div>
                @if($order->transaction_id)
                    <div class="info-item"><strong>Transaction ID:</strong> {{ $order->transaction_id }}</div>
                @endif
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product_name }}
                        @if($item->selected_color || $item->selected_size)
                            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                                @if($item->selected_color) Color: {{ $item->selected_color }} @endif
                                @if($item->selected_size) | Size: {{ $item->selected_size }} @endif
                            </div>
                        @endif
                    </td>
                    <td>৳{{ number_format($item->price, 0) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td style="text-align: right;">৳{{ number_format($item->subtotal, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-container">
            <div class="summary-table">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>৳{{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->discount > 0)
                <div class="summary-row" style="color: #10b981;">
                    <span>Discount</span>
                    <span>- ৳{{ number_format($order->discount, 0) }}</span>
                </div>
                @endif
                <div class="summary-row">
                    <span>Delivery Charge</span>
                    <span>৳{{ number_format($order->delivery_fee, 0) }}</span>
                </div>
                <div class="summary-row total">
                    <span>Grand Total</span>
                    <span>৳{{ number_format($order->total, 0) }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for shopping with <strong>{{ $gs->site_name }}</strong>!</p>
            <p>If you have any questions about this invoice, please contact us.</p>
        </div>
    </div>
    @endforeach

    <script>
        // Auto print if only one invoice
        @if($orders->count() == 1)
            window.onload = function() {
                // Optional: window.print();
            }
        @endif
    </script>
</body>
</html>
