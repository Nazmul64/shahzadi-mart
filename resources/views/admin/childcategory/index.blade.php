@extends('admin.master')

@section('main-content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    .page-title-box h4   { font-size: 1.1rem; font-weight: 600; margin-bottom: 2px; }
    .page-title-box small{ color: #6c757d; font-size: .82rem; }

    div.dataTables_wrapper div.dataTables_length label,
    div.dataTables_wrapper div.dataTables_filter label { font-size: .9rem; }
    div.dataTables_wrapper div.dataTables_filter input {
        border: 1px solid #ced4da; border-radius: .375rem; padding: .3rem .6rem; font-size: .9rem;
    }
    div.dataTables_wrapper div.dataTables_length select {
        border: 1px solid #ced4da; border-radius: .375rem; padding: .25rem .5rem; font-size: .9rem;
    }
    div.dataTables_wrapper div.dataTables_info,
    div.dataTables_wrapper div.dataTables_paginate { font-size: .88rem; }

    #childTable thead tr th {
        background: #fff; font-weight: 600; font-size: .88rem;
        color: #333; border-bottom: 2px solid #dee2e6; white-space: nowrap;
    }
    #childTable tbody tr td { font-size: .88rem; vertical-align: middle; }
    #childTable tbody tr:hover { background: #f8f9fa; }

    .btn-attr {
        background-color: #1a2b6b; color: #fff !important; border: none;
        border-radius: 20px; padding: 5px 14px; font-size: .82rem;
        white-space: nowrap; text-decoration: none; display: inline-flex;
        align-items: center; gap: 4px; cursor: pointer;
    }
    .btn-attr:hover { background-color: #152259; }

    .btn-pill {
        border-radius: 20px; padding: 5px 14px; font-size: .82rem; font-weight: 500;
        border: none; white-space: nowrap; display: inline-flex;
        align-items: center; gap: 5px; cursor: pointer; text-decoration: none;
    }
    .btn-pill-green { background-color: #1e8449; color: #fff; }
    .btn-pill-green:hover { background-color: #196f3d; color: #fff; }
    .btn-pill-red   { background-color: #c0392b; color: #fff; }
    .btn-pill-red:hover   { background-color: #a93226; color: #fff; }

    .btn-edit {
        background-color: #1a2b6b; color: #fff !important; border: none;
        border-radius: 20px; padding: 5px 16px; font-size: .82rem;
        white-space: nowrap; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;
    }
    .btn-edit:hover { background-color: #152259; }

    .btn-del {
        background-color: #1a2b6b; color: #fff; border: none; border-radius: 50%;
        width: 32px; height: 32px; display: inline-flex; align-items: center;
        justify-content: center; font-size: .85rem; cursor: pointer; vertical-align: middle;
    }
    .btn-del:hover { background-color: #c0392b; }

    .btn-add-new {
        background-color: #1a2b6b; color: #fff !important; border: none;
        border-radius: 25px; padding: 8px 22px; font-size: .9rem; font-weight: 500;
        display: inline-flex; align-items: center; gap: 5px; cursor: pointer;
    }
    .btn-add-new:hover { background-color: #152259; }

    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button.current:hover {
        background: #1a2b6b !important; color: #fff !important;
        border-color: #1a2b6b !important; border-radius: 4px;
    }
    .dataTables_paginate .paginate_button:hover {
        background: #e9ecef !important; color: #333 !important; border-color: #dee2e6 !important;
    }

    .modal-title-custom {
        font-size: 1rem; font-weight: 700; letter-spacing: .05em;
        color: #1a2b6b; text-transform: uppercase;
    }
    .modal-label {
        font-weight: 700; font-size: .88rem; color: #1a2b6b;
        text-align: right; padding-top: 8px;
    }
    .modal-sublabel { font-size: .75rem; color: #6c757d; font-weight: 400; }

    .btn-modal-save {
        background-color: #1a2b6b; color: #fff; border: none;
        border-radius: 4px; padding: 9px 36px; font-size: .9rem; font-weight: 500;
    }
    .btn-modal-save:hover { background-color: #152259; color: #fff; }
    .btn-modal-close {
        background-color: #6c757d; color: #fff; border: none;
        border-radius: 4px; padding: 9px 28px; font-size: .9rem;
    }
    .btn-modal-close:hover { background-color: #5a6268; color: #fff; }

    /* Loading spinner for dropdown */
    .select-loading { color: #6c757d; font-size: .82rem; padding: 4px 0; display:none; }
</style>

{{-- Page Header --}}
<div class="page-title-box mb-3">
    <h4>Child Sub Categories</h4>
    <small>Dashboard &rsaquo; Manage Categories &rsaquo; Child Sub Categories</small>
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
            <button type="button" id="btnAddNew" class="btn-add-new">+ Add New</button>
        </div>

        <table id="childTable" class="table table-bordered w-100">
            <thead>
                <tr>
                    <th>Sub Category</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th class="text-center">Attributes</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($childSubCategories as $item)
                <tr>
                    <td>{{ $item->subCategory->sub_name ?? 'N/A' }}</td>
                    <td>{{ $item->child_sub_name }}</td>
                    <td>{{ $item->slug }}</td>

                    <td class="text-center">
                        <a href="#" class="btn-attr">&#9998; Create</a>
                    </td>

                    <td class="text-center">
                        <a href="{{ route('childcategory.toggle-status', $item->id) }}"
                           class="btn-pill {{ $item->status ? 'btn-pill-green' : 'btn-pill-red' }}">
                            {{ $item->status ? 'Activated' : 'Deactivated' }}
                            <span style="font-size:.7rem;">&#9660;</span>
                        </a>
                    </td>

                    <td class="text-center" style="white-space:nowrap;">
                        <button type="button" class="btn-edit btn-open-edit"
                            data-id="{{ $item->id }}"
                            data-name="{{ addslashes($item->child_sub_name) }}"
                            data-slug="{{ $item->slug }}"
                            data-category="{{ $item->subCategory->category_id ?? '' }}"
                            data-subcategory="{{ $item->sub_category_id }}"
                            data-featured="{{ $item->featured ? '1' : '0' }}"
                            data-status="{{ $item->status ? '1' : '0' }}">
                            &#9998; Edit
                        </button>
                        <form action="{{ route('childcategory.destroy', $item->id) }}"
                              method="POST" style="display:inline-block; margin-left:4px;"
                              onsubmit="return confirm('Delete this child sub category?')">
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


{{-- ======== CREATE MODAL ======== --}}
<div class="modal fade" id="createChildModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title modal-title-custom">ADD CHILD SUB CATEGORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('childcategory.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4">

                    {{-- Step 1: Main Category --}}
                    <div class="row mb-3 align-items-center">
                        <div class="col-4 modal-label">Main Category *</div>
                        <div class="col-8">
                            <select id="create_category" class="form-select">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Step 2: Sub Category (loads after category selected) --}}
                    <div class="row mb-3 align-items-center">
                        <div class="col-4 modal-label">Sub Category *</div>
                        <div class="col-8">
                            <select name="sub_category_id" id="create_subcategory" class="form-select" disabled>
                                <option value="">-- Select Category First --</option>
                            </select>
                            <small class="select-loading" id="create_loading">⏳ Loading...</small>
                        </div>
                    </div>

                    {{-- Name --}}
                    <div class="row mb-3 align-items-start">
                        <div class="col-4 modal-label">
                            Name *
                            <div class="modal-sublabel">(In Any Language)</div>
                        </div>
                        <div class="col-8">
                            <input type="text" name="child_sub_name" id="create_child_name"
                                   class="form-control" placeholder="Child sub category name">
                        </div>
                    </div>

                    {{-- Slug --}}
                    <div class="row mb-3 align-items-start">
                        <div class="col-4 modal-label">
                            Slug *
                            <div class="modal-sublabel">(In English)</div>
                        </div>
                        <div class="col-8">
                            <input type="text" name="slug" id="create_child_slug"
                                   class="form-control" placeholder="Auto-generated" readonly>
                        </div>
                    </div>

                    {{-- Featured --}}
                    <div class="row mb-3 align-items-center">
                        <div class="col-4 modal-label">Featured</div>
                        <div class="col-8">
                            <select name="featured" class="form-select">
                                <option value="0">Deactivated</option>
                                <option value="1">Activated</option>
                            </select>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="row mb-3 align-items-center">
                        <div class="col-4 modal-label">Status</div>
                        <div class="col-8">
                            <select name="status" class="form-select">
                                <option value="1">Activated</option>
                                <option value="0">Deactivated</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top d-flex justify-content-between">
                    <button type="submit" class="btn-modal-save">Save</button>
                    <button type="button" class="btn-modal-close" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ======== EDIT MODAL ======== --}}
<div class="modal fade" id="editChildModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title modal-title-custom">EDIT CHILD SUB CATEGORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editChildForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body py-4">

                    {{-- Step 1: Main Category --}}
                    <div class="row mb-3 align-items-center">
                        <div class="col-4 modal-label">Main Category *</div>
                        <div class="col-8">
                            <select id="edit_category" class="form-select">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Step 2: Sub Category --}}
                    <div class="row mb-3 align-items-center">
                        <div class="col-4 modal-label">Sub Category *</div>
                        <div class="col-8">
                            <select name="sub_category_id" id="edit_subcategory" class="form-select" disabled>
                                <option value="">-- Select Category First --</option>
                            </select>
                            <small class="select-loading" id="edit_loading">⏳ Loading...</small>
                        </div>
                    </div>

                    {{-- Name --}}
                    <div class="row mb-3 align-items-start">
                        <div class="col-4 modal-label">
                            Name *
                            <div class="modal-sublabel">(In Any Language)</div>
                        </div>
                        <div class="col-8">
                            <input type="text" name="child_sub_name" id="edit_child_name" class="form-control">
                        </div>
                    </div>

                    {{-- Slug --}}
                    <div class="row mb-3 align-items-start">
                        <div class="col-4 modal-label">
                            Slug *
                            <div class="modal-sublabel">(In English)</div>
                        </div>
                        <div class="col-8">
                            <input type="text" name="slug" id="edit_child_slug" class="form-control" readonly>
                        </div>
                    </div>

                    {{-- Featured --}}
                    <div class="row mb-3 align-items-center">
                        <div class="col-4 modal-label">Featured</div>
                        <div class="col-8">
                            <select name="featured" id="edit_featured" class="form-select">
                                <option value="0">Deactivated</option>
                                <option value="1">Activated</option>
                            </select>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="row mb-3 align-items-center">
                        <div class="col-4 modal-label">Status</div>
                        <div class="col-8">
                            <select name="status" id="edit_status" class="form-select">
                                <option value="1">Activated</option>
                                <option value="0">Deactivated</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top d-flex justify-content-between">
                    <button type="submit" class="btn-modal-save">Save</button>
                    <button type="button" class="btn-modal-close" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ===== JS ===== --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
// AJAX URL
var getSubCatUrl = '{{ route("childcategory.getSubCategories") }}';

// Load SubCategories by Category ID
function loadSubCategories(categoryId, subSelectId, loadingId, selectedSubId) {
    var $sub     = $('#' + subSelectId);
    var $loading = $('#' + loadingId);

    if (!categoryId) {
        $sub.html('<option value="">-- Select Category First --</option>').prop('disabled', true);
        return;
    }

    $loading.show();
    $sub.prop('disabled', true);

    $.ajax({
        url: getSubCatUrl,
        type: 'GET',
        data: { category_id: categoryId },
        success: function(data) {
            $loading.hide();
            var options = '<option value="">-- Select Sub Category --</option>';
            if (data.length > 0) {
                $.each(data, function(i, sub) {
                    var selected = (selectedSubId && sub.id == selectedSubId) ? 'selected' : '';
                    options += '<option value="' + sub.id + '" ' + selected + '>' + sub.sub_name + '</option>';
                });
                $sub.prop('disabled', false);
            } else {
                options = '<option value="">-- No Sub Category Found --</option>';
            }
            $sub.html(options);
        },
        error: function() {
            $loading.hide();
            $sub.html('<option value="">-- Error loading --</option>');
        }
    });
}

$(document).ready(function () {

    // DataTable
    $('#childTable').DataTable({
        dom: '<"row align-items-center mb-3"<"col-auto"l><"col-auto"f>>rtip',
        order: [[1, 'asc']],
        pageLength: 10,
        language: {
            search:     "Search:",
            lengthMenu: "Show _MENU_ entries",
            info:       "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate:   { previous: "Previous", next: "Next" }
        },
        columnDefs: [{ orderable: false, targets: [3, 4, 5] }]
    });

    // Add New → Create Modal
    $('#btnAddNew').on('click', function () {
        // Reset create modal
        $('#create_category').val('');
        $('#create_subcategory').html('<option value="">-- Select Category First --</option>').prop('disabled', true);
        $('#create_child_name').val('');
        $('#create_child_slug').val('');
        new bootstrap.Modal(document.getElementById('createChildModal')).show();
    });

    // CREATE: Category change → load SubCategories
    $('#create_category').on('change', function () {
        loadSubCategories($(this).val(), 'create_subcategory', 'create_loading', null);
    });

    // EDIT: Category change → load SubCategories
    $('#edit_category').on('change', function () {
        loadSubCategories($(this).val(), 'edit_subcategory', 'edit_loading', null);
    });

    // Auto slug (create)
    $('#create_child_name').on('input', function () {
        $('#create_child_slug').val(
            $(this).val().toLowerCase().trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '')
        );
    });

    // Auto slug (edit)
    $('#edit_child_name').on('input', function () {
        $('#edit_child_slug').val(
            $(this).val().toLowerCase().trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '')
        );
    });

    // Edit button → Edit Modal
    $(document).on('click', '.btn-open-edit', function () {
        var id          = $(this).data('id');
        var name        = $(this).data('name');
        var slug        = $(this).data('slug');
        var categoryId  = $(this).data('category');
        var subcatId    = $(this).data('subcategory');
        var featured    = $(this).data('featured');
        var status      = $(this).data('status');

        $('#editChildForm').attr('action', '/childcategory/' + id);
        $('#edit_child_name').val(name);
        $('#edit_child_slug').val(slug);
        $('#edit_featured').val(featured);
        $('#edit_status').val(status);

        // Set category then load subcategories
        $('#edit_category').val(categoryId);
        loadSubCategories(categoryId, 'edit_subcategory', 'edit_loading', subcatId);

        new bootstrap.Modal(document.getElementById('editChildModal')).show();
    });

});
</script>

@endsection
