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

    <!-- Toggle Sidebar Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggleBtn = document.querySelector('.toggle-sidebar-btn');
            var sidebar = document.getElementById('sidebar');

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