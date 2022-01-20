<style>
.footerbg {
    margin-top: 0px;
}
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
	top: 22% !important;
	left: 25%;
}
.login_box_left{
		background:linear-gradient(to bottom, #de5233, #ea6f0c);
		min-height:500px
}
.login_box_right{	
	background:#fff;
	min-height: 500px
}
.dont_have{
	display: inline-block;
	vertical-align: top;
	padding:9px 10px 0px 0px;
	color: #a8a8a8;
}

</style>







<div id="contact" class="outline_btn input_line contact_page">
<div class="centre_box login_box fadeInDown animated">


 


<div class="login_box_left f_l width_45">
<div class="text-center">
<div class="row   text-white">




<div class="contact_page_icon">
<a href="/pages/faq">
<h1 class="font-20" style="text-transform:uppercase;">
<i class="fa  fa-question-circle"></i>
<?php __('Faq');?></h1>
<p><?php __('Check out our answers to the most commonly asked questions');?></p>
</a>
</div>


<div class="contact_page_icon border_top_none">
<a href="/tickets">
<h1 class="font-20" style="text-transform:uppercase;">
<i class="fa  fa-envelope"></i><?php __('General Support');?></h1>
<p><a href="mailto:info@congobid.com"><?= __('info@CongoBid.com') ?></a></p>
</a>
</div>

<div class="contact_page_icon border_top_none">
<a href="/page/how-it-works">
<h1 class="font-20" style="text-transform:uppercase;">
<i class="fa   fa-gear"></i>
<?php __('How CongoBid Works');?></h1>
<p><?php __('Click here to find out how it works! For more detailed answers, visit the FAQ’s');?></p>
</a>
</div>





</div>

</div>
</div>



<div class="login_box_right f_r width_55">
<div class="login-only padd_40">
<div class="text-center font-20"><strong class="btm_bor_2"><?php __('Have a question? Let us help!');?></strong></div>
<?php echo $form->create(null, array('url' => '/contact')); ?>

	<?php

	echo $form->input('name', array('label' => __('Name', true)));	
	echo $form->input('email', array('class' => 'disabled','label' => __('Email', true)));
	echo $form->input('phone_number', array('class' => 'type_phone2','maxlength' => '15','label' => __('Phone Number', true)));
	echo $form->input('message', array('label'=>__('Message',true),'type' => 'textarea'));
	?>
	
	<?php if(Configure::read('Recaptcha.enabled')):?>
	<label style="padding:4px 0px 4px 0px;display:none"><?php __('Verification');?></label>
	<?php echo $recaptcha->getHtml(!empty($recaptchaError) ? $recaptchaError : null);?>
	<?php endif;?>				
	<?php echo $form->end(__('Submit', true));?>


</div> 
</div>




</div>
</div>



<script>
$('input').focus(function(){
  $(this).parents('.input').addClass('focused');
});

$('input').blur(function(){
  var inputValue = $(this).val();
  if ( inputValue == "" ) {
   
    $(this).parents('.input').removeClass('focused');  
  }
})  
</script>