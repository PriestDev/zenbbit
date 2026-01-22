<?php 
Include('security.php');
include('includes/header.php');
include('includes/navbar.php');
?>
<div class="container-fluid" style="max-width: 400px;">
     <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Message</h6>
        </div> 
        <div class="card-body">
            <?php 
                if (isset($_SESSION['status']) && $_SESSION['status'] !='') {
                  echo "<h2 class='text-danger'> ".$_SESSION['status']." </h2>";
                  unset($_SESSION['status']);
                }
          
                $id = $_POST['id'];
                $sql = "SELECT * FROM mails WHERE id= '$id'";
                $run = mysqli_query($conn, $sql);
        
                foreach ($run as $row ) {
                
            ?>
        <p style='padding: 10px;'><?= $row['user']; ?></p>
        <div style='padding: 10px;'>
                <?= $row['message']; ?>
        </div>

   <?php

        }

include('includes/script.php');
//include('includes/footer.php');
?>