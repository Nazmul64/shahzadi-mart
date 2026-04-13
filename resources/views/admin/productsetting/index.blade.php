@extends('admin.master')

@section('main-content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<style>
    body, .main-content { background: #f4f6f9; }

    .page-title-box h4    { font-size: 1rem; font-weight: 700; margin-bottom: 2px; color: #222; }
    .page-title-box small { color: #6c757d; font-size: .78rem; }

    .settings-card {
        background: #fff;
        border-radius: 4px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .setting-row {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #f0f2f5;
        padding: 7px 0;
        min-height: 40px;
    }
    .setting-row:last-child { border-bottom: none; }

    .setting-label {
        flex: 0 0 290px;
        text-align: right;
        font-size: .82rem;
        color: #444;
        font-weight: 500;
        padding-right: 20px;
        line-height: 1.3;
    }
    .setting-label .req { color: #c0392b; }

    .setting-control {
        flex: 1;
        padding-right: 16px;
    }

    .setting-control .form-control {
        width: 100%;
        max-width: 700px;
        font-size: .82rem;
        border: 1px solid #dde1e7;
        border-radius: 3px;
        padding: 5px 10px;
        color: #333;
        height: 32px;
        background: #fff;
    }
    .setting-control .form-control:focus {
        border-color: #1a2b6b;
        box-shadow: 0 0 0 .12rem rgba(26,43,107,.12);
        outline: none;
    }

    .section-header {
        text-align: center;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .08em;
        color: #555;
        background: #f5f6fa;
        padding: 7px 0;
        border-top: 1px solid #e9ecef;
        border-bottom: 1px solid #e9ecef;
        text-transform: uppercase;
    }

    .toggle-hidden { display: none; }

    .toggle-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 30px;
        padding: 4px 12px 4px 10px;
        font-size: .78rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        user-select: none;
        transition: background .15s;
        line-height: 1.4;
    }
    .toggle-pill.on  { background: #1e8449; color: #fff; }
    .toggle-pill.off { background: #c0392b; color: #fff; }
    .toggle-pill .dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #fff;
        opacity: .85;
        flex-shrink: 0;
    }
    .toggle-pill .arrow {
        font-size: .6rem;
        opacity: .8;
        margin-left: 2px;
    }

    .chips-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        max-width: 700px;
        background: #fff;
        border: 1px solid #dde1e7;
        border-radius: 3px;
        padding: 5px 8px;
        min-height: 34px;
        cursor: text;
        align-items: center;
    }
    .chip {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        background: #e8ecf8;
        color: #1a2b6b;
        border-radius: 20px;
        padding: 2px 8px 2px 10px;
        font-size: .76rem;
        font-weight: 600;
        border: 1px solid #c5ceed;
    }
    .chip-remove {
        background: none;
        border: none;
        color: #1a2b6b;
        font-size: .75rem;
        cursor: pointer;
        padding: 0 1px;
        line-height: 1;
        opacity: .8;
    }
    .chip-remove:hover { opacity: 1; }
    .chips-input {
        border: none;
        outline: none;
        font-size: .82rem;
        min-width: 80px;
        flex: 1;
        padding: 1px 0;
        color: #333;
    }
    .chips-hint {
        font-size: .72rem;
        color: #999;
        margin-top: 3px;
    }

    .btn-save {
        background: #1a2b6b;
        color: #fff;
        border: none;
        border-radius: 3px;
        padding: 8px 28px;
        font-size: .85rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-save:hover { background: #152259; }

    .alert { font-size: .84rem; }
</style>

<div class="page-title-box mb-3">
    <h4>Product Settings</h4>
    <small>Dashboard &rsaquo; Products &rsaquo; Product Settings</small>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2 mb-3">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger py-2 mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="settings-card">

    {{-- ✅ FIX: route name admin.product.settings.update --}}
    <form action="{{ route('admin.product.settings.update') }}" method="POST" id="settingsForm">
        @csrf
        @method('PUT')

        {{-- ── General ── --}}
        <div class="setting-row">
            <div class="setting-label">Display Stock Number</div>
            <div class="setting-control">
                @include('admin.productsetting.toggle', [
                    'name'    => 'display_stock_number',
                    'checked' => $settings->display_stock_number,
                ])
            </div>
        </div>

        <div class="setting-row">
            <div class="setting-label">Product Whole Sale Max Quantity <span class="req">*</span></div>
            <div class="setting-control">
                <input type="number" name="product_whole_sale_max_quantity" class="form-control"
                       min="1" value="{{ old('product_whole_sale_max_quantity', $settings->product_whole_sale_max_quantity) }}">
            </div>
        </div>

        {{-- ── HOME PAGE SECTION ── --}}
        <div class="section-header">HOME PAGE SECTION</div>

        @php
        $homeFields = [
            'display_flash_deal_products'  => 'Display Flash Deal Products',
            'display_hot_products'         => 'Display Hot Products',
            'display_new_products'         => 'Display New Products',
            'display_sale_products'        => 'Display Sale Products',
            'display_best_seller_products' => 'Display Best Seller Products',
            'display_popular_products'     => 'Display Popular Products',
            'display_top_rated_products'   => 'Display Top Rated Products',
            'display_big_save_products'    => 'Display Big Save Products',
            'display_trending_products'    => 'Display Trending Products',
        ];
        @endphp

        @foreach($homeFields as $field => $label)
        <div class="setting-row">
            <div class="setting-label">{{ $label }} <span class="req">*</span></div>
            <div class="setting-control">
                <input type="number" name="{{ $field }}" class="form-control"
                       min="1" value="{{ old($field, $settings->$field) }}">
            </div>
        </div>
        @endforeach

        {{-- ── CATEGORY PAGE SECTION ── --}}
        <div class="section-header">CATEGORY PAGE SECTION</div>

        <div class="setting-row">
            <div class="setting-label">Display Products Per Page <span class="req">*</span></div>
            <div class="setting-control">
                <input type="number" name="category_products_per_page" class="form-control"
                       min="1" value="{{ old('category_products_per_page', $settings->category_products_per_page) }}">
            </div>
        </div>

        {{-- ── VENDOR PAGE SECTION ── --}}
        <div class="section-header">VENDOR PAGE SECTION</div>

        <div class="setting-row">
            <div class="setting-label">Display Products Per Page <span class="req">*</span></div>
            <div class="setting-control">
                <input type="number" name="vendor_products_per_page" class="form-control"
                       min="1" value="{{ old('vendor_products_per_page', $settings->vendor_products_per_page) }}">
            </div>
        </div>

        {{-- ── PRODUCT DETAILS PAGE SECTION ── --}}
        <div class="section-header">PRODUCT DETAILS PAGE SECTION</div>

        <div class="setting-row">
            <div class="setting-label">Display Contact Seller</div>
            <div class="setting-control">
                @include('admin.productsetting.toggle', [
                    'name'    => 'display_contact_seller',
                    'checked' => $settings->display_contact_seller,
                ])
            </div>
        </div>

        <div class="setting-row">
            <div class="setting-label">Display Product By Seller <span class="req">*</span></div>
            <div class="setting-control">
                <input type="number" name="display_products_by_seller" class="form-control"
                       min="1" value="{{ old('display_products_by_seller', $settings->display_products_by_seller) }}">
            </div>
        </div>

        {{-- ── VENDOR PRODUCT CREATE ENABLE & DISABLE ── --}}
        <div class="section-header">VENDOR PRODUCT CREATE ENABLE &amp; DISABLE</div>

        @php
        $vendorToggles = [
            'vendor_physical_products'  => 'Vendor Physical Products',
            'vendor_digital_products'   => 'Vendor Digital Products',
            'vendor_license_products'   => 'Vendor License Products',
            'vendor_listing_products'   => 'Vendor Listing Products',
            'vendor_affiliate_products' => 'Vendor Affiliate Products',
        ];
        @endphp

        @foreach($vendorToggles as $field => $label)
        <div class="setting-row">
            <div class="setting-label">{{ $label }}</div>
            <div class="setting-control">
                @include('admin.productsetting.toggle', [
                    'name'    => $field,
                    'checked' => $settings->$field,
                ])
            </div>
        </div>
        @endforeach

        {{-- ── WISHLIST PAGE SECTION ── --}}
        <div class="section-header">WISHLIST PAGE SECTION</div>

        <div class="setting-row">
            <div class="setting-label">Display Products Per Page <span class="req">*</span></div>
            <div class="setting-control">
                <input type="number" name="wishlist_products_per_page" class="form-control"
                       min="1" value="{{ old('wishlist_products_per_page', $settings->wishlist_products_per_page) }}">
            </div>
        </div>

        <div class="setting-row">
            <div class="setting-label">View Wishlist Product Per Page <span class="req">*</span></div>
            <div class="setting-control">
                <div class="chips-wrap" id="chipsWrap" onclick="document.getElementById('chipsInput').focus()">
                    @foreach(array_filter(array_map('trim', explode(',', old('view_wishlist_product_per_page', $settings->view_wishlist_product_per_page)))) as $chip)
                        <span class="chip">{{ $chip }}<button type="button" class="chip-remove" onclick="removeChip(this)">&#10005;</button></span>
                    @endforeach
                    <input type="text" id="chipsInput" class="chips-input" placeholder="Type number &amp; press Enter">
                </div>
                <input type="hidden" name="view_wishlist_product_per_page" id="chipsHidden"
                       value="{{ old('view_wishlist_product_per_page', $settings->view_wishlist_product_per_page) }}">
                <div class="chips-hint">Type a number and press Enter to add</div>
            </div>
        </div>

        {{-- ── CATALOG & FILTER SECTION ── --}}
        <div class="section-header">CATALOG &amp; FILTER SECTION</div>

        <div class="setting-row">
            <div class="setting-label">Minimum Price <span class="req">*</span></div>
            <div class="setting-control">
                <input type="number" name="catalog_min_price" class="form-control"
                       min="0" step="0.01" value="{{ old('catalog_min_price', $settings->catalog_min_price) }}">
            </div>
        </div>

        <div class="setting-row">
            <div class="setting-label">Maximum Price <span class="req">*</span></div>
            <div class="setting-control">
                <input type="number" name="catalog_max_price" class="form-control"
                       min="0" step="0.01" value="{{ old('catalog_max_price', $settings->catalog_max_price) }}">
            </div>
        </div>

        <div class="setting-row">
            <div class="setting-label">View Product Per Page <span class="req">*</span></div>
            <div class="setting-control">
                <input type="number" name="catalog_view_product_per_page" class="form-control"
                       min="1" value="{{ old('catalog_view_product_per_page', $settings->catalog_view_product_per_page) }}">
            </div>
        </div>

        {{-- ── Save ── --}}
        <div class="setting-row" style="border-bottom: none; padding: 14px 0 14px 0;">
            <div style="flex: 0 0 290px;"></div>
            <div class="setting-control">
                <button type="submit" class="btn-save">Save</button>
            </div>
        </div>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function syncChipsHidden() {
    var chips = document.querySelectorAll('#chipsWrap .chip');
    var vals = Array.from(chips).map(function(c) {
        return c.childNodes[0].textContent.trim();
    });
    document.getElementById('chipsHidden').value = vals.join(',');
}

function removeChip(btn) {
    btn.closest('.chip').remove();
    syncChipsHidden();
}

document.getElementById('chipsInput').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' || e.key === ',') {
        e.preventDefault();
        var val = this.value.trim().replace(',', '');
        if (val && !isNaN(val) && val !== '') {
            var chip = document.createElement('span');
            chip.className = 'chip';
            chip.innerHTML = val + '<button type="button" class="chip-remove" onclick="removeChip(this)">&#10005;</button>';
            document.getElementById('chipsWrap').insertBefore(chip, this);
            this.value = '';
            syncChipsHidden();
        }
    }
    if (e.key === 'Backspace' && this.value === '') {
        var chips = document.querySelectorAll('#chipsWrap .chip');
        if (chips.length) {
            chips[chips.length - 1].remove();
            syncChipsHidden();
        }
    }
});
</script>

@endsection
