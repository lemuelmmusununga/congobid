<?php
class BidbutlersController extends AppController {

	var $name = 'Bidbutlers';

	function index() {
		
		$this->Bidbutler->query(" DELETE FROM bidbutlers WHERE auction_id IN ( select id from auctions where closed = 1 ) 	");

		$this->paginate = array('conditions' => array(  'Bidbutler.user_id' => $this->Auth->user('id')), 'limit' => 20, 'order' => array('Bidbutler.created' => 'desc'), 'contain' => array('Auction' => array('Product' => 'Image')));
 		$this->set('bidbutlers', $this->paginate());
		$this->pageTitle = __('My bid buddys', true);

	}
	
	
	function balance($user_id = null){
		if(!empty($user_id)){
			return $this->User->Bid->balance($user_id);
		}
	}
	 

	function add($auction_id = null, $bidss = null) {
		if (!$auction_id && empty($this->data)) {
			if(isset($this->data['Bidbutler']['ajax'])){echo json_encode(array('message' => 'Invalid bid buddy'));exit;}else{
			$this->Session->setFlash(__('Invalid bid buddy', true));
			$this->redirect(array('action'=>'index'));
			}
		}
		$auction = $this->Bidbutler->Auction->find('first', array('conditions' => array('Auction.id' => $auction_id), 'contain' => 'Product'));
		if(empty($auction)) {
			if(isset($this->data['Bidbutler']['ajax'])){echo json_encode(array('message' => 'Invalid bid buddy'));exit;}else{
			$this->Session->setFlash(__('Invalid auction', true));
			$this->redirect(array('action'=>'index'));
			}
		}

		if(!empty($auction['Auction']['nail_bitter'])) {
			
			if(isset($this->data['Bidbutler']['ajax'])){echo json_encode(array('message' => 'This is a nail bitter auction, a bid buddy cannot be added.'));exit;}else{
			$this->Session->setFlash(__('This is a nail bitter auction, a bid buddy cannot be added.', true));
			$this->redirect(array('controller' => 'auctions', 'action' => 'view', $auction_id));
			}
		}
		$user_id = $this->Auth->user('id') ; 
		if( $this->appConfigurations['limits_daily']['active'] == true ){
			$expiry_date = date('Y-m-d H:i:s', time() - ($this->appConfigurations['limits_daily']['expiry'] * 24 * 60 * 60));
			$start_offer = '2011-04-24 00:00:00';
			if($expiry_date < $start_offer){$expiry_date = $start_offer;}

			$sql = mysql_query("SELECT a.leader_id FROM auctions a, products p WHERE a.product_id = p.id AND a.leader_id = $user_id AND a.end_time > '$expiry_date' AND a.deleted = '0' ");
			$total   = mysql_num_rows($sql);

			if($total >= $this->appConfigurations['limits_daily']['limit']) {
				$this->Session->setFlash(__('Your daily limits are reched.', true));
				$this->redirect(array('controller' => 'auctions', 'action' => 'view', $auction_id));
			}
		}
		if( $this->appConfigurations['limits_weekly']['active'] == true ){
			$expiry_date = date('Y-m-d H:i:s', time() - ($this->appConfigurations['limits_weekly']['expiry'] * 24 * 60 * 60));
			$start_offer = '2011-04-24 00:00:00';
			if($expiry_date < $start_offer){$expiry_date = $start_offer;}

			$sql = mysql_query("SELECT a.leader_id FROM auctions a, products p WHERE a.product_id = p.id AND a.leader_id = $user_id AND a.end_time > '$expiry_date' AND a.deleted = '0' ");
			$total   = mysql_num_rows($sql);

			if($total >= $this->appConfigurations['limits_weekly']['limit']) {
				$this->Session->setFlash(__('Your weekly limits are reched.', true));
				$this->redirect(array('controller' => 'auctions', 'action' => 'view', $auction_id));
			}
		}
		if( $this->appConfigurations['limits_monthly']['active'] == true ){
			$expiry_date = date('Y-m-d H:i:s', time() - ($this->appConfigurations['limits_monthly']['expiry'] * 24 * 60 * 60));
			$start_offer = '2011-04-24 00:00:00';
			if($expiry_date < $start_offer){$expiry_date = $start_offer;}

			$sql = mysql_query("SELECT a.leader_id FROM auctions a, products p WHERE a.product_id = p.id AND a.leader_id = $user_id AND a.end_time > '$expiry_date' AND a.deleted = '0'  ");
			$total   = mysql_num_rows($sql);

			if($total >= $this->appConfigurations['limits_monthly']['limit']) {
				$this->Session->setFlash(__('Your monthyl limits are reched.', true));
				$this->redirect(array('controller' => 'auctions', 'action' => 'view', $auction_id));
			}
		}
		
		$balance = $this->balance($this->Auth->user('id'));
		
		if($balance < ($this->data['Bidbutler']['bids']) ){ //echo $balance; exit;
			if(isset($this->data['Bidbutler']['ajax'])){echo json_encode(array('message' => 'You dont have enough bids in your account.'));exit;}else{
			$this->Session->setFlash(__('You dont have enough bids in your account.', true), 'default', array('class' => 'success')); 
			$this->redirect(array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));
			}
		}

