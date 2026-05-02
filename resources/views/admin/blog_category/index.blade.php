@php
    $layout = request()->routeIs('manager.*') ? 'manager.master' : (request()->routeIs('emplee.*') ? 'emplee.master' : 'admin.master');
    $contentSection = request()->routeIs('admin.*') ? 'main-content' : 'content';
    $routePrefix = request()->routeIs('manager.*') ? 'manager.blog-categories' : (request()->routeIs('emplee.*') ? 'emplee.blog-categories' : 'admin.blog-categories');
@endphp

@extends($layout)

@section($contentSection)
<div class="{{ request()->routeIs('manager.*') ? 'db-page' : 'page-wrapper' }}">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Blog Categories</h4>
        <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary btn-sm">Add New Category</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    @if($category->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route($routePrefix . '.edit', $category->id) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route($routePrefix . '.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
