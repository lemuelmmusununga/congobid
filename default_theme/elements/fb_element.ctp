<div id="fb-root"></div>
 
<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/vendors/fb/fbmain.php"; 

?>	
	<div id="fb-root"></div>
 <script type="text/javascript">
            function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){        
                FB.ui({ method : 'feed', 
                        message: userPrompt,
                        link   :  hrefLink,
                        caption:  hrefTitle,
                        picture: '/img/logo/logo.png'
               });

            }
           
        </script>
		<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
		 <script type="text/javascript">
		   FB.init({
			 appId  : '<?=$fbconfig['appid']?>',
			 status : true, // check login status
			 cookie : true, // enable cookies to allow the server to access the session
			 xfbml  : true  // parse XFBML
		   });
		   
		     /* All the events registered */
			FB.Event.subscribe('auth.login', function(response) {
				// do something with response
				login();
			});
			FB.Event.subscribe('auth.logout', function(response) {
				// do something with response
				logout();
			});
			
			function login(){
                document.location.href = "<?='/?login'?>";
            }
            function logout(){
              
            }
		   
		 </script>
		 

 <?php
	
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
	$sql = 'SELECT id from users where email = "'.$user->email.'"';
	$run = mysql_query($sql);
	$res = mysql_fetch_array($run,MYSQL_ASSOC);
	$user_id = $res['id']; 
	if($user_id != ''){ 
		 
	}else{ 
		$key = rand(1999,9999999999999999).$user->first_name ;
		 
		$username = _getUnique_userName(strtolower( $user->first_name ));
		$sql_insert = 'INSERT INTO users SET email = "'.$user->email .'" ,
									  username = "'.$username.'" ,
									  first_name = "'.$user->first_name.'" ,
									  last_name = "'.$user->first_name.'" ,
									  active = "1" , 
									  fb_user = "1" , 
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

	?>
         <?php } ?>  
<?php if (!$user && !$session->check('Auth.User')) {  
 echo  $fb_login_link ;
  } ?> 