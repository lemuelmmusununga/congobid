<?php
// Include the config file
require_once '../config/config.php';
 

// just incase the database isn't called yet
require_once '../database.php';


if(1) {
	 
	$date_now = date('Y-m-d H:i:s');
	$strtotime_extnd = ( strtotime($date_now) + ( 60 ) ); //time    86400 * 1 
	$newExtendeddate = date('Y-m-d H:i:s',$strtotime_extnd);
	
	$sql = "SELECT 
	a.id,a.price,a.end_time,u.username
	FROM auctions a LEFT JOIN users u ON u.id = a.leader_id 
	WHERE a.closed = 0 AND a.deleted = 0 AND a.end_time > '".$date_now."' AND   a.end_time < '".$newExtendeddate."' ORDER BY a.end_time ASC  ";
	$auction_data_sql = mysqli_query($db,$sql) or die(mysql_error());
 
 
	 
	while($auction_data = mysqli_fetch_array( $auction_data_sql ) ){ 
		$datap = array();
		$datap['id'] = $auction_data['id'];
		$datap['p'] = $auction_data['price'];
		$datap['u'] = $auction_data['username'];
		$datap['s'] = strtotime($auction_data['end_time']) - time();
		$datap['auto_update'] = 1;
		 echo '<pre>';print_r($datap);echo '</pre>';  
		 echo '<pre>';print_r($auction_data);echo '</pre>';  
		 $url = 'https://localhost:3001/push/'; 
		//$url = 'https://www.bidealo.com:3001/push/'; 
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datap));
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$result = curl_exec($ch);
		echo $datap['s']; 
	}
}

 exit('l');
 
?>