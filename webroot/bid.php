<?php
// Include the config file
require_once '../config/config.php';
  

// Setup the timezone
if(!empty($config['App']['timezone'])){
	putenv("TZ=".$config['App']['timezone']);
}
//*** Load Add-on manager
define('DS', '/');
define('ADDON', '..' . DS . 'add-ons' . DS);
define('PHPPA_VERSION', '2.5.0');
require( ADDON . 'addon_manager.php');
AddonManager::loadAddons();

// Include the functions
require_once '../daemons_functions.php';

// Include some get status functions
require_once '../getstatus_functions.php';


// lets check for multiversions
 
//Set up logging
if ($config['App']['daemons_log']===TRUE) {
	define('LOG_FILE', '../tmp/logs/daemons.log');
} else {
	define('LOG_FILE', '');
}

  

// just incase the database isn't called yet
require_once '../database.php';

// NORMAL BIDDING
// Reading session id from cookie
if(!empty($_COOKIE['AUCTION'])){
	$sessionId = $_COOKIE['AUCTION'];
	session_id($sessionId);
}

// Starting session
session_start();

// Reading user id
if(!empty($_SESSION['Auth'])){
	$data['user_id'] = $_SESSION['Auth']['User']['id'];
	$data['first_name'] = $_SESSION['Auth']['User']['first_name'];
}else{
	$data['user_id'] = null;
}

if(!empty($_GET['id'])) {
	$data['auction_id']	= intval($_GET['id']);
	$aid	= intval($_GET['id']);

	 
}
$uid = $data['user_id'];
// Debugging stuff
if(0){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
} 

 $msgarr['eng']['not_login'] = 'You are not logged in.';
 $msgarr['eng']['csrf_attack'] = 'CSRF attack attempt detected.';
 $msgarr['eng']['beginer_error'] = 'Sorry, this auction is only open to new bidders.';
 $msgarr['eng']['auction_closed'] = 'Auction has been closed';
 $msgarr['eng']['auction_not_started'] = 'Auction has not started yet';
 $msgarr['eng']['already_leading'] = 'You cannot bid as you are already the latest bidder';
 $msgarr['eng']['upgrade_plan'] = 'Upgrade your plan to %s bid on this product ';
 $msgarr['eng']['buy_plan'] = 'You must buy Plan';
 $msgarr['eng']['bid_placed'] = 'Your bid was placed';
 $msgarr['eng']['bid_problem'] = 'There was a problem placing the bid please contact us';
 $msgarr['eng']['no_bids'] = 'You have no more bids in your account';
 $msgarr['eng']['upgrade_plan3'] = 'do you want to pay %s  bids?';
 $msgarr['eng']['auction_blocked'] = "auction is blocked by %s , you can unclock your self by paying %s bids";
 $msgarr['eng']['already_blocked'] = "auction is currently blocked";
 $msgarr['fre']['block_before_10'] = "Auction can be blocked before 10 second";


 $msgarr['fre']['not_login'] = "Vous n'êtes pas connecté.";
 $msgarr['fre']['csrf_attack'] = "Tentative d'attaque CSRF détectée.";
 $msgarr['fre']['beginer_error'] = "Désolé, cette enchère n'est ouverte qu'aux nouveaux bideurs.";
 $msgarr['fre']['auction_closed'] = "L'enchère a été clôturée";
 $msgarr['fre']['auction_not_started'] = "L'enchère n'a pas encore commencé";
 $msgarr['fre']['already_leading'] = 'Vous ne pouvez pas bidez car vous êtes déjà le dernier bideur';
 //$msgarr['fre']['upgrade_plan'] = 'Mettez à niveau votre forfait pour %s bider sur ce produit ';
$msgarr['fre']['upgrade_plan'] = 'Pour bider sur ce produit, vous devez acceder à la categorie %s. ';  
$msgarr['fre']['buy_plan'] = 'Vous devez acheter une souscription';
 $msgarr['fre']['bid_placed'] = 'Vous avez bidez';
 $msgarr['fre']['bid_problem'] = 'Un problème est survenu lors de la soumission du Bid, veuillez nous contacter';
 $msgarr['fre']['no_bids'] = "Vous n'avez plus des Bids dans votre compte";
 $msgarr['fre']['upgrade_plan3'] = " Payez %s bids?";
 $msgarr['fre']['auction_blocked'] = "Enchère bloquée par  %s , payez  %s bids pour vous débloquer";
 $msgarr['fre']['already_blocked'] = "L'enchère est actuellement bloquée";
 $msgarr['fre']['block_before_10'] = "Auction can be blocked before 10 second";
