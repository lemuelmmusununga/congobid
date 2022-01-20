<?php
// include script with functions
include 'plugin_Ecom.php';
// getting response with given parameters
$response = getorderStatus('GetOrderStatus','EN','TEST_ECOM51','22791','8E1BBB29D87473148F2BBA609D1E13FF');
echo $response;
?>