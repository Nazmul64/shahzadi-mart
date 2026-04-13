@extends('admin.master')

@section('main-content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
.cf-root { font-family: 'Plus Jakarta Sans', sans-serif; background: #f4f6fb; min-height: 100vh; padding: 32px 36px 60px; color: #1a2340; }
.cf-header { display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:14px; margin-bottom:28px; }
.cf-header-left h1 { font-size:1.55rem; font-weight:800; color:#0d2a6b; letter-spacing:-0.4px; display:flex; align-items:center; gap:10px; }
.cf-header-left h1 .icon-wrap { width:38px; height:38px; background:linear-gradient(135deg,#dbeafe,#bfdbfe); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
.cf-breadcrumb { display:flex; align-items:center; gap:6px; font-size:0.8rem; color:#8494b3; margin-top:6px; padding-left:48px; }
.cf-breadcrumb a { color:#8494b3; text-decoration:none; transition:color .2s; }
.cf-breadcrumb a:hover { color:#0d2a6b; }
.cf-back-btn { display:inline-flex; align-items:center; gap:6px; background:#fff; color:#0d2a6b; border:1.5px solid #c7d2fe; border-radius:10px; padding:9px 18px; font-family:'Plus Jakarta Sans',sans-serif; font-size:0.85rem; font-weight:700; text-decoration:none; cursor:pointer; box-shadow:0 2px 8px rgba(13,42,107,.08); transition:all .18s; }
.cf-back-btn:hover { background:#eef2ff; transform:translateY(-1px); color:#0d2a6b; text-decoration:none; }
.cf-card { background:#fff; border-radius:16px; border:1px solid #e8edf8; box-shadow:0 4px 20px rgba(0,0,0,.06); overflow:hidden; }
.cf-card-header { background:linear-gradient(135deg,#0d2a6b 0%,#1e40af 100%); padding:20px 32px; display:flex; align-items:center; gap:12px; }
.cf-card-header h2 { font-size:1.05rem; font-weight:700; color:#fff; margin:0; }
.cf-card-header p { font-size:0.78rem; color:rgba(255,255,255,.65); margin:3px 0 0; }
.cf-card-icon { width:44px; height:44px; background:rgba(255,255,255,.12); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; border:1px solid rgba(255,255,255,.2); }
.cf-errors { margin:24px 32px 0; background:#fff5f5; border:1px solid #fed7d7; border-left:4px solid #fc8181; border-radius:10px; padding:14px 18px; font-size:0.85rem; color:#742a2a; }
.cf-errors ul { margin:6px 0 0 18px; }
.cf-errors ul li { margin-bottom:3px; }
.cf-form-body { padding:30px 32px 36px; }
.cf-section-title { font-size:0.72rem; font-weight:800; letter-spacing:1px; text-transform:uppercase; color:#8494b3; display:flex; align-items:center; gap:10px; margin-bottom:22px; }
.cf-section-title::after { content:''; flex:1; height:1px; background:#edf0fb; }
.cf-field { display:grid; grid-template-columns:220px 1fr; gap:0 20px; align-items:flex-start; margin-bottom:22px; }
@media (max-width:700px) { .cf-field { grid-template-columns:1fr; } .cf-field-label { text-align:left !important; padding-right:0 !important; } }
.cf-field-label { text-align:right; padding-right:4px; padding-top:9px; }
.cf-field-label label { font-size:0.875rem; font-weight:700; color:#2c3a5a; display:block; }
.cf-field-label .hint { font-size:0.74rem; color:#a0aec0; font-weight:500; margin-top:2px; }
.cf-field-label .required { color:#ef4444; margin-left:2px; }
.cf-input, .cf-select { width:100%; border:1.5px solid #dde3f0; border-radius:10px; padding:10px 14px; font-family:'Plus Jakarta Sans',sans-serif; font-size:0.9rem; color:#1a2340; background:#f8faff; outline:none; transition:border-color .2s,box-shadow .2s,background .2s; }
.cf-input:focus, .cf-select:focus { border-color:#1a47b8; background:#fff; box-shadow:0 0 0 3px rgba(26,71,184,.1); }
.cf-input::placeholder { color:#b0bcd4; }
.cf-select { cursor:pointer; }
.cf-input-group { display:flex; align-items:center; gap:10px; }
.cf-input-group .cf-input { flex:1; max-width:280px; }
.cf-unit { font-size:0.88rem; font-weight:700; color:#8494b3; background:#f1f4fb; border:1.5px solid #dde3f0; border-radius:8px; padding:9px 14px; white-space:nowrap; }
.cf-conditional { display:none; }
.cf-conditional.show { display:grid; }
.cf-divider { height:1px; background:#f0f3fa; margin:28px 0; }
.cf-submit-wrap { display:flex; justify-content:flex-end; gap:12px; margin-top:8px; padding-top:24px; border-top:1px solid #f0f3fa; }
.cf-btn-cancel { background:#fff; color:#5a6a85; border:1.5px solid #dde3f0; border-radius:10px; padding:11px 24px; font-family:'Plus Jakarta Sans',sans-serif; font-size:0.88rem; font-weight:700; text-decoration:none; cursor:pointer; transition:all .18s; }
.cf-btn-cancel:hover { background:#f4f6fb; color:#1a2340; text-decoration:none; }
.cf-btn-submit { background:linear-gradient(135deg,#0d2a6b 0%,#1a47b8 100%); color:#fff; border:none; border-radius:10px; padding:11px 40px; font-family:'Plus Jakarta Sans',sans-serif; font-size:0.9rem; font-weight:700; cursor:pointer; box-shadow:0 4px 16px rgba(13,42,107,.28); transition:transform .18s,box-shadow .18s; display:inline-flex; align-items:center; gap:7px; }
.cf-btn-submit:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(13,42,107,.36); }
</style>

<div class="cf-root">

    <div class="cf-header">
        <div class="cf-header-left">
            <h1>
                <div class="icon-wrap">🏷️</div>
                Add New Coupon
            </h1>
            <nav class="cf-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span>›</span>
                {{-- ✅ FIX --}}
                <a href="{{ route('admin.coupons.index') }}">Coupons</a>
                <span>›</span>
                <span>Add New</span>
            </nav>
        </div>
        {{-- ✅ FIX --}}
        <a href="{{ route('admin.coupons.index') }}" class="cf-back-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            Back to List
        </a>
    </div>

    <div class="cf-card">

        <div class="cf-card-header">
            <div class="cf-card-icon">🎟️</div>
            <div>
                <h2>Coupon Information</h2>
                <p>Fill in the details below to create a new discount coupon.</p>
            </div>
        </div>

        @if($errors->any())
        <div class="cf-errors">
            <strong>Please fix the following errors:</strong>
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        <div class="cf-form-body">
            {{-- ✅ FIX --}}
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf

                <div class="cf-section-title">Basic Information</div>

                {{-- Code --}}
                <div class="cf-field">
                    <div class="cf-field-label">
                        <label>Coupon Code <span class="required">*</span></label>
                        <div class="hint">Any language supported</div>
                    </div>
                    <div class="cf-field-control">
                        <input type="text" name="code" value="{{ old('code') }}"
                               placeholder="e.g. SAVE20, EID50…"
                               class="cf-input" style="font-weight:700;letter-spacing:.5px;">
                    </div>
                </div>

                {{-- Apply To --}}
                <div class="cf-field">
                    <div class="cf-field-label">
                        <label>Apply To <span class="required">*</span></label>
                        <div class="hint">Which products qualify?</div>
                    </div>
                    <div class="cf-field-control">
                        <select name="allow_product_type" id="allowProductType"
                                onchange="handleProductType()" class="cf-select">
                            <option value="">— Select scope —</option>
                            <option value="all"               {{ old('allow_product_type') == 'all'               ? 'selected' : '' }}>All Products</option>
                            <option value="category"          {{ old('allow_product_type') == 'category'          ? 'selected' : '' }}>Category</option>
                            <option value="sub_category"      {{ old('allow_product_type') == 'sub_category'      ? 'selected' : '' }}>Sub Category</option>
                            <option value="child_sub_category"{{ old('allow_product_type') == 'child_sub_category'? 'selected' : '' }}>Child Sub Category</option>
                        </select>
                    </div>
                </div>

                {{-- Category --}}
                <div class="cf-field cf-conditional" id="categoryRow">
                    <div class="cf-field-label"><label>Category <span class="required">*</span></label></div>
                    <div class="cf-field-control">
                        <select name="category_id" class="cf-select">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Sub Category --}}
                <div class="cf-field cf-conditional" id="subCategoryRow">
                    <div class="cf-field-label"><label>Sub Category <span class="required">*</span></label></div>
                    <div class="cf-field-control">
                        <select name="sub_category_id" class="cf-select">
                            <option value="">Select Sub Category</option>
                            @foreach($subCategories as $sub)
                                <option value="{{ $sub->id }}" {{ old('sub_category_id') == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->sub_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Child Sub Category --}}
                <div class="cf-field cf-conditional" id="childSubRow">
                    <div class="cf-field-label"><label>Child Sub Category <span class="required">*</span></label></div>
                    <div class="cf-field-control">
                        <select name="child_sub_category_id" class="cf-select">
                            <option value="">Select Child Sub Category</option>
                            @foreach($childSubs as $child)
                                <option value="{{ $child->id }}" {{ old('child_sub_category_id') == $child->id ? 'selected' : '' }}>
                                    {{ $child->child_sub_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="cf-divider"></div>
                <div class="cf-section-title">Discount Configuration</div>

                {{-- Discount Type --}}
                <div class="cf-field">
                    <div class="cf-field-label"><label>Discount Type <span class="required">*</span></label></div>
                    <div class="cf-field-control">
                        <select name="type" id="couponType" onchange="handleType()" class="cf-select">
                            <option value="">— Choose type —</option>
                            <option value="discount_by_percentage" {{ old('type') == 'discount_by_percentage' ? 'selected' : '' }}>Discount By Percentage (%)</option>
                            <option value="discount_by_amount"     {{ old('type') == 'discount_by_amount'     ? 'selected' : '' }}>Discount By Fixed Amount ($)</option>
                        </select>
                    </div>
                </div>

                {{-- Percentage --}}
                <div class="cf-field cf-conditional" id="percentageRow">
                    <div class="cf-field-label">
                        <label>Percentage <span class="required">*</span></label>
                        <div class="hint">Between 0 – 100</div>
                    </div>
                    <div class="cf-field-control">
                        <div class="cf-input-group">
                            <input type="number" name="percentage" value="{{ old('percentage') }}"
                                   min="0" max="100" step="0.01" placeholder="0.00" class="cf-input">
                            <span class="cf-unit">%</span>
                        </div>
                    </div>
                </div>

                {{-- Amount --}}
                <div class="cf-field cf-conditional" id="amountRow">
                    <div class="cf-field-label"><label>Amount <span class="required">*</span></label></div>
                    <div class="cf-field-control">
                        <div class="cf-input-group">
                            <input type="number" name="amount" value="{{ old('amount') }}"
                                   min="0" step="0.01" placeholder="0.00" class="cf-input">
                            <span class="cf-unit">$</span>
                        </div>
                    </div>
                </div>

                <div class="cf-divider"></div>
                <div class="cf-section-title">Quantity & Validity</div>

                {{-- Quantity --}}
                <div class="cf-field">
                    <div class="cf-field-label"><label>Quantity <span class="required">*</span></label></div>
                    <div class="cf-field-control">
                        <select name="quantity" id="quantitySelect" onchange="handleQuantity()" class="cf-select">
                            <option value="unlimited" {{ old('quantity','unlimited') == 'unlimited' ? 'selected' : '' }}>Unlimited</option>
                            <option value="limited"   {{ old('quantity') == 'limited' ? 'selected' : '' }}>Limited</option>
                        </select>
                    </div>
                </div>

                {{-- Usage Limit --}}
                <div class="cf-field cf-conditional" id="quantityLimitRow">
                    <div class="cf-field-label">
                        <label>Usage Limit <span class="required">*</span></label>
                        <div class="hint">Max times redeemable</div>
                    </div>
                    <div class="cf-field-control">
                        <input type="number" name="quantity_limit" value="{{ old('quantity_limit') }}"
                               min="1" placeholder="e.g. 100" class="cf-input">
                    </div>
                </div>

                {{-- Start Date --}}
                <div class="cf-field">
                    <div class="cf-field-label"><label>Start Date <span class="required">*</span></label></div>
                    <div class="cf-field-control">
                        <input type="date" name="start_date" value="{{ old('start_date') }}" class="cf-input">
                    </div>
                </div>

                {{-- End Date --}}
                <div class="cf-field">
                    <div class="cf-field-label"><label>End Date <span class="required">*</span></label></div>
                    <div class="cf-field-control">
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="cf-input">
                    </div>
                </div>

                <div class="cf-submit-wrap">
                    {{-- ✅ FIX --}}
                    <a href="{{ route('admin.coupons.index') }}" class="cf-btn-cancel">Cancel</a>
                    <button type="submit" class="cf-btn-submit">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Create Coupon
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function handleProductType() {
    const val = document.getElementById('allowProductType').value;
    toggleConditional('categoryRow',    val === 'category');
    toggleConditional('subCategoryRow', val === 'sub_category');
    toggleConditional('childSubRow',    val === 'child_sub_category');
}
function handleType() {
    const val = document.getElementById('couponType').value;
    toggleConditional('percentageRow', val === 'discount_by_percentage');
    toggleConditional('amountRow',     val === 'discount_by_amount');
}
function handleQuantity() {
    const val = document.getElementById('quantitySelect').value;
    toggleConditional('quantityLimitRow', val === 'limited');
}
function toggleConditional(id, show) {
    const el = document.getElementById(id);
    if (show) el.classList.add('show');
    else      el.classList.remove('show');
}
handleProductType();
handleType();
handleQuantity();
</script>

@endsection
