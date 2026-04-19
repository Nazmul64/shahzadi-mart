@extends('admin.master')

@section('main-content')

<style>
/* ══════════════════════════════════════════
   ADMIN REVIEW MANAGEMENT — FULL STYLES
══════════════════════════════════════════ */
.rv-wrap * { box-sizing: border-box; margin: 0; padding: 0; }

.rv-wrap {
    padding: 24px;
    font-family: 'DM Sans', 'Segoe UI', sans-serif;
    background: #f5f6fa;
    min-height: 100vh;
}

/* Page header */
.rv-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}
.rv-page-title {
    font-size: 22px;
    font-weight: 800;
    color: #1a1a2e;
    display: flex;
    align-items: center;
    gap: 10px;
}
.rv-page-title i { color: #e8192c; }
.rv-page-subtitle {
    font-size: 13px;
    color: #888;
    font-weight: 400;
    margin-top: 3px;
}

/* Stats cards */
.rv-stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
.rv-stat {
    background: #fff;
    border-radius: 12px;
    padding: 18px 20px;
    border: 1px solid #e8eaf0;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    transition: transform .2s, box-shadow .2s;
}
.rv-stat:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,0,0,.08); }
.rv-stat-icon {
    width: 44px; height: 44px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.rv-stat-icon.total   { background: rgba(232,25,44,.1);  color: #e8192c; }
.rv-stat-icon.pending { background: rgba(245,158,11,.1); color: #f59e0b; }
.rv-stat-icon.approved{ background: rgba(34,197,94,.1);  color: #22c55e; }
.rv-stat-icon.rating  { background: rgba(59,130,246,.1); color: #3b82f6; }
.rv-stat-num  { font-size: 24px; font-weight: 800; color: #1a1a2e; line-height: 1; }
.rv-stat-lbl  { font-size: 12px; color: #888; font-weight: 500; margin-top: 3px; }

/* Filter / search bar */
.rv-filter-bar {
    background: #fff;
    border: 1px solid #e8eaf0;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.rv-search-wrap {
    flex: 1; min-width: 200px;
    position: relative;
}
.rv-search-wrap i {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: #aaa; font-size: 13px;
}
.rv-search-input {
    width: 100%; padding: 9px 12px 9px 34px;
    border: 1px solid #e8eaf0; border-radius: 8px;
    font-size: 13px; color: #333; outline: none;
    transition: border-color .2s;
    font-family: inherit;
}
.rv-search-input:focus { border-color: #e8192c; }
.rv-filter-select {
    padding: 9px 14px; border: 1px solid #e8eaf0; border-radius: 8px;
    font-size: 13px; color: #333; outline: none; cursor: pointer;
    background: #f9fafb; font-family: inherit; min-width: 130px;
}
.rv-filter-select:focus { border-color: #e8192c; }
.rv-bulk-btn {
    padding: 9px 18px; background: #e8192c; color: #fff; border: none;
    border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; gap: 6px;
    transition: background .2s, transform .2s; font-family: inherit;
}
.rv-bulk-btn:hover { background: #c8102e; transform: translateY(-1px); }
.rv-bulk-btn.outline {
    background: #fff; color: #e8192c;
    border: 1px solid #e8192c;
}
.rv-bulk-btn.outline:hover { background: rgba(232,25,44,.06); }

/* Alert */
.rv-alert {
    padding: 12px 18px; border-radius: 10px; margin-bottom: 18px;
    font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 10px;
}
.rv-alert.success { background: rgba(34,197,94,.1); border: 1px solid rgba(34,197,94,.3); color: #16a34a; }
.rv-alert.error   { background: rgba(232,25,44,.08); border: 1px solid rgba(232,25,44,.25); color: #e8192c; }

/* Review Table */
.rv-card {
    background: #fff;
    border: 1px solid #e8eaf0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    margin-bottom: 20px;
}
.rv-table-wrap { overflow-x: auto; }
.rv-table {
    width: 100%; border-collapse: collapse; font-size: 13px;
}
.rv-table th {
    padding: 13px 16px; text-align: left;
    font-size: 10px; font-weight: 700; color: #888;
    text-transform: uppercase; letter-spacing: .6px;
    background: #f9fafb; border-bottom: 1px solid #e8eaf0;
    white-space: nowrap;
}
.rv-table td {
    padding: 14px 16px; border-bottom: 1px solid #f0f2f5;
    vertical-align: middle;
}
.rv-table tr:last-child td { border-bottom: none; }
.rv-table tr:hover td { background: #fafbfc; }

/* Checkbox */
.rv-check {
    width: 16px; height: 16px; accent-color: #e8192c; cursor: pointer;
}

/* Product cell */
.rv-prod-cell { display: flex; align-items: center; gap: 10px; }
.rv-prod-img {
    width: 42px; height: 42px; border-radius: 8px; object-fit: cover;
    border: 1px solid #e8eaf0; flex-shrink: 0;
}
.rv-prod-name {
    font-size: 13px; font-weight: 600; color: #1a1a2e;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    max-width: 160px;
}
.rv-prod-cat { font-size: 11px; color: #aaa; margin-top: 2px; }

/* Reviewer cell */
.rv-user-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    background: linear-gradient(135deg, #e8192c, #8b0000);
    color: #fff; font-weight: 800; font-size: 13px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.rv-user-name  { font-weight: 600; color: #333; font-size: 13px; }
.rv-user-email { font-size: 11px; color: #aaa; margin-top: 2px; }

/* Stars */
.rv-stars { display: flex; gap: 2px; align-items: center; }
.rv-stars i { font-size: 13px; color: #f59e0b; }
.rv-stars i.empty { color: #ddd; }
.rv-stars-num { font-size: 12px; font-weight: 700; color: #555; margin-left: 5px; }

/* Review text */
.rv-review-text {
    font-size: 13px; color: #555; line-height: 1.55;
    max-width: 220px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    font-style: italic;
}
.rv-no-text { font-size: 12px; color: #bbb; font-style: italic; }

/* Status badge */
.rv-status {
    padding: 4px 12px; border-radius: 20px;
    font-size: 11px; font-weight: 700; white-space: nowrap;
    display: inline-flex; align-items: center; gap: 4px;
}
.rv-status.approved { background: rgba(34,197,94,.1); color: #16a34a; border: 1px solid rgba(34,197,94,.25); }
.rv-status.pending  { background: rgba(245,158,11,.1); color: #d97706; border: 1px solid rgba(245,158,11,.25); }

/* Action buttons */
.rv-actions { display: flex; gap: 6px; align-items: center; }
.rv-btn {
    padding: 6px 13px; border-radius: 7px; font-size: 12px;
    font-weight: 700; cursor: pointer; border: none;
    display: flex; align-items: center; gap: 5px;
    transition: all .2s; font-family: inherit; text-decoration: none;
    white-space: nowrap;
}
.rv-btn.approve { background: rgba(34,197,94,.1); color: #16a34a; border: 1px solid rgba(34,197,94,.25); }
.rv-btn.approve:hover { background: #22c55e; color: #fff; }
.rv-btn.unapprove { background: rgba(245,158,11,.1); color: #d97706; border: 1px solid rgba(245,158,11,.25); }
.rv-btn.unapprove:hover { background: #f59e0b; color: #fff; }
.rv-btn.delete  { background: rgba(232,25,44,.08); color: #e8192c; border: 1px solid rgba(232,25,44,.2); }
.rv-btn.delete:hover  { background: #e8192c; color: #fff; }

/* Date */
.rv-date { font-size: 12px; color: #aaa; white-space: nowrap; }

/* Empty state */
.rv-empty {
    text-align: center; padding: 60px 24px; color: #aaa;
}
.rv-empty i { font-size: 44px; color: #e0e0e0; display: block; margin-bottom: 14px; }
.rv-empty p { font-size: 14px; }

/* Pagination */
.rv-pagination-wrap {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px; border-top: 1px solid #f0f2f5;
    flex-wrap: wrap; gap: 10px;
}
.rv-page-info { font-size: 13px; color: #888; }
.rv-pages { display: flex; gap: 4px; }
.rv-pages a, .rv-pages span {
    display: flex; align-items: center; justify-content: center;
    width: 34px; height: 34px; border-radius: 8px;
    font-size: 13px; font-weight: 600; text-decoration: none;
    border: 1px solid #e8eaf0; color: #555; transition: all .2s;
}
.rv-pages a:hover { border-color: #e8192c; color: #e8192c; }
.rv-pages span.active { background: #e8192c; border-color: #e8192c; color: #fff; }

/* Modal */
.rv-modal-bg {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(0,0,0,.55); backdrop-filter: blur(4px);
    align-items: center; justify-content: center;
}
.rv-modal-bg.show { display: flex; }
.rv-modal-box {
    background: #fff; border-radius: 16px; padding: 30px 26px;
    max-width: 400px; width: 92%; text-align: center;
    animation: rvFadeUp .25s ease;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
}
@keyframes rvFadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
.rv-modal-icon  { font-size: 44px; color: #e8192c; margin-bottom: 14px; }
.rv-modal-title { font-size: 19px; font-weight: 800; color: #1a1a2e; margin-bottom: 8px; }
.rv-modal-desc  { font-size: 13px; color: #888; margin-bottom: 26px; line-height: 1.6; }
.rv-modal-actions { display: flex; gap: 10px; }
.rv-modal-confirm { flex:1; padding:12px; background:#e8192c; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; font-family:inherit; }
.rv-modal-cancel  { flex:1; padding:12px; background:#f5f6fa; color:#555; border:1px solid #e0e0e0; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; font-family:inherit; }

/* Full review modal */
.rv-full-modal {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(0,0,0,.55); backdrop-filter: blur(4px);
    align-items: center; justify-content: center;
}
.rv-full-modal.show { display: flex; }
.rv-full-box {
    background: #fff; border-radius: 16px; padding: 28px;
    max-width: 520px; width: 94%;
    animation: rvFadeUp .25s ease;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
}
.rv-full-box-head {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px; border-bottom: 1px solid #f0f2f5; padding-bottom: 14px;
}
.rv-full-box-title { font-size: 17px; font-weight: 800; color: #1a1a2e; }
.rv-close-btn {
    width: 32px; height: 32px; border-radius: 8px; border: 1px solid #e0e0e0;
    background: #f5f6fa; cursor: pointer; display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: #888; transition: all .2s;
}
.rv-close-btn:hover { border-color: #e8192c; color: #e8192c; }

/* Responsive */
@media (max-width: 1024px) { .rv-stats-row { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
    .rv-wrap { padding: 16px; }
    .rv-stats-row { grid-template-columns: repeat(2, 1fr); }
    .rv-filter-bar { flex-direction: column; align-items: stretch; }
    .rv-search-wrap { min-width: unset; }
}
@media (max-width: 480px) { .rv-stats-row { grid-template-columns: 1fr 1fr; } }
</style>

<div class="rv-wrap">

    {{-- ══ PAGE HEADER ══ --}}
    <div class="rv-header">
        <div>
            <div class="rv-page-title">
                <i class="fas fa-star"></i> Product Reviews
            </div>
            <div class="rv-page-subtitle">সকল customer রিভিউ এখানে manage করুন</div>
        </div>
    </div>

    {{-- ══ SESSION ALERTS ══ --}}
    @if(session('success'))
        <div class="rv-alert success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="rv-alert error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- ══ STATS ══ --}}
    @php
        $totalReviews    = \App\Models\Producreview::count();
        $pendingReviews  = \App\Models\Producreview::where('is_approved', false)->count();
        $approvedReviews = \App\Models\Producreview::where('is_approved', true)->count();
        $avgRating       = \App\Models\Producreview::where('is_approved', true)->avg('rating') ?? 0;
    @endphp
    <div class="rv-stats-row">
        <div class="rv-stat">
            <div class="rv-stat-icon total"><i class="fas fa-comments"></i></div>
            <div>
                <div class="rv-stat-num">{{ $totalReviews }}</div>
                <div class="rv-stat-lbl">মোট রিভিউ</div>
            </div>
        </div>
        <div class="rv-stat">
            <div class="rv-stat-icon pending"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div class="rv-stat-num" style="color:#d97706;">{{ $pendingReviews }}</div>
                <div class="rv-stat-lbl">অনুমোদন বাকি</div>
            </div>
        </div>
        <div class="rv-stat">
            <div class="rv-stat-icon approved"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="rv-stat-num" style="color:#16a34a;">{{ $approvedReviews }}</div>
                <div class="rv-stat-lbl">অনুমোদিত</div>
            </div>
        </div>
        <div class="rv-stat">
            <div class="rv-stat-icon rating"><i class="fas fa-star"></i></div>
            <div>
                <div class="rv-stat-num" style="color:#3b82f6;">{{ number_format($avgRating, 1) }}</div>
                <div class="rv-stat-lbl">গড় রেটিং</div>
            </div>
        </div>
    </div>

    {{-- ══ FILTER BAR ══ --}}
    <form method="GET" action="{{ route('admin.admin.reviews.index') }}" id="rv-filter-form">
        <div class="rv-filter-bar">
            <div class="rv-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="rv-search-input"
                       placeholder="পণ্য বা reviewer নাম খুঁজুন..."
                       value="{{ request('search') }}">
            </div>
            <select name="status" class="rv-filter-select" onchange="document.getElementById('rv-filter-form').submit()">
                <option value="all"      {{ request('status','all') === 'all'      ? 'selected' : '' }}>সব রিভিউ</option>
                <option value="pending"  {{ request('status') === 'pending'        ? 'selected' : '' }}>⏳ Pending</option>
                <option value="approved" {{ request('status') === 'approved'       ? 'selected' : '' }}>✅ Approved</option>
            </select>
            <select name="rating" class="rv-filter-select" onchange="document.getElementById('rv-filter-form').submit()">
                <option value="">সব রেটিং</option>
                @for($r=5;$r>=1;$r--)
                    <option value="{{ $r }}" {{ request('rating') == $r ? 'selected' : '' }}>
                        {{ $r }} ★
                    </option>
                @endfor
            </select>
            <button type="submit" class="rv-bulk-btn">
                <i class="fas fa-filter"></i> ফিল্টার
            </button>
            @if(request()->hasAny(['search','status','rating']))
                <a href="{{ route('admin.admin.reviews.index') }}" class="rv-bulk-btn outline">
                    <i class="fas fa-times"></i> রিসেট
                </a>
            @endif
        </div>
    </form>

    {{-- ══ BULK ACTIONS ══ --}}
    <form method="POST" action="{{ route('admin.admin.reviews.bulk') }}" id="rv-bulk-form">
        @csrf
        <div style="display:flex;gap:8px;margin-bottom:14px;flex-wrap:wrap;align-items:center;">
            <span style="font-size:13px;color:#888;font-weight:500;">Bulk Action:</span>
            <button type="button" class="rv-bulk-btn" onclick="rvBulkAction('approve')" style="background:#22c55e;">
                <i class="fas fa-check"></i> সব Approve
            </button>
            <button type="button" class="rv-bulk-btn" onclick="rvBulkAction('unapprove')" style="background:#f59e0b;">
                <i class="fas fa-ban"></i> সব Unapprove
            </button>
            <button type="button" class="rv-bulk-btn" onclick="rvBulkAction('delete')" style="background:#e8192c;">
                <i class="fas fa-trash"></i> সব Delete
            </button>
            <input type="hidden" name="bulk_action" id="rv-bulk-action-input">
            <input type="hidden" name="selected_ids" id="rv-selected-ids">
        </div>

        {{-- ══ TABLE ══ --}}
        <div class="rv-card">
            <div class="rv-table-wrap">
                <table class="rv-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="rv-check" id="rv-check-all" onchange="rvToggleAll(this)"></th>
                            <th>#</th>
                            <th>পণ্য</th>
                            <th>Reviewer</th>
                            <th>রেটিং</th>
                            <th>রিভিউ</th>
                            <th>স্ট্যাটাস</th>
                            <th>তারিখ</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        @php
                            $prod  = $review->product;
                            $user  = $review->user;
                            $imgSrc = $prod && $prod->feature_image
                                ? asset('uploads/products/'.$prod->feature_image)
                                : 'https://via.placeholder.com/42/f3f4f6/9ca3af?text=P';
                        @endphp
                        <tr id="rv-row-{{ $review->id }}">
                            {{-- Checkbox --}}
                            <td>
                                <input type="checkbox" class="rv-check rv-row-check" value="{{ $review->id }}">
                            </td>
                            {{-- Row number --}}
                            <td style="color:#aaa;font-size:12px;font-weight:600;">
                                {{ ($reviews->currentPage()-1)*$reviews->perPage() + $loop->iteration }}
                            </td>
                            {{-- Product --}}
                            <td>
                                <div class="rv-prod-cell">
                                    <img src="{{ $imgSrc }}" class="rv-prod-img" alt=""
                                         onerror="this.src='https://via.placeholder.com/42/f3f4f6/9ca3af?text=P'">
                                    <div>
                                        <div class="rv-prod-name">
                                            {{ $prod ? $prod->name : '—' }}
                                        </div>
                                        @if($prod && $prod->category)
                                            <div class="rv-prod-cat">{{ $prod->category->category_name }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            {{-- Reviewer --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div class="rv-user-avatar">
                                        {{ strtoupper(substr($user ? $user->name : 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="rv-user-name">{{ $user ? $user->name : 'Anonymous' }}</div>
                                        <div class="rv-user-email">{{ $user ? $user->email : '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            {{-- Rating --}}
                            <td>
                                <div class="rv-stars">
                                    @for($s=1;$s<=5;$s++)
                                        <i class="fas fa-star {{ $s <= $review->rating ? '' : 'empty' }}"
                                           style="{{ $s <= $review->rating ? 'color:#f59e0b' : 'color:#ddd' }}"></i>
                                    @endfor
                                    <span class="rv-stars-num">{{ $review->rating }}/5</span>
                                </div>
                            </td>
                            {{-- Review text --}}
                            <td>
                                @if($review->review)
                                    <div class="rv-review-text">"{{ $review->review }}"</div>
                                    <button type="button"
                                            onclick="rvShowFull('{{ addslashes($review->review) }}','{{ addslashes($prod ? $prod->name : '') }}',{{ $review->rating }})"
                                            style="background:none;border:none;color:#e8192c;font-size:11px;font-weight:700;cursor:pointer;margin-top:4px;padding:0;font-family:inherit;">
                                        পুরো পড়ুন →
                                    </button>
                                @else
                                    <span class="rv-no-text">(কোনো মন্তব্য নেই)</span>
                                @endif
                            </td>
                            {{-- Status --}}
                            <td>
                                <span class="rv-status {{ $review->is_approved ? 'approved' : 'pending' }}">
                                    <i class="fas fa-{{ $review->is_approved ? 'check-circle' : 'hourglass-half' }}"></i>
                                    {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            {{-- Date --}}
                            <td>
                                <div class="rv-date">{{ $review->created_at->format('d M Y') }}</div>
                                <div class="rv-date" style="margin-top:2px;">{{ $review->created_at->format('H:i') }}</div>
                            </td>
                            {{-- Actions --}}
                            <td>
                                <div class="rv-actions">
                                    @if(!$review->is_approved)
                                        <form action="{{ route('admin.admin.reviews.approve', $review->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="rv-btn approve" title="Approve">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.admin.reviews.unapprove', $review->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="rv-btn unapprove" title="Unapprove">
                                                <i class="fas fa-ban"></i> Unpublish
                                            </button>
                                        </form>
                                    @endif
                                    <button type="button" class="rv-btn delete"
                                            onclick="rvConfirmDelete({{ $review->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="rv-empty">
                                    <i class="fas fa-star-half-alt"></i>
                                    <p>কোনো রিভিউ পাওয়া যায়নি।</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($reviews->hasPages())
            <div class="rv-pagination-wrap">
                <div class="rv-page-info">
                    মোট {{ $reviews->total() }} টি রিভিউ &nbsp;|&nbsp;
                    পেজ {{ $reviews->currentPage() }} / {{ $reviews->lastPage() }}
                </div>
                <div class="rv-pages">
                    @if($reviews->onFirstPage())
                        <span style="opacity:.4;"><i class="fas fa-chevron-left"></i></span>
                    @else
                        <a href="{{ $reviews->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
                    @endif
                    @foreach($reviews->getUrlRange(1, $reviews->lastPage()) as $page => $url)
                        @if($page == $reviews->currentPage())
                            <span class="active">{{ $page }}</span>
                        @elseif(abs($page - $reviews->currentPage()) <= 2)
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                    @if($reviews->hasMorePages())
                        <a href="{{ $reviews->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
                    @else
                        <span style="opacity:.4;"><i class="fas fa-chevron-right"></i></span>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </form>

</div>

{{-- ══ DELETE CONFIRM MODAL ══ --}}
<div class="rv-modal-bg" id="rv-delete-modal">
    <div class="rv-modal-box">
        <div class="rv-modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="rv-modal-title">রিভিউ মুছে ফেলবেন?</div>
        <div class="rv-modal-desc">এই রিভিউটি স্থায়ীভাবে মুছে যাবে এবং আর ফিরিয়ে আনা যাবে না।</div>
        <div class="rv-modal-actions">
            <button class="rv-modal-cancel" onclick="document.getElementById('rv-delete-modal').classList.remove('show')">
                বাতিল করুন
            </button>
            <button class="rv-modal-confirm" id="rv-delete-confirm-btn">হ্যাঁ, মুছুন</button>
        </div>
    </div>
</div>
<form id="rv-delete-form" action="" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>

{{-- ══ FULL REVIEW MODAL ══ --}}
<div class="rv-full-modal" id="rv-full-modal">
    <div class="rv-full-box">
        <div class="rv-full-box-head">
            <div class="rv-full-box-title" id="rv-full-prod-name">রিভিউ</div>
            <button class="rv-close-btn" onclick="document.getElementById('rv-full-modal').classList.remove('show')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="rv-stars" id="rv-full-stars" style="margin-bottom:16px;"></div>
        <p id="rv-full-text" style="font-size:14px;color:#444;line-height:1.7;font-style:italic;"></p>
    </div>
</div>

<script>
/* ──────────────────────────────────────
   ADMIN REVIEW JS
────────────────────────────────────── */

// Select all checkboxes
function rvToggleAll(masterChk) {
    document.querySelectorAll('.rv-row-check').forEach(function(c) {
        c.checked = masterChk.checked;
    });
}

// Bulk action
function rvBulkAction(action) {
    var selected = [];
    document.querySelectorAll('.rv-row-check:checked').forEach(function(c) {
        selected.push(c.value);
    });
    if (selected.length === 0) {
        alert('অন্তত একটি রিভিউ সিলেক্ট করুন।');
        return;
    }
    if (action === 'delete' && !confirm(selected.length + ' টি রিভিউ মুছে ফেলবেন?')) return;
    document.getElementById('rv-bulk-action-input').value = action;
    document.getElementById('rv-selected-ids').value = selected.join(',');
    document.getElementById('rv-bulk-form').submit();
}

// Delete confirm modal
function rvConfirmDelete(id) {
    var modal = document.getElementById('rv-delete-modal');
    var form  = document.getElementById('rv-delete-form');
    form.action = '{{ url("admin/reviews") }}/' + id;
    modal.classList.add('show');
    document.getElementById('rv-delete-confirm-btn').onclick = function() {
        form.submit();
    };
}
document.getElementById('rv-delete-modal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('show');
});

// Full review modal
function rvShowFull(text, prodName, rating) {
    document.getElementById('rv-full-prod-name').textContent = prodName || 'রিভিউ';
    document.getElementById('rv-full-text').textContent = '"' + text + '"';
    var starsEl = document.getElementById('rv-full-stars');
    starsEl.innerHTML = '';
    for (var s = 1; s <= 5; s++) {
        var i = document.createElement('i');
        i.className = 'fas fa-star';
        i.style.color = s <= rating ? '#f59e0b' : '#ddd';
        i.style.fontSize = '16px';
        starsEl.appendChild(i);
    }
    var numEl = document.createElement('span');
    numEl.textContent = rating + '/5';
    numEl.style.cssText = 'font-size:13px;font-weight:700;color:#555;margin-left:8px;';
    starsEl.appendChild(numEl);
    document.getElementById('rv-full-modal').classList.add('show');
}
document.getElementById('rv-full-modal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('show');
});

// Auto hide alerts
setTimeout(function() {
    document.querySelectorAll('.rv-alert').forEach(function(el) {
        el.style.transition = 'opacity .5s';
        el.style.opacity = '0';
        setTimeout(function() { el.remove(); }, 500);
    });
}, 4000);
</script>

@endsection
