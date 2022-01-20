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

<div class="main_content">
<div class="main_content_middle main_content_middle_login">


<div class="login-only">
<h1><?php __('Already a Member?');?><br /><?php __('Please Login');?></h1>

<div class="dots"></div>

<fieldset>
<?php echo $form->create('User', array('action' => 'login'));?>				
<input type="text" class="username" id="UserUsername" value="Username" maxlength="40" name="data[User][username]" onclick="javascript:if(this.value == 'Username'){this.value='';}">
<input type="password" class="password" id="UserPassword" value="88888888__" name="data[User][password]" onclick="javascript:if(this.value == '88888888__'){this.value='';}">
    
  
<div class="forgotpassword"><a  href="<?php echo $this->webroot; ?>users/reset"><?php __('Forgot your password');?></a></div>
  
				
<?php echo $form->end('Login');?>
				
</fieldset> 

</div>            
            
</div> 
</div>

