<?php
	$html->addCrumb(__('Settings', true), '/admin/settings');
	$html->addCrumb(__('Help Topics', true), '/admin/help_topics');
	$html->addCrumb(__('Create', true), '/admin/help_topics/create');
	echo $this->element('admin/crumb');
?>

<div class="helpcategory form">

	<?php echo $form->create('HelpTopic', array('url' => '/admin/help_topics/create'));?>
		<fieldset>
			
			<legend><?php __('Create Help Topics');?></legend>
			<div class="input text">
				<label for="HelpTopicStatus">Help Category </label>		
				<?php echo $form->select('HelpTopic.helpcategory_id', $helpcategory_id,1); ?>
				<?php /*<?=$f->select('ManufacturersProductsLine.manufacturer_id', $manufacturers, null, array('multiple'=>'multiple', 'style'=>'height:100px;'))? */ ?>
			</div>
			<?php echo $form->input('title', array('label' => __('Title *', true))); ?>
			<?php echo $form->input('description', array('label' => __('Description', true))); ?>		
			<div class="input text">
				<label for="HelpTopicStatus">Status </label>	
				<select name="data[HelpTopic][status]">
					<option value="1">Active</option>
					<option value="0">InActive</option>		
				</select>
			</div>
			
		</fieldset>
	<?php echo $form->end(__('Add Help Topic >>', true));?>
	
</div>

<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to Help Topic', true), array('action' => 'index'));?></li>
	</ul>
</div>
