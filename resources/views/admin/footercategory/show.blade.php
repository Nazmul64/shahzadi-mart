@extends('admin.master')

@section('main-content')

<style>
    .aip-page-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.35rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 24px;
    }

    .aip-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 6px rgba(0,0,0,.07);
        max-width: 680px;
    }

    .aip-card-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 14px 20px;
        border-bottom: 1px solid #eceef3;
        font-size: .92rem;
        font-weight: 700;
        color: #1a1a2e;
    }
    .aip-card-header i { font-size: .85rem; color: #6c6c8a; }

    .aip-card-body { padding: 24px; }

    /* ── Detail row ── */
    .aip-detail-row {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 14px 0;
        border-bottom: 1px solid #f3f4f8;
    }
    .aip-detail-row:last-child { border-bottom: none; }

    .aip-detail-label {
        min-width: 160px;
        font-size: .87rem;
        font-weight: 600;
        color: #6c6c8a;
        padding-top: 2px;
    }

    .aip-detail-value {
        font-size: .92rem;
        color: #1a1a2e;
        font-weight: 500;
        flex: 1;
    }

    .aip-badge {
        display: inline-block;
        background: #f3f4f8;
        color: #4a4a66;
        border-radius: 6px;
        padding: 3px 12px;
        font-size: .83rem;
        font-family: monospace;
        letter-spacing: .3px;
    }

    /* ── Action buttons ── */
    .aip-actions {
        display: flex;
        gap: 10px;
        margin-top: 24px;
    }

    .btn-aip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: none;
        border-radius: 8px;
        padding: 10px 22px;
        font-size: .9rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background .2s, box-shadow .2s, transform .15s;
    }
    .btn-aip:hover { transform: translateY(-1px); }

    .btn-aip-edit {
        background: #f59e0b;
        color: #fff;
    }
    .btn-aip-edit:hover {
        background: #d97706;
        box-shadow: 0 4px 14px rgba(245,158,11,.35);
        color: #fff;
    }

    .btn-aip-back {
        background: #f3f4f8;
        color: #3d3d55;
    }
    .btn-aip-back:hover {
        background: #e5e7ef;
        color: #1a1a2e;
    }

    .btn-aip-delete {
        background: #ef4444;
        color: #fff;
        border: none;
    }
    .btn-aip-delete:hover {
        background: #dc2626;
        box-shadow: 0 4px 14px rgba(239,68,68,.35);
    }
</style>

<div class="container-fluid py-2">

    {{-- Page title --}}
    <h4 class="aip-page-title">
        <i class="fas fa-layer-group"></i> Footer Category Details
    </h4>

    <div class="aip-card">
        <div class="aip-card-header">
            <i class="fas fa-info-circle"></i>
            Category Information
        </div>
        <div class="aip-card-body">

            {{-- ID --}}
            <div class="aip-detail-row">
                <div class="aip-detail-label">
                    <i class="fas fa-hashtag me-1"></i> ID
                </div>
                <div class="aip-detail-value">
                    {{ $footercategory->id }}
                </div>
            </div>

            {{-- Category Name --}}
            <div class="aip-detail-row">
                <div class="aip-detail-label">
                    <i class="fas fa-tag me-1"></i> Category Name
                </div>
                <div class="aip-detail-value">
                    {{ $footercategory->category_name }}
                </div>
            </div>

            {{-- Category Slug --}}
            <div class="aip-detail-row">
                <div class="aip-detail-label">
                    <i class="fas fa-link me-1"></i> Category Slug
                </div>
                <div class="aip-detail-value">
                    <span class="aip-badge">{{ $footercategory->category_slug }}</span>
                </div>
            </div>

            {{-- Created At --}}
            <div class="aip-detail-row">
                <div class="aip-detail-label">
                    <i class="fas fa-calendar-plus me-1"></i> Created At
                </div>
                <div class="aip-detail-value">
                    {{ $footercategory->created_at->format('d M Y, h:i A') }}
                </div>
            </div>

            {{-- Updated At --}}
            <div class="aip-detail-row">
                <div class="aip-detail-label">
                    <i class="fas fa-calendar-check me-1"></i> Updated At
                </div>
                <div class="aip-detail-value">
                    {{ $footercategory->updated_at->format('d M Y, h:i A') }}
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="aip-actions">
                <a href="{{ route('admin.footercategory.index') }}" class="btn-aip btn-aip-back">
                    <i class="fas fa-arrow-left"></i> Back
                </a>

                <a href="{{ route('admin.footercategory.edit', $footercategory->id) }}"
                   class="btn-aip btn-aip-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <form action="{{ route('admin.footercategory.destroy', $footercategory->id) }}"
                      method="POST"
                      style="display:inline"
                      onsubmit="return confirm('সত্যিই Delete করবেন?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-aip btn-aip-delete">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>

@endsection
