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
 <div class="box clearfix">
<div class="step_titel">
<div class="doc_width"><h1><?php __('Change Password');?></h1></div>
</div>
<div class="main_content">
 
	<div class="main_content_middle">			
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
			<div class="rightcol_inner">            
				<?php
					$html->addCrumb(__('Change Password', true), '/users/changepassword');
					echo $this->element('crumb_user');
				?>
				
				<fieldset>
					<?php echo $form->create('User', array('url' => '/users/changepassword'));?>
					<h3 class="thigstodo" style="padding-left:0px;display:none;"><?php __('To change your password enter in your old password and your new password twice.');?></h3>
                    <br>

					<?php
						echo $form->input('old_password', array('value' => '', 'type' => 'password', 'label' => __('Old password', true)));
						echo $form->input('before_password', array('value' => '', 'type' => 'password', 'label' => __('New Password', true)));
						echo $form->input('retype_password', array('value' => '', 'type' => 'password', 'label' => __('Retype Password', true)));
					?>
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
