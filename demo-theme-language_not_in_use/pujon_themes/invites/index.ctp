<style>
div.submit{
	margin-top:8px!important;
}
</style>

 <div class="box clearfix">
 <div class="step_titel">
<div class="doc_width"><h1> <?php __('Invite My Friends');?></h1></div>
</div>
<div class="main_content">
 
		<div class="main_content_middle">			
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
			<div class="rightcol_inner">            
            
				<?php
				$html->addCrumb('Invite my friends', '/Invite my friends');
				echo $this->element('crumb_user');
				?>

				<div class="invites form">
					<h3 class="billing" style="margin-bottom:0px;margin-top:5px;margin-left:0px;"><?php __('You will receive 10% free bids on the first package any of your friends purchase.');?></h3>
					<h3 class="billing" style="margin-bottom:0px;margin-top:2px;margin-left:0px;">
                    </h3>
					<?php echo $form->create('Invite', array('action' => 'index')); ?>
					<?php echo $form->textarea('friends_email', array('id'=>'recipient_list','div' => false, 'label' => false,'cols'=> 50,'rows'=>2)); ?>
                    
						<h3 class="billing" style="margin-bottom:0px;margin-top:0px;margin-left:0px;"><?php echo $form->label(__('Invite Message', true));?></h3>
						<?php echo $form->textarea('message', array('div' => false, 'label' => false,'cols'=> 50,'rows'=>7)); ?>
				
					<?php echo $form->end(__('Invite Now', true)); ?>
					<br style="clear:both;">
					<div id="importer" style="display:none;">
						<h3 class="billing" style="margin-left:0px;"><?php __('Import your contacts from webmail services');?></h3>
						<?php echo $html->link($html->image('aol.gif', array('border' => 0)), array('action' => 'import', 'aol'), array('class' => 'importAction', 'title' => 'aol.com'), null, false);?>
						<?php echo $html->link($html->image('gmail.gif', array('border' => 0)), array('action' => 'import', 'gmail'), array('class' => 'importAction', 'title' => 'gmail.com'), null, false);?>
						<?php echo $html->link($html->image('hotmail.gif', array('border' => 0)), array('action' => 'import', 'hotmail'), array('class' => 'importAction', 'title' => 'hotmail.com'), null, false);?>
						<?php echo $html->link($html->image('msn_mail.gif', array('border' => 0)), array('action' => 'import', 'msn_mail'), array('class' => 'importAction', 'title' => 'msn.com'), null, false);?>
						<?php echo $html->link($html->image('yahoo.gif', array('border' => 0)), array('action' => 'import', 'yahoo'), array('class' => 'importAction', 'title' => 'yahoo.com'), null, false);?>
					</div>
					<div id="importer_form" style="display: none">
						<fieldset>
						<?php echo $form->create('User', array('action' => 'import'));?>
							<?php echo $form->input('login', array('class' => 'importerLogin', 'after' => '@<span id="importer_service">&nbsp;</span>'));?>
							<?php echo $form->input('password', array('class' => 'importerPassword'));?>
							<?php echo $form->submit('Import', array('class' => 'importerSubmit'));?>
						<?php echo $form->end();?>
						</fieldset>
					</div>
					<div id="importer_inprogress" style="display: none">
						<?php echo $html->image('spinner2.gif');?>   <?php __('Please wait while we import your contacts...');?>
					</div>
				</div>
                </div>
			</div>
    </div> 
    </div>
    </div>
<?php echo $javascript->link('importer');?>