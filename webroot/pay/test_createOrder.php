<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// include script with functions
include 'plugin_Ecom.php';
// getting response with given parameters
$response = createOrder('CreateOrder',
						'EN',
						'TEST_ECOM321', // provide your merchant ID
						'123456', // amount example this 123456 is treated like 1234.56
						'978', // currency 978 is for EUR, 976 for CDF and 936 for GHS
						'Dummy description',
						'https://preview.congobid.com/payment_gateways/payle_ipn', // approve
						'https://preview.congobid.com/packages/index/1', // cancle
						'https://preview.congobid.com/payment_gateways/payle_ipn',  // decline
						'Purchase',
						'3');
echo '<pre>';print_r($response);echo '</pre>'; exit;
?>