@extends('manager.master')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
:root { --brand: #1a2b6b; --brand-green: #1e8449; --brand-red: #c0392b; }
.page-title-box h4 { font-size:1.1rem; font-weight:700; color:var(--brand); }
#productTable thead tr th { background:#f4f6fb; font-weight:700; font-size:.82rem; color:var(--brand); border-bottom:2px solid #dee2e6; }
#productTable tbody tr td { font-size:.85rem; vertical-align:middle; padding:9px 12px; }
.prod-img { width:54px; height:54px; object-fit:cover; border-radius:6px; border:1px solid #e0e0e0; }
.btn-pill-green { background:var(--brand-green); color:#fff; border-radius:20px; padding:5px 13px; font-size:.8rem; text-decoration:none; }
.btn-pill-red { background:var(--brand-red); color:#fff; border-radius:20px; padding:5px 13px; font-size:.8rem; text-decoration:none; }
.btn-edit-link { background:var(--brand); color:#fff !important; border-radius:20px; padding:5px 14px; font-size:.8rem; text-decoration:none; }
.btn-add-new { background:var(--brand); color:#fff !important; border-radius:25px; padding:7px 20px; font-size:.85rem; text-decoration:none; }
</style>

<div class="container-fluid" style="padding-top: 25px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="page-title-box">
            <h4>Manager - Products</h4>
            <small>Manage all inventory items</small>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-add-new">+ Add New Product</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2 mb-3">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-3">
            <table id="productTable" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name / SKU</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $item)
                    <tr>
                        <td>
                            @if($item->feature_image)
                                <img class="prod-img" src="{{ asset('uploads/products/' . $item->feature_image) }}">
                            @else
                                <div class="prod-img-empty">No Img</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:700;">{{ $item->name }}</div>
                            <small class="text-muted">SKU: {{ $item->sku ?? 'N/A' }}</small>
                        </td>
                        <td>{{ $item->category->category_name ?? '—' }}</td>
                        <td>৳{{ number_format($item->current_price, 2) }}</td>
                        <td class="text-center">{{ $item->stock ?? 'Unlimited' }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($item->status) }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.products.edit', $item->id) }}" class="btn-edit-link">Edit</a>
                            <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="border-radius:20px;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    $('#productTable').DataTable();
});
</script>

@endsection
