<style>
fieldset label{text-align:right;width:200px;}
select{font-weight:normal;}
fieldset div.submit{margin:0px 0px 0px 215px!important;}
</style>
<div class="step_titel">

<div class="doc_width"><h1><?php __('Add New Address');?></h1></div>

</div>
<div class="main_content main_content_address">

		<div class="main_content_middle">			

			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
			<div class="rightcol_inner">            
				<?php
				$html->addCrumb(__('My Addresses', true), '/addresses');
				$html->addCrumb(__('Add', true), '/addresses/add/'.$name);
				echo $this->element('crumb_user');
				?>
				
				<fieldset>
				<?php echo $form->create(null, array('url' => '/addresses/add/'.$name));?>
				<?php
					echo $form->input('name', array('label' => __('Name *', true)));
					echo $form->input('address_1', array('label' => __('Address (line 1) *', true)));
					echo $form->input('address_2', array('label' => __('Address (line 2)', true)));
					echo $form->input('suburb', array('label' => __('Suburb / Town', true)));
					echo $form->input('city', array('label' => __('City / State / County *', true)));
					echo $form->input('postcode', array('label' => __('Post Code / Zip Code *', true)));
					echo $form->input('country_id', array('label' => __('Country *', true), 'empty' => 'Select'));
					echo $form->input('phone', array('label' => __('Phone', true)));
					echo $form->input('update_all', array('type' => 'checkbox', 'label' => __('Make all your addresses this address.', true)));
				?>
				<?php echo $form->end('Add Address');?>
				</fieldset>
				<div class="actions" style="margin-left:215px;">
					<ul>
						<li><?php echo $html->link(__('<< Back to your addresses', true), array('action' => 'index'));?></li>
					</ul>
				</div>
                </div>
			</div>


</div> 
    </div>

