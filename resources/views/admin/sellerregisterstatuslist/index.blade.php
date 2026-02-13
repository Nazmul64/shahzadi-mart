@extends('admin.master')

@section('main-content')

<style>
    /* Main Container - Add left margin to account for sidebar */
    .seller-management {
        padding: 20px;
        margin-left: 0;
        width: 100%;
        max-width: 100%;
    }

    /* Adjust for sidebar - Add this class to your container */
    .main-content-wrapper {
        margin-left: 250px; /* Adjust based on your sidebar width */
        padding: 20px;
        transition: margin-left 0.3s ease;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .page-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .page-header p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 14px;
        position: relative;
        z-index: 1;
    }

    /* Statistics Cards */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border-left: 4px solid;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, transparent 0%, rgba(0, 0, 0, 0.02) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card.total {
        border-color: #667eea;
    }

    .stat-card.pending {
        border-color: #f59e0b;
    }

    .stat-card.active {
        border-color: #10b981;
    }

    .stat-card.suspended {
        border-color: #ef4444;
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        margin: 5px 0;
    }

    .stat-icon {
        font-size: 24px;
        opacity: 0.3;
        float: right;
    }

    /* Filters Section */
    .filters-section {
        background: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .filters-section h5 {
        margin-bottom: 15px;
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        align-items: end;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 5px;
        display: block;
    }

    .form-control,
    .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 14px;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control:hover,
    .form-select:hover {
        border-color: #d1d5db;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .table-header {
        padding: 20px;
        border-bottom: 2px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .table-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .custom-table {
        margin: 0;
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table thead {
        background: #f9fafb;
    }

    .custom-table th {
        padding: 15px;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
        white-space: nowrap;
        text-align: left;
    }

    .custom-table td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        color: #374151;
    }

    .custom-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .custom-table tbody tr:hover {
        background-color: #f9fafb;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Seller Info */
    .seller-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .seller-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
        text-transform: uppercase;
    }

    .seller-details h6 {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
    }

    .seller-details p {
        margin: 2px 0 0;
        font-size: 12px;
        color: #6b7280;
    }

    /* Badges */
    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge i {
        font-size: 11px;
    }

    .badge.bg-warning {
        background-color: #fef3c7 !important;
        color: #92400e;
    }

    .badge.bg-success {
        background-color: #d1fae5 !important;
        color: #065f46;
    }

    .badge.bg-danger {
        background-color: #fee2e2 !important;
        color: #991b1b;
    }

    .badge.bg-info {
        background-color: #dbeafe !important;
        color: #1e40af;
    }

    /* Action Buttons */
    .btn-action-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-success {
        background-color: #10b981;
        color: white;
    }

    .btn-success:hover {
        background-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background-color: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-info {
        background-color: #3b82f6;
        color: white;
    }

    .btn-info:hover {
        background-color: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-secondary {
        background-color: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
        transform: translateY(-2px);
    }

    .btn-outline-primary {
        background-color: transparent;
        color: #667eea;
        border: 2px solid #667eea;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-outline-primary:hover {
        background-color: #667eea;
        color: white;
        border-color: #667eea;
        transform: translateY(-2px);
    }

    .text-muted {
        color: #9ca3af !important;
        font-size: 13px;
        font-style: italic;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 20px;
        display: block;
    }

    .empty-state h5 {
        font-size: 18px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
    }

    .empty-state p {
        font-size: 14px;
        margin-bottom: 20px;
        color: #6b7280;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 20px;
        border-top: 2px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .showing-entries {
        font-size: 14px;
        color: #6b7280;
    }

    /* Action Buttons Section */
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-primary i,
    .btn-secondary i,
    .btn-outline-primary i {
        font-size: 16px;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 20px;
        border-bottom: none;
    }

    .modal-title {
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .modal-body {
        padding: 25px;
    }

    .modal-footer {
        border-top: 2px solid #f3f4f6;
        padding: 15px 20px;
    }

    .info-row {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 10px;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #6b7280;
        font-size: 14px;
    }

    .info-value {
        color: #1f2937;
        font-size: 14px;
        word-break: break-word;
    }

    /* Section Headers in Modal */
    .modal-body h6 {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
        margin-top: 20px;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid #f3f4f6;
    }

    .modal-body h6:first-child {
        margin-top: 0;
    }

    /* Close Button */
    .btn-close-white {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }

    .btn-close-white:hover {
        opacity: 1;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .main-content-wrapper {
            margin-left: 200px; /* Smaller sidebar on tablets */
        }
    }

    @media (max-width: 768px) {
        .main-content-wrapper {
            margin-left: 0; /* No sidebar margin on mobile */
        }

        .page-header {
            padding: 20px;
        }

        .page-header h2 {
            font-size: 22px;
        }

        .stats-cards {
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .filter-row {
            grid-template-columns: 1fr;
        }

        .table-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .btn-action-group {
            flex-direction: column;
            width: 100%;
        }

        .btn-sm {
            width: 100%;
            justify-content: center;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
        }

        .pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }

        .info-row {
            grid-template-columns: 1fr;
            gap: 5px;
        }
    }

    @media (max-width: 480px) {
        .stats-cards {
            grid-template-columns: 1fr;
        }
    }

    /* Print Styles */
    @media print {
        .main-content-wrapper {
            margin-left: 0 !important;
        }

        .page-header,
        .filters-section,
        .action-buttons,
        .btn,
        .pagination-wrapper {
            display: none !important;
        }

        .table-card {
            box-shadow: none;
        }

        .custom-table {
            font-size: 12px;
        }

        .custom-table th,
        .custom-table td {
            padding: 8px;
        }
    }

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Smooth Scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Focus Styles for Accessibility */
    *:focus-visible {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }

    /* Utility Classes */
    .w-100 {
        width: 100%;
    }

    .mt-3 {
        margin-top: 1rem;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }
</style>

<div class="main-content-wrapper">
    <div class="container-fluid seller-management">
        <!-- Page Header -->
        <div class="page-header">
            <h2>
                <i class="bi bi-people-fill"></i> Seller Registration Management
            </h2>
            <p>Manage and approve seller registrations</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-cards">
            <div class="stat-card total">
                <i class="bi bi-people stat-icon"></i>
                <div class="stat-label">Total Sellers</div>
                <div class="stat-value">{{ $sellers->total() ?? count($sellers) }}</div>
            </div>
            <div class="stat-card pending">
                <i class="bi bi-clock-history stat-icon"></i>
                <div class="stat-label">Pending Approval</div>
                <div class="stat-value">{{ $sellers->where('status', 'pending')->count() }}</div>
            </div>
            <div class="stat-card active">
                <i class="bi bi-check-circle stat-icon"></i>
                <div class="stat-label">Active Sellers</div>
                <div class="stat-value">{{ $sellers->where('status', 'active')->count() }}</div>
            </div>
            <div class="stat-card suspended">
                <i class="bi bi-x-circle stat-icon"></i>
                <div class="stat-label">Suspended</div>
                <div class="stat-value">{{ $sellers->where('status', 'suspended')->count() }}</div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <h5><i class="bi bi-funnel"></i> Filters</h5>
            <form action="{{ route('seller.register.list') }}" method="GET">
                <div class="filter-row">
                    <div>
                        <label class="form-label">Search</label>
                        <input
                            type="text"
                            class="form-control"
                            name="search"
                            placeholder="Search by name, email, or store..."
                            value="{{ request('search') }}"
                        >
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Sort By</label>
                        <select class="form-select" name="sort">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('seller.register.export') }}" class="btn btn-outline-primary">
                <i class="bi bi-download"></i> Export to Excel
            </a>
            <button type="button" class="btn btn-secondary" onclick="window.print()">
                <i class="bi bi-printer"></i> Print
            </button>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div class="table-header">
                <h5 class="table-title">Seller List ({{ $sellers->total() ?? count($sellers) }} total)</h5>
            </div>

            @if($sellers->count() > 0)
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Seller Info</th>
                            <th>Store Name</th>
                            <th>Business Type</th>
                            <th>Phone</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sellers as $key => $seller)
                        <tr>
                            <td>{{ $sellers->firstItem() + $key ?? $key + 1 }}</td>
                            <td>
                                <div class="seller-info">
                                    <div class="seller-avatar">
                                        {{ strtoupper(substr($seller->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div class="seller-details">
                                        <h6>{{ $seller->name ?? 'N/A' }}</h6>
                                        <p>{{ $seller->email ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $seller->store_name ?? 'N/A' }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ ucfirst($seller->business_type ?? 'N/A') }}
                                </span>
                            </td>
                            <td>{{ $seller->phone ?? 'N/A' }}</td>
                            <td>
                                <small>{{ $seller->created_at ? $seller->created_at->format('M d, Y') : 'N/A' }}</small>
                            </td>
                            <td>
                                @if($seller->status == 'pending')
                                    <span class="badge bg-warning">
                                        <i class="bi bi-clock-history"></i> Pending
                                    </span>
                                @elseif($seller->status == 'active')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Active
                                    </span>
                                @elseif($seller->status == 'suspended')
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle"></i> Suspended
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-action-group">
                                    <!-- View Details -->
                                    <button
                                        type="button"
                                        class="btn btn-info btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewModal{{ $seller->id }}"
                                        title="View Details"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    @if($seller->status == 'pending')
                                        <!-- Approve -->
                                        <form
                                            action="{{ route('seller.register.approve', $seller->id) }}"
                                            method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you sure you want to approve this seller?')"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" title="Approve">
                                                <i class="bi bi-check-lg"></i> Approve
                                            </button>
                                        </form>

                                        <!-- Reject -->
                                        <form
                                            action="{{ route('seller.register.reject', $seller->id) }}"
                                            method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you sure you want to reject this seller?')"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Reject">
                                                <i class="bi bi-x-lg"></i> Reject
                                            </button>
                                        </form>
                                    @elseif($seller->status == 'active')
                                        <!-- Suspend -->
                                        <form
                                            action="{{ route('seller.register.suspend', $seller->id) }}"
                                            method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you sure you want to suspend this seller?')"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Suspend">
                                                <i class="bi bi-pause-circle"></i> Suspend
                                            </button>
                                        </form>
                                    @elseif($seller->status == 'suspended')
                                        <!-- Reactivate -->
                                        <form
                                            action="{{ route('seller.register.reactivate', $seller->id) }}"
                                            method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you sure you want to reactivate this seller?')"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" title="Reactivate">
                                                <i class="bi bi-arrow-clockwise"></i> Reactivate
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">No Action</span>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- View Details Modal -->
                        <div class="modal fade" id="viewModal{{ $seller->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $seller->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewModalLabel{{ $seller->id }}">
                                            <i class="bi bi-person-circle"></i> Seller Details
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6><strong>Personal Information</strong></h6>
                                        <div class="info-row">
                                            <div class="info-label">Full Name:</div>
                                            <div class="info-value">{{ $seller->name ?? 'N/A' }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Email:</div>
                                            <div class="info-value">{{ $seller->email ?? 'N/A' }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Phone:</div>
                                            <div class="info-value">{{ $seller->phone ?? 'N/A' }}</div>
                                        </div>

                                        <h6><strong>Business Information</strong></h6>
                                        <div class="info-row">
                                            <div class="info-label">Store Name:</div>
                                            <div class="info-value">{{ $seller->store_name ?? 'N/A' }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Business Type:</div>
                                            <div class="info-value">{{ ucfirst($seller->business_type ?? 'N/A') }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Business Name:</div>
                                            <div class="info-value">{{ $seller->business_name ?? 'N/A' }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Address:</div>
                                            <div class="info-value">{{ $seller->business_address ?? 'N/A' }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">City:</div>
                                            <div class="info-value">{{ $seller->city ?? 'N/A' }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Registration Date:</div>
                                            <div class="info-value">
                                                {{ $seller->created_at ? $seller->created_at->format('F d, Y h:i A') : 'N/A' }}
                                            </div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Status:</div>
                                            <div class="info-value">
                                                @if($seller->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($seller->status == 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($seller->status == 'suspended')
                                                    <span class="badge bg-danger">Suspended</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($sellers, 'links'))
            <div class="pagination-wrapper">
                <div class="showing-entries">
                    Showing {{ $sellers->firstItem() ?? 0 }} to {{ $sellers->lastItem() ?? 0 }}
                    of {{ $sellers->total() ?? 0 }} entries
                </div>
                <div>
                    {{ $sellers->links() }}
                </div>
            </div>
            @endif
            @else
            <!-- Empty State -->
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h5>No Sellers Found</h5>
                <p>There are no seller registrations matching your criteria.</p>
                @if(request()->hasAny(['search', 'status', 'sort']))
                    <a href="{{ route('seller.register.list') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-clockwise"></i> Clear Filters
                    </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-hide success/error messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (bootstrap && bootstrap.Alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);
    });

    // Confirm before bulk actions
    function confirmBulkAction(action) {
        return confirm(`Are you sure you want to ${action} selected sellers?`);
    }

    // Print functionality - Hide unnecessary elements
    window.onbeforeprint = function() {
        document.querySelectorAll('.btn, .filters-section, .action-buttons').forEach(el => {
            el.style.display = 'none';
        });
    };

    window.onafterprint = function() {
        document.querySelectorAll('.btn, .filters-section, .action-buttons').forEach(el => {
            el.style.display = '';
        });
    };

    // Prevent multiple form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
            }
        });
    });

    // Enhanced table row click (optional)
    document.querySelectorAll('.custom-table tbody tr').forEach(row => {
        row.style.cursor = 'pointer';
    });
</script>
@endsection
