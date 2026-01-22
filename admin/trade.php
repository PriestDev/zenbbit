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
      <form action="code.php" method="POST">
        <div class="modal-body">
          <div class="form-group">
            <label> Duration(hours) </label>
            <input type="number" name="trade_hrs" class="form-control" value="<?= TRADE_HRS ?>" required>
          </div>
          <div class="form-group">
            <label> Profit(%) </label>
            <input type="number" name="prof" class="form-control" value="<?= T_PROFIT ?>" required>
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
  <h5> Active Plans
  <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
  Auto Trade Settings
</button> -->
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
    <div class="mb-3">
        <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search User_ID in table.." title="Type in a User ID">
    </div>
    <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Trade ID</th>
          <th>User ID</th>
          <th>Trade Pair</th>
          <th>Amount</th>
          <th>Profit</th>
          <th>Status</th>
          <th>Start_date</th>
          <th>End_date</th>
          <th>Last_update</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
      <?php 
       $sql = "SELECT * FROM trade ORDER BY id DESC";
      $run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($run) > 0) {
      while ($row = mysqli_fetch_assoc($run)) {     
       ?>
        <tr>
          <td> <?php echo $row['trx_id']; ?></td>
          <td><?php echo $row['user']; ?></td>
          <td><?php echo $row['pair']; ?></td>
          <td>$<?php echo $row['amount']; ?></td>
          <td>$<?php echo $row['profit']; ?></td>
           <td><?php if ($row['status'] == 1) {
            echo ' <b class="bg-success" style="text-align: center; margin-top: 10px; padding: 3px 6px; font-size: 10px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Trading</b>';
          } elseif ($row['status'] == 0) {
            echo ' <b class="bg-warning" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Pending</b>';
          } elseif ($row['status'] == 2) {
            echo ' <b class="bg-dark" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Ended</b>';
          } ?></td>
          <td><?php echo $row['create_date']; ?></td>
          <td><?php echo date('Y-m-d h:m:s', strtotime($row['end_date'])); ?></td>
          <td><?php echo $row['up_date']; ?></td>
          <td>
            <form action="trade_edit.php" method="POST">
                <?php $_SESSION['set_trade'] = $row['id']; ?>
              <div style="display: flex;">
                <input type="hidden" value="<?= $_SERVER['PHP_SELF'] ?>" name="file">
                <input type="hidden" name="edit" value=" <?php echo $row['id']; ?> ">
                <button type="submit" name="edit_plan" class="btn btn-success btn-sm" style="padding: 4px; margin: 3px;"> Set up plan </button>
            
                <input type="hidden" name="id" value=" <?php echo $row['id']; ?> ">
                <button type="submit" name="del_trade" class="btn btn-danger btn-sm" style="padding: 4px; margin: 3px;"> Delete plan </button>
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

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
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