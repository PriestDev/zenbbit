<?php
require_once __DIR__ . '/db_config.php';

if (!$conn) {
    echo "DB connection failed\n";
    exit(1);
}

$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'page_content' ORDER BY ORDINAL_POSITION";
$res = $conn->query($sql);

if (!$res) {
    echo "Query failed: " . $conn->error . "\n";
    exit(1);
}

$cols = [];
while ($row = $res->fetch_assoc()) {
    $cols[] = $row['COLUMN_NAME'];
}

echo "Columns in page_content: \n";
foreach ($cols as $c) {
    echo " - $c\n";
}

$needed = ['btc','eth','trc','erc','xrp','bnb','sol','avax'];
$missing = array_values(array_filter($needed, function($n) use ($cols) { return !in_array($n, $cols); }));

if (count($missing) === 0) {
    echo "\nAll required wallet columns are present.\n";
    exit(0);
} else {
    echo "\nMissing columns: " . implode(', ', $missing) . "\n";
    exit(2);
}
