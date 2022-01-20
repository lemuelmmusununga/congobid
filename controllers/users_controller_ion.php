<?php

require_once('..' . DS .'controllers' . DS .'users_module1.php');

class UsersController extends AppController {

	var $name = 'Users';
	var $restricted_users_delete = array(1);
	var $uses = array('User', 'Setting', 'Gender');
	var $helpers = array('Recaptcha');
	var $components = array('Recaptcha', 'PhpBB3');

	function beforeFilter(){
		parent::beforeFilter();
		
		obfGetBeforeFilter($this);
	}
	
	function api(){ 
		/*#$api_user_info = mysql_fetch_array(mysql_query("SELECT value FROM settings WHERE name = 'api_username' "), MYSQL_ASSOC);
		#$api_sig_info = mysql_fetch_array(mysql_query("SELECT value FROM settings WHERE name = 'api_signature' "), MYSQL_ASSOC);
		//  FRODE1350 / AJAP%*/
		
		$api_username = $_GET['u'];
		$api_signature = $_GET['sig'];
		
		$api_auth = mysql_fetch_array(mysql_query("SELECT id,username,password FROM merchants WHERE username = '$api_username' AND password = '$api_signature' AND status = 1     "), MYSQL_ASSOC);
		
		$error = 0;
		
		/*if($api_username == $api_user_info['value'] && $api_signature == $api_sig_info['value'] ){*/
		if(!empty($api_auth)){
			$mer_id 	= $api_auth['id'];
			
			$username 	= urldecode($_GET['username']);
			$sponsor 	= urldecode($_GET['sponsor']);
			$fn 		= urldecode($_GET['fn']);
			$ln 		= urldecode($_GET['ln']);
			$email 		= urldecode($_GET['email']);
			
			$username 	= utf8_encode($username);
			$sponsor 	= utf8_encode($sponsor);
			$fn 		= utf8_encode($fn);
			$ln 		= utf8_encode($ln);
			$email 		= utf8_encode($email);
			
			$password 	= md5($_GET['password']);
			
			$bids 		= $this->appConfigurations['registration_bids'];
				
			//echo $username; exit;
			 
			if($username != '' && $password != '' && $email != ''){
				
				$username_check = $this->User->findByUsername($username);
				if(!empty($username_check)){
					$message['error_code'] = 03;
					$message['error_message'] = 'Username already exist';
					$error = 1;
				}
				$email_check = $this->User->findByEmail($email);
				if(!empty($email_check)){
					$message['error_code'] = 04;
					$message['error_message'] = 'email already exist';
					$error = 1;
				}
				
				if($error == 0){
					$sql =  'INSERT INTO users SET username = "'.$username.'", mer_id = "'.$mer_id.'", last_name = "'.$ln.'", first_name = "'.$fn.'", password="'.$password.'" , email="'.$email.'", sponsor="'.$sponsor.'", active="1" , from_bidify="1", newsletter="1", created=NOW(), modified=NOW() ';

					mysql_query($sql) or die(mysql_error());
					$user_id = mysql_insert_id();
					if($bids > 0){
						mysql_query("INSERT INTO bids SET user_id = '$user_id', credit='$bids', description='Signup Bids'  ") or die(mysql_error());
					}
					$message['SUCCESS'] = 1;
					$message['user_id_registered'] = $user_id;
					
					if($this->appConfigurations['api_email_welcome'] == true){
						$user = $this->User->findById($user_id);
						$data['template'] = 'users/welcome_api';
						$data['layout']   = 'default';
						$data['to'] 	  = $user['User']['email'];
						$data['subject']  = sprintf(__('Thank you for joining %s', true), Configure::read('Site.name'));
						$data['User']	  = $user['User'];
						$data['User']['password']	  = $_GET['password'];
						$this->set('data', $data);
						$this->_sendEmail($data);
					}
					
				}
			
			}else{
				
				$message['error_code'] = 02;
				$message['error_message'] = 'Invaild data supplied';
			}
			
			
		}else{
			$message['error_code'] = 01;
			$message['error_message'] = 'Message api login incorrect.';
		}
		
		/*echo '<pre>';print_r($_GET);echo '</pre>';
		echo '<pre>';print_r($message);echo '</pre>';  */
		echo  json_encode($message);
		
		exit();
	}
	
