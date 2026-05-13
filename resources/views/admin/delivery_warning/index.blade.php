@extends('admin.master')

@section('main-content')

<div class="page-header">
    <div class="page-header__left">
        <h4 class="page-title">Delivery Time Warning</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">24 Hours (Delivery Warning)</li>
            </ol>
        </nav>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('admin.delivery_warning.update') }}" method="POST">
            @csrf

            <div class="row g-4">
                <div class="col-12 col-md-8">
                    <h5 class="mb-3">Delivery Time Details</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Button Text</label>
                        <input type="text" name="button_text" class="form-control" value="{{ $deliveryWarning->button_text ?? 'Delivery within 24-72 hrs.' }}" placeholder="e.g. Delivery within 24-72 hrs.">
                        <small class="text-muted">This text appears inside the gradient button below the contact options on the product details page.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Warning Note</label>
                        <textarea name="warning_text" class="form-control" rows="5" placeholder="e.g. বিঃদ্রঃ- দয়া করে ১০০% শিওর হয়ে অর্ডার করবেন।">{{ $deliveryWarning->warning_text ?? 'বিঃদ্রঃ- দয়া করে ১০০% শিওর হয়ে অর্ডার করবেন। ছবি এবং বর্ণনার সাথে পণ্যের মিল থাকা সত্ত্বেও আপনি পণ্য গ্রহণ করতে না চাইলে কুরিয়ার চার্জ ১৫০টাকা কুরিয়ার ডেলিভারি ম্যানকে প্রদান করে পণ্য সাথে সাথে রিটার্ন করবেন। পরে কোন কমপ্লেইন/রিটার্ন গ্রহণযোগ্য নয়! অযথা অর্ডার থেকে বিরত থাকুন, কারন আপনার মোবাইল নাম্বার এড্রেস ডিভাইস আইপি নাম্বার দেখা যায়।' }}</textarea>
                        <small class="text-muted">This red warning text appears directly below the delivery button.</small>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
                        <i class="fas fa-save me-1"></i> Save Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.page-header { display: flex; justify-content: space-between; margin-bottom: 25px; }
.page-title { font-weight: 800; color: #0b1121; }
.card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
.form-label { font-weight: 600; color: #475569; font-size: 14px; }
.form-control { border-radius: 8px; border-color: #e2e8f0; padding: 10px 15px; }
.form-control:focus { box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); border-color: #3b82f6; }
.btn-primary { background: #0b1121; border: none; border-radius: 8px; transition: all 0.3s; }
.btn-primary:hover { background: #1e293b; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(11, 17, 33, 0.2); }
.breadcrumb-item a { color: #64748b; text-decoration: none; }
</style>

@endsection
