<?php

require_once('..' . DS .'controllers' . DS .'users_module2.php');

function obfGetBeforeFilter(&$th) {
	obfRunBeforeFilter($th);
}

function obfGetIndex(&$th) {
	obfRunIndex($th);
}

function obfGetGetEndTime() {
	return obfRunGetEndTime();
}

function obfGetAdminAdd(&$th) {
	return obfRunAdminAdd($th);
}


function obfGetLicensing(&$th) {
	 
	
	return true;
}

?>