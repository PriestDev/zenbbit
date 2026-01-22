<?php 
date_default_timezone_set("Europe/London");

session_start();

include('../database/db_config.php');

if ($conn) {
		//echo "successful";
 } else {
 	header('location: ../database/db_config.php');
 }
	
if (!$_SESSION['username']) {

	header('location: login.php');
}

?>