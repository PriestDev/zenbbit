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
// SESSION VALIDATION - Check if ADMIN is logged in
// =====================================================================
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// =====================================================================
// PREVENT USER SESSION FROM ACCESSING ADMIN AREA
// =====================================================================
if (isset($_SESSION['user_id']) || isset($_SESSION['user_email'])) {
    // User is trying to access admin area - clear their session
    session_destroy();
    header('Location: login.php');
    exit;
}

?>