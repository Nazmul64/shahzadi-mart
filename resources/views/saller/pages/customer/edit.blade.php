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
        <div class="container-fluid px-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="font-w700 mb-0" style="font-size: 24px; color: #333;">Edit Customer</h2>
                <a href="{{ route('saller.customer.index') }}" class="btn btn-outline-secondary btn-sm px-3" style="border-radius: 8px;">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <form action="{{ route('saller.customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label font-w600">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control" placeholder="Enter first name" value="{{ old('first_name', $customer->first_name) }}" required>
                                    @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label font-w600">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Enter last name" value="{{ old('last_name', $customer->last_name) }}" required>
                                    @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label font-w600">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control" placeholder="Enter phone number" value="{{ old('phone', $customer->phone) }}" required>
                                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label font-w600">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter email address" value="{{ old('email', $customer->email) }}" required>
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label font-w600">Password (Leave blank to keep current)</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" id="password" placeholder="New password">
                                        <button class="btn btn-outline-light border text-muted" type="button" onclick="togglePass('password')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label font-w600">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Repeat new password">
                                        <button class="btn btn-outline-light border text-muted" type="button" onclick="togglePass('password_confirmation')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label font-w600">Profile Photo</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        @if($customer->photo)
                                        <img src="{{ asset($customer->photo) }}" alt="Current Photo" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                        @endif
                                        <div class="photo-upload-container p-3 border flex-grow-1" style="border-style: dashed !important; border-radius: 10px; background: #fafafa;">
                                            <input type="file" name="photo" class="form-control d-none" id="photoInput" accept="image/*" onchange="previewImage(this)">
                                            <div class="text-center py-2" onclick="document.getElementById('photoInput').click()" style="cursor: pointer;">
                                                <i class="bi bi-cloud-arrow-up text-muted" style="font-size: 24px;"></i>
                                                <p class="mb-0 text-muted small">Click to change photo</p>
                                            </div>
                                            <div id="imagePreview" class="text-center d-none mt-2">
                                                <img src="#" alt="Preview" class="rounded" style="max-height: 80px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-danger px-5 py-2 font-w700" style="background: #ff3e6c; border: none; border-radius: 8px;">
                                    Update Customer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePass(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }

    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const img = preview.querySelector('img');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    .font-w600 { font-weight: 600; }
    .font-w700 { font-weight: 700; }
    .form-control:focus {
        border-color: #ff3e6c;
        box-shadow: 0 0 0 0.2rem rgba(255, 62, 108, 0.1);
    }
</style>
@endsection
