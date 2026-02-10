  
        // Toggle Sidebar
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

        // Show Section
        function showSection(sectionId) {
            document.querySelectorAll('.page-section').forEach(section => {
                section.classList.remove('active');
            });

            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
            });

            document.querySelectorAll('.bottom-nav-item').forEach(item => {
                item.classList.remove('active');
            });

            document.getElementById(sectionId).classList.add('active');

            if (event && event.currentTarget) {
                event.currentTarget.classList.add('active');
            }

            if (window.innerWidth < 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }

            window.scrollTo(0, 0);
        }

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
                        borderColor: '#FF6B35',
                        backgroundColor: 'rgba(255, 107, 53, 0.1)',
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
                        backgroundColor: 'rgba(255, 107, 53, 0.8)',
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
                            backgroundColor: 'rgba(255, 107, 53, 0.3)',
                            borderColor: '#FF6B35',
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
                        backgroundColor: ['#FF6B35', '#10b981', '#f59e0b'],
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
