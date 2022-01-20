<?php
	class DashboardsController extends AppController{
		var $name = 'Dashboards';
		var $uses = array('Bid', 'Account');
		
		
		function beforeFilter(){
			parent::beforeFilter();
			
			if(!empty($this->Auth)) {
				$this->Auth->allow('template_switch');
			}
		}
		
		function _getOnlineUsers(){
			$dir   = TMP . DS . 'cache' . DS;
			
			$files = scandir($dir);
			$count = 0;
			
			foreach($files as $filename){
				if(is_dir($dir . $filename)){
					continue;
				}
				
				if(substr($filename, 0, 16) == 'cake_user_count_') {
					$count++;
				}
			}
			
			return $count;
		}
		
		function _income($type, $past = false, $options = null) {
			if($type == 'days') {
				$date = date('Y-m-d');
				
				if($past == true) {
				$date = date('Y-m-d', time() - 86400 * $options);
				}
				
				if($options == 1) {
					$income = $this->Account->find('all', array('conditions' => "Account.created BETWEEN '$date 00:00:00' AND '$date 23:59:59'", 'fields' => "SUM(Account.price) as 'income'"));
					
					if(empty($income[0][0]['income'])) {
						$income[0][0]['income'] = 0;
					}
				} else {
					$past = date('Y-m-d', strtotime($date) - 86400 * $options);
					
					$income = $this->Account->find('all', array('conditions' => "Account.created BETWEEN '$past 00:00:00' AND '$date 23:59:59'", 'fields' => "SUM(Account.price) as 'income'"));
					if(empty($income[0][0]['income'])) {
						$income[0][0]['income'] = 0;
					}
				}
			} elseif($type == 'month') {
				$lastDay = date('t');
				$month = date('m');
				$year = date('Y');
				
				$rollback = date('d') + 1;
				
				if($past == true) {
					$lastDay = date('t', time() - 86400 * $rollback);
					$month = date('m', time() - 86400 * $rollback);
					$year = date('Y', time() - 86400 * $rollback);
				}
				
				$income = $this->Account->find('all', array('conditions' => "Account.created BETWEEN '$year-$month-01 00:00:00' AND '$year-$month-$lastDay 23:59:59'", 'fields' => "SUM(Account.price) as 'income'"));
				if(empty($income[0][0]['income'])) {
					$income[0][0]['income'] = 0;
				}
			}
			
			return $income[0][0]['income'];
		}
		
		function admin_dbupgrade() {
			
		}
		
		function admin_index(){
			 
			
			$conditions = array(
				'Bid.debit <>' => 0,
				'User.autobidder' => 0,
				'Auction.id <>' => 0
			);
			$this->set('bids', $this->Bid->find('all', array('conditions' => $conditions, 'limit' => 10, 'contain' => array('Auction' => array('Product'), 'User'), 'order' => array('Bid.id' => 'desc'))));
			
			$this->set('onlineUsers', $this->_getOnlineUsers());
			
			$this->set('dailyIncome', $this->_income('days', false, 1));
			$this->set('yesterdayIncome', $this->_income('days', true, 1));
			
			$this->set('weeklyIncome', $this->_income('days', false, 7));
			$this->set('lastweekIncome', $this->_income('days', true, 7));
			
			$this->set('monthlyIncome', $this->_income('month'));
			$this->set('lastmonthIncome', $this->_income('month', true));
			
			$this->set('config', $this->appConfigurations);
			
			 
			
			 
		}
		
		function admin_clear_cache() {
		
			list($errors, $successes)=$this->_clearDir(TMP);
			$this->set('tmp_errors', $errors);
			$this->set('tmp_successes', $successes);
			
			list($errors, $successes)=$this->_clearDir(TMP . DS . 'cache');
			$this->set('cache_errors', $errors);
			$this->set('cache_successes', $successes);
			
			list($errors, $successes)=$this->_clearDir(TMP . DS . 'cache' . DS . 'models');
			$this->set('models_errors', $errors);
			$this->set('models_successes', $successes);
		
		}
		
		
		function _clearDir($dir) {
			
			$successes=0;
			$errors=array();
			
			$d = dir($dir);
			while (false !== ($entry = $d->read())) {
			if (preg_match("/^cake_/", $entry)) {
			$file=$dir . DS . $entry;
			unlink($file);
			if (file_exists($file)) {
			$errors[]='Could not delete: '.$file;
			} else {
			$successes++;
			}
			}
			}
			$d->close();
			
			return array($errors, $successes);
			
		
		}
		
		function admin_stats() {
			if (Configure::read('Stats') && Configure::read('Stats.enabled')===true) {
				$this->set('enabled', true);
			} else {
				$this->set('enabled', false);
			}
		}
		
		function template_switch($template) {
			if (Configure::read('SCD') && Configure::read('SCD.isSCD')===true) {
				$template_list=Configure::read('SCD.templates');
				if (!isset($template_list[$template])) {
					$this->Session->setFlash('Invalid template specified');
				} else {
					$this->Session->write('switch_template', $template);
				}
			}
			$this->redirect($this->referer());
		}
		
		function __saveDBVersion() {
			$setting=$this->Setting->findByName('phppa_version', array(	'Setting.id',
															'Setting.name',
															'Setting.description', 'Setting.value'));
			if (empty($setting)) {
				//create whole new record
				$setting=array('Setting'=>array(	'value'=>PHPPA_VERSION,
										'name'=>'phppa_version',
										'description'=>'Internal use only, modifying this value can cause software instability!'));
				$this->Setting->create();
				
			} else {
				//just update value
				$setting['Setting']['value']=PHPPA_VERSION;
			}
			
			
			$this->Setting->save($setting);
			$this->log('Saved new version number to settings table', 'upgrade');
		}
	}
?>