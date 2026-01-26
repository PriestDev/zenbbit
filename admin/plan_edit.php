<?php
include('security.php');

if (isset($_POST['del_trade'])) {
    $id = intval($_POST['id']);
    $stmt = mysqli_prepare($conn, "DELETE FROM plan WHERE id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $_SESSION['success'] = "Plan deleted successfully";
        header('location: plan.php');
    } else {
        $_SESSION['status'] = "An error occurred";
        header('location: plan.php');
    }
    exit;
}

if (isset($_POST['edit_plan'])) {
    include('includes/header.php');
    include('includes/navbar.php');
    
    $id = intval($_POST['id']);
    $stmt = mysqli_prepare($conn, "SELECT * FROM plan WHERE id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if (!$row) {
            header('location: plan.php');
            exit;
        }
?>

<main id="content">
    <h1 class="page-heading">Edit Investment Plan</h1>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header">
            <h3 class="m-0">Plan Configuration</h3>
        </div>
        <div class="card-body">
            <form action="code.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']); ?>">

                <div class="form-group">
                    <label>Plan Name *</label>
                    <input type="text" name="pair" class="form-control" required value="<?= htmlspecialchars($row['name']); ?>" placeholder="Enter plan name">
                </div>

                <div class="form-group">
                    <label>Minimum Amount ($) *</label>
                    <input type="number" min="1" step="0.01" class="form-control" required name="min" value="<?= htmlspecialchars($row['min']); ?>" placeholder="Minimum investment">
                </div>

                <div class="form-group">
                    <label>Maximum Amount ($) <small>(0 for unlimited)</small></label>
                    <input type="number" step="0.01" class="form-control" required name="max" value="<?= htmlspecialchars($row['max']); ?>" placeholder="Maximum investment">
                </div>

                <div class="form-group">
                    <label>Profit Percentage (%) *</label>
                    <input type="number" step="0.01" class="form-control" required name="prof" value="<?= htmlspecialchars($row['per']); ?>" placeholder="Profit percentage">
                </div>

                <div class="form-group">
                    <label>Duration (minutes) *</label>
                    <input type="number" name="duration" required class="form-control" value="<?= htmlspecialchars($row['duration']); ?>" placeholder="Plan duration in minutes">
                </div>

                <div class="form-group">
                    <label>Status *</label>
                    <select class="form-control" name="status">
                        <option value="1" <?= $row['status'] == 1 ? 'selected' : ''; ?>>Active</option>
                        <option value="0" <?= $row['status'] == 0 ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" name="plan_edit" class="btn btn-primary">Save Changes</button>
                    <a href="plan.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php 
include('includes/script.php');
include('includes/footer.php');
    }
}
?>
