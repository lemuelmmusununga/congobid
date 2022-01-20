<?php
// include script with functions
include 'plugin_Ecom.php';
// getting response with given parameters
$response = createRecurPayment('CreateOrder','EN','TEST_ECOM51','123456','978','Dummy description','http://#.com/testing/?response=approve','http://#.com/testing/?response=cancel','http://#.com/testing/?response=decline','23','20180910','00-30-00-00-0000','','Purchase');

?>