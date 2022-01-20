<?php
	class Page extends AppModel {

		var $name = 'Page';

		function __construct($id = false, $table = null, $ds = null){
			parent::__construct($id, $table, $ds);

			$this->validate = array(
				'name' => array(
					'rule' => array('minLength', 1),
					'message' => __('Name is required', true)
				),
				'title' => array(
					'rule' => array('minLength', 1),
					'message' => __('Title is required', true)
				),
				'content' => array(
					'rule' => array('minLength', 1),
					'message' => __('Content is required', true)
				),
				'email' => array(
					'email' => array(
						'rule' => 'email',
						'message' => __('The email address you entered is not valid.', true)
					),
					'minLength' => array(
						'rule' => array('minLength', 1),
						'message' => __('Email address is required.', true)
					)
				),
				'department_id' => array(
					'rule' => array('minLength', 1),
					'message' => __('Department is required', true)
				),
				'message' => array(
					'rule' => array('minLength', 1),
					'message' => __('Enquiry is required', true)
				),
				'otp' => array(
					'rule' => array('minLength', 4),
					'message' => __('OTP must be 4 digits', true)
				),
				 
				'new_pass' => array(
					'between' => array(
						'rule' => array('between', 6, 25),
						'message' => __('PIN must be 6 digit long.', true)
					),
					'alphaNumeric' => array(
						'rule' => 'alphaNumeric',
						'message' => __('PIN can be alphabets and number only', true)
					),
					'minLength' => array(
						'rule' => array('minLength', 1),
						'message' => __('PIN is a required field.', true)
					)
				),
			);
		}

		/**
		 * Override parent before save for slug generation
		 *
		 * @return boolean Always true
		 */
		function beforeSave(){
			if(!empty($this->data)) {
				// Generating slug from page name
				if(!empty($this->data['Page']['name'])) {
					if(!empty($this->data['Page']['id'])) {
						$this->data['Page']['slug'] = $this->generateNiceName($this->data['Page']['name'], $this->data['Page']['id']);
					} else {
						$this->data['Page']['slug'] = $this->generateNiceName($this->data['Page']['name']);
					}
				}

				 
			}
			return true;
		}
	
		function afterSave($model) {
			parent::afterSave($model);
			
			Cache::delete('bottom_pages');
		}

		/**
		 * Function to get last order number
		 *
		 * @return int Return last order number
		 */
		function getLastOrderNumber($position = null) {
			$this->recursive = -1;
			$lastItem = $this->find('first', array('conditions' => array($position.'_show' => 1), 'order' => array($position.'_order' => 'desc')));
			if(!empty($lastItem)) {
				return $lastItem['Page'][$position.'_order'] + 1;
			} else {
				return 0;
			}
		}
	}
?>