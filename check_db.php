<?php
// Quick database check script
require_once 'database/db_config.php';

// Get user ID from session if available, otherwise use a test query
session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    // Just show all users and their balances
    $query = "SELECT acct_id, first_name, last_name, btc_balance, eth_balance, bnb_balance, trx_balance, sol_balance, xrp_balance, avax_balance, erc_balance, trc_balance FROM user LIMIT 5";
} else {
    $query = "SELECT acct_id, first_name, last_name, btc_balance, eth_balance, bnb_balance, trx_balance, sol_balance, xrp_balance, avax_balance, erc_balance, trc_balance FROM user WHERE acct_id = ?";
}

$stmt = $conn->prepare($query);

if ($user_id) {
    $stmt->bind_param("s", $user_id);
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    echo "<h2>Database Asset Balances</h2>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Account ID</th><th>Name</th><th>BTC</th><th>ETH</th><th>BNB</th><th>TRX</th><th>SOL</th><th>XRP</th><th>AVAX</th><th>ERC</th><th>TRC</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['acct_id']) . "</td>";
        $first = isset($row['first_name']) ? $row['first_name'] : (isset($row['fname']) ? $row['fname'] : '');
        $last = isset($row['last_name']) ? $row['last_name'] : (isset($row['lname']) ? $row['lname'] : '');
        echo "<td>" . htmlspecialchars(trim($first . ' ' . $last)) . "</td>";
        echo "<td>" . number_format($row['btc_balance'], 8) . "</td>";
        echo "<td>" . number_format($row['eth_balance'], 8) . "</td>";
        echo "<td>" . number_format($row['bnb_balance'], 8) . "</td>";
        echo "<td>" . number_format($row['trx_balance'], 8) . "</td>";
        echo "<td>" . number_format($row['sol_balance'], 8) . "</td>";
        echo "<td>" . number_format($row['xrp_balance'], 8) . "</td>";
        echo "<td>" . number_format($row['avax_balance'], 8) . "</td>";
        echo "<td>" . number_format($row['erc_balance'], 8) . "</td>";
        echo "<td>" . number_format($row['trc_balance'], 8) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "Query error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
