<?php
require 'database/db_config.php';

// Get user table structure
$result = $conn->query("DESCRIBE user");

if ($result) {
    echo "User Table Columns:\n";
    echo "====================\n\n";
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
