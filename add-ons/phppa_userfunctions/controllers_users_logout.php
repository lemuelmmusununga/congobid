// Deleting remember me cookie if it exists
if($this->Cookie->read('User.id')){
	$this->Cookie->del('User.id');
}

// Deleting getstatus cookie if it exists
if($this->Cookie->read('user_id')){
	$this->Cookie->del('user_id');
}

// Logout from forum also
if(Configure::read('App.forum')){
	$this->PhpBB3->logout();
}

$this->Session->setFlash(__('You have been successfully logged out.', true), 'default', array('class' => 'success'));
$this->redirect($this->Auth->logout());

