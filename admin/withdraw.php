<?php 
include('security.php');

include('includes/header.php');
include('includes/navbar.php');
   ?>


 <div class="card-body">
  <form action="code.php" method="POST"> 
    <!--  
    <div style="align-items: right;">
      <input type="" name="" value="<?php //echo $row['serial']; ?>">
     <button type="submit" name="clear" class="btn btn-gray "> Clear All </button>
     </div>
     -->
  </form> 
  <div class="table-responsive">
      <div class="mb-3">
        <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search TRX_ID in table.." title="Type in a Transaction ID">
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
    <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>TRX_ID</th>
          <th>User_ID</th>
          <th>Method</th>
          <th>Gateway</th>
          <th>Status</th>
          <th>Amount</th>
          <th>Wallet/Bank Details</th>
          <th>Create_at</th>
          <th>Last_update</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
      <?php 
      $sql = "SELECT * FROM transaction WHERE status = 'withdraw' ORDER BY id DESC";
      $run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($run) > 0) {
      while ($row = mysqli_fetch_assoc($run)) {     
       ?>
        <tr>
          <td> <?php echo $row['trx_id']; ?></td>
          <td><?php echo $row['user_id']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php if ($row['gate_way'] == 1) {
            echo ' <b class="bg-dark" style="text-align: center; margin-top: 10px; padding: 3px 6px; font-size: 10px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Balance</b>';
          } elseif ($row['gate_way'] == 2) {
            echo ' <b class="bg-dark" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Profit</b>';
          } elseif ($row['gate_way'] == 3) {
            echo ' <b class="bg-dark" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Referral</b>';
          } else {
            echo ' <b class="bg-dark" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Withdrawable_Amount</b>';
          }
          ?></td>
          <td><?php if ($row['serial'] == 0) {
            echo ' <b class="bg-warning" style="text-align: center; margin-top: 10px; padding: 3px 6px; font-size: 10px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Pending</b>';
          } elseif ($row['serial'] == 1) {
            echo ' <b class="bg-success" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Approved</b>';
          } elseif ($row['serial'] == 2) {
            echo ' <b class="bg-danger" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Declined</b>';
          } ?></td>
          <td><?php echo $row['amt']; ?></td>
          <td><?php if ($row['name'] == 'BANK') {
                                    echo "Account Number: ".$row['acct_num'].", Account Name: ". $row['acct_name'].", Bank: " . $row['bank_name'] . ", Routing Number: " . $row['route'];
                                } else {
                                    echo $row['details'];
                                }?></td>
          <td><?= date('Y-m-d h:ia', strtotime($row['create_date'])) ?></td>
          <td><?= date('Y-m-d h:ia', strtotime($row['update'])) ?></td>
          <td>
           <form method="POST" action="code.php">
            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
            <input type="hidden" value="<?= $row['amt']; ?>" name="amt">
            <input type="hidden" value="<?= $row['user_id'] ?>" name="user_id">
            <input type="hidden" value="<?= $row['email'] ?>" name="email"> 
            <input type="hidden" name="gate_way" value="<?php echo $row['gate_way'] ?>">
            <input type="hidden" value="<?= $_SERVER['PHP_SELF'] ?>" name="file">
            <?php if ($row['serial'] == 0) {
              ?>
            <center >
                <input type="hidden" name="approve_status" value="<?php echo $row['trx_id']; ?>">
                <button type="submit" name="approve_wth" class="btn btn-success btn-sm"> Approve </button>
                
                <button type="submit" name="decline_wth" class="btn btn-danger btn-sm"> Decline </button>
            </center>
              
              <?php
            } else {
              ?>

              <center>
                <input type="hidden" name="delete_wth" value="<?php echo $row['trx_id'] ?>">
                <button type="submit" name="delete_withdraw" class="btn btn-danger btn-sm"> DELETE </button>
              </center>

              <?php
            } 
            ?>
        
              
              
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