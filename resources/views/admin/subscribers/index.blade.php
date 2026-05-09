@extends('admin.master')

@section('main-content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    .page-title-box h4    { font-size: 1.1rem; font-weight: 600; margin-bottom: 2px; }
    .page-title-box small { color: #6c757d; font-size: .82rem; }

    #subscriberTable thead tr th {
        background: #fff; font-weight: 600; font-size: .88rem;
        color: #333; border-bottom: 2px solid #dee2e6; white-space: nowrap;
    }
    #subscriberTable tbody tr td { font-size: .88rem; vertical-align: middle; }
    #subscriberTable tbody tr:hover { background: #f8f9fa; }

    .btn-del {
        background-color: #c0392b; color: #fff; border: none;
        border-radius: 50%; width: 32px; height: 32px;
        display: inline-flex; align-items: center;
        justify-content: center; font-size: .85rem;
        cursor: pointer; vertical-align: middle;
    }
    .btn-del:hover { background-color: #a93226; }
</style>

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-start mb-3">
    <div class="page-title-box">
        <h4>Newsletter Subscribers</h4>
        <small>Dashboard &rsaquo; Subscribers List</small>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-3">

        <table id="subscriberTable" class="table table-bordered w-100">
            <thead>
                <tr>
                    <th style="width:50px;">SL</th>
                    <th>Email</th>
                    <th>Subscribed Date</th>
                    <th class="text-center" style="width:100px;">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscribers as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->created_at->format('d M Y, h:i A') }}</td>
                    <td class="text-center">
                        <form action="{{ route('admin.subscribers.destroy', $item->id) }}"
                              method="POST" style="display:inline-block;"
                              onsubmit="return confirm('আপনি কি নিশ্চিত যে আপনি এই সাবস্ক্রাইবার মুছে ফেলতে চান?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-del" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $subscribers->links() }}
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#subscriberTable').DataTable({
        dom: '<"row align-items-center mb-3"<"col-auto"l><"col-auto"f>>rtip',
        order: [[2, 'desc']],
        pageLength: 20,
        language: {
            search:     "Search:",
            lengthMenu: "Show _MENU_ entries",
            info:       "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate:   { previous: "Previous", next: "Next" }
        },
        columnDefs: [
            { orderable: false, targets: [0, 3] }
        ],
        paging: false // Since we use Laravel pagination
    });
});
</script>

@endsection
