<div class="checkout-professional" id="checkout-form-section">
    <div class="order-form-container">
        <form id="proOrderForm" class="pro-order-form">
            @csrf
            <input type="hidden" name="landing_page_id" value="{{ $landing->id }}">
            <input type="hidden" name="product_id" value="{{ $landing->product_id }}">
            
            <div class="row-pro g-4">
                {{-- Left Column: Information & Payment --}}
                <div class="col-pro-8">
                    <div class="checkout-card">
                        <div class="card-header-pro">
                            <i class="bi bi-person-fill"></i> আপনার তথ্য দিন
                        </div>
                        <div class="card-body-pro">
                            <div class="mb-3">
                                <label class="form-label-pro">আপনার নাম লিখুন *</label>
                                <div class="input-group-pro">
                                    <span class="input-icon"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control-pro" placeholder="উদা: আব্দুল্লাহ" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label-pro">আপনার মোবাইল নাম্বার *</label>
                                <div class="input-group-pro">
                                    <span class="input-icon"><i class="bi bi-phone"></i></span>
                                    <input type="text" name="phone" class="form-control-pro" placeholder="উদা: 017XXXXXXXX" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label-pro">আপনার বিস্তারিত ঠিকানা লিখুন *</label>
                                <div class="input-group-pro">
                                    <span class="input-icon"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="address" class="form-control-pro" placeholder="গ্রাম/মহল্লা, থানা, জেলা" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label-pro">ডেলিভারি এরিয়া নির্বাচন করুন *</label>
                                <div class="input-group-pro">
                                    <span class="input-icon"><i class="bi bi-truck"></i></span>
                                    <select name="shipping_area" id="shipping_area_pro" class="form-select-pro" required>
                                        <option value="">নির্বাচন করুন</option>
                                        @foreach($shippingCharges as $charge)
                                            <option value="{{ $charge->area_name }}" data-cost="{{ $charge->amount }}">
                                                {{ $charge->area_name }} ({{ number_format($charge->amount) }} ৳)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-card mt-4">
                        <div class="card-header-pro">
                            <i class="bi bi-credit-card-fill"></i> পেমেন্ট পদ্ধতি
                        </div>
                        <div class="card-body-pro">
                            <div class="payment-options">
                                <label class="payment-option-pro active" onclick="selectPayment(this)">
                                    <input type="radio" name="payment_method" value="cod" checked>
                                    <div class="payment-content">
                                        <div class="payment-icon">💵</div>
                                        <div class="payment-text">
                                            <div class="payment-name">Cash on Delivery</div>
                                            <div class="payment-desc">পণ্য হাতে পেয়ে টাকা পরিশোধ করুন</div>
                                        </div>
                                    </div>
                                    <div class="payment-check"><i class="bi bi-check-circle-fill"></i></div>
                                </label>

                                @php
                                    $bkash = \App\Models\Paymentgetewaymanage::where('gateway_name', 'bkash')->where('status', 1)->first();
                                    $nagad = \App\Models\NagadSetting::where('status', 1)->first();
                                    $shurjopay = \App\Models\Paymentgetewaymanage::where('gateway_name', 'shurjopay')->where('status', 1)->first();
                                @endphp

                                @if($bkash)
                                <label class="payment-option-pro" onclick="selectPayment(this)">
                                    <input type="radio" name="payment_method" value="bkash">
                                    <div class="payment-content">
                                        <div class="payment-icon">
                                            <img src="{{ asset('uploads/generalsetting/bkash.png') }}" style="width: 30px; height: 30px; border-radius: 4px;" onerror="this.src='https://raw.githubusercontent.com/the-m-bakery/payment-logos/main/bkash/bkash_logo.png'">
                                        </div>
                                        <div class="payment-text">
                                            <div class="payment-name">bKash</div>
                                            <div class="payment-desc">বিকাশ দিয়ে পেমেন্ট করুন</div>
                                        </div>
                                    </div>
                                    <div class="payment-check"><i class="bi bi-check-circle-fill"></i></div>
                                </label>
                                @endif

                                @if($nagad)
                                <label class="payment-option-pro" onclick="selectPayment(this)">
                                    <input type="radio" name="payment_method" value="nagad">
                                    <div class="payment-content">
                                        <div class="payment-icon">
                                            <img src="{{ asset($nagad->logo ?? 'uploads/generalsetting/nagad.png') }}" style="width: 30px; height: 30px; border-radius: 4px;" onerror="this.src='https://raw.githubusercontent.com/the-m-bakery/payment-logos/main/nagad/nagad_logo.png'">
                                        </div>
                                        <div class="payment-text">
                                            <div class="payment-name">Nagad</div>
                                            <div class="payment-desc">নগদ দিয়ে পেমেন্ট করুন</div>
                                        </div>
                                    </div>
                                    <div class="payment-check"><i class="bi bi-check-circle-fill"></i></div>
                                </label>
                                @endif

                                @if($shurjopay)
                                <label class="payment-option-pro" onclick="selectPayment(this)">
                                    <input type="radio" name="payment_method" value="shurjopay">
                                    <div class="payment-content">
                                        <div class="payment-icon">💳</div>
                                        <div class="payment-text">
                                            <div class="payment-name">Online Payment</div>
                                            <div class="payment-desc">কার্ড বা মোবাইল ব্যাংকিং (Surjopay)</div>
                                        </div>
                                    </div>
                                    <div class="payment-check"><i class="bi bi-check-circle-fill"></i></div>
                                </label>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Summary --}}
                <div class="col-pro-4">
                    <div class="checkout-card h-100">
                        <div class="card-header-pro">
                            <i class="bi bi-cart-fill"></i> অর্ডার সামারি
                        </div>
                        <div class="card-body-pro">
                            <div id="pro-cart-items">
                                @php
                                    $allProductIds = [$landing->product_id];
                                    if (is_array($landing->product_ids)) {
                                        $allProductIds = array_unique(array_merge($allProductIds, $landing->product_ids));
                                    }
                                    $checkoutProducts = \App\Models\Product::whereIn('id', $allProductIds)->get();
                                @endphp

                                @if($checkoutProducts->count() > 1)
                                    <div class="product-selection-pro mb-4">
                                        <label class="form-label-pro mb-3">প্যাকেজ নির্বাচন করুন (একাধিক নির্বাচন করা যাবে):</label>
                                        @foreach($checkoutProducts as $index => $prod)
                                            <label class="product-option-pro active"
                                                   data-id="{{ $prod->id }}"
                                                   data-price="{{ $prod->discount_price ?? $prod->current_price }}"
                                                   data-name="{{ $prod->name }}"
                                                   data-image="{{ asset('uploads/products/'.$prod->feature_image) }}"
                                                   data-is-combo="true">
                                                <div class="payment-content">
                                                    <input type="checkbox" name="selected_product_id[]" value="{{ $prod->id }}" class="form-check-input me-3 mt-0" style="width: 20px; height: 20px; cursor: pointer; border: 2px solid #1a2b6b;" checked>
                                                    <div class="item-img-pro">
                                                        <img src="{{ asset('uploads/products/'.$prod->feature_image) }}" alt="">
                                                    </div>
                                                    <div class="payment-text">
                                                        <div class="payment-name">{{ $prod->name }}</div>
                                                        <div class="payment-desc">৳{{ number_format($prod->discount_price ?? $prod->current_price) }}</div>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    @php $prod = $checkoutProducts->first(); @endphp
                                    @if($prod)
                                    <div class="pro-cart-item" data-id="{{ $prod->id }}" data-price="{{ $prod->discount_price ?? $prod->current_price }}" data-name="{{ $prod->name }}">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="item-img-pro">
                                                <img src="{{ asset('uploads/products/'.$prod->feature_image) }}" alt="">
                                            </div>
                                            <div class="item-info-pro">
                                                <div class="item-name-pro">{{ $prod->name }}</div>
                                                <div class="item-qty-pro">
                                                    <button type="button" class="qty-btn-pro minus">-</button>
                                                    <span class="qty-val-pro">1</span>
                                                    <button type="button" class="qty-btn-pro plus">+</button>
                                                </div>
                                            </div>
                                            <div class="item-price-pro">
                                                ৳<span class="unit-price-pro">{{ number_format($prod->discount_price ?? $prod->current_price) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            </div>

                            @if($checkoutProducts->count() > 1)
                            <div class="selected-qty-wrap d-flex justify-content-between align-items-center mt-3 p-3 bg-light rounded-3">
                                <span class="fw-bold">পরিমাণ:</span>
                                <div class="item-qty-pro">
                                    <button type="button" class="qty-btn-pro minus">-</button>
                                    <span class="qty-val-pro">1</span>
                                    <button type="button" class="qty-btn-pro plus">+</button>
                                </div>
                            </div>
                            @endif

                            <div class="summary-divider"></div>

                            <div class="summary-rows">
                                <div class="summary-row">
                                    <span>সাবটোটাল</span>
                                    <span>৳<span id="subtotal-pro">0</span></span>
                                </div>
                                <div class="summary-row">
                                    <span>ডেলিভারি চার্জ</span>
                                    <span>৳<span id="shipping-pro">0</span></span>
                                </div>
                                <div class="summary-row" id="discount-row-pro" style="display: none; color: #10b981;">
                                    <span>অনলাইন পেমেন্ট ডিসকাউন্ট ({{ $websetting->payment_discount_percentage ?? 0 }}%)</span>
                                    <span>-৳<span id="discount-val-pro">0</span></span>
                                </div>
                                <div class="summary-row total">
                                    <span>সর্বমোট</span>
                                    <span>৳<span id="total-pro">0</span></span>
                                </div>
                            </div>

                            <div class="trust-badges mt-4">
                                <div class="trust-item"><i class="bi bi-shield-check"></i> ১০০% অরিজিনাল পণ্য</div>
                                <div class="trust-item"><i class="bi bi-arrow-counterclockwise"></i> সহজ রিটার্ন পলিসি</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="submit-wrap-pro mt-4">
                <button type="submit" class="confirm-btn-pro" id="submitBtnPro">
                    <span class="btn-text">অর্ডার নিশ্চিত করুন</span>
                    <span class="btn-price">৳<span id="btn-total-pro">0</span></span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --primary-pro: {{ $landing->btn_color ?? '#1a2b6b' }};
        --secondary-pro: #f8f9fa;
        --border-pro: #e2e8f0;
        --text-pro: #1e293b;
        --muted-pro: #64748b;
    }

    .checkout-professional { font-family: 'Hind Siliguri', sans-serif; color: var(--text-pro); }

    .row-pro {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 30px !important;
        width: 100% !important;
        margin: 0 !important;
    }

    @media (min-width: 768px) {
        .row-pro {
            grid-template-columns: 65% 35% !important;
            align-items: start !important;
        }
    }

    .order-form-container {
        max-width: 1200px !important;
        margin: 0 auto !important;
        width: 100% !important;
    }

    .col-pro-8, .col-pro-4 {
        width: auto !important;
        padding: 0 !important;
        min-width: 0 !important;
    }

    .checkout-card { background: #fff; border-radius: 16px; border: 1px solid var(--border-pro); overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
    .card-header-pro { background: var(--secondary-pro); padding: 16px 24px; font-weight: 700; font-size: 1.1rem; border-bottom: 1px solid var(--border-pro); color: var(--primary-pro); display: flex; align-items: center; gap: 10px; }
    .card-body-pro { padding: 24px; }

    .form-label-pro { font-weight: 600; margin-bottom: 8px; font-size: 0.95rem; color: #334155; display: block; }
    .input-group-pro { position: relative; display: flex; align-items: center; }
    .input-icon { position: absolute; left: 16px; color: var(--muted-pro); z-index: 10; }
    .form-control-pro, .form-select-pro { width: 100%; padding: 12px 16px 12px 45px; border: 1px solid var(--border-pro); border-radius: 10px; font-size: 1rem; transition: all 0.2s; background: #fff; }
    .form-control-pro:focus, .form-select-pro:focus { outline: none; border-color: var(--primary-pro); box-shadow: 0 0 0 3px rgba(26, 43, 107, 0.1); }

    .payment-options { display: flex; flex-direction: column; gap: 12px; }
    .payment-option-pro { display: flex; align-items: center; justify-content: space-between; padding: 16px; border: 2px solid var(--border-pro); border-radius: 12px; cursor: pointer; transition: all 0.2s; position: relative; }
    .payment-option-pro.active { border-color: var(--primary-pro); background: rgba(26, 43, 107, 0.02); }
    .payment-option-pro input { position: absolute; opacity: 0; }
    .payment-content { display: flex; align-items: center; gap: 12px; }
    .payment-icon { font-size: 1.5rem; }
    .payment-name { font-weight: 700; font-size: 1rem; }
    .payment-desc { font-size: 0.8rem; color: var(--muted-pro); }
    .payment-check { color: var(--primary-pro); font-size: 1.2rem; display: none; }
    .payment-option-pro.active .payment-check { display: block; }

    .pro-cart-item { padding: 10px 0; }
    .item-img-pro img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-pro); }
    .item-info-pro { flex: 1; }
    .item-name-pro { font-weight: 700; font-size: 0.95rem; margin-bottom: 5px; }
    .item-qty-pro { display: flex; align-items: center; gap: 8px; }
    .qty-btn-pro { border: 1px solid var(--border-pro); background: #fff; width: 24px; height: 24px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 700; cursor: pointer; transition: 0.2s; }
    .qty-btn-pro:hover { background: var(--secondary-pro); }
    .qty-val-pro { font-weight: 700; font-size: 0.9rem; min-width: 20px; text-align: center; }
    .item-price-pro { font-weight: 800; color: var(--primary-pro); font-size: 1.1rem; }

    .summary-divider { height: 1px; background: var(--border-pro); margin: 20px 0; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 500; color: var(--muted-pro); }
    .summary-row.total { color: var(--text-pro); font-weight: 800; font-size: 1.3rem; margin-top: 15px; border-top: 2px solid var(--secondary-pro); padding-top: 15px; }

    .trust-badges { display: flex; flex-direction: column; gap: 8px; }
    .trust-item { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--muted-pro); font-weight: 600; }
    .trust-item i { color: #10b981; }

    .submit-wrap-pro { width: 100%; margin-top: 30px; }
    .confirm-btn-pro { width: 100%; background: var(--primary-pro); color: #fff; border: none; padding: 22px 30px; border-radius: 15px; font-weight: 800; font-size: 1.4rem; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s; cursor: pointer; box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
    .confirm-btn-pro:hover { transform: translateY(-3px); box-shadow: 0 15px 45px rgba(0,0,0,0.2); opacity: 0.95; }
    .confirm-btn-pro:active { transform: translateY(0); }
</style>

<script>
    (function() {
        var form = document.getElementById('proOrderForm');
        var shippingSelect = document.getElementById('shipping_area_pro');

        // ── GA4 begin_checkout ──
        var beginCheckoutFired = false;
        form.addEventListener('focusin', function() {
            if (!beginCheckoutFired) {
                var calc = updateCalc();
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                    'event': 'begin_checkout',
                    'ecommerce': {
                        'currency': 'BDT',
                        'value': Number((calc.unitPrice * calc.qty).toFixed(2)),
                        'items': calc.selectedItems.map(function(item) {
                            return {
                                'item_id': item.id,
                                'item_name': item.name,
                                'price': Number(item.price.toFixed(2)),
                                'quantity': Number(item.qty)
                            };
                        })
                    }
                });
                beginCheckoutFired = true;
            }
        });

        function updateCalc() {
            var unitPrice = 0;
            var qtyEl = document.querySelector('.qty-val-pro');
            var qty = qtyEl ? parseInt(qtyEl.textContent) : 1;
            var selectedItems = [];

            var multiProductSelection = document.querySelector('.product-selection-pro');
            if (multiProductSelection) {
                var activeOptions = multiProductSelection.querySelectorAll('.product-option-pro.active');
                activeOptions.forEach(function(opt) {
                    var price = parseFloat(opt.dataset.price) || 0;
                    unitPrice += price;
                    selectedItems.push({
                        id: opt.dataset.id || '',
                        name: opt.dataset.name || '',
                        price: price,
                        qty: qty // applying global quantity to each item for backend
                    });
                });
            } else {
                var singleItem = document.querySelector('.pro-cart-item');
                if (singleItem) {
                    var price = parseFloat(singleItem.dataset.price) || 0;
                    unitPrice = price;
                    selectedItems.push({
                        id: singleItem.dataset.id || '',
                        name: singleItem.dataset.name || '',
                        price: price,
                        qty: qty
                    });
                }
            }

            var subtotal = unitPrice * qty;
            var selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
            var shipping = selectedOption ? (parseFloat(selectedOption.dataset.cost) || 0) : 0;

            var paymentMethod = '';
            var checkedPayment = document.querySelector('input[name="payment_method"]:checked');
            if (checkedPayment) {
                paymentMethod = checkedPayment.value;
            }

            var discountStatus = {{ !empty($websetting->payment_discount_status) ? 1 : 0 }};
            var discountPercentage = {{ !empty($websetting->payment_discount_percentage) ? (float)$websetting->payment_discount_percentage : 0 }};

            var discountAmount = 0;
            if (discountStatus && paymentMethod && paymentMethod !== 'cod') {
                discountAmount = (subtotal * discountPercentage) / 100;
                document.getElementById('discount-row-pro').style.display = 'flex';
                document.getElementById('discount-val-pro').textContent = discountAmount.toLocaleString();
            } else {
                document.getElementById('discount-row-pro').style.display = 'none';
                document.getElementById('discount-val-pro').textContent = '0';
            }

            var total = (subtotal - discountAmount) + shipping;

            document.getElementById('subtotal-pro').textContent = subtotal.toLocaleString();
            document.getElementById('shipping-pro').textContent = shipping.toLocaleString();
            document.getElementById('total-pro').textContent = total.toLocaleString();
            document.getElementById('btn-total-pro').textContent = total.toLocaleString();

            return { selectedItems: selectedItems, unitPrice: unitPrice, qty: qty };
        }

        // Handle Product Option Selection
        function bindProductOptionEvents() {
            var productOptions = document.querySelectorAll('.product-option-pro:not([data-bound="true"])');
            productOptions.forEach(function(opt) {
                opt.setAttribute('data-bound', 'true');
                
                opt.addEventListener('click', function(e) {
                    if (this.dataset.isCombo === 'true') {
                        e.preventDefault();
                        return;
                    }
                    var checkbox = this.querySelector('input[type="checkbox"]');
                    if (e.target !== checkbox) {
                        checkbox.checked = !checkbox.checked;
                    }
                    if (checkbox.checked) {
                        this.classList.add('active');
                    } else {
                        this.classList.remove('active');
                    }
                    updateCalc();
                });
            });
        }
        bindProductOptionEvents();

        // Dynamic Add to Checkout function exposed globally
        window.addDynamicProductToCheckout = function(productData) {
            var container = document.querySelector('.product-selection-pro');
            if (!container) {
                // If it's a single item layout, convert to multi item layout
                var cartItemsContainer = document.getElementById('pro-cart-items');
                var singleItem = document.querySelector('.pro-cart-item');
                if(singleItem && cartItemsContainer) {
                    var html = '<div class="product-selection-pro mb-4"><label class="form-label-pro mb-3">প্যাকেজ নির্বাচন করুন (একাধিক নির্বাচন করা যাবে):</label>';
                    
                    // Add existing item as a checkbox option
                    html += `<label class="product-option-pro active" data-id="${singleItem.dataset.id}" data-price="${singleItem.dataset.price}" data-name="${singleItem.dataset.name}" data-image="${singleItem.querySelector('img').src}" data-is-combo="true">
                                <div class="payment-content">
                                    <input type="checkbox" name="selected_product_id[]" value="${singleItem.dataset.id}" class="form-check-input me-3 mt-0" style="width: 20px; height: 20px; cursor: pointer; border: 2px solid #1a2b6b;" checked>
                                    <div class="item-img-pro"><img src="${singleItem.querySelector('img').src}" alt=""></div>
                                    <div class="payment-text">
                                        <div class="payment-name">${singleItem.dataset.name}</div>
                                        <div class="payment-desc">৳${parseFloat(singleItem.dataset.price).toLocaleString()}</div>
                                    </div>
                                </div>
                             </label>`;
                    html += '</div>';
                    
                    // Replace single item with multi item selection
                    cartItemsContainer.innerHTML = html;
                    
                    // Move quantity to selected-qty-wrap
                    var qtyWrap = document.querySelector('.selected-qty-wrap');
                    if(!qtyWrap) {
                        cartItemsContainer.insertAdjacentHTML('afterend', `
                        <div class="selected-qty-wrap d-flex justify-content-between align-items-center mt-3 p-3 bg-light rounded-3">
                            <span class="fw-bold">পরিমাণ:</span>
                            <div class="item-qty-pro">
                                <button type="button" class="qty-btn-pro minus">-</button>
                                <span class="qty-val-pro">1</span>
                                <button type="button" class="qty-btn-pro plus">+</button>
                            </div>
                        </div>`);
                        // Re-bind qty events
                        bindQtyEvents();
                    }
                    container = document.querySelector('.product-selection-pro');
                }
            }

            if (container) {
                // Check if product already exists
                var existingOption = container.querySelector(`.product-option-pro[data-id="${productData.id}"]`);
                if (existingOption) {
                    var checkbox = existingOption.querySelector('input[type="checkbox"]');
                    if (!checkbox.checked) {
                        existingOption.classList.add('active');
                        checkbox.checked = true;
                    }
                } else {
                    // Append new product option
                    var newHtml = `
                    <label class="product-option-pro active" data-id="${productData.id}" data-price="${productData.price}" data-name="${productData.name}" data-image="${productData.image}">
                        <div class="payment-content">
                            <input type="checkbox" name="selected_product_id[]" value="${productData.id}" class="form-check-input me-3 mt-0" style="width: 20px; height: 20px; cursor: pointer; border: 2px solid #1a2b6b;" checked>
                            <div class="item-img-pro"><img src="${productData.image}" alt=""></div>
                            <div class="payment-text">
                                <div class="payment-name">${productData.name}</div>
                                <div class="payment-desc">৳${parseFloat(productData.price).toLocaleString()}</div>
                            </div>
                        </div>
                    </label>`;
                    container.insertAdjacentHTML('beforeend', newHtml);
                }
                bindProductOptionEvents();
                updateCalc();
                window.showProToast('পণ্যটি সফলভাবে যুক্ত করা হয়েছে!');
            }
        };

        function bindQtyEvents() {
            document.querySelectorAll('.plus:not([data-bound="true"])').forEach(function(btn) {
                btn.setAttribute('data-bound', 'true');
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    var qVal = btn.closest('.item-qty-pro').querySelector('.qty-val-pro');
                    if (qVal) {
                        var q = parseInt(qVal.textContent);
                        qVal.textContent = q + 1;
                        updateCalc();
                    }
                });
            });

            document.querySelectorAll('.minus:not([data-bound="true"])').forEach(function(btn) {
                btn.setAttribute('data-bound', 'true');
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    var qVal = btn.closest('.item-qty-pro').querySelector('.qty-val-pro');
                    if (qVal) {
                        var q = parseInt(qVal.textContent);
                        if (q > 1) {
                            qVal.textContent = q - 1;
                            updateCalc();
                        }
                    }
                });
            });
        }
        bindQtyEvents();

        // Handle Payment Selection
        window.selectPayment = function(el) {
            document.querySelectorAll('.payment-option-pro').forEach(function(opt) {
                opt.classList.remove('active');
            });
            el.classList.add('active');
            var radio = el.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
            updateCalc();
        };

        shippingSelect.addEventListener('change', updateCalc);
        updateCalc();

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var btn = document.getElementById('submitBtnPro');
            btn.disabled = true;
            var btnText = btn.querySelector('.btn-text');
            if (btnText) btnText.textContent = 'প্রসেসিং...';

            var calc = updateCalc();
            var cart = calc.selectedItems;
            
            if (cart.length === 0) {
                alert("দয়া করে কমপক্ষে একটি প্রোডাক্ট নির্বাচন করুন।");
                btn.disabled = false;
                if (btnText) btnText.textContent = 'অর্ডার নিশ্চিত করুন';
                return;
            }

            var formData = new FormData(this);
            var data = {};
            formData.forEach(function(value, key) { data[key] = value; });
            data.cart = cart;
            data._token = "{{ csrf_token() }}";
            data.landing_source = "landing_page";

            $.ajax({
                url: "{{ route('order.store') }}",
                method: "POST",
                data: data,
                success: function(res) {
                    if (res.success) {
                        window.location.href = res.redirect;
                    } else {
                        alert(res.message);
                        btn.disabled = false;
                        if (btnText) btnText.textContent = 'অর্ডার নিশ্চিত করুন';
                    }
                },
                error: function(xhr) {
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Error';
                    alert('সমস্যা হয়েছে: ' + msg);
                    btn.disabled = false;
                    if (btnText) btnText.textContent = 'অর্ডার নিশ্চিত করুন';
                }
            });
        });
    })();
</script>