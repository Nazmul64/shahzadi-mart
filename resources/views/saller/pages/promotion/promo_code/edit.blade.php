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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('saller.promotion.promo_code.index') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> Back</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Voucher</li>
                </ol>
            </nav>
            <h2 class="page-title font-w700" style="font-size: 24px; color: #333;">Edit Voucher</h2>
        </div>

        <div class="data-card border-0 shadow-sm mx-3 mb-5" style="border-radius: 12px; background: #fff;">
            <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                <h5 class="font-w600" style="font-size: 16px; color: #333;"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Voucher: {{ $coupon->code }}</h5>
            </div>
            
            <form action="{{ route('saller.promotion.promo_code.update', $coupon->id) }}" method="POST" class="p-4">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Voucher Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" value="{{ $coupon->code }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Discount Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required onchange="toggleDiscountFields(this)">
                                <option value="discount_by_amount" {{ $coupon->type == 'discount_by_amount' ? 'selected' : '' }}>Amount</option>
                                <option value="discount_by_percentage" {{ $coupon->type == 'discount_by_percentage' ? 'selected' : '' }}>Percentage</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Discount <span class="text-danger">*</span></label>
                            <input type="number" name="amount" id="discount_amount" class="form-control {{ $coupon->type == 'discount_by_amount' ? '' : 'd-none' }}" value="{{ $coupon->amount }}">
                            <input type="number" name="percentage" id="discount_percentage" class="form-control {{ $coupon->type == 'discount_by_percentage' ? '' : 'd-none' }}" value="{{ $coupon->percentage }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Limit For Single User</label>
                            <input type="number" name="quantity_limit" class="form-control" value="{{ $coupon->quantity_limit }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control" value="{{ $coupon->start_date ? $coupon->start_date->format('Y-m-d') : '' }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Start Time <span class="text-danger">*</span></label>
                            <input type="time" name="start_time" class="form-control" value="00:00">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Expired Date <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control" value="{{ $coupon->end_date ? $coupon->end_date->format('Y-m-d') : '' }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Expired Time <span class="text-danger">*</span></label>
                            <input type="time" name="end_time" class="form-control" value="23:59">
                        </div>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="button" class="btn btn-light px-4 me-2" onclick="window.location.href='{{ route('saller.promotion.promo_code.index') }}'">Cancel</button>
                        <button type="submit" class="btn btn-danger px-5" style="background-color: #ff3e6c; border: none; border-radius: 8px;">Update Voucher</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleDiscountFields(select) {
        const amountInput = document.getElementById('discount_amount');
        const percentInput = document.getElementById('discount_percentage');
        
        if (select.value === 'discount_by_percentage') {
            amountInput.classList.add('d-none');
            percentInput.classList.remove('d-none');
        } else {
            amountInput.classList.remove('d-none');
            percentInput.classList.add('d-none');
        }
    }
</script>

<style>
    .font-w600 { font-weight: 600; }
    .font-w700 { font-weight: 700; }
    .form-control, .form-select {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px 15px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #ff3e6c;
        box-shadow: 0 0 0 3px rgba(255, 62, 108, 0.1);
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: "|";
        color: #ccc;
    }
</style>
@endsection
