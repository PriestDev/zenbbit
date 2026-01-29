<?php
/**
 * PROCESS_DEPOSIT.PHP - Handle deposit submissions
 * 
 * Receives deposit form data, validates, and inserts into transaction table
 * Returns JSON response for AJAX requests
 */

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized. Please login first.'
    ]);
    exit;
}

// Include database connection
include '../includes/dashboard_init.php';

// Get POST data
$deposit_method = $_POST['deposit_method'] ?? '';
$deposit_amount = floatval($_POST['deposit_amount'] ?? 0);
$wallet_address = $_POST['wallet_address'] ?? '';
$payment_receipt = $_FILES['payment_receipt'] ?? null;

// Validate inputs
if (empty($deposit_method) || $deposit_amount <= 0 || empty($wallet_address)) {
    echo json_encode([
        'success' => false,
        'message' => 'All fields are required and amount must be greater than 0'
    ]);
    exit;
}

// Validate payment receipt
if (!$payment_receipt || $payment_receipt['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        'success' => false,
        'message' => 'Please upload a valid payment receipt'
    ]);
    exit;
}

// Check file size (5MB max)
$max_file_size = 5 * 1024 * 1024;
if ($payment_receipt['size'] > $max_file_size) {
    echo json_encode([
        'success' => false,
        'message' => 'File size exceeds 5MB limit'
    ]);
    exit;
}

// Validate file type
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
$file_info = pathinfo($payment_receipt['name']);
$file_extension = strtolower($file_info['extension'] ?? '');

if (!in_array($file_extension, $allowed_extensions)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid file type. Allowed: JPG, PNG, GIF, PDF'
    ]);
    exit;
}

try {
    // Create uploads directory if needed
    $uploads_dir = '../uploads/proofs/';
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0755, true);
    }

    // Generate unique filename
    $filename = time() . '_' . bin2hex(random_bytes(4)) . '.' . $file_extension;
    $file_path = $uploads_dir . $filename;

    // Move uploaded file
    if (!move_uploaded_file($payment_receipt['tmp_name'], $file_path)) {
        throw new Exception('Failed to upload receipt file');
    }

    // Map deposit methods to transaction table format
    $method_map = [
        'btc' => 'Bitcoin',
        'eth' => 'Ethereum',
        'usdt_trc' => 'USDT-TRC20',
        'usdt_erc' => 'USDT-ERC20'
    ];

    $asset_name = $method_map[$deposit_method] ?? $deposit_method;
    $user_id = $_SESSION['user_id'];

    // Get user data
    $stmt = $conn->prepare("SELECT email, name FROM user WHERE acct_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        throw new Exception('User not found');
    }

    // Generate transaction ID
    $trx_id = 'DEP-' . uniqid();
    $currentDate = date('Y-m-d H:i:s');
    $serial = 0; // 0 = pending, 1 = approved, 2 = declined
    $gate_way = 1; // 1 = Balance source

    // Insert into transaction table
    $insertStmt = $conn->prepare(
        "INSERT INTO transaction (trx_id, user_id, name, type, status, amt, asset, details, proof, wallet_address, serial, gate_way, email, create_date) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$insertStmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $type = 'deposit';
    $status = 'deposit';
    $asset = strtolower($deposit_method);
    $details = 'Payment receipt uploaded';

    $insertStmt->bind_param(
        "sssssdsssisss",
        $trx_id,
        $user_id,
        $asset_name,
        $type,
        $status,
        $deposit_amount,
        $asset,
        $details,
        $filename,
        $wallet_address,
        $serial,
        $gate_way,
        $user['email'],
        $currentDate
    );

    if (!$insertStmt->execute()) {
        throw new Exception("Failed to insert deposit: " . $insertStmt->error);
    }

    $insertStmt->close();

    echo json_encode([
        'success' => true,
        'message' => 'Deposit submitted successfully. Your transaction is pending verification.',
        'transactionId' => $trx_id,
        'timestamp' => time()
    ]);

} catch (Exception $e) {
    // Clean up uploaded file if insertion failed
    if (isset($file_path) && file_exists($file_path)) {
        unlink($file_path);
    }

    error_log("Deposit Error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Error processing deposit: ' . $e->getMessage()
    ]);
}

exit;
?>
