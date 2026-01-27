<?php
/**
 * Migration: Add Cryptocurrency Balance Columns
 * 
 * Adds balance tracking for 9 cryptocurrencies to the user table:
 * - Bitcoin (BTC)
 * - Ethereum (ETH)
 * - Binance Coin (BNB)
 * - TRON (TRX)
 * - Solana (SOL)
 * - Ripple (XRP)
 * - Avalanche (AVAX)
 * - USDT ERC-20
 * - USDT TRC-20
 * 
 * Run this migration: php migrations/add_crypto_balances.php
 */

include(__DIR__ . '/../database/db_config.php');

if ($conn === null) {
    die("❌ Database connection failed. Check your connection settings.\n");
}

$crypto_columns = [
    'btc_balance' => 'DECIMAL(20,8) DEFAULT 0',
    'eth_balance' => 'DECIMAL(20,8) DEFAULT 0',
    'bnb_balance' => 'DECIMAL(20,8) DEFAULT 0',
    'trx_balance' => 'DECIMAL(20,8) DEFAULT 0',
    'sol_balance' => 'DECIMAL(20,8) DEFAULT 0',
    'xrp_balance' => 'DECIMAL(20,8) DEFAULT 0',
    'avax_balance' => 'DECIMAL(20,8) DEFAULT 0',
    'erc_balance' => 'DECIMAL(20,8) DEFAULT 0',
    'trc_balance' => 'DECIMAL(20,8) DEFAULT 0'
];

$errors = [];
$success_count = 0;

echo "🔄 Starting migration: Adding cryptocurrency balance columns...\n\n";

foreach ($crypto_columns as $column => $type) {
    // Check if column already exists
    $checkSQL = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
                 WHERE TABLE_SCHEMA = DATABASE() 
                 AND TABLE_NAME = 'user' 
                 AND COLUMN_NAME = '$column'";
    
    $result = $conn->query($checkSQL);
    
    if ($result && $result->num_rows > 0) {
        echo "⏭️  Column '$column' already exists, skipping...\n";
        continue;
    }
    
    // Add the column
    $alterSQL = "ALTER TABLE user ADD COLUMN $column $type AFTER balance";
    
    if ($conn->query($alterSQL) === TRUE) {
        echo "✅ Added column: $column\n";
        $success_count++;
    } else {
        $error = "Error adding column $column: " . $conn->error;
        echo "❌ " . $error . "\n";
        $errors[] = $error;
    }
}

// Create asset_transaction table for tracking
echo "\n🔄 Creating asset_transaction table for transaction tracking...\n\n";

$create_transaction_table = "CREATE TABLE IF NOT EXISTS asset_transaction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    acct_id VARCHAR(255) NOT NULL,
    crypto_type VARCHAR(20) NOT NULL,
    transaction_type ENUM('deposit', 'withdrawal') NOT NULL,
    amount DECIMAL(20,8) NOT NULL,
    previous_balance DECIMAL(20,8) NOT NULL,
    new_balance DECIMAL(20,8) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    admin_id INT DEFAULT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY user_id (user_id),
    KEY acct_id (acct_id),
    KEY crypto_type (crypto_type),
    KEY transaction_type (transaction_type),
    KEY created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($create_transaction_table) === TRUE) {
    echo "✅ Created table: asset_transaction\n";
} else {
    $error = "Error creating asset_transaction table: " . $conn->error;
    echo "❌ " . $error . "\n";
    $errors[] = $error;
}

// Summary
echo "\n" . str_repeat("=", 60) . "\n";
echo "Migration Summary\n";
echo str_repeat("=", 60) . "\n";
echo "✅ Columns Added: $success_count\n";

if (!empty($errors)) {
    echo "❌ Errors: " . count($errors) . "\n";
    echo "\nError Details:\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
} else {
    echo "✅ No errors - Migration completed successfully!\n";
}

echo str_repeat("=", 60) . "\n";

$conn->close();
?>
