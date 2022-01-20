<?php
$html->addCrumb(__('Manage Orders', true), '/admin/tokens');

echo $this->element('admin/crumb');
?>

<div class="auctions index">

<h2><?php __('Orders Placed');?></h2>
<blockquote><p>Below you can see an overview of all orders that have been placed.  </p></blockquote>
<?php if($paginator->counter() > 0):?>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php __('Order Number');?></th>
	<th><?php __('Title');?></th>
	<th><?php __('Username');?></th>
	<th><?php __('Amount');?></th>
	<th><?php __('Status');?></th>
	<th><?php __('Date');?></th><th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($tokens as $token):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
							
	<td><?php echo $token['Token']['id'] ; ?></td>
	<td><?php echo $token['Token']['title'] ; ?></td>
	<td><?php echo $token['User']['username'] ; ?></td>
	<td><?php echo $number->currency($token['Token']['amount'], $appConfigurations['currency'] ) ; ?></td>
	<td><?php echo ($token['Token']['status'] == 0) ? 'Pending'  : 'Completed' ; ?></td>
	
	<td>
		<?php echo $time->niceShort($token['Token']['created']); ?>
	</td>
	<td>
		<?php if($token['Token']['status'] == 0){ ?>
					
					<a href="/admin/payment_gateways/payment_approve/<?php echo $token['Token']['id']; ?>" onclick="return confirm('Are you sure you want to Approve order # <?php echo $token['Token']['id']; ?> ');">Approve</a>
					| <a href="/admin/tokens/delete/<?php echo $token['Token']['id']; ?>" onclick="return confirm('Are you sure you want to Delete order # <?php echo $token['Token']['id']; ?> ');">Delete</a>
			<?php } ?>
	</td>
							
						</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('admin/pagination'); ?>

<?php else: ?>
	<p><?php __('No orders have been placed on the site yet.');?></p>
<?php endif; ?>
</div>
