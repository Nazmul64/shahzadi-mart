@extends('admin.master')

@section('main-content')

<style>
* { box-sizing: border-box; }
.os-wrapper { background: #f4f6fb; min-height: 100vh; font-family: 'Segoe UI', sans-serif; padding: 0; }

.os-topbar {
    background: #fff; border-bottom: 1px solid #e8eaf0;
    padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;
}
.os-topbar h2 { font-size: 20px; font-weight: 700; color: #2d3748; margin: 0; }
.os-breadcrumb { font-size: 12px; color: #aaa; margin-top: 2px; }
.os-breadcrumb a { color: #19cac4; text-decoration: none; }
.os-breadcrumb a:hover { text-decoration: underline; }

.os-topbar-actions { display: flex; gap: 8px; align-items: center; }

.btn-back {
    background: #6c757d; color: #fff; border: none; border-radius: 22px;
    padding: 9px 20px; font-size: 13px; font-weight: 600; cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px;
    text-decoration: none; transition: opacity .2s;
}
.btn-back:hover { opacity: .88; color: #fff; text-decoration: none; }

.btn-edit-order {
    background: linear-gradient(135deg, #8e44ad, #6c3483); color: #fff; border: none;
    border-radius: 22px; padding: 9px 20px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
    text-decoration: none; transition: opacity .2s;
}
.btn-edit-order:hover { opacity: .88; color: #fff; text-decoration: none; }

.os-content { padding: 20px 24px; }
.os-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start; }

.os-card {
    background: #fff; border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06); margin-bottom: 16px; overflow: hidden;
}
.os-card-header {
    padding: 14px 20px; border-bottom: 1px solid #f0f2f8;
    display: flex; justify-content: space-between; align-items: center;
}
.os-card-title { font-size: 14px; font-weight: 700; color: #2d3748; margin: 0; }
.os-card-body { padding: 20px; }

.os-table { width: 100%; border-collapse: collapse; }
.os-table thead tr { background: #f8f9fc; border-bottom: 2px solid #e8eaf0; }
.os-table th { padding: 11px 14px; font-size: 12px; font-weight: 700; color: #7a849e; text-transform: uppercase; letter-spacing: .4px; }
.os-table td { padding: 14px; font-size: 13px; color: #3a4259; border-bottom: 1px solid #f0f2f8; vertical-align: middle; }
.os-table tbody tr:last-child td { border-bottom: none; }

.os-price-row { display: flex; justify-content: space-between; padding: 7px 0; font-size: 13px; color: #666; }
.os-price-row.total { font-size: 16px; font-weight: 700; border-top: 2px solid #eee; margin-top: 6px; padding-top: 12px; color: #2d3748; }
.os-price-row.total span:last-child { color: #19cac4; }
.os-price-row.discount { color: #28a745; }

.os-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.os-info-label { font-size: 11px; color: #aaa; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px; }
.os-info-value { font-size: 14px; color: #2d3748; font-weight: 500; }

.os-badge { display: inline-block; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-order-pending    { background:#fff8e6; color:#b7791f; border:1px solid #f6e05e; }
.badge-order-processing { background:#ebf8ff; color:#2b6cb0; border:1px solid #90cdf4; }
.badge-order-shipped    { background:#e8f5e9; color:#2e7d32; border:1px solid #a5d6a7; }
.badge-order-delivered  { background:#f0fff4; color:#276749; border:1px solid #9ae6b4; }
.badge-order-cancelled  { background:#fff5f5; color:#c53030; border:1px solid #feb2b2; }
.badge-pay-pending  { background:#fff8e6; color:#b7791f; border:1px solid #f6e05e; }
.badge-pay-paid     { background:#f0fff4; color:#276749; border:1px solid #9ae6b4; }
.badge-pay-failed   { background:#fff5f5; color:#c53030; border:1px solid #feb2b2; }
.badge-pay-refunded { background:#faf5ff; color:#6b46c1; border:1px solid #d6bcfa; }

.os-select {
    width: 100%; border: 1px solid #dde2ec; border-radius: 8px; padding: 9px 12px;
    font-size: 13px; outline: none; margin-bottom: 10px; color: #3a4259; transition: border-color .2s;
}
.os-select:focus { border-color: #19cac4; }

.btn-update-status {
    width: 100%; border: none; border-radius: 8px; padding: 10px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: opacity .2s;
}
.btn-update-status:hover { opacity: .88; }
.btn-order-status   { background: linear-gradient(135deg, #3d5a99, #2e4a89); color: #fff; }
.btn-payment-status { background: linear-gradient(135deg, #19cac4, #0fb8b2); color: #fff; }
.btn-steadfast-send { background: linear-gradient(135deg, #f39c12, #e67e22); color: #fff; }
.btn-steadfast-resend { background: #f4f6fb; color: #888; border: 1px solid #e5e7eb; }

.os-order-number { font-weight: 700; color: #19cac4; font-size: 15px; }

/* ─── Steadfast Info Box ─────────────────────────────────────────── */
.sf-info-box {
    border-radius: 8px; padding: 12px 14px; margin-bottom: 14px;
}
.sf-info-box.sent {
    background: #f0fff4; border: 1px solid #9ae6b4;
}
.sf-info-box.not-sent {
    background: #fffbeb; border: 1px solid #f6e05e;
}
.sf-info-row {
    display: flex; justify-content: space-between;
    font-size: 12px; color: #555; padding: 3px 0;
}
.sf-info-row span:first-child { color: #888; }
.sf-info-row span:last-child  { font-weight: 600; color: #2d3748; }

.sf-status-badge {
    display: inline-block; padding: 2px 10px; border-radius: 20px;
    font-size: 11px; font-weight: 600;
}
.sf-status-pending          { background:#fff8e6; color:#b7791f; }
.sf-status-delivered        { background:#f0fff4; color:#276749; }
.sf-status-cancelled        { background:#fff5f5; color:#c53030; }
.sf-status-partial_delivered{ background:#ebf8ff; color:#2b6cb0; }
.sf-status-unknown          { background:#f4f6fb; color:#888; }

@media (max-width: 900px) {
    .os-grid { grid-template-columns: 1fr; }
    .os-info-grid { grid-template-columns: 1fr; }
}
</style>

<div class="os-wrapper">

    {{-- Top Header --}}
    <div class="os-topbar">
        <div>
            <h2>Order Details</h2>
            <div class="os-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Home</a> /
                <a href="{{ route('admin.order.allorder') }}">All Orders</a> /
                {{ $order->order_number }}
            </div>
        </div>
        <div class="os-topbar-actions">
            <a href="{{ route('admin.order.edit', $order->id) }}" class="btn-edit-order">
                <i class="bi bi-pencil-square"></i> Edit Order
            </a>
            <a href="{{ route('admin.order.allorder') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="os-content">

        @if(session('success'))
            <div style="background:#f0fff4;border-left:4px solid #38a169;padding:12px 16px;
                        font-size:13px;color:#276749;margin-bottom:16px;border-radius:6px;">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#fff5f5;border-left:4px solid #e53e3e;padding:12px 16px;
                        font-size:13px;color:#c53030;margin-bottom:16px;border-radius:6px;">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        @php $sfOrder = $order->steadfastOrder; $isSent = $sfOrder && $sfOrder->is_sent; @endphp

        <div class="os-grid">

            {{-- ══ LEFT COLUMN ══ --}}
            <div>

                {{-- Order Items --}}
                <div class="os-card">
                    <div class="os-card-header">
                        <h5 class="os-card-title">অর্ডারকৃত পণ্যসমূহ</h5>
                        <span style="font-size:12px;color:#aaa;">{{ $order->items->count() }} টি পণ্য</span>
                    </div>
                    <div style="padding:0;">
                        <table class="os-table">
                            <thead>
                                <tr>
                                    <th>পণ্য</th>
                                    <th>মূল্য</th>
                                    <th>পরিমাণ</th>
                                    <th>ছাড়</th>
                                    <th style="text-align:right;">সাবটোটাল</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:12px;">
                                            @if($item->product_image)
                                                <img src="{{ asset('uploads/products/'.$item->product_image) }}"
                                                     alt="{{ $item->product_name }}"
                                                     style="width:52px;height:52px;object-fit:cover;border-radius:8px;border:1px solid #eee;">
                                            @else
                                                <div style="width:52px;height:52px;background:#f3f4f6;border-radius:8px;
                                                            display:flex;align-items:center;justify-content:center;">
                                                    <i class="bi bi-image" style="color:#ccc;font-size:20px;"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div style="font-weight:600;font-size:13px;">{{ $item->product_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>৳{{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>—</td>
                                    <td style="text-align:right;font-weight:600;">
                                        ৳{{ number_format($item->subtotal, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Price Summary --}}
                        <div style="padding:16px 20px;border-top:1px solid #f0f2f8;">
                            <div style="max-width:280px;margin-left:auto;">
                                <div class="os-price-row">
                                    <span>সাবটোটাল</span>
                                    <span>৳{{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                @if($order->discount > 0)
                                <div class="os-price-row discount">
                                    <span>ছাড় @if($order->coupon_code)({{ $order->coupon_code }})@endif</span>
                                    <span>− ৳{{ number_format($order->discount, 2) }}</span>
                                </div>
                                @endif
                                <div class="os-price-row">
                                    <span>ডেলিভারি চার্জ</span>
                                    <span>৳{{ number_format($order->delivery_fee, 2) }}</span>
                                </div>
                                <div class="os-price-row total">
                                    <span>মোট</span>
                                    <span>৳{{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Customer Info --}}
                <div class="os-card">
                    <div class="os-card-header">
                        <h5 class="os-card-title">কাস্টমার তথ্য</h5>
                        <a href="{{ route('admin.order.edit', $order->id) }}"
                           style="font-size:12px;color:#19cac4;text-decoration:none;">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </div>
                    <div class="os-card-body">
                        <div class="os-info-grid">
                            <div>
                                <div class="os-info-label">নাম</div>
                                <div class="os-info-value">{{ $order->customer_name }}</div>
                            </div>
                            <div>
                                <div class="os-info-label">ফোন</div>
                                <div class="os-info-value">{{ $order->phone }}</div>
                            </div>
                            <div>
                                <div class="os-info-label">ডেলিভারি এলাকা</div>
                                <div class="os-info-value">{{ $order->delivery_area ?? '—' }}</div>
                            </div>
                            <div>
                                <div class="os-info-label">ঠিকানা</div>
                                <div class="os-info-value">{{ $order->address }}</div>
                            </div>
                            @if($order->note)
                            <div style="grid-column:1/-1;">
                                <div class="os-info-label">নোট</div>
                                <div class="os-info-value">{{ $order->note }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>{{-- end left --}}

            {{-- ══ RIGHT COLUMN ══ --}}
            <div>

                {{-- Order Summary --}}
                <div class="os-card">
                    <div class="os-card-header">
                        <h5 class="os-card-title">অর্ডার সারসংক্ষেপ</h5>
                    </div>
                    <div class="os-card-body">
                        <div style="margin-bottom:14px;">
                            <div class="os-info-label">অর্ডার নম্বর</div>
                            <div class="os-order-number">{{ $order->order_number }}</div>
                        </div>
                        <div style="margin-bottom:14px;">
                            <div class="os-info-label">তারিখ</div>
                            <div class="os-info-value">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                        </div>
                        <div>
                            <div class="os-info-label">পেমেন্ট পদ্ধতি</div>
                            <div class="os-info-value" style="text-transform:uppercase;">
                                {{ $order->payment_method ?? 'COD' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Steadfast Courier Card --}}
                <div class="os-card">
                    <div class="os-card-header">
                        <h5 class="os-card-title">
                            <i class="bi bi-truck me-1" style="color:#f39c12;"></i>
                            Steadfast Courier
                        </h5>
                        @if($isSent)
                            <span style="font-size:11px;background:#f0fff4;color:#276749;
                                         border:1px solid #9ae6b4;border-radius:20px;padding:2px 10px;font-weight:600;">
                                ✓ Sent
                            </span>
                        @endif
                    </div>
                    <div class="os-card-body">

                        @if($isSent)
                            <div class="sf-info-box sent">
                                <div class="sf-info-row">
                                    <span>Consignment ID</span>
                                    <span>{{ $sfOrder->consignment_id }}</span>
                                </div>
                                @if($sfOrder->tracking_code)
                                <div class="sf-info-row">
                                    <span>Tracking Code</span>
                                    <span>{{ $sfOrder->tracking_code }}</span>
                                </div>
                                @endif
                                <div class="sf-info-row">
                                    <span>COD Amount</span>
                                    <span>৳{{ number_format($sfOrder->cod_amount, 0) }}</span>
                                </div>
                                @if($sfOrder->delivery_charge > 0)
                                <div class="sf-info-row">
                                    <span>Delivery Charge</span>
                                    <span>৳{{ number_format($sfOrder->delivery_charge, 0) }}</span>
                                </div>
                                @endif
                                <div class="sf-info-row" style="margin-top:6px;">
                                    <span>Courier Status</span>
                                    <span>
                                        <span class="sf-status-badge sf-status-{{ $sfOrder->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $sfOrder->status)) }}
                                        </span>
                                    </span>
                                </div>
                                @if($sfOrder->tracking_message)
                                <div style="font-size:11px;color:#888;margin-top:8px;
                                            padding-top:8px;border-top:1px solid #c6f6d5;">
                                    {{ $sfOrder->tracking_message }}
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="sf-info-box not-sent">
                                <div style="font-size:12px;color:#b7791f;font-weight:500;">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    এই অর্ডারটি এখনো Steadfast-এ পাঠানো হয়নি।
                                </div>
                            </div>
                        @endif

                        {{-- Send / Resend Button --}}
                        <form method="POST"
                              action="{{ route('admin.steadfast.send', $order->id) }}"
                              onsubmit="return confirm('{{ $isSent ? 'পুনরায় Steadfast Courier-এ পাঠাতে চান?' : 'এই অর্ডারটি Steadfast Courier-এ পাঠাতে চান?' }}')">
                            @csrf
                            <button type="submit"
                                    class="btn-update-status {{ $isSent ? 'btn-steadfast-resend' : 'btn-steadfast-send' }}">
                                <i class="bi bi-truck"></i>
                                {{ $isSent ? 'পুনরায় পাঠান (Resend)' : 'Steadfast-এ পাঠান' }}
                            </button>
                        </form>

                    </div>
                </div>

                {{-- Update Order Status --}}
                <div class="os-card">
                    <div class="os-card-header">
                        <h5 class="os-card-title">অর্ডার স্ট্যাটাস পরিবর্তন</h5>
                    </div>
                    <div class="os-card-body">
                        <div style="margin-bottom:12px;">
                            <span class="os-badge badge-order-{{ $order->order_status }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </div>
                        <form method="POST" action="{{ route('admin.order.status', $order->id) }}">
                            @csrf
                            @method('PATCH')
                            <select name="order_status" class="os-select">
                                <option value="pending"    {{ $order->order_status === 'pending'    ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>🔄 Processing</option>
                                <option value="shipped"    {{ $order->order_status === 'shipped'    ? 'selected' : '' }}>🚚 Shipped</option>
                                <option value="delivered"  {{ $order->order_status === 'delivered'  ? 'selected' : '' }}>✅ Delivered</option>
                                <option value="cancelled"  {{ $order->order_status === 'cancelled'  ? 'selected' : '' }}>❌ Cancelled</option>
                            </select>
                            <button type="submit" class="btn-update-status btn-order-status">
                                <i class="bi bi-arrow-repeat"></i> স্ট্যাটাস আপডেট করুন
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Update Payment Status --}}
                <div class="os-card">
                    <div class="os-card-header">
                        <h5 class="os-card-title">পেমেন্ট স্ট্যাটাস পরিবর্তন</h5>
                    </div>
                    <div class="os-card-body">
                        <div style="margin-bottom:12px;">
                            <span class="os-badge badge-pay-{{ $order->payment_status }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <form method="POST" action="{{ route('admin.order.payment-status', $order->id) }}">
                            @csrf
                            @method('PATCH')
                            <select name="payment_status" class="os-select">
                                <option value="pending"  {{ $order->payment_status === 'pending'  ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="paid"     {{ $order->payment_status === 'paid'     ? 'selected' : '' }}>✅ Paid</option>
                                <option value="failed"   {{ $order->payment_status === 'failed'   ? 'selected' : '' }}>❌ Failed</option>
                                <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>↩️ Refunded</option>
                            </select>
                            <button type="submit" class="btn-update-status btn-payment-status">
                                <i class="bi bi-arrow-repeat"></i> পেমেন্ট আপডেট করুন
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Delete Order --}}
                <div class="os-card">
                    <div class="os-card-body">
                        <form method="POST"
                              action="{{ route('admin.order.destroy', $order->id) }}"
                              onsubmit="return confirm('এই অর্ডারটি স্থায়ীভাবে মুছে ফেলতে চান?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="width:100%;background:#fff5f5;color:#c53030;border:1px solid #feb2b2;
                                           border-radius:8px;padding:10px;font-size:13px;font-weight:600;
                                           cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;">
                                <i class="bi bi-trash3"></i> অর্ডার মুছে ফেলুন
                            </button>
                        </form>
                    </div>
                </div>

            </div>{{-- end right --}}

        </div>{{-- end grid --}}
    </div>
</div>

@endsection
