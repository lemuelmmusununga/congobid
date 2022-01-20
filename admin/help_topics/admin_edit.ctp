<?php
	$html->addCrumb(__('Settings', true), '/admin/settings');
	$html->addCrumb(__('Help HelpTopic', true), '/admin/help_topics');
	$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$this->data['HelpTopic']['id']);
	echo $this->element('admin/crumb');
?>

<div class="helptopic form">
<?php echo $form->create();?>
	<fieldset>
 		<legend><?php __('Edit a Help HelpTopic');?></legend>
			
		<div class="input text">
			<label for="HelpTopicStatus">Help Category </label>	
			<?php echo $form->select('helpcategory_id', $categorylist, $this->data['HelpTopic']['helpcategory_id']) ?>
		</div>
		<?php
			echo $form->input('id');
			echo $form->input('title');
			echo $form->input('description');
		?>
		<div class="input text">
			<label for="HelpTopicStatus">Status </label>	
			<select name="data[HelpTopic][status]">				
				<option value="1" <?php if($this->data['HelpTopic']['status'] ==1) echo "selected" ?> >Active</option>
				<option value="0" <?php if($this->data['HelpTopic']['status'] ==0) echo "selected" ?>>InActive</option>		
			</select>
		</div>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to Help HelpTopic', true), array('action' => 'index'));?></li>
	</ul>
</div>
