<?php
class PaymentGatewaysController extends AppController{
	var $name = 'PaymentGateways';
	var $uses = array('Auction', 'Package', 'Bid', 'Setting', 'Account','User', 'Referral', 'Coupon', 'Order');
	var $components = array('Cookie');
	var $helpers = array('Dotpay', 'Epayment', 'GoogleCheckout');
	
	function beforeFilter(){
		parent::beforeFilter();
		if(isset($this->Auth)){
			$this->Auth->allow('returning', 'dotpay_ipn', 'mobile_ipn', 'payle_ipn','paypal_ipn',
					  'paypal_pro_ipn', 'secure_pay_ipn','authorizenet_ipn', 'plimus_ipn','paybox_ipn',
					  'usaepay_ipn',
					  'pagseguro_ipn', 'nbepay_ipn', 'ipay88_ipn', 'multisafepay_ipn', 'dalpay_ipn', 'ogone', 'ogone_ipn');
		}
		
 	}
	
	/**
	 * Avoid XSS injection and controll input values.
	 */
	private function _validateModelId($model = null, $id = null)
	{
		if(!in_array($model, array('package', 'auction')))
		{
			$this->Session->setFlash(sprintf(__('There is no handler for %s in this payment gateway.', true), $model));
			$this->redirect('/');
			return false;
		}
		if(!is_numeric($id))
		{
			$this->Session->setFlash(sprintf(__('Wrong item id in this payment gateway.', true)));
			$this->redirect('/');
			return false;
		}
		
		eval(AddonManager::hook('controllers_paymentgateways_validatemodelid'));

		return true;
	}
	
	/**
	 * Function to calculate hmac
	 */
	function _hmac($data, $key){
		// RFC 2104 HMAC implementation for php.
		// Creates an md5 HMAC.
		// Eliminates the need to install mhash to compute a HMAC
		// Hacked by Lance Rushing
		$b = 64; // byte length for md5
		if (strlen($key) > $b) {
		   $key = pack("H*",md5($key));
		}
		$key  = str_pad($key, $b, chr(0x00));
		$ipad = str_pad('', $b, chr(0x36));
		$opad = str_pad('', $b, chr(0x5c));
		$k_ipad = $key ^ $ipad ;
		$k_opad = $key ^ $opad;
		
		return md5($k_opad  . pack("H*",md5($k_ipad . $data)));
	}

	/**
	 * Function to set an auction's status
	 */
	function _setAuctionStatus($auction_id, $status_id){
		eval(AddonManager::hook('controllers_paymentgateways_setauctionstatus'));
		
		if(!empty($auction_id) && !empty($status_id)){
			$auction['Auction']['id']        = $auction_id;
			$auction['Auction']['status_id'] = $status_id;
			
			return $this->Auction->save($auction, false);
		}else{
			return false;
		}
	}
	
	
	/**
	 * Function to add credit to user's account
	 */
	function _credit($auction_id, $credit = 0, $debit = 0, $user_id = null){
		eval(AddonManager::hook('controllers_paymentgateways_credit')); 
		
		if(!empty($auction_id)){
		    if(!empty($user)){
			$credit['Credit']['user_id'] = $user_id;
		    }else{
			$credit['Credit']['user_id'] = $this->Auth->user('id');
		    }
		    $credit['Credit']['auction_id'] = $auction_id;
		    $credit['Credit']['credit']     = $credit;
		    $credit['Credit']['debit']      = $debit;
		
		    $this->Auction->Credit->create();
		
		    return $this->Auction->Credit->save($credit);
		}else{
		    return false;
		}
	}

	/**
	 * Function to add bids to user's account
	 */
	function _bids($user_id = null, $description = null, $credit = 0, $debit = 0){
 		
		if(!empty($user_id) && !empty($description)){
			if( 1 || $this->appConfigurations['simpleBids'] == true) {
				$user = $this->User->find('first', array('conditions' => array('User.id' => $user_id), 'contain' => ''));
				if($credit > 0) {
					$user['User']['bid_balance'] += $credit;
				} else {
					$user['User']['bid_balance'] -= $debit;
				}
				
				$this->User->save($user, false);
				
				$bid['Bid']['user_id']     = $user_id;
				$bid['Bid']['description'] = $description;
				$bid['Bid']['credit']      = $credit;
				$bid['Bid']['debit']       = $debit;
				$bid['Bid']['created']       = date('Y-m-d H:i:s');
				$bid['Bid']['modified']       = date('Y-m-d H:i:s');
				
				return $bid;
			} else {
				$bid['Bid']['user_id']     = $user_id;
				$bid['Bid']['description'] = $description;
				$bid['Bid']['credit']      = $credit;
				$bid['Bid']['debit']       = $debit;
				$bid['Bid']['created']       = date('Y-m-d H:i:s');
				$bid['Bid']['modified']       = date('Y-m-d H:i:s');
				$this->Bid->create();
				
				return $this->Bid->save($bid);
			}
		}else{
			return false;
		}
	}

