@extends('admin.master')

@section('main-content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Page Manage</h4>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary rounded-pill px-4">
            + Create
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Buttons + Search --}}
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <button class="btn btn-sm btn-secondary me-1" onclick="copyTable()">
                        <i class="fas fa-copy me-1"></i>Copy
                    </button>
                    <button class="btn btn-sm btn-secondary me-1" onclick="window.print()">
                        <i class="fas fa-print me-1"></i>Print
                    </button>
                    <button class="btn btn-sm btn-secondary" onclick="exportPDF()">
                        <i class="fas fa-file-pdf me-1"></i>PDF
                    </button>
                </div>
                <div class="d-flex align-items-center">
                    <label class="me-2 mb-0 fw-semibold">Search:</label>
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control form-control-sm"
                        style="width:200px"
                        onkeyup="searchTable()"
                        placeholder="খুঁজুন..."
                    >
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="pageTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:55px">SL</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th style="width:140px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $index => $page)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $page->name }}</td>
                            <td>{{ $page->title }}</td>

                            {{-- Category --}}
                            <td>
                                @if($page->footercategory)
                                    <span class="badge"
                                          style="background:#f0dde9; color:#b5006e;
                                                 font-size:.82rem; padding:5px 10px;
                                                 border-radius:6px; font-weight:600;">
                                        {{ $page->footercategory->category_name }}
                                    </span>
                                @else
                                    <span class="text-muted fst-italic" style="font-size:.82rem;">
                                        N/A
                                    </span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($page->status == 1)
                                    <span class="badge text-bg-success">Active</span>
                                @else
                                    <span class="badge text-bg-danger">Inactive</span>
                                @endif
                            </td>

                            {{-- Action --}}
                            <td>
                                {{-- Edit --}}
                                <a href="{{ route('admin.pages.edit', $page->id) }}"
                                   class="btn btn-sm btn-warning me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form
                                    action="{{ route('admin.pages.destroy', $page->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('সত্যিই Delete করবেন?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                কোনো Page নেই।
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    function searchTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('#pageTable tbody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
        });
    }

    function copyTable() {
        const table = document.getElementById('pageTable');
        const range = document.createRange();
        range.selectNode(table);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
        alert('Table copied to clipboard!');
    }

    function exportPDF() {
        window.print();
    }
</script>

@endsection
