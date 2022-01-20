<?php
	$html->addCrumb(__('Settings', true), '/admin/settings');
	$html->addCrumb(__('Help Category', true), '/admin/help_categories');
	$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$this->data['HelpCategory']['id']);
	echo $this->element('admin/crumb');
?>

<div class="helpcategory form">
<?php echo $form->create();?>
	<fieldset>
 		<legend><?php __('Edit a Help Category');?></legend>
		<?php
			echo $form->input('id');
			echo $form->input('title');
		?>
		<div class="input text">
			<label for="HelpCategoryStatus">Status </label>	
			<select name="data[HelpCategory][status]">
				
				<option value="1" <?php if($this->data['HelpCategory']['status'] ==1) echo "selected" ?> >Active</option>
				<option value="0" <?php if($this->data['HelpCategory']['status'] ==0) echo "selected" ?>>InActive</option>		
			</select>
		</div>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to Help Category', true), array('action' => 'index'));?></li>
	</ul>
</div>
