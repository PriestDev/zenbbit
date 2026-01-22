 <?php

 include('security.php');

if (isset($_POST['del_trade'])) {
	$id = $_POST['id'];

	$sql = "DELETE FROM plan WHERE id = $id";
	$run = mysqli_query($conn, $sql);

	if ($run) {
		$_SESSION['success'] = "Deleted successfully";
		header('location: plan.php');
	} else {
		$_SESSION['status'] = "An error occured";
		header('location: plan.php');
	}
}

 if (isset($_POST['edit_plan'])) {
    
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="container-fluid">

     <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Plan</h6>
            
        </div>
        <div class="card-body">
            <?php 

                if (isset($_POST['edit_plan'])) {
                    $id = $_POST['id'];

                    $sql = "SELECT * FROM plan WHERE id='$id' ";
                    $run = mysqli_query($conn, $sql);

                    foreach ($run as $row) {

            ?>
    
        <form action="code.php" method="POST">
        <div class="modal-body">
            <input type="hidden" name="id" value="<?= $row['id']; ?>">
          <div class="form-group">
            <label> Plan Name </label>
            <input type="text" name="pair" class="form-control" required value="<?= $row['name']; ?>">
          </div>
          <div class="form-group">
            <label> Min_Amount </label>
            <input type="number" min='1' class="form-control" required name="min" value="<?= $row['min'] ?>">
          </div>
          <div class="form-group">
            <label> Max_Amount <small>(Zero for unlimited)</small> </label>
            <input type="number" class="form-control" required name="max" value="<?= $row['max'] ?>">
          </div>
          <div class="form-group">
            <label> Profit (%) </label>
            <input type="number" class="form-control" required name="prof" value="<?= $row['per'] ?>">
          </div>
          <div class="form-group">
            <label> Plan Duration (minutes) </label>
            <input type="number" name="duration" required class="form-control" value="<?= $row['duration']; ?>" required>
          </div>
          <div class="form-group">
            <label> status </label>
            <select class="form-control" name="status" default="<?= $row['status']; ?>">
              <option value="<?= $row['status'] ?>">--Default --</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <a href="trade.php" class="btn btn-secondary" >Close</a>
          <button type="submit" name="plan_edit" class="btn btn-primary">Save</button>
        </div>
     </form>
       <?php
                }
            }
            
        ?>

        </div>
    </div>
</div>


<?php 
include('includes/script.php');
include('includes/footer.php');
} 
?>
