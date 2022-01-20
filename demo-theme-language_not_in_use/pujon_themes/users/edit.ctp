<style>
fieldset label{
	text-align:left;
	width:110px;
}
fieldset .text label, fieldset.contact .text label, fieldset.contact .select label, fieldset.contact .textarea label{
	text-align:left;
	width:110px;
}
div.checkbox{
	margin:0px 0px 20px 0px;
}

</style>
 <div class="box clearfix">
<div class="step_titel">
<div class="doc_width"><h1><?php __('Edit Account');?></h1></div>
</div>
<div class="main_content">
 
		<div class="main_content_middle">			
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
			<div class="rightcol_inner">            
				<?php
				$html->addCrumb(__('Edit Profile', true), '/users/edit');
				echo $this->element('crumb_user');
				?>
				
				<?php echo $form->create('User', array('url'=>'/users/edit'));?>
				<fieldset>

				<br>

					<div class="edit_user"><?php echo $form->input('username', array('label' => __('Username *', true))); ?></div>
					<div class="edit_user"><?php 	echo $form->input('first_name', array('label' => __('First Name *', true))); ?></div>
					<div class="edit_user"><?php 	echo $form->input('email', array('label' => __('Email *', true))); ?></div>
					<div class="edit_user"><?php 	echo $form->input('last_name', array('label' => __('Last Name *', true))); ?></div>
					
				<div class="user_date"><?php 	echo $form->input('date_of_birth', array('label' => __('Date of Birth', true),  'minYear' => $appConfigurations['Dob']['year_min'], 'maxYear' => $appConfigurations['Dob']['year_max'])); ?></div>
 <div class="user_gender"><?php 	echo $form->input('gender_id', array('label' => __('Gender *', true))); ?></div>
<div class="user_chekbox"><?php 	echo $form->input('newsletter', array('label' => __('Sign up for the newsletter?', true))); ?></div>
						<?php echo $form->end(__('Save Changes', true));?>
					
				</fieldset>
                </div>
			</div>

    </div> 
    </div>
    </div>
