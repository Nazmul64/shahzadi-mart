@extends('admin.master')

@section('main-content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
.ce-root { font-family: 'Plus Jakarta Sans', sans-serif; background: #f4f6fb; min-height: 100vh; padding: 32px 36px 60px; color: #1a2340; }
.ce-header { display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:14px; margin-bottom:28px; }
.ce-header-left h1 { font-size:1.55rem; font-weight:800; color:#0d2a6b; letter-spacing:-0.4px; display:flex; align-items:center; gap:10px; }
.ce-header-left h1 .icon-wrap { width:38px; height:38px; background:linear-gradient(135deg,#fef3c7,#fde68a); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
.ce-breadcrumb { display:flex; align-items:center; gap:6px; font-size:0.8rem; color:#8494b3; margin-top:6px; padding-left:48px; }
.ce-breadcrumb a { color:#8494b3; text-decoration:none; transition:color .2s; }
.ce-breadcrumb a:hover { color:#0d2a6b; }
.ce-back-btn { display:inline-flex; align-items:center; gap:6px; background:#fff; color:#0d2a6b; border:1.5px solid #c7d2fe; border-radius:10px; padding:9px 18px; font-family:'Plus Jakarta Sans',sans-serif; font-size:0.85rem; font-weight:700; text-decoration:none; box-shadow:0 2px 8px rgba(13,42,107,.08); transition:all .18s; }
.ce-back-btn:hover { background:#eef2ff; transform:translateY(-1px); color:#0d2a6b; text-decoration:none; }
.ce-preview { background:linear-gradient(135deg,#0d2a6b 0%,#1e40af 100%); border-radius:14px; padding:18px 26px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:22px; box-shadow:0 6px 24px rgba(13,42,107,.22); }
.ce-preview-code { font-size:1.5rem; font-weight:800; color:#fff; letter-spacing:2px; font-family:'Courier New',monospace; text-shadow:0 2px 8px rgba(0,0,0,.2); }
.ce-preview-meta { display:flex; gap:12px; flex-wrap:wrap; }
.ce-preview-chip { background:rgba(255,255,255,.15); color:#fff; border:1px solid rgba(255,255,255,.25); border-radius:20px; padding:5px 14px; font-size:0.78rem; font-weight:700; }
.ce-preview-chip.green { background:rgba(16,185,129,.25); border-color:rgba(16,185,129,.4); }
.ce-preview-chip.red   { background:rgba(239,68,68,.25);  border-color:rgba(239,68,68,.4); }
.ce-preview-chip.amber { background:rgba(245,158,11,.25); border-color:rgba(245,158,11,.4); }
.ce-card { background:#fff; border-radius:16px; border:1px solid #e8edf8; box-shadow:0 4px 20px rgba(0,0,0,.06); overflow:hidden; }
.ce-card-header { background:linear-gradient(135deg,#78350f 0%,#d97706 100%); padding:20px 32px; display:flex; align-items:center; gap:12px; }
.ce-card-header h2 { font-size:1.05rem; font-weight:700; color:#fff; margin:0; }
.ce-card-header p  { font-size:0.78rem; color:rgba(255,255,255,.7); margin:3px 0 0; }
.ce-card-icon { width:44px; height:44px; background:rgba(255,255,255,.15); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; border:1px solid rgba(255,255,255,.2); }
.ce-errors { margin:24px 32px 0; background:#fff5f5; border:1px solid #fed7d7; border-left:4px solid #fc8181; border-radius:10px; padding:14px 18px; font-size:0.85rem; color:#742a2a; }
.ce-errors ul { margin:6px 0 0 18px; }
.ce-form-body { padding:30px 32px 36px; }
.ce-section-title { font-size:0.72rem; font-weight:800; letter-spacing:1px; text-transform:uppercase; color:#8494b3; display:flex; align-items:center; gap:10px; margin-bottom:22px; }
.ce-section-title::after { content:''; flex:1; height:1px; background:#edf0fb; }
.ce-field { display:grid; grid-template-columns:220px 1fr; gap:0 20px; align-items:flex-start; margin-bottom:22px; }
@media (max-width:700px) { .ce-field { grid-template-columns:1fr; } .ce-field-label { text-align:left !important; padding-right:0 !important; } }
.ce-field-label { text-align:right; padding-right:4px; padding-top:9px; }
.ce-field-label label { font-size:0.875rem; font-weight:700; color:#2c3a5a; display:block; }
.ce-field-label .hint { font-size:0.74rem; color:#a0aec0; font-weight:500; margin-top:2px; }
.ce-field-label .required { color:#ef4444; margin-left:2px; }
.ce-input, .ce-select { width:100%; border:1.5px solid #dde3f0; border-radius:10px; padding:10px 14px; font-family:'Plus Jakarta Sans',sans-serif; font-size:0.9rem; color:#1a2340; background:#f8faff; outline:none; transition:border-color .2s,box-shadow .2s,background .2s; }
.ce-input:focus, .ce-select:focus { border-color:#d97706; background:#fff; box-shadow:0 0 0 3px rgba(217,119,6,.1); }
.ce-input::placeholder { color:#b0bcd4; }
.ce-select { cursor:pointer; }
.ce-input-group { display:flex; align-items:center; gap:10px; }
.ce-input-group .ce-input { flex:1; max-width:280px; }
.ce-unit { font-size:0.88rem; font-weight:700; color:#8494b3; background:#f1f4fb; border:1.5px solid #dde3f0; border-radius:8px; padding:9px 14px; }
.ce-conditional { display:none; }
.ce-conditional.show { display:grid; }
.ce-divider { height:1px; background:#f0f3fa; margin:28px 0; }
.ce-submit-wrap { display:flex; justify-content:flex-end; gap:12px; margin-top:8px; padding-top:24px; border-top:1px solid #f0f3fa; }
.ce-btn-cancel { background:#fff; color:#5a6a85; border:1.5px solid #dde3f0; border-radius:10px; padding:11px 24px; font-family:'Plus Jakarta Sans',sans-serif; font-size:0.88rem; font-weight:700; text-decoration:none; cursor:pointer; transition:all .18s; }
.ce-btn-cancel:hover { background:#f4f6fb; color:#1a2340; text-decoration:none; }
.ce-btn-submit { background:linear-gradient(135deg,#78350f 0%,#d97706 100%); color:#fff; border:none; border-radius:10px; padding:11px 40px; font-family:'Plus Jakarta Sans',sans-serif; font-size:0.9rem; font-weight:700; cursor:pointer; box-shadow:0 4px 16px rgba(120,53,15,.28); transition:transform .18s,box-shadow .18s; display:inline-flex; align-items:center; gap:7px; }
.ce-btn-submit:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(120,53,15,.36); }
</style>

<div class="ce-root">

    <div class="ce-header">
        <div class="ce-header-left">
            <h1>
                <div class="icon-wrap">✏️</div>
                Edit Coupon
            </h1>
            <nav class="ce-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span>›</span>
                {{-- ✅ FIX --}}
                <a href="{{ route('admin.coupons.index') }}">Coupons</a>
                <span>›</span>
                <span>Edit: {{ $coupon->code }}</span>
            </nav>
        </div>
        {{-- ✅ FIX --}}
        <a href="{{ route('admin.coupons.index') }}" class="ce-back-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            Back to List
        </a>
    </div>

    {{-- Preview Bar --}}
    <div class="ce-preview">
        <div>
            <div style="font-size:.7rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.55);margin-bottom:4px;">Coupon Code</div>
            <div class="ce-preview-code">{{ $coupon->code }}</div>
        </div>
        <div class="ce-preview-meta">
            <span class="ce-preview-chip amber">{{ $coupon->type === 'discount_by_percentage' ? '% Percentage' : '$ Amount' }}</span>
            <span class="ce-preview-chip">
                @if($coupon->type === 'discount_by_percentage')
                    {{ number_format($coupon->percentage, 2) }}%
                @else
                    ${{ number_format($coupon->amount, 2) }}
                @endif
            </span>
            <span class="ce-preview-chip">Used: {{ $coupon->used ?? 0 }}</span>
            <span class="ce-preview-chip {{ $coupon->status === 'activated' ? 'green' : 'red' }}">
                {{ $coupon->status === 'activated' ? 'Active' : 'Inactive' }}
            </span>
        </div>
    </div>

    <div class="ce-card">

        <div class="ce-card-header">
            <div class="ce-card-icon">🎟️</div>
            <div>
                <h2>Update Coupon Details</h2>
                <p>Modify the fields below and save changes.</p>
            </div>
        </div>

        @if($errors->any())
        <div class="ce-errors">
            <strong>Please fix the following errors:</strong>
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        <div class="ce-form-body">
            {{-- ✅ FIX --}}
            <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="ce-section-title">Basic Information</div>

                {{-- Code --}}
                <div class="ce-field">
                    <div class="ce-field-label">
                        <label>Coupon Code <span class="required">*</span></label>
                        <div class="hint">Any language supported</div>
                    </div>
                    <div class="ce-field-control">
                        <input type="text" name="code" value="{{ old('code', $coupon->code) }}"
                               class="ce-input" style="font-weight:700;letter-spacing:.5px;">
                    </div>
                </div>

                {{-- Apply To --}}
                <div class="ce-field">
                    <div class="ce-field-label">
                        <label>Apply To <span class="required">*</span></label>
                    </div>
                    <div class="ce-field-control">
                        <select name="allow_product_type" id="allowProductType" onchange="handleProductType()" class="ce-select">
                            <option value="all"               {{ old('allow_product_type', $coupon->allow_product_type) == 'all'               ? 'selected' : '' }}>All Products</option>
                            <option value="category"          {{ old('allow_product_type', $coupon->allow_product_type) == 'category'          ? 'selected' : '' }}>Category</option>
                            <option value="sub_category"      {{ old('allow_product_type', $coupon->allow_product_type) == 'sub_category'      ? 'selected' : '' }}>Sub Category</option>
                            <option value="child_sub_category"{{ old('allow_product_type', $coupon->allow_product_type) == 'child_sub_category' ? 'selected' : '' }}>Child Sub Category</option>
                        </select>
                    </div>
                </div>

                {{-- Category --}}
                <div class="ce-field ce-conditional" id="categoryRow">
                    <div class="ce-field-label"><label>Category <span class="required">*</span></label></div>
                    <div class="ce-field-control">
                        <select name="category_id" class="ce-select">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $coupon->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Sub Category --}}
                <div class="ce-field ce-conditional" id="subCategoryRow">
                    <div class="ce-field-label"><label>Sub Category <span class="required">*</span></label></div>
                    <div class="ce-field-control">
                        <select name="sub_category_id" class="ce-select">
                            <option value="">Select Sub Category</option>
                            @foreach($subCategories as $sub)
                                <option value="{{ $sub->id }}" {{ old('sub_category_id', $coupon->sub_category_id) == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->sub_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Child Sub Category --}}
                <div class="ce-field ce-conditional" id="childSubRow">
                    <div class="ce-field-label"><label>Child Sub Category <span class="required">*</span></label></div>
                    <div class="ce-field-control">
                        <select name="child_sub_category_id" class="ce-select">
                            <option value="">Select Child Sub Category</option>
                            @foreach($childSubs as $child)
                                <option value="{{ $child->id }}" {{ old('child_sub_category_id', $coupon->child_sub_category_id) == $child->id ? 'selected' : '' }}>
                                    {{ $child->child_sub_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="ce-divider"></div>
                <div class="ce-section-title">Discount Configuration</div>

                {{-- Discount Type --}}
                <div class="ce-field">
                    <div class="ce-field-label"><label>Discount Type <span class="required">*</span></label></div>
                    <div class="ce-field-control">
                        <select name="type" id="couponType" onchange="handleType()" class="ce-select">
                            <option value="discount_by_percentage" {{ old('type', $coupon->type) == 'discount_by_percentage' ? 'selected' : '' }}>Discount By Percentage (%)</option>
                            <option value="discount_by_amount"     {{ old('type', $coupon->type) == 'discount_by_amount'     ? 'selected' : '' }}>Discount By Fixed Amount ($)</option>
                        </select>
                    </div>
                </div>

                {{-- Percentage --}}
                <div class="ce-field ce-conditional" id="percentageRow">
                    <div class="ce-field-label">
                        <label>Percentage <span class="required">*</span></label>
                        <div class="hint">Between 0 – 100</div>
                    </div>
                    <div class="ce-field-control">
                        <div class="ce-input-group">
                            <input type="number" name="percentage" value="{{ old('percentage', $coupon->percentage) }}"
                                   min="0" max="100" step="0.01" placeholder="0.00" class="ce-input">
                            <span class="ce-unit">%</span>
                        </div>
                    </div>
                </div>

                {{-- Amount --}}
                <div class="ce-field ce-conditional" id="amountRow">
                    <div class="ce-field-label"><label>Amount <span class="required">*</span></label></div>
                    <div class="ce-field-control">
                        <div class="ce-input-group">
                            <input type="number" name="amount" value="{{ old('amount', $coupon->amount) }}"
                                   min="0" step="0.01" placeholder="0.00" class="ce-input">
                            <span class="ce-unit">$</span>
                        </div>
                    </div>
                </div>

                <div class="ce-divider"></div>
                <div class="ce-section-title">Quantity & Validity</div>

                {{-- Quantity --}}
                <div class="ce-field">
                    <div class="ce-field-label"><label>Quantity <span class="required">*</span></label></div>
                    <div class="ce-field-control">
                        <select name="quantity" id="quantitySelect" onchange="handleQuantity()" class="ce-select">
                            <option value="unlimited" {{ old('quantity', $coupon->quantity) == 'unlimited' ? 'selected' : '' }}>Unlimited</option>
                            <option value="limited"   {{ old('quantity', $coupon->quantity) == 'limited'   ? 'selected' : '' }}>Limited</option>
                        </select>
                    </div>
                </div>

                {{-- Usage Limit --}}
                <div class="ce-field ce-conditional" id="quantityLimitRow">
                    <div class="ce-field-label">
                        <label>Usage Limit <span class="required">*</span></label>
                        <div class="hint">Max times redeemable</div>
                    </div>
                    <div class="ce-field-control">
                        <input type="number" name="quantity_limit" value="{{ old('quantity_limit', $coupon->quantity_limit) }}"
                               min="1" class="ce-input">
                    </div>
                </div>

                {{-- Start Date --}}
                <div class="ce-field">
                    <div class="ce-field-label"><label>Start Date <span class="required">*</span></label></div>
                    <div class="ce-field-control">
                        <input type="date" name="start_date"
                               value="{{ old('start_date', $coupon->start_date?->format('Y-m-d')) }}"
                               class="ce-input">
                    </div>
                </div>

                {{-- End Date --}}
                <div class="ce-field">
                    <div class="ce-field-label"><label>End Date <span class="required">*</span></label></div>
                    <div class="ce-field-control">
                        <input type="date" name="end_date"
                               value="{{ old('end_date', $coupon->end_date?->format('Y-m-d')) }}"
                               class="ce-input">
                    </div>
                </div>

                <div class="ce-submit-wrap">
                    {{-- ✅ FIX --}}
                    <a href="{{ route('admin.coupons.index') }}" class="ce-btn-cancel">Cancel</a>
                    <button type="submit" class="ce-btn-submit">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function handleProductType() {
    const val = document.getElementById('allowProductType').value;
    toggle('categoryRow',    val === 'category');
    toggle('subCategoryRow', val === 'sub_category');
    toggle('childSubRow',    val === 'child_sub_category');
}
function handleType() {
    const val = document.getElementById('couponType').value;
    toggle('percentageRow', val === 'discount_by_percentage');
    toggle('amountRow',     val === 'discount_by_amount');
}
function handleQuantity() {
    const val = document.getElementById('quantitySelect').value;
    toggle('quantityLimitRow', val === 'limited');
}
function toggle(id, show) {
    document.getElementById(id).classList.toggle('show', show);
}
handleProductType();
handleType();
handleQuantity();
</script>

@endsection
