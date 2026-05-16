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
            <h2 class="page-title font-w700" style="font-size: 24px; color: #333;">Customer Management</h2>
            <a href="{{ route('saller.customer.create') }}" class="btn btn-danger btn-sm px-4" style="border-radius: 8px; background-color: #ff3e6c; border: none;">
                <i class="bi bi-plus-circle me-1"></i> Add New Customer
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-3 border-0 shadow-sm" role="alert" style="border-radius: 10px; background: #d1e7dd; color: #0f5132;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="data-card border-0 shadow-sm mx-3" style="border-radius: 10px; background: #fff;">
            <div class="table-responsive px-4 py-4">
                <table class="table align-middle">
                    <thead class="text-uppercase small text-muted font-w600" style="background: #f8f9fa;">
                        <tr>
                            <th>SL</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Registered At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $key => $customer)
                        <tr style="border-bottom: 1px solid #f8f9fa;">
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <img src="{{ $customer->photo ? asset($customer->photo) : 'https://ui-avatars.com/api/?name='.urlencode($customer->name) }}" 
                                     alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            </td>
                            <td class="font-w600" style="color: #333;">{{ $customer->name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td class="text-muted">{{ $customer->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <a href="{{ route('saller.customer.edit', $customer->id) }}" class="btn btn-sm btn-light text-primary border" title="Edit" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('saller.customer.destroy', $customer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger border" title="Delete" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-people text-muted" style="font-size: 48px;"></i>
                                <p class="text-muted mt-2">No customers found</p>
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
    }
    .btn-action.edit { background: #fff3f6; color: #ff3e6c; }
    .btn-action.delete { background: #f8f9fa; color: #666; }
</style>
@endsection
