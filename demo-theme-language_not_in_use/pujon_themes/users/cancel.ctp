<style>
fieldset div.submit{
	margin-left:0px!important;
	margin-top:5px!important;
}
</style>
 <div class="box clearfix">
 <div class="step_titel">
<div class="doc_width"><h1> <?php __('Cancel Account');?></h1></div>
</div>
<div class="main_content canel">
 
 
		<div class="main_content_middle">			
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
			<div class="rightcol_inner">                        
				<?php
				$html->addCrumb(__('Cancel Account', true), '/users/cancel');
				echo $this->element('crumb_user');
				?>

			<h3 class="billing"><?php __('Are you sure you want to cancel your account?');?></h3>

				<?php echo $form->create('User', array('action' => 'cancel'));?>
				<fieldset>
					<?php
						echo $form->hidden('security', array('value' => $security));?>
						<?php echo $form->end(__('Yes, Cancel My Account', true));?>
						
					
				</fieldset>
               
			</div>
            </div>
    </div> 
    </div>
    </div>
