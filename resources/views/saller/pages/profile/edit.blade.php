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
            <div>
                <h2 class="page-title font-w700" style="font-size: 24px; color: #333;"><i class="bi bi-pencil-square me-2 text-danger"></i>Edit Seller Profile & Shop</h2>
                <p class="text-muted small mb-0">Update your personal and business information.</p>
            </div>
            <a href="{{ route('saller.profile.index') }}" class="btn btn-light btn-sm px-4" style="border-radius: 8px;">
                <i class="bi bi-arrow-left me-1"></i> Back to Profile
            </a>
        </div>

        <form action="{{ route('saller.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4 mx-3 mb-5">
                <!-- Left: Form Fields -->
                <div class="col-lg-8">
                    <!-- Personal Info Card -->
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                        <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                            <h5 class="font-w600" style="color: #333;"><i class="bi bi-person-circle me-2 text-primary"></i>Personal Information</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12 mb-3">
                                    <label class="form-label small font-w600">Profile Photo</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <img id="photo-preview" src="{{ $seller->photo ? asset($seller->photo) : 'https://ui-avatars.com/api/?name='.urlencode($seller->name).'&background=ff3e6c&color=fff' }}" 
                                             alt="User" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #eee;">
                                        <input type="file" name="photo" class="form-control" accept="image/*" onchange="previewImage(this, 'photo-preview')">
                                    </div>
                                    <small class="text-muted small">Recommended: Square image (JPG, PNG)</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small font-w600">First Name</label>
                                    <input type="text" name="firstName" class="form-control" value="{{ $seller->first_name ?? explode(' ', $seller->name)[0] }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small font-w600">Last Name</label>
                                    <input type="text" name="lastName" class="form-control" value="{{ $seller->last_name ?? (count(explode(' ', $seller->name)) > 1 ? explode(' ', $seller->name)[1] : '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small font-w600">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $seller->phone }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small font-w600">Email Address</label>
                                    <input type="email" class="form-control bg-light" value="{{ $seller->email }}" readonly disabled>
                                    <small class="text-muted small">Email cannot be changed.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shop Settings Card -->
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                            <h5 class="font-w600" style="color: #333;"><i class="bi bi-shop me-2 text-primary"></i>Shop Settings</h5>
                        </div>
                        <div class="card-body p-4">
                            @php
                                $address = is_array($seller->address) ? $seller->address : [];
                            @endphp
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label small font-w600">Shop Name</label>
                                    <input type="text" name="storeName" class="form-control" value="{{ $seller->store_name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small font-w600">Business Name</label>
                                    <input type="text" name="businessName" class="form-control" value="{{ $seller->business_name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small font-w600">City</label>
                                    <input type="text" name="city" class="form-control" value="{{ $seller->city }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small font-w600">Business Address</label>
                                    <textarea name="businessAddress" class="form-control" rows="3" required>{{ $seller->business_address }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small font-w600">Postal Code</label>
                                    <input type="text" name="postalCode" class="form-control" value="{{ $seller->postal_code }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Card -->
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                            <h5 class="font-w600" style="color: #333;"><i class="bi bi-geo-alt me-2 text-danger"></i>Pin Your Location</h5>
                        </div>
                        <div class="card-body p-4">
                            <div id="map" style="height: 300px; border-radius: 12px; border: 1px solid #eee;"></div>
                            <input type="hidden" name="latitude" id="latitude" value="{{ $seller->latitude ?? '23.6850' }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ $seller->longitude ?? '90.3563' }}">
                            <small class="text-muted d-block mt-2">Click on the map to pin your shop location.</small>
                        </div>
                    </div>
                </div>

                <!-- Right: Graphics Update -->
                <div class="col-lg-4">
                    <!-- Shop Logo Card -->
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                        <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                            <h5 class="font-w600" style="color: #333;">Shop Logo</h5>
                        </div>
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <img id="logo-preview" src="{{ $seller->store_logo ? asset($seller->store_logo) : asset('uploads/no-image.png') }}" 
                                     alt="Logo" style="width: 150px; height: 150px; border-radius: 12px; object-fit: contain; border: 1px solid #eee; background: #fff;">
                            </div>
                            <input type="file" name="storeLogo" class="form-control" accept="image/*" onchange="previewImage(this, 'logo-preview')">
                            <small class="text-muted d-block mt-2">Transparent PNG or JPG (500x500px)</small>
                        </div>
                    </div>

                    <!-- Shop Banner Card -->
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                        <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                            <h5 class="font-w600" style="color: #333;">Shop Banner</h5>
                        </div>
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <img id="banner-preview" src="{{ $seller->store_banner ? asset($seller->store_banner) : 'https://via.placeholder.com/1200x300?text=Shop+Banner' }}" 
                                     alt="Banner" style="width: 100%; height: 120px; border-radius: 8px; object-fit: cover; border: 1px solid #eee;">
                            </div>
                            <input type="file" name="storeBanner" class="form-control" accept="image/*" onchange="previewImage(this, 'banner-preview')">
                            <small class="text-muted d-block mt-2">Wide landscape (e.g. 1920x480px)</small>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm bg-danger text-white p-2 mb-4" style="border-radius: 12px;">
                         <button type="submit" class="btn btn-danger w-100 py-3 font-w700" style="border-radius: 10px; background: #ff3e6c; border: none;">
                            <i class="bi bi-save me-2"></i> SAVE ALL CHANGES
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Map Initialization
    document.addEventListener('DOMContentLoaded', function() {
        var lat = document.getElementById('latitude').value;
        var lng = document.getElementById('longitude').value;
        
        var map = L.map('map').setView([lat, lng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        var marker = L.marker([lat, lng], {
            draggable: true
        }).addTo(map);
        
        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
        });
        
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
    });
</script>

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
</style>
@endsection
