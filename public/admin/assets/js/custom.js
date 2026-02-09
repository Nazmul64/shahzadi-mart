
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
            // Hide all sections
            document.querySelectorAll('.page-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Remove active from all menu items
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
            });

            // Remove active from bottom nav
            document.querySelectorAll('.bottom-nav-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(sectionId).classList.add('active');
            
            // Add active to clicked menu item
            event.currentTarget.classList.add('active');

            // Close sidebar on mobile
            if (window.innerWidth < 768) {
                toggleSidebar();
            }

            // Scroll to top
            window.scrollTo(0, 0);
        }

        // Sales Chart
        const salesCtx = document.getElementById('salesChart');
        if (salesCtx) {
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Sales',
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
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + (value / 1000) + 'K';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Order Status Chart
        const orderStatusCtx = document.getElementById('orderStatusChart');
        if (orderStatusCtx) {
            new Chart(orderStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Delivered', 'Processing', 'Pending', 'Cancelled'],
                    datasets: [{
                        data: [2941, 645, 261, 89],
                        backgroundColor: [
                            '#10b981',
                            '#f59e0b',
                            '#3b82f6',
                            '#ef4444'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 10,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        }

        // Show mobile card list on small screens
        function checkScreenSize() {
            const mobileCards = document.querySelectorAll('.mobile-card-list');
            const desktopTables = document.querySelectorAll('.table-responsive');
            
            if (window.innerWidth < 768) {
                mobileCards.forEach(card => card.style.display = 'block');
            } else {
                mobileCards.forEach(card => card.style.display = 'none');
            }
        }

        // Run on load and resize
        checkScreenSize();
        window.addEventListener('resize', checkScreenSize);

        // Close modals and show success message
        document.querySelectorAll('.modal .btn-primary').forEach(btn => {
            btn.addEventListener('click', function() {
                const modal = bootstrap.Modal.getInstance(this.closest('.modal'));
                if (modal) {
                    modal.hide();
                    // Show success toast (can be enhanced with actual toast component)
                    alert('Action completed successfully!');
                }
            });
        });

        // Simulate loading
        window.addEventListener('load', function() {
            const loadingOverlay = document.getElementById('loadingOverlay');
            setTimeout(() => {
                loadingOverlay.style.display = 'none';
            }, 500);
        });

        // Prevent body scroll when sidebar is open on mobile
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        sidebar.addEventListener('transitionend', function() {
            if (sidebar.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
  