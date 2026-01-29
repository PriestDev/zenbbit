<?php
/**
 * FETCH_NOTIFICATIONS.PHP - User Notifications API
 * Fetches account updates, transaction updates, and trading plan updates
 * for the authenticated user
 */

header('Content-Type: application/json');
date_default_timezone_set("Europe/London");

// Initialize session
session_start();

// Check authentication
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'count' => 0,
        'notifications' => [],
        'message' => 'User not authenticated. Please login first.'
    ]);
    exit;
}

// Connect to database
try {
    include '../database/db_config.php';
    
    if (!$conn) {
        throw new Exception('Database connection failed');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'count' => 0,
        'notifications' => [],
        'message' => 'Database connection error: ' . $e->getMessage()
    ]);
    exit;
}

$userId = $_SESSION['user_id'];
$notifications = [];

// Use output buffering to prevent any stray output before JSON
ob_start();

try {
    // Escape user ID for safety
    $userId_esc = mysqli_real_escape_string($conn, $userId);
    
    // ========================================
    // 1. RECENT TRANSACTION UPDATES
    // ========================================
    $transactionQuery = "
        SELECT 
            trx_id,
            name,
            amt,
            status,
            serial,
            create_date,
            'transaction' as type
        FROM transaction
        WHERE user_id = '$userId_esc'
        ORDER BY create_date DESC
    ";
    
    $transactionResult = @mysqli_query($conn, $transactionQuery);
    
    if (!$transactionResult) {
        // Table may not exist, log error but continue
        error_log('Transaction query failed: ' . mysqli_error($conn));
    } elseif (mysqli_num_rows($transactionResult) > 0) {
        while ($row = mysqli_fetch_assoc($transactionResult)) {
            $txn_status = strtolower($row['status']); // deposit, withdraw, etc
            $serial = (int)$row['serial']; // 0 = pending, 1 = approved, 2 = declined
            
            // Determine status label based on serial
            $statusLabel = 'Pending';
            $statusColor = '#ffa500';
            if ($serial === 1) {
                $statusLabel = 'Approved';
                $statusColor = '#4caf50';
            } elseif ($serial === 2) {
                $statusLabel = 'Declined';
                $statusColor = '#f44336';
            }
            
            $amount = number_format($row['amt'], 2);
            
            // Create user-friendly message based on transaction type
            $icon = '';
            $title = '';
            $message = '';
            
            if ($txn_status === 'deposit') {
                $icon = '💰';
                $title = 'Deposit Received';
                $message = "Deposit of \${$amount} ({$row['name']}) - <span style='color: {$statusColor};'>{$statusLabel}</span>";
            } elseif ($txn_status === 'withdraw') {
                $icon = '🏦';
                $title = 'Withdrawal Request';
                $message = "Withdrawal of \${$amount} ({$row['name']}) - <span style='color: {$statusColor};'>{$statusLabel}</span>";
            } elseif ($txn_status === 'transfer') {
                $icon = '🔄';
                $title = 'Transfer Processed';
                $message = "Transfer of \${$amount} - <span style='color: {$statusColor};'>{$statusLabel}</span>";
            } else {
                $icon = '📊';
                $title = ucfirst($txn_status) . ' Update';
                $message = "{$row['name']}: \${$amount} - <span style='color: {$statusColor};'>{$statusLabel}</span>";
            }
            
            $notifications[] = [
                'id' => 'trx_' . $row['trx_id'],
                'type' => 'transaction',
                'icon' => $icon,
                'title' => $title,
                'message' => $message,
                'time' => date('c', strtotime($row['create_date'])), // ISO 8601 format for JS
                'timestamp' => strtotime($row['create_date']),
                'status' => $statusLabel
            ];
        }
    }
    
    // ========================================
    // 2. ACCOUNT UPDATE NOTIFICATIONS
    // ========================================
    $accountQuery = "
        SELECT 
            acct_id,
            first_name,
            last_name,
            wallet_stat,
            `update` as create_date
        FROM user
        WHERE acct_id = '$userId_esc'
        LIMIT 1
    ";
    
    $accountResult = mysqli_query($conn, $accountQuery);
    
    if ($accountResult && mysqli_num_rows($accountResult) > 0) {
        $account = mysqli_fetch_assoc($accountResult);
        
        // Wallet status notification
        if ($account['wallet_stat'] == 2) {
            $notifications[] = [
                'id' => 'wallet_pending',
                'type' => 'account',
                'icon' => '⏳',
                'title' => 'Wallet Verification',
                'message' => 'Your wallet connection is pending admin verification',
                'time' => date('c'),
                'timestamp' => time(),
                'status' => 'pending'
            ];
        } elseif ($account['wallet_stat'] == 1) {
            $notifications[] = [
                'id' => 'wallet_connected',
                'type' => 'account',
                'icon' => '✅',
                'title' => 'Wallet Connected',
                'message' => 'Your wallet has been successfully verified and connected',
                'time' => date('c'),
                'timestamp' => time(),
                'status' => 'completed'
            ];
        }
        
        // KYC status notification
        if ($account['card_stat'] == 2) {
            $notifications[] = [
                'id' => 'kyc_pending',
                'type' => 'account',
                'icon' => '📋',
                'title' => 'KYC Verification',
                'message' => 'Your KYC verification is pending admin review',
                'time' => date('c'),
                'timestamp' => time(),
                'status' => 'pending'
            ];
        } elseif ($account['card_stat'] == 1) {
            $notifications[] = [
                'id' => 'kyc_verified',
                'type' => 'account',
                'icon' => '✅',
                'title' => 'KYC Verified',
                'message' => 'Your identity has been successfully verified',
                'time' => date('c'),
                'timestamp' => time(),
                'status' => 'completed'
            ];
        }
    }
    
    // ========================================
    // 3. TRADING PLAN & TRADE UPDATES
    // ========================================
    $tradeQuery = "
        SELECT 
            id,
            trx_id,
            amount,
            pair,
            profit,
            status,
            end_date,
            create_date
        FROM trade
        WHERE user = '$userId_esc'
        ORDER BY create_date DESC
        LIMIT 5
    ";
    
    $tradeResult = mysqli_query($conn, $tradeQuery);
    
    if ($tradeResult && mysqli_num_rows($tradeResult) > 0) {
        while ($row = mysqli_fetch_assoc($tradeResult)) {
            $amount = number_format($row['amount'], 2);
            $profit = number_format($row['profit'], 2);
            $pair = $row['pair'];
            
            $status = (int)$row['status'];
            $statusText = $status == 1 ? 'Active' : 'Completed';
            $statusColor = $status == 1 ? '#4caf50' : '#2196f3';
            
            // Check if trade has ended
            $endDate = strtotime($row['end_date']);
            $now = time();
            $isEnded = $now > $endDate;
            
            if ($isEnded && $status == 1) {
                $statusText = 'Completed';
                $statusColor = '#2196f3';
            }
            
            $notifications[] = [
                'id' => 'trade_' . $row['trx_id'],
                'type' => 'trading',
                'icon' => '📈',
                'title' => 'Trading Plan: ' . $pair,
                'message' => "Amount: \${$amount} | Profit: \${$profit} | Status: <span style='color: {$statusColor};'>{$statusText}</span>",
                'time' => date('c', strtotime($row['create_date'])), // ISO 8601 format for JS
                'timestamp' => strtotime($row['create_date']),
                'status' => strtolower($statusText),
                'endDate' => $row['end_date']
            ];
        }
    }
    
    // ========================================
    // 4. SORT NOTIFICATIONS BY TIMESTAMP (NEWEST FIRST)
    // ========================================
    usort($notifications, function($a, $b) {
        return $b['timestamp'] - $a['timestamp'];
    });
    
    // Return all collected notifications (already ordered by timestamp)
    // Note: large result sets may affect payload size; consider server-side limits or pagination if needed.
    
    // ========================================
    // 5. RETURN RESPONSE
    // ========================================
    $response = [
        'success' => true,
        'count' => count($notifications),
        'notifications' => $notifications
    ];
    
    ob_end_clean();
    echo json_encode($response);
    
} catch (Exception $e) {
    ob_end_clean();
    echo json_encode([
        'success' => false,
        'count' => 0,
        'notifications' => [],
        'message' => 'Error fetching notifications: ' . $e->getMessage()
    ]);
}

// Close database connection
if (isset($conn)) {
    $conn->close();
}
?>
