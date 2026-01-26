<?php 
    include('security.php');
    include('includes/header.php');
    include('includes/navbar.php');
?>

<main id="content">
    <!-- Page Heading -->
    <h1 class="page-heading">Investment Plans</h1>

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

    <!-- Plans Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-between align-center">
            <h3 class="m-0">Investment Plans</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#planModal">
                <i class="fas fa-plus"></i> New Plan
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Plan Name</th>
                            <th>Min Amount</th>
                            <th>Max Amount</th>
                            <th>Profit %</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $stmt = mysqli_prepare($conn, "SELECT id, name, min, max, per, duration, status, reg_date, up_date FROM plan ORDER BY id DESC");
                        if ($stmt) {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $status_badge = ($row['status'] == 1)
                                        ? '<span class="badge badge-approved">ACTIVE</span>'
                                        : '<span class="badge badge-pending">INACTIVE</span>';

                                    $max_display = ($row['max'] == 0) ? 'Unlimited' : '$' . number_format($row['max'], 2);
                                    $plan_name = htmlspecialchars($row['name']);
                                    $min_amount = '$' . number_format($row['min'], 2);
                                    $profit = $row['per'] . '%';
                                    $duration = $row['duration'] . ' min';
                                    $id = (int)$row['id'];
                                    $reg_date = date('Y-m-d', strtotime($row['reg_date']));
                                    $up_date = date('Y-m-d', strtotime($row['up_date']));
                        ?>
                        <tr>
                            <td><strong><?php echo $plan_name; ?></strong></td>
                            <td><?php echo $min_amount; ?></td>
                            <td><?php echo $max_display; ?></td>
                            <td><?php echo $profit; ?></td>
                            <td><?php echo $duration; ?></td>
                            <td><?php echo $status_badge; ?></td>
                            <td><?php echo $reg_date; ?></td>
                            <td><?php echo $up_date; ?></td>
                            <td>
                                <form action="plan_edit.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <button type="submit" name="edit_plan" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </form>
                                <form action="plan_edit.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <button type="submit" name="del_trade" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php
                                }
                            } else {
                                echo '<tr><td colspan="9" class="text-center text-muted">No investment plans found</td></tr>';
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

<?php 
include('includes/script.php');
include('includes/footer.php');
?>