<style>
fieldset label{
	width:100%;
	padding-bottom:5px;
}
fieldset div.submit{
	margin-left:0px!important;
	margin-top:10px!important;
}
fieldset .text input, fieldset .password input, fieldset .textarea textarea{
	width:270px;
}
</style>
  <div class="box clearfix input_line input_only_line">
 
  <div class="step_titel">
<div class="doc_width"><h1> <?php __('Convert Bids');?>
</div>

</div>


<div class="main_content">
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
	<div class="doc_width shadow_bg">								
			<div id="rightcol">
			<div class="rightcol_inner">            
				
				
				<fieldset>
					<?php echo $form->create('User', array('url' => '/pages/convert_bids/1'));?>
					 <br>

					
					<div class="input box_input focused">	
						   
						  <?php 
						  $msg = sprintf(__('You currently have %s Bonus bids, it can be converted into your regular %s bids', true), $bonus_bids, $new_bonus_bids);
							echo $msg;

							?>
	<br />	<br />

							<?php 
							__('Click Below Convert button if you want to convert');
						 ?>
				
						 </div>	
					
					 
						 				
					
					<br style="clear:both">
				 
						<?php echo $form->end(__('Convert', true));?>
					 		

					
				</fieldset>
                </div>
			</div>	
           </div> 
    </div>
    </div>

<style>
.input_line .input label{top: 21px;}
.input_only_line .input input{padding: 7px 2% 7px 0px;}
</style>

 