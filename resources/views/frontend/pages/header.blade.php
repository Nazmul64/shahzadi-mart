<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shahzadi-mart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet"href="{{asset('frontend')}}/assets/css/style.css">
</head>
<body>
    <!-- Top Header -->
    <div class="top-header">
        <div class="top-header-content">
            <a href="start-selling.html"><i class="fas fa-store"></i> Sell on ShopGo</a>
            <a href="#"><i class="fas fa-map-marker-alt"></i> Our Stores</a>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="header-content">
            <div class="header-left">
                <i class="fas fa-bars mobile-menu-toggle" onclick="toggleSidebar()"></i>

                <a href="#" class="logo">
                    ShopGo<span class="logo-emoji">😊</span>
                </a>
            </div>

            <div class="search-container">
                <input
                    type="search"
                    class="search-box"
                    placeholder="Search products, brands and categories"
                    autocomplete="off"
                    autocorrect="off"
                    autocapitalize="off"
                    spellcheck="false"
                >
                <button class="search-btn" type="button">Search</button>
            </div>

            <div class="header-right">
                <div class="header-actions">
                    <div class="header-action account-dropdown">
                        <i class="fas fa-user"></i>
                        <span>Account</span>
                        <div class="dropdown-content">
                            <div class="dropdown-header">
                                <p>Welcome to ShopGo</p>
                                <button class="signin-btn">Sign In</button>
                            </div>
                            <a href="customer-account-index.html" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>My Account</span>
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-shopping-bag"></i>
                                <span>Orders</span>
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-heart"></i>
                                <span>Favorites</span>
                            </a>
                            <a href="#" class="dropdown-item logout-item">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>LOGOUT</span>
                            </a>
                        </div>
                    </div>

                    <a href="#" class="header-action">
                        <i class="fas fa-question-circle"></i>
                        <span>Help</span>
                    </a>

                    <a href="card.html" class="header-action">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Cart</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
