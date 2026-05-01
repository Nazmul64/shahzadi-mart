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
.btn-order-status     { background: linear-gradient(135deg, #3d5a99, #2e4a89); color: #fff; }
.btn-payment-status   { background: linear-gradient(135deg, #19cac4, #0fb8b2); color: #fff; }
.btn-steadfast-send   { background: linear-gradient(135deg, #f39c12, #e67e22); color: #fff; }
.btn-steadfast-resend { background: #f4f6fb; color: #888; border: 1px solid #e5e7eb; }

.os-order-number { font-weight: 700; color: #19cac4; font-size: 15px; }

.sf-info-box { border-radius: 8px; padding: 12px 14px; margin-bottom: 14px; }
.sf-info-box.sent     { background: #f0fff4; border: 1px solid #9ae6b4; }
.sf-info-box.not-sent { background: #fffbeb; border: 1px solid #f6e05e; }
.sf-info-row {
    display: flex; justify-content: space-between;
    font-size: 12px; color: #555; padding: 3px 0;
}
.sf-info-row span:first-child { color: #888; }
.sf-info-row span:last-child  { font-weight: 600; color: #2d3748; }

.sf-status-badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.sf-status-pending           { background:#fff8e6; color:#b7791f; }
.sf-status-delivered         { background:#f0fff4; color:#276749; }
.sf-status-cancelled         { background:#fff5f5; color:#c53030; }
.sf-status-partial_delivered { background:#ebf8ff; color:#2b6cb0; }
.sf-status-unknown           { background:#f4f6fb; color:#888; }

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

        @php
            $sfOrder    = $order->steadfastOrder;
            $isSent     = $sfOrder && $sfOrder->is_sent;
            $pathaoOrd  = $order->pathaoOrder;
            $pathaoSent = $pathaoOrd && $pathaoOrd->is_sent;

            // ✅ Pathao single send route — Laravel এ generate করো যাতে prefix ঠিক থাকে
            $pathaoSendUrl = route('admin.pathao.send', $order->id);
        @endphp

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
                                            <div style="font-weight:600;font-size:13px;">{{ $item->product_name }}</div>
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

                {{-- ─── Steadfast Card ─── --}}
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
                                <div style="font-size:11px;color:#888;margin-top:8px;padding-top:8px;border-top:1px solid #c6f6d5;">
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

                {{-- ─── Pathao Card ─── --}}
                <div class="os-card">
                    <div class="os-card-header">
                        <h5 class="os-card-title">
                            <i class="bi bi-send me-1" style="color:#00b894;"></i>
                            Pathao Courier
                        </h5>
                        @if($pathaoSent)
                            <span style="font-size:11px;background:#f0fff4;color:#276749;
                                         border:1px solid #9ae6b4;border-radius:20px;
                                         padding:2px 10px;font-weight:600;">
                                ✓ Sent
                            </span>
                        @endif
                    </div>
                    <div class="os-card-body">

                        @if($pathaoSent)
                            <div style="background:#f0fff4;border:1px solid #9ae6b4;border-radius:8px;
                                        padding:12px 14px;margin-bottom:14px;">
                                @if($pathaoOrd->consignment_id)
                                <div class="sf-info-row">
                                    <span>Consignment ID</span>
                                    <span>{{ $pathaoOrd->consignment_id }}</span>
                                </div>
                                @endif
                                @if($pathaoOrd->merchant_order_id)
                                <div class="sf-info-row">
                                    <span>Merchant Order ID</span>
                                    <span>{{ $pathaoOrd->merchant_order_id }}</span>
                                </div>
                                @endif
                                <div class="sf-info-row">
                                    <span>COD Amount</span>
                                    <span>৳{{ number_format($pathaoOrd->amount_to_collect, 0) }}</span>
                                </div>
                                @if($pathaoOrd->delivery_fee > 0)
                                <div class="sf-info-row">
                                    <span>Delivery Fee</span>
                                    <span>৳{{ number_format($pathaoOrd->delivery_fee, 0) }}</span>
                                </div>
                                @endif
                                <div class="sf-info-row" style="margin-top:6px;">
                                    <span>Status</span>
                                    <span style="font-weight:600;color:#276749;">
                                        {{ $pathaoOrd->order_status ?? 'Pending' }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div style="background:#fffbeb;border:1px solid #f6e05e;border-radius:8px;
                                        padding:12px 14px;margin-bottom:14px;">
                                <div style="font-size:12px;color:#b7791f;font-weight:500;">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    এই অর্ডারটি এখনো Pathao-তে পাঠানো হয়নি।
                                </div>
                            </div>
                        @endif

                        {{-- ✅ onclick এ JS function call — URL PHP থেকে data-attribute হিসেবে পাঠাচ্ছি --}}
                        <button type="button"
                                onclick="openPathaoModal()"
                                class="btn-update-status"
                                style="background:{{ $pathaoSent ? '#f4f6fb' : 'linear-gradient(135deg,#00b894,#00a381)' }};
                                       color:{{ $pathaoSent ? '#888' : '#fff' }};
                                       border:{{ $pathaoSent ? '1px solid #e5e7eb' : 'none' }};">
                            <i class="bi bi-send"></i>
                            {{ $pathaoSent ? 'পুনরায় পাঠান (Resend)' : 'Pathao-তে পাঠান' }}
                        </button>

                    </div>
                </div>

                {{-- ─── Update Order Status ─── --}}
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

                {{-- ─── Update Payment Status ─── --}}
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

                {{-- ─── Delete Order ─── --}}
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

        </div>{{-- end os-grid --}}
    </div>{{-- end os-content --}}
</div>{{-- end os-wrapper --}}


{{-- ════════════════════════════════════════════════
     PATHAO MODAL
════════════════════════════════════════════════ --}}
<div id="pathao-modal-overlay"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);
            z-index:10000;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:28px 32px;width:440px;
                max-width:95vw;box-shadow:0 8px 32px rgba(0,0,0,0.2);max-height:90vh;overflow-y:auto;">

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h5 style="margin:0;font-size:16px;font-weight:700;color:#2d3748;">
                <i class="bi bi-send me-2" style="color:#00b894;"></i>
                Pathao Courier
                <span style="font-size:12px;font-weight:400;color:#aaa;margin-left:6px;">
                    #{{ $order->order_number }}
                </span>
            </h5>
            <button onclick="closePathaoModal()"
                    style="background:none;border:none;font-size:22px;cursor:pointer;color:#aaa;line-height:1;">×</button>
        </div>

        <div id="pathao-modal-info"
             style="background:#f0fff4;border:1px solid #9ae6b4;border-radius:8px;
                    padding:10px 14px;font-size:13px;color:#276749;margin-bottom:16px;display:none;"></div>
        <div id="pathao-modal-error"
             style="background:#fff5f5;border:1px solid #feb2b2;border-radius:8px;
                    padding:10px 14px;font-size:13px;color:#c53030;margin-bottom:16px;display:none;"></div>

        {{-- Store --}}
        <div style="margin-bottom:14px;">
            <label style="font-size:13px;font-weight:600;color:#3a4259;display:block;margin-bottom:6px;">
                Store <span style="color:#e74c3c;">*</span>
            </label>
            <select id="pathao-store"
                    style="width:100%;border:1px solid #dde2ec;border-radius:8px;padding:9px 12px;
                           font-size:13px;outline:none;color:#3a4259;">
                <option value="">Select Store...</option>
            </select>
        </div>

        {{-- City --}}
        <div style="margin-bottom:14px;">
            <label style="font-size:13px;font-weight:600;color:#3a4259;display:block;margin-bottom:6px;">
                City <span style="color:#e74c3c;">*</span>
            </label>
            <select id="pathao-city"
                    onchange="loadZones(this.value)"
                    style="width:100%;border:1px solid #dde2ec;border-radius:8px;padding:9px 12px;
                           font-size:13px;outline:none;color:#3a4259;">
                <option value="">Select City...</option>
            </select>
        </div>

        {{-- Zone --}}
        <div style="margin-bottom:14px;">
            <label style="font-size:13px;font-weight:600;color:#3a4259;display:block;margin-bottom:6px;">
                Zone <span style="color:#e74c3c;">*</span>
            </label>
            <select id="pathao-zone"
                    onchange="loadAreas(this.value)"
                    style="width:100%;border:1px solid #dde2ec;border-radius:8px;padding:9px 12px;
                           font-size:13px;outline:none;color:#3a4259;">
                <option value="">Select Zone...</option>
            </select>
        </div>

        {{-- Area --}}
        <div style="margin-bottom:22px;">
            <label style="font-size:13px;font-weight:600;color:#3a4259;display:block;margin-bottom:6px;">
                Area <span style="font-size:11px;color:#aaa;font-weight:400;">(Optional)</span>
            </label>
            <select id="pathao-area"
                    style="width:100%;border:1px solid #dde2ec;border-radius:8px;padding:9px 12px;
                           font-size:13px;outline:none;color:#3a4259;">
                <option value="">Select Area (Optional)...</option>
            </select>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <button onclick="closePathaoModal()"
                    style="background:#f4f6fb;color:#555;border:1px solid #e5e7eb;border-radius:8px;
                           padding:9px 22px;font-size:13px;cursor:pointer;font-weight:600;">
                Close
            </button>
            <button id="pathao-submit-btn"
                    onclick="submitPathaoOrder()"
                    style="background:#00b894;color:#fff;border:none;border-radius:8px;
                           padding:9px 22px;font-size:13px;cursor:pointer;font-weight:600;
                           display:inline-flex;align-items:center;gap:6px;">
                <i class="bi bi-send"></i> Submit
            </button>
        </div>

    </div>
</div>


{{-- ════════════════════════════════════════════════
     JAVASCRIPT — ✅ route() দিয়ে সঠিক URL
════════════════════════════════════════════════ --}}
<script>
/* ── Open / Close ── */
function openPathaoModal() {
    document.getElementById('pathao-modal-info').style.display  = 'none';
    document.getElementById('pathao-modal-error').style.display = 'none';
    document.getElementById('pathao-zone').innerHTML = '<option value="">Select Zone...</option>';
    document.getElementById('pathao-area').innerHTML = '<option value="">Select Area (Optional)...</option>';
    document.getElementById('pathao-modal-overlay').style.display = 'flex';
    loadStores();
    loadCities();
}

function closePathaoModal() {
    document.getElementById('pathao-modal-overlay').style.display = 'none';
}

document.getElementById('pathao-modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) closePathaoModal();
});

/* ── Helpers ── */
function showErr(msg) {
    const el = document.getElementById('pathao-modal-error');
    el.innerHTML     = '<i class="bi bi-exclamation-circle me-1"></i>' + msg;
    el.style.display = 'block';
    document.getElementById('pathao-modal-info').style.display = 'none';
}
function showSuccess(msg) {
    const el = document.getElementById('pathao-modal-info');
    el.innerHTML     = '<i class="bi bi-check-circle me-1"></i>' + msg;
    el.style.display = 'block';
    document.getElementById('pathao-modal-error').style.display = 'none';
}

/* ── Data Loaders ── */
function loadStores() {
    fetch('{{ route("admin.pathao.stores") }}')
        .then(r => r.json())
        .then(res => {
            const sel = document.getElementById('pathao-store');
            sel.innerHTML = '<option value="">Select Store...</option>';
            if (res.success && res.data && res.data.length) {
                res.data.forEach(s => {
                    sel.innerHTML += `<option value="${s.store_id}">${s.store_name}</option>`;
                });
            } else {
                sel.innerHTML += '<option value="" disabled>No stores found</option>';
            }
        })
        .catch(() => showErr('Store load করতে সমস্যা। API token চেক করুন।'));
}

function loadCities() {
    fetch('{{ route("admin.pathao.cities") }}')
        .then(r => r.json())
        .then(res => {
            const sel = document.getElementById('pathao-city');
            sel.innerHTML = '<option value="">Select City...</option>';
            if (res.success && res.data && res.data.length) {
                res.data.forEach(c => {
                    sel.innerHTML += `<option value="${c.city_id}">${c.city_name}</option>`;
                });
            }
        })
        .catch(() => showErr('City load failed.'));
}

function loadZones(cityId) {
    if (!cityId) return;
    const sel = document.getElementById('pathao-zone');
    sel.innerHTML = '<option value="">Loading zones...</option>';
    document.getElementById('pathao-area').innerHTML = '<option value="">Select Area (Optional)...</option>';

    fetch('{{ route("admin.pathao.zones") }}?city_id=' + cityId)
        .then(r => r.json())
        .then(res => {
            sel.innerHTML = '<option value="">Select Zone...</option>';
            if (res.success && res.data && res.data.length) {
                res.data.forEach(z => {
                    sel.innerHTML += `<option value="${z.zone_id}">${z.zone_name}</option>`;
                });
            }
        })
        .catch(() => { sel.innerHTML = '<option value="">Zone load failed</option>'; });
}

function loadAreas(zoneId) {
    if (!zoneId) return;
    const sel = document.getElementById('pathao-area');
    sel.innerHTML = '<option value="">Loading areas...</option>';

    fetch('{{ route("admin.pathao.areas") }}?zone_id=' + zoneId)
        .then(r => r.json())
        .then(res => {
            sel.innerHTML = '<option value="">Select Area (Optional)...</option>';
            if (res.success && res.data && res.data.length) {
                res.data.forEach(a => {
                    sel.innerHTML += `<option value="${a.area_id}">${a.area_name}</option>`;
                });
            }
        })
        .catch(() => { sel.innerHTML = '<option value="">Select Area (Optional)...</option>'; });
}

/* ── Submit ── */
function submitPathaoOrder() {
    const store_id = document.getElementById('pathao-store').value;
    const city_id  = document.getElementById('pathao-city').value;
    const zone_id  = document.getElementById('pathao-zone').value;
    const area_id  = document.getElementById('pathao-area').value;

    document.getElementById('pathao-modal-error').style.display = 'none';
    document.getElementById('pathao-modal-info').style.display  = 'none';

    if (!store_id) { showErr('Store নির্বাচন করুন।'); return; }
    if (!city_id)  { showErr('City নির্বাচন করুন।');  return; }
    if (!zone_id)  { showErr('Zone নির্বাচন করুন।');  return; }

    const btn = document.getElementById('pathao-submit-btn');
    btn.disabled  = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Sending...';

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData  = new FormData();
    formData.append('_token',   csrfToken);
    formData.append('store_id', store_id);
    formData.append('city_id',  city_id);
    formData.append('zone_id',  zone_id);
    if (area_id) formData.append('area_id', area_id);

    {{-- ✅ মূল Fix: route() দিয়ে সঠিক URL — admin prefix সহ --}}
    const url = '{{ route("admin.pathao.send", $order->id) }}';

    fetch(url, { method: 'POST', body: formData })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                showSuccess(res.message || 'সফলভাবে Pathao-তে পাঠানো হয়েছে!');
                setTimeout(() => { closePathaoModal(); location.reload(); }, 1800);
            } else {
                showErr(res.message || 'Something went wrong.');
            }
        })
        .catch(e => showErr('Network error: ' + e.message))
        .finally(() => {
            btn.disabled  = false;
            btn.innerHTML = '<i class="bi bi-send"></i> Submit';
        });
}
</script>

@endsection
