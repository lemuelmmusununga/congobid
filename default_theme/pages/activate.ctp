<style>
fieldset div.submit{
	margin-left:0px!important;
	float:none;
	display:inline-block;
}
fieldset .text input, fieldset .password input, fieldset .textarea textarea{
	width:250px;
}
fieldset label{
	font-size:12px;
	color:#868686;
}
div.checkbox{
	margin-left:0px;
	margin-bottom:14px;
	margin-top:6px;
}



</style>

<div class="step_titel login_bg_title">
<div class="doc_width">
<h1><?php __('Activate your account');?></h1>
</div>
</div>
<div class="main_content">

<div class="main_content_middle main_content_middle_login">

<div class="login-only">
<h1 class="text-center"><?php __('Enter Your SMS code to activate your account.') ?></h1>

<div class="dots"></div>

<fieldset>
<?php echo $form->create('User', array('url' => '/pages/activate/'.$id));?>
		
	<div class="activate"> 	
<div class="text_input"> 
       					
<input type="text" class="username" id="UserSms_Code" value="" maxlength="4" name="data[User][sms_code]" onclick="javascript:if(this.value == '<?php __('Sms code');?>'){this.value='';}">

</div>  
  
<div class="forgotpassword forgotpassword2 text-center" style="margin-top:0px;"><a  href="<?php echo $this->webroot; ?>pages/resent/<?php echo $id;?>">
<?php __('Resend sms');?></a></div>
  
				
<?php echo $form->end(__('Verify Now!', true));?>
</div>			
</fieldset> 

</div>            
            
</div> 
</div>

