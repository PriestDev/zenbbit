<?php
// Quick database check
include 'database/db_config.php';

if (!$conn) {
    die("DB connection failed\n");
}

echo "=== User Table Structure ===\n";
$result = $conn->query("DESCRIBE user");
$id_col = null;
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'];
    if ($row['Key'] === 'PRI') {
        echo " [PRIMARY KEY]";
        $id_col = $row['Field'];
    }
    echo "\n";
}

echo "\n=== Wallet Columns Check ===\n";
$result = $conn->query("SHOW COLUMNS FROM user LIKE 'wallet%'");
echo "Wallet columns found: " . $result->num_rows . "\n";
while ($row = $result->fetch_assoc()) {
    echo "  - " . $row['Field'] . " (" . $row['Type'] . ")\n";
}

echo "\n=== Primary ID Column ===\n";
echo "Primary key column: " . ($id_col ?? "NOT FOUND") . "\n";

echo "\n=== Sample User Data ===\n";
$result = $conn->query("SELECT id, acct_id, email FROM user LIMIT 1");
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "Found user: id=" . $user['id'] . ", acct_id=" . $user['acct_id'] . ", email=" . $user['email'] . "\n";
} else {
    echo "No users in database\n";
}
?>
