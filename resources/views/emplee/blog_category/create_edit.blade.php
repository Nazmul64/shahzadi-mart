@php
    $layout = request()->routeIs('manager.*') ? 'manager.master' : (request()->routeIs('emplee.*') ? 'emplee.master' : 'admin.master');
    $contentSection = request()->routeIs('admin.*') ? 'main-content' : 'content';
    $routePrefix = request()->routeIs('manager.*') ? 'manager.blog-categories' : (request()->routeIs('emplee.*') ? 'emplee.blog-categories' : 'admin.blog-categories');
    $isEdit = isset($category);
@endphp

@extends($layout)

@section($contentSection)
<div class="{{ request()->routeIs('manager.*') ? 'db-page' : 'page-wrapper' }}">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>{{ $isEdit ? 'Edit Blog Category' : 'Create Blog Category' }}</h4>
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
            <form action="{{ $isEdit ? route($routePrefix . '.update', $category->id) : route($routePrefix . '.store') }}" method="POST">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="status" id="status" {{ old('status', $category->status ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Active</label>
                </div>

                <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update Category' : 'Create Category' }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
