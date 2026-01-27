<?php 
session_start();

// Clear ADMIN-specific session variables
unset($_SESSION['admin_id']);
unset($_SESSION['admin_username']);
unset($_SESSION['admin_email']);
unset($_SESSION['admin_type']);
unset($_SESSION['last_activity']);
unset($_SESSION['session_type']);

// Completely destroy session
session_destroy();

// Redirect to login
header('Location: login.php');
exit();
?>
