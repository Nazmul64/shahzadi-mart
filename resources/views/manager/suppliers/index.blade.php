@extends('manager.master')

@section('title', 'Suppliers')

@section('main-content')
<style>
:root {
    --pur-bg: #0f172a;
    --pur-card: #1e293b;
    --pur-border: rgba(255,255,255,0.07);
    --pur-accent: #3b82f6;
    --pur-accent2: #8b5cf6;
    --pur-green: #10b981;
    --pur-red: #ef4444;
    --pur-text: #94a3b8;
    --pur-heading: #f1f5f9;
}

.pm-wrap {
    padding: 28px 32px;
    min-height: 100vh;
    background: var(--pur-bg);
    font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
}

.pm-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
    flex-wrap: wrap;
    gap: 14px;
}

.pm-title {
    font-size: 24px;
    font-weight: 800;
    color: var(--pur-heading);
    display: flex;
    align-items: center;
    gap: 12px;
}

.pm-title i {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, var(--pur-accent), var(--pur-accent2));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #fff;
    box-shadow: 0 4px 16px rgba(59,130,246,0.35);
}

.pm-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
    cursor: pointer;
    border: none;
}

.pm-btn-primary {
    background: linear-gradient(135deg, var(--pur-accent), var(--pur-accent2));
    color: #fff;
    box-shadow: 0 4px 14px rgba(59,130,246,0.3);
}
.pm-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(59,130,246,0.45); color: #fff; }

.pm-btn-sm {
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 7px;
}

.pm-btn-info { background: rgba(59,130,246,0.15); color: var(--pur-accent); border: 1px solid rgba(59,130,246,0.25); }
.pm-btn-info:hover { background: var(--pur-accent); color: #fff; }

.pm-btn-warn { background: rgba(245,158,11,0.15); color: #f59e0b; border: 1px solid rgba(245,158,11,0.25); }
.pm-btn-warn:hover { background: #f59e0b; color: #fff; }

.pm-btn-danger { background: rgba(239,68,68,0.15); color: var(--pur-red); border: 1px solid rgba(239,68,68,0.25); }
.pm-btn-danger:hover { background: var(--pur-red); color: #fff; }

.pm-card {
    background: var(--pur-card);
    border: 1px solid var(--pur-border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.2);
}

.pm-table {
    width: 100%;
    border-collapse: collapse;
}

.pm-table thead th {
    background: rgba(0,0,0,0.3);
    padding: 14px 18px;
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .8px;
    border-bottom: 1px solid var(--pur-border);
    text-align: left;
}

.pm-table tbody tr {
    border-bottom: 1px solid var(--pur-border);
    transition: background .2s;
}
.pm-table tbody tr:hover { background: rgba(255,255,255,0.02); }
.pm-table tbody tr:last-child { border-bottom: none; }

.pm-table td {
    padding: 14px 18px;
    font-size: 14px;
    color: var(--pur-text);
    vertical-align: middle;
}

.pm-table td strong { color: var(--pur-heading); font-weight: 600; }

.badge-active {
    background: rgba(16,185,129,0.15);
    color: var(--pur-green);
    border: 1px solid rgba(16,185,129,0.3);
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.badge-inactive {
    background: rgba(239,68,68,0.15);
    color: var(--pur-red);
    border: 1px solid rgba(239,68,68,0.3);
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.pm-empty {
    text-align: center;
    padding: 60px 20px;
    color: var(--pur-text);
}
.pm-empty i { font-size: 48px; opacity: .3; display: block; margin-bottom: 14px; }

.pm-alert {
    padding: 14px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 14px;
    font-weight: 500;
}
.pm-alert-success { background: rgba(16,185,129,0.12); color: var(--pur-green); border: 1px solid rgba(16,185,129,0.25); }
</style>

<div class="pm-wrap">
    <div class="pm-top">
        <div class="pm-title">
            <i class="bi bi-person-badge-fill"></i>
            Suppliers
        </div>
        <a href="{{ route('manager.suppliers.create') }}" class="pm-btn pm-btn-primary">
            <i class="bi bi-plus-lg"></i> Add Supplier
        </a>
    </div>

    @if(session('success'))
    <div class="pm-alert pm-alert-success"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif

    <div class="pm-card">
        <table class="pm-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $supplier->name }}</strong></td>
                    <td>{{ $supplier->company_name ?? '—' }}</td>
                    <td>{{ $supplier->phone ?? '—' }}</td>
                    <td>{{ $supplier->email ?? '—' }}</td>
                    <td>
                        <button onclick="toggleStatus({{ $supplier->id }}, this)"
                            class="{{ $supplier->status ? 'badge-active' : 'badge-inactive' }}"
                            style="border:none;cursor:pointer;">
                            {{ $supplier->status ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="pm-btn pm-btn-sm pm-btn-warn">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST"
                                onsubmit="return confirm('Delete this supplier?')">
                                @csrf @method('DELETE')
                                <button class="pm-btn pm-btn-sm pm-btn-danger" type="submit">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="pm-empty">
                            <i class="bi bi-person-badge"></i>
                            No suppliers found. <a href="{{ route('manager.suppliers.create') }}" style="color:var(--pur-accent)">Add one now.</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $suppliers->links() }}
    </div>
</div>

<script>
function toggleStatus(id, btn) {
    fetch(`/admin/suppliers/${id}/toggle-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            if (btn.classList.contains('badge-active')) {
                btn.classList.replace('badge-active', 'badge-inactive');
                btn.textContent = 'Inactive';
            } else {
                btn.classList.replace('badge-inactive', 'badge-active');
                btn.textContent = 'Active';
            }
        }
    });
}
</script>
@endsection
