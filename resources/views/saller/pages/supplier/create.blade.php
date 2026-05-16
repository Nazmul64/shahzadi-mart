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
                    <li class="breadcrumb-item"><a href="{{ route('saller.suppliers.index') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> Back</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Supplier</li>
                </ol>
            </nav>
            <h2 class="page-title font-w700" style="font-size: 24px; color: #333;">Add New Supplier</h2>
        </div>

        <div class="data-card border-0 shadow-sm mx-3 mb-5" style="border-radius: 12px; background: #fff;">
            <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                <h5 class="font-w600" style="font-size: 16px; color: #333;"><i class="bi bi-person-plus me-2 text-primary"></i>Supplier Information</h5>
            </div>
            
            <form action="{{ route('saller.suppliers.store') }}" method="POST" enctype="multipart/form-data" class="p-4">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" placeholder="Enter first name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" placeholder="Enter last name" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email address" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone number" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-w600">Supplier Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/*" onchange="previewImage(this, 'photo-preview')">
                            <small class="text-muted d-block mt-1">Uploads will be saved in root /uploads/supplier</small>
                            <div class="mt-2">
                                <img id="photo-preview" src="#" alt="Preview" style="display: none; width: 100px; height: 100px; border-radius: 8px; object-fit: cover; border: 1px solid #ddd;">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="button" class="btn btn-light px-4 me-2" onclick="window.location.href='{{ route('saller.suppliers.index') }}'">Cancel</button>
                        <button type="submit" class="btn btn-danger px-5" style="background-color: #ff3e6c; border: none; border-radius: 8px;">Save Supplier</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    .font-w600 { font-weight: 600; }
    .font-w700 { font-weight: 700; }
    .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px 15px;
    }
    .form-control:focus {
        border-color: #ff3e6c;
        box-shadow: 0 0 0 3px rgba(255, 62, 108, 0.1);
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: "|";
        color: #ccc;
    }
</style>
@endsection
