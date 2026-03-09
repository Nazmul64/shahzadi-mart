@extends('admin.master')

@section('main-content')
<div class="container-fluid py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold">পারমিশন ম্যানেজমেন্ট</h4>
            <small class="text-muted">সিস্টেমের সব পারমিশন গ্রুপ অনুযায়ী দেখুন</small>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bulkCreateModal">
                <i class="fas fa-layer-group me-1"></i> Bulk তৈরি
            </button>
            <a href="{{ route('permissions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> নতুন পারমিশন
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @forelse($permissions as $group => $groupPerms)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <span class="fw-semibold">
                <i class="fas fa-folder-open me-2 text-warning"></i>{{ $group }}
                <span class="badge bg-secondary ms-1">{{ $groupPerms->count() }}</span>
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>নাম</th>
                            <th>Slug</th>
                            <th>রোলে ব্যবহার</th>
                            <th class="text-end pe-3">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupPerms as $perm)
                        <tr>
                            <td class="ps-3 text-muted">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $perm->name }}</td>
                            <td><code class="text-primary">{{ $perm->slug }}</code></td>
                            <td>
                                <span class="badge bg-info">{{ $perm->roles_count }} রোলে</span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('permissions.edit', $perm->id) }}"
                                   class="btn btn-sm btn-outline-warning me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('permissions.destroy', $perm->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('\'{{ $perm->name }}\' ডিলিট করবেন?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5 text-muted">
        <i class="fas fa-key fa-3x mb-3 d-block"></i>
        কোনো পারমিশন নেই।
        <a href="{{ route('permissions.create') }}" class="d-block mt-2">প্রথম পারমিশন তৈরি করুন</a>
    </div>
    @endforelse

</div>

{{-- Bulk Create Modal --}}
<div class="modal fade" id="bulkCreateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-layer-group me-2"></i>Bulk পারমিশন তৈরি</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('permissions.bulkCreate') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">গ্রুপের নাম <span class="text-danger">*</span></label>
                        <input type="text" name="group" class="form-control"
                               placeholder="যেমন: Products, Orders, Blog" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">অ্যাকশনগুলো (কমা দিয়ে আলাদা করুন) <span class="text-danger">*</span></label>
                        <input type="text" name="actions" class="form-control"
                               placeholder="view, create, edit, delete, export" required>
                        <small class="text-muted">উদাহরণ: গ্রুপ "Products" + অ্যাকশন "view, create" → "Products View", "Products Create" তৈরি হবে</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                    <button type="submit" class="btn btn-primary">তৈরি করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
