@extends('admin.master')

@section('main-content')

<style>
    .form-card { max-width: 680px; }
    .form-label { font-weight: 600; font-size: .9rem; }
    .card-header-custom {
        background-color: #d4a017; color: #fff;
        padding: 14px 20px; border-radius: 8px 8px 0 0;
        font-size: 1rem; font-weight: 600;
    }
    .btn-update {
        background-color: #d4a017; color: #fff; border: none;
        border-radius: 6px; padding: 8px 28px; font-size: .9rem; font-weight: 500;
    }
    .btn-update:hover { background-color: #b8860b; color: #fff; }
    .btn-back {
        background-color: #6c757d; color: #fff; border: none;
        border-radius: 6px; padding: 8px 22px; font-size: .9rem;
        text-decoration: none; display: inline-block;
    }
    .btn-back:hover { background-color: #5a6268; color: #fff; }
    .current-img {
        width: 120px; height: 100px; object-fit: cover;
        border-radius: 6px; border: 2px solid #dee2e6;
    }
    .preview-img {
        width: 120px; height: 100px; object-fit: cover;
        border-radius: 6px; border: 2px dashed #1e8449; margin-top: 8px;
    }
</style>

<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h4 style="font-size:1.1rem; font-weight:600; margin-bottom:2px;">Edit Category</h4>
        <small style="color:#6c757d; font-size:.82rem;">
            Dashboard &rsaquo; Manage Categories &rsaquo; Edit
        </small>
    </div>
    <a href="{{ route('admin.category.index') }}" class="btn-back">&#8592; Back</a>
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
    <div class="card-header-custom">&#9998; Edit Category Information</div>
    <div class="card-body p-4">
        <form action="{{ route('admin.category.update', $category->id) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Category Name <span style="color:red;">*</span></label>
                <input type="text" name="category_name"
                       value="{{ old('category_name', $category->category_name) }}"
                       class="form-control @error('category_name') is-invalid @enderror"
                       placeholder="Enter category name">
                @error('category_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Current Photo</label><br>
                @if($category->category_photo)
                    <img src="{{ asset('uploads/category/' . $category->category_photo) }}"
                         id="current_img" alt="Current Photo" class="current-img">
                @else
                    <span style="color:#6c757d; font-size:.88rem;">No photo uploaded</span>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Change Photo
                    <span style="color:#6c757d; font-weight:400; font-size:.82rem;">
                        (leave blank to keep current)
                    </span>
                </label>
                <input type="file" name="category_photo" id="category_photo"
                       class="form-control @error('category_photo') is-invalid @enderror"
                       accept="image/jpg,image/jpeg,image/png"
                       onchange="previewNewImage(event)">
                @error('category_photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="preview_box" style="display:none;">
                    <small style="color:#1e8449; font-size:.82rem;">&#10003; New photo selected:</small><br>
                    <img id="preview_img" src="" alt="New Preview" class="preview-img">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Featured</label>
                <select name="featured" class="form-select">
                    <option value="inactive" {{ old('featured', $category->featured) == 'inactive' ? 'selected' : '' }}>Deactivated</option>
                    <option value="active"   {{ old('featured', $category->featured) == 'active'   ? 'selected' : '' }}>Activated</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active"   {{ old('status', $category->status) == 'active'   ? 'selected' : '' }}>Activated</option>
                    <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Deactivated</option>
                </select>
            </div>

            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn-update">&#8635; Update Category</button>
                <a href="{{ route('admin.category.index') }}" class="btn-back">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function previewNewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const currentImg = document.getElementById('current_img');
            if (currentImg) currentImg.src = e.target.result;
            document.getElementById('preview_img').src = e.target.result;
            document.getElementById('preview_box').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}
</script>

@endsection
