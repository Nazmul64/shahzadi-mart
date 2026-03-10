@extends('admin.master')

@section('main-content')

<style>
    .form-card { max-width: 680px; }
    .form-label { font-weight: 600; font-size: .9rem; }
    .card-header-custom {
        background-color: #1a2b6b; color: #fff;
        padding: 14px 20px; border-radius: 8px 8px 0 0;
        font-size: 1rem; font-weight: 600;
    }
    .btn-save {
        background-color: #1e8449; color: #fff; border: none;
        border-radius: 6px; padding: 8px 28px; font-size: .9rem; font-weight: 500;
    }
    .btn-save:hover { background-color: #196f3d; color: #fff; }
    .btn-back {
        background-color: #6c757d; color: #fff; border: none;
        border-radius: 6px; padding: 8px 22px; font-size: .9rem;
        text-decoration: none; display: inline-block;
    }
    .btn-back:hover { background-color: #5a6268; color: #fff; }
    .preview-img {
        width: 120px; height: 100px; object-fit: cover;
        border-radius: 6px; border: 2px solid #dee2e6; margin-top: 8px;
    }
</style>

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h4 style="font-size:1.1rem; font-weight:600; margin-bottom:2px;">Add New Category</h4>
        <small style="color:#6c757d; font-size:.82rem;">Dashboard &rsaquo; Manage Categories &rsaquo; Add New</small>
    </div>
    <a href="{{ route('category.index') }}" class="btn-back">&#8592; Back</a>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm form-card">
    <div class="card-header-custom">
        &#10010; Category Information
    </div>
    <div class="card-body p-4">
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Category Name --}}
            <div class="mb-3">
                <label class="form-label">Category Name <span style="color:red;">*</span></label>
                <input type="text"
                       name="category_name"
                       value="{{ old('category_name') }}"
                       class="form-control @error('category_name') is-invalid @enderror"
                       placeholder="Enter category name">
                @error('category_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Category Photo --}}
            <div class="mb-3">
                <label class="form-label">Category Photo <span style="color:red;">*</span></label>
                <input type="file"
                       name="category_photo"
                       id="category_photo"
                       class="form-control @error('category_photo') is-invalid @enderror"
                       accept="image/jpg,image/jpeg,image/png"
                       onchange="previewImage(event)">
                @error('category_photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="preview_box" style="display:none;">
                    <img id="preview_img" src="" alt="Preview" class="preview-img">
                </div>
            </div>

            {{-- Featured --}}
            <div class="mb-3">
                <label class="form-label">Featured</label>
                <select name="featured" class="form-select">
                    <option value="inactive" {{ old('featured','inactive') == 'inactive' ? 'selected' : '' }}>Deactivated</option>
                    <option value="active"   {{ old('featured') == 'active' ? 'selected' : '' }}>Activated</option>
                </select>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active"   {{ old('status','active') == 'active' ? 'selected' : '' }}>Activated</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Deactivated</option>
                </select>
            </div>

            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn-save">&#10003; Save Category</button>
                <a href="{{ route('category.index') }}" class="btn-back">Cancel</a>
            </div>

        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview_img').src = e.target.result;
                document.getElementById('preview_box').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection