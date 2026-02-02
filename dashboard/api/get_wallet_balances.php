<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);

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

$user_id = $_SESSION['user_id'];

// Fetch user's crypto balances from database
$stmt = $conn->prepare(
    "SELECT btc_balance, eth_balance, bnb_balance, trx_balance, sol_balance, xrp_balance, avax_balance, erc_balance, trc_balance
     FROM user WHERE acct_id = ?"
);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error'
    ]);
    exit;
}

$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => 'User not found'
    ]);
    exit;
}

// Format balances with appropriate decimal places
$balances = [
    'btc' => number_format(floatval($user['btc_balance'] ?? 0), 5, '.', ''),
    'eth' => number_format(floatval($user['eth_balance'] ?? 0), 5, '.', ''),
    'bnb' => number_format(floatval($user['bnb_balance'] ?? 0), 5, '.', ''),
    'trx' => number_format(floatval($user['trx_balance'] ?? 0), 5, '.', ''),
    'sol' => number_format(floatval($user['sol_balance'] ?? 0), 5, '.', ''),
    'xrp' => number_format(floatval($user['xrp_balance'] ?? 0), 5, '.', ''),
    'avax' => number_format(floatval($user['avax_balance'] ?? 0), 5, '.', ''),
    'erc' => number_format(floatval($user['erc_balance'] ?? 0), 5, '.', ''),
    'trc' => number_format(floatval($user['trc_balance'] ?? 0), 5, '.', '')
];

echo json_encode([
    'status' => 'success',
    'balances' => $balances
]);
?>
