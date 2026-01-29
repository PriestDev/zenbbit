<?php
/**
 * PROCESS_DEPOSIT.PHP - Handle deposit submissions
 * 
 * Receives deposit form data via POST, validates, and inserts into transaction table
 * Uses traditional form submission (no AJAX) for cPanel compatibility
 */

// Check if user is logged in
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    $_SESSION['deposit_error'] = 'Unauthorized. Please login first.';
    header('Location: ../deposit.php');
    exit;
}

// Include database connection
require_once '../includes/dashboard_init.php';

// Get POST data
$deposit_method = $_POST['deposit_method'] ?? '';
$deposit_amount = floatval($_POST['deposit_amount'] ?? 0);
$wallet_address = $_POST['wallet_address'] ?? 'N/A'; // Not required for traditional form
$payment_receipt = $_FILES['payment_receipt'] ?? null;

// Validate inputs
if (empty($deposit_method) || $deposit_amount <= 0) {
    $_SESSION['deposit_error'] = 'All fields are required and amount must be greater than 0';
    header('Location: ../deposit.php');
    exit;
}

// Validate payment receipt
if (!$payment_receipt || $payment_receipt['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['deposit_error'] = 'Please upload a valid payment receipt';
    header('Location: ../deposit.php');
    exit;
}

// Check file size (5MB max)
$max_file_size = 5 * 1024 * 1024;
if ($payment_receipt['size'] > $max_file_size) {
    $_SESSION['deposit_error'] = 'File size exceeds 5MB limit';
    header('Location: ../deposit.php');
    exit;
}

// Validate file type
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
$file_info = pathinfo($payment_receipt['name']);
$file_extension = strtolower($file_info['extension'] ?? '');

if (!in_array($file_extension, $allowed_extensions)) {
    $_SESSION['deposit_error'] = 'Invalid file type. Allowed: JPG, PNG, GIF, PDF';
    header('Location: ../deposit.php');
    exit;
}

try {
    // Create uploads directory if needed
    $uploads_dir = dirname(__DIR__) . '/uploads/proofs/';
    if (!is_dir($uploads_dir)) {
        @mkdir($uploads_dir, 0755, true);
    }

    // Generate unique filename
    $filename = time() . '_' . bin2hex(random_bytes(4)) . '.' . $file_extension;
    $file_path = $uploads_dir . $filename;

    // Move uploaded file
    if (!move_uploaded_file($payment_receipt['tmp_name'], $file_path)) {
        $_SESSION['deposit_error'] = 'Failed to upload receipt file';
        header('Location: ../deposit.php');
        exit;
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
    $stmt = $conn->prepare("SELECT email FROM user WHERE acct_id = ?");
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    
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
    $type = 'deposit';
    $status = 'deposit';
    $asset = strtolower($deposit_method);
    $details = 'Payment receipt uploaded';

    // Insert into transaction table
    $insertStmt = $conn->prepare(
        "INSERT INTO transaction (trx_id, user_id, name, type, status, amt, asset, details, proof, serial, gate_way, email, create_date) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$insertStmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $insertStmt->bind_param(
        "sssssdsssi ss",
        $trx_id,
        $user_id,
        $asset_name,
        $type,
        $status,
        $deposit_amount,
        $asset,
        $details,
        $filename,
        $serial,
        $gate_way,
        $user['email'],
        $currentDate
    );

    if (!$insertStmt->execute()) {
        throw new Exception("Failed to insert deposit: " . $insertStmt->error);
    }

    $insertStmt->close();

    // Success - redirect with message
    $_SESSION['deposit_success'] = 'Deposit submitted successfully! Your transaction is pending verification. You will receive confirmation via email.';
    header('Location: ../deposit.php');
    exit;

} catch (Exception $e) {
    // Clean up uploaded file if insertion failed
    if (isset($file_path) && file_exists($file_path)) {
        @unlink($file_path);
    }

    error_log("Deposit Error: " . $e->getMessage());
    
    $_SESSION['deposit_error'] = 'Error processing deposit: ' . $e->getMessage();
    header('Location: ../deposit.php');
    exit;
}
?>

