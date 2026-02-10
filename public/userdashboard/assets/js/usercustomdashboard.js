
        // Toggle Sidebar (Mobile)
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Show Section
        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });

            // Show selected section
            document.getElementById(sectionId).classList.add('active');

            // Update active nav item
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });

            // Close sidebar on mobile
            if (window.innerWidth < 769) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.querySelector('.sidebar-overlay');
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Switch Tab
        function switchTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            // Show selected tab content
            document.getElementById(tabId).classList.add('active');

            // Update active tab button
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
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
            const stars = document.querySelectorAll('.star-input');
            stars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
            });

            // Character counter for textareas
            const textareas = document.querySelectorAll('.form-textarea');
            textareas.forEach(textarea => {
                const charCount = textarea.nextElementSibling;
                if (charCount && charCount.classList.contains('char-count')) {
                    textarea.addEventListener('input', function() {
                        const length = this.value.length;
                        charCount.textContent = length + ' / 200';
                    });
                }
            });
        });
