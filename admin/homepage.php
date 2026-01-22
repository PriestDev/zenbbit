<?php 
include('security.php');

include('includes/header.php');
include('includes/navbar.php');
?>

<div class="card-body">
  <div class="table-responsive">
     
  <center>
  <div class="col-xl-8 col-lg-8">

      <!-- Area Chart -->
      <div class="card shadow mb-4">
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
          <form action="code.php" method="POST" enctype="multipart/form-data">
              <input name="id" type="hidden" value="$row['id']"/>
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-dark">Homepage</h6>
                </div>
                <div class="card-body">
                    <?php
                       $sql = "SELECT * FROM page_content";
                        $run = mysqli_query($conn, $sql);
        
                      foreach ($run as $row ) {
                    ?>
                    <div class="modal-body">
                      <div class="form-group">
                        <label> Website Name </label>
                        <input type="text" name="sitename" class="form-control" value="<?php echo $row['site_name']; ?>" placeholder="Enter Websitename">
                      </div>
                      <div class="form-group">
                        <label> Phone </label>
                        <input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>" placeholder="Enter Phone">
                      </div>
                       <div class="form-group">
                          <label>Website Mailer Account <small>current (<?= EMAIL ?>)</small>:</label>
                          <select class="form-control" name="email">
                            <option value="<?= EMAIL ?>" class="text-fade">-- Select mailing account --</option>
                                <option value="admin@<?= DOMAIN ?>">admin@<?= DOMAIN ?></option>
                                <option value="support@<?= DOMAIN ?>">support@<?= DOMAIN ?></option>
                          </select>
                      </div>
                      <div class="form-group">
                        <label> Address </label>
                        <input type="text" name="address" class="form-control" value="<?php echo $row['address']; ?>" placeholder="Enter Address">
                      </div>
                      
                      <div class="form-group">
                        <label> BTC Address </label>
                        <input type="text" name="btc" class="form-control" value="<?= BTC; ?>" placeholder="Enter BTC Address">
                      </div>
                      <div class="form-group">
                        <label> ETH Address </label>
                        <input type="text" name="eth" class="form-control" value="<?= ETH; ?>" placeholder="Enter ETH Address">
                      </div>
                      <div class="form-group">
                        <label> TRC Address </label>
                        <input type="text" name="trc" class="form-control" value="<?= TRC; ?>" placeholder="Enter USDT(trc20) Address">
                      </div>
                      <div class="form-group">
                        <label> ERC Address </label>
                        <input type="text" name="erc" class="form-control" value="<?= ERC; ?>" placeholder="Enter USDT(erc20) Address">
                      </div>
                      
                      <div class="form-group">
                        <label> Referral Percent </label>
                        <input type="number" name="ref" class="form-control" required value="<?php echo $row['ref']; ?>" placeholder="%">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="save_site" class="btn btn-dark">Save</button>
                    </div>
                </div>
                <br>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Logo & Fav Icon</h6>
                </div>
                <div class="card-body"></div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Website Logo </label>
                            <input type="file" name="logo" class="form-control">
                        </div><br>
                        <div class="form-group">
                            <label> Website Fav Icon </label>
                            <input type="file" name="fav" class="form-control">
                        </div><br>
                        <div  style="padding: 10px;">
                            <center>
                        
                                <?php
                                if ($row['logo'] != null) {
                                 echo'<img src="../uploads/'.$row['logo'].'" class="img-profile" width= 200; height= 200; alt="logo">';
                                 ?>
                               <br>
                               <br>
                               <div>
                                <button type="submit" name="delete_logo" class="btn btn-danger">Delete Logo</button>
                               </div>
                            </center>
                           <?php 
                              }
                           ?>
                        </div> 
                        <div  style="padding: 10px;">
                            <center>
                        
                                <?php
                                    if ($row['fav'] != null) {
                                     echo'<img src="../uploads/'.$row['fav'].'" class="img-profile" width= 200; height= 200; alt="fav">';
                                 ?>
                               <br>
                               <br>
                               <div>
                                    <button type="submit" name="delete_fav" class="btn btn-danger">Delete Fav</button>
                               </div>
                            </center>
                           <?php 
                              }
                           ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="save_logo" class="btn btn-dark">Save</button>
                    </div>
                </form>
               <?php }?>
             </div>
          </div>
      </center>
  </div>
</div>
 

<?php 
include('includes/script.php');
include('includes/footer.php');
?>