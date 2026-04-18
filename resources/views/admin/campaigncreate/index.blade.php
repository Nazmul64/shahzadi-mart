@extends('admin.master')

@section('main-content')

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Syne:wght@600;700&display=swap" rel="stylesheet">
<style>
:root {
    --brand: #5b3cf5;
    --brand-light: #ede9ff;
    --brand-dark: #3d20d6;
    --surface: #ffffff;
    --surface-2: #f8f7fc;
    --border: rgba(91,60,245,0.10);
    --border-2: rgba(91,60,245,0.20);
    --text-1: #14112a;
    --text-2: #5c587a;
    --text-3: #9a96b5;
    --success: #16a34a;
    --success-bg: #dcfce7;
    --danger: #dc2626;
    --danger-bg: #fee2e2;
    --radius: 12px;
    --radius-sm: 7px;
    --shadow: 0 1px 3px rgba(20,17,42,.06), 0 4px 16px rgba(91,60,245,.06);
    --shadow-hover: 0 2px 8px rgba(20,17,42,.10), 0 8px 32px rgba(91,60,245,.12);
}
* { font-family: 'DM Sans', sans-serif; }
body { background: #f3f1fb !important; }

/* ── Page Header ───────────────────────────────── */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    padding: 8px 0;
}
.page-title {
    font-family: 'Syne', sans-serif;
    font-size: 22px;
    font-weight: 700;
    color: var(--text-1);
    letter-spacing: -.3px;
    margin: 0;
}
.page-title span {
    display: block;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 400;
    color: var(--text-3);
    margin-top: 2px;
    letter-spacing: 0;
}
.btn-create {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--brand);
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    padding: 9px 20px;
    border-radius: var(--radius-sm);
    text-decoration: none;
    transition: background .18s, transform .15s, box-shadow .18s;
    box-shadow: 0 2px 8px rgba(91,60,245,.25);
}
.btn-create:hover {
    background: var(--brand-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(91,60,245,.35);
    color: #fff;
    text-decoration: none;
}

/* ── Alert ─────────────────────────────────────── */
.alert-success-custom {
    background: var(--success-bg);
    border: 1px solid #86efac;
    color: var(--success);
    border-radius: var(--radius-sm);
    padding: 12px 16px;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
}

/* ── Table Card ─────────────────────────────────── */
.card-table {
    background: var(--surface);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
}
.table-header-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    border-bottom: 1px solid var(--border);
}
.table-header-bar h6 {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-2);
    margin: 0;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.count-badge {
    background: var(--brand-light);
    color: var(--brand);
    font-size: 12px;
    font-weight: 600;
    padding: 2px 10px;
    border-radius: 20px;
}

/* ── Table ──────────────────────────────────────── */
.table { margin-bottom: 0; }
.table thead th {
    background: var(--surface-2);
    border-bottom: 1px solid var(--border);
    border-top: none;
    font-size: 12px;
    font-weight: 600;
    color: var(--text-3);
    text-transform: uppercase;
    letter-spacing: .6px;
    padding: 12px 20px;
    white-space: nowrap;
}
.table tbody td {
    padding: 14px 20px;
    vertical-align: middle;
    border-bottom: 1px solid var(--border);
    font-size: 14px;
    color: var(--text-2);
}
.table tbody tr:last-child td { border-bottom: none; }
.table tbody tr { transition: background .12s; }
.table tbody tr:hover { background: #faf9ff; }

.td-title { font-weight: 500; color: var(--text-1); }
.td-product {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
}
.td-product::before {
    content: '';
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--brand);
    opacity: .5;
    flex-shrink: 0;
}

/* ── Media Type Pills ───────────────────────────── */
.media-pill-image {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #ede9ff;
    color: var(--brand);
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    letter-spacing: .2px;
}
.media-pill-video {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #fef3c7;
    color: #d97706;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    letter-spacing: .2px;
}

/* ── Preview Cell ───────────────────────────────── */
.img-thumb {
    width: 56px;
    height: 40px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid var(--border-2);
    display: block;
}

