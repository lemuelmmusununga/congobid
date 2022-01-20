<style>
.shadow_bg{width:1360px!important}
.totalresults{
	display:none;
}
</style>
 <div class="step_titel">
<div class="doc_width"><h1><?php echo sprintf(__('My %s', true), $appConfigurations['name']); ?></h1>

<?php
				$html->addCrumb(__('My Account', true), '/accounts');
				echo $this->element('crumb_user');
				?>
</div>
</div>
<div class="main_content">
 
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
		<div class="doc_width shadow_bg">			
			
			<div id="rightcol">
			<div class="rightcol_inner">            
				
				
				
				<div class="mange_space">
				<?php if(!empty($accounts)): ?>
					<?php echo $this->element('pagination'); ?>
				<div class="table-responsive">
					<table class="results" cellpadding="0" cellspacing="0">
						<tr>
							<th><?php echo $paginator->sort(__('Date'), 'created');?></th>
							<th><?php echo $paginator->sort(__('Description'), 'Account.name');?></th>
							<th><?php echo $paginator->sort(__('Amount'), 'Auction.price');?></th>
						</tr>
					<?php
					$i = 0;
					foreach ($accounts as $account):
						$class = null;
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
						}
						$is_points = strpos($account['Account']['name'], 'axdi Points');
						$is_reward = strpos($account['Account']['name'], 'eward Store');
					?>
						<tr<?php echo $class;?>>
							<td>
								<?php echo $time->niceShort($account['Account']['created']); ?>
							</td>
							<td>
								<?php echo   $account['Account']['name']; ?>
								<?php if($account['Account']['auction_id']) : ?>
									<a href="/auctions/view/<?php echo $account['Account']['auction_id']; ?>"><?php __('View this Auction');?></a>
								<?php elseif($account['Account']['bids']) : ?>
									<?php echo ($is_points || $is_reward ) ? '' :      __('- '.$account['Account']['bids'].' Bids Purchased')  ;?> 
								
								<?php endif; ?>
							</td>
							<td>
								<?php
								echo ($is_points || $is_reward) ? $account['Account']['price'] :  $number->currency($account['Account']['price'], $appConfigurations['currency']); 
								
								?>
							</td>
						</tr>
					<?php endforeach; ?>
					</table>
			</div>             				
					<?php echo $this->element('pagination'); ?>
				
				<?php else:?>
					<p><?php __('You have no account transactions at the moment.');?></p>
				<?php endif;?>
                </div>
                </div>
			</div>
    </div> 
    </div>
