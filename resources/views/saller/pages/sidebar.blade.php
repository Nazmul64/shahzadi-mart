    <div class="sidebar" id="sidebar">
        @php
            $gs = \App\Models\Generalsetting::getSettings();
            $siteName = $gs->website_name ?? ($gs->site_name ?? 'Shahzadi Mart');
        @endphp
        <div class="sidebar-header" style="padding: 25px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); background: rgba(0,0,0,0.1);">
            <div class="d-flex align-items-center gap-3">
                <div class="logo-wrapper" style="background: #fff; padding: 5px; border-radius: 8px; display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    @if($gs->header_logo)
                        <img src="{{ asset($gs->header_logo) }}" alt="Logo" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                    @else
                        <i class="bi bi-shop" style="color: #0f172a; font-size: 20px;"></i>
                    @endif
                </div>
                <div class="brand-text">
                    <h5 class="mb-0" style="color: #fff; font-weight: 800; letter-spacing: 0.5px; font-size: 16px;">{{ strtoupper($siteName) }}</h5>
                    <span style="color: var(--primary); font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">Portal</span>
                </div>
            </div>
            <button class="sidebar-close" onclick="toggleSidebar()" style="background: rgba(255,255,255,0.1); border: none; color: #fff; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                <i class="bi bi-chevron-left" style="font-size: 14px;"></i>
            </button>
        </div>

        <div class="sidebar-menu">
            <div class="menu-item has-submenu" onclick="toggleSubmenu(this)">
                <div class="menu-link">
                    <i class="bi bi-bag-fill"></i>
                    <span>Orders Hub</span>
                    <i class="bi bi-chevron-down submenu-arrow"></i>
                </div>
                <div class="submenu">
                    <a href="#" onclick="showSection('orders')">All Orders</a>
                    <a href="#">Pending Orders</a>
                    <a href="#">Processing</a>
                    <a href="#">Shipped</a>
                    <a href="#">Delivered</a>
                    <a href="#">Cancelled</a>
                </div>
            </div>

            <div class="menu-item {{ request()->routeIs('saller.dashboard') ? 'active' : '' }}" onclick="showSection('dashboard')">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </div>
            
            <a href="{{ route('saller.profile.index') }}" class="menu-item {{ request()->routeIs('saller.profile.*') ? 'active' : '' }}" style="text-decoration: none; color: inherit;">
                <i class="bi bi-person-bounding-box"></i>
                <span>My Profile</span>
            </a>

            <div class="menu-item has-submenu" onclick="toggleSubmenu(this)">
                <div class="menu-link">
                    <i class="bi bi-pc-display"></i>
                    <span>POS Management</span>
                    <i class="bi bi-chevron-down submenu-arrow"></i>
                </div>
                <div class="submenu {{ request()->routeIs('saller.pos.*') ? 'open' : '' }}">
                    <a href="{{ route('saller.pos.index') }}" class="{{ request()->routeIs('saller.pos.index') ? 'active' : '' }}">New POS Sale</a>
                    <a href="{{ route('saller.pos.orders') }}" class="{{ request()->routeIs('saller.pos.orders') ? 'active' : '' }}">POS History</a>
                </div>
            </div>

            <div class="menu-item has-submenu" onclick="toggleSubmenu(this)">
                <div class="menu-link">
                    <i class="bi bi-reply-all"></i>
                    <span>Refund Management</span>
                    <i class="bi bi-chevron-down submenu-arrow"></i>
                </div>
                <div class="submenu">
                    <a href="#">Refund Requests</a>
                    <a href="#">Approved Refunds</a>
                    <a href="#">Rejected Refunds</a>
                </div>
            </div>

            <div class="menu-item">
                <i class="bi bi-chat-left-dots-fill"></i>
                <span>Messages</span>
            </div>

            @php
                $unreadAdminChats = \App\Models\SellerAdminChat::where('seller_id', auth()->id())->where('sender', 'admin')->where('is_read', false)->count();
            @endphp
            <a href="{{ route('saller.chat.index') }}" class="menu-item {{ request()->routeIs('saller.chat.*') ? 'active' : '' }}">
                <i class="bi bi-headset"></i>
                <span>Chat with Admin</span>
                @if($unreadAdminChats > 0)
                    <span class="badge rounded-pill bg-danger ms-auto">{{ $unreadAdminChats }}</span>
                @endif
            </a>

            <div class="menu-item has-submenu {{ request()->routeIs('saller.categories.*') || request()->routeIs('saller.subcategories.*') || request()->routeIs('saller.childcategories.*') ? 'open active' : '' }}" onclick="toggleSubmenu(this)">
                <div class="menu-link">
                    <i class="bi bi-layers-fill"></i>
                    <span>Category Management</span>
                    <i class="bi bi-chevron-down submenu-arrow"></i>
                </div>
                <div class="submenu {{ request()->routeIs('saller.categories.*') || request()->routeIs('saller.subcategories.*') || request()->routeIs('saller.childcategories.*') ? 'open' : '' }}">
                    <a href="{{ route('saller.categories.index') }}" class="{{ request()->routeIs('saller.categories.index') ? 'active' : '' }}">Category</a>
                    <a href="{{ route('saller.subcategories.index') }}" class="{{ request()->routeIs('saller.subcategories.index') ? 'active' : '' }}">Sub Category</a>
                    <a href="{{ route('saller.childcategories.index') }}" class="{{ request()->routeIs('saller.childcategories.index') ? 'active' : '' }}">Child Category</a>
                    <a href="#">Request Category</a>
                </div>
            </div>

            <div class="menu-item has-submenu {{ request()->routeIs('saller.products.*') || request()->routeIs('saller.digital_products.*') ? 'open active' : '' }}" onclick="toggleSubmenu(this)">
                <div class="menu-link">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Product Management</span>
                    <i class="bi bi-chevron-down submenu-arrow"></i>
                </div>
                <div class="submenu {{ request()->routeIs('saller.products.*') || request()->routeIs('saller.digital_products.*') ? 'open' : '' }}">
                    <a href="{{ route('saller.products.index') }}" class="{{ request()->routeIs('saller.products.index') ? 'active' : '' }}">All Product</a>
                    <a href="{{ route('saller.products.create') }}" class="{{ request()->routeIs('saller.products.create') ? 'active' : '' }}">Add Product</a>
                    <a href="{{ route('saller.digital_products.index') }}" class="{{ request()->routeIs('saller.digital_products.index') ? 'active' : '' }}">All Digital Product</a>
                    <a href="{{ route('saller.digital_products.create') }}" class="{{ request()->routeIs('saller.digital_products.create') ? 'active' : '' }}">Add Digital Product</a>
                    <a href="#">Product Reviews</a>
                </div>
            </div>

            <div class="menu-item has-submenu {{ request()->routeIs('saller.brands.*') || request()->routeIs('saller.colors.*') || request()->routeIs('saller.sizes.*') || request()->routeIs('saller.units.*') ? 'open active' : '' }}" onclick="toggleSubmenu(this)">
                <div class="menu-link">
                    <i class="bi bi-tags-fill"></i>
                    <span>Product Variant</span>
                    <i class="bi bi-chevron-down submenu-arrow"></i>
                </div>
                <div class="submenu {{ request()->routeIs('saller.brands.*') || request()->routeIs('saller.colors.*') || request()->routeIs('saller.sizes.*') || request()->routeIs('saller.units.*') ? 'open' : '' }}">
                    <a href="{{ route('saller.brands.index') }}" class="{{ request()->routeIs('saller.brands.index') ? 'active' : '' }}">Brand</a>
                    <a href="{{ route('saller.colors.index') }}" class="{{ request()->routeIs('saller.colors.index') ? 'active' : '' }}">Color</a>
                    <a href="{{ route('saller.sizes.index') }}" class="{{ request()->routeIs('saller.sizes.index') ? 'active' : '' }}">Size</a>
                    <a href="{{ route('saller.units.index') }}" class="{{ request()->routeIs('saller.units.index') ? 'active' : '' }}">Unit</a>
                </div>
            </div>

            <div class="menu-item has-submenu" onclick="toggleSubmenu(this)">
                <div class="menu-link">
                    <i class="bi bi-bag-check-fill"></i>
                    <span>Purchase</span>
                    <i class="bi bi-gift-fill text-primary ms-auto" style="font-size: 1.2rem;"></i>
                    <i class="bi bi-chevron-down submenu-arrow"></i>
                </div>
                <div class="submenu">
                    <a href="#">New Purchase</a>
                    <a href="#">Purchase History</a>
                </div>
            </div>

            <div class="menu-item has-submenu {{ request()->routeIs('saller.promotion.*') ? 'open active' : '' }}" onclick="toggleSubmenu(this)">
                <div class="menu-link">
                    <i class="bi bi-megaphone-fill"></i>
                    <span>Promotion Management</span>
                    <i class="bi bi-chevron-down submenu-arrow"></i>
                </div>
                <div class="submenu {{ request()->routeIs('saller.promotion.*') ? 'open' : '' }}">
                    <a href="{{ route('saller.promotion.flash_deals.index') }}" class="{{ request()->routeIs('saller.promotion.flash_deals.*') ? 'active' : '' }}">Flash Deals</a>
                    <a href="{{ route('saller.promotion.banner_setup.index') }}" class="{{ request()->routeIs('saller.promotion.banner_setup.*') ? 'active' : '' }}">Banner Setup</a>
                    <a href="{{ route('saller.promotion.promo_code.index') }}" class="{{ request()->routeIs('saller.promotion.promo_code.*') ? 'active' : '' }}">Promo Code</a>
                </div>
            </div>

            <div class="menu-item has-submenu" onclick="toggleSubmenu(this)">
                <div class="menu-link">
                    <i class="bi bi-people-fill"></i>
                    <span>Employee</span>
                    <i class="bi bi-chevron-down submenu-arrow"></i>
                </div>
                <div class="submenu">
                    <a href="#">All Employees</a>
                    <a href="#">Roles & Permissions</a>
                </div>
            </div>



            <div class="menu-item has-submenu {{ request()->is('saller/suppliers*') ? 'open active' : '' }}" onclick="toggleSubmenu(this)">
                <div class="menu-link">
                    <i class="bi bi-truck"></i>
                    <span>Suppliers</span>
                    <i class="bi bi-chevron-down submenu-arrow"></i>
                </div>
                <div class="submenu {{ request()->is('saller/suppliers*') ? 'open' : '' }}">
                    <a href="{{ route('saller.suppliers.index') }}" class="{{ request()->routeIs('saller.suppliers.index') ? 'active' : '' }}">All Suppliers</a>
                    <a href="{{ route('saller.suppliers.create') }}" class="{{ request()->routeIs('saller.suppliers.create') ? 'active' : '' }}">Add Supplier</a>
                </div>
            </div>

            <div class="menu-section-title">My Shop</div>

            <div class="menu-item has-submenu {{ request()->is('saller/customers*') ? 'open active' : '' }}" onclick="toggleSubmenu(this)">
                <div class="menu-link">
                    <i class="bi bi-person-plus-fill"></i>
                    <span>Customer Management</span>
                    <i class="bi bi-chevron-down submenu-arrow"></i>
                </div>
                <div class="submenu {{ request()->is('saller/customers*') ? 'open' : '' }}">
                    <a href="{{ route('saller.customers.index') }}" class="{{ request()->routeIs('saller.customers.index') ? 'active' : '' }}">All Customers</a>
                    <a href="#">Customer Queries</a>
                </div>
            </div>

            <div class="menu-item" onclick="showSection('payouts')">
                <i class="bi bi-wallet2"></i>
                <span>Withdraws</span>
            </div>

            <div class="menu-item has-submenu" onclick="toggleSubmenu(this)">
                <div class="menu-link">
                    <i class="bi bi-file-earmark-arrow-up-fill"></i>
                    <span>Import/Export</span>
                    <i class="bi bi-chevron-down submenu-arrow"></i>
                </div>
                <div class="submenu">
                    <a href="#">Bulk Import</a>
                    <a href="#">Bulk Export</a>
                </div>
            </div>
        </div>

        <div class="sidebar-footer">
            <i class="bi bi-arrows-fullscreen footer-icon"></i>
            <i class="bi bi-person footer-icon" onclick="showSection('profile')"></i>
            <a href="{{ route('saller.logout') }}" class="footer-icon text-danger">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>

    <script>
        function toggleSubmenu(element) {
            // Close other submenus
            const allItems = document.querySelectorAll('.menu-item.has-submenu');
            allItems.forEach(item => {
                if (item !== element) {
                    item.classList.remove('open');
                }
            });
            
            // Toggle current
            element.classList.toggle('open');
        }
    </script>
