<?php
/**
 * SECURITY.PHP - Session & Trade Management
 * Handles session initialization, user validation, IP banning, and trade completion
 */

// ============================================
// SESSION INITIALIZATION
// ============================================

date_default_timezone_set("Europe/London");

// Only configure session settings if no session is active
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.gc_maxlifetime', 3600);
    session_set_cookie_params(3600);
    session_start();
}

// ============================================
// INCLUDES & DATABASE
// ============================================

include('../../database/db_config.php');
require '../../details.php';
require '../../admin.php';
require '../user.php';

if (!$conn) {
    header('location: ../database/db_config.php');
    exit;
}

// ============================================
// UTILITY FUNCTIONS
// ============================================

/**
 * Get user's IP address
 * Checks multiple sources for accurate IP detection
 */
if (!function_exists('get_user_ip')) {
    function get_user_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}

/**
 * Send email notification
 * @param string $to Email recipient
 * @param string $subject Email subject
 * @param string $message HTML email message
 */
if (!function_exists('send_email')) {
    function send_email($to, $subject, $message) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From:' . NAME . ' <' . EMAIL . '>' . "\r\n";
        mail($to, $subject, $message, $headers);
    }
}

/**
 * Send admin alert email for banned IP errors
 */
if (!function_exists('notify_admin_banned_ip_error')) {
    function notify_admin_banned_ip_error() {
    $message = '
        <div style="background-color: rgb(175, 175, 175); padding: 30px;">
            <div style="text-align: center; max-width: 500px; margin:auto; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); padding: 30px;">
                <h6 style="text-align: center; background-color: rgb(175, 175, 175); padding: 15px; margin: 6px -12px;">Notification</h6>
                <center>
                    <img src="https://' . DOMAIN . '/uploads/' . LOGO . '" width="100%" height="180" alt="LOGO">
                </center>
                <h4>Hello Admin</h4><br>
                <p style="color: red;">ALERT!!</p>
                <p>An banned ip error in your codes.</p>
                <br><br>
                <p style="text-align: center; font-size: 10px;">&copy; ' . NAME . ', ' . date('Y') . '</p>
            </div>
        </div>
    ';
    send_email(Admin_Email, "Error with banned ip", $message);
    }
}

/**
 * Send trade completion email to user
 */
if (!function_exists('notify_user_trade_complete')) {
    function notify_user_trade_complete($user_data) {
    $message = '
        <div style="background-color: rgb(175, 175, 175); padding: 30px;">
            <div style="text-align: center; max-width: 500px; margin:auto; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); padding: 30px;">
                <h6 style="text-align: center; background-color: rgb(175, 175, 175); padding: 15px; margin: 6px -12px;">Notification</h6>
                <center>
                    <img src="https://' . DOMAIN . '/uploads/' . LOGO . '" width="100%" height="180" alt="LOGO">
                </center>
                <h4>Hello ' . $user_data['first_name'] . ' ' . $user_data['last_name'] . '</h4><br>
                <p style="color: red;">ALERT!!</p>
                <p>Your Automated Trading session was successful and your profit has been added to your account.</p>
                <br><br>
                <p style="text-align: center; font-size: 10px;">&copy; ' . NAME . ', ' . date('Y') . '</p>
            </div>
        </div>
    ';
    send_email($user_data['email'], "Trade Alert", $message);
    }
}

// ============================================
// SESSION VALIDATION
// ============================================

/**
 * Validate user session and check account status
 */
if (!function_exists('validate_user_session')) {
    function validate_user_session($conn) {
    global $user;
    
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === null) {
        header('location: ../login.php');
        exit;
    }
    
    $user = $_SESSION['user_id'];
    $sql = "SELECT * FROM user WHERE acct_id = '$user'";
    $run = mysqli_query($conn, $sql);
    $result = $run->fetch_array(MYSQLI_ASSOC);
    
    // Incomplete registration
    // if ($result['status'] == 2) {
    //     $_SESSION['status'] = "Complete registration to verify your account";
    //     header('location: ../user/user-data.php');
    //     exit;
    // }
    
    // Account blocked
    if ($result['status'] == 0) {
        header('location: ../blocked.php');
        exit;
    }
    }
}

/**
 * Check if user IP is banned and handle accordingly
 */
if (!function_exists('check_banned_ip')) {
    function check_banned_ip($conn, $user) {
    
    $sql = "SELECT * FROM user WHERE acct_id = '$user'";
    $run = mysqli_query($conn, $sql);
    $u = $run->fetch_array(MYSQLI_ASSOC);
    
    // Only process if status is 3 (banned)
    if ($u['status'] != 3) {
        return;
    }
    
    $user_ip = get_user_ip();
    $user_1 = $u['first_name'];
    $user_2 = $u['last_name'];
    
    $sql_ = "INSERT INTO banned_ip (first_name, last_name, ip_address) VALUES ('$user_1', '$user_2', '$user_ip')";
    $run_ = mysqli_query($conn, $sql_);
    
    if ($run_) {
        unset($_SESSION['user_id']);
        header('location: https://www.404.com/');
        exit;
    } else {
        notify_admin_banned_ip_error();
    }
    }
}

/**
 * Process pending trades - check if trade is complete and update user balance
 */
if (!function_exists('process_pending_trades')) {
    function process_pending_trades($conn, $user) {
    $current_date = date('Y-m-d h:i:s');
    
    $sql = "SELECT * FROM trade WHERE user = '$user' ORDER BY id DESC";
    $run = mysqli_query($conn, $sql);
    
    if (!$run) {
        return;
    }
    
    $result = $run->fetch_array(MYSQLI_ASSOC);
    
    if (!isset($result['id'])) {
        return;
    }
    
    $end_date = date('Y-m-d h:i:s', strtotime($result['end_date']));
    
    // Check if trade has been withdrawn
    if ($result['wth_trade'] == 0 && $result['id'] != null) {
        $trade_id = $result['id'];
        
        // Trade is complete
        if ($current_date > $end_date) {
            $sql = "UPDATE trade SET status = 2, wth_trade = 1 WHERE id = '$trade_id'";
            $run_p = mysqli_query($conn, $sql);
            
            if (!$run_p) {
                return;
            }
            
            $profit = $result['profit'];
            $trade_amt = $result['amount'];
            
            // Get user data
            $sql = "SELECT * FROM user WHERE acct_id = '$user'";
            $run = mysqli_query($conn, $sql);
            $user_data = $run->fetch_array(MYSQLI_ASSOC);
            
            // Update user balance and profit
            $new_profit = $user_data['profit'] + $profit;
            $new_balance = $user_data['balance'] + $trade_amt;
            
            $sql = "UPDATE user SET profit = '$new_profit', balance = '$new_balance' WHERE acct_id = '$user'";
            $run = mysqli_query($conn, $sql);
            
            if ($run) {
                notify_user_trade_complete($user_data);
            }
        } 
        // Trade is still pending
        elseif ($current_date < $end_date) {
            $sql = "UPDATE trade SET status = 1 WHERE id = '$trade_id'";
            mysqli_query($conn, $sql);
        }
    }
    }
}

// ============================================
// EXECUTION
// ============================================

validate_user_session($conn);
check_banned_ip($conn, $user);
process_pending_trades($conn, $user);

?>
