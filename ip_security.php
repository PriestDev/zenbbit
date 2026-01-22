<?php
    include('database/db_config.php');

    function get_ip() {
        $mainIp = '';
		if (getenv('HTTP_CLIENT_IP'))
			$mainIp = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$mainIp = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$mainIp = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$mainIp = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$mainIp = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$mainIp = getenv('REMOTE_ADDR');
		else
			$mainIp = 'UNKNOWN';
		return $mainIp;
    }
    		
    $user_ip = get_ip();
    
    $sql = "SELECT * FROM banned_ip WHERE ip_address = '$user_ip'";
    $run = mysqli_query($conn, $sql);
    $user = $run->fetch_array(MYSQLI_ASSOC);
    
    if (isset($user['ip_address']) && $user['ip_address'] == null) {
        // echo 'Success';
        
        $sql_ = "SELECT * FROM user WHERE ip_address = '$user_ip'";
        $run_ = mysqli_query($conn, $sql_);
        $user_ = $run_->fetch_array(MYSQLI_ASSOC);
        
        if ($user_['ip_address'] == null) {
            $sql_ = "INSERT INTO unknown_ip (ip_address) VALUES ('$user_ip')";
     		$run_ = mysqli_query($conn, $sql_);
        } else {
            // header('location: https://www.pornhub.com/');
            // echo 'error';
        }
    } else {
        header('location: https://www.404.com/');
        // echo 'error';
    }
?>