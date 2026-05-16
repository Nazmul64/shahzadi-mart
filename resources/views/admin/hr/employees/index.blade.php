@extends('admin.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    <div class="container-fluid px-lg-5">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Employee Directory</h4>
                <p class="text-muted small mb-0">Total {{ $employees->count() }} staff members in your organization</p>
            </div>
            <a href="{{ route('manager.hr.employees.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm border-0" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                <i class="bi bi-person-plus me-2"></i> Add New Employee
            </a>
        </div>

        {{-- Employee Grid --}}
        <div class="row g-4">
            @forelse($employees as $employee)
                <div class="col-xl-4 col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 transition-all hover-shadow">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="position-relative">
                                    @if($employee->photo)
                                        <img src="{{ asset($employee->photo) }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 70px; height: 70px;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 d-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px;">
                                            <i class="bi bi-person display-6 text-primary"></i>
                                        </div>
                                    @endif
                                    <span class="position-absolute bottom-0 end-0 p-1 border border-light rounded-circle {{ $employee->status ? 'bg-success' : 'bg-danger' }}" style="width: 14px; height: 14px;"></span>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">{{ $employee->name }}</h5>
                                    <p class="text-muted small mb-0"><i class="bi bi-telephone me-1"></i> {{ $employee->phone }}</p>
                                    <span class="badge {{ $employee->status ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $employee->status ? 'text-success' : 'text-danger' }} rounded-pill" style="font-size: 10px;">
                                        {{ $employee->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>

                            <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <div class="bg-light p-2 rounded-3">
                                        <small class="text-muted d-block text-uppercase" style="font-size: 9px; letter-spacing: 0.5px;">Current Salary</small>
                                        <span class="fw-bold text-dark">৳{{ number_format($employee->current_salary, 0) }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-2 rounded-3">
                                        <small class="text-muted d-block text-uppercase" style="font-size: 9px; letter-spacing: 0.5px;">Joining Date</small>
                                        <span class="fw-medium text-dark small">{{ date('d M, Y', strtotime($employee->joining_date)) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="info-details small">
                                <p class="mb-1 text-muted"><i class="bi bi-geo-alt me-2"></i> {{ $employee->village }}, {{ $employee->thana }}, {{ $employee->district }}</p>
                                <p class="mb-1 text-muted"><i class="bi bi-person-hearts me-2"></i> Father: {{ $employee->father_name }}</p>
                                <p class="mb-1 text-muted"><i class="bi bi-card-text me-2"></i> NID: {{ $employee->nid ?: 'N/A' }}</p>
                            </div>

                            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                                <a href="{{ route('manager.hr.employees.show', $employee->id) }}" class="btn btn-light btn-sm flex-grow-1 rounded-3 fw-bold" style="font-size: 11px;"><i class="bi bi-eye me-1"></i> Full Profile</a>
                                <a href="{{ route('manager.hr.employees.edit', $employee->id) }}" class="btn btn-light btn-sm rounded-3 text-primary"><i class="bi bi-pencil"></i></a>
                                @if($employee->nid_photo)
                                    <a href="{{ asset($employee->nid_photo) }}" target="_blank" class="btn btn-light btn-sm rounded-3 text-info" title="View NID"><i class="bi bi-card-image"></i></a>
                                @endif
                                <form action="{{ route('manager.hr.employees.delete', $employee->id) }}" method="POST" onsubmit="return confirm('Delete this employee?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm rounded-3 text-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-white d-inline-block p-5 rounded-4 shadow-sm">
                        <i class="bi bi-people display-1 text-muted opacity-25"></i>
                        <h5 class="mt-4 fw-bold">No Employees Yet</h5>
                        <p class="text-muted">Your team will appear here once added</p>
                        <a href="{{ route('manager.hr.employees.create') }}" class="btn btn-primary rounded-pill px-4 mt-2">Add Employee</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1.25rem !important; }
    .hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important; }
    .object-fit-cover { object-fit: cover; }
</style>
@endsection
