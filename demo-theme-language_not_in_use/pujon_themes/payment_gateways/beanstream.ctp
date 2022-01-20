<div class="payment-redirect">
    <h1><?php 
	 //__('Please wait while we transfering you to the payment gateway.');
	 ?></h1>
	 <?php echo $form->create('beanstream', array('url' => $formurl));?>
		<fieldset>
			<legend><?php __('Enter payment information');?></legend>

			
			<?php echo $form->hidden('amount', array('value' => $data['amount'])); ?>
			
			<?php echo $form->input('cardowner', array('label' => __('Credit card owner *', true))); ?>
			
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