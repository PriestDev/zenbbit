<?php
include 'database/db_config.php';

echo "User table columns:\n";
$result = $conn->query('SHOW COLUMNS FROM user');
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . "\n";
}

echo "\n\nChecking for wallet-related columns:\n";
$result = $conn->query('SHOW COLUMNS FROM user LIKE "%wallet%"');
echo "Rows found: " . $result->num_rows . "\n";
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . "\n";
}
?>
