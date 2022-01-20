<style>
.shadow_bg{width:1360px!important}
.invites{text-align:center;}
</style>
 <div class="box clearfix">
 <div class="step_titel">
 
<div class="doc_width"><h1> <?php __('Invite My Friends');?> </h1>
<?php
				$html->addCrumb('Invite my friends', '/Invite my friends');
				echo $this->element('crumb_user');
				?>


</div>
 
</div>
<div class="main_content">
 
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
	<div class="doc_width shadow_bg">	
		
			
			<div id="rightcol">
			<div class="rightcol_inner">            
				
				
				<div class="invites form">
				
				<div class="invite_left">
				<div class="invite_left_inner">
					<h3 class="billing"><?php __('You will receive 20% free bids on the first package any of your friends purchase.');?></h3>
					<h3 class="billing invite-text" style="margin-bottom:0px;margin-top:35px;">
					<?php __("Enter your friend's number (format 243xxxxxxxxx)");?>					
					</h3>
					<?php echo $form->create('Invite', array('action' => 'index')); ?>
					<?php echo $form->textarea('friends_email', array('id'=>'recipient_list','div' => false, 'label' => false,'cols'=> 50,'rows'=>1)); ?>
                    
						<h3 class="billing invite-text" style="margin-bottom:0px;margin-top:0px;"><?php echo $form->label(__('Invite Message', true));?></h3>
						<?php echo $form->textarea('message', array('div' => false, 'label' => false,'cols'=> 50,'rows'=>7)); ?>
				
						<br style="clear:both">
					<?php echo $form->end(__('Invite Now', true)); ?>
					</div>
					</div>
					
					
					
					</div>
                </div>
			</div>
			
			
    </div> 
    </div>
    </div>



