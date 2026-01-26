<?php 
include('security.php');
require('../details.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<main id="content">
    <h1 class="page-heading">Bonus & Other Transactions</h1>

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

    <!-- Add Bonus Modal -->
    <div class="modal-overlay" id="bonusModal">
        <div class="modal-dialog" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Add Bonus</h3>
                    <button type="button" class="modal-close" onclick="document.getElementById('bonusModal').style.display='none'">×</button>
                </div>
                <form action="code.php" method="POST">
                    <div class="modal-body">
                        <p style="color: #d32f2f; font-size: 12px; margin-bottom: 15px;">All fields are required</p>

                        <div class="form-group">
                            <label>Select User *</label>
                            <?php
                                $stmt = mysqli_prepare($conn, "SELECT id, email, first_name, last_name FROM user ORDER BY id DESC");
                                if ($stmt) {
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                            ?>
                            <select class="form-control" name="user" required>
                                <option value="">-- Select user --</option>
                                <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . htmlspecialchars($row['email']) . '">' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . '</option>';
                                    }
                                    mysqli_stmt_close($stmt);
                                ?>
                            </select>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <label>Amount * ($)</label>
                            <input type="number" required name="amount" class="form-control" placeholder="Enter amount" step="0.01">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('bonusModal').style.display='none'">Cancel</button>
                        <button type="submit" name="bonus" class="btn btn-primary">Add Bonus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bonus Transactions Card -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="m-0">Transactions</h3>
            <button type="button" class="btn btn-primary" onclick="document.getElementById('bonusModal').style.display='flex'">
                + Add Bonus
            </button>
        </div>
        <div class="card-body">
            <div style="margin-bottom: 15px;">
                <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search by TRX ID..." style="max-width: 300px;">
            </div>

            <div class="table-responsive">
                <table class="table table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>TRX ID</th>
                            <th>User</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $stmt = mysqli_prepare($conn, "SELECT * FROM transaction WHERE status='other' ORDER BY id DESC");
                            if ($stmt) {
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $status_badge = '';
                                        if ($row['serial'] == 0) {
                                            $status_badge = '<span class="badge" style="background-color: #ff9800;">Pending</span>';
                                        } elseif ($row['serial'] == 1) {
                                            $status_badge = '<span class="badge" style="background-color: #4caf50;">Approved</span>';
                                        } elseif ($row['serial'] == 2) {
                                            $status_badge = '<span class="badge" style="background-color: #f44336;">Declined</span>';
                                        }
                        ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($row['trx_id']); ?></strong></td>
                            <td><?= htmlspecialchars($row['user_id']); ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td>$<?= number_format($row['amt'], 2); ?></td>
                            <td><?= $status_badge; ?></td>
                            <td><?= date('M d, Y H:i', strtotime($row['create_date'])); ?></td>
                            <td>
                                <form method="POST" action="code.php" style="display: inline;">
                                    <input type="hidden" value="<?= htmlspecialchars($row['amt']); ?>" name="amt">
                                    <input type="hidden" value="<?= htmlspecialchars($row['user_id']); ?>" name="user_id">
                                    <input type="hidden" value="<?= htmlspecialchars($row['email']); ?>" name="email">

                                    <?php if ($row['serial'] == 0) { ?>
                                        <input type="hidden" name="approve_serial" value="<?= htmlspecialchars($row['trx_id']); ?>">
                                        <button type="submit" name="approve_deposit" class="btn btn-sm btn-success">Approve</button>

                                        <input type="hidden" name="serial" value="<?= htmlspecialchars($row['trx_id']); ?>">
                                        <button type="submit" name="decline_deposit" class="btn btn-sm btn-danger">Decline</button>
                                    <?php } else { ?>
                                        <input type="hidden" name="delete_wth" value="<?= htmlspecialchars($row['id']); ?>">
                                        <button type="submit" name="delete_trx" class="btn btn-sm btn-danger">Delete</button>
                                    <?php } ?>
                                </form>
                            </td>
                        </tr>
                        <?php
                                    }
                                    mysqli_stmt_close($stmt);
                                } else {
                        ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px; color: #999;">
                                No transactions found
                            </td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
// Modal backdrop click handler
document.getElementById('bonusModal').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});

// Search function
function myFunction() {
    var input = document.getElementById("myInput");
    var filter = input.value.toUpperCase();
    var table = document.getElementById("myTable");
    var tr = table.getElementsByTagName("tr");
    
    for (var i = 1; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            var txtValue = td.textContent || td.innerText;
            tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }
    }
}
</script>

<?php 
include('includes/script.php');
include('includes/footer.php');
?>