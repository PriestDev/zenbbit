<?php
	include('../database/db_config.php');
	session_start();
    require('../details.php');
    
    $user = $_SESSION['user_id'];
    $sql = "SELECT * FROM user WHERE acct_id = '$user'"; 
    $run = mysqli_query($conn, $sql);
    $val = $run->fetch_array(MYSQLI_ASSOC);
    if ($val['email'] == null) {
        $_SESSION['status'] = 'Email not found';
        header('location: ../user/user-data.php');
    } else{
        //resend code
        $email = $val['email'];
        $v_code = mt_rand(100000,999999);
        $sql = "UPDATE user SET v_code = '$v_code' WHERE acct_id = '$user'";
        $run = mysqli_query($conn, $sql);

        //send email
        $to = $email;
        $subject = "Email Verification";
        
        $message = '
            <div style="background-color: rgb(175, 175, 175); padding: 30px;">
                <div style="max-width: 500px; margin:auto; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); padding: 30px;">
                    <h6 style="text-align: center; background-color: rgb(175, 175, 175); padding: 15px; margin: 6px -12px;">Notification</h6>
                    <center>
                        <img src="https://'.DOMAIN.'/uploads/'.LOGO.'" width="350" height="180" alt="LOGO">
                    </center>
                    <h4>Hello '.$user.'</h4><br>
                    <p>Thanks for registering with us</p>
                    <p>Please use the code below to verify your email address.</p>
                    <br>
                    <p>Your email verification code is: <b style="font-size: 20px; color: rgb(46, 59, 46);">'.$v_code.'</b></p>
                    <br>
                    <br>
                    <p style="text-align: center; font-size: 10px;">&copy; '.NAME.', '.date('Y').'</p>
                </div>
            </div>
        ';
        
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        // More headers
        $headers .= 'From:'.NAME.' <'.EMAIL.'>' . "\r\n";
        
        mail($to,$subject,$message,$headers);
        
        $_SESSION['success'] = 'Code successfully resent to your email';
        header('location: ../user/user-data.php');
    }
 ?>