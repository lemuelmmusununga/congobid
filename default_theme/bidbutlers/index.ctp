<style>
.shadow_bg{width:1360px!important}
</style>
 <div class="box clearfix">



 <div class="step_titel">
<div class="doc_width"><h1>  <?php __('My BidBuddies');?> </h1>
<?php
					$html->addCrumb(__('My Bid Butlers', true), '/bidbutlers');
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
				<?php if(!empty($bidbutlers)): ?>
					<?php echo $this->element('pagination'); ?>
				
				<div class="table-responsive">
		
					<table class="results" cellpadding="0" cellspacing="0">
						<tr>
							<th> <?php __('Image');?></th>
							<th> <?php __('Auction');?></th>
							<?php if($appConfigurations['bidButlerType'] !== 'simple') : ?>
								<th> <?php __('Minimum Price');?></th>
								<th> <?php __('Maximum Price');?></th>
							<?php endif; ?>
							<th> <?php __('Bids Left');?></th>
							<th> <?php __('Date');?></th>
							<th class="actions"> <?php __('Options');?></th>
						</tr>
					<?php
					$i = 0;
					foreach ($bidbutlers as $bidbutler):
						$class = null;
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
						}
					?>
						<tr<?php echo $class;?>>
							<td>
							<a href="/auctions/view/<?php echo $bidbutler['Auction']['id']; ?>">
							<?php if(!empty($bidbutler['Auction']['Product']['Image'])):?>
								<?php if(!empty($bidbutler['Auction']['Product']['Image'][0]['ImageDefault']['image'])) : ?>
									<?php echo $html->image('default_images/'.$appConfigurations['serverName'].'/thumbs/'.$bidbutler['Auction']['Product']['Image'][0]['ImageDefault']['image']); ?>
								<?php else: ?>
									<?php echo $html->image('product_images/thumbs/'.$bidbutler['Auction']['Product']['Image'][0]['image']); ?>
								<?php endif; ?>
							<?php else:?>
								<?php echo $html->image('product_images/thumbs/no-image.gif');?>
							<?php endif;?>
							</a>
							</td>
							<td>
								<?php echo $html->link($bidbutler['Auction']['Product']['title'], array('controller'=> 'auctions', 'action'=>'view', $bidbutler['Auction']['id'])); ?>
							</td>
							<?php if($appConfigurations['bidButlerType'] !== 'simple') : ?>
								<td>
									<?php echo $number->currency($bidbutler['Bidbutler']['minimum_price'], $appConfigurations['currency']); ?>
								</td>
								<td>
									<?php echo $number->currency($bidbutler['Bidbutler']['maximum_price'], $appConfigurations['currency']); ?>
								</td>
							<?php endif; ?>
							<td>
								<?php echo $bidbutler['Bidbutler']['bids']; ?>
							</td>
							<td>
								<?php echo $time->niceShort($bidbutler['Bidbutler']['created']); ?>
							</td>
						<td class="actions block_btn">
								<?php echo $html->link(__('Edit', true), array('action'=>'edit', $bidbutler['Bidbutler']['id']),array('class' => 'btn_new animated-btn animated-1 small_btn')); ?>
								 <?php echo $html->link(__('Delete', true), array('action'=>'delete', $bidbutler['Bidbutler']['id']),array('class' => 'btn_new animated-btn animated-1 small_btn'), null, sprintf(__('Are you sure you want to delete this bid butler?', true))); ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</table>
					</div>
				
					<?php echo $this->element('pagination'); ?>
				
				<?php else:?>
					<p><?php __('You have no bid butlers at the moment.');?></p>
				<?php endif;?>
                
                <div class="users_share">
<span><a href="http://www.facebook.com/" target="_blank"><img src="<?php echo $this->webroot;?>img/black/facebook_icon.png"/></a></span>
<span><a href="http://www.twitter.com/" target="_blank"><img src="<?php echo $this->webroot;?>img/black/twitter_icon.png"/></a></span>
<span><a href="http://www.google.com/" target="_blank"><img src="<?php echo $this->webroot;?>img/black/googleplus_icon.png"/></a></span>

</div>
                </div>
				</div>             
			</div>
    </div> 
    </div>
    </div>
