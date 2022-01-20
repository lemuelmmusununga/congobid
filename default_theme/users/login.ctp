<style>
.footerbg {
    margin-top: 0px;
}
fieldset div.submit{
	margin-left:0px!important;
	float:none;
	display:inline-block;
}
fieldset .text input, fieldset .password input, fieldset .textarea textarea{
	width:250px;
}
fieldset label{
	font-size:15px;
	color:#333;
}
div.checkbox{
	margin-left:0px;
	margin-bottom:14px;
	margin-top:6px;
}
.form-group{
	padding-bottom: 10px;
}
.login-only input{border: 1px solid #999;padding-left: 3%;width: 96.5%;height:35px;border-radius: 4px;
margin-bottom: 20px;}
.form-group label{position: inherit;}
.focused label{transform: translateY(0%);}
body{margin:0px;}
#login{}
#container {
    float: left;
    width: 100%;
	height: 100vh;
	background: #ffedda;

}

.login_box{
	
}
.centre_box{
	width:50%;	
	overflow: hidden;
	position:absolute;
	top: 20% !important;
	left: 25%;
	box-shadow: 0px 0px 5px #daaeb0;
	background:linear-gradient(to bottom, #de5233, #ea6f0c);
}
.login_box_left{
	background:linear-gradient(to bottom, #de5233, #ea6f0c);
	min-height: 450px
}
.login_box_right{	
	background:#fff;
	min-height: 450px;
	font-size: 15px;
}
.dont_have{
	display: inline-block;
	vertical-align: top;
	padding:9px 10px 0px 0px;
	color: #333;
	font-weight: bold;
}

</style>





<div id="login" class="outline_btn page_login">
<div class="centre_box login_box fadeInDown animated">





<div class="login_box_left f_l width_45">
<div class="padd_40 text-center padd_t_80 center-content">
<img src="<?php echo $this->webroot; ?>img/logo/logo.png">

<div class="row padd_tb_20  text-white">
<h1 class="font-20"><?php __('Already a Member?');?><br /><?php __('Please Login');?></h1>
<div class="dots"></div>

<p class="padd_tb_10">
<?php __("Welcome to CongoBid - Home of TCG bidding fee auctions. We offer a wide variety of sets, booster boxes, tins, blister and vintage packs, as well as individual cards.");?>
 </p>
</div>

</div>
</div>

<div class="login_box_right f_r width_55">
<div class="login-only padd_40 center-content">


<div class="f_r_">
<span class="dont_have f_l"><?php __("Don't have an account?");?></span>
<a class="btn_new  left-animated  btn-blue small_btn f_r" href="/users/register">
<?php __("Signup");?></a>
</div>


<div class="row padd_tb_20">
<fieldset>
<?php echo $form->create('User', array('action' => 'login'));?>	
<div class="form-group">
<label><?php __('Phone Number');?></label>			
<input type="tel" class="username" id="UserUsername"  value="" maxlength="40" name="data[User][username]">
</div>

<div class="form-group">
<label><?php __('Pin');?></label>			
<input type="password" class="password" id="UserPassword" value="" name="data[User][password]">
</div>


    

	



  
<div class="forgotpassword padd_t_10">

<?php
echo '<div class="checkbox">';
					echo $form->checkbox('remember_me');
					echo $form->label('remember_me', __('Remember Me', true), array('class' => 'nofloat'));
					echo '</div>';
?>

<a  href="<?php echo $this->webroot; ?>users/reset"><?php __('Forgot your password');?></a></div>
  
				

<?php echo $form->end(__('Login', true));?>
				
</fieldset> 








</div>

</div> 
</div>




</div>
</div>

<script>
$('input').focus(function(){
  $(this).parents('.form-group').addClass('focused');
});

$('input').blur(function(){
  var inputValue = $(this).val();
  if ( inputValue == "" ) {
   
    $(this).parents('.form-group').removeClass('focused');  
  }
})  



$(function() {
  $('body').addClass('page_login');
});
</script>	