<?php 
include('security.php');
require('../details.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<main id="content">
    <!-- Page Heading -->
    <h1 class="page-heading">Deposit Transactions</h1>

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

    <!-- Deposits Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-between align-center">
            <h3 class="m-0">All Deposit Requests</h3>
        </div>
        <div class="card-body">
            <div class="search-box">
                <input type="text" class="search-input" id="searchInput" placeholder="Search by TRX ID or User ID..." onkeyup="filterTable()">
            </div>

            <div class="table-responsive">
                <table class="table" id="depositsTable">
                    <thead>
                        <tr>
                            <th>TRX ID</th>
                            <th>User ID</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Proof</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $stmt = mysqli_prepare($conn, "SELECT * FROM transaction WHERE status = 'deposit' ORDER BY id DESC");
                        if ($stmt) {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
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

                                    $trx_id = htmlspecialchars($row['trx_id']);
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
                            <td><?php echo $amount; ?> <?php echo $asset; ?></td>
                            <td>
                                <?php 
                                if (!empty($row['proof'])) {
                                    $proof_url = htmlspecialchars($row['proof']);
                                    echo '<a href="../uploads/proofs/' . $proof_url . '" target="_blank" class="btn btn-sm btn-secondary" title="View proof">
                                        <i class="fas fa-image"></i> View
                                    </a>';
                                } else {
                                    echo '<span class="text-muted">No proof</span>';
                                }
                                ?>
                            </td>
                            <td><?php echo $status_badge; ?></td>
                            <td><?php echo $created; ?></td>
                            <td>
                                <?php if ($row['serial'] == 0) { ?>
                                    <form method="POST" action="code.php" style="display: inline;">
                                        <input type="hidden" name="approve_serial" value="<?php echo htmlspecialchars($row['trx_id']); ?>">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                                        <button type="submit" name="approve_deposit" class="btn btn-sm btn-success" title="Approve deposit">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="code.php" style="display: inline;">
                                        <input type="hidden" name="serial" value="<?php echo htmlspecialchars($row['trx_id']); ?>">
                                        <button type="submit" name="decline_deposit" class="btn btn-sm btn-danger" title="Decline deposit">
                                            <i class="fas fa-times"></i> Decline
                                        </button>
                                    </form>
                                <?php } else { ?>
                                    <form method="POST" action="code.php" style="display: inline;">
                                        <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                                        <button type="submit" name="delete_deposit" class="btn btn-sm btn-danger" title="Delete record" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center text-muted">No deposit transactions found</td></tr>';
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
    const table = document.getElementById('depositsTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;
        
        // Search in TRX ID and User ID columns (first 2 columns)
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