<?php

class TwitterComponent extends Object1
{
	function tweet($product, $auction_id, $config) {
		//*** See if we need to call bit.ly API
		//pr($product);exit;
		$product_title=$product['Product']['title'];
		$short_link=false;
		$product_link=Configure::read('App.url') . AppController::AuctionLinkFlat($auction_id, $product_title);
		if ($config['short_url']['append_short_url']==true) {
			if ($config['short_url']['short_url_provider']=='bit.ly') {
				$short_link=$this->getBitlyLink($product_link, $config['short_url']['bitly']['login'], $config['short_url']['bitly']['api_key']);
			}
		}
		
		//*** Build the tweet
		$start_price=AppController::currency($product['Product']['start_price'], Configure::read('App.currency'));
		
		$tokens_from=array('%PRODUCT%', '%START-PRICE%', '%LINK%');
		$tokens_to=array($product_title, $start_price);
		
		$tweet_text=$config['tweet'];
		$link=($short_link ? $short_link : $product_link);
		$tweet_size=strlen(str_replace($tokens_from, '', $tweet_text) . $start_price . $product_title . $link);
		if ($tweet_size>140) {
			//trim down product_title to fit
			$need_to_shrink=$tweet_size-140;
			if ($need_to_shrink>strlen($product_title)) {
				$this->log('Can\'t possibly shave '.$need_to_shrink.' characters! Tweet aborted.', 'twitter');
				return false;
			}
			
			$tokens_to[0]=substr($product_title, 0, strlen($product_title)-$need_to_shrink);
		}
		
		$tweet_text=str_replace($tokens_from, $tokens_to, $tweet_text);
		$tweet_text.=$link;
		
		$this->_postTweet($tweet_text, $config);
		
	}
	
	function _postTweet($tweet_text, $config) {
	
		if ($tweet_text) {
			App::import('Vendor', 'tmhoauth/oauth');
			
			$connection = new tmhOAuth(array(
				'consumer_key' => $config['consumer_key'],
				'consumer_secret' => $config['consumer_secret'],
				'user_token' => $config['access_token'],
				'user_secret' => $config['access_token_secret'],
			));                                                         
			
			if ($r=$connection->request('POST', $connection->url('1/statuses/update'), array('status' => $tweet_text))) {
				$this->log('Tweeted successfully', 'twitter');
			} else {
				$this->log('Error while tweeting, check tokens. '.$r, 'twitter');
			}
		}
		
	}
	
	function getBitlyLink($url, $login, $api_key) {
		
		$api_url="http://api.bit.ly/v3/shorten?login=".urlencode($login)."&apiKey=".urlencode($api_key)."&uri=".urlencode($url)."&format=txt";
		if (function_exists('curl_init')) {
			//we can use curl
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($ch);
			if (curl_error($ch)) {
				$this->log(__METHOD__ . " - cURL failure: ".curl_error($ch), 'twitter');
			}
			curl_close($ch);
			unset($fil);
			
			
		} elseif (ini_get('allow_url_fopen')) {
			//we can use built in file_get_contents()
			
			$fil=file_get_contents($api_url);
			if ($fil===FALSE) {
				log_msg(__METHOD__ . " - file_get_contents() failure", 'twitter');
			}
			unset($fil);
			
		} else {
			$this->log(__METHOD__ . " - curl module not found and allow_url_fopen set to false.", 'twitter');
		}
	
		
		if (!strstr($result, 'http://')) {
			//didn't return valid url
			$this->log(__METHOD__ . " - Returned error: ".$result, 'twitter');
			return false;
		}
		
		$this->log(__METHOD__ . " - Returned valid bit.ly URL ".$result, 'twitter');
		return trim($result);
		
	}
	

}
?>
