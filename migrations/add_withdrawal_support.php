<?php
/**
 * Migration: Add withdrawal support to transaction table
 * 
 * This migration adds the following columns to the transaction table:
 * - asset: the type of cryptocurrency/asset being withdrawn
 * - wallet_address: the recipient wallet address for the withdrawal
 * - type: withdrawal, deposit, etc.
 */

include '../database/db_config.php';

// Check if columns already exist
$result = $conn->query("SHOW COLUMNS FROM `transaction`");
$columns = [];
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}

$changes = [];

// Add 'asset' column if it doesn't exist
if (!in_array('asset', $columns)) {
    $sql = "ALTER TABLE `transaction` ADD COLUMN `asset` VARCHAR(50) NULL AFTER `amt`";
    if ($conn->query($sql)) {
        $changes[] = "✓ Added 'asset' column";
    } else {
        $changes[] = "✗ Failed to add 'asset' column: " . $conn->error;
    }
}

// Add 'wallet_address' column if it doesn't exist
if (!in_array('wallet_address', $columns)) {
    $sql = "ALTER TABLE `transaction` ADD COLUMN `wallet_address` VARCHAR(255) NULL AFTER `asset`";
    if ($conn->query($sql)) {
        $changes[] = "✓ Added 'wallet_address' column";
    } else {
        $changes[] = "✗ Failed to add 'wallet_address' column: " . $conn->error;
    }
}

// Add 'type' column if it doesn't exist
if (!in_array('type', $columns)) {
    $sql = "ALTER TABLE `transaction` ADD COLUMN `type` VARCHAR(50) DEFAULT 'transaction' AFTER `status`";
    if ($conn->query($sql)) {
        $changes[] = "✓ Added 'type' column";
    } else {
        $changes[] = "✗ Failed to add 'type' column: " . $conn->error;
    }
}

// If no changes were needed
if (empty($changes)) {
    $changes[] = "✓ Migration complete - all required columns already exist";
}

$conn->close();

// Output results
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Database migration completed',
    'changes' => $changes
]);

?>
