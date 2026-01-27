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

    <!-- Theme initialization - apply saved theme before navbar.php runs -->
    <script>
        (function() {
            // Apply saved theme immediately to prevent flash
            var savedTheme = localStorage.getItem('admin-theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark-mode');
                document.body.classList.add('dark-mode');
            }
        })();
    </script>
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
    </script>
</body>
</html>