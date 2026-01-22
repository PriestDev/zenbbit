<?php 
    include('security.php');
    
    include('includes/header.php');
    include('includes/navbar.php');
?>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle"> Setup Plan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="server.php" method="POST">
        <div class="modal-body">
          <div class="form-group">
            <label> Plan Name </label>
            <input type="text" name="pair" class="form-control" placeholder="Trading Plan Name" required>
          </div>
          <div class="form-group">
            <label> Min Amount ($) </label>
            <input type="number" min='1' name="min" class="form-control" placeholder="Plan Price" required>
          </div>
          <div class="form-group">
            <label> Max Amount ($) <small>Set to zero (0) for unlimited</small> </label>
            <input type="number" name="max" class="form-control" placeholder="Plan Price" required>
          </div>
          <div class="form-group">
            <label> Profit (%) </label>
            <input type="number" name="prof" class="form-control" placeholder="Trade Profit" required>
          </div>
          <div class="form-group">
            <label> Duration (minutes)</label>
            <input type="number" name="duration" class="form-control" placeholder="Duration" required>
          </div>
          <div class="form-group">
            <label> Status </label>
            <select class="form-control" name="status" required>
              <option value="0">-- Select Status --</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="trade" class="btn btn-primary">Save</button>
        </div>
     </form>
    </div>
  </div>
</div>
<div>
  <h5> Trade
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
  New Trade
</button>
  </h5>
</div>


 <div class="card-body">            
  <div class="table-responsive">
      <?php 
    if (isset($_SESSION['success']) && $_SESSION['success'] !='') {
      echo "<h2 class='text-info'> ".$_SESSION['success']." </h2>";
      unset($_SESSION['success']);
    }
    if (isset($_SESSION['status']) && $_SESSION['status'] !='') {
      echo "<h2 class='text-danger'> ".$_SESSION['status']." </h2>";
      unset($_SESSION['status']);
    }
  ?>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Plan_Name</th>
          <th>Min_Amount</th>
          <th>Max_Amount</th>
          <th>Profit(%)</th>
          <th>Duration</th>
          <th>Status</th>
          <th>Reg_date</th>
          <th>Last_update</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
      <?php 
       $sql = "SELECT * FROM plan ORDER BY id DESC";
      $run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($run) > 0) {
      while ($row = mysqli_fetch_assoc($run)) {     
       ?>
        <tr>
          <td> <?php echo $row['name']; ?></td>
          <td>$<?= number_format($row['min']); ?></td>
          <td><?php if ($row['max'] == 0) { echo "Unlimited"; } else { echo '$'.number_format($row['max']); } ?></td>
          <td><?= $row['per']; ?>%</td>
          <td><?= $row['duration']; ?> minutes</td>
           <td><?php if ($row['status'] == 1) {
            echo ' <b class="bg-success" style="text-align: center; margin-top: 10px; padding: 3px 6px; font-size: 10px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Active</b>';
          } elseif ($row['status'] == 0) {
            echo ' <b class="bg-warning" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Inactive</b>';
          } ?></td>
          <td><?= $row['reg_date']; ?></td>
          <td><?= $row['up_date']; ?></td>
          <td>
            <form action="plan_edit.php" method="POST">
              <div style="display: flex;">

                <button type="submit" name="edit_plan" class="btn btn-success btn-sm" style="padding: 4px; margin: 3px;"> Edit </button>
            
                <input type="hidden" name="id" value=" <?php echo $row['id']; ?> ">
                <button type="submit" name="del_trade" class="btn btn-danger btn-sm" style="padding: 4px; margin: 3px;"> Delete </button>
              </div>
            </form>
          </td>
        </tr>

       <?php
      }
    } else {
      echo "No Record Found";
    }
  ?>
      </tbody>
    </table>
  </div>
</div>


<?php 
include('includes/script.php');
include('includes/footer.php');
?>