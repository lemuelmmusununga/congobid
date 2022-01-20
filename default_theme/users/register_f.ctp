<style>
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
</style>


<div class="main_content">
<div class="main_content_middle main_content_middle_login register_page">

<div class="signup_row">
<div class="left_login">
<div class="login-only">
<h1><?php __('Already a Member?'); ?><br /><?php __('Please Login'); ?></h1>

<br />
<div class="dots"></div>
<br />


<?php echo $form->create('User', array('action' => 'login'));?>				
<input type="text" class="username" id="UserUsername" value="Username" maxlength="40" name="data[User][username]" onclick="javascript:if(this.value == 'Username'){this.value='';}">
<input type="password" class="password" id="UserPassword" value="88888888__" name="data[User][password]" onclick="javascript:if(this.value == '88888888__'){this.value='';}">
    
  
<div class="forgotpassword"><a  href="<?php echo $this->webroot; ?>users/reset"><?php __('Forgot your password'); ?></a></div>
  
				
<?php echo $form->end('Login');?>

				


</div>

</div>

<div class="right_signup">
<h2><?php __("I'M NEW HERE");?></h2>
<div class="info"><?php __("If you don't have an account you need to register first before you start bidding.");?></div>
<div class="dots gray_dotted"></div>

<?php echo $form->create('User', array('action' => 'register'));?>
					<?php
					echo $form->input('username', array('placeholder'=>'Username' ,  'label' =>false));
					echo $form->input('email', array('placeholder'=>'Email' ,  'label' =>false));
					echo $form->input('before_password', array('value' => '', 'type' => 'password', 'placeholder'=>'Password' ,  'label' =>false));
					echo $form->input('retype_password', array('value' => '', 'type' => 'password', 'placeholder'=>'Password Confirmation' ,  'label' =>false));
					echo $form->input('referrer', array('placeholder'=>'Referred By WeigRate Team', 'class'=>'refereed_class' ,  'label' =>false));
					
					?>

				<div class="bottom_text">
				<?php echo $form->input('terms', array('type' => 'checkbox', 'label' => 'I accept Bidnbids <a target="_blank" href="/page/terms">terms and conditions</a> '));

				?>
				</div>
                
				<br style="clear:both;" />
				<br style="clear:both;" />                

				<?php echo $form->end('Register'); ?>




</div>
</div>


		      
      
        
			
               
	</div> 
    </div>


<script type="text/javascript">
	$(document).ready(function(){
		$('.radio-group input').click(function(){
			if($(this).attr('title')){
				if($(this).attr('title') == 1){
					$('#sourceExtraBlock').show(1);
				}else{
					$('#sourceExtraBlock').hide(1);
					$('#sourceExtra').val('');
				}
			}
		});

		if($('.radio-group input:checked').attr('title') == 1){
			$('#sourceExtraBlock').show(1);
		}
	});
</script>
