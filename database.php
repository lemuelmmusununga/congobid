<?php
// if(empty($config) || 1) {
// 	require 'config/config.php';
// }
require 'config/config.php';
 
// Make a connection
//if(!$db = @mysql_connect($config['Database']['host'], $config['Database']['login'], $config['Database']['password'])) {
if(!$db = @mysqli_connect($config['Database']['host'], $config['Database']['login'], $config['Database']['password'], $config['Database']['database'] ) ) {
	 die('Unable to connect to the database.');

}

// Select database
/*
if(!@mysql_select_db($config['Database']['database'], $db)) {
	die("Unable to find the database");
}
*/
?>