	function api_email_check(){
		#$api_user_info = mysql_fetch_array(mysql_query("SELECT value FROM settings WHERE name = 'api_username' "), MYSQL_ASSOC);
		#$api_sig_info = mysql_fetch_array(mysql_query("SELECT value FROM settings WHERE name = 'api_signature' "), MYSQL_ASSOC);
		//  FRODE1350 / AJAP%
		
		$api_username = $_GET['u'];
		$api_signature = $_GET['sig'];
		
		
		$api_auth = mysql_fetch_array(mysql_query("SELECT username,password FROM merchants WHERE username = '$api_username' AND password = '$api_signature' AND status = 1     "), MYSQL_ASSOC);
		
		$error = 0;
		
		/*if($api_username == $api_user_info['value'] && $api_signature == $api_sig_info['value'] ){*/
		if(!empty($api_auth)){
			$email = $_GET['email'];
			if($email != ''){
				$email_check = $this->User->findByEmail($email);
				if(!empty($email_check)){
					$message['response'] = 1;
				}else{
					$message['response'] = 0;
				}
				
			}else{
				$message['response'] = 0;
			}
		}else{
			$message['error_code'] = 01;
			$message['error_message'] = 'Message api login incorrect';
		}
		
		echo  json_encode($message);
		
		exit();
	}
	
	function api_user_check(){ 
		#$api_user_info = mysql_fetch_array(mysql_query("SELECT value FROM settings WHERE name = 'api_username' "), MYSQL_ASSOC);
		#$api_sig_info = mysql_fetch_array(mysql_query("SELECT value FROM settings WHERE name = 'api_signature' "), MYSQL_ASSOC);
		//  FRODE1350 / AJAP%
		
		$api_username = $_GET['u'];
		$api_signature = $_GET['sig'];
		
		
		$api_auth = mysql_fetch_array(mysql_query("SELECT username,password FROM merchants WHERE username = '$api_username' AND password = '$api_signature' AND status = 1     "), MYSQL_ASSOC);
		
		$error = 0;
		
		/*if($api_username == $api_user_info['value'] && $api_signature == $api_sig_info['value'] ){*/
		if(!empty($api_auth)){
			$username = $_GET['username'];
			if($username != ''){
				$username_check = $this->User->findByUsername($username);
				if(!empty($username_check)){
					$message['response'] = 1;
				}else{
					$message['response'] = 0;
				}
			}else{
				$message['response'] = 0;
			}
		}else{
			$message['error_code'] = 01;
			$message['error_message'] = 'Message api login incorrect';
		}
		
		echo  json_encode($message);
		
		exit();
	}
	
	function api_count_sponsor(){ 
		#$api_user_info = mysql_fetch_array(mysql_query("SELECT value FROM settings WHERE name = 'api_username' "), MYSQL_ASSOC);
		#$api_sig_info = mysql_fetch_array(mysql_query("SELECT value FROM settings WHERE name = 'api_signature' "), MYSQL_ASSOC);
		//  FRODE1350 / AJAP%
		
		$api_username = $_GET['u'];
		$api_signature = $_GET['sig'];
		
		
		$api_auth = mysql_fetch_array(mysql_query("SELECT username,password FROM merchants WHERE username = '$api_username' AND password = '$api_signature' AND status = 1     "), MYSQL_ASSOC);
		
		$error = 0;
		
		/*if($api_username == $api_user_info['value'] && $api_signature == $api_sig_info['value'] ){*/
		if(!empty($api_auth)){
			$username = $_GET['username'];
			if($username != ''){
				$username_check = $this->User->find('count',array('conditions'=> array('User.sponsor' => $username ) ));
				if(!empty($username_check)){
					$message['response'] = $username_check;
				}else{
					$message['response'] = 0;
				}
			}else{
				$message['response'] = 0;
			}
		}else{
			$message['error_code'] = 01;
			$message['error_message'] = 'Message api login incorrect';
		}
		
		echo  json_encode($message);
		
		exit();
	}
	
	
	 
	
	       
