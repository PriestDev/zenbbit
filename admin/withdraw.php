<?php 
include('security.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<main id="content">
    <!-- Page Heading -->
    <h1 class="page-heading">Withdrawal Transactions</h1>

    <!-- Status Messages -->
    <?php 
        if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['status']) . '</div>';
            unset($_SESSION['status']);
        }
    ?>

    <!-- Withdrawals Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-between align-center">
            <h3 class="m-0">All Withdrawal Requests</h3>
        </div>
        <div class="card-body">
            <div class="search-box">
                <input type="text" class="search-input" id="searchInput" placeholder="Search by TRX ID or User ID..." onkeyup="filterTable()">
            </div>

            <div class="table-responsive">
                <table class="table" id="withdrawalsTable">
                    <thead>
                        <tr>
                            <th>TRX ID</th>
                            <th>User ID</th>
                            <th>Method</th>
                            <th>Source</th>
                            <th>Amount</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Accept both 'withdraw' and 'withdrawal' (legacy records)
                        $stmt = mysqli_prepare($conn, "SELECT * FROM transaction WHERE type LIKE 'with%' ORDER BY id DESC");
                        if ($stmt) {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Determine status badge
                                    $status_badge = '';
                                    switch($row['serial']) {
                                        case 0:
                                            $status_badge = '<span class="badge badge-pending">PENDING</span>';
                                            break;
                                        case 1:
                                            $status_badge = '<span class="badge badge-approved">APPROVED</span>';
                                            break;
                                        case 2:
                                            $status_badge = '<span class="badge badge-declined">DECLINED</span>';
                                            break;
                                        default:
                                            $status_badge = '<span class="badge badge-pending">UNKNOWN</span>';
                                    }

                                    // Determine gateway source
                                    $gateway_name = '';
                                    switch($row['gate_way']) {
                                        case 1:
                                            $gateway_name = 'Balance';
                                            break;
                                        case 2:
                                            $gateway_name = 'Profit';
                                            break;
                                        case 3:
                                            $gateway_name = 'Referral';
                                            break;
                                        default:
                                            $gateway_name = 'Assets';
                                    }

                                    // Build details string
                                    $details = '';
                                    if ($row['name'] == 'BANK') {
                                        $details = 'Bank: ' . htmlspecialchars($row['bank_name']) . 
                                                 ' | Account: ' . htmlspecialchars($row['acct_num']) . 
                                                 ' | Name: ' . htmlspecialchars($row['acct_name']);
                                    } else {
                                        $details = htmlspecialchars($row['details']);
                                    }

                                    // Use trx_id when present, otherwise fall back to internal id
                                    $trx_id_raw = !empty($row['trx_id']) ? $row['trx_id'] : 'id:' . $row['id'];
                                    $trx_id = htmlspecialchars($trx_id_raw);
                                    $user_id = htmlspecialchars($row['user_id']);
                                    $method = htmlspecialchars($row['name']);
                                    $asset = strtoupper(htmlspecialchars($row['asset'] ?? 'USD'));
                                    $amount = number_format($row['amt'], 8);
                                    $created = date('Y-m-d H:i', strtotime($row['create_date']));
                        ?>
                        <tr>
                            <td><strong><?php echo $trx_id; ?></strong></td>
                            <td><?php echo $user_id; ?></td>
                            <td><?php echo $method; ?></td>
                            <td><?php echo $gateway_name; ?></td>
                            <td><?php echo $amount; ?> <?php echo $asset; ?></td>
                            <td><?php echo $details; ?></td>
                            <td><?php echo $status_badge; ?></td>
                            <td><?php echo $created; ?></td>
                            <td>
                                <?php if ($row['serial'] == 0) { ?>
                                    <form method="POST" action="code.php" style="display: inline;">
                                        <input type="hidden" name="approve_status" value="<?php echo htmlspecialchars($row['trx_id'] ?: 'id:' . $row['id']); ?>">
                                        <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                                        <input type="hidden" name="amt" value="<?php echo htmlspecialchars($row['amt']); ?>">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                                        <input type="hidden" name="gate_way" value="<?php echo (int)$row['gate_way']; ?>">
                                        <button type="submit" name="approve_wth" class="btn btn-sm btn-success" title="Approve withdrawal">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="code.php" style="display: inline;">
                                        <input type="hidden" name="approve_status" value="<?php echo htmlspecialchars($row['trx_id'] ?: 'id:' . $row['id']); ?>">
                                        <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                                        <input type="hidden" name="amt" value="<?php echo htmlspecialchars($row['amt']); ?>">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                                        <input type="hidden" name="gate_way" value="<?php echo (int)$row['gate_way']; ?>">
                                        <button type="submit" name="decline_wth" class="btn btn-sm btn-danger" title="Decline withdrawal">
                                            <i class="fas fa-times"></i> Decline
                                        </button>
                                    </form>
                                <?php } else { ?>
                                    <form method="POST" action="code.php" style="display: inline;">
                                        <input type="hidden" name="delete_wth" value="<?php echo htmlspecialchars($row['trx_id']); ?>">
                                        <button type="submit" name="delete_withdraw" class="btn btn-sm btn-danger" title="Delete record" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                                }
                            } else {
                                echo '<tr><td colspan="9" class="text-center text-muted">No withdrawal transactions found</td></tr>';
                            }
                            mysqli_stmt_close($stmt);
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
// Filter table functionality
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toUpperCase();
    const table = document.getElementById('withdrawalsTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;
        
        // Search in TRX ID and User ID columns
        if (cells[0].textContent.toUpperCase().indexOf(filter) > -1 || 
            cells[1].textContent.toUpperCase().indexOf(filter) > -1) {
            found = true;
        }
        
        rows[i].style.display = found ? '' : 'none';
    }
}
</script>

<?php 
include('includes/script.php');
include('includes/footer.php');
?>