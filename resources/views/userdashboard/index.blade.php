@include('frontend.pages.header')

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap');

.oc-shell-wrapper {
    background: #0a0a0c;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #ffffff;
    display: flex;
    flex-direction: column;
}

.oc-shell {
    display: flex;
    flex: 1;
    position: relative;
}

:root {
    --oc-bg:            #0a0a0c;
    --oc-surface:       #141418;
    --oc-surface-alt:   #1c1c22;
    --oc-border:        rgba(255, 255, 255, 0.08);
    --oc-primary:       #e8192c;
    --oc-primary-hover: #c8102e;
    --oc-text:          #ffffff;
    --oc-text-muted:    #a0a0ab;
    --oc-text-dim:      #71717a;
    --oc-sidebar-w:     280px;
}

/* ── SIDEBAR ── */
.oc-sidebar {
    width: var(--oc-sidebar-w);
    background: var(--oc-surface);
    border-right: 1px solid var(--oc-border);
    display: flex;
    flex-direction: column;
    transition: all .4s cubic-bezier(0.4, 0, 0.2, 1);
    flex-shrink: 0;
}

@media (max-width: 1024px) {
    .oc-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 1001;
        transform: translateX(-100%);
    }
    .oc-sidebar.open {
        transform: translateX(0);
        box-shadow: 20px 0 50px rgba(0,0,0,0.8);
    }
}

.oc-sidebar-header {
    padding: 30px 24px;
    border-bottom: 1px solid var(--oc-border);
}

.oc-profile-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 12px;
}

.oc-avatar-container {
    position: relative;
    width: 80px;
    height: 80px;
}

.oc-avatar-main {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 3px solid var(--oc-border);
    padding: 3px;
    background: linear-gradient(135deg, var(--oc-primary), #8b5cf6);
    overflow: hidden;
}

.oc-avatar-main img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.oc-avatar-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: 800;
    background: var(--oc-surface-alt);
    color: var(--oc-text);
}

.oc-user-info h3 {
    font-family: 'Outfit', sans-serif;
    font-size: 16px;
    font-weight: 700;
    margin: 0;
}

.oc-user-info span {
    font-size: 11px;
    color: var(--oc-text-dim);
    text-transform: uppercase;
}

/* ── NAV ── */
.oc-nav {
    flex: 1;
    padding: 20px 12px;
    overflow-y: auto;
}

.oc-nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    border-radius: 10px;
    color: var(--oc-text-muted);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all .3s;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    margin-bottom: 4px;
}

.oc-nav-item:hover {
    background: var(--oc-surface-alt);
    color: var(--oc-text);
}

.oc-nav-item.active {
    background: rgba(232, 25, 44, 0.1);
    color: var(--oc-primary);
    font-weight: 700;
}

.oc-nav-item i {
    width: 20px;
    text-align: center;
    font-size: 16px;
}

/* ── MAIN CONTENT ── */
.oc-main {
    flex: 1;
    padding: 30px;
    background: #0a0a0c;
    overflow-x: hidden;
}

@media (max-width: 1024px) {
    .oc-main {
        padding: 20px;
    }
}

.oc-top-bar {
    display: none;
    align-items: center;
    justify-content: space-between;
    padding: 15px 20px;
    background: var(--oc-surface);
    border-bottom: 1px solid var(--oc-border);
    margin: -30px -30px 30px -30px;
}

@media (max-width: 1024px) {
    .oc-top-bar {
        display: flex;
        margin: -20px -20px 20px -20px;
    }
}

.oc-menu-toggle {
    background: none;
    border: 1px solid var(--oc-border);
    color: #fff;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
}

/* ── STATS ── */
.oc-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 30px;
}

.oc-stat-card {
    background: var(--oc-surface);
    border: 1px solid var(--oc-border);
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: transform .3s;
}

.oc-stat-card:hover { transform: translateY(-3px); }

.oc-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: var(--oc-surface-alt);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: var(--oc-primary);
}

.oc-stat-value {
    font-size: 22px;
    font-weight: 800;
    font-family: 'Outfit', sans-serif;
}

.oc-stat-label {
    font-size: 12px;
    color: var(--oc-text-dim);
    font-weight: 600;
    text-transform: uppercase;
}

/* ── CARDS ── */
.oc-card {
    background: var(--oc-surface);
    border: 1px solid var(--oc-border);
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
}

.oc-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--oc-border);
}

