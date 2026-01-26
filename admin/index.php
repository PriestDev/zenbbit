<?php 
include('security.php');
include('includes/header.php'); 
include('includes/navbar.php');
?>

<main id="content">
    <!-- Status Messages -->
    <div id="statusContainer"></div>

    <!-- Page Heading -->
    <h1 class="page-heading">Dashboard</h1>

    <?php 
        if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['status']) . '</div>';
            unset($_SESSION['status']);
        }
        if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
            unset($_SESSION['success']);
        }
    ?>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <!-- Total Balance Card -->
        <div class="stat-card primary">
            <div>
                <div class="stat-label">Platform Balance</div>
                <div class="stat-value">
                    <?php 
                    // Get total deposits
                    $stmt = mysqli_prepare($conn, "SELECT COALESCE(SUM(amt), 0) AS figure FROM transaction WHERE serial = 1 AND status = 'deposit'");
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $val = mysqli_fetch_assoc($result);
                    $total_deposits = $val['figure'];
                    
                    // Get total withdrawals
                    $stmt = mysqli_prepare($conn, "SELECT COALESCE(SUM(amt), 0) AS total FROM transaction WHERE serial = 1 AND status = 'withdraw'");
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);
                    $total_withdrawals = $row['total'];
                    
                    $balance = $total_deposits - $total_withdrawals;
                    echo number_format($balance, 2);
                    ?>
                </div>
            </div>
            <i class="fas fa-dollar-sign stat-icon"></i>
        </div>

        <!-- Total Users Card -->
        <a href="users.php" class="stat-card success" style="text-decoration: none; color: inherit;">
            <div>
                <div class="stat-label">Total Users</div>
                <div class="stat-value">
                    <?php 
                    $stmt = mysqli_prepare($conn, "SELECT COUNT(id) AS count FROM user");
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['count'];
                    ?>
                </div>
            </div>
            <i class="fas fa-users stat-icon"></i>
        </a>

        <!-- Registered Admins Card -->
        <a href="register.php" class="stat-card info" style="text-decoration: none; color: inherit;">
            <div>
                <div class="stat-label">Admin Accounts</div>
                <div class="stat-value">
                    <?php 
                    $stmt = mysqli_prepare($conn, "SELECT COUNT(id) AS count FROM admin");
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['count'];
                    ?>
                </div>
            </div>
            <i class="fas fa-shield-alt stat-icon"></i>
        </a>

        <!-- Pending Deposits Card -->
        <a href="deposit.php" class="stat-card warning" style="text-decoration: none; color: inherit;">
            <div>
                <div class="stat-label">Pending Deposits</div>
                <div class="stat-value">
                    <?php
                    $stmt = mysqli_prepare($conn, "SELECT COUNT(id) AS count FROM transaction WHERE status = 'deposit' AND serial = 0");
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['count'];
                    ?>
                </div>
            </div>
            <i class="fas fa-hourglass stat-icon"></i>
        </a>

        <!-- Pending Withdrawals Card -->
        <a href="withdraw.php" class="stat-card danger" style="text-decoration: none; color: inherit;">
            <div>
                <div class="stat-label">Pending Withdrawals</div>
                <div class="stat-value">
                    <?php
                    $stmt = mysqli_prepare($conn, "SELECT COUNT(id) AS count FROM transaction WHERE status = 'withdraw' AND serial = 0");
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['count'];
                    ?>
                </div>
            </div>
            <i class="fas fa-exclamation-circle stat-icon"></i>
        </a>
    </div>

    <!-- Recent Transactions Section -->
    <div class="card mt-4">
        <div class="card-header d-flex justify-between align-center">
            <h3 class="m-0">Recent Transactions</h3>
        </div>
        <div class="card-body">
            <div class="search-box">
                <input type="text" id="searchInput" class="search-input" placeholder="Search by TRX ID or User ID..." onkeyup="filterTable()">
            </div>
            
            <div class="table-responsive">
                <table class="table" id="transactionTable">
                    <thead>
                        <tr>
                            <th>TRX ID</th>
                            <th>User ID</th>
                            <th>Gateway</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $stmt = mysqli_prepare($conn, "SELECT * FROM transaction ORDER BY id DESC LIMIT 20");
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $status_badge = '';
                                if ($row['serial'] == 0) {
                                    $status_badge = '<span class="badge badge-pending">Pending</span>';
                                } elseif ($row['serial'] == 1) {
                                    $status_badge = '<span class="badge badge-approved">Approved</span>';
                                } elseif ($row['serial'] == 2) {
                                    $status_badge = '<span class="badge badge-declined">Declined</span>';
                                }
                        ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row['trx_id']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo number_format($row['amt'], 2); ?></td>
                            <td><?php echo $status_badge; ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($row['create_date'])); ?></td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="7" class="text-center text-muted">No transactions found</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
// Apply dark mode from localStorage
const theme = localStorage.getItem('admin-theme') || 'light';
if (theme === 'dark') {
    document.body.classList.add('dark-mode');
}

// Theme toggle functionality
const themeToggle = document.getElementById('themeToggle');
if (themeToggle) {
    themeToggle.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        const isDark = document.body.classList.contains('dark-mode');
        localStorage.setItem('admin-theme', isDark ? 'dark' : 'light');
    });
}

// Sidebar toggle for mobile
const toggleBtn = document.querySelector('.toggle-sidebar-btn');
const sidebar = document.getElementById('sidebar');
if (toggleBtn && sidebar) {
    toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        sidebar.classList.toggle('show');
    });
    
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#sidebar') && !e.target.closest('.toggle-sidebar-btn')) {
            sidebar.classList.remove('show');
        }
    });
}

// Collapse menu items
const collapseLinks = document.querySelectorAll('[data-toggle="collapse"]');
collapseLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const target = this.getAttribute('data-target');
        const menu = document.querySelector(target);
        if (menu) {
            menu.classList.toggle('show');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
        }
    });
});

// Table search/filter function
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toUpperCase();
    const table = document.getElementById('transactionTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;
        
        for (let j = 0; j < cells.length; j++) {
            if (cells[j].textContent.toUpperCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        
        rows[i].style.display = found ? '' : 'none';
    }
}
</script>

<?php 
include('includes/script.php');
include('includes/footer.php');
?>
