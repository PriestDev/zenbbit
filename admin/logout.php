<?php 
session_start();

// Destroy all session data
unset($_SESSION['username']);
session_destroy();

// Redirect to login
header('Location: login.php');
exit();
?>
