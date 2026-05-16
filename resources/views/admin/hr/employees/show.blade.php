@extends('admin.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    <div class="container-fluid px-lg-5">
        {{-- Profile Header --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-body p-0">
                <div class="bg-primary bg-opacity-10 p-4 p-lg-5 d-md-flex align-items-center gap-4">
                    <div class="profile-img-wrap mb-3 mb-md-0">
                        @if($employee->photo)
                            <img src="{{ asset($employee->photo) }}" class="rounded-circle shadow-sm border border-4 border-white" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-white rounded-circle shadow-sm border border-4 border-white d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <i class="bi bi-person text-primary display-4"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="fw-bold text-dark mb-1">{{ $employee->name }}</h3>
                        <p class="text-muted mb-2"><i class="bi bi-telephone-fill me-1"></i> {{ $employee->phone }} | <i class="bi bi-geo-alt-fill me-1"></i> {{ $employee->district }}</p>
                        <div class="d-flex gap-2">
                            <span class="badge bg-primary rounded-pill px-3 py-2">ID: #EMP-{{ $employee->id }}</span>
                            <span class="badge {{ $employee->status ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                                {{ $employee->status ? 'Active Staff' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <a href="{{ route('manager.hr.employees.edit', $employee->id) }}" class="btn btn-white bg-white text-primary rounded-pill px-4 shadow-sm fw-bold border">
                            <i class="bi bi-pencil-square me-2"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Left Column: Details --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4 border-bottom pb-2">Personal Details</h6>
                        <div class="info-item mb-3">
                            <small class="text-muted d-block">Father's Name</small>
                            <span class="fw-medium text-dark">{{ $employee->father_name ?: 'N/A' }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <small class="text-muted d-block">Mother's Name</small>
                            <span class="fw-medium text-dark">{{ $employee->mother_name ?: 'N/A' }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <small class="text-muted d-block">Father's Phone</small>
                            <span class="fw-medium text-dark">{{ $employee->father_phone ?: 'N/A' }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <small class="text-muted d-block">Village/Area</small>
                            <span class="fw-medium text-dark">{{ $employee->village ?: 'N/A' }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <small class="text-muted d-block">Thana & District</small>
                            <span class="fw-medium text-dark">{{ $employee->thana }}, {{ $employee->district }}</span>
                        </div>
                        <div class="info-item">
                            <small class="text-muted d-block">Joining Date</small>
                            <span class="fw-medium text-dark">{{ date('d M, Y', strtotime($employee->joining_date)) }}</span>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4 border-bottom pb-2">Employment & Documents</h6>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Salary:</span>
                            <span class="fw-bold text-dark">৳{{ number_format($employee->current_salary, 0) }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">National ID (NID)</small>
                            @if($employee->nid_photo)
                                <a href="{{ asset($employee->nid_photo) }}" target="_blank" class="d-block border rounded p-2 text-center text-decoration-none bg-light">
                                    <i class="bi bi-card-image me-1"></i> View NID Document
                                </a>
                            @else
                                <span class="badge bg-light text-muted w-100 py-2 border">No NID Uploaded</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Activity Summary --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold mb-0">Monthly Performance Summary ({{ date('F Y') }})</h6>
                            <a href="{{ route('manager.hr.salary') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View Full Payroll</a>
                        </div>
                        
                        @php
                            $month = date('Y-m');
                            $presentCount = $employee->attendances->where('status', 'present')->where('date', 'like', $month.'%')->count();
                            $absentCount = $employee->attendances->where('status', 'absent')->where('date', 'like', $month.'%')->count();
                            $totalAdvance = $employee->advances->where('month', $month)->sum('amount');
                        @endphp

                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="bg-success bg-opacity-10 p-3 rounded-4 text-center border border-success border-opacity-10">
                                    <h3 class="fw-bold text-success mb-0">{{ $presentCount }}</h3>
                                    <small class="text-success fw-bold text-uppercase" style="font-size: 10px;">Present Days</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-danger bg-opacity-10 p-3 rounded-4 text-center border border-danger border-opacity-10">
                                    <h3 class="fw-bold text-danger mb-0">{{ $absentCount }}</h3>
                                    <small class="text-danger fw-bold text-uppercase" style="font-size: 10px;">Absent Days</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-warning bg-opacity-10 p-3 rounded-4 text-center border border-warning border-opacity-10">
                                    <h3 class="fw-bold text-warning mb-0">৳{{ number_format($totalAdvance, 0) }}</h3>
                                    <small class="text-warning fw-bold text-uppercase" style="font-size: 10px;">Advance Taken</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Attendance Calendar Preview --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4 border-bottom pb-2">Recent Attendance</h6>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr class="text-muted small">
                                        <th>Date</th>
                                        <th>Day</th>
                                        <th class="text-center">Status</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee->attendances()->latest()->take(10)->get() as $att)
                                        <tr>
                                            <td><span class="fw-medium">{{ date('d M, Y', strtotime($att->date)) }}</span></td>
                                            <td><span class="text-muted small">{{ date('D', strtotime($att->date)) }}</span></td>
                                            <td class="text-center">
                                                <span class="badge {{ $att->status == 'present' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $att->status == 'present' ? 'text-success' : 'text-danger' }} rounded-pill" style="font-size: 10px;">
                                                    {{ ucfirst($att->status) }}
                                                </span>
                                            </td>
                                            <td><small class="text-muted">{{ $att->note ?: '-' }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
