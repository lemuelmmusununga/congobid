<?php
$start = microtime();

// Include the config file
require_once '../config/config.php';

//*** Load Add-on manager
define('DS', '/');
define('ADDON', '..' . DS . 'add-ons' . DS);
define('PHPPA_VERSION', '2.5.0');
require( ADDON . 'addon_manager.php');
AddonManager::loadAddons();

// Include the functions
require_once '../getstatus_functions.php';
require_once '../daemons_functions.php'; 

// lets check for multiversions
$_SERVER['SERVER_NAME'] = str_replace('www.', '', $_SERVER['SERVER_NAME']);

//Set up logging
if ($config['App']['daemons_log']===TRUE) {
	define(LOG_FILE, '../tmp/logs/daemons.log');
} else {
	define(LOG_FILE, '');
}


function _bin($auction_id, $buy_now_price, $user_id = 0,&$bid_count = null,&$vbid_count = null) {
	global $config;
	if ($buy_now_price==0) return 0;
	require_once('../database.php');
	
	if (isset($config['App']['buyNow']['bid_discount']) && $config['App']['buyNow']['bid_discount']===true) {
		if($user_id>0) {
			$vbid_count=cacheRead('vbid_'.$auction_id.'_'.$user_id);
			$bid_count=cacheRead('bid_'.$auction_id.'_'.$user_id);
			$discount=($bid_count*$config['App']['buyNow']['bid_price']);
		}
		
		return ($discount>=$buy_now_price)?0.01:$buy_now_price - $discount;
		
	} else {
		return $buy_now_price;
	}
}


// Setup the timezone
if(!empty($config['App']['timezone'])){
	@putenv("TZ=".$config['App']['timezone']);
}

// Reading session id from cookie
if(!empty($_COOKIE['AUCTION'])){
	$sessionId = $_COOKIE['AUCTION'];
	session_id($sessionId);
}

// Starting session
session_start();

// Reading user id
if(!empty($_SESSION['Auth']['User']['id'])){
	$user_id = $_SESSION['Auth']['User']['id'];
}else{
	$user_id = null;
}

// Turn on/off error reporting based on debug level
if($config['debug'] == 1){
	error_reporting(E_ALL);
}else{
	error_reporting(E_ERROR);
}

// Get the peak
$ipn = isPeakNow();

// Lets check that the site is online
$siteOnline = siteOnline();

// Get the POST data
$data 	   = $_POST;
if(empty($data)){
	if (isset($_REQUEST['testnum'])) {
		$data = array('auction_id' => $_REQUEST['testnum']);
	} else {
		die('No data given');
	}
}

// Result array
$results = array();


$rate = 1;
$last_key = end(array_keys($data));
	
// Loop through the posted data

