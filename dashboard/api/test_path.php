<?php
$currentFile = __FILE__;
echo "Current file: $currentFile\n";

$level1 = dirname($currentFile);
echo "Level 1: $level1\n";

$level2 = dirname($level1);
echo "Level 2: $level2\n";

$level3 = dirname($level2);
echo "Level 3: $level3\n";

$dbPath = $level3 . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'db_config.php';
echo "Final path: $dbPath\n";
echo "Exists: " . (file_exists($dbPath) ? "YES" : "NO") . "\n";
?>
