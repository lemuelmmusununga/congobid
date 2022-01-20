if(Configure::read('App.demoMode')) {
	$this->data['User']['admin'] = 1;
} else {
	$this->data['User']['admin'] = 0;
}
if(isset($this->data['User']['terms']) && $this->data['User']['terms'] == 0) {
	$this->data['User']['terms'] = null;
}

if ($data = $this->User->register($this->data, false, $this->Session->read('Sms.id'))) {


	if($data['User']['username']) {   
		$pn =  $data['User']['username']; 
		$data2 = array(	
						'activation_code'=> $data['User']['sms_code'] ,
 						'customer_alias' => $data['User']['first_name']  
 						  )	;	 	
		$res = $this->sendSms(7, $pn, $data2);
	} 

	
	$this->redirect(array('controller'=>'pages','action'=>'activate',$data['User']['id'] ));
	exit;


	$this->Session->delete('Sms.id');

	if($this->Session->check('Coupon')) {
		$coupon = $this->Session->read('Coupon');
		if($coupon['Coupon']['coupon_type_id'] == 6) {
			$bid['Bid']['user_id'] = $data['User']['id'];
			$bid['Bid']['credit']  = $coupon['Coupon']['saving'];
			$bid['Bid']['description']  = __('Free registration bids', true);;

			$this->User->Bid->create();
			$this->User->Bid->save($bid);
		}
	}

	if(1 || $this->_sendEmail($data)){ //$this->_sendEmail($data)
		$this->Session->setFlash(__('Thank you for registering.  An email has been sent to your email address, please check your email in order to activate your account.  If you fail to receive an email please check your SPAM box and add as an accepted sender.', true), 'default', array('class' => 'success'));
		$this->redirect('/users/login?e=1');
	}else{
		$this->Session->setFlash(__('Email sending failed. Please try again or contact the administrator.', true));
	}
} else {
	$this->set('errors_arr', $this->User->validationErrors);
	$this->Session->setFlash(__('There was a problem creating your account please review the errors below and try again.', true), 'default', array('class' => 'message'));
}