foreach($data as $key => $value){
	// Get the auction data
	if(!empty($_GET['histories'])) {
		$result = cacheRead('cake_auction_view_'.$value);
	} else {
		$result = cacheRead('cake_auction_'.$value);
	}
	
	

	if(empty($result)) {
		// Including database
		require_once '../database.php';

		// Get the auction data
		$a = mysql_fetch_array(mysql_query("SELECT id, product_id, start_time, end_time, price p, leader_id l, peak_only po, closed FROM auctions WHERE id = $value"), MYSQL_ASSOC);

		// Get the product related to auction
		$product = mysql_fetch_array(mysql_query("SELECT id, rrp, fixed, buy_now FROM products WHERE id = ".$a['product_id']), MYSQL_ASSOC);

		
		/*$bid = mysql_fetch_array(mysql_query("SELECT u.username u FROM bids b, users u WHERE b.credit = 0 AND b.user_id = u.id AND b.auction_id = ".$value." ORDER BY b.id DESC LIMIT 1"), MYSQL_ASSOC);*/
		$bid = mysql_fetch_array(mysql_query("SELECT username u FROM users WHERE id = '".$a['l']."' "), MYSQL_ASSOC);
	
		
		
		
		if(!empty($config['App']['flashMessage'])){
			// Get the message
			$message = mysql_fetch_array(mysql_query("SELECT * FROM messages WHERE auction_id = ".$a['id']." LIMIT 1"), MYSQL_ASSOC);
			if(empty($message)){
				$message = false;
			}
		}

		$saving  = savings($a, $product);
		
		$lastPrice = $a['p'] * $rate;

		if(!empty($_GET['histories']) || !empty($_GET['savings'])) {
			$a['sps'] = round($saving['percentage'], 2) . ' %';
			$a['sp']      = currency($saving['p'] * $rate, $config['App']['currency']);
			
		}

		// Formatting last result
		$result = array();
		$result['Product'] = $product;

		// Getting the last bid
		if(!empty($bid['u'])) {
			$a['u']	 = utf8_encode($bid['u']);
		}else{
			$a['u'] = 'No bids'; 
		}

		
		// If requested, include the bid histories
		if(!empty($_GET['histories'])) {
			
		
			$bidHistories = mysql_query("SELECT b.id, b.user_id, b.description, b.debit, b.created, u.username u FROM bids b, users u WHERE b.credit = 0 AND b.user_id = u.id AND b.auction_id = ".$a['id']." ORDER BY b.id DESC LIMIT ".$config['App']['bidHistoryLimit']);

			// Get the total rows
			$total_rows   = mysql_num_rows($bidHistories);

			// If there is a result
			if($total_rows > 0) {
				$bidHistoriesResult = array();

				// Loop through results
				while($history = mysql_fetch_array($bidHistories, MYSQL_ASSOC)) {
					#$bidHistory['B']['id']          = $history['id'];
					$bidHistory['B']['C']     = niceShort($history['created']);
					$bidHistory['B']['D'] = $history['description'];
					$bidHistory['B']['u']   = utf8_encode($history['u']);
					
					$bidHistoriesResult[] = $bidHistory;
				}

				// Put the formatted history to result
				$result['H'] = $bidHistoriesResult;
			}
		}

		
		$result['A'] = $a;

		// lets cache this query
		if (preg_match('/^auction_([0-9]+)$/', $result['A']['e'])) {
			if(!empty($_GET['histories'])) {
				$a = cacheWrite('cake_auction_view_'.$value, $result);
			} else {
				$a = cacheWrite('cake_auction_'.$value, $result);
			}
		}
	}
	// Balance reading
	if(!empty($user_id)){
		$balance = cacheRead('cake_bids_balance_'.$user_id);
		if(empty($balance)){
			require_once '../database.php';

			if(empty($config['App']['simpleBids'])){
				$pbalance = mysql_fetch_array(mysql_query("SELECT SUM(credit) - SUM(debit) AS b FROM bids WHERE user_id = ".$user_id), MYSQL_ASSOC);
				//$vbalance = mysql_fetch_array(mysql_query("SELECT SUM(credit) - SUM(debit) AS b FROM bids WHERE user_id = ".$user_id), MYSQL_ASSOC);
				//$balance['b'] = $pbalance['b'] . '+'. $vbalance['b'] ;
				$balance['b'] = $pbalance['b']  ;
				
			}else{
				$balance = mysql_fetch_array(mysql_query("SELECT bid_balance AS balance FROM users WHERE id = ".$user_id), MYSQL_ASSOC);
				
			}
		}

		// Bring the balance in
		if(!empty($balance)){
			$result['B'] = $balance;
			cacheWrite('cake_bids_balance_'.$user_id, $balance);
		}
	}

	// some settings we can't cache

	// currencies converted
	$result['A']['as']   	    = currency($result['Product']['rrp'] - $result['A']['p'] , $config['App']['currency']);
	$result['A']['p']   	    = currency($result['A']['p'] * $rate, $config['App']['currency']);
	
	$mybids = 0;
	$vmybids = 0;
	$result['A']['bin'] = currency(_bin($result['A']['id'], $result['Product']['buy_now'], $user_id,$mybids,$vmybids) * $rate, $config['App']['currency']);
	$result['A']['m'] = $mybids;
	$result['A']['v'] = $vmybids;
	
	
	$result['Product']['rrp'] 	  		= $result['Product']['rrp'] * $rate;
	
	$result['A']['tl']	= strtotime($result['A']['end_time']) - time();
	if($result['A']['tl'] <= 0 && $result['A']['closed'] == 0){
		#$result['A']['tl'] = 1;
	}

	// now lets check that the site is online
	if($siteOnline == 'no' or $siteOnline=='0') {
		$result['A']['ipn'] 	= 0;
		$result['A']['po'] 	= 1;
	} else {
		$result['A']['ipn'] 	= $ipn; 
	}
	
	if(!empty($config['App']['delayedStart'])) {
		if(($result['A']['u'] == 'No hay pujas') || ($result['A']['u'] == 'Nessuna offerta')) {
			$result['A']['T'] = 'Bid Required';
		} else {
			$result['A']['T']   = getStringTime($result['A']['end_time']);
		}
	} else {
		$result['A']['T']   = getStringTime($result['A']['end_time']);
	}
	
	
	
	if($result['A']['closed']){
		$result['A']['T'] = 'Ended';
	}
	#if($_GET['page'] != 'view'){unset($result['A']['bin']);}
	unset($result['Product']);
	unset($result['A']['product_id']);unset($result['A']['start_time']);unset($result['A']['end_time']);unset($result['A']['closed']);
	#unset($result['A']['is_seat']);unset($result['A']['min_seat']);unset($result['A']['seat_status']);
	$results[] = $result;
}


unset($history, $result);

echo json_encode($results);

?>
