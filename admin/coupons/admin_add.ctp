<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Coupons', true), '/admin/coupons');
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add/');
echo $this->element('admin/crumb');
?>

<div class="coupons form">
<blockquote><p><?php __('New coupon codes can be added here. Use the \'Coupon Type\' option to display a brief description of the type of promotion offered.') ?></p></blockquote>
<?php echo $form->create('Coupon');?>
	<fieldset>
 		<legend><?php __('Add Coupon');?></legend>
	<?php
		echo $form->input('code');
		// Show only if reward points is on
		if(Configure::read('App.rewardsPoint')) {
			$label = __('Saving/Reward Points', true);
		}else{
			$label = __('Saving', true);
		}
		echo $form->input('saving', array('label' => $label));
		echo $form->input('coupon_type_id');

		echo $form->input('single_use', array('label' => 'Single Use'));
		echo $form->input('one_per_account', array('label' =>'One Per Account'));
		echo $form->input('expiry', array('timeFormat' => '24+second', 'label' => __('Expiry Time', true)));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li class="addpage"><?php echo $html->link(__('<< List Coupons', true), array('action'=>'index'));?></li>
	</ul>
</div>
