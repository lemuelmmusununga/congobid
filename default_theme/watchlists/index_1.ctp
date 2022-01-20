<style>
.shadow_bg{width:1360px!important}
fieldset label{
	width:100%;
	padding-bottom:5px;
}
fieldset div.submit{
	margin-left:0px!important;
	margin-top:10px!important;
}
fieldset .text input, fieldset .password input, fieldset .textarea textarea{
	width:270px;
}
</style>
 <div class="box clearfix">
<div class="step_titel">
<div class="doc_width"><h1><?php __('My Watchlist');?></h1>
<?php
				$html->addCrumb(__('My Watchlist', true), '/watchlists');
				echo $this->element('crumb_user');
				?>
</div>
</div>
<div class="main_content">
 <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
	<div class="doc_width shadow_bg">			
			
			<div id="rightcol">
			<div class="rightcol_inner">            
				<?php if($paginator->counter() > 0):?>
					<?php echo $this->element('pagination'); ?>
					<div class="table-responsive">
					<table class="results" cellpadding="0" cellspacing="0">
						<tr>
							<th><?php __('Image');?></th>
							<th><?php __('Title');?></th>
							<th><?php echo $paginator->sort('end_time');?></th>
							<th><?php echo $paginator->sort('price');?></th>
							<th class="actions"><?php __('Actions');?></th>
						</tr>
						<?php
						$i = 0;
						foreach ($watchlists as $watchlist):
							$class = null;
							if ($i++ % 2 == 0) {
								$class = ' class="altrow"';
							}
						?>
						<tr<?php echo $class;?>>
							<td>
								<?php if(!empty($watchlist['Auction']['Product']['Image'][0]['image'])):?>
									<?php if(!empty($watchlist['Auction']['Product']['Image'][0]['ImageDefault']['image'])) : ?>
										<?php echo $html->image('default_images/'.$appConfigurations['serverName'].'/thumbs/'.$watchlist['Auction']['Product']['Image'][0]['ImageDefault']['image']); ?>
									<?php else: ?>
										<?php echo $html->image('product_images/thumbs/'.$watchlist['Auction']['Product']['Image'][0]['image']); ?>
									<?php endif; ?>
								<?php else:?>
									<?php echo $html->image('product_images/thumbs/no-image.gif');?>
								<?php endif;?>
							</td>
							<td>
								<?php echo $html->link($watchlist['Auction']['Product']['title'], array('controller'=> 'auctions', 'action'=>'view', $watchlist['Auction']['id'])); ?>
							</td>
							<td>
								<?php echo $time->niceShort($watchlist['Auction']['end_time']); ?>
							</td>
							<td>
								<?php echo $number->currency($watchlist['Auction']['price'], $appConfigurations['currency']); ?>
							</td>
							<td class="actions">
								<?php echo $html->link(__('Delete', true), array('action'=>'delete', $watchlist['Watchlist']['id']),array('class' => 'btn_new animated-btn animated-1 small_btn'), null, __('Are you sure you want to delete this auction from your watchlist?', true)); ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</table>
					</div>
				<div class="bottom_tr">&nbsp;</div>                                 
				<?php else:?>
					<?php __('You are not watching any auctions at the moment.');?>
				<?php endif;?>
                </div>
                </div>
			</div>
           </div> 
    </div>
    </div>