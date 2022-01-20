<div class="payment-redirect">
    <h1><?php __('Please wait while we transfering you to the payment gateway.');?></h1>
	 <?php echo $form->create('firstdata', array('url' => $data['url']));?>
		<fieldset>
			<legend><?php __('Enter payment information');?></legend>

			<?php 
			echo $form->hidden('mer_id', array('value' => $data['mer_id']));
			echo $form->hidden('num_items', array('value' => $data['num_items']));
			echo $form->hidden('mer_url_idx', array('value' => $data['mer_url_idx']));
			
			echo $form->hidden('item1_desc', array('value' => $data['item1_desc']));
			echo $form->hidden('item1_price', array('value' => $data['item1_price']));
			echo $form->hidden('item1_qty', array('value' => $data['item1_qty']));
			
			echo $form->hidden('transinfo', array('value' => $data['transinfo']));
			
			?>
			
			<?php echo $form->hidden('ordertype', array('value' => 'SALE')); ?>
			<?php echo $form->hidden('chargetotal', array('value' => $data['amount'])); ?>
			<?php echo $form->hidden('cvmindicator', array('value' => 'provided')); ?>
			<?php echo $form->hidden('debugging', array('value' => $data['debugging'])); ?>
			<?php echo $form->hidden('verbose', array('value' => $data['verbose'])); ?>

			<?php echo $form->input('cardnumber', array('label' => __('Credit card no *', true))); ?>

			<div class="input text">
				<label for="cardexp">Expiration date *</label>
				<?php echo $form->datetime('cardexp', 'MY', 'NONE', null, array('minYear' => date('Y'),
										  'maxYear' => date('Y')+15, 'label' => 'Expiration date *')); ?>
			</div>
			
			<?php	echo $form->input('cvmvalue', array('label' => __('CVV *', true)));
					echo $form->end(__('Save Changes', true));
			?>
		</fieldset>
	
   <script type="text/javascript">
        $(document).ready(function(){
            //document.frmPagseguro.submit();
        });
	</script>
</div>