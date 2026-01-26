<?php
/**
 * DASHBOARD_INIT.PHP - Centralized Dashboard Initialization
 * Handles session, authentication, database, and user loading
 * Used by all dashboard pages to ensure consistent initialization
 */

// ============================================
// PREVENT DUPLICATE EXECUTION
// ============================================

if (defined('DASHBOARD_INIT_LOADED')) {
    return;
}
define('DASHBOARD_INIT_LOADED', true);

// ============================================
// ERROR HANDLING
// ============================================

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// ============================================
// OUTPUT BUFFERING
// ============================================

if (ob_get_level() === 0) {
    ob_start();
}

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
// DETECT PROPER BASE PATH
// ============================================

// Determine the correct base directory
$baseDir = dirname(dirname(dirname(__FILE__)));

// ============================================
// DATABASE & REQUIRED FILES
// ============================================

if (!defined('DB_CONFIG_LOADED')) {
    $dbConfigPath = $baseDir . '/database/db_config.php';
    if (file_exists($dbConfigPath)) {
        include $dbConfigPath;
        define('DB_CONFIG_LOADED', true);
    } else {
        http_response_code(500);
        die('Error: Database configuration file not found at ' . $dbConfigPath);
    }
}

if (!defined('DETAILS_LOADED')) {
    $detailsPath = $baseDir . '/details.php';
    if (file_exists($detailsPath)) {
        require $detailsPath;
        define('DETAILS_LOADED', true);
    } else {
        http_response_code(500);
        die('Error: Details file not found at ' . $detailsPath);
    }
}

if (!defined('ADMIN_LOADED')) {
    $adminPath = $baseDir . '/admin.php';
    if (file_exists($adminPath)) {
        require $adminPath;
        define('ADMIN_LOADED', true);
    } else {
        http_response_code(500);
        die('Error: Admin file not found at ' . $adminPath);
    }
}

// ============================================
// AUTHENTICATION CHECK
// ============================================

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// ============================================
// LOAD USER DATA
// ============================================

if (!defined('USER_PHP_LOADED')) {
    $userPath = dirname(dirname(__FILE__)) . '/user.php';
    if (file_exists($userPath)) {
        require $userPath;
        define('USER_PHP_LOADED', true);
    } else {
        http_response_code(500);
        die('Error: User data file not found at ' . $userPath);
    }
}

// ============================================
// VALIDATION FUNCTIONS
// ============================================

/**
 * Get user's IP address
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
 * Validate user session and check account status
 */
if (!function_exists('validate_user_session')) {
    function validate_user_session($conn) {
        global $user;
        
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === null) {
            header('location: login.php');
            exit;
        }
        
        $user = $_SESSION['user_id'];
        $sql = "SELECT * FROM user WHERE acct_id = '$user'";
        $run = mysqli_query($conn, $sql);
        $result = $run->fetch_array(MYSQLI_ASSOC);
        
        // Account blocked
        if ($result['status'] == 0) {
            header('location: blocked.php');
            exit;
        }
    }
}

/**
 * Check if user IP is banned
 */
if (!function_exists('check_banned_ip')) {
    function check_banned_ip($conn, $user) {
        $sql = "SELECT * FROM user WHERE acct_id = '$user'";
        $run = mysqli_query($conn, $sql);
        $u = $run->fetch_array(MYSQLI_ASSOC);
        
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
            header('location: blocked.php');
            exit;
        }
    }
}

/**
 * Process pending trades
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
        
        if ($result['wth_trade'] == 0 && $result['id'] != null) {
            $trade_id = $result['id'];
            
            if ($current_date > $end_date) {
                $sql = "UPDATE trade SET status = 2, wth_trade = 1 WHERE id = '$trade_id'";
                $run_p = mysqli_query($conn, $sql);
                
                if (!$run_p) {
                    return;
                }
                
                $profit = $result['profit'];
                $trade_amt = $result['amount'];
                
                $sql = "SELECT * FROM user WHERE acct_id = '$user'";
                $run = mysqli_query($conn, $sql);
                $user_data = $run->fetch_array(MYSQLI_ASSOC);
                
                $new_profit = $user_data['profit'] + $profit;
                $new_balance = $user_data['balance'] + $trade_amt;
                
                $sql = "UPDATE user SET profit = '$new_profit', balance = '$new_balance' WHERE acct_id = '$user'";
                mysqli_query($conn, $sql);
            } 
            elseif ($current_date < $end_date) {
                $sql = "UPDATE trade SET status = 1 WHERE id = '$trade_id'";
                mysqli_query($conn, $sql);
            }
        }
    }
}

// ============================================
// EXECUTE VALIDATION
// ============================================

validate_user_session($conn);
check_banned_ip($conn, $_SESSION['user_id']);
process_pending_trades($conn, $_SESSION['user_id']);

?>
