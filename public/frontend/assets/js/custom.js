 // Hero Slider
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.slider-dot');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            
            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        function previousSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(currentSlide);
        }

        function goToSlide(index) {
            currentSlide = index;
            showSlide(currentSlide);
        }

        // Auto slide every 5 seconds
        setInterval(nextSlide, 5000);

        // Category Toggle
        function toggleCategory(element) {
            const subcategory = element.nextElementSibling;
            element.classList.toggle('active');
            
            if (subcategory && subcategory.classList.contains('subcategory-menu')) {
                subcategory.classList.toggle('show');
            }
        }

        // Sidebar Toggle for Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        // Flash Sale Timer
        let hours = 2, minutes = 26, seconds = 17;
        
        function updateFlashTimer() {
            seconds--;
            if (seconds < 0) {
                seconds = 59;
                minutes--;
            }
            if (minutes < 0) {
                minutes = 59;
                hours--;
            }
            if (hours < 0) {
                hours = 23;
            }
            
            const timerElement = document.getElementById('flashTimer');
            if (timerElement) {
                timerElement.textContent = `Ends in: ${hours.toString().padStart(2, '0')}h : ${minutes.toString().padStart(2, '0')}m : ${seconds.toString().padStart(2, '0')}s`;
            }
        }

        setInterval(updateFlashTimer, 1000);

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                    document.querySelector('.sidebar-overlay').classList.remove('show');
                }
            }
        });

        // Mobile dropdown toggle
        if (window.innerWidth <= 768) {
            const accountDropdown = document.querySelector('.account-dropdown');
            const dropdownContent = document.querySelector('.dropdown-content');
            
            if (accountDropdown && dropdownContent) {
                accountDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Toggle visibility
                    if (dropdownContent.style.opacity === '1') {
                        dropdownContent.style.opacity = '0';
                        dropdownContent.style.visibility = 'hidden';
                        dropdownContent.style.transform = 'translateY(-10px)';
                    } else {
                        dropdownContent.style.opacity = '1';
                        dropdownContent.style.visibility = 'visible';
                        dropdownContent.style.transform = 'translateY(0)';
                    }
                });
                
                // Close when clicking outside
                document.addEventListener('click', function(e) {
                    if (!accountDropdown.contains(e.target)) {
                        dropdownContent.style.opacity = '0';
                        dropdownContent.style.visibility = 'hidden';
                        dropdownContent.style.transform = 'translateY(-10px)';
                    }
                });
            }
        }
// End for frontend


// Start product list javascript code


        // Toggle category sections
        function productlistingeToggleCategory(element) {
            const content = element.nextElementSibling;
            const icon = element.querySelector('.productlistinge-collapse-icon');
            
            if (content.classList.contains('productlistinge-collapsed')) {
                content.classList.remove('productlistinge-collapsed');
                icon.textContent = '−';
            } else {
                content.classList.add('productlistinge-collapsed');
                icon.textContent = '+';
            }
        }

        // Toggle filters on mobile
        function productlistingeToggleFilters() {
            const sidebar = document.getElementById('productlistingeFilterSidebar');
            sidebar.classList.toggle('productlistinge-active');
        }

        // Price range slider functionality
        function productlistingeUpdatePriceRange() {
            const minPrice = document.getElementById('productlistingeMinPrice');
            const maxPrice = document.getElementById('productlistingeMaxPrice');
            const minPriceInput = document.getElementById('productlistingeMinPriceInput');
            const maxPriceInput = document.getElementById('productlistingeMaxPriceInput');
            const trackFilled = document.getElementById('productlistingePriceTrackFilled');

            let minVal = parseInt(minPrice.value);
            let maxVal = parseInt(maxPrice.value);

            if (minVal > maxVal - 100) {
                minVal = maxVal - 100;
                minPrice.value = minVal;
            }

            if (maxVal < minVal + 100) {
                maxVal = minVal + 100;
                maxPrice.value = maxVal;
            }

            minPriceInput.value = minVal;
            maxPriceInput.value = maxVal;

            const percentMin = ((minVal - 20) / (26025 - 20)) * 100;
            const percentMax = ((maxVal - 20) / (26025 - 20)) * 100;
            trackFilled.style.left = percentMin + '%';
            trackFilled.style.right = (100 - percentMax) + '%';
        }

        function productlistingeUpdateFromInput() {
            const minPrice = document.getElementById('productlistingeMinPrice');
            const maxPrice = document.getElementById('productlistingeMaxPrice');
            const minPriceInput = document.getElementById('productlistingeMinPriceInput');
            const maxPriceInput = document.getElementById('productlistingeMaxPriceInput');

            minPrice.value = minPriceInput.value;
            maxPrice.value = maxPriceInput.value;
            productlistingeUpdatePriceRange();
        }

        productlistingeUpdatePriceRange();
