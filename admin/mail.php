<?php 
include('security.php');

include('includes/header.php');
require '../details.php';
include('includes/navbar.php');

?>

<div class="card-body">
  <div class="table-responsive">
     
  <center>
  <div class="col-xl-8 col-lg-8">

      <!-- Area Chart -->
      <div class="card shadow mb-4">
          <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-dark">Send Mail</h6>
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

               $sql = "SELECT * FROM user";
              $run = mysqli_query($conn, $sql);

            ?>
    <form action="code.php" method="POST">
        <div class="modal-body">
           <div class="form-group">
              <label>Mailer Account:</label>
              <select class="form-control" name="mailer">
                <option  value="" class="text-fade">-- Select mailer account --</option>
                <option value="admin@<?= DOMAIN ?>">admin@<?= DOMAIN ?></option>
                <option value="support@<?= DOMAIN ?>">support@<?= DOMAIN ?></option>
                <option value="info@<?= DOMAIN ?>">info@<?= DOMAIN ?></option>
                <option value="no-reply@<?= DOMAIN ?>">no-reply@<?= DOMAIN ?></option>
                <option value="kyc@<?= DOMAIN ?>">kyc@<?= DOMAIN ?></option>
              </select>
          </div>
          <div class="form-group">
            <label> Subject </label>
            <input type="text" name="subject" required class="form-control" placeholder="Enter Email Subject">
          </div>
          <!--<div class="form-group">-->
          <!--  <label> Username </label>-->
          <!--  <input type="text" name="username" class="form-control" placeholder="Enter Username">-->
          <!--</div>-->
          <div class="form-group">
            <label>User Email:</label>
            <?php
            
                $sql = "SELECT * FROM user";
                $run = mysqli_query($conn, $sql);
            
            ?>
              <select class="form-control" name="email">
                  <option  value="<?= $row['email'] ?>" class="text-fade">-- Select user email --</option>
                  <?php
                    
                    while ($row = mysqli_fetch_assoc($run))
                        {
                  ?>
                <option  value="<?= $row['email'] ?>" class="text-fade"><?= $row['email'] ?></option>
                <?php }
                ?>
              </select>
          </div>
          <div class="form-group">
            <label> Message </label>
            <textarea class="form-control" required name="message"></textarea>
         </div><br>
        </div>
        <div class="modal-footer">
          <button type="submit" name="mail" required class="btn btn-dark">Send</button>
        </div>
     </form>
     </div>
      </div>
      </center>
  </div>
</div>
<script src="../ckeditor/ckeditor.js"></script>
 <script>
     CKEDITOR.replace('message');
 </script>

<?php 
include('includes/script.php');
include('includes/footer.php');
?>