<?php
/**
 * PROCESS_DEPOSIT.PHP - Handle deposit submissions
 * 
 * Receives deposit form data via POST, validates, and inserts into transaction table
 * Uses traditional form submission (no AJAX) for cPanel compatibility
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Check if user is logged in
if (!isset($_SESSION)) {
    session_start();
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

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
$crypto_amount = floatval($_POST['crypto_amount'] ?? 0);  // Converted crypto amount from frontend
$wallet_address = $_POST['wallet_address'] ?? 'N/A'; // Not required for traditional form
$payment_receipt = $_FILES['payment_receipt'] ?? null;

// Use crypto amount if available, fallback to deposit_amount
$final_amount = ($crypto_amount > 0) ? $crypto_amount : $deposit_amount;

// Validate inputs
if (empty($deposit_method) || $final_amount <= 0) {
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
    // Create uploads directory if needed (project root uploads/proofs)
    $uploads_dir = dirname(__DIR__, 2) . '/uploads/proofs/';
    if (!is_dir($uploads_dir)) {
        @mkdir($uploads_dir, 0755, true);
    }

    // Generate unique filename
    $filename = time() . '_' . bin2hex(random_bytes(4)) . '.' . $file_extension;
    $file_path = $uploads_dir . $filename;

    // Ensure this is a valid uploaded file
    if (!is_uploaded_file($payment_receipt['tmp_name'])) {
        $_SESSION['deposit_error'] = 'Invalid uploaded file';
        header('Location: ../deposit.php');
        exit;
    }

    // Move uploaded file
    if (!move_uploaded_file($payment_receipt['tmp_name'], $file_path)) {
        $_SESSION['deposit_error'] = 'Failed to upload receipt file';
        header('Location: ../deposit.php');
        exit;
    }

    // Verify file exists and is readable, set secure permissions
    if (!file_exists($file_path) || !is_readable($file_path)) {
        @unlink($file_path);
        $_SESSION['deposit_error'] = 'Uploaded file not accessible after upload';
        header('Location: ../deposit.php');
        exit;
    }

    // Attempt to set file permissions to 0644 (owner read/write, group/other read)
    @chmod($file_path, 0644);

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
        "sssssdsssiiss",
        $trx_id,
        $user_id,
        $asset_name,
        $type,
        $status,
        $final_amount,
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

