if(!empty($this->data)){
	if($data = $this->User->reset($this->data)){

		$pn =  $data['User']['username']; 
		$data1 = array(	
						'activation_code'=> $data['User']['sms_code'] ,
 						'customer_alias' => $data['User']['first_name']  
 						  )	;	 	
		$res = $this->sendSms(7, $pn, $data1);

 		$this->Session->write('reset_user_id', $data['User']['id']);
 		$this->Session->write('reset_user_username', $data['User']['username']);
		$this->Session->setFlash(__('An sms containing your account details has been sent. Please check your sms.', true), 'default', array('class' => 'success'));
		$this->redirect('/pages/reset');
		 
		 
	}else{
		$this->Session->setFlash(__('The phone number address you entered is not assigned to any member.', true));
	}
}
$this->pageTitle = __('Reset Your Password', true);
 