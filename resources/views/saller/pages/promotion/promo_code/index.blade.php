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
            <h2 class="page-title font-w700" style="font-size: 24px; color: #333;">Promo Codes</h2>
            <a href="{{ route('saller.promotion.promo_code.create') }}" class="btn btn-danger btn-sm px-4" style="border-radius: 8px; background-color: #ff3e6c; border: none;">
                <i class="bi bi-plus-circle me-1"></i> Add Promo Code
            </a>
        </div>

        <div class="data-card border-0 shadow-sm mx-3" style="border-radius: 10px; background: #fff;">
            <div class="table-responsive px-4 py-4">
                <table class="table align-middle">
                    <thead class="text-uppercase small text-muted font-w600" style="background: #f8f9fa;">
                        <tr>
                            <th>DISCOUNT</th>
                            <th>STARTED AT</th>
                            <th>EXPIRED AT</th>
                            <th>STATUS</th>
                            <th class="text-end">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                        <tr style="border-bottom: 1px solid #f8f9fa;">
                            <td class="font-w600" style="color: #333;">{{ $coupon->code }}</td>
                            <td class="font-w600" style="color: #333;">
                                {{ $coupon->type === 'discount_by_percentage' ? $coupon->percentage.'%' : '$'.$coupon->amount }}
                            </td>
                            <td class="text-muted">{{ $coupon->start_date ? $coupon->start_date->format('Y-m-d') : 'N/A' }}</td>
                            <td class="text-muted">{{ $coupon->end_date ? $coupon->end_date->format('Y-m-d') : 'N/A' }}</td>
                            <td>
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input custom-switch" type="checkbox" onchange="updateStatus({{ $coupon->id }}, this)" {{ $coupon->status == 'activated' ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="action-buttons justify-content-end d-flex align-items-center">
                                    <a href="{{ route('saller.promotion.promo_code.edit', $coupon->id) }}" class="btn-action edit"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('saller.promotion.promo_code.delete', $coupon->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this promo code?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-ticket-perforated text-muted" style="font-size: 48px;"></i>
                                <p class="text-muted mt-2">No promo codes found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function updateStatus(id, element) {
        const status = element.checked ? 'activated' : 'deactivated';
        
        fetch(`/saller/promo-codes/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Optional: show a small toast or notification
                console.log('Status updated successfully');
            } else {
                alert('Failed to update status');
                element.checked = !element.checked; // Revert switch
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred');
            element.checked = !element.checked; // Revert switch
        });
    }
</script>

<style>
    .font-w600 { font-weight: 600; }
    .font-w700 { font-weight: 700; }
    .custom-switch {
        width: 40px !important;
        height: 20px !important;
        cursor: pointer !important;
    }
    .custom-switch:checked {
        background-color: #ff3e6c !important;
        border-color: #ff3e6c !important;
    }
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
