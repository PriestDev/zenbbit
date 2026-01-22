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
        <h4 class="modal-title" id="exampleModalLongTitle">Users form</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <center class='text-danger'> All field is required</center>
      <center class='text-danger'>* Unique field</center>
      <form action="code.php" method="POST">
	      <div class="modal-body">
           <div class="form-group">
            <label> Name <span class='text-danger'>*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Enter Name">
          </div>
	        <div class="form-group">
	        	<label> Username <span class='text-danger'>*</span></label>
	        	<input type="text" name="username" class="form-control" placeholder="Enter Username">
	        </div>
	        <div class="form-group">
	        	<label> Email <span class='text-danger'>*</span></label>
	        	<input type="email" name="email" class="form-control" placeholder="Enter Email">
	        </div>
          <div class="form-group">
            <label> Wallet Address <span class='text-danger'>*</span></label>
            <input type="text" name="wallet" class="form-control" placeholder="Enter Wallet Address">
          </div>
	        <div class="form-group">
	        	<label> Passsword </label>
	        	<input type="password" name="password" class="form-control" placeholder="Password">
	        </div>
	        <div class="form-group">
	        	<label> Confirm Password </label>
	        	<input type="password" name="cpassword" class="form-control" placeholder="Confirm Password">
	        </div>
          

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" name="user_btn" class="btn btn-primary">Save</button>
	      </div>
     </form>
    </div>
  </div>
</div>
<!--<div>-->
<!--	<h5> User-->
	<!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">-->
<!--  New User-->
<!--</button>-->
<!--	</h5>-->
<!--</div>-->

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
         <div class="mb-3">
        <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search User in table.." title="Type in a User">
      </div>
    <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th>
          <!--<th>Upline_ID</th>-->
          <th>Name</th>
          <th>Email</th>
          <th>Status</th>
          <th>Reg_date</th>
          <th>Updated_at</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
           <?php 
          $sql = "SELECT * FROM user ORDER BY id DESC";
          $run = mysqli_query($conn, $sql);
            if (mysqli_num_rows($run) > 0) {
              while ($row = mysqli_fetch_assoc($run)) {
           ?>
        <tr>
          <td><?php echo $row['acct_id']; ?></td>
          <!--<td><?php echo $row['ref_id']; ?></td>-->
          <td><?php echo $row['first_name'] .' '. $row['last_name']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php if ($row['status'] == 1) {
            echo ' <b class= "bg-success" style="text-align: center; margin-top: 10px; padding: 3px 6px; font-size: 10px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">ACTIVE</b>';
          } elseif ($row['status'] == 2) {
            echo ' <b class= "bg-warning" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">PENDING</b>';
          } elseif ($row['status'] == 0) {
            echo ' <b class= "bg-danger" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">BLOCKED</b>';
          } elseif ($row['status'] == 3) {
            echo ' <b class= "bg-secondary" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">BANNED</b>';
          } ?></td>
          <td><?php echo date("Y-m-d h:i:A", strtotime($row['reg_date'])); ?></td>
          <td><?php echo date("Y-m-d h:i:A", strtotime($row['update'])); ?></td>
          <td style=" display: flex; justify-content: space-between;">
            <input type="hidden" name="phrase" value="<?php echo $row['phrase'] ?>">
            <a class="btn btn-secondary btn-sm" href="user_edit.php?id=<?= $row['id'] ?>">Edit</a>
           <form method="POST" action="code.php">
                <input type="hidden" name="delete_id" value="<?php echo $row['id'] ?>">
                <!--<button style="margin: 2px;" type="submit" name="delete" class="btn btn-danger btn-sm"> Delete </button>-->
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

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>

<?php 
include('includes/script.php');
include('includes/footer.php');
?>