<?php

//**************************************
//*** phpPennyAuction Add-on Manager ***
//**************************************

class AddonManager {
		
	private static $addons;
	private static $hooks;
	private static $paths;
	
	static function loadAddons() {
		
		//initialize
		self::$addons=array();
		self::$hooks=array();
		
		$addons=glob(ADDON . '*', GLOB_ONLYDIR);
		foreach ($addons as $addon) {
			//load this addon's info file
			$files=glob($addon.DS.'*.php');
			if (FALSE==($info=self::loadInfo($addon.DS.'phppa.inf'))) {
				//something's wrong with our info file, abort
				continue;
			}
			
			if (isset($info['enabled']) && $info['enabled']===FALSE) {
				continue;
			}

			//pass plugin paths to Cake
			if (is_dir($addon . DS . 'controllers')) {
				self::__setPath('controller', $addon . DS . 'controllers');
			}
			if (is_dir($addon . DS . 'models')) {
				self::__setPath('model', $addon . DS . 'models');
			}
			if (is_dir($addon . DS . 'views')) {
				self::__setPath('view', $addon . DS . 'views');
			}
			if (is_dir($addon . DS . 'helpers')) {
				self::__setPath('helper', $addon . DS . 'helpers');
			}
			if (is_dir($addon . DS . 'component')) {
				self::__setPath('component', $addon . DS . 'component');
			}
			
			
			foreach ($files as $plug) {
				if (basename($plug)=='plugin_config.php' && class_exists('Configure')) {
					Configure::load($plug);
				}
				
				//load plug code contents
				$contents=file_get_contents($plug);
				
				//strip open/close tags
				$contents=preg_replace('@^<\?php@', '', $contents);
				$contents=preg_replace('@\?>$@', '', $contents);
				
				//get base names
				$plug=basename($plug);
				$plug=strtolower(substr($plug, 0, strlen($plug)-4));
				$addon=basename($addon);
				$addon=strtolower($addon);
				self::createHook($addon, $plug, $contents);
				
			}
			
			self::$addons[]=$addon;
			
			unset($info);
		}
	}
	
	static private function loadInfo($filename) {
		$inf_file=@file_get_contents($filename);
		eval($inf_file);
		if (!isset($info) or empty($info)) {
			$this->log('BAD INFO FILE: '.$filename, 'addons');
			return false;
		} else {
			//check that we're compatible
			if (PHPPA_VERSION<$info['min_version']) {
				if (isset($this)) {
					$this->log($info['name'].' not compatible (min_version)', 'addons');
				}
				return false;
			} elseif (PHPPA_VERSION>$info['max_version']) {
				if (isset($this)) {
					$this->log($info['name'].' not compatible (max_version)', 'addons');
				}
				return false;
			}
			
			return $info;
		}
	}


	//pushes a addon to the hook stack
	static private function createHook($addon, $hook, $code) {
		if (!isset(self::$hooks[$hook][$addon])) {
			self::$hooks[$hook][$addon] = $code;
		}
	}

	//returns true if the specified extension is loaded
	static public function loaded($extension) {
		return in_array($extension, self::$addons);
	}
	
	//returns code for any addons on the supplied $hook	
	static public function hook($hook) {
		$hook=strtolower($hook);
		
		if (!isset(self::$hooks[$hook])) return '';
		
		$content='';
		foreach (self::$hooks[$hook] as $addon=>$hook) {
			$content .= $hook;
		}
		
		return $content;
		
	}
	
	private function __setPath($type, $path) {
		if (!isset(self::$paths[$type])) self::$paths[$type]=array();
		
		self::$paths[$type][]=$path;
	}
	
	public function getPaths($type) {
		if (!isset(self::$paths[$type]) || !is_array(self::$paths[$type])) {
			return array();
		} else {
			return self::$paths[$type];
		}
	}
}

?>