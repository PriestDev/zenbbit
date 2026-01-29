<?php
/**
 * Crypto Asset Management API
 * 
 * Handles asset balance operations: deposits, withdrawals, and transaction logging
 * Uses the same system as the main balance withdrawal mechanism
 * 
 * Functions:
 * - deposit_crypto_asset() - Add funds to user crypto balance
 * - withdraw_crypto_asset() - Deduct funds from user crypto balance
 * - get_asset_balance() - Get current balance for specific asset
 * - get_asset_transactions() - Get transaction history for asset
 */

require_once(__DIR__ . '/../../database/db_config.php');

// =====================================================================
// CRYPTO ASSET FUNCTIONS
// =====================================================================

/**
 * Get user's current balance for a specific crypto asset
 * 
 * @param mysqli $conn Database connection
 * @param string $acct_id User account ID
 * @param string $crypto_type Asset type (btc, eth, bnb, trx, sol, xrp, avax, erc, trc)
 * @return float Current balance or 0 if not found
 */
function get_asset_balance($conn, $acct_id, $crypto_type) {
    $balance_column = strtolower($crypto_type) . '_balance';
    
    $stmt = $conn->prepare("SELECT $balance_column FROM user WHERE acct_id = ?");
    if (!$stmt) {
        error_log("Error preparing statement: " . $conn->error);
        return 0;
    }
    
    $stmt->bind_param("s", $acct_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        return (float)($row[$balance_column] ?? 0);
    }
    
    $stmt->close();
    return 0;
}

/**
 * Deposit crypto assets to user balance
 * 
 * @param mysqli $conn Database connection
 * @param int $user_id User ID
 * @param string $acct_id User account ID
 * @param string $crypto_type Asset type
 * @param float $amount Amount to deposit
 * @param int|null $admin_id Admin ID making the adjustment (null if user self-transaction)
 * @param string|null $description Transaction description
 * @return array ['success' => bool, 'message' => string, 'transaction_id' => int|null]
 */
function deposit_crypto_asset($conn, $user_id, $acct_id, $crypto_type, $amount, $admin_id = null, $description = null) {
    // Validate inputs
    if ($amount <= 0) {
        return ['success' => false, 'message' => 'Amount must be greater than 0', 'transaction_id' => null];
    }
    
    if (!in_array(strtolower($crypto_type), ['btc', 'eth', 'bnb', 'trx', 'sol', 'xrp', 'avax', 'erc', 'trc'])) {
        return ['success' => false, 'message' => 'Invalid crypto type', 'transaction_id' => null];
    }
    
    $crypto_type = strtolower($crypto_type);
    $balance_column = $crypto_type . '_balance';
    
    // Get current balance
    $current_balance = get_asset_balance($conn, $acct_id, $crypto_type);
    $new_balance = $current_balance + $amount;
    
    // Update user balance
    $update_stmt = $conn->prepare("UPDATE user SET $balance_column = ? WHERE acct_id = ?");
    if (!$update_stmt) {
        error_log("Error preparing update statement: " . $conn->error);
        return ['success' => false, 'message' => 'Database error', 'transaction_id' => null];
    }
    
    $update_stmt->bind_param("ds", $new_balance, $acct_id);
    
    if (!$update_stmt->execute()) {
        error_log("Error updating balance: " . $update_stmt->error);
        $update_stmt->close();
        return ['success' => false, 'message' => 'Failed to update balance', 'transaction_id' => null];
    }
    
    $update_stmt->close();
    
    // Log transaction
    $trans_stmt = $conn->prepare(
        "INSERT INTO asset_transaction (user_id, acct_id, crypto_type, transaction_type, amount, previous_balance, new_balance, status, admin_id, description) 
         VALUES (?, ?, ?, 'deposit', ?, ?, ?, 'completed', ?, ?)"
    );
    
    if (!$trans_stmt) {
        error_log("Error preparing transaction statement: " . $conn->error);
        return ['success' => false, 'message' => 'Transaction logging error', 'transaction_id' => null];
    }
    
    $trans_stmt->bind_param("issdddis", $user_id, $acct_id, $crypto_type, $amount, $current_balance, $new_balance, $admin_id, $description);
    
    if (!$trans_stmt->execute()) {
        error_log("Error logging transaction: " . $trans_stmt->error);
        $trans_stmt->close();
        return ['success' => false, 'message' => 'Transaction logging failed', 'transaction_id' => null];
    }
    
    $transaction_id = $trans_stmt->insert_id;
    $trans_stmt->close();
    
    return [
        'success' => true,
        'message' => 'Deposit successful',
        'transaction_id' => $transaction_id,
        'new_balance' => $new_balance
    ];
}

/**
 * Withdraw crypto assets from user balance
 * 
 * @param mysqli $conn Database connection
 * @param int $user_id User ID
 * @param string $acct_id User account ID
 * @param string $crypto_type Asset type
 * @param float $amount Amount to withdraw
 * @param int|null $admin_id Admin ID making the withdrawal
 * @param string|null $description Transaction description
 * @return array ['success' => bool, 'message' => string, 'transaction_id' => int|null]
 */
