<?php 
Include('security.php');
include('includes/header.php');
include('includes/navbar.php');
?>
<div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; width: 100%;">
    <div style="max-width: 400px; width: 100%; padding: 20px;">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
        </div> 
        <div class="card-body">
            <?php 
        if (isset($_SESSION['status']) && $_SESSION['status'] !='') {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>".$_SESSION['status']."<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
      unset($_SESSION['status']);
    }
  
        $admin = $_SESSION['username'];
        $sql = "SELECT * FROM admin WHERE user_name= '$admin'";
        $run = mysqli_query($conn, $sql);

        foreach ($run as $row ) {
        
    ?>
        <?php echo'<center><img src="../uploads/'.$row['image'].'" class="img-profile" width= 120; height= 100; alt="Image"></center><br>'; ?>

        <form method="POST" action="code.php" enctype="multipart/form-data">
            <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">
            <div class="form-group">
                <label> Upload image </label>
                <input type="file" name="edit_image" class="form-control" value="<?php echo $row['image']?>" >
            </div>
            <div class="form-group">
                <label> Username </label>
                <input type="text" name="edit_username" value="<?php echo $row['user_name']; ?>" class="form-control" placeholder="Enter Username" >
            </div>
            <div class="form-group">
                <label> Email </label>
                <input type="email" name="edit_email" value="<?php echo $row['email']; ?>" class="form-control" placeholder="Enter Email" >
            </div>
            <div class="form-group">
                <label> Password </label>
                <input type="password" name="edit_password" class="form-control" placeholder="Leave blank to keep current password" >
                <small class="form-text text-muted">Only change if you want to update your password</small>
            </div>
            <div>
                <a href="index.php" class="btn btn-danger">CANCEL</a>
                <button type="submit" name="admin_btn" class="btn btn-primary">UPDATE</button>
            </div>
        </form>
   <?php

        }
        ?>
        </div>
    </div>
</div>

<?php
include('includes/script.php');
//include('includes/footer.php');
?>