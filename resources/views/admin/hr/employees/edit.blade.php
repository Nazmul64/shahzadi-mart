@extends('admin.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    <div class="container-fluid px-lg-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Edit Employee: {{ $employee->name }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb small mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('manager.hr.employees') }}" class="text-decoration-none">Employees</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                        <form action="{{ route('manager.hr.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">
                                {{-- Basic Info --}}
                                <div class="col-12"><h6 class="fw-bold text-primary border-bottom pb-2">Basic Information</h6></div>
                                
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control rounded-3 py-2" value="{{ $employee->name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control rounded-3 py-2" value="{{ $employee->phone }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Profile Photo</label>
                                    <input type="file" name="photo" class="form-control rounded-3 py-2" accept="image/*">
                                    @if($employee->photo)
                                        <div class="mt-2"><img src="{{ asset($employee->photo) }}" class="rounded shadow-sm" width="50"></div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">NID Number</label>
                                    <input type="text" name="nid" class="form-control rounded-3 py-2" value="{{ $employee->nid }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">NID Card Photo</label>
                                    <input type="file" name="nid_photo" class="form-control rounded-3 py-2" accept="image/*">
                                    @if($employee->nid_photo)
                                        <div class="mt-2"><img src="{{ asset($employee->nid_photo) }}" class="rounded shadow-sm" width="50"></div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Current Salary <span class="text-danger">*</span></label>
                                    <div class="input-group shadow-sm rounded-3">
                                        <span class="input-group-text bg-light border-end-0">৳</span>
                                        <input type="number" name="current_salary" class="form-control border-start-0 rounded-end-3 py-2" value="{{ $employee->current_salary }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Status</label>
                                    <select name="status" class="form-select rounded-3 py-2">
                                        <option value="1" {{ $employee->status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$employee->status ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                {{-- Family Info --}}
                                <div class="col-12 mt-5"><h6 class="fw-bold text-primary border-bottom pb-2">Family Information</h6></div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Father's Name</label>
                                    <input type="text" name="father_name" class="form-control rounded-3 py-2" value="{{ $employee->father_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Mother's Name</label>
                                    <input type="text" name="mother_name" class="form-control rounded-3 py-2" value="{{ $employee->mother_name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Father's Phone Number</label>
                                    <input type="text" name="father_phone" class="form-control rounded-3 py-2" value="{{ $employee->father_phone }}">
                                </div>

                                {{-- Address Info --}}
                                <div class="col-12 mt-5"><h6 class="fw-bold text-primary border-bottom pb-2">Address Information</h6></div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Village/Area</label>
                                    <input type="text" name="village" class="form-control rounded-3 py-2" value="{{ $employee->village }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Thana/Upazila</label>
                                    <input type="text" name="thana" class="form-control rounded-3 py-2" value="{{ $employee->thana }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-uppercase text-muted">District</label>
                                    <input type="text" name="district" class="form-control rounded-3 py-2" value="{{ $employee->district }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Full Address (Details)</label>
                                    <textarea name="address" class="form-control rounded-3" rows="3">{{ $employee->address }}</textarea>
                                </div>

                                <div class="col-12 mt-5 pt-3 border-top text-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold border-0 shadow-sm" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                                        <i class="bi bi-check-circle me-2"></i> Update Employee Profile
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
@endsection
