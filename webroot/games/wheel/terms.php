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

$users = mysql_fetch_array(mysql_query("SELECT spin_credits FROM users WHERE id = '".$_SESSION['Auth']['User']['id']."'"), MYSQL_ASSOC);
$credits = 	$users['spin_credits']; 
if($credits < 0){
$credits = 0;
}		
$credits = 20;
echo "show_popup=0&can_spin=1&user_credit=$credits&user_name=".$_SESSION['Auth']['User']['username']."&time_left=0";

?>