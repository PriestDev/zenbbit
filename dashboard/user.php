<?php
// Determine base directory for includes
$baseDir = dirname(dirname(__FILE__));

include($baseDir . '/database/db_config.php');
require $baseDir . '/details.php';
require $baseDir . '/admin.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
}

$user = $_SESSION['user_id'];
    
    $sql = " SELECT * FROM user WHERE acct_id = '$user' ";
    $run = mysqli_query($conn, $sql);
    
    // Initialize asset balances with default values
    $btc_balance = 0;
    $eth_balance = 0;
    $bnb_balance = 0;
    $trx_balance = 0;
    $sol_balance = 0;
    $xrp_balance = 0;
    $avax_balance = 0;
    $erc_balance = 0;
    $trc_balance = 0;
    
 	foreach ($run as $val) {
 	    $id = $val['id'];
 		$fname = $val['first_name'];
 		$lname = $val['last_name'];
 		$bal = $val['balance'];
 		$email = $val['email'];
 		$profit = $val['profit'];
 		// $profit_per = $val['profit_per'];
 		$u_img = $val['image'];
 		$acct_id = $val['acct_id'];
 		$email = $val['email'];
 		$phone = $val['phone'];
 		$country = $val['country'];
 		$ip = $val['ip_address'];
 		$reg_date = $val['reg_date'];
 		$update = $val['update'];
 		$total_bal = $bal + $profit;
 		$pass = $val['password'];
 		$state = $val['state'];
 		$city = $val['city'];
		$address = $val['address'];
		$zip = $val['zip'];
		$phrase = $val['phrase'];
		$wallet_stat = $val['wallet_stat'];
		$t_btn = $val['trade_btn'];
		$ref = $val['referral'];
		$card = $val['card'];
		$s_card = $val['s_card'];
		$card_stat = $val['card_stat'];
		$trade_per = $val['trade_per'];
		$acct_stat = $val['acct_stat'];
		$wth_amt = $val['wth_amt'];
		$wth_amt_status = $val['wth_amt_status'];
		$kyc = $val['kyc'];
		$status = $val['status'];
		// Extract individual asset balances
		$btc_balance = floatval($val['btc_balance'] ?? 0);
		$eth_balance = floatval($val['eth_balance'] ?? 0);
		$bnb_balance = floatval($val['bnb_balance'] ?? 0);
		$trx_balance = floatval($val['trx_balance'] ?? 0);
		$sol_balance = floatval($val['sol_balance'] ?? 0);
		$xrp_balance = floatval($val['xrp_balance'] ?? 0);
		$avax_balance = floatval($val['avax_balance'] ?? 0);
		$erc_balance = floatval($val['erc_balance'] ?? 0);
		$trc_balance = floatval($val['trc_balance'] ?? 0); 		$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://blockchain.info/tobtc?currency=USD&value=".$bal,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: fc62ebce-6d0b-ef4f-ba02-fcb05e284a02"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    
        $bal_btc = json_decode($response);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://blockchain.info/tobtc?currency=USD&value=".$total_bal,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: fc62ebce-6d0b-ef4f-ba02-fcb05e284a02"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    
        $total_btc = json_decode($response);

 		defined('id') or define('id', $id);
		defined('fname') or define('fname', $fname);
		defined('lname') or define('lname', $lname);
		defined('email') or define('email', $email);
		defined('btc') or define('btc', $bal_btc);
		defined('total_btc') or define('total_btc', $total_btc);
		defined('state') or define('state', $state);
		defined('city') or define('city', $city);
		defined('zip') or define('zip', $zip);
		defined('address') or define('address', $address);
		defined('phrase') or define('phrase', $phrase);
		defined('wallet_stat') or define('wallet_stat', $wallet_stat);
		defined('bal') or define('bal', $bal);
		defined('profit') or define('profit', $profit);
		// defined('profit_per') or define('profit_per', $profit_per);
		defined('u_img') or define('u_img', $u_img);
		defined('acct_id') or define('acct_id', $acct_id);
		// defined('email') or define('email', $email);
		defined('phone') or define('phone', $phone);
		defined('country') or define('country', $country);
		defined('ip') or define('ip', $ip);
		defined('reg_date') or define('reg_date', $reg_date);
		defined('update') or define('update', $update);
		defined('total_bal') or define('total_bal', $total_bal);
		defined('pass') or define('pass', $pass);
		defined('ref') or define('ref', $ref);
		defined('trade_per') or define('trade_per', $trade_per);
		defined('trade_btn') or define('trade_btn', $t_btn);
		defined('acct_stat') or define('acct_stat', $acct_stat);
		defined('wth_amt') or define('wth_amt', $wth_amt);
		defined('wth_amt_status') or define('wth_amt_status', $wth_amt_status);
		defined('card') or define('card', $card);
		defined('s_card') or define('s_card', $s_card);
		defined('card_stat') or define('card_stat', $card_stat);
		defined('kyc') or define('kyc', $kyc);
		defined('status') or define('status', $status);


	}
	
?>
