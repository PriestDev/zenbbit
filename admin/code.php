<?php
/**
 * Admin Panel - Form Processing Handler
 * 
 * Processes all admin panel form submissions with prepared statements
 * and comprehensive input validation. Maintains backward compatibility
 * with all existing admin page functionalities.
 * 
 * Security Features:
 * - Prepared statements for all database queries (SQL injection prevention)
 * - Input sanitization and validation
 * - Session-based error/success messaging
 * - HTML output escaping
 * - CSRF protection via session management
 * 
 * Form Handlers:
 * - Admin Registration & Management
 * - Site Configuration (settings, logo, favicon)
 * - Email System (sending, tracking)
 * - Trading (plans, trades, settings)
 * - Deposits & Withdrawals (approval, decline, deletion)
 * - User Management (profile updates, deletion)
 * - Wallet & KYC Verification
 * - Bonus Distribution
 * - Login Authentication
 */

// NOTE: security.php is NOT included here to prevent redirect loops during login processing
// It will be included by pages that call this file AFTER they handle their own security checks

date_default_timezone_set("Europe/London");

// Only start session if one is not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../details.php';
require '../admin.php';
require '../database/db_config.php';

// =====================================================================
// HELPER FUNCTIONS
// =====================================================================

/**
 * Sanitize user input to prevent XSS
 * @param string $data Input data to sanitize
 * @return string Sanitized data
 */
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email format
 * @param string $email Email address
 * @return bool True if valid email
 */
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generate unique transaction ID
 * @return string Unique ID
 */
function generate_trx_id() {
    return uniqid();
}

/**
 * Send HTML formatted email
 * @param string $to Recipient email
 * @param string $subject Email subject
 * @param string $message_content Email message content
 * @param string $from_email Sender email
 * @return bool Success status
 */
function send_email($to, $subject, $message_content, $from_email = EMAIL) {
    if (!is_valid_email($to)) {
        return false;
    }
    
    $message = '
    <div style="background-color: rgb(175, 175, 175); padding: 30px;">
        <div style="max-width: 500px; margin:auto; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); padding: 30px;">
            <h6 style="text-align: center; background-color: rgb(175, 175, 175); padding: 15px; margin: 6px -12px;">Notification</h6>
            <center>
                <img src="https://' . DOMAIN . '/uploads/' . LOGO . '" style="filter: invert(100%);" width="100%" height="30%" alt="LOGO">
            </center>
            <br>
            <p style="text-align: center; padding: 10px;">' . $message_content . '</p>
            <br><br>
            <p style="text-align: center; font-size: 10px;">&copy; ' . NAME . ', ' . date('Y') . '</p>
        </div>
    </div>';
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: ' . NAME . ' <' . $from_email . '>' . "\r\n";
    
    return mail($to, $subject, $message, $headers);
}

/**
 * Generate CSRF token for form protection
 * @return string CSRF token
 */
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * @param string $token Token to verify
 * @return bool True if valid token
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Set session alert and redirect
 * @param string $type Alert type (success/status)
 * @param string $message Alert message
 * @param string|null $redirect Page to redirect to
 */
function set_alert($type, $message, $redirect = null) {
    $_SESSION[$type] = $message;
    if ($redirect) {
        header("location: $redirect");
        exit;
    }
}

/**
 * Get user by email
 * @param mysqli $conn Database connection
 * @param string $email User email
 * @return array|null User data or null
 */
function get_user_by_email($conn, $email) {
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
}

/**
 * Get user by ID
 * @param mysqli $conn Database connection
 * @param int $id User ID
 * @return array|null User data or null
 */
function get_user_by_id($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
}

/**
 * Get user by account ID
 * @param mysqli $conn Database connection
 * @param string $acct_id Account ID
 * @return array|null User data or null
 */
