<?php 
########## Google Settings.. Client ID, Client Secret from https://cloud.google.com/console #############
$google_client_id       = '26589798334-s9sfj8va397p61q1sv4fgk4r4lr79esk.apps.googleusercontent.com';
$google_client_secret   = 'b-IuD_L1bW_Cl_cdUvajcTpV';
$google_redirect_url    = 'http://pujon.co?g_login=1'; //path to your script 
$google_developer_key   = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx';



include_once $_SERVER['DOCUMENT_ROOT']."/vendors/google/src/Google_Client.php";
include_once $_SERVER['DOCUMENT_ROOT']."/vendors/google/src/contrib/Google_Oauth2Service.php";



//start session
session_start();

$gClient = new Google_Client();
$gClient->setApplicationName('propenny');
$gClient->setClientId($google_client_id);
$gClient->setClientSecret($google_client_secret);
$gClient->setRedirectUri($google_redirect_url);
$gClient->setDeveloperKey($google_developer_key);

$google_oauthV2 = new Google_Oauth2Service($gClient);

//If user wish to log out, we just unset Session variable
if (isset($_REQUEST['reset']))  
{
  unset($_SESSION['token']);
  $gClient->revokeToken();
  header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
}

//If code is empty, redirect user to google authentication page for code.
//Code is required to aquire Access Token from google
//Once we have access token, assign token to session variable
//and we can redirect user back to page and login.
if (isset($_GET['code'])) 
{ 
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
    return;
}


if (isset($_SESSION['token'])) 
{ 
    $gClient->setAccessToken($_SESSION['token']);
}


if ($gClient->getAccessToken()) 
{
      //For logged in user, get details from google using access token
      $user                 = $google_oauthV2->userinfo->get(); 
      $user_id              = $user['id'];
      $user_name            = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
      $email                = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
      $profile_url          = filter_var($user['link'], FILTER_VALIDATE_URL);
      $profile_image_url    = filter_var($user['picture'], FILTER_VALIDATE_URL);
      $personMarkup         = "$email<div><img src='$profile_image_url?sz=50'></div>";
      $_SESSION['token']    = $gClient->getAccessToken();
	  
	  
	   /*echo '<pre>'; 
    print_r($user);
    echo '</pre>'; exit; */
	
	
}
else 
{
    //For Guest user, get google login url
    $authUrl = $gClient->createAuthUrl();
}



if(isset($authUrl)) //user is not logged in, show login button
{
   
} 
else // user logged in 
{
	
	if (!function_exists('_getUnique_userName')) {
		function _getUnique_userName($name=null, $resursive_call=null){
			$username = $name;
			if($resursive_call == 1){
				$username = $name. rand(1,999);
			}
			$sql = "SELECT id FROM users WHERE username = '$username' ";
			$runnung = mysql_query($sql);
			$res_count = mysql_num_rows($runnung);
			if($res_count == 0){
				return $username;
			}else{
				$username = _getUnique_userName($name, 1);
				return $username;
			}
		}
	}
	
	if ($user && !$session->check('Auth.User') && $this->params['action'] != 'logout' && $this->params['action'] != 'login'  ) {
	$sql = 'SELECT id from users where email = "'.$email.'"';
	$run = mysql_query($sql);
	$res = mysql_fetch_array($run,MYSQL_ASSOC);
	$user_id = $res['id']; 
	if($user_id != ''){ 
		//header("Location: http://sapomartelo.com.br/auctions/login/$id");
		//exit("Location: http://sapomartelo.com.br/auctions/index/$id");
	}else{ 
		$key = rand(1999,9999999999999999).$user['given_name'];
		//$username = $user['first_name'].rand(1,99);
		$username = _getUnique_userName(strtolower($user['given_name']));
		$sql_insert = 'INSERT INTO users SET email = "'.$user['email'].'" ,
									  username = "'.$username.'" ,
									  first_name = "'.$user['given_name'].'" ,
									  last_name = "'.$user['Patidar'].'" ,
									  profile_image = "'.$user['picture'].'" ,
									  active = "1" , 
									  fb_user = "0" , 
									  google_user = "1" , 
									  `key` = "'.$key.'" , 
									  admin = "0" , 
									  ip = "'.$_SERVER['REMOTE_ADDR'].'" ,
									  created = "'.$created.'" ,
									  modified = "'.$created.'" ,
									 
									  password = "'.Security::hash('Ajay123', null, true).'"
			  ';
		$run_insert = mysql_query($sql_insert) or die(mysql_error());
		$user_id = mysql_insert_id(); 
		
		$setting1 = mysql_fetch_array(mysql_query("SELECT value FROM settings WHERE name = 'free_registeration_bids'"), MYSQL_ASSOC);
		$setting = $setting1['value'];
		
		$sql_bids = "INSERT INTO bids SET user_id = '".$user_id."', credit = '".$setting."', description = 'Free Registration bids' , created = '".date('Y-m-d H:i:s') ."'  , modified = '".date('Y-m-d H:i:s') ."' ";
		mysql_query($sql_bids) or die(mysql_error());
		
		 
		
		 
	}
	
		$sql = 'SELECT  username, password from users where id = "'.$user_id.'"';
		$run = mysql_query($sql);
		$res = mysql_fetch_array($run,MYSQL_ASSOC);
		$username = $res['username'];
		$password = $res['password'];
		
		//echo '<pre>'; print_r($this->params); echo '</pre>'; exit;
		
	
		$login_html = '<html><body><form id="UserLoginForm1" id="UserLoginForm1" method="post" action="/users/login"><input name="data[User][username]" type="hidden" maxlength="40" value="'.$username.'" id="UserUsername"><input type="hidden" name="data[User][password]" value="'.$password.'" ><input type="hidden" name="data[User][autologin_fb]" value="1" ></form>';
		$login_html .= '<script type="text/javascript"> document.getElementById("UserLoginForm1").submit();  </script></body></html>';
		echo $login_html; exit();
  
  
    $user_exist = $mysqli->query("SELECT COUNT(google_id) as usercount FROM google_users WHERE google_id=$user_id")->fetch_object()->usercount; 
    if($user_exist)
    {
        echo 'Welcome back '.$user_name.'!';
    }else{ 
        //user is new
        echo 'Hi '.$user_name.', Thanks for Registering!';
        $mysqli->query("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) 
        VALUES ($user_id, '$user_name','$email','$profile_url','$profile_image_url')");
    }

    
    /*echo '<br /><a href="'.$profile_url.'" target="_blank"><img src="'.$profile_image_url.'?sz=100" /></a>';
    echo '<br /><a class="logout" href="?reset=1">Logout</a>';
    echo '<pre>'; 
    print_r($user);
    echo '</pre>'; */ 
}
 



?>	
	 
		 


		 
         <?php }   

		 
if(isset($authUrl) && $this->params['action'] == 'login' || 1) {
	echo '<a class="login" href="'.$authUrl.'"><img  src="/img/button/google_login.png" /></a>';
}else{
	echo '<a class="login" href="/?google_login=1"><img src="/img/button/google_login.png" /></a>';
} 
?>