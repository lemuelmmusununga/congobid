<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once('/var/www/html/database.php');
require_once('./header_incluede.php');
 
	$message="";

	$success = false;

	$error = false;

	if($_GET['user_id'] !=''){
		$user_id = $_GET['user_id'];
		$bids = $_GET['bids'];
		$action = $_GET['action'];
		$password = $_GET['password'];
	}else{
		$user_id = $_POST['user_id'];
		$pid = $_POST['bids'];
		$action = $_POST['action'];
		$password = $_GET['password'];
	}

	// $action = 'add';
	// $bids = '5';
	// $user_id = 1;
	$pass = md5(date('Y-m-d'));
	if($pass != $password){
		$return['msg'] = 'Invalid Password, Please try again with correct password';
		echo  json_encode($return,JSON_FORCE_OBJECT);
	}

	function getBalance($uid){
		global $db;
		$sql_balance   = "SELECT bid_balance  FROM users  WHERE id = '$uid'   ";
		$sql_balanceRun  = mysqli_fetch_array( mysqli_query($db,$sql_balance), MYSQLI_ASSOC ) ;
		$user_balance = $sql_balanceRun['bid_balance'] ;
		return $user_balance;
	}

	if($action == 'balance' || 1){
		 $user_balance = getBalance($user_id);
 	}

	if($action == 'add'){
		$new_balance = $user_balance + $bids ;
		$sql_balance   = "UPDATE users  SET bid_balance = $new_balance WHERE id =  $user_id  ";
		$sql_balance1   = "INSERT INTO bids  SET user_id =  $user_id, description='Api Bids '  ";
		$sql_balanceRun  =  mysqli_query( $db,$sql_balance)  ;

		$return['msg'] = 'Bids updated successfully';
		$return['old_balance'] = $user_balance;
		$return['new_balance'] = getBalance($user_id);
		$return['bids'] = $bids;
		$return['user_id'] = $user_id;
		
		echo  json_encode($return,JSON_FORCE_OBJECT);
	}


 

 

  
	exit;

?>

