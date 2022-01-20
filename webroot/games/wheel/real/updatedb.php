<?php
// Include the config file
require_once '../../../config/config.php';


// Setup the timezone
if(!empty($config['App']['timezone'])){
	putenv("TZ=".$config['App']['timezone']);
}

// just incase the database isn't called yet
require_once '../../../database.php';

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
	$user_id = $_SESSION['Auth']['User']['id'];
}else{
	$user_id = null;
}



$add_spin = $_POST['add_spin'];
$won_bids = $_POST['won_bids'];
$show_popup = $_POST['show_popup'];
$can_spin = $_POST['can_spin'];
$user_credit = $_POST['user_credit'];
$user_name = $_POST['user_name'];
$time_left = $_POST['time_left'];


if($user_id > 0 && $won_bids > 0){
	$sql = "INSERT INTO bids SET user_id = '".$user_id. "', auction_id = '0', description = 'Free Wheel Bids', credit = '$won_bids',	debit = '0', created = '".date("Y-m-d h:i:s"). "', modified = '".date("Y-m-d h:i:s"). "' ";
	$run = mysql_query($sql);
}


exit('ll');


?>