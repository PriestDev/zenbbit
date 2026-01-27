<?php
/**
 * Admin Crypto Asset Management API Endpoint
 * 
 * Admin-only endpoint for managing user crypto asset balances
 * Used alongside the user edit page to deposit/withdraw from user accounts
 * 
 * POST Parameters:
 * - action: 'deposit' or 'withdraw'
 * - user_id: target user ID
 * - acct_id: target user account ID
 * - crypto: asset type (btc, eth, bnb, trx, sol, xrp, avax, erc, trc)
 * - amount: transaction amount
 * - description: (optional) reason for adjustment
 * 
 * Returns JSON response
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// Check if admin is logged in
if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'admin') {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized - Admin access required']);
    exit;
}

require_once(__DIR__ . '/../api/crypto_assets.php');

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = sanitize_input($_POST['action'] ?? '');
    $user_id = (int)($_POST['user_id'] ?? 0);
    $acct_id = sanitize_input($_POST['acct_id'] ?? '');
    $crypto = sanitize_input($_POST['crypto'] ?? '');
    $amount = (float)($_POST['amount'] ?? 0);
    $description = sanitize_input($_POST['description'] ?? 'Admin adjustment');
    
    $admin_id = $_SESSION['id'];
    
    // Validate required fields
    if (empty($action) || $user_id <= 0 || empty($acct_id) || empty($crypto) || $amount <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing or invalid parameters']);
        exit;
    }
    
    // Validate action
    if (!in_array($action, ['deposit', 'withdraw'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid action. Use deposit or withdraw']);
        exit;
    }
    
    // Execute transaction with admin ID
    if ($action === 'deposit') {
        $result = deposit_crypto_asset($conn, $user_id, $acct_id, $crypto, $amount, $admin_id, $description);
    } else {
        $result = withdraw_crypto_asset($conn, $user_id, $acct_id, $crypto, $amount, $admin_id, $description);
    }
    
    // Return result
    echo json_encode($result);
    exit;
}

// Invalid request method
http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed']);
?>
