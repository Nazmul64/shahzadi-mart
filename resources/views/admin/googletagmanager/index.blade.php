@extends('admin.master')
@section('title', 'Google Tag Manager')

@section('main-content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap');

    .pixel-wrap { font-family: 'DM Sans', sans-serif; background: #0c0e14; min-height: 100vh; padding: 2.5rem 2rem; }
    .pixel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; }
    .pixel-title { font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 700; color: #f0f0f0; letter-spacing: -0.5px; }
    .pixel-title span { color: #7c6ef7; }
    .btn-add { display: inline-flex; align-items: center; gap: 8px; padding: 0.65rem 1.4rem; background: #7c6ef7; color: #fff; font-family: 'DM Sans', sans-serif; font-size: 0.875rem; font-weight: 500; border-radius: 10px; text-decoration: none; border: none; cursor: pointer; transition: background 0.2s, transform 0.15s; }
    .btn-add:hover { background: #6a5ce8; transform: translateY(-1px); color: #fff; }
    .btn-add svg { width: 15px; height: 15px; }

    .card-table { background: #13151f; border: 1px solid #1e2130; border-radius: 16px; overflow: hidden; }
    .table-head { display: grid; grid-template-columns: 60px 1fr 140px 160px; padding: 0.9rem 1.5rem; background: #0f1119; border-bottom: 1px solid #1e2130; }
    .table-head span { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.2px; color: #555a72; }

    .table-row { display: grid; grid-template-columns: 60px 1fr 140px 160px; padding: 1rem 1.5rem; border-bottom: 1px solid #1a1c27; align-items: center; transition: background 0.15s; }
    .table-row:last-child { border-bottom: none; }
    .table-row:hover { background: #181a25; }

    .row-id { font-size: 0.8rem; color: #3d4157; font-weight: 600; }
    .row-pid { font-family: 'Courier New', monospace; font-size: 0.85rem; color: #c8cbe0; letter-spacing: 0.5px; }

    .badge-active { display: inline-flex; align-items: center; gap: 6px; padding: 0.3rem 0.8rem; background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.25); border-radius: 20px; font-size: 0.75rem; font-weight: 500; color: #34d399; }
    .badge-active::before { content: ''; width: 6px; height: 6px; background: #34d399; border-radius: 50%; }
    .badge-inactive { display: inline-flex; align-items: center; gap: 6px; padding: 0.3rem 0.8rem; background: rgba(100, 100, 120, 0.12); border: 1px solid rgba(100, 100, 120, 0.2); border-radius: 20px; font-size: 0.75rem; font-weight: 500; color: #5a5f7a; }

    .actions { display: flex; justify-content: center; gap: 8px; }
    .btn-edit { padding: 0.38rem 1rem; background: rgba(250, 199, 117, 0.1); border: 1px solid rgba(250, 199, 117, 0.25); color: #fac775; font-size: 0.78rem; font-weight: 500; border-radius: 8px; text-decoration: none; transition: all 0.2s; }
    .btn-edit:hover { background: rgba(250, 199, 117, 0.18); color: #fac775; }
    .btn-del { padding: 0.38rem 1rem; background: rgba(226, 75, 74, 0.1); border: 1px solid rgba(226, 75, 74, 0.25); color: #e24b4a; font-size: 0.78rem; font-weight: 500; border-radius: 8px; border: 1px solid rgba(226, 75, 74, 0.25); cursor: pointer; background: rgba(226, 75, 74, 0.1); transition: all 0.2s; }
    .btn-del:hover { background: rgba(226, 75, 74, 0.18); }

    .empty-state { padding: 4rem 2rem; text-align: center; color: #3d4157; }
    .empty-state svg { width: 42px; height: 42px; margin-bottom: 1rem; opacity: 0.3; }
    .empty-state p { font-size: 0.9rem; }

    .flash-success { margin-bottom: 1.5rem; padding: 0.85rem 1.25rem; background: rgba(52, 211, 153, 0.08); border: 1px solid rgba(52, 211, 153, 0.2); border-radius: 10px; color: #34d399; font-size: 0.875rem; display: flex; align-items: center; gap: 8px; }
</style>

<div class="pixel-wrap">

    @if(session('success'))
    <div class="flash-success">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="pixel-header">
        <h1 class="pixel-title">Google Tag <span>Manager</span></h1>
        <a href="{{ route('admin.googletagmanager.create') }}" class="btn-add">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Tag
        </a>
    </div>

    <div class="card-table">
        <div class="table-head">
            <span>#</span>
            <span>Google Tag ID</span>
            <span>Status</span>
            <span style="text-align:center">Actions</span>
        </div>

        @forelse($google_tag_ids as $tag)
        <div class="table-row">
            <span class="row-id">{{ $tag->id }}</span>
            <span class="row-pid">{{ $tag->google_tag_id }}</span>
            <span>
                @if($tag->status)
                    <span class="badge-active">Active</span>
                @else
                    <span class="badge-inactive">Inactive</span>
                @endif
            </span>
            <div class="actions">
                <a href="{{ route('admin.googletagmanager.edit', $tag->id) }}" class="btn-edit">Edit</a>
                <form action="{{ route('admin.googletagmanager.destroy', $tag->id) }}" method="POST"
                      onsubmit="return confirm('Delete this Google Tag ID?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-del">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p>No tags found. Add your first Google Tag ID.</p>
        </div>
        @endforelse
    </div>

</div>

@endsection
