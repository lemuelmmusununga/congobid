$this->set('user', $this->User->read(null, $this->Auth->user('id')));

$userAddress = array();
foreach($this->User->Address->addressTypes() as $id=>$type) {
	$userAddress[$type] = $this->User->Address->find('first', array('conditions' => array('Address.user_id' => $this->Auth->user('id'), 
															'Address.user_address_type_id' => $id)));
}
$this->set('userAddress', $userAddress);

$this->set('unpaidAuctions', $this->User->Auction->find('count', array('conditions' => array(	'Auction.winner_id' => $this->Auth->user('id'), 
															'Status.id' => 1))));

$this->pageTitle = __('Dashboard', true);
