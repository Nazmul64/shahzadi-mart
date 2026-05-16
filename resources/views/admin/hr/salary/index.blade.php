@extends('admin.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    <div class="container-fluid px-lg-5">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Salary & Payment Management</h4>
                <p class="text-muted small mb-0">Manage payroll, track advances, and view payment history</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <input type="month" id="salary_month" class="form-control rounded-pill border-0 shadow-sm px-3" 
                       value="{{ $month }}" onchange="window.location.href='?month=' + this.value">
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 bg-primary text-white">
                        <small class="text-white-50 fw-bold text-uppercase" style="font-size: 10px;">Total Base Salaries</small>
                        <h2 class="fw-bold mb-0">৳{{ number_format($employees->sum('current_salary'), 0) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 bg-danger text-white">
                        <small class="text-white-50 fw-bold text-uppercase" style="font-size: 10px;">Total Advances (Month)</small>
                        @php $monthAdvances = 0; foreach($employees as $e) $monthAdvances += $e->advances->sum('amount'); @endphp
                        <h2 class="fw-bold mb-0">৳{{ number_format($monthAdvances, 0) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 bg-warning text-white">
                        <small class="text-white-50 fw-bold text-uppercase" style="font-size: 10px;">Company Expenses</small>
                        <h2 class="fw-bold mb-0">৳{{ number_format($totalExpenses, 0) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 bg-dark text-white">
                        <small class="text-white-50 fw-bold text-uppercase" style="font-size: 10px;">Est. Total Cost</small>
                        <h2 class="fw-bold mb-0">৳{{ number_format($employees->sum('current_salary') + $totalExpenses, 0) }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 p-0">
                <ul class="nav nav-tabs nav-fill border-0" id="salaryTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active py-3 fw-bold border-0 rounded-0" data-bs-toggle="tab" href="#payrollTab">
                            <i class="bi bi-calculator me-2"></i> Monthly Payroll
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-3 fw-bold border-0 rounded-0" data-bs-toggle="tab" href="#advanceTab">
                            <i class="bi bi-cash-stack me-2"></i> Advance History
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-3 fw-bold border-0 rounded-0" data-bs-toggle="tab" href="#paymentTab">
                            <i class="bi bi-check2-all me-2"></i> Payment History
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="tab-content">
                    {{-- ── Tab 1: Payroll ── --}}
                    <div class="tab-pane fade show active" id="payrollTab">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr class="text-muted small">
                                        <th class="ps-4 py-3 fw-bold text-uppercase">Employee</th>
                                        <th class="py-3 fw-bold text-uppercase text-center">Attendance</th>
                                        <th class="py-3 fw-bold text-uppercase">Base Salary</th>
                                        <th class="py-3 fw-bold text-uppercase">Advance</th>
                                        <th class="py-3 fw-bold text-uppercase">Net Payable</th>
                                        <th class="text-end pe-4 py-3 fw-bold text-uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                        @php
                                            $presentCount = $employee->attendances->where('status', 'present')->count();
                                            $absentCount = $employee->attendances->where('status', 'absent')->count();
                                            $totalAdvance = $employee->advances->sum('amount');
                                            $totalSalary = $employee->current_salary;
                                            $netPayable = $totalSalary - $totalAdvance;
                                        @endphp
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    @if($employee->photo)
                                                        <img src="{{ asset($employee->photo) }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle"><i class="bi bi-person text-primary"></i></div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0 fw-bold small text-dark">{{ $employee->name }}</h6>
                                                        <span class="text-muted" style="font-size: 10px;">{{ $employee->phone }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 me-1" style="font-size: 9px;">P: {{ $presentCount }}</span>
                                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2" style="font-size: 9px;">A: {{ $absentCount }}</span>
                                            </td>
                                            <td><span class="fw-bold text-dark small">৳{{ number_format($totalSalary, 0) }}</span></td>
                                            <td><span class="fw-bold text-danger small">৳{{ number_format($totalAdvance, 0) }}</span></td>
                                            <td><span class="fw-bold text-primary small">৳{{ number_format($netPayable, 0) }}</span></td>
                                            <td class="text-end pe-4">
                                                <button class="btn btn-sm btn-info text-white rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#advanceModal{{ $employee->id }}" style="font-size: 11px;">
                                                    <i class="bi bi-plus-circle me-1"></i> Add Advance
                                                </button>
                                                
                                                <form action="{{ route('manager.hr.salary.pay') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                                    <input type="hidden" name="month" value="{{ $month }}">
                                                    <input type="hidden" name="base_salary" value="{{ $totalSalary }}">
                                                    <input type="hidden" name="present_days" value="{{ $presentCount }}">
                                                    <input type="hidden" name="absent_days" value="{{ $absentCount }}">
                                                    <input type="hidden" name="advances" value="{{ $totalAdvance }}">
                                                    <input type="hidden" name="net_payable" value="{{ $netPayable }}">
                                                    
                                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3" onclick="return confirm('Record salary payment for {{ $employee->name }} for {{ $month }}?')" style="font-size: 11px; background: linear-gradient(135deg, #6366f1, #4f46e5); border: 0;">
                                                        <i class="bi bi-cash me-1"></i> Pay Now
                                                    </button>
                                                </form>

                                                <a href="{{ route('manager.hr.employees.show', $employee->id) }}" class="btn btn-sm btn-light rounded-pill px-3 border" style="font-size: 11px;">
                                                    <i class="bi bi-eye me-1"></i> Profile
                                                </a>
                                            </td>

                                        </tr>

                                        {{-- Advance Modal --}}
                                        <div class="modal fade" id="advanceModal{{ $employee->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 rounded-4 shadow-lg">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title fw-bold">Pay Advance to {{ $employee->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('manager.hr.salary.advance') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label small fw-bold">Advance Amount</label>
                                                                <div class="input-group shadow-sm rounded-3">
                                                                    <span class="input-group-text bg-white border-end-0">৳</span>
                                                                    <input type="number" name="amount" class="form-control border-start-0 py-2" placeholder="0.00" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label small fw-bold">Date</label>
                                                                <input type="date" name="date" class="form-control rounded-3 py-2" value="{{ date('Y-m-d') }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label small fw-bold">Note (Optional)</label>
                                                                <textarea name="note" class="form-control rounded-3" rows="2" placeholder="Reason for advance"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0">
                                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm border-0" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">Confirm Payment</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ── Tab 2: Advance History ── --}}
                    <div class="tab-pane fade" id="advanceTab">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-muted small">
                                    <tr>
                                        <th class="ps-4 py-3">Employee</th>
                                        <th class="py-3">Amount</th>
                                        <th class="py-3 text-center">Date</th>
                                        <th class="py-3">Month</th>
                                        <th class="py-3">Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allAdvances as $adv)
                                        <tr>
                                            <td class="ps-4 fw-bold text-dark small">{{ $adv->employee->name }}</td>
                                            <td><span class="text-danger fw-bold">৳{{ number_format($adv->amount, 0) }}</span></td>
                                            <td class="text-center small text-muted">{{ date('d M, Y', strtotime($adv->date)) }}</td>
                                            <td><span class="badge bg-light text-muted border rounded-pill px-2">{{ $adv->month }}</span></td>
                                            <td class="small text-muted">{{ $adv->note ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="p-3">{{ $allAdvances->links() }}</div>
                        </div>
                    </div>

                    {{-- ── Tab 3: Payment History ── --}}
                    <div class="tab-pane fade" id="paymentTab">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 text-center">
                                <thead class="bg-light text-muted small text-uppercase">
                                    <tr>
                                        <th class="text-start ps-4">Employee</th>
                                        <th>Month</th>
                                        <th>Net Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paidSalaries as $sal)
                                        <tr>
                                            <td class="text-start ps-4 fw-bold text-dark small">{{ $sal->employee->name }}</td>
                                            <td>{{ $sal->month }}</td>
                                            <td><span class="fw-bold text-success">৳{{ number_format($sal->net_payable, 0) }}</span></td>
                                            <td><span class="badge bg-success rounded-pill px-2" style="font-size: 10px;">Paid</span></td>
                                            <td class="small text-muted">{{ date('d M, Y', strtotime($sal->payment_date)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="p-3">{{ $paidSalaries->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1.25rem !important; }
    .nav-tabs .nav-link { color: #64748b; border-bottom: 2px solid transparent !important; transition: all 0.2s; }
    .nav-tabs .nav-link.active { color: #6366f1; border-bottom-color: #6366f1 !important; background: transparent; }
    .nav-tabs .nav-link:hover:not(.active) { color: #475569; background: #f8fafc; }
</style>
@endsection
