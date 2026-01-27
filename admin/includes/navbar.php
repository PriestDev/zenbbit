<!-- ========================================
     NAVBAR & SIDEBAR CONTAINER
     ======================================== -->

<!-- Navbar CSS with theme support -->
<style>
/* CSS Variables for theming - Light Mode Default */
:root {
    --navbar-bg: #ffffff;
    --navbar-border: #e5e7eb;
    --navbar-text: #1f2937;
    --sidebar-bg: #f9fafb;
    --sidebar-text: #374151;
    --collapse-bg: #f3f4f6;
    --collapse-text: #6b7280;
    --bg-primary: #ffffff;
    --bg-secondary: #f9fafb;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --border-color: #e5e7eb;
    --primary-color: #622faa;
}

/* Dark Mode */
html[data-theme="dark"],
html[data-theme="dark"] body,
body[data-theme="dark"],
body.dark-mode {
    --navbar-bg: #1a1a1a;
    --navbar-border: #333333;
    --navbar-text: #f3f4f6;
    --sidebar-bg: #0f0f0f;
    --sidebar-text: #d1d5db;
    --collapse-bg: #2d2d2d;
    --collapse-text: #9ca3af;
    --bg-primary: #0f0f0f;
    --bg-secondary: #1a1a1a;
    --text-primary: #f3f4f6;
    --text-secondary: #9ca3af;
    --border-color: #333333;
}

/* Header/Navbar Styles */
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1.5rem;
    background-color: var(--navbar-bg);
    border-bottom: 1px solid var(--navbar-border);
    height: 60px;
    z-index: 1000;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.toggle-sidebar-btn {
    display: none;
    background: none;
    border: none;
    color: var(--navbar-text);
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0.5rem;
    transition: color 0.2s ease;
}

.toggle-sidebar-btn:hover {
    color: var(--primary-color, #622faa);
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon-btn,
.profile-dropdown-trigger {
    background: none;
    border: none;
    color: var(--navbar-text);
    cursor: pointer;
    font-size: 1.25rem;
    padding: 0.5rem;
    transition: all 0.2s ease;
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.header-icon-btn:hover,
.profile-dropdown-trigger:hover {
    color: var(--primary-color, #622faa);
}

.notification-badge {
    position: absolute;
    top: 0;
    right: 0;
    background-color: #ef4444;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: bold;
}

/* Dropdown Menus */
.notification-dropdown-menu,
.profile-dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background-color: var(--navbar-bg);
    border: 1px solid var(--navbar-border);
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    min-width: 280px;
    max-height: 400px;
    overflow-y: auto;
    z-index: 1001;
    display: none !important;
    visibility: hidden;
    opacity: 0;
    pointer-events: none;
    transition: all 0.2s ease;
}

.notification-dropdown-wrapper.show .notification-dropdown-menu,
.profile-dropdown-wrapper.show .profile-dropdown-menu {
    display: block !important;
    visibility: visible;
    opacity: 1;
    pointer-events: auto;
}

.notification-dropdown-header,
.profile-dropdown-header {
    padding: 1rem;
    border-bottom: 1px solid var(--navbar-border);
}

.notification-dropdown-body {
    max-height: 250px;
    overflow-y: auto;
}

.notification-item,
.profile-dropdown-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: var(--navbar-text);
    text-decoration: none;
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
}

.notification-item:hover,
.profile-dropdown-item:hover {
    background-color: var(--collapse-bg);
    border-left-color: var(--primary-color, #622faa);
}

.notification-content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    flex: 1;
    margin-left: 0.75rem;
}

.notification-title {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--navbar-text);
}

.notification-amount {
    font-size: 0.85rem;
    color: var(--collapse-text);
}

.notification-dropdown-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1rem;
    color: var(--primary-color, #622faa);
    text-decoration: none;
    font-weight: 500;
    border-top: 1px solid var(--navbar-border);
}

/* Sidebar Styles */
#sidebar {
    position: fixed;
    left: 0;
    top: 60px;
    width: 260px;
    height: calc(100vh - 60px);
    background-color: var(--sidebar-bg);
    border-right: 1px solid var(--navbar-border);
    padding: 0;
    overflow-y: auto;
    z-index: 999;
    transition: transform 0.3s ease;
}

