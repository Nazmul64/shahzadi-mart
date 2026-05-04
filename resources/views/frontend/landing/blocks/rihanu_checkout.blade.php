<div class="checkout-container" id="checkout">
    <h2 class="section-title" style="font-size: 1.5rem; text-align: left;">{{ $content['title'] ?? 'অর্ডার করতে নিচের ফর্মে আপনার তথ্য দিন' }}</h2>
    
    <form id="rihanuOrderForm-{{ $block->id ?? rand() }}" class="rihanuOrderForm">
        <input type="hidden" name="landing_page_id" value="{{ $landing->id }}">
        
        <div class="checkout-grid">
            {{-- Left Column: Form --}}
            <div>
                <div class="billing-title">Billing details</div>
                <div class="form-group">
                    <label>আপনার নাম লিখুন *</label>
                    <input type="text" name="name" class="form-control" placeholder="আপনার নাম লিখুন" required>
                </div>
                <div class="form-group">
                    <label>আপনার পূর্ণ ঠিকানা লিখুন *</label>
                    <input type="text" name="address" class="form-control" placeholder="গ্রাম/মহল্লা, থানা, জেলা" required>
                </div>
                <div class="form-group">
                    <label>আপনার জেলা নির্বাচন করুন *</label>
                    <select name="shipping_area" class="form-control shipping_area_selector" required>
                        <option value="inside" data-cost="70">Dhaka City (70 ৳)</option>
                        <option value="outside" data-cost="130">Outside Dhaka (130 ৳)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Phone *</label>
                    <input type="text" name="phone" class="form-control" placeholder="01XXXXXXXXX" required>
                </div>

                <div class="billing-title" style="margin-top: 30px;">Shipping</div>
                <div style="background: #f9fbf7; padding: 15px; border-radius: 5px; border: 1px solid #eee;">
                    হোম ডেলিভারি ফ্রি
                </div>
            </div>

            {{-- Right Column: Products & Total --}}
            <div>
                <div class="billing-title">Your order</div>
                <div class="product-selector">
                    @php
                        $productIds = $content['product_ids'] ?? [$landing->product_id];
                        $checkoutProducts = \App\Models\Product::whereIn('id', $productIds)->get();
                    @endphp
                    
                    @foreach($checkoutProducts as $index => $prod)
                    <div class="product-option {{ $index == 0 ? 'active' : '' }}" 
                         data-id="{{ $prod->id }}" 
                         data-price="{{ $prod->discount_price ?? $prod->current_price }}" 
                         data-name="{{ $prod->name }}">
                        <input type="radio" name="selected_product" value="{{ $prod->id }}" {{ $index == 0 ? 'checked' : '' }}>
                        <img src="{{ asset('uploads/products/'.$prod->feature_image) }}" alt="{{ $prod->name }}">
                        <div class="product-info">
                            <h4>{{ $prod->name }}</h4>
                            <div class="product-qty">
                                <button type="button" class="qty-btn-block minus">-</button>
                                <span class="qty-val-block">1</span>
                                <button type="button" class="qty-btn-block plus">+</button>
                            </div>
                        </div>
                        <div class="product-price">৳{{ number_format($prod->discount_price ?? $prod->current_price) }}</div>
                    </div>
                    @endforeach
                </div>

                <div class="order-summary">
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span class="subtotal_display">৳0</span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping</span>
                        <span class="shipping_display">৳0</span>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span class="grand_total_display">৳0</span>
                    </div>
                </div>

                <div style="margin-top: 20px; background: #f9fbf7; padding: 15px; border-radius: 5px; font-size: 0.9rem; color: #666;">
                    অগ্রিম কোন টাকা ছাড়াই অর্ডার করুন। Pay with cash upon delivery.
                </div>

                <button type="submit" class="order-btn submitBtnBlock" style="width: 100%; border-radius: 10px; margin-top: 20px;">
                    অর্ডার কনফার্ম করুন ৳ <span class="btn_total_display">0</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        const form = $('#rihanuOrderForm-{{ $block->id ?? "default" }}');
        
        function updateCalc() {
            const activeOption = form.find('.product-option.active');
            const price = parseFloat(activeOption.data('price'));
            const qty = parseInt(activeOption.find('.qty-val-block').text());
            const shipping = parseInt(form.find('.shipping_area_selector').find(':selected').data('cost'));
            
            const subtotal = price * qty;
            const total = subtotal + shipping;

            form.find('.subtotal_display').text('৳' + subtotal.toLocaleString());
            form.find('.shipping_display').text('৳' + shipping.toLocaleString());
            form.find('.grand_total_display').text('৳' + total.toLocaleString());
            form.find('.btn_total_display').text(total.toLocaleString());
        }

        form.find('.product-option').click(function() {
            form.find('.product-option').removeClass('active');
            $(this).addClass('active');
            $(this).find('input[type="radio"]').prop('checked', true);
            updateCalc();
        });

        form.find('.plus').click(function(e) {
            e.stopPropagation();
            let q = parseInt($(this).siblings('.qty-val-block').text());
            $(this).siblings('.qty-val-block').text(++q);
            updateCalc();
        });

        form.find('.minus').click(function(e) {
            e.stopPropagation();
            let q = parseInt($(this).siblings('.qty-val-block').text());
            if(q > 1) $(this).siblings('.qty-val-block').text(--q);
            updateCalc();
        });

        form.find('.shipping_area_selector').change(updateCalc);

        updateCalc();

        form.on('submit', function(e) {
            e.preventDefault();
            const btn = form.find('.submitBtnBlock');
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> প্রসেসিং...');

            const activeOption = form.find('.product-option.active');
            const cart = [{
                id: activeOption.data('id'),
                qty: parseInt(activeOption.find('.qty-val-block').text()),
                price: parseFloat(activeOption.data('price')),
                name: activeOption.data('name')
            }];

            const formData = $(this).serializeArray();
            const data = {};
            formData.forEach(item => data[item.name] = item.value);
            data.cart = cart;
            data._token = "{{ csrf_token() }}";

            $.ajax({
                url: "{{ route('order.store') }}",
                method: "POST",
                data: data,
                success: function(res) {
                    if(res.success) window.location.href = res.redirect;
                    else { alert(res.message); btn.prop('disabled', false).html('অর্ডার কনফার্ম করুন'); }
                },
                error: function(xhr) {
                    alert('সমস্যা হয়েছে: ' + (xhr.responseJSON?.message || 'Error'));
                    btn.prop('disabled', false).html('অর্ডার কনফার্ম করুন');
                }
            });
        });
    });
</script>
