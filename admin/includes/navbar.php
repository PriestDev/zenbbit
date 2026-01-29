<!-- ========================================
     NAVBAR & SIDEBAR CONTAINER
     ======================================== -->
<!-- Load external CSS for navbar/sidebar -->
<link rel="stylesheet" href="css/navbar-custom.css">

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
    <ul class="sidebar-nav-container" style="list-style: none; padding: 0; margin: 0;">
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
                <!-- <a href="plan.php" class="collapse-item"><i class="fas fa-chart-line"></i> Trading Plans</a> -->
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
                <!-- <a href="other.php" class="collapse-item"><i class="fas fa-exchange-alt"></i> Other</a> -->
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
<!-- Load external JavaScript for navbar/sidebar functionality -->
<script src="js/navbar-custom.js"></script>
