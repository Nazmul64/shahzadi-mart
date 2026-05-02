@php
    $layout = request()->routeIs('manager.*') ? 'manager.master' : (request()->routeIs('emplee.*') ? 'emplee.master' : 'admin.master');
    $contentSection = request()->routeIs('admin.*') ? 'main-content' : 'content';
    $routePrefix = request()->routeIs('manager.*') ? 'manager.blog-posts' : (request()->routeIs('emplee.*') ? 'emplee.blog-posts' : 'admin.blog-posts');
    $isEdit = isset($post);
@endphp

@extends($layout)

@section($contentSection)
<div class="{{ request()->routeIs('manager.*') ? 'db-page' : 'page-wrapper' }}">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>{{ $isEdit ? 'Edit Blog Post' : 'Create Blog Post' }}</h4>
        <a href="{{ route($routePrefix . '.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ $isEdit ? route($routePrefix . '.update', $post->id) : route($routePrefix . '.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Post Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $post->title ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="summernote" class="form-control" rows="8">{{ old('description', $post->description ?? '') }}</textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="blog_category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('blog_category_id', $post->blog_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Featured Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if($isEdit && $post->image)
                                <div class="mt-2">
                                    <img src="{{ asset($post->image) }}" style="width: 100%; border-radius: 6px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="status" id="status" {{ old('status', $post->status ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">{{ $isEdit ? 'Update Post' : 'Publish Post' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endsection
