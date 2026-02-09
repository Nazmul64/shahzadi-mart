@extends('frontend.master')

@section('main-content')
 <main class="content-area">
            <!-- Hero Section -->
            <div class="hero-section">
                <!-- Hero Slider -->
                <div class="hero-slider">
                    <button class="slider-arrow slider-prev" onclick="previousSlide()">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="slider-arrow slider-next" onclick="nextSlide()">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <div class="slider-wrapper">
                        <div class="slide active">
                            <div class="slide-content">
                                <h1>Hot Deals<br>on Cool Gadgets!</h1>
                                <p style="color: #8B7355; font-size: 14px; margin-bottom: 15px; font-weight: 600;">30% OFF</p>
                                <p style="color: #6B5B52; font-size: 13px; margin-bottom: 15px;">Save Big Today!</p>
                                <button class="slide-btn">Shop Now!</button>
                            </div>
                            <div class="slide-image">
                                <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=600&h=400&fit=crop" alt="Cool Gadgets">
                            </div>
                        </div>

                        <div class="slide">
                            <div class="slide-content">
                                <h1>Elevate Your<br>Audio Experience</h1>
                                <button class="slide-btn">Explore Now</button>
                            </div>
                            <div class="slide-image">
                                <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=600&h=400&fit=crop" alt="Earbuds">
                            </div>
                        </div>

                        <div class="slide">
                            <div class="slide-content">
                                <h1>Cozy Comfort for<br>Little Ones!</h1>
                                <button class="slide-btn">Shop Baby Essentials</button>
                            </div>
                            <div class="slide-image">
                                <img src="https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=600&h=400&fit=crop" alt="Baby Products">
                            </div>
                        </div>

                        <div class="slide">
                            <div class="slide-content">
                                <h1>Dive Into A World Of<br>Crystal Clear Sound</h1>
                                <button class="slide-btn">Buy Now</button>
                            </div>
                            <div class="slide-image">
                                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&h=400&fit=crop" alt="Headphones">
                            </div>
                        </div>
                    </div>

                    <div class="slider-controls">
                        <span class="slider-dot active" onclick="goToSlide(0)"></span>
                        <span class="slider-dot" onclick="goToSlide(1)"></span>
                        <span class="slider-dot" onclick="goToSlide(2)"></span>
                        <span class="slider-dot" onclick="goToSlide(3)"></span>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="right-sidebar">
                    <div class="welcome-card">
                        <p>Welcome to ShopGo</p>
                       <div class="auth-buttons">
                        <button class="register-btn" onclick="window.location.href='login-or-signup.html'">
                            Register
                        </button>
                        <button class="signin-btn-card" onclick="window.location.href='login-or-signup.html'">
                            Sign in
                        </button>
                    </div>

                    </div>

                    <div class="clearance-card">
                        CLEA-<br>RANCE
                    </div>
                </div>
            </div>

            <!-- Category Circles - Auto Slider -->
            <div class="category-circles-container">
                <div class="category-circles" id="categoryCircles">
                    <!-- First Set -->
                    <div class="category-circle">
                        <div class="category-circle-img">
                            <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=150&h=150&fit=crop" alt="Sunglasses"></a>
                        </div>
                        <p>Clearance</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1593640495253-23196b27a87f?w=150&h=150&fit=crop" alt="Flash"></a>
                        </div>
                        <p>Flash</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=150&h=150&fit=crop" alt="Phones"></a>
                        </div>
                        <p>Phones</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=150&h=150&fit=crop" alt="Laptops"></a>
                        </div>
                        <p>Laptops</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=150&h=150&fit=crop" alt="Speakers"></a>
                        </div>
                        <p>Speakers</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=150&h=150&fit=crop" alt="Keyboards"></a>
                        </div>
                        <p>Keyboards</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1585255318859-f5c15f4cffe9?w=150&h=150&fit=crop" alt="Watches"></a>
                        </div>
                        <p>Watches</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=150&h=150&fit=crop" alt="Sunglasses"></a>
                        </div>
                        <p>Sunglasses</p>
                    </div>

                    <!-- Duplicate Set for Seamless Loop -->
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1607083206869-4c7672e72a8a?w=150&h=150&fit=crop" alt="Clearance"></a>
                        </div>
                        <p>Clearance</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1593640495253-23196b27a87f?w=150&h=150&fit=crop" alt="Flash"></a>
                        </div>
                        <p>Flash</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=150&h=150&fit=crop" alt="Phones"></a>
                        </div>
                        <p>Phones</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=150&h=150&fit=crop" alt="Laptops"></a>
                        </div>
                        <p>Laptops</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=150&h=150&fit=crop" alt="Speakers"></a>
                        </div>
                        <p>Speakers</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=150&h=150&fit=crop" alt="Keyboards"></a>
                        </div>
                        <p>Keyboards</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                             <a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1585255318859-f5c15f4cffe9?w=150&h=150&fit=crop" alt="Watches"></a>
                        </div>
                        <p>Watches</p>
                    </div>
                    <div class="category-circle">
                        <div class="category-circle-img">
                            <a href="product-listing.html"><a href="product-listing.html"><img href="product-listing.html" src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=150&h=150&fit=crop" alt="Sunglasses"></a>
                        </div>
                        <p>Sunglasses</p>
                    </div>
                </div>
            </div>

            <!-- Flash Sales -->
            <div class="flash-sales-header">
                <div class="flash-title">
                    <i class="fas fa-bolt"></i>
                    Flash Sales
                </div>
                <div class="flash-timer" id="flashTimer">Ends in: 02h : 26m : 17s</div>
                <a href="#" class="see-all-link">SEE ALL <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="product-grid-container">
                <div class="product-grid">
                    <!-- First Set -->
                    <div class="product-card">
                        <div class="discount-badge">-18%</div>
                        <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?w=200&h=200&fit=crop" class="product-image" alt="Desktop"></a>
                        <h3 class="product-name">Lenovo V30a Business All-in-One Desktop</h3>
                        <div class="product-price">KSh 44,326</div>
                        <div class="product-old-price">KSh 54,900</div>
                        <div class="product-stock">13 items left</div>
                        <div class="product-rating">
                            <div class="stars">★★★☆☆</div>
                            <span class="rating-count">(74)</span>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="discount-badge">-18%</div>
                        <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=200&h=200&fit=crop" class="product-image" alt="Laptop"></a>
                        <h3 class="product-name">Acer Chromebook Spin 314 Convertible Laptop</h3>
                        <div class="product-price">KSh 34,260</div>
                        <div class="product-old-price">KSh 41,800</div>
                        <div class="product-stock">22 items left</div>
                        <div class="product-rating">
                            <div class="stars">★★★☆☆</div>
                            <span class="rating-count">(56)</span>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="discount-badge">-18%</div>
                        <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1527814050087-3793815479db?w=200&h=200&fit=crop" class="product-image" alt="Mouse"></a>
                        <h3 class="product-name">Razer Naga Pro Wireless Gaming Mouse</h3>
                        <div class="product-price">KSh 999</div>
                        <div class="product-old-price">KSh 1,200</div>
                        <div class="product-stock">11 items left</div>
                        <div class="product-rating">
                            <div class="stars">★★★★☆</div>
                            <span class="rating-count">(132)</span>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="discount-badge">-18%</div>
                        <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=200&h=200&fit=crop" class="product-image" alt="Keyboard"></a>
                        <h3 class="product-name">Redragon S101 Wired RGB Backlit Gaming Keyboard</h3>
                        <div class="product-price">KSh 4,260</div>
                        <div class="product-old-price">KSh 5,200</div>
                        <div class="product-stock">6 items left</div>
                        <div class="product-rating">
                            <div class="stars">★★★★☆</div>
                            <span class="rating-count">(89)</span>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="discount-badge">-18%</div>
                        <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=200&h=200&fit=crop" class="product-image" alt="Mouse Pad"></a>
                        <h3 class="product-name">SteelSeries QcK Gaming Mouse Pad</h3>
                        <div class="product-price">KSh 999</div>
                        <div class="product-old-price">KSh 1,200</div>
                        <div class="product-stock">3 items left</div>
                        <div class="product-rating">
                            <div class="stars">★★★★☆</div>
                            <span class="rating-count">(245)</span>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="discount-badge">-18%</div>
                        <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1586953208270-e1a85ab5d9d6?w=200&h=200&fit=crop" class="product-image" alt="Drawing Tablet"></a>
                        <h3 class="product-name">Wacom Cintiq 16 Drawing Tablet with Full HD 15.4"</h3>
                        <div class="product-price">KSh 23,673</div>
                        <div class="product-old-price">KSh 28,900</div>
                        <div class="product-stock">43 items left</div>
                        <div class="product-rating">
                            <div class="stars">★★★★☆</div>
                            <span class="rating-count">(167)</span>
                        </div>
                    </div>

                    <!-- Duplicate Set for Seamless Loop -->
                    <div class="product-card">
                        <div class="discount-badge">-18%</div>
                        <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?w=200&h=200&fit=crop" class="product-image" alt="Desktop"></a>
                        <h3 class="product-name">Lenovo V30a Business All-in-One Desktop</h3>
                        <div class="product-price">KSh 44,326</div>
                        <div class="product-old-price">KSh 54,900</div>
                        <div class="product-stock">13 items left</div>
                        <div class="product-rating">
                            <div class="stars">★★★☆☆</div>
                            <span class="rating-count">(74)</span>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="discount-badge">-18%</div>
                        <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=200&h=200&fit=crop" class="product-image" alt="Laptop"></a>
                        <h3 class="product-name">Acer Chromebook Spin 314 Convertible Laptop</h3>
                        <div class="product-price">KSh 34,260</div>
                        <div class="product-old-price">KSh 41,800</div>
                        <div class="product-stock">22 items left</div>
                        <div class="product-rating">
                            <div class="stars">★★★☆☆</div>
                            <span class="rating-count">(56)</span>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="discount-badge">-18%</div>
                        <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1527814050087-3793815479db?w=200&h=200&fit=crop" class="product-image" alt="Mouse"></a>
                        <h3 class="product-name">Razer Naga Pro Wireless Gaming Mouse</h3>
                        <div class="product-price">KSh 999</div>
                        <div class="product-old-price">KSh 1,200</div>
                        <div class="product-stock">11 items left</div>
                        <div class="product-rating">
                            <div class="stars">★★★★☆</div>
                            <span class="rating-count">(132)</span>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="discount-badge">-18%</div>
                        <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=200&h=200&fit=crop" class="product-image" alt="Keyboard"></a>
                        <h3 class="product-name">Redragon S101 Wired RGB Backlit Gaming Keyboard</h3>
                        <div class="product-price">KSh 4,260</div>
                        <div class="product-old-price">KSh 5,200</div>
                        <div class="product-stock">6 items left</div>
                        <div class="product-rating">
                            <div class="stars">★★★★☆</div>
                            <span class="rating-count">(89)</span>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="discount-badge">-18%</div>
                        <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=200&h=200&fit=crop" class="product-image" alt="Mouse Pad"></a>
                        <h3 class="product-name">SteelSeries QcK Gaming Mouse Pad</h3>
                        <div class="product-price">KSh 999</div>
                        <div class="product-old-price">KSh 1,200</div>
                        <div class="product-stock">3 items left</div>
                        <div class="product-rating">
                            <div class="stars">★★★★☆</div>
                            <span class="rating-count">(245)</span>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="discount-badge">-18%</div>
                        <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1586953208270-e1a85ab5d9d6?w=200&h=200&fit=crop" class="product-image" alt="Drawing Tablet"></a>
                        <h3 class="product-name">Wacom Cintiq 16 Drawing Tablet with Full HD 15.4"</h3>
                        <div class="product-price">KSh 23,673</div>
                        <div class="product-old-price">KSh 28,900</div>
                        <div class="product-stock">43 items left</div>
                        <div class="product-rating">
                            <div class="stars">★★★★☆</div>
                            <span class="rating-count">(167)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hot Categories -->
            <div class="section-header">
                <h2>Hot Categories</h2>
            </div>

            <div class="hot-categories">
                <div class="hot-categories-grid">
                    <!-- First Set -->
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=150&h=150&fit=crop" alt="Fashion">
                        </div>
                        <p>Fashion</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=150&h=150&fit=crop" alt="Audio">
                        </div>
                        <p>Audio</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1581092795360-fd1ca04f0952?w=150&h=150&fit=crop" alt="Industrial">
                        </div>
                        <p>Industrial</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=150&h=150&fit=crop" alt="Electronics">
                        </div>
                        <p>Electronics</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=150&h=150&fit=crop" alt="Beauty">
                        </div>
                        <p>Beauty</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1581092795360-fd1ca04f0952?w=150&h=150&fit=crop" alt="Appliances">
                        </div>
                        <p>Appliances</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1556909114-44e3e70034e2?w=150&h=150&fit=crop" alt="Home & Living">
                        </div>
                        <p>Home & Living</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?w=150&h=150&fit=crop" alt="Kitchen">
                        </div>
                        <p>Kitchen</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=150&h=150&fit=crop" alt="Leisure">
                        </div>
                        <p>Leisure & Outdoor</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1554260570-9140fd3b7614?w=150&h=150&fit=crop" alt="Sports">
                        </div>
                        <p>Sports</p>
                    </div>

                    <!-- Duplicate Set for Seamless Loop -->
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=150&h=150&fit=crop" alt="Fashion">
                        </div>
                        <p>Fashion</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=150&h=150&fit=crop" alt="Audio">
                        </div>
                        <p>Audio</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1581092795360-fd1ca04f0952?w=150&h=150&fit=crop" alt="Industrial">
                        </div>
                        <p>Industrial</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=150&h=150&fit=crop" alt="Electronics">
                        </div>
                        <p>Electronics</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=150&h=150&fit=crop" alt="Beauty">
                        </div>
                        <p>Beauty</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1581092795360-fd1ca04f0952?w=150&h=150&fit=crop" alt="Appliances">
                        </div>
                        <p>Appliances</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1556909114-44e3e70034e2?w=150&h=150&fit=crop" alt="Home & Living">
                        </div>
                        <p>Home & Living</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?w=150&h=150&fit=crop" alt="Kitchen">
                        </div>
                        <p>Kitchen</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=150&h=150&fit=crop" alt="Leisure">
                        </div>
                        <p>Leisure & Outdoor</p>
                    </div>
                    <div class="hot-category-item">
                        <div class="hot-category-img">
                            <img src="https://images.unsplash.com/photo-1554260570-9140fd3b7614?w=150&h=150&fit=crop" alt="Sports">
                        </div>
                        <p>Sports</p>
                    </div>
                </div>
            </div>

            <!-- New Arrivals -->
            <div class="section-header">
                <h2>New Arrivals</h2>
                <a href="#" class="see-all-link">SEE ALL <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="product-grid">
                <div class="product-card">
                    <div class="discount-badge">-28%</div>
                    <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1625805866449-3589fe3f71a3?w=200&h=200&fit=crop" class="product-image" alt="Controller"></a>
                    <h3 class="product-name">Razer Wolverine V2 Chroma Wired Gaming Controller</h3>
                    <div class="product-price">KSh 8,326</div>
                    <div class="product-old-price">KSh 11,600</div>
                    <div class="product-rating">
                        <div class="stars">★★★★☆</div>
                        <span class="rating-count">(156)</span>
                    </div>
                </div>

                <div class="product-card">
                    <div class="discount-badge">-28%</div>
                    <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1527814050087-3793815479db?w=200&h=200&fit=crop" class="product-image" alt="Mouse"></a>
                    <h3 class="product-name">Logitech G502 Lightspeed Wireless Gaming Mouse</h3>
                    <div class="product-price">KSh 1,726</div>
                    <div class="product-old-price">KSh 2,400</div>
                    <div class="product-rating">
                        <div class="stars">★★★★☆</div>
                        <span class="rating-count">(289)</span>
                    </div>
                </div>

                <div class="product-card">
                    <div class="discount-badge">-28%</div>
                    <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?w=200&h=200&fit=crop" class="product-image" alt="Desktop"></a>
                    <h3 class="product-name">Lenovo V30a Business All-in-One Desktop</h3>
                    <div class="product-price">KSh 45,426</div>
                    <div class="product-old-price">KSh 63,100</div>
                    <div class="product-rating">
                        <div class="stars">★★★☆☆</div>
                        <span class="rating-count">(74)</span>
                    </div>
                </div>

                <div class="product-card">
                    <div class="discount-badge">-28%</div>
                    <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=200&h=200&fit=crop" class="product-image" alt="Tablet"></a>
                    <h3 class="product-name">Wacom Intuos Pro Medium Bluetooth Drawing Tablet</h3>
                    <div class="product-price">KSh 24,260</div>
                    <div class="product-old-price">KSh 33,700</div>
                    <div class="product-rating">
                        <div class="stars">★★★★☆</div>
                        <span class="rating-count">(198)</span>
                    </div>
                </div>

                <div class="product-card">
                    <div class="discount-badge">-28%</div>
                    <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1625805866449-3589fe3f71a3?w=200&h=200&fit=crop" class="product-image" alt="Hub"></a>
                    <h3 class="product-name">Anker USB Hub Adapter</h3>
                    <div class="product-price">KSh 1,626</div>
                    <div class="product-old-price">KSh 2,260</div>
                    <div class="product-rating">
                        <div class="stars">★★★★★</div>
                        <span class="rating-count">(412)</span>
                    </div>
                </div>

                <div class="product-card">
                    <div class="discount-badge">-28%</div>
                    <a href="productdetails.html"><img src="https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=200&h=200&fit=crop" class="product-image" alt="Keyboard"></a>
                    <h3 class="product-name">SteelSeries Apex 3 RGB Gaming Keyboard</h3>
                    <div class="product-price">KSh 2,426</div>
                    <div class="product-old-price">KSh 3,370</div>
                    <div class="product-rating">
                        <div class="stars">★★★★☆</div>
                        <span class="rating-count">(267)</span>
                    </div>
                </div>
            </div>
        </main>
@endsection