.sidebar-brand {
    padding: 1.5rem;
    text-align: center;
    border-bottom: 1px solid var(--navbar-border);
}

.sidebar-brand-logo {
    max-width: 100%;
    height: auto;
    max-height: 60px;
}

.sidebar-brand-text {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--navbar-text);
}

.sidebar-divider {
    height: 1px;
    background-color: var(--navbar-border);
    margin: 1rem 0;
}

.sidebar-heading {
    padding: 0.75rem 1.5rem;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--collapse-text);
    letter-spacing: 0.05em;
}

.sidebar-footer {
    padding: 1rem;
    border-top: 1px solid var(--navbar-border);
    margin-top: auto;
}

.sidebar-footer-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

/* Navigation Styles */
.nav-item {
    list-style: none;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    color: var(--sidebar-text);
    text-decoration: none;
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
    cursor: pointer;
    font-weight: 500;
    font-size: 0.95rem;
}

.nav-link i {
    margin-right: 0.75rem;
    width: 1.25rem;
    text-align: center;
}

.nav-link:hover {
    background-color: var(--collapse-bg);
    color: var(--navbar-text);
    border-left-color: var(--primary-color, #622faa);
    padding-left: 1.75rem;
}

.nav-link.collapsed {
    background-color: transparent;
}

/* Collapse Menu Styles - Show by default */
.collapse {
    display: block !important;
    max-height: 1000px;
    overflow: visible;
    visibility: visible;
    transition: max-height 0.3s ease, visibility 0.3s ease;
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.08) 0%, rgba(0, 0, 0, 0.04) 100%);
    border-left: 3px solid var(--primary-color, #622faa);
    margin: 0.5rem 1rem 0.5rem 1rem;
    border-radius: 0.375rem;
    padding: 0.5rem 0;
}

.collapse.collapse-closed {
    display: none !important;
    max-height: 0;
    overflow: hidden;
    visibility: hidden;
}

.collapse-item {
    display: flex !important;
    align-items: center;
    gap: 0.75rem;
    visibility: visible !important;
    padding: 0.75rem 1.5rem 0.75rem 3rem;
    color: var(--collapse-text);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    border-left: 3px solid transparent;
    transition: all 0.2s ease;
    background-color: transparent;
    margin: 0.25rem 0;
    line-height: 1.4;
}

.collapse-item i {
    margin-right: 0.25rem;
    font-size: 0.75rem;
    width: 1rem;
    text-align: center;
    opacity: 0.8;
}

