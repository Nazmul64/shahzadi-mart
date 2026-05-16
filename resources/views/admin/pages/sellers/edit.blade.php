@extends('admin.master')
@section('content')
<style>
    #map {
        height: 450px;
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border: 1px solid #eee;
        z-index: 1;
    }
    .pac-container {
        z-index: 9999 !important;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border: none;
        margin-top: 5px;
    }
    .form-control {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #dee2e6;
    }
    .profile-upload-preview, .logo-upload-preview, .banner-upload-preview {
        width: 100%;
        height: 180px;
        background: #f1f3f5;
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 10px;
    }
    .font-w600 { font-weight: 600; }
    .font-w700 { font-weight: 700; }
    .btn-danger { background: #ff3e3e !important; border: none; }
</style>

<div class="content-body" style="background: #f8f9fa;">
    <div class="container-fluid">
        <div class="row page-titles mx-0 align-items-center mb-4">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4 class="font-w700 text-dark"><i class="bi bi-pencil-square me-2 text-danger"></i>Edit Shop: {{ $seller->store_name }}</h4>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.sellers.update', $seller->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-12">
                     {{-- User & Account Info --}}
                     <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="card-title font-w600"><i class="bi bi-person-circle me-2"></i>Registration Details</h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control" value="{{ $seller->first_name }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ $seller->last_name }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{ $seller->email }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control" value="{{ $seller->phone }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Password (Leave blank to keep current)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">User Photo</label>
                                    <div class="profile-upload-preview" id="userPhotoPreview">
                                        <img src="{{ $seller->photo_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <input type="file" name="photo" class="form-control" onchange="previewImage(this, 'userPhotoPreview')">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Shop Information --}}
                    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="card-title font-w600"><i class="bi bi-shop me-2"></i>Shop Details</h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Shop Name <span class="text-danger">*</span></label>
                                    <input type="text" name="store_name" class="form-control" value="{{ $seller->store_name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Exact Address</label>
                                    <input type="text" name="address" id="exact_address" class="form-control" value="{{ $seller->address }}" placeholder="Search or Type Address">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Shop Logo</label>
                                    <div class="logo-upload-preview" id="shopLogoPreview">
                                        <img src="{{ $seller->store_logo_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <input type="file" name="store_logo" class="form-control" onchange="previewImage(this, 'shopLogoPreview')">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Shop Banner</label>
                                    <div class="banner-upload-preview" id="shopBannerPreview">
                                        <img src="{{ $seller->store_banner_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <input type="file" name="store_banner" class="form-control" onchange="previewImage(this, 'shopBannerPreview')">
                                </div>
                                
                                {{-- Map Section --}}
                                <div class="col-md-12 mb-4">
                                    <label class="form-label d-flex justify-content-between">
                                        <span><i class="bi bi-map me-1"></i>Edit Shop Location (Google Map)</span>
                                        <span class="text-primary small" id="latlng_display">{{ $seller->latitude }}, {{ $seller->longitude }}</span>
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-white"><i class="bi bi-search text-danger"></i></span>
                                        <input type="text" id="map_search" class="form-control border-start-0" placeholder="Search District, Area or Landmarks...">
                                    </div>
                                    <div id="map"></div>
                                    <input type="hidden" name="latitude" id="lat" value="{{ $seller->latitude }}">
                                    <input type="hidden" name="longitude" id="lng" value="{{ $seller->longitude }}">
                                    <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle me-1"></i>You can drag the red marker to pinpoint the exact shop location.</small>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Shop Description</label>
                                    <textarea name="description" class="form-control" rows="3">{{ $seller->store_description }}</textarea>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control form-select">
                                        <option value="active" {{ $seller->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $seller->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="pending" {{ $seller->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="suspended" {{ $seller->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mb-5">
                        <button type="submit" class="btn btn-danger btn-lg px-5 shadow-sm" style="border-radius: 10px;">
                            <i class="bi bi-check-circle me-2"></i> Update Shop & Seller
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Google Maps API --}}
<script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places"></script>

<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function initMap() {
        var defaultPos = { 
            lat: {{ $seller->latitude ?? 23.8103 }}, 
            lng: {{ $seller->longitude ?? 90.4125 }} 
        };
        
        var map = new google.maps.Map(document.getElementById("map"), {
            center: defaultPos,
            zoom: 15,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true,
            styles: [
                { "featureType": "poi", "stylers": [{ "visibility": "off" }] }
            ]
        });

        var marker = new google.maps.Marker({
            position: defaultPos,
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            title: "Drag to pin shop location"
        });

        // Autocomplete search
        var input = document.getElementById('map_search');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) return;

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            updateLocation(place.geometry.location.lat(), place.geometry.location.lng());
            
            if(place.formatted_address) {
                document.getElementById('exact_address').value = place.formatted_address;
            }
        });

        google.maps.event.addListener(marker, 'dragend', function() {
            var pos = marker.getPosition();
            updateLocation(pos.lat(), pos.lng());
        });

        map.addListener('click', function(e) {
            marker.setPosition(e.latLng);
            updateLocation(e.latLng.lat(), e.latLng.lng());
        });

        function updateLocation(lat, lng) {
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
            document.getElementById('latlng_display').innerText = lat.toFixed(6) + ", " + lng.toFixed(6);
        }
    }

    google.maps.event.addDomListener(window, 'load', initMap);
</script>
@endsection
