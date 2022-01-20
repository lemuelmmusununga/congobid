<div class="payment-redirect">
    <h1></h1>
	
	 <?php echo $form->create('payfast', array('url' => $formurl));?>
		<fieldset>
			<legend><?php __('Please wait while we transfering you to the payment gateway.'); ?></legend>
			
			<?php
				$fields = array(
					'merchant_id',
					 'merchant_key',
					 'return_url',
					 'cancel_url',
					 'notify_url',
					 'name_first',
					 'name_last',
					 'email_address',
					 'm_payment_id',
					 'amount',
					 'item_name',
					 'item_description',
					 'email_confirmation',
					 'signature'
				);
			?>
			<?php foreach($fields as $field): ?>
			
				<input type="hidden" name="<?php echo $field; ?>" value="<?php echo $data[$field];?>"/> 
			
			<?php endforeach; ?>
			
			<?php
			/* echo $form->hidden('merchant_id', array('value' => $data['merchant_id'])); 
			 echo $form->hidden('merchant_key', array('value' => $data['merchant_key'])); 
			 echo $form->hidden('return_url', array('value' => $data['return_url'])); 
			 echo $form->hidden('cancel_url', array('value' => $data['cancel_url'])); 
			 echo $form->hidden('notify_url', array('value' => $data['notify_url'])); 
			
			 echo $form->hidden('name_first', array('value' => $data['name_first'])); 
			 echo $form->hidden('name_last', array('value' => $data['name_last'])); 
			 echo $form->hidden('email_address', array('value' => $data['email_address'])); 
			
			
			 echo $form->hidden('m_payment_id', array('value' => $data['m_payment_id'])); 
			 echo $form->hidden('amount', array('value' => $data['amount'])); 
			 echo $form->hidden('item_name', array('value' => $data['item_name'])); 
			 echo $form->hidden('item_description', array('value' => $data['item_description'])); 
			
			 echo $form->hidden('email_confirmation', array('value' => $data['email_confirmation'])); 
			
			 echo $form->hidden('signature'); 
			*/
			echo $form->end(__('Save Changes', true)); ?>
		</fieldset>
	
   <script type="text/javascript">
        $(document).ready(function(){
            //document.frmPayfast.submit();
        });
	</script>
</div>