		$this->set('auction', $auction);
		
		// if the advanced mode is on, lets check that they haven't already placed a valid bid buddy on this auction
		if($this->appConfigurations['bidButlerType'] == 'advanced') {
			$bidbutlerCount = $this->Bidbutler->find('count', array('conditions' => array('Bidbutler.auction_id' => $auction_id, 'Bidbutler.user_id' => $this->Auth->user('id'), 'Bidbutler.maximum_price >' => $auction['Auction']['price'], 'Bidbutler.bids >' => 0)));
			if($bidbutlerCount > 0) {
				if(isset($this->data['Bidbutler']['ajax'])){echo json_encode(array('message' => 'You already have a valid bid buddy on this auction you cannot add another one until the existing bid buddy is used.'));exit;}else{
				$this->Session->setFlash(__('You already have a valid bid buddy on this auction you cannot add another one until the existing bid buddy is used.', true), 'default', array('class' => 'success'));
				$this->redirect(array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));
				}
			}
		}
		
		if (!empty($this->data) || $bidss > 0 ) {
			$this->data['Bidbutler']['user_id'] = $this->Auth->user('id');
			$this->data['Bidbutler']['auction_id'] = $auction_id;
			$this->data['Bidbutler']['balance'] = $this->Bidbutler->Auction->Bid->balance($this->Auth->user('id'));
			
			if($bidss > 0){
				$this->data['Bidbutler']['maximum_price'] = 100;
				$this->data['Bidbutler']['minimum_price'] = '0.01';
				$this->data['Bidbutler']['bids']  = $bidss ;
			}
			
			$this->Bidbutler->query('DELETE FROM bidbutlers where user_id = "'.$this->Auth->user('id').'" AND auction_id = "'.$auction_id.'" ');
			$bbid = $this->Bidbutler->create();
			if ($this->Bidbutler->save($this->data)) {
				if($this->appConfigurations['bidButlerType'] == 'advanced') {
					if($this->appConfigurations['simpleBids'] == true) {
						$user['User']['id'] = $this->Auth->user('id');
						$user['User']['bid_balance'] += $this->data['Bidbutler']['bids'] * $auction['Auction']['bid_debit'];
						$this->User->save($user);
					} else {
						// lets take the credit now
						$bid['Bid']['user_id'] 	  = $this->data['Bidbutler']['user_id'];
						$bid['Bid']['credit']     = 0;
						//$bid['Bid']['debit']      = $this->data['Bidbutler']['bids'] * $auction['Auction']['bid_debit'];
						$bid['Bid']['debit']      = $this->data['Bidbutler']['bids'] ;
						$bid['Bid']['description'] = __('bid buddy Credits', true);
						//echo '<pre>';print_r($bid);exit();	
						$this->User->Bid->create();
						$this->User->Bid->save($bid);
					}
				}
				if(isset($this->data['Bidbutler']['ajax'])){echo json_encode(array('message' => 'The bid buddy has been added successfully.', 'id' => $this->Bidbutler->id));exit;}else{
				$this->Session->setFlash(__('Your bid buddy is set.', true), 'default', array('class' => 'success'));
				$this->redirect(array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));
				}
			} else {
				if(isset($this->data['Bidbutler']['ajax'])){echo json_encode(array('message' => 'There was a problem adding the bid buddy please review the errors below and try again.'));exit;}else{
				$this->Session->setFlash(__('There was a problem adding the bid buddy please review the errors below and try again.', true));
				}
			}
		}
		$this->pageTitle = __('Add a bid buddy', true);
	}

	function edit($id = null) {

		if (!empty($this->data)) {
			$id=$this->data['Bidbutler']['id'];
		}

		$bidbutler = $this->Bidbutler->find('first', array('conditions' => array('Bidbutler.id' => $id), 'contain' => array('Auction' => array('Product'))));
		if(empty($bidbutler)) {
			$this->Session->setFlash(__('Invalid bid buddy', true));
			$this->redirect(array('action'=>'index'));
		}
		if($bidbutler['Bidbutler']['user_id'] !== $this->Auth->user('id')) {
			$this->Session->setFlash(__('Invalid bid buddy', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('bidbutler', $bidbutler);

		if (!empty($this->data)) {
			$this->data['Bidbutler']['user_id'] = $this->Auth->user('id');
			$this->data['Bidbutler']['auction_id'] = $bidbutler['Bidbutler']['auction_id'];
			$this->data['Bidbutler']['balance'] = $this->Bidbutler->Auction->Bid->balance($this->Auth->user('id'));
			if ($this->Bidbutler->save($this->data)) {
				$this->Session->setFlash(__('The bid buddy has been updated successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem updating the bid buddy please review the errors below and try again.', true));
			}
		} else {
			$this->data = $bidbutler;
		}
		$this->pageTitle = __('Edit a bid buddy', true);
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid bid buddy', true));
			$this->redirect(array('action'=>'index'));
		}
		$bidbutler = $this->Bidbutler->read(null, $id);
		if(empty($bidbutler)) {
			$this->Session->setFlash(__('Invalid bid buddy', true));
			$this->redirect(array('action'=>'index'));
		}
		if($bidbutler['Bidbutler']['user_id'] == $this->Auth->user('id')) {
			if ($this->Bidbutler->del($id)) {
				$this->Session->setFlash(__('Your bid buddy was successfully deleted.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem deleting the bid buddy please try again.', true));
				$this->redirect(array('action'=>'index'));
			}
		} else {
			$this->Session->setFlash(__('Invalid bid buddy', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function admin_user($user_id = null) {
		if(empty($user_id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$user = $this->Bidbutler->User->read(null, $user_id);
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$this->set('user', $user);

		$this->paginate = array('conditions' => array('Bidbutler.user_id' => $user_id), 'contain' => array('User', 'Auction' => 'Product'), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Bidbutler.created' => 'desc'));
		$this->set('bidbutlers', $this->paginate());
	}

	function admin_delete($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid id for bid buddy', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$bidbutler = $this->Bidbutler->read(null, $id);
		if(empty($bidbutler)) {
			$this->Session->setFlash(__('Invalid id for bid buddy', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}

		if ($this->Bidbutler->del($id)) {
			$this->Session->setFlash(__('The bid buddy was successfully deleted.', true));
		} else {
			$this->Session->setFlash(__('There was a problem deleting this bid buddy.', true));
		}
		$this->redirect(array('action'=>'user', $bidbutler['Bidbutler']['user_id']));
	}
}
?>