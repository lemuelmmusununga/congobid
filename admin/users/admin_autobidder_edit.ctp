<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(__('Auto Bidders', true), '/admin/'.$this->params['controller'].'/autobidders');
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/autobidder_edit/'.$this->data['User']['id']);
echo $this->element('admin/crumb');


$this->data['User']['lat'] = ($this->data['User']['lat'] == 0) ? '22.966190424413668' : $this->data['User']['lat'] ;
$this->data['User']['lon'] = ($this->data['User']['lon'] == 0) ? '76.05481807416163' : $this->data['User']['lon'] ;

?>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
<script src="/js/location_jquery.js"></script>
 
<?php echo $form->create('User', array('url' => '/admin/users/autobidder_edit/'.$this->data['User']['id']));?>
	<fieldset>
 		<legend><?php __('Edit an Auto bidder');?></legend>
	<?php

 	echo $form->input('id');
		echo $form->input('username');
		echo $form->input('first_name');
		echo $form->input('aid', array('label' => __('Auction ID', true)));

		echo $form->input('email');
  
		echo $form->input('active');
	?>
	 
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to auto bidders', true), array('action' => 'autobidders')); ?> </li>
	</ul>
</div> 
