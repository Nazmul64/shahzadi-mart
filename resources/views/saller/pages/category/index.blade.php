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
        <div class="page-header mb-4 px-3 pt-3">
            <h2 class="page-title font-w700" style="font-size: 24px; color: #333;">Category List</h2>
        </div>

        <div class="data-card border-0 shadow-sm mx-3" style="border-radius: 10px; background: #fff;">
            <div class="data-card-header px-4 py-3 border-bottom-0">
                <h6 class="text-muted mb-0">Categories</h6>
            </div>

            <div class="table-responsive px-4 pb-4">
                <table class="table align-middle" style="border-collapse: separate; border-spacing: 0 10px;">
                    <thead class="text-uppercase small text-muted font-w600">
                        <tr>
                            <th style="border-bottom: 1px solid #eee;">SL</th>
                            <th style="border-bottom: 1px solid #eee;">THUMBNAIL</th>
                            <th style="border-bottom: 1px solid #eee;">NAME</th>
                            <th class="text-end" style="border-bottom: 1px solid #eee;">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $key => $category)
                        <tr style="border-bottom: 1px solid #f8f9fa;">
                            <td class="font-w600" style="color: #333;">{{ $key + 1 }}</td>
                            <td>
                                @if($category->category_photo)
                                    <img src="{{ asset('uploads/category/' . $category->category_photo) }}" alt="" style="width: 45px; height: 45px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                @else
                                    <div style="width: 45px; height: 45px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="font-w600" style="color: #333;">{{ $category->category_name }}</td>
                            <td class="text-end">
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input custom-switch" type="checkbox" disabled {{ $category->status == 'active' ? 'checked' : '' }}>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No categories found in database.</td>
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
    .custom-switch {
        width: 40px !important;
        height: 20px !important;
        cursor: not-allowed !important;
        opacity: 1 !important;
    }
    .custom-switch:checked {
        background-color: #ff3e6c !important;
        border-color: #ff3e6c !important;
    }
    .table thead th {
        padding: 15px 10px;
        letter-spacing: 0.5px;
    }
    .table tbody td {
        padding: 15px 10px;
    }
</style>
@endsection
