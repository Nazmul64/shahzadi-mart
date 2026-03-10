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

    #catalogTable thead tr th { background:#fff; font-weight:600; font-size:.88rem; color:#333; border-bottom:2px solid #dee2e6; white-space:nowrap; }
    #catalogTable tbody tr td { font-size:.88rem; vertical-align:middle; }
    #catalogTable tbody tr:hover { background:#f8f9fa; }

    .prod-name  { font-weight:600; font-size:.9rem; color:#1a1a1a; }
    .prod-meta  { font-size:.75rem; color:#6c757d; margin-top:1px; }
    .prod-meta span { margin-right:10px; }

    .badge-type   { background:#e8ecf8; color:#1a2b6b; border-radius:20px; padding:4px 12px; font-size:.78rem; font-weight:600; white-space:nowrap; }
    .badge-type.physical           { background:#fdf2e9; color:#e67e22; }
    .badge-type.license            { background:#eaf4fb; color:#1a6fa0; }
    .badge-type.classified_listing { background:#f5eef8; color:#7d3c98; }
    .badge-type.service            { background:#e9f7ef; color:#1e8449; }

    .stock-badge           { background:#e8f8f5; color:#1e8449; border-radius:20px; padding:4px 12px; font-size:.78rem; font-weight:600; }
    .stock-badge.low       { background:#fdf2e9; color:#e67e22; }
    .stock-badge.out       { background:#fdedec; color:#c0392b; }
    .stock-badge.unlimited { background:#eaf4fb; color:#1a6fa0; }

    .price-text { font-weight:600; font-size:.9rem; }

    .btn-pill-green { background:#1e8449; color:#fff; border:none; border-radius:20px; padding:5px 14px; font-size:.82rem; font-weight:500; display:inline-flex; align-items:center; gap:5px; cursor:pointer; text-decoration:none; white-space:nowrap; }
    .btn-pill-green:hover { background:#196f3d; color:#fff; }
    .btn-pill-red   { background:#c0392b; color:#fff; border:none; border-radius:20px; padding:5px 14px; font-size:.82rem; font-weight:500; display:inline-flex; align-items:center; gap:5px; cursor:pointer; text-decoration:none; white-space:nowrap; }
    .btn-pill-red:hover   { background:#a93226; color:#fff; }

    .actions-btn { background:#1a2b6b; color:#fff; border:none; border-radius:20px; padding:5px 16px; font-size:.82rem; font-weight:500; display:inline-flex; align-items:center; gap:5px; cursor:pointer; white-space:nowrap; }
    .actions-btn:hover { background:#152259; }
    .actions-wrap { position:relative; display:inline-block; }
    .actions-dropdown { display:none; position:absolute; right:0; top:calc(100% + 4px); background:#fff; border:1px solid #dee2e6; border-radius:8px; min-width:170px; z-index:999; box-shadow:0 4px 16px rgba(0,0,0,.1); overflow:hidden; }
    .actions-dropdown a,
    .actions-dropdown button { display:block; width:100%; padding:9px 16px; font-size:.83rem; text-align:left; border:none; background:none; color:#333; text-decoration:none; cursor:pointer; }
    .actions-dropdown a:hover,
    .actions-dropdown button:hover { background:#f0f3ff; color:#1a2b6b; }
    .actions-dropdown .dd-star:hover   { background:#fffbea; color:#d4a017; }
    .actions-dropdown .dd-danger:hover { background:#fdedec; color:#c0392b; }

    .btn-add-new { background:#1a2b6b; color:#fff !important; border:none; border-radius:25px; padding:8px 22px; font-size:.9rem; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:5px; }
    .btn-add-new:hover { background:#152259; }

    .star-icon { color:#f1c40f; font-size:1rem; margin-right:2px; }

    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button.current:hover { background:#1a2b6b !important; color:#fff !important; border-color:#1a2b6b !important; border-radius:4px; }
    .dataTables_paginate .paginate_button:hover { background:#e9ecef !important; color:#333 !important; border-color:#dee2e6 !important; }

    #galleryModal .modal-header { background:#1a2b6b; color:#fff; }
    #galleryModal .modal-header .btn-close { filter:invert(1); }
    .gal-thumb { width:120px; height:100px; object-fit:cover; border-radius:6px; border:1px solid #dee2e6; }
    .gal-card  { text-align:center; font-size:.75rem; color:#555; }
</style>

{{-- Gallery Modal --}}
<div class="modal fade" id="galleryModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalTitle">Product Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="galleryModalBody" class="d-flex flex-wrap gap-3">
                    <div class="text-center text-muted w-100 py-4">Loading...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-title-box mb-3">
    <h4>Products</h4>
    <small>Dashboard &rsaquo; Products &rsaquo; Catalog Products</small>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-3">
        <div class="text-end mb-2">
            <a href="{{ route('products.index') }}" class="btn-add-new">&#8592; All Products</a>
        </div>

        <table id="catalogTable" class="table table-bordered w-100">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $item)
                <tr>
                    {{-- Name + meta --}}
                    <td>
                        <div class="prod-name">
                            @if($item->is_highlighted)
                                <span class="star-icon" title="Highlighted">&#9733;</span>
                            @endif
                            {{ Str::limit($item->name, 55) }}
                        </div>
                        <div class="prod-meta">
                            <span>ID: {{ str_pad($item->id, 8, '0', STR_PAD_LEFT) }}</span>
                            @if($item->sku)   <span>SKU: {{ $item->sku }}</span>   @endif
                            @if($item->vendor)<span>VENDOR: {{ $item->vendor }}</span>@endif
                        </div>
                    </td>

                    {{-- Type --}}
                    <td class="text-center">
                        <span class="badge-type {{ $item->product_type }}">
                            {{ \App\Models\Product::$productTypes[$item->product_type] ?? ucfirst($item->product_type) }}
                        </span>
                    </td>

                    {{-- Stock --}}
                    <td class="text-center">
                        @if($item->is_unlimited || $item->stock === null)
                            <span class="stock-badge unlimited">Unlimited</span>
                        @elseif($item->stock == 0)
                            <span class="stock-badge out">Out Of Stock</span>
                        @elseif($item->stock <= 10)
                            <span class="stock-badge low">{{ $item->stock }} left</span>
                        @else
                            <span class="stock-badge">{{ $item->stock }}</span>
                        @endif
                    </td>

                    {{-- Price --}}
                    <td class="text-center">
                        <span class="price-text">{{ number_format($item->current_price, 2) }}$</span>
                        @if($item->discount_price)
                            <br><small class="text-muted text-decoration-line-through">{{ number_format($item->discount_price, 2) }}$</small>
                        @endif
                    </td>

                    {{-- Status toggle --}}
                    <td class="text-center">
                        <a href="{{ route('products.toggle-status', $item->id) }}"
                           class="btn-pill {{ $item->status === 'active' ? 'btn-pill-green' : 'btn-pill-red' }}">
                            {{ $item->status === 'active' ? 'Activated' : 'Deactivated' }}
                            <span style="font-size:.7rem;">&#9660;</span>
                        </a>
                    </td>

                    {{-- Actions --}}
                    <td class="text-center">
                        <div class="actions-wrap">
                            <button type="button" class="actions-btn" onclick="toggleDropdown(this)">
                                Actions <span style="font-size:.7rem;">&#9660;</span>
                            </button>
                            <div class="actions-dropdown">
                                <a href="{{ route('products.edit', $item->id) }}">&#9998; Edit</a>

                                @if(!empty($item->gallery_images) && count($item->gallery_images) > 0)
                                <a href="javascript:void(0)"
                                   onclick="openGallery({{ $item->id }}, '{{ addslashes($item->name) }}')">
                                    &#128444; View Gallery
                                </a>
                                @endif

                                <form action="{{ route('products.catalog.highlight', $item->id) }}" method="POST" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="dd-star">
                                        &#9733; {{ $item->is_highlighted ? 'Un-Highlight' : 'Highlight' }}
                                    </button>
                                </form>

                                <form action="{{ route('products.catalog.remove', $item->id) }}" method="POST"
                                      style="margin:0;" onsubmit="return confirm('Remove this product from catalog?')">
                                    @csrf
                                    <button type="submit" class="dd-danger">&#128465; Remove Catalog</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($products->isEmpty())
            <div class="text-center py-4 text-muted">
                <p style="font-size:.95rem;">No catalog products found.</p>
                <a href="{{ route('products.index') }}" class="btn-add-new" style="display:inline-flex;">View All Products</a>
            </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#catalogTable').DataTable({
        dom: '<"row align-items-center mb-3"<"col-auto"l><"col-auto"f>>rtip',
        order: [[0, 'asc']],
        pageLength: 10,
        language: {
            search: "Search:", lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: { previous: "Previous", next: "Next" }
        },
        columnDefs: [{ orderable: false, targets: [1,2,3,4,5] }]
    });
});

function toggleDropdown(btn) {
    var dd = btn.nextElementSibling;
    var isOpen = dd.style.display === 'block';
    document.querySelectorAll('.actions-dropdown').forEach(function(d){ d.style.display='none'; });
    dd.style.display = isOpen ? 'none' : 'block';
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.actions-wrap'))
        document.querySelectorAll('.actions-dropdown').forEach(function(d){ d.style.display='none'; });
});

var GALLERY_URL = "{{ url('admin/products') }}";
function openGallery(productId, productName) {
    document.querySelectorAll('.actions-dropdown').forEach(function(d){ d.style.display='none'; });
    document.getElementById('galleryModalTitle').textContent = productName + ' — Gallery';
    document.getElementById('galleryModalBody').innerHTML = '<div class="text-center text-muted w-100 py-4">Loading...</div>';
    var modal = new bootstrap.Modal(document.getElementById('galleryModal'));
    modal.show();
    fetch(GALLERY_URL + '/' + productId + '/catalog-gallery')
        .then(function(r){ return r.json(); })
        .then(function(data) {
            var body = '';
            if (!data.gallery || data.gallery.length === 0) {
                body = '<div class="text-center text-muted w-100 py-4">No gallery images found.</div>';
            } else {
                data.gallery.forEach(function(g) {
                    var meta = [g.color ? '🎨 '+g.color : '', g.size ? g.size : ''].filter(Boolean).join(' · ');
                    body += '<div class="gal-card"><img src="'+g.url+'" class="gal-thumb" alt="">'+(meta?'<div class="mt-1">'+meta+'</div>':'')+'</div>';
                });
            }
            document.getElementById('galleryModalBody').innerHTML = body;
        })
        .catch(function() {
            document.getElementById('galleryModalBody').innerHTML = '<div class="text-center text-danger w-100 py-4">Failed to load gallery.</div>';
        });
}
</script>

@endsection
