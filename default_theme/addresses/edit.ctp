<style>
fieldset label{text-align:right;width:200px;}
select{font-weight:normal;}
</style>
<div class="box clearfix input_line input_only_line address_shipping">

<div class="step_titel">
<div class="doc_width">
<h1><?php __('Change Address');?></h1>
<?php
				$html->addCrumb('My Addresses', '/addresses');
				$html->addCrumb('Edit', '/addresses/edit/'.$name);
				echo $this->element('crumb_user');
				?>
</div>				

</div>
<div class="main_content edit_propfile">
<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
		<div class="doc_width shadow_bg">			

			
			<div id="rightcol">
			<div class="rightcol_inner">            
				
				
				<?php echo $form->create(null, array('url' => '/addresses/edit/'.$name));?>
					<fieldset>
					<?php
						echo $form->input('id');
						?>
						
						<div class="edit_user">
					<?php echo $form->input('name', array('label' => __('Name', true))); ?> 
					</div>
					
					<div class="edit_user">
					<?php echo $form->input('address_1', array('label' => __('Address 1', true))); ?> 
					</div>
					
					<div class="edit_user">
					<?php echo $form->input('address_2', array('label' => __('Address 2', true))); ?> 
					</div>
					
					<div class="edit_user">
					<?php echo $form->input('suburb', array('label' => __('Suburb / Town', true))); ?> 
					</div>	
					
					<div class="edit_user">
					<?php echo $form->input('city', array('label' => __('City', true))); ?>
					</div>
					
					<div class="edit_user">
					<?php echo $form->input('postcode', array('label' => __('Postcode', true))); ?> 
					</div>
					
					<div class="edit_user">
					<?php echo $form->input('phone', array('label' => __('Phone', true))); ?> 
					</div>
					
					<div class="edit_user">
					<?php
					echo $form->input('country_id', array('empty' => 'Select'));
					?>
					</div>
					
						
					
				<div class="hide">	
				<?php 
					echo $form->input('update_all', array('type' => 'checkbox', 'label' => __('Make all your addresses this address.', true)));
				?>
				</div>
					
					<div class="center_btn">
				 <?php echo $form->end(__('Update Address', true));?>
				</div>
				</fieldset>
			                </div>
			</div>

</div> 
    </div>

</div>