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
            <h2 class="page-title font-w700" style="font-size: 24px; color: #333;">Seller Profile</h2>
            <a href="{{ route('saller.profile.edit') }}" class="btn btn-danger btn-sm px-4" style="border-radius: 8px; background-color: #ff3e6c; border: none;">
                <i class="bi bi-pencil-square me-1"></i> Edit Shop & Profile
            </a>
        </div>

        <div class="row g-4 mx-3">
            <!-- Left Side: Profile & Shop Info -->
            <div class="col-lg-8">
                <!-- Shop Header Card -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
                    <div style="height: 200px; background: url('{{ $seller->store_banner ? asset($seller->store_banner) : 'https://via.placeholder.com/1200x300?text=No+Banner' }}') center/cover no-repeat;">
                    </div>
                    <div class="card-body position-relative pt-5">
                        <div class="position-absolute" style="top: -60px; left: 30px;">
                            <img src="{{ $seller->store_logo ? asset($seller->store_logo) : asset('uploads/no-image.png') }}" 
                                 alt="Logo" style="width: 120px; height: 120px; border-radius: 12px; border: 5px solid #fff; background: #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1); object-fit: contain;">
                        </div>
                        <div class="ms-1 pt-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h3 class="font-w700 mb-1" style="color: #333;">{{ $seller->store_name }}</h3>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="text-warning small">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <span class="text-muted ms-1">(0.0)</span>
                                        </div>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3" style="border-radius: 20px;">Active Seller</span>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-outline-secondary btn-sm px-3" style="border-radius: 8px;"><i class="bi bi-box-arrow-up-right me-1"></i> Visit Shop</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Information -->
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                        <h5 class="font-w600" style="color: #333;"><i class="bi bi-info-circle me-2 text-danger"></i>Shop Information</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <td class="ps-4 py-3 text-muted w-25">Shop Name</td>
                                        <td class="py-3 font-w600">{{ $seller->store_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3 text-muted">Business Address</td>
                                        <td class="py-3">{{ $seller->address['business_address'] ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3 text-muted">Location</td>
                                        <td class="py-3">{{ $seller->address['city'] ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3 text-muted">Description</td>
                                        <td class="py-3">{{ $seller->store_description ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3 text-muted">Joined At</td>
                                        <td class="py-3">{{ $seller->created_at->format('M d, Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: User Info & Security -->
            <div class="col-lg-4">
                <!-- User Profile Card -->
                <div class="card border-0 shadow-sm mb-4 text-center py-4" style="border-radius: 12px;">
                    <div class="mb-3 position-relative d-inline-block mx-auto">
                        <img src="{{ $seller->photo ? asset($seller->photo) : 'https://ui-avatars.com/api/?name='.urlencode($seller->name).'&background=ff3e6c&color=fff' }}" 
                             alt="User" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #f8f9fa;">
                        <span class="position-absolute bottom-0 end-0 bg-success border border-white border-2 rounded-circle" style="width: 18px; height: 18px;"></span>
                    </div>
                    <h5 class="font-w700 mb-0">{{ $seller->name }}</h5>
                    <p class="text-muted small mb-3">{{ $seller->email }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge bg-primary-subtle text-primary px-3 py-2" style="border-radius: 8px;">Seller</span>
                        <span class="badge bg-light text-muted px-3 py-2" style="border-radius: 8px;">Joined {{ $seller->created_at->format('M Y') }}</span>
                    </div>
                </div>

                <!-- Password Update Form -->
                <div class="card border-0 shadow-sm" style="border-radius: 12px;" id="password-section">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                        <h5 class="font-w600" style="color: #333;"><i class="bi bi-shield-lock me-2 text-danger"></i>Security Settings</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('saller.profile.update_password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small font-w600">Current Password</label>
                                <input type="password" name="current_password" class="form-control" placeholder="••••••••" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small font-w600">New Password</label>
                                <input type="password" name="new_password" class="form-control" placeholder="New password" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small font-w600">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm" required>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 py-2 font-w600" style="border-radius: 8px;">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .font-w600 { font-weight: 600; }
    .font-w700 { font-weight: 700; }
    .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 15px;
    }
    .form-control:focus {
        border-color: #ff3e6c;
        box-shadow: 0 0 0 3px rgba(255, 62, 108, 0.1);
    }
    .card { transition: all 0.3s ease; }
</style>
@endsection
