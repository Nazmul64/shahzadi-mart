@extends('admin.master')

@section('main-content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>নতুন Footer Category যোগ করুন</h4>
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

                    <form action="{{ route('admin.footercategory.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Category Name <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="category_name"
                                name="category_name"
                                class="form-control @error('category_name') is-invalid @enderror"
                                value="{{ old('category_name') }}"
                                placeholder="Category Name লিখুন"
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
                                value="{{ old('category_slug') }}"
                                placeholder="auto-generate হবে"
                                autocomplete="off"
                            >
                            <small class="text-muted">
                                Name লিখলে Slug স্বয়ংক্রিয়ভাবে তৈরি হবে।
                                চাইলে নিজেও লিখতে পারবেন।
                            </small>
                            @error('category_slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <a href="{{ route('admin.footercategory.index') }}"
                           class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Save করুন</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>



<script>
    // ── Auto Slug Generator ──────────────────────────────────────
    const nameInput = document.getElementById('category_name');
    const slugInput = document.getElementById('category_slug');
    let slugManuallyEdited = false;

    // ব্যবহারকারী নিজে slug edit করলে auto-generate বন্ধ হবে
    slugInput.addEventListener('input', function () {
        slugManuallyEdited = this.value.trim() !== '';
    });

    // name থেকে slug তৈরি করার function
    function generateSlug(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/[\s_]+/g, '-')       // space/underscore → dash
            .replace(/[^\w\-]+/g, '')       // special chars বাদ
            .replace(/\-\-+/g, '-')         // double dash → single
            .replace(/^-+|-+$/g, '');       // শুরু/শেষের dash বাদ
    }

    nameInput.addEventListener('input', function () {
        if (!slugManuallyEdited) {
            slugInput.value = generateSlug(this.value);
        }
    });

    // Name clear হলে slug-ও clear হবে
    nameInput.addEventListener('blur', function () {
        if (this.value.trim() === '') {
            slugInput.value = '';
            slugManuallyEdited = false;
        }
    });
</script>
@endsection
