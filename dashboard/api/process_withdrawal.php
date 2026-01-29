<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized. Please login first.'
    ]);
    exit;
}

// Include database connection
include '../includes/dashboard_init.php';

// Define admin email constant if not already defined
if (!defined('ADMIN_EMAIL')) {
    define('ADMIN_EMAIL', 'admin@zenbbit.com');
}

// Get request data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request data'
    ]);
    exit;
}

$asset = $input['asset'] ?? '';
$amount = floatval($input['amount'] ?? 0);
$address = $input['address'] ?? '';

// Validate inputs
if (empty($asset) || $amount <= 0 || empty($address)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'All fields are required and amount must be greater than 0'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Map asset codes to database columns
$assetMap = [
    'btc' => 'btc_balance',
    'eth' => 'eth_balance',
    'bnb' => 'bnb_balance',
    'trx' => 'trx_balance',
    'sol' => 'sol_balance',
    'xrp' => 'xrp_balance',
    'avax' => 'avax_balance',
    'usdt-erc20' => 'erc_balance',
    'usdt-trc20' => 'trc_balance'
];

// Validate asset
if (!isset($assetMap[$asset])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid asset selected'
    ]);
    exit;
}

$balanceColumn = $assetMap[$asset];

// Asset info for email
$assetInfo = [
    'btc' => ['name' => 'Bitcoin', 'symbol' => 'BTC'],
    'eth' => ['name' => 'Ethereum', 'symbol' => 'ETH'],
    'bnb' => ['name' => 'Binance Coin', 'symbol' => 'BNB'],
    'trx' => ['name' => 'TRON', 'symbol' => 'TRX'],
    'sol' => ['name' => 'Solana', 'symbol' => 'SOL'],
    'xrp' => ['name' => 'Ripple', 'symbol' => 'XRP'],
    'avax' => ['name' => 'Avalanche', 'symbol' => 'AVAX'],
    'usdt-erc20' => ['name' => 'USDT (ERC20)', 'symbol' => 'USDT-ERC20'],
    'usdt-trc20' => ['name' => 'USDT (TRC20)', 'symbol' => 'USDT-TRC20']
];

$selectedAsset = $assetInfo[$asset];

// Get user data and balance
$stmt = $conn->prepare("SELECT * FROM user WHERE acct_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User not found'
    ]);
    exit;
}

// Check balance
$currentBalance = floatval($user[$balanceColumn] ?? 0);
if ($currentBalance < $amount) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Insufficient balance. Your balance: ' . number_format($currentBalance, 8) . ' ' . $selectedAsset['symbol']
    ]);
    exit;
}

// Begin transaction
$conn->begin_transaction();

try {
    // Deduct amount from user balance
    $newBalance = $currentBalance - $amount;
    $updateStmt = $conn->prepare("UPDATE user SET $balanceColumn = ? WHERE acct_id = ?");
    $updateStmt->bind_param("ds", $newBalance, $user_id);
    
    if (!$updateStmt->execute()) {
        throw new Exception("Failed to update user balance: " . $updateStmt->error);
    }
    $updateStmt->close();
    
    // Insert withdrawal record into transaction table
    $trx_id = 'WTH-' . uniqid();
    $withdrawalType = 'withdraw';
    $withdrawalStatus = 'pending';
    $serial = 0; // 0 = pending, 1 = approved, 2 = declined
    $gate_way = 1; // 1 = Balance, 2 = Profit, 3 = Referral
    $currentDate = date('Y-m-d H:i:s');
    
    $insertStmt = $conn->prepare(
        "INSERT INTO transaction (trx_id, user_id, name, type, status, amt, asset, wallet_address, serial, gate_way, email, create_date) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    
    if (!$insertStmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $assetSymbol = $selectedAsset['symbol'];
    $insertStmt->bind_param(
        "sssssdssiiss",
        $trx_id,
        $user_id,
        $assetSymbol,
        $withdrawalType,
        $withdrawalStatus,
        $amount,
        $asset,
        $address,
        $serial,
        $gate_way,
        $user['email'],
        $currentDate
    );
    
    if (!$insertStmt->execute()) {
        throw new Exception("Failed to insert transaction record: " . $insertStmt->error);
    }
    
    $transactionId = $insertStmt->insert_id;
    $insertStmt->close();
    
    // Commit transaction
    $conn->commit();
    
    // Send email notifications
    $userEmail = $user['email'] ?? '';
    $userName = $user['name'] ?? 'User';
    
    // Get admin email from configuration
    $adminEmail = ADMIN_EMAIL;
    
    if (!empty($userEmail)) {
        sendWithdrawalEmails($userEmail, $userName, $adminEmail, $amount, $selectedAsset['symbol'], $address, $transactionId);
    }
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Withdrawal request submitted successfully. You will receive confirmation via email.',
        'transactionId' => $transactionId,
        'newBalance' => $newBalance
    ]);
    
} catch (Exception $e) {
    $conn->rollback();
    error_log("Withdrawal Error: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to process withdrawal: ' . $e->getMessage()
    ]);
}

