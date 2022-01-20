<?php
class PagesController extends AppController {

	var $name = 'Pages';

	var $helpers = array('Fck', 'Recaptcha');
	var $components = array('Recaptcha');

	var $uses = array('Page','User','Bid', 'Department');

	function beforeFilter(){
		parent::beforeFilter();

		$this->cacheAction = Configure::read('Cache.time');
		if(!empty($this->Auth)){
			$this->Auth->allow('activate','resent','reset','pay','how_it_works','view', 'getpages','faq','privacy','terms', 'contact','registerintro','wheel', 'suggestion');
			#$this->Auth->allow('contact','registerintro','wheel', 'suggestion');
		}
	}

	function reset(){ 
		$user_id = $this->Session->read('reset_user_id');
		$user_phone = $this->Session->read('reset_user_username');
		$this->set('user_id', $user_id);
		$this->set('user_phone', $user_phone);

		if(!$user_phone){
			$this->redirect('/users/reset');
		}

		if(!empty($this->data)){
			$otp = $this->data['Page']['otp'];
			$password = $this->data['Page']['new_pass'];
			
			$error = false;
			if($otp < 1000 || $otp > 10000){
				$errorOtp = __('OTP must be 4 digit long',true);
				$error = true;
			}
			if(  strlen($password) < 6 || strlen($password) > 26 ){
				$errorPass = __('PIN must be 6 digit long.',true); 
				$error = true;
			}
			if( !ctype_alnum($password) ){
				$errorPass = __('PIN can be alphabets and number only',true);
				$error = true;
			}
			if($error == false){
				$user = $this->User->findById($user_id);
			
				if($user['User']['sms_code'] == $otp){
					$user['User']['password'] = Security::hash(Configure::read('Security.salt').$password );
				   $this->User->save($user, false);
				   $this->Session->setFlash(__('Your password is reset, you can login now', true), 'default', array('class' => 'success'));
				   $this->redirect('/users/login');
   
			   }else{
				   $this->Session->setFlash(__('You entered wrong otp, pleasetry again.', true), 'default', array('class' => 'message'));
   
			   } 
			}else{
				//$this->Session->setFlash(__('Error: '.$errorMsg,  true), 'default', array('class' => 'message'));
 				$this->set('errorOtp', $errorOtp);
 				$this->set('errorPass', $errorPass);
			}


			 

			
			//$this->set('errors_arr', $this->User->validationErrors);
			//$this->set('errors_arr', $this->User->validationErrors);
		}
		
		
		
						

	}

