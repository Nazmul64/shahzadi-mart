@extends('saller.master')

@section('main-content')
<style>
/* ══════════════════════════════════════════
   GOOGLE FONTS
   ══════════════════════════════════════════ */
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

/* ══════════════════════════════════════════
   CSS VARIABLES
   ══════════════════════════════════════════ */
:root {
    --primary:       #ff3e6c;
    --primary-dark:  #e02e5a;
    --primary-light: #fff0f3;
    --primary-muted: rgba(255, 62, 108, 0.1);
    --secondary:     #64748b;
    --accent:        #10b981;
    --danger:        #ef4444;
    --warning:       #f59e0b;
    --gray-50:       #f8fafc;
    --gray-100:      #f1f5f9;
    --gray-200:      #e2e8f0;
    --gray-300:      #cbd5e1;
    --gray-400:      #94a3b8;
    --gray-500:      #64748b;
    --gray-600:      #475569;
    --gray-700:      #334155;
    --gray-800:      #1e293b;
    --gray-900:      #0f172a;
    --radius-sm:     8px;
    --radius:        12px;
    --radius-lg:     16px;
    --shadow-sm:     0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow:        0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-md:     0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-lg:     0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    --glass:         rgba(255, 255, 255, 0.8);
}

* { box-sizing: border-box; font-family: 'DM Sans', sans-serif; }

.pos-wrapper {
    display: flex;
    height: calc(100vh - 70px);
    overflow: hidden;
    background: var(--gray-50);
}

/* ── LEFT PANEL ───────────────────────── */
.pos-left {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.pos-filters {
    padding: 12px 20px;
    background: #fff;
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
    z-index: 100;
}

.filter-select {
    height: 38px;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius-sm);
    padding: 0 10px;
    font-size: 13px;
    font-weight: 500;
    outline: none;
    background: #fff;
    color: var(--gray-700);
    cursor: pointer;
    transition: all .2s;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    padding-right: 28px;
    min-width: 130px;
}
.filter-select:focus { border-color: var(--primary); }

.filter-search {
    flex: 1;
    min-width: 200px;
    height: 38px;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius-sm);
    padding: 0 12px 0 36px;
    font-size: 13px;
    outline: none;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 12px center;
}

.product-grid {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 15px;
    align-content: start;
}

