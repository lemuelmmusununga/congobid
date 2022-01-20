<?php

if ($this->Auth->login()) {
	if ($this->Auth->user('active') == 1) {
		if (!empty($this->data['User']['remember_me']) || 1) {
//pr($this->Auth->user('id'));exit;			
			$this->Cookie->write('User.id', $this->Auth->user('id'), false, REMEMBER_ME_DURATION);
			$this->Cookie->write('User.pass', $this->data['User']['password'], false, REMEMBER_ME_DURATION);
			unset($this->data['User']['remember_me']);
		} else {
			$this->Cookie->write('User.id', $this->Auth->user('id'), true, '+1 hour');
		}

		 
		$this->Session->setFlash(__('You have successfully logged in.', true), 'default', array('class' => 'success'));
		
		
		
		if ($this->Session->read('justActivated')) {
			$this->Session->delete('justActivated');
			$this->redirect('/page/how-it-works');
		}
		if ($this->Session->read('pay.redirect')) {
			$this->Session->delete('pay.redirect');
			$this->redirect('/pages/pay');
		}

		if ($this->Auth->user('admin') == 1) {
			$this->redirect('/admin/auctions'); exit;
		} 
		 
		$this->redirect('/?from_login=1');

	} else {
		if (!$this->Auth->user('email') && $this->Auth->user('mobile')) {
			$this->Session->write('Sms.id', $this->Auth->user('id'));
			$this->Auth->logout();
			$this->Session->setFlash(__('You have an SMS account only.  Please create an online account in order to access the features on the website.', true));
			$this->redirect(array('action' => 'register'));
		} else {
			$this->Auth->logout();
			$this->Session->setFlash(__('Your account has not been actived yet or your account has been suspended.', true));

			if (!empty($this->data['User']['url'])) {
				$this->redirect($this->data['User']['url']);
			} else {
				$this->redirect(array('action' => 'login'));
			}
		}
	}
}