	/**
	 * Function to add an account entry to user's account
	 */
	function _account($user_id = null, $name, $bids = 0, $price, $auction_id=0){
		 
		if(!empty($user_id) && !empty($name)){
			$account['Account']['user_id'] = $user_id;
			$account['Account']['name']    = $name;
			$account['Account']['description']    = $name;
			$account['Account']['credit']    = $bids;
			$account['Account']['price']   = $price;
			$account['Account']['auction_id']   = $auction_id;
 			$account['Account']['created']       = date('Y-m-d H:i:s');
			$account['Account']['modified']       = date('Y-m-d H:i:s');
			$this->Account->create();
			$this->Account->save($account, false);
			$this->log("_account: account record added ($user_id, $name, $bids, $price)", 'payment');
			
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Function to get auction
	 */
	function _getAuction($auction_id, $user_id, $redirect = true){
		$auction = $this->Auction->find('first', array('conditions' => array('Auction.id' => $auction_id)));
		
		eval(AddonManager::hook('controllers_paymentgateways_getauction'));
		
		if(!empty($auction)){
			// Check if logged user is the winner
			if($auction['Auction']['winner_id'] != $user_id){
				if($redirect){
					$this->Session->setFlash(__('Invalid auction', true));
					$this->redirect(array('controller' => 'auctions', 'action' => 'won'));
				}else{
					return false;
				}
			}
			
			// Check auction status is not paid
			if($auction['Auction']['status_id'] != 1) {
				if($redirect){
					$this->Session->setFlash(__('You have already paid for this auction.', true));
					$this->redirect(array('controller' => 'auctions', 'action' => 'won'));
				}else{
					return false;
				}
			}
			
			// Get the total cost
			$total = 0;
			if(!empty($auction['Product']['fixed'])) {
				$total = $auction['Product']['fixed_price'] + $auction['Product']['delivery_cost'];
			} else {
				$total = $auction['Auction']['price'] + $auction['Product']['delivery_cost'];
			}
			
			// Check credit
			if(Configure::read('App.credits.active')){
				$credits  = $this->Auction->Credit->balance($user_id, Configure::read('App.credits.expiry'));
				$original = $total;
				$total    = $total - $credits;
		
				if($total < 0) {
					$total = 0;
					$auction['Credit']['debit'] = $original;
				} else {
					$auction['Credit']['debit'] = $credits;
				}
			}
			
			$auction['Auction']['total'] = $total;
		}
		
		return $auction;
	}

	/**
	 * Function to get package
	 */
	function _getPackage($package_id, $user_id = null){
		if(!empty($package_id)){
			// Set the user id in session for coupon
			// in package's afterFind()
			if(!empty($user_id)){
	
				// better to put it on PaymentGateway array than
				// Auth.User.id since it will open security hole
				$this->Session->write('PaymentGateway.user_id', $user_id);
	
				// Check validity of user's coupon
				if(Configure::read('App.coupons')){
					if($coupon = Cache::read('coupon_user_'.$user_id)){
						$coupon = $this->Coupon->findByCode(strtoupper($coupon['Coupon']['code']));
					}
				}
			}
	
			return $this->Package->find('first', array('conditions' => array('Package.id' => $package_id)));
		}else{
		    return false;
		}
	}

	/**
	 * Function to check if the addressed already completed
	 */
	function _isAddressCompleted($user_id = null){
		if(empty($user_id)){
		    $user_id = $this->Auth->user('id');
		}
		
		return $this->Auction->Winner->Address->isCompleted($user_id);
	}

	/**
	* Check if this is user first won auction
	*/
	function _firstWin($user_id = null, $auction_id) {
		if(empty($user_id)){
		    $user_id = $this->Auth->user('id');
		}
		
		$won = $this->Auction->find('count', array('conditions' => array('Auction.winner_id' => $user_id)));
		if($won == 1) {
			// Give 'em first winning bonus bid
			$setting = Configure::read('Settings.free_won_auction_bids');
			if((is_numeric($setting)) && $setting > 0) {
				$credit = $credit;
			} elseif(substr($setting, -1) == '%' && is_numeric(substr($setting, 0, -1))) {
				$bids  = $this->find('all', array('conditions' => array('Bid.user_id' => $user_id, 'Bid.auction_id' => $auction_id), 'fields' => "SUM(Bid.debit) as 'bids'"));
				if(empty($bids[0][0]['bids'])) {
					$bids[0][0]['bids'] = 0;
				}
	
				$credit = $bids[0][0]['bids'] * (substr($setting, 0, -1) / 100);
				$credit = ceil($credit);
			}
	
			if(!empty($credit) && $credit > 0){
				$description = __('Free bids given for winning your first auction.', true);
				$this->_bids($user_id, $description, $credit, 0);
			}

			return true;
		}else{
			return false;
		}
	}

	/**
	* Check if this is user first bid package purchase
	*/
	function _checkFirstPurchase($user_id = null, $bids = null){
		/*if(!empty($user_id)){
		    $purchasedBefore = $this->User->Account->find('first', array('conditions' => array('Account.user_id' => $user_id, 'Account.bids >' => 0)));
		    if(empty($purchasedBefore)) {
			// Get the setting
			$setting = Configure::read('Settings.free_bid_packages_bids');
			
			// If setting for free bids is not 0
			if((is_numeric($setting)) && $setting > 0) {
				$credit = $setting;
			} elseif(substr($setting, -1) == '%' && is_numeric(substr($setting, 0, -1))) {
				$credit = $bids * (substr($setting, 0, -1) / 100);
			}
			
			$description = __('Free bids given for purchasing bids for the first time.', true);
			$this->_bids($user_id, $description, $credit, 0);
		    }else{
			return false;
		    }
		}else{
		    return false;
		}*/
	}
	
	/**
	* Check if user referred by another user
	*/
	function _checkReferral($user_id = null, $bids=null){
	// Now we check if this user was referred so we can give the free bids away
		$referral = $this->Referral->find('first', array('conditions' => array('user_id' => $user_id, 'confirmed' => 0)));
	
		if(!empty($referral)) {
			// Get the setting for free bids
			$setting = Configure::read('Settings.free_referral_bids');
			$bids_credit = round( $bids * ($setting/100) );	 
			$description = __('Referral Bids Earned for:', true).' '.$referral['User']['username'];
			$this->_bids($referral['Referral']['referrer_id'], $description, $bids_credit, 0);
	
			// Finally set the referral as confirmed
			$referral['Referral']['confirmed'] = 1;
			unset($referral['Referral']['modified']);
	
			// Save the referral
			$this->User->Referral->save($referral);
		}
	}

	/**
	 * Check reward point whether it's on or off and add points into
	 * user account if necessary
	 */
	function _checkRewardPoints($package_id = null, $user_id = null){
		if($package_id && $user_id){
			// Adding points
			if(Configure::read('App.rewardsPoint')){

				// Set the user id in session for coupon
				// in package's afterFind()
				if(!empty($user_id)){

					// better to put it on PaymentGateway array than
					// Auth.User.id since it will open security hole
					$this->Session->write('PaymentGateway.user_id', $user_id);

					// Check validity of user's coupon
					if(Configure::read('App.coupons')){
						if($coupon = Cache::read('coupon_user_'.$user_id)){
							$coupon = $this->Coupon->findByCode(strtoupper($coupon['Coupon']['code']));
						}
					}
				}

				$package = $this->Package->findById($package_id);

				if(!empty($package['PackagePoint']['points'])){
					$point = $this->User->Point->findByUserId($user_id);
					if(!empty($point)){
						$point['Point']['points'] += $package['PackagePoint']['points'];
					}else{
						$point['Point']['user_id'] = $user_id;
						$point['Point']['points']  = $package['PackagePoint']['points'];

						$this->User->Point->create();
					}

					$this->User->Point->save($point);
				}
			}
		}
	}

	/**
	 * Function for returning from payment gateway
	 */
	function returning($model){
		if(!empty($model)){
			switch($model){
				case 'auction':
					$this->Session->setFlash(__('Your payment was successful.  We will notify you when your item has been shipped.', true));
					$this->redirect(array('controller' => 'auctions', 'action' => 'won'));
					break;

				case 'package':
					$this->Session->setFlash(__('Your payment was successful and your bids are available. If you are experiencing an issue, please contact support.', true), 'default', array('class'=>'success'));
					$this->redirect(array('controller' => 'accounts', 'action' => 'index'));
					break;
			}
		}else{
			die('I hate you');
		}
	}

	/**
	 * Function for cancelling from payment gateway
	 */
	function cancel($model){
		if(!empty($model)){
			switch($model){
				case 'auction':
					$this->Session->setFlash(__('Your payment was canceled.', true));
					$this->redirect(array('controller' => 'auctions', 'action' => 'won'));
					break;

				case 'package':
					$this->Session->setFlash(__('Your payment was canceled.', true));
					$this->redirect(array('controller' => 'accounts', 'action' => 'index'));
					break;
			}
		}else{
			die('I hate you');
		}
	}

	/**
	* Function for sending notification after auction payment
	*/
	function _sendAuctionNotification($auction, $user_id = null){
		// Get users
		$user = $this->User->findById($user_id);
		
		$data['template'] = 'payment_gateways/auction_pay';
		$data['layout']   = 'default';
		
		// Send to both user and admin
		$data['to'] 	  = array($user['User']['email'], $this->appConfigurations['email']);
		
		$data['subject']  = __('Won Auction Payment', true);
		$data['User']	  = $user['User'];
		
		$this->set('auction', $auction);
		$this->set('user', $data);
		
		if($this->_sendEmail($data)){
		    return true;
		}else{
		    return false;
		}
	}
	
	/**
	* Function for sending notification after package purchase
	*/
	function _sendPackageNotification($package, $user_id = null){
		// Get users
		$user = $this->User->findById($user_id);
		
		$data['template'] = 'payment_gateways/package_buy';
		$data['layout']   = 'default';
		
		// Send to both user and admin
		$data['to'] 	  = $user['User']['email'];
		
		$data['subject']  = __('Bid Package Purchased', true);
		$data['User']	  = $user['User'];
		
		$this->set('data', $data);
		$this->set('package', $package);
		
		if($this->_sendEmail($data)){
			$data['to'] 	  = $this->appConfigurations['email'];
			$this->_sendEmail($data);
		    return true;
		}else{
		    return false;
		}
	}
	
    /**
     * Google Checkout function
     * In case the XML API contains multiple open tags
     * with the same value, then invoke this function and
     * perform a foreach on the resultant array.
     * This takes care of cases when there is only one unique tag
     * or multiple tags.Examples of this are "anonymous-address",
     * "merchant-code-string" from the merchant-calculations-callback API
     */
    function get_arr_result($child_node) {
        $result = array();
        if(isset($child_node)) {
            if(is_associative_array($child_node)) {
                $result[] = $child_node;
            } else {
                foreach($child_node as $curr_node){
                    $result[] = $curr_node;
                }
            }
        }
        return $result;
    }

    /* Returns true if a given variable represents an associative array */
    function is_associative_array( $var ) {
        return is_array( $var ) && !is_numeric( implode( '', array_keys( $var ) ) );
    }

    /**
     * Dotpay payment gateway
     * http://www.dotpay.eu
     */
    function dotpay($model = null, $id = null){
		 $this->_validateModelId($model, $id);
		 
        if(!empty($model)){
            // Get gateway information
            $gateway = Configure::read('PaymentGateways.Dotpay');

            switch($model){
                case 'auction':
                    $auction   = $this->_getAuction($id, $this->Auth->user('id'));
                    $addresses = $this->_isAddressCompleted();
                    $user      = $auction['Winner'];

                    // for detection in ipn
                    // anti fraud
                    $security_code       = sha1(Configure::read('Security.salt') . $this->Auth->user('id'));
                    $data['control']     = 'auction#'.$auction['Auction']['id'].'#'.$this->Auth->user('id') . '#' . $security_code;

                    $data['id']          = $gateway['id'];
                    $data['currency']    = $gateway['currency'];
                    $data['lang']        = $gateway['lang'];
                    $data['URL']         = $gateway['URL'];
                    $data['URLC']        = $gateway['URLC'];
                    $data['amount']      = $auction['Auction']['total'];
                    $data['description'] = $auction['Product']['title'];

                    $data['firstname']   = $user['first_name'];
                    $data['lastname']    = $user['last_name'];
                    $data['email']       = $user['email'];
                    $data['street']      = $addresses['Billing']['address_1'];
                    $data['street_n1']   = $addresses['Billing']['address_2'];
                    $data['city']        = $addresses['Billing']['city'];
                    $data['postcode']    = $addresses['Billing']['postcode'];
                    $data['phone']       = $addresses['Billing']['phone'];
                    $data['country']     = $addresses['Billing']['country_name'];

                    break;
                case 'package':
                    $package   = $this->_getPackage($id);

                    // for detection in ipn
                    // anti fraud
                    $security_code       = sha1(Configure::read('Security.salt') . $this->Auth->user('id'));
                    $data['control']     = 'package#'.$package['Package']['id'].'#'.$this->Auth->user('id') . '#' . $security_code;

                    $data['id']          = $gateway['id'];
                    $data['currency']    = $gateway['currency'];
                    $data['lang']        = $gateway['lang'];
                    $data['URL']         = $gateway['URL'];
                    $data['URLC']        = $gateway['URLC'];
                    $data['amount']      = $package['Package']['price'];
                    $data['description'] = $package['Package']['name'];

                    $data['firstname']   = $this->Auth->user('first_name');
                    $data['lastname']    = $this->Auth->user('last_name');
                    $data['email']       = $this->Auth->user('email');

                    break;
                default:
                    $this->Session->setFlash(sprintf(__('There is no handler for %s in this payment gateway.', true), $model));
                    $this->redirect('/');
            }

            $this->set('data', $data);
        }else{
            $this->Session->setFlash(__('Invalid payment gateway', true));
            $this->redirect('/');
        }
    }

    function dotpay_ipn(){
        Configure::write('debug', 0);
        $this->layout = 'ajax';
        $data = $_POST;

        if(!empty($data)){
            $control = explode('#', $data['control']);

            $model         = !empty($control[0]) ? $control[0] : null;
            $id            = !empty($control[1]) ? $control[1] : null;
            $user_id       = !empty($control[2]) ? $control[2] : null;
            $security_code = !empty($control[3]) ? $control[3] : null;

            // Anti fraud
            if(sha1(Configure::read('Security.salt') . $user_id) != $security_code){
                return false;
            }

            switch($model){
                case 'auction':
                    if(!empty($data['t_status']) && $data['t_status'] == 2){
                        $this->log('Start changing auction','payment');
                        
                        $this->log('Get the auction','payment');
                        $auction = $this->_getAuction($id, $user_id, false);

                        // Change auction status
                        $status = $this->_setAuctionStatus($id, 2);

                        // Check the first winners bonus
				$this->_firstWin($user_id, $id);
				
				eval(AddonManager::hook('controllers_paymentgateways_paid'));

                        // Lets deduct the spent credits
                        if(Configure::read('App.credit.active')){
                            $this->_credit($id, 0, $auction['Credit']['debit'], $user_id);
                        }

                        // Send notification email
                        $this->_sendAuctionNotification($auction, $user_id);
                    }
                    break;

                case 'package':
                    if(!empty($data['t_status']) && $data['t_status'] == 2){
                        $package = $this->_getPackage($id, $user_id);

                        // Adding bids
                        $description = __('Bids purchased - package name:', true).' '.$package['Package']['name'];
                        $credit      = $package['Package']['bids'];
                        $this->_bids($user_id, $description, $credit, 0);

                        // Updating account
                        $name  = __('Bids purchased - package name:', true).' '.$package['Package']['name'];
                        $bids  = $package['Package']['bids'];
                        $price = $package['Package']['price'];

                        // Add bonus if it's user first purchase
                        $this->_checkFirstPurchase($user_id, $bids);

                        $this->_account($user_id, $name, $bids, $price);

                        // Checking referral bonus
                        $this->_checkReferral($user_id);

						// Check and increase user reward points
						$this->_checkRewardPoints($id, $user_id);

                        // Send notification email
                        $this->_sendPackageNotification($package, $user_id);
                    }
                    break;
            }
        }
    }

    /**
     * Epayment payment gateway
     * http://www.epayment.ro
     */
    function epayment($model = null, $id = null){
		 $this->_validateModelId($model, $id);
		//
    }

    function epayment_ipn(){

    }

    /**
     * Google Checkout payment gateway
     * http://checkout.google.com
     */
    function google_checkout($model = null, $id = null){
		 $this->_validateModelId($model, $id);
		if(!empty($model)){
            // Get gateway information
            $gateway = Configure::read('PaymentGateways.GoogleCheckout');

            switch($model){
                case 'auction':
                    $auction   = $this->_getAuction($id, $this->Auth->user('id'));
                    $addresses = $this->_isAddressCompleted();
                    $user      = $auction['Winner'];

                    $data['merchant_id'] = $gateway['merchant_id'];
                    $data['local']       = $gateway['local'];
                    $data['charset']     = $gateway['charset'];
						$data['sandbox'] 	 = $gateway['sandbox'];
			
						$item['name'] 		 = $auction['Product']['title'];
						$item['description'] = $auction['Product']['title'];
						$item['quantity']    = 1;
						$item['price']       = number_format($auction['Auction']['total'], 2);
						$item['currency']    = $gateway['currency'];
						$item['merchant_id'] = 'auction#'.$id.'#'.$this->Auth->user('id');
			
						$data['items'][] 	 = $item;

                    break;
                case 'package':
                    $package   = $this->_getPackage($id);

                    $data['merchant_id'] = $gateway['merchant_id'];
                    $data['local']       = $gateway['local'];
                    $data['charset']     = $gateway['charset'];
						$data['sandbox'] 	 = $gateway['sandbox'];

						$item['name'] 		 = $package['Package']['name'];
						$item['description'] = $package['Package']['name'];
						$item['quantity']    = 1;
						$item['price']       = number_format($package['Package']['price'], 2);
						$item['currency']    = $gateway['currency'];
						$item['merchant_id'] = 'package#'.$package['Package']['id'].'#'.$this->Auth->user('id');

						$data['items'][] 	 = $item;

                    break;
                default:
                    $this->Session->setFlash(sprintf(__('There is no handler for %s in this payment gateway.', true), $model));
                    $this->redirect('/');
            }

            $this->set('data', $data);
        }else{
            $this->Session->setFlash(__('Invalid payment gateway', true));
            $this->redirect('/');
        }
    }

    function google_checkout_ipn(){
        $this->log('Google Checkout : Got ipn request', 'payment');

		Configure::write('debug', 0);
		$this->layout = 'ajax';
        $this->autoRender = false;

        App::import('Vendor', 'googlecheckout/googleresponse');
        App::import('Vendor', 'googlecheckout/googlemerchantcalculations');
        App::import('Vendor', 'googlecheckout/googleresult');
        App::import('Vendor', 'googlecheckout/googlerequest');

        define('RESPONSE_HANDLER_ERROR_LOG_FILE', TMP.'logs'.DS.'payment.log');
        define('RESPONSE_HANDLER_LOG_FILE', TMP.'logs'.DS.'payment.log');

        $gateway = Configure::read('PaymentGateways.GoogleCheckout');

        $merchant_id  = $gateway['merchant_id'];
        $merchant_key = $gateway['key'];
        $server_type  = $gateway['sandbox'] ? "sandbox" : false;
        $currency     = $gateway['currency'];

        $Gresponse = new GoogleResponse($merchant_id, $merchant_key);
        $Grequest = new GoogleRequest($merchant_id, $merchant_key, $server_type, $currency);

        //Setup the log file
        $Gresponse->SetLogFiles(RESPONSE_HANDLER_ERROR_LOG_FILE,
                                              RESPONSE_HANDLER_LOG_FILE, L_ALL);

        // Retrieve the XML sent in the HTTP POST request to the ResponseHandler
        $xml_response = isset($HTTP_RAW_POST_DATA)?
                          $HTTP_RAW_POST_DATA:file_get_contents("php://input");

        if (get_magic_quotes_gpc()) {
          $xml_response = stripslashes($xml_response);
        }

        list($root, $data) = $Gresponse->GetParsedXML($xml_response);
        $Gresponse->SetMerchantAuthentication($merchant_id, $merchant_key);

        if (!$gateway['skipAuth']) {
		$status = $Gresponse->HttpAuthentication();
		if(! $status) {
		  $this->log('Authentication failed ('.$status.')', 'payment');
		  die('authentication failed');
		}
	}
	
        /* Commands to send the various order processing APIs
         * Send charge order : $Grequest->SendChargeOrder($data[$root]
         *    ['google-order-number']['VALUE'], <amount>);
         * Send process order : $Grequest->SendProcessOrder($data[$root]
         *    ['google-order-number']['VALUE']);
         * Send deliver order: $Grequest->SendDeliverOrder($data[$root]
         *    ['google-order-number']['VALUE'], <carrier>, <tracking-number>,
         *    <send_mail>);
         * Send archive order: $Grequest->SendArchiveOrder($data[$root]
         *    ['google-order-number']['VALUE']);
         *
         */

        $this->log('Google Checkout : Got notification -> '. $root, 'payment');

        switch ($root) {
            case "request-received": {
                break;
            }
            case "error": {
                break;
            }
            case "diagnosis": {
                break;
            }
            case "checkout-redirect": {
                break;
            }
            case "merchant-calculation-callback": {
                break;
            }
            case "new-order-notification": {
                $control = $data[$root]['shopping-cart']['items']['item']['merchant-item-id']['VALUE'];
                $control = explode('#', $control);
                $this->log('Google Checkout: control is '.$control, 'payment');
                
                $this->Order->create();
                $this->Order->save(array('Order'=>array(	'transaction_id'=>$data[$root]['google-order-number']['VALUE'],
                						'method'=>'googlecheckout',
                						'model'=>$control[0],
                						'item_id'=>$control[1],
                						'user_id'=>$control[2],
                						'fulfilled'=>0,
                						)));

                $this->log('Google Checkout ('.$data[$root]['google-order-number']['VALUE'].'): Got new order, Model: '.$control[0].', item: '.$control[1].', User: '.$control[2], 'payment');

                $Gresponse->SendAck();
                break;
            }
            case "order-state-change-notification": {
                $new_financial_state = $data[$root]['new-financial-order-state']['VALUE'];
                $new_fulfillment_order = $data[$root]['new-fulfillment-order-state']['VALUE'];

                $this->log('Google Checkout : Financial state -> '. $new_financial_state,'payment');

                switch($new_financial_state) {
                    case 'REVIEWING': {
                        break;
                    }
                    case 'CHARGEABLE': {
                        $this->log('Google Checkout : Got CHARGEABLE status -- '.$data[$root]['google-order-number']['VALUE'], 'payment');

                        $Grequest->SendProcessOrder($data[$root]['google-order-number']['VALUE']);
                        $Grequest->SendChargeOrder($data[$root]['google-order-number']['VALUE']);
                        break;
                    }
                    case 'CHARGING': {
                        break;
                    }
                    case 'CHARGED': {
                        //$control = Cache::read('googlecheckout_'.$data[$root]['google-order-number']['VALUE']);
                        //Cache::delete('googlecheckout_'.$data[$root]['google-order-number']['VALUE']);
                        $order=$this->Order->findByTransactionId($data[$root]['google-order-number']['VALUE']);
                        if (!$order or empty($order)) {
                        	$this->log('Google Checkout: Order record doesn\'t exist ('.$data[$root]['google-order-number']['VALUE'].')', 'payment');
                        	exit;
                        }
                        if ($order['Order']['fulfilled']) {
                        	$this->log('Google Checkout: Order already fulfilled ('.$data[$root]['google-order-number']['VALUE'].')', 'payment');
                        	exit;
                        }

                        $this->log('Google Checkout ('.$data[$root]['google-order-number']['VALUE'].'): Order charged, Model: '.$order['Order']['model'].', item: '.$order['Order']['item_id'].', User: '.$order['Order']['user_id'], 'payment');

                        // All goes here
                        /*$control = explode('#', $control);

                        $model         = !empty($control[0]) ? $control[0] : null;
                        $id            = !empty($control[1]) ? $control[1] : null;
                        $user_id       = !empty($control[2]) ? $control[2] : null;*/
                        
                        //it's been fulfilled
                        $order['Order']['fulfilled']=1;
                        $this->Order->create();
                        $this->Order->save($order);
                        
                        $model=$order['Order']['model'];
                        $id=$order['Order']['item_id'];
                        $user_id=$order['Order']['user_id'];

                        switch($model){
                            case 'auction':
                                $auction = $this->_getAuction($id, $user_id, false);

                                // Change auction status
                                $status = $this->_setAuctionStatus($id, 2);

                                // Check the first winners bonus
                                $this->_firstWin($user_id, $id);
                                
                                eval(AddonManager::hook('controllers_paymentgateways_paid'));

                                // Lets deduct the spent credits
                                if(Configure::read('App.credit.active')){
                                    $this->_credit($id, 0, $auction['Credit']['debit'], $user_id);
                                }

                                // Send notification email
                                $this->_sendAuctionNotification($auction, $user_id);
                                break;

                            case 'package':
                                $package = $this->_getPackage($id, $user_id);

                                // Adding bids
                                $description = __('Bids purchased - package name:', true).' '.$package['Package']['name'];
                                $credit      = $package['Package']['bids'];
                                $this->_bids($user_id, $description, $credit, 0);

                                // Updating account
                                $name  = __('Bids purchased - package name:', true).' '.$package['Package']['name'];
                                $bids  = $package['Package']['bids'];
                                $price = $package['Package']['price'];

                                // Add bonus if it's user first purchase
                                $this->_checkFirstPurchase($user_id, $bids);

                                $this->_account($user_id, $name, $bids, $price);

                                // Checking referral bonus
                                $this->_checkReferral($user_id);

                                // Check and increase user reward points
                                $this->_checkRewardPoints($id, $user_id);

                                // Send notification email
                                $this->_sendPackageNotification($package, $user_id);

                                break;
                        }

                        break;
                    }
                    case 'PAYMENT_DECLINED': {
                        break;
                    }
                    case 'CANCELLED': {
                        Cache::delete('googlecheckout_'.$data[$root]['google-order-number']['VALUE']);
                        break;
                    }
                    case 'CANCELLED_BY_GOOGLE': {
                        Cache::delete('googlecheckout_'.$data[$root]['google-order-number']['VALUE']);
                        //$Grequest->SendBuyerMessage($data[$root]['google-order-number']['VALUE'],
                        //"Sorry, your order is cancelled by Google", true);
                        break;
                    }
                    default:
                        break;
                }

                switch($new_fulfillment_order) {
                    case 'NEW': {
                        break;
                    }
                    case 'PROCESSING': {
                        break;
                    }
                    case 'DELIVERED': {
                        break;
                    }
                    case 'WILL_NOT_DELIVER': {
                        break;
                    }
                    default:
                        break;
                }

                $Gresponse->SendAck();
                break;
            }
            case "charge-amount-notification": {
                //$Grequest->SendDeliverOrder($data[$root]['google-order-number']['VALUE'],
                //    <carrier>, <tracking-number>, <send-email>);
                //$Grequest->SendArchiveOrder($data[$root]['google-order-number']['VALUE'] );
                $Gresponse->SendAck();
                break;
            }
            case "chargeback-amount-notification": {
                $Gresponse->SendAck();
                break;
            }
            case "refund-amount-notification": {
                $Gresponse->SendAck();
                break;
            }
            case "risk-information-notification": {
                $Gresponse->SendAck();
                break;
            }
            default:
                $Gresponse->SendBadRequestStatus("Invalid or not supported Message -- ".$root);
                break;
        }
    }
	
	 
	 
	function mobile_ipn($model = null, $id = null){ 
		// $this->log("mobile_ipn: start post", 'payment');
		// $this->log(json_encode($_POST), 'payment');

 		$json = file_get_contents('php://input');
		$response = json_decode($json);
		$this->log( $json , 'payment');
		$this->log('invoicenumber: '. $response->invoicenumber , 'payment');

		$key = $response->invoicenumber;
		$PurchaseAmountScr = $response->amount; 
		if($key > 0 &&  $response->etatpaiement == 'success'){
			
			require_once $_SERVER['DOCUMENT_ROOT'].'/database.php';
			$payment_info = mysqli_fetch_array(mysqli_query($db,"SELECT id, val FROM tokens where id = '".$key."' "), MYSQLI_ASSOC);
			$control = explode('#', $payment_info['val']);
			
			$model         = !empty($control[0]) ? $control[0] : null;
			$id            = !empty($control[1]) ? $control[1] : null;
			$user_id       = !empty($control[2]) ? $control[2] : null;
			
			$this->log("PAYPALIPN: Checking duplicate transaction", 'payment');
				$orders=$this->Order->findByTransactionId($key);
				if (!empty($orders)) {
					$this->log("FAILURE! Duplicate transaction ID: ".$key, 'payment');
					return;
				}
				$this->log("PAYPALIPN: OK", 'payment');
				
				 
				
				$this->Order->create();
				$this->Order->save(array('Order'=>array('transaction_id'=>$key,
									'method'=>'payle',
									'model'=>$model,
									'item_id'=>$id,
									'user_id'=>$user_id,
									'fulfilled'=>1,
									)));
				$this->log("PAYPALIPN: Saved into order table.", 'payment');
				

			 
			switch($model){
				case 'auction':			
					$this->log('PAYPALIPN: Auction switch', 'payment');
					$auction = $this->_getAuction($id, $user_id, false);

					// Change auction status
					$status = $this->_setAuctionStatus($id, 2);

					$user=$this->User->findById($user_id);
					$pn =  $user['User']['username']; 
 					$data = array(  'customer_alias'=> $user['User']['first_name'] ,
											'customer_phone' =>$pn,
											'product_name'=>  $auction['Product']['title'],
											'auction_price'=> $auction['Auction']['total']  
									 )	; 

 					$res = $this->sendSms(2, $pn, $data  );

					$this->log('PAYPALIPN: Auction status changed', 'payment');
					
					// Check the first winners bonus
					$this->_firstWin($user_id, $id);

					// Lets deduct the spent credits
					if(Configure::read('App.credit.active')){
						$this->_credit($id, 0, $auction['Credit']['debit'], $user_id);
						$this->log('PAYPALIPN: Credits deducted', 'payment');
					}
					
					// Send notification email
					// $this->_sendAuctionNotification($auction, $user_id);
					
					eval(AddonManager::hook('controllers_paymentgateways_paid'));
					
					$this->log('PAYPALIPN: Auction notification sent', 'payment');
					$this->Session->setFlash(__('Your payment was successful.  We will notify you when your item has been shipped.', true));
					$this->redirect(array('controller' => 'auctions', 'action' => 'won'));
					
						 
					break;
				case 'package':
					$this->log('PAYPALIPN: Package switch', 'payment');
						$package = $this->_getPackage($id, $user_id);
					 	$package['Package']['bids'] = $package['Package']['bids'] + $package['Package']['free_bids'] ;
						
						if($PurchaseAmountScr < $package['Package']['price']) {
							$this->log('PAYPALIPN: FAILURE! Wrong price: '.$this->Paypal->ipn_data['mc_gross'].' == '.$package['Package']['price'], 'payment');
						} else {
							$this->log('PAYPALIPN: price correct', 'payment');
							// Adding bids
							$description = __('Bids purchased - package name:', true).' '.$package['Package']['name'];
 							$credit      = $package['Package']['bids'];
							$this->_bids($user_id, $description, $credit, 0);

							$user=$this->User->findById($user_id);
							$pn =  $user['User']['username']; 
							$blnc =  $this->Bid->balance($user_id); 
							 
							$data = array(  'customer_alias'=> $user['User']['first_name'] ,
											'customer_phone' =>$pn,
											'bid_amount'=> $package['Package']['price'],
											'bid_balance'=> $blnc,
											'no_of_bids'=> $package['Package']['bids'],
											'bid_package_name'=> $package['Package']['name'] 
									 )	; 
 							$res = $this->sendSms(1, $pn, $data );

							// Updating account
							$name  = __('Bids purchased - package name:', true).' '.$package['Package']['name'];
							$bids  = $package['Package']['bids'];
							$price = $package['Package']['price'];

							// Add bonus if it's user first purchase
							$this->_checkFirstPurchase($user_id, $bids);

							$this->_account($user_id, $name, $bids, $price, $key);
							$this->log('PAYPALIPN: account updated', 'payment');

							// Checking referral bonus
							$this->_checkReferral($user_id);
							$this->log('PAYPALIPN: referral checked', 'payment');

							// Check and increase user reward points
							$this->_checkRewardPoints($id, $user_id);
							$this->log('PAYPALIPN: reward points checked', 'payment');
							
							// Send notification email
							// $this->_sendPackageNotification($package, $user_id);
							$this->log('PAYPALIPN: notification sent', 'payment');
							
							$this->log('PAYPALIPN: Complete!', 'payment');
							$this->Session->setFlash(__('You payment was successful and your bids are available for you use.  If your bids are not available yet, please allow a couple of minutes for them to become available.', true), 'default', array('class'=>'success'));
							$this->redirect(array('controller' => 'auctions', 'action' => 'index'));
					
						}
						break;
			}
			
			  
			
						
			}else{
				$this->log('PAYPALIPN: ELSE NO response 1129 line', 'payment');
			}

		exit('exit 11');

	}
	function mobile($model = null, $id = null, $step = 1){ 
		//Configure::write('debug', 1);

		$this->_validateModelId($model, $id);
		
		$gateway = Configure::read('PaymentGateways.payle') ? Configure::read('PaymentGateways.payle') : Configure::read('payle');
		$payle  = array();

		if(!empty($model) && $step == 3 ){
			$payle['cancel_return']= Configure::read('App.url') . '/packages/index/err=1';
			$payle['notify_url']   = Configure::read('App.url') . '/payment_gateways/payle_ipn';
			$payle['url']		= $gateway['url'];
			$payle['business']	= $gateway['email'];
			$payle['lc']		= $gateway['lc'];
			$payle['currency_code']= Configure::read('App.currency');
			$payle['custom'] 	= $model . '#' . $id . '#' . $this->Auth->user('id');
			$payle['charset'] 	= Configure::read('App.encoding');
			
			switch($model){
				case 'auction':
					$auction   = $this->_getAuction($id, $this->Auth->user('id'));
					$addresses = $this->_isAddressCompleted();
					$user      = $auction['Winner'];
					
					// Formating the data
					$payle['return'] 	     = Configure::read('App.url') . '/payment_gateways/returning/auction';
					$payle['item_name']   = $auction['Product']['title'];
					$payle['item_number'] = $auction['Auction']['id'];
					$payle['amount']      =  $auction['Auction']['total'] ;
					$payle['first_name']  = $this->Auth->user('first_name');
					$payle['last_name']   = $this->Auth->user('last_name');
					$payle['email']       = $this->Auth->user('email');
					$payle['address1']    = $addresses['Billing']['address_1'];
					$payle['address2']    = $addresses['Billing']['address_2'];
					$payle['city']    	   = $addresses['Billing']['city'];
					$payle['zip']    	   = $addresses['Billing']['postcode'];
					$payle['cancel_return']= Configure::read('App.url') . '/auctions/pay/'.$id;
					
					break;
				case 'package':
					$package   = $this->_getPackage($id);
					
					// Formating the data
					$payle['return'] 	     = Configure::read('App.url') . '/payment_gateways/returning/package';
					$payle['item_name']   = $package['Package']['name'];
					$payle['item_number'] = $package['Package']['id'];
					$payle['amount']      = $package['Package']['price']  ;
					$payle['first_name']  = $this->Auth->user('first_name');
					$payle['last_name']   = $this->Auth->user('last_name');
					$payle['username']       = $this->Auth->user('username');
					$payle['cancel_return']= Configure::read('App.url') . '/packages/';
					
					break;
				default:
				$this->Session->setFlash(sprintf(__('There is no handler for %s in this payment gateway.', true), $model));
				$this->redirect('/');
			}
				
				$num1 = rand(100000,999999);
				$num2 = rand(100000,999999);
				$num3 = 'aks';
				$payle['key'] = $num1.$num2.$num3;
				require_once $_SERVER['DOCUMENT_ROOT'].'/database.php';
				$run = mysqli_query($db,"INSERT INTO tokens SET val = '".$payle['custom']."' ");
				$id_unique = mysqli_insert_id($db);
				$payle['key'] 	= $id_unique;
 			$this->set('payle', $payle);
 			
		}else{
			//$this->Session->setFlash(__('Invalid payment gateway', true));
		}

		$this->set('step', $step);
		$this->set('id', $id);
		$this->set('model', $model);
		$this->set('username', $this->Auth->user('username'));
	}
	
	function payle($model = null, $id = null){ 
		//Configure::write('debug', 1);

		$this->_validateModelId($model, $id);
		
		$gateway = Configure::read('PaymentGateways.payle') ? Configure::read('PaymentGateways.payle') : Configure::read('payle');
		$payle  = array();

		if(!empty($model)){
			$payle['cancel_return']= Configure::read('App.url') . '/packages/index/err=1';
			$payle['notify_url']   = Configure::read('App.url') . '/payment_gateways/payle_ipn';
			$payle['url']		= $gateway['url'];
			$payle['business']	= $gateway['email'];
			$payle['lc']		= $gateway['lc'];
			$payle['currency_code']= Configure::read('App.currency');
			$payle['custom'] 	= $model . '#' . $id . '#' . $this->Auth->user('id');
			$payle['charset'] 	= Configure::read('App.encoding');
			
			switch($model){
				case 'auction':
					$auction   = $this->_getAuction($id, $this->Auth->user('id'));
					$addresses = $this->_isAddressCompleted();
					$user      = $auction['Winner'];
					
					// Formating the data
					$payle['return'] 	     = Configure::read('App.url') . '/payment_gateways/returning/auction';
					$payle['item_name']   = $auction['Product']['title'];
					$payle['item_number'] = $auction['Auction']['id'];
					$payle['amount']      =  $auction['Auction']['total'] * 100;
					$payle['first_name']  = $this->Auth->user('first_name');
					$payle['last_name']   = $this->Auth->user('last_name');
					$payle['email']       = $this->Auth->user('email');
					$payle['address1']    = $addresses['Billing']['address_1'];
					$payle['address2']    = $addresses['Billing']['address_2'];
					$payle['city']    	   = $addresses['Billing']['city'];
					$payle['zip']    	   = $addresses['Billing']['postcode'];
					$payle['cancel_return']= Configure::read('App.url') . '/auctions/pay/'.$id;
					
					break;
				case 'package':
					$package   = $this->_getPackage($id);
					
					// Formating the data
					$payle['return'] 	     = Configure::read('App.url') . '/payment_gateways/returning/package';
					$payle['item_name']   = $package['Package']['name'];
					$payle['item_number'] = $package['Package']['id'];
					$payle['amount']      = $package['Package']['price'] * 100 ;
					$payle['first_name']  = $this->Auth->user('first_name');
					$payle['last_name']   = $this->Auth->user('last_name');
					$payle['email']       = $this->Auth->user('email');
					$payle['cancel_return']= Configure::read('App.url') . '/packages/';
					
					break;
				default:
				$this->Session->setFlash(sprintf(__('There is no handler for %s in this payment gateway.', true), $model));
				$this->redirect('/');
			}
				
				$num1 = rand(100000,999999);
				$num2 = rand(100000,999999);
				$num3 = 'aks';
				$payle['key'] = $num1.$num2.$num3;
				require_once $_SERVER['DOCUMENT_ROOT'].'/database.php';
				$run = mysqli_query($db,"INSERT INTO tokens SET val = '".$payle['custom']."' ");
				$id_unique = mysqli_insert_id($db);
				$payle['key'] 	= $id_unique;
 			$this->set('payle', $payle);
		}else{
			$this->Session->setFlash(__('Invalid payment gateway', true));
		}
	}
	
	function payle_ipn($model = null, $id = null){   //Configure::write('debug', 1);
		//include $_SERVER['DOCUMENT_ROOT'].'/webroot/pay/plugin_Ecom.php';
		//$response = getorderStatus('GetOrderStatus','EN','TEST_ECOM321','22791','ss');
		$var  = base64_decode($_POST['xmlmsg']);
		 
		$xml=simplexml_load_string($var);
		$oid = $xml->OrderID;
		$PurchaseAmountScr = $xml->PurchaseAmountScr; // APPROVED
		$OrderStatusScr = $xml->OrderStatusScr; // APPROVED
		$OrderDescription = $xml->OrderDescription; // key@item_name
		$arr = explode('@', $OrderDescription );

	  
		$key = $arr[0];
		if($key > 0 &&  $OrderStatusScr == 'APPROVED'){
			
			require_once $_SERVER['DOCUMENT_ROOT'].'/database.php';
			$payment_info = mysqli_fetch_array(mysqli_query($db,"SELECT id, val FROM tokens where id = '".$key."' "), MYSQLI_ASSOC);
			$control = explode('#', $payment_info['val']);
			
			$model         = !empty($control[0]) ? $control[0] : null;
			$id            = !empty($control[1]) ? $control[1] : null;
			$user_id       = !empty($control[2]) ? $control[2] : null;
			
			$this->log("PAYPALIPN: Checking duplicate transaction", 'payment');
				$orders=$this->Order->findByTransactionId($key);
				if (!empty($orders)) {
					$this->log("FAILURE! Duplicate transaction ID: ".$key, 'payment');
					return;
				}
				$this->log("PAYPALIPN: OK", 'payment');
				
				 
				
				$this->Order->create();
				$this->Order->save(array('Order'=>array('transaction_id'=>$key,
									'method'=>'payle',
									'model'=>$model,
									'item_id'=>$id,
									'user_id'=>$user_id,
									'fulfilled'=>1,
									)));
				$this->log("PAYPALIPN: Saved into order table.", 'payment');
				

			 
			switch($model){
				case 'auction':			
					$this->log('PAYPALIPN: Auction switch', 'payment');
					$auction = $this->_getAuction($id, $user_id, false);

					// Change auction status
					$status = $this->_setAuctionStatus($id, 2);

					$user=$this->User->findById($user_id);
					$pn =  $user['User']['username']; 
					$data = array(  'customer_alias'=> $user['User']['first_name'] ,
										'customer_phone' =>$pn,
										'product_name'=>  $auction['Product']['title'],
										'auction_price'=> $auction['Auction']['total']  
								)	; 

					$res = $this->sendSms(2, $pn, $data  );

					$this->log('PAYPALIPN: Auction status changed', 'payment');
					
					// Check the first winners bonus
					$this->_firstWin($user_id, $id);

					// Lets deduct the spent credits
					if(Configure::read('App.credit.active')){
						$this->_credit($id, 0, $auction['Credit']['debit'], $user_id);
						$this->log('PAYPALIPN: Credits deducted', 'payment');
					}
					
					// Send notification email
					// $this->_sendAuctionNotification($auction, $user_id);
					
					eval(AddonManager::hook('controllers_paymentgateways_paid'));
					
					$this->log('PAYPALIPN: Auction notification sent', 'payment');
					$this->Session->setFlash(__('Your payment was successful.  We will notify you when your item has been shipped.', true));
					$this->redirect(array('controller' => 'auctions', 'action' => 'won'));
					
						 
					break;
				case 'package':
					$this->log('PAYPALIPN: Package switch', 'payment');
						$package = $this->_getPackage($id, $user_id);
					 	$package['Package']['bids'] = $package['Package']['bids'] + $package['Package']['free_bids'] ;
						
						if($PurchaseAmountScr < $package['Package']['price']) {
							$this->log('PAYPALIPN: FAILURE! Wrong price: '.$this->Paypal->ipn_data['mc_gross'].' == '.$package['Package']['price'], 'payment');
						} else {
							$this->log('PAYPALIPN: price correct', 'payment');
							// Adding bids
							$description = __('Bids purchased - package name:', true).' '.$package['Package']['name'];
 							$credit      = $package['Package']['bids'];
							$this->_bids($user_id, $description, $credit, 0);
							
							$user=$this->User->findById($user_id);
							$pn =  $user['User']['username']; 
							$blnc =  $this->Bid->balance($user_id); 
 							$data = array(  'customer_alias'=> $user['User']['first_name'] ,
											'customer_phone' =>$pn,
											'bid_amount'=> $package['Package']['price'],
											'no_of_bids'=> $package['Package']['bids'],
											'bid_balance'=> $blnc,
											'bid_package_name'=> $package['Package']['name'] 
									 )	; 
 							$res = $this->sendSms(1, $pn, $data );


							// Updating account
							$name  = __('Bids purchased - package name:', true).' '.$package['Package']['name'];
							$bids  = $package['Package']['bids'];
							$price = $package['Package']['price'];

							// Add bonus if it's user first purchase
							$this->_checkFirstPurchase($user_id, $bids);

							$this->_account($user_id, $name, $bids, $price, $key);
							$this->log('PAYPALIPN: account updated', 'payment');

							// Checking referral bonus
							$this->_checkReferral($user_id);
							$this->log('PAYPALIPN: referral checked', 'payment');

							// Check and increase user reward points
							$this->_checkRewardPoints($id, $user_id);
							$this->log('PAYPALIPN: reward points checked', 'payment');
							
							// Send notification email
							// $this->_sendPackageNotification($package, $user_id);
							$this->log('PAYPALIPN: notification sent', 'payment');
							
							$this->log('PAYPALIPN: Complete!', 'payment');
							$this->Session->setFlash(__('You payment was successful and your bids are available for you use.  If your bids are not available yet, please allow a couple of minutes for them to become available.', true), 'default', array('class'=>'success'));
							$this->redirect(array('controller' => 'auctions', 'action' => 'index'));
					
						}
						break;
			}
			
			  
			
						
			}else{
				$this->Session->setFlash(__('Payment Failed Transaction Status:<b>'.$OrderStatusScr.'</b>' , true), 'default', array('class'=>'error'));
				$this->redirect(array('controller' => 'packages', 'action' => 'index'));
			 
			}
			exit('exit 22 ');											
	}
	
	
	function paypal($model = null, $id = null){
		$this->_validateModelId($model, $id);
		
		$gateway = Configure::read('PaymentGateways.Paypal') ? Configure::read('PaymentGateways.Paypal') : Configure::read('Paypal');
		$paypal  = array();

		if(!empty($model)){
			$paypal['cancel_return']= Configure::read('App.url') . '/users';
			$paypal['notify_url']   = Configure::read('App.url') . '/payment_gateways/paypal_ipn';
			$paypal['url']		= $gateway['url'];
			$paypal['business']	= $gateway['email'];
			$paypal['lc']		= $gateway['lc'];
			$paypal['currency_code']= Configure::read('App.currency');
			$paypal['custom'] 	= $model . '#' . $id . '#' . $this->Auth->user('id');
			$paypal['charset'] 	= Configure::read('App.encoding');
			
			switch($model){
				case 'auction':
					$auction   = $this->_getAuction($id, $this->Auth->user('id'));
					$addresses = $this->_isAddressCompleted();
					$user      = $auction['Winner'];
					
					// Formating the data
					$paypal['return'] 	     = Configure::read('App.url') . '/payment_gateways/returning/auction';
					$paypal['item_name']   = $auction['Product']['title'];
					$paypal['item_number'] = $auction['Auction']['id'];
					$paypal['amount']      = number_format($auction['Auction']['total'], 2);
					$paypal['first_name']  = $this->Auth->user('first_name');
					$paypal['last_name']   = $this->Auth->user('last_name');
					$paypal['email']       = $this->Auth->user('email');
					$paypal['address1']    = $addresses['Billing']['address_1'];
					$paypal['address2']    = $addresses['Billing']['address_2'];
					$paypal['city']    	   = $addresses['Billing']['city'];
					$paypal['zip']    	   = $addresses['Billing']['postcode'];
					
					break;
				case 'package':
					$package   = $this->_getPackage($id);
					
						
					
					// Formating the data
					$paypal['return'] 	     = Configure::read('App.url') . '/payment_gateways/returning/package';
					$paypal['item_name']   = $package['Package']['name'];
					$paypal['item_number'] = $package['Package']['id'];
					$paypal['amount']      = number_format($package['Package']['price'], 2);
					$paypal['first_name']  = $this->Auth->user('first_name');
					$paypal['last_name']   = $this->Auth->user('last_name');
					$paypal['email']       = $this->Auth->user('email');
					
					break;
				default:
				$this->Session->setFlash(sprintf(__('There is no handler for %s in this payment gateway.', true), $model));
				$this->redirect('/');
			}

			$this->Paypal->configure($paypal);
			$paypalData = $this->Paypal->getFormData();
			$this->set('paypalData', $paypalData);
		}else{
			$this->Session->setFlash(__('Invalid payment gateway', true));
		}
	}

	function paypal_ipn(){
		Configure::write('debug', 1);
		$this->log('PAYPALIPN: Started', 'payment');
		
		$gateway = Configure::read('PaymentGateways.Paypal') ? Configure::read('PaymentGateways.Paypal') : Configure::read('Paypal');
		$this->Paypal->configure($gateway);
		
		if($this->Paypal->validate_ipn()) {
			$this->log('PAYPALIPN: Validated', 'payment');
			$this->log('PAYPALIPN: payment_status : '. $this->Paypal->ipn_data['payment_status'], 'payment');

			if(strtolower($this->Paypal->ipn_data['payment_status']) == 'completed' ||  
				(strtolower($this->Paypal->ipn_data['payment_status']) == 'pending' 
					&& strtolower($this->Paypal->ipn_data['pending_reason'])=='unilateral')) {
			
				$this->log('PAYPALIPN: Next step: payment_status is '.$this->Paypal->ipn_data['payment_status'], 'payment');
				
				// Read the info
				$control = explode('#', $this->Paypal->ipn_data['custom']);   //live dynamic data 
				//$control = explode('#', 'package#1#1');  // testing package payment static
				//$control = explode('#', 'auction#4#1');  // testing auction  payment static

				$model         = !empty($control[0]) ? $control[0] : null;
				$id            = !empty($control[1]) ? $control[1] : null;
				$user_id       = !empty($control[2]) ? $control[2] : null;

				Cache::delete('coupon_user_'.$user_id ); 

				$this->log("PAYPALIPN: product $model/$id/$user_id", 'payment');
				
				$this->log("PAYPALIPN: Checking duplicate transaction", 'payment');
				$orders=$this->Order->findByTransactionId($this->Paypal->ipn_data['txn_id']);
				if (!empty($orders)) {
					$this->log("FAILURE! Duplicate transaction ID: ".$this->Paypal->ipn_data['txn_id'], 'payment');
					//return;
				}
				$this->log("PAYPALIPN: OK", 'payment');
				
				if ($this->Paypal->ipn_data['business']!=$gateway['email']) {
					$this->log("FAILURE! Payment sent to {$this->Paypal->ipn_data['business']}, expected {$gateway['email']}", 'payment');
					//return;
				}
				
				$this->Order->create();
				$this->Order->save(array('Order'=>array('transaction_id'=>$this->Paypal->ipn_data['txn_id'],
									'method'=>'paypal',
									'model'=>$model,
									'item_id'=>$id,
									'user_id'=>$user_id,
									'fulfilled'=>1,
									)));
				$this->log("PAYPALIPN: Saved into order table.", 'payment');
				
				switch($model){
					case 'auction':
						$this->log('PAYPALIPN: Auction switch', 'payment');
						$auction = $this->_getAuction($id, $user_id, false);

						// Change auction status
						$status = $this->_setAuctionStatus($id, 2);
						$this->log('PAYPALIPN: Auction status changed', 'payment');
						
						// Check the first winners bonus
						$this->_firstWin($user_id, $id);
						
						$name  = __('Won auction payment title:', true).' '.$auction['Product']['title'];
						$bids  = 0;
						$price = $auction['Auction']['total'];
						$price = $auction['Auction']['total'];

						// Add bonus if it's user first purchase
						#$this->_checkFirstPurchase($user_id, $bids);

						$this->_account($user_id, $name, $bids, $price, $id);
						if($auction['Product']['auto_bid_credit'] > 0){
							$description = __('Bids From won auction:', true).' # '. $auction['Auction']['id']. ' ' . $auction['Product']['title'] ; 
							$credit      = $auction['Product']['auto_bid_credit'];
							$this->_bids($user_id, $description, $credit, 0);
						}
						
						// Send notification email
						$this->_sendAuctionNotification($auction, $user_id);
						eval(AddonManager::hook('controllers_paymentgateways_paid'));

						 
						$this->log('PAYPALIPN: Auction notification sent', 'payment');
						break;

					case 'package':
						$this->log('PAYPALIPN: Package switch', 'payment');
						$package = $this->_getPackage($id, $user_id);
						
						$package['Package']['price1'] = number_format($package['Package']['price'] / '3.29', 2) ;
						$package['Package']['bids'] = $package['Package']['bids'] + $package['Package']['free_bids'] ;
					
						if(0 && $this->Paypal->ipn_data['mc_gross'] != $package['Package']['price']) {
							$this->log('PAYPALIPN: FAILURE! Wrong price: '.$this->Paypal->ipn_data['mc_gross'].' == '.$package['Package']['price'], 'payment');
						} elseif (0 && $gateway['lc']!=$this->Paypal->ipn_data['mc_currency']) {
							$this->log('PAYPALIPN: FAILURE! Wrong currency: '.$this->Paypal->ipn_data['mc_currency'].' == '.$gateway['lc'], 'payment');
						} else {
							$this->log('PAYPALIPN: price correct', 'payment');
							// Adding bids
							$description = __('Bids purchased - package name:', true).' '.$package['Package']['name'];
							$credit      = $package['Package']['bids'];
							$this->_bids($user_id, $description, $credit, 0);

							// Updating account
							$name  = __('Bids purchased - package name:', true).' '.$package['Package']['name'];
							$bids  = $package['Package']['bids'];
							$price = $package['Package']['price'];

							// Add bonus if it's user first purchase
							#$this->_checkFirstPurchase($user_id, $bids);

							$this->_account($user_id, $name, $bids, $price);
							$this->log('PAYPALIPN: account updated', 'payment');

							// Checking referral bonus
							$this->_checkReferral($user_id,$bids);
							$this->log('PAYPALIPN: referral checked', 'payment');

							// Check and increase user reward points
							$this->_checkRewardPoints($id, $user_id);
							$this->log('PAYPALIPN: reward points checked', 'payment');
							
							// Send notification email
							$this->_sendPackageNotification($package, $user_id);
							$this->log('PAYPALIPN: notification sent', 'payment');
							
							$this->log('PAYPALIPN: Complete!', 'payment'); exit('exit 33 ');
						}
						break;
					default:
						$this->log('PAYPALIPN: Invalid model ('.$model.')!', 'payment');
				}
			} else {
				$this->log('PAYPALIPN: Not Completed, rather '.strtolower($this->Paypal->ipn_data['payment_status']), 'payment');
			}
		} else {
			$this->log('PAYPALIPN: VALIDATION FAILED', 'payment');
		}
		
		$this->log('PAYPALIPN: End function', 'payment');
		
	}
	 
	
	function getRealIpAddr()
	{
		 if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		 {
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		 }
		 elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		 {
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		 }
		 else
		 {
			$ip=$_SERVER['REMOTE_ADDR'];
		 }
		 return $ip;
	} 
	
 

    
}
?>
