@extends('emplee.master')

@section('content')

<style>
.cp-root { background: #f8fafc; min-height: 100vh; padding: 24px; }
.cp-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
.cp-header h2 { font-size: 20px; font-weight: 800; color: #1e293b; }
.btn-add { background: #3b82f6; color: #fff; padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none; }

.cp-card { background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
.table th { background: #f8fafc; font-size: 12px; text-transform: uppercase; color: #64748b; padding: 12px 16px; }
.table td { padding: 16px; vertical-align: middle; font-size: 14px; }

.code-badge { background: #eff6ff; color: #1e40af; padding: 4px 8px; border-radius: 6px; font-family: monospace; font-weight: 700; }
</style>

<div class="cp-root">
    <div class="cp-header" style="margin-top: 20px;">
        <h2>Employee - Coupon List</h2>
        <a href="{{ route('emplee.coupon.create') }}" class="btn-add">+ New Coupon</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="cp-card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Coupon Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Valid Until</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                    <tr>
                        <td><span class="code-badge">{{ $coupon->code }}</span></td>
                        <td>{{ $coupon->type === 'discount_by_percentage' ? 'Percentage' : 'Amount' }}</td>
                        <td><strong>{{ $coupon->type === 'discount_by_percentage' ? $coupon->percentage.'%' : '৳'.$coupon->amount }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($coupon->end_date)->format('d M Y') }}</td>
                        <td>
                            <span class="badge {{ $coupon->status === 'activated' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($coupon->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('emplee.coupon.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Remove coupon?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
