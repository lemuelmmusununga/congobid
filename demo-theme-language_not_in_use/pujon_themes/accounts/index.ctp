<style>
.totalresults{
	display:none;
}
</style>
 <div class="step_titel">
<div class="doc_width"><h1> <?php __('My Account');?></h1></div>
</div>
<div class="main_content">
 
 
		<div class="main_content_middle">			
			<div id="leftcol">
				<?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
			</div>
			<div id="rightcol">
			<div class="rightcol_inner">            
				<?php
				$html->addCrumb(__('My Account', true), '/accounts');
				echo $this->element('crumb_user');
				?>
				<div class="mange_space">
				<?php if(!empty($accounts)): ?>
					<?php echo $this->element('pagination'); ?>
				
					<table class="results" cellpadding="0" cellspacing="0">
						<tr>
							<th><?php echo $paginator->sort('Date', 'created');?></th>
							<th><?php echo $paginator->sort('Description', 'Account.name');?></th>
							<th><?php echo $paginator->sort('Amount', 'Auction.price');?></th>
						</tr>
					<?php
					$i = 0;
					foreach ($accounts as $account):
						$class = null;
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
						}
					?>
						<tr<?php echo $class;?>>
							<td>
								<?php echo $time->niceShort($account['Account']['created']); ?>
							</td>
							<td>
								<?php echo $account['Account']['name']; ?>
								<?php if($account['Account']['auction_id']) : ?>
									<a href="/auctions/view/<?php echo $account['Account']['auction_id']; ?>"><?php __('View this Auction');?></a>
								<?php elseif($account['Account']['bids']) : ?>
									- <?php echo $account['Account']['bids']; ?> <?php __('Bids Purchased');?>
								<?php endif; ?>
							</td>
							<td>
								<?php echo $number->currency($account['Account']['price'], $appConfigurations['currency']); ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</table>
				<div class="bottom_tr">&nbsp;</div>             				
					<?php echo $this->element('pagination'); ?>
				
				<?php else:?>
					<p><?php __('You have no account transactions at the moment.');?></p>
				<?php endif;?>
                </div>
                </div>
			</div>
    </div> 
    </div>
