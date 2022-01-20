<?php



function obfRunBeforeFilter(&$th) {
	if(!empty($th->Auth)) {
		$th->Auth->allow('register', 'reset', 'activate', 'tracking', 'admin_user');
	}
}


function obfRunGetEndTime() {
	return date('Y-m-d H:i:s', strtotime('-1 minute'));
}


function obfRunAdminAdd(&$th) {
	if (!empty($th->data)) {
		$th->data['User']['before_password'] = $th->User->generateRandomPassword();
		if ($data = $th->User->register($th->data, true)) {
			$data['User']['password'] = $th->data['User']['before_password'];
			if($th->_sendEmail($data)){
				$th->Session->setFlash(__('The user has been added and their username and password details have been sent to them.', true));
				$th->redirect(array('action' => 'index'));
			}else{
				$th->Session->setFlash(__('Email sending failed. Please try again or contact administrator.', true));
			}
		} else {
			$th->Session->setFlash(__('There was a problem adding the user please review the errors below and try again.', true));
		}
	}
	$th->set('genders', $th->Gender->find('list'));
}


function obfRunIndex(&$th) {
	$th->set('user', $th->User->read(null, $th->Auth->user('id')));

	$userAddress = array();
	foreach($th->User->Address->addressTypes() as $id=>$type) {
		$userAddress[$type] = $th->User->Address->find('first', array('conditions' => array('Address.user_id' => $th->Auth->user('id'), 
																'Address.user_address_type_id' => $id)));
	}
	$th->set('userAddress', $userAddress);

	$th->set('unpaidAuctions', $th->User->Auction->find('count', array('conditions' => array(	'Auction.winner_id' => $th->Auth->user('id'), 
																'Status.id' => 1))));

	$th->pageTitle = __('Dashboard', true);
}













