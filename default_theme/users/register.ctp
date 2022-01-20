<style>
#UserRegisterForm div.text label, #UserRegisterForm div.date label, #UserRegisterForm div.select label, #UserRegisterForm div.password label, #UserEditForm div.text label, #UserEditForm div.date label, #UserEditForm div.select label, #UserEditForm div.password label{
	margin-right:0;
	width: 100% !important;
	font-size: 15px;
}
.footerbg {
    margin-top: 0px;
	display:none;
}
.bottom_text{padding: 0px 0px 10px 0px;}
.input_line .input.checkbox label {
    top: 0px!important;
}
.input_line .input.checkbox.focused label{
	transform: translateY(0%);
	text-align: left;
}
.right_signup .bottom_text label{padding-top: 4px;padding-bottom: 15px;}}
#UserRegisterForm div.text label,#UserRegisterForm div.date label,#UserRegisterForm div.select label,#UserRegisterForm div.password label,#UserEditForm div.text label,#UserEditForm div.date label,#UserEditForm div.select label,#UserEditForm div.password label{
	width:150px;
}
.right_signup .text{width:auto;float:none;}
fieldset .form-container, fieldset .input{
	padding-bottom:2px;
}
.right_signup #UserRegisterForm div.checkbox input{width:11px;margin-top: 6px;}
.input_line .input.checkbox label{width:95%}
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
    float: left;
    width: 100%;
	background: #ffedda;

}

.login_box{
	
}
#login{text-align:center}
.centre_box{
	width:60%;
	margin: 25px auto;
	display: inline-block;
	background: linear-gradient(to bottom, #de5233, #ea6f0c);
	box-shadow:0px 10px 10px #daaeb0;	
	}
	.login_box_left{
		min-height: 450px;
		transition:all 0.5s ease-in;
	}
	.login_box_right{	
	background:#fff;
	min-height:600px;
	transition:all 0.5s ease-in;
	}
	.dont_have{
	display: inline-block;
	vertical-align: top;
	padding:9px 10px 0px 0px;
	color: #a8a8a8;
	}
	.higlight_box{	
	   box-shadow:inset 0 0 30px #ff9100;
	}
	.login_box_left.higlight_box{		
		 box-shadow:inset 0 0 30px rgba(0,0,0,0.4);
	}
	.register_manage_height{}


.input_line .input.date label{
	top: 0px;
}
.input_line .input.select label{
	top: 0px;
	position: inherit;
	padding-top: 15px;
}
.register .right_signup .edit_user .date{
	font-size: 0;
	padding-top: 15px;

}
.register .right_signup .edit_user .date select{
	width: 31.9% !important;
	color: #333 !important;
	font-size: 13px !important;
	font-family: Roboto,Arial, Helvetica, sans-serif;
}

.register .right_signup .edit_user .select select{
	color: #333 !important;
	font-size: 13px !important;
	font-family: Roboto,Arial, Helvetica, sans-serif;
}
.register .right_signup .edit_user .date select#UserDateOfBirthDay{
	margin:0px 5px;
}

