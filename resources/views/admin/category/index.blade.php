@extends('admin.master')

@section('main-content')

{{-- ===== ALL CDN ===== --}}
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

    #categoryTable thead tr th {
        background: #fff; font-weight: 600; font-size: .88rem;
        color: #333; border-bottom: 2px solid #dee2e6; white-space: nowrap;
    }
    #categoryTable tbody tr td { font-size: .88rem; vertical-align: middle; }
    #categoryTable tbody tr:hover { background: #f8f9fa; }

    /* Category photo thumbnail */
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

    .btn-attr {
        background-color: #1a2b6b; color: #fff !important; border: none;
        border-radius: 20px; padding: 5px 16px; font-size: .82rem;
        white-space: nowrap; text-decoration: none; display: inline-block;
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
        text-decoration: none; display: inline-flex; align-items: center; gap: 5px; cursor: pointer;
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

    /* Modal */
    .modal-title-custom {
        font-size: 1rem; font-weight: 700; letter-spacing: .05em;
        color: #1a2b6b; text-transform: uppercase;
    }
    .modal-label {
        font-weight: 700; font-size: .88rem; color: #1a2b6b;
        text-align: right; padding-top: 8px;
    }
    .modal-sublabel { font-size: .75rem; color: #6c757d; font-weight: 400; }

    .img-upload-box {
        width: 240px; height: 240px;
        border: 2px dashed #adb5bd; border-radius: 6px;
        position: relative; overflow: hidden; cursor: pointer;
        display: flex; align-items: flex-end; justify-content: center;
    }
    .img-upload-box img {
        position: absolute; top: 0; left: 0;
        width: 100%; height: 100%; object-fit: cover;
    }
    .img-upload-overlay {
        position: relative; z-index: 2;
        background: rgba(255,255,255,0.85); width: 100%; text-align: center;
        padding: 8px 0; font-size: .85rem; color: #333;
        display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .img-size-hint { font-size: .8rem; color: #6c757d; margin-top: 6px; }

    .btn-modal-save {
        background-color: #1a2b6b; color: #fff; border: none;
        border-radius: 4px; padding: 9px 36px; font-size: .9rem; font-weight: 500;
    }
    .btn-modal-save:hover { background-color: #152259; color: #fff; }
    .btn-modal-close {
        background-color: #1a2b6b; color: #fff; border: none;
        border-radius: 4px; padding: 9px 28px; font-size: .9rem;
    }
    .btn-modal-close:hover { background-color: #152259; color: #fff; }
</style>

{{-- Page Header --}}
<div class="page-title-box mb-3">
    <h4>Main Categories</h4>
    <small>Dashboard &rsaquo; Manage Categories &rsaquo; Main Categories</small>
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

        <table id="categoryTable" class="table table-bordered w-100">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th class="text-center">Attributes</th>
                    <th class="text-center">Featured</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $item)
                <tr>
                    {{-- Photo --}}
                    <td class="text-center">
                        @if($item->category_photo && file_exists(public_path('uploads/category/'.$item->category_photo)))
                            <img src="{{ asset('uploads/category/'.$item->category_photo) }}"
                                 alt="{{ $item->category_name }}"
                                 class="cat-photo">
                        @else
                            <div class="cat-photo-empty">No Img</div>
                        @endif
                    </td>

                    <td>{{ $item->category_name }}</td>
                    <td>{{ $item->slug }}</td>

                    <td class="text-center">
                        <a href="#" class="btn-attr">&#9998; Create</a>
                    </td>

                    <td class="text-center">
                        <a href="{{ route('category.toggle-featured', $item->id) }}"
                           class="btn-pill {{ $item->featured === 'active' ? 'btn-pill-green' : 'btn-pill-red' }}">
                            {{ $item->featured === 'active' ? 'Activated' : 'Deactivated' }}
                            <span style="font-size:.7rem;">&#9660;</span>
                        </a>
                    </td>

                    <td class="text-center">
                        <a href="{{ route('category.toggle-status', $item->id) }}"
                           class="btn-pill {{ $item->status === 'active' ? 'btn-pill-green' : 'btn-pill-red' }}">
                            {{ $item->status === 'active' ? 'Activated' : 'Deactivated' }}
                            <span style="font-size:.7rem;">&#9660;</span>
                        </a>
                    </td>

                    <td class="text-center" style="white-space:nowrap;">
                        <button type="button" class="btn-edit btn-open-edit"
                            data-id="{{ $item->id }}"
                            data-name="{{ addslashes($item->category_name) }}"
                            data-slug="{{ $item->slug }}"
                            data-featured="{{ $item->featured }}"
                            data-status="{{ $item->status }}"
                            data-photo="{{ asset('uploads/category/'.$item->category_photo) }}">
                            &#9998; Edit
                        </button>
                        <form action="{{ route('category.destroy', $item->id) }}"
                              method="POST" style="display:inline-block; margin-left:4px;"
                              onsubmit="return confirm('Delete this category?')">
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
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title modal-title-custom">ADD CATEGORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body py-4">
                    <div class="row mb-3 align-items-start">
                        <div class="col-3 modal-label">Name *<div class="modal-sublabel">(In Any Language)</div></div>
                        <div class="col-9">
                            <input type="text" name="category_name" id="create_name" class="form-control" placeholder="Category name">
                        </div>
                    </div>
                    <div class="row mb-3 align-items-start">
                        <div class="col-3 modal-label">Slug *<div class="modal-sublabel">(In English)</div></div>
                        <div class="col-9">
                            <input type="text" name="slug" id="create_slug" class="form-control" placeholder="Auto-generated" readonly>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-start">
                        <div class="col-3 modal-label">Image*</div>
                        <div class="col-9">
                            <div class="img-upload-box" onclick="document.getElementById('create_photo').click()">
                                <img id="create_preview" src="" style="display:none;">
                                <div class="img-upload-overlay">&#8679; Upload Image</div>
                            </div>
                            <input type="file" name="category_photo" id="create_photo"
                                   accept="image/jpg,image/jpeg,image/png" style="display:none;"
                                   onchange="previewImg('create_photo','create_preview')">
                            <p class="img-size-hint">Prefered Size: (1230x267) or Square Sized Image</p>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-3 modal-label">Featured</div>
                        <div class="col-9">
                            <select name="featured" class="form-select">
                                <option value="inactive">Deactivated</option>
                                <option value="active">Activated</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-3 modal-label">Status</div>
                        <div class="col-9">
                            <select name="status" class="form-select">
                                <option value="active">Activated</option>
                                <option value="inactive">Deactivated</option>
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
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title modal-title-custom">EDIT CATEGORY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCategoryForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body py-4">
                    <div class="row mb-3 align-items-start">
                        <div class="col-3 modal-label">Name *<div class="modal-sublabel">(In Any Language)</div></div>
                        <div class="col-9">
                            <input type="text" name="category_name" id="edit_name" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3 align-items-start">
                        <div class="col-3 modal-label">Slug *<div class="modal-sublabel">(In English)</div></div>
                        <div class="col-9">
                            <input type="text" name="slug" id="edit_slug" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-start">
                        <div class="col-3 modal-label">Current Image*</div>
                        <div class="col-9">
                            <div class="img-upload-box" onclick="document.getElementById('edit_photo').click()">
                                <img id="edit_preview" src="" style="display:none;">
                                <div class="img-upload-overlay">&#8679; Upload Image</div>
                            </div>
                            <input type="file" name="category_photo" id="edit_photo"
                                   accept="image/jpg,image/jpeg,image/png" style="display:none;"
                                   onchange="previewImg('edit_photo','edit_preview')">
                            <p class="img-size-hint">Prefered Size: (1230x267) or Square Sized Image</p>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-3 modal-label">Featured</div>
                        <div class="col-9">
                            <select name="featured" id="edit_featured" class="form-select">
                                <option value="inactive">Deactivated</option>
                                <option value="active">Activated</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-3 modal-label">Status</div>
                        <div class="col-9">
                            <select name="status" id="edit_status" class="form-select">
                                <option value="active">Activated</option>
                                <option value="inactive">Deactivated</option>
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
$(document).ready(function () {

    $('#categoryTable').DataTable({
        dom: '<"row align-items-center mb-3"<"col-auto"l><"col-auto"f>>rtip',
        order: [[1, 'asc']],   // Name column (index 1 now) A→Z
        pageLength: 10,
        language: {
            search:     "Search:",
            lengthMenu: "Show _MENU_ entries",
            info:       "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate:   { previous: "Previous", next: "Next" }
        },
        columnDefs: [
            { orderable: false, targets: [0, 3, 4, 5, 6] }  // Photo, Attributes, Featured, Status, Options
        ]
    });

    // Add New → Create Modal
    $('#btnAddNew').on('click', function () {
        new bootstrap.Modal(document.getElementById('createCategoryModal')).show();
    });

    // Auto slug
    $('#create_name').on('input', function () {
        var slug = $(this).val()
            .toLowerCase().trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
        $('#create_slug').val(slug);
    });

    // Edit button → Edit Modal
    $(document).on('click', '.btn-open-edit', function () {
        var id       = $(this).data('id');
        var name     = $(this).data('name');
        var slug     = $(this).data('slug');
        var featured = $(this).data('featured');
        var status   = $(this).data('status');
        var photo    = $(this).data('photo');

        $('#editCategoryForm').attr('action', '/category/' + id);
        $('#edit_name').val(name);
        $('#edit_slug').val(slug);
        $('#edit_featured').val(featured);
        $('#edit_status').val(status);

        if (photo) {
            $('#edit_preview').attr('src', photo).show();
        }

        new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
    });

});

function previewImg(inputId, previewId) {
    var file = document.getElementById(inputId).files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById(previewId);
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}
</script>

@endsection