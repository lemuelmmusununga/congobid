<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Help Category', true), '/admin/help_categories');
$html->addCrumb(__('Create', true), '/admin/help_categories/create');
echo $this->element('admin/crumb');
?>

<div class="helpcategory form">

<?php echo $form->create('HelpCategory', array('url' => '/admin/help_categories/create'));?>
	<fieldset>
 		<legend><?php __('Create Help Categories');?></legend>
		<?php echo $form->input('title', array('label' => __('Title *', true))); ?>	
		
		<div class="input text">
			<label for="HelpCategoryStatus">Status </label>	
			<select name="data[HelpCategory][status]">
				<option value="1">Active</option>
				<option value="0">InActive</option>		
			</select>
		</div>
	</fieldset>
<?php echo $form->end(__('Add Help Category >>', true));?>
</div>

<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to Help Category', true), array('action' => 'index'));?></li>
	</ul>
</div>
