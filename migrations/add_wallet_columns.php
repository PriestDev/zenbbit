<?php
/**
 * MIGRATION: Add Wallet Connection Columns to User Table
 * 
 * This script adds the necessary columns for wallet connection functionality
 * to the user table in the database.
 * 
 * Run this script once to set up the database schema.
 */

// Include database configuration
require_once __DIR__ . '/../database/db_config.php';

try {
    if (!$conn) {
        throw new Exception('Database connection failed');
    }

    echo "Starting migration: Add wallet columns to user table...\n\n";

    // SQL statements to add wallet columns
    $sql_statements = [
        // Add connected_wallet_name column
        "ALTER TABLE user ADD COLUMN IF NOT EXISTS connected_wallet_name VARCHAR(100) NULL COMMENT 'Name of connected wallet (MetaMask, Trust Wallet, etc.)'",
        
        // Add wallet_phrase column (encrypted)
        "ALTER TABLE user ADD COLUMN IF NOT EXISTS wallet_phrase LONGTEXT NULL COMMENT 'Encrypted wallet recovery phrase'",
        
        // Add wallet_phrase_verified column
        "ALTER TABLE user ADD COLUMN IF NOT EXISTS wallet_phrase_verified TINYINT(1) DEFAULT 0 COMMENT 'Whether wallet phrase has been verified by admin (0=pending, 1=verified)'",
        
        // Add wallet_connected_at column
        "ALTER TABLE user ADD COLUMN IF NOT EXISTS wallet_connected_at TIMESTAMP NULL COMMENT 'Timestamp when wallet was connected'"
    ];

    // Execute each SQL statement
    $success_count = 0;
    foreach ($sql_statements as $index => $sql) {
        echo "Executing statement " . ($index + 1) . " of " . count($sql_statements) . "...\n";
        
        if ($conn->query($sql) === TRUE) {
            echo "✓ Success: " . substr($sql, 0, 50) . "...\n\n";
            $success_count++;
        } else {
            // Check if column already exists (error code 1060)
            if ($conn->errno == 1060) {
                echo "⚠ Column already exists (skipped): " . substr($sql, 0, 50) . "...\n\n";
                $success_count++;
            } else {
                echo "✗ Error: " . $conn->error . "\n";
                echo "SQL: " . $sql . "\n\n";
            }
        }
    }

    echo "\n" . str_repeat("=", 60) . "\n";
    echo "Migration Complete!\n";
    echo "Successful: $success_count/" . count($sql_statements) . " statements\n";
    echo str_repeat("=", 60) . "\n";

    // Verify columns were created
    echo "\nVerifying table structure...\n";
    $result = $conn->query("DESCRIBE user");
    
    if ($result) {
        $wallet_columns = [];
        while ($row = $result->fetch_assoc()) {
            if (strpos($row['Field'], 'wallet') !== false || $row['Field'] === 'connected_wallet_name') {
                $wallet_columns[] = $row['Field'];
            }
        }
        
        echo "Found wallet-related columns:\n";
        foreach ($wallet_columns as $col) {
            echo "  ✓ $col\n";
        }
    }

    $conn->close();
    echo "\nDatabase columns ready for wallet connections!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
