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
<div class="doc_width"><h1> <?php __('Transfer bids');?>
</div>

</div>


<div class="main_content">
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
	<div class="doc_width shadow_bg">								
			<div id="rightcol">
			<div class="rightcol_inner">            
				
				
				<fieldset>
					<?php echo $form->create('User', array('url' => '/pages/bids'));?>
					<h3 class="thigstodo" style="padding-left:0px;display:none;"><?php __('To change your password enter in your old password and your new password twice.');?></h3>
                    <br>

					
					<div class="input box_input focused">	
						<label><?php __('Phone Number');?></label>	
							<input type="tel" class="username" id="UserUsername"  value="" maxlength="40" name="data[Page][username]">
						</div>	
					
						<div class="input box_input focused">	
							<label><?php __('Bids');?></label>	
							<input type="tel" class="username" id="Userbids"  value="" maxlength="40" name="data[Page][bids]">
						</div>	
						<div class="input box_input focused">	
							<label><?php __('Pin');?></label>	
							<input type="password" class="password"  id="UserPassword" value="" name="data[Page][password]">
						</div>	
						 				
					
					<br style="clear:both">
				 
						<?php echo $form->end(__('Transfer', true));?>
					 		

					
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

 