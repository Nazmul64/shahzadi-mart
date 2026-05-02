@extends('manager.master')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
.cp-root { font-family: 'Plus Jakarta Sans', sans-serif; background: #f4f6fb; min-height: 100vh; padding: 20px; color: #1a2340; }
.cp-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.cp-header h1 { font-size:1.4rem; font-weight:800; color:#059669; margin:0; }
.cp-add-btn { background:#059669; color:#fff !important; border-radius:10px; padding:10px 20px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }

.cp-card { background:#fff; border-radius:14px; border:1px solid #e8edf8; box-shadow:0 2px 12px rgba(0,0,0,0.05); overflow:hidden; }
table.cp-table { width:100%; border-collapse:collapse; }
.cp-table thead tr { background:#f8faff; border-bottom:2px solid #edf0fb; }
.cp-table th { padding:12px 18px; text-align:left; font-weight:700; font-size:0.75rem; color:#5a6a85; text-transform:uppercase; }
.cp-table td { padding:14px 18px; color:#2c3a5a; font-weight:500; border-bottom:1px solid #f3f5fb; }

.cp-code-chip { background:#dcfce7; color:#065f46; border:1px solid #b9f6ca; border-radius:7px; padding:4px 10px; font-size:0.82rem; font-weight:700; font-family:monospace; }
.cp-status-badge { padding:4px 12px; border-radius:20px; font-size:0.75rem; font-weight:700; color:#fff; }
.status-active { background:#10b981; }
.status-inactive { background:#ef4444; }

.btn-action { width:32px; height:32px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; border:1.5px solid #e2e8f0; color:#64748b; text-decoration:none; transition:all 0.2s; }
.btn-action:hover { background:#f1f5f9; color:#059669; border-color:#059669; }
</style>

<div class="cp-root">
    <div class="cp-header">
        <h1><i class="bi bi-ticket-perforated me-2"></i>Coupon Management</h1>
        <a href="{{ route('manager.coupon.create') }}" class="cp-add-btn">+ New Coupon</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="cp-card">
        <div class="table-responsive">
            <table class="cp-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Validity</th>
                        <th>Used</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                    <tr>
                        <td><span class="cp-code-chip">{{ $coupon->code }}</span></td>
                        <td>{{ $coupon->type === 'discount_by_percentage' ? 'Percentage' : 'Fixed Amount' }}</td>
                        <td><strong>{{ $coupon->type === 'discount_by_percentage' ? $coupon->percentage.'%' : '৳'.$coupon->amount }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($coupon->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($coupon->end_date)->format('d M Y') }}</td>
                        <td>{{ $coupon->used ?? 0 }}</td>
                        <td>
                            <span class="cp-status-badge {{ $coupon->status === 'activated' ? 'status-active' : 'status-inactive' }}">
                                {{ ucfirst($coupon->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn-action" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('manager.coupon.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Delete coupon?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action" style="color:#ef4444;"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
