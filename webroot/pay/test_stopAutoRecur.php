<?php
// include script with functions
include 'plugin_Ecom.php';
// getting response with given parameters
$response = stopAutoRecur('StopAutoRecurPayment','EN','TEST_ECOM51','22808','DCE50D7206ACEF424AF3278394675ECC');
echo $response;
?>