	function pay($confirm=0){  		   

		if($_GET['a'] > 0){
			$a= $_GET['a'];
 			$this->Session->write('pay.amount', $a );
		}
		if($_GET['oid'] > 0){
			$oid= $_GET['oid'];
			$this->Session->write('pay.oid', $oid );
		}

		

		$user_id = $this->Auth->user('id');

		if(!$user_id){
			$this->Session->write('pay.redirect', 1);
			$this->Session->setFlash(__('Please login to continue', true), 'default', array('class' => 'success'));
			$this->redirect('/users/login');
		}

		$amount = $this->Session->read('pay.amount');
		$oid = $this->Session->read('pay.oid');

 		$user = $this->User->findById($user_id);
		$bids = (int) $user['User']['bid_balance'];
		if($bids < $amount && $amount > 0){
			 
			$this->Session->setFlash(__('Insufficient balance, topup your account', true), 'default', array('class' => 'success'));
			$this->redirect('/packages/index');
		}

		$remaining_bids = $bids - $amount; 
		 
		
		if($confirm == 1){
 			$this->User->query("UPDATE users SET  bid_balance =   ".$remaining_bids ."   WHERE id = '$user_id' ");
			$this->User->query("INSERT INTO accounts SET user_id  ='$user_id',
														 name = 'payed order ID $oid e-comm store  ',
														 description = ' payed order ID $oid e-comm store   ' ,
														 price = '".  $amount   ."',
														 created = '". date('Y-m-d H:i:s') ."'      ");
			
			 
			
			$data['user_id'] = $user_id ; 
			$data['amount'] = $amount; 
			$data['oid'] = $oid; 
			$data['error'] = 0; 
			$this->Session->write('pay.success', 1); 
			$data['total_bids'] = $bids; 
			$data['remaining_bids'] = $remaining_bids; 
 
			$url = 'http://shop.congobid.com/payment-response';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($ch);
			curl_close ($ch);
			$this->Session->setFlash(__('Payment Complete, Redirecting in 10 second...', true), 'default', array('class' => 'message'));
			$this->redirect('/pages/pay/2');
		}
	 
	
		$this->set('oid', $oid) ;
		$this->set('bids', $bids) ;
		$this->set('remaining_bids', $remaining_bids) ;
		$this->set('amount', $amount) ;
		$this->set('confirm', $confirm) ;
		$this->set('success', (int) $this->Session->read('pay.success')) ;
	}


	function bids($pid = null, $aid = 0) {  		 

		$user_id = $this->Auth->user('id');
		$user = $this->User->findById($user_id);
		$balance = $this->User->Bid->balance($user_id);   

		

		if(!empty($this->data)){
			$toUser =   $this->User->findByUsername($this->data['Page']['username']);
			
			$pass =  Security::hash(Configure::read('Security.salt').$this->data['Page']['password']);
			$err = 0;
			if(!$toUser['User']['id']){
				$err_msg   = 'Invalid Phone Number or not registered'; $err = 1;
			}
			if($toUser['User']['username'] == $user['User']['username']){
				$err_msg   = 'You can not sent bids to your self'; $err = 1;
			}
			if($pass != $user['User']['password']){
				$err_msg   = 'Password is wrong'; $err = 1;
			}
			 
			if( $balance <  $this->data['Page']['bids'] && $balance > 0  ){
				$err_msg   = 'Insufficient balance, you can only sent '. $balance ; $err = 1;
			}
			if( $balance <  50  ){
				$err_msg   = 'You must have minimum 50 bids so you can send.'    ; $err = 1;
			}

			if($err == 1){
				$this->Session->setFlash(__($err_msg, true), 'default', array('class' => 'message'));
			}

			if($err == 0){
				
				
				$data['Bid']['created'] = date('Y-m-d H:i:s');
				$data['Bid']['modified'] = date('Y-m-d H:i:s');

				$data['Bid']['user_id'] = $user_id;
				$data['Bid']['description'] = 'Transfer bids to: '. $toUser['User']['username'];
				$data['Bid']['credit'] = 0 ;
				$data['Bid']['debit'] =  $this->data['Page']['bids'] ;
				$this->Bid->create();$this->Bid->save($data); 
				$this->Bid->query("UPDATE users SET bid_balance = bid_balance - ".$data['Bid']['debit']."   WHERE id = ".$user_id );
				
					

 				$data['Bid']['user_id'] = $toUser['User']['id'];
				$data['Bid']['description'] = 'Received bids from: '. $user['User']['username'];
				$description = 'From '. $user['User']['username'] . ' to : '.$toUser['User']['username'] ; 
				$data['Bid']['debit'] =  0 ;
				$data['Bid']['credit'] =  $this->data['Page']['bids'] ;
				$this->Bid->create();$this->Bid->save($data);
				$to_balance = $this->User->Bid->balance($toUser['User']['id']); 
				$sender_balance =  $balance -  $this->data['Page']['bids'] ;
				$this->Bid->query("UPDATE users SET bid_balance = bid_balance + ".$data['Bid']['credit']."   WHERE id = ".$toUser['User']['id'] );

				$this->Bid->query("INSERT INTO accounts SET is_transfer  = 1,  user_id = '$user_id', credit = '".$this->data['Page']['bids']."',
																name = '$description', description = '$description', 
															    created = '".date('Y-m-d H:i:s')."'	   "  ); 

				$pn =  $user['User']['username']; 
				$msg = 'Bids Transfered to: '. $toUser['User']['username']; 
				$data = array(	'total_bid_sent'=> $this->data['Page']['bids'] ,
									'recipient_phone_number'=> $toUser['User']['username'] ,
									'sender_alias' => $user['User']['first_name'] ,
									'recipient_alias' => $toUser['User']['first_name'] ,
									'balance'=> $sender_balance ,
									'bi_earn' => 0 )	; 
				$res = $this->sendSms(3, $pn,  $data   ); 
				
				$pn =  $toUser['User']['username']; 
				$msg = 'Bids Received from: '. $user['User']['username'];
 				$data = array(	'total_bid_received'=> $this->data['Page']['bids'] ,
									'receiver_alias'=> $toUser['User']['first_name'] ,
									'sender_phone'=> $user['User']['username'] ,
									'sender_alias' => $user['User']['first_name'] ,
									'balanace'=> $to_balance ,
							  )	; 	
				$res = $this->sendSms(4, $pn, $data  );

				$this->Session->setFlash(__('Bids Transfered', true), 'default', array('class' => 'message'));
				$this->redirect('/users/index');
			}
 		}
	}


	function update_plan($pid = null, $aid = 0) {
 		$user_id = $this->Auth->user('id');
 		// Configure::write('debug', 1);
		 $user = $this->User->findById($user_id);
		$sid_old = $user['User']['sid'] ;
		$user['User']['sid'] = $pid ;
		$user['User']['sid_exp'] = date('Y-m-d', strtotime('+7 days')) ;

		 $balance = $this->User->Bid->balance($user_id);   
		 $data['Bid']['user_id'] = $user_id;
		 $data['Bid']['description'] = 'Purchased plan '. $this->appConfigurations['subscription_pack'][$pid];
		// $data['Bid']['debit'] = $this->appConfigurations['subscription_pack_price'][$pid] - $this->appConfigurations['subscription_pack_price'][$sid_old];
		 $data['Bid']['debit'] = $this->appConfigurations['subscription_pack_price'][$pid] ;
		 $data['Bid']['subscription_pack_cost'] = $this->appConfigurations['subscription_pack_cost'][$pid] ; //- $this->appConfigurations['subscription_pack_cost'][$sid_old];
			
		 if($balance >= $data['Bid']['debit'] && $data['Bid']['debit'] > 0   ){  
			$data['Bid']['debit'] = $this->appConfigurations['subscription_pack_price'][$pid] - $this->appConfigurations['subscription_pack_price'][$sid_old];
			$this->User->Bid->save($data);
			//$this->User->save($user); 				

			$this->User->query("UPDATE users SET sid ='$pid', bid_balance = bid_balance - ".$data['Bid']['debit']." , sid_exp = '".$user['User']['sid_exp']."' WHERE id = '$user_id' ");
			$this->User->query("INSERT INTO accounts SET user_id  ='$user_id',
														 name = '".$data['Bid']['description']."',
														 is_plan_buy = 1,
														 description = '".$data['Bid']['description']."',
														 price = '".  $data['Bid']['subscription_pack_cost']   ."',
														 created = '". date('Y-m-d H:i:s') ."'      ");

			$pn =  $user['User']['username']; 
			$msg = 'Subscription updated to: '. $this->appConfigurations['subscription_pack'][$pid];	
 			 
			$data = array(  'customer_alias'=> $user['User']['first_name'] ,
							'plan_name' =>$this->appConfigurations['subscription_pack'][$pid] ,
							'bid_balance' =>$balance ,
							'plan_price_range'=> $this->appConfigurations['subscription_pack_rrp'][$pid]
									 )	; 
			if($sid_old){ //upgrade
				$res = $this->sendSms(6,$pn,$data);
			}else{ //new plan 
				$res = $this->sendSms(5,$pn,$data );
			}
 		 
		 }else{  
			 if($data['Bid']['debit'] < 0){
				$this->Session->setFlash(__('You can not upgrade to lower package', true), 'default', array('class' => 'message'));

			 }else{
				$this->Session->setFlash(__('you dont have sufficient balance ', true), 'default', array('class' => 'message'));

			 }
			$this->redirect('/users/index');
		 } 
		 

		  
		 $this->Session->setFlash(__('Your account is upgraded', true), 'default', array('class' => 'success'));
		 if($aid > 0){
			$this->redirect('/auctions/product-'.$aid);
		 }else{
			$this->redirect('/users/index');
		 }
		  
	}

	function convert_bids($confirm = 0) {
		$user_id = $this->Auth->user('id');
 		$user = $this->User->findById($user_id);
		$bids = (int) $user['User']['bid_balance']; 
		$bonus_bids = (int) $user['User']['rewards_points'];
		$new_bonus_bids = (int) ($user['User']['rewards_points']/10);

		$error = 0;
		if($bonus_bids < 2){
			$this->Session->setFlash(__('You must have minimum 2 bonus bids to convert into regular bids.', true), 'default', array('class' => 'error'));
			$this->redirect('/users/index');
		}
		if($confirm){
			$new_balance =   $bids + $new_bonus_bids ;
			$this->User->query("UPDATE users SET  bid_balance =   ".$new_balance ." , rewards_points = '0' WHERE id = '$user_id' ");
			$this->User->query("INSERT INTO accounts SET user_id  ='$user_id',
														 name = 'Converted $bonus_bids bonus bids into $new_bonus_bids regular bids  ',
														 description = 'Converted $bonus_bids bonus bids into $new_bonus_bids regular bids  ' ,
														 price = '".  $new_bonus_bids   ."',
														 created = '". date('Y-m-d H:i:s') ."'      ");
			
			$this->Session->setFlash(__('Bids converted.', true), 'default', array('class' => 'success'));
			$this->redirect('/users/index');
			
		}
		 
		$this->set('bonus_bids', $bonus_bids) ;
		$this->set('new_bonus_bids', $new_bonus_bids) ;
				 
		 
   }
	
	function activate($id = null) {
 		$user = $this->User->findById($id);

		// echo '<pre>';print_r($user);echo '</pre>'; exit;
		if(!empty($this->data)){
			if($this->data['User']['sms_code'] == $user['User']['sms_code'] ){
				//mysql_query("UPDATE users set `active` = 1 WHERE id = $id ");
				$this->User->query("UPDATE users set `active` = 1 WHERE id = $id ");

				$login_html = '<html><body><form id="UserLoginForm" id="UserLoginForm" method="post" action="/users/login"><input name="data[User][username]" type="hidden" maxlength="40" value="'.$user['User']['username'].'" id="UserUsername"><input type="hidden" name="data[User][password]" value="'.$user['User']['password'].'" ><input type="hidden" name="data[User][autologin_fb]" value="1" ></form>';
				$login_html .= '<script type="text/javascript"> document.getElementById("UserLoginForm").submit();  </script></body></html>';
				echo $login_html; exit;


				$this->Session->setFlash(__('Your account is activated, you can login now.', true), 'default', array('class' => 'success'));
				$this->redirect('/users/login');
			}else{
				$this->Session->setFlash(__('Invalid Activation code.', true));
			}
			 
		}
		$this->set('id', $id);
	}
	
	function resent($id = null) {
		//Configure::write('debug', 1);
		$user_id = $this->Session->read('reset_user_id');
		$user_phone = $this->Session->read('reset_user_username');


		$user = $this->User->findById($user_id);
		
		$code = rand(1000,9999);
		
 		$this->User->query("UPDATE users set sms_code = '$code' WHERE id = $user_id  ");
  
		$pn =  $user['User']['username'];  
 		
		$data = array(	
						'activation_code'=> $code ,
 						'customer_alias' => $toUser['User']['first_name']  
 						  )	;	 	
		$res = $this->sendSms(7, $pn, $data);
		   
		$this->Session->setFlash(__("Sms sent successfully to your phone number: $pn ", true), 'default', array('class' => 'success'));
				
 		$this->redirect('/pages/reset/');		
	}


		function registerintro($slug = null) {
		}
		function wheel($slug = null) {
		}
		function how_it_works($slug = null) {
		
			$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
			$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
			$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
			$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
			$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
			
			//do something with this information
			if( $iPod || $iPhone ){
				$this->render('how_it_works_mobile');
			}else if($iPad){
				//browser reported as an iPad -- do something here
			}else if($Android){
				$this->render('how_it_works_mobile');
			}
		}
		function faq($slug = null) {
		}
		function privacy($slug = null) {
		}
		function terms($slug = null) {
		}

	function view($slug = null) {
		$page = $this->Page->findBySlug($slug);
		if(!empty($page)){
			$this->set('page', $page);
		}else{
			$this->cakeError('error404');
		}

		$this->pageTitle = $page['Page']['title'];
		if(!empty($page['Page']['meta_description'])) {
			$this->set('meta_description', $page['Page']['meta_description']);
		}
		if(!empty($page['Page']['meta_keywords'])) {
			$this->set('meta_keywords', $page['Page']['meta_keywords']);
		}
	}

	function contact() {
		if(!empty($this->data)) {
			if($this->Recaptcha->isValid() || Configure::read('Recaptcha.enabled') == false) {
				$this->Page->set($this->data);
				if($this->Page->validates()) {
					$data['Page'] 	 			= $this->data['Page'];

					if(!empty($data['Page']['department_id'])) {
						$department = $this->Department->read(null, $data['Page']['department_id']);
						$data['Department'] = $department['Department'];
					}

					$data['delivery'] = 'mail';
					$data['from'] 	 = $this->data['Page']['name'].' <'.$this->data['Page']['email'].'>';


					if(!empty($data['Department']['email'])) {
						$data['to'] 			= $data['Department']['email'];
					} else {
						$data['to'] 			= $this->appConfigurations['email'];
					}

					$data['subject'] 			= sprintf(__('%s - Contact Form Submitted', true), $this->appConfigurations['name']);
					$data['template'] 			= 'pages/contact';
					$this->_sendEmail($data);

					$this->Session->setFlash(__('The contact form was successfully submitted.', true), 'default', array('class' => 'success'));
					$this->redirect('/contact');
				} else {
					$this->Session->setFlash(__('There was a problem submitting the contact form please review the errors below and try again.', true));
				}
			} else {
				$this->Session->setFlash(__('The captcha form was not valid, please try again.', true), 'default', array('class' => 'message'));
				$this->set('recaptchaError', $this->Recaptcha->error);
			}
    	}
    	$this->pageTitle = __('Contact Us', true);

    	$this->set('departments', $this->Department->find('list', array('order' => array('name' => 'asc'))));
	}

	function suggestion() {
		if(!empty($this->data)) {
			$this->Page->set($this->data);
			if($this->Page->validates()) {
				$data['Page'] 	 			= $this->data['Page'];
	
				if(Configure::read('Email.delivery') == 'smtp') {
					$data['from'] 	 		= $this->appConfigurations['email'];
				} else {
					$data['from'] 	 		= $this->data['Page']['name'].' <'.$this->data['Page']['email'].'>';
				}
	
				$data['to'] 				= Configure::read('App.email');
				$data['subject'] 			= sprintf(__('%s - Suggestion Form Submitted', true), $this->appConfigurations['name']);
				$data['template'] 			= 'pages/suggestion';
				$this->_sendEmail($data);
	
				$this->Session->setFlash(__('The suggestion form was successfully submitted.', true), 'default', array('class' => 'success'));
				$this->redirect('/suggestion');
			} else {
				$this->Session->setFlash(__('There was a problem submitting the suggestion form please review the errors below and try again.', true));
			}
		}
		$this->pageTitle = __('Suggestion Box', true);
	
		$this->set('departments', $this->Department->find('list', array('order' => array('name' => 'asc'))));
	}

	function admin_index() {
		 $this->set('staticPages', $this->Page->find('all', array('conditions' => array(), 'order' => array('name' => 'asc'))));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Page->create();
			if ($this->Page->save($this->data)) {
				$this->Session->setFlash(__('The page has been added successfully.', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the page please review the errors below and try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Page', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			unset($this->data['Page']['slug']);
			if ($this->Page->save($this->data)) {
				$this->Session->setFlash(__('The page has been updated successfully.', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem saving the page please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Page->read(null, $id);
		}
	}

	function admin_saveorder($position = 'top') {
		$this->layout = 'js/ajax';
		$message = '';

		if(!empty($_POST)){
			$data = $_POST;

			foreach($data['page'] as $order => $id){
				$page['Page']['id'] = $id;
				$page['Page'][$position.'_show']  = 1;
				$page['Page'][$position.'_order'] = $order;

				$this->Page->save($page);
			}

			$message = __('Page order has been saved', true);
		}

		$this->set('message', $message);
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Page', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Page->del($id)) {
			$this->Session->setFlash(__('The page was successfully deleted.', true));
			$this->redirect(array('action' => 'index'));
		}
	}

}
?>
