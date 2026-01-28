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
    
    // Query for user's deposits (if deposits table exists)
    // For now, return empty array as deposits table may not be set up
    $deposits = [];
    
    // Try to query deposits if the table exists
    $check_table = "SELECT COUNT(*) FROM information_schema.TABLES 
                   WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'deposits' LIMIT 1";
    $result = mysqli_query($conn, $check_table);
    $table_exists = mysqli_fetch_row($result)[0] > 0;
    
    if ($table_exists) {
        $sql = "SELECT id, user_id, amount, currency, status, approval, trx_id, date 
                FROM deposits 
                WHERE user_id = ? OR acct_id = ?
                ORDER BY date DESC 
                LIMIT 50";
        
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $user_id, $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            while ($row = mysqli_fetch_assoc($result)) {
                $deposits[] = [
                    'id' => $row['id'],
                    'amount' => $row['amount'],
                    'currency' => strtoupper($row['currency']),
                    'status' => $row['status'] ?? 'pending',
                    'approval' => $row['approval'] ?? 0,
                    'trx_id' => $row['trx_id'] ?? 'N/A',
                    'date' => $row['date']
                ];
            }
            mysqli_stmt_close($stmt);
        }
    }
    
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
