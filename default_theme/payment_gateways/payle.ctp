 

			<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// include script with functions
include $_SERVER['DOCUMENT_ROOT'].'/webroot/pay/plugin_Ecom.php';
// getting response with given parameters
$response = createOrder('CreateOrder',
						'EN',
						'CONGOBID', // provide your merchant ID TEST_ECOM321
						$payle['amount'], // amount example this 123456 is treated like 1234.56
						'840', // currency 978 is for EUR, 976 for CDF and 936 for GHS 840 = usd
						$payle['key'].'@'.$payle['item_name'], //description
						'https://www.congobid.com/payment_gateways/payle_ipn', // approve
						'https://www.congobid.com/packages/index/1', // cancle
						'https://www.congobid.com/payment_gateways/payle_ipn',  // decline
						'Purchase',
						$payle['key']);
echo '<pre>';print_r($response);echo '</pre>'; exit;
?>
