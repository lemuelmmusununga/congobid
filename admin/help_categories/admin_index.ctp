<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Help Categories', true), '/admin/help_categories');
echo $this->element('admin/crumb');
?>

<div class="helpcategory auctions index">
	<h2><?php __('Help Categories');?></h2>

	<div class="actions">
		<ul>
			<li class="addpage"><?php echo $html->link(__('Create a new Help Category', true), array('action' => 'create')); ?></li>
		</ul>
	</div>

	<?php if($paginator->counter() > 0):?>

	<?php echo $this->element('admin/pagination'); ?>


<table class="wonauctions" cellpadding="0" width="100%" cellspacing="0">
		<tr>
			<th><?php echo $paginator->sort('title');?></th>
			<th><?php echo $paginator->sort('status');?></th>
			<th class="actions"><?php __('Options');?></th>
		</tr>
		<tbody id="imageList">
			<?php
			$i = 0;
			foreach ($help_categories as $help_category):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
				<tr<?php echo $class;?>>
					<td><?php echo $help_category['HelpCategory']['title']; ?></td>
					<?php  $helpstatus = ($help_category['HelpCategory']['status'] ==1) ? 'Active' : 'InActive'; ?>
					<td><?php echo $helpstatus; ?></td>
					<td class="actions">
						<?php echo $html->link(__('Edit', true), array('action'=>'edit', $help_category['HelpCategory']['id'])); ?>  
                        
                         <?php echo $html->link(__('Delete', true), array('action'=>'delete', $help_category['HelpCategory']['id']), null, sprintf(__('Are you sure you want to delete this Help Category?', true))); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php echo $this->element('admin/pagination'); ?>

<?php else: ?>
	<p><?php __('There are no Help Category at the moment.');?></p>
<?php endif; ?>

<div class="actions">
	<ul>
		<li class="addpage"><?php echo $html->link(__('Create a new Help Category', true), array('action' => 'create')); ?></li>
	</ul>
</div>
