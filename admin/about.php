<?php
include('security.php');
include('includes/header.php');
include('includes/navbar.php');

?>
<div class="container-fluid" style="max-width: 800px;">

     <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">About Us</h6>
        </div> 
        <div class="card-body">
            <?php 
        if (isset($_SESSION['status']) && $_SESSION['status'] !='') {
      echo "<h2 class='text-danger'> ".$_SESSION['status']." </h2>";
      unset($_SESSION['status']);
    }
  
        $sql = "SELECT * FROM page_content";
        $run = mysqli_query($conn, $sql);

        foreach ($run as $row ) {
        
    ?>
      
        <form method="POST" action="code.php" enctype="multipart/form-data">
          <!--   <div class="form-group">
                <label> About us </label>
                <textarea type="text" name="about"value="<?php echo $row['about']; ?>"  class="form-control" required></textarea>
            </div>
            <br> -->
            <div class="form-group">
                <label> Site Link Description </label>
                <textarea type="text" name="about"value="<?php echo $row['about']; ?>"  class="form-control" required></textarea>
            </div>
            <div>
                <a href="index.php" class="btn btn-danger">CANCEL</a>
                <button type="submit" name="about" class="btn btn-primary">UPDATE</button>
            </div>
        </form>
   <?php

        }
        
    ?>
<?php
include('includes/script.php');
 ?>