<?php
// Include the config file
require_once '../config/config.php';
 

// just incase the database isn't called yet
require_once '../database.php';


if(!empty($_GET['id'])) {
	$aid	= intval($_GET['id']); 
	
	$auction_data = mysql_fetch_array(mysql_query("SELECT 
					a.id,a.price,a.end_time,a.end_time, u.username
					FROM auctions a LEFT JOIN users u ON u.id = a.leader_id 
					WHERE a.id = '$aid'"), MYSQL_ASSOC);
	 
	$datap['id'] = $aid;
	$datap['p'] = number_format($auction_data['price'],2,',','.');
	$datap['u'] = $auction_data['username'];
	$datap['s'] = strtotime($auction_data['end_time']) - time();
	$datap['auto_update'] = 1;
	
	#echo '<pre>';print_r($auction_data);echo '</pre>'; 
	
	//$url = 'http://localhost:3000/push/'; 
	$url = 'https://localhost:3001/push/'; 
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datap));
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$result = curl_exec($ch);
	#echo $datap['s']; 
}

 
 
?>