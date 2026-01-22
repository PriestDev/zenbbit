<?php 
session_start();

if (isset($_POST['logout_btn'])) {
	
	
	unset($_SESSION['username']);
	header('location: login.php');
}



?>