.oc-card-title {
    font-size: 18px;
    font-weight: 700;
    font-family: 'Outfit', sans-serif;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ── FORMS ── */
.oc-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

@media (max-width: 640px) {
    .oc-form-grid { grid-template-columns: 1fr; }
}

.oc-input {
    width: 100%;
    background: var(--oc-surface-alt);
    border: 1px solid var(--oc-border);
    border-radius: 10px;
    padding: 12px 16px;
    color: #fff;
    outline: none;
    transition: border-color .3s;
}

.oc-input:focus { border-color: var(--oc-primary); }

.oc-btn-save {
    background: var(--oc-primary);
    color: #fff;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
    transition: opacity .3s;
}

.oc-btn-save:hover { opacity: 0.9; }

/* ── TABLES ── */
.oc-table-wrap { overflow-x: auto; }
.oc-table {
    width: 100%;
    border-collapse: collapse;
    white-space: nowrap;
}
.oc-table th {
    text-align: left;
    padding: 12px;
    font-size: 11px;
    color: var(--oc-text-dim);
    text-transform: uppercase;
    background: var(--oc-surface-alt);
}
.oc-table td {
    padding: 12px;
    border-bottom: 1px solid var(--oc-border);
    font-size: 14px;
}

/* ── TABS ── */
.oc-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}
.oc-tab-btn {
    background: none;
    border: none;
    color: var(--oc-text-dim);
    padding: 8px 16px;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 2px solid transparent;
}
.oc-tab-btn.active {
    color: var(--oc-primary);
    border-bottom-color: var(--oc-primary);
}

.oc-section { display: none; }
.oc-section.active { display: block; animation: ocFade .3s ease; }

@keyframes ocFade { from { opacity: 0; } to { opacity: 1; } }

/* Overlay for mobile */
.oc-mobile-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.8);
    z-index: 1000;
}
.oc-mobile-overlay.open { display: block; }

</style>

