<?php 
 include('database/db_config.php');

 $sql = " SELECT * FROM admin WHERE usertype = 1";
 $run = mysqli_query($conn, $sql);
 	foreach ($run as $val) {
 		$email = $val['email'];

		defined('Admin_Email') or define('Admin_Email', $email);

	}
?>