<div class="payment-redirect">
    <h1><?php __('Please wait while we transfering you to the payment gateway.');?></h1>
	
	Explanation
	<form action="https://api.multisafepay.com/ewx/post.php" method="post" target="_blank">
		<input type="hidden" name="currency" value="EUR" />
		<input type="hidden" name="action" value="pay" />
		<input type="hidden" name="account" value="123456" />
		<input type="hidden" name="site_id" value="789" />
		<input type="hidden" name="site_secure_code" value="112233" />
		<input type="hidden" name="amount" value="10.00" />
		<input type="hidden" name="description" value=" Example product" />
		<input type="hidden" name="items" value="" />
		<input type="submit" value=”Submit” name=”Submit” />
	</form> 
	 
	 
	<form name="frmPagseguro" action="https://pagseguro.uol.com.br/security/webpagamentos/webpagto.aspx" method="post">
		<?php echo $data; ?>
		<input type="submit" value="<?php __('Click here if this page appears for more than 5 seconds');?>"/>
	</form>	
	 
here: <br/><br/>
<pre>
<? print_r($request_data); ?>
</pre>
	 
	 
	
   <script type="text/javascript">
        $(document).ready(function(){
            //document.frmPagseguro.submit();
        });
	</script>
</div>