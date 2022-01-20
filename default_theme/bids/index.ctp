<style>
.shadow_bg{width:1360px!important}
</style>
 <div class="box clearfix">
 <div class="step_titel">
<div class="doc_width"><h1> <?php __('My Bids');?></h1>
<?php
				$html->addCrumb(__('My Bids', true), '/bids');
				echo $this->element('crumb_user');
				?>

</div>
</div>
<div class="main_content">
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
		<div class="doc_width shadow_bg">			
			
			<div id="rightcol">
			<div class="rightcol_inner">            
				
			
                <div class="mange_space_bids">               			
				<?php if($appConfigurations['simpleBids'] == false) : ?>
					<?php if(!empty($bids)): ?>
						<?php # echo $this->element('pagination'); ?>
				<div class="table-responsive">
						<table class="results" cellpadding="0" cellspacing="0">
							<tr>
								<th><?php echo $paginator->sort('Date', 'Bid.created');?></th>
								<th><?php echo $paginator->sort('description');?></th>
								<th><?php echo $paginator->sort('debit');?></th>
								<th><?php echo $paginator->sort('credit');?></th>
							</tr>
							<tr>
								<td colspan="3"><strong><?php __('Current Balance');?></strong></td>
								<td><strong><?php echo $bidBalance; ?></strong></td>
							</tr>
						<?php
						$i = 0;
						foreach ($bids as $bid):
							$class = null;
							if ($i++ % 2 == 0) {
								$class = ' class="altrow"';
							}
						?>
							<tr<?php echo $class;?>>
								<td>
									<?php echo $time->niceShort($bid['Bid']['created']); ?>
								</td>
								<td>
									<?php echo $bid['Bid']['description']; ?>
									<?php if(!empty($bid['Bid']['auction_id'])) : ?>
										<?php __('placed on auction titled:');?> &nbsp; <?php echo $html->link($bid['Auction']['Product']['title'], array('controller' => 'auctions', 'action' => 'view', $bid['Bid']['auction_id']));?>
									<?php endif; ?>
								</td>
								<td>
									 <?php echo (int) $bid['Bid']['debit']; ?> 
								</td>
								<td>
									 <?php echo ($bid['Bid']['credit']) ? (int)$bid['Bid']['credit'] : ''; ?> 
								</td>
							</tr>
						<?php endforeach; ?>
						</table>
								</div>             

						<?php echo $this->element('pagination'); ?>
				
					<?php else:?>
						<p><?php __('You have no bids in your account.');?></p>
					<?php endif;?>
				<?php else:?>
					<?php __('You have'); ?> <strong><?php echo $bidBalance; ?></strong> <?php __('bids in your account'); ?>
				<?php endif; ?>
                </div>
                </div>
			</div>
    </div> 
    </div>
    </div>
