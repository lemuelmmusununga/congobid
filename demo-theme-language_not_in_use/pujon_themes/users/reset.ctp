<style>
div.submit{
	margin-left:0px!important;
	float:none;
	margin-top:15px!important;
	display:inline-block;
	text-align:center;
}

.login-only input{width:50%;}
</style>

<div class="main_content">    
<div class="main_content_middle">	
<div class="login-only reset_only">
<h1><?php __('Please enter your email.');?></h1>
<div class="dots"></div>
<?php echo $form->create('User', array('action' => 'reset'));?>

	<?php echo $form->input('email', array('placeholder'=>'Your Email' ,  'label' =>false)); ?> 

         <?php echo $form->end(__('Send Details', true));?>
		
  </div>            
  </div>     
   </div>
