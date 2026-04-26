@extends('admin.master')

@section('main-content')

{{-- ═══════════════════════════════════════════════════════════════
     DEPENDENCIES
════════════════════════════════════════════════════════════════ --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
/* ── Root tokens ── */
:root {
    --brand-dark  : #1a2b6b;
    --brand-light : #152259;
    --brand-green : #1e8449;
    --brand-red   : #c0392b;
    --radius-pill : 20px;
    --radius-sm   : 6px;
    --shadow-card : 0 1px 6px rgba(0,0,0,.08);
}

/* ── Page title ── */
.page-title-box h4    { font-size:1.1rem; font-weight:700; margin-bottom:2px; color:#1a2b6b; }
.page-title-box small { color:#6c757d; font-size:.82rem; }

/* ── DataTable controls ── */
div.dataTables_wrapper div.dataTables_length label,
div.dataTables_wrapper div.dataTables_filter label { font-size:.88rem; }
div.dataTables_wrapper div.dataTables_filter input {
    border:1px solid #ced4da; border-radius:.375rem;
    padding:.3rem .6rem; font-size:.88rem;
}
div.dataTables_wrapper div.dataTables_length select {
    border:1px solid #ced4da; border-radius:.375rem;
    padding:.25rem .5rem; font-size:.88rem;
}
div.dataTables_wrapper div.dataTables_info,
div.dataTables_wrapper div.dataTables_paginate { font-size:.85rem; }

/* ── Table ── */
#productTable { border-collapse:separate; border-spacing:0; }
#productTable thead tr th {
    background:#f4f6fb;
    font-weight:700;
    font-size:.82rem;
    color:#1a2b6b;
    border-bottom:2px solid #dee2e6;
    white-space:nowrap;
    padding:10px 12px;
}
#productTable tbody tr td {
    font-size:.85rem;
    vertical-align:middle;
    padding:9px 12px;
    border-color:#f0f0f0;
}
#productTable tbody tr:hover { background:#f8faff; }

/* ── Feature image ── */
.prod-img {
    width:54px; height:54px; object-fit:cover;
    border-radius:var(--radius-sm); border:1px solid #e0e0e0;
    cursor:pointer; transition:transform .2s;
}
.prod-img:hover    { transform:scale(1.08); }
.prod-img-empty {
    width:54px; height:54px; border-radius:var(--radius-sm);
    background:#f0f0f0; display:flex; align-items:center;
    justify-content:center; font-size:.68rem; color:#aaa;
    border:1px dashed #ccc;
}

/* ── Gallery thumbs ── */
.gallery-thumbs             { display:flex; flex-wrap:wrap; gap:4px; margin-top:4px; }
.gallery-thumb-wrap         { position:relative; display:inline-block; }
.gallery-thumb-wrap img {
    width:36px; height:36px; object-fit:cover;
    border-radius:4px; border:1px solid #e0e0e0;
    cursor:pointer; transition:transform .2s;
}
.gallery-thumb-wrap img:hover { transform:scale(1.1); }
.gallery-thumb-badge        { position:absolute; bottom:-3px; left:0; right:0; display:flex; gap:2px; justify-content:center; }
.gbadge {
    font-size:.52rem; padding:1px 3px; border-radius:3px;
    font-weight:700; white-space:nowrap; max-width:35px;
    overflow:hidden; text-overflow:ellipsis; line-height:1.4;
}
.gbadge-color { background:#e8ecf8; color:#1a2b6b; }
.gbadge-size  { background:#e8f8f5; color:#1e8449; }

/* ── Variant chips ── */
.variant-list   { display:flex; flex-wrap:wrap; gap:4px; margin-top:4px; }
.variant-chip {
    display:inline-flex; align-items:center; gap:3px;
    background:#f4f6fb; border:1px solid #e2e8f0;
    border-radius:12px; padding:3px 8px; font-size:.74rem;
}
.variant-chip .vcolor-dot { width:9px; height:9px; border-radius:50%; border:1px solid #ccc; flex-shrink:0; }
.variant-chip .vsize      { font-weight:700; color:#1a2b6b; }
.variant-chip .vprice     { color:#1e8449; font-weight:600; }
.variant-chip .vstock     { color:#888; }

/* ── Pill buttons ── */
.btn-pill {
    border-radius:var(--radius-pill); padding:5px 13px;
    font-size:.8rem; font-weight:600; border:none;
    white-space:nowrap; display:inline-flex; align-items:center;
    gap:4px; cursor:pointer; text-decoration:none; transition:background .18s, transform .15s;
}
.btn-pill:hover             { transform:translateY(-1px); }
.btn-pill-green             { background:var(--brand-green); color:#fff; }
.btn-pill-green:hover       { background:#196f3d; color:#fff; }
.btn-pill-red               { background:var(--brand-red); color:#fff; }
.btn-pill-red:hover         { background:#a93226; color:#fff; }

.btn-edit-link {
    background:var(--brand-dark); color:#fff !important; border:none;
    border-radius:var(--radius-pill); padding:5px 14px;
    font-size:.8rem; font-weight:600; white-space:nowrap;
    text-decoration:none; display:inline-flex; align-items:center;
    gap:4px; transition:background .18s;
}
.btn-edit-link:hover { background:var(--brand-light); }

.btn-del {
    background:#e8ecf8; color:var(--brand-dark); border:none;
    border-radius:50%; width:30px; height:30px;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:.82rem; cursor:pointer; transition:background .18s, color .18s;
    vertical-align:middle;
}
.btn-del:hover { background:var(--brand-red); color:#fff; }

.btn-add-new {
    background:var(--brand-dark); color:#fff !important; border:none;
    border-radius:25px; padding:7px 20px;
    font-size:.85rem; font-weight:600; text-decoration:none;
    display:inline-flex; align-items:center; gap:5px;
    transition:background .18s, transform .15s;
}
.btn-add-new:hover { background:var(--brand-light); transform:translateY(-1px); }

/* ── Type badge ── */
.badge-type {
    background:#e8ecf8; color:var(--brand-dark);
    border-radius:var(--radius-pill); padding:4px 11px;
    font-size:.76rem; font-weight:700;
}

/* ── Stock badge ── */
.stock-badge {
    background:#e8f8f5; color:var(--brand-green);
    border-radius:var(--radius-pill); padding:4px 11px;
    font-size:.76rem; font-weight:700;
}
.stock-badge.low       { background:#fdf2e9; color:#e67e22; }
.stock-badge.out       { background:#fdedec; color:var(--brand-red); }
.stock-badge.unlimited { background:#eaf4fb; color:#1a6fa0; }

/* ── Label badges ── */
.flash-badge {
    display:inline-flex; align-items:center; gap:3px;
    background:#fff3cd; color:#b45309;
    border:1px solid #fcd34d;
    border-radius:var(--radius-pill); padding:3px 9px;
    font-size:.7rem; font-weight:700; white-space:nowrap;
}
.flash-badge svg { width:10px; height:10px; }
.flash-price     { font-size:.78rem; font-weight:700; color:var(--brand-red); }

.new-arrival-badge {
    display:inline-flex; align-items:center; gap:3px;
    background:#d1fae5; color:#065f46;
    border:1px solid #6ee7b7;
    border-radius:var(--radius-pill); padding:3px 9px;
    font-size:.7rem; font-weight:700; white-space:nowrap;
}
.bestseller-badge {
    display:inline-flex; align-items:center; gap:3px;
    background:#ede9fe; color:#5b21b6;
    border:1px solid #c4b5fd;
    border-radius:var(--radius-pill); padding:3px 9px;
    font-size:.7rem; font-weight:700; white-space:nowrap;
}

/* ── Pagination ── */
.dataTables_paginate .paginate_button.current,
.dataTables_paginate .paginate_button.current:hover {
    background:var(--brand-dark) !important; color:#fff !important;
    border-color:var(--brand-dark) !important; border-radius:4px;
}
.dataTables_paginate .paginate_button:hover {
    background:#e9ecef !important; color:#333 !important;
    border-color:#dee2e6 !important;
}

/* ── Lightbox ── */
#imgLightbox {
    display:none; position:fixed; inset:0;
    background:rgba(0,0,0,.82); z-index:9999;
    align-items:center; justify-content:center;
    flex-direction:column; gap:12px;
    backdrop-filter:blur(4px);
}
#imgLightbox.show     { display:flex; animation:lbIn .2s ease; }
@keyframes lbIn       { from{opacity:0;transform:scale(.96)} to{opacity:1;transform:scale(1)} }
#imgLightbox img      { max-width:88vw; max-height:78vh; border-radius:8px; box-shadow:0 8px 40px rgba(0,0,0,.6); }
#imgLightbox .lb-close {
    color:#fff; font-size:2rem; cursor:pointer;
    position:absolute; top:16px; right:22px; line-height:1;
    opacity:.8; transition:opacity .2s;
}
#imgLightbox .lb-close:hover { opacity:1; }
#imgLightbox .lb-meta        { color:rgba(255,255,255,.8); font-size:.86rem; text-align:center; }

/* ── Alert ── */
.alert-success { border-left:4px solid var(--brand-green); background:#f0fdf4; color:#1e5c30; }
</style>

{{-- ── Lightbox ── --}}
<div id="imgLightbox" onclick="closeLightbox()">
    <span class="lb-close" onclick="closeLightbox()">&times;</span>
    <img id="lbImg" src="" alt="">
    <div class="lb-meta" id="lbMeta"></div>
</div>

{{-- ── Page Header ── --}}
<div class="page-title-box mb-3">
    <h4>All Products</h4>
    <small>Dashboard &rsaquo; Products &rsaquo; All Products</small>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2 mb-3">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-3">

        {{-- ── Action Bar ── --}}
        <div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.products.deactivated') }}"  class="btn-add-new" style="background:#6c757d;">
                    Deactivated
                </a>
                <a href="{{ route('admin.products.catalog') }}"      class="btn-add-new" style="background:#1e8449;">
                    &#128218; Catalog
                </a>
                <a href="{{ route('admin.products.flash-sales') }}"  class="btn-add-new" style="background:#d97706;">
                    &#9889; Flash Sales
                </a>
                <a href="{{ route('admin.products.new-arrivals') }}" class="btn-add-new" style="background:#059669;">
                    &#10024; New Arrivals
                </a>
                <a href="{{ route('admin.products.bestsellers') }}"  class="btn-add-new" style="background:#7c3aed;">
                    &#11088; Bestsellers
                </a>
            </div>
            <a href="{{ route('admin.products.create') }}" class="btn-add-new">
                + Add New Product
            </a>
        </div>

        {{-- ── Products Table ── --}}
        <table id="productTable" class="table table-bordered w-100">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name / SKU</th>
                    <th>Category</th>
                    <th>Gallery</th>
                    <th>Variants</th>
                    <th>Price</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Labels</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Options</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $item)
                <tr>
                    {{-- Feature Image --}}
                    <td>
                        @if($item->feature_image && file_exists(public_path('uploads/products/' . $item->feature_image)))
                            <img
                                src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                class="prod-img"
                                title="{{ $item->name }}"
                                onclick="openLightbox('{{ asset('uploads/products/' . $item->feature_image) }}','{{ addslashes($item->name) }}')"
                            >
                        @else
                            <div class="prod-img-empty">No Img</div>
                        @endif
                    </td>

                    {{-- Name / Slug / SKU --}}
                    <td>
                        <div style="font-weight:700; color:#1a2b6b;">{{ $item->name }}</div>
                        <small class="text-muted d-block">{{ $item->slug }}</small>
                        @if($item->sku)
                            <small class="text-muted">SKU: <strong>{{ $item->sku }}</strong></small>
                        @endif
                        @if($item->vendor)
                            <small class="text-muted d-block">Vendor: {{ $item->vendor }}</small>
                        @endif
                    </td>

                    {{-- Category hierarchy --}}
                    <td style="min-width:120px;">
                        <div style="font-weight:600;">{{ $item->category->category_name ?? '—' }}</div>
                        @if($item->subCategory)
                            <small class="text-muted d-block">&#8627; {{ $item->subCategory->sub_name }}</small>
                        @endif
                        @if($item->childSubCategory)
                            <small class="text-muted d-block">&#8627; {{ $item->childSubCategory->child_sub_name }}</small>
                        @endif
                    </td>

                    {{-- Gallery --}}
                    <td style="min-width:110px;">
                        @php $gallery = $item->gallery_images ?? []; @endphp
                        @if(count($gallery) > 0)
                            <div class="gallery-thumbs">
                                @foreach($gallery as $gItem)
                                    @php
                                        $gImg   = is_array($gItem) ? $gItem['image'] : $gItem;
                                        $gColor = is_array($gItem) ? ($gItem['color'] ?? null) : null;
                                        $gSize  = is_array($gItem) ? ($gItem['size']  ?? null) : null;
                                        $gLabel = trim(($gColor ?? '') . ' ' . ($gSize ?? ''));
                                    @endphp
                                    @if($gImg && file_exists(public_path('uploads/products/' . $gImg)))
                                        <div class="gallery-thumb-wrap">
                                            <img
                                                src="{{ asset('uploads/products/' . $gImg) }}"
                                                title="{{ $gLabel ?: 'Gallery Image' }}"
                                                onclick="openLightbox('{{ asset('uploads/products/' . $gImg) }}','{{ addslashes($gLabel ?: 'Gallery Image') }}')"
                                            >
                                            <div class="gallery-thumb-badge">
                                                @if($gColor)<span class="gbadge gbadge-color" title="Color: {{ $gColor }}">{{ Str::limit($gColor, 4) }}</span>@endif
                                                @if($gSize) <span class="gbadge gbadge-size"  title="Size: {{ $gSize }}">{{ $gSize }}</span>@endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <small class="text-muted" style="font-size:.7rem;">{{ count($gallery) }} image(s)</small>
                        @else
                            <small class="text-muted">—</small>
                        @endif
                    </td>

                    {{-- Variants --}}
                    <td style="min-width:150px;">
                        @php $variants = $item->variants ?? []; @endphp
                        @if(count($variants) > 0)
                            <div class="variant-list">
                                @foreach($variants as $v)
                                    <div class="variant-chip">
                                        <span class="vcolor-dot" style="background:{{ $v['color'] ?? '#ccc' }};"></span>
                                        @if(!empty($v['size']))  <span class="vsize">{{ $v['size'] }}</span>@endif
                                        @if(!empty($v['price'])) <span class="vprice">৳{{ number_format($v['price'], 0) }}</span>@endif
                                        <span class="vstock">({{ $v['stock'] ?? 0 }})</span>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted" style="font-size:.7rem;">{{ count($variants) }} variant(s)</small>
                        @else
                            <small class="text-muted">—</small>
                        @endif
                    </td>

                    {{-- Price --}}
                    <td style="min-width:90px;">
                        <div style="font-weight:700; color:#1a2b6b;">৳{{ number_format($item->current_price, 2) }}</div>
                        @if($item->discount_price)
                            <small class="text-muted text-decoration-line-through d-block">৳{{ number_format($item->discount_price, 2) }}</small>
                        @endif
                        @if($item->is_flash_sale && $item->flash_sale_price)
                            <span class="flash-price">&#9889; ৳{{ number_format($item->flash_sale_price, 2) }}</span>
                        @endif
                    </td>

                    {{-- Stock --}}
                    <td class="text-center">
                        @if($item->is_unlimited || $item->stock === null)
                            <span class="stock-badge unlimited">Unlimited</span>
                        @elseif($item->stock == 0)
                            <span class="stock-badge out">Out of Stock</span>
                        @elseif($item->stock <= 10)
                            <span class="stock-badge low">{{ $item->stock }} left</span>
                        @else
                            <span class="stock-badge">{{ $item->stock }}</span>
                        @endif
                    </td>

                    {{-- Type --}}
                    <td class="text-center">
                        <span class="badge-type">{{ ucfirst(str_replace('_', ' ', $item->product_type)) }}</span>
                    </td>

                    {{-- Labels --}}
                    <td class="text-center" style="min-width:110px;">
                        <div class="d-flex flex-column gap-1 align-items-center">
                            @if($item->is_flash_sale)
                                <span class="flash-badge">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 2L4.093 12.688H11L10 22l8.907-10.688H13L13 2z"/></svg>
                                    Flash Sale
                                </span>
                            @endif
                            @if($item->is_new_arrival)
                                <span class="new-arrival-badge">&#10024; New</span>
                            @endif
                            @if($item->is_bestseller)
                                <span class="bestseller-badge">&#11088; Bestseller</span>
                            @endif
                            @if(!$item->is_flash_sale && !$item->is_new_arrival && !$item->is_bestseller)
                                <small class="text-muted">—</small>
                            @endif
                        </div>
                    </td>

                    {{-- Status Toggle --}}
                    <td class="text-center">
                        <a href="{{ route('admin.products.toggle-status', $item->id) }}"
                           class="btn-pill {{ $item->status === 'active' ? 'btn-pill-green' : 'btn-pill-red' }}"
                           onclick="return confirm('Toggle status for \'{{ addslashes($item->name) }}\'?')">
                            {{ $item->status === 'active' ? 'Active' : 'Inactive' }}
                            <span style="font-size:.65rem;">&#9660;</span>
                        </a>
                    </td>

                    {{-- Options --}}
                    <td class="text-center" style="white-space:nowrap;">
                        <a href="{{ route('admin.products.edit', $item->id) }}" class="btn-edit-link">
                            &#9998; Edit
                        </a>

                        <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST"
                              style="display:inline-block; margin-left:4px;"
                              onsubmit="return confirm('Delete \'{{ addslashes($item->name) }}\'? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-del" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-5 text-muted">
                        <div style="font-size:2rem;">📦</div>
                        <div style="font-weight:600; margin-top:6px;">No products found</div>
                        <small>Click "Add New Product" to get started.</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

{{-- ── Scripts ── --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#productTable').DataTable({
        dom: '<"row align-items-center mb-3"<"col-auto"l><"col-auto ms-auto"f>>rtip',
        order: [[1, 'asc']],
        pageLength: 10,
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries found",
            paginate: { previous: "Prev", next: "Next" }
        },
        columnDefs: [
            { orderable: false, targets: [0, 3, 4, 8, 9, 10] }
        ]
    });
});

/* ── Lightbox ── */
function openLightbox(src, label) {
    document.getElementById('lbImg').src           = src;
    document.getElementById('lbMeta').textContent  = label || '';
    document.getElementById('imgLightbox').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('imgLightbox').classList.remove('show');
    document.getElementById('lbImg').src = '';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
});
</script>

@endsection
