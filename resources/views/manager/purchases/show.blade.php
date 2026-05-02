@extends('manager.master')
@section('title', 'Purchase Details — ' . $purchase->purchase_number)
@section('main-content')
<style>
body { background: #f5f7fa; }
.pur-wrap { padding: 24px 28px; min-height: 100vh; background: #f5f7fa; font-family: 'Segoe UI', sans-serif; }
.pur-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
.pur-title { font-size: 20px; font-weight: 700; color: #111827; }
.pur-title span { font-size: 14px; font-weight: 500; color: #6b7280; }
.btn-group { display: flex; gap: 10px; flex-wrap: wrap; }
.pur-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; border-radius: 7px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; transition: all .2s; text-decoration: none; }
.pur-btn-cyan { background: #06b6d4; color: #fff; }
.pur-btn-cyan:hover { background: #0891b2; color: #fff; }
.pur-btn-green { background: #10b981; color: #fff; }
.pur-btn-green:hover { background: #059669; color: #fff; }
.pur-btn-pink { background: #e91e8c; color: #fff; }
.pur-btn-pink:hover { background: #c4176f; color: #fff; }
.pur-btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 5px; }
.pur-btn-danger { background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; }
.pur-btn-danger:hover { background: #ef4444; color: #fff; }
.pur-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,.06); margin-bottom: 20px; }
.info-grid { display: grid; grid-template-columns: 1fr 1fr 200px; gap: 20px; }
.info-row { margin-bottom: 14px; }
.info-label { font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 3px; }
.info-value { font-size: 14px; color: #111827; font-weight: 500; }
.info-value a { color: #e91e8c; text-decoration: none; }
.info-value a:hover { text-decoration: underline; }
.slip-thumb { width: 100%; aspect-ratio: 4/3; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; background: #f9fafb; display: flex; align-items: center; justify-content: center; }
.slip-thumb img { width: 100%; height: 100%; object-fit: cover; border-radius: 7px; }
.slip-placeholder { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 140px; color: #9ca3af; }
.section-label { font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #f3f4f6; }
table.pur-table { width: 100%; border-collapse: collapse; }
table.pur-table th { background: #f9fafb; padding: 12px 16px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #6b7280; border-bottom: 1px solid #e5e7eb; text-align: left; }
table.pur-table td { padding: 13px 16px; font-size: 14px; color: #374151; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
table.pur-table tr:last-child td { border-bottom: none; }
table.pur-table tr:hover td { background: #fafafa; }
.badge { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
.badge-pending { background: #fef3c7; color: #92400e; }
.badge-received { background: #d1fae5; color: #065f46; }
.badge-cancelled { background: #fee2e2; color: #991b1b; }
.add-form { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px 20px; margin-bottom: 20px; display: none; }
.add-form.show { display: block; }
.add-form-grid { display: grid; grid-template-columns: 1fr 110px 140px 120px; gap: 12px; align-items: end; }
.pur-input { width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 8px 12px; font-size: 13px; color: #374151; background: #fff; box-sizing: border-box; font-family: inherit; }
.pur-input:focus { border-color: #e91e8c; outline: none; }
.pur-input option { background: #fff; }
.pur-input-label { font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 5px; display: block; text-transform: uppercase; }
.pur-alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; font-weight: 500; }
.pur-alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.pur-alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
@media(max-width:900px){.info-grid{grid-template-columns:1fr;}.add-form-grid{grid-template-columns:1fr 1fr;}}
</style>

<div class="pur-wrap">
    {{-- Header --}}
    <div class="pur-header">
        <div class="pur-title">
            Purchase Details
            <span>({{ str_pad($purchase->id, 6, '0', STR_PAD_LEFT) }})</span>
            &nbsp;
            @if($purchase->status === 'received')
                <span class="badge badge-received">Received</span>
            @elseif($purchase->status === 'pending')
                <span class="badge badge-pending">Pending</span>
            @else
                <span class="badge badge-cancelled">Cancelled</span>
            @endif
        </div>
        <div class="btn-group">
            @if($purchase->status !== 'received')
            <form action="{{ route('admin.purchases.mark-received', $purchase->id) }}" method="POST"
                onsubmit="return confirm('Mark as Received and update stock?')">
                @csrf @method('PATCH')
                <button type="submit" class="pur-btn pur-btn-cyan">
                    Mark as Received
                </button>
            </form>
            @endif

            <a href="{{ route('admin.purchases.pdf', $purchase->id) }}" target="_blank" class="pur-btn pur-btn-green">
                <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 16l4-4h-3V4h-2v8H8l4 4z"/><path d="M20 18H4v2h16v-2z"/>
                </svg>
                Download Invoice
            </a>

            @if($purchase->status !== 'received')
            <button type="button" class="pur-btn pur-btn-pink" onclick="toggleAddForm()">
                Attach Products
            </button>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="pur-alert pur-alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="pur-alert pur-alert-error">{{ session('error') }}</div>
    @endif

    {{-- Info Card --}}
    <div class="pur-card">
        <div class="info-grid">
            <div>
                <div class="info-row">
                    <div class="info-label">Name or Title:</div>
                    <div class="info-value">{{ $purchase->title ?? '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Total Amount:</div>
                    <div class="info-value">৳{{ number_format($purchase->total_amount, 2) }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Notes:</div>
                    <div class="info-value" style="color:#6b7280;">{{ $purchase->notes ?? '—' }}</div>
                </div>
            </div>
            <div>
                <div class="info-row">
                    <div class="info-label">Received Date:</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('m/d/Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Supplier:</div>
                    <div class="info-value">
                        <a href="#">{{ $purchase->supplier->name ?? '—' }}</a>
                    </div>
                </div>
            </div>
            <div>
                <div class="info-label">Slip Image</div>
                <div class="slip-thumb">
                    @if($purchase->lot_slip_image)
                        <img src="{{ asset('uploads/purchase/' . $purchase->lot_slip_image) }}" alt="Slip">
                    @else
                        <div class="slip-placeholder">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none">
                                <rect width="24" height="24" rx="4" fill="#e5e7eb"/>
                                <path d="M4 16l4-4 3 3 4-5 5 6H4z" fill="#9ca3af"/>
                                <circle cx="8" cy="8" r="2" fill="#9ca3af"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Attach Product Form (hidden) --}}
    @if($purchase->status !== 'received')
    <div class="add-form" id="addProductForm">
        <form action="{{ route('admin.purchases.attach', $purchase->id) }}" method="POST">
            @csrf
            <div class="add-form-grid">
                <div>
                    <label class="pur-input-label">Product</label>
                    <select name="product_id" class="pur-input" required>
                        <option value="">— Select Product —</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="pur-input-label">Quantity</label>
                    <input type="number" name="quantity" class="pur-input" placeholder="0" min="1" required>
                </div>
                <div>
                    <label class="pur-input-label">Unit Price (৳)</label>
                    <input type="number" name="unit_price" class="pur-input" placeholder="0.00" step="0.01" min="0" required>
                </div>
                <div>
                    <label class="pur-input-label">&nbsp;</label>
                    <button type="submit" class="pur-btn pur-btn-pink" style="width:100%;justify-content:center;">
                        Add Item
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif

    {{-- Product List --}}
    <div class="pur-card">
        <div class="section-label">Product List</div>
        <table class="pur-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchase->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                    <td>{{ number_format($item->quantity) }}</td>
                    <td>৳{{ number_format($item->total_price, 2) }}</td>
                    <td>
                        @if($purchase->status !== 'received')
                        <form action="{{ route('admin.purchases.remove-item', $item->id) }}" method="POST"
                            onsubmit="return confirm('Remove this item?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="pur-btn pur-btn-sm pur-btn-danger">
                                Delete
                            </button>
                        </form>
                        @else
                        <span style="color:#9ca3af;font-size:12px;">Locked</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:40px;color:#9ca3af;">
                        No products added yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($purchase->items->count() > 0)
        <div style="text-align:right;padding:14px 16px;border-top:1px solid #f3f4f6;font-weight:700;color:#111827;">
            Grand Total: ৳{{ number_format($purchase->total_amount, 2) }}
        </div>
        @endif
    </div>
</div>

<script>
function toggleAddForm() {
    const form = document.getElementById('addProductForm');
    form.classList.toggle('show');
}
@if($errors->any())
document.getElementById('addProductForm') && document.getElementById('addProductForm').classList.add('show');
@endif
</script>
@endsection
