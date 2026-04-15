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

    #deactivatedTable thead tr th { background:#fff; font-weight:600; font-size:.88rem; color:#333; border-bottom:2px solid #dee2e6; white-space:nowrap; }
    #deactivatedTable tbody tr td { font-size:.88rem; vertical-align:middle; }
    #deactivatedTable tbody tr:hover { background:#f8f9fa; }

    .prod-name  { font-weight:600; font-size:.9rem; }
    .prod-id    { font-size:.75rem; color:#6c757d; }
    .badge-type { background:#e8ecf8; color:#1a2b6b; border-radius:20px; padding:4px 12px; font-size:.78rem; font-weight:600; }
    .stock-badge        { background:#e8f8f5; color:#1e8449; border-radius:20px; padding:4px 12px; font-size:.78rem; font-weight:600; }
    .stock-badge.low    { background:#fdf2e9; color:#e67e22; }
    .stock-badge.out    { background:#fdedec; color:#c0392b; }
    .price-text { font-weight:600; font-size:.9rem; }

    .btn-pill-red {
        background:#c0392b; color:#fff; border:none; border-radius:20px;
        padding:5px 14px; font-size:.82rem; font-weight:500;
        display:inline-flex; align-items:center; gap:5px; cursor:pointer;
        text-decoration:none; white-space:nowrap;
    }
    .btn-pill-red:hover { background:#a93226; color:#fff; }

    .actions-btn {
        background:#1a2b6b; color:#fff; border:none; border-radius:20px;
        padding:5px 14px; font-size:.82rem; font-weight:500;
        display:inline-flex; align-items:center; gap:5px; cursor:pointer;
        position:relative; white-space:nowrap;
    }
    .actions-btn:hover { background:#152259; }
    .actions-dropdown {
        display:none; position:absolute; right:0; top:calc(100% + 4px);
        background:#fff; border:1px solid #dee2e6; border-radius:8px;
        min-width:140px; z-index:999; box-shadow:0 4px 16px rgba(0,0,0,.1);
        overflow:hidden;
    }
    .actions-dropdown a,
    .actions-dropdown button {
        display:block; width:100%; padding:9px 14px; font-size:.83rem;
        text-align:left; border:none; background:none; color:#333;
        text-decoration:none; cursor:pointer;
    }
    .actions-dropdown a:hover,
    .actions-dropdown button:hover { background:#f0f3ff; color:#1a2b6b; }
    .actions-dropdown .dd-danger:hover { background:#fdedec; color:#c0392b; }
    .actions-wrap { position:relative; display:inline-block; }

    .btn-add-new {
        background:#1a2b6b; color:#fff !important; border:none;
        border-radius:25px; padding:8px 22px; font-size:.9rem; font-weight:500;
        text-decoration:none; display:inline-flex; align-items:center; gap:5px;
    }
    .btn-add-new:hover { background:#152259; }

    .flash-badge { display:inline-flex; align-items:center; gap:3px; background:#fff3cd; color:#b45309; border:1px solid #fcd34d; border-radius:20px; padding:3px 10px; font-size:.72rem; font-weight:700; white-space:nowrap; }
    .new-arrival-badge { display:inline-flex; align-items:center; gap:3px; background:#d1fae5; color:#065f46; border:1px solid #6ee7b7; border-radius:20px; padding:3px 10px; font-size:.72rem; font-weight:700; white-space:nowrap; }

    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button.current:hover { background:#1a2b6b !important; color:#fff !important; border-color:#1a2b6b !important; border-radius:4px; }
    .dataTables_paginate .paginate_button:hover { background:#e9ecef !important; color:#333 !important; border-color:#dee2e6 !important; }
</style>

<div class="page-title-box mb-3">
    <h4>Deactivated Products</h4>
    <small>Dashboard › Products › Deactivated Products</small>
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
            <a href="{{ route('admin.products.index') }}" class="btn-add-new">&#8592; All Products</a>
        </div>

        <table id="deactivatedTable" class="table table-bordered w-100">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Labels</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $item)
                <tr>
                    {{-- Name --}}
                    <td>
                        <div class="prod-name">{{ $item->name }}</div>
                        <div class="prod-id">ID: {{ str_pad($item->id, 8, '0', STR_PAD_LEFT) }}</div>
                        @if($item->category)
                            <small class="text-muted" style="font-size:.75rem;">{{ $item->category->category_name }}</small>
                        @endif
                    </td>

                    {{-- Type --}}
                    <td class="text-center">
                        <span class="badge-type">{{ ucfirst($item->product_type) }}</span>
                    </td>

                    {{-- Stock --}}
                    <td class="text-center">
                        @if($item->is_unlimited || $item->stock === null)
                            <span class="stock-badge" style="background:#eaf4fb;color:#1a6fa0;">Unlimited</span>
                        @elseif($item->stock == 0)
                            <span class="stock-badge out">Out of Stock</span>
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
                        @if($item->is_flash_sale && $item->flash_sale_price)
                            <br><small style="color:#c0392b;font-weight:700;">&#9889; ${{ number_format($item->flash_sale_price, 2) }}</small>
                        @endif
                    </td>

                    {{-- Labels --}}
                    <td class="text-center">
                        <div class="d-flex flex-column gap-1 align-items-center">
                            @if($item->is_flash_sale)
                                <span class="flash-badge">&#9889; Flash</span>
                            @endif
                            @if($item->is_new_arrival)
                                <span class="new-arrival-badge">&#10024; New</span>
                            @endif
                            @if(!$item->is_flash_sale && !$item->is_new_arrival)
                                <small class="text-muted">—</small>
                            @endif
                        </div>
                    </td>

                    {{-- Status --}}
                    <td class="text-center">
                        <a href="{{ route('admin.products.toggle-status', $item->id) }}"
                           class="btn-pill-red">
                            Deactivated <span style="font-size:.7rem;">&#9660;</span>
                        </a>
                    </td>

                    {{-- Options --}}
                    <td class="text-center">
                        <div class="actions-wrap">
                            <button type="button" class="actions-btn" onclick="toggleDropdown(this)">
                                Actions <span style="font-size:.7rem;">&#9660;</span>
                            </button>
                            <div class="actions-dropdown">
                                <a href="{{ route('admin.products.edit', $item->id) }}">&#9998; Edit</a>
                                <a href="{{ route('admin.products.toggle-status', $item->id) }}">&#9654; Activate</a>
                                <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dd-danger">&#128465; Delete</button>
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
                <p style="font-size:.95rem;">No deactivated products found.</p>
                <a href="{{ route('admin.products.index') }}" class="btn-add-new" style="display:inline-flex;">View All Products</a>
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
    $('#deactivatedTable').DataTable({
        dom: '<"row align-items-center mb-3"<"col-auto"l><"col-auto"f>>rtip',
        order: [[0, 'asc']],
        pageLength: 10,
        language: {
            search: "Search:", lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: { previous: "Previous", next: "Next" }
        },
        columnDefs: [{ orderable: false, targets: [4, 5, 6] }]
    });
});
function toggleDropdown(btn) {
    var dd = btn.nextElementSibling;
    var isOpen = dd.style.display === 'block';
    document.querySelectorAll('.actions-dropdown').forEach(function(d){ d.style.display = 'none'; });
    dd.style.display = isOpen ? 'none' : 'block';
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.actions-wrap')) {
        document.querySelectorAll('.actions-dropdown').forEach(function(d){ d.style.display = 'none'; });
    }
});
</script>

@endsection