	function _income($payment_gateway_id, $start_date, $end_date, $sell_back_percent=null){
		
		if($payment_gateway_id > 0) {
			#$payment_gateway_condition = "   ";
		}
		$fields = "SUM(price) as income";
		if($sell_back_percent == 1) {
			$fields = "SUM(sell_back_per) as income";
		}
		
		$query  = "SELECT $fields FROM accounts WHERE created > '$start_date' AND created < '$end_date' AND payment_gateway_id = '$payment_gateway_id' ";
		$result = mysql_fetch_array(mysql_query($query), MYSQL_ASSOC);
		return $result['income'];
		
	}

	function login() {

		$returned=obfGetLicensing($this);
		
		if($returned===FALSE) {
			// Deleting remember me cookie if it exists
			if($this->Cookie->read('User.id')){
				$this->Cookie->del('User.id');
				$this->Cookie->del('User.pass');
			}
			
			// Deleting getstatus cookie if it exists
			if($this->Cookie->read('user_id')){
				$this->Cookie->del('user_id');
			}
		
			$this->Session->delete('Auth.User');
			unset($this->data['User']['password']);
			$this->render();
			$this->Auth->logout();
			return;
			
		} elseif(!empty($this->data)) {
			eval(AddonManager::hook('controllers_users_login'));
			
		} else {
			if(!empty($this->appConfigurations['sslUrl'])) {
				if(empty($_SERVER['HTTPS'])) {
					$this->redirect($this->appConfigurations['sslUrl'].'/users/login');
				}
			}
			
			$id = $this->Auth->user('id');
			if(!empty($id)) {
				if(!empty($this->appConfigurations['sslUrl'])) {
					$this->redirect($this->appConfigurations['url'].'/users');
				} else {
					$this->redirect(array('action' => 'index'));
				}
			}
		}
		$this->pageTitle = __('Login', true);
		unset($this->data['User']['password']);
	}

	function logout() {
		eval(AddonManager::hook('controllers_users_logout'));
	}

	function index() {
		eval(AddonManager::hook('controllers_users_index'));
		//$this->set('cash_balance', $this->User->Credit->balance($this->Auth->user('id')));
	}

	function reset(){
		if (Configure::read('SCD') && Configure::read('SCD.isSCD')===true) {
			return false;
		}
		
		eval(AddonManager::hook('controllers_users_reset'));
	}

	function activate($key){
		eval(AddonManager::hook('controllers_users_activate'));
	}

