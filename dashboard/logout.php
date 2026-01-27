<?php 
	session_start();
	
	// Clear USER-specific session variables
	unset($_SESSION['user_id']);
	unset($_SESSION['user_email']);
	unset($_SESSION['user_account_id']);
	unset($_SESSION['last_activity']);
	unset($_SESSION['session_type']);
	
	// Completely destroy session
	session_destroy();
	
	header('location: login.php');
?>
