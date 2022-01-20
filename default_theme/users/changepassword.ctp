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
<div class="doc_width"><h1> <?php __('Change Password');?>
</div>

</div>


<div class="main_content">
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
	<div class="doc_width shadow_bg">								
			<div id="rightcol">
			<div class="rightcol_inner">            
				
				
				<fieldset>
					<?php echo $form->create('User', array('url' => '/users/changepassword'));?>
					<h3 class="thigstodo" style="padding-left:0px;display:none;"><?php __('To change your password enter in your old password and your new password twice.');?></h3>
                    <br>

					
				<div class="edit_user"><?php echo $form->input('old_password', array('value' => '', 'type' => 'password','label' => __('Old Password', true))); ?></div>
					
					<div class="edit_user"><?php echo $form->input('before_password', array('value' => '', 'type' => 'password','label' => __('New Password', true))); ?></div>
						
					<div class="edit_user"><?php echo $form->input('retype_password', array('value' => '', 'type' => 'password','label' => __('Retype Password', true))); ?></div>
										
					
					<br style="clear:both">
					<?php if (isset($is_scd) && $is_scd===true): ?>
						<?php echo $form->end(__('Change Password', true));?>
					<?php else: ?>
						<?php echo $form->end(__('Change Password', true));?>
					<?php endif; ?>
								

					
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

$(function() {
  $('body').addClass('page_register');
});
</script>