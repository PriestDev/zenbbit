<?php 
include('security.php');
include('includes/header.php');
include('includes/navbar.php');

// Get all site activities
$activities = array();

// Get recent transactions
$tx_query = "SELECT 'transaction' as type, id, CONCAT(name, ' - ', status) as description, user_id as user, amt as amount, create_date as activity_date, status as tx_status FROM transaction ORDER BY create_date DESC LIMIT 50";
$tx_result = mysqli_query($conn, $tx_query);
if ($tx_result) {
    while ($row = mysqli_fetch_assoc($tx_result)) {
        $activities[] = $row;
    }
}

// Get recent user signups (if user table exists - with acct_id field)
$user_query = "SELECT 'signup' as type, id, CONCAT('User signup: ', acct_id) as description, acct_id as user, '' as amount, reg_date as activity_date, 'active' as tx_status FROM user ORDER BY reg_date DESC LIMIT 20";
$user_result = @mysqli_query($conn, $user_query);
if ($user_result) {
    while ($row = mysqli_fetch_assoc($user_result)) {
        $activities[] = $row;
    }
}

// Sort activities by date (newest first)
usort($activities, function($a, $b) {
    return strtotime($b['activity_date']) - strtotime($a['activity_date']);
});

// Limit to latest 100 activities
$activities = array_slice($activities, 0, 100);
?>

<main id="content">
    <div class="page-header">
        <h1 class="page-heading">
            <i class="fas fa-fw fa-bell"></i> Site Activities
        </h1>
        <p class="page-subtitle">Real-time platform activity tracking and monitoring</p>
    </div>

    <?php 
        if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> ' . htmlspecialchars($_SESSION['status']) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            unset($_SESSION['status']);
        }
    ?>

    <!-- Activity Summary Stats -->
    <div class="stats-grid">
        <!-- Total Activities -->
        <div class="stat-card primary">
            <div>
                <div class="stat-label">Total Activities</div>
                <div class="stat-value"><?php echo count($activities); ?></div>
            </div>
            <i class="fas fa-fw fa-chart-line stat-icon"></i>
        </div>

        <!-- Recent Transactions -->
        <div class="stat-card info">
            <div>
                <div class="stat-label">Recent Transactions</div>
                <div class="stat-value">
                    <?php 
                        $tx_count = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM transaction WHERE DATE(create_date) = CURDATE()");
                        $tx_data = mysqli_fetch_assoc($tx_count);
                        echo $tx_data['cnt'];
                    ?>
                </div>
            </div>
            <i class="fas fa-fw fa-exchange-alt stat-icon"></i>
        </div>

        <!-- New Signups Today -->
        <div class="stat-card success">
            <div>
                <div class="stat-label">New Signups Today</div>
                <div class="stat-value">
                    <?php 
                        $user_count = @mysqli_query($conn, "SELECT COUNT(*) as cnt FROM user WHERE DATE(reg_date) = CURDATE()");
                        $user_data = $user_count ? mysqli_fetch_assoc($user_count) : array('cnt' => 0);
                        echo isset($user_data['cnt']) ? $user_data['cnt'] : '0';
                    ?>
                </div>
            </div>
            <i class="fas fa-fw fa-user-plus stat-icon"></i>
        </div>

        <!-- Pending Transactions -->
        <div class="stat-card warning">
            <div>
                <div class="stat-label">Pending Transactions</div>
                <div class="stat-value">
                    <?php 
                        $pending_count = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM transaction WHERE serial = 0");
                        $pending_data = mysqli_fetch_assoc($pending_count);
                        echo $pending_data['cnt'];
                    ?>
                </div>
            </div>
            <i class="fas fa-fw fa-hourglass-half stat-icon"></i>
        </div>
    </div>

    <!-- Activities Table -->
    <div class="card shadow-lg">
        <div class="card-header bg-gradient">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="mb-0">
                        <i class="fas fa-fw fa-list"></i> All Site Activities
                    </h3>
                    <small class="text-muted">Latest 100 activities (Latest first)</small>
                </div>
                <span class="badge badge-primary" style="font-size: 0.9rem;">
                    <?php echo count($activities); ?> Activities
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <?php if (count($activities) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 12%;">
                                    <i class="fas fa-fw fa-tag"></i> Type
                                </th>
                                <th style="width: 28%;">
                                    <i class="fas fa-fw fa-info-circle"></i> Description
                                </th>
                                <th style="width: 15%;">
                                    <i class="fas fa-fw fa-user"></i> User
                                </th>
                                <th style="width: 12%; text-align: right;">
                                    <i class="fas fa-fw fa-dollar-sign"></i> Amount
                                </th>
                                <th style="width: 12%;">
                                    <i class="fas fa-fw fa-check-circle"></i> Status
                                </th>
                                <th style="width: 21%;">
                                    <i class="fas fa-fw fa-calendar"></i> Date & Time
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activities as $activity): ?>
                                <tr class="activity-row">
                                    <td>
                                        <?php 
                                            $type = $activity['type'];
                                            $badge_class = 'badge-info';
                                            $icon = 'fa-info-circle';
                                            
                                            if ($type === 'transaction') {
                                                $badge_class = 'badge-primary';
                                                $icon = 'fa-exchange-alt';
                                            } elseif ($type === 'signup') {
                                                $badge_class = 'badge-success';
                                                $icon = 'fa-user-plus';
                                            } elseif ($type === 'admin_action') {
                                                $badge_class = 'badge-warning';
                                                $icon = 'fa-cog';
                                            }
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>">
                                            <i class="fas fa-fw <?php echo $icon; ?>"></i>
                                            <?php echo ucfirst(str_replace('_', ' ', $type)); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($activity['description']); ?></strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <i class="fas fa-fw fa-circle-user"></i>
                                            </div>
                                            <strong><?php echo htmlspecialchars($activity['user']); ?></strong>
                                        </div>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php 
                                            if (!empty($activity['amount'])) {
                                                echo '<strong class="text-success">$' . number_format($activity['amount'], 2) . '</strong>';
                                            } else {
                                                echo '<span class="text-muted">-</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $status = $activity['tx_status'];
                                            $status_badge = 'badge-secondary';
                                            $status_icon = 'fa-circle';
                                            
                                            if ($status === 'deposit' || $status === 'completed' || $status === 'approved' || $status === 'active') {
                                                $status_badge = 'badge-success';
                                                $status_icon = 'fa-check-circle';
                                            } elseif ($status === 'withdraw' || $status === 'pending') {
                                                $status_badge = 'badge-warning';
                                                $status_icon = 'fa-hourglass-half';
                                            } elseif ($status === 'failed' || $status === 'declined') {
                                                $status_badge = 'badge-danger';
                                                $status_icon = 'fa-times-circle';
                                            }
                                        ?>
                                        <span class="badge <?php echo $status_badge; ?>">
                                            <i class="fas fa-fw <?php echo $status_icon; ?>"></i>
                                            <?php echo ucfirst($status); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-fw fa-clock"></i>
                                            <?php echo date('M d, Y H:i', strtotime($activity['activity_date'])); ?>
                                        </small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h4>No Activities Yet</h4>
                    <p class="text-muted">There are no recorded activities. All activities will appear here.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>


<?php
include('includes/footer.php');
?>