@extends('admin.master')

@section('main-content')

<div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <div class="navbar-brand">
                    <i class="bi bi-shop"></i>
                    <span class="d-none d-sm-inline">Admin</span>
                </div>
            </div>

            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search...">
            </div>

            <div class="top-navbar-right">
                <div class="notification-icon">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge">12</span>
                </div>

               <div class="dropdown user-profile">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                    id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">

                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100"
                            alt="Admin" class="user-avatar rounded-circle" width="40" height="40">

                        <div class="user-info ms-2">
                            <h6 class="mb-0"></h6>
                            <small class="text-muted">{{Auth::user()->name ?? ''}}</small>
                        </div>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-gear"></i> Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content" style="padding-bottom: 80px;">
            <!-- Dashboard Section -->
            <div class="page-section active" id="dashboard">
                <div class="page-header">
                    <h2>Dashboard Overview</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </nav>
                </div>

                <!-- Stats Cards -->
                <div class="stats-cards">
                    <div class="stat-card primary">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Revenue</span>
                            <div class="stat-card-icon primary">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">$124.5K</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+12.5%</span>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Orders</span>
                            <div class="stat-card-icon success">
                                <i class="bi bi-cart-check"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">3,847</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+8.2%</span>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Active Vendors</span>
                            <div class="stat-card-icon warning">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">156</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+3 new</span>
                        </div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Products</span>
                            <div class="stat-card-icon info">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">12.4K</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+215</span>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="row">
                    <div class="col-lg-8 mb-3">
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Sales Analytics</h5>
                            </div>
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-3">
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Order Status</h5>
                            </div>
                            <canvas id="orderStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders & Activity -->
                <div class="row">
                    <div class="col-lg-8 mb-3">
                        <div class="data-card">
                            <div class="data-card-header">
                                <h5 class="data-card-title">Recent Orders</h5>
                                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>

                            <!-- Desktop Table -->
                            <div class="table-responsive d-none d-md-block">
                                <table class="table data-table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#ORD-1234</td>
                                            <td>John Doe</td>
                                            <td>$459.00</td>
                                            <td><span class="badge badge-success">Delivered</span></td>
                                            <td>Feb 09</td>
                                        </tr>
                                        <tr>
                                            <td>#ORD-1235</td>
                                            <td>Sarah Wilson</td>
                                            <td>$299.00</td>
                                            <td><span class="badge badge-warning">Processing</span></td>
                                            <td>Feb 09</td>
                                        </tr>
                                        <tr>
                                            <td>#ORD-1236</td>
                                            <td>Mike Johnson</td>
                                            <td>$1,249.00</td>
                                            <td><span class="badge badge-info">Shipped</span></td>
                                            <td>Feb 08</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card List -->
                            <div class="mobile-card-list d-md-none">
                                <div class="mobile-card-item">
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Order ID:</span>
                                        <span class="mobile-card-value">#ORD-1234</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Customer:</span>
                                        <span class="mobile-card-value">John Doe</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Amount:</span>
                                        <span class="mobile-card-value">$459.00</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Status:</span>
                                        <span class="badge badge-success">Delivered</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Date:</span>
                                        <span class="mobile-card-value">Feb 09, 2026</span>
                                    </div>
                                </div>

                                <div class="mobile-card-item">
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Order ID:</span>
                                        <span class="mobile-card-value">#ORD-1235</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Customer:</span>
                                        <span class="mobile-card-value">Sarah Wilson</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Amount:</span>
                                        <span class="mobile-card-value">$299.00</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Status:</span>
                                        <span class="badge badge-warning">Processing</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Date:</span>
                                        <span class="mobile-card-value">Feb 09, 2026</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-3">
                        <div class="data-card">
                            <div class="data-card-header">
                                <h5 class="data-card-title">Recent Activity</h5>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon" style="background: #dbeafe; color: #1e40af;">
                                    <i class="bi bi-person-plus"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>New Vendor</h6>
                                    <p>Fashion Outlet joined</p>
                                    <span class="activity-time">2 hours ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon" style="background: #d1fae5; color: #065f46;">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>New Product</h6>
                                    <p>Gaming Laptop added</p>
                                    <span class="activity-time">4 hours ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon" style="background: #fef3c7; color: #92400e;">
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>New Review</h6>
                                    <p>5 star for Headphones</p>
                                    <span class="activity-time">6 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vendors Section -->
            <div class="page-section" id="vendors">
                <div class="page-header">
                    <h2>Vendor Management</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Vendors</li>
                        </ol>
                    </nav>
                </div>

                <div class="filter-section">
                    <button class="filter-toggle" onclick="toggleFilter()">
                        <i class="bi bi-funnel"></i>
                        <span>Filters</span>
                    </button>
                    <div class="filter-content" id="filterContent">
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label">Search Vendor</label>
                                <input type="text" class="form-control" placeholder="Search...">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Status</label>
                                <select class="form-select">
                                    <option>All Status</option>
                                    <option>Active</option>
                                    <option>Pending</option>
                                    <option>Suspended</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Join Date</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">All Vendors (156)</h5>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addVendorModal">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>

                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Vendor</th>
                                    <th>Products</th>
                                    <th>Sales</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="vendor-info">
                                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=100" alt="Vendor" class="vendor-avatar">
                                            <div class="vendor-details">
                                                <h6>Tech Store</h6>
                                                <p>John Smith</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>245</td>
                                    <td>$45.2K</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                            <button class="btn-action edit"><i class="bi bi-pencil"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="vendor-info">
                                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" alt="Vendor" class="vendor-avatar">
                                            <div class="vendor-details">
                                                <h6>Fashion Hub</h6>
                                                <p>Sarah Wilson</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>189</td>
                                    <td>$32.8K</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                            <button class="btn-action edit"><i class="bi bi-pencil"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="mobile-card-list d-md-none">
                        <div class="mobile-card-item">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="vendor-info">
                                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=100" alt="Vendor" class="vendor-avatar">
                                    <div class="vendor-details">
                                        <h6>Tech Store</h6>
                                        <p>John Smith</p>
                                    </div>
                                </div>
                                <span class="badge badge-success">Active</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Products:</span>
                                <span class="mobile-card-value">245</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Total Sales:</span>
                                <span class="mobile-card-value">$45,230</span>
                            </div>
                            <div class="action-buttons mt-2">
                                <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                <button class="btn-action edit"><i class="bi bi-pencil"></i></button>
                                <button class="btn-action delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>

                        <div class="mobile-card-item">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="vendor-info">
                                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" alt="Vendor" class="vendor-avatar">
                                    <div class="vendor-details">
                                        <h6>Fashion Hub</h6>
                                        <p>Sarah Wilson</p>
                                    </div>
                                </div>
                                <span class="badge badge-success">Active</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Products:</span>
                                <span class="mobile-card-value">189</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Total Sales:</span>
                                <span class="mobile-card-value">$32,890</span>
                            </div>
                            <div class="action-buttons mt-2">
                                <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                <button class="btn-action edit"><i class="bi bi-pencil"></i></button>
                                <button class="btn-action delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="page-section" id="products">
                <div class="page-header">
                    <h2>Product Management</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </nav>
                </div>

                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">All Products (12,458)</h5>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="mobile-card-list">
                        <div class="mobile-card-item">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100" alt="Product" class="product-img">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0" style="font-size: 14px;">Wireless Headphones</h6>
                                    <small class="text-secondary">SKU-001234</small>
                                </div>
                                <span class="badge badge-success">Active</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Price:</span>
                                <span class="mobile-card-value">$129.99</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Stock:</span>
                                <span class="mobile-card-value">45 units</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Vendor:</span>
                                <span class="mobile-card-value">Tech Store</span>
                            </div>
                            <div class="action-buttons mt-2">
                                <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                <button class="btn-action edit"><i class="bi bi-pencil"></i></button>
                                <button class="btn-action delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>

                        <div class="mobile-card-item">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100" alt="Product" class="product-img">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0" style="font-size: 14px;">Smart Watch</h6>
                                    <small class="text-secondary">SKU-001235</small>
                                </div>
                                <span class="badge badge-warning">Low Stock</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Price:</span>
                                <span class="mobile-card-value">$299.99</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Stock:</span>
                                <span class="mobile-card-value">12 units</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Vendor:</span>
                                <span class="mobile-card-value">Tech Store</span>
                            </div>
                            <div class="action-buttons mt-2">
                                <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                <button class="btn-action edit"><i class="bi bi-pencil"></i></button>
                                <button class="btn-action delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Section -->
            <div class="page-section" id="orders">
                <div class="page-header">
                    <h2>Order Management</h2>
                </div>

                <div class="stats-cards mb-3">
                    <div class="stat-card primary">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total</span>
                            <div class="stat-card-icon primary">
                                <i class="bi bi-cart"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">3,847</div>
                    </div>
                    <div class="stat-card success">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Delivered</span>
                            <div class="stat-card-icon success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">2,941</div>
                    </div>
                    <div class="stat-card warning">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Processing</span>
                            <div class="stat-card-icon warning">
                                <i class="bi bi-clock"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">645</div>
                    </div>
                    <div class="stat-card info">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Pending</span>
                            <div class="stat-card-icon info">
                                <i class="bi bi-hourglass"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">261</div>
                    </div>
                </div>

                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">All Orders</h5>
                    </div>
                    <div class="mobile-card-list">
                        <div class="mobile-card-item">
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Order ID:</span>
                                <span class="mobile-card-value">#ORD-1234</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Customer:</span>
                                <span class="mobile-card-value">John Doe</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Amount:</span>
                                <span class="mobile-card-value">$459.00</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Status:</span>
                                <span class="badge badge-success">Delivered</span>
                            </div>
                            <div class="action-buttons mt-2">
                                <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                <button class="btn-action edit"><i class="bi bi-pencil"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Sections with Empty States -->
            <div class="page-section" id="customers">
                <div class="page-header">
                    <h2>Customer Management</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-person-badge"></i>
                    <h4>Customer Management</h4>
                    <p>Manage your customers</p>
                </div>
            </div>

            <div class="page-section" id="categories">
                <div class="page-header">
                    <h2>Categories</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-tags"></i>
                    <h4>Category Management</h4>
                    <p>Organize your products</p>
                </div>
            </div>

            <div class="page-section" id="inventory">
                <div class="page-header">
                    <h2>Inventory Management</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Inventory</li>
                        </ol>
                    </nav>
                </div>

                <!-- Stats Cards -->
                <div class="stats-cards mb-3">
                    <div class="stat-card primary">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Products</span>
                            <div class="stat-card-icon primary">
                                <i class="bi bi-boxes"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">12,458</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+215</span>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-card-header">
                            <span class="stat-card-title">In Stock</span>
                            <div class="stat-card-icon success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">10,234</div>
                        <div class="stat-card-change">
                            <span>82.1%</span>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Low Stock</span>
                            <div class="stat-card-icon warning">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">1,856</div>
                        <div class="stat-card-change negative">
                            <i class="bi bi-arrow-down"></i>
                            <span>14.9%</span>
                        </div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Out of Stock</span>
                            <div class="stat-card-icon info">
                                <i class="bi bi-x-circle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">368</div>
                        <div class="stat-card-change">
                            <span>3.0%</span>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="filter-section">
                    <button class="filter-toggle" onclick="toggleFilter()">
                        <i class="bi bi-funnel"></i>
                        <span>Filters</span>
                    </button>
                    <div class="filter-content" id="filterContent">
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label">Search Product</label>
                                <input type="text" class="form-control" placeholder="Search by name or SKU...">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Category</label>
                                <select class="form-select">
                                    <option>All Categories</option>
                                    <option>Electronics</option>
                                    <option>Fashion</option>
                                    <option>Home & Garden</option>
                                    <option>Sports</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Vendor</label>
                                <select class="form-select">
                                    <option>All Vendors</option>
                                    <option>Tech Store</option>
                                    <option>Fashion Hub</option>
                                    <option>Sports Zone</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Stock Status</label>
                                <select class="form-select">
                                    <option>All Status</option>
                                    <option>In Stock</option>
                                    <option>Low Stock</option>
                                    <option>Out of Stock</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Warehouse</label>
                                <select class="form-select">
                                    <option>All Warehouses</option>
                                    <option>Main Warehouse</option>
                                    <option>Warehouse A</option>
                                    <option>Warehouse B</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory Chart -->
                <div class="row mb-3">
                    <div class="col-lg-8 mb-3">
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Stock Movement</h5>
                            </div>
                            <canvas id="stockMovementChart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Stock Distribution</h5>
                            </div>
                            <canvas id="stockDistributionChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>
                        <strong>Low Stock Alert!</strong> 1,856 products are running low on stock.
                        <a href="#" class="alert-link">View All</a>
                    </div>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-inventory-tab" data-bs-toggle="tab" data-bs-target="#all-inventory" type="button">
                            All Products
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="low-stock-tab" data-bs-toggle="tab" data-bs-target="#low-stock" type="button">
                            Low Stock
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="out-stock-tab" data-bs-toggle="tab" data-bs-target="#out-stock" type="button">
                            Out of Stock
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="movements-tab" data-bs-toggle="tab" data-bs-target="#movements" type="button">
                            Stock Movements
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- All Inventory Tab -->
                    <div class="tab-pane fade show active" id="all-inventory" role="tabpanel">
                        <div class="data-card">
                            <div class="data-card-header">
                                <h5 class="data-card-title">All Inventory Items</h5>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateStockModal">
                                    <i class="bi bi-arrow-repeat"></i> Update Stock
                                </button>
                            </div>

                            <!-- Desktop Table -->
                            <div class="table-responsive d-none d-md-block">
                                <table class="table data-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>SKU</th>
                                            <th>Vendor</th>
                                            <th>Warehouse</th>
                                            <th>In Stock</th>
                                            <th>Reserved</th>
                                            <th>Available</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100" alt="Product" class="product-img me-2">
                                                    <span>Wireless Headphones</span>
                                                </div>
                                            </td>
                                            <td>SKU-001234</td>
                                            <td>Tech Store</td>
                                            <td>Main Warehouse</td>
                                            <td>45</td>
                                            <td>3</td>
                                            <td><strong>42</strong></td>
                                            <td><span class="badge badge-success">In Stock</span></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-action view" title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn-action edit" title="Adjust Stock" onclick="adjustStock('Wireless Headphones')">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100" alt="Product" class="product-img me-2">
                                                    <span>Smart Watch</span>
                                                </div>
                                            </td>
                                            <td>SKU-001235</td>
                                            <td>Tech Store</td>
                                            <td>Warehouse A</td>
                                            <td>12</td>
                                            <td>2</td>
                                            <td><strong>10</strong></td>
                                            <td><span class="badge badge-warning">Low Stock</span></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-action view" title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn-action edit" title="Adjust Stock" onclick="adjustStock('Smart Watch')">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=100" alt="Product" class="product-img me-2">
                                                    <span>Running Shoes</span>
                                                </div>
                                            </td>
                                            <td>SKU-001236</td>
                                            <td>Sports Zone</td>
                                            <td>Warehouse B</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td><strong>0</strong></td>
                                            <td><span class="badge badge-danger">Out of Stock</span></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-action view" title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn-action edit" title="Restock" onclick="adjustStock('Running Shoes')">
                                                        <i class="bi bi-plus-circle"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=100" alt="Product" class="product-img me-2">
                                                    <span>Gaming Laptop</span>
                                                </div>
                                            </td>
                                            <td>SKU-001237</td>
                                            <td>Tech Store</td>
                                            <td>Main Warehouse</td>
                                            <td>23</td>
                                            <td>1</td>
                                            <td><strong>22</strong></td>
                                            <td><span class="badge badge-success">In Stock</span></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-action view" title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn-action edit" title="Adjust Stock" onclick="adjustStock('Gaming Laptop')">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card List -->
                            <div class="mobile-card-list d-md-none">
                                <div class="mobile-card-item">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100" alt="Product" class="product-img">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0" style="font-size: 14px;">Wireless Headphones</h6>
                                            <small class="text-secondary">SKU-001234</small>
                                        </div>
                                        <span class="badge badge-success">In Stock</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Vendor:</span>
                                        <span class="mobile-card-value">Tech Store</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Warehouse:</span>
                                        <span class="mobile-card-value">Main Warehouse</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">In Stock:</span>
                                        <span class="mobile-card-value">45 units</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Reserved:</span>
                                        <span class="mobile-card-value">3 units</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Available:</span>
                                        <span class="mobile-card-value"><strong>42 units</strong></span>
                                    </div>
                                    <div class="action-buttons mt-2">
                                        <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                        <button class="btn-action edit" onclick="adjustStock('Wireless Headphones')"><i class="bi bi-pencil"></i></button>
                                    </div>
                                </div>

                                <div class="mobile-card-item">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100" alt="Product" class="product-img">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0" style="font-size: 14px;">Smart Watch</h6>
                                            <small class="text-secondary">SKU-001235</small>
                                        </div>
                                        <span class="badge badge-warning">Low Stock</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Vendor:</span>
                                        <span class="mobile-card-value">Tech Store</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Warehouse:</span>
                                        <span class="mobile-card-value">Warehouse A</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">In Stock:</span>
                                        <span class="mobile-card-value text-warning">12 units</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Reserved:</span>
                                        <span class="mobile-card-value">2 units</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Available:</span>
                                        <span class="mobile-card-value"><strong>10 units</strong></span>
                                    </div>
                                    <div class="action-buttons mt-2">
                                        <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                        <button class="btn-action edit" onclick="adjustStock('Smart Watch')"><i class="bi bi-pencil"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Low Stock Tab -->
                    <div class="tab-pane fade" id="low-stock" role="tabpanel">
                        <div class="data-card">
                            <div class="data-card-header">
                                <h5 class="data-card-title">Low Stock Items (1,856)</h5>
                                <button class="btn btn-sm btn-warning">
                                    <i class="bi bi-bell"></i> Set Alerts
                                </button>
                            </div>
                            <div class="alert alert-warning">
                                <i class="bi bi-info-circle me-2"></i>
                                These products need restocking soon to avoid stockouts.
                            </div>
                            <div class="mobile-card-list">
                                <div class="mobile-card-item">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100" alt="Product" class="product-img">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0" style="font-size: 14px;">Smart Watch</h6>
                                            <small class="text-secondary">SKU-001235</small>
                                        </div>
                                        <span class="badge badge-warning">Low Stock</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Current Stock:</span>
                                        <span class="mobile-card-value text-warning"><strong>12 units</strong></span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Min Required:</span>
                                        <span class="mobile-card-value">50 units</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Shortage:</span>
                                        <span class="mobile-card-value text-danger">-38 units</span>
                                    </div>
                                    <div class="action-buttons mt-2">
                                        <button class="btn btn-sm btn-primary" onclick="reorderProduct('Smart Watch')">
                                            <i class="bi bi-cart-plus"></i> Reorder
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Out of Stock Tab -->
                    <div class="tab-pane fade" id="out-stock" role="tabpanel">
                        <div class="data-card">
                            <div class="data-card-header">
                                <h5 class="data-card-title">Out of Stock Items (368)</h5>
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-exclamation-triangle"></i> Urgent
                                </button>
                            </div>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                These products are completely out of stock and need immediate restocking.
                            </div>
                            <div class="mobile-card-list">
                                <div class="mobile-card-item">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=100" alt="Product" class="product-img">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0" style="font-size: 14px;">Running Shoes</h6>
                                            <small class="text-secondary">SKU-001236</small>
                                        </div>
                                        <span class="badge badge-danger">Out of Stock</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Last Sold:</span>
                                        <span class="mobile-card-value">3 days ago</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Pending Orders:</span>
                                        <span class="mobile-card-value text-danger">12 orders</span>
                                    </div>
                                    <div class="action-buttons mt-2">
                                        <button class="btn btn-sm btn-primary" onclick="reorderProduct('Running Shoes')">
                                            <i class="bi bi-cart-plus"></i> Urgent Reorder
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Movements Tab -->
                    <div class="tab-pane fade" id="movements" role="tabpanel">
                        <div class="data-card">
                            <div class="data-card-header">
                                <h5 class="data-card-title">Recent Stock Movements</h5>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download"></i> Export
                                </button>
                            </div>

                            <!-- Desktop Table -->
                            <div class="table-responsive d-none d-md-block">
                                <table class="table data-table">
                                    <thead>
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>Product</th>
                                            <th>Type</th>
                                            <th>Quantity</th>
                                            <th>From/To</th>
                                            <th>Performed By</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Feb 09, 10:30 AM</td>
                                            <td>Wireless Headphones</td>
                                            <td><span class="badge badge-success"><i class="bi bi-arrow-down"></i> Stock In</span></td>
                                            <td><strong class="text-success">+50</strong></td>
                                            <td>Supplier ABC</td>
                                            <td>Admin User</td>
                                            <td>New shipment</td>
                                        </tr>
                                        <tr>
                                            <td>Feb 09, 09:15 AM</td>
                                            <td>Smart Watch</td>
                                            <td><span class="badge badge-danger"><i class="bi bi-arrow-up"></i> Stock Out</span></td>
                                            <td><strong class="text-danger">-5</strong></td>
                                            <td>Order #ORD-1234</td>
                                            <td>System</td>
                                            <td>Customer order</td>
                                        </tr>
                                        <tr>
                                            <td>Feb 08, 04:20 PM</td>
                                            <td>Gaming Laptop</td>
                                            <td><span class="badge badge-info"><i class="bi bi-arrow-left-right"></i> Transfer</span></td>
                                            <td><strong>10</strong></td>
                                            <td>Warehouse A → B</td>
                                            <td>Warehouse Manager</td>
                                            <td>Stock rebalancing</td>
                                        </tr>
                                        <tr>
                                            <td>Feb 08, 02:45 PM</td>
                                            <td>Running Shoes</td>
                                            <td><span class="badge badge-warning"><i class="bi bi-pencil"></i> Adjustment</span></td>
                                            <td><strong class="text-danger">-3</strong></td>
                                            <td>Main Warehouse</td>
                                            <td>Admin User</td>
                                            <td>Damaged items</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile Card List -->
                            <div class="mobile-card-list d-md-none">
                                <div class="mobile-card-item">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1" style="font-size: 13px;">Wireless Headphones</h6>
                                            <small class="text-secondary">Feb 09, 10:30 AM</small>
                                        </div>
                                        <span class="badge badge-success"><i class="bi bi-arrow-down"></i> Stock In</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Quantity:</span>
                                        <span class="mobile-card-value text-success"><strong>+50</strong></span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">From:</span>
                                        <span class="mobile-card-value">Supplier ABC</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Note:</span>
                                        <span class="mobile-card-value">New shipment</span>
                                    </div>
                                </div>

                                <div class="mobile-card-item">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1" style="font-size: 13px;">Smart Watch</h6>
                                            <small class="text-secondary">Feb 09, 09:15 AM</small>
                                        </div>
                                        <span class="badge badge-danger"><i class="bi bi-arrow-up"></i> Stock Out</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Quantity:</span>
                                        <span class="mobile-card-value text-danger"><strong>-5</strong></span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">To:</span>
                                        <span class="mobile-card-value">Order #ORD-1234</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Note:</span>
                                        <span class="mobile-card-value">Customer order</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-section" id="payments">
                <div class="page-header">
                    <h2>Payments</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-credit-card"></i>
                    <h4>Payment Management</h4>
                    <p>Track all transactions</p>
                </div>
            </div>

            <div class="page-section" id="commission">
                <div class="page-header">
                    <h2>Commission</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-percent"></i>
                    <h4>Commission Settings</h4>
                    <p>Manage vendor commissions</p>
                </div>
            </div>

            <div class="page-section" id="payouts">
                <div class="page-header">
                    <h2>Vendor Payouts</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Vendor Payouts</li>
                        </ol>
                    </nav>
                </div>

                <!-- Stats Cards -->
                <div class="stats-cards mb-3">
                    <div class="stat-card primary">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Payouts</span>
                            <div class="stat-card-icon primary">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">$89.5K</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>This Month</span>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Pending</span>
                            <div class="stat-card-icon warning">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">$12.3K</div>
                        <div class="stat-card-change">
                            <span>15 Vendors</span>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Completed</span>
                            <div class="stat-card-icon success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">$77.2K</div>
                        <div class="stat-card-change positive">
                            <span>141 Vendors</span>
                        </div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Next Payout</span>
                            <div class="stat-card-icon info">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">Feb 15</div>
                        <div class="stat-card-change">
                            <span>6 days left</span>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="filter-section">
                    <button class="filter-toggle" onclick="toggleFilter()">
                        <i class="bi bi-funnel"></i>
                        <span>Filters</span>
                    </button>
                    <div class="filter-content" id="filterContent">
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label">Search Vendor</label>
                                <input type="text" class="form-control" placeholder="Search by vendor name...">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Status</label>
                                <select class="form-select">
                                    <option>All Status</option>
                                    <option>Pending</option>
                                    <option>Processing</option>
                                    <option>Completed</option>
                                    <option>Failed</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Period</label>
                                <select class="form-select">
                                    <option>This Month</option>
                                    <option>Last Month</option>
                                    <option>Last 3 Months</option>
                                    <option>Last 6 Months</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">From Date</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="form-label">To Date</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payout Summary Chart -->
                <div class="row mb-3">
                    <div class="col-lg-8 mb-3">
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Payout Trends</h5>
                            </div>
                            <canvas id="payoutTrendsChart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Payment Methods</h5>
                            </div>
                            <canvas id="paymentMethodsChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pending Payouts -->
                <div class="data-card mb-3">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Pending Payouts (15)</h5>
                        <button class="btn btn-sm btn-primary" onclick="processAllPayouts()">
                            <i class="bi bi-send"></i> Process All
                        </button>
                    </div>

                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" onclick="selectAllPayouts(this)"></th>
                                    <th>Vendor</th>
                                    <th>Amount</th>
                                    <th>Commission</th>
                                    <th>Net Amount</th>
                                    <th>Period</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" class="payout-checkbox"></td>
                                    <td>
                                        <div class="vendor-info">
                                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=100" alt="Vendor" class="vendor-avatar">
                                            <div class="vendor-details">
                                                <h6>Tech Store</h6>
                                                <p>tech@store.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$4,520.00</td>
                                    <td>$678.00 (15%)</td>
                                    <td><strong>$3,842.00</strong></td>
                                    <td>Jan 2026</td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="bi bi-bank"></i> Bank
                                        </span>
                                    </td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn-action edit" title="Process" onclick="processPayout('Tech Store')">
                                                <i class="bi bi-send"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="payout-checkbox"></td>
                                    <td>
                                        <div class="vendor-info">
                                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" alt="Vendor" class="vendor-avatar">
                                            <div class="vendor-details">
                                                <h6>Fashion Hub</h6>
                                                <p>fashion@hub.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$3,290.00</td>
                                    <td>$394.80 (12%)</td>
                                    <td><strong>$2,895.20</strong></td>
                                    <td>Jan 2026</td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="bi bi-paypal"></i> PayPal
                                        </span>
                                    </td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn-action edit" title="Process" onclick="processPayout('Fashion Hub')">
                                                <i class="bi bi-send"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="payout-checkbox"></td>
                                    <td>
                                        <div class="vendor-info">
                                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt="Vendor" class="vendor-avatar">
                                            <div class="vendor-details">
                                                <h6>Sports Zone</h6>
                                                <p>sports@zone.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$2,845.00</td>
                                    <td>$284.50 (10%)</td>
                                    <td><strong>$2,560.50</strong></td>
                                    <td>Jan 2026</td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="bi bi-bank"></i> Bank
                                        </span>
                                    </td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn-action edit" title="Process" onclick="processPayout('Sports Zone')">
                                                <i class="bi bi-send"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="mobile-card-list d-md-none">
                        <div class="mobile-card-item">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="vendor-info">
                                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=100" alt="Vendor" class="vendor-avatar">
                                    <div class="vendor-details">
                                        <h6>Tech Store</h6>
                                        <p>tech@store.com</p>
                                    </div>
                                </div>
                                <span class="badge badge-warning">Pending</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Gross Amount:</span>
                                <span class="mobile-card-value">$4,520.00</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Commission (15%):</span>
                                <span class="mobile-card-value text-danger">-$678.00</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Net Amount:</span>
                                <span class="mobile-card-value"><strong>$3,842.00</strong></span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Period:</span>
                                <span class="mobile-card-value">Jan 2026</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Method:</span>
                                <span class="badge badge-info"><i class="bi bi-bank"></i> Bank Transfer</span>
                            </div>
                            <div class="action-buttons mt-2">
                                <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                <button class="btn-action edit" onclick="processPayout('Tech Store')"><i class="bi bi-send"></i></button>
                            </div>
                        </div>

                        <div class="mobile-card-item">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="vendor-info">
                                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" alt="Vendor" class="vendor-avatar">
                                    <div class="vendor-details">
                                        <h6>Fashion Hub</h6>
                                        <p>fashion@hub.com</p>
                                    </div>
                                </div>
                                <span class="badge badge-warning">Pending</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Gross Amount:</span>
                                <span class="mobile-card-value">$3,290.00</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Commission (12%):</span>
                                <span class="mobile-card-value text-danger">-$394.80</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Net Amount:</span>
                                <span class="mobile-card-value"><strong>$2,895.20</strong></span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Period:</span>
                                <span class="mobile-card-value">Jan 2026</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Method:</span>
                                <span class="badge badge-success"><i class="bi bi-paypal"></i> PayPal</span>
                            </div>
                            <div class="action-buttons mt-2">
                                <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                <button class="btn-action edit" onclick="processPayout('Fashion Hub')"><i class="bi bi-send"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payout History -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Payout History</h5>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download"></i> Export
                        </button>
                    </div>

                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Payout ID</th>
                                    <th>Vendor</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#PAY-7891</td>
                                    <td>
                                        <div class="vendor-info">
                                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=100" alt="Vendor" class="vendor-avatar">
                                            <div class="vendor-details">
                                                <h6>Tech Store</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><strong>$3,842.00</strong></td>
                                    <td><i class="bi bi-bank"></i> Bank Transfer</td>
                                    <td>Feb 01, 2026</td>
                                    <td><span class="badge badge-success">Completed</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view" title="View Receipt">
                                                <i class="bi bi-receipt"></i>
                                            </button>
                                            <button class="btn-action edit" title="Download">
                                                <i class="bi bi-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#PAY-7890</td>
                                    <td>
                                        <div class="vendor-info">
                                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="Vendor" class="vendor-avatar">
                                            <div class="vendor-details">
                                                <h6>Home Decor</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><strong>$3,256.90</strong></td>
                                    <td><i class="bi bi-paypal"></i> PayPal</td>
                                    <td>Feb 01, 2026</td>
                                    <td><span class="badge badge-success">Completed</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view" title="View Receipt">
                                                <i class="bi bi-receipt"></i>
                                            </button>
                                            <button class="btn-action edit" title="Download">
                                                <i class="bi bi-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#PAY-7889</td>
                                    <td>
                                        <div class="vendor-info">
                                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" alt="Vendor" class="vendor-avatar">
                                            <div class="vendor-details">
                                                <h6>Fashion Hub</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><strong>$2,895.20</strong></td>
                                    <td><i class="bi bi-paypal"></i> PayPal</td>
                                    <td>Jan 28, 2026</td>
                                    <td><span class="badge badge-info">Processing</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view" title="Track">
                                                <i class="bi bi-geo-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#PAY-7888</td>
                                    <td>
                                        <div class="vendor-info">
                                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt="Vendor" class="vendor-avatar">
                                            <div class="vendor-details">
                                                <h6>Sports Zone</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><strong>$2,340.50</strong></td>
                                    <td><i class="bi bi-bank"></i> Bank Transfer</td>
                                    <td>Jan 25, 2026</td>
                                    <td><span class="badge badge-danger">Failed</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view" title="View Details">
                                                <i class="bi bi-info-circle"></i>
                                            </button>
                                            <button class="btn-action edit" title="Retry">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="mobile-card-list d-md-none">
                        <div class="mobile-card-item">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1" style="font-size: 13px;">#PAY-7891</h6>
                                    <div class="vendor-info">
                                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=100" alt="Vendor" class="vendor-avatar">
                                        <div class="vendor-details">
                                            <h6>Tech Store</h6>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge badge-success">Completed</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Amount:</span>
                                <span class="mobile-card-value"><strong>$3,842.00</strong></span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Method:</span>
                                <span class="mobile-card-value"><i class="bi bi-bank"></i> Bank Transfer</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Date:</span>
                                <span class="mobile-card-value">Feb 01, 2026</span>
                            </div>
                            <div class="action-buttons mt-2">
                                <button class="btn-action view"><i class="bi bi-receipt"></i></button>
                                <button class="btn-action edit"><i class="bi bi-download"></i></button>
                            </div>
                        </div>

                        <div class="mobile-card-item">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1" style="font-size: 13px;">#PAY-7889</h6>
                                    <div class="vendor-info">
                                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" alt="Vendor" class="vendor-avatar">
                                        <div class="vendor-details">
                                            <h6>Fashion Hub</h6>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge badge-info">Processing</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Amount:</span>
                                <span class="mobile-card-value"><strong>$2,895.20</strong></span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Method:</span>
                                <span class="mobile-card-value"><i class="bi bi-paypal"></i> PayPal</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Date:</span>
                                <span class="mobile-card-value">Jan 28, 2026</span>
                            </div>
                            <div class="action-buttons mt-2">
                                <button class="btn-action view"><i class="bi bi-geo-alt"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Payout pagination" class="mt-3">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="page-section" id="refunds">
                <div class="page-header">
                    <h2>Refunds</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-arrow-return-left"></i>
                    <h4>Refund Management</h4>
                    <p>Process customer refunds</p>
                </div>
            </div>

            <div class="page-section" id="taxes">
                <div class="page-header">
                    <h2>Tax Management</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-calculator"></i>
                    <h4>Tax Settings</h4>
                    <p>Configure tax rates</p>
                </div>
            </div>

            <div class="page-section" id="shipping">
                <div class="page-header">
                    <h2>Shipping</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-truck"></i>
                    <h4>Shipping Management</h4>
                    <p>Configure shipping methods</p>
                </div>
            </div>

            <div class="page-section" id="reviews">
                <div class="page-header">
                    <h2>Reviews & Ratings</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-star"></i>
                    <h4>Review Management</h4>
                    <p>Manage customer reviews</p>
                </div>
            </div>

            <div class="page-section" id="coupons">
                <div class="page-header">
                    <h2>Coupons & Discounts</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-ticket-perforated"></i>
                    <h4>Coupon Management</h4>
                    <p>Create discount codes</p>
                </div>
            </div>

            <div class="page-section" id="disputes">
                <div class="page-header">
                    <h2>Disputes</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-exclamation-triangle"></i>
                    <h4>Dispute Resolution</h4>
                    <p>Handle customer disputes</p>
                </div>
            </div>

            <div class="page-section" id="support">
                <div class="page-header">
                    <h2>Customer Support</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-headset"></i>
                    <h4>Support Tickets</h4>
                    <p>Manage customer queries</p>
                </div>
            </div>

            <div class="page-section" id="promotions">
                <div class="page-header">
                    <h2>Promotions</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-megaphone"></i>
                    <h4>Marketing Promotions</h4>
                    <p>Create promotional campaigns</p>
                </div>
            </div>

            <div class="page-section" id="email">
                <div class="page-header">
                    <h2>Email Marketing</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-envelope"></i>
                    <h4>Email Campaigns</h4>
                    <p>Send marketing emails</p>
                </div>
            </div>

            <div class="page-section" id="seo">
                <div class="page-header">
                    <h2>SEO Management</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-graph-up-arrow"></i>
                    <h4>SEO Settings</h4>
                    <p>Optimize for search engines</p>
                </div>
            </div>

            <div class="page-section" id="reports">
                <div class="page-header">
                    <h2>Reports</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-graph-up"></i>
                    <h4>Sales Reports</h4>
                    <p>View detailed analytics</p>
                </div>
            </div>

            <div class="page-section" id="analytics">
                <div class="page-header">
                    <h2>Analytics</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-bar-chart"></i>
                    <h4>Analytics Dashboard</h4>
                    <p>Track performance metrics</p>
                </div>
            </div>

            <div class="page-section" id="admins">
                <div class="page-header">
                    <h2>Admin Users</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-shield-check"></i>
                    <h4>Admin Management</h4>
                    <p>Manage admin accounts</p>
                </div>
            </div>

            <div class="page-section" id="settings">
                <div class="page-header">
                    <h2>Settings</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-gear"></i>
                    <h4>System Settings</h4>
                    <p>Configure your platform</p>
                </div>
            </div>

            <div class="page-section" id="notifications">
                <div class="page-header">
                    <h2>Notifications</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-bell"></i>
                    <h4>Notification Settings</h4>
                    <p>Manage notifications</p>
                </div>
            </div>

            <div class="page-section" id="security">
                <div class="page-header">
                    <h2>Security</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-lock"></i>
                    <h4>Security Settings</h4>
                    <p>Protect your platform</p>
                </div>
            </div>

            <div class="page-section" id="backups">
                <div class="page-header">
                    <h2>Backups</h2>
                </div>
                <div class="empty-state">
                    <i class="bi bi-cloud-download"></i>
                    <h4>Backup Management</h4>
                    <p>Secure your data</p>
                </div>
            </div>
        </div>
    </div>
@endsection