.collapse-item:hover {
    color: var(--navbar-text);
    background-color: var(--collapse-bg);
    border-left-color: var(--primary-color, #622faa);
    padding-left: 3.25rem;
}

.collapse-item:active {
    background-color: var(--collapse-bg);
    color: var(--primary-color, #622faa);
    border-left-color: var(--primary-color, #622faa);
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .toggle-sidebar-btn {
        display: block;
    }
    
    #sidebar {
        transform: translateX(-100%);
        box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
    }
    
    #sidebar.show {
        transform: translateX(0);
    }
    
    .header {
        padding: 0.75rem 1rem;
    }
}
</style>

<!-- Navbar HTML Structure -->
<div class="header">
    <!-- Left: Toggle Sidebar Button (Mobile Only) -->
    <button class="toggle-sidebar-btn" title="Toggle Sidebar">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Center: Spacer (Flexbox growth) -->
    <div style="flex: 1;"></div>
    
    <!-- Right: Header Actions (Notifications, Profile & Logout) -->
    <div class="header-actions">
        <!-- Notification Dropdown -->
        <div class="notification-dropdown-wrapper">
            <button class="header-icon-btn notification-trigger" title="View Notifications">
                <i class="fas fa-bell"></i>
                <?php
                    // Get pending transactions count
                    $pending_query = "SELECT COUNT(id) AS num FROM transaction WHERE serial = 0";
                    $pending_result = mysqli_query($conn, $pending_query);
                    $pending_data = mysqli_fetch_assoc($pending_result);
                    $pending_count = isset($pending_data['num']) ? intval($pending_data['num']) : 0;
                    
                    if ($pending_count > 0) {
                        echo '<span class="notification-badge">' . min($pending_count, 99) . (($pending_count > 99) ? '+' : '') . '</span>';
                    }
                ?>
            </button>
            
            <!-- Notification Dropdown Menu (Hidden by default) -->
            <div class="notification-dropdown-menu">
                <div class="notification-dropdown-header">
                    <h6 style="margin: 0; padding: 0;">Notifications</h6>
                    <small style="opacity: 0.7;"><?php echo $pending_count; ?> Pending</small>
                </div>
                <div class="notification-dropdown-body">
                    <?php
                        // Fetch recent pending transactions
                        $notif_query = "SELECT id, name, status, amt, create_date FROM transaction WHERE serial = 0 ORDER BY create_date DESC LIMIT 5";
                        $notif_result = mysqli_query($conn, $notif_query);
                        
                        if ($notif_result && mysqli_num_rows($notif_result) > 0) {
                            while ($notif = mysqli_fetch_assoc($notif_result)) {
                                $is_deposit = strtolower($notif['status']) === 'deposit';
                                $type_icon = $is_deposit ? 'fa-plus-circle text-success' : 'fa-minus-circle text-danger';
                                $type_label = $is_deposit ? 'Deposit' : 'Withdrawal';
                                $amount = htmlspecialchars($notif['amt']);
                                $username = htmlspecialchars($notif['name']);
                                $link = $is_deposit ? 'deposit.php' : 'withdraw.php';
                                echo '
                                <a href="'.$link.'" class="notification-item">
                                    <i class="fas '.$type_icon.'"></i>
                                    <div class="notification-content">
                                        <span class="notification-title">'.$type_label.' - '.$username.'</span>
                                        <span class="notification-amount">$'.$amount.'</span>
                                    </div>
                                </a>';
                            }
                        } else {
                            echo '<div class="notification-empty" style="padding: 2rem 1rem; text-align: center; color: var(--collapse-text);"><i class="fas fa-inbox"></i><p>No pending transactions</p></div>';
                        }
                    ?>
                </div>
                <hr style="margin: 0.5rem 0; border-color: var(--navbar-border);">
                <a href="notification.php" class="notification-dropdown-footer">
                    <span>View All Notifications</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <!-- Admin Username & Profile Image with Dropdown -->
        <div class="profile-dropdown-wrapper">
            <button class="profile-dropdown-trigger" title="Profile Options">
                <span>
                    <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?>
                </span>
                <?php
                    $admin = isset($_SESSION['username']) ? $_SESSION['username'] : '';
                    if ($admin) {
                        $sql = "SELECT image FROM admin WHERE user_name = ? LIMIT 1";
                        if ($stmt = mysqli_prepare($conn, $sql)) {
                            mysqli_stmt_bind_param($stmt, 's', $admin);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            if ($row = mysqli_fetch_assoc($result)) {
                                if (!empty($row['image'])) {
                                    echo '<img src="../uploads/'.htmlspecialchars($row['image']).'" alt="Profile" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;" title="Click for profile options">';
                                } else {
                                    echo '<div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #622faa, #8b5fbf); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.9rem;"><i class="fas fa-user"></i></div>';
                                }
                            }
                            mysqli_stmt_close($stmt);
                        }
                    }
                ?>
            </button>
            
            <!-- Profile Dropdown Menu -->
            <div class="profile-dropdown-menu">
                <div class="profile-dropdown-header">
                    <h6 style="margin: 0; padding: 0;">
                        <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?>
                    </h6>
                    <small style="opacity: 0.7;">Admin Account</small>
                </div>
                <hr style="margin: 0.5rem 0; border-color: var(--navbar-border);">
                <a href="admin.php" class="profile-dropdown-item">
                    <i class="fas fa-fw fa-user-cog"></i>
                    <span>Update Profile</span>
                </a>
                <a href="security.php" class="profile-dropdown-item">
                    <i class="fas fa-fw fa-shield-alt"></i>
                    <span>Security Settings</span>
                </a>
                <hr style="margin: 0.5rem 0; border-color: var(--navbar-border);">
                <a href="logout.php" class="profile-dropdown-item" style="color: #ef4444;">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Sign Out</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ========================================
     SIDEBAR NAVIGATION
     ======================================== -->
<nav id="sidebar">
    <!-- Sidebar Brand (Logo/Site Name) -->
    <div class="sidebar-brand">
        <?php
            $sql = "SELECT * FROM page_content LIMIT 1";
            $run = mysqli_query($conn, $sql);
            if ($run && $row = mysqli_fetch_assoc($run)) {
                if (!empty($row['logo'])) {
                    // Logo image with responsive sizing
                    $logo_path = "../uploads/".htmlspecialchars($row['logo']);
                    // Check if file exists
                    if (file_exists(__DIR__ . '/../' . $logo_path)) {
                        echo '<img src="'.$logo_path.'" alt="'.htmlspecialchars($row['site_name'] ?? 'Logo').'" class="sidebar-brand-logo" title="'.htmlspecialchars($row['site_name'] ?? 'Site Logo').'">';
                    } else {
                        // Fallback to text if image doesn't exist
                        echo '<div class="sidebar-brand-text">' . htmlspecialchars($row['site_name'] ?? 'Admin') . '</div>';
                    }
                } else if (!empty($row['site_name'])) {
                    // Fallback to site name text
                    echo '<div class="sidebar-brand-text">' . htmlspecialchars($row['site_name']) . '</div>';
                } else {
                    // Ultimate fallback
                    echo '<div class="sidebar-brand-text">Admin</div>';
                }
            }
        ?>
    </div>

    <div class="sidebar-divider"></div>

    <!-- Navigation Items -->
    <ul style="list-style: none; padding: 0; margin: 0;">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="index.php" class="nav-link">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <div class="sidebar-divider"></div>
        <div class="sidebar-heading">Management</div>

        <!-- Admin & Users Menu -->
        <li class="nav-item">
            <a href="#manageMenu" class="nav-link collapsed" data-toggle="collapse" data-target="#manageMenu" aria-expanded="false">
                <i class="fas fa-fw fa-users"></i>
                <span>Management</span>
            </a>
            <div id="manageMenu" class="collapse" data-parent="#sidebar">
                <a href="register.php" class="collapse-item"><i class="fas fa-shield-alt"></i> Admin List</a>
                <a href="users.php" class="collapse-item"><i class="fas fa-user-circle"></i> Users List</a>
                <a href="plan.php" class="collapse-item"><i class="fas fa-chart-line"></i> Trading Plans</a>
            </div>
        </li>

        <!-- Transactions Menu -->
        <li class="nav-item">
            <a href="#transMenu" class="nav-link collapsed" data-toggle="collapse" data-target="#transMenu" aria-expanded="false">
                <i class="fas fa-fw fa-donate"></i>
                <span>Transactions</span>
            </a>
            <div id="transMenu" class="collapse" data-parent="#sidebar">
                <a href="deposit.php" class="collapse-item"><i class="fas fa-plus-circle"></i> Deposits</a>
                <a href="withdraw.php" class="collapse-item"><i class="fas fa-minus-circle"></i> Withdrawals</a>
                <a href="other.php" class="collapse-item"><i class="fas fa-exchange-alt"></i> Other</a>
            </div>
        </li>

        <div class="sidebar-divider"></div>
        <div class="sidebar-heading">Configuration</div>

        <!-- Settings Menu -->
        <li class="nav-item">
            <a href="#settingsMenu" class="nav-link collapsed" data-toggle="collapse" data-target="#settingsMenu" aria-expanded="false">
                <i class="fas fa-fw fa-cog"></i>
                <span>Settings</span>
            </a>
            <div id="settingsMenu" class="collapse" data-parent="#sidebar">
                <a href="homepage.php" class="collapse-item"><i class="fas fa-home"></i> Homepage</a>
                <a href="mail.php" class="collapse-item"><i class="fas fa-envelope"></i> Send Email</a>
                <a href="mails.php" class="collapse-item"><i class="fas fa-inbox"></i> Email History</a>
                <a href="notification.php" class="collapse-item"><i class="fas fa-bell"></i> Notifications</a>
            </div>
        </li>
    </ul>

    <!-- Sidebar Footer (Theme Toggle & Logout) -->
    <div class="sidebar-footer">
        <div class="sidebar-footer-buttons">
            <button id="themeToggle" class="btn btn-sm btn-secondary w-100" title="Toggle Dark/Light Mode">
                <i class="fas fa-moon"></i> <span>Dark Mode</span>
            </button>
            <a href="logout.php" class="btn btn-sm btn-danger w-100" title="Sign Out">
                <i class="fas fa-sign-out-alt"></i> <span>Sign Out</span>
            </a>
        </div>
    </div>
</nav>

<!-- ========================================
     NAVBAR & SIDEBAR INTERACTIVE SCRIPTS
     ======================================== -->
<script>
(function() {
    'use strict';
    
    // ===========================================
    // 1. MOBILE SIDEBAR TOGGLE
    // ===========================================
    function initMobileSidebarToggle() {
        var toggleBtn = document.querySelector('.toggle-sidebar-btn');
        var sidebar = document.getElementById('sidebar');
        
        if (!toggleBtn || !sidebar) return;
        
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            sidebar.classList.toggle('show');
        });
        
        // Close sidebar when clicking outside on mobile
        if (window.innerWidth <= 768) {
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#sidebar') && !e.target.closest('.toggle-sidebar-btn')) {
                    sidebar.classList.remove('show');
                }
            });
        }
    }
    
    // ===========================================
    // 2. COLLAPSE/ACCORDION FUNCTIONALITY
    // ===========================================
    function initCollapseMenus() {
        var triggers = document.querySelectorAll('[data-toggle="collapse"]');
        
        if (!triggers.length) {
            console.warn('No collapse triggers found');
            return;
        }
        
        triggers.forEach(function(trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var targetId = this.getAttribute('data-target');
                
                // Normalize selector
                if (!targetId) return;
                if (targetId.charAt(0) !== '#') {
                    targetId = '#' + targetId;
                }
                
                var target = document.querySelector(targetId);
                if (!target) {
                    console.warn('Collapse target not found:', targetId);
                    return;
                }
                
                // Get parent for accordion behavior
                var parentId = target.getAttribute('data-parent');
                var parentEl = parentId ? document.querySelector(parentId) : null;
                
                // Close all other expanded items in same parent (remove collapse-closed from others)
                if (parentEl) {
                    var allCollapses = parentEl.querySelectorAll('.collapse');
                    allCollapses.forEach(function(collapseItem) {
                        if (collapseItem !== target) {
                            collapseItem.classList.add('collapse-closed');
                            
                            // Update the trigger for this collapsed item
                            var itemId = collapseItem.getAttribute('id');
                            if (itemId) {
                                var relatedTrigger = document.querySelector('[data-target="#' + itemId + '"], [data-target="' + itemId + '"]');
                                if (relatedTrigger) {
                                    relatedTrigger.setAttribute('aria-expanded', 'false');
                                    relatedTrigger.classList.add('collapsed');
                                }
                            }
                        }
                    });
                }
                
                // Toggle current target collapse-closed state
                var isClosed = target.classList.contains('collapse-closed');
                if (isClosed) {
                    target.classList.remove('collapse-closed');
                    this.setAttribute('aria-expanded', 'true');
                    this.classList.remove('collapsed');
                } else {
                    target.classList.add('collapse-closed');
                    this.setAttribute('aria-expanded', 'false');
                    this.classList.add('collapsed');
                }
            });
        });
    }
    
    // ===========================================
    // 3. NOTIFICATION DROPDOWN TOGGLE
    // ===========================================
    function initNotificationDropdown() {
        var notificationBtn = document.querySelector('.notification-trigger');
        var notificationWrapper = document.querySelector('.notification-dropdown-wrapper');
        var notificationMenu = document.querySelector('.notification-dropdown-menu');
        
        if (!notificationBtn || !notificationWrapper) return;
        
        notificationBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var isOpen = notificationWrapper.classList.contains('show');
            // Close profile dropdown
            document.querySelector('.profile-dropdown-wrapper')?.classList.remove('show');
            // Toggle notification dropdown
            if (isOpen) {
                notificationWrapper.classList.remove('show');
                if (notificationMenu) notificationMenu.style.display = 'none';
            } else {
                notificationWrapper.classList.add('show');
                if (notificationMenu) notificationMenu.style.display = 'block';
            }
        });
    }
    
    // ===========================================
    // 4. PROFILE DROPDOWN TOGGLE
    // ===========================================
    function initProfileDropdown() {
        var profileBtn = document.querySelector('.profile-dropdown-trigger');
        var profileWrapper = document.querySelector('.profile-dropdown-wrapper');
        var profileMenu = document.querySelector('.profile-dropdown-menu');
        
        if (!profileBtn || !profileWrapper) return;
        
        profileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var isOpen = profileWrapper.classList.contains('show');
            // Close notification dropdown
            document.querySelector('.notification-dropdown-wrapper')?.classList.remove('show');
            // Toggle profile dropdown
            if (isOpen) {
                profileWrapper.classList.remove('show');
                if (profileMenu) profileMenu.style.display = 'none';
            } else {
                profileWrapper.classList.add('show');
                if (profileMenu) profileMenu.style.display = 'block';
            }
        });
    }
    
    // ===========================================
    // 5. CLOSE DROPDOWNS ON OUTSIDE CLICK
    // ===========================================
    function initDropdownAutoClose() {
        document.addEventListener('click', function(e) {
            var notificationWrapper = document.querySelector('.notification-dropdown-wrapper');
            var profileWrapper = document.querySelector('.profile-dropdown-wrapper');
            
            // Close notification dropdown
            if (notificationWrapper && !e.target.closest('.notification-dropdown-wrapper')) {
                notificationWrapper.classList.remove('show');
                var notifMenu = document.querySelector('.notification-dropdown-menu');
                if (notifMenu) notifMenu.style.display = 'none';
            }
            
            // Close profile dropdown
            if (profileWrapper && !e.target.closest('.profile-dropdown-wrapper')) {
                profileWrapper.classList.remove('show');
                var profMenu = document.querySelector('.profile-dropdown-menu');
                if (profMenu) profMenu.style.display = 'none';
            }
        });
    }
    
    // ===========================================
    // 6. THEME TOGGLE (if exists) - Applies to entire page
    // ===========================================
    function initThemeToggle() {
        var themeToggle = document.getElementById('themeToggle');
        if (!themeToggle) {
            console.warn('Theme toggle button not found');
            return;
        }
        
        // Check current theme from localStorage
        var currentTheme = localStorage.getItem('admin-theme') || 'light';
        updateThemeButton(currentTheme);
        applyTheme(currentTheme);
        
        themeToggle.addEventListener('click', function() {
            var theme = localStorage.getItem('admin-theme') || 'light';
            var newTheme = theme === 'light' ? 'dark' : 'light';
            
            localStorage.setItem('admin-theme', newTheme);
            applyTheme(newTheme);
            updateThemeButton(newTheme);
        });
        
        function applyTheme(theme) {
            // Apply to html element for CSS variables - this affects entire page
            document.documentElement.setAttribute('data-theme', theme);
            
            // Apply to body for backwards compatibility
            if (theme === 'dark') {
                document.documentElement.classList.add('dark-mode');
                document.body.classList.add('dark-mode');
            } else {
                document.documentElement.classList.remove('dark-mode');
                document.body.classList.remove('dark-mode');
            }
        }
        
        function updateThemeButton(theme) {
            if (!themeToggle) return;
            
            var icon = themeToggle.querySelector('i');
            var text = themeToggle.querySelector('span');
            
            // Update button classes
            if (theme === 'dark') {
                themeToggle.classList.remove('btn-secondary');
                themeToggle.classList.add('btn-warning');
            } else {
                themeToggle.classList.remove('btn-warning');
                themeToggle.classList.add('btn-secondary');
            }
            
            // Update icon if it exists
            if (icon) {
                icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }
            
            // Update text if it exists
            if (text) {
                text.textContent = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
            }
        }
    }
    
    // ===========================================
    // INITIALIZE ALL WHEN DOM IS READY
    // ===========================================
    function init() {
        initMobileSidebarToggle();
        initCollapseMenus();
        initNotificationDropdown();
        initProfileDropdown();
        initDropdownAutoClose();
        initThemeToggle();
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
