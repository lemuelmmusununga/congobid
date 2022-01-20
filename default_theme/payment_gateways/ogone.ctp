<div class="payment-redirect">
    <h1><?php __('Please wait while we transfering you to the payment gateway.');?></h1>
	
    <form method="post" action="<?php echo $paymentRequest->getOgoneUri()?>" id="ogone" name="ogone">
	<?php //foreach($this->getParameters() as $key => $value): ?>
	<?php foreach($paymentRequest->toArray() as $key => $value): ?>
	    <?php if($value) :?>
		<input type="hidden" name="<?php echo $key?>" value="<?php echo htmlspecialchars($value) ?>"  />
	    <?php endif?>
	<?php endforeach?>
	
	<input type="hidden" name="SHASIGN" value="<?php echo $paymentRequest->getShaSign()?>" />

	<input type="submit" value="<?php __('Click here if this page appears for more than 5 seconds');?>" id="submit" name="submit" />

</form>
    
    
   <script type="text/javascript">
        $(document).ready(function(){
            //document.ogone.submit();
        });
	</script>
</div>