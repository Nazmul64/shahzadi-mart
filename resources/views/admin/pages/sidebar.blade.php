<div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="d-flex align-items-center">
                <i class="bi bi-shop fs-4 text-warning me-2"></i>
                <h4>Admin Panel</h4>
            </div>
            <button class="sidebar-close" onclick="toggleSidebar()">
                <i class="bi bi-x"></i>
            </button>
        </div>

        <div class="sidebar-menu">
            <div class="menu-item active" onclick="showSection('dashboard')">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </div>

            <div class="menu-section-title">E-Commerce Management</div>

            <div class="menu-item" onclick="showSection('vendors')">
                <i class="bi bi-people"></i>
                <span>Vendor Management</span>
            </div>

            <div class="menu-item" onclick="showSection('products')">
                <i class="bi bi-box-seam"></i>
                <span>Product Management</span>
            </div>

            <div class="menu-item" onclick="showSection('orders')">
                <i class="bi bi-cart-check"></i>
                <span>Order Management</span>
            </div>

            <div class="menu-item" onclick="showSection('customers')">
                <i class="bi bi-person-badge"></i>
                <span>Customer Management</span>
            </div>

            <div class="menu-item" onclick="showSection('categories')">
                <i class="bi bi-tags"></i>
                <span>Categories</span>
            </div>

            <div class="menu-item" onclick="showSection('inventory')">
                <i class="bi bi-boxes"></i>
                <span>Inventory Management</span>
            </div>

            <div class="menu-section-title">Financial</div>

            <div class="menu-item" onclick="showSection('payments')">
                <i class="bi bi-credit-card"></i>
                <span>Payments</span>
            </div>

            <div class="menu-item" onclick="showSection('commission')">
                <i class="bi bi-percent"></i>
                <span>Commission</span>
            </div>

            <div class="menu-item" onclick="showSection('payouts')">
                <i class="bi bi-cash-stack"></i>
                <span>Vendor Payouts</span>
            </div>

            <div class="menu-item" onclick="showSection('refunds')">
                <i class="bi bi-arrow-return-left"></i>
                <span>Refunds</span>
            </div>

            <div class="menu-item" onclick="showSection('taxes')">
                <i class="bi bi-calculator"></i>
                <span>Tax Management</span>
            </div>

            <div class="menu-section-title">Operations</div>

            <div class="menu-item" onclick="showSection('shipping')">
                <i class="bi bi-truck"></i>
                <span>Shipping</span>
            </div>

            <div class="menu-item" onclick="showSection('reviews')">
                <i class="bi bi-star"></i>
                <span>Reviews & Ratings</span>
            </div>

            <div class="menu-item" onclick="showSection('coupons')">
                <i class="bi bi-ticket-perforated"></i>
                <span>Coupons & Discounts</span>
            </div>

            <div class="menu-item" onclick="showSection('disputes')">
                <i class="bi bi-exclamation-triangle"></i>
                <span>Disputes</span>
            </div>

            <div class="menu-item" onclick="showSection('support')">
                <i class="bi bi-headset"></i>
                <span>Customer Support</span>
            </div>

            <div class="menu-section-title">Marketing</div>

            <div class="menu-item" onclick="showSection('promotions')">
                <i class="bi bi-megaphone"></i>
                <span>Promotions</span>
            </div>

            <div class="menu-item" onclick="showSection('email')">
                <i class="bi bi-envelope"></i>
                <span>Email Marketing</span>
            </div>

            <div class="menu-item" onclick="showSection('seo')">
                <i class="bi bi-graph-up-arrow"></i>
                <span>SEO Management</span>
            </div>

            <div class="menu-section-title">Analytics</div>

            <div class="menu-item" onclick="showSection('reports')">
                <i class="bi bi-graph-up"></i>
                <span>Reports</span>
            </div>

            <div class="menu-item" onclick="showSection('analytics')">
                <i class="bi bi-bar-chart"></i>
                <span>Analytics</span>
            </div>

            <div class="menu-section-title">Settings</div>

            <div class="menu-item" onclick="showSection('admins')">
                <i class="bi bi-shield-check"></i>
                <span>Admin Users</span>
            </div>

            <div class="menu-item" onclick="showSection('settings')">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </div>

            <div class="menu-item" onclick="showSection('notifications')">
                <i class="bi bi-bell"></i>
                <span>Notifications</span>
            </div>

            <div class="menu-item" onclick="showSection('security')">
                <i class="bi bi-lock"></i>
                <span>Security</span>
            </div>

            <div class="menu-item" onclick="showSection('backups')">
                <i class="bi bi-cloud-download"></i>
                <span>Backups</span>
            </div>
        </div>
    </div>
