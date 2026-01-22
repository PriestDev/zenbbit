<?php
    include('security.php');
    include('includes/header.php');
    include('includes/navbar.php');
    
    if (isset($_GET['id']) && $_GET['id'] != null) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM user WHERE id = '$id'";
        $run = mysqli_query($conn, $sql);
        $row = $run->fetch_array(MYSQLI_ASSOC);
?>

<div class="container-fluid">
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
<div class="row">
    <div class="col-md-6">
    	 <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header header-elements-inline">
                <h6 class="card-title font-weight-semibold">Edit User Details</h6>
                
            </div>
            <div class="card-body">
                <form method="POST" action="code.php">
                	<input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">
                	<input type="hidden" value="<?= $_SERVER['PHP_SELF'].'?id='.$id ?>" name="file">
                	<input type="hidden" name="ip_address" value="<?php echo $row['ip_address'] ?>">
                	<div class="form-group">
        	        	<label> First Name: </label>
        	        	<input type="text" name="edit_fname" value="<?php echo $row['first_name'] ?>" class="form-control" required>
        	        </div>
        	        <div class="form-group">
        	        	<label> Last Name: </label>
        	        	<input type="text" name="edit_lname" value="<?php echo $row['last_name'] ?>" class="form-control" required>
        	        </div>
        	        <div class="form-group">
        	        	<label>Deposited Balance: </label>
        	        	<input type="text" name="user_bal" value="<?php echo $row['balance'] ?>" class="form-control" required>
        	        </div>
        	        <div class="form-group">
        	        	<label>Profit Balance: </label>
        	        	<input type="text" name="profit" value="<?php echo $row['profit'] ?>" class="form-control" required >
        	        </div>
        	        <!--<div class="form-group">-->
        	        <!--	<label>Profit Percent: </label>-->
        	        <!--	<input type="text" name="profit_per" value="<?php echo $row['profit_per'] ?>" class="form-control" required >-->
        	        <!--</div>-->
        	        <div class="form-group">
        	        	<label> Email: </label>
        	        	<input type="email" name="edit_email" value="<?php echo $row['email'] ?>" class="form-control" required>
        	        </div>
        	        <div class="form-group">
        	        	<label> User Trade Progress Percent: (current: <?= $row['trade_per'] ?>%)</label>
        	        	<input type="number" name="trade_per"value="<?php echo $row['trade_per'] ?>" max="100" class="form-control" required>
        	        </div>
        	         <div class="form-group">
        	        	<label> Phone: </label>
        	        	<input type="text" name="phone" value="<?php echo $row['phone'] ?>" class="form-control" required>
        	        </div>
        	        <div class="form-group">
        	        	<label> Passsword: </label>
        	        	<input type="text" name="edit_password"value="<?php echo $row['password'] ?>"  class="form-control" required>
        	        </div>
        	          <div class="form-group">
        	          	<label>Status:</label>
        	            <select class="form-control" name="status">
        	              <option value="1">Activate</option>
        	              <option value="0">Suspend</option>
        	              <option value="2">Pend</option>
        	              <option value="3">Ban</option>
        	            </select>
        	          </div>
        	          <div class="form-group">
        	          	<label>Account Status (<small>Default: <?= $row['acct_stat'] ?></small>):</label>
        	            <select class="form-control" name="acct_stat">
        	              <option class="text-fade" value="<?= $row['acct_stat']; ?>"> --Default-- </option>
        	              <option value="Inactive">Inactive</option>
        	              <option value="Maintenance Mode">Maintenance Mode</option>
        	              <option value="Bronze">Bronze</option>
        	              <option value="Silver">Silver</option>
        	              <option value="Gold">Gold</option>
        	              <option value="Platinum">Platinum</option>
        	              <option value="Diamond">Diamond</option>
        	            </select>
        	          </div>
        	          <div class="form-group">
        	        	<label>Manual Withdrawable Amount:</label>
        	        	<input type="text" name="wth_amt_u" value="<?php echo $row['wth_amt'] ?>" class="form-control">
        	        </div>
        	          <div class="form-check">
                          <input class="form-check-input" name="t_btn" type="checkbox" <?php if ($row['trade_btn'] == 1) {echo 'checked';}  ?> value="1" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">
                            Off Start Trade Button
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" name="wth_amt_status" type="checkbox" <?php if ($row['wth_amt_status'] == 1) {echo 'checked';}  ?> value="1" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">
                            Switch to manual withdraw for user
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" name="kyc" type="checkbox" <?php if ($row['kyc'] == 1) {echo 'checked';}  ?> value="1" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">
                            KYC
                          </label>
                        </div>
        	          <br>
        	        <div class="d-flex flex-row">
        	       <button type="submit" name="updatebtn" class="btn btn-dark ml-auto p-2">UPDATE</button>
        	        </div>
        	    </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
	     <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header header-elements-inline">
                <h6 class="card-title font-weight-semibold">User Profile</h6>
            </div>
            <div class="card-body">
            	<center>
           		    <img src="../uploads/<?php echo $row['image']; ?>" class="rounded mx-auto d-block" width= 320; height= 300;>
           		</center>
    	       	<div class="text-sm-left mt-4 ml-4 font-weight-semibold">
           			<small><p class=""><b>IP address:</b> <mark><?= $row['ip_address']; ?></mark></p></small>
           			<small><p class=""><b>Country:</b> <mark><?= $row['country']; ?></mark></p></small>
           			<small><p class=""><b>State:</b> <mark><?= $row['state']; ?></mark></p></small>
           			<small><p class=""><b>City:</b> <mark><?= $row['city']; ?></mark></p></small>
           			<small><p class=""><b>Account ID:</b> <mark><?= $row['acct_id']; ?></mark></p></small>
           			<small><p class=""><b>Device:</b> <mark><?= $row['device']; ?></mark></p></small>
           			<small><p class=""><b>Device Type:</b> <mark><?= $row['device_type']; ?></mark></p></small>
           			<small><p class=""><b>Browser:</b> <mark><?= $row['browser']; ?></mark></p></small>
           			<small><p class=""><b>Last Login:</b> <mark><?= date("l, jS F Y (h:ia)", strtotime($row['last_login']));?></mark></p></small>
           			<small><p class=""><b>Last Updated:</b> <mark><?= date("l, jS F Y (h:ia)", strtotime($row['update']));?></mark></p></small>
           			<small><p class=""><b>Reg_date:</b> <mark><?= date("l, jS F Y (h:ia)", strtotime($row['reg_date']));?></mark></p></small>
           		</div>
           	</div>
        </div>
    </div>
