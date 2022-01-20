<style>
.footerbg {
    margin-top: 0px;
}
#UserRegisterForm div.text label,#UserRegisterForm div.date label,#UserRegisterForm div.select label,#UserRegisterForm div.password label,#UserEditForm div.text label,#UserEditForm div.date label,#UserEditForm div.select label,#UserEditForm div.password label{
	width:150px;
}
.right_signup .text{width:auto;float:none;}
fieldset .form-container, fieldset .input{
	padding-bottom:2px;
}

#recaptcha_area{
	float:left!important;
	width:250px!important;
	margin-top:10px;
}

div.submit{
	margin-left:0px!important;
	float:none;
	display:inline-block;
}

#container {	
    background:#ffedda;
    float: left;
    width: 100%;
	height: 100vh;
	background-size: cover;	

}

.centre_box{
	width:30%;
	overflow: hidden;
	position:absolute;
	top:21% !important;
	left:35%;
	box-shadow: 0px 0px 5px #daaeb0;
}
.login_box_right{	
	border-radius: 6px;	
	background-image: linear-gradient(120deg,#fff 0,rgba(255,255,255,0.7) 100%);
	min-height: 300px;
	transition:all 0.5s ease-in;
	}

	</style>


	<div id="login" class="outline_btn register input_line">
	<div class="centre_box login_box fadeInDown animated">
	


	<div class="login_box_right f_r width_100">
	
	
	<div class="reset_header">
	<h2><?php __("Recover Your Password");?></h2>
	<p>
	<?php __('Enter your email address and we will send you an email with a recovery password');?></p>
	</div>
	
	
	<div class="login-only padd_40">
	<div class="signup_row">
	<div class="right_signup user_reset">
	
	<div class="dots gray_dotted line"></div>
		<?php echo $form->create('User', array('action' => 'reset'));?>
		
		
			<?php echo $form->input('username', array('label' => __('Phone Number', true))); ?> 
			<p class="phone_hint mar_t_0"><?php __("Phone Number like");?> : 243 815 237 009</p>	
	

		<br style="clear:both;" />
		<br style="clear:both;" />                
		<?php echo $form->end(__('SEND', true));?>

</div>
</div>
</div>
</div>






  
        
		
		
</div>
</div>


<script>
$(function() {
  $('body').addClass('page_reset');
});
</script>