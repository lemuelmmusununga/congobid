<style>
fieldset label{
	width:100%;
	padding-bottom:5px;
}
fieldset div.submit{
	margin-left:0px!important;
	margin-top:10px!important;
}
div.submit input{
	width:auto
}
fieldset .text input, fieldset .password input, fieldset .textarea textarea{
	width:270px;
}
</style>
  <div class="box clearfix input_line input_only_line">
 
  <div class="step_titel">
<div class="doc_width"><h1> <?php __('Make Payment');?>
</div>

</div>


<div class="main_content">
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
	<div class="doc_width shadow_bg">								
			<div id="rightcol">
			<div class="rightcol_inner">            
				
			<?php if($confirm ==2){ ?>
				<h2> <?php __('Payment Completed, redirecting in 10 seconds.'); echo $oid;?> </h2>
				<script> 
					
					setTimeout(function(){ 
						window.location.href = 'http://shop.congobid.com/thank-you?oid=<?php echo $oid;?>&success=<?php echo $success;?>';
					 }, 3000);
				</script>  
				
				<?php } else{ ?>
					<fieldset>
					<?php echo $form->create('User', array('url' => '/pages/pay/1'));?>
					 <br>
                     <h2> <?php __('Paying for Order ID:'); echo $oid;?> </h2> 
                     <h2> <?php __('Amount in bids:'); echo $amount;?> </h2> 
					
					<div class="input box_input focused">	
						   
						  <?php 
						  $msg = sprintf(__('You currently have %s bids, After making payment you will have %s bids', true), $bids, $remaining_bids);
							echo $msg;

							?>
	<br />	<br />

							<?php 
							__('Click Below pay button to make payment');
						 ?>
				
						 </div>	
					
					 
						 				
					
					<br style="clear:both">
				 
						<?php echo $form->end(__('Pay', true));?>
					 		

					
				</fieldset>
				<?php } ?>
                </div>
			</div>	
           </div> 
    </div>
    </div>

<style>
.input_line .input label{top: 21px;}
.input_only_line .input input{padding: 7px 2% 7px 0px;}
</style>

 