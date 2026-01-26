<?php 
date_default_timezone_set("Europe/London");

session_start();

// =====================================================================
// SESSION TIMEOUT - Check if session has expired (15 minutes inactivity)
// =====================================================================
$session_timeout = 900; // 15 minutes in seconds

if (isset($_SESSION['last_activity'])) {
    $inactive_time = time() - $_SESSION['last_activity'];
    
    if ($inactive_time > $session_timeout) {
        // Session expired - destroy and redirect
        session_destroy();
        header('Location: login.php');
        exit;
    }
}

// Update last activity time
$_SESSION['last_activity'] = time();

// =====================================================================
// DATABASE CONNECTION
// =====================================================================
include('../database/db_config.php');

// Check if database connection failed
if (!$conn) {
    header('Location: ../database/db_config.php');
    exit;
}

// =====================================================================
// SESSION VALIDATION - Check if user is logged in
// =====================================================================
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

?>