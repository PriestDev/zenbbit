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
        <h4 class="modal-title" id="exampleModalLongTitle">Admin form</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">
	      <div class="modal-body">

	        <div class="form-group">
	        	<label> Username </label>
	        	<input type="text" name="username" class="form-control" placeholder="Enter Username">
	        </div>
	        <div class="form-group">
	        	<label> Email </label>
	        	<input type="email" name="email" class="form-control" placeholder="Enter Email">
	        </div>
	        <div class="form-group">
	        	<label> Passsword </label>
	        	<input type="password" name="password" class="form-control" placeholder="Password">
	        </div>
	        <div class="form-group">
	        	<label> Confirm Password </label>
	        	<input type="password" name="cpassword" class="form-control" placeholder="Confirm Password">
	        </div>
          <input type="hidden" name="usertype" value="sub admin">

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" name="register" class="btn btn-primary">Save</button>
	      </div>
     </form>
    </div>
  </div>
</div>
<div>
	<h5> Admin
	<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
  New Admin
</button>
	</h5>
</div>

 <div class="card-body">
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
  <div class="table-responsive">
    <?php 
      
      $sql = "SELECT * FROM admin";
      $run = mysqli_query($conn, $sql);
     ?>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th>
          <th>User_name</th>
          <th>Email</th>
          <th>Status</th>
          <th>Reg_date</th>
          <th>Updated_at</th>
          <th>Status</th>
        </tr>
    </thead>
    <tbody>
      <?php 
    if (mysqli_num_rows($run) > 0) {
      while ($row = mysqli_fetch_assoc($run)) {
       ?>


        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['user_name']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php if ($row['status'] == 1) {
            echo ' <b class="bg-success" style="text-align: center; margin-top: 10px; padding: 3px 6px; font-size: 10px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">ACTIVE</b>';
          } elseif ($row['status'] == 0) {
            echo ' <b class="bg-warning" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">INACTIVE</b>';
          } ?></td>
          <td><?php echo date("Y-m-d h:iA", strtotime($row['reg_date'])); ?></td>
          <td><?php echo date("Y-m-d h:iA", strtotime($row['update_date'])); ?></td>
            <td>
                 <form method="POST" action="code.php"> 
                
                <?php
                 if ($row['usertype'] == 1) {
                  ?>

                   <p style="text-align: center; padding: 3px; margin: 5px 13px; background-color: lightblue; color: white; font-weight: 6em; border-radius: 5px;">Super Admin</p>

                    <?php
                } elseif ($row['usertype'] == 0) {
                    ?>

                    <center>
                      <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                      <button type="submit" name="edit_btn" class="btn btn-success btn-sm"> EDIT </button>

                      <input type="hidden" name="delete_admin" value="<?php echo $row['id'] ?>">
                      <button type="submit" name="delete_btn" class="btn btn-danger btn-sm"> DELETE </button>
                    </center>
                    
                   <?php
                  } ?>
                    
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