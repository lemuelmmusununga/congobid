<style>
.wonauctions2 td{padding:10px 0px;}
</style>
<?php
$html->addCrumb(__('Manage Auctions', true), '/admin/auctions');
if(!empty($extraCrumb)) :
	$html->addCrumb($extraCrumb['title'], '/admin/auctions/'.$extraCrumb['url']);
endif;
echo $this->element('admin/crumb');
?>

<div class="auctions index">

<h2><?php __('store orders ');?></h2>

<?php if(!empty($statuses)):?>
	<p><?php __('View by status :');?>
	<?php echo $form->create('Auction', array('action' => 'won'));?>
	<?php echo $form->input('status_id', array('id' => 'selectStatus', 'selected' => $selected, 'options' => $statuses, 'label' => false));?>
	<?php echo $form->end();?></p>
<?php endif;?>

<div class="actions">
	<ul>
		<li class="addpage"><?php echo $html->link(__('Manage your Products', true), array('controller' => 'products', 'action' => 'index')); ?></li>
	</ul>
</div>

<?php if($paginator->counter() > 0):?>

<?php echo $this->element('admin/pagination'); ?>
<div style="clear:both;"></div>
<div style="padding:10px; border-top:1px solid #eee; font-weight:bold; font-size:16px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">
<table class="wonauctions2" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <?php

$query = "SELECT amount, SUM(amount) FROM storeorders"; 
	 
$result = mysql_query($query) or die(mysql_error());

// Print out result
while($row = mysql_fetch_array($result)){
	echo "Total Order Balance ". " = ". $number->currency($row['SUM(amount)'], $appConfigurations['currency']);
}
?>
    </td>
    <td>
    <?php

$query = "SELECT amount, SUM(amount) FROM storeorders WHERE status_id = 3"; 
	 
$result = mysql_query($query) or die(mysql_error());

// Print out result
while($row = mysql_fetch_array($result)){
	echo "Total Paid-Fulfilled Order ". " = ". $number->currency($row['SUM(amount)'], $appConfigurations['currency']);
}
?>
    </td>
        <td>
    <?php

$query = "SELECT amount, SUM(amount) FROM storeorders WHERE status_id = 2"; 
	 
$result = mysql_query($query) or die(mysql_error());

// Print out result
while($row = mysql_fetch_array($result)){
	echo "Total Paid-Unfulfilled Order ". " = ". $number->currency($row['SUM(amount)'], $appConfigurations['currency']);
}
?>
    </td>
    <td>
    <?php

$query = "SELECT amount, SUM(amount) FROM storeorders WHERE status_id = 1"; 
	 
$result = mysql_query($query) or die(mysql_error());

// Print out result
while($row = mysql_fetch_array($result)){
	echo "Total Unpaid Order ". " = ". $number->currency($row['SUM(amount)'], $appConfigurations['currency']);
}
?>
    </td>
  </tr>
</table>
</div>

<table class="wonauctions" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<th><?php __('User ID');?></th>
	<th><?php __('cart ID');?></th>
	 <th><?php echo $paginator->sort('title');?></th>
	<th><?php __('Price');?></th>
    <th><?php __('Qty');?></th>
    <th><?php __('Shipping');?></th>
    <th><?php __('Total');?></th>
    <th><?php __('Size');?></th>
	<th><?php __('color');?></th>
	<th><?php echo $paginator->sort('Date Ordered', 'end_time');?></th>
	<th><?php echo $paginator->sort('Status', 'Status.name');?></th>			 
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($orders as $order):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	#echo '<pre>';print_r($order);echo '</pre>'; exit;
?>
	<tr<?php echo $class;?>>
    						<td>
                            	<?php echo $html->link($order['Storeorder']['user_id'], array('controller' => 'users', 'action' => 'view', $order['User']['id'])); ?>
								
							</td>
							<td>
                            	<?php echo $html->link($order['Storeorder']['cart_id'], array('target'=>'_blank', 'controller' => 'storeorders', 'action' => 'cart', $order['Storeorder']['cart_id'])); ?>
								
							</td>
			<td>
							
								<?php echo $html->link($order['Product']['title'], array('admin' => false, 'controller' => 'products', 'action' => 'view', $order['Product']['id']),  array('target' => '_blank')); ?>
							</td>
							<td>
								<?php echo  $order['Storeorder']['amount'] ; ?>
							</td>
                            <td>
								<?php echo  $order['Storeorder']['quantity'] ; ?>
							</td>
                            <td>
								<?php echo  $order['Storeorder']['shipping'] ; ?>
							</td>
                            <td>
								<?php echo  ($order['Storeorder']['amount'] * $order['Storeorder']['quantity']) +  $order['Storeorder']['shipping']; ?>
							</td>
							<td>
								<?php echo  $order['Storeorder']['size'] ; ?>
							</td>
							<td>
								<?php echo  $order['Storeorder']['color'] ; ?>
							</td>
							<td>
								<?php echo $time->niceShort($order['Storeorder']['created']); ?>
							</td>
							<td>
								<?php echo $order['Status']['name']; ?>
							</td>
							<td nowrap="nowrap">
								<?php echo $html->link(__('View', true), array('admin' => false, 'controller'=> 'products', 'action' => 'view', $order['Product']['id'])); ?>
								 | 
									<?php echo $html->link(__('Update Status', true), array('action' => 'winner', $order['Storeorder']['id'])); ?>
								 
							</td>
	</tr>
<?php endforeach; ?>
</table>
<?php echo $this->element('admin/pagination'); ?>

<?php else: ?>
	<p><?php __('There are no auctions at the moment.');?></p>
<?php endif; ?>
</div>

<div class="actions">
	<ul>
		<li class="addpage"><?php echo $html->link(__('Manage your Products', true), array('controller' => 'products', 'action' => 'index')); ?></li>
	</ul>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		if($('#selectStatus').length){
			$('#selectStatus').change(function(){
				location.href = '/admin/storeorders/index/' + $('#selectStatus').val();
			});
		}	});
</script>