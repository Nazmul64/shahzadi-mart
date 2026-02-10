@include('frontend.pages.header')
    <!-- Mobile Header (visible on mobile only) -->
    <div class="customerdashboard-mobile-header">
        <button class="customerdashboard-mobile-menu-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="customerdashboard-mobile-logo">crudio</div>
        <div style="width: 40px;"></div>
    </div>

    <!-- Sidebar Overlay -->
    <div class="customerdashboard-sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- App Container -->
    <div class="customerdashboard-app-container">
        <!-- Sidebar -->
        <aside class="customerdashboard-sidebar" id="sidebar">
            <div class="customerdashboard-sidebar-header">
                <div class="customerdashboard-profile-section">
                    <div class="customerdashboard-profile-avatar">crudio</div>
                    <div class="customerdashboard-profile-info">
                        <div class="customerdashboard-profile-name">
                            John Doe
                            <i class="fas fa-pen customerdashboard-edit-icon" onclick="showSection('manage-account')"></i>
                        </div>
                        <div class="customerdashboard-profile-joined">Joined: 2nd April, 2023</div>
                    </div>
                </div>
            </div>

            <nav class="customerdashboard-nav-menu">
                <a class="customerdashboard-nav-item customerdashboard-active" onclick="showSection('dashboard')">
                    <i class="fas fa-chart-pie customerdashboard-nav-icon"></i>
                    <span class="customerdashboard-nav-text">Dashboard</span>
                </a>

                <a class="customerdashboard-nav-item" onclick="showSection('orders')">
                    <i class="fas fa-shopping-bag customerdashboard-nav-icon"></i>
                    <span class="customerdashboard-nav-text">Orders</span>
                </a>

                <a class="customerdashboard-nav-item" onclick="showSection('address-book')">
                    <i class="fas fa-address-book customerdashboard-nav-icon"></i>
                    <span class="customerdashboard-nav-text">Address Book</span>
                </a>

                <a class="customerdashboard-nav-item" onclick="showSection('reviews')">
                    <i class="fas fa-star customerdashboard-nav-icon"></i>
                    <span class="customerdashboard-nav-text">Pending Reviews</span>
                    <span class="customerdashboard-nav-badge customerdashboard-warning">2</span>
                </a>

                <a class="customerdashboard-nav-item" onclick="showSection('notifications')">
                    <i class="fas fa-bell customerdashboard-nav-icon"></i>
                    <span class="customerdashboard-nav-text">Notifications</span>
                    <span class="customerdashboard-nav-badge customerdashboard-danger">2</span>
                </a>

                <a class="customerdashboard-nav-item" onclick="showSection('saved-items')">
                    <i class="fas fa-heart customerdashboard-nav-icon"></i>
                    <span class="customerdashboard-nav-text">Saved Items</span>
                </a>
            </nav>

            <div class="customerdashboard-signout-section">
                <button class="customerdashboard-signout-btn" onclick="signOut()">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sign Out</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="customerdashboard-main-content">
            <!-- Dashboard Section -->
            <section class="customerdashboard-section customerdashboard-active" id="dashboard">
                <div class="customerdashboard-content-wrapper">
                    <div class="customerdashboard-stats-grid">
                        <div class="customerdashboard-stat-card">
                            <div class="customerdashboard-stat-number">23</div>
                            <div class="customerdashboard-stat-label">Orders</div>
                        </div>
                        <div class="customerdashboard-stat-card">
                            <div class="customerdashboard-stat-number">KSh 23,900</div>
                            <div class="customerdashboard-stat-label">Wallet</div>
                        </div>
                        <div class="customerdashboard-stat-card">
                            <div class="customerdashboard-stat-number">23</div>
                            <div class="customerdashboard-stat-label">ShopGo Points</div>
                        </div>
                        <div class="customerdashboard-stat-card">
                            <div class="customerdashboard-stat-number">23</div>
                            <div class="customerdashboard-stat-label">Coins</div>
                        </div>
                    </div>

                    <div class="customerdashboard-content-card">
                        <div class="customerdashboard-address-card">
                            <div class="customerdashboard-address-header">
                                <div>
                                    <div class="customerdashboard-delivery-label">Door to Door Delivery</div>
                                    <span class="customerdashboard-default-badge">DEFAULT ADDRESS</span>
                                </div>
                            </div>

                            <div class="customerdashboard-address-info">
                                <div class="customerdashboard-info-row">
                                    <i class="fas fa-user customerdashboard-info-icon"></i>
                                    <span>JOHN DOE</span>
                                </div>
                                <div class="customerdashboard-info-row">
                                    <i class="fas fa-phone customerdashboard-info-icon"></i>
                                    <span>+000 70000000/ +000 70000000</span>
                                </div>
                                <div class="customerdashboard-info-row">
                                    <i class="fas fa-map-marker-alt customerdashboard-info-icon"></i>
                                    <span>Lifestyle Kenya Ltd, Towers 1st Flr, George Padmore Rd, Kilimani, Nairobi</span>
                                </div>
                                <div class="customerdashboard-info-row">
                                    <i class="fas fa-map customerdashboard-info-icon"></i>
                                    <span>Nairobi | Dagoretti North | Kilimani</span>
                                </div>
                            </div>

                            <button class="customerdashboard-manage-btn" onclick="showSection('address-book')">
                                <i class="fas fa-cog"></i>
                                <span>Manage</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Orders Section -->
            <section class="customerdashboard-section" id="orders">
                <div class="customerdashboard-content-wrapper">
                    <div class="customerdashboard-page-header">
                        <button class="customerdashboard-back-btn" onclick="showSection('dashboard')">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h1 class="customerdashboard-page-title">My Orders</h1>
                    </div>

                    <div class="customerdashboard-filter-tabs">
                        <button class="customerdashboard-filter-btn customerdashboard-active">All Orders</button>
                        <button class="customerdashboard-filter-btn customerdashboard-pending">Pending</button>
                        <button class="customerdashboard-filter-btn customerdashboard-processing">Processing</button>
                        <button class="customerdashboard-filter-btn customerdashboard-shipped">Shipped</button>
                        <button class="customerdashboard-filter-btn customerdashboard-transit">In Transit</button>
                        <button class="customerdashboard-filter-btn customerdashboard-delivered">Delivered</button>
                        <button class="customerdashboard-filter-btn customerdashboard-cancelled">Cancelled</button>
                    </div>

                    <div class="customerdashboard-order-item">
                        <div class="customerdashboard-order-info">
                            <div class="customerdashboard-order-number">
                                <span class="customerdashboard-order-label">Order No:</span>
                                <span class="customerdashboard-order-id">3469609</span>
                                <button class="customerdashboard-copy-btn" onclick="copyOrderNumber('3469609')">
                                    <i class="far fa-copy"></i>
                                </button>
                                <span class="customerdashboard-status-badge customerdashboard-pending">Pending</span>
                            </div>
                            <div class="customerdashboard-order-date">Order date: 24-11-2023 16:51:18</div>
                        </div>
                        <button class="customerdashboard-order-menu-btn">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>

                    <div class="customerdashboard-order-item">
                        <div class="customerdashboard-order-info">
                            <div class="customerdashboard-order-number">
                                <span class="customerdashboard-order-label">Order No:</span>
                                <span class="customerdashboard-order-id">3469609</span>
                                <button class="customerdashboard-copy-btn" onclick="copyOrderNumber('3469609')">
                                    <i class="far fa-copy"></i>
                                </button>
                                <span class="customerdashboard-status-badge customerdashboard-pending">Pending</span>
                            </div>
                            <div class="customerdashboard-order-date">Order date: 24-11-2023 16:51:18</div>
                        </div>
                        <button class="customerdashboard-order-menu-btn">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>

                    <div class="customerdashboard-order-item">
                        <div class="customerdashboard-order-info">
                            <div class="customerdashboard-order-number">
                                <span class="customerdashboard-order-label">Order No:</span>
                                <span class="customerdashboard-order-id">3469609</span>
                                <button class="customerdashboard-copy-btn" onclick="copyOrderNumber('3469609')">
                                    <i class="far fa-copy"></i>
                                </button>
                                <span class="customerdashboard-status-badge customerdashboard-pending">Pending</span>
                            </div>
                            <div class="customerdashboard-order-date">Order date: 24-11-2023 16:51:18</div>
                        </div>
                        <button class="customerdashboard-order-menu-btn">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Address Book Section -->
            <section class="customerdashboard-section" id="address-book">
                <div class="customerdashboard-content-wrapper">
                    <div class="customerdashboard-page-header">
                        <button class="customerdashboard-back-btn" onclick="showSection('dashboard')">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h1 class="customerdashboard-page-title">Address Book</h1>
                        <button class="customerdashboard-page-action-btn" onclick="showSection('add-address')">
                            <i class="fas fa-plus"></i>
                            <span>Add New Address</span>
                        </button>
                    </div>

                    <div class="customerdashboard-address-grid">
                        <div class="customerdashboard-address-card">
                            <div class="customerdashboard-address-header">
                                <div>
                                    <div class="customerdashboard-delivery-label">Door to Door Delivery</div>
                                    <span class="customerdashboard-default-badge">DEFAULT ADDRESS</span>
                                </div>
                            </div>

                            <div class="customerdashboard-address-info">
                                <div class="customerdashboard-info-row">
                                    <i class="fas fa-user customerdashboard-info-icon"></i>
                                    <span>JOHN DOE</span>
                                </div>
                                <div class="customerdashboard-info-row">
                                    <i class="fas fa-phone customerdashboard-info-icon"></i>
                                    <span>+000 70000000/ +000 70000000</span>
                                </div>
                                <div class="customerdashboard-info-row">
                                    <i class="fas fa-map-marker-alt customerdashboard-info-icon"></i>
                                    <span>Lifestyle Kenya Ltd, Towers 1st Flr, George Padmore Rd, Kilimani, Nairobi</span>
                                </div>
                                <div class="customerdashboard-info-row">
                                    <i class="fas fa-map customerdashboard-info-icon"></i>
                                    <span>Nairobi | Kilimani</span>
                                </div>
                            </div>

                            <div class="customerdashboard-address-actions">
                                <button class="customerdashboard-delete-btn">Delete</button>
                                <button class="customerdashboard-edit-btn">Edit</button>
                            </div>
                        </div>

                        <div class="customerdashboard-address-card">
                            <div class="customerdashboard-address-header">
                                <div>
                                    <div class="customerdashboard-delivery-label">Door to Door Delivery</div>
                                </div>
                            </div>

                            <div class="customerdashboard-address-info">
                                <div class="customerdashboard-info-row">
                                    <i class="fas fa-user customerdashboard-info-icon"></i>
                                    <span>JOHN DOE</span>
                                </div>
                                <div class="customerdashboard-info-row">
                                    <i class="fas fa-phone customerdashboard-info-icon"></i>
                                    <span>+000 70000000/ +000 70000000</span>
                                </div>
                                <div class="customerdashboard-info-row">
                                    <i class="fas fa-map-marker-alt customerdashboard-info-icon"></i>
                                    <span>Lifestyle Kenya Ltd, Towers 1st Flr, George Padmore Rd, Kilimani, Nairobi</span>
                                </div>
                                <div class="customerdashboard-info-row">
                                    <i class="fas fa-map customerdashboard-info-icon"></i>
                                    <span>Nairobi | Kilimani</span>
                                </div>
                            </div>

                            <div class="customerdashboard-address-actions">
                                <button class="customerdashboard-delete-btn">Delete</button>
                                <button class="customerdashboard-edit-btn">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Add Address Section -->
            <section class="customerdashboard-section" id="add-address">
                <div class="customerdashboard-content-wrapper">
                    <div class="customerdashboard-page-header">
                        <button class="customerdashboard-back-btn" onclick="showSection('address-book')">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h1 class="customerdashboard-page-title">Add Shipping Address</h1>
                    </div>

                    <div class="customerdashboard-content-card">
                        <form class="customerdashboard-form-grid">
                            <div class="customerdashboard-form-group">
                                <label class="customerdashboard-form-label">First Name</label>
                                <input type="text" class="customerdashboard-form-input" placeholder="First Name">
                            </div>

                            <div class="customerdashboard-form-group">
                                <label class="customerdashboard-form-label">Last Name</label>
                                <input type="text" class="customerdashboard-form-input" placeholder="Last Name">
                            </div>

                            <div class="customerdashboard-form-group">
                                <label class="customerdashboard-form-label">Phone Number</label>
                                <div class="customerdashboard-phone-input-group">
                                    <input type="text" class="customerdashboard-form-input customerdashboard-country-code" value="+000" readonly>
                                    <input type="text" class="customerdashboard-form-input" placeholder="Phone Number" style="flex: 1;">
                                </div>
                            </div>

                            <div class="customerdashboard-form-group">
                                <label class="customerdashboard-form-label">Additional Phone Number</label>
                                <div class="customerdashboard-phone-input-group">
                                    <input type="text" class="customerdashboard-form-input customerdashboard-country-code" value="+000" readonly>
                                    <input type="text" class="customerdashboard-form-input" placeholder="Additional Phone Number" style="flex: 1;">
                                </div>
                            </div>

                            <div class="customerdashboard-form-group customerdashboard-full-width">
                                <label class="customerdashboard-form-label">Delivery Address</label>
                                <textarea class="customerdashboard-form-textarea" placeholder="Pomalo Technologies Ltd, Afya House 3rd Flr, Tom Mboya Street, Nairobi, CBD"></textarea>
                                <div class="customerdashboard-char-count">0 / 200</div>
                            </div>

                            <div class="customerdashboard-form-group">
                                <label class="customerdashboard-form-label">County</label>
                                <select class="customerdashboard-form-select">
                                    <option>Select County</option>
                                    <option>Nairobi</option>
                                    <option>Mombasa</option>
                                </select>
                            </div>

                            <div class="customerdashboard-form-group">
                                <label class="customerdashboard-form-label">Area</label>
                                <select class="customerdashboard-form-select">
                                    <option>Select Area</option>
                                    <option>CBD</option>
                                    <option>Westlands</option>
                                </select>
                            </div>

                            <div class="customerdashboard-form-group customerdashboard-full-width">
                                <div class="customerdashboard-form-checkbox-wrapper">
                                    <input type="checkbox" class="customerdashboard-form-checkbox" id="defaultAddress">
                                    <label for="defaultAddress" class="customerdashboard-form-checkbox-label">Set as default address</label>
                                </div>
                            </div>

                            <div class="customerdashboard-form-group customerdashboard-full-width">
                                <div class="customerdashboard-form-actions">
                                    <button type="button" class="customerdashboard-cancel-btn" onclick="showSection('address-book')">Cancel</button>
                                    <button type="submit" class="customerdashboard-save-btn">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Profile Details Section -->
            <section class="customerdashboard-section" id="profile-details">
                <div class="customerdashboard-content-wrapper">
                    <div class="customerdashboard-page-header">
                        <button class="customerdashboard-back-btn" onclick="showSection('dashboard')">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h1 class="customerdashboard-page-title">Profile Details</h1>
                        <button class="customerdashboard-page-action-btn" onclick="showSection('manage-account')">
                            <span>Edit Profile</span>
                        </button>
                    </div>

                    <div class="customerdashboard-content-card">
                        <div class="customerdashboard-profile-grid">
                            <div class="customerdashboard-profile-field">
                                <div class="customerdashboard-field-label">First name</div>
                                <div class="customerdashboard-field-value">Allan</div>
                            </div>

                            <div class="customerdashboard-profile-field">
                                <div class="customerdashboard-field-label">Last name</div>
                                <div class="customerdashboard-field-value">James</div>
                            </div>

                            <div class="customerdashboard-profile-field">
                                <div class="customerdashboard-field-label">Email</div>
                                <div class="customerdashboard-field-value">test@example.com</div>
                            </div>

                            <div class="customerdashboard-profile-field">
                                <div class="customerdashboard-field-label">Gender</div>
                                <div class="customerdashboard-field-value">M</div>
                            </div>

                            <div class="customerdashboard-profile-field">
                                <div class="customerdashboard-field-label">Birth date</div>
                                <div class="customerdashboard-field-value">1990-12-31</div>
                            </div>

                            <div class="customerdashboard-profile-field">
                                <div class="customerdashboard-field-label">Phone Number</div>
                                <div class="customerdashboard-field-value">+000 700000000</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Manage Account Section -->
            <section class="customerdashboard-section" id="manage-account">
                <div class="customerdashboard-content-wrapper">
                    <div class="customerdashboard-page-header">
                        <button class="customerdashboard-back-btn" onclick="showSection('dashboard')">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h1 class="customerdashboard-page-title">Manage Account</h1>
                    </div>

                    <div class="customerdashboard-tabs">
                        <button class="customerdashboard-tab-btn customerdashboard-active" onclick="switchTab('personal-details')">Personal details</button>
                        <button class="customerdashboard-tab-btn" onclick="switchTab('security')">Security</button>
                        <button class="customerdashboard-tab-btn" onclick="switchTab('preference')">Preference</button>
                    </div>

                    <!-- Personal Details Tab -->
                    <div class="customerdashboard-tab-content customerdashboard-active" id="personal-details">
                        <div class="customerdashboard-content-card">
                            <h3 class="customerdashboard-card-header">Manage personal details</h3>
                            <form class="customerdashboard-form-grid">
                                <div class="customerdashboard-form-group">
                                    <label class="customerdashboard-form-label">First Name</label>
                                    <input type="text" class="customerdashboard-form-input" value="Allan">
                                </div>

                                <div class="customerdashboard-form-group">
                                    <label class="customerdashboard-form-label">Last Name</label>
                                    <input type="text" class="customerdashboard-form-input" value="James">
                                </div>

                                <div class="customerdashboard-form-group">
                                    <label class="customerdashboard-form-label">Gender</label>
                                    <select class="customerdashboard-form-select">
                                        <option>Select gender</option>
                                        <option selected>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>

                                <div class="customerdashboard-form-group">
                                    <label class="customerdashboard-form-label">Date of Birth</label>
                                    <input type="date" class="customerdashboard-form-input" value="1990-12-31">
                                </div>

                                <div class="customerdashboard-form-group customerdashboard-full-width">
                                    <div class="customerdashboard-form-checkbox-wrapper">
                                        <input type="checkbox" class="customerdashboard-form-checkbox" id="agreeTerms">
                                        <label for="agreeTerms" class="customerdashboard-form-checkbox-label">
                                            I agree with <a href="#" style="color: #0066cc;">Privacy Policies</a> & <a href="#" style="color: #0066cc;">Terms and Conditions</a>
                                        </label>
                                    </div>
                                </div>

                                <div class="customerdashboard-form-group customerdashboard-full-width">
                                    <div class="customerdashboard-form-actions">
                                        <button type="submit" class="customerdashboard-save-btn">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div class="customerdashboard-tab-content" id="security">
                        <div class="customerdashboard-content-card">
                            <h3 class="customerdashboard-card-header">Change Password</h3>
                            <form class="customerdashboard-form-grid">
                                <div class="customerdashboard-form-group customerdashboard-full-width">
                                    <label class="customerdashboard-form-label">Current Password</label>
                                    <input type="password" class="customerdashboard-form-input" placeholder="Current Password">
                                </div>

                                <div class="customerdashboard-form-group customerdashboard-full-width">
                                    <label class="customerdashboard-form-label">New Password</label>
                                    <input type="password" class="customerdashboard-form-input" placeholder="New Password">
                                </div>

                                <div class="customerdashboard-form-group customerdashboard-full-width">
                                    <label class="customerdashboard-form-label">Confirm Password</label>
                                    <input type="password" class="customerdashboard-form-input" placeholder="Confirm Password">
                                </div>

                                <div class="customerdashboard-form-group customerdashboard-full-width">
                                    <p style="font-size: 12px; color: var(--customerdashboard-text-light);">8 characters or longer. Combine upper and lowercase letters and numbers.</p>
                                </div>

                                <div class="customerdashboard-form-group customerdashboard-full-width">
                                    <div class="customerdashboard-form-actions">
                                        <button type="submit" class="customerdashboard-save-btn">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Preference Tab -->
                    <div class="customerdashboard-tab-content" id="preference">
                        <div class="customerdashboard-content-card">
                            <h3 class="customerdashboard-card-header">Customer Preferences</h3>

                            <div class="customerdashboard-preference-item">
                                <div class="customerdashboard-preference-label">Order Updates</div>
                                <label class="customerdashboard-toggle-switch">
                                    <input type="checkbox" class="customerdashboard-toggle-input" checked>
                                    <span class="customerdashboard-toggle-slider">
                                        <span class="customerdashboard-toggle-label customerdashboard-on">ON</span>
                                        <span class="customerdashboard-toggle-label customerdashboard-off">OFF</span>
                                    </span>
                                </label>
                            </div>

                            <div class="customerdashboard-preference-item">
                                <div class="customerdashboard-preference-label">Promotional Emails</div>
                                <label class="customerdashboard-toggle-switch">
                                    <input type="checkbox" class="customerdashboard-toggle-input" checked>
                                    <span class="customerdashboard-toggle-slider">
                                        <span class="customerdashboard-toggle-label customerdashboard-on">ON</span>
                                        <span class="customerdashboard-toggle-label customerdashboard-off">OFF</span>
                                    </span>
                                </label>
                            </div>

                            <div class="customerdashboard-preference-item">
                                <div class="customerdashboard-preference-label">SMS Offers</div>
                                <label class="customerdashboard-toggle-switch">
                                    <input type="checkbox" class="customerdashboard-toggle-input">
                                    <span class="customerdashboard-toggle-slider">
                                        <span class="customerdashboard-toggle-label customerdashboard-on">ON</span>
                                        <span class="customerdashboard-toggle-label customerdashboard-off">OFF</span>
                                    </span>
                                </label>
                            </div>

                            <div class="customerdashboard-preference-item">
                                <div class="customerdashboard-preference-label">Product Recommendations</div>
                                <label class="customerdashboard-toggle-switch">
                                    <input type="checkbox" class="customerdashboard-toggle-input" checked>
                                    <span class="customerdashboard-toggle-slider">
                                        <span class="customerdashboard-toggle-label customerdashboard-on">ON</span>
                                        <span class="customerdashboard-toggle-label customerdashboard-off">OFF</span>
                                    </span>
                                </label>
                            </div>

                            <div class="customerdashboard-preference-item">
                                <div class="customerdashboard-preference-label">Wishlist Alerts</div>
                                <label class="customerdashboard-toggle-switch">
                                    <input type="checkbox" class="customerdashboard-toggle-input">
                                    <span class="customerdashboard-toggle-slider">
                                        <span class="customerdashboard-toggle-label customerdashboard-on">ON</span>
                                        <span class="customerdashboard-toggle-label customerdashboard-off">OFF</span>
                                    </span>
                                </label>
                            </div>

                            <div class="customerdashboard-preference-item">
                                <div class="customerdashboard-preference-label">Newsletter Subscription</div>
                                <label class="customerdashboard-toggle-switch">
                                    <input type="checkbox" class="customerdashboard-toggle-input">
                                    <span class="customerdashboard-toggle-slider">
                                        <span class="customerdashboard-toggle-label customerdashboard-on">ON</span>
                                        <span class="customerdashboard-toggle-label customerdashboard-off">OFF</span>
                                    </span>
                                </label>
                            </div>

                            <div class="customerdashboard-form-actions" style="margin-top: 24px;">
                                <button class="customerdashboard-save-btn">Save Preferences</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Reviews Section -->
            <section class="customerdashboard-section" id="reviews">
                <div class="customerdashboard-content-wrapper">
                    <div class="customerdashboard-page-header">
                        <button class="customerdashboard-back-btn" onclick="showSection('dashboard')">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h1 class="customerdashboard-page-title">Reviews</h1>
                    </div>

                    <div class="customerdashboard-filter-tabs">
                        <button class="customerdashboard-filter-btn customerdashboard-active">Pending Review</button>
                        <button class="customerdashboard-filter-btn">Reviewed</button>
                    </div>

                    <div class="customerdashboard-review-item">
                        <div class="customerdashboard-review-header">
                            <div class="customerdashboard-review-order-info">
                                <span class="customerdashboard-order-label">Order No:</span>
                                <span class="customerdashboard-order-id">3469605</span>
                                <button class="customerdashboard-copy-btn">
                                    <i class="far fa-copy"></i>
                                </button>
                                <span>24-11-2023 16:51:18</span>
                            </div>
                            <button class="customerdashboard-write-review-btn" onclick="showSection('write-review')">Write review</button>
                        </div>

                        <div class="customerdashboard-product-review-item">
                            <img src="https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=200" alt="Product" class="customerdashboard-product-review-img">
                            <div class="customerdashboard-product-review-info">
                                <div class="customerdashboard-product-review-name">Lenovo V30a Business All-in-One Desktop</div>
                                <div class="customerdashboard-product-specs">Color:Blue | Size:2XL</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Write Review Section -->
            <section class="customerdashboard-section" id="write-review">
                <div class="customerdashboard-content-wrapper">
                    <div class="customerdashboard-page-header">
                        <button class="customerdashboard-back-btn" onclick="showSection('reviews')">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h1 class="customerdashboard-page-title">Write A Review</h1>
                    </div>

                    <div class="customerdashboard-content-card">
                        <h3 class="customerdashboard-card-header">Review the Product</h3>

                        <div class="customerdashboard-product-review-item" style="margin-bottom: 24px;">
                            <img src="https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=200" alt="Product" class="customerdashboard-product-review-img">
                            <div class="customerdashboard-product-review-info">
                                <div class="customerdashboard-product-review-name">Lenovo V30a Business All-in-One Desktop</div>
                                <div class="customerdashboard-product-specs">Color:Blue | Size:2XL</div>
                            </div>
                        </div>

                        <div>
                            <h4 style="font-size: 16px; margin-bottom: 12px; color: var(--customerdashboard-text-dark);">Were you satisfied with the product?</h4>
                            <div class="customerdashboard-rating-input">
                                <i class="fas fa-star customerdashboard-star-input customerdashboard-active"></i>
                                <i class="fas fa-star customerdashboard-star-input"></i>
                                <i class="fas fa-star customerdashboard-star-input"></i>
                                <i class="fas fa-star customerdashboard-star-input"></i>
                                <i class="fas fa-star customerdashboard-star-input"></i>
                            </div>
                        </div>

                        <div class="customerdashboard-form-group" style="margin-top: 24px;">
                            <label class="customerdashboard-form-label">Your Review</label>
                            <textarea class="customerdashboard-form-textarea" placeholder="Share your experience with this product..." style="min-height: 150px;"></textarea>
                        </div>

                        <div class="customerdashboard-form-actions">
                            <button class="customerdashboard-cancel-btn" onclick="showSection('reviews')">Cancel</button>
                            <button class="customerdashboard-save-btn">Submit Review</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Saved Items Section -->
            <section class="customerdashboard-section" id="saved-items">
                <div class="customerdashboard-content-wrapper">
                    <div class="customerdashboard-page-header">
                        <button class="customerdashboard-back-btn" onclick="showSection('dashboard')">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h1 class="customerdashboard-page-title">Saved Items</h1>
                    </div>

                    <div class="customerdashboard-pagination">
                        <div class="customerdashboard-page-info">All(23) <button class="customerdashboard-cancel-btn" style="margin-left: 16px; padding: 8px 16px;">Clear All</button></div>
                        <div class="customerdashboard-page-nav">
                            <div class="customerdashboard-page-info">1 / 3</div>
                            <button class="customerdashboard-page-btn">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="customerdashboard-page-btn">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <div class="customerdashboard-products-grid">
                        <div class="customerdashboard-product-card">
                            <button class="customerdashboard-remove-product-btn">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <img src="https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400" alt="Product" class="customerdashboard-product-img">
                            <div class="customerdashboard-brand-badge">Brand Official</div>
                            <div class="customerdashboard-product-title">Lenovo V30a Business All-in-One Desktop</div>
                            <div class="customerdashboard-price-row">
                                <div class="customerdashboard-current-price">KSh 45,025</div>
                                <div class="customerdashboard-old-price">KSh 51,399</div>
                                <div class="customerdashboard-discount">-43%</div>
                            </div>
                            <div class="customerdashboard-rating">
                                <div class="customerdashboard-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <div class="customerdashboard-rating-count">(7)</div>
                            </div>
                            <button class="customerdashboard-add-cart-btn">Add to cart</button>
                        </div>

                        <div class="customerdashboard-product-card">
                            <button class="customerdashboard-remove-product-btn">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <img src="https://images.unsplash.com/photo-1527814050087-3793815479db?w=400" alt="Product" class="customerdashboard-product-img">
                            <div class="customerdashboard-product-title">Razer Naga Pro Wireless Gaming Mouse</div>
                            <div class="customerdashboard-price-row">
                                <div class="customerdashboard-current-price">KSh 2,025</div>
                                <div class="customerdashboard-old-price">KSh 3,399</div>
                                <div class="customerdashboard-discount">-43%</div>
                            </div>
                            <div class="customerdashboard-rating">
                                <div class="customerdashboard-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <div class="customerdashboard-rating-count">(3)</div>
                            </div>
                            <button class="customerdashboard-add-cart-btn">Add to cart</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Notifications Section -->
            <section class="customerdashboard-section" id="notifications">
                <div class="customerdashboard-content-wrapper">
                    <div class="customerdashboard-page-header">
                        <button class="customerdashboard-back-btn" onclick="showSection('dashboard')">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h1 class="customerdashboard-page-title">Notifications</h1>
                    </div>

                    <div class="customerdashboard-content-card">
                        <p style="text-align: center; color: var(--customerdashboard-text-light); padding: 40px 20px;">
                            <i class="fas fa-bell" style="font-size: 48px; color: var(--customerdashboard-border); margin-bottom: 16px; display: block;"></i>
                            No new notifications
                        </p>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Toggle Sidebar (Mobile)
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.customerdashboard-sidebar-overlay');
            sidebar.classList.toggle('customerdashboard-active');
            overlay.classList.toggle('customerdashboard-active');
        }

        // Show Section
        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.customerdashboard-section').forEach(section => {
                section.classList.remove('customerdashboard-active');
            });

            // Show selected section
            document.getElementById(sectionId).classList.add('customerdashboard-active');

            // Update active nav item
            document.querySelectorAll('.customerdashboard-nav-item').forEach(item => {
                item.classList.remove('customerdashboard-active');
            });

            // Close sidebar on mobile
            if (window.innerWidth < 769) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.querySelector('.customerdashboard-sidebar-overlay');
                sidebar.classList.remove('customerdashboard-active');
                overlay.classList.remove('customerdashboard-active');
            }

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Switch Tab
        function switchTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.customerdashboard-tab-content').forEach(content => {
                content.classList.remove('customerdashboard-active');
            });

            // Show selected tab content
            document.getElementById(tabId).classList.add('customerdashboard-active');

            // Update active tab button
            document.querySelectorAll('.customerdashboard-tab-btn').forEach(btn => {
                btn.classList.remove('customerdashboard-active');
            });
            event.target.classList.add('customerdashboard-active');
        }

        // Sign Out
        function signOut() {
            if (confirm('Are you sure you want to sign out?')) {
                alert('Signing out...');
            }
        }

        // Copy Order Number
        function copyOrderNumber(orderNumber) {
            navigator.clipboard.writeText(orderNumber).then(() => {
                alert('Order number copied: ' + orderNumber);
            });
        }

        // Star Rating Interaction
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.customerdashboard-star-input');
            stars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.classList.add('customerdashboard-active');
                        } else {
                            s.classList.remove('customerdashboard-active');
                        }
                    });
                });
            });

            // Character counter for textareas
            const textareas = document.querySelectorAll('.customerdashboard-form-textarea');
            textareas.forEach(textarea => {
                const charCount = textarea.nextElementSibling;
                if (charCount && charCount.classList.contains('customerdashboard-char-count')) {
                    textarea.addEventListener('input', function() {
                        const length = this.value.length;
                        charCount.textContent = length + ' / 200';
                    });
                }
            });
        });
    </script>
</body>
</html>
