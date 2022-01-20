if(!empty($key)){
	$user = $this->User->activate($key);
	if(!empty($user)) {
		$data['template'] = 'users/welcome';
		$data['layout']   = 'default';
		$data['to'] 	  = $user['User']['email'];
		$data['subject']  = sprintf(__('Thank you for joining %s', true), Configure::read('Site.name'));
		$data['User']	  = $user['User'];
		$this->set('data', $data);
		$this->_sendEmail($data);
		
		if($user['google_user'] == 1 || $user['fb_user'] == 1){
			return true;
		}

		// To redirect users to package after login
		$this->Session->write('justActivated', 1);

		// now check the free bids setting
		$setting = Configure::read('Settings.free_registeration_bids');  
		if((is_numeric($setting)) && $setting > 0) {
			$bidData['Bid']['user_id'] = $user['User']['id'];
			$bidData['Bid']['description'] = __('Free bids given for registering.', true);
			$bidData['Bid']['credit'] = $setting;
			$bidData['Bid']['created'] = date('Y-m-d H:i:s');
			$bidData['Bid']['modified'] = date('Y-m-d H:i:s'); 
			$this->User->Bid->create();
			$this->User->Bid->save($bidData);

			 

			$this->Session->setFlash(__('Your account has been activated and some free bids have been added to your account. Please login using your username and password.', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('Your account has been activated. Please login using your username and password.', true), 'default', array('class' => 'success'));
		}
		$this->redirect('/users/login?e=1');
	} else {
		$this->Session->setFlash(__('Invalid activation key or you have already been activated. Please try again or contact the administrator.', true));
		$this->redirect('/users/login?e=1');
	}
} else {
	$this->redirect(array('action'=>'login'));
}
