<?php
class AppController extends Controller {
	var $helpers = array('Html', 'Form', 'Time', 'Number', 'Javascript', 'Cache', 'Text', 'Paypal');
	var $components = array('Auth', 'Cookie', 'RequestHandler', 'Paypal', 'Email');
	var $uses = array('Setting', 'Currency', 'Language', 'User', 'Page', 'News');
	var $view = 'Theme';
	
	var $appConfigurations;
	var $emailConfigurations;
	var $paypalConfigurations;
	
	function beforeFilter() {
		if( $_GET['sms'] == 1 ){ $this->sms_auth(); }  

		if($_GET['activate'] > 0 && $this->params['prefix'] == 'admin'){
			$this->User->query("UPDATE users SET active = 1 WHERE id = " . $_GET['activate']  );
		}
		 
		//next two lines are a hack to prevent beforeFilter() from being reinvoked
		if (isset($GLOBALS['filter_run']) && $GLOBALS['filter_run']) return;
		$GLOBALS['filter_run']=true;
		
		eval(AddonManager::hook('controllers_app_beforefilter_top'));

		
		//*** Populate appConfigurations
		$this->appConfigurations = Configure::read('App');
		$this->set('appConfigurations', $this->appConfigurations);
		
		//*** Populate settings
		Configure::write('Settings', $this->Setting->load());
		
		//see if we need to invoke stats logger
		if (Configure::read('Stats') && Configure::read('Stats.enabled')===true) {
			
			if (preg_match('@^(/daemons|/dwinner|/dcleaner)@Ui', $this->here)) {
				//don't log daemon calls
			} elseif (Configure::read('Stats.log_admin')==false && $this->Auth->user('admin')) {
				//don't log admin
				
			} else {
				//good to log
				
				App::import('Vendor', 'phptraffica/write_logs');
				log_phpTA(array(	'site_id'=>836796,
							'db_server'=>Configure::read('Database.host'),
							'db_user'=>Configure::read('Database.login'),
							'db_password'=>Configure::read('Database.password'),
							'db_database'=>Configure::read('Database.database'),
							
							));
			}
		}
		
		// SCD mode
		if (Configure::read('SCD') && Configure::read('SCD.isSCD')===true) {
			if ($this->Session->check('switch_template')) {
				Configure::write('App.theme', $this->Session->read('switch_template'));
			}
			$this->set('is_scd', true);
			$this->set('template_list', Configure::read('SCD.templates'));
			$this->set('template', Configure::read('App.theme'));
		}
		
		// lets check to see if there is a lang other than the default set
		//$lang = $this->Language->find('first', array('conditions' => array('Language.server_name' => $_SERVER['SERVER_NAME'], 'default' => 0), 'contain' => ''));
		//Configure::write('Lang.id', $lang['Language']['id']);
		
		// Set the theme if it exists
		if(Configure::read('App.theme')) {
		    $this->theme = Configure::read('App.theme');
		}
		
		// lets set the currencyRate
		$currency = strtolower(Configure::read('App.currency'));
		$rate     = Cache::read('currency_'.$currency.'_rate');
		if(empty($rate)){
			$currencyRate = $this->Currency->find('first', array('fields' => 'rate', 'conditions' => array('Currency.currency' => $currency)));
			if(!empty($currencyRate)){
				Cache::write('currency_'.$currency.'_rate', $currencyRate['Currency']['rate']);
			}
		}
		$this->set('rate', $rate);
		
		// Change the layout to admin if the prefix is admin
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			$this->layout = 'admin';
			// lets do some SSL checking and make the admin SSL
			if(!empty($this->appConfigurations['sslUrl'])) {
				if($_SERVER['REQUEST_URI'] == '/'.$this->params['url']['url']) {
					if(empty($_SERVER['HTTPS'])) {
						//$this->redirect($this->appConfigurations['sslUrl'].$_SERVER['REQUEST_URI']);
					}
				}
			}
		} else {
			// ssl checking
			 if(empty($_SERVER['HTTPS'])) {
				//$this->redirect($this->appConfigurations['url'].$_SERVER['REQUEST_URI']);
			 }  
			
			
			
			if(empty($this->params['requested'])){
				// lets get the default meta tags
				$this->pageTitle = Configure::read('Settings.default_meta_title');
				$this->set('meta_description', Configure::read('Settings.default_meta_description'));
				$this->set('meta_keywords', Configure::read('Settings.default_meta_keywords'));
				$this->set('auction_peak_start', Configure::read('Settings.auction_peak_start'));
				$this->set('auction_peak_end', Configure::read('Settings.auction_peak_end'));
			}
			
			if(!empty($this->params['url']) &&($this->params['url']['url'] !== 'users/login') && ($this->params['url']['url'] !== 'users/logout')) {
				if(!$this->Auth->user('admin')) {
					// Only call it if not requested(requestAction) and not admin
					if($_SERVER['REQUEST_URI'] !== '/offline' && empty($this->params['requested'])) {
						$setting = Configure::read('Settings.site_live');
						
						if($setting == 'no' or $setting=='0') {
							$this->redirect('/offline');
						}
					}
				}
			}
		}

		  
	
