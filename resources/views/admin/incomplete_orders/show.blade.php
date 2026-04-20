{{-- resources/views/admin/incomplete_orders/show.blade.php --}}
@extends('admin.master')

@section('main-content')

<style>
* { box-sizing: border-box; }
.ios-wrapper { background: #f4f6fb; min-height: 100vh; font-family: 'Segoe UI', sans-serif; padding: 0; }

.ios-topbar {
    background: #fff; border-bottom: 1px solid #e8eaf0;
    padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;
}
.ios-topbar h2 { font-size: 20px; font-weight: 700; color: #2d3748; margin: 0; }
.ios-breadcrumb { font-size: 12px; color: #aaa; margin-top: 2px; }
.ios-breadcrumb a { color: #e53e3e; text-decoration: none; }
.ios-breadcrumb a:hover { text-decoration: underline; }

.ios-topbar-actions { display: flex; gap: 8px; align-items: center; }

.btn-back {
    background: #6c757d; color: #fff; border: none; border-radius: 22px;
    padding: 9px 20px; font-size: 13px; font-weight: 600; cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px;
    text-decoration: none; transition: opacity .2s;
}
.btn-back:hover { opacity: .88; color: #fff; text-decoration: none; }

.ios-content { padding: 20px 24px; }
.ios-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start; }

.ios-card {
    background: #fff; border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06); margin-bottom: 16px; overflow: hidden;
}
.ios-card-header {
    padding: 14px 20px; border-bottom: 1px solid #f0f2f8;
    display: flex; justify-content: space-between; align-items: center;
}
.ios-card-title { font-size: 14px; font-weight: 700; color: #2d3748; margin: 0; }
.ios-card-body { padding: 20px; }

.ios-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.ios-info-label { font-size: 11px; color: #aaa; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px; }
.ios-info-value { font-size: 14px; color: #2d3748; font-weight: 500; }

/* Status Badges */
.ios-badge { display: inline-block; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-incomplete { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
.badge-recovered  { background: #f0fff4; color: #276749; border: 1px solid #9ae6b4; }
.badge-contacted  { background: #ebf8ff; color: #2b6cb0; border: 1px solid #90cdf4; }

/* Cart table */
.ios-table { width: 100%; border-collapse: collapse; }
.ios-table thead tr { background: #f8f9fc; border-bottom: 2px solid #e8eaf0; }
.ios-table th { padding: 11px 14px; font-size: 12px; font-weight: 700; color: #7a849e; text-transform: uppercase; letter-spacing: .4px; }
.ios-table td { padding: 14px; font-size: 13px; color: #3a4259; border-bottom: 1px solid #f0f2f8; vertical-align: middle; }
.ios-table tbody tr:last-child td { border-bottom: none; }

/* Steadfast/Pathao info boxes */
.sf-info-box { border-radius: 8px; padding: 12px 14px; margin-bottom: 14px; }
.sf-info-box.sent     { background: #f0fff4; border: 1px solid #9ae6b4; }
.sf-info-box.not-sent { background: #fffbeb; border: 1px solid #f6e05e; }
.sf-info-row {
    display: flex; justify-content: space-between;
    font-size: 12px; color: #555; padding: 3px 0;
}
.sf-info-row span:first-child { color: #888; }
.sf-info-row span:last-child  { font-weight: 600; color: #2d3748; }

/* Buttons */
.btn-update-status {
    width: 100%; border: none; border-radius: 8px; padding: 10px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: opacity .2s;
    margin-bottom: 8px;
}
.btn-update-status:hover { opacity: .88; }
.btn-status-update    { background: linear-gradient(135deg, #3d5a99, #2e4a89); color: #fff; }
.btn-steadfast-send   { background: linear-gradient(135deg, #f39c12, #e67e22); color: #fff; }
.btn-steadfast-resend { background: #f4f6fb; color: #888; border: 1px solid #e5e7eb; }
.btn-pathao-send      { background: linear-gradient(135deg, #00b894, #00a381); color: #fff; }
.btn-pathao-resend    { background: #f4f6fb; color: #888; border: 1px solid #e5e7eb; }

.ios-os-select {
    width: 100%; border: 1px solid #dde2ec; border-radius: 8px; padding: 9px 12px;
    font-size: 13px; outline: none; margin-bottom: 10px; color: #3a4259; transition: border-color .2s;
}
.ios-os-select:focus { border-color: #e53e3e; }

/* Pathao Modal */
.pm-label { font-size: 13px; font-weight: 600; color: #3a4259; display: block; margin-bottom: 6px; }
.pm-select {
    width: 100%; border: 1px solid #dde2ec; border-radius: 8px;
    padding: 9px 12px; font-size: 13px; outline: none; color: #3a4259;
}
.pm-select:focus { border-color: #00b894; }
.pm-info-box { border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px; display: none; }
.pm-info-box.success { background: #f0fff4; border: 1px solid #9ae6b4; color: #276749; }
.pm-info-box.error   { background: #fff5f5; border: 1px solid #feb2b2; color: #c53030; }

@media (max-width: 900px) {
    .ios-grid { grid-template-columns: 1fr; }
    .ios-info-grid { grid-template-columns: 1fr; }
}
</style>

<div class="ios-wrapper">

    {{-- Top Header --}}
    <div class="ios-topbar">
        <div>
            <h2>Incomplete Order Details</h2>
            <div class="ios-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Home</a> /
                <a href="{{ route('admin.incomplete-orders.index') }}">Incomplete Orders</a> /
                #INC-{{ $incompleteOrder->id }}
            </div>
        </div>
        <div class="ios-topbar-actions">
            <a href="{{ route('admin.incomplete-orders.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="ios-content">

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
        @if(session('warning'))
            <div style="background:#fffbeb;border-left:4px solid #f6e05e;padding:12px 16px;
                        font-size:13px;color:#b7791f;margin-bottom:16px;border-radius:6px;">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
            </div>
        @endif

        @php
            $sfOrder   = $incompleteOrder->steadfastOrder;
            $isSfSent  = $sfOrder && $sfOrder->is_sent;
            $pathaoOrd = $incompleteOrder->pathaoOrder;
            $isPaSent  = $pathaoOrd && $pathaoOrd->is_sent;
            $cart      = $incompleteOrder->cart_snapshot ?? [];
        @endphp

        <div class="ios-grid">

            {{-- ══ LEFT COLUMN ══ --}}
            <div>

                {{-- Cart Items --}}
                <div class="ios-card">
                    <div class="ios-card-header">
                        <h5 class="ios-card-title">Cart Items (Snapshot)</h5>
                        <span style="font-size:12px;color:#aaa;">{{ count($cart) }} টি পণ্য</span>
                    </div>
                    <div style="padding:0;">
                        @if(count($cart) > 0)
                        <table class="ios-table">
                            <thead>
                                <tr>
                                    <th>পণ্য</th>
                                    <th>পরিমাণ</th>
                                    <th style="text-align:right;">মূল্য</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $item)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:12px;">
                                            @if(!empty($item['image']))
                                                <img src="{{ asset('uploads/products/'.$item['image']) }}"
                                                     style="width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid #eee;">
                                            @else
                                                <div style="width:48px;height:48px;background:#f3f4f6;border-radius:8px;
                                                            display:flex;align-items:center;justify-content:center;">
                                                    <i class="bi bi-image" style="color:#ccc;font-size:18px;"></i>
                                                </div>
                                            @endif
                                            <div style="font-weight:600;font-size:13px;">
                                                {{ $item['name'] ?? 'Product' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>×{{ $item['quantity'] ?? 1 }}</td>
                                    <td style="text-align:right;font-weight:600;">
                                        @if(!empty($item['price']))
                                            ৳{{ number_format($item['price'] * ($item['quantity'] ?? 1), 0) }}
                                        @else —
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <div style="padding:30px;text-align:center;color:#aaa;font-size:13px;">
                                <i class="bi bi-cart-x" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                                কোনো cart data নেই
                            </div>
                        @endif

                        {{-- Price Summary --}}
                        <div style="padding:16px 20px;border-top:1px solid #f0f2f8;">
                            <div style="max-width:260px;margin-left:auto;">
                                @if($incompleteOrder->delivery_fee > 0)
                                <div style="display:flex;justify-content:space-between;padding:6px 0;font-size:13px;color:#666;">
                                    <span>ডেলিভারি চার্জ</span>
                                    <span>৳{{ number_format($incompleteOrder->delivery_fee, 0) }}</span>
                                </div>
                                @endif
                                <div style="display:flex;justify-content:space-between;padding:10px 0;
                                            font-size:16px;font-weight:700;border-top:2px solid #eee;margin-top:4px;">
                                    <span>মোট</span>
                                    <span style="color:#e53e3e;">৳{{ number_format($incompleteOrder->total, 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Customer Info --}}
                <div class="ios-card">
                    <div class="ios-card-header">
                        <h5 class="ios-card-title">কাস্টমার তথ্য</h5>
                        @if($incompleteOrder->phone)
                        <a href="tel:{{ $incompleteOrder->phone }}"
                           style="background:#38a169;color:#fff;border-radius:20px;padding:5px 14px;
                                  font-size:12px;font-weight:600;text-decoration:none;display:inline-flex;
                                  align-items:center;gap:5px;">
                            <i class="bi bi-telephone-fill"></i> Call
                        </a>
                        @endif
                    </div>
                    <div class="ios-card-body">
                        <div class="ios-info-grid">
                            <div>
                                <div class="ios-info-label">নাম</div>
                                <div class="ios-info-value">{{ $incompleteOrder->customer_name ?: '—' }}</div>
                            </div>
                            <div>
                                <div class="ios-info-label">ফোন</div>
                                <div class="ios-info-value">
                                    <a href="tel:{{ $incompleteOrder->phone }}"
                                       style="color:#38a169;text-decoration:none;font-weight:600;">
                                        {{ $incompleteOrder->phone ?: '—' }}
                                    </a>
                                </div>
                            </div>
                            <div>
                                <div class="ios-info-label">ডেলিভারি এলাকা</div>
                                <div class="ios-info-value">{{ $incompleteOrder->delivery_area ?: '—' }}</div>
                            </div>
                            <div>
                                <div class="ios-info-label">পেমেন্ট পদ্ধতি</div>
                                <div class="ios-info-value" style="text-transform:uppercase;">
                                    {{ $incompleteOrder->payment_method ?: '—' }}
                                </div>
                            </div>
                            @if($incompleteOrder->address)
                            <div style="grid-column:1/-1;">
                                <div class="ios-info-label">ঠিকানা</div>
                                <div class="ios-info-value">{{ $incompleteOrder->address }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>{{-- end left --}}

            {{-- ══ RIGHT COLUMN ══ --}}
            <div>

                {{-- Order Summary --}}
                <div class="ios-card">
                    <div class="ios-card-header">
                        <h5 class="ios-card-title">অর্ডার সারসংক্ষেপ</h5>
                    </div>
                    <div class="ios-card-body">
                        <div style="margin-bottom:14px;">
                            <div class="ios-info-label">ID</div>
                            <div style="font-weight:700;color:#e53e3e;font-size:15px;">#INC-{{ $incompleteOrder->id }}</div>
                        </div>
                        <div style="margin-bottom:14px;">
                            <div class="ios-info-label">তারিখ</div>
                            <div class="ios-info-value">{{ $incompleteOrder->created_at->format('d M Y, h:i A') }}</div>
                        </div>
                        <div>
                            <div class="ios-info-label">বর্তমান স্ট্যাটাস</div>
                            <div style="margin-top:4px;">
                                <span class="ios-badge badge-{{ $incompleteOrder->status }}">
                                    @if($incompleteOrder->status === 'incomplete') 🔴
                                    @elseif($incompleteOrder->status === 'recovered') ✅
                                    @else 📞
                                    @endif
                                    {{ ucfirst($incompleteOrder->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status Update --}}
                <div class="ios-card">
                    <div class="ios-card-header">
                        <h5 class="ios-card-title">স্ট্যাটাস পরিবর্তন</h5>
                    </div>
                    <div class="ios-card-body">
                        <form method="POST"
                              action="{{ route('admin.incomplete-orders.update-status', $incompleteOrder->id) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="ios-os-select">
                                <option value="incomplete" {{ $incompleteOrder->status === 'incomplete' ? 'selected' : '' }}>🔴 Incomplete</option>
                                <option value="contacted"  {{ $incompleteOrder->status === 'contacted'  ? 'selected' : '' }}>📞 Contacted</option>
                                <option value="recovered"  {{ $incompleteOrder->status === 'recovered'  ? 'selected' : '' }}>✅ Recovered</option>
                            </select>
                            <button type="submit" class="btn-update-status btn-status-update">
                                <i class="bi bi-arrow-repeat"></i> স্ট্যাটাস আপডেট করুন
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Steadfast Card --}}
                <div class="ios-card">
                    <div class="ios-card-header">
                        <h5 class="ios-card-title">
                            <i class="bi bi-truck me-1" style="color:#f39c12;"></i>
                            Steadfast Courier
                        </h5>
                        @if($isSfSent)
                            <span style="font-size:11px;background:#f0fff4;color:#276749;
                                         border:1px solid #9ae6b4;border-radius:20px;padding:2px 10px;font-weight:600;">
                                ✓ Sent
                            </span>
                        @endif
                    </div>
                    <div class="ios-card-body">

                        @if($isSfSent)
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
                                    <span>Status</span>
                                    <span style="font-weight:600;color:#276749;">{{ ucfirst(str_replace('_', ' ', $sfOrder->status)) }}</span>
                                </div>
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
                              action="{{ route('admin.incomplete-orders.steadfast.send', $incompleteOrder->id) }}"
                              onsubmit="return confirm('{{ $isSfSent ? 'পুনরায় Steadfast-এ পাঠাতে চান?' : 'Steadfast Courier-এ পাঠাতে চান?' }}')">
                            @csrf
                            <button type="submit"
                                    class="btn-update-status {{ $isSfSent ? 'btn-steadfast-resend' : 'btn-steadfast-send' }}">
                                <i class="bi bi-truck"></i>
                                {{ $isSfSent ? 'পুনরায় পাঠান (Resend)' : 'Steadfast-এ পাঠান' }}
                            </button>
                        </form>

                    </div>
                </div>

                {{-- Pathao Card --}}
                <div class="ios-card">
                    <div class="ios-card-header">
                        <h5 class="ios-card-title">
                            <i class="bi bi-send me-1" style="color:#00b894;"></i>
                            Pathao Courier
                        </h5>
                        @if($isPaSent)
                            <span style="font-size:11px;background:#f0fff4;color:#276749;
                                         border:1px solid #9ae6b4;border-radius:20px;padding:2px 10px;font-weight:600;">
                                ✓ Sent
                            </span>
                        @endif
                    </div>
                    <div class="ios-card-body">

                        @if($isPaSent)
                            <div style="background:#f0fff4;border:1px solid #9ae6b4;border-radius:8px;padding:12px 14px;margin-bottom:14px;">
                                @if($pathaoOrd->consignment_id)
                                <div class="sf-info-row">
                                    <span>Consignment ID</span>
                                    <span>{{ $pathaoOrd->consignment_id }}</span>
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
                                    <span style="font-weight:600;color:#276749;">{{ $pathaoOrd->order_status ?? 'Pending' }}</span>
                                </div>
                            </div>
                        @else
                            <div style="background:#fffbeb;border:1px solid #f6e05e;border-radius:8px;padding:12px 14px;margin-bottom:14px;">
                                <div style="font-size:12px;color:#b7791f;font-weight:500;">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    এই অর্ডারটি এখনো Pathao-তে পাঠানো হয়নি।
                                </div>
                            </div>
                        @endif

                        <button type="button"
                                onclick="openPathaoModal()"
                                class="btn-update-status {{ $isPaSent ? 'btn-pathao-resend' : 'btn-pathao-send' }}">
                            <i class="bi bi-send"></i>
                            {{ $isPaSent ? 'পুনরায় পাঠান (Resend)' : 'Pathao-তে পাঠান' }}
                        </button>

                    </div>
                </div>

                {{-- Delete --}}
                <div class="ios-card">
                    <div class="ios-card-body">
                        <form method="POST"
                              action="{{ route('admin.incomplete-orders.destroy', $incompleteOrder->id) }}"
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
        </div>{{-- end ios-grid --}}
    </div>{{-- end ios-content --}}
</div>{{-- end ios-wrapper --}}


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
                    #INC-{{ $incompleteOrder->id }}
                </span>
            </h5>
            <button onclick="closePathaoModal()"
                    style="background:none;border:none;font-size:22px;cursor:pointer;color:#aaa;line-height:1;">×</button>
        </div>

        <div id="pathao-modal-info"  class="pm-info-box success"></div>
        <div id="pathao-modal-error" class="pm-info-box error"></div>

        <div style="margin-bottom:14px;">
            <label class="pm-label">Store <span style="color:#e74c3c;">*</span></label>
            <select id="pathao-store" class="pm-select"><option value="">Select Store...</option></select>
        </div>
        <div style="margin-bottom:14px;">
            <label class="pm-label">City <span style="color:#e74c3c;">*</span></label>
            <select id="pathao-city" class="pm-select" onchange="loadZones(this.value)">
                <option value="">Select City...</option>
            </select>
        </div>
        <div style="margin-bottom:14px;">
            <label class="pm-label">Zone <span style="color:#e74c3c;">*</span></label>
            <select id="pathao-zone" class="pm-select" onchange="loadAreas(this.value)">
                <option value="">Select Zone...</option>
            </select>
        </div>
        <div style="margin-bottom:22px;">
            <label class="pm-label">Area <span style="font-size:11px;color:#aaa;font-weight:400;">(Optional)</span></label>
            <select id="pathao-area" class="pm-select"><option value="">Select Area (Optional)...</option></select>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <button onclick="closePathaoModal()"
                    style="background:#f4f6fb;color:#555;border:1px solid #e5e7eb;border-radius:8px;
                           padding:9px 22px;font-size:13px;cursor:pointer;font-weight:600;">Close</button>
            <button id="pathao-submit-btn" onclick="submitPathaoOrder()"
                    style="background:#00b894;color:#fff;border:none;border-radius:8px;
                           padding:9px 22px;font-size:13px;cursor:pointer;font-weight:600;
                           display:inline-flex;align-items:center;gap:6px;">
                <i class="bi bi-send"></i> Submit
            </button>
        </div>
    </div>
</div>


<script>
function openPathaoModal() {
    document.getElementById('pathao-modal-info').style.display  = 'none';
    document.getElementById('pathao-modal-error').style.display = 'none';
    document.getElementById('pathao-zone').innerHTML = '<option value="">Select Zone...</option>';
    document.getElementById('pathao-area').innerHTML = '<option value="">Select Area (Optional)...</option>';
    document.getElementById('pathao-modal-overlay').style.display = 'flex';
    loadStores(); loadCities();
}
function closePathaoModal() {
    document.getElementById('pathao-modal-overlay').style.display = 'none';
}
document.getElementById('pathao-modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) closePathaoModal();
});

function showErr(msg) {
    var el = document.getElementById('pathao-modal-error');
    el.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>' + msg;
    el.style.display = 'block';
    document.getElementById('pathao-modal-info').style.display = 'none';
}
function showSuccess(msg) {
    var el = document.getElementById('pathao-modal-info');
    el.innerHTML = '<i class="bi bi-check-circle me-1"></i>' + msg;
    el.style.display = 'block';
    document.getElementById('pathao-modal-error').style.display = 'none';
}

function loadStores() {
    fetch('{{ route("admin.pathao.stores") }}')
        .then(r => r.json())
        .then(res => {
            var sel = document.getElementById('pathao-store');
            sel.innerHTML = '<option value="">Select Store...</option>';
            if (res.success && res.data && res.data.length) {
                res.data.forEach(s => sel.innerHTML += `<option value="${s.store_id}">${s.store_name}</option>`);
            } else { sel.innerHTML += '<option disabled>No stores found</option>'; }
        })
        .catch(() => showErr('Store load করতে সমস্যা। API token চেক করুন।'));
}
function loadCities() {
    fetch('{{ route("admin.pathao.cities") }}')
        .then(r => r.json())
        .then(res => {
            var sel = document.getElementById('pathao-city');
            sel.innerHTML = '<option value="">Select City...</option>';
            if (res.success && res.data && res.data.length) {
                res.data.forEach(c => sel.innerHTML += `<option value="${c.city_id}">${c.city_name}</option>`);
            }
        })
        .catch(() => showErr('City load failed.'));
}
function loadZones(cityId) {
    if (!cityId) return;
    var sel = document.getElementById('pathao-zone');
    sel.innerHTML = '<option value="">Loading...</option>';
    document.getElementById('pathao-area').innerHTML = '<option value="">Select Area (Optional)...</option>';
    fetch('{{ route("admin.pathao.zones") }}?city_id=' + cityId)
        .then(r => r.json())
        .then(res => {
            sel.innerHTML = '<option value="">Select Zone...</option>';
            if (res.success && res.data && res.data.length)
                res.data.forEach(z => sel.innerHTML += `<option value="${z.zone_id}">${z.zone_name}</option>`);
        })
        .catch(() => { sel.innerHTML = '<option value="">Zone load failed</option>'; });
}
function loadAreas(zoneId) {
    if (!zoneId) return;
    var sel = document.getElementById('pathao-area');
    sel.innerHTML = '<option value="">Loading...</option>';
    fetch('{{ route("admin.pathao.areas") }}?zone_id=' + zoneId)
        .then(r => r.json())
        .then(res => {
            sel.innerHTML = '<option value="">Select Area (Optional)...</option>';
            if (res.success && res.data && res.data.length)
                res.data.forEach(a => sel.innerHTML += `<option value="${a.area_id}">${a.area_name}</option>`);
        })
        .catch(() => { sel.innerHTML = '<option value="">Select Area (Optional)...</option>'; });
}

function submitPathaoOrder() {
    var store_id = document.getElementById('pathao-store').value;
    var city_id  = document.getElementById('pathao-city').value;
    var zone_id  = document.getElementById('pathao-zone').value;
    var area_id  = document.getElementById('pathao-area').value;

    document.getElementById('pathao-modal-error').style.display = 'none';
    document.getElementById('pathao-modal-info').style.display  = 'none';

    if (!store_id) { showErr('Store নির্বাচন করুন।'); return; }
    if (!city_id)  { showErr('City নির্বাচন করুন।');  return; }
    if (!zone_id)  { showErr('Zone নির্বাচন করুন।');  return; }

    var btn = document.getElementById('pathao-submit-btn');
    btn.disabled  = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Sending...';

    var formData = new FormData();
    formData.append('_token',   document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    formData.append('store_id', store_id);
    formData.append('city_id',  city_id);
    formData.append('zone_id',  zone_id);
    if (area_id) formData.append('area_id', area_id);

    var url = '{{ route("admin.incomplete-orders.pathao.send", $incompleteOrder->id) }}';

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
