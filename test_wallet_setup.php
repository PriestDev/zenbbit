<?php
// Test the wallet handler setup
include 'database/db_config.php';

echo "Database Connection Test:\n";
echo "========================\n";

if ($conn && !$conn->connect_error) {
    echo "✓ Database connected successfully\n";
    echo "  Host: localhost\n";
    echo "  Database: zenbbit\n";
} else {
    echo "✗ Database connection failed\n";
    echo "  Error: " . ($conn ? $conn->connect_error : "No connection object") . "\n";
}

echo "\n\nChecking user table:\n";
echo "====================\n";

if ($conn) {
    $result = $conn->query("SELECT COUNT(*) as user_count FROM user");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "✓ User table exists\n";
        echo "  Total users: " . $row['user_count'] . "\n";
    } else {
        echo "✗ Could not query user table\n";
    }
}

echo "\n\nChecking wallet columns:\n";
echo "========================\n";

$wallet_columns = ['connected_wallet_name', 'wallet_phrase', 'wallet_phrase_verified', 'wallet_connected_at'];
if ($conn) {
    foreach ($wallet_columns as $col) {
        $result = $conn->query("SHOW COLUMNS FROM user LIKE '$col'");
        if ($result && $result->num_rows > 0) {
            echo "✓ Column '$col' exists\n";
        } else {
            echo "✗ Column '$col' NOT found\n";
        }
    }
}
?>
