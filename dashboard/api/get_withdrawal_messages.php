<?php
header('Content-Type: application/json');

require_once(__DIR__ . '/../../database/db_config.php');

$sql = "SELECT eth_message, tron_message, eth_gas, tron_gas FROM page_content LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode([
        'status' => 'success',
        'eth_message' => $row['eth_message'] ?? 'Your Ethereum withdrawal has been queued for processing.',
        'tron_message' => $row['tron_message'] ?? 'Your TRON withdrawal has been queued for processing.',
        'erc_message' => $row['eth_message'] ?? 'Your USDT (ERC20) withdrawal has been queued for processing.',
        'trc_message' => $row['tron_message'] ?? 'Your USDT (TRC20) withdrawal has been queued for processing.',
        'eth_gas' => $row['eth_gas'] ?? 'Current Ethereum network gas fees apply',
        'tron_gas' => $row['tron_gas'] ?? 'Current TRON network gas fees apply'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unable to fetch withdrawal messages'
    ]);
}
