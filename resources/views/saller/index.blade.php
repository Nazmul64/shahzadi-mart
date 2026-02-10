@extends('saller.master')

@section('main-content')
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <div class="navbar-brand">
                    <i class="bi bi-shop"></i>
                    <span class="d-none d-sm-inline">Seller Panel</span>
                </div>
            </div>

            <div class="top-navbar-right">
                <div class="notification-icon">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge">5</span>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content" style="padding-bottom: 80px;">

            <!-- Dashboard Section -->
            <div class="page-section active" id="dashboard">
                <div class="page-header">
                    <h2 class="page-title">Dashboard Overview</h2>
                    <p class="page-subtitle">Welcome back! Here's your store performance</p>
                </div>

                <!-- Stats Cards -->
                <div class="stats-cards">
                    <div class="stat-card primary">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Sales</span>
                            <div class="stat-card-icon primary">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">৳45,230</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+12.5%</span>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Orders</span>
                            <div class="stat-card-icon success">
                                <i class="bi bi-cart-check"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">156</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+8 today</span>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Products</span>
                            <div class="stat-card-icon warning">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">245</div>
                        <div class="stat-card-change">
                            <span>12 low stock</span>
                        </div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Pending Payout</span>
                            <div class="stat-card-icon info">
                                <i class="bi bi-wallet2"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">৳12.3K</div>
                        <div class="stat-card-change">
                            <span>Next: Feb 15</span>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row">
                    <div class="col-lg-8 mb-3">
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Sales Overview</h5>
                            </div>
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-3">
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Order Status</h5>
                            </div>
                            <canvas id="orderChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Management Section -->
            <div class="page-section" id="inventory">
                <div class="page-header">
                    <h2 class="page-title">Inventory Management</h2>
                    <p class="page-subtitle">Track and manage your stock levels</p>
                </div>

                <!-- Inventory Stats -->
                <div class="stats-cards">
                    <div class="stat-card primary">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Products</span>
                            <div class="stat-card-icon primary">
                                <i class="bi bi-boxes"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">245</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+15 this month</span>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-card-header">
                            <span class="stat-card-title">In Stock</span>
                            <div class="stat-card-icon success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">228</div>
                        <div class="stat-card-change">
                            <span>93.1%</span>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Low Stock</span>
                            <div class="stat-card-icon warning">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">12</div>
                        <div class="stat-card-change negative">
                            <i class="bi bi-arrow-down"></i>
                            <span>4.9%</span>
                        </div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Out of Stock</span>
                            <div class="stat-card-icon info">
                                <i class="bi bi-x-circle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">5</div>
                        <div class="stat-card-change">
                            <span>2.0%</span>
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
                                    <option>Home & Living</option>
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
                            <div class="col-12">
                                <button class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Movement Chart -->
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
                <div class="alert-custom alert-warning">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div>
                        <strong>Low Stock Alert!</strong><br>
                        <small>12 products are running low on stock and need restocking soon.</small>
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
                                            <th>Category</th>
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
                                            <td>SKU-001</td>
                                            <td>Electronics</td>
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
                                            <td>SKU-002</td>
                                            <td>Electronics</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td><strong>6</strong></td>
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
                                            <td>SKU-003</td>
                                            <td>Fashion</td>
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
                                            <small class="text-secondary">SKU-001</small>
                                        </div>
                                        <span class="badge badge-success">In Stock</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Category:</span>
                                        <span class="mobile-card-value">Electronics</span>
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
                                            <small class="text-secondary">SKU-002</small>
                                        </div>
                                        <span class="badge badge-warning">Low Stock</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Category:</span>
                                        <span class="mobile-card-value">Electronics</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">In Stock:</span>
                                        <span class="mobile-card-value text-warning">8 units</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Reserved:</span>
                                        <span class="mobile-card-value">2 units</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Available:</span>
                                        <span class="mobile-card-value"><strong>6 units</strong></span>
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
                                <h5 class="data-card-title">Low Stock Items (12)</h5>
                                <button class="btn btn-sm btn-warning">
                                    <i class="bi bi-bell"></i> Set Alerts
                                </button>
                            </div>
                            <div class="alert-custom alert-warning">
                                <i class="bi bi-info-circle"></i>
                                <div>
                                    <strong>Stock Alert:</strong> These products need restocking soon.
                                </div>
                            </div>
                            <div class="mobile-card-list">
                                <div class="mobile-card-item">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100" alt="Product" class="product-img">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0" style="font-size: 14px;">Smart Watch</h6>
                                            <small class="text-secondary">SKU-002</small>
                                        </div>
                                        <span class="badge badge-warning">Low Stock</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Current Stock:</span>
                                        <span class="mobile-card-value text-warning"><strong>8 units</strong></span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Min Required:</span>
                                        <span class="mobile-card-value">20 units</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Shortage:</span>
                                        <span class="mobile-card-value text-danger">-12 units</span>
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
                                <h5 class="data-card-title">Out of Stock Items (5)</h5>
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-exclamation-triangle"></i> Urgent
                                </button>
                            </div>
                            <div class="alert-custom alert-warning">
                                <i class="bi bi-exclamation-triangle"></i>
                                <div>
                                    <strong>Critical Alert:</strong> These products are completely out of stock.
                                </div>
                            </div>
                            <div class="mobile-card-list">
                                <div class="mobile-card-item">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=100" alt="Product" class="product-img">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0" style="font-size: 14px;">Running Shoes</h6>
                                            <small class="text-secondary">SKU-003</small>
                                        </div>
                                        <span class="badge badge-danger">Out of Stock</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Last Sold:</span>
                                        <span class="mobile-card-value">2 days ago</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Pending Orders:</span>
                                        <span class="mobile-card-value text-danger">5 orders</span>
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
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Feb 10, 10:30 AM</td>
                                            <td>Wireless Headphones</td>
                                            <td><span class="badge badge-success"><i class="bi bi-arrow-down"></i> Stock In</span></td>
                                            <td><strong class="text-success">+50</strong></td>
                                            <td>Supplier ABC</td>
                                            <td>New shipment</td>
                                        </tr>
                                        <tr>
                                            <td>Feb 10, 09:15 AM</td>
                                            <td>Smart Watch</td>
                                            <td><span class="badge badge-danger"><i class="bi bi-arrow-up"></i> Stock Out</span></td>
                                            <td><strong class="text-danger">-5</strong></td>
                                            <td>Order #ORD-1234</td>
                                            <td>Customer order</td>
                                        </tr>
                                        <tr>
                                            <td>Feb 09, 04:20 PM</td>
                                            <td>Gaming Keyboard</td>
                                            <td><span class="badge badge-warning"><i class="bi bi-pencil"></i> Adjustment</span></td>
                                            <td><strong class="text-danger">-3</strong></td>
                                            <td>Warehouse</td>
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
                                            <small class="text-secondary">Feb 10, 10:30 AM</small>
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
                                            <small class="text-secondary">Feb 10, 09:15 AM</small>
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

            <!-- Vendor Payouts Section -->
            <div class="page-section" id="payouts">
                <div class="page-header">
                    <h2 class="page-title">Vendor Payouts</h2>
                    <p class="page-subtitle">Track your earnings and payment history</p>
                </div>

                <!-- Payout Stats -->
                <div class="stats-cards">
                    <div class="stat-card primary">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Earnings</span>
                            <div class="stat-card-icon primary">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">৳89,500</div>
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
                        <div class="stat-card-value">৳12,300</div>
                        <div class="stat-card-change">
                            <span>To be paid</span>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Completed</span>
                            <div class="stat-card-icon success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">৳77,200</div>
                        <div class="stat-card-change positive">
                            <span>Received</span>
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
                            <span>5 days left</span>
                        </div>
                    </div>
                </div>

                <!-- Payout Charts -->
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
                                <h5 class="chart-title">Earnings Breakdown</h5>
                            </div>
                            <canvas id="earningsChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pending Payout Alert -->
                <div class="alert-custom alert-info">
                    <i class="bi bi-info-circle-fill fs-5"></i>
                    <div>
                        <strong>Upcoming Payout:</strong> Your next payout of ৳12,300 is scheduled for Feb 15, 2026.
                        <br><small>Funds will be transferred to your registered bank account.</small>
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
                                    <th>Period</th>
                                    <th>Gross Amount</th>
                                    <th>Commission</th>
                                    <th>Net Amount</th>
                                    <th>Method</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#PAY-0015</td>
                                    <td>Jan 2026</td>
                                    <td>৳45,200</td>
                                    <td>৳6,780 (15%)</td>
                                    <td><strong>৳38,420</strong></td>
                                    <td><i class="bi bi-bank"></i> Bank Transfer</td>
                                    <td>Feb 01, 2026</td>
                                    <td><span class="badge badge-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>#PAY-0014</td>
                                    <td>Dec 2025</td>
                                    <td>৳38,900</td>
                                    <td>৳5,835 (15%)</td>
                                    <td><strong>৳33,065</strong></td>
                                    <td><i class="bi bi-bank"></i> Bank Transfer</td>
                                    <td>Jan 01, 2026</td>
                                    <td><span class="badge badge-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>#PAY-0013</td>
                                    <td>Nov 2025</td>
                                    <td>৳32,450</td>
                                    <td>৳4,868 (15%)</td>
                                    <td><strong>৳27,582</strong></td>
                                    <td><i class="bi bi-bank"></i> Bank Transfer</td>
                                    <td>Dec 01, 2025</td>
                                    <td><span class="badge badge-success">Completed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="mobile-card-list d-md-none">
                        <div class="mobile-card-item">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1" style="font-size: 13px;">#PAY-0015</h6>
                                    <small class="text-secondary">Period: Jan 2026</small>
                                </div>
                                <span class="badge badge-success">Completed</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Gross Amount:</span>
                                <span class="mobile-card-value">৳45,200</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Commission (15%):</span>
                                <span class="mobile-card-value text-danger">-৳6,780</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Net Amount:</span>
                                <span class="mobile-card-value"><strong>৳38,420</strong></span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Method:</span>
                                <span class="mobile-card-value"><i class="bi bi-bank"></i> Bank Transfer</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Date:</span>
                                <span class="mobile-card-value">Feb 01, 2026</span>
                            </div>
                        </div>

                        <div class="mobile-card-item">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1" style="font-size: 13px;">#PAY-0014</h6>
                                    <small class="text-secondary">Period: Dec 2025</small>
                                </div>
                                <span class="badge badge-success">Completed</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Gross Amount:</span>
                                <span class="mobile-card-value">৳38,900</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Commission (15%):</span>
                                <span class="mobile-card-value text-danger">-৳5,835</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Net Amount:</span>
                                <span class="mobile-card-value"><strong>৳33,065</strong></span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Method:</span>
                                <span class="mobile-card-value"><i class="bi bi-bank"></i> Bank Transfer</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Date:</span>
                                <span class="mobile-card-value">Jan 01, 2026</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings Summary -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Earnings Summary</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded">
                                <h6 class="text-secondary mb-2">Total Sales (This Month)</h6>
                                <h3 class="text-primary mb-0">৳45,230</h3>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded">
                                <h6 class="text-secondary mb-2">Commission Deducted</h6>
                                <h3 class="text-danger mb-0">৳6,785</h3>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded">
                                <h6 class="text-secondary mb-2">Your Net Earnings</h6>
                                <h3 class="text-success mb-0">৳38,445</h3>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light rounded">
                                <h6 class="text-secondary mb-2">Commission Rate</h6>
                                <h3 class="text-warning mb-0">15%</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Account Info -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Payment Method</h5>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Bank Name</label>
                                <input type="text" class="form-control" value="Dutch-Bangla Bank" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Branch Name</label>
                                <input type="text" class="form-control" value="Dhanmondi Branch" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Account Number</label>
                                <input type="text" class="form-control" value="****-****-1234" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Account Holder Name</label>
                                <input type="text" class="form-control" value="Tech Store BD" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Products Section -->
            <div class="page-section" id="products">
                <div class="page-header">
                    <h2 class="page-title">My Products</h2>
                    <p class="page-subtitle">Manage your product catalog</p>
                </div>

                <!-- Product Stats -->
                <div class="stats-cards">
                    <div class="stat-card primary">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Products</span>
                            <div class="stat-card-icon primary">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">245</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+15 this month</span>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Active</span>
                            <div class="stat-card-icon success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">228</div>
                        <div class="stat-card-change">
                            <span>93.1%</span>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Pending Review</span>
                            <div class="stat-card-icon warning">
                                <i class="bi bi-clock"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">12</div>
                        <div class="stat-card-change">
                            <span>Under review</span>
                        </div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Inactive</span>
                            <div class="stat-card-icon info">
                                <i class="bi bi-x-circle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">5</div>
                        <div class="stat-card-change">
                            <span>2.0%</span>
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
                                    <option>Home & Living</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Status</label>
                                <select class="form-select">
                                    <option>All Status</option>
                                    <option>Active</option>
                                    <option>Inactive</option>
                                    <option>Pending</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products List -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">All Products (245)</h5>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            <i class="bi bi-plus-circle"></i> Add Product
                        </button>
                    </div>

                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Sales</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100" alt="Product" class="product-img">
                                            <div>
                                                <div style="font-weight: 600;">Wireless Headphones</div>
                                                <small class="text-secondary">Premium Sound Quality</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>SKU-001</td>
                                    <td>Electronics</td>
                                    <td><strong>৳1,250</strong></td>
                                    <td>45 units</td>
                                    <td>128</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn-action edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editProductModal">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn-action delete" title="Delete" onclick="deleteProduct('Wireless Headphones')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100" alt="Product" class="product-img">
                                            <div>
                                                <div style="font-weight: 600;">Smart Watch</div>
                                                <small class="text-secondary">Fitness Tracker</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>SKU-002</td>
                                    <td>Electronics</td>
                                    <td><strong>৳3,500</strong></td>
                                    <td>8 units</td>
                                    <td>45</td>
                                    <td><span class="badge badge-warning">Low Stock</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn-action edit" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn-action delete" title="Delete" onclick="deleteProduct('Smart Watch')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=100" alt="Product" class="product-img">
                                            <div>
                                                <div style="font-weight: 600;">Running Shoes</div>
                                                <small class="text-secondary">Athletic Footwear</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>SKU-003</td>
                                    <td>Fashion</td>
                                    <td><strong>৳2,800</strong></td>
                                    <td>0 units</td>
                                    <td>92</td>
                                    <td><span class="badge badge-danger">Out of Stock</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn-action edit" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn-action delete" title="Delete" onclick="deleteProduct('Running Shoes')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=100" alt="Product" class="product-img">
                                            <div>
                                                <div style="font-weight: 600;">Gaming Laptop</div>
                                                <small class="text-secondary">High Performance</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>SKU-004</td>
                                    <td>Electronics</td>
                                    <td><strong>৳85,000</strong></td>
                                    <td>12 units</td>
                                    <td>23</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action view" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn-action edit" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn-action delete" title="Delete" onclick="deleteProduct('Gaming Laptop')">
                                                <i class="bi bi-trash"></i>
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
                                    <small class="text-secondary">SKU-001</small>
                                </div>
                                <span class="badge badge-success">Active</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Category:</span>
                                <span class="mobile-card-value">Electronics</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Price:</span>
                                <span class="mobile-card-value">৳1,250</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Stock:</span>
                                <span class="mobile-card-value">45 units</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Total Sales:</span>
                                <span class="mobile-card-value">128</span>
                            </div>
                            <div class="action-buttons mt-2">
                                <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                <button class="btn-action edit" data-bs-toggle="modal" data-bs-target="#editProductModal"><i class="bi bi-pencil"></i></button>
                                <button class="btn-action delete" onclick="deleteProduct('Wireless Headphones')"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>

                        <div class="mobile-card-item">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100" alt="Product" class="product-img">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0" style="font-size: 14px;">Smart Watch</h6>
                                    <small class="text-secondary">SKU-002</small>
                                </div>
                                <span class="badge badge-warning">Low Stock</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Category:</span>
                                <span class="mobile-card-value">Electronics</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Price:</span>
                                <span class="mobile-card-value">৳3,500</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Stock:</span>
                                <span class="mobile-card-value text-warning">8 units</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Total Sales:</span>
                                <span class="mobile-card-value">45</span>
                            </div>
                            <div class="action-buttons mt-2">
                                <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                <button class="btn-action edit"><i class="bi bi-pencil"></i></button>
                                <button class="btn-action delete" onclick="deleteProduct('Smart Watch')"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Selling Products -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Top Selling Products</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded">
                                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100" alt="Product" class="product-img">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Wireless Headphones</h6>
                                    <small class="text-secondary">128 sales</small>
                                </div>
                                <div class="text-end">
                                    <div style="font-size: 18px; font-weight: 700; color: var(--success-color);">৳160,000</div>
                                    <small class="text-secondary">Revenue</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded">
                                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=100" alt="Product" class="product-img">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Running Shoes</h6>
                                    <small class="text-secondary">92 sales</small>
                                </div>
                                <div class="text-end">
                                    <div style="font-size: 18px; font-weight: 700; color: var(--success-color);">৳257,600</div>
                                    <small class="text-secondary">Revenue</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings Section -->
            <div class="page-section" id="earnings">
                <div class="page-header">
                    <h2 class="page-title">Earnings Overview</h2>
                    <p class="page-subtitle">Track your revenue and income</p>
                </div>

                <!-- Earnings Stats -->
                <div class="stats-cards">
                    <div class="stat-card primary">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Revenue</span>
                            <div class="stat-card-icon primary">
                                <i class="bi bi-graph-up"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">৳542,300</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+18.5% vs last month</span>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Net Earnings</span>
                            <div class="stat-card-icon success">
                                <i class="bi bi-wallet2"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">৳460,955</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>After commission</span>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Commission Paid</span>
                            <div class="stat-card-icon warning">
                                <i class="bi bi-percent"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">৳81,345</div>
                        <div class="stat-card-change">
                            <span>15% rate</span>
                        </div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Avg Order Value</span>
                            <div class="stat-card-icon info">
                                <i class="bi bi-cart"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">৳3,476</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+5.2%</span>
                        </div>
                    </div>
                </div>

                <!-- Earnings Charts -->
                <div class="row mb-3">
                    <div class="col-lg-8 mb-3">
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Monthly Earnings Trend</h5>
                            </div>
                            <canvas id="monthlyEarningsChart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Revenue Breakdown</h5>
                            </div>
                            <canvas id="revenueBreakdownChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Earnings Summary -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Earnings Summary (Last 6 Months)</h5>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download"></i> Export Report
                        </button>
                    </div>

                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Total Sales</th>
                                    <th>Orders</th>
                                    <th>Gross Revenue</th>
                                    <th>Commission (15%)</th>
                                    <th>Net Earnings</th>
                                    <th>Growth</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Jan 2026</strong></td>
                                    <td>156</td>
                                    <td>156</td>
                                    <td>৳542,300</td>
                                    <td>৳81,345</td>
                                    <td><strong>৳460,955</strong></td>
                                    <td><span class="badge badge-success">+18.5%</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Dec 2025</strong></td>
                                    <td>142</td>
                                    <td>142</td>
                                    <td>৳458,900</td>
                                    <td>৳68,835</td>
                                    <td><strong>৳390,065</strong></td>
                                    <td><span class="badge badge-success">+12.3%</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Nov 2025</strong></td>
                                    <td>128</td>
                                    <td>128</td>
                                    <td>৳389,200</td>
                                    <td>৳58,380</td>
                                    <td><strong>৳330,820</strong></td>
                                    <td><span class="badge badge-success">+8.7%</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Oct 2025</strong></td>
                                    <td>118</td>
                                    <td>118</td>
                                    <td>৳345,600</td>
                                    <td>৳51,840</td>
                                    <td><strong>৳293,760</strong></td>
                                    <td><span class="badge badge-warning">+3.2%</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Sep 2025</strong></td>
                                    <td>115</td>
                                    <td>115</td>
                                    <td>৳334,850</td>
                                    <td>৳50,228</td>
                                    <td><strong>৳284,622</strong></td>
                                    <td><span class="badge badge-danger">-2.5%</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Aug 2025</strong></td>
                                    <td>121</td>
                                    <td>121</td>
                                    <td>৳342,700</td>
                                    <td>৳51,405</td>
                                    <td><strong>৳291,295</strong></td>
                                    <td><span class="badge badge-success">+5.8%</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card List -->
                    <div class="mobile-card-list d-md-none">
                        <div class="mobile-card-item">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">Jan 2026</h6>
                                    <small class="text-secondary">156 orders</small>
                                </div>
                                <span class="badge badge-success">+18.5%</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Gross Revenue:</span>
                                <span class="mobile-card-value">৳542,300</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Commission:</span>
                                <span class="mobile-card-value text-danger">-৳81,345</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Net Earnings:</span>
                                <span class="mobile-card-value"><strong>৳460,955</strong></span>
                            </div>
                        </div>

                        <div class="mobile-card-item">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">Dec 2025</h6>
                                    <small class="text-secondary">142 orders</small>
                                </div>
                                <span class="badge badge-success">+12.3%</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Gross Revenue:</span>
                                <span class="mobile-card-value">৳458,900</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Commission:</span>
                                <span class="mobile-card-value text-danger">-৳68,835</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label">Net Earnings:</span>
                                <span class="mobile-card-value"><strong>৳390,065</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue by Category -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Revenue by Category</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="mb-0">Electronics</h6>
                                    <i class="bi bi-laptop fs-4 text-primary"></i>
                                </div>
                                <div class="fs-4 fw-bold text-primary">৳385,000</div>
                                <small class="text-secondary">71% of total revenue</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="mb-0">Fashion</h6>
                                    <i class="bi bi-bag fs-4 text-success"></i>
                                </div>
                                <div class="fs-4 fw-bold text-success">৳124,500</div>
                                <small class="text-secondary">23% of total revenue</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="mb-0">Others</h6>
                                    <i class="bi bi-box fs-4 text-warning"></i>
                                </div>
                                <div class="fs-4 fw-bold text-warning">৳32,800</div>
                                <small class="text-secondary">6% of total revenue</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store Settings Section -->
            <div class="page-section" id="store-settings">
                <div class="page-header">
                    <h2 class="page-title">Store Settings</h2>
                    <p class="page-subtitle">Configure your store information</p>
                </div>

                <!-- Store Information -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Store Information</h5>
                        <button class="btn btn-sm btn-primary">
                            <i class="bi bi-check-circle"></i> Save Changes
                        </button>
                    </div>

                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Store Name</label>
                                    <input type="text" class="form-control" value="Tech Store BD">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Store URL</label>
                                    <div class="input-group">
                                        <span class="input-group-text">marketplace.com/</span>
                                        <input type="text" class="form-control" value="techstore-bd">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Store Description</label>
                            <textarea class="form-control" rows="4">Your one-stop shop for all tech gadgets and electronics. We offer genuine products with warranty and fast delivery across Bangladesh.</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Contact Email</label>
                                    <input type="email" class="form-control" value="contact@techstorebd.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Contact Phone</label>
                                    <input type="tel" class="form-control" value="+880 1712-345678">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Business Address</label>
                            <textarea class="form-control" rows="2">House 45, Road 12, Dhanmondi, Dhaka-1209, Bangladesh</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Store Logo</label>
                                    <input type="file" class="form-control" accept="image/*">
                                    <small class="text-secondary">Recommended: 200x200px, PNG or JPG</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Store Banner</label>
                                    <input type="file" class="form-control" accept="image/*">
                                    <small class="text-secondary">Recommended: 1920x400px, PNG or JPG</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Business Settings -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Business Settings</h5>
                    </div>

                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Business Type</label>
                                    <select class="form-select">
                                        <option>Individual Seller</option>
                                        <option selected>Sole Proprietorship</option>
                                        <option>Partnership</option>
                                        <option>Private Limited Company</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Trade License Number</label>
                                    <input type="text" class="form-control" value="TL-123456-2024">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">TIN Number</label>
                                    <input type="text" class="form-control" value="123-456-7890">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">VAT Registration</label>
                                    <input type="text" class="form-control" value="VAT-987654321">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Payment Settings -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Payment Settings</h5>
                    </div>

                    <form>
                        <h6 class="mb-3">Bank Account Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Bank Name</label>
                                    <select class="form-select">
                                        <option selected>Dutch-Bangla Bank</option>
                                        <option>BRAC Bank</option>
                                        <option>City Bank</option>
                                        <option>Eastern Bank</option>
                                        <option>Islami Bank</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Branch Name</label>
                                    <input type="text" class="form-control" value="Dhanmondi Branch">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control" value="1234567890">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Account Holder Name</label>
                                    <input type="text" class="form-control" value="Tech Store BD">
                                </div>
                            </div>
                        </div>

                        <h6 class="mb-3 mt-4">Mobile Banking (Optional)</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Provider</label>
                                    <select class="form-select">
                                        <option value="">None</option>
                                        <option selected>bKash</option>
                                        <option>Nagad</option>
                                        <option>Rocket</option>
                                        <option>Upay</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="tel" class="form-control" value="+880 1712-345678">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Shipping Settings -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Shipping Settings</h5>
                    </div>

                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Default Shipping Method</label>
                                    <select class="form-select">
                                        <option>Standard Delivery (3-5 days)</option>
                                        <option selected>Express Delivery (1-2 days)</option>
                                        <option>Same Day Delivery</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Shipping Charge (Inside Dhaka)</label>
                                    <input type="number" class="form-control" value="60">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Shipping Charge (Outside Dhaka)</label>
                                    <input type="number" class="form-control" value="120">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Free Shipping Above</label>
                                    <input type="number" class="form-control" value="2000" placeholder="Order amount">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Processing Time</label>
                            <select class="form-select">
                                <option>1 Business Day</option>
                                <option selected>2-3 Business Days</option>
                                <option>3-5 Business Days</option>
                                <option>1 Week</option>
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Notification Settings -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Notification Preferences</h5>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notif1" checked>
                        <label class="form-check-label" for="notif1">
                            Email notifications for new orders
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notif2" checked>
                        <label class="form-check-label" for="notif2">
                            SMS notifications for order status updates
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notif3" checked>
                        <label class="form-check-label" for="notif3">
                            Low stock alerts
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notif4">
                        <label class="form-check-label" for="notif4">
                            Marketing and promotional emails
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notif5" checked>
                        <label class="form-check-label" for="notif5">
                            Customer message notifications
                        </label>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Security Settings</h5>
                    </div>

                    <form>
                        <div class="form-group">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control" placeholder="Enter current password">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" placeholder="Enter new password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" placeholder="Confirm new password">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-shield-check"></i> Update Password
                        </button>
                    </form>

                    <hr class="my-4">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="two-factor" checked>
                        <label class="form-check-label" for="two-factor">
                            <strong>Enable Two-Factor Authentication (2FA)</strong><br>
                            <small class="text-secondary">Add an extra layer of security to your account</small>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Order Management Section -->
            <div class="page-section" id="orders">
                <div class="page-header">
                    <h2 class="page-title">Order Management</h2>
                    <p class="page-subtitle">Track and manage your orders</p>
                </div>

                <!-- Order Stats -->
                <div class="stats-cards">
                    <div class="stat-card primary">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Orders</span>
                            <div class="stat-card-icon primary">
                                <i class="bi bi-cart"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">156</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+8 today</span>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Processing</span>
                            <div class="stat-card-icon warning">
                                <i class="bi bi-clock"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">23</div>
                        <div class="stat-card-change">
                            <span>Need attention</span>
                        </div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Shipped</span>
                            <div class="stat-card-icon info">
                                <i class="bi bi-truck"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">45</div>
                        <div class="stat-card-change">
                            <span>In transit</span>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Delivered</span>
                            <div class="stat-card-icon success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">88</div>
                        <div class="stat-card-change positive">
                            <span>This month</span>
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
                                <label class="form-label">Search Order</label>
                                <input type="text" class="form-control" placeholder="Order ID or customer name...">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Status</label>
                                <select class="form-select">
                                    <option>All Status</option>
                                    <option>Pending</option>
                                    <option>Processing</option>
                                    <option>Shipped</option>
                                    <option>Delivered</option>
                                    <option>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Date Range</label>
                                <select class="form-select">
                                    <option>All Time</option>
                                    <option>Today</option>
                                    <option>Last 7 Days</option>
                                    <option>Last 30 Days</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-orders-tab" data-bs-toggle="tab" data-bs-target="#all-orders" type="button">
                            All Orders
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pending-orders-tab" data-bs-toggle="tab" data-bs-target="#pending-orders" type="button">
                            Pending
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="processing-orders-tab" data-bs-toggle="tab" data-bs-target="#processing-orders" type="button">
                            Processing
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="shipped-orders-tab" data-bs-toggle="tab" data-bs-target="#shipped-orders" type="button">
                            Shipped
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- All Orders Tab -->
                    <div class="tab-pane fade show active" id="all-orders" role="tabpanel">
                        <div class="data-card">
                            <div class="data-card-header">
                                <h5 class="data-card-title">All Orders (156)</h5>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download"></i> Export
                                </button>
                            </div>

                            <!-- Desktop Table -->
                            <div class="table-responsive d-none d-md-block">
                                <table class="table data-table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Product</th>
                                            <th>Amount</th>
                                            <th>Payment</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>#ORD-1234</strong></td>
                                            <td>
                                                <div>
                                                    <div style="font-weight: 600;">John Doe</div>
                                                    <small class="text-secondary">john@email.com</small>
                                                </div>
                                            </td>
                                            <td>Wireless Headphones</td>
                                            <td><strong>৳1,250</strong></td>
                                            <td><span class="badge badge-success">Paid</span></td>
                                            <td><span class="badge badge-warning">Processing</span></td>
                                            <td>Feb 10, 2026</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-action view" title="View Details" data-bs-toggle="modal" data-bs-target="#orderDetailsModal">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn-action edit" title="Update Status" data-bs-toggle="modal" data-bs-target="#updateOrderModal">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>#ORD-1235</strong></td>
                                            <td>
                                                <div>
                                                    <div style="font-weight: 600;">Sarah Wilson</div>
                                                    <small class="text-secondary">sarah@email.com</small>
                                                </div>
                                            </td>
                                            <td>Smart Watch</td>
                                            <td><strong>৳3,500</strong></td>
                                            <td><span class="badge badge-success">Paid</span></td>
                                            <td><span class="badge badge-info">Shipped</span></td>
                                            <td>Feb 09, 2026</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-action view" title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn-action edit" title="Update Status">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>#ORD-1236</strong></td>
                                            <td>
                                                <div>
                                                    <div style="font-weight: 600;">Mike Johnson</div>
                                                    <small class="text-secondary">mike@email.com</small>
                                                </div>
                                            </td>
                                            <td>Running Shoes</td>
                                            <td><strong>৳2,800</strong></td>
                                            <td><span class="badge badge-success">Paid</span></td>
                                            <td><span class="badge badge-success">Delivered</span></td>
                                            <td>Feb 08, 2026</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-action view" title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>#ORD-1237</strong></td>
                                            <td>
                                                <div>
                                                    <div style="font-weight: 600;">Emily Davis</div>
                                                    <small class="text-secondary">emily@email.com</small>
                                                </div>
                                            </td>
                                            <td>Gaming Laptop</td>
                                            <td><strong>৳85,000</strong></td>
                                            <td><span class="badge badge-warning">Pending</span></td>
                                            <td><span class="badge badge-primary">Pending</span></td>
                                            <td>Feb 10, 2026</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-action view" title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn-action edit" title="Update Status">
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
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1" style="font-size: 14px;">#ORD-1234</h6>
                                            <small class="text-secondary">John Doe</small>
                                        </div>
                                        <span class="badge badge-warning">Processing</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Product:</span>
                                        <span class="mobile-card-value">Wireless Headphones</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Amount:</span>
                                        <span class="mobile-card-value">৳1,250</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Payment:</span>
                                        <span class="badge badge-success">Paid</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Date:</span>
                                        <span class="mobile-card-value">Feb 10, 2026</span>
                                    </div>
                                    <div class="action-buttons mt-2">
                                        <button class="btn-action view" data-bs-toggle="modal" data-bs-target="#orderDetailsModal"><i class="bi bi-eye"></i></button>
                                        <button class="btn-action edit" data-bs-toggle="modal" data-bs-target="#updateOrderModal"><i class="bi bi-pencil"></i></button>
                                    </div>
                                </div>

                                <div class="mobile-card-item">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1" style="font-size: 14px;">#ORD-1235</h6>
                                            <small class="text-secondary">Sarah Wilson</small>
                                        </div>
                                        <span class="badge badge-info">Shipped</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Product:</span>
                                        <span class="mobile-card-value">Smart Watch</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Amount:</span>
                                        <span class="mobile-card-value">৳3,500</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Payment:</span>
                                        <span class="badge badge-success">Paid</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Date:</span>
                                        <span class="mobile-card-value">Feb 09, 2026</span>
                                    </div>
                                    <div class="action-buttons mt-2">
                                        <button class="btn-action view"><i class="bi bi-eye"></i></button>
                                        <button class="btn-action edit"><i class="bi bi-pencil"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Orders Tab -->
                    <div class="tab-pane fade" id="pending-orders" role="tabpanel">
                        <div class="data-card">
                            <div class="data-card-header">
                                <h5 class="data-card-title">Pending Orders (10)</h5>
                            </div>
                            <div class="alert-custom alert-warning">
                                <i class="bi bi-clock-history"></i>
                                <div>
                                    <strong>Action Required:</strong> These orders are awaiting payment confirmation.
                                </div>
                            </div>
                            <div class="mobile-card-list">
                                <div class="mobile-card-item">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1" style="font-size: 14px;">#ORD-1237</h6>
                                            <small class="text-secondary">Emily Davis</small>
                                        </div>
                                        <span class="badge badge-primary">Pending</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Product:</span>
                                        <span class="mobile-card-value">Gaming Laptop</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Amount:</span>
                                        <span class="mobile-card-value">৳85,000</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Payment:</span>
                                        <span class="badge badge-warning">Pending</span>
                                    </div>
                                    <div class="action-buttons mt-2">
                                        <button class="btn btn-sm btn-primary">Confirm Payment</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Processing Orders Tab -->
                    <div class="tab-pane fade" id="processing-orders" role="tabpanel">
                        <div class="data-card">
                            <div class="data-card-header">
                                <h5 class="data-card-title">Processing Orders (23)</h5>
                            </div>
                            <div class="alert-custom alert-info">
                                <i class="bi bi-info-circle"></i>
                                <div>
                                    <strong>In Progress:</strong> These orders are being prepared for shipment.
                                </div>
                            </div>
                            <div class="mobile-card-list">
                                <div class="mobile-card-item">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1" style="font-size: 14px;">#ORD-1234</h6>
                                            <small class="text-secondary">John Doe</small>
                                        </div>
                                        <span class="badge badge-warning">Processing</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Product:</span>
                                        <span class="mobile-card-value">Wireless Headphones</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Amount:</span>
                                        <span class="mobile-card-value">৳1,250</span>
                                    </div>
                                    <div class="action-buttons mt-2">
                                        <button class="btn btn-sm btn-primary">Mark as Shipped</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipped Orders Tab -->
                    <div class="tab-pane fade" id="shipped-orders" role="tabpanel">
                        <div class="data-card">
                            <div class="data-card-header">
                                <h5 class="data-card-title">Shipped Orders (45)</h5>
                            </div>
                            <div class="alert-custom alert-success">
                                <i class="bi bi-truck"></i>
                                <div>
                                    <strong>In Transit:</strong> These orders are on their way to customers.
                                </div>
                            </div>
                            <div class="mobile-card-list">
                                <div class="mobile-card-item">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1" style="font-size: 14px;">#ORD-1235</h6>
                                            <small class="text-secondary">Sarah Wilson</small>
                                        </div>
                                        <span class="badge badge-info">Shipped</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Product:</span>
                                        <span class="mobile-card-value">Smart Watch</span>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label">Tracking:</span>
                                        <span class="mobile-card-value">TRK-123456789</span>
                                    </div>
                                    <div class="action-buttons mt-2">
                                        <button class="btn btn-sm btn-outline-primary">Track Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews & Ratings Section -->
            <div class="page-section" id="reviews">
                <div class="page-header">
                    <h2 class="page-title">Reviews & Ratings</h2>
                    <p class="page-subtitle">Customer feedback and ratings</p>
                </div>

                <!-- Review Stats -->
                <div class="stats-cards">
                    <div class="stat-card primary">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Reviews</span>
                            <div class="stat-card-icon primary">
                                <i class="bi bi-star"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">284</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+12 this week</span>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Average Rating</span>
                            <div class="stat-card-icon success">
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">4.6</div>
                        <div class="stat-card-change">
                            <span>Out of 5.0</span>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Pending Reply</span>
                            <div class="stat-card-icon warning">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">8</div>
                        <div class="stat-card-change">
                            <span>Need response</span>
                        </div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-card-header">
                            <span class="stat-card-title">5 Star Reviews</span>
                            <div class="stat-card-icon info">
                                <i class="bi bi-emoji-smile"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">198</div>
                        <div class="stat-card-change positive">
                            <span>69.7%</span>
                        </div>
                    </div>
                </div>

                <!-- Rating Distribution -->
                <div class="row mb-3">
                    <div class="col-lg-8 mb-3">
                        <div class="data-card">
                            <div class="data-card-header">
                                <h5 class="data-card-title">Rating Distribution</h5>
                            </div>
                            <div class="p-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div style="width: 60px; font-weight: 600;">5 Stars</div>
                                    <div class="flex-grow-1 mx-3">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" style="width: 69.7%; background: #10b981;" role="progressbar">198</div>
                                        </div>
                                    </div>
                                    <div style="width: 50px; text-align: right;">69.7%</div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div style="width: 60px; font-weight: 600;">4 Stars</div>
                                    <div class="flex-grow-1 mx-3">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" style="width: 18.3%; background: #3b82f6;" role="progressbar">52</div>
                                        </div>
                                    </div>
                                    <div style="width: 50px; text-align: right;">18.3%</div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div style="width: 60px; font-weight: 600;">3 Stars</div>
                                    <div class="flex-grow-1 mx-3">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" style="width: 7.4%; background: #f59e0b;" role="progressbar">21</div>
                                        </div>
                                    </div>
                                    <div style="width: 50px; text-align: right;">7.4%</div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div style="width: 60px; font-weight: 600;">2 Stars</div>
                                    <div class="flex-grow-1 mx-3">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" style="width: 2.8%; background: #f97316;" role="progressbar">8</div>
                                        </div>
                                    </div>
                                    <div style="width: 50px; text-align: right;">2.8%</div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div style="width: 60px; font-weight: 600;">1 Star</div>
                                    <div class="flex-grow-1 mx-3">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" style="width: 1.8%; background: #ef4444;" role="progressbar">5</div>
                                        </div>
                                    </div>
                                    <div style="width: 50px; text-align: right;">1.8%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-3">
                        <div class="data-card text-center p-4">
                            <div style="font-size: 64px; font-weight: 700; color: var(--primary-color);">4.6</div>
                            <div class="mb-2">
                                <i class="bi bi-star-fill" style="color: #f59e0b; font-size: 20px;"></i>
                                <i class="bi bi-star-fill" style="color: #f59e0b; font-size: 20px;"></i>
                                <i class="bi bi-star-fill" style="color: #f59e0b; font-size: 20px;"></i>
                                <i class="bi bi-star-fill" style="color: #f59e0b; font-size: 20px;"></i>
                                <i class="bi bi-star-half" style="color: #f59e0b; font-size: 20px;"></i>
                            </div>
                            <div class="text-secondary">Based on 284 reviews</div>
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
                            <div class="col-6">
                                <label class="form-label">Rating</label>
                                <select class="form-select">
                                    <option>All Ratings</option>
                                    <option>5 Stars</option>
                                    <option>4 Stars</option>
                                    <option>3 Stars</option>
                                    <option>2 Stars</option>
                                    <option>1 Star</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Status</label>
                                <select class="form-select">
                                    <option>All Status</option>
                                    <option>Pending Reply</option>
                                    <option>Replied</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary">Apply Filters</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews List -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h5 class="data-card-title">Customer Reviews</h5>
                    </div>

                    <!-- Review Item -->
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div style="font-weight: 600;">John Doe</div>
                                <div class="mb-1">
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                </div>
                            </div>
                            <small class="text-secondary">2 days ago</small>
                        </div>
                        <div class="mb-2">
                            <strong>Product:</strong> Wireless Headphones
                        </div>
                        <p class="mb-2" style="font-size: 14px;">Amazing sound quality! The noise cancellation works perfectly. Very comfortable to wear for long hours. Highly recommended!</p>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#replyReviewModal">
                            <i class="bi bi-reply"></i> Reply
                        </button>
                    </div>

                    <!-- Review Item -->
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div style="font-weight: 600;">Sarah Wilson</div>
                                <div class="mb-1">
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star" style="color: #e5e7eb;"></i>
                                </div>
                            </div>
                            <small class="text-secondary">5 days ago</small>
                        </div>
                        <div class="mb-2">
                            <strong>Product:</strong> Smart Watch
                        </div>
                        <p class="mb-2" style="font-size: 14px;">Good product overall. Battery life could be better. Fitness tracking features are excellent.</p>
                        <div class="bg-light p-3 rounded mb-2">
                            <div style="font-weight: 600; font-size: 12px;" class="mb-1">
                                <i class="bi bi-shop"></i> Seller Response:
                            </div>
                            <p class="mb-0" style="font-size: 13px;">Thank you for your feedback! We're glad you're enjoying the fitness features. For better battery life, try adjusting the display brightness and background refresh settings.</p>
                            <small class="text-secondary">3 days ago</small>
                        </div>
                    </div>

                    <!-- Review Item -->
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div style="font-weight: 600;">Mike Johnson</div>
                                <div class="mb-1">
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star" style="color: #e5e7eb;"></i>
                                    <i class="bi bi-star" style="color: #e5e7eb;"></i>
                                </div>
                            </div>
                            <small class="text-secondary">1 week ago</small>
                        </div>
                        <div class="mb-2">
                            <strong>Product:</strong> Running Shoes
                        </div>
                        <p class="mb-2" style="font-size: 14px;">Comfortable shoes but sizing runs a bit small. Quality is good for the price.</p>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#replyReviewModal">
                            <i class="bi bi-reply"></i> Reply
                        </button>
                    </div>
                </div>
            </div>

            <!-- Messages Section -->
            <div class="page-section" id="messages">
                <div class="page-header">
                    <h2 class="page-title">Customer Messages</h2>
                    <p class="page-subtitle">Communicate with your customers</p>
                </div>

                <!-- Message Stats -->
                <div class="stats-cards">
                    <div class="stat-card primary">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Messages</span>
                            <div class="stat-card-icon primary">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">45</div>
                        <div class="stat-card-change positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+3 today</span>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Unread</span>
                            <div class="stat-card-icon warning">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">12</div>
                        <div class="stat-card-change">
                            <span>Need attention</span>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Replied</span>
                            <div class="stat-card-icon success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">33</div>
                        <div class="stat-card-change">
                            <span>This week</span>
                        </div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-card-header">
                            <span class="stat-card-title">Avg Response Time</span>
                            <div class="stat-card-icon info">
                                <i class="bi bi-clock"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">2.5h</div>
                        <div class="stat-card-change positive">
                            <span>Fast reply</span>
                        </div>
                    </div>
                </div>

                <!-- Messages List -->
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <div class="data-card" style="height: 600px; overflow-y: auto;">
                            <div class="data-card-header">
                                <h5 class="data-card-title">Conversations</h5>
                            </div>

                            <!-- Message Thread -->
                            <div class="border-bottom p-3 bg-light" style="cursor: pointer;" onclick="selectConversation('John Doe')">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <div style="font-weight: 600;">John Doe</div>
                                    <small class="text-secondary">2h ago</small>
                                </div>
                                <div style="font-size: 13px; color: var(--text-secondary);">When will my order be shipped?</div>
                                <span class="badge badge-primary mt-1">New</span>
                            </div>

                            <div class="border-bottom p-3" style="cursor: pointer;" onclick="selectConversation('Sarah Wilson')">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <div style="font-weight: 600;">Sarah Wilson</div>
                                    <small class="text-secondary">5h ago</small>
                                </div>
                                <div style="font-size: 13px; color: var(--text-secondary);">Thank you for the quick delivery!</div>
                            </div>

                            <div class="border-bottom p-3" style="cursor: pointer;" onclick="selectConversation('Mike Johnson')">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <div style="font-weight: 600;">Mike Johnson</div>
                                    <small class="text-secondary">1d ago</small>
                                </div>
                                <div style="font-size: 13px; color: var(--text-secondary);">Do you have this in size 42?</div>
                                <span class="badge badge-primary mt-1">New</span>
                            </div>

                            <div class="border-bottom p-3" style="cursor: pointer;" onclick="selectConversation('Emily Davis')">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <div style="font-weight: 600;">Emily Davis</div>
                                    <small class="text-secondary">2d ago</small>
                                </div>
                                <div style="font-size: 13px; color: var(--text-secondary);">Can I get a discount on bulk order?</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 mb-3">
                        <div class="data-card" style="height: 600px; display: flex; flex-direction: column;">
                            <div class="data-card-header">
                                <h5 class="data-card-title">John Doe</h5>
                                <small class="text-secondary">Order #ORD-1234</small>
                            </div>

                            <!-- Chat Messages -->
                            <div class="flex-grow-1 p-3" style="overflow-y: auto; background: #f8f9fa;">
                                <!-- Customer Message -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-start gap-2">
                                        <div class="bg-white p-3 rounded" style="max-width: 70%;">
                                            <div style="font-size: 14px;">Hi, I placed an order yesterday. When will it be shipped?</div>
                                            <small class="text-secondary">2h ago</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seller Message -->
                                <div class="mb-3 d-flex justify-content-end">
                                    <div class="bg-primary text-white p-3 rounded" style="max-width: 70%;">
                                        <div style="font-size: 14px;">Hello! Thank you for your order. We're processing it now and it will be shipped within 24 hours.</div>
                                        <small style="opacity: 0.8;">1h ago</small>
                                    </div>
                                </div>

                                <!-- Customer Message -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-start gap-2">
                                        <div class="bg-white p-3 rounded" style="max-width: 70%;">
                                            <div style="font-size: 14px;">Great! Can you provide tracking information once shipped?</div>
                                            <small class="text-secondary">30m ago</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Message Input -->
                            <div class="p-3 border-top">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Type your message..." id="messageInput">
                                    <button class="btn btn-primary" onclick="sendMessage()">
                                        <i class="bi bi-send"></i> Send
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-section" id="profile">
                <div class="page-header">
                    <h2 class="page-title">Profile Settings</h2>
                </div>
                <div class="data-card text-center py-5">
                    <i class="bi bi-person-circle" style="font-size: 48px; color: var(--text-secondary);"></i>
                    <h4 class="mt-3">Account Profile</h4>
                    <p class="text-secondary">Update your personal information</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="#" class="bottom-nav-item active" onclick="showSection('dashboard')">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="#" class="bottom-nav-item" onclick="showSection('inventory')">
            <i class="bi bi-boxes"></i>
            <span>Inventory</span>
        </a>
        <a href="#" class="bottom-nav-item" onclick="showSection('orders')">
            <i class="bi bi-cart-check"></i>
            <span>Orders</span>
        </a>
        <a href="#" class="bottom-nav-item" onclick="showSection('payouts')">
            <i class="bi bi-wallet2"></i>
            <span>Payouts</span>
        </a>
        <a href="#" class="bottom-nav-item" onclick="showSection('profile')">
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
        </a>
    </div>

    <!-- Floating Action Button -->
    <button class="fab" data-bs-toggle="modal" data-bs-target="#updateStockModal">
        <i class="bi bi-plus"></i>
    </button>

    <!-- Update Stock Modal -->
    <div class="modal fade" id="updateStockModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Stock</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="form-label">Product</label>
                            <select class="form-select">
                                <option>Select a product...</option>
                                <option>Wireless Headphones (SKU-001)</option>
                                <option>Smart Watch (SKU-002)</option>
                                <option>Running Shoes (SKU-003)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Movement Type</label>
                            <select class="form-select">
                                <option>Stock In (Add)</option>
                                <option>Stock Out (Remove)</option>
                                <option>Adjustment</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" placeholder="Enter quantity">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Reason/Note</label>
                            <textarea class="form-control" rows="3" placeholder="Reason for stock change..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: auto;">Cancel</button>
                    <button type="button" class="btn btn-primary">Update Stock</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" placeholder="Enter product name">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">SKU</label>
                                    <input type="text" class="form-control" placeholder="SKU-00X">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <select class="form-select">
                                        <option>Electronics</option>
                                        <option>Fashion</option>
                                        <option>Home & Living</option>
                                        <option>Sports</option>
                                        <option>Beauty</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="4" placeholder="Product description..."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Price (৳)</label>
                                    <input type="number" class="form-control" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Stock Quantity</label>
                                    <input type="number" class="form-control" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Weight (kg)</label>
                                    <input type="number" class="form-control" placeholder="0.0" step="0.1">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Product Images</label>
                            <input type="file" class="form-control" accept="image/*" multiple>
                            <small class="text-secondary">You can upload multiple images</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-select">
                                <option selected>Active</option>
                                <option>Inactive</option>
                                <option>Draft</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: auto;">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveProduct()">Add Product</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" value="Wireless Headphones">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">SKU</label>
                                    <input type="text" class="form-control" value="SKU-001" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <select class="form-select">
                                        <option selected>Electronics</option>
                                        <option>Fashion</option>
                                        <option>Home & Living</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="4">Premium Sound Quality Wireless Headphones with noise cancellation</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Price (৳)</label>
                                    <input type="number" class="form-control" value="1250">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Stock Quantity</label>
                                    <input type="number" class="form-control" value="45">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Weight (kg)</label>
                                    <input type="number" class="form-control" value="0.3" step="0.1">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-select">
                                <option selected>Active</option>
                                <option>Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: auto;">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="updateProduct()">Update Product</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details - #ORD-1234</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="mb-2">Customer Information</h6>
                            <div class="bg-light p-3 rounded">
                                <div class="mb-2"><strong>Name:</strong> John Doe</div>
                                <div class="mb-2"><strong>Email:</strong> john@email.com</div>
                                <div class="mb-2"><strong>Phone:</strong> +880 1712-345678</div>
                                <div><strong>Address:</strong> House 45, Road 12, Dhanmondi, Dhaka-1209</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="mb-2">Order Information</h6>
                            <div class="bg-light p-3 rounded">
                                <div class="mb-2"><strong>Order ID:</strong> #ORD-1234</div>
                                <div class="mb-2"><strong>Date:</strong> Feb 10, 2026</div>
                                <div class="mb-2"><strong>Status:</strong> <span class="badge badge-warning">Processing</span></div>
                                <div><strong>Payment:</strong> <span class="badge badge-success">Paid</span></div>
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-2">Order Items</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Wireless Headphones</td>
                                    <td>৳1,250</td>
                                    <td>1</td>
                                    <td>৳1,250</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <div class="bg-light p-3 rounded">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <strong>৳1,250</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <strong>৳60</strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong style="font-size: 18px; color: var(--primary-color);">৳1,310</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: auto;">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateOrderModal">
                        <i class="bi bi-pencil"></i> Update Status
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Order Status Modal -->
    <div class="modal fade" id="updateOrderModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Order Status</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="form-label">Order ID</label>
                            <input type="text" class="form-control" value="#ORD-1234" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Current Status</label>
                            <input type="text" class="form-control" value="Processing" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Update Status To</label>
                            <select class="form-select" id="orderStatus">
                                <option>Processing</option>
                                <option>Shipped</option>
                                <option>Delivered</option>
                                <option>Cancelled</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tracking Number (Optional)</label>
                            <input type="text" class="form-control" placeholder="Enter tracking number">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" rows="3" placeholder="Add any notes about this status update..."></textarea>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="notifyCustomer" checked>
                            <label class="form-check-label" for="notifyCustomer">
                                Notify customer via email
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: auto;">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="updateOrderStatus()">Update Status</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Review Modal -->
    <div class="modal fade" id="replyReviewModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reply to Review</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div style="font-weight: 600;">John Doe</div>
                                <div class="mb-1">
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                    <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                </div>
                            </div>
                            <small class="text-secondary">2 days ago</small>
                        </div>
                        <p class="mb-0" style="font-size: 14px;">Amazing sound quality! The noise cancellation works perfectly. Very comfortable to wear for long hours. Highly recommended!</p>
                    </div>

                    <form>
                        <div class="form-group">
                            <label class="form-label">Your Response</label>
                            <textarea class="form-control" rows="4" placeholder="Write your response to this review..."></textarea>
                        </div>

                        <div class="alert-custom alert-info">
                            <i class="bi bi-info-circle"></i>
                            <div>
                                <small>Your response will be visible to all customers viewing this review.</small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: auto;">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="replyToReview()">Post Reply</button>
                </div>
            </div>
        </div>
    </div>
@endsection
