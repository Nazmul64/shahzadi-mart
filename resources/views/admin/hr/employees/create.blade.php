@extends('admin.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    <div class="container-fluid px-lg-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Add New Employee</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb small mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.hr.employees') }}" class="text-decoration-none">Employees</a></li>
                        <li class="breadcrumb-item active">Add New</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('manager.hr.employees') }}" class="btn btn-sm btn-light border px-3 rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-lg-5">
                        <form action="{{ route('manager.hr.employees.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">
                                {{-- Basic Info --}}
                                <div class="col-12"><h6 class="fw-bold text-primary border-bottom pb-2">Basic Information</h6></div>
                                
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control rounded-3 py-2 @error('name') is-invalid @enderror" placeholder="e.g. John Doe" value="{{ old('name') }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control rounded-3 py-2 @error('phone') is-invalid @enderror" placeholder="01XXX XXXXXX" value="{{ old('phone') }}" required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Profile Photo</label>
                                    <input type="file" name="photo" id="photoInput" class="form-control rounded-3 py-2 @error('photo') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp,image/svg+xml">
                                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="mt-2" id="photoPreviewWrap" style="display:none;">
                                        <img id="photoPreview" src="#" class="rounded shadow-sm" style="width: 80px; height: 80px; object-fit: cover; border: 2px solid #6366f1;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">NID Number</label>
                                    <input type="text" name="nid" class="form-control rounded-3 py-2" placeholder="National ID Card Number" value="{{ old('nid') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">NID Card Photo / PDF</label>
                                    <input type="file" name="nid_photo" id="nidInput" class="form-control rounded-3 py-2 @error('nid_photo') is-invalid @enderror" accept="image/*,application/pdf">
                                    @error('nid_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="mt-2" id="nidPreviewWrap" style="display:none;">
                                        <div id="pdfPreview" class="bg-light rounded p-3 text-center" style="display:none; border: 2px dashed #6366f1;">
                                            <i class="bi bi-file-earmark-pdf-fill text-danger display-6"></i>
                                            <p class="small mb-0 mt-1 fw-bold">PDF Document Selected</p>
                                        </div>
                                        <img id="nidPreview" src="#" class="rounded shadow-sm" style="width: 120px; height: 75px; object-fit: cover; border: 2px solid #6366f1;">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Starting Salary <span class="text-danger">*</span></label>
                                    <div class="input-group shadow-sm rounded-3">
                                        <span class="input-group-text bg-light border-end-0">৳</span>
                                        <input type="number" name="starting_salary" class="form-control border-start-0 rounded-end-3 py-2 @error('starting_salary') is-invalid @enderror" placeholder="0.00" value="{{ old('starting_salary') }}" required>
                                    </div>
                                    @error('starting_salary') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Joining Date <span class="text-danger">*</span></label>
                                    <input type="date" name="joining_date" class="form-control rounded-3 py-2 @error('joining_date') is-invalid @enderror" value="{{ old('joining_date', date('Y-m-d')) }}" required>
                                    @error('joining_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Family Info --}}
                                <div class="col-12 mt-5"><h6 class="fw-bold text-primary border-bottom pb-2">Family Information</h6></div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Father's Name</label>
                                    <input type="text" name="father_name" class="form-control rounded-3 py-2" placeholder="Name of father" value="{{ old('father_name') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Mother's Name</label>
                                    <input type="text" name="mother_name" class="form-control rounded-3 py-2" placeholder="Name of mother" value="{{ old('mother_name') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Father's Phone Number</label>
                                    <input type="text" name="father_phone" class="form-control rounded-3 py-2" placeholder="Phone of father" value="{{ old('father_phone') }}">
                                </div>

                                {{-- Address Info --}}
                                <div class="col-12 mt-5"><h6 class="fw-bold text-primary border-bottom pb-2">Address Information</h6></div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Village/Area</label>
                                    <input type="text" name="village" class="form-control rounded-3 py-2" placeholder="Village name" value="{{ old('village') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Thana/Upazila</label>
                                    <input type="text" name="thana" class="form-control rounded-3 py-2" placeholder="Thana name" value="{{ old('thana') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-uppercase text-muted">District</label>
                                    <input type="text" name="district" class="form-control rounded-3 py-2" placeholder="District name" value="{{ old('district') }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Full Address (Details)</label>
                                    <textarea name="address" class="form-control rounded-3" rows="3" placeholder="Additional address details">{{ old('address') }}</textarea>
                                </div>

                                <div class="col-12 mt-5 pt-3 border-top text-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold border-0 shadow-sm" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                                        <i class="bi bi-check-circle me-2"></i> Save Employee Profile
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setupPreview(inputId, previewId, wrapId, pdfPreviewId = null) {
        document.getElementById(inputId).addEventListener('change', function(e) {
            const file = e.target.files[0];
            const wrap = document.getElementById(wrapId);
            const imgPreview = document.getElementById(previewId);
            const pdfPreview = pdfPreviewId ? document.getElementById(pdfPreviewId) : null;

            if (file) {
                wrap.style.display = 'block';
                if (file.type === 'application/pdf' && pdfPreview) {
                    imgPreview.style.display = 'none';
                    pdfPreview.style.display = 'block';
                } else {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        imgPreview.src = event.target.result;
                        imgPreview.style.display = 'block';
                        if (pdfPreview) pdfPreview.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    }

    setupPreview('photoInput', 'photoPreview', 'photoPreviewWrap');
    setupPreview('nidInput', 'nidPreview', 'nidPreviewWrap', 'pdfPreview');
</script>

@endsection
