<?php
// Include the config file
require_once '../../../config/config.php';


// NORMAL BIDDING
// Reading session id from cookie
if(!empty($_COOKIE['AUCTION'])){
	$sessionId = $_COOKIE['AUCTION'];
	session_id($sessionId);
}

// Starting session
session_start();
require_once '../../../database.php';


echo "show_popup=1&can_spin=1&user_credit=5&user_name=".$_SESSION['Auth']['User']['username']."&time_left=0";

?>