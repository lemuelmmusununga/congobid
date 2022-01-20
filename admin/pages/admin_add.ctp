<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>

<div class="pages form">
<?php echo $form->create('Page');?>
	<fieldset>
 		<legend><?php __('Add a Page');?></legend>
	<?php
		echo $form->input('name', array('label' => __('Page Name *', true)));
		echo $form->input('title', array('label' => __('Meta Title *', true)));
	?>

	<label for="PageContent"><?php __('Content *');?></label>
	<?php echo $fck->input('Page.content'); ?>

 

	</fieldset>
<?php echo $form->end(__('Add Page', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to pages', true), array('action' => 'index'));?></li>
	</ul>
</div>
