<style>
.shadow_bg{width:1360px!important;}
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
.user_date{
	width: 39%;
}
fieldset .user_gender .select select{
	width: 20%;
}
#rightcol{padding: 0;}
fieldset{margin:0;}
.register .right_signup .edit_user input{
	background: gray !important;
}
</style>
 <div class="box clearfix input_line input_only_line user_edit_pge">
<div class="step_titel">
<div class="doc_width"><h1><?php __('Edit Account');?></h1>
<?php
$html->addCrumb(__('Edit Profile', true), '/users/edit');
echo $this->element('crumb_user');
?>
</div>
</div>
<div class="main_content">
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>

 
		<div class="doc_width shadow_bg">			
		
			<div id="rightcol">
			<div class="rightcol_inner">            
				
				
				
				
				<fieldset class="width_50 f_l edit_propfile">				
<?php echo $form->create('User', array('url'=>'/users/edit'));?>
						
			<div class="padd_30 padd_t_0">	
			
			
					
			
			
					<div class="row">
					<div class="edit_user"><?php echo $form->input('username', array('label' => __('Username *', true))); ?></div>
					<div class="edit_user"><?php 	echo $form->input('first_name', array('label' => __('Alias *', true))); ?></div>
					</div>
					
					
					<div class="row">
					<div class="edit_user"><?php 	echo $form->input('email', array('label' => __('Email *', true))); ?></div>
					<div class="edit_user"><?php 	echo $form->input('last_name', array('label' => __('Full Name *', true))); ?></div>
					</div>
				
				<div class="row">				
				<div class="edit_user"><?php 	echo $form->input('date_of_birth', array('type'=>"date", 'label' => __('Date of Birth', true)    )); ?></div>
				
				<div class="edit_user"><?php 	echo $form->input('gender_id', array('label' => __('Gender *', true))); ?></div>
				</div>
 
 
<div class="user_chekbox"><?php 	echo $form->input('newsletter', array('label' => __('Sign up for the newsletter?', true))); ?></div>
	<div class="center_btn">
						<?php echo $form->end(__('Save Changes', true));?>
						<a class="btn_new  left-animated right-animated  btn-blue manage_add_btn" href="/addresses">
			<?php __('Manage Addresses');?></a>
					</div>
					
					</div>
				</fieldset>
				
				
				
				
                </div>
			</div>

    </div> 
    </div>
    </div>
