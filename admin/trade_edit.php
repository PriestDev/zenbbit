 <?php

 include('security.php');

 if (isset($_POST['del_trade'])) {
     
	$id = $_POST['id'];

	$sql = "DELETE FROM trade WHERE id = $id";
	$run = mysqli_query($conn, $sql);

	if ($run) {
		$_SESSION['success'] = "Deleted successfully";
		header('location: index.php');
	} else {
		$_SESSION['status'] = "Error occured";
		header('location: index.php');
	}

 } elseif (isset($_POST['edit_plan'])) {
     
    
    include('includes/header.php');
    include('includes/navbar.php');
?>
    
    <div class="container-fluid">
    
         <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit User Plan</h6>
                
            </div>
            <div class="card-body">
                <?php 
                    // Check if the form is submitted`    
                    if (isset($_POST['edit_plan'])) {
                        $id = $_POST['edit'];
    
                        $sql = "SELECT * FROM trade WHERE id='$id' ";
                        $run = mysqli_query($conn, $sql);
    
                        function bal($conn) {
                          $id = $_POST['edit'];
                          $user_bal = '';
                          $sql = "SELECT * FROM trade WHERE id = '$id' ";
                          $run = mysqli_query($conn, $sql);
                          $result = $run->fetch_array(MYSQLI_ASSOC);
                          if ($run) {
                            $user = $result['user'];
                            $sql = "SELECT * FROM user WHERE acct_id = '$user'";
                            $run = mysqli_query($conn, $sql);
                            $row = $run->fetch_array(MYSQLI_ASSOC);
    
                            if ($row['balance'] != null) {
                              $user_bal = $row['balance'];
                            }
                          }
    
                          return $user_bal;
                        }
    
                    }
    
                    foreach ($run as $row) {
    
                ?>
        
            <form action="code.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                  <div class="form-group">
                    <label> User </label>
                    <input type="text" name="user" class="form-control" value="<?php echo $row['user']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label> User Balance </label>
                    <input type="text" class="form-control" name="u_bal" value=" <?= bal($conn); ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label> Plan </label>
                    <select class="form-control" name="pair" required>

                        <?php
                          // Fetch all active plans from the database
                          $sql = "SELECT name FROM plan WHERE status = 1";
                          $result = mysqli_query($conn, $sql);

                          // Show default selected option
                          echo '<option value="' . htmlspecialchars($row['pair']) . '">--Default (' . htmlspecialchars($row['pair']) . ') --</option>';

                          // If there are active plans, list them
                          if ($result && mysqli_num_rows($result) > 0) {
                            while ($plan = mysqli_fetch_assoc($result)) {
                              echo '<option value="' . htmlspecialchars($plan['name']) . '">' . htmlspecialchars($plan['name']) . '</option>';
                            }
                          } else {
                            echo '<option value="" class="text-fade">-- No active plan --</option>';
                          }
                        ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label> Trade Amount </label>
                    <?php
                        if($row['amount'] == null) {
                            ?>
                                <input type="number" name="amt" class="form-control" placeholder="Enter Trade Amount" required>
                            <?php
                        } else {
                            ?>
                                <input type="number" class="form-control" readonly value="<?php echo $row['amount']; ?>">
                            <?php
                        }
                    ?>
                  </div>
                  <div class="form-group">
                    <label> status </label>
                    <select class="form-control" name="status" default="<?php echo $row['status']; ?>">
                      <option value="<?= $row['status'] ?>">--Default --</option>
                      <option value="0">Processing</option>
                      <option value="1">Trading</option>
                      <option value="2">Ended</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label> Trade Profit ($)</label>
                    <input type="number" name="prof" class="form-control" value="<?php echo $row['profit']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label> Trade Duration (minutes) </label>
                    <input type="number" name="trade_hrs" placeholder="" class="form-control" value="<?php echo $row['trade_duration']; ?>" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <a href="<?= $_POST['file'] ?>" class="btn btn-secondary" >Close</a>
                  <input type="hidden" value="<?= $_POST['file'] ?>" name="file">
                  <button type="submit" name="trade_edit" class="btn btn-primary">Save</button>
                </div>
            </form>
           <?php
    
                }
                
            ?>
    
            </div>
        </div>
    </div>
    
    
<?php 
    include('includes/script.php');
    include('includes/footer.php');

 } else {
     header('location: ./');
 }
?>
