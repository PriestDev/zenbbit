<?php
/**
 * Crypto Asset Transaction API Endpoint
 * 
 * Handles deposit/withdrawal operations for crypto assets
 * Uses the same session-based system as the main balance operations
 * 
 * POST Parameters:
 * - action: 'deposit' or 'withdraw'
 * - crypto: asset type (btc, eth, bnb, trx, sol, xrp, avax, erc, trc)
 * - amount: transaction amount
 * - description: (optional) transaction description
 * 
 * Returns JSON response
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

require_once(__DIR__ . '/crypto_assets.php');
require_once(__DIR__ . '/../includes/header.php');

// Check if user is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['acct_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['id'];
$acct_id = $_SESSION['acct_id'];

// Handle GET requests - retrieve balances and transaction history
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = sanitize_input($_GET['action'] ?? 'balances');
    
    if ($action === 'balances') {
        $balances = get_all_asset_balances($conn, $acct_id);
        echo json_encode(['success' => true, 'data' => $balances]);
        exit;
    }
    
    if ($action === 'transactions') {
        $crypto = sanitize_input($_GET['crypto'] ?? null);
        $transactions = get_asset_transactions($conn, $acct_id, $crypto, 100);
        echo json_encode(['success' => true, 'data' => $transactions]);
        exit;
    }
    
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}

// Handle POST requests - deposit/withdraw
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = sanitize_input($_POST['action'] ?? '');
    $crypto = sanitize_input($_POST['crypto'] ?? '');
    $amount = (float)($_POST['amount'] ?? 0);
    $description = sanitize_input($_POST['description'] ?? 'User transaction');
    
    // Validate required fields
    if (empty($action) || empty($crypto) || $amount <= 0) {
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
    
    // Execute transaction
    if ($action === 'deposit') {
        $result = deposit_crypto_asset($conn, $user_id, $acct_id, $crypto, $amount, null, $description);
    } else {
        $result = withdraw_crypto_asset($conn, $user_id, $acct_id, $crypto, $amount, null, $description);
    }
    
    // Return result
    echo json_encode($result);
    exit;
}

// Invalid request method
http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed']);
?>
