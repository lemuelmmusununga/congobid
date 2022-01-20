<?php
$html->addCrumb(__('General Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="currencies index">

<div class="auctions"><h2><?php __('Currencies');?></h2></div>
<blockquote><p>Use this page to configure currencies and their rates.</p></blockquote>
<?php if($paginator->counter() > 0):?>

<?php echo $this->element('admin/pagination'); ?>

<table class="wonauctions" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<th><?php echo $paginator->sort('currency');?></th>
	<th><?php echo $paginator->sort('rate');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($currencies as $currency):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td width="33%">
			<?php echo $currency['Currency']['currency']; ?>
		</td>
		<td width="33%">
			<?php echo $currency['Currency']['rate']; ?>
		</td>
		<td class="actions" width="33%">
		<span class="edit"><?php echo $html->link(__('Edit', true), array('action' => 'edit', $currency['Currency']['id'])); ?></span>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('admin/pagination'); ?>

<?php else:?>
	<p><?php __('There are no currencies at the moment.');?></p>
<?php endif;?>
</div>
