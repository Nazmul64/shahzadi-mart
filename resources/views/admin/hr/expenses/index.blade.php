@extends('admin.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    <div class="container-fluid px-lg-5">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Company Expenses</h4>
                <p class="text-muted small mb-0">Track and manage your daily business costs</p>
            </div>
            <button class="btn btn-primary rounded-pill px-4 shadow-sm border-0" style="background: linear-gradient(135deg, #f59e0b, #d97706);" data-bs-toggle="modal" data-bs-target="#expenseModal">
                <i class="bi bi-plus-circle me-2"></i> Add New Expense
            </button>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr class="text-muted small">
                                        <th class="ps-4 py-3 fw-bold text-uppercase">Category</th>
                                        <th class="py-3 fw-bold text-uppercase">Amount</th>
                                        <th class="py-3 fw-bold text-uppercase text-center">Date</th>
                                        <th class="py-3 fw-bold text-uppercase">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($expenses as $expense)
                                        <tr>
                                            <td class="ps-4">
                                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1" style="font-size: 11px;">{{ $expense->category }}</span>
                                            </td>
                                            <td><span class="fw-bold text-dark">৳{{ number_format($expense->amount, 0) }}</span></td>
                                            <td class="text-center text-muted small">{{ date('d M, Y', strtotime($expense->date)) }}</td>
                                            <td class="text-muted small">{{ $expense->description }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <i class="bi bi-receipt display-4 text-muted opacity-25"></i>
                                                <p class="text-muted mt-2">No expenses recorded yet</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-body p-4 text-center">
                        <h6 class="text-muted small fw-bold text-uppercase mb-3">Total This Month</h6>
                        @php
                            $thisMonthTotal = $expenses->whereBetween('date', [date('Y-m-01'), date('Y-m-t')])->sum('amount');
                        @endphp
                        <h2 class="fw-bold text-warning mb-0">৳{{ number_format($thisMonthTotal, 0) }}</h2>
                        <hr class="my-4 opacity-50">
                        <div class="small text-muted">Based on recorded expenses for {{ date('F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Expense Modal --}}
<div class="modal fade" id="expenseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Company Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('manager.hr.expenses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Expense Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select rounded-3 py-2" required>
                            <option value="Office Rent">Office Rent</option>
                            <option value="Electricity Bill">Electricity Bill</option>
                            <option value="Internet Bill">Internet Bill</option>
                            <option value="Snacks & Tea">Snacks & Tea</option>
                            <option value="Transportation">Transportation</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Amount <span class="text-danger">*</span></label>
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
                        <label class="form-label small fw-bold">Description (Optional)</label>
                        <textarea name="description" class="form-control rounded-3" rows="3" placeholder="Short detail about this expense"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-white rounded-pill px-4 shadow-sm border-0">Add Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1.25rem !important; }
</style>
@endsection
