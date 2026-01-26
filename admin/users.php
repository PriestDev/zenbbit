<?php 
include('security.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<main id="content">
    <!-- Page Heading -->
    <h1 class="page-heading">Manage Users</h1>

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

    <!-- Users Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-between align-center">
            <h3 class="m-0">All Users</h3>
        </div>
        <div class="card-body">
            <div class="search-box">
                <input type="text" class="search-input" id="searchInput" placeholder="Search by ID, name, or email..." onkeyup="filterTable()">
            </div>

            <div class="table-responsive">
                <table class="table" id="usersTable">
                    <thead>
                        <tr>
                            <th>Account ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Registration Date</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $stmt = mysqli_prepare($conn, "SELECT id, acct_id, first_name, last_name, email, status, reg_date, `update` FROM user ORDER BY id DESC");
                        if ($stmt) {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Determine status badge
                                    $status_badge = '';
                                    switch($row['status']) {
                                        case 1:
                                            $status_badge = '<span class="badge badge-approved">ACTIVE</span>';
                                            break;
                                        case 2:
                                            $status_badge = '<span class="badge badge-pending">PENDING</span>';
                                            break;
                                        case 0:
                                            $status_badge = '<span class="badge badge-declined">BLOCKED</span>';
                                            break;
                                        case 3:
                                            $status_badge = '<span class="badge" style="background: #6b7280; color: white; padding: 0.375rem 0.75rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">BANNED</span>';
                                            break;
                                        default:
                                            $status_badge = '<span class="badge" style="background: #9ca3af; color: white; padding: 0.375rem 0.75rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">UNKNOWN</span>';
                                    }

                                    $full_name = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                                    $email = htmlspecialchars($row['email']);
                                    $acct_id = htmlspecialchars($row['acct_id']);
                                    $reg_date = date("Y-m-d H:i", strtotime($row['reg_date']));
                                    $update_date = date("Y-m-d H:i", strtotime($row['update']));
                                    $user_id = (int)$row['id'];
                        ?>
                        <tr>
                            <td><strong><?php echo $acct_id; ?></strong></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $status_badge; ?></td>
                            <td><?php echo $reg_date; ?></td>
                            <td><?php echo $update_date; ?></td>
                            <td style="display: flex; gap: 0.5rem;">
                                <a href="user_edit.php?id=<?php echo $user_id; ?>" class="btn btn-sm btn-primary" title="Edit user">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                        <?php
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center text-muted">No users found</td></tr>';
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
    const table = document.getElementById('usersTable');
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