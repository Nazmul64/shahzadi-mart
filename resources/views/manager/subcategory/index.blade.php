@extends('manager.master')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    .page-title-box h4    { font-size: 1.1rem; font-weight: 600; margin-bottom: 2px; }
    .page-title-box small { color: #6c757d; font-size: .82rem; }
    div.dataTables_wrapper div.dataTables_length label, div.dataTables_wrapper div.dataTables_filter label { font-size: .9rem; }
    #subCategoryTable thead tr th { background: #fff; font-weight: 600; font-size: .88rem; color: #333; border-bottom: 2px solid #dee2e6; white-space: nowrap; }
    #subCategoryTable tbody tr td { font-size: .88rem; vertical-align: middle; }
    .btn-pill { border-radius: 20px; padding: 5px 14px; font-size: .82rem; font-weight: 500; border: none; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; cursor: pointer; text-decoration: none; }
    .btn-pill-green { background-color: #1e8449; color: #fff; }
    .btn-pill-red   { background-color: #c0392b; color: #fff; }
    .btn-edit { background-color: #1a2b6b; color: #fff !important; border: none; border-radius: 20px; padding: 5px 16px; font-size: .82rem; white-space: nowrap; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; }
    .btn-del { background-color: #1a2b6b; color: #fff; border: none; border-radius: 50%; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; cursor: pointer; }
    .btn-add-new { background-color: #1a2b6b; color: #fff !important; border: none; border-radius: 25px; padding: 8px 22px; font-size: .9rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; cursor: pointer; }
</style>

<div class="container-fluid" style="padding-top: 25px;">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="page-title-box">
            <h4>Manager - Sub Categories</h4>
            <small>Manage all sub-categories</small>
        </div>
        <button type="button" id="btnAddNew" class="btn-add-new">+ Add New</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-3">
            <table id="subCategoryTable" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th class="text-center">Featured</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subCategories as $item)
                    <tr>
                        <td>{{ $item->category->category_name ?? 'N/A' }}</td>
                        <td>{{ $item->sub_name }}</td>
                        <td>{{ $item->slug }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->featured === 'active' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($item->featured) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($item->status) }}</span>
                        </td>
                        <td class="text-center" style="white-space:nowrap;">
                            <button type="button" class="btn-edit btn-open-edit"
                                data-id="{{ $item->id }}"
                                data-name="{{ addslashes($item->sub_name) }}"
                                data-category="{{ $item->category_id }}">
                                Edit
                            </button>
                            <form action="{{ route('manager.subcategory.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- CREATE MODAL --}}
<div class="modal fade" id="createSubModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ADD SUB CATEGORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('manager.subcategory.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Main Category</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sub Category Name</label>
                        <input type="text" name="sub_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
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
    $('#subCategoryTable').DataTable();
    $('#btnAddNew').on('click', function () {
        new bootstrap.Modal(document.getElementById('createSubModal')).show();
    });
});
</script>

@endsection