</div>
<div class="col-md-12">
	 <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header header-elements-inline">
            <h6 class="card-title font-weight-semibold">Referral List</h6>
        </div>
        <div class="card-body">
             <div class="table-responsive">
            	<table class="table">
              <thead>
                <tr>
                  <th scope="col">First_Name</th>
                  <th scope="col">Last_Name</th>
                  <th scope="col">Ref_Amount</th>
                  <th scope="col">Reg_date</th>
                </tr>
              </thead>
              <tbody>
                <?php
                
        			$user = $row['acct_id'];

        			$sql = "SELECT * FROM user WHERE ref_id = '$user' ";
        			$run = mysqli_query($conn, $sql);
    
            		if (mysqli_num_rows($run) > 0) {
                        while ($ref = mysqli_fetch_assoc($run)) {
        
                	?>
                <tr>
                  <th scope="row"><?= $ref['first_name'] ?></th>
                  <td><?= $ref['last_name'] ?></td>
                  <td><?= REF ?>%</td>
                  <td><?= $ref['reg_date'] ?></td>
                </tr>
                <?php
    
    		            }
                	} else {
                	    ?>
                	        <tr>
                              <td colspan="8">No result found</td>
                            </tr>
                	    <?php
                	}
    	        ?>
              </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
	 <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header header-elements-inline">
            <h6 class="card-title font-weight-semibold">Trade List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th>Trade ID</th>
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
                        $sql = "SELECT * FROM trade WHERE user = '$user' ORDER BY id DESC";
                        $run = mysqli_query($conn, $sql);
                
                        if (mysqli_num_rows($run) > 0) {
                          while ($val = mysqli_fetch_assoc($run)) {     
                       ?>
                            <tr>
                              <td> <?php echo $val['trx_id']; ?></td>
                              <td><?php echo $val['pair']; ?></td>
                              <td>$<?php echo $val['amount']; ?></td>
                              <td>$<?php echo $val['profit']; ?></td>
                                <td><?php if ($val['status'] == 1) {
                                echo ' <b class="bg-success" style="text-align: center; margin-top: 10px; padding: 3px 6px; font-size: 10px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Trading</b>';
                              } elseif ($val['status'] == 0) {
                                echo ' <b class="bg-warning" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Processing</b>';
                              } elseif ($val['status'] == 2) {
                                echo ' <b class="bg-dark" style="text-align: center; font-size: 10px; padding: 3px 6px; margin: 3px; color: white; font-weight: 6em; border-radius: 5px;">Ended</b>';
                              } ?></td>
                              <td><?php echo $val['create_date']; ?></td>
                              <td><?php echo date('Y-m-d h:m:s', strtotime($val['end_date'])); ?></td>
                              <td><?php echo $val['up_date']; ?></td>
                              <td>
                                <form action="trade_edit.php" method="POST">
                                  <div style="display: flex;">
                                    <input type="hidden" value="<?= $_SERVER['PHP_SELF'].'?id='.$id ?>" name="file">
                                    <input type="hidden" name="edit" value=" <?php echo $val['id']; ?> ">
                                    <button type="submit" name="edit_plan" class="btn btn-success btn-sm" style="padding: 4px; margin: 3px;"> Set up trade </button>
                                
                                    <input type="hidden" name="id" value=" <?php echo $val['id']; ?> ">
                                    <button type="submit" name="del_trade" class="btn btn-danger btn-sm" style="padding: 4px; margin: 3px;"> Delete Trade</button>
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
    </div>
</div>
 
    <?php

        if ($row['phrase'] != null) {
    ?>
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title font-weight-semibold">Crypto Wallet Phrase</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="code.php">
                            <input type="hidden" value="<?= $_SERVER['PHP_SELF'].'?id='.$id ?>" name="file">
                        	 <center>
                                <div class="form-group">
                    	        	<textarea class="form-control" name="phrase" required><?= $row["phrase"] ?></textarea>
                    	        </div>
                            	<br>
                               <div>
                                    <input type="hidden" value="<?php echo $row['id']; ?>" name="id">
                                    <button type="submit" name="delete_wallet" class="btn btn-danger">Delete Phrase</button>
                               </div>
                           </center>
                			<br>
                	        <?php
                			    if ($row['wallet_stat'] != 1) {
                			        ?>
                			        <div class="d-flex flex-row">
                    	      			<button type="submit" name="c_wallet" class="btn btn-dark ml-auto p-2">Verify</button>
                        	        </div>
                			        <?php 
                			    } else {
                			        
                			    }
                			?>
                	    </form>
                	</div>
                </div>
            </div>
    <?php 
        }
        
        if ($row['card'] != null) {
            ?>
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header header-elements-inline">
                            <h6 class="card-title font-weight-semibold">KYC</h6>
                            
                        </div>
                        <div class="card-body">
                            <form method="POST" action="code.php">
                        	 <center>
                                <div class="form-group">
                                <a href="../uploads/<?= $row['card'] ?>" target="_blank">
                                    <img src="../uploads/<?= $row['card'] ?>" class="rounded mx-auto d-block" width=720 height=100%>
                                </a>
                	        	<br>
                	        	<br>
                	        	<a href="../uploads/<?= $row['s_card'] ?>" target="_blank">
                                    <img src="../uploads/<?= $row['s_card'] ?>" class="rounded mx-auto d-block" width=720 height=100%>
                                </a>
                	        </div>
                               <br>
                               <br>
                               <div>
                                    <input type="hidden" value="<?php echo $row['id']; ?>" name="kyc_id">
                                    <input type="hidden" value="<?= $_SERVER['PHP_SELF'].'?id='.$id ?>" name="file">
                                    <button type="submit" name="delete_kyc" class="btn btn-danger">Delete KYC</button>
                               </div>
                            </center>

                			<br>
                			<?php
                			    if ($row['card_stat'] != 1) {
                			        ?>
                			        <div class="d-flex flex-row">
                    	      			<button type="submit" name="c_wallet" class="btn btn-dark ml-auto p-2">Verify</button>
                        	        </div>
                			        <?php 
                			    } else {
                			        
                			    }
                			?>
                	    </form>
                        </div>
                    </div>
                </div>
            <?php
        }
    ?>

<?php 
        include('includes/script.php');
        include('includes/footer.php');
    
    } else {
        header('location: ./');
    }
?>