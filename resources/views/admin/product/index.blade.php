@extends('admin.master')

@section('main-content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    .page-title-box h4    { font-size:1.1rem; font-weight:600; margin-bottom:2px; }
    .page-title-box small { color:#6c757d; font-size:.82rem; }

    div.dataTables_wrapper div.dataTables_length label,
    div.dataTables_wrapper div.dataTables_filter label { font-size:.9rem; }
    div.dataTables_wrapper div.dataTables_filter input  { border:1px solid #ced4da; border-radius:.375rem; padding:.3rem .6rem; font-size:.9rem; }
    div.dataTables_wrapper div.dataTables_length select { border:1px solid #ced4da; border-radius:.375rem; padding:.25rem .5rem; font-size:.9rem; }
    div.dataTables_wrapper div.dataTables_info,
    div.dataTables_wrapper div.dataTables_paginate { font-size:.88rem; }

    #productTable thead tr th { background:#fff; font-weight:600; font-size:.88rem; color:#333; border-bottom:2px solid #dee2e6; white-space:nowrap; }
    #productTable tbody tr td { font-size:.88rem; vertical-align:middle; }
    #productTable tbody tr:hover { background:#f8f9fa; }

    .prod-img { width:55px; height:55px; object-fit:cover; border-radius:6px; border:1px solid #dee2e6; cursor:pointer; }
    .prod-img-empty { width:55px; height:55px; border-radius:6px; background:#e9ecef; display:flex; align-items:center; justify-content:center; font-size:.7rem; color:#6c757d; border:1px solid #dee2e6; }

    /* Gallery thumbnails */
    .gallery-thumbs { display:flex; flex-wrap:wrap; gap:5px; margin-top:5px; }
    .gallery-thumb-wrap { position:relative; display:inline-block; }
    .gallery-thumb-wrap img { width:38px; height:38px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6; cursor:pointer; }
    .gallery-thumb-badge { position:absolute; bottom:-2px; left:0; right:0; display:flex; gap:2px; justify-content:center; }
    .gbadge { font-size:.55rem; padding:1px 4px; border-radius:3px; font-weight:600; white-space:nowrap; max-width:36px; overflow:hidden; text-overflow:ellipsis; line-height:1.3; }
    .gbadge-color { background:#e8ecf8; color:#1a2b6b; }
    .gbadge-size  { background:#e8f8f5; color:#1e8449; }

    /* Variant chips */
    .variant-list { display:flex; flex-wrap:wrap; gap:4px; margin-top:4px; }
    .variant-chip { display:inline-flex; align-items:center; gap:4px; background:#f8f9fa; border:1px solid #dee2e6; border-radius:20px; padding:3px 8px; font-size:.75rem; }
    .variant-chip .vcolor-dot { width:10px; height:10px; border-radius:50%; border:1px solid #ccc; flex-shrink:0; }
    .variant-chip .vsize  { font-weight:600; color:#1a2b6b; }
    .variant-chip .vprice { color:#1e8449; }
    .variant-chip .vstock { color:#6c757d; }

    /* Buttons */
    .btn-pill { border-radius:20px; padding:5px 14px; font-size:.82rem; font-weight:500; border:none; white-space:nowrap; display:inline-flex; align-items:center; gap:5px; cursor:pointer; text-decoration:none; }
    .btn-pill-green { background:#1e8449; color:#fff; }
    .btn-pill-green:hover { background:#196f3d; color:#fff; }
    .btn-pill-red   { background:#c0392b; color:#fff; }
    .btn-pill-red:hover   { background:#a93226; color:#fff; }
    .btn-edit-link { background:#1a2b6b; color:#fff !important; border:none; border-radius:20px; padding:5px 16px; font-size:.82rem; white-space:nowrap; text-decoration:none; display:inline-flex; align-items:center; gap:4px; }
    .btn-edit-link:hover  { background:#152259; }
    .btn-del { background:#1a2b6b; color:#fff; border:none; border-radius:50%; width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center; font-size:.85rem; cursor:pointer; vertical-align:middle; }
    .btn-del:hover { background:#c0392b; }
    .btn-add-new { background:#1a2b6b; color:#fff !important; border:none; border-radius:25px; padding:8px 22px; font-size:.9rem; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:5px; }
    .btn-add-new:hover { background:#152259; }

    /* Badges */
    .badge-type   { background:#e8ecf8; color:#1a2b6b; border-radius:20px; padding:4px 12px; font-size:.78rem; font-weight:600; }
    .stock-badge  { background:#e8f8f5; color:#1e8449; border-radius:20px; padding:4px 12px; font-size:.78rem; font-weight:600; }
    .stock-badge.low      { background:#fdf2e9; color:#e67e22; }
    .stock-badge.out      { background:#fdedec; color:#c0392b; }
    .stock-badge.unlimited{ background:#eaf4fb; color:#1a6fa0; }

    /* Pagination */
    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button.current:hover { background:#1a2b6b !important; color:#fff !important; border-color:#1a2b6b !important; border-radius:4px; }
    .dataTables_paginate .paginate_button:hover { background:#e9ecef !important; color:#333 !important; border-color:#dee2e6 !important; }

    /* Lightbox */
    #imgLightbox { display:none; position:fixed; inset:0; background:rgba(0,0,0,.75); z-index:9999; align-items:center; justify-content:center; flex-direction:column; gap:10px; }
    #imgLightbox.show { display:flex; }
    #imgLightbox img  { max-width:90vw; max-height:80vh; border-radius:8px; box-shadow:0 4px 30px rgba(0,0,0,.5); }
    #imgLightbox .lb-close { color:#fff; font-size:2rem; cursor:pointer; position:absolute; top:18px; right:24px; line-height:1; }
    #imgLightbox .lb-meta  { color:#fff; font-size:.88rem; text-align:center; }
</style>

{{-- Lightbox --}}
<div id="imgLightbox" onclick="closeLightbox()">
    <span class="lb-close" onclick="closeLightbox()">&times;</span>
    <img id="lbImg" src="" alt="">
    <div class="lb-meta" id="lbMeta"></div>
</div>

<div class="page-title-box mb-3">
    <h4>All Products</h4>
    <small>Dashboard &rsaquo; Products &rsaquo; All Products</small>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center mb-2 gap-2 flex-wrap">
            <div class="d-flex gap-2">
                <a href="{{ route('products.deactivated') }}" class="btn-add-new" style="background:#6c757d;">
                    Deactivated
                </a>
                <a href="{{ route('products.catalog') }}" class="btn-add-new" style="background:#1e8449;">
                    Catalog
                </a>
            </div>
            <a href="{{ route('products.create') }}" class="btn-add-new">+ Add New Product</a>
        </div>

        <table id="productTable" class="table table-bordered w-100">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Gallery</th>
                    <th>Variants</th>
                    <th>Price</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $item)
                <tr>
                    {{-- Feature Image --}}
                    <td>
                        @if($item->feature_image && file_exists(public_path('uploads/products/'.$item->feature_image)))
                            <img src="{{ asset('uploads/products/'.$item->feature_image) }}"
                                 class="prod-img"
                                 onclick="openLightbox('{{ asset('uploads/products/'.$item->feature_image) }}', 'Feature Image')">
                        @else
                            <div class="prod-img-empty">No Img</div>
                        @endif
                    </td>

                    {{-- Name --}}
                    <td>
                        <div style="font-weight:600;">{{ $item->name }}</div>
                        <small class="text-muted">{{ $item->slug }}</small>
                        @if($item->sku)
                            <br><small class="text-muted">SKU: {{ $item->sku }}</small>
                        @endif
                    </td>

                    {{-- Category --}}
                    <td>
                        <div>{{ $item->category->category_name ?? 'N/A' }}</div>
                        @if($item->subCategory)
                            <small class="text-muted">&#8627; {{ $item->subCategory->sub_name }}</small>
                        @endif
                        @if($item->childSubCategory)
                            <small class="text-muted d-block">&#8627; {{ $item->childSubCategory->child_sub_name }}</small>
                        @endif
                    </td>

                    {{-- Gallery --}}
                    <td style="min-width:120px;">
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
                                    @if($gImg && file_exists(public_path('uploads/products/'.$gImg)))
                                    <div class="gallery-thumb-wrap">
                                        <img src="{{ asset('uploads/products/'.$gImg) }}"
                                             title="{{ $gLabel ?: 'Gallery Image' }}"
                                             onclick="openLightbox('{{ asset('uploads/products/'.$gImg) }}', '{{ $gLabel ?: 'Gallery Image' }}')">
                                        <div class="gallery-thumb-badge">
                                            @if($gColor)
                                                <span class="gbadge gbadge-color" title="Color: {{ $gColor }}">{{ Str::limit($gColor, 5) }}</span>
                                            @endif
                                            @if($gSize)
                                                <span class="gbadge gbadge-size" title="Size: {{ $gSize }}">{{ $gSize }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            <small class="text-muted" style="font-size:.72rem;">{{ count($gallery) }} image(s)</small>
                        @else
                            <small class="text-muted">—</small>
                        @endif
                    </td>

                    {{-- Variants --}}
                    <td style="min-width:160px;">
                        @php $variants = $item->variants ?? []; @endphp
                        @if(count($variants) > 0)
                            <div class="variant-list">
                                @foreach($variants as $v)
                                <div class="variant-chip">
                                    <span class="vcolor-dot" style="background:{{ $v['color'] ?? '#ccc' }};"></span>
                                    @if(!empty($v['size']))
                                        <span class="vsize">{{ $v['size'] }}</span>
                                    @endif
                                    @if(!empty($v['price']))
                                        <span class="vprice">${{ number_format($v['price'], 2) }}</span>
                                    @endif
                                    <span class="vstock">({{ $v['stock'] ?? 0 }})</span>
                                </div>
                                @endforeach
                            </div>
                            <small class="text-muted" style="font-size:.72rem;">{{ count($variants) }} variant(s)</small>
                        @else
                            <small class="text-muted">—</small>
                        @endif
                    </td>

                    {{-- Price --}}
                    <td>
                        <div style="font-weight:600;">${{ number_format($item->current_price, 2) }}</div>
                        @if($item->discount_price)
                            <small class="text-muted text-decoration-line-through">
                                ${{ number_format($item->discount_price, 2) }}
                            </small>
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
                        <span class="badge-type">{{ ucfirst($item->product_type) }}</span>
                    </td>

                    {{-- Status --}}
                    <td class="text-center">
                        <a href="{{ route('products.toggle-status', $item->id) }}"
                           class="btn-pill {{ $item->status === 'active' ? 'btn-pill-green' : 'btn-pill-red' }}">
                            {{ $item->status === 'active' ? 'Activated' : 'Deactivated' }}
                            <span style="font-size:.7rem;">&#9660;</span>
                        </a>
                    </td>

                    {{-- Options --}}
                    <td class="text-center" style="white-space:nowrap;">
                        <a href="{{ route('products.edit', $item->id) }}" class="btn-edit-link">&#9998; Edit</a>
                        <form action="{{ route('products.destroy', $item->id) }}" method="POST"
                              style="display:inline-block; margin-left:4px;"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-del" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#productTable').DataTable({
        dom: '<"row align-items-center mb-3"<"col-auto"l><"col-auto"f>>rtip',
        order: [[1, 'asc']],
        pageLength: 10,
        language: {
            search:     "Search:",
            lengthMenu: "Show _MENU_ entries",
            info:       "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate:   { previous: "Previous", next: "Next" }
        },
        columnDefs: [{ orderable: false, targets: [0, 3, 4, 7, 8, 9] }]
    });
});

function openLightbox(src, label) {
    document.getElementById('lbImg').src = src;
    document.getElementById('lbMeta').textContent = label || '';
    document.getElementById('imgLightbox').classList.add('show');
}
function closeLightbox() {
    document.getElementById('imgLightbox').classList.remove('show');
    document.getElementById('lbImg').src = '';
}
document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeLightbox(); });
</script>

@endsection
