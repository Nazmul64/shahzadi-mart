    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="d-flex align-items-center">
                <i class="bi bi-shop fs-4 text-warning me-2"></i>
                <h4>Seller Dashboard</h4>
            </div>
            <button class="sidebar-close" onclick="toggleSidebar()">
                <i class="bi bi-x"></i>
            </button>
        </div>

        <div class="seller-profile">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" alt="Seller" class="seller-avatar">
            <div class="seller-name">Tech Store BD</div>
            <div class="seller-store">@techstore-bd</div>
            <span class="seller-badge"><i class="bi bi-patch-check-fill"></i> Verified</span>
        </div>

        <div class="sidebar-menu">
            <div class="menu-item active" onclick="showSection('dashboard')">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </div>

            <div class="menu-section-title">Store Management</div>

            <div class="menu-item" onclick="showSection('products')">
                <i class="bi bi-box-seam"></i>
                <span>My Products</span>
            </div>

            <div class="menu-item" onclick="showSection('orders')">
                <i class="bi bi-cart-check"></i>
                <span>Orders</span>
            </div>

            <div class="menu-item" onclick="showSection('inventory')">
                <i class="bi bi-boxes"></i>
                <span>Inventory</span>
            </div>

            <div class="menu-section-title">Financial</div>

            <div class="menu-item" onclick="showSection('earnings')">
                <i class="bi bi-cash-coin"></i>
                <span>Earnings</span>
            </div>

            <div class="menu-item" onclick="showSection('payouts')">
                <i class="bi bi-wallet2"></i>
                <span>Payouts</span>
            </div>

            <div class="menu-section-title">Settings</div>

            <div class="menu-item" onclick="showSection('store-settings')">
                <i class="bi bi-shop-window"></i>
                <span>Store Settings</span>
            </div>

            <div class="menu-item" onclick="showSection('profile')">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </div>
        </div>
    </div>
