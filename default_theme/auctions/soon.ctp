
<div class="step_titel">
<div class="doc_width"><h1><?php __('Future Auctions'); ?></h1></div>
</div>
<div class="doc_width">        
			
			<?php if(!empty($auctions)) : ?>
				
                
             
	<ul class="horizontal-bid-list">
	<?php
 			
	foreach($auctions as $auction):  
 	 
	$is_future = ($sec_leftF > 10) ? true : false ;	
	 
	?>
	
	
																				
	<li class="auction-item 1auction_<?php echo $auction['Auction']['id']; echo ($is_future) ? ' future ' : '' ; ?>   " title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>"><?php if(!empty($auction['Product']['fixed'])):?><a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="fixed"></span></a><?php endif; ?><?php if(!empty($auction['Auction']['free'])) : ?><a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="free"></span></a><?php endif; ?>
		 <div class="ribbon ribbon-top-right"><span><?php __('Future');?></span></div>

		 <font></font>
		  <font></font>
		  <font></font>
		  <font></font>		 

		<i class="live_icon"><span></span></i>		
		<h3><?php echo $html->link($text->truncate($auction['Product']['title'],28), AppController::AuctionLink($auction['Auction']['id'], $auction['Product']['title']));?></h3>
	   
			
			<?php if( $auction['Auction']['add_watchlist'] == 1 || $fromWatchlist == 1  ):?>
				<div class="favorite remove"><?php echo $html->link(__('Remove  Watchlist', true), array('controller' => 'watchlists', 'action'=>'delete1', $auction['Auction']['id']), null, sprintf(__('Are you sure you want to delete the auction from your watchlist??', true), $watchlist['Watchlist']['id'])); ?></div>
			<?php else:?>
				<div class="favorite add"><?php echo $html->link(__('Add to Watchlist', true), array('controller' => 'watchlists', 'action' => 'add', $auction['Auction']['id']));?></div>
			<?php endif;?>
			
		
		
		<div class="thumb clearfix">
            	
			<?php if (1){?>
			<span class=" close_sticker close_sticker_<?php echo $appConfigurations['language']; ?>"></span>
			<div class="sold_for">
				<p><?php __('Sold for');?></p><strong class="bid-price"><?php echo $number->currency($auction['Auction']['price'],$appConfigurations['currency']); ?></strong>
			</div>
			
			<?php }?>
				<a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><span class="<?php if(!empty($auction['Auction']['penny'])):?> penny<?php endif;?><?php if(!empty($auction['Auction']['peak_only'])):?> peak_only<?php endif;?><?php if(!empty($auction['Auction']['beginner'])):?> beginner<?php endif;?> <?php if(!empty($auction['Auction']['nail_bitter'])):?> nail<?php endif;?><?php if(!empty($auction['Auction']['featured'])):?> featured<?php endif;?>"></span>
				<?php
				if(!empty($auction['Product']['Image']) && !empty($auction['Product']['Image'][0]['image'])) {
					echo $html->image('product_images/max/'.$auction['Product']['Image'][0]['image']);
				} else {
					echo $html->image('product_images/thumbs/no-image.gif');
				} 
				?>
				</a>
			</div> 
			
		<label class="highlight_timer">	
		<div class="time_left"><span><?php  __('Starts at') ?></span></div>
		<div class="timer_arrow price_arrow">
		<div id="pricear">
		<span class="arrow1 arrow_up ar1"></span>
		<span class="arrow1 arrow_down ar1"></span>			
		</div>
		</div>
	
		<span id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown" >
		<?php  __('Soon')  ?>
		</span>
	 
		</label>	
			
			
 
	
	
	<div class="row row_price">	
	<div class="padd_lr_20">
	<div class="left_auc_content f_l price_increase_left">
	<p class="price-increment price_inc">+<?php echo $number->currency($auction['Auction']['price_inc'], $appConfigurations['currency']);?>
	: <?php echo $auction['Auction']['price_inc_new'] ?>
</p>
	<p class="price_inc_text"><?php __('Price increase');?></p>
	 
	
	
	<label class="price_highlight">
	<span class="bid-price">
	<?php echo $number->currency($auction['Auction']['price'],$appConfigurations['currency']); ?></span>
	</label>
	

	
	<p class="current_bid"><?php __('Current bid');?></p>
	<p class="current_bid winner_bid"><?php __('Winner bid');?></p>
	
	
	</div>
	
		
	<div class="left_auc_content f_r text-right">
	
	<span class="valu_price">
	<span><?php __('Value');?></span>	
	<span><label><?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></label></span>	
	</span>
	<p class="min_price"><?php __('Min price');?>: <strong><?php echo $number->currency($auction['Product']['minimum_price'], $appConfigurations['currency']); ?></strong></p>

	</div>	
	</div>
	</div>
	
	<p class="auc_cat">
		<?php __('Categorie');?>:
		<strong><?php echo $number->prod_subs_cat_name($auction['Product']['rrp']); ?></strong>
 	</p>
	<p class="auc_cat padd_t_0">
		<?php __('Your current balance');?>:
		<strong class="bid-balance"> <?php echo $bidBalance ; ?></strong>
	</p>
	
		<div class="bid-msg bid-msg2">
			<div class="bid-message"></div>
			</div>
			
		    <div class="auc_btm_content blink">	
		
				 
			 
				 
			 
            <div class="bidbtn bid-button"><a href="/users/login" class="b-login-new"><span><?php __('Coming Soon');  ?></span></a></div>
				<div class="btn_view">
				 <a href="<?php echo AppController::AuctionLinkFlat($auction['Auction']['id'], $auction['Product']['title']); ?>"><?php __('View');?></a>
				</div>
           
			
			</div>
			

		<div class="crackers">
			<div class="before"></div>
			<div class="after"></div>
		</div>
		
	</li>
	<?php endforeach;?>
	
	


</ul>



 			<?php else: ?>
				<div class="align-center off_message"><p><?php __('There are no future auctions at the moment.');?></p></div>
			<?php endif; ?>
		<br class="clear_l">
		<div class="crumb_bar">
			<?php
			$html->addCrumb(__('Future Auctions', true), '/auctions/soon');
			echo $this->element('crumb_auction');
			?>
		</div>


            
</div>
       