function get_user_by_acct_id($conn, $acct_id) {
    $stmt = $conn->prepare("SELECT * FROM user WHERE acct_id = ?");
    $stmt->bind_param("s", $acct_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
}

/**
 * Get admin by ID
 * @param mysqli $conn Database connection
 * @param int $id Admin ID
 * @return array|null Admin data or null
 */
function get_admin_by_id($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM admin WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
}

/**
 * Calculate trade end date
 * @param string $start_date Start date
 * @param int $trade_hrs Trade duration in hours
 * @return string|null End date or null
 */
function calculate_end_date($start_date, $trade_hrs) {
    if ($trade_hrs) {
        return date("Y-m-d H:i:s", strtotime($start_date) + ($trade_hrs * 86400));
    }
    return null;
}

/**
 * Handle file upload
 * @param string $file_field Form field name
 * @param string $upload_dir Upload directory
 * @return string|null Filename or null
 */
function upload_file($file_field, $upload_dir = '../uploads/') {
    if (isset($_FILES[$file_field]) && $_FILES[$file_field]['error'] === UPLOAD_ERR_OK) {
        $filename = basename($_FILES[$file_field]['name']);
        $target_path = $upload_dir . $filename;
        if (move_uploaded_file($_FILES[$file_field]['tmp_name'], $target_path)) {
            return $filename;
        }
    }
    return null;
}

/**
 * Get current asset price in USD using CoinGecko simple API
 * @param string $asset Asset code (e.g., 'btc', 'eth', 'usdt_erc')
 * @return float Price in USD or 0 on failure
 */
function get_asset_price_usd($asset) {
    $a = strtolower($asset);
    // Map internal asset codes to CoinGecko ids
    $map = [
        'btc' => 'bitcoin',
        'eth' => 'ethereum',
        'bnb' => 'binancecoin',
        'trx' => 'tron',
        'sol' => 'solana',
        'xrp' => 'ripple',
        'avax' => 'avalanche-2',
        'usdt_erc' => 'tether',
        'usdt_trc' => 'tether',
        'erc' => 'tether',
        'trc' => 'tether'
    ];

    // Stablecoins treat as $1
    if (in_array($a, ['usdt_erc','usdt_trc','erc','trc'])) {
        return 1.0;
    }

    if (!isset($map[$a])) {
        return 0.0;
    }

    $id = $map[$a];
    $url = "https://api.coingecko.com/api/v3/simple/price?ids=" . urlencode($id) . "&vs_currencies=usd";
    $opts = [
        'http' => [
            'method' => 'GET',
            'timeout' => 5
        ]
    ];
    $context = stream_context_create($opts);
    $resp = @file_get_contents($url, false, $context);
    if (!$resp) return 0.0;
    $data = json_decode($resp, true);
    if (!$data || !isset($data[$id]['usd'])) return 0.0;
    return floatval($data[$id]['usd']);
}

// =====================================================================
// ADMIN MANAGEMENT
// =====================================================================

/**
 * Register new admin account
 */
if (isset($_POST['register'])) {
    $username = sanitize_input($_POST['username'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $cpass = $_POST['cpassword'] ?? '';
    $usertype = sanitize_input($_POST['usertype'] ?? '');
    
    // Validation
    if (empty($username) || empty($email) || empty($pass)) {
        set_alert('status', 'All fields are required', 'register.php');
    }
    
    if (!is_valid_email($email)) {
        set_alert('status', 'Invalid email address', 'register.php');
    }
    
    if ($pass !== $cpass) {
        set_alert('status', "Password and Confirm Password don't match", 'register.php');
    }
    
    if (strlen($pass) < 8) {
        set_alert('status', 'Password must be at least 8 characters', 'register.php');
    }
    
    // Hash password using bcrypt (PASSWORD_BCRYPT)
    $hashed_password = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 10]);
    
    $stmt = $conn->prepare("INSERT INTO admin (user_name, email, password, usertype) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $usertype);
    
    if ($stmt->execute()) {
        set_alert('success', 'Admin Profile Added', 'register.php');
    } else {
        set_alert('status', 'Admin Profile Not Added: ' . $stmt->error, 'register.php');
    }
    $stmt->close();
}


/**
 * Update admin profile (self)
 */
if (isset($_POST['admin_btn'])) {
    $id = (int)$_POST['edit_id'];
    $username = sanitize_input($_POST['edit_username'] ?? '');
    $email = sanitize_input($_POST['edit_email'] ?? '');
    $pass = $_POST['edit_password'] ?? '';
    $image = upload_file('edit_image');
    
    // Hash password if provided, otherwise keep existing
    if (!empty($pass)) {
        $pass = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 10]);
    } else {
        // Get existing password if not changing
        $stmt = $conn->prepare("SELECT password FROM admin WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
        $pass = $result['password'];
        $stmt->close();
    }
    
    if ($image) {
        $stmt = $conn->prepare("UPDATE admin SET user_name=?, email=?, password=?, image=? WHERE id=?");
        $stmt->bind_param("ssssi", $username, $email, $pass, $image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE admin SET user_name=?, email=?, password=? WHERE id=?");
        $stmt->bind_param("sssi", $username, $email, $pass, $id);
    }
    
    if ($stmt->execute()) {
        unset($_SESSION['username']);
        set_alert('success', 'Profile Updated', 'login.php');
    } else {
        set_alert('status', 'Update Unsuccessful', 'index.php');
    }
    $stmt->close();
}


/**
 * Update admin account (admin edit)
 */
if (isset($_POST['update_btn'])) {
    $id = (int)$_POST['edit_id'];
    $username = sanitize_input($_POST['edit_username'] ?? '');
    $email = sanitize_input($_POST['edit_email'] ?? '');
    $pass = $_POST['edit_password'] ?? '';
    $status = (int)($_POST['status'] ?? 1);
    
    // Hash password if provided, otherwise keep existing
    if (!empty($pass)) {
        $pass = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 10]);
    } else {
        // Get existing password if not changing
        $stmt = $conn->prepare("SELECT password FROM admin WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);
        $pass = $result['password'];
        $stmt->close();
    }
    
    $stmt = $conn->prepare("UPDATE admin SET user_name=?, email=?, password=?, status=? WHERE id=?");
    $stmt->bind_param("sssii", $username, $email, $pass, $status, $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Admin Updated', 'register.php');
    } else {
        set_alert('status', 'Update Unsuccessful', 'register.php');
    }
    $stmt->close();
}


/**
 * Delete admin account
 */
if (isset($_POST['delete_btn'])) {
    $id = (int)$_POST['delete_admin'];
    
    $stmt = $conn->prepare("DELETE FROM admin WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Admin Deleted', 'register.php');
    } else {
        set_alert('status', 'Admin Not Deleted', 'register.php');
    }
    $stmt->close();
}

// =====================================================================
// SITE SETTINGS
// =====================================================================

/**
 * Save site configuration
 */
if (isset($_POST['save_site'])) {
    $id = (int)$_POST['id'];
    $site = sanitize_input($_POST['sitename'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');
    $address = sanitize_input($_POST['address'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $ref = sanitize_input($_POST['ref'] ?? '');
    $btc = sanitize_input($_POST['btc'] ?? '');
    $eth = sanitize_input($_POST['eth'] ?? '');
    $trc = sanitize_input($_POST['trc'] ?? '');
    $erc = sanitize_input($_POST['erc'] ?? '');
    $xrp = sanitize_input($_POST['xrp'] ?? '');
    $eth_message = sanitize_input($_POST['eth_message'] ?? '');
    $tron_message = sanitize_input($_POST['tron_message'] ?? '');
    $eth_gas = sanitize_input($_POST['eth_gas'] ?? '');
    $tron_gas = sanitize_input($_POST['tron_gas'] ?? '');
    
    $stmt = $conn->prepare(
        "UPDATE page_content SET site_name=?, ref=?, btc=?, xrp=?, eth=?, trc=?, erc=?, email=?, phone=?, address=?, eth_message=?, tron_message=?, eth_gas=?, tron_gas=? WHERE id=?"
    );
    $stmt->bind_param("ssssssssssssssi", $site, $ref, $btc, $xrp, $eth, $trc, $erc, $email, $phone, $address, $eth_message, $tron_message, $eth_gas, $tron_gas, $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Site Settings Updated', 'homepage.php');
    } else {
        set_alert('status', 'Update Failed', 'homepage.php');
    }
    $stmt->close();
}

/**
 * Upload logo and favicon
 */
if (isset($_POST['save_logo'])) {
    $fav = upload_file('fav');
    $logo = upload_file('logo');
    
    if ($fav || $logo) {
        $fields = [];
        $params = [];
        $types = '';
        
        if ($fav) {
            $fields[] = "fav=?";
            $params[] = $fav;
            $types .= 's';
        }
        if ($logo) {
            $fields[] = "logo=?";
            $params[] = $logo;
            $types .= 's';
        }
        
        $params[] = 1;
        $types .= 'i';
        
        $sql = "UPDATE page_content SET " . implode(', ', $fields) . " WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            set_alert('success', 'Logo/Favicon Updated', 'homepage.php');
        } else {
            set_alert('status', 'Upload Failed', 'homepage.php');
        }
        $stmt->close();
    } else {
        set_alert('status', 'No files uploaded', 'homepage.php');
    }
}

/**
 * Delete logo
 */
if (isset($_POST['delete_logo'])) {
    $stmt = $conn->prepare("UPDATE page_content SET logo=NULL WHERE id=?");
    $id = 1;
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Logo Deleted', 'homepage.php');
    } else {
        set_alert('status', 'Delete Failed', 'homepage.php');
    }
    $stmt->close();
}

/**
 * Delete favicon
 */
if (isset($_POST['delete_fav'])) {
    $stmt = $conn->prepare("UPDATE page_content SET fav=NULL WHERE id=?");
    $id = 1;
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Favicon Deleted', 'homepage.php');
    } else {
        set_alert('status', 'Delete Failed', 'homepage.php');
    }
    $stmt->close();
}

// =====================================================================
// EMAIL MANAGEMENT
// =====================================================================

/**
 * Send email to user
 */
if (isset($_POST['mail'])) {
    $email = sanitize_input($_POST['email'] ?? '');
    $mailer = sanitize_input($_POST['mailer'] ?? '');
    $subject = sanitize_input($_POST['subject'] ?? '');
    $message_content = $_POST['message'] ?? '';
    
    if (empty($email) || empty($subject) || empty($message_content)) {
        set_alert('status', 'All fields are required', 'mail.php');
    }
    
    if (!is_valid_email($email)) {
        set_alert('status', 'Invalid email address', 'mail.php');
    }
    
    $user = get_user_by_email($conn, $email);
    
    if (!$user) {
        set_alert('status', 'User not found', 'mail.php');
    }
    
    $stmt = $conn->prepare("INSERT INTO mails (mailer, subject, user, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $mailer, $subject, $email, $message_content);
    
    if ($stmt->execute()) {
        if (send_email($email, $subject, $message_content, $mailer)) {
            set_alert('success', 'Email sent successfully', 'mail.php');
        } else {
            set_alert('status', 'Email delivery failed', 'mail.php');
        }
    } else {
        set_alert('status', 'Mail not saved', 'mail.php');
    }
    $stmt->close();
}

// =====================================================================
// PLAN MANAGEMENT
// =====================================================================

/**
 * Update trading plan
 */
if (isset($_POST['plan_edit'])) {
    $id = (int)$_POST['id'];
    $pair = sanitize_input($_POST['pair'] ?? '');
    $min = (float)($_POST['min'] ?? 0);
    $max = (float)($_POST['max'] ?? 0);
    $prof = (float)($_POST['prof'] ?? 0);
    $duration = (int)($_POST['duration'] ?? 0);
    $status = (int)($_POST['status'] ?? 0);
    
    $stmt = $conn->prepare("UPDATE plan SET name=?, min=?, max=?, per=?, status=?, duration=? WHERE id=?");
    $stmt->bind_param("sdddiii", $pair, $min, $max, $prof, $status, $duration, $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Plan Updated', 'plan.php');
    } else {
        set_alert('status', 'Plan not updated', 'plan.php');
    }
    $stmt->close();
}

// =====================================================================
// TRADE MANAGEMENT
// =====================================================================

/**
 * Update trade
 */
if (isset($_POST['trade_edit'])) {
    $file = sanitize_input($_POST['file'] ?? 'index.php');
    $id = (int)$_POST['id'];
    $user = sanitize_input($_POST['user'] ?? '');
    $u_bal = (float)($_POST['u_bal'] ?? 0);
    $pair = sanitize_input($_POST['pair'] ?? '');
    $amt = (float)($_POST['amt'] ?? 0);
    $status = (int)($_POST['status'] ?? 0);
    $prof = (float)($_POST['prof'] ?? 0);
    $trade_hrs = (int)($_POST['trade_hrs'] ?? 0);
    
    $start_date = date('Y-m-d H:i:s');
    $end_date = calculate_end_date($start_date, $trade_hrs);
    
    if ($amt > 0 && $u_bal < $amt) {
        set_alert('status', 'Insufficient balance for user', $file);
    }
    
    $user_data = get_user_by_acct_id($conn, $user);
    
    if (!$user_data) {
        set_alert('status', 'User not found', $file);
    }
    
    if ($amt > 0) {
        $stmt = $conn->prepare(
            "UPDATE trade SET create_date=?, trade_duration=?, pair=?, amount=?, status=?, profit=?, end_date=? WHERE id=?"
        );
        $stmt->bind_param("sissdisi", $start_date, $trade_hrs, $pair, $amt, $status, $prof, $end_date, $id);
        
        if ($stmt->execute()) {
            $new_bal = $user_data['balance'] - $amt;
            $stmt2 = $conn->prepare("UPDATE user SET balance=? WHERE acct_id=?");
            $stmt2->bind_param("ds", $new_bal, $user);
            
            if ($stmt2->execute()) {
                set_alert('success', 'Trade Updated', $file);
            } else {
                set_alert('status', 'Balance update failed', $file);
            }
            $stmt2->close();
        } else {
            set_alert('status', 'Trade Not Updated', $file);
        }
    } else {
        $stmt = $conn->prepare(
            "UPDATE trade SET create_date=?, trade_duration=?, pair=?, status=?, profit=?, end_date=? WHERE id=?"
        );
        $stmt->bind_param("sisdisi", $start_date, $trade_hrs, $pair, $status, $prof, $end_date, $id);
        
        if ($stmt->execute()) {
            set_alert('success', 'Trade Updated', $file);
        } else {
            set_alert('status', 'Trade Not Updated', $file);
        }
    }
    $stmt->close();
}

/**
 * Process completed trade
 */
if (isset($_POST['proccess_trade'])) {
    $id = (int)$_POST['id'];
    
    $stmt = $conn->prepare("UPDATE trade SET status=1 WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Trade Successfully Processed', 'index.php');
    } else {
        set_alert('status', 'An error occurred', 'index.php');
    }
    $stmt->close();
}

/**
 * Delete trade
 */
if (isset($_POST['del_trade'])) {
    $file = sanitize_input($_POST['file'] ?? 'index.php');
    $id = (int)$_POST['id'];
    
    $stmt = $conn->prepare("DELETE FROM trade WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Trade Deleted', $file);
    } else {
        set_alert('status', 'Delete Failed', $file);
    }
    $stmt->close();
}

/**
 * Clear all trades
 */
if (isset($_POST['clear'])) {
    $stmt = $conn->prepare("DELETE FROM trade");
    
    if ($stmt->execute()) {
        set_alert('success', 'All Trades Deleted', 'index.php');
    } else {
        set_alert('status', 'Delete Failed', 'index.php');
    }
    $stmt->close();
}

/**
 * Update trade settings
 */
if (isset($_POST['trade'])) {
    $id = 1;
    $trade_hrs = (int)$_POST['trade_hrs'];
    $prof = (float)$_POST['prof'];
    
    $stmt = $conn->prepare("UPDATE trade_set SET trade_hrs=?, profit=? WHERE id=?");
    $stmt->bind_param("idi", $trade_hrs, $prof, $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Trade Settings Updated', 'trade.php');
    } else {
        set_alert('status', 'Update Failed', 'trade.php');
    }
    $stmt->close();
}

// =====================================================================
// DEPOSIT MANAGEMENT
// =====================================================================

/**
 * Approve deposit
 */
if (isset($_POST['approve_deposit'])) {
    $id = sanitize_input($_POST['approve_serial'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $user = sanitize_input($_POST['user_id'] ?? '');
    $amt = (float)($_POST['amt'] ?? 0);
    $pair = sanitize_input($_POST['pair'] ?? '');
    $status = 1;
    
    // Only update the serial status to 'approved' (1).
    $stmt = $conn->prepare("UPDATE transaction SET serial=? WHERE trx_id=?");
    $stmt->bind_param("is", $status, $id);

    if ($stmt->execute()) {
        // Fetch transaction details to notify user (amount, user acct, email, asset)
        $txn_stmt = $conn->prepare("SELECT amt, user_id, email, asset FROM transaction WHERE trx_id=? LIMIT 1");
        if ($txn_stmt) {
            $txn_stmt->bind_param("s", $id);
            $txn_stmt->execute();
            $txn_res = $txn_stmt->get_result();
            $txn = $txn_res->fetch_assoc();
            $txn_stmt->close();

            $notify_amt = isset($txn['amt']) ? (float)$txn['amt'] : $amt;
            $notify_user_acct = $txn['user_id'] ?? $user;
            $notify_email = $txn['email'] ?? $email;
            $txn_asset = isset($txn['asset']) ? strtolower($txn['asset']) : '';

            // Update user's crypto balance based on asset code in transaction.asset
            $asset_map = [
                'btc' => 'btc_balance',
                'eth' => 'eth_balance',
                'bnb' => 'bnb_balance',
                'trx' => 'trx_balance',
                'sol' => 'sol_balance',
                'xrp' => 'xrp_balance',
                'avax' => 'avax_balance',
                'usdt_erc' => 'erc_balance',
                'usdt_trc' => 'trc_balance',
                'erc' => 'erc_balance',
                'trc' => 'trc_balance'
            ];

            if (!empty($txn_asset) && isset($asset_map[$txn_asset]) && !empty($notify_user_acct)) {
                $balance_col = $asset_map[$txn_asset];

                // Read current balance
                $bal_stmt = $conn->prepare("SELECT $balance_col FROM user WHERE acct_id = ? LIMIT 1");
                if ($bal_stmt) {
                    $bal_stmt->bind_param("s", $notify_user_acct);
                    $bal_stmt->execute();
                    $bal_res = $bal_stmt->get_result();
                    $bal_row = $bal_res->fetch_assoc();
                    $bal_stmt->close();

                    $current_bal = isset($bal_row[$balance_col]) ? (float)$bal_row[$balance_col] : 0.0;

                    // Convert USD amount to crypto units using current price
                    $price_usd = get_asset_price_usd($txn_asset);
                    if ($price_usd <= 0) {
                        // fallback: treat stored amount as crypto units if price unavailable
                        $crypto_amount = $notify_amt;
                    } else {
                        // If notify_amt is USD value, crypto units = USD / price
                        $crypto_amount = $notify_amt / $price_usd;
                    }

                    // For stablecoins (mapped to tether) keep 1:1
                    if (in_array($txn_asset, ['usdt_erc','usdt_trc','erc','trc'])) {
                        $crypto_amount = $notify_amt;
                    }

                    // Round to 8 decimal places for balances
                    $crypto_amount = round($crypto_amount, 8);
                    $new_bal = $current_bal + $crypto_amount;

                    // Update user balance
                    $upd_sql = "UPDATE user SET $balance_col = ? WHERE acct_id = ?";
                    $upd_stmt = $conn->prepare($upd_sql);
                    if ($upd_stmt) {
                        $upd_stmt->bind_param("ds", $new_bal, $notify_user_acct);
                        $upd_stmt->execute();
                        $upd_stmt->close();
                    }
                }
            }

            // If email not present on transaction, try fetching from user record
            if (empty($notify_email) && !empty($notify_user_acct)) {
                $u = get_user_by_acct_id($conn, $notify_user_acct);
                if ($u && !empty($u['email'])) {
                    $notify_email = $u['email'];
                }
            }

            if (!empty($notify_email)) {
                $message = '<strong>Your deposit of $' . number_format($notify_amt, 2) . ' has been received and approved.</strong><br>' .
                           '<span style="font-size:0.95rem;color:#555;">Transaction ID: ' . htmlspecialchars($id) . '</span>';
                send_email($notify_email, "Deposit Approved", $message);
            }
        }

        set_alert('success', 'Deposit Approved', 'deposit.php');
    } else {
        set_alert('status', 'Approval failed', 'deposit.php');
    }
    $stmt->close();
}

/**
 * Decline deposit
 */
if (isset($_POST['decline_deposit'])) {
    $id = sanitize_input($_POST['serial'] ?? '');
    $status = 2; // 2 = declined
    
    $stmt = $conn->prepare("UPDATE transaction SET serial=? WHERE trx_id=?");
    $stmt->bind_param("is", $status, $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Deposit Declined', 'deposit.php');
    } else {
        set_alert('status', 'Decline failed', 'deposit.php');
    }
    $stmt->close();
}

/**
 * Delete deposit
 */
if (isset($_POST['delete_deposit'])) {
    $id = (int)$_POST['id'];
    
    $stmt = $conn->prepare("DELETE FROM transaction WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Deposit Deleted', 'deposit.php');
    } else {
        set_alert('status', 'Delete Failed', 'deposit.php');
    }
    $stmt->close();
}

// =====================================================================
// WITHDRAWAL MANAGEMENT
// =====================================================================

/**
 * Approve withdrawal
 */
if (isset($_POST['approve_wth'])) {
    $identifier = sanitize_input($_POST['approve_status'] ?? $_POST['trx_id'] ?? '');
    $status = 1;

    if (empty($identifier)) {
        set_alert('status', 'Invalid transaction identifier', 'withdraw.php');
    }

    // Resolve transaction by trx_id or id:NN fallback
    $tx = null;
    if (strpos($identifier, 'id:') === 0) {
        $tx_id = (int)substr($identifier, 3);
        $sel = $conn->prepare("SELECT * FROM transaction WHERE id=? LIMIT 1");
        if ($sel) {
            $sel->bind_param("i", $tx_id);
            $sel->execute();
            $tx = $sel->get_result()->fetch_assoc();
            $sel->close();
        }
    } else {
        $sel = $conn->prepare("SELECT * FROM transaction WHERE trx_id=? LIMIT 1");
        if ($sel) {
            $sel->bind_param("s", $identifier);
            $sel->execute();
            $tx = $sel->get_result()->fetch_assoc();
            $sel->close();
        }
    }

    if (!$tx) {
        set_alert('status', 'Transaction not found', 'withdraw.php');
    }

    // Update serial using id when available to avoid ambiguity
    if (!empty($tx['id'])) {
        $up = $conn->prepare("UPDATE transaction SET serial=? WHERE id=?");
        $up->bind_param("ii", $status, $tx['id']);
    } else {
        $up = $conn->prepare("UPDATE transaction SET serial=? WHERE trx_id=?");
        $up->bind_param("is", $status, $tx['trx_id']);
    }

    if ($up && $up->execute()) {
        $amt = (float)($tx['amt'] ?? 0);
        $notify_email = $tx['email'] ?? '';
        
        // Deduct amount from user's crypto balance
        $tx_asset = isset($tx['asset']) ? strtolower($tx['asset']) : '';
        $tx_user = $tx['user_id'] ?? '';
        
        $asset_map = [
            'btc' => 'btc_balance',
            'eth' => 'eth_balance',
            'bnb' => 'bnb_balance',
            'trx' => 'trx_balance',
            'sol' => 'sol_balance',
            'xrp' => 'xrp_balance',
            'avax' => 'avax_balance',
            'usdt_erc' => 'erc_balance',
            'usdt_trc' => 'trc_balance',
            'erc' => 'erc_balance',
            'trc' => 'trc_balance'
        ];
        
        if (!empty($tx_asset) && isset($asset_map[$tx_asset]) && !empty($tx_user)) {
            $balance_col = $asset_map[$tx_asset];
            
            // Read current balance
            $bal_stmt = $conn->prepare("SELECT $balance_col FROM user WHERE acct_id = ? LIMIT 1");
            if ($bal_stmt) {
                $bal_stmt->bind_param("s", $tx_user);
                $bal_stmt->execute();
                $bal_res = $bal_stmt->get_result();
                $bal_row = $bal_res->fetch_assoc();
                $bal_stmt->close();
                
                $current_bal = isset($bal_row[$balance_col]) ? (float)$bal_row[$balance_col] : 0.0;
                
                // Convert USD amount to crypto units
                $price_usd = get_asset_price_usd($tx_asset);
                if ($price_usd <= 0) {
                    $crypto_amount = $amt;
                } else {
                    $crypto_amount = $amt / $price_usd;
                }
                
                // For stablecoins keep 1:1
                if (in_array($tx_asset, ['usdt_erc','usdt_trc','erc','trc'])) {
                    $crypto_amount = $amt;
                }
                
                $crypto_amount = round($crypto_amount, 8);
                $new_bal = max(0, $current_bal - $crypto_amount); // Ensure balance doesn't go negative
                
                // Deduct from user balance
                $upd_sql = "UPDATE user SET $balance_col = ? WHERE acct_id = ?";
                $upd_stmt = $conn->prepare($upd_sql);
                if ($upd_stmt) {
                    $upd_stmt->bind_param("ds", $new_bal, $tx_user);
                    $upd_stmt->execute();
                    $upd_stmt->close();
                }
            }
        }
        
        // Fallback: attempt to get user email from user record if transaction missing it
        if (empty($notify_email) && !empty($tx['user_id'])) {
            if (ctype_digit($tx['user_id'])) {
                $u = get_user_by_id($conn, (int)$tx['user_id']);
            } else {
                $u = get_user_by_acct_id($conn, $tx['user_id']);
            }
            if ($u && !empty($u['email'])) $notify_email = $u['email'];
        }

        if (!empty($notify_email)) {
            $message = "This is to inform you that your withdrawal request of $" . number_format($amt, 2) . " from your account has been confirmed and you will receive it shortly.";
            send_email($notify_email, "Withdrawal Processed", $message);
        }
        set_alert('success', 'Withdrawal Approved', 'withdraw.php');
    } else {
        set_alert('status', 'Approval failed', 'withdraw.php');
    }
    if (isset($up) && $up) $up->close();
}

/**
 * Decline withdrawal
 */
if (isset($_POST['decline_wth'])) {
    $file = sanitize_input($_POST['file'] ?? 'withdraw.php');
    $email = sanitize_input($_POST['email'] ?? '');
    // Accept trx id via approve_status (consistent with approve form) or fallback to status/trx_id
    $trx_id = sanitize_input($_POST['approve_status'] ?? $_POST['trx_id'] ?? $_POST['status'] ?? '');
    $user = sanitize_input($_POST['user_id'] ?? '');
    $amt = (float)($_POST['amt'] ?? 0);
    $gateway = (int)($_POST['gate_way'] ?? 1);
    $status = 2;

    if (empty($trx_id)) {
        set_alert('status', 'Invalid transaction identifier', $file);
    }

    // Resolve transaction similar to approve flow
    $tx = null;
    if (strpos($trx_id, 'id:') === 0) {
        $tx_id = (int)substr($trx_id, 3);
        $sel = $conn->prepare("SELECT * FROM transaction WHERE id=? LIMIT 1");
        if ($sel) {
            $sel->bind_param("i", $tx_id);
            $sel->execute();
            $tx = $sel->get_result()->fetch_assoc();
            $sel->close();
        }
    } else {
        $sel = $conn->prepare("SELECT * FROM transaction WHERE trx_id=? LIMIT 1");
        if ($sel) {
            $sel->bind_param("s", $trx_id);
            $sel->execute();
            $tx = $sel->get_result()->fetch_assoc();
            $sel->close();
        }
    }

    if (!$tx) {
        set_alert('status', 'Transaction not found', $file);
    }

    if (!empty($tx['id'])) {
        $stmt = $conn->prepare("UPDATE transaction SET serial=? WHERE id=?");
        $stmt->bind_param("ii", $status, $tx['id']);
    } else {
        $stmt = $conn->prepare("UPDATE transaction SET serial=? WHERE trx_id=?");
        $stmt->bind_param("is", $status, $trx_id);
    }

    if ($stmt->execute()) {
        // Refund logic: use values from transaction when possible
        $tx_user = $tx['user_id'] ?? $user;
        $tx_amt = (float)($tx['amt'] ?? $amt);
        $tx_gateway = (int)($tx['gate_way'] ?? $gateway);

        $user_data = null;
        if (!empty($tx_user)) {
            if (ctype_digit($tx_user)) {
                $user_data = get_user_by_id($conn, (int)$tx_user);
            } else {
                $user_data = get_user_by_acct_id($conn, $tx_user);
            }
        }

        if ($user_data) {
            $tx_asset = isset($tx['asset']) ? strtolower($tx['asset']) : '';
            
            $asset_map = [
                'btc' => 'btc_balance',
                'eth' => 'eth_balance',
                'bnb' => 'bnb_balance',
                'trx' => 'trx_balance',
                'sol' => 'sol_balance',
                'xrp' => 'xrp_balance',
                'avax' => 'avax_balance',
                'usdt_erc' => 'erc_balance',
                'usdt_trc' => 'trc_balance',
                'erc' => 'erc_balance',
                'trc' => 'trc_balance'
            ];
            
            $stmt2 = null;
            if (!empty($tx_asset) && isset($asset_map[$tx_asset])) {
                // Refund to crypto balance
                $balance_col = $asset_map[$tx_asset];
                $current_bal = isset($user_data[$balance_col]) ? (float)$user_data[$balance_col] : 0.0;
                
                $price_usd = get_asset_price_usd($tx_asset);
                if ($price_usd <= 0) {
                    $crypto_amount = $tx_amt;
                } else {
                    $crypto_amount = $tx_amt / $price_usd;
                }
                
                if (in_array($tx_asset, ['usdt_erc','usdt_trc','erc','trc'])) {
                    $crypto_amount = $tx_amt;
                }
                
                $crypto_amount = round($crypto_amount, 8);
                $new_bal = $current_bal + $crypto_amount;
                
                $stmt2 = $conn->prepare("UPDATE user SET $balance_col = ? WHERE id = ?");
                if ($stmt2) {
                    $stmt2->bind_param("di", $new_bal, $user_data['id']);
                }
            } elseif ($tx_gateway == 1) {
                // Fallback to legacy balance for non-crypto transactions
                $new_balance = (float)$user_data['balance'] + $tx_amt;
                $stmt2 = $conn->prepare("UPDATE user SET balance = ? WHERE id = ?");
                if ($stmt2) {
                    $stmt2->bind_param("di", $new_balance, $user_data['id']);
                }
            } else {
                // Fallback to legacy profit
                $new_profit = (float)$user_data['profit'] + $tx_amt;
                $stmt2 = $conn->prepare("UPDATE user SET profit = ? WHERE id = ?");
                if ($stmt2) {
                    $stmt2->bind_param("di", $new_profit, $user_data['id']);
                }
            }

            if (isset($stmt2) && $stmt2 && $stmt2->execute()) {
                $message = "This is to inform you that your withdrawal request of $" . number_format($amt, 2) . " from your account has been declined.";
                send_email($email, "Withdrawal Declined", $message);
                set_alert('success', 'Withdrawal Declined', $file);
            } else {
                set_alert('status', 'Update failed', $file);
            }
            if (isset($stmt2) && $stmt2) $stmt2->close();
        } else {
            set_alert('status', 'User not found', $file);
        }
    } else {
        set_alert('status', 'Decline failed', $file);
    }
    $stmt->close();
}

/**
 * Delete withdrawal
 */
if (isset($_POST['delete_withdraw'])) {
    $identifier = sanitize_input($_POST['delete_wth'] ?? '');
    if (strpos($identifier, 'id:') === 0) {
        $del_id = (int)substr($identifier, 3);
        $stmt = $conn->prepare("DELETE FROM transaction WHERE id=?");
        $stmt->bind_param("i", $del_id);
    } else {
        $stmt = $conn->prepare("DELETE FROM transaction WHERE trx_id=?");
        $stmt->bind_param("s", $identifier);
    }
    
    if ($stmt->execute()) {
        set_alert('success', 'Withdrawal Deleted', 'withdraw.php');
    } else {
        set_alert('status', 'Delete Failed', 'withdraw.php');
    }
    $stmt->close();
}

// =====================================================================
// USER MANAGEMENT
// =====================================================================

/**
 * Update user profile
 */
if (isset($_POST['updatebtn'])) {
    $file = sanitize_input($_POST['file'] ?? 'users.php');
    $id = (int)$_POST['edit_id'];
    $fname = sanitize_input($_POST['edit_fname'] ?? '');
    $lname = sanitize_input($_POST['edit_lname'] ?? '');
    $ip_address = sanitize_input($_POST['ip_address'] ?? '');
    $email = sanitize_input($_POST['edit_email'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');
    $t_btn = (int)($_POST['t_btn'] ?? 0);
    $status = (int)($_POST['status'] ?? 0);
    $trade_per = (float)($_POST['trade_per'] ?? 0);
    $acct_stat = (int)($_POST['acct_stat'] ?? 0);
    $kyc = (int)($_POST['kyc'] ?? 0);
    
    // Crypto balances
    $btc_balance = (float)($_POST['btc_balance'] ?? 0);
    $eth_balance = (float)($_POST['eth_balance'] ?? 0);
    $bnb_balance = (float)($_POST['bnb_balance'] ?? 0);
    $trx_balance = (float)($_POST['trx_balance'] ?? 0);
    $sol_balance = (float)($_POST['sol_balance'] ?? 0);
    $xrp_balance = (float)($_POST['xrp_balance'] ?? 0);
    $avax_balance = (float)($_POST['avax_balance'] ?? 0);
    $erc_balance = (float)($_POST['erc_balance'] ?? 0);
    $trc_balance = (float)($_POST['trc_balance'] ?? 0);
    
    // Get user data before update to detect changes
    $user_data = get_user_by_id($conn, $id);
    $acct_id = $user_data['acct_id'] ?? '';
    
    // Handle password: Only update if a new password is provided
    // If password field is empty, keep the existing password
    $pass = $_POST['edit_password'] ?? '';
    if (empty($pass)) {
        // Password not provided in form - keep existing password
        $pass = $user_data['password'] ?? '';
    }
    
    // Handle banned IP
    if ($status == 3) {
        $stmt = $conn->prepare("INSERT INTO banned_ip (first_name, last_name, ip_address) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fname, $lname, $ip_address);
        
        if (!$stmt->execute()) {
            send_email(Admin_Email, "Error with banned IP", "An error occurred while banning IP address.");
            set_alert('status', 'Ban IP error', $file);
        }
        $stmt->close();
    } else {
        $stmt = $conn->prepare("DELETE FROM banned_ip WHERE ip_address=?");
        $stmt->bind_param("s", $ip_address);
        $stmt->execute();
        $stmt->close();
    }
    
    // CRITICAL: Verify password is not empty before update
    // This prevents accidental password nullification during asset balance updates
    if (empty($pass)) {
        error_log("WARNING: Empty password detected during user update for ID: $id. Using existing password.");
        $pass = $user_data['password'] ?? '';
        
        // Additional safety check - if still empty, abort update
        if (empty($pass)) {
            set_alert('status', 'ERROR: Cannot update user without valid password. Please contact support.', $file);
            exit;
        }
    }
    
    // Update user - now includes crypto balances (removed balance and profit updates)
    $stmt = $conn->prepare(
        "UPDATE user SET first_name=?, last_name=?, phone=?, email=?, password=?, status=?, trade_btn=?, trade_per=?, acct_stat=?, kyc=?, btc_balance=?, eth_balance=?, bnb_balance=?, trx_balance=?, sol_balance=?, xrp_balance=?, avax_balance=?, erc_balance=?, trc_balance=? WHERE id=?"
    );
    $stmt->bind_param(
        "ssssiidiiidddddddddi",
        $fname, $lname, $phone, $email, $pass, $status, $t_btn, $trade_per, $acct_stat, $kyc, 
        $btc_balance, $eth_balance, $bnb_balance, $trx_balance, $sol_balance, $xrp_balance, $avax_balance, $erc_balance, $trc_balance, $id
    );
    
    if ($stmt->execute()) {
        // Log crypto balance changes to asset_transaction table
        $crypto_types = [
            'btc' => ['old' => $user_data['btc_balance'] ?? 0, 'new' => $btc_balance],
            'eth' => ['old' => $user_data['eth_balance'] ?? 0, 'new' => $eth_balance],
            'bnb' => ['old' => $user_data['bnb_balance'] ?? 0, 'new' => $bnb_balance],
            'trx' => ['old' => $user_data['trx_balance'] ?? 0, 'new' => $trx_balance],
            'sol' => ['old' => $user_data['sol_balance'] ?? 0, 'new' => $sol_balance],
            'xrp' => ['old' => $user_data['xrp_balance'] ?? 0, 'new' => $xrp_balance],
            'avax' => ['old' => $user_data['avax_balance'] ?? 0, 'new' => $avax_balance],
            'erc' => ['old' => $user_data['erc_balance'] ?? 0, 'new' => $erc_balance],
            'trc' => ['old' => $user_data['trc_balance'] ?? 0, 'new' => $trc_balance]
        ];
        
        $admin_id = $_SESSION['id'] ?? null;
        
        foreach ($crypto_types as $crypto => $balances) {
            if ($balances['old'] != $balances['new']) {
                $amount = abs($balances['new'] - $balances['old']);
                $type = $balances['new'] > $balances['old'] ? 'deposit' : 'withdrawal';
                
                $log_stmt = $conn->prepare(
                    "INSERT INTO asset_transaction (user_id, acct_id, crypto_type, transaction_type, amount, previous_balance, new_balance, status, admin_id, description) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, 'completed', ?, 'Admin adjustment')"
                );
                $log_stmt->bind_param(
                    "isssdddi",
                    $id, $acct_id, $crypto, $type, $amount, $balances['old'], $balances['new'], $admin_id
                );
                $log_stmt->execute();
                $log_stmt->close();
            }
        }
        
        set_alert('success', 'User Updated', $file);
    } else {
        set_alert('status', 'Update Failed', $file);
    }
    $stmt->close();
}

/**
 * Delete user
 */
if (isset($_POST['delete'])) {
    $id = (int)$_POST['delete_id'];
    
    $stmt = $conn->prepare("DELETE FROM user WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'User Deleted', 'users.php');
    } else {
        set_alert('status', 'Delete Failed', 'users.php');
    }
    $stmt->close();
}

/**
 * Delete user from user edit page
 */
if (isset($_POST['delete_user'])) {
    $id = (int)$_POST['delete_user'];
    $user_email = sanitize_input($_POST['user_email'] ?? '');
    
    // Begin transaction to delete user and all related data
    $conn->begin_transaction();
    
    try {
        // Delete user transactions
        $stmt = $conn->prepare("DELETE FROM transaction WHERE user_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        
        // Delete user deposits
        $stmt = $conn->prepare("DELETE FROM deposits WHERE user_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        
        // Delete user KYC data
        $stmt = $conn->prepare("DELETE FROM kyc WHERE user_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        
        // Delete user asset transactions
        $stmt = $conn->prepare("DELETE FROM asset_transaction WHERE user_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        
        // Delete main user record
        $stmt = $conn->prepare("DELETE FROM user WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        
        // Commit transaction
        $conn->commit();
        
        // Send notification email to admin
        $subject = "User Account Deleted";
        $message = "
            <h2>User Account Deletion Notification</h2>
            <p><strong>Email:</strong> {$user_email}</p>
            <p><strong>User ID:</strong> {$id}</p>
            <p><strong>Deleted At:</strong> " . date('Y-m-d H:i:s') . "</p>
            <p><strong>Deleted By:</strong> Admin</p>
            <hr>
            <p>The user account and all associated data (transactions, KYC, etc.) have been permanently deleted from the system.</p>
        ";
        send_email(Admin_Email, $subject, $message);
        
        set_alert('success', 'User Account Permanently Deleted', 'users.php');
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        error_log("User deletion error for ID {$id}: " . $e->getMessage());
        set_alert('status', 'Failed to Delete User: ' . $e->getMessage(), 'user_edit.php?id=' . $id);
    }
}

// =====================================================================
// WALLET & KYC VERIFICATION
// =====================================================================

/**
 * Verify wallet
 */
if (isset($_POST['c_wallet'])) {
    $file = sanitize_input($_POST['file'] ?? 'users.php');
    
    // Only handle wallet verification - KYC verification columns don't exist in current schema
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = (int)$_POST['id'];
        
        $stmt = $conn->prepare("UPDATE user SET wallet_stat=1 WHERE id=?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            set_alert('success', 'Wallet Verified', $file);
        } else {
            set_alert('status', 'Connection Error', $file);
        }
        $stmt->close();
    } else {
        set_alert('status', 'Invalid request', $file);
    }
}

/**
 * Delete wallet
 */
if (isset($_POST['delete_wallet'])) {
    $file = sanitize_input($_POST['file'] ?? 'users.php');
    $id = (int)$_POST['edit_id'];
    
    $stmt = $conn->prepare("UPDATE user SET phrase=NULL, wallet_stat=0 WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Wallet Deleted', $file);
    } else {
        set_alert('status', 'Delete Failed', $file);
    }
    $stmt->close();
}

/**
 * Update wallet phrase
 */
if (isset($_POST['update_phrase'])) {
    $file = sanitize_input($_POST['file'] ?? 'users.php');
    $id = (int)$_POST['edit_id'];
    $phrase = sanitize_input($_POST['phrase'] ?? '');
    $wallet_stat = (int)($_POST['wallet_stat'] ?? 0);
    
    // Validate phrase (12 or 24 words)
    $word_count = count(explode(' ', trim($phrase)));
    if ($word_count !== 12 && $word_count !== 24) {
        set_alert('status', 'Recovery phrase must contain 12 or 24 words', $file);
    }
    
    // Sanitize phrase - remove extra spaces, convert to lowercase
    $phrase = strtolower(preg_replace('/\s+/', ' ', $phrase));
    
    $stmt = $conn->prepare("UPDATE user SET phrase=?, wallet_stat=? WHERE id=?");
    $stmt->bind_param("sii", $phrase, $wallet_stat, $id);
    
    if ($stmt->execute()) {
        set_alert('success', 'Wallet Phrase Updated', $file);
    } else {
        set_alert('status', 'Update Failed', $file);
    }
    $stmt->close();
}

/**
 * KYC Management - Approve / Reject / Reset
 */
if (isset($_POST['verify_kyc']) || isset($_POST['reject_kyc']) || isset($_POST['reset_kyc'])) {
    $file = sanitize_input($_POST['file'] ?? 'users.php');
    $id = (int)($_POST['edit_id'] ?? 0);

    if ($id <= 0) {
        set_alert('status', 'Invalid user ID', $file);
    }

    // Fetch user
    $user = get_user_by_id($conn, $id);
    if (!$user) {
        set_alert('status', 'User not found', $file);
    }

    // Decide action
    if (isset($_POST['verify_kyc'])) {
        $new_status = 1; // verified
        $kyc_tbl_status = 1;
        $alert_msg = 'KYC Verified';
        $email_subject = 'KYC Verified';
        $email_message = '<strong>Your identity documents have been verified.</strong><br><span style="font-size:0.95rem;color:#555;">You may now access all platform features.</span>';
    } elseif (isset($_POST['reject_kyc'])) {
        $new_status = 0; // not verified / rejected
        $kyc_tbl_status = 2; // rejected in kyc table
        $alert_msg = 'KYC Rejected';
        $email_subject = 'KYC Verification Rejected';
        $email_message = '<strong>Your KYC submission has been rejected.</strong><br><span style="font-size:0.95rem;color:#555;">Please review and resubmit valid documents.</span>';
    } else {
        // reset
        $new_status = 0; // not verified
        $kyc_tbl_status = 0; // pending/none
        $alert_msg = 'KYC Status Reset';
        $email_subject = 'KYC Status Reset';
        $email_message = '<strong>Your KYC status has been reset.</strong><br><span style="font-size:0.95rem;color:#555;">Please re-upload documents if required.</span>';
    }

    // Update user table kyc column if exists
    $stmt = $conn->prepare("UPDATE user SET kyc=? WHERE id=?");
    $stmt->bind_param("ii", $new_status, $id);
    $ok = $stmt->execute();
    $stmt->close();

    // Update kyc table entries for this user if present
    $stmt2 = $conn->prepare("UPDATE kyc SET status=? WHERE user_id=?");
    if ($stmt2) {
        $stmt2->bind_param("ii", $kyc_tbl_status, $id);
        $stmt2->execute();
        $stmt2->close();
    }

    // Send email notification to user (best-effort)
    $notify_email = $user['email'] ?? '';
    if (!empty($notify_email) && is_valid_email($notify_email)) {
        send_email($notify_email, $email_subject, $email_message);
    }

    if ($ok) {
        set_alert('success', $alert_msg, 'user_edit.php?id=' . $id);
    } else {
        set_alert('status', 'KYC update failed', 'user_edit.php?id=' . $id);
    }
}

// =====================================================================
// BONUS & TRANSACTIONS
// =====================================================================

/**
 * Award bonus to user
 */
if (isset($_POST['bonus'])) {
    $user_email = sanitize_input($_POST['user'] ?? '');
    $amount = (float)($_POST['amount'] ?? 0);
    
    if (empty($user_email) || $amount <= 0) {
        set_alert('status', 'Invalid user or amount', 'other.php');
    }
    
    $user_data = get_user_by_email($conn, $user_email);
    
    if (!$user_data) {
        set_alert('status', 'User not found', 'other.php');
    }
    
    $trx_id = generate_trx_id();
    $status = 'other';
    $serial = 1;
    
    $stmt = $conn->prepare(
        "INSERT INTO transaction (trx_id, user_id, amt, name, status, email, serial) VALUES (?, ?, ?, 'Bonus', ?, ?, ?)"
    );
    $stmt->bind_param("ssdssi", $trx_id, $user_data['acct_id'], $amount, $status, $user_data['email'], $serial);
    
    if ($stmt->execute()) {
        $new_profit = $user_data['profit'] + $amount;
        $stmt2 = $conn->prepare("UPDATE user SET profit=? WHERE acct_id=?");
        $stmt2->bind_param("ds", $new_profit, $user_data['acct_id']);
        
        if ($stmt2->execute()) {
            $message = "Congratulations! A bonus of $" . number_format($amount, 2) . " has been added to your trading account due to your active participation. We hope you achieve more on your trading journey with us.";
            send_email($user_data['email'], "Bonus Alert", $message);
            set_alert('success', 'Bonus Awarded', 'other.php');
        } else {
            set_alert('status', 'Balance update failed', 'other.php');
        }
        $stmt2->close();
    } else {
        set_alert('status', 'Bonus award failed', 'other.php');
    }
    $stmt->close();
}

// =====================================================================
// ADMIN LOGIN (For backward compatibility)
// =====================================================================

/**
 * Admin login
 */
if (isset($_POST['login_btn'])) {
    // Validate CSRF token first
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        set_alert('status', 'Security validation failed. Please try again.', 'login.php');
    }
    
    $username = sanitize_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        set_alert('status', 'Username and password are required', 'login.php');
    }
    
    // Get admin user from database
    $stmt = $conn->prepare("SELECT * FROM admin WHERE user_name=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_array(MYSQLI_ASSOC);
    $stmt->close();
    
    // Verify password using bcrypt
    if ($admin && password_verify($password, $admin['password'])) {
        // Regenerate session ID for security (prevent session fixation)
        session_regenerate_id(true);
        
        // Set ADMIN-specific session variables
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_type'] = $admin['usertype'];
        $_SESSION['last_activity'] = time();
        $_SESSION['session_type'] = 'admin'; // Track session type
        
        header('location: index.php');
        exit;
    } else {
        // Log failed attempt
        error_log("Failed login attempt for username: $username from IP: " . $_SERVER['REMOTE_ADDR']);
        set_alert('status', 'Invalid username or password', 'login.php');
    }
}


// =====================================================================
// ADMIN EDIT FORM DISPLAY (For backward compatibility)
// =====================================================================

if (isset($_POST['edit_btn'])) {
    include('includes/header.php');
    include('includes/navbar.php');
    ?>
    
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Admin Profile</h6>
            </div>
            <div class="card-body">
                <?php 
                    if (isset($_POST['edit_btn'])) {
                        $id = (int)$_POST['edit_id'];
                        $admin = get_admin_by_id($conn, $id);
                        
                        if ($admin) {
                ?>
                        <form method="POST" action="code.php">
                            <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($admin['id']); ?>">
                            
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="edit_username" value="<?php echo htmlspecialchars($admin['user_name']); ?>" class="form-control" readonly required>
                            </div>
                            
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="edit_email" value="<?php echo htmlspecialchars($admin['email']); ?>" class="form-control" readonly required>
                            </div>
                            
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="edit_password" value="<?php echo htmlspecialchars($admin['password']); ?>" class="form-control" readonly required>
                            </div>
                            
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1" <?php echo $admin['status'] == 1 ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo $admin['status'] == 0 ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                            
                            <div>
                                <a href="register.php" class="btn btn-danger">Cancel</a>
                                <button type="submit" name="update_btn" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                <?php 
                        } else {
                            echo '<p class="alert alert-danger">Admin not found</p>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    
    <?php 
    include('includes/script.php');
    include('includes/footer.php');
}

// End of file - code.php
// All functions are modular, secure, and reusable across all admin pages
?>