// End for product listing



// Product-details start
        // Image Gallery & Zoom Functionality
        const mainImageContainer = document.getElementById('mainImageContainer');
        const mainImage = document.getElementById('mainImage');
        const zoomImage = document.getElementById('zoomImage');
        const zoomLens = document.getElementById('zoomLens');
        const zoomPreview = document.getElementById('zoomPreview');
        const imageCounter = document.getElementById('imageCounter');
        const thumbnails = document.querySelectorAll('.thumbnail-item');

        // Thumbnail Click Handler
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const imageUrl = this.getAttribute('data-image');
                const zoomUrl = this.getAttribute('data-zoom');
                const index = this.getAttribute('data-index');

                mainImage.src = imageUrl;
                zoomImage.src = zoomUrl;
                imageCounter.textContent = `${index}/6`;
            });
        });

        // Image Zoom Functionality
        mainImageContainer.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            // Position lens
            const lensWidth = zoomLens.offsetWidth / 2;
            const lensHeight = zoomLens.offsetHeight / 2;

            let posX = x - lensWidth;
            let posY = y - lensHeight;

            // Boundary check
            if (posX < 0) posX = 0;
            if (posY < 0) posY = 0;
            if (posX > rect.width - zoomLens.offsetWidth) posX = rect.width - zoomLens.offsetWidth;
            if (posY > rect.height - zoomLens.offsetHeight) posY = rect.height - zoomLens.offsetHeight;

            zoomLens.style.left = posX + 'px';
            zoomLens.style.top = posY + 'px';

            // Calculate zoom
            const cx = zoomPreview.offsetWidth / zoomLens.offsetWidth;
            const cy = zoomPreview.offsetHeight / zoomLens.offsetHeight;

            zoomImage.style.width = (mainImage.width * cx) + 'px';
            zoomImage.style.height = (mainImage.height * cy) + 'px';
            zoomImage.style.left = -(posX * cx) + 'px';
            zoomImage.style.top = -(posY * cy) + 'px';
        });

        // Wishlist Toggle
        const wishlistBtn = document.getElementById('wishlistBtn');
        wishlistBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const icon = this.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            
            if (icon.classList.contains('fas')) {
                icon.style.color = '#f85606';
                this.style.backgroundColor = '#fff0e6';
            } else {
                icon.style.color = '#666';
                this.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
            }
        });

        // Quantity Controls
        const qtyInput = document.getElementById('qtyInput');
        const decreaseBtn = document.getElementById('decreaseQty');
        const increaseBtn = document.getElementById('increaseQty');

        decreaseBtn.addEventListener('click', function() {
            let value = parseInt(qtyInput.value);
            if (value > 1) {
                qtyInput.value = value - 1;
            }
        });

        increaseBtn.addEventListener('click', function() {
            let value = parseInt(qtyInput.value);
            if (value < 11) {
                qtyInput.value = value + 1;
            }
        });

        // Option Buttons
        document.querySelectorAll('.option-button').forEach(button => {
            button.addEventListener('click', function() {
                if (!this.classList.contains('disabled')) {
                    const siblings = this.parentElement.querySelectorAll('.option-button');
                    siblings.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });

        // Flash Sale Timer
        function updateFlashTimer() {
            let hours = 1;
            let minutes = 39;
            let seconds = 54;

            setInterval(() => {
                seconds--;
                if (seconds < 0) {
                    seconds = 59;
                    minutes--;
                }
                if (minutes < 0) {
                    minutes = 59;
                    hours--;
                }
                if (hours < 0) {
                    hours = 0;
                    minutes = 0;
                    seconds = 0;
                }

                document.getElementById('hoursTimer').textContent = 
                    hours.toString().padStart(2, '0') + 'h';
                document.getElementById('minutesTimer').textContent = 
                    minutes.toString().padStart(2, '0') + 'm';
                document.getElementById('secondsTimer').textContent = 
                    seconds.toString().padStart(2, '0') + 's';
            }, 1000);
        }

        updateFlashTimer();

        // Social Share
        document.querySelectorAll('.social-icon').forEach(icon => {
            icon.addEventListener('click', function() {
                const platform = this.title;
                console.log(`Sharing on ${platform}`);
            });
        });

        // Add to Cart
        document.querySelector('.btn-add-cart').addEventListener('click', function() {
            alert('Product added to cart!');
        });

        // Buy Now
        document.querySelector('.btn-buy-now').addEventListener('click', function() {
            alert('Proceeding to checkout...');
        });

        // Tab Switching Function
        function switchTab(evt, tabName) {
            const tabContents = document.querySelectorAll('.tab-content');
            const tabButtons = document.querySelectorAll('.tab-button');

            tabContents.forEach(content => {
                content.style.display = 'none';
            });

            tabButtons.forEach(button => {
                button.classList.remove('active');
            });

            document.getElementById(tabName).style.display = 'block';
            evt.currentTarget.classList.add('active');
        }
// end product-details 

// Start Card Javascript code 
        // Toggle Select All Checkbox
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            
            updateCartTotal();
        }

        // Increase Quantity
        function increaseQty(button) {
            const input = button.previousElementSibling;
            let value = parseInt(input.value);
            if (value < 99) {
                input.value = value + 1;
                updateCartTotal();
            }
        }

        // Decrease Quantity
        function decreaseQty(button) {
            const input = button.nextElementSibling;
            let value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
                updateCartTotal();
            }
        }

        // Remove Item
        function removeItem(element) {
            if (confirm('Are you sure you want to remove this item from cart?')) {
                const item = element.closest('.cardpage-item');
                item.style.transition = 'all 0.3s ease';
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    item.remove();
                    updateCartCount();
                    updateCartTotal();
                }, 300);
            }
        }

        // Clear Cart
        function clearCart() {
            if (confirm('Are you sure you want to clear your entire cart?')) {
                const items = document.querySelectorAll('.cardpage-item');
                items.forEach(item => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.9)';
                });
                
                setTimeout(() => {
                    items.forEach(item => item.remove());
                    updateCartCount();
                    updateCartTotal();
                }, 300);
            }
        }

        // Update Cart Count
        function updateCartCount() {
            const itemCount = document.querySelectorAll('.cardpage-item').length;
            document.getElementById('cartCount').textContent = itemCount;
        }

        // Update Cart Total
        function updateCartTotal() {
            const checkedItems = document.querySelectorAll('.item-checkbox:checked');
            let total = 0;
            
            checkedItems.forEach(checkbox => {
                const item = checkbox.closest('.cardpage-item');
                const priceElement = item.querySelector('.cardpage-item-current-price');
                const qtyInput = item.querySelector('.cardpage-qty-input');
                
                const price = parseFloat(priceElement.textContent.replace('KSh ', '').replace(',', ''));
                const qty = parseInt(qtyInput.value);
                
                total += price * qty;
            });
            
            const formattedTotal = total.toLocaleString('en-KE', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
            
            document.getElementById('subtotalAmount').textContent = 'KSh ' + formattedTotal;
            document.getElementById('checkoutAmount').textContent = formattedTotal;
        }

        // Proceed to Checkout
        function proceedToCheckout() {
            const checkedItems = document.querySelectorAll('.item-checkbox:checked');
            
            if (checkedItems.length === 0) {
                alert('Please select at least one item to checkout.');
                return;
            }
            
            alert('Proceeding to checkout with ' + checkedItems.length + ' item(s)...');
        }

        // Initialize cart total on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check all items by default
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            
            document.getElementById('selectAllCheckbox').checked = true;
            updateCartTotal();
        });

//End Card javascript code


