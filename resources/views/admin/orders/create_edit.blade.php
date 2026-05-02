{{-- resources/views/admin/orders/create_edit.blade.php --}}
@if(request()->routeIs('manager.*'))
    @extends('manager.master')
@elseif(request()->routeIs('emplee.*'))
    @extends('emplee.master')
@else
    @extends('admin.master')
@endif

@section(request()->routeIs('admin.*') ? 'main-content' : 'content')

<style>
* { box-sizing: border-box; }
.oe-wrapper { background: #f4f6fb; min-height: 100vh; font-family: 'Segoe UI', sans-serif; padding: 0; }

/* ─── Top Header ──────────────────────────────────────────────────── */
.oe-topbar {
    background: #fff; border-bottom: 1px solid #e8eaf0;
    padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;
}
.oe-topbar h2 { font-size: 20px; font-weight: 700; color: #2d3748; margin: 0; }
.oe-topbar-actions { display: flex; gap: 8px; align-items: center; }

.btn-cart-clear {
    background: linear-gradient(135deg, #f7617a, #e84b65); color: #fff; border: none;
    border-radius: 22px; padding: 9px 20px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: opacity .2s;
}
.btn-cart-clear:hover { opacity: .88; }

.btn-back {
    background: #6c757d; color: #fff; border: none; border-radius: 22px;
    padding: 9px 20px; font-size: 13px; font-weight: 600; cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px; text-decoration: none; transition: opacity .2s;
}
.btn-back:hover { opacity: .88; color: #fff; text-decoration: none; }

/* ─── Content ─────────────────────────────────────────────────────── */
.oe-content { padding: 20px 24px; }
.oe-card { background: #fff; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,.06); margin-bottom: 20px; overflow: hidden; }

/* ─── Product Select ──────────────────────────────────────────────── */
.oe-field-label { font-size: 13px; font-weight: 600; color: #3a4259; margin-bottom: 6px; display: block; }
.oe-field-label span { color: #e74c3c; }
.oe-select {
    width: 100%; border: 1px solid #dde2ec; border-radius: 8px; padding: 10px 14px;
    font-size: 13px; color: #3a4259; background: #fff; outline: none;
    transition: border-color .2s; appearance: none; cursor: pointer;
}
.oe-select:focus { border-color: #19cac4; }

/* ─── Items Table ─────────────────────────────────────────────────── */
.oe-items-table { width: 100%; border-collapse: collapse; }
.oe-items-table thead tr { background: #f8f9fc; border-bottom: 2px solid #e8eaf0; }
.oe-items-table th { padding: 11px 14px; font-size: 12px; font-weight: 700; color: #7a849e; text-transform: uppercase; letter-spacing: .4px; }
.oe-items-table td { padding: 14px; font-size: 13px; color: #3a4259; vertical-align: middle; border-bottom: 1px solid #f0f2f8; }

.oe-prod-img { width: 52px; height: 52px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; }

/* ─── Qty Controls ────────────────────────────────────────────────── */
.qty-ctrl { display: flex; align-items: center; border: 1px solid #dde2ec; border-radius: 8px; overflow: hidden; width: fit-content; }
.qty-btn { width: 34px; height: 34px; border: none; background: #f8f9fc; color: #3a4259; font-size: 18px; cursor: pointer; transition: background .2s; line-height: 1; }
.qty-btn:hover { background: #e8eaf0; }
.qty-input { width: 50px; height: 34px; border: none; border-left: 1px solid #dde2ec; border-right: 1px solid #dde2ec; text-align: center; font-size: 13px; font-weight: 600; color: #2d3748; outline: none; }

/* ─── Inputs ──────────────────────────────────────────────────────── */
.oe-input {
    width: 100%; border: 1px solid #dde2ec; border-radius: 8px; padding: 10px 14px;
    font-size: 13px; color: #3a4259; outline: none; transition: border-color .2s;
}
.oe-input:focus { border-color: #19cac4; }

.btn-remove-item { width: 30px; height: 30px; background: #e74c3c; color: #fff; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; }

/* ─── Bottom Grid ─────────────────────────────────────────────────── */
.oe-bottom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

/* ─── Summary Table ───────────────────────────────────────────────── */
.oe-summary-table { width: 100%; border-collapse: collapse; }
.oe-summary-table td { padding: 13px 16px; font-size: 13px; color: #3a4259; border-bottom: 1px solid #f0f2f8; }
.oe-summary-table td:last-child { font-weight: 600; text-align: right; }
.oe-summary-table tr:last-child td { border-bottom: none; font-weight: 700; font-size: 14px; }

/* ─── Submit Button ───────────────────────────────────────────────── */
.btn-update {
    width: 100%; background: linear-gradient(135deg, #19cac4, #0fb8b2); color: #fff;
    border: none; border-radius: 8px; padding: 14px; font-size: 15px; font-weight: 700;
    cursor: pointer; transition: opacity .2s; letter-spacing: .3px; margin-top: 4px;
}
.btn-update:hover { opacity: .9; }

@media (max-width: 768px) { .oe-bottom-grid { grid-template-columns: 1fr; } }
</style>

<div class="oe-wrapper">

    {{-- Top Header --}}
    <div class="oe-topbar">
        <h2>{{ isset($order) ? 'Edit Order — ' . $order->order_number : 'Create New Order' }}</h2>
        <div class="oe-topbar-actions">
            <button class="btn-cart-clear" onclick="clearCart()">
                <i class="bi bi-cart-x"></i> Cart Clear
            </button>
            @php
                if (request()->routeIs('manager.*')) {
                    $backRoute = route('manager.orders.index');
                } elseif (request()->routeIs('emplee.*')) {
                    $backRoute = route('emplee.orders.index');
                } else {
                    $backRoute = route('admin.order.allorder');
                }
            @endphp
            <a href="{{ $backRoute }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="oe-content">

        @if(session('success'))
            <div style="background:#f0fff4;border-left:4px solid #38a169;padding:12px 16px;
                        font-size:13px;color:#276749;margin-bottom:16px;border-radius:6px;">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background:#fff5f5;border-left:4px solid #e53e3e;padding:12px 16px;
                        font-size:13px;color:#c53030;margin-bottom:16px;border-radius:6px;">
                <i class="bi bi-exclamation-circle me-2"></i>
                <strong>ত্রুটি পাওয়া গেছে:</strong>
                <ul style="margin:8px 0 0 20px;padding:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Dynamic Form Action --}}
        @php
            if (request()->routeIs('manager.*')) {
                $formAction = isset($order) ? route('manager.orders.update', $order->id) : route('manager.orders.store');
            } elseif (request()->routeIs('emplee.*')) {
                $formAction = isset($order) ? route('emplee.orders.update', $order->id) : route('emplee.orders.store');
            } else {
                $formAction = isset($order) ? route('admin.order.update', $order->id) : route('admin.order.store');
            }
        @endphp
        <form method="POST" action="{{ $formAction }}" id="order-form">
            @csrf
            @if(isset($order)) @method('PUT') @endif

            {{-- Product Selector --}}
            <div class="oe-card" style="padding:20px;">
                <label class="oe-field-label">Products <span>*</span></label>
                <select class="oe-select" id="product-select" onchange="addProduct(this)">
                    <option value="">— পণ্য নির্বাচন করুন —</option>
                    @foreach($products as $product)
                        @php
                            $price = ($product->discount_price > 0) ? $product->discount_price : $product->price;
                        @endphp
                        <option value="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $price }}"
                                data-image="{{ $product->feature_image ? asset('uploads/products/'.$product->feature_image) : '' }}">
                            {{ $product->name }} — ৳{{ number_format($price, 0) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Items Table --}}
            <div class="oe-card">
                <div style="overflow-x:auto;">
                    <table class="oe-items-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Discount</th>
                                <th>Sub Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="items-tbody">
                            @if(isset($order) && $order->items->count() > 0)
                                @foreach($order->items as $item)
                                <tr id="row-{{ $item->product_id ?? $loop->index }}">
                                    <td>
                                        @if($item->feature_image)
                                            <img src="{{ asset('uploads/products/'.$item->feature_image) }}" class="oe-prod-img">
                                        @else
                                            <div style="width:52px;height:52px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                                <i class="bi bi-image" style="color:#ccc;font-size:20px;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>
                                        <div class="qty-ctrl">
                                            <button type="button" class="qty-btn"
                                                    onclick="changeQty('qty-{{ $item->product_id ?? $loop->index }}', -1, {{ $item->price }})">−</button>
                                            <input type="number" class="qty-input"
                                                   id="qty-{{ $item->product_id ?? $loop->index }}"
                                                   name="items[{{ $loop->index }}][quantity]"
                                                   value="{{ $item->quantity }}" min="1"
                                                   data-price="{{ $item->price }}"
                                                   onchange="calcRow('qty-{{ $item->product_id ?? $loop->index }}', {{ $item->price }})">
                                            <button type="button" class="qty-btn"
                                                    onclick="changeQty('qty-{{ $item->product_id ?? $loop->index }}', 1, {{ $item->price }})">+</button>
                                        </div>
                                        <input type="hidden" name="items[{{ $loop->index }}][product_id]" value="{{ $item->product_id }}">
                                    </td>
                                    <td id="price-{{ $item->product_id ?? $loop->index }}">৳{{ number_format($item->price, 0) }}</td>
                                    <td>
                                        <input type="number" class="oe-input" style="width:90px;"
                                               name="items[{{ $loop->index }}][discount]"
                                               value="{{ $item->discount ?? 0 }}" min="0"
                                               id="disc-{{ $item->product_id ?? $loop->index }}"
                                               onchange="calcRow('qty-{{ $item->product_id ?? $loop->index }}', {{ $item->price }})">
                                    </td>
                                    <td id="sub-{{ $item->product_id ?? $loop->index }}">{{ $item->subtotal }}</td>
                                    <td>
                                        <button type="button" class="btn-remove-item"
                                                onclick="removeRow('row-{{ $item->product_id ?? $loop->index }}', '{{ $item->product_id ?? $loop->index }}')">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr id="empty-row">
                                    <td colspan="7" style="text-align:center;padding:30px;color:#aaa;font-size:13px;">
                                        উপরে থেকে পণ্য নির্বাচন করুন
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Bottom: Customer + Summary --}}
            <div class="oe-bottom-grid">

                {{-- Customer Info --}}
                <div class="oe-card" style="padding:20px;">
                    <h6 style="font-size:14px;font-weight:700;color:#2d3748;margin:0 0 16px;">কাস্টমার তথ্য</h6>
                    <div style="display:flex;flex-direction:column;gap:12px;">
                        <input type="text" class="oe-input" name="customer_name"
                               placeholder="Customer Name *"
                               value="{{ old('customer_name', isset($order) ? $order->customer_name : '') }}"
                               required>
                        <input type="text" class="oe-input" name="phone"
                               placeholder="Phone Number *"
                               value="{{ old('phone', isset($order) ? $order->phone : '') }}"
                               required>
                        <input type="text" class="oe-input" name="address"
                               placeholder="Full Address *"
                               value="{{ old('address', isset($order) ? $order->address : '') }}"
                               required>
                        <input type="text" class="oe-input" name="delivery_area"
                               placeholder="Delivery Area / Note"
                               value="{{ old('delivery_area', isset($order) ? $order->delivery_area : '') }}">
                    </div>
                </div>

                {{-- Price Summary --}}
                <div class="oe-card">
                    <table class="oe-summary-table">
                        <tr>
                            <td>Sub Total</td>
                            <td id="summary-subtotal">{{ isset($order) ? $order->subtotal : '0' }}</td>
                        </tr>
                        <tr>
                            <td>Shipping Fee</td>
                            <td>
                                <input type="number" class="oe-input" style="width:110px;text-align:right;"
                                       name="delivery_fee" id="delivery-fee" min="0"
                                       value="{{ old('delivery_fee', isset($order) ? $order->delivery_fee : 70) }}"
                                       onchange="recalcTotal()">
                            </td>
                        </tr>
                        <tr>
                            <td>Item Discount</td>
                            <td id="summary-discount">{{ isset($order) ? $order->discount : '0' }}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td id="summary-total" style="color:#19cac4;font-size:16px;">
                                {{ isset($order) ? $order->total : '0' }}
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="subtotal" id="hidden-subtotal"
                           value="{{ isset($order) ? $order->subtotal : 0 }}">
                    <input type="hidden" name="discount" id="hidden-discount"
                           value="{{ isset($order) ? $order->discount : 0 }}">
                    <input type="hidden" name="total" id="hidden-total"
                           value="{{ isset($order) ? $order->total : 0 }}">
                </div>

            </div>{{-- end bottom grid --}}

            <button type="submit" class="btn-update">
                {{ isset($order) ? 'Update Order' : 'Create Order' }}
            </button>

        </form>
    </div>
</div>

<script>
let rowIndex = 0;

// Pre-populate from existing order items
@if(isset($order))
    rowIndex = {{ $order->items->count() }};
@endif

function addProduct(sel) {
    const opt   = sel.options[sel.selectedIndex];
    if (!opt.value) return;

    const pid   = opt.value;
    const name  = opt.getAttribute('data-name');
    const price = parseFloat(opt.getAttribute('data-price')) || 0;
    const image = opt.getAttribute('data-image') || '';

    // Remove empty placeholder row
    const emptyRow = document.getElementById('empty-row');
    if (emptyRow) emptyRow.remove();

    // If product row already exists → just increase qty
    if (document.getElementById('row-' + pid)) {
        const qtyInput = document.getElementById('qty-' + pid);
        if (qtyInput) {
            qtyInput.value = parseInt(qtyInput.value) + 1;
            calcRow('qty-' + pid, price);
        }
        sel.value = '';
        return;
    }

    const idx    = rowIndex++;
    const imgHtml = image
        ? `<img src="${image}" class="oe-prod-img" style="width:52px;height:52px;object-fit:cover;border-radius:8px;border:1px solid #eee;">`
        : `<div style="width:52px;height:52px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="bi bi-image" style="color:#ccc;font-size:20px;"></i></div>`;

    const row = document.createElement('tr');
    row.id    = 'row-' + pid;
    row.innerHTML = `
        <td>${imgHtml}</td>
        <td>${name}</td>
        <td>
            <div class="qty-ctrl">
                <button type="button" class="qty-btn" onclick="changeQty('qty-${pid}', -1, ${price})">−</button>
                <input type="number" class="qty-input" id="qty-${pid}"
                       name="items[${idx}][quantity]" value="1" min="1"
                       data-price="${price}"
                       onchange="calcRow('qty-${pid}', ${price})">
                <button type="button" class="qty-btn" onclick="changeQty('qty-${pid}', 1, ${price})">+</button>
            </div>
            <input type="hidden" name="items[${idx}][product_id]" value="${pid}">
        </td>
        <td id="price-${pid}">৳${price}</td>
        <td>
            <input type="number" class="oe-input" style="width:90px;"
                   name="items[${idx}][discount]"
                   value="0" min="0"
                   id="disc-${pid}"
                   onchange="calcRow('qty-${pid}', ${price})">
        </td>
        <td id="sub-${pid}">${price}</td>
        <td>
            <button type="button" class="btn-remove-item"
                    onclick="removeRow('row-${pid}', '${pid}')">
                <i class="bi bi-x"></i>
            </button>
        </td>
    `;
    document.getElementById('items-tbody').appendChild(row);

    recalcTotal();
    sel.value = '';
}

function changeQty(inputId, delta, price) {
    const input = document.getElementById(inputId);
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    input.value = val;
    calcRow(inputId, price);
}

function calcRow(inputId, price) {
    const input = document.getElementById(inputId);
    const pid   = inputId.replace('qty-', '');
    const qty   = parseInt(input.value) || 1;
    const discInput = document.getElementById('disc-' + pid);
    const disc  = discInput ? (parseFloat(discInput.value) || 0) : 0;
    const sub   = (qty * price) - disc;
    const subEl = document.getElementById('sub-' + pid);
    if (subEl) subEl.textContent = sub;
    recalcTotal();
}

function removeRow(rowId, pid) {
    const row = document.getElementById(rowId);
    if (row) row.remove();
    recalcTotal();
    if (document.getElementById('items-tbody').children.length === 0) {
        document.getElementById('items-tbody').innerHTML =
            '<tr id="empty-row"><td colspan="7" style="text-align:center;padding:30px;color:#aaa;font-size:13px;">উপরে থেকে পণ্য নির্বাচন করুন</td></tr>';
    }
}

function recalcTotal() {
    let subtotal = 0, discount = 0;
    document.querySelectorAll('[id^="sub-"]').forEach(el => {
        subtotal += parseFloat(el.textContent) || 0;
    });
    document.querySelectorAll('[id^="disc-"]').forEach(el => {
        discount += parseFloat(el.value) || 0;
    });
    const shipping = parseFloat(document.getElementById('delivery-fee').value) || 0;
    const total    = subtotal + shipping;

    document.getElementById('summary-subtotal').textContent = subtotal;
    document.getElementById('summary-discount').textContent = discount;
    document.getElementById('summary-total').textContent    = total;
    document.getElementById('hidden-subtotal').value = subtotal;
    document.getElementById('hidden-discount').value = discount;
    document.getElementById('hidden-total').value    = total;
}

function clearCart() {
    if (!confirm('কার্ট খালি করতে চান?')) return;
    document.getElementById('items-tbody').innerHTML =
        '<tr id="empty-row"><td colspan="7" style="text-align:center;padding:30px;color:#aaa;font-size:13px;">উপরে থেকে পণ্য নির্বাচন করুন</td></tr>';
    recalcTotal();
}

// Initial recalc for edit mode
recalcTotal();
</script>

@endsection
