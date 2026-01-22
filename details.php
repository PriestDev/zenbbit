<?php 
 include('database/db_config.php');

 $sql = " SELECT * FROM page_content";
 $run = mysqli_query($conn, $sql);
 	foreach ($run as $val) {
 		$name = $val['site_name'];
 		$logo = $val['logo'];
 		$desc = $val['site_desc'];
 		$email = $val['email'];
 		$phone = $val['phone'];
 		$address = $val['address'];
 		$domain = $val['domain'];
		$fav = $val['fav'];
		$ref = $val['ref'];
		$btc = $val['btc'];
		$eth = $val['eth'];
		$trc = $val['trc'];
		$erc = $val['erc'];


		defined('LOGO') or define('LOGO', $logo);
		defined('DESC') or define('DESC', $desc);
		defined('NAME') or define('NAME', $name);
		defined('EMAIL') or define('EMAIL', $email);
		defined('PHONE') or define('PHONE', $phone);
		defined('ADDRESS') or define('ADDRESS', $address);
		defined('DOMAIN') or define('DOMAIN', $domain);
		defined('FAV') or define('FAV', $fav);
		defined('REF') or define('REF', $ref);
		defined('BTC') or define('BTC', $btc);
		defined('ETH') or define('ETH', $eth);
		defined('TRC') or define('TRC', $trc);
		defined('ERC') or define('ERC', $erc);

	}
	
	$tSql = " SELECT * FROM trade_set WHERE id = 1";
    $tRun = mysqli_query($conn, $tSql);
     	foreach ($tRun as $conte) {
     		$trade_hrs = $conte['trade_hrs'];
     		$profit = $conte['profit'];
    
    		defined('TRADE_HRS') or define('TRADE_HRS', $trade_hrs);
    		defined('T_PROFIT') or define('T_PROFIT', $profit);
    }

?>