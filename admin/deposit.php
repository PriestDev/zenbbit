<?php 
include('security.php');
require('../details.php');
include('includes/header.php');
include('includes/navbar.php');

?>

 <div class="card-body">
      <div class="table-responsive">
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
              <th>Proof</th>
              <th>Status</th>
              <th>Create_at</th>
              <th>Last_update</th>
              <th>Action</th>
            </tr>
        </thead>
        <tbody>
          <?php 
          
          $sql = "SELECT * FROM transaction WHERE status = 'deposit' ORDER BY id DESC";
          $run = mysqli_query($conn, $sql); 
          
            if (mysqli_num_rows($run) > 0) {
              while ($row = mysqli_fetch_assoc($run)) {
           ?>
    
            <form method="POST" action="code.php">
            <tr>
              <td><?php echo $row['trx_id']; ?></td>
              <td><?php echo $row['user_id']; ?></td>
              <td><?php 
              if($row['serial'] == 0) {
                  ?>
                  <input type="text" value="<?= $row['name'] ?>" class="form-control" name="pair">
                  <?php
              } else {
                  echo $row['name'];
              }
              ?></td>
              <td><?php 
              if($row['serial'] == 0) {
                  ?>
                  <input type="number" value="<?= $row['amt'] ?>" class="form-control" name="amt">
                  <?php
              } else {
                  echo '$' .$row['amt'];
              }
              ?></td>
                <td><a href="https://<?= DOMAIN ?>/uploads/proofs/<?= $row['proof'] ?>"><img src="../uploads/proofs/<?= $row['proof'] ?>" height="80px" width="150px"></a></td>
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
                     <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                 <button type="submit" name="delete_deposit" class="btn btn-danger btn-sm"> DELETE </button>
                  </center>
    
                  <?php
                } ?>
              </td>        
            </tr>
             </form>
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