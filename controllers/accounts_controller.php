<?php
class AccountsController extends AppController {

	var $name = 'Accounts';

	function index() {
		$this->Account->recursive = 0;
		$this->paginate = array('conditions' => array('Account.user_id' => $this->Auth->user('id')), 'limit' => 50, 'order' => array('Account.created' => 'desc'));
		$this->set('accounts', $this->paginate());

		$this->pageTitle = __('My Account', true);
	}
	
	function admin_index($only_bids=0) {
		$this->Account->recursive = 0;
		if( $only_bids == 1 ){
			$this->paginate = array('conditions' => array('Account.credit > 0'), 'limit' => 50, 'order' => array('Account.id' => 'desc'));
		}else if( $only_bids == 2 ){
			$this->paginate = array('conditions' => array('Account.from_admin' => 1), 'limit' => 50, 'order' => array('Account.id' => 'desc'));
		}else if( $only_bids == 3 ){
			$this->paginate = array('conditions' => array('Account.is_transfer ' => 1), 'limit' => 50, 'order' => array('Account.id' => 'desc'));
		}else if( $only_bids == 4 ){
			$this->paginate = array('conditions' => array('Account.is_plan_buy ' => 1), 'limit' => 50, 'order' => array('Account.id' => 'desc'));
		}else{
			$this->paginate = array('conditions' => array(), 'limit' => 50, 'order' => array('Account.id' => 'desc'));
		}
		$this->set('accounts', $this->paginate());

		$this->pageTitle = __('All Transactions', true);
	}

	function admin_user($user_id = null) {
		if(empty($user_id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$user = $this->Account->User->read(null, $user_id);
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$this->set('user', $user);

		$this->paginate = array('conditions' => array('Account.user_id' => $user_id), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Auction.end_time' => 'asc'));
		$this->set('accounts', $this->paginate());
	}
}
?>
