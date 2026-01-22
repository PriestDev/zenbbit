<?php
// Mark all notifications as read
// This is a placeholder - connect to your database for real functionality

header('Content-Type: application/json');

// Example response
$response = [
    'status' => 'ok',
    'message' => 'All notifications marked as read'
];

echo json_encode($response);
?>
