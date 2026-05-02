@extends('emplee.master')
@section('title', 'Purchase Return List')
@section('main-content')
<style>
body{background:#f5f7fa;}
.pur-wrap{padding:24px 28px;min-height:100vh;background:#f5f7fa;font-family:'Segoe UI',sans-serif;}
.pur-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;}
.pur-page-title{font-size:20px;font-weight:700;color:#111827;}
.pur-btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:7px;font-size:13px;font-weight:600;cursor:pointer;border:none;transition:all .2s;text-decoration:none;}
.pur-btn-pink{background:#e91e8c;color:#fff;}
.pur-btn-pink:hover{background:#c4176f;color:#fff;}
.pur-btn-sm{padding:5px 11px;font-size:12px;border-radius:5px;}
.pur-btn-approve{background:#d1fae5;color:#065f46;border:1px solid #a7f3d0;}
.pur-btn-approve:hover{background:#10b981;color:#fff;}
.pur-btn-reject{background:#fee2e2;color:#ef4444;border:1px solid #fecaca;}
.pur-btn-reject:hover{background:#ef4444;color:#fff;}
.pur-btn-danger{background:#fee2e2;color:#ef4444;border:1px solid #fecaca;}
.pur-btn-danger:hover{background:#ef4444;color:#fff;}
.pur-card{background:#fff;border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.06);}
table.pur-table{width:100%;border-collapse:collapse;}
table.pur-table th{background:#f9fafb;padding:12px 16px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#6b7280;border-bottom:2px solid #e5e7eb;text-align:left;}
table.pur-table td{padding:13px 16px;font-size:14px;color:#374151;border-bottom:1px solid #f3f4f6;vertical-align:middle;}
table.pur-table tr:last-child td{border-bottom:none;}
table.pur-table tr:hover td{background:#fafafa;}
.badge{padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;}
.badge-pending{background:#fef3c7;color:#92400e;}
.badge-approved{background:#d1fae5;color:#065f46;}
.badge-rejected{background:#fee2e2;color:#991b1b;}
.pur-alert{padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;font-weight:500;}
.pur-alert-success{background:#d1fae5;color:#065f46;border:1px solid #a7f3d0;}
.no-data{text-align:center;padding:50px;color:#9ca3af;font-size:14px;}
</style>

<div class="pur-wrap">
    <div class="pur-top">
        <div class="pur-page-title">Purchase Return List</div>
        <a href="{{ route('emplee.purchase-returns.create') }}" class="pur-btn pur-btn-pink">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
            Return Create
        </a>
    </div>

    @if(session('success'))
    <div class="pur-alert pur-alert-success">{{ session('success') }}</div>
    @endif

    <div class="pur-card">
        <table class="pur-table">
            <thead>
                <tr>
                    <th>SL.</th>
                    <th>Supplier</th>
                    <th>Purchase Invoice</th>
                    <th>Amount</th>
                    <th>Total Product</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $return)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $return->supplier->name ?? '—' }}</td>
                    <td>{{ $return->purchase->purchase_number ?? '—' }}</td>
                    <td>৳{{ number_format($return->amount, 2) }}</td>
                    <td>{{ $return->total_product }}</td>
                    <td>
                        @if($return->status === 'approved')
                            <span class="badge badge-approved">Approved</span>
                        @elseif($return->status === 'rejected')
                            <span class="badge badge-rejected">Rejected</span>
                        @else
                            <span class="badge badge-pending">Pending</span>
                        @endif
                    </td>
                    <td>{{ $return->created_at->format('m/d/Y') }}</td>
                    <td>
                        <div style="display:flex;gap:5px;flex-wrap:wrap;">
                            @if($return->status === 'pending')
                            <form action="{{ route('admin.purchase-returns.approve', $return->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="pur-btn pur-btn-sm pur-btn-approve">Approve</button>
                            </form>
                            <form action="{{ route('admin.purchase-returns.reject', $return->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="pur-btn pur-btn-sm pur-btn-reject">Reject</button>
                            </form>
                            @endif
                            <form action="{{ route('admin.purchase-returns.destroy', $return->id) }}" method="POST"
                                onsubmit="return confirm('Delete this return?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="pur-btn pur-btn-sm pur-btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8"><div class="no-data">No Data Found</div></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;">{{ $returns->links() }}</div>
</div>
@endsection
