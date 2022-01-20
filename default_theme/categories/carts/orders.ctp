<div class="box clearfix">
<div class="top_heading">
<span><img alt="" src="<?php echo $this->webroot; ?>img/heading_left.png"></span>
<ul>
<li><span><img alt="" src="<?php echo $this->webroot; ?>img/titel_left.png"></span><h1>
<label><img alt="" src="<?php echo $this->webroot; ?>img/watch_icon.png"></label>
My Orders</h1><span>
<img alt="" src="<?php echo $this->webroot; ?>img/titel_right.png"></span></li>
</ul>
<span><img alt="" src="<?php echo $this->webroot; ?>img/heading_right.png"></span>
</div>
<div class="main_content">
 
 
 
		<div class="main_content_middle">			
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
				<?php
				$html->addCrumb(__('My Orders', true), '/carts/orders');
				echo $this->element('crumb_user');
				?>
			
			
				<?php if($appConfigurations['simpleBids'] == false) : ?>
					<?php if(!empty($orders)): ?>
						<?php echo $this->element('pagination'); ?>
				
						<table class="results" cellpadding="0" cellspacing="0">
							<tr>
								<th><?php echo $paginator->sort('Date', 'Cart.created');?></th>
								<th><?php echo $paginator->sort('Products');?></th>
								<th><?php echo $paginator->sort('Total');?></th>
								<th><?php echo $paginator->sort('status');?></th>
							 
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
								<td><?php echo $time->niceShort($order['Cart']['created']); ?></td>
								<td>
									<?php foreach($order['CartProduct'] as $prd){ 
											
											if($prd['prd_title'] == ''){
												$prd_ttl = mysql_fetch_array(mysql_query("SELECT title FROM products WHERE  id = '".$prd['pid']."' "), MYSQL_ASSOC);
												
												mysql_query("UPDATE cart_products SET prd_title = '".$prd_ttl['title']."'	where id = '".$prd['id']."'");
												$prd['prd_title'] = $prd_ttl['title'];
												
											}
											$prd['prd_title'] = $prd['prd_title'] ;
											
											 
											
									?>
											
											<?php echo $prd['prd_title']; ?><br />
											<?php echo 'Quantity: '. $prd['quantity'].' |  Amount: '.$prd['amount']; ?> = <?php echo $number->currency( ($prd['quantity']*$prd['amount']), $appConfigurations['currency']); ?>
											
											<hr />
									<?php }?>
								<td><?php echo $number->currency( $order['Cart']['amount']); ?></td>
								<td><?php echo $order['Status']['name']; ?></td>
								 
							</tr>
						<?php endforeach; ?>
						</table>
				
						<?php echo $this->element('pagination'); ?>
				
					<?php else:?>
						<p>You have no orders in your cart.</p>
					<?php endif;?>
				<?php else:?>
					<?php __('You have'); ?> <strong><?php echo $bidBalance; ?></strong> <?php __('bids in your account'); ?>
				<?php endif; ?>
			</div>
        
    </div> 
    </div>
    </div>
            
