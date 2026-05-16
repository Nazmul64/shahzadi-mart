  
        // Toggle Submenu for Admin Sidebar
        function sbToggle(element) {
            // Toggle open class on the clicked menu item
            element.classList.toggle('open');
            // Find the next sibling which should be the submenu container
            const subMenu = element.nextElementSibling;
            if (subMenu && subMenu.classList.contains('sb-sub')) {
                subMenu.classList.toggle('open');
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Toggle Filter
        function toggleFilter() {
            const filterContent = document.getElementById('filterContent');
            filterContent.classList.toggle('active');
        }

        // Show Section – enhanced to manage active states for menu and submenu links
        function showSection(sectionId) {
            const targetSection = document.getElementById(sectionId);
            
            // If section not found on current page
            if (!targetSection) {
                // Only redirect if we are NOT already on the dashboard page
                if (!window.location.pathname.includes('/saller/dashboard')) {
                    window.location.href = "/saller/dashboard?section=" + sectionId;
                } else {
                    console.warn("Section not found: " + sectionId);
                }
                return;
            }

            // Hide all page sections
            document.querySelectorAll('.page-section').forEach(section => {
                section.classList.remove('active');
            });

            // Clear active state from all top‑level menu items
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
                // also close any open submenu
                const sub = item.nextElementSibling;
                if (sub && sub.classList.contains('submenu')) {
                    sub.classList.remove('open');
                }
            });

            // Clear active from bottom navigation items
            document.querySelectorAll('.bottom-nav-item').forEach(item => {
                item.classList.remove('active');
            });

            // Activate the target page
            targetSection.classList.add('active');

            // Identify which menu item triggered the call (via event)
            if (window.event && window.event.currentTarget) {
                const clicked = window.event.currentTarget;
                // If a submenu link was clicked, mark its parent as active
                if (clicked.closest('.submenu')) {
                    const parentItem = clicked.closest('.submenu').previousElementSibling;
                    if (parentItem) parentItem.classList.add('active');
                }
                clicked.classList.add('active');
            }

            // Collapse sidebar on mobile after navigation
            if (window.innerWidth < 992) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                if (sidebar) sidebar.classList.remove('active');
                if (overlay) overlay.classList.remove('active');
            }

            window.scrollTo(0, 0);
        }

        // Attach click listeners to submenu links for proper active handling
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.submenu a').forEach(link => {
                link.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    
                    // Only prevent default and use showSection if it's a hash link
                    if (href && href.startsWith('#')) {
                        e.preventDefault();
                        const target = href.replace('#', '');
                        if (target) showSection(target);
                        
                        // Remove active from all submenu links first
                        document.querySelectorAll('.submenu a').forEach(l => l.classList.remove('active'));
                        this.classList.add('active');
                    }
                    // Otherwise, let the browser navigate normally to the real route
                });
            });
        });

        // Adjust Stock
        function adjustStock(productName) {
            alert('Adjusting stock for: ' + productName);
        }

        // Reorder Product
        function reorderProduct(productName) {
            alert('Creating reorder for: ' + productName);
        }

        // Charts
        // Sales Chart
        const salesCtx = document.getElementById('salesChart');
        if (salesCtx) {
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Sales (৳)',
                        data: [12000, 19000, 15000, 25000, 22000, 30000],
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        }

        // Order Chart
        const orderCtx = document.getElementById('orderChart');
        if (orderCtx) {
            new Chart(orderCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Delivered', 'Shipped', 'Processing', 'Pending'],
                    datasets: [{
                        data: [88, 45, 23, 10],
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, padding: 10, font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // Stock Movement Chart
        const stockMovementCtx = document.getElementById('stockMovementChart');
        if (stockMovementCtx) {
            new Chart(stockMovementCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [
                        {
                            label: 'Stock In',
                            data: [150, 200, 180, 220, 190, 250],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4
                        },
                        {
                            label: 'Stock Out',
                            data: [120, 150, 140, 180, 160, 200],
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: true, position: 'top' } }
                }
            });
        }

        // Stock Distribution Chart
        const stockDistCtx = document.getElementById('stockDistributionChart');
        if (stockDistCtx) {
            new Chart(stockDistCtx, {
                type: 'doughnut',
                data: {
                    labels: ['In Stock', 'Low Stock', 'Out of Stock'],
                    datasets: [{
                        data: [228, 12, 5],
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, padding: 10, font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // Payout Trends Chart
        const payoutTrendsCtx = document.getElementById('payoutTrendsChart');
        if (payoutTrendsCtx) {
            new Chart(payoutTrendsCtx, {
                type: 'bar',
                data: {
                    labels: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
                    datasets: [{
                        label: 'Net Earnings (৳)',
                        data: [25000, 28000, 27000, 27582, 33065, 38420],
                        backgroundColor: 'rgba(37, 99, 235, 0.8)',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        }

        // Earnings Chart
        const earningsCtx = document.getElementById('earningsChart');
        if (earningsCtx) {
            new Chart(earningsCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Net Earnings', 'Commission'],
                    datasets: [{
                        data: [77200, 12300],
                        backgroundColor: ['#10b981', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, padding: 10, font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // Monthly Earnings Chart
        const monthlyEarningsCtx = document.getElementById('monthlyEarningsChart');
        if (monthlyEarningsCtx) {
            new Chart(monthlyEarningsCtx, {
                type: 'bar',
                data: {
                    labels: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
                    datasets: [
                        {
                            label: 'Gross Revenue',
                            data: [342700, 334850, 345600, 389200, 458900, 542300],
                            backgroundColor: 'rgba(37, 99, 235, 0.3)',
                            borderColor: '#2563eb',
                            borderWidth: 2
                        },
                        {
                            label: 'Net Earnings',
                            data: [291295, 284622, 293760, 330820, 390065, 460955],
                            backgroundColor: 'rgba(16, 185, 129, 0.8)',
                            borderColor: '#10b981',
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '৳' + (value / 1000) + 'K';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Revenue Breakdown Chart
        const revenueBreakdownCtx = document.getElementById('revenueBreakdownChart');
        if (revenueBreakdownCtx) {
            new Chart(revenueBreakdownCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Electronics', 'Fashion', 'Others'],
                    datasets: [{
                        data: [385000, 124500, 32800],
                        backgroundColor: ['#2563eb', '#10b981', '#f59e0b'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, padding: 10, font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // Product Functions
        function deleteProduct(productName) {
            if (confirm('Are you sure you want to delete "' + productName + '"?')) {
                alert('Product "' + productName + '" has been deleted!');
            }
        }

        function saveProduct() {
            alert('Product added successfully!');
            const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
            modal.hide();
        }

        function updateProduct() {
            alert('Product updated successfully!');
            const modal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
            modal.hide();
        }

        // Order Functions
        function updateOrderStatus() {
            const status = document.getElementById('orderStatus').value;
            alert('Order status updated to: ' + status);
            const modal = bootstrap.Modal.getInstance(document.getElementById('updateOrderModal'));
            modal.hide();
        }

        // Review Functions
        function replyToReview() {
            alert('Your reply has been posted successfully!');
            const modal = bootstrap.Modal.getInstance(document.getElementById('replyReviewModal'));
            modal.hide();
        }

        // Message Functions
        function selectConversation(customerName) {
            console.log('Selected conversation with: ' + customerName);
            // In real app, this would load the conversation messages
        }

        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();

            if (message) {
                alert('Message sent: ' + message);
                messageInput.value = '';
            } else {
                alert('Please enter a message');
            }
        }

        // Show mobile card list on small screens
        function checkScreenSize() {
            const mobileCards = document.querySelectorAll('.mobile-card-list');

            if (window.innerWidth < 768) {
                mobileCards.forEach(card => card.style.display = 'block');
            } else {
                mobileCards.forEach(card => card.style.display = 'none');
            }
        }

        checkScreenSize();
        window.addEventListener('resize', checkScreenSize);
