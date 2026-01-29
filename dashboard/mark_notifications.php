<?php
// Mark all notifications as read (sets session cutoff)
header('Content-Type: application/json');
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

// Store a timestamp indicating notifications up to this time are read
$_SESSION['notifications_read_at'] = time();

echo json_encode(['status' => 'ok']);
?>