/* Video thumbnail wrapper */
.video-thumb-wrap {
    position: relative;
    width: 56px;
    height: 40px;
    border-radius: 6px;
    overflow: hidden;
    background: #1e1b2e;
    border: 1px solid var(--border-2);
    cursor: pointer;
    flex-shrink: 0;
}
.video-thumb-wrap video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.video-play-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(20,17,42,.45);
}
.video-play-overlay i {
    font-size: 13px;
    color: #fff;
    filter: drop-shadow(0 1px 3px rgba(0,0,0,.5));
}

/* URL video badge */
.video-url-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #fef3c7;
    color: #d97706;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    text-decoration: none;
    max-width: 100px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.video-url-badge:hover {
    background: #d97706;
    color: #fff;
    text-decoration: none;
}

.img-placeholder {
    width: 56px;
    height: 40px;
    background: var(--surface-2);
    border-radius: 6px;
    border: 1px dashed var(--border-2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-3);
    font-size: 11px;
}

/* ── Status Badges ──────────────────────────────── */
.badge-active {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: var(--success-bg);
    color: var(--success);
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}
.badge-active::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--success);
}
.badge-inactive {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #f4f4f6;
    color: var(--text-3);
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}
.badge-inactive::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--text-3);
}

/* ── Action Buttons ─────────────────────────────── */
.action-btns { display: flex; align-items: center; gap: 6px; justify-content: center; }
.btn-icon {
    width: 32px; height: 32px;
    display: inline-flex; align-items: center; justify-content: center;
    border-radius: 7px;
    font-size: 13px;
    transition: background .15s, color .15s, transform .13s;
    border: 1px solid transparent;
    cursor: pointer;
    text-decoration: none;
}
.btn-icon-edit { background: #ede9ff; color: var(--brand); border-color: rgba(91,60,245,.15); }
.btn-icon-edit:hover { background: var(--brand); color: #fff; transform: translateY(-1px); }
.btn-icon-del { background: var(--danger-bg); color: var(--danger); border-color: rgba(220,38,38,.15); }
.btn-icon-del:hover { background: var(--danger); color: #fff; transform: translateY(-1px); }

/* ── Empty State ────────────────────────────────── */
.empty-state { text-align: center; padding: 60px 20px; color: var(--text-3); }
.empty-state i { font-size: 36px; display: block; margin-bottom: 12px; opacity: .4; }
.empty-state p { font-size: 14px; margin: 0; }

/* ── Pagination ─────────────────────────────────── */
.pagination-wrap {
    border-top: 1px solid var(--border);
    padding: 14px 20px;
    background: var(--surface-2);
}
.pagination .page-link {
    border-radius: 6px !important;
    font-size: 13px;
    font-weight: 500;
    color: var(--brand);
    border: 1px solid var(--border);
    margin: 0 2px;
}
.pagination .page-item.active .page-link {
    background: var(--brand);
    border-color: var(--brand);
    color: #fff;
}

/* ── Serial Number ──────────────────────────────── */
.serial-num {
    width: 28px; height: 28px;
    background: var(--surface-2);
    border: 1px solid var(--border);
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 600; color: var(--text-3);
}

/* ── Video Modal ────────────────────────────────── */
.vmodal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(14,10,30,.75);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(4px);
}
.vmodal-backdrop.open { display: flex; }
.vmodal-box {
    background: #1e1b2e;
    border-radius: 14px;
    padding: 20px;
    max-width: 680px;
    width: 92vw;
    position: relative;
    box-shadow: 0 24px 80px rgba(0,0,0,.55);
}
.vmodal-close {
    position: absolute;
    top: -12px; right: -12px;
    width: 32px; height: 32px;
    background: var(--brand);
    color: #fff;
    border: none;
    border-radius: 50%;
    font-size: 13px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 8px rgba(91,60,245,.4);
    transition: background .15s, transform .13s;
}
.vmodal-close:hover { background: var(--brand-dark); transform: scale(1.1); }
.vmodal-box video {
    width: 100%;
    border-radius: 8px;
    max-height: 70vh;
    display: block;
    background: #000;
}
.vmodal-title {
    color: #fff;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 12px;
    opacity: .7;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<div class="container-fluid py-1">

    {{-- Page Header --}}
    <div class="page-header">
        <h4 class="page-title">
            Campaign Manager
            <span>Manage all your landing page campaigns</span>
        </h4>
        <a href="{{ route('admin.campaigncreate.create') }}" class="btn-create">
            <i class="fas fa-plus"></i> New Campaign
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert-success-custom">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card-table">
        <div class="table-header-bar">
            <h6>All Campaigns</h6>
            <span class="count-badge">{{ $campaigns->total() }} total</span>
        </div>

        <div class="table-responsive">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Title</th>
                        <th>Product</th>
                        <th>Media Type</th>
                        <th>Preview</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                    <tr>
                        {{-- Serial --}}
                        <td>
                            <div class="serial-num">{{ $loop->iteration }}</div>
                        </td>

                        {{-- Title --}}
                        <td>
                            <span class="td-title">{{ $campaign->title }}</span>
                        </td>

                        {{-- Product --}}
                        <td>
                            <span class="td-product">{{ $campaign->product->name ?? '—' }}</span>
                        </td>

                        {{-- Media Type Pill --}}
                        <td>
                            @if($campaign->media_type === 'Video')
                                <span class="media-pill-video">
                                    <i class="fas fa-video"></i> Video
                                </span>
                            @else
                                <span class="media-pill-image">
                                    <i class="fas fa-image"></i> Image
                                </span>
                            @endif
                        </td>

                        {{-- Preview --}}
                        <td>
                            @if($campaign->media_type === 'Video')
                                {{-- Uploaded video file --}}
                                @if($campaign->video)
                                    <div class="video-thumb-wrap"
                                         onclick="openVideoModal('{{ asset($campaign->video) }}', '{{ $campaign->title }}')">
                                        <video src="{{ asset($campaign->video) }}" preload="metadata" muted></video>
                                        <div class="video-play-overlay">
                                            <i class="fas fa-play"></i>
                                        </div>
                                    </div>
                                {{-- External video URL --}}
                                @elseif($campaign->video_url)
                                    <a href="{{ $campaign->video_url }}" target="_blank"
                                       class="video-url-badge" title="{{ $campaign->video_url }}">
                                        <i class="fas fa-external-link-alt"></i> URL
                                    </a>
                                @else
                                    <div class="img-placeholder"><i class="fas fa-video" style="font-size:14px;opacity:.4"></i></div>
                                @endif
                            @else
                                {{-- Image preview --}}
                                @if($campaign->image)
                                    <img src="{{ asset($campaign->image) }}" alt="preview" class="img-thumb">
                                @else
                                    <div class="img-placeholder">N/A</div>
                                @endif
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($campaign->status)
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-inactive">Inactive</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.campaigncreate.edit', $campaign->id) }}"
                                   class="btn-icon btn-icon-edit" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                 <a href="{{ route('campaign.manage', $campaign->id) }}"
                                    class="btn-icon btn-icon-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.campaigncreate.destroy', $campaign->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this campaign?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-icon-del" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-layer-group"></i>
                                <p>No campaigns found. Create your first one!</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($campaigns->hasPages())
        <div class="pagination-wrap">
            {{ $campaigns->links() }}
        </div>
        @endif
    </div>

</div>

{{-- Video Preview Modal --}}
<div class="vmodal-backdrop" id="videoModal" onclick="closeVideoModal(event)">
    <div class="vmodal-box">
        <button class="vmodal-close" onclick="closeVideoModal(null, true)">
            <i class="fas fa-times"></i>
        </button>
        <div class="vmodal-title" id="vmodal_title"></div>
        <video id="vmodal_player" controls></video>
    </div>
</div>

<script>
function openVideoModal(src, title) {
    const modal  = document.getElementById('videoModal');
    const player = document.getElementById('vmodal_player');
    const ttl    = document.getElementById('vmodal_title');
    player.src   = src;
    ttl.textContent = title;
    modal.classList.add('open');
    player.play().catch(() => {});
}

function closeVideoModal(e, force = false) {
    if (!force && e && e.target !== document.getElementById('videoModal')) return;
    const modal  = document.getElementById('videoModal');
    const player = document.getElementById('vmodal_player');
    player.pause();
    player.src = '';
    modal.classList.remove('open');
}

// ESC key close
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeVideoModal(null, true);
});
</script>

@endsection
