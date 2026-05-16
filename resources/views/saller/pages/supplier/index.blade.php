@extends('saller.master')

@section('main-content')
<div class="main-content">
    <div class="top-navbar">
        <div class="d-flex align-items-center gap-3">
            <button class="menu-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div class="navbar-brand">
                <i class="bi bi-shop"></i>
                <span class="d-none d-sm-inline">SELLER <strong>PORTAL</strong></span>
            </div>
        </div>
    </div>

    <div class="page-content" style="background: #f4f7fa;">
        <div class="page-header d-flex justify-content-between align-items-center mb-4 px-3 pt-3">
            <h2 class="page-title font-w700" style="font-size: 24px; color: #333;">Suppliers</h2>
            <a href="{{ route('saller.suppliers.create') }}" class="btn btn-danger btn-sm px-4" style="border-radius: 8px; background-color: #ff3e6c; border: none;">
                <i class="bi bi-plus-circle me-1"></i> Add Supplier
            </a>
        </div>

        <div class="data-card border-0 shadow-sm mx-3" style="border-radius: 10px; background: #fff;">
            <div class="table-responsive px-4 py-4">
                <table class="table align-middle">
                    <thead class="text-uppercase small text-muted font-w600" style="background: #f8f9fa;">
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Joined At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                        <tr style="border-bottom: 1px solid #f8f9fa;">
                            <td>
                                @if($supplier->photo)
                                    <img src="{{ asset($supplier->photo) }}" alt="Supplier" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #eee;">
                                @else
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #ccc;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="font-w600" style="color: #333;">{{ $supplier->name }}</td>
                            <td class="text-muted">{{ $supplier->email }}</td>
                            <td class="text-muted">{{ $supplier->phone }}</td>
                            <td class="text-muted">{{ $supplier->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="action-buttons justify-content-end d-flex align-items-center">
                                    <a href="{{ route('saller.suppliers.edit', $supplier->id) }}" class="btn-action edit" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('saller.suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-people text-muted" style="font-size: 48px;"></i>
                                <p class="text-muted mt-2">No suppliers found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .font-w600 { font-weight: 600; }
    .font-w700 { font-weight: 700; }
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-left: 5px;
        text-decoration: none;
    }
    .btn-action.edit { background: #fff3f6; color: #ff3e6c; }
    .btn-action.delete { background: #f8f9fa; color: #666; }
</style>
@endsection