<div class="oc-shell-wrapper">
    <div class="oc-shell">
        <div class="oc-mobile-overlay" id="ocMobileOverlay" onclick="ocToggleSidebar()"></div>

        <!-- Sidebar -->
        <aside class="oc-sidebar" id="ocSidebar">
            <div class="oc-sidebar-header">
                <div class="oc-profile-box">
                    <div class="oc-avatar-container">
                        <div class="oc-avatar-main">
                            @if(Auth::user()->photo)
                                <img src="{{ asset('uploads/avator/'.Auth::user()->photo) }}" alt="User">
                            @else
                                <div class="oc-avatar-placeholder">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="oc-user-info">
                        <h3>{{ Auth::user()->name }}</h3>
                        <span>ID: #{{ Auth::user()->id }}</span>
                    </div>
                </div>
            </div>

            <nav class="oc-nav">
                <button class="oc-nav-item active" onclick="ocShow('dashboard')">
                    <i class="fas fa-th-large"></i> Overview
                </button>
                <button class="oc-nav-item" onclick="ocShow('orders')">
                    <i class="fas fa-shopping-bag"></i> My Orders
                </button>
                <button class="oc-nav-item" onclick="ocShow('wishlist')">
                    <i class="fas fa-heart"></i> Wishlist
                </button>
                <button class="oc-nav-item" onclick="ocShow('settings')">
                    <i class="fas fa-user-cog"></i> Account Settings
                </button>
                <button class="oc-nav-item" onclick="ocShow('address')">
                    <i class="fas fa-map-marker-alt"></i> Address Book
                </button>
                
                <div style="margin-top:20px; border-top:1px solid var(--oc-border); padding-top:10px;">
                    <form action="{{ route('customer.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="oc-nav-item text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="oc-main">
            <!-- Mobile Top Bar -->
            <div class="oc-top-bar">
                <button class="oc-menu-toggle" onclick="ocToggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div style="font-weight:700;">DASHBOARD</div>
                <div style="width:40px;"></div> <!-- Spacer -->
            </div>

            <!-- Dashboard Section -->
            <section class="oc-section active" id="oc-section-dashboard">
                <h2 style="font-family:'Outfit'; margin-bottom:24px;">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}</h2>
                
                <div class="oc-stats-grid">
                    <div class="oc-stat-card">
                        <div class="oc-stat-icon"><i class="fas fa-shopping-cart"></i></div>
                        <div>
                            <div class="oc-stat-value">{{ $totalOrders }}</div>
                            <div class="oc-stat-label">Total Orders</div>
                        </div>
                    </div>
                    <div class="oc-stat-card">
                        <div class="oc-stat-icon" style="color:#f59e0b;"><i class="fas fa-clock"></i></div>
                        <div>
                            <div class="oc-stat-value">{{ $pendingOrders }}</div>
                            <div class="oc-stat-label">Pending</div>
                        </div>
                    </div>
                    <div class="oc-stat-card">
                        <div class="oc-stat-icon" style="color:#10b981;"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <div class="oc-stat-value">{{ $deliveredOrders }}</div>
                            <div class="oc-stat-label">Delivered</div>
                        </div>
                    </div>
                    <div class="oc-stat-card">
                        <div class="oc-stat-icon" style="color:#ef4444;"><i class="fas fa-heart"></i></div>
                        <div>
                            <div class="oc-stat-value">{{ $wishlistCount }}</div>
                            <div class="oc-stat-label">Saved Items</div>
                        </div>
                    </div>
                </div>

                <div class="oc-card">
                    <div class="oc-card-header">
                        <div class="oc-card-title"><i class="fas fa-receipt"></i> Recent Orders</div>
                        <button style="background:none; border:none; color:var(--oc-primary); font-weight:700; cursor:pointer;" onclick="ocShow('orders')">View All</button>
                    </div>
                    <div class="oc-table-wrap">
                        <table class="oc-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders->take(5) as $order)
                                <tr>
                                    <td style="font-weight:700;">#{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td style="font-weight:800;">৳{{ number_format($order->total, 2) }}</td>
                                    <td>
                                        <span style="padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700; background:rgba(232, 25, 44, 0.1); color:var(--oc-primary);">
                                            {{ strtoupper($order->order_status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" style="text-align:center; padding:30px;">No recent orders.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Orders Section -->
            <section class="oc-section" id="oc-section-orders">
                <div class="oc-card">
                    <div class="oc-card-header">
                        <div class="oc-card-title"><i class="fas fa-shopping-bag"></i> Order History</div>
                    </div>
                    <div class="oc-table-wrap">
                        <table class="oc-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td style="font-weight:700;">#{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>{{ $order->items->count() }} items</td>
                                    <td style="font-weight:800;">৳{{ number_format($order->total, 2) }}</td>
                                    <td>{{ ucfirst($order->order_status) }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="5" style="text-align:center; padding:30px;">You haven't placed any orders yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Wishlist Section -->
            <section class="oc-section" id="oc-section-wishlist">
                <div class="oc-card">
                    <div class="oc-card-header">
                        <div class="oc-card-title"><i class="fas fa-heart"></i> My Wishlist</div>
                    </div>
                    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:15px;">
                        @forelse($wishlistItems as $wItem)
                        @php $prod = $wItem->product; @endphp
                        @if($prod)
                        <div style="background:var(--oc-surface-alt); border-radius:10px; overflow:hidden;">
                            <img src="{{ asset('uploads/products/'.$prod->feature_image) }}" style="width:100%; height:150px; object-fit:cover;">
                            <div style="padding:10px;">
                                <div style="font-size:13px; font-weight:600; margin-bottom:5px; height:34px; overflow:hidden;">{{ $prod->name }}</div>
                                <div style="color:var(--oc-primary); font-weight:800;">৳{{ number_format($prod->effective_price, 2) }}</div>
                                <a href="{{ route('product.detail', $prod->slug) }}" style="display:block; margin-top:10px; text-align:center; font-size:12px; color:#fff; text-decoration:none; padding:6px; border:1px solid var(--oc-border); border-radius:6px;">View</a>
                            </div>
                        </div>
                        @endif
                        @empty
                        <div style="grid-column: 1 / -1; text-align:center; padding:40px; color:var(--oc-text-dim);">Your wishlist is empty.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- Settings Section -->
            <section class="oc-section" id="oc-section-settings">
                <div class="oc-card">
                    <div class="oc-card-header">
                        <div class="oc-card-title"><i class="fas fa-user-cog"></i> Account Settings</div>
                    </div>
                    
                    <div class="oc-tabs">
                        <button class="oc-tab-btn active" id="btn-tab-profile" onclick="ocSwitchTab('profile')">Profile Info</button>
                        <button class="oc-tab-btn" id="btn-tab-password" onclick="ocSwitchTab('password')">Security</button>
                    </div>

                    <!-- Profile Form -->
                    <div id="oc-tab-profile" class="oc-tab-content">
                        <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div style="display:flex; align-items:center; gap:20px; margin-bottom:24px; padding:15px; background:var(--oc-surface-alt); border-radius:10px;">
                                <div style="width:60px; height:60px; border-radius:50%; overflow:hidden;">
                                    @if(Auth::user()->photo)
                                        <img src="{{ asset('uploads/avator/'.Auth::user()->photo) }}" style="width:100%; height:100%; object-fit:cover;">
                                    @else
                                        <div style="width:100%; height:100%; background:#333; display:flex; align-items:center; justify-content:center;">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                    @endif
                                </div>
                                <div>
                                    <label style="font-size:12px; display:block; margin-bottom:5px; color:var(--oc-text-dim);">Profile Photo</label>
                                    <input type="file" name="photo" style="font-size:12px;">
                                </div>
                            </div>

                            <div class="oc-form-grid">
                                <div>
                                    <label style="font-size:12px; margin-bottom:5px; display:block;">Full Name</label>
                                    <input type="text" name="name" class="oc-input" value="{{ Auth::user()->name }}" required>
                                </div>
                                <div>
                                    <label style="font-size:12px; margin-bottom:5px; display:block;">Email Address</label>
                                    <input type="email" name="email" class="oc-input" value="{{ Auth::user()->email }}" required>
                                </div>
                                <div>
                                    <label style="font-size:12px; margin-bottom:5px; display:block;">Phone</label>
                                    <input type="text" name="phone" class="oc-input" value="{{ Auth::user()->phone }}">
                                </div>
                                <div>
                                    <label style="font-size:12px; margin-bottom:5px; display:block;">Address</label>
                                    <input type="text" name="address" class="oc-input" value="{{ Auth::user()->address }}">
                                </div>
                            </div>
                            <div style="margin-top:20px; text-align:right;">
                                <button type="submit" class="oc-btn-save">Save Changes</button>
                            </div>
                        </form>
                    </div>

                    <!-- Password Form -->
                    <div id="oc-tab-password" class="oc-tab-content" style="display:none;">
                        <form action="{{ route('customer.profile.password') }}" method="POST">
                            @csrf
                            <div class="oc-form-grid">
                                <div style="grid-column: 1 / -1;">
                                    <label style="font-size:12px; margin-bottom:5px; display:block;">Current Password</label>
                                    <input type="password" name="current_password" class="oc-input" required>
                                </div>
                                <div>
                                    <label style="font-size:12px; margin-bottom:5px; display:block;">New Password</label>
                                    <input type="password" name="password" class="oc-input" required>
                                </div>
                                <div>
                                    <label style="font-size:12px; margin-bottom:5px; display:block;">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="oc-input" required>
                                </div>
                            </div>
                            <div style="margin-top:20px; text-align:right;">
                                <button type="submit" class="oc-btn-save">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Address Section -->
            <section class="oc-section" id="oc-section-address">
                <div class="oc-card">
                    <div class="oc-card-header">
                        <div class="oc-card-title"><i class="fas fa-map-marker-alt"></i> Address Book</div>
                        <button class="oc-btn-save" style="padding:6px 12px; font-size:12px;">Add New</button>
                    </div>
                    <div style="padding:15px; border:1px solid var(--oc-border); border-radius:10px;">
                        <div style="font-weight:700; margin-bottom:5px;">Default Shipping Address</div>
                        <div style="font-size:14px; color:var(--oc-text-dim);">{{ Auth::user()->address ?? 'No address set yet.' }}</div>
                    </div>
                </div>
            </section>

        </main>
    </div>
</div>

<script>
function ocToggleSidebar() {
    const sidebar = document.getElementById('ocSidebar');
    const overlay = document.getElementById('ocMobileOverlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
}

function ocShow(sectionId) {
    document.querySelectorAll('.oc-section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.oc-nav-item').forEach(n => n.classList.remove('active'));
    
    document.getElementById('oc-section-' + sectionId).classList.add('active');
    
    // Set active nav item
    const navItems = document.querySelectorAll('.oc-nav-item');
    navItems.forEach(item => {
        if (item.getAttribute('onclick').includes("'"+sectionId+"'")) {
            item.classList.add('active');
        }
    });

    if (window.innerWidth <= 1024) ocToggleSidebar();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function ocSwitchTab(tabId) {
    document.getElementById('oc-tab-profile').style.display = 'none';
    document.getElementById('oc-tab-password').style.display = 'none';
    document.getElementById('btn-tab-profile').classList.remove('active');
    document.getElementById('btn-tab-password').classList.remove('active');
    
    document.getElementById('oc-tab-' + tabId).style.display = 'block';
    document.getElementById('btn-tab-' + tabId).classList.add('active');
}
</script>

@include('frontend.pages.footer')
