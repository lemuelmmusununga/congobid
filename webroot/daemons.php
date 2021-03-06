<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$start = microtime();
// Include the config file
require_once '../config/config.php';
 
//*** Load Add-on manager
define('DS', '/');
define('ADDON', '..' . DS . 'add-ons' . DS);
define('PHPPA_VERSION', '2.5.0');
require( ADDON . 'addon_manager.php');
AddonManager::loadAddons();

// Setup the timezone
if(!empty($config['App']['timezone'])){
	putenv("TZ=".$config['App']['timezone']);
}

// Include the functions
require_once '../daemons_functions.php';
 
// Include some get status functions
require_once '../getstatus_functions.php';

//Set up logging
if ($config['App']['daemons_log']===TRUE) {
	define('LOG_FILE', '../tmp/logs/daemons.log');
} else {
	define('LOG_FILE', '');
}

require('../cake_skeletons.php');
require('../cake/libs/cache.php');
 
// Lets check that the site is online
$siteOnline = siteOnline();

if($siteOnline == 'no' or $siteOnline=='0') {
	exit('site not online');
}
 
// just incase the database isn't called yet
require_once '../database.php';

//force autobid setting to database setting, overriding any config.php setting
//$config['App']['autobids']=(get('autobidders') ? true : false);


switch($_GET['type']){
	 	
	case 'extend':
		if(cacheRead('cake_extend.pid')) {
			// return false;
		} else {
			cacheWrite('cake_extend.pid', microtime(), $config['App']['cronTime'] * 50);
		}
		
		//lets extend it by placing an autobid
		 
 		//$autobid_time 				= get('autobid_time');
		$autobid_time 				= 15;

		$expireTime = time() + ($config['App']['cronTime'] * 60);

		while (time() < $expireTime) {
			$autobid_time 				= rand(1,10);
			$autobid_time1 				= rand(1,10);
			$autobid_time2 				= rand(21,30);
			// now check for auto extends
			if( $autobid_time == rand(1,10) || $autobid_time1 == rand(1,10)  || $autobid_time2 == rand(20,30) ) {
				
				$date = date('Y-m-d H:i:s', time() + $autobid_time);
				$sql = mysqli_query($db,"SELECT 	a.id, 
								a.end_time,
								a.autobids, 
								p.autobid_limit, 
								a.random 
								FROM auctions a, products p 
								WHERE p.id = a.product_id 
								   AND (p.autobid = 1) 
								   AND (a.price < a.minimum_price)
								   AND a.deleted=0
								   AND a.closed = 0 
								   AND a.soon_undate = 0 
								   AND a.active = 1 
								   AND a.end_time < '$date'");
			 
				
				$total_rows   = mysqli_num_rows($sql);

				if($total_rows > 0) {
					while($auction = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
						

						if(checkCanClose($auction['id'], 0) == false) {
							placeAutobid($auction['id']);
						}
					}
				}
			}
			// sleep for 0.5 of a second
			usleep(500000);
		}
		
		cacheDelete('cake_extend.pid');
		
	break;
									
	case 'close':
		if(cacheRead('cake_close.pid')) {
			#return false;
		} else {
			cacheWrite('cake_close.pid', microtime(), $config['App']['cronTime'] * 60);
		}
		
		logIt('Daemon init');
		
		$expireTime = time() + ($config['App']['cronTime'] * 60);

		while (time() < $expireTime) {
			// lets start by getting all the auctions that have closed
			$sql_raw = "SELECT 	* FROM auctions WHERE end_time <= '".date('Y-m-d H:i:s')."' AND closed = 0 AND soon_undate = 0 AND active = 1 AND deleted=0";
			$sql = mysqli_query($db,$sql_raw);
			echo '<br />'.$sql_raw;
			$total_rows   = mysqli_num_rows($sql);
			echo '<br /> total rows : '.$total_rows;  
			if($total_rows > 0) {
				while($auction = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
					 echo '<br /> init : '.$auction['id'];
					// before we declare this user the winner, lets run some test to make sure the auction can definitely close
					if(  checkCanClose($auction['id'], 0) == false) {
						  
							placeAutobid($auction['id']);
					  
					} else {
						echo '<br /> closing : '.$auction['id'];
						logIt($auction['id'].' OK to close');
						closeAuction($auction);
					}
				}
			}
			// sleep for 0.5 of a second 
			usleep(500000);
			//mysqli_free_result($sql);
		}
		
		cacheDelete('cake_close.pid');
		
	break;
	
	case 'close1':
 		  $sql = mysqli_query($db,"SELECT 	* FROM auctions WHERE id = '190' "); 
 			if(1) {
				while($auction = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
					echo '<br /> init : '.$auction['id'];
					if(  checkCanClose($auction['id'], 0) == false) {
							echo '<br /> placeing Autobid : '.$auction['id'];
							//placeAutobid($auction['id']);
					} else {
						echo '<br /> closing : '.$auction['id'];
						closeAuction($auction);
					}
 				}
			}
 		
	break;
	case 'extend1':
		$expireTime = time() + ($config['App']['cronTime'] * 60);
		while (time() < $expireTime) {
 		 	$rand = rand(1,10);
			$sql = mysqli_query($db,"SELECT id FROM auctions WHERE real_bids_in_row > 5 ");  
 			if(1) {
				while($auction = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
					echo '<br /> init : '.$auction['id'];
					if(  checkCanClose($auction['id'], 0) == false) {
							echo '<br /> placeing Autobid extend1 : '.$auction['id'];
							placeAutobid($auction['id']);
					}  
 				}
			}
		}
 		
	break;
}
 

?>
 
