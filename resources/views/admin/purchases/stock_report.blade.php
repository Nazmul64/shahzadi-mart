@extends('admin.master')
@section('title', 'Stock Report')
@section('main-content')
<style>
.pur-wrap { padding: 18px 22px; min-height: 100vh; background: #f5f7fa; font-family: 'Segoe UI', Arial, sans-serif; }

/* ── Filter bar ─────────────────────────────────────── */
.filter-bar {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.filter-bar select,
.filter-bar input[type="date"] {
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 13px;
    color: #374151;
    background: #fff;
    outline: none;
    height: 38px;
    font-family: inherit;
}
.filter-bar select:focus,
.filter-bar input:focus { border-color: #e91e8c; }
.filter-bar select { flex: 1; min-width: 0; }
.filter-bar input[type="date"] { width: 160px; color: #9ca3af; }
.fb-btn {
    height: 38px;
    padding: 0 16px;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all .2s;
    white-space: nowrap;
    text-decoration: none;
}
.fb-btn-filter { background: #e91e8c; color: #fff; }
.fb-btn-filter:hover { background: #c4176f; }
.fb-btn-reset  { background: #374151; color: #fff; width: 38px; padding: 0; justify-content: center; }
.fb-btn-reset:hover  { background: #1f2937; }
.fb-btn-print  { background: #ef4444; color: #fff; width: 38px; padding: 0; justify-content: center; }
.fb-btn-print:hover  { background: #dc2626; }

/* ── Table ──────────────────────────────────────────── */
.pur-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
table.sr-table { width: 100%; border-collapse: collapse; }

/* first header row */
table.sr-table thead tr.hd1 th {
    background: #fff;
    padding: 12px 16px;
    border-bottom: 1px solid #e5e7eb;
}
table.sr-table thead tr.hd1 th.label-th {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #6b7280;
    text-align: left;
}
table.sr-table thead tr.hd1 th.group-th {
    background: #f1f5f9;
    text-align: center;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    border-left: 2px solid #e2e8f0;
    letter-spacing: .3px;
}

/* second header row */
table.sr-table thead tr.hd2 th {
    background: #f9fafb;
    padding: 9px 16px;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #6b7280;
    border-bottom: 2px solid #e5e7eb;
    text-align: center;
}
table.sr-table thead tr.hd2 th.left { text-align: left; }

/* body */
table.sr-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background .15s; }
table.sr-table tbody tr:last-child { border-bottom: none; }
table.sr-table tbody tr:hover td { background: #fafafa; }
table.sr-table td {
    padding: 12px 16px;
    font-size: 14px;
    color: #374151;
    vertical-align: middle;
}
table.sr-table td.center { text-align: center; }
table.sr-table td.sn { font-weight: 700; color: #111827; text-align: left; }
table.sr-table td.prod-name a { color: #2563eb; text-decoration: none; font-weight: 500; }
table.sr-table td.prod-name a:hover { text-decoration: underline; }

@media print {
    .filter-bar { display: none !important; }
    .pur-wrap { padding: 0; background: #fff; }
}
</style>

<div class="pur-wrap">

    {{-- Filter Bar --}}
    <form class="filter-bar" method="GET" action="{{ route('admin.purchases.report') }}">

        {{-- Product dropdown --}}
        <select name="product_id">
            <option value="">All Products</option>
            @foreach($allProducts as $p)
            <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>
                {{ $p->name }}
            </option>
            @endforeach
        </select>

        {{-- Date filter --}}
        <input type="date" name="filter_date"
            value="{{ request('filter_date') }}"
            placeholder="Filter by date">

        {{-- Filter button --}}
        <button type="submit" class="fb-btn fb-btn-filter">
            <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4 6h16M7 12h10M10 18h4"/>
                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M4 6h16M7 12h10M10 18h4" fill="none"/>
            </svg>
            Filter
        </button>

        {{-- Reset --}}
        <a href="{{ route('admin.purchases.report') }}" class="fb-btn fb-btn-reset" title="Reset">
            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
            </svg>
        </a>

        {{-- Print / PDF --}}
        <button type="button" class="fb-btn fb-btn-print" onclick="window.print()" title="Print / Save PDF">
            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
            </svg>
        </button>

    </form>

    {{-- Table --}}
    <div class="pur-card">
        <table class="sr-table">
            <thead>
                {{-- Row 1: SN | Product Name | ← Stock Details (spans 3) → --}}
                <tr class="hd1">
                    <th class="label-th" style="width:60px;">SN</th>
                    <th class="label-th">Product Name</th>
                    <th class="group-th" colspan="3" style="min-width:420px;">Stock Details</th>
                </tr>
                {{-- Row 2: sub-headers for grouped columns --}}
                <tr class="hd2">
                    <th class="left"></th>
                    <th class="left"></th>
                    <th>Purchased (In)</th>
                    <th>Sold (Out)</th>
                    <th>Available Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $i => $p)
                <tr>
                    <td class="sn">{{ $i + 1 }}</td>
                    <td class="prod-name">
                        <a href="#">{{ $p['name'] }}</a>
                    </td>
                    <td class="center">{{ number_format($p['purchased']) }}</td>
                    <td class="center">{{ number_format($p['sold']) }}</td>
                    <td class="center">{{ number_format($p['stock']) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:50px 20px;color:#9ca3af;">
                        No products found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