function withdraw_crypto_asset($conn, $user_id, $acct_id, $crypto_type, $amount, $admin_id = null, $description = null) {
    // Validate inputs
    if ($amount <= 0) {
        return ['success' => false, 'message' => 'Amount must be greater than 0', 'transaction_id' => null];
    }
    
    if (!in_array(strtolower($crypto_type), ['btc', 'eth', 'bnb', 'trx', 'sol', 'xrp', 'avax', 'erc', 'trc'])) {
        return ['success' => false, 'message' => 'Invalid crypto type', 'transaction_id' => null];
    }
    
    $crypto_type = strtolower($crypto_type);
    $balance_column = $crypto_type . '_balance';
    
    // Get current balance
    $current_balance = get_asset_balance($conn, $acct_id, $crypto_type);
    
    // Check if sufficient balance
    if ($current_balance < $amount) {
        return [
            'success' => false,
            'message' => 'Insufficient ' . strtoupper($crypto_type) . ' balance. Available: ' . $current_balance,
            'transaction_id' => null
        ];
    }
    
    $new_balance = $current_balance - $amount;
    
    // Update user balance
    $update_stmt = $conn->prepare("UPDATE user SET $balance_column = ? WHERE acct_id = ?");
    if (!$update_stmt) {
        error_log("Error preparing update statement: " . $conn->error);
        return ['success' => false, 'message' => 'Database error', 'transaction_id' => null];
    }
    
    $update_stmt->bind_param("ds", $new_balance, $acct_id);
    
    if (!$update_stmt->execute()) {
        error_log("Error updating balance: " . $update_stmt->error);
        $update_stmt->close();
        return ['success' => false, 'message' => 'Failed to update balance', 'transaction_id' => null];
    }
    
    $update_stmt->close();
    
    // Log transaction
    $trans_stmt = $conn->prepare(
        "INSERT INTO asset_transaction (user_id, acct_id, crypto_type, transaction_type, amount, previous_balance, new_balance, status, admin_id, description) 
         VALUES (?, ?, ?, 'withdrawal', ?, ?, ?, 'completed', ?, ?)"
    );
    
    if (!$trans_stmt) {
        error_log("Error preparing transaction statement: " . $conn->error);
        return ['success' => false, 'message' => 'Transaction logging error', 'transaction_id' => null];
    }
    
    $trans_stmt->bind_param("issdddis", $user_id, $acct_id, $crypto_type, $amount, $current_balance, $new_balance, $admin_id, $description);
    
    if (!$trans_stmt->execute()) {
        error_log("Error logging transaction: " . $trans_stmt->error);
        $trans_stmt->close();
        return ['success' => false, 'message' => 'Transaction logging failed', 'transaction_id' => null];
    }
    
    $transaction_id = $trans_stmt->insert_id;
    $trans_stmt->close();
    
    return [
        'success' => true,
        'message' => 'Withdrawal successful',
        'transaction_id' => $transaction_id,
        'new_balance' => $new_balance
    ];
}

/**
 * Get transaction history for a specific asset
 * 
 * @param mysqli $conn Database connection
 * @param string $acct_id User account ID
 * @param string $crypto_type Asset type (optional)
 * @param int $limit Number of transactions to retrieve
 * @return array Array of transaction records
 */
function get_asset_transactions($conn, $acct_id, $crypto_type = null, $limit = 50) {
    $query = "SELECT * FROM asset_transaction WHERE acct_id = ?";
    $params = [$acct_id];
    $types = "s";
    
    if ($crypto_type) {
        $query .= " AND crypto_type = ?";
        $params[] = strtolower($crypto_type);
        $types .= "s";
    }
    
    $query .= " ORDER BY created_at DESC LIMIT ?";
    $params[] = $limit;
    $types .= "i";
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        error_log("Error preparing transactions statement: " . $conn->error);
        return [];
    }
    
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $transactions = [];
    
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
    
    $stmt->close();
    return $transactions;
}

/**
 * Get all asset balances for a user
 * 
 * @param mysqli $conn Database connection
 * @param string $acct_id User account ID
 * @return array Associative array of all crypto balances
 */
function get_all_asset_balances($conn, $acct_id) {
    $stmt = $conn->prepare(
        "SELECT btc_balance, eth_balance, bnb_balance, trx_balance, sol_balance, xrp_balance, avax_balance, erc_balance, trc_balance 
         FROM user WHERE acct_id = ?"
    );
    
    if (!$stmt) {
        error_log("Error preparing balances statement: " . $conn->error);
        return [];
    }
    
    $stmt->bind_param("s", $acct_id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $balances = $result->fetch_assoc();
        $stmt->close();
        
        // Convert all to floats
        return [
            'btc' => (float)($balances['btc_balance'] ?? 0),
            'eth' => (float)($balances['eth_balance'] ?? 0),
            'bnb' => (float)($balances['bnb_balance'] ?? 0),
            'trx' => (float)($balances['trx_balance'] ?? 0),
            'sol' => (float)($balances['sol_balance'] ?? 0),
            'xrp' => (float)($balances['xrp_balance'] ?? 0),
            'avax' => (float)($balances['avax_balance'] ?? 0),
            'erc' => (float)($balances['erc_balance'] ?? 0),
            'trc' => (float)($balances['trc_balance'] ?? 0)
        ];
    }
    
    $stmt->close();
    return [];
}

?>
