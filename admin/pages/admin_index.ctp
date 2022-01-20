<?php
$html->addCrumb(__('Manage Pages', true), '/admin/pages');
$html->addCrumb(__('Pages', true), '/admin/pages');
echo $this->element('admin/crumb');
?>

<div class="pages auctions index">

<h2><?php __('Pages');?></h2>

<blockquote><p>Add new content &amp; pages here to your website. You can specify where you want the pages to appear - either 'top' (at the top of the page), 'bottom' (at the bottom of the page), or neither ('static'). </p></blockquote>

<div class="actions">
	<ul>
		<li class="addpage"><?php echo $html->link(__('Add a new page', true), array('action' => 'add')); ?></li>
	</ul>
</div>
<div class="page_page">
<h2><?php __('Top Menu Pages');?></h2>
 
<?php if(!empty($staticPages)):?>
<div id="sortableStatus" class="message" style="display: none"></div>
<table id="pageList" class="wonauctions" width="100%" cellpadding="0" cellspacing="0">
<tr>
	<th><?php __('Name');?></th>
	<th><?php __('Last Modified');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($staticPages as $page):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr <?php echo $class;?>>
		<td width="33%">
			<?php echo $page['Page']['name']; ?>
		</td>
		<td width="33%">
			<?php echo $time->niceShort($page['Page']['modified']); ?>
		</td>
		<td class="actions" width="33%">
			<span><?php echo $html->link(__('View', true), array('admin' => false, 'controller' => false, 'action'=>'view', $page['Page']['slug']), array('target' => '_blank')); ?></span>
			 <span class="edit"><?php echo $html->link(__('Edit', true), array('action'=>'edit', $page['Page']['id'])); ?></span>
			<span class="delete"><?php echo $html->link(__('Delete', true), array('action' => 'delete', $page['Page']['id']), null,
			
			 sprintf(__('Are you sure you want to delete the page named: %s?', true), $page['Page']['name'])); ?></span>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<?php else:?>
	<p><?php __('There are no static pages at the moment.');?></p>
<?php endif;?>


</div>

<div class="actions">
	<ul>
		<li class="addpage"><?php echo $html->link(__('Add a new page', true), array('action' => 'add')); ?></li>
	</ul>
</div>