.register .right_signup .edit_user select{
	width:100%!important;
	text-align:left;
	color: #333;
	height:35px;
	text-align: left;
	position: relative;
	border-radius: 0px;
	border:none!important;
	border-bottom:1px solid #999!important;

}	
.full_input .register .right_signup .edit_user.box_input input{
	border: 1px solid #999 !important;
	padding-left: 7%!important;
	width: 92.5% !important;
	margin-bottom: 20px;
	border-radius: 4px;
	font-size: 15px;
	
}
.full_input .register .right_signup .edit_user select{
	border: 1px solid #999 !important;
	padding-left: 3%;
	width: 96.5% !important;
	border-radius: 4px;	
	
}
.full_input .login-only .box_input input{
	border: 1px solid #fff;
	height: 35px;
	padding-left: 3%;
	width: 96.5% !important;
	border-radius: 4px;
	
}
.text-light{color:#333!important;}
.input_line .input label{
	top: 0px;
	font-size:15px;
}
.input_line .input.focused label{
	transform: translateY(0%);
}
.edit_user_referrer{padding-top: 14px;}
.input_line .input label{position: inherit;}
.row{padding-bottom: 30px;}
.right_signup input{margin: 0;}
.register .right_signup .edit_user{
	width: 100%;
	position:relative;
}
.register .right_signup .edit_user + .edit_user{
	width: 100%;
	margin-left: 0;
}
.icon_input{
	position: absolute;
	left: 9px;
	top: 39px;
}
.error-message{
	position: relative;
	top: -16px;
	margin-bottom: 8px;
	font-size: 14px !important;
}
	</style>


	<div id="login" class="outline_btn register input_line">
	<div class="centre_box login_box fadeInDown animated">
	<div class="login_box_left f_l width_40 white-text">
	<div class="padd_40 text-center padd_t_50 login-only center-content">
	<img src="<?php echo $this->webroot; ?>img/logo/logo.png">

	<div class="row padd_tb_20  text-white">

	<h1 class="font-20"><?php __('Already a Member?'); ?><br /><?php __('Please Login'); ?></h1>

	<br />
	<div class="dots line"></div>
	<br />


	<?php echo $form->create('User', array('action' => 'login'));?>	
	<div class="input box_input">	
	<label><?php __('Phone Number');?></label>	
	<input type="tel" class="username" id="UserUsername"  value="" maxlength="40" name="data[User][username]">
	</div>
	
	<div class="input box_input">	
	<label><?php __('Pin');?></label>	
	<input type="password" class="password"  id="UserPassword" value="" name="data[User][password]">
	</div>

	<div class="forgotpassword padd_t_10">

	<?php
	echo '<div class="checkbox">';
	echo $form->checkbox('remember_me');
	echo $form->label('remember_me', __('Remember Me', true), array('class' => 'nofloat'));
	echo '</div>';
	?>

	<a class="hide"  href="<?php echo $this->webroot; ?>users/reset"><?php __('Forgot your password');?></a></div>


 <?php echo $form->end(__('Login', true));?>

	</div>

	</div>
	</div>


	<div class="login_box_right f_r width_60">
	<div class="login-only padd_40">
	<div class="signup_row">
	<div class="right_signup center-content">
	<h2><?php __("I'M NEW HERE");?></h2>
	<div class="info width_80 center_div text-center text-light"><strong><?php __("If you don’t have an account yet, you will need to register to start bidding.");?></strong></div>
	<div class="dots gray_dotted line"></div>

	<div class="register_manage_height">
	<?php echo $form->create('User', array('action' => 'register'));?>

		<div class="row">	
		
		<div class="edit_user box_input">
			<?php echo $form->input('last_name', array('label' => __('Full Name', true))); ?> 		
		</div>
			
		<div class="edit_user box_input">
			<img class="icon_input" src="<?php echo $this->webroot; ?>img/user_icon_u.png" alt="">
			<?php echo $form->input('first_name', array('label' => __('Alias', true))); ?> 
		</div>
		
		</div>
 
		<div class="row">
			
		<div class="edit_user box_input">
			<img class="icon_input" src="<?php echo $this->webroot; ?>img/lock_icon_u.png" alt="">
			<?php echo $form->input('before_password', array('value' => '','type' => 'password','label' => __('Code Pin', true))); ?> 
		</div>
			
		<div class="edit_user box_input">		
			<label for="UserUsername"><?php echo __('Phone Number');  ?></label>	
			<?php echo $form->text('username', array('type'=>'tel', 'label' => __('Phone Number', true))); ?> 
			<?php if($errors_arr['username'] != ''){  echo '<div class="error-message">'.$errors_arr['username']. '</div>'; } ?>
			<p class="phone_hint"><?php __("Format of phone number (ex: 243xxxxxxxxx). Note it will be your username");?></p>	
		</div>
			
		</div>
		 
		 
		<div class="row">
			 
			
			
			<div class="edit_user edit_user_referrer box_input">
			<?php echo $form->input('email', array('label' => __('Email', true))); ?>
			</div>
					
		</div>	



		      
				<div class="bottom_text">
				<?php echo $form->input('terms', array('type' => 'checkbox', 
				'label' => __("I have read and agree to the CongoBid.com  <a target='_blank' href='/page/terms-and-conditions'>Terms and Conditions </a> and  <a target='_blank' href='/page/privacy-policy'> Privacy Policy </a>. I also agree that I am at least 18 years of age and to only open one account", true)));
				?>				
				</div>

				<div class="bottom_text">
				<?php echo $form->input('newsletter', array('type' => 'checkbox', 
				'label' =>  __('I would like to receive emails regarding FREE Bids and other promotions', true)));
				?>				
				</div>
                
				  </div>         

                <?php echo $form->end(__('Register', true));?>




</div>
</div>
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


<script>
/*
$('.login_box_right').click(function(){
	$('.login_box_left').removeClass('higlight_box');	
	$('.login_box_right').addClass('higlight_box');	
});
$('.login_box_left').click(function(){
	$('.login_box_right').removeClass('higlight_box');	
	$('.login_box_left').addClass('higlight_box');	
});

*/
</script>



<script>


 $('checkbox').removeClass('focused');

$('input').focus(function(){
  $(this).parents('.input').addClass('focused');
});

$('input').blur(function(){
  var inputValue = $(this).val();
  if ( inputValue == "" ) {
   
    $(this).parents('.input').removeClass('focused');  
  }
})  

$(function() {
  $('body').addClass('page_register full_input');
});
 
</script>