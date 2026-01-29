<?php
/**
 * GET_DEPOSITS.PHP - Fetch user deposits history
 * 
 * Returns user's deposit history for display on dashboard/deposit pages
 * Handles AJAX requests from deposit form module
 */

// Include database configuration
include '../../database/db_config.php';

// Set response header as JSON
header('Content-Type: application/json');

// Check if user is authenticated
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized',
        'deposits' => []
    ]);
    exit;
}

try {
    $user_id = $_SESSION['user_id'];
    
    // Query user's deposits from transaction table
    $sql = "SELECT id, trx_id, user_id, amt, name, serial, email, create_date 
            FROM transaction 
            WHERE status = 'deposit' AND user_id = ?
            ORDER BY create_date DESC";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
    }
    
    $result = mysqli_stmt_get_result($stmt);
    $deposits = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        // Map serial to status label
        $statusLabel = 'Pending';
        switch ($row['serial']) {
            case 0:
                $statusLabel = 'Pending';
                break;
            case 1:
                $statusLabel = 'Approved';
                break;
            case 2:
                $statusLabel = 'Declined';
                break;
        }
        
        $deposits[] = [
            'id' => $row['id'],
            'trx_id' => $row['trx_id'],
            'amount' => (float)$row['amt'],
            'currency' => htmlspecialchars($row['name']),
            'status' => 'deposit',
            'approval' => (int)$row['serial'],
            'approval_status' => $statusLabel,
            'email' => $row['email'],
            'date' => $row['create_date']
        ];
    }
    
    mysqli_stmt_close($stmt);
    
    // Return success response
    echo json_encode([
        'success' => true,
        'deposits' => $deposits,
        'timestamp' => time()
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching deposits: ' . $e->getMessage(),
        'deposits' => []
    ]);
}

mysqli_close($conn);
?>
