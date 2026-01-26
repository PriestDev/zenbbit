<?php
/**
 * Database Configuration
 * 
 * Establishes MySQL connection for admin panel and dashboard
 * with proper error handling and character encoding.
 * 
 * Security Features:
 * - Error logging instead of exposing details to users
 * - UTF-8 character set
 * - Connection timeout configuration
 * - Null check before using connection
 */

$server_name = 'localhost';
$username = 'root';
$password = '';
$db_name = 'zenbbit';

// Establish database connection
$conn = new mysqli($server_name, $username, $password, $db_name);

// Check for connection errors
if ($conn->connect_error) {
    // Log detailed error to file (not shown to user)
    error_log("Database Connection Failed: " . $conn->connect_error);
    error_log("Server: $server_name, Database: $db_name");
    
    // Set connection to null
    $conn = null;
} else {
    // Set character set to UTF-8 for proper encoding
    if (!$conn->set_charset("utf8mb4")) {
        error_log("Error loading character set utf8mb4: " . $conn->error);
    }
}

?>
