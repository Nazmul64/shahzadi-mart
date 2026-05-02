@extends('manager.master')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    .page-title-box h4    { font-size: 1.1rem; font-weight: 600; margin-bottom: 2px; }
    .page-title-box small { color: #6c757d; font-size: .82rem; }

    div.dataTables_wrapper div.dataTables_length label,
    div.dataTables_wrapper div.dataTables_filter label { font-size: .9rem; }
    div.dataTables_wrapper div.dataTables_filter input {
        border: 1px solid #ced4da; border-radius: .375rem;
        padding: .3rem .6rem; font-size: .9rem;
    }
    div.dataTables_wrapper div.dataTables_length select {
        border: 1px solid #ced4da; border-radius: .375rem;
        padding: .25rem .5rem; font-size: .9rem;
    }
    div.dataTables_wrapper div.dataTables_info,
    div.dataTables_wrapper div.dataTables_paginate { font-size: .88rem; }

    #categoryTable thead tr th {
        background: #fff; font-weight: 600; font-size: .88rem;
        color: #333; border-bottom: 2px solid #dee2e6; white-space: nowrap;
    }
    #categoryTable tbody tr td { font-size: .88rem; vertical-align: middle; }
    #categoryTable tbody tr:hover { background: #f8f9fa; }

    .cat-photo { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #dee2e6; }
    .cat-photo-empty { width: 50px; height: 50px; background: #f0f0f0; border-radius: 6px; border: 1px solid #dee2e6; display: flex; align-items: center; justify-content: center; font-size: .7rem; color: #aaa; }

    .btn-pill { border-radius: 20px; padding: 5px 14px; font-size: .82rem; font-weight: 500; border: none; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; cursor: pointer; text-decoration: none; }
    .btn-pill-green { background-color: #1e8449; color: #fff; }
    .btn-pill-red   { background-color: #c0392b; color: #fff; }

    .btn-edit { background-color: #1a2b6b; color: #fff !important; border: none; border-radius: 20px; padding: 5px 16px; font-size: .82rem; white-space: nowrap; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; }
    .btn-del { background-color: #ef4444; color: #fff; border: none; border-radius: 50%; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; cursor: pointer; }

    .btn-add-new { background-color: #1a2b6b; color: #fff !important; border: none; border-radius: 25px; padding: 8px 22px; font-size: .9rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; cursor: pointer; }

    /* Modal */
    .modal-title-custom { font-size: 1rem; font-weight: 700; color: #1a2b6b; text-transform: uppercase; }
    .modal-label { font-weight: 700; font-size: .88rem; color: #1a2b6b; text-align: right; padding-top: 8px; }

    .img-upload-box { width: 200px; height: 200px; border: 2px dashed #adb5bd; border-radius: 6px; position: relative; overflow: hidden; cursor: pointer; display: flex; align-items: flex-end; justify-content: center; }
    .img-upload-box img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
    .img-upload-overlay { position: relative; z-index: 2; background: rgba(255,255,255,0.85); width: 100%; text-align: center; padding: 8px 0; font-size: .85rem; color: #333; }
</style>

<div class="container-fluid" style="padding-top: 25px;">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="page-title-box">
            <h4>Manager - Categories</h4>
            <small>Manage all categories from here</small>
        </div>
        <button type="button" id="btnAddNew" class="btn-add-new">+ Add New</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-3">
            <table id="categoryTable" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th style="width:60px;">Photo</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th class="text-center">Featured</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $item)
                    <tr>
                        <td class="text-center">
                            @if($item->category_photo && file_exists(public_path('uploads/category/'.$item->category_photo)))
                                <img src="{{ asset('uploads/category/'.$item->category_photo) }}" class="cat-photo">
                            @else
                                <div class="cat-photo-empty">No Img</div>
                            @endif
                        </td>
                        <td>{{ $item->category_name }}</td>
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
                                data-name="{{ addslashes($item->category_name) }}"
                                data-slug="{{ $item->slug }}"
                                data-featured="{{ $item->featured }}"
                                data-status="{{ $item->status }}"
                                data-photo="{{ $item->category_photo ? asset('uploads/category/'.$item->category_photo) : '' }}">
                                Edit
                            </button>
                            <form action="{{ route('manager.category.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this category?')">
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
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-custom">ADD CATEGORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('manager.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body py-4">
                    <div class="row mb-3">
                        <div class="col-3 modal-label">Name *</div>
                        <div class="col-9"><input type="text" name="category_name" id="create_name" class="form-control" required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3 modal-label">Image *</div>
                        <div class="col-9">
                            <div class="img-upload-box" onclick="document.getElementById('create_photo').click()">
                                <img id="create_preview" src="" style="display:none;">
                                <div class="img-upload-overlay">Upload Image</div>
                            </div>
                            <input type="file" name="category_photo" id="create_photo" style="display:none;" onchange="previewImg('create_photo','create_preview')">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-custom">EDIT CATEGORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCategoryForm" action="" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body py-4">
                    <div class="row mb-3">
                        <div class="col-3 modal-label">Name *</div>
                        <div class="col-9"><input type="text" name="category_name" id="edit_name" class="form-control" required></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3 modal-label">Image</div>
                        <div class="col-9">
                            <div class="img-upload-box" onclick="document.getElementById('edit_photo').click()">
                                <img id="edit_preview" src="" style="display:none;">
                                <div class="img-upload-overlay">Change Image</div>
                            </div>
                            <input type="file" name="category_photo" id="edit_photo" style="display:none;" onchange="previewImg('edit_photo','edit_preview')">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    $(document).on('click', '.btn-open-edit', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var photo = $(this).data('photo');

        $('#editCategoryForm').attr('action', '{{ url("/") }}/manager/categories/' + id);
        $('#edit_name').val(name);

        if (photo) {
            $('#edit_preview').attr('src', photo).show();
        } else {
            $('#edit_preview').hide();
        }

        new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
    });
});

function previewImg(inputId, previewId) {
    var file = document.getElementById(inputId).files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + previewId).attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
    }
}
</script>

@endsection
