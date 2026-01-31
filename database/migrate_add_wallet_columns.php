<?php
/**
 * One-off migration script to add wallet columns to `page_content`.
 * Run from CLI: php database/migrate_add_wallet_columns.php
 */

require_once __DIR__ . '/db_config.php';

if (!$conn) {
    echo "Database connection not available. Check database/db_config.php\n";
    exit(1);
}

$columns = [
    'bnb' => 'VARCHAR(255) DEFAULT NULL',
    'sol' => 'VARCHAR(255) DEFAULT NULL',
    'avax' => 'VARCHAR(255) DEFAULT NULL'
];

foreach ($columns as $col => $definition) {
    $checkSql = "SELECT COUNT(*) as cnt FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'page_content' AND COLUMN_NAME = '" . $conn->real_escape_string($col) . "'";
    $res = $conn->query($checkSql);
    $exists = false;
    if ($res) {
        $row = $res->fetch_assoc();
        $exists = ((int)$row['cnt'] > 0);
    }

    if ($exists) {
        echo "Column '{$col}' already exists.\n";
        continue;
    }

    $alter = "ALTER TABLE `page_content` ADD COLUMN `{$col}` {$definition}";
    if ($conn->query($alter) === TRUE) {
        echo "Added column '{$col}' to page_content.\n";
    } else {
        echo "Failed to add column '{$col}': " . $conn->error . "\n";
    }
}

$conn->close();
echo "Migration complete.\n";
