@extends('admin.master')

@section('main-content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Slider</h4>
                    <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Photo <span class="text-muted small">(leave empty to keep current)</span>
                            </label>
                            <input type="file" name="photo" accept="image/*"
                                   class="form-control @error('photo') is-invalid @enderror"
                                   onchange="previewImage(this)">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <p class="text-muted small mb-1">Current Photo:</p>
                                <img id="imagePreview"
                                     src="{{ asset($slider->photo) }}"
                                     alt="{{ $slider->title }}"
                                     width="150"
                                     style="border-radius:6px; border:1px solid #ddd; padding:3px;">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update Slider
                            </button>
                            <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