// Bid the auction
$t = time() + 30 ; 
$ct = time()   ; 
if($_GET['block'] == 1){

	$is_blked = mysqli_fetch_array(mysqli_query($db,"SELECT id FROM auction_block WHERE auction_id  = '".$aid."' AND   created > $ct   " ), MYSQLI_ASSOC);
	 
	if(!$is_blked['id']){
		$prd = mysqli_fetch_array(mysqli_query($db,"SELECT a.block_bids,a.end_time, p.title FROM products p
													LEFT JOIN auctions a ON p.id = a.product_id WHERE a.id = '$aid'  "), MYSQLI_ASSOC);
		$bal = balance($uid);
		$blk_bd = $prd['block_bids'];
		$tl = strtotime($prd['end_time']) - time();
		
		if($bal > $blk_bd && $tl > 10   ){
			$usr = mysqli_fetch_array(mysqli_query($db,"SELECT first_name,username FROM users WHERE id = $uid " ), MYSQLI_ASSOC);
	
			mysqli_query($db,"UPDATE users SET bid_balance = bid_balance - $blk_bd  WHERE id = $uid " );
			mysqli_query($db,"INSERT INTO bids SET 	user_id = '{$uid}', 
													description = 'Auction Blocked ',
													blk = 1,
													auction_id = '{$aid}',
													debit = '{$blk_bd}',
													created = '".date('Y-m-d H:i:s')."' 
			");
			mysqli_query($db,"DELETE FROM auction_block WHERE auction_id  = '".$aid."'  " );
			mysqli_query($db,"DELETE FROM user_unblock WHERE auction_id  = '".$aid."'  " );
			$setting = mysqli_query($db,"INSERT INTO auction_block SET auction_id  = '".$aid."', user_id = '".$uid."', created = '$t'   " );
			
		 	$setting = mysqli_query($db,"INSERT INTO user_unblock SET auction_id  = '".$aid."', user_id = '".$uid."', created = '$t'   " );
			$data_p['aid'] = $aid;
			$data_p['uid'] = $uid;
			$data_p['blk_bd'] = $blk_bd;
			
			$data_p['msg'] = " Auction Blocked by {$data['first_name']}  for 30 seconds id#: $aid  title:   {$prd['title']}   ";
			$data_p['event'] = 'Block';
			$data_p['BU'] = ($usr['first_name']) ? $un['first_name'].'(B)' : $un['username'].'(B)'  ;
			$data_p['u'] = $data_p['BU']; 
			$data_p['BC'] = date('Y-m-d H:i:s');
			$auction = $data_p;
			push($data_p); 
		}else{ 
			$auction['Auction']['message'] = $msgarr[$config['App']['language']]['no_bids'];
			if($tl < 10){
				$auction['Auction']['message'] = $msgarr[$config['App']['language']]['block_before_10'];
			}
		} 
	}else{
		$auction['Auction']['message'] = $msgarr[$config['App']['language']]['already_blocked'];
	} 

}else if($_GET['un_block'] == 1   ){ 
	$usr = mysqli_fetch_array(mysqli_query($db,"SELECT first_name,username FROM users WHERE id = $uid " ), MYSQLI_ASSOC);
	
	$prd = mysqli_fetch_array(mysqli_query($db,"SELECT a.unblock_bids, p.title FROM products p
												LEFT JOIN auctions a ON p.id = a.product_id WHERE a.id = '$aid'  "), MYSQLI_ASSOC);
	$bal = balance($uid);
	$blk_bd = $prd['unblock_bids'];

	if($bal > $blk_bd){   

		mysqli_query($db,"UPDATE users SET bid_balance = bid_balance - $blk_bd  WHERE id = $uid " );
		mysqli_query($db,"INSERT INTO bids SET 	user_id = '{$uid}', 
												unblk = 1,
												description = 'Auction Un-Blocked ',
												auction_id = '{$aid}',
												debit = '{$blk_bd}',
												created = '".date('Y-m-d H:i:s')."' 
		   ");
		 
		$setting = mysqli_query($db,"DELETE FROM user_unblock WHERE auction_id  = '".$data['auction_id']."' AND user_id = '".$uid."'   " );
		$setting = mysqli_query($db,"INSERT INTO user_unblock SET auction_id  = '".$data['auction_id']."', user_id = '".$uid."', created = '$t'   " );
	
		$data_p['aid'] = $aid;
		$data_p['uid'] = $uid;
		$data_p['blk_bd'] = $blk_bd;
		
		$data_p['msg'] = " User:  {$data['first_name']}  Unblocked id#: $aid  title:   {$prd['title']}   ";
		$data_p['event'] = 'Block';
		$data_p['BU'] = ($usr['first_name']) ? $un['first_name'].'(UB)' : $un['username'].'(UB)' ;
		$data_p['u'] = $data_p['BU']; 
		$data_p['BC'] = date('Y-m-d H:i:s');
		$auction = $data_p;
		push($data_p); 
	}else{ 
		$auction['Auction']['message'] = $msgarr[$config['App']['language']]['no_bids'];
	}  


 
}else{ 
	$auction = bid($data);
}

echo json_encode($auction);


?>
