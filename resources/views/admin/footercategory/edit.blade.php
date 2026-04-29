@extends('admin.master')

@section('main-content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Footer Category Edit করুন</h4>
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

                    <form action="{{ route('admin.footercategory.update', $footercategory->id) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">
                                Category Name <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="category_name"
                                name="category_name"
                                class="form-control @error('category_name') is-invalid @enderror"
                                value="{{ old('category_name', $footercategory->category_name) }}"
                                autocomplete="off"
                            >
                            @error('category_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category Slug</label>
                            <input
                                type="text"
                                id="category_slug"
                                name="category_slug"
                                class="form-control @error('category_slug') is-invalid @enderror"
                                value="{{ old('category_slug', $footercategory->category_slug) }}"
                                autocomplete="off"
                            >
                            <small class="text-muted">
                                Name পরিবর্তন করলে Slug স্বয়ংক্রিয়ভাবে আপডেট হবে।
                                চাইলে নিজেও লিখতে পারবেন।
                            </small>
                            @error('category_slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <a href="{{ route('admin.footercategory.index') }}"
                           class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Update করুন</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // ── Auto Slug Generator (Edit) ───────────────────────────────
    const nameInput = document.getElementById('category_name');
    const slugInput = document.getElementById('category_slug');

    // Edit page-এ সবসময় existing slug থাকে,
    // কিন্তু name change করলে slug update হবে
    let slugManuallyEdited = false;

    slugInput.addEventListener('input', function () {
        slugManuallyEdited = this.value.trim() !== '';
    });

    function generateSlug(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/[\s_]+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    nameInput.addEventListener('input', function () {
        if (!slugManuallyEdited) {
            slugInput.value = generateSlug(this.value);
        }
    });

    nameInput.addEventListener('blur', function () {
        if (this.value.trim() === '') {
            slugInput.value = '';
            slugManuallyEdited = false;
        }
    });
</script>
@endsection