	function register($referrer = null) {
		$site_ref = explode('/',$this->params['url']['url']);
		if($site_ref[0] == 'site'){	
			if($referrer != ''){  
				$this->Session->write("referrer",$referrer);
				$this->redirect('/?rf='.$referrer);
			}
		}
		
		if(!empty($this->appConfigurations['registerOff'])) {
			$this->Session->setFlash(__('Registration has been turned off.', true), 'default', array('class' => 'message'));
			$this->redirect(array('controller' => 'auctions', 'action'=>'home'));
		}
		
		if (!empty($this->data)) {
			if($this->Recaptcha->isValid() || Configure::read('Recaptcha.enabled') == false) {
				eval(AddonManager::hook('controllers_users_register'));
			}else{
				$this->Session->setFlash(__('The captcha form was not valid, please try again.', true), 'default', array('class' => 'message'));
				$this->set('recaptchaError', $this->Recaptcha->error);
			}
		} else {
			if(!empty($this->appConfigurations['sslUrl'])) {
				if(empty($_SERVER['HTTPS'])) {
					$this->redirect($this->appConfigurations['sslUrl'].'/users/register/'.$referrer);
				}
			}
			
			$id = $this->Auth->user('id');
			if(!empty($id)) {
				if(!empty($this->appConfigurations['sslUrl'])) {
					$this->redirect($this->appConfigurations['url'].'/users');
				} else {
					$this->redirect(array('action' => 'index'));
				}
			}
			if($referrer != ''){ 
				$this->Session->write("referrer",$referrer);
			}
			$this->data['User']['referrer'] = $this->Session->read("referrer");
			
			if(!empty($this->appConfigurations['newsletterSelected'])) {
				$this->data['User']['newsletter'] = 1;
			}

			if(!empty($this->appConfigurations['ipBlock'])) {
				// lets make sure that the IP address has not been used before the set number of times
				if(!empty($_SERVER['REMOTE_ADDR'])) {
					$totalIps = $this->User->find('count', array('conditions' => array('User.ip' => $_SERVER['REMOTE_ADDR'])));
					if($totalIps > $this->appConfigurations['ipBlock']) {
						$this->Session->setFlash(__('Your IP address has been used too many times for creating an account. You cannot create any more accounts.', true), 'default', array('class' => 'message'));
						if(!empty($this->appConfigurations['sslUrl'])) {
							$this->redirect($this->appConfigurations['url'].'/auctions');
						} else {
							$this->redirect(array('controller' => 'auctions', 'action' => 'index'));
						}
					}
				}
			}

			if($this->Session->check('Sms.id')) {
				$this->data = $this->User->read(null, $this->Session->read('Sms.id'));
				$this->data['User']['username'] = '';
			}
		}
		$this->set('genders', $this->Gender->find('list'));
		if (($sources=Cache::read('sources', 'week'))===FALSE) {
			$sources=$this->User->Source->find('all', array('order' => 'Source.order ASC', 'recursive'=>-1));
			Cache::write('sources', $sources, 'week');
		}
		$this->set('sources', $sources);
    
		$this->pageTitle = __('Register', true);
	}
	
	function registration($referrer = null) {
		$site_ref = explode('/',$this->params['url']['url']);
		if($site_ref[0] == 'site'){
			if($referrer != ''){ 
				$this->Session->write("referrer",$referrer);
			}
			$this->redirect(array('controller' => 'auctions', 'action'=>'home'));
		}
		if(!empty($this->appConfigurations['registerOff'])) {
			$this->Session->setFlash(__('Registration has been turned off.', true), 'default', array('class' => 'message'));
			$this->redirect(array('controller' => 'auctions', 'action'=>'home'));
		}
		
		if (!empty($this->data)) {
			if($this->Recaptcha->isValid() || Configure::read('Recaptcha.enabled') == false) {
				eval(AddonManager::hook('controllers_users_register'));
			}else{
				$this->Session->setFlash(__('The captcha form was not valid, please try again.', true), 'default', array('class' => 'message'));
				$this->set('recaptchaError', $this->Recaptcha->error);
			}
		} else {
			if(!empty($this->appConfigurations['sslUrl'])) {
				if(empty($_SERVER['HTTPS'])) {
					$this->redirect($this->appConfigurations['sslUrl'].'/users/registration/'.$referrer);
				}
			}
			
			$id = $this->Auth->user('id');
			if(!empty($id)) {
				if(!empty($this->appConfigurations['sslUrl'])) {
					$this->redirect($this->appConfigurations['url'].'/users');
				} else {
					$this->redirect(array('action' => 'index'));
				}
			}
			if($referrer != ''){ 
				$this->Session->write("referrer",$referrer);
			}
			$this->data['User']['referrer'] = $this->Session->read("referrer");
			
			if(!empty($this->appConfigurations['newsletterSelected'])) {
				$this->data['User']['newsletter'] = 1;
			}

			if(!empty($this->appConfigurations['ipBlock'])) {
				// lets make sure that the IP address has not been used before the set number of times
				if(!empty($_SERVER['REMOTE_ADDR'])) {
					$totalIps = $this->User->find('count', array('conditions' => array('User.ip' => $_SERVER['REMOTE_ADDR'])));
					if($totalIps > $this->appConfigurations['ipBlock']) {
						$this->Session->setFlash(__('Your IP address has been used too many times for creating an account. You cannot create any more accounts.', true), 'default', array('class' => 'message'));
						if(!empty($this->appConfigurations['sslUrl'])) {
							$this->redirect($this->appConfigurations['url'].'/auctions');
						} else {
							$this->redirect(array('controller' => 'auctions', 'action' => 'index'));
						}
					}
				}
			}

			if($this->Session->check('Sms.id')) {
				$this->data = $this->User->read(null, $this->Session->read('Sms.id'));
				$this->data['User']['username'] = '';
			}
		}
		$this->set('genders', $this->Gender->find('list'));
		if (($sources=Cache::read('sources', 'week'))===FALSE) {
			$sources=$this->User->Source->find('all', array('order' => 'Source.order ASC', 'recursive'=>-1));
			Cache::write('sources', $sources, 'week');
		}
		$this->set('sources', $sources);
    
		$this->pageTitle = __('Register', true);
	}

