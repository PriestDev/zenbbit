<?php
    $server_name = 'localhost';
    $username = 'root';
    $password = '';
    $db_name = 'zenbbit';

    $conn = new mysqli($server_name, $username,$password, $db_name); 

    if ($conn) {
        //echo "successful";
         } else {
            die("ERROR: Could not connect. " . mysqli_connect_error());
    }
 ?>