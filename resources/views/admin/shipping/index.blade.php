@extends('admin.master')

@section('main-content')
<style>
    :root {
        --primary: #6c5ce7;
        --primary-light: #f0eeff;
        --success: #00b894;
        --danger: #e8192c;
        --dark: #1a1a2e;
        --text: #374151;
        --muted: #9ca3af;
        --border: #e5e7eb;
        --bg: #f8f9fb;
        --card: #ffffff;
    }

    .page-wrapper { padding: 24px; background: var(--bg); min-height: 100vh; }

    /* ── Top Bar ── */
    .top-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }
    .page-title i { color: var(--primary); }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--primary);
        color: #fff;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: background .2s, transform .15s;
    }
    .btn-add:hover { background: #5a4bd1; color: #fff; transform: scale(1.02); }

    /* ── Flash ── */
    .flash-msg {
        border-radius: 10px;
        padding: 13px 18px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 18px;
    }
    .flash-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .flash-error   { background: #fff0f1; color: var(--danger); border: 1px solid #fecdd3; }

    /* ── Search Bar ── */
    .search-card {
        background: var(--card);
        border-radius: 14px;
        border: 1.5px solid var(--border);
        padding: 18px 22px;
        margin-bottom: 20px;
    }
    .search-row {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }
    .search-input-wrap {
        flex: 1;
        min-width: 200px;
        position: relative;
    }
    .search-input-wrap i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: 14px;
    }
    .search-input {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        padding: 10px 14px 10px 38px;
        font-size: 14px;
        outline: none;
        transition: border .2s;
        background: var(--bg);
    }
    .search-input:focus { border-color: var(--primary); background: #fff; }

    .filter-select {
        border: 1.5px solid var(--border);
        border-radius: 9px;
        padding: 10px 14px;
        font-size: 14px;
        outline: none;
        background: var(--bg);
        color: var(--text);
        cursor: pointer;
        transition: border .2s;
        min-width: 140px;
    }
    .filter-select:focus { border-color: var(--primary); }

    .btn-search {
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background .2s;
    }
    .btn-search:hover { background: #5a4bd1; }

    .btn-reset {
        background: var(--bg);
        color: var(--muted);
        border: 1.5px solid var(--border);
        padding: 10px 16px;
        border-radius: 9px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all .2s;
    }
    .btn-reset:hover { border-color: var(--danger); color: var(--danger); }

    /* ── Table ── */
    .table-card {
        background: var(--card);
        border-radius: 14px;
        border: 1.5px solid var(--border);
        overflow: hidden;
    }
    .table-head-bar {
        padding: 16px 22px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .table-head-bar span {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .table-head-bar span i { color: var(--primary); }
    .result-count {
        font-size: 12px;
        color: var(--muted);
        background: var(--bg);
        padding: 4px 10px;
        border-radius: 20px;
        border: 1px solid var(--border);
    }

    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f9fafb;
        padding: 13px 18px;
        font-size: 12px;
        font-weight: 700;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .6px;
        text-align: left;
        border-bottom: 1.5px solid var(--border);
    }
    tbody tr { transition: background .15s; }
    tbody tr:hover { background: #fafafa; }
    tbody td {
        padding: 14px 18px;
        font-size: 14px;
        color: var(--text);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }

    .td-serial {
        width: 50px;
        color: var(--muted);
        font-size: 13px;
        font-weight: 600;
    }
    .td-area { font-weight: 600; color: var(--dark); }
    .td-amount { font-weight: 700; color: var(--primary); font-size: 15px; }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }
    .badge-active   { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .badge-inactive { background: #fff0f1; color: var(--danger); border: 1px solid #fecdd3; }

    /* Action Buttons */
    .action-wrap { display: flex; gap: 6px; align-items: center; }
    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1.5px solid;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        text-decoration: none;
        transition: all .2s;
    }
    .btn-edit   { border-color: #bfdbfe; color: #3b82f6; background: #eff6ff; }
    .btn-edit:hover { background: #3b82f6; color: #fff; border-color: #3b82f6; }
    .btn-toggle-on  { border-color: #bbf7d0; color: #16a34a; background: #f0fdf4; }
    .btn-toggle-on:hover  { background: #16a34a; color: #fff; border-color: #16a34a; }
    .btn-toggle-off { border-color: #fde68a; color: #d97706; background: #fffbeb; }
    .btn-toggle-off:hover { background: #d97706; color: #fff; border-color: #d97706; }
    .btn-delete { border-color: #fecdd3; color: var(--danger); background: #fff0f1; }
    .btn-delete:hover { background: var(--danger); color: #fff; border-color: var(--danger); }

    /* Empty */
    .empty-row td {
        text-align: center;
        padding: 60px 20px;
        color: var(--muted);
    }
    .empty-row .empty-icon { font-size: 48px; margin-bottom: 10px; display: block; }

    /* Pagination */
    .pagination-wrap {
        padding: 16px 22px;
        border-top: 1px solid var(--border);
    }
    .pagination-wrap .pagination { margin: 0; justify-content: center; }
</style>

<div class="page-wrapper">

    {{-- Top Bar --}}
    <div class="top-bar">
        <h1 class="page-title">
            <i class="bi bi-truck"></i> শিপিং চার্জ ম্যানেজমেন্ট
        </h1>
        <a href="{{ route('admin.shipping.create') }}" class="btn-add">
            <i class="bi bi-plus-circle-fill"></i> নতুন শিপিং চার্জ
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="flash-msg flash-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash-msg flash-error"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
    @endif

    {{-- Search Form --}}
    <div class="search-card">
        <form action="{{ route('admin.shipping.index') }}" method="GET">
            <div class="search-row">
                <div class="search-input-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text"
                           name="search"
                           class="search-input"
                           placeholder="এলাকার নাম দিয়ে খুঁজুন..."
                           value="{{ request('search') }}">
                </div>
                <select name="status" class="filter-select">
                    <option value="">সব স্ট্যাটাস</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>সক্রিয়</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                </select>
                <button type="submit" class="btn-search">
                    <i class="bi bi-search"></i> খুঁজুন
                </button>
                <a href="{{ route('admin.shipping.index') }}" class="btn-reset">
                    <i class="bi bi-x-circle"></i> রিসেট
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-head-bar">
            <span><i class="bi bi-list-ul"></i> শিপিং চার্জ তালিকা</span>
            <span class="result-count">মোট: {{ $shippingCharges->total() }} টি</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>এলাকার নাম</th>
                    <th>চার্জ (৳)</th>
                    <th>স্ট্যাটাস</th>
                    <th>তারিখ</th>
                    <th style="text-align:center">একশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shippingCharges as $index => $shipping)
                <tr>
                    <td class="td-serial">{{ $shippingCharges->firstItem() + $index }}</td>
                    <td class="td-area">
                        <i class="bi bi-geo-alt-fill" style="color:var(--primary); margin-right:6px"></i>
                        {{ $shipping->area_name }}
                    </td>
                    <td class="td-amount">৳ {{ number_format($shipping->amount, 2) }}</td>
                    <td>
                        @if($shipping->status === 'active')
                            <span class="status-badge badge-active">
                                <i class="bi bi-circle-fill" style="font-size:7px"></i> সক্রিয়
                            </span>
                        @else
                            <span class="status-badge badge-inactive">
                                <i class="bi bi-circle-fill" style="font-size:7px"></i> নিষ্ক্রিয়
                            </span>
                        @endif
                    </td>
                    <td style="color:var(--muted); font-size:13px">
                        {{ $shipping->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div class="action-wrap" style="justify-content:center">
                            {{-- Edit --}}
                            <a href="{{ route('admin.shipping.edit', $shipping->id) }}"
                               class="btn-action btn-edit" title="সম্পাদনা">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            {{-- Toggle Status --}}
                            <form action="{{ route('admin.shipping.toggle-status', $shipping->id) }}"
                                  method="POST" style="display:inline">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="btn-action {{ $shipping->status === 'active' ? 'btn-toggle-on' : 'btn-toggle-off' }}"
                                        title="{{ $shipping->status === 'active' ? 'নিষ্ক্রিয় করুন' : 'সক্রিয় করুন' }}">
                                    <i class="bi bi-{{ $shipping->status === 'active' ? 'toggle-on' : 'toggle-off' }}"></i>
                                </button>
                            </form>

                            {{-- Delete --}}
                            <form action="{{ route('admin.shipping.destroy', $shipping->id) }}"
                                  method="POST" style="display:inline"
                                  onsubmit="return confirm('নিশ্চিতভাবে মুছে ফেলবেন?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="মুছুন">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="6">
                        <span class="empty-icon">🚚</span>
                        কোনো শিপিং চার্জ পাওয়া যায়নি।
                        <br>
                        <a href="{{ route('admin.shipping.create') }}" style="color:var(--primary); font-weight:600; text-decoration:none; margin-top:10px; display:inline-block">
                            + নতুন শিপিং চার্জ যোগ করুন
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($shippingCharges->hasPages())
        <div class="pagination-wrap">
            {{ $shippingCharges->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
