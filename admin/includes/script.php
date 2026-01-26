    <!-- Font Awesome (already loaded in header, but included for reference) -->
    <script src="vendor/fontawesome-free/js/all.min.js"></script>
    
    <!-- Core admin scripts -->
    <script>
        // ========================================
        // THEME MANAGEMENT
        // ========================================
        document.addEventListener('DOMContentLoaded', function() {
            const theme = localStorage.getItem('admin-theme') || 'light';
            if (theme === 'dark') {
                document.body.classList.add('dark-mode');
            }
            
            // Theme toggle
            const themeToggle = document.getElementById('themeToggle');
            if (themeToggle) {
                themeToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    document.body.classList.toggle('dark-mode');
                    const isDark = document.body.classList.contains('dark-mode');
                    localStorage.setItem('admin-theme', isDark ? 'dark' : 'light');
                });
            }
        });

        // ========================================
        // SIDEBAR TOGGLE (Mobile)
        // ========================================
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('.toggle-sidebar-btn');
            const sidebar = document.getElementById('sidebar');
            const wrapper = document.getElementById('wrapper');
            
            if (toggleBtn && sidebar) {
                // Toggle sidebar on button click
                toggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('show');
                });
                
                // Close sidebar when clicking outside
                document.addEventListener('click', function(e) {
                    const isClickInside = sidebar.contains(e.target);
                    const isClickOnButton = toggleBtn.contains(e.target);
                    
                    if (!isClickInside && !isClickOnButton && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
                
                // Close sidebar when a link is clicked
                const sidebarLinks = sidebar.querySelectorAll('a');
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        // Don't close for collapse toggles
                        if (!this.hasAttribute('data-toggle')) {
                            sidebar.classList.remove('show');
                        }
                    });
                });
            }
        });

        // ========================================
        // DROPDOWN/COLLAPSE MENUS
        // ========================================
        document.addEventListener('DOMContentLoaded', function() {
            const collapseLinks = document.querySelectorAll('[data-toggle="collapse"]');
            
            collapseLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const targetSelector = this.getAttribute('data-target');
                    const menu = document.querySelector(targetSelector);
                    
                    if (menu) {
                        menu.classList.toggle('show');
                        const isExpanded = this.getAttribute('aria-expanded') === 'true';
                        this.setAttribute('aria-expanded', !isExpanded);
                    }
                });
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('[data-toggle="collapse"]') && 
                    !e.target.closest('.collapse')) {
                    // Don't close on nested clicks
                }
            });
        });

        // ========================================
        // MODAL HANDLING
        // ========================================
        window.showModal = function(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'flex';
                modal.classList.add('show');
            }
        };

        window.closeModal = function(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
            }
        };

        // Close modal on backdrop click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.style.display = 'none';
                e.target.classList.remove('show');
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('.modal-overlay.show');
                modals.forEach(modal => {
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                });
            }
        });

        // ========================================
        // FORM VALIDATION
        // ========================================
        window.validateForm = function(formElement) {
            const inputs = formElement.querySelectorAll('[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            return isValid;
        };

        // ========================================
        // UTILITIES
        // ========================================
        window.formatCurrency = function(value, decimals = 2) {
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals
            }).format(value);
        };

        window.showToast = function(message, type = 'info', duration = 3000) {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type}`;
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                max-width: 400px;
                z-index: 9999;
                animation: slideIn 0.3s ease;
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, duration);
        };

        // ========================================
        // TABLE SEARCH FUNCTIONALITY
        // ========================================
        window.tableSearch = function(inputId, tableId) {
            const input = document.getElementById(inputId);
            const table = document.getElementById(tableId);
            
            if (input && table) {
                input.addEventListener('keyup', function() {
                    const filter = this.value.toUpperCase();
                    const rows = table.querySelectorAll('tbody tr');
                    
                    rows.forEach(row => {
                        let found = false;
                        const cells = row.querySelectorAll('td');
                        
                        cells.forEach(cell => {
                            if (cell.textContent.toUpperCase().indexOf(filter) > -1) {
                                found = true;
                            }
                        });
                        
                        row.style.display = found ? '' : 'none';
                    });
                });
            }
        };

        // ========================================
        // RESPONSIVE BEHAVIOR
        // ========================================
        function handleResponsive() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar && window.innerWidth > 768) {
                sidebar.classList.remove('show');
            }
        }

        window.addEventListener('resize', handleResponsive);
        document.addEventListener('DOMContentLoaded', handleResponsive);
    </script>