.product-card {
    background: #fff;
    border-radius: var(--radius);
    border: 1px solid var(--gray-200);
    padding: 10px;
    cursor: pointer;
    transition: all .2s;
    position: relative;
    box-shadow: var(--shadow-sm);
}
.product-card:hover { transform: translateY(-3px); box-shadow: var(--shadow); border-color: var(--primary); }
.product-card img { width: 100%; height: 110px; object-fit: cover; border-radius: var(--radius-sm); background: var(--gray-50); }
.p-name { font-weight: 600; font-size: 13px; color: var(--gray-800); margin: 8px 0 4px; height: 36px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
.p-price { font-size: 15px; font-weight: 700; color: var(--primary); }
.p-old-price { font-size: 11px; color: var(--gray-400); text-decoration: line-through; margin-left: 4px; }
.p-stock { font-size: 11px; color: var(--gray-500); margin-top: 5px; }
.flash-badge { position: absolute; top: 5px; right: 5px; background: var(--danger); color: #fff; font-size: 9px; font-weight: 800; padding: 2px 6px; border-radius: 4px; z-index: 1; }

/* ── RIGHT PANEL ──────────────────────── */
.pos-right {
    width: 400px;
    background: #fff;
    border-left: 1px solid var(--gray-200);
    display: flex;
    flex-direction: column;
}

.cart-header { padding: 15px; border-bottom: 1px solid var(--gray-100); background: #fff; }
.customer-row { display: flex; gap: 8px; }
.customer-select-wrap { flex: 1; position: relative; }
.customer-search-input {
    width: 100%; height: 42px; border: 1.5px solid var(--gray-200); border-radius: 8px;
    padding: 0 12px 0 40px; font-size: 13px; outline: none; transition: all 0.2s;
    background: #fdfdfd url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpath d='M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'/%3E%3Ccircle cx='12' cy='7' r='4'/%3E%3C/svg%3E") no-repeat 14px center;
}
.customer-search-input:focus { border-color: var(--primary); background-color: #fff; box-shadow: 0 0 0 4px var(--primary-muted); }

.customer-dropdown {
    position: absolute; top: 46px; left: 0; right: 0; background: #fff; border: 1px solid var(--gray-200);
    border-radius: 12px; z-index: 1000; max-height: 300px; overflow-y: auto; display: none; 
    box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 5px;
}
.customer-item { 
    padding: 10px 12px; cursor: pointer; border-radius: 8px; transition: all 0.2s; 
    display: flex; align-items: center; gap: 10px; margin-bottom: 2px;
}
.customer-item:hover { background: var(--primary-light); }
.customer-avatar-small {
    width: 32px; height: 32px; border-radius: 50%; background: var(--primary);
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700; flex-shrink: 0;
}
.customer-info-small { flex: 1; min-width: 0; }
.customer-info-small strong { display: block; font-size: 13px; color: var(--gray-800); }
.customer-info-small span { font-size: 11px; color: var(--gray-500); display: block; overflow: hidden; text-overflow: ellipsis; }

.btn-add-customer {
    height: 42px; padding: 0 15px; background: var(--primary); color: #fff; border: none;
    border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s;
}
.btn-add-customer:hover { background: var(--primary-dark); opacity: 0.9; }

.selected-customer-tag {
    display: none; align-items: center; gap: 10px; margin-top: 10px; padding: 10px;
    background: var(--primary-light); border-radius: 10px; border: 1px solid var(--primary-muted);
}
.sct-avatar {
    width: 36px; height: 36px; border-radius: 50%; background: var(--primary);
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 700;
}
.sct-info { flex: 1; }
.sct-info strong { font-size: 13px; color: var(--primary-dark); display: block; }
.sct-info span { font-size: 11px; color: var(--gray-500); }
.sct-remove { 
    width: 24px; height: 24px; border-radius: 50%; border: none; 
    background: rgba(255, 62, 108, 0.1); color: var(--primary); 
    cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 10px;
}
.sct-remove:hover { background: var(--primary); color: #fff; }

.cart-items { flex: 1; overflow-y: auto; padding: 12px; }
.cart-item { 
    display: flex; gap: 12px; padding: 10px; background: #fff; 
    border-radius: 12px; margin-bottom: 10px; border: 1px solid var(--gray-100);
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}
.cart-item img { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; background: var(--gray-50); }
.ci-info { flex: 1; min-width: 0; }
.ci-name { font-size: 13px; font-weight: 600; color: var(--gray-800); }
.ci-price { font-size: 14px; font-weight: 700; color: var(--primary); margin-top: 2px; }
.cart-qty { display: flex; align-items: center; gap: 4px; margin-top: 6px; }
.qty-btn { 
    width: 24px; height: 24px; border: 1px solid var(--gray-200); background: #fff; 
    border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; 
    font-size: 14px; color: var(--gray-600); transition: all 0.2s;
}
.qty-btn:hover { background: var(--gray-50); border-color: var(--primary); color: var(--primary); }
.qty-input { 
    width: 32px; height: 24px; text-align: center; border: none; 
    background: transparent; font-size: 13px; font-weight: 700; color: var(--gray-800);
}

.cart-summary { padding: 15px 20px; border-top: 1px solid var(--gray-100); background: #fff; }
.summary-row { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 6px; color: var(--gray-600); }
.summary-row .label { font-weight: 500; }
.summary-row .val { font-weight: 600; color: var(--gray-800); }
.summary-row.tax { font-size: 12px; color: var(--gray-500); padding-bottom: 4px; border-bottom: 1px dashed var(--gray-200); margin-bottom: 10px; }
.summary-row.total { 
    font-size: 18px; font-weight: 800; color: var(--gray-900); 
    margin-top: 10px; padding-top: 5px; 
}
.summary-row.total .val { color: var(--primary); }

.coupon-section { padding: 0 20px 15px; }
.coupon-box { 
    display: flex; gap: 8px; background: #f8fafc; padding: 5px; 
    border-radius: 10px; border: 1px solid var(--gray-200);
}
.coupon-box input { 
    flex: 1; background: transparent; border: none; outline: none; 
    padding: 0 10px; font-size: 12px; font-weight: 600;
}
.btn-apply { 
    padding: 6px 14px; background: #fff; border: 1px solid var(--gray-200); 
    border-radius: 7px; font-size: 11px; font-weight: 700; color: var(--primary);
    cursor: pointer; transition: all 0.2s;
}
.btn-apply:hover { background: var(--primary); color: #fff; border-color: var(--primary); }

.cart-actions { padding: 0 20px 20px; }
.btn-complete { 
    width: 100%; height: 50px; background: var(--primary); color: #fff; border: none; 
    border-radius: 12px; font-weight: 800; cursor: pointer; font-size: 16px; 
    box-shadow: 0 8px 16px var(--primary-muted); transition: all 0.3s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-complete:hover { transform: translateY(-2px); box-shadow: 0 12px 20px var(--primary-muted); opacity: 0.95; }
.btn-complete:active { transform: scale(0.98); }

/* Modal */
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 10000; display: none; align-items: center; justify-content: center; }
.modal-overlay.show { display: flex; }
.modal-box { background: #fff; border-radius: var(--radius-lg); padding: 25px; width: 400px; box-shadow: var(--shadow-lg); }
.form-group { margin-bottom: 15px; }
.form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--gray-500); margin-bottom: 5px; text-transform: uppercase; }
.form-group input { width: 100%; height: 38px; border: 1.5px solid var(--gray-200); border-radius: var(--radius-sm); padding: 0 12px; font-size: 13px; }
.modal-actions { display: flex; gap: 10px; margin-top: 20px; }
.btn-submit { flex: 1; height: 40px; background: var(--primary); color: #fff; border: none; border-radius: var(--radius-sm); font-weight: 700; cursor: pointer; }
.btn-cancel { flex: 1; height: 40px; background: var(--gray-100); border: none; border-radius: var(--radius-sm); cursor: pointer; }
</style>

<div class="pos-wrapper">
    <div class="pos-left">
        <div class="pos-filters">
            <select class="filter-select" id="categoryFilter" onchange="filterProducts()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                @endforeach
            </select>
            <select class="filter-select" id="brandFilter" onchange="filterProducts()">
                <option value="">All Brands</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
            <select class="filter-select" id="sizeFilter" onchange="filterProducts()">
                <option value="">All Sizes</option>
                @foreach($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
            </select>
            <select class="filter-select" id="colorFilter" onchange="filterProducts()">
                <option value="">All Colors</option>
                @foreach($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
            </select>
            <input class="filter-search" type="text" id="productSearch" placeholder="Search name or SKU..." onkeyup="filterProducts()">
        </div>

        <div id="productGridWrap" class="product-grid">
            @include('saller.pos.partials.product_grid', ['products' => $products])
        </div>

        <div class="pagination-wrap p-3 bg-white border-top">
            {{ $products->links() }}
        </div>
    </div>

    <div class="pos-right">
        <div class="cart-header">
            <div class="customer-row">
                <div class="customer-select-wrap">
                    <input type="text" class="customer-search-input" id="customerSearch" placeholder="Search by phone or name..." autocomplete="off">
                    <div class="customer-dropdown" id="customerDropdown"></div>
                </div>
                <button class="btn-add-customer" onclick="openModal('newCustomerModal')">New</button>
            </div>
            <div class="selected-customer-tag" id="selectedCustomerTag">
                <div class="sct-avatar" id="sctAvatar"></div>
                <div class="sct-info">
                    <strong id="sctName"></strong>
                    <span id="sctPhone"></span>
                </div>
                <button class="sct-remove" onclick="clearCustomer()">✕</button>
            </div>
        </div>

        <div class="cart-items" id="cartItems">
            <div class="text-center py-5 text-muted">
                <i class="bi bi-cart-x" style="font-size: 40px; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                Cart is empty
            </div>
        </div>

        <div class="cart-summary">
            <div class="summary-row"><span class="label">Sub Total</span><span class="val" id="subTotalDisplay">৳0.00</span></div>
            <div class="summary-row text-danger" id="discountRow" style="display:none">
                <span class="label">Discount (<span id="couponCodeDisplay"></span>)</span>
                <span class="val" id="discountDisplay">-৳0.00</span>
            </div>
            <div id="taxBreakdown"></div>
            <div class="summary-row total">
                <span class="label">Grand Total</span>
                <span class="val" id="grandTotalDisplay">৳0.00</span>
            </div>
        </div>

        <div class="coupon-section">
            <div class="coupon-box" id="couponInputBox">
                <input type="text" id="couponInput" placeholder="Coupon code">
                <button class="btn-apply" onclick="applyCoupon()">Apply</button>
            </div>
            <div id="couponAppliedMsg" class="alert alert-success py-2 px-3 mb-0 d-flex justify-content-between align-items-center" style="display:none !important; border-radius: 10px; font-size: 12px;">
                <span><i class="bi bi-check-circle-fill me-1"></i> Coupon applied!</span>
                <a href="javascript:void(0)" onclick="removeCoupon()" class="text-danger fw-bold text-decoration-none">Remove</a>
            </div>
        </div>

        <div class="cart-actions">
            <button class="btn-complete" onclick="placeOrder('completed')">
                <i class="bi bi-check-circle-fill"></i> Complete Order
            </button>
        </div>
    </div>
</div>

{{-- New Customer Modal --}}
<div class="modal-overlay" id="newCustomerModal">
    <div class="modal-box">
        <h4 class="mb-3">Add New Customer</h4>
        <div class="form-group">
            <label>First Name</label>
            <input type="text" id="custFirstName">
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" id="custLastName">
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" id="custPhone">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" id="custEmail">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" id="custPassword" value="password123">
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal('newCustomerModal')">Cancel</button>
            <button class="btn-submit" onclick="saveCustomer()">Save</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let cart = [];
let selectedCustomer = null;
let couponData = null;
const taxes = @json($taxes);

function filterProducts() {
    let data = {
        category_id: $('#categoryFilter').val(),
        brand_id: $('#brandFilter').val(),
        size_id: $('#sizeFilter').val(),
        color_id: $('#colorFilter').val(),
        search: $('#productSearch').val()
    };
    $.get("{{ route('saller.pos.searchProducts') }}", data, function(res) {
        if(res.success) $('#productGridWrap').html(res.html);
    });
}

function addToCart(id, name, sku, image, price, oldPrice, isUnlimited, stock, variants) {
    let item = cart.find(i => i.product_id === id);
    if(item) {
        item.quantity++;
    } else {
        cart.push({
            product_id: id,
            name: name,
            image: image,
            unit_price: price,
            quantity: 1
        });
    }
    renderCart();
}

function renderCart() {
    let html = '';
    let subTotal = 0;
    cart.forEach((item, index) => {
        let total = item.unit_price * item.quantity;
        subTotal += total;
        html += `
        <div class="cart-item">
            <img src="${item.image ? '/uploads/products/'+item.image : '/images/no-image.png'}" onerror="this.src='/images/no-image.png'">
            <div class="ci-info">
                <div class="ci-name">${item.name}</div>
                <div class="ci-price">৳${item.unit_price.toFixed(2)}</div>
                <div class="cart-qty">
                    <button class="qty-btn" onclick="updateQty(${index}, -1)">-</button>
                    <input type="text" class="qty-input" value="${item.quantity}" readonly>
                    <button class="qty-btn" onclick="updateQty(${index}, 1)">+</button>
                </div>
            </div>
            <div class="text-end">
                <div class="fw-bold">৳${total.toFixed(2)}</div>
                <button class="btn btn-sm text-danger" onclick="removeItem(${index})"><i class="bi bi-trash"></i></button>
            </div>
        </div>`;
    });
    $('#cartItems').html(cart.length ? html : '<div class="text-center py-5 text-muted">Cart is empty</div>');
    
    // Calculations
    let discount = 0;
    if (couponData) {
        discount = couponData.discount_amount;
        $('#discountRow').show();
        $('#couponCodeDisplay').text(couponData.coupon_code);
        $('#discountDisplay').text('-৳' + discount.toFixed(2));
        $('#couponAppliedMsg').show();
        $('#couponInput').hide();
    } else {
        $('#discountRow').hide();
        $('#couponAppliedMsg').hide();
        $('#couponInput').show();
    }

    let taxableAmount = subTotal - discount;
    let totalTax = 0;
    let taxHtml = '';
    taxes.forEach(t => {
        let lineTax = taxableAmount * (t.percentage / 100);
        totalTax += lineTax;
        taxHtml += `<div class="summary-row tax">
            <span class="label">${t.name} (${t.percentage}%)</span>
            <span class="val">৳${lineTax.toFixed(2)}</span>
        </div>`;
    });

    let grandTotal = taxableAmount + totalTax;

    $('#subTotalDisplay').text('৳' + subTotal.toFixed(2));
    $('#taxBreakdown').html(taxHtml);
    $('#grandTotalDisplay').text('৳' + grandTotal.toFixed(2));
}

function applyCoupon() {
    let code = $('#couponInput').val();
    let subTotal = cart.reduce((sum, i) => sum + (i.unit_price * i.quantity), 0);
    if (!code) return;
    if (subTotal <= 0) { alert('Cart is empty'); return; }

    $.post("{{ route('saller.pos.applyCoupon') }}", {
        code: code,
        sub_total: subTotal,
        _token: "{{ csrf_token() }}"
    }, function(res) {
        if (res.success) {
            couponData = res;
            renderCart();
        }
    }).fail(function(xhr) {
        alert(xhr.responseJSON.message || 'Invalid coupon');
    });
}

function removeCoupon() {
    couponData = null;
    $('#couponInput').val('');
    renderCart();
}

function updateQty(index, delta) {
    cart[index].quantity += delta;
    if(cart[index].quantity < 1) cart.splice(index, 1);
    renderCart();
}

function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

// Customer Search
$('#customerSearch').on('keyup', function() {
    let q = $(this).val();
    if(q.length < 1) { $('#customerDropdown').hide(); return; }
    $.get("{{ route('saller.pos.searchCustomers') }}", {q: q}, function(res) {
        if(res.success && res.data.length) {
            let html = '';
            res.data.forEach(c => {
                let initial = c.name.charAt(0).toUpperCase();
                html += `
                <div class="customer-item" onclick='selectCustomer(${JSON.stringify(c)})'>
                    <div class="customer-avatar-small">${initial}</div>
                    <div class="customer-info-small">
                        <strong>${c.name}</strong>
                        <span>${c.phone} ${c.email ? '| ' + c.email : ''}</span>
                    </div>
                </div>`;
            });
            $('#customerDropdown').html(html).show();
        } else {
            $('#customerDropdown').html('<div class="p-3 text-center text-muted" style="font-size:12px">No customers found</div>').show();
        }
    });
});

function selectCustomer(c) {
    selectedCustomer = c;
    $('#sctName').text(c.name);
    $('#sctPhone').text(c.phone + (c.email ? ' | ' + c.email : ''));
    $('#sctAvatar').text(c.name.charAt(0).toUpperCase());
    $('#selectedCustomerTag').css('display', 'flex');
    $('#customerSearch').hide();
    $('#customerDropdown').hide();
}

function clearCustomer() {
    selectedCustomer = null;
    $('#selectedCustomerTag').hide();
    $('#customerSearch').show().val('').focus();
}

function openModal(id) { $('#' + id).addClass('show'); }
function closeModal(id) { $('#' + id).removeClass('show'); }

function saveCustomer() {
    let data = {
        first_name: $('#custFirstName').val(),
        last_name: $('#custLastName').val(),
        phone: $('#custPhone').val(),
        email: $('#custEmail').val(),
        password: $('#custPassword').val(),
        _token: "{{ csrf_token() }}"
    };
    $.post("{{ route('saller.pos.storeCustomer') }}", data, function(res) {
        if(res.success) {
            selectCustomer(res.customer);
            closeModal('newCustomerModal');
        }
    }).fail(function(xhr) {
        alert('Error: ' + JSON.stringify(xhr.responseJSON.errors));
    });
}

function placeOrder(status) {
    if(!cart.length) { alert('Cart is empty'); return; }
    let subTotal = cart.reduce((sum, i) => sum + (i.unit_price * i.quantity), 0);
    
    let discount = couponData ? couponData.discount_amount : 0;
    let taxableAmount = subTotal - discount;
    let totalTax = 0;
    taxes.forEach(t => {
        totalTax += taxableAmount * (t.percentage / 100);
    });
    let grandTotal = taxableAmount + totalTax;

    let data = {
        items: cart,
        customer_id: selectedCustomer ? selectedCustomer.id : null,
        sub_total: subTotal,
        discount_amount: discount,
        tax_amount: totalTax,
        grand_total: grandTotal,
        coupon_code: couponData ? couponData.coupon_code : null,
        coupon_discount: discount,
        status: status,
        payment_method: 'cash',
        _token: "{{ csrf_token() }}"
    };
    $.post("{{ route('saller.pos.placeOrder') }}", data, function(res) {
        if(res.success) {
            alert('Order placed successfully! Invoice: ' + res.invoice_no);
            cart = [];
            couponData = null;
            clearCustomer();
            renderCart();
            window.open("{{ url('saller/pos/invoice') }}/" + res.session_id, '_blank');
        }
    });
}
</script>
@endsection
