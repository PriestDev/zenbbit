<?php 
include('security.php');

include('includes/header.php'); 
include('includes/navbar.php');
?>
  

    <!-- Begin Page Content -->
    <div class="container-fluid">
       

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

        </div>
        <?php 
           
            if (isset($_SESSION['status']) && $_SESSION['status'] !='') {
              echo "<h2 class='text-danger'> ".$_SESSION['status']." </h2>";
              unset($_SESSION['status']);
            }
            if (isset($_SESSION['success']) && $_SESSION['success'] !='') {
              echo "<h2 class='text-success'> ".$_SESSION['success']." </h2>";
              unset($_SESSION['success']);
            }
        ?>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Balance</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    
                                    <?php 
                                    $mysqli_query = "SELECT SUM(amt) AS figure FROM transaction WHERE serial= 1 AND status = 'deposit'";

                                      $run = mysqli_query($conn, $mysqli_query);
                                      $val = mysqli_fetch_assoc($run);
                                      $total = $val['figure'];
                                   

                                    $sql = "SELECT SUM(amt) AS total FROM transaction WHERE serial= 1 AND status = 'withdraw'";

                                      $result = mysqli_query($conn, $sql);
                                      $row = mysqli_fetch_assoc($result);
                                      $sum = $row['total'];

                                      $display = $total - $sum;
                                      if ($display <= 0) {
                                          echo '<h1>0</h1>';
                                      } else{
                                         echo '<h1>' .number_format($display). '</h1>';
                                      }
                                       

                                     ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                   <a href="users.php" class="text-dark">Total Users</a></div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">

                                    <?php 
                                            $sql = "SELECT id FROM user ORDER BY id";
                                            $run = mysqli_query($conn, $sql);

                                            $row = mysqli_num_rows($run);

                                            echo "<h1>".$row."</h1>";

                                        ?>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- registered admin Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> 
                                <a href="register.php" class="text-dark"> Registered Admin </a>
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <?php 
                                            $sql = "SELECT id FROM admin ORDER BY id";
                                            $run = mysqli_query($conn, $sql);

                                            $row = mysqli_num_rows($run);

                                            echo "<h1>".$row."</h1>";

                                        ?>
                                        
                                    </div>
                                    <div class="col">
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    <a href="deposit.php" class="text-dark"> Pending Deposit </a></div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    
                                    <?php
                                    $sql = "SELECT * FROM transaction WHERE status= 'deposit' AND serial = 0 ";
                                    $run = mysqli_query($conn, $sql);

                                            $row = mysqli_num_rows($run);

                                            echo "<h1>".$row."</h1>";
                                     ?>
                                </div>
                            </div>
                            <?php if($row >= 1)
                            {
                              ?>
                                <div class="col-auto">
                                <i class="fas fa-spinner fa-spin fa-2x text-gray-300"></i>
                                </div>
                              <?php
                            }?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    <a href="withdraw.php" class="text-dark">Pending Withdraw</a></div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    
                                    <?php
                                    $sql = "SELECT * FROM transaction WHERE serial= 0 AND status = 'withdraw' ";
                                    $run = mysqli_query($conn, $sql);

                                            $row = mysqli_num_rows($run);

                                            echo "<h1>".$row."</h1>";
                                     ?>
                                </div>
                            </div>
                            <?php if($row >= 1)
                            {
                              ?>
                            <div class="col-auto">
                                <i class="fas fa-spinner fa-pulse fa-2x text-gray-300"></i>
                            </div>
                            <?php
                            }?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- trades -->

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    <a href="trade.php" class="text-dark">Pending Trades</a></div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    
                                    <?php
                                    $sql = "SELECT * FROM trade WHERE status = 0 ";
                                    $run = mysqli_query($conn, $sql);

                                            $row = mysqli_num_rows($run);

                                            echo "<h1>".$row."</h1>";
                                     ?>
                                </div>
                            </div>
                            <?php if($row >= 1)
                            {
                              ?>
                            <div class="col-auto">
                                <i class="fas fa-spinner fa-pulse fa-2x text-gray-300"></i>
                            </div>
                            <?php
                            }?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Transactions</h6>
                <!-- <form action="code.php" method="POST">
                  <button type="submit" name="clear_t" class="btn btn-sm"><i class="fas fa-trash"></i></button>
                </form> -->
            </div>
         <div class="card-body">
  <div class="table-responsive">
      <div class="mb-3">
        <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search TRX_ID in table.." title="Type in a Transaction ID">
      </div>
    <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Trx_ID</th>
          <th>User_ID</th>
          <th>gateway</th>
          <th>Status</th>
          <th>Trx Type</th>
          <th>Amount</th>
          <th>Create_at</th>
          <th>Last_update</th>
        </tr>
    </thead>
    <tbody>
      <?php 

      
             $sql = "SELECT * FROM transaction ORDER BY id DESC";
            $run = mysqli_query($conn,$sql);

               if (mysqli_num_rows($run) > 0) {
                while ($row = mysqli_fetch_assoc($run)) {
      ?>


        <tr>
          <td><?php echo $row['trx_id']; ?></td>
          <td><?php echo $row['user_id']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php if ($row['serial'] == 0) {
            echo ' <b class="bg-warning" style="text-align: center; margin-top: 10px; padding: 3px 6px; font-size: 10px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Pending</b>';
          } elseif ($row['serial'] == 1) {
            echo ' <b class="bg-success" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Approved</b>';
          } elseif ($row['serial'] == 2) {
            echo ' <b class="bg-danger" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Declined</b>';
          } ?></td>
          <td><?php echo $row['status']; ?></td>
          <td><?php echo $row['amt']; ?></td>
          <td><?php echo date('Y-m-d h:ia', strtotime($row['create_date'])) ?></td>
          <td><?= date('Y-m-d h:ia', strtotime($row['update'])) ?></td>
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
</div>

    

</div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

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
   
   