	function edit() {
		if(!empty($this->data)) {
			$this->data['User']['id'] = $this->Auth->user('id');
			if($this->Auth->user('admin') == 0) {
				$this->data['User']['admin'] = 0;
			}
			#unset($this->data['User']['username']);

			if($this->User->save($this->data)) {
				$this->Session->setFlash(__('Your account has been updated successfully.', true), 'default', array('class' => 'success'));
				if(!empty($this->appConfigurations['sslUrl'])) {
					$this->redirect($this->appConfigurations['url'].'/users');
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('There was a problem updating your account please review the errors below and try again.', true));
			}
		} else {
			if(!empty($this->appConfigurations['sslUrl'])) {
				if(empty($_SERVER['HTTPS'])) {
					$this->redirect($this->appConfigurations['sslUrl'].'/users/edit');
				}
			}
			
			$this->data = $this->User->read(null, $this->Auth->user('id'));
		}

		$this->set('genders', $this->Gender->find('list'));

		$this->pageTitle = __('Edit Profile', true);
	}

	function changepassword() {
		if (Configure::read('SCD') && Configure::read('SCD.isSCD')===true) {
			$this->demoDisabled();
		}
		
		if(!empty($this->data)) {
			$this->data['User']['id'] = $this->Auth->user('id');
			if($this->Auth->user('admin') == 0) {
				$this->data['User']['admin'] = 0;
			}
			if(!empty($this->data['User']['before_password'])){
				#$this->data['User']['password'] = Security::hash(Configure::read('Security.salt').$this->data['User']['before_password']);
				$this->data['User']['password'] = md5($this->data['User']['before_password']);
			}
			$this->User->set($this->data);
			if($this->User->validates()) {
				// stupid cake bug requires manual validation here
				if($this->data['User']['before_password'] == $this->data['User']['retype_password']) {
					if($this->User->save($this->data, false)) {

						// Change password on forum database
						if(Configure::read('App.forum')){
							$this->PhpBB3->changePassword($this->Auth->user('username'), $this->data['User']['retype_password']);
						}

						$this->Session->setFlash(__('Your password has been successfully changed.', true), 'default', array('class' => 'success'));
						if(!empty($this->appConfigurations['sslUrl'])) {
							$this->redirect($this->appConfigurations['url'].'/users');
						} else {
							$this->redirect(array('action'=>'index'));
						}
					} else {
						$this->Session->setFlash(__('There was a problem changing your password.  Please review the errors below and try again.', true));
					}
				} else {
					$this->Session->setFlash(__('The new password does not match.', true));
				}
			}
		}

		$this->pageTitle = __('Change Password', true);
	}

	function points(){
		$points = $this->User->Point->balance($this->Auth->user('id'));
		return $points;
	}

	function tracking() {

	}

