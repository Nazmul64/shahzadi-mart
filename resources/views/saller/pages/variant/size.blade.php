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
            <h2 class="page-title font-w700" style="font-size: 24px; color: #333;">Size List</h2>
        </div>

        <div class="data-card border-0 shadow-sm mx-3" style="border-radius: 10px; background: #fff;">
            <div class="data-card-header px-4 py-3 border-bottom-0">
                <h6 class="text-muted mb-0">Sizes</h6>
            </div>

            <div class="table-responsive px-4 pb-4">
                <table class="table align-middle">
                    <thead class="text-uppercase small text-muted font-w600">
                        <tr>
                            <th style="border-bottom: 1px solid #eee;">SL</th>
                            <th style="border-bottom: 1px solid #eee;">NAME</th>
                            <th class="text-end" style="border-bottom: 1px solid #eee;">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sizes as $key => $size)
                        <tr style="border-bottom: 1px solid #f8f9fa;">
                            <td class="font-w600" style="color: #333;">{{ $key + 1 }}</td>
                            <td class="font-w600" style="color: #333;">{{ $size->name }}</td>
                            <td class="text-end">
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input custom-switch" type="checkbox" disabled {{ $size->is_active == 1 ? 'checked' : '' }}>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">No sizes found.</td>
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
    }
    .table tbody td {
        padding: 15px 10px;
    }
</style>
@endsection
