<?php
/**
 * DEBUG SCRIPT - Check wallet handler status
 */

header('Content-Type: application/json');

include '../includes/dashboard_init.php';

// Check session
echo json_encode([
    'session_id' => session_id(),
    'session_status' => session_status(),
    'has_user_id' => isset($_SESSION['user_id']),
    'user_id' => $_SESSION['user_id'] ?? null,
    'has_wallet_token' => isset($_SESSION['wallet_token']),
    'wallet_token_length' => isset($_SESSION['wallet_token']) ? strlen($_SESSION['wallet_token']) : 0,
    'php_version' => phpversion(),
    'post_data' => $_POST ?? [],
    'server_info' => [
        'method' => $_SERVER['REQUEST_METHOD'],
        'remote_addr' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 50)
    ]
], JSON_PRETTY_PRINT);
?>