	function cancel(){
		if(!empty($this->data)){
			$security = $this->Session->read('CancelAccountSec');
			$passSecurity = false;
			if(!empty($security)){
				if($this->data['User']['security'] == $security){
					$passSecurity = true;
					$this->Session->delete('CancelAccountSec');
				}
			}

			if(!$passSecurity){
				$this->Session->setFlash(__('Please use button in Cancel Account page to cancel your account.', true));
				$this->redirect(array('index'));
			}

			$this->User->id = $this->Auth->user('id');
			if($this->User->saveField('active', 0)){
				$this->Session->setFlash(__('Your account has been cancelled and you have been automatically logged out.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'logout'));
			}else{
				$this->Session->setFlash(__('Your account cannot be cancelled. Please try again.', true));
				$this->redirect(array('action' => 'index'));
			}
		}else{
			// For security
			$security = Security::hash(time() + mt_rand(100, 999));
			$this->Session->write('CancelAccountSec', $security);
			$this->set('security', $security);
		}
	}

	function admin_login() {
		$this->redirect('/users/login');
	}

	function admin_index() {
		$this->paginate = array('conditions' => array('User.autobidder' => 0), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('User.created' => 'desc'));
		$this->set('users', $this->paginate());
	}

	function admin_search(){
		if(!empty($this->data['User']['name']) || !empty($this->data['User']['mer_id']) || !empty($this->data['User']['ip']) ||
		   !empty($this->data['User']['email']) ||
		   !empty($this->data['User']['username'])){


			$email = $this->data['User']['email'];
			$username = $this->data['User']['username'];

			$conditions = array();

			if(!empty($this->data['User']['name'])){
				$conditions[] = 'User.first_name LIKE \'%'.$this->data['User']['name'].'%\' OR User.last_name LIKE \'%'.$this->data['User']['name'].'%\'';
			}

			if(!empty($this->data['User']['email'])){
				$conditions[] = array('User.email' => $this->data['User']['email']);
			}

			if(!empty($this->data['User']['username'])){
				$conditions[] = 'User.username LIKE \'%'.$this->data['User']['username'].'%\'';
			}
			if(!empty($this->data['User']['ip'])){
				$conditions[] = array('User.ip' => $this->data['User']['ip']);
			}

			$conditions[] = array('User.autobidder' => 0);
			//debug($conditions);die();


			$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('User.created' => 'desc'));
			$this->set('users', $this->paginate('User', $conditions));
		}else{
			$this->Session->setFlash(__('Please enter at least one search term', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	function admin_view($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action' => 'index'));
		}
		$user = $this->User->read(null, $id);
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $user);

		$address_types = $this->User->Address->addressTypes();
		$userAddress = array();
		$addressRequired = 0;
		foreach($address_types as $key=>$type) {
			$userAddress[$type] = $this->User->Address->find('first', array('conditions' => array('Address.user_id' => $id, 'Address.user_address_type_id' => $key)));
		}
		$this->set('address', $userAddress);

		if(!empty($user['Referral'])) {
			$this->set('referral', $this->User->Referral->find('first', array('conditions'=>array('Referral.user_id' => $user['User']['id']))));
		}
		
		$this->set('genders', $this->Gender->find('list'));
	}

	function admin_resend($id = null){
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action' => 'index'));
		}
		$user = $this->User->read(null, $id);
        $user['User']['activate_link'] = $this->appConfigurations['url'] . '/users/activate/' . $user['User']['key'];
        $user['to'] 				   = $user['User']['email'];
        $user['subject'] 			   = sprintf(__('Account Activation - %s', true), $this->appConfigurations['name']);
        $user['template'] 			   = 'users/activate';

        if($this->_sendEmail($user)){
            $this->Session->setFlash(__('Activation email has been sent to user email address.', true));
            $this->redirect(array('action' => 'index'));
        }else{
            $this->Session->setFlash(__('Activation email sending failed. Please try again.', true));
            $this->redirect(array('action' => 'index'));
        }
    }

	function admin_add() {
		obfGetAdminAdd($this);
	}

	function admin_edit($id = null) {
		if(!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('There user has been updated successfully.', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem updating the users details please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
			if(empty($this->data)) {
				$this->Session->setFlash(__('Invalid User', true));
				$this->redirect(array('action' => 'index'));
			}
		}
		$this->set('genders', $this->Gender->find('list'));
	}

	function admin_delete($id = null, $autobid = null) {
		if(!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'));
		}
		if($this->User->delete($id)) {
			$this->Session->setFlash(__('The user was successfully deleted.', true));
		} else {
			$this->Session->setFlash(__('There was a problem deleting the user.', true));
		}
		if(!empty($autobid)) {
			$this->redirect(array('action' => 'autobidders'));
		} else {
			$this->redirect(array('action' => 'index'));
		}
	}

	function admin_suspend($id = null) {
		if(!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'));
		}

		$user = $this->User->read(null, $id);
		$user['User']['active'] = 0;
		$this->User->save($user);

		$this->Session->setFlash(__('The user was successfully suspended.', true));
		$this->redirect(array('action' => 'index'));
	}

	function admin_autobidders() {
		$this->paginate = array('contain' => array('Auction', 'Bid'), 'conditions' => array('User.autobidder' => 1), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('User.created' => 'desc'));
		$this->set('users', $this->paginate());
	}

	function admin_autobidder_add() {
		if (!empty($this->data)) {
			$this->data['User']['autobidder'] = 1;
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The auto bidder was added successfully.', true));
				$this->redirect(array('action' => 'autobidders'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the user please review the errors below and try again.', true));
			}
		}
	}

	function admin_autobidder_edit($id = null) {
		if(!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
            $this->User->id = $id;
            $this->data['User']['autobidder'] = 1;
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The autobidder has been updated successfully.', true));
				$this->redirect(array('action'=>'autobidders'));
			} else {
				$this->Session->setFlash(__('There was a problem updating the autobidder please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
			if(empty($this->data)) {
				$this->Session->setFlash(__('Invalid User', true));
				$this->redirect(array('action' => 'index'));
			}
		}
	}

	function admin_changepassword($id){
		
		$this->User->id=$id;
		$this->User->recursive=-1;
		$user=$this->User->read();
		$this->set('user', $user);
		
		if(!empty($this->data)) {
			if(!empty($this->data['User']['before_password'])){
				$this->data['User']['id']=$user['User']['id'];
				#$this->data['User']['password'] = Security::hash(Configure::read('Security.salt').$this->data['User']['before_password']);
				$this->data['User']['password'] = md5($this->data['User']['before_password']);
			}
			$this->User->set($this->data);
			if($this->User->validates()) {
				// stupid cake bug requires manual validation here
				if($this->data['User']['before_password'] == $this->data['User']['retype_password']) {
					if($this->User->save($this->data, false)) {
						$this->Session->setFlash(__('Your password has been successfully changed.', true), 'default', array('class' => 'success'));
						$this->redirect(array('action'=>'index'));
					} else {
						$this->Session->setFlash(__('There was a problem changing your password.  Please review the errors below and try again.', true));
					}
				} else {
					$this->Session->setFlash(__('The new password does not match.', true));
				}
			}
		}

	}
	
	function admin_online() {
		$dir   = TMP . DS . 'cache' . DS;
            
		$files = scandir($dir);
		$users = array();

		foreach($files as $filename){
			if(is_dir($dir . $filename)){
				continue;
			}
				
			if(substr($filename, 0, 16) == 'cake_user_count_') {
				$data = explode('_', $filename);
				$users[] = $this->User->find('first', array('conditions' => array('User.id' => $data[3]), 'contain' => ''));
			}
		}
		
		$this->set('users', $users);
	}
	
	function getEndTime() {
		//returns the MySQL timestamp of one minute ago to solve bug where
		//listings bidded between refreshes
		//Yes, this would be better in the auctions model, but we need a new
		//function added here for ioncube obfuscation purposes
		
		return obfGetGetEndTime();
	}
}
?>