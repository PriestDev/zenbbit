<?php
require_once(__DIR__ . '/database/db_config.php');
$run = mysqli_query($conn, "SELECT * FROM page_content LIMIT 1");
if ($run && $row = mysqli_fetch_assoc($run)) {
    var_export($row);
} else {
    echo "No row\n";
}
?>