@extends('emplee.master')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    .page-title-box h4    { font-size: 1.1rem; font-weight: 600; margin-bottom: 2px; }
    .page-title-box small { color: #6c757d; font-size: .82rem; }

    #categoryTable thead tr th {
        background: #fff; font-weight: 600; font-size: .88rem;
        color: #333; border-bottom: 2px solid #dee2e6;
    }
    #categoryTable tbody tr td { font-size: .88rem; vertical-align: middle; }

    .cat-photo {
        width: 50px; height: 50px; object-fit: cover;
        border-radius: 6px; border: 1px solid #dee2e6;
    }
    .cat-photo-empty {
        width: 50px; height: 50px; background: #f0f0f0;
        border-radius: 6px; border: 1px solid #dee2e6;
        display: flex; align-items: center; justify-content: center;
        font-size: .7rem; color: #aaa;
    }

    .btn-add-new {
        background: #3b82f6; color: #fff !important; border: none;
        border-radius: 25px; padding: 8px 22px; font-size: .9rem; font-weight: 500;
        text-decoration: none; display: inline-flex;
        align-items: center; gap: 5px; cursor: pointer;
    }
    .btn-add-new:hover { background: #2563eb; }

    .btn-del {
        background-color: #ef4444; color: #fff; border: none;
        border-radius: 50%; width: 32px; height: 32px;
        display: inline-flex; align-items: center;
        justify-content: center; font-size: .85rem;
        cursor: pointer;
    }
    .btn-del:hover { background-color: #dc2626; }
</style>

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-start mb-3">
    <div class="page-title-box" style="margin-top: 20px;">
        <h4>Employee - Category Hub</h4>
        <small>Employee Panel &rsaquo; Manage Categories</small>
    </div>
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
            <button type="button" id="btnAddNew" class="btn-add-new">+ New Category</button>
        </div>

        <table id="categoryTable" class="table table-bordered w-100">
            <thead>
                <tr>
                    <th style="width:60px;">Photo</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $item)
                <tr>
                    <td class="text-center">
                        @if($item->category_photo && file_exists(public_path('uploads/category/'.$item->category_photo)))
                            <img src="{{ asset('uploads/category/'.$item->category_photo) }}"
                                 alt="{{ $item->category_name }}" class="cat-photo">
                        @else
                            <div class="cat-photo-empty">No Img</div>
                        @endif
                    </td>

                    <td>{{ $item->category_name }}</td>

                    <td class="text-center">
                        <span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>

                    <td class="text-center">
                        <form action="{{ route('emplee.category.destroy', $item->id) }}"
                              method="POST" onsubmit="return confirm('Remove category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-del" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>


{{-- ======== CREATE MODAL ======== --}}
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">ADD CATEGORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('emplee.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category Photo</label>
                        <input type="file" name="category_photo" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="submit" class="btn btn-primary w-100">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#categoryTable').DataTable();
    $('#btnAddNew').on('click', function () {
        new bootstrap.Modal(document.getElementById('createCategoryModal')).show();
    });
});
</script>

@endsection
