@php
    $layout = request()->routeIs('manager.*') ? 'manager.master' : (request()->routeIs('emplee.*') ? 'emplee.master' : 'admin.master');
    $contentSection = request()->routeIs('admin.*') ? 'main-content' : 'content';
    $routePrefix = request()->routeIs('manager.*') ? 'manager.blog-posts' : (request()->routeIs('emplee.*') ? 'emplee.blog-posts' : 'admin.blog-posts');
@endphp

@extends($layout)

@section($contentSection)
<div class="{{ request()->routeIs('manager.*') ? 'db-page' : 'page-wrapper' }}">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Blog Posts</h4>
        <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary btn-sm">Add New Post</a>
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
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>
                                    @if($post->image)
                                        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <div style="width: 50px; height: 50px; background: #e2e8f0; display:flex; align-items:center; justify-content:center; border-radius: 4px;">No Img</div>
                                    @endif
                                </td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category->name ?? 'N/A' }}</td>
                                <td>
                                    @if($post->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route($routePrefix . '.edit', $post->id) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route($routePrefix . '.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
