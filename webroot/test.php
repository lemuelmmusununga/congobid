<?php 

$url = 'https://cdn-api.co-vin.in/api/v2/appointment/sessions/calendarByPin?pincode=452012&date=11-05-2021';

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	//Execute the request
	$result = curl_exec($ch);
echo '<pre> url: ';print_r($result);echo '</pre>'; exit;



?>