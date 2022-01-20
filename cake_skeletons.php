<?php
//*** CakePHP skeletons
//For using CakePHP components
class Object1 {
	function log($msg, $which=false) {
		logIt($msg, $which);
	}
}
class AppController {
	function AuctionLink($id, $product_name) {
		if (Configure::read('App.disableSlugs')) {
			return array('controller'=>'auctions', 'action' => 'view', $id);
		} else {
			return array('controller'=>'auctions', 'action' => self::urlTitle($product_name.'-'.$id));
		}
	}
	
	function AuctionLinkFlat($id, $product_name) {
		if (Configure::read('App.disableSlugs')) {
			return '/auctions/view/'.$id;
		} else {
			return '/auctions/'.self::urlTitle($product_name.'-'.$id);
		}
	}
	
	function urlTitle($title) {
		$title=str_replace(' & ', ' and ', $title);
		$title=preg_replace('/[^A-Za-z0-9]/','-',$title);
		while (strstr($title, '--'))
			$title=str_replace('--','-',$title);
		
		return $title;
	}
	
	function currency($price, $type) {
		return currency($price, $type);
	}
}

class App {
	function import($type, $file) {
		if ($type=='Vendor') {
			include('../vendors/'.$file.'.php');
		}
	}
}


//*** Configure object for reading/writing site configuration
class Configure {
	function read($key) {
		global $config;
		
		$key_levels=explode('.', $key);
		$cur_config=&$config;
		foreach ($key_levels as $level) {
			if (isset($cur_config[$level])) {
				$cur_config=&$cur_config[$level];
				if (!is_array($cur_config)) break;
			} else {
				return false;
			}
		}
		
		return $cur_config;
	}
}

?>