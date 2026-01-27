    <!-- Footer (Fixed at Bottom) -->
    <footer>
        <p>
            Copyright &copy; <?php echo date('Y'); ?> All rights reserved. Powered by <?php 
                if (!defined('NAME')) {
                    include('../../details.php');
                }
                echo defined('NAME') ? htmlspecialchars(NAME) : 'Priest Dev'; 
            ?>
        </p>
    </footer>
    </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- jQuery MUST load before Bootstrap JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap JS for collapse functionality -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar & Theme Script -->
    <script>
        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('admin-theme') || 'light';
            applyTheme(savedTheme);
            updateThemeButton(savedTheme);
        });

        // Update theme button appearance
        function updateThemeButton(theme) {
            const btn = document.getElementById('themeToggle');
            if (!btn) return;
            
            const isDark = theme === 'dark';
            const icon = btn.querySelector('i');
            const span = btn.querySelector('span');
            
            if (isDark) {
                // Dark mode active - show sun icon to switch to light
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                span.textContent = 'Light Mode';
                btn.setAttribute('data-theme', 'dark');
            } else {
                // Light mode active - show moon icon to switch to dark
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                span.textContent = 'Dark Mode';
                btn.removeAttribute('data-theme');
            }
        }

        // Apply theme to entire page uniformly
        function applyTheme(theme) {
            const isDark = theme === 'dark';
            
            // Apply to html element
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.style.colorScheme = theme;
            
            // Apply to body element
            if (isDark) {
                document.body.setAttribute('data-theme', 'dark');
                document.body.classList.add('dark-mode');
                document.body.style.colorScheme = 'dark';
            } else {
                document.body.removeAttribute('data-theme');
                document.body.classList.remove('dark-mode');
                document.body.style.colorScheme = 'light';
            }
            
            // Force CSS variables update
            const root = document.documentElement;
            if (isDark) {
                root.style.setProperty('--bg-primary', '#0f0f0f');
                root.style.setProperty('--bg-secondary', '#1a1a1a');
                root.style.setProperty('--text-primary', '#f3f4f6');
                root.style.setProperty('--text-secondary', '#9ca3af');
                root.style.setProperty('--border-color', '#333333');
            } else {
                root.style.setProperty('--bg-primary', '#ffffff');
                root.style.setProperty('--bg-secondary', '#f9fafb');
                root.style.setProperty('--text-primary', '#1f2937');
                root.style.setProperty('--text-secondary', '#6b7280');
                root.style.setProperty('--border-color', '#e5e7eb');
            }
            
            // Update all elements with CSS variable dependencies
            updateElementStyles();
            
            // Update logo filter based on theme
            const logoImg = document.querySelector('.sidebar-brand-logo');
            if (logoImg) {
                if (isDark) {
                    logoImg.style.filter = 'brightness(1.3) contrast(1.1) drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3))';
                } else {
                    logoImg.style.filter = 'brightness(1.15) contrast(1.2) drop-shadow(0 2px 6px rgba(0, 0, 0, 0.2))';
                }
            }
            
            // Update sidebar background
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                if (isDark) {
                    sidebar.style.background = 'linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 100%)';
                } else {
                    sidebar.style.background = 'linear-gradient(135deg, #2d1b4e 0%, #3d2660 100%)';
                }
            }
            
            // Update header background
            const header = document.querySelector('.header');
            if (header) {
                if (isDark) {
                    header.style.background = 'linear-gradient(135deg, #1a1a1a 0%, #262626 100%)';
                    header.style.borderBottomColor = 'rgba(255, 255, 255, 0.1)';
                } else {
                    header.style.background = 'linear-gradient(135deg, #622faa 0%, #7d3fc0 100%)';
                    header.style.borderBottomColor = 'rgba(255, 255, 255, 0.2)';
                }
            }
            
            // Force repaint on all elements
            document.body.style.transition = 'background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease';
            setTimeout(() => {
                document.body.style.transition = '';
            }, 300);
        }

        // Update element styles that depend on CSS variables
        function updateElementStyles() {
            const isDark = localStorage.getItem('admin-theme') === 'dark';
            
            // Refresh cards and containers
            const cards = document.querySelectorAll('.card, .stat-card, .modal-content, .navbar, .topbar');
            cards.forEach(card => {
                if (card.classList.contains('table-responsive')) return;
                card.style.backgroundColor = 'var(--bg-secondary)';
                card.style.borderColor = 'var(--border-color)';
                card.style.color = 'var(--text-primary)';
            });
            
            // Refresh form elements
            const forms = document.querySelectorAll('.form-control, .form-select, input[type="text"], input[type="email"], input[type="password"], input[type="number"], textarea, select, .input-group');
            forms.forEach(form => {
                if (form.classList.contains('btn') || form.classList.contains('toggle-sidebar-btn')) return;
                form.style.backgroundColor = 'var(--bg-secondary)';
                form.style.borderColor = 'var(--border-color)';
                form.style.color = 'var(--text-primary)';
            });
            
            // Refresh table elements
            const tables = document.querySelectorAll('table');
            tables.forEach(table => {
                table.style.backgroundColor = 'var(--bg-secondary)';
                table.style.borderColor = 'var(--border-color)';
                table.style.color = 'var(--text-primary)';
            });
            
            const tableHeads = document.querySelectorAll('thead, thead tr, thead th');
            tableHeads.forEach(th => {
                th.style.backgroundColor = isDark ? '#333333' : '#f3f4f6';
                th.style.color = 'var(--text-primary)';
            });
            
            const tableRows = document.querySelectorAll('tbody tr, tbody td');
            tableRows.forEach(row => {
                row.style.borderColor = 'var(--border-color)';
                row.style.color = 'var(--text-primary)';
            });
            
            // Refresh text elements uniformly
            const textElements = document.querySelectorAll('h1, h2, h3, h4, h5, h6, p, span, label, div, section, main, article');
            textElements.forEach(elem => {
                // Only apply if not a button or special element
                if (!elem.classList.contains('btn') && !elem.classList.contains('badge') && 
                    elem.tagName !== 'BUTTON' && elem.tagName !== 'A' && 
                    !elem.classList.contains('btn-group')) {
                    const computedStyle = window.getComputedStyle(elem);
                    // Only set if element doesn't have inline important styles
                    if (!elem.style.color || !elem.style.color.includes('!important')) {
                        elem.style.color = 'var(--text-primary)';
                    }
                }
            });
            
            // Update links uniformly
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                if (!link.classList.contains('btn') && !link.classList.contains('dropdown-item')) {
                    link.style.color = 'var(--primary-color)';
                }
            });
            
            // Update dropdown items
            const dropdownItems = document.querySelectorAll('.profile-dropdown-item, .dropdown-item');
            dropdownItems.forEach(item => {
                item.style.color = 'var(--text-primary)';
            });
            
            // Update page background
            const main = document.querySelector('#content');
            if (main) {
                main.style.backgroundColor = 'var(--bg-primary)';
            }
            
            // Update wrapper
            const wrapper = document.getElementById('wrapper');
            if (wrapper) {
                wrapper.style.backgroundColor = 'var(--bg-primary)';
            }
        }

        // Initialize Bootstrap Collapse
        document.addEventListener('DOMContentLoaded', function() {
            const collapseElements = document.querySelectorAll('[data-toggle="collapse"]');
            collapseElements.forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('data-target'));
                    if (target) {
                        const isExpanded = this.getAttribute('aria-expanded') === 'true';
                        
                        // Close other collapse items
                        document.querySelectorAll('.collapse.show').forEach(item => {
                            if (item.id !== target.id) {
                                item.classList.remove('show');
                                const btn = document.querySelector(`[data-target="#${item.id}"]`);
                                if (btn) btn.setAttribute('aria-expanded', 'false');
                            }
                        });
                        
                        // Toggle current
                        if (isExpanded) {
                            target.classList.remove('show');
                            this.setAttribute('aria-expanded', 'false');
                        } else {
                            target.classList.add('show');
                            this.setAttribute('aria-expanded', 'true');
                        }
                    }
                });
            });
        });

        // Toggle Sidebar Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('.toggle-sidebar-btn');
            const sidebar = document.getElementById('sidebar');
            const wrapper = document.getElementById('wrapper');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }

            // Close sidebar when clicking outside
            document.addEventListener('click', function(event) {
                if (sidebar && !sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                    if (window.innerWidth < 768) {
                        sidebar.classList.remove('active');
                    }
                }
            });

            // Close sidebar on window resize if > 768px
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('active');
                }
            });
        });

        // Theme Toggle
        document.getElementById('themeToggle')?.addEventListener('click', function() {
            const currentTheme = localStorage.getItem('admin-theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            // Save to localStorage
            localStorage.setItem('admin-theme', newTheme);
            
            // Apply theme
            applyTheme(newTheme);
            
            // Update button appearance
            updateThemeButton(newTheme);
        });
    </script>
</body>
</html>