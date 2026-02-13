
@include('admin.pages.header')
@include('admin.pages.sidebar')
    <!-- Main Content -->
    @yield('main-content')
    <!-- Bottom Navigation - Mobile Only -->
    <div class="bottom-nav">
        <a href="#" class="bottom-nav-item active" onclick="showSection('dashboard')">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="#" class="bottom-nav-item" onclick="showSection('orders')">
            <i class="bi bi-cart-check"></i>
            <span>Orders</span>
        </a>
        <a href="#" class="bottom-nav-item" onclick="showSection('products')">
            <i class="bi bi-box-seam"></i>
            <span>Products</span>
        </a>
        <a href="#" class="bottom-nav-item" onclick="showSection('vendors')">
            <i class="bi bi-people"></i>
            <span>Vendors</span>
        </a>
        <a href="#" class="bottom-nav-item" onclick="showSection('settings')">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a>
    </div>

    <!-- Quick Actions - Mobile Only -->
    <div class="quick-actions">
        <button class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus"></i>
        </button>
    </div>

    <!-- Add Vendor Modal -->
    <div class="modal fade" id="addVendorModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Vendor</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="form-label">Store Name</label>
                            <input type="text" class="form-control" placeholder="Enter store name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Owner Name</label>
                            <input type="text" class="form-control" placeholder="Enter owner name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="vendor@email.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" placeholder="+1 234 567 8900">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Commission Rate (%)</label>
                            <input type="number" class="form-control" placeholder="15">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-select">
                                <option>Active</option>
                                <option>Pending</option>
                                <option>Suspended</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: auto;">Cancel</button>
                    <button type="button" class="btn btn-primary">Add Vendor</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down">
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
                        <div class="form-group">
                            <label class="form-label">SKU</label>
                            <input type="text" class="form-control" placeholder="SKU-001234">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3" placeholder="Product description"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select class="form-select">
                                <option>Electronics</option>
                                <option>Fashion</option>
                                <option>Home & Garden</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Price ($)</label>
                            <input type="number" class="form-control" placeholder="99.99">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" placeholder="100">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: auto;">Cancel</button>
                    <button type="button" class="btn btn-primary">Add Product</button>
                </div>
            </div>
        </div>
    </div>

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
                                <option>Wireless Headphones (SKU-001234)</option>
                                <option>Smart Watch (SKU-001235)</option>
                                <option>Running Shoes (SKU-001236)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Warehouse</label>
                            <select class="form-select">
                                <option>Main Warehouse</option>
                                <option>Warehouse A</option>
                                <option>Warehouse B</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Movement Type</label>
                            <select class="form-select">
                                <option>Stock In (Add)</option>
                                <option>Stock Out (Remove)</option>
                                <option>Adjustment</option>
                                <option>Transfer</option>
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

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <script src="{{asset('admin')}}/assets/js/custom.js"></script>
</body>
</html>