// Function to send emails
function sendWithdrawalEmails($userEmail, $userName, $adminEmail, $amount, $symbol, $address, $transactionId) {
    // User email
    $userSubject = "Withdrawal Request Confirmation - Zenbbit";
    $userBody = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; background: #f9f9f9; border-radius: 8px; }
            .header { background: #622faa; color: #fff; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
            .content { background: #fff; padding: 20px; border-radius: 0 0 8px 8px; }
            .details { background: #f5f5f5; padding: 15px; border-radius: 6px; margin: 20px 0; }
            .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #ddd; }
            .detail-row:last-child { border-bottom: none; }
            .label { font-weight: bold; color: #622faa; }
            .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center; font-size: 12px; color: #999; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Withdrawal Request Confirmation</h2>
            </div>
            <div class='content'>
                <p>Hello <strong>$userName</strong>,</p>
                
                <p>Your withdrawal request has been received and is being processed. Below are the details of your withdrawal:</p>
                
                <div class='details'>
                    <div class='detail-row'>
                        <span class='label'>Amount:</span>
                        <span>$amount $symbol</span>
                    </div>
                    <div class='detail-row'>
                        <span class='label'>Recipient Address:</span>
                        <span>$address</span>
                    </div>
                    <div class='detail-row'>
                        <span class='label'>Transaction ID:</span>
                        <span>#$transactionId</span>
                    </div>
                    <div class='detail-row'>
                        <span class='label'>Status:</span>
                        <span style='color: #ff9800;'>Pending</span>
                    </div>
                    <div class='detail-row'>
                        <span class='label'>Date:</span>
                        <span>" . date('F d, Y H:i:s') . "</span>
                    </div>
                </div>
                
                <p><strong>What happens next?</strong></p>
                <ul>
                    <li>Our team will review your withdrawal request</li>
                    <li>You will receive an email confirmation once processed</li>
                    <li>Typically, withdrawals are processed within 24-48 hours</li>
                </ul>
                
                <p>If you have any questions, please contact our support team.</p>
                
                <div class='footer'>
                    <p>&copy; 2024 Zenbbit. All rights reserved.</p>
                    <p>This is an automated message. Please do not reply to this email.</p>
                </div>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Admin notification email
    $adminSubject = "New Withdrawal Request - Zenbbit Admin";
    $adminBody = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; background: #f9f9f9; border-radius: 8px; }
            .header { background: #622faa; color: #fff; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
            .content { background: #fff; padding: 20px; border-radius: 0 0 8px 8px; }
            .details { background: #f5f5f5; padding: 15px; border-radius: 6px; margin: 20px 0; }
            .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #ddd; }
            .detail-row:last-child { border-bottom: none; }
            .label { font-weight: bold; color: #622faa; }
            .alert { background: #fff3cd; border: 1px solid #ffc107; padding: 12px; border-radius: 6px; margin: 15px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New Withdrawal Request</h2>
            </div>
            <div class='content'>
                <div class='alert'>
                    <strong>New withdrawal request received - Action Required</strong>
                </div>
                
                <p>A new withdrawal request has been submitted by a user. Please review and process:</p>
                
                <div class='details'>
                    <div class='detail-row'>
                        <span class='label'>User Name:</span>
                        <span>$userName</span>
                    </div>
                    <div class='detail-row'>
                        <span class='label'>User Email:</span>
                        <span>$userEmail</span>
                    </div>
                    <div class='detail-row'>
                        <span class='label'>Amount:</span>
                        <span>$amount $symbol</span>
                    </div>
                    <div class='detail-row'>
                        <span class='label'>Recipient Address:</span>
                        <span>$address</span>
                    </div>
                    <div class='detail-row'>
                        <span class='label'>Transaction ID:</span>
                        <span>#$transactionId</span>
                    </div>
                    <div class='detail-row'>
                        <span class='label'>Submitted Date:</span>
                        <span>" . date('F d, Y H:i:s') . "</span>
                    </div>
                </div>
                
                <p>Please log in to the admin panel to review and process this withdrawal request.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Send emails
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: noreply@zenbbit.com\r\n";
    
    // Send to user
    mail($userEmail, $userSubject, $userBody, $headers);
    
    // Send to admin
    if (!empty($adminEmail)) {
        mail($adminEmail, $adminSubject, $adminBody, $headers);
    }
}

?>
