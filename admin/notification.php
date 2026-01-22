<?php 
include('security.php');

if (isset($_POST['notify_wth'])) {
	$id = $_POST['id'];

	 $sql = "UPDATE notification SET status='clicked' WHERE id='$id' ";
	 $run = mysqli_query($conn, $sql);

	if ($run) {
			header('location: withdraw.php');
		} else {
		
			header('location: index.php');
		}

} elseif (isset($_POST['notify_depo'])) {
	$id = $_POST['id'];

	 $sql = "UPDATE notification SET status='clicked' WHERE id='$id' ";
	 $run = mysqli_query($conn, $sql);

	if ($run) {
			header('location: deposit.php');
		} else {
		
			header('location: index.php');
		}

}

include('includes/header.php');
include('includes/notify_nav.php');
?>

<!-- Begin Page Content -->
    <div class="container-fluid">
       

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Notification</h1>

        </div>
        <?php 
           
            if (isset($_SESSION['status']) && $_SESSION['status'] !='') {
              echo "<h2 class='text-danger'> ".$_SESSION['status']." </h2>";
              unset($_SESSION['status']);
            }
        ?>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-12 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-3">
                    <div class="card-body">
                        <div class="row  align-items-center">

                        	<div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                            <div class="col mr-2">
                                
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    
                                  
                                </div>
                            </div>
                            <div class="col-auto text-gray-800 btn">
                                &times;
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php
include('includes/script.php');
include('includes/footer.php');
?>