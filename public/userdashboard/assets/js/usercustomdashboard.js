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