/**
* SPBAS License Validation
*
* @package    Framework
* @author     Andy Rockwell <support@solidphp.com>
* @access private
*/
class licensing
	{
	/**
	* Validate licensing
	* 
	* @param string $api_fingerprint
	* @param string $server 
	* @param string $RPC 
	* @param string $license 
	* @return mixed string on error; array on success
	*/
	function validate_license($api_fingerprint, $server, $RPC, $license)
		{
		$method=false; // not sure why this is called and not set...
		
		//workaround for APC/eAccelerator bug
		if (!class_exists('CakeLog')) {
			require_once(LIBS . 'cake_log.php');
		}
		
		// Check the local key first
		$returned=licensing::parse_xml(licensing::validate_local_key());
//pr($returned);//exit;
		// process the local key 
		if ($returned['status']=='grab_new_key'||$returned['status']=='expired') 
			{
			// go remote to get licensing data
			$returned=licensing::parse_xml(licensing::go_remote($method, $server, $license));
//pr($returned);
			// remote failed, set $returned to invalid
			if (empty($returned)) { $returned['status']="invalid"; }
		
			// we got a good response from the remote. We now need to grab a new
			// local license key and store it somewhere.
			if ($returned['status']=='active'||$returned['status']=='reissued') 
				{
				// grab a remote license key and write it to the correct place
				licensing::go_remote_api($RPC, $api_fingerprint, $license);

				$returned=licensing::parse_xml(licensing::validate_local_key(true)); // pr($returned);
//pr($returned);
				}
			}
		// Process the final status of the license after trying:
		// 
		// 1. local key first
		// 2. going remote for a new key
		// 3. getting a new key from the API
		if ($returned['status']!='active'&&$returned['status']!='reissued') 
			{
			// failed, set $returned to invalid
			if (empty($returned)) { $returned['status']="invalid"; }
		
			$errors=false;
			CakeLog::write('license', 'License invalid - status ('.$returned['status'].')');
			if ($returned['status']=="suspended") 
				{
				$errors=__('This license has been suspended.', true);
				}
			else if ($returned['status']=="pending") 
				{ 
				$errors=__('This license is pending admin approval.', true); 
				}
			else if ($returned['status']=="expired") 
				{ 
				$errors=__('This license is expired.', true); 
				}
			else if ($returned['status']=="renew") 
				{ 
				$errors=$returned['message']; 
				}
			else if ($returned['status']=='active'
				&&strcmp(md5('56d9ce577e79bd83d8f98e2fec53e04a'.$token), $returned['access_token'])!=0)
				{
				$errors=__('This license has an invalid checksum.', true); 
				}
			else { 
				$errors=__('License invalid. Please review the Knowledge Base for information on how to resolve this problem.', true); }
			}
		
		// unset($server, $data, $parser, $values, $tags, $token);
	
		return (@$errors)?@$errors:$returned;
		}

	/**
	* Write the local license key to somewhere.
	* 
	* @param string $local_key		The local key data to write.
	* @return You choose.
	*/
	function store_local_key($local_key) {
		if (!$local_key) {
			CakeLog::write('license', 'Deleted local key, reset?');
			Cache::delete('license_key_'.Configure::read('App.serverName'));
		} else {
			CakeLog::write('license', 'Stored local key: '.$local_key);
			Cache::write('license_key_'.Configure::read('App.serverName'), $local_key, 'week');
		}
	}

	/**
	* Get the local key from where you stored it.
	* 
	* @return string The local license key.
	*/
	function get_stored_local_key()
		{
		//$rs=mysql_fetch_assoc(mysql_query("select `value` from `settings` where `name`='local_license_key'"));
		//return $rs['value'];
		//echo "GOT: ". Cache::read('license_key_'.Configure::read('App.serverName'));
		return Cache::read('license_key_'.Configure::read('App.serverName'), 'week');
		
		}

	/**
	* Write the best remote licensing method
	* 
	* @param string $method Either phpaudit_exec_socket, phpaudit_exec_curl or file_get_contents
	* @return You choose.
	*/
	function write_best_method($method)
		{
		return 'phpaudit_exec_socket';
		}

	/**
	* Get the best remote licensing method previously saved
	* 
	* @return string The saved or default remote call method.
	*/
	function get_best_method()
		{
		return 'phpaudit_exec_socket';
		}

	/**
	* Get license information from the local key
	* 
	* @param string $path_to_key
	* @return array
	*/
	function info($path_to_key)
		{
		$raw_array=licensing::parse_local_key($path_to_key);

		if (!@is_array($raw_array)||$raw_array===false)
			{
			CakeLog::write('license', 'info(): No Local Key');
			return array('status' => false, 
						'expires' => 'Unknown',
						'message' => 'No local key found for this installation. Please login to the client area to get a new key.');
			}

		$local_key_expires=($raw_array[1]=='never')?'Never':date('r', $raw_array[1]);

		if ($raw_array[9]&&@strcmp(@md5("56d9ce577e79bd83d8f98e2fec53e04a".$raw_array[9]), $raw_array[10])!=0)
			{
				CakeLog::write('license', 'info(): custom variables checksum failed');
			return array('status' => false,
						'expires' => $local_key_expires,
						'message' => 'Custom variables checksum failed for this local key.');
			}

		if (@strcmp(@md5("56d9ce577e79bd83d8f98e2fec53e04a".$raw_array[1]), $raw_array[2])!=0)
			{
				CakeLog::write('license', 'info(): expiry checksum failed');
			return array('status' => false,
						'expires' => $local_key_expires,
						'message' => 'License expiry checksum failed for this local key.');
			}

		if ($raw_array[1]<time()&&$raw_array[1]!="never")
			{
				CakeLog::write('license', 'info(): license key is expired');
			return array('status' => false,
						'expires' => $local_key_expires,
						'message' => 'Your local license key has expired.');
			}

		$directory_array=@explode(",", $raw_array[3]);
		$valid_dir=licensing::path_translated();
		$valid_dir=@md5("56d9ce577e79bd83d8f98e2fec53e04a".$valid_dir);
		if (!@in_array($valid_dir, $directory_array))
			{
				CakeLog::write('license', 'info(): bad installation path');
			return array('status' => false,
				'expires' => $local_key_expires,
				'message' => 'Local license key failed to validate the installation path.');
			}

		$host_array=@explode(",", $raw_array[4]);
		if (!@in_array(@md5("56d9ce577e79bd83d8f98e2fec53e04a".$_SERVER['HTTP_HOST']), $host_array))
			{
				CakeLog::write('license', 'info(): bad host address');
			return array('status' => false,
					'expires' => $local_key_expires,
					'message' => 'Local license key failed to validate the host address.');
			}

		$ip_array=@explode(",", $raw_array[5]);
		if (!@in_array(@md5("56d9ce577e79bd83d8f98e2fec53e04a".licensing::server_addr()), $ip_array))
			{
				CakeLog::write('license', 'info(): bad IP');
			return array('status' => false,
					'expires' => $local_key_expires,
					'message' => 'Local license key failed to validate the IP address.');
			}

		return array('status' => true,
					'expires' => $local_key_expires,
					'message' => 'The local license key is valid.');
		}

	/**
	* Validate a local license key
	* 
	* @return boolean $debug
	* @return array The results of validation.
	*/
	function validate_local_key($debug=false)
		{
		// get the local key and parse it into an array
		$raw_array=licensing::parse_local_key();

		if (!@is_array($raw_array)||$raw_array===false)
			{
				CakeLog::write('license', 'validate_local_key(): empty key');
			return "<verify status='grab_new_key' message='The local license key was empty.' />";
			}

		if ($raw_array[9]&&@strcmp(@md5("56d9ce577e79bd83d8f98e2fec53e04a".$raw_array[9]), $raw_array[10])!=0)
			{
				CakeLog::write('license', 'validate_local_key(): tampered');
			return "<verify status='invalid' message='The custom variables were tampered with.' />";
			}
	
		if (@strcmp(@md5("56d9ce577e79bd83d8f98e2fec53e04a".$raw_array[1]), $raw_array[2])!=0)
			{
				CakeLog::write('license', 'validate_local_key(): checksum fail');
			return "<verify status='invalid' message='The local license key checksum failed.' ".$raw_array[9]." />";
			}
	
		if ($raw_array[1]<time()&&$raw_array[1]!="never")
			{
				CakeLog::write('license', 'validate_local_key(): expired/fetching new');
			return "<verify status='expired' message='Fetching a new local key.' ".$raw_array[9]." />";
			}
	
		if ($raw_array[13]&&@strcmp(@md5("56d9ce577e79bd83d8f98e2fec53e04a".$raw_array[13]), $raw_array[14])!=0)
			{
				CakeLog::write('license', 'validate_local_key(): D.C. tampered');
			return "<verify status='invalid' message='The download controls were tampered with.' />";
			}
	
		if ($raw_array[15]&&@strcmp(@md5("56d9ce577e79bd83d8f98e2fec53e04a".$raw_array[15]), $raw_array[16])!=0)
			{
				CakeLog::write('license', 'validate_local_key(): SPBASver tampered');
			return "<verify status='invalid' message='The SPBAS version has been tampered with.' />";
			}
	
		
		$directory_array=@explode(",", $raw_array[3]);
		$valid_dir=licensing::path_translated();
		$valid_dir=@md5("56d9ce577e79bd83d8f98e2fec53e04a".$valid_dir);
		if (!@in_array($valid_dir, $directory_array))
			{
				CakeLog::write('license', 'validate_local_key(): unexpected file path');
			return "<verify status='invalid' message='The file path did not match what was expected.' ".$raw_array[9]." />";
			}
	
		$host_array=@explode(",", $raw_array[4]);
		//if (!@in_array(@md5("56d9ce577e79bd83d8f98e2fec53e04a".$_SERVER['HTTP_HOST']), $host_array))
		//	{
		//	return "<verify status='invalid' message='The hostname did not match was was expected.' ".$raw_array[9]." />";
		//	}
	
		$ip_array=@explode(",", $raw_array[5]);
		$server_addr=licensing::server_addr(); 
		$ip_check=@in_array(@md5("56d9ce577e79bd83d8f98e2fec53e04a".$server_addr), $ip_array);
		if (!$ip_check)
			{
			$server_addr=substr($server_addr, 0, strrpos($server_addr, '.'));
			$ip_check=@in_array(@md5("56d9ce577e79bd83d8f98e2fec53e04a".$server_addr), $ip_array);
			}
	
		if (!$ip_check)
			{
			$server_addr=substr($server_addr, 0, strrpos($server_addr, '.'));
			$ip_check=@in_array(@md5("56d9ce577e79bd83d8f98e2fec53e04a".$server_addr), $ip_array);
			}
	
		if (!$ip_check)
			{
				CakeLog::write('license', 'validate_local_key(): unexpected IP addr');
			return "<verify status='invalid_key' message='The IP address did not match what was expected.' ".$raw_array[9]." />";
			}
	
		return "<verify status='active' message='The license key is valid.' ".$raw_array[9]." />";
		}

	/**
	* Parse the XML
	* 
	* @return array The results the parsed XML.
	*/
	function parse_xml($data)
		{		
		$parser=@xml_parser_create('');
		@xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		@xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		@xml_parse_into_struct($parser, $data, $values, $tags);
		@xml_parser_free($parser);
		
		if (isset($values[0]['attributes'])) {
			return $values[0]['attributes'];
		} else  {
			CakeLog::write('license', 'parse_xml: FAILED');
			return false;
		}
		}

	/**
	* Parse the XML
	* 
	* @return array The results the parsed XML.
	*/
	function get_key()
		{
		// get the local license key
		$data=licensing::get_stored_local_key();
		if (!$data) {  return false; }
	
		// parse out what we don't need
		$buffer=@str_replace("<", "", $data);
		$buffer=@str_replace(">", "", $buffer);
		$buffer=@str_replace("?PHP", "", $buffer);
		$buffer=@str_replace("?", "", $buffer);
		$buffer=@str_replace("/*--", "", $buffer);
		$buffer=@str_replace("--*/", "", $buffer);
	
		return @str_replace("\n", "", $buffer);
		}
	
	/**
	* Parse the cleaned local key string into an array
	* 
	* @return array The results the parsed local key.
	*/
	function parse_local_key()
		{ // die("<textarea>".licensing::get_key()."</textarea>");
		$raw_data=@base64_decode(licensing::get_key()); 
		$raw_array=@explode("|", $raw_data); 
		if (@is_array($raw_array)&&@count($raw_array)<8) { return false; }
	
		return $raw_array;
		}
	
	/**
	* Make a token to be used with DNS Spoof Protection
	* 
	* @return array The token string.
	*/
	function make_token() { return md5('56d9ce577e79bd83d8f98e2fec53e04a'.time()); }
	
	/**
	* Go remote to validate the license using cURL
	* 
	* @param array $array The connection string.
	* @return array The XML results of the request.
	*/
	function phpaudit_exec_curl($array)
		{
		if (!function_exists('curl_init')) return false;

		$array=@explode("?", $array);
	
		$link=curl_init();
		curl_setopt($link, CURLOPT_URL, $array[0]);
		curl_setopt($link, CURLOPT_POSTFIELDS, $array[1]);
		curl_setopt($link, CURLOPT_VERBOSE, 0);
		curl_setopt($link, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($link, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($link, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($link, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($link, CURLOPT_MAXREDIRS, 6);
		curl_setopt($link, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($link, CURLOPT_TIMEOUT, 15); // 60
		$results=curl_exec($link);
		if (curl_errno($link)>0) {
			CakeLog::write('license', 'phpaudit_exec_curl(): curl failed with errorno: '.curl_errno($link));
			curl_close($link);
			return false;
		}
		curl_close($link);
	
		if (@strpos($results, "verify")===false) { 
			CakeLog::write('license', 'phpaudit_exec_curl(): Bad results: '.$results);	
		}
	
		return $results;
		}
	
	/**
	* Go remote to validate the license using fsockopen()
	* 
	* @param string $http_host		ex. phpaudit.com
	* @param string $http_dir		ex. /admin
	* @param string $http_file		ex. /validate_internal.php
	* @param string $querystring	The licensing access data to pass in for validation.
	* @return array The XML results of the request.
	*/
	function phpaudit_exec_socket($http_host, $http_dir, $http_file, $querystring)
		{
		$fp=@fsockopen($http_host, 80, $errno, $errstr, 10); // was 5
		if (!$fp) { 
			CakeLog::write('license', 'phpaudit_exec_socket(): Couldnt fsockopen: error '.$errno.'/'.$errstr);
			return false; 
		}

		// build the headers to use
		$header="POST {$http_dir}{$http_file} HTTP/1.0\r\n";
		$header.="Host: {$http_host}\r\n";
		$header.="Content-type: application/x-www-form-urlencoded\r\n";
		$header.="User-Agent: SolidPHP Business Automation Software (SPBAS) (http://www.spbas.com)\r\n";
		$header.="Content-length: ".@strlen($querystring)."\r\n";
		$header.="Connection: close\r\n\r\n";
		$header.=$querystring;

		// handle the session
		$data=false;
		if (@function_exists('stream_set_timeout')) { stream_set_timeout($fp, 20); }
		if (!fputs($fp, $header)) {
			CakeLog::write('license', 'phpaudit_exec_socket(): fputs failed ');
		}

		if (@function_exists('socket_get_status')) { $status=@socket_get_status($fp); } 
		else { $status=true; }

		while (!@feof($fp)&&$status) 
			{
			$data.=@fgets($fp, 1024);

			if (@function_exists('socket_get_status')) { $status=@socket_get_status($fp); } 
			else 
				{
				if (@feof($fp)==true) { $status=false; } 
				else { $status=true; }
				}
			}

		@fclose ($fp);

		// uncomment to debug the return
		// echo("<textarea rows='10' cols='100'>".$data."</textarea>"); 

		// we had a bad header response
		if (!strpos($data, '200')) { return false; }
		
		// the response was empty, something went wrong
		if (!$data) { return false; }

		// separate the header from the validation XML
		$data=@explode("\r\n\r\n", $data, 2);

		// no validation XML was returned!
		if (!$data[1]) { return false; }

		// We have something returned, but it's not what is expected
		if (@strpos($data[1], 'verify')===false) { 
			CakeLog::write('license', 'phpaudit_exec_socket(): bad return value: '.$data[1]);
			return false; 
		}

		// return the XML validation string
		return $data[1];
		}
	
	/**
	* Get the directory path
	* 
	* @return string The directory path.
	*/
	function path_translated()
		{
		$option=array('PATH_TRANSLATED', 
					'ORIG_PATH_TRANSLATED', 
					'SCRIPT_FILENAME', 
					'DOCUMENT_ROOT',
					'APPL_PHYSICAL_PATH');

		foreach ($option as $key)
			{
			if (!isset($_SERVER[$key])||strlen(trim($_SERVER[$key]))<=0) { continue; }

			// if (@substr(php_uname(), 0, 7)=='Windows')
			if (@substr(php_uname(), 0, 7)=='Windows'&&strpos($_SERVER[$key], '\\'))
				{
				return  @substr($_SERVER[$key], 0, @strrpos($_SERVER[$key], '\\'));
				}
			
			return  @substr($_SERVER[$key], 0, @strrpos($_SERVER[$key], '/'));
			}

		// return false;
		return 'Directory path could be determined.';
		}
	
	/**
	* Get the IP address
	* 
	* @return string The IP address.
	*/
	function server_addr()
		{
		$options=array('SERVER_ADDR', 'LOCAL_ADDR');
		foreach ($options as $key)
			{
			if (isset($_SERVER[$key])) { return $_SERVER[$key]; }
			}

		//return false;
		return 'IP could be determined.';
		}

	/**
	* Make a remote call to the licensing server.
	* 
	* @param string $method	The licensing method to use.
	* @param string $server	The server URL to use
	* @param string $license	The license key to validate.
	* @return string The XML validation string.
	*/
	function go_remote($method, $server, $license)
		{
		$methods=@$GLOBALS['methods'];

		// if we have a previously stored license method, use that first
		if ($method)
			{
			unset($methods[$method]);
			$methods[]=$method;
			$methods=array_reverse($methods);
			}

		// build a querystring of the licensing data
		$enable_dns_spoof='yes';
		$query_string="license={$license}";
		$query_string.="&access_directory=".licensing::path_translated();
		$query_string.="&access_ip=".licensing::server_addr();
		$query_string.="&access_host={$_SERVER['HTTP_HOST']}";
		$query_string.='&access_token=';
		$query_string.=$token=licensing::make_token();

		// loop all licensing methods and break on the first that returns $data
		$data=false;
		foreach(array('phpaudit_exec_socket', 'phpaudit_exec_curl', 'file_get_contents') as $license_method) 
			{
			// break the $server string into parts
			$sinfo=@parse_url($server);
	
			// try fsockopen()
			if ($license_method=='phpaudit_exec_socket'&&!$data)
				{
				$data=@licensing::phpaudit_exec_socket($sinfo['host'], $sinfo['path'], '/validate_internal.php', $query_string);
				}
	
			// try cURL
			if ($license_method=='phpaudit_exec_curl'&&!$data)
				{
				$data=@licensing::phpaudit_exec_curl("{$server}/validate_internal.php?{$query_string}");
				}
	
			// try using the fopen() wrappers
			if ($license_method=='file_get_contents'&&!$data)
				{
					if (!$data=@file_get_contents("{$server}validate_internal.php?{$query_string}")) {
						CakeLog::write('license', 'go_remote(): file_get_contents failed');
					}
				}

			// we have data, break out of the loop
			if ($data) 
				{ 
				// write the method which was successful first
				licensing::write_best_method($license_method);
				break; 
				}
			}

		return $data; // the licensing data
		}

	/**
	* Make a remote call to the licensing server.
	* 
	* @param string $RPC				The URL to the admin rpc.php file.
	* @param string $api_fingerprint	The API fingerprint to use.
	* @param string $license			The license key to validate.
	* @return string The local key string.
	*/
	function go_remote_api($RPC, $api_fingerprint, $license)
		{
		$use=parse_url($RPC);
		$fp=@fsockopen($use['host'], 80, $errno, $errstr, 10); // was 5
		if (!$fp) { 
			CakeLog::write('license', 'go_remote_api(): fsockopen() failed: '.$errno.'/'.$errstr);
			return false; 
		}

		// build the headers to use
		$header="POST {$use['path']} HTTP/1.0\r\n";
		$header.="Host: {$use['host']}\r\n";
		$header.="Content-type: application/x-www-form-urlencoded\r\n";
		$header.="User-Agent: SolidPHP Business Automation Software (SPBAS) (http://www.spbas.com)\r\n";
		$header.="Content-length: ".@strlen($querystring="mod=license&task=get_local_key&api_key={$api_fingerprint}&license_key={$license}")."\r\n";
		$header.="Connection: close\r\n\r\n";
		$header.=$querystring;

		// handle the session
		$local_key='';
		if (@function_exists('stream_set_timeout')) { stream_set_timeout($fp, 20); }
		if (!@fputs($fp, $header)) {
			CakeLog::write('license', 'go_remote_api(): fputs failed');
		}

		if (@function_exists('socket_get_status')) { $status=@socket_get_status($fp); } 
		else { $status=true; }

		while (!@feof($fp)&&$status) 
			{
			$local_key.=@fgets($fp, 1024);

			if (@function_exists('socket_get_status')) { $status=@socket_get_status($fp); } 
			else 
				{
				if (@feof($fp)==true) { $status=false; } 
				else { $status=true; }
				}
			}

		@fclose ($fp);
		// echo "<textarea rows='100' cols='100'>{$local_key}</textarea>"; die;
		$local_key=@explode("\r\n\r\n", $local_key, 2);

		// uncomment to debug the return
		// echo "<textarea rows='100' cols='100'>".var_export($local_key, 1)."</textarea>"; die;

		licensing::store_local_key($local_key[1]);

		return $local_key[1];
		}
	}
?>