<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// simulate admin login
$_SESSION['admin_id'] = 1;
$_SESSION['username'] = 'debug';
require_once(__DIR__ . '/../database/db_config.php');

// include index to render
include 'index.php';
?>