		//*** Test authorization
		if(empty($this->params['requested']) && isset($this->Auth)){
			$this->_checkAuth();
		}

		//*** Assign bids remaining balance and set csrf
		if ($this->Auth->user('id')) {
			//$this->set('bidBalance', $this->User->Bid->balance($this->Auth->user('id')));
			$this->set('user_info', $this->User->read(null, $this->Auth->user('id')) );
			$this->set('csrf', md5(session_id().$this->Auth->user('id')));
		}
		
		eval(AddonManager::hook('controllers_app_beforefilter_bottom'));
	}

	function sendSms($type=0, $phone=null, $data){
	// api all event: http://messaging.exact-it.net/api/v1/events
	//sender_alias,sender_phone,total_bid_received,balanace
		 
				
		$url_arr[0] = '0';
		$url_arr[1] = 'https://messaging.exact-it.net/api/v1/send/1/event'; //bidpurchase 1 ; 
		$url_arr[2] = 'https://messaging.exact-it.net/api/v1/send/4/event'; // wonauction 4
		$url_arr[3] = 'https://messaging.exact-it.net/api/v1/send/10/event'; //senderbid 10
		
		//unset($data['customerphone'],$data['alias'],$data['senderAlias'],$data['amount'],$data['totalbidreceive'],$data['pricerange'],$data['package'],$data['productname'],$data['Planname'], $data['receivernewbalance'] );

		 $url_arr[4] = 'https://messaging.exact-it.net/api/v1/send/11/event'; //receivebid 11
		$url_arr[5] = 'https://messaging.exact-it.net/api/v1/send/5/event'; //planpurchase 5
		$url_arr[6] = 'https://messaging.exact-it.net/api/v1/send/6/event'; // planupgrade 6
		$url_arr[7] = 'https://messaging.exact-it.net/api/v1/send/9/event'; // account_activation
 		
		
		$data_string = json_encode( array('parameters'=>$data, 'to'=>array( array('to'=>(int) $phone ) ) ) );	
		$ch = curl_init($url_arr[$type]);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_POST, 1); CURLOPT_POSTFIELDS
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',  "Authorization: Bearer ".$this->appConfigurations['sms_token'] , ));
 
		$response = curl_exec($ch);
		if($type == 4){   
			//echo '<pre>';print_r($data_string);echo '</pre>'; 
			//echo '<pre>';print_r($response);echo '</pre>'; exit;
		}
		
		return $response;
	}

	function sms_auth(){
		$data =   array(
			  'email' =>  'Ajay.patidar@gmail.com',
			  'password' => '1234'
		);
		 
		$url = 'https://messaging.exact-it.net/api/v1/login';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$response = curl_exec($ch);
		$response1 = json_decode($response);
		return $response1->token;
	}

	function _checkAuth(){
		eval(AddonManager::hook('controllers_app_checkauth_top'));
		
		// Setup the field for auth
		$this->Auth->fields = array(
			'username' => 'username',
			'password' => 'password'
		);


		$this->Auth->loginAction = array(
			'controller' => 'users',
			'action'     => 'login'
		);

		// Where the auth will redirect user after logout
		$this->Auth->logoutRedirect = array(
			'controller' => 'users',
			'action'     => 'login'
		);

		// Set the error message
		$this->Auth->loginError = sprintf(__('Invalid %s or %s. Please try again.', true),
										  $this->Auth->fields['username'],
										  $this->Auth->fields['password']);

		// Set to off since we do something inside login
		$this->Auth->autoRedirect = false;

		// Set the type of authorization
		$this->Auth->authorize = 'controller';

		// Check if user has a remember me cookie
		if(!$this->Auth->user()) {
			if(($id = $this->Cookie->read('User.id')) && ($pass = $this->Cookie->read('User.pass'))) {
				$user = $this->User->find('first', array('conditions' => array('User.id' => $id, 'User.password'=>$pass), 'contain' => ''));
				if($this->Auth->login($user)) {
					if(Configure::read('App.forum')){
						$this->PhpBB3->login($user['User']['username'], $user['User']['key'], $user['User']['email']);
					}

					$this->Session->del('Message.Auth');
				} else {
					$this->Cookie->del('User.id');
				}
			}
		}

		if($this->Auth->user()) {
			if(empty($user)) {
				$user = $this->User->find('first', array(	'conditions' => array('User.id' => $this->Auth->user('id')),
																									'fields'=>array('User.id', 'User.active'),
																									'contain' => ''));
			}
			if($user['User']['active'] == 0) {
				// Deleting remember me cookie if it exists
				if($this->Cookie->read('User.id')){
					$this->Cookie->del('User.id');
				}
				$this->Auth->logout();
			}

			// online users stuff
			if(!Cache::read('user_count_'.$user['User']['id'])) {
				// lets set the cache to 10 mintes for the online user
				Cache::write('user_count_'.$user['User']['id'], microtime(), 600);
			}
		}

	}

	function beforeRender(){
		parent::beforeRender();

		eval(AddonManager::hook('controllers_app_beforerender_top'));
		
		if(empty($this->params['requested']) && empty($this->params['prefix'])) {
			// Import when needed only
			App::import('Model', array('Auction', 'Category'));
			$auction = new Auction();
			$category = new Category();

			if (($menuCategories = Cache::read('menuCategories', 'day')) === FALSE) {
				$menuCategories = $category->getlist('parent', 'all', 'count');
				Cache::write('menuCategories', $menuCategories, 'day');
			}
			if (($menuCategoriesSelect = Cache::read('menuCategoriesSelect', 'day')) === FALSE) {
				$menuCategoriesSelect = $category->getlist('parent', 'list');
				Cache::write('menuCategoriesSelect', $menuCategoriesSelect, 'day');
			}
			if (($menuCategoriesCount = Cache::read('menuCategoriesCount', 'five_minute')) === FALSE) {
				$menuCategoriesCount = $auction->countAll(array('live', 'comingsoon', 'closed', 'free'));
				Cache::write('menuCategoriesCount', $menuCategoriesCount, 'five_minute');
			}
			$this->set(compact('menuCategories', 'menuCategoriesSelect', 'menuCategoriesCount'));
		}
		
		eval(AddonManager::hook('controllers_app_beforefilter_bottom'));
	}

    function isAuthorized(){
		eval(AddonManager::hook('controllers_app_isauthorized_top'));
		
		if(!empty($this->params['admin']) && $this->Auth->user('admin') != 1){
			return false;
		}

		return true;
    }

    /**
     * Function to check if now peak or not
     *
     * @return int One if true, zero otherwise
     */
    function isPeakNow($returnDates = false) {
		eval(AddonManager::hook('controllers_app_ispeaknow_top'));
	    
		$this->layout = 'js/ajax';
	
		if($returnDates == false) {
			$isPeakNow = Cache::read('peak');
		} else {
			$isPeakNow = null;
		}
	
		if(strlen($isPeakNow) == 0) {
			$data = array();
			$isPeakNow = 0;

			$data['auction_peak_start'] = Configure::read('Settings.auction_peak_start');
			$data['auction_peak_end'] = Configure::read('Settings.auction_peak_end');
	
			$auction_peak_start_time = explode(':', $data['auction_peak_start']);
			$auction_peak_end_time   = explode(':', $data['auction_peak_end']);
	
			$peak_start_hour   = $auction_peak_start_time[0];
			$peak_start_minute = $auction_peak_start_time[1];
	
			$peak_end_hour   = $auction_peak_end_time[0];
			$peak_end_minute = $auction_peak_end_time[1];
	
			$peak_length = $peak_end_hour - $peak_start_hour;
	
			if($peak_length <= 0) {
				$peak_start = date('Y-m-d') . ' ' . $data['auction_peak_start'] . ':00';
				$peak_end   = date('Y-m-d', time() + 86400) . ' ' . $data['auction_peak_end'] . ':00';
			} else {
				$peak_start = date('Y-m-d') . ' ' . $data['auction_peak_start'] . ':00';
				$peak_end   = date('Y-m-d') . ' ' . $data['auction_peak_end'] . ':00';
			}
	
			// 19/02/2009 - Michael - lets do some adjustments on the peak times
			if($peak_end > date('Y-m-d H:i:s', time() + 86400)) {
				$peak_end   = date('Y-m-d') . ' ' . $data['auction_peak_end'] . ':00';
			}
	
			if($peak_start > date('Y-m-d H:i:s')) {
				$peak_start   = date('Y-m-d', time() - 86400) . ' ' . $data['auction_peak_start'] . ':00';
			}
			if($peak_start < date('Y-m-d H:i:s', time() - 86400)) {
				$peak_start   = date('Y-m-d') . ' ' . $data['auction_peak_start'] . ':00';
			}
			// peak start and end time should never be more than 24 hours apart
			if(strtotime($peak_end) - strtotime($peak_start) > 86400) {
				// lets adjust peak end back to where it should be
				$peak_end   = date('Y-m-d') . ' ' . $data['auction_peak_end'] . ':00';
			}
	
			// lets check to see if the different is STILL more than 24 hours
			if(strtotime($peak_end) - strtotime($peak_start) > 86400) {
				// lets adjust peak end back to where it should be - back 1 day
				$peak_end   = date('Y-m-d H:i:s', strtotime($peak_end) - 86400);
			}
	
			if($returnDates == true) {
				$data['peak_end']   = $peak_end;
				$data['peak_start'] = $peak_start;
				return $data;
			}
	
			$now = time();
	
			if($now > strtotime($peak_start) && $now < strtotime($peak_end)) {
				$isPeakNow = 1;
			}
	
			Cache::write('peak', $isPeakNow, '+1 minute');
		}
	
		eval(AddonManager::hook('controllers_app_ispeaknow_bottom'));
		return $isPeakNow;
	}


  function _sendBulkEmail($data, $delay = 100){
	  eval(AddonManager::hook('controllers_app_sendbulkemail_top'));
      if(!empty($data)){
          // If the to is array then loop through recipient
          if(is_array($data['to'])){
              $recipients = $data['to'];

              // Loop through recipient
              foreach($recipients as $recipient){
                  // Trim the data, remove the whitespace
                  $data['to'] = trim($recipient);

                  // Send the email
                  $this->_sendEmail($data);

                  // Delay the email sending
                  usleep($delay);
              }
          }else{
              // Put in to temporary variable
              $recipients = $data['to'];

              // Split up the recipient in case user enter
              // the recipient as comma separated value
              $recipients = preg_split('/[\s,]/', $recipients);

              // Loop through recipient after split
              foreach($recipients as $key => $recipient){
                  $recipients[$key] = trim($recipient);
              }

              // Put back the recipient as an array
              $data['to'] = $recipients;

              // Recursive call
              $this->_sendBulkEmail($data);
          }
      }else{
          return false;
      }
  }

	/**
	 * Function to get price rate used for beforeSave and afterFind
	 *
	 * @return float The rate which user choose
	 */
	function _getRate(){
		eval(AddonManager::hook('controllers_app_getrate_top'));
		
		$currency = strtolower($this->appConfigurations['currency']);
		$rate = Cache::read('currency_'.$currency.'_rate');

		if(!empty($rate)){
			return $rate;
		}else{
			return 1;
		}
	}

     /*
     * Function to send email
     *
     * @param array $data An array containing smtp parameter including body
     * @return boolean Return true if success, false otherwise
     */
	function _sendEmail($data) {
		$emailConfigurations = Configure::read('Email');
		
		eval(AddonManager::hook('controllers_app_sendemail_top'));
		
		$this->Email->to = $data['to'];
		$this->Email->subject = $data['subject'];
		$this->Email->from = $emailConfigurations['From'];
		$this->Email->template = $data['template'];
		
		//Send as 'html', 'text' or 'both' (default is 'text')
		if(!empty($emailConfigurations['IsHTML'])) {
			$this->Email->sendAs = 'both';
		} else {
			$this->Email->sendAs = 'text';
		}
		
		if ($emailConfigurations['IsSMTP']) {
			$this->Email->smtpOptions = array(
				'port'=>$emailConfigurations['Port'],
				'timeout'=>'15',
				'host' => $emailConfigurations['Host'],
				'username'=>$emailConfigurations['Username'],
				'password'=>$emailConfigurations['Password'],
			);
		}
		
		$this->set('data', $data);
		
		if ($this->Email->send()) {
			return true;
		} else {
			$this->log('Email sending failed to '.$data['to']);
		}
		
	}
    
	function currency($number, $currency = 'USD', $options = array()) {
		eval(AddonManager::hook('controllers_app_currency_top'));
		
		$default = array(
			'before'=>'', 'after' => '', 'zero' => '0', 'places' => 2, 'thousands' => ',',
			'decimals' => '.','negative' => '()', 'escape' => true
		);
		$currencies = array(
			'USD' => array(
				'before' => '$', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
				'decimals' => '.', 'negative' => '()', 'escape' => true
			),
			'GBP' => array(
				'before'=>'&#163;', 'after' => 'p', 'zero' => 0, 'places' => 2, 'thousands' => ',',
				'decimals' => '.', 'negative' => '()','escape' => false
			),
			'EUR' => array(
				'before'=>'&#8364;', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => '.',
				'decimals' => ',', 'negative' => '()', 'escape' => false
			),
			'AUD' => array(
				'before' => '$', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
				'decimals' => '.', 'negative' => '()', 'escape' => true
			),
			'NZD' => array(
				'before' => 'NZ$', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
				'decimals' => '.', 'negative' => '()', 'escape' => true
			),
			'PLN' => array(
				'before'=>'z&#322;', 'after' => '', 'zero' => 0, 'places' => 2, 'thousands' => '',
				'decimals' => ',', 'negative' => '()', 'escape' => false
			),
			'LEI' => array(
				'before'=>'', 'after' => 'LEI', 'zero' => 0, 'places' => 2, 'thousands' => '',
				'decimals' => ',', 'negative' => '()', 'escape' => false
			),
			'NOK' => array(
				'before' => 'kr ', 'after' => '', 'zero' => 0, 'places' => 2, 'thousands' => ',',
				'decimals' => '.', 'negative' => '()', 'escape' => true
			)
		);

		if (isset($currencies[$currency])) {
			$default = $currencies[$currency];
		} elseif (is_string($currency)) {
			$options['before'] = $currency;
		}

		$options = array_merge($default, $options);

		$result = null;

		if ($number == 0 ) {
			if ($options['zero'] !== 0 ) {
				return $options['zero'];
			}
			$options['after'] = null;
		} elseif ($number < 1 && $number > -1 ) {
			if(Configure::read('App.noCents') == true) {
				$options['after'] = null;
			} else {
				if(!empty($options['after'])){
					$multiply = intval('1' . str_pad('', $options['places'], '0'));
					$number = $number * $multiply;
					$options['before'] = null;
					$options['places'] = null;
				}
			}
		} else {
			$options['after'] = null;
		}

		$abs = abs($number);
		$places = 0;
		if (is_int($options)) {
			$places = $options;
		}

		$separators = array(',', '.', '-', ':');

		$before = $after = null;
		if (is_string($options) && !in_array($options, $separators)) {
			$before = $options;
		}
		$thousands = ',';
		if (!is_array($options) && in_array($options, $separators)) {
			$thousands = $options;
		}
		$decimals = '.';
		if (!is_array($options) && in_array($options, $separators)) {
			$decimals = $options;
		}

		$escape = true;
		if (is_array($options)) {
			$options = array_merge(array('before'=>'$', 'places' => 2, 'thousands' => ',', 'decimals' => '.'), $options);
			extract($options);
		}

		$result = $before . number_format($number, $places, $decimals, $thousands) . $after;

		
		
		
		if ($number < 0 ) {
			if($options['negative'] == '()') {
				$result = '(' . $result .')';
			} else {
				$result = $options['negative'] . $result;
			}
		}
		return $result;
	}
	
	function AuctionLink($id, $product_name) {
		eval(AddonManager::hook('controllers_app_auctionlink_top'));
		
		if (Configure::read('App.disableSlugs')) {
			return array('controller'=>'auctions', 'action' => 'view', $id);
		} else {
			return array('controller'=>'auctions', 'action' => self::urlTitle($product_name.'-'.$id));
		}
	}
	
	function AuctionLinkFlat($id, $product_name) {
		eval(AddonManager::hook('controllers_app_auctionlinkflat_top'));
		
		if (Configure::read('App.disableSlugs')) {
			return '/auctions/view/'.$id;
		} else {
			return '/auctions/'.self::urlTitle($product_name.'-'.$id);
		}
	}
	
	function CategoryLink($id, $category_name) {
		eval(AddonManager::hook('controllers_app_categorylink_top'));
		
		if (Configure::read('App.disableSlugs')) {
			return array('controller'=>'categories', 'action' => 'view', $id);
		} else {
			return array('controller'=>'categories', 'action' => self::urlTitle($category_name.'-'.$id));
		}
	}
	
	function CategoryLinkFlat($id, $category_name) {
		eval(AddonManager::hook('controllers_app_categorylinkflat_top'));
		
		if (Configure::read('App.disableSlugs')) {
			return '/categories/view/'.self::urlTitle($id);
		} else {
			return '/categories/'.self::urlTitle($category_name.'-'.$id);
		}
	}
	
	function urlTitle($title) {
		eval(AddonManager::hook('controllers_app_urltitle_top'));
		$title=str_replace(' & ', ' and ', $title);
		$title=preg_replace('/[^A-Za-z0-9]/','-',$title);
		while (strstr($title, '--'))
			$title=str_replace('--','-',$title);
		
		return $title;
	}
	
	function demoDisabled() {
		if (Configure::read('SCD') && Configure::read('SCD.isSCD')===true) {
			exit('This feature is disabled in the demo version. <p><a href="javascript:history.back()">Go back</a>');
		}
	}
	
	function getEndTime() {
		eval(AddonManager::hook('controllers_app_getendtime_top'));
		
		return date('Y-m-d H:i:s', strtotime('-1 minute'));
	}
	
}
?>
