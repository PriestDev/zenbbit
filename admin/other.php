<?php 
include('security.php');
require('../details.php');
include('includes/header.php');
include('includes/navbar.php');


?>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Add Bonus</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <center class='text-danger'> All field is required</center>
      <form action="code.php" method="POST">
	      <div class="modal-body">
            <div class="form-group">
            <label>User</label>
            <?php
            
                $sql = "SELECT * FROM user ORDER BY id DESC";
                $run = mysqli_query($conn, $sql);
            
            ?>
              <select class="form-control" name="user" required>
                  <option  value"" class="text-fade">-- Select user  --</option>
                  <?php
                    
                    while ($row = mysqli_fetch_assoc($run))
                        {
                  ?>
                <option  value="<?= $row['email'] ?>" class="text-fade"><?= $row['first_name'] .' '. $row['last_name']; ?></option>
                <?php }
                ?>
              </select>
          </div>
	        <div class="form-group">
	        	<label> Amount <span class='text-danger'>*</span></label>
	        	<input type="number" required name="amount" class="form-control" placeholder="Enter Amount">
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" name="bonus" class="btn btn-primary">Save</button>
	      </div>
     </form>
    </div>
  </div>
</div>

<div class="card-body">
      <div class="table-responsive">
         <div>
        	<h5> Bonus
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                  Add
                </button>
        	</h5>
        </div>

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
            <div class="mb-3">
                <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search TRX_ID in table.." title="Type in a Transaction ID">
            </div>
            <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>TRX_ID</th>
              <th>User_ID</th>
              <th>Method</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Create_at</th>
              <th>Last_update</th>
              <th>Action</th>
            </tr>
        </thead>
        <tbody>
          <?php 
          
          $sql = "SELECT * FROM transaction WHERE status = 'other' ORDER BY id DESC";
          $run = mysqli_query($conn, $sql); 
          
            if (mysqli_num_rows($run) > 0) {
              while ($row = mysqli_fetch_assoc($run)) {
           ?>
            <tr>
              <td><?php echo $row['trx_id']; ?></td>
              <td><?php echo $row['user_id']; ?></td>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo '$' .$row['amt']; ?></td>
               <td><?php if ($row['serial'] == 0) {
                echo ' <b class="bg-warning" style="text-align: center; margin-top: 10px; padding: 3px 6px; font-size: 10px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Pending</b>';
              } elseif ($row['serial'] == 1) {
                echo ' <b class="bg-success" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Approved</b>';
              } elseif ($row['serial'] == 2) {
                echo ' <b class="bg-danger" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Declined</b>';
              } ?></td>
              <td><?= date('Y-m-d h:ia', strtotime($row['create_date'])) ?></td>
              <td><?= date('Y-m-d h:ia', strtotime($row['update'])) ?></td>
              <td>
               <form method="POST" action="code.php"> 
                <input type="hidden" value="<?= $row['amt']; ?>" name="amt">
                <input type="hidden" value="<?= $row['user_id'] ?>" name="user_id">
                <input type="hidden" value="<?= $row['email'] ?>" name="email">
                <?php if ($row['serial'] == 0) {
                  ?>
                    <center >
                    <input type="hidden" name="approve_serial" value="<?php echo $row['trx_id']; ?>">
                  <button type="submit" name="approve_deposit" class="btn btn-success btn-sm"> Approve </button>
    
                <input type="hidden" name="serial" value="<?php echo $row['trx_id'] ?>">
                 <button type="submit" name="decline_deposit" class="btn btn-danger btn-sm"> Decline </button>
                  </center>
                  
                  <?php
                } else {
                  ?>
    
                <center>
                    <input type="hidden" name="delete_wth" value="<?php echo $row['id'] ?>">
                    <button type="submit" name="delete_trx" class="btn btn-danger btn-sm"> DELETE </button>
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