@extends('admin.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    <div class="container-fluid px-lg-4">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Attendance Management</h4>
                <p class="text-muted small mb-0">Track daily attendance and view monthly reports for <strong>{{ date('F Y', strtotime($month)) }}</strong></p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <input type="month" id="attendance_month" class="form-control rounded-pill border-0 shadow-sm px-3" 
                       value="{{ $month }}" onchange="window.location.href='?month=' + this.value">
            </div>
        </div>

        {{-- Tabs --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white border-0 p-0">
                <ul class="nav nav-tabs nav-fill border-0" id="attendanceTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active py-3 fw-bold border-0 rounded-0" data-bs-toggle="tab" href="#markTab">
                            <i class="bi bi-calendar-check me-2"></i> Mark Attendance
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-3 fw-bold border-0 rounded-0" data-bs-toggle="tab" href="#reportTab">
                            <i class="bi bi-bar-chart-line me-2"></i> Monthly Report
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="tab-content">
                    {{-- ── Tab 1: Mark Attendance (The Grid) ── --}}
                    <div class="tab-pane fade show active" id="markTab">
                        <form action="{{ route('manager.hr.attendance.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="month" value="{{ $month }}">
                            
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0 text-center" style="min-width: 1400px;">
                                    <thead class="bg-light sticky-top" style="z-index: 10;">
                                        <tr class="small">
                                            <th class="ps-4 text-start bg-light sticky-left" style="width: 250px; position: sticky; left: 0; z-index: 11;">Employee Name</th>
                                            @for($i = 1; $i <= $daysInMonth; $i++)
                                                <th class="py-3" style="width: 45px;">{{ $i }}<br><small class="text-muted opacity-50">{{ date('D', strtotime($month . '-' . $i)) }}</small></th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $employee)
                                            @php $empAtt = $groupedAttendances[$employee->id] ?? collect(); @endphp
                                            <tr>
                                                <td class="ps-4 text-start bg-white sticky-left" style="position: sticky; left: 0; z-index: 9;">
                                                    <h6 class="mb-0 fw-bold small text-dark">{{ $employee->name }}</h6>
                                                    <span class="text-muted" style="font-size: 9px;">{{ $employee->phone }}</span>
                                                </td>
                                                @for($i = 1; $i <= $daysInMonth; $i++)
                                                    @php 
                                                        $date = $month . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                                                        $att = $empAtt->firstWhere('date', $date);
                                                        $status = $att ? $att->status : null;
                                                    @endphp
                                                    <td class="p-1">
                                                        <div class="d-flex flex-column gap-1 align-items-center justify-content-center">
                                                            <input class="form-check-input att-check present-check m-0" type="radio" name="attendance[{{ $employee->id }}][{{ $i }}]" value="present" style="width: 14px; height: 14px;" {{ $status == 'present' ? 'checked' : '' }}>
                                                            <input class="form-check-input att-check absent-check m-0" type="radio" name="attendance[{{ $employee->id }}][{{ $i }}]" value="absent" style="width: 14px; height: 14px;" {{ $status == 'absent' ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                @endfor
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-4 border-top text-end bg-white">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm border-0" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">Save Monthly Grid</button>
                            </div>
                        </form>
                    </div>

                    {{-- ── Tab 2: Monthly Report ── --}}
                    <div class="tab-pane fade" id="reportTab">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 text-center">
                                <thead class="bg-light text-muted small text-uppercase">
                                    <tr>
                                        <th class="text-start ps-4 py-3">Employee Name</th>
                                        <th>Total Days</th>
                                        <th>Present</th>
                                        <th>Absent</th>
                                        <th>Late</th>
                                        <th>Leave</th>
                                        <th>Attendance %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                        @php
                                            $empAtt = $groupedAttendances[$employee->id] ?? collect();
                                            $present = $empAtt->where('status', 'present')->count();
                                            $absent = $empAtt->where('status', 'absent')->count();
                                            $late = $empAtt->where('status', 'late')->count();
                                            $totalMarked = $present + $absent + $late;
                                            $percentage = $totalMarked > 0 ? round(($present / $totalMarked) * 100) : 0;
                                        @endphp
                                        <tr>
                                            <td class="text-start ps-4 fw-bold text-dark small">{{ $employee->name }}</td>
                                            <td><span class="badge bg-light text-dark border rounded-pill px-2">{{ $totalMarked }}</span></td>
                                            <td><span class="text-success fw-bold">{{ $present }}</span></td>
                                            <td><span class="text-danger fw-bold">{{ $absent }}</span></td>
                                            <td><span class="text-warning fw-bold">{{ $late }}</span></td>
                                            <td><span class="text-muted">0</span></td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                                                        <div class="progress-bar {{ $percentage > 80 ? 'bg-success' : ($percentage > 50 ? 'bg-warning' : 'bg-danger') }}" style="width: {{ $percentage }}%"></div>
                                                    </div>
                                                    <span class="small fw-bold">{{ $percentage }}%</span>
                                                </div>
                                            </td>
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

<style>
    .rounded-4 { border-radius: 1.25rem !important; }
    .nav-tabs .nav-link { color: #64748b; border-bottom: 2px solid transparent !important; transition: all 0.2s; }
    .nav-tabs .nav-link.active { color: #6366f1; border-bottom-color: #6366f1 !important; background: transparent; }
    .nav-tabs .nav-link:hover:not(.active) { color: #475569; background: #f8fafc; }
    .sticky-left { border-right: 2px solid #f1f5f9 !important; }
    .present-check:checked { background-color: #10b981 !important; border-color: #10b981 !important; }
    .absent-check:checked { background-color: #ef4444 !important; border-color: #ef4444 !important; }
</style>
@endsection
