<?php   
	$lang = 'fre';  
  	
	if(@$_GET['lang'] == 'fre'){
		setcookie('lang', 'fre', time() + (86400 * 30), "/"); // 86400 = 1 day
		$_COOKIE['lang'] = 'fre'; $lang = 'fre';
	}
	if(@$_GET['lang'] == 'eng'){
		setcookie('lang', 'eng', time() + (86400 * 30), "/"); // 86400 = 1 day
		$_COOKIE['lang'] = 'eng'; $lang = 'eng';
	}

	if(isset($_COOKIE['lang'])){
		$lang = $_COOKIE['lang'];
	}
	$domain = 'https://www.congobid.com';
	//$domain = 'http://185.98.137.239';
	$license = '64d2237e9384b621015122ae6fc87420';
	
	if($_SERVER['HTTP_HOST'] == 'preview.congobid.com'){
		$domain = 'https://preview.congobid.com';
		$license = '6b430206b467943a9e9c51bf427ffd11';
 	}
	 
    $config = array(
        'Database' => array(
            'driver'     => 'mysqli',
            'persistent' => false,
            'host'       => 'localhost',  
            'login'      => 'root', 
            'password'   => 'h2L1v0J2D9a0H4H',  
            'database'   => 'c1cauction',  
            'prefix'     => '',  
            'encoding'	 => 'utf8' 
        ),
	 	 

        'App' => array(
		'license'                => '6b430206b467943a9e9c51bf427ffd11_', // preview-6b430206b467943a9e9c51bf427ffd11  64d2237e9384b621015122ae6fc87420 -ip  64d2237e9384b621015122ae6fc87420
		'encoding'               => 'UTF-8',
		'baseUrl'                => '', // Required only if using subdomain/folder
		'base'                   => '', // Required only if using subdomain/folder
		'dir'		    		 => '', // Required only if using subdomain/folder
		'webroot'				 => 'webroot',
		'name'                   => 'CongoBid', 
		'url'                    => $domain, // fill this out
		'ref_url'                => $domain, // fill this out
		'nml_url'                => $domain, // fill this out
		'serverName'             => '', //  this isn't usually needed 
		'timezone'               => 'Africa/Kinshasa', // check the Time Zone article in the Knowledge Base for the correct syntax
		'language'               => $lang, // Three-letter only, eng = English. 
		'email'                  => 'abe@propenny.com', // fill this out and change it to desired email
		'currency'               => 'USD', // Three-letter currency code, i.e. GBP, USD, CAD. For other currencies, please see Knowledge Base
		
		
		
		
//  *******************************************************************************************
		
		
		
		
//		
// Templates Setting (Skin/Theme)
// 
// If you have purchased templates alongside your order, please refer to
// rhe documentation available inside the download. The default template is
// already set up below, you don't need to adjust this if this is the one you
// want to use. 
		'theme'                  => 'default_theme', 
		
		// More Templates available inside the Support Center (depending on package)
		
		
//  *******************************************************************************************	
		
		
		
//		
// Rest of Software Settings
//
// These fields should be adjusted to customize your website, but please be sure
// to make a backup of this file BEFORE editing below. phpPennyAuction Support cannot
// be held responsible if you mess up your website by not reading the relevant
// documentation beforehand. Please refer to our Disclaimer for more information.
		
		'noCents'        		 => true, // false = show prices in European format (,01c), true = show prices in American format (.01p)
		'pageLimit'              => 25, // number of pages that can be viewed in very quick succession to prevent spam harvesting, default is '25'
		'adminPageLimit'         => 100, // number of pages that the admin user(s) can view in a session before you need to sign back in. To prevent bots/hacks.
		'bidHistoryLimit'        => 10, // default number of bids to show in the 'bid box' when viewing an auction
		'remember_me'            => '+30 days', // default cookie session timeout
		
		
		'cakeKey'            	=> $license, // do not change it

		'cakeurl'            	=> 'propenny.com', // do not change it

		'auctionUpdateFrequency' => 1, // how often auction status updates. leave at '1' unless you are sure what you're doing!
		'timeSyncFrequency'      => 9, // leave at '9' unless you are sure what you're doing!
		'memoryLimit'      	  	 => '256M', // needs to be mirrored in your php.ini file - advanced users ONLY!
		'autobidTime'      		 => 10, 
		'gateway' 	       		 => true, // leave this enabled or it will mess up your website! :)
		'demoMode' 	       		 => false, // 'admin mode' - please see Knowledge Base (KB) documentation on this.
		'autobids'               => true, // use autobidding/test bidders on your website?
		'smartAutobids'          => true, // makes the autobidders act in more realistic way, recommended to enable if autobids are enabled
		'bidIncrements' 		 => 'single', // options are: single, dynamic, product
		'bidButlerType'      	 => 'simple', // options are: simple, advanced
		'bidButlerDeploy'		 => 'single', // options are: single, grouped.  Grouped only works when bid increments not dynamic
		// 'bidButlerRapidDeploy'	 => '10', // advanced users only, dsiabled by default
		'homeEndingLimit'     	 => 10, // the number of auctions to show in the 'ending soon' part of the homwepage
		'homeFeaturedLimit'      => 5, // the number of auctions to show in the 'Featured' top part of the homepage
		'homeFeaturedAuction'    => true, //enable 'featured' auctions to show on your homepage?
		'newsletterSelected'     => true, // default subcription mode for the newsletter when customers sign up
		'uniqueAuctionLayout'    => false, // please see documentation in the Knowledge Base (KB) for this, leave to 'false' or you may mess your site up
		'sourceRequired'	     => true, // force the 
		'phoneRequired'	 		 => false, // force the phone number field to be entered, when your customers register?
		'taxNumberRequired' 	 => true, // if included in your template, force the customer to enter a tax ID or VAT #?
		'endedLimit'			 => 30, // the number of auctions to show in the 'Ended' auctions page? set to 0 for unlimited
		'flashMessage'           => false,
		'simpleBids'			 => false,
		'rewardsPoint'           => false,
		'coupons'                => true, // enable the coupons module?
		'hiddenReserve'			 => true, // enable the hidden reserve module?
		'emailWinner'			 => true, // send an email to the winner of the auction?
		'timeFormat'             => 24, // can be 12 or 24
		'ipBlock'				 => 0,
		'delayedStart'			 => false,
		'cronTime' 	        	 => 1, // the cron job execution time, in minutes. Set to 20 if you can only run crons every 20th minute, for example. Default is 1 (minute)
		'bidButlerSleep'		 => 2, // higher for decreased server load, lower for more accurate bid butlers, default 4
		'wwwRedirect'			 => false, // if enabled, forces the 'www.' in all URLs, cannot be used if installing to a sub-domain
		'sslUrl'				 => '', // add your https:// secure URL here, and in the ref_url setting above, if you want to use SSL secure pages.
		'registerOff'			 => false,	// require login/registration to bid? NOT all templates are supported
		'sms_token'			 => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiM2U0MzkxOGVlOGMyZjRlZjdkZTI1MWFiMDliYTAyMDFlMThhM2ViNTAzYTNmMzIzYjFkM2FmMDhhNGIzOTdiYmFhYTE4MDYzMGEwNjlhNTciLCJpYXQiOjE2MjIzODEyMTEuNTU4MDU3LCJuYmYiOjE2MjIzODEyMTEuNTU4MDYyLCJleHAiOjE2NTM5MTcyMTEuNTUxMjE3LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.lo1WX5JaRndk4Klxt5PUpgpajrkq1ndDbAiaK4i1hjPUbgUTyM52RwUnxQLmHyQ261Ikd_WVeennXx4x6b2gVVp1MmZFqh909fSR7i96GOAj2P0sOT6gZaLtoXlJspJDyEWo-95a9d_Nrdo3PY2NkSY5_kSKdx99va-eqvgbnYOIh14LB1X1Dz6l1f7d0rOSyXr1WHeicKJWZoeOR2RzBxcA0ad4pXQxScdHyAHvkE-iiHEPTVo-mmXSBh6clFiUFR5MnPzvAME62huPOVJB8DfrQ5LJTQIMVcnmRx7nc51R0gfACLiy8OdBY7qHb7k8ilSDEkhfFEctL0R3clD51xxax41N6GnwwirEg8GuQZTVozNfvu_0DHmKhQpvFQ-FepdfpuogNTGZZpOY62uJBGWGBxraA2Xx2ffAvktmVdl6XUChKQ9ot8OSUthXe1A1sfqvws1pGJqH_RWjtVsDrb6KpKbT_wLdNXg--Ki13Aa7NlkZ_ecD0SHMyffLhz5kGdiuIAMQr7dpQ1ZBonjHpQ3_f8DOf6F6-aGYG6BYphgV0mLG54zX1uRpuhdJ7U90_D3XsiCnNlfsI0e8RTIsG4Pn3bbF3IMQ_orRsMagZ1P_7CKXAGUmJUzKGH6ajDmNvYmcmqBb5NU1NmSWpZciX_Mdq56m9ug2I_kgccKYHUk',	// require login/registration to bid? NOT all templates are supported


//
// Madbid Counter Settings
//
// If you want the timer to never go beyond X number of
// seconds/minutes, set that here. 0 = disabled

		'maxCounterTime' 		 => 15, // if greater than zero, the time will not go past this point once this time is met.
		
		
		
//
// Deprecated features
//
// These features require additional work to use and are here for legacy purposes only, or are 
// very advanced. We do not recommend using them unless required as they may have bugs or have
// other undesirable effects.

		'forum'                  => false, // use the bundled Forum software? please contact support for assistance with this.
		'affiliates'			 => false, // enable the affiliates module?
		'daemons_log'			 => false, // turn on only for cronjob debugging, log files can get HUGE, open a ticket if unsure!



 	'subscription_pack' => array(
			'0'=>'None',	 
			'1'=>'Simba',	 
			'2'=>'Benda',	 
			'3'=>'Turbo',	 
			'4'=>'Bulldozer',	 
			'5'=>'Béton',	 
			'6'=>'Sukisa',	  
		),
 	'subscription_pack_price' => array(
			'0'=>'0',	 
			'1'=>'10',	 
			'2'=>'30',	 
			'3'=>'50',	 
			'4'=>'100',	 
			'5'=>'200',	  
			'6'=>'500',	  
		),
	'subscription_pack_cost' => array(
			'0'=>'0',	 
			'1'=>'1',	 
			'2'=>'3',	 
			'3'=>'5',	 
			'4'=>'10',	 
			'5'=>'20',	  
			'6'=>'50',	  
		),
	'subscription_pack_rrp' => array(
			'0'=>'0',	 
			'1'=>'200',	 
			'2'=>'500',	 
			'3'=>'1000',	 
			'4'=>'2000',	 
			'5'=>'5000',	  
			'6'=>'10000', 
		),
	 
 

		
		
		
//  *******************************************************************************************
		
		
		

//
// Custom Image Settings (Thumbnails)
//
// If you want to adjust the size of the product images / thumbs. All
// sizes are in pixels

		'Image' => array(
		'thumb_width'  => 200,
		'thumb_height' => 180,
		'max_width'    => 536,
		'max_height'   => 563
		),
		
		
		
		
		
//  *******************************************************************************************	
		
		
		
		
//		
// Date of Birth Settings
//
// Adjust the Age requirements for your websiteto prevent minors from signing up etc	

		'Dob' => array(
			'year_min' => date('Y') - 100,
			'year_max' => date('Y') - 18
		),
		
		'credits' => array(
			'active'	=> false,
			'value'     => 1,
			'expiry'    => 45,
		),
		
		
		
		
//  *******************************************************************************************
		
		
		
		

//
// Winning Limits
//
// Use Limits to reduce the number of possible wins by your site visitors on specific
// products and categories. NB: Disabled by default.

		'limits' => array(
			'active' => false,
				'limit' => 8,
				'expiry' => 28, // the number of days
		),
		
		
		
		
		
//  *******************************************************************************************
		
		
		
		
//
// Cleaner Settings
// 
// Clears out the previously ended auctions from your website and keeps
// everything running smoothly. Please only adjust if you are sure what you
// are doing!

		'cleaner' => array(
			'active' => true,
			'clear' => 30,     // the number of days the auctions should remain
			'clear_all' => 35, // the number of days until ALL auctions are deleted
		),
		
		
		
		
//  *******************************************************************************************
		
			
			
		
//
// Multi-Versions
//
// Use the software with varying languages, currencies, timezones
// and much more. See the KB for the full introduction to this feature. If you 
// only want to use one single site, you can ignore these settings. 

		'multiVersions' => array(
			'domain.com' => array(
			'name'                   => 'Telebid',
	        'url'                    => 'http://telebid',
	        'timezone'               => 'Europe/London',
			'language'               => 'en',
			'currency'               => 'GBP',
			'noCents'        	 	 => true,
			'theme'              	 => ''
			)
		),
		
        ),
		
		
		
				
//  *******************************************************************************************	
			
	
		

//
// Payment Gateways Settings
// Refer to the Knowledge Base (KB) for assistance with these. PayPal is automatically
// set up if you are using the self-installer using your default email
// address. If you want to use other payment gateways, please refer to the
// Knowledge Base (KB) for guidance and notes, or contact phpPennyauctio support.

// PayPal 
        'Paypal' => array(
            'url'   	 => 'https://www.paypal.com/cgi-bin/webscr',
            'email' 	 => 'papove01@hotmail.com', //enter your default PayPal email address here. 
            'lc'    	 => 'USD',
        ),

// PayPal Pro Gateway
        'PaypalProUk' => array(
            'username' 		=> '',
            'password' 		=> '',
            'signature' 	=> '',
            'endpoint' 		=> 'https://api-3t.paypal.com/nvp',
            'use_proxy'	 	=> false,
            'proxy_host' 	=> '127.0.0.1',
            'proxy_port' 	=> 80,
            'version' 		=> '52.0',
            'ssl_url'		=> ''
        ),


// ePayment Gateway
        'ePayment' => array(
            'merchant'  => '', // merchant identifier
            'key'       => '', // key signature
            'testorder' => 'TRUE', // empty this out to get live
            'language'  => 'en' // can be = en, ro, fr, it, es de
        ),





//  *******************************************************************************************




// 
// Email settings
// 
// These are autopopulated, by the Installer script. If you are
// having difficulty with emails and they are not being sent/received
// please de-comment out the section immediately below and try the
// third-party option below (commented out by default).

        'Email' => array( 
            'IsSMTP'     => false,
            'IsHTML'     => true,
            'SMTPAuth'   => false,
            'CharSet'   => 'UTF-8',
            'Host'       => 'localhost',
            'Port'       => 25,
            'WordWrap'   => 50,
            'From'       => 'care@propenny.com',  //fill this in
            'FromName'   => 'The 1 Bid ', //fill this in with your chosen business/website name
            'ReplyTo'    => 'info@propenny.com' //fill this in
            
        ),
		
		
// The section below uses Gmail's IMAP Servers, you don't need to use
// these settings unless you are having difficulties with the above default
// SMTP settings for your server. Make sure to comment the above out if you 
// want to use the below (de-comment that too). 
   /*
        'Email' => array(
            'IsSMTP'     => true,
            'IsHTML'     => true,
            'SMTPAuth'   => true,
            'SMTPSecure' => 'ssl',
            'Host'       => 'smtp.gmail.com',
            'Port'       => 465,
            'Username'   => 'phppennyauctiondemo@gmail.com',
            'Password'   => 'sH7!2lcmJznx8dhAv',
            'WordWrap'   => 50,
            'From'       => 'phppennyauctiondemo@gmail.com',
            'FromName'   => 'Website Name',
            'ReplyTo'    => 'info@propenny.com'
        ),*/




//  *******************************************************************************************




//
// Disable the website cache
// Be very careful here, this will slow your website down and is
// meant for trouble-shooting only.

        'Cache' => array(
            'disable' => false,
            'check' => false,
            'time' => '' // relative time such as +1 day, +2 months, +3 minutes
        ),



//  *******************************************************************************************




//
// Postcode/Zip Validation 
// 
// If you want to allow RegEx expressions such as only 5 digit zip codes, if you
// want to block non-US users for example, then you can adjust the RegEx settings here
// to do so. Please see the Knowledge Base for RegEx values.

        'Validation' => array(
		'postcode' => '', // Only accept numbers
		'custom_rule_postcode' => false, // regex rule, ex: '/^[0-9a-zA-Z]{4}-[0-9a-zA-Z]{3}$/'
        ),




//  *******************************************************************************************




//
// Debug Mode
//
// Enable this by setting it to '1' or disable it by setting it to '0'. '2' will allow
// debugging of your database and output SQL commands.
// Do NOT leave this setting enabled on live websites, always set back to '0' 
        'debug' => 0,    
	
	
	
	
//  *******************************************************************************************
	
		
	

//
// Custom Payment gateways
// 
// Add your own custom gateway here if you need to. 
        'PaymentGateways' => array(
								   
// DotPay					   
            'Dotpay' => array(
                'id'       => '',        // Merchant id
                'currency' => 'USD',          // Currency
                'lang'     => 'en',           // Can be pl, en, de, it, fr, es, cz, ru
                'URL'      => 'http://www.',  // URL where the user will be redirected after payment succeded
                'URLC'     => 'http://www.',  // URL where the confirmation will be called (IPN)
            ),
			
// Google Checkout
            'GoogleCheckout' => array(
                'merchant_id' => '',
                'key'         => '',
                'currency'    => 'USD',
                'local'       => 'en_US',
                'charset'     => 'utf-8',
                'sandbox'     => true
            ),
			
// iDEAL/TargetPay
            'iDeal' => array(
                'layout' => ''
            ),

// Authorize.NET
            'AuthorizeNet' => array(
                'login' => '',
                'key'   => '',
                'test'  => true,
                'url'   => 'https://test.authorize.net/gateway/transact.dll',// Test URL
                //'url'   => 'https://secure.authorize.net/gateway/transact.dll',// Real Url
            ),

// DIBS Danish Gateway
	    'DIBS' => array(
	    	// Merchant identity
	    	'merchant' => '',
	    
// For currency check the CODE (number) on http://tech.dibs.dk/?id=2656 or
// http://en.wikipedia.org/wiki/ISO_4217 for complete ISO. If you use USD, then put 840 here
	    	'currency' => '',
	    
// Accept languages: da = Danish (default), sv = Swedish, no = Norwegian, en = English nl = Dutch,
// de = German, fr = French, fi = Finnish, es = Spanish, it = Italian, fo = Faroese, pl = Polish
	    	'lang' => 'en',
	    	'test' => false // 'yes' or 'false'
	    ),

// Add Custom Payment Gateway ?
// Using the default settings and format here
			'custom' => array(
            	'active' => false,
            	'won_url' => 'http://www.custom.com?user_id=[user_id]&auction_id=[auction_id]&price=[price]'
            )
        ),





//  *******************************************************************************************


		
		
//
// SMS gateways 
// Allows SMS bidding through approved providers. Please refer to the 
// Knowledge Base & docs available if your package supports this.

        'SmsGateways' => array(
            // Main Configurations
			'replyStatus' => false,


// Clickatell.com SMS Gateway
            'Clickatell' => array(
                'user' => '', // Clickatell user id
                'password' => '', // Clickatell password id
                'api_id' => '' // Clickatell api id
            ),


 // Aspiro SMS Gateway
            'Aspiro' => array(
                'username' => '', // Aspiro username
				'password' => '',
                'phone_country_code' => '',
				'reply' => array(
					'text'		         => "",
                    'invalidAuctionText' => "Invalid Auction ID. Please try again.",
					'country'	         => '',
					'accessNumber'       => '',
					'senderNumber'       => '',
					'price'		         => ''
				)
            )
        ),





//  *******************************************************************************************




//
// Recpatcha (Captcha Number) Settings
//
// These settings control the reCaptcha module on the Register page
// to prevent automated/spammy registrations. You don't need to adjust these
// settings and can just use the global key as standard

        'Recaptcha' => array(
            'enabled' => false,
            'secure_server' => false,
            'public_key' => '6LeK8wgAAAAAAIAf8adQkBEm5lwk5wgWRii4a9wE',
            'private_key' => '6LeK8wgAAAAAAKaiZlLVLAwlHPtFmF6JLcWFCTCq'
        ),
        
		
		
		
//  *******************************************************************************************		
		
		
		

//
// Stats Settings
//
// Advanced statistics for your website, including page views, sources of traffic and
// much more. Needs to be enabled first by changing 'false' to 'true'. Viewable from your Admin
// Panel once enabled.
        'Stats'=>array(
		'enabled'=>false,		//if set to false, stats logging is disabled. Reduces MySQL load
		'log_admin'=>false,		//if set to true, administrator's actions will be logged
        ),
		
		
	 
        
    );
	
	
	
	